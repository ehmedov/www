<?include ("key.php");
if ($_SESSION["login"]!="ASA" && $_SESSION["login"]!="bor")
{
	die("");
}	
?>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<meta http-equiv="Content-Language" content="ru">
<LINK REL=StyleSheet HREF='main.css' TYPE='text/css'>
<body bgcolor=#dddddd>
<?
include "conf.php";
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

$add_fire=$_POST["add_fire"]; 
$add_water=$_POST["add_water"]; 
$add_air=$_POST["add_air"]; 
$add_earth=$_POST["add_earth"]; 

$sword_vl=$_POST["sword_vl"];
$axe_vl=$_POST["axe_vl"];
$fail_vl=$_POST["fail_vl"];
$knife_vl=$_POST["knife_vl"];
$spear_vl=$_POST["spear_vl"];
$staff_vl=$_POST["staff_vl"];

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
$count_mag=$_POST["count_mag"];
$is_personal=$_POST["is_personal"];
$personal_owner=$_POST["personal_owner"];

$sex=$_POST["sex"];
$need_orden=$_POST["need_orden"];
$noremont=$_POST["noremont"];
$item=$_GET['item'];



if($_REQUEST['edit'])
{
	$sql="UPDATE paltar SET name='$name', img='$img', mass='$mass', sex='$sex',price='$price', min_sila='$min_sila', min_lovkost='$min_lovkost',
		min_udacha='$min_udacha', min_power='$min_power', min_intellekt='$min_intellekt', min_vospriyatie='$min_vospriyatie',
		min_level='$min_level', add_sila='$add_sila', add_lovkost='$add_lovkost', add_udacha='$add_udacha', add_hp='$add_hp',
		add_intellekt='$add_intellekt', add_mana='$add_mana', protect_head='$protect_head', protect_arm='$protect_arm',
		protect_corp='$protect_corp', protect_poyas='$protect_poyas', protect_legs='$protect_legs',
		krit='$krit',uvorot='$uvorot', min_attack='$min_attack', max_attack='$max_attack', art='$art', 
		akrit='$akrit', auvorot='$auvorot', sword_vl='$sword_vl', axe_vl='$axe_vl', fail_vl='$fail_vl', 
		knife_vl='$knife_vl', spear_vl='$spear_vl', staff_vl='$staff_vl', mountown='$count_mag', orden='$need_orden',iznos_max='$iznos_max',
		is_personal='$is_personal', personal_owner='$personal_owner', add_fire='$add_fire',add_water='$add_water',add_air='$add_air',add_earth='$add_earth',
		noremont='$noremont' WHERE id='$item'";
	//$sql;
	$res=mysql_query($sql);
	if($res)
	{
		echo "ВЕЩЬ <font color=red><b>$name</font></b> UPDATED<br>";
		unset($_REQUEST['edit']);
	}
	else
	{
		echo "failed";
		echo mysql_error();
	}
	echo "<br>";
}
$res=mysql_query("SELECT * FROM paltar WHERE id='".$item."'");
$sel=mysql_fetch_array($res);
mysql_free_result($res);
?>
<form  method='post'>
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
<font color=RED><b>Путь к рисунку: </b></font>
</td>
<td>
<input type=text name=img class=new size=30 value="<?echo $sel['img'];?>">
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
<font color=RED><b>Цена: </b></font>
</td>
<td>
<input type=text name=price class=new size=30 value="<?echo $sel['price'];?>">
</td>
</tr>
	
<tr>
<td>
Мин. сила:
</td>
<td>
<input type=text name=min_sila class=new size=30 value="<?echo $sel['min_sila'];?>">
</td>
</tr>
	
<tr>
<td>
Мин. ловкость:
</td>
<td>
<input type=text name=min_lovkost class=new size=30 value="<?echo $sel['min_lovkost'];?>">
</td>
</tr>
	
<tr>
<td>
Мин. удача:
</td>
<td>
<input type=text name=min_udacha class=new size=30 value="<?echo $sel['min_udacha'];?>">
</td>
</tr>
	
<tr>
<td>
Мин. выносливость:
</td>
<td>
<input type=text name=min_power class=new size=30 value="<?echo $sel['min_power'];?>">
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
Мин. восприятие:
</td>
<td>
<input type=text name=min_vospriyatie class=new size=30 value="<?echo $sel['min_vospriyatie'];?>">
</td>
</tr>
	
