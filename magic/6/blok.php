<?include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
$reason=htmlspecialchars(addslashes($_POST['reason']));
$reason=str_replace("\n","<br>",$reason);
if(!empty($target))
{
	$q=mysql_query("select * from users where login='".$target."'");
	$res=mysql_fetch_array($q);
	if(!$res)
	{
		echo "�������� <B>".$target."</B> �� ������ � ���� ������.";die();
	}
	if ($res['login']=="���������")
	{
		echo "�������������� ����� ��������� ������ �����!";die();
	}
	if ($db["adminsite"]!=5)
	{	
		if($res['adminsite']>=5 ||$res["admin_level"]>=9)
		{
			echo "�������� <B>$target</B> �� ������ � ���� ������.";
			die();
		}
	}
	$chas = date("H");
	$vaxt=date("d.m.Y H:i:s", mktime($chas-$GSM));
	mysql_query("UPDATE users SET blok='1',blok_reason='".$reason." (".$vaxt.", ".$login.")',metka='' WHERE login='".$target."'");
	mysql_query("DELETE FROM online WHERE login='".$target."'");
	$pref=$db["sex"];
	if($pref=="female")
	{
		$prefix="�";
	}
	else
	{
		$prefix="";
	}

	say("toall","<font color=#40404A>������ ���� <b>&laquo;".$login."&raquo;</b> �������$prefix ������ ��������� <b>&laquo;".$target."&raquo;</b></font>.",$login);
	echo "�������� <B>$target</B> ������.";
	history($_POST['target'],"������",$reson,$ip,$login);
	history($login,"������ ��������� $target",$reson,$ip,$target);

}
?>
