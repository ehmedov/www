<?include("key.php");
$login=$_SESSION['login'];
$bank=$_POST['bank'];
$platina=$_POST['platina'];
if(!empty($bank)&& !empty($platina))
{
	$S="select * from bank where  number='".$bank."'";
	$q=mysql_query($S);
	$res=mysql_fetch_array($q);
	$target=$res['login'];
	if(!$res)
	{
		print "���������� ���� <B>".$bank."</B> �� ������ � ���� ������.";
		die();
	}
	if(!is_numeric($platina))
    {
    	print "����������� ������� �����!";
    	die();
    }
    if($platina<0)
    {
    	print "����������� ������� �����!";
    	die();
    }
	if($platina>$res['emoney'])
    {
    	print "� ���������� ���� <B>".$bank."</B> ��� ����� �����.";
    	die();
    }
    $update=mysql_query("UPDATE bank SET emoney=emoney-".$platina." WHERE number='".$bank."'");
    print "� ���������� ���� <b>".$bank."</b> ������� <b>".$platina."</b> ��.";
	history($target,"� ���������� ���� ".$bank." ������� $platina ��.",$reson,$ip,$login);
	history($login,"� ���������� ���� ".$bank." ������ $platina ��.",$reson,$ip,$target);

}
?>
