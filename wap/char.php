<?
include ("key.php");
include ("conf.php");
include ("align.php");
include ("functions.php");

header("Content-Type: text/html; charset=windows-1251");
header("Cache-Control: no-cache, must-revalidate"); // ������� �������� ���-�� �� �� ��������� ��� ��������
header("Pragma: no-cache");
echo '<?xml version="1.0" encoding="windows-1251"?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.2//EN" "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="en">';
$login=$_SESSION["login"];
$uin_id=$_SESSION["uin_id"];
$message="";
$data = mysql_connect($base_name, $base_user, $base_pass) or die('�� ���������� ������������. ��������� ��� �������, ��� ������������ � ������!');
mysql_select_db($db_name) or die('������ ����� � ���� ������');

$db=mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `login` = '".$login."'"));

TestBattle($db);
if($db["room"]=="house")
{
	$_SESSION["message"]="�� � ���������";
	Header("Location: main.php?tmp=".md5(time()));
	die();
}

$have_priem=mysql_fetch_Array(mysql_query("SELECT count(*) FROM slots_priem WHERE user_id =".$db["id"]));
if (!$have_priem[0])
{	
	for($i=1;$i<=8;$i++) mysql_query("INSERT INTO slots_priem (user_id,sl_name) values (".$db["id"].",'sl".$i."')");
}

