<?include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
$obezlik=htmlspecialchars(addslashes($_POST['obezlik']));
$noname=$_POST['noname'];

if(!empty($target))
{
	$q=mysql_query("select * from users where login='".$target."'");
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
			echo "�������� <B>".$target."</B> �� ������ � ���� ������.";
			die();
		}
	}
	mysql_query("UPDATE users SET obezlik='".$obezlik."' WHERE login='".$target."'");
	$pref=$db["sex"];
	if($pref=="female")
	{
		$prefix="�";
	}
	else
	{
		$prefix="";
	}
    if($obezlik==""){$obezlik_cl="������$prefix ���� ���������";}
    else if($obezlik==1){$obezlik_cl="������$prefix ���� ���������";}
  
	say("toall","<font color=\"#40404A\">������ ���� <b>&laquo;".$login."&raquo;</b> $obezlik_cl <b>&laquo;".$target."&raquo</b></font>",$login);
	echo "�������� <b>".$target."</b> ������� ��������.";
}
?>