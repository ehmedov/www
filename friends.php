<?
include ('key.php');
ob_start("@ob_gzhandler");
include ("conf.php");
Header("Cache-Control: no-cache, must-revalidate"); // говорим браузеру что-бы он не кешировал эту страницу
Header("Pragma: no-cache");
$login=$_SESSION["login"];

$data = mysql_connect($base_name, $base_user, $base_pass) or die('Не получается подключиться. Проверьте имя сервера, имя пользователя и пароль!');
mysql_select_db($db_name) or die('Ошибка входа в базу данных');
//-----------------------------------------------------------------------------------------------		
if ($_GET['add'] && $_POST['target'])
{   
	$target=htmlspecialchars(addslashes($_POST['target']));
	$group=(INT)($_POST['group']);
	$comment=htmlspecialchars(addslashes($_POST['comment']));
	
	$CHECK = mysql_fetch_array(mysql_query("SELECT login,adminsite FROM `users` WHERE login='".$target."'"));
	if(!$CHECK)
	{
		$mess="Персонаж <B>".$target."</B> не найден в базе данных.";
	}
	else if($CHECK["adminsite"]>2)
	{
		$mess="Персонаж <B>".$target."</B> не найден в базе данных.";
	}
	else
	{
		$CHECKFRIEND = mysql_fetch_array(mysql_query("SELECT * FROM `friend` WHERE login = '".$login."' and friend='".$target."'"));			
		if(!$CHECKFRIEND)
		{
			mysql_query("INSERT INTO friend(login, friend, grup, comment) VALUES('".$login."', '".$CHECK["login"]."', '".$group."', '".$comment."')");
			$mess= "Персонаж <b>".$target."</b> добавлен.";
		}
		else
		{
			$mess= "Персонаж <b>".$target."</b> уже в списке.";
		}
	}
}
//-----------------------------------------------------------------------------------------------	
if ($_GET['delusr'])
{
	$delusr=(int)$_GET['delusr'];
	$search=mysql_query("SELECT friend FROM `friend` WHERE login='".$login."' and id = ".$delusr);
	if($sec = mysql_fetch_array($search))
	{
		mysql_query("DELETE FROM `friend` WHERE id=".$delusr);
		$mess= "Персонаж <B>".$sec["friend"]."</B> убран из списка.";
	}
	else
	{
		$mess= "Персонаж не найден.";
	}
}
//-----------------------------------------------------------------------------------------------	
$fr="";$vr="";
$c_f=0;
$c_v=0;
$result = mysql_query("SELECT users.login, users.id, level, dealer, orden, admin_level, clan_short, clan, room, friend.grup, friend.id as user_id, friend.comment, (SELECT count(*) FROM online WHERE online.login=users.login) as online FROM friend LEFT JOIN users ON users.login=friend.friend WHERE friend.login='".$login."'");
if(mysql_num_rows($result))
{	
	while ($DAT = mysql_fetch_array($result))
	{	
		$room=$DAT['room'];
		$user_id=$DAT['user_id'];
		include('otaqlar.php');
		if (!$DAT['online']) $online="<img src='img/index/offline.gif'>";else $online="<img src='img/index/online.gif'>";

		if ($DAT['grup']==0)
		{	
			$c_f++;
			$fr.="<tr><td nowrap>$online <a href='javascript:top.AddToPrivate(\"".$DAT['login']."\")'><img border=0 src=img/arrow3.gif alt=\"Приватное сообщение\" ></a>
			<script>drwfl('".$DAT['login']."', '".$DAT['id']."', '".$DAT['level']."', '".$DAT['dealer']."', '".$DAT['orden']."', '".$DAT['admin_level']."', '".$DAT['clan_short']."', '".$DAT['clan']."');</script> - <i style='color:gray;'>".$mesto."</i>".
			($DAT['comment']?"&nbsp;<small>(".$DAT['comment'].")</small>":"")."&nbsp;&nbsp;&nbsp;<a OnClick=\"if (!confirm('Удалить персонаж из списка друзей?')) { return false; } \" href='?delusr=$user_id'><img src='img/del.gif' alt='Удалить из списка'></a></td></tr>";
		}
		else if ($DAT['grup']==1)
		{
			$c_v++;
			$vr.="<tr><td nowrap>$online <a href='javascript:top.AddToPrivate(\"".$DAT['login']."\")'><img border=0 src=img/arrow3.gif alt=\"Приватное сообщение\" ></a>
			<script>drwfl('".$DAT['login']."', '".$DAT['id']."', '".$DAT['level']."', '".$DAT['dealer']."', '".$DAT['orden']."', '".$DAT['admin_level']."', '".$DAT['clan_short']."', '".$DAT['clan']."');</script> - <i style='color:gray;'>".$mesto."</i>".
			($DAT['comment']?"&nbsp;<small>(".$DAT['comment'].")</small>":"")."&nbsp;&nbsp;&nbsp;<a OnClick=\"if (!confirm('Удалить персонаж из списка друзей?')) { return false; } \" href='?delusr=$user_id'><img src='img/del.gif' alt='Удалить из списка'></a></td></tr>";
		}
	}
}
mysql_free_result($result);
mysql_close();
?>
<HTML>
<HEAD>	
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<meta http-equiv="Content-Language" content="ru">
	<META Http-Equiv=Cache-Control Content="no-cache, max-age=0, must-revalidate, no-store">
	<meta http-equiv=PRAGMA content=NO-CACHE>
	<meta http-equiv=Expires content=0>	
	<LINK REL=StyleSheet HREF='main.css' TYPE='text/css'>
