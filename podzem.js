Up = new Array('', 'Шак вперед', 'Поворот на право', 'Поворот налево', 'Повернуться', 'Шаг назад', 'Шаг влево', 'Шаг вправо');
m_p=4;//Поля карты
mp_w=new Array ('', 8, 10, 10, 8);
mp_h=new Array ('', 10, 8, 8, 10);
pach="i/podzemka/lok/";
img=new Array(
	'1_left_wall.gif', '1_front_wall.gif', '1_right_wall.gif',
	'2_left_wall.gif', '2_front_wall.gif', '2_right_wall.gif',
	'3_left_wall.gif', '3_front_wall.gif', '3_right_wall.gif',
	'4_ceil_wall.gif', '4_floor_wall.gif', '4_left_wall.gif', '4_right_wall.gif'
);

var progressEnd = 32;
var progressColor = '#00CC00';
var mtime = parseInt('1');
if (!mtime || mtime<=0) {mtime=0;}
var progressInterval = Math.round(mtime*1000/progressEnd);
var is_accessible = true;
var progressAt = 0;
var progressTimer;
var GListUpdateTime;

function progress_create(){
	var s='';
	for (i=1; i<=progressEnd; i++) {
		s+='<span id="progress'+i+'">&nbsp;</span>';
		if (i<progressEnd) {s+='&nbsp;'};
	}
	document.getElementById('progr').innerHTML=s;
}

function progress_start(){
	progress_create();
	for (var i = 1; i <= progressEnd; i++) {
		document.getElementById('progress'+i).style.backgroundColor = progressColor;
	}
}

function progress_update() {
	progressAt++;
	if (progressAt > progressEnd) {
		is_accessible = true;
	} else {
		document.getElementById('progress'+progressAt).style.backgroundColor = progressColor;
		progressTimer = setTimeout('progress_update()',progressInterval);
	}
}

function progress_clear() {
	for (var i = 1; i <= progressEnd; i++) document.getElementById('progress'+i).style.backgroundColor = 'transparent';
	progressAt = 0;
    is_accessible = false;
}

function progress_stop() {
	clearTimeout(progressTimer);
	progress_clear();
}

//Загрузка картинок
function LoadImg(){
	var i = 0;
 	for(i=0; i<=(img.length-1); i++){
 		image = new Image();
       	image.src = pach+img[i];
  	}
}

