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
	}
	else 
	{
		mysql_query("UPDATE users SET shut='0' WHERE login='".$target."'");
		say("toall","<font color=#40404A>������ ���� <b>&laquo;".$login."&raquo;</b> ���� �������� �������� � ��������� <b>&laquo;".$target."&raquo;</b>.</font>",$login);
		history($target,"����� �������� ��������",$reson,$ip,$login);
		history($login,"���� �������� ��������",$reson,$ip,$target);
		echo "�������� �������� �����.";
	}
}
?>
