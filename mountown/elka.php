<?
$login=$_SESSION['login'];
$date_birth=2007;
$year=2011;
include ("time.php");
if ((date(n)==8 && date(j)<20) || (date(n)==7 && date(j)>=27)) {$text_type=1;$h3="С днем рождения!!! Нам ".(date("Y")-$date_birth)." года (06.08.$year) ";} //birthday
else if ((date(n)==12 && date(j)>=1) || (date(n)==5 && date(j)<=30)  || $db["adminsite"]) {$text_type=2;$h3="Новогодняя ёлка";}//New Year
$birth=explode("-",$db["date"]);
$birth=explode(".",$birth[0]);
if ($birth[2]<=2008) $veteran=1;
//---------------------------------------------------
if ($_GET['action']=="del" && is_numeric($_GET['id']) && $db["admin_level"]>=1)
{
	mysql_query("UPDATE elka SET text='<font color=#ff0000><i>Удалено Представителям порядка ".$login."</i></font>' WHERE id='".(int)$_GET['id']."'");
}
//-----------------Birth Day Gift-----------------------------
if ($_GET['action']=="getbirth")
{
	if (date(n)==8 && (date(j)==4 || date(j)==5 || date(j)==6 || date(j)==7  || date(j)==8 || date(j)==9))
	{
		$findpodarka = @mysql_fetch_array(mysql_query("SELECT * FROM elkapodarka WHERE login='".$login."' and type=1"));
		if (!$findpodarka)
		{
			if ($db["level"]<8)$get_item_id=1082; else $get_item_id=817;
			$buy_item=mysql_fetch_assoc(mysql_query("SELECT * FROM paltar WHERE id=$get_item_id"));
			$veteran_item=mysql_fetch_assoc(mysql_query("SELECT * FROM paltar WHERE id=1083"));

			mysql_query("LOCK TABLES inv WRITE");
			if ($veteran==1)
			{
				mysql_query("INSERT INTO `inv` (`id`, `owner`, `img`, `gift`, `gift_author` , `object_id`, `object_type`, `object_razdel`, `name`,  `mass`, `price`, `gos_price`, `min_sila`, `min_lovkost`, `min_udacha`, `min_power`, `min_intellekt`, `min_vospriyatie`, `min_level`, `min_sword_vl`, `min_staff_vl`, `min_axe_vl`, `min_fail_vl`, `min_knife_vl`, `min_spear_vl`,`min_fire`,`min_water`,`min_air`,`min_earth`,`min_svet`,`min_tma`,`min_gray`,`add_fire`, `add_water`, `add_air`, `add_earth`, `add_svet`, `add_tma`, `add_gray`, `add_sila`, `add_lovkost`, `add_udacha`, `add_intellekt`, `add_duxovnost`, `add_hp`, `add_mana`, `protect_head`, `protect_arm`, `protect_corp`, `protect_poyas`, `protect_legs`, `protect_rej`, `protect_drob`, `protect_kol`, `protect_rub`, `protect_fire`, `protect_water`, `protect_air`, `protect_earth`, `protect_svet`, `protect_tma`, `protect_gray`,`protect_mag`,`protect_udar`, `shieldblock`, `krit`, `akrit`, `uvorot`, `auvorot`, `parry`, `counter`, `add_rej`, `add_drob`, `add_kol`, `add_rub`, `ms_udar`, `ms_krit`, `ms_mag`, `ms_fire`, `ms_water`, `ms_air`, `ms_earth`, `ms_svet`, `ms_tma`, `ms_gray`, `ms_rej`, `ms_drob`, `ms_kol`, `ms_rub`, `iznos_max`, `min_attack`, `max_attack`, `proboy`, `add_oruj`, `add_sword_vl`, `add_staff_vl`, `add_axe_vl`, `add_fail_vl`, `add_knife_vl`, `add_spear_vl`, `need_orden`, `sex`, `art`, `podzemka`, `is_personal`, `personal_owner`, `noremont`, `two_hand`, `second_hand`,  `add_fire_att`, `add_air_att`, `add_watet_att`, `add_earth_att`, `edited`) 
				VALUES (NULL, '".$login."','".$veteran_item["img"]."' ,'1','Администрации WWW.OlDmeydan.Pe.Hu' ,'".$veteran_item["id"]."', '".$veteran_item["object"]."', 'obj', '".$veteran_item["name"]."', '".$veteran_item["mass"]."', '".$veteran_item["price"]."', '".$veteran_item["price"]."', '".$veteran_item["min_sila"]."', '".$veteran_item["min_lovkost"]."', '".$veteran_item["min_udacha"]."', '".$veteran_item["min_power"]."', '".$veteran_item["min_intellekt"]."', '".$veteran_item["min_vospriyatie"]."', '".$veteran_item["min_level"]."', '".$veteran_item["min_sword_vl"]."', '".$veteran_item["min_staff_vl"]."', '".$veteran_item["min_axe_vl"]."', '".$veteran_item["min_fail_vl"]."', '".$veteran_item["min_knife_vl"]."', '".$veteran_item["min_spear_vl"]."', '".$veteran_item["min_fire"]."','".$veteran_item["min_water"]."','".$veteran_item["min_air"]."','".$veteran_item["min_earth"]."','".$veteran_item["min_svet"]."','".$veteran_item["min_tma"]."','".$veteran_item["min_gray"]."', '".$veteran_item["add_fire"]."', '".$veteran_item["add_water"]."', '".$veteran_item["add_air"]."', '".$veteran_item["add_earth"]."', '".$veteran_item["add_svet"]."', '".$veteran_item["add_tma"]."', '".$veteran_item["add_gray"]."', '".$veteran_item["add_sila"]."', '".$veteran_item["add_lovkost"]."', '".$veteran_item["add_udacha"]."', '".$veteran_item["add_intellekt"]."', '".$veteran_item["add_duxovnost"]."', '".$veteran_item["add_hp"]."', '".$veteran_item["add_mana"]."', '".$veteran_item["protect_head"]."', '".$veteran_item["protect_arm"]."', '".$veteran_item["protect_corp"]."', '".$veteran_item["protect_poyas"]."', '".$veteran_item["protect_legs"]."', '".$veteran_item["protect_rej"]."', '".$veteran_item["protect_drob"]."', '".$veteran_item["protect_kol"]."', '".$veteran_item["protect_rub"]."', '".$veteran_item["protect_fire"]."', '".$veteran_item["protect_water"]."', '".$veteran_item["protect_air"]."', '".$veteran_item["protect_earth"]."', '".$veteran_item["protect_svet"]."', '".$veteran_item["protect_tma"]."', '".$veteran_item["protect_gray"]."', '".$veteran_item["protect_mag"]."', '".$veteran_item["protect_udar"]."','".$veteran_item["shieldblock"]."','".$veteran_item["krit"]."', '".$veteran_item["akrit"]."', '".$veteran_item["uvorot"]."', '".$veteran_item["auvorot"]."', '".$veteran_item["parry"]."', '".$veteran_item["counter"]."', '".$veteran_item["add_rej"]."', '".$veteran_item["add_drob"]."', '".$veteran_item["add_kol"]."', '".$veteran_item["add_rub"]."', '".$veteran_item["ms_udar"]."', '".$veteran_item["ms_krit"]."', '".$veteran_item["ms_mag"]."', '".$veteran_item["ms_fire"]."', '".$veteran_item["ms_water"]."', '".$veteran_item["ms_air"]."', '".$veteran_item["ms_earth"]."', '".$veteran_item["ms_svet"]."', '".$veteran_item["ms_tma"]."', '".$veteran_item["ms_gray"]."', '".$veteran_item["ms_rej"]."', '".$veteran_item["ms_drob"]."', '".$veteran_item["ms_kol"]."', '".$veteran_item["ms_rub"]."', '".$veteran_item["iznos_max"]."', '".$veteran_item["min_attack"]."', '".$veteran_item["max_attack"]."', '".$veteran_item["proboy"]."','".$veteran_item["add_oruj"]."' ,'".$veteran_item["add_sword_vl"]."', '".$veteran_item["add_staff_vl"]."', '".$veteran_item["add_axe_vl"]."', '".$veteran_item["add_fail_vl"]."', '".$veteran_item["add_knife_vl"]."', '".$veteran_item["add_spear_vl"]."', '".$veteran_item["need_orden"]."', '".$veteran_item["sex"]."', '".$veteran_item["art"]."', '".$veteran_item["podzemka"]."', '".$veteran_item["is_personal"]."', '".$veteran_item["personal_owner"]."', '".$veteran_item["noremont"]."', '".$veteran_item["two_hand"]."', '".$veteran_item["second_hand"]."',  '".$veteran_item["add_fire_att"]."', '".$veteran_item["add_air_att"]."', '".$veteran_item["add_watet_att"]."', '".$veteran_item["add_earth_att"]."', '".$veteran_item["edited"]."');");
				$have_medal=@mysql_fetch_Array(mysql_Query("SELECT count(*) FROM inv WHERE owner='".$login."' and object_type='medal' and object_id=7"));
				if (!$have_medal[0]) mysql_query("INSERT INTO inv(owner,object_id,object_type,object_razdel,gift,wear,gift_author) VALUES('".$login."','7','medal','medal','1','0','Администрации WWW.OlDmeydan.Pe.Hu')");#Медал Ветеран
			}
			mysql_query("INSERT INTO `inv` (`id`, `owner`, `img`, `gift`, `gift_author` , `object_id`, `object_type`, `object_razdel`, `name`,  `mass`, `price`, `gos_price`, `min_sila`, `min_lovkost`, `min_udacha`, `min_power`, `min_intellekt`, `min_vospriyatie`, `min_level`, `min_sword_vl`, `min_staff_vl`, `min_axe_vl`, `min_fail_vl`, `min_knife_vl`, `min_spear_vl`,`min_fire`,`min_water`,`min_air`,`min_earth`,`min_svet`,`min_tma`,`min_gray`,`add_fire`, `add_water`, `add_air`, `add_earth`, `add_svet`, `add_tma`, `add_gray`, `add_sila`, `add_lovkost`, `add_udacha`, `add_intellekt`, `add_duxovnost`, `add_hp`, `add_mana`, `protect_head`, `protect_arm`, `protect_corp`, `protect_poyas`, `protect_legs`, `protect_rej`, `protect_drob`, `protect_kol`, `protect_rub`, `protect_fire`, `protect_water`, `protect_air`, `protect_earth`, `protect_svet`, `protect_tma`, `protect_gray`,`protect_mag`,`protect_udar`, `shieldblock`, `krit`, `akrit`, `uvorot`, `auvorot`, `parry`, `counter`, `add_rej`, `add_drob`, `add_kol`, `add_rub`, `ms_udar`, `ms_krit`, `ms_mag`, `ms_fire`, `ms_water`, `ms_air`, `ms_earth`, `ms_svet`, `ms_tma`, `ms_gray`, `ms_rej`, `ms_drob`, `ms_kol`, `ms_rub`, `iznos_max`, `min_attack`, `max_attack`, `proboy`, `add_oruj`, `add_sword_vl`, `add_staff_vl`, `add_axe_vl`, `add_fail_vl`, `add_knife_vl`, `add_spear_vl`, `need_orden`, `sex`, `art`, `podzemka`, `is_personal`, `personal_owner`, `noremont`, `two_hand`, `second_hand`,  `add_fire_att`, `add_air_att`, `add_watet_att`, `add_earth_att`, `edited`) 
				VALUES (NULL, '".$login."','".$buy_item["img"]."' ,'1','Администрации WWW.OlDmeydan.Pe.Hu' ,'".$buy_item["id"]."', '".$buy_item["object"]."', 'obj', '".$buy_item["name"]."', '".$buy_item["mass"]."', '".$buy_item["price"]."', '".$buy_item["price"]."', '".$buy_item["min_sila"]."', '".$buy_item["min_lovkost"]."', '".$buy_item["min_udacha"]."', '".$buy_item["min_power"]."', '".$buy_item["min_intellekt"]."', '".$buy_item["min_vospriyatie"]."', '".$buy_item["min_level"]."', '".$buy_item["min_sword_vl"]."', '".$buy_item["min_staff_vl"]."', '".$buy_item["min_axe_vl"]."', '".$buy_item["min_fail_vl"]."', '".$buy_item["min_knife_vl"]."', '".$buy_item["min_spear_vl"]."', '".$buy_item["min_fire"]."','".$buy_item["min_water"]."','".$buy_item["min_air"]."','".$buy_item["min_earth"]."','".$buy_item["min_svet"]."','".$buy_item["min_tma"]."','".$buy_item["min_gray"]."', '".$buy_item["add_fire"]."', '".$buy_item["add_water"]."', '".$buy_item["add_air"]."', '".$buy_item["add_earth"]."', '".$buy_item["add_svet"]."', '".$buy_item["add_tma"]."', '".$buy_item["add_gray"]."', '".$buy_item["add_sila"]."', '".$buy_item["add_lovkost"]."', '".$buy_item["add_udacha"]."', '".$buy_item["add_intellekt"]."', '".$buy_item["add_duxovnost"]."', '".$buy_item["add_hp"]."', '".$buy_item["add_mana"]."', '".$buy_item["protect_head"]."', '".$buy_item["protect_arm"]."', '".$buy_item["protect_corp"]."', '".$buy_item["protect_poyas"]."', '".$buy_item["protect_legs"]."', '".$buy_item["protect_rej"]."', '".$buy_item["protect_drob"]."', '".$buy_item["protect_kol"]."', '".$buy_item["protect_rub"]."', '".$buy_item["protect_fire"]."', '".$buy_item["protect_water"]."', '".$buy_item["protect_air"]."', '".$buy_item["protect_earth"]."', '".$buy_item["protect_svet"]."', '".$buy_item["protect_tma"]."', '".$buy_item["protect_gray"]."', '".$buy_item["protect_mag"]."', '".$buy_item["protect_udar"]."','".$buy_item["shieldblock"]."','".$buy_item["krit"]."', '".$buy_item["akrit"]."', '".$buy_item["uvorot"]."', '".$buy_item["auvorot"]."', '".$buy_item["parry"]."', '".$buy_item["counter"]."', '".$buy_item["add_rej"]."', '".$buy_item["add_drob"]."', '".$buy_item["add_kol"]."', '".$buy_item["add_rub"]."', '".$buy_item["ms_udar"]."', '".$buy_item["ms_krit"]."', '".$buy_item["ms_mag"]."', '".$buy_item["ms_fire"]."', '".$buy_item["ms_water"]."', '".$buy_item["ms_air"]."', '".$buy_item["ms_earth"]."', '".$buy_item["ms_svet"]."', '".$buy_item["ms_tma"]."', '".$buy_item["ms_gray"]."', '".$buy_item["ms_rej"]."', '".$buy_item["ms_drob"]."', '".$buy_item["ms_kol"]."', '".$buy_item["ms_rub"]."', '".$buy_item["iznos_max"]."', '".$buy_item["min_attack"]."', '".$buy_item["max_attack"]."', '".$buy_item["proboy"]."','".$buy_item["add_oruj"]."' ,'".$buy_item["add_sword_vl"]."', '".$buy_item["add_staff_vl"]."', '".$buy_item["add_axe_vl"]."', '".$buy_item["add_fail_vl"]."', '".$buy_item["add_knife_vl"]."', '".$buy_item["add_spear_vl"]."', '".$buy_item["need_orden"]."', '".$buy_item["sex"]."', '".$buy_item["art"]."', '".$buy_item["podzemka"]."', '".$buy_item["is_personal"]."', '".$buy_item["personal_owner"]."', '".$buy_item["noremont"]."', '".$buy_item["two_hand"]."', '".$buy_item["second_hand"]."',  '".$buy_item["add_fire_att"]."', '".$buy_item["add_air_att"]."', '".$buy_item["add_watet_att"]."', '".$buy_item["add_earth_att"]."', '".$buy_item["edited"]."');");
			//--------Eliksiri-------------
			mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author,term) VALUES ('".$login."','224','scroll','magic','10','1','Администрации WWW.OlDmeydan.Pe.Hu','".(time()+30*24*3600)."')");#Нектар Отрицания
			mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author,term) VALUES ('".$login."','111','scroll','magic','10','1','Администрации WWW.OlDmeydan.Pe.Hu','".(time()+30*24*3600)."')");#Большое Зелье Неуязвимости
			mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author,term) VALUES ('".$login."','220','scroll','magic','50','1','Администрации WWW.OlDmeydan.Pe.Hu','".(time()+30*24*3600)."')");#Большое Эликсир Жизни
			mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author) VALUES ('".$login."','94','scroll','magic','75','1','Администрации WWW.OlDmeydan.Pe.Hu')");#Восстановление энергии 1000HP 
			#mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author) VALUES ('".$login."','176','scroll','magic','50','1','Администрации WWW.OlDmeydan.Pe.Hu')");#Восстановление маны 1000MN 

			mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author) VALUES ('".$login."','52','scroll','magic','20','1','Администрации WWW.OlDmeydan.Pe.Hu')");#Тактика Крови
			mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author) VALUES ('".$login."','53','scroll','magic','20','1','Администрации WWW.OlDmeydan.Pe.Hu')");#Тактика Защиты
			mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author) VALUES ('".$login."','54','scroll','magic','20','1','Администрации WWW.OlDmeydan.Pe.Hu')");#Тактика Ответа
			mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author) VALUES ('".$login."','55','scroll','magic','20','1','Администрации WWW.OlDmeydan.Pe.Hu')");#Тактика Боя
			mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author) VALUES ('".$login."','258','scroll','magic','20','1','Администрации WWW.OlDmeydan.Pe.Hu')");#Тактика Парирования

			mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author) VALUES ('".$login."','61','scroll','magic','5','1','Администрации WWW.OlDmeydan.Pe.Hu')");#Воскрешение 
			mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author) VALUES ('".$login."','116','scroll','magic','10','1','Администрации WWW.OlDmeydan.Pe.Hu')");#Клонирование
			mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author) VALUES ('".$login."','4','scroll','magic','10','1','Администрации WWW.OlDmeydan.Pe.Hu')");#Нападение 
			
			mysql_query("INSERT INTO inv(owner,object_id,object_type,object_razdel,gift,wear,gift_author) VALUES('".$login."','34','medal','medal','1','0','Администрации WWW.OlDmeydan.Pe.Hu')");#Медал Нам 4 года!

			if ($_GET["type"]=="mag")
			{
				mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author,term) VALUES ('".$login."','225','scroll','magic','5','1','Администрации WWW.OlDmeydan.Pe.Hu','".(time()+30*24*3600)."')");#Снадобье Забытых Магистров
				mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author,term) VALUES ('".$login."','228','scroll','magic','15','1','Администрации WWW.OlDmeydan.Pe.Hu','".(time()+30*24*3600)."')");#Ледяной Интеллект
			}
			else
			{
				mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author,term) VALUES ('".$login."','226','scroll','magic','5','1','Администрации WWW.OlDmeydan.Pe.Hu','".(time()+30*24*3600)."')");#Снадобье Забытых Мастеров 
				mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author,term) VALUES ('".$login."','227','scroll','magic','15','1','Администрации WWW.OlDmeydan.Pe.Hu','".(time()+30*24*3600)."')");#Сила Великана
			} 
			mysql_query("UNLOCK TABLES");
		
			mysql_query("INSERT INTO elkapodarka (login,type) VALUES ('".$login."','1')");
			$msg="Вы получили подарки... С днём рождения!";
		}
		else $msg="Вы уже получали подарок!";
	}
	else $msg="Еще не время!";
}
//--------------------New Year Gift-------------------------------
if ($_GET['action']=="getpodarka")
{
	if ((date(n)==1 && date(j)>=16) || (date(n)==1 && date(j)<=5) || $db["adminsite"])
	{	
		$findpodarka = @mysql_fetch_array(mysql_query("SELECT * FROM elkapodarka WHERE login='".$login."' and type=2"));
		if (!$findpodarka)
		{
			mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author,term) VALUES ('".$login."','224','scroll','magic','10','1','Администрации WWW.OlDmeydan.Pe.Hu','".(time()+30*24*3600)."')");#Нектар Отрицания
			mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author,term) VALUES ('".$login."','111','scroll','magic','10','1','Администрации WWW.OlDmeydan.Pe.Hu','".(time()+30*24*3600)."')");#Большое Зелье Неуязвимости
			mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author,term) VALUES ('".$login."','220','scroll','magic','50','1','Администрации WWW.OlDmeydan.Pe.Hu','".(time()+30*24*3600)."')");#Большое Эликсир Жизни
			mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author) VALUES ('".$login."','94','scroll','magic','75','1','Администрации WWW.OlDmeydan.Pe.Hu')");#Восстановление энергии 1000HP 
			mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author) VALUES ('".$login."','176','scroll','magic','50','1','Администрации WWW.OlDmeydan.Pe.Hu')");#Восстановление маны 1000MN 
			mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author) VALUES ('".$login."','129','scroll','magic','10','1','Администрации WWW.OlDmeydan.Pe.Hu')");#Двуручный Зверь
			
			
			mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author,term) VALUES ('".$login."','235','scroll','magic','10','1','Администрации WWW.OlDmeydan.Pe.Hu','".(time()+30*24*3600)."')");#Большое Эликсир Ветра
			mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author,term) VALUES ('".$login."','236','scroll','magic','10','1','Администрации WWW.OlDmeydan.Pe.Hu','".(time()+30*24*3600)."')");#Большое Эликсир Морей
			mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author,term) VALUES ('".$login."','237','scroll','magic','10','1','Администрации WWW.OlDmeydan.Pe.Hu','".(time()+30*24*3600)."')");#Большое Эликсир Песков
			mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author,term) VALUES ('".$login."','238','scroll','magic','10','1','Администрации WWW.OlDmeydan.Pe.Hu','".(time()+30*24*3600)."')");#Большое Эликсир Пламени
				
				
			mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author,term) VALUES ('".$login."','239','scroll','magic','10','1','Администрации WWW.OlDmeydan.Pe.Hu','".(time()+30*24*3600)."')");#Зелье Пронзающих Игл
			mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author,term) VALUES ('".$login."','240','scroll','magic','10','1','Администрации WWW.OlDmeydan.Pe.Hu','".(time()+30*24*3600)."')");#Зелье Сверкающих Лезвий
			mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author,term) VALUES ('".$login."','241','scroll','magic','10','1','Администрации WWW.OlDmeydan.Pe.Hu','".(time()+30*24*3600)."')");#Зелье Свистящих Секир
			mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author,term) VALUES ('".$login."','242','scroll','magic','10','1','Администрации WWW.OlDmeydan.Pe.Hu','".(time()+30*24*3600)."')");#Зелье Тяжелых Молотов
							
			
			mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author) VALUES ('".$login."','52','scroll','magic','20','1','Администрации WWW.OlDmeydan.Pe.Hu')");#Тактика Крови
			mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author) VALUES ('".$login."','53','scroll','magic','20','1','Администрации WWW.OlDmeydan.Pe.Hu')");#Тактика Защиты
			mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author) VALUES ('".$login."','54','scroll','magic','20','1','Администрации WWW.OlDmeydan.Pe.Hu')");#Тактика Ответа
			mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author) VALUES ('".$login."','55','scroll','magic','20','1','Администрации WWW.OlDmeydan.Pe.Hu')");#Тактика Боя
			mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author) VALUES ('".$login."','258','scroll','magic','20','1','Администрации WWW.OlDmeydan.Pe.Hu')");#Тактика Парирования

			mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author) VALUES ('".$login."','61','scroll','magic','5','1','Администрации WWW.OlDmeydan.Pe.Hu')");#Воскрешение 
			mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author) VALUES ('".$login."','116','scroll','magic','10','1','Администрации WWW.OlDmeydan.Pe.Hu')");#Клонирование
			mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author) VALUES ('".$login."','4','scroll','magic','10','1','Администрации WWW.OlDmeydan.Pe.Hu')");#Нападение 
			mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author) VALUES ('".$login."','259','scroll','magic','10','1','Администрации WWW.OlDmeydan.Pe.Hu')");#Жажда жизни+6
			
			mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author,term) VALUES ('".$login."','223','scroll','magic','10','1','Администрации WWW.OlDmeydan.Pe.Hu','".(time()+30*24*3600)."')");#Зелье Сокрушения[3]
			if ($_GET["type"]=="mag")
			{
				mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author,term) VALUES ('".$login."','229','scroll','magic','5','1','Администрации WWW.OlDmeydan.Pe.Hu','".(time()+30*24*3600)."')");#Эликсир злых намерений
				mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author,term) VALUES ('".$login."','233','scroll','magic','5','1','Администрации WWW.OlDmeydan.Pe.Hu','".(time()+30*24*3600)."')");#Эликсир Признания
				mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author,term) VALUES ('".$login."','228','scroll','magic','15','1','Администрации WWW.OlDmeydan.Pe.Hu','".(time()+30*24*3600)."')");#Ледяной Интеллект
			}
			else
			{
				mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author,term) VALUES ('".$login."','230','scroll','magic','5','1','Администрации WWW.OlDmeydan.Pe.Hu','".(time()+30*24*3600)."')");#Эликсир добрых намерений
				mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author,term) VALUES ('".$login."','231','scroll','magic','5','1','Администрации WWW.OlDmeydan.Pe.Hu','".(time()+30*24*3600)."')");#Эликсир гиганта
				mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author,term) VALUES ('".$login."','227','scroll','magic','15','1','Администрации WWW.OlDmeydan.Pe.Hu','".(time()+30*24*3600)."')");#Сила Великана						
			}
			if ($db["level"]>=4)
			{	
				if ($db["level"]>=4)$item_str="(1163, 1165, 1531, 1164, 1162, 1034, 1037, 1529, 1530)";
				else if ($db["level"]==9)$item_str="(1163, 1165, 1531, 1164, 1162, 1034, 1037, 1529, 1530)";
				else if ($db["level"]>=10)$item_str="(1163, 1165, 1531, 1164, 1162, 1034, 1037, 1529, 1530)";
				$buy_item_sql=mysql_query("SELECT * FROM paltar WHERE id in $item_str");
				while ($buy_item=@mysql_Fetch_array($buy_item_sql))
				{
					mysql_query("INSERT INTO `inv` (`id`, `owner`, `img`, `gift`, `gift_author` , `object_id`, `object_type`, `object_razdel`, `name`,  `mass`, `price`, `gos_price`, `min_sila`, `min_lovkost`, `min_udacha`, `min_power`, `min_intellekt`, `min_vospriyatie`, `min_level`, `min_sword_vl`, `min_staff_vl`, `min_axe_vl`, `min_fail_vl`, `min_knife_vl`, `min_spear_vl`,`min_fire`,`min_water`,`min_air`,`min_earth`,`min_svet`,`min_tma`,`min_gray`,`add_fire`, `add_water`, `add_air`, `add_earth`, `add_svet`, `add_tma`, `add_gray`, `add_sila`, `add_lovkost`, `add_udacha`, `add_intellekt`, `add_duxovnost`, `add_hp`, `add_mana`, `protect_head`, `protect_arm`, `protect_corp`, `protect_poyas`, `protect_legs`, `protect_rej`, `protect_drob`, `protect_kol`, `protect_rub`, `protect_fire`, `protect_water`, `protect_air`, `protect_earth`, `protect_svet`, `protect_tma`, `protect_gray`,`protect_mag`,`protect_udar`, `shieldblock`, `krit`, `akrit`, `uvorot`, `auvorot`, `parry`, `counter`, `add_rej`, `add_drob`, `add_kol`, `add_rub`, `ms_udar`, `ms_krit`, `ms_mag`, `ms_fire`, `ms_water`, `ms_air`, `ms_earth`, `ms_svet`, `ms_tma`, `ms_gray`, `ms_rej`, `ms_drob`, `ms_kol`, `ms_rub`, `iznos_max`, `min_attack`, `max_attack`, `proboy`, `add_oruj`, `add_sword_vl`, `add_staff_vl`, `add_axe_vl`, `add_fail_vl`, `add_knife_vl`, `add_spear_vl`, `need_orden`, `sex`, `art`, `podzemka`, `is_personal`, `personal_owner`, `noremont`, `two_hand`, `second_hand`,  `add_fire_att`, `add_air_att`, `add_watet_att`, `add_earth_att`, `edited`) 
					VALUES (NULL, '".$login."','".$buy_item["img"]."' ,'1','Администрации WWW.OlDmeydan.Pe.Hu' ,'".$buy_item["id"]."', '".$buy_item["object"]."', 'obj', '".$buy_item["name"]."', '".$buy_item["mass"]."', '".$buy_item["price"]."', '".$buy_item["price"]."', '".$buy_item["min_sila"]."', '".$buy_item["min_lovkost"]."', '".$buy_item["min_udacha"]."', '".$buy_item["min_power"]."', '".$buy_item["min_intellekt"]."', '".$buy_item["min_vospriyatie"]."', '".$buy_item["min_level"]."', '".$buy_item["min_sword_vl"]."', '".$buy_item["min_staff_vl"]."', '".$buy_item["min_axe_vl"]."', '".$buy_item["min_fail_vl"]."', '".$buy_item["min_knife_vl"]."', '".$buy_item["min_spear_vl"]."', '".$buy_item["min_fire"]."','".$buy_item["min_water"]."','".$buy_item["min_air"]."','".$buy_item["min_earth"]."','".$buy_item["min_svet"]."','".$buy_item["min_tma"]."','".$buy_item["min_gray"]."', '".$buy_item["add_fire"]."', '".$buy_item["add_water"]."', '".$buy_item["add_air"]."', '".$buy_item["add_earth"]."', '".$buy_item["add_svet"]."', '".$buy_item["add_tma"]."', '".$buy_item["add_gray"]."', '".$buy_item["add_sila"]."', '".$buy_item["add_lovkost"]."', '".$buy_item["add_udacha"]."', '".$buy_item["add_intellekt"]."', '".$buy_item["add_duxovnost"]."', '".$buy_item["add_hp"]."', '".$buy_item["add_mana"]."', '".$buy_item["protect_head"]."', '".$buy_item["protect_arm"]."', '".$buy_item["protect_corp"]."', '".$buy_item["protect_poyas"]."', '".$buy_item["protect_legs"]."', '".$buy_item["protect_rej"]."', '".$buy_item["protect_drob"]."', '".$buy_item["protect_kol"]."', '".$buy_item["protect_rub"]."', '".$buy_item["protect_fire"]."', '".$buy_item["protect_water"]."', '".$buy_item["protect_air"]."', '".$buy_item["protect_earth"]."', '".$buy_item["protect_svet"]."', '".$buy_item["protect_tma"]."', '".$buy_item["protect_gray"]."', '".$buy_item["protect_mag"]."', '".$buy_item["protect_udar"]."','".$buy_item["shieldblock"]."','".$buy_item["krit"]."', '".$buy_item["akrit"]."', '".$buy_item["uvorot"]."', '".$buy_item["auvorot"]."', '".$buy_item["parry"]."', '".$buy_item["counter"]."', '".$buy_item["add_rej"]."', '".$buy_item["add_drob"]."', '".$buy_item["add_kol"]."', '".$buy_item["add_rub"]."', '".$buy_item["ms_udar"]."', '".$buy_item["ms_krit"]."', '".$buy_item["ms_mag"]."', '".$buy_item["ms_fire"]."', '".$buy_item["ms_water"]."', '".$buy_item["ms_air"]."', '".$buy_item["ms_earth"]."', '".$buy_item["ms_svet"]."', '".$buy_item["ms_tma"]."', '".$buy_item["ms_gray"]."', '".$buy_item["ms_rej"]."', '".$buy_item["ms_drob"]."', '".$buy_item["ms_kol"]."', '".$buy_item["ms_rub"]."', '5', '".$buy_item["min_attack"]."', '".$buy_item["max_attack"]."', '".$buy_item["proboy"]."','".$buy_item["add_oruj"]."' ,'".$buy_item["add_sword_vl"]."', '".$buy_item["add_staff_vl"]."', '".$buy_item["add_axe_vl"]."', '".$buy_item["add_fail_vl"]."', '".$buy_item["add_knife_vl"]."', '".$buy_item["add_spear_vl"]."', '".$buy_item["need_orden"]."', '".$buy_item["sex"]."', '".$buy_item["art"]."', '1', '".$buy_item["is_personal"]."', '".$buy_item["personal_owner"]."', '1', '".$buy_item["two_hand"]."', '".$buy_item["second_hand"]."',  '".$buy_item["add_fire_att"]."', '".$buy_item["add_air_att"]."', '".$buy_item["add_watet_att"]."', '".$buy_item["add_earth_att"]."', '".$buy_item["edited"]."');");
				}
			}
			
			if ($veteran==1)
			{
				mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author) VALUES ('".$login."','250','scroll','magic','5','1','Администрации WWW.OlDmeydan.Pe.Hu')");#Izlomdakilar
				mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author) VALUES ('".$login."','251','scroll','magic','5','1','Администрации WWW.OlDmeydan.Pe.Hu')");#Izlomdakilar 
				mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author) VALUES ('".$login."','252','scroll','magic','5','1','Администрации WWW.OlDmeydan.Pe.Hu')");#Izlomdakilar 
				mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author) VALUES ('".$login."','253','scroll','magic','5','1','Администрации WWW.OlDmeydan.Pe.Hu')");#Izlomdakilar 					
				mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author) VALUES ('".$login."','254','scroll','magic','5','1','Администрации WWW.OlDmeydan.Pe.Hu')");#Izlomdakilar 
				mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author) VALUES ('".$login."','255','scroll','magic','5','1','Администрации WWW.OlDmeydan.Pe.Hu')");#Izlomdakilar 					
				mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author) VALUES ('".$login."','256','scroll','magic','5','1','Администрации WWW.OlDmeydan.Pe.Hu')");#Izlomdakilar 
				mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author) VALUES ('".$login."','257','scroll','magic','5','1','Администрации WWW.OlDmeydan.Pe.Hu')");#Izlomdakilar
			}
			
			$vaxt=time()+365*24*60*60;
			mysql_query("INSERT INTO elkapodarka (login,type) VALUES ('".$login."','2')");
			$msg="С наступающим новым 2016 Годом!";
		}
		else $msg="Вы уже получали подарок от Деда Мороза!";
	}
	else $msg="Еще не время!";
}
//---------------------------------------------------
if (isset($_POST['text']) && $_POST['text']!="")
{
	$text=htmlspecialchars(addslashes(trim($_POST['text'])));
	$text = wordwrap($text, 40, " ",1);
	$next_time=time()+24*3600;
	$now=time();
	$find = @mysql_fetch_array(mysql_query("SELECT * FROM elka WHERE login='".$login."' ORDER BY time DESC LIMIT 1"));
	$my_time=$find['time'];
	if ($my_time<=$now)
	{
		mysql_query("LOCK TABLES elka WRITE");
		mysql_query("INSERT INTO elka (text,login,time,type,year) VALUES ('".$text."','".$login."','".$next_time."','".$text_type."','".$year."')");
		mysql_query("UNLOCK TABLES");
		$msg=" Ваше пожелание успешно добавлено...";
	}
	else
	{
		$msg="Ещё: ".convert_time($my_time);
	}
}
//---------------------------------------------------
//type=1  Ad gunu
//type=2  New Year
//---------------------------------------------------
?>
<body style="background-image: url(img/index/elka.jpg);background-repeat:no-repeat;background-position:top right">
<h3><?=$h3;if ($veteran) echo " (Вы ветеран)"?></h3>
<TABLE width=100% border=0>
<tr>
	<td width=100%><b style="color:#ff0000"><?=$msg;?></font></td>
	<td align=right nowrap>
		<input type="button" class="newbut" onclick="location.href='main.php?act=go&level=okraina'" value="Вернуться" >
		<input type="button" class="newbut" onclick="location.href='main.php?act=none'" value="Обновить">
		<?
			if ((date(n)==1 && date(j)>=16) || (date(n)==1 && date(j)<=5) || $db["adminsite"])
			echo "<input type=button onclick=\"location.href='main.php?act=go&level=led'\" value=\"Леденая пещера\" style=\"background-color:#AA0000; color: white;\">";
		?>
	</td>
