var Hint3Name = '';
step=0;
//�����
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
			if(srcID=="OUTchaR"){}else
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

//������
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


//--------------------------- ���������, �������� �������, ��� ���� � �������------------------------------
function form(title, script, name, opis, mtype) {
	var s;
	s='<form action="'+script+'" method=POST name=slform><table border=0 width=100% cellspacing="0" cellpadding="2"><tr><td colspan=2>'+
	' '+opis+'</TD></TR><TR><TD width=50% align=right style="padding-left:5"><INPUT style="width: 200" TYPE="text" NAME="'+name+'" id="'+name+'"  value=""></TD><TD width=50%><INPUT type=image SRC="#IMGSRC#" WIDTH="27" HEIGHT="20" BORDER=0 ALT=""></TD></TR></TABLE></FORM>';
	s = crtmagic(mtype, title, s);
	document.getElementById("hint4").innerHTML = s;
	document.getElementById("hint4").style.visibility = "visible";
	document.getElementById("hint4").style.left = 300;
	document.getElementById("hint4").style.top = document.body.scrollTop+50;
	document.getElementById(name).focus();
	Hint3Name = name;
}
//--------------------------------------------------------------------------------
function formTextarea(title, script, name, opis, mtype) {
	var s;
	s='<form action="'+script+'" method=POST name=slform><table border=0 width=100% cellspacing="0" cellpadding="2"><tr><td colspan=2>'+
	' '+opis+'</TD></TR><TR><TD width=50% align=right style="padding-left:5"><textarea rows="5" NAME="'+name+'" id="'+name+'"  cols="40"></textarea></TD><TD width=50%><INPUT type=image SRC="#IMGSRC#" WIDTH="27" HEIGHT="20" BORDER=0 ALT=""></TD></TR></TABLE></FORM>';
	s = crtmagic(mtype, title, s);
	document.getElementById("hint4").innerHTML = s;
	document.getElementById("hint4").style.visibility = "visible";
	document.getElementById("hint4").style.left = 300;
	document.getElementById("hint4").style.top = document.body.scrollTop+50;
	document.getElementById(name).focus();
	Hint3Name = name;
}
//---------------------------������ � ����� ��� ���------------------------------
function findlogin(title, script, name, defaultlogin, mtype) {
	var s;
	s='<form action="'+script+'" method=POST ><table border=0 width=100% cellspacing="0" cellpadding="2"><tr><td colspan=2>'+
	'������� ����� ���������:<small><BR>(����� �������� �� ������ � ����)</TD></TR><TR><TD width=50% align=right style="padding-left:5"><INPUT style="width: 100%" TYPE="text" NAME="'+name+'" id="'+name+'"  value="'+defaultlogin+'"></TD><TD width=50%><INPUT type=image SRC="#IMGSRC#" WIDTH="27" HEIGHT="20" BORDER=0 ALT=""></TD></TR></TABLE></FORM>';
	s = crtmagic(mtype, title, s);

	document.getElementById("hint4").innerHTML = s;
	document.getElementById("hint4").style.visibility = "visible";
	document.getElementById("hint4").style.left = 300;
	document.getElementById("hint4").style.top = document.body.scrollTop+50;
	document.getElementById(name).focus();
	Hint3Name = name;
}
//---------------------------������ � ����� ��� ���------------------------------
function findlogin_pass(title, script, name, defaultlogin, mtype) {
	var s;
	s='<form action="'+script+'" method=POST ><table border=0 width=100% cellspacing="0" cellpadding="2"><tr><td colspan=2>'+
	'������� ������:</TD></TR><TR><TD width=50% align=right style="padding-left:5"><INPUT style="width: 100%" TYPE="password" NAME="'+name+'" id="'+name+'"  value="'+defaultlogin+'"></TD><TD width=50%><INPUT type=image SRC="#IMGSRC#" WIDTH="27" HEIGHT="20" BORDER=0 ALT=""></TD></TR></TABLE></FORM>';
	s = crtmagic(mtype, title, s);

	document.getElementById("hint4").innerHTML = s;
	document.getElementById("hint4").style.visibility = "visible";
	document.getElementById("hint4").style.left = 500;
	document.getElementById("hint4").style.top  = 100;
	document.getElementById(name).focus();
	//Hint3Name = name;
}
//---------------------------cngmail------------------------------
function cngmail(title, script, name, defaultlogin, mtype) {
	var s;
	s='<form action="'+script+'" method=POST ><table border=0 width=100% cellspacing="0" cellpadding="2"><tr><td>'+
	'�����:</TD><TD align=left><INPUT  TYPE="text" NAME="'+name+'" id="'+name+'"  value="'+defaultlogin+'"></TD></TR><TR><TD>'+
	'����� E-mail:</TD><TD align=left><INPUT TYPE="text" NAME="email" value=""></TD></TR>'+	
	'<TR><TD colspan=2 align=right><INPUT type=image SRC="#IMGSRC#" WIDTH="27" HEIGHT="20" BORDER=0 ALT=""></TD></TR></TABLE></FORM>';
	s = crtmagic(mtype, title, s);

	document.getElementById("hint4").innerHTML = s;
	document.getElementById("hint4").style.visibility = "visible";
	document.getElementById("hint4").style.left = 300;
	document.getElementById("hint4").style.top = document.body.scrollTop+50;
	document.getElementById(name).focus();
	Hint3Name = name;
}
//---------------------------cngpass------------------------------
function cngpass(title, script, name, defaultlogin, mtype) {
	var s;
	s='<form action="'+script+'" method=POST ><table border=0 width=100% cellspacing="0" cellpadding="2"><tr><td>'+
	'�����:</TD><TD align=left><INPUT  TYPE="text" NAME="'+name+'" id="'+name+'"  value="'+defaultlogin+'"></TD></TR><TR><TD>'+
	'����� ������:</TD><TD align=left><INPUT TYPE="text" NAME="new_pass" value=""></TD></TR>'+	
	'<TR><TD colspan=2 align=right><INPUT type=image SRC="#IMGSRC#" WIDTH="27" HEIGHT="20" BORDER=0 ALT=""></TD></TR></TABLE></FORM>';
	s = crtmagic(mtype, title, s);

	document.getElementById("hint4").innerHTML = s;
	document.getElementById("hint4").style.visibility = "visible";
	document.getElementById("hint4").style.left = 300;
	document.getElementById("hint4").style.top = document.body.scrollTop+50;
	document.getElementById(name).focus();
	Hint3Name = name;
}
//---------------------------cnglogin------------------------------
function cnglogin(title, script, name, defaultlogin, mtype) {
	var s;
	s='<form action="'+script+'" method=POST ><table border=0 width=100% cellspacing="0" cellpadding="2"><tr><td>'+
	'�����:</TD><TD align=left><INPUT  TYPE="text" NAME="'+name+'" id="'+name+'"  value="'+defaultlogin+'"></TD></TR><TR><TD>'+
	'����� �����:</TD><TD align=left><INPUT TYPE="text" NAME="newlogin" value=""></TD></TR>'+	
	'<TR><TD colspan=2 align=right><INPUT type=image SRC="#IMGSRC#" WIDTH="27" HEIGHT="20" BORDER=0 ALT=""></TD></TR></TABLE></FORM>';
	s = crtmagic(mtype, title, s);

	document.getElementById("hint4").innerHTML = s;
	document.getElementById("hint4").style.visibility = "visible";
	document.getElementById("hint4").style.left = 300;
	document.getElementById("hint4").style.top = document.body.scrollTop+50;
	document.getElementById(name).focus();
	Hint3Name = name;
}
//---------------------------takenaqrada------------------------------
function takenaqrada(title, script, name, defaultlogin, mtype) {
	var s;
	s='<form action="'+script+'" method=POST ><table border=0 width=100% cellspacing="0" cellpadding="2"><tr><td>'+
	'����� :</TD><TD align=left><INPUT  TYPE="text" NAME="'+name+'" id="'+name+'"  value="'+defaultlogin+'"></TD></TR><TR><TD>'+
	'������� :</TD><TD align=left><INPUT TYPE="text" NAME="zoloto" value=""></TD></TR>'+	
	'<TR><TD colspan=2 align=right><INPUT type=image SRC="#IMGSRC#" WIDTH="27" HEIGHT="20" BORDER=0 ALT=""></TD></TR></TABLE></FORM>';
	s = crtmagic(mtype, title, s);

	document.getElementById("hint4").innerHTML = s;
	document.getElementById("hint4").style.visibility = "visible";
	document.getElementById("hint4").style.left = 300;
	document.getElementById("hint4").style.top = document.body.scrollTop+50;
	document.getElementById(name).focus();
	Hint3Name = name;
}
//---------------------------takemoney------------------------------
function givenaqrada(title, script, name, defaultlogin, mtype) {
	var s;
	s='<form action="'+script+'" method=POST ><table border=0 width=100% cellspacing="0" cellpadding="2"><tr><td>'+
	'����� :</TD><TD align=left><INPUT  TYPE="text" NAME="'+name+'" id="'+name+'"  value="'+defaultlogin+'"></TD></TR><TR><TD>'+
	'������� :</TD><TD align=left><INPUT TYPE="text" NAME="naqrada" value=""></TD></TR>'+	
	'<TR><TD colspan=2 align=right><INPUT type=image SRC="#IMGSRC#" WIDTH="27" HEIGHT="20" BORDER=0 ALT=""></TD></TR></TABLE></FORM>';
	s = crtmagic(mtype, title, s);

	document.getElementById("hint4").innerHTML = s;
	document.getElementById("hint4").style.visibility = "visible";
	document.getElementById("hint4").style.left = 300;
	document.getElementById("hint4").style.top = document.body.scrollTop+50;
	document.getElementById(name).focus();
	Hint3Name = name;
}
//---------------------------takemoney------------------------------
function takemoney(title, script, name, defaultlogin, mtype) {
	var s;
	s='<form action="'+script+'" method=POST ><table border=0 width=100% cellspacing="0" cellpadding="2"><tr><td>'+
	'����� :</TD><TD align=left><INPUT  TYPE="text" NAME="'+name+'" id="'+name+'"  value="'+defaultlogin+'"></TD></TR><TR><TD>'+
	'������ :</TD><TD align=left><INPUT TYPE="text" NAME="zoloto" value=""></TD></TR>'+	
	'<TR><TD colspan=2 align=right><INPUT type=image SRC="#IMGSRC#" WIDTH="27" HEIGHT="20" BORDER=0 ALT=""></TD></TR></TABLE></FORM>';
	s = crtmagic(mtype, title, s);

	document.getElementById("hint4").innerHTML = s;
	document.getElementById("hint4").style.visibility = "visible";
	document.getElementById("hint4").style.left = 300;
	document.getElementById("hint4").style.top = document.body.scrollTop+50;
	document.getElementById(name).focus();
	Hint3Name = name;
}
//---------------------------takeplatina------------------------------
function takeplatina(title, script, name, defaultlogin, mtype) {
	var s;
	s='<form action="'+script+'" method=POST ><table border=0 width=100% cellspacing="0" cellpadding="2"><tr><td>'+
	'����� :</TD><TD align=left><INPUT  TYPE="text" NAME="'+name+'" id="'+name+'"  value="'+defaultlogin+'"></TD></TR><TR><TD>'+
	'������� :</TD><TD align=left><INPUT TYPE="text" NAME="platina" value=""></TD></TR>'+	
	'<TR><TD colspan=2 align=right><INPUT type=image SRC="#IMGSRC#" WIDTH="27" HEIGHT="20" BORDER=0 ALT=""></TD></TR></TABLE></FORM>';
	s = crtmagic(mtype, title, s);

	document.getElementById("hint4").innerHTML = s;
	document.getElementById("hint4").style.visibility = "visible";
	document.getElementById("hint4").style.left = 300;
	document.getElementById("hint4").style.top = document.body.scrollTop+50;
	document.getElementById(name).focus();
	Hint3Name = name;
}
//---------------------------takemoneybank------------------------------
function takemoneybank(title, script, name, defaultlogin, mtype) {
	var s;
	s='<form action="'+script+'" method=POST ><table border=0 width=100% cellspacing="0" cellpadding="2"><tr><td>'+
	'���������� ���� :</TD><TD align=left><INPUT  TYPE="text" NAME="bank" value="'+defaultlogin+'"></TD></TR><TR><TD>'+
	'������ :</TD><TD align=left><INPUT TYPE="text" NAME="zoloto" value=""></TD></TR>'+	
	'<TR><TD colspan=2 align=right><INPUT type=image SRC="#IMGSRC#" WIDTH="27" HEIGHT="20" BORDER=0 ALT=""></TD></TR></TABLE></FORM>';
	s = crtmagic(mtype, title, s);

	document.getElementById("hint4").innerHTML = s;
	document.getElementById("hint4").style.visibility = "visible";
	document.getElementById("hint4").style.left = 300;
	document.getElementById("hint4").style.top = document.body.scrollTop+50;
	document.getElementById(name).focus();
	Hint3Name = name;
}
//---------------------------takeplatinabank------------------------------
function takeplatinabank(title, script, name, defaultlogin, mtype) {
	var s;
	s='<form action="'+script+'" method=POST ><table border=0 width=100% cellspacing="0" cellpadding="2"><tr><td>'+
	'���������� ���� :</TD><TD align=left><INPUT  TYPE="text" NAME="bank" value="'+defaultlogin+'"></TD></TR><TR><TD>'+
	'������� :</TD><TD align=left><INPUT TYPE="text" NAME="platina" value=""></TD></TR>'+	
	'<TR><TD colspan=2 align=right><INPUT type=image SRC="#IMGSRC#" WIDTH="27" HEIGHT="20" BORDER=0 ALT=""></TD></TR></TABLE></FORM>';
	s = crtmagic(mtype, title, s);

	document.getElementById("hint4").innerHTML = s;
	document.getElementById("hint4").style.visibility = "visible";
	document.getElementById("hint4").style.left = 300;
	document.getElementById("hint4").style.top = document.body.scrollTop+50;
	document.getElementById(name).focus();
	Hint3Name = name;
}
//---------------------------marry------------------------------
function marry(title, script, name, defaultlogin, mtype) {
	var s;
	s='<form action="'+script+'" method=POST ><table border=0 width=100% cellspacing="0" cellpadding="2"><tr><td>'+
	'����� ������:</TD><TD align=left><INPUT  TYPE="text" NAME="'+name+'" id="'+name+'"  value="'+defaultlogin+'"></TD></TR><TR><TD>'+
	'����� �������:</TD><TD align=left><INPUT TYPE="text" NAME="target2" value=""></TD></TR>'+	
	'<TR><TD colspan=2 align=right><INPUT type=image SRC="#IMGSRC#" WIDTH="27" HEIGHT="20" BORDER=0 ALT=""></TD></TR></TABLE></FORM>';
	s = crtmagic(mtype, title, s);

	document.getElementById("hint4").innerHTML = s;
	document.getElementById("hint4").style.visibility = "visible";
	document.getElementById("hint4").style.left = 300;
	document.getElementById("hint4").style.top = document.body.scrollTop+50;
	document.getElementById(name).focus();
	Hint3Name = name;
}
//---------------------------status------------------------------
function status(title, script, name, defaultlogin, mtype) {
	var s;
	s='<form action="'+script+'" method=POST ><table border=0 width=100% cellspacing="0" cellpadding="2"><tr><td colspan=2>'+
	'������� ����� ���������:<small><BR>(����� �������� �� ������ � ����)</TD></TR><TR><TD align=left colspan=2><INPUT  TYPE="text" NAME="'+name+'" id="'+name+'"  value="'+defaultlogin+'"></TD></TR><TR><TD>'+
	'������:</TD><TD align=left><INPUT TYPE="text" NAME="status" value=""></TD></TR>'+	
	'<TR><TD colspan=2 align=right><INPUT type=image SRC="#IMGSRC#" WIDTH="27" HEIGHT="20" BORDER=0 ALT=""></TD></TR></TABLE></FORM>';
	s = crtmagic(mtype, title, s);

	document.getElementById("hint4").innerHTML = s;
	document.getElementById("hint4").style.visibility = "visible";
	document.getElementById("hint4").style.left = 300;
	document.getElementById("hint4").style.top = document.body.scrollTop+50;
	document.getElementById(name).focus();
	Hint3Name = name;
}
//---------------------------���� ���� �������------------------------------
function loginP(title, script, name, defaultlogin, mtype) {
	var s;
	s='<form action="'+script+'" method=POST ><table border=0 width=100% cellspacing="0" cellpadding="2"><tr><td colspan=2>'+
	'������� ����� ���������:<small><BR>(����� �������� �� ������ � ����)</TD></TR><TR><TD width=80% align=right style="padding-left:5"><INPUT style="width: 100%" TYPE="text" NAME="'+name+'" id="'+name+'"  value="'+defaultlogin+'"></TD><TD width=20%></TD></TR><TR><TD colspan=2>'+
	'������� �������:</TD></TR><TR><TD width=80% align=right style="padding-left:5"><INPUT style="width: 100%" TYPE="text" NAME="text" value=""></TD><TD width=20%><INPUT type=image SRC="#IMGSRC#" WIDTH="27" HEIGHT="20" BORDER=0 ALT=""></TD></TR></TABLE></FORM>';
	s = crtmagic(mtype, title, s);

	document.getElementById("hint4").innerHTML = s;
	document.getElementById("hint4").style.visibility = "visible";
	document.getElementById("hint4").style.left = 300;
	document.getElementById("hint4").style.top = document.body.scrollTop+50;
	document.getElementById(name).focus();
	Hint3Name = name;
}
//---------------------------HP------------------------------
function HP(title, script, name, defaultlogin, mtype) {
	var s;
	s='<form action="'+script+'" method=POST ><table border=0 width=100% cellspacing="0" cellpadding="2"><tr><td colspan=2>'+
	'������� ����� ���������:<small><BR>(����� �������� �� ������ � ����)</TD></TR><TR><TD width=80% align=right style="padding-left:5"><INPUT style="width: 100%" TYPE="text" NAME="'+name+'" id="'+name+'"  value="'+defaultlogin+'"></TD><TD width=20%></TD></TR><TR><TD colspan=2>'+
	'���������:</TD></TR><TR><TD width=80% align=left style="padding-left:5"><select name=noname><option value="1" selected>��</option><option value="">���</option></select></TD><TD width=20%><INPUT type=image SRC="#IMGSRC#" WIDTH="27" HEIGHT="20" BORDER=0 ALT=""></TD></TR></TABLE></FORM>';
	s = crtmagic(mtype, title, s);

	document.getElementById("hint4").innerHTML = s;
	document.getElementById("hint4").style.visibility = "visible";
	document.getElementById("hint4").style.left = 300;
	document.getElementById("hint4").style.top = document.body.scrollTop+50;
	document.getElementById(name).focus();
	Hint3Name = name;
}
//---------------------------add_navik------------------------------
function add_navik(title, script, name, defaultlogin, mtype) {
	var s;
	s='<form action="'+script+'" method=POST >'+
	'<table border=0 width=100% cellspacing="0" cellpadding="2">'+
	'<TR><TD>�����:</TD><TD width=80% align=right style="padding-left:5"><INPUT style="width: 100%" TYPE="text" NAME="'+name+'" id="'+name+'"  value="'+defaultlogin+'"></TD></TR>'+
	'<TR><TD>�������:</TD><TD width=80% align=left style="padding-left:5"><select name="level"><option value="1" selected>1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option></select></TD></TR>'+
	'<TR><TD>�����:  </TD><TD width=80% align=left style="padding-left:5"><select name="navik"><option value="2">������</option><option value="1">�����</option><option value="5">�������</option><option value="3">�������</option></select> <INPUT type=image SRC="#IMGSRC#" WIDTH="27" HEIGHT="20" BORDER=0 ALT=""></TD></TR>'+
	'</TABLE></FORM>';
	s = crtmagic(mtype, title, s);

	document.getElementById("hint4").innerHTML = s;
	document.getElementById("hint4").style.visibility = "visible";
	document.getElementById("hint4").style.left = 300;
	document.getElementById("hint4").style.top = document.body.scrollTop+50;
	document.getElementById(name).focus();
	Hint3Name = name;
}
//---------------------------del_navik------------------------------
function del_navik(title, script, name, defaultlogin, mtype) {
	var s;
	s='<form action="'+script+'" method=POST >'+
	'<table border=0 width=100% cellspacing="0" cellpadding="2">'+
	'<TR><TD>�����:</TD><TD width=80% align=right style="padding-left:5"><INPUT style="width: 100%" TYPE="text" NAME="'+name+'" id="'+name+'"  value="'+defaultlogin+'"></TD></TR>'+
	'<TR><TD>�����:  </TD><TD width=80% align=left style="padding-left:5"><select name="navik"><option value="2">������</option><option value="1">�����</option><option value="5">�������</option><option value="3">�������</option></select> <INPUT type=image SRC="#IMGSRC#" WIDTH="27" HEIGHT="20" BORDER=0 ALT=""></TD></TR>'+
	'</TABLE></FORM>';
	s = crtmagic(mtype, title, s);

	document.getElementById("hint4").innerHTML = s;
	document.getElementById("hint4").style.visibility = "visible";
	document.getElementById("hint4").style.left = 300;
	document.getElementById("hint4").style.top = document.body.scrollTop+50;
	document.getElementById(name).focus();
	Hint3Name = name;
}
//-------------------takeOrden------------------------------------------------------------------
function takeOrden(title, script, name, defaultlogin, mtype) 
{
	var s;
	s='<form action="'+script+'" method=POST ><table border=0 width=100% cellspacing="0" cellpadding="2"><tr><td colspan=2>'+
	'������� ����� ���������:<small><BR>(����� �������� �� ������ � ����)</TD></TR><TR><TD width=80% align=right style="padding-left:5"><INPUT style="width: 100%" TYPE="text" NAME="'+name+'" id="'+name+'"  value="'+defaultlogin+'"></TD><TD width=20%></TD></TR><TR><TD colspan=2 style="padding-left:5">������� �������: <select name=access><option value=1 selected>1 ����<option value=2>2 ����<option value=3>3 ����<option value=4>4 ����<option value=5>5 ����<option value=6>6 ����<option value=7>7 ����<option value=8>8 ����<option value=9>9 ����<option value=10>10 ����</select></TD></TR><TR><TD colspan=2>'+
	'�����:</TD></TR><TR><TD width=80% align=right style="padding-left:5"><INPUT style="width: 100%" TYPE="text" NAME="otdel" value=""></TD><TD width=20%><INPUT type=image SRC="#IMGSRC#" WIDTH="27" HEIGHT="20" BORDER=0 ALT=""></TD></TR></TABLE></FORM>';
	s = crtmagic(mtype, title, s);

	document.getElementById("hint4").innerHTML = s;
	document.getElementById("hint4").style.visibility = "visible";
	document.getElementById("hint4").style.left = 300;
	document.getElementById("hint4").style.top = document.body.scrollTop+50;
	document.getElementById(name).focus();
	Hint3Name = name;
}
//-------------------takeOrdenAdmin------------------------------------------------------------------
function takeOrdenAdmin(title, script, name, defaultlogin, mtype) 
{
	var s;
	s='<form action="'+script+'" method=POST >'+
	'<table border=0 width=100% cellspacing="0" cellpadding="2">'+
	'<tr><td colspan=2>������� ����� ���������:<small><BR>(����� �������� �� ������ � ����)</TD></TR>'+
	'<TR><TD colspan=2><input style="width: 100%" TYPE="text" NAME="'+name+'" id="'+name+'"  value="'+defaultlogin+'"></TD></TR>'+
	'<TR><TD colspan=2>�����: <select name=orden_type><option value=1 selected>������ �������<option value=6>�������� ����</select></TD></TR>'+
	'<TR><TD colspan=2>������� �������: <select name=access><option value=1 selected>1 ����<option value=2>2 ����<option value=3>3 ����<option value=4>4 ����<option value=5>5 ����<option value=6>6 ����<option value=7>7 ����<option value=8>8 ����<option value=9>9 ����<option value=10>10 ����</select></TD></TR>'+
	'<TR><TD colspan=2>�����:</TD></TR>'+
	'<TR><TD width=80% align=right style="padding-left:5"><INPUT style="width: 100%" TYPE="text" NAME="otdel" value=""></TD><TD width=20%><INPUT type=image SRC="#IMGSRC#" WIDTH="27" HEIGHT="20" BORDER=0 ALT=""></TD></TR></TABLE></FORM>';
	s = crtmagic(mtype, title, s);

	document.getElementById("hint4").innerHTML = s;
	document.getElementById("hint4").style.visibility = "visible";
	document.getElementById("hint4").style.left = 300;
	document.getElementById("hint4").style.top = document.body.scrollTop+50;
	document.getElementById(name).focus();
	Hint3Name = name;
}
//-------------------takeOrdenADV------------------------------------------------------------------
function takeOrdenAdv(title, script, name, defaultlogin, mtype) 
{
	var s;
	s='<form action="'+script+'" method=POST ><table border=0 width=100% cellspacing="0" cellpadding="2">'+
	'<tr><td colspan=2>������� ����� ���������:<small><BR>(����� �������� �� ������ � ����)</TD></TR>'+
	'<TR><TD width=80% align=right style="padding-left:5"><INPUT style="width: 100%" TYPE="text" NAME="'+name+'" id="'+name+'"  value="'+defaultlogin+'"></TD><TD width=20%></TD></TR>'+
	'<TR><TD colspan=2>�����:</TD></TR>'+
	'<TR><TD width=80% align=right style="padding-left:5" colspan="2"><INPUT style="width: 100%" TYPE="text" NAME="otdel" value=""></TD></TR>'+
	'<TR><TD width=80%><select name="leave"><option value="0" selected>�������</option><option value="1">�������</option></select></TD><TD width=20%><INPUT type=image SRC="#IMGSRC#" WIDTH="27" HEIGHT="20" BORDER=0 ALT=""></TD></TR>'+
	'</TABLE></FORM>';
	s = crtmagic(mtype, title, s);

	document.getElementById("hint4").innerHTML = s;
	document.getElementById("hint4").style.visibility = "visible";
	document.getElementById("hint4").style.left = 300;
	document.getElementById("hint4").style.top = document.body.scrollTop+50;
	document.getElementById(name).focus();
	Hint3Name = name;
}
//-------------------fear------------------------------------------------------------------
function fear(title, script, name, defaultlogin, mtype) 
{
	var s;
	s='<form action="'+script+'" method=POST ><table border=0 width=100% cellspacing="0" cellpadding="2"><tr><td colspan=2>'+
	'������� ����� ���������:<small><BR>(����� �������� �� ������ � ����)</TD></TR><TR><TD width=80% align=right style="padding-left:5"><INPUT style="width: 100%" TYPE="text" NAME="'+name+'" id="'+name+'"  value="'+defaultlogin+'"></TD><TD width=20%></TD></TR><TR><TD colspan=2 style="padding-left:5">������������ ���������: <INPUT  TYPE="text" NAME="timer" value=""></TD></TR><TR><TD colspan=2>'+
	'������� �������:</TD></TR><TR><TD width=80% align=right style="padding-left:5"><INPUT style="width: 100%" TYPE="text" NAME="reason" value=""></TD><TD width=20%><INPUT type=image SRC="#IMGSRC#" WIDTH="27" HEIGHT="20" BORDER=0 ALT=""></TD></TR></TABLE></FORM>';
	s = crtmagic(mtype, title, s);

	document.getElementById("hint4").innerHTML = s;
	document.getElementById("hint4").style.visibility = "visible";
	document.getElementById("hint4").style.left = 300;
	document.getElementById("hint4").style.top = document.body.scrollTop+50;
	document.getElementById(name).focus();
	Hint3Name = name;
}
//-------------------IP Blok------------------------------------------------------------------
function ipblok(title, script, name, defaultlogin, mtype) 
{
	var s;
	s='<form action="'+script+'" method=POST ><table border=0 width=100% cellspacing="0" cellpadding="2"><tr><td colspan=2>'+
	'������� ����� ���������:<small><BR>(����� �������� �� ������ � ����)</TD></TR><TR><TD width=80% align=right style="padding-left:5"><INPUT style="width: 100%" TYPE="text" NAME="'+name+'" id="'+name+'"  value="'+defaultlogin+'"></TD><TD width=20%></TD></TR><TR><TD style="padding-left:5"><select name=timer><option value=1 selected>1 ���� <option value=2>2 ���� <option value=6>6 ����� <option value=24>24 ����� <option value=48>2 ����� <option value=168>7 ����� </select></TD>'+
	'<TD><INPUT type=image SRC="#IMGSRC#" WIDTH="27" HEIGHT="20" BORDER=0 ALT=""></TD></TR></TABLE></FORM>';
	s = crtmagic(mtype, title, s);

	document.getElementById("hint4").innerHTML = s;
	document.getElementById("hint4").style.visibility = "visible";
	document.getElementById("hint4").style.left = 300;
	document.getElementById("hint4").style.top = document.body.scrollTop+50;
	document.getElementById(name).focus();
	Hint3Name = name;
}