$k1=mysql_fetch_array(mysql_query("SELECT is_modified, add_rej, add_drob, add_kol, add_rub FROM `inv` WHERE id=".$db["hand_r"]));
$k2=mysql_fetch_array(mysql_query("SELECT is_modified, add_rej, add_drob, add_kol, add_rub FROM `inv` WHERE id=".$db["hand_l"]));
effects($db["id"],$effect);
###########################################################################################################
if ($_GET["ups"] && $db["ups"])
{
	if($_GET["ups"]=="sila")
	{
		mysql_query("UPDATE `users` SET `sila` = `sila`+1, `ups`=`ups`-1 WHERE `login` = '".$login."'");
		$message="���������� ����������� <b>\"����\"</b> ����������� ������.";
	}
	if($_GET["ups"]=="lovkost")
	{
		mysql_query("UPDATE `users` SET `lovkost` = `lovkost`+1, `ups`=`ups`-1 WHERE `login` = '".$login."'");
        $message="���������� ����������� <b>\"��������\"</b> ����������� ������.";
	}
	if($_GET["ups"]=="udacha")
	{
		mysql_query("UPDATE `users` SET `udacha` = `udacha`+1, `ups`=`ups`-1 WHERE `login` = '".$login."'");
        $message="���������� ����������� <b>\"�����\"</b> ����������� ������.";
	}
	if($_GET["ups"]=="power")
	{
		mysql_query("UPDATE `users` SET `power` = `power`+1, `hp_all` = `hp_all`+6, `ups`=`ups`-1 WHERE `login` = '".$login."'");
		$message="���������� ����������� <b>\"������������\"</b> ����������� ������.";
	}
	if($_GET["ups"]=="intellekt")
	{
		mysql_query("UPDATE `users` SET `intellekt` = `intellekt`+1, `ups`=`ups`-1 WHERE `login` = '".$login."'");
    	$message="���������� ����������� <b>\"���������\"</b> ����������� ������.";
	}
	if($_GET["ups"]=="vospriyatie")
	{
		mysql_query("UPDATE `users` SET `vospriyatie` = `vospriyatie`+1, `mana_all` = `mana_all`+10, `ups`=`ups`-1 WHERE `login` = '".$login."'");
        $message="���������� ����������� <b>\"����������\"</b> ����������� ������.";
	}
	if($_GET["ups"]=="duxovnost")
	{
		mysql_query("UPDATE `users` SET `duxovnost` = `duxovnost`+1, `ups`=`ups`-1 WHERE `login` = '".$login."'");
    	$message="���������� ����������� <b>\"����������\"</b> ����������� ������.";
	}
	$db=mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `login` = '".$login."'"));
	$_GET["view"]=1;
}
###########################################################################################################
$umeniyalar=array("castet_vl","sword_vl","axe_vl","hummer_vl","copie_vl","shot_vl","staff_vl","cast","fire_magic","earth_magic","water_magic","air_magic","svet_magic","tma_magic","gray_magic");
if ($_GET["umenie"] && $db["umenie"] && in_array($_GET["umenie"],$umeniyalar))
{
	switch ($_GET["umenie"])
    {
        case "phisic_vl": $st_title="����������� �����"; break;
		case "sword_vl":  $st_title="������"; break;
        case "castet_vl": $st_title="������, ���������"; break;
        case "axe_vl":  $st_title="��������, ��������"; break;
        case "hummer_vl":  $st_title="��������, ��������"; break;
		case "copie_vl":  $st_title="���������� ��������"; break;
        case "staff_vl":  $st_title="��������"; break;
       
        case "fire_magic":  $st_title="������� ����"; break;
        case "earth_magic":  $st_title="������� �����"; break;
        case "water_magic":  $st_title="������� ����"; break;
        case "air_magic":  $st_title="������� �������"; break;
        
        case "svet_magic":  $st_title="������� �����"; break;
        case "tma_magic":  $st_title="������� ����"; break;
        case "gray_magic":  $st_title="����� �����"; break;
    }
	mysql_query("UPDATE users SET ".$_GET["umenie"]."=".$_GET["umenie"]."+1, umenie=umenie-1 WHERE login='".$login."'");
	$message="������ ��������� <b>���������� �������� $st_title</b>!";
	$db=mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `login` = '".$login."'"));
	$_GET["view"]=1;
}
###########################################################################################################
if (($_GET["action"]=="onset_priem") && is_numeric($_GET["id"]))
{
	$id=(int)$_GET["id"];
	$res=mysql_query("SELECT * FROM priem WHERE id=$id and view=0");
	if (mysql_num_rows($res))
	{
		$result=mysql_fetch_array($res);
		if ($db["level"] < $result["level"]) $msg="������� ������� ���!";
		else if ($db['intellekt']+$effect["add_intellekt"] < $result["intellekt"]) $msg="��������� ���. ��������� ".$result["intellekt"];
		else if ($db["vospriyatie"] < $result["vospriyatie"]) $msg="��������� ���. ���������� ".$result["vospriyatie"];								
		else if ($db["fire_magic"]+$effect["add_fire_magic"] < $result["fire_magic"]) $msg="��������� ���������� �������� ������� ���� ".$result["fire_magic"];
		else if ($db["earth_magic"]+$effect["add_earth_magic"] < $result["earth_magic"]) $msg="��������� ���������� �������� ������� ����� ".$result["earth_magic"];
		else if ($db["water_magic"]+$effect["add_water_magic"] < $result["water_magic"]) $msg="��������� ���������� �������� ������� ���� ".$result["water_magic"];
		else if ($db["air_magic"]+$effect["add_air_magic"] < $result["air_magic"]) $msg="��������� ���������� �������� ������� ������� ".$result["air_magic"];
		
		else if ($db["svet_magic"]+$effect["add_svet_magic"] < $result["svet_magic"]) $msg="���������� �������� ������� ����� ".$result["svet_magic"];
		else if ($db["tma_magic"]+$effect["add_tma_magic"] < $result["tma_magic"]) $msg="���������� �������� ������� ���� ".$result["tma_magic"];
		else if ($db["gray_magic"]+$effect["add_gray_magic"] < $result["gray_magic"]) $msg="���������� �������� ����� ����� ".$result["gray_magic"];
		else
		{
			$sl_inf=mysql_fetch_array(mysql_query("SELECT count(*) FROM slots_priem WHERE priem_id=".$id." and user_id =".$db["id"]));
			if ($sl_inf[0])
			{
				$msg="������������ ���� ������";
			}
		 	else
		 	{
		 		$slot_inf=mysql_fetch_array(mysql_query("SELECT * FROM slots_priem WHERE priem_id=0 and user_id =".$db["id"]." ORDER BY sl_name ASC"));
		 		if (!$slot_inf)$slot_name = "sl1";
		 		else $slot_name = $slot_inf["sl_name"];
				mysql_query("UPDATE slots_priem SET priem_id=".$id." WHERE sl_name='".$slot_name."' and user_id =".$db["id"]);
			}
		}
	}
	$_GET["view"]=4;
}
if ($_GET["action"]=="unset_priem")
{
	$sl_name=htmlspecialchars(addslashes($_GET["sl_name"]));
	mysql_query("UPDATE slots_priem SET priem_id=0 WHERE sl_name='$sl_name' and user_id = ".$db["id"]);
	$_GET["view"]=4;
}
if ($_GET["clear_abil"]=="all")
{
	mysql_query("UPDATE slots_priem SET priem_id=0 WHERE user_id = ".$db["id"]);
	$_GET["view"]=4;
}
###########################################################################################################

?>
<html>
<head>
	<title>WAP.MEYDAN.AZ</title>
	<link rel="stylesheet" href="main.css" type="text/css" />
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
	<meta http-equiv="Content-Language" content="ru" />
	<meta name="Description" content="�������� RPG ������ ���� ����������� ���� � �����. ������ ������, �������� �������, ��� ����, ����� ���� ����� ������ � �����." />
	<meta http-equiv="cache-control" content="no-cache" />
	<meta http-equiv="pragma" content="no-cache" />
	<meta http-equiv="expires" content="0" />
</head>

<body>
<div id="cnt" class="content">
<div class="aheader">
	[<a href="?view=0">����������</a>] [<a href="?view=1">��������� � ����������</a>] [<a href="?view=2">������ � ������������</a>] [<a href="?view=3">���������</a>] 
	[<a href="?view=4">�����</a>] [<a href="?view=5">�������� ������</a>] [<a href="?view=7">���������</a>]
	<br/>
