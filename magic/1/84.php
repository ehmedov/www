<?
include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
$status=htmlspecialchars(addslashes($_POST['status']));

if(!empty($target))
{
	mysql_fetch_array(mysql_query("SELECT * FROM users WHERE login='".$target."'"));
	if(!$res)
	{
		echo "�������� <B>".$target."</B> �� ������ � ���� ������.";
	}
	else 
	{
		mysql_query("UPDATE users SET status='".$status."' WHERE login='".$target."'");
		echo  "�������� <B>".$target."</B> ������� ��������.";
	}
}
?>