<?
session_start();
session_destroy();
include "conf.php";
$data = mysql_connect($base_name, $base_user, $base_pass) or die('�� ���������� ������������. ��������� ��� �������, ��� ������������ � ������!');
mysql_select_db($db_name) or die('������ ����� � ���� ������');
?>
<html>
<head>
	<title>WWW.MEYDAN.AZ- �������� RPG ������ ���� ����������� ���� � �����</title>
	<link href="http://www.meydan.az/favicon.ico" rel="icon">
	<LINK REL=StyleSheet HREF='index.css' TYPE='text/css'>	
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<meta http-equiv="Content-Language" content="ru">
	<meta name="Keywords" content="����, ������, �������, ������, online, ��������, internet, RPG, fantasy, �������, ���, �����, �����, �����, ����, ����, �����, ������, meydan, ���, �����, �����, ��������, �����������, ����������� ����������, ������, ���, ����������, ���, ������, �����, ����, ����,  games, ����, ����, �������, ����,������,antibk,anti,����,��,bk,combats,kombats,�������,��,���,org,ru,combats.ru,paladins,��������,������,�����,������,�������,�������,������,��������,���������,���,���,���������,�������,�����,��,mercenaries,darkclan,wild,hearts,mid,��������,�����������,����,�����������,������,merlin,lel,���,����,����������,online,offline,������,�������,����,���������������������,���,php,�����,���������,�������,�����,�������,��������,�����,�����,���,����,������,��������,���������,������������,���������,����,���,��������,����,�������,������,����,clan,������������,�������,�����������,������,��,up,�����,�������,level,�������,�����,�����,��������,�����������,�����������,�������,enchanter,�����,����,capitalcity,antibkcity,capital,forum,�����,angels,sun,sand,emerald,�������,1 ��,���,������,�������,���������,����������,���,������,�������,�������,�������,�������,�������������,�����������,������,�����,������������,����,�����������,������ ����,�����������,����,tj,dave,alone,soul,����������,serious,damage,bringers">
	<meta name="Description" content="�������� RPG ������ ���� ����������� ���� � �����. ������ ������, �������� �������, ��� ����, ����� ���� ����� ������ � �����.">
	<META http-equiv=Cache-Control content=no-cache>
	<META http-equiv=PRAGMA content=NO-CACHE>
	<META http-equiv=Expires content=0>
</head>
<?
if($break == 1)
{
	echo '<center><br><br><br><br>
	<table border="0" cellpadding="0" cellspacing="0" width="400">
	  <tbody>
	  <tr>
	    <td><br><br><br>
	    <img src="img/const/cons.gif" align="right" border="0" height="43" width="52">
		<font face="ARIAL" size="-1">		
		<h3>WWW.MEYDAN.AZ</h3>
	    <small>�������� RPG ������ ���� ����������� ���� � �����</small>
	    <br>
	 	<p align="center"><strong>  �������� ���� �������� �� ��������.</strong></p>
		<br><br><img src="img/const/under.gif" border="0" height="13" width="442"> 
	<br>
    </font></td></tr></tbody></table>';
	die();
}
 //onload="DrawWeather();WeatherBegin();"
?>
<script type="text/javascript" src="snow.js"></script>
<div id='snow' name='snow'></div>	
<body bgcolor="#000000">

	<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" width="1255" height="600" id="index" align="middle">
	<param name="allowScriptAccess" value="sameDomain" />
	<param name="allowFullScreen" value="false" />
	<param name="movie" value="img/swf/index.swf" /><param name="quality" value="high" /><param name="bgcolor" value="#000000" />	<embed src="img/swf/index.swf" quality="high" bgcolor="#000000" width="1255" height="600" name="index" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
	</object>


	<center>
		<a href="rules.php" onclick="window.open(this.href);return false;">������</a> &nbsp;
		<a href="soqlaweniya.php" onclick="window.open(this.href);return false;">����������</a> &nbsp;
		<a href="remind.php" onclick="window.open(this.href, 'remind', 'width=500, height=230');return false;">������ ������?</a> &nbsp;
		<a href="top.php" onclick="window.open(this.href);return false;">�������</a>&nbsp;
		<a href="http://www.meydan.az/forum/forum.php"  onclick="window.open(this.href);return false;">�����</a>
		<div align=center>
			<? 
				$all = mysql_fetch_array(mysql_query("select (SELECT count(*) FROM `users`) as us, (SELECT count(*) FROM `online`)as onl"));
				echo "<font color=#E8C483>
						����� �������: <b><u>".$all["us"]."</u></b> ���. | 
						������� ��-����: <b><u>".$all["onl"]."</u></b> ���.
						</FONT><br>";
				mysql_close($data);
			?>
		</div>
		<small class="small">� Copyright 2006-2010  WWW.MEYDAN.AZ - ���������� ������ ����</small>
	</center>
</body>