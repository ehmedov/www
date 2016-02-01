<?include("key.php");
$login=$_SESSION['login'];
if(!empty($_POST['target']))
{
	$target=htmlspecialchars(addslashes($_POST['target']));
	$S="select * from users where login='".$target."' limit 1";
	$q=mysql_query($S);
	$res=mysql_fetch_array($q);
	if(!$res)
	{
		print "ѕерсонаж <B>".$target."</B> не найден в базе данных.";
		die();
	}
	if ($res['login']=="—ќ«ƒј“≈Ћ№" || ($res['login']=="bor" && $login!="bor"))
	{
		print "–едактирование богов запрещено высшей силой!";
		die();
	}
	echo "<br><table style='border:1px solid #DB9F73' width=400 align=right cellpadding=5 cellspacing=0><tr><td valign=top>";
	echo "<font color=green>Ѕанковский —чЄт <b>".$res['login']."</b>:</font><br><br>";
	$nomer = mysql_query("SELECT * FROM bank WHERE login='".$target."'");
	while ($num = mysql_fetch_array($nomer))
	{
		echo "<b>".$num['number']." - (".sprintf ("%01.2f", $num['money'])." зл. - ".sprintf ("%01.2f", $num['emoney'])." пл.</b>)<br>";
	}
	echo "</td></tr></table>";
}
?>
