var Hint3Name = '';
step=0;

//книги
function book() 
{
	var srcId, srcElement, targetElement;
	srcElement = window.event.srcElement;
	if (srcElement.className.toUpperCase() == "LEVEL1") 
	{
		srcID = srcElement.id.substr(0, srcElement.id.length-1);
		targetElement = document.getElementById(srcID + "s");
		srcElement = document.getElementById(srcID + "i");
		if (targetElement.style.display == "none")
		{
			targetElement.style.display = "";
			if(srcID=="OUTchaR")
			{
			}
			else
			{
				targetElement.style.left = 100;
				targetElement.style.top = document.body.scrollTop+50;
			}
		}
		else
		{
			targetElement.style.display = "none";
		}
	}
}
document.onclick = book;

//свитки

function showmagic()
{
	if(document.getElementById("magicform").style.display=="none")
	{
    	document.getElementById("magicform").style.display="";
	}
	else
	{
		document.getElementById("magicform").style.display="none";
	}
}

function errmess(s)
{
	messid.innerHTML='<B>'+s+'</B>';
	highlight();
}

function highlight()
{
  	if (step) return(0);
  	step=10;
  	setTimeout(dohi,50);
}

function dohi()
{
  	var hx=new Array(0,1,2,3,4,5,6,7,8,9,"A","B","C","D","E","F");
	step--;
  	messid.style.color="#"+hx[Math.floor(15-step/2)]+((step&1)?"F":"8")+"0000";
  	if (step>0) setTimeout(dohi,50);
}


function fixspaces(s)
{
  	while (s.substr(s.length-1,s.length)==" ") s=s.substr(0,s.length-1);
  	while (s.substr(0,1)==" ") s=s.substr(1,s.length);
  	return(s);
}


// Заголовок, название скрипта, имя поля с логином
function form(title, script, name, opis, mtype) {
	var s;
	s='<form action="'+script+'" method=POST name=slform><table border=0 width=100% cellspacing="0" cellpadding="2"><tr><td colspan=2>'+
	' '+opis+'</TD></TR><TR><TD width=50% align=right style="padding-left:5"><INPUT style="width: 200" TYPE="text" NAME="'+name+'" id="'+name+'"  value=""></TD><TD width=50%><INPUT type=image SRC="#IMGSRC#" WIDTH="27" HEIGHT="20" BORDER=0 ALT=""></TD></TR></TABLE></FORM>';
	s = crtmagic(mtype, title, s);
	document.getElementById("hint4").innerHTML = s;
	document.getElementById("hint4").style.visibility = "visible";
	document.getElementById("hint4").style.left = "400px";
	document.getElementById("hint4").style.top = document.body.scrollTop+50;
	document.getElementById(name).focus();
	Hint3Name = name;
}
function formforum(title, script, name, mtype) 
{
	var s;
	s='<form action="'+script+'" method=POST ><table border=0 width=100% cellspacing="0" cellpadding="2"><tr><td colspan=2>'+
	'</TD></TR><TR><TD width=50% align=right style="padding-left:5"><textarea rows=5 cols=35 NAME="'+name+'" id="'+name+'" ></textarea></TD><TD width=50%><INPUT type=image SRC="#IMGSRC#" WIDTH="27" HEIGHT="20" BORDER=0 ALT=""></TD></TR></TABLE></FORM>';
	s = crtmagic(mtype, title, s);
	document.getElementById("hint4").innerHTML = s;
	
	document.getElementById("hint4").style.visibility = "visible";
	document.getElementById("hint4").style.left = "500px";
	document.getElementById("hint4").style.top = document.body.scrollTop+120 + "px";
	document.getElementById(name).focus();
	Hint3Name = name;
}
//Silah adi...
function findwear(title, script, name, mtype) {
	var s;
	s='<form action="'+script+'" method=POST ><table border=0 width=100% cellspacing="0" cellpadding="2"><tr><td colspan=2>'+
	'Укажите название:<small></TD></TR><TR><TD width=50% align=right style="padding-left:5"><INPUT style="width: 100%" TYPE="text" NAME="'+name+'" id="'+name+'"  value=""></TD><TD width=50%><INPUT type=image SRC="#IMGSRC#" WIDTH="27" HEIGHT="20" BORDER=0 ALT=""></TD></TR></TABLE></FORM>';
	s = crtmagic(mtype, title, s);

	document.getElementById("hint4").innerHTML = s;
	document.getElementById("hint4").style.visibility = "visible";
	document.getElementById("hint4").style.left = "200px";
	document.getElementById("hint4").style.top = document.body.scrollTop+120;
	document.getElementById(name).focus();
	Hint3Name = name;
}

