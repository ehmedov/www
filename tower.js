pach="img/tower/";

img=new Array(
	'1_left_wall.gif', '1_front_wall.gif', '1_right_wall.gif',
	'2_left_wall.gif', '2_front_wall.gif', '2_right_wall.gif',
	'3_left_wall.gif', '3_front_wall.gif', '3_right_wall.gif',
	'4_ceil_wall.gif', '4_floor_wall.gif', '4_left_wall.gif','4_right_wall.gif');

function LoadImg(){
	var i = 0;
 	for(i=0; i<=(img.length-1); i++)
 	{
 		image = new Image();
       	image.src = pach+img[i];
  	}
}
function Print()
{
	document.getElementById('lok').innerHTML='<div id="l1l" style="display:none; Z-INDEX:7; LEFT:10px; WIDTH:50px; POSITION:absolute; TOP:10px"><img src="img/tower/1_left_wall.gif" width="50" height="240"></div>\n<div id="l1f" style="display:none; Z-INDEX:7; LEFT:60px; WIDTH:252px; POSITION:absolute; TOP:29px; display:none"><img src="img/tower/1_front_wall.gif" width="252" height="179"></div>\n<div id="l1r" style="display:none; Z-INDEX:7; RIGHT:10px; WIDTH:50px; POSITION:absolute; TOP:10px"><img src="img/tower/1_right_wall.gif" width="50" height="240"></div>\n<div id="l2l" style="display:none; Z-INDEX:5; LEFT:10px; WIDTH:96px; POSITION:absolute; TOP:28px"><img src="img/tower/2_left_wall.gif" width="96" height="182"></div>\n<div id="l2f" style="display:none; Z-INDEX:5; LEFT:106px; WIDTH:160px; POSITION:absolute; TOP:50px"><img src="img/tower/2_front_wall.gif" width="160" height="117"></div>\n<div id="l2r" style="display:none; Z-INDEX:5; RIGHT:10px; WIDTH:96px; POSITION:absolute; TOP:28px"><img src="img/tower/2_right_wall.gif" width="96" height="182"></div>\n<div id="l3l" style="display:none; Z-INDEX:3; LEFT:10px; WIDTH:128px; POSITION:absolute; TOP:50px"><img src="img/tower/3_left_wall.gif" width="128" height="118"></div>\n<div id="l3f" style="display:none; Z-INDEX:3; LEFT:137px; WIDTH:96px; POSITION:absolute; TOP:67px"><img src="img/tower/3_front_wall.gif" width="96" height="70"></div>\n<div id="l3r" style="display:none; Z-INDEX:3; RIGHT:10px; WIDTH:128px; POSITION:absolute; TOP:50px"><img src="img/tower/3_right_wall.gif" width="128" height="118"></div>\n<div id="l4ce" style="display:block; LEFT:10px; WIDTH:352px; POSITION:absolute; TOP:10px"><img src="img/tower/4_ceil_wall.gif" width="352" height="70"></div>\n<div id="l4fl" style="display:block; LEFT:10px; WIDTH:352px; BOTTOM:10px; POSITION:absolute"><img src="img/tower/4_floor_wall.gif" width="352" height="135"></div>\n<div id="l4l" style="display:none; Z-INDEX:1; LEFT:10px; WIDTH:150px; POSITION:absolute; TOP:67px"><img src="img/tower/4_left_wall.gif" width="150" height="71"></div>\n<div id="l4r" style="display:none; Z-INDEX:1; RIGHT:10px; WIDTH:150px; POSITION:absolute; TOP:67px"><img src="img/tower/4_right_wall.gif" width="150" height="71"></div>';
	
	document.getElementById('lok').innerHTML+='<div id="m2_1" onmouseout="closeMenu();" style="display:none; Z-INDEX:6; POSITION:absolute; TOP:55px;"><img src="img/tower/0.png"  alt="" style="CURSOR:hand" id="im2_1" onClick="OpenMenu(bots_id);"></div><div id="m2_l1" style="display:none; Z-INDEX:6; POSITION:absolute; TOP:55px; " ><img src="img/tower/0.png"  alt="" id="im2_l1"></div><div id="m2_r1" style="display:none; Z-INDEX:6;POSITION:absolute; TOP:55px;"><img src="img/tower/0.png"  alt="" id="im2_r1"></div>';
	document.getElementById('lok').innerHTML+='<div id="m2_3" style="display:none; Z-INDEX:4; WIDTH:50px; top:90px; POSITION:absolute;"><img src="img/tower/0.png" width="50" alt="" id="im2_3"></div><div id="m2_l3" style="display:none; Z-INDEX:4; WIDTH:50px; top:90px; POSITION:absolute;"><img src="img/tower/0.png" width="50" alt="" id="im2_l3"></div><div id="m2_r3" style="display:none; Z-INDEX:4; WIDTH:50px; BOTTOM:90px; POSITION:absolute;"><img src="img/tower/0.png" width="50" alt="" id="im2_r3"></div>';
}
function PrintBot()
{
	document.getElementById('lok').innerHTML+="<div id='bot_id' onmouseout='closeMenu();' style='display:none; Z-INDEX:100; POSITION:absolute; LEFT:110px; TOP:30px;'><img src='img/tower/smert.gif'  alt='' style='CURSOR:hand' onClick='OpenMenu(\"19x11\");'></div>";
	document.getElementById('lok').innerHTML+='<div id="bot_id_small" style="display:none; Z-INDEX:100; WIDTH:75px; LEFT:140px; TOP:50px; POSITION:absolute;"><img src="img/tower/smert.gif" width="75" alt=""></div>';
}
function Attak_b(id)
{
	document.location.href="?attack_bot="+id+"&rnd="+Math.random();
}

//меню наподения
function OpenMenu(id){
	 var el, x, y;
	 el = document.all("oMenu");
	 x = event.clientX + document.documentElement.scrollLeft +document.body.scrollLeft - 5;
	 y = event.clientY + document.documentElement.scrollTop + document.body.scrollTop-5;
	 if (event.clientY + 72 > document.body.clientHeight) { y-=62 } else { y-=2 }
	 el.innerHTML = "<div class=menuItem onmouseout='this.className=\"menuItem\";' onmouseover='this.className=\"menuItem2\";' onclick='Attak_b(\""+id+"\");'>Напасть</div>";
	 el.style.left = x + "px";
	 el.style.top  = y + "px";
	 el.style.visibility = "visible";
}

//Закрыть меню наподения
function closeMenu(event){
	 if (window.event && window.event.toElement)
 	 {var cls = window.event.toElement.className;
  		if (cls=='menuItem' || cls=='menu') return;
 	 }
	 document.all("oMenu").style.visibility = "hidden";
	 document.all("oMenu").style.top="0px";
	 document.all("oMenu").style.left="0px";
	 return false;
}
