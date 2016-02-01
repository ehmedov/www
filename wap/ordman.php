<?
include ("key.php");
include ("conf.php");
include ("align.php");
header("Content-Type: text/html; charset=windows-1251");
header("Cache-Control: no-cache, must-revalidate"); // говорим браузеру что-бы он не кешировал эту страницу
header("Pragma: no-cache");
echo '<?xml version="1.0" encoding="windows-1251"?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.2//EN" "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="en">';

$data = mysql_connect($base_name, $base_user, $base_pass) or die('Не получается подключиться. Проверьте имя сервера, имя пользователя и пароль!');
mysql_select_db($db_name) or die('Ошибка входа в базу данных');
?>
<html>
<head>
	<title>WAP.MEYDAN.AZ</title>
	<link rel="stylesheet" href="main.css" type="text/css"/>	
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
	<meta http-equiv="Content-Language" content="ru" />
	<meta name="Description" content="Отличная RPG онлайн игра посвященная боям и магии. Тысячи жизней, миллионы смертей, два бога, сотни битв между Светом и Тьмой." />
	<meta http-equiv="cache-control" content="no-cache" />
	<meta http-equiv="pragma" content="no-cache" />
	<meta http-equiv="expires" content="0" />
</head>

<body>
<div id="cnt" class="content">
	<div class="aheader"><b>Модераторы online</b></div>
	<div class="sep2"></div>
	<div>
	<?	
		$SostQuery = mysql_query("SELECT login, id, level, dealer, orden, admin_level, adminsite, clan_short, clan, room, otdel, travm,(SELECT count(*) FROM online WHERE online.login=users.login) as online FROM users WHERE (orden=1 and adminsite<2) or dealer=1 and NOT blok ORDER BY  adminsite DESC, admin_level DESC");
	    WHILE ($DAT = mysql_fetch_array($SostQuery))
		{
			$room=$DAT['room'];
			$otdel=$DAT['otdel'];
			include('otaqlar.php');
			if (!$DAT['online']) $online="<font color='#666666'><i><b>Нет в клубе</b></i></font>";else $online="<font color='#228b22'><b>OnLine</b></font>";
			echo drwfl($DAT["login"], $DAT["id"], $DAT["level"], $DAT["dealer"], $DAT["orden"], $DAT["admin_level"], $DAT["clan"], $DAT["clan_short"], $DAT["travm"])." - ".$otdel." - ".$mesto." - ".$online."<br/>";
	    }
	    mysql_close();
	?>
	</div>
	<?include("bottom.php");?>
</div>