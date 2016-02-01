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
		print "Персонаж <B>".$target."</B> не найден в базе данных.";
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
    	print "У персонажа <B>".$target."</B> нет такой суммы.";
    	die();
    }
    $update=mysql_query("UPDATE users SET money=money-".$zoloto." WHERE login='".$target."'");
    print "У персонажа <b>".$res['login']."</b> забрана <b>".$zoloto."</b> Зл.";
	history($_POST['target'],"Забрана ".$zoloto." Зл.",$reson,$ip,$login);
	history($login,"Забрал ".$zoloto." Зл.",$reson,$ip,$target);

}
?>
