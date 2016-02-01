<?
ob_start();
include ("key.php");
include ("conf.php");
include ("flood.php");
header("Content-type: text/html; charset=windows-1251");
header("Cache-Control: no-cache, must-revalidate"); // говорим браузеру что-бы он не кешировал эту страницу
header("Pragma: no-cache");
$data   = mysql_connect($base_name, $base_user, $base_pass)or die ('Технический перерыв  . Приносим свои извинения. Администрация.');
mysql_select_db($db_name,$data);

$login=$_SESSION["login"];
echo '<?xml version="1.0" encoding="windows-1251"?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.2//EN" "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="en">';
$db=mysql_fetch_Array(mysql_query("SELECT * FROM users WHERE login='".$login."'"));

$chat_base = "/srv/www/meydan.az/public_html/chat/lovechat";
#$chat_base = "C:\AppServ\www\ever\chat\lovechat";

if ($_POST["who"])
{
	if($_POST["private"])$_POST["msgchat"]="private [".$_POST["who"]."] ".$_POST["msgchat"];
	else $_POST["msgchat"]="to [".$_POST["who"]."] ".$_POST["msgchat"];
}
$text=htmlspecialchars(addslashes($_POST["msgchat"]));
$text=substr($text, 0, 100);
$text=str_replace("&amp;","&",$text);

if ($_SESSION["chat_text"]==$text)
{
	$msg_err="Flood";
}	
else if ($db["shut"]>time())
{
	$msg_err="Молчанка: ".convert_time($db["shut"]);
}
else if ($db["blok"]>time())
{
	Header("Location: index.php");die();
}
else
{
	if ($db["clan"]=="")$text=str_replace("clan [","ЗАПРЕЩЕННЫЕ СЛОВА",$text);
	if ($db["level"]==0)$text=str_replace("private","to",$text);

	$tmp_text=str_replace($flood,"",$text);
	if ($tmp_text!=$text)
	{
		$text="ЗАПРЕЩЕННЫЕ СЛОВА";
		if (!$db["admin_level"] && !$db["dealer"])
		{
			$time2=time()+1800;
			mysql_query("UPDATE users SET shut='".$time2."',shut_reason='Использование ненормативной лексики в чате' WHERE login='".$login."'");
			$msg_err.="Автоматически наложено заклинания молчания на персонажа <b>&quot".$login."&quot</b> на 30 мин. <b>Причина:</b> <i>Использование ненормативной лексики в чате.</i>";
		}
	}
	$text = wordwrap(trim($text), 100, " ",1);

	$fopen_chat = fopen($chat_base,"a");
	fwrite ($fopen_chat,"::".time()."::".$login."::".$db["color"]."::".$text."::".$db["room"]."::".$db["city_game"]."::\n");
	fclose ($fopen_chat);
	$msg_err.="Сообщение добавлено";
	//-------------archive---------------
	/*$baza_name=date("dmY"); 
	$fopen_chat = fopen("data/".$baza_name,"a");
	fwrite ($fopen_chat,"::".$micro."::".$login."::".$OTHER["color"]."::".$text."::".$OTHER["room"]."::".$OTHER["city_game"]."::\n");
	fclose ($fopen_chat);*/		

}
//----------------------------------
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
	<div>	
	<?
		echo "<b>".$msg_err."</b><br/><a href='chat.php'>Назад</a>";
		echo "<meta http-equiv=refresh CONTENT=\"5;URL=chat.php\">";	
	?>
	</div>
<?include ("bottom.php");?>
</div>
</html>