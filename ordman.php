<?
include ('key.php');
include ("conf.php");
Header("Cache-Control: no-cache, must-revalidate"); // говорим браузеру что-бы он не кешировал эту страницу
Header("Pragma: no-cache");

$data = mysql_connect($base_name, $base_user, $base_pass) or die('Не получается подключиться. Проверьте имя сервера, имя пользователя и пароль!');
mysql_select_db($db_name) or die('Ошибка входа в базу данных');
?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<meta http-equiv="Content-Language" content="ru">
	<meta http-equiv=Cache-Control Content=no-cache>
	<meta http-equiv=PRAGMA content=NO-CACHE>
	<meta http-equiv=Expires content=0>	
	<LINK rel="stylesheet" type="text/css" href="main.css">
	<script language="JavaScript" type="text/javascript" src="commoninf.js"></script>
</head>	
<body bgcolor="#faeede">
<TABLE width=100% border=0>
<tr valign=top>
	<td width=100%><h3>Модераторы online</h3></td>
	<td align=right nowrap>
		<input type=button onclick="location.href='main.php?act=none'" value="Вернуться" class=new >
		<input type=button onclick="location.href='ordman.php'" value="Обновить" class=new >
	</td>
</tr>
</table>
<table width=100% cellspacing=1 cellpadding=3 class="l3">
<tr class="l3">
	<tr class="l3">
		<td width=30% align=center><b>Ник</b></td>
		<td width=30% align=center><b>Должность</b></td>
		<td width=20% align=center><b>Комната</b></td>
		<td width=20% align=center><b>Статус</b></td>
	</tr>
</tr>
<?	
	$SostQuery = mysql_query("SELECT login,id,level,dealer,orden,admin_level,adminsite,clan_short,clan,room,otdel,(select count(*) FROM online where login=users.login) as online FROM users WHERE (orden=1 and adminsite<2) or dealer=1 and NOT blok ORDER BY  adminsite DESC, admin_level DESC");
    WHILE ($DAT = mysql_fetch_array($SostQuery))
	{
		$n=!$n;
		$room=$DAT['room'];
		$DAT['otdel']=str_replace("&amp;","&",$DAT['otdel']);
		include('otaqlar.php');
		if (!$DAT['online']) $online="<font color='#666666'><i><b>Нет в клубе</b></i></font>";else $online="<font color='green'><b>OnLine</b></font>";
		echo "
		<tr class='".($n?'l0':'l1')."'>
			<td width=30% align='left'>
			<a href='javascript:top.AddToPrivate(\"".$DAT['login']."\")'><img border=0 src=img/arrow3.gif alt=\"Приватное сообщение\" ></a>
			<script>drwfl('".$DAT['login']."', '".$DAT['id']."', '".$DAT['level']."', '".$DAT['dealer']."', '".$DAT['orden']."', '".$DAT['admin_level']."', '".$DAT['clan_short']."', '".$DAT['clan']."');</script>
			</td>
			<td width=30% align='center'>".$DAT['otdel']."</td>
			<td width=20% align='center'>".$mesto."</td>
			<td align='center'>".$online."</td>
		</tr>";
    }
    mysql_free_result($SostQuery);
    mysql_close($data);
?>
</table>