//свиток с целью вне боя
function findlogin(title, script, name, defaultlogin, mtype) {
	var s;
	s='<form action="'+script+'" method=POST ><table border=0 width=100% cellspacing="0" cellpadding="2"><tr><td colspan=2>'+
	'Укажите логин персонажа:<small><BR>(можно щелкнуть по логину в чате)</TD></TR><TR><TD width=50% align=right style="padding-left:5"><INPUT style="width: 100%" TYPE="text" NAME="'+name+'" id="'+name+'"  value="'+defaultlogin+'"></TD><TD width=50%><INPUT type=image SRC="#IMGSRC#" WIDTH="27" HEIGHT="20" BORDER=0 ALT="" ></TD></TR></TABLE></FORM>';
	s = crtmagic(mtype, title, s);

	document.getElementById("hint4").innerHTML = s;
	document.getElementById("hint4").style.visibility = "visible";
	document.getElementById("hint4").style.left = "200px";
	document.getElementById("hint4").style.top = document.body.scrollTop+120;
	document.getElementById(name).focus();
	Hint3Name = name;
}
//maqazin count
function countitems(title, script, name, mtype) 
{
	var s;
	s='<form action="'+script+'" method=POST name=slform>'+
	'<table border=0 width=100% cellspacing="0" cellpadding="2">'+
		'<tr><td width=30% nowrap>Количество:</TD><td style="padding-left:5" nowrap><INPUT  TYPE="text" NAME="item_count" maxlength=1 size=5></TD><TD width=50%><INPUT type=image SRC="#IMGSRC#" WIDTH="27" HEIGHT="20" BORDER=0 ALT=""></TD></TR></TABLE></FORM>';
	s = crtmagic(mtype, title, s);

	document.getElementById("hint4").innerHTML = s;
	document.getElementById("hint4").style.visibility = "visible";
	document.getElementById("hint4").style.left = 100;
	document.getElementById("hint4").style.top = document.body.scrollTop+120;
	slform.item_count.focus();
	Hint3Name = name;
}
//Inventar Add_UPS
function AddCount(title, script, name, mtype) 
{
	var s;
	s='<form action="'+script+'" method=POST name=slform>'+
	'<table border=0 width=100% cellspacing="0" cellpadding="2">'+
		'<tr><td colspan=2>Количество (шт.)</td></tr>'+
		'<tr><td width=50% align=right style="padding-left:5"><input type="text" NAME="'+name+'" id="'+name+'"  maxlength=3 size=5></TD><TD width=50%><INPUT type=image SRC="#IMGSRC#" WIDTH="27" HEIGHT="20" BORDER=0 ALT=""></TD></TR></TABLE></FORM>';
	s = crtmagic(mtype, title, s);

	document.getElementById("hint4").innerHTML = s;
	document.getElementById("hint4").style.visibility = "visible";
	document.getElementById("hint4").style.left = 100;
	document.getElementById("hint4").style.top = document.body.scrollTop+120;
	slform.item_count.focus();
	Hint3Name = name;
}
//AUCTION
function lot(title, script, name, mtype) 
{
	var s;
	s='<form action="'+script+'" method=POST name=slform><table border=0 width=100% cellspacing="0" cellpadding="2"><tr><td>'+
	'<b>'+name+'</b> </TD></TR><TR><TD valign=center>Укажите цену: <INPUT  TYPE="text" NAME="lot_price" maxlength=5 size=5> <INPUT type=image SRC="#IMGSRC#" WIDTH="27" HEIGHT="20" BORDER=0 ALT=""></TD></TR></TABLE></FORM>';
	s = crtmagic(mtype, title, s);

	document.getElementById("hint4").innerHTML = s;
	document.getElementById("hint4").style.visibility = "visible";
	document.getElementById("hint4").style.left = 100;
	document.getElementById("hint4").style.top = document.body.scrollTop+120;
	slform.lot_price.focus();
	Hint3Name = name;
}
// Заголовок, название скрипта, имя поля с логином, логин по умолчанию, тип оформления, тип с целью или без
function bMag(title, script, name, defaultlogin, mtype, btype, text){
	var s;

    if(btype==1){
	s='<form action="'+script+'" method=POST name=slform>'+
	'<table border=0 width=100% cellspacing="0" cellpadding="2"><tr>'+
    '<td colspan=2>'+text+'<br>Укажите логин персонажа:<small><BR>(можно щелкнуть по логину в чате)</TD>'+
    '</TR><TR><TD width=50% align=right style="padding-left:5"><INPUT style="width: 100%" TYPE="text" NAME="'+name+'" id="'+name+'"  value="'+defaultlogin+'"></TD>'+
    '<TD width=50%><INPUT type=image SRC="#IMGSRC#" WIDTH="27" HEIGHT="20" BORDER=0 ALT="" ></TD></TR></TABLE></FORM>';
    }
    else if(btype==2)
    {
		s='<form action="'+script+'" method=POST name=slform>'+
		'<table border=0 width=100% cellspacing="0" cellpadding="2"><tr>'+
    	'<td colspan=2>'+text+'<br>Укаждите вашу цену:</TD>'+
    	'</TR><TR><TD width=50% align=right style="padding-left:5"><INPUT style="width: 100%" TYPE="text" NAME="'+name+'" id="'+name+'"  value="'+defaultlogin+'"></TD>'+
    	'<TD width=50%><INPUT type=submit  WIDTH="27" HEIGHT="20" BORDER=0 value=Ok ></TD></TR></TABLE></FORM>';
    }
    else
    {
		s='<form action="'+script+'" method=POST name=slform><table border=0 width=100% cellspacing="0" cellpadding="2"><tr><td colspan=2>'+
	    text+'</TD></TR><TR><TD width=50% align=left><INPUT class=new TYPE="submit" name="tmpname423" value="Да" style="width:70%"></TD>'+
	    '<TD width=50% align=right><INPUT class=new type=button style="width:70%" value="Нет" onclick="closehint3();"></TD></TR></TABLE></FORM>';
    }

	s = crtmagic(mtype, title, s);

	document.getElementById("hint4").innerHTML = s;
	document.getElementById("hint4").style.visibility = "visible";
	document.getElementById("hint4").style.left = 100;
	document.getElementById("hint4").style.top = document.body.scrollTop+200;
	document.getElementById(name).focus();
	Hint3Name = name;
}

