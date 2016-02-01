<?
include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
$pol=htmlspecialchars(addslashes($_POST['pol']));

if(!empty($target))
{
	mysql_fetch_array(mysql_query("SELECT * FROM users WHERE login='".$target."'"));
	if(!$res)
	{
		echo "Персонаж <B>".$target."</B> не найден в базе данных.";
	}
	else 
	{	
		mysql_query("UPDATE users SET sex='".$pol."' WHERE login='".$target."'");
		echo "Персонаж <B>".$target."</B> успешно обновлен.";
		history($_POST['target'],"Сменили пол",$reson,$ip,$login);
		history($login,"Сменил пол",$reson,$ip,$_POST['target']);
	}
}
?>