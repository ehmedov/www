<?include ("key.php");
array_walk($_POST,"format_string");

$name=$_POST["name"];
$img=$_POST["img"];
$mass=$_POST["mass"];
$price=$_POST["price"];
$min_sila=$_POST["min_sila"];
$min_lovkost=$_POST["min_lovkost"];
$min_udacha=$_POST["min_udacha"];
$min_power=$_POST["min_power"];
$min_intellekt=$_POST["min_intellekt"];
$min_vospriyatie=$_POST["min_vospriyatie"];
$min_level=$_POST["min_level"];
$add_sila=$_POST["add_sila"];
$add_lovkost=$_POST["add_lovkost"];
$add_udacha=$_POST["add_udacha"];
$add_hp=$_POST["add_hp"];
$add_intellekt=$_POST["add_intellekt"];
$add_mana=$_POST["add_mana"];
$sword_vl=$_POST["sword_vl"];
$axe_vl=$_POST["axe_vl"];
$fail_vl=$_POST["fail_vl"];
$knife_vl=$_POST["knife_vl"];
$spear_vl=$_POST["spear_vl"];
$staff_vl=$_POST["staff_vl"];

$add_fire=$_POST["add_fire"]; 
$add_water=$_POST["add_water"]; 
$add_air=$_POST["add_air"]; 
$add_earth=$_POST["add_earth"]; 

$protect_head=$_POST["protect_head"];
$protect_arm=$_POST["protect_arm"];
$protect_corp=$_POST["protect_corp"];
$protect_poyas=$_POST["protect_poyas"];
$protect_legs=$_POST["protect_legs"];

$krit=$_POST["krit"];
$akrit=$_POST["akrit"];
$uvorot=$_POST["uvorot"];
$auvorot=$_POST["auvorot"];

$iznos_max=$_POST["iznos_max"];

$min_attack=$_POST["min_attack"];
$max_attack=$_POST["max_attack"];

