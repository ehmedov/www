<?
function getalign($align)
{
	switch ($align) 
	{
		case 1:	return("������ �������"); break;
		case 2:	return("�������");break;
		case 3: return("����� ����������");break;
		case 4: return("����� �����");break;
		case 5: return("�������� ����������");break;
		case 6: return("�������� ����");break;
		case 100: return("��������");break;
	}
	return("");
}
function drwfl($name, $id, $level, $dealer,  $align, $rang, $klan, $klanid, $travma)
{
	$s="";
	if ($align>0) $s.="<img src='http://www.meydan.az/img/orden/$align/$rang.gif'  title=\"".getalign($align)."\" border='0' /> ";
	if ($dealer>0)$s.="<img src='http://www.meydan.az/img/orden/dealer.gif' border='0' title=\"������ ����\" /> ";
	if ($klanid) $s.="<a href='clan_inf.php?clan=".$klanid."'><img src='http://www.meydan.az/img/clan/".$klanid.".gif'  title='������� ".$klan."' border='0' /></a> ";
	$s.="<b>".$name."</b> [".$level."]";
	if ($id!=-1) $s.="<a href='info.php?log=$name' style='cursor:hand'><img src='http://www.meydan.az/img/index/h.gif' title='���. � ".$name."' border='0' /></a>";
	if ($travma!=0)$s.=" <img src='http://www.meydan.az/img/index/travma.gif' title=\"�������� �����������\" />";
	return ($s);
}

function drbt($name, $id, $level, $dealer,  $align, $rang, $klan, $klanid, $can, $canall, $p)
{
	$s="";
	if ($align>0) $s.="<img src='http://www.meydan.az/img/orden/$align/$rang.gif'  title=\"".getalign($align)."\" border='0' /> ";
	if ($dealer>0)$s.="<img src='http://www.meydan.az/img/orden/dealer.gif' border='0' title=\"������ ����\" /> ";
	if ($klanid) $s.="<a href='clan_inf.php?clan=".$klanid."'><img src='http://www.meydan.az/img/clan/".$klanid.".gif'  title='������� ".$klan."' border='0' /></a> ";
	$s.="<span class=$p>".$name."</span> [".$level."]";
	if ($id!=-1) $s.="<a href='info.php?log=$name'><img src='http://www.meydan.az/img/index/h.gif' title='���. � ".$name."' border='0' /></a>";
	$s.="[".$can."/".$canall."]";
	return ($s);
}
?>