<?
	ob_start();
	include ("key.php");
	include ("conf.php");
	include ("functions.php");
	include ("align.php");

	header("Content-type: text/html; charset=windows-1251");
	header("Cache-Control: no-cache, must-revalidate"); // ������� �������� ���-�� �� �� ��������� ��� ��������
	header("Pragma: no-cache");
	$data = mysql_connect($base_name, $base_user, $base_pass) or die('�� ���������� ������������. ��������� ��� �������, ��� ������������ � ������!');
	mysql_select_db($db_name) or die('������ ����� � ���� ������');
	$login=$_SESSION["login"];
	echo '<?xml version="1.0" encoding="windows-1251"?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.2//EN" "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="en">';
if($break == 1) 
{
	Header("Location: index.php");
    die();
}
$have_ses=mysql_fetch_Array(mysql_Query("SELECT count(*) FROM online WHERE uniqPCID='".session_id()."' and login='".$login."'"));
if (!$have_ses[0])
{
	Header("Location: index.php?logout=".md5(time()));
 	die();
}
$db=mysql_fetch_array(mysql_query("SELECT users.*,zver.id as zver_count,zver.obraz as zver_obraz,zver.level as zver_level,zver.name as zver_name,zver.type as zver_type FROM `users` LEFT join zver on zver.owner=users.id  and zver.sleep=0 WHERE login='".$login."'"));
effects($db["id"],$effect);
######################################################
TestBattle($db);
testPrision($db);
testCureTravm($login);
if ($db["exp"]>=$db["next_up"])
{	
	testUps($db);
}
if ($db["zver_count"])
{
	$zver_db=mysql_fetch_assoc(mysql_query("SELECT * FROM zver WHERE id=".$db["zver_count"]));
	if ($zver_db["exp"]>=$zver_db["next_up"])
	{	
		testZverUp($zver_db,$db["login"]);
	}
}
######################################################
if($db["son"]==0)
{
	########################## ����� ����� ############################################
	$have_elik=mysql_fetch_Array(mysql_query("SELECT * FROM effects WHERE user_id=".$db["id"]." and type='jj'"));
	if ($have_elik)
	{
		if ($have_elik["end_time"]<time())
		{
			mysql_query("UPDATE users SET hp_all=hp_all-".$have_elik["add_hp"]." WHERE login='".$db["login"]."'");
			mysql_query("DELETE FROM effects WHERE id=".$have_elik["id"]);
			$_SESSION["message"].="�������� �������� <b>������ �����+?�</b> �����������!!!<br/>";
		}
	}
	####################################################################################
	mysql_query("DELETE FROM effects WHERE user_id=".$db["id"]." and end_time<".time()." and type!='jj'");
	if(mysql_affected_rows()>0)$_SESSION["message"].="�������� �������� �����������!!!<br/>";
}
####################################################################################
include ("fill_hp.php");
####################################################################################
$room=$db["room"];
if($_GET["act"]=="go")
{	
	$changeroom=false;
	$level=$_GET["level"];
	if (in_array($level,array("room4","municip")) && $room=="arena") {$changeroom=true;}
	else if (in_array($level,array("room3")) && $room=="arena") 
	{
		if ($db["level"]>=7  ||$db["orden"]==1)$changeroom=true;
		else $mess="��� ������� �� ��������� ������ � ��� ������� (������ 7 � ����).";
	}
	else if (in_array($level,array("room5")) && $room=="arena") 
	{
		if ($db["level"]>=9  ||$db["orden"]==1)$changeroom=true;
		else $mess="��� ������� �� ��������� ������ � ��� ������� (������ 9 � ����).";
	}
	else if (in_array($level,array("room2")) && $room=="arena") 
	{
		if ($db["orden"]==1)$changeroom=true;
		else $mess="�� �� ������ ����� � ��� �������, ��� ��� �� ��������� �����������.";
	}
	else if (in_array($level,array("room1")) && $room=="arena") 
	{
		if ($db["orden"]==1)$changeroom=true;
		else $mess="��� ������� �� ��������� ������ � ��� �������.";
	}
	else if ($level=="room6" && $room=="arena")
	{
		if($db["sex"]=="female" || $db["orden"]==1) {$changeroom=true;}
		else $mess="���� �������� ������ ��������...";
	}
	else if ($room=="room1" && $level=="arena" && $db["level"]>0) {$changeroom=true;}
	else if (in_array($room,array("room2","room3","room4","room5","municip","room6")) && $level=="arena") {$changeroom=true;}
	else if (in_array($level,array("bazar", "remesl")) && $room=="municip") {$changeroom=true;}
	else if (in_array($level,array("municip")) && in_array($room,array("bazar","remesl"))) {$changeroom=true;}
	else if (in_array($level,array("okraina")) && in_array($room,array("remesl"))) {$changeroom=true;}
	else if (in_array($level,array("remesl", "house")) && in_array($room,array("okraina"))) {$changeroom=true;}
	else if (in_array($level,array("okraina")) && in_array($room,array("house"))) 
	{
		if ($db["son"]==0)$changeroom=true;
		else {$mess="�� �� ������ ������������ �� ������� ���!";$changeroom=false;}
	} 
	else if (in_array($level,array("bank")) && in_array($room,array("remesl"))) {$changeroom=true;}
	else if (in_array($level,array("remesl")) && in_array($room,array("bank"))) {$changeroom=true;}
	########################################################################
	if($db["zayavka"])
	{
		$mess="�� ������ ������ � �� ������ ������������! ";$changeroom=false;
	}
	if(!$db["movable"] && !in_array($db["room"],array("smert_room","towerin","crypt","dungeon","canalization","mount","crypt","crypt_floor2","labirint_led","war_labirint")))
	{
		$mess="�� ����������� � �� ������ ������������! ";$changeroom=false;
	}
	if($db["travm_var"]>0 && ($db["hand_r_type"]!="kostyl" || $db["hand_l_type"]!="kostyl") && !in_array($db["room"],array("smert_room","towerin","crypt","dungeon","canalization","mount","crypt","crypt_floor2","labirint_led","war_labirint")))
	{
		$mess="� ��� ������� ��� ������� ������. �� �� ������ ������������! ";$changeroom=false;
	}
	if ($changeroom)
	{
		mysql_query("UPDATE users, online SET users.room='".$level."', online.room='".$level."' WHERE online.login=users.login and online.login='".$login."'");
		$room=$level;
		$db["room"]=$level;
	}
	else 
	{
		if (!$mess) $err_msg.="�� �� ������ ��� ������.";
		else $err_msg.=$mess;
	}
}
?>
<html>
<head>
	<title>WAP.MEYDAN.AZ</title>
	<link rel="stylesheet" href="main.css" type="text/css" />
	<link rel="shortcut icon" type="image/x-icon" href="img/icon/favicon.ico" />
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
	<meta http-equiv="Content-Language" content="ru" />
	<meta name="Description" content="�������� RPG ������ ���� ����������� ���� � �����. ������ ������, �������� �������, ��� ����, ����� ���� ����� ������ � �����." />
	<meta http-equiv="cache-control" content="no-cache" />
	<meta http-equiv="pragma" content="no-cache" />
	<meta http-equiv="expires" content="0" />
