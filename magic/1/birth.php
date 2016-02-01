<?include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
$birth=htmlspecialchars(addslashes($_POST['birth']));

if(!empty($target))
{
	$sql="update `users` set birthday='".$birth."' where login='".$target."'";
	$query=mysql_query($sql);
	if($query)
	{
		print "Дата рождения заменен!";
	}
	else
	{
		echo mysql_error();
	}
}
else{?>
<br>
<br>

<body onLoad='top.cf.action=1;' onUnload='top.cf.action=0;'>
<form name='action' action='main.php?act=inkviz&spell=birth' method='post'>
<table border=0 width=100%>
<tr>
	<td>
		Логин:
	</td>
	<td>
		<input type=text name="target" class=new size=30>
	</td>
</tr>
<tr>
	<td>
		Дата рождения:
	</td>
	<td>
		<input type=text name="birth" class=new size=30> <br><small>(dd.mm.yyyy -01.01.2008 bu shekilde..noqteynen)</small>
	</td>
</tr>
<tr>
	<td>
		<input type=submit value="Создать" class=new>
	</td>
</tr>
</table>
</form>
<?}?>
