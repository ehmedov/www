<?
include_once ("key.php");
include_once ("conf.php");
include_once ("functions.php");
$login=$_SESSION["login"];

mysql_connect($base_name, $base_user, $base_pass) or die('�� ���������� ������������. ��������� ��� �������, ��� ������������ � ������!');
mysql_select_db($db_name) or die('������ ����� � ���� ������');

Header("Cache-Control: no-cache, must-revalidate"); // ������� �������� ���-�� �� �� ��������� ��� ��������
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
//-------------------------���� �������� ---------------------------------------------
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

		$msg="���� �������� ��� ������ ������� �� <b>".$db["birth"]."</b> �� ".$birthday." �� <b>".PRICE_BIRTH." ��.</b>";
		$db["birth"]=$birthday;
		$db["platina"]=$db["platina"]-PRICE_BIRTH;
		mysql_query("INSERT into comoddel (login,action,ip) values ('".$db["login"]."','".$msg."','".$db["remote_ip"]."')");
		history($db["login"],"���� ��������","<font color=red>���� �������� ��� ������ �������</font>",$db["remote_ip"],"����. �����");
	}
	else $msg="����� �� ����� ����� ������������ (".PRICE_BIRTH." ��.)";
}

//-------------------------------------------------------------------------------------
if ($_POST['chg_mail']) 
{
	$new_mail=strtolower(HtmlSpecialChars(trim($_POST['new_mail'])));
	$ok=true;
	if (trim($new_mail)=="") {$ok=false;$msg='����� ������ �������� �����.';}
	if (!preg_match('#^[a-z0-9.!\#$%&\'*+-/=?^_`{|}~]+@([0-9.]+|([^\s]+\.+[a-z]{2,6}))$#si', $new_mail)){$ok=false;$msg="������. ������� ������ �������� �����.";}
	if ($db["platina"]<PRICE_MAIL){$ok=false;$msg="����� �� ����� ����� ������������ (".PRICE_MAIL." ��.)";}
	if ($ok) 
	{
		mysql_query("UPDATE info SET email='".addslashes($new_mail)."' WHERE id_pers='".$db["id"]."'");
		mysql_query("UPDATE users SET platina=platina-'".PRICE_MAIL."' WHERE login='".$login."'");
		$db["platina"]=$db["platina"]-PRICE_MAIL;
		$msg="�������� ����� ������� ������ �� <b>".$db["mail"]."</b> �� <b>".PRICE_MAIL." ��.</b>. ����� E-mail: <b>".$new_mail."</b>";
		mysql_query("INSERT into comoddel (login,action,ip) values ('".$db["login"]."','".$msg."','".$db["remote_ip"]."')");
		history($db["login"],"�������� �����","<font color=red>�������� ����� ������� ������</font>",$db["remote_ip"],"����. �����");
	}
}
//-------------------------------------------------------------------------------------
if ($_POST['chg_sex']) 
{
	$new_sex=HtmlSpecialChars(addslashes($_POST['new_sex']));
	$ok=true;
	if (!in_array($new_sex,array("male","female"))) {$ok=false;$msg='�� ������� �������� ���';}
	if ($db["platina"]<PRICE_SEX){$ok=false;$msg="����� �� ����� ����� ������������ (".PRICE_SEX." ��.)";}
	if ($ok) 
	{	
		$db["sex"]=$new_sex;
		if($db["sex"]=="male")$obraz="m/1.gif";else if ($db["sex"]=="female")$obraz="f/1.gif";
		mysql_query("UPDATE users SET sex='".$new_sex."', platina=platina-'".PRICE_SEX."', obraz='".$obraz."' WHERE login='".$login."'");
		$db["platina"]=$db["platina"]-PRICE_SEX;
		$msg="������ ������� ��� �� ".$new_sex." �� <b>".PRICE_SEX." ��.</b>";
		mysql_query("INSERT into comoddel (login,action,ip) values ('".$db["login"]."','".$msg."','".$db["remote_ip"]."')");
		history($db["login"],"������� ���","������ ������� ���",$db["remote_ip"],"����. �����");
	}
}
//-------------------------------------------------------------------------------------
if ($_POST['chg_login']) 
{
	$okname=true;

	$name=HtmlSpecialChars(addslashes(trim($_POST['new_login'])));
	$en=preg_match("/^(([a-zA-Z -])+)$/i", $name);
	$ru=preg_match("/^(([�-��-� -])+)$/i", $name);
	$res=mysql_query("SELECT id FROM users WHERE login='".$name."'");
	if (mysql_num_rows($res)){$okname=false;$msg="����� <B>".$name."</B> ��� �����!.";}
	else if ($db["platina"]<PRICE_NIK){$okname=false;$msg="����� �� ����� ����� ������������ (".PRICE_NIK." ��.)";}
	else if (!$name) {$msg="�� ������ �����";$okname=false;}
	else if ((($en && $ru) or (!$en && !$ru)) && ($name)){$msg="�������� �����";$okname=false;}
	else if (strlen($name)>20) {$msg="����� ������ ��������� �� ����� 20 ��������";$okname=false;}
	else if (strlen($name)<3) {$msg="����� ������ ��������� �� ����� 3 ��������";$okname=false;}
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
		$msg="������ ������� ��� <b>".$db["login"]."</b> �� <b>".$name."</b> �� <b>".PRICE_NIK." ��.</b>";
		mysql_query("INSERT into comoddel (login,action,ip) values ('".$db["login"]."','".$msg."','".$db["remote_ip"]."')");
		history($name,"������� ���",$msg,$db["remote_ip"],"����. �����");
	}
}
//-------------------------------------------------------------------------------------
if ($_POST['chg_klichka']) 
{
	$okname=true;

	$animal_name=HtmlSpecialChars(addslashes(trim($_POST['new_klichka'])));
	$en=preg_match("/^(([a-zA-Z#])+)$/i", $animal_name);
	$ru=preg_match("/^(([�-��-�#])+)$/i", $animal_name);
	
	$res=mysql_query("SELECT id FROM zver WHERE owner='".$db["id"]."'");
	if (!mysql_num_rows($res)){$okname=false;$msg="����� �� ������.";}
	else if ($db["platina"]<PRICE_ZVER){$okname=false;$msg="����� �� ����� ����� ������������ (".PRICE_ZVER." ��.)";}
	else if (!$animal_name) {$msg="�� ������ ������ ";$okname=false;}
	else if ((($en && $ru) or (!$en && !$ru)) && ($animal_name)){$msg="�������� ������";$okname=false;}
	else if (strlen($animal_name)>10) {$msg="������ ������ ��������� �� ����� 10 ��������";$okname=false;}
	else if (strlen($animal_name)<3) {$msg="������ ������ ��������� �� ����� 3 ��������";$okname=false;}
	if ($okname) 
	{		
		mysql_query("UPDATE users SET platina=platina-".PRICE_ZVER." WHERE login='".$login."'");
		$db["platina"]=$db["platina"]-PRICE_ZVER;

		mysql_query("UPDATE zver SET name='".$animal_name."' WHERE owner='".$db["id"]."'");
		$msg="������ ������� ������ ��������� �� <b>".$animal_name."</b> �� <b>".PRICE_ZVER." ��.</b>";
		mysql_query("INSERT into comoddel (login,action,ip) values ('".$db["login"]."','".$msg."','".$db["remote_ip"]."')");
		history($name,"������� ������","������ ������� ������",$db["remote_ip"],"����. �����");
	}
}
//-------------------------------------------------------------------------------------
if ($_POST['xaos']) 
{
	$okxaos=true;
	if ($db["platina"]<PRICE_PRISON){$okxaos=false;$msg="����� �� ����� ����� ������������ (".PRICE_PRISON." ��.)";}
	if (!$db["prision"]){$okxaos=false;$msg="�� �� �������� �����������...";}
	if($okxaos)
	{	
		mysql_query("UPDATE users SET prision='0',orden=0,platina=platina-".PRICE_PRISON." WHERE login='".$login."'");
		$db["prision"]=0;
		$db["platina"]=$db["platina"]-PRICE_PRISON;
		$msg="�� ����� �� �����... �� <b>".PRICE_PRISON." ��.</b>";
		mysql_query("INSERT into comoddel (login,action,ip) values ('".$db["login"]."','".$msg."','".$db["remote_ip"]."')");
		history($db["login"],"����� �� �����","<font color=red>".$msg."</font>",$db["remote_ip"],"����. �����");
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
	if ($db["platina"]<$price_vip){$okvip=false;$msg="����� �� ����� ����� ������������ (".$price_vip." ��.)";}
	if ($db["prision"]){$okvip=false;$msg="�� �������� �����������...";}
	if ($db["vip"]>time()){$okvip=false;$msg="�� ��� ��������� VIP �������������...";}
	if($okvip)
	{	
		$vip_time=time()+(int)$_POST["vip_month"]*30*24*3600;
		mysql_query("UPDATE users SET vip='".$vip_time."',platina=platina-".$price_vip." WHERE login='".$login."'");
		$db["platina"]=$db["platina"]-$price_vip;
		$msg="�� ����� V.I.P-������������� ���� WWW.OlDmeydan.Pe.Hu �� <b>".$price_vip." ��.</b>";
		mysql_query("INSERT into comoddel (login,action,ip) values ('".$db["login"]."','".$msg."','".$db["remote_ip"]."')");
		history($db["login"],"V.I.P",$msg,$db["remote_ip"],"����. �����");
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
<H3>����. �����</H3>
<table width=100%>
<tr>
	<td><font color=#ff0000><?=$msg?>&nbsp;</font></td>
	<td width=30%>	
		<?
			$money = sprintf ("%01.2f", $db["money"]);
			$platina = sprintf ("%01.2f", $db["platina"]);
		?>
		<div align=right>� ��� � �������: <B><?echo $money;?></b> ��. <b><?echo $platina;?></b> ��.</div>
	</td>
	</tr>
</table>
<div align=right>
<input type="button" class="btn" id="refresh" onclick="window.location='com.php'" value="��������">
<input type=button value='���������' class='new' style='cursor:hand' onClick="javascript:location.href='main.php?act=none'">
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
    <OPTION VALUE="01"'.($m=='01'?" selected":"").'>������
    <OPTION VALUE="02"'.($m=='02'?" selected":"").'>�������
    <OPTION VALUE="03"'.($m=='03'?" selected":"").'>����
    <OPTION VALUE="04"'.($m=='04'?" selected":"").'>������
    <OPTION VALUE="05"'.($m=='05'?" selected":"").'>���
    <OPTION VALUE="06"'.($m=='06'?" selected":"").'>����
    <OPTION VALUE="07"'.($m=='07'?" selected":"").'>����
    <OPTION VALUE="08"'.($m=='08'?" selected":"").'>������
    <OPTION VALUE="09"'.($m=='09'?" selected":"").'>��������
    <OPTION VALUE="10"'.($m=='10'?" selected":"").'>�������
    <OPTION VALUE="11"'.($m=='11'?" selected":"").'>������
    <OPTION VALUE="12"'.($m=='12'?" selected":"").'>�������
	</select> ';
	echo '<select name="birth_year" class="inup"  style="width=60; ">';
	for($i=1950;$i<=2002;$i++)
	{
		if($i==$y){$ch=" selected";}else{$ch="";}
		echo "<OPTION VALUE=\"$i\"$ch>$i";
	}
	echo "</select>";
	echo "&nbsp;<INPUT TYPE='submit' VALUE=' ������� ' CLASS='but'>
		</td><td width=100% valign='bottom'> (<i>��������� ���� ��������</i> - <b>".PRICE_BIRTH." ��.</b>)</td>
	</tr></table></FORM>";
	//-----------------------------------------------------------------------------------------------
	echo "<table width=90% border=0><tr><td nowrap valign='middle'>
	<form action='' method='post'>
	<tr class='l1'>
		<td>
			����� E-mail: <input type=text name=new_mail class=inup size='45' maxlength='90'> <INPUT TYPE='submit' VALUE=' ������� '  name=chg_mail CLASS='but'> (<i>��������� �-mail</i> - <b>".PRICE_MAIL." ��.</b>)
		</td>
	</tr></table>
	</FORM>";
	//-----------------------------------------------------------------------------------------------
	echo "<table width=90% border=0><tr><td nowrap valign='middle'>
	<form action='' method='post'>
	<tr class='l1'>
		<td>
			��������: <select name=new_sex><option value='male' ".($db["sex"]=="male"?"selected":"").">�������<option value='female' ".($db["sex"]=="female"?"selected":"").">�������</select> <INPUT TYPE='submit' VALUE=' ������� '  name=chg_sex CLASS='but'> (<i>����� ���� </i> - <b>".PRICE_SEX." ��.</b>)
		</td>
	</tr></table>
	</FORM>";	
	//-----------------------------------------------------------------------------------------------
	echo "<table width=90% border=0><tr><td nowrap valign='middle'>
	<form action='' method='post'>
	<tr class='l1'>
		<td>
			����� ���: <input type=text name=new_login class=inup size='25' maxlength='30'> <INPUT TYPE='submit' VALUE=' ������� '  name=chg_login CLASS='but'> (<i>������� ���</i> - <b>".PRICE_NIK." ��.</b>)
		</td>
	</tr></table>
	</FORM>";
	//-----------------------------------------------------------------------------------------------
	echo "<table width=90% border=0><tr><td nowrap valign='middle'>
	<form action='' method='post'>
	<tr class='l1'>
		<td>
			<INPUT TYPE='submit' VALUE=' ����� �� ������ �� ".PRICE_PRISON." ��.'  name='xaos' CLASS='but'>
		</td>
	</tr></table>
	</FORM>";
	//-----------------------------------------------------------------------------------------------
	echo "<table width=90% border=0><tr><td nowrap valign='middle'>
	<form action='' method='post'>
	<tr class='l1'>
		<td>����� <b>V.I.P</b> ������������� ���� WWW.OlDmeydan.Pe.Hu
			<select name='vip_month' class='inup' >
				<OPTION VALUE=1>�� 1 ������ �� 1000 ��.
	    		<OPTION VALUE=3>�� 3 ������ �� 3000 ��.
	    		<OPTION VALUE=6>�� 6 ������ �� 5000 ��.
	    		<OPTION VALUE=12>�� 1 ��� �� 7000 ��.
	    	</select>
			<INPUT TYPE='submit' VALUE=' ������� ' name='vip' CLASS='but'>
		</td>
	</tr></table>
	</FORM>";
	echo "<table width=90% border=0><tr><td nowrap valign='middle'>
	<form action='' method='post'>
	<tr class='l1'>
		<td>
			�������� ������ ������ ���������: <input type=text name=new_klichka class=inup size='25' maxlength='30'> <INPUT TYPE='submit' VALUE=' ������� ������ '  name=chg_klichka CLASS='but'> (<i>������� ������</i> - <b>".PRICE_ZVER." ��.</b>)
		</td>
	</tr></table>
	</FORM>";
?>