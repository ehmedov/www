<?
function userip() 
{
	if (getenv('HTTP_X_FORWARDED_FOR')) 
	{
		$strIP = getenv('HTTP_X_FORWARDED_FOR');
	} 
	elseif (getenv('HTTP_X_FORWARDED')) 
	{
		$strIP = getenv('HTTP_X_FORWARDED');
	} 
	elseif (getenv('HTTP_FORWARDED_FOR')) 
	{
		$strIP = getenv('HTTP_FORWARDED_FOR');
	} 
	elseif (getenv('HTTP_FORWARDED')) 
	{
		$strIP = getenv('HTTP_FORWARDED');
	} 
	else 
	{
		$strIP = $_SERVER['REMOTE_ADDR'];
	}
	return $strIP;
}
//=====================================================================================================
function say($to,$text,$sender)
{
	$result = mysql_query("SELECT room,city_game FROM `users` WHERE login='".$sender."'");
	$db = mysql_fetch_array($result);
	mysql_free_result($result);
	$login=$to;
	$room = $db["room"];
	$city = $db["city_game"];
    $text = "sys $text</font>endSys";
	$chat_base = "/srv/www/meydan.az/public_html/chat/lovechat";
	if($to == "toall"){$to = "sys";}
	else if($to == "toall_news"){$to = "sys_news";}
	$fopen_chat = fopen($chat_base,"a");
	fwrite ($fopen_chat,"::".time()."::$to::#990000::$text::".$db["room"]."::".$db["city_game"]."::\n");
	fclose ($fopen_chat);
}
//=====================================================================================================
function roomcount($r)
{		
	$rc=mysql_fetch_array(mysql_query("select count(*) FROM online where room='".htmlspecialchars(addslashes($r))."'"));
	return $rc[0];
}
//================================Item Desc ============================================================
function show_item($db,$item_Array)
{
	global $effect;
	if ($db["vip"]>time())$price_art=sprintf ("%01.2f", ceil($item_Array["price"]*0.75));
	$price_gos = sprintf ("%01.2f", $item_Array["price"]);

	if (!$item_Array["podzemka"])
	{
		if ($item_Array["art"]){$price_print="Пл."; $my_money=$db['platina'];}else {$price_print="Зл."; $my_money=$db['money'];}
	}
	else {$price_print="Ед."; $my_money=$db['naqrada'];}


	$is_runa=$item_Array["runas"];
	$rname=explode("#",$is_runa);
	if ($is_runa)
	{
		$r_name=mysql_fetch_array(mysql_query("SELECT name FROM runa WHERE type='".$rname[0]."' and step='".$rname[1]."'"));
	}
	$str="<b ".($item_Array["art"]==1?"style='color:#95486D;'":"").($item_Array["art"]==2?"style='color:#b22222;'":"").">".$item_Array["name"].($item_Array["is_modified"]?" +".$item_Array["is_modified"]:"")."</b>".($item_Array["gift"]?"&nbsp;<img src='http://www.meydan.az/img/icon/gift.gif' border='0' alt='Подарок от ".$item_Array["gift_author"]."' />":"").($item_Array["art"]==1?"&nbsp;<img src='http://www.meydan.az/img/artefakt.gif' border='0' alt='АРТЕФАКТ' />":"").($item_Array["art"]==2?"&nbsp;<img src='http://www.meydan.az/img/icon/artefakt.gif' border='0' alt='АРТЕФАКТ' />":"").($item_Array["podzemka"]?"&nbsp;<img src='http://www.meydan.az/img/icon/podzemka.gif' border='0' alt='Вещи Потерянных Героев' />":"").($is_runa?"<img src='http://www.meydan.az/img/icon/runa.gif' alt='".$r_name["name"]."' />":"");
	if($item_Array["need_orden"])
	{
		switch ($item_Array["need_orden"]) 
		{
			 case 1:$orden_dis = "Стражи порядка";break;
			 case 2:$orden_dis = "Вампиры";break;
		 	 case 3:$orden_dis = "Орден Равновесия";break;
		 	 case 4:$orden_dis = "Орден Света";break;
		 	 case 5:$orden_dis = "Тюремный заключеный";break;
		 	 case 6:$orden_dis = "Истинный Мрак";break;
		}
		$str.="&nbsp;<img src='http://www.meydan.az/img/orden/".$item_Array["need_orden"]."/0.gif' border='0' alt='Требуемый орден: ".$orden_dis."' />";
	}
	$str.="&nbsp;(Масса: ".$item_Array["mass"].")<br/>";
	$str.="<b>Цена: ".($item_Array["price"]>$my_money  && count($db)>0?"<font color='#ff0000'>":"").$price_gos.($db["vip"]>time() && $item_Array["art"]>0?" [V.I.P Клуб ".$price_art."]":"")."</font> ".$price_print."</b>";
	$str.=($item_Array["gos_price"]>0?" (Гос. цена: ".sprintf ("%01.2f", $item_Array["gos_price"])." $price_print)":"");
	$str.="<br/>Долговечность: ".(int)$item_Array["iznos"]."/".(int)$item_Array["iznos_max"]."<br/>";
	$str.=($item_Array["edited"]>0?"<font color='#228b22'>Возможно усиление до 10го уровня</font><br/>":"");
	$str.=($item_Array["object"]=="spear" || $item_Array["object_type"]=="spear"?"Срок годности: 30 дн.<br/>":"");
	$str.=($item_Array["add_xp"]>0?"Усилен: +".$item_Array["add_xp"]."<br/>":"");
	$str.=($item_Array["gravirovka"]!=""?"Выгравирована надпись: <i>".$item_Array["gravirovka"]."</i><br/>":"");

	$str.="<b>Требуется минимальное:</b><br/>";
	
	$str.=(($item_Array['min_sila'])?"• ".(($item_Array['min_sila'] > ($db['sila']+$effect["add_sila"]) && count($db)>0)?"<font color='#ff0000'>":"")."Сила: {$item_Array['min_sila']}</font><br/>":"");
	$str.=(($item_Array['min_lovkost'])?"• ".(($item_Array['min_lovkost'] > ($db['lovkost']+$effect["add_lovkost"]) && count($db)>0)?"<font color='#ff0000'>":"")."Ловкость: {$item_Array['min_lovkost']}</font><br/>":"");
	$str.=(($item_Array['min_udacha'])?"• ".(($item_Array['min_udacha'] > ($db['udacha']+$effect['add_udacha']) && count($db)>0)?"<font color='#ff0000'>":"")."Удача: {$item_Array['min_udacha']}</font><br/>":"");
	$str.=(($item_Array['min_power'])?"• ".(($item_Array['min_power'] > $db['power'] && count($db)>0)?"<font color='#ff0000'>":"")."Выносливость: {$item_Array['min_power']}</font><br/>":"");
	$str.=(($item_Array['min_intellekt'])?"• ".(($item_Array['min_intellekt'] > ($db['intellekt']+$effect['add_intellekt']) && count($db)>0)?"<font color='#ff0000'>":"")."Интеллект: {$item_Array['min_intellekt']}</font><br/>":"");
	$str.=(($item_Array['min_vospriyatie'])?"• ".(($item_Array['min_vospriyatie'] > $db['vospriyatie'] && count($db)>0)?"<font color='#ff0000'>":"")."Воссприятие: {$item_Array['min_vospriyatie']}</font><br/>":"");
	$str.=(($item_Array['min_level'])?"• ".(($item_Array['min_level'] > $db['level'] && count($db)>0)?"<font color='#ff0000'>":"")."Уровень: {$item_Array['min_level']}</font><br/>":"");

	$str.=(($item_Array['min_sword_vl'])?"• ".(($item_Array['min_sword_vl'] > $db['sword_vl'] && count($db)>0)?"<font color='#ff0000'>":"")."Мастерство владения мечами: {$item_Array['min_sword_vl']}</font><br/>":"");
	$str.=(($item_Array['min_staff_vl'])?"• ".(($item_Array['min_staff_vl'] > $db['staff_vl'] && count($db)>0)?"<font color='#ff0000'>":"")."Мастерство владение посохами: {$item_Array['min_staff_vl']}</font><br/>":"");
	$str.=(($item_Array['min_axe_vl'])?"• ".(($item_Array['min_axe_vl'] > $db['axe_vl'] && count($db)>0)?"<font color='#ff0000'>":"")."Мастерство владения топорами, секирами: {$item_Array['min_axe_vl']}</font><br/>":"");
	$str.=(($item_Array['min_fail_vl'])?"• ".(($item_Array['min_fail_vl'] > $db['hummer_vl'] && count($db)>0)?"<font color='#ff0000'>":"")."Мастерство владения дубинами и булавами: {$item_Array['min_fail_vl']}</font><br/>":"");
	$str.=(($item_Array['min_knife_vl'])?"• ".(($item_Array['min_knife_vl'] > $db['castet_vl'] && count($db)>0)?"<font color='#ff0000'>":"")."Мастерство владения ножами, кастетами: {$item_Array['min_knife_vl']}</font><br/>":"");
	$str.=(($item_Array['min_spear_vl'])?"• ".(($item_Array['min_spear_vl'] > $db['copie_vl'] && count($db)>0)?"<font color='#ff0000'>":"")."Мастерство владения древковоми оружиями: {$item_Array['min_spear_vl']}</font><br/>":"");
	
	$str.=(($item_Array['min_fire'])?"• ".(($item_Array['min_fire'] > $db['fire_magic'] && count($db)>0)?"<font color='#ff0000'>":"")."Владение магией Огня: {$item_Array['min_fire']}</font><br/>":"");
	$str.=(($item_Array['min_water'])?"• ".(($item_Array['min_water'] > $db['water_magic'] && count($db)>0)?"<font color='#ff0000'>":"")."Владение магией Воды: {$item_Array['min_water']}</font><br/>":"");
	$str.=(($item_Array['min_air'])?"• ".(($item_Array['min_air'] > $db['air_magic'] && count($db)>0)?"<font color='#ff0000'>":"")."Владение магией Воздуха: {$item_Array['min_air']}</font><br/>":"");
	$str.=(($item_Array['min_earth'])?"• ".(($item_Array['min_earth'] > $db['earth_magic'] && count($db)>0)?"<font color='#ff0000'>":"")."Владение магией Земли: {$item_Array['min_earth']}</font><br/>":"");
	$str.=(($item_Array['min_svet'])?"• ".(($item_Array['min_svet'] > $db['svet_magic'] && count($db)>0)?"<font color='#ff0000'>":"")."Владение магией Света: {$item_Array['min_svet']}</font><br/>":"");
	$str.=(($item_Array['min_tma'])?"• ".(($item_Array['min_tma'] > $db['tma_magic'] && count($db)>0)?"<font color='#ff0000'>":"")."Владение магией Тьмы: {$item_Array['min_tma']}</font><br/>":"");
	$str.=(($item_Array['min_gray'])?"• ".(($item_Array['min_gray'] > $db['gray_magic'] && count($db)>0)?"<font color='#ff0000'>":"")."Владение серой магией: {$item_Array['min_gray']}</font><br/>":"");
	
	if($item_Array['sex']!="" && count($db)>0)
	{
		$str.="• ";
		if ($item_Array['sex']!=$db["sex"])$str.="<font color='#ff0000'>";
		if ($item_Array['sex'] == "female")$str.="Пол: Женский";
	    else if($item_Array['sex'] == "male")$str.="Пол: Мужской";
		$str.="</font><br/>";
	}
	$str.="<b>Действует на:</b><br/>";
	
	$str.=(($item_Array['two_hand'])?"• <font style='color:#008080'><b>Двуручное оружие</b></font><br/>":"");
	$str.=(($item_Array['second_hand'])?"• <font color'#228b22'>Второе оружие</font><br/>":"");

	$str.=(($item_Array['min_attack'] && $item_Array['max_attack'])?"• Урон: {$item_Array['min_attack']} - {$item_Array['max_attack']}<br/>":"");
	$str.=(($item_Array['proboy'])?"• Мф. удара сквозь броню: {$item_Array['proboy']}<br/>":"");

	$str.=(($item_Array['add_sila']>0)?"• Сила: +{$item_Array['add_sila']}<br/>":"");
	$str.=(($item_Array['add_sila']<0)?"• Сила: {$item_Array['add_sila']}<br/>":"");
	$str.=(($item_Array['add_lovkost']>0)?"• Ловкость: +{$item_Array['add_lovkost']}<br/>":"");
	$str.=(($item_Array['add_lovkost']<0)?"• Ловкость: {$item_Array['add_lovkost']}<br/>":"");
	$str.=(($item_Array['add_udacha']>0)?"• Удача: +{$item_Array['add_udacha']}<br/>":"");
	$str.=(($item_Array['add_udacha']<0)?"• Удача: {$item_Array['add_udacha']}<br/>":"");
	$str.=(($item_Array['add_intellekt']>0)?"• Интеллект: +{$item_Array['add_intellekt']}<br/>":"");
	$str.=(($item_Array['add_duxovnost']>0)?"• Духовность: +{$item_Array['add_duxovnost']}<br/>":"");
	$str.=(($item_Array['add_hp'])?"• Уровень жизни: +{$item_Array['add_hp']}<br/>":"");
	$str.=(($item_Array['add_mana'])?"• Уровень маны: +{$item_Array['add_mana']}<br/>":"");
	
	$str.=(($item_Array['krit'])?"• Мф. критических ударов: {$item_Array['krit']}%<br/>":"");
	$str.=(($item_Array['akrit'])?"• Мф. против крит. ударов: {$item_Array['akrit']}%<br/>":"");
	$str.=(($item_Array['ms_krit'])?"• Мф. мощности крит. удара: {$item_Array['ms_krit']}%<br/>":"");
	$str.=(($item_Array['parry'])?"• Мф. парирования: {$item_Array['parry']}%<br/>":"");
	$str.=(($item_Array['counter'])?"• Мф. контрудара: {$item_Array['counter']}%<br/>":"");
	$str.=(($item_Array['uvorot'])?"• Мф. увертывания: {$item_Array['uvorot']}%<br/>":"");
	$str.=(($item_Array['auvorot'])?"• Мф. против увертывания: {$item_Array['auvorot']}%<br/>":"");
	
	$str.=(($item_Array['add_krit'])?"• Мф. критических ударов: {$item_Array['add_krit']}%<br/>":"");
	$str.=(($item_Array['add_akrit'])?"• Мф. против крит. ударов: {$item_Array['add_akrit']}%<br/>":"");
	$str.=(($item_Array['add_uvorot'])?"• Мф. увертывания: {$item_Array['add_uvorot']}%<br/>":"");
	$str.=(($item_Array['add_auvorot'])?"• Мф. против увертывания: {$item_Array['add_auvorot']}%<br/>":"");

	
	$str.=(($item_Array['add_oruj'])?"• Владения Оружием: +{$item_Array['add_oruj']}<br/>":"");
	$str.=(($item_Array['add_knife_vl'])?"• Мастерство владения ножами и кастетами: +{$item_Array['add_knife_vl']}<br/>":"");
	$str.=(($item_Array['add_axe_vl'])?"• Мастерство владения топорами и секирами: +{$item_Array['add_axe_vl']}<br/>":"");
	$str.=(($item_Array['add_fail_vl'])?"• Мастерство владения дубинами и булавами: +{$item_Array['add_fail_vl']}<br/>":"");
	$str.=(($item_Array['add_sword_vl'])?"• Мастерство владения мечами: +{$item_Array['add_sword_vl']}<br/>":"");
	$str.=(($item_Array['add_staff_vl'])?"• Мастерство владение посохами: +{$item_Array['add_staff_vl']}<br/>":"");
	$str.=(($item_Array['add_spear_vl'])?"• Мастерство владения древковоми оружиями: +{$item_Array['add_spear_vl']}<br/>":"");
	
	$str.=(($item_Array['add_fire'])?"• Мастерство владения стихией Огня: +{$item_Array['add_fire']}<br/>":"");
	$str.=(($item_Array['add_water'])?"• Мастерство владения стихией Воды: +{$item_Array['add_water']}<br/>":"");
	$str.=(($item_Array['add_air'])?"• Мастерство владения стихией Воздуха: +{$item_Array['add_air']}<br/>":"");
	$str.=(($item_Array['add_earth'])?"• Мастерство владения стихией Земли: +{$item_Array['add_earth']}<br/>":"");
	$str.=(($item_Array['add_svet'])?"• Мастерство владения магией Света: +{$item_Array['add_svet']}<br/>":"");
	$str.=(($item_Array['add_gray'])?"• Мастерство владения серой магией: +{$item_Array['add_gray']}<br/>":"");
	$str.=(($item_Array['add_tma'])?"• Мастерство владения магией Тьмы: +{$item_Array['add_tma']}<br/>":"");
	
	$str.=(($item_Array['protect_head'])?"• Броня головы: {$item_Array['protect_head']}<br/>":"");
	$str.=(($item_Array['protect_arm'])?"• Броня рук: {$item_Array['protect_arm']}<br/>":"");
	$str.=(($item_Array['protect_corp'])?"• Броня корпуса: {$item_Array['protect_corp']}<br/>":"");
	$str.=(($item_Array['protect_poyas'])?"• Броня пояса: {$item_Array['protect_poyas']}<br/>":"");
	$str.=(($item_Array['protect_legs'])?"• Броня ног: {$item_Array['protect_legs']}<br/>":"");
	
	$str.=(($item_Array['protect_rej'])?"• Защита от режущего урона: {$item_Array['protect_rej']}<br/>":"");
	$str.=(($item_Array['protect_drob'])?"• Защита от дробящего урона: {$item_Array['protect_drob']}<br/>":"");
	$str.=(($item_Array['protect_kol'])?"• Защита от колющего урона: {$item_Array['protect_kol']}<br/>":"");
	$str.=(($item_Array['protect_rub'])?"• Защита от рубящего урона: {$item_Array['protect_rub']}<br/>":"");
	
	$str.=(($item_Array['protect_fire'])?"• Защиты от магии Огня: {$item_Array['protect_fire']}<br/>":"");
	$str.=(($item_Array['protect_water'])?"• Защиты от магии Воды: {$item_Array['protect_water']}<br/>":"");
	$str.=(($item_Array['protect_air'])?"• Защиты от магии Воздуха: {$item_Array['protect_air']}<br/>":"");
	$str.=(($item_Array['protect_earth'])?"• Защиты от магии Земли: {$item_Array['protect_earth']}<br/>":"");	
	$str.=(($item_Array['protect_svet'])?"• Защиты от магии Света: {$item_Array['protect_svet']}<br/>":"");
	$str.=(($item_Array['protect_tma'])?"• Защиты от магии Тьмы: {$item_Array['protect_tma']}<br/>":"");
	$str.=(($item_Array['protect_gray'])?"• Защиты от Серой магии: {$item_Array['protect_gray']}<br/>":"");

	$str.=(($item_Array['protect_udar'])?"• Защита от урона: +{$item_Array['protect_udar']}%<br/>":"");
	$str.=(($item_Array['protect_mag'])?"• Защита от магии: +{$item_Array['protect_mag']}%<br/>":"");
	
	$str.=(($item_Array['shieldblock'])?"• Мф.блока щитом: +{$item_Array['shieldblock']}%<br/>":"");
	
	$str.=(($item_Array['ms_udar'])?"• Мф. мощности урона: +{$item_Array['ms_udar']}%<br/>":"");
	$str.=(($item_Array['ms_rub'])?"• Мф. мощности рубящго урона: +{$item_Array['ms_rub']}%<br/>":"");
	$str.=(($item_Array['ms_kol'])?"• Мф. мощности колющего урона: +{$item_Array['ms_kol']}%<br/>":"");
	$str.=(($item_Array['ms_drob'])?"• Мф. мощности дробящего урона: +{$item_Array['ms_drob']}%<br/>":"");
	$str.=(($item_Array['ms_rej'])?"• Мф. мощности режущего урона: +{$item_Array['ms_rej']}%<br/>":"");
	
	$str.=(($item_Array['ms_mag'])?"• Мф. мощности магии стихий: +{$item_Array['ms_mag']}%<br/>":"");
	$str.=(($item_Array['ms_fire'])?"• Мф. мощности магии Огня: +{$item_Array['ms_fire']}%<br/>":"");
	$str.=(($item_Array['ms_water'])?"• Мф. мощности магии Воды: +{$item_Array['ms_water']}%<br/>":"");
	$str.=(($item_Array['ms_air'])?"• Мф. мощности магии Воздуха: +{$item_Array['ms_air']}%<br/>":"");
	$str.=(($item_Array['ms_earth'])?"• Мф. мощности магии Земли: +{$item_Array['ms_earth']}%<br/>":"");
	$str.=(($item_Array['ms_svet'])?"• Мф. мощности магии Света: +{$item_Array['ms_svet']}%<br/>":"");
	$str.=(($item_Array['ms_tma'])?"• Мф. мощности магии Тьмы: +{$item_Array['ms_tma']}%<br/>":"");
	$str.=(($item_Array['ms_gray'])?"• Мф. мощности Серой магии: +{$item_Array['ms_gray']}%<br/>":"");

	$str.=(($item_Array['add_rej']>0 || $item_Array['add_drob']>0 || $item_Array['add_kol']>0 || $item_Array['add_rub']>0 ||$item_Array['add_fire_att']>0 || $item_Array['add_air_att']>0 || $item_Array['add_watet_att']>0 || $item_Array['add_earth_att']>0)?"<b>Особенности атаки:</b><br/>":"");
	$str.=(($item_Array['add_rej'])?"• Мф. режущего урона: +{$item_Array['add_rej']}%<br/>":"");
	$str.=(($item_Array['add_drob'])?"• Мф. дробящего урона: +{$item_Array['add_drob']}%<br/>":"");
	$str.=(($item_Array['add_kol'])?"• Мф. колющего урона: +{$item_Array['add_kol']}%<br/>":"");
	$str.=(($item_Array['add_rub'])?"• Мф. рубящего урона: +{$item_Array['add_rub']}%<br/>":"");
	
	$str.=(($item_Array['add_fire_att'])?"• Мф. огненные атаки: +{$item_Array['add_fire_att']}%<br/>":"");
	$str.=(($item_Array['add_air_att'])?"• Мф. электрические атаки: +{$item_Array['add_air_att']}%<br/>":"");
	$str.=(($item_Array['add_watet_att'])?"• Мф. ледяные атаки: +{$item_Array['add_watet_att']}%<br/>":"");
	$str.=(($item_Array['add_earth_att'])?"• Мф. земляные атаки: +{$item_Array['add_earth_att']}%<br/>":"");
	
	$str.=(($item_Array['term'])?"<br/><b>Аренда:</b> до ".(date('d.m.y H:i:s', $item_Array['term'])):"");

	$str.=(($item_Array['bs'])?"<br/><font style='font-size:11px; color:#990000'>Турнирный доспех</font>":"");
	$str.=(($item_Array['podzemka'])?"<br/><font style='font-size:11px; color:#990000'>Предмет из подземелья</font>":"");
	$str.=(($item_Array['noremont'])?"<br/><font style='font-size:11px; color:#990000'>Предмет не подлежит ремонту</font>":"");
	$str.=(($item_Array["object"]=="spear" || $item_Array["object_type"]=="spear")?"<br/><font style='font-size:11px; color:#990000'>Зона Блокирования: ++ (При надевании на вторую руку)</font>":"");
	echo $str;
}
/*==============SLOT====================================*/
function slot($sl)
{
	switch ($sl)
	{
		case "amulet":	$slt="Амулеты";break;
		case "naruchi":	$slt="Наручи";break;
		case "hand_r":	$slt="Правая рука";break;
		case "armour":	$slt="Броня";break;
		case "rubaxa":	$slt="Рубахи";break;
		case "plash":	$slt="Плаш";break;
		case "poyas":	$slt="Пояса";break;
		case "helmet":	$slt="Шлемы";break;
		case "mask":	$slt="Маска";break;
		case "perchi":	$slt="Перчатки";break;
		case "ring1":	$slt="Первая Кольцо";break;
		case "ring2":	$slt="Второе Кольцо";break;
		case "ring3":	$slt="Третое Кольцо";break;
		case "pants":	$slt="Поножи";break;
		case "hand_l":	$slt="Левая рука";break;
		case "boots":	$slt="Сапоги";break;
	}
	return $slt;
}
/*=============ПОКАЗАТЬ================================*/
function showPlayer($myinfo)
{
	effects($myinfo["id"],$effect);
	$descr=array();
	$descr['amulet']="<font style='color:#696969'>Пустой слот амулет</font>";
	$descr['naruchi']="<font style='color:#696969'>Пустой слот наручи</font>";
	$descr['hand_r']="<font style='color:#696969'>Пустой слот правая рука</font>";
	$descr['armour']="<font style='color:#696969'>Пустой слот броня</font>";
	$descr['rubaxa']="<font style='color:#696969'>Пустой слот рубахи</font>";
	$descr['plash']="<font style='color:#696969'>Пустой слот плаш</font>";
	$descr['poyas']="<font style='color:#696969'>Пустой слот пояс</font>";
	$descr['helmet']="<font style='color:#696969'>Пустой слот шлем</font>";
	$descr['mask']="<font style='color:#696969'>Пустой слот маска</font>";
	$descr['perchi']="<font style='color:#696969'>Пустой слот перчатки</font>";
	$descr['ring1']="<font style='color:#696969'>Пустой слот кольцо</font>";
	$descr['ring2']="<font style='color:#696969'>Пустой слот кольцо</font>";
	$descr['ring3']="<font style='color:#696969'>Пустой слот кольцо</font>";
	$descr['pants']="<font style='color:#696969'>Пустой слот поножи</font>";
	$descr['hand_l']="<font style='color:#696969'>Пустой слот левая рука</font>";
	$descr['boots']="<font style='color:#696969'>Пустой слот обувь</font>";
	
	$myinfo['sila']=$myinfo['sila']+$effect["add_sila"];
	$myinfo['lovkost']=$myinfo['lovkost']+$effect["add_lovkost"];
	$myinfo['udacha']=$myinfo['udacha']+$effect["add_udacha"];

	$sql=mysql_query ("SELECT * FROM inv WHERE wear=1 and object_razdel='obj' and owner='".$myinfo["login"]."'");
	while($dat=mysql_fetch_array($sql))
	{
		if(($myinfo['sila']<$dat["min_sila"] || $myinfo['lovkost']<$dat["min_lovkost"] || $myinfo['udacha']<$dat["min_udacha"] || $myinfo['power']<$dat["min_vinoslivost"] || ($dat["sex"]!=0 && $myinfo['sex']!=$dat["wear_sex"])||($dat["need_orden"]!=0 && $myinfo['orden']!=$dat["need_orden"]))&& $dat["object_type"]!="kostyl")
		{
			unWear($myinfo['login'],$dat["id"]);
		}
		else
		{
			$desc="";
			if($dat["art"]==1){$desc.="<img src='http://www.meydan.az/img/artefakt.gif' border='0' /> ";}
			if($dat["art"]==2){$desc.="<img src='http://www.meydan.az/img/icon/artefakt.gif' border='0' /> ";}
			if($dat["podzemka"]){$desc.="<img src='http://www.meydan.az/img/icon/podzemka.gif' border='0' /> ";}
			if($dat["need_orden"]){$desc.="<img src='http://www.meydan.az/img/orden/".$dat["need_orden"]."/0.gif' border='0' /> ";}
			if($dat["is_runa"]){$desc.="<img src='http://www.meydan.az/img/icon/runa.gif' border=0 /> ";}
			$desc.="<font ".($dat["art"]==1?"style='color:#95486D;'":"").($dat["art"]==2?"style='color:#b22222;'":"").">".$dat["name"].($dat["is_modified"]?" +".$dat["is_modified"]:"")." (".$dat["iznos"]."/".$dat["iznos_max"].")</font> [<a href='item_desc.php?item_id=".$dat["id"]."'>info</a>]";
		}
		$descr[$dat["slot"]]=$desc;
	}
	echo 
	"<b>".slot("amulet")."</b>: ".$descr["amulet"]."<br/>".
	"<b>".slot("naruchi")."</b>: ".$descr["naruchi"]."<br/>".
	"<b>".slot("hand_r")."</b>: ".$descr["hand_r"]."<br/>".
	"<b>".slot("armour")."</b>: ".$descr["armour"]."<br/>".
	"<b>".slot("rubaxa")."</b>: ".$descr["rubaxa"]."<br/>".
	"<b>".slot("plash")."</b>: ".$descr["plash"]."<br/>".	
	"<b>".slot("poyas")."</b>: ".$descr["poyas"]."<br/>".
	"<b>".slot("helmet")."</b>: ".$descr["helmet"]."<br/>".
	"<b>".slot("mask")."</b>: ".$descr["mask"]."<br/>".	
	"<b>".slot("perchi")."</b>: ".$descr["perchi"]."<br/>".
	"<b>".slot("ring1")."</b>: ".$descr["ring1"]."<br/>".
	"<b>".slot("ring2")."</b>: ".$descr["ring2"]."<br/>".
	"<b>".slot("ring3")."</b>: ".$descr["ring3"]."<br/>".
	"<b>".slot("pants")."</b>: ".$descr["pants"]."<br/>".
	"<b>".slot("hand_l")."</b>: ".$descr["hand_l"]."<br/>".
	"<b>".slot("boots")."</b>: ".$descr["boots"]."<br/>";

	mysql_free_result($sql);
}
/*=============ПОКАЗАТЬ В ИНВЕНТАРЕ====================*/
function showPlayer_inv($myinfo)
{
	effects($myinfo["id"],$effect);
	$descr=array();
	$descr['amulet']="<font style='color:#696969'>Пустой слот амулет</font>";
	$descr['naruchi']="<font style='color:#696969'>Пустой слот наручи</font>";
	$descr['hand_r']="<font style='color:#696969'>Пустой слот правая рука</font>";
	$descr['armour']="<font style='color:#696969'>Пустой слот броня</font>";
	$descr['rubaxa']="<font style='color:#696969'>Пустой слот рубахи</font>";
	$descr['plash']="<font style='color:#696969'>Пустой слот плаш</font>";
	$descr['poyas']="<font style='color:#696969'>Пустой слот пояс</font>";
	$descr['helmet']="<font style='color:#696969'>Пустой слот шлем</font>";
	$descr['mask']="<font style='color:#696969'>Пустой слот маска</font>";
	$descr['perchi']="<font style='color:#696969'>Пустой слот перчатки</font>";
	$descr['ring1']="<font style='color:#696969'>Пустой слот кольцо</font>";
	$descr['ring2']="<font style='color:#696969'>Пустой слот кольцо</font>";
	$descr['ring3']="<font style='color:#696969'>Пустой слот кольцо</font>";
	$descr['pants']="<font style='color:#696969'>Пустой слот поножи</font>";
	$descr['hand_l']="<font style='color:#696969'>Пустой слот левая рука</font>";
	$descr['boots']="<font style='color:#696969'>Пустой слот обувь</font>";
	
	$myinfo['sila']=$myinfo['sila']+$effect["add_sila"];
	$myinfo['lovkost']=$myinfo['lovkost']+$effect["add_lovkost"];
	$myinfo['udacha']=$myinfo['udacha']+$effect["add_udacha"];

	$sql=mysql_query ("SELECT * FROM inv WHERE wear=1 and object_razdel='obj' and owner='".$myinfo["login"]."'");
	while($dat=mysql_fetch_array($sql))
	{
		if(($myinfo['sila']<$dat["min_sila"] || $myinfo['lovkost']<$dat["min_lovkost"] || $myinfo['udacha']<$dat["min_udacha"] || $myinfo['power']<$dat["min_vinoslivost"] || ($dat["sex"]!=0 && $myinfo['sex']!=$dat["wear_sex"])||($dat["need_orden"]!=0 && $myinfo['orden']!=$dat["need_orden"]))&& $dat["object_type"]!="kostyl")
		{
			unWear($myinfo['login'],$dat["id"]);
		}
		else
		{
			$desc="";
			if($dat["art"]==1){$desc.="<img src='http://www.meydan.az/img/artefakt.gif' border='0' /> ";}
			if($dat["art"]==2){$desc.="<img src='http://www.meydan.az/img/icon/artefakt.gif' border='0' /> ";}
			if($dat["podzemka"]){$desc.="<img src='http://www.meydan.az/img/icon/podzemka.gif' border='0' /> ";}
			if($dat["need_orden"]){$desc.="<img src='http://www.meydan.az/img/orden/".$dat["need_orden"]."/0.gif' border='0' /> ";}
			if($dat["is_runa"]){$desc.="<img src='http://www.meydan.az/img/icon/runa.gif' border=0 /> ";}
			$desc.="<font ".($dat["art"]==1?"style='color:#95486D;'":"").($dat["art"]==2?"style='color:#b22222;'":"").">".$dat["name"].($dat["is_modified"]?" +".$dat["is_modified"]:"")." (".$dat["iznos"]."/".$dat["iznos_max"].")</font>";
		}
		$descr[$dat["slot"]]=$desc;
	}
	echo 
	"<b>".slot("amulet")."</b>: ".$descr["amulet"].($myinfo['amulet']?"<a href='?unwear=".$myinfo['amulet']."'>[снять]</a> <a href='?info=".$myinfo['amulet']."'>[info]</a>":"")."<br/>".
	"<b>".slot("naruchi")."</b>: ".$descr["naruchi"].($myinfo['naruchi']?"<a href='?unwear=".$myinfo['naruchi']."'>[снять]</a> <a href='?info=".$myinfo['naruchi']."'>[info]</a>":"")."<br/>".
	"<b>".slot("hand_r")."</b>: ".$descr["hand_r"].($myinfo['hand_r']?"<a href='?unwear=".$myinfo['hand_r']."'>[снять]</a> <a href='?info=".$myinfo['hand_r']."'>[info]</a>":"")."<br/>".
	"<b>".slot("armour")."</b>: ".$descr["armour"].($myinfo['armour']?"<a href='?unwear=".$myinfo['armour']."'>[снять]</a> <a href='?info=".$myinfo['armour']."'>[info]</a>":"")."<br/>".
	"<b>".slot("rubaxa")."</b>: ".$descr["rubaxa"].($myinfo['rubaxa']?"<a href='?unwear=".$myinfo['rubaxa']."'>[снять]</a> <a href='?info=".$myinfo['rubaxa']."'>[info]</a>":"")."<br/>".
	"<b>".slot("plash")."</b>: ".$descr["plash"].($myinfo['plash']?"<a href='?unwear=".$myinfo['plash']."'>[снять]</a> <a href='?info=".$myinfo['plash']."'>[info]</a>":"")."<br/>".	
	"<b>".slot("poyas")."</b>: ".$descr["poyas"].($myinfo['poyas']?"<a href='?unwear=".$myinfo['poyas']."'>[снять]</a> <a href='?info=".$myinfo['poyas']."'>[info]</a>":"")."<br/>".
	"<b>".slot("helmet")."</b>: ".$descr["helmet"].($myinfo['helmet']?"<a href='?unwear=".$myinfo['helmet']."'>[снять]</a> <a href='?info=".$myinfo['helmet']."'>[info]</a>":"")."<br/>".
	"<b>".slot("mask")."</b>: ".$descr["mask"].($myinfo['mask']?"<a href='?unwear=".$myinfo['mask']."'>[снять]</a> <a href='?info=".$myinfo['mask']."'>[info]</a>":"")."<br/>".	
	"<b>".slot("perchi")."</b>: ".$descr["perchi"].($myinfo['perchi']?"<a href='?unwear=".$myinfo['perchi']."'>[снять]</a> <a href='?info=".$myinfo['perchi']."'>[info]</a>":"")."<br/>".
	"<b>".slot("ring1")."</b>: ".$descr["ring1"].($myinfo['ring1']?"<a href='?unwear=".$myinfo['ring1']."'>[снять]</a> <a href='?info=".$myinfo['ring1']."'>[info]</a>":"")."<br/>".
	"<b>".slot("ring2")."</b>: ".$descr["ring2"].($myinfo['ring2']?"<a href='?unwear=".$myinfo['ring2']."'>[снять]</a> <a href='?info=".$myinfo['ring2']."'>[info]</a>":"")."<br/>".
	"<b>".slot("ring3")."</b>: ".$descr["ring3"].($myinfo['ring3']?"<a href='?unwear=".$myinfo['ring3']."'>[снять]</a> <a href='?info=".$myinfo['ring3']."'>[info]</a>":"")."<br/>".
	"<b>".slot("pants")."</b>: ".$descr["pants"].($myinfo['pants']?"<a href='?unwear=".$myinfo['pants']."'>[снять]</a> <a href='?info=".$myinfo['pants']."'>[info]</a>":"")."<br/>".
	"<b>".slot("hand_l")."</b>: ".$descr["hand_l"].($myinfo['hand_l']?"<a href='?unwear=".$myinfo['hand_l']."'>[снять]</a> <a href='?info=".$myinfo['hand_l']."'>[info]</a>":"")."<br/>".
	"<b>".slot("boots")."</b>: ".$descr["boots"].($myinfo['boots']?"<a href='?unwear=".$myinfo['boots']."'>[снять]</a> <a href='?info=".$myinfo['boots']."'>[info]</a>":"")."<br/>";

	mysql_free_result($sql);
}
//-------------------------------------------------
function effects($user_id,&$effect)
{
	$effect=mysql_fetch_array(mysql_query("SELECT 
	SUM(add_sila) as add_sila, SUM(add_lovkost) as add_lovkost, SUM(add_udacha) as add_udacha, SUM(add_intellekt) as add_intellekt,
	SUM(add_krit) as add_krit, SUM(add_akrit) as add_akrit, SUM(add_uvorot) as add_uvorot, SUM(add_auvorot) as add_auvorot,
	SUM(add_bron) as add_bron, SUM(add_mg_bron) as add_mg_bron, SUM(add_ms_boyech) as add_ms_boyech, SUM(add_ms_mag) as add_ms_mag, 
	SUM(add_sword_vl) as add_sword_vl, SUM(add_staff_vl) as add_staff_vl, SUM(add_axe_vl) as add_axe_vl, SUM(add_hummer_vl) as add_hummer_vl, SUM(add_castet_vl) as add_castet_vl, SUM(add_copie_vl) as add_copie_vl, 
	SUM(protect_fire) as protect_fire, SUM(protect_earth) as protect_earth, SUM(protect_water) as protect_water, SUM(protect_air) as protect_air,
	SUM(p_kol) as p_kol, SUM(p_rub) as p_rub, SUM(p_drob) as p_drob, SUM(p_rej) as p_rej,
	SUM(min_udar) as min_udar, SUM(max_udar) as max_udar
	FROM effects WHERE user_id='".$user_id."'"));
}
//-------------------------------------------------
function is_wear($who)
{
	$is_w=mysql_fetch_Array(mysql_query("SELECT count(*) FROM inv WHERE `owner`='".$who."' and `object_razdel` = 'obj' and `wear`=1"));
	return $is_w[0];
}
//-------------------------------------------------
function drop($spell,$spell_info)
{
	mysql_query("UPDATE inv SET iznos=iznos+1 WHERE id = '".$spell."'");
	$INV_SQL = mysql_query("SELECT iznos,iznos_max FROM `inv` WHERE id = '".$spell."'");
	$INV     = mysql_fetch_array($INV_SQL);
	if($INV["iznos"]==$INV["iznos_max"])
	{
		mysql_query("DELETE FROM `inv` WHERE id = '".$spell."'");
		$_SESSION["message"].="<br/>Свиток &laquo;".$spell_info["name"]."&raquo; полностью использован.";
	}
}
//-----------------Tip Boycha----------------------
function voin_type($myinfo)
{
	effects($myinfo["id"],$effect);
	$myinfo["sila"]=$myinfo["sila"]+$effect["add_sila"];
	$myinfo["lovkost"]=$myinfo["lovkost"]+$effect["add_lovkost"];
	$myinfo["udacha"]=$myinfo["udacha"]+$effect["add_udacha"];
	$myinfo["intellekt"]=$myinfo["intellekt"]+$effect["add_intellekt"];
	
	if ($myinfo["sila"]>$myinfo["lovkost"] && $myinfo["sila"]>$myinfo["udacha"] && $myinfo["sila"]>$myinfo["intellekt"])$str="silach";
	else if ($myinfo["udacha"]>$myinfo["lovkost"] && $myinfo["udacha"]>$myinfo["intellekt"])$str="krit";
	else if ($myinfo["lovkost"]>$myinfo["udacha"] && $myinfo["lovkost"]>$myinfo["intellekt"])$str="uvarot";
	else if ($myinfo["intellekt"]>$myinfo["lovkost"] && $myinfo["intellekt"]>$myinfo["udacha"])$str="mag";
	else $str="antikrit";
	return $str;
}
/*===================startTrain=================================*/
function startTrain($who)
{
    $ip=$who['remote_ip'];
    $prototype = $who['login'];
    $mine_id=$who['id'];
    $me=$who['login'];
	$name ="Тень";
	mysql_query("INSERT INTO zayavka(status,type,timeout,creator) VALUES('3','1','3','".$mine_id."')");
	mysql_query("INSERT INTO teams(player,team,ip,battle_id,hitted,over) VALUES('".$me."','1','".$ip."','".$mine_id."','0','0')");
	addBot($me,$mine_id,$prototype,$name);
	goBattle($me);
}
/*========================ADDBOT=======================================*/
function addBot($who,$buid,$bot,$bot_name)
{
	$GBD = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE login='".$bot."'"));

	$weapons = array('axe','fail','knife','sword','spear','shot','staff','kostyl');
	$shields = array('shield');
	$bot_two_hands    = false;
	$bot_shield_hands = false;
    if (in_array($GBD["hand_r_type"],$weapons) && in_array($GBD["hand_l_type"],$weapons)){$bot_two_hands = true;}
    if (in_array($GBD["hand_l_type"],$shields)){$bot_shield_hands = true;}
	if ($bot=="Исчадие Хаоса"){$bot_two_hands = true; $GBD["hp_all"]=300000;}

	$timeout = time()+3*60;
    $z_res=mysql_fetch_Array(mysql_query("SELECT type FROM zayavka WHERE creator=".$buid));
	mysql_query("INSERT INTO battles(type, creator_id, lasthit) VALUES('".$z_res["type"]."', '".$buid."', '".$timeout."')");
	$b_id=mysql_insert_id();
	mysql_query("INSERT INTO bot_temp(bot_name,hp,hp_all,battle_id,prototype,team,two_hands,shield_hands) VALUES('".$bot_name."','".$GBD["hp_all"]."','".$GBD["hp_all"]."','".$b_id."','".$bot."','2','".$bot_two_hands."','".$bot_shield_hands."')");
}
/*===================запись в историю============================*/
function history($who,$act,$val,$ip,$to)
{
	$dates=date("Y-m-d H:i:s");
	mysql_query("LOCK TABLES perevod WRITE");
	mysql_query("INSERT INTO perevod(date, login, action, item, ip, login2) VALUES('".$dates."','".$who."','".$act."','".$val."','".$ip."','".$to."')");
	mysql_query("UNLOCK TABLES");
}
/*==============установить хп====================================*/
function setHP($who,$val,$all)
{
	$query=mysql_query("SELECT cure,cure_time FROM `users` WHERE login='".$who."'");
	$data=mysql_fetch_array($query);
	$cure_full = $data["cure_time"]-$data["cure"];
	$one=$cure_full/$all;
	$time=$cure_full-$one*$val;
	$put_to_base=time()+$time;
   	$add_cure = 0.001;
   	if ($data["cure"]>=100)$add_cure = 0;
	mysql_query("UPDATE `users` SET cure_hp='".$put_to_base."',hp='".$val."',cure=cure+$add_cure WHERE login='".$who."'");
}
/*==============установить ману====================================*/
function setMN($who,$val,$all)
{
	$one=1200/$all;
	$time=1200-$one*$val;
	$put_to_base=time()+$time;
	mysql_query("UPDATE users SET cure_mn='".$put_to_base."',mana='".$val."' WHERE login='".$who."'");
}

/*======================С Н Я Т Ь================================*/
function unWear($who,$itm)
{
	$db=mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE login='".$who."'"));	
	$item_data=mysql_fetch_array(mysql_query("SELECT * FROM inv WHERE owner='".$who."' and id='".$itm."' and object_razdel='obj' and inv.wear=1"));
	
	if ($item_data)
	{
		$i_type=$item_data["object_type"];
		$id_inv=$item_data["id"];
		if($i_type=="sword" || $i_type=="axe" || $i_type=="fail" || $i_type=="knife" || $i_type=="spear" || $i_type=="shield" || $i_type=="amunition" || $i_type=="staff" || $i_type=="kostyl")
		{
			if($db["hand_r"] == $itm){$slot = "hand_r";}
	        if($db["hand_l"] == $itm){$slot = "hand_l";}
	    }
		else if($i_type=="ring")
		{
			if($db["ring1"]==$itm)
			{
				$slot="ring1";
			}
			else if($db["ring2"]==$itm)
			{
				$slot="ring2";
			}
			else if($db["ring3"]==$itm)
			{
				$slot="ring3";
			}
		}
		else
		{
	        $slot=$i_type;
		}	
		$slot_v=$db[$slot];	

		$new_sila=$db["sila"]-$item_data["add_sila"];
		$new_lovkost=$db["lovkost"]-$item_data["add_lovkost"];
		$new_udacha=$db["udacha"]-$item_data["add_udacha"];
		$new_intellekt=$db["intellekt"]-$item_data["add_intellekt"];
		$new_duxovnost=$db["duxovnost"]-$item_data["add_duxovnost"];
		
		$new_phead=$db["bron_head"]-$item_data["protect_head"];
		$new_parm=$db["bron_arm"]-$item_data["protect_arm"];
		$new_pcorp=$db["bron_corp"]-$item_data["protect_corp"];
		$new_ppoyas=$db["bron_poyas"]-$item_data["protect_poyas"];
		$new_plegs=$db["bron_legs"]-$item_data["protect_legs"];
		
		$new_mfkrit=$db["krit"]-$item_data["krit"];
		$new_mfantikrit=$db["akrit"]-$item_data["akrit"];
		$new_mfuvorot=$db["uvorot"]-$item_data["uvorot"];
		$new_mfantiuvorot=$db["auvorot"]-$item_data["auvorot"];

		$new_wpmin_h=$item_data["min_attack"];
		$new_wpmax_h=$item_data["max_attack"];
		
		if($slot=="hand_l")
		{
			$new_wpmin=$db["hand_l_hitmin"]-$item_data["min_attack"];
			$new_wpmax=$db["hand_l_hitmax"]-$item_data["max_attack"];
		}
		else if($slot=="hand_r")
		{
			$new_wpmin=$db["hand_r_hitmin"]-$item_data["min_attack"];
			$new_wpmax=$db["hand_r_hitmax"]-$item_data["max_attack"];
		}
		
		$new_swordvl=$db["sword_vl"]-$item_data["add_sword_vl"];
		$new_axevl=$db["axe_vl"]-$item_data["add_axe_vl"];
		$new_failvl=$db["hummer_vl"]-$item_data["add_fail_vl"];
		$new_knifevl=$db["castet_vl"]-$item_data["add_knife_vl"];
		$new_spearvl=$db["copie_vl"]-$item_data["add_spear_vl"];
		$new_staffvl=$db["staff_vl"]-$item_data["add_staff_vl"];
			
		$new_fire=$db["fire_magic"]-$item_data["add_fire"];
		$new_water=$db["water_magic"]-$item_data["add_water"];
		$new_air=$db["air_magic"]-$item_data["add_air"];
		$new_earth=$db["earth_magic"]-$item_data["add_earth"];
		$new_svet=$db["svet_magic"]-$item_data["add_svet"];
		$new_tma=$db["tma_magic"]-$item_data["add_tma"];
		$new_gray=$db["gray_magic"]-$item_data["add_gray"];

		$protect_rej=$db["protect_rej"]-$item_data["protect_rej"];
		$protect_drob=$db["protect_drob"]-$item_data["protect_drob"];
		$protect_kol=$db["protect_kol"]-$item_data["protect_kol"];
		$protect_rub=$db["protect_rub"]-$item_data["protect_rub"];

		$protect_fire=$db["protect_fire"]-$item_data["protect_fire"];
		$protect_water=$db["protect_water"]-$item_data["protect_water"];
		$protect_air=$db["protect_air"]-$item_data["protect_air"];
		$protect_earth=$db["protect_earth"]-$item_data["protect_earth"];
		$protect_svet=$db["protect_svet"]-$item_data["protect_svet"];
		$protect_tma=$db["protect_tma"]-$item_data["protect_tma"];
		$protect_gray=$db["protect_gray"]-$item_data["protect_gray"];

		$protect_mag=$db["protect_mag"]-$item_data["protect_mag"];
		$protect_udar=$db["protect_udar"]-$item_data["protect_udar"];

		$shieldblock=$db["shieldblock"]-$item_data["shieldblock"];

		$parry=$db["parry"]-$item_data["parry"];
		$counter=$db["counter"]-$item_data["counter"];

		$add_rej=$db["add_rej"]-$item_data["add_rej"];
		$add_drob=$db["add_drob"]-$item_data["add_drob"];
		$add_kol=$db["add_kol"]-$item_data["add_kol"];
		$add_rub=$db["add_rub"]-$item_data["add_rub"];

		$add_fire_att=$db["add_fire_att"]-$item_data["add_fire_att"];
		$add_air_att=$db["add_air_att"]-$item_data["add_air_att"];
		$add_watet_att=$db["add_watet_att"]-$item_data["add_watet_att"];
		$add_earth_att=$db["add_earth_att"]-$item_data["add_earth_att"];

		$ms_udar=$db["ms_udar"]-$item_data["ms_udar"];
		$ms_krit=$db["ms_krit"]-$item_data["ms_krit"];
		$ms_mag=$db["ms_mag"]-$item_data["ms_mag"];

		$ms_fire=$db["ms_fire"]-$item_data["ms_fire"]-$item_data["ms_mag"];
		$ms_water=$db["ms_water"]-$item_data["ms_water"]-$item_data["ms_mag"];
		$ms_air=$db["ms_air"]-$item_data["ms_air"]-$item_data["ms_mag"];
		$ms_earth=$db["ms_earth"]-$item_data["ms_earth"]-$item_data["ms_mag"];
		$ms_svet=$db["ms_svet"]-$item_data["ms_svet"]-$item_data["ms_mag"];
		$ms_tma=$db["ms_tma"]-$item_data["ms_tma"]-$item_data["ms_mag"];
		$ms_gray=$db["ms_gray"]-$item_data["ms_gray"]-$item_data["ms_mag"];

		$new_cost=($item_data["art"]>0?$item_data["gos_price"]*20:$item_data["gos_price"]);

		$ms_rej=$db["ms_rej"]-$item_data["ms_rej"];
		$ms_drob=$db["ms_drob"]-$item_data["ms_drob"];
		$ms_kol=$db["ms_kol"]-$item_data["ms_kol"];
		$ms_rub=$db["ms_rub"]-$item_data["ms_rub"];

		$proboy=$db["proboy"]-$item_data["proboy"];
		$add_oruj=$db["add_oruj"]-$item_data["add_oruj"];

		$new_cure=$db["cure"];
		
		$new_hp=$db["hp_all"]-$item_data["add_hp"]-$item_data["add_xp"];
		$new_mana=$db["mana_all"]-$item_data["add_mana"];
		
		$hp=$db["hp"];
		$mn=$db["mana"];
		if($new_hp>=$hp){$hp2=$hp;}else{$r=$hp-$new_hp; $hp2=$hp-$r;}
		if($new_mana>=$mn){$mn2=$mn;}else{$k=$mn-$new_mana; $mn2=$mn-$k;}
		setHP($who,$hp2,$new_hp);
		setMN($who,$mn2,$new_mana);

		$new_sql ="UPDATE `users` SET sila='".$new_sila."', lovkost='".$new_lovkost."', udacha='".$new_udacha."', duxovnost='$new_duxovnost', hp_all='".$new_hp."',";
		$new_sql.="intellekt='".$new_intellekt."', mana_all='".$new_mana."',bron_head='".$new_phead."',bron_corp='".$new_pcorp."',";
		$new_sql.="bron_legs='".$new_plegs."', bron_arm='".$new_parm."',bron_poyas='".$new_ppoyas."',";
		$new_sql.="$slot='0',sword_vl='".$new_swordvl."',axe_vl='".$new_axevl."',hummer_vl='".$new_failvl."',";
		$new_sql.="castet_vl='".$new_knifevl."',copie_vl='".$new_spearvl."',staff_vl='".$new_staffvl."',";

		if($slot == "hand_r")
		{
			$new_sql.="hand_r_type='phisic',hand_r_free='1',hand_r_hitmin='0',hand_r_hitmax='0',";
		}
		else if($slot == "hand_l")
		{
			$new_sql.="hand_l_type='phisic',hand_l_free='1',hand_l_hitmin='0',hand_l_hitmax='0',";
		}
		$new_sql.="protect_rej='$protect_rej', protect_drob='$protect_drob', protect_kol='$protect_kol', protect_rub='$protect_rub', ";
		$new_sql.="protect_fire='$protect_fire', protect_water='$protect_water', protect_air='$protect_air', protect_earth='$protect_earth', protect_svet='$protect_svet', protect_tma='$protect_tma', protect_gray='$protect_gray', ";
		$new_sql.="protect_mag='$protect_mag', protect_udar='$protect_udar', shieldblock='$shieldblock', ";
		$new_sql.="parry='$parry', counter='$counter', ";
		//$new_sql.="add_rej='$add_rej', add_drob='$add_drob', add_kol='$add_kol', add_rub='$add_rub', ";
		//$new_sql.="add_fire_att='$add_fire_att', add_air_att='$add_air_att', add_watet_att='$add_watet_att', add_earth_att='$add_earth_att', ";
		$new_sql.="ms_udar='$ms_udar', ms_krit='$ms_krit', ms_mag='$ms_mag', ";
		$new_sql.="ms_fire='$ms_fire', ms_water='$ms_water', ms_air='$ms_air', ms_earth='$ms_earth', ms_svet='$ms_svet', ms_tma='$ms_tma', ms_gray='$ms_gray', ";
		$new_sql.="ms_rej='$ms_rej', ms_drob='$ms_drob', ms_kol='$ms_kol', ms_rub='$ms_rub', ";
		$new_sql.="proboy='$proboy', add_oruj='$add_oruj', ";

		$new_sql.="krit='$new_mfkrit',akrit='$new_mfantikrit',uvorot='$new_mfuvorot',auvorot='$new_mfantiuvorot',";
		$new_sql.="fire_magic='$new_fire',water_magic='$new_water',";
		$new_sql.="air_magic='$new_air',earth_magic='$new_earth',cure='$new_cure',";
		$new_sql.="svet_magic='$new_svet',tma_magic='$new_tma',gray_magic='$new_gray',";
		$new_sql.=($item_data["two_hand"]?"two_hand=0,":"");
		$new_sql.="cost=cost-$new_cost";
		$new_sql.=" WHERE login='".$who."'";
		mysql_query($new_sql);	
		mysql_query("UPDATE inv SET wear='0',slot='' WHERE id='".$id_inv."'");
	}
	Header("Location: inv.php?otdel=obj&tmp=".md5(time()));
}
/*===========================О Д Е Т Ь=========================*/
function wear($who,$itm)
{
	$db = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE login='".$who."'"));
	effects($db["id"],$effect);
	$item_data = mysql_fetch_array(mysql_query("SELECT * FROM inv WHERE owner='".$who."' and id='".$itm."' and object_razdel='obj' and wear=0"));
	if ($item_data)
	{
		$i_type = $item_data["object"];/*тип предмета*/
		$wearable = 0;
	    if(	($db["sila"]+$effect["add_sila"])>=$item_data["min_sila"] && 
	       	($db["lovkost"]+$effect["add_lovkost"])>=$item_data["min_lovkost"] && 
	       	($db["udacha"]+$effect["add_udacha"])>=$item_data["min_udacha"] && 
	    	($db["power"]>=$item_data["min_power"]) &&
	    	($db["intellekt"]+$effect["add_intellekt"])>=$item_data["min_intellekt"] && 
	    	($db["vospriyatie"]>=$item_data["min_vospriyatie"]) && 
	    	($db["level"]>=$item_data["min_level"]) &&
	    	($db["sword_vl"]+$effect["add_sword_vl"])>=$item_data["min_sword_vl"] && 
	    	($db["staff_vl"]+$effect["add_staff_vl"])>=$item_data["min_staff_vl"] &&
	    	($db["axe_vl"]+$effect["add_axe_vl"])>=$item_data["min_axe_vl"] &&
	    	($db["hummer_vl"]+$effect["add_hummer_vl"])>=$item_data["min_fail_vl"] &&
	    	($db["castet_vl"]+$effect["add_castet_vl"])>=$item_data["min_knife_vl"] &&
	    	($db["copie_vl"]+$effect["add_copie_vl"])>=$item_data["min_spear_vl"] &&
	    	($db["water_magic"]+$effect["add_water_magic"])>=$item_data["min_water"] && 
	    	($db["earth_magic"]+$effect["add_earth_magic"])>=$item_data["min_earth"] && 
	    	($db["fire_magic"]+$effect["add_fire_magic"])>=$item_data["min_fire"] &&
	    	($db["air_magic"]+$effect["add_air_magic"])>=$item_data["min_air"]
	    ){$wearable=1;}
	    if ($item_data["object_type"] == "kostyl")$wearable=1;
		if ($item_data["iznos"]>=$item_data["iznos_max"])$wearable=0;
		if ($db['bs']==0 && $item_data["bs"]==1)$wearable=0;
		if ($db['bs']==1 && $item_data["bs"]==0)$wearable=0;
		
		if($item_data["second_hand"]==1)
		{
			if($db["two_hand"] == 1)
			{
				unWear($who,$db["hand_r"]);
	            wear($who,$itm);
	            die();
			}
	        else if($db["hand_r_free"] == 1){$slot = "hand_r";}
	        else if($db["hand_r_free"] == 0 && $db["hand_l_free"] == 1){$slot = "hand_l";}
	        else if($db["hand_r_free"] == 0 && $db["hand_l_free"] == 0)
	        {
	            unWear($who,$db["hand_r"]);
	            wear($who,$itm);
	            die();
	        }
	    	$w_type = $item_data["object_type"];/*тип оружия*/
		}
		else if($item_data["two_hand"] == 1)
		{
			if($db["hand_r_free"] == 1 && $db["hand_l_free"] == 1){$slot = "hand_r";}
			else if($db["hand_r_free"] == 1 && $db["hand_l_free"] == 0)
			{
				unWear($who,$db["hand_l"]);
				wear($who,$itm);
				die();
			}
			else if($db["hand_r_free"] == 0 && $db["hand_l_free"] == 1)
			{
				unWear($who,$db["hand_r"]);
				wear($who,$itm);
				die();
			}
			else if($db["hand_r_free"] == 0 && $db["hand_l_free"] == 0)
			{
				unWear($who,$db["hand_r"]);
				unWear($who,$db["hand_l"]);
				wear($who,$itm);
				die();
			}
	    	$w_type = $item_data["object_type"];/*тип оружия*/
		}
		else if($item_data["object_type"] == "sword" || $item_data["object_type"] == "axe" || $item_data["object_type"] == "fail" || $item_data["object_type"] == "spear" || $item_data["object_type"] == "knife" || $item_data["object_type"] == "kostyl")
		{
			if($item_data["second_hand"]==0)
			{
				if($db["two_hand"] == 1)
				{
					unWear($who,$db["hand_r"]);
		            wear($who,$itm);
		            die();
				}
				else if($db["hand_r_free"] == 0)
				{
					unWear($who,$db["hand_r"]);
					wear($who,$itm);
					die();
				}
				else {$slot = "hand_r";}
			}
			$w_type = $item_data["object_type"];/*тип оружия*/
		}		
	    else if($item_data["object_type"] == "shield" || $item_data["object_type"] == "amunition")
	    {
			if($db["two_hand"] == 1)
			{
				unWear($who,$db["hand_r"]);
	            wear($who,$itm);
	            die();
			}
			else if($db["hand_l_free"] == 1){$slot = "hand_l";}
			else if($db["hand_l_free"] == 0 )
			{
		   		unWear($who,$db["hand_l"]);
		    	wear($who,$itm);
		    	die();
			}
	    	$w_type = $item_data["object_type"];/*тип оружия*/
	    }
	    else if($item_data["object_type"] == "ring")
	    {
			if(!$db["ring1"]){$slot = "ring1";}
			else if(!$db["ring2"]){$slot="ring2";}
			else if(!$db["ring3"]){$slot = "ring3";}
			else
			{
	            unWear($who,$db["ring1"]);
	            wear($who,$itm);
	            die();
			}
			$wear_type="paltar";
	    }
	    else
	    {
	    	if ($db[$item_data["object_type"]] != 0)
	     	{
	         	unWear($who,$db[$item_data["object_type"]]);
	         	wear($who,$itm);
	         	die();
	     	}
	     	$slot = $item_data["object_type"];/*тип оружия*/
	     	$wear_type="paltar";
		}

		if($item_data["need_orden"]!=0 && $db["orden"]!=$item_data["need_orden"])
		{
			$_SESSION["message"]="Ваша склонность не позволяет одеть эту вещь.";
		}
		else if($item_data["sex"]!="" && $db["sex"]!=$item_data["sex"])
		{
			$_SESSION["message"]="Ваша пол не позволяет одеть эту вещь.";
		}
		else if($wearable == 1)
		{
			$new_sila=$db["sila"]+$item_data["add_sila"];
			$new_lovkost=$db["lovkost"]+$item_data["add_lovkost"];
			$new_udacha=$db["udacha"]+$item_data["add_udacha"];
			$new_intellekt=$db["intellekt"]+$item_data["add_intellekt"];
			$new_duxovnost=$db["duxovnost"]+$item_data["add_duxovnost"];
			
			$new_phead=$db["bron_head"]+$item_data["protect_head"];
			$new_parm=$db["bron_arm"]+$item_data["protect_arm"];
			$new_pcorp=$db["bron_corp"]+$item_data["protect_corp"];
			$new_ppoyas=$db["bron_poyas"]+$item_data["protect_poyas"];
			$new_plegs=$db["bron_legs"]+$item_data["protect_legs"];
			
			$new_mfkrit=$db["krit"]+$item_data["krit"];
			$new_mfantikrit=$db["akrit"]+$item_data["akrit"];
			$new_mfuvorot=$db["uvorot"]+$item_data["uvorot"];
			$new_mfantiuvorot=$db["auvorot"]+$item_data["auvorot"];
			
			$new_wpmin_h=$item_data["min_attack"];
			$new_wpmax_h=$item_data["max_attack"];
			if($slot=="hand_l")
			{
				$new_wpmin=$db["hand_l_hitmin"]+$item_data["min_attack"];
				$new_wpmax=$db["hand_l_hitmax"]+$item_data["max_attack"];
			}
			else if($slot=="hand_r")
			{
				$new_wpmin=$db["hand_r_hitmin"]+$item_data["min_attack"];
				$new_wpmax=$db["hand_r_hitmax"]+$item_data["max_attack"];
			}

			$new_swordvl=$db["sword_vl"]+$item_data["add_sword_vl"];
			$new_axevl=$db["axe_vl"]+$item_data["add_axe_vl"];
			$new_failvl=$db["hummer_vl"]+$item_data["add_fail_vl"];
			$new_knifevl=$db["castet_vl"]+$item_data["add_knife_vl"];
			$new_spearvl=$db["copie_vl"]+$item_data["add_spear_vl"];
			$new_staffvl=$db["staff_vl"]+$item_data["add_staff_vl"];
			
			$new_fire=$db["fire_magic"]+$item_data["add_fire"];
			$new_water=$db["water_magic"]+$item_data["add_water"];
			$new_air=$db["air_magic"]+$item_data["add_air"];
			$new_earth=$db["earth_magic"]+$item_data["add_earth"];
			$new_svet=$db["svet_magic"]+$item_data["add_svet"];
			$new_tma=$db["tma_magic"]+$item_data["add_tma"];
			$new_gray=$db["gray_magic"]+$item_data["add_gray"];

			
			$protect_rej=$db["protect_rej"]+$item_data["protect_rej"];
			$protect_drob=$db["protect_drob"]+$item_data["protect_drob"];
			$protect_kol=$db["protect_kol"]+$item_data["protect_kol"];
			$protect_rub=$db["protect_rub"]+$item_data["protect_rub"];

			$protect_fire=$db["protect_fire"]+$item_data["protect_fire"];
			$protect_water=$db["protect_water"]+$item_data["protect_water"];
			$protect_air=$db["protect_air"]+$item_data["protect_air"];
			$protect_earth=$db["protect_earth"]+$item_data["protect_earth"];
			$protect_svet=$db["protect_svet"]+$item_data["protect_svet"];
			$protect_tma=$db["protect_tma"]+$item_data["protect_tma"];
			$protect_gray=$db["protect_gray"]+$item_data["protect_gray"];

			$protect_mag=$db["protect_mag"]+$item_data["protect_mag"];
			$protect_udar=$db["protect_udar"]+$item_data["protect_udar"];

			$shieldblock=$db["shieldblock"]+$item_data["shieldblock"];
			
			$parry=$db["parry"]+$item_data["parry"];
			$counter=$db["counter"]+$item_data["counter"];

			$add_rej=$db["add_rej"]+$item_data["add_rej"];
			$add_drob=$db["add_drob"]+$item_data["add_drob"];
			$add_kol=$db["add_kol"]+$item_data["add_kol"];
			$add_rub=$db["add_rub"]+$item_data["add_rub"];

			$add_fire_att=$db["add_fire_att"]+$item_data["add_fire_att"];
			$add_air_att=$db["add_air_att"]+$item_data["add_air_att"];
			$add_watet_att=$db["add_watet_att"]+$item_data["add_watet_att"];
			$add_earth_att=$db["add_earth_att"]+$item_data["add_earth_att"];

			$ms_udar=$db["ms_udar"]+$item_data["ms_udar"];
			$ms_krit=$db["ms_krit"]+$item_data["ms_krit"];
			$ms_mag=$db["ms_mag"]+$item_data["ms_mag"];

			$ms_fire=$db["ms_fire"]+$item_data["ms_fire"]+$item_data["ms_mag"];
			$ms_water=$db["ms_water"]+$item_data["ms_water"]+$item_data["ms_mag"];
			$ms_air=$db["ms_air"]+$item_data["ms_air"]+$item_data["ms_mag"];
			$ms_earth=$db["ms_earth"]+$item_data["ms_earth"]+$item_data["ms_mag"];
			$ms_svet=$db["ms_svet"]+$item_data["ms_svet"]+$item_data["ms_mag"];
			$ms_tma=$db["ms_tma"]+$item_data["ms_tma"]+$item_data["ms_mag"];
			$ms_gray=$db["ms_gray"]+$item_data["ms_gray"]+$item_data["ms_mag"];

			$ms_rej=$db["ms_rej"]+$item_data["ms_rej"];
			$ms_drob=$db["ms_drob"]+$item_data["ms_drob"];
			$ms_kol=$db["ms_kol"]+$item_data["ms_kol"];
			$ms_rub=$db["ms_rub"]+$item_data["ms_rub"];
			$new_cost=($item_data["art"]>0?$item_data["gos_price"]*20:$item_data["gos_price"]);

			$proboy=$db["proboy"]+$item_data["proboy"];
			$add_oruj=$db["add_oruj"]+$item_data["add_oruj"];

			$new_mana=$db["mana_all"]+$item_data["add_mana"];
			$new_hp=$db["hp_all"]+$item_data["add_xp"]+$item_data["add_hp"];
			$now_hp = $db["hp"];
			$now_mn = $db["mana"];
			setHP($who,$now_hp,$new_hp);
			setMN($who,$now_mn,$new_mana);

			$new_sql ="UPDATE `users` SET sila='$new_sila', lovkost='$new_lovkost', udacha='$new_udacha', intellekt='$new_intellekt', duxovnost='$new_duxovnost', ";
			$new_sql.="hp_all='$new_hp', mana_all='$new_mana',";
			$new_sql.="bron_head='$new_phead', bron_corp='$new_pcorp', bron_legs='$new_plegs', bron_arm='$new_parm', bron_poyas='$new_ppoyas',";
			$new_sql.="$slot='".$item_data["id"]."', sword_vl='$new_swordvl', axe_vl='$new_axevl', hummer_vl='$new_failvl', castet_vl='$new_knifevl', copie_vl='$new_spearvl', staff_vl='$new_staffvl',";
			if($slot == "hand_r")
			{
				$new_sql.="hand_r_type='$w_type', hand_r_free='0', hand_r_hitmin='$new_wpmin', hand_r_hitmax='$new_wpmax',";
			}
			else if($slot == "hand_l")
			{
				$new_sql.="hand_l_type='$w_type', hand_l_free='0', hand_l_hitmin='$new_wpmin', hand_l_hitmax='$new_wpmax',";
			}
		
			$new_sql.="protect_rej='$protect_rej', protect_drob='$protect_drob', protect_kol='$protect_kol', protect_rub='$protect_rub', ";
			$new_sql.="protect_fire='$protect_fire', protect_water='$protect_water', protect_air='$protect_air', protect_earth='$protect_earth', protect_svet='$protect_svet', protect_tma='$protect_tma', protect_gray='$protect_gray', ";
			$new_sql.="protect_mag='$protect_mag', protect_udar='$protect_udar', shieldblock='$shieldblock', ";
			$new_sql.="parry='$parry', counter='$counter', ";
			//$new_sql.="add_rej='$add_rej', add_drob='$add_drob', add_kol='$add_kol', add_rub='$add_rub', ";
			//$new_sql.="add_fire_att='$add_fire_att', add_air_att='$add_air_att', add_watet_att='$add_watet_att', add_earth_att='$add_earth_att', ";
			$new_sql.="ms_udar='$ms_udar', ms_krit='$ms_krit', ms_mag='$ms_mag', ";
			$new_sql.="ms_fire='$ms_fire', ms_water='$ms_water', ms_air='$ms_air', ms_earth='$ms_earth', ms_svet='$ms_svet', ms_tma='$ms_tma', ms_gray='$ms_gray', ";
			$new_sql.="ms_rej='$ms_rej', ms_drob='$ms_drob', ms_kol='$ms_kol', ms_rub='$ms_rub', ";
			$new_sql.="proboy='$proboy', add_oruj='$add_oruj', ";
			$new_sql.="krit='$new_mfkrit', akrit='$new_mfantikrit', uvorot='$new_mfuvorot', auvorot='$new_mfantiuvorot', ";
			$new_sql.="fire_magic='$new_fire', water_magic='$new_water', air_magic='$new_air', earth_magic='$new_earth', ";
			$new_sql.="svet_magic='$new_svet',tma_magic='$new_tma',gray_magic='$new_gray',";
			$new_sql.=($wear_type!="paltar"?"two_hand=".$item_data["two_hand"].",":"");
			$new_sql.="cost=cost+$new_cost";
			$new_sql.=" WHERE login='".$who."'";

			mysql_query($new_sql);
			mysql_query("UPDATE `inv` SET wear=1,slot='".$slot."' WHERE id='".$itm."'");
		}
	}
	Header("Location: inv.php?otdel=obj&tmp=".md5(time()));
}
/*========================раздеть=======================*/
function unwear_full($who)
{
	$user_query=mysql_query("SELECT id,slot FROM inv WHERE `owner`='".$who."' and `object_razdel` = 'obj' and wear=1");
	while ($db=mysql_fetch_array($user_query))
	{
		unWear($who,$db["id"]);
	}
	mysql_free_result($user_query);
	Header("Location: inv.php?otdel=obj&tmp=".md5(time()));
}
//=====================================================================================================
function showpic($myinfo, $slot, $n)
{
	if ($n==2 && $myinfo['slot'.$slot]) {echo "<a href='?act=setdown_svitok&slot=$slot&id=".$myinfo['slot'.$slot]."'>";}
	if ($n==4 && $myinfo['slot'.$slot]) {echo "<a href='?act=magic&slot=$slot&id=".$myinfo['slot'.$slot]."'>";}
	if ($myinfo['slot'.$slot])
	{
		$f=mysql_fetch_array(mysql_query("SELECT scroll.name, scroll.img, inv.iznos, inv.iznos_max FROM inv LEFT JOIN scroll on scroll.id=inv.object_id WHERE inv.id='".$myinfo['slot'.$slot]."' and inv.owner='".$myinfo["login"]."' and object_type='scroll'"));
		echo "<img src='http://www.meydan.az/img/".$f["img"]."' title='".($n==2?"Снять ":($n==4?"Использовать ":"")).$f["name"]."' border='0' />";
	}
	else echo "<img src='http://www.meydan.az/img/elik/none.gif' title='Пустой слот заклинания' border='0' />";
	if ($n==2 || $n==4) {echo "</a>";}
}
//=====================================================================================================
function set_svitok($myinfo,$item_id) 
{	
	$res=mysql_fetch_array(mysql_query("SELECT * FROM inv WHERE owner='".$myinfo["login"]."' and id=$item_id and wear=0 and object_razdel='magic'"));
	if ($res)
	{	
		$sloton=0;
		$t=109;
		if ($myinfo["level"]>=10)$t=110;
		if ($myinfo["level"]>=11)$t=111;
		for ($i=100;$i<=$t;$i++) 
		{
			if (!$myinfo['slot'.$i]) {$sloton=$i;break;}
		}
		unset($i);
		if (!$sloton) 
		{ 
			#снимаем слот 100
			$sloton=100;
			setdown_svitok($myinfo,100,$myinfo['slot100']);
		}
		mysql_query("UPDATE users SET slot".$sloton."=$item_id WHERE login='".$myinfo["login"]."'");
		mysql_query("UPDATE inv SET wear=1 WHERE id=$item_id and owner='".$myinfo["login"]."'");
	}
	$now=md5(time());
	Header("Location: inv.php?otdel=magic&tmp=$now");
}
//=====================================================================================================
function setdown_svitok($myinfo,$slot,$item_id)
{
	$res=mysql_fetch_array(mysql_query("SELECT * FROM inv WHERE owner='".$myinfo["login"]."' and id=$item_id and wear=1 and object_razdel='magic'"));
	if ($res)
	{
		mysql_query("UPDATE users SET slot".$slot."=0 WHERE login='".$myinfo["login"]."'");
		mysql_query("UPDATE inv SET wear=0 WHERE id=$item_id");
	}
	$now=md5(time());
	Header("Location: inv.php?otdel=magic&tmp=$now");
}

/*=====================ПОЛУЧИТЬ ТРАВМУ===========================*/
function getTravm($who,$travmType)
{
	$data=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE login='".$who."'"));
	
	$time_now=time();
	if($travmType==1){$time=rand(30,120);$time_protect=360;}
	else if($travmType==2){$time=rand(120,360);$time_protect=720;}
	else if($travmType==3){$time=rand(360,720);$time_protect=1440;}
	else if($travmType==4){$time=1440;$time_protect=1440;}
	$travma_orden=array(3,4);
	$travma_rand=rand(1,3);
	$stats=array();
	$stats[0]="sila";
	$stats[1]="lovkost";
	$stats[2]="udacha";
	
	if (voin_type($data)=="mag")$kill_stat="intellekt";
	else $kill_stat=$stats[rand(0,2)];
	
	$stat=$data[$kill_stat];
	$st1=$data[$kill_stat];
	
	$kill_time=$time_now+$time*60;
	$protect_time=$time_now+$time_protect*60;
	$min_s = ($stat/100)*($travmType*20);
	
	$write_stat=floor($stat-$min_s);
	$al=$st1-$write_stat;
	$bots=Array('BOT','BOT0','BOT1','BOT2','BOT3','BOT4','BOT5','BOT6','BOT7','BOT8','BOT9','BOT10','BOT11','BOT12','BOT13','BOT14','BOT15','BOT16','BOT17','BOT18','BOT19','BOT20','BOT21','BOT22','BOT23','BOT24','BOT25','BOT26','BOT27','BOT28','BOT29','BOT30',
	'Гигантская крыса(4)','Гигантская крыса(5)','Гигантская крыса(6)','Гигантская крыса(7)','Гигантская крыса(8)','Гигантская крыса(9)','Гигантская крыса(10)','Гигантская крыса(11)',
	'Рептогатор(4)','Рептогатор(5)','Рептогатор(6)','Рептогатор(7)','Рептогатор(8)','Рептогатор(9)','Рептогатор(10)','Рептогатор(11)',
	'Зубоскал(4)','Зубоскал(5)','Зубоскал(6)','Зубоскал(7)','Зубоскал(8)','Зубоскал(9)','Зубоскал(10)','Зубоскал(11)',
	'Волк(4)','Волк(5)','Волк(6)','Волк(7)','Волк(8)','Волк(9)','Волк(10)','Волк(11)',
	'Лев(4)','Лев(5)','Лев(6)','Лев(7)','Лев(8)','Лев(9)','Лев(10)','Лев(11)',
	'Медведь(4)','Медведь(5)','Медведь(6)','Медведь(7)','Медведь(8)','Медведь(9)','Медведь(10)','Медведь(11)','ПОВЕЛИТЕЛЬ','Злой Снеговик',
	'Ловкая фицилия','Волк Валдагор','Саблезубый тигрица','Древень','Гордт-головорез','Гранитный голем','ГунглХО','Наглица','Надзиратель',
	'Свирепая','Цвятущая','Крэтс','Королевский скорпион','Огненный Крофдор','Натана','Angellika','Рыбак Натан', 'Наездница', 'Мальчик Лука', 'Ведьма');
	
	if (!in_array($who,$bots))
	{
		if ($data['travm']=="0" && $data["travm_protect"]<=$time_now)
		
		{	if ($data['level']>3 && (!in_array($data['orden'],$travma_orden) || (in_array($data['orden'],$travma_orden) && $travma_rand==2))) 
			{
				mysql_query("UPDATE users SET $kill_stat='".$write_stat."',travm_var='".$travmType."',travm='".$kill_time."',travm_stat='".$kill_stat."',travm_old_stat='".$al."', travm_protect='".$protect_time."' WHERE login='".$who."'");
			}
		}
		else
		{
			if ($travmType==4)mysql_query("UPDATE users SET travm_var='".$travmType."',travm='".$kill_time."', travm_protect='".$protect_time."' WHERE login='".$who."'");
		}
	}
}

/*====================ВЫЛЕЧИТЬ ТРАВМУ============================*/
function testCureTravm($who)
{
	$dat=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE login='".$who."'"));
	$tim=$dat["travm"]-time();
    if($tim<=0 && $dat["travm"]>0)
    {
    	$t_stat = $dat["travm_stat"];
		$o_stat = $dat["travm_old_stat"];
        mysql_query("UPDATE users SET $t_stat=$t_stat+$o_stat, travm='0', travm_stat='', travm_var='', travm_old_stat='' WHERE login='".$who."'");
        $_SESSION["message"]="Травма вылечена";
	}
}
/*========================ПРОВЕРКА НА ПОЛУЧЕНИЕ АПА/ЛЕВЕЛА=======*/
function testUps($user)
{
	$exptable = array(
						/*   ups,umenie,power,money, level, next_up, status,mass*/
						"0" => array (0,0,0,100,0,20,"Новичок",30),
						"20" => array (1,0,0,1,0,45,"Новичок",0),
						"45" => array (1,0,0,3,0,75,"Новичок",0),
						"75" => array (1,0,0,5,0,110,"Новичок",0),
						"110" => array (3,1,1,200,1,160,"Оруженосец",85),//level 1
						"160" => array (1,0,0,10,0,215,"Оруженосец",0),
						"215" => array (1,0,0,10,0,280,"Оруженосец",0),
						"280" => array (1,0,0,10,0,350,"Оруженосец",0),
						"350" => array (1,0,0,10,0,410,"Оруженосец",0),
						"410" => array (3,1,1,300,1,530,"Воин Первого круга",125),//level 2
						"530" => array (1,0,0,20,0,670,"Воин Первого круга",0),
						"670" => array (1,0,0,20,0,830,"Воин Первого круга",0),
						"830" => array (1,0,0,20,0,950,"Воин Первого круга",0),
						"950" => array (1,0,0,20,0,1100,"Воин Первого круга",0),
						"1100" => array (1,0,0,20,0,1300,"Воин Первого круга",0),
						"1300" => array (3,1,1,400,1,1450,"Воин Второго круга",165),//level 3
						"1450" => array (1,0,0,20,0,1650,"Воин Второго круга",0),
						"1650" => array (1,0,0,20,0,1850,"Воин Второго круга",0),
						"1850" => array (1,0,0,20,0,2050,"Воин Второго круга",0),
						"2050" => array (1,0,0,20,0,2200,"Воин Второго круга",0),
						"2200" => array (1,0,0,20,0,2500,"Воин Второго круга",0),
						"2500" => array (5,1,1,500,1,2900,"Воин Третьего круга",205),//level 4
						"2900" => array (1,0,0,30,0,3350,"Воин Третьего круга",0),
						"3350" => array (1,0,0,30,0,3800,"Воин Третьего круга",0),
						"3800" => array (1,0,0,30,0,4200,"Воин Третьего круга",0),
						"4200" => array (1,0,0,30,0,4600,"Воин Третьего круга",0),
						"4600" => array (1,0,0,30,0,5000,"Воин Третьего круга",0),
						"5000" => array (3,1,1,1000,1,6000,"Рыцарь",300),//level 5
						"6000" => array (1,0,0,40,0,7000,"Рыцарь",0),
						"7000" => array (1,0,0,40,0,8000,"Рыцарь",0),
						"8000" => array (1,0,0,40,0,9000,"Рыцарь",0),
						"9000" => array (1,0,0,40,0,10000,"Рыцарь",0),
						"10000" => array (1,0,0,40,0,11000,"Рыцарь",0),
						"11000" => array (1,0,0,40,0,12000,"Рыцарь",0),
						"12000" => array (1,0,0,40,0,12500,"Рыцарь",0),
						"12500" => array (3,1,1,2500,1,14000,"Легионер",350),//level 6
						"14000" => array (1,0,0,50,0,15500,"Легионер",0),
						"15500" => array (1,0,0,50,0,17000,"Легионер",0),
						"17000" => array (1,0,0,50,0,19000,"Легионер",0),
						"19000" => array (1,0,0,50,0,21000,"Легионер",0),
						"21000" => array (1,0,0,50,0,23000,"Легионер",0),
						"23000" => array (1,0,0,50,0,27000,"Легионер",0),
						"27000" => array (1,0,0,50,0,30000,"Легионер",0),
						"30000" => array (5,1,1,5000,1,60000,"Мастер Боевых Искусств",400),//level 7
						"60000" => array (1,0,0,100,0,75000,"Мастер Боевых Искусств",0),
						"75000" => array (1,0,0,100,0,150000,"Мастер Боевых Искусств",0),
						"150000" => array (1,0,0,100,0,175000,"Мастер Боевых Искусств",0),
						"175000" => array (1,0,0,100,0,200000,"Мастер Боевых Искусств",0),
						"200000" => array (1,0,0,100,0,225000,"Мастер Боевых Искусств",0),
						"225000" => array (1,0,0,100,0,250000,"Мастер Боевых Искусств",0),
						"250000" => array (1,0,0,100,0,260000,"Мастер Боевых Искусств",0),
						"260000" => array (1,0,0,100,0,280000,"Мастер Боевых Искусств",0),
						"280000" => array (1,0,0,100,0,300000,"Мастер Боевых Искусств",0),
						"300000" => array (5,1,1,7500,1,400000,"Полководец",450),//level 8
						"400000" => array (0,0,0,500,0,500000,"Полководец",0),
						"500000" => array (0,0,0,500,0,600000,"Полководец",0),
						"600000" => array (0,0,0,500,0,700000,"Полководец",0),
						"700000" => array (0,0,0,500,0,800000,"Полководец",0),
						"800000" => array (0,0,0,600,0,900000,"Полководец",0),
						"900000" => array (0,0,0,700,0,1000000,"Полководец",0),
						"1000000" => array (0,0,0,800,0,1200000,"Полководец",0),
						"1200000" => array (0,0,0,900,0,1500000,"Полководец",0),
						"1500000" => array (1,0,0,1000,0,1750000,"Полководец",0),
						"1750000" => array (1,0,0,100,0,2000000,"Полководец",0),
						"2000000" => array (1,0,0,200,0,2175000,"Полководец",0),
						"2175000" => array (1,0,0,300,0,2300000,"Полководец",0),
						"2300000" => array (1,0,0,400,0,2400000,"Полководец",0),
						"2400000" => array (1,0,0,500,0,2500000,"Полководец",0),
						"2500000" => array (1,0,0,1000,0,2600000,"Полководец",0),
						"2600000" => array (1,0,0,1000,0,2800000,"Полководец",0),
						"2800000" => array (1,0,0,1000,0,3000000,"Полководец",0),
						"3000000" => array (7,1,2,10000,1,6000000,"Рыцарь Хаоса",500),//level 9
						"6000000" => array (1,0,0,1000,0,6500000,"Рыцарь Хаоса",0),
						"6500000" => array (1,0,0,500,0,7500000,"Рыцарь Хаоса",0),
						"7500000" => array (1,0,0,600,0,8500000,"Рыцарь Хаоса",0),
						"8500000" => array (1,0,0,700,0,9000000,"Рыцарь Хаоса",0),
						"9000000" => array (1,0,0,800,0,9250000,"Рыцарь Хаоса",0),
						"9250000" => array (1,0,0,900,0,9500000,"Рыцарь Хаоса",0),
						"9500000" => array (1,0,0,1000,0,9750000,"Рыцарь Хаоса",0),
						"9750000" => array (1,0,0,1000,0,9900000,"Рыцарь Хаоса",0),
						"9900000" => array (1,0,0,1000,0,10000000,"Рыцарь Хаоса",0),
						"10000000" => array (9,1,3,15000,1,13000000,"Ассасин",550),//level 10
						"13000000" => array (2,0,0,100,0,14000000,"Ассасин",0),
						"14000000" => array (2,0,0,200,0,15000000,"Ассасин",0),
						"15000000" => array (2,0,0,300,0,16000000,"Ассасин",0),
						"16000000" => array (2,0,0,400,0,17000000,"Ассасин",0),
						"17000000" => array (2,0,0,500,0,17500000,"Ассасин",0),
						"17500000" => array (2,0,0,600,0,18000000,"Ассасин",0),
						"18000000" => array (2,0,0,700,0,19000000,"Ассасин",0),
						"19000000" => array (2,0,0,800,0,19500000,"Ассасин",0),
						"19500000" => array (2,0,0,900,0,20000000,"Ассасин",0),
						"20000000" => array (2,0,0,1000,0,30000000,"Ассасин",0),
                        "30000000" => array (3,0,0,500,0,32000000,"Ассасин",0),
                        "32000000" => array (2,0,0,500,0,34000000,"Ассасин",0),
                        "34000000" => array (2,0,0,500,0,35000000,"Ассасин",0),
                        "35000000" => array (3,0,0,500,0,36000000,"Ассасин",0),
                        "36000000" => array (2,0,0,500,0,38000000,"Ассасин",0),
                        "38000000" => array (2,0,0,500,0,40000000,"Ассасин",0),
                        "40000000" => array (2,0,0,500,0,42000000,"Ассасин",0),
                        "42000000" => array (2,0,0,500,0,44000000,"Ассасин",0),
                        "44000000" => array (2,0,0,500,0,45000000,"Ассасин",0),
                        "45000000" => array (2,0,0,500,0,46000000,"Ассасин",0),
                        "46000000" => array (2,0,0,500,0,48000000,"Ассасин",0),
                        "48000000" => array (2,0,0,500,0,50000000,"Ассасин",0),
                        "50000000" => array (2,0,0,500,0,52000000,"Ассасин",0),
                        "52000000" => array (10,1,5,25000,1,55000000,"Ветеран I степени",600),//level 11
                        "55000000" => array (1,0,1,1000,0,60000000,"Ветеран I степени",0),
                        "60000000" => array (1,0,1,1000,0,65000000,"Ветеран I степени",0),
                        "65000000" => array (1,0,1,1000,0,70000000,"Ветеран I степени",0),
                        "70000000" => array (1,0,1,1000,0,75000000,"Ветеран I степени",0),
                        "75000000" => array (1,0,1,1000,0,80000000,"Ветеран I степени",0),
                        "80000000" => array (1,0,1,1000,0,85000000,"Ветеран I степени",0),
                        "85000000" => array (1,0,1,1000,0,90000000,"Ветеран I степени",0),
                        "90000000" => array (1,0,1,1000,0,95000000,"Ветеран I степени",0),
                        "95000000" => array (1,0,0,1000,0,100000000,"Ветеран I степени",0),
        				"100000000" => array (15,0,1,1000,0,120000000,"Ветеран I степени",0),
        				"120000000" => array (15,0,0,50000,1,200000000,"Ветеран II степени",0),//level 12
        				"200000000" => array (1, 0,0,10000,0,500000000,"Ветеран II степени",0),
        				"500000000" => array (1, 0,0,10000,0,1000000000,"Ветеран II степени",0),
				);
				/*   ups,umenie,power,money, level, next_up, status,mass*/
	if ($user['exp'] >= $user['next_up'])
	{
		if($exptable[$user['next_up']][4]==1)
		{
			$_SESSION["message"]="Воин <b>".$user["login"]."</b> достиг уровня <b>".($user['level']+1)."</b>!";
			if ($user['refer'] && ($user['level']+1>=6))
			{
				$have_refer=mysql_fetch_Array(mysql_query("SELECT login,remote_ip FROM users WHERE id=".$user['refer']));
				if ($have_refer)
				{
					$give_pl=array();
					$give_pl[6]=10;
					$give_pl[7]=20;
					$give_pl[8]=50;
					$give_pl[9]=100;
					$give_pl[10]=200;
					$give_pl[11]=300;
					$give_pl[12]=500;
					$give_ref_pl=$give_pl[$user['level']+1];
					$txt="Персонаж ".$user['login']." перешел на ".($user['level']+1)." уровень. Вам перечислено ".$give_ref_pl." Пл.</font>";
					mysql_query("UPDATE users SET platina=platina+".$give_ref_pl." WHERE id=".$user['refer']);
					mysql_query("INSERT INTO pochta(user, whom, text, subject) VALUES ('Путешественник','".$have_refer["login"]."','".$txt."','Получил Платина')");
					history($have_refer["login"], "Получил Платина", $give_ref_pl." Пл. [".$user['login']."-".$user['remote_ip']."]", $have_refer["remote_ip"], "Реферал");
				}
			}
		}
		
		history($user["login"],'Получил Зл.',$exptable[$user['next_up']][3]." Зл.",$user['remote_ip'],'Перешел АП'.($exptable[$user['next_up']][4]==1?" [достиг уровня ".($user['level']+1)."]":""));

		mysql_query("UPDATE `users` SET `next_up` = ".$exptable[$user['next_up']][5].",`ups` = ups+".$exptable[$user['next_up']][0].",
						`umenie` = `umenie`+".$exptable[$user['next_up']][1].", `power` = `power`+".$exptable[$user['next_up']][2].",
						`hp_all` = `hp_all`+".($exptable[$user['next_up']][2]*6).",`status`='".$exptable[$user['next_up']][6]."', maxmass=maxmass+".$exptable[$user['next_up']][7].",
						`money` = `money`+'".$exptable[$user['next_up']][3]."',`level` = `level`+".$exptable[$user['next_up']][4]."
						WHERE `id` = '".$user['id']."'");

		$now=md5(time());
		Header("Location: main.php?act=none&tmp=$now");
	}
}	

/*===================TestUP====================================*/
function testZverUp($zver,$owner)
{
	include("bot_exp.php");
	$exp_table=array();
	$exp_table[0]="110";
	$exp_table[1]="410";
	$exp_table[2]="1300";
	$exp_table[3]="2500";
	$exp_table[4]="5000";
	$exp_table[5]="12500";
	$exp_table[6]="30000";
	$exp_table[7]="300000";
	$exp_table[8]="3000000";
	$exp_table[9]="10000000";
	$exp_table[10]="50000000";
	$exp_table[11]="100000000";
	$exp_table[12]="1000000000";

	for($i=0;$i<count($exp_table);$i++)
	{
		if($exp_table[$i]==$zver["next_up"]){$current_up=$i;}
	}

	$cur_level=$zver["level"]+1;	
	$id=$current_up+1;
	$next_exp=$exp_table[$id];

	mysql_query("UPDATE zver SET next_up='".$next_exp."',level='".$cur_level."',hp_all=".($a[$zver["type"]][$cur_level]["power"]*6)." , 
	sila=".$a[$zver["type"]][$cur_level]["sila"]." , lovkost=".$a[$zver["type"]][$cur_level]["lovkost"]." , udacha=".$a[$zver["type"]][$cur_level]["udacha"]." , power=".$a[$zver["type"]][$cur_level]["power"]." , 
	intellekt=".$a[$zver["type"]][$cur_level]["intellekt"]." , vospriyatie=".$a[$zver["type"]][$cur_level]["vospriyatie"]." , 
	krit=".$a[$zver["type"]][$cur_level]["krit"]." , akrit=".$a[$zver["type"]][$cur_level]["akrit"]." , uvorot=".$a[$zver["type"]][$cur_level]["uvorot"]." , auvorot=".$a[$zver["type"]][$cur_level]["auvorot"]." , 
	bron_head=".$a[$zver["type"]][$cur_level]["bron_head"]." , bron_corp=".$a[$zver["type"]][$cur_level]["bron_corp"]." , bron_poyas=".$a[$zver["type"]][$cur_level]["bron_poyas"]." , bron_legs=".$a[$zver["type"]][$cur_level]["bron_legs"]." , 
	hand_r_hitmin=".$a[$zver["type"]][$cur_level]["hand_r_hitmin"]." , hand_r_hitmax=".$a[$zver["type"]][$cur_level]["hand_r_hitmax"]." , hand_l_hitmin=".$a[$zver["type"]][$cur_level]["hand_l_hitmin"]." , hand_l_hitmax=".$a[$zver["type"]][$cur_level]["hand_l_hitmax"]." , 
	add_bron=".$a[$zver["type"]][$cur_level]["add_bron"]." , add_magic=".$a[$zver["type"]][$cur_level]["add_magic"]." WHERE id='".$zver["id"]."'");
	$_SESSION["message"]="Звер <b>".$zver["name"]."</b> достиг уровня <b>".$cur_level."</b>!";
	$now=md5(time());
	Header("Location: main.php?act=none&tmp=$now");
}
/*===================ТЮРЬМА====================================*/
function testPrision($who)
{
	if($who["prision"]!=0 && $who["prision"]!="")
    {
		$tim=floor($who["prision"]-time());
		if($tim<=0)
		{
			mysql_query("UPDATE users SET prision='0',orden=0 WHERE login='".$who["login"]."'");
		}
	}
}
/*================Восстановить хп================================*/
function cureHP($who,$beg,$fin)
{
	$query=mysql_query("SELECT * FROM users WHERE login='".$who."'");
	$data=mysql_fetch_array($query);
	$hp_all=$data["hp_all"];
	
	$r=$fin-$beg;
	$raznica=floor((($fin-$beg)/$hp_all)*100);
	$time_to_cure=($raznica*600)/100;
	$put_to_base=time()+$time_to_cure;
}
/*======================TestBattle===============================*/
function TestBattle($pers)
{
	if($pers["battle"])
	{
		Header("Location: battle.php?tmp=".md5(time())."");
	}
}

/*=======================================================================*/
function getNextEnemy($who,$teams,$creators,$b_id)
{
	$victims=array();
	$opponents = mysql_query("SELECT player FROM teams LEFT JOIN users on users.login=teams.player WHERE teams.battle_id = '".$creators."' and users.hp>0 and teams.team=".$teams);
	if (mysql_num_rows($opponents))
	{
    	while ($opponent=mysql_fetch_array($opponents)) 
    	{
    		$user_turn_us=mysql_fetch_array(mysql_query("SELECT count(*) FROM hit_temp WHERE attack='".$opponent["player"]."' AND defend='".$who."' AND battle_id=$b_id"));
      		if (!$user_turn_us[0]) $victims[] = $opponent["player"];
    	}
	}
	$BLD_ = mysql_query("SELECT * FROM bot_temp WHERE battle_id='".$b_id."' and hp>0 and team=$teams");
	if (mysql_num_rows($BLD_))
	{
		while ($BLD=mysql_fetch_array($BLD_))
		{
			$user_turn_bt=mysql_fetch_array(mysql_query("SELECT count(*) FROM hit_temp WHERE attack='".$BLD["bot_name"]."' AND defend='".$who."' AND battle_id=$b_id"));
			if (!$user_turn_bt[0]) $victims[] = $BLD["bot_name"];
		}
	}
	$set_opp = $victims[rand(0,count($victims)-1)];
	mysql_query("UPDATE users SET battle_opponent='".$set_opp."' WHERE login='".$who."'");
	return $set_opp;
}
/*=======================================================================*/
function hit_dis($attack,$defend,$type,$blocked,$hit,$hand,$blok,$blokzone,$bat)
{
	$at_priem=array();
	$def_priem=array();
	$battle_id = $bat;
	$date = date("H:i");
	################ Doyuwculer ################################
	if($type[0]==0)
	{
		//если не бот
		$ATTACK_QUERY = mysql_query("SELECT users.*,zver.id as zver_count,zver.level as zver_level,zver.type as zver_type FROM users LEFT JOIN zver on zver.owner=users.id and zver.sleep=0 WHERE login='".$attack."'");
		$ATTACK_DATA  = mysql_fetch_array($ATTACK_QUERY);
		mysql_free_result($ATTACK_QUERY);
		$a_pr=mysql_query("SELECT pr_name FROM person_on WHERE id_person=".$ATTACK_DATA["id"]." and battle_id=$bat and pr_active=2 and pr_cur_uses>0");
		while($attack_priem=mysql_fetch_array($a_pr))
		{
			$at_priem[]=$attack_priem["pr_name"];
		}	
	}
	else if($type[0] == 1)
	{ 
		//если бот
		$ATT_SQL = mysql_query("SELECT * FROM bot_temp WHERE battle_id=$bat and  bot_name='".$attack."'");
		$ATT_DATA = mysql_fetch_array($ATT_SQL);
		mysql_free_result($ATT_SQL);
		
		if (!$ATT_DATA["zver"])
		{	
			$ATTACK_QUERY = mysql_query("SELECT * FROM users WHERE login='".$ATT_DATA["prototype"]."'");#bot from users
		}
		else 
		{
			$ATTACK_QUERY = mysql_query("SELECT * FROM zver WHERE id='".$ATT_DATA["prototype"]."'");#is_Zver
		}
		$ATTACK_DATA  = mysql_fetch_array($ATTACK_QUERY);
		mysql_free_result($ATTACK_QUERY);
	}
	if($type[1]==0)
	{
		//если не бот
		$DEFEND_QUERY = mysql_query("SELECT users.*,zver.id as zver_count,zver.level as zver_level,zver.type as zver_type FROM users LEFT JOIN zver on zver.owner=users.id and zver.sleep=0 WHERE login='".$defend."'");
		$DEFEND_DATA  = mysql_fetch_array($DEFEND_QUERY);
		mysql_free_result($DEFEND_QUERY);
		$d_pr=mysql_query("SELECT pr_name FROM person_on WHERE id_person=".$DEFEND_DATA["id"]." and battle_id=$bat and pr_active=2 and pr_cur_uses>0");
		while($defend_priem=mysql_fetch_array($d_pr))
		{
			$def_priem[]=$defend_priem["pr_name"];
		}
	}
	else if($type[1] == 1)
	{
		//если бот
		$DEF_SQL = mysql_query("SELECT * FROM bot_temp WHERE battle_id=$bat and  bot_name='".$defend."'");
		$DEF_DATA = mysql_fetch_array($DEF_SQL);
		mysql_free_result($DEF_SQL);
		
		if(!$DEF_DATA["zver"])
		{	
			$DEFEND_QUERY = mysql_query("SELECT * FROM users WHERE login='".$DEF_DATA["prototype"]."'");
		}
		else 
		{
			$DEFEND_QUERY = mysql_query("SELECT * FROM zver WHERE id='".$DEF_DATA["prototype"]."'");
		}
		$DEFEND_DATA  = mysql_fetch_array($DEFEND_QUERY);
		mysql_free_result($DEFEND_QUERY);
	}
	################################################################################################
	if($type[0]==0)
    {
       if($ATTACK_DATA["battle_team"] == 1){$span1 = "p1";$span2 = "p2";}else{$span1 = "p2";$span2 = "p1";}
    }
    else if($type[0]==1)
    {
       if($ATT_DATA["team"] == 1){$span1 = "p1";$span2 = "p2";}else{$span1 = "p2";$span2 = "p1";}
    }
	################################################################################################
	
	$attack_priem_count=array_count_values($at_priem);
	$defent_priem_count=array_count_values($def_priem);
	
	/*if (in_Array("resolvetactic",$def_priem))
	{
		$phrase.= "<span class=date>$date</span> <span class=$span1>".$defend."</span> понял что его спасение это прием <b>Разгадать тактику</b>.<br>";
		mysql_query("UPDATE person_on SET pr_active=1,pr_cur_uses=1 WHERE id_person='".$ATTACK_DATA["id"]."' and battle_id=".$bat." and pr_active=2");
		mysql_query("UPDATE person_on SET pr_active=1 WHERE id_person='".$DEFEND_DATA["id"]."' and battle_id=".$bat." and pr_name='resolvetactic'");
		unset($at_priem);
	}*/	
	if (in_Array("resolvetactic",$at_priem))
	{
		$phrase.= "<span class=date>$date</span> <span class=$span1>".$attack."</span> понял что его спасение это прием <b>Разгадать тактику</b>.<br>";
		mysql_query("UPDATE person_on SET pr_active=1,pr_cur_uses=1 WHERE id_person='".$DEFEND_DATA["id"]."' and battle_id=".$bat." and pr_active=2");
		mysql_query("UPDATE person_on SET pr_active=1 WHERE id_person='".$ATTACK_DATA["id"]."' and battle_id=".$bat." and pr_name='resolvetactic'");
		unset($def_priem);
	}

	include ("inc/battle/calc_g.php");
	include ("inc/battle/hit_dis.php");
	################################################################################################
    if($ATTACK_DATA["sex"] == "male"){$pref = "";}else{$pref = "а";}
    if($DEFEND_DATA["sex"] == "male"){$pref_d = "";}else{$pref_d = "а";}

	//--------------------yazilar--------------------------------
    $hit_dis=array();
    $hit_dis[1]=$head_dis[rand(0,count($head_dis)-1)];
    $hit_dis[2]=$arm_dis[rand(0,count($arm_dis)-1)];
    $hit_dis[3]=$corp_dis[rand(0,count($corp_dis)-1)];
    $hit_dis[4]=$poyas_dis[rand(0,count($poyas_dis)-1)];
    $hit_dis[5]=$leg_dis[rand(0,count($leg_dis)-1)];

    $hit_dis_txt=$hit_dis_phisic[rand(0,count($hit_dis_phisic)-1)];
    $killtext=$kill_dis[rand(0,count($kill_dis)-1)];
    $blok_txt=$blok_dis[rand(0,count($blok_dis)-1)];
    
    $krit_hit_1 = $krit_dis_1[rand(0,count($krit_dis_1)-1)];
    $krit_hit_2 = $krit_dis_2[rand(0,count($krit_dis_2)-1)];
    
    $uvorot_1 = $uv_dis_1[rand(0,count($uv_dis_1)-1)];/*isteyirdi*/
    $uvorot_2 = $uv_dis_2[rand(0,count($uv_dis_2)-1)];/*bu zaman*/
    $uvorot_3 = $uv_dis_3[rand(0,count($uv_dis_3)-1)];/*otprignul*/

	$parry_1 = $parry_dis[rand(0,count($parry_dis)-1)];/*pariroval*/
	
    $priem_txt = $priyem_dis[rand(0,count($priyem_dis)-1)];
	//------------------------------------------------------------
	switch ($hit) 
	{
		 case 1:$bronya_m = $defend_bron_h;break;
		 case 2:$bronya_m = $defend_bron_a;break;
	 	 case 3:$bronya_m = $defend_bron_c;break;
	 	 case 4:$bronya_m = $defend_bron_p;break;
	 	 case 5:$bronya_m = $defend_bron_l;break;
	}
	if (in_Array("skiparmor",$at_priem))
	{
		$def_protect_udar=$def_protect_udar-250;
		$bronya_m=0;
		if ($def_protect_udar<=0)$def_protect_udar=0;
	}
		
	if ($def_protect_udar>=750)      {$percent_bron=250;}#87.5
	else if ($def_protect_udar>=500) {$percent_bron=200;}#75
	else if ($def_protect_udar>=350) {$percent_bron=150;}#75
	else if ($def_protect_udar>=300) {$percent_bron=100;}#75
	else if ($def_protect_udar>=250) {$percent_bron=50; }#50
	else if ($def_protect_udar>=100) {$percent_bron=20; }#20
	else if ($def_protect_udar>=50)   {$percent_bron=10; }#10
	if ($ATTACK_DATA["level"]<$DEFEND_DATA["level"] && $is_art!=2)
	{
		$percent_bron=$percent_bron+($DEFEND_DATA["level"]-$ATTACK_DATA["level"])*20;
	}
    $bronya = $bronya_m+$bronya_m*$percent_bron/100;
    if ($is_proboy)
    {
    	$bronya=$bronya-$bronya_m;
    	$hit_dis_txt=$proboy_dis[rand(0,count($proboy_dis)-1)].$hit_dis_txt;
    }
    if ($bronya<=0)$bronya=0;
	##############################---Priyomlar---##################################
	
    if ($attack_priem_count["yarost"]==1)$hit_k=$hit_k+$hit_k*0.05;
    else if ($attack_priem_count["yarost"]==2)$hit_k=$hit_k+$hit_k*0.10;
    else if ($attack_priem_count["yarost"]>=3)$hit_k=$hit_k+$hit_k*0.15;

	if ($defent_priem_count["stoykost"]==1)$bronya=$bronya+$bronya*0.05;
    else if ($defent_priem_count["stoykost"]==2)$bronya=$bronya+$bronya*0.10;
    else if ($defent_priem_count["stoykost"]>=3)$bronya=$bronya+$bronya*0.15;
	
	if ((in_Array("prikritsa",$def_priem)&& $type[1]==0))$bronya=$bronya+3;
	
	$hit_k = $hit_k-rand($bronya,$bronya*1.1); // son udarimdan duwmenin bronyasinin ferqi...

	$hit_k=$hit_k+(in_Array("vlomit",$at_priem)?4:0);

	$hit_k=$hit_k+(in_Array("hit",$at_priem)?($ATTACK_DATA["level"]*3):0);
	$hit_k=$hit_k+(in_Array("strong_hit",$at_priem)?($ATTACK_DATA["level"]*6):0);
	$hit_k=((in_Array("block",$def_priem)&& $type[1]==0)?($hit_k*0.5):$hit_k);
	
	
	$hit_k=((in_Array("restore",$def_priem)&& $type[1]==0)?($hit_k*0.75):$hit_k);

	//------------------END BONUS-------------------------------------------------
	if($hit_k<=0) $hit_k = rand(3*$ATTACK_DATA["level"],(1+4*$ATTACK_DATA["level"])); // eger 0-dan kichikdirse...
	
	$hit_k=((in_Array("earth_shield",$def_priem)&& $type[1]==0)?$hit_k*0.05:$hit_k);
	$hit_k=((in_Array("fullshield",$def_priem)&& $type[1]==0)?1:$hit_k);
	
	$hit_k=ceil($hit_k);

	switch ($blok) 
	{
		case 0:$bl=($blokzone?'000':'00');break;
		case 1:$bl=($blokzone?'123':'12');break;
		case 2:$bl=($blokzone?'234':'23');break;
		case 3:$bl=($blokzone?'345':'34');break;
		case 4:$bl=($blokzone?'451':'45');break;
		case 5:$bl=($blokzone?'512':'51');break;
	}	
	//---------------------------------------------------------------------------
	if (in_Array("krit",$at_priem)) {$is_krit=true;$is_uvorot=false;$is_parry=false;$is_counter=false;}
	if (in_Array("forcefield7",$def_priem))$is_krit=false;
	if (in_Array("hidden_dodge",$def_priem))$is_uvorot=true;
	if (in_Array("power",$at_priem)){$is_krit=true;$is_uvorot=false;}
	if (in_Array("skiparmor",$at_priem)){$is_uvorot=false;$is_parry=false;}
	if ($blocked){if ($is_probit_blok && $is_krit)$blocked=0;}else $is_probit_blok=false;
	if ($blok==0) {$is_uvorot=false;$is_parry=false;}
	if ($blocked) {$is_uvorot=false;$is_parry=false;$is_counter=false;}
	
    if($blocked)
    {
        $phrase.= "<script>adh($hit,$bl,'$date',3,'$attack');</script><span class=$span1>$attack</span> $uvorot_1 $hit_dis[$hit], $uvorot_2 <span class=$span2>$defend</span> $blok_txt.<BR>";
    	$blok_priem=1;
    }
    else if($type[1]==0 && in_Array("tuman7",$def_priem)) 
    {
		mysql_query("UPDATE person_on SET pr_active=1 WHERE id_person='".$DEFEND_DATA["id"]."' and battle_id=".$bat." and pr_name='tuman7'");
		hit_dis($attack,$attack,$type[0].$type[0],0,rand(1,5),0,0,0,$bat);
		$phrase.= "<span class=date>$date</span> <span class=$span2>$defend</span> понимая, что ситуация становится критической, применил прием <b>Рассечение тумана</b><BR>";
    }
    else if($is_uvorot || ($type[1]==0 && in_Array("uvarot",$def_priem)) || ($type[1]==0 && in_Array("counter_bladedance",$def_priem)) || ($type[1]==0 && in_Array("hidden_dodge",$def_priem)))
    {
        if (!$is_counter)
        {
        	$phrase = "<script>adh($hit,$bl,'$date',3,'$attack');</script><span class=$span1>$attack</span> $uvorot_1 $hit_dis[$hit], $uvorot_2 <span class=$span2>$defend</span> $uvorot_3.<BR>";
    	}
    	else if ($is_counter)
    	{
			hit_dis($defend,$attack,$type[1].$type[0],0,rand(1,5),0,0,0,$bat);
			$phrase = "<script>adh($hit,$bl,'$date',3,'$attack');</script><span class=$span1>$attack</span> $uvorot_1 $hit_dis[$hit], $uvorot_2 <span class=$span2>$defend</span> $uvorot_3 и <b style='color:green'>сделал контрудар</b>.<BR>";
    	}	
		$uvarot_priem=1;
		if (in_Array("uvarot",$def_priem) && $type[1]==0)
		{	
			mysql_query("UPDATE person_on SET pr_active=1 WHERE id_person='".$DEFEND_DATA["id"]."' and battle_id=".$bat." and pr_name='uvarot'");
			$phrase.= "<span class=date>$date</span> <span class=$span2>$defend</span>, $priem_txt <b>Коварный уход</b>.<br>";
			$uvarot_priem=0;
		}
		if (in_Array("counter_bladedance",$def_priem) && $type[1]==0)
		{	
			mysql_query("UPDATE person_on SET pr_active=1 WHERE id_person='".$DEFEND_DATA["id"]."' and battle_id=".$bat." and pr_name='counter_bladedance'");
			hit_dis($defend,$attack,$type[1].$type[0],0,rand(1,5),0,0,0,$bat);
			$phrase.= "<span class=date>$date</span> <span class=$span2>$defend</span>, $priem_txt <b>Веерная атака</b>.<br>";
			$uvarot_priem=0;
		}
		if (in_Array("hidden_dodge",$def_priem) && $type[1]==0)
		{	
			mysql_query("UPDATE person_on SET pr_active=1 WHERE id_person='".$DEFEND_DATA["id"]."' and battle_id=".$bat." and pr_name='hidden_dodge'");
			hit_dis($defend,$attack,$type[1].$type[0],0,rand(1,5),0,0,0,$bat);
			$phrase.= "<span class=date>$date</span> <span class=$span2>$defend</span>, $priem_txt <b>Рубленые раны</b>.<br>";
			$uvarot_priem=0;
		}
    }
	else if($is_parry || ($type[1]==0 && in_Array("parry",$def_priem)) || ($type[1]==0 && in_Array("parry_life",$def_priem)))
    {
        $phrase.= "<script>adh($hit,$bl,'$date',3,'$attack');</script><span class=$span1>$attack</span> $uvorot_1 $hit_dis[$hit], $uvorot_2 <span class=$span2>$defend</span> $parry_1.<BR>";
    	$parry_priem=1;
		if (in_Array("parry",$def_priem) && $type[1]==0)
		{	
			mysql_query("UPDATE person_on SET pr_active=1 WHERE id_person='".$DEFEND_DATA["id"]."' and battle_id=".$bat." and pr_name='parry'");
			$phrase.= "<span class=date>$date</span> <span class=$span2>$defend</span>, $priem_txt <b>Предвидение</b>.<br>";
			$parry_priem=0;
		}
		if (in_Array("parry_life",$def_priem) && $type[1]==0)
		{
			mysql_query("UPDATE person_on SET pr_active=1 WHERE id_person='".$DEFEND_DATA["id"]."' and battle_id=".$bat." and pr_name='parry_life'");
			$hp_add=$ATTACK_DATA["level"]*5;
			$new_hp=$DEFEND_DATA["hp"]+$hp_add;
			if ($new_hp>$DEFEND_DATA["hp_all"]) 
			{
				$new_hp=$DEFEND_DATA["hp_all"];
				$hp_add=$DEFEND_DATA["hp_all"]-$DEFEND_DATA["hp"];
			}	
			setHP($DEFEND_DATA["login"],$new_hp,$DEFEND_DATA['hp_all']);
			$phrase.= "<span class=date>$date</span> <span class=$span2>$defend</span>, $priem_txt <b>Второе дыхание+ $hp_add HP.</b><br>";
			$parry_priem=0;
		}
    }
    else if($is_krit)
    {
    	$my_hit=1;
    	$mykrit=((1+rand(0,$ms_krit)/100)*2)*$hit_k;
    	$mykrit=(in_Array("krit_max",$at_priem)?$mykrit:rand($mykrit*0.6,$mykrit*0.7));

    	if ($mykrit<0)$mykrit=0;
        $hit_k = ceil($mykrit);
		$probiv="";
		if ($is_probit_blok){$hit_k=ceil($hit_k/4);$probiv=", <b style='color:red'>пробив блок</b>,";}


        if($type[1] == 0)
        {
	        $hp_all = $DEFEND_DATA["hp_all"];
	        $hp_now = $DEFEND_DATA["hp"];
        }
        else if($type[1]==1)
        {
	        $hp_all = $DEF_DATA["hp_all"];
	        $hp_now = $DEF_DATA["hp"];
        }
        $hp_new = $hp_now - $hit_k;
        if($hit_k >= $hp_now)
        {
            $hp_new = 0;
            if($is_travm == 1 && $DEFEND_DATA["travm"]==0 && $DEFEND_DATA["level"]>0 && $DEFEND_DATA["travm_protect"]<=time())
			{
                $percent = $hp_all/100;
                if($hit_k<$percent*30)
                {
                	$travm = 1;
                }
                else if($hit_k>=$percent*30 && $hit_k<$percent*60)
                {
                	$travm = 2;
                }
                else if($hit_k>=$percent*60)
                {
                	$travm = 3;
                }
                getTravm($defend,$travm);
                include "inc/battle/travm_dis.php";
                $travm_dis = array();
                $travm_dis[1] = $ushib_d;
                $travm_dis[2] = $perelom_d;
                $travm_dis[3] = $heavy_d;

                $phrase  = "<span class=sysdate >$date</span> <span class=$span2>$defend</span> побежден великим воином по имени <span class=$span1>$attack</span>.<BR>";
                $phrase .= "<span class=sysdate >$date</span> <span class=$span2>$defend</span> получил$pref_d $travm_text: <font color=red>".$travm_dis[$travm]."</font>.<BR>";
                $phrase .= "<script>adh($hit,$bl,'$date',4,'$attack');</script>Ничто не предвещало беды...Но <span class=$span1>$attack</span>$probiv страшно крикнув нанес удар в $hit_dis[$hit] <span class=$span2>$defend</span> на <span class=krit title='$txt_hit_type'>-$hit_k </span> [$hp_new/$hp_all]<BR>";
			}
            else 
            {
                $phrase  = "<span class=sysdate >$date</span> <span class=$span2>$defend</span> $killtext.<BR>";
                $phrase .= "<script>adh($hit,$bl,'$date',4,'$attack');</script><span class=$span2>$defend</span> $krit_hit_1 <span class=$span1>$attack</span>$probiv $krit_hit_2 $hit_dis[$hit] на <span class=krit title='$txt_hit_type'>-$hit_k</span> [$hp_new/$hp_all]<BR>";
            }
            mysql_query("DELETE FROM `hit_temp` WHERE attack='".$defend."'");
		}
        else
        {
            $phrase = "<script>adh($hit,$bl,'$date',4,'$attack');</script><span class=$span2>$defend</span> $krit_hit_1 <span class=$span1>$attack</span>$probiv $krit_hit_2 $hit_dis[$hit] на <span class=krit title='$txt_hit_type'>-$hit_k </span> [$hp_new/$hp_all]<BR>";
        }
        if($type[1]==0)
        {
        	mysql_query("UPDATE users SET hp='".$hp_new."',battle_opponent='' WHERE login='".$defend."'");
        }
        else if($type[1]==1)
        {
            mysql_query("UPDATE bot_temp SET hp='".$hp_new."' WHERE bot_name='".$defend."' AND battle_id='".$battle_id."'");
        }
        if($type[0]==0)
        {
			mysql_query("UPDATE teams SET hitted=hitted+$hit_k WHERE player='".$attack."'");
        }
        if($type[0]==1 && $ATT_DATA["zver"]==1)
        {
			mysql_query("UPDATE teams SET hitted=hitted+$hit_k WHERE player=(select login from users where id=".$ATTACK_DATA["owner"].")");
        }
		$krit_priem=1;
		if($type[0]==0)
		{	
			if (in_Array("hit",$at_priem))
			{
				$phrase.= "<span class=date>$date</span> <span class=$span1>$attack</span>, $priem_txt <b>Сильный удар</b>.<br>";
				mysql_query("UPDATE person_on SET pr_active=1 WHERE id_person='".$ATTACK_DATA["id"]."' and battle_id=".$bat." and pr_name='hit'");
			}
			if (in_Array("skiparmor",$at_priem))
			{
				$phrase.= "<span class=date>$date</span> <span class=$span1>$attack</span>, $priem_txt <b>Точный удар</b>.<br>";
				mysql_query("UPDATE person_on SET pr_active=1 WHERE id_person='".$ATTACK_DATA["id"]."' and battle_id=".$bat." and pr_name='skiparmor'");
			}
			if (in_Array("vlomit",$at_priem))
			{
				$phrase.= "<span class=date>$date</span> <span class=$span1>$attack</span>, $priem_txt <b>Вломить</b>.<br>";
				mysql_query("UPDATE person_on SET pr_active=1 WHERE id_person='".$ATTACK_DATA["id"]."' and battle_id=".$bat." and pr_name='vlomit'");
			}
			if (in_Array("power",$at_priem))
			{
				$phrase.= "<span class=date>$date</span> <span class=$span1>$attack</span>, $priem_txt <b>Ледяная игла</b>.<br>";
				mysql_query("UPDATE person_on SET pr_active=1 WHERE id_person='".$ATTACK_DATA["id"]."' and battle_id=".$bat." and pr_name='power'");
			}
			if (in_Array("strong_hit",$at_priem))
			{
				$phrase.= "<span class=date>$date</span> <span class=$span1>$attack</span>, $priem_txt <b>Мощный удар</b>.<br>";
				mysql_query("UPDATE person_on SET pr_active=1 WHERE id_person='".$ATTACK_DATA["id"]."' and battle_id=".$bat." and pr_name='strong_hit'");
			}
			if (in_Array("krit",$at_priem))
			{
				$phrase.= "<span class=date>$date</span> <span class=$span1>$attack</span>, $priem_txt <b>Слепая удача</b>.<br>";
				mysql_query("UPDATE person_on SET pr_active=1 WHERE id_person='".$ATTACK_DATA["id"]."' and battle_id=".$bat." and pr_name='krit'");
				$krit_priem=0;
			}
			if (in_Array("krit_max",$at_priem))
			{
				$phrase.= "<span class=date>$date</span> <span class=$span1>$attack</span>, $priem_txt <b>Дикая удача</b>.<br>";
				mysql_query("UPDATE person_on SET pr_active=1 WHERE id_person='".$ATTACK_DATA["id"]."' and battle_id=".$bat." and pr_name='krit_max'");
			}
			if (in_Array("jajda",$at_priem))
			{
				$phrase.= "<span class=date>$date</span> <span class=$span1>$attack</span>, $priem_txt <b>Жажда Крови</b>.<br>";
				mysql_query("UPDATE person_on SET pr_active=1 WHERE id_person='".$ATTACK_DATA["id"]."' and battle_id=".$bat." and pr_name='jajda'");
			}
		}
		if($type[1]==0)
		{
			if (in_Array("block",$def_priem))
			{
				$phrase.= "<span class=date>$date</span> <span class=$span2>$defend</span>, $priem_txt <b>Активная защита</b>.<br>";
				mysql_query("UPDATE person_on SET pr_active=1 WHERE id_person='".$DEFEND_DATA["id"]."' and battle_id=".$bat." and pr_name='block'");
			}
			if (in_Array("prikritsa",$def_priem))
			{
				$phrase.= "<span class=date>$date</span> <span class=$span2>$defend</span>, $priem_txt <b>Прикрыться</b>.<br>";
				mysql_query("UPDATE person_on SET pr_active=1 WHERE id_person='".$DEFEND_DATA["id"]."' and battle_id=".$bat." and pr_name='prikritsa'");
			}
			if (in_Array("fullshield",$def_priem))
			{
				$phrase.= "<span class=date>$date</span> <span class=$span2>$defend</span>, $priem_txt <b>Полная защита</b>.<br>";
				mysql_query("UPDATE person_on SET pr_active=1 WHERE id_person='".$DEFEND_DATA["id"]."' and battle_id=".$bat." and pr_name='fullshield'");
			}
			if (in_Array("earth_shield",$def_priem))
			{
				$phrase.= "<span class=date>$date</span> <span class=$span2>$defend</span>, $priem_txt <b>Каменный Щит</b>.<br>";
				mysql_query("UPDATE person_on SET pr_active=1 WHERE id_person='".$DEFEND_DATA["id"]."' and battle_id=".$bat." and pr_name='earth_shield'");
			}
			if (in_Array("protdrob",$def_priem))
			{
				mysql_query("UPDATE person_on SET pr_cur_uses=pr_cur_uses-1 WHERE id_person='".$DEFEND_DATA["id"]."' and battle_id=".$bat." and pr_name='protdrob'");
				$my_res=mysql_fetch_array(mysql_query("SELECT pr_cur_uses FROM person_on WHERE id_person=".$DEFEND_DATA["id"]." and battle_id=".$bat." and pr_name='protdrob'"));
				if ($my_res["pr_cur_uses"]==1)
				mysql_query("UPDATE person_on SET pr_active=1 WHERE id_person='".$DEFEND_DATA["id"]."' and battle_id=".$bat." and pr_name='protdrob'");
			}
			if (in_Array("protkol",$def_priem))
			{
				mysql_query("UPDATE person_on SET pr_cur_uses=pr_cur_uses-1 WHERE id_person='".$DEFEND_DATA["id"]."' and battle_id=".$bat." and pr_name='protkol'");
				$my_res=mysql_fetch_array(mysql_query("SELECT pr_cur_uses FROM person_on WHERE id_person=".$DEFEND_DATA["id"]." and battle_id=".$bat." and pr_name='protkol'"));
				if ($my_res["pr_cur_uses"]==1)
				mysql_query("UPDATE person_on SET pr_active=1 WHERE id_person='".$DEFEND_DATA["id"]."' and battle_id=".$bat." and pr_name='protkol'");
			}
			if (in_Array("protrej",$def_priem))
			{
				mysql_query("UPDATE person_on SET pr_cur_uses=pr_cur_uses-1 WHERE id_person='".$DEFEND_DATA["id"]."' and battle_id=".$bat." and pr_name='protrej'");
				$my_res=mysql_fetch_array(mysql_query("SELECT pr_cur_uses FROM person_on WHERE id_person=".$DEFEND_DATA["id"]." and battle_id=".$bat." and pr_name='protrej'"));
				if ($my_res["pr_cur_uses"]==1)
				mysql_query("UPDATE person_on SET pr_active=1 WHERE id_person='".$DEFEND_DATA["id"]."' and battle_id=".$bat." and pr_name='protrej'");
			}
			if (in_Array("protrub",$def_priem))
			{
				mysql_query("UPDATE person_on SET pr_cur_uses=pr_cur_uses-1 WHERE id_person='".$DEFEND_DATA["id"]."' and battle_id=".$bat." and pr_name='protrub'");
				$my_res=mysql_fetch_array(mysql_query("SELECT pr_cur_uses FROM person_on WHERE id_person=".$DEFEND_DATA["id"]." and battle_id=".$bat." and pr_name='protrub'"));
				if ($my_res["pr_cur_uses"]==1)
				mysql_query("UPDATE person_on SET pr_active=1 WHERE id_person='".$DEFEND_DATA["id"]."' and battle_id=".$bat." and pr_name='protrub'");
			}
		}
	}
	else if(!$blocked)
    {
    	$my_hit=1;
        if($type[1]==0)
        {
	        $hp_all = $DEFEND_DATA["hp_all"];
	        $hp_now = $DEFEND_DATA["hp"];
        }
        else if($type[1]==1)
        {
	        $hp_all = $DEF_DATA["hp_all"];
	        $hp_now = $DEF_DATA["hp"];
        }
		if (in_Array("forcefield7",$def_priem))
		{
			$phrase.= "<span class=date>$date</span> <span class=$span1>$defend</span>, $priem_txt <b>Силовое поле[7]</b> и поглотил <b>$hit_k</b> урон.<br>";
			mysql_query("UPDATE person_on SET hited=hited-$hit_k WHERE id_person='".$DEFEND_DATA["id"]."' and battle_id=".$bat." and pr_name='forcefield7'");
			$my_res=mysql_fetch_array(mysql_query("SELECT hited FROM person_on WHERE id_person=".$DEFEND_DATA["id"]." and battle_id=$bat and pr_name='forcefield7'"));
			if ($my_res["hited"]<=0)
			mysql_query("UPDATE person_on SET pr_active=1 WHERE id_person='".$DEFEND_DATA["id"]."' and battle_id=".$bat." and pr_name='forcefield7'");
			$hit_k=0;
		}
        $hp_new = $hp_now - $hit_k;

        if($hit_k >= $hp_now)
        {
            $hp_new = 0;
            $phrase .= "<span class=sysdate >$date</span> <span class=$span2>$defend</span> $killtext.<BR> ";
            $phrase .= "<script>adh($hit,$bl,'$date',1,'$attack');</script><span class=$span1>$attack</span> $hit_dis_txt $hit_dis[$hit] <span class=$span2>$defend</span> на <span class=hitted title='$txt_hit_type'>-$hit_k</span> [$hp_new/$hp_all]<BR>";
			mysql_query("DELETE FROM `hit_temp` WHERE attack='".$defend."'");
        }
        else
        {
	        $phrase .= "<script>adh($hit,$bl,'$date',1,'$attack');</script><span class=$span1>$attack</span> $hit_dis_txt $hit_dis[$hit] <span class=$span2>$defend</span> на <span class=hitted title='$txt_hit_type'>-$hit_k</span> [$hp_new/$hp_all]<BR>";
        }

        if($type[1]==0)
        {
            mysql_query("UPDATE users SET hp='".$hp_new."',battle_opponent='' WHERE login='".$defend."'");
        }
        else if($type[1] == 1)
        {
			mysql_query("UPDATE bot_temp SET hp='".$hp_new."' WHERE bot_name='".$defend."' AND battle_id='".$battle_id."'");
        }
        
        if($type[0]==0)
        {
			mysql_query("UPDATE teams SET hitted=hitted+$hit_k WHERE player='".$attack."'");
        }
        if($type[0]==1 && $ATT_DATA["zver"]==1)
        {
			mysql_query("UPDATE teams SET hitted=hitted+$hit_k WHERE player=(select login from users where id=".$ATTACK_DATA["owner"].")");
        }
        $udar_priem=1;
        if($type[0]==0)
		{
			if (in_Array("restore",$at_priem) && $ATTACK_DATA["hp"]>0)
			{
				$max_add=array();
				$max_add[6]=30;
				$max_add[7]=60;
				$max_add[8]=90;
				$max_add[9]=120;
				$max_add[10]=150;
				$max_add[11]=180;
				$hp_add=ceil($ATTACK_DATA["hp_all"]*0.15);
				if ($hp_add>$max_add[$ATTACK_DATA["level"]])$hp_add=$max_add[$ATTACK_DATA["level"]];
				$new_hp=$ATTACK_DATA["hp"]+$hp_add;
				if ($new_hp>$ATTACK_DATA["hp_all"]) 
				{
					$new_hp=$ATTACK_DATA["hp_all"];
					$hp_add=$ATTACK_DATA["hp_all"]-$ATTACK_DATA["hp"];
				}	
				setHP($ATTACK_DATA["login"],$new_hp,$ATTACK_DATA['hp_all']);
				$phrase.= "<span class=date>$date</span> <span class=$span1>$attack</span> восстановил здоровье от приема <b>Глухая Защита. <font color=green>+$hp_add</font></b> [".$new_hp."/".$ATTACK_DATA['hp_all']."].<br>";
				mysql_query("UPDATE person_on SET pr_cur_uses=pr_cur_uses-1 WHERE id_person='".$ATTACK_DATA["id"]."' and battle_id=".$bat." and pr_name='restore'");
				$my_res=mysql_fetch_array(mysql_query("SELECT pr_cur_uses FROM person_on WHERE id_person=".$ATTACK_DATA["id"]." and battle_id=$bat and pr_name='restore'"));
				if ($my_res["pr_cur_uses"]==1)
				mysql_query("UPDATE person_on SET pr_active=1 WHERE id_person='".$ATTACK_DATA["id"]."' and battle_id=".$bat." and pr_name='restore'");
			}
			if (in_Array("skiparmor",$at_priem))
			{
				$phrase.= "<span class=date>$date</span> <span class=$span1>$attack</span>, $priem_txt <b>Точный удар</b>.<br>";
				mysql_query("UPDATE person_on SET pr_active=1 WHERE id_person='".$ATTACK_DATA["id"]."' and battle_id=".$bat." and pr_name='skiparmor'");
			}
			if (in_Array("hit",$at_priem))
			{
				$phrase.= "<span class=date>$date</span> <span class=$span1>$attack</span>, $priem_txt <b>Сильный удар</b>.<br>";
				mysql_query("UPDATE person_on SET pr_active=1 WHERE id_person='".$ATTACK_DATA["id"]."' and battle_id=".$bat." and pr_name='hit'");
			}
			if (in_Array("vlomit",$at_priem))
			{
				$phrase.= "<span class=date>$date</span> <span class=$span1>$attack</span>, $priem_txt <b>Вломить</b>.<br>";
				mysql_query("UPDATE person_on SET pr_active=1 WHERE id_person='".$ATTACK_DATA["id"]."' and battle_id=".$bat." and pr_name='vlomit'");
			}

			if (in_Array("strong_hit",$at_priem))
			{
				$phrase.= "<span class=date>$date</span> <span class=$span1>$attack</span>, $priem_txt <b>Мощный удар</b>.<br>";
				mysql_query("UPDATE person_on SET pr_active=1 WHERE id_person='".$ATTACK_DATA["id"]."' and battle_id=".$bat." and pr_name='strong_hit'");
			}
		}
		if($type[1]==0)
		{
			if (in_Array("block",$def_priem))
			{
				$phrase.= "<span class=date>$date</span> <span class=$span2>$defend</span>, $priem_txt <b>Активная защита</b>.<br>";
				mysql_query("UPDATE person_on SET pr_active=1 WHERE id_person='".$DEFEND_DATA["id"]."' and battle_id=".$bat." and pr_name='block'");
			}
			if (in_Array("prikritsa",$def_priem))
			{
				$phrase.= "<span class=date>$date</span> <span class=$span2>$defend</span>, $priem_txt <b>Прикрыться</b>.<br>";
				mysql_query("UPDATE person_on SET pr_active=1 WHERE id_person='".$DEFEND_DATA["id"]."' and battle_id=".$bat." and pr_name='prikritsa'");
			}

			if (in_Array("fullshield",$def_priem))
			{
				$phrase.= "<span class=date>$date</span> <span class=$span2>$defend</span>, $priem_txt <b>Полная защита</b>.<br>";
				mysql_query("UPDATE person_on SET pr_active=1 WHERE id_person='".$DEFEND_DATA["id"]."' and battle_id=".$bat." and pr_name='fullshield'");
			}
			if (in_Array("earth_shield",$def_priem))
			{
				$phrase.= "<span class=date>$date</span> <span class=$span2>$defend</span>, $priem_txt <b>Каменный Щит</b>.<br>";
				mysql_query("UPDATE person_on SET pr_active=1 WHERE id_person='".$DEFEND_DATA["id"]."' and battle_id=".$bat." and pr_name='earth_shield'");
			}
			if (in_Array("protdrob",$def_priem))
			{
				mysql_query("UPDATE person_on SET pr_cur_uses=pr_cur_uses-1 WHERE id_person='".$DEFEND_DATA["id"]."' and battle_id=".$bat." and pr_name='protdrob'");
				$my_res=mysql_fetch_array(mysql_query("SELECT pr_cur_uses FROM person_on WHERE id_person=".$DEFEND_DATA["id"]." and battle_id=".$bat." and pr_name='protdrob'"));
				if ($my_res["pr_cur_uses"]==1)
				mysql_query("UPDATE person_on SET pr_active=1 WHERE id_person='".$DEFEND_DATA["id"]."' and battle_id=".$bat." and pr_name='protdrob'");
			}
			if (in_Array("protkol",$def_priem))
			{
				mysql_query("UPDATE person_on SET pr_cur_uses=pr_cur_uses-1 WHERE id_person='".$DEFEND_DATA["id"]."' and battle_id=".$bat." and pr_name='protkol'");
				$my_res=mysql_fetch_array(mysql_query("SELECT pr_cur_uses FROM person_on WHERE id_person=".$DEFEND_DATA["id"]." and battle_id=".$bat." and pr_name='protkol'"));
				if ($my_res["pr_cur_uses"]==1)
				mysql_query("UPDATE person_on SET pr_active=1 WHERE id_person='".$DEFEND_DATA["id"]."' and battle_id=".$bat." and pr_name='protkol'");
			}
			if (in_Array("protrej",$def_priem))
			{
				mysql_query("UPDATE person_on SET pr_cur_uses=pr_cur_uses-1 WHERE id_person='".$DEFEND_DATA["id"]."' and battle_id=".$bat." and pr_name='protrej'");
				$my_res=mysql_fetch_array(mysql_query("SELECT pr_cur_uses FROM person_on WHERE id_person=".$DEFEND_DATA["id"]." and battle_id=".$bat." and pr_name='protrej'"));
				if ($my_res["pr_cur_uses"]==1)
				mysql_query("UPDATE person_on SET pr_active=1 WHERE id_person='".$DEFEND_DATA["id"]."' and battle_id=".$bat." and pr_name='protrej'");
			}
			if (in_Array("protrub",$def_priem))
			{
				mysql_query("UPDATE person_on SET pr_cur_uses=pr_cur_uses-1 WHERE id_person='".$DEFEND_DATA["id"]."' and battle_id=".$bat." and pr_name='protrub'");
				$my_res=mysql_fetch_array(mysql_query("SELECT pr_cur_uses FROM person_on WHERE id_person=".$DEFEND_DATA["id"]." and battle_id=".$bat." and pr_name='protrub'"));
				if ($my_res["pr_cur_uses"]==1)
				mysql_query("UPDATE person_on SET pr_active=1 WHERE id_person='".$DEFEND_DATA["id"]."' and battle_id=".$bat." and pr_name='protrub'");
			}
		}
    }
	mysql_query("UPDATE battle_units SET all_hit=all_hit+1 ".($my_hit?" ,counter=counter+1":"").($krit_priem?" ,krit=krit+1":"").($udar_priem?", hit=hit+1":"")." WHERE battle_id=$bat and player='".$attack."'");
    mysql_query("UPDATE battle_units SET all_hit=all_hit+1 ".($uvarot_priem?", uvarot=uvarot+1":"").($blok_priem?", block=block+1":"").($parry_priem?", parry=parry+1":"")." WHERE battle_id=$bat and player='".$defend."'");
    battle_log($battle_id, $phrase);
}
/*=======================================================================*/
function isblocked($hit,$blok,$shield)
{
	$matrix=array();
    $matrix1=array(
		array(0,0,0,0,0,0),
		array(0,1,0,0,0,1),
		array(0,1,1,0,0,0),
		array(0,0,1,1,0,0),
		array(0,0,0,1,1,0),
		array(0,0,0,0,1,1),
	);
	$matrix2=array(
		array(0,0,0,0,0,0),
		array(0,1,0,0,1,1),
		array(0,1,1,0,0,1),
		array(0,1,1,1,0,0),
		array(0,0,1,1,1,0),
		array(0,0,0,1,1,1),
	);
	if (!$shield)$matrix=$matrix1;else $matrix=$matrix2;
	if ($matrix[$hit][$blok]==1) {return 1; } else {return 0;}
}
/*===============================УДАР====================================*/
function hit($attack,$defend,$hit1,$hit2,$hit3,$block1,$battle_id,$is_human)
{
	mysql_query("UPDATE battles SET lasthit='".time()."' WHERE id=$battle_id");

	$sql_ = mysql_query("SELECT * FROM hit_temp WHERE attack='".$attack."' AND defend='".$defend."' and battle_id=".$battle_id);
	if(mysql_num_rows($sql_)==0)
	{
		mysql_query("INSERT INTO hit_temp(attack,defend,def_hit1,def_hit2,def_hit3,def_block1,time,battle_id,is_human) VALUES('".$defend."','".$attack."','".$hit1."','".$hit2."','".$hit3."','".$block1."','".time()."','".$battle_id."','".$is_human."')");
		mysql_query("UPDATE users SET battle_opponent='' WHERE login='".$attack."'");
	}
	else
	{
		$SHD=mysql_fetch_array($sql_);
		$zones  = 1;
		$zones1 = 1;
		
		$blockzone	   = false;
		$blockzone1	   = false;

		$weapons = array('axe','fail','knife','sword','spear','shot','staff','kostyl');
		$shields=array('shield','spear');

		if ($is_human==0)
		{	
			$ATTACK_QUERY = mysql_query("SELECT users.id,hand_r_type, hand_l_type,(SELECT count(*) FROM inv WHERE inv.owner=users.login and inv.name='Кольцо Атаки' and wear=1) as item_name FROM users WHERE users.login='".$attack."'");
			$ATTACK_DATA  = mysql_fetch_array($ATTACK_QUERY);
			if(in_array($ATTACK_DATA["hand_r_type"],$weapons) && in_array($ATTACK_DATA["hand_l_type"],$weapons))
			{
				$zones++;
			}
			if ($ATTACK_DATA["item_name"]>0){$zones++;$ring_attack=1;}
			if (in_array($ATTACK_DATA["hand_l_type"],$shields))
			{
				$blockzone = true;
			}
		}
		else if ($is_human==1)
		{
			$SQL_1=mysql_query("SELECT * FROM bot_temp WHERE battle_id='".$battle_id."' and bot_name='".$attack."' limit 1");
			$BOTD1 = mysql_fetch_array($SQL_1);
	        if ($BOTD1["two_hands"]==1)$zones++;
			if ($BOTD1["shield_hands"]==1)$blockzone = true;
		}
		//-------------------------------------------------------------------------------------------------	
		if ($SHD["is_human"]==0)
		{	
			$DEFEND_QUERY = mysql_query("SELECT users.id, hand_r_type,hand_l_type,hp,(SELECT count(*) FROM inv WHERE inv.owner=users.login and inv.name='Кольцо Атаки' and wear=1) as item_name FROM users WHERE users.login='".$defend."'");
			$DEFEND_DATA  = mysql_fetch_array($DEFEND_QUERY);
		
			if(in_array($DEFEND_DATA["hand_r_type"],$weapons) && in_array($DEFEND_DATA["hand_l_type"],$weapons))
			{
				$zones1++;
			}
			if ($DEFEND_DATA["item_name"]>0){$zones1++;$ring_defend=1;}
			if (in_array($DEFEND_DATA["hand_l_type"],$shields))
			{
				$blockzone1 = true;
			}
		}
		else if ($SHD["is_human"]==1)
		{
			$SQL=mysql_query("SELECT * FROM bot_temp WHERE battle_id='".$battle_id."' and bot_name='".$defend."' limit 1");
			$BOTD = mysql_fetch_array($SQL);
	        $DEFEND_DATA["hp"]=$BOTD["hp"];
	        if ($BOTD["two_hands"]==1)$zones1++;
			if ($BOTD["shield_hands"]==1)$blockzone1 = true;
		}
		//-------------------------------------------------------------------------------------------------	

		$def_hit1 = $SHD["def_hit1"];
		$def_hit2 = $SHD["def_hit2"];
		$def_hit3 = $SHD["def_hit3"];
		$def_block1 = $SHD["def_block1"];

		$def_blocked=isblocked($hit1,$def_block1,$blockzone1);
		$att_blocked=isblocked($def_hit1,$block1,$blockzone);
		
		$def_blocked2=isblocked($hit2,$def_block1,$blockzone1);
		$att_blocked2=isblocked($def_hit2,$block1,$blockzone);
		
		$def_blocked3=isblocked($hit3,$def_block1,$blockzone1);
		$att_blocked3=isblocked($def_hit3,$block1,$blockzone);
       	//-------------------------------------------------------------
		if($DEFEND_DATA["hp"]>0)
		{ 
			mysql_query("UPDATE person_on SET pr_wait_for=pr_wait_for-1 WHERE pr_wait_for>0 and battle_id=".$battle_id." and id_person=".$ATTACK_DATA["id"]);
			mysql_query("UPDATE person_on SET pr_wait_for=pr_wait_for-1 WHERE pr_wait_for>0 and battle_id=".$battle_id." and id_person=".$DEFEND_DATA["id"]);
			
			mysql_Query("UPDATE teams SET op_ch=op_ch+1 WHERE player='".$attack."' and op_ch<=0;");
			mysql_Query("UPDATE teams SET op_ch=op_ch+1 WHERE player='".$defend."' and op_ch<=0;");
			if ($zones==1 && $hit1)
			{
		    	hit_dis($attack,$defend,$is_human.$SHD["is_human"],$def_blocked,$hit1,0,$def_block1,$blockzone1,$battle_id);
		    }
	    	else if($zones==2 && $hit1 && $hit2)
	        {
		    	hit_dis($attack,$defend,$is_human.$SHD["is_human"],$def_blocked,$hit1,0,$def_block1,$blockzone1,$battle_id);
	    		if ($ring_attack)
	    		{	
	    			hit_dis($attack,$defend,$is_human.$SHD["is_human"],$def_blocked2,$hit2,0,$def_block1,$blockzone1,$battle_id);
	    		}
	    		else 
	    		{
	    			hit_dis($attack,$defend,$is_human.$SHD["is_human"],$def_blocked2,$hit2,1,$def_block1,$blockzone1,$battle_id);
	    		}
			}
			else if($zones==3 && $hit1 && $hit2 && $hit3)
	        {
		    	hit_dis($attack,$defend,$is_human.$SHD["is_human"],$def_blocked,$hit1,0,$def_block1,$blockzone1,$battle_id);
	    		hit_dis($attack,$defend,$is_human.$SHD["is_human"],$def_blocked2,$hit2,1,$def_block1,$blockzone1,$battle_id);
	    		hit_dis($attack,$defend,$is_human.$SHD["is_human"],$def_blocked3,$hit3,0,$def_block1,$blockzone1,$battle_id);
			}
			if($zones1==1 && $def_hit1)
			{
		   	 	hit_dis($defend,$attack,$SHD["is_human"].$is_human,$att_blocked,$def_hit1,0,$block1,$blockzone,$battle_id);
		   	}	
		    else if($zones1==2 && $def_hit1 && $def_hit2)
	        {
		   	 	hit_dis($defend,$attack,$SHD["is_human"].$is_human,$att_blocked,$def_hit1,0,$block1,$blockzone,$battle_id);
		   	 	
		   	 	if ($ring_defend)
				{	
					hit_dis($defend,$attack,$SHD["is_human"].$is_human,$att_blocked2,$def_hit2,0,$block1,$blockzone,$battle_id);
				}
				else
				{
					hit_dis($defend,$attack,$SHD["is_human"].$is_human,$att_blocked2,$def_hit2,1,$block1,$blockzone,$battle_id);
				}
			}
			else if($zones1==3 && $def_hit1 && $def_hit2 && $def_hit3)
	        {
		   	 	hit_dis($defend,$attack,$SHD["is_human"].$is_human,$att_blocked,$def_hit1,0,$block1,$blockzone,$battle_id);
				hit_dis($defend,$attack,$SHD["is_human"].$is_human,$att_blocked2,$def_hit2,1,$block1,$blockzone,$battle_id);
				hit_dis($defend,$attack,$SHD["is_human"].$is_human,$att_blocked3,$def_hit3,0,$block1,$blockzone,$battle_id);
			}
			
			include_once("inc/battle/comment.php");
			$phrase=get_comment();
			$phrase=$phrase."<hr>";
			battle_log($battle_id, $phrase);
		}
	 	mysql_query("DELETE FROM hit_temp WHERE attack='".$attack."' AND defend='".$defend."'");
		mysql_query("UPDATE users SET battle_opponent='' WHERE login='".$attack."'");
	}
}
/*====================win================================================*/
function win($team,$battle)
{
	include "conf.php";
	$date = date("H:i");
	$sql_bat = mysql_query("SELECT zayavka.type, zayavka.clan_id, zayavka.hidden, battles.creator_id FROM `battles` LEFT JOIN zayavka on zayavka.creator=battles.creator_id WHERE battles.id=$battle");
	$B_DAT = mysql_fetch_array($sql_bat);
	mysql_free_result($sql_bat);
	$cr = $B_DAT["creator_id"];
	$zay_type=$B_DAT["type"];
	$hidden=$B_DAT["hidden"];
	
	$bot_battle=array(55,10,80,15,82,33,88);
	$boylar=array(3,4,101,5,6,102,11,7);
	
	$svet_=array(4);
	$tma_=array(2,6);
	$neytral_=array(3);
	
	$gr=array(3,4,101);$gr_perc=0.05;
	$haot=array(5,6,102);$haot_perc=0.1;
	if ($hidden)$haot_perc=0.15;
	
    if (in_array($zay_type,$gr)) $faiz=$faiz+$faiz*$gr_perc;
    if (in_array($zay_type,$haot)) $faiz=$faiz+$faiz*$haot_perc;
    if ($zay_type==23) $faiz=$faiz+2;
    //if ($zay_type==77) $faiz=1.5*$faiz;
    if ($zay_type==11) $faiz=1.5*$faiz;
    
	$lev = 0;
	$lev_a = 0;
	$SSS = mysql_query("SELECT sum(users.level)as level, count(teams.player)as count FROM teams LEFT JOIN users on users.login=teams.player WHERE teams.battle_id='".$cr."' and teams.team='".($team==1?2:1)."'");
	$SD = mysql_fetch_array($SSS);
	$lev = (int)$SD["level"];
	$lev_a=(int)$SD["count"];

	$SSS1 = mysql_query("SELECT sum(users.level)as level, count(bot_temp.prototype)as count FROM bot_temp LEFT JOIN users on users.login=bot_temp.prototype WHERE bot_temp.battle_id='".$battle."' AND team='".($team==1?2:1)."' and zver=0");
	$SD1 = mysql_fetch_array($SSS1);
	$lev = $lev+(int)$SD1["level"];
	$lev_a=$lev_a+(int)$SD1["count"];

	$SSS2 = mysql_query("SELECT sum(zver.level)as level, count(bot_temp.prototype)as count FROM bot_temp LEFT JOIN zver on zver.id=bot_temp.prototype WHERE bot_temp.battle_id='".$battle."' AND team='".($team==1?2:1)."' and zver=1");
	$SD2 = mysql_fetch_array($SSS2);
	$lev = $lev+(int)$SD2["level"];
	$lev_a=$lev_a+(int)$SD2["count"];
	
	if ($lev_a==0) { $lev_a++; }
	$user_level = ceil($lev/$lev_a);

	include ("basehp.php");
	
	$svet=0;$tma=0;
	$winners="";
	$all_winners="";
	$win_array=array();
	$art_array=array();
	$max_hp=0; $max_hp_winner="";
	$T = mysql_query("SELECT hitted,player FROM teams WHERE battle_id='".$cr."' AND over=0 AND team='".$team."'");
	$count_winners=mysql_num_Rows($T);
	while($DATA = mysql_fetch_array($T))
	{
		$monstr_win=0;
		$hitted_win=$DATA["hitted"];
        $player=$DATA["player"];
        $all_winners.=$player.", ";
        
        if ($hitted_win>$max_hp){$max_hp=$hitted_win; $max_hp_winner=$player;}
        
        $WINNER_QUERY_D=mysql_query("SELECT users.*,zver.level as zver_level,zver.energy FROM users LEFT JOIN zver on zver.owner=users.id and zver.sleep=0 WHERE login='".$player."'");
        $WINNER_DATA=mysql_fetch_array($WINNER_QUERY_D);
        mysql_free_result($WINNER_QUERY_D);
		$art_array[]=$player;
		if ($WINNER_DATA["hp"]>0 && $WINNER_DATA["orden"]!=5)
		{
			$winners.="<b>".$player."</b>, ";
			if ($hitted_win>5000){$win_array[]=$player;}
		}
		if ($WINNER_DATA["zver_on"] && $WINNER_DATA["zver_level"]<$WINNER_DATA["level"] && $WINNER_DATA["zver_level"]<10)
		{
			$exp_minus = rand(1,4);
			if($WINNER_DATA["energy"]<$exp_minus)
			{
				$exp_minus = rand(1,$WINNER_DATA["energy"]);
			}
			$zver_oput=(int)($exp_table_bot[$WINNER_DATA["zver_level"]]*$faiz);
			if (in_array($zay_type,$bot_battle))$zver_oput=($WINNER_DATA["zver_level"]+1)*3*$faiz;
			mysql_query("UPDATE zver SET energy=energy-$exp_minus,exp=exp+".$zver_oput." WHERE owner=".$WINNER_DATA["id"]." and sleep=0");
			$ms="Опыт зверя увеличился на <b>".$zver_oput."</b>.".(($faiz>1 && $zver_oput>0)?" (".($faiz*100)."%)":"");
			if($WINNER_DATA["login"]==$_SESSION["login"])$_SESSION["message"].=$ms;
		}	
		if(in_array($zay_type,$boylar))
		{
			if ($WINNER_DATA['clan']!="")
			{
				mysql_query("UPDATE clan SET ochki=ochki+1 WHERE name='".$WINNER_DATA["clan"]."'");
			}
			if (in_array($WINNER_DATA['orden'],$svet_))$svet++;
			if (in_array($WINNER_DATA['orden'],$tma_))$tma++;
			if (in_array($WINNER_DATA['orden'],$neytral_))$neytral++;
			#new year
			#mysql_Query("INSERT INTO inv (owner, object_id, object_type, object_razdel, gift, gift_author, iznos, iznos_max, term) VALUES('".$WINNER_DATA['login']."', '60', 'scroll', 'magic', '1', 'WWW.MEYDAN.AZ', '0', '1', '".(time()+30*24*3600)."');");
			#if($WINNER_DATA["login"]==$_SESSION["login"])$_SESSION["message"].="Вы нашли <b>Снежок</b>";

			#novruz
			mysql_Query("INSERT INTO inv (owner, object_id, object_type, object_razdel, gift, gift_author, iznos, iznos_max, term) VALUES('".$WINNER_DATA['login']."', '262', 'scroll', 'magic', '1', 'WWW.MEYDAN.AZ', '0', '1', '".(time()+30*24*3600)."');");
			if($WINNER_DATA["login"]==$_SESSION["login"])$_SESSION["message"].="Вы нашли <b>Праздничные яйца</b>";
			
			mysql_Query("INSERT INTO inv (owner, object_id, object_type, object_razdel, iznos, iznos_max) VALUES('".$WINNER_DATA['login']."', '20', 'wood', 'thing', '0', '1');");
			if($WINNER_DATA["login"]==$_SESSION["login"])$_SESSION["message"].="Вы нашли <b>Жетон Падшего Бойца</b>";
		}
		
		if ($zay_type==82)
		{
			//Ледяная пещера
			$monstr_win=1;
			switch ($WINNER_DATA['room'])
			{
				case "labirint_led":$etaj=1;break;
				case "labirint_led2":$etaj=2;break;
			}
			if ($WINNER_DATA['fwd'])
			{
				$gr_id=mysql_fetch_array(mysql_query("SELECT group_id FROM led_login WHERE player='".$WINNER_DATA['login']."'"));
				mysql_query("INSERT INTO led_setting VALUES (null,'".$WINNER_DATA['fwd']."','".$WINNER_DATA['login']."','".$gr_id['group_id']."','".$etaj."','bot','')");
				$count_led=rand(0,2);
				if ($count_led>0)
				{	
					for ($kk=1;$kk<=$count_led;$kk++)
					{
						$item_led=rand(64,68);
						mysql_query("INSERT INTO led_setting VALUES (null,'".$WINNER_DATA['fwd']."','".$WINNER_DATA['login']."','".$gr_id['group_id']."','".$etaj."','items','".$item_led."')");
					}
				}
			}
		}
		
		if ($zay_type==15)
		{
			//Катакомбы
			$monstr_win=1;
			if ($WINNER_DATA['fwd'])
			{
				$sel_=mysql_fetch_array(mysql_query("SELECT battle_id FROM zayavka_teams WHERE player='".$WINNER_DATA['login']."'"));
				mysql_query("INSERT INTO dungeon_bots VALUES ('".$WINNER_DATA['fwd']."','".$WINNER_DATA['login']."','".$sel_['battle_id']."')");
				$counts=rand(1,4);
				if ($counts>0)
				{
					for ($kk=1;$kk<=$counts;$kk++)
					{	
						$items=rand(52,63);
						mysql_query("INSERT INTO predmet (creator, cord, object_id, type) VALUES ('".$sel_['battle_id']."','".$WINNER_DATA['fwd']."','".$items."','wood')");
					}
				}
			}
		}
		if ($zay_type==13 || $zay_type==77)
		{
			$winner_clan=$WINNER_DATA["clan_short"];
			$winner_clan_name=$WINNER_DATA["clan"];
		}
		if ($zay_type==33)
		{
			//Проклеенный Клад
			$monstr_win=1;
			switch ($WINNER_DATA['room'])
			{
				case "crypt":$etaj=1;break;
				case "crypt_floor2":$etaj=2;break;
			}
			if ($WINNER_DATA['fwd'])
			{
				$gr_id=mysql_fetch_array(mysql_query("SELECT group_id FROM z_login WHERE player='".$WINNER_DATA['login']."'"));
				mysql_query("INSERT INTO crypt_setting VALUES (null,'".$WINNER_DATA['fwd']."','".$WINNER_DATA['login']."','".$gr_id['group_id']."','".$etaj."','bot','')");
				$counts=rand(0,3);
				if ($counts>0)
				{
					if ($etaj==1)
					{
						$item_array=array(84,85,86,87,88,89,94,95,96,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117);
						mysql_query("INSERT INTO crypt_setting VALUES (null,'".$WINNER_DATA['fwd']."','".$WINNER_DATA['login']."','".$gr_id['group_id']."','".$etaj."','items','".mt_rand(84,89)."')");
					}
					else if ($etaj==2)
					{
						$have_qwest=mysql_fetch_Array(mysql_query("SELECT * FROM qwest WHERE owner='".$WINNER_DATA["id"]."' and status=0"));
						if ($have_qwest)
						{
							$item_array=array();
							$item_array[]=$have_qwest["item1"];
							if ($have_qwest["item2"])$item_array[]=$have_qwest["item2"];
							if ($have_qwest["item3"])$item_array[]=$have_qwest["item3"];
						}
					}
					for ($kk=1;$kk<=$counts;$kk++)
					{
						if ($etaj==1)
						{
							$all_res=rand(1,5);
							if ($all_res==1)$items=rand(91,93);
							else $items=$item_array[rand(0,count($item_array)-1)];
						}
						else if ($etaj==2)
						{
							$items=$item_array[rand(0,count($item_array)-1)];
						}
						if ($items)mysql_query("INSERT INTO crypt_setting VALUES (null,'".$WINNER_DATA['fwd']."','".$WINNER_DATA['login']."','".$gr_id['group_id']."','".$etaj."','items','".$items."')");
					}
				}
			}
		}
		if ($zay_type==88)
		{
			//Загадочная пещера
			$monstr_win=1;
			switch ($WINNER_DATA['room'])
			{
				case "izumrud_floor":$etaj=1;break;
				case "izumrud_floor2":$etaj=2;break;
			}
			if ($WINNER_DATA['fwd'])
			{
				$gr_id=mysql_fetch_array(mysql_query("SELECT group_id FROM izumrud_login WHERE player='".$WINNER_DATA['login']."'"));
				mysql_query("INSERT INTO izumrud_setting VALUES (null,'".$WINNER_DATA['fwd']."','".$WINNER_DATA['login']."','".$gr_id['group_id']."','".$etaj."','bot','')");
				$counts=rand(0,3);
				if ($counts>0)
				{
					if ($etaj==1)
					{
						$item_array=array(142,143,144,145,146,147);
					}
					else if ($etaj==2)
					{
						$item_array=array(1);
					}
					for ($kk=1;$kk<=$counts;$kk++)
					{
						if ($etaj==1)
						{
							$items=$item_array[rand(0,count($item_array)-1)];
						}
						else if ($etaj==2)
						{
							$items=$item_array[rand(0,count($item_array)-1)];
						}
						if ($items)mysql_query("INSERT INTO izumrud_setting VALUES (null,'".$WINNER_DATA['fwd']."','".$WINNER_DATA['login']."','".$gr_id['group_id']."','".$etaj."','items','".$items."')");
					}
				}
			}
		}
		$vip_bonus=0;
        $vip_text="";
		
        $add_exp = (($exp_table[$user_level]*$hitted_win)/100)*($WINNER_DATA["orden"]==5?0.2:1);
        $w_exp=$add_exp;
        
        if ($zay_type==15){$w_exp=$w_exp/3;$monstr_win=1;}
        else if (in_array($zay_type,$bot_battle)){$w_exp=$WINNER_DATA["level"]*10;$monstr_win=1;}
        if ($w_exp>$max_exp[$WINNER_DATA["level"]])$w_exp=$max_exp[$WINNER_DATA["level"]];
        if ($WINNER_DATA["vip"]>time())
        {
        	$vip_bonus=ceil($w_exp*0.5);
        	$vip_text="<b>VIP Бонус</b> + $vip_bonus опыта. ";
        }
        $w_exp=$w_exp+$vip_bonus;
        $w_exp=$w_exp*$faiz;
        if ($zay_type==19)
		{
			//Таинственный Маяк
			mysql_Query("UPDATE hellround_pohod SET `end` = 1, `date_out` = ".time()." WHERE `end` = 0 and `owner`=".$WINNER_DATA["id"].";");
			$w_exp=0;
			$monstr_win=1;
        }
        
        $w_exp=ceil($w_exp);
        //-------give money-------------------------
		$give_money=rand(5,80);
		//Групповые: с оружием
		$str_money=((($zay_type==4 || $zay_type==5) && $WINNER_DATA["orden"]!=5)?$give_money:0);
		$text=($str_money?"Вы нашли <b>".sprintf ("%01.2f", $give_money)." Зл.</b> у убитого бойца.":"");
		//------------------------------------------
        mysql_query("UPDATE users SET battle='0', ".($zay_type==11?"doblest=doblest+5,":"").($monstr_win?"monstr=monstr+1,":"win=win+1,")." money=money+$str_money, exp=exp+$w_exp, zver_on=0, zayavka=0, battle_opponent='', battle_pos='', battle_team='', fwd='' WHERE login='".$player."'");
		$wintext="Бой окончен! Вы выиграли бой. Всего вами нанесено: <b>".$hitted_win." HP</b>. Получено опыта: <b>".$w_exp."</b>".(($faiz>1 && $w_exp>0)?' ('.($faiz*100).'%)':'').". ".$vip_text.$text;
		if($WINNER_DATA["login"]==$_SESSION["login"])$_SESSION["message"].=$wintext;
   		//---------хп при победе--------------
        if ($WINNER_DATA["level"]<4) setHP($WINNER_DATA['login'],$WINNER_DATA["hp_all"],$WINNER_DATA["hp_all"]);
        else setHP($WINNER_DATA['login'],$WINNER_DATA["hp"],$WINNER_DATA["hp_all"]);
        setMN($WINNER_DATA['login'],$WINNER_DATA["mana"],$WINNER_DATA["mana_all"]);
	}
	mysql_query("UPDATE teams SET over = 1 WHERE battle_id='".$cr."' and team=$team");

	if ($count_winners>20)
	{
		say("toall","Бой закончен. Благодаря величайшим воинам ".$winners."! Победа за <i>".$all_winners."</i>","bor");
		$co_arr=count($win_array);
		for ($i=0;$i<$co_arr;$i++)
		{	
			$user=$win_array[$i];
			mysql_query("UPDATE users SET money=money+101 WHERE login='".$user."'");
			if($user==$_SESSION["login"])$_SESSION["message"].="Вы нашли <b>101.00 Зл.</b> у убитого бойца.";
		}
	}
	
	if ($zay_type==23) 
	{
		shuffle($art_array);
		$art_winner=$art_array[0];
		if ($art_winner && $art_winner!="Исчадие Хаоса")
		{
			mysql_query("INSERT INTO inv (owner,object_type,object_id) VALUES ('".$art_winner."','wood',23);");
			if ($max_hp_winner && $max_hp_winner!=$art_winner)
			{
				mysql_query("INSERT INTO inv (owner,object_type,object_id) VALUES ('".$max_hp_winner."','wood',23);");
			}
			say("toall_news","<font color=#ff0000>Внимание! <b>$art_winner</b> $str_art_winner нашел чек на АРТ. Обналичит чек на АРТ можна у <b>Торговец Вискаль</b></font>","bor");
		}
	}
	if ($zay_type==13)
	{
		mysql_query("TRUNCATE TABLE `castle_config`");
		mysql_query("INSERT INTO castle_config SET owner = '".$winner_clan."'");
		mysql_query("UPDATE clan SET kazna = kazna + 3000,level=level+1 WHERE name_short = '".$winner_clan."'");
		mysql_query("UPDATE castle_log SET winner = '".$winner_clan."' WHERE battle_log = '".$battle."'");
		say("toall_news","<font color=#ff0000>Внимание! Битва за Башню завершилась. Победил Ханства <b>".$winner_clan_name."</b></font>","bor");
	}
	if ($zay_type==11)
	{
		$phrase= "<span class=date>$date</span> ... и победители стали калечить проигравших...<BR>";
		battle_log($battle, $phrase);
		mysql_query("UPDATE align SET svet=svet+".($svet>0?1:0).", tma=tma+".($tma>0?1:0).", neytral=neytral+".($neytral>0?1:0));
		if ($svet>0)	{say("toall_news","<font color=#ff0000>Бой СВЕТ VS TЬМА закончен. <b>Победил Свет</b></font>","bor");}
		else if ($tma>0) {say("toall_news","<font color=#ff0000>Бой СВЕТ VS TЬМА закончен. <b>Победила Тьма</b></font>","bor");}
		else {say("toall_news","<font color=#ff0000>Бой СВЕТ VS TЬМА закончен. Ничья</font>","bor");}
	}
	if ($zay_type==66)
	{
		$s_ql=mysql_fetch_Array(mysql_query("SELECT * FROM bot_temp WHERE prototype='Рыцарь Смерти' and team=$team"));
		if (!$s_ql[0])
		{	
			mysql_query("INSERT INTO bs_objects (type) VALUES (3);");
			mysql_query("INSERT INTO bs_objects (bs_id,coord,type) VALUES (24,'19x11',4);");
			mysql_query('UPDATE `deztow_turnir` SET `log` = CONCAT(`log`,\''."<span class=date>".date("d.m.y H:i")."</span> <b>Рыцарь Смерти</b> повержен и выбывает из турнира<BR>".'\') WHERE `active` = TRUE');
		}
	}
	if ($zay_type==77)
	{
		$c_b=mysql_fetch_Array(mysql_query("SELECT * FROM clan_battle WHERE id=".$B_DAT["clan_id"]));
		if ($c_b)
		{	
			if ($winner_clan==$c_b["attacker"])$str="win=win+1"; else $str="lose=lose+1";
			mysql_query("UPDATE clan_battle SET ".$str." WHERE id=".$B_DAT["clan_id"]);
		}
	}
}

/*========================lose===========================================*/
function lose($team,$battle,$phrase)
{
	$date = date("H:i");
	$sql_bat = mysql_query("SELECT zayavka.type,battles.creator_id FROM `battles` LEFT JOIN zayavka on zayavka.creator=battles.creator_id WHERE battles.id=$battle");
	$B_DAT = mysql_fetch_array($sql_bat);
	mysql_free_result($sql_bat);
	$cr = $B_DAT["creator_id"];
	$zay_type=$B_DAT["type"];
	$boylar=array(3,4,101,5,6,102,11);
	
	$T = mysql_query("SELECT player,hitted FROM teams WHERE battle_id='".$cr."' AND over=0 and team='".$team."'");
	while($DATA = mysql_fetch_array($T))
	{
        $player = $DATA["player"];
        $hitted_win=$DATA["hitted"];
		if ($zay_type==15)
		{
			mysql_query('UPDATE labirint SET location="29x15", vector="180" WHERE user_id="'.$player.'"');
		}	
		if ($zay_type==88)
		{
			mysql_query('UPDATE labirint SET location="29x2", vector="180", lose=lose+1 WHERE user_id="'.$player.'"');
		}
        //-------------------------------------------------------------------------------------
        $LOSER_QUERY_D=mysql_query("SELECT users.*,zver.energy FROM users LEFT join zver on zver.owner=users.id and zver.sleep=0 WHERE login='".$player."'");
        $LOSER_DATA=mysql_fetch_array($LOSER_QUERY_D);
        mysql_free_result($LOSER_QUERY_D);
        $objects = array();
        $objects[0] = $LOSER_DATA["amulet"];
        $objects[1] = $LOSER_DATA["hand_r"];
        $objects[2] = $LOSER_DATA["armour"];
        $objects[3] = $LOSER_DATA["poyas"];
        $objects[4] = $LOSER_DATA["ring1"];
        $objects[5] = $LOSER_DATA["ring2"];
        $objects[6] = $LOSER_DATA["ring3"];
        $objects[7] = $LOSER_DATA["helmet"];
        $objects[8] = $LOSER_DATA["perchi"];
        $objects[9] = $LOSER_DATA["hand_l"];
        $objects[10] = $LOSER_DATA["boots"];
		$objects[11] = $LOSER_DATA["naruchi"];
        $objects[12] = $LOSER_DATA["rubaxa"];
        $objects[13] = $LOSER_DATA["plash"];
        $objects[14] = $LOSER_DATA["mask"];
		$objects[15] = $LOSER_DATA["pants"];

        $damage = 0;
        shuffle($objects);
        foreach($objects as $key => $value) 
        {
			if($value==0) 
			{
				unset($objects[$key]);
			}
		}
		$new_array = array_values($objects);
		$damage = $new_array[0];
		if($damage!=0)
        {
        	$GET_F_INV=mysql_query("SELECT paltar.name,inv.iznos_max,inv.iznos FROM inv LEFT JOIN paltar on paltar.id=inv.object_id WHERE inv.id=".$damage);
	        $GET_D = mysql_fetch_array($GET_F_INV);
	        mysql_free_result($GET_F_INV);
	        $iznos_all = $GET_D["iznos_max"];
	        $iznos = $GET_D["iznos"]+1;
	        $obj_name=$GET_D["name"];

	        $krit_iznos=$iznos_all-2;

            if($iznos>=$krit_iznos && $iznos<$iznos_all)
            {
            	if($LOSER_DATA["login"]==$_SESSION["login"])$_SESSION["message"].="Предмет <b>".$obj_name."</b> в критическом состоянии!<br/><small>(на правах рекламы) <b>Ремонтная мастерская</b>. Мы даем вторую жизнь старым вещам!</small>";
            }
            
            if($iznos<=$iznos_all)
            {
            	mysql_query("UPDATE inv SET iznos =iznos+1 WHERE id = '".$damage."'");
            }
			if ($iznos_all==1)
			{
				unWear($player,$damage);
            	mysql_query("DELETE FROM inv WHERE id='".$damage."'");
                history($player,'Пришел в негодность',$obj_name,$LOSER_DATA["remote_ip"],"Бой ".$battle);
				if($LOSER_DATA["login"]==$_SESSION["login"])$_SESSION["message"].="Предмет <b>".$obj_name."</b> сломался";
			}
			else if($iznos==$iznos_all)
            {
            	unWear($player,$damage);
            	if($LOSER_DATA["login"]==$_SESSION["login"])$_SESSION["message"].="Предмет <b>".$obj_name."</b> нуждается в ремонте!<BR><small>(на правах рекламы) <b>Ремонтная мастерская</b>. Мы даем вторую жизнь старым вещам!</small>";
			}
		}
		if ($zay_type==29)
		{
			#Пещера Воинов
			mysql_query("UPDATE users SET zayava=0 WHERE login='".$player."'");
			mysql_query("UPDATE war_team SET lose=1 WHERE player='".$player."'");
			say("toroom","<b>$player</b> трагически погиб и покидает турнир.",$player);
		}
		if ($zay_type==99 || $zay_type==66)
		{
			mysql_query("UPDATE users SET bs=0,location='', vector='' WHERE login='".$player."'");
			$str="<span class=date>".date("d.m.y H:i")."</span> <script>drwfl('".$LOSER_DATA['login']."','".$LOSER_DATA['id']."','".$LOSER_DATA['level']."','".$LOSER_DATA['dealer']."','".$LOSER_DATA['orden']."','".$LOSER_DATA['admin_level']."','".$LOSER_DATA['clan_short']."','".$LOSER_DATA['clan']."');</script> повержен и выбывает из турнира<BR>";
			mysql_query('UPDATE `deztow_turnir` SET `log` = CONCAT(`log`,"'.$str.'") WHERE `active` = TRUE');
			mysql_Query("DELETE FROM labirint WHERE user_id='".$player."'");
			mysql_Query("UPDATE bs_objects SET bs=0,owner='',coord='".$LOSER_DATA["location"]."' WHERE owner='".$player."'");
			mysql_query("DELETE FROM inv WHERE owner='".$player."' and object_razdel='thing' and object_id=24 LIMIT 1");
			say("toroom","<b>$player</b> трагически погиб и покидает турнир.",$player);
		}
		if ($zay_type==19)
		{
			//Таинственный Маяк
			$have_hell=mysql_fetch_Array(mysql_Query("SELECT * FROM hellround_pohod WHERE `end` = 0 and `owner`=".$LOSER_DATA["id"].";"));
			$count_wood=$have_hell["volna"];
			for($i=0; $i<$count_wood; $i++) 
			{
				mysql_query("INSERT INTO `inv` (`owner`, `object_id`, `object_type`, `object_razdel` ,`iznos`, `iznos_max`) VALUES ('".$LOSER_DATA['login']."', '139','wood','thing','0','1');");
			}
			$count_redkiy=$have_hell["unikal_count"]-1;
			if ($count_redkiy>0)
			{
				for($i=0; $i<$count_redkiy; $i++)
				{
					mysql_query("INSERT INTO `inv` (`owner`, `object_id`, `object_type`, `object_razdel` ,`iznos`, `iznos_max`) VALUES ('".$LOSER_DATA['login']."', '140','wood','thing','0','1');");
				}
				$str_redkiy="<b>Редкий Образец</b> x$count_redkiy.";
			}
			say("toroom","<b>".$LOSER_DATA['login']."</b> создал предмет <b>Образец</b> x$count_wood. $str_redkiy",$LOSER_DATA['login']);
			mysql_Query("UPDATE hellround_pohod SET `end` = 1, `date_out` = ".time()." WHERE `end` = 0 and `owner`=".$LOSER_DATA["id"].";");
        }
        if(in_array($zay_type,$boylar))
		{
			#new year
			#mysql_Query("INSERT INTO inv (owner, object_id, object_type, object_razdel, gift, gift_author, iznos, iznos_max, term) VALUES('".$LOSER_DATA['login']."', '60', 'scroll', 'magic', '1', 'WWW.MEYDAN.AZ', '0', '1', '".(time()+30*24*3600)."');");
			#if($LOSER_DATA["login"]==$_SESSION["login"])$_SESSION["message"].="Вы нашли <b>Снежок</b>";
			
			#novruz
			mysql_Query("INSERT INTO inv (owner, object_id, object_type, object_razdel, gift, gift_author, iznos, iznos_max, term) VALUES('".$LOSER_DATA['login']."', '262', 'scroll', 'magic', '1', 'WWW.MEYDAN.AZ', '0', '1', '".(time()+30*24*3600)."');");
			if($LOSER_DATA["login"]==$_SESSION["login"])$_SESSION["message"].="Вы нашли <b>Праздничные яйца</b>";
		}
		if ($LOSER_DATA["zver_on"])
		{
			$exp_minus = rand(1,4);
			if($LOSER_DATA["energy"]<$exp_minus)
			{
				$exp_minus = rand(1,$LOSER_DATA["energy"]);
			}
			mysql_query("UPDATE zver SET energy=energy-$exp_minus WHERE owner=".$LOSER_DATA["id"]." and sleep=0 ");
		}	
    	$krov=array("100","101","102","11");
    	if(in_array($zay_type,$krov))
        {
        	$travm=rand(1,3);
        	getTravm($player,$travm);
        	include "inc/battle/travm_dis.php";
			$travm_dis = array();
            $travm_dis[1] = $ushib_d_h[rand(0,count($ushib_d_h)-1)];
            $travm_dis[2] = $ushib_d_c[rand(0,count($ushib_d_c)-1)];
            $travm_dis[3] = $ushib_d_l[rand(0,count($ushib_d_l)-1)];
        	$phrase= "<span class=date>$date</span> <B>".$player."</B> получил повреждение: <font color=red>".$travm_dis[$travm]."</font>.<BR>";
	        battle_log($battle, $phrase);
        }
        if($zay_type==20)
        {
        	getTravm($player,4);
        	$phrase = "<span class=date>$date</span> <B>".$player."</B> получил повреждение: <font color=red>Неличимая травма</font>.<BR>";
	        battle_log($battle, $phrase);
        }
        if($phrase == 0)
        {
			if($LOSER_DATA["login"]==$_SESSION["login"])$_SESSION["message"].="Бой окончен! Вы проиграли бой. Всего вами нанесено: <b>".$hitted_win." HP</b>. Получено опыта: <b>0</b>.";
        }
        else if($phrase == 1)
        {
			if($LOSER_DATA["login"]==$_SESSION["login"])$_SESSION["message"].="Бой окончен! Ничья!. Всего вами нанесено: <b>".$hitted_win." HP</b>. Получено опыта: <b>0</b>.";        	
        }
        else if($phrase == 2)
        {
        	$travm=rand(1,3);
        	getTravm($player,$travm);
        	include "inc/battle/travm_dis.php";
			$travm_dis = array();
            $travm_dis[1] = $ushib_d_h[rand(0,count($ushib_d_h)-1)];
            $travm_dis[2] = $ushib_d_c[rand(0,count($ushib_d_c)-1)];
            $travm_dis[3] = $ushib_d_l[rand(0,count($ushib_d_l)-1)];;

        	$phrase = "<span class=date>$date</span> <B>".$player."</B> получил повреждение: <font color=red>".$travm_dis[$travm]."</font>.<BR>";
	        battle_log($battle, $phrase);
			if($LOSER_DATA["login"]==$_SESSION["login"])$_SESSION["message"].="Бой окончен! Вы проиграли бой. Всего вами нанесено: <b>".$hitted_win." HP</b>. Получено опыта: <b>0</b>.";
        }
        else if($phrase == 11)
        {
			if($LOSER_DATA["login"]==$_SESSION["login"])$_SESSION["message"].="Бой окончен! Ничья!. Всего вами нанесено: <b>".$hitted_win." HP</b>. Получено опыта: <b>0</b>.";        	
		}
		$all_hp=$LOSER_DATA["hp_all"];
		if ($LOSER_DATA["level"]<4) setHP($player,$all_hp,$all_hp);
		else setHP($player,'0',$all_hp);
        $cur_m = $LOSER_DATA["mana"];
        $all_m = $LOSER_DATA["mana_all"];
        setMN($player,$cur_m,$all_m);
	}
	mysql_query("UPDATE users,(SELECT player FROM teams WHERE battle_id='".$cr."' AND team='".$team."') as upd SET battle='0', ".(($phrase == 1||$phrase == 11)?"nich=nich+1":"lose=lose+1").", zayavka=0, battle_opponent='', battle_pos='', battle_team='',fwd='',zver_on=0,oslab=".(time()+5*60)." WHERE login=upd.player");
	mysql_query("UPDATE teams SET over = 1 WHERE battle_id='".$cr."' and team=$team");
}

/*=================clear Zayavka=========================================*/
function clearZayavka($creator,$bid)
{
	$B_DAT = mysql_fetch_array(mysql_query("SELECT zayavka.type, battles.win, battles.logs FROM `battles` LEFT JOIN zayavka on zayavka.creator=battles.creator_id WHERE battles.id=$bid"));
	if ($B_DAT)
	{
		$win = $B_DAT["win"];
		$zay_type=$B_DAT["type"];
	    $T = mysql_query("SELECT users.id as ids,login,level,orden, admin_level,dealer,clan,clan_short,remote_ip,t.hitted,t.team FROM users,(SELECT ip,hitted,player,team FROM teams WHERE battle_id='".$creator."') as t WHERE users.login=t.player");
	    while($TD = mysql_fetch_array($T))
	    {
	    	$ids=$TD['ids'];
	    	$login=$TD['login'];
	    	$level=$TD['level'];
	    	$orden=$TD['orden'];
	    	$admin_level=$TD['admin_level'];
	    	$dealer=$TD['dealer'];
	    	$clan=$TD['clan'];
	    	$clan_short=$TD['clan_short'];
	    	$ip=$TD['remote_ip'];
	    	$hitted=$TD['hitted'];
	    	$team=$TD['team'];
	        mysql_query("INSERT INTO team_history(ids,login,level,orden,admin_level,dealer,clan,clan_short,ip,hitted,battle_id,team,win,type) VALUES('".$ids."','".$login."','".$level."','".$orden."','".$admin_level."','".$dealer."','".$clan."','".$clan_short."','".$ip."','".$hitted."','".$bid."','".$team."','".$win."','".$zay_type."')");
	    }
		$BOT = mysql_query("SELECT users.id as ids,bot.bot_name,level,orden,admin_level,dealer,clan,clan_short,bot.team FROM users,(SELECT * FROM bot_temp WHERE battle_id='$bid' and zver=0) as bot WHERE users.login=bot.prototype");
		while ($BOTD = mysql_fetch_array($BOT))
		{
			$ids=$BOTD['ids'];
	    	$bot_name=$BOTD['bot_name'];
	    	$level=$BOTD['level'];
	    	$orden=$BOTD['orden'];
	    	$admin_level=$BOTD['admin_level'];
	    	$dealer=$BOTD['dealer'];
	    	$clan=$BOTD['clan'];
	    	$clan_short=$BOTD['clan_short'];
	    	$ip="none";
	    	$hitted=$BOTD['hitted'];
			$team=$BOTD["team"];
	        mysql_query("INSERT INTO team_history(ids,login,level,orden,admin_level,dealer,clan,clan_short,ip,hitted,battle_id,team,win,type) VALUES('".$ids."','".$bot_name."','".$level."','".$orden."','".$admin_level."','".$dealer."','".$clan."','".$clan_short."','".$ip."','0','".$bid."','".$team."','".$win."','".$zay_type."')");
		}
		$BOT_ZVER = mysql_query("SELECT zver.id as ids,bot.bot_name,level,orden,admin_level,dealer,clan,clan_short,bot.team FROM zver,(SELECT * FROM bot_temp WHERE battle_id='$bid' and zver=1) as bot WHERE zver.id=bot.prototype");
		while ($BOTD_Z = mysql_fetch_array($BOT_ZVER))
		{
			$ids=$BOTD_Z['ids'];
	    	$bot_name=$BOTD_Z['bot_name'];
	    	$level=$BOTD_Z['level'];
	    	$orden=$BOTD_Z['orden'];
	    	$admin_level=$BOTD_Z['admin_level'];
	    	$dealer=$BOTD['dealer'];
	    	$clan=$BOTD_Z['clan'];
	    	$clan_short=$BOTD_Z['clan_short'];
	    	$ip="none";
	    	$hitted=$BOTD_Z['hitted'];
			$team=$BOTD_Z["team"];
	        mysql_query("INSERT INTO team_history(ids,login,level,orden,admin_level,dealer,clan,clan_short,ip,hitted,battle_id,team,win,type) VALUES('".$ids."','".$bot_name."','".$level."','".$orden."','".$admin_level."','".$dealer."','".$clan."','".$clan_short."','".$ip."','0','".$bid."','".$team."','".$win."','".$zay_type."')");
		}
		mysql_query("INSERT INTO battles_archive(id, type, win, status, creator_id, logs) VALUES(\"".$bid."\", \"".$zay_type."\", \"".$win."\", \"finished\", \"".$creator."\", \"".$B_DAT["logs"]."\")");
		mysql_query("DELETE FROM hit_temp WHERE battle_id='".$bid."'");
		mysql_query("DELETE FROM battles WHERE id='".$bid."'");
		mysql_query("DELETE FROM battles WHERE creator_id='".$creator."'");
		if($bid)mysql_query("DELETE FROM effects WHERE battle_id = '".$bid."'");
		mysql_query("DELETE FROM battle_units WHERE battle_id = '".$bid."'");
		mysql_query("DELETE FROM teams WHERE battle_id = '".$creator."'");
		mysql_query("DELETE FROM zayavka WHERE creator = '".$creator."'");
		mysql_query("DELETE FROM bot_temp WHERE battle_id='".$bid."'");
		mysql_query("DELETE FROM person_on WHERE battle_id='".$bid."'");
	}
}
/*==========Battle Log====================================================*/
function battle_log($battle_id, $battle_txt)
{
	mysql_query("UPDATE battles SET `logs` = CONCAT(`logs`,\"".$battle_txt."\") WHERE id=$battle_id");
}
/*==========go battle====================================================*/
function goBattle($who)
{
	$SQL = mysql_query("SELECT teams.*, users.level, users.duxovnost FROM teams LEFT JOIN users on users.login=teams.player WHERE player='".$who."'");
    $DATA = mysql_fetch_array($SQL);
    if ($DATA)
    {
    	$level=ceil($DATA["level"]/2+5)+$DATA["duxovnost"];
		$creator = $DATA["battle_id"];
		$team = $DATA['team'];
		$B_SQL = mysql_query("SELECT * FROM battles WHERE creator_id='".$creator."'");
		$B_DATA = mysql_fetch_array($B_SQL);
		if (!$B_DATA)
		{
			$Z_SQL = mysql_query("SELECT * FROM zayavka WHERE creator=$creator");
			$Z_DATA = mysql_fetch_array($Z_SQL);
			$type = $Z_DATA["type"];
			$timeout = time()+$Z_DATA["timeout"]*60;
			mysql_query("INSERT INTO battles(type, creator_id, lasthit) VALUES('".$type."', '".$creator."', '".$timeout."')");
			$b_id=mysql_insert_id();
			mysql_query("UPDATE users SET zayavka=1,battle='".$b_id."',battle_team='".$team."',battle_pos='".$creator."' WHERE login='".$who."'");
		}
		else
		{
			$b_id = $B_DATA["id"];
			mysql_query("UPDATE users SET zayavka=1,battle='".$b_id."',battle_team='".$team."',battle_pos='".$creator."' WHERE login='".$who."'");
		}
		mysql_query("INSERT INTO battle_units(battle_id,player,hp) VALUES('".$b_id."','".$who."','".$level."')");

		$team1_p="";$team2_p="";
		
		$T_SQL = mysql_query("SELECT * FROM teams WHERE battle_id=$creator");
		while($T_DATA = mysql_fetch_array($T_SQL))
		{
	        if ($T_DATA["team"]==1)
	        {	
	        	$team1_p.=$comma1.$T_DATA["player"];
	        	$comma1=", ";
	        }
	        else 
	        {	
	        	$team2_p.=$comma2.$T_DATA["player"].", ";
	        	$comma2=", ";
	        }
		}
		$comma1="";$comma2="";
		$TBOT_SQL = mysql_query("SELECT * FROM bot_temp WHERE battle_id='".$b_id."'");
		while ($TBOT_DATA = mysql_fetch_array($TBOT_SQL))
		{
			if($TBOT_DATA["team"]==1)
			{
				$team1_p.=$comma1.$TBOT_DATA["bot_name"];
				$comma1=", ";
			}
			else
			{
				$team2_p.=$comma2.$TBOT_DATA["bot_name"];
				$comma2=", ";
			}
		}
		
		$date_s=date("Y-m-d H:i:s");
		$diss=array();
		$diss[0]="На часах было <span class=date>$date_s</span>, когда <b style='color:#000000'>$team1_p</b> и <b style='color:#000000'>$team2_p</b> завязали драку...<hr>";
		$diss[1]="Небо было чистым и ничто не предвещало беды...Но когда часы показали <span class=date>$date_s</span>, <b style='color:#000000'>$team1_p</b> и <b style='color:#000000'>$team2_p</b> принялись варварски избивать друг друга.<hr>";
		$diss[2]="В этот день у скорой помощи было много работы...И в <span class=date>$date_s</span> поступил еще один вызов - <b style='color:#000000'>$team1_p</b> и <b style='color:#000000'>$team2_p</b> начали драться прямо на улице.<hr>";
		$diss[3]="Часы на башне показали <span class=date>$date_s</span>, когда <b style='color:#000000'>$team1_p</b> и <b style='color:#000000'>$team2_p</b> решили разобраться кто из них круче.<hr>";
		$diss[4]="Был обычный солнечный день...Но когда тени от стрелок часов показали <span class=date>$date_s</span>, <b style='color:#000000'>$team1_p</b> и <b style='color:#000000'>$team2_p</b> накинулись друг на друга, так словно не ели три дня.<hr>";
		$diss[5]="<span class=date>$date_s</span> Стая ворон с оглушительным карканьем сорвалась с низкого неба, хлопьями пепла упав на просяное поле; и рука сама нащупала за поясом рукоять меча. Просто так, для успокоения. Страха не было, но ощущение шершавой рукояти под ладонью доставило удовольствие. <b style='color:#000000'>$team1_p</b> и <b style='color:#000000'>$team2_p</b> замерли друг перед другом.<hr>";
		$diss[6]="<span class=date>$date_s</span> Мир ещё не решил, каким ему стать. Он просто плыл по течению, плескался, высматривал берега, наслаждаясь безмятежным покачиванием на волнах времени, изливавшегося теперь из совершенно другого источника. И не было ясно, кто останется в живых <b style='color:#000000'>$team1_p</b> или <b style='color:#000000'>$team2_p</b> ...<hr>";
		$diss[7]="Часы показывали <span class=date>$date_s</span>, когда <b style='color:#000000'>$team1_p</b> и <b style='color:#000000'>$team2_p</b> бросили вызов друг другу...<hr>";
		$diss[8]="Часы показывали <span class=date>$date_s</span>, когда <b style='color:#000000'>$team1_p</b> и <b style='color:#000000'>$team2_p</b> выбежали на арену...<hr>";
		$diss[9]="Часы показывали <span class=date>$date_s</span>, когда <b style='color:#000000'>$team1_p</b> и <b style='color:#000000'>$team2_p</b> вызвались на этот жестокий бой...<hr>";
		$diss[10]="Худой уборщик быстро сбежал со ступенек арены вниз, унося с собой напоминания, оставшиеся от предыдущего боя. Не успел он уйти, как на песок ступили новые бойцы, молча поклонились друг другу и завязалась новая битва.<hr>";
		$diss[11]="Колыхнулось покрывало в бортике арены, и как будто из стены, медленно стали выплывать люди. И какого только оружия они не держали – сразу видно, что идут воины, а не рыбаки или земледельцы. Чинно, не спеша, готовые к поединку повернулись навстречу друг другу, легко кивнули головами и бой начался!<hr>";

		$diss_put=$diss[rand(0,11)];
		battle_log($b_id, $diss_put);
	    Header("Location: battle.php?tmp=".md5(time()));
		//die();
	}
}
//============================================================================//
function startBattle($creator_id)
{
	$zay=mysql_fetch_array(mysql_query("SELECT * FROM zayavka WHERE creator=$creator_id"));
	if ($zay["status"]!=3)
	{
		$timeout = time()+$zay["timeout"]*60;
		mysql_query("UPDATE zayavka SET status='3' WHERE creator=$creator_id");
		mysql_query("INSERT INTO battles(type, creator_id, lasthit) VALUES('".$zay["type"]."', '".$zay["creator"]."', '".$timeout."')");
		$b_id=mysql_insert_id();
		#if ($zay["type"]!=1 && $zay["type"]!=100 && (rand(0,1)==1))mysql_query("INSERT INTO bot_temp(bot_name,hp,hp_all,battle_id,prototype,team,two_hands,shield_hands) VALUES('Снеговик','15000','15000','".$b_id."','Снеговик','".rand(1,2)."','2','0')");//new year
		
		if ($zay["type"]==7)
		{
			include("bot_array.php");
			foreach ($bot_level[$zay["maxlev1"]] as $k => $v) 
			{
			    $bot_prototype=$k;
			    foreach ($v as $t => $tt) 
				{
					$hp_bot=$v["hp"];
					$team_bot=$v["team"];
					$two_hands_bot=$v["bot_two_hands"];
					$shield_hands_bot=$v["bot_shield_hands"];
				}
				mysql_query("INSERT INTO bot_temp(bot_name,hp,hp_all,battle_id,prototype,team,two_hands,shield_hands) VALUES('$bot_prototype','$hp_bot','$hp_bot','".$b_id."','$bot_prototype','$team_bot','$two_hands_bot','$shield_hands_bot')");
			}
		}

		mysql_query("UPDATE users,(SELECT team, player FROM teams WHERE battle_id=".$creator_id.") as upd SET zayavka=1,battle='".$b_id."', battle_team=upd.team, battle_pos='".$creator_id."' WHERE login=upd.player");
		mysql_query("INSERT INTO battle_units(battle_id,player,hp) (SELECT '".$b_id."',users.login,users.level/2+5+users.duxovnost FROM teams LEFT JOIN users on users.login=teams.player WHERE teams.battle_id='".$creator_id."')");
		$query_sql=mysql_query("SELECT group_concat(player) as players,team FROM `teams` WHERE battle_id=".$creator_id." GROUP by team");
		while ($query=mysql_fetch_array($query_sql))
		{
			if ($query["team"]==1)$team1_p=$query["players"];
			else if ($query["team"]==2)$team2_p=$query["players"];
		}
		$date_s=date("Y-m-d H:i:s");
		$diss=array();
		$diss[0]="На часах было <span class=date>$date_s</span>, когда <b style='color:#000000'>$team1_p</b> и <b style='color:#000000'>$team2_p</b> завязали драку...<hr>";
		$diss[1]="Небо было чистым и ничто не предвещало беды...Но когда часы показали <span class=date>$date_s</span>, <b style='color:#000000'>$team1_p</b> и <b style='color:#000000'>$team2_p</b> принялись варварски избивать друг друга.<hr>";
		$diss[2]="В этот день у скорой помощи было много работы...И в <span class=date>$date_s</span> поступил еще один вызов - <b style='color:#000000'>$team1_p</b> и <b style='color:#000000'>$team2_p</b> начали драться прямо на улице.<hr>";
		$diss[3]="Часы на башне показали <span class=date>$date_s</span>, когда <b style='color:#000000'>$team1_p</b> и <b style='color:#000000'>$team2_p</b> решили разобраться кто из них круче.<hr>";
		$diss[4]="Был обычный солнечный день...Но когда тени от стрелок часов показали <span class=date>$date_s</span>, <b style='color:#000000'>$team1_p</b> и <b style='color:#000000'>$team2_p</b> накинулись друг на друга, так словно не ели три дня.<hr>";
		$diss[5]="<span class=date>$date_s</span> Стая ворон с оглушительным карканьем сорвалась с низкого неба, хлопьями пепла упав на просяное поле; и рука сама нащупала за поясом рукоять меча. Просто так, для успокоения. Страха не было, но ощущение шершавой рукояти под ладонью доставило удовольствие. <b style='color:#000000'>$team1_p</b> и <b style='color:#000000'>$team2_p</b> замерли друг перед другом.<hr>";
		$diss[6]="<span class=date>$date_s</span> Мир ещё не решил, каким ему стать. Он просто плыл по течению, плескался, высматривал берега, наслаждаясь безмятежным покачиванием на волнах времени, изливавшегося теперь из совершенно другого источника. И не было ясно, кто останется в живых <b style='color:#000000'>$team1_p</b> или <b style='color:#000000'>$team2_p</b> ...<hr>";
		$diss[7]="Часы показывали <span class=date>$date_s</span>, когда <b style='color:#000000'>$team1_p</b> и <b style='color:#000000'>$team2_p</b> бросили вызов друг другу...<hr>";
		$diss[8]="Часы показывали <span class=date>$date_s</span>, когда <b style='color:#000000'>$team1_p</b> и <b style='color:#000000'>$team2_p</b> выбежали на арену...<hr>";
		$diss[9]="Часы показывали <span class=date>$date_s</span>, когда <b style='color:#000000'>$team1_p</b> и <b style='color:#000000'>$team2_p</b> вызвались на этот жестокий бой...<hr>";
		$diss[10]="Худой уборщик быстро сбежал со ступенек арены вниз, унося с собой напоминания, оставшиеся от предыдущего боя. Не успел он уйти, как на песок ступили новые бойцы, молча поклонились друг другу и завязалась новая битва.<hr>";
		$diss[11]="Колыхнулось покрывало в бортике арены, и как будто из стены, медленно стали выплывать люди. И какого только оружия они не держали – сразу видно, что идут воины, а не рыбаки или земледельцы. Чинно, не спеша, готовые к поединку повернулись навстречу друг другу, легко кивнули головами и бой начался!<hr>";

		$diss_put=$diss[rand(0,11)];
		battle_log($b_id, $diss_put);
	}
}
//-------------------------------------------------------------------------------
function getSign($day,$month)	
{
	switch ($month)	
	{
		case 1:
			$zodiac	= ($day <=20)	? "1.gif alt='Козерог'" : "2.gif alt='Водолей'";
		break;
		case 2:
			$zodiac	= ($day <=18)	? "2.gif alt='Водолей'" : "3.gif alt='Рыбы'";
		break;
		case 3:
			$zodiac	= ($day <=20)	? "3.gif alt='Рыбы'" : "4.gif alt='Овен'";
		break;
		case 4:
			$zodiac	= ($day <=20)	? "4.gif alt='Овен'" : "5.gif alt='Телец'";
		break;
		case 5:
			$zodiac	= ($day <=21)	? "5.gif alt='Телец'" : "6.gif alt='Близнецы'";
		break;
		case 6:
			$zodiac	= ($day <=22)	? "6.gif alt='Близнецы'" : "7.gif alt='Рак'";
		break;
		case 7:
			$zodiac	= ($day <=22)	? "7.gif alt='Рак'" : "8.gif alt='Лев'";
		break;
		case 8:
			$zodiac	= ($day <=21)	? "8.gif alt='Лев'" : "9.gif alt='Дева'";
		break;
		case 9:
			$zodiac	= ($day <=23)	? "9.gif alt='Дева'" : "10.gif alt='Весы'";
		break;
		case 10:
			$zodiac	= ($day <=23)	? "10.gif alt='Весы'" : "11.gif alt='Скорпион'";
		break;
		case 11:
			$zodiac	= ($day <=21)	? "11.gif alt='Скорпион'" : "12.gif alt='Стрелец'";
		break;
		case 12:
			$zodiac	= ($day <=22)	? "12.gif alt='Стрелец'" : "1.gif alt='Козерог'";
		break;
	}
	return $zodiac;
}
//---------------------------------------------------------------------------
function checkbattlehars($need_hit,$need_krit,$need_block,$need_uvarot,$need_s_duh,$need_counter,$need_parry, $hit, $krit, $block, $uvarot,$s_duh,$counter,$parry) 
{ # влад магией, статы + хар-ки битвы
  if ($hit>=$need_hit && $krit>=$need_krit && $block>=$need_block && $uvarot>=$need_uvarot && $counter>=$need_counter && $parry>=$need_parry && $s_duh>=$need_s_duh) 
  {
  	return 1;
  }
  else return 0;
}
//---------------------------------------------------------------------------
function convert_time_last($vaxt)
{
	$r=$vaxt-time();
	$days=(int)($r/(60*60*24));
	$hours=(int)(($r-$days*60*60*24)/(60*60));
	$mins=(int)(($r-$days*60*60*24-$hours*60*60)/(60));
	$secs=(int)($r-$days*60*60*24-$hours*60*60-$mins*60);
	
	if($days<=0){$day="";}else $day="$days дн.";
	if($hours<=0){$hour="";}else $hour="$hours ч.";
	if($mins<=0){$minut="";}else $minut="$mins мин.";
	if($secs<=0){$secs=0;}
	$left="$day $hour $minut $secs сек.";
	return $left;
}
//---------------------------------------------------------------------------
function convert_time($vaxt)
{
	$r=$vaxt-time();
	$days=(int)($r/(60*60*24));
	$hours=(int)(($r-$days*60*60*24)/(60*60));
	$mins=(int)(($r-$days*60*60*24-$hours*60*60)/(60));
	$secs=(int)($r-$days*60*60*24-$hours*60*60-$mins*60);
	
	if($days<=0){$day="";}else $day="$days дн.";
	if($hours<=0){$hour="";}else $hour="$hours ч.";
	if($mins<=0){$minut="";}else $minut="$mins мин.";
	if($secs<=0){$secs=0;}
	$left="$day $hour $minut $secs сек.";
	return $left;
}


?>