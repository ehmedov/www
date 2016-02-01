<?
include "conf.php";
$data = mysql_connect($base_name, $base_user, $base_pass);
mysql_select_db($db_name,$data);
//----------------------------------------------------------------
$DEL_OLD_SQL = mysql_query("SELECT * FROM `zayavka`");
while($OLD_DATA = mysql_fetch_array($DEL_OLD_SQL))
{
	$SEEK_ONLINE  = mysql_fetch_array(mysql_query("SELECT count(*) FROM online LEFT JOIN users ON users.login=online.login WHERE users.id=".$OLD_DATA["creator"]));
	if(!$SEEK_ONLINE[0])
	{
		$SEL=mysql_fetch_array(mysql_query("SELECT * FROM battles WHERE creator_id='".$OLD_DATA["creator"]."' ORDER BY date DESC LIMIT 1"));
		$players=mysql_query("SELECT player FROM teams WHERE battle_id='".$OLD_DATA["creator"]."'");
		while ($pl=mysql_fetch_array($players))
		{
			mysql_query("UPDATE users SET zayavka='0', battle='0',battle_opponent='', battle_pos='', battle_team='', zver_on=0 WHERE login='".$pl["player"]."'");
		}
		mysql_query("DELETE FROM `zayavka` WHERE id = '".$OLD_DATA["id"]."'");
		mysql_query("DELETE FROM `teams` WHERE battle_id = '".$OLD_DATA["creator"]."'");
		mysql_query("DELETE FROM `hit_temp` WHERE battle_id='".$SEL["id"]."'");
		mysql_query("DELETE FROM `battles` WHERE id='".$SEL["id"]."'");
		mysql_query("DELETE FROM `bot_temp` WHERE battle_id='".$SEL["id"]."'");
		mysql_query("DELETE FROM `battle_units` WHERE battle_id='".$SEL["id"]."'");
		mysql_query("DELETE FROM `person_on` WHERE battle_id='".$SEL["id"]."'");
	}
}

$tm=time()-1*24*3600;
mysql_query("DELETE FROM roul_wins WHERE wintime<'".$tm."'");   
mysql_query("DELETE FROM roul_num WHERE wintime<'".$tm."'");
mysql_query("TRUNCATE TABLE `daily_kwest`");
mysql_query("UPDATE abils set c_iznos=0");

?>