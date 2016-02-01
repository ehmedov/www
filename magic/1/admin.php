<?include("key.php");
$login=$_SESSION['login'];
$target=$_POST['target'];
$admin_level=$_POST['admin_level'];
$adminsite=$_POST['adminsite'];

if(empty($target))
{
	?>
	<body onLoad='top.cf.action=1;' onUnload='top.cf.action=0;'>
	<div align=right>
	<table border=0 class=inv width=300 height=120>
	<tr><td align=left valign=top>
	<form name='action' action='main.php?act=inkviz&spell=admin' method='post'>
	”кажите логин персонажа и уровень доступа:<BR>
	<input type=text name='target' class=button size=15>

	<select class=button name=admin_level>
	<option value=1>1
	<option value=2>2
	<option value=3>3
	<option value=4>4
	<option value=5>5
	<option value=6>6
	<option value=7>7
	<option value=8>8
	<option value=9>9
	<option value=10>10
	</select>

	<select class=button name=adminsite>
	<option value=1>1
	<option value=2>2
	<option value=3>3
	<option value=4>4
	<option value=5>5
	</select>
	<input type=submit style="height=17" value=" OK " class=button><BR>
	<span class=small>ўелкните на логин в чате.</span>
	</form>
	</td></tr>
	</table>
	<?
}
else if($db["orden"]==1 && $db["adminsite"]>=5)
{
	$S="select * from users where login='".$target."'";
	$q=mysql_query($S);
	$res=mysql_fetch_array($q);
	if(!$res)
	{
		print "ѕерсонаж <B>".$target."</B> не найден в базе данных.";
		die();
	}
	if ($res['login']=="—ќ«ƒј“≈Ћ№")
	{
			print "–едактирование богов запрещено высшей силой!";
			die();
	}
	if ($db["adminsite"]!=5)
	{	
		if($res['adminsite']>=5)
		{
			print "ѕерсонаж <B>".$target."</B> не найден в базе данных.";
			die();
		}
	}
	$sql = "UPDATE users SET orden='1',admin_level='$admin_level',adminsite='$adminsite',parent_temp='".$_SESSION["login"]."' WHERE login='$target'";
	$result = mysql_query($sql);
	print "ѕерсонаж <B>".$target."</B> прин€т в орден.";
}
?>