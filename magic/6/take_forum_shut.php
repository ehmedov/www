<?include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
if(!empty($target))
{	
	$S="select * from users where login='".$target."'";
	$q=mysql_query($S);
	$res=mysql_fetch_array($q);
	if(!$res)
	{
		print "�������� <B>".$target."</B> �� ������ � ���� ������.";
		die();
	}
	if ($res['login']=="���������")
	{
		print "�������������� ����� ��������� ������ �����!";
		die();
	}
	if ($db["adminsite"]!=5)
	{	
		if($res['adminsite']>=5 ||$res["admin_level"]>=9)
		{
			print "�������� <B>".$target."</B> �� ������ � ���� ������.";
			die();
		}
	}
	$sql = "UPDATE users SET forum_shut='0' WHERE login='".$target."'";
	$result = mysql_query($sql);
	say("toall","<font color=#40404A>������ ���� <b>&laquo;".$login."&raquo;</b> ���� �������� �������� � ��������� <b>&laquo;".$target."&raquo;</b>.</font>",$login);
	history($target,"����� �������� ��������",$reson,$ip,$login);
	history($login,"���� �������� ��������",$reson,$ip,$target);
	print "�������� �������� �����.";
}
?>