//-------------------loginSilent------------------------------------------------------------------
function loginSilent(title, script, name, defaultlogin, mtype) 
{
	var s;
	s='<form action="'+script+'" method=POST ><table border=0 width=100% cellspacing="0" cellpadding="2"><tr><td colspan=2>'+
	'������� ����� ���������:<small><BR>(����� �������� �� ������ � ����)</TD></TR><TR><TD width=80% align=right style="padding-left:5"><INPUT style="width: 100%" TYPE="text" NAME="'+name+'" id="'+name+'"  value="'+defaultlogin+'"></TD><TD width=20%></TD></TR><TR><TD colspan=2 style="padding-left:5"><select name=timer><option value=1 selected>1 ��� <option value=15>15 ��� <option value=30>30 ��� <option value=60>60 ��� <option value=120>2 ���� <option value=360>6 ����� <option value=720>12 ����� <option value=1440>24 ����� <option value=2880>2 ����� </select></TD></TR><TR><TD colspan=2>'+
	'������� �������:</TD></TR><TR><TD width=80% align=right style="padding-left:5"><INPUT style="width: 100%" TYPE="text" NAME="reason" value=""></TD><TD width=20%><INPUT type=image SRC="#IMGSRC#" WIDTH="27" HEIGHT="20" BORDER=0 ALT=""></TD></TR></TABLE></FORM>';
	s = crtmagic(mtype, title, s);

	document.getElementById("hint4").innerHTML = s;
	document.getElementById("hint4").style.visibility = "visible";
	document.getElementById("hint4").style.left = 300;
	document.getElementById("hint4").style.top = document.body.scrollTop+50;
	document.getElementById(name).focus();
	Hint3Name = name;
}
//-------------------loginSilentFor------------------------------------------------------------------
function silent(title, script, name, defaultlogin, mtype) 
{
	var s;
	s='<form action="'+script+'" method=POST ><table border=0 width=100% cellspacing="0" cellpadding="2"><tr><td colspan=2>'+
	'������� ����� ���������:<small><BR>(����� �������� �� ������ � ����)</TD></TR><TR><TD width=80% align=right style="padding-left:5"><INPUT style="width: 100%" TYPE="text" NAME="'+name+'" id="'+name+'"  value="'+defaultlogin+'"></TD><TD width=20%></TD></TR><TR><TD colspan=2>'+
	'������� �������:</TD></TR><TR><TD width=80% align=right style="padding-left:5"><INPUT style="width: 100%" TYPE="text" NAME="reason" value=""></TD><TD width=20%><INPUT type=image SRC="#IMGSRC#" WIDTH="27" HEIGHT="20" BORDER=0 ALT=""></TD></TR></TABLE></FORM>';
	s = crtmagic(mtype, title, s);

	document.getElementById("hint4").innerHTML = s;
	document.getElementById("hint4").style.visibility = "visible";
	document.getElementById("hint4").style.left = 300;
	document.getElementById("hint4").style.top = document.body.scrollTop+50;
	document.getElementById(name).focus();
	Hint3Name = name;
}
//-------------------dealer------------------------------------------------------------------
function dealer(title, script, name, defaultlogin, mtype) 
{
	var s;
	s='<form action="'+script+'" method=POST ><table border=0 width=100% cellspacing="0" cellpadding="2"><tr><td colspan=2>'+
	'������� ����� ���������:<small><BR>(����� �������� �� ������ � ����)</TD></TR><TR><TD colspan=2><INPUT style="width: 100%" TYPE="text" NAME="'+name+'" id="'+name+'"  value="'+defaultlogin+'"></TD></TR><TR><TD>���������:</TD><TD><INPUT TYPE="text" NAME="otdel" value=""></TD></TR><TR><TD>��������:</TD><TD><select name=dealer><option value="" selected>�������<option value=1>������� ������</select></TD></TR>'+
	'<TR><TD width=80% align=right style="padding-left:5"></TD><TD width=20%><INPUT type=image SRC="#IMGSRC#" WIDTH="27" HEIGHT="20" BORDER=0 ALT=""></TD></TR></TABLE></FORM>';
	s = crtmagic(mtype, title, s);

	document.getElementById("hint4").innerHTML = s;
	document.getElementById("hint4").style.visibility = "visible";
	document.getElementById("hint4").style.left = 300;
	document.getElementById("hint4").style.top = document.body.scrollTop+50;
	document.getElementById(name).focus();
	Hint3Name = name;
}
//-------------------changepol------------------------------------------------------------------
function changepol(title, script, name, defaultlogin, mtype) 
{
	var s;
	s='<form action="'+script+'" method=POST ><table border=0 width=100% cellspacing="0" cellpadding="2"><tr><td colspan=2>'+
	'������� ����� ���������:<small><BR>(����� �������� �� ������ � ����)</TD></TR><TR><TD width=80% align=right style="padding-left:5"><INPUT style="width: 100%" TYPE="text" NAME="'+name+'" id="'+name+'"  value="'+defaultlogin+'"></TD><TD width=20%></TD></TR><TR><TD colspan=2 style="padding-left:5">��������: <select name=pol><option value="male" selected>�������<option value="female">�������</select></TD></TR>'+
	'<TR><TD width=80% align=right style="padding-left:5"></TD><TD width=20%><INPUT type=image SRC="#IMGSRC#" WIDTH="27" HEIGHT="20" BORDER=0 ALT=""></TD></TR></TABLE></FORM>';
	s = crtmagic(mtype, title, s);

	document.getElementById("hint4").innerHTML = s;
	document.getElementById("hint4").style.visibility = "visible";
	document.getElementById("hint4").style.left = 300;
	document.getElementById("hint4").style.top = document.body.scrollTop+50;
	document.getElementById(name).focus();
	Hint3Name = name;
}
//-------------------profession------------------------------------------------------------------
function profession(title, script, name, defaultlogin, mtype) 
{
	var s;
	s='<form action="'+script+'" method=POST ><table border=0 width=100% cellspacing="0" cellpadding="2"><tr><td colspan=2>'+
	'������� ����� ���������:<small><BR>(����� �������� �� ������ � ����)</TD></TR><TR><TD width=80% align=right style="padding-left:5"><INPUT style="width: 100%" TYPE="text" NAME="'+name+'" id="'+name+'"  value="'+defaultlogin+'"></TD><TD width=20%></TD></TR><TR><TD colspan=2 style="padding-left:5">��������: <select name=profession><option value="" selected>��� ���������<option value="knight">������<option value="mag">���<option value="trade">��������<option value="doctor">�������<option value="monk">�����<option value="jurnalist">���������</select></TD></TR>'+
	'<TR><TD width=80% align=right style="padding-left:5"></TD><TD width=20%><INPUT type=image SRC="#IMGSRC#" WIDTH="27" HEIGHT="20" BORDER=0 ALT=""></TD></TR></TABLE></FORM>';
	s = crtmagic(mtype, title, s);

	document.getElementById("hint4").innerHTML = s;
	document.getElementById("hint4").style.visibility = "visible";
	document.getElementById("hint4").style.left = 300;
	document.getElementById("hint4").style.top = document.body.scrollTop+50;
	document.getElementById(name).focus();
	Hint3Name = name;
}
//-------------------vip------------------------------------------------------------------
function vip(title, script, name, defaultlogin, mtype) 
{
	var s;
	s='<form action="'+script+'" method=POST ><table border=0 width=100% cellspacing="0" cellpadding="2"><tr><td colspan=2>'+
	'������� ����� ���������:<small><BR>(����� �������� �� ������ � ����)</TD></TR><TR><TD width=80% align=right style="padding-left:5"><INPUT style="width: 100%" TYPE="text" NAME="'+name+'" id="'+name+'"  value="'+defaultlogin+'"></TD><TD width=20%></TD></TR><TR><TD colspan=2 style="padding-left:5">��������: <select name=vip><option value="0" selected>�������<option value="1">1 �����<option value="2">2 �����<option value="7">7 �����<option value="15">15 �����<option value="30">30 �����</select></TD></TR>'+
	'<TR><TD width=80% align=right style="padding-left:5"></TD><TD width=20%><INPUT type=image SRC="#IMGSRC#" WIDTH="27" HEIGHT="20" BORDER=0 ALT=""></TD></TR></TABLE></FORM>';
	s = crtmagic(mtype, title, s);

	document.getElementById("hint4").innerHTML = s;
	document.getElementById("hint4").style.visibility = "visible";
	document.getElementById("hint4").style.left = 300;
	document.getElementById("hint4").style.top = document.body.scrollTop+50;
	document.getElementById(name).focus();
	Hint3Name = name;
}
//-------------------sponsor------------------------------------------------------------------
function sponsor(title, script, name, defaultlogin, mtype) 
{
	var s;
	s='<form action="'+script+'" method=POST ><table border=0 width=100% cellspacing="0" cellpadding="2"><tr><td colspan=2>'+
	'������� ����� ���������:<small><BR>(����� �������� �� ������ � ����)</TD></TR><TR><TD width=80% align=right style="padding-left:5"><INPUT style="width: 100%" TYPE="text" NAME="'+name+'" id="'+name+'"  value="'+defaultlogin+'"></TD><TD width=20%></TD></TR><TR><TD colspan=2 style="padding-left:5">��������: <select name=sponsor><option value="" selected>�������<option value=1>��������� �������<option value=2>����������� �������<option value=3>������� �������</select></TD></TR>'+
	'<TR><TD width=80% align=right style="padding-left:5"></TD><TD width=20%><INPUT type=image SRC="#IMGSRC#" WIDTH="27" HEIGHT="20" BORDER=0 ALT=""></TD></TR></TABLE></FORM>';
	s = crtmagic(mtype, title, s);

	document.getElementById("hint4").innerHTML = s;
	document.getElementById("hint4").style.visibility = "visible";
	document.getElementById("hint4").style.left = 300;
	document.getElementById("hint4").style.top = document.body.scrollTop+50;
	document.getElementById(name).focus();
	Hint3Name = name;
}
//-------------------Naqradit Ordenom------------------------------------------------------------------
function naqrada(title, script, name, defaultlogin, mtype) 
{
	var s;
	s='<form action="'+script+'" method=POST ><table border=0 width=100% cellspacing="0" cellpadding="2"><tr><td colspan=2>'+
	'������� ����� ���������:<small><BR>(����� �������� �� ������ � ����)</TD></TR><TR><TD width=80% align=right style="padding-left:5"><INPUT style="width: 100%" TYPE="text" NAME="'+name+'" id="'+name+'"  value="'+defaultlogin+'"></TD><TD width=20%></TD></TR>'+
	'<TR><TD colspan=2 width=80% align=left style="padding-left:5">��������: '+
	'<select name=medal>'+
	'<option value="1">������ ����</option>'+
	'<option value="2">����� �����������</option>'+
	'<option value="3">����� ��������������</option>'+
	'<option value="4">����� �������</option>'+
	'<option value="5">����� ������</option>'+
	'<option value="7">�������</option>'+
	'<option value="10">������ ���</option>'+
	'<option value="11">������ ������� ����</option>'+
	'<option value="12">������ ������ ����</option>'+
	'<option value="13">������ ����������� ����</option>'+
	'<option value="14">����� ������������</option>'+
	'<option value="15">����� ������������</option>'+
	'<option value="16">�����������</option>'+
	'<option value="19">�����</option>'+
	'<option value="18">����������������</option>'+
	'<option value="17">���������� ��������</option>'+
	'<option value="20">����� ������������ ��������</option>'+
	'<option value="21">����� ������� ���-�� ����� �� ����� ������</option>'+
	'<option value="22">����� ����������� �� ����� ������</option>'+
	'<option value="23">����� �������</option>'+
	'<option value="24">���������� ��������</option>'+
	'<option value="25">�������������� ��������</option>'+
	'<option value="26">��������� �����</option>'+
	'<option value="28">01.20.1990 ����������� ���� ������</option>'+
	'<option value="29">������ ���</option>'+
	'<option value="36">�� ���������� ������������� ������</option>'+
	'<option value="38">������ ���������</option>'+
	'<option value="42">�������� �������� ��������� ������� WWW.MEYDAN.AZ</option>'+
	'<option value="45">Party Meydan.az</option>'+	
	'<option value="46">����������� ���� ������ - �������</option>'+	
	'<option value="47">��� 7 ���!</option>'+		
	'</select></TD><TD width=20%><INPUT type=image SRC="#IMGSRC#" WIDTH="27" HEIGHT="20" BORDER=0 ALT=""></TD></TR></TABLE></FORM>';
	s = crtmagic(mtype, title, s);

	document.getElementById("hint4").innerHTML = s;
	document.getElementById("hint4").style.visibility = "visible";
	document.getElementById("hint4").style.left = 300;
	document.getElementById("hint4").style.top = document.body.scrollTop+50;
	document.getElementById(name).focus();
	Hint3Name = name;
}
//-------------------Scan Birth------------------------------------------------------------------
function findbirth(title, script, defaultlogin, mtype) 
{
	var s;
	s='<form action="'+script+'" method=POST ><table border=0 width=100% cellspacing="0" cellpadding="2"><tr><td>'+
	'����:</TD><TD width=80% colspan=2><INPUT TYPE="text" NAME="day" value=""></TD></TR><TR><TD>�����:</td><TD colspan=2><INPUT TYPE="text" NAME="month" value=""></TD></TR><TR><TD>'+
	'���:</TD><TD><INPUT TYPE="text" NAME="year" value=""></TD><TD width=20%><INPUT type=image SRC="#IMGSRC#" WIDTH="27" HEIGHT="20" BORDER=0 ALT=""></TD></TR></TABLE></FORM>';
	s = crtmagic(mtype, title, s);

	document.getElementById("hint4").innerHTML = s;
	document.getElementById("hint4").style.visibility = "visible";
	document.getElementById("hint4").style.left = 300;
	document.getElementById("hint4").style.top = document.body.scrollTop+50;
	document.getElementById("day").focus();
	Hint3Name = "day";
}

