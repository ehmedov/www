<?include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
if(!empty($target))
{
	$q=mysql_query("SELECT id,password,password1,login FROM users WHERE login='$target' LIMIT 1");
	$res=mysql_fetch_array($q);
	if(!$res)
	{
		print "Персонаж <B>$target</B> не найден в базе данных.";
	}
	else
	{	
		echo "<b>Парол1</b> - |".base64_decode($res['password'])."|<br>";
		echo "<b>Парол2</b> - |".$res['password1']."|<br>";
	}
}
?>
