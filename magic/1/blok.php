<?
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
$reason=htmlspecialchars(addslashes($_POST['reason']));
$reason=str_replace("\n","<br>",$reason);
$reason = str_replace("&amp;","&",$reason);
if(!empty($target))
{
	$q=mysql_query("SELECT * FROM users WHERE login='".$target."'");
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
			echo "Персонаж <B>$target</B> не найден в базе данных.";
			die();
		}
	}
	$vaxt=date("d.m.Y H:i:s");
	if($db["adminsite"])$logins="Высшая сила";
	else $logins=$login;
	mysql_query("UPDATE users SET blok='1',blok_reason='".$reason." (".$vaxt.", ".$logins.")', metka=0 WHERE login='".$target."'");
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
	talk("toall","Представитель порядка <b>&laquo;".$logins."&raquo;</b> казнил$prefix персонажа <b>&laquo;".$target."&raquo;</b>.","");
	echo "Персонаж <B>".$res["login"]."</B> казнен.";
	history($target,"КАЗНЕН",$reson,$res["remote_ip"],$logins);
	history($login,"КАЗНИЛ персонажа $target",$reson,$db["remote_ip"],$target);
}
?>