<?include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
if(!empty($target))
{
	$q=mysql_query("select * from users where login='".$target."'");
	$res=mysql_fetch_array($q);
	if(!$res)
	{
		echo "�������� <B>".$target."</B> �� ������ � ���� ������.";
	}
	else if ($res['login']=="���������")
	{
		echo "�������������� ����� ��������� ������ �����!";
	}
	else
	{	
		mysql_query("UPDATE users SET orden='',admin_level='0',parent_temp='',adminsite='',dealer='',sponsor='0',vip='0',otdel='' WHERE login='".$target."'");
		say("toall","�������� <b>".$target."</b> ������ �� ������ <b>�������� ����.</b>",$login);
		echo "�������� <B>".$target."</B> ������ �� ������ �������� ����.";
	}
}
?>
