<?
include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
if(!empty($target))
{	
	if($db["orden"]==1 && $db["admin_level"]>=3)
	{	
		$q=mysql_query("SELECT * FROM users WHERE login='".$target."'");
		$res=mysql_fetch_array($q);
		if(!$res)
		{
			echo "�������� <B>".$target."</B> �� ������ � ���� ������.";
		}
		else if ($res["shut"]>time()+24*3600 && $db["admin_level"]<9)
		{
			echo "�������� �������� �� ����� ���� �����.";
		}
		else
		{
			if($db["adminsite"])$logins="������ ����";
			else $logins=$login;
			mysql_query("UPDATE users SET shut='0' WHERE login='".$target."'");
			talk("toall","������������� ������� <b>&laquo;".$logins."&raquo;</b> ���� �������� �������� � ��������� <b>&laquo;".$res["login"]."&raquo;</b>.","");
			history($res["login"],"����� �������� ��������",$reson,$ip,$login);
			history($login,"���� �������� ��������",$reson,$ip,$res["login"]);
			echo "�������� �������� �����.";
		}
	}
}
?>
