<?
	include "conf.php";
	ob_start("@ob_gzhandler");
	$data   = mysql_connect($base_name, $base_user, $base_pass)or die ('Технический перерыв  . Приносим свои извинения. Администрация.');
	mysql_select_db($db_name,$data);
	header("Content-Type: text/html; charset=windows-1251");
	Header("Cache-Control: no-cache, must-revalidate"); // говорим браузеру что-бы он не кешировал эту страницу
	Header("Pragma: no-cache");
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<meta http-equiv="Content-Language" content="ru">
	<meta http-equiv=Cache-Control Content=no-cache>
	<meta http-equiv=PRAGMA content=NO-CACHE>
	<meta http-equiv=Expires content=0>	
	<LINK REL=StyleSheet HREF='main.css' TYPE='text/css'>
	<title>WWW.OlDmeydaN.Pe.Hu</title>
</head>

<body bgcolor="#faeede">
<script language="JavaScript" type="text/javascript" src="commoninf.js"></script>
<center><a href="who.php?<?=md5(time());?>" class=us2>Обновить</a><center>
<?
$all = mysql_fetch_array(mysql_query("SELECT count(*) FROM `online`"));
echo "Жителей Он-лайн: <b><u>".$all[0]."</u></b> чел.";
?>
<table width=600 cellspacing=1 cellpadding=3 class='l3'>
	<tr height=30>
		<td><b>Сейчас в игре</b></td>
		<td><b>Местонахождение</b></td>
	</tr>
	<?
		$result= mysql_query("SELECT users.login, id, level, orden, admin_level, dealer, clan_short, clan, users.room FROM online LEFT JOIN users on users.login=online.login WHERE users.adminsite<2 ORDER BY online.room ASC");
		while ($DAT = mysql_fetch_array($result))
		{
			$n=(!$n);
	    	$room=$DAT['room'];
			include('otaqlar.php');
	        echo "
	        <tr class='".($n?'l0':'l1')."'>
	        	<td valign=center noWrap>
       				<script>drwfl('".$DAT['login']."', '".$DAT['id']."', '".$DAT['level']."', '".$DAT['dealer']."', '".$DAT['orden']."', '".$DAT['admin_level']."', '".$DAT['clan_short']."', '".$DAT['clan']."');</script>
	        	</td>
				<td valign=center style='color:green' noWrap>".$mesto."</td>
			</tr>\n";
		}
		mysql_free_result($result);
		mysql_close();
	?>
</table><br>
