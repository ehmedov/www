<?
ob_start();
include ("key.php");
include ("conf.php");
include ("functions.php");
include ("align.php");
$login=$_SESSION["login"];

header("Content-type: text/html; charset=windows-1251");
header("Cache-Control: no-cache, must-revalidate"); // ������� �������� ���-�� �� �� ��������� ��� ��������
header("Pragma: no-cache");

echo '<?xml version="1.0" encoding="windows-1251"?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.2//EN" "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="en">';

$data = mysql_connect($base_name, $base_user, $base_pass) or die('�� ���������� ������������. ��������� ��� �������, ��� ������������ � ������!');
mysql_select_db($db_name) or die('������ ����� � ���� ������');

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
	<meta name="Description" content="�������� RPG ������ ���� ����������� ���� � �����. ������ ������, �������� �������, ��� ����, ����� ���� ����� ������ � �����." />
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
	echo "<b>����� �� ������ �������� ������������� ��� � ����� �����.</b><br/>";
	if(!empty($db["travm"]))
	{
	 	echo "<b style='color:#ff0000'>�� �� ������ �������, �.�. ������ ������������!<br/>��� ��������� �����!</b><br/>";
	}
	else if ($db["zayavka"])
	{
		echo "<b style='color:#ff0000'>�� �� ������ ������� ���� �����! ������� �������� �������...</b><br/>";
	}
	else
	{
		if($db["level"]<=$min_level)
		{
			if($_GET["train"] && $db["level"]<=$min_level)
			{
				startTrain($db);
			} 
			echo "��� � ����� ���������� �� 4-�� ������<br/>[<a href='?train=1'>������ ����������</a>]<br/>";
		}
		else
		{
			echo "<b style='color: #ff0000'>��� ������� ��������� ���������� � ��� � �����!</b><br/>��� � ����� ���������� �� $min_level ������<br/>";
		}
	}
echo "<br/></div>";
?>
<?include("bottom.php");?>
</div>
</html>