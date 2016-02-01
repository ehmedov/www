<?
	include ("conf.php");
	include ("align.php");
	ob_start("ob_gzhandler");
	$data   = mysql_connect($base_name, $base_user, $base_pass)or die ('Технический перерыв  . Приносим свои извинения. Администрация.');
	mysql_select_db($db_name,$data);
	header("Content-Type: text/html; charset=windows-1251");
	header("Cache-Control: no-cache, must-revalidate"); // говорим браузеру что-бы он не кешировал эту страницу
	header("Pragma: no-cache");
		echo '<?xml version="1.0" encoding="windows-1251"?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.2//EN" "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="en">';
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
	<div class="aheader">
	<a href="who.php">Обновить</a><br/>
	<?
	$all = mysql_fetch_array(mysql_query("SELECT count(*) FROM `online`"));
	echo "Жителей Он-лайн: <b><u>".$all[0]."</u></b> чел.";
	$ttt=20;
	$total=$all[0];
	if (empty($_GET['start'])) $start = 0; else $start = (int)abs($_GET['start']);
	if ($total < $start + $ttt){ $end = $total; }
	else {$end = $start + $ttt; }
	?>
	</div>
	<div class="sep2"></div>
	<div>
		<?
			$result= mysql_query("SELECT users.login, id, level, orden, admin_level, dealer, clan_short, clan, travm, users.room FROM online LEFT JOIN users on users.login=online.login WHERE users.adminsite<2 LIMIT $start, $ttt");
			while ($DAT = mysql_fetch_array($result))
			{
		    	$room=$DAT['room'];
				include('otaqlar.php');
		        echo drwfl($DAT["login"], $DAT["id"], $DAT["level"], $DAT["dealer"], $DAT["orden"], $DAT["admin_level"], $DAT["clan"], $DAT["clan_short"], $DAT["travm"])." - <font color='#696969'>".$mesto."</font><br/>";
			}
			mysql_free_result($result);
			echo "<br/><center>";
			if ($start != 0) {echo '<small><a href="?start='.($start - $ttt).'">Назад</a></small> ';}
			if ($total > $start + $ttt) {echo ' <small><a href="?start='.($start + $ttt).'">Далее</a></small>';}
			mysql_close();
		?>
	</div>
	<?include("bottom.php");?>
</div>
</html>