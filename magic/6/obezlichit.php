<?include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
$obezlik=htmlspecialchars(addslashes($_POST['obezlik']));
$noname=$_POST['noname'];

if(!empty($target))
{
	$q=mysql_query("select * from users where login='".$target."'");
	$res=mysql_fetch_array($q);
	if(!$res)
	{
		echo "Персонаж <B>".$target."</B> не найден в базе данных.";
		die();
	}
	if ($res['login']=="СОЗДАТЕЛЬ")
	{
		echo "Редактирование богов запрещено высшей силой!";
		die();
	}
	if ($db["adminsite"]!=5)
	{	
		if($res['adminsite']>=5 ||$res["admin_level"]>=9)
		{
			echo "Персонаж <B>".$target."</B> не найден в базе данных.";
			die();
		}
	}
	mysql_query("UPDATE users SET obezlik='".$obezlik."' WHERE login='".$target."'");
	$pref=$db["sex"];
	if($pref=="female")
	{
		$prefix="а";
	}
	else
	{
		$prefix="";
	}
    if($obezlik==""){$obezlik_cl="Открыл$prefix инфу персонажа";}
    else if($obezlik==1){$obezlik_cl="Закрыл$prefix инфу персонажа";}
  
	say("toall","<font color=\"#40404A\">Смерть Души <b>&laquo;".$login."&raquo;</b> $obezlik_cl <b>&laquo;".$target."&raquo</b></font>",$login);
	echo "Персонаж <b>".$target."</b> успешно обновлен.";
}
?>