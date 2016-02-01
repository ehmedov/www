<?
include ("key.php");
include ("conf.php");
include ("align.php");
include ("functions.php");
header("Content-Type: text/html; charset=windows-1251");
header("Cache-Control: no-cache, must-revalidate"); // говорим браузеру что-бы он не кешировал эту страницу
header("Pragma: no-cache");
$random=md5(rand());
echo '<?xml version="1.0" encoding="windows-1251"?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.2//EN" "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="en">';
$login=$_SESSION["login"];
$uin_id=$_SESSION["uin_id"];
$message="";
$stack=array(60);
$data = mysql_connect($base_name, $base_user, $base_pass) or die('Не получается подключиться. Проверьте имя сервера, имя пользователя и пароль!');
mysql_select_db($db_name) or die('Ошибка входа в базу данных');

$db = mysql_fetch_array(mysql_query("SELECT * FROM users LEFT JOIN info on info.id_pers=users.id WHERE login='".$login."'"));
effects($db["id"],$effect);
include("fill_hp.php");
TestBattle($db);
if($db["room"]=="house")
{
	$_SESSION["message"]="Вы в Гостинице";
	Header("Location: main.php?tmp=".md5(time()));
	die();
}
$ip=$db["remote_ip"];
##############################################################################################
mysql_query("DELETE FROM `inv` WHERE owner='".$login."' and object_type='flower' and term<".time());
##############################################################################################
if ($_GET["delete"] && is_numeric($_GET["delete"]))
{	
	$drop_item=mysql_fetch_array(mysql_query("SELECT * FROM inv WHERE id='".$_GET["delete"]."' and owner='".$login."' and wear=0"));
	if (!$drop_item)
	{
		$_SESSION["message"]= "У вас нет такой вещь...";
	}
	else
	{
		if ($drop_item["name"]=="")$drop_item["name"]=htmlspecialchars(addslashes($_GET["name"]));
		mysql_query("DELETE FROM inv WHERE id='".$_GET["delete"]."' and wear=0");
		history($login,'Выбросил',$drop_item["name"],$ip,'Свалка');
		$_SESSION["message"]= "Вы удачно удалили предмет &quot".$drop_item["name"]."&quot!";
	}
}
##############################################################################################
$otdel="obj";
if (isset($_GET['otdel']))
{	
	$otdel=htmlspecialchars(addslashes($_GET['otdel']));
	$_SESSION['sess_otdel']=$otdel;
}
else 
{
	if (isset($_SESSION['sess_otdel']))
	{
		$otdel=$_SESSION['sess_otdel'];
	}
}
##############################################################################################
if ($_POST["unlock"])
{
	$lock=mysql_fetch_Array(mysql_query("SELECT pass FROM effects WHERE user_id=".$db["id"]." and type='lock'"));
	if ($lock["pass"]!= $_POST["unlock_psw"])
	{	
		$_SESSION["message"]="Неверный пароль";
	}
	else $_SESSION["lock"]=true;
}
if (!$_SESSION["lock"])
{
	$lock=mysql_fetch_Array(mysql_query("SELECT pass FROM effects WHERE user_id=".$db["id"]." and type='lock' and end_time>".time()));
	if ($lock && $lock["pass"]!="")$inventar_locked=true;
}
##############################################################################################
$sql1=mysql_fetch_Array(mysql_query("SELECT sum(mass),count(*) FROM inv WHERE inv.owner='".$login."' and inv.object_razdel='obj'"));

$sql2=mysql_fetch_Array(mysql_query("SELECT sum(scroll.mass),count(*) FROM inv LEFT JOIN scroll on scroll.id=inv.object_id WHERE inv.owner='".$login."' and inv.object_razdel='magic'"));

$sql3=mysql_fetch_Array(mysql_query("SELECT sum(wood.mass),count(*) FROM inv LEFT JOIN wood on wood.id=inv.object_id WHERE inv.owner='".$login."' and inv.object_razdel='thing'"));

$sql4=mysql_fetch_Array(mysql_query("SELECT sum(flower.mass),count(*) FROM inv LEFT JOIN flower on flower.id=inv.object_id WHERE inv.owner='".$login."' and inv.object_razdel='other'"));

