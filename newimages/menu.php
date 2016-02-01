<?
include("key.php");
ob_start("ob_gzhandler");
Header('Content-Type: text/html; charset=windows-1251');
Header("Cache-Control: no-cache, must-revalidate"); // говорим браузеру что-бы он не кешировал эту страницу
Header("Pragma: no-cache");
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
	.bgrright{background: url('img/design/brg-top-right-1a.gif') repeat-x top left}
	.bgrleft{background: url('img/design/brg-top-left-1a.gif') repeat-x top right}
</style>
	
<body bgcolor="#faeede" text="#FFD175" link="#FFD175" vlink="#FFD175" alink="white" leftmargin=0 topmargin=0 rightmargin=0 bottommargin=0 marginwidth=0 marginheight=0>
<script>
	function new_win(name)
	{
		if(name == 'forum')
		{
			window.open('forum/forum.php?'+Math.random(),'forum');
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
<table cellspacing=0 cellpadding=0 border=0 width="100%" height=50>
<tr valign=top>
	<td class="bgrleft" width=50%>
	<table cellspacing=0 cellpadding=0 border=0 width="100%" height=50>
	<tr valign=top>
		<td><img src="img/design/top-left.gif" width=35 height=50 hspace=0 vspace=0 border=0></td>
		<td width=100%>
			<table cellspacing=0 cellpadding=0 border=0 height=50 width=100%>
			<tr>
				<td height=35 valign=bottom align=right>
					<?if($_SESSION["login"]=="bor"){?>
				    <a href="javascript:url('inkviz');" title="Возможности">Возможности</a> <img src="img/design/menu-ball.gif" width=14 height=14 hspace=1 vspace=0 border=0 style="vertical-align:bottom"> 
					<?}?>
					<img onclick="javascript:url('inv');" src="newimages/inv1.png" onmouseover="this.src='/newimages/inv2.png';" onmouseout="this.src='/newimages/inv1.png';"> <img src="img/design/menu-ball.gif" width=14 height=14 hspace=1 vspace=0 border=0 style="vertical-align:bottom"> 
					<a href="javascript:url('char');" title="Характеристики персонажа">Персонаж</a> <img src="img/design/menu-ball.gif" width=14 height=14 hspace=1 vspace=0 border=0 style="vertical-align:bottom"> 
					<a href="javascript:url2('anket.php');" title="Анкета персонажа">Анкета</a> <img src="img/design/menu-ball.gif" width=14 height=14 hspace=1 vspace=0 border=0 style="vertical-align:bottom"> 
				</td>
			</tr>
			<tr>
				<td height=3></td>
			</tr>
			<tr>
				<td height=12></td>
			</tr>
			</table>
		</td>
	</tr>
	</table>
	</td>
	<td width=302 height=50>
		<img src="img/design/top-balls.gif" width=302 height=50 hspace=0 vspace=0 border=0 usemap="#hotslots">
	</td>
	<td class="bgrright" width=100%>
		<table cellspacing=0 cellpadding=0 border=0 width="100%" height=50>
		<tr valign=top>
			<td>
			<table cellspacing=0 cellpadding=0 border=0 height=35 width=100%>
			<tr>
				<td height=35 valign=bottom align=left>
					&nbsp;
					<a href="javascript:new_win('who');" title="Кто Где?">Кто Где?</a> <img src="img/design/menu-ball.gif" width=14 height=14 hspace=1 vspace=0 border=0 style="vertical-align:bottom"> 
					<a href="javascript:url('none');" title="Локация">Локация</a> <img src="img/design/menu-ball.gif" width=14 height=14 hspace=1 vspace=0 border=0 style="vertical-align:bottom"> 
					<a href="javascript:new_win('forum');" title="Форум">Форум</a> <img src="img/design/menu-ball.gif" width=14 height=14 hspace=1 vspace=0 border=0 style="vertical-align:bottom"> 
					<a href="javascript:url2('com.php');" title="Комм. Отдел">Комм. Отдел</a> <img src="img/design/menu-ball.gif" width=14 height=14 hspace=1 vspace=0 border=0 style="vertical-align:bottom"> 
					<a href="javascript:new_win('smscoin');" title="SMS">SMS</a> <img src="img/design/menu-ball.gif" width=14 height=14 hspace=1 vspace=0 border=0 style="vertical-align:bottom"> 
					<a href="javascript:exit();">Выход</a>
				</td>
			</tr>
			</table>
			</td>
			<td align=right>
				<img src="img/design/top-right.gif" width=34 height=50 hspace=0 vspace=0 border=0>
			</td>
		</tr>
		</table>
	</td>
</tr>
</table>
</body>
</html>