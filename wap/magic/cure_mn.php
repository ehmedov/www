<?
if($db["battle"] && $db["hp"])
{
	if ($db["mana"]<$db["mana_all"])
	{
		switch ($mtype) 
		{
			case "mn100": $mana_add = 100;break;
			case "mn200": $mana_add = 200;break;
			case "mn500": $mana_add = 500;break;
			case "mn1000": $mana_add = 1000;break;
		}

		mysql_query("UPDATE inv SET iznos = iznos+1 WHERE id='".$id."'");
		$DAT = mysql_fetch_array(mysql_query("SELECT iznos,iznos_max FROM inv WHERE id = '".$id."'"));
		if($DAT["iznos"]==$DAT["iznos_max"])
		{
			mysql_query("UPDATE users SET slot".$slot."=0 WHERE login='".$login."'");
			mysql_query("DELETE FROM inv WHERE id = '".$id."'");
			$_SESSION["message"].="Заклинание <b>&laquo;".$name."&raquo;</b> полностью использован!";
		}

		$mana = $db["mana"];
		$mana_all = $db["mana_all"];
		
		if($mana_all - $mana<$mana_add)
		{
			$mana_add = $mana_all - $mana;
		}
		$mana_new = $mana + $mana_add;
		
		setMN($login,$mana_new,$mana_all);

	    $battle_id = $db["battle"];
	    $date = date("H:i");
	    $span=($db["battle_team"]==1?"p1":"p2");
	    $phrase = "<span class=date>$date</span> <span class=$span>$login</span> использовал свиток <b>&laquo;".$name."&raquo;</b> и восстановил ману <span class=hitted>+$mana_add</span> [$mana_new/$mana_all]<br>";
	    $t = time();
    	battle_log($battle_id, $phrase);
    }
}
?>