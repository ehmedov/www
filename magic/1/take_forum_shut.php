<?include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
if(!empty($target))
{	
	if($db["orden"]==1 && $db["admin_level"]>=3)
	{
		$q=mysql_query("select * from users where login='".$target."'");
		$res=mysql_fetch_array($q);
		if(!$res)
		{
			echo "�������� <B>".$target."</B> �� ������ � ���� ������.";
		}
		else 
		{	
			mysql_query("UPDATE users SET forum_shut='0' WHERE login='".$target."'");
			say("toall","������������� ������� <b>&laquo;".$login."&raquo;</b> ���� �������� �������� � ��������� <b>&laquo;".$target."&raquo;</b>.",$login);
			history($target,"����� �������� ��������",$reson,$ip,$login);
			history($login,"���� �������� ��������",$reson,$ip,$target);
			echo "�������� �������� �����.";
		}
	}
}
?>
