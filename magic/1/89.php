<?
include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
$pol=htmlspecialchars(addslashes($_POST['pol']));

if(!empty($target))
{
	mysql_fetch_array(mysql_query("SELECT * FROM users WHERE login='".$target."'"));
	if(!$res)
	{
		echo "�������� <B>".$target."</B> �� ������ � ���� ������.";
	}
	else 
	{	
		mysql_query("UPDATE users SET sex='".$pol."' WHERE login='".$target."'");
		echo "�������� <B>".$target."</B> ������� ��������.";
		history($_POST['target'],"������� ���",$reson,$ip,$login);
		history($login,"������ ���",$reson,$ip,$_POST['target']);
	}
}
?>