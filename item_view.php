<?
echo "<td valign=top>";
echo "<B>$name".($is_modified?" +$is_modified":"")."</B> (Масса: $mass)";
if ($is_artefakt){$price_print="Пл.";}
else {$price_print="Зл.";}

if($gift)
{
	echo "&nbsp;<img src='img/icon/gift.gif' border=0 alt='Подарок от $gift_author'>";
}
if($is_artefakt)
{
	echo "&nbsp;<img src='img/icon/artefakt.gif' border=0 alt='Артефактная вещь'>";
}
if($is_personal)
{
	echo "&nbsp;<img src='img/icon/personal.gif' border=0 alt='Именная артефактная вещь.\nПринадлежит $personal_owner'>";
}
if($is_runa)
{
	echo "&nbsp; <img src='img/icon/runa.gif' alt='".$r_name["name"]."\n".$r_name["descs"]."'>";
}
if($is_aligned)
{
	switch ($is_aligned) 
	{
		 case 1:$orden_dis = "Стражи порядка";break;
		 case 2:$orden_dis = "Вампиры";break;
	 	 case 3:$orden_dis = "Орден Равновесия";break;
	 	 case 4:$orden_dis = "Орден Света";break;
	 	 case 5:$orden_dis = "Тюремный заключеный";break;
	 	 case 6:$orden_dis = "Истинный Мрак";break;
	}
	echo "&nbsp;<img src='img/orden/$is_aligned/0.gif' border=0 alt='Требуемый орден:\n$orden_dis'>";
}

echo "<br><b> Цена: $price_gos $price_print </b><BR>";
echo "Долговечность: $iznos/$iznos_max<BR>";
if ($edited>0)echo  "<b>Усилен:+$edited</b><br>";
if ($dat["add_xp"]>0)echo  "<b>Подогнано: ".$dat["add_xp"]." HP</b><br>";
if ($gravirovka!="")echo  "<b>Выгравирована надпись:</b> <i>".$gravirovka."</i><br>";
echo "<table width=100%><tr><td valign=top width=250><b>Требуется минимальное:</b><BR>";
if($min_s)
{
	if($min_s>$db["sila"])
	{
		echo "&bull; <font color=#FF0000>Сила: $min_s</font>";
	}
	else echo "&bull; Сила: $min_s";
	echo "<BR>";
}

if($min_l)
{
	if($min_l>$db["lovkost"])
	{
		echo "&bull; <font color=#FF0000>Ловкость: $min_l</font>";
	}
	else echo "&bull; Ловкость: $min_l";
	echo "<BR>";
}
if($min_u)
{
	if($min_u>$db["udacha"])
	{
		echo "&bull; <font color=#FF0000>Удача: $min_u</font>";
	}
	else echo "&bull; Удача: $min_u";
	echo "<BR>";
}
if($min_p)
{
	if($min_p>$db["power"])
	{
		echo "&bull; <font color=#FF0000>Выносливость: $min_p</font>";
	}
	else echo "&bull; Выносливость: $min_p";
	echo "<BR>";
}
if($min_i)
{
	if($min_i>$db["intellekt"])
	{
		$min_i="&bull; <font color=#FF0000>Интеллект: $min_i</font>";
	}
	else echo "&bull; Интеллект: $min_i";
	echo "<BR>";
}
if($min_v)
{
	if($min_v>$db["vospriyatie"])
	{
		$min_v="&bull; <font color=#FF0000>Воссприятие: $min_v</font>";
	}
	else echo "&bull; Воссприятие: $min_v";
	echo "<BR>";
}
if($min_level>$db["level"])
{
	echo "&bull; <font color=#FF0000>Уровень: $min_level</font>";
}
else echo "&bull; Уровень: $min_level";

echo "</td><td valign=top><b>Действие:</b><BR>";
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
if($add_hp)
{
	echo "&bull; Уровень HP: +".($add_hp+$dat["add_xp"]).($dat["add_xp"]?" <font color=green>[+".$dat["add_xp"]."]</font>":"")."<BR>";
}
if($add_mana)
{
	echo "&bull; Уровень маны: +$add_mana<BR>";
}
if($addsword_vl>0)
{
	echo "&bull; Владение мечами: +$addsword_vl<BR>";
}
if($addaxe_vl>0)
{
	echo "&bull; Владение топорами: +$addaxe_vl<BR>";
}
if($addfail_vl>0)
{
	echo "&bull; Владение дубинами: +$addfail_vl<BR>";
}
if($addknife_vl>0)
{
	echo "&bull; Владение ножами: +$addknife_vl<BR>";
}
if($addspear_vl>0)
{
	echo "&bull; Владение копьями: +$addspear_vl<BR>";
}
if($addstaff_vl>0)
{
	echo "&bull; Владение посохами: +$addstaff_vl<BR>";
}

if($p_h)
{
	echo "&bull; Броня головы: $p_h<BR>";
}
if($p_c)
{
	echo "&bull; Броня корпуса: $p_c<BR>";
}
if($p_a)
{
	echo "&bull; Броня рук: $p_a<BR>";
}
if($p_p)
{
	echo "&bull; Броня пояса: $p_p<BR>";
}
if($p_l)
{
	echo "&bull; Броня ног: $p_l<BR>";
}
if($mf_krit>0){
echo "&bull; Шанс крит. удара: +$mf_krit<BR>";
}
else if($mf_krit<0){
echo "&bull; Шанс крит. удара: $mf_krit<BR>";
}
if($mf_antikrit>0){
echo "&bull; Шанс антикрит: +$mf_antikrit<BR>";
}
else if($mf_antikrit<0){
echo "&bull; Шанс антикрит: $mf_antikrit<BR>";
}
if($mf_uvorot>0){
echo "&bull; Шанс уворота: +$mf_uvorot<BR>";
}
else if($mf_uvorot<0){
echo "&bull; Шанс уворота: $mf_uvorot<BR>";
}
if($mf_antiuvorot>0){
echo "&bull; Шанс антиуворота: +$mf_antiuvorot<BR>";
}
else if($mf_antiuvorot<0){
echo "&bull; Шанс антиуворота: $mf_antiuvorot<BR>";
}
if($min_a)
{
	echo "&bull; Мин. удар: ".($min_a+ ($is_modified?$is_modified*5:0))."<BR>";
}
if($max_a)
{
	echo "&bull; Макс. удар: ".($max_a+ ($is_modified?$is_modified*5:0))."<BR>";
}
?>
</td>
</tr></table>
<?echo ($noremont?"<small><font color=brown>Предмет не подлежит ремонту<br>Предмет можно продать за  1 $price_print</font></small>":"");?>
