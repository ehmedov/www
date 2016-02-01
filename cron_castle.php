<?
include "conf.php";
include "functions.php";
$data = mysql_connect($base_name, $base_user, $base_pass);
mysql_select_db($db_name,$data);
$chat_base="/srv/www/meydan.az/public_html/chat/lovechat";

#$chat_base="C:\\AppServ\www\ever\chat\lovechat";

$getOwner = mysql_query("SELECT owner, name FROM castle_config LEFT JOIN clan on clan.name_short=castle_config.owner");
$check_clans = mysql_num_rows(mysql_query("SELECT * FROM castle_tournament ORDER BY stavka DESC"));

// если есть хозяин замка
if (mysql_num_rows($getOwner) == 1)
{
	echo "1.// Esli EST XOZAYN ZAMKA<br>";
	$FC = mysql_fetch_assoc($getOwner);
	$FirstClan = $FC['owner'];
	$FirstClanName = $FC['name'];
	if ($check_clans == 0)
	{
		// замок остается у хозяина
		echo "2.//ZAMOK OSTAYOTSA U XOZAYNA<br>";
		$mess = 'Внимание! Ханство <b>'.$FC['name'].'</b> удержал свой замок!';
		$mess = "sys<font color=#ff0000>$mess</font>endSys";
		$fopen_chat = fopen($chat_base,"a");
		fwrite ($fopen_chat,"::".time()."::sys_news::#FF0000::$mess::castle::mountown::\n");
		fclose ($fopen_chat);
	}
	else 
	{
		// выбираем 2й клан
		$getSecondClan = mysql_fetch_assoc(mysql_Query("SELECT * FROM castle_tournament LEFT JOIN clan on clan.name_short=castle_tournament.tribe ORDER BY stavka DESC LIMIT 1"));
		$SecondClan = $getSecondClan['tribe'];
		$SecondClanName = $getSecondClan['name'];
		mysql_query("DELETE FROM castle_tournament WHERE tribe = '".$getSecondClan['tribe']."' ");
		echo "3.//VIBIRAEM 2-OY KLAN<br>";
	}
}
// если замок ничейный
else 
{
	echo "4.// ESLI ZAMOK NICHEYNIY<br>";
	if ($check_clans == 0)
	{
		// заявок нет - делать нехуй
		echo "5.//ZAYAVOK NET<br>";
	}
	elseif ($check_clans == 1)
	{
		// один клан = автозахват замка
		$getFirstClan = mysql_fetch_assoc(mysql_query("SELECT * FROM castle_tournament LEFT JOIN clan on clan.name_short=castle_tournament.tribe ORDER BY stavka DESC LIMIT 1"));
		$FirstClan = $getFirstClan['tribe'];
		$FirstClanName = $getFirstClan['name'];
		mysql_query("DELETE FROM castle_tournament WHERE id = ".$getFirstClan['id']." ");
		mysql_query("INSERT INTO castle_config SET owner = '".$FirstClan."' ");
		echo "6.//ODIN KLAN - AVTOZAXVAT ZAMKA<br>";
		$mess = 'Внимание! Ханство <b>'.$getFirstClan["name"].'</b> стал владельцем замка!';
		$mess = "sys<font color=#ff0000>$mess</font>endSys";
		$fopen_chat = fopen($chat_base,"a");
		fwrite ($fopen_chat,"::".time()."::sys_news::#FF0000::$mess::castle::mountown::\n");
		fclose ($fopen_chat);
	}
	else 
	{
		// выбираем два замка для боя
		$getFirstClan = mysql_fetch_assoc(mysql_query("SELECT * FROM castle_tournament LEFT JOIN clan on clan.name_short=castle_tournament.tribe ORDER BY stavka DESC LIMIT 1"));
		$FirstClan = $getFirstClan['tribe'];
		$FirstClanName = $getFirstClan['name'];
		mysql_query("DELETE FROM castle_tournament WHERE tribe = '".$getFirstClan['tribe']."' ");
		
		$getSecondClan = mysql_fetch_assoc(mysql_query("SELECT * FROM castle_tournament LEFT JOIN clan on clan.name_short=castle_tournament.tribe ORDER BY stavka DESC LIMIT 1"));
		$SecondClan = $getSecondClan['tribe'];
		$SecondClanName = $getSecondClan['name'];
		mysql_query("DELETE FROM castle_tournament WHERE tribe = '".$getSecondClan['tribe']."' ");
		
		echo "7.//VIBIRAYEM 2-KLANA DLYA BOYA ".$FirstClanName." - ".$SecondClanName."<br>";
	}
}

$getMoney = mysql_query("SELECT * FROM castle_tournament LEFT JOIN clan on clan.name_short=castle_tournament.tribe");
while ($returnMoney = mysql_fetch_assoc($getMoney))
{
	echo "8.//VOZVRAT BABLA KLANU ".$returnMoney['name']."<br>";
	mysql_query("UPDATE users SET  money = money + ".$returnMoney['stavka']." WHERE clan_short = '".$returnMoney['tribe']."' AND glava = 1 LIMIT 1");
}
mysql_query("TRUNCATE TABLE `castle_tournament`");

