<?include("key.php");
$login=$_SESSION['login'];
$bank=$_POST['bank'];
$zoloto=$_POST['zoloto'];
if(!empty($bank)&& !empty($zoloto))
{
	$S="select * from bank where  number='".$bank."'";
	$q=mysql_query($S);
	$res=mysql_fetch_array($q);
	if(!$res)
	{
		print "���������� ���� <B>".$bank."</B> �� ������ � ���� ������.";
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
    	print "� ���������� ���� <B>".$bank."</B> ��� ����� �����.";
    	die();
    }
    $update=mysql_query("UPDATE bank SET money=money-".$zoloto." WHERE number='".$bank."'");
	history($res['login'],"� ���������� ���� ".$bank." ������� $zoloto ��.",$reson,$ip,$login);
	history($login,"� ���������� ���� ".$bank." ������ $zoloto ��.",$reson,$ip,$res['login']);
    print "� ���������� ���� <b>".$bank."</b> ������� <b>".$zoloto."</b> ��.";
}
?>
