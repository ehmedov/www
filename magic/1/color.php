<?
$target=htmlspecialchars(addslashes($_POST['target']));
if(!empty($target))
{
	$sql="update `users` set color='black' where login='".$target."'";
	$query=mysql_query($sql);
	if($query)
	{
		print "баг исправлен :)";
	}
	else
	{
		echo mysql_error();
	}
}
else
{
	?>
	<body onLoad='top.cf.action=1;' onUnload='top.cf.action=0;'>
	<div align=right>
	<table border=0 class=inv width=300 height=120>
	<tr><td align=left valign=top>
	<form name='action' action='main.php?act=inkviz&spell=color' method='post'>
	<table border=0 width=500>
	<tr>
	<td>
	Логин:
	</td>
	<td>
	<input type=text name="target" class=new size=30> <br>
	<span> Укажите логин персонажа,для испавления бага </span>
	</td>
	</tr> <tr><td>
	<input type=submit value="Исправить" class=new>
	</td></tr>
	</table>
	</form>
	<?
}
?>
