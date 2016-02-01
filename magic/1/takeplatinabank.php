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
		print "Банковский Счёт <B>".$bank."</B> не найден в базе данных.";
		die();
	}
	if(!is_numeric($platina))
    {
    	print "Неправильно введена сумма!";
    	die();
    }
    if($platina<0)
    {
    	print "Неправильно введена сумма!";
    	die();
    }
	if($platina>$res['emoney'])
    {
    	print "У Банковский Счёт <B>".$bank."</B> нет такой суммы.";
    	die();
    }
    $update=mysql_query("UPDATE bank SET emoney=emoney-".$platina." WHERE number='".$bank."'");
    print "У Банковский Счёт <b>".$bank."</b> забрана <b>".$platina."</b> Пл.";
	history($target,"У Банковский Счёт ".$bank." забрана $platina Пл.",$reson,$ip,$login);
	history($login,"У Банковский Счёт ".$bank." забрал $platina Пл.",$reson,$ip,$target);

}
?>
