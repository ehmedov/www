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
				echo "����� ��������...";
				history($owner,"����� ��������","�� $price ��.",$query["remote_ip"],"���������� �������");
			}
			else
			{
				echo "����� ������������";
			}
		}
		else echo "������� <B>".$owner."</B> �� ������";
	}
	else
	{
		mysql_query("INSERT INTO obraz(img,sex,price,owner) VALUES('vip/".$sex."/".$img."','".$sex."','".$price."','".$owner."')");
		echo "����� ��������...";
	}
}

?>
<form action='main.php?act=inkviz&spell=add_obraz' method='post'>
	<table border=0>
	<tr><td align=left valign=top width=120>�����:</td><td><input type=text name='img' class=new size=27></td></tr>
	<tr>
		<td>���:</td>
		<td>
			<select name=sex class=new>
				<option value="male">�������
				<option value="female">�������
			</select>
		</td>
	</tr>
	<tr><td>����:</td><td><input type=text name='price' class=new size=15></td></tr>
	<tr><td>��������:</td><td><input type=text name='owner' class=new size=15></td></tr>
	<tr><td align=center colspan=2><input type=submit value=" �������� " class=new></td></tr>
	</table>
</form>