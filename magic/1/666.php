<?
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
$timer=(int)$_POST['timer'];
$reason=htmlspecialchars(addslashes($_POST['reason']));
if(!empty($target) && $timer>0)
{
	$res=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE login='".$target."'"));
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
	$time2=time()+$timer*3600;
	mysql_query("UPDATE users SET shut='".$time2."', shut_reason='".$reason."' WHERE login='".$target."'");
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
	if($db["adminsite"])$logins="������ ����";
	else $logins=$login;
	talk("toall","������������� ������� <b>&laquo".$logins."&raquo;</b> �������$prefix �������� �������� �� ��������� <b>&laquo;".$target."&raquo;</b> ������ $timer �����. $reson","");
	
	history($target, "��������", $reson, $res["remote_ip"], $logins);
	history($login, "�������", $reson, $db["remote_ip"], $target);

	echo "�� <b>".$target."</b> �������� �������� �������� ������ $timer �����.";
}
?>
