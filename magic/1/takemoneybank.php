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
		print "Банковский Счёт <B>".$bank."</B> не найден в базе данных.";
		die();
	}
	if(!is_numeric($zoloto))
    {
    	print "Неправильно введена сумма!";
    	die();
    }
    if($zoloto<0)
    {
    	print "Неправильно введена сумма!";
    	die();
    }
	if($zoloto>$res['money'])
    {
    	print "У Банковский Счёт <B>".$bank."</B> нет такой суммы.";
    	die();
    }
    $update=mysql_query("UPDATE bank SET money=money-".$zoloto." WHERE number='".$bank."'");
	history($res['login'],"У Банковский Счёт ".$bank." забрана $zoloto Зл.",$reson,$ip,$login);
	history($login,"У Банковский Счёт ".$bank." забрал $zoloto Зл.",$reson,$ip,$res['login']);
    print "У Банковский Счёт <b>".$bank."</b> забрана <b>".$zoloto."</b> Зл.";
}
?>
