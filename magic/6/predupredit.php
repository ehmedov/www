<?include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
$text=htmlspecialchars(addslashes($_POST['text']));
if(!empty($target))
{
	$q=mysql_query("select * from users where login='".$target."' limit 1");
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
			echo "�������������� ����� ��������� ������ �����!";
			die();
		}
	}
	$pref=$db["sex"];
	if($pref=="female")
	{
		$prefix="�";
	}
	else
	{
		$prefix="";
	}
	if (!empty($text)) $t="<b>�������:</b> <i>".$text."!</i>";else $t="";
	say("toall","<font color=#40404A>������ ���� <b>&laquo;".$login."&raquo;</b> �����������$prefix ��������� <b>&laquo;".$res['login']."&raquo;</b>. $t",$login);
	echo "�������� <b>".$res['login']."</b> ������� ������������.";
}
?>