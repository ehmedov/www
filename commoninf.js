function getalign(align)
{
	var n=parseFloat(align);
	if (n == 1) return("������ �������");
	if (n == 2) return("�������");
	if (n == 3) return("����� ����������");
	if (n == 4) return("����� �����");
	if (n == 5) return("�������� ����������");
	if (n == 6) return("�������� ����");
	if (n == 7) return("������� �����");
	if (n == 100) return("��������");
	return("");
}

function drbt(name, dealer, align, rang, klan,  klanid, hp, hpall, class_name,is_hit)
{
	var s="";
	var for_info=name;
	s+="<a href=\"javascript:top.AddToPrivate('"+name+"')\"><img border='0' src='img/arrow3.gif' alt='��������� ���������' ></a> ";
	if (align>0) s+="<img src='img/orden/"+align+"/"+rang+".gif'  alt='"+getalign(align)+"' border='0' /></a>";
	if (dealer>0)s+="<img src='img/orden/dealer.gif' border=0 alt='������ ����'>";
	if (klan) s+="<a href='clan_inf.php?clan="+klan+"' target='_blank'><img src='img/clan/"+klan+".gif'  alt='������� "+klanid+"' border='0' /></A>";
	s+="<a href=\"javascript:top.AddTo('"+name+"')\">";
	if(is_hit>0)name="<u>"+name+"</u>";
	s+="<span class='"+class_name+"'>"+name+"</span></a>";
	s+=" <a href='http://www.OlDmeydan.Pe.Hu/info.php?log="+for_info+"' target='_blank'><img src='http://www.OlDmeydan.Pe.Hu/img/index/h.gif' alt='���. � "+for_info+"' border='0' /></a> ";
	s+="["+hp+"/"+hpall+"]";
	document.write(s);
}


function lrb(name, level, dealer, align, rang, klan,  klanid, class_name)
{
	var s="";
	if (align>0) s+="<img src='img/orden/"+align+"/"+rang+".gif'  alt='"+getalign(align)+"' border='0' /></a>";
	if (dealer>0)s+="<img src='img/orden/dealer.gif' border=0 alt='������ ����'>";
	if (klan) s+="<a href='clan_inf.php?clan="+klan+"' target='_blank'><img src='img/clan/"+klan+".gif'  alt='������� "+klanid+"' border='0' /></A>";
	s+="<span class='"+class_name+"'>"+name+" ["+level+"]</span>";
	s+=" <a href='http://www.OlDmeydan.Pe.Hu/info.php?log="+name+"' target='_blank'><img src='http://www.OlDmeydan.Pe.Hu/img/index/h.gif' alt='���. � "+name+"' border='0' /></a>";
	document.write(s);
}


