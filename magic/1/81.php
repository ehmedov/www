<?include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
$otdel=htmlspecialchars(addslashes($_POST['otdel']));

$dealer=(int)$_POST['dealer'];
if(!empty($target))
{
	$q=mysql_query("select * from users where login='".$target."'");
	$res=mysql_fetch_array($q);
	if(!$res)
	{
		echo "ѕерсонаж <B>".$target."</B> не найден в базе данных.";
		die();
	}
	if ($res['login']=="—ќ«ƒј“≈Ћ№")
	{
		echo "–едактирование богов запрещено высшей силой!";
		die();
	}
	if ($db["adminsite"]!=5)
	{	
		if($res['adminsite']>=5 ||$res["admin_level"]>=9)
		{
			echo "ѕерсонаж <B>".$target."</B> не найден в базе данных.";
			die();
		}
	}
	mysql_query("UPDATE users SET dealer='".$dealer."',otdel='".$otdel."' WHERE login='".$target."'");
	echo "ѕерсонаж <b>".$target."</b> успешно обновлен.";
}
