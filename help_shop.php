<?
include_once("key.php");
include_once("conf.php");
include_once("functions.php");
include_once("item_des.php");
ob_start("ob_gzhandler");
Header("Cache-Control: no-cache, must-revalidate"); // говорим браузеру что-бы он не кешировал эту страницу
Header("Pragma: no-cache");
$login=$_SESSION['login'];
$data = mysql_connect($base_name, $base_user, $base_pass) or die('Не получается подключиться. Проверьте имя сервера, имя пользователя и пароль!');
mysql_select_db($db_name) or die('Ошибка входа в базу данных');

$result = mysql_query("SELECT users.*,zver.id as zver_count,zver.obraz as zver_obraz,zver.level as zver_level,zver.name as zver_name,zver.type as zver_type FROM `users` LEFT join zver on zver.owner=users.id  and zver.sleep=0 WHERE login='".$login."'");
$db = mysql_fetch_assoc($result);
##==============================================================
if ($_GET["cek"])
{
	$have_chek=mysql_fetch_Array(mysql_query("SELECT id FROM inv WHERE owner='".$login."' and object_type='wood' and object_id=22 LIMIT 1"));
	if ($have_chek)
	{
		mysql_Query("UPDATE users SET money=money+100 WHERE login='".$login."'");
		mysql_query("DELETE FROM inv WHERE id=".$have_chek["id"]);
		$msg="<font color=red>Обналичен чек на 100.00 Зл.</font><br>";
		history($login,"Обналичен чек","Обналичен чек на 100.00 Зл",$db["remote_ip"],"Торговец Вискаль");
	}
	else $msg="<font color=red>Не найден чек <img src=img/wood/cek.gif></font><br>";
}
##==============================================================
if ($_GET["cek_art"])
{
	$have_chek=mysql_fetch_Array(mysql_query("SELECT id FROM inv WHERE owner='".$login."' and object_type='wood' and object_id=23 LIMIT 1"));
	if ($have_chek)
	{
		$del_time=time()+7*24*60*60;
		$buy_item=mysql_fetch_assoc(mysql_query("SELECT * FROM paltar WHERE id=975"));
		mysql_query("LOCK TABLES inv WRITE");
		mysql_query("INSERT INTO `inv` (`id`, `owner`, `img`, `object_id`, `object_type`, `object_razdel`, `name`, `term`, `mass`, `price`, `gos_price`, `min_sila`, `min_lovkost`, `min_udacha`, `min_power`, `min_intellekt`, `min_vospriyatie`, `min_level`, `min_sword_vl`, `min_staff_vl`, `min_axe_vl`, `min_fail_vl`, `min_knife_vl`, `min_spear_vl`,`min_fire`,`min_water`,`min_air`,`min_earth`,`min_svet`,`min_tma`,`min_gray`,`add_fire`, `add_water`, `add_air`, `add_earth`, `add_svet`, `add_tma`, `add_gray`, `add_sila`, `add_lovkost`, `add_udacha`, `add_intellekt`, `add_duxovnost`, `add_hp`, `add_mana`, `protect_head`, `protect_arm`, `protect_corp`, `protect_poyas`, `protect_legs`, `protect_rej`, `protect_drob`, `protect_kol`, `protect_rub`, `protect_fire`, `protect_water`, `protect_air`, `protect_earth`, `protect_svet`, `protect_tma`, `protect_gray`,`protect_mag`,`protect_udar`, `shieldblock`, `krit`, `akrit`, `uvorot`, `auvorot`, `parry`, `counter`, `add_rej`, `add_drob`, `add_kol`, `add_rub`, `ms_udar`, `ms_krit`, `ms_mag`, `ms_fire`, `ms_water`, `ms_air`, `ms_earth`, `ms_svet`, `ms_tma`, `ms_gray`, `ms_rej`, `ms_drob`, `ms_kol`, `ms_rub`, `iznos_max`, `min_attack`, `max_attack`, `proboy`, `add_oruj`, `add_sword_vl`, `add_staff_vl`, `add_axe_vl`, `add_fail_vl`, `add_knife_vl`, `add_spear_vl`, `need_orden`, `sex`, `art`, `podzemka`, `is_personal`, `personal_owner`, `noremont`, `two_hand`, `second_hand`,  `add_fire_att`, `add_air_att`, `add_watet_att`, `add_earth_att`, `edited`) 
			VALUES (NULL, '".$login."','".$buy_item["img"]."' ,'".$buy_item["id"]."', '".$buy_item["object"]."', 'obj', '".$buy_item["name"]."', '".$del_time."', '".$buy_item["mass"]."', '".$buy_item["price"]."', '".$gos_price."', '".$buy_item["min_sila"]."', '".$buy_item["min_lovkost"]."', '".$buy_item["min_udacha"]."', '".$buy_item["min_power"]."', '".$buy_item["min_intellekt"]."', '".$buy_item["min_vospriyatie"]."', '".$buy_item["min_level"]."', '".$buy_item["min_sword_vl"]."', '".$buy_item["min_staff_vl"]."', '".$buy_item["min_axe_vl"]."', '".$buy_item["min_fail_vl"]."', '".$buy_item["min_knife_vl"]."', '".$buy_item["min_spear_vl"]."', '".$buy_item["min_fire"]."','".$buy_item["min_water"]."','".$buy_item["min_air"]."','".$buy_item["min_earth"]."','".$buy_item["min_svet"]."','".$buy_item["min_tma"]."','".$buy_item["min_gray"]."', '".$buy_item["add_fire"]."', '".$buy_item["add_water"]."', '".$buy_item["add_air"]."', '".$buy_item["add_earth"]."', '".$buy_item["add_svet"]."', '".$buy_item["add_tma"]."', '".$buy_item["add_gray"]."', '".$buy_item["add_sila"]."', '".$buy_item["add_lovkost"]."', '".$buy_item["add_udacha"]."', '".$buy_item["add_intellekt"]."', '".$buy_item["add_duxovnost"]."', '".$buy_item["add_hp"]."', '".$buy_item["add_mana"]."', '".$buy_item["protect_head"]."', '".$buy_item["protect_arm"]."', '".$buy_item["protect_corp"]."', '".$buy_item["protect_poyas"]."', '".$buy_item["protect_legs"]."', '".$buy_item["protect_rej"]."', '".$buy_item["protect_drob"]."', '".$buy_item["protect_kol"]."', '".$buy_item["protect_rub"]."', '".$buy_item["protect_fire"]."', '".$buy_item["protect_water"]."', '".$buy_item["protect_air"]."', '".$buy_item["protect_earth"]."', '".$buy_item["protect_svet"]."', '".$buy_item["protect_tma"]."', '".$buy_item["protect_gray"]."', '".$buy_item["protect_mag"]."', '".$buy_item["protect_udar"]."','".$buy_item["shieldblock"]."','".$buy_item["krit"]."', '".$buy_item["akrit"]."', '".$buy_item["uvorot"]."', '".$buy_item["auvorot"]."', '".$buy_item["parry"]."', '".$buy_item["counter"]."', '".$buy_item["add_rej"]."', '".$buy_item["add_drob"]."', '".$buy_item["add_kol"]."', '".$buy_item["add_rub"]."', '".$buy_item["ms_udar"]."', '".$buy_item["ms_krit"]."', '".$buy_item["ms_mag"]."', '".$buy_item["ms_fire"]."', '".$buy_item["ms_water"]."', '".$buy_item["ms_air"]."', '".$buy_item["ms_earth"]."', '".$buy_item["ms_svet"]."', '".$buy_item["ms_tma"]."', '".$buy_item["ms_gray"]."', '".$buy_item["ms_rej"]."', '".$buy_item["ms_drob"]."', '".$buy_item["ms_kol"]."', '".$buy_item["ms_rub"]."', '".$buy_item["iznos_max"]."', '".$buy_item["min_attack"]."', '".$buy_item["max_attack"]."', '".$buy_item["proboy"]."','".$buy_item["add_oruj"]."' ,'".$buy_item["add_sword_vl"]."', '".$buy_item["add_staff_vl"]."', '".$buy_item["add_axe_vl"]."', '".$buy_item["add_fail_vl"]."', '".$buy_item["add_knife_vl"]."', '".$buy_item["add_spear_vl"]."', '".$buy_item["need_orden"]."', '".$buy_item["sex"]."', '".$buy_item["art"]."', '".$buy_item["podzemka"]."', '".$buy_item["is_personal"]."', '".$buy_item["personal_owner"]."', '".$buy_item["noremont"]."', '".$buy_item["two_hand"]."', '".$buy_item["second_hand"]."',  '".$buy_item["add_fire_att"]."', '".$buy_item["add_air_att"]."', '".$buy_item["add_watet_att"]."', '".$buy_item["add_earth_att"]."', '".$buy_item["edited"]."');");
		mysql_query("UNLOCK TABLES");
		mysql_query("DELETE FROM inv WHERE id=".$have_chek["id"]);
		$msg="<font color=red>Обналичен Чек на АРТ на неделю на <b>".$buy_item["name"]."</b></font> <img src=img/items/".$buy_item["img"]."><br>";
		history($login,"Обналичен чек","Обналичен чек на АРТ",$db["remote_ip"],"Торговец Вискаль");
	}
	else $msg="<font color=red>Не найден чек <img src=img/wood/cek_art.gif></font><br>";
}
##==============================================================
if ($_GET["cek_scroll"])
{
	$have_chek=mysql_fetch_Array(mysql_query("SELECT id FROM inv WHERE owner='".$login."' and object_type='wood' and object_id=24 LIMIT 1"));
	if ($have_chek)
	{
		switch ($_GET["item_id"])
		{
			case 1: $item_id=229; break;
			case 2: $item_id=230; break;
			default:$item_id=229; break;
		}	
		$buy_item = mysql_fetch_array(mysql_query("SELECT * FROM scroll WHERE id=".$item_id));
		if ($buy_item)
		{	
			if ($buy_item["del_time"])
			{
				$del_time= time() + $buy_item["del_time"]*24*3600;
			}
			mysql_query("LOCK TABLES inv WRITE");
			mysql_query("INSERT INTO inv(owner,object_id,object_type,object_razdel,wear,iznos,iznos_max,term, gift, gift_author) 
			VALUES ('".$login."','".$buy_item["id"]."','scroll','magic','0','0','".$buy_item["iznos_max"]."','".$del_time."',1,'Торговец Вискаль')");
			mysql_query("UNLOCK TABLES");
		
			mysql_query("DELETE FROM inv WHERE id=".$have_chek["id"]);
			$msg="<font color=red>Обналичен Чек на Эликсир на <b>".$buy_item["name"]."</b></font> <img src=img/".$buy_item["img"]."><br>";
			history($login,"Обналичен чек","Обналичен чек на Эликсир",$db["remote_ip"],"Торговец Вискаль");
		}
	}
	else $msg="<font color=red>Не найден чек <img src=img/wood/cek_scroll.gif></font><br>";
}
?>
<html>
<HEAD>	
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<meta http-equiv="Content-Language" content="ru">
	<META Http-Equiv=Cache-Control Content="no-cache, max-age=0, must-revalidate, no-store">
	<meta http-equiv=PRAGMA content=NO-CACHE>
	<meta http-equiv=Expires content=0>	
	<LINK REL=StyleSheet HREF='main.css' TYPE='text/css'>
</HEAD>
<body bgcolor="#faeede">
<DIV id="slot_info" style="VISIBILITY: hidden; POSITION: absolute;z-index: 1;"></DIV>
<script language="JavaScript" type="text/javascript" src="show_inf.js"></script>
<script language="JavaScript" type="text/javascript" src="commoninf.js"></script>
<script language="JavaScript" type="text/javascript" src="glow.js"></script>

<script>
function talk(phrase)
{
	if(phrase==0)
	{
		document.location.href='main.php?act=none';
	}
	if(phrase==1)
	{
		document.location.href='?cek=true';
	}
	if(phrase==2)
	{
		document.location.href='?cek_art=true';
	}
	if(phrase==3)
	{
		document.location.href='?cek_scroll=true&item_id=1';
	}
	if(phrase==4)
	{
		document.location.href='?cek_scroll=true&item_id=2';
	}
}
function dialog()
{
	bernard.innerHTML='<B>Торговец Вискаль:</B><BR>'+
	'Вэллкам в мой магазин, сэр!!!<BR><BR>'+
	'У нас есть все, чего бы вы ни пожелали - по разумным ценам. <br>'+
	'<?=$msg;?>'+	
	'<BR><a href="javascript:talk(1)" class=us2><B>• Обналичить Чек на <B>100.00 Зл.</B></a> <img src="img/wood/cek.gif">'+
	'<BR><a href="javascript:talk(2)" class=us2><B>• Обналичить Чек на АРТ на неделю</a> <img src="img/wood/cek_art.gif">'+
	'<BR><a href="javascript:talk(3)" class=us2><B>• Обналичить Чек на Эликсир на "Эликсир злых намерений" (для мага)</a> <img src="img/wood/cek_scroll.gif">'+
	'<BR><a href="javascript:talk(4)" class=us2><B>• Обналичить Чек на Эликсир на "Эликсир добрых намерений" (для воина)</a> <img src="img/wood/cek_scroll.gif">'+
	'<BR><BR><a href="javascript:talk(0)" class=us2><B>• Завершить диалог</B></a>';
}

</script>

<SCRIPT language="JavaScript" type="text/javascript" src="fight.js"></SCRIPT>
<h3>Диалог с "Торговец Вискаль"</h3>
<table width=100% border=0>
<tr>
	<td width=210 valign=top>
		<?
			showHPbattle($db);
			showPlayer($db);
		?>
	</td>
	<td valign=top><br>
		<table border=0 width=100% cellpadding=1 cellspacing=1 align=left><tr><td>
			<div id='bernard'></div>
			<script>dialog();</script>
		</td></tr></table>
	</td>
	<td width=210 valign=top>
	<?
		$bot=mysql_fetch_Array(mysql_query("SELECT * FROM users WHERE login='Торговец Вискаль'"));
		showHPbattle($bot);
		showPlayer($bot);
	?>
	</td>
</tr>
</table>