<?
$now=time();
$take=(int)$_GET["take"];

$login=$_SESSION['login'];
$ip=$db[remote_ip];
	echo"<table width=100% cellspacing=0 cellpadding=3 border=0><tr><td>";
	if ($take==1) 
	{
		if ($db['kwest'] != 0) $msg="Ошибка, не пытайтесь взломать игру :)!";
		else {mysql_query("UPDATE users SET kwest=1 WHERE login='".$login."'");}
	}

	if ($take==2)
	{
		if ($db['kwest'] != 1) $msg="Ошибка, не пытайтесь взломать игру :)!";
		else 
		{
			$alexandrit = mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_id=11 and object_type='wood'");
			if (mysql_num_rows ($alexandrit)) 
			{
				mysql_query("DELETE FROM inv WHERE owner='".$login."' AND object_id=11 and object_type='wood'");
				mysql_query("UPDATE users SET kwest=2, money=money+5 WHERE login='".$login."'");
				history($login,"Подземелья Призраков","Вы получили 5 Зл.",$ip,$login);
			}
			else $msg="У вас нет вещи \"Александрит\"!";
		}
	}

	if ($take==3)
	{
		if ($db['kwest'] != 2) $msg="Ошибка, не пытайтесь взломать игру :)!";
		else
		{
			mysql_query("UPDATE users SET kwest=3 WHERE login='".$login."'");
		}
	}

	if ($take==4)
	{
		if ($db['kwest'] != 3) $msg="Ошибка, не пытайтесь взломать игру :)!";
		else
		{
			$alexandrit = mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_id=13 and object_type='wood'");
			$almaz = mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_id=12 and object_type='wood'");
			if (mysql_num_rows ($alexandrit) && mysql_num_rows ($almaz)) 
			{
				mysql_query("DELETE FROM inv WHERE owner='".$login."' AND object_id IN (12,13) and object_type='wood'");
				mysql_query("UPDATE users SET kwest=4, money=money+50 WHERE login='".$login."'");
				history($login,"Подземелья Призраков","Вы получили 50 Зл.",$ip,$login);
			}
			else $msg="У вас нет вещи \"Алмаз\" и  \"Амазонит\"!";
		}
	}
	
	if ($take==5)
	{
		if ($db['kwest'] != 4) $msg="Ошибка, не пытайтесь взломать игру :)!";
		else
		{
			mysql_query("UPDATE users SET kwest=5 WHERE login='".$login."'");
			mysql_query("DELETE FROM labirint_bots WHERE user_id='".$login."' and type='bot'");
		}
	}


	if ($take==6)
	{
		if ($db['kwest'] != 5) $msg="Ошибка, не пытайтесь взломать игру :)!";
		else 
		{
			$opal = mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_id=16 and object_type='wood'");
			$rubin = mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_id=17 and object_type='wood'");
			$sun_kamen = mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_id=19 and object_type='wood'");
			if (mysql_num_rows ($opal) && mysql_num_rows ($rubin)&& mysql_num_rows ($sun_kamen)) 
			{
				mysql_query("DELETE FROM inv WHERE owner='".$login."' AND object_id IN (16,17,19) and object_type='wood'");
				mysql_query("UPDATE users SET kwest=6 WHERE login='".$login."'");
				$ItTake = "Кольцо Уничтожения";
				$buyitem = mysql_fetch_array(mysql_query("SELECT * FROM paltar WHERE name='".$ItTake."'"));
				if ($buyitem)
				{
					mysql_query("INSERT INTO inv(owner,object_id,object_type,object_razdel,wear,iznos,iznos_max,noremont) VALUES ('".$login."','".$buyitem['id']."','".$buyitem['object']."','obj','0','0','".$buyitem['iznos_max']."','".$buyitem['noremont']."')");
					$msg="Вы получили <u>\"Кольцо Уничтожения\"</u><br>";
					history($login,"Подземелья Призраков","Кольцо Уничтожения",$ip,$login);
				}
			}
			else $msg="У вас нет вещи \"Рубин\", \"Солнечный камень\" и  \"Опал\"!";
		}
	}

	if ($take==7)
	{
		if ($db['kwest'] != 6) $msg="Ошибка, не пытайтесь взломать игру :)!";
		else
		{
			mysql_query("UPDATE users SET kwest=7 WHERE login='".$login."'");
			mysql_query("DELETE FROM labirint_bots WHERE user_id='".$login."' and type='bot'");
		}
	}

	if ($take==8)
	{
		if ($db['kwest'] != 7) $msg="Ошибка, не пытайтесь взломать игру :)!";
		else 
		{
			$zmei_plod = mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_id=21 and object_type='wood'");
			$lezvie = mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_id=22 and object_type='wood'");
			$rukoad = mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_id=20 and object_type='wood'");
			if (mysql_num_rows ($zmei_plod) && mysql_num_rows ($lezvie)&& mysql_num_rows ($rukoad)) 
			{
				mysql_query("DELETE FROM inv WHERE owner='".$login."' AND object_id IN (20,21,22) and object_type='wood'");
				mysql_query("UPDATE users SET kwest=8,umenie=umenie+1,money=money+100 WHERE login='".$login."'");
				$msg="Вы получили <b>100 Зл, + 1 к умениям</b><br>";
				history($login,"Подземелья Призраков","Вы получили 100 Зл, + 1 к умениям",$ip,$login);
			}
			else $msg="У вас нет вещи \"Рукоядь\", \"Змеиный плод\" и  \"Лезвие\"!";
		}
	}

	if ($take==9)
	{
		if ($db['kwest'] != 8) $msg="Ошибка, не пытайтесь взломать игру :)!";
		else 
		{
			mysql_query("UPDATE users SET kwest=9 WHERE login='".$login."'");
			mysql_query("DELETE FROM labirint_bots WHERE user_id='".$login."' and type='bot'");
		}
	}

	if ($take==10)
	{
		$pirit = mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_id=15 and object_type='wood'");
		$sapfir = mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_id=18 and object_type='wood'");
		if (mysql_num_rows ($pirit) && mysql_num_rows ($sapfir)) 
		{
			mysql_query("DELETE FROM inv WHERE owner='".$login."' AND object_id IN (15,18) and object_type='wood'");
			mysql_query("UPDATE users SET kwest=10, money=money+250 WHERE login='".$login."'");
			mysql_query("INSERT INTO inv(owner,object_id,object_type,object_razdel,wear,iznos,iznos_max) VALUES ('".$login."','9','scroll','magic','0','0','5')");
			$msg="Вы получили <b>250 Зл.</b> и Элексир <b>Живая вода - Полное восстановление</b><br>";
			history($login,"Подземелья Призраков",$msg,$ip,$login);
		}
		else $msg="У вас нет вещи \"Сапфир\" и  \"Пирит\"!";
	}

	if ($take==11)
	{
		if ($db['kwest'] != 10) $msg="Ошибка, не пытайтесь взломать игру :)!";
		else 
		{
			mysql_query("UPDATE users SET kwest=11 WHERE login='".$login."'");
			mysql_query("DELETE FROM labirint_bots WHERE user_id='".$login."' and type='bot'");
		}
	}

	if ($take==12)
	{
		if ($db['kwest'] != 11) $msg="Ошибка, не пытайтесь взломать игру :)!";
		else 
		{
			$plash = mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_id=23 and object_type='wood'");
			if (mysql_num_rows ($plash)) 
			{
				mysql_query("DELETE FROM inv WHERE owner='".$login."' AND object_id=23 and object_type='wood'");
				mysql_query("UPDATE users SET kwest=12 WHERE login='".$login."'");
				$ItTake = "Доспехи Гладиатора";
				$buyitem = mysql_fetch_array(mysql_query("SELECT * FROM paltar WHERE name='".$ItTake."'"));
				if ($buyitem)
				{
					mysql_query("INSERT INTO inv(owner,object_id,object_type,object_razdel,wear,iznos,iznos_max,noremont) VALUES ('".$login."','".$buyitem['id']."','".$buyitem['object']."','obj','0','0','10','1')");
					$msg="Вы получили <u>\"$ItTake\"</u><br>";
					history($login,"Подземелья Призраков",$msg,$ip,$login);
				}
			}
			else $msg="У вас нет вещи \"Доспехи Гладиатора\"!";
		}
	}

	if ($take==13)
	{
		if ($db['kwest'] != 12) $msg="Ошибка, не пытайтесь взломать игру :)!";
		else 
		{
			mysql_query("UPDATE users SET kwest=13 WHERE login='".$login."'");
			mysql_query("DELETE FROM labirint_bots WHERE user_id='".$login."' and type='bot'");
		}
	}

	if ($take==14)
	{
		if ($db['kwest'] != 13) $msg="Ошибка, не пытайтесь взломать игру :)!";
		else 
		{
			$sol = mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_id=24 and object_type='wood'");
			if (mysql_num_rows ($sol)) 
			{
				mysql_query("DELETE FROM inv WHERE owner='".$login."' AND object_id=24 and object_type='wood'");
				mysql_query("UPDATE users SET kwest=14 WHERE login='".$login."'");
				
				$ItTake = "Копье боли";
				$buyitem = mysql_fetch_array(mysql_query("SELECT * FROM paltar WHERE name='".$ItTake."'"));
				if ($buyitem)
				{
					mysql_query("INSERT INTO inv(owner,object_id,object_type,object_razdel,wear,iznos,iznos_max,noremont) VALUES ('".$login."','".$buyitem['id']."','".$buyitem['object']."','obj','0','0','5','1')");
					$msg="Вы получили <u>\"$ItTake\"</u><br>";
					history($login,"Подземелья Призраков",$msg,$ip,$login);
				}
			}
			else $msg="У вас нет вещи \"СОЛЬ\"!";
		}
	}
	
	if ($take==15)
	{
		if ($db['kwest'] != 14) $msg="Ошибка, не пытайтесь взломать игру :)!";
		else 
		{
			mysql_query("UPDATE users SET kwest=15 WHERE login='".$login."'");
			mysql_query("DELETE FROM labirint_bots WHERE user_id='".$login."' and type='bot'");
		}
	}
	if ($take==16)
	{
		if ($db['kwest'] != 15) $msg="Ошибка, не пытайтесь взломать игру :)!";
		else 
		{
			$kill_bots = mysql_query("SELECT * FROM labirint_bots WHERE user_id='".$login."' AND type='bot'");
			$count_kill_bots=mysql_num_rows ($kill_bots);
			if ($count_kill_bots>=25) 
			{
				mysql_query("UPDATE users SET kwest=16 WHERE login='".$login."'");
				
				$ItTake = "Рубаха Золотого Дракона";
				$buyitem = mysql_fetch_array(mysql_query("SELECT * FROM paltar WHERE name='".$ItTake."'"));
				if ($buyitem)
				{
					mysql_query("INSERT INTO inv(owner,object_id,object_type,object_razdel,wear,iznos,iznos_max,noremont) VALUES ('".$login."','".$buyitem['id']."','".$buyitem['object']."','obj','0','0','5','1')");
					$msg="Вы получили <u>\"$ItTake\"</u><br>";
					history($login,"Подземелья Призраков",$msg,$ip,$login);
				}
			}
			else $msg="Не хватает ".(25-$count_kill_bots)." ботов!";
		}
	}
	
	if ($take==17)
	{
		if ($db['kwest'] != 16) $msg="Ошибка, не пытайтесь взломать игру :)!";
		else 
		{
			mysql_query("UPDATE users SET kwest=17 WHERE login='".$login."'");
			mysql_query("DELETE FROM labirint_bots WHERE user_id='".$login."' and type='bot'");
		}
	}
	if ($take==18)
	{
		if ($db['kwest'] != 17) $msg="Ошибка, не пытайтесь взломать игру :)!";
		else 
		{
			$noj = mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_id=25 and object_type='wood'");
			if (mysql_num_rows ($noj)) 
			{
				mysql_query("DELETE FROM inv WHERE owner='".$login."' AND object_id=25 and object_type='wood'");
				mysql_query("UPDATE users SET kwest=18 WHERE login='".$login."'");				
				$ItTake = "Плащ Золотого Дракона";
				$buyitem = mysql_fetch_array(mysql_query("SELECT * FROM paltar WHERE name='".$ItTake."'"));
				if ($buyitem)
				{
					mysql_query("INSERT INTO inv(owner,object_id,object_type,object_razdel,wear,iznos,iznos_max,noremont) VALUES ('".$login."','".$buyitem['id']."','".$buyitem['object']."','obj','0','0','5','1')");
					$msg="Вы получили <u>\"$ItTake\"</u><br>";
					history($login,"Подземелья Призраков",$msg,$ip,$login);
				}

			}
			else $msg="У вас нет вещи \"Кровавый мясник\"!";
		}
	}
	if ($take==19)
	{
		if ($db['kwest'] != 18) $msg="Ошибка, не пытайтесь взломать игру :)!";
		else 
		{
			mysql_query("UPDATE users SET kwest=19 WHERE login='".$login."'");
			mysql_query("DELETE FROM labirint_bots WHERE user_id='".$login."' and type='bot'");
		}
	}
	if ($take==20)
	{
		if ($db['kwest'] != 19) $msg="Ошибка, не пытайтесь взломать игру :)!";
		else
		{
			$bread = mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_id=26 and object_type='wood'");
			$meat = mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_id=27 and object_type='wood'");
			if (mysql_num_rows ($bread) && mysql_num_rows ($meat)) 
			{
				mysql_query("DELETE FROM inv WHERE owner='".$login."' AND object_id IN (26,27) and object_type='wood'");
				mysql_query("UPDATE users SET kwest=20 WHERE login='".$login."'");
				$ItTake = "Заточка оружия +3";
				$buyitem = mysql_fetch_array(mysql_query("SELECT * FROM scroll WHERE name='".$ItTake."'"));
				if ($buyitem)
				{
					mysql_query("INSERT INTO inv(owner,object_id,object_type,object_razdel,wear,iznos,iznos_max) VALUES ('".$login."','".$buyitem['id']."','scroll','magic','0','0','".$buyitem['iznos_max']."')");
					$msg="Вы получили <u>\"$ItTake\"</u><br>";
					history($login,"Подземелья Призраков",$msg,$ip,$login);
				}
			}
			else $msg="У вас нет вещи \"Мясо\" и  \"Хлеб\"!";
		}
	}
	if ($take==21)
	{
		if ($db['kwest'] != 20) $msg="Ошибка, не пытайтесь взломать игру :)!";
		else 
		{
			mysql_query("UPDATE users SET kwest=21 WHERE login='".$login."'");
			mysql_query("DELETE FROM labirint_bots WHERE user_id='".$login."' and type='bot'");
		}
	}
	if ($take==22)
	{
		if ($db['kwest'] != 21) $msg="Ошибка, не пытайтесь взломать игру :)!";
		else
		{
			$kill_bots = mysql_query("SELECT * FROM labirint_bots WHERE user_id='".$login."' AND type='bot' and bots IN (98,97,95,93,91)");
			$count_kill_bots=mysql_num_rows ($kill_bots);
			if ($count_kill_bots==5) 
			{
				mysql_query("UPDATE users SET kwest=22, money=money+300 WHERE login='".$login."'");
				history($login,"Подземелья Призраков","Вы получили 300 Зл.",$ip,$login);
			}
			else $msg="Задания еще не выполнена! Не хватает ".(5-$count_kill_bots)." ботов!";
		}
	}
	if ($take==23)
	{
		if ($db['kwest'] != 22) $msg="Ошибка, не пытайтесь взломать игру :)!";
		else 
		{
			mysql_query("UPDATE users SET kwest=23 WHERE login='".$login."'");
			mysql_query("DELETE FROM labirint_bots WHERE user_id='".$login."' and type='bot'");
		}
	}
	if ($take==24)
	{
		if ($db['kwest'] != 23) $msg="Ошибка, не пытайтесь взломать игру :)!";
		else 
		{
			$vozdux = mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_id=29 and object_type='wood'");
			$oqon = mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_id=30 and object_type='wood'");
			$voda = mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_id=31 and object_type='wood'");
			$zemlya = mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_id=32 and object_type='wood'");
			if (mysql_num_rows($vozdux) && mysql_num_rows($oqon) && mysql_num_rows($voda) && mysql_num_rows($zemlya)) 
			{
				mysql_query("DELETE FROM inv WHERE owner='".$login."' AND object_id IN (29,30,31,32) and object_type='wood'");
				mysql_query("UPDATE users SET kwest=24 WHERE login='".$login."'");
				mysql_query("INSERT INTO inv(owner,object_id,object_type,object_razdel,wear,iznos,iznos_max) VALUES ('".$login."','4','scroll','magic','0','0','1')");
				mysql_query("INSERT INTO inv(owner,object_id,object_type,object_razdel,wear,iznos,iznos_max) VALUES ('".$login."','18','scroll','magic','0','0','1')");
				mysql_query("INSERT INTO inv(owner,object_id,object_type,object_razdel,wear,iznos,iznos_max) VALUES ('".$login."','22','scroll','magic','0','0','1')");
				$msg="Вы получили \"<u>Нападение</u>\", \"<u>Восстановить жизнь - 1000HP</u>\" и \"<u>Зелье каменной Стойкости x4</u>\"!<br>";
				history($login,"Подземелья Призраков",$msg,$ip,$login);
			}
			else $msg="Задания еще не выполнена!";
		}
	}
	if ($take==25)
	{
		if ($db['kwest'] != 24) $msg="Ошибка, не пытайтесь взломать игру :)!";
		else 
		{
			mysql_query("UPDATE users SET kwest=25 WHERE login='".$login."'");
			mysql_query("DELETE FROM labirint_bots WHERE user_id='".$login."' and type='bot'");
		}
	}
	if ($take==26)
	{
		if ($db['kwest'] != 25) $msg="Ошибка, не пытайтесь взломать игру :)!";
		else 
		{
			$dash1 = mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_id=33 and object_type='wood'");
			$dash2 = mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_id=34 and object_type='wood'");
			$dash3 = mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_id=35 and object_type='wood'");
			if (mysql_num_rows($dash1) && mysql_num_rows($dash2) && mysql_num_rows($dash3)) 
			{
				mysql_query("DELETE FROM inv WHERE owner='".$login."' AND object_id IN (33,34,35) and object_type='wood'");
				mysql_query("UPDATE users SET kwest=26 WHERE login='".$login."'");
				mysql_query("INSERT INTO inv(owner,object_id,object_type,object_razdel,wear,iznos,iznos_max) VALUES ('".$login."','53','scroll','magic','0','0','1')");
				mysql_query("INSERT INTO inv(owner,object_id,object_type,object_razdel,wear,iznos,iznos_max) VALUES ('".$login."','54','scroll','magic','0','0','1')");
				mysql_query("INSERT INTO inv(owner,object_id,object_type,object_razdel,wear,iznos,iznos_max) VALUES ('".$login."','55','scroll','magic','0','0','1')");
				mysql_query("INSERT INTO inv(owner,object_id,object_type,object_razdel,wear,iznos,iznos_max) VALUES ('".$login."','52','scroll','magic','0','0','1')");
				mysql_query("INSERT INTO inv(owner,object_id,object_type,object_razdel,wear,iznos,iznos_max) VALUES ('".$login."','51','scroll','magic','0','0','5')");

				$msg="Вы получили \"<u>Лечение травмы</u>\", \"<u>Тактика Защиты</u>\" , \"<u>Тактика Боя</u>\" , \"<u>Тактика Крови</u>\" и \"<u>Тактика Ответа</u>\"!<br>";
				history($login,"Подземелья Призраков",$msg,$ip,$login);
			}
			else $msg="Задания еще не выполнена!";
		}
	}
	if ($take==27)
	{
		if ($db['kwest'] != 26) $msg="Ошибка, не пытайтесь взломать игру :)!";
		else 
		{
			mysql_query("UPDATE users SET kwest=27 WHERE login='".$login."'");
			mysql_query("DELETE FROM labirint_bots WHERE user_id='".$login."' and type='bot'");
		}
	}
	if ($take==28)
	{
		if ($db['kwest'] != 27) $msg="Ошибка, не пытайтесь взломать игру :)!";
		else 
		{
			$dash1 = mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_id=36 and object_type='wood'");
			$dash2 = mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_id=37 and object_type='wood'");
			$dash3 = mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_id=38 and object_type='wood'");
			$k1=mysql_num_rows($dash1);
			$k2=mysql_num_rows($dash2);
			$k3=mysql_num_rows($dash3);
			$col=10;
			if ($k1>=$col && $k2>=$col && $k3>=$col) 
			{
				mysql_query("DELETE FROM inv WHERE owner='".$login."' AND object_id IN (36,37,38) and object_type='wood'");
				mysql_query("UPDATE users SET kwest=28, naqrada=naqrada+50 WHERE login='".$login."'");
				$ItTake = "Ёлка Деда Мороза";
				$buyitem = mysql_fetch_array(mysql_query("SELECT * FROM paltar WHERE name='".$ItTake."'"));
				if ($buyitem)
				{
					mysql_query("INSERT INTO inv(owner,object_id,object_type,object_razdel,wear,iznos,iznos_max,noremont) VALUES ('".$login."','".$buyitem['id']."','".$buyitem['object']."','obj','0','0','50','1')");
					$msg="Вы получили <u>\"$ItTake\"</u> и 50 ед. награды<br>";
					history($login,"Подземелья Призраков",$msg,$ip,$login);
				}
			}
			else $msg="Задания еще не выполнена!<br> <font color=#000000>Не хватает: Железная руда- ".($col-$k1)." штук, Никилиевая руда- ".($col-$k2)." штук и Урановая руда- ".($col-$k3)." штук</font>";
		}
	}
	if ($take==29)
	{
		if ($db['kwest'] != 28) $msg="Ошибка, не пытайтесь взломать игру :)!";
		else 
		{
			mysql_query("UPDATE users SET kwest=29 WHERE login='".$login."'");
			mysql_query("DELETE FROM labirint_bots WHERE user_id='".$login."' and type='bot'");
		}
	}
	if ($take==30)
	{
		if ($db['kwest'] != 29) $msg="Ошибка, не пытайтесь взломать игру :)!";
		else 
		{
			$dash1 = mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_id=39 and object_type='wood'");
			$dash2 = mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_id=40 and object_type='wood'");
			$dash3 = mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_id=41 and object_type='wood'");
			$dash4 = mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_id=42 and object_type='wood'");

			$k1=mysql_num_rows($dash1);
			$k2=mysql_num_rows($dash2);
			$k3=mysql_num_rows($dash3);
			$k4=mysql_num_rows($dash4);
			$col=5;
			if ($k1>=$col && $k2>=$col && $k3>=$col && $k4>=$col) 
			{
				mysql_query("DELETE FROM inv WHERE owner='".$login."' AND object_id IN (39,40,41,42) and object_type='wood'");
				mysql_query("UPDATE users SET kwest=30, naqrada=naqrada+100, money=money+500 WHERE login='".$login."'");
				$msg="Вы получили 500 Зл. и 100 ед. награды<br>";
				history($login,"Подземелья Призраков",$msg,$ip,$login);
			}
			else $msg="Задания еще не выполнена!<br> <font color=#000000>Не хватает: Превосходный топаз- ".($col-$k1)." штук, Чистое золото- ".($col-$k2)." штук, Превосходный рубин- ".($col-$k3)." штук и Превосходный сапфир- ".($col-$k4)." штук </font>";
		}
	}
	if ($take==31)
	{
		if ($db['kwest'] != 30) $msg="Ошибка, не пытайтесь взломать игру :)!";
		else 
		{
			mysql_query("UPDATE users SET kwest=31 WHERE login='".$login."'");
			mysql_query("DELETE FROM labirint_bots WHERE user_id='".$login."' and type='bot'");
		}
	}
	if ($take==32)
	{
		if ($db['kwest'] != 31) $msg="Ошибка, не пытайтесь взломать игру :)!";
		else 
		{
			$dash1 = mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_id=43 and object_type='wood'");
			$dash2 = mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_id=44 and object_type='wood'");
			$dash3 = mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_id=45 and object_type='wood'");
			$dash4 = mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_id=46 and object_type='wood'");
			$dash5 = mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_id=47 and object_type='wood'");

			$k1=mysql_num_rows($dash1);
			$k2=mysql_num_rows($dash2);
			$k3=mysql_num_rows($dash3);
			$k4=mysql_num_rows($dash4);
			$k5=mysql_num_rows($dash5);
			$col=10;
			if ($k1>=$col && $k2>=$col && $k3>=$col && $k4>=$col && $k5>=$col) 
			{
				mysql_query("DELETE FROM inv WHERE owner='".$login."' AND object_id IN (43,44,45,46,47) and object_type='wood'");
				mysql_query("UPDATE users SET kwest=32, naqrada=naqrada+200 WHERE login='".$login."'");
				$ItTake = "Ёлка Силача";
				$buyitem = mysql_fetch_array(mysql_query("SELECT * FROM paltar WHERE name='".$ItTake."'"));
				if ($buyitem)
				{
					mysql_query("INSERT INTO inv(owner,object_id,object_type,object_razdel,wear,iznos,iznos_max,noremont) VALUES ('".$login."','".$buyitem['id']."','".$buyitem['object']."','obj','0','0','10','1')");
					$msg="Вы получили <u>\"$ItTake\"</u> и 200 ед. награды<br>";
					history($login,"Подземелья Призраков",$msg,$ip,$login);
				}
			}
			else $msg="Задания еще не выполнена!<br> <font color=#000000>Не хватает: Желтый шарик- ".($col-$k1)." штук, Белый шарик- ".($col-$k2)." штук, Красный шарик- ".($col-$k3)." штук, Зеленый шарик-".($col-$k4)." штук и Основание Елки- ".($col-$k5)." штук </font>";
		}
	}
	if ($take==33)
	{
		if ($db['kwest'] != 32) $msg="Ошибка, не пытайтесь взломать игру :)!";
		else 
		{
			mysql_query("UPDATE users SET kwest=33 WHERE login='".$login."'");
			mysql_query("DELETE FROM labirint_bots WHERE user_id='".$login."' and type='bot'");
		}
	}
	if ($take==34)
	{
		if ($db['kwest'] != 33) $msg="Ошибка, не пытайтесь взломать игру :)!";
		else 
		{
			$dash1 = mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_id=48 and object_type='wood'");
			$dash2 = mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_id=49 and object_type='wood'");
			$dash3 = mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_id=50 and object_type='wood'");
			$dash4 = mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_id=51 and object_type='wood'");

			$k1=mysql_num_rows($dash1);
			$k2=mysql_num_rows($dash2);
			$k3=mysql_num_rows($dash3);
			$k4=mysql_num_rows($dash4);
			if ($k1>=25 && $k2>=30 && $k3>=20 && $k4>=15) 
			{
				mysql_query("DELETE FROM inv WHERE owner='".$login."' AND object_id IN (48,49,50,51) and object_type='wood'");
				mysql_query("UPDATE users SET kwest=34, naqrada=naqrada+500, exp=exp+1000 WHERE login='".$login."'");
				$msg="Вы получили 1000 опыта и 500 ед. награды<br>";
				history($login,"Подземелья Призраков",$msg,$ip,$login);
			}
			else $msg="Задания еще не выполнена!<br> <font color=#000000>Не хватает: Великолепное золото- ".((25-$k1)>0?(25-$k1)."шт.":"<font color=#ff0000>(выполнен)</font>").", Великолепный рубин- ".((30-$k2)>0?(30-$k2)."шт.":"<font color=#ff0000>(выполнен)</font>").", Великолепный горный хрусталь- ".((20-$k3)>0?(20-$k3)."шт.":"<font color=#ff0000>(выполнен)</font>")."  и Великолепный топаз- ".((15-$k4)>0?(15-$k4)."шт.":"<font color=#ff0000>(выполнен)</font>")."</font>";
		}
	}
	if ($take==35)
	{
		if ($db['kwest'] != 34) $msg="Ошибка, не пытайтесь взломать игру :)!";
		else 
		{
			mysql_query("UPDATE users SET kwest=35 WHERE login='".$login."'");
			mysql_query("DELETE FROM labirint_bots WHERE user_id='".$login."' and type='bot'");
		}
	}
	if ($take==36)
	{
		if ($db['kwest'] != 35) $msg="Ошибка, не пытайтесь взломать игру :)!";
		else 
		{
			$my_prof_sql=mysql_query("SELECT * FROM person_proff WHERE person=".$db["id"]." and proff=5");
			$my_prof=mysql_fetch_array($my_prof_sql);
			if ($my_prof["navika"]>=150) 
			{
				$ItTake = "Щит Забытого Бога";
				$buyitem = mysql_fetch_array(mysql_query("SELECT * FROM paltar WHERE name='".$ItTake."'"));
				if ($buyitem)
				{
					mysql_query("INSERT INTO inv(owner,object_id,object_type,object_razdel,wear,iznos,iznos_max,noremont) VALUES ('".$login."','".$buyitem['id']."','".$buyitem['object']."','obj','0','0','10','1')");
				}
				mysql_query("UPDATE users SET kwest=36, naqrada=naqrada+300, exp=exp+3500 WHERE login='".$login."'");
				$msg="Вы получили <u>\"$ItTake\"</u>, 3500 опыта и 300 ед. награды<br>";
				mysql_query("INSERT INTO inv(owner,object_id,object_type,object_razdel,gift,wear,gift_author) VALUES('".$login."','8','medal','medal','1','0','WWW.MEYDAN.AZ')");
				history($login,"Подземелья Призраков",$msg,$ip,$login);
			}
			else $msg="Задания еще не выполнена!<br> <font color=#000000>Не хватает: ".(int)(150-$my_prof["navika"])."</font>";
		}
	}


