<?
$login=$_SESSION['login'];
unwear_full($login);
$have_elik=mysql_fetch_Array(mysql_query("SELECT * FROM effects WHERE user_id=".$db["id"]." and type='jj'"));
if ($have_elik)
{
	mysql_query("UPDATE users SET hp_all=hp_all-".$have_elik["add_hp"]." WHERE login='".$db["login"]."'");
	mysql_query("DELETE FROM effects WHERE id=".$have_elik["id"]);
	history($login,"Действие Эликсира","Действие Эликсира <b>«Жажда жизни+?»</b> закончилось",$db["remote_ip"],"Комната Знахаря");
	talk($db["login"],"Действие Эликсира <b>«Жажда жизни+?»</b> закончилось!!!",$db);
}
##############################################################################3
$expstats = array(
		/*   nextup,=>summstats,sumvinosl*/
		"1" => array (8,4,1),
		"2" => array (14,5,3),
		"3" => array (23,6,4),
		"4" => array (35,7,5),
		"5" => array (50,8,6),
		"6" => array (68,9,7),
		"7" => array (89,10,8),
		"8" => array (113,11,9),
		"9" => array (140,12,10),
		"10" => array (170,13,11),
		"11" => array (200,14,12),
		"12" => array (200,15,13),
		"13" => array (220,16,14),
		"14" => array (300,17,15),
		"15" => array (320,18,16),
		"16" => array (350,19,17),
		"17" => array (380,20,48),
		"18" => array (410,21,51),
		"19" => array (440,22,54),
		"20" => array (470,23,57),
		"21" => array (500,24,60),
		"22" => array (530,25,63),
		"23" => array (560,26,66),
		"24" => array (590,27,69),
		"25" => array (630,28,72),
		"26" => array (670,29,75),
		"27" => array (710,30,78),
		"28" => array (750,31,81),
		"29" => array (790,32,84),
		"30" => array (840,33,87),
		"31" => array (890,34,90),
		"32" => array (940,35,93),
		"33" => array (990,36,96),
		"34" => array (1040,37,99),
		"35" => array (1140,38,102),
);


$price_masttery=$db["level"]*0;
$price_all_stat=$db["level"]*0;
$price_stat=0;

if ($db["level"]<36)$price_masttery=0;
if ($db["level"]<36)$price_all_stat=0;
if ($db["level"]<36)$price_stat=0;
$tmp=md5(time());
//----------------------dropmastery-------------------------------------------------------------	
if ($_POST['dropmastery'])
{
	if ($db['money']<$price_masttery) 
	{
		$mess="У вас нет столько денег!";
	}
	else
	{
		mysql_query("UPDATE users SET money=money-$price_masttery, umenie=".$expstats[$db['level']][2]."+add_umenie,phisic_vl=0,castet_vl=0,sword_vl=0,axe_vl=0,hummer_vl=0,copie_vl=0,staff_vl=0,fire_magic=0,earth_magic=0,water_magic=0,air_magic=0,svet_magic=0,tma_magic=0,gray_magic=0 WHERE login='".$login."'");
		$mess="Удачно скинуты Умения. Вам это стоило ".$price_masttery." Зл.";
		history($login,"Сбросить Навыки",$mess,$db["remote_ip"],"Комната Знахаря");
	}
	$db = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE login='".$login."'"));
}
//-----------------------dropstats---------------------------------------------------	

if ($_POST['dropstats'])
{
	if ($db['money']<$price_all_stat) 
	{
		$mess="У вас нет столько денег!";
	}
	else
	{
		mysql_query("UPDATE users SET money=money-$price_all_stat, ups=".$expstats[$db['level']][0]."+add_ups,sila=3,lovkost=3,udacha=3,power=".$expstats[$db['level']][1].",hp=1,hp_all=".($expstats[$db['level']][1]*6).",intellekt=0,vospriyatie=0,duxovnost=0,mana=0,mana_all=0 WHERE login='".$login."'");
		$mess="Удачно скинуты Параметры. Вам это стоило ".$price_all_stat." Зл.";
		history($login,"Сбросить Параметры",$mess,$db["remote_ip"],"Комната Знахаря");
	}
	$db = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE login='".$login."'"));
}

