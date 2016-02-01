<?include ("key.php");
$name=$_POST["name"];
$img=$_POST["img"];
$mass=$_POST["mass"];
$price=$_POST["price"];
$wish=$_POST["wish"];
$count_mag=$_POST["count_mag"];

if(!empty($name))
{
	$w0="INSERT INTO gift(name,img,wish,mass,price,is_random,g_type,g_id,type,mountown,term,msg)
	VALUES ('".$name."','upakovka/".$img."','".$wish."','".$mass."','".$price."','1','1','1','1','".$count_mag."','','')";
	$res=mysql_query($w0);
	if($res)
	{
		print "Вещь <font color=red><b>$name</font></b> кол-вом <b>$count_mag $art</b> изготовлена<br>";
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
<form name='action' action='main.php?act=inkviz&spell=add_gift' method='post'>
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
		<font color=RED><b>Wish: </b></font>
	</td>
	<td>
		<input type=text name=wish class=new size=30>
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
		<font color=RED><b>Кол-во в маге:</b></font>
	</td>
	<td>
		<input type=text name=count_mag class=new size=30 value='1'>
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
