<?
include ("key.php");
ob_start("@ob_gzhandler");
include ("conf.php");
include ("inc/battle/battle_type.php");
$login=$_SESSION['login'];
Header("Cache-Control: no-cache, must-revalidate"); // говорим браузеру что-бы он не кешировал эту страницу
Header("Pragma: no-cache");
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
<?
$data = mysql_connect($base_name, $base_user, $base_pass) or die('Не получается подключиться. Проверьте имя сервера, имя пользователя и пароль!');
mysql_select_db($db_name) or die('Ошибка входа в базу данных');

$result = mysql_query("SELECT * FROM users WHERE login='".$login."'");
$db = mysql_fetch_array($result);
$admin=($db["admin_level"]>8?1:0);

$cure_hp=$db["cure_hp"];
$time_to_cure=$cure_hp-time();
$hhh=$db["hp_all"];
if($db["battle"]==0)
{
	if($time_to_cure>0)
	{
		$cure_full = $db["cure_time"]-$db["cure"];
		$percent_hp=floor((100*$time_to_cure)/$cure_full);
		$percent=100-$percent_hp;
		$hp[0]=floor(($hhh*$percent)/100);
		mysql_query("UPDATE users SET hp='".$hp[0]."' WHERE login='".$login."'");
	}
	else
	{
		$hp[0]=$db["hp_all"];
		mysql_query("UPDATE users SET hp='".$hp[0]."',cure_hp='0' WHERE login='".$login."'");
	}
}
$hp[1]=$db["hp_all"];
?>
<body bgcolor="#faeede">
<script language="JavaScript" type="text/javascript" src="commoninf.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/ajax.js"></script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align=left valign=middle>
    	<?echo "<script>drwfl('".$db['login']."','".$db['id']."','".$db['level']."','".$db['dealer']."','".$db['orden']."','".$db['admin_level']."','".$db['clan_short']."','".$db['clan']."');</script>";?>
		<span id="HP" style="font-size:10px"></span>&nbsp;<img src="img/icon/grey.jpg" alt="Уровень жизни" name="HP1" width="1" height="10" id="HP1"><img src="img/icon/grey.jpg" alt="Уровень жизни" name="HP2" width="1" height="10" id="HP2"><span style="width:1px; height:10px"></span>
		<script>top.setHP(<?echo $hp[0].",".$hp[1].",100";?>);</script>	
	</td>
    <td  align=right valign=middle>
    	<INPUT TYPE=button class="podskazka" value="Подсказка" onclick="window.open('help/zayavka.php','displayWindow','height=400,width=500,resizable=no,scrollbars=yes,menubar=no,status=no,toolbar=no,directories=no,location=no')"/>
		<INPUT TYPE=button value="Вернуться" onclick="location.href='main.php?act=none';">
	</td>
  </tr>
</table>
<table align="center" width="100%" border="0">
  	<tr class=m>
		<td width="14%" class="m" align="center"><a href="#" onclick="document.location.href='zayavkatrain.php'" class="f">Тренировочные</a></td>
		<td width="14%" class="m" align="center"><a href="#" onclick="document.location.href='zayavka.php'" class="f">Одиночные</a></td>
		<td width="14%" class="m" align="center"><a href="#" onclick="document.location.href='group_zayavka.php'" class="f">Групповые</a></td>
		<td width="14%" class="m" align="center"><a href="#" onclick="document.location.href='haot.php'" class="f">Хаотические</a></td>				
		<td width="14%" class="s" align="center"><a href="#" onclick="document.location.href='during.php'" class="f">Текущие</a></td>
		<td width="14%" class="m" align="center"><a href="#" onclick="document.location.href='archive.php'" class="f">Летописи</a></td>
	</tr>	
</table>
<?
	$krov=array("100","101","102");
	$battle=mysql_query("SELECT creator, date, type FROM zayavka WHERE status=3 ORDER BY UNIX_TIMESTAMP(date) DESC");
	$c=mysql_num_rows($battle);
	echo "<H3>Записи текущих боев на ".date("d.m.y")." (всего ".$c.")</H3>"; 
	if (!$c)	echo "<CENTER><BR><BR><B>Нет текущих боев :'(</B><BR><BR><BR></CENTER>";
	echo "<table width=100% cellspacing=0 cellpadding=5>";
	while($res=mysql_fetch_array($battle))
	{
		$n=(!$n);
		$team1 = "";
		$team2 = "";
		$cr = $res["creator"];
		$vaxt = $res["date"];
		$battle_type = $res["type"];
		$battle_img="<img src='img/battletype/".(in_array($battle_type,$krov)?"3.gif' border=0 alt='Кровавый бой'":"1.gif' border=0 alt='Бой с оружием'").">";				
		
		$sql="(SELECT users.login, users.id, users.level, users.dealer, users.orden,users.admin_level, users.clan_short, users.clan, users.remote_ip, users.battle as bat_id, t.team FROM users,(SELECT player, team FROM teams WHERE battle_id=$cr) as t WHERE login=t.player)
		UNION  (SELECT proto.bot_name, users.id, users.level, users.dealer, users.orden,users.admin_level, users.clan_short, users.clan, users.remote_ip, proto.battle_id as bat_id ,proto.team FROM users,(SELECT prototype, team, battle_id, bot_name FROM bot_temp,(SELECT id FROM battles WHERE creator_id=$cr) as bat WHERE battle_id=bat.id and zver=0)as proto WHERE users.login=proto.prototype)
		UNION  (SELECT proto.bot_name, zver.id, zver.level, zver.dealer, zver.orden,zver.admin_level, zver.clan_short, zver.clan, zver.remote_ip, proto.battle_id as bat_id ,proto.team FROM zver,(SELECT prototype, team, battle_id, bot_name FROM bot_temp,(SELECT id FROM battles WHERE creator_id=$cr) as bat WHERE battle_id=bat.id and zver=1)as proto WHERE zver.id=proto.prototype)";
		$team=mysql_query($sql);
		while($result=mysql_fetch_array($team))
		{
			$player="<script>drwfl('".$result['login']."','".$result['id']."','".$result['level']."','".$result['dealer']."','".$result['orden']."','".$result['admin_level']."','".$result['clan_short']."','".$result['clan']."');</script>".($admin?" <small><font color=gray>(".($result['remote_ip']?$result['remote_ip']:"none").")</font></small>":"");
			if ($cr==$result['id'])$player="<u>".$player."</u>";
			if ($result['team']==1)
			{	
				$team1.=$comma1.$player;
				$comma1=", ";
			}
			else
			{	
				$team2.=$comma2.$player;
				$comma2=", ";
			}
			$bid=$result['bat_id'];	
		}
		$comma1="";$comma2="";
		mysql_free_result($team);	
		echo "<tr class='".($n?'l0':'l1')."'><td nowrap valign=top>".$vaxt."<br><small><b>Тип боя:</b> <u>".boy_type($battle_type)."</small></td><td width=100%> $team1 против $team2 &nbsp; &nbsp;$battle_img <a href='log.php?log=".$bid."' class=us2 target='_blank'>»»</a></td></tr>";
	}
	mysql_free_result($battle);
	echo "</table>";
	mysql_close();
?>