<tr>
<td>
<font color=RED><b>Мин. уровень:</b></font>
</td>
<td>
<input type=text name=min_level class=new size=30 value="<?echo $sel['min_level'];?>">
</td>
</tr>
	
<tr>
<td>
+ сила:
</td>
<td>
<input type=text name=add_sila class=new size=30 value="<?echo $sel['add_sila'];?>">
</td>
</tr>
	
<tr>
<td>
+ ловкость:
</td>
<td>
<input type=text name=add_lovkost class=new size=30 value="<?echo $sel['add_lovkost'];?>">
</td>
</tr>
	
<tr>
<td>
+ удача:
</td>
<td>
<input type=text name=add_udacha class=new size=30 value="<?echo $sel['add_udacha'];?>">
</td>
</tr>
	
<tr>
<td>
+ уровень HP:
</td>
<td>
<input type=text name=add_hp class=new size=30 value="<?echo $sel['add_hp'];?>">
</td>
</tr>
	
<tr>
<td>
+ интеллект:
</td>
<td>
<input type=text name=add_intellekt class=new size=30 value="<?echo $sel['add_intellekt'];?>">
</td>
</tr>
	
<tr>
<td>
+ уровень маны:
</td>
<td>
<input type=text name=add_mana class=new size=30 value="<?echo $sel['add_mana'];?>">
</td>
</tr>
<tr><td colspan=2><hr></td></tr>
	
<tr>
<td>
+ владение мечами:
</td>
<td>
<input type=text name=sword_vl class=new size=30 value="<?echo $sel['sword_vl'];?>">
</td>
</tr>
	
<tr>
<td>
+ владение топорами:
</td>
<td>
<input type=text name=axe_vl class=new size=30 value="<?echo $sel['axe_vl'];?>">
</td>
</tr>
	
<tr>
<td>
+ владение булавами:
</td>
<td>
<input type=text name=fail_vl class=new size=30 value="<?echo $sel['fail_vl'];?>">
</td>
</tr>
	
<tr>
<td>
+ владение ножами:
</td>
<td>
<input type=text name=knife_vl class=new size=30 value="<?echo $sel['knife_vl'];?>">
</td>
</tr>
	
<tr>
<td>
+ владение копьями:
</td>
<td>
<input type=text name=spear_vl class=new size=30 value="<?echo $sel['spear_vl'];?>">
</td>
</tr>

<tr>
<td>
+ владение посохами:
</td>
<td>
<input type=text name=staff_vl class=new size=30 value="<?echo $sel['staff_vl'];?>">
</td>
</tr>
	
<tr><td colspan=2><hr></td></tr>
	
<tr>
<td>
Броня головы:
</td>
<td>
<input type=text name=protect_head class=new size=30 value="<?echo $sel['protect_head'];?>">
</td>
</tr>
	
<td>
Броня рук:
</td>
<td>
<input type=text name=protect_arm class=new size=30 value="<?echo $sel['protect_arm'];?>">
</td>
</tr>
	
<tr>
<td>
Броня корпуса:
</td>
<td>
<input type=text name=protect_corp class=new size=30 value="<?echo $sel['protect_corp'];?>">
</td>
</tr>
	
<tr>
<td>
Броня пояса:
</td>
<td>
<input type=text name=protect_poyas class=new size=30 value="<?echo $sel['protect_poyas'];?>">
</td>
</tr>
	
<tr>
<td>
Броня ног:
</td>
<td>
<input type=text name=protect_legs class=new size=30 value="<?echo $sel['protect_legs'];?>">
</td>
</tr>
<tr><td colspan=2><hr></td></tr>
	
<tr>
<td>
Мф. крит:
</td>
<td>
<input type=text name=krit class=new size=30 value="<?echo $sel['krit'];?>">
</td>
</tr>
	
<tr>
<td>
Мф. антикрит:
</td>
<td>
<input type=text name=akrit class=new size=30 value="<?echo $sel['akrit'];?>">
</td>
</tr>
	
<tr>
<td>
Мф.уворот:
</td>
<td>
<input type=text name=uvorot class=new size=30 value="<?echo $sel['uvorot'];?>">
</td>
</tr>
	
