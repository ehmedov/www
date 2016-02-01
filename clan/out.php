<?include('key.php');
$login=$_SESSION["login"];
$target=htmlspecialchars(addslashes($_POST['target']));
if(empty($target))
{
	?>
		<body onLoad='top.cf.action=1;' onUnload='top.cf.action=0;'>
		<table border=0 class=inv width=500 height=120>
		<tr valign=top><td align=left>
		<form name='action' action='main.php?act=clan&do=2&a=out' method='post'>
			<b>Введите Ник:</b><BR>
			<input type=text name='target' class=new size=30>
			<input type=submit style="height=17" value=" OK " class=new><BR>
			<span class=small>Щелкните на логин в чате.</span>
		</form>
		</td></tr>
		</table>
	<?
}
else if($db["glava"]==1)
{
	$S="select * from users where login='".$target."' limit 1";
	$q=mysql_query($S);
	$res=mysql_fetch_array($q);
	if(!$res)
	{
		echo "Персонаж <B>$target</B> не найден в базе данных.";
	}
	else if($res["clan_short"]!=$clan_s)
	{
		echo "Персонаж <B>$target</B> не состоит в Вашем клане";
	}
	else
	{
		mysql_query("UPDATE users SET clan='',clan_short='',chin='',orden='',clan_take='0',glava=0 WHERE login='".$res['login']."'");
		echo "Персонаж <B>".$res['login']."</B> изгнан из Ханства.";
		history($res['login'],'Изгнан из Ханства.',"Ханства ".$clan_t,$res['remote_ip'],"Глава: ".$login);
		history($login,'Изгнал из Ханства','Персонаж '.$res['login'].' изгнан из Ханства '.$clan_t,$db['remote_ip'], "Глава: ".$login);
	}
}
?>