</head>
<body>
<div id="cnt" class="content">
	<div class="aheader"><b style='color:#ff0000'><?=$_SESSION["message"]; $_SESSION["message"]="";?></b></div><br/>
	<?
	include("header.php");
	?>
	<div class="aheader"> 
		<a href='smscoin.php'>���������� ����� ����� SMS</a><br/>
	 	<a href='who.php'>������� ��-����</a><br/>
	 	<a href='http://www.meydan.az/extable.php'>������� �����</a><br/>
	</div>
	<div class="sep1"></div>
	<div class="sep2"></div>
	<div class="aheader">
		<br/>
		<a href='char.php'>��������</a><br/>
	 	<a href='inv.php'>��������</a><br/>
	 	<?if ($db["orden"]==1)
		{?>
			<a href='orden.php'>������ �������</a><br/>
		<?}?>
	 	<?if ($db["zver_count"])
		{?>
			<a href='animal.php'>�����</a><br/>
		<?}?>
	 	<a href='anket.php'>�������� ������</a><br/>
	 	<a href='security.php'>������������</a><br/>
	 	<a href='ordman.php'>���������� ����</a><br/>
		<a href='chat.php'>���</a><br/><br/>	
		<a href='index.php?logout=true'>�����</a><br/><br/>
	</div>
	<?
	if (in_array($db["room"],array("room1","room2","room3","room4","room5")))
	{
		?>
			<div class="sep1"></div>
			<div class="sep2"></div>
			<div class="sep1"></div>
			<div class="aheader">
				[<a href='zayavkatrain.php'>�������������</a>]<br/>
				[<a href='zayavka.php'>���������</a>]<br/>
				[<a href='group.php'>���������</a>]<br/>
				[<a href='haot.php'>�����������</a>]<br/>
				[<a href='during.php'>�������</a>]<br/>
			</div>
		<?
	}
	?>
	<div class="sep3">
		<?
			include ("otaqlar.php");
			echo "<b>��������������</b>: <a href='main.php'>".$mesto."</a> (".roomcount($room)." ���.)";
		?>
	</div>
	<div class="aheader">
		<?
			echo "<b style='color:#ff0000'>".$err_msg."</b><br/>";
			include("room_detect.php");
		?><br/>
	</div>	
	<?include("bottom.php");?>
</div>
</html>