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
		echo "�������� <B>".$target."</B> �� ������ � ���� ������.";
		die();
	}
	if ($res['login']=="���������")
	{
		echo "�������������� ����� ��������� ������ �����!";
		die();
	}
	if ($db["adminsite"]!=5)
	{	
		if($res['adminsite']>=5 ||$res["admin_level"]>=9)
		{
			echo "�������� <B>$target</B> �� ������ � ���� ������.";
			die();
		}
	}
	mysql_query("UPDATE users SET blok='0' WHERE login='".$target."'");
	echo "�������� <b>".$target."</b> ���������.";
	history($target,"���������",$reson,$ip,$login);
	history($login,"��������� ���������",$reson,$ip,$target);
}
?>