function drwfl(name, id, level, dealer, align, rang, klan, klanid)
{
	var s="";
	if (align>0) s+="<img src='http://www.OlDmeydan.Pe.Hu/img/orden/"+align+"/"+rang+".gif'  alt=\""+getalign(align)+"\" border='0' /></a> ";
	if (dealer>0)s+="<img src='http://www.OlDmeydan.Pe.Hu/img/orden/dealer.gif' border=0 alt=\"������ ����\">";

	if (klan) s+="<a href='http://www.OlDmeydan.Pe.Hu/clan_inf.php?clan="+klan+"' target='_blank'><img src='http://www.OlDmeydan.Pe.Hu/img/clan/"+klan+".gif'  alt='������� "+klanid+"' border='0' /></A>";
	s+="<b>"+name+"</b>";
	if (level!=-1) s+=" ["+level+"]";
	if (id!=-1) s+=" <a href='http://www.OlDmeydan.Pe.Hu/info.php?log="+name+"' target='_blank'><img src='http://www.OlDmeydan.Pe.Hu/img/index/h.gif' alt='���. � "+name+"' border='0' /></a>";

	document.write(s);
}
function wk(name, id, level, dealer, align, rang, klan, klanid,slp,trv)
{
	var timestamp = requestFile();
	var s="";
	if (align>0) s+="<img src='http://www.OlDmeydan.Pe.Hu/img/orden/"+align+"/"+rang+".gif'  alt=\""+getalign(align)+"\" border='0' /></a> ";
	if (dealer>0)s+="<img src='http://www.OlDmeydan.Pe.Hu/img/orden/dealer.gif' border=0 alt=\"������ ����\">";

	if (klan) s+="<a href='http://www.OlDmeydan.Pe.Hu/clan_inf.php?clan="+klan+"' target='_blank'><img src='http://www.OlDmeydan.Pe.Hu/img/clan/"+klan+".gif'  alt='������� "+klanid+"' border='0' /></A>";
	s+="<b>"+name+"</b>";
	if (level!=-1) s+=" ["+level+"]";
	if (id!=-1) s+="<a href='http://www.OlDmeydan.Pe.Hu/info.php?log="+name+"' target='_blank'><img src='http://www.OlDmeydan.Pe.Hu/img/index/h.gif' alt='���. � "+name+"' border='0' /></a>";
	if (slp>timestamp) { s+=' <img src=\"http://www.OlDmeydan.Pe.Hu/img/index/molch.gif\" alt=\"�������� �������� ��������\">'; }
	if (trv>0) { s+=' <img src=\"http://www.OlDmeydan.Pe.Hu/img/index/travma.gif\" alt=\"�������� �����������\">'; }
	document.write(s);
}
function w(name, id, level, dealer, align, rang, klan, klanid, slp, trv)
{
	var timestamp = requestFile();
	var s="";
	s+="<nobr><a href=\"javascript:top.AddToPrivate('"+name+"')\"><img border='0' src='http://www.OlDmeydan.Pe.Hu/img/arrow3.gif' alt='��������� ���������' ></a> ";
	if (align>0) s+="<img src='http://www.OlDmeydan.Pe.Hu/img/orden/"+align+"/"+rang+".gif'  alt=\""+getalign(align)+"\" border='0' /></a> ";
	if (dealer>0)s+="<img src='http://www.OlDmeydan.Pe.Hu/img/orden/dealer.gif' border=0 alt=\"������ ����\">";

	if (klan) s+="<a href='http://www.OlDmeydan.Pe.Hu/clan_inf.php?clan="+klan+"' target='_blank'><img src='http://www.OlDmeydan.Pe.Hu/img/clan/"+klan+".gif'  alt='������� "+klanid+"' border='0' /></A>";
	s+=" <a href='javascript:top.AddTo(\""+name+"\")'>"+name+"</a>";
	if (level!=-1) s+=" ["+level+"]";
	if (id!=-1) s+="<a href='http://www.OlDmeydan.Pe.Hu/info.php?log="+name+"' target=_blank><img src='http://www.OlDmeydan.Pe.Hu/img/index/h.gif' alt='���. � "+name+timestamp+"' border='0' /></a>";
	if (slp>timestamp) { s+=' <img src=\"http://www.OlDmeydan.Pe.Hu/img/index/molch.gif\" alt=\"�������� �������� ��������\">'; }
	if (trv>0) { s+=' <img src=\"http://www.OlDmeydan.Pe.Hu/img/index/travma.gif\" alt=\"�������� �����������\">'; }
	s+='</nobr><br>';
	document.write(s);
}

function info(name, id, level, dealer, align, rang, klan, klanid)
{
	var s="";
	if (align>0) s+="<img src='img/orden/"+align+"/"+rang+".gif'  alt=\""+getalign(align)+"\" border='0' /></a> ";
	if (dealer>0)s+="<img src='img/orden/dealer.gif' border=0 alt=\"������ ����\">";

	if (klan) s+="<a href='clan_inf.php?clan="+klan+"' target='_blank'><img src='img/clan/"+klan+".gif'  alt='������� "+klanid+"' border='0' /></A>";
	s+="<b>"+name+"</b>";
	if (level!=-1) s+=" ["+level+"]";
	if (id!=-1) s+=" <a href='info.php?log="+name+"' target='_blank'><img src='img/index/h.gif' alt='���. � "+name+"' border='0' /></a>";

	document.write(s);
}