<tr>
<td>
Мф. антиуворот:
</td>
<td>
<input type=text name=auvorot class=new size=30 value="<?echo $sel['auvorot'];?>">
</td>
</tr>
<tr><td colspan=2><hr></td></tr>
<tr>
<td>
Стихия огня:
</td>
<td>
<input type=text name=add_fire class=new size=30 value="<?echo $sel['add_fire'];?>">
</td>
</tr>
<tr>
<td>
Стихия воды:
</td>
<td>
<input type=text name=add_water class=new size=30 value="<?echo $sel['add_water'];?>">
</td>
</tr>
<tr>
<td>
Стихия воздуха:
</td>
<td>
<input type=text name=add_air class=new size=30 value="<?echo $sel['add_air'];?>">
</td>
</tr>
<tr>
<td>
Стихия земли:
</td>
<td>
<input type=text name=add_earth class=new size=30 value="<?echo $sel['add_earth'];?>">
</td>
</tr>
	
<tr><td colspan=2><hr></td></tr>	
<tr>
<td>
Долговечность:
</td>
<td>
<input type=text name=iznos_max class=new size=30 value="<?echo $sel['iznos_max'];?>">
</td>
</tr>

	
<tr><td colspan=2><hr></td></tr>	
<tr>
<td>
Мин. аттака:
</td>
<td>
<input type=text name=min_attack class=new size=30 value="<?echo $sel['min_attack'];?>">
</td>
</tr>
	
<tr>
<td>
Макс. аттака:
</td>
<td>
<input type=text name=max_attack class=new size=30 value="<?echo $sel['max_attack'];?>">
</td>
</tr>
	
<tr>
<td>
<b style='color:#FF0000'>Артефактная вещь:</b>
</td>
<td>
<select name=art  class=new>	
	<option value="0">NO
	<option value="1" <?echo ($sel['art']?"selected":"")?>>YES
</select>
</td>
</tr>

<tr>
<td>
<b style='color:#FF0000'>Ремонт предмета:</b>
</td>
<td>
<select name=noremont  class=new>
	<option value="0">ремонтируется
	<option value="1" <?echo ($sel['noremont']?"selected":"")?>>не подлежит ремонту
</select>
</td>
</tr>


<tr>
<td>
<b style='color:#FF0000'>Именной:</b>
</td>
<td>
<select name=is_personal  class=new>	
	<option value="0">NO
	<option value="1" <?echo ($sel['is_personal']?"selected":"")?>>YES
</select>
</td>
</tr>
	
<tr>
<td>
<b style='color:#FF0000'>Владелец:</b>
</td>
<td>
<input type=text name=personal_owner class=new size=30 value="<?echo $sel['personal_owner'];?>">
</td>
</tr>


<tr>
<td>
Пол предмета:
</td>
<td>
<select name=sex class=new>
	<option value=''>-----
	<option value='male' <?echo ($sel['sex']=="male"?"selected":"")?>>Мужской
	<option value='female' <?echo ($sel['sex']=="female"?"selected":"")?>>Женский
</select>
</td>
</tr>
	
<tr>
<td>
<b style='color:#FF0000'>Кол-во в маге:</b>
</td>
<td>
<input type=text name=count_mag class=new size=30 value="<?echo $sel['mountown'];?>">
</td>
</tr>

<tr>
<td>
<b style='color:#FF0000'>Склонность:</b>
</td>
<td>
<select name=need_orden class=new>
	<option value=0 <?echo ($sel['orden']==0?"selected":"")?>>нет
	<option value=1 <?echo ($sel['orden']==1?"selected":"")?>>Братство Палачей
	<option value=2 <?echo ($sel['orden']==2?"selected":"")?>>Вампиры
	<option value=3 <?echo ($sel['orden']==3?"selected":"")?>>Орден Равновесия
	<option value=4 <?echo ($sel['orden']==4?"selected":"")?>>Орден Света
	<option value=5 <?echo ($sel['orden']==5?"selected":"")?>>Тюремный заключеный
	<option value=6 <?echo ($sel['orden']==6?"selected":"")?>>Истинный Мрак
</select>
</td>
</tr>


<tr>
<td>
	<input type=submit value="UPDATE" class='new' name='edit'>
</td>
</tr>
</table>
</form>
