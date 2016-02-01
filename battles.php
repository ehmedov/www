<?
include("key.php");
Header('Content-Type: text/html; charset=windows-1251');
Header("Cache-Control: no-cache, must-revalidate"); // говорим браузеру что-бы он не кешировал эту страницу
Header("Pragma: no-cache");
?>
<html>
<head>
	<link href="favicon.ico" rel="icon">
	<title>XAKUS</title>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<meta http-equiv="Content-Language" content="ru">
	<META Http-Equiv=Cache-Control Content="no-cache, max-age=0, must-revalidate, no-store">
	<meta http-equiv=PRAGMA content=NO-CACHE>
	<meta http-equiv=Expires content=0>	
</head>
	
<SCRIPT LANGUAGE="JavaScript" src="jquery.js"></SCRIPT>
<script>

window.status='Браузерная онлайн игра XAKUS';

var chat_turn=1;
var ChatOm = false;			// фильтр сообщений в чате
var autogo = false;
var autosave = false;
var rnd = Math.random();

//-- Смена хитпоинтов
var delay = 8;		// Каждые 8сек. увеличение HP на 1%
var redHP = 0.33;	// меньше 30% красный цвет
var yellowHP = 0.66;// меньше 60% желтый цвет, иначе зеленый
var TimerOn = -1;	// id таймера
var tkHP, maxHP;
var speed=100;
var mspeed=100;
var chat_version = -1;
function setHP(value, max, newspeed) 
{
	tkHP=value; maxHP=max;
	if (TimerOn>=0) { clearTimeout(TimerOn); TimerOn=-1; }
	if (newspeed < 1) TimerOn=-1;
	speed=newspeed;
	setHPlocal();
}
function setHPlocal() 
{
	if (tkHP>maxHP) { tkHP=maxHP; TimerOn=-1;} else {TimerOn=0;}
	var le=Math.round(tkHP)+"/"+maxHP;
	//	le=240 - (le.length + 2)*7;
	le=260;
	var sz1 = Math.round( ( le/maxHP ) * tkHP );
	var sz2 = le - sz1;
	if (top.frames['main'].document.all("HP")) 
	{
		top.frames['main'].document.HP1.width=sz1;
		top.frames['main'].document.HP2.width=sz2;
		top.frames['main'].document.HP2.display=sz2?"":"none";
		if (tkHP/maxHP < redHP) { top.frames['main'].document.HP1.src='img/icon/red.jpg'; }
		else 
		{
			if (tkHP/maxHP < yellowHP) 
			{ 
				top.frames['main'].document.HP1.src='img/icon/yellow.jpg'; 
			}
			else 
			{ 
				top.frames['main'].document.HP1.src='img/icon/green.jpg'; 
			}
		}
		var s = top.frames['main'].document.all("HP").innerHTML;
		top.frames['main'].document.all("HP").innerHTML = Math.round(tkHP)+"/"+maxHP;
	}
	tkHP = (tkHP+(maxHP/100)*speed/1000);
	if (TimerOn!=-1) {TimerOn=setTimeout('setHPlocal()', delay*100)};
}

