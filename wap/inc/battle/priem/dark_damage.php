<?
if($db["battle"] && $db["hp"] && $db["battle_opponent"]!="")
{
	$damage_min=$db["level"]*10;$damage_max=$db["level"]*10;
	
	$login=$_SESSION["login"];
	$select_target=$db["battle_opponent"];
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

		if ($hp_now>0)
		{
			$pers_uron=calc_mag($db,"tma_magic");
			$uron =$pers_uron+rand($damage_min,$damage_max);
			$uron=$uron-$protect_fire-($protect_mag+$effect["add_mg_bron"])/4;
			if ($uron<=0)$uron=3*$db["level"];
			$uron=ceil($uron);
			$add_me_hp=ceil($uron/2);
			$hp_new = $hp_now - $uron;
		    if ($hp_new <= 0 )
		    {
		    	$hp_new=0;
		    	$phrase= "<span class=sysdate>$date</span> <B>".$select_target." убит</B><BR>";
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
		 	
		 	if($db["hp_all"] - $db["hp"]<$add_me_hp)
			{
				$add_me_hp = $db["hp_all"] - $db["hp"];
			}
			$hp_new = $db["hp"] + $add_me_hp;
			setHP($login,$hp_new,$db["hp_all"]);
			
			if($db["battle_team"]==1){$span = "p1";$span2 = "p2";}else{$span = "p2";$span2 = "p1";}
			
			$phrase="<span class=date>$date</span> <span class=$span>".$login."</span> направил ужасающий <span class=magic>".$is_pr["name"]."</span> на <span class=$span2>$select_target</span> на <span class=hitted>-$uron</span> [$hp_new/$hp_all] и восстановил здоровье на <b style='color:green'>+$add_me_hp</b> [".$hp_new."/".$db["hp_all"]."]<BR>";

			battle_log($b_id, $phrase);
			hit($login,$target,0,0,0,0,$b_id,0);
		}
	}
}
?>