<?$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
if(!empty($target))
{
	$q=mysql_query("SELECT * FROM users WHERE login='".$target."'");
	$res=mysql_fetch_array($q);
	if(!$res)
	{
		echo "Персонаж <B>$target</B> не найден в базе данных.";
	}
	else
	{	
		mysql_query("UPDATE users SET last_request_time=0, led_time=0, hell_time=0, izumrud_time=0, vaulttime=0 WHERE login='".$res["login"]."'");
		echo "ok";
	}
}
?>
