<?
	$name=htmlspecialchars(addslashes($_POST['name']));
	$about=htmlspecialchars(addslashes($_POST['about']));
	$type=htmlspecialchars(addslashes($_POST['type']));
	
	$level=(int)$_POST['level'];
	$intellekt=(int)$_POST['intellekt'];
	$water_magic=(int)$_POST['water_magic'];
	$earth_magic=(int)$_POST['earth_magic'];
	$fire_magic=(int)$_POST['fire_magic'];
	$air_magic=(int)$_POST['air_magic'];
	$krit=(int)$_POST['krit'];
	$mag=(int)$_POST['mag'];
	$uvarot=(int)$_POST['uvarot'];
	$hit=(int)$_POST['hit'];
	$block=(int)$_POST['block'];
	$hp=(int)$_POST['hp'];
	$all_hit=(int)$_POST['all_hit'];
	$counts=(int)$_POST['counts'];
	$mana=(int)$_POST['mana'];
	$vospriyatie=(int)$_POST['vospriyatie'];
	
	if ($db["orden"]==1 && $db["admin_level"]>=10 && !empty($name))
	{
		mysql_query("INSERT INTO priem(type,name,about,level,intellekt,vospriyatie,water_magic,earth_magic,fire_magic,air_magic,krit,mag,uvarot,hit,block,hp,all_hit,count,mana) 
					VALUES('$type','$name','$about','$level','$intellekt','$vospriyatie','$water_magic','$earth_magic','$fire_magic','$air_magic','$krit','$mag','$uvarot','$hit','$block','$hp','$all_hit','$counts','$mana')");
		echo "����� ��������...";
	}

?>
<table border=0 class=inv>
<tr>
	<td align=left valign=top>
	<form action='main.php?act=inkviz&spell=add_priem' method='post'>
			�������� ������: <input type=text name='name' class=new size=27><br>
			����������: <input type=text name='about' class=new size=27><br>
			���: <input type=text name='type' class=new size=27><br>
			�����: <input type=text name='mag' class=new size=27><br>	
			���. �������: <input type=text name='level' class=new size=27><br>
			���. ���������: <input type=text name='intellekt' class=new size=27><br>
			���. ����������: <input type=text name='vospriyatie' class=new size=27><br>
			������ ����: <input type=text name='mana' class=new size=27><br>
			���������� �������� ������� ����: <input type=text name='water_magic' class=new size=27><br>
			���������� �������� ������� �����: <input type=text name='earth_magic' class=new size=27><br>
			���������� �������� ������� ����: <input type=text name='fire_magic' class=new size=27><br>
			���������� �������� ������� �������: <input type=text name='air_magic' class=new size=27><br><br>
			
			���������� �������������: <input type=text name='counts' class=new size=27><br>
			����������� ����: <input type=text name='krit' class=new size=27><br>
			����������� ������: <input type=text name='uvarot' class=new size=27><br>
			���������� ����: <input type=text name='hit' class=new size=27><br>
			�������� ����: <input type=text name='block' class=new size=27><br>
			���������� �����: <input type=text name='hp' class=new size=27><br>
			���������� �����: <input type=text name='all_hit' class=new size=27><br>
		<input type=submit value=" �������� " class=new>
	</form>
	</td>
</tr>
</table>