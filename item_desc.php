<?

while($dat=mysql_fetch_assoc($seek))
{	
	$n=(!$n);
	$id=$dat["id"];
	$name=$dat["name"];
	$nums_art=$dat["art"];
	$podzemka=$dat["podzemka"];
	$nums_mountown=$dat["mountown"];
	$podzemka=$dat["podzemka"];
	$img=$dat["img"];
	$mass=$dat["mass"];
	$price=$dat["price"];
	if ($db["vip"]>time())$price_art=sprintf ("%01.2f", ceil($price*0.75));
	$price_gos = sprintf ("%01.2f", $price);
	$sex = $dat["sex"];
	if (!$podzemka)
	{
		if ($nums_art){$price_print="��."; $my_money=$db['platina'];}else {$price_print="��."; $my_money=$db['money'];}
	}
	else {$price_print="��."; $my_money=$db['naqrada'];}

	$min_s=$dat["min_sila"];
	$min_l=$dat["min_lovkost"];
	$min_u=$dat["min_udacha"];
	$min_p=$dat["min_power"];
	$min_i=$dat["min_intellekt"];
	$min_v=$dat["min_vospriyatie"];
	$min_level=$dat["min_level"];
	$min_iznos=$dat["iznos_min"];
	$max_iznos=$dat["iznos_max"];
	
	$add_s=$dat["add_sila"];
	$add_l=$dat["add_lovkost"];
	$add_u=$dat["add_udacha"];
	$add_hp=$dat["add_hp"];
	$add_i=$dat["add_intellekt"];
	$add_mana=$dat["add_mana"];

	$addsword_vl=$dat["sword_vl"];
	$addaxe_vl=$dat["axe_vl"];
	$addfail_vl=$dat["fail_vl"];
	$addknife_vl=$dat["knife_vl"];
	$addspear_vl=$dat["spear_vl"];
	$addstaff_vl=$dat["staff_vl"];

	$p_h=$dat["protect_head"];
	$p_a=$dat["protect_arm"];
	$p_c=$dat["protect_corp"];
	$p_p=$dat["protect_poyas"];
	$p_l=$dat["protect_legs"];

	$mf_krit=$dat["krit"];
	$mf_antikrit=$dat["akrit"];
	$mf_uvorot=$dat["uvorot"];
	$mf_antiuvorot=$dat["auvorot"];

	$min_a=$dat["min_attack"];
	$max_a=$dat["max_attack"];
	
	$noremont=$dat["noremont"];
	$need_orden=$dat["orden"];

	$add_fire=$dat["add_fire"];
	$add_water=$dat["add_water"];
	$add_air=$dat["add_air"];
	$add_earth=$dat["add_earth"];
	
	$add_cast=$dat["add_cast"];
	$add_trade=$dat["add_trade"];
	$add_cure=$dat["add_cure"];

	$school = $dat["school"];
	if($school == "air"){$school_d = "������";}
	if($school == "water"){$school_d = "����";}
	if($school == "fire"){$school_d = "�����";}
	if($school == "earth"){$school_d = "�����";}

	echo "\n<tr bgcolor=".($n?'#C7C7C7':'#D5D5D5')."><td valign=center align=center width=150 nowrap>";
	echo "<img src='img/$img' alt='$name'><BR>";
	echo "<a href='?buy=$otdel&item=$id&rnd=".md5(rand(1,1000000))."' >������</a>";
	//if ($dat["art"] && !$podzemka){echo "<hr width=75%>";echo "<a href='?buy=$otdel&item=$id&rnd=".md5(rand(1,1000000))."&arenda=1' >������ �� ������ �� ".($dat["price"]*0.1)." $price_print</a>";}
	if ($db['adminsite']>=5)
	{
		echo "<hr width=75%><a href='edititems.php?item=$id' target='_blank'>edit</a>";
	}	
	echo "</td>";
	echo "<td valign=top nowrap>";
	echo "<b>$name</b> ";
	if ($nums_art) echo "<img src='img/icon/artefakt.gif' border=0 alt=\"��������\">&nbsp;";
	if ($podzemka) echo "<img src='img/icon/podzemka.gif' border=0 alt=\"���� ���������� ������\">&nbsp;";
	if($need_orden!=0)
	{
		switch ($need_orden) 
		{
			 case 1:$orden_dis = "������ �������";break;
			 case 2:$orden_dis = "�������";break;
		 	 case 3:$orden_dis = "����� ����������";break;
		 	 case 4:$orden_dis = "����� �����";break;
		 	 case 5:$orden_dis = "�������� ����������";break;
		 	 case 6:$orden_dis = "�������� ����";break;
		}
		echo "<img src='img/orden/".$need_orden."/0.gif' border=0 alt='��������� �����:\n".$orden_dis."'>&nbsp;";
	}
	echo "(�����: <b>$mass</b> ��.)&nbsp;(��������: <b>$nums_mountown</b> ��.)";
	echo "<br>";	
	//---------------------------------------------------------------
	echo "<b>����: ".($price>$my_money?"<FONT COLOR=RED>":"").$price_gos.($db["vip"]>time()?" [V.I.P ���� ".$price_art."]":"")."</font> $price_print</b><BR>";
	echo "�������������: $min_iznos/$max_iznos<BR>";
	echo "<table width=100%><tr><td valign=top width=250 nowrap>";
	echo "<b>��������� �����������:</b><BR>";
	if($min_s)
	{
		if($min_s>$db["sila"])
		{
			echo "&bull; <font color=#FF0000>����: $min_s</font>";
		}
		else echo "&bull; ����: $min_s";
		echo "<BR>";
	}
	if($min_l)
	{
		if($min_l>$db["lovkost"])
		{
			echo "&bull; <font color=#FF0000>��������: $min_l</font>";
		}
		else echo "&bull; ��������: $min_l";
		echo "<BR>";
	}
	if($min_u)
	{
		if($min_u>$db["udacha"])
		{
			echo "&bull; <font color=#FF0000>�����: $min_u</font>";
		}
		else echo "&bull; �����: $min_u";
		echo "<BR>";
	}
	if($min_p)
	{
		if($min_p>$db["power"])
		{
			echo "&bull; <font color=#FF0000>������������: $min_p</font>";
		}
		else echo "&bull; ������������: $min_p";
		echo "<BR>";
	}
	if($min_i)
	{
		if($min_i>$db["intellekt"])
		{
			echo "&bull; <font color=#FF0000>���������: $min_i</font>";
		}
		else echo "&bull; ���������: $min_i";
		echo "<BR>";
	}
	if($min_v)
	{
		if($min_v>$db["vospriyatie"])
		{
			echo "&bull; <font color=#FF0000>�����������: $min_v</font>";
		}
		else echo "&bull; �����������: $min_v";
		echo "<BR>";
	}
	if($min_level>$db["level"])
	{
		echo "&bull; <font color=#FF0000>�������: $min_level</font>";
	}
	else echo "&bull; �������: $min_level";

	if(!empty($sex))
	{
		if($sex == "female" && $sex!=$db["sex"]){$req_sex = "<font color=#FF0000>�������</font>";}
	    else if($sex == "female" && $sex==$db["sex"]){$req_sex = "�������";}
	    else if($sex == "male" && $sex==$db["sex"]){$req_sex = "�������";}
		else if($sex == "male" && $sex!=$db["sex"]){$req_sex = "<font color=#FF0000>�������</font>";}
		echo "<BR>&bull; ���: $req_sex<BR>";
	}
	echo "</td><td valign=top nowrap>";
	echo "<b>��������� ��:</b><BR>";

	if($add_s>0)
	{
		echo "&bull; ����: +$add_s<BR>";
	}
	else if($add_s<0)
	{
		echo "&bull; ����: <font color=#FF0000>$add_s</font><BR>";
	}
	if($add_l>0)
	{
		echo "&bull; ��������: +$add_l<BR>";
	}
	else if($add_l<0)
	{
		echo "&bull; ��������: <font color=#FF0000>$add_l</font><BR>";
	}
	if($add_u>0)
	{
		echo "&bull; �����: +$add_u<BR>";
	}
	else if($add_u<0)
	{
		echo "&bull; �����: <font color=#FF0000>$add_u</font><BR>";
	}
	if($add_i>0)
	{
		echo "&bull; ���������: +$add_i<BR>";
	}
	else if($add_i<0)
	{
		echo "&bull; ���������: <font color=#FF0000>+$add_i</font><BR>";
	}
	if($add_hp>0)
	{
		echo "&bull; ������� HP: +$add_hp<BR>";
	}
	if($add_mana>0)
	{
		echo "&bull; ������� ����: +$add_mana<BR>";
	}
	if($addsword_vl>0)
	{
		echo "&bull; �������� ������: +$addsword_vl<BR>";
	}
	if($addaxe_vl>0)
	{
		echo "&bull; �������� ��������: +$addaxe_vl<BR>";
	}
	if($addfail_vl>0)
	{
		echo "&bull; �������� ��������: +$addfail_vl<BR>";
	}
	if($addknife_vl>0)
	{
		echo "&bull; �������� ������: +$addknife_vl<BR>";
	}
	if($addspear_vl>0)
	{
		echo "&bull; �������� �������: +$addspear_vl<BR>";
	}
	if($addstaff_vl>0)
	{
		echo "&bull; �������� ��������: +$addstaff_vl<BR>";
	}
	if($p_h>0)
	{
		echo "&bull; ����� ������: $p_h<BR>";
	}
	if($p_c>0)
	{
		echo "&bull; ����� �������: $p_c<BR>";
	}
	if($p_a>0)
	{
		echo "&bull; ����� ���: $p_a<BR>";
	}
	if($p_p>0)
	{
		echo "&bull; ����� �����: $p_p<BR>";
	}
	if($p_l>0)
	{
		echo "&bull; ����� ���: $p_l<BR>";
	}
	if($add_fire>0)
	{
		echo "&bull; ������ ����: +$add_fire<BR>";
	}
	if($add_water>0)
	{
		echo "&bull; ������ ����: +$add_water<BR>";
	}
	if($add_air>0)
	{
		echo "&bull; ������ �������: +$add_air<BR>";
	}
	if($add_earth>0)
	{
		echo "&bull; ������ �����: +$add_earth<BR>";
	}
	if($mf_krit)
	{
		echo "&bull; ���� ����. �����: +$mf_krit<BR>";
	}
	if($mf_antikrit)
	{
		echo "&bull; ���� ��������: +$mf_antikrit<BR>";
	}
	if($mf_uvorot)
	{
		echo "&bull; ���� �������: +$mf_uvorot<BR>";
	}
	if($mf_antiuvorot)
	{
		echo "&bull; ���� �����������: +$mf_antiuvorot<BR>";
	}
	if($min_a)
	{
		echo "&bull; ���. ����: $min_a<BR>";
	}
	if($max_a)
	{
		echo "&bull; ����. ����: $max_a<BR>";
	}
	echo "</td></tr></table>";
	echo ($noremont?"<small><font color=brown>������� �� �������� �������<br>������� ����� ������� ��  1 $price_print</font></small>":"");
}
mysql_free_result($seek);
if (!$counts)echo "<tr bgcolor='#C7C7C7'><td valign=center align=center nowrap colspan=2><b>�������� �������� ������...</b></td></tr>";
echo "</table>";
echo "</td></tr></table><br>\t";
?>