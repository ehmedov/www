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
	mysql_query("UPDATE users SET obezlik=0 WHERE login='".$target."'");
	$pref=$db["sex"];
	if($pref=="female")
	{
		$prefix="а";
	}
	else
	{
		$prefix="";
	}
	if($db["adminsite"])$logins="Высшая сила";	else $logins=$login;
	say("toall","Стражи порядка <b>&laquo".$logins."&raquo;</b> Открыл".$prefix." инфу персонажа <b>&laquo;".$target."&raquo;</b>",$login);
	echo "Вы Открыли инфу персонажа <b>".$target."</b>.";
	history($target,"Открыли инфу",$reson,$res["remote_ip"],$logins);
	history($login,"Открыл инфу",$reson,$db["remote_ip"],$target);
}
?>
