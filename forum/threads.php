<?
//die("Извините сайт временно не работает.");
include ("key.php");
ob_start("@ob_gzhandler");
include ("../conf.php");
include ('time.php');

$data = mysql_connect($base_name, $base_user, $base_pass) or die('Не получается подключиться. Проверьте имя сервера, имя пользователя и пароль!');
mysql_select_db($db_name) or die('Ошибка входа в базу данных');

Header("Cache-Control: no-cache, must-revalidate"); // говорим браузеру что-бы он не кешировал эту страницу
Header("Pragma: no-cache");

$login=$_SESSION["login"];
$USER_DATA=mysql_fetch_Array(mysql_query("SELECT forum_shut,level,orden,dealer,admin_level,clan,clan_short,remote_ip,adminsite FROM users WHERE login='".$login."'"));

$level = $USER_DATA["level"];
$orden = $USER_DATA["orden"];
$dealer = $USER_DATA["dealer"];
$admin_level = $USER_DATA["admin_level"];
$otdel = $USER_DATA["otdel"];
$clan = $USER_DATA["clan"];
$clan_s = $USER_DATA["clan_short"];
$ip = $USER_DATA["remote_ip"];

$fid=strtolower(htmlspecialchars(addslashes($_GET["fid"])));
$tid=strtolower(htmlspecialchars(addslashes($_GET["tid"])));

$get=array("news","help","thanks","relax","bugs","idea","clan","laws","contest","jeremiad","sales","lies","others","palach","tarman");
$name=array("Официальные объявления","Вопросы и помощь в игре","Благодарности и поздравления","Отдых","Ошибки и сбои (Баги)","Идеи и предложения","Ханствы","Законы проекта www.OlDmeydan.Pe.Hu","Конкурсы","Жалобы",	"Сделки","Обманы","Комм. Отдел","Совещание Стражи Порядка","Тьма");
$test_out=$name[array_search($fid,$get)];
$date=date("d.m.Y-H:i:s");
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
	<title>Форум :: www.OlDmeydan.Pe.Hu</title>
</HEAD>
<body class=txt bgcolor=#f5fff5 leftmargin="0" rightmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<script language="JavaScript" type="text/javascript" src="http://www.OlDmeydan.Pe.Hu/commoninf.js"></script>
<SCRIPT LANGUAGE="JavaScript" SRC="../scripts/magic-main.js"></SCRIPT>
<script>
	function move(title, script, name)
	{
		document.all("hint3").innerHTML = '<table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: hand" onclick="closehint3();"><BIG><B>x</td></tr><tr><td colspan=2>'+
		'<table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><form action="'+script+'" method=POST><td colspan=2>'+
		'<select name='+name+'>'+
		'<option value="news">Официальные объявления'+
		'<option value="help" >Вопросы и помощь в игре'+
		'<option value="thanks" >Благодарности и поздравления'+
		'<option value="relax" >Отдых'+
		'<option value="bugs" >Ошибки и сбои (Баги)'+
		'<option value="idea" >Идеи и предложения'+
		'<option value="clan" >Ханства'+
		'<option value="laws" >Законы проекта www.OlDmeydan.Pe.Hu' +
		'<option value="contest" >Конкурсы'+
		'<option value="jeremiad" >Жалобы'+
		'<option value="sales" >Сделки'+
		'<option value="lies" >Обманы'+
		'<option value="others" >Комм. Отдел'+
		'<option value="palach" >Совещание Стражи Порядка'+
		'</select> <INPUT type=image SRC="../img/dmagic/gray_30.gif"></FORM></TABLE></td></tr></table>';
		document.all("hint3").style.visibility = "visible";
		document.all("hint3").style.left = 100;
		document.all("hint3").style.top = 100;
		document.all(name).focus();
		Hint3Name = name;	
	}
	function closehint3()
	{
		document.all("hint3").style.visibility="hidden";
	    Hint3Name='';
	}
</script>
<?
	include_once('banner.html');
?>
<table width=100%>
<tr>
	<td nowrap>&nbsp;<b><a  href="forum.php" style='color: #990000'>Форум www.OlDmeydan.Pe.Hu</a>	» <?echo $test_out;?></b></td>
	<td align=right>
		<form action="search.php" method="GET" style='margin: 0;'> 
			<input class='inup' type="hidden" name="fid" value="<?=$fid?>" />
			<input class='inup' type="text" name="search_text" value="" />
			<SELECT name="type">
				<OPTION value="topic" selected>Тема
				<OPTION value="creator">Автор
			</SELECT>
			<input class="btn" type="submit" name="find" value="Найти!"/>
		</form>
	</td>