function Print_(){	document.getElementById('lok').innerHTML='<div id="load" style="display:none; border:1px solid #808080; position: absolute; width: 137px; height: 45px; z-index: 10; left: 112px; top: 102px; background-color:#C0C0C0; padding-left:0; padding-right:0; padding-top:10px; padding-bottom:0"><b>Загрузка...</b></div><div style="display:none; position: absolute; width: 352px; height: 0px; left:10px; top:10px; Z-INDEX:10;" id="msg"></div><div id="l1l" style="display:none; Z-INDEX:7; LEFT:10px; WIDTH:50px; POSITION:absolute; TOP:10px"><img src="i/podzemka/lok/1_left_wall.gif" width="50" height="240"></div>\n<div id="l1f" style="display:none; Z-INDEX:7; LEFT:60px; WIDTH:252px; POSITION:absolute; TOP:29px; display:none"><img src="i/podzemka/lok/1_front_wall.gif" width="252" height="179"></div>\n<div id="l1r" style="display:none; Z-INDEX:7; RIGHT:10px; WIDTH:50px; POSITION:absolute; TOP:10px"><img src="i/podzemka/lok/1_right_wall.gif" width="50" height="240"></div>\n<div id="l2l" style="display:none; Z-INDEX:5; LEFT:10px; WIDTH:96px; POSITION:absolute; TOP:28px"><img src="i/podzemka/lok/2_left_wall.gif" width="96" height="182"></div>\n<div id="l2f" style="display:none; Z-INDEX:5; LEFT:106px; WIDTH:160px; POSITION:absolute; TOP:50px"><img src="i/podzemka/lok/2_front_wall.gif" width="160" height="117"></div>\n<div id="l2r" style="display:none; Z-INDEX:5; RIGHT:10px; WIDTH:96px; POSITION:absolute; TOP:28px"><img src="i/podzemka/lok/2_right_wall.gif" width="96" height="182"></div>\n<div id="l3l" style="display:none; Z-INDEX:3; LEFT:10px; WIDTH:128px; POSITION:absolute; TOP:50px"><img src="i/podzemka/lok/3_left_wall.gif" width="128" height="118"></div>\n<div id="l3f" style="display:none; Z-INDEX:3; LEFT:137px; WIDTH:96px; POSITION:absolute; TOP:67px"><img src="i/podzemka/lok/3_front_wall.gif" width="96" height="70"></div>\n<div id="l3r" style="display:none; Z-INDEX:3; RIGHT:10px; WIDTH:128px; POSITION:absolute; TOP:50px"><img src="i/podzemka/lok/3_right_wall.gif" width="128" height="118"></div>\n<div id="l4ce" style="display:none; LEFT:10px; WIDTH:352px; POSITION:absolute; TOP:10px"><img src="i/podzemka/lok/4_ceil_wall.gif" width="352" height="70"></div>\n<div id="l4fl" style="display:none; LEFT:10px; WIDTH:352px; BOTTOM:10px; POSITION:absolute"><img src="i/podzemka/lok/4_floor_wall.gif" width="352" height="135"></div>\n<div id="l4l" style="display:none; Z-INDEX:1; LEFT:10px; WIDTH:150px; POSITION:absolute; TOP:67px"><img src="i/podzemka/lok/4_left_wall.gif" width="150" height="71"></div>\n<div id="l4r" style="display:none; Z-INDEX:1; RIGHT:10px; WIDTH:150px; POSITION:absolute; TOP:67px"><img src="i/podzemka/lok/4_right_wall.gif" width="150" height="71"></div>';
	document.getElementById('lok').innerHTML+='<div onmouseout="hideshow();" id="m1_2" style="display:none; Z-INDEX:6; LEFT:77px; WIDTH:95px; POSITION:absolute; TOP:48px; HEIGHT:174px"><img src="i/podzemka/0.gif" width="95" height="174" alt="" style="CURSOR:hand" id="im1_2"></div>\n<div id="m1_3" onmouseout="hideshow();" style="display:none; Z-INDEX:6; LEFT:197px; WIDTH:95px; POSITION:absolute; TOP:49px; HEIGHT:174px"><img src="i/podzemka/0.gif" width="95" height="174" alt="" style="CURSOR:hand" id="im1_3"></div>\n<div id="m1_1" onmouseout="hideshow();" style="display:none; Z-INDEX:6; LEFT:140px; WIDTH:98px; POSITION:absolute; TOP:57px; HEIGHT:180px"><img src="i/podzemka/0.gif" width="98" height="180" alt="" style="CURSOR:hand" id="im1_1"></div><div id="m1_l1" style="display:none; Z-INDEX:6; LEFT:0px; WIDTH:87px; POSITION:absolute; TOP:52px; HEIGHT:160px"><img src="i/podzemka/0.gif" width="87" height="160" alt="" id="im1_l1"></div><div id="m1_r1" style="display:none; Z-INDEX:6; LEFT:280px; WIDTH:87px; POSITION:absolute; TOP:52px; HEIGHT:160px"><img src="i/podzemka/0.gif" width="87" height="160" alt="" id="im1_r1"></div>';
	document.getElementById('lok').innerHTML+='<div id="m2_l1" style="display:none; Z-INDEX:4; LEFT:10px; WIDTH:49px; BOTTOM:100px; POSITION:absolute; HEIGHT:90px"><img src="i/podzemka/0.gif" width="49" height="90" alt="" id="im2_l1"></div><div id="m2_l2" style="display:none; Z-INDEX:4; LEFT:40px; WIDTH:49px; BOTTOM:100px; POSITION:absolute; HEIGHT:90px"><img src="i/podzemka/0.gif" width="49" height="90" alt="" id="im2_l2"></div><div id="m2_l3" style="display:none; Z-INDEX:4; LEFT:70px; WIDTH:49px; BOTTOM:100px; POSITION:absolute; HEIGHT:90px"><img src="i/podzemka/0.gif" width="49" height="90" alt="" id="im2_l3"></div><div id="m2_r1" style="display:none; Z-INDEX:4; LEFT:300px; WIDTH:49px; BOTTOM:100px; POSITION:absolute; HEIGHT:90px"><img src="i/podzemka/0.gif" width="49" height="90" alt="" id="im2_r1"></div><div id="m2_r2" style="display:none; Z-INDEX:4; LEFT:270px; WIDTH:49px; BOTTOM:100px; POSITION:absolute; HEIGHT:90px"><img src="i/podzemka/0.gif" width="49" height="90" alt="" id="im2_r2"></div><div id="m2_r3" style="display:none; Z-INDEX:4; LEFT:240px; WIDTH:49px; BOTTOM:100px; POSITION:absolute; HEIGHT:90px"><img src="i/podzemka/0.gif" width="49" height="90" alt="" id="im2_r3"></div><div id="m2_2" style="display:none; Z-INDEX:4; LEFT:120px; WIDTH:49px; BOTTOM:100px; POSITION:absolute; HEIGHT:90px"><img src="i/podzemka/0.gif" width="49" height="90" alt="" id="im2_2"></div><div id="m2_1" style="display:none; Z-INDEX:4; LEFT:160px; WIDTH:49px; BOTTOM:100px; POSITION:absolute; HEIGHT:90px"><img src="i/podzemka/0.gif" width="49" height="90" alt="" id="im2_1"></div><div id="m2_3" style="display:none; Z-INDEX:4; LEFT:200px; WIDTH:49px; BOTTOM:100px; POSITION:absolute; HEIGHT:90px"><img src="i/podzemka/0.gif" width="49" height="90" alt="" id="im2_3"></div>';}