$art=$_POST["art"];
$podzemka=$_POST["podzemka"];
$count_mag=$_POST["count_mag"];
$type_tb=$_POST["type_tb"];
$need_orden=$_POST["need_orden"];
$type=$_POST["type"];
$is_personal=$_POST["is_personal"];
$personal_owner=$_POST["personal_owner"];
$name=$_POST["name"];
$sex=$_POST["sex"];
$remont=$_POST["remont"];
if(!empty($name))
{
	$w0="INSERT INTO paltar(object,name,img,mass,price,min_sila,min_lovkost,min_udacha,min_power,min_intellekt,min_vospriyatie,min_level,add_sila,add_lovkost,add_udacha,add_hp,add_intellekt,add_mana,protect_head,protect_arm,protect_corp,protect_poyas,protect_legs,krit,uvorot,iznos_min,iznos_max,min_attack,max_attack,art,type,akrit,auvorot,sword_vl,axe_vl,fail_vl,knife_vl,spear_vl,staff_vl,mountown,orden,sex,noremont,is_personal,personal_owner,podzemka,add_fire,add_water,add_air,add_earth) 
	VALUES ('$type_tb','$name','$img','$mass','$price','$min_sila','$min_lovkost','$min_udacha','$min_power','$min_intellekt','$min_vospriyatie','$min_level','$add_sila','$add_lovkost','$add_udacha','$add_hp','$add_intellekt','$add_mana','$protect_head','$protect_arm','$protect_corp','$protect_poyas','$protect_legs','$krit','$uvorot','0','$iznos_max','$min_attack','$max_attack','$art','$type','$akrit','$auvorot','$sword_vl','$axe_vl','$fail_vl','$knife_vl','$spear_vl','$staff_vl','$count_mag','$need_orden','$sex','$remont','$is_personal','$personal_owner','$podzemka','$add_fire','$add_water','$add_air','$add_earth')";
	$res=mysql_query($w0);
	if($res)
	{
		echo "Вещь <font color=red><b>$name</font></b> кол-вом <b>$count_mag</b> изготовлена<br>";		
	}
	else
	{
		echo "failed";
		echo mysql_error();
	}
	echo "<br>";
}
else
{
?>
<form name='action' action='main.php?act=inkviz&spell=add' method='post'>
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
<font color=RED><b>Масса:</b><font>
</td>
<td>
<input type=text name=mass class=new size=30>
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
Мин. сила:
</td>
<td>
<input type=text name=min_sila class=new size=30>
</td>
</tr>
<tr>
<td>
Мин. ловкость:
</td>
<td>
<input type=text name=min_lovkost class=new size=30>
</td>
</tr>
<tr>
<td>
Мин. удача:
</td>
<td>
<input type=text name=min_udacha class=new size=30>
</td>
</tr>
<tr>
<td>
Мин. выносливость:
</td>
<td>
<input type=text name=min_power class=new size=30>
</td>
</tr>
<tr>
<td>
Мин. интеллект:
</td>
<td>
<input type=text name=min_intellekt class=new size=30>
</td>
</tr>
<tr>
<td>
Мин. восприятие:
</td>
<td>
<input type=text name=min_vospriyatie class=new size=30>
</td>
</tr>
<tr>
<td>
<font color=RED><b>Мин. уровень:</b></font>
</td>
<td>
<input type=text name=min_level class=new size=30>
</td>
</tr>
<tr>
<td>
+ сила:
</td>
<td>
<input type=text name=add_sila class=new size=30>
</td>
</tr>
<tr>
<td>
+ ловкость:
</td>
<td>
<input type=text name=add_lovkost class=new size=30>
</td>
</tr>
<tr>
<td>
+ удача:
</td>
<td>
<input type=text name=add_udacha class=new size=30>
</td>
</tr>
<tr>
<td>
+ уровень HP:
</td>
<td>
<input type=text name=add_hp class=new size=30>
</td>
</tr>
<tr>
<td>
+ интеллект:
</td>
<td>
<input type=text name=add_intellekt class=new size=30>
</td>
</tr>
<tr>
<td>
+ уровень маны:
</td>
<td>
<input type=text name=add_mana class=new size=30>
</td>
</tr>
<tr><td colspan=2><hr></td></tr>
<tr>
<td>
+ владение мечами:
</td>
<td>
<input type=text name=sword_vl class=new size=30>
</td>
</tr>
<tr>
<td>
+ владение топорами:
</td>
<td>
<input type=text name=axe_vl class=new size=30>
</td>
</tr>
<tr>
<td>
+ владение булавами:
</td>
<td>
<input type=text name=fail_vl class=new size=30>
</td>
</tr>
<tr>
<td>
+ владение ножами:
</td>
<td>
<input type=text name=knife_vl class=new size=30>
</td>
</tr>
<tr>
<td>
+ владение копьями:
</td>
<td>
<input type=text name=spear_vl class=new size=30>
</td>
</tr>
<tr>
<td>
+ владение посохами:
</td>
<td>
<input type=text name=staff_vl class=new size=30>
</td>
</tr>

<tr><td colspan=2><hr></td></tr>
<tr>
<td>
Броня головы:
</td>
<td>
<input type=text name=protect_head class=new size=30>
</td>
</tr>
<td>
Броня рук:
</td>
<td>
<input type=text name=protect_arm class=new size=30>
</td>
</tr>
<tr>
<td>
Броня корпуса:
</td>
<td>
<input type=text name=protect_corp class=new size=30>
</td>
</tr>
<tr>
<td>
Броня пояса:
</td>
<td>
<input type=text name=protect_poyas class=new size=30>
</td>
</tr>
<tr>
<td>
Броня ног:
</td>
<td>
<input type=text name=protect_legs class=new size=30>
</td>
</tr>
<tr><td colspan=2><hr></td></tr>
<tr>
<td>
Мф. крит:
</td>
<td>
<input type=text name=krit class=new size=30>
</td>
</tr>
<tr>
<td>
Мф. антикрит:
</td>
<td>
<input type=text name=akrit class=new size=30>
</td>
</tr>
<tr>
<td>
Мф.уворот:
</td>
<td>
<input type=text name=uvorot class=new size=30>
</td>
</tr>
<tr>
<td>
Мф. антиуворот:
</td>
<td>
<input type=text name=auvorot class=new size=30>
</td>
</tr>
<tr><td colspan=2><hr></td></tr>
<tr>
<td>
Стихия огня:
</td>
<td>
<input type=text name=add_fire class=new size=30>
</td>
</tr>
<tr>
<td>
Стихия воды:
</td>
<td>
<input type=text name=add_water class=new size=30>
</td>
</tr>
<tr>
<td>
Стихия воздуха:
</td>
<td>
<input type=text name=add_air class=new size=30>
</td>
</tr>
<tr>
<td>
Стихия земли:
</td>
<td>
<input type=text name=add_earth class=new size=30>
</td>
</tr>
<tr><td colspan=2><hr></td></tr>
<tr>
<td>
<font color=RED><b>Износ: </b></font>
</td>
<td>
<input type=text name=iznos_max class=new size=30>
</td>
</tr>
<tr>
<td>
Мин. аттака:
</td>
<td>
<input type=text name=min_attack class=new size=30>
</td>
</tr>
<tr>
<td>
Макс. аттака:
</td>
<td>
<input type=text name=max_attack class=new size=30>
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
Именной:
</td>
<td>
<select name=is_personal  class=new>	
	<option value="0">NO
	<option value="1">YES
</select>
</td>
</tr>
	
<td>
Подземный:
</td>
<td>
<select name=podzemka  class=new>	
	<option value="0">NO
	<option value="1">YES
</select>
</td>
</tr>
		
<tr>
<td>
Владелец:
</td>
<td>
<input type=text name=personal_owner class=new size=30>
</td>
</tr>
<tr>
<td>
<font color=RED><b>Кол-во в маге:</b></font>
</td>
<td>
<input type=text name=count_mag class=new size=30 value=100000>
</td>
</tr>
<tr>
<td>
Пол предмета:
</td>
<td>
<select name=sex class=new>
	<option value='' selected>-----
	<option value='male'>male
	<option value='female'>female
</select>
</td>
</tr>
<tr>
<td>
Ремонт предмета:
</td>
<td>
<select name=remont class=new>
	<option value='0' selected>ремонтируется
	<option value='1'>не подлежит ремонту
</select>
</td>
</tr>

<tr>
<td>
Класс предмета:
</td>
<td>
<select name=type_tb class=new>
	<option value=pants selected>Поножи
	<option value=kostyl>Амуниция
	<option value=amunition>Инструменты
	<option value=amulet>Амулет
	<option value=naruchi>Наручи
	<option value=sword>Меч
	<option value=axe>Топор
	<option value=fail>Молот/дубина
	<option value=knife>Нож/кастет
	<option value=spear>Древковое оружие
	<option value=staff>Посохи
	<option value=armour>Броня
	<option value=rubaxa>Рубахи
	<option value=plash>Плащи
	<option value=poyas>Пояс
	<option value=helmet>Шлем
	<option value=mask>Маски
	<option value=perchi >Перчатки
	<option value=shield>Щит
	<option value=boots>Сапоги
	<option value=ring>Кольцо
	
</select>
</td>
</tr>
<tr>
<td>
Склонность:
</td>
<td>
<select name=need_orden class=new>
	<option value=0>нет
	<option value=1>Братство Палачей
	<option value=2>Вампиры
	<option value=3>Орден Равновесия
	<option value=4>Орден Света
	<option value=5>Тюремный заключеный
	<option value=6>Истинный Мрак
</select>
</td>
</tr>
<tr>
<td>
Тип предмета:
</td>
<td>
<select name=type class=new>
<option value=pants selected>Поножи
<option value=amunition>Инструменты
<option value=kostyl>Амуниция
<option value=castet>Кастет, нож.
<option value=sword>Меч, клинок
<option value=axe>Топор
<option value=hummer>Молот, дубина
<option value=copie>Копье
<option value=staff>Посохи
<option value=ring>Кольцо
<option value=amulet>Амулет
<option value=naruchi>Наручи
<option value=armor>Легкая броня
<option value=heavy_armor>Тяжелая броня
<option value=rubaxa>Рубахи
<option value=plash>Плащи	
<option value=poyas>Пояс
<option value=shlem>Шлем
<option value=mask>Маски
<option value=perchi>Перчатки
<option value=shield>Щит
<option value=boots>Сапоги
</select>
</td>
<td>
</select>
</td>
</tr>
<tr><td>
<input type=submit value="Создать" class=new>
</td></tr>
</table>
</form>

<?
}
?>
