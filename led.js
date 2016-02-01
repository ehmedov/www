pach="img/led/";
img=new Array(
	'1_left_wall.gif', '1_front_wall.gif', '1_right_wall.gif',
	'2_left_wall.gif', '2_front_wall.gif', '2_right_wall.gif',
	'3_left_wall.gif', '3_front_wall.gif', '3_right_wall.gif',
	'4_left_wall.gif', '4_right_wall.gif','bg.gif',
	'navigation.gif','left.gif','noway.gif','right.gif','shadow.gif','up.gif',
	'bots/santa.png'
);

//Загрузка картинок
function LoadImg()
{
	var i = 0;
	var s;
 	for(i=0; i<=(img.length-1); i++)
 	{
 		image = new Image();
       	image.src = pach+img[i];
  	}
}
function Attak_b(id)
{
	document.location.href="?action=attack&id="+id+"&rnd="+Math.random();
}
function dungeon_obj (pid) 
{
	document.location.href = "?get="+pid+'&r='+Math.random();;
	return;
}
//меню наподения
function OpenMenu(id){	 var el, x, y;
	 el = document.all("oMenu");
	 x = event.clientX + document.documentElement.scrollLeft +document.body.scrollLeft - 5;
	 y = event.clientY + document.documentElement.scrollTop + document.body.scrollTop-5;
	 if (event.clientY + 72 > document.body.clientHeight) { y-=62 } else { y-=2 }
	 el.innerHTML = "<div class=menuItem onmouseout=\"this.className='menuItem';\" onmouseover=\"this.className='menuItem2';\" onclick=\"Attak_b('"+id+"');\">Напасть</div>";
	 el.style.left = x + "px";
	 el.style.top  = y + "px";
	 el.style.visibility = "visible";}

//Закрыть меню наподения
function closeMenu(event){	 if (window.event && window.event.toElement)
 	 {var cls = window.event.toElement.className;
  		if (cls=='menuItem' || cls=='menu') return;
 	 }
	 document.all("oMenu").style.visibility = "hidden";
	 document.all("oMenu").style.top="0px";
	 document.all("oMenu").style.left="0px";
	 return false;
}


//Перс HP
function show(min, max)
{
	perc=max/100;
	n=max-min;
	m2=Math.floor(min/perc);
	m1=Math.floor(100-m2);
	if(m2==100){m2=100;}
	if(m2<30){color='img/icon/red.jpg';}
	else if(m2<60){color='img/icon/yellow.jpg';}
	else {color='img/icon/green.jpg';}
	s="<table border='0' cellpadding='0' cellspacing='0' width='180' height='10'><tr><td width='100%' nowrap background='img/icon/grey.jpg'><img src='"+color+"'  alt='Уровень жизни' height='10' width='"+m2+"%'></td><td><b style='font-weight: bold;font-size: 10; color: #000000'>"+min+"/"+max+"</b></td></tr></table>";
	document.write(s);
}
//
function VesualBot(bots,loc)
{
	var cord=Math.round(150/(bots.length+1));
	var k='';
	for(i=0; i<bots.length; i++)
	{
		cord+=40;
		k+= "<img src='img/led/bots/"+bots[i]+".png' style='POSITION:absolute; LEFT:"+cord+"px;' alt='Подземные существа'>";
	}
	k="<div style='CURSOR:hand' onClick=\"OpenMenu('"+loc+"');\">"+k+"</div>";
	document.getElementById("us").innerHTML=k;
	
}
//
function VesualBot2(bots,loc)
{
	var cord=Math.round(220/(bots.length+1));
	var k='';
	for(i=0; i<bots.length; i++)
	{
		cord+=35;
		k+= "<img src='img/led/bots/"+bots[i]+".png' style='WIDTH:70px; POSITION:absolute; LEFT:"+cord+"px;' alt='Подземные существа'>";
	}
	//k="<div style='CURSOR:hand' onClick=\"OpenMenu('"+loc+"');\">"+k+"</div>";
	document.getElementById("us2").innerHTML=k;
	
}