</HEAD>
<script>	
function findlogin2(title, script, name, groups, subgroups)
{   
	var s = '<table width=270 cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: hand" onclick="closehint3();"><BIG><B>x</td></tr><tr><td colspan=2>';
	s +='<table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><form action="'+script+'" method=POST><td align=center>';
	s +='<table width=90% cellspacing=0 cellpadding=2 align=center><tr><td align=left colspan="2">';
	s +='Укажите логин персонажа:<br><small>(можно щелкнуть по логину в чате)</small></td></tr>';
	s += '<tr><td align=right><small><b>Логин:</b></small></td><td><INPUT TYPE=text NAME="'+name+'" style="width:140px"></td></tr>';
	if (groups && groups.length>0) 
	{
		s+='<tr><td align=right><small><b>Группа:</b></small></td><td width=140><SELECT NAME=group style="width:140px">';
		for(i=0; i< groups.length; i++) 
		{
			s+='<option value="'+i+'">'+groups[i];
		}
		s+='</SELECT></td></tr>';
	}

	s += '<tr><td align=right><small><b>Комментарий:</b></small></td><td><INPUT TYPE=text NAME="comment" VALUE="" style="width:105px">&nbsp;';
	s += '<INPUT type=image SRC="img/ok.gif" ALT="Добавить контакт" style="border:0; vertical-align: middle"></TD></TR></TABLE><INPUT TYPE=hidden name=sd4 value=""></TD></FORM></TR></TABLE></td></tr></table>';
	document.all("hint4").innerHTML = s;
	document.all("hint4").style.visibility = "visible";
	document.all("hint4").style.left = 100;
	document.all("hint4").style.top = document.body.scrollTop+50;
	document.all(name).focus();
	Hint3Name = name;
}
</script>
<body bgcolor="#faeede">
<script language="JavaScript" type="text/javascript" src="commoninf.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/magic-main.js"></script>	
<div id=hint4></div>
<table border="0" cellspacing="0" width="100%" align="center">
<tr>
	<td width=100%><font color=#ff0000><?=$mess?></font></td>
	<td align=right noWrap>
		<INPUT TYPE="button" style="background-color:#AA0000; color: white;" value="Игнор Лист" onclick="javascript:document.location.href='ignor.php'">
		<INPUT type='button' style='width: 100px' value='Добавить'  style='cursor:hand' onclick='findlogin2("Добавить в список", "?add=1", "target", new Array("Друзья","Враги"))'>
		<INPUT type='button' style='width: 100px' value='Вернуться' style='cursor:hand' onClick="javascript:location.href='main.php?act=none'">
	</td>
</tr>
</table>
<table width="100%">
<?
if ($c_f>0)
{	
	echo "<tr><td colspan=4 align=center><h4>Друзья</h4></td></tr>";
	echo $fr;
}
?>
</table>
<br><br>
<table width="100%">
<?
if ($c_v>0)
{	
	echo "<tr><td colspan=4 align=center><h4>Враги</h4></td></tr>";
	echo $vr;
}
?>
</table>
<br><br><br>
<?	include("counter.php");?>