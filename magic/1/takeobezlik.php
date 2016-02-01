<?include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
$timer=htmlspecialchars(addslashes($_POST['timer']));

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
		mysql_query("UPDATE users SET obezlik='0' WHERE login='".$target."'");
		say("toall","Представитель порядка <b>&laquo;".$login."&raquo;</b> Открыл$prefix инфу персонажа <b>&laquo;".$target."&raquo</b>",$login);
		history($target,"Открыли инфу",$reson,$res["remote_ip"],$login);
		history($login,"Открыл инфу",$reson,$db["remote_ip"],$target);
		echo "Персонаж <b>".$target."</b> успешно обновлен.";
	}
}
?>