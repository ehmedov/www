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
				$msg="�� ���������� '����� � ���������' �� 30.00 ��.";
			}
			else $msg="������������ �����.";
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
				$msg="�� ���������� '����� � ���������' �� 5.00 ��.";
			}
			else $msg="������������ �����.";
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
				$msg="�� ���������� '����� � ���������' �� 20.00 ��.";
			}
			else $msg="������������ �����.";
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
			Header("Location: main.php?act=none");
			die();
		}
		else
		{
			$msg="����� ����������...";
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
		Header("Location: main.php?act=none");
		die();
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
				else $msg="������������ �����.";
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
			$msg="��� ����...";
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
?>
<h3>���������</h3>
<table width=100% cellspacing=0 cellpadding=3>
<tr valign=top class="l3">
	<td>
		<?echo "<script>drwfl('".$db['login']."','".$db['id']."','".$db['level']."','".$db['dealer']."','".$db['orden']."','".$db['admin_level']."','".$db['clan_short']."','".$db['clan']."');</script>";?>
		[� ��� � �������: <B><?echo $money;?></B> ��. <B><?echo $platina;?></B> ��. <B><?echo $naqrada;?></B> ��.]
	</td>
	<td align=right nowrap>
		<input type=button onclick="location.href='main.php?act=go&level=okraina'" value="����� �� �����" class=new >
		<input type=button onclick="location.href='main.php?act=none'" value="��������" class=new >
	</td>
</tr>
<tr valign=top class="l0">
	<td colspan=2><b>�������:</b> ��� ����������. ��� �������� ���������. ��� ������������� ����� � �������� ���������.</td>
</tr>
<tr class="l0">
	<td colspan=2><?echo "<font color=red>".$msg."</font>&nbsp;";?></td>
</tr>
<tr class="l0">
<td colspan=2>
<?
	$result=mysql_query("SELECT * FROM house WHERE login='".$login."' limit 1");
	if (!mysql_num_rows($result))
	{
		echo "���������� ����� � ���������<BR>
		����: <b>30.00 ��.</b> � ������<BR>
 		&bull; �����<BR>
		<A href='?action=arenda&type=1' onclick=\"return confirm('�� �������, ��� ������ ��������� 30 ��.?')\">����� �������</A><HR>";
		
		echo "���������� ����� � ���������<BR>
		����: <b>5.00 ��.</b> � �����<BR>
 		&bull; �����<BR>
		<A href='?action=arenda&type=2' onclick=\"return confirm('�� �������, ��� ������ ��������� 5.00 ��.?')\">����� �������</A><HR>";
		
		echo "���������� ����� � ���������<BR>
		����: <b>20.00 ��.</b> � �����<BR>
		&bull; ���� ��� ��������: 1<br>
 		&bull; �����<BR>
		<A href='?action=arenda&type=3' onclick=\"return confirm('�� �������, ��� ������ ��������� 20.00 ��.?')\">����� �������</A><HR>";	
	}
	else
	{
		$res=mysql_fetch_Array($result);
		echo "<TABLE WIDTH=100% CELLSPACING=1 CELLPADDING=3 class='l3'><tr valign=top class='l0'><td nowrap width=300>";
		echo "�� ���������� ����� � ���������<BR>
		������ ������: ".$res['date']."<BR>
		�������� ��: ".date('d.m.y H:i', $res['time']);
		if($res["time"]<time()){echo "<br><font color=red>����� ����������...</font> <a href='?up_date=1'><img src='img/icon/plus.gif' border=0 alt='���������'></a>";}
		if ($res["type"]==1)echo "<BR>���� � ������: <b>30.00 ��.</b><BR>";
		else if ($res["type"]==2)echo "<BR>���� � �����: <b>5.00 ��.</b><BR>";
		else if ($res["type"]==3)echo "<BR>���� � �����: <b>20.00 ��.</b><BR>&nbsp&bull; ���� ��� ��������: 1<BR>";
		echo "&nbsp&bull; �����<BR><BR>";
		echo "<A href=\"?closearenda=1\" onclick=\"return confirm('�� �������, ��� ������ ���������� ������?')\">���������� ������</A><BR>
		<small>��� ������ ������, ��� ���� �� ������� � <br>�������� ����������� � ��� ���������.</small><BR>";
		if ($res["type"]==3)echo "<small><font color=red>���� �������� ����������� �� ����.</font><small>";
		echo "</td><td width=100%>";
		echo "�� ������ �������, ����� � ������� ����.<BR>
		�� ����� ��� ��� ��������� ������� �� ��� ������������������. <BR>
		��� �������� ���, ��������, ���������.<BR>
		��� �� ������ �� ��������� ��������� � ������������ ������ �������������<BR><BR>";
		if (!$db["son"])
		{	
			echo "���������: <B>�� �����������</B><BR>
			<A href=\"?to_sleep=1\" >������</A><BR>";
		}
		else
		{
			echo "<DIV  class='l3'>
			���������: <B>�� �����</B><BR>
			<A href=\"?to_awake=1\" >����������</A><BR></DIV>";
		}
		echo "</td></tr>";
		echo "</td></tr></table>";
		$res["zapiska"]=str_replace("&amp;","&",$res["zapiska"]);
		$res["zapiska"]=wordwrap($res["zapiska"], 100, " ",1);
		echo "<FORM METHOD=POST>
			�� ���������� � ����� �������. ������, ��� �� ������ - �������� ������.<BR>
			�� ������ �������� ������ ��� ������ ����� ������� �� ����� 2048 ��������.
			<TEXTAREA rows=10 style='width: 100%;' name='notes'>".$res["zapiska"]."</TEXTAREA><BR>
			<INPUT type='submit' name='savenotes' value='��������� �����'>
			</FORM>";
		
		if ($res["type"]==3)
		{
			echo "<TABLE cellpadding=0 cellspacing=0 width=100%>
			<TR>
			<TD align=center>";
				$zver_in=mysql_fetch_array(mysql_query("SELECT id,obraz,name,level FROM zver WHERE id=".$res["zver"]));
				if ($zver_in)
				{
					echo "<B>".$zver_in["name"]."</B> [".$zver_in["level"]."]<br>
					<A href='?pet_wear=1' alt='�������'><IMG src='img/".$zver_in["obraz"]."'></A>";
				}
				else 
				{
					echo "<B>��������</B><br><IMG src='img/obraz/animal/null.gif'>";
				}

			echo "</td><TD align=center>";
				$zver_on=mysql_fetch_array(mysql_query("SELECT id,obraz,name,level FROM zver WHERE owner=".$db["id"]." and sleep=0"));
				if ($zver_on)
				{
					echo "<B>".$zver_on["name"]."</B> [".$zver_on["level"]."]<br>
					<A href='?pet_unwear=".$zver_on["id"]."' alt='��������'><IMG src='img/".$zver_on["obraz"]."'></A>";
				}
				else 
				{
					echo "<B>��������</B><br>
					<IMG src='img/obraz/animal/null.gif'>";
				}
			echo "</TD>
			</TR>";	
			echo "</TABLE>";
		}	
	}
?>
</td>
</tr>
</table>