<?
ob_start();
include ("key.php");
include ("conf.php");
header("Content-type: text/html; charset=windows-1251");
header("Cache-Control: no-cache, must-revalidate"); // говорим браузеру что-бы он не кешировал эту страницу
header("Pragma: no-cache");
$data   = mysql_connect($base_name, $base_user, $base_pass)or die ('Технический перерыв  . Приносим свои извинения. Администрация.');
mysql_select_db($db_name,$data);

$login=$_SESSION["login"];
echo '<?xml version="1.0" encoding="windows-1251"?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.2//EN" "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="en">';

$OTHER=mysql_fetch_array(mysql_query("SELECT clan, room, city_game FROM users WHERE login='".$login."'"));
$my_clan=$OTHER["clan"];
?>
<head>	
	<title>WAP.MEYDAN.AZ - Чат</title>
	<link rel="stylesheet" href="main.css" type="text/css"/>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
	<meta http-equiv="Content-Language" content="ru" />
	<meta name="Description" content="Отличная RPG онлайн игра посвященная боям и магии. Тысячи жизней, миллионы смертей, два бога, сотни битв между Светом и Тьмой." />
	<meta http-equiv="cache-control" content="no-cache" />
	<meta http-equiv="pragma" content="no-cache" />
	<meta http-equiv="expires" content="0" />
</head>
<body>

<div class='content'>
<?
$file_chat = file("/srv/www/meydan.az/public_html/chat/lovechat");
#$file_chat = file("C:\AppServ\www\ever\chat\lovechat");

$file_chat = array_reverse($file_chat);

$total = count($file_chat);
$chat_array=array();
for ($i = 0; $i < $total; $i++)
{
	$data_chat = explode("::",$file_chat[$i]);
	if($data_chat[2]!="sys" && $data_chat[2]!="sys_news" && !strpos($data_chat[4], "endSys"))$chat_array[]=$data_chat;
}

$total = count($chat_array);
$ttt=30;

if (empty($_GET['start'])) $start = 0; else $start = (int)$_GET['start'];
if ($total < $start + $ttt){ $end = $total; }
else {$end = $start + $ttt; }

for ($i = 0; $i < $total; $i++)
{
	$classdate = "date";
	#$time =date("d.m.y H:i",$chat_array[$i][1]);
	$time =date("H:i",$chat_array[$i][1]);
	$name = $chat_array[$i][2];
	$color = $chat_array[$i][3];
	$body = $chat_array[$i][4];
	$msg_room = $chat_array[$i][5];
	$msg_city = $chat_array[$i][6];
	$have_ignor=mysql_fetch_Array(mysql_Query("SELECT count(*) FROM ignor WHERE login='".$login."' and ignored='".$name."'"));
	if (eregi ("to \[$login\]", $body, $regs)) 
	{
		$classdate = "date2"; $forom = 1;
	} 
	if (eregi ("private \[$login\]", $body, $regs)) 
	{
		$classdate = "date2";
	}
	if (eregi ("clan \[$my_clan\]", $body, $regs)) 
	{
		$classdate = "date2";
	}
	
	
	if (substr($body, 0, 7) == "private")
	{
		if (eregi ("private \[$login\]", $body, $regs))
		{
			if (!$have_ignor[0])
			{
				$massages.= "<font class='$classdate'>$time</font> [<a href='?who=$name'>$name</a>] <font color='$color'>$body</font> <br/>";
			}
		}
		else if ($name == $login && $OTHER["city_game"]==$msg_city)
		{
			if (!$have_ignor[0])$massages .= "<font class='$classdate'>$time</font> [<a href='?who=$name'>$name</a>] <font color='$color'>$body</font><br/>";
		}
	}
	else if (substr($body, 0, 4) == "clan")
	{
		if (eregi("clan \[$my_clan\]", $body))
		{
			$massages .= "<font class='$classdate'>$time</font> [<a href='?who=$name'>$name</a>] <font color='$color'>$body</font> <BR/>";
		}
	}
	else if ($forom == 1 &&  $OTHER["room"]==$msg_room && $OTHER["city_game"]==$msg_city)
	{
		if (!$have_ignor[0])$massages .= "<font class='$classdate'>$time</font> [<a href='?who=$name'>$name</a>] <font color='$color'>$body</font> <br/>";
	} 
	else if ($_GET['fltr'] != 1 && $OTHER["room"]==$msg_room && $OTHER["city_game"]==$msg_city)
	{
		if (!$have_ignor[0])$massages .= "<font class='$classdate'>$time</font> [<a href='?who=$name'>$name</a>] <font color='$color'>$body</font> <br/>";
	}
}
echo "<div><br/>";
	echo $massages;
	echo "<br/><center>";
	#if ($start != 0) {echo '<small><a href="?start='.($start - $ttt).'">Назад</a></small> ';}
	#if ($total > $start + $ttt) {echo ' <small><a href="?start='.($start + $ttt).'">Далее</a></small>';}
	echo"<br/><a href=\"chat.php\">Обновить</a>"; 
	echo"
	<br/>
	<form method=\"post\" action='add.php'>
		Приват: <input type=\"checkbox\" class=\"inup\"  name=\"private\" /> 
		<input type=\"text\" class=\"inup\"  name=\"who\" maxlength=\"30\" size=\"10\" value=\"".htmlspecialchars(addslashes($_GET["who"]))."\" /> 
		<input type=\"text\" class=\"inup\"  name=\"msgchat\" maxlength=\"150\" size=\"35\" value=\"\" />
		<input type=\"submit\" class=\"inup\" value=\"OK\" />
	</form><br/>";
echo "</div>";
?>	
<?include("bottom.php");?>
</div>
</html>