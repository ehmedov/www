<?include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
$reason=htmlspecialchars(addslashes($_POST['reason']));
$reason=str_replace("\n","<br>",$reason);
$timer=$_POST['timer'];
if(!empty($target))
{
	$q=mysql_query("select * from users where login='".$target."'");
	$res=mysql_fetch_array($q);
	if(!$res)
	{
		echo "�������� <B>".$target."</B> �� ������ � ���� ������.";
		die();
	}
	else if ($res['login']=="���������")
	{
		echo "�������������� ����� ��������� ������ �����!";
		die();
	}
	else if ($db["adminsite"]!=5)
	{	
		if($res['adminsite']>=5 ||$res["admin_level"]>=9)
		{
			echo "�������� <B>".$target."</B> �� ������ � ���� ������.";
			die();
		}
	}
	$d=date("H.i");
	$chas = date("H");
	$vaxt=date("d.m.Y H:i:s", mktime($chas-$GSM));
	$time2=time()+$timer*3600;
	mysql_query("UPDATE users SET orden='5', otdel='', admin_level='',adminsite='',clan='',clan_short='',clan_take='',parent_temp='',prision='".$time2."',prision_reason='".$reason." (".$vaxt.", ".$login.")',metka='',parent_temp='' WHERE login='".$target."'");

	$pref=$db["sex"];
	if($pref=="female")
	{
		$prefix="�";
	}
	else
	{
		$prefix="";
	}
	if($timer==24){$days_d="�����";}
	if($timer==72){$days_d="3 ���";}
	if($timer==168){$days_d="������";}
	if($timer==360){$days_d="15 �����";}
	if($timer==744){$days_d="�����";}
	if($timer==1440){$days_d="2 ������";}
	if($timer==2160){$days_d="3 ������";}
	if($timer==4320){$days_d="6 ������";}
	if($timer==8640){$days_d="12 ������";}

	say("toall","<font color=\"#40404A\">������ ���� <b>&laquo".$login."&raquo;</b> ��������".$prefix." � ������ ��������� <b>&laquo;".$target."&raquo;</b> �� ".$days_d.".</font>",$login);
	echo "�������� <b>".$target."</b> ��������� � ������.";
	history($target,"��������� � ������ ($days_d)",$reson,$ip,$login);
	history($login,"�������� � ������ ($days_d)",$reson,$ip,$target);
}
?>
