<?include("key.php");
define("SILENT", 30);
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
$reason=htmlspecialchars(addslashes($_POST['reason']));
if(!empty($target))
{
	if($db["orden"]==6 && $db["admin_level"]>=2)
	{
		$result=mysql_query("select * from users where login='".$target."'");
		$res=mysql_fetch_array($result);
		mysql_free_result($result);
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
		if ($res['shut']!=0)
		{
			echo "�� ��������� <b>".$res["login"]."</b> ��� �������� �������� ��������!";
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
		$time2=time()+SILENT*60;
		mysql_query("UPDATE users SET shut='".$time2."',shut_reason='".$reason."' WHERE login='".$res['login']."'");

		$hours=floor(SILENT/60);
		$minutes=SILENT-$hours*60;

		if($hours>0)
		{
			if($hours==2 || $hours==24)
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
		if ($reason!="")
		{	
			$reason_text="<b>�������:</b> <i>".$reason."</i>";
		}
		else $reason_text="";	 
		say("toall","<font color=#40404A>������ ���� <b>&quot".$login."&quot</b> �����������$prefix �������� �������� �� ��������� <b>&quot".$res['login']."&quot</b> �� $hours_d $minutes_d. $reason_text</font>",$login);
		history($target,"�������� �� 30 ���.",$reason_text,$ip,$login);
		history($login,"�������� �� 30 ���.",$reason_text,$ip,$target);		
		$time_d = $hours_d."  ".$minutes_d;
		echo "���� ������� � ��� <b>".$target."</b>. �� ����� ������� ".$time_d ;
	}
}
?>
