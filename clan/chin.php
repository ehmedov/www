<?include('key.php');
$login=$_SESSION["login"];
$target=htmlspecialchars(addslashes($_POST['target']));
$new_c=htmlspecialchars(addslashes($_POST['new_c']));

if(empty($target))
{
	?>
	<body onLoad='top.cf.action=1;' onUnload='top.cf.action=0;'>
	<table border=0 class=inv width=300>
	<tr valign=top><td align=left>
	<form name='action' action='main.php?act=clan&do=2&a=chin' method='post'>
	<b>Укажите логин персонажа:</b><BR>
	<input type=text name='target' class=new size=30><BR>
	<b>Статус:</b><BR>
	<input type=text name='new_c' class=new size=30><BR>
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
	else
	{
		if ($db["clan_short"]==$res["clan_short"])
		{
	    	$sql = "UPDATE users SET chin='".$new_c."' WHERE login='".$target."'";
	    	$result = mysql_query($sql);
	    	echo "Персонажу <B>$target</B> Назначена новая Должность <B>$new_c</B>.";
    	}
    	else
    	{
    		echo "Персонаж <B>$target</B> не состоит в Вашем клане";
    	}
	}
}
?>