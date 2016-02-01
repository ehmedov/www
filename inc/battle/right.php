<?
	$protivnik=$opponent;
	$bot = 0;
	$BOT_D = mysql_fetch_array(mysql_query("SELECT * FROM bot_temp WHERE battle_id='".$bid."' and bot_name='".$protivnik."'"));
	if ($BOT_D)
	{
		$bot = 1;
		$opponent=$BOT_D["prototype"];
	}
	$results=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE login='".$opponent."'"));
	if($bot == 0)
	{
		showHPbattle($results);
	}
	else if($bot == 1)
	{
		showHPBot($BOT_D);
	}
	if ($P_HDATA["type"]!=55)
	{	
		if ($BOT_D["zver"]==0)showPlayer($results);
		else if ($BOT_D["zver"]==1)showZver($BOT_D["prototype"]);
	}
	else
	{
		echo "<center>";
		if (str_replace("Гигантская крыса","",$BOT_D["bot_name"])!=$BOT_D["bot_name"]) echo "<img src='img/obraz/les/krisa.jpg'>";
		else if (str_replace("Дикий Циклоп","",$BOT_D["bot_name"])!=$BOT_D["bot_name"]) echo "<img src='img/obraz/les/ciklop.jpg'>";
		else if (str_replace("Гигантский Червь","",$BOT_D["bot_name"])!=$BOT_D["bot_name"]) echo "<img src='img/obraz/les/cerv.jpg'>";
		else if (str_replace("Дерево убийца","",$BOT_D["bot_name"])!=$BOT_D["bot_name"])echo "<img src='img/obraz/les/derevo.jpg'>";
		else if (str_replace("Трол","",$BOT_D["bot_name"])!=$BOT_D["bot_name"])echo "<img src='img/obraz/les/trol.jpg'>";
		else if (str_replace("Лев","",$BOT_D["bot_name"])!=$BOT_D["bot_name"])echo "<img src='img/obraz/les/lev.jpg'>";
		else if (str_replace("Разбойник","",$BOT_D["bot_name"])!=$BOT_D["bot_name"])echo "<img src='img/obraz/les/razboynik.jpg'>";
		echo "</center>";
	}
	

?>