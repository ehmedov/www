<?include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
if(!empty($target))
{
	$q=mysql_query("select * from users where login='".$target."'");
	$res=mysql_fetch_array($q);
	if(!$res)
	{
		echo "ѕерсонаж <B>".$target."</B> не найден в базе данных.";
	}
	else if ($res['login']=="—ќ«ƒј“≈Ћ№")
	{
		echo "–едактирование богов запрещено высшей силой!";
	}
	else
	{	
		mysql_query("UPDATE users SET orden='',admin_level='0',parent_temp='',adminsite='',dealer='',sponsor='0',vip='0',otdel='' WHERE login='".$target."'");
		say("toall","ѕерсонаж <b>".$target."</b> изгнан из ордена <b>»стинный ћрак.</b>",$login);
		echo "ѕерсонаж <B>".$target."</B> изгнан из ордена »стинный ћрак.";
	}
}
?>
