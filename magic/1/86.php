<?include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
$timer=htmlspecialchars(addslashes($_POST['timer']));

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
	$time2=time()+$timer*3600;
	mysql_query("UPDATE users SET obezlik='".$time2."' WHERE login='".$target."'");
	if($timer==24){$days_d="�����";}
	if($timer==72){$days_d="3 ���";}
	if($timer==168){$days_d="������";}
	if($timer==360){$days_d="15 �����";}
	if($timer==744){$days_d="�����";}
	if($timer==1440){$days_d="2 ������";}
	if($timer==2160){$days_d="3 ������";}
	if($timer==4320){$days_d="6 ������";}
	if($timer==8640){$days_d="12 ������";}
	
	$pref=$db["sex"];
	if($pref=="female")
	{
		$prefix="�";
	}
	else
	{
		$prefix="";
	}
    if($obezlik==""){$obezlik_cl=" ������$prefix ���� ��������� ";}
    else if($obezlik==1){$obezlik_cl=" ������ $prefix ���� ��������� ";}
    if($db["adminsite"])$logins="������ ����";	else $logins=$login;
	say("toall","������������� ������� <b>&laquo;".$logins."&raquo;</b> ������$prefix ���� ��������� <b>&laquo;".$target."&raquo</b> �� ".$days_d."",$login);
	history($target,"������� ���� ($days_d)",$reson,$res["remote_ip"],$logins);
	history($login,"������ ���� ($days_d)",$reson,$db["remote_ip"],$target);
	echo "�������� <b>".$target."</b> ������� ��������.";
}
?>