//Скрыть все слои
function HideDiv()
{
	id_div = new Array('l1l', 'l1f', 'l1r', 'l2l', 'l2f', 'l2r', 'l3l', 'l3f', "l3r", "l4ce", "l4fl", "l4l", "l4r");
	var i = 0;
	for(i=0; i<=id_div.length-1; i++)
		document.getElementById(id_div[i]).style.display = 'none';
}

//Скрыть навигацию
function HideUp()
{
	var i = 0;
	for(y=1; y<=7; y++)
	{
		eval ('document.getElementById(\'u'+y+'\').onmousemove = function () {fastshow2(\'<b>'+Up[y]+'</b><br><font color="#FF0000">Нельзя</font>\');}');
		document.getElementById('u'+y).onclick = null;
	}
}

//Показать локацию
function VesualLok(loks){
	var i = 0;
	for(i=1; i<=loks.length-1; i++)
		document.getElementById(loks[i]).style.display = 'block';
}

//Скрываем ботов
function HideBot(){
	id_bot = new Array('m1_1', 'm1_2', 'm1_3', 'm1_l1', 'm1_r1', 'm2_l1', 'm2_l2', 'm2_l3', 'm2_r1', 'm2_r2', 'm2_r3', 'm2_1', 'm2_2', 'm2_3');
	var i = 0;
	for(i=0; i<=id_bot.length-1; i++){
		document.getElementById(id_bot[i]).style.display = 'none';
		document.images['i'+id_bot[i]].src='i/podzemka/0.gif';
	}
}

//Показываем передних ботов
function GlVesualBot(bots, idd, imgs, nap, bot_id_a){
	var i = 0;
	for(i=1; i<=bots.length-1; i++){
		document.getElementById(idd[i]).style.display = 'block';
		document.images['i'+idd[i]].src='i/chars/0/'+imgs[bots[i]];
		eval ('document.getElementById(\''+idd[i]+'\').onmousemove = function () {fastshow2(\'<b>'+nap[bots[i]]+'</b>\');}');
		eval ('document.getElementById(\''+idd[i]+'\').onclick = function () {OpenMenu('+bot_id_a[i]+');}');
	}
}

