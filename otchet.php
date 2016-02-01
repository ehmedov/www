<?
include ('key.php');
include ("conf.php");
$login=$_SESSION["login"];
$data = mysql_connect($base_name, $base_user, $base_pass) or die('Не получается подключиться. Проверьте имя сервера, имя пользователя и пароль!');
mysql_select_db($db_name) or die('Ошибка входа в базу данных');

/*
0-Персонаж зарегистрирован
1-Персонаж авторизировался
2-Неверный пароль
5-Неверный Запрос второго пароля
*/
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
<div align=right><input type=button value='Вернуться' class='new' style='cursor:hand' onClick="javascript:location.href='main.php?act=none'"></div>
<FORM ACTION="" METHOD=POST>
	<H3>Отчет системы безопасности</H3>
	Вы можете получить отчет о заходах за указанный месяц<BR>
	Укажите месяц, на который хотите получить отчет <small>(в формате mm.yy)</small>: 
	<INPUT TYPE=text NAME=date value="<?echo date('m.y');?>"> 
	<INPUT TYPE=submit name=logenters value="Посмотреть">
</FORM>
<BR>
<?
if ($_REQUEST['date']) 
{
	$_REQUEST['date']=trim($_REQUEST['date']);
	$m=($_REQUEST['date'][0]?$_REQUEST['date'][0]:'0').($_REQUEST['date'][1]?$_REQUEST['date'][1]:'0');
	$y=($_REQUEST['date'][3]?$_REQUEST['date'][3]:'0').($_REQUEST['date'][4]?$_REQUEST['date'][4]:'0');
	if ($m>0 && $y>0) 
	{
		?>
		<table width=100% cellspacing=1 cellpadding=3 class="l3">
		<TR class="l1"><TD>
		<H3>Отчет системы безопасности за <? echo $m.'.20'.$y; ?></H3>
	  	<?
		    $res=mysql_query("SELECT * FROM report WHERE login='".$login."' and time_stamp like '20".$y."-".$m."%' ORDER BY time_stamp DESC");
		  	unset($i); 
		  	while ($i<mysql_num_rows($res)) 
		  	{
		    	$i++;
		    	$s=mysql_fetch_array($res);
		    	echo $s['time_stamp']." ".(($s['type']==2 ||$s['type']==5)?"<b>":"").$s['action']."</b> ".$s['ip'].'<br>';
		 	}
		 	if (!mysql_num_rows($res))	echo "Нет данных";
	  	?>
		</TD></TR></TABLE>
		<? 
	}
}
mysql_close();
?>
<br/>
</BODY>
</HTML>	