<?include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
$new_pass=htmlspecialchars(addslashes($_POST['new_pass']));
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
	$sql = "UPDATE users SET password='".base64_encode($new_pass)."' WHERE login='".$target."'";
	$result = mysql_query($sql);
	history($target,"������� ������",$reson,$ip,$login);
	history($login,"������ ������",$reson,$ip,$target);
	print "�������� <B>".$target."</B> ������� ��������.";
}
?>