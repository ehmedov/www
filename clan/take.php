<?
include('key.php');
$login=$_SESSION["login"];
$clan_limit=50+$SITED['level']*5;
$SostCount = mysql_fetch_array(mysql_query("SELECT count(*) FROM users WHERE clan='".$clan_t."' and blok=0 ORDER BY glava DESC, clan_take DESC"));
//--------------------------
if ($_POST["target"])
{	
	$target=htmlspecialchars(addslashes($_POST["target"]));
	if($db["clan_take"]==1)
	{
		$q=mysql_query("SELECT * FROM users WHERE login='".$target."'");
		$res=mysql_fetch_array($q);
		if(!$res)
		{
			$msg= "�������� <B>".$target."</B> �� ������ � ���� ������.";
		}
		else if($res["level"]<8)
		{
			$msg= "����������� ������� ����� � ���� <b>8</b>";
		}
		else if($res["clan_short"]!="" || $res["orden"] || $res["dealer"])
		{
			$msg= "�������� <B>".$target."</B> ��� ������� � �����";
		}
		else if(($res["metka"]+5*24*60*60)<time())
		{
			$msg= "�������� <B>".$target."</B> �� ������ �������� <img src='img/orden/1/10.gif'><b>������ �������</b>!";
		}
		else if($SostCount[0]>=$clan_limit)
		{
			$msg= "�������� ".$clan_limit." ���.";
		}
		else if($db["money"]<100)
		{
			$msg= "� ��� ������������ �������, ��� ������ � ���� ������ �����!";
		}
		else
		{
			mysql_query("UPDATE users SET clan='".$clan_t."',clan_short='".$clan_s."',chin='����������',orden='".$orden_t."' WHERE login='".$res['login']."'");
			mysql_query("UPDATE users SET money=money-100 WHERE login='".$login."'");
			talk($res['login'],"�������� <b>".$db['login']."</b> ������ ��� � ������� <b>".$clan_t."</b>...",$res);
			$msg= "�������� <b>".$res['login']."</b> ������ � �������. � ������ ����� ����� <b>100 ��.</b>";
			history($res['login'],'������ � �������.','������� '.$clan_t,$res['remote_ip'], "�����: ".$login);
			history($login,'������ � �������.','�������� '.$res['login'].' ������ � ������� '.$clan_t,$db['remote_ip'], "�����: ".$login);
		}
	}
}
//--------------------------
echo "<font color=red>$msg</font>";
?>
<form name='slform' action='main.php?act=clan&do=3' method='POST'>
<table>
<tr valign=top>
	<td align=left>
		�� ����� � ���� ������ �����, �� ������ �������� ������� <b>100.00 ��.</b><BR>
		����� ���� ����� ������ ������ �������� � <img src='img/orden/1/10.gif'><b>������ �������</b>.<BR>
		<br><b>������� ���:</b>	<input type=text name='target' class=new size=20>
		<input type=submit value="�������" class=new><BR>
		<small>(� ��� � �������: <?=$SostCount[0]?> ���. �������� <?=$clan_limit?> ���.)</small>
		
	</td>
</tr>
</table>
</form>
<script>Hint3Name = 'target';</script>