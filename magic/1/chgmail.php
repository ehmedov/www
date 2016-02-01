<?include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
$email=htmlspecialchars(addslashes($_POST['email']));
if(!empty($target))
{
	$S="select * from users where login='".$target."'";
	$q=mysql_query($S);
	$res=mysql_fetch_array($q);
	if(!$res)
	{
		print "ѕерсонаж <B>".$target."</B> не найден в базе данных.";
		die();
	}
	if ($res['login']=="—ќ«ƒј“≈Ћ№")
	{
			print "–едактирование богов запрещено высшей силой!";
			die();
	}
	if ($db["adminsite"]!=5)
	{	
		if($res['adminsite']>=5 ||$res["admin_level"]>=9)
		{
			print "ѕерсонаж <B>".$target."</B> не найден в базе данных.";
			die();
		}
	}
	$sql = "UPDATE users SET mail='".$email."' WHERE login='".$target."'";
	$result = mysql_query($sql);
	history($target,"—менили mail ",$reson,$ip,$login);
	history($login,"—менил mail ",$reson,$ip,$target);
	print "ѕерсонаж <B>".$target."</B> успешно обновлен.";
}
?>