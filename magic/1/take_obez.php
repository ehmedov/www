<?include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
if(!empty($target))
{
	$q=mysql_query("select * from users where login='".$target."'");
	$res=mysql_fetch_array($q);
	if(!$res)
	{
		echo "�������� <B>".$target."</B> �� ������ � ���� ������.";
		die();
	}
	if ($db["adminsite"]!=5)
	{	
		if($res['adminsite']>=5 ||$res["admin_level"]>=9)
		{
			echo "�������������� ����� ��������� ������ �����!";
			die();
		}
	}
	mysql_query("UPDATE users SET obezlik=0 WHERE login='".$target."'");
	$pref=$db["sex"];
	if($pref=="female")
	{
		$prefix="�";
	}
	else
	{
		$prefix="";
	}
	if($db["adminsite"])$logins="������ ����";	else $logins=$login;
	say("toall","������ ������� <b>&laquo".$logins."&raquo;</b> ������".$prefix." ���� ��������� <b>&laquo;".$target."&raquo;</b>",$login);
	echo "�� ������� ���� ��������� <b>".$target."</b>.";
	history($target,"������� ����",$reson,$res["remote_ip"],$logins);
	history($login,"������ ����",$reson,$db["remote_ip"],$target);
}
?>
