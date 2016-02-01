<?
include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes(trim($_POST['target'])));
$target2=htmlspecialchars(addslashes(trim($_POST['target2'])));
if(!empty($target) && !empty($target2))
{
	$q=mysql_query("SELECT * FROM users LEFT JOIN info on info.id_pers=users.id WHERE login='".$target."'");
	$q2=mysql_query("SELECT * FROM users LEFT JOIN info on info.id_pers=users.id WHERE login='".$target2."'");

	$res=mysql_fetch_array($q);
	$res2=mysql_fetch_array($q2);

	if(!$res)
	{
		echo "Персонаж <B>".$target."</B> не найден в базе данных.";
	}
	else if(!$res2)
	{
		echo "Персонаж <B>".$target2."</B> не найден в базе данных.";
	}
	else if ($res['sex']!="male")
	{
		echo "У Жениха должен быть мужской пол!";
	}
	else if($res2['sex']!="female")
	{
		echo "У Невесты должен быть женский пол!";
	}
	else if($res['marry']!="")
	{
		echo "Персонаж <B>".$target."</B> уже в браке.";
	}
	else if($res2['marry']!="")
	{
		echo "Персонаж <B>".$target2."</B> уже в браке.";
	}
	else
	{
		mysql_query("UPDATE info SET marry='".$target2."' WHERE id_pers='".$res["id"]."'");
		mysql_query("UPDATE info SET marry='".$target."' WHERE id_pers='".$res2["id"]."'");
		$pref=$db["sex"];
		if($pref=="female"){$prefix="а";}else{$prefix="";}
		if($db["adminsite"])$logins="Высшая сила";	else $logins=$login;
		talk("toall","Представитель порядка <b>&laquo;".$logins."&raquo;</b> заключил$prefix брак между <b>&laquo;".$res["login"]."&raquo</b> и <b>&laquo;".$res2["login"]."&raquo</b>","");
		echo "Брак успешно заключен.";
	}
}
?>