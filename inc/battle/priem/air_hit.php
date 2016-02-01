<?
if($db["battle"] && $db["hp"] && $db["battle_opponent"]!="")
{
	if($db["battle_team"]==1){$span = "p1";$span2 = "p2";}else{$span = "p2";$span2 = "p1";}
	switch ($is_pr["type"]) 
	{
		case "air8": $damage_min=1;$damage_max=54;break;
		case "air9": $damage_min=1;$damage_max=66;break;
		case "air10":$damage_min=1;$damage_max=79;break;
	}

	$login=$_SESSION["login"];
	$creator = $db["battle_pos"];
	$b_id=$db["battle"];
	$date = date("H:i");
	$enemy_team=($db["battle_team"]==1?'2':'1');
	$victims=array();
	$hited_targets=array();
	
	$opponents = mysql_query("SELECT player,power,id,hp,hp_all,protect_fire,protect_water,protect_air,protect_earth,protect_svet,protect_tma,protect_gray,protect_mag FROM teams as tem LEFT JOIN users us on us.login=tem.player WHERE battle_id = '".$creator."' and hp>0 and team=$enemy_team");
	if (mysql_num_rows($opponents))
	{
    	while ($opponent=mysql_fetch_array($opponents)) 
    	{
      		$user_turn=mysql_fetch_array(mysql_query("SELECT * FROM hit_temp WHERE attack='".$opponent["player"]."' AND defend='".$login."'"));
      		if (!$user_turn) 
      		{
      			$victims[] = array("opponent"=>$opponent["player"], "power"=>$opponent["power"], "id"=>$opponent["id"], "types"=>"human", "hp"=>$opponent["hp"], "hp_all"=>$opponent["hp_all"], "protect_fire"=>$opponent["protect_fire"], "protect_water"=>$opponent["protect_water"], "protect_air"=>$opponent["protect_air"], "protect_earth"=>$opponent["protect_earth"], "protect_svet"=>$opponent["protect_svet"], "protect_tma"=>$opponent["protect_tma"], "protect_gray"=>$opponent["protect_gray"], "protect_mag"=>$opponent["protect_mag"]);
      		}
    	}
	}
	$BLD_ = mysql_query("SELECT bot_temp.bot_name, users.id,users.power, bot_temp.hp, bot_temp.hp_all,protect_fire,protect_water,protect_air,protect_earth,protect_svet,protect_tma,protect_gray,protect_mag FROM bot_temp LEFT JOIN users on users.login=bot_temp.prototype WHERE battle_id='".$b_id."' and bot_temp.hp>0 and team=$enemy_team");
	if (mysql_num_rows($BLD_))
	{	
		while ($BLD=mysql_fetch_array($BLD_))
		{
			$victims[] = array("opponent"=>$BLD["bot_name"], "power"=>$BLD["power"], "id"=>$BLD["id"], "types"=>"bot", "hp"=>$BLD["hp"], "hp_all"=>$BLD["hp_all"],"protect_fire"=>$BLD["protect_fire"], "protect_water"=>$BLD["protect_water"], "protect_air"=>$BLD["protect_air"], "protect_earth"=>$BLD["protect_earth"], "protect_svet"=>$BLD["protect_svet"], "protect_tma"=>$BLD["protect_tma"], "protect_gray"=>$BLD["protect_gray"], "protect_mag"=>$BLD["protect_mag"]);
		}
	}
	$n=rand(1,7);//kolichestvo udarov
	$n2=count($victims);
	if($n2<$n) $n=$n2;
	$i=$ret['uron']=0;
	$phrase='';
	
	$pers_uron=calc_mag($db,"air_magic");
	$f=$pers_uron + $damage_min;
	$g=$pers_uron + $damage_max;
	shuffle($victims);

	for($i=0;$i<$n;$i++) 
	{
		effects($victims[$i]["id"],$effect);
		$def_priem=array();
		$d_pr=mysql_query("SELECT pr_name FROM person_on WHERE id_person=".$victims[$i]["id"]." and battle_id=$b_id and pr_active=2 and pr_cur_uses>0");
		while($defend_priem=mysql_fetch_array($d_pr))
		{
			$def_priem[]=$defend_priem["pr_name"];
		}
		$uron=mt_rand($f, $g);
		if ($victims[$i]["power"]>=125) {$def_protect_mag=150;}
		else if ($victims[$i]["power"]>=100) {$def_protect_mag=100;}
		else if ($victims[$i]["power"]>=75)  {$def_protect_mag=75;}
		else if ($victims[$i]["power"]>=50)  {$def_protect_mag=50;}
		else if ($victims[$i]["power"]>=25)  {$def_protect_mag=25;}
		$victims[$i]["protect_mag"]=$victims[$i]["protect_mag"]+$victims[$i]["power"]*1.5+$def_protect_mag;
		$uron=$uron-($victims[$i]["protect_air"]+$effect["protect_air"])-($victims[$i]["protect_mag"]+$effect["add_mg_bron"])/4;
		if ($uron<=0)$uron=3*$db["level"];
		if (in_Array("protair",$def_priem))
		{
			$uron=$uron/2;
			mysql_query("UPDATE person_on SET pr_cur_uses=pr_cur_uses-1 WHERE id_person='".$victims[$i]["id"]."' and battle_id=".$b_id." and pr_name='protair'");
			$my_res=mysql_fetch_array(mysql_query("SELECT pr_cur_uses FROM person_on WHERE id_person=".$victims[$i]["id"]." and battle_id=".$b_id." and pr_name='protair'"));
			if ($my_res["pr_cur_uses"]==1)
			mysql_query("UPDATE person_on SET pr_active=1 WHERE id_person='".$victims[$i]["id"]."' and battle_id=".$b_id." and pr_name='protair'");
		}
		if (in_Array("block",$def_priem))
		{
			$uron=$uron/2;
			$phrase.= "<span class=date>$date</span> <span class=$span2>$opponenti</span> понял что его спасение это прием <b>Активная защита</b>.<br>";
			mysql_query("UPDATE person_on SET pr_active=1 WHERE id_person='".$victims[$i]["id"]."' and battle_id=".$b_id." and pr_name='block'");
		}
		if (in_Array("fullshield",$def_priem))
		{
			$uron=1;
			$phrase.= "<span class=date>$date</span> <span class=$span2>$opponenti</span> понял что его спасение это прием <b>Полная защита</b>.<br>";
			mysql_query("UPDATE person_on SET pr_active=1 WHERE id_person='".$victims[$i]["id"]."' and battle_id=".$b_id." and pr_name='fullshield'");
		}
		$uron=ceil($uron);
		$hp_new=$victims[$i]["hp"]-$uron;
		$opponenti=$victims[$i]["opponent"];
		$hited_targets[]=$opponenti;
	    if ($hp_new <= 0 )
	    {
	    	$hp_new=0;
	    	$phrase.= "<span class=sysdate>$date</span> <B>".$opponenti." убит</B><BR>";
	    }		
		if ($victims[$i]["types"]=="human")
		{
			mysql_query("UPDATE users SET hp='".$hp_new."' WHERE login='".$opponenti."'");
		}
		else if ($victims[$i]["types"]=="bot")
		{
			mysql_query("UPDATE bot_temp SET hp='".$hp_new."' WHERE battle_id='".$b_id."' AND bot_name='".$opponenti."'");
		}
		$phrase.="<span class=date>$date</span> <span class=$span>".$login."</span> направил ужасающий <span class=magic>".$is_pr["name"]."</span> на <span class=$span2>".$opponenti."</span>, <span class=hitted>-$uron</span> [".$hp_new."/".$victims[$i]["hp_all"]."]<BR>";
		$ret['uron']+=$uron;	
	}
	mysql_query("UPDATE teams SET hitted=hitted+".$ret['uron']." WHERE player='".$login."'");
	mysql_query("UPDATE battle_units SET hit=hit-".(int)$is_pr["hit"].",krit=krit-".(int)$is_pr["krit"].",uvarot=uvarot-".(int)$is_pr["uvarot"].",block=block-".(int)$is_pr["block"].",hp=hp-".(int)$is_pr["hp"].",counter=counter-".(int)$is_pr["all_hit"]." WHERE player='".$login."' and battle_id='".$b_id."'");
	
	mysql_query("UPDATE person_on SET pr_active=1,pr_wait_for=".$is_pr["wait"]." WHERE id_person='".$db["id"]."' and pr_name='air8' and battle_id='".$b_id."'");
	mysql_query("UPDATE person_on SET pr_active=1,pr_wait_for=".$is_pr["wait"]." WHERE id_person='".$db["id"]."' and pr_name='air9' and battle_id='".$b_id."'");
	mysql_query("UPDATE person_on SET pr_active=1,pr_wait_for=".$is_pr["wait"]." WHERE id_person='".$db["id"]."' and pr_name='air10' and battle_id='".$b_id."'");
	
	battle_log($b_id, $phrase);
}
?>