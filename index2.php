<?
session_start();
if ($_GET["act"]=="exit")
{
	if ($_SESSION["session_user_id"]!="")
	{
		session_destroy();
	}
}
include "conf.php";
$data = mysql_connect($base_name, $base_user, $base_pass) or die('�� ���������� ������������. ��������� ��� �������, ��� ������������ � ������!');
mysql_select_db($db_name) or die('������ ����� � ���� ������');

Header('Content-Type: text/html; charset=windows-1251');
Header("Cache-Control: no-cache, must-revalidate");
Header("Pragma: no-cache");

?>
<html>
<head>
	<title>WWW.MEYDAN.AZ- �������� RPG ������ ���� ����������� ���� � �����</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta http-equiv="content-type" content="text/html; charset=windows-1251" />
	<meta name="Description" content="�������� RPG ������ ���� ����������� ���� � �����. ������ ������, �������� �������, ��� ����, ����� ���� ����� ������ � �����.">
	<meta name="keywords" content="MMO, MMORPG, RPG, role playing game, role playing, browser based game, free to play, F2P, multiplayer game, fantasy game, fantasy mmo, online game, game forum, community forum,����, ������, �������, ������, online, ��������, internet, RPG, fantasy, �������, ���, �����, �����, �����, ����, ����, �����, ������, meydan, ���, �����, �����, ��������, �����������, ����������� ����������, ������, ���, ����������, ���, ������, �����, ����, ����,  games, ����, ����, �������, ����,������,antibk,anti,����,��,bk,combats,kombats,�������,��,���,org,ru,combats.ru,paladins,��������,������,�����,������,�������,�������,������,��������,���������,���,���,���������,�������,�����,��,mercenaries,darkclan,wild,hearts,mid,��������,�����������,����,�����������,������,merlin,lel,���,����,����������,online,offline,������,�������,����,���������������������,���,php,�����,���������,�������,�����,�������,��������,�����,�����,���,����,������,��������,���������,������������,���������,����,���,��������,����,�������,������,����,clan,������������,�������,�����������,������,��,up,�����,�������,level,�������,�����,�����,��������,�����������,�����������,�������,enchanter,�����,����,capitalcity,antibkcity,capital,forum,�����,angels,sun,sand,emerald,�������,1 ��,���,������,�������,���������,����������,���,������,�������,�������,�������,�������,�������������,�����������,������,�����,������������,����,�����������,������ ����,�����������,����,tj,dave,alone,soul,����������,serious,damage,bringers" />
	<meta http-equiv="cache-control" content="no-cache" />
	<meta http-equiv="pragma" content="no-cache" />
	<meta http-equiv="expires" content="0" />

	<link rel="stylesheet" type="text/css" href="new_index.css" />
	<link rel="shortcut icon" href="favicon.ico" />
</head>
<body>
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
<div id="container">
	<p id="logo" style="height:250px;">
		<?//<img src="img/index_new/logo1.png" alt="">?>
	</p>
	<div id="buttonContainer">
		<form id="loginForm" action="enter.php" method="post">
			<div id="loginBox" >
				<table>
				<tr>
					<td align='right'>�����:</td><td><input type="text" name="logins" onBlur="if (value == '') {value='�����'}" onFocus="if (value == '�����') {value =''}" value="�����"class="inup" ></td>
				</tr>
				<tr>
					<td align='right'>������:</td><td><input type="password" name="psw" class="inup" ></td>
				</tr>
				<tr>
					<td><input type="submit" class="btn" value=" ����� " onclick="this.blur()"></td>
					<td><input type="button" class="btn" value=" ����������� " onclick="this.blur(); window.location.href='reg.php'"></td>
				</tr>
				</table>
			</div>
			
			
			<!--<input type="image" onmouseout="this.src='img/index_new/enter1.png'" onmouseover="this.src='img/index_new/enter2.png'" src="img/index_new/enter1.png" alt="�����" />
			!-->
		</form>
	</div>
	<br/><br/><br/><br/><br/><br/><br/><br/><br/>
	<div align='center'>
		<a href="rules.php" onclick="window.open(this.href);return false;">������</a> &nbsp;
		<a href="soqlaweniya.php" onclick="window.open(this.href);return false;">����������</a> &nbsp;
		<a href="remind.php" onclick="window.open(this.href, 'remind', 'width=500, height=230');return false;">������ ������?</a> &nbsp;
		<a href="top.php" onclick="window.open(this.href);return false;">�������</a>	&nbsp;
		<a href="http://www.meydan.az/forum/forum.php"  onclick="window.open(this.href);return false;">�����</a>
	</div>
	<div align='center'>
		<? 
			$date1=strtotime(date('d.m.Y'));
			$date2=$date1+24*60*60;
			$entered=mysql_fetch_array(mysql_query("SELECT count(*) FROM (SELECT id FROM report WHERE (UNIX_TIMESTAMP(time_stamp)>=$date1 and UNIX_TIMESTAMP(time_stamp)<$date2) and type=1 GROUP BY login) as t"));

			$all = mysql_fetch_array(mysql_query("select (SELECT count(*) FROM `users`) as us, (SELECT count(*) FROM `online`)as onl"));
			echo "<font color='#907e65'>
					����� �������: <b><u>".(int)($all["us"]+70000)."</u></b> ���. | 
					������� ��-����: <b><u>".(int)$all["onl"]."</u></b> ���. |
					������� �� �������: <b><u>".(int)$entered[0]."</u></b> ���.
					</font><br/>";
		?>
	</div>

	<div id="footer" align='center'>
		<p class="center">� Copyright 2006-<?=date("Y")?> WWW.MEYDAN.AZ - ���������� ������ ����</p>
		<?include("counter.php");?>
	</div>
</div>
</body>
</html>