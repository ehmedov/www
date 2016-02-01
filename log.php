<?
session_start();
@ob_start("ob_gzhandler");
include ("conf.php");
include ("inc/battle/battle_type.php");

header("Content-Type: text/html; charset=windows-1251");
header("Cache-Control: no-cache, must-revalidate"); // говорим браузеру что-бы он не кешировал эту страницу
header("Pragma: no-cache");
$login=$_SESSION["login"];

$data = @mysql_connect($base_name, $base_user, $base_pass) or die('Не получается подключиться. Проверьте имя сервера, имя пользователя и пароль!');
mysql_select_db($db_name) or die('Ошибка входа в базу данных');
###################################################################################
?>
<html>
<HEAD>
	<title>XAKUS - Просмотр лога боя...</title>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<meta http-equiv="Content-Language" content="ru">
	<META Http-Equiv=Cache-Control Content="no-cache, max-age=0, must-revalidate, no-store">
	<meta http-equiv=PRAGMA content=NO-CACHE>
	<meta http-equiv=Expires content=0>	
	<LINK REL=StyleSheet HREF='main.css' TYPE='text/css'>
</HEAD>
<body bgcolor="#faeede">
<script language="JavaScript" type="text/javascript" src="fight.js"></script>
<script language="JavaScript" type="text/javascript" src="commoninf.js"></script>
<script language="JavaScript" type="text/javascript" src="show_inf.js"></script>
<script>
var my_login = '<?=$login; ?>';
function dv(){document.write('<hr>');}
</script>	
<DIV id="slot_info" style="VISIBILITY: hidden; POSITION: absolute"></DIV>
<?
$logs=(int)$_GET['log'];
$DATA = mysql_fetch_array(mysql_query("SELECT * FROM battles WHERE id='".$logs."'"));
if (!$DATA)
{
	$DATA = mysql_fetch_array(mysql_query("SELECT * FROM battles_archive WHERE id='".$logs."'"));
}
if (!$DATA)
{
	echo "Лог боя не найден!";
	die();
}

if(!isset($_GET['page'])||$_GET['page']==0)
{
	$page = 1; 
} 
else 
{ 
	$page = abs($_GET['page']);
} 
$max_results = 10;
$from = (($page * $max_results) - $max_results); 

$text=explode("<hr>",$DATA["logs"]);
$text=array_reverse($text);
$total_results=count($text);

$to=$from+$max_results;
if ($to>$total_results)
$to=$total_results;
$total_pages = ceil($total_results / $max_results); 

echo "<h3>Архив боёв</h3>";
echo "<input type=button value='Обновить' class='new' style='cursor:hand' onClick=\"document.location.reload();\">";
echo "<div align=right> Страницы:";
for($i = 1; $i < $total_pages+1; $i++)
{
    if($page== $i && !$_GET["p"]){echo "<font color=red><b> $i</b></font>";} else {echo "<a href='?log=$logs&page=$i' class='us2'> $i</a> ";}
}
echo " (<a href='?log=$logs&p=all' ".($_GET["p"]=="all"?" style='color:red' ":"").">все</a>)</div>";

$btype=$DATA["type"];
$status = $DATA["status"];
$win = $DATA["win"];
$creator=$DATA["creator_id"];
$bid=$DATA["id"];
$span=($win == 1?"p1":"p2");
$seek = mysql_query("SELECT * FROM `team_history` WHERE battle_id='".$logs."'");
$counts=mysql_num_Rows($seek);
while($dat=mysql_fetch_array($seek))
{
	if ($dat["team"]==$win)
	{	
    	$winner.=$comma."<script>drwfl('".$dat['login']."','".$dat['id']."','".$dat['level']."','".$dat['dealer']."','".$dat['orden']."','".$dat['admin_level']."','".$dat['clan_short']."','".$dat['clan']."');</script>";
		$comma=", ";
    }
    if ($dat["team"]==1)
    {
    	$statistika1.="<tr><td><span class=p1><script>drwfl('".$dat['login']."','".$dat['id']."','".$dat['level']."','".$dat['dealer']."','".$dat['orden']."','".$dat['admin_level']."','".$dat['clan_short']."','".$dat['clan']."');</script></span></td><td>".$dat["hitted"]."</td></tr>";
    }
    else if ($dat["team"]==2)
    {
    	$statistika2.="<tr><td><span class=p2><script>drwfl('".$dat['login']."','".$dat['id']."','".$dat['level']."','".$dat['dealer']."','".$dat['orden']."','".$dat['admin_level']."','".$dat['clan_short']."','".$dat['clan']."');</script></span></td><td>".$dat["hitted"]."</td></tr>";
    }
}
if ($counts>=50)echo "<h3>Легендарный бой</h3>";
if ($win ==0)
{
	$count_all=mysql_fetch_Array(mysql_query("SELECT count(*) FROM teams WHERE battle_id=".$creator));
	echo "В бою: <b>".$count_all[0]."</b> человек";
}
if ($win !=0){$w = "Победа за <img src='img/index/win.gif'> <span class=$span>$winner</span>";}else{$w="Ничья";}
$s_t=($status == "finished"?"Поединок завершен. ".$w :"Поединок идет...");

