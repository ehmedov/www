<?
ob_start();
session_start();
include ("conf.php");
include ("functions.php");

header("Content-type: text/html; charset=windows-1251");
header("Cache-Control: no-cache, must-revalidate"); // ������� �������� ���-�� �� �� ��������� ��� ��������
header("Pragma: no-cache");
$data = mysql_connect($base_name, $base_user, $base_pass) or die('�� ���������� ������������. ��������� ��� �������, ��� ������������ � ������!');
mysql_select_db($db_name) or die('������ ����� � ���� ������');

echo '<?xml version="1.0" encoding="windows-1251"?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.2//EN" "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="en">';
$item_id=(int)abs($_GET["item_id"]);
$from_inv=mysql_fetch_Array(mysql_query("SELECT * FROM inv WHERE id='".$item_id."' and object_razdel='obj'"));
?>
<html>
<head>
	<title>WAP.MEYDAN.AZ</title>
	<link rel="stylesheet" href="main.css" type="text/css"/>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
	<meta http-equiv="Content-Language" content="ru" />
	<meta name="Description" content="�������� RPG ������ ���� ����������� ���� � �����. ������ ������, �������� �������, ��� ����, ����� ���� ����� ������ � �����." />
	<meta http-equiv="cache-control" content="no-cache" />
	<meta http-equiv="pragma" content="no-cache" />
	<meta http-equiv="expires" content="0" />
</head>
<body>
<div id="cnt" class="content">
	<div>
	<?
	if(!$from_inv)
	{
		echo "<b>������� �� ������</b>";
	}
	else
	{
		echo "<br/><b>���� ���������:</b> ".$from_inv["owner"]."<br/><img src='http://www.meydan.az/img/items/".$from_inv["img"]."' border='0' /><br/>";
		show_item($db,$from_inv);
		$from_shop=mysql_fetch_Array(mysql_query("SELECT * FROM paltar WHERE id='".$from_inv["object_id"]."'"));
		echo "<div class=\"sep1\"></div><div class=\"sep2\"></div>";
		echo "<br/><b>���� �� ��������</b><br/><img src='http://www.meydan.az/img/items/".$from_inv["img"]."' border='0' /><br/>";
		show_item($db,$from_shop);
	}
	?>
	</div>	
	<?include("bottom.php");?>
</div>
</html>