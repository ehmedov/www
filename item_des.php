<?
function show_item($db,$item_Array)
{
	global $effect;
	if ($db["vip"]>time())$price_art=sprintf ("%01.2f", ceil($item_Array["price"]*0.75));
	$price_gos = sprintf ("%01.2f", $item_Array["price"]);

	if (!$item_Array["podzemka"])
	{
		if ($item_Array["art"]){$price_print="��."; $my_money=$db['platina'];}else {$price_print="��."; $my_money=$db['money'];}
	}
	else {$price_print="��."; $my_money=$db['naqrada'];}


	$is_runa=$item_Array["runas"];
	$rname=explode("#",$is_runa);
	if ($is_runa)
	{
		$r_name=mysql_fetch_array(mysql_query("SELECT name FROM runa WHERE type='".$rname[0]."' and step='".$rname[1]."'"));
	}
	$str="<a>".$item_Array["name"].($item_Array["is_modified"]?" +".$item_Array["is_modified"]:"")."</a>".($item_Array["gift"]?"&nbsp;<img src='img/icon/gift.gif' border=0 alt=\"������� �� ".$item_Array["gift_author"]."\">":"").($item_Array["art"]==1?"&nbsp;<img src='img/artefakt.gif' border=0 alt=\"��������\">":"").($item_Array["art"]==2?"&nbsp;<img src='img/icon/artefakt.gif' border=0 alt=\"��������\">":"").($item_Array["podzemka"]?"&nbsp;<img src='img/icon/podzemka.gif' border=0 alt=\"���� ���������� ������\">":"").($is_runa?"<img src='img/icon/runa.gif' alt='".$r_name["name"]."'>":"");
	if($item_Array["need_orden"])
	{
		switch ($item_Array["need_orden"]) 
		{
			 case 1:$orden_dis = "������ �������";break;
			 case 2:$orden_dis = "�������";break;
		 	 case 3:$orden_dis = "����� ����������";break;
		 	 case 4:$orden_dis = "����� �����";break;
		 	 case 5:$orden_dis = "�������� ����������";break;
		 	 case 6:$orden_dis = "�������� ����";break;
		}
		$str.="&nbsp;<img src='img/orden/".$item_Array["need_orden"]."/0.gif' border=0 alt='��������� �����:\n".$orden_dis."'>";
	}
	$str.="&nbsp;(�����: ".$item_Array["mass"].")<br>";
	$str.="<b>����: ".($item_Array["price"]>$my_money  && count($db)>0?"<FONT COLOR=RED>":"").$price_gos.($db["vip"]>time() && $item_Array["art"]>0?" [V.I.P ���� ".$price_art."]":"")."</font> ".$price_print."</b>";
	$str.=($item_Array["gos_price"]>0?" (���. ����: ".sprintf ("%01.2f", $item_Array["gos_price"])." $price_print)":"");
	$str.="<BR>�������������: ".(int)$item_Array["iznos"]."/".(int)$item_Array["iznos_max"]."<BR>";
	$str.=($item_Array["edited"]>0?"<FONT COLOR=green>�������� �������� �� 10�� ������</font><BR>":"");
	$str.=($item_Array["object"]=="spear" || $item_Array["object_type"]=="spear"?"���� ��������: 30 ��.<BR>":"");
	$str.=($item_Array["add_xp"]>0?"������: +".$item_Array["add_xp"]."<BR>":"");
	$str.=($item_Array["gravirovka"]!=""?"������������� �������: <i>".$item_Array["gravirovka"]."</i><BR>":"");

	$str.="<b>��������� �����������:</b><BR>";
	
	$str.=(($item_Array['min_sila'])?"� ".(($item_Array['min_sila'] > ($db['sila']+$effect["add_sila"]) && count($db)>0)?"<font color=red>":"")."����: {$item_Array['min_sila']}</font><BR>":"");
	$str.=(($item_Array['min_lovkost'])?"� ".(($item_Array['min_lovkost'] > ($db['lovkost']+$effect["add_lovkost"]) && count($db)>0)?"<font color=red>":"")."��������: {$item_Array['min_lovkost']}</font><BR>":"");
	$str.=(($item_Array['min_udacha'])?"� ".(($item_Array['min_udacha'] > ($db['udacha']+$effect['add_udacha']) && count($db)>0)?"<font color=red>":"")."�����: {$item_Array['min_udacha']}</font><BR>":"");
	$str.=(($item_Array['min_power'])?"� ".(($item_Array['min_power'] > $db['power'] && count($db)>0)?"<font color=red>":"")."������������: {$item_Array['min_power']}</font><BR>":"");
	$str.=(($item_Array['min_intellekt'])?"� ".(($item_Array['min_intellekt'] > ($db['intellekt']+$effect['add_intellekt']) && count($db)>0)?"<font color=red>":"")."���������: {$item_Array['min_intellekt']}</font><BR>":"");
	$str.=(($item_Array['min_vospriyatie'])?"� ".(($item_Array['min_vospriyatie'] > $db['vospriyatie'] && count($db)>0)?"<font color=red>":"")."�����������: {$item_Array['min_vospriyatie']}</font><BR>":"");
	$str.=(($item_Array['min_level'])?"� ".(($item_Array['min_level'] > $db['level'] && count($db)>0)?"<font color=red>":"")."�������: {$item_Array['min_level']}</font><BR>":"");

	$str.=(($item_Array['min_sword_vl'])?"� ".(($item_Array['min_sword_vl'] > $db['sword_vl'] && count($db)>0)?"<font color=red>":"")."���������� �������� ������: {$item_Array['min_sword_vl']}</font><BR>":"");
	$str.=(($item_Array['min_staff_vl'])?"� ".(($item_Array['min_staff_vl'] > $db['staff_vl'] && count($db)>0)?"<font color=red>":"")."���������� �������� ��������: {$item_Array['min_staff_vl']}</font><BR>":"");
	$str.=(($item_Array['min_axe_vl'])?"� ".(($item_Array['min_axe_vl'] > $db['axe_vl'] && count($db)>0)?"<font color=red>":"")."���������� �������� ��������, ��������: {$item_Array['min_axe_vl']}</font><BR>":"");
	$str.=(($item_Array['min_fail_vl'])?"� ".(($item_Array['min_fail_vl'] > $db['hummer_vl'] && count($db)>0)?"<font color=red>":"")."���������� �������� �������� � ��������: {$item_Array['min_fail_vl']}</font><BR>":"");
	$str.=(($item_Array['min_knife_vl'])?"� ".(($item_Array['min_knife_vl'] > $db['castet_vl'] && count($db)>0)?"<font color=red>":"")."���������� �������� ������, ���������: {$item_Array['min_knife_vl']}</font><BR>":"");
	$str.=(($item_Array['min_spear_vl'])?"� ".(($item_Array['min_spear_vl'] > $db['copie_vl'] && count($db)>0)?"<font color=red>":"")."���������� �������� ���������� ��������: {$item_Array['min_spear_vl']}</font><BR>":"");
	
	$str.=(($item_Array['min_fire'])?"� ".(($item_Array['min_fire'] > $db['fire_magic'] && count($db)>0)?"<font color=red>":"")."�������� ������ ����: {$item_Array['min_fire']}</font><BR>":"");
	$str.=(($item_Array['min_water'])?"� ".(($item_Array['min_water'] > $db['water_magic'] && count($db)>0)?"<font color=red>":"")."�������� ������ ����: {$item_Array['min_water']}</font><BR>":"");
	$str.=(($item_Array['min_air'])?"� ".(($item_Array['min_air'] > $db['air_magic'] && count($db)>0)?"<font color=red>":"")."�������� ������ �������: {$item_Array['min_air']}</font><BR>":"");
	$str.=(($item_Array['min_earth'])?"� ".(($item_Array['min_earth'] > $db['earth_magic'] && count($db)>0)?"<font color=red>":"")."�������� ������ �����: {$item_Array['min_earth']}</font><BR>":"");
	$str.=(($item_Array['min_svet'])?"� ".(($item_Array['min_svet'] > $db['svet_magic'] && count($db)>0)?"<font color=red>":"")."�������� ������ �����: {$item_Array['min_svet']}</font><BR>":"");
	$str.=(($item_Array['min_tma'])?"� ".(($item_Array['min_tma'] > $db['tma_magic'] && count($db)>0)?"<font color=red>":"")."�������� ������ ����: {$item_Array['min_tma']}</font><BR>":"");
	$str.=(($item_Array['min_gray'])?"� ".(($item_Array['min_gray'] > $db['gray_magic'] && count($db)>0)?"<font color=red>":"")."�������� ����� ������: {$item_Array['min_gray']}</font><BR>":"");
	
	if($item_Array['sex']!="" && count($db)>0)
	{
		$str.="� ";
		if ($item_Array['sex']!=$db["sex"])$str.="<font color=#FF0000>";
		if ($item_Array['sex'] == "female")$str.="���: �������";
	    else if($item_Array['sex'] == "male")$str.="���: �������";
		$str.="</font><BR>";
	}
	$str.="<b>��������� ��:</b><BR>";
	
	$str.=(($item_Array['two_hand'])?"� <font style='color:#008080'><b>��������� ������</b></font><BR>":"");
	$str.=(($item_Array['second_hand'])?"� <font style='color:green'>������ ������</font><BR>":"");

	$str.=(($item_Array['min_attack'] && $item_Array['max_attack'])?"� ����: {$item_Array['min_attack']} - {$item_Array['max_attack']}<BR>":"");
	$str.=(($item_Array['proboy'])?"� ��. ����� ������ �����: {$item_Array['proboy']}<BR>":"");

	$str.=(($item_Array['add_sila']>0)?"� ����: +{$item_Array['add_sila']}<BR>":"");
	$str.=(($item_Array['add_sila']<0)?"� ����: {$item_Array['add_sila']}<BR>":"");
	$str.=(($item_Array['add_lovkost']>0)?"� ��������: +{$item_Array['add_lovkost']}<BR>":"");
	$str.=(($item_Array['add_lovkost']<0)?"� ��������: {$item_Array['add_lovkost']}<BR>":"");
	$str.=(($item_Array['add_udacha']>0)?"� �����: +{$item_Array['add_udacha']}<BR>":"");
	$str.=(($item_Array['add_udacha']<0)?"� �����: {$item_Array['add_udacha']}<BR>":"");
	$str.=(($item_Array['add_intellekt']>0)?"� ���������: +{$item_Array['add_intellekt']}<BR>":"");
	$str.=(($item_Array['add_duxovnost']>0)?"� ����������: +{$item_Array['add_duxovnost']}<BR>":"");
	$str.=(($item_Array['add_hp'])?"� ������� �����: +{$item_Array['add_hp']}<BR>":"");
	$str.=(($item_Array['add_mana'])?"� ������� ����: +{$item_Array['add_mana']}<BR>":"");
	
	$str.=(($item_Array['krit'])?"� ��. ����������� ������: {$item_Array['krit']}%<BR>":"");
	$str.=(($item_Array['akrit'])?"� ��. ������ ����. ������: {$item_Array['akrit']}%<BR>":"");
	$str.=(($item_Array['ms_krit'])?"� ��. �������� ����. �����: {$item_Array['ms_krit']}%<BR>":"");
	$str.=(($item_Array['parry'])?"� ��. �����������: {$item_Array['parry']}%<BR>":"");
	$str.=(($item_Array['counter'])?"� ��. ����������: {$item_Array['counter']}%<BR>":"");
	$str.=(($item_Array['uvorot'])?"� ��. �����������: {$item_Array['uvorot']}%<BR>":"");
	$str.=(($item_Array['auvorot'])?"� ��. ������ �����������: {$item_Array['auvorot']}%<BR>":"");
	
	$str.=(($item_Array['add_krit'])?"� ��. ����������� ������: {$item_Array['add_krit']}%<BR>":"");
	$str.=(($item_Array['add_akrit'])?"� ��. ������ ����. ������: {$item_Array['add_akrit']}%<BR>":"");
	$str.=(($item_Array['add_uvorot'])?"� ��. �����������: {$item_Array['add_uvorot']}%<BR>":"");
	$str.=(($item_Array['add_auvorot'])?"� ��. ������ �����������: {$item_Array['add_auvorot']}%<BR>":"");

	
	$str.=(($item_Array['add_oruj'])?"� �������� �������: +{$item_Array['add_oruj']}<BR>":"");
	$str.=(($item_Array['add_knife_vl'])?"� ���������� �������� ������ � ���������: +{$item_Array['add_knife_vl']}<BR>":"");
	$str.=(($item_Array['add_axe_vl'])?"� ���������� �������� �������� � ��������: +{$item_Array['add_axe_vl']}<BR>":"");
	$str.=(($item_Array['add_fail_vl'])?"� ���������� �������� �������� � ��������: +{$item_Array['add_fail_vl']}<BR>":"");
	$str.=(($item_Array['add_sword_vl'])?"� ���������� �������� ������: +{$item_Array['add_sword_vl']}<BR>":"");
	$str.=(($item_Array['add_staff_vl'])?"� ���������� �������� ��������: +{$item_Array['add_staff_vl']}<BR>":"");
	$str.=(($item_Array['add_spear_vl'])?"� ���������� �������� ���������� ��������: +{$item_Array['add_spear_vl']}<BR>":"");
	
	$str.=(($item_Array['add_fire'])?"� ���������� �������� ������� ����: +{$item_Array['add_fire']}<BR>":"");
	$str.=(($item_Array['add_water'])?"� ���������� �������� ������� ����: +{$item_Array['add_water']}<BR>":"");
	$str.=(($item_Array['add_air'])?"� ���������� �������� ������� �������: +{$item_Array['add_air']}<BR>":"");
	$str.=(($item_Array['add_earth'])?"� ���������� �������� ������� �����: +{$item_Array['add_earth']}<BR>":"");
	$str.=(($item_Array['add_svet'])?"� ���������� �������� ������ �����: +{$item_Array['add_svet']}<BR>":"");
	$str.=(($item_Array['add_gray'])?"� ���������� �������� ����� ������: +{$item_Array['add_gray']}<BR>":"");
	$str.=(($item_Array['add_tma'])?"� ���������� �������� ������ ����: +{$item_Array['add_tma']}<BR>":"");
	
	$str.=(($item_Array['protect_head'])?"� ����� ������: {$item_Array['protect_head']}<BR>":"");
	$str.=(($item_Array['protect_arm'])?"� ����� ���: {$item_Array['protect_arm']}<BR>":"");
	$str.=(($item_Array['protect_corp'])?"� ����� �������: {$item_Array['protect_corp']}<BR>":"");
	$str.=(($item_Array['protect_poyas'])?"� ����� �����: {$item_Array['protect_poyas']}<BR>":"");
	$str.=(($item_Array['protect_legs'])?"� ����� ���: {$item_Array['protect_legs']}<BR>":"");
	
	$str.=(($item_Array['protect_rej'])?"� ������ �� �������� �����: {$item_Array['protect_rej']}<BR>":"");
	$str.=(($item_Array['protect_drob'])?"� ������ �� ��������� �����: {$item_Array['protect_drob']}<BR>":"");
	$str.=(($item_Array['protect_kol'])?"� ������ �� �������� �����: {$item_Array['protect_kol']}<BR>":"");
	$str.=(($item_Array['protect_rub'])?"� ������ �� �������� �����: {$item_Array['protect_rub']}<BR>":"");
	
	$str.=(($item_Array['protect_fire'])?"� ������ �� ����� ����: {$item_Array['protect_fire']}<BR>":"");
	$str.=(($item_Array['protect_water'])?"� ������ �� ����� ����: {$item_Array['protect_water']}<BR>":"");
	$str.=(($item_Array['protect_air'])?"� ������ �� ����� �������: {$item_Array['protect_air']}<BR>":"");
	$str.=(($item_Array['protect_earth'])?"� ������ �� ����� �����: {$item_Array['protect_earth']}<BR>":"");	
	$str.=(($item_Array['protect_svet'])?"� ������ �� ����� �����: {$item_Array['protect_svet']}<BR>":"");
	$str.=(($item_Array['protect_tma'])?"� ������ �� ����� ����: {$item_Array['protect_tma']}<BR>":"");
	$str.=(($item_Array['protect_gray'])?"� ������ �� ����� �����: {$item_Array['protect_gray']}<BR>":"");

	$str.=(($item_Array['protect_udar'])?"� ������ �� �����: +{$item_Array['protect_udar']}%<BR>":"");
	$str.=(($item_Array['protect_mag'])?"� ������ �� �����: +{$item_Array['protect_mag']}%<BR>":"");
	
	$str.=(($item_Array['shieldblock'])?"� ��.����� �����: +{$item_Array['shieldblock']}%<BR>":"");
	
	$str.=(($item_Array['ms_udar'])?"� ��. �������� �����: +{$item_Array['ms_udar']}%<BR>":"");
	$str.=(($item_Array['ms_rub'])?"� ��. �������� ������� �����: +{$item_Array['ms_rub']}%<BR>":"");
	$str.=(($item_Array['ms_kol'])?"� ��. �������� �������� �����: +{$item_Array['ms_kol']}%<BR>":"");
	$str.=(($item_Array['ms_drob'])?"� ��. �������� ��������� �����: +{$item_Array['ms_drob']}%<BR>":"");
	$str.=(($item_Array['ms_rej'])?"� ��. �������� �������� �����: +{$item_Array['ms_rej']}%<BR>":"");
	
	$str.=(($item_Array['ms_mag'])?"� ��. �������� ����� ������: +{$item_Array['ms_mag']}%<BR>":"");
	$str.=(($item_Array['ms_fire'])?"� ��. �������� ����� ����: +{$item_Array['ms_fire']}%<BR>":"");
	$str.=(($item_Array['ms_water'])?"� ��. �������� ����� ����: +{$item_Array['ms_water']}%<BR>":"");
	$str.=(($item_Array['ms_air'])?"� ��. �������� ����� �������: +{$item_Array['ms_air']}%<BR>":"");
	$str.=(($item_Array['ms_earth'])?"� ��. �������� ����� �����: +{$item_Array['ms_earth']}%<BR>":"");
	$str.=(($item_Array['ms_svet'])?"� ��. �������� ����� �����: +{$item_Array['ms_svet']}%<BR>":"");
	$str.=(($item_Array['ms_tma'])?"� ��. �������� ����� ����: +{$item_Array['ms_tma']}%<BR>":"");
	$str.=(($item_Array['ms_gray'])?"� ��. �������� ����� �����: +{$item_Array['ms_gray']}%<BR>":"");

	$str.=(($item_Array['add_rej']>0 || $item_Array['add_drob']>0 || $item_Array['add_kol']>0 || $item_Array['add_rub']>0 ||$item_Array['add_fire_att']>0 || $item_Array['add_air_att']>0 || $item_Array['add_watet_att']>0 || $item_Array['add_earth_att']>0)?"<b>����������� �����:</b><BR>":"");
	$str.=(($item_Array['add_rej'])?"� ��. �������� �����: +{$item_Array['add_rej']}%<BR>":"");
	$str.=(($item_Array['add_drob'])?"� ��. ��������� �����: +{$item_Array['add_drob']}%<BR>":"");
	$str.=(($item_Array['add_kol'])?"� ��. �������� �����: +{$item_Array['add_kol']}%<BR>":"");
	$str.=(($item_Array['add_rub'])?"� ��. �������� �����: +{$item_Array['add_rub']}%<BR>":"");
	
	$str.=(($item_Array['add_fire_att'])?"� ��. �������� �����: +{$item_Array['add_fire_att']}%<BR>":"");
	$str.=(($item_Array['add_air_att'])?"� ��. ������������� �����: +{$item_Array['add_air_att']}%<BR>":"");
	$str.=(($item_Array['add_watet_att'])?"� ��. ������� �����: +{$item_Array['add_watet_att']}%<BR>":"");
	$str.=(($item_Array['add_earth_att'])?"� ��. �������� �����: +{$item_Array['add_earth_att']}%<BR>":"");
	
	$str.=(($item_Array['term'])?"<BR><b>������:</b> �� ".(date('d.m.y H:i:s', $item_Array['term'])):"");

	$str.=(($item_Array['bs'])?"<br><font style='font-size:11px; color:#990000'>��������� ������</font>":"");
	$str.=(($item_Array['podzemka'])?"<br><font style='font-size:11px; color:#990000'>������� �� ����������</font>":"");
	$str.=(($item_Array['noremont'])?"<br><font style='font-size:11px; color:#990000'>������� �� �������� �������</font>":"");
	$str.=(($item_Array["object"]=="spear" || $item_Array["object_type"]=="spear")?"<br><font style='font-size:11px; color:#990000'>���� ������������: ++ (��� ��������� �� ������ ����)</font>":"");
	echo $str;
}
?>