//Показываем ботов
function VesualBot(bots, idd, imgs){
	var i = 0;
	for(i=1; i<=bots.length-1; i++){
		document.images['i'+idd[i]].src='i/chars/0/'+imgs[bots[i]];
		document.getElementById(idd[i]).style.display = 'block';
	}
}

//Показать навигацию
function VesualUP(navs){
	var y = 0;
	for(y=1; y<=navs.length-1; y++){
		eval ('document.getElementById(\'u'+navs[y]+'\').onmousemove = function () {fastshow2(\'<b>'+Up[navs[y]]+'</b>\');}');
		eval ('document.getElementById(\'u'+navs[y]+'\').onclick = function () {go('+navs[y]+');}');	}

}

//Ходьба
function go(v) {	if (is_accessible){     document.getElementById('load').style.display = 'block';
     createRequest();
     request.open("GET", "go_podz.php?v="+v, true);
     request.onreadystatechange = UpdateP;
     request.send(null);
 	}
}

function UpdateP() {
     if (request.readyState == 4) {
       if (request.status == 200) {
  		 if (request.responseText!=""){  		 	HideUp();
  		 	if (request.responseText=="exitgl")
  		 		showMsg("exitgl");
  			else {	  		 	HideDiv();
	  		 	HideBot();
	  		 	progress_clear();
	     		progress_update();
	     		eval(request.responseText);
	     		GList();
	     		VesualUP(ups);
	     		VesualLok(lok);
	     		GlVesualBot(bot, idds, imgss, naps, bot_id_a);
	     		VesualBot(bot_, idds_, imgss);
	     		SetScrolMap(Leftm, Topm);
	     		SetStrelka(Lefts, Tops, nap);
			    smotrNa(nap);
			}
  		 }
  		 document.getElementById('load').style.display = 'none';
       } else
         alert("status is "+request.status);
     }
}
//

//Список группы
function GList() {	 if (GListUpdateTime)     	clearTimeout(GListUpdateTime);
     createRequest();
     request.open("GET", "podzem_group_inf.php", true);
     request.onreadystatechange = GListUpdate;
     request.send(null);
     GListUpdateTime = setTimeout(GList, 20000);
}

function GListUpdate() {
     if (request.readyState == 4) {
       if (request.status == 200) {
  		 if (request.responseText!=""){
	     		eval(request.responseText);
			    GroupList(name, idp, levelp, align, klan, hps, maxhps, xk, yk);
  		 }
       } else
         alert("status is "+request.status);
     }
     return true;
}
//

function fastshow2 (content) {
  var el = document.getElementById("mmoves");
  if (content!='' && el.style.visibility != "visible") {el.innerHTML = '<small>'+content+'</small>';}

  if(event.clientX+document.body.scrollLeft+el.clientWidth+20>=document.body.clientWidth) x=event.clientX-el.clientWidth-10;
  else x=event.clientX+document.body.scrollLeft+10;
  y=event.clientY+document.body.scrollTop+20;
  el.style.left=x;
  el.style.top=y;
  if (el.style.visibility != "visible") {
    el.style.visibility = "visible";
  }
}

function hideshow () {
  document.getElementById("mmoves").style.visibility = 'hidden';
}