//-- Смена маны
var Mdelay = 8;
var MTimerOn = -1;	// id таймера
var tkMana, maxMana;
function setMana(value, max, newspeed) 
{
	tkMana=value; maxMana=max;
	if (MTimerOn>=0) { clearTimeout(MTimerOn); MTimerOn=-1; }
	if (newspeed < 1) TimerOn=-1;
	mspeed=newspeed;
	setManalocal();
}
function setManalocal() 
{
	if (maxMana==0) return(0);
	if (tkMana>maxMana) { tkMana=maxMana; MTimerOn=-1; } else {MTimerOn=0;}
	var le=Math.round(tkMana)+"/"+maxMana;
	le=260;
	var sz1 = Math.round( ( le / maxMana ) * tkMana);
	var sz2 = le - sz1;
	if (top.frames['main'].document.all("Mana")) 
	{
		top.frames['main'].document.Mana1.width=sz1;
		top.frames['main'].document.Mana2.width=sz2;
		top.frames['main'].document.Mana2.display=sz2?"":"none";
		top.frames['main'].document.Mana1.src='img/icon/blue.jpg';
		var s = top.frames['main'].document.all("Mana").innerHTML;
		top.frames['main'].document.all("Mana").innerHTML = s.substring(0, s.lastIndexOf(':')+1) + Math.round(tkMana)+"/"+maxMana;
	}
	tkMana = (tkMana+(maxMana/1000)*mspeed/100);
	if (MTimerOn!=-1) {MTimerOn=setTimeout('setManalocal()', Mdelay*100);};
}
//---------------------CHAT WORKS---------------------
var ChatTimerID = -1;           // id таймера для чата
var ChatDelay = 12;             // через сколько сек. рефрешить чат
var ChatNormDelay = 12;         // через сколько сек. рефрешить чат при нормальном обновлении
var ChatSlowDelay = 60;         // через сколько сек. рефрешить чат при медленном обновлении
var ChatSlow = false;           // обновление чата раз в минуту
var ChatClearTimerID = -1;      // id таймера для чата
var ChatClearDelay = 300;       // через сколько сек. чистим чат
var ChatClearSize = 5000;      // Сколько байт оставляем после чистки
var SysClearSize = 5000;      // Сколько байт оставляем после чистки
var user = '<?echo $_SESSION["login"]; ?>';
var maxsmiles = 3;

function RefreshChat()
{
	var s = '&user='+user;
 	if (top.ChatOm) { s=s+'&fltr=1'; }
 	if (ChatTimerID>=0) { clearTimeout(ChatTimerID); }
 	ChatTimerID = setTimeout('RefreshChat()', ChatDelay*1000);
 	top.talk.frames['refreshed'].location='chat/chat.php?sub=refreshed&'+Math.random()+s;
}

function StopRefreshChat() // останавливает обновление чата
{
	if (ChatTimerID>=0) {clearTimeout(ChatTimerID); }
 	ChatTimerID = -1;
}

function NextRefreshChat() // сбрасывает таймер счетчика
{
	if (ChatTimerID>=0) {clearTimeout(ChatTimerID); }
 	ChatTimerID = setTimeout('RefreshChat()', ChatDelay*1000);
}

function RefreshClearChat() // Автоочистка чата
{
	if (ChatClearTimerID>=0) { clearTimeout(ChatClearTimerID); }
 	ChatClearTimerID = setTimeout('RefreshClearChat()', ChatClearDelay*1000);
 	var s = frames.ch.frames.chat.document.all["mes"].innerHTML;
 	var s1 = frames.ch.frames.chat.document.all["mes1"].innerHTML;
 	if (s.length > ChatClearSize)
 	{
 		var j = s.lastIndexOf('<BR>', s.length-ChatClearSize);
  		frames.ch.frames['chat'].document.all("mes").innerHTML = s.substring(j, s.length);
 	}
 	if (s1.length > SysClearSize)
 	{
 		var j = s1.lastIndexOf('<BR>', s1.length-SysClearSize);
  		frames.ch.frames['chat'].document.all("mes1").innerHTML = s1.substring(j, s1.length);
 	}
}
function AddTo(login)
{
	var o = main.Hint3Name;
	if ((o != null)&&(o != "")) 
	{
		frames['main'].document.all(o).value=login;
		frames['main'].document.all(o).focus();
	} 
 	else
 	{
 		frames['talk'].document.F1.text.focus();
 		frames['talk'].document.F1.text.value = 'to ['+login+'] '+ frames['talk'].document.F1.text.value;
 	}
}

function AddToPrivate(login)
{
	frames['talk'].document.F1.text.focus();
 	frames['talk'].document.F1.text.value = 'private ['+login+'] ' + frames['talk'].document.F1.text.value;
}

