<?
include("key.php");
ob_start("@ob_gzhandler");
include("req.php");
include("conf.php");
include ("inc/battle/battle_type.php");

array_walk($_REQUEST,"format_string");
array_walk($_POST,"format_string");
array_walk($_GET,"format_string"); 
$login=$_SESSION['login'];
Header("Cache-Control: no-cache, must-revalidate"); // говорим браузеру что-бы он не кешировал эту страницу
Header("Pragma: no-cache");

$data = mysql_connect($base_name, $base_user, $base_pass) or die('Не получается подключиться. Проверьте имя сервера, имя пользователя и пароль!');
mysql_select_db($db_name) or die('Ошибка входа в базу данных');

$tar=$_GET['tar'];
if(empty($tar)&& empty($_POST['target']))
{
	$target_p = $login;
}
else if (isset($tar))
{
	$target_p = $tar;
}
else if (isset($_POST['target']))
{
	$target_p = $_POST['target'];
}

$target=$_POST['target'];
$date=$_POST['date'];
$scan=$_POST['scan'];
$view=$_POST['view'];
$curday=$date;
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
<body bgcolor="#faeede">
<?
$result = mysql_query("SELECT * FROM users WHERE login='".$login."'");
$db = mysql_fetch_array($result);
$my_orden = $db["orden"];
$adminsite = $db["adminsite"];

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

if($_POST['date']=='')
{
	$d=getdate(time());
	$date1=mktime(0,0,0,$d[mon],$d[mday],$d[year]);
	$date2=$date1+86400;
}
else
{
	$d=explode('.',str_replace('_','.',$_POST['date']));
	$date1=mktime(0,0,0,$d[1],$d[0],$d[2]);
	$date2=$date1+86400;
}
?>
<script language="JavaScript" type="text/javascript" src="commoninf.js"></script>
<script type="text/javascript">
function formSubmit()
{
	document.getElementById("arch").submit()
}
</script>
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
		<td width="14%" class="m" align="center"><a href="#" onclick="document.location.href='during.php'" class="f">Текущие</a></td>
		<td width="14%" class="s" align="center"><a href="#" onclick="document.location.href='archive.php'" class="f">Летописи</a></td>
	</tr>	
</table>
<table border=0 width=100%>
<TR>
	<td><h3>Архив поединков за <?echo date('d.m.Y',$date1)?></h3></td>
</TR>
<TR>
	<td align=center>
		<form name="arch" action='archive.php?act=view&tmp=<?=md5(time());?>' method="POST">
			<input type=hidden name=type value=fin>
			Бои персонажа: <input type=text class=new style="width:100px;" name="target" value="<?=$target_p?>">
			за: <input type=text class=new style="width=100" name="date" value="<?=date('d.m.Y',$date1)?>">
			<input type=submit name="view" class=but value="Найти" style="width=100"><br>
			<input class=new style="width:120px" value="&lt;&lt; день назад" type=button onclick="arch.date.value='<?=date('d.m.Y',$date1-86400)?>';formSubmit();">
			<input class=new style="width:120px" value="день вперед &gt;&gt;" type=button onclick="arch.date.value='<?=date('d.m.Y',$date2)?>';formSubmit();">
		</form>
	</td>
