<?include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
if(!empty($target))
{
	$q=mysql_query("select * from users where login='".$target."'");
	$res=mysql_fetch_array($q);
	if(!$res)
	{
		echo "Персонаж <B>".$target."</B> не найден в базе данных.";
	}
	else
	{
		mysql_query("UPDATE zayavka SET comment = '<font color=#40404A><u>удален Смерть Души <b>".$login."</b> </u></font>'  WHERE creator='".$res['id']."'");
		echo "OK";
	}
}
?>
