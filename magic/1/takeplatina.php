<?include("key.php");
$login=$_SESSION['login'];
$target=$_POST['target'];
$platina=$_POST['platina'];
if(!empty($target)&& !empty($platina))
{
	$S="select * from users where login='".$target."'";
	$q=mysql_query($S);
	$res=mysql_fetch_array($q);
	if(!$res)
	{
		print "Персонаж <B>".$target."</B> не найден в базе данных.";
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
	if($platina>$res['platina'])
    {
    	print "У персонажа <B>".$target."</B> нет такой суммы.";
    	die();
    }
    $update=mysql_query("UPDATE users SET platina=platina-".$platina." WHERE login='".$target."'");
    print "У персонажа <b>".$res['login']."</b> забрана <b>".$platina."</b> Пл.";
	history($_POST['target'],"Забрана ".$platina." Пл.",$reson,$ip,$login);
	history($login,"Забрал ".$platina." Пл.",$reson,$ip,$target);

}
?>
