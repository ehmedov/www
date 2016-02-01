<?
session_start();	
header("Content-Type: text/html; charset=windows-1251");
header("Cache-Control: no-cache, must-revalidate"); // говорим браузеру что-бы он не кешировал эту страницу
header("Pragma: no-cache");

if($_SESSION["my_battle"]!=0)
{
	ob_start("ob_gzhandler");
	include ("conf.php");
	include ("functions.php");
	$login=$_SESSION["login"];

	$data = mysql_connect($base_name, $base_user, $base_pass) or die('Не получается подключиться. Проверьте имя сервера, имя пользователя и пароль!');
	mysql_select_db($db_name) or die('Ошибка входа в базу данных');

	$bat_id=$_SESSION["my_battle"];
	$creator=$_SESSION["my_creator"];
	$bot=mysql_query("SELECT * FROM bot_temp WHERE battle_id='".$bat_id."' and hp>0");
	while ($bots=mysql_fetch_array($bot))
	{
		if ($bots["team"]==1)$enemy_teams=2; else if ($bots["team"]==2)$enemy_teams=1;
		
		$sql=mysql_query("SELECT player FROM teams LEFT JOIN users on users.login=teams.player WHERE teams.team=".$enemy_teams." and teams.battle_id=".$creator." and users.hp>0");
		while ($teams=mysql_fetch_array($sql))
		{
			$hits=mysql_fetch_array(mysql_query("SELECT count(*) FROM hit_temp WHERE attack='".$teams["player"]."' and defend='".$bots["bot_name"]."' and battle_id=".$bat_id));
			if (!$hits[0])
			{
				$block = rand(1,5);
				if($bots["bot_name"]=="Тень")$block = 0;
				$hit1  = rand(1,5);$hit2  = rand(1,5);
				hit($bots["bot_name"],$teams["player"],$hit1,$hit2,$hit3,$block,$bat_id,1);
			}
		}
		$sql_bot=mysql_query("SELECT bot_name FROM bot_temp WHERE team=".$enemy_teams." and battle_id=".$bat_id." and hp>0");
		while ($teams_bot=mysql_fetch_array($sql_bot))
		{
			$hits_bot=mysql_fetch_array(mysql_query("SELECT count(*) FROM hit_temp WHERE attack='".$teams_bot["bot_name"]."' and defend='".$bots["bot_name"]."' and battle_id=".$bat_id));
			if (!$hits_bot[0])
			{
				$hit1  = rand(1,5);$hit2  = rand(1,5);$block = rand(1,5);
				hit($bots["bot_name"],$teams_bot["bot_name"],$hit1,$hit2,$hit3,$block,$bat_id,1);
			}
		}
	}
	if($_SESSION["battle_ref"] == 0)
	{
		$_SESSION["battle_ref"] = 1;
		echo "battle";
	}
	mysql_close();
}
?>