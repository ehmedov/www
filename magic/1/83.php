<?
include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
$profession=htmlspecialchars(addslashes($_POST['profession']));
if(!empty($target))
{
	$res=mysql_fetch_array(mysql_query("SELECT * FROM users where login='".$target."'"));
	if(!$res)
	{
		echo  "Персонаж <B>".$target."</B> не найден в базе данных.";
	}
	else
	{
		mysql_query("UPDATE users SET profession='".$profession."' WHERE login='".$target."'");
		echo "Персонаж <B>".$target."</B> успешно обновлен.";
	}
}
?>