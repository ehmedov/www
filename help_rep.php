<?
include_once("key.php");
include_once("conf.php");
include_once("functions.php");
include_once("item_des.php");
ob_start("ob_gzhandler");
Header("Cache-Control: no-cache, must-revalidate"); // говорим браузеру что-бы он не кешировал эту страницу
Header("Pragma: no-cache");
$login=$_SESSION['login'];
$data = mysql_connect($base_name, $base_user, $base_pass) or die('Не получается подключиться. Проверьте имя сервера, имя пользователя и пароль!');
mysql_select_db($db_name) or die('Ошибка входа в базу данных');

$result = mysql_query("SELECT users.*,zver.id as zver_count,zver.obraz as zver_obraz,zver.level as zver_level,zver.name as zver_name,zver.type as zver_type FROM `users` LEFT join zver on zver.owner=users.id  and zver.sleep=0 WHERE login='".$login."'");
$db = mysql_fetch_assoc($result);
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
<DIV id="slot_info" style="VISIBILITY: hidden; POSITION: absolute;z-index: 1;"></DIV>
<script language="JavaScript" type="text/javascript" src="show_inf.js"></script>
<script language="JavaScript" type="text/javascript" src="commoninf.js"></script>
<script language="JavaScript" type="text/javascript" src="glow.js"></script>

<script>
function talk(phrase)
{
	if(phrase==0)
	{
		document.location.href='main.php?act=none';
	}
}
function dialog()
{
	bernard.innerHTML='<B>Механик Торвальдс:</B><BR>'+
	'Доброго здравица, путник.<br>'+
	'Что-то твоя экипировка не выглядит больно таки новой. Нужна помощь в починке? <BR>'+
	'<BR><a href="javascript:talk(0)" class=us2><B>• Завершить диалог</B></a>';
}

</script>

<SCRIPT language="JavaScript" type="text/javascript" src="fight.js"></SCRIPT>
<h3>Диалог с "Механик Торвальдс"</h3>
<table width=100% border=0>
<tr>
	<td width=210 valign=top>
		<?
			showHPbattle($db);
			showPlayer($db);
		?>
	</td>
	<td valign=top><br>
		<table border=0 width=100% cellpadding=1 cellspacing=1 align=left><tr><td>
			<div id='bernard'></div>
			<script>dialog();</script>
		</td></tr></table>
	</td>
	<td width=210 valign=top>
		<?
		$result=mysql_query("SELECT * FROM users WHERE login='Механик Торвальдс' limit 1");
		$bot=mysql_fetch_Array($result);
		mysql_free_result($result);
		showHPbattle($bot);
		showPlayer($bot);
		?>
	</td>
</tr>
</table>