<?
echo "<b>".$name.($is_modified?" +$is_modified":"")."</b> (�����: $mass)";
if($gift)
{
	print "&nbsp; &nbsp;<img src='img/icon/gift.gif' border=0 alt='������� �� $gift_author'>";
}
if($is_artefakt)
{
	print "&nbsp; &nbsp;<img src='img/icon/artefakt.gif' border=0 alt='����������� ����'>";
}
if($is_personal)
{
	print "&nbsp; &nbsp;<img src='img/icon/personal.gif' alt='������� ����������� ����.\n����������� $personal_owner'>";
}
if($need_orden!=0)
{
	if($need_orden==1){$orden_dis="�������� �������";}
	else if($need_orden==2){$orden_dis="�������";}
	else if($need_orden==3){$orden_dis="����� ����������";}
	else if($need_orden==4){$orden_dis="����� �����";}
	else if($need_orden==5){$orden_dis="�������� ����������";}
	else if($need_orden==6){$orden_dis="�������� ����";}				
	echo "&nbsp; &nbsp;<img src='img/orden/$need_orden/0.gif' border=0 alt='��������� �����: $orden_dis'>";
}
echo "<br><b>����: $price_gos ".$pr."</b><BR>";
echo "�������������: $iznos/$iznos_max<BR>";
if ($gravirovka!="")echo  "<BR><b>������������� �������:</b> <i>".$gravirovka."</i>";
print "<table width=100%><tr><td valign=top width=250>";
print "<b>��������� �����������:</b><BR>";
if($min_level)
{
	echo "&bull; ".($min_level>$db["level"]?"<font color=red>":"")."�������: $min_level</font><BR>";
}
if($min_s)
{
	echo "&bull; ".($min_s>$db["sila"]?"<font color=red>":"")."����: $min_s</font><BR>";
}
if($min_l)
{
	echo "&bull; ".($min_l>$db["lovkost"]?"<font color=red>":"")."��������: $min_l</font><BR>";
}
if($min_u)
{
	echo "&bull; ".($min_u>$db["udacha"]?"<font color=red>":"")."�����: $min_u</font><BR>";
}
if($min_p)
{
	echo "&bull; ".($min_p>$db["power"]?"<font color=red>":"")."������������: $min_p</font><BR>";
}
if($min_i)
{
	echo "&bull; ".($min_i>$db["intellekt"]?"<font color=red>":"")."���������: $min_i</font><BR>";
}
if($min_v)
{
	echo "&bull; ".($min_v>$db["vospriyatie"]?"<font color=red>":"")."�����������: $min_v</font><BR>";
}
if(!empty($sex))
{
	if($sex == "female" && $sex!=$sexy){$req_sex = "<font color=#FF0000>�������</font>";}
    else if($sex == "female" && $sex==$sexy){$req_sex = "<font color=#009900>�������</font>";}
    else if($sex == "male" && $sex==$sexy){$req_sex = "<font color=#009900>�������</font>";}
	else if($sex == "male" && $sex!=$sexy){$req_sex = "<font color=#FF0000>�������</font>";}
	echo "<BR>&bull; ���: $req_sex<BR>";
}		
print "</td><td valign=top><b>��������� ��:</b><BR>";
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
else if($add_hp<0)
{
	echo "&bull; ������� HP: <font color=#FF0000>$add_hp</font><BR>";
}
if($add_mana>0)
{
	echo "&bull; ������� ����: +$add_mana<BR>";
}
else if($add_mana<0)
{
	echo "&bull; ������� ����: <font color=#FF0000>$add_mana</font><BR>";
}
if($addsword_vl)
{
	echo "&bull; �������� ������: +$addsword_vl<BR>";
}
if($addaxe_vl)
{
	echo "&bull; �������� ��������, ��������: +$addaxe_vl<BR>";
}
if($addfail_vl)
{
	echo "&bull; �������� ��������, ��������: +$addfail_vl<BR>";
}
if($addknife_vl)
{
	echo "&bull; �������� ������, ���������: +$addknife_vl<BR>";
}
if($addspear_vl)
{
	echo "&bull; �������� ���������� ��������: +$addspear_vl<BR>";
}
if($p_h)
{
	echo "&bull; ����� ������: +$p_h<BR>";
}
if($p_c)
{
	echo "&bull; ����� �������: +$p_c<BR>";
}
if($p_a)
{
	echo "&bull; ����� ���: +$p_a<BR>";
}
if($p_p)
{
	echo "&bull; ����� �����: +$p_p<BR>";
}
if($p_l)
{
	echo "&bull; ����� ���: +$p_l<BR>";
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
if($add_cast>0)
{
	echo "&bull; ����������: +$add_cast<BR>";
}
if($mf_krit>0)
{
	echo "&bull; ���� ����. �����: +$mf_krit<BR>";
}
else if($mf_krit<0)
{
	echo "&bull; ���� ����. �����: $mf_krit<BR>";
}
if($mf_antikrit>0)
{
	echo "&bull; ���� ��������: +$mf_antikrit<BR>";
}
else if($mf_antikrit<0)
{
	echo "&bull; ���� ��������: $mf_antikrit<BR>";
}
if($mf_uvorot>0)
{
	echo "&bull; ���� �������: +$mf_uvorot<BR>";
}
else if($mf_uvorot<0)
{
	echo "&bull; ���� �������: $mf_uvorot<BR>";
}
if($mf_antiuvorot>0)
{
	echo "&bull; ���� �����������: +$mf_antiuvorot<BR>";
}
else if($mf_antiuvorot<0)
{
	echo "&bull; ���� �����������: $mf_antiuvorot<BR>";
}
if($min_a)
{
	echo "&bull; ����������� �����������: ".($min_a+ ($is_modified?$is_modified*5:0))."<BR>";
}
if($max_a)
{
	echo "&bull; ������������ �����������: ".($max_a+ ($is_modified?$is_modified*5:0))."<BR>";
}
print "</td></tr></table>";
echo ($noremont?"<small><font color=brown>������� �� �������� �������<br>������� ����� ������� ��  1 $pr</font></small>":"");
?>