echo "<center><b style='color:#ff0000'>&nbsp;$msg</b></center>";
echo "<fieldset style='WIDTH: 100%; border:1px ridge;'>";
echo "<legend><b>Получить задание</b> - <font color=#000000>Награды: <b>$db[naqrada] ед.</b></font></legend>
<table width=100% cellspacing=0 cellpadding=5>
<tr>
<td><div align='justify'>";
$db=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE login='$login' limit 1"));

	if ($db['kwest'] == 0) 
	{
		echo "<center>Здравствуйте, <b>$login</b>.</center> Я так понимаю, что в <b>".strtoupper($db["city_game"])." ' е</b> вы недавно, так как раньше я вас не видел. 
		Надеюсь, вам понравился наш великий город и вы останетесь здесь надолго. 
		<br>Город у нас большой: есть арена для тренировок, магазин, в котором можно приобрести боевую амуницию, оружие, разнообразные свитки и эликсиры.
		Кстати, о магазине... Вам необходимо купить доспехи. Если вы их еще не купили, без них находится в нашем городе крайне опасно! Кстати, захватите в Магазине Магии свитки!
		<center><b>Так что направляйтесь в магазин!</b> </center>";
		echo "<center><input class=lbut type=button value='Получить Квест №1!' onclick='window.location.href=\"?take=1\"'></center>"; 
	}
	elseif ($db['kwest'] == 1) 
	{
		echo "<center><b style='color:#ff0000'>Вы получили <u>Квест №1</u></b>.</center>Для его выполнения вам предстоит добраться, через кровожадных монстров в подземелье, 
		до <b>Оранжерея</b> и найти там <b>Александрит</b>.
		<br>После этого придите сюда для получения бонуса.";
		echo "<br><center><input class=lbut type=button value='Получить бонус за Квест №1' onclick='window.location.href=\"?take=2\"'></center>";
	}
	elseif ($db['kwest'] == 2) 
	{
		echo"Поздравляю вы выполнили <b>Квест №1</b>, в честь этого вы получили бонус в размере <b>5 Зл</b>.
		<br><center><input class=lbut type=button value='Получить Квест №2' onclick='window.location.href=\"?take=3\"'></center>"; 
	}
	elseif ($db['kwest'] == 3) 
	{
		echo "<center><b style='color:#ff0000'>Вы получили <u>Квест №2</u></b>.</center>Для его выполнения вам предстоит добраться, до <b>Зал Очищения</b> в подземелье, и найти там сундук, в нем вы найдете <b>Алмаз</b>, 
		но для окончания квеста вам нужно будет найти еще <b>Амазонит</b> в обратном пути.
		<br>После этого придите сюда для получения бонуса."; 
		echo "<br><center><input class=lbut type=button value='Получить бонус за Квест №2' onclick='window.location.href=\"?take=4\"'></center>";
	}
	elseif ($db['kwest'] == 4) 
	{
		echo "Поздравляю вы выполнили <b>Квест №2</b>, в честь этого вы получили бонус в размере <b>50 Зл</b>.
		<br><center><input class=lbut type=button value='Получить Квест №3' onclick='window.location.href=\"?take=5\"'></center>"; 
	}
	elseif ($db['kwest'] == 5) 
	{
		echo "<center><b style='color:#ff0000'>Вы получили <u>Квест №3</u></b>.</center> Это <b>\"Испорченное Кольцо Уничтожения\"</b> <img src='img/ring/unichtojeniya.gif' border=0> оно потеряло свои свойства, для того чтобы его востановить в прежнее состояние, вам необходимо отыскать ингридиенты:
		<br><br> - <b>Рубин</b> (находится в <b>Коридор</b>, в Подземелье)<br> - <b>Солнечный камень</b> (находится в <b>Зал Мертвых</b>, в Подземелье)<br> - <b>Опал</b> (находится в <b>Зал Жизни</b>, в Подземелье)
		<br><br> После того как вы все эти ингридиенты найдете, необходимо будет вернусть назад, для того чтобы наш алхимик зачаровал <b>\"Кольцо Уничтожения\"</b>, это кольцо и будет вам бонусом за выполнение <b>Квеста №3</b>."; 
		echo "<br><center><input class=lbut type=button value='Получить бонус за Квест №3' onclick='window.location.href=\"?take=6\"'></center>";
	}
	elseif ($db['kwest'] == 6) 
	{
		echo "Поздравляю вы выполнили <b>Квест №3</b>, в честь этого вы получили бонус <b>\"Кольцо Уничтожения\"</b>.
		<br><center><input class=lbut type=button value='Получить Квест №4' onclick='window.location.href=\"?take=7\"'></center>"; 
	}
	elseif ($db['kwest'] == 7) 
	{
		echo "<center><b style='color:#ff0000'>Вы получили <u>Квест №4</u></b>.</center>Ооо... Ты снова пришел ко мне, вот у меня для тебя новое задание:
		<br><br>Найди <b>3 части меча</b>:<br><b>Змеиный плод</b> что выпал из рукояди, саму <b>Рукоядь</b>, <b>Лезвие</b> от меча...
		<br>Ты наверное подумаешь, свехнулся старик, где же я их найду! А я тебе подскажу...
		<br><b>Змеиный плод</b> будет лежать в <b>Зал Мертвых</b>, <b>Рукоядь</b> в <b>Зал Жизни</b>, <b>Лезвие</b> будет торчать в <b>Зал Живых</b>.
		<br>Принеси мне эти части, я тебе отблагадарю сполна...<br>Удачи <b>$login</b>...";
		echo "<br><center><input class=lbut type=button value='Получить бонус за Квест №4' onclick='window.location.href=\"?take=8\"'></center>";
	}
	elseif ($db['kwest'] == 8) 
	{
		echo "Поздравляю вы выполнили <b>Квест №4</b>, в честь этого вы получили бонус <b>50 Зл, + 1 к умениям</b>.
		<br><br>
		<b>Квест №1</b> выполнен<br><b>Квест №2</b> выполнен<br><b>Квест №3</b> выполнен<br><b>Квест №4</b> выполнен<br><br>";
		echo "<br><center><input class=lbut type=button value='Получить Квест №5' onclick='window.location.href=\"?take=9\"'></center>"; 
	}
	elseif ($db['kwest'] == 9) 
	{
		echo "<center><b style='color:#ff0000'>Вы получили <u>Квест №5</u></b>.</center>";
		echo "<b>Приветствую вас еще раз $login, у меня для вас есть задание. !</b><br>Я смотрю, вы полны сил и решимости!! В ваших глазах я вижу желание участвовать в битвах и побеждать! Это похвально! Но для настоящего бойца одного желания мало. 
		Еще необходим опыт и мастерство. Для того чтобы их обрести, вы должны пройти несколько испытаний.<br><br>Наши алхимики варят новое зелье, но для его приготовления им не хватает пары ингредиентов.
		Принесите мне <b>Пирит</b> (находится в <b>Зал Очищения</b>, в Подземелье), и еще один ингредиент это - <b>Сапфир</b> (находится в <b>Зал Живых</b>, в Подземелье).";
		echo "<br><center><input class=lbut type=button value='Получить бонус за Квест №5' onclick='window.location.href=\"?take=10\"'></center>";
	}
	elseif ($db['kwest'] == 10) 
	{
		echo "Поздравляю вы выполнили <b>Квест №5</b>, в честь этого вы получили бонус <b>250 Зл.</b> и Элексир <b>Живая вода - Полное восстановление</b>.";
		echo "<br><center><input class=lbut type=button value='Получить Квест №6' onclick='window.location.href=\"?take=11\"'></center>"; 
	}
	elseif ($db['kwest'] == 11) 
	{
		echo "<center><b style='color:#ff0000'>Вы получили <u>Квест №6</u></b>.</center>";
		echo "Один из моих знакомых Войнов, когда шел ко мне в гости, потерял в одном из залов свою <b>Доспех</b>, которую он выйграл на арене, тебе задание:
		<br>Найди эту <b>Доспехи Гладиатора</b> и принеси мне..."; 
		echo "<br><center><input class=lbut type=button value='Получить бонус за Квест №6' onclick='window.location.href=\"?take=12\"'></center>";
	}
	elseif ($db['kwest'] == 12) 
	{
		echo "Поздравляю вы выполнили <b>Квест №6</b>, в честь этого вы получили бонус <b>Доспехи Гладиатора</b>.";
		echo "<br><center><input class=lbut type=button value='Получить Квест №7' onclick='window.location.href=\"?take=13\"'></center>"; 
	}
	elseif ($db['kwest'] == 13) 
	{
		echo "<center><b style='color:#ff0000'>Вы получили <u>Квест №7</u></b>.</center>";
		echo "<br><b>Здравствуй, старый друг! </b><br>Сегодня я получил записку от моего брата. 
		Он наловил рыбы, варит уху и приглашает меня в гости. Но как назло у него кончилась соль и он просил принести мешочек.
		<br>Вот тебе задание, найди <b>СОЛЬ</b> для меня!. Только не просыпь ее - она очень дорога в этом году.";
		echo "<br><center><input class=lbut type=button value='Получить бонус за Квест №7' onclick='window.location.href=\"?take=14\"'></center>";
	}
	elseif ($db['kwest'] == 14) 
	{
		echo "Поздравляю вы выполнили <b>Квест №7</b>, в честь этого вы получили бонус <b>Копье боли</b>.";
		echo "<br><center><input class=lbut type=button value='Получить Квест №8' onclick='window.location.href=\"?take=15\"'></center>"; 
	}
	elseif ($db['kwest'] == 15) 
	{
		echo "<center><b style='color:#ff0000'>Вы получили <u>Квест №8</u></b>.</center>";
		echo "Чтобы восстановиться в глазах окружающих, Вам необходимо выполнить приказ: <br><b>уничтожить хотя бы 25 монстров \"Ботов\"</b>.<br><br> 
		Кроме Вас, все в курсе что они обжились в \"Подземелья Призраков\".";
		echo "<br><center><input class=lbut type=button value='Получить бонус за Квест №8' onclick='window.location.href=\"?take=16\"'></center>";
	}
	elseif ($db['kwest'] == 16) 
	{
		echo "Поздравляю вы выполнили <b>Квест №8</b>, в честь этого вы получили бонус <b>Рубаха Золотого Дракона</b>.";
		echo "<br><center><input class=lbut type=button value='Получить Квест №9' onclick='window.location.href=\"?take=17\"'></center>"; 
	}
	elseif ($db['kwest'] == 17) 
	{
		echo "<center><b style='color:#ff0000'>Вы получили <u>Квест №9</u></b>.</center>";
		echo "Мясник просит добыть новый нож у кузнеца. Поскольку ему он очень нужен, ввиду того, что старый совсем тупой, а расплатиться он мясом, которое кузнец не берет, ибо ему нужны деньги.";
		echo "<br><center><input class=lbut type=button value='Получить бонус за Квест №9' onclick='window.location.href=\"?take=18\"'></center>";
	}
	elseif ($db['kwest'] == 18) 
	{
		echo "Поздравляю вы выполнили <b>Квест №9</b>, в честь этого вы получили бонус <b>Плащ Золотого Дракона</b>.";
		echo "<br><center><input class=lbut type=button value='Получить Квест №10' onclick='window.location.href=\"?take=19\"'></center>"; 
	}
	elseif ($db['kwest'] == 19) 
	{
		echo "<center><b style='color:#ff0000'>Вы получили <u>Квест №10</u></b>.</center>";
		echo "Равняйсь! Смирно! Я – полковник Джонс. На сегодня я ваш папа, мама, а если понадобится, то и могильщик! Молчать! 
		<br>Итак, ваша задача: Бедная женщина, живущая в Синтоуне просит вас о помощи, чтобы прокормить своих детей! Найди для меня <b>Хлеб</b> и <b>Мясо</b> и принеси мне...";
		echo "<br><center><input class=lbut type=button value='Получить бонус за Квест №10' onclick='window.location.href=\"?take=20\"'></center>";
	}
	elseif ($db['kwest'] == 20) 
	{
		echo "Поздравляю вы выполнили <b>Квест №10</b>, в честь этого вы получили бонус <b>Заточка оружия +3</b>.";
		echo "<br><center><input class=lbut type=button value='Получить Квест №11' onclick='window.location.href=\"?take=21\"'></center>"; 
	}
	elseif ($db['kwest'] == 21) 
	{
		echo "<center><b style='color:#ff0000'>Вы получили <u>Квест №11</u></b>.</center>";
		echo "Чтобы восстановиться в глазах окружающих, Вы должны убить 5 монстров за всё плохое. Последний раз их видели неподалеку от <b>\"VIP Зона\"</b>. Надеюсь, еще увидимся...";
		echo "<br><center><input class=lbut type=button value='Получить бонус за Квест №11' onclick='window.location.href=\"?take=22\"'></center>";
	}
	elseif ($db['kwest'] == 22) 
	{
		echo "Поздравляю вы выполнили <b>Квест №11</b>, в честь этого вы получили бонус <b>300 Зл.</b>.";
		echo "<br><center><input class=lbut type=button value='Получить Квест №12' onclick='window.location.href=\"?take=23\"'></center>"; 
	}
	elseif ($db['kwest'] == 23) 
	{
		echo "<center><b style='color:#ff0000'>Вы получили <u>Квест №12</u></b>.</center>";
		echo "Любимый мир всех ювелиров. Населяют его безумно миролюбивые и до грани пацифистичные создания - тролли. К сожалению, Портал , через который можно попасть в этот мир, открывает проход в весьма небольшую и замкнутую часть Подземелья Призраков.<br><br> ";
		echo "Тролли любят всякие красивые безделушки, колечки, кулоны, ожерелья, украшенные драгоценными и не очень камнями. Всегда носят с собой хотя бы одну такую вещичку. Чем к более высокому сословию относится тролль, тем более дорогие украшения они носит с собой.<br><br>";
		echo "Если желаете найти мне безделушки, отправляйтесь и убивайте обитающих там монстров до тех пор пока не найдете их.";
		echo "<br><center><input class=lbut type=button value='Получить бонус за Квест №12' onclick='window.location.href=\"?take=24\"'></center>";
	}
	elseif ($db['kwest'] == 24) 
	{
		echo "Поздравляю вы выполнили <b>Квест №12</b>, в честь этого вы получили бонус <b>\"Нападение\"</b>, <b>\"Восстановить жизнь - 1000HP\"</b> и <b>\"Зелье каменной Стойкости x4\"</b>.";
		echo "<br><center><input class=lbut type=button value='Получить Квест №13' onclick='window.location.href=\"?take=25\"'></center>"; 
	}
	elseif ($db['kwest'] == 25) 
	{
		echo "<center><b style='color:#ff0000'>Вы получили <u>Квест №13</u></b>.</center>";
		echo "Вам следует поднапрячься, и найти <b>\"Мелкий щебень\"</b>, <b>\"Небольшой камень\"</b> и <b>\"Осколок гранита\"</b>. <br>";
		echo "Для достижения цели придется поучаствовать в захвате с монстрами. <br>";
		echo "Завладеть всеми их навыками и мысленной интуицией. <br>";
		echo "Запомни в подземелье, каждый квест имеет своё значение в игре. Не надейтесь на помощь... ";
		echo "<br><center><input class=lbut type=button value='Получить бонус за Квест №13' onclick='window.location.href=\"?take=26\"'></center>";
	}
	elseif ($db['kwest'] == 26) 
	{
		//<i>Продолжение следует...</i>
		echo "Поздравляю вы выполнили <b>Квест №13</b>, в честь этого вы получили бонус \"<u>Лечение травмы</u>\", \"<u>Тактика Защиты</u>\" , \"<u>Тактика Боя</u>\" , \"<u>Тактика Крови</u>\" и \"<u>Тактика Ответа</u>\".";
		echo "<br><center><input class=lbut type=button value='Получить Квест №14' onclick='window.location.href=\"?take=27\"'></center>"; 
	}
	elseif ($db['kwest'] == 27) 
	{
		echo "<center><b style='color:#ff0000'>Вы получили <u>Квест №14</u></b>.</center>";
		echo "Для бесчеловечных экспериментов лекарей города, Вам следует набраться храбрости и доставить <b>\"Железная руда\"</b> , \"<b>Никилиевая руда</b>\" и \"<b>Урановая руда</b>\" в количестве 10 штук.";
		echo "Чтобы отыскать требуемое Вам придется сразиться с множеством монcтров в <b>\"Подземелья Призраков\"</b>. <br>Мы верим в ваши силы... <br>";
		echo "<br>Делается за 10 похода.";
		echo "<br><center><input class=lbut type=button value='Получить бонус за Квест №14' onclick='window.location.href=\"?take=28\"'></center>";
	}
	elseif ($db['kwest'] == 28) 
	{
		//<i>Продолжение следует...</i>
		echo "Поздравляю вы выполнили <b>Квест №14</b>, в честь этого вы получили бонус \"<u>Ёлка Деда Мороза</u>\" и 50 ед. награды.";
		echo "<br><center><input class=lbut type=button value='Получить Квест №15' onclick='window.location.href=\"?take=29\"'></center>"; 
	}
	elseif ($db['kwest'] == 29) 
	{
		echo "<center><b style='color:#ff0000'>Вы получили <u>Квест №15</u></b>.</center>";
		echo "Неизвестно почему, Вы должны доставить <b>\"Превосходный топаз\"</b>, <b>\"Чистое золото\"</b>, <b>\"Превосходный рубин\"</b> и <b>\"Превосходный сапфир\"</b> в количестве 5 штук.<br>";
		echo "Для этого Вам придется отправиться в <b>\"Подземелья Призраков\"</b> и быть внимательным на всё протяжении пути. Будьте осмотрительны...<br>";
		echo "<br>Делается за 5 похода.";
		echo "<br><center><input class=lbut type=button value='Получить бонус за Квест №15' onclick='window.location.href=\"?take=30\"'></center>";
	}
	elseif ($db['kwest'] == 30) 
	{
		echo "Поздравляю вы выполнили <b>Квест №15</b>, в честь этого вы получили бонус \"<u>500 Зл.</u>\" и 100 ед. награды.";
		echo "<br><center><input class=lbut type=button value='Получить Квест №16' onclick='window.location.href=\"?take=31\"'></center>"; 
	}
	elseif ($db['kwest'] == 31) 
	{
		echo "<center><b style='color:#ff0000'>Вы получили <u>Квест №16</u></b>.</center>";
		echo "Великолепно! Вы уже доказали Вашу преданность.<br>";
		echo "Вам следует поднапрячься, и найти <b>\"Шарик для Елки\"</b> в количестве 40 штук, и <b>\"Основание Елки\"</b> в количестве 10 штук.<br>";
		echo "Для этого Вам придется отправиться в <b>\"Подземелья Призраков\"</b> и быть внимательным на всё протяжении пути. И помните, это не прогулка...<br>";
		echo "<br>Делается за 10 похода.";
		echo "<br><center><input class=lbut type=button value='Получить бонус за Квест №16' onclick='window.location.href=\"?take=32\"'></center>";
	}
	elseif ($db['kwest'] == 32) 
	{
		echo "Поздравляю вы выполнили <b>Квест №16</b>, в честь этого вы получили бонус \"<u>Ёлка Силача</u>\" и 200 ед. награды.";
		echo "<br><center><input class=lbut type=button value='Получить Квест №17' onclick='window.location.href=\"?take=33\"'></center>"; 
	}
	elseif ($db['kwest'] == 33) 
	{
		echo "<center><b style='color:#ff0000'>Вы получили <u>Квест №17</u></b>.</center>";
		echo "Ты славно потрудился во имя Разума. Мы считаем, что теперь ты готов справится с миссией достойной звания Рыцаря!<br>";
		echo "Вам придется хорошо поработать, чтобы достать <b>\"Великолепное золото\"</b> в количестве 25 штук, <b>\"Великолепный рубин\"</b> в количестве 30 штук, <b>\"Великолепный горный хрусталь\"</b> в количестве 20 штук, и <b>\"Великолепный топаз\"</b> в количестве 15 штук для пополнения наших запасов.<br>";
		echo "<br>Прощайте... :)";
		echo "<br><center><input class=lbut type=button value='Получить бонус за Квест №17' onclick='window.location.href=\"?take=34\"'></center>";
	}
	elseif ($db['kwest'] == 34) 
	{
		echo "Поздравляю вы выполнили <b>Квест №17</b>, в честь этого вы получили бонус <b>1000 опыта</b> и <b>500 ед. награды</b>.";
		echo "<br><center><input class=lbut type=button value='Получить Квест №18' onclick='window.location.href=\"?take=35\"'></center>"; 
	}
	elseif ($db['kwest'] == 35) 
	{
		echo "<center><b style='color:#ff0000'>Вы получили <u>Квест №18</u></b>.</center>";
		echo "От вас требуется что бы вы подняли свой <b>Рейтинг Лесоруба до 150</b>";
		echo "<br><center><input class=lbut type=button value='Получить бонус за Квест №18' onclick='window.location.href=\"?take=36\"'></center>";
	}
	elseif ($db['kwest'] == 36) 
	{
		echo "Поздравляю вы выполнили <b>Квест №18</b>, в честь этого вы получили бонус <b>Щит Забытого Бога</b>, <b>3500 опыта</b> и <b>300 ед. награды</b>.";
		echo "<br><center><input class=lbut type=button value='Продолжение следует...' onclick='window.location.href=\"?take=37\"'></center>"; 
	}
	elseif ($db['kwest'] >36) 
	{
		//<i>Продолжение следует...</i>
		echo "<font color=red>Поздравляю вы выполнили все квесты в етом подземелье...</font>";
	}

echo"
</td></tr>
</table>
</fieldset>";
echo"</td></tr></table>";
?>