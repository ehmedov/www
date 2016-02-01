<?
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes(trim($_POST['target'])));
if(!empty($target))
{
	$q=mysql_query("SELECT * FROM users WHERE login='".$target."'");
	$res=mysql_fetch_array($q);
	if(!$res)
	{
		echo "Персонаж <B>".$target."</B> не найден в базе данных.";
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
	if ($res["blok"])
	{
		echo "Персонаж <B>".$target."</B> не может быть выпущен из тюрьмы так как он находиться в Блоке";
	}	
	else
	{	
		if($db["adminsite"])$logins="Высшая сила";
		else $logins=$login;
		mysql_query("UPDATE users SET prision='0',orden='' WHERE login='".$res["login"]."'");
		$pref=$db["sex"];
		if($pref=="female")
		{
			$prefix="а";
		}
		else
		{
			$prefix="";
		}

		talk("toall","Представитель порядка <b>&laquo;".$logins."&raquo;</b> выпустил".$prefix." персонажа <b>&laquo;".$res["login"]."&raquo;</b> из тюрьмы.","");
		echo "Персонаж <B>".$target."</B> на свободе.";
		history($target,"Выпустили из тюрьмы!",$reson,$res["remote_ip"],$logins);
		history($login,"Выпустил персонажа из тюрьмы",$reson,$db["remote_ip"],$target);
	}
}
?>