</tr>
<tr>
	<td valign=top colspan=2>
	<?
		echo "<center>";
		//----------------------------------Ad gunu------------------------------------------------------------
		if ((date(n)==8 && date(j)<9) || (date(n)==7 && date(j)>=27))
		{
			echo "
				<img src='img/upakovka/warrior1.gif' onmouseover=\"slot_view('<b>Подарок Для Воина!</b>');\" onmouseout=\"slot_hide();\" style='cursor:hand;' onclick=\"location.href='?action=getbirth&type=warrior'\"> 
				<img src='img/upakovka/mag1.gif' 	onmouseover=\"slot_view('<b>Подарок Для Мага!</b>');\" onmouseout=\"slot_hide();\" style='cursor:hand;' onclick=\"location.href='?action=getbirth&type=mag'\">";
		}
		//----------------------------------Ney Year-------------------------------------------------------------------
		if ((date(n)==1 && date(j)>=16) || (date(n)==1 && date(j)<=5) || $db["adminsite"])
		{
			echo "<b>По-традиции, в Новый Год Дед Мороз под ёлку кладет подарки. Так возьмите же свой подарок :) </b></br>
			<img src='img/upakovka/warrior1.gif' onmouseover=\"slot_view('<b>Подарок Для Воина!</b>');\" onmouseout=\"slot_hide();\" style='cursor:hand;' onclick=\"location.href='?action=getpodarka&type=warrior'\"> 
			<img src='img/upakovka/mag1.gif' 	onmouseover=\"slot_view('<b>Подарок Для Мага!</b>');\" onmouseout=\"slot_hide();\" style='cursor:hand;' onclick=\"location.href='?action=getpodarka&type=mag'\">";
		}
		echo "</center>";
		//----------------------------------Text-------------------------------------------------------------------
		echo "<br><u>Ваши пожелания</u>: ";
		$page=(int)abs($_GET['page']);
		$row=@mysql_fetch_array(mysql_query("SELECT count(*) FROM elka WHERE type=".$text_type." and year=".$year));
		$page_cnt=$row[0];
		$cnt=$page_cnt; // общее количество записей во всём выводе
		$rpp=20; // кол-во записей на страницу
		$rad=2; // сколько ссылок показывать рядом с номером текущей страницы (2 слева + 2 справа + активная страница = всего 5)

		$links=$rad*2+1;
		$pages=ceil($cnt/$rpp);
		if ($page>0) { echo "<a href=\"?page=0\">«««</a> | <a href=\"?page=".($page-1)."\">««</a> |"; }
		$start=$page-$rad;
		if ($start>$pages-$links) { $start=$pages-$links; }
		if ($start<0) { $start=0; }
		$end=$start+$links;
		if ($end>$pages) { $end=$pages; }
		for ($i=$start; $i<$end; $i++) 
		{
			if ($i==$page)
			{
				echo "<b style='color:#ff0000'><u>";
			} 
			else 
			{
				echo "<a href=\"?page=$i\">";
			}
			echo $i;
			if ($i==$page) 
			{
				echo "</u></b>";
			} 
			else 
			{
				echo "</a>";
			}
			if ($i!=($end-1)) { echo " | "; }
		}
		if ($pages>$links && $page<($pages-$rad-1)) { echo " ... <a href=\"?page=".($pages-1)."\">".($pages-1)."</a>"; }
		if ($page<$pages-1) { echo " | <a href=\"?page=".($page+1)."\">»»</a> | <a href=\"?page=".($pages-1)."\">»»»</a>"; }

		$limit = $rpp;
		$eu = $page*$limit;
		echo "<br>";
		$SSS = mysql_query("SELECT elka.id as ids, elka.text, elka.date, users.login, users.id, users.level, users.orden, users.admin_level, users.dealer, users.clan_short, users.clan FROM elka LEFT JOIN users on elka.login=users.login WHERE elka.type=".$text_type." and elka.year=".$year." ORDER by elka.date DESC limit $eu, $limit");
		while($DATA = @mysql_fetch_array($SSS))
		{
			$delid=$DATA['ids'];
			echo "<div style='padding: 1px;'><font class=date>".$DATA["date"]."</font> <script>drwfl('".$DATA['login']."', '".$DATA['id']."', '".$DATA['level']."', '".$DATA['dealer']."', '".$DATA['orden']."', '".$DATA['admin_level']."', '".$DATA['clan_short']."', '".$DATA['clan']."');</script>";
			echo " - ".wordwrap(trim(str_replace("&amp;","&",$DATA['text'])), 40, " ",1).(($db['orden']==1)?"&nbsp; <a href='?action=del&id=$delid'><img src='img/icon/del.gif'></a>":"");
			echo "</div>";
		}
		echo '
			<form method="POST" action="?act=none">
				Ваше пожелание:	<input type=text name="text" value="" maxlength="1024" size=50> <input type="submit" name="add" value=" Добавить ">
			</form>';
		//-------------------------------------------------------------------------------------------------------------------
	?>
</td>
</tr>
</table>
<br><br><br><br>
<?include_once("counter.php");?>