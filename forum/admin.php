<?
include_once ('key.php');
ob_start("ob_gzhandler");
include_once ("conf.php");
include_once ("functions.php");
$login=$_SESSION["login"];
Header("Cache-Control: no-cache, must-revalidate"); // ������� �������� ���-�� �� �� ��������� ��� ��������
Header("Pragma: no-cache");

?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<meta http-equiv="Content-Language" content="ru">
	<meta http-equiv=Cache-Control Content=no-cache>
	<meta http-equiv=PRAGMA content=NO-CACHE>
	<meta http-equiv=Expires content=0>	
	<LINK rel="stylesheet" type="text/css" href="main.css">
</head>	
<body bgcolor="#faeede">
<SCRIPT LANGUAGE="JavaScript" SRC="scripts/orden.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" SRC="commoninf.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" SRC="scripts/magic-main.js"></SCRIPT>
<div id=hint4></div>
<?
$data = mysql_connect($base_name, $base_user, $base_pass) or die('�� ���������� ������������. ��������� ��� �������, ��� ������������ � ������!');
mysql_select_db($db_name) or die('������ ����� � ���� ������');

$db=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE login='".$login."'"));
if ($db["orden"]==1 && $db["admin_level"]>8)
{
	$db_orden=$db["orden"];
	$db_admin_level=$db["admin_level"];
	$db_adminsite=$db["adminsite"];
	echo "<table width=100% border=0><tr><td width=100%><h3>�������</h3></td>
		<td align=right valign=top nowrap>
			<INPUT TYPE=button value=\"��������\" onClick=\"location.href='admin.php'\"> 
			<INPUT TYPE=button value=\"���������\" onClick=\"location.href='main.php?act=none'\">
		</td></table>";
    if($db["adminsite"]>2 || $db["login"]=="Archanel" || $db["login"]=="OBITEL")
    {
    	echo "<b style='color:#990000'>��������� ������ ��������...</b><br>";
    	echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"findlogin('��������� �����', '?spell=11', 'target', '',4)\" class=us2 title='��������� �����.'>::��������� �����</a><BR>";           	
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"takemoney('������� ������ � ���������', '?spell=takemoney', 'target', '',4)\" class=us2 title='������� ������ � ���������.'>::������� ������ � ���������</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"takeplatina('������� ������� � ���������', '?spell=takeplatina', 'target', '',4)\" class=us2 title='������� ������� � ���������.'>::������� ������� � ���������</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"takenaqrada('������� ������� � ���������', '?spell=takenaqrada', 'target', '',4)\" class=us2 title='������� ������� � ���������.'>::������� ������� � ���������</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"takemoneybank('������� ������ � �����', '?spell=takemoneybank', 'target', '',4)\" class=us2 title='������� ������ � �����.'>::������� ������ � �����</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"takeplatinabank('������� ������� � �����', '?spell=takeplatinabank', 'target', '',4)\" class=us2 title='������� ������� � �����.'>::������� ������� � �����</a><BR>";

		echo "<br><b style='color:#990000'>������������ ip</b><br>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"ipblok('������������ IP', '?spell=ip_blok', 'target', '',4)\" class=us2 title='������������ IP'>::������������ IP</a><BR>";
	}
    if($db["admin_level"]>=10)
    {
		echo "<br><b style='color:#990000'>��������� �����...</b><br>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"marry('��������', '?spell=marry', 'target', '',4)\" class=us2 title='��������.'>::��������</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"findlogin('��������� ������� ���', '?spell=razvod', 'target', '',4)\" class=us2 title='��������� ������� ���.'>::��������� ������� ���</a><BR>";

		
		echo "<br><b style='color:#990000'>10 ����. ����� ��..</b><br>";
		echo "&nbsp; &nbsp; &nbsp; <a href='?spell=com'  class=us2 title='����. �����.'>::����. �����</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='?spell=compl'  class=us2 title='����. �����. �����'>::����. �����. �����</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='?spell=smscoin'  class=us2 title='SMS COIN'>::SMS COIN</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='?spell=com_runa'  class=us2 title='����������� ������� '>::����������� �������</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='?spell=clan_perevod'  class=us2 title='�������� �������'>::�������� �������</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='?spell=naqruzka'  class=us2 title='������� �������� �������'>::������� �������� �������</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='chat_archive.php'  class=us2 title='�������� ��� ����' target='_blank'>::�������� ��� ����</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='?spell=turnir' class=us2 title='�������� ������'>::�������� ������</a><BR><BR>";
		
		echo "&nbsp; &nbsp; &nbsp; <a href='?spell=svet_tma' class=us2 title='���� vs. ����'>::���� vs. ����</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='?spell=chaos_battle' class=us2 title='��� � �������� �����'>::��� � �������� �����</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='?spell=haot' class=us2 title='��������� ���'>::��������� ���</a><BR><BR>";

		
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"findlogin('������� �������', '?spell=peredacha', 'target', '',4)\" class=us2 title='������� �������'>::������� �������</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"findlogin('������� ��������', '?spell=take_obez', 'target', '',4)\" class=us2 title='������� ��������'>::������� ��������</a><BR>";
    	echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"fear('��������', '?spell=666', 'target', '',4)\" class=us2 title='��������.'>::��������</a><BR>";
    	echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"fear('�������� �������', '?spell=777', 'target', '',4)\" class=us2 title='�������� �������.'>::�������� �������</a><BR>";		
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"findlogin('������ �������', '?spell=del_gift', 'target', '',4)\" class=us2 title='������ �������'>::������ �������</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"findlogin('������� �� �����', '?spell=clanout', 'target', '',4)\" class=us2 title='������� �� �����.'>::������� �� �����</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"findlogin('���������� ���������', '?spell=6', 'target', '',4)\" class=us2 title='���������� ���������.'>::���������� ���������</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"silent('�������� �� 2 �����', '?spell=molch2880', 'target', '',4)\" class=us2 title='�������� �� 2 �����'>::�������� �� 2 �����</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"findlogin('��������� ��������� �� ������.', '?spell=xaos_del', 'target', '',4)\" class=us2 title='��������� ��������� �� ������.'>::��������� ��������� �� ������.</a><BR>";
    	echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"takeOrden('������� ��������� � �����', '?spell=7', 'target', '',4)\" class=us2 title='������� ��������� � �����.'>::������� ��������� � �����</a><BR>";
    	echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"loginBlok('������� ��������� �� ������', '?spell=8', 'target', '',4)\" class=us2 title='������� ��������� �� ������.'>::������� ��������� �� ������</a><BR>";
    	echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"HP('������������ HP ������ ���������', '?spell=87', 'target', '',4)\" class=us2 title='������������ HP ������ ���������.'>::������������ HP ������ ���������</a><BR>";
    	echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"HP('������������ MANA ������ ���������', '?spell=mana', 'target', '',4)\" class=us2 title='������������ MANA ������ ���������.'>::������������ MANA ������ ���������</a><BR>";
    	echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"HP('������ ������� � ���������', '?spell=79', 'target', '',4)\" class=us2 title='������ ������� � ���������.'>::������ ������� � ���������</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"naqrada('��������� ��������� �������', '?spell=naqrada', 'target', '',4)\" class=us2 title='��������� ��������� �������'>::��������� ��������� �������</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"naqrada('������� ����� � ���������', '?spell=take_naqrada', 'target', '',4)\" class=us2 title='������� ����� � ���������'>::������� ����� � ���������</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"HP('�������� ��������� �� �����', '?spell=85', 'target', '',4)\" class=us2 title='�������� ��������� �� �����.'>::�������� ��������� �� �����</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"findlogin('MANA ile bagli BAQ', '?spell=mana_baq', 'target', '',4)\" class=us2 title='MANA ile bagli BAQ'>::MANA ile bagli BAQ</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"findlogin('HP ile bagli BAQ', '?spell=hp_baq', 'target', '',4)\" class=us2 title='HP ile bagli BAQ'>::HP ile bagli BAQ</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"findlogin('MF ile bagli BAQ', '?spell=mf_baq', 'target', '',4)\" class=us2 title='MF ile bagli BAQ'>::MF ile bagli BAQ</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"findlogin('BRONYA ile bagli BAQ', '?spell=bron_baq', 'target', '',4)\" class=us2 title='BRONYA ile bagli BAQ'>::BRONYA ile bagli BAQ</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"findlogin('VLADENIYA ile bagli BAQ', '?spell=vladeniya_baq', 'target', '',4)\" class=us2 title='VLADENIYA ile bagli BAQ'>::VLADENIYA ile bagli BAQ</a><BR><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"findlogin('BATTLE BAQ', '?spell=zay_admin', 'target', '',4)\" class=us2 title='BATTLE BAQ'>::BATTLE BAQ</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"findlogin('PODZEMKA BAQ', '?spell=podzemka_baq', 'target', '',4)\" class=us2 title='PODZEMKA BAQ'>::PODZEMKA BAQ</a><BR><BR>";
		#echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"findlogin('ALL BAQ', '?spell=all_baq', 'target', '',4)\" class=us2 title='ALL BAQ'>::ALL BAQ</a><BR>";

    }
    if($db["adminsite"]>2 || $db["login"]=="OBITEL")
    {
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"findlogin('Find Password', '?spell=pass', 'target', '',4)\" class=us2 title='Find Password.'>::Find Password</a><BR>";
    }
	if($db["adminsite"]>2)
    {
    	echo "<br><b style='color:red'>������������� www.OlDmeydan.Pe.Hu</b><br>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"findlogin('ID to Login', '?spell=id', 'target', '',4)\" class=us2 title='ID to Login'>::ID to Login</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"findlogin('Last Request Time', '?spell=lrt', 'target', '',4)\" class=us2 title='Last Request Time'>::Last Request Time</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"findlogin('���� ������ ������', '?spell=chgsecpass', 'target', '',4)\" class=us2 title='���� ������ ������'>::���� ������ ������</a><BR>";		
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"changepol('������� ���', '?spell=89', 'target', '',4)\" class=us2 title='������� ���.'>::������� ���</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"cnglogin('������� ���', '?spell=chglogin', 'target', '',4)\" class=us2 title='������� ���.'>::������� ���</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"cngmail('������� E-mail', '?spell=chgmail', 'target', '',4)\" class=us2 title='������� E-mail.'>::������� E-mail</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"cngpass('������� ������', '?spell=chgpass', 'target', '',4)\" class=us2 title='������� ������.'>::������� ������</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"findlogin('Find Password', '?spell=pass', 'target', '',4)\" class=us2 title='Find Password.'>::Find Password</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"findlogin('Find Inventar Password', '?spell=pass_inv', 'target', '',4)\" class=us2 title='Find Inventar Password.'>::Find Inventar Password</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"dealer('������� ��������� � �������', '?spell=81', 'target', '',4)\" class=us2 title='������� ��������� � �������.'>::������� ��������� � �������</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"vip('������� ��������� � V.I.P ����', '?spell=80', 'target', '',4)\" class=us2 title='������� ��������� � V.I.P ����.'>::������� ��������� � V.I.P ����</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"profession('��������� ���������', '?spell=83', 'target', '',4)\" class=us2 title='��������� ���������.'>::��������� ���������</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"status('��������� ������', '?spell=84', 'target', '',4)\" class=us2 title='��������� ������.'>::��������� ������</a><BR><BR><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"findlogin('�������� ��������� �� ����', '?spell=del_user', 'target', '',4)\" class=us2 title='�������� ��������� �� ����'>::�������� ��������� �� ����</a><BR>";
	}
	//------------------------------------------------------------------------------------------------------------
	echo '<DIV id="Layer1" style="Z-INDEX: 1; LEFT: 400px; TOP: 30px; POSITION: absolute;  "><br>';
	$spell=$_GET['spell'];
	if(!empty($spell))
	{
		switch ($spell)
		{
			case "id":include "magic/1/id.php";break;
			case "6":include "magic/1/6.php";break;
			case "pass":include "magic/1/pass.php";break;
			case "pass_inv":include "magic/1/pass_inv.php";break;
			
			case "chgsecpass":include "magic/1/chgsecpass.php";break;
			case "com":include "magic/1/com.php";break;
			case "compl":include "magic/1/compl.php";break;
			case "smscoin":include "magic/1/smscoin.php";break;
			case "clan_perevod":include "magic/1/clan_perevod.php";break;
			case "naqruzka":include "magic/1/naqruzka.php";break;
			case "84":include "magic/1/84.php";break;
			case "80":include "magic/1/80.php";break;
			case "81":include "magic/1/81.php";break;
			case "83":include "magic/1/83.php";break;
			case "85":include "magic/1/85.php";break;
			case "svet_tma":include "magic/1/svet_tma.php";break;
			case "chaos_battle":include "magic/1/chaos_battle.php";break;
			case "haot":include "magic/1/haot.php";break;
			case "chglogin":include "magic/1/chglogin.php";break;
			case "chgmail":include "magic/1/chgmail.php";break;
			case "chgpass":include "magic/1/chgpass.php";break;
			case "89":include "magic/1/89.php";break;
			case "lrt":include "magic/1/lrt.php";break;
			case "mana_baq":include "magic/1/mana_baq.php";break;
			case "hp_baq":include "magic/1/hp_baq.php";break;
			case "naqrada":include "magic/1/naqrada.php";break;
			case "take_naqrada":include "magic/1/take_naqrada.php";break;
			case "79":include "magic/1/79.php";break;
			case "mana":include "magic/1/mana.php";break;
			case "87":include "magic/1/87.php";break;
			case "7":include "magic/1/7.php";break;
			case "8":include "magic/1/8.php";break;
			case "xaos_del":include "magic/1/xaos_del.php";break;
			case "11":include "magic/1/11.php";break;
			case "takemoney":include "magic/1/takemoney.php";break;
			case "takeplatina":include "magic/1/takeplatina.php";break;
			case"takeplatinabank":include "magic/1/takeplatinabank.php";break;
			case "takemoneybank":include "magic/1/takemoneybank.php";break;
			case "ip_blok":include "magic/1/ip_blok.php";break;
			case "marry":include "magic/1/marry.php";break;
			case "razvod":include "magic/1/razvod.php";break;
			case "turnir":include "magic/1/turnir.php";break;
			case "take_obez":include "magic/1/take_obez.php";break;
			case "peredacha":include "magic/1/peredacha.php";break;
			case "666":include "magic/1/666.php";break;
			case "777":include "magic/1/777.php";break;
			case "del_gift":include "magic/1/del_gift.php";break;
			case "clanout":include "magic/1/clanout.php";break;
			case "molch2880":include "magic/1/molch2880.php";break;
			case "takenaqrada":include "magic/1/takenaqrada.php";break;
			case "mf_baq":include "magic/1/mf_baq.php";break;
			case "bron_baq":include "magic/1/bron_baq.php";break;
			case "vladeniya_baq":include "magic/1/vladeniya_baq.php";break;
			case "del_user":include "magic/1/del_user.php";break;
			case "com_runa":include "magic/1/com_runa.php";break;
			case "zay_admin":include "magic/1/zay_admin.php";break;
			case "podzemka_baq":include "magic/1/podzemka_baq.php";break;
			case "all_baq":include "magic/1/all_baq.php";break;
		}
	}
	echo "</div>";
}
else echo "��� ���� ������!";
mysql_close($data);
?>