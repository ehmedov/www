function ins_smile()
{
	var element=document.getElementById('cp');
	element.style.visibility='visible';
}
function clearForm()
{
	if(confirm("�� ������� ��� ������ �������� �����?"))
	{
		document.Add.name.value="";
		document.Add.mail.value="";
		document.Add.header.value="";
		document.Add.msg.value="";
	}
}

function clearForm_comment()
{
	if(confirm("�� ������� ��� ������ �������� �����?"))
	{
		document.add_top.msg.value="";
		document.add_top.header.value="";
	}
}


function submitForm()
{
	if(document.Add.name.value=="" && document.Add.anonim.checked!=true){alert('�� �� ����� ��� �����!!!');}
	else if(document.Add.header.value==""){alert('�� �� ����� ��������� �������!!!');}
	else if(document.Add.msg.value==""){alert('�� �� ����� ����� ���������!!!');}
	else
	{
		document.Add.submit();
	}
}

function submitForm_comment()
{
	if(document.add_top.msg.value==""){alert('�� �� ����� ����� ���������!');}
	else
	{
		document.add_top.submit();
	}
}


function smile(name){
document.Add.msg.value+=name;
}

function storeCaret(text) {
    if (text.createTextRange) { text.caretPos = document.selection.createRange().duplicate(); }
}
function paste(s1, s2)
{
   
 if (document.getSelection) { alert("��� NN �� ��������!"); }
   if (document.selection) 
   {
		var str = document.selection.createRange();
		var s = document.add_top.comments.value;
		if (s1 == '//') 
		{
			if ((str.text != "") && (s.indexOf(str.text)<0)) 
			{
				var str2 = '> ';
				var j = 0;
				for(var i=0; i<str.text.length; i++) 
				{
					str2 += str.text.charAt(i); j++;
					if (str.text.charAt(i) == "\n") { str2 += "> "; j=0; }
					if ((j>55)&&(str.text.charAt(i) == ' ')) { str2 += "\n> "; j=0; }
				}
				document.add_top.comments.value = s+"<I>\n"+str2+"\n</I>\n";
			} 
			else 
			{
				alert("�� ������� �����!\n��� ������� ������, ������� �������� �� �������� ������ �����, � ����� ������� ��� ������.");
			}
		} 
		else 
		{
			if ((str.text != "") && (s.indexOf(str.text)>=0)) 
			{
				if (str.text.indexOf(s1) == 0) {return '';}
				str.text = s1+str.text+s2;
			} 
			else 
			{
	        	if (document.add_top.comments.createTextRange && document.add_top.comments.caretPos) 
	        	{
	            	var caretPos = document.add_top.comments.caretPos;
	            	caretPos.text = s1+s2;
	        	} 
	        	else 
	        	{
	                document.add_top.comments.value = s+s1+s2;
	            }
			}
		}
	}
	document.add_top.comments.focus();
	return false;
}

function help(what){
if(what=='comment'){
alert("����������� ������ ���� ����������� ����������� �������������� ��� �������.");
}
else if(what=='anonim'){
alert("���������� �� ����� ������ ����� ������ ����� ���������.\n��� ��������� ������ ����� ������� �� �����������.");
}
else if(what=='mail'){
alert("���� �� ������, ����� ���������� ������ ��� e-mail\n������� ��� � ��� ����, ����� ������� ���� ������.");
}
else if(what=='login'){
alert("������� � ��� ���� ��� �����.");
}
else if(what=='msg'){
alert("� ��� ���� ��������� ����� ���������.������������� HTML-����� ���������.\n����������� ������ � ������ �����, ������� ���������� � ������ �������.\n�-������ �����\n�-������\n�-������������\nURL-������ URL\nIMG-�������\n��� ������������� ������ �������� ������� ������ � ���� \"����� ���������\"\n� ������� ������ ��� ������ �����.");
}
else if(what=='private'){
alert("��� ��������� ������ ��� ������� ����� ��������� � ������� ������,����� - � ����� �������.");
}
else if(what=='forward'){
alert("���������� ���������� �� ��� e-mail ������ ��� ���������� �����������.\nE-mail ���� ������ ���� ����������.");
}
else if(what=='offtop'){
alert("��������� ��� ��������� � ������, �.�. ������ ���������� ��� ��� ���������� �����������.");
}
else if(what=='attach'){
alert("�� ������ ����� ���������� ���� � ������ ���������.\n������ ����� �� ������ ��������� 2.00 ��.");
}
}