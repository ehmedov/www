<?include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
$timer=htmlspecialchars(addslashes($_POST['timer']));
$reason=htmlspecialchars(addslashes($_POST['reason']));
if(!empty($target))
{
	if (!is_numeric($timer))
	{
		echo "������ ��� �������� \"������������ ���������\"";
		die();
	}	
	$q=mysql_query("select * from users where login='".$target."'");
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
			echo "�������������� ����� ��������� ������ �����!";
			die();
		}
	}
	$d=date("H.i");
	$time2=time()+$timer*60*60;
	mysql_query("UPDATE users SET forum_shut='".$time2."' WHERE login='".$target."'");
	if ($reason!="")
	{	
		$reson="<b>�������:</b> <i>".$reason."</i>";	
	}
	else $reson="";	 

	$pref=$db["sex"];
	if($pref=="female")
	{
		$prefix="�";
	}
	else
	{
		$prefix="";
	}
	if($login=="ASA")$login="������ ����";
	say("toall","������������� ������� <b>&laquo;".$login."&raquo;</b> �������$prefix �������� ��������� �������� �� <b>&laquo;".$target."&raquo;</b> ������ $timer �����. $reson",$login);
	history($target,"�������� �������",$reson,$ip,$login);
	history($login,"�������� �������",$reson,$ip,$target);

	echo "�� <b>".$target."</b> �������� �������� ��������� �������� ������ $timer �����.";
}
?>
