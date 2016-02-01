<?include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
if(!empty($target))
{
	if($db["orden"]==1 && $db["admin_level"]>=4)
	{
		$result=mysql_query("select * from users where login='".$target."'");
		$res=mysql_fetch_array($result);
		mysql_free_result($result);
		if(!$res)
		{
			echo "Персонаж <B>".$target."</B> не найден в базе данных.";
			die();
		}
		mysql_query("UPDATE zver SET name='Зверь' WHERE owner='".$res['id']."'");
		echo "Вы сменили кличку!";
	}	
}
?>
