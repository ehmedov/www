<?
include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes(trim($_POST['target'])));
$target2=htmlspecialchars(addslashes(trim($_POST['target2'])));
if(!empty($target) && !empty($target2))
{
	$q=mysql_query("SELECT * FROM users LEFT JOIN info on info.id_pers=users.id WHERE login='".$target."'");
	$q2=mysql_query("SELECT * FROM users LEFT JOIN info on info.id_pers=users.id WHERE login='".$target2."'");

	$res=mysql_fetch_array($q);
	$res2=mysql_fetch_array($q2);

	if(!$res)
	{
		echo "�������� <B>".$target."</B> �� ������ � ���� ������.";
	}
	else if(!$res2)
	{
		echo "�������� <B>".$target2."</B> �� ������ � ���� ������.";
	}
	else if ($res['sex']!="male")
	{
		echo "� ������ ������ ���� ������� ���!";
	}
	else if($res2['sex']!="female")
	{
		echo "� ������� ������ ���� ������� ���!";
	}
	else if($res['marry']!="")
	{
		echo "�������� <B>".$target."</B> ��� � �����.";
	}
	else if($res2['marry']!="")
	{
		echo "�������� <B>".$target2."</B> ��� � �����.";
	}
	else
	{
		mysql_query("UPDATE info SET marry='".$target2."' WHERE id_pers='".$res["id"]."'");
		mysql_query("UPDATE info SET marry='".$target."' WHERE id_pers='".$res2["id"]."'");
		$pref=$db["sex"];
		if($pref=="female"){$prefix="�";}else{$prefix="";}
		if($db["adminsite"])$logins="������ ����";	else $logins=$login;
		talk("toall","������������� ������� <b>&laquo;".$logins."&raquo;</b> ��������$prefix ���� ����� <b>&laquo;".$res["login"]."&raquo</b> � <b>&laquo;".$res2["login"]."&raquo</b>","");
		echo "���� ������� ��������.";
	}
}
?>