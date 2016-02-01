var Blocks=new Array("Нет","Голова", "Грудь", "Живот", "Пояс", "Ноги");

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
	document.write("<table border=0 cellpadding=0 cellspacing=0 width=260 height=10 bgcolor=#dedede><tr><td width=100% nowrap style='position: relative' background='img/icon/grey.jpg'><img src="+color+"  alt='Уровень жизни' height='10' width="+m2+"%><SPAN style='position: absolute; right: 5; z-index: 1; font-weight: bold;font-size: 10; color: #FFFFFF'>"+min+"/"+max+"</span></td></tr></table>");
}

function showMN(min, max)
{
	perc=max/100;
	n=max-min;
	m2=Math.floor(min/perc);
	m1=Math.floor(100-m2);
	if(m2==100){m2=100;}
	color='img/icon/blue.jpg'
	document.write("<table border=0 cellpadding=0 cellspacing=0 width=260 height=10 bgcolor=#dedede><tr><td width=100% nowrap style='position: relative' background='img/icon/grey.jpg'><img src="+color+" alt='Уровень маны' height='10' width="+m2+"%><SPAN style='position: absolute; right: 5; z-index: 1; font-weight: bold;font-size: 10; color: #FFFFFF'>"+min+"/"+max+"</span></td></tr></table>");
}

function draw_combat_info(legend, side)
{
  	var s ='<img src="img/combats/1x1.gif" border=0 width="4" height=1>';
  	if (!side) return;
  	for (var i=1;i<=5;i++)
  	{
    	s += '<img src="img/combats/'+((3+(side & 1))*10 + legend[i])+'.gif" alt="" width="10" height="12" border="0" align="bottom">';
  	}
  	return s;
}


function adh(a,d,tm,to, me) 
{
	var s = "", s1 = "", legend = new Array(0,0,0,0,0,0);

	if (a > 0) { s1="Атака: "+Blocks[a]+"<BR>"; legend[a] = 2;}
	var dd = (""+d).split('');

	for (i=0; i<dd.length; i++) 
	{
		if (s) s+= (i == dd.length - 1) ? " и ": ", ";
		s+=Blocks[parseInt(dd[i])];
		legend[parseInt(dd[i])] += 1;
	}

	s = 'Защита: ' + s;

	document.write("<SPAN style='' onmouseover='slot_view(\""+s1+s+"\"); this.style.textDecoration=\"underline\"' onmouseout='slot_hide(); this.style.textDecoration=\"\"'>");
	if (tm) 
	{ // Время определено - значит нуна вывести время и(?) легенду
		if (me==my_login)highlite=true;else highlite=false;
		s = '<font class=date' + (highlite?'2':'') + '>' + tm + '</font>';
		if (to) s+=(draw_combat_info(legend, to));
		document.write(s+'</SPAN>');
		document.write(' ');
	} 
	else if (tm=='') document.write('??:?? </SPAN> ');
}


function DrawRes(SP_HIT, SP_KRT, SP_CNTR, SP_BLK, SP_HP, SP_ALL,SP_PARRY)
{
	document.writeln('<TABLE width=238><tr>' +
		"<TD width=34 align=center><SMALL><IMG width=15 alt='Нанесенный удар'  		src='img/priem/hit.gif'>" + SP_HIT + "</TD>" +
		"<TD width=34 align=center><SMALL><IMG width=15 alt='Критический удар'  	src='img/priem/krit.gif'>" + SP_KRT + "</TD>" +
		"<TD width=34 align=center><SMALL><IMG width=15 alt='Парирования'  			src='img/priem/parry.gif'>" + SP_PARRY + "</TD>" +
		"<TD width=34 align=center><SMALL><IMG width=15 alt='Проведенный уворот'  	src='img/priem/uvarot.gif'>" + SP_CNTR + "</TD>" +
		"<TD width=34 align=center><SMALL><IMG width=15 alt='Успешный блок'  		src='img/priem/block.gif'>" + SP_BLK + "</TD>" +
		"<TD width=34 align=center><SMALL><IMG width=15 alt='Уровень духа'  	    src='img/priem/hp.gif'>" + SP_HP + "</TD>" +
		"<TD width=34 align=center><SMALL><IMG width=15 alt='Нанесенный урон'  	    src='img/priem/all.gif'>" + SP_ALL + "</TD>" +
		'</tr></TABLE>');
}

