<?
include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
if(!empty($target))
{
	$res=mysql_fetch_array(mysql_query("SELECT * FROM users LEFT JOIN info on info.id_pers=users.id WHERE users.login='".$target."' limit 1"));
	if(!$res)
	{
		echo "�������� <B>".$target."</B> �� ������ � ���� ������.";
	}
	else if ($res['adminsite']>2 && $db["adminsite"]<2)
	{
		echo "�������������� ����� ��������� ������ �����!";
	}
	else
	{
		echo "
		<table><tr><td>
		<h3>����� ��������� ".$res["login"]."</h3><br>
		�������� ���������: <a href='perevod.php?tar=$target' class=us2 target='_blank'>����������</a><br>";
		echo "������: <b>".sprintf ("%01.2f", $res['money'])."</b> ��.<BR>";	
		echo "�������: <b>".sprintf ("%01.2f", $res['platina'])."</b> ��.<BR>";
		echo "<hr><font color=green>���������� ����:</font><br>";
		$nomer = mysql_query("SELECT * FROM bank WHERE login='".$target."'");
		while ($num = mysql_fetch_array($nomer))
		{
			echo "<b>".$num['number']." - (".sprintf ("%01.2f", $num['money'])." ��. - ".sprintf ("%01.2f", $num['emoney'])." ��.</b>)<br>";
		}
		if ($db["id"]==48)
		{	
			echo "<hr>";
			echo "���� ��������: <b>".$res['birth']."</b><BR>";
			echo "E-mail: <b>".$res['email']."</b><BR><BR>";
			echo "<b style='color:brown'>��������� ������� ����������</b><br>".($res["prision_reason"]?$res["prision_reason"]:"<i style='color:grey'>����</i>");
			echo "<br><br><b style='color:brown'>��������� ������� �����</b><br>".($res["blok_reason"]?$res["blok_reason"]:"<i style='color:grey'>����</i>");

			echo "<br><br><b style='color:brown'>����� ������� ������������:</b><br>";
			$lv=mysql_query("SELECT * FROM report WHERE login='".$res["login"]."' and type='1' ORDER BY time_stamp DESC LIMIT 5");
			while ($lastvisit=mysql_fetch_array($lv))
			{
				echo $lastvisit['time_stamp']." <b>".$lastvisit['action']."</b> ".$lastvisit['ip'].'<br>';
			}	
		}
		
		echo "<br></td></tr></table>";
	}
}
?>
