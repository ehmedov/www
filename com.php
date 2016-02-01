<?
include_once ("key.php");
include_once ("conf.php");
include_once ("functions.php");
$login=$_SESSION["login"];

mysql_connect($base_name, $base_user, $base_pass) or die('Не получается подключиться. Проверьте имя сервера, имя пользователя и пароль!');
mysql_select_db($db_name) or die('Ошибка входа в базу данных');

Header("Cache-Control: no-cache, must-revalidate"); // говорим браузеру что-бы он не кешировал эту страницу
Header("Pragma: no-cache");

$db = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` LEFT JOIN info on info.id_pers=users.id WHERE login='".$login."'"));
##################################################################################
$room_array=array("house", "led", "labirint_led", "crypt_go", "crypt", "crypt_floor2", 
"warcrypt", "war_labirint", "smert_room", "towerin", "katakomba", "dungeon");
if(in_Array($db["room"],$room_array)){Header("Location: main.php");die();}
if($db["battle"]){Header("Location: battle.php");die();}
##################################################################################
$ip=$db["remote_ip"];
define("PRICE_BIRTH", 100);
define("PRICE_MAIL", 100);
define("PRICE_SEX", 200);
define("PRICE_NIK", 200);
define("PRICE_ZVER", 100);

if ($db["prision"]>0)
{
	$r=$db["prision"]-time();
	$days=(int)($r/(60*60*24));
	switch($db["prision"])
	{
		case ($days<3):define(PRICE_PRISON, 10);break;
		case ($days<7):define(PRICE_PRISON, 25);break;
		case ($days<15):define(PRICE_PRISON, 50);break;
		case ($days<35):define(PRICE_PRISON, 75);break;
		case ($days<65):define(PRICE_PRISON, 100);break;
		case ($days<95):define(PRICE_PRISON, 125);break;
		case ($days<200):define(PRICE_PRISON, 150);break;
		case ($days<370):define(PRICE_PRISON, 200);break;
		case ($days<780):define(PRICE_PRISON, 500);break;
	}
}
else define(PRICE_PRISON, 0);
//-------------------------Дата рождения ---------------------------------------------
if ($_POST["birth_day"])
{
	if ($db["platina"]>=PRICE_BIRTH)
	{	
		$birth_day = htmlspecialchars(addslashes($_POST["birth_day"]));
		$birth_month = htmlspecialchars(addslashes($_POST["birth_month"]));
		$birth_year = htmlspecialchars(addslashes($_POST["birth_year"]));
		$birthday=$birth_day.".".$birth_month.".".$birth_year;
		mysql_query("UPDATE info SET birth='".$birthday."' WHERE id_pers='".$db["id"]."'");
		mysql_query("UPDATE users SET platina=platina-'".PRICE_BIRTH."' WHERE login='".$login."'");

		$msg="Дата рождения был удачно изменен из <b>".$db["birth"]."</b> на ".$birthday." за <b>".PRICE_BIRTH." Пл.</b>";
		$db["birth"]=$birthday;
		$db["platina"]=$db["platina"]-PRICE_BIRTH;
		mysql_query("INSERT into comoddel (login,action,ip) values ('".$db["login"]."','".$msg."','".$db["remote_ip"]."')");
		history($db["login"],"Дата рождения","<font color=red>Дата рождения был удачно изменен</font>",$db["remote_ip"],"Комм. Отдел");
	}
	else $msg="Суммы на Вашем счету недостаточно (".PRICE_BIRTH." Пл.)";
}

//-------------------------------------------------------------------------------------
if ($_POST['chg_mail']) 
{
	$new_mail=strtolower(HtmlSpecialChars(trim($_POST['new_mail'])));
	$ok=true;
	if (trim($new_mail)=="") {$ok=false;$msg='Задан пустой почтовый адрес.';}
	if (!preg_match('#^[a-z0-9.!\#$%&\'*+-/=?^_`{|}~]+@([0-9.]+|([^\s]+\.+[a-z]{2,6}))$#si', $new_mail)){$ok=false;$msg="Ошибка. Неверно введен почтовый адрес.";}
	if ($db["platina"]<PRICE_MAIL){$ok=false;$msg="Суммы на Вашем счету недостаточно (".PRICE_MAIL." Пл.)";}
	if ($ok) 
	{
		mysql_query("UPDATE info SET email='".addslashes($new_mail)."' WHERE id_pers='".$db["id"]."'");
		mysql_query("UPDATE users SET platina=platina-'".PRICE_MAIL."' WHERE login='".$login."'");
		$db["platina"]=$db["platina"]-PRICE_MAIL;
		$msg="Почтовый адрес успешно сменен из <b>".$db["mail"]."</b> за <b>".PRICE_MAIL." Пл.</b>. Новый E-mail: <b>".$new_mail."</b>";
		mysql_query("INSERT into comoddel (login,action,ip) values ('".$db["login"]."','".$msg."','".$db["remote_ip"]."')");
		history($db["login"],"Почтовый адрес","<font color=red>Почтовый адрес успешно сменен</font>",$db["remote_ip"],"Комм. Отдел");
	}
}
//-------------------------------------------------------------------------------------
if ($_POST['chg_sex']) 
{
	$new_sex=HtmlSpecialChars(addslashes($_POST['new_sex']));
	$ok=true;
	if (!in_array($new_sex,array("male","female"))) {$ok=false;$msg='Вы указали неверный пол';}
	if ($db["platina"]<PRICE_SEX){$ok=false;$msg="Суммы на Вашем счету недостаточно (".PRICE_SEX." Пл.)";}
	if ($ok) 
	{	
		$db["sex"]=$new_sex;
		if($db["sex"]=="male")$obraz="m/1.gif";else if ($db["sex"]=="female")$obraz="f/1.gif";
		mysql_query("UPDATE users SET sex='".$new_sex."', platina=platina-'".PRICE_SEX."', obraz='".$obraz."' WHERE login='".$login."'");
		$db["platina"]=$db["platina"]-PRICE_SEX;
		$msg="Удачно Изменен Пол на ".$new_sex." за <b>".PRICE_SEX." Пл.</b>";
		mysql_query("INSERT into comoddel (login,action,ip) values ('".$db["login"]."','".$msg."','".$db["remote_ip"]."')");
		history($db["login"],"Изменен Пол","Удачно Изменен Пол",$db["remote_ip"],"Комм. Отдел");
	}
}
//-------------------------------------------------------------------------------------
if ($_POST['chg_login']) 
{
	$okname=true;

	$name=HtmlSpecialChars(addslashes(trim($_POST['new_login'])));
	$en=preg_match("/^(([a-zA-Z -])+)$/i", $name);
	$ru=preg_match("/^(([а-яА-Я -])+)$/i", $name);
	$res=mysql_query("SELECT id FROM users WHERE login='".$name."'");
	if (mysql_num_rows($res)){$okname=false;$msg="Логин <B>".$name."</B> уже занят!.";}
	else if ($db["platina"]<PRICE_NIK){$okname=false;$msg="Суммы на Вашем счету недостаточно (".PRICE_NIK." Пл.)";}
	else if (!$name) {$msg="Не указан Логин";$okname=false;}
	else if ((($en && $ru) or (!$en && !$ru)) && ($name)){$msg="Неверное Логин";$okname=false;}
	else if (strlen($name)>20) {$msg="Логин должен содержать не более 20 символов";$okname=false;}
	else if (strlen($name)<3) {$msg="Логин должен содержать не менее 3 символов";$okname=false;}
	if ($okname) 
	{		
		mysql_query("UPDATE users SET login='".$name."', platina=platina-".PRICE_NIK." WHERE login='".$login."'");
		$db["platina"]=$db["platina"]-PRICE_NIK;

		mysql_query("UPDATE inv SET owner='".$name."' WHERE owner='".$login."'");
		mysql_query("UPDATE comok SET owner='".$name."' WHERE owner='".$login."'");
		mysql_query("UPDATE bank SET login='".$name."' WHERE login='".$login."'");
		mysql_query("UPDATE thread SET creator='".$name."' WHERE creator='".$login."'");
		mysql_query("UPDATE topic SET login='".$name."' WHERE login='".$login."'");
		mysql_query("UPDATE perevod SET login='".$name."' WHERE login='".$login."'");
		mysql_query("UPDATE complect SET owner='".$name."' WHERE owner='".$login."'");
		mysql_query("UPDATE friend SET login='".$name."' WHERE login='".$login."'");
		mysql_query("UPDATE friend SET friend='".$name."' WHERE friend='".$login."'");
		mysql_query("UPDATE bs_winner SET user='".$name."' WHERE user='".$login."'");
		mysql_query("UPDATE house SET login='".$name."' WHERE login='".$login."'");
		mysql_query("UPDATE report SET login='".$name."' WHERE login='".$login."'");
		mysql_query("UPDATE casino SET Username='".$name."' WHERE Username='".$login."'");
		
		mysql_query("UPDATE elkapodarka SET login='".$name."' WHERE login='".$login."'");
		mysql_query("UPDATE elka SET login='".$name."' WHERE login='".$login."'");
		
		mysql_query("UPDATE novruzpodarka SET login='".$name."' WHERE login='".$login."'");
		mysql_query("UPDATE novruz SET login='".$name."' WHERE login='".$login."'");
		
		mysql_query("UPDATE obraz SET owner='".$name."' WHERE owner='".$login."'");
		mysql_query("DELETE FROM online WHERE login='".$login."'");
		$_SESSION["login"]=$name;
		$msg="Удачно Изменен Ник <b>".$db["login"]."</b> на <b>".$name."</b> за <b>".PRICE_NIK." Пл.</b>";
		mysql_query("INSERT into comoddel (login,action,ip) values ('".$db["login"]."','".$msg."','".$db["remote_ip"]."')");
		history($name,"Изменен Ник",$msg,$db["remote_ip"],"Комм. Отдел");
	}
}
//-------------------------------------------------------------------------------------
if ($_POST['chg_klichka']) 
{
	$okname=true;

	$animal_name=HtmlSpecialChars(addslashes(trim($_POST['new_klichka'])));
	$en=preg_match("/^(([a-zA-Z#])+)$/i", $animal_name);
	$ru=preg_match("/^(([а-яА-Я#])+)$/i", $animal_name);
	
	$res=mysql_query("SELECT id FROM zver WHERE owner='".$db["id"]."'");
	if (!mysql_num_rows($res)){$okname=false;$msg="Зверь не найден.";}
	else if ($db["platina"]<PRICE_ZVER){$okname=false;$msg="Суммы на Вашем счету недостаточно (".PRICE_ZVER." Пл.)";}
	else if (!$animal_name) {$msg="Не указан кличка ";$okname=false;}
	else if ((($en && $ru) or (!$en && !$ru)) && ($animal_name)){$msg="Неверное кличка";$okname=false;}
	else if (strlen($animal_name)>10) {$msg="Кличка должен содержать не более 10 символов";$okname=false;}
	else if (strlen($animal_name)<3) {$msg="Кличка должен содержать не менее 3 символов";$okname=false;}
	if ($okname) 
	{		
		mysql_query("UPDATE users SET platina=platina-".PRICE_ZVER." WHERE login='".$login."'");
		$db["platina"]=$db["platina"]-PRICE_ZVER;

		mysql_query("UPDATE zver SET name='".$animal_name."' WHERE owner='".$db["id"]."'");
		$msg="Удачно Изменен Кличка животному на <b>".$animal_name."</b> за <b>".PRICE_ZVER." Пл.</b>";
		mysql_query("INSERT into comoddel (login,action,ip) values ('".$db["login"]."','".$msg."','".$db["remote_ip"]."')");
		history($name,"Изменен Кличку","Удачно Изменен Кличка",$db["remote_ip"],"Комм. Отдел");
	}
}
//-------------------------------------------------------------------------------------
if ($_POST['xaos']) 
{
	$okxaos=true;
	if ($db["platina"]<PRICE_PRISON){$okxaos=false;$msg="Суммы на Вашем счету недостаточно (".PRICE_PRISON." Пл.)";}
	if (!$db["prision"]){$okxaos=false;$msg="Вы не тюремный заключенный...";}
	if($okxaos)
	{	
		mysql_query("UPDATE users SET prision='0',orden=0,platina=platina-".PRICE_PRISON." WHERE login='".$login."'");
		$db["prision"]=0;
		$db["platina"]=$db["platina"]-PRICE_PRISON;
		$msg="Вы вышли из хаоса... за <b>".PRICE_PRISON." Пл.</b>";
		mysql_query("INSERT into comoddel (login,action,ip) values ('".$db["login"]."','".$msg."','".$db["remote_ip"]."')");
		history($db["login"],"Вышли из хаоса","<font color=red>".$msg."</font>",$db["remote_ip"],"Комм. Отдел");
	}
}
//-------------------------------------------------------------------------------------
if ($_POST['vip']) 
{
	switch ($_POST["vip_month"])
	{
		case 1:$price_vip=1000; break;
    	case 3:$price_vip=3000; break;
    	case 6:$price_vip=5000; break;
    	case 12:$price_vip=7000; break;
	}
	$okvip=true;
	if ($db["platina"]<$price_vip){$okvip=false;$msg="Суммы на Вашем счету недостаточно (".$price_vip." Пл.)";}
	if ($db["prision"]){$okvip=false;$msg="Вы тюремный заключенный...";}
	if ($db["vip"]>time()){$okvip=false;$msg="Вы уже являетесь VIP пользователем...";}
	if($okvip)
	{	
		$vip_time=time()+(int)$_POST["vip_month"]*30*24*3600;
		mysql_query("UPDATE users SET vip='".$vip_time."',platina=platina-".$price_vip." WHERE login='".$login."'");
		$db["platina"]=$db["platina"]-$price_vip;
		$msg="Вы стали V.I.P-пользователем игры WWW.OlDmeydan.Pe.Hu за <b>".$price_vip." Пл.</b>";
		mysql_query("INSERT into comoddel (login,action,ip) values ('".$db["login"]."','".$msg."','".$db["remote_ip"]."')");
		history($db["login"],"V.I.P",$msg,$db["remote_ip"],"Комм. Отдел");
	}
}
//-------------------------------------------------------------------------------------
?>
<HEAD>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<meta http-equiv="Content-Language" content="ru">
	<meta name="author" content="OlDmeydan.Pe.Hu">
	<META Http-Equiv=Cache-Control Content="no-cache, max-age=0, must-revalidate, no-store">
	<meta http-equiv=PRAGMA content=NO-CACHE>
	<meta http-equiv=Expires content=0>	
	<LINK REL=StyleSheet HREF='main.css' TYPE='text/css'>
