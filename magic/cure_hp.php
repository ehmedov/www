<?
$login=$_SESSION['login'];
if($db["battle"] && $db["hp"])
{
	if ($db["hp"]<$db["hp_all"])
	{	
		switch ($mtype) 
		{
			case "hp10": $hp_add = 10;$duxa=0;break;
			case "hp50": $hp_add = 50;$duxa=0;break;
			case "hp100": $hp_add = 100;$duxa=0;break;
			case "hp200": $hp_add = 200;$duxa=0;break;
			case "hp500": $hp_add = 500;$duxa=1;break;
			case "hp1000": $hp_add = 1000;$duxa=2;break;
			case "hp_full": $hp_add = $db["hp_all"];$duxa=2;break;
		}
		$have_Duxa=mysql_fetch_Array(mysql_query("SELECT hp FROM `battle_units` WHERE player='".$db["login"]."' and battle_id=".$db["battle"]));
		if ($have_Duxa["hp"]>=$duxa)
		{	
			mysql_query("UPDATE `battle_units` SET hp=hp-$duxa WHERE player='".$db["login"]."' and battle_id=".$db["battle"]);
			mysql_query("UPDATE inv SET iznos = iznos+1 WHERE id='".$id."'");
			$DAT = mysql_fetch_array(mysql_query("SELECT iznos,iznos_max FROM inv WHERE id = '".$id."'"));
			if($DAT["iznos"]==$DAT["iznos_max"])
			{
				mysql_query("UPDATE users SET slot".$slot."=0 WHERE login='".$login."'");
				mysql_query("DELETE FROM inv WHERE id = '".$id."'");
				say($login, "Заклинание <b>&laquo;".$name."&raquo;</b> полностью использован!", $login);
			}

			$hp_now = $db["hp"];
			$hp_all = $db["hp_all"];
			if($hp_all - $hp_now<$hp_add)
			{
				$hp_add = $hp_all - $hp_now;
			}
			$hp_new = $hp_now + $hp_add;
			$mana_new = $db["mana"] - $mana;
			$mana_all = $db["mana_all"];
			setHP($login,$hp_new,$hp_all);
			setMN($login,$mana_new,$mana_all);

		    $battle_id = $db["battle"];
		    $date = date("H:i");
		    $span=($db["battle_team"]==1?"p1":"p2");
		    $phrase = "<span class=date>$date</span> <span class=$span>$login</span> использовал свиток <b>&laquo;".$name."&raquo;</b> и восстановил свое здоровье <span class=hitted>+$hp_add</span> [$hp_new/$hp_all]<br>";
		    $t = time();
		    battle_log($battle_id, $phrase);
		}
		else say($login, "Не хватает Уровень Духа. Требуется Уровень Духа: $duxa", $login);
	}
}
?>