//меню наподения
function OpenMenu(id){	 var el, x, y;
	 el = document.all("oMenu");
	 x = event.clientX + document.documentElement.scrollLeft +document.body.scrollLeft - 5;
	 y = event.clientY + document.documentElement.scrollTop + document.body.scrollTop-5;
	 if (event.clientY + 72 > document.body.clientHeight) { y-=62 } else { y-=2 }
	 el.innerHTML = '<div class=menuItem onmouseout="this.className=\'menuItem\';" onmouseover="this.className=\'menuItem2\';" onclick="Attak_b('+id+');">Напасть</div>';
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

//Установка положение мини карты
function SetScrolMap(Left_, Top_){
    map_pod_=document.all("map_pod");
	map_pod_.scrollLeft=Left_;
	map_pod_.scrollTop=Top_;
}

//Установка стрелки
function SetStrelka(Left_, Top_, I_){	L1=(Left_-1)*18.5+m_p;
	L2=Left_*17+m_p;
	T1=(Top_-1)*17.5+m_p;
	T2=Top_*17+m_p;
	im_t=Math.round(3+T1);
	im_l=Math.round(((18.5-mp_w[I_])/2)+L1);
	//im_l=Math.round(L1);
	document.getElementById('st').innerHTML='<div style="position: absolute; left:'+im_l+'px; top:'+im_t+'px" id="strelka"><img border="0" src="i/podzemka/mp/mp'+I_+'.gif"></div>';
}

//Смотрит на
function smotrNa(t){	var st;	switch (t){		case 1 : st="Смотрим на Север"; break;
		case 2 : st="Смотрим на Восток"; break;
		case 3 : st="Смотрим на Запод"; break;
		case 4 : st="Смотрим на Юг"; break;
		default : st=''; break	}
	document.getElementById('sm').innerHTML=st;}
//

//Список группы
function GroupList(name, id, level, dealer,orden,admin_level, clan, clan_short, hps, maxhps, xk, yk){  var s='<table border="1"><tr><td>'+drwfl(name[0],id[0],level[0],dealer[0],orden[0],admin_level[0],clan_short[0],clan[0])+'</td>';
  s+='<td>'+hps[0]+'/'+maxhps[0]+'</td></tr></table>';
  s+="<table border='0'>";
  var bg='';
  for(i=1; i<=name.length-1; i++)
  {
  	  s+='<tr><td bgcolor="#DFDFDF">';
  	  s+=drwfl(name[i],id[i],level[i],dealer[i],orden[i],admin_level[i],clan_short[i],clan[i]);
	  s+='</td><td bgcolor="#DFDFDF">';
	  s+=hps[i]+'/'+maxhps[i];
	  s+='</td><td bgcolor="#DFDFDF">';
	  s+=Poloj(xk[i], yk[i], xk[0], yk[0]);
	  s+='</td></tr>';
  }
  s+='</table>';
  document.getElementById('grlist').innerHTML=s;
}
//

//Перс HP
function persHP(hp_, maxhp_){	var s='';	var redHP = 30;	// меньше 30% красный цвет
  	var yellowHP = 60;// меньше 60% желтый цвет, иначе зеленый	hpur=Math.round(hp_*100/maxhp_);
	if (hpur<redHP) imhp='bk_life_red.gif';
	else if (hpur<yellowHP) imhp='bk_life_yellow.gif';
	else imhp='bk_life_green.gif';
	s+='<div style="width: 100px; height: 8px; background-image: url(\'../i/misc/bk_life_loose.gif\'); background-repeat: repeat-x; background-position-x: left" onmouseout="hideshow();" onmousemove="fastshow2(\'Уровень HP:<b>'+Math.round(hp_)+'/'+Math.round(maxhp_)+'</b>\');"><img border="0" src="../i/misc/'+imhp+'" width="'+hpur+'" height="8"></div>';
	return s;}
//

//Положение
function Poloj(x, y, x0, y0){	var x_=x0-x;
	var y_=y0-y;
	var s='';	if (x_>0) s+='Запод-'+x_;
	else if (x_<=0)	{		x_=x_*(-1);
		s+='Восток-'+x_;	}
	if (s!='' && y_!=0) s+=', ';
	if(y_>0) s+='Север-'+y_;
	else if (y_<=0)	{		y_=y_*(-1);
		s+='Юг-'+y_;	}
	return s;}
//

//Показ сообщения
function showMsg(type){	 var st='';	 switch (type){
		case "exitgl" : st="Вашь проводник покинул \"Подземелье!!!\""; break;
		default : st=''; break
	}
	document.getElementById('msg').style.display = 'block';
	document.getElementById('msg').innerHTML=st;}
//

//Нападение на бота
function Attak_b(id) {
  createRequest();
  request.open("GET", "attack_bot.php?id="+id, true);
  request.onreadystatechange=function(){
	  if (request.readyState == 4) {
	  	if (request.status == 200){
	         if (request.responseText=="attack")
   				  window.location.reload();
	  	}else
	         alert("status is "+request.status);
	  }
  }
  request.send(null);
  closeMenu();
}
//