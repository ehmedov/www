<?
ob_start();
include ("key.php");
include ("conf.php");
include ("functions.php");
include ("align.php");
$login=$_SESSION["login"];

header("Content-type: text/html; charset=windows-1251");
header("Cache-Control: no-cache, must-revalidate"); // говорим браузеру что-бы он не кешировал эту страницу
header("Pragma: no-cache");

echo '<?xml version="1.0" encoding="windows-1251"?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.2//EN" "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="en">';

$data = mysql_connect($base_name, $base_user, $base_pass) or die('Не получается подключиться. Проверьте имя сервера, имя пользователя и пароль!');
mysql_select_db($db_name) or die('Ошибка входа в базу данных');

$db = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE login='".$login."'"));
TestBattle($db);
include ("fill_hp.php");
$min_level=4;
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
<?
	include("header.php");
?>	
<?
echo "<div class='aheader'><br/>";
	echo "<img src='img/others/train.jpg' border='0' /><br/>";
	echo "<b>Здесь вы можете провести тренировочные бои с Вашей тенью.</b><br/>";
	if(!empty($db["travm"]))
	{
	 	echo "<b style='color:#ff0000'>Вы не можете драться, т.к. тяжело травмированы!<br/>Вам необходим отдых!</b><br/>";
	}
	else if ($db["zayavka"])
	{
		echo "<b style='color:#ff0000'>Вы не можете принять этот вызов! Сначала отзовите текущую...</b><br/>";
	}
	else
	{
		if($db["level"]<=$min_level)
		{
			if($_GET["train"] && $db["level"]<=$min_level)
			{
				startTrain($db);
			} 
			echo "Бои с ботом проводятся до 4-го уровня<br/>[<a href='?train=1'>Начать тренеровку</a>]<br/>";
		}
		else
		{
			echo "<b style='color: #ff0000'>Ваш уровень превышает допустимый в бою с ботом!</b><br/>Бои с ботом проводятся до $min_level уровня<br/>";
		}
	}
echo "<br/></div>";
?>
<?include("bottom.php");?>
</div>
</html>