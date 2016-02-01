<?
include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
if(!empty($target))
{	
	if($db["orden"]==1 && $db["admin_level"]>=3)
	{	
		$q=mysql_query("SELECT * FROM users WHERE login='".$target."'");
		$res=mysql_fetch_array($q);
		if(!$res)
		{
			echo "Персонаж <B>".$target."</B> не найден в базе данных.";
		}
		else if ($res["shut"]>time()+24*3600 && $db["admin_level"]<9)
		{
			echo "Заклятие молчания не может быть снята.";
		}
		else
		{
			if($db["adminsite"])$logins="Высшая сила";
			else $logins=$login;
			mysql_query("UPDATE users SET shut='0' WHERE login='".$target."'");
			talk("toall","Представитель порядка <b>&laquo;".$logins."&raquo;</b> снял заклятие молчания с персонажа <b>&laquo;".$res["login"]."&raquo;</b>.","");
			history($res["login"],"сняли заклятие молчания",$reson,$ip,$login);
			history($login,"снял заклятие молчания",$reson,$ip,$res["login"]);
			echo "Заклятие молчания снято.";
		}
	}
}
?>