</tr>
</table>	
<?
function BoardCountMsg($id)
{
	if (is_numeric($id))
	{	
		$SQL = mysql_query("SELECT count(*) FROM `topic` WHERE topic_id = '".(int)$id."'");
		$row = mysql_fetch_array($SQL);
		return $row[0];
	}
}
//-------------------------MOVE----------------------------------
if ($_GET['move'] && $USER_DATA["admin_level"] >= 4)
{
	$_GET['move']=(int)$_GET['move'];
	$_POST["move"]=htmlspecialchars(addslashes($_POST["move"]));
	mysql_query("UPDATE thread SET thr='".$_POST["move"]."', moved=1 WHERE id='".$_GET['move']."'");
}
//-------------------------UnLock----------------------------------
if ($_GET['action']=="unlock" && $USER_DATA["admin_level"] >= 9)
{
	mysql_query("UPDATE thread SET locked=0 WHERE id='".$tid."'");
}

//-------------------------Lock----------------------------------
if ($_GET['action']=="lock" && $USER_DATA["admin_level"] >= 9)
{
	mysql_query("UPDATE thread SET locked=1 WHERE id='".$tid."'");
}
//------------------------Delete----------------------------------
if ($_GET['action']=="del" && $USER_DATA["admin_level"] >= 4)
{
	$sql_=mysql_query("SELECT * FROM thread WHERE id='".$tid."'");
	if (mysql_num_rows($sql_))
	{	
		$sql_l=mysql_fetch_array($sql_);
		if (($sql_l["locked"]==1 && $USER_DATA["admin_level"] >= 9)||$sql_l["locked"]==0)
		{	
			$txt=$sql_l["topic"]." (Автор: ".$sql_l["creator"].")";
			mysql_query("UPDATE thread SET deleted=1,del_user='".$login."' WHERE id='".$tid."'");
			#mysql_query("UPDATE topic SET deleted=1 WHERE topic_id='".$tid."'");
		    mysql_query("LOCK TABLES perevod WRITE");
			mysql_query("INSERT INTO perevod(date,login,action,item,ip,login2) VALUES('".date("Y-m-d H:i:s")."','".$login."','Удалил Топик','".$txt."','".$ip."','Форум')");
			mysql_query("UNLOCK TABLES");
			echo "<br><b style='color:#ff0000'>Топик удалена.</b>";
		}
	}
}
//------------------------------------------------------------------------------------
if ($_GET['action']=="add" && in_array($fid,$get) && isset($_SESSION["login"]) && $USER_DATA['forum_shut']<time() && $USER_DATA["level"]>=4)
{
	if ($_POST['title']!="" && $_POST['comments']!="")
	{
		$title=htmlspecialchars($_POST['title']);
		$comments=htmlspecialchars($_POST['comments']);
		
		$comments = str_replace("\n","<BR>",$comments);
        $comments=str_replace("[B]","<B>",$comments);
        $comments=str_replace("[/B]","</B>",$comments);
        $comments=str_replace("[I]","<I>",$comments);
        $comments=str_replace("[/I]","</I>",$comments);
        $comments=str_replace("[U]","<U>",$comments);
        $comments=str_replace("[/U]","</U>",$comments);
        $comments=str_replace("[I]","<I>",$comments);
        $comments=str_replace("[left]","<div align=left>",$comments);
        $comments=str_replace("[/left]","</div>",$comments);
     	
     	$comments=str_replace("[right]","<div align=right>",$comments);
        $comments=str_replace("[/right]","</div>",$comments);
        
        $comments=str_replace("[center]","<div align=center>",$comments);
        $comments=str_replace("[/center]","</div>",$comments);
		for($n = 1;$n <= 18;$n++)
        {
	        $comments = str_replace(":sm$n:","<IMG BORDER=0 SRC=\"smiles/sm$n.gif\">",$comments);
        }
		$INS_THR = mysql_query("INSERT INTO thread(thr,topic,creator,clan,clan_s,orden,dealer,admin_level,level,last_post) VALUES('".addslashes($fid)."','".addslashes($title)."','$login','$clan','$clan_s','$orden','$dealer','$admin_level','$level','$date')");
		$top_id=mysql_insert_id();
		mysql_query("INSERT INTO topic (msg,topic_id,login,orden,dealer,admin_level,clan,clan_s,level) VALUES('".addslashes($comments)."','$top_id','$login','$orden','$dealer','$admin_level','$clan','$clan_s','$level')");
	}
}
//------------------------------------------------------------------------------------	
$today=date("d.m.Y");
if (in_array($fid,$get))
{	
	
	if ((($fid=='palach' && $orden!=1)||($fid=='tarman' && $orden!=6)) && $USER_DATA["adminsite"]!=5)
	{
		echo "<br><br><br><div align=center><b style='color:#ff0000'>Вы не можете просматривать и редактировать данный раздел, т.к. ваша склонность не соответствует необходимой.</b></div>";die();
	}
	else
	{	
		$GET_D = mysql_query("SELECT count(*) FROM thread WHERE thr='".$fid."' and deleted=0");
		$row = mysql_fetch_array($GET_D);
		$page=(int)abs($_GET['page']);
		$cnt=$row[0]; // общее количество записей во всём выводе
		$rpp=20; // кол-во записей на страницу
		$rad=4; // сколько ссылок показывать рядом с номером текущей страницы (2 слева + 2 справа + активная страница = всего 5)
		echo "<center>";
		$links=$rad*2+1;
		$pages=ceil($cnt/$rpp);
		if ($page>0) { echo "<a href='?fid=".$fid."'>«««</a> | <a href='?fid=".$fid."&page=".($page-1)."'>««</a> |"; }
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
				echo "<a href='?fid=".$fid."&page=$i'>";
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
		if ($pages>$links && $page<($pages-$rad-1)) { echo " ... <a href='?fid=".$fid."&page=".($pages-1)."'>".($pages-1)."</a>"; }
		if ($page<$pages-1) { echo " | <a href='?fid=".$fid."&page=".($page+1)."'>»»</a> | <a href='?fid=".$fid."&page=".($pages-1)."'>»»»</a>"; }
		echo "</center>";
		$limit = $rpp;
		$eu = $page*$limit;

		echo "<table width=100% border=0 cellpadding=5 cellspacing=1>
		<tr bgcolor=#d0eed0>
		<td width=80% style='color: #990000' colspan=2><b>Тема</b></td>
		<td style='color: #990000' align=center><b>Дата</b></td>
		<td style='color: #990000' align=center><b>#</b></td>
		<td width=15% style='color: #990000'><b>Автор</b></td>
		<td width=15% style='color: #990000'><nobr><b>Последнее сообщение</b></nobr></td>";
		echo ($USER_DATA["admin_level"] >= 4)?"<td width=15% style='color: #990000'>&nbsp;</td>":"";
		echo "</tr>";
		$SQL_="SELECT t.*,unix_timestamp(t.date) as utime FROM thread t WHERE thr='".$fid."'  and deleted=0 ORDER BY locked DESC,utime DESC LIMIT $eu, $limit";
		$GET_D = mysql_query($SQL_);
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

			$author ="<script>drwfl('$auth_name', '1', '$auth_level', '$auth_dealer', '$auth_orden', '$auth_admin_level', '$auth_clan_s', '$auth_clan');</script>";
			echo "<tr bgcolor=".($n?'#e0eee0':'#d0f5d0')." onMouseOver='this.bgColor=\"#e6f3e6\";' onMouseOut='this.bgColor=\"".($n?'#e0eee0':'#d0f5d0')."\";'>";
			echo "<td valign=middle nowrap>";
			echo ($locked==1?"<img src='img/locked.gif' border=0 alt='Тема закрыта'>":($today==$pieces[0]?"<img src='img/new.gif' border=0 alt='Новые сообщения'>":"<img src='img/read.gif' border=0 alt='Нет новых сообщений'>"))."</td><td> <a href='messages.php?fid=$fid&tid=$top_id&rnd=".md5(time())."' style='text-decoration: none;'>".$top_head."</a></b></td>
			<td align=center valign=middle><nobr>".$date_news."</nobr></td>
			<td align=center valign=middle>&nbsp;&nbsp;".BoardCountMsg($top_id)."&nbsp;&nbsp;</td>
			<td valign=middle><nobr><b>".$author."</b></nobr></td>
			<td valign=middle><nobr><a>".$last_reply."</a></nobr></td>";
			echo ($USER_DATA["admin_level"] >= 4)?"<td style='color: #990000' nowrap><img src='img/delete.gif' border=0 title='Удалить тему' onClick=\"document.location='?action=del&fid=$fid&tid=$top_id&page=$page'\" style='cursor:hand'> <img src='img/move.gif' border=0 title='Переместить тему' onClick=\"move('Переместит тему', '?fid=$fid&move=$top_id', 'move');\" style='cursor:hand'>".(($USER_DATA["admin_level"] >= 9)?" <img src='img/quick_lock.gif' border=0 title='Закрыт доступ' onClick=\"document.location='?fid=$fid&action=lock&tid=$top_id'\" style='cursor:hand'> <img src='img/unlock.gif' border=0 title='Открыт доступ' onClick=\"document.location='?fid=$fid&action=unlock&tid=$top_id'\" style='cursor:hand'></td>":"")."</td>":"";
			echo "</tr>";
		}
		echo "</table>";
	}
	if (isset($_SESSION["login"]) && $USER_DATA['forum_shut']<time() && $USER_DATA["level"]>=4)
	{	
		include_once("inc.php");
	}
	else if (!isset($_SESSION["login"]))
	{
		echo "<center><i>Вы не авторизованы</i></center>";
	}
	else if ($USER_DATA['forum_shut']>time())
	{
		echo "<center><small>Персонаж бедет молчать на форуме ещё ".convert_time($USER_DATA['forum_shut'])." </small></center>";
	}
}
?>
<table border=0 cellspacing=0 cellpadding=0 bgcolor=#d0eed0 width=100%>
<tr><td bgcolor=#003300></td></tr>
<tr><td width=30% align=right>
<?	include("../counter.php");?>
</td></tr>
<tr><td bgcolor=#003300></td></tr>
</table>
<div id=hint3 style="VISIBILITY: hidden; WIDTH: 240px; POSITION: absolute"></div>