//-----------------------------------------------------------------------------------
if ($_POST['movestat']) 
{
	$mf1=$_REQUEST['stat'];
	$mf2=$_REQUEST['statchange'];
	if ($mf1==$mf2)
	{
		$mess="Стат нельзя перекинуть в самого себя.";
	}
	else if (($mf1=="sila" && $db[$mf1]<4) || ($mf1=="lovkost" && $db[$mf1]<4)||($mf1=="udacha" && $db[$mf1]<4)||($mf1=="power" && $db[$mf1]<=$expstats[$db['level']][1])||($mf1=="vospriyatie" && $db[$mf1]<1)||($mf1=="intellekt" && $db[$mf1]<1)||($mf1=="duxovnost" && $db[$mf1]<1))
	{
		$mess="Невозможно перераспределить статы ниже минимального уровня.";
	}
	else if ($db["money"]<$price_stat)
	{
		$mess="У вас нет столько денег!";
	}	
	else if ($mf1=="power")
	{
		mysql_query("UPDATE users SET power=power-1, hp_all=hp_all-6,money=money-$price_stat, $mf2=$mf2+1 WHERE login='".$login."'");
		$mess="Удачно переброшен стат. Вам это стоило ".$price_stat." Зл.";
	}
	else if ($mf2=="power")
	{
		mysql_query("UPDATE users SET $mf1=$mf1-1,power=power+1,money=money-$price_stat, hp_all=hp_all+6 WHERE login='".$login."'");
		$mess="Удачно переброшен стат. Вам это стоило ".$price_stat." Зл.";
	}
	else if ($mf1=="vospriyatie")
	{
		mysql_query("UPDATE users SET vospriyatie=vospriyatie-1, mana_all=mana_all-10, money=money-$price_stat, $mf2=$mf2+1 WHERE login='".$login."'");
		$mess="Удачно переброшен стат. Вам это стоило ".$price_stat." Зл.";
	}
	else if ($mf2=="vospriyatie")
	{
		mysql_query("UPDATE users SET $mf1=$mf1-1, vospriyatie=vospriyatie+1, money=money-$price_stat, mana_all=mana_all+10 WHERE login='".$login."'");
		$mess="Удачно переброшен стат. Вам это стоило ".$price_stat." Зл.";
	}
	else
	{
		mysql_query("UPDATE users SET $mf1=$mf1-1,$mf2=$mf2+1,money=money-$price_stat WHERE login='".$login."'");
		$mess="Удачно переброшен стат. Вам это стоило ".$price_stat." Зл.";
	}
	$db = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE login='".$login."'"));
}
//-----------------------------------------------------------------------------------	

$money = sprintf ("%01.2f", $db["money"]);
$platina = sprintf ("%01.2f", $db["platina"]);
?>
<h3>Комната Знахаря</h3>
<TABLE width=100% cellspacing=0 cellpadding=0><tr><td><b style=color:#ff0000><?=$mess;?>&nbsp;</b></td><td align=right>У вас в наличии: <B><?echo $money;?></b> зл. <b><?echo $platina;?></b> пл.</td></tr></table>
<div align=right>
	<input type=button value="Обновить" class=new onClick="javascript:location.href='main.php?act=none'">
	<input type=button value="Выход" class=new onClick="javascript:location.href='main.php?act=go&level=remesl'">
</div>
<table align=center width=100%>
<tr>
<td width=100% valign=top>
<FORM method=POST action="?act=none">
<FIELDSET><LEGEND><b>Навыки владения оружием и магией</b></LEGEND>
<TABLE width=98% align=center>
<TD>
У вас есть шанс  забыть старое ради нового (<?=$price_masttery?> Зл.): <INPUT type=submit name='dropmastery' value='Сбросить Навыки' onclick="return confirm('Вы действительно хотите сбросить умения?')"><BR><BR>
</TABLE>
</FIELDSET>
</FORM>


<FORM method=POST action="?act=none">
<FIELDSET><LEGEND><b>Параметры персонажа</b></LEGEND>
<TABLE width=98% align=center>
<TD>
У вас есть шанс  забыть старое ради нового (<?=$price_all_stat?> Зл.): <INPUT type=submit name='dropstats' value='Сбросить Параметры' onclick="return confirm('Вы действительно хотите сбросить все Параметры до минимального уровня?')"><BR><BR>
</TABLE>
</FIELDSET>
</FORM>

<FIELDSET>
<LEGEND><b>Параметры</b></LEGEND>
	<table align=center width=100%>
	<tr>
	<td valign=center>
		
		Сила : <?echo $db['sila'];?><br>
		Ловкость : <?echo $db['lovkost'];?><br>
		Удача : <?echo $db['udacha'];?><br>
		Выносливость : <?echo $db['power'];?><br>
		Интеллект :	<?echo $db['intellekt'];?><br>
		Восприятие : <?echo $db['vospriyatie'];?><br>
		<?
			if ($db['level']>9)
			{	
			?>
				Духовность : <?echo $db['duxovnost'];?><br>	
			<?
			}
		?>
			<br>
		
		<form method="post" action="?<?=$tmp?>">
		Перенести <select name="stat">
			<option value="sila">Сила
			<option value="lovkost">Ловкость
			<option value="udacha">Удача
			<option value="power">Выносливость
			<option value="intellekt">Интеллект	
			<option value="vospriyatie">Восприятие
			<?if($db['level']>9) {?><option value="duxovnost">Духовность<?}?>
		</select>
		в <select name="statchange">
			<option value="sila">Сила (<?=$price_stat;?>  зл.)
			<option value="lovkost">Ловкость (<?=$price_stat;?>  зл.)
			<option value="udacha">Удача (<?=$price_stat;?>  зл.)
			<option value="power">Выносливость (<?=$price_stat;?>  зл.)
			<option value="intellekt">Интеллект (<?=$price_stat;?>  зл.)
			<option value="vospriyatie">Восприятие (<?=$price_stat;?>  зл.)
			<?if($db['level']>9) {?><option value="duxovnost">Духовность (<?=$price_stat;?>  зл.)<?}?>
			
		</select>
		<br>Роспись: <input type="submit" name="movestat" value=" Согласен " onclick="return confirm('Вы уверены в своем выборе?')">
		</form>
	</td>	
	</tr>
	</table>
</FIELDSET>

</td>
<td align=right> 
	<img src="img/index/stat.gif" border=0>	
</td>
</tr>
</table>
