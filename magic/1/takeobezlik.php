<?include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
$timer=htmlspecialchars(addslashes($_POST['timer']));

if(!empty($target))
{
	$q=mysql_query("select * from users where login='".$target."'");
	$res=mysql_fetch_array($q);
	if(!$res)
	{
		echo "�������� <B>".$target."</B> �� ������ � ���� ������.";
	}
	else
	{	
		mysql_query("UPDATE users SET obezlik='0' WHERE login='".$target."'");
		say("toall","������������� ������� <b>&laquo;".$login."&raquo;</b> ������$prefix ���� ��������� <b>&laquo;".$target."&raquo</b>",$login);
		history($target,"������� ����",$reson,$res["remote_ip"],$login);
		history($login,"������ ����",$reson,$db["remote_ip"],$target);
		echo "�������� <b>".$target."</b> ������� ��������.";
	}
}
?>