//-------------------loginXaos------------------------------------------------------------------
function loginXaos(title, script, name, defaultlogin, mtype) 
{
	var s;
	s='<form action="'+script+'" method=POST><table border=0 width=100% cellspacing="0" cellpadding="2"><tr><td colspan=2>'+
	'������� ����� ���������:<small><BR>(����� �������� �� ������ � ����)</TD></TR><TR><TD width=80% align=right style="padding-left:5"><INPUT style="width: 100%" TYPE="text" NAME="'+name+'" id="'+name+'" value="'+defaultlogin+'"></TD><TD width=20%></TD></TR><TR><TD colspan=2 style="padding-left:5"><select name=timer><option value=24 selected>1 ���� <option value=72>3 ��� <option value=168>������ <option value=360>15 ����� <option value=744>����� <option value=1440>2 ������ <option value=2160>3 ������ <option value=4320>6 ������ <option value=8640>12 ������ <option value=17280>2 ����</select></TD></TR><TR><TD colspan=2>'+
	'������� �������:</TD></TR><TR><TD width=80% align=right style="padding-left:5"><textarea rows="5" name="reason" cols="40"></textarea></TD><TD width=20%><INPUT type=image SRC="#IMGSRC#" WIDTH="27" HEIGHT="20" BORDER=0 ALT=""></TD></TR></TABLE></FORM>';
	s = crtmagic(mtype, title, s);

	document.getElementById("hint4").innerHTML = s;
	document.getElementById("hint4").style.visibility = "visible";
	document.getElementById("hint4").style.left = 300;
	document.getElementById("hint4").style.top = document.body.scrollTop+50;
	document.getElementById(name).focus();
	Hint3Name = name;
}
//-------------------loginObezl------------------------------------------------------------------
function loginObezl(title, script, name, defaultlogin, mtype) 
{
	var s;
	s='<form action="'+script+'" method=POST ><table border=0 width=100% cellspacing="0" cellpadding="2"><tr><td colspan=2>'+
	'������� ����� ���������:<small><BR>(����� �������� �� ������ � ����)</TD></TR><TR><TD width=80% align=right style="padding-left:5"><INPUT style="width: 100%" TYPE="text" NAME="'+name+'" id="'+name+'"  value="'+defaultlogin+'"></TD><TD width=20%></TD></TR><TR><TD colspan=2 style="padding-left:5"><select name=timer><option value=24 selected>1 ���� <option value=72>3 ��� <option value=168>������ <option value=360>15 ����� <option value=744>����� <option value=1440>2 ������ <option value=2160>3 ������ <option value=4320>6 ������ <option value=8640>12 ������</select></TD>'+
	'<TD width=20%><INPUT type=image SRC="#IMGSRC#" WIDTH="27" HEIGHT="20" BORDER=0 ALT=""></TD></TR></TABLE></FORM>';
	s = crtmagic(mtype, title, s);

	document.getElementById("hint4").innerHTML = s;
	document.getElementById("hint4").style.visibility = "visible";
	document.getElementById("hint4").style.left = 300;
	document.getElementById("hint4").style.top = document.body.scrollTop+50;
	document.getElementById(name).focus();
	Hint3Name = name;
}
//------------------------loginBlok--------------------------------------------------------------------------
function loginBlok(title, script, name, defaultlogin, mtype) {
	var s;
	s='<form action="'+script+'" method=POST ><table border=0 width=100% cellspacing="0" cellpadding="2"><tr><td colspan=2>'+
	'������� ����� ���������:<small><BR>(����� �������� �� ������ � ����)</TD></TR><TR><TD width=80% align=right style="padding-left:5"><INPUT style="width: 100%" TYPE="text" NAME="'+name+'" id="'+name+'"  value="'+defaultlogin+'"></TD><TD width=20%></TD></TR><TR><TD colspan=2>'+
	'������� �������:</TD></TR><TR><TD width=80% align=right style="padding-left:5"><textarea rows="5" name="reason" cols="40"></textarea></TD><TD width=20%><INPUT type=image SRC="#IMGSRC#" WIDTH="27" HEIGHT="20" BORDER=0 ALT=""></TD></TR></TABLE></FORM>';
	s = crtmagic(mtype, title, s);

	document.getElementById("hint4").innerHTML = s;
	document.getElementById("hint4").style.visibility = "visible";
	document.getElementById("hint4").style.left = 300;
	document.getElementById("hint4").style.top = document.body.scrollTop+50;
	document.getElementById(name).focus();
	Hint3Name = name;
}
//--------------------------------------------------------------------------------------------------

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
// ��� �����. ���������, �������� �������, �������� �����, ����� ������ � �������, ����� �� ���������, �������� ���. ����
//2 ���� ���� ������ ����
function magicklogin(title, script, magickname, n, defaultlogin, extparam, mtype) {

	var s = '<form action="'+script+'" method=POST name=slform><table border=0 width=100% cellspacing="0" cellpadding="2"><tr><input type=hidden name="use" value="'+magickname+'"><input type=hidden name="n" value="'+n+'"><td colspan=2>'+
	'������� ����� ���������:<small><BR>(����� �������� �� ������ � ����)</TD></TR><TR><TD style="padding-left:5" width=50% align=right><INPUT TYPE="text" NAME="param" value="'+defaultlogin+'" style="width: 100%"></TD><TD width=50%><INPUT type=image SRC="#IMGSRC#" WIDTH="27" HEIGHT="20" BORDER=0 ALT="" onclick="slform.param.value=fixspaces(slform.param.value);"></TD></TR>';
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

// �����
//��
function UseMagick(title, script, name, extparam, n, extparam2, mtype) {
   if ((extparam != null)&&(extparam != '')) {

	var t1='text',t2='text';

	if (extparam.substr(0,1) == "!")
	{
		t1='password';
		extparam=extparam.substr(1,extparam.length);
	}

	var s = '<form action="'+script+'" method=POST name=slform><table border=0 width=100% cellspacing="1" cellpadding="0"><TR><input type=hidden name="use" value="'+name+'"><input type=hidden name="n" value="'+n+'"><td colspan=2 align=left><NOBR><SMALL>'+
	extparam + ':</NOBR></TD></TR><TR><TD width=100% align=left style="padding-left:5"><INPUT tabindex=1 style="width: 100%" TYPE="'+t1+'" id="param" NAME="param" value=""></TD><TD width=10%><INPUT type=image SRC="#IMGSRC#" WIDTH="27" HEIGHT="20" BORDER=0 ALT="" tabindex=3></TD></TR>';
	if (extparam2 != null && extparam2 != '') {
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
   } else {
		dialogconfirm('�������������', script, '<TABLE width=100%><TD><IMG src="img/'+name+'"></TD><TD>������������ ������?</TABLE>'+
		'<input type=hidden name="use" value="'+name+'"><input type=hidden name="n" value="'+n+'">', mtype);
   }
}

// ��������� ���� ����� ������
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

while (body.indexOf('#IMGSRC#')>=0) body = body.replace('#IMGSRC#', 'img/dmagic/'+names[mtype*10]+'_30.gif');
var s='<table width="270" border="0" align="center" cellpadding="0" cellspacing="0">'+
	'<tr>'+
	'<td width="100%">'+
	'<table width="100%"  border="0" cellspacing="0" cellpadding="0">'+
	'<tr><td>'+
		'<table width="100%" border="0" cellpadding="0" cellspacing="0">'+
		'<tr>'+
		'<td width="'+names[mtype*10+1]+'" align="left"><img src="img/dmagic/b'+names[mtype*10]+'_03.gif" width="'+names[mtype*10+1]+'" height="'+names[mtype*10+2]+'"></td>'+
		'<td width="100%" align="right" background="img/dmagic/b'+names[mtype*10]+'_05.gif"></td>'+
		'<td width="'+names[mtype*10+3]+'" align="right"><img src="img/dmagic/b'+names[mtype*10]+'_07.gif" width="'+names[mtype*10+3]+'" height="'+names[mtype*10+2]+'"></td>'+
		'</tr>'+
		'</table></td>'+
	'</tr>'+
	'<tr><td>'+
		'<table width="100%" border="0" cellspacing="0" cellpadding="0">'+
		'<tr>'+
			(names[mtype*10+7]?'<td width="'+names[mtype*10+7]+'"><SPAN style="width:'+names[mtype*10+7]+'">&nbsp;</SPAN></td>':'')+
			'<td width="5" background="img/dmagic/b'+names[mtype*10]+'_17.gif">&nbsp;</td>'+
			'<td width="100%">'+
			'<table width="100%" border="0" cellspacing="0" cellpadding="0">'+
			'<tr><td bgcolor="#'+colors[mtype*2]+'"'+(names[mtype*10+9]?' style="padding-top: '+names[mtype*10+9]+'"':'')+' >'+
			'<table border=0 width=100% cellspacing="0" cellpadding="0"><td style="padding-left: 20" align=center><B>'+title+
			'</td><td width=20 align=right valign=top style="cursor: pointer;" onclick="closehint3();" style=\'filter:Gray()\' onmouseover="this.filters.Gray.Enabled=false" onmouseout="this.filters.Gray.Enabled=true"><IMG src="img/dmagic/clear.gif" width=13 height=13>&nbsp;</td></table>'+
			'</td></tr>'+
			'<tr>'+
				'<td align="center" bgcolor="#'+colors[mtype*2+1]+'">'+body+
			'</tr>'+
			'</table></td>'+
			'<td width="5" background="img/dmagic/b'+names[mtype*10]+'_19.gif">&nbsp;</td>'+
			(names[mtype*10+8]?'<td width="'+names[mtype*10+8]+'"><SPAN style="width:'+names[mtype*10+8]+'">&nbsp;</SPAN></td></td>':'')+
			'</tr>'+
		'</table></td>'+
	'</tr>'+
	'<tr><td>'+
		'<table width="100%"  border="0" cellpadding="0" cellspacing="0">'+
		'<tr>'+
			'<td width="'+names[mtype*10+4]+'" align="left"><img src="img/dmagic/b'+names[mtype*10]+'_27.gif" width="'+names[mtype*10+4]+'" height="'+names[mtype*10+6]+'"></td>'+
			'<td width="100%" align="right" background="img/dmagic/b'+names[mtype*10]+'_29.gif"></td>'+
			'<td width="'+names[mtype*10+5]+'" align="right"><img src="img/dmagic/b'+names[mtype*10]+'_31.gif" width="'+names[mtype*10+5]+'" height="'+names[mtype*10+6]+'"></td>'+
		'</tr>'+
		'</table></td>'+
	'</tr>'+
	'</table></td>'+
'</tr>'+
'</table>';

	return s;
}