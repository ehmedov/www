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
		mysql_query("UPDATE users SET password1='' WHERE login='".$target."'");
		echo "ok";
	}
}
?>
