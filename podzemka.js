pach="img/ug/";

img=new Array(
	'1_left_wall.gif', '1_front_wall.gif', '1_right_wall.gif',
	'2_left_wall.gif', '2_front_wall.gif', '2_right_wall.gif',
	'3_left_wall.gif', '3_front_wall.gif', '3_right_wall.gif',
	'4_ceil_wall.gif', '4_floor_wall.gif', '4_left_wall.gif', '4_right_wall.gif',
	'sunduk.gif','teleport.gif','bots/1016.gif'
);

function LoadImg(){
	var i = 0;
 	for(i=0; i<=(img.length-1); i++)
 	{
 		image = new Image();
       	image.src = pach+img[i];
  	}
}

function say()
{
	document.location.href="?action=kvest";
}
function Attak_b(id)
{
	document.location.href="?action=attack&id="+id+"&rnd="+Math.random();
}
function dungeon_take(id)
{
	document.location.href="?action=dungeon_take&id="+id+"&rnd="+Math.random();
}
function SayMenu(){
	 var el, x, y;
	 el = document.all("oMenu");
	 x = event.clientX + document.documentElement.scrollLeft +document.body.scrollLeft - 5;
	 y = event.clientY + document.documentElement.scrollTop + document.body.scrollTop-5;
	 if (event.clientY + 72 > document.body.clientHeight) { y-=62 } else { y-=2 }
	 el.innerHTML = '<div class=menuItem onmouseout="this.className=\'menuItem\';" onmouseover="this.className=\'menuItem2\';" onclick="say();">Получить заданию</div>';
	 
	 el.style.left = x + "px";
	 el.style.top  = y + "px";
	 el.style.visibility = "visible";
}

