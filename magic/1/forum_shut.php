<?include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
if(!empty($target))
{
	if($db["orden"]==1 && $db["admin_level"]>=1)
	{
		$q=mysql_query("SELECT * FROM users WHERE login='".$target."'");
		$res=mysql_fetch_array($q);
		if(!$res)
		{
			echo "�������� <B>".$target."</B> �� ������ � ���� ������.";
			die();
		}
		if ($db["adminsite"]!=5)
		{	
			if($res['adminsite']>=5 || $res["admin_level"]>=9 )
			{
				echo "�������������� ����� ��������� ������ �����!";
				die();
			}
		}	
		$d=date("H.i");
		$time2=time()+$_POST['timer']*60;
		mysql_query("UPDATE users SET forum_shut='".$time2."' WHERE login='".$target."'");

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
			$reson="<b>�������:</b> <i>".htmlspecialchars(addslashes($_POST['reason']))."</i>";
			$reson = str_replace("&amp;","&",$reson);
		}
		else $reson="";
		if($db["adminsite"])$logins="������ ����";
		else $logins=$login;
		talk("toall","������������� ������� <b>&quot".$logins."&quot</b> �������$prefix �������� ��������� �������� �� <b>&quot".$res['login']."&quot</b> �� $hours_d $minutes_d. $reson","");
		history($target,"��������� ��������� ��������",$reson,$ip,$logins);
		history($login,"�������$prefix �������� ��������� ��������",$reson,$ip,$target);
		echo "�� ����� ������� $hours_d $minutes_d";
	}
}
?>