function wks(name, id, level, dealer, align, rang, klan, klanid, slp, trv,slp_time)
{
	var s="";
	s+="<nobr><a href=\"javascript:top.AddToPrivate('"+name+"')\"><img border='0' src='http://www.OlDmeydan.Pe.Hu/img/arrow3.gif' alt='��������� ���������' ></a> ";
	if (align>0) s+="<img src='http://www.OlDmeydan.Pe.Hu/img/orden/"+align+"/"+rang+".gif'  alt=\""+getalign(align)+"\" border='0' /></a> ";
	if (dealer>0)s+="<img src='http://www.OlDmeydan.Pe.Hu/img/orden/dealer.gif' border=0 alt=\"������ ����\">";

	if (klan) s+="<a href='http://www.OlDmeydan.Pe.Hu/clan_inf.php?clan="+klan+"' target='_blank'><img src='http://www.OlDmeydan.Pe.Hu/img/clan/"+klan+".gif'  alt='������� "+klanid+"' border='0' /></A>";
	s+=" <a href='javascript:top.AddTo(\""+name+"\")'>"+name+"</a>";
	if (level!=-1) s+=" ["+level+"]";
	if (id!=-1) s+="<a href='http://www.OlDmeydan.Pe.Hu/info.php?log="+name+"' target=_blank><img src='http://www.OlDmeydan.Pe.Hu/img/index/h.gif' alt='���. � "+name+"' border='0' /></a>";
	if (slp>slp_time) { s+=' <img src=\"http://www.OlDmeydan.Pe.Hu/img/index/molch.gif\" alt=\"�������� �������� ��������\">'; }
	if (trv>0) { s+=' <img src=\"http://www.OlDmeydan.Pe.Hu/img/index/travma.gif\" alt=\"�������� �����������\">'; }
	s+='</nobr><br>';
	document.write(s);
}

function usr(name, id, level, dealer, align, rang, klan, klanid, slp, trv)
{
	var s="";
	s+="<nobr><a href=\"javascript:top.AddToPrivate('"+name+"')\"><img border='0' src='http://www.OlDmeydan.Pe.Hu/img/arrow3.gif' alt='��������� ���������' ></a> ";
	if (align>0) s+="<img src='http://www.OlDmeydan.Pe.Hu/img/orden/"+align+"/"+rang+".gif'  alt=\""+getalign(align)+"\" border='0' /></a> ";
	if (dealer>0)s+="<img src='http://www.OlDmeydan.Pe.Hu/img/orden/dealer.gif' border=0 alt=\"������ ����\">";

	if (klan) s+="<a href='http://www.OlDmeydan.Pe.Hu/clan_inf.php?clan="+klan+"' target='_blank'><img src='http://www.OlDmeydan.Pe.Hu/img/clan/"+klan+".gif'  alt='������� "+klanid+"' border='0' /></A>";
	s+=" <a href='javascript:top.AddTo(\""+name+"\")'>"+name+"</a>";
	if (level!=-1) s+=" ["+level+"]";
	if (id!=-1) s+="<a href='http://www.OlDmeydan.Pe.Hu/info.php?log="+name+"' target=_blank><img src='http://www.OlDmeydan.Pe.Hu/img/index/h.gif' alt='���. � "+name+"' border='0' /></a>";
	if (slp>0) { s+=' <img src=\"http://www.OlDmeydan.Pe.Hu/img/index/molch.gif\" alt=\"�������� �������� ��������\">'; }
	if (trv>0) { s+=' <img src=\"http://www.OlDmeydan.Pe.Hu/img/index/travma.gif\" alt=\"�������� �����������\">'; }
	s+='</nobr><br>';
	document.write(s);
}