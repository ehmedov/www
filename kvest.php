<?
$now=time();
$take=(int)$_GET["take"];

$login=$_SESSION['login'];
$ip=$db[remote_ip];
	echo"<table width=100% cellspacing=0 cellpadding=3 border=0><tr><td>";
	if ($take==1) 
	{
		if ($db['kwest'] != 0) $msg="������, �� ��������� �������� ���� :)!";
		else {mysql_query("UPDATE users SET kwest=1 WHERE login='".$login."'");}
	}

	if ($take==2)
	{
		if ($db['kwest'] != 1) $msg="������, �� ��������� �������� ���� :)!";
		else 
		{
			$alexandrit = mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_id=11 and object_type='wood'");
			if (mysql_num_rows ($alexandrit)) 
			{
				mysql_query("DELETE FROM inv WHERE owner='".$login."' AND object_id=11 and object_type='wood'");
				mysql_query("UPDATE users SET kwest=2, money=money+5 WHERE login='".$login."'");
				history($login,"���������� ���������","�� �������� 5 ��.",$ip,$login);
			}
			else $msg="� ��� ��� ���� \"�����������\"!";
		}
	}

	if ($take==3)
	{
		if ($db['kwest'] != 2) $msg="������, �� ��������� �������� ���� :)!";
		else
		{
			mysql_query("UPDATE users SET kwest=3 WHERE login='".$login."'");
		}
	}

	if ($take==4)
	{
		if ($db['kwest'] != 3) $msg="������, �� ��������� �������� ���� :)!";
		else
		{
			$alexandrit = mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_id=13 and object_type='wood'");
			$almaz = mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_id=12 and object_type='wood'");
			if (mysql_num_rows ($alexandrit) && mysql_num_rows ($almaz)) 
			{
				mysql_query("DELETE FROM inv WHERE owner='".$login."' AND object_id IN (12,13) and object_type='wood'");
				mysql_query("UPDATE users SET kwest=4, money=money+50 WHERE login='".$login."'");
				history($login,"���������� ���������","�� �������� 50 ��.",$ip,$login);
			}
			else $msg="� ��� ��� ���� \"�����\" �  \"��������\"!";
		}
	}
	
	if ($take==5)
	{
		if ($db['kwest'] != 4) $msg="������, �� ��������� �������� ���� :)!";
		else
		{
			mysql_query("UPDATE users SET kwest=5 WHERE login='".$login."'");
			mysql_query("DELETE FROM labirint_bots WHERE user_id='".$login."' and type='bot'");
		}
	}


	if ($take==6)
	{
		if ($db['kwest'] != 5) $msg="������, �� ��������� �������� ���� :)!";
		else 
		{
			$opal = mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_id=16 and object_type='wood'");
			$rubin = mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_id=17 and object_type='wood'");
			$sun_kamen = mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_id=19 and object_type='wood'");
			if (mysql_num_rows ($opal) && mysql_num_rows ($rubin)&& mysql_num_rows ($sun_kamen)) 
			{
				mysql_query("DELETE FROM inv WHERE owner='".$login."' AND object_id IN (16,17,19) and object_type='wood'");
				mysql_query("UPDATE users SET kwest=6 WHERE login='".$login."'");
				$ItTake = "������ �����������";
				$buyitem = mysql_fetch_array(mysql_query("SELECT * FROM paltar WHERE name='".$ItTake."'"));
				if ($buyitem)
				{
					mysql_query("INSERT INTO inv(owner,object_id,object_type,object_razdel,wear,iznos,iznos_max,noremont) VALUES ('".$login."','".$buyitem['id']."','".$buyitem['object']."','obj','0','0','".$buyitem['iznos_max']."','".$buyitem['noremont']."')");
					$msg="�� �������� <u>\"������ �����������\"</u><br>";
					history($login,"���������� ���������","������ �����������",$ip,$login);
				}
			}
			else $msg="� ��� ��� ���� \"�����\", \"��������� ������\" �  \"����\"!";
		}
	}

	if ($take==7)
	{
		if ($db['kwest'] != 6) $msg="������, �� ��������� �������� ���� :)!";
		else
		{
			mysql_query("UPDATE users SET kwest=7 WHERE login='".$login."'");
			mysql_query("DELETE FROM labirint_bots WHERE user_id='".$login."' and type='bot'");
		}
	}

	if ($take==8)
	{
		if ($db['kwest'] != 7) $msg="������, �� ��������� �������� ���� :)!";
		else 
		{
			$zmei_plod = mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_id=21 and object_type='wood'");
			$lezvie = mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_id=22 and object_type='wood'");
			$rukoad = mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_id=20 and object_type='wood'");
			if (mysql_num_rows ($zmei_plod) && mysql_num_rows ($lezvie)&& mysql_num_rows ($rukoad)) 
			{
				mysql_query("DELETE FROM inv WHERE owner='".$login."' AND object_id IN (20,21,22) and object_type='wood'");
				mysql_query("UPDATE users SET kwest=8,umenie=umenie+1,money=money+100 WHERE login='".$login."'");
				$msg="�� �������� <b>100 ��, + 1 � �������</b><br>";
				history($login,"���������� ���������","�� �������� 100 ��, + 1 � �������",$ip,$login);
			}
			else $msg="� ��� ��� ���� \"�������\", \"������� ����\" �  \"������\"!";
		}
	}

	if ($take==9)
	{
		if ($db['kwest'] != 8) $msg="������, �� ��������� �������� ���� :)!";
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
			$msg="�� �������� <b>250 ��.</b> � ������� <b>����� ���� - ������ ��������������</b><br>";
			history($login,"���������� ���������",$msg,$ip,$login);
		}
		else $msg="� ��� ��� ���� \"������\" �  \"�����\"!";
	}

	if ($take==11)
	{
		if ($db['kwest'] != 10) $msg="������, �� ��������� �������� ���� :)!";
		else 
		{
			mysql_query("UPDATE users SET kwest=11 WHERE login='".$login."'");
			mysql_query("DELETE FROM labirint_bots WHERE user_id='".$login."' and type='bot'");
		}
	}

	if ($take==12)
	{
		if ($db['kwest'] != 11) $msg="������, �� ��������� �������� ���� :)!";
		else 
		{
			$plash = mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_id=23 and object_type='wood'");
			if (mysql_num_rows ($plash)) 
			{
				mysql_query("DELETE FROM inv WHERE owner='".$login."' AND object_id=23 and object_type='wood'");
				mysql_query("UPDATE users SET kwest=12 WHERE login='".$login."'");
				$ItTake = "������� ����������";
				$buyitem = mysql_fetch_array(mysql_query("SELECT * FROM paltar WHERE name='".$ItTake."'"));
				if ($buyitem)
				{
					mysql_query("INSERT INTO inv(owner,object_id,object_type,object_razdel,wear,iznos,iznos_max,noremont) VALUES ('".$login."','".$buyitem['id']."','".$buyitem['object']."','obj','0','0','10','1')");
					$msg="�� �������� <u>\"$ItTake\"</u><br>";
					history($login,"���������� ���������",$msg,$ip,$login);
				}
			}
			else $msg="� ��� ��� ���� \"������� ����������\"!";
		}
	}

	if ($take==13)
	{
		if ($db['kwest'] != 12) $msg="������, �� ��������� �������� ���� :)!";
		else 
		{
			mysql_query("UPDATE users SET kwest=13 WHERE login='".$login."'");
			mysql_query("DELETE FROM labirint_bots WHERE user_id='".$login."' and type='bot'");
		}
	}

	if ($take==14)
	{
		if ($db['kwest'] != 13) $msg="������, �� ��������� �������� ���� :)!";
		else 
		{
			$sol = mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_id=24 and object_type='wood'");
			if (mysql_num_rows ($sol)) 
			{
				mysql_query("DELETE FROM inv WHERE owner='".$login."' AND object_id=24 and object_type='wood'");
				mysql_query("UPDATE users SET kwest=14 WHERE login='".$login."'");
				
				$ItTake = "����� ����";
				$buyitem = mysql_fetch_array(mysql_query("SELECT * FROM paltar WHERE name='".$ItTake."'"));
				if ($buyitem)
				{
					mysql_query("INSERT INTO inv(owner,object_id,object_type,object_razdel,wear,iznos,iznos_max,noremont) VALUES ('".$login."','".$buyitem['id']."','".$buyitem['object']."','obj','0','0','5','1')");
					$msg="�� �������� <u>\"$ItTake\"</u><br>";
					history($login,"���������� ���������",$msg,$ip,$login);
				}
			}
			else $msg="� ��� ��� ���� \"����\"!";
		}
	}
	
	if ($take==15)
	{
		if ($db['kwest'] != 14) $msg="������, �� ��������� �������� ���� :)!";
		else 
		{
			mysql_query("UPDATE users SET kwest=15 WHERE login='".$login."'");
			mysql_query("DELETE FROM labirint_bots WHERE user_id='".$login."' and type='bot'");
		}
	}
	if ($take==16)
	{
		if ($db['kwest'] != 15) $msg="������, �� ��������� �������� ���� :)!";
		else 
		{
			$kill_bots = mysql_query("SELECT * FROM labirint_bots WHERE user_id='".$login."' AND type='bot'");
			$count_kill_bots=mysql_num_rows ($kill_bots);
			if ($count_kill_bots>=25) 
			{
				mysql_query("UPDATE users SET kwest=16 WHERE login='".$login."'");
				
				$ItTake = "������ �������� �������";
				$buyitem = mysql_fetch_array(mysql_query("SELECT * FROM paltar WHERE name='".$ItTake."'"));
				if ($buyitem)
				{
					mysql_query("INSERT INTO inv(owner,object_id,object_type,object_razdel,wear,iznos,iznos_max,noremont) VALUES ('".$login."','".$buyitem['id']."','".$buyitem['object']."','obj','0','0','5','1')");
					$msg="�� �������� <u>\"$ItTake\"</u><br>";
					history($login,"���������� ���������",$msg,$ip,$login);
				}
			}
			else $msg="�� ������� ".(25-$count_kill_bots)." �����!";
		}
	}
	
	if ($take==17)
	{
		if ($db['kwest'] != 16) $msg="������, �� ��������� �������� ���� :)!";
		else 
		{
			mysql_query("UPDATE users SET kwest=17 WHERE login='".$login."'");
			mysql_query("DELETE FROM labirint_bots WHERE user_id='".$login."' and type='bot'");
		}
	}
	if ($take==18)
	{
		if ($db['kwest'] != 17) $msg="������, �� ��������� �������� ���� :)!";
		else 
		{
			$noj = mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_id=25 and object_type='wood'");
			if (mysql_num_rows ($noj)) 
			{
				mysql_query("DELETE FROM inv WHERE owner='".$login."' AND object_id=25 and object_type='wood'");
				mysql_query("UPDATE users SET kwest=18 WHERE login='".$login."'");				
				$ItTake = "���� �������� �������";
				$buyitem = mysql_fetch_array(mysql_query("SELECT * FROM paltar WHERE name='".$ItTake."'"));
				if ($buyitem)
				{
					mysql_query("INSERT INTO inv(owner,object_id,object_type,object_razdel,wear,iznos,iznos_max,noremont) VALUES ('".$login."','".$buyitem['id']."','".$buyitem['object']."','obj','0','0','5','1')");
					$msg="�� �������� <u>\"$ItTake\"</u><br>";
					history($login,"���������� ���������",$msg,$ip,$login);
				}

			}
			else $msg="� ��� ��� ���� \"�������� ������\"!";
		}
	}
	if ($take==19)
	{
		if ($db['kwest'] != 18) $msg="������, �� ��������� �������� ���� :)!";
		else 
		{
			mysql_query("UPDATE users SET kwest=19 WHERE login='".$login."'");
			mysql_query("DELETE FROM labirint_bots WHERE user_id='".$login."' and type='bot'");
		}
	}
	if ($take==20)
	{
		if ($db['kwest'] != 19) $msg="������, �� ��������� �������� ���� :)!";
		else
		{
			$bread = mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_id=26 and object_type='wood'");
			$meat = mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_id=27 and object_type='wood'");
			if (mysql_num_rows ($bread) && mysql_num_rows ($meat)) 
			{
				mysql_query("DELETE FROM inv WHERE owner='".$login."' AND object_id IN (26,27) and object_type='wood'");
				mysql_query("UPDATE users SET kwest=20 WHERE login='".$login."'");
				$ItTake = "������� ������ +3";
				$buyitem = mysql_fetch_array(mysql_query("SELECT * FROM scroll WHERE name='".$ItTake."'"));
				if ($buyitem)
				{
					mysql_query("INSERT INTO inv(owner,object_id,object_type,object_razdel,wear,iznos,iznos_max) VALUES ('".$login."','".$buyitem['id']."','scroll','magic','0','0','".$buyitem['iznos_max']."')");
					$msg="�� �������� <u>\"$ItTake\"</u><br>";
					history($login,"���������� ���������",$msg,$ip,$login);
				}
			}
			else $msg="� ��� ��� ���� \"����\" �  \"����\"!";
		}
	}
	if ($take==21)
	{
		if ($db['kwest'] != 20) $msg="������, �� ��������� �������� ���� :)!";
		else 
		{
			mysql_query("UPDATE users SET kwest=21 WHERE login='".$login."'");
			mysql_query("DELETE FROM labirint_bots WHERE user_id='".$login."' and type='bot'");
		}
	}
	if ($take==22)
	{
		if ($db['kwest'] != 21) $msg="������, �� ��������� �������� ���� :)!";
		else
		{
			$kill_bots = mysql_query("SELECT * FROM labirint_bots WHERE user_id='".$login."' AND type='bot' and bots IN (98,97,95,93,91)");
			$count_kill_bots=mysql_num_rows ($kill_bots);
			if ($count_kill_bots==5) 
			{
				mysql_query("UPDATE users SET kwest=22, money=money+300 WHERE login='".$login."'");
				history($login,"���������� ���������","�� �������� 300 ��.",$ip,$login);
			}
			else $msg="������� ��� �� ���������! �� ������� ".(5-$count_kill_bots)." �����!";
		}
	}
	if ($take==23)
	{
		if ($db['kwest'] != 22) $msg="������, �� ��������� �������� ���� :)!";
		else 
		{
			mysql_query("UPDATE users SET kwest=23 WHERE login='".$login."'");
			mysql_query("DELETE FROM labirint_bots WHERE user_id='".$login."' and type='bot'");
		}
	}
	if ($take==24)
	{
		if ($db['kwest'] != 23) $msg="������, �� ��������� �������� ���� :)!";
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
				$msg="�� �������� \"<u>���������</u>\", \"<u>������������ ����� - 1000HP</u>\" � \"<u>����� �������� ��������� x4</u>\"!<br>";
				history($login,"���������� ���������",$msg,$ip,$login);
			}
			else $msg="������� ��� �� ���������!";
		}
	}
	if ($take==25)
	{
		if ($db['kwest'] != 24) $msg="������, �� ��������� �������� ���� :)!";
		else 
		{
			mysql_query("UPDATE users SET kwest=25 WHERE login='".$login."'");
			mysql_query("DELETE FROM labirint_bots WHERE user_id='".$login."' and type='bot'");
		}
	}
	if ($take==26)
	{
		if ($db['kwest'] != 25) $msg="������, �� ��������� �������� ���� :)!";
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

				$msg="�� �������� \"<u>������� ������</u>\", \"<u>������� ������</u>\" , \"<u>������� ���</u>\" , \"<u>������� �����</u>\" � \"<u>������� ������</u>\"!<br>";
				history($login,"���������� ���������",$msg,$ip,$login);
			}
			else $msg="������� ��� �� ���������!";
		}
	}
	if ($take==27)
	{
		if ($db['kwest'] != 26) $msg="������, �� ��������� �������� ���� :)!";
		else 
		{
			mysql_query("UPDATE users SET kwest=27 WHERE login='".$login."'");
			mysql_query("DELETE FROM labirint_bots WHERE user_id='".$login."' and type='bot'");
		}
	}
	if ($take==28)
	{
		if ($db['kwest'] != 27) $msg="������, �� ��������� �������� ���� :)!";
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
				$ItTake = "���� ���� ������";
				$buyitem = mysql_fetch_array(mysql_query("SELECT * FROM paltar WHERE name='".$ItTake."'"));
				if ($buyitem)
				{
					mysql_query("INSERT INTO inv(owner,object_id,object_type,object_razdel,wear,iznos,iznos_max,noremont) VALUES ('".$login."','".$buyitem['id']."','".$buyitem['object']."','obj','0','0','50','1')");
					$msg="�� �������� <u>\"$ItTake\"</u> � 50 ��. �������<br>";
					history($login,"���������� ���������",$msg,$ip,$login);
				}
			}
			else $msg="������� ��� �� ���������!<br> <font color=#000000>�� �������: �������� ����- ".($col-$k1)." ����, ���������� ����- ".($col-$k2)." ���� � �������� ����- ".($col-$k3)." ����</font>";
		}
	}
	if ($take==29)
	{
		if ($db['kwest'] != 28) $msg="������, �� ��������� �������� ���� :)!";
		else 
		{
			mysql_query("UPDATE users SET kwest=29 WHERE login='".$login."'");
			mysql_query("DELETE FROM labirint_bots WHERE user_id='".$login."' and type='bot'");
		}
	}
	if ($take==30)
	{
		if ($db['kwest'] != 29) $msg="������, �� ��������� �������� ���� :)!";
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
				$msg="�� �������� 500 ��. � 100 ��. �������<br>";
				history($login,"���������� ���������",$msg,$ip,$login);
			}
			else $msg="������� ��� �� ���������!<br> <font color=#000000>�� �������: ������������ �����- ".($col-$k1)." ����, ������ ������- ".($col-$k2)." ����, ������������ �����- ".($col-$k3)." ���� � ������������ ������- ".($col-$k4)." ���� </font>";
		}
	}
	if ($take==31)
	{
		if ($db['kwest'] != 30) $msg="������, �� ��������� �������� ���� :)!";
		else 
		{
			mysql_query("UPDATE users SET kwest=31 WHERE login='".$login."'");
			mysql_query("DELETE FROM labirint_bots WHERE user_id='".$login."' and type='bot'");
		}
	}
	if ($take==32)
	{
		if ($db['kwest'] != 31) $msg="������, �� ��������� �������� ���� :)!";
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
				$ItTake = "���� ������";
				$buyitem = mysql_fetch_array(mysql_query("SELECT * FROM paltar WHERE name='".$ItTake."'"));
				if ($buyitem)
				{
					mysql_query("INSERT INTO inv(owner,object_id,object_type,object_razdel,wear,iznos,iznos_max,noremont) VALUES ('".$login."','".$buyitem['id']."','".$buyitem['object']."','obj','0','0','10','1')");
					$msg="�� �������� <u>\"$ItTake\"</u> � 200 ��. �������<br>";
					history($login,"���������� ���������",$msg,$ip,$login);
				}
			}
			else $msg="������� ��� �� ���������!<br> <font color=#000000>�� �������: ������ �����- ".($col-$k1)." ����, ����� �����- ".($col-$k2)." ����, ������� �����- ".($col-$k3)." ����, ������� �����-".($col-$k4)." ���� � ��������� ����- ".($col-$k5)." ���� </font>";
		}
	}
	if ($take==33)
	{
		if ($db['kwest'] != 32) $msg="������, �� ��������� �������� ���� :)!";
		else 
		{
			mysql_query("UPDATE users SET kwest=33 WHERE login='".$login."'");
			mysql_query("DELETE FROM labirint_bots WHERE user_id='".$login."' and type='bot'");
		}
	}
	if ($take==34)
	{
		if ($db['kwest'] != 33) $msg="������, �� ��������� �������� ���� :)!";
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
				$msg="�� �������� 1000 ����� � 500 ��. �������<br>";
				history($login,"���������� ���������",$msg,$ip,$login);
			}
			else $msg="������� ��� �� ���������!<br> <font color=#000000>�� �������: ������������ ������- ".((25-$k1)>0?(25-$k1)."��.":"<font color=#ff0000>(��������)</font>").", ������������ �����- ".((30-$k2)>0?(30-$k2)."��.":"<font color=#ff0000>(��������)</font>").", ������������ ������ ��������- ".((20-$k3)>0?(20-$k3)."��.":"<font color=#ff0000>(��������)</font>")."  � ������������ �����- ".((15-$k4)>0?(15-$k4)."��.":"<font color=#ff0000>(��������)</font>")."</font>";
		}
	}
	if ($take==35)
	{
		if ($db['kwest'] != 34) $msg="������, �� ��������� �������� ���� :)!";
		else 
		{
			mysql_query("UPDATE users SET kwest=35 WHERE login='".$login."'");
			mysql_query("DELETE FROM labirint_bots WHERE user_id='".$login."' and type='bot'");
		}
	}
	if ($take==36)
	{
		if ($db['kwest'] != 35) $msg="������, �� ��������� �������� ���� :)!";
		else 
		{
			$my_prof_sql=mysql_query("SELECT * FROM person_proff WHERE person=".$db["id"]." and proff=5");
			$my_prof=mysql_fetch_array($my_prof_sql);
			if ($my_prof["navika"]>=150) 
			{
				$ItTake = "��� �������� ����";
				$buyitem = mysql_fetch_array(mysql_query("SELECT * FROM paltar WHERE name='".$ItTake."'"));
				if ($buyitem)
				{
					mysql_query("INSERT INTO inv(owner,object_id,object_type,object_razdel,wear,iznos,iznos_max,noremont) VALUES ('".$login."','".$buyitem['id']."','".$buyitem['object']."','obj','0','0','10','1')");
				}
				mysql_query("UPDATE users SET kwest=36, naqrada=naqrada+300, exp=exp+3500 WHERE login='".$login."'");
				$msg="�� �������� <u>\"$ItTake\"</u>, 3500 ����� � 300 ��. �������<br>";
				mysql_query("INSERT INTO inv(owner,object_id,object_type,object_razdel,gift,wear,gift_author) VALUES('".$login."','8','medal','medal','1','0','WWW.MEYDAN.AZ')");
				history($login,"���������� ���������",$msg,$ip,$login);
			}
			else $msg="������� ��� �� ���������!<br> <font color=#000000>�� �������: ".(int)(150-$my_prof["navika"])."</font>";
		}
	}


