<?
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
$reason=htmlspecialchars(addslashes($_POST['reason']));
$reason=str_replace("\n","<br>",$reason);
$reason = str_replace("&amp;","&",$reason);
if(!empty($target))
{
	$q=mysql_query("SELECT * FROM users WHERE login='".$target."'");
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
			echo "�������� <B>$target</B> �� ������ � ���� ������.";
			die();
		}
	}
	$vaxt=date("d.m.Y H:i:s");
	if($db["adminsite"])$logins="������ ����";
	else $logins=$login;
	mysql_query("UPDATE users SET blok='1',blok_reason='".$reason." (".$vaxt.", ".$logins.")', metka=0 WHERE login='".$target."'");
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
	talk("toall","������������� ������� <b>&laquo;".$logins."&raquo;</b> ������$prefix ��������� <b>&laquo;".$target."&raquo;</b>.","");
	echo "�������� <B>".$res["login"]."</B> ������.";
	history($target,"������",$reson,$res["remote_ip"],$logins);
	history($login,"������ ��������� $target",$reson,$db["remote_ip"],$target);
}
?>