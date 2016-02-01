<?include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
$reason=htmlspecialchars(addslashes($_POST['reason']));
$reason=str_replace("\n","<br>",$reason);
if(!empty($target))
{
	$q=mysql_query("select * from users where login='".$target."'");
	$res=mysql_fetch_array($q);
	if(!$res)
	{
		echo "Персонаж <B>".$target."</B> не найден в базе данных.";die();
	}
	if ($res['login']=="СОЗДАТЕЛЬ")
	{
		echo "Редактирование богов запрещено высшей силой!";die();
	}
	if ($db["adminsite"]!=5)
	{	
		if($res['adminsite']>=5 ||$res["admin_level"]>=9)
		{
			echo "Персонаж <B>$target</B> не найден в базе данных.";
			die();
		}
	}
	$chas = date("H");
	$vaxt=date("d.m.Y H:i:s", mktime($chas-$GSM));
	mysql_query("UPDATE users SET blok='1',blok_reason='".$reason." (".$vaxt.", ".$login.")',metka='' WHERE login='".$target."'");
	mysql_query("DELETE FROM online WHERE login='".$target."'");
	$pref=$db["sex"];
	if($pref=="female")
	{
		$prefix="а";
	}
	else
	{
		$prefix="";
	}

	say("toall","<font color=#40404A>Смерть Души <b>&laquo;".$login."&raquo;</b> отрубил$prefix голову персонажа <b>&laquo;".$target."&raquo;</b></font>.",$login);
	echo "Персонаж <B>$target</B> казнен.";
	history($_POST['target'],"КАЗНЕН",$reson,$ip,$login);
	history($login,"КАЗНИЛ персонажа $target",$reson,$ip,$target);

}
?>
