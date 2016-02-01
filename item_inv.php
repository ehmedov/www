<?
echo "<b>".$name.($is_modified?" +$is_modified":"")."</b> (Масса: $mass)";
if($gift)
{
	print "&nbsp; &nbsp;<img src='img/icon/gift.gif' border=0 alt='Подарок от $gift_author'>";
}
if($is_artefakt)
{
	print "&nbsp; &nbsp;<img src='img/icon/artefakt.gif' border=0 alt='Артефактная вещь'>";
}
if($is_personal)
{
	print "&nbsp; &nbsp;<img src='img/icon/personal.gif' alt='Именная артефактная вещь.\nПринадлежит $personal_owner'>";
}
if($need_orden!=0)
{
	if($need_orden==1){$orden_dis="Братство Палачей";}
	else if($need_orden==2){$orden_dis="Вампиры";}
	else if($need_orden==3){$orden_dis="Орден Равновесия";}
	else if($need_orden==4){$orden_dis="Орден Света";}
	else if($need_orden==5){$orden_dis="Тюремный заключеный";}
	else if($need_orden==6){$orden_dis="Истинный Мрак";}				
	echo "&nbsp; &nbsp;<img src='img/orden/$need_orden/0.gif' border=0 alt='Требуемый орден: $orden_dis'>";
}
echo "<br><b>Цена: $price_gos ".$pr."</b><BR>";
echo "Долговечность: $iznos/$iznos_max<BR>";
if ($gravirovka!="")echo  "<BR><b>Выгравирована надпись:</b> <i>".$gravirovka."</i>";
print "<table width=100%><tr><td valign=top width=250>";
print "<b>Требуется минимальное:</b><BR>";
if($min_level)
{
	echo "&bull; ".($min_level>$db["level"]?"<font color=red>":"")."Уровень: $min_level</font><BR>";
}
if($min_s)
{
	echo "&bull; ".($min_s>$db["sila"]?"<font color=red>":"")."Сила: $min_s</font><BR>";
}
if($min_l)
{
	echo "&bull; ".($min_l>$db["lovkost"]?"<font color=red>":"")."Ловкость: $min_l</font><BR>";
}
if($min_u)
{
	echo "&bull; ".($min_u>$db["udacha"]?"<font color=red>":"")."Удача: $min_u</font><BR>";
}
if($min_p)
{
	echo "&bull; ".($min_p>$db["power"]?"<font color=red>":"")."Выносливость: $min_p</font><BR>";
}
if($min_i)
{
	echo "&bull; ".($min_i>$db["intellekt"]?"<font color=red>":"")."Интеллект: $min_i</font><BR>";
}
if($min_v)
{
	echo "&bull; ".($min_v>$db["vospriyatie"]?"<font color=red>":"")."Воссприятие: $min_v</font><BR>";
}
if(!empty($sex))
{
	if($sex == "female" && $sex!=$sexy){$req_sex = "<font color=#FF0000>женский</font>";}
    else if($sex == "female" && $sex==$sexy){$req_sex = "<font color=#009900>женский</font>";}
    else if($sex == "male" && $sex==$sexy){$req_sex = "<font color=#009900>мужской</font>";}
	else if($sex == "male" && $sex!=$sexy){$req_sex = "<font color=#FF0000>мужской</font>";}
	echo "<BR>&bull; Пол: $req_sex<BR>";
}		
print "</td><td valign=top><b>Действует на:</b><BR>";
if($add_s>0)
{
	echo "&bull; Сила: +$add_s<BR>";
}
else if($add_s<0)
{
	echo "&bull; Сила: <font color=#FF0000>$add_s</font><BR>";
}
if($add_l>0)
{
	echo "&bull; Ловкость: +$add_l<BR>";
}
else if($add_l<0)
{
	echo "&bull; Ловкость: <font color=#FF0000>$add_l</font><BR>";
}
if($add_u>0)
{
	echo "&bull; Удача: +$add_u<BR>";
}
else if($add_u<0)
{
	echo "&bull; Удача: <font color=#FF0000>$add_u</font><BR>";
}
if($add_i>0)
{
	echo "&bull; Интеллект: +$add_i<BR>";
}
else if($add_i<0)
{
	echo "&bull; Интеллект: <font color=#FF0000>+$add_i</font><BR>";
}
if($add_hp>0)
{
	echo "&bull; Уровень HP: +$add_hp<BR>";
}
else if($add_hp<0)
{
	echo "&bull; Уровень HP: <font color=#FF0000>$add_hp</font><BR>";
}
if($add_mana>0)
{
	echo "&bull; Уровень маны: +$add_mana<BR>";
}
else if($add_mana<0)
{
	echo "&bull; Уровень маны: <font color=#FF0000>$add_mana</font><BR>";
}
if($addsword_vl)
{
	echo "&bull; Владение мечами: +$addsword_vl<BR>";
}
if($addaxe_vl)
{
	echo "&bull; Владение топорами, секирами: +$addaxe_vl<BR>";
}
if($addfail_vl)
{
	echo "&bull; Владение дубинами, булавами: +$addfail_vl<BR>";
}
if($addknife_vl)
{
	echo "&bull; Владение ножами, кастетами: +$addknife_vl<BR>";
}
if($addspear_vl)
{
	echo "&bull; Владение древковоми оружиями: +$addspear_vl<BR>";
}
if($p_h)
{
	echo "&bull; Броня головы: +$p_h<BR>";
}
if($p_c)
{
	echo "&bull; Броня корпуса: +$p_c<BR>";
}
if($p_a)
{
	echo "&bull; Броня рук: +$p_a<BR>";
}
if($p_p)
{
	echo "&bull; Броня пояса: +$p_p<BR>";
}
if($p_l)
{
	echo "&bull; Броня ног: +$p_l<BR>";
}
if($add_fire>0)
{
	echo "&bull; Стихия огня: +$add_fire<BR>";
}
if($add_water>0)
{
	echo "&bull; Стихия воды: +$add_water<BR>";
}
if($add_air>0)
{
	echo "&bull; Стихия воздуха: +$add_air<BR>";
}
if($add_earth>0)
{
	echo "&bull; Стихия земли: +$add_earth<BR>";
}
if($add_cast>0)
{
	echo "&bull; Кастование: +$add_cast<BR>";
}
if($mf_krit>0)
{
	echo "&bull; Шанс крит. удара: +$mf_krit<BR>";
}
else if($mf_krit<0)
{
	echo "&bull; Шанс крит. удара: $mf_krit<BR>";
}
if($mf_antikrit>0)
{
	echo "&bull; Шанс антикрит: +$mf_antikrit<BR>";
}
else if($mf_antikrit<0)
{
	echo "&bull; Шанс антикрит: $mf_antikrit<BR>";
}
if($mf_uvorot>0)
{
	echo "&bull; Шанс уворота: +$mf_uvorot<BR>";
}
else if($mf_uvorot<0)
{
	echo "&bull; Шанс уворота: $mf_uvorot<BR>";
}
if($mf_antiuvorot>0)
{
	echo "&bull; Шанс антиуворота: +$mf_antiuvorot<BR>";
}
else if($mf_antiuvorot<0)
{
	echo "&bull; Шанс антиуворота: $mf_antiuvorot<BR>";
}
if($min_a)
{
	echo "&bull; Минимальное повреждение: ".($min_a+ ($is_modified?$is_modified*5:0))."<BR>";
}
if($max_a)
{
	echo "&bull; Максимальное повреждение: ".($max_a+ ($is_modified?$is_modified*5:0))."<BR>";
}
print "</td></tr></table>";
echo ($noremont?"<small><font color=brown>Предмет не подлежит ремонту<br>Предмет можно продать за  1 $pr</font></small>":"");
?>