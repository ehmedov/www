<?
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
$timer=(int)$_POST['timer'];
$reason=htmlspecialchars(addslashes($_POST['reason']));
if(!empty($target) && $timer>0)
{
	$res=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE login='".$target."'"));
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
	$time2=time()+$timer*3600;
	mysql_query("UPDATE users SET shut='".$time2."', shut_reason='".$reason."' WHERE login='".$target."'");
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
	if($db["adminsite"])$logins="Высшая сила";
	else $logins=$login;
	talk("toall","Представитель порядка <b>&laquo".$logins."&raquo;</b> наложил$prefix заклятие молчания на персонажа <b>&laquo;".$target."&raquo;</b> сроком $timer часов. $reson","");
	
	history($target, "Напугали", $reson, $res["remote_ip"], $logins);
	history($login, "Напугал", $reson, $db["remote_ip"], $target);

	echo "На <b>".$target."</b> наложено заклятие молчания сроком $timer часов.";
}
?>
