<?
include ("key.php");
include ("conf.php");
include ("align.php");
include ("functions.php");
header("Content-Type: text/html; charset=windows-1251");
header("Cache-Control: no-cache, must-revalidate"); // говорим браузеру что-бы он не кешировал эту страницу
header("Pragma: no-cache");
echo '<?xml version="1.0" encoding="windows-1251"?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.2//EN" "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="en">';
$login=$_SESSION["login"];
$uin_id=$_SESSION["uin_id"];
$message="";
$data = mysql_connect($base_name, $base_user, $base_pass) or die('Не получается подключиться. Проверьте имя сервера, имя пользователя и пароль!');
mysql_select_db($db_name) or die('Ошибка входа в базу данных');
$db = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE login='".$login."'"));
TestBattle($db);
if($db["room"]=="house")
{
	Header("Location: main.php?tmp=".md5(time()));
	die();
}
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
	<?
		$zver=mysql_fetch_array(mysql_query("SELECT * FROM zver WHERE owner=".$uin_id." and sleep=0"));
		##################################################################################################
		if($_GET["action"]=='energy')
		{
			$items=mysql_fetch_array(mysql_query("SELECT scroll.add_energy, inv.id FROM inv LEFT JOIN scroll ON scroll.id=inv.object_id WHERE inv.owner='".$login."' and inv.object_razdel='food' and scroll.ztype='".$zver["type"]."'"));
			if($items)
			{
				$add_energy=$items["add_energy"];
				if($zver["max_energy"] - $zver["energy"]<$add_energy)
				{
					$add_energy = $zver["max_energy"] - $zver["energy"];
				}
				$new_sitost = $zver["energy"] + $add_energy;
				if ($add_energy>0)
				{	
					mysql_query("UPDATE zver SET energy='".$new_sitost."' WHERE id=".$zver["id"]);
					mysql_query("UPDATE `inv` SET iznos=iznos+1 WHERE id = '".$items["id"]."'");
					$INV     = mysql_fetch_array(mysql_query("SELECT * FROM `inv` WHERE id = '".$items["id"]."'"));
					if($INV["iznos"]>=$INV["iznos_max"])
					{
						mysql_query("DELETE FROM `inv` WHERE id = '".$items["id"]."'");
						$message.="<br>Свиток полностью использован.";
					}
					$zver["energy"]=$new_sitost;
					$message.="Вы пополнили энергию зверя на ".$new_sitost;
				}
				else $message="Ваш зверь сыт";
			}
			else $message="У вас нет подходяший еды...";
		}
		##################################################################################################
		if (!$zver)
		{
			echo "<h3>У вас нету зверя</h3>";
		}
		else
		{
			echo "<div class='aheader'><b>".$zver["name"]."</b> [".$zver["level"]."]<br/><img src='http://www.meydan.az/img/".$zver['obraz']."' border='0' /><br/><font color='ff0000'>".$message."</font></div>";
			echo "
			<div>
				<b>HP</b>: ".$zver["hp_all"]."<br/><br/>
				<b>Сила</b>: ".$zver["sila"]."<br/>
				<b>Ловкость</b>: ".$zver["lovkost"]."<br/>
				<b>Удача</b>: ".$zver["udacha"]."<br/>
				<b>Выносливость</b>: ".$zver["power"]."<br/><br/>

				<b>Уровень</b>: ".$zver["level"]."<br/>
				<b>Опыт</b>: ".$zver["exp"]."/".$zver["next_up"]."<br/>
				<b>Энергия</b>: ".$zver["energy"]."/".$zver["max_energy"]." [<a href='?action=energy'>Скормить</a>]<br/><br/>";
				if ($zver["level"]>0)
				{
					switch ($zver["type"]) 
					{
						 case "wolf":	$txt = "• Удача + ".($zver["level"]);break;
						 case "bear":	$txt = "• Сила + ".($zver["level"]);break;
					 	 case "cheetah":$txt = "• Ловкость + ".($zver["level"]);break;
					 	 case "snake":	$txt = "• Интеллект + ".($zver["level"]);break;
					}

					echo "<b>Освоенные навыки</b>:<br/>$txt";
				}
				if ($zver["two_hands"]>time())
				{
					echo "<br/><br/><b>Состояние</b>:<br/> Двуручный Зверь: Еще".convert_time($zver['two_hands']);
				}
			echo "</div>";
		}

	    mysql_close();
	?>
	<?include("bottom.php");?>
</div>