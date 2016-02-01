function hint(text)
{
	var s;
	s='<table cellpadding=0 cellspacing=0 bgcolor="FFFFE1" border=0>';
	s+='<tr><td align=left><FONT STYLE="FONT-SIZE: 8pt;">'+text+'</FONT></td></tr>';
	s+='</table>';
	var element=document.getElementById('city_info');
	element.innerHTML=s;
	
	x = event.clientX + document.body.scrollLeft + 10;
	y = event.clientY + document.body.scrollTop + 10;

    element.style.left = x + 'px';
    element.style.top = y + 'px';
	element.style.visibility='visible';
}

function c()
{ 
	var element=document.getElementById('city_info');
	element.style.visibility='hidden'; 
}