//цель плюс причина
function loginP(title, script, name, defaultlogin, mtype) {
	var s;
	s='<form action="'+script+'" method=POST name=action><table border=0 width=100% cellspacing="0" cellpadding="2"><tr><td colspan=2>'+
	'Укажите логин персонажа:<small><BR>(можно щелкнуть по логину в чате)</TD></TR><TR><TD width=80% align=right style="padding-left:5"><INPUT style="width: 100%" TYPE="text" NAME="'+name+'" id="'+name+'"  value="'+defaultlogin+'"></TD><TD width=20%></TD></TR><TR><TD colspan=2>'+
	'Укажите причину:</TD></TR><TR><TD width=80% align=right style="padding-left:5"><INPUT style="width: 100%" TYPE="text" NAME="text" value=""></TD><TD width=20%><INPUT type=image SRC="#IMGSRC#" WIDTH="27" HEIGHT="20" BORDER=0 ALT=""></TD></TR></TABLE></FORM>';
	s = crtmagic(mtype, title, s);

	document.getElementById("hint4").innerHTML = s;
	document.getElementById("hint4").style.visibility = "visible";
	document.getElementById("hint4").style.left = 300;
	document.getElementById("hint4").style.top = document.body.scrollTop+50;
	document.getElementById(name).focus();
	Hint3Name = name;
}
//lock
function lock(title, script, name, defaultlogin, mtype) {
	var s;
	s='<form action="'+script+'" method=POST name=action><table border=0 width=100% cellspacing="0" cellpadding="2"><tr><td colspan=2>'+
	'Укажите пароль:</TD></TR><TR><TD width=80% align=right style="padding-left:5"><INPUT style="width: 100%" TYPE="text" NAME=pass1></TD><TD width=20%></TD></TR><TR><TD colspan=2>'+
	'Повторите пароль:</TD></TR><TR><TD width=80% align=right style="padding-left:5"><INPUT style="width: 100%" TYPE="text" NAME="pass2" value=""></TD><TD width=20%><INPUT type=image SRC="#IMGSRC#" WIDTH="27" HEIGHT="20" BORDER=0 ALT=""></TD></TR></TABLE></FORM>';
	s = crtmagic(mtype, title, s);

	document.getElementById("hint4").innerHTML = s;
	document.getElementById("hint4").style.visibility = "visible";
	document.getElementById("hint4").style.left = 300;
	document.getElementById("hint4").style.top = document.body.scrollTop+50;
	document.getElementById(name).focus();
	Hint3Name = name;
}
//пдтвержение использования
function dialogconfirm(title, script, text, mtype) {
	var s;

	s='<form action="'+script+'" method="post" name="slform">'+
	'<table border=0 width=100% cellspacing="0" cellpadding="2">'+
	'<tr><td colspan=2>'+text+'</td></tr>'+
	'<tr><td width=50% align=left><input type="submit" name="tmpname423" id="tmpname423" value="Да"  class="new" style="width:70%"></td><td width=50% align=right><input class="new" type=button style="width:70%" value="Нет" onclick="closehint3();"></td></tr>'+
	'</table></form>';
	s = crtmagic(mtype, title, s);
	document.getElementById("hint4").innerHTML = s;
	document.getElementById("hint4").style.visibility = "visible";
	document.getElementById("hint4").style.left = 100;
	document.getElementById("hint4").style.top = document.body.scrollTop+50;
	document.getElementById("tmpname423").focus();
	Hint3Name = name;
}

