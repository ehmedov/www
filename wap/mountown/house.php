<?
$login=$_SESSION["login"];
//--------------------------------ARENDA----------------------------------------------
if ($_GET["action"]=="arenda")
{
	$result=mysql_query("SELECT * FROM house WHERE login='".$login."'");
	if (!mysql_num_rows($result))
	{
		if ($_GET["type"]==1)
		{	
			if ($db["money"]>=30)
			{	
				$date=date("d.m.y H:i");
				$time=time()+7*24*3600;
				mysql_query("LOCK TABLES house WRITE");
				mysql_query("INSERT into house (login,time,date,type) values('".$login."', '".$time."','".$date."','1')");
				mysql_query("UNLOCK TABLES");
				mysql_query("UPDATE users SET money=money-30 WHERE login='".$login."'");
				$db["money"]=$db["money"]-30;
				$msg="�� ���������� '����� � ���������' �� 30.00 ��.<br/>";
			}
			else $msg="������������ �����.<br/>";
		}
		else if ($_GET["type"]==2)
		{
			if ($db["platina"]>=5)
			{	
				$date=date("d.m.y H:i");
				$time=time()+30*24*3600;
				mysql_query("LOCK TABLES house WRITE");
				mysql_query("INSERT into house (login,time,date,type) values('".$login."', '".$time."','".$date."','2')");
				mysql_query("UNLOCK TABLES");
				mysql_query("UPDATE users SET platina=platina-5 WHERE login='".$login."'");
				$db["platina"]=$db["platina"]-5;
				$msg="�� ���������� '����� � ���������' �� 5.00 ��.<br/>";
			}
			else $msg="������������ �����.<br/>";
		}
		else if ($_GET["type"]==3)
		{
			if ($db["platina"]>=20)
			{	
				$date=date("d.m.y H:i");
				$time=time()+30*24*3600;
				mysql_query("LOCK TABLES house WRITE");
				mysql_query("INSERT into house (login,time,date,type) values('".$login."', '".$time."','".$date."','3')");
				mysql_query("UNLOCK TABLES");
				mysql_query("UPDATE users SET platina=platina-20 WHERE login='".$login."'");
				$db["platina"]=$db["platina"]-20;
				$msg="�� ���������� '����� � ���������' �� 20.00 ��.<br/>";
			}
			else $msg="������������ �����.<br/>";
		}
	}
}
//--------------------------------Close Arenda----------------------------------------------
if ($_GET["closearenda"] && !$db["son"])
{
	$result=mysql_query("SELECT * FROM house WHERE login='".$login."' limit 1");
	if (mysql_num_rows($result))
	{
		mysql_query ("DELETE FROM house WHERE login='".$login."'");
	}
}
//---------------------SLEEP---------------------------------------------------------
if ($_GET["to_sleep"] && !$db["son"])
{
	$result=mysql_query("SELECT * FROM house WHERE login='".$login."' limit 1");
	if (mysql_num_rows($result))
	{
		$res=mysql_fetch_array($result);
		if ($res["time"]>time())
		{
			mysql_query("UPDATE users SET son=1 WHERE login='".$login."'");
			mysql_query("UPDATE effects SET add_time=end_time-".time()." WHERE user_id=".$db["id"]);
			$db["son"]=1;
		}
		else
		{
			$msg="����� ����������...<br/>";
		}
	}
}
//--------------------------AWAKE----------------------------------------------------
if ($_GET["to_awake"] && $db["son"])
{
	$result=mysql_query("SELECT * FROM house WHERE login='".$login."' limit 1");
	if (mysql_num_rows($result))
	{
		$res=mysql_fetch_array($result);
	
		mysql_query("UPDATE users SET son=0 WHERE login='".$login."'");
		mysql_query("UPDATE effects SET end_time= add_time+".time().",add_time=0 WHERE user_id=".$db["id"]);
		$db["son"]=0;
	}
}
//--------------------------UP DATE----------------------------------------------------
if ($_GET["up_date"])
{
	$result=mysql_query("SELECT * FROM house WHERE login='".$login."' limit 1");
	if (mysql_num_rows($result))
	{
		$res=mysql_fetch_array($result);
		if ($res["time"]<time())
		{
			if ($res["type"]==1)
			{
				if ($db["money"]>=30)
				{
					$time=time()+7*24*3600;
					mysql_query("UPDATE users SET money=money-30 WHERE login='".$login."'");
					mysql_query("UPDATE house SET time='".$time."' WHERE login='".$login."'");
					$db["money"]=$db["money"]-30;
				}
				else $msg="������������ �����.<br/>";
			}
			else if ($res["type"]==2)
			{
				if ($db["platina"]>=5)
				{
					$time=time()+30*24*3600;
					mysql_query("UPDATE users SET platina=platina-5 WHERE login='".$login."'");
					mysql_query("UPDATE house SET time='".$time."' WHERE login='".$login."'");
					$db["platina"]=$db["platina"]-5;
				}
			}
			else if ($res["type"]==3)
			{
				if ($db["platina"]>=20)
				{
					$time=time()+30*24*3600;
					mysql_query("UPDATE users SET platina=platina-20 WHERE login='".$login."'");
					mysql_query("UPDATE house SET time='".$time."' WHERE login='".$login."'");
					$db["platina"]=$db["platina"]-20;
				}
			}
		}
	}
}
//--------------------------Zapiska----------------------------------------------------
if ($_POST["savenotes"])
{
	$notes=$_POST["notes"];
	$result=mysql_query("SELECT * FROM house WHERE login='".$login."' limit 1");
	if (mysql_num_rows($result))
	{
		mysql_query("UPDATE house SET zapiska='".$notes."' WHERE login='".$login."'");
	}
}
//--------------------------Pet UnWear----------------------------------------------------
if ($_GET["pet_unwear"])
{
	$_GET["pet_unwear"]=(int)$_GET["pet_unwear"];
	$pet_unwear=mysql_fetch_array(mysql_query("SELECT * FROM house WHERE login='".$login."'"));
	if ($pet_unwear["type"]==3)
	{
		if (!$pet_unwear["zver"])
		{	
			$is_sleep=mysql_fetch_array(mysql_query("SELECT count(*) FROM zver WHERE id=".$_GET["pet_unwear"]." and owner=".$db["id"]." and sleep=0"));
			if ($is_sleep[0])
			{	
				mysql_query("UPDATE house SET zver='".$_GET["pet_unwear"]."' WHERE login='".$login."'");
				mysql_query("UPDATE zver SET sleep=1 WHERE id=".$_GET["pet_unwear"]);
			}
		}
		else
		{
			$msg="��� ����...<br/>";
		}
	}
}
//--------------------------Pet Wear----------------------------------------------------
if ($_GET["pet_wear"])
{
	$pet_wear=mysql_fetch_array(mysql_query("SELECT * FROM house WHERE login='".$login."'"));
	if ($pet_wear["type"]==3)
	{
		if ($pet_wear["zver"])
		{	
			$is_sleep=mysql_fetch_array(mysql_query("SELECT * FROM zver WHERE owner=".$db["id"]." and sleep=0"));
			if (!$is_sleep)
			{	
				mysql_query("UPDATE house SET zver='' WHERE login='".$login."'");
				mysql_query("UPDATE zver SET sleep=0 WHERE id=".$pet_wear["zver"]);
			}
			else 
			{
				mysql_query("UPDATE house SET zver='".$is_sleep["id"]."' WHERE login='".$login."'");
				mysql_query("UPDATE zver SET sleep=1 WHERE id=".$is_sleep["id"]);
				mysql_query("UPDATE zver SET sleep=0 WHERE id=".$pet_wear["zver"]);
			}
		}
	}
}
//------------------------------------------------------------------------------
$platina = sprintf ("%01.2f", $db["platina"]);
$money = sprintf ("%01.2f", $db["money"]);
$naqrada = sprintf ("%01.2f", $db["naqrada"]);
echo "<font color=red>".$msg."</font>";
?>
<b>���������</b> [<a href="main.php?act=go&level=okraina">����� �� �����</a>]<br/>
� ��� � �������: <b><?echo $money;?></b> ��. <b><?echo $platina;?></b> ��. <b><?echo $naqrada;?></b> ��.<br/>
<div id="cnt" class="content">
<?
	$result=mysql_query("SELECT * FROM house WHERE login='".$login."' limit 1");
	if (!mysql_num_rows($result))
	{
		echo "<div class=\"sep1\"></div><div class=\"sep2\"></div>";
		echo "���������� ����� � ���������<br/>
		����: <b>30.00 ��.</b> � ������<br/>
 		&bull; �����<br/>
		<a href='?action=arenda&type=1'>����� ������� �� 30.00 ��.</a>";
		
		echo "<div class=\"sep1\"></div><div class=\"sep2\"></div>";
		
		echo "���������� ����� � ���������<br/>
		����: <b>5.00 ��.</b> � �����<br/>
 		&bull; �����<br/>
		<a href='?action=arenda&type=2'>����� ������� �� 5.00 ��.</a>";
		
		echo "<div class=\"sep1\"></div><div class=\"sep2\"></div>";
		
		echo "���������� ����� � ���������<br/>
		����: <b>20.00 ��.</b> � �����<br/>
		&bull; ���� ��� ��������: 1<br/>
 		&bull; �����<br/>
		<a href='?action=arenda&type=3' onclick=\"return confirm('�� �������, ��� ������ ��������� 20.00 ��.?')\">����� ������� �� 20.00 ��.</a>";	
	}
	else
	{
		$res=mysql_fetch_Array($result);
		echo "�� ���������� ����� � ���������<br/>
		������ ������: ".$res['date']."<br/>
		�������� ��: ".date('d.m.y H:i', $res['time']);
		if($res["time"]<time()){echo "<br/><font color='#ff0000'>����� ����������...</font> <a href='?up_date=1'>+</a>";}
		if ($res["type"]==1)echo "<br/>���� � ������: <b>30.00 ��.</b><br/>";
		else if ($res["type"]==2)echo "<br/>���� � �����: <b>5.00 ��.</b><br/>";
		else if ($res["type"]==3)echo "<br/>���� � �����: <b>20.00 ��.</b><br/>&nbsp&bull; ���� ��� ��������: 1<br/>";
		echo "&nbsp&bull; �����<br/><br/>";
		echo "<a href=\"?closearenda=1\">���������� ������</a><br/>
		<small>��� ������ ������, ��� ���� �� ������� � <br/>�������� ����������� � ��� ���������.</small><br/>";
		if ($res["type"]==3)echo "<small><font color=red>���� �������� ����������� �� ����.</font><small>";
	
		echo "<div class=\"sep1\"></div><div class=\"sep2\"></div>";
		
		if (!$db["son"])
		{	
			echo "���������: <b>�� �����������</b><br/>
			<a href=\"?to_sleep=1\" >������</a><br/>";
		}
		else
		{
			echo "<div style='background-color: #A0A0A0'>���������: <b>�� �����</b><br/><a href=\"?to_awake=1\">����������</a><br/></div>";
		}
		echo "<div class=\"sep1\"></div><div class=\"sep2\"></div>";
		$res["zapiska"]=str_replace("&amp;","&",$res["zapiska"]);
		$res["zapiska"]=wordwrap($res["zapiska"], 100, " ",1);
		echo "
			<form method='post'>
				<b>�������� ������ (2048 ��������).</b><br/>
				<textarea rows='6' cols='30' name='notes'>".$res["zapiska"]."</textarea><br/>
				<input type='submit' name='savenotes' class='inup' value='��������� �����' />
			</form>";
		
		if ($res["type"]==3)
		{
			$zver_in=mysql_fetch_array(mysql_query("SELECT id,obraz,name,level FROM zver WHERE id=".$res["zver"]));
			if ($zver_in)
			{
				echo "<b>".$zver_in["name"]."</b> [".$zver_in["level"]."]<br/>
				<a href='?pet_wear=1' alt='�������'><img src='http://www.meydan.az/img/".$zver_in["obraz"]."' border='0' /></a>";
			}
			else 
			{
				echo "<b>��������</b><br/><img src='http://www.meydan.az/img/obraz/animal/null.gif' border='0' />";
			}
			echo "<br/>";
			$zver_on=mysql_fetch_array(mysql_query("SELECT id,obraz,name,level FROM zver WHERE owner=".$db["id"]." and sleep=0"));
			if ($zver_on)
			{
				echo "<b>".$zver_on["name"]."</b> [".$zver_on["level"]."]<br/>
				<a href='?pet_unwear=".$zver_on["id"]."' alt='��������'><img src='http://www.meydan.az/img/".$zver_on["obraz"]."' border='0' /></a>";
			}
			else 
			{
				echo "<b>��������</b><br/><img src='http://www.meydan.az/img/obraz/animal/null.gif' border='0' />";
			}
		}	
	}
?>
</div>