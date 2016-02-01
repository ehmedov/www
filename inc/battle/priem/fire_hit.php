<?
if($db["battle"] && $db["hp"] && $db["battle_opponent"]!="")
{
	if($db["battle_team"]==1){$span = "p1";$span2 = "p2";}else{$span = "p2";$span2 = "p1";}
	switch ($is_pr["type"]) 
	{
		case "fire8": $damage_min=40;$damage_max=43;break;
		case "fire9": $damage_min=50;$damage_max=51;break;
		case "fire10":$damage_min=60;$damage_max=62;break;
	}
	$login=$_SESSION["login"];

	$select_target=htmlspecialchars(addslashes($_POST["target"]));
	$target=$db["battle_opponent"];
	$enemy_team=($db["battle_team"]==1?'2':'1');
	
	$b_id = $db["battle"];
	$phrase ="";
	
	$mbot_a = mysql_fetch_array(mysql_query("SELECT users.id, users.power, users.protect_fire, users.protect_mag, bot_temp.hp, bot_temp.hp_all FROM `bot_temp` LEFT JOIN users on users.login=bot_temp.prototype WHERE battle_id='".$b_id."' AND bot_name='".$select_target."'"));
	$res=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE login='".$select_target."' and battle=".$b_id." and battle_team=".$enemy_team));
	if ($res){$human=1;}else{$human=0;}
	if ($mbot_a){$target_bot=1;}else {$target_bot=0;}
	if ($human==1 || $target_bot==1)
	{	
		$date = date("H:i");
		if($target_bot!=1)
		{
		    $hp_now = $res["hp"];
			$hp_all = $res["hp_all"];
			$users_id=$res["id"];
			$protect_fire=$res["protect_fire"];
			$protect_mag=$res["protect_mag"];
			$power=$res["power"];
		}
		else
		{
		    $hp_now = $mbot_a["hp"];
			$hp_all = $mbot_a["hp_all"];
			$users_id=$mbot_a["id"];
			$protect_fire=$mbot_a["protect_fire"];
			$protect_mag=$mbot_a["protect_mag"];
			$power=$mbot_a["power"]; 
		}
		if ($power>=125) {$def_protect_mag=150;}
		else if ($power>=100) {$def_protect_mag=100;}
		else if ($power>=75)  {$def_protect_mag=75;}
		else if ($power>=50)  {$def_protect_mag=50;}
		else if ($power>=25)  {$def_protect_mag=25;}
		$protect_mag=$protect_mag+$power*1.5+$def_protect_mag;
		effects($users_id,$effect);
		$def_priem=array();
		$d_pr=mysql_query("SELECT pr_name FROM person_on WHERE id_person=".$users_id." and battle_id=$b_id and pr_active=2 and pr_cur_uses>0");
		while($defend_priem=mysql_fetch_array($d_pr))
		{
			$def_priem[]=$defend_priem["pr_name"];
		}

		if ($hp_now>0)
		{
			$pers_uron=calc_mag($db,"fire_magic");
			$uron =$pers_uron+rand($damage_min,$damage_max);
			$uron=$uron-($protect_fire+$effect["protect_fire"])-($protect_mag+$effect["add_mg_bron"])/4;
			if ($uron<=0)$uron=3*$db["level"];
			
			if (in_Array("protfire",$def_priem))
			{
				$uron=$uron/2;
				mysql_query("UPDATE person_on SET pr_cur_uses=pr_cur_uses-1 WHERE id_person='".$users_id."' and battle_id=".$b_id." and pr_name='protfire'");
				$my_res=mysql_fetch_array(mysql_query("SELECT pr_cur_uses FROM person_on WHERE id_person=".$users_id." and battle_id=".$b_id." and pr_name='protfire'"));
				if ($my_res["pr_cur_uses"]==1)
				mysql_query("UPDATE person_on SET pr_active=1 WHERE id_person='".$users_id."' and battle_id=".$b_id." and pr_name='protfire'");
			}
			if (in_Array("block",$def_priem))
			{
				$uron=$uron/2;
				$phrase.= "<span class=date>$date</span> <span class=$span2>$select_target</span> понял что его спасение это прием <b>Активная защита</b>.<br>";
				mysql_query("UPDATE person_on SET pr_active=1 WHERE id_person='".$users_id."' and battle_id=".$b_id." and pr_name='block'");
			}
			if (in_Array("fullshield",$def_priem))
			{
				$uron=1;
				$phrase.= "<span class=date>$date</span> <span class=$span2>$select_target</span> понял что его спасение это прием <b>Полная защита</b>.<br>";
				mysql_query("UPDATE person_on SET pr_active=1 WHERE id_person='".users_id."' and battle_id=".$b_id." and pr_name='fullshield'");
			}
			$uron=ceil($uron);
			$hp_new = $hp_now - $uron;
		    if ($hp_new <= 0 )
		    {
		    	$hp_new=0;
		    	$phrase.= "<span class=sysdate>$date</span> <B>".$select_target." убит</B><BR>";
		    }
			
		    if($target_bot!=1)
		    {
		    	mysql_query("UPDATE users SET hp='".$hp_new."' WHERE login='".$select_target."'");
		    }
		    else
		    {
		    	mysql_query("UPDATE bot_temp SET hp='".$hp_new."' WHERE battle_id='".$b_id."' AND bot_name='".$select_target."'");
		    }
			mysql_query("UPDATE teams SET hitted=hitted+$uron WHERE player='".$login."'");
			mysql_query("UPDATE battle_units SET hit=hit-".(int)$is_pr["hit"].",krit=krit-".(int)$is_pr["krit"].",uvarot=uvarot-".(int)$is_pr["uvarot"].",block=block-".(int)$is_pr["block"].",hp=hp-".(int)$is_pr["hp"].",counter=counter-".(int)$is_pr["all_hit"]." WHERE player='".$login."' and battle_id='".$b_id."'");
			mysql_query("UPDATE person_on SET pr_active=1,pr_wait_for=".$is_pr["wait"]." WHERE id_person='".$db["id"]."' and pr_name='fire8' and battle_id='".$b_id."'");
			mysql_query("UPDATE person_on SET pr_active=1,pr_wait_for=".$is_pr["wait"]." WHERE id_person='".$db["id"]."' and pr_name='fire9' and battle_id='".$b_id."'");
			mysql_query("UPDATE person_on SET pr_active=1,pr_wait_for=".$is_pr["wait"]." WHERE id_person='".$db["id"]."' and pr_name='fire10' and battle_id='".$b_id."'");

			
			$phrase.="<span class=date>$date</span> <span class=$span>".$login."</span> направил ужасающий <span class=magic>".$is_pr["name"]."</span> на <span class=$span2>$select_target</span> на <span class=hitted>-$uron</span> [$hp_new/$hp_all]<BR>";
			battle_log($b_id, $phrase);
		}
	}
}
?>