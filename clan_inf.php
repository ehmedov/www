<?
session_start();
ob_start("@ob_gzhandler");
include ("conf.php");
$login=$_SESSION["login"];
Header("Cache-Control: no-cache, must-revalidate"); // говорим браузеру что-бы он не кешировал эту страницу
Header("Pragma: no-cache");

$data = mysql_connect($base_name, $base_user, $base_pass) or die('Не получается подключиться. Проверьте имя сервера, имя пользователя и пароль!');
mysql_select_db($db_name) or die('Ошибка входа в базу данных');
$my_info=mysql_fetch_Array(mysql_query("SELECT admin_level FROM users WHERE login='".$login."'"));
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
		<meta http-equiv="Content-Language" content="ru">
		<meta http-equiv=Cache-Control Content=no-cache>
		<meta http-equiv=PRAGMA content=NO-CACHE>
		<meta http-equiv=Expires content=0>	
		<LINK rel="stylesheet" type="text/css" href="main.css">
	</head>
<body bgcolor="#faeede">
<script language="JavaScript" type="text/javascript" src="commoninf.js"></script>

<?
$clan=htmlspecialchars(addslashes($_GET['clan']));
if(empty($clan))
{
	echo "Неверный запрос.";
}
else
{
	$sql = mysql_query("SELECT clan.*,clan.level as c_level,users.login,users.id,users.level,users.dealer,users.orden,users.admin_level,users.clan_short,users.clan FROM clan LEFT JOIN users on users.id=clan.creator WHERE name_short='".$clan."'");
	$res = mysql_fetch_array($sql);
	mysql_free_result($sql);
	if(!$res)
	{
		echo "<h3>Такое Ханство не существует.</h3>";
	}
	else
	{
		$clan_name=$res["name_short"];
		$name = $res["name"];
		$glava = $res["glava"];
		$story = $res["story"];
		$ochki= $res["ochki"];
		$kazna=$res["kazna"];
		$level=$res["c_level"];
		$wins=$res["wins"];
		$site = strtolower("http://".str_replace("http://","",$res["site"]));
		?>
		<title>WWW.OlDmeydan.Pe.Hu - информация о Ханства <?echo $res["name"]?></title>
		<h3>Информация о Ханстве <?=$name?></h3>
		<b>Сайт Ханства:</b> <a href='<?echo $site?>' class=us2 target='_blank'><?echo $site?></a><BR>
		<b>Рейтинг:</b> <a href="top.php?act=clan&clan_id=<?=$clan_name?>" target='_blank'><FONT color=#007200><B><?=$ochki?></b></font></a><br>
		<b>Уровень:</b> <FONT color=#007200><B><?=$level?></B></FONT><br>
		<b>Победа Ханства:</b> <a href="top.php?act=clan_win&clan_id=<?=$clan_name?>" target='_blank'><?=$wins?></a><br>	
		<?
			if ($my_info["admin_level"]>=5) 
			{
				echo "<b>Казна:</b> ".number_format($kazna, 2, '.', ' ')." Зл.<br>";
				echo "<form name='action' action='' method='post'>
					<input type=submit name='view' value='Посмотрет Отчет' class=new>
					</form>";
				if ($_POST["view"])
				{
					$lines = file("clan/operation/".$clan_name.".dis");
					foreach ($lines as $line_num => $line) 
					{
						$dis = explode("|",$line);
				    	$txt.= $dis[2]."  ".$dis[0]."  [".$dis[1]."]\n";
					}
					echo "<textarea rows=30 cols=120>".str_replace("<b>","",str_replace("</b>","",$txt))."</textarea><br>";
				}

			}
			echo "<b>Список абилок:</b><br>";
			$_abil=mysql_query("SELECT * FROM abils where tribe='".$name."'");
			while ($abil=mysql_fetch_array($_abil)) 
			{
				$iteminfo=mysql_fetch_array(mysql_query("SELECT * FROM scroll where id='".$abil["item_id"]."'")); // Получаем инфу о предмете
				echo "<img src='img/".$iteminfo["img"]."' alt='".$iteminfo["name"]." [".$abil["c_iznos"]."/".$abil["m_iznos"]."]'> ";
			}
			if (!mysql_num_rows($_abil)) echo  "У Ханства нет не одной абилити!";
		?>
		<hr>
		<h3>История Ханства</h3>
		<?echo $story?><hr>
		<?
		$SEEK = mysql_query("SELECT login,id,level,dealer,orden,admin_level,clan_short,clan,chin,glava,clan_take,(select count(*) FROM online where login=users.login) as online FROM users WHERE clan_short='".$clan_name."' and blok=0 ORDER BY glava DESC, clan_take DESC, exp DESC");
		echo "<h3>Бойцы Ханства (Всего: ".mysql_num_rows($SEEK).")".($res["creator"]?"<br>(Ханство Основано Персонажем <script>drwfl('".$res['login']."', '".$res['id']."', '".$res['level']."', '".$res['dealer']."', '".$res['orden']."', '".$res['admin_level']."', '".$res['clan_short']."', '".$res['clan']."');</script>)":"")."</h3>";
		while($D_S = mysql_fetch_array($SEEK))
		{
			if (!$D_S['online']) $online="<font color='#ff0000'><i><b>|Нет в клубе</b></i></font>";
			else	$online="<font color=green><b>|online</b></font>";

			if ($D_S["login"]==$glava) $gimg="<img src='img/index/glava.gif' alt='Хан'>"; 
			else if ($D_S['clan_take']) $gimg="<img src='img/index/zamglava.gif' alt='Визир'>"; 
			else $gimg="";
			echo "<a onclick=\"window.opener.top.AddToPrivate('".$D_S['login']."')\" href='#'><img border=0 src=img/arrow3.gif alt=\"Приватное сообщение\" ></a> <script>drwfl('".$D_S['login']."', '".$D_S['id']."', '".$D_S['level']."', '".$D_S['dealer']."', '".$D_S['orden']."', '".$D_S['admin_level']."', '".$D_S['clan_short']."', '".$D_S['clan']."');</script>"." - $gimg <i><font color='#333333'>".$D_S['chin']."</font></i> $online<br>";
		}
		mysql_free_result($SEEK);
	}
}
mysql_close($data);
?>