function AddToClan(clan)
{
	frames['talk'].document.F1.text.focus();
 	frames['talk'].document.F1.text.value = 'clan ['+clan+'] ' + frames['talk'].document.F1.text.value;
}
function get_by_id(name)
{
  if (frames.ch.frames["chat"].document.getElementById) return frames.ch.frames["chat"].document.getElementById(name);
  else if (frames.ch.frames["chat"].document.all) return frames.ch.frames["chat"].document.all[name];
}

function CLR1() {frames['talk'].document.F1.text.value=''; frames['talk'].document.F1.text.focus();}

function copyLogin (login)
{
  	var cpn = get_by_id ('holdtext');
  	cpn.innerText = login;
  	var cp = cpn.createTextRange();
  	cp.execCommand ("RemoveFormat");
  	cp.execCommand ("Copy");
}

function start() // Старт чата
{
	ChatTimerID = setTimeout('RefreshChat()', ChatDelay*1000); 	
 	ChatClearTimerID = setTimeout('RefreshClearChat()', ChatClearDelay*1000);
}

function sml(smile)
{
	top.talk.document.forms[0].text.value += ' :'+smile+': ';
}

function am(text,all_messages)
{
	//alert(text);
	var s="";
 	var spl=text.split("<BR>");
 	for (var k=0; k<spl.length; k++)
 	{
 		var txt=spl[k];
  		if (txt.length>0)
  		{
  			var i,j=0;
   			for (i=0; i < 129; i++)
   			{
   				while(txt.indexOf('*sm'+i+'*') >= 0)
    			{
    				txt = txt.replace('*sm'+i+'*', "<img src='../img/smile/sm"+i+".gif' border=0>");
     				if (++j >= maxsmiles) break;
    			}
    			if (j>=maxsmiles) break;
   			}
   			if ((j=txt.indexOf('private ['))>0 && (i=txt.indexOf(']', j+9))>0 && txt.indexOf('</font> [<SPAN>'+user+'</SPAN>] ')>0)
   			{
   				var user2 = txt.substring(j+9, i);
    			txt = txt.replace('private ['+user2+']', '<SPAN class=p alt="'+user2+'">private ['+user2+']</SPAN>');
   			}
   			else if (txt.indexOf('private ['+user+']')>0)
   			{
   				if ((j=txt.indexOf('[<SPAN>'))>0)
    			{
    				i=txt.indexOf('</', j+7);
     				var user2 = txt.substring(j+7, i);
     				txt = txt.replace('private ['+user+']', '<SPAN class=p alt="'+user2+'">private ['+user+']</SPAN>');
    			}
    			else
    			{
    				txt = txt.replace('private ['+user+']', '<b>private ['+user+']</b>')
    			}
    			txt = txt.replace('<font class=date>', '<font class=date2>');
   			}
   			else if ((j=txt.indexOf('clan ['))>0 && (i=txt.indexOf(']', j+6))>0)
   			{
   				var clan = txt.substring(j+6, i);
    			txt = txt.replace('clan ['+clan+']', '<SPAN class=clan_st alt="'+clan+'">clan ['+clan+']</SPAN>');
   			}
   			else if (txt.indexOf('to ['+user+']')>0)
   			{
   				txt = txt.replace('to ['+user+']', '<b>to ['+user+']</b>');
    			txt = txt.replace('<font class=date>', '<font class=date2>');
   			}
   			s+=txt+"<BR>";
  		}
 	}
 	if (all_messages==0){if (frames.ch.frames['chat'].document.all["mes"])	frames.ch.frames['chat'].document.all["mes"].innerHTML += s;}
 	if (all_messages==1){if (frames.ch.frames['chat'].document.all["mes1"])	frames.ch.frames['chat'].document.all["mes1"].innerHTML += s;}
 	scrl(0);
}

