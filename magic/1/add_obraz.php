<?
$img=htmlspecialchars(addslashes($_POST['img']));
$sex=htmlspecialchars(addslashes($_POST['sex']));
$owner=htmlspecialchars(addslashes(trim($_POST['owner'])));
$price=(int)$_POST['price'];

if (!empty($img))
{
	if ($owner!="")
	{
		$query=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE login='$owner'"));
		if ($query)
		{
			if ($query["platina"]>=$price)
			{
				mysql_query("INSERT INTO obraz(img,sex,price,owner) VALUES('vip/".$sex."/".$img."','".$sex."','".$price."','".$owner."')");
				mysql_query("UPDATE users SET obraz='vip/".$sex."/".$img."',platina=platina-$price WHERE login='".$owner."'");
				echo "Образ Добавлен...";
				history($owner,"Образ Добавлен","За $price Пл.",$query["remote_ip"],"Мастерская Образов");
			}
			else
			{
				echo "Сумма недостаточно";
			}
		}
		else echo "Песонаж <B>".$owner."</B> не найден";
	}
	else
	{
		mysql_query("INSERT INTO obraz(img,sex,price,owner) VALUES('vip/".$sex."/".$img."','".$sex."','".$price."','".$owner."')");
		echo "Образ Добавлен...";
	}
}

?>
<form action='main.php?act=inkviz&spell=add_obraz' method='post'>
	<table border=0>
	<tr><td align=left valign=top width=120>Образ:</td><td><input type=text name='img' class=new size=27></td></tr>
	<tr>
		<td>Пол:</td>
		<td>
			<select name=sex class=new>
				<option value="male">Мужские
				<option value="female">Женские
			</select>
		</td>
	</tr>
	<tr><td>Цена:</td><td><input type=text name='price' class=new size=15></td></tr>
	<tr><td>Владелец:</td><td><input type=text name='owner' class=new size=15></td></tr>
	<tr><td align=center colspan=2><input type=submit value=" Добавить " class=new></td></tr>
	</table>
</form>