<?php
include ("conf.php");
ob_start("ob_gzhandler");
Header("Cache-Control: no-cache, must-revalidate"); // ������� �������� ���-�� �� �� ��������� ��� ��������
Header("Pragma: no-cache");
$data = mysql_connect($base_name, $base_user, $base_pass) or die('�� ���������� ������������. ��������� ��� �������, ��� ������������ � ������!');
mysql_select_db($db_name) or die('������ ����� � ���� ������');

$_GET['id']=(int)$_GET['id'];
$tr = mysql_fetch_array(mysql_query("SELECT * FROM `deztow_turnir` WHERE `id` = '".$_GET['id']."'"));
?>
<html>
<HEAD>	
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<meta http-equiv="Content-Language" content="ru">
	<META Http-Equiv=Cache-Control Content="no-cache, max-age=0, must-revalidate, no-store">
	<meta http-equiv=PRAGMA content=NO-CACHE>
	<meta http-equiv=Expires content=0>	
	<LINK REL=StyleSheet HREF='main.css' TYPE='text/css'>
</HEAD>
<script language="JavaScript" type="text/javascript" src="commoninf.js"></script>	
<body leftmargin=5 topmargin=5 marginwidth=5 marginheight=5 bgcolor=e2e0e0>
	<H3>��������� �����. ����� � ������� .</H3>
	�������� ����: <B><?=$tr['coin']?> ��.</B><BR>
	<?=$tr['log']?><BR>
</BODY>
</HTML>