echo "<center><b style='color:#ff0000'>&nbsp;$msg</b></center>";
echo "<fieldset style='WIDTH: 100%; border:1px ridge;'>";
echo "<legend><b>�������� �������</b> - <font color=#000000>�������: <b>$db[naqrada] ��.</b></font></legend>
<table width=100% cellspacing=0 cellpadding=5>
<tr>
<td><div align='justify'>";
$db=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE login='$login' limit 1"));

	if ($db['kwest'] == 0) 
	{
		echo "<center>������������, <b>$login</b>.</center> � ��� �������, ��� � <b>".strtoupper($db["city_game"])." ' �</b> �� �������, ��� ��� ������ � ��� �� �����. 
		�������, ��� ���������� ��� ������� ����� � �� ���������� ����� �������. 
		<br>����� � ��� �������: ���� ����� ��� ����������, �������, � ������� ����� ���������� ������ ��������, ������, ������������� ������ � ��������.
		������, � ��������... ��� ���������� ������ �������. ���� �� �� ��� �� ������, ��� ��� ��������� � ����� ������ ������ ������! ������, ��������� � �������� ����� ������!
		<center><b>��� ��� ������������� � �������!</b> </center>";
		echo "<center><input class=lbut type=button value='�������� ����� �1!' onclick='window.location.href=\"?take=1\"'></center>"; 
	}
	elseif ($db['kwest'] == 1) 
	{
		echo "<center><b style='color:#ff0000'>�� �������� <u>����� �1</u></b>.</center>��� ��� ���������� ��� ��������� ���������, ����� ����������� �������� � ����������, 
		�� <b>���������</b> � ����� ��� <b>�����������</b>.
		<br>����� ����� ������� ���� ��� ��������� ������.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �� ����� �1' onclick='window.location.href=\"?take=2\"'></center>";
	}
	elseif ($db['kwest'] == 2) 
	{
		echo"���������� �� ��������� <b>����� �1</b>, � ����� ����� �� �������� ����� � ������� <b>5 ��</b>.
		<br><center><input class=lbut type=button value='�������� ����� �2' onclick='window.location.href=\"?take=3\"'></center>"; 
	}
	elseif ($db['kwest'] == 3) 
	{
		echo "<center><b style='color:#ff0000'>�� �������� <u>����� �2</u></b>.</center>��� ��� ���������� ��� ��������� ���������, �� <b>��� ��������</b> � ����������, � ����� ��� ������, � ��� �� ������� <b>�����</b>, 
		�� ��� ��������� ������ ��� ����� ����� ����� ��� <b>��������</b> � �������� ����.
		<br>����� ����� ������� ���� ��� ��������� ������."; 
		echo "<br><center><input class=lbut type=button value='�������� ����� �� ����� �2' onclick='window.location.href=\"?take=4\"'></center>";
	}
	elseif ($db['kwest'] == 4) 
	{
		echo "���������� �� ��������� <b>����� �2</b>, � ����� ����� �� �������� ����� � ������� <b>50 ��</b>.
		<br><center><input class=lbut type=button value='�������� ����� �3' onclick='window.location.href=\"?take=5\"'></center>"; 
	}
	elseif ($db['kwest'] == 5) 
	{
		echo "<center><b style='color:#ff0000'>�� �������� <u>����� �3</u></b>.</center> ��� <b>\"����������� ������ �����������\"</b> <img src='img/ring/unichtojeniya.gif' border=0> ��� �������� ���� ��������, ��� ���� ����� ��� ����������� � ������� ���������, ��� ���������� �������� �����������:
		<br><br> - <b>�����</b> (��������� � <b>�������</b>, � ����������)<br> - <b>��������� ������</b> (��������� � <b>��� �������</b>, � ����������)<br> - <b>����</b> (��������� � <b>��� �����</b>, � ����������)
		<br><br> ����� ���� ��� �� ��� ��� ����������� �������, ���������� ����� �������� �����, ��� ���� ����� ��� ������� ��������� <b>\"������ �����������\"</b>, ��� ������ � ����� ��� ������� �� ���������� <b>������ �3</b>."; 
		echo "<br><center><input class=lbut type=button value='�������� ����� �� ����� �3' onclick='window.location.href=\"?take=6\"'></center>";
	}
	elseif ($db['kwest'] == 6) 
	{
		echo "���������� �� ��������� <b>����� �3</b>, � ����� ����� �� �������� ����� <b>\"������ �����������\"</b>.
		<br><center><input class=lbut type=button value='�������� ����� �4' onclick='window.location.href=\"?take=7\"'></center>"; 
	}
	elseif ($db['kwest'] == 7) 
	{
		echo "<center><b style='color:#ff0000'>�� �������� <u>����� �4</u></b>.</center>���... �� ����� ������ �� ���, ��� � ���� ��� ���� ����� �������:
		<br><br>����� <b>3 ����� ����</b>:<br><b>������� ����</b> ��� ����� �� �������, ���� <b>�������</b>, <b>������</b> �� ����...
		<br>�� �������� ���������, ��������� ������, ��� �� � �� �����! � � ���� ��������...
		<br><b>������� ����</b> ����� ������ � <b>��� �������</b>, <b>�������</b> � <b>��� �����</b>, <b>������</b> ����� ������� � <b>��� �����</b>.
		<br>������� ��� ��� �����, � ���� ����������� ������...<br>����� <b>$login</b>...";
		echo "<br><center><input class=lbut type=button value='�������� ����� �� ����� �4' onclick='window.location.href=\"?take=8\"'></center>";
	}
	elseif ($db['kwest'] == 8) 
	{
		echo "���������� �� ��������� <b>����� �4</b>, � ����� ����� �� �������� ����� <b>50 ��, + 1 � �������</b>.
		<br><br>
		<b>����� �1</b> ��������<br><b>����� �2</b> ��������<br><b>����� �3</b> ��������<br><b>����� �4</b> ��������<br><br>";
		echo "<br><center><input class=lbut type=button value='�������� ����� �5' onclick='window.location.href=\"?take=9\"'></center>"; 
	}
	elseif ($db['kwest'] == 9) 
	{
		echo "<center><b style='color:#ff0000'>�� �������� <u>����� �5</u></b>.</center>";
		echo "<b>����������� ��� ��� ��� $login, � ���� ��� ��� ���� �������. !</b><br>� ������, �� ����� ��� � ���������!! � ����� ������ � ���� ������� ����������� � ������ � ���������! ��� ���������! �� ��� ���������� ����� ������ ������� ����. 
		��� ��������� ���� � ����������. ��� ���� ����� �� �������, �� ������ ������ ��������� ���������.<br><br>���� �������� ����� ����� �����, �� ��� ��� ������������� �� �� ������� ���� ������������.
		��������� ��� <b>�����</b> (��������� � <b>��� ��������</b>, � ����������), � ��� ���� ���������� ��� - <b>������</b> (��������� � <b>��� �����</b>, � ����������).";
		echo "<br><center><input class=lbut type=button value='�������� ����� �� ����� �5' onclick='window.location.href=\"?take=10\"'></center>";
	}
	elseif ($db['kwest'] == 10) 
	{
		echo "���������� �� ��������� <b>����� �5</b>, � ����� ����� �� �������� ����� <b>250 ��.</b> � ������� <b>����� ���� - ������ ��������������</b>.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �6' onclick='window.location.href=\"?take=11\"'></center>"; 
	}
	elseif ($db['kwest'] == 11) 
	{
		echo "<center><b style='color:#ff0000'>�� �������� <u>����� �6</u></b>.</center>";
		echo "���� �� ���� �������� ������, ����� ��� �� ��� � �����, ������� � ����� �� ����� ���� <b>������</b>, ������� �� ������� �� �����, ���� �������:
		<br>����� ��� <b>������� ����������</b> � ������� ���..."; 
		echo "<br><center><input class=lbut type=button value='�������� ����� �� ����� �6' onclick='window.location.href=\"?take=12\"'></center>";
	}
	elseif ($db['kwest'] == 12) 
	{
		echo "���������� �� ��������� <b>����� �6</b>, � ����� ����� �� �������� ����� <b>������� ����������</b>.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �7' onclick='window.location.href=\"?take=13\"'></center>"; 
	}
	elseif ($db['kwest'] == 13) 
	{
		echo "<center><b style='color:#ff0000'>�� �������� <u>����� �7</u></b>.</center>";
		echo "<br><b>����������, ������ ����! </b><br>������� � ������� ������� �� ����� �����. 
		�� ������� ����, ����� ��� � ���������� ���� � �����. �� ��� ����� � ���� ��������� ���� � �� ������ �������� �������.
		<br>��� ���� �������, ����� <b>����</b> ��� ����!. ������ �� ������� �� - ��� ����� ������ � ���� ����.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �� ����� �7' onclick='window.location.href=\"?take=14\"'></center>";
	}
	elseif ($db['kwest'] == 14) 
	{
		echo "���������� �� ��������� <b>����� �7</b>, � ����� ����� �� �������� ����� <b>����� ����</b>.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �8' onclick='window.location.href=\"?take=15\"'></center>"; 
	}
	elseif ($db['kwest'] == 15) 
	{
		echo "<center><b style='color:#ff0000'>�� �������� <u>����� �8</u></b>.</center>";
		echo "����� �������������� � ������ ����������, ��� ���������� ��������� ������: <br><b>���������� ���� �� 25 �������� \"�����\"</b>.<br><br> 
		����� ���, ��� � ����� ��� ��� �������� � \"���������� ���������\".";
		echo "<br><center><input class=lbut type=button value='�������� ����� �� ����� �8' onclick='window.location.href=\"?take=16\"'></center>";
	}
	elseif ($db['kwest'] == 16) 
	{
		echo "���������� �� ��������� <b>����� �8</b>, � ����� ����� �� �������� ����� <b>������ �������� �������</b>.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �9' onclick='window.location.href=\"?take=17\"'></center>"; 
	}
	elseif ($db['kwest'] == 17) 
	{
		echo "<center><b style='color:#ff0000'>�� �������� <u>����� �9</u></b>.</center>";
		echo "������ ������ ������ ����� ��� � �������. ��������� ��� �� ����� �����, ����� ����, ��� ������ ������ �����, � ������������ �� �����, ������� ������ �� �����, ��� ��� ����� ������.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �� ����� �9' onclick='window.location.href=\"?take=18\"'></center>";
	}
	elseif ($db['kwest'] == 18) 
	{
		echo "���������� �� ��������� <b>����� �9</b>, � ����� ����� �� �������� ����� <b>���� �������� �������</b>.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �10' onclick='window.location.href=\"?take=19\"'></center>"; 
	}
	elseif ($db['kwest'] == 19) 
	{
		echo "<center><b style='color:#ff0000'>�� �������� <u>����� �10</u></b>.</center>";
		echo "��������! ������! � � ��������� �����. �� ������� � ��� ����, ����, � ���� �����������, �� � ���������! �������! 
		<br>����, ���� ������: ������ �������, ������� � �������� ������ ��� � ������, ����� ���������� ����� �����! ����� ��� ���� <b>����</b> � <b>����</b> � ������� ���...";
		echo "<br><center><input class=lbut type=button value='�������� ����� �� ����� �10' onclick='window.location.href=\"?take=20\"'></center>";
	}
	elseif ($db['kwest'] == 20) 
	{
		echo "���������� �� ��������� <b>����� �10</b>, � ����� ����� �� �������� ����� <b>������� ������ +3</b>.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �11' onclick='window.location.href=\"?take=21\"'></center>"; 
	}
	elseif ($db['kwest'] == 21) 
	{
		echo "<center><b style='color:#ff0000'>�� �������� <u>����� �11</u></b>.</center>";
		echo "����� �������������� � ������ ����������, �� ������ ����� 5 �������� �� �� ������. ��������� ��� �� ������ ���������� �� <b>\"VIP ����\"</b>. �������, ��� ��������...";
		echo "<br><center><input class=lbut type=button value='�������� ����� �� ����� �11' onclick='window.location.href=\"?take=22\"'></center>";
	}
	elseif ($db['kwest'] == 22) 
	{
		echo "���������� �� ��������� <b>����� �11</b>, � ����� ����� �� �������� ����� <b>300 ��.</b>.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �12' onclick='window.location.href=\"?take=23\"'></center>"; 
	}
	elseif ($db['kwest'] == 23) 
	{
		echo "<center><b style='color:#ff0000'>�� �������� <u>����� �12</u></b>.</center>";
		echo "������� ��� ���� ��������. �������� ��� ������� ����������� � �� ����� ������������� �������� - ������. � ���������, ������ , ����� ������� ����� ������� � ���� ���, ��������� ������ � ������ ��������� � ��������� ����� ���������� ���������.<br><br> ";
		echo "������ ����� ������ �������� ����������, �������, ������, ��������, ���������� ������������ � �� ����� �������. ������ ����� � ����� ���� �� ���� ����� �������. ��� � ����� �������� �������� ��������� ������, ��� ����� ������� ��������� ��� ����� � �����.<br><br>";
		echo "���� ������� ����� ��� ����������, ������������� � �������� ��������� ��� �������� �� ��� ��� ���� �� ������� ��.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �� ����� �12' onclick='window.location.href=\"?take=24\"'></center>";
	}
	elseif ($db['kwest'] == 24) 
	{
		echo "���������� �� ��������� <b>����� �12</b>, � ����� ����� �� �������� ����� <b>\"���������\"</b>, <b>\"������������ ����� - 1000HP\"</b> � <b>\"����� �������� ��������� x4\"</b>.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �13' onclick='window.location.href=\"?take=25\"'></center>"; 
	}
	elseif ($db['kwest'] == 25) 
	{
		echo "<center><b style='color:#ff0000'>�� �������� <u>����� �13</u></b>.</center>";
		echo "��� ������� ������������, � ����� <b>\"������ ������\"</b>, <b>\"��������� ������\"</b> � <b>\"������� �������\"</b>. <br>";
		echo "��� ���������� ���� �������� ������������� � ������� � ���������. <br>";
		echo "��������� ����� �� �������� � ��������� ���������. <br>";
		echo "������� � ����������, ������ ����� ����� ��� �������� � ����. �� ��������� �� ������... ";
		echo "<br><center><input class=lbut type=button value='�������� ����� �� ����� �13' onclick='window.location.href=\"?take=26\"'></center>";
	}
	elseif ($db['kwest'] == 26) 
	{
		//<i>����������� �������...</i>
		echo "���������� �� ��������� <b>����� �13</b>, � ����� ����� �� �������� ����� \"<u>������� ������</u>\", \"<u>������� ������</u>\" , \"<u>������� ���</u>\" , \"<u>������� �����</u>\" � \"<u>������� ������</u>\".";
		echo "<br><center><input class=lbut type=button value='�������� ����� �14' onclick='window.location.href=\"?take=27\"'></center>"; 
	}
	elseif ($db['kwest'] == 27) 
	{
		echo "<center><b style='color:#ff0000'>�� �������� <u>����� �14</u></b>.</center>";
		echo "��� ������������� ������������� ������� ������, ��� ������� ��������� ��������� � ��������� <b>\"�������� ����\"</b> , \"<b>���������� ����</b>\" � \"<b>�������� ����</b>\" � ���������� 10 ����.";
		echo "����� �������� ��������� ��� �������� ��������� � ���������� ���c���� � <b>\"���������� ���������\"</b>. <br>�� ����� � ���� ����... <br>";
		echo "<br>�������� �� 10 ������.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �� ����� �14' onclick='window.location.href=\"?take=28\"'></center>";
	}
	elseif ($db['kwest'] == 28) 
	{
		//<i>����������� �������...</i>
		echo "���������� �� ��������� <b>����� �14</b>, � ����� ����� �� �������� ����� \"<u>���� ���� ������</u>\" � 50 ��. �������.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �15' onclick='window.location.href=\"?take=29\"'></center>"; 
	}
	elseif ($db['kwest'] == 29) 
	{
		echo "<center><b style='color:#ff0000'>�� �������� <u>����� �15</u></b>.</center>";
		echo "���������� ������, �� ������ ��������� <b>\"������������ �����\"</b>, <b>\"������ ������\"</b>, <b>\"������������ �����\"</b> � <b>\"������������ ������\"</b> � ���������� 5 ����.<br>";
		echo "��� ����� ��� �������� ����������� � <b>\"���������� ���������\"</b> � ���� ������������ �� �� ���������� ����. ������ �������������...<br>";
		echo "<br>�������� �� 5 ������.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �� ����� �15' onclick='window.location.href=\"?take=30\"'></center>";
	}
	elseif ($db['kwest'] == 30) 
	{
		echo "���������� �� ��������� <b>����� �15</b>, � ����� ����� �� �������� ����� \"<u>500 ��.</u>\" � 100 ��. �������.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �16' onclick='window.location.href=\"?take=31\"'></center>"; 
	}
	elseif ($db['kwest'] == 31) 
	{
		echo "<center><b style='color:#ff0000'>�� �������� <u>����� �16</u></b>.</center>";
		echo "�����������! �� ��� �������� ���� �����������.<br>";
		echo "��� ������� ������������, � ����� <b>\"����� ��� ����\"</b> � ���������� 40 ����, � <b>\"��������� ����\"</b> � ���������� 10 ����.<br>";
		echo "��� ����� ��� �������� ����������� � <b>\"���������� ���������\"</b> � ���� ������������ �� �� ���������� ����. � �������, ��� �� ��������...<br>";
		echo "<br>�������� �� 10 ������.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �� ����� �16' onclick='window.location.href=\"?take=32\"'></center>";
	}
	elseif ($db['kwest'] == 32) 
	{
		echo "���������� �� ��������� <b>����� �16</b>, � ����� ����� �� �������� ����� \"<u>���� ������</u>\" � 200 ��. �������.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �17' onclick='window.location.href=\"?take=33\"'></center>"; 
	}
	elseif ($db['kwest'] == 33) 
	{
		echo "<center><b style='color:#ff0000'>�� �������� <u>����� �17</u></b>.</center>";
		echo "�� ������ ���������� �� ��� ������. �� �������, ��� ������ �� ����� ��������� � ������� ��������� ������ ������!<br>";
		echo "��� �������� ������ ����������, ����� ������� <b>\"������������ ������\"</b> � ���������� 25 ����, <b>\"������������ �����\"</b> � ���������� 30 ����, <b>\"������������ ������ ��������\"</b> � ���������� 20 ����, � <b>\"������������ �����\"</b> � ���������� 15 ���� ��� ���������� ����� �������.<br>";
		echo "<br>��������... :)";
		echo "<br><center><input class=lbut type=button value='�������� ����� �� ����� �17' onclick='window.location.href=\"?take=34\"'></center>";
	}
	elseif ($db['kwest'] == 34) 
	{
		echo "���������� �� ��������� <b>����� �17</b>, � ����� ����� �� �������� ����� <b>1000 �����</b> � <b>500 ��. �������</b>.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �18' onclick='window.location.href=\"?take=35\"'></center>"; 
	}
	elseif ($db['kwest'] == 35) 
	{
		echo "<center><b style='color:#ff0000'>�� �������� <u>����� �18</u></b>.</center>";
		echo "�� ��� ��������� ��� �� �� ������� ���� <b>������� �������� �� 150</b>";
		echo "<br><center><input class=lbut type=button value='�������� ����� �� ����� �18' onclick='window.location.href=\"?take=36\"'></center>";
	}
	elseif ($db['kwest'] == 36) 
	{
		echo "���������� �� ��������� <b>����� �18</b>, � ����� ����� �� �������� ����� <b>��� �������� ����</b>, <b>3500 �����</b> � <b>300 ��. �������</b>.";
		echo "<br><center><input class=lbut type=button value='����������� �������...' onclick='window.location.href=\"?take=37\"'></center>"; 
	}
	elseif ($db['kwest'] >36) 
	{
		//<i>����������� �������...</i>
		echo "<font color=red>���������� �� ��������� ��� ������ � ���� ����������...</font>";
	}

echo"
</td></tr>
</table>
</fieldset>";
echo"</td></tr></table>";
?>