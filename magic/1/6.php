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
		echo "Персонаж <B>".$target."</B> не найден в базе данных.";
		die();
	}
	if ($res['login']=="СОЗДАТЕЛЬ")
	{
		echo "Редактирование богов запрещено высшей силой!";
		die();
	}
	if ($db["adminsite"]!=5)
	{	
		if($res['adminsite']>=5 ||$res["admin_level"]>=9)
		{
			echo "Персонаж <B>$target</B> не найден в базе данных.";
			die();
		}
	}
	mysql_query("UPDATE users SET blok='0' WHERE login='".$target."'");
	echo "Персонаж <b>".$target."</b> воскрешен.";
	history($target,"ВОСКРЕШЕН",$reson,$ip,$login);
	history($login,"Воскресил персонажа",$reson,$ip,$target);
}
?>