//пдтвержение использования
function Daily_Gift(title, script, text, mtype) {
	var s;

	s='<form action="'+script+'" method="post" name="slform">'+
	'<table border=0 width=100% cellspacing="0" cellpadding="2">'+
	'<tr><td colspan=2>'+text+'</td></tr>'+
	'<tr><td width=50% align=left><input type="submit" name="yes" id="yes" value="Да"  class="new" style="width:70%"></td><td width=50% align=right><input class="new" type="submit" name="no" value="Нет" style="width:70%"></td></tr>'+
	'</table></form>';
	s = crtmagic(mtype, title, s);
	document.getElementById("hint_gift").innerHTML = s;
	document.getElementById("hint_gift").style.visibility = "visible";
	document.getElementById("hint_gift").style.left = 350;
	document.getElementById("hint_gift").style.top = document.body.scrollTop+50;
	document.getElementById("yes").focus();

}
//пдтвержение использования
function confirmetion(title, id, script, text, mtype) {
	var s;

	s='<table border=0 width=100% cellspacing="0" cellpadding="2"><tr>'+
	text+'</TD></TR><TR><TD width=50% align=left><INPUT class=new TYPE="text" name="char_id" value="'+id+'" style="display:none;"><INPUT class=new TYPE="submit" name="tmpname423" value="Да" style="width:70%"></TD><TD width=50% align=right><INPUT class=new type=button style="width:70%" value="Нет" onclick="closehint3();"></TD></TR></FORM></TABLE>';

	s = crtmagic(mtype, title, s);
	document.getElementById("hint4").innerHTML = s;

	document.getElementById("hint4").style.visibility = "visible";
	document.getElementById("hint4").style.left = 150;
	document.getElementById("hint4").style.top = document.body.scrollTop+150;
	document.getElementById("tmpname423").focus();
	Hint3Name = name;
}

//типа красивый алерт
function dialogOK(title, text, mtype) {
	var s;

	s='<table border=0 width=100% cellspacing="0" cellpadding="2"><tr><td colspan=2>'+
	text+'</TD></TR><TR><TD width=100% align=right><INPUT type=button style="width:70%" value="Закрыть" onclick="closehint3();"></TD></TR></FORM></TABLE>';

	s = crtmagic(mtype, title, s);
	document.getElementById("hint4").innerHTML = s;
	document.getElementById("hint4").style.visibility = "visible";
	document.getElementById("hint4").style.left = 100;
	document.getElementById("hint4").style.top = document.body.scrollTop+50;
	Hint3Name = name;
}


