<?
//die("Извините сайт временно не работает.");
include ("key.php");
ob_start("ob_gzhandler");
include ("../conf.php");
include ('time.php');

$data = mysql_connect($base_name, $base_user, $base_pass) or die('Не получается подключиться. Проверьте имя сервера, имя пользователя и пароль!');
mysql_select_db($db_name) or die('Ошибка входа в базу данных');

Header("Cache-Control: no-cache, must-revalidate"); // говорим браузеру что-бы он не кешировал эту страницу
Header("Pragma: no-cache");

$login=$_SESSION["login"];
$USER_DATA=mysql_fetch_Array(mysql_query("SELECT adminsite FROM users WHERE login='".$login."'"));

$adminsite= $USER_DATA["adminsite"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<HEAD>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<meta http-equiv="Content-Language" content="ru">
	<META Http-Equiv=Cache-Control Content="no-cache, max-age=0, must-revalidate, no-store">
	<meta http-equiv=PRAGMA content=NO-CACHE>
	<meta http-equiv=Expires content=0>	
	<link rel=stylesheet type="text/css" href="forum.css">
	<title>Архив удаленных тем :: www.OlDmeydan.Pe.Hu</title>
</HEAD>
<body class=txt bgcolor=#f5fff5 leftmargin="0" rightmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<script language="JavaScript" type="text/javascript" src="http://www.OlDmeydan.Pe.Hu/commoninf.js"></script>
<?
include_once('banner.html');
if (!$adminsite)
{
	echo "<br><br><br><div align=center><b style='color:#ff0000'>Вы не можете просматривать и редактировать данный раздел, т.к. ваша склонность не соответствует необходимой.</b></div>";
	die();
}

function BoardCountMsg($id)
{
	$row = mysql_fetch_array(mysql_query("SELECT count(*) FROM `topic` WHERE topic_id = '".(int)$id."'"));
	return $row[0];
}
//------------------------UNDO----------------------------------
if ($_GET["undo_id"])
{
	$undo_id=(int)$_GET["undo_id"];
	mysql_query("UPDATE thread SET deleted=0 WHERE id='".$undo_id."'");
}	
//------------------------Delete----------------------------------
if ($_GET["del_id"])
{
	$del_id=(int)$_GET["del_id"];
	mysql_query("DELETE FROM thread WHERE id='".$del_id."'");
	mysql_query("DELETE FROM topic WHERE topic_id='".$del_id."'");
}	
//----------------------------------------------------------------
$GET_D = mysql_query("SELECT count(*) FROM thread WHERE deleted=1");
$row = mysql_fetch_array($GET_D);
$page=(int)abs($_GET['page']);
$cnt=$row[0]; // общее количество записей во всём выводе
$rpp=20; // кол-во записей на страницу
$rad=4; // сколько ссылок показывать рядом с номером текущей страницы (2 слева + 2 справа + активная страница = всего 5)
echo "<center>";
$links=$rad*2+1;
$pages=ceil($cnt/$rpp);
if ($page>0) { echo "<a href='archive.php'>«««</a> | <a href='?page=".($page-1)."'>««</a> |"; }
$start=$page-$rad;
if ($start>$pages-$links) { $start=$pages-$links; }
if ($start<0) { $start=0; }
$end=$start+$links;
if ($end>$pages) { $end=$pages; }
for ($i=$start; $i<$end; $i++) 
{
	if ($i==$page) 
	{
		echo "<b style='color:#ff0000'><u>";
	} 
	else 
	{
		echo "<a href='?page=$i'>";
	}
	echo $i;
	if ($i==$page) 
	{
		echo "</u></b>";
	} 
	else 
	{
		echo "</a>";
	}
	if ($i!=($end-1)) { echo " | "; }
}
if ($pages>$links && $page<($pages-$rad-1)) { echo " ... <a href='?page=".($pages-1)."'>".($pages-1)."</a>"; }
if ($page<$pages-1) { echo " | <a href='?page=".($page+1)."'>»»</a> | <a href='?page=".($pages-1)."'>»»»</a>"; }
echo "</center>";
$limit = $rpp;
$eu = $page*$limit;

echo "<table width=100% border=0 cellpadding=5 cellspacing=1>
<tr bgcolor=#d0eed0>
	<td width=80% style='color: #990000' colspan=2><b>Тема</b></td>
	<td style='color: #990000' align=center><b>Дата</b></td>
	<td style='color: #990000' align=center><b>#</b></td>
	<td width=15% style='color: #990000'><b>Автор</b></td>
	<td width=15% style='color: #990000'><nobr><b>Последнее сообщение</b></nobr></td>
	<td width=15% style='color: #990000'><img src='img/delete.gif' border=0 title='Удалить Все' onClick=\"document.location='?del_all=true&page=$page'\" style='cursor:hand'></td>
</tr>";
//------------------------Delete ALL----------------------------------
if ($_GET["del_all"])
{
	$GET_D = mysql_query("SELECT * FROM thread WHERE deleted=1 ORDER BY date DESC LIMIT $eu, $limit");
	while($DATA = mysql_fetch_array($GET_D))
	{
		mysql_query("DELETE FROM thread WHERE id='".$DATA["id"]."'");
		mysql_query("DELETE FROM topic WHERE topic_id='".$DATA["id"]."'");
	}
}
//------------------------Delete----------------------------------

$GET_D = mysql_query("SELECT * FROM thread WHERE deleted=1 ORDER BY date DESC LIMIT $eu, $limit");
while($DATA = mysql_fetch_array($GET_D))
{
	$n=(!$n);
	str_replace("&amp;","&",$DATA["topic"]);
	$top_head = str_replace("&amp;","&",$DATA["topic"]);
	$top_id = $DATA["id"];
	$date_news=$DATA["date"];
	$auth_name = $DATA["creator"];
	$auth_clan = $DATA["clan"];
	$auth_clan_s = $DATA["clan_s"];
	$auth_orden = $DATA["orden"];
	$auth_dealer = $DATA["dealer"];
	$auth_admin_level = $DATA["admin_level"];
	$auth_level = $DATA["level"];
	$last_reply = $DATA["last_post"];		
	$pieces = explode("-",$last_reply);
	$locked=$DATA["locked"];
	$fid=$DATA["thr"];
	$del_user=$DATA["del_user"];

	$author ="<script>drwfl('$auth_name', '1', '$auth_level', '$auth_dealer', '$auth_orden', '$auth_admin_level', '$auth_clan_s', '$auth_clan');</script>";
	echo "<tr title='Удален персонажем $del_user' bgcolor=".($n?'#e0eee0':'#d0f5d0')." onMouseOver='this.bgColor=\"#e6f3e6\";' onMouseOut='this.bgColor=\"".($n?'#e0eee0':'#d0f5d0')."\";'>";
	echo "<td valign=middle nowrap width=20><img src='img/read.gif' border=0 alt='Нет новых сообщений'></td>
	<td width=100%><a href='messages.php?fid=$fid&tid=$top_id&rnd=".md5(time())."' style='text-decoration: none;'>".$top_head."</a></b></td>
	<td align=center valign=middle><nobr>".$date_news."</nobr></td>
	<td align=center valign=middle>&nbsp;&nbsp;".BoardCountMsg($top_id)."&nbsp;&nbsp;</td>
	<td valign=middle><nobr><b>".$author."</b></nobr></td>
	<td valign=middle><nobr><a>".$last_reply."</a></nobr></td>
	<td style='color: #990000' nowrap>
		<img src='img/unlock.gif' border=0 title='Вернут тему'  onClick=\"document.location='?undo_id=$top_id&page=$page'\" style='cursor:hand'>
		<img src='img/delete.gif' border=0 title='Удалить тему' onClick=\"document.location='?del_id=$top_id&page=$page'\" style='cursor:hand'>
	</td>
	</tr>";
}
echo "<tr bgcolor=#ffffff></tr>";
echo "</table>";
?>
<table border=0 cellspacing=0 cellpadding=0 bgcolor=#d0eed0 width=100%>
<tr><td bgcolor=#003300></td></tr>
<tr><td width=30% align=right>
<?	include("../counter.php");?>
</td></tr>
<tr><td bgcolor=#003300></td></tr>
</table>