function DrawTrick(can_use, img,  txt, free_cast, dsc, resource, select_target, target, target_login, magic_type, name)
{
  var s = '';
  var rnd = Math.random();
  var res = resource.split(',');
  // 0=HIT, 1=KRT, 2=CNTR, 3=BLK, 4=PRY, 5=HP, 6=spirit, 7=mana, 8=cool_down, 9=cool_down_left, 10=limit, 11=limit_left

  if (can_use)
  {
  	if (select_target)
  	{
	  	s += "<A style='cursor: hand' onclick=\"findlogin('</b>Выберите" +
		     (target == 'friend' ? ' дружественную цель': (target == 'enemy' ? ' врага': (target == 'any'? ' цель':""))) +
	  	     ' для приема <b nobr nowrap>' + txt + "', 'battle.php', 'target',  '" + target_login + "', '" +
		     magic_type + "', '<INPUT type=hidden name=special value=" + name+ ">'" + (free_cast?'':', 1') + ')">';
  	} 
  	else 
  	{
		s += free_cast ? '<A HREF="/battle.php?special=' + name + '&r=' + rnd + '">': "<A style='cursor: hand' onclick=\"b_confirm('battle.php', '" + txt + "', '" + magic_type + "', '<INPUT type=hidden name=special value=" + name+ ">', 1)\">";
	}
  }

  s +=  '<IMG style="' + (can_use? 'cursor:hand': "filter:gray(), Alpha(Opacity='70');") + '" width=40 height=25 '+ "src='../i/misc/icons/" + img+ ".gif'";
  if (txt){
	s+= "onmouseout='hideshow();' onmouseover='fastshow(\"<B>" + txt + "</B><BR>" ;
	s+= (res[0]=='0'? '': '<IMG width=8 height=8 src=\\"../i/misc/micro/hit.gif\\"> '+ res[0] + '&nbsp;&nbsp;');
	s+= (res[1]=='0'? '': '<IMG width=8 height=8 src=\\"../i/misc/micro/krit.gif\\"> '+ res[1] + '&nbsp;&nbsp;');

	s+=  (res[2]=='0'? '': '<IMG width=8 height=8 src=\\"../i/misc/micro/counter.gif\\"> '+ res[2] + '&nbsp;&nbsp;');

	s+=  (res[3]=='0'? '': '<IMG width=8 height=8 src=\\"../i/misc/micro/block.gif\\"> '+ res[3] + '&nbsp;&nbsp;');
	s+=  (res[4]=='0'? '': '<IMG width=8 height=8 src=\\"../i/misc/micro/parry.gif\\"> '+ res[4] + '&nbsp;&nbsp;');
	s+=  (res[5]=='0'? '': '<IMG width=8 height=8 src=\\"../i/misc/micro/hp.gif\\"> '+ res[5] + '&nbsp;&nbsp;');
	s+=  (res[6] == '0' ? '': '<BR>Сила духа:' + res[6] ) ;
	s+=  (res[7] == '0' ? '': '<BR>Расход маны: ' + res[7] ) ;
	s+=  (res[8] == '0' ? '': '<BR>Задержка: ' + res[8]        + (res[9] == '0' ? '' : ' (ещё ' + res[9] + ")")) ;
	s+=  (res[10] == '0' ? '': '<BR>Использований: ' + res[11] + '/' +res[10]);
	// + (res[11] == '' ? '' : ' (ещё ' + res[11] + ")")) ;
	s+=  (free_cast? '': '<BR>&bull; Приём тратит ход') ;
	s+=  '<br><br>' +  dsc + "\", 300)'" ;
  }
  s+= '>' + (can_use ? '</A>': '');
//if (img=='wis_fire_incenerate10')window.clipboardData.setData('Text',s);
  document.write(s);
}




var atk_zones = 'в голову,в грудь,в живот,в пояс(пах),по ногам'.split(',');
var def_zones = 'головы,груди,живота,пояса,ног'.split(',');
var noattack = '';  // ?
var moves = new Array();
var cur_col = 0;    // текущая колонка
var ranged = false; // дистанционное оружие
var attacks =  1;   // кол. атак
var block_num = 1; // кол. блок
var wait = true, reload = false;

// Установить ход
function DrawDots(is_attack)
{
	var i, j, s = '<table border=0 cellspacing=0 cellpadding=0>';
	for (i=0; i < atk_zones.length; i++)
	{
		s += '<tr><td nowrap>';
		if (is_attack)
		{
			for (j = 0; j < attacks; j++)
			s += '<INPUT TYPE=radio' + noattack + ' NAME=attack'+ j +' value='+(i+1)+
			     ' id="r_' + j + '_' + i +'" onclick="set_move('+j+');" style="background:transparent;border: 1px solid #CEBBAA;">&nbsp;';
			s += '<label id="lfa_' + i + '" for="r_0_' + i + '">Удар ' + atk_zones[i] + '</label>';
		} 
		else 
		{
			var t="";
			var j = i;
			for (k=0; k < block_num; k++) 
			{
				if (j >= atk_zones.length) {j=0;}
				t+=def_zones[j];
				if (block_num > 1 && k!=block_num-1) 
				{
					t+=(k!=block_num-2)?", ":" и ";
				}
				j++;
			}

			s += '<INPUT TYPE=radio NAME=defend value='+(i+1)+
		    ' id="r_' + attacks + '_' + i +'" onclick="set_move('+attacks+');" style="background:transparent;border: 1px solid #CEBBAA;">&nbsp;' +
  		    '<label for="r_' + attacks + '_' + i + '">Блок ' + t + '</label>';
		}
		s += '</tr></tr>\n';
  }
  // if (is_attack )window.clipboardData.setData('Text',s);
  s += '</table>';
  document.writeln(s);
  wait = false;
}

