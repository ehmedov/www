<?
session_start();
session_destroy();
include ("conf.php");
header("Content-Type: text/html; charset=windows-1251");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

$data = mysql_connect($base_name, $base_user, $base_pass) or die('Не получается подключиться. Проверьте имя сервера, имя пользователя и пароль!');
mysql_select_db($db_name) or die('Ошибка входа в базу данных');

echo '<?xml version="1.0" encoding="windows-1251"?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.2//EN" "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="en">';
?>
<head>
	<title>WAP.MEYDAN.AZ- Отличная RPG онлайн игра посвященная боям и магии</title>
	<link rel="stylesheet" href="main.css" type="text/css" />
	<link rel="shortcut icon" type="image/x-icon" href="img/icon/favicon.ico" />
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
	<meta http-equiv="Content-Language" content="ru" />
	<meta name="Description" content="Отличная RPG онлайн игра посвященная боям и магии. Тысячи жизней, миллионы смертей, два бога, сотни битв между Светом и Тьмой." />
	<meta http-equiv="cache-control" content="no-cache" />
	<meta http-equiv="pragma" content="no-cache" />
	<meta http-equiv="expires" content="0" />
</head>
<body>
<div id="cnt" class="content">
	<div class="sep2"></div><br/>
	<div class="aheader">
		<img src="img/index/banner<?=rand(0,1);?>.png" title="WAP.MEYDAN.AZ" border="0"/>
	</div>
	<br/>
	<div class="aheader">
		<form method="post" action="enter.php">
			<b>Логин:</b><br/><input type="text" class="inup" name="logins" title="Login" maxlength="30" size="10" /><br/>
			<b>Пароль:</b><br/><input type="password" class="inup"  name="psw" maxlength="20" title="Password" size="10" /><br/><br/>
			<input class="inup" type="submit" value="Войти" /><br/>
		</form>
		<a accesskey="2" href="reg.php">[Регистрация]</a><br/><br/>
	</div>
	<div class="aheader">
		<? 
			$all = mysql_fetch_array(mysql_query("select (SELECT count(*) FROM `users`) as us, (SELECT count(*) FROM `online`)as onl"));
			echo "Всего жителей: <b><u>".($all["us"])."</u></b> чел. | Жителей Он-лайн: <b><u>".$all["onl"]."</u></b> чел.<br/>";
			mysql_close($data);
		?>
	</div>
	<?include("bottom_index.php");?>
</div>