<?
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
$reason=htmlspecialchars(addslashes($_POST['reason']));
$reason=str_replace("\n","<br>",$reason);
$reason = str_replace("&amp;","&",$reason);
$timer=htmlspecialchars(addslashes($_POST['timer']));
if(!empty($target))
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
		if($res['adminsite']>=5 ||$res["admin_level"]>=9)
		{
			echo "�������������� ����� ��������� ������ �����!";
			die();
		}
	}
	$vaxt=date("d.m.Y H:i:s");
	$time2=time()+$timer*3600;
	if($db["adminsite"])$logins="������ ����";
	else $logins=$login;
	mysql_query("UPDATE users SET orden='5',otdel='',admin_level='',adminsite='',clan='',clan_short='',clan_take='',prision='".$time2."',prision_reason='".$reason." (".$vaxt.", ".$logins.")', metka=0 WHERE login='".$target."'");
	mysql_query("UPDATE info SET parent_temp='' WHERE id_pers=".$res["id"]);
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
	if($timer==17280){$days_d="2 ����";}
	
	talk("toall","������������� ������� <b>&laquo".$logins."&raquo;</b> ��������".$prefix." � ������ ��������� <b>&laquo;".$target."&raquo;</b> �� ".$days_d.".","");
	echo "�������� <b>".$target."</b> ��������� � ������.";
	history($target,"��������� � ������ (".$days_d.")",$reason,$res["remote_ip"],$logins);
	history($login,"�������� � ������ (".$days_d.")",$reason,$db["remote_ip"],$target);
}
?>
