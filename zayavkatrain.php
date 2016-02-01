<?
include("key.php");
ob_start("@ob_gzhandler");
$login=$_SESSION['login'];
$train=$_GET['train'];
include ("conf.php");
include ("time.php");
include ("align.php");
include ("functions.php");

Header("Cache-Control: no-cache, must-revalidate"); // говорим браузеру что-бы он не кешировал эту страницу
Header("Pragma: no-cache");

$data = mysql_connect($base_name, $base_user, $base_pass);
mysql_select_db($db_name,$data);
$result = mysql_query("SELECT * FROM users WHERE login='".$login."'");
$db = mysql_fetch_array($result);

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
$tr_time=2;
?>
<HEAD>	
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<meta http-equiv="Content-Language" content="ru">
	<META Http-Equiv=Cache-Control Content="no-cache, max-age=0, must-revalidate, no-store">
	<meta http-equiv=PRAGMA content=NO-CACHE>
	<meta http-equiv=Expires content=0>	
	<LINK REL=StyleSheet HREF='main.css' TYPE='text/css'>
</HEAD>
<body bgcolor="#faeede">
<script language="JavaScript" type="text/javascript" src="commoninf.js"></script>
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
		<td width="14%" class="s" align="center"><a href="#" onclick="document.location.href='zayavkatrain.php'" class="f">Тренировочные</a></td>
		<td width="14%" class="m" align="center"><a href="#" onclick="document.location.href='zayavka.php'" class="f">Одиночные</a></td>
		<td width="14%" class="m" align="center"><a href="#" onclick="document.location.href='group_zayavka.php'" class="f">Групповые</a></td>
		<td width="14%" class="m" align="center"><a href="#" onclick="document.location.href='haot.php'" class="f">Хаотические</a></td>
		<td width="14%" class="m" align="center"><a href="#" onclick="document.location.href='during.php'" class="f">Текущие</a></td>
		<td width="14%" class="m" align="center"><a href="#" onclick="document.location.href='archive.php'" class="f">Летописи</a></td>
	</tr>
</table>
<br>
<center><img src='img/city/turnir.jpg'><br>Здесь вы можете провести тренировочные бои с Вашей тенью.</center>
<?
if(!empty($db["travm"]))
{
 	echo "<div align=center><b style='color:#ff0000'>Вы не можете драться, т.к. тяжело травмированы!<br>Вам необходим отдых!</b></div>";
}
else if ($db["zayavka"])
{
	echo "<div align=center><b style='color:#ff0000'>Вы не можете принять этот вызов! Сначала отзовите текущую...</b><br>";
}
else
{
	if($db["level"]<=8)
	{
		?>	
			<div align=center><small>(* Бои с ботом проводятся до 8-го уровня)</small>
			 		<br><input type=button value='Начать тренеровку' class="button" style="cursor:hand" onClick="this.disabled=true; javascript:location.href='?train=1';">
			</div>
		<?
		if(isset($train))
		{
		   if($db["level"]<=8)
		   {
		   		startTrain($db);
		   }
		}  
	}
	else
	{
		echo "<div align=center><b style='COLOR: Red'>Ваш уровень превышает допустимый в бою с ботом!</b><br><small>(* Бои с ботом проводятся до 4-го уровня)</small></div>";
	}
}
?>