function OpenMenu(id){
	 var el, x, y;
	 el = document.all("oMenu");
	 x = event.clientX + document.documentElement.scrollLeft +document.body.scrollLeft - 5;
	 y = event.clientY + document.documentElement.scrollTop + document.body.scrollTop-5;
	 if (event.clientY + 72 > document.body.clientHeight) { y-=62 } else { y-=2 }
	 el.innerHTML = '<div class=menuItem onmouseout="this.className=\'menuItem\';" onmouseover="this.className=\'menuItem2\';" onclick="Attak_b('+id+');">Напасть</div>';
	 
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
function Print()
{
	document.getElementById('lok').innerHTML='<div id="l1l" style="display:none; Z-INDEX:7; LEFT:10px; WIDTH:50px; POSITION:absolute; TOP:10px"><img src="img/ug/1_left_wall.gif" width="50" height="240"></div>\n<div id="l1f" style="display:none; Z-INDEX:7; LEFT:60px; WIDTH:252px; POSITION:absolute; TOP:29px; display:none"><img src="img/ug/1_front_wall.gif" width="252" height="179"></div>\n<div id="l1r" style="display:none; Z-INDEX:7; RIGHT:10px; WIDTH:50px; POSITION:absolute; TOP:10px"><img src="img/ug/1_right_wall.gif" width="50" height="240"></div>\n<div id="l2l" style="display:none; Z-INDEX:5; LEFT:10px; WIDTH:96px; POSITION:absolute; TOP:28px"><img src="img/ug/2_left_wall.gif" width="96" height="182"></div>\n<div id="l2f" style="display:none; Z-INDEX:5; LEFT:106px; WIDTH:160px; POSITION:absolute; TOP:50px"><img src="img/ug/2_front_wall.gif" width="160" height="117"></div>\n<div id="l2r" style="display:none; Z-INDEX:5; RIGHT:10px; WIDTH:96px; POSITION:absolute; TOP:28px"><img src="img/ug/2_right_wall.gif" width="96" height="182"></div>\n<div id="l3l" style="display:none; Z-INDEX:3; LEFT:10px; WIDTH:128px; POSITION:absolute; TOP:50px"><img src="img/ug/3_left_wall.gif" width="128" height="118"></div>\n<div id="l3f" style="display:none; Z-INDEX:3; LEFT:137px; WIDTH:96px; POSITION:absolute; TOP:67px"><img src="img/ug/3_front_wall.gif" width="96" height="70"></div>\n<div id="l3r" style="display:none; Z-INDEX:3; RIGHT:10px; WIDTH:128px; POSITION:absolute; TOP:50px"><img src="img/ug/3_right_wall.gif" width="128" height="118"></div>\n<div id="l4ce" style="display:block; LEFT:10px; WIDTH:352px; POSITION:absolute; TOP:10px"><img src="img/ug/4_ceil_wall.gif" width="352" height="70"></div>\n<div id="l4fl" style="display:block; LEFT:10px; WIDTH:352px; BOTTOM:10px; POSITION:absolute"><img src="img/ug/4_floor_wall.gif" width="352" height="135"></div>\n<div id="l4l" style="display:none; Z-INDEX:1; LEFT:10px; WIDTH:150px; POSITION:absolute; TOP:67px"><img src="img/ug/4_left_wall.gif" width="150" height="71"></div>\n<div id="l4r" style="display:none; Z-INDEX:1; RIGHT:10px; WIDTH:150px; POSITION:absolute; TOP:67px"><img src="img/ug/4_right_wall.gif" width="150" height="71"></div>';
	document.getElementById('lok').innerHTML+='<div id="sunduk" style="display:none; Z-INDEX:6; LEFT:130px;POSITION:absolute; TOP:115px; "><img src="img/ug/sunduk.gif" alt="" style="CURSOR:hand" onClick="dungeon_take(sunduk_id);"></div><div id="sunduk_l" style="display:none; Z-INDEX:6; LEFT:10px; POSITION:absolute; TOP:115px;"><img src="img/ug/sunduk.gif" alt=""></div><div id="sunduk_r" style="display:none; Z-INDEX:6; LEFT:245px; POSITION:absolute; TOP:115px;"><img src="img/ug/sunduk.gif" alt=""></div>';
	document.getElementById('lok').innerHTML+='<div id="sunduk_small" style="display:none; Z-INDEX:6; LEFT:145px;POSITION:absolute; TOP:100px; "><img src="img/ug/sunduk.gif" alt="" width=80></div><div id="sunduk_l_small" style="display:none; Z-INDEX:1; LEFT:50px; POSITION:absolute; TOP:110px;"><img src="img/ug/sunduk.gif" width=80 alt=""></div><div id="sunduk_r_small" style="display:none; Z-INDEX:1; LEFT:230px; POSITION:absolute; TOP:110px;"><img src="img/ug/sunduk.gif" width=80 alt=""></div>';
	document.getElementById('lok').innerHTML+='<div id="m2_1" onmouseout="closeMenu();" style="display:none; Z-INDEX:6; LEFT:140px; WIDTH:98px; POSITION:absolute; TOP:57px; HEIGHT:180px"><img src="img/ug/bots/1016.gif" width="98" height="180" alt="" style="CURSOR:hand" id="im2_1" onClick="OpenMenu(bots_id);"></div><div id="m2_l1" style="display:none; Z-INDEX:6; LEFT:0px; WIDTH:87px; POSITION:absolute; TOP:52px; HEIGHT:160px" ><img src="img/ug/bots/1016.gif" width="87" height="160" alt="" id="im2_l1"></div><div id="m2_r1" style="display:none; Z-INDEX:6; LEFT:280px; WIDTH:87px; POSITION:absolute; TOP:52px; HEIGHT:160px"><img src="img/ug/bots/1016.gif" width="87" height="160" alt="" id="im2_r1"></div>';
	document.getElementById('lok').innerHTML+='<div id="m2_3" style="display:none; Z-INDEX:4; LEFT:160px; WIDTH:49px; BOTTOM:100px; POSITION:absolute; HEIGHT:90px"><img src="img/ug/bots/1016.gif" width="49" height="90" alt="" id="im2_3"></div><div id="m2_l3" style="display:none; Z-INDEX:4; LEFT:70px; WIDTH:49px; BOTTOM:100px; POSITION:absolute; HEIGHT:90px"><img src="img/ug/bots/1016.gif" width="49" height="90" alt="" id="im2_l3"></div><div id="m2_r3" style="display:none; Z-INDEX:4; LEFT:240px; WIDTH:49px; BOTTOM:100px; POSITION:absolute; HEIGHT:90px"><img src="img/ug/bots/1016.gif" width="49" height="90" alt="" id="im2_r3"></div>';
	document.getElementById('lok').innerHTML+='<div id="teleport" onmouseout="closeMenu();" style="display:none; Z-INDEX:6; LEFT:130px;POSITION:absolute; TOP:90px;"><img src="img/ug/teleport.gif" alt="Телепортация"></div>';
	document.getElementById('lok').innerHTML+='<div id="teleport_small" onmouseout="closeMenu();" style="display:none; Z-INDEX:6; LEFT:160px;POSITION:absolute; TOP:105px;"><img src="img/ug/teleport.gif" width="55" alt="Телепортация"></div>';

}

