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
		mysql_query("UPDATE zayavka SET comment = '<font color=#40404A><u>������ ������ ���� <b>".$login."</b> </u></font>'  WHERE creator='".$res['id']."'");
		echo "OK";
	}
}
?>
