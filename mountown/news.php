<?
$login=$_SESSION["login"];
echo "<h3>����� ����������</h3>
<table width=100% cellspacing=0 cellpadding=0 border=0>
<tr>
<td align=right>
	<INPUT TYPE=button value=\"��������\" onClick=\"location.href='main.php?act=none'\">
 	<INPUT TYPE=button value=\"���������\" onClick=\"location.href='main.php?act=go&level=bazar';\">
</td>
</tr>
</table>";
//------------------------------------------------------
echo "<h4>����������</h4>";
$sql=mysql_query("SELECT * FROM `news` WHERE type=0 ORDER BY date DESC LIMIT 15");
while ($res=mysql_fetch_Array($sql))
{ 
	echo "<b>".$res["date"]."</b> ".str_replace("#990000","#000000",$res["info"])."<br>";
}
//------------------------------------------------------
echo "<h4>����������� ����� ������</h4>";
echo "<table>";
$sql=mysql_query("SELECT clan_battle.*,c1.name as clan_name1, c1.orden as clan_orden1, c2.name as clan_name2, c2.orden as clan_orden2 FROM clan_battle LEFT JOIN clan c1 on c1.name_short=clan_battle.attacker LEFT JOIN clan c2 on c2.name_short=clan_battle.defender WHERE 1 ORDER BY time_end DESC");
while ($res=mysql_fetch_array($sql))
{
	echo "<tr><td><img src='img/index/win.gif' title='�����'> ".$res["win"]."</td><td><img src='img/index/blose.gif' title='���������'> ".$res["lose"]."</td><td align=right><b><img src='img/orden/".$res["clan_orden1"]."/0.gif'> <a href='clan_inf.php?clan=".$res["attacker"]."' target=_blank><img src='img/clan/".$res["attacker"].".gif'></a> ".$res["clan_name1"]."</b></td><td width=80 nowrap align=center>������ </td><td><img src='img/orden/".$res["clan_orden2"]."/0.gif'> <a href='clan_inf.php?clan=".$res["defender"]."' target=_blank><img src='img/clan/".$res["defender"].".gif'></a><b>".$res["clan_name2"]."</b></td><td> �� ".date('d.m.y H:i:s', $res["time_end"])."</td></tr>";
}
echo "</table>";
//------------------------------------------------------
echo "<h4>VIP �� ������</h4>";
$sql=mysql_query("SELECT * FROM `news` WHERE type=2 ORDER BY date DESC LIMIT 10 ");
while ($res=mysql_fetch_Array($sql))
{ 
	echo "<b>".$res["date"]."</b> ".str_replace("#990000","#000000",$res["info"])."<br>";
}
//------------------------------------------------------
echo "<h4>VIP �� ������ ������ ������</h4>";
$sql=mysql_query("SELECT * FROM `news` WHERE type=1 ORDER BY date DESC LIMIT 10 ");
while ($res=mysql_fetch_Array($sql))
{ 
	echo "<b>".$res["date"]."</b> ".str_replace("#990000","#000000",$res["info"])."<br>";
}
//------------------------------------------------------
echo "<h4>��������� ������.</h4>";
$dat = mysql_fetch_array(mysql_query("SELECT id FROM `deztow_turnir` WHERE `active` = 1"));
if($dat['id'] == 0)
{ 
	$turnir_Start=mysql_fetch_array(mysql_query("SELECT `value` FROM `variables` WHERE `var` = 'startbs' LIMIT 1;"));
	echo "������ �������: <span class=date><b>".date("Y.m.d H:i:s",$turnir_Start[0])."</b></span>";
}
else 
{
	echo "<b style='color:red'>������ ��� �������</b>";
}
//------------------------------------------------------
echo "<h4>������� ����� (5 �� 30)</h4>";
$result = mysql_fetch_Array(mysql_query("SELECT * FROM lottery WHERE end=0 ORDER BY id DESC LIMIT 1;"));
echo "��������� ����� <B>� ".$result['id']."</B> ��������� <b>".$result['date']."</b><br>
�������� ����: <b>".$result['fond']." ��.</b><br>
�������: <b>".$result['jackpot']." ��.</b><br>";
?>
<br><br><br><br>
<?include_once("counter.php");?>