</HEAD>
<body bgcolor="#faeede">
<H3>Комм. Отдел</H3>
<table width=100%>
<tr>
	<td><font color=#ff0000><?=$msg?>&nbsp;</font></td>
	<td width=30%>	
		<?
			$money = sprintf ("%01.2f", $db["money"]);
			$platina = sprintf ("%01.2f", $db["platina"]);
		?>
		<div align=right>У вас в наличии: <B><?echo $money;?></b> Зл. <b><?echo $platina;?></b> Пл.</div>
	</td>
	</tr>
</table>
<div align=right>
<input type="button" class="btn" id="refresh" onclick="window.location='com.php'" value="Обновить">
<input type=button value='Вернуться' class='new' style='cursor:hand' onClick="javascript:location.href='main.php?act=none'">
</div>
<?
	$birth=explode(".",$db["birth"]);
	$d=$birth[0];
	$m=$birth[1];
	$y=$birth[2];
	echo "<form action='' method='post' name=chg_birth>";
	echo "<table width=90% border=0><tr class='l1'><td nowrap valign='middle'>";
	echo "<select name='birth_day' class='inup' style='width=40;'>";
	for($i=1;$i<=31;$i++)
	{
		if($i==$d){$ch=" selected";}else{$ch="";}
		if($i<10){$i='0'.$i;}echo "<OPTION VALUE=\"$i\"$ch>$i";
	}
	echo "</select> ";
	echo '<select name="birth_month" class="inup" style="width=95;">
    <OPTION VALUE="01"'.($m=='01'?" selected":"").'>ЯНВАРЬ
    <OPTION VALUE="02"'.($m=='02'?" selected":"").'>ФЕВРАЛЬ
    <OPTION VALUE="03"'.($m=='03'?" selected":"").'>МАРТ
    <OPTION VALUE="04"'.($m=='04'?" selected":"").'>АПРЕЛЬ
    <OPTION VALUE="05"'.($m=='05'?" selected":"").'>МАЙ
    <OPTION VALUE="06"'.($m=='06'?" selected":"").'>ИЮНЬ
    <OPTION VALUE="07"'.($m=='07'?" selected":"").'>ИЮЛЬ
    <OPTION VALUE="08"'.($m=='08'?" selected":"").'>АВГУСТ
    <OPTION VALUE="09"'.($m=='09'?" selected":"").'>СЕНТЯБРЬ
    <OPTION VALUE="10"'.($m=='10'?" selected":"").'>ОКТЯБРЬ
    <OPTION VALUE="11"'.($m=='11'?" selected":"").'>НОЯБРЬ
    <OPTION VALUE="12"'.($m=='12'?" selected":"").'>ДЕКАБРЬ
	</select> ';
	echo '<select name="birth_year" class="inup"  style="width=60; ">';
	for($i=1950;$i<=2002;$i++)
	{
		if($i==$y){$ch=" selected";}else{$ch="";}
		echo "<OPTION VALUE=\"$i\"$ch>$i";
	}
	echo "</select>";
	echo "&nbsp;<INPUT TYPE='submit' VALUE=' Сменить ' CLASS='but'>
		</td><td width=100% valign='bottom'> (<i>Изменения Даты Рождения</i> - <b>".PRICE_BIRTH." Пл.</b>)</td>
	</tr></table></FORM>";
	//-----------------------------------------------------------------------------------------------
	echo "<table width=90% border=0><tr><td nowrap valign='middle'>
	<form action='' method='post'>
	<tr class='l1'>
		<td>
			Новый E-mail: <input type=text name=new_mail class=inup size='45' maxlength='90'> <INPUT TYPE='submit' VALUE=' Сменить '  name=chg_mail CLASS='but'> (<i>Изменения Е-mail</i> - <b>".PRICE_MAIL." Пл.</b>)
		</td>
	</tr></table>
	</FORM>";
	//-----------------------------------------------------------------------------------------------
	echo "<table width=90% border=0><tr><td nowrap valign='middle'>
	<form action='' method='post'>
	<tr class='l1'>
		<td>
			Действие: <select name=new_sex><option value='male' ".($db["sex"]=="male"?"selected":"").">Мужской<option value='female' ".($db["sex"]=="female"?"selected":"").">Женский</select> <INPUT TYPE='submit' VALUE=' Сменить '  name=chg_sex CLASS='but'> (<i>Смена пола </i> - <b>".PRICE_SEX." Пл.</b>)
		</td>
	</tr></table>
	</FORM>";	
	//-----------------------------------------------------------------------------------------------
	echo "<table width=90% border=0><tr><td nowrap valign='middle'>
	<form action='' method='post'>
	<tr class='l1'>
		<td>
			Новый Ник: <input type=text name=new_login class=inup size='25' maxlength='30'> <INPUT TYPE='submit' VALUE=' Сменить '  name=chg_login CLASS='but'> (<i>Сменить ник</i> - <b>".PRICE_NIK." Пл.</b>)
		</td>
	</tr></table>
	</FORM>";
	//-----------------------------------------------------------------------------------------------
	echo "<table width=90% border=0><tr><td nowrap valign='middle'>
	<form action='' method='post'>
	<tr class='l1'>
		<td>
			<INPUT TYPE='submit' VALUE=' Выйти из Тюрьмы за ".PRICE_PRISON." Пл.'  name='xaos' CLASS='but'>
		</td>
	</tr></table>
	</FORM>";
	//-----------------------------------------------------------------------------------------------
	echo "<table width=90% border=0><tr><td nowrap valign='middle'>
	<form action='' method='post'>
	<tr class='l1'>
		<td>Стать <b>V.I.P</b> пользователем игры WWW.OlDmeydan.Pe.Hu
			<select name='vip_month' class='inup' >
				<OPTION VALUE=1>на 1 месяца за 1000 Пл.
	    		<OPTION VALUE=3>на 3 месяца за 3000 Пл.
	    		<OPTION VALUE=6>на 6 месяца за 5000 Пл.
	    		<OPTION VALUE=12>на 1 год за 7000 Пл.
	    	</select>
			<INPUT TYPE='submit' VALUE=' Принять ' name='vip' CLASS='but'>
		</td>
	</tr></table>
	</FORM>";
	echo "<table width=90% border=0><tr><td nowrap valign='middle'>
	<form action='' method='post'>
	<tr class='l1'>
		<td>
			Изменить кличку своему животному: <input type=text name=new_klichka class=inup size='25' maxlength='30'> <INPUT TYPE='submit' VALUE=' Сменить кличку '  name=chg_klichka CLASS='but'> (<i>Сменить кличку</i> - <b>".PRICE_ZVER." Пл.</b>)
		</td>
	</tr></table>
	</FORM>";
?>