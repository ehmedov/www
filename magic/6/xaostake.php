<?include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
if(!empty($target))
{
	$q=mysql_query("select * from users where login='".$target."'");
	$res=mysql_fetch_array($q);
	if(!$res)
	{
		echo "Персонаж <B>$target</B> не найден в базе данных.";die();
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
		echo "Персонаж <B>".$target."</B> не может быть выпущен из тюрьмы так как он находиться в Блоке...";
	}
	else
	{
		mysql_query("UPDATE users SET prision='0',orden='' WHERE login='".$target."'");
		$pref=$db["sex"];
		if($pref=="female")
		{
			$prefix="а";
		}
		else
		{
			$prefix="";
		}
		
		say("toall","<font color=#40404A>Смерть Души <b>&laquo;".$login."&raquo;</b> выпустил$prefix персонажа <b>&laquo;".$target."&raquo;</b> из тюрьмы.</font>",$login);
		echo "Персонаж <B>".$target."</B> на свободе.";
		history($target,"Выпустили из тюрьмы!",$reson,$ip,$login);
		history($login,"Выпустил персонажа из тюрьмы",$reson,$ip,$target);
	}
}
?>