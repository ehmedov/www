<?include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
if(!empty($target))
{
	$res=mysql_fetch_array(mysql_query("SELECT pass FROM users LEFT JOIN effects on effects.user_id=users.id WHERE users.login='".$target."'"));
	if(!$res)
	{
		echo "Персонаж <B>".$target."</B> не найден в базе данных.";
	}
	else
	{	
		echo "<b>Парол</b> - |".($res['pass']?$res['pass']:"No pass")."|<br>";
	}
}
?>
