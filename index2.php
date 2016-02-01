<?
session_start();
if ($_GET["act"]=="exit")
{
	if ($_SESSION["session_user_id"]!="")
	{
		session_destroy();
	}
}
include "conf.php";
$data = mysql_connect($base_name, $base_user, $base_pass) or die('Не получается подключиться. Проверьте имя сервера, имя пользователя и пароль!');
mysql_select_db($db_name) or die('Ошибка входа в базу данных');

Header('Content-Type: text/html; charset=windows-1251');
Header("Cache-Control: no-cache, must-revalidate");
Header("Pragma: no-cache");

?>
<html>
<head>
	<title>WWW.MEYDAN.AZ- Отличная RPG онлайн игра посвященная боям и магии</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta http-equiv="content-type" content="text/html; charset=windows-1251" />
	<meta name="Description" content="Отличная RPG онлайн игра посвященная боям и магии. Тысячи жизней, миллионы смертей, два бога, сотни битв между Светом и Тьмой.">
	<meta name="keywords" content="MMO, MMORPG, RPG, role playing game, role playing, browser based game, free to play, F2P, multiplayer game, fantasy game, fantasy mmo, online game, game forum, community forum,игра, играть, игрушки, онлайн, online, интернет, internet, RPG, fantasy, фэнтези, меч, топор, магия, кулак, удар, блок, атака, защита, meydan, бой, битва, отдых, обучение, развлечение, виртуальная реальность, рыцарь, маг, знакомства, чат, лучший, форум, свет, тьма,  games, клан, банк, магазин, клан,антибк,antibk,anti,анти,бк,bk,combats,kombats,комбатс,ру,орг,org,ru,combats.ru,paladins,паладины,доспех,хаоса,злости,панцирь,тарманы,темные,нейтралы,групповой,бой,бои,артефакты,кредиты,креды,кр,mercenaries,darkclan,wild,hearts,mid,мусорщик,мироздатель,лорд,разрушитель,мерлин,merlin,lel,лел,клуб,бойцовский,online,offline,онлайн,оффлайн,игра,многопользовательская,пхп,php,букет,незабудок,титанов,броня,ботинки,перчатки,перчи,статы,нуб,ньюб,артник,критовик,уворотчик,выносливость,интеллект,боец,маг,мудрость,удар,перелом,травма,клан,clan,переодевалка,лотерея,развлечения,портал,ап,up,левел,уровень,level,таблица,опыта,фанат,прокачка,прокачаться,центральная,площадь,enchanter,общий,враг,capitalcity,antibkcity,capital,forum,форум,angels,sun,sand,emerald,аукцион,1 кр,гос,госмаг,магазин,ремонтная,мастерская,зал,воинов,рыцарей,таверна,березка,аукцион,распределение,примерочная,лекарь,звери,цветоводство,крит,критический,пробив блок,комментатор,маша,tj,dave,alone,soul,тараканище,serious,damage,bringers" />
	<meta http-equiv="cache-control" content="no-cache" />
	<meta http-equiv="pragma" content="no-cache" />
	<meta http-equiv="expires" content="0" />

	<link rel="stylesheet" type="text/css" href="new_index.css" />
	<link rel="shortcut icon" href="favicon.ico" />
</head>
<body>
<?
if($break == 1)
{
	echo '<center><br><br><br><br>
	<table border="0" cellpadding="0" cellspacing="0" width="400">
	  <tbody>
	  <tr>
	    <td><br><br><br>
	    <img src="img/const/cons.gif" align="right" border="0" height="43" width="52">
		<font face="ARIAL" size="-1">		
		<h3>WWW.MEYDAN.AZ</h3>
	    <small>Отличная RPG онлайн игра посвященная боям и магии</small>
	    <br>
	 	<p align="center"><strong>  Извините сайт временно не работает.</strong></p>
		<br><br><img src="img/const/under.gif" border="0" height="13" width="442"> 
	<br>
    </font></td></tr></tbody></table>';
	die();
}
 //onload="DrawWeather();WeatherBegin();"
?>
<div id="container">
	<p id="logo" style="height:250px;">
		<?//<img src="img/index_new/logo1.png" alt="">?>
	</p>
	<div id="buttonContainer">
		<form id="loginForm" action="enter.php" method="post">
			<div id="loginBox" >
				<table>
				<tr>
					<td align='right'>Логин:</td><td><input type="text" name="logins" onBlur="if (value == '') {value='Логин'}" onFocus="if (value == 'Логин') {value =''}" value="Логин"class="inup" ></td>
				</tr>
				<tr>
					<td align='right'>Пароль:</td><td><input type="password" name="psw" class="inup" ></td>
				</tr>
				<tr>
					<td><input type="submit" class="btn" value=" Войти " onclick="this.blur()"></td>
					<td><input type="button" class="btn" value=" Регистрация " onclick="this.blur(); window.location.href='reg.php'"></td>
				</tr>
				</table>
			</div>
			
			
			<!--<input type="image" onmouseout="this.src='img/index_new/enter1.png'" onmouseover="this.src='img/index_new/enter2.png'" src="img/index_new/enter1.png" alt="Войти" />
			!-->
		</form>
	</div>
	<br/><br/><br/><br/><br/><br/><br/><br/><br/>
	<div align='center'>
		<a href="rules.php" onclick="window.open(this.href);return false;">Законы</a> &nbsp;
		<a href="soqlaweniya.php" onclick="window.open(this.href);return false;">Соглашения</a> &nbsp;
		<a href="remind.php" onclick="window.open(this.href, 'remind', 'width=500, height=230');return false;">Забыли пароль?</a> &nbsp;
		<a href="top.php" onclick="window.open(this.href);return false;">Рейтинг</a>	&nbsp;
		<a href="http://www.meydan.az/forum/forum.php"  onclick="window.open(this.href);return false;">Форум</a>
	</div>
	<div align='center'>
		<? 
			$date1=strtotime(date('d.m.Y'));
			$date2=$date1+24*60*60;
			$entered=mysql_fetch_array(mysql_query("SELECT count(*) FROM (SELECT id FROM report WHERE (UNIX_TIMESTAMP(time_stamp)>=$date1 and UNIX_TIMESTAMP(time_stamp)<$date2) and type=1 GROUP BY login) as t"));

			$all = mysql_fetch_array(mysql_query("select (SELECT count(*) FROM `users`) as us, (SELECT count(*) FROM `online`)as onl"));
			echo "<font color='#907e65'>
					Всего жителей: <b><u>".(int)($all["us"]+70000)."</u></b> чел. | 
					Жителей Он-лайн: <b><u>".(int)$all["onl"]."</u></b> чел. |
					Игроков за сегодня: <b><u>".(int)$entered[0]."</u></b> чел.
					</font><br/>";
		?>
	</div>

	<div id="footer" align='center'>
		<p class="center">© Copyright 2006-<?=date("Y")?> WWW.MEYDAN.AZ - бесплатная онлайн игра</p>
		<?include("counter.php");?>
	</div>
</div>
</body>
</html>