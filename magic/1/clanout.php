<?include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
if(!empty($target))
{
	$q=mysql_query("select * from users where login='".$target."' limit 1");
	$res=mysql_fetch_array($q);
	if(!$res)
	{
		echo "Персонаж <B>".$target."</B> не найден в базе данных.";
	}
	else if ($res['orden']==1 || $res['orden']==6 || $res['orden']==5)
	{
		echo "Невозможно изгнать из клана. Редактирование богов запрещено высшей силой!";
	}
	else
	{	
		$ip=$res["remote_ip"];
		$ip_me=$db["remote_ip"];
		$sql = "UPDATE users SET clan='',clan_short='',chin='',orden='',clan_take='' WHERE login='".$target."'";
		$result = mysql_query($sql);
		echo "Персонаж <B>".$target."</B> изгнан из клана.";
		history($target,"Изгнан из клана",$reson,$ip,$login);
		history($login,"Изгнал из клана",$reson,$ip_me,$target);

	}
}
?>