$sql5=mysql_fetch_Array(mysql_query("SELECT sum(inv.mass),count(*) FROM inv LEFT JOIN runa on runa.id=inv.object_id WHERE inv.owner='".$login."' and inv.object_razdel='runa'"));

$mass=$sql1[0]+$sql2[0]+$sql3[0]+$sql4[0]+$sql5[0];
$al=$sql1[1]+$sql2[1]+$sql3[1]+$sql4[1]+$sql5[1];

if($mass>$db["maxmass"])
{
	$mass_style="color=#ff0000";
    if($db["movable"])
    {
    	mysql_query("UPDATE users SET movable='0' WHERE login='".$login."'");
    	$_SESSION["message"]="Вы перегружены и не можете перемещаться...";
    }
}
else
{
	$mass_style="";
    if(!$db["movable"])
    {
        mysql_query("UPDATE users SET movable='1' WHERE login='".$login."'");
        $_SESSION["message"]="Вы больше не перегружены...";
    }
}
##############################################################################################
if($_GET["wear"] && !$db["battle"] && !$db["zayavka"] && is_numeric($_GET["wear"]))
{
	if ($db["room"]!="smert_room" && $db["room"]!="house" && $db["room"]!="zadaniya")
	{
		wear($login,$_GET["wear"]);
	}
	else 
	{
		$_SESSION["message"]="В этой комнате невозможно одеватся";
	}
}
if($_GET["unwear"] && !$db["battle"] && !$db["zayavka"] && is_numeric($_GET["unwear"]))
{
	if ($db["room"]!="smert_room" && $db["room"]!="house" && $db["room"]!="zadaniya")
	{
		unWear($login,$_GET["unwear"]);
	}
}
if($_GET["act"]=="unwear_full" && !$db["battle"] && $db["room"]!="house")
{
	unwear_full($login);
}
##############################################################################################
if($_GET["act"]=="addToSlot" && !$db["battle"] && is_numeric($_GET['id']) && $db["room"]!="house")
{
	set_svitok($db,$_GET['id']);
}
if($_GET["act"]=="setdown_svitok" && !$db["battle"] && is_numeric($_GET['id']) && is_numeric($_GET['slot']) && $db["room"]!="house")
{
	setdown_svitok($db,$_GET['slot'],$_GET['id']);
}
##############################################################################################
if($_GET["act"]=="magic" && !$db["battle"] && $db["room"]!="house")
{
	$spell=(int)abs($_GET['spell']);
	$DATA = mysql_fetch_array(mysql_query("SELECT * FROM inv LEFT JOIN scroll on scroll.id=inv.object_id WHERE inv.id='".$spell."' and inv.owner='".$login."' and inv.object_razdel='magic' and inv.wear=0"));
	if ($DATA)
	{
		$elik_id=$DATA["object_id"];
		$mtype=$DATA["mtype"];
		$min_i = $DATA["min_intellekt"];
		$min_v = $DATA["min_vospriyatie"];
		$min_l = $DATA["min_level"];
		$orden = $DATA["orden"];
		$name = $DATA["name"];
		$mana = $DATA["mana"];
		$file = $DATA["files"];
		if($DATA["orden"])
		{
			if($orden == $db["orden"]){$ordens = 1;	}
			else{$ordens = 0;}
		}
		else{$ordens = 1;}

		if($db["intellekt"]+$effect["add_intellekt"]>=$min_i && $db["vospriyatie"]>=$min_v && $db["level"]>=$min_l && $ordens && $db["mana"]>=$mana)
		{
			if (file_exists("magic/".$file)) include "magic/".$file;
			else $_SESSION["message"]="Файл не найден! Введутся технические работы!";
		}
		else
		{
			$_SESSION["message"]="У Вас недостаточно параметров для кастования этого заклятия!";
		}
	}
	else
	{
		$_SESSION["message"]="Свиток не найден!";
	}
}
##############################################################################################
?>
<html>
<head>
	<title>WAP.MEYDAN.AZ</title>
	<link rel="stylesheet" href="main.css" type="text/css"/>	
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
	<meta http-equiv="Content-Language" content="ru" />
	<meta name="Description" content="Отличная RPG онлайн игра посвященная боям и магии. Тысячи жизней, миллионы смертей, два бога, сотни битв между Светом и Тьмой." />
	<meta http-equiv="cache-control" content="no-cache" />
	<meta http-equiv="pragma" content="no-cache" />
	<meta http-equiv="expires" content="0" />
