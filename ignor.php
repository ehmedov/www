<?
include ('key.php');
ob_start("@ob_gzhandler");
include ("conf.php");
Header("Cache-Control: no-cache, must-revalidate"); // говорим браузеру что-бы он не кешировал эту страницу
Header("Pragma: no-cache");
$login=$_SESSION["login"];

$data = mysql_connect($base_name, $base_user, $base_pass) or die('Не получается подключиться. Проверьте имя сервера, имя пользователя и пароль!');
mysql_select_db($db_name) or die('Ошибка входа в базу данных');
//-----------------------------------------------------------------------------------------------		
if ($_GET['login'])
{   
	$target=htmlspecialchars(addslashes($_GET['login']));
	$CHECK = mysql_fetch_array(mysql_query("SELECT id, login, orden FROM `users` WHERE login='".$target."'"));
	if(!$CHECK)
	{
		$mess="Персонаж <B>".$target."</B> не найден в базе данных.";
	}
	else if($CHECK["orden"]==1)
	{
		$mess="Персонаж <B>".$target."</B> не найден в базе данных.";
	}
	else if ($_SESSION["uin_id"]==$CHECK["id"])
	{
		$mess="Незачем добавить себя в игнор";		
	}	
	else
	{
		$CHECKFRIEND = mysql_fetch_array(mysql_query("SELECT * FROM `ignor` WHERE login = '".$login."' and ignored='".$target."'"));
		if(!$CHECKFRIEND)
		{
			mysql_query("INSERT INTO ignor(login,ignored) VALUES('".$login."','".$CHECK["login"]."')");
			$mess= "Персонаж <b>".$target."</b> добавлен.";
		}
		else
		{
			$mess= "Персонаж <b>".$target."</b> уже в списке.";
		}
	}
}
//-----------------------------------------------------------------------------------------------	
if ($_GET['delusr'])
{
	$delusr=(int)$_GET['delusr'];
	mysql_query("DELETE FROM `ignor` WHERE id=".$delusr." and login='".$login."'");
}
//-----------------------------------------------------------------------------------------------	
$result = mysql_query("SELECT users.login, users.id, level, dealer, orden, admin_level, clan_short, clan, room, ignor.id as ignor_id,(SELECT count(*) FROM online WHERE online.login=users.login) as online FROM ignor LEFT JOIN users ON users.login=ignor.ignored WHERE ignor.login='".$login."'");
while ($DAT = mysql_fetch_array($result))
{	
	$room=$DAT['room'];
	$ignor_id=$DAT['ignor_id'];
	include('otaqlar.php');
	if (!$DAT['online']) $online="<img src='img/index/offline.gif'>";else $online="<img src='img/index/online.gif'>";

	$ignored_txt.="<tr><td nowrap>$online <a href='javascript:top.AddToPrivate(\"".$DAT['login']."\")'><img border=0 src=img/arrow3.gif alt=\"Приватное сообщение\" ></a>
	<script>drwfl('".$DAT['login']."', '".$DAT['id']."', '".$DAT['level']."', '".$DAT['dealer']."', '".$DAT['orden']."', '".$DAT['admin_level']."', '".$DAT['clan_short']."', '".$DAT['clan']."');</script> - <i style='color:gray;'>".$mesto."</i>
	&nbsp;&nbsp;&nbsp;<a OnClick=\"if (!confirm('Удалить персонаж из списка?')) { return false; } \" href='?delusr=$ignor_id'><img src='img/del.gif' alt='Удалить из списка'></a></td></tr>";
}
mysql_close();
?>
<html>
<HEAD>	
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<meta http-equiv="Content-Language" content="ru">
	<META Http-Equiv=Cache-Control Content="no-cache, max-age=0, must-revalidate, no-store">
	<meta http-equiv=PRAGMA content=NO-CACHE>
	<meta http-equiv=Expires content=0>	
	<LINK REL=StyleSheet HREF='main.css' TYPE='text/css'>
</HEAD>
<body bgcolor="#faeede">
<script language="JavaScript" type="text/javascript" src="commoninf.js"></script>
<h3>Игнор Лист</h3>
<table border="0" cellspacing="0" width="100%" align="center">
<tr>
	<td width=100%><font color=#ff0000><?=$mess?></font></td>
	<td align=right noWrap>
		<INPUT type='button' style='width: 100px' value='Вернуться' style='cursor:hand' onClick="javascript:location.href='main.php?act=none'">
	</td>
</tr>
<tr>
	<td colspan=2><?=$ignored_txt;?></td>
</tr>
</table>
<br><br><br>
<?	include("counter.php");?>