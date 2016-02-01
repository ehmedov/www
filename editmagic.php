<?
session_start();
if ($_SESSION["login"]!="bor" && $_SESSION["login"]!="OBITEL")
{
	die("No Hack");
}
?>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<meta http-equiv="Content-Language" content="ru">
<LINK REL=StyleSheet HREF='main.css' TYPE='text/css'>
<body bgcolor=#dddddd>
<?
include("conf.php");
$data = mysql_connect($base_name, $base_user, $base_pass);
if(!mysql_select_db($db_name,$data))
{
	echo mysql_error();
	die();
}

$name=$_POST["name"];
$img=$_POST["img"];
$mass=$_POST["mass"];
$price=$_POST["price"];
$mtype=$_POST["mtype"];
$min_level=$_POST["min_level"];
$type=$_POST["type"];
$count_mag=$_POST["count_mag"];
$need_orden=$_POST["need_orden"];
$desc=$_POST["desc"];
$files=$_POST["files"];
$min_intellekt=$_POST["min_intellekt"];
$min_vospriyatie=$_POST["min_vospriyatie"];
$art=$_POST["art"];
$otdel=$_POST["otdel"];
$iznos_max=$_POST["iznos_max"];
$ztype=$_POST["ztype"];
$add_energy=$_POST["add_energy"];
$to_book=$_POST["to_book"];
$del_time=$_POST["del_time"];
$item=(int)$_GET['item'];
$mana=$_POST["mana"];

