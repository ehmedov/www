var rnd = Math.random();
//-- ����� ����������
var delay = 8;		// ������ 18���. ���������� HP �� 1%
var redHP = 0.33;	// ������ 30% ������� ����
var yellowHP = 0.66;// ������ 60% ������ ����, ����� �������
var TimerOn = -1;	// id �������
var tkHP, maxHP;
var speed=100;
var mspeed=100;

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
	le=260;
	var sz1 = Math.round((le/maxHP)*tkHP);
	var sz2 = le - sz1;
	if (document.all("HP")) {
		document.HP1.width=sz1;
		document.HP2.width=sz2;
		document.HP2.display=sz2?"":"none";
		if (tkHP/maxHP < redHP) { document.HP1.src='img/icon/red.jpg'; }
		else {
			if (tkHP/maxHP < yellowHP) { document.HP1.src='img/icon/yellow.jpg'; }
			else { document.HP1.src='img/icon/green.jpg'; }
		}
		var s = document.all("HP").innerHTML;
		document.all("HP").innerHTML = Math.round(tkHP)+"/"+maxHP;
	}
	tkHP = (tkHP+(maxHP/100)*speed/1000);
	if (TimerOn!=-1) {TimerOn=setTimeout('setHPlocal()', delay*100)};
}

var Mdelay = 8;
var MTimerOn = -1;	// id �������
var tkMana, maxMana;

function setMana(value, max, newspeed) {
	tkMana=value; maxMana=max;
	if (MTimerOn>=0) { clearTimeout(MTimerOn); MTimerOn=-1; }
	if (newspeed < 1) TimerOn=-1;
	mspeed=newspeed;
	setManalocal();
}

function setManalocal() {
	if (maxMana==0) return(0);
	if (tkMana>maxMana) { tkMana=maxMana; MTimerOn=-1; } else {MTimerOn=0;}
	var le=Math.round(tkMana)+"/"+maxMana;
	le=260;
	var sz1 = Math.round( ( le / maxMana ) * tkMana);
	var sz2 = le - sz1;
	if (document.all("Mana")) {
		document.Mana1.width=sz1;
		document.Mana2.width=sz2;
		document.Mana2.display=sz2?"":"none";
		document.Mana1.src='img/icon/blue.jpg';
		var s = document.all("Mana").innerHTML;
		document.all("Mana").innerHTML = s.substring(0, s.lastIndexOf(':')+1) + Math.round(tkMana)+"/"+maxMana;
	}
	tkMana = (tkMana+(maxMana/1000)*mspeed/100);
	if (MTimerOn!=-1) {MTimerOn=setTimeout('setManalocal()', Mdelay*100);};
}