function AddLogin(ev) // Добавить обращение из чата
{
    if (frames.ch.frames["chat"].window.event)
    {
        ev = frames.ch.frames["chat"].window.event;
    }
    var o = frames.ch.frames["chat"].window.event ? frames.ch.frames["chat"].window.event.srcElement : ev.target;

 	if (o.tagName == "SPAN")
 	{
 		var login=o.innerHTML;
  		if (o.getAttribute('alt') != null && o.getAttribute('alt').length>0) login=o.getAttribute('alt');
  		var i1,i2;
  		if ((i1 = login.indexOf('['))>=0 && (i2 = login.indexOf(']'))>0) login=login.substring(i1+1, i2);
  		if (o.className == "p") { top.AddToPrivate(login, false) }
  		else if (o.className == "clan_st") { top.AddToClan(login, false) }
  		else { top.AddTo(login) }
 	}
}

// Функция для определения координат указателя мыши
function defPosition(event) 
{
      var x = y = 0;
      if (document.attachEvent != null) 
      { 	
      		// Internet Explorer & Opera
            x = frames.ch.frames["chat"].window.event.clientX + (frames.ch.frames["chat"].document.documentElement.scrollLeft ? frames.ch.frames["chat"].document.documentElement.scrollLeft : frames.ch.frames["chat"].document.body.scrollLeft);
            y = frames.ch.frames["chat"].window.event.clientY + (frames.ch.frames["chat"].document.documentElement.scrollTop ? frames.ch.frames["chat"].document.documentElement.scrollTop : frames.ch.frames["chat"].document.body.scrollTop);
			if (frames.ch.frames["chat"].window.event.clientY + 72 > frames.ch.frames["chat"].document.body.clientHeight) { y-=68 } else { y-=2 }
      } 
      else if (!document.attachEvent && document.addEventListener) 
      { 
      		// Gecko
            x = event.clientX + frames.ch.frames["chat"].window.scrollX;
            y = event.clientY + frames.ch.frames["chat"].window.scrollY;
			if (event.clientY + 72 > frames.ch.frames["chat"].document.body.clientHeight) { y-=68 } else { y-=2 }
      } 
      else 
      {
            // Do nothing
      }
      return {x:x, y:y};
}
function OpenMenu(event) //Менюшка в чате
{
	event = event || window.event;
    var el, login;
    var html = "";
	el = frames.ch.frames["chat"].document.getElementById("oMenu");
	o=event.target || event.srcElement;
	if (o.tagName != "SPAN") return false;

	login=(event.target || event.srcElement).innerHTML;
	
	var i1, i2;
	if ((i1 = login.indexOf('['))>=0 && (i2 = login.indexOf(']'))>0) login=login.substring(i1+1, i2);
	
	html = '<A class="menuItem" HREF="javascript:top.AddTo(\''+login+'\');top.cMenu();">»&nbsp;Для</A>'+
	'<A class="menuItem" HREF="javascript:top.AddToPrivate(\''+login+'\');top.cMenu();">»&nbsp;Приватно</A>'+
	'<A class="menuItem" HREF="javascript:top.copyLogin(\''+login+'\');top.cMenu();">»&nbsp;Копировать</A>'+
	'<A class="menuItem" HREF="javascript:top.inf(\''+login+'\');top.cMenu();">»&nbsp;Информация</A>'+
	'<A class="menuItem" HREF="javascript:top.ignor(\''+login+'\');top.cMenu();">»&nbsp;В игнор</A>';

	if(html)
	{
		el.innerHTML = html;
		el.style.left = defPosition(event).x + "px";
		el.style.top  = defPosition(event).y + "px";
		el.style.display = "";
	}
	event.returnValue=false;
	return false;
}
function closeMenu(event)
{
	if (frames.ch.frames["chat"].window.event && frames.ch.frames["chat"].window.event.toElement)
	{
		var cls = frames.ch.frames["chat"].window.event.toElement.className;
 		if (cls=='menuItem' || cls=='menu') return true;
	}
 	frames.ch.frames["chat"].document.all("oMenu").style.display = "none";
 	return false;
}
function cMenu()
{
	frames.ch.frames["chat"].document.all("oMenu").style.display = "none";
	top.talk.F1.text.focus();
}
function inf(login)
{
	window.open('../info.php?log='+login,'_blank','');
}

function ignor(login)
{
	top.frames.main.document.location="../ignor.php?login="+login;
}


