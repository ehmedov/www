<body style="background-image: url(img/index/castle.jpg);background-repeat:no-repeat;background-position:top right">
<?
$login=$_SESSION["login"];

$getOwner = mysql_fetch_assoc(mysql_query("SELECT * FROM castle_config LEFT JOIN clan on clan.name_short=castle_config.owner"));
if ($getOwner['owner'] != '')
{
	$owner = '����� ����������� �����: '.($getOwner['orden']?'<img src="img/orden/'.$getOwner['orden'].'/0.gif"> ':'').'<a href="clan_inf.php?clan='.$getOwner['name_short'].'" target=_blank><img src=img/clan/'.$getOwner['name_short'].'.gif></a> '.$getOwner['name'].'';
}
else 
{
	$owner = '� ������ ������ ����� ����� �� ������������.';
}

echo "<h3>�������� �����<br><small>(".$owner.")</small></h3>";
//***************************************************************************
if (isset($_POST['enter_castle']))
{
	if(($db['clan_short'] == $getOwner['owner'] && $db['clan_short']!="") || $db["adminsite"]) 
	{
		$_SESSION["castle"]=1;
		Header("Location: main.php?act=go&level=castle_hall");
		die();
	}
}
//***************************************************************************
if (isset($_POST['add_new']))
{
	$_POST['cr'] = (int)$_POST['cr'];
	if ($db['glava'] != 1 || $db['clan'] == '') 
	{
		$msg = '�������� ����� ������ ����� �����';
	}
	else if(date("w")!=0 && date("w")!=3)
	{
		$msg = '��������� ����� �� ����� ������� � <b>�����������</b> � <b>�����</b>.';
	}
	else if(date("H")>=18)
	{
		$msg = '����� ������ ������ �� ����� �� <b>18:00</b>.';
	}
	else if ($db['clan'] == $getOwner['owner']) 
	{
		$msg = '�� �� ������ ������ ������!';
	}
	else if ($_POST['cr'] > $db['money'])
	{
		$msg = '� ��� ������������ �����!';
	}
	else 
	{
		$checkStavka = mysql_query("SELECT stavka FROM castle_tournament WHERE tribe = '".$db['clan_short']."' ");
		if (mysql_num_rows($checkStavka) == 0)
		{
			if ($_POST['cr'] < 1000)
			{
				$msg = '����������� ������ <b>1000 ��.</b>!';
			}
			else 
			{
				mysql_query("UPDATE users SET money = money - ".$_POST['cr']." WHERE login ='".$login."'");
				$db['money'] -= $_POST['cr'];
				mysql_query("INSERT INTO castle_tournament SET stavka = ".$_POST['cr'].", tribe = '".$db['clan_short']."'");
				history($login,"����� ������ �� ������","<b>".$_POST['cr']." ��.</b>",$db['remote_ip'],"�������� �����");
			}
		}
		else
		{
			mysql_query("UPDATE users SET money = money - ".$_POST['cr']." WHERE login ='".$login."'");
			$db['money'] -= $_POST['cr'];
			mysql_query("UPDATE castle_tournament SET stavka = stavka + ".$_POST['cr']." WHERE tribe = '".$db['clan_short']."'");
			history($login,"������ ����� �� ������","<b>".$_POST['cr']." ��.</b>",$db['remote_ip'],"�������� �����");
		}
	}
}
//***************************************************************************
$money = sprintf ("%01.2f", $db["money"]);
$platina = sprintf ("%01.2f", $db["platina"]);

echo"
<table width=100% cellspacing=0 cellpadding=0 border=0>
<tr>
<td align=left valign=top>� ��� � �������: <b>$money</b> ��. <b>$platina</b> ��.</td>
<td nowrap><center><font color=red>$msg</font></center>&nbsp;</td>
<td align=right valign=top nowrap>
	<INPUT TYPE=button class=newbut value=\"��������\" onClick=\"location.href='main.php?act=none'\">
 	<INPUT TYPE=button class=newbut value=\"���������\" onClick=\"location.href='main.php?act=go&level=okraina';\">
</td>
</tr>
</table>";

$getTribes = mysql_query("SELECT * FROM castle_tournament LEFT JOIN clan on clan.name_short=castle_tournament.tribe ORDER BY stavka DESC");
if (mysql_num_rows($getTribes) == 0)
{
	$clan_list = '� ������ ������ ����� �� ����� ������ �� ����� �����.';
}
else 
{
	while ($tribes = mysql_fetch_assoc($getTribes))
	{
		$clan_list .= '<img src="img/orden/'.$tribes['orden'].'/0.gif"> <img src=img/clan/'.$tribes['name_short'].'.gif align=midle> <b>'.$tribes['name'].'</b> [������: '.sprintf ("%01.2f", $tribes['stavka']).' ��.]<br>';
		if ($db['clan_short'] == $tribes['tribe'])
		{
			$My_Stavka = $tribes['stavka'];
		}
	}
}


