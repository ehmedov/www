<?include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
$newlogin=htmlspecialchars(addslashes($_POST['newlogin']));

if(!empty($target) && !empty($newlogin))
{
	$q=mysql_query("SELECT * FROM users WHERE login='".$target."' limit 1");
	$res=mysql_fetch_array($q);
	if(!$res)
	{
		echo  "Персонаж <B>".$target."</B> не найден в базе данных.";
		die();
	}
	$qq=mysql_query("SELECT * FROM users WHERE login='".$newlogin."' limit 1");
	$ress=mysql_fetch_array($qq);
	if($ress)
	{
		echo  "Логин <B>".$newlogin."</B> уже занят!.";
		die();
	}
	if ($db["adminsite"]!=5)
	{	
		if($res['adminsite']>=5 ||$res["admin_level"]>=9)
		{
			echo  "Персонаж <B>".$target."</B> не найден в базе данных.";
			die();
		}
	}
	mysql_query("DELETE FROM online where login='".$target."'");
	mysql_query("UPDATE users SET login='".$newlogin."' WHERE login='".$target."'");
	mysql_query("UPDATE inv SET owner='".$newlogin."' WHERE owner='".$target."'");
	mysql_query("UPDATE comok SET owner='".$newlogin."' WHERE owner='".$target."'");
	mysql_query("UPDATE bank SET login='".$newlogin."' WHERE login='".$target."'");
	mysql_query("UPDATE thread SET creator='".$newlogin."' WHERE creator='".$target."'");
	mysql_query("UPDATE topic SET login='".$newlogin."' WHERE login='".$target."'");
	mysql_query("UPDATE perevod SET login='".$newlogin."' WHERE login='".$target."'");
	mysql_query("UPDATE complect SET owner='".$newlogin."' WHERE owner='".$target."'");
	mysql_query("UPDATE friend SET login='".$newlogin."' WHERE login='".$target."'");
	mysql_query("UPDATE friend SET friend='".$newlogin."' WHERE friend='".$target."'");
	mysql_query("UPDATE bs_winner SET user='".$newlogin."' WHERE user='".$target."'");
	mysql_query("UPDATE house SET login='".$newlogin."' WHERE login='".$target."'");
	
	$txt="<font color=#ff0000>Сменили ник (<b>$target</b> на <b>$newlogin</b>)</font>";
	history($newlogin,$txt,$reson,$ip,$login);
	history($login,$txt,$reson,$ip,$newlogin);

	echo  "Персонаж <B>".$target."</B> успешно обновлен.";
}
?>