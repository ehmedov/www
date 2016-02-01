<?
include "conf.php";
$data = mysql_connect($base_name, $base_user, $base_pass);
mysql_select_db($db_name,$data);
$sql=mysql_query("SELECT * FROM zayavka_bot WHERE status=1");
if (mysql_num_rows($sql))
{
	while ($groups=mysql_fetch_array($sql))
	{
		$sql_teams=mysql_query("SELECT * FROM zayavka_teams WHERE battle_id=".$groups["id"]);
		while ($res=mysql_fetch_array($sql_teams))
		{	
			mysql_query("UPDATE users SET zayava=0 WHERE login='".$res["player"]."'");
		}
		mysql_query("DELETE FROM zayavka_teams WHERE battle_id=".$groups["id"]);
		mysql_query("DELETE FROM zayavka_bot WHERE id=".$groups["id"]);
	}
}
unset($sql,$groups,$sql_teams,$res);
##-----------------##
$sql=mysql_query("SELECT * FROM z_group WHERE status=1");
if (mysql_num_rows($sql))
{
	while ($groups=mysql_fetch_array($sql))
	{
		$sql_teams=mysql_query("SELECT * FROM z_login WHERE group_id=".$groups["id"]);
		while ($res=mysql_fetch_array($sql_teams))
		{	
			mysql_query("UPDATE users SET zayava=0 WHERE login='".$res["player"]."'");
		}
		mysql_query("DELETE FROM z_login WHERE group_id=".$groups["id"]);
		mysql_query("DELETE FROM z_group WHERE id=".$groups["id"]);
	}
}
##-----------------##
$sql=mysql_query("SELECT * FROM led_group WHERE status=1");
if (mysql_num_rows($sql))
{
	while ($groups=mysql_fetch_array($sql))
	{
		$sql_teams=mysql_query("SELECT * FROM led_login WHERE group_id=".$groups["id"]);
		while ($res=mysql_fetch_array($sql_teams))
		{	
			mysql_query("UPDATE users SET zayava=0 WHERE login='".$res["player"]."'");
		}
		mysql_query("DELETE FROM led_login WHERE group_id=".$groups["id"]);
		mysql_query("DELETE FROM led_group WHERE id=".$groups["id"]);
	}
}
##-----------------##
$sql=mysql_query("SELECT * FROM izumrud_group WHERE status=1");
if (mysql_num_rows($sql))
{
	while ($groups=mysql_fetch_array($sql))
	{
		$sql_teams=mysql_query("SELECT * FROM izumrud_login WHERE group_id=".$groups["id"]);
		while ($res=mysql_fetch_array($sql_teams))
		{	
			mysql_query("UPDATE users SET zayava=0 WHERE login='".$res["player"]."'");
		}
		mysql_query("DELETE FROM izumrud_login WHERE group_id=".$groups["id"]);
		mysql_query("DELETE FROM izumrud_group WHERE id=".$groups["id"]);
	}
}

#echo "Katakomba zayavka deleted...";
?>