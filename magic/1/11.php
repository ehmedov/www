<?
include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
if(!empty($target))
{
	$res=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE login='".$target."'"));
	if(!$res)
	{
		echo "Персонаж <B>".$target."</B> не найден в базе данных.";
	}
	else
	{
		mysql_query("UPDATE users SET metka='".time()."'  WHERE login='".$res['login']."'");
		mysql_query("INSERT INTO perevod_arch(date,login,action,item,ip,login2) SELECT perevod.date,perevod.login,perevod.action,perevod.item,perevod.ip,perevod.login2 FROM perevod WHERE login='".$res['login']."';");
		mysql_query("DELETE FROM perevod WHERE login='".$res['login']."'");
		
		history($res['login'],"Проверка","Проверка у Представителей порядка пройдена удачно. (Модератор: ".$login.")",$res["remote_ip"],"АДМИНКА");
		history($login,"Проверка","Поставил метку персонажу ".$res['login'],$db["remote_ip"],"АДМИНКА");
		echo "Метка поставлена персонажу <b>'".$res['login']."'</b>.";
	}
}
?>
