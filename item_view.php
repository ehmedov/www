<?
echo "<td valign=top>";
echo "<B>$name".($is_modified?" +$is_modified":"")."</B> (�����: $mass)";
if ($is_artefakt){$price_print="��.";}
else {$price_print="��.";}

if($gift)
{
	echo "&nbsp;<img src='img/icon/gift.gif' border=0 alt='������� �� $gift_author'>";
}
if($is_artefakt)
{
	echo "&nbsp;<img src='img/icon/artefakt.gif' border=0 alt='����������� ����'>";
}
if($is_personal)
{
	echo "&nbsp;<img src='img/icon/personal.gif' border=0 alt='������� ����������� ����.\n����������� $personal_owner'>";
}
if($is_runa)
{
	echo "&nbsp; <img src='img/icon/runa.gif' alt='".$r_name["name"]."\n".$r_name["descs"]."'>";
}
if($is_aligned)
{
	switch ($is_aligned) 
	{
		 case 1:$orden_dis = "������ �������";break;
		 case 2:$orden_dis = "�������";break;
	 	 case 3:$orden_dis = "����� ����������";break;
	 	 case 4:$orden_dis = "����� �����";break;
	 	 case 5:$orden_dis = "�������� ����������";break;
	 	 case 6:$orden_dis = "�������� ����";break;
	}
	echo "&nbsp;<img src='img/orden/$is_aligned/0.gif' border=0 alt='��������� �����:\n$orden_dis'>";
}

echo "<br><b> ����: $price_gos $price_print </b><BR>";
echo "�������������: $iznos/$iznos_max<BR>";
if ($edited>0)echo  "<b>������:+$edited</b><br>";
if ($dat["add_xp"]>0)echo  "<b>���������: ".$dat["add_xp"]." HP</b><br>";
if ($gravirovka!="")echo  "<b>������������� �������:</b> <i>".$gravirovka."</i><br>";
echo "<table width=100%><tr><td valign=top width=250><b>��������� �����������:</b><BR>";
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
		$min_i="&bull; <font color=#FF0000>���������: $min_i</font>";
	}
	else echo "&bull; ���������: $min_i";
	echo "<BR>";
}
if($min_v)
{
	if($min_v>$db["vospriyatie"])
	{
		$min_v="&bull; <font color=#FF0000>�����������: $min_v</font>";
	}
	else echo "&bull; �����������: $min_v";
	echo "<BR>";
}
if($min_level>$db["level"])
{
	echo "&bull; <font color=#FF0000>�������: $min_level</font>";
}
else echo "&bull; �������: $min_level";

echo "</td><td valign=top><b>��������:</b><BR>";
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
if($add_hp)
{
	echo "&bull; ������� HP: +".($add_hp+$dat["add_xp"]).($dat["add_xp"]?" <font color=green>[+".$dat["add_xp"]."]</font>":"")."<BR>";
}
if($add_mana)
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

if($p_h)
{
	echo "&bull; ����� ������: $p_h<BR>";
}
if($p_c)
{
	echo "&bull; ����� �������: $p_c<BR>";
}
if($p_a)
{
	echo "&bull; ����� ���: $p_a<BR>";
}
if($p_p)
{
	echo "&bull; ����� �����: $p_p<BR>";
}
if($p_l)
{
	echo "&bull; ����� ���: $p_l<BR>";
}
if($mf_krit>0){
echo "&bull; ���� ����. �����: +$mf_krit<BR>";
}
else if($mf_krit<0){
echo "&bull; ���� ����. �����: $mf_krit<BR>";
}
if($mf_antikrit>0){
echo "&bull; ���� ��������: +$mf_antikrit<BR>";
}
else if($mf_antikrit<0){
echo "&bull; ���� ��������: $mf_antikrit<BR>";
}
if($mf_uvorot>0){
echo "&bull; ���� �������: +$mf_uvorot<BR>";
}
else if($mf_uvorot<0){
echo "&bull; ���� �������: $mf_uvorot<BR>";
}
if($mf_antiuvorot>0){
echo "&bull; ���� �����������: +$mf_antiuvorot<BR>";
}
else if($mf_antiuvorot<0){
echo "&bull; ���� �����������: $mf_antiuvorot<BR>";
}
if($min_a)
{
	echo "&bull; ���. ����: ".($min_a+ ($is_modified?$is_modified*5:0))."<BR>";
}
if($max_a)
{
	echo "&bull; ����. ����: ".($max_a+ ($is_modified?$is_modified*5:0))."<BR>";
}
?>
</td>
</tr></table>
<?echo ($noremont?"<small><font color=brown>������� �� �������� �������<br>������� ����� ������� ��  1 $price_print</font></small>":"");?>