function foundmagictype (mtypes) {
	if (mtypes) {
		mtypes=mtypes+"";
		if (mtypes.indexOf(',') == -1) return parseInt(mtypes);
		var s=mtypes.split(',');
		var found=0;
		var doubl=0;
		var maxfound=0;

		for (i=0; i < s.length; i++) {
			var k=parseInt(s[i]);
			if (k > maxfound) {
				found=i + 1;
				maxfound=k;
				doubl=0;
			} else {
				if (k == maxfound) {doubl=1;}
			}
		}
		if (doubl) {return 0};

		return found;
	}
	return 0;
}
// Для магии. Заголовок, название скрипта, название магии, номер вещицы в рюкзаке, логин по умолчанию, описание доп. поля
//2 поля типа экстра форм
function magicklogin(title, script, magickname, n, defaultlogin, extparam, mtype) {

	var s = '<form action="'+script+'" method=POST name=slform><table border=0 width=100% cellspacing="0" cellpadding="2"><tr><input type=hidden name="use" value="'+magickname+'"><input type=hidden name="n" value="'+n+'"><td colspan=2>'+
	'Укажите логин персонажа:<small><BR>(можно щелкнуть по логину в чате)</TD></TR><TR><TD style="padding-left:5" width=50% align=right><INPUT TYPE="text" NAME="param" value="'+defaultlogin+'" style="width: 100%"></TD><TD width=50%><INPUT type=image SRC="#IMGSRC#" WIDTH="27" HEIGHT="20" BORDER=0 ALT=""></TD></TR>';
	if (extparam != null && extparam != '') {
		s = s + '<TR><td style="padding-left:5">'+extparam+'<BR><INPUT style="width: 100%" TYPE="text" NAME="param2"></TD><TD></TR>';
	}
	s = s + '</TABLE></FORM>';
	s = crtmagic(mtype, title, s);
	document.getElementById("hint4").innerHTML = s;
	document.getElementById("hint4").style.visibility = "visible";
	document.getElementById("hint4").style.left = 100;
	document.getElementById("hint4").style.top = document.body.scrollTop+50;
	document.getElementById("param").focus();
	Hint3Name = 'param';
}

// Магия
//хз
function UseMagick(title, script, name, extparam, n, extparam2, mtype) 
{
	if ((extparam != null)&&(extparam != '')) 
	{
		var t1='text',t2='text';

		if (extparam.substr(0,1) == "!")
		{
			t1='password';
			extparam=extparam.substr(1,extparam.length);
		}

		var s = '<form action="'+script+'" method=POST><table border=0 width=100% cellspacing="1" cellpadding="0"><TR><input type=hidden name="use" value="'+name+'"><input type=hidden name="n" value="'+n+'"><td colspan=2 align=left><NOBR><SMALL>'+
		extparam + ':</NOBR></TD></TR><TR><TD width=100% align=left style="padding-left:5"><INPUT tabindex=1 style="width: 100%" TYPE="'+t1+'" id="param" NAME="param" value=""></TD><TD width=10%><INPUT type=image SRC="#IMGSRC#" WIDTH="27" HEIGHT="20" BORDER=0 ALT="" tabindex=3></TD></TR>';
		if (extparam2 != null && extparam2 != '') 
		{
			if (extparam2.substr(0,1) == "!")
			{
				t2='password';
				extparam2=extparam2.substr(1,extparam2.length);
			}
			s = s + '<TR><td colspan=2><NOBR><SMALL>'+extparam2+':</NOBR><TR style="padding-left:5"><TD><INPUT tabindex=2 TYPE="'+t2+'" NAME="param2" style="width: 50%"></TD><TD></TR>';
		}
		s += '</TABLE></FORM>';
		s = crtmagic(mtype, title, s);
		document.getElementById("hint4").innerHTML = s;
		document.getElementById("hint4").style.visibility = "visible";
		document.getElementById("hint4").style.left = 100;
		document.getElementById("hint4").style.top = document.body.scrollTop+50;
		document.getElementById("param").focus();
		Hint3Name = 'param';
	} 
	else 
	{
		dialogconfirm('Подтверждение', script, '<TABLE width=100%><TD><IMG src="img/'+name+'"></TD><TD>Использовать сейчас?</TABLE>'+
		'<input type=hidden name="use" value="'+name+'"><input type=hidden name="n" value="'+n+'">', mtype);
	}
}

// Закрывает окно ввода логина
function closehint3()
{
	document.getElementById("hint4").style.visibility="hidden";
    Hint3Name='';
}



