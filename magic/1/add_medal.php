<?
	$name=htmlspecialchars(addslashes($_POST['name']));
	$img=htmlspecialchars(addslashes($_POST['img']));

?>
<table border=0 class=inv width=300 height=120>
<tr>
	<td align=left valign=top>
	<form action='main.php?act=inkviz&spell=add_medal' method='post'>
		Названия Медалья: <input type=text name='name' class=new size=27><br>
		Укажите Изображения: <input type=text name='img' class=new size=27><br>
		<input type=submit value=" Применить " class=new>
	</form>
	</td>
</tr>
</table>
<?
if ($db["orden"]==1 && $db["admin_level"]>=10 && !empty($name) && !empty($img))
{
	$result = mysql_query("INSERT INTO medal(name,img) VALUES('$name','img/medal/$img')");
	print "Медаль Добавлен...";
}
?>