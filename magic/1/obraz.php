<?include("key.php");
$login=$_SESSION['login'];
$target=$_POST['target'];
$obraz=$_POST['obraz'];

if(!empty($target))
{
	$sql="update `users` set obraz='".$obraz."' where login='".$target."'";
	$query=mysql_query($sql);
	if($query)
	{
		print "Образ поставлен персонажу <b>".$target."</b>";
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
<form name='action' action='main.php?act=inkviz&spell=obraz' method='post'>
<table border=0 width=500>
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
		Путь к рисунку:
	</td>
	<td>
		<input type=text name="obraz" class=new size=30>
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