function crtmagic(mtype, title, body, subm) {
//name, XYX, X1-X2-Y2, pad.LRU
	mtype=foundmagictype(mtype);

var names=new Array(
'neitral',17, 6, 14, 17, 14, 7,0,0, 3,
'fire', 57, 30, 33, 20, 21, 14, 11, 12, 0,
'water', 57, 30, 33, 20, 21, 14, 11, 12, 0,
'air', 57, 30, 33, 20, 21, 14, 11, 12, 0,
'earth', 57,30, 33, 20, 21, 14, 11, 12, 0,
'white', 51, 25, 46, 44, 44, 10, 5, 5, 0,
'gray', 51, 25, 46, 44, 44, 10, 5, 5, 0,
'black', 51, 25, 46, 44, 44, 10, 5, 5, 0);
var colors=new Array('B1A993','DDD5BF', 'ACA396','D3CEC8', '96B0C6', 'BDCDDB', 'AEC0C9', 'CFE1EA', 'AAA291', 'D5CDBC', 'BCBBB6', 'EFEEE9', '969592', 'DADADA', '72726B', 'A6A6A0');

while (body.indexOf('#IMGSRC#')>=0) body = body.replace('#IMGSRC#', 'http://www.meydan.az/img/dmagic/'+names[mtype*10]+'_30.gif');
var s='<table width="270" border="0" align="center" cellpadding="0" cellspacing="0">'+
	'<tr>'+
	'<td width="100%">'+
	'<table width="100%"  border="0" cellspacing="0" cellpadding="0">'+
	'<tr><td>'+
		'<table width="100%" border="0" cellpadding="0" cellspacing="0">'+
		'<tr>'+
		'<td width="'+names[mtype*10+1]+'" align="left"><img src="http://www.meydan.az/img/dmagic/b'+names[mtype*10]+'_03.gif" width="'+names[mtype*10+1]+'" height="'+names[mtype*10+2]+'"></td>'+
		'<td width="100%" align="right" background="http://www.meydan.az/img/dmagic/b'+names[mtype*10]+'_05.gif"></td>'+
		'<td width="'+names[mtype*10+3]+'" align="right"><img src="http://www.meydan.az/img/dmagic/b'+names[mtype*10]+'_07.gif" width="'+names[mtype*10+3]+'" height="'+names[mtype*10+2]+'"></td>'+
		'</tr>'+
		'</table></td>'+
	'</tr>'+
	'<tr><td>'+
		'<table width="100%" border="0" cellspacing="0" cellpadding="0">'+
		'<tr>'+
			(names[mtype*10+7]?'<td width="'+names[mtype*10+7]+'"><SPAN style="width:'+names[mtype*10+7]+'">&nbsp;</SPAN></td>':'')+
			'<td width="5" background="http://www.meydan.az/img/dmagic/b'+names[mtype*10]+'_17.gif">&nbsp;</td>'+
			'<td width="100%">'+
			'<table width="100%" border="0" cellspacing="0" cellpadding="0">'+
			'<tr><td bgcolor="#'+colors[mtype*2]+'"'+(names[mtype*10+9]?' style="padding-top: '+names[mtype*10+9]+'"':'')+' >'+
			'<table border=0 width=100% cellspacing="0" cellpadding="0"><td style="padding-left: 20" align=center><B>'+title+
			'</td><td width=20 align=right valign=top style="cursor: pointer" onclick="closehint3();" style=\'filter:Gray()\' onmouseover="this.filters.Gray.Enabled=false" onmouseout="this.filters.Gray.Enabled=true"><IMG src="http://www.meydan.az/img/dmagic/clear.gif" width=13 height=13>&nbsp;</td></table>'+
			'</td></tr>'+
			'<tr>'+
				'<td align="center" bgcolor="#'+colors[mtype*2+1]+'">'+body+
			'</tr>'+
			'</table></td>'+
			'<td width="5" background="http://www.meydan.az/img/dmagic/b'+names[mtype*10]+'_19.gif">&nbsp;</td>'+
			(names[mtype*10+8]?'<td width="'+names[mtype*10+8]+'"><SPAN style="width:'+names[mtype*10+8]+'">&nbsp;</SPAN></td></td>':'')+
			'</tr>'+
		'</table></td>'+
	'</tr>'+
	'<tr><td>'+
		'<table width="100%"  border="0" cellpadding="0" cellspacing="0">'+
		'<tr>'+
			'<td width="'+names[mtype*10+4]+'" align="left"><img src="http://www.meydan.az/img/dmagic/b'+names[mtype*10]+'_27.gif" width="'+names[mtype*10+4]+'" height="'+names[mtype*10+6]+'"></td>'+
			'<td width="100%" align="right" background="http://www.meydan.az/img/dmagic/b'+names[mtype*10]+'_29.gif"></td>'+
			'<td width="'+names[mtype*10+5]+'" align="right"><img src="http://www.meydan.az/img/dmagic/b'+names[mtype*10]+'_31.gif" width="'+names[mtype*10+5]+'" height="'+names[mtype*10+6]+'"></td>'+
		'</tr>'+
		'</table></td>'+
	'</tr>'+
	'</table></td>'+
'</tr>'+
'</table>';

	return s;
}