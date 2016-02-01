<?
ob_start();
session_start();
include ("conf.php");
include ("functions.php");
include ("align.php");

header("Content-type: text/html; charset=windows-1251");
header("Cache-Control: no-cache, must-revalidate"); // говорим браузеру что-бы он не кешировал эту страницу
header("Pragma: no-cache");
$data = mysql_connect($base_name, $base_user, $base_pass) or die('Не получается подключиться. Проверьте имя сервера, имя пользователя и пароль!');
mysql_select_db($db_name) or die('Ошибка входа в базу данных');
	
echo '<?xml version="1.0" encoding="windows-1251"?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.2//EN" "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="en">';
$log_name = htmlspecialchars(addslashes(trim($_GET['log'])));
$db=mysql_fetch_array(mysql_query("SELECT users.*,info.*,zver.id as zver_count,zver.obraz as zver_obraz,zver.level as zver_level,zver.name as zver_name,zver.type as zver_type FROM `users` LEFT JOIN info on info.id_pers=users.id LEFT JOIN zver on zver.owner=users.id and zver.sleep=0 WHERE login='".$log_name."'"));
if(!$db || !$log_name)
{
	echo '
	<html>
	<head>
		<title>WAP.MEYDAN.AZ - Произошла ошибка</title>
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
		<b style="color:#ff0000;">Произошла ошибка:</b> <br>Указанный персонаж не найден...
		<div class="sep1"></div>
		<div class="sep2"></div>
		© Администрация <b>Wap.MeYdaN.Az - Самый азартный проект в Азербайджане!</b>';
		include("bottom.php");
		die();
	echo '</div>';
}
effects($db["id"],$effect);
switch (voin_type($db)) 
{
	case "silach":$v_type = "Силач";break;
	case "krit":$v_type = "Критовик";break;
	case "uvarot":$v_type = "Уворотчик";break;
	case "mag":$v_type = "Маг";break;
	case "antikrit":$v_type = "Анти-Критовик";break;
}
####################################################################################
include ("fill_hp.php");
testCureTravm($db["login"]);
####################################################################################
?>
<html>
<head>
	<title><?echo $db["login"];?> - Информация о персонаже</title>
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
	<?include("header_info.php");?>
	<div>
		<?
	        if($db["orden"]) 
	        {
	        	echo "<img src='http://www.meydan.az/img/orden/".$db["orden"]."/".$db["admin_level"].".gif' border='0' alt='".getalign($db["orden"])."' title='".getalign($db["orden"])."' /> <b>".getalign($db["orden"])."</b><br/>";
				if ($db["otdel"])echo "Должность: <b>".$db["otdel"]."</b><br/>";
	        }
			if ($db["parent_temp"])
			{
				echo "Назначил: <b><a href='info.php?log=".$db["parent_temp"]."'>".$db["parent_temp"]."</a></b><br/>";
			}
	        if($db["clan_short"])
	        {
				echo "<img src='http://www.meydan.az/img/clan/".$db["clan_short"].".gif' border='0' alt='".$db["clan"]."' title='".$db["clan"]."' /> <b>Ханство: <a href='http://www.meydan.az/clan_inf.php?clan=".$db["clan_short"]."'>".$db["clan"]."</a></b><br/>";
				echo "<b>Должность: ".$db["chin"]."</b><br/>";
	        }
		?>
	</div>
	<div>
		<?
			echo "
			Сила: ".($db['sila']+$effect["add_sila"])."<br/>
			Ловкость: ".($db['lovkost']+$effect["add_lovkost"])."<br/>
			Удача: ".($db['udacha']+$effect["add_udacha"])."<br/>
			Выносливость: ".$db['power']."<br/>";
			if ($db["level"]>1) 
			{
				echo "Интеллект: ".($db['intellekt']+$effect["add_intellekt"])."<br/>
					  Восприятие: ".$db['vospriyatie']."<br/>";
			}
			if ($db['level'] > 9)
			{
				echo "Духовность: ".$db['duxovnost']."<br/>";
			} 
		?>
	</div>
	<div class="sep1"></div>
	<div class="sep2"></div>
	<div>
		Побед: <?echo $db["win"];?><br/>
		Поражений: <?=$db["lose"];?><br/>
		Ничьих: <?=$db["nich"];?><br/>
		Побед над монстрами: <?=$db["monstr"];?><br/>
		Репутация: <?=$db["reputation"];?><br/>
		Доблесть: <?=$db["doblest"];?><br/>
	</div>
	<div class="sep1"></div>
	<div class="sep2"></div>
	<div>		
		Тип Воина: <b><?echo $v_type;?></b><br/>
		Статус: <b><?echo $db["status"];?></b><br/>
		Место рождения: <b><?echo strtoupper($db["born_city"]);?></b><br/>
		Родился: <?echo  $db["date"];?><br/>
	</div>
	<div class="sep1"></div>
	<div class="sep2"></div>
	<div>
	<?
	if($db["obezlik"]>time())
	{
		echo "<b>Обезличен еще ".convert_time($db["obezlik"])."</b>";
	}
	else
	{	
		echo "
		<center><b>Анкетные данные</b></center><br/>
		<b>Имя:</b> ".$db["name"]."<br/>
	    <b>Пол:</b> ".(($db["sex"] == "male")?"Мужской":"Женский")."<br/>
		<b>Город:</b> ".$db["town"]."<br/>";
		if ($db["deviz"]) echo "<b>Девиз: </b>".$db["deviz"]."<br/>";
		if($db["icq"]) echo "<b>ICQ номер: </b>".$db["icq"]."<br/>";
		if($db["hobie"])
		{
			$db["hobie"]=str_replace("&amp;","&",$db["hobie"]);
			$db["hobie"]=wordwrap($db["hobie"], 40, " ",1);
			$db["hobie"]=str_replace("\n","<br>",$db["hobie"]);
			$db["hobie"]=str_replace("\n","<br/>",$db["hobie"]);
			echo "<br><b>Дополнительная информация:</b><br/>".$db["hobie"];
		}
	}
	if(($$db["metka"]+5*24*60*60)>time())
	{
		$tim=$db["metka"]+5*24*60*60;
		echo "<br/><font color='#ff0000'><b>Метка:</b> Удачно пройдена проверка, время прохождения: <b>".date("d.m.Y",$db["metka"])."</b> (Еще ".convert_time($tim).")<br/>";
	}
	mysql_close();
	?>
	</div>	
	<?include("bottom.php");?>
</div>
</html>