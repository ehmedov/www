<?
$login=$_SESSION["login"];
if($db["battle"] && !$db["hp"])
{
	$battle_id = $db["battle"];
    $date = date("H:i");
    $span=($db["battle_team"]==1?"p1":"p2");
    
	mysql_query("UPDATE inv SET iznos = iznos+1 WHERE id='".$id."'");
	$S_INV = mysql_query("SELECT iznos,iznos_max FROM inv WHERE id = '".$id."' limit 1");
	$DAT = mysql_fetch_array($S_INV);
	if($DAT["iznos"]==$DAT["iznos_max"])
	{
		mysql_query("UPDATE users SET slot".$slot."=0 WHERE login='".$login."'");
		mysql_query("DELETE FROM inv WHERE id = '".$id."'");
		say($login, "Заклинание <b>&laquo;".$name."&raquo;</b> полностью использован!", $login);
	}

	mysql_query("UPDATE battle_units SET hp=".(ceil($db["level"]/2+5)+$db["duxovnost"])." WHERE player='".$login."' and battle_id='".$battle_id."'");
	mysql_query("DELETE FROM hit_temp WHERE attack='".$db["login"]."'");
	mysql_query("DELETE FROM hit_temp WHERE defend='".$db["login"]."'");
	

	$mana_new = $db["mana"] - $mana;
	$mana_all = $db["mana_all"];
	setHP($login,$db["hp_all"],$db["hp_all"]);
	setMN($login,$mana_new,$mana_all);
	

    $phrase = "<span class=date>$date</span> <span class=$span>$login</span> внезапно исцелился...<br>";
    battle_log($battle_id, $phrase);
}
?>