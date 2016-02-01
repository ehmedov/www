<?function getalign($align)
{
	switch ($align) 
	{
		case 1:	return("Стражи порядка"); break;
		case 2:	return("Вампиры");break;
		case 3: return("Орден Равновесия");break;
		case 4: return("Орден Света");break;
		case 5: return("Тюремный заключеный");break;
		case 6: return("Истинный Мрак");break;
		case 100: return("Смертные");break;
	}
	return("");
}
function drwfl($name, $id, $level, $dealer,  $align, $rang, $klan, $klanid)
{
	$s="";
	if ($align>0) $s.="<img src='img/orden/$align/$rang.gif'  alt=\"".getalign($align)."\" border='0' /></a> ";
	if ($dealer>0)$s.="<img src='img/orden/dealer.gif' border=0 alt=\"Диллер игры\">";
	if ($klan) $s.="<a href='clan_inf.php?clan=".$klan."' target='_blank'><img src='img/clan/".$klan.".gif'  alt='Ханства ".$klanid."' border='0' /></A>";
	$s.="<b>".$name."</b>";
	if ($level!=-1) $s.=" [".$level."]";
	if ($id!=-1) $s.="<a onClick=\"window.open('info.php?log=$name', '_blank', '')\"; style='cursor:hand'><img src='img/index/h.gif' alt='Инф. о ".$name."' border='0' /></a>";
	return ($s);
}
function drwflbat($name, $id, $level, $dealer, $align, $rang, $klan, $klanid, $travma)
{
	$s="";
	if ($align>0) $s.="<img src='img/orden/$align/$rang.gif'  alt=\"".getalign($align)."\" border='0' /></a> ";
	if ($dealer>0)$s.="<img src='img/orden/dealer.gif' border=0 alt=\"Диллер игры\">";
	if ($klan) $s.="<a href='clan_inf.php?clan=".$klan."' target='_blank'><img src='img/clan/".$klan.".gif'  alt='Ханства ".$klanid."' border='0' /></A>";
	$s.="<b>".$name."</b>";
	if ($level!=-1) $s.=" [".$level."]";
	if ($id!=-1) $s.="<a onClick=\"window.open('info.php?log=$name', '_blank', '')\"; style='cursor:hand'><img src='img/index/h.gif' alt='Инф. о ".$name."' border='0' /></a>&nbsp;";
	if ($travma!=0)$s.="<img src=img/index/travma.gif alt=\"Персонаж травмирован\">";
	return ($s);
}
function drbt($name, $dealer, $align, $rang, $klan, $klanid, $can, $canall, $p)
{
	$s="";
	$s.="<a href=\"javascript:top.AddToPrivate('".$name."')\"><img border='0' src='img/arrow3.gif' alt='Приватное сообщение' ></a>&nbsp;";
	if ($align>0) $s.="<img src='img/orden/$align/$rang.gif'  alt=\"".getalign($align)."\" border='0' /></a>";
	if ($dealer>0)$s.="<img src='img/orden/dealer.gif' border=0 alt=\"Диллер игры\">";
	if ($klan) $s.="<a href='clan_inf.php?clan=".$klan."' target='_blank'><img src='img/clan/".$klan.".gif'  alt='Ханства ".$klanid."' border='0' /></A>";
	$s.="<a href='javascript:top.AddTo(\"".$name."\")'><span class=$p>".$name."</span></a>";
	$s.="[".$can."/".$canall."]";
	return ($s);
}
?>