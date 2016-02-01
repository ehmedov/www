<?
include ("key.php");
include ("../conf.php");
include ("config.php");
include ("flood.php");

header("Content-Type: text/html; charset=windows-1251");
Header("Cache-Control: no-cache, must-revalidate"); // говорим браузеру что-бы он не кешировал эту страницу
Header("Pragma: no-cache");

$my_login = $_SESSION["login"];
$my_remote=getenv('REMOTE_ADDR');
$micro = time();


if ($_SESSION["count_all"]=="") {$count_time = $micro - 15*60;}else{$count_time = $_SESSION["count_all"];}


$data = mysql_connect($base_name, $base_user, $base_pass) or die('Не получается подключиться. Проверьте имя сервера, имя пользователя и пароль!');
mysql_select_db($db_name) or die('Ошибка при подключении к БД');

$OTHER=mysql_fetch_array(mysql_query("SELECT users.remote_ip, users.room, users.city_game, users.battle ,users.clan, users.clan_short, users.blok, users.shut, users.level, users.admin_level, users.adminsite, users.dealer, users.color, online.uniqPCID FROM online LEFT JOIN users on users.login=online.login WHERE online.login='".$my_login."'"));
$my_clan=$OTHER["clan"];
$_SESSION["clan_short"]=$OTHER["clan_short"];
$_SESSION["my_battle"]=$OTHER["battle"];
//-------------------------------------------------------------------------------------------
if($OTHER["uniqPCID"]!=$_SESSION["session_user_id"] || $break || $OTHER["blok"])
{
    echo "<script>top.window.location = '../index.php';</script>";
    die();
}
//--------------------------РЕФРЕШНЫЙ ФРЕЙМ---------------------------------------------------
if ($_GET['text']!="" && $OTHER["shut"]<time())
{
	$text=AddSlashes(HtmlSpecialChars($_GET['text']));
	$text=str_replace("&amp;","&",$text);
	if ($OTHER["clan"]=="")$text=str_replace("clan [","<b style=color:#ff0000>ЗАПРЕЩЕННЫЕ СЛОВА</b>",$text);
	if ($OTHER["level"]==0)$text=str_replace("private","to",$text);

	$tmp_text=str_replace($flood,"",$text);
	if ($tmp_text!=$text)
	{
		$text="<b style=color:#ff0000>ЗАПРЕЩЕННЫЕ СЛОВА</b>";
		if (!$OTHER["admin_level"] && !$OTHER["dealer"])
		{
			$time2=time()+1800;
			mysql_query("UPDATE users SET shut='".$time2."',shut_reason='Использование ненормативной лексики в чате' WHERE login='".$my_login."'");
			de("toall","Автоматически наложено заклинания молчания на персонажа <b>&quot".$my_login."&quot</b> на 30 мин. <b>Причина:</b> <i>Использование ненормативной лексики в чате.</i>",$my_login,$OTHER["room"],$OTHER["city_game"]);
		}
	}
	$text = wordwrap(trim($text), 100, " ",1);
	#if ($OTHER["adminsite"])$text="<b>".$text."</b>";

	$fopen_chat = fopen($chat_base,"a");
	fwrite ($fopen_chat,"::".$micro."::".$my_login."::".$OTHER["color"]."::".$text."::".$OTHER["room"]."::".$OTHER["city_game"]."::\n");
	fclose ($fopen_chat);
	//-------------archive---------------
	$baza_name=date("dmY"); 
	$fopen_chat = fopen("data/".$baza_name,"a");
	fwrite ($fopen_chat,"::".$micro."::".$my_login."::".$OTHER["color"]."::".$text."::".$OTHER["room"]."::".$OTHER["city_game"]."::\n");
	fclose ($fopen_chat);		
	//----------------------------
	echo "<SCRIPT> top.CLR1(); </SCRIPT>"; 
}
//-------------Считать масаги------------------------------------------------------------------
$file_chat = file($chat_base);
$count_chat = count($file_chat);
list($t0,$t1) = explode("::", $file_chat[$count_chat-1]);
if ($t1 != $count_time)
{
	$massages = "";	$systems = "";
	$count_chat = count(file($chat_base));
	$file_chat = file($chat_base);
	for ($i=0; $i<$count_chat; $i++)
	{
		list($t0,$t1,$t2,$t3,$t4,$t5,$t6) = explode("::", $file_chat[$i]);
		if ($count_time < $t1)
		{
			$classdate = "date";
			$time =date("H:i:s",$t1);
			$name = $t2;
			$color = $t3;
			$body = $t4;
			$msg_room = $t5;
			$msg_city = $t6;
			#if ($name=="bor" || $name=="OBITEL")$body="<b>".$body."</b>";
			$have_ignor=mysql_fetch_Array(mysql_Query("SELECT count(*) FROM ignor WHERE login='".$my_login."' and ignored='".$name."'"));
			if (eregi ("to \[$my_login\]", $body, $regs)) 
			{
				$classdate = "date2"; $forom = 1;
			} 
			if (eregi ("private \[$my_login\]", $body, $regs)) 
			{
				$classdate = "date2";
			}
			if (eregi ("clan \[$my_clan\]", $body, $regs)) 
			{
				$classdate = "date2";
			}
			
			if ($name == "sys" && $_GET['fltr'] != 1) 
			{
				$body = str_replace("sys","",$body);
				$body = str_replace("endSys","",$body);
				$systems.= "<font class=$classdate>$time</font> <font color=\"#ff0000\">Внимание!</font> <font color=\"#000000\">$body</font><BR>";
			}
			else if ($name == "sys_news" && $_GET['fltr'] != 1 && $OTHER["city_game"]==$msg_city) 
			{
				$body = str_replace("sys","",$body);
				$body = str_replace("endSys","",$body);
				$massages.= "'<font class=$classdate>$time</font> <font color=\"#000000\">$body</font> <BR>'+";
			}
			else if ($name == "toroom" && $_GET['fltr'] != 1 && $OTHER["room"]==$msg_room && $OTHER["city_game"]==$msg_city) 
			{
				$body = str_replace("sys","",$body);
				$body = str_replace("endSys","",$body);
				$systems.= "<font class=$classdate>$time</font> <font color=\"#ff0000\">Внимание!</font> <font color=\"#000000\">$body</font><BR>";
			}
			else if (substr($body, 0, 7) == "private")
			{
				if (eregi ("private \[$my_login\]", $body, $regs))
				{
					if (!$have_ignor[0])
					{
						$massages .= "'<font class=$classdate>$time</font> [<SPAN>$name</SPAN>] <font color=\"$color\">$body</font> <BR>'+";
						echo "<script>if (top.chat_turn==2){top.frames.ch.frames['but'].document.all('all').className = 'light';}</script>";
					}
				}
				else if ($name == $my_login && $OTHER["city_game"]==$msg_city)
				{
					if (!$have_ignor[0])$massages .= "'<font class=$classdate>$time</font> [<SPAN>$name</SPAN>] <font color=\"$color\">$body</font> <BR>'+";
				}
			}
			else if (substr($body, 0, 4) == "clan")
			{
				if (eregi("clan \[$my_clan\]", $body))
				{
					$massages .= "'<font class=$classdate>$time</font> [<SPAN>$name</SPAN>] <font color=\"$color\">$body</font> <BR>'+";
					echo "<script>if (top.chat_turn==2){top.frames.ch.frames['but'].document.all('all').className = 'light';}</script>";
				}
			}
		    else if(substr($body, 0, 3) == "sys")
		    {
		     	if($my_login == $name)
		     	{
		     		$body = str_replace("sys","",$body);
		     		$body = str_replace("endSys","",$body);
		     		$systems.= "<font class=date2>$time</font> <font color=\"#ff0000\">Внимание!</font> <font color=\"#000000\">$body</font><BR>";
		     		echo "<script>if (top.chat_turn==1){top.frames.ch.frames['but'].document.all('system').className = 'light';}</script>";
		     	}
		    }
			else if ($forom == 1 && $name !="sys" && $OTHER["room"]==$msg_room && $OTHER["city_game"]==$msg_city)
			{
				if (!$have_ignor[0])$massages .= "'<font class=$classdate>$time</font> [<SPAN>$name</SPAN>] <font color=\"$color\">$body</font> <BR>'+";
			} 
			else if ($_GET['fltr'] != 1 && $name!="sys" && $OTHER["room"]==$msg_room && $OTHER["city_game"]==$msg_city)
			{
				if (!$have_ignor[0])$massages .= "'<font class=$classdate>$time</font> [<SPAN>$name</SPAN>] <font color=\"$color\">$body</font> <BR>'+";
			}
		}
	}
	$count_time = $t1;
	$_SESSION["count_all"]= $count_time;
	$massages .= "''";
	if ($massages != ""){echo "<SCRIPT>top.am(".$massages.",0);</SCRIPT>";}
	if ($systems != "") {echo "<SCRIPT>top.am('".$systems."',1);</SCRIPT>";}
}
mysql_close();
?>