<?include("key.php");
$login=$_SESSION['login'];
$target=$_POST['target'];
if(!empty($target))
{
	$S="select * from users where login='".$target."'";
	$q=mysql_query($S);
	$res=mysql_fetch_array($q);
	if(!$res)
	{
		print "�������� <B>".$target."</B> �� ������ � ���� ������.";
	}
	else
	{
		$update= mysql_query("UPDATE zayavka SET comment = '<font color=#ff0000><u>������ ������� <b>".$login."</b> </u></font>'  WHERE creator='".$res['id']."'");
		echo "OK";
	}
}
?>
