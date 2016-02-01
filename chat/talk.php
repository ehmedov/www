<?
include ("key.php");
include ("../conf.php");
$login=$_SESSION["login"];
Header("Cache-Control: no-cache, must-revalidate"); // говорим браузеру что-бы он не кешировал эту страницу
Header("Pragma: no-cache");

$data = mysql_connect($base_name, $base_user, $base_pass) or die('Не получается подключиться. Проверьте имя сервера, имя пользователя и пароль!');
mysql_select_db($db_name) or die('Ошибка входа в базу данных');

$db = mysql_fetch_assoc(mysql_query("SELECT clan,orden,dealer,admin_level,adminsite,level FROM users WHERE login='".$login."'"));
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
			.hand {CURSOR: pointer}
			.field 
			{
				BORDER-RIGHT: #000000 0px solid; BORDER-TOP: #383838 2px solid; FONT-WEIGHT: normal; FONT-SIZE: 11px; BORDER-LEFT: #000000 0px solid; WIDTH: 100%; COLOR: #343434; BORDER-BOTTOM: #383838 0px solid; FONT-FAMILY: Tahoma; BACKGROUND-COLOR: #e9e9e9; max-height: 17px
			}
		</style>
	</head>	
<body onLoad="top.start();clock();" topMargin=0 LeftMargin=0 RightMargin=0 BottomMargin=0 bgcolor=#959795>
	<script type="text/javascript">
		function s()
		{
		   var x = event.screenX - 120;
		   var y = event.screenY - 360;
		   var sFeatures = 'dialogLeft:'+x+'px;dialogTop:'+y+'px;dialogHeight:340px;dialogWidth:400px;help:no;status:no;unadorned:no';
		   window.showModelessDialog("../smiles.php", window, sFeatures);
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

<FORM action="chat.php" target="refreshed" method=GET name="F1" onsubmit="top.NextRefreshChat();">
	<table cellspacing="0" cellpadding="0" border="0"  width=100%  background="img/say_bg.jpg">
	<tr>
	 	<td class=hand><img src="img/say_left.gif" title="Чат"></td>
	    <td id="T2" width="100%">
	    	<div id=inputtext><input type="text" class="field" name="text" maxlength="500" onkeyup="if((event.ctrlKey) && ((event.keyCode==10)||(event.keyCode==13))) { document.F1.sbm.click() }"></div>
		</td>   
		<td><img src="img/say_k.gif" alt="" border="0"></td>
	    <td>
	        <table cellspacing=0 cellpadding=0 border=0>
	        <tr>
		        <td class=hand title="Добавить текст в чат" onclick="document.F1.submit();"><img src="img/enter.gif" alt="" border="0"></td>
		        <td class=hand title="Очистить строку ввода/чат" onclick="top.clearc();"><img src="img/clear.gif" alt="" border="0"></td>
		        <?if($db["clan"]!=""){?>
		      	<td class=hand onclick="top.main.location.href='../main.php?act=clan';"><img src='img/clan.gif' alt="Клановая комната"></td>
				<?}?>
				<?if($db["orden"]==1 || $db["dealer"]){?>
		      	<td class=hand><img src="img/1.gif" alt="Админ"  onclick="url2('../orden.php');" ></td>
				<?
					if ($db["adminsite"])echo "<td class=hand><img src=\"img/admin.gif\" alt=\"Админ\"  onclick=\"url2('../admin.php');\" ></td>";
				}?>
				<?if($db["orden"]==2)
				{
					$CurrentTime = date("H");
					if ($CurrentTime >= 21 || $CurrentTime <7)
					{?>
		      		<td class=hand><img src='img/vampire.gif' alt="Вампиры" onclick="url2('../orden.php');" ></td>
					<?}
				}
				?>
				<?if($db["level"]>=8 && $db["orden"]!=5){?>
		      	<td class=hand><img src='img/peredacha.gif'  onclick="url2('../give.php');" alt="Передача"></td>
				<?}?>
				<td class=hand><img src='img/orden.gif' onclick="top.main.location.href='../ordman.php';" alt="Модераторы онлайн"></td>
				<?if($db["level"]>=4){?>
		      	<td class=hand><img src='img/friends.gif' onclick="top.main.location.href='../friends.php';" alt="Друзья"></td>
		         <?}?>	      	
		        <td class=hand onclick="top.sw_filter();"><div id=filter title="(выключено) Показывать в чате только сообщения адресованные мне"><img src='img/talk.gif'></div></td>
		        <td class=hand><img src="img/smile.gif" alt="" border="0" onclick="s();"></td>
		      </tr>
			</table>
		</td>
	  	<td><img src="img/say_trenn.gif"></td>
	    <td class=hand width="70" valign="middle" align="center">
	        <b class=hand id="clock" style="font-family:arial; color:#959795; font-size:14px" title="Текущее время">&nbsp;00:00:00</b>
	    </td>
		<td valign=top><img src="img/say_right.gif"></td>
	</tr>
	</table>
	<INPUT TYPE="hidden" name="sub" value="refreshed">
	<INPUT TYPE="hidden" name="fltr" value="">
</FORM>
<iframe name="refreshed" width=0 height=0 scrolling="no" noresize>