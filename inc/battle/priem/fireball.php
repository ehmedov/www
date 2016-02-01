<?
if($db["battle"] && $db["hp"] && $db["battle_opponent"]!="")
{
	if($db["battle_team"]==1){$span = "p1";$span2 = "p2";}else{$span = "p2";$span2 = "p1";}
			
	switch ($is_pr["type"]) 
	{
		case "fireball4":$damage_min=25;$damage_max=27;break;
		case "fireball5":$damage_min=30;$damage_max=33;break;
		case "fireball6":$damage_min=35;$damage_max=39;break;
		case "fireball7": $damage_min=45;$damage_max=47;break;
		case "fireball8": $damage_min=55;$damage_max=58;break;
		case "fireball9": $damage_min=65;$damage_max=69;break;
		case "fireball10":$damage_min=80;$damage_max=83;break;
	}
	$login=$_SESSION["login"];
	$select_target=htmlspecialchars(addslashes($_POST["target"]));
	$target=$db["battle_opponent"];
	$b_id = $db["battle"];
	$phrase ="";
	switch ($db["battle_team"])
	{
		case 1: $enemy_team=2; break;
		case 2: $enemy_team=1; break;
	}

	$mbot = mysql_query("SELECT users.id,users.power, bot_temp.hp, bot_temp.hp_all,protect_fire,protect_mag FROM `bot_temp` LEFT JOIN users on users.login=bot_temp.prototype WHERE battle_id='".$b_id."' AND bot_name='".$select_target."' and team=".$enemy_team);
	$mbot_a = mysql_fetch_array($mbot);
	if( $mbot_a){$target_bot=1;}else {$target_bot=0;}

	$q=mysql_query("SELECT * FROM users WHERE login='".$select_target."' and battle=".$b_id." and battle_team=".$enemy_team);
	$res=mysql_fetch_array($q);
	if ($res){$human=1;}else{$human=0;}

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
				mysql_query("UPDATE person_on SET pr_active=1 WHERE id_person='".$users_id."' and battle_id=".$b_id." and pr_name='fullshield'");
			}
			if ($uron<=0)$uron=3*$db["level"];

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
			mysql_query("UPDATE battle_units SET counter=counter+1 WHERE battle_id=$b_id and player='".$login."'");

			$phrase.="<span class=date>$date</span> <span class=$span>".$login."</span> направил ужасающий <span class=magic>".$is_pr["name"]."</span> на <span class=$span2>$select_target</span> на <span class=hitted>-$uron</span> [$hp_new/$hp_all]<BR>";
			battle_log($b_id, $phrase);
			hit($login,$target,0,0,0,0,$b_id,0);
		}
	}
}
?>