function sw_filter() // Фильтрация сообщений
{
	top.ChatOm = ! top.ChatOm; 
	if (top.ChatOm) 
	{
	  	top.talk.document.all('filter').title = '(включено) Показывать в чате только сообщения адресованные мне';
	  	top.talk.document.all["filter"].innerHTML = '<img src="img/design/talk/close.gif">';
 	}
 	else 
 	{
  		top.talk.document.all('filter').title = '(выключено) Показывать в чате только сообщения адресованные мне';
  		top.talk.document.all["filter"].innerHTML = '<img src="img/design/talk/talk.gif">';
 	}
	top.talk.F1.text.focus();
}


function clearc() // Очистка чата от масаг
{
	if (frames['talk'].document.F1.text.value == '')
	{
		if (confirm("Вы точно хотите стереть чат?"))
		{
			if (chat_turn == 1) frames.ch.frames['chat'].document.all('mes').innerHTML='';
			else if (chat_turn == 2) frames.ch.frames['chat'].document.all('mes1').innerHTML='';
			else if (chat_turn == 3) frames.ch.frames['chat'].document.all('mes2').innerHTML='';
		}
	}
	else 
	{ 
		frames['talk'].document.F1.text.value='';
	}
	frames['talk'].document.F1.text.focus();
}

function scrl(how)
{
	frames.ch.frames["chat"].window.scrollBy(0, 65000);
}
//----------------Ajax Work------------------------------
function refrew() 
{
	$.get('battle_ajax.php?nocache=' + Math.random(), function(data) 
	{
	   	switch (data)
		{
			case "battle":  		top.main.location.href="battle.php?tmp="+Math.random();  break;
		}
	});
	setTimeout("refrew();",5000);
}
refrew();
//----------------Ajax Work------------------------------
document.write(
	'<frameset rows="50,*,38" frameborder="0" border="0" framespacing="0">'+
		'<frame src="menu.php?'+rnd+'" scrolling="no" noresize frameborder="0" border="0" framespacing="0" marginwidth="0" marginheight="0">'+
		'<frameset cols="10, *, 10" frameborder="0" framespacing="0" border="0">'+
			'<frame src="bgleft.html" marginwidth="0" marginheight="0" scrolling="no" frameborder="0"></frame>'+
				'<frameset rows="75%, *" frameborder="0" border="0" framespacing="0">'+
					'<frame src="main.php?act=none&tmp='+rnd+'"  name="main" marginwidth="0" marginheight="0" frameborder="0" border=0 style="border-bottom: 1px solid #44484f; cursor: s-resize;"></frame>'+
					'<frameset cols="*, 300" frameborder="0" border="0" framespacing="0">'+
						'<frame src="ch.html?'+rnd+'" name="ch" frameborder="0" scrolling="no" marginwidth="1" marginheight="1" framespacing="1" />' +
						'<frame src="chat/users.php?'+rnd+'" name="users"  marginwidth="0" marginheight="0" scrolling="auto" frameborder="0" style="border-left: 1px solid #44484f; cursor: w-resize;">'+
					'</frameset>'+
				'</frameset>'+
			'<frame src="bgright.html" marginwidth="0" marginheight="0" scrolling="no" frameborder="0"></frame>'+
  		'</frameset>'+
		'<frame src="talk.php?'+rnd+'" name="talk" scrolling="no" noresize>'+
	'</frameset>');
</script>
<NOSCRIPT>
<FONT COLOR="red">Внимание!</FONT> В вашем браузере отключена поддержка JavaScripts. Необходимо их включить (это абсолютно безопасно!) для продолжения игры.<BR>
В меню браузера Internet Explorer выберите "Сервис" => "Свойства обозревателя" перейдите на закладку "Безопасность". Для зоны <B>Интернет</B> нажмите кнопку "Другой". Установите уровень безопасности "Средний", этого достаточно. Или же, в списке параметров найдите раздел "Сценарии" и там нужно разрешить выполнение Активных сценариев.
</NOSCRIPT>