echo "<br><table cellspacing=0 cellpadding=0><tr><td width=100%>Дата проведения поединка: <b>".$DATA["date"]."</b></td><td align=right nowrap><b>Тип боя:</b> <u>".boy_type($btype)."</u></td></tr></table><BR>$s_t<BR><BR>";
if ($_GET["p"]=="all"){$from=0;$to=$total_results;}

for ($i=$from;$i<$to;$i++)echo $text[$i]."<SCRIPT>dv();</SCRIPT>\n";

if($status!="finished") 
{
	$fighters1="";
	$fighters2="";
	$sql_fighters="(SELECT 	login,
					id,
					level,
					orden,
					admin_level,
					dealer,
					clan_short,
					clan,
					hp,
					hp_all,
					team
					FROM users,(SELECT player,team FROM teams WHERE battle_id=$creator) as us WHERE users.login=us.player and users.hp>0)
			UNION (SELECT 	bot.bot_name,
					id,
					level,
					orden,
					admin_level,
					dealer,
					clan_short,
					clan,
					bot.hp,
					bot.hp_all,
					team
					FROM users,(SELECT bot_name,hp,hp_all,team,prototype FROM bot_temp WHERE battle_id=$bid and zver=0) as bot WHERE users.login=bot.prototype and bot.hp>0)
			UNION (SELECT 	bot.bot_name,
					zver.id,
					zver.level,
					zver.orden,
					zver.admin_level,
					zver.dealer,
					zver.clan_short,
					zver.clan,
					bot.hp,
					bot.hp_all,
					bot.team
					FROM zver,(SELECT bot_name,hp,hp_all,team,prototype FROM bot_temp WHERE battle_id=$bid and zver=1) as bot WHERE zver.id=bot.prototype and bot.hp>0)
	";
	
	$counts1=0;
	$counts2=0;
	$battle_units=mysql_query($sql_fighters);
	while ($ss=mysql_fetch_array($battle_units))
	{
		if ($ss['team']==1) 
		{
			$fighters1.=($counts1>0?", ":"")."<span class=p1><script>drwfl('".$ss['login']."','".$ss['id']."','".$ss['level']."','".$ss['dealer']."','".$ss['orden']."','".$ss['admin_level']."','".$ss['clan_short']."','".$ss['clan']."');</script></span> [".$ss['hp']."/".$ss['hp_all']."] ";
			$counts1++;
		}
		else 
		{
			$fighters2.=($counts2>0?", ":"")."<span class=p2><script>drwfl('".$ss['login']."','".$ss['id']."','".$ss['level']."','".$ss['dealer']."','".$ss['orden']."','".$ss['admin_level']."','".$ss['clan_short']."','".$ss['clan']."');</script></span> [".$ss['hp']."/".$ss['hp_all']."] ";
			$counts2++;
		}
	}
	echo "<br><br><center>$fighters1 против $fighters2</center>";
}
if ($win !="0" )
{
	echo "
	<H3>Суммарно</H3>
	<TABLE border=0 cellspacing=0 cellpadding=4 align=center>
	<tr>
	<td valign=top>
		<TABLE border=1 cellspacing=0 cellpadding=4>
			<TR><TD align=center><b>Персонаж</TD><TD><b>Урон</TD></TR>
			$statistika1
		</table>
	</td>
	<td valign=top>
		<TABLE border=1 cellspacing=0 cellpadding=4>
			<TR><TD align=center><b>Персонаж</TD><TD><b>Урон</TD></TR>
			$statistika2
		</table>
	</td>
	</tr>
	</table>";
}

?>
