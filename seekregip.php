<?
session_start();
header("Content-Type: text/html; charset=windows-1251");
Header("Cache-Control: no-cache, must-revalidate"); // говорим браузеру что-бы он не кешировал эту страницу
Header("Pragma: no-cache");

include "conf.php";
include "align.php";
$login=$_SESSION["login"];

$ip=base64_decode(trim($_GET['ip']));
$remoteip=base64_decode(trim($_GET['remoteip']));
$remote_ip=base64_decode(trim($_GET['remote_ip']));

$onlineip=base64_decode(trim($_GET['onlineip']));
$onlineremote=base64_decode(trim($_GET['onlineremote']));
$last_ip=base64_decode(trim($_GET['last_ip']));

?>
<HTML>
<HEAD>
	<title>WWW.MEYDAN.AZ - IP SEARCH!!!</title>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<meta http-equiv="Content-Language" content="ru">
	<META Http-Equiv=Cache-Control Content="no-cache, max-age=0, must-revalidate, no-store">
	<meta http-equiv=PRAGMA content=NO-CACHE>
	<meta http-equiv=Expires content=0>	
	<LINK REL=StyleSheet HREF='main.css' TYPE='text/css'>
</HEAD>
<body bgcolor="#dddddd" >
<?
$data = mysql_connect($base_name, $base_user, $base_pass);
if(!mysql_select_db($db_name,$data))
{
 	echo mysql_error();
 	exit;
}
$me=mysql_fetch_array(mysql_query("select orden from users where login='$login'"));
if ($me['orden']==1 || $me['orden']==6)
{
	if ($ip)
	{	
		print "<h3>Регистрировался с IP <b>$ip</b></h3>";
		$SEEK_IP = mysql_query("SELECT id,login,level,orden,admin_level,clan,clan_short,dealer FROM users WHERE reg_ip='$ip'");
		while($ip_data = mysql_fetch_Array($SEEK_IP))
		{
			$id_ip = $ip_data["id"];
			$player_ip = $ip_data["login"];
			$level_ip = $ip_data["level"];
			$orden_ip = $ip_data["orden"];
			$admin_level_ip = $ip_data["admin_level"];
			$dealer_ip = $ip_data["dealer"];
			$clan_s_ip = $ip_data["clan_short"];
			$clan_f_ip = $ip_data["clan"];
			echo drwfl($player_ip, $id_ip, $level_ip, $dealer_ip,  $orden_ip, $admin_level_ip, $clan_s_ip, $clan_f_ip)."<br>";
		}
	}
	else if ($onlineip)
	{	
		print "<h3>Текущий IP адрес: <b>$onlineip</b></h3>";
		$on=mysql_query("SELECT users.id,users.login,users.level,users.orden ,users.admin_level ,users.clan,users.clan_short, users.dealer FROM users,(SELECT online.login FROM online WHERE online.ip='$onlineip') as onl WHERE users.login=onl.login");
		while($ip_data = mysql_fetch_array($on))
		{
			$id_ip = $ip_data["id"];
			$player_ip = $ip_data["login"];
			$level_ip = $ip_data["level"];
			$orden_ip = $ip_data["orden"];
			$admin_level_ip = $ip_data["admin_level"];
			$dealer_ip = $ip_data["dealer"];
			$clan_s_ip = $ip_data["clan_short"];
			$clan_f_ip = $ip_data["clan"];
			echo drwfl($player_ip, $id_ip, $level_ip, $dealer_ip,  $orden_ip,$admin_level_ip, $clan_s_ip, $clan_f_ip)."<br>";
		}
	
	}
	else if ($onlineremote)
	{	
		print "<h3>Текущий Обший IP: <b>$onlineremote</b></h3>";
		$on=mysql_query("SELECT users.id,users.login,users.level,users.orden ,users.admin_level ,users.clan,users.clan_short, users.dealer FROM users,(SELECT online.login FROM online WHERE online.remote_ip='$onlineremote') as onl WHERE users.login=onl.login");
		while($ip_data = mysql_fetch_array($on))
		{
			$id_ip = $ip_data["id"];
			$player_ip = $ip_data["login"];
			$level_ip = $ip_data["level"];
			$orden_ip = $ip_data["orden"];
			$admin_level_ip = $ip_data["admin_level"];
			$dealer_ip = $ip_data["dealer"];
			$clan_s_ip = $ip_data["clan_short"];
			$clan_f_ip = $ip_data["clan"];
			echo drwfl($player_ip, $id_ip, $level_ip, $dealer_ip,  $orden_ip,$admin_level_ip, $clan_s_ip, $clan_f_ip)."<br>";
		}
	
	}
	else if ($last_ip)
	{	
		print "<h3>Последний раз зашел c IP адреса: <b>$last_ip</b></h3>";
		$SEEK_IP = mysql_query("SELECT id,login,level,orden,admin_level,clan,clan_short,dealer FROM users WHERE last_ip='$last_ip'");
		while($ip_data = mysql_fetch_Array($SEEK_IP))
		{
			$id_ip = $ip_data["id"];
			$player_ip = $ip_data["login"];
			$level_ip = $ip_data["level"];
			$orden_ip = $ip_data["orden"];
			$admin_level_ip = $ip_data["admin_level"];
			$dealer_ip = $ip_data["dealer"];
			$clan_s_ip = $ip_data["clan_short"];
			$clan_f_ip = $ip_data["clan"];
			echo drwfl($player_ip, $id_ip, $level_ip, $dealer_ip,  $orden_ip, $admin_level_ip, $clan_s_ip, $clan_f_ip)."<br>";
		}
	}
	else if ($remote_ip)
	{	
		print "<h3>Последний Обший IP: <b>$remote_ip</b></h3>";
		$SEEK_IP = mysql_query("SELECT id,login,level,orden,admin_level,clan,clan_short,dealer FROM users WHERE remote_ip='$remote_ip'");
		while($ip_data = mysql_fetch_Array($SEEK_IP))
		{
			$id_ip = $ip_data["id"];
			$player_ip = $ip_data["login"];
			$level_ip = $ip_data["level"];
			$orden_ip = $ip_data["orden"];
			$admin_level_ip = $ip_data["admin_level"];
			$dealer_ip = $ip_data["dealer"];
			$clan_s_ip = $ip_data["clan_short"];
			$clan_f_ip = $ip_data["clan"];
			echo drwfl($player_ip, $id_ip, $level_ip, $dealer_ip,  $orden_ip, $admin_level_ip, $clan_s_ip, $clan_f_ip)."<br>";
		}
	}

}
?>
</body>