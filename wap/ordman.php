<?
include ("key.php");
include ("conf.php");
include ("align.php");
header("Content-Type: text/html; charset=windows-1251");
header("Cache-Control: no-cache, must-revalidate"); // ������� �������� ���-�� �� �� ��������� ��� ��������
header("Pragma: no-cache");
echo '<?xml version="1.0" encoding="windows-1251"?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.2//EN" "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="en">';

$data = mysql_connect($base_name, $base_user, $base_pass) or die('�� ���������� ������������. ��������� ��� �������, ��� ������������ � ������!');
mysql_select_db($db_name) or die('������ ����� � ���� ������');
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
	<div class="aheader"><b>���������� online</b></div>
	<div class="sep2"></div>
	<div>
	<?	
		$SostQuery = mysql_query("SELECT login, id, level, dealer, orden, admin_level, adminsite, clan_short, clan, room, otdel, travm,(SELECT count(*) FROM online WHERE online.login=users.login) as online FROM users WHERE (orden=1 and adminsite<2) or dealer=1 and NOT blok ORDER BY  adminsite DESC, admin_level DESC");
	    WHILE ($DAT = mysql_fetch_array($SostQuery))
		{
			$room=$DAT['room'];
			$otdel=$DAT['otdel'];
			include('otaqlar.php');
			if (!$DAT['online']) $online="<font color='#666666'><i><b>��� � �����</b></i></font>";else $online="<font color='#228b22'><b>OnLine</b></font>";
			echo drwfl($DAT["login"], $DAT["id"], $DAT["level"], $DAT["dealer"], $DAT["orden"], $DAT["admin_level"], $DAT["clan"], $DAT["clan_short"], $DAT["travm"])." - ".$otdel." - ".$mesto." - ".$online."<br/>";
	    }
	    mysql_close();
	?>
	</div>
	<?include("bottom.php");?>
</div>