</div>
<div class="sep1"></div>
<div class="sep2"></div>
<?
############################################################################################################
if ($_GET["view"]==1)
{
?>	
	<div class="aheader">
		<b>��������� ���������</b><br/>
		<font color='#ff0000'><?=$message;?></font>
	</div>
	<div>
		<?
			echo "
			&nbsp;� ����: ".($db['sila']+$effect["add_sila"]).($db["ups"]?" <a href='?ups=sila'>+</a>":"")."<br/>
			&nbsp;� ��������: ".($db['lovkost']+$effect["add_lovkost"]).($db["ups"]?" <a href='?ups=lovkost'>+</a>":"")."<br/>
			&nbsp;� �����: ".($db['udacha']+$effect["add_udacha"]).($db["ups"]?" <a href='?ups=udacha'>+</a>":"")."<br/>
			&nbsp;� ������������: ".$db['power'].($db["ups"]?" <a href='?ups=power'>+</a>":"")."<br/>";
			if ($db["level"]>1) 
			{
				echo "&nbsp;� ���������: ".($db['intellekt']+$effect["add_intellekt"]).($db["ups"]?" <a href='?ups=intellekt'>+</a>":"")."<br/>
					  &nbsp;� ����������: ".$db['vospriyatie'].($db["ups"]?" <a href='?ups=vospriyatie'>+</a>":"")."<br/>";
			}
			if ($db['level'] > 9)
			{
				echo "&nbsp;� ����������: ".$db['duxovnost'].($db["ups"]?" <a href='?ups=duxovnost'>+</a>":"")."<br/>";
			} 
			if($db["ups"]){echo "<br/><b style='color:#228b22'>��������� ����������: ".$db["ups"]."</b>";}
		?>
	</div>
	<div class="sep1"></div>
	<div class="sep2"></div>
	<div class="aheader">
		<b>���������� ��������</b><br/>
	</div>
	<div>
		<b>������:</b><br/>
		&nbsp;� ���������� �������� ������:				<?echo ($db["sword_vl"]+$effect["add_sword_vl"]+$db["add_oruj"]);		if($db["umenie"]){echo " <a href='?umenie=sword_vl'>+</a>";}?><br/>
		&nbsp;� ���������� �������� ������, ���������:	<?echo ($db["castet_vl"]+$effect["add_castet_vl"]+$db["add_oruj"]);		if($db["umenie"]){echo " <a href='?umenie=castet_vl'>+</a>";}?><br/>
		&nbsp;� ���������� �������� ��������, ��������:	<?echo ($db["axe_vl"]+$effect["add_axe_vl"]+$db["add_oruj"]);			if($db["umenie"]){echo " <a href='?umenie=axe_vl'>+</a>";}?><br/>
		&nbsp;� ���������� �������� ��������, ��������:	<?echo ($db["hummer_vl"]+$effect["add_hummer_vl"]+$db["add_oruj"]);		if($db["umenie"]){echo " <a href='?umenie=hummer_vl'>+</a>";}?><br/>
		&nbsp;� ���������� �������� ���������� ��������:<?echo ($db["copie_vl"]+$effect["add_copie_vl"]+$db["add_oruj"]);		if($db["umenie"]){echo " <a href='?umenie=copie_vl'>+</a>";}?><br/>
		&nbsp;� ���������� �������� ��������:			<?echo ($db["staff_vl"]+$effect["add_staff_vl"]);						if($db["umenie"]){echo " <a href='?umenie=staff_vl'>+</a>";}?><br/>
		
		<br/><b>�����:</b><br/>
		&nbsp;� ���������� �������� ������� ����:		<?echo ($db["fire_magic"]+$effect["add_fire_magic"]);					if($db["umenie"]){echo " <a href='?umenie=fire_magic'>+</a>";}?><br/>
		&nbsp;� ���������� �������� ������� �����:		<?echo ($db["earth_magic"]+$effect["add_earth_magic"]);					if($db["umenie"]){echo " <a href='?umenie=earth_magic'>+</a>";}?><br/>
		&nbsp;� ���������� �������� ������� ����:		<?echo ($db["water_magic"]+$effect["add_water_magic"]);					if($db["umenie"]){echo " <a href='?umenie=water_magic'>+</a>";}?><br/>
		&nbsp;� ���������� �������� ������� �������:	<?echo ($db["air_magic"]+$effect["add_air_magic"]);						if($db["umenie"]){echo " <a href='?umenie=air_magic'>+</a>";}?><br/>
		&nbsp;� ���������� �������� ������� �����:		<?echo ($db["svet_magic"]+$effect["add_svet_magic"]);					if($db["umenie"]){echo " <a href='?umenie=svet_magic'>+</a>";}?><br/>
		&nbsp;� ���������� �������� ������� ����:		<?echo ($db["tma_magic"]+$effect["add_tma_magic"]);						if($db["umenie"]){echo " <a href='?umenie=tma_magic'>+</a>";}?><br/>
		&nbsp;� ���������� �������� ����� �����:		<?echo ($db["gray_magic"]+$effect["add_gray_magic"]);					if($db["umenie"]){echo " <a href='?umenie=gray_magic'>+</a>";}?><br/>
		<?if($db["umenie"]){echo "<br><b style='color:#228b22'>��������� ������: ".$db["umenie"]."</b><br/>";}?>
	</div>
<?
}
############################################################################################################
if ($_GET["view"]==5)
{
	?>
	<div class="aheader">
		<b>�������� ������</b><br/>
	</div>
	<div>
	<?
		if ($db["sila"]+$effect["add_sila"]>=125) 	    echo "<b>���� �������</b><br/>� ������������ ��������� �����������: 10<br/>� ����������� ��������� �����������: 10<br/>� ��. �������� �����: 25<br/><br/>";
		else if ($db["sila"]+$effect["add_sila"]>=100) 	echo "<b>���� �������</b><br/>� ��. �������� �����: 25<br/><br/>";
		else if ($db["sila"]+$effect["add_sila"]>=75) 	echo "<b>���� �������</b><br/>� ��. �������� �����: 17<br/><br/>";
		else if ($db["sila"]+$effect["add_sila"]>=50) 	echo "<b>���� �������</b><br/>� ��. �������� �����: 10<br/><br/>";
		else if ($db["sila"]+$effect["add_sila"]>=25) 	echo "<b>���� �������</b><br/>� ��. �������� �����: 5<br/><br/>";
		
		if ($db["lovkost"]+$effect["add_lovkost"]>=125) 	    echo "<b>�������� �����</b><br/>� ��. ������ ������������ ����� (%): 40<br/>� ��. ����������� (%): 15<br/>� ��. ����������� (%): 120<br/><br/>";
		else if ($db["lovkost"]+$effect["add_lovkost"]>=100) 	echo "<b>�������� �����</b><br/>� ��. ������ ������������ ����� (%): 40<br/>� ��. ����������� (%): 15<br/>� ��. ����������� (%): 105<br/><br/>";
		else if ($db["lovkost"]+$effect["add_lovkost"]>=75) 	echo "<b>�������� �����</b><br/>� ��. ������ ������������ ����� (%): 15<br/>� ��. ����������� (%): 15<br/>� ��. ����������� (%): 35<br/><br/>";
		else if ($db["lovkost"]+$effect["add_lovkost"]>=50) 	echo "<b>�������� �����</b><br/>� ��. ������ ������������ ����� (%): 15<br/>� ��. ����������� (%): 5<br/>� ��. ����������� (%): 35<br/><br/>";
		else if ($db["lovkost"]+$effect["add_lovkost"]>=25) 	echo "<b>�������� �����</b><br/>� ��. ����������� (%): 5<br/><br/>";
		
		if($db["udacha"]+$effect["add_udacha"]>=125) 		echo "<b>���������� �������</b><br/>� ��. ������������ ����� (%): 120<br/>� ��. �������� ����. ����� (%): 25<br/>� ��. ������ ����������� (%): 45<br/><br/>";
		else if ($db["udacha"]+$effect["add_udacha"]>=100) 	echo "<b>���������� �������</b><br/>� ��. ������������ ����� (%): 105<br/>� ��. �������� ����. ����� (%): 25<br/>� ��. ������ ����������� (%): 45<br/><br/>";
		else if ($db["udacha"]+$effect["add_udacha"]>=75) 	echo "<b>���������� �������</b><br/>� ��. ������������ ����� (%): 35<br/>� ��. �������� ����. ����� (%): 25<br/>� ��. ������ ����������� (%): 15<br/><br/>";
		else if ($db["udacha"]+$effect["add_udacha"]>=50) 	echo "<b>���������� �������</b><br/>� ��. ������������ ����� (%): 35<br/>� ��. �������� ����. ����� (%): 10<br/>� ��. ������ ����������� (%): 15<br/><br/>";
		else if ($db["udacha"]+$effect["add_udacha"]>=25)	echo "<b>���������� �������</b><br/>� ��. �������� ����. ����� (%): 10<br/><br/>";
		
		if ($db["power"]>=125) 		echo "<b>������ ��������</b><br/>� 25% ������ �� �����<br/><br/>";
		else if ($db["power"]>=100)	echo "<b>������ ��������</b><br/>� 20% ������ �� �����<br/><br/>";
		else if ($db["power"]>=75)	echo "<b>������ ��������</b><br/>� 15% ������ �� �����<br/><br/>";
		else if ($db["power"]>=50)	echo "<b>������ ��������</b><br/>� 10% ������ �� �����<br/><br/>";
		else if ($db["power"]>=25)	echo "<b>������ ��������</b><br/>� 5% ������ �� �����<br/><br/>";
		
		if ($db["intellekt"]+$effect["add_intellekt"]>=125)			echo "<b>������� ������</b><br/>� �������� ����� ������ +25%<br/><br/>";
		else if ($db["intellekt"]+$effect["add_intellekt"]>=100)	echo "<b>������� ������</b><br/>� �������� ����� ������ +20%<br/><br/>";
		else if ($db["intellekt"]+$effect["add_intellekt"]>=75) 	echo "<b>������� ������</b><br/>� �������� ����� ������ +15%<br/><br/>";
		else if ($db["intellekt"]+$effect["add_intellekt"]>=50) 	echo "<b>������� ������</b><br/>� �������� ����� ������ +10%<br/><br/>";
		else if ($db["intellekt"]+$effect["add_intellekt"]>=25) 	echo "<b>������� ������</b><br/>� �������� ����� ������ +5%<br/><br/>";
?>
	<br/><br/><small><font color='#ff0000'>��������!</font> ��������, � �������� ����� �� ������ ����� ������ 25, ������ �������� �� ���� �����. 
	������������ ����� ����� ������ �� ���������� ������. 
	������ �� ������ � ���� �� ����� �� �����������, � ���������� ����� ����������. 
	(������: ���� �� ������ 100 ���� �� � ��� ����� +10% � ���������� �����, � �� 10%+5%.)</small><br/>
	</div>
<?
}
############################################################################################################
if ($_GET["view"]==7)
{
	?>
		<div class="aheader">
			<b>���������</b><br/>
		</div>
	<?
		echo "<div>";
		$pr_sql=mysql_query("SELECT title, navika FROM person_proff LEFT JOIN academy on academy.id=person_proff.proff WHERE person=".$db["id"]);
		if (mysql_num_rows($pr_sql))
		{	
			while($pr=mysql_fetch_array($pr_sql))
			{
				echo "&nbsp;� ".$pr["title"].": <b>".$pr["navika"]."</b><br/>";
			}
		}
		else echo "��� ���������";
		echo "</div>";
}
############################################################################################################
if ($_GET["view"]==3)
{
	?>
		<div class="aheader">
			<b>���������</b><br/>
		</div>
	<?
		echo "<div>";
		$s=mysql_query("SELECT * FROM effects LEFT JOIN scroll on scroll.id=effects.elik_id WHERE end_time>".time()." and effects.user_id=".$db["id"]);
		if (mysql_num_rows($s))
		{
			while ($sc=mysql_fetch_array($s))
			{
				echo $sc["name"]." - ".$sc["descs"]." ("."��� ".convert_time($sc['end_time'])."')<br/>";
			}
			echo "<br/><br/>";
		}
		if (ceil($db['cure']))
		{						
			echo "�������������� HP (%) + ".ceil($db['cure'])." (�������� ����������� [".ceil($db['cure'])."])<br/><br/>";
		}
		if($db["vip"]>time())
		{
			echo "V.I.P ���� WWW.MEYDAN.AZ - ���: ".convert_time($db["vip"])."<br/><br/>";
		}
		if($db["travm"]!=0)
		{
			$travm=$db["travm_var"];
			$kstat=$db["travm_stat"];
			$stats=$db["travm_old_stat"];
			if($travm==1){$travm="������ ������";}
			else if($travm==2){$travm="������� ������";}
			else if($travm==3){$travm="������� ������";}
			else if($travm==4){$travm="��������� ������";}
			if($kstat=="sila"){$kstat="����";}
			else if($kstat=="lovkost"){$kstat="��������";}
			else if($kstat=="udacha"){$kstat="��������";}
			else if($kstat=="intellekt"){$kstat="���������";}
			
			echo "<img src='http://www.meydan.az/img/index/travma.gif' border='0' /> ";
			echo "� ��������� <b>".$travm.".</b> ";
			echo "���������� �������������� <b style='color:#ff0000'>$kstat-$stats</b> ";
			echo "(��� ".convert_time($db['travm']).")<br/><br/>";
		}
		if($db["oslab"]>time())
	   	{
			echo "<img src='http://www.meydan.az/img/index/travma.gif' border='0' /> ";
			echo "�������� �������� ��-�� ������ � ���, ��� ".convert_time($db['oslab'])."<br/><br/>"; 
		}
		if($db["shut"]>time())
	   	{							
			echo "<img src='http://www.meydan.az/img/index/molch.gif' border='0' /> ";
			echo "������ ��� ".convert_time($db['shut'])."<br/><br/>"; 
		}
		if($db["travm_protect"]>time())
	   	{							
			echo "<img src='http://www.meydan.az/img/index/travm_protect.gif' border='0' />";
			echo "<b>���������� �����������:</b> ������ �� �����, ��� ".convert_time($db['travm_protect'])."<br/><br/>"; 
		}
		echo "</div>";
}
############################################################################################################
if ($_GET["view"]==2)
{
?>
	<div class="aheader">
		<b>������</b><br/>
	</div>
	<div>
	� ����� ������: 	<b><?=ceil($db["bron_head"]);?></b><br/>
	� ����� �������:	<b><?=ceil($db["bron_corp"]);?></b><br/>
	� ����� �����: 		<b><?=ceil($db["bron_poyas"]);?></b><br/>
	� ����� ���: 		<b><?=ceil($db["bron_legs"]);?></b><br/><br/>
	
	� ������ �� �������� �����: 	<b><?=ceil($db["protect_rej"]+$effect["p_rej"]);?></b><br/>
	� ������ �� ��������� �����:	<b><?=ceil($db["protect_drob"]+$effect["p_drob"]);?></b><br/>
	� ������ �� �������� �����: 	<b><?=ceil($db["protect_kol"]+$effect["p_kol"]);?></b><br/>
	� ������ �� �������� �����: 	<b><?=ceil($db["protect_rub"]+$effect["p_rub"]);?></b><br/><br/>

	� ������ �� �����: <b><?=ceil($db["protect_udar"]+$effect["add_bron"]+$db["power"]*1.5);?></b><br/>
	� ������ �� �����: <b><?=ceil($db["protect_mag"]+$effect["add_mg_bron"]+$db["power"]*1.5);?></b><br/><br/>
	
	� ��������� ������ �� ����� ����: 		<b><?=ceil($db["protect_fire"]+$effect["protect_fire"]);?></b><br/>
	� ��������� ������ �� ����� ����: 		<b><?=ceil($db["protect_water"]+$effect["protect_water"]);?></b><br/>
	� ��������� ������ �� ����� �������:	<b><?=ceil($db["protect_air"]+$effect["protect_air"]);?></b><br/>
	� ��������� ������ �� ����� �����: 		<b><?=ceil($db["protect_earth"]+$effect["protect_earth"]);?></b><br/>
	� ��������� ������ �� ����� �����: 		<b><?=ceil($db["protect_svet"]+$effect["protect_svet"]);?></b><br/>
	� ��������� ������ �� ����� ����: 		<b><?=ceil($db["protect_tma"]+$effect["protect_tma"]);?></b><br/>
	� ��������� ������ �� ����� �����: 		<b><?=ceil($db["protect_gray"]+$effect["protect_gray"]);?></b><br/><br/>
		
	� ��.����� �����: <b><?=ceil($db["shieldblock"]+$db["shieldblock"]*$effect["shieldblock"]/100);?></b><br/><br/>
	<div class="sep1"></div>
	<div class="sep2"></div>
	<div class="aheader">
		<b>������������</b><br/>
	</div>	
	<? 
		$krit=$db["krit"]+5*($db["udacha"]+$effect["add_udacha"])+$effect["add_krit"]; 
		$antikrit=$db["akrit"]+5*($db["udacha"]+$effect["add_udacha"])+$effect["add_akrit"]; 
		$uvorot=$db["uvorot"]+5*($db["lovkost"]+$effect["add_lovkost"])+$effect["add_uvorot"];
		$antiuvorot=$db["auvorot"]+5*($db["lovkost"]+$effect["add_lovkost"])+$effect["add_auvorot"];
		$db["sila"]=$db["sila"]+$effect["add_sila"];
		
		$udar_min1=$db["hand_r_hitmin"]+($db["sila"]+ceil($db["sila"]*0.4))+(int)(0+$k1['is_modified1']);
		$udar_max1=$db["hand_r_hitmax"]+($db["sila"]+ceil($db["sila"]*0.8))+(int)(0+$k1['is_modified1']);
		$udar_min2=$db["hand_l_hitmin"]+($db["sila"]+ceil($db["sila"]*0.4))+(int)(0+$k2['is_modified2']);
		$udar_max2=$db["hand_l_hitmax"]+($db["sila"]+ceil($db["sila"]*0.8))+(int)(0+$k2['is_modified2']); 
	?>
	� ����: <b><?echo "$udar_min1-$udar_max1".(($db["hand_l_type"]!="phisic" && $db["hand_l_type"]!="shield")?" / $udar_min2-$udar_max2":"");?></b><br/>
	� ��. ����. �����: <b><?echo $krit;?></b><br/>
	� ��. ������ ����. �����: <b><?echo $antikrit;?></b><br/>
	� ��. �����������: <b><?echo $uvorot;?></b><br/>
	� ��. ������ �����������: <b><?echo $antiuvorot;?></b><br/>
	� ��. �����������: <b><?echo ($db["parry"]+5);?></b><br/>
	� ��. ����������: <b><?echo ($db["counter"]+10) ;?></b><br/>
	� ��. ������ �����: <b><?echo ($db["proboy"]+5) ;?></b><br/><br/>

	� ��. �������� �����: <b><?echo (int)$db["ms_udar"];?></b><br/>
	� ��. �������� ������������ �����: <b><?echo (int)$db["ms_krit"];?></b><br/><br/>

	� ��. �������� ������� �����: <b><?echo (int)$db["ms_rub"];?></b><br/>
	� ��. �������� �������� �����: <b><?echo (int)$db["ms_kol"];?></b><br/>
	� ��. �������� ��������� �����: <b><?echo (int)$db["ms_drob"];?></b><br/>
	� ��. �������� �������� �����: <b><?echo (int)$db["ms_rej"];?></b><br/><br/>

	� ��. ������� �����: <b><?echo (int)$k1["add_rub"];?></b>-<b><?echo (int)$k2["add_rub"];?></b><br/>
	� ��. �������� �����: <b><?echo (int)$k1["add_kol"];?></b>-<b><?echo (int)$k2["add_kol"];?></b><br/>
	� ��. ��������� �����: <b><?echo (int)$k1["add_drob"];?></b>-<b><?echo (int)$k2["add_drob"];?></b><br/>
	� ��. �������� �����: <b><?echo (int)$k1["add_rej"];?></b>-<b><?echo (int)$k2["add_rej"];?></b><br/><br/>
	<?
	if (($db['intellekt']+$effect["add_intellekt"])>=125) 	    $add_ms_mag=25;
	else if (($db['intellekt']+$effect["add_intellekt"])>=100) 	$add_ms_mag=20;
	else if (($db['intellekt']+$effect["add_intellekt"])>=75) 	$add_ms_mag=15;
	else if (($db['intellekt']+$effect["add_intellekt"])>=50) 	$add_ms_mag=10;
	else if (($db['intellekt']+$effect["add_intellekt"])>=25)	$add_ms_mag=5;
	$add_ms_mag=$add_ms_mag+($db['intellekt']+$effect["add_intellekt"])*0.5
	?>
	� ��. �������� �����: <b><?echo (int)($db["ms_mag"]+$add_ms_mag);?></b><br/>
	� ��. �������� ����� ����: <b><?echo (int)($db["ms_fire"]+$add_ms_mag);?></b><br/>
	� ��. �������� ����� ����: <b><?echo (int)($db["ms_water"]+$add_ms_mag);?></b><br/>
	� ��. �������� ����� �������: <b><?echo (int)($db["ms_air"]+$add_ms_mag);?></b><br/>
	� ��. �������� ����� �����: <b><?echo (int)($db["ms_earth"]+$add_ms_mag);?></b><br/>
	� ��. �������� ����� �����: <b><?echo (int)($db["ms_svet"]+$add_ms_mag);?></b><br/>
	� ��. �������� ����� ����: <b><?echo (int)($db["ms_tma"]+$add_ms_mag);?></b><br/>
	� ��. �������� ����� �����: <b><?echo (int)($db["ms_gray"]+$add_ms_mag);?></b><br/><br/>
	</div>
<?
}
############################################################################################################
if ($_GET["view"]==4)
{
	?>
		<div class="aheader">
			<font color='#ff0000'><?=$msg;?></font>
		</div>
	<?
		echo "<div>";
		$used_priem=array();
		echo "<div class=\"aheader\"><b>��������� ������ ��� ���: </b></div><br/>";
		$aktiv_p = mysql_query("SELECT * FROM slots_priem LEFT JOIN priem on priem.id=slots_priem.priem_id WHERE user_id=".$db["id"]." ORDER BY sl_name ASC");
		while($aktiv_priem=mysql_fetch_array($aktiv_p))
		{
			$i++;
			$used_priem[]=(int)$aktiv_priem["priem_id"];
			if ($aktiv_priem["priem_id"]!=0)
			{
				if 	($db["level"] >= $aktiv_priem["level"] &&
					($db['intellekt']+$effect["add_intellekt"] >= $aktiv_priem["intellekt"])&& 
					($db["vospriyatie"] >= $aktiv_priem["vospriyatie"])&& 			
					($db["fire_magic"]+$effect["add_fire_magic"] >= $aktiv_priem["fire_magic"])&& 
					($db["earth_magic"]+$effect["add_earth_magic"] >= $aktiv_priem["earth_magic"])&& 
					($db["water_magic"]+$effect["add_water_magic"] >= $aktiv_priem["water_magic"])&& 
					($db["air_magic"]+$effect["add_air_magic"] >= $aktiv_priem["air_magic"])&& 
					($db["svet_magic"]+$effect["add_svet_magic"] >= $aktiv_priem["svet_magic"])&& 
					($db["tma_magic"]+$effect["add_tma_magic"] >= $aktiv_priem["tma_magic"])&& 
					($db["gray_magic"]+$effect["add_gray_magic"] >= $aktiv_priem["gray_magic"]))
					{
						echo "��� $i: <b>".$aktiv_priem["name"]."</b> [<a href='?action=unset_priem&sl_name=".$aktiv_priem["sl_name"]."'>�����</a>] [<a href='?view=6&view_rpiem=".$aktiv_priem["id"]."'>info</a>]<br/>";
					}
					else
					{
						mysql_query("UPDATE slots_priem SET priem_id=0 WHERE sl_name='".$aktiv_priem["sl_name"]."' and user_id = ".$db["id"]);	
						echo "���� $i: ������ ����<br/>";
					}
			}
			else echo "���� $i: ������ ����<br/>";
		}
		echo "<a href='?clear_abil=all'>��������</a>";
		echo "<div class=\"sep1\"></div>";
		echo "<div class=\"sep2\"></div>";
		echo "<div class=\"aheader\"><b>����� ��� ������:</b></div><br/>";
			$all_priem = mysql_query("SELECT * FROM priem WHERE view=0 ORDER BY mag ASC, level ASC, type ASC");
			while ($a_p = mysql_fetch_array($all_priem))
			{
				echo "<b>".$a_p["name"].":</b> ";
				if (in_Array($a_p["id"],$used_priem))echo "<font style='color:#696969'>�����</font>";
				else if ($db["level"] < $a_p["level"]) echo "<font style='color:#ff0000'>������ �����</font>";
				else echo "[<a href='?action=onset_priem&id=".$a_p["id"]."'>������</a>]";
				echo " [<a href='?view=6&view_rpiem=".$a_p["id"]."'>info</a>]<br/>";
			}
		echo "</div>";
}
############################################################################################################
if ($_GET["view"]==6)
{
	$view_rpiem=(int)$_GET["view_rpiem"];
	echo "<div>";
	#<img src="img/priem/' + t[i] + '.gif"  alt="" />
	$a_p = mysql_fetch_array(mysql_query("SELECT * FROM priem WHERE view=0 and id=$view_rpiem"));
	if($a_p)
	{
		echo "<div class=\"aheader\"><b>���� - ".$a_p["name"]."</b></div><br/>";
		echo "<img src='http://www.meydan.az/img/priem/misc/".$a_p["id"].".gif' border='0' /><br/>";
		echo 
		($a_p["hit"]?"<img src='http://www.meydan.az/img/priem/hit.gif'  alt='' border='0' />".$a_p["hit"]:"").($a_p["krit"]?"<img src='http://www.meydan.az/img/priem/krit.gif'  alt='' border='0' />".$a_p["krit"]:"").
		($a_p["block"]?"<img src='http://www.meydan.az/img/priem/block.gif'  alt='' border='0' />".$a_p["block"]:"").($a_p["uvarot"]?"<img src='http://www.meydan.az/img/priem/uvarot.gif'  alt='' border='0' />".$a_p["uvarot"]:"").
		($a_p["hp"]?"<img src='http://www.meydan.az/img/priem/hp.gif'  alt='' border='0' />".$a_p["hp"]:"").($a_p["all_hit"]?"<img src='http://www.meydan.az/img/priem/all.gif'  alt='' border='0' />".$a_p["all_hit"]:"").
		($a_p["parry"]?"<img src='http://www.meydan.az/img/priem/parry.gif'  alt='' border='0' />".$a_p["parry"]:"");
		echo "<br/><br/><b>��������� �����������:</b>".($a_p["wait"]?"<br/>� ��������: ".$a_p["wait"]:"").($a_p["level"]?"<br/>� �������: ".$a_p["level"]:"").($a_p["intellekt"]?"<br/>� ���������: ".$a_p["intellekt"]:"").
		($a_p["vospriyatie"]?"<br/>� ����������: ".$a_p["vospriyatie"]:"").($a_p["mana"]?"<br/>� ������ ����: ".$a_p["mana"]:"").($a_p["hod"]?"<br/>� ����� ������ ���":"").
		($a_p["water_magic"]?"<br/>� ���������� �������� ������� ����: ".$a_p["water_magic"]:"").($a_p["earth_magic"]?"<br/>� ���������� �������� ������� �����: ".$a_p["earth_magic"]:"").
		($a_p["fire_magic"]?"<br/>� ���������� �������� ������� ����: ".$a_p["fire_magic"]:"").($a_p["air_magic"]?"<br/>� ���������� �������� ������� �������: ".$a_p["air_magic"]:"").
		($a_p["svet_magic"]?"<br/>� ���������� �������� ������� �����: ".$a_p["svet_magic"]:"").($a_p["tma_magic"]?"<br/>� ���������� �������� ������� ����: ".$a_p["tma_magic"]:"").
		($a_p["gray_magic"]?"<br/>� ���������� �������� ����� �����: ".$a_p["gray_magic"]:"")."<br/><br/><b>��������:</b> ".$a_p["about"];
		
		echo "<br/><br/>[<a href='?view=4'>�����</a>]<br/><br/>";
	}
	echo "</div>";
}
############################################################################################################
if (!$_GET["view"])
{
	echo "
		<div class=\"aheader\"><img src='http://www.meydan.az/img/obraz/".$db["obraz"]."' border='0' /></div>
		<div>
		�����: ".$db["win"]."<br/>
		���������: ".$db["lose"]."<br/>
		������: ".$db["nich"]."<br/>
		����� ��� ���������: ".$db["monstr"]."<br/>
		���������: ".$db["reputation"]."<br/>
		��������: ".$db["doblest"]."<br/><br/><br/>
		������: <b>".number_format($db["money"], 2, '.', ' ')."</b> ��.<br>
		�������: <b>".number_format($db["platina"], 2, '.', ' ')."</b> ��.<br>
		�������: <b>".number_format($db["naqrada"], 2, '.', ' ')."</b> ��.<br>
		�������: <b>".number_format($db["silver"], 2, '.', ' ')."</b> ��.<br>
		�������: ".(50-$db["peredacha"])."
	</div>";
}
############################################################################################################
?>
<?
	mysql_close();
?>
<?include("bottom.php");?>
</div>