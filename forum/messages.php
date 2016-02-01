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
$clan = $USER_DATA["clan"];
$clan_s = $USER_DATA["clan_short"];
$ip = $USER_DATA["remote_ip"];

$fid=strtolower(htmlspecialchars(addslashes($_GET["fid"])));
$tid=(int)$_GET["tid"];
$view_id=(int)$_GET["view_id"];
$id=htmlspecialchars(addslashes($_GET["id"]));

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
<?
include_once('banner.html');

$TOP_D = mysql_fetch_array(mysql_query("SELECT * FROM thread WHERE id=$tid"));
$top_header = $TOP_D["topic"];
$top_header=str_replace("&amp;","&",$top_header);
$moved= $TOP_D["moved"];

echo "&nbsp;<b><a href='forum.php' style='color: #990000'>Форум www.OlDmeydan.Pe.Hu</a> » <a href=threads.php?fid=".(in_array($fid,$get)?"$fid":"news").">$test_out</a> » $top_header</b><br>";
?>
<SCRIPT LANGUAGE="JavaScript" SRC="../scripts/magic-main.js"></SCRIPT>
<script language="JavaScript" type="text/javascript" src="http://www.OlDmeydan.Pe.Hu/commoninf.js"></script>
<?
function limit_text($text, $limit)
{
	return implode(" ", array_slice(explode(" ", $text), 0, $limit));
}
//--------------------------------------------------------------------
if ($_GET['action']=="del_topic" && $USER_DATA["admin_level"] >= 4)
{
	$sql_l=mysql_fetch_array(mysql_query("SELECT * FROM topic WHERE id='".$id."'"));
	if ($sql_l)
	{
		if ($TOP_D["locked"]==0)
		{
			$txt=$sql_l["msg"]." (Автор: ".$sql_l["login"].")";
			mysql_query("UPDATE topic SET msg='<font color=#ff0000><i>Удалено Стражом порядка ".$login." (".date("Y-m-d H:i:s").")</i></font>' WHERE id='".$id."'");
	        mysql_query("LOCK TABLES perevod WRITE");
			mysql_query("INSERT INTO perevod(date,login,action,item,ip,login2) VALUES('".date("Y-m-d H:i:s")."','".$login."','Удалил Тему','".$txt."','".$ip."','Форум')");
			mysql_query("UNLOCK TABLES");
	        echo "<b style='color:#ff0000'>Тема удалена.</b>";
		}
		else echo "<b style='color:#ff0000'>Невозможно удалить информацию о закрывшем топике.</b>";
	}
}
//--------------------------------------------------------------------
if ($_GET['action']=="del_topic_full" && $USER_DATA["admin_level"] >= 9)
{
	$sql_l=mysql_fetch_array(mysql_query("SELECT * FROM topic WHERE id='".$id."'"));
	if ($sql_l)
	{
		if (($TOP_D["locked"]==1 && $USER_DATA["admin_level"] >= 9)||$TOP_D["locked"]==0)	
		{
			$txt=$sql_l["msg"]." (Автор: ".$sql_l["login"].")";
			mysql_query("DELETE FROM topic WHERE id='".$id."'");
	        mysql_query("LOCK TABLES perevod WRITE");
			mysql_query("INSERT INTO perevod(date,login,action,item,ip,login2) VALUES('".date("Y-m-d H:i:s")."','".$login."','Удалил Тему','".$txt."','".$ip."','Форум')");
			mysql_query("UNLOCK TABLES");
	        echo "<b style='color:#ff0000'>Тема удалена.</b>";
		}
		else echo "<b style='color:#ff0000'>Невозможно удалить информацию о закрывшем топике.</b>";
	}
}
//--------------------------------------------------------------------
if($_GET['action']=="add_comment")
{
    if($USER_DATA["admin_level"] >= 4)
    {
    	$comment = htmlspecialchars($_POST['comment']); 
	    $comment = str_replace("\n","<BR>",$comment);
    	$s="<br><br><font color=#FF0000><b><i>".$comment."</i></b> ( АВТОР: ".$_SESSION['login']." - ".$date." )</font><br><br>";
        mysql_query("UPDATE topic SET msg=CONCAT(msg,'".addslashes($s)."') WHERE id='$id'");
    }
}
//--------------------------------------------------------------------
if ($_GET['action']=="add" && in_array($fid,$get) && isset($_SESSION["login"]) && $USER_DATA['forum_shut']<time() && $USER_DATA["level"]>=4)
{
	if ($_POST['comments']!="")
	{
		$sql=mysql_query("SELECT * FROM thread WHERE id=$tid");
		$res=mysql_fetch_array($sql);
		if (($res["locked"]==1 && $USER_DATA["admin_level"] >= 9)||$res["locked"]==0)
		{	
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
	        if ($USER_DATA["adminsite"])
	        {
	        	$pos_1 = strpos($comments, "[img]");
				$pos_2 = strpos($comments, "[/img]");
				if($pos_1 && $pos_2)
				{	
				$my_link=substr($comments,$pos_1+5,$pos_2-$pos_1-5);
				$comments=str_replace($my_link,"",$comments);
				$comments=str_replace("[img]","<img src='",$comments);
				$comments=str_replace("[/img]","$my_link' border='0' />",$comments);
				}
	        }
			for($n = 1;$n <= 18;$n++)
	        {
		        $comments = str_replace(":sm$n:","<IMG BORDER=0 SRC=\"smiles/sm$n.gif\">",$comments);
	        }
			mysql_query("INSERT INTO topic(msg,topic_id,login,orden,dealer,admin_level,clan,clan_s,level) VALUES('".addslashes($comments)."','$tid','$login','$orden','$dealer','$admin_level','$clan','$clan_s','$level')");
			mysql_query("UPDATE thread SET last_post='$date' WHERE id=$tid");
		}
		else echo "<b style='color:#ff0000'>Тема закрыта.</b>";
	}
}
//--------------------------------------------------------------------
if (in_array($fid,$get))
{	
	if ((($fid=='palach' && $orden!=1)||($fid=='tarman' && $orden!=6)) && $USER_DATA["adminsite"]!=5)
	{
		echo "<br><br><br><div align=center><b style='color:#ff0000'>Вы не можете просматривать и редактировать данный раздел, т.к. ваша склонность не соответствует необходимой.</b></div>";die();
	}
	else if(is_numeric($tid))
	{
		$ALL_S = mysql_query("SELECT count(*) FROM topic WHERE topic_id='".(int)$tid."'");
		$row = mysql_fetch_array($ALL_S);
		$page=(int)abs($_GET['page']);
		$cnt=$row[0]; // общее количество записей во всём выводе
		$rpp=20; // кол-во записей на страницу
		$rad=5; // сколько ссылок показывать рядом с номером текущей страницы (2 слева + 2 справа + активная страница = всего 5)
		echo "<center>";
		$links=$rad*2+1;
		$pages=ceil($cnt/$rpp);
		if ($page>0) { echo "<a href='?fid=".$fid."&tid=".$tid."'>«««</a> | <a href='?fid=".$fid."&tid=".$tid."&page=".($page-1)."'>««</a> |"; }
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
				echo "<a href='?fid=".$fid."&tid=".$tid."&page=$i'>";
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
		if ($pages>$links && $page<($pages-$rad-1)) { echo " ... <a href='?fid=".$fid."&tid=".$tid."&page=".($pages-1)."'>".($pages-1)."</a>"; }
		if ($page<$pages-1) { echo " | <a href='?fid=".$fid."&tid=".$tid."&page=".($page+1)."'>»»</a> | <a href='?fid=".$fid."&tid=".$tid."&page=".($pages-1)."'>»»»</a>"; }
		echo "</center>";
		$limit = $rpp;
		$eu = $page*$limit;
		print "<table align=center width=100% border=0 cellspacing=1 cellpadding=2>
			<tr>
				<td bgcolor=#d0eed0 style='color: #990000'><b>Автор</b></td>
				<td bgcolor=#d0eed0 style='color: #990000'><b>Тема: $top_header</b> ".($moved?" [Перемещен]":"")."</td>
			</tr>";
		$SQL_="SELECT * FROM topic WHERE topic_id='".(int)$tid."' ORDER BY unix_timestamp(date) DESC LIMIT $eu, $limit";
		$GET = mysql_query($SQL_);
		while($DATA = mysql_fetch_array($GET))
		{
			$msg = $DATA["msg"];
			$msg=str_replace("&amp;","&",$msg);
			$author = $DATA["login"];
			$level = $DATA["level"];
			$orden_d = $DATA["orden"];
			$dealer_d = $DATA["dealer"];
			$admin_level = $DATA["admin_level"];
			$clan_s  = $DATA["clan_s"];
			$clan_f  = $DATA["clan"];
			$top_id=$DATA['id'];
			$cut_count=300;
			if ($fid=="palach")
			{
				if ($view_id!=$top_id)
				{
					if (strlen($msg)>$cut_count)$msg=limit_text($msg, $cut_count)."<br><br><div align=right><a href='?fid=".$fid."&tid=".$tid."&page=".$page."&view_id=".$top_id."'><b>Читать полностью</b></a></div>";
				}
			}
			echo "<tr>
					<td width=250 bgcolor=#d0f5d0 valign=top>
						<script>drwfl('$author', '1', '$level', '$dealer_d', '$orden_d', '$admin_level', '$clan_s', '$clan_f');</script>
					</td>";
					echo "<td bgcolor=#e0ffe0 valign=top>";
					echo "<table width=100% cellpadding=0 cellspacing=0><tr><td width=15 bgcolor=#99CC99></td><td style='font-size: 8pt;' align=left bgcolor=#d0f5d0>&nbsp;&nbsp;написано: ".$DATA["date"]."&nbsp;</td><td align=right bgcolor=#d0f5d0>";
					if($USER_DATA["admin_level"] >= 4)
					{
						echo "<a href='?action=del_topic&fid=$fid&tid=$tid&id=$top_id' style='text-decoration:none;font-size:8pt;color:#99CC99;'>[Удалить тему]</a>&nbsp;&nbsp;&nbsp;";
						echo "<a href=\"javascript:formforum('Добавить ответ','?action=add_comment&fid=$fid&tid=$tid&id=$top_id', 'comment','', '5')\" style='text-decoration:none;font-size:8pt;color:#99CC99;'>[Добавить ответ]</A>";
					}
					if($USER_DATA["admin_level"] >= 9)
					{
						echo "&nbsp;&nbsp;&nbsp;<a href='?action=del_topic_full&fid=$fid&tid=$tid&id=$top_id' style='text-decoration:none;font-size:8pt;color:#99CC99;'>[Удалить Полностью]</a>";
					}
					echo "</td></tr></table>";
					echo "<br>".$msg."<br><br></td>
				</tr>";
		}
		echo "</table>";
	}
	if (isset($_SESSION["login"]) && $USER_DATA['forum_shut']<time() && $USER_DATA["level"]>=4)
	{	
		include("inc_message.php");
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
<?include("../counter.php");?>
</td></tr>
<tr><td bgcolor=#003300></td></tr>
</table>
<div id=hint4 style="VISIBILITY: hidden; WIDTH: 240px; POSITION: absolute;top:160px; left:40px;"></div>
</HTML>