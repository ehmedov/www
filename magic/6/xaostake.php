<?include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
if(!empty($target))
{
	$q=mysql_query("select * from users where login='".$target."'");
	$res=mysql_fetch_array($q);
	if(!$res)
	{
		echo "�������� <B>$target</B> �� ������ � ���� ������.";die();
	}
	if ($db["adminsite"]!=5)
	{	
		if($res['adminsite']>=5 ||$res["admin_level"]>=9)
		{
			echo "�������� <B>".$target."</B> �� ������ � ���� ������.";
			die();
		}
	}
	if ($res["blok"])
	{
		echo "�������� <B>".$target."</B> �� ����� ���� ������� �� ������ ��� ��� �� ���������� � �����...";
	}
	else
	{
		mysql_query("UPDATE users SET prision='0',orden='' WHERE login='".$target."'");
		$pref=$db["sex"];
		if($pref=="female")
		{
			$prefix="�";
		}
		else
		{
			$prefix="";
		}
		
		say("toall","<font color=#40404A>������ ���� <b>&laquo;".$login."&raquo;</b> ��������$prefix ��������� <b>&laquo;".$target."&raquo;</b> �� ������.</font>",$login);
		echo "�������� <B>".$target."</B> �� �������.";
		history($target,"��������� �� ������!",$reson,$ip,$login);
		history($login,"�������� ��������� �� ������",$reson,$ip,$target);
	}
}
?>