<?include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
$text=htmlspecialchars(addslashes($_POST['text']));
if(!empty($target))
{
	$q=mysql_query("select * from users where login='".$target."' limit 1");
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
			echo "Редактирование богов запрещено высшей силой!";
			die();
		}
	}
	$pref=$db["sex"];
	if($pref=="female")
	{
		$prefix="а";
	}
	else
	{
		$prefix="";
	}
	if (!empty($text)) $t="<b>Причина:</b> <i>".$text."!</i>";else $t="";
	say("toall","<font color=#40404A>Смерть Души <b>&laquo;".$login."&raquo;</b> предупредил$prefix персонажа <b>&laquo;".$res['login']."&raquo;</b>. $t",$login);
	echo "Персонаж <b>".$res['login']."</b> успешно предупрежден.";
}
?>