<?
if($db["battle"] && $db["hp"])
{
	switch ($mtype) 
	{
		case "block": 	$taktik_type="block";	break;
		case "uvarot": 	$taktik_type="uvarot";	break;
		case "krit": 	$taktik_type="krit";	break;
		case "hit": 	$taktik_type="hit";		break;
		case "parry": 	$taktik_type="parry";	break;
	}
	$login=$_SESSION['login'];
	$battle_id = $db["battle"];
	$span=($db["battle_team"]==1?"p1":"p2");
	$date = date("H:i");
	$taktika=5;

	$paltar=mysql_fetch_array(mysql_query("SELECT * FROM battle_units WHERE player='".$login."'"));
	if ($paltar)
	{
		mysql_query("UPDATE battle_units SET $taktik_type=$taktik_type+$taktika WHERE player='".$login."'");
		mysql_query("UPDATE inv SET iznos = iznos+1 WHERE id='".$id."'");
		$DAT = mysql_fetch_array(mysql_query("SELECT iznos,iznos_max FROM inv WHERE id = '".$id."' limit 1"));
		if($DAT["iznos"]==$DAT["iznos_max"])
		{
			mysql_query("UPDATE users SET slot".$slot."=0 WHERE login='".$login."'");
			mysql_query("DELETE FROM inv WHERE id = '".$id."'");
			say($login, "Заклинание <b>&laquo;".$name."&raquo;</b> полностью использован!", $login);
		}
	    $phrase = "<span class=date>".$date."</span> <span class=$span>".$login."</span> использовал свиток <b>&laquo;".$name."&raquo;</b><br>";
	    battle_log($battle_id, $phrase);
	}
}
?>