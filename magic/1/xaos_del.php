<?
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes(trim($_POST['target'])));
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
			echo "�������� <B>".$target."</B> �� ������ � ���� ������.";
			die();
		}
	}
	if ($res["blok"])
	{
		echo "�������� <B>".$target."</B> �� ����� ���� ������� �� ������ ��� ��� �� ���������� � �����";
	}	
	else
	{	
		if($db["adminsite"])$logins="������ ����";
		else $logins=$login;
		mysql_query("UPDATE users SET prision='0',orden='' WHERE login='".$res["login"]."'");
		$pref=$db["sex"];
		if($pref=="female")
		{
			$prefix="�";
		}
		else
		{
			$prefix="";
		}

		talk("toall","������������� ������� <b>&laquo;".$logins."&raquo;</b> ��������".$prefix." ��������� <b>&laquo;".$res["login"]."&raquo;</b> �� ������.","");
		echo "�������� <B>".$target."</B> �� �������.";
		history($target,"��������� �� ������!",$reson,$res["remote_ip"],$logins);
		history($login,"�������� ��������� �� ������",$reson,$db["remote_ip"],$target);
	}
}
?>