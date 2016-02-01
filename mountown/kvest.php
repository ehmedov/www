<?
$now=time();
$take=(int)$_GET["take"];
$login=$_SESSION['login'];
$ip=$db["remote_ip"];

if ($_GET["take"]) 
{
	if ($db['kwest'] == 0)
	{	
		mysql_query("UPDATE users SET kwest=1 WHERE login='".$login."'");
		$db['kwest']=1;
	}
	else if ($db['kwest'] == 1)
	{
		$col=10;
		$obj = mysql_fetch_array(mysql_query("SELECT count(*) FROM inv WHERE owner='".$login."' AND object_id=84 and object_type='wood'"));
		if ($obj[0]>=$col) 
		{
			mysql_query("DELETE FROM inv WHERE owner='".$login."' AND object_id=84 and object_type='wood'");
			mysql_query("UPDATE users SET kwest=2, naqrada=naqrada+150 WHERE login='".$login."'");
			$db['kwest']=2;
			$db['naqrada']=$db['naqrada']+150;
			history($login,"Проклятый Клад","Вы получили 150 ед. награды",$ip,$login);
		}
		else $msg="<font color=#000000>Не хватает: Аквомалин - ".($col-$obj[0])." штук...</font>";
	}
	else if ($db['kwest'] == 2)
	{
		mysql_query("UPDATE users SET kwest=3 WHERE login='".$login."'");
		$db['kwest']=3;
	}
	else if ($db['kwest'] == 3)
	{
		$col=20;
		$obj = mysql_fetch_array(mysql_query("SELECT count(*) FROM inv WHERE owner='".$login."' AND object_id=85 and object_type='wood'"));
		if ($obj[0]>=$col) 
		{
			mysql_query("DELETE FROM inv WHERE owner='".$login."' AND object_id=85 and object_type='wood'");
			mysql_query("UPDATE users SET kwest=4, naqrada=naqrada+140 WHERE login='".$login."'");
			$db['kwest']=4;
			$db['naqrada']=$db['naqrada']+140;
			history($login,"Проклятый Клад","Вы получили 140 ед. награды",$ip,$login);
		}
		else $msg="<font color=#000000>Не хватает: Жермалин - ".($col-$obj[0])." штук...</font>";
	}
	else if ($db['kwest'] == 4)
	{
		mysql_query("UPDATE users SET kwest=5 WHERE login='".$login."'");
		$db['kwest']=5;
	}
	else if ($db['kwest'] == 5)
	{
		$col=15;
		$obj = mysql_fetch_array(mysql_query("SELECT count(*) FROM inv WHERE owner='".$login."' AND object_id=86 and object_type='wood'"));
		if ($obj[0]>=$col) 
		{
			mysql_query("DELETE FROM inv WHERE owner='".$login."' AND object_id=86 and object_type='wood'");
			mysql_query("UPDATE users SET kwest=6, naqrada=naqrada+350 WHERE login='".$login."'");
			$db['kwest']=6;
			$db['naqrada']=$db['naqrada']+350;
			history($login,"Проклятый Клад","Вы получили 350 ед. награды",$ip,$login);
		}
		else $msg="<font color=#000000>Не хватает: Мисрак - ".($col-$obj[0])." штук...</font>";
	}
	else if ($db['kwest'] == 6)
	{
		mysql_query("UPDATE users SET kwest=7 WHERE login='".$login."'");
		$db['kwest']=7;
	}
	else if ($db['kwest'] == 7)
	{
		$col=25;
		$obj = mysql_fetch_array(mysql_query("SELECT count(*) FROM inv WHERE owner='".$login."' AND object_id=87 and object_type='wood'"));
		if ($obj[0]>=$col) 
		{
			mysql_query("DELETE FROM inv WHERE owner='".$login."' AND object_id=87 and object_type='wood'");
			mysql_query("UPDATE users SET kwest=8, naqrada=naqrada+200 WHERE login='".$login."'");
			$db['kwest']=8;
			$db['naqrada']=$db['naqrada']+200;
			history($login,"Проклятый Клад","Вы получили 200 ед. награды",$ip,$login);
		}
		else $msg="<font color=#000000>Не хватает: Скарап - ".($col-$obj[0])." штук...</font>";
	}
	else if ($db['kwest'] == 8)
	{
		mysql_query("UPDATE users SET kwest=9 WHERE login='".$login."'");
		$db['kwest']=9;
	}
	else if ($db['kwest'] == 9)
	{
		$col=30;
		$obj = mysql_fetch_array(mysql_query("SELECT count(*) FROM inv WHERE owner='".$login."' AND object_id=88 and object_type='wood'"));
		if ($obj[0]>=$col) 
		{
			mysql_query("DELETE FROM inv WHERE owner='".$login."' AND object_id=88 and object_type='wood'");
			mysql_query("UPDATE users SET kwest=10, naqrada=naqrada+300 WHERE login='".$login."'");
			$db['kwest']=10;
			$db['naqrada']=$db['naqrada']+300;
			history($login,"Проклятый Клад","Вы получили 300 ед. награды",$ip,$login);
		}
		else $msg="<font color=#000000>Не хватает: Турмалин - ".($col-$obj[0])." штук...</font>";
	}
	else if ($db['kwest'] == 10)
	{
		mysql_query("UPDATE users SET kwest=11 WHERE login='".$login."'");
		$db['kwest']=11;
	}
	else if ($db['kwest'] == 11)
	{
		$col=30;
		$obj = mysql_fetch_array(mysql_query("SELECT count(*) FROM inv WHERE owner='".$login."' AND object_id=89 and object_type='wood'"));
		if ($obj[0]>=$col) 
		{
			mysql_query("DELETE FROM inv WHERE owner='".$login."' AND object_id=89 and object_type='wood'");
			mysql_query("UPDATE users SET kwest=12, naqrada=naqrada+70 WHERE login='".$login."'");
			$db['kwest']=12;
			$db['naqrada']=$db['naqrada']+70;
			history($login,"Проклятый Клад","Вы получили 70 ед. награды",$ip,$login);
		}
		else $msg="<font color=#000000>Не хватает: Фифорак - ".($col-$obj[0])." штук...</font>";
	}
	else if ($db['kwest'] == 12)
	{
		mysql_query("UPDATE users SET kwest=13 WHERE login='".$login."'");
		$db['kwest']=13;
	}
	else if ($db['kwest'] == 13)
	{
		$col=45;
		$obj = mysql_fetch_array(mysql_query("SELECT count(*) FROM inv WHERE owner='".$login."' AND object_id=94 and object_type='wood'"));
		if ($obj[0]>=$col) 
		{
			mysql_query("DELETE FROM inv WHERE owner='".$login."' AND object_id=94 and object_type='wood'");
			mysql_query("UPDATE users SET kwest=14, naqrada=naqrada+100 WHERE login='".$login."'");
			$db['kwest']=14;
			$db['naqrada']=$db['naqrada']+100;
			history($login,"Проклятый Клад","Вы получили 100 ед. награды",$ip,$login);
		}
		else $msg="<font color=#000000>Не хватает: Медная руда - ".($col-$obj[0])." штук...</font>";
	}
	else if ($db['kwest'] == 14)
	{
		mysql_query("UPDATE users SET kwest=15 WHERE login='".$login."'");
		$db['kwest']=15;
	}
	else if ($db['kwest'] == 15)
	{
		$col=50;
		$obj = mysql_fetch_array(mysql_query("SELECT count(*) FROM inv WHERE owner='".$login."' AND object_id=95 and object_type='wood'"));
		if ($obj[0]>=$col) 
		{
			mysql_query("DELETE FROM inv WHERE owner='".$login."' AND object_id=95 and object_type='wood'");
			mysql_query("UPDATE users SET kwest=16, naqrada=naqrada+100 WHERE login='".$login."'");
			$db['kwest']=16;
			$db['naqrada']=$db['naqrada']+100;
			history($login,"Проклятый Клад","Вы получили 100 ед. награды",$ip,$login);
		}
		else $msg="<font color=#000000>Не хватает: Метеоритный металл - ".($col-$obj[0])." штук...</font>";
	}
	else if ($db['kwest'] == 16)
	{
		mysql_query("UPDATE users SET kwest=17 WHERE login='".$login."'");
		$db['kwest']=17;
	}
	else if ($db['kwest'] == 17)
	{
		$col=50;
		$obj = mysql_fetch_array(mysql_query("SELECT count(*) FROM inv WHERE owner='".$login."' AND object_id=96 and object_type='wood'"));
		if ($obj[0]>=$col) 
		{
			mysql_query("DELETE FROM inv WHERE owner='".$login."' AND object_id=96 and object_type='wood'");
			mysql_query("UPDATE users SET kwest=18, naqrada=naqrada+500 WHERE login='".$login."'");
			$db['kwest']=18;
			$db['naqrada']=$db['naqrada']+500;
			history($login,"Проклятый Клад","Вы получили 500 ед. награды",$ip,$login);
		}
		else $msg="<font color=#000000>Не хватает: Железная руда - ".($col-$obj[0])." штук...</font>";
	}
	else if ($db['kwest'] == 18)
	{
		mysql_query("UPDATE users SET kwest=19 WHERE login='".$login."'");
		$db['kwest']=19;
	}
	else if ($db['kwest'] == 19)
	{
		$col=30;
		$obj = mysql_fetch_array(mysql_query("SELECT count(*) FROM inv WHERE owner='".$login."' AND object_id=97 and object_type='wood'"));
		if ($obj[0]>=$col) 
		{
			mysql_query("DELETE FROM inv WHERE owner='".$login."' AND object_id=97 and object_type='wood'");
			mysql_query("UPDATE users SET kwest=20, naqrada=naqrada+100 WHERE login='".$login."'");
			$db['kwest']=20;
			$db['naqrada']=$db['naqrada']+100;
			history($login,"Проклятый Клад","Вы получили 100 ед. награды",$ip,$login);
		}
		else $msg="<font color=#000000>Не хватает: Металл ярости - ".($col-$obj[0])." штук...</font>";
	}
	else if ($db['kwest'] == 20)
	{
		mysql_query("UPDATE users SET kwest=21 WHERE login='".$login."'");
		$db['kwest']=21;
	}
	else if ($db['kwest'] == 21)
	{
		$col=60;
		$obj = mysql_fetch_array(mysql_query("SELECT count(*) FROM inv WHERE owner='".$login."' AND object_id=98 and object_type='wood'"));
		if ($obj[0]>=$col) 
		{
			mysql_query("DELETE FROM inv WHERE owner='".$login."' AND object_id=98 and object_type='wood'");
			mysql_query("UPDATE users SET kwest=22, naqrada=naqrada+150 WHERE login='".$login."'");
			$db['kwest']=22;
			$db['naqrada']=$db['naqrada']+150;
			history($login,"Проклятый Клад","Вы получили 150 ед. награды",$ip,$login);
		}
		else $msg="<font color=#000000>Не хватает: Металл обмана - ".($col-$obj[0])." штук...</font>";
	}
	else if ($db['kwest'] == 22)
	{
		mysql_query("UPDATE users SET kwest=23 WHERE login='".$login."'");
		$db['kwest']=23;
	}
	else if ($db['kwest'] == 23)
	{
		$col=35;
		$obj = mysql_fetch_array(mysql_query("SELECT count(*) FROM inv WHERE owner='".$login."' AND object_id=99 and object_type='wood'"));
		if ($obj[0]>=$col) 
		{
			mysql_query("DELETE FROM inv WHERE owner='".$login."' AND object_id=99 and object_type='wood'");
			mysql_query("UPDATE users SET kwest=24, naqrada=naqrada+500 WHERE login='".$login."'");
			$db['kwest']=24;
			$db['naqrada']=$db['naqrada']+500;
			history($login,"Проклятый Клад","Вы получили 500 ед. награды",$ip,$login);
		}
		else $msg="<font color=#000000>Не хватает: Металл гибели - ".($col-$obj[0])." штук...</font>";
	}
	else if ($db['kwest'] == 24)
	{
		mysql_query("UPDATE users SET kwest=25 WHERE login='".$login."'");
		$db['kwest']=25;
	}
	else if ($db['kwest'] == 25)
	{
		$col=20;
		$obj = mysql_fetch_array(mysql_query("SELECT count(*) FROM inv WHERE owner='".$login."' AND object_id=100 and object_type='wood'"));
		if ($obj[0]>=$col) 
		{
			mysql_query("DELETE FROM inv WHERE owner='".$login."' AND object_id=100 and object_type='wood'");
			mysql_query("UPDATE users SET kwest=26, naqrada=naqrada+50 WHERE login='".$login."'");
			$db['kwest']=26;
			$db['naqrada']=$db['naqrada']+50;
			history($login,"Проклятый Клад","Вы получили 50 ед. награды",$ip,$login);
		}
		else $msg="<font color=#000000>Не хватает: Металл тверди - ".($col-$obj[0])." штук...</font>";
	}	
	else if ($db['kwest'] == 26)
	{
		mysql_query("UPDATE users SET kwest=27 WHERE login='".$login."'");
		$db['kwest']=27;
	}
	else if ($db['kwest'] == 27)
	{
		$col=45;
		$obj = mysql_fetch_array(mysql_query("SELECT count(*) FROM inv WHERE owner='".$login."' AND object_id=101 and object_type='wood'"));
		if ($obj[0]>=$col) 
		{
			mysql_query("DELETE FROM inv WHERE owner='".$login."' AND object_id=101 and object_type='wood'");
			mysql_query("UPDATE users SET kwest=28, naqrada=naqrada+150 WHERE login='".$login."'");
			$db['kwest']=28;
			$db['naqrada']=$db['naqrada']+150;
			history($login,"Проклятый Клад","Вы получили 150 ед. награды",$ip,$login);
		}
		else $msg="<font color=#000000>Не хватает: Металл жестокости - ".($col-$obj[0])." штук...</font>";
	}
	else if ($db['kwest'] == 28)
	{
		mysql_query("UPDATE users SET kwest=29 WHERE login='".$login."'");
		$db['kwest']=29;
	}
	else if ($db['kwest'] == 29)
	{
		$col=10;
		$obj = mysql_fetch_array(mysql_query("SELECT count(*) FROM inv WHERE owner='".$login."' AND object_id=91 and object_type='wood'"));
		if ($obj[0]>=$col) 
		{
			mysql_query("DELETE FROM inv WHERE owner='".$login."' AND object_id=91 and object_type='wood'");
			mysql_query("UPDATE users SET kwest=30, naqrada=naqrada+1000 WHERE login='".$login."'");
			$db['kwest']=30;
			$db['naqrada']=$db['naqrada']+1000;
			history($login,"Проклятый Клад","Вы получили 1000 ед. награды",$ip,$login);
		}
		else $msg="<font color=#000000>Не хватает: Пожиратель - ".($col-$obj[0])." штук...</font>";
	}
	else if ($db['kwest'] == 30)
	{
		mysql_query("UPDATE users SET kwest=31 WHERE login='".$login."'");
		$db['kwest']=31;
	}
	else if ($db['kwest'] == 31)
	{
		$col=30;
		$obj = mysql_fetch_array(mysql_query("SELECT count(*) FROM inv WHERE owner='".$login."' AND object_id=102 and object_type='wood'"));
		if ($obj[0]>=$col) 
		{
			mysql_query("DELETE FROM inv WHERE owner='".$login."' AND object_id=102 and object_type='wood'");
			mysql_query("UPDATE users SET kwest=32, naqrada=naqrada+250 WHERE login='".$login."'");
			$db['kwest']=32;
			$db['naqrada']=$db['naqrada']+250;
			history($login,"Проклятый Клад","Вы получили 250 ед. награды",$ip,$login);
		}
		else $msg="<font color=#000000>Не хватает: Металл доверия - ".($col-$obj[0])." штук...</font>";
	}	
	else if ($db['kwest'] == 32)
	{
		mysql_query("UPDATE users SET kwest=33 WHERE login='".$login."'");
		$db['kwest']=33;
	}
	else if ($db['kwest'] == 33)
	{
		$col=50;
		$obj = mysql_fetch_array(mysql_query("SELECT count(*) FROM inv WHERE owner='".$login."' AND object_id=103 and object_type='wood'"));
		if ($obj[0]>=$col) 
		{
			mysql_query("DELETE FROM inv WHERE owner='".$login."' AND object_id=103 and object_type='wood'");
			mysql_query("UPDATE users SET kwest=34, naqrada=naqrada+150 WHERE login='".$login."'");
			$db['kwest']=34;
			$db['naqrada']=$db['naqrada']+150;
			history($login,"Проклятый Клад","Вы получили 150 ед. награды",$ip,$login);
		}
		else $msg="<font color=#000000>Не хватает: Металл ловкости - ".($col-$obj[0])." штук...</font>";
	}
	else if ($db['kwest'] == 34)
	{
		mysql_query("UPDATE users SET kwest=35 WHERE login='".$login."'");
		$db['kwest']=35;
	}
	else if ($db['kwest'] == 35)
	{
		$col=10;
		$obj = mysql_fetch_array(mysql_query("SELECT count(*) FROM inv WHERE owner='".$login."' AND object_id=92 and object_type='wood'"));
		if ($obj[0]>=$col) 
		{
			mysql_query("DELETE FROM inv WHERE owner='".$login."' AND object_id=92 and object_type='wood'");
			mysql_query("UPDATE users SET kwest=36, naqrada=naqrada+1000 WHERE login='".$login."'");
			$db['kwest']=36;
			$db['naqrada']=$db['naqrada']+1000;
			history($login,"Проклятый Клад","Вы получили 1000 ед. награды",$ip,$login);
		}
		else $msg="<font color=#000000>Не хватает: Зуб мудрости Уборга - ".($col-$obj[0])." штук...</font>";
	}
	else if ($db['kwest'] == 36)
	{
		mysql_query("UPDATE users SET kwest=37 WHERE login='".$login."'");
		$db['kwest']=37;
	}
	else if ($db['kwest'] == 37)
	{
		$col=50;
		$obj = mysql_fetch_array(mysql_query("SELECT count(*) FROM inv WHERE owner='".$login."' AND object_id=105 and object_type='wood'"));
		if ($obj[0]>=$col) 
		{
			mysql_query("DELETE FROM inv WHERE owner='".$login."' AND object_id=105 and object_type='wood'");
			mysql_query("UPDATE users SET kwest=38, naqrada=naqrada+150 WHERE login='".$login."'");
			$db['kwest']=38;
			$db['naqrada']=$db['naqrada']+150;
			history($login,"Проклятый Клад","Вы получили 150 ед. награды",$ip,$login);
		}
		else $msg="<font color=#000000>Не хватает: Коготь Волфера - ".($col-$obj[0])." штук...</font>";
	}
	else if ($db['kwest'] == 38)
	{
		mysql_query("UPDATE users SET kwest=39 WHERE login='".$login."'");
		$db['kwest']=39;
	}
	else if ($db['kwest'] == 39)
	{
		$col=60;
		$obj = mysql_fetch_array(mysql_query("SELECT count(*) FROM inv WHERE owner='".$login."' AND object_id=106 and object_type='wood'"));
		if ($obj[0]>=$col) 
		{
			mysql_query("DELETE FROM inv WHERE owner='".$login."' AND object_id=106 and object_type='wood'");
			mysql_query("UPDATE users SET kwest=40, naqrada=naqrada+200 WHERE login='".$login."'");
			$db['kwest']=40;
			$db['naqrada']=$db['naqrada']+200;
			history($login,"Проклятый Клад","Вы получили 200 ед. награды",$ip,$login);
		}
		else $msg="<font color=#000000>Не хватает: Жало Харциды - ".($col-$obj[0])." штук...</font>";
	}
	else if ($db['kwest'] == 40)
	{
		mysql_query("UPDATE users SET kwest=41 WHERE login='".$login."'");
		$db['kwest']=41;
	}
	else if ($db['kwest'] == 41)
	{
		$col=50;
		$obj = mysql_fetch_array(mysql_query("SELECT count(*) FROM inv WHERE owner='".$login."' AND object_id=108 and object_type='wood'"));
		if ($obj[0]>=$col) 
		{
			mysql_query("DELETE FROM inv WHERE owner='".$login."' AND object_id=108 and object_type='wood'");
			mysql_query("UPDATE users SET kwest=42, naqrada=naqrada+200 WHERE login='".$login."'");
			$db['kwest']=42;
			$db['naqrada']=$db['naqrada']+200;
			history($login,"Проклятый Клад","Вы получили 200 ед. награды",$ip,$login);
		}
		else $msg="<font color=#000000>Не хватает: Желчь скорпиона - ".($col-$obj[0])." штук...</font>";
	}
	else if ($db['kwest'] == 42)
	{
		mysql_query("UPDATE users SET kwest=43 WHERE login='".$login."'");
		$db['kwest']=43;
	}
	else if ($db['kwest'] == 43)
	{
		$col=45;
		$obj = mysql_fetch_array(mysql_query("SELECT count(*) FROM inv WHERE owner='".$login."' AND object_id=109 and object_type='wood'"));
		if ($obj[0]>=$col) 
		{
			mysql_query("DELETE FROM inv WHERE owner='".$login."' AND object_id=109 and object_type='wood'");
			mysql_query("UPDATE users SET kwest=44, naqrada=naqrada+500 WHERE login='".$login."'");
			$db['kwest']=44;
			$db['naqrada']=$db['naqrada']+500;
			history($login,"Проклятый Клад","Вы получили 500 ед. награды",$ip,$login);
		}
		else $msg="<font color=#000000>Не хватает: Грибы Шизки - ".($col-$obj[0])." штук...</font>";
	}
	else if ($db['kwest'] == 44)
	{
		mysql_query("UPDATE users SET kwest=45 WHERE login='".$login."'");
		$db['kwest']=45;
	}
	else if ($db['kwest'] == 45)
	{
		$col=20;
		$obj = mysql_fetch_array(mysql_query("SELECT count(*) FROM inv WHERE owner='".$login."' AND object_id=110 and object_type='wood'"));
		if ($obj[0]>=$col) 
		{
			mysql_query("DELETE FROM inv WHERE owner='".$login."' AND object_id=110 and object_type='wood'");
			mysql_query("UPDATE users SET kwest=46, naqrada=naqrada+300 WHERE login='".$login."'");
			$db['kwest']=46;
			$db['naqrada']=$db['naqrada']+300;
			history($login,"Проклятый Клад","Вы получили 300 ед. награды",$ip,$login);
		}
		else $msg="<font color=#000000>Не хватает: Заколдованные зубы - ".($col-$obj[0])." штук...</font>";
	}
	else if ($db['kwest'] == 46)
	{
		mysql_query("UPDATE users SET kwest=47 WHERE login='".$login."'");
		$db['kwest']=47;
	}
	else if ($db['kwest'] == 47)
	{
		$col=10;
		$obj = mysql_fetch_array(mysql_query("SELECT count(*) FROM inv WHERE owner='".$login."' AND object_id=107 and object_type='wood'"));
		if ($obj[0]>=$col) 
		{
			mysql_query("DELETE FROM inv WHERE owner='".$login."' AND object_id=107 and object_type='wood'");
			mysql_query("UPDATE users SET kwest=48, naqrada=naqrada+2000 WHERE login='".$login."'");
			$db['kwest']=48;
			$db['naqrada']=$db['naqrada']+2000;
			history($login,"Проклятый Клад","Вы получили 2000 ед. награды",$ip,$login);
		}
		else $msg="<font color=#000000>Не хватает: Слизь Гурральдия Корра - ".($col-$obj[0])." штук...</font>";
	}
	else if ($db['kwest'] == 48)
	{
		mysql_query("UPDATE users SET kwest=49 WHERE login='".$login."'");
		$db['kwest']=49;
	}
	else if ($db['kwest'] == 49)
	{
		$col=30;
		$obj = mysql_fetch_array(mysql_query("SELECT count(*) FROM inv WHERE owner='".$login."' AND object_id=111 and object_type='wood'"));
		if ($obj[0]>=$col) 
		{
			mysql_query("DELETE FROM inv WHERE owner='".$login."' AND object_id=111 and object_type='wood'");
			mysql_query("UPDATE users SET kwest=50, naqrada=naqrada+500 WHERE login='".$login."'");
			$db['kwest']=50;
			$db['naqrada']=$db['naqrada']+500;
			history($login,"Проклятый Клад","Вы получили 500 ед. награды",$ip,$login);
		}
		else $msg="<font color=#000000>Не хватает: Язык Цербера - ".($col-$obj[0])." штук...</font>";
	}
	else if ($db['kwest'] == 50)
	{
		mysql_query("UPDATE users SET kwest=51 WHERE login='".$login."'");
		$db['kwest']=51;
	}
	else if ($db['kwest'] == 51)
	{
		$col=30;
		$obj = mysql_fetch_array(mysql_query("SELECT count(*) FROM inv WHERE owner='".$login."' AND object_id=112 and object_type='wood'"));
		if ($obj[0]>=$col) 
		{
			mysql_query("DELETE FROM inv WHERE owner='".$login."' AND object_id=112 and object_type='wood'");
			mysql_query("UPDATE users SET kwest=52, naqrada=naqrada+300 WHERE login='".$login."'");
			$db['kwest']=52;
			$db['naqrada']=$db['naqrada']+300;
			history($login,"Проклятый Клад","Вы получили 300 ед. награды",$ip,$login);
		}
		else $msg="<font color=#000000>Не хватает: Мертвый ром - ".($col-$obj[0])." штук...</font>";
	}
	else if ($db['kwest'] == 52)
	{
		mysql_query("UPDATE users SET kwest=53 WHERE login='".$login."'");
		$db['kwest']=53;
	}
	else if ($db['kwest'] == 53)
	{
		$col=40;
		$obj = mysql_fetch_array(mysql_query("SELECT count(*) FROM inv WHERE owner='".$login."' AND object_id=113 and object_type='wood'"));
		if ($obj[0]>=$col) 
		{
			mysql_query("DELETE FROM inv WHERE owner='".$login."' AND object_id=113 and object_type='wood'");
			mysql_query("UPDATE users SET kwest=54, naqrada=naqrada+500 WHERE login='".$login."'");
			$db['kwest']=54;
			$db['naqrada']=$db['naqrada']+500;
			history($login,"Проклятый Клад","Вы получили 500 ед. награды",$ip,$login);
		}
		else $msg="<font color=#000000>Не хватает: Сердце болот - ".($col-$obj[0])." штук...</font>";
	}
	else if ($db['kwest'] == 54)
	{
		mysql_query("UPDATE users SET kwest=55 WHERE login='".$login."'");
		$db['kwest']=55;
	}
	else if ($db['kwest'] == 55)
	{
		$col=50;
		$obj = mysql_fetch_array(mysql_query("SELECT count(*) FROM inv WHERE owner='".$login."' AND object_id=99 and object_type='wood'"));
		if ($obj[0]>=$col) 
		{
			mysql_query("DELETE FROM inv WHERE owner='".$login."' AND object_id=99 and object_type='wood'");
			mysql_query("UPDATE users SET kwest=56, naqrada=naqrada+500 WHERE login='".$login."'");
			$db['kwest']=56;
			$db['naqrada']=$db['naqrada']+500;
			history($login,"Проклятый Клад","Вы получили 500 ед. награды",$ip,$login);
		}
		else $msg="<font color=#000000>Не хватает: Металл гибели - ".($col-$obj[0])." штук...</font>";
	}
	else if ($db['kwest'] == 56)
	{
		mysql_query("UPDATE users SET kwest=57 WHERE login='".$login."'");
		$db['kwest']=57;
	}
	else if ($db['kwest'] == 57)
	{
		$col=35;
		$obj = mysql_fetch_array(mysql_query("SELECT count(*) FROM inv WHERE owner='".$login."' AND object_id=96 and object_type='wood'"));
		if ($obj[0]>=$col) 
		{
			mysql_query("DELETE FROM inv WHERE owner='".$login."' AND object_id=96 and object_type='wood'");
			mysql_query("UPDATE users SET kwest=58, naqrada=naqrada+900 WHERE login='".$login."'");
			$db['kwest']=58;
			$db['naqrada']=$db['naqrada']+900;
			history($login,"Проклятый Клад","Вы получили 900 ед. награды",$ip,$login);
		}
		else $msg="<font color=#000000>Не хватает: Железная руда - ".($col-$obj[0])." штук...</font>";
	}
	else if ($db['kwest'] == 58)
	{
		mysql_query("UPDATE users SET kwest=59 WHERE login='".$login."'");
		$db['kwest']=59;
	}
	else if ($db['kwest'] == 59)
	{
		$col=25;
		$obj = mysql_fetch_array(mysql_query("SELECT count(*) FROM inv WHERE owner='".$login."' AND object_id=111 and object_type='wood'"));
		if ($obj[0]>=$col) 
		{
			mysql_query("DELETE FROM inv WHERE owner='".$login."' AND object_id=111 and object_type='wood'");
			mysql_query("UPDATE users SET kwest=60, naqrada=naqrada+1000, exp=exp+1000 WHERE login='".$login."'");
			mysql_query("INSERT INTO inv(owner,object_id,object_type,object_razdel,gift,gift_author) VALUES('".$login."','35','medal','medal','1','WWW.MEYDAN.AZ')");
			$db['kwest']=60;
			$db['naqrada']=$db['naqrada']+1000;
			history($login,"Проклятый Клад","Вы получили 1000 ед. награды",$ip,$login);
		}
		else $msg="<font color=#000000>Не хватает: Язык Цербера - ".($col-$obj[0])." штук...</font>";
	}
	/*else if ($db['kwest'] == 54)
	{
		$msg="Продолжение следует...";
	}*/
}
echo"<table width=100% cellspacing=0 cellpadding=3 border=0><tr><td valign=top>";
	echo"<table width=100% cellspacing=0 cellpadding=3 border=0><tr><td>";
	echo "<center><b style='color:#ff0000'>&nbsp;$msg</b></center>";
	echo "<fieldset style='WIDTH: 100%; border:1px ridge;'>";
	echo "<legend><b>Получить задание</b></legend>
	<table width=100% cellspacing=0 cellpadding=5><tr><td align='justify'>";
	if ($db['kwest'] == 0)
	{
		echo "Приветствую тебя, добрый путник! 
		<br>Как здорово, что ты согласился развлечь старого человека теплой дружеской беседой... 
		Давно ко мне не заходила ни единая душа, да и те странствующие путники не удостоили меня ни единым словом. 
		Я буду рад побеседовать с тобой. <br><br>";
		echo "<center><input class=lbut type=button value='Получить Квест №1!' onclick='window.location.href=\"?take=37\"'></center>"; 
	}
	else if ($db['kwest'] == 1)
	{
		echo "Вам необходимо найти <b>\"Аквомалин\"</b> в количестве 10 штук. 
		Для этого придется обыскать не один труп в <b>\"Проклятый Клад\"</b>. Скатертью дорожка!
		<br>Вы получите: 150 ед. награды.";
		echo "<br><center><input class=lbut type=button value='Получить бонус за Квест №1' onclick='window.location.href=\"?take=38\"'></center>";
	}
	else if ($db['kwest'] == 2) 
	{
		echo "Поздравляю вы выполнили <b>Квест №1</b>, в честь этого вы получили бонус <b>150 ед. награды</b>.";
		echo "<br><center><input class=lbut type=button value='Получить Квест №2' onclick='window.location.href=\"?take=39\"'></center>"; 
	}
	else if ($db['kwest'] == 3)
	{
		echo "Тщеславия ради, Вам следует отыскать <b>\"Жермалин\"</b> в количестве 20 штук. \"Попросите\" их у монстров в <b>\"Проклятый Клад\"</b>. 
		Не надейтесь на помощь...		
		<br>Вы получите: 140 ед. награды.";
		echo "<br><center><input class=lbut type=button value='Получить бонус за Квест №2' onclick='window.location.href=\"?take=40\"'></center>";
	}
	else if ($db['kwest'] == 4) 
	{
		echo "Поздравляю вы выполнили <b>Квест №2</b>, в честь этого вы получили бонус <b>140 ед. награды</b>.";
		echo "<br><center><input class=lbut type=button value='Получить Квест №3' onclick='window.location.href=\"?take=41\"'></center>"; 
	}
	else if ($db['kwest'] == 5)
	{
		echo "Неизвестно зачем, Вы должны хорошенько постараться, чтобы собрать <b>\"Мисрак\"</b> в количестве 15 штук. 
		Придется отнять их у монстров в <b>\"Проклятый Клад\"</b>. 
		Будьте осмотрительны...
		<br>Вы получите: 350 ед. награды.";
		echo "<br><center><input class=lbut type=button value='Получить бонус за Квест №3' onclick='window.location.href=\"?take=42\"'></center>";
	}
	else if ($db['kwest'] == 6) 
	{
		echo "Поздравляю вы выполнили <b>Квест №3</b>, в честь этого вы получили бонус <b>350 ед. награды</b>.";
		echo "<br><center><input class=lbut type=button value='Получить Квест №4' onclick='window.location.href=\"?take=43\"'></center>"; 
	}
	else if ($db['kwest'] == 7)
	{
		echo "Вам следует поднапрячься, и найти <b>\"Скарап\"</b> в количестве 25 штук. 
		Для достижения цели придется поучаствовать в захвате <b>\"Проклятый Клад\"</b>. 
		<br>Вы получите: 200 ед. награды.";
		echo "<br><center><input class=lbut type=button value='Получить бонус за Квест №4' onclick='window.location.href=\"?take=44\"'></center>";
	}
	else if ($db['kwest'] == 8) 
	{
		echo "Поздравляю вы выполнили <b>Квест №4</b>, в честь этого вы получили бонус <b>200 ед. награды</b>.";
		echo "<br><center><input class=lbut type=button value='Получить Квест №5' onclick='window.location.href=\"?take=45\"'></center>"; 
	}
	else if ($db['kwest'] == 9)
	{
		echo "Вопреки всем усмешкам, Вы должны хорошенько постараться, чтобы найти <b>\"Турмалин\"</b> в количестве 30 штук. 
		Только неся смерть монстрам из <b>\"Проклятый Клад\"</b> Вы сможете найти то, что нужно. Ждем с трофеями... 
		<br>Вы получите: 300 ед. награды.";
		echo "<br><center><input class=lbut type=button value='Получить бонус за Квест №5' onclick='window.location.href=\"?take=46\"'></center>";
	}
	else if ($db['kwest'] == 10) 
	{
		echo "Поздравляю вы выполнили <b>Квест №5</b>, в честь этого вы получили бонус <b>200 ед. награды</b>.";
		echo "<br><center><input class=lbut type=button value='Получить Квест №6' onclick='window.location.href=\"?take=47\"'></center>"; 
	}
	else if ($db['kwest'] == 11)
	{
		echo "Чтобы отстоять свою честь и достоинство, Вам следует поискать <b>\"Фифорак\"</b> в количестве 30 штук. 
		Для этого вам потребуется убить и обыскать не один десяток монстров в <b>\"Проклятый Клад\"</b>. И помните, это не прогулка...  
		<br>Вы получите: 70 ед. награды.";
		echo "<br><center><input class=lbut type=button value='Получить бонус за Квест №6' onclick='window.location.href=\"?take=48\"'></center>";
	}
	else if ($db['kwest'] == 12) 
	{
		echo "Поздравляю вы выполнили <b>Квест №6</b>, в честь этого вы получили бонус <b>70 ед. награды</b>.";
		echo "<br><center><input class=lbut type=button value='Получить Квест №7' onclick='window.location.href=\"?take=49\"'></center>"; 
	}
	else if ($db['kwest'] == 13)
	{
		echo "Неизвестно зачем, Вы должны хорошенько постараться, чтобы собрать <b>\"Медная руда\"</b> в количестве 45 штук. 
		Придется отнять их у монстров в <b>\"Проклятый Клад\"</b>. Будьте осмотрительны...  
		<br>Вы получите: 100 ед. награды.";
		echo "<br><center><input class=lbut type=button value='Получить бонус за Квест №7' onclick='window.location.href=\"?take=50\"'></center>";
	}
	else if ($db['kwest'] == 14) 
	{
		echo "Поздравляю вы выполнили <b>Квест №7</b>, в честь этого вы получили бонус <b>100 ед. награды</b>.";
		echo "<br><center><input class=lbut type=button value='Получить Квест №8' onclick='window.location.href=\"?take=51\"'></center>"; 
	}
	else if ($db['kwest'] == 15)
	{
		echo "Чтобы что-то сделать, сначала нужно что-то найти..., Вам необходимо найти <b>\"Метеоритный металл\"</b> в количестве 50 штук. 
		Придется убить не один десяток монстров в <b>\"Проклятый Клад\"</b>. Прощайте...  
		<br>Вы получите: 100 ед. награды.";
		echo "<br><center><input class=lbut type=button value='Получить бонус за Квест №8' onclick='window.location.href=\"?take=52\"'></center>";
	}
	else if ($db['kwest'] == 16) 
	{
		echo "Поздравляю вы выполнили <b>Квест №8</b>, в честь этого вы получили бонус <b>100 ед. награды</b>.";
		echo "<br><center><input class=lbut type=button value='Получить Квест №9' onclick='window.location.href=\"?take=53\"'></center>"; 
	}
	else if ($db['kwest'] == 17)
	{
		echo "Для бесчеловечных экспериментов лекарей города, Вам следует набраться храбрости и доставить <b>\"Железная руда\"</b> в количестве 50 штук. 
		Чтобы отыскать требуемое Вам придется сразиться с множеством монcтров в <b>\"Проклятый Клад\"</b>. Мы верим в ваши силы... 
		<br>Вы получите: 500 ед. награды.";
		echo "<br><center><input class=lbut type=button value='Получить бонус за Квест №9' onclick='window.location.href=\"?take=54\"'></center>";
	}
	else if ($db['kwest'] == 18) 
	{
		echo "Поздравляю вы выполнили <b>Квест №9</b>, в честь этого вы получили бонус <b>500 ед. награды</b>.";
		echo "<br><center><input class=lbut type=button value='Получить Квест №10' onclick='window.location.href=\"?take=55\"'></center>"; 
	}
	else if ($db['kwest'] == 19)
	{
		echo "Чтобы отстоять свою честь и достоинство, Вам следует поискать <b>\"Металл ярости\"</b> в количестве 30 штук. 
		Для этого вам потребуется убить и обыскать не один десяток монстров в <b>\"Проклятый Клад\"</b>. И помните, это не прогулка...
		<br>Вы получите: 100 ед. награды.";
		echo "<br><center><input class=lbut type=button value='Получить бонус за Квест №10' onclick='window.location.href=\"?take=56\"'></center>";
	}
	else if ($db['kwest'] == 20) 
	{
		echo "Поздравляю вы выполнили <b>Квест №10</b>, в честь этого вы получили бонус <b>100 ед. награды</b>.";
		echo "<br><center><input class=lbut type=button value='Получить Квест №11' onclick='window.location.href=\"?take=57\"'></center>"; 
	}
	else if ($db['kwest'] == 21)
	{
		echo "Чтобы что-то сделать, сначала нужно что-то найти..., Вам необходимо найти <b>\"Металл обмана\"</b> в количестве 60 штук. 
		Придется убить не один десяток монстров в <b>\"Проклятый Клад\"</b>. Прощайте...
		<br>Вы получите: 150 ед. награды.";
		echo "<br><center><input class=lbut type=button value='Получить бонус за Квест №11' onclick='window.location.href=\"?take=58\"'></center>";
	}
	else if ($db['kwest'] == 22) 
	{
		echo "Поздравляю вы выполнили <b>Квест №11</b>, в честь этого вы получили бонус <b>150 ед. награды</b>.";
		echo "<br><center><input class=lbut type=button value='Получить Квест №12' onclick='window.location.href=\"?take=59\"'></center>"; 
	}
	else if ($db['kwest'] == 23)
	{
		echo "Неизвестно зачем, Вы должны хорошенько постараться, чтобы собрать <b>\"Металл гибели\"</b> в количестве 35 штук. 
		Придется отнять их у монстров в <b>\"Проклятый Клад\"</b>. Будьте осмотрительны...  
		<br>Вы получите: 500 ед. награды.";
		echo "<br><center><input class=lbut type=button value='Получить бонус за Квест №12' onclick='window.location.href=\"?take=60\"'></center>";
	}
	else if ($db['kwest'] == 24) 
	{
		echo "Поздравляю вы выполнили <b>Квест №12</b>, в честь этого вы получили бонус <b>500 ед. награды</b>.";
		echo "<br><center><input class=lbut type=button value='Получить Квест №13' onclick='window.location.href=\"?take=61\"'></center>"; 
	}
	else if ($db['kwest'] == 25)
	{
		echo "Мы уже видели вашу силу..вас ждет новая тяжка..борьба за лучшое место..не боясь Монстров одалея их силы от вас требуется  доставить 
		<b>\"Металл тверди\"</b> в количестве 20 штук. 
		Доказывайте этим безстрашным Монстрам вашу силу в <b>\"Проклятый Клад\"</b>.
		<br>Вы получите: 50 ед. награды.";
		echo "<br><center><input class=lbut type=button value='Получить бонус за Квест №13' onclick='window.location.href=\"?take=62\"'></center>";
	}
	else if ($db['kwest'] == 26) 
	{
		echo "Поздравляю вы выполнили <b>Квест №13</b>, в честь этого вы получили бонус <b>50 ед. награды</b>.";
		echo "<br><center><input class=lbut type=button value='Получить Квест №14' onclick='window.location.href=\"?take=63\"'></center>"; 
	}
	else if ($db['kwest'] == 27)
	{
		echo "Продолжается Борьба за ценные камни…от вас требуется храбрости  сразиться с монстрами и добыть  
		<b>\"Металл жестокости\"</b> в количестве 45 штук. 
		Не показывайте свой страх..Посторайтесь возвращаться живым :).
		<br>Вы получите: 150 ед. награды.";
		echo "<br><center><input class=lbut type=button value='Получить бонус за Квест №14' onclick='window.location.href=\"?take=64\"'></center>";
	}
	else if ($db['kwest'] == 28) 
	{
		echo "Поздравляю вы выполнили <b>Квест №14</b>, в честь этого вы получили бонус <b>150 ед. награды</b>.";
		echo "<br><center><input class=lbut type=button value='Получить Квест №15' onclick='window.location.href=\"?take=65\"'></center>"; 
	}
	else if ($db['kwest'] == 29)
	{
		echo "Ооо Привет дружище, сколько не виделись стабой, Садись выпей по-чайку, я тот ремесленник,который тебе давал задании,спасибо,что тогда меня не оставил без помощи, помог мне.
		А шасть опять мне тебе задании, говорят что к катакомбах много мне подобных ресурсов... Прошу тебя, иди туда собери для меня:
		<b>\"Пожиратель\"</b> (<font color=red>Редкость</font>) в количестве <b>10 штук</b>. 
		Собери приходи ко мне, в замен тебе награду дам, и новую Заданию!
		<br>Вы получите: <b>1000 ед.</b> награды.";
		echo "<br><center><input class=lbut type=button value='Получить бонус за Квест №15' onclick='window.location.href=\"?take=66\"'></center>";
	}
	else if ($db['kwest'] == 30) 
	{
		echo "Поздравляю вы выполнили <b>Квест №15</b>, в честь этого вы получили бонус <b>1000 ед. награды</b>.";
		echo "<br><center><input class=lbut type=button value='Получить Квест №16' onclick='window.location.href=\"?take=67\"'></center>"; 
	}
	else if ($db['kwest'] == 31)
	{
		echo "Ого кого вижу :) Собрал... Молодчина!, Есть один минус, это моя вина извени, когда я тебе давал заданию, забыл тебе сказать некоторых ресурсов ,
		<br>эхх ..., но думаю ты такой храбрец можешь ещё пойти туда убить всех и собрать мне этих ресурсов:
		<b>\"Металл доверия\"</b> в количестве 30 штук. 
		Иди мне срочно они нужны,буду ждать тебя!
		<br>Вы получите: 250 ед. награды.";
		echo "<br><center><input class=lbut type=button value='Получить бонус за Квест №16' onclick='window.location.href=\"?take=68\"'></center>";
	}
	else if ($db['kwest'] == 32) 
	{
		echo "Поздравляю вы выполнили <b>Квест №16</b>, в честь этого вы получили бонус <b>250 ед. награды</b>.";
		echo "<br><center><input class=lbut type=button value='Получить Квест №17' onclick='window.location.href=\"?take=69\"'></center>"; 
	}
	else if ($db['kwest'] == 33)
	{
		echo "Спасибо Большое Храбрец <b>$login</b>! Я приготовлю заказанную метал, мне в эту сезон пришло много заказов, так что Храбрец, задании будет Много! 
		Я думаю, ты до конца поможешь мне... ты иди отдохни немного, и потом иди собери ещё ресурсов:
		<b>\"Металл ловкости\"</b> в количестве 50 штук. 
		<br>Вы получите: 150 ед. награды.";
		echo "<br><center><input class=lbut type=button value='Получить бонус за Квест №17' onclick='window.location.href=\"?take=70\"'></center>";
	}
	else if ($db['kwest'] == 34) 
	{
		echo "Поздравляю вы выполнили <b>Квест №17</b>, в честь этого вы получили бонус <b>150 ед. награды</b>.";
		echo "<br><center><input class=lbut type=button value='Получить Квест №18' onclick='window.location.href=\"?take=71\"'></center>"; 
	}
	else if ($db['kwest'] == 35)
	{
		echo "Вопреки всем усмешкам, Вы должны хорошенько постараться, чтобы найти <b>\"Зуб мудрости Уборга\"</b> в количестве 10 штук. 
		Только неся смерть монстрам из Проклятый Клад Вы сможете найти то, что нужно. Ждем с трофеями... 
		<br>Вы получите: 1000 ед. награды.";
		echo "<br><center><input class=lbut type=button value='Получить бонус за Квест №18' onclick='window.location.href=\"?take=70\"'></center>";
	}
	else if ($db['kwest'] == 36) 
	{
		echo "Поздравляю вы выполнили <b>Квест №18</b>, в честь этого вы получили бонус <b>1000 ед. награды</b>.";
		echo "<br><center><input class=lbut type=button value='Получить Квест №19' onclick='window.location.href=\"?take=71\"'></center>"; 
	}
	else if ($db['kwest'] == 37)
	{
		echo "Вопреки всем усмешкам, Вы должны хорошенько постараться, чтобы найти <b>\"Коготь Волфера\"</b> в количестве 50 штук. 
		Только неся смерть монстрам из Проклятый Клад Вы сможете найти то, что нужно. Ждем с трофеями... 
		<br>Вы получите: 150 ед. награды.";
		echo "<br><center><input class=lbut type=button value='Получить бонус за Квест №19' onclick='window.location.href=\"?take=70\"'></center>";
	}
	else if ($db['kwest'] == 38) 
	{
		echo "Поздравляю вы выполнили <b>Квест №19</b>, в честь этого вы получили бонус <b>150 ед. награды</b>.";
		echo "<br><center><input class=lbut type=button value='Получить Квест №20' onclick='window.location.href=\"?take=71\"'></center>"; 
	}
	else if ($db['kwest'] == 39)
	{
		echo "Вопреки всем усмешкам, Вы должны хорошенько постараться, чтобы найти <b>\"Жало Харциды\"</b> в количестве 60 штук. 
		Только неся смерть монстрам из Проклятый Клад Вы сможете найти то, что нужно. Ждем с трофеями... 
		<br>Вы получите: 200 ед. награды.";
		echo "<br><center><input class=lbut type=button value='Получить бонус за Квест №20' onclick='window.location.href=\"?take=70\"'></center>";
	}
	else if ($db['kwest'] == 40) 
	{
		echo "Поздравляю вы выполнили <b>Квест №20</b>, в честь этого вы получили бонус <b>200 ед. награды</b>.";
		echo "<br><center><input class=lbut type=button value='Получить Квест №21' onclick='window.location.href=\"?take=71\"'></center>"; 
	}
	else if ($db['kwest'] == 41)
	{
		echo "Спасибо Большое Храбрец <b>$login</b>! 
		Я думаю, ты до конца поможешь мне... ты иди собери ещё ресурсов:
		<b>\"Желчь скорпиона\"</b> в количестве 50 штук. 
		<br>Вы получите: 200 ед. награды.";
		echo "<br><center><input class=lbut type=button value='Получить бонус за Квест №21' onclick='window.location.href=\"?take=72\"'></center>";
	}
	else if ($db['kwest'] == 42) 
	{
		echo "Поздравляю вы выполнили <b>Квест №21</b>, в честь этого вы получили бонус <b>200 ед. награды</b>.";
		echo "<br><center><input class=lbut type=button value='Получить Квест №22' onclick='window.location.href=\"?take=73\"'></center>"; 
	}
	else if ($db['kwest'] == 43)
	{
		echo "Спасибо Большое Храбрец <b>$login</b>! 
		Я думаю, ты до конца поможешь мне... ты иди собери ещё ресурсов:
		<b>\"Грибы Шизки\"</b> в количестве 45 штук. 
		<br>Вы получите: 500 ед. награды.";
		echo "<br><center><input class=lbut type=button value='Получить бонус за Квест №22' onclick='window.location.href=\"?take=72\"'></center>";
	}
	else if ($db['kwest'] == 44) 
	{
		echo "Поздравляю вы выполнили <b>Квест №22</b>, в честь этого вы получили бонус <b>500 ед. награды</b>.";
		echo "<br><center><input class=lbut type=button value='Получить Квест №23' onclick='window.location.href=\"?take=73\"'></center>"; 
	}
	else if ($db['kwest'] == 45)
	{
		echo "Вам необходимо найти <b>\"Заколдованные зубы\"</b> в количестве 20 штук. 
		Для этого придется обыскать не один труп в <b>\"Проклятый Клад\"</b>. Скатертью дорожка!
		<br>Вы получите: 300 ед. награды.";
		echo "<br><center><input class=lbut type=button value='Получить бонус за Квест №23' onclick='window.location.href=\"?take=38\"'></center>";
	}
	else if ($db['kwest'] == 46) 
	{
		echo "Поздравляю вы выполнили <b>Квест №23</b>, в честь этого вы получили бонус <b>300 ед. награды</b>.";
		echo "<br><center><input class=lbut type=button value='Получить Квест №24' onclick='window.location.href=\"?take=73\"'></center>"; 
	}
	else if ($db['kwest'] == 47)
	{
		echo "Вопреки всем усмешкам, Вы должны хорошенько постараться, чтобы найти <b>\"Слизь Гурральдия Корра\"</b> в количестве 10 штук. 
		Только неся смерть монстрам из <b>\"Проклятый Клад\"</b> Вы сможете найти то, что нужно. Ждем с трофеями... 
		<br>Вы получите: 2000 ед. награды.";
		echo "<br><center><input class=lbut type=button value='Получить бонус за Квест №24' onclick='window.location.href=\"?take=46\"'></center>";
	}
	else if ($db['kwest'] == 48) 
	{
		echo "Поздравляю вы выполнили <b>Квест №24</b>, в честь этого вы получили бонус <b>2000 ед. награды</b>.";
		echo "<br><center><input class=lbut type=button value='Получить Квест №25' onclick='window.location.href=\"?take=73\"'></center>"; 
	}
	else if ($db['kwest'] == 49)
	{
		echo "Чтобы что-то сделать, сначала нужно что-то найти..., Вам необходимо найти <b>\"Язык Цербера\"</b> в количестве 30 штук. 
		Придется убить не один десяток монстров в <b>\"Проклятый Клад\"</b>. Прощайте...
		<br>Вы получите: 500 ед. награды.";
		echo "<br><center><input class=lbut type=button value='Получить бонус за Квест №25' onclick='window.location.href=\"?take=58\"'></center>";
	}
	else if ($db['kwest'] == 50) 
	{
		echo "Поздравляю вы выполнили <b>Квест №25</b>, в честь этого вы получили бонус <b>500 ед. награды</b>.";
		echo "<br><center><input class=lbut type=button value='Получить Квест №26' onclick='window.location.href=\"?take=73\"'></center>"; 
	}
	else if ($db['kwest'] == 51)
	{
		echo "Спасибо Большое Храбрец <b>$login</b>! 
		Я думаю, ты до конца поможешь мне... ты иди собери ещё ресурсов:
		<b>\"Мертвый ром\"</b> в количестве 30 штук. 
		<br>Вы получите: 300 ед. награды.";
		echo "<br><center><input class=lbut type=button value='Получить бонус за Квест №26' onclick='window.location.href=\"?take=72\"'></center>";
	}
	else if ($db['kwest'] == 52) 
	{
		echo "Поздравляю вы выполнили <b>Квест №26</b>, в честь этого вы получили бонус <b>300 ед. награды</b>.";
		echo "<br><center><input class=lbut type=button value='Получить Квест №27' onclick='window.location.href=\"?take=73\"'></center>"; 
	}
	else if ($db['kwest'] == 53)
	{
		echo "Вопреки всем усмешкам, Вы должны хорошенько постараться, чтобы найти <b>\"Сердце болот\"</b> в количестве 40 штук. 
		Только неся смерть монстрам из Проклятый Клад Вы сможете найти то, что нужно. Ждем с трофеями... 
		<br>Вы получите: 500 ед. награды.";
		echo "<br><center><input class=lbut type=button value='Получить бонус за Квест №27' onclick='window.location.href=\"?take=70\"'></center>";
	}
	else if ($db['kwest'] == 54) 
	{
		echo "Поздравляю вы выполнили <b>Квест №27</b>, в честь этого вы получили бонус <b>500 ед. награды</b>.";
		echo "<br><center><input class=lbut type=button value='Получить Квест №28' onclick='window.location.href=\"?take=73\"'></center>"; 
	}
	else if ($db['kwest'] == 55)
	{
		echo "Вам необходимо найти <b>\"Металл гибели\"</b> в количестве 50 штук. 
		Для этого придется обыскать не один труп в <b>\"Проклятый Клад\"</b>. Скатертью дорожка!
		<br>Вы получите: 500 ед. награды.";
		echo "<br><center><input class=lbut type=button value='Получить бонус за Квест №28' onclick='window.location.href=\"?take=38\"'></center>";
	}
	else if ($db['kwest'] == 56) 
	{
		echo "Поздравляю вы выполнили <b>Квест №28</b>, в честь этого вы получили бонус <b>500 ед. награды</b>.";
		echo "<br><center><input class=lbut type=button value='Получить Квест №29' onclick='window.location.href=\"?take=73\"'></center>"; 
	}
	else if ($db['kwest'] == 57)
	{
		echo "Ого кого вижу :) Собрал... Молодчина!, Есть один минус, это моя вина извени, когда я тебе давал заданию, забыл тебе сказать некоторых ресурсов ,
		<br>эхх ..., но думаю ты такой храбрец можешь ещё пойти туда убить всех и собрать мне этих ресурсов:
		<b>\"Железная руда\"</b> в количестве 35 штук. 
		Иди мне срочно они нужны,буду ждать тебя!
		<br>Вы получите: 900 ед. награды.";
		echo "<br><center><input class=lbut type=button value='Получить бонус за Квест №29' onclick='window.location.href=\"?take=68\"'></center>";
	}
	else if ($db['kwest'] == 58)
	{
		echo "Поздравляю вы выполнили <b>Квест №29</b>, в честь этого вы получили бонус <b>900 ед. награды</b>.";
		echo "<br><center><input class=lbut type=button value='Получить Квест №30' onclick='window.location.href=\"?take=73\"'></center>"; 
	}
	else if ($db['kwest'] == 59)
	{
		echo "Спасибо Большое Храбрец <b>$login</b>! 
		Я думаю, ты до конца поможешь мне... ты иди собери ещё ресурсов:
		<b>\"Язык Цербера\"</b> в количестве 25 штук. 
		<br>Вы получите: 1000 ед. награды + 1000 Опыт";
		echo "<br><center><input class=lbut type=button value='Получить бонус за Квест №30' onclick='window.location.href=\"?take=72\"'></center>";
	}
	else if ($db['kwest'] == 60)
	{
		echo "Поздравляю вы выполнили <b>Квест №30</b>, в честь этого вы получили бонус <b>1000 ед. награды + 1000 Опыт и Медал Мастер лабиринта 3-го уровня</b>.";
		echo "<br><center><b style='color:red'>Поздравляю вы выполнили все квесты в етом подземелье...</b></center>"; 
	}
	//-------------------------------------------------------------------------------
	echo"</td></tr></table>
	</fieldset>";
	echo"</td></tr></table>";
	if ($_GET["buy"]=="ups")
	{
		if (25-$db["add_ups"]>0)
		{	
			$price_stat=5000+500*$db["add_ups"];
			if ($db["naqrada"]>=$price_stat)
			{
				mysql_query("UPDATE users SET ups=ups+1,add_ups=add_ups+1, naqrada=naqrada-$price_stat WHERE login='".$login."'");
				history($login,'Получил Способность',"За $price_stat Ед.",$db['remote_ip'],"Задания");
				$db["naqrada"]=$db["naqrada"]-$price_stat;
				$db["add_ups"]=$db["add_ups"]+1;
				echo "<font color=red>Вы удачно обменяли $price_stat Ед. на 1 Способность</font>";
			}
			else echo "<font color=red>У вас недостаточно средств!</font>";
		}
	}
	else if ($_GET["buy"]=="umenie")
	{
		if (8-$db["add_umenie"]>0)
		{	
			$price_umenie=5000+500*$db["add_umenie"];
			if ($db["naqrada"]>=$price_umenie)
			{
				mysql_query("UPDATE users SET umenie=umenie+1,add_umenie=add_umenie+1, naqrada=naqrada-$price_umenie WHERE login='".$login."'");
				history($login,'Получил Умение',"За $price_umenie Ед.",$db['remote_ip'],"Задания");
				$db["naqrada"]=$db["naqrada"]-$price_umenie;
				$db["add_umenie"]=$db["add_umenie"]+1;
				echo "<font color=red>Вы удачно обменяли $price_umenie Ед. на 1 Умение</font>";
			}
			else echo "<font color=red>У вас недостаточно средств!</font>";
		}
	}
	else if ($_GET["buy"]=="money")
	{
		if ($db["naqrada"]>=100)
		{
			mysql_query("UPDATE users SET money=money+1000,naqrada=naqrada-100 WHERE login='".$login."'");
			history($login,'Получил Зл.',"1000.00 Зл. за 100 Ед.",$db['remote_ip'],"Задания");
			$db["naqrada"]=$db["naqrada"]-100;
			echo "<font color=red>Вы удачно обменяли 100 Ед. на 1000.00 Зл.</font>";
		}
		else echo "<font color=red>У вас недостаточно средств!</font>";
	}
			
	if (25-$db["add_ups"]>0)
	{	
		$count_stats=25-$db["add_ups"];
		$price_stat=5000+500*$db["add_ups"];
	}
	if (8-$db["add_umenie"]>0)
	{	
		$count_umenie=8-$db["add_umenie"];
		$price_umenie=5000+500*$db["add_umenie"];
	}
	if ($count_stats<=0){$count_stats=0;$price_stat=0;}
	if ($count_umenie<=0){$count_umenie=0;$price_umenie=0;}

	?>
	<BR>
	<FIELDSET style='WIDTH: 100%; border:1px ridge;'><LEGEND> Награда: <B><?=$db["naqrada"]?> Ед.</B> </LEGEND>
	<TABLE>
	<TR><TD>Способность (еще <?=$count_stats;?>)</TD><TD style='padding-left: 10'>за <?=$price_stat?> Ед.</TD><TD style='padding-left: 10'>
	<INPUT type='button' value='Купить' onclick="if (confirm('Купить: Способность?\n\nКупив способность, Вы сможете увеличить характеристики персонажа.\nНапример, можно увеличить силу.')) {location='?buy=ups'}"></TD></TR>

	<TR><TD>Умение (еще <?=$count_umenie;?>)</TD><TD style='padding-left: 10'>за <?=$price_umenie?> Ед.</TD><TD style='padding-left: 10'>
	<INPUT type='button' value='Купить' onclick="if (confirm('Купить: Умение?\n\nУмение даёт возможность почуствовать себя мастером меча, топора, магии и т.п.')) {location='?buy=umenie'}"></TD></TR>

	<TR><TD>Деньги (1000.00 Зл.)</TD><TD style='padding-left: 10'>за 100 Ед.</TD><TD style='padding-left: 10'>
	<INPUT type='button' value='Купить' onclick="if (confirm('Купить: Деньги (100 Зл.)?\n\nНаграду можно получить полновесными кредитами.')) {location='?buy=money'}"></TD></TR>
	</TABLE>
	</FIELDSET>
	<BR>
	<?
	echo "</td>
	<td valign=top align=right width=300>
		<input type=button value='Вернуться' onclick=\"document.location='main.php?act=go&level=crypt_go'\">
		<input type=button value='Обновить' onClick=\"location.href='?act=none'\"><br>
	</td>
	</tr></table>";
?>