echo"
<table width=100% cellspacing=0 cellpadding=0>
<tr>
	<td valign=top width=430 nowrap>";
		if  (($db['clan_short'] != $getOwner['owner'] && $db['glava'] == 1 && $db['clan_short']!="") || $db["adminsite"])
		{
			if (!isset($My_Stavka)) $My_Stavka = 0;
			echo "<fieldset style='WIDTH: 95%'>
		    	<legend><b>������ ������ �� ����� �����:</b></legend>
		    	<form action='main.php?act=none' method=post>
		    		���� ������: ".sprintf ("%01.2f", $My_Stavka)." ��.<br>
		    		�����: <input type=text class=input value='' name=cr maxlength=4>
		    		<input type=submit class=input value='������!' name=add_new>
		    </fieldset>
		    <br><br>";
		}
		if (($db['clan_short'] == $getOwner['owner'] && $db['clan_short']!="") ||  $db["adminsite"])
		{
			 echo "<fieldset style='WIDTH: 95%'>
		    	<legend><b>���� ����������� :</b></legend>
		    	<form action='' method=post>
		    		<input type=submit class=input value='����� � �����!' name=enter_castle>
		    	</form>
		    </fieldset>	
		    <br>
			<br>";
		}
		echo "<fieldset style='WIDTH: 95%'><legend><b>����� ������� ������ ������ �� ����� �����:</b></legend>$clan_list</fieldset>	
	</td>
	<td width=100% valign=top>
		<fieldset style='WIDTH: 100%'>
			<legend><b>���������� � �������:</b></legend>
			����� �� ����� ������� � ����������� � �����. ����� ���������� �����: 18:00
		</fieldset>	
		<br>
		<fieldset style='WIDTH: 100%'>
			<legend><b>������ ����������!</b></legend>
			� � ����� �� ����� ��������� ��� ����, ������� �������� ������������ ������. <br>
			� ����������� ������ - 1000 ��.<br>
			� � ����� �� �����, ������������� ����������� ���������� - ����������<br>
			� <b>� ��� �������� ������ �� ������ ������, ������� ��������� � �������� ����� �� ������ ������.</b><br>
			� ������ ������� �� ������ � ������ ������������ ������������ ������.
		</fieldset>	
	</td>
</tr>
</table>";
		
echo "<center><h4>���������� 10-�� ���������� ����</h4>";
echo "<table>
<tr align='center' bgcolor='212120' style='color:#ffffff'><td>������</td><td>�����</td><td>����</td><td>������</td><td>��� �����</td><td>����������</td></tr>";
$sql=mysql_query("SELECT * FROM castle_log ORDER BY battle_time DESC LIMIT 10");
while($query=mysql_fetch_array($sql))
{
	#������ �����
	$defender=mysql_fetch_array(mysql_query("SELECT * FROM clan WHERE name_short='".$query["defender"]."'"));
	$atacker=mysql_fetch_array(mysql_query("SELECT * FROM clan WHERE name_short='".$query["atacker"]."'"));
	if ($query["winner"]==$defender['name_short'])$winner=$defender;
	else $winner=$atacker;
	echo "
	<tr align='center'>
		<td><img src='img/orden/".$defender['orden']."/0.gif'> <a href='clan_inf.php?clan=".$defender['name_short']."' target='_blank'><img src='img/clan/".$defender['name_short'].".gif'></a> ".$defender["name"]."</td>
		<td><img src='img/orden/".$atacker['orden']."/0.gif'> <a href='clan_inf.php?clan=".$atacker['name_short']."' target='_blank'><img src='img/clan/".$atacker['name_short'].".gif'></a> ".$atacker["name"]."</td>
		<td width=110>".date('d.m.y H:i', $query["battle_time"])."</td>
		<td width=110>".$query["stavka"]." ��.</td>
		<td width=110><a href='http://www.meydan.az/log.php?log=".$query["battle_log"]."' target='_blank'>��</a></td>
		<td><img src='img/orden/".$winner['orden']."/0.gif'> <a href='clan_inf.php?clan=".$winner['name_short']."' target='_blank'><img src='img/clan/".$winner['name_short'].".gif'></a> ".$winner["name"]."</td>
	</tr>";
}
echo "</table></center>";
?>
<br><br><br><br>
<?include_once("counter.php");?>