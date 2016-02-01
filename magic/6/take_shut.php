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
		mysql_query("UPDATE users SET shut='0' WHERE login='".$target."'");
		say("toall","<font color=#40404A>Смерть Души <b>&laquo;".$login."&raquo;</b> снял заклятие молчания с персонажа <b>&laquo;".$target."&raquo;</b>.</font>",$login);
		history($target,"сняли заклятие молчания",$reson,$ip,$login);
		history($login,"снял заклятие молчания",$reson,$ip,$target);
		echo "Заклятие молчания снято.";
	}
}
?>
