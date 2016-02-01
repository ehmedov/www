<?
include_once("inc/shop/otdels_b.php");
$login=$_SESSION['login'];
$otdel=htmlspecialchars(addslashes($_GET["otdel"]));
$buy=htmlspecialchars(addslashes($_GET["buy"]));
$deist=$_GET['deist'];
$set=(int)$_GET['set'];
$item=(int)$_GET['item'];
$ids=(int)$_GET['ids'];
$do=(int)$_GET['do'];
$ip=$db["remote_ip"];
$_POST['price']=(int)$_POST['price'];
if (!isset($otdels[$otdel])){$otdel="sword";}
if (!isset($otdels[$buy])){$buy="sword";};
//-----------------покупаем все---------------------------
if($_GET["by_all"] && $db["adminsite"]>=5)
{
	$q=mysql_query("SELECT * FROM comok WHERE object_id='".$set."' and object_type = '".$otdel."'");
	while ($r=mysql_fetch_Array($q))
	{
		mysql_query("UPDATE users SET money=money+".$r["price"]." WHERE login='".$r["owner"]."'");
	}
	mysql_query("DELETE FROM comok WHERE object_id='".$set."' and object_type = '".$otdel."'");
	$set="";
}	
//-----------------покупка предмета---------------------------
if($buy && $item>0)
{
	$bye_sql = mysql_query("SELECT * FROM comok WHERE id=".$item);
	$to_inv = mysql_fetch_array($bye_sql);
	if ($to_inv)
	{
		$price_com=$to_inv["price"];
		$nalog=$price_com*0.1;
		if($nalog<1){$nalog=1;}
		if($db["money"]>=$price_com)
		{
			mysql_query("LOCK TABLES inv WRITE");
			mysql_query("INSERT INTO `inv` (`owner`, `img`, `object_id`, `object_type`, `object_razdel`, `bs`, `runas`, `gravirovka`, `add_xp`, `term`, `is_modified`, `name`,  `mass`, `price`, `gos_price`, `min_sila`, `min_lovkost`, `min_udacha`, `min_power`, `min_intellekt`, `min_vospriyatie`, `min_level`, `min_sword_vl`, `min_staff_vl`, `min_axe_vl`, `min_fail_vl`, `min_knife_vl`, `min_spear_vl`,`min_fire`,`min_water`,`min_air`,`min_earth`,`min_svet`,`min_tma`,`min_gray`,`add_fire`, `add_water`, `add_air`, `add_earth`, `add_svet`, `add_tma`, `add_gray`, `add_sila`, `add_lovkost`, `add_udacha`, `add_intellekt`, `add_duxovnost`, `add_hp`, `add_mana`, `protect_head`, `protect_arm`, `protect_corp`, `protect_poyas`, `protect_legs`, `protect_rej`, `protect_drob`, `protect_kol`, `protect_rub`, `protect_fire`, `protect_water`, `protect_air`, `protect_earth`, `protect_svet`, `protect_tma`, `protect_gray`,`protect_mag`,`protect_udar`, `shieldblock`, `krit`, `akrit`, `uvorot`, `auvorot`, `parry`, `counter`, `add_rej`, `add_drob`, `add_kol`, `add_rub`, `ms_udar`, `ms_krit`, `ms_mag`, `ms_fire`, `ms_water`, `ms_air`, `ms_earth`, `ms_svet`, `ms_tma`, `ms_gray`, `ms_rej`, `ms_drob`, `ms_kol`, `ms_rub`,`iznos`, `iznos_max`, `min_attack`, `max_attack`, `proboy`, `add_oruj`, `add_sword_vl`, `add_staff_vl`, `add_axe_vl`, `add_fail_vl`, `add_knife_vl`, `add_spear_vl`, `need_orden`, `sex`, `art`, `podzemka`, `is_personal`, `personal_owner`, `noremont`, `two_hand`, `second_hand`,  `add_fire_att`, `add_air_att`, `add_watet_att`, `add_earth_att`, `edited`) 
			VALUES ('".$login."','".$to_inv["img"]."' ,'".$to_inv["object_id"]."', '".$to_inv["object_type"]."', '".$to_inv["object_razdel"]."', '".$to_inv["bs"]."', '".$to_inv["runas"]."', '".$to_inv["gravirovka"]."', '".$to_inv["add_xp"]."', '".$to_inv["term"]."','".$to_inv["is_modified"]."', '".$to_inv["name"]."', '".$to_inv["mass"]."', '".$price_com."', '".$to_inv["gos_price"]."', '".$to_inv["min_sila"]."', '".$to_inv["min_lovkost"]."', '".$to_inv["min_udacha"]."', '".$to_inv["min_power"]."', '".$to_inv["min_intellekt"]."', '".$to_inv["min_vospriyatie"]."', '".$to_inv["min_level"]."', '".$to_inv["min_sword_vl"]."', '".$to_inv["min_staff_vl"]."', '".$to_inv["min_axe_vl"]."', '".$to_inv["min_fail_vl"]."', '".$to_inv["min_knife_vl"]."', '".$to_inv["min_spear_vl"]."', '".$to_inv["min_fire"]."','".$to_inv["min_water"]."','".$to_inv["min_air"]."','".$to_inv["min_earth"]."','".$to_inv["min_svet"]."','".$to_inv["min_tma"]."','".$to_inv["min_gray"]."', '".$to_inv["add_fire"]."', '".$to_inv["add_water"]."', '".$to_inv["add_air"]."', '".$to_inv["add_earth"]."', '".$to_inv["add_svet"]."', '".$to_inv["add_tma"]."', '".$to_inv["add_gray"]."', '".$to_inv["add_sila"]."', '".$to_inv["add_lovkost"]."', '".$to_inv["add_udacha"]."', '".$to_inv["add_intellekt"]."', '".$to_inv["add_duxovnost"]."', '".$to_inv["add_hp"]."', '".$to_inv["add_mana"]."', '".$to_inv["protect_head"]."', '".$to_inv["protect_arm"]."', '".$to_inv["protect_corp"]."', '".$to_inv["protect_poyas"]."', '".$to_inv["protect_legs"]."', '".$to_inv["protect_rej"]."', '".$to_inv["protect_drob"]."', '".$to_inv["protect_kol"]."', '".$to_inv["protect_rub"]."', '".$to_inv["protect_fire"]."', '".$to_inv["protect_water"]."', '".$to_inv["protect_air"]."', '".$to_inv["protect_earth"]."', '".$to_inv["protect_svet"]."', '".$to_inv["protect_tma"]."', '".$to_inv["protect_gray"]."', '".$to_inv["protect_mag"]."', '".$to_inv["protect_udar"]."','".$to_inv["shieldblock"]."','".$to_inv["krit"]."', '".$to_inv["akrit"]."', '".$to_inv["uvorot"]."', '".$to_inv["auvorot"]."', '".$to_inv["parry"]."', '".$to_inv["counter"]."', '".$to_inv["add_rej"]."', '".$to_inv["add_drob"]."', '".$to_inv["add_kol"]."', '".$to_inv["add_rub"]."', '".$to_inv["ms_udar"]."', '".$to_inv["ms_krit"]."', '".$to_inv["ms_mag"]."', '".$to_inv["ms_fire"]."', '".$to_inv["ms_water"]."', '".$to_inv["ms_air"]."', '".$to_inv["ms_earth"]."', '".$to_inv["ms_svet"]."', '".$to_inv["ms_tma"]."', '".$to_inv["ms_gray"]."', '".$to_inv["ms_rej"]."', '".$to_inv["ms_drob"]."', '".$to_inv["ms_kol"]."', '".$to_inv["ms_rub"]."', '".$to_inv["iznos"]."', '".$to_inv["iznos_max"]."', '".$to_inv["min_attack"]."', '".$to_inv["max_attack"]."', '".$to_inv["proboy"]."','".$to_inv["add_oruj"]."' ,'".$to_inv["add_sword_vl"]."', '".$to_inv["add_staff_vl"]."', '".$to_inv["add_axe_vl"]."', '".$to_inv["add_fail_vl"]."', '".$to_inv["add_knife_vl"]."', '".$to_inv["add_spear_vl"]."', '".$to_inv["need_orden"]."', '".$to_inv["sex"]."', '".$to_inv["art"]."', '".$to_inv["podzemka"]."', '".$to_inv["is_personal"]."', '".$to_inv["personal_owner"]."', '".$to_inv["noremont"]."', '".$to_inv["two_hand"]."', '".$to_inv["second_hand"]."',  '".$to_inv["add_fire_att"]."', '".$to_inv["add_air_att"]."', '".$to_inv["add_watet_att"]."', '".$to_inv["add_earth_att"]."', '".$to_inv["edited"]."');");
			
			mysql_query("UNLOCK TABLES");
			mysql_query("DELETE FROM `comok` WHERE id = '".$item."'");
			$money_to_owner=$price_com-$nalog;
			mysql_query("UPDATE users SET money=money-$price_com WHERE login='".$login."'");
			$db["money"]=$db["money"]-$price_com;
			mysql_query("UPDATE users SET money=money+$money_to_owner WHERE login='".$to_inv["owner"]."'");
			$message="Вы удачно купили &laquo;".$to_inv["name"]."&raquo; за $price_com Зл.";
			say($to_inv["owner"],"Ваш товар <b>&laquo;".$to_inv["name"]."&raquo;</b> был куплен в комиссионном магазине. За вычетом налогов вам переведено <b>$money_to_owner зл.</b>",$to_inv["owner"]);
			$name2=$to_inv["name"]." ($price_com Зл. - ".$to_inv["owner"].") (Гос. цена: ".$to_inv["qosprice"]." Зл.)";
			history($login,'Купил',$name2,$ip,'Комиссионный магазин');
			$name3=$to_inv["name"]." $price_com зл. (За вычетом налогов переведено $money_to_owner зл. - ".$login.") (Гос. цена: ".$to_inv["qosprice"]." зл.)";
			history($to_inv["owner"],'Продал',$name3,$ip,'Комиссионный магазин');
			mysql_query("INSERT INTO pochta(user,whom,text,subject) VALUES ('Комиссионка','".$to_inv["owner"]."','Ваш товар <b>&laquo;".$to_inv["name"]."&raquo;</b> был куплен в комиссионном магазине. За вычетом налогов вам переведено <b>$money_to_owner зл.</b>','Комиссионный магазин')");

			$otdel=$buy;
			$set=$set;
		}
		else
		{
			$message="У вас недостаточно средств чтобы купить ".$to_inv["name"]."";
		} 
	}
	else $message="Вещь не найдена...";
}
//---------------------------------сменить цену---------------------------------------------
if($deist=="zabrat")
{
	if($do==2 && is_numeric($ids) && is_numeric($_POST['price']))
	{
		$result=mysql_query("SELECT * FROM comok WHERE owner='".$login."' and id='".$ids."'");
		$datas = mysql_fetch_array($result);
		if ($datas)
		{
			$gos_price=sprintf ("%01.2f", $datas["gos_price"]);			
			if(0.7*$gos_price>$_POST['price'])
			{
				$message="Мы не принимаем вещи <u>дешевле</u> чем за 70 % от гос. цены. Гос. цена &laquo;".$datas["name"]."&raquo; составляет $gos_price Зл. <br>
		      	В то время как вы указали ".$_POST['price']." Зл.";
			}
			else if($gos_price*1.3<$_POST['price'])
			{
				$message="Мы не принимаем вещи <u>дороже</u> чем за 30 % от гос. цены. Гос. цена &laquo;".$datas["name"]."&raquo; составляет $gos_price Зл. <br>
		      	В то время как вы указали ".$_POST['price']." Зл.";
			}				
			else if($db["money"]<1)
			{ 
				$message="У вас недостаточно средств для того чтобы изменить цену &laquo;".$datas["name"]."&raquo;";
			}
			else
			{
				mysql_query("UPDATE comok SET price='".$_POST['price']."' WHERE id='".$datas["id"]."'");
				mysql_query("UPDATE users SET money=money-1 WHERE login='".$login."'");
				$db["money"]=$db["money"]-1;
				history($login,'Сменил цену',$datas["name"]." за 1.00 Зл.",$ip,'Комиссионный магазин');					
				$message="Вы удачно изменили цену на &laquo;".$datas["name"]."&raquo; и заплатили за это 1.00 Зл.";
			}
		}
		else $message="Вещь не найдена...";
	}
	//--------------------------Забрать---------------------------------------
	if($do==3 && is_numeric($ids))
	{
		$result=mysql_query("SELECT	* FROM comok WHERE owner='".$login."' and id='".$ids."'");
		$to_inv = mysql_fetch_array($result);
		if ($to_inv)
		{
			if($db["money"]<1)
			{ 
				$message="У вас недостаточно средств для того чтобы изменить цену &laquo;".$datas["name"]."&raquo;";
			}
			else
			{
				mysql_query("LOCK TABLES inv WRITE");
				mysql_query("INSERT INTO `inv` (`owner`, `img`, `object_id`, `object_type`, `object_razdel`, `gravirovka`, `add_xp`, `runas`, `bs`, `term`, `is_modified`, `name`,  `mass`, `price`, `gos_price`, `min_sila`, `min_lovkost`, `min_udacha`, `min_power`, `min_intellekt`, `min_vospriyatie`, `min_level`, `min_sword_vl`, `min_staff_vl`, `min_axe_vl`, `min_fail_vl`, `min_knife_vl`, `min_spear_vl`,`min_fire`,`min_water`,`min_air`,`min_earth`,`min_svet`,`min_tma`,`min_gray`,`add_fire`, `add_water`, `add_air`, `add_earth`, `add_svet`, `add_tma`, `add_gray`, `add_sila`, `add_lovkost`, `add_udacha`, `add_intellekt`, `add_duxovnost`, `add_hp`, `add_mana`, `protect_head`, `protect_arm`, `protect_corp`, `protect_poyas`, `protect_legs`, `protect_rej`, `protect_drob`, `protect_kol`, `protect_rub`, `protect_fire`, `protect_water`, `protect_air`, `protect_earth`, `protect_svet`, `protect_tma`, `protect_gray`,`protect_mag`,`protect_udar`, `shieldblock`, `krit`, `akrit`, `uvorot`, `auvorot`, `parry`, `counter`, `add_rej`, `add_drob`, `add_kol`, `add_rub`, `ms_udar`, `ms_krit`, `ms_mag`, `ms_fire`, `ms_water`, `ms_air`, `ms_earth`, `ms_svet`, `ms_tma`, `ms_gray`, `ms_rej`, `ms_drob`, `ms_kol`, `ms_rub`,`iznos`, `iznos_max`, `min_attack`, `max_attack`, `proboy`, `add_oruj`, `add_sword_vl`, `add_staff_vl`, `add_axe_vl`, `add_fail_vl`, `add_knife_vl`, `add_spear_vl`, `need_orden`, `sex`, `art`, `podzemka`, `is_personal`, `personal_owner`, `noremont`, `two_hand`, `second_hand`,  `add_fire_att`, `add_air_att`, `add_watet_att`, `add_earth_att`, `edited`) 
				VALUES ('".$login."','".$to_inv["img"]."' ,'".$to_inv["object_id"]."', '".$to_inv["object_type"]."', '".$to_inv["object_razdel"]."', '".$to_inv["gravirovka"]."', '".$to_inv["add_xp"]."', '".$to_inv["runas"]."', '".$to_inv["bs"]."','".$to_inv["term"]."','".$to_inv["is_modified"]."', '".$to_inv["name"]."', '".$to_inv["mass"]."', '".$to_inv["my_price"]."', '".$to_inv["gos_price"]."', '".$to_inv["min_sila"]."', '".$to_inv["min_lovkost"]."', '".$to_inv["min_udacha"]."', '".$to_inv["min_power"]."', '".$to_inv["min_intellekt"]."', '".$to_inv["min_vospriyatie"]."', '".$to_inv["min_level"]."', '".$to_inv["min_sword_vl"]."', '".$to_inv["min_staff_vl"]."', '".$to_inv["min_axe_vl"]."', '".$to_inv["min_fail_vl"]."', '".$to_inv["min_knife_vl"]."', '".$to_inv["min_spear_vl"]."', '".$to_inv["min_fire"]."','".$to_inv["min_water"]."','".$to_inv["min_air"]."','".$to_inv["min_earth"]."','".$to_inv["min_svet"]."','".$to_inv["min_tma"]."','".$to_inv["min_gray"]."', '".$to_inv["add_fire"]."', '".$to_inv["add_water"]."', '".$to_inv["add_air"]."', '".$to_inv["add_earth"]."', '".$to_inv["add_svet"]."', '".$to_inv["add_tma"]."', '".$to_inv["add_gray"]."', '".$to_inv["add_sila"]."', '".$to_inv["add_lovkost"]."', '".$to_inv["add_udacha"]."', '".$to_inv["add_intellekt"]."', '".$to_inv["add_duxovnost"]."', '".$to_inv["add_hp"]."', '".$to_inv["add_mana"]."', '".$to_inv["protect_head"]."', '".$to_inv["protect_arm"]."', '".$to_inv["protect_corp"]."', '".$to_inv["protect_poyas"]."', '".$to_inv["protect_legs"]."', '".$to_inv["protect_rej"]."', '".$to_inv["protect_drob"]."', '".$to_inv["protect_kol"]."', '".$to_inv["protect_rub"]."', '".$to_inv["protect_fire"]."', '".$to_inv["protect_water"]."', '".$to_inv["protect_air"]."', '".$to_inv["protect_earth"]."', '".$to_inv["protect_svet"]."', '".$to_inv["protect_tma"]."', '".$to_inv["protect_gray"]."', '".$to_inv["protect_mag"]."', '".$to_inv["protect_udar"]."','".$to_inv["shieldblock"]."','".$to_inv["krit"]."', '".$to_inv["akrit"]."', '".$to_inv["uvorot"]."', '".$to_inv["auvorot"]."', '".$to_inv["parry"]."', '".$to_inv["counter"]."', '".$to_inv["add_rej"]."', '".$to_inv["add_drob"]."', '".$to_inv["add_kol"]."', '".$to_inv["add_rub"]."', '".$to_inv["ms_udar"]."', '".$to_inv["ms_krit"]."', '".$to_inv["ms_mag"]."', '".$to_inv["ms_fire"]."', '".$to_inv["ms_water"]."', '".$to_inv["ms_air"]."', '".$to_inv["ms_earth"]."', '".$to_inv["ms_svet"]."', '".$to_inv["ms_tma"]."', '".$to_inv["ms_gray"]."', '".$to_inv["ms_rej"]."', '".$to_inv["ms_drob"]."', '".$to_inv["ms_kol"]."', '".$to_inv["ms_rub"]."', '".$to_inv["iznos"]."', '".$to_inv["iznos_max"]."', '".$to_inv["min_attack"]."', '".$to_inv["max_attack"]."', '".$to_inv["proboy"]."','".$to_inv["add_oruj"]."' ,'".$to_inv["add_sword_vl"]."', '".$to_inv["add_staff_vl"]."', '".$to_inv["add_axe_vl"]."', '".$to_inv["add_fail_vl"]."', '".$to_inv["add_knife_vl"]."', '".$to_inv["add_spear_vl"]."', '".$to_inv["need_orden"]."', '".$to_inv["sex"]."', '".$to_inv["art"]."', '".$to_inv["podzemka"]."', '".$to_inv["is_personal"]."', '".$to_inv["personal_owner"]."', '".$to_inv["noremont"]."', '".$to_inv["two_hand"]."', '".$to_inv["second_hand"]."',  '".$to_inv["add_fire_att"]."', '".$to_inv["add_air_att"]."', '".$to_inv["add_watet_att"]."', '".$to_inv["add_earth_att"]."', '".$to_inv["edited"]."');");
				mysql_query("UNLOCK TABLES");
				mysql_query("DELETE FROM `comok` WHERE id = '".$to_inv["id"]."'");
				mysql_query("UPDATE users SET money=money-1 WHERE login='".$login."'");
				$db["money"]=$db["money"]-1;
				history($login,'Забрал',$to_inv["name"]." за 1.00 Зл.",$ip,'Комиссионный магазин');
				$message="Вы удачно забрали &laquo; ".$to_inv["name"]." &raquo; из комиссионного магазина и заплатили за это 1.00 Зл.";
    		}
     	}
     	else $message="Вещь не найдена...";
	}
}
	//--------------------------------------------сдать в комок-------------------------
if($deist=="sdat")
{
	if($do==1 && is_numeric($ids) && is_numeric($_POST['price']))
	{
		$resu=mysql_query("SELECT * FROM inv WHERE owner='".$login."' and (object_razdel='obj' or object_razdel='magic') and wear=0 and gift=0 and id='".$ids."'");
		$to_comok = mysql_fetch_array($resu);
		if ($to_comok)
		{
			if ($to_comok["object_type"]=='scroll')
			{
				$sql_price=mysql_query("SELECT * FROM scroll WHERE id='".$to_comok["object_id"]."'");
				$g_price=mysql_fetch_array($sql_price);
				$gos_price=sprintf ("%01.2f", $g_price["price"]);
				$art=$g_price["art"];
				$podzemka=$g_price["podzemka"];
				$name=$g_price["name"];
				$my_price=$g_price["price"];
			}
			else 
			{
				$gos_price=sprintf ("%01.2f", $to_comok["gos_price"]);
				$art=$to_comok["art"];
				$podzemka=$to_comok["podzemka"];
				$name=$to_comok["name"];
				if ($to_comok["is_modified"]>0)$names=$name."+".$to_comok["is_modified"];
				$my_price=$to_comok["price"];
			}
			if ($db["orden"]==5){$message="Любые передачи запрещены Хаосникам!";}
			else if($art || $podzemka)
			{
				$message="Мы не принимаем АРТ или Предметы из подземелья";
			}
			else if(0.7*$gos_price>$_POST['price'])
			{
				$message="Мы не принимаем вещи <u>дешевле</u> чем за ".ceil(0.7*$gos_price)." Зл. Гос. цена &laquo;".$name."&raquo; составляет ".$gos_price." Зл. <br>
		      	В то время как вы указали ".$_POST['price']." Зл.";
			}
			else if($gos_price*1.3<$_POST['price'])
			{
				$message="Мы не принимаем вещи <u>дороже</u> чем за 30 % от гос. цены. Гос. цена &laquo;".$name."&raquo; составляет ".$gos_price." Зл. <br>
		      	В то время как вы указали ".$_POST['price']." Зл.";
			}
			else
			{
				mysql_query("LOCK TABLES comok WRITE");
				mysql_query("INSERT INTO `comok` (`owner`, `img`, `object_id`, `object_type`, `object_razdel`, `gravirovka`, `add_xp`, `runas`, `bs`, `term`, `is_modified`, `name`,  `mass`, `price`, `my_price`, `gos_price`, `min_sila`, `min_lovkost`, `min_udacha`, `min_power`, `min_intellekt`, `min_vospriyatie`, `min_level`, `min_sword_vl`, `min_staff_vl`, `min_axe_vl`, `min_fail_vl`, `min_knife_vl`, `min_spear_vl`,`min_fire`,`min_water`,`min_air`,`min_earth`,`min_svet`,`min_tma`,`min_gray`,`add_fire`, `add_water`, `add_air`, `add_earth`, `add_svet`, `add_tma`, `add_gray`, `add_sila`, `add_lovkost`, `add_udacha`, `add_intellekt`, `add_duxovnost`, `add_hp`, `add_mana`, `protect_head`, `protect_arm`, `protect_corp`, `protect_poyas`, `protect_legs`, `protect_rej`, `protect_drob`, `protect_kol`, `protect_rub`, `protect_fire`, `protect_water`, `protect_air`, `protect_earth`, `protect_svet`, `protect_tma`, `protect_gray`,`protect_mag`,`protect_udar`, `shieldblock`, `krit`, `akrit`, `uvorot`, `auvorot`, `parry`, `counter`, `add_rej`, `add_drob`, `add_kol`, `add_rub`, `ms_udar`, `ms_krit`, `ms_mag`, `ms_fire`, `ms_water`, `ms_air`, `ms_earth`, `ms_svet`, `ms_tma`, `ms_gray`, `ms_rej`, `ms_drob`, `ms_kol`, `ms_rub`,`iznos`, `iznos_max`, `min_attack`, `max_attack`, `proboy`, `add_oruj`, `add_sword_vl`, `add_staff_vl`, `add_axe_vl`, `add_fail_vl`, `add_knife_vl`, `add_spear_vl`, `need_orden`, `sex`, `art`, `podzemka`, `is_personal`, `personal_owner`, `noremont`, `two_hand`, `second_hand`,  `add_fire_att`, `add_air_att`, `add_watet_att`, `add_earth_att`, `edited`) 
				VALUES ('".$login."','".$to_comok["img"]."' ,'".$to_comok["object_id"]."', '".$to_comok["object_type"]."', '".$to_comok["object_razdel"]."', '".$to_comok["gravirovka"]."', '".$to_comok["add_xp"]."', '".$to_comok["runas"]."', '".$to_comok["bs"]."','".$to_comok["term"]."','".$to_comok["is_modified"]."', '".$name."', '".$to_comok["mass"]."', '".$_POST['price']."', '".$my_price."', '".$gos_price."', '".$to_comok["min_sila"]."', '".$to_comok["min_lovkost"]."', '".$to_comok["min_udacha"]."', '".$to_comok["min_power"]."', '".$to_comok["min_intellekt"]."', '".$to_comok["min_vospriyatie"]."', '".$to_comok["min_level"]."', '".$to_comok["min_sword_vl"]."', '".$to_comok["min_staff_vl"]."', '".$to_comok["min_axe_vl"]."', '".$to_comok["min_fail_vl"]."', '".$to_comok["min_knife_vl"]."', '".$to_comok["min_spear_vl"]."', '".$to_comok["min_fire"]."','".$to_comok["min_water"]."','".$to_comok["min_air"]."','".$to_comok["min_earth"]."','".$to_comok["min_svet"]."','".$to_comok["min_tma"]."','".$to_comok["min_gray"]."', '".$to_comok["add_fire"]."', '".$to_comok["add_water"]."', '".$to_comok["add_air"]."', '".$to_comok["add_earth"]."', '".$to_comok["add_svet"]."', '".$to_comok["add_tma"]."', '".$to_comok["add_gray"]."', '".$to_comok["add_sila"]."', '".$to_comok["add_lovkost"]."', '".$to_comok["add_udacha"]."', '".$to_comok["add_intellekt"]."', '".$to_comok["add_duxovnost"]."', '".$to_comok["add_hp"]."', '".$to_comok["add_mana"]."', '".$to_comok["protect_head"]."', '".$to_comok["protect_arm"]."', '".$to_comok["protect_corp"]."', '".$to_comok["protect_poyas"]."', '".$to_comok["protect_legs"]."', '".$to_comok["protect_rej"]."', '".$to_comok["protect_drob"]."', '".$to_comok["protect_kol"]."', '".$to_comok["protect_rub"]."', '".$to_comok["protect_fire"]."', '".$to_comok["protect_water"]."', '".$to_comok["protect_air"]."', '".$to_comok["protect_earth"]."', '".$to_comok["protect_svet"]."', '".$to_comok["protect_tma"]."', '".$to_comok["protect_gray"]."', '".$to_comok["protect_mag"]."', '".$to_comok["protect_udar"]."','".$to_comok["shieldblock"]."','".$to_comok["krit"]."', '".$to_comok["akrit"]."', '".$to_comok["uvorot"]."', '".$to_comok["auvorot"]."', '".$to_comok["parry"]."', '".$to_comok["counter"]."', '".$to_comok["add_rej"]."', '".$to_comok["add_drob"]."', '".$to_comok["add_kol"]."', '".$to_comok["add_rub"]."', '".$to_comok["ms_udar"]."', '".$to_comok["ms_krit"]."', '".$to_comok["ms_mag"]."', '".$to_comok["ms_fire"]."', '".$to_comok["ms_water"]."', '".$to_comok["ms_air"]."', '".$to_comok["ms_earth"]."', '".$to_comok["ms_svet"]."', '".$to_comok["ms_tma"]."', '".$to_comok["ms_gray"]."', '".$to_comok["ms_rej"]."', '".$to_comok["ms_drob"]."', '".$to_comok["ms_kol"]."', '".$to_comok["ms_rub"]."', '".$to_comok["iznos"]."', '".$to_comok["iznos_max"]."', '".$to_comok["min_attack"]."', '".$to_comok["max_attack"]."', '".$to_comok["proboy"]."','".$to_comok["add_oruj"]."' ,'".$to_comok["add_sword_vl"]."', '".$to_comok["add_staff_vl"]."', '".$to_comok["add_axe_vl"]."', '".$to_comok["add_fail_vl"]."', '".$to_comok["add_knife_vl"]."', '".$to_comok["add_spear_vl"]."', '".$to_comok["need_orden"]."', '".$to_comok["sex"]."', '".$to_comok["art"]."', '".$to_comok["podzemka"]."', '".$to_comok["is_personal"]."', '".$to_comok["personal_owner"]."', '".$to_comok["noremont"]."', '".$to_comok["two_hand"]."', '".$to_comok["second_hand"]."',  '".$to_comok["add_fire_att"]."', '".$to_comok["add_air_att"]."', '".$to_comok["add_watet_att"]."', '".$to_comok["add_earth_att"]."', '".$to_comok["edited"]."');");
				mysql_query("UNLOCK TABLES");
				mysql_query("DELETE FROM `inv` WHERE id = '".$to_comok["id"]."'");
				history($login,'Поставил',$name." за ".$_POST['price']." Зл. (Гос. цена - ".$gos_price." Зл.)",$ip,'Комиссионный магазин');
				$message="Вы сдали предмет &laquo;".$name."&raquo; в Комиссионный магазин по цене ".$_POST['price']." Зл. Когда товар будет продан деньги поступят к вам автоматически.";
			}
		}
		else $message="Вещь не найдена...";
	}
}
//----------------------------------------------------------------------------------
$money = sprintf ("%01.2f", $db["money"]);
$platina = sprintf ("%01.2f", $db["platina"]);
?>
<link rel=stylesheet type="text/css" href="smith.css">
<SCRIPT LANGUAGE="JavaScript" SRC="scripts/magic-main.js"></SCRIPT>
<div id=hint4></div>
<h3>Комиссионный магазин</h3>
<TABLE width=100% cellspacing=0 cellpadding=0>
<tr>
<td>
	<font color=#ff0000><?=$message;$message="";?>&nbsp;</font></td><td align=right nowrap>У вас в наличии: <B><?echo $money;?></b> Зл. <b><?echo $platina;?></b> Пл.
</td>
</tr>
</table>

<table cellpadding="0" cellspacing="0" border=0 width=100% height=100%>
<tr>
<td align="center" valign="top" width=100%>
	<table cellpadding="0" cellspacing="0" border="0" width=100%><tr>
	<td width=100%>
	<?
	//-------------------------------------Мои вещи-------------------------------------------------------------
	if($deist=="zabrat")
	{
		echo "<TABLE WIDTH=100% CELLSPACING=1 CELLPADDING=3 BGCOLOR=#212120>";
		echo "<tr class='fnew' align=center><td colspan=2><b>Ваши вещи в магазине</b><br />
			Если вы забираете предмет из комиссионного магазина, то с вас снимается 1 Зл. за хранение</td></tr>";
		
		$result=mysql_query("SELECT * FROM comok WHERE owner='".$login."'");
		if (mysql_num_rows($result))
		{	
			while($data = mysql_fetch_array($result))
			{
				$n=(!$n);
				$item_id = $data["id"];
		        $iznos = $data["iznos"];
				$iznos_all = $data["iznos_max"];
				$term=$data["term"];
				$del_time=$data["del_time"];
				echo "<tr bgcolor=".($n?'#D5D5D5':'#C7C7C7').">";
				if ($data["object_razdel"]=='obj')
				{
					echo "<td width=150 valign=center align=center><img src='img/items/".$data["img"]."'><br>";
					echo "<a style=\"cursor:hand\" href=\"#\" onclick=\"bMag('Сменить цену :', '?deist=zabrat&ids=$item_id&do=2', 'price', '','5','2', '".$data["name"]." ($iznos/$iznos_all)')\" title='Сменить цену' >Сменить цену</a><br />";
					echo "<a style=\"cursor:hand\" href=\"?deist=zabrat&ids=$item_id&do=3\" title='Забрать вещи.' >Забрать</a>";
					echo "</td><td valign='top'>";
					show_item($db,$data);
					echo "</td></tr>";
				}
				else
				{
					$DAT=mysql_fetch_array(mysql_query("SELECT * FROM scroll WHERE id=".$data["object_id"]));
					$spell_id=$DAT["id"];
			        $name = $DAT["name"];
			        $img = $DAT["img"];
			        $min_i = $DAT["min_intellekt"];
			        $min_v = $DAT["min_vospriyatie"];
			        $min_level = $DAT["min_level"];
			        $desc = $DAT["desc"];
			        $type = $DAT["type"];
			        $mana = $DAT["mana"]; 
			        $school = $DAT["school"];
			        $artovka = $DAT["art"];
			        $price=$data["price"];
			        $price=sprintf ("%01.2f", $price);
			        echo "<td width=150 valign=center align=center><img src='img/$img'><br>";
					echo "<a style=\"cursor:hand\" href=\"#\" onclick=\"bMag('Сменить цену :', '?deist=zabrat&ids=$item_id&do=2', 'price', '','5','2', '".$name." ($iznos/$iznos_all)')\" title='Сменить цену' >Сменить цену</a><br />";
					echo "<a style=\"cursor:hand\" href=\"?deist=zabrat&ids=$item_id&do=3\" title='Забрать вещи.' >Забрать</a>";
			        echo "</td><td valign=top><b>$name</b> ".($artovka?"<img src='img/icon/artefakt.gif' border=0 alt=\"АРТЕФАКТ\">":"")." (Масса: ".$DAT["mass"].")<br>";
					echo "<b>Цена: ".$price.($artovka?" Пл.":" Зл.")."</b><BR>";
			        echo "Долговечность: $iznos/$iznos_all<BR>";
			        if ($del_time>0)
			        {
			        	echo "Срок годности: $del_time дн. (до  ".(date('d.m.y H:i:s', $term)).")<br>";
			        	if ($term<time())
			        	{
			        		mysql_query("DELETE FROM inv WHERE id=$item_id");
			        		history($login,"Закончился срок годности",$name,$db["remote_ip"],"Инвентарь");
			        	}
			        }
			        if ($min_i>0 || $min_v>0 || $min_level>0)echo "<BR><b>Требования:</b><BR>";
			        if($min_i)
					{
						echo "&bull; ".($min_i>$db["intellekt"]?"<font color=red>":"")."Интеллект: $min_i</font><BR>";
					}
					if($min_v)
					{
						echo "&bull; ".($min_v>$db["vospriyatie"]?"<font color=red>":"")."Воссприятие: $min_v</font><BR>";
					}
					if ($min_level>0)
					{	
			        	echo "&bull; ".($min_level>$db["level"]?"<font color=red>":"")."Уровень: $min_level</font><BR>";
			        }
			        if($mana)
					{
						echo "&bull; Исп. маны: ".$mana."<BR>";
					}
					if($school)
					{
						switch ($school) 
						{
							 case "air":$school_d = "Воздух";break;
							 case "water":$school_d = "Вода";break;
						 	 case "fire":$school_d = "Огонь";break;
						 	 case "earth":$school_d = "Земля";break;
						}
						echo "&bull; Стихия: <b>".$school_d."</b><BR>";
					}
			        if($DAT["descs"])
			        {
			        	echo "<br>";
			        	echo "<div style=\"background-color: #FAF0E6\"><small><b>Описание:</b> ".$DAT["descs"]."</small></div>";
			        }

				}
				echo "</td></tr>";
			}
		}
		else
		{
			echo "<TR><TD bgcolor=e2e0e0 align=center colspan=2><b>Ваших вещей в магазине нет!</b></td></tr>";
		}
		echo "</table><br>";
	}
	//----------------------------Приём вещей---------------------------------------------------------------------------
	else if($deist=="sdat")
	{
		//------------------------------------------------список вещей в инвентaрe---------------------
		echo "<TABLE WIDTH=100% CELLSPACING=1 CELLPADDING=2 BGCOLOR=#212120>";
		echo "<tr class='fnew' align=center><td colspan=2><b>Отдел \"Сдать вещи\"</b> <br />
		При продаже вашей вещи взымается комиссия 10% от стоимости сделки, но не меньше 1.00 Зл.</td></tr>";
		$result=mysql_query("SELECT * FROM inv WHERE owner='".$login."' and (object_razdel='obj' or object_razdel='magic') and wear='0' and gift=0 ORDER BY object_razdel DESC");
		while($data = mysql_fetch_array($result))
		{
			$n=(!$n);
			$item_id = $data["id"];
	        $iznos = $data["iznos"];
			$iznos_all = $data["iznos_max"];
			$term=$data["term"];
			$del_time=$data["del_time"];
			echo "<tr bgcolor=".($n?'#D5D5D5':'#C7C7C7').">";
			if ($data["object_razdel"]=='obj')
			{
				echo "<td width=150 valign=center align=center><img src='img/items/".$data["img"]."'><br>";
				echo "<a href=\"#\" style=\"cursor:hand\" onclick=\"bMag('Сдать в магазин:', '?deist=sdat&do=1&ids=".$item_id."', 'price', '','5','2', '".$data["name"]." (".$iznos."/".$iznos_all.")')\" title='Сдать в магазин.' >Сдать в магазин</a>";
				echo "</td><td valign='top'>";
				show_item($db,$data);
				echo "</td></tr>";
			}
			else
			{
				$DAT=mysql_fetch_array(mysql_query("SELECT * FROM scroll WHERE id=".$data["object_id"]));
				$spell_id=$DAT["id"];
		        $name = $DAT["name"];
		        $img = $DAT["img"];
		        $min_i = $DAT["min_intellekt"];
		        $min_v = $DAT["min_vospriyatie"];
		        $min_level = $DAT["min_level"];
		        $desc = $DAT["desc"];
		        $type = $DAT["type"];
		        $mana = $DAT["mana"]; 
		        $school = $DAT["school"];
		        $artovka = $DAT["art"];
		        $price=$DAT["price"];
		        $price=sprintf ("%01.2f", $price);
		        echo "<td width=150 valign=center align=center><img src='img/$img'><br>";
				echo "<a href=\"#\" style=\"cursor:hand\" onclick=\"bMag('Сдать в магазин:', '?deist=sdat&do=1&ids=".$item_id."', 'price', '','5','2', '".$name." (".$iznos."/".$iznos_all.")')\" title='Сдать в магазин.' >Сдать в магазин</a>";
		        echo "</td><td valign=top><b>$name</b> ".($artovka?"<img src='img/icon/artefakt.gif' border=0 alt=\"АРТЕФАКТ\">":"")." (Масса: ".$DAT["mass"].")<br>";
				echo "<b>Цена: ".$price.($artovka?" Пл.":" Зл.")."</b><BR>";
		        echo "Долговечность: $iznos/$iznos_all<BR>";
		        if ($del_time>0)
		        {
		        	echo "Срок годности: $del_time дн. (до  ".(date('d.m.y H:i:s', $term)).")<br>";
		        	if ($term<time())
		        	{
		        		mysql_query("DELETE FROM inv WHERE id=$item_id");
		        		history($login,"Закончился срок годности",$name,$db["remote_ip"],"Инвентарь");
		        	}
		        }
		        if ($min_i>0 || $min_v>0 || $min_level>0)echo "<BR><b>Требования:</b><BR>";
		        if($min_i)
				{
					echo "&bull; ".($min_i>$db["intellekt"]?"<font color=red>":"")."Интеллект: $min_i</font><BR>";
				}
				if($min_v)
				{
					echo "&bull; ".($min_v>$db["vospriyatie"]?"<font color=red>":"")."Воссприятие: $min_v</font><BR>";
				}
				if ($min_level>0)
				{	
		        	echo "&bull; ".($min_level>$db["level"]?"<font color=red>":"")."Уровень: $min_level</font><BR>";
		        }
		        if($mana)
				{
					echo "&bull; Исп. маны: ".$mana."<BR>";
				}
				if($school)
				{
					switch ($school) 
					{
						 case "air":$school_d = "Воздух";break;
						 case "water":$school_d = "Вода";break;
					 	 case "fire":$school_d = "Огонь";break;
					 	 case "earth":$school_d = "Земля";break;
					}
					echo "&bull; Стихия: <b>".$school_d."</b><BR>";
				}
		        if($DAT["descs"])
		        {
		        	echo "<br>";
		        	echo "<div style=\"background-color: #FAF0E6\"><small><b>Описание:</b> ".$DAT["descs"]."</small></div>";
		        }

			}
			echo "</td></tr>";
		}
		echo "</table><br>";
	}
	//--------вывод предметов из витрины -------------------------------------------
	else if($otdel && $set)
	{
		echo "<TABLE WIDTH=100% CELLSPACING=1 CELLPADDING=3 BGCOLOR=#212120>";
		$comok_otdel_sql = mysql_query("SELECT * FROM comok WHERE object_id='".$set."' and object_type = '".$otdel."'");
		if (!mysql_num_rows($comok_otdel_sql))
		{
			echo "<tr bgcolor='#C7C7C7'><td align=center><b>Прилавок магазина пустой...</b></td></tr>";
		}
		else
		{
			while($data = mysql_fetch_array($comok_otdel_sql))
			{
				$n=(!$n);
				$item_id = $data["id"];
		        $iznos = $data["iznos"];
				$iznos_all = $data["iznos_max"];
				$term=$data["term"];
				$del_time=$data["del_time"];
				echo "<tr bgcolor=".($n?'#D5D5D5':'#C7C7C7').">";
				if ($data["object_razdel"]=='obj')
				{
					echo "<td width=150 valign=center align=center><img src='img/items/".$data["img"]."'><br>";
					echo "<a href='?buy=$otdel&item=$item_id&set=$set' >Купить</a>";
					echo "</td><td valign='top'>";
					show_item($db,$data);
					echo "</td></tr>";
				}
				else
				{
					$DAT=mysql_fetch_array(mysql_query("SELECT * FROM scroll WHERE id=".$data["object_id"]));
					$spell_id=$DAT["id"];
			        $name = $DAT["name"];
			        $img = $DAT["img"];
			        $min_i = $DAT["min_intellekt"];
			        $min_v = $DAT["min_vospriyatie"];
			        $min_level = $DAT["min_level"];
			        $desc = $DAT["desc"];
			        $type = $DAT["type"];
			        $mana = $DAT["mana"]; 
			        $school = $DAT["school"];
			        $artovka = $DAT["art"];
			        $price=$DAT["price"];
			        $price=sprintf ("%01.2f", $price);
			        echo "<td width=150 valign=center align=center><img src='img/$img'><br>";
					echo "<a href='?buy=$otdel&item=$item_id&set=$set' >Купить</a>";
			        echo "</td><td valign=top><b>$name</b> ".($artovka?"<img src='img/icon/artefakt.gif' border=0 alt=\"АРТЕФАКТ\">":"")." (Масса: ".$DAT["mass"].")<br>";
					echo "<b>Цена: ".$price.($artovka?" Пл.":" Зл.")."</b><BR>";
			        echo "Долговечность: $iznos/$iznos_all<BR>";
			        if ($del_time>0)
			        {
			        	echo "Срок годности: $del_time дн. (до  ".(date('d.m.y H:i:s', $term)).")<br>";
			        	if ($term<time())
			        	{
			        		mysql_query("DELETE FROM inv WHERE id=$item_id");
			        		history($login,"Закончился срок годности",$name,$db["remote_ip"],"Инвентарь");
			        	}
			        }
			        if ($min_i>0 || $min_v>0 || $min_level>0)echo "<BR><b>Требования:</b><BR>";
			        if($min_i)
					{
						echo "&bull; ".($min_i>$db["intellekt"]?"<font color=red>":"")."Интеллект: $min_i</font><BR>";
					}
					if($min_v)
					{
						echo "&bull; ".($min_v>$db["vospriyatie"]?"<font color=red>":"")."Воссприятие: $min_v</font><BR>";
					}
					if ($min_level>0)
					{	
			        	echo "&bull; ".($min_level>$db["level"]?"<font color=red>":"")."Уровень: $min_level</font><BR>";
			        }
			        if($mana)
					{
						echo "&bull; Исп. маны: ".$mana."<BR>";
					}
					if($school)
					{
						switch ($school) 
						{
							 case "air":$school_d = "Воздух";break;
							 case "water":$school_d = "Вода";break;
						 	 case "fire":$school_d = "Огонь";break;
						 	 case "earth":$school_d = "Земля";break;
						}
						echo "&bull; Стихия: <b>".$school_d."</b><BR>";
					}
			        if($DAT["descs"])
			        {
			        	echo "<br>";
			        	echo "<div style=\"background-color: #FAF0E6\"><small><b>Описание:</b> ".$DAT["descs"]."</small></div>";
			        }
				}
				echo "</td></tr>";
			}
		}
		echo "</table><br>";
	}
	else
	{
		//------------вывод витрины раздела----------------------------------------------------		
		if ($otdel=='scroll')$dddd='scroll';else $dddd='paltar';
		$sql= "SELECT
		        c. * , o.name, o.img, o.mass,
		         count( c.object_id ) AS count,
		         min( c.price ) AS price_min,
		         max( c.price ) AS price_max,
		         min( c.iznos ) AS iznos_m_min,
		         max( c.iznos ) AS iznos_m_max
		      FROM
		         comok AS c
		      LEFT JOIN $dddd AS o ON ( o.id = c.object_id )
		      WHERE c.object_type = '".$otdel."'
		      GROUP BY c.object_id ";
		$comok_otdel_sql = mysql_query($sql);
		$counts=mysql_num_rows($comok_otdel_sql);

		echo "<TABLE WIDTH=100% CELLSPACING=1 CELLPADDING=3 BGCOLOR=#212120 border=0>
		<tr class='fnew' align=center><td colspan=2 width=100%><b>Ассортимент товаров отдела: \"".$otdels[$otdel]."\"</b> </td></tr>";

		while($comok_otdel = mysql_fetch_array($comok_otdel_sql))
		{
			$n=(!$n);
			echo "<tr bgcolor=".($n?'#C7C7C7':'#D5D5D5').">";
			echo "<td valign=center align=center width=200 nowrap>";
			echo"<img border=\"0\" src=\"img/".($otdel=='scroll'?"":"/items/").$comok_otdel["img"]."\" alt='".$comok_otdel["name"]."'>";
			echo "<br /><a href=\"?otdel=$otdel&set=".$comok_otdel["object_id"]."\" >Подробнее</a>";
			if ($db["adminsite"]>2)echo "<br /><a href=\"?otdel=$otdel&by_all=true&set=".$comok_otdel["object_id"]."\" >купит все</a>";
			echo "</td>";
			echo "<td valign=top width=100%>";
			$price_min = sprintf ("%01.2f", $comok_otdel["price_min"]);
			$price_max = sprintf ("%01.2f", $comok_otdel["price_max"]);
			$mass=$comok_otdel["mass"];
			$count=$comok_otdel["count"];
			$iznos_m_min=$comok_otdel["iznos_m_min"];
			$iznos_m_max=$comok_otdel["iznos_m_max"];
			if($iznos_m_min != $iznos_m_max){$iznos_min="$iznos_m_min-$iznos_m_max";}else{$iznos_min=$iznos_m_min;}
			$iznos_max=$comok_otdel["iznos_max"];
			echo "<b>".$comok_otdel["name"]."</b> (Масса: $mass)<br>";
			echo "<b>Цена: $price_min";
			if($price_max!=$price_min){echo " - $price_max";}
			echo " зл.</b>";
			echo "<br>Количество:  $count шт.";
			echo "<br>Долговечность: $iznos_min/$iznos_max";
			echo "</td></tr>";
		}
		if ($counts<=0)	echo "<TR><TD bgcolor=e2e0e0 align=center colspan=2><b>Прилавок магазина пустой</b></td></tr>";
		echo "</table><br>";
	}
?>
	</td>
	</tr>
	</table>
</td>
<td >&nbsp;</td>
<td valign="top" align=right>
	<table class="g" width="180" cellspacing="1" cellpadding="3">
    <tr bgcolor="#cdcdcd">
        <td>
			<input type=button style="width:100%; cursor:hand" onclick="location.href='?deist=sdat'" value=" Сдать вещи " class=newbut >	
			<input type=button style="width:100%; cursor:hand" onclick="location.href='?deist=zabrat'" value=" Забрать вещи " class=newbut >
			<INPUT type=button style="width:100%; cursor:hand" onclick="location.href='main.php?act=go&level=municip'" value="Выход" class="newbut">	
        </td>
    </tr>
	</table>
	<br>	  	  
	<?include_once("inc/shop/otdels.php")?>
	<br>
	<table class="g" width="180" cellspacing="1" cellpadding="3" >
    <tr bgcolor="#cdcdcd">
        <td>	
			&nbsp;<a href='?otdel=scroll'  >Магические свитки</a><br />	
        </td>
    </tr>
	</table>
  </td>
  </tr>
</table>