if (isset($SecondClan))
{
	echo "9.//NACHINAYEM BITVU<br>";
	// начинаем битву	
	// выбираем игроков онлайн
	#$getRightTeam = mysql_query("SELECT users.login, users.remote_ip FROM users, online WHERE users.clan_short = '".$FirstClan."'  AND online.room = 'castle' AND users.login = online.login");
	#$getLeftTeam =  mysql_query("SELECT users.login, users.remote_ip FROM users, online WHERE users.clan_short = '".$SecondClan."' AND online.room = 'castle' AND users.login = online.login");

	$getRightTeam = mysql_query("SELECT users.id, users.login, users.remote_ip FROM online LEFT JOIN users on users.login=online.login WHERE online.room = 'castle' and users.clan_short = '".$FirstClan."'");
	$getLeftTeam =  mysql_query("SELECT users.id, users.login, users.remote_ip FROM online LEFT JOIN users on users.login=online.login WHERE online.room = 'castle' and users.clan_short = '".$SecondClan."'");

	if (mysql_num_rows($getRightTeam) == 0)
	{
		mysql_query("TRUNCATE TABLE `castle_config`");
		mysql_query("INSERT INTO castle_config SET owner = '".$SecondClan."' ");
		echo "10.//XANSTVA ".$SecondClanName." STAL VLADELCHOM ZAMKA!";
		$mess = 'Внимание! Ханство <b>'.$SecondClanName.'</b> стал владельцем замка!';
		$mess = "sys<font color=#ff0000>$mess</font>endSys";
		$fopen_chat = fopen($chat_base,"a");
		fwrite ($fopen_chat,"::".time()."::sys_news::#FF0000::$mess::castle::mountown::\n");
		fclose ($fopen_chat);
	}
	else if (mysql_num_rows($getLeftTeam) == 0)
	{
		mysql_query("TRUNCATE TABLE `castle_config`");
		mysql_query("INSERT INTO castle_config SET owner = '".$FirstClan."' ");
		echo "11.//XANSTVA ".$FirstClanName." STAL VLADELCHOM ZAMKA!";
		$mess = 'Внимание! Ханство <b>'.$FirstClanName.'</b> стал владельцем замка!';
		$mess = "sys<font color=#ff0000>$mess</font>endSys";
		$fopen_chat = fopen($chat_base,"a");
		fwrite ($fopen_chat,"::".time()."::sys_news::#FF0000::$mess::castle::mountown::\n");
		fclose ($fopen_chat);
	}
	else 
	{
		$mess = 'Внимание! Началась Битва за Башню между Ханствами <b>'.$FirstClanName.'</b> и <b>'.$SecondClanName.'</b>';
		$mess = "sys<font color=#ff0000>$mess</font>endSys";
		$fopen_chat = fopen($chat_base,"a");
		fwrite ($fopen_chat,"::".time()."::sys_news::#FF0000::$mess::castle::mountown::\n");
		fclose ($fopen_chat);
		echo "12.//INICHILIRUYEM BITVU $FirstClanName - $SecondClanName<br>";
		
		$timeout=3;
		$creator_id=100;
		$battle_type=13;
		mysql_query("INSERT INTO zayavka(status, type, timeout, creator) VALUES('3', '".$battle_type."', '".$timeout."', '".$creator_id."')");
		mysql_query("INSERT INTO battles(type, creator_id, lasthit) VALUES('".$battle_type."', '".$creator_id."', '".(time()+60*$timeout)."')");
		$b_id=mysql_insert_id();
		
		while($gRightTeam = mysql_fetch_array($getRightTeam))
		{
			$opp1=$gRightTeam["login"];
			mysql_query("UPDATE users SET zayavka=1, battle='".$b_id."', battle_team='1', battle_pos='".$creator_id."' WHERE login='".$opp1."'");
			mysql_query("INSERT INTO teams(player, team, ip, battle_id) VALUES('".$opp1."', '1', '".$gRightTeam["remote_ip"]."', '".$creator_id."')");
			mysql_query("INSERT INTO battle_units(battle_id, player, hp) VALUES('".$b_id."', '".$opp1."', 15)");
			echo "13.//BOYCHI ZANSTVA ".$FirstClanName." ".$opp1." [".$gRightTeam["id"]."] <br>";

		}
		while($gLeftTeam = mysql_fetch_array($getLeftTeam))
		{
			$opp2=$gLeftTeam["login"];
			mysql_query("UPDATE users SET zayavka=1, battle='".$b_id."', battle_team='2', battle_pos='".$creator_id."' WHERE login='".$opp2."'");
			mysql_query("INSERT INTO teams(player, team, ip, battle_id) VALUES('".$opp2."','2','".$gLeftTeam["remote_ip"]."','".$creator_id."')");
			mysql_query("INSERT INTO battle_units(battle_id, player, hp) VALUES('".$b_id."', '".$opp2."', 15)");
			echo "14.//BOYCHI ZANSTVA ".$SecondClanName." ".$opp2." [".$gLeftTeam["id"]."] <br>";
		}
		$comment = "Часы показывали <span class='date'>".date("d-m-Y H:i")."</span>, когда Ханство <b>".$FirstClanName."</b> и Ханство <b>".$SecondClanName."</b> бросили вызов друг другу.<hr>";
		battle_log($b_id, $comment);
		// cоздаем бой
		mysql_query("INSERT INTO castle_log (defender,atacker,stavka,battle_time,battle_log) VALUES ('".$FirstClan."','".$SecondClan."','".$getSecondClan["stavka"]."','".time()."','".$b_id."')");
		//---------------
		echo "15. VSE OK! Bitvar ".$log_file."<br>";
	}
}