</tr>
</table>
<?
//------------------------------------------------Показать только бои персонажа---------------------------------------
if($_POST["type"]!="")
{
	$date = str_replace(".","-",$date);
	$date1=strtotime($date);
	$date2=strtotime($date)+24*60*60;
    $sql="SELECT t.*,b.date,b.win,b.type FROM team_history t LEFT JOIN battles_archive b on (UNIX_TIMESTAMP(date)>=$date1 and UNIX_TIMESTAMP(date)<$date2) WHERE t.battle_id=b.id and t.login='".htmlspecialchars(addslashes($target))."'";
    $TEAM = mysql_query($sql);
    if (!mysql_num_rows($TEAM)) 
	{
		echo "<CENTER><B>В этот день не было боев...</B></CENTER>";
	}
	else
	{
		unset($i);
		echo "<table width=100% cellspacing=0 cellpadding=5>";
		while ($i<mysql_num_rows($TEAM)) 
		{
			$n=(!$n);
			$i++;
			$T_D = mysql_fetch_array($TEAM);
			$bid = $T_D["battle_id"];
			$vaxt = $T_D["date"];
			$btype = $T_D["type"];
	        $team1 = "";
	        $team2 = "";
	        $win1="";$win2="";
	        if($T_D["win"]==1){$win1 = "<img src='img/index/win.gif' alt='Победа за этой коммандой'>";}
	        elseif($T_D["win"]==2){$win2 = "<img src='img/index/win.gif' alt='Победа за этой коммандой'>";}
        
			$LIST_TEAM = mysql_query("SELECT * FROM team_history WHERE battle_id='".$bid."'");
			$counts1=0;
			$counts2=0;

			while($T_LISTD = mysql_fetch_array($LIST_TEAM))
	        {
	        	if($my_orden == 1 || $my_orden == 6)
	        	{
	        		$ip = $T_LISTD["ip"];
	        		$ip_t = "(<i>ip: <small>$ip</small></i>)";
	        	}
	        	else{$ip_t = "";}
				if ($T_LISTD['team']==1) 
				{
					$team1.=($counts1>0?", ":"")."<script>lrb('".$T_LISTD['login']."','".$T_LISTD['level']."','".$T_LISTD['dealer']."','".$T_LISTD['orden']."','".$T_LISTD['admin_level']."','".$T_LISTD['clan_short']."','".$T_LISTD['clan']."','p1');</script> $ip_t";
					$counts1++;
				}
				else 
				{
					$team2.=($counts2>0?", ":"")."<script>lrb('".$T_LISTD['login']."','".$T_LISTD['level']."','".$T_LISTD['dealer']."','".$T_LISTD['orden']."','".$T_LISTD['admin_level']."','".$T_LISTD['clan_short']."','".$T_LISTD['clan']."','p2');</script> $ip_t";
					$counts2++;
				}
	        }
	        echo  "<tr class='".($n?'l0':'l1')."'><td valign=top><b>$i</b>. </td><td nowrap valign=top>".$vaxt."<br><small><b>Тип боя:</b> <u>".boy_type($btype)."</small></td><td width=100%>$team1 $win1 <SPAN style='color: red; font-weight: bold; '>против</SPAN> $team2 $win2 <a href='log.php?log=$bid&tmp=".md5(time())."' class=us2 target='_blank'>»»</a></td></tr>";
		}
		echo "</table>";
	}
}
//------------IP SCAN-----------------------------------------------
/*if(!empty($_POST['scan']))
{
	if (($my_orden == 1 && $adminsite >= 5) || ($my_orden == 6 && $adminsite >= 3))
	{
		$count_ip=0;
		$txt_="SELECT team_history.*,bat.date,bat.win FROM team_history LEFT JOIN battles bat on bat.id=team_history.battle_id WHERE login='".htmlspecialchars(addslashes($target))."'";
		$sql=mysql_query($txt_);
		while($res=mysql_fetch_array($sql))
		{
			$vaxt=$res["date"];	
			$B = $res["battle_id"];
			$win1="";
			$win2="";
			$team1 = "";
			$team2 = "";
	    	if($res["win"]==1){$win1 = "<img src='img/index/win.gif' alt='Победа за этой коммандой'>";}
	    	elseif($res["win"]==2){$win2 = "<img src='img/index/win.gif' alt='Победа за этой коммандой'>";}
			$txt="SELECT * FROM team_history WHERE battle_id='".$B."' and ip='".$res['ip']."')";
			$sql_=mysql_query($txt);
			if (mysql_num_rows($sql_)>1)
			{	
				$count_ip++;
				while ($BSD=mysql_fetch_array($sql_))
				{
					$ip_t = " (<b style='color:green'><small>IP: $BSD[ip]</small></b>) ";
					if ($BSD['team']==1) $team1.="<script>drwfl('".$BSD['login']."','".$BSD['id']."','".$BSD['level']."','".$BSD['dealer']."','".$BSD['orden']."','".$BSD['admin_level']."','".$BSD['clan_short']."','".$BSD['clan']."');</script> $ip_t";
					else $team2.="<script>drwfl('".$BSD['login']."','".$BSD['id']."','".$BSD['level']."','".$BSD['dealer']."','".$BSD['orden']."','".$BSD['admin_level']."','".$BSD['clan_short']."','".$BSD['clan']."');</script> $ip_t";
				}
				echo  "<div style='padding: 2px;'> ".$vaxt." $team1 $win1 <i>против</i> $team2 $win2 <a href='log.php?log=$B&tmp=".md5(time())."' class=us2 target='_blank'>»»</a></div>";
			}
		}
		if (!$count_ip) echo "<CENTER><BR><BR><B>Бои проведенные с одного IP-адреса не было...</B><BR><BR><BR></CENTER>";
		$_POST[type]="";
	}
}*/
mysql_close();
?>
<br><br>