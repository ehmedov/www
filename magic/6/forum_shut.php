<?include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
if(!empty($target))
{
	if($db["orden"]==6 && $db["admin_level"]>=1)
	{
		$S="select * from users where login='".$target."'";
		$q=mysql_query($S);
		$res=mysql_fetch_array($q);
		if(!$res)
		{
			print "�������� <B>".$target."</B> �� ������ � ���� ������.";
			die();
		}
		if ($res['login']=="���������")
		{
			print "�������������� ����� ��������� ������ �����!";
			die();
		}
		if ($db["adminsite"]!=5)
		{	
			if($res['adminsite']>=5 || $res["admin_level"]>=9 )
			{
				print "�������������� ����� ��������� ������ �����!";
				die();
			}
		}	
		$d=date("H.i");
		$time2=time()+$_POST['timer']*60;
		$sql = "UPDATE users SET forum_shut='".$time2."' WHERE login='".$target."'";
		$result = mysql_query($sql);

		$hours=floor($_POST['timer']/60);
		$minutes=$_POST['timer']-$hours*60;

		if($hours>0)
		{
			if($hours==2 or $hours==24)
			{
				$hours_d="$hours ����";
			}
			else
			{
				$hours_d="$hours �����";
			}
			$minutes_d="";
		}
		else
		{
			$hours_d="";
			$minutes_d="$minutes �����";
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
		if ($_POST['reason']!="")
		{	
			$reson="�������: ".htmlspecialchars(addslashes($_POST['reason']));
		}
		else $reson="";	 
		say("toall","<font color=#40404A>������ ���� <b>&quot".$login."&quot</b> �������$prefix �������� ��������� �������� �� <b>&quot".$target."&quot</b>, ������ $hours_d $minutes_d. $reson</font>",$login);
		history($target,"��������� ��������� ��������",$reson,$ip,$login);
		history($login,"�������$prefix �������� ��������� ��������",$reson,$ip,$target);
		print "�� ����� ������� $hours_d $minutes_d";
	}
}
?>
