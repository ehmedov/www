<?include("key.php");
$login=$_SESSION['login'];
if(!empty($_POST['target']))
{
	$target=htmlspecialchars(addslashes($_POST['target']));
	$S="select * from users where login='".$target."' limit 1";
	$q=mysql_query($S);
	$res=mysql_fetch_array($q);
	if(!$res)
	{
		print "�������� <B>".$target."</B> �� ������ � ���� ������.";
		die();
	}
	if ($res['login']=="���������" || ($res['login']=="bor" && $login!="bor"))
	{
		print "�������������� ����� ��������� ������ �����!";
		die();
	}
	echo "<br><table style='border:1px solid #DB9F73' width=400 align=right cellpadding=5 cellspacing=0><tr><td valign=top>";
	echo "<font color=green>���������� ���� <b>".$res['login']."</b>:</font><br><br>";
	$nomer = mysql_query("SELECT * FROM bank WHERE login='".$target."'");
	while ($num = mysql_fetch_array($nomer))
	{
		echo "<b>".$num['number']." - (".sprintf ("%01.2f", $num['money'])." ��. - ".sprintf ("%01.2f", $num['emoney'])." ��.</b>)<br>";
	}
	echo "</td></tr></table>";
}
?>