function errmess(s)
{
	document.getElementById("messid").innerHTML=s;
}
function check(ok)
{
	var silent = (ok == 1);
	if (ranged == 1)
	{ // Backward combatibility (uncomplete)
   		for (i=0; i<attacks; i++)
     	if ( eval('f1.attack'+i+'.value') == "" ) { if (!silent) errmess('Удар не выбран.'); return false; }
  	} 
  	else
  	{
   		for (var i=0; i<=attacks; i++)
   		{
			if (moves[i] == null)
			{
				if (!silent) errmess(((i<attacks)? 'Удар':'Блок') + ' не выбран.');
				return false;
			}
		}
  	}
  	document.getElementById("let_attack").disabled = true;
  	form_submit();
  	
}

function set_move(col, n)
{
	moves[col] = n || 1;
  	if (document.getElementById("f1t"))
  	{ // определенва ли табличка
  		var i;
		// Обесцветить текущую колонку
		for (i=0; i<atk_zones.length;i++) document.getElementById("r_" + cur_col + '_' + i).style.backgroundColor = "transparent";
		// Установить точку если надо
		if (n) document.getElementById("r_" + cur_col + '_' + (n - 1)).checked = true;
		// Определить следующую колонку
		cur_col = (col + 1) % (attacks + 1);
		// Подсветить следующую колонку
		if (top.autogo && check(1)) form_submit();
		else for (i=0; i<atk_zones.length;i++)
		{
			//document.getElementById("r_" + cur_col + '_' + i).style.backgroundColor = "#eeeeee";
			document.getElementById("lfa_" + i).htmlFor = "r_" + (cur_col < attacks ? cur_col:0) + '_' + i;
		}
  }
  if (top.autogo && check(1)) form_submit();
}

function set_action () 
{
	var e = event;
	if (wait || reload) return;
	if (typeof attacks == 'undefined') {return;}
	if (((e.keyCode>=49 && e.keyCode<=53) || (e.keyCode>=97 && e.keyCode<=101)) && document.getElementById("f1t")) 
	{
		set_move(cur_col, e.keyCode - ((e.keyCode>=97) ? 96: 48));
		wait = true; 
		setTimeout('wait=false;', 75);
	}
	if (check(1) && cur_col ==attacks && document.getElementById("let_attack") && !document.getElementById("let_attack").disabled) 
	document.getElementById("let_attack").focus();
	return;
}
function form_submit(){
	if (reload) return;
  	reload = true;
  	var id = setTimeout('document.f1.submit();', 150);
}

function setAutoGo(ok)
{
	if (top.autogo == ok) return true;
	top.autogo = ok;
	document.getElementById("let_attack").disabled = !!ok;
  	if (check(1) && ok) form_submit();
	return true;
}
var alert_text = "Используется неэкономный режим работы с Javascript. Это, скорее всего, вызвано переполнением кэша браузера. "+
		"Рекомендуем по окончанию боя очистить кэш Опции/Свойства обозревателя/Общие/Удалить файлы (операция может потребовать много времени) и перезайти в игру";

function DrawButtons(script_alert)
{
  document.write('<input type="checkbox" name="autogo" value="1"  style="background:transparent;border: 1px solid #CEBBAA;" title="Удар при выставлении хода" onclick="setAutoGo(this.checked);"'+(top.autogo?' checked':'')+'>' +
  		'&nbsp;<INPUT TYPE=submit  name="let_attack" id="let_attack"' + (top.autogo ? ' disabled':'')+ ' value="Ударить!!!" onclick="return check();">' +
		(script_alert?' <span title="' + alert_text +'"><b>(<font color=red>!</font>)</b></span>':''));
}

function show_priems_info(req, title, description)
{
    var t = ['hit', 'krit', 'block', 'uvarot', 'hp','all','parry'];
    var text = '';
    text += '<b>' + title;
    text += '</b><br />';
    for (i in req) 
    {
        if (!req[i]) 
        {
            continue;
        }
        text += '<img src="img/priem/' + t[i] + '.gif"  alt="" />';
        text += '&nbsp;' + req[i] + '&nbsp;&nbsp;';
    }
    text += '<br /><br />' + description;
    slot_view(text);
}


function print_priems(can_use, id, priem_name, select_target,req, title, description)
{
	var s = '';
	var rnd = Math.random();
	if (can_use)
	{	
		if (select_target==1)
		{
	  		s += "<A style='cursor: hand' onclick=\"findlogin('</b>Выберите врага для приема <b nobr nowrap>" + title + "</b>', 'battle.php?special=" + priem_name + "&r=" + rnd + "', 'target',  '', '1')\">";
  		} 
  		else 
  		{
			s += '<A HREF="battle.php?special=' + priem_name + '&r=' + rnd + '">';
		}
	}
	s += '<IMG style="' + (can_use? "cursor:hand": "filter:gray();") + '" src="img/priem/misc/' + id+ '.gif" border=0';
	s += " onmouseover=\"show_priems_info("+req+",'"+title+"','"+description+"')\" onmouseout='slot_hide()'>" + (can_use ? '</A>': '');
	document.write(s+"&nbsp;");
 }

