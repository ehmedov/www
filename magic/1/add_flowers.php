<?
include ("key.php");
$name=$_POST["name"];
$img=$_POST["img"];
$mass=$_POST["mass"];
$price=$_POST["price"];
$iznos_max=$_POST["iznos_max"];
$count_mag=$_POST["count_mag"];
$type=$_POST["type"];
$is_art=$_POST["art"];
if(!empty($name))
{
	$w0="INSERT INTO flower(name,img,mass,price,term,mountown,type,art) 
	VALUES ('".$name."','gift/".$img."','".$mass."','".$price."','".$iznos_max."','".$count_mag."','".$type."','".$is_art."')";
	$res=mysql_query($w0);
	if($res)
	{
		echo "Вещь <font color=red><b>$name</font></b> кол-вом <b>$count_mag $art</b> изготовлена<br>";
	}
	else
	{
		echo $w0."<br>";
		echo mysql_error();
	}
}
else
{
?>
<form name='action' action='main.php?act=inkviz&spell=add_flowers' method='post'>
<table border=0 width=500>
<tr>
	<td>
		<font color=RED><b>Название: </b></font>
	</td>
	<td>
		<input type=text name=name class=new size=30>
	</td>
</tr>
<tr>
	<td>
		<font color=RED><b>Путь к рисунку: </b></font
	</td>
	<td>
		<input type=text name=img class=new size=30>
	</td>
</tr>
<tr>
	<td>
		<font color=RED><b>Цена: </b></font>
	</td>
	<td>
		<input type=text name=price class=new size=30>
	</td>
</tr>
<tr>
	<td>
		<font color=RED><b>Масса:</b><font>
	</td>
	<td>
		<input type=text name=mass class=new size=30 value='1'>
	</td>
</tr>
	
<tr>
<td>
	<font color=RED><b>Износ: </b><font>
</td>
<td>
	<input type=text name=iznos_max class=new size=30 value='10'>
</td>
</tr>	
<tr>
	<td>
		<font color=RED><b>Кол-во в маге:</b></font>
	</td>
	<td>
		<input type=text name=count_mag class=new size=30 value='100000'>
	</td>
</tr>
	
<tr>
	<td>
		<font color=RED><b>Тип предмета:</b></font>
	</td>
	<td>
		<select name=type class=new>
			<option value="1">Цветы
			<option value="2">Открытки
			<option value="3">Аксессуары
			<option value="4">Подарки
			<option value="5">Национальные
			<option value="6">Новогодние
			<option value="7">Валентинки
			<option value="8">Уникальные подарки
			<option value="9" selected>Летние подарки
		</select>
	</td>
</tr>
	
<tr>
<td>
Артефактная вещь:
</td>
<td>
<select name=art class=new>
	<option value='0' selected>NO
	<option value='1'>YES
</select>
</td>
</tr>	
	
<tr>
	<td>
		<input type=submit value="Создать" class=new>
	</td>
</tr>
</table>
</form>

<?
}
?>
