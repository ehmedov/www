<?
session_start();
@ob_start("ob_gzhandler");
include ("key.php");
include ("conf.php");
Header("Cache-Control: no-cache, must-revalidate"); // говорим браузеру что-бы он не кешировал эту страницу
Header("Pragma: no-cache");
$login=$_SESSION["login"];

$data = @mysql_connect($base_name, $base_user, $base_pass) or die('Не получается подключиться. Проверьте имя сервера, имя пользователя и пароль!');
mysql_select_db($db_name) or die('Ошибка входа в базу данных');

$db=mysql_fetch_array(mysql_query("SELECT orden FROM users WHERE login='".$login."'"));
?>
<HTML>
<head>
	<title>WWW.MEYDAN.AZ- Отличная RPG онлайн игра посвященная боям и магии</title>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<meta http-equiv="Content-Language" content="ru">
	<META Http-Equiv=Cache-Control Content="no-cache, max-age=0, must-revalidate, no-store">
	<meta http-equiv=PRAGMA content=NO-CACHE>
	<meta http-equiv=Expires content=0>
	<LINK REL=StyleSheet HREF='main.css' TYPE='text/css'>
</head>
<body bgcolor=#dddddd topMargin=5 leftMargin=0 rightMargin=0 bottomMargin=0 >
<br><br>
<?
if ($db["orden"]==1)
{
	echo "<INPUT TYPE=button onclick=\"document.location.reload();\" value=\"Обновить\" style=\"cursor:hand\">
	<TABLE width=100% cellspacing=1 cellpadding=5 bgcolor=212120>";
	$text_f="chat/lovechat";
	$text_a=file($text_f);	
	$total_results=count($text_a);
	$massages="";
	for ($i=$total_results-1; $i>0; $i--)
	{
		list($t0,$t1,$t2,$t3,$t4,$t5,$t6) = explode("::", $text_a[$i]);
		$zaman = date("H:i",$t1);
		$name = $t2;
		$color = $t3;
		$body = $t4;
		if((substr($body, 0, 3)!= "sys") && (substr($body, 0, 7) != "private"))
		echo "<tr bgcolor=#EEEEEE><td width=50 align=center><font class=date1>".$zaman."</font></td><td width=250><b>[".$t2."]</b> </td><td>".$body."</td></tr>";
	}
	echo "</table>";
}
else echo "Вам сюда нельзя!";
?>
<br><br><br>