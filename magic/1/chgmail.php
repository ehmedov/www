<?include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
$email=htmlspecialchars(addslashes($_POST['email']));
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
	$sql = "UPDATE users SET mail='".$email."' WHERE login='".$target."'";
	$result = mysql_query($sql);
	history($target,"������� mail ",$reson,$ip,$login);
	history($login,"������ mail ",$reson,$ip,$target);
	print "�������� <B>".$target."</B> ������� ��������.";
}
?>