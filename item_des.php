<?
function show_item($db,$item_Array)
{
	global $effect;
	if ($db["vip"]>time())$price_art=sprintf ("%01.2f", ceil($item_Array["price"]*0.75));
	$price_gos = sprintf ("%01.2f", $item_Array["price"]);

	if (!$item_Array["podzemka"])
	{
		if ($item_Array["art"]){$price_print="ѕл."; $my_money=$db['platina'];}else {$price_print="«л."; $my_money=$db['money'];}
	}
	else {$price_print="≈д."; $my_money=$db['naqrada'];}


	$is_runa=$item_Array["runas"];
	$rname=explode("#",$is_runa);
	if ($is_runa)
	{
		$r_name=mysql_fetch_array(mysql_query("SELECT name FROM runa WHERE type='".$rname[0]."' and step='".$rname[1]."'"));
	}
	$str="<a>".$item_Array["name"].($item_Array["is_modified"]?" +".$item_Array["is_modified"]:"")."</a>".($item_Array["gift"]?"&nbsp;<img src='img/icon/gift.gif' border=0 alt=\"ѕодарок от ".$item_Array["gift_author"]."\">":"").($item_Array["art"]==1?"&nbsp;<img src='img/artefakt.gif' border=0 alt=\"ј–“≈‘ј “\">":"").($item_Array["art"]==2?"&nbsp;<img src='img/icon/artefakt.gif' border=0 alt=\"ј–“≈‘ј “\">":"").($item_Array["podzemka"]?"&nbsp;<img src='img/icon/podzemka.gif' border=0 alt=\"¬ещи ѕотер€нных √ероев\">":"").($is_runa?"<img src='img/icon/runa.gif' alt='".$r_name["name"]."'>":"");
	if($item_Array["need_orden"])
	{
		switch ($item_Array["need_orden"]) 
		{
			 case 1:$orden_dis = "—тражи пор€дка";break;
			 case 2:$orden_dis = "¬ампиры";break;
		 	 case 3:$orden_dis = "ќрден –авновеси€";break;
		 	 case 4:$orden_dis = "ќрден —вета";break;
		 	 case 5:$orden_dis = "“юремный заключеный";break;
		 	 case 6:$orden_dis = "»стинный ћрак";break;
		}
		$str.="&nbsp;<img src='img/orden/".$item_Array["need_orden"]."/0.gif' border=0 alt='“ребуемый орден:\n".$orden_dis."'>";
	}
	$str.="&nbsp;(ћасса: ".$item_Array["mass"].")<br>";
	$str.="<b>÷ена: ".($item_Array["price"]>$my_money  && count($db)>0?"<FONT COLOR=RED>":"").$price_gos.($db["vip"]>time() && $item_Array["art"]>0?" [V.I.P  луб ".$price_art."]":"")."</font> ".$price_print."</b>";
	$str.=($item_Array["gos_price"]>0?" (√ос. цена: ".sprintf ("%01.2f", $item_Array["gos_price"])." $price_print)":"");
	$str.="<BR>ƒолговечность: ".(int)$item_Array["iznos"]."/".(int)$item_Array["iznos_max"]."<BR>";
	$str.=($item_Array["edited"]>0?"<FONT COLOR=green>¬озможно усиление до 10го уровн€</font><BR>":"");
	$str.=($item_Array["object"]=="spear" || $item_Array["object_type"]=="spear"?"—рок годности: 30 дн.<BR>":"");
	$str.=($item_Array["add_xp"]>0?"”силен: +".$item_Array["add_xp"]."<BR>":"");
	$str.=($item_Array["gravirovka"]!=""?"¬ыгравирована надпись: <i>".$item_Array["gravirovka"]."</i><BR>":"");

	$str.="<b>“ребуетс€ минимальное:</b><BR>";
	
	$str.=(($item_Array['min_sila'])?"Х ".(($item_Array['min_sila'] > ($db['sila']+$effect["add_sila"]) && count($db)>0)?"<font color=red>":"")."—ила: {$item_Array['min_sila']}</font><BR>":"");
	$str.=(($item_Array['min_lovkost'])?"Х ".(($item_Array['min_lovkost'] > ($db['lovkost']+$effect["add_lovkost"]) && count($db)>0)?"<font color=red>":"")."Ћовкость: {$item_Array['min_lovkost']}</font><BR>":"");
	$str.=(($item_Array['min_udacha'])?"Х ".(($item_Array['min_udacha'] > ($db['udacha']+$effect['add_udacha']) && count($db)>0)?"<font color=red>":"")."”дача: {$item_Array['min_udacha']}</font><BR>":"");
	$str.=(($item_Array['min_power'])?"Х ".(($item_Array['min_power'] > $db['power'] && count($db)>0)?"<font color=red>":"")."¬ыносливость: {$item_Array['min_power']}</font><BR>":"");
	$str.=(($item_Array['min_intellekt'])?"Х ".(($item_Array['min_intellekt'] > ($db['intellekt']+$effect['add_intellekt']) && count($db)>0)?"<font color=red>":"")."»нтеллект: {$item_Array['min_intellekt']}</font><BR>":"");
	$str.=(($item_Array['min_vospriyatie'])?"Х ".(($item_Array['min_vospriyatie'] > $db['vospriyatie'] && count($db)>0)?"<font color=red>":"")."¬осспри€тие: {$item_Array['min_vospriyatie']}</font><BR>":"");
	$str.=(($item_Array['min_level'])?"Х ".(($item_Array['min_level'] > $db['level'] && count($db)>0)?"<font color=red>":"")."”ровень: {$item_Array['min_level']}</font><BR>":"");

	$str.=(($item_Array['min_sword_vl'])?"Х ".(($item_Array['min_sword_vl'] > $db['sword_vl'] && count($db)>0)?"<font color=red>":"")."ћастерство владени€ мечами: {$item_Array['min_sword_vl']}</font><BR>":"");
	$str.=(($item_Array['min_staff_vl'])?"Х ".(($item_Array['min_staff_vl'] > $db['staff_vl'] && count($db)>0)?"<font color=red>":"")."ћастерство владение посохами: {$item_Array['min_staff_vl']}</font><BR>":"");
	$str.=(($item_Array['min_axe_vl'])?"Х ".(($item_Array['min_axe_vl'] > $db['axe_vl'] && count($db)>0)?"<font color=red>":"")."ћастерство владени€ топорами, секирами: {$item_Array['min_axe_vl']}</font><BR>":"");
	$str.=(($item_Array['min_fail_vl'])?"Х ".(($item_Array['min_fail_vl'] > $db['hummer_vl'] && count($db)>0)?"<font color=red>":"")."ћастерство владени€ дубинами и булавами: {$item_Array['min_fail_vl']}</font><BR>":"");
	$str.=(($item_Array['min_knife_vl'])?"Х ".(($item_Array['min_knife_vl'] > $db['castet_vl'] && count($db)>0)?"<font color=red>":"")."ћастерство владени€ ножами, кастетами: {$item_Array['min_knife_vl']}</font><BR>":"");
	$str.=(($item_Array['min_spear_vl'])?"Х ".(($item_Array['min_spear_vl'] > $db['copie_vl'] && count($db)>0)?"<font color=red>":"")."ћастерство владени€ древковоми оружи€ми: {$item_Array['min_spear_vl']}</font><BR>":"");
	
	$str.=(($item_Array['min_fire'])?"Х ".(($item_Array['min_fire'] > $db['fire_magic'] && count($db)>0)?"<font color=red>":"")."¬ладение магией ќгн€: {$item_Array['min_fire']}</font><BR>":"");
	$str.=(($item_Array['min_water'])?"Х ".(($item_Array['min_water'] > $db['water_magic'] && count($db)>0)?"<font color=red>":"")."¬ладение магией ¬оды: {$item_Array['min_water']}</font><BR>":"");
	$str.=(($item_Array['min_air'])?"Х ".(($item_Array['min_air'] > $db['air_magic'] && count($db)>0)?"<font color=red>":"")."¬ладение магией ¬оздуха: {$item_Array['min_air']}</font><BR>":"");
	$str.=(($item_Array['min_earth'])?"Х ".(($item_Array['min_earth'] > $db['earth_magic'] && count($db)>0)?"<font color=red>":"")."¬ладение магией «емли: {$item_Array['min_earth']}</font><BR>":"");
	$str.=(($item_Array['min_svet'])?"Х ".(($item_Array['min_svet'] > $db['svet_magic'] && count($db)>0)?"<font color=red>":"")."¬ладение магией —вета: {$item_Array['min_svet']}</font><BR>":"");
	$str.=(($item_Array['min_tma'])?"Х ".(($item_Array['min_tma'] > $db['tma_magic'] && count($db)>0)?"<font color=red>":"")."¬ладение магией “ьмы: {$item_Array['min_tma']}</font><BR>":"");
	$str.=(($item_Array['min_gray'])?"Х ".(($item_Array['min_gray'] > $db['gray_magic'] && count($db)>0)?"<font color=red>":"")."¬ладение серой магией: {$item_Array['min_gray']}</font><BR>":"");
	
	if($item_Array['sex']!="" && count($db)>0)
	{
		$str.="Х ";
		if ($item_Array['sex']!=$db["sex"])$str.="<font color=#FF0000>";
		if ($item_Array['sex'] == "female")$str.="ѕол: ∆енский";
	    else if($item_Array['sex'] == "male")$str.="ѕол: ћужской";
		$str.="</font><BR>";
	}
	$str.="<b>ƒействует на:</b><BR>";
	
	$str.=(($item_Array['two_hand'])?"Х <font style='color:#008080'><b>ƒвуручное оружие</b></font><BR>":"");
	$str.=(($item_Array['second_hand'])?"Х <font style='color:green'>¬торое оружие</font><BR>":"");

	$str.=(($item_Array['min_attack'] && $item_Array['max_attack'])?"Х ”рон: {$item_Array['min_attack']} - {$item_Array['max_attack']}<BR>":"");
	$str.=(($item_Array['proboy'])?"Х ћф. удара сквозь броню: {$item_Array['proboy']}<BR>":"");

	$str.=(($item_Array['add_sila']>0)?"Х —ила: +{$item_Array['add_sila']}<BR>":"");
	$str.=(($item_Array['add_sila']<0)?"Х —ила: {$item_Array['add_sila']}<BR>":"");
	$str.=(($item_Array['add_lovkost']>0)?"Х Ћовкость: +{$item_Array['add_lovkost']}<BR>":"");
	$str.=(($item_Array['add_lovkost']<0)?"Х Ћовкость: {$item_Array['add_lovkost']}<BR>":"");
	$str.=(($item_Array['add_udacha']>0)?"Х ”дача: +{$item_Array['add_udacha']}<BR>":"");
	$str.=(($item_Array['add_udacha']<0)?"Х ”дача: {$item_Array['add_udacha']}<BR>":"");
	$str.=(($item_Array['add_intellekt']>0)?"Х »нтеллект: +{$item_Array['add_intellekt']}<BR>":"");
	$str.=(($item_Array['add_duxovnost']>0)?"Х ƒуховность: +{$item_Array['add_duxovnost']}<BR>":"");
	$str.=(($item_Array['add_hp'])?"Х ”ровень жизни: +{$item_Array['add_hp']}<BR>":"");
	$str.=(($item_Array['add_mana'])?"Х ”ровень маны: +{$item_Array['add_mana']}<BR>":"");
	
	$str.=(($item_Array['krit'])?"Х ћф. критических ударов: {$item_Array['krit']}%<BR>":"");
	$str.=(($item_Array['akrit'])?"Х ћф. против крит. ударов: {$item_Array['akrit']}%<BR>":"");
	$str.=(($item_Array['ms_krit'])?"Х ћф. мощности крит. удара: {$item_Array['ms_krit']}%<BR>":"");
	$str.=(($item_Array['parry'])?"Х ћф. парировани€: {$item_Array['parry']}%<BR>":"");
	$str.=(($item_Array['counter'])?"Х ћф. контрудара: {$item_Array['counter']}%<BR>":"");
	$str.=(($item_Array['uvorot'])?"Х ћф. увертывани€: {$item_Array['uvorot']}%<BR>":"");
	$str.=(($item_Array['auvorot'])?"Х ћф. против увертывани€: {$item_Array['auvorot']}%<BR>":"");
	
	$str.=(($item_Array['add_krit'])?"Х ћф. критических ударов: {$item_Array['add_krit']}%<BR>":"");
	$str.=(($item_Array['add_akrit'])?"Х ћф. против крит. ударов: {$item_Array['add_akrit']}%<BR>":"");
	$str.=(($item_Array['add_uvorot'])?"Х ћф. увертывани€: {$item_Array['add_uvorot']}%<BR>":"");
	$str.=(($item_Array['add_auvorot'])?"Х ћф. против увертывани€: {$item_Array['add_auvorot']}%<BR>":"");

	
	$str.=(($item_Array['add_oruj'])?"Х ¬ладени€ ќружием: +{$item_Array['add_oruj']}<BR>":"");
	$str.=(($item_Array['add_knife_vl'])?"Х ћастерство владени€ ножами и кастетами: +{$item_Array['add_knife_vl']}<BR>":"");
	$str.=(($item_Array['add_axe_vl'])?"Х ћастерство владени€ топорами и секирами: +{$item_Array['add_axe_vl']}<BR>":"");
	$str.=(($item_Array['add_fail_vl'])?"Х ћастерство владени€ дубинами и булавами: +{$item_Array['add_fail_vl']}<BR>":"");
	$str.=(($item_Array['add_sword_vl'])?"Х ћастерство владени€ мечами: +{$item_Array['add_sword_vl']}<BR>":"");
	$str.=(($item_Array['add_staff_vl'])?"Х ћастерство владение посохами: +{$item_Array['add_staff_vl']}<BR>":"");
	$str.=(($item_Array['add_spear_vl'])?"Х ћастерство владени€ древковоми оружи€ми: +{$item_Array['add_spear_vl']}<BR>":"");
	
	$str.=(($item_Array['add_fire'])?"Х ћастерство владени€ стихией ќгн€: +{$item_Array['add_fire']}<BR>":"");
	$str.=(($item_Array['add_water'])?"Х ћастерство владени€ стихией ¬оды: +{$item_Array['add_water']}<BR>":"");
	$str.=(($item_Array['add_air'])?"Х ћастерство владени€ стихией ¬оздуха: +{$item_Array['add_air']}<BR>":"");
	$str.=(($item_Array['add_earth'])?"Х ћастерство владени€ стихией «емли: +{$item_Array['add_earth']}<BR>":"");
	$str.=(($item_Array['add_svet'])?"Х ћастерство владени€ магией —вета: +{$item_Array['add_svet']}<BR>":"");
	$str.=(($item_Array['add_gray'])?"Х ћастерство владени€ серой магией: +{$item_Array['add_gray']}<BR>":"");
	$str.=(($item_Array['add_tma'])?"Х ћастерство владени€ магией “ьмы: +{$item_Array['add_tma']}<BR>":"");
	
	$str.=(($item_Array['protect_head'])?"Х Ѕрон€ головы: {$item_Array['protect_head']}<BR>":"");
	$str.=(($item_Array['protect_arm'])?"Х Ѕрон€ рук: {$item_Array['protect_arm']}<BR>":"");
	$str.=(($item_Array['protect_corp'])?"Х Ѕрон€ корпуса: {$item_Array['protect_corp']}<BR>":"");
	$str.=(($item_Array['protect_poyas'])?"Х Ѕрон€ по€са: {$item_Array['protect_poyas']}<BR>":"");
	$str.=(($item_Array['protect_legs'])?"Х Ѕрон€ ног: {$item_Array['protect_legs']}<BR>":"");
	
	$str.=(($item_Array['protect_rej'])?"Х «ащита от режущего урона: {$item_Array['protect_rej']}<BR>":"");
	$str.=(($item_Array['protect_drob'])?"Х «ащита от дроб€щего урона: {$item_Array['protect_drob']}<BR>":"");
	$str.=(($item_Array['protect_kol'])?"Х «ащита от колющего урона: {$item_Array['protect_kol']}<BR>":"");
	$str.=(($item_Array['protect_rub'])?"Х «ащита от руб€щего урона: {$item_Array['protect_rub']}<BR>":"");
	
	$str.=(($item_Array['protect_fire'])?"Х «ащиты от магии ќгн€: {$item_Array['protect_fire']}<BR>":"");
	$str.=(($item_Array['protect_water'])?"Х «ащиты от магии ¬оды: {$item_Array['protect_water']}<BR>":"");
	$str.=(($item_Array['protect_air'])?"Х «ащиты от магии ¬оздуха: {$item_Array['protect_air']}<BR>":"");
	$str.=(($item_Array['protect_earth'])?"Х «ащиты от магии «емли: {$item_Array['protect_earth']}<BR>":"");	
	$str.=(($item_Array['protect_svet'])?"Х «ащиты от магии —вета: {$item_Array['protect_svet']}<BR>":"");
	$str.=(($item_Array['protect_tma'])?"Х «ащиты от магии “ьмы: {$item_Array['protect_tma']}<BR>":"");
	$str.=(($item_Array['protect_gray'])?"Х «ащиты от —ерой магии: {$item_Array['protect_gray']}<BR>":"");

	$str.=(($item_Array['protect_udar'])?"Х «ащита от урона: +{$item_Array['protect_udar']}%<BR>":"");
	$str.=(($item_Array['protect_mag'])?"Х «ащита от магии: +{$item_Array['protect_mag']}%<BR>":"");
	
	$str.=(($item_Array['shieldblock'])?"Х ћф.блока щитом: +{$item_Array['shieldblock']}%<BR>":"");
	
	$str.=(($item_Array['ms_udar'])?"Х ћф. мощности урона: +{$item_Array['ms_udar']}%<BR>":"");
	$str.=(($item_Array['ms_rub'])?"Х ћф. мощности руб€щго урона: +{$item_Array['ms_rub']}%<BR>":"");
	$str.=(($item_Array['ms_kol'])?"Х ћф. мощности колющего урона: +{$item_Array['ms_kol']}%<BR>":"");
	$str.=(($item_Array['ms_drob'])?"Х ћф. мощности дроб€щего урона: +{$item_Array['ms_drob']}%<BR>":"");
	$str.=(($item_Array['ms_rej'])?"Х ћф. мощности режущего урона: +{$item_Array['ms_rej']}%<BR>":"");
	
	$str.=(($item_Array['ms_mag'])?"Х ћф. мощности магии стихий: +{$item_Array['ms_mag']}%<BR>":"");
	$str.=(($item_Array['ms_fire'])?"Х ћф. мощности магии ќгн€: +{$item_Array['ms_fire']}%<BR>":"");
	$str.=(($item_Array['ms_water'])?"Х ћф. мощности магии ¬оды: +{$item_Array['ms_water']}%<BR>":"");
	$str.=(($item_Array['ms_air'])?"Х ћф. мощности магии ¬оздуха: +{$item_Array['ms_air']}%<BR>":"");
	$str.=(($item_Array['ms_earth'])?"Х ћф. мощности магии «емли: +{$item_Array['ms_earth']}%<BR>":"");
	$str.=(($item_Array['ms_svet'])?"Х ћф. мощности магии —вета: +{$item_Array['ms_svet']}%<BR>":"");
	$str.=(($item_Array['ms_tma'])?"Х ћф. мощности магии “ьмы: +{$item_Array['ms_tma']}%<BR>":"");
	$str.=(($item_Array['ms_gray'])?"Х ћф. мощности —ерой магии: +{$item_Array['ms_gray']}%<BR>":"");

	$str.=(($item_Array['add_rej']>0 || $item_Array['add_drob']>0 || $item_Array['add_kol']>0 || $item_Array['add_rub']>0 ||$item_Array['add_fire_att']>0 || $item_Array['add_air_att']>0 || $item_Array['add_watet_att']>0 || $item_Array['add_earth_att']>0)?"<b>ќсобенности атаки:</b><BR>":"");
	$str.=(($item_Array['add_rej'])?"Х ћф. режущего урона: +{$item_Array['add_rej']}%<BR>":"");
	$str.=(($item_Array['add_drob'])?"Х ћф. дроб€щего урона: +{$item_Array['add_drob']}%<BR>":"");
	$str.=(($item_Array['add_kol'])?"Х ћф. колющего урона: +{$item_Array['add_kol']}%<BR>":"");
	$str.=(($item_Array['add_rub'])?"Х ћф. руб€щего урона: +{$item_Array['add_rub']}%<BR>":"");
	
	$str.=(($item_Array['add_fire_att'])?"Х ћф. огненные атаки: +{$item_Array['add_fire_att']}%<BR>":"");
	$str.=(($item_Array['add_air_att'])?"Х ћф. электрические атаки: +{$item_Array['add_air_att']}%<BR>":"");
	$str.=(($item_Array['add_watet_att'])?"Х ћф. лед€ные атаки: +{$item_Array['add_watet_att']}%<BR>":"");
	$str.=(($item_Array['add_earth_att'])?"Х ћф. земл€ные атаки: +{$item_Array['add_earth_att']}%<BR>":"");
	
	$str.=(($item_Array['term'])?"<BR><b>јренда:</b> до ".(date('d.m.y H:i:s', $item_Array['term'])):"");

	$str.=(($item_Array['bs'])?"<br><font style='font-size:11px; color:#990000'>“урнирный доспех</font>":"");
	$str.=(($item_Array['podzemka'])?"<br><font style='font-size:11px; color:#990000'>ѕредмет из подземель€</font>":"");
	$str.=(($item_Array['noremont'])?"<br><font style='font-size:11px; color:#990000'>ѕредмет не подлежит ремонту</font>":"");
	$str.=(($item_Array["object"]=="spear" || $item_Array["object_type"]=="spear")?"<br><font style='font-size:11px; color:#990000'>«она Ѕлокировани€: ++ (ѕри надевании на вторую руку)</font>":"");
	echo $str;
}
?>