</head>

<body>
<div id="cnt" class="content">
	<div class="aheader">
		<b>Инвентар</b><br/>
		<font color='#ff0000'><?echo $_SESSION["message"];$_SESSION["message"]="";?></font>
	</div>
	<?
	if ($_GET["info"])
	{
		$item_id=(int)$_GET["info"];
		$sql_info=mysql_fetch_Array(mysql_query("SELECT * FROM inv WHERE owner='".$login."' and object_razdel='obj' and id=".$item_id));
		if ($sql_info)
		{
			echo "<img src='http://www.meydan.az/img/items/".$sql_info["img"]."' border='0' /><br/>";
			echo show_item($db,$sql_info);
		}
	}
	else if($otdel=="obj")
	{
		showPlayer_inv($db);
		echo "<br/>[<a href=\"?act=unwear_full\">Снять все</a>]<br/>";
	}
	else if($otdel=="magic")
	{
		for ($j=0;$j<=1;$j++) 
		{
			for ($i=$j*6+100;$i<=$j*6+105;$i++) 
			{
			    echo showpic($db,$i,2);
			}
			unset($i);
		}
	}
	?>
	<div class="sep1"></div>
	<div class="sep2"></div>
	<div class="aheader">[<a href='?otdel=obj&<?=$random;?>'>Экипировка</a>] [<a href='?otdel=magic&<?=$random;?>'>Магия</a>] [<a href='?otdel=runa&<?=$random;?>'>Руны</a>] 
	[<a href='?otdel=other&<?=$random;?>'>Открытки</a>] [<a href='?otdel=thing&<?=$random;?>'>Ресурсы</a>] [<a href='?otdel=flud&<?=$random;?>'>Прочее</a>]</div>
	<div class="aheader"><? echo "Рюкзак (<font $mass_style>масса: ".round($mass,2)."</font>/".$db["maxmass"].", Всего вещей: $al)";?></div>	
	<div class="sep1"></div>
	<div class="sep2"></div>
	<?
	if ($inventar_locked)
	{
		echo "
		<form method='post' action=''>
			<div class=\"aheader\">
			<b>Рюкзак закрыт.</b><br/><img src='http://www.meydan.az/img/elik/lock.gif' border='0' /><br/>
			Введите пароль: <input type='password' name='unlock_psw' size='10' class='inup'  />
			<input type='submit' name='unlock' value='Открыть' class='inup' />
			</form>
			</div>";
		include("bottom.php");
		die();
	}	
	##############################################################################################	
	if ($otdel=="obj")
	{
		$sql_inv=mysql_query("SELECT * FROM inv WHERE object_razdel='obj' and owner='".$login."' and wear=0 and ".($db["bs"]?"bs=1":"bs=0")." ORDER BY UNIX_TIMESTAMP(date) DESC");
		if (!mysql_num_rows($sql_inv))echo "<br/><div class=\"aheader\"><b style='color:#ff0000'>ПУСТО</b></div><br/>";
		while($dat=mysql_fetch_array($sql_inv))
		{
			$wearable = 0;
			    if(	($db["sila"]+$effect["add_sila"])>=$dat["min_sila"] && 
			       	($db["lovkost"]+$effect["add_lovkost"])>=$dat["min_lovkost"] && 
			       	($db["udacha"]+$effect["add_udacha"])>=$dat["min_udacha"] && 
			    	($db["power"]>=$dat["min_power"]) &&
			    	($db["intellekt"]+$effect["add_intellekt"])>=$dat["min_intellekt"] && 
			    	($db["vospriyatie"]>=$dat["min_vospriyatie"]) && 
			    	($db["level"]>=$dat["min_level"]) &&
			    	($db["sword_vl"]+$effect["add_sword_vl"])>=$dat["min_sword_vl"] && 
			    	($db["staff_vl"]+$effect["add_staff_vl"])>=$dat["min_staff_vl"] &&
			    	($db["axe_vl"]+$effect["add_axe_vl"])>=$dat["min_axe_vl"] &&
			    	($db["hummer_vl"]+$effect["add_hummer_vl"])>=$dat["min_fail_vl"] &&
			    	($db["castet_vl"]+$effect["add_castet_vl"])>=$dat["min_knife_vl"] &&
			    	($db["copie_vl"]+$effect["add_copie_vl"])>=$dat["min_spear_vl"] &&
			    	($db["water_magic"]+$effect["add_water_magic"])>=$dat["min_water"] && 
			    	($db["earth_magic"]+$effect["add_earth_magic"])>=$dat["min_earth"] && 
			    	($db["fire_magic"]+$effect["add_fire_magic"])>=$dat["min_fire"] &&
			    	($db["air_magic"]+$effect["add_air_magic"])>=$dat["min_air"]
			    ){$wearable=1;}
				if ($dat["iznos"]>=$dat["iznos_max"])$wearable=0;
				if ($db['bs']==0 && $dat["bs"]==1)$wearable=0;
				if ($db['bs']==1 && $dat["bs"]==0)$wearable=0;
				if ($dat["object_type"]=='kostyl')$wearable=1;
				if ($dat["need_orden"]!=0 && $db["orden"]!=$dat["need_orden"])$wearable=0;
				
				if ($dat["term"]!="")
				{
					mysql_Query("DELETE FROM inv WHERE id=".$dat["id"]." and term<".time());
					if(mysql_affected_rows()>0)
					{
						$_SESSION["message"]="Закончился срок аренды <b>".$dat["name"]."</b>";
						history($login,"Закончился срок аренды",$dat["name"],$db["remote_ip"],"Инвентарь");
						Header("Location: inv.php?otdel=obj&tmp=".md5(time()));
					}
				}
			$desc="";
			if($dat["art"]==1){$desc.="<img src='http://www.meydan.az/img/artefakt.gif' border='0' /> ";}
			if($dat["art"]==2){$desc.="<img src='http://www.meydan.az/img/icon/artefakt.gif' border='0' /> ";}
			if($dat["podzemka"]){$desc.="<img src='http://www.meydan.az/img/icon/podzemka.gif' border='0' /> ";}
			if($dat["need_orden"]){$desc.="<img src='http://www.meydan.az/img/orden/".$dat["need_orden"]."/0.gif' border='0' /> ";}
			if($dat["is_runa"]){$desc.="<img src='http://www.meydan.az/img/icon/runa.gif' border='0' /> ";}
			$desc.="<b ".($dat["art"]==1?"style='color:#95486D;'":"").($dat["art"]==2?"style='color:#b22222;'":"").">".$dat["name"].($dat["is_modified"]?" +".$dat["is_modified"]:"")." (".$dat["iznos"]."/".$dat["iznos_max"].")</b> ";
			$desc.="<a href='?info=".$dat["id"]."'>[info]</a> ";
			$desc.=($wearable?"<a href='?wear=".$dat["id"]."'>[Надеть]</a>":"нельзя одеть");
			$desc.=" <a href='?delete=".$dat["id"]."'><img src='http://www.meydan.az/img/icon/del.gif' border='0' /></a>";
			echo $desc."<br/>";
		}
		mysql_free_result($sql_inv);
	}
	###############################################################################################
	else if($otdel=="magic")
	{
		$sql_inv = mysql_query("SELECT scroll.*, inv.id as ids, inv.iznos, inv.iznos_max, inv.term, inv.gift, inv.gift_author FROM inv LEFT JOIN scroll on scroll.id=inv.object_id WHERE inv.owner='".$login."' and inv.object_razdel='magic' and inv.wear=0 ORDER BY UNIX_TIMESTAMP(inv.date) DESC");
		if (!mysql_num_rows($sql_inv))echo "<br/><div class=\"aheader\"><b style='color:#ff0000'>ПУСТО</b></div><br/>";
		while($dat = mysql_fetch_array($sql_inv))
		{
			$spells_attack=array("Нападение", "Снежок", "Подмога", "Лечение травм", "Жажда жизни+1", "Жажда жизни+2", "Жажда жизни+3", "Жажда жизни+4", "Жажда жизни+5", "Жажда жизни+6");
			$animal_type=array("wolf","cheetah","bear","dragon","snake");
			$zatochka_name=array("Заточка оружия +3",
			"Заточка молоты и дубины +1","Заточка молоты и дубины +2","Заточка молоты и дубины +3","Заточка молоты и дубины +4","Заточка молоты и дубины +5",
			"Заточка молоты и дубины +6","Заточка молоты и дубины +7","Заточка молоты и дубины +8","Заточка молоты и дубины +9","Заточка молоты и дубины +10",

			"Заточка ножи +1","Заточка ножи +2","Заточка ножи +3","Заточка ножи +4","Заточка ножи +5",
			"Заточка ножи +6","Заточка ножи +7","Заточка ножи +8","Заточка ножи +9","Заточка ножи +10",
				
			"Заточка мечи +1","Заточка мечи +2","Заточка мечи +3","Заточка мечи +4","Заточка мечи +5",
			"Заточка мечи +6","Заточка мечи +7","Заточка мечи +8","Заточка мечи +9","Заточка мечи +10",
				
			"Заточка топоры +1","Заточка топоры +2","Заточка топоры +3","Заточка топоры +4","Заточка топоры +5",
			"Заточка топоры +6","Заточка топоры +7","Заточка топоры +8","Заточка топоры +9","Заточка топоры +10",
			
			"Заточка Посоха +1","Заточка Посоха +2","Заточка Посоха +3","Заточка Посоха +4","Заточка Посоха +5",
			"Заточка Посоха +6","Заточка Посоха +7","Заточка Посоха +8","Заточка Посоха +9","Заточка Посоха +10");
			echo "<b ".($dat["art"]?"style='color:#95486D;'":"").">".$dat["name"]." (".$dat["iznos"]."/".$dat["iznos_max"].")</b> ";
			if($dat["art"])echo "<img src='http://www.meydan.az/img/icon/artefakt.gif' border='0' /> ";
			if($dat["podzemka"]){echo "<img src='http://www.meydan.az/img/icon/podzemka.gif' border='0' /> ";}

	        if($dat["to_book"])
	        {
				echo "[<a href='?act=addToSlot&id=".$dat["ids"]."' class=us2>надеть</a>]";
	        }
	    	else
	        {
				if (in_array($dat["name"],$spells_attack))
				{	
					echo "[<a href='#'>исп-ть</a>]";
    			}
    			else if (in_array($dat["type"],$animal_type))
    			{
    				echo "<a href='#'>исп-ть</a>";
    			}
    			else if(in_array($dat["name"],$zatochka_name))
    			{
    				echo "[<a href='#'>исп-ть</a>]";
    			}
    			else if($dat["name"]=="Замок для рюкзака")
    			{
    				echo "[<a href='#'>исп-ть</a>]";
    			}
    			else
    			{
    				echo "[<a href='?act=magic&spell=".$dat["ids"]."'>выпит</a>]";
        		}
			}
			echo " <a href='?act=info_magic&item_id=".$dat["id"]."'>[info]</a> <a href='?delete=".$dat["ids"]."&name=".$dat["name"]."'><img src='http://www.meydan.az/img/icon/del.gif' border='0' /></a> ";
			if(in_array($spell_id,$stack))echo "<a href='?stack=".$dat["id"]."'><img src='http://www.meydan.az/img/icon/join.gif' alt='Собрать' style='cursor: hand' border='0' /> ";
	        if ($dat["del_time"]>0)
	        {
	        	echo "<br/><font style='color:#696969'>Срок: ".$dat["del_time"]." дн. (до ".(date('d.m.y H:i:s', $dat["term"])).")</font>";
	        	if ($term<time())
	        	{
	        		mysql_query("DELETE FROM inv WHERE id=".$dat["id"]);
	        		history($login,"Закончился срок годности",$dat["name"],$db["remote_ip"],"Инвентарь");
	        	}
	        }
	        echo "<br/><br/>";
		}
		mysql_free_result($sql_inv);
	}
	?>

	<?mysql_close();?>
	<?include("bottom.php");?>
</div>