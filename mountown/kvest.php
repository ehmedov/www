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
			history($login,"��������� ����","�� �������� 150 ��. �������",$ip,$login);
		}
		else $msg="<font color=#000000>�� �������: ��������� - ".($col-$obj[0])." ����...</font>";
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
			history($login,"��������� ����","�� �������� 140 ��. �������",$ip,$login);
		}
		else $msg="<font color=#000000>�� �������: �������� - ".($col-$obj[0])." ����...</font>";
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
			history($login,"��������� ����","�� �������� 350 ��. �������",$ip,$login);
		}
		else $msg="<font color=#000000>�� �������: ������ - ".($col-$obj[0])." ����...</font>";
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
			history($login,"��������� ����","�� �������� 200 ��. �������",$ip,$login);
		}
		else $msg="<font color=#000000>�� �������: ������ - ".($col-$obj[0])." ����...</font>";
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
			history($login,"��������� ����","�� �������� 300 ��. �������",$ip,$login);
		}
		else $msg="<font color=#000000>�� �������: �������� - ".($col-$obj[0])." ����...</font>";
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
			history($login,"��������� ����","�� �������� 70 ��. �������",$ip,$login);
		}
		else $msg="<font color=#000000>�� �������: ������� - ".($col-$obj[0])." ����...</font>";
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
			history($login,"��������� ����","�� �������� 100 ��. �������",$ip,$login);
		}
		else $msg="<font color=#000000>�� �������: ������ ���� - ".($col-$obj[0])." ����...</font>";
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
			history($login,"��������� ����","�� �������� 100 ��. �������",$ip,$login);
		}
		else $msg="<font color=#000000>�� �������: ����������� ������ - ".($col-$obj[0])." ����...</font>";
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
			history($login,"��������� ����","�� �������� 500 ��. �������",$ip,$login);
		}
		else $msg="<font color=#000000>�� �������: �������� ���� - ".($col-$obj[0])." ����...</font>";
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
			history($login,"��������� ����","�� �������� 100 ��. �������",$ip,$login);
		}
		else $msg="<font color=#000000>�� �������: ������ ������ - ".($col-$obj[0])." ����...</font>";
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
			history($login,"��������� ����","�� �������� 150 ��. �������",$ip,$login);
		}
		else $msg="<font color=#000000>�� �������: ������ ������ - ".($col-$obj[0])." ����...</font>";
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
			history($login,"��������� ����","�� �������� 500 ��. �������",$ip,$login);
		}
		else $msg="<font color=#000000>�� �������: ������ ������ - ".($col-$obj[0])." ����...</font>";
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
			history($login,"��������� ����","�� �������� 50 ��. �������",$ip,$login);
		}
		else $msg="<font color=#000000>�� �������: ������ ������ - ".($col-$obj[0])." ����...</font>";
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
			history($login,"��������� ����","�� �������� 150 ��. �������",$ip,$login);
		}
		else $msg="<font color=#000000>�� �������: ������ ���������� - ".($col-$obj[0])." ����...</font>";
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
			history($login,"��������� ����","�� �������� 1000 ��. �������",$ip,$login);
		}
		else $msg="<font color=#000000>�� �������: ���������� - ".($col-$obj[0])." ����...</font>";
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
			history($login,"��������� ����","�� �������� 250 ��. �������",$ip,$login);
		}
		else $msg="<font color=#000000>�� �������: ������ ������� - ".($col-$obj[0])." ����...</font>";
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
			history($login,"��������� ����","�� �������� 150 ��. �������",$ip,$login);
		}
		else $msg="<font color=#000000>�� �������: ������ �������� - ".($col-$obj[0])." ����...</font>";
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
			history($login,"��������� ����","�� �������� 1000 ��. �������",$ip,$login);
		}
		else $msg="<font color=#000000>�� �������: ��� �������� ������ - ".($col-$obj[0])." ����...</font>";
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
			history($login,"��������� ����","�� �������� 150 ��. �������",$ip,$login);
		}
		else $msg="<font color=#000000>�� �������: ������ ������� - ".($col-$obj[0])." ����...</font>";
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
			history($login,"��������� ����","�� �������� 200 ��. �������",$ip,$login);
		}
		else $msg="<font color=#000000>�� �������: ���� ������� - ".($col-$obj[0])." ����...</font>";
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
			history($login,"��������� ����","�� �������� 200 ��. �������",$ip,$login);
		}
		else $msg="<font color=#000000>�� �������: ����� ��������� - ".($col-$obj[0])." ����...</font>";
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
			history($login,"��������� ����","�� �������� 500 ��. �������",$ip,$login);
		}
		else $msg="<font color=#000000>�� �������: ����� ����� - ".($col-$obj[0])." ����...</font>";
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
			history($login,"��������� ����","�� �������� 300 ��. �������",$ip,$login);
		}
		else $msg="<font color=#000000>�� �������: ������������� ���� - ".($col-$obj[0])." ����...</font>";
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
			history($login,"��������� ����","�� �������� 2000 ��. �������",$ip,$login);
		}
		else $msg="<font color=#000000>�� �������: ����� ���������� ����� - ".($col-$obj[0])." ����...</font>";
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
			history($login,"��������� ����","�� �������� 500 ��. �������",$ip,$login);
		}
		else $msg="<font color=#000000>�� �������: ���� ������� - ".($col-$obj[0])." ����...</font>";
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
			history($login,"��������� ����","�� �������� 300 ��. �������",$ip,$login);
		}
		else $msg="<font color=#000000>�� �������: ������� ��� - ".($col-$obj[0])." ����...</font>";
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
			history($login,"��������� ����","�� �������� 500 ��. �������",$ip,$login);
		}
		else $msg="<font color=#000000>�� �������: ������ ����� - ".($col-$obj[0])." ����...</font>";
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
			history($login,"��������� ����","�� �������� 500 ��. �������",$ip,$login);
		}
		else $msg="<font color=#000000>�� �������: ������ ������ - ".($col-$obj[0])." ����...</font>";
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
			history($login,"��������� ����","�� �������� 900 ��. �������",$ip,$login);
		}
		else $msg="<font color=#000000>�� �������: �������� ���� - ".($col-$obj[0])." ����...</font>";
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
			history($login,"��������� ����","�� �������� 1000 ��. �������",$ip,$login);
		}
		else $msg="<font color=#000000>�� �������: ���� ������� - ".($col-$obj[0])." ����...</font>";
	}
	/*else if ($db['kwest'] == 54)
	{
		$msg="����������� �������...";
	}*/
}
echo"<table width=100% cellspacing=0 cellpadding=3 border=0><tr><td valign=top>";
	echo"<table width=100% cellspacing=0 cellpadding=3 border=0><tr><td>";
	echo "<center><b style='color:#ff0000'>&nbsp;$msg</b></center>";
	echo "<fieldset style='WIDTH: 100%; border:1px ridge;'>";
	echo "<legend><b>�������� �������</b></legend>
	<table width=100% cellspacing=0 cellpadding=5><tr><td align='justify'>";
	if ($db['kwest'] == 0)
	{
		echo "����������� ����, ������ ������! 
		<br>��� �������, ��� �� ���������� �������� ������� �������� ������ ��������� �������... 
		����� �� ��� �� �������� �� ������ ����, �� � �� ������������� ������� �� ��������� ���� �� ������ ������. 
		� ���� ��� ������������ � �����. <br><br>";
		echo "<center><input class=lbut type=button value='�������� ����� �1!' onclick='window.location.href=\"?take=37\"'></center>"; 
	}
	else if ($db['kwest'] == 1)
	{
		echo "��� ���������� ����� <b>\"���������\"</b> � ���������� 10 ����. 
		��� ����� �������� �������� �� ���� ���� � <b>\"��������� ����\"</b>. ��������� �������!
		<br>�� ��������: 150 ��. �������.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �� ����� �1' onclick='window.location.href=\"?take=38\"'></center>";
	}
	else if ($db['kwest'] == 2) 
	{
		echo "���������� �� ��������� <b>����� �1</b>, � ����� ����� �� �������� ����� <b>150 ��. �������</b>.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �2' onclick='window.location.href=\"?take=39\"'></center>"; 
	}
	else if ($db['kwest'] == 3)
	{
		echo "��������� ����, ��� ������� �������� <b>\"��������\"</b> � ���������� 20 ����. \"���������\" �� � �������� � <b>\"��������� ����\"</b>. 
		�� ��������� �� ������...		
		<br>�� ��������: 140 ��. �������.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �� ����� �2' onclick='window.location.href=\"?take=40\"'></center>";
	}
	else if ($db['kwest'] == 4) 
	{
		echo "���������� �� ��������� <b>����� �2</b>, � ����� ����� �� �������� ����� <b>140 ��. �������</b>.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �3' onclick='window.location.href=\"?take=41\"'></center>"; 
	}
	else if ($db['kwest'] == 5)
	{
		echo "���������� �����, �� ������ ���������� �����������, ����� ������� <b>\"������\"</b> � ���������� 15 ����. 
		�������� ������ �� � �������� � <b>\"��������� ����\"</b>. 
		������ �������������...
		<br>�� ��������: 350 ��. �������.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �� ����� �3' onclick='window.location.href=\"?take=42\"'></center>";
	}
	else if ($db['kwest'] == 6) 
	{
		echo "���������� �� ��������� <b>����� �3</b>, � ����� ����� �� �������� ����� <b>350 ��. �������</b>.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �4' onclick='window.location.href=\"?take=43\"'></center>"; 
	}
	else if ($db['kwest'] == 7)
	{
		echo "��� ������� ������������, � ����� <b>\"������\"</b> � ���������� 25 ����. 
		��� ���������� ���� �������� ������������� � ������� <b>\"��������� ����\"</b>. 
		<br>�� ��������: 200 ��. �������.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �� ����� �4' onclick='window.location.href=\"?take=44\"'></center>";
	}
	else if ($db['kwest'] == 8) 
	{
		echo "���������� �� ��������� <b>����� �4</b>, � ����� ����� �� �������� ����� <b>200 ��. �������</b>.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �5' onclick='window.location.href=\"?take=45\"'></center>"; 
	}
	else if ($db['kwest'] == 9)
	{
		echo "������� ���� ��������, �� ������ ���������� �����������, ����� ����� <b>\"��������\"</b> � ���������� 30 ����. 
		������ ���� ������ �������� �� <b>\"��������� ����\"</b> �� ������� ����� ��, ��� �����. ���� � ��������... 
		<br>�� ��������: 300 ��. �������.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �� ����� �5' onclick='window.location.href=\"?take=46\"'></center>";
	}
	else if ($db['kwest'] == 10) 
	{
		echo "���������� �� ��������� <b>����� �5</b>, � ����� ����� �� �������� ����� <b>200 ��. �������</b>.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �6' onclick='window.location.href=\"?take=47\"'></center>"; 
	}
	else if ($db['kwest'] == 11)
	{
		echo "����� �������� ���� ����� � �����������, ��� ������� �������� <b>\"�������\"</b> � ���������� 30 ����. 
		��� ����� ��� ����������� ����� � �������� �� ���� ������� �������� � <b>\"��������� ����\"</b>. � �������, ��� �� ��������...  
		<br>�� ��������: 70 ��. �������.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �� ����� �6' onclick='window.location.href=\"?take=48\"'></center>";
	}
	else if ($db['kwest'] == 12) 
	{
		echo "���������� �� ��������� <b>����� �6</b>, � ����� ����� �� �������� ����� <b>70 ��. �������</b>.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �7' onclick='window.location.href=\"?take=49\"'></center>"; 
	}
	else if ($db['kwest'] == 13)
	{
		echo "���������� �����, �� ������ ���������� �����������, ����� ������� <b>\"������ ����\"</b> � ���������� 45 ����. 
		�������� ������ �� � �������� � <b>\"��������� ����\"</b>. ������ �������������...  
		<br>�� ��������: 100 ��. �������.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �� ����� �7' onclick='window.location.href=\"?take=50\"'></center>";
	}
	else if ($db['kwest'] == 14) 
	{
		echo "���������� �� ��������� <b>����� �7</b>, � ����� ����� �� �������� ����� <b>100 ��. �������</b>.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �8' onclick='window.location.href=\"?take=51\"'></center>"; 
	}
	else if ($db['kwest'] == 15)
	{
		echo "����� ���-�� �������, ������� ����� ���-�� �����..., ��� ���������� ����� <b>\"����������� ������\"</b> � ���������� 50 ����. 
		�������� ����� �� ���� ������� �������� � <b>\"��������� ����\"</b>. ��������...  
		<br>�� ��������: 100 ��. �������.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �� ����� �8' onclick='window.location.href=\"?take=52\"'></center>";
	}
	else if ($db['kwest'] == 16) 
	{
		echo "���������� �� ��������� <b>����� �8</b>, � ����� ����� �� �������� ����� <b>100 ��. �������</b>.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �9' onclick='window.location.href=\"?take=53\"'></center>"; 
	}
	else if ($db['kwest'] == 17)
	{
		echo "��� ������������� ������������� ������� ������, ��� ������� ��������� ��������� � ��������� <b>\"�������� ����\"</b> � ���������� 50 ����. 
		����� �������� ��������� ��� �������� ��������� � ���������� ���c���� � <b>\"��������� ����\"</b>. �� ����� � ���� ����... 
		<br>�� ��������: 500 ��. �������.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �� ����� �9' onclick='window.location.href=\"?take=54\"'></center>";
	}
	else if ($db['kwest'] == 18) 
	{
		echo "���������� �� ��������� <b>����� �9</b>, � ����� ����� �� �������� ����� <b>500 ��. �������</b>.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �10' onclick='window.location.href=\"?take=55\"'></center>"; 
	}
	else if ($db['kwest'] == 19)
	{
		echo "����� �������� ���� ����� � �����������, ��� ������� �������� <b>\"������ ������\"</b> � ���������� 30 ����. 
		��� ����� ��� ����������� ����� � �������� �� ���� ������� �������� � <b>\"��������� ����\"</b>. � �������, ��� �� ��������...
		<br>�� ��������: 100 ��. �������.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �� ����� �10' onclick='window.location.href=\"?take=56\"'></center>";
	}
	else if ($db['kwest'] == 20) 
	{
		echo "���������� �� ��������� <b>����� �10</b>, � ����� ����� �� �������� ����� <b>100 ��. �������</b>.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �11' onclick='window.location.href=\"?take=57\"'></center>"; 
	}
	else if ($db['kwest'] == 21)
	{
		echo "����� ���-�� �������, ������� ����� ���-�� �����..., ��� ���������� ����� <b>\"������ ������\"</b> � ���������� 60 ����. 
		�������� ����� �� ���� ������� �������� � <b>\"��������� ����\"</b>. ��������...
		<br>�� ��������: 150 ��. �������.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �� ����� �11' onclick='window.location.href=\"?take=58\"'></center>";
	}
	else if ($db['kwest'] == 22) 
	{
		echo "���������� �� ��������� <b>����� �11</b>, � ����� ����� �� �������� ����� <b>150 ��. �������</b>.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �12' onclick='window.location.href=\"?take=59\"'></center>"; 
	}
	else if ($db['kwest'] == 23)
	{
		echo "���������� �����, �� ������ ���������� �����������, ����� ������� <b>\"������ ������\"</b> � ���������� 35 ����. 
		�������� ������ �� � �������� � <b>\"��������� ����\"</b>. ������ �������������...  
		<br>�� ��������: 500 ��. �������.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �� ����� �12' onclick='window.location.href=\"?take=60\"'></center>";
	}
	else if ($db['kwest'] == 24) 
	{
		echo "���������� �� ��������� <b>����� �12</b>, � ����� ����� �� �������� ����� <b>500 ��. �������</b>.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �13' onclick='window.location.href=\"?take=61\"'></center>"; 
	}
	else if ($db['kwest'] == 25)
	{
		echo "�� ��� ������ ���� ����..��� ���� ����� �����..������ �� ������ �����..�� ����� �������� ������ �� ���� �� ��� ���������  ��������� 
		<b>\"������ ������\"</b> � ���������� 20 ����. 
		����������� ���� ����������� �������� ���� ���� � <b>\"��������� ����\"</b>.
		<br>�� ��������: 50 ��. �������.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �� ����� �13' onclick='window.location.href=\"?take=62\"'></center>";
	}
	else if ($db['kwest'] == 26) 
	{
		echo "���������� �� ��������� <b>����� �13</b>, � ����� ����� �� �������� ����� <b>50 ��. �������</b>.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �14' onclick='window.location.href=\"?take=63\"'></center>"; 
	}
	else if ($db['kwest'] == 27)
	{
		echo "������������ ������ �� ������ ������� ��� ��������� ���������  ��������� � ��������� � ������  
		<b>\"������ ����������\"</b> � ���������� 45 ����. 
		�� ����������� ���� �����..������������ ������������ ����� :).
		<br>�� ��������: 150 ��. �������.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �� ����� �14' onclick='window.location.href=\"?take=64\"'></center>";
	}
	else if ($db['kwest'] == 28) 
	{
		echo "���������� �� ��������� <b>����� �14</b>, � ����� ����� �� �������� ����� <b>150 ��. �������</b>.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �15' onclick='window.location.href=\"?take=65\"'></center>"; 
	}
	else if ($db['kwest'] == 29)
	{
		echo "��� ������ �������, ������� �� �������� ������, ������ ����� ��-�����, � ��� �����������,������� ���� ����� �������,�������,��� ����� ���� �� ������� ��� ������, ����� ���.
		� ����� ����� ��� ���� �������, ������� ��� � ���������� ����� ��� �������� ��������... ����� ����, ��� ���� ������ ��� ����:
		<b>\"����������\"</b> (<font color=red>��������</font>) � ���������� <b>10 ����</b>. 
		������ ������� �� ���, � ����� ���� ������� ���, � ����� �������!
		<br>�� ��������: <b>1000 ��.</b> �������.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �� ����� �15' onclick='window.location.href=\"?take=66\"'></center>";
	}
	else if ($db['kwest'] == 30) 
	{
		echo "���������� �� ��������� <b>����� �15</b>, � ����� ����� �� �������� ����� <b>1000 ��. �������</b>.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �16' onclick='window.location.href=\"?take=67\"'></center>"; 
	}
	else if ($db['kwest'] == 31)
	{
		echo "��� ���� ���� :) ������... ���������!, ���� ���� �����, ��� ��� ���� ������, ����� � ���� ����� �������, ����� ���� ������� ��������� �������� ,
		<br>��� ..., �� ����� �� ����� ������� ������ ��� ����� ���� ����� ���� � ������� ��� ���� ��������:
		<b>\"������ �������\"</b> � ���������� 30 ����. 
		��� ��� ������ ��� �����,���� ����� ����!
		<br>�� ��������: 250 ��. �������.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �� ����� �16' onclick='window.location.href=\"?take=68\"'></center>";
	}
	else if ($db['kwest'] == 32) 
	{
		echo "���������� �� ��������� <b>����� �16</b>, � ����� ����� �� �������� ����� <b>250 ��. �������</b>.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �17' onclick='window.location.href=\"?take=69\"'></center>"; 
	}
	else if ($db['kwest'] == 33)
	{
		echo "������� ������� ������� <b>$login</b>! � ���������� ���������� �����, ��� � ��� ����� ������ ����� �������, ��� ��� �������, ������� ����� �����! 
		� �����, �� �� ����� �������� ���... �� ��� ������� �������, � ����� ��� ������ ��� ��������:
		<b>\"������ ��������\"</b> � ���������� 50 ����. 
		<br>�� ��������: 150 ��. �������.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �� ����� �17' onclick='window.location.href=\"?take=70\"'></center>";
	}
	else if ($db['kwest'] == 34) 
	{
		echo "���������� �� ��������� <b>����� �17</b>, � ����� ����� �� �������� ����� <b>150 ��. �������</b>.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �18' onclick='window.location.href=\"?take=71\"'></center>"; 
	}
	else if ($db['kwest'] == 35)
	{
		echo "������� ���� ��������, �� ������ ���������� �����������, ����� ����� <b>\"��� �������� ������\"</b> � ���������� 10 ����. 
		������ ���� ������ �������� �� ��������� ���� �� ������� ����� ��, ��� �����. ���� � ��������... 
		<br>�� ��������: 1000 ��. �������.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �� ����� �18' onclick='window.location.href=\"?take=70\"'></center>";
	}
	else if ($db['kwest'] == 36) 
	{
		echo "���������� �� ��������� <b>����� �18</b>, � ����� ����� �� �������� ����� <b>1000 ��. �������</b>.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �19' onclick='window.location.href=\"?take=71\"'></center>"; 
	}
	else if ($db['kwest'] == 37)
	{
		echo "������� ���� ��������, �� ������ ���������� �����������, ����� ����� <b>\"������ �������\"</b> � ���������� 50 ����. 
		������ ���� ������ �������� �� ��������� ���� �� ������� ����� ��, ��� �����. ���� � ��������... 
		<br>�� ��������: 150 ��. �������.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �� ����� �19' onclick='window.location.href=\"?take=70\"'></center>";
	}
	else if ($db['kwest'] == 38) 
	{
		echo "���������� �� ��������� <b>����� �19</b>, � ����� ����� �� �������� ����� <b>150 ��. �������</b>.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �20' onclick='window.location.href=\"?take=71\"'></center>"; 
	}
	else if ($db['kwest'] == 39)
	{
		echo "������� ���� ��������, �� ������ ���������� �����������, ����� ����� <b>\"���� �������\"</b> � ���������� 60 ����. 
		������ ���� ������ �������� �� ��������� ���� �� ������� ����� ��, ��� �����. ���� � ��������... 
		<br>�� ��������: 200 ��. �������.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �� ����� �20' onclick='window.location.href=\"?take=70\"'></center>";
	}
	else if ($db['kwest'] == 40) 
	{
		echo "���������� �� ��������� <b>����� �20</b>, � ����� ����� �� �������� ����� <b>200 ��. �������</b>.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �21' onclick='window.location.href=\"?take=71\"'></center>"; 
	}
	else if ($db['kwest'] == 41)
	{
		echo "������� ������� ������� <b>$login</b>! 
		� �����, �� �� ����� �������� ���... �� ��� ������ ��� ��������:
		<b>\"����� ���������\"</b> � ���������� 50 ����. 
		<br>�� ��������: 200 ��. �������.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �� ����� �21' onclick='window.location.href=\"?take=72\"'></center>";
	}
	else if ($db['kwest'] == 42) 
	{
		echo "���������� �� ��������� <b>����� �21</b>, � ����� ����� �� �������� ����� <b>200 ��. �������</b>.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �22' onclick='window.location.href=\"?take=73\"'></center>"; 
	}
	else if ($db['kwest'] == 43)
	{
		echo "������� ������� ������� <b>$login</b>! 
		� �����, �� �� ����� �������� ���... �� ��� ������ ��� ��������:
		<b>\"����� �����\"</b> � ���������� 45 ����. 
		<br>�� ��������: 500 ��. �������.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �� ����� �22' onclick='window.location.href=\"?take=72\"'></center>";
	}
	else if ($db['kwest'] == 44) 
	{
		echo "���������� �� ��������� <b>����� �22</b>, � ����� ����� �� �������� ����� <b>500 ��. �������</b>.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �23' onclick='window.location.href=\"?take=73\"'></center>"; 
	}
	else if ($db['kwest'] == 45)
	{
		echo "��� ���������� ����� <b>\"������������� ����\"</b> � ���������� 20 ����. 
		��� ����� �������� �������� �� ���� ���� � <b>\"��������� ����\"</b>. ��������� �������!
		<br>�� ��������: 300 ��. �������.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �� ����� �23' onclick='window.location.href=\"?take=38\"'></center>";
	}
	else if ($db['kwest'] == 46) 
	{
		echo "���������� �� ��������� <b>����� �23</b>, � ����� ����� �� �������� ����� <b>300 ��. �������</b>.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �24' onclick='window.location.href=\"?take=73\"'></center>"; 
	}
	else if ($db['kwest'] == 47)
	{
		echo "������� ���� ��������, �� ������ ���������� �����������, ����� ����� <b>\"����� ���������� �����\"</b> � ���������� 10 ����. 
		������ ���� ������ �������� �� <b>\"��������� ����\"</b> �� ������� ����� ��, ��� �����. ���� � ��������... 
		<br>�� ��������: 2000 ��. �������.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �� ����� �24' onclick='window.location.href=\"?take=46\"'></center>";
	}
	else if ($db['kwest'] == 48) 
	{
		echo "���������� �� ��������� <b>����� �24</b>, � ����� ����� �� �������� ����� <b>2000 ��. �������</b>.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �25' onclick='window.location.href=\"?take=73\"'></center>"; 
	}
	else if ($db['kwest'] == 49)
	{
		echo "����� ���-�� �������, ������� ����� ���-�� �����..., ��� ���������� ����� <b>\"���� �������\"</b> � ���������� 30 ����. 
		�������� ����� �� ���� ������� �������� � <b>\"��������� ����\"</b>. ��������...
		<br>�� ��������: 500 ��. �������.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �� ����� �25' onclick='window.location.href=\"?take=58\"'></center>";
	}
	else if ($db['kwest'] == 50) 
	{
		echo "���������� �� ��������� <b>����� �25</b>, � ����� ����� �� �������� ����� <b>500 ��. �������</b>.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �26' onclick='window.location.href=\"?take=73\"'></center>"; 
	}
	else if ($db['kwest'] == 51)
	{
		echo "������� ������� ������� <b>$login</b>! 
		� �����, �� �� ����� �������� ���... �� ��� ������ ��� ��������:
		<b>\"������� ���\"</b> � ���������� 30 ����. 
		<br>�� ��������: 300 ��. �������.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �� ����� �26' onclick='window.location.href=\"?take=72\"'></center>";
	}
	else if ($db['kwest'] == 52) 
	{
		echo "���������� �� ��������� <b>����� �26</b>, � ����� ����� �� �������� ����� <b>300 ��. �������</b>.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �27' onclick='window.location.href=\"?take=73\"'></center>"; 
	}
	else if ($db['kwest'] == 53)
	{
		echo "������� ���� ��������, �� ������ ���������� �����������, ����� ����� <b>\"������ �����\"</b> � ���������� 40 ����. 
		������ ���� ������ �������� �� ��������� ���� �� ������� ����� ��, ��� �����. ���� � ��������... 
		<br>�� ��������: 500 ��. �������.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �� ����� �27' onclick='window.location.href=\"?take=70\"'></center>";
	}
	else if ($db['kwest'] == 54) 
	{
		echo "���������� �� ��������� <b>����� �27</b>, � ����� ����� �� �������� ����� <b>500 ��. �������</b>.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �28' onclick='window.location.href=\"?take=73\"'></center>"; 
	}
	else if ($db['kwest'] == 55)
	{
		echo "��� ���������� ����� <b>\"������ ������\"</b> � ���������� 50 ����. 
		��� ����� �������� �������� �� ���� ���� � <b>\"��������� ����\"</b>. ��������� �������!
		<br>�� ��������: 500 ��. �������.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �� ����� �28' onclick='window.location.href=\"?take=38\"'></center>";
	}
	else if ($db['kwest'] == 56) 
	{
		echo "���������� �� ��������� <b>����� �28</b>, � ����� ����� �� �������� ����� <b>500 ��. �������</b>.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �29' onclick='window.location.href=\"?take=73\"'></center>"; 
	}
	else if ($db['kwest'] == 57)
	{
		echo "��� ���� ���� :) ������... ���������!, ���� ���� �����, ��� ��� ���� ������, ����� � ���� ����� �������, ����� ���� ������� ��������� �������� ,
		<br>��� ..., �� ����� �� ����� ������� ������ ��� ����� ���� ����� ���� � ������� ��� ���� ��������:
		<b>\"�������� ����\"</b> � ���������� 35 ����. 
		��� ��� ������ ��� �����,���� ����� ����!
		<br>�� ��������: 900 ��. �������.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �� ����� �29' onclick='window.location.href=\"?take=68\"'></center>";
	}
	else if ($db['kwest'] == 58)
	{
		echo "���������� �� ��������� <b>����� �29</b>, � ����� ����� �� �������� ����� <b>900 ��. �������</b>.";
		echo "<br><center><input class=lbut type=button value='�������� ����� �30' onclick='window.location.href=\"?take=73\"'></center>"; 
	}
	else if ($db['kwest'] == 59)
	{
		echo "������� ������� ������� <b>$login</b>! 
		� �����, �� �� ����� �������� ���... �� ��� ������ ��� ��������:
		<b>\"���� �������\"</b> � ���������� 25 ����. 
		<br>�� ��������: 1000 ��. ������� + 1000 ����";
		echo "<br><center><input class=lbut type=button value='�������� ����� �� ����� �30' onclick='window.location.href=\"?take=72\"'></center>";
	}
	else if ($db['kwest'] == 60)
	{
		echo "���������� �� ��������� <b>����� �30</b>, � ����� ����� �� �������� ����� <b>1000 ��. ������� + 1000 ���� � ����� ������ ��������� 3-�� ������</b>.";
		echo "<br><center><b style='color:red'>���������� �� ��������� ��� ������ � ���� ����������...</b></center>"; 
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
				history($login,'������� �����������',"�� $price_stat ��.",$db['remote_ip'],"�������");
				$db["naqrada"]=$db["naqrada"]-$price_stat;
				$db["add_ups"]=$db["add_ups"]+1;
				echo "<font color=red>�� ������ �������� $price_stat ��. �� 1 �����������</font>";
			}
			else echo "<font color=red>� ��� ������������ �������!</font>";
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
				history($login,'������� ������',"�� $price_umenie ��.",$db['remote_ip'],"�������");
				$db["naqrada"]=$db["naqrada"]-$price_umenie;
				$db["add_umenie"]=$db["add_umenie"]+1;
				echo "<font color=red>�� ������ �������� $price_umenie ��. �� 1 ������</font>";
			}
			else echo "<font color=red>� ��� ������������ �������!</font>";
		}
	}
	else if ($_GET["buy"]=="money")
	{
		if ($db["naqrada"]>=100)
		{
			mysql_query("UPDATE users SET money=money+1000,naqrada=naqrada-100 WHERE login='".$login."'");
			history($login,'������� ��.',"1000.00 ��. �� 100 ��.",$db['remote_ip'],"�������");
			$db["naqrada"]=$db["naqrada"]-100;
			echo "<font color=red>�� ������ �������� 100 ��. �� 1000.00 ��.</font>";
		}
		else echo "<font color=red>� ��� ������������ �������!</font>";
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
	<FIELDSET style='WIDTH: 100%; border:1px ridge;'><LEGEND> �������: <B><?=$db["naqrada"]?> ��.</B> </LEGEND>
	<TABLE>
	<TR><TD>����������� (��� <?=$count_stats;?>)</TD><TD style='padding-left: 10'>�� <?=$price_stat?> ��.</TD><TD style='padding-left: 10'>
	<INPUT type='button' value='������' onclick="if (confirm('������: �����������?\n\n����� �����������, �� ������� ��������� �������������� ���������.\n��������, ����� ��������� ����.')) {location='?buy=ups'}"></TD></TR>

	<TR><TD>������ (��� <?=$count_umenie;?>)</TD><TD style='padding-left: 10'>�� <?=$price_umenie?> ��.</TD><TD style='padding-left: 10'>
	<INPUT type='button' value='������' onclick="if (confirm('������: ������?\n\n������ ��� ����������� ������������ ���� �������� ����, ������, ����� � �.�.')) {location='?buy=umenie'}"></TD></TR>

	<TR><TD>������ (1000.00 ��.)</TD><TD style='padding-left: 10'>�� 100 ��.</TD><TD style='padding-left: 10'>
	<INPUT type='button' value='������' onclick="if (confirm('������: ������ (100 ��.)?\n\n������� ����� �������� ������������ ���������.')) {location='?buy=money'}"></TD></TR>
	</TABLE>
	</FIELDSET>
	<BR>
	<?
	echo "</td>
	<td valign=top align=right width=300>
		<input type=button value='���������' onclick=\"document.location='main.php?act=go&level=crypt_go'\">
		<input type=button value='��������' onClick=\"location.href='?act=none'\"><br>
	</td>
	</tr></table>";
?>