if($_REQUEST['edit'])
{
	$sql="UPDATE scroll SET name='$name',img='$img',mtype='$mtype',mass='$mass',price='$price',min_level='$min_level',type='$type',iznos_max='$iznos_max',
	mountown='$count_mag',orden='$need_orden',descs='$desc',files='$files',min_intellekt='$min_intellekt',min_vospriyatie='$min_vospriyatie',mana='$mana',art='$art',otdel='$otdel',
	add_energy='$add_energy',ztype='$ztype',to_book='$to_book',del_time='$del_time' WHERE id=$item";

	$res=mysql_query($sql);
	if($res)
	{
		echo "ВЕЩЬ <font color=red><b>".$name."</font></b> UPDATED<br>";
		unset($_REQUEST['edit']);
	}
	else
	{
		echo mysql_error();
	}
	echo "<br>";
	#mysql_query("UPDATE inv SET term=".(time()+$del_time*24*3600)." WHERE object_razdel='magic' and object_id=$item");
}
$res=mysql_query("SELECT * FROM scroll WHERE id='".$item."' limit 1");
$sel=mysql_fetch_array($res);
mysql_free_result($res);
?>
<form  method="POST">
	<table border=0 width=500>
	<tr>
		<td>
		<font color=RED><b>Название: </b></font>
		</td>
		<td>
		<input type=text name=name class=new size=30 value="<?echo $sel['name'];?>">
		</td>
	</tr>
	<tr>
		<td>
		<font color=RED><b>Путь к рисунку: </b></font
		</td>
		<td>
		<input type=text name=img class=new size=30 value="<?echo $sel['img'];?>">
		</td>
	</tr>
	<tr>
		<td>
		<font color=RED><b>Magic Type: </b></font
		</td>
		<td>
		<input type=text name=mtype class=new size=30 value="<?echo $sel['mtype'];?>">
		</td>
	</tr>
	<tr>
		<td>
		<font color=RED><b>Масса:</b><font>
		</td>
		<td>
		<input type=text name=mass class=new size=30 value="<?echo $sel['mass'];?>">
		</td>
	</tr>
	<tr>
		<td>
		<font color=RED><b>Износ: </b><font>
		</td>
		<td>
		<input type=text name=iznos_max class=new size=30 value="<?echo $sel['iznos_max'];?>">
		</td>
	</tr>	
	<tr>
		<td>
		<font color=RED><b>Цена: </b></font>
		</td>
		<td>
		<input type=text name=price class=new size=30 value="<?echo $sel['price'];?>">
		</td>
	</tr>
	<tr>
		<td>
		Мин. уровень:
		</td>
		<td>
		<input type=text name=min_level class=new size=30 value="<?echo $sel['min_level'];?>">
		</td>
	</tr>
	<tr>
		<td>
		Мин. интеллект:
		</td>
		<td>
		<input type=text name=min_intellekt class=new size=30 value="<?echo $sel['min_intellekt'];?>">
		</td>
	</tr>
	<tr>
		<td>
		Мин. Восприятие:
		</td>
		<td>
		<input type=text name=min_vospriyatie class=new size=30 value="<?echo $sel['min_vospriyatie'];?>">
		</td>
	</tr>
	<tr>
		<td>
		Исп. маны:
		</td>
		<td>
		<input type=text name=mana class=new size=30 value="<?echo $sel['mana'];?>">
		</td>
	</tr>
	<tr>
		<td>
		<font color=RED><b>Кол-во в маге:</b></font>
		</td>
		<td>
		<input type=text name=count_mag class=new size=30 value="<?echo $sel['mountown'];?>">
		</td>
	</tr>
	<tr>
		<td>
		<font color=RED><b>Файл:</b></font>
		</td>
		<td>
		<input type=text name=files class=new size=30 value="<?echo $sel['files'];?>">
		</td>
	</tr>
	<tr>
		<td>
		<font color=RED><b>DESC:</b></font>
		</td>
		<td>
		<textarea name=desc class=new cols=60 rows=5><?=$sel['descs'];?></textarea>
		</td>
	</tr>
	
	<tr>
		<td>
		<font color=RED><b>Срок годности (дн.):</b></font>
		</td>
		<td>
		<input type=text name=del_time class=new size=30 value="<?echo $sel['del_time'];?>">
		</td>
	</tr>
			
	<tr>
	<td>
		<font color=RED><b>Отдел:</b></font>
		</td>
		<td>
		<select name=otdel class=new>
			<option value=0 <?echo ($sel['otdel']==0?"selected":"")?>>Зелья
			<option value=1 <?echo ($sel['otdel']==1?"selected":"")?>>Восстановление
			<option value=2 <?echo ($sel['otdel']==2?"selected":"")?>>Разрушение
			<option value=3 <?echo ($sel['otdel']==3?"selected":"")?>>Ремесленные
			<option value=4 <?echo ($sel['otdel']==4?"selected":"")?>>Боевые
			<option value=5 <?echo ($sel['otdel']==5?"selected":"")?>>Клановые Абилити
			<option value=6 <?echo ($sel['otdel']==6?"selected":"")?>>Животные
			<option value=7 <?echo ($sel['otdel']==7?"selected":"")?>>Еда для Животных
			<option value=8 <?echo ($sel['otdel']==8?"selected":"")?>>Статовые
			<option value=9 <?echo ($sel['otdel']==9?"selected":"")?>>Защитные
			<option value=10 <?echo ($sel['otdel']==10?"selected":"")?>>Владения навыками
			<option value=11 <?echo ($sel['otdel']==11?"selected":"")?>>Книжные
		</td>
	</tr>
	<tr>
		<td>
		<font color=RED><b>ART:</b></font>
		</td>
		<td>
		<select name=art class=new>
			<option value=0>НЕТ
			<option value=1 <?echo ($sel['art']?"selected":"")?>>ДА
		</td>
	</tr>
	<tr>
		<td>
		<font color=RED><b>Свиток:</b></font>
		</td>
		<td>
		<select name=to_book class=new>
		<option value=0>НЕТ
		<option value=1 <?echo ($sel['to_book']?"selected":"")?>>ДА
		</td>
	</tr>
	<tr>
		<td>
		<font color=RED><b>TYPE:</b></font>
		</td>
		<td>
		<select name="type" class=new>
		<option value="scroll" 	<?echo ($sel['type']=='scroll'?"selected":"")?>>scroll
		<option value="ability" <?echo ($sel['type']=='ability'?"selected":"")?>>ability
		<option value="food" 	<?echo ($sel['type']=='food'?"selected":"")?>>food
		<option value="wolf" 	<?echo ($sel['type']=='wolf'?"selected":"")?>>wolf
		<option value="cheetah" <?echo ($sel['type']=='cheetah'?"selected":"")?>>cheetah
		<option value="bear" 	<?echo ($sel['type']=='bear'?"selected":"")?>>bear
		<option value="dragon" 	<?echo ($sel['type']=='dragon'?"selected":"")?>>dragon
		<option value="snake" 	<?echo ($sel['type']=='snake'?"selected":"")?>>snake
		</td>
	</tr>
	<tr>
		<td>
		<font color=RED><b>Тип Еды:</b></font>
		</td>
		<td>
		<select name=ztype class=new>
		<option value="">
		<option value="wolf"	<?echo ($sel['ztype']=='wolf'?"selected":"")?>>wolf
		<option value="cheetah"	<?echo ($sel['ztype']=='cheetah'?"selected":"")?>>cheetah
		<option value="bear"	<?echo ($sel['ztype']=='bear'?"selected":"")?>>bear
		<option value="dragon"	<?echo ($sel['ztype']=='dragon'?"selected":"")?>>dragon
		<option value="snake"	<?echo ($sel['ztype']=='snake'?"selected":"")?>>snake
		</td>
	</tr>
	<tr>
		<td>
		<font color=RED><b>Сытость:</b></font>
		</td>
		<td>
		<select name=add_energy class=new>
		<option value="">
		<option value="5"	<?echo ($sel['add_energy']=='5'?"selected":"")?>>5
		<option value="10"	<?echo ($sel['add_energy']=='10'?"selected":"")?>>10
		<option value="15"	<?echo ($sel['add_energy']=='15'?"selected":"")?>>15
		<option value="20"	<?echo ($sel['add_energy']=='20'?"selected":"")?>>20
		</td>
	</tr>
	<tr>
		<td>
		Склонность:
		</td>
		<td>
		<select name=need_orden class=new>
		<option value=0>нет
		<option value=1	<?echo ($sel['orden']=='1'?"selected":"")?>>Стражи порядка
		<option value=2	<?echo ($sel['orden']=='2'?"selected":"")?>>Вампиры
		<option value=3	<?echo ($sel['orden']=='3'?"selected":"")?>>Орден Равновесия
		<option value=4	<?echo ($sel['orden']=='4'?"selected":"")?>>Орден Света
		<option value=5	<?echo ($sel['orden']=='5'?"selected":"")?>>Тюремный заключеный
		<option value=6	<?echo ($sel['orden']=='6'?"selected":"")?>>Истинный Мрак
		</select>
		</td>
	</tr>

	<tr>
		<td colspan=2 align=center>
			<input type=submit value="UPDATE" class='new' name='edit'>
		</td>
	</tr>
	</table>
</form>
