<?include("key.php");
$login=$_SESSION['login'];
$target=$_POST['target'];
$zoloto=$_POST['zoloto'];
if(!empty($target)&& !empty($zoloto))
{
	$S="select * from users where login='".$target."'";
	$q=mysql_query($S);
	$res=mysql_fetch_array($q);
	if(!$res)
	{
		print "�������� <B>".$target."</B> �� ������ � ���� ������.";
		die();
	}
	if(!is_numeric($zoloto))
    {
    	print "����������� ������� �����!";
    	die();
    }
    if($zoloto<0)
    {
    	print "����������� ������� �����!";
    	die();
    }
	if($zoloto>$res['money'])
    {
    	print "� ��������� <B>".$target."</B> ��� ����� �����.";
    	die();
    }
    $update=mysql_query("UPDATE users SET money=money-".$zoloto." WHERE login='".$target."'");
    print "� ��������� <b>".$res['login']."</b> ������� <b>".$zoloto."</b> ��.";
	history($_POST['target'],"������� ".$zoloto." ��.",$reson,$ip,$login);
	history($login,"������ ".$zoloto." ��.",$reson,$ip,$target);

}
?>
