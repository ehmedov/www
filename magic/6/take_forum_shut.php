<?include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
if(!empty($target))
{	
	$S="select * from users where login='".$target."'";
	$q=mysql_query($S);
	$res=mysql_fetch_array($q);
	if(!$res)
	{
		print "Персонаж <B>".$target."</B> не найден в базе данных.";
		die();
	}
	if ($res['login']=="СОЗДАТЕЛЬ")
	{
		print "Редактирование богов запрещено высшей силой!";
		die();
	}
	if ($db["adminsite"]!=5)
	{	
		if($res['adminsite']>=5 ||$res["admin_level"]>=9)
		{
			print "Персонаж <B>".$target."</B> не найден в базе данных.";
			die();
		}
	}
	$sql = "UPDATE users SET forum_shut='0' WHERE login='".$target."'";
	$result = mysql_query($sql);
	say("toall","<font color=#40404A>Смерть Души <b>&laquo;".$login."&raquo;</b> снял форумную малчанку с персонажа <b>&laquo;".$target."&raquo;</b>.</font>",$login);
	history($target,"сняли заклятие молчания",$reson,$ip,$login);
	history($login,"снял заклятие молчания",$reson,$ip,$target);
	print "Заклятие молчания снято.";
}
?>
