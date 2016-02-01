<?
	include "conf.php";
	ob_start("ob_gzhandler");
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
	<title>WWW.MEYDAN.AZ - Участники Новогоднего Джекпота</title>
</head>

<body topMargin=4 leftMargin=4 bottomMargin=4 rightMargin=4 bgcolor=#dddddd>
<script language="JavaScript" type="text/javascript" src="commoninf.js"></script>
<center><a href="bank_member.php" class=us2>Обновить</a><center>
<table border="0" cellpadding=3 cellspacing=1  style="border-collapse: collapse" width="400" align="center">
	<tr height=30>
		<td bgcolor=#FCFAF3 style="color:#990000" align=center><b style="color:green">Участники</b></td>
	</tr>
	<?
		$result= mysql_query("SELECT users.login, users.id, level, orden, admin_level, dealer, clan_short, clan FROM bank_member LEFT JOIN users on users.id=bank_member.user_id WHERE 1 ORDER BY bank_member.date DESC");
		while ($DAT = mysql_fetch_array($result))
		{
	        echo "
	        <tr>
	        	<td bgcolor=#FCFAF3 valign=center noWrap>
       				<script>drwfl('".$DAT['login']."', '".$DAT['id']."', '".$DAT['level']."', '".$DAT['dealer']."', '".$DAT['orden']."', '".$DAT['admin_level']."', '".$DAT['clan_short']."', '".$DAT['clan']."');</script>
	        	</td>
			</tr>\n";
		}
		mysql_free_result($result);
		mysql_close();
	?>
</table><br>