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
		echo "Персонаж <B>".$target."</B> не найден в базе данных.";
		die();
	}
	if(!is_numeric($zoloto))
    {
    	echo "Неправильно введена сумма!";
    	die();
    }
    if($zoloto<0)
    {
    	echo "Неправильно введена сумма!";
    	die();
    }
	if($zoloto>$res['naqrada'])
    {
    	echo "У персонажа <B>".$target."</B> нет такой суммы.";
    	die();
    }
    $update=mysql_query("UPDATE users SET naqrada=naqrada-".$zoloto." WHERE login='".$target."'");
    echo "У персонажа <b>".$res['login']."</b> забрана <b>".$zoloto."</b> Ед.";
	history($_POST['target'],"Забрана ".$zoloto." Ед.",$reson,$ip,$login);
	history($login,"Забрал ".$zoloto." Ед.",$reson,$ip,$target);
}
?>
