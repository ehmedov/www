<?
include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
$access=htmlspecialchars(addslashes($_POST['access']));
$otdel=htmlspecialchars(addslashes($_POST['otdel']));

if(!empty($target))
{
	$q=mysql_query("SELECT * FROM users WHERE login='".$target."'");
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
			echo "�������� <B>".$target."</B> �� ������ � ���� ������.";
			die();
		}
	}
	mysql_query("UPDATE users SET orden='1', admin_level='".$access."', otdel='".$otdel."',  clan='', clan_short='' WHERE login='".$target."'");
	mysql_query("UPDATE info SET parent_temp='".$login."' WHERE id_pers=".$res["id"]);
	echo "�������� <b>".$target."</b> ������ � �����.";
}
?>