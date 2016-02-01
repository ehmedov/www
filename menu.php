<?
include("key.php");
include_once("conf.php");
$data = mysql_connect($base_name, $base_user, $base_pass) or die('Не получается подключиться. Проверьте имя сервера, имя пользователя и пароль!');
mysql_select_db($db_name) or die('Ошибка входа в базу данных');
mysql_query ("SET NAMES 'latin1'"); 
mysql_query ("set character_set_client='latin1'"); 
mysql_query ("set character_set_results='latin1'"); 
mysql_query ("set collation_connection='latin1_swedish_ci'");
$login=$_SESSION["login"];

$result = mysql_query("SELECT `money`,`platina`,`naqrada`,`silver`,`adminsite`,`win`,`lose`,`nich`,`monstr` FROM `users` WHERE login='".$login."'");
$db = mysql_fetch_assoc($result);
?>
<html>
<HEAD>	
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<meta http-equiv="Content-Language" content="ru">
	<META Http-Equiv=Cache-Control Content="no-cache, max-age=0, must-revalidate, no-store">
	<meta http-equiv=PRAGMA content=NO-CACHE>
	<meta http-equiv=Expires content=0>	
</HEAD>
<style type="text/css">
	body, td {font-family: arial, tahoma, helvetica, sans serif; font-size: 11px;}
	small {font-family: arial, tahoma, helvetica, sans serif; font-size: 10px;}
	A{color: #FFD175;text-decoration:none;font-size: 13px;}
	A:visited {color: #FFD175;text-decoration:none;}
	A:hover {color: #F85711;text-decoration:underline;}
	.bgrright{background: url('images/new/bg.jpg') repeat-x top left}
	.bgrleft{background: url('images/new/bg.jpg') repeat-x top right}
</style>
	
<body bgcolor="#e0e0e0" text="#FFD175" link="#FFD175" vlink="#FFD175" alink="white" leftmargin=0 topmargin=0 rightmargin=0 bottommargin=0 marginwidth=0 marginheight=0>
<script>
	function new_win(name)
	{
		if(name == 'forum')
		{
			window.open('forum/forum.php?'+Math.random(),'forum');
		}
		if(name == 'baq')
		{
			window.open('baq/forum.php?'+Math.random(),'baq');
		}
		if(name == 'who')
		{
			window.open('who.php?'+Math.random(),'who');
		}
		if(name == 'smscoin')
		{
			window.open('smscoin.php?'+Math.random(),'smscoin');
		}
	}
	function url(url)
	{
		top.main.location = "main.php?act="+url+"&"+Math.random();
	}
	function url2(url)
	{
		top.main.location.href = url+"?"+Math.random();
	}
	function exit()
	{
		if(confirm("Вы уверены что хотите выйти из игры?")){top.location.href='index.php?act=exit';}
	}
</script>
<td height=35 valign=bottom align=right>
				
					
					
							<?if($_SESSION["orden"]==6){?>
				    <a href="javascript:url2('orden.php');" title="Истинный Мрак">Истинный Мрак</a> <img src="img/design/admin.gif" width=14 height=14 hspace=1 vspace=0 border=0 style="vertical-align:bottom"> 
					<?}?>
				</td>
					<table cellspacing=0 cellpadding=0 border=0 width="100%" height=42 background="images/new/bg.jpg">
<td width=35 background="images/new/left.gif" height=40></td>
<?if ($db["adminsite"]>=5){?>
			<td width=90><img src="images/new/admin.gif" border=0 onClick="url('inkviz');" style="cursor:hand"></td>
<?}?>
					<td width=90><img src="images/new/inv.gif" border=0 onClick="url('inv');" style="cursor:hand"></td>
	<td width=90><img src="images/new/char.gif" border=0 onClick="url('char');" style="cursor:hand"></td>
	<td width=90><img src="images/new/anketa.gif" border=0 onClick="url2('anket.php');" style="cursor:hand"></td>
	<td width=90><img src="images/new/who.gif" border=0 onClick="new_win('who');" style="cursor:hand"></td>
	<td width=90><img src="images/new/where.gif" border=0 onClick="url('none');" style="cursor:hand"></td>
	<td width=90><img src="images/new/forum.gif" border=0 onClick="new_win('forum');" style="cursor:hand"></td>
	<td width=90><img src="images/new/kom.gif" border=0 onClick="url2('com.php');" style="cursor:hand"></td>
	<td width=90><img src="images/new/exit.gif" border=0 onClick="exit();" style="cursor:hand"></td>
	<td width=39 background="images/new/right.gif"></td>


</tr>
</table>
</body>
