<?
$login=$_SESSION["login"];
$weapons = array('axe','fail','knife','sword','spear','shot','staff','kostyl');
$shields=array('shield');
$bot_two_hands= false;
$bot_shield_hands= false;
$date = date("H:i");
if(in_array($db["hand_r_type"],$weapons) && in_array($db["hand_l_type"],$weapons))
{
	$bot_two_hands = true;
}
if (in_array($db["hand_l_type"],$shields))
{
	$bot_shield_hands = true;
}

if($db["battle"] && $db["hp"])
{
	$count_klon=mysql_fetch_array(mysql_query("SELECT count(*) FROM bot_temp WHERE battle_id=".(int)$db["battle"]."	and prototype='".$login."'"));
	if($db["battle_team"]==1){$span = "p1";$span2 = "p2";}else{$span = "p2";$span2 = "p1";}
	$b_id=$db["battle"];
	$bot_name=$login."(клон ".($count_klon[0]+1).")";
	mysql_query("INSERT INTO bot_temp(bot_name,hp,hp_all,battle_id,prototype,team,two_hands,shield_hands) VALUES('".$bot_name."','".$db["hp"]."','".$db["hp_all"]."','".$b_id."','".$login."','".$db["battle_team"]."','".$bot_two_hands."','".$bot_shield_hands."')");
	$phrase="<span class=date>$date</span> <span class=$span>".$login."</span> породил клона <b>".$bot_name."</b><BR>";
	battle_log($b_id, $phrase);
	mysql_query("UPDATE inv SET iznos = iznos+1 WHERE id='".$id."'");
	$DAT = mysql_fetch_array(mysql_query("SELECT iznos,iznos_max FROM inv WHERE id = '".$id."'"));
	if($DAT["iznos"]==$DAT["iznos_max"])
	{
		mysql_query("UPDATE users SET slot".$slot."=0 WHERE login='".$login."'");
		mysql_query("DELETE FROM inv WHERE id = '".$id."'");
		say($login, "Заклинание <b>&laquo;".$name."&raquo;</b> полностью использован!", $login);
	}

}
?>
