<?include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
$timer=htmlspecialchars(addslashes($_POST['timer']));
$reason=htmlspecialchars(addslashes($_POST['reason']));
if(!empty($target))
{
	if (!is_numeric($timer))
	{
		echo "Ошибка при введение \"Длительность наказания\"";
		die();
	}	
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
	$d=date("H.i");
	$time2=time()+$timer*60*60;
	mysql_query("UPDATE users SET forum_shut='".$time2."' WHERE login='".$target."'");
	if ($reason!="")
	{	
		$reson="<b>Причина:</b> <i>".$reason."</i>";	
	}
	else $reson="";	 

	$pref=$db["sex"];
	if($pref=="female")
	{
		$prefix="а";
	}
	else
	{
		$prefix="";
	}
	if($login=="ASA")$login="Высшая сила";
	say("toall","Представитель порядка <b>&laquo;".$login."&raquo;</b> наложил$prefix заклятие форумного молчания на <b>&laquo;".$target."&raquo;</b> сроком $timer часов. $reson",$login);
	history($target,"Напугать форумом",$reson,$ip,$login);
	history($login,"Напугать форумом",$reson,$ip,$target);

	echo "На <b>".$target."</b> наложено заклятие форумного молчания сроком $timer часов.";
}
?>
