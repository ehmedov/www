<?
include ("key.php");
include ("conf.php");
$login=$_SESSION["login"];
Header('Content-Type: text/html; charset=windows-1251');
Header("Cache-Control: no-cache, must-revalidate"); // говорим браузеру что-бы он не кешировал эту страницу
Header("Pragma: no-cache");

$data = mysql_connect($base_name, $base_user, $base_pass) or die('Не получается подключиться. Проверьте имя сервера, имя пользователя и пароль!');
mysql_select_db($db_name) or die('Ошибка входа в базу данных');

$db = mysql_fetch_assoc(mysql_query("SELECT clan, orden, dealer, admin_level, adminsite, level FROM users WHERE login='".$login."'"));
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<meta http-equiv="Content-Language" content="ru">
	<meta name="author" content="meydan.az">
	<META Http-Equiv=Cache-Control Content="no-cache, max-age=0, must-revalidate, no-store">
	<meta http-equiv=PRAGMA content=NO-CACHE>
	<meta http-equiv=Expires content=0>	
	<style>
		.hand {cursor: pointer;}
		.field 
		{
			BORDER-RIGHT: #000000 0px solid; BORDER-TOP: #383838 2px solid; FONT-WEIGHT: normal; FONT-SIZE: 11px; BORDER-LEFT: #000000 0px solid; WIDTH: 100%; COLOR: #343434; BORDER-BOTTOM: #383838 0px solid; FONT-FAMILY: Tahoma; BACKGROUND-COLOR: #e9e9e9; max-height: 17px
		}
	</style>
</head>	
<script type="text/javascript">
	function s()
	{
	   var x = event.screenX - 120;
	   var y = event.screenY - 360;
	   var sFeatures = 'dialogLeft:'+x+'px;dialogTop:'+y+'px;dialogHeight:340px;dialogWidth:400px;help:no;status:no;unadorned:no';
	   window.showModelessDialog("smiles.php", window, sFeatures);
	}
	function url2(url)
	{
		top.main.location.href = url;
	}
	function url(url)
	{
		top.main.location = "main.php?act="+url;
	}

	var currenttime = '<? echo date("F d, Y H:i:s", time())?>' //PHP method of getting server date
	var montharray=new Array("January","February","March","April","May","June","July","August","September","October","November","December")
	var serverdate=new Date(currenttime)
	function padlength(what)
	{
		var output=(what.toString().length==1)? "0"+what : what
		return output
	}
	function displaytime()
	{
		serverdate.setSeconds(serverdate.getSeconds()+1)
		var datestring=montharray[serverdate.getMonth()]+" "+padlength(serverdate.getDate())+", "+serverdate.getFullYear()
		var timestring=padlength(serverdate.getHours())+":"+padlength(serverdate.getMinutes())+":"+padlength(serverdate.getSeconds())
		document.all("clock").innerHTML='&nbsp;'+timestring
	}
	function clock()
	{
		setInterval("displaytime()", 1000)
	}
</script>
<body bgcolor="#392F2D" text="#FFD175" link="#FFD175" vlink="#FFD175" alink="white" leftmargin=0 topmargin=0 rightmargin=0 bottommargin=0 marginwidth=0 marginheight=0 background="img/design/talk/center-bgr.gif"  onLoad="top.start();clock();" >

<form action="chat/chat.php" target="refreshed" method="get" style="padding:0px;margin:0px" name="F1" onsubmit="top.NextRefreshChat();">

<table cellspacing=0 cellpadding=0 border=0 width=100%>
<tr valign=top>
	<td>
		<form action="chat/chat.php" target="refreshed" method="get" style="padding:0px;margin:0px" name="F1" onsubmit="top.NextRefreshChat();">
		<INPUT TYPE="hidden" name="sub" value="refreshed">
		<INPUT TYPE="hidden" name="fltr" value="">
		<table cellspacing=0 cellpadding=0 border=0 >
			<tr>
				<td width=84 nowrap height=36 background="img/design/talk/center-left.gif" align=right valign=middle><font id="clock"></font>&nbsp;&nbsp;</td>
				<td width=99% height=36 background="img/design/talk/center-enter-text.gif" valign=middle>
					<input name="text" maxlength=500 style="color:#FFD175;width:100%;height:15;border:0;border-color:#522B20;background-color:transparent">
				</td>
				<td width=30><input type="image" src="img/design/talk/button-enter.gif" width=50 height=36 border=0 hspace=0 vspace=0 alt="Сказать" title="Сказать"></td>
				<td width=30><img src="img/design/talk/channel-all-on.gif" width=30 height=36 border=0 style='cursor:pointer;' title='Очистить строку ввода/чат' alt='Очистить строку ввода/чат' hspace=0 vspace=0 onclick="top.clearc();"></td>
				<?if($db["clan"]){?>
				<td width=30><img src="img/design/talk/clan.gif" width=30 height=36 border=0 style='cursor:pointer;' title='Клановая комната' alt='Клановая комната' hspace=0 vspace=0 onclick="top.main.location.href='main.php?act=clan';"></td>
				<?}?>
				<?if ($db["adminsite"]){?>
				<td width=30><img src="img/design/talk/admin.gif" width=30 height=36 border=0 style='cursor:pointer;' title='Админ' alt='Админ' hspace=0 vspace=0 onclick="top.main.location.href='admin.php';"></td>
				<?}?>
				<?if($db["orden"]==1 || $db["dealer"]){?>
				<td width=30><img src="img/design/talk/orden1.gif" width=30 height=36 border=0 style='cursor:pointer;' title='Стражи порядка' alt='Стражи порядка' hspace=0 vspace=0 onclick="top.main.location.href='orden.php';"></td>
				<?}?>	
				<?if($db["orden"]==2 && (date("H") >= 21 || date("H") <7)){?>
				<td width=30><img src="img/design/talk/vampire.gif" width=30 height=36 border=0 style='cursor:pointer;' title='Вампиры' alt='Вампиры' hspace=0 vspace=0 onclick="top.main.location.href='orden.php';"></td>
				<?}?>
				<?if($db["level"]>=8 && $db["orden"]!=5){?>
				<td width=30><img src="img/design/talk/give.gif" width=30 height=36 border=0 style='cursor:pointer;' title='Передача' alt='Передача' hspace=0 vspace=0 onclick="top.main.location.href='give.php';"></td>
				<?}?>
				<td width=30><img src="img/design/talk/moder.gif" width=30 height=36 border=0 style='cursor:pointer;' title='Модераторы онлайн' alt='Модераторы онлайн' hspace=0 vspace=0 onclick="top.main.location.href='ordman.php';"></td>
				<?if($db["level"]>=4){?>
				<td width=30><img src="img/design/talk/friends.gif" width=30 height=36 border=0 style='cursor:pointer;' title='Список Друзей' alt='Список Друзей' hspace=0 vspace=0 onclick="top.main.location.href='friends.php';"></td>
				<?}?>
				
				<td width=30><div id=filter title="(выключено) Показывать в чате только сообщения адресованные мне" onclick="top.sw_filter();"><img src="img/design/talk/talk.gif" width=30 height=36 border=0 hspace=0 vspace=0></div></td>
				<td width=30><img src="img/design/talk/smiley.gif" onclick="s();" style="cursor:pointer;" width=30 height=36 hspace=0 vspace=0 border=0 title="" alt=""></td>
			</tr>
		</table>
	</td>
	</tr>
</table>
</FORM>
<iframe name="refreshed" width=0 height=0 scrolling="no" noresize>