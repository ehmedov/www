<?include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
$otdel=htmlspecialchars(addslashes($_POST['otdel']));
$access=(int)$_POST['access'];
if(!empty($target))
{
	$q=mysql_query("select * from users where login='".$target."'");
	$res=mysql_fetch_array($q);
	mysql_free_result($q);
	if(!$res)
	{
		echo "�������� <B>".$target."</B> �� ������ � ���� ������.";die();
	}
	if ($res['login']=="���������")
	{
		echo "�������������� ����� ��������� ������ �����!";die();
	}
	if ($db["adminsite"]!=5)
	{
		if($res['adminsite']>=5 ||$res["admin_level"]>=9)
		{
			echo "�������� <B>".$target."</B> �� ������ � ���� ������.";
			die();
		}
	}
	mysql_query("UPDATE users SET orden='6',admin_level='".$access."',otdel='".$otdel."',parent_temp='".$login."',clan='',clan_short='' WHERE login='".$target."'");
	say("toall","�������� <b>".$target."</b> ������ � ����� <b>�������� ����.</b>",$login);
	echo "�������� <b>".$target."</b> ������ � ����� �������� ����.";

}
?>