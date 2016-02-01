<?
$login=$_SESSION["login"];
include ('time.php');
$ip=$db["remote_ip"];
if($db["admin_level"]>=10)$admin=1;
if($db["admin_level"]>=4)$moder=1;

$z_money=array();
$z_money[8]	=1000;
$z_money[9]	=1500;
$z_money[10]=2000;
$z_money[11]=3000;
$z_money[12]=5000;


###//Действия
// Проверка
if ($_GET["id"] && $admin==1) 
{
	$pr_id=(int)$_GET["id"];
	$hinfo=mysql_fetch_Array(mysql_query("SELECT proverka.*,users.metka,users.blok,users.prision,users.remote_ip FROM proverka LEFT JOIN users on users.login=proverka.login WHERE proverka.id=".$pr_id));
	if ($hinfo['blok'])	$msg = "Пресонаж <b>".$hinfo['login']."</b> заблокирован!";
	else if ($hinfo['prision'])$msg = "Пресонаж <b>".$hinfo['login']."</b> в хаосе!";
	else if ($hinfo["metka"]+5*24*60*60>time())$msg = "У персонажа <b>".$hinfo['login']."</b> ещё действительна предыдущая проверка!";
	else 
	{
		mysql_query("UPDATE users SET metka='".time()."'  WHERE login='".$hinfo['login']."'");
		mysql_query("LOCK TABLES proverka WRITE, perevod WRITE, perevod_arch WRITE");
		mysql_query("DELETE FROM proverka where id=".$pr_id);
		mysql_query("INSERT INTO perevod_arch(date,login,action,item,ip,login2) SELECT perevod.date,perevod.login,perevod.action,perevod.item,perevod.ip,perevod.login2 FROM perevod WHERE login='".$hinfo['login']."';");
		mysql_query("DELETE FROM perevod WHERE login='".$hinfo['login']."'");
		mysql_query("UNLOCK TABLES");
		$txt="Проверка у Представителей порядка пройдена удачно. У Вас есть 5 суток для вступления в Ханство.";
		mysql_query("INSERT INTO pochta(user,whom,text,subject) VALUES ('Проверка','".$hinfo['login']."','".$txt."','Проверка у Представителей порядка')");
		$msg = "Вы пометили, что персонаж <b>".$hinfo['login']."</b> чист перед законом.";
		history($hinfo['login'],"Проверка","Проверка у Представителей порядка пройдена удачно. (Модератор: ".$login.")",$hinfo["remote_ip"],"Дом Проверки");
		history($login,"Проверка","Поставил метку персонажу ".$hinfo['login'],$db["remote_ip"],"Дом Проверки");
	}
}
// Отказ
if ($_GET["otkaz"] && $admin==1) 
{
	$otkaz=(int)$_GET["otkaz"];
	$comment=htmlspecialchars(addslashes($_POST['comment']));
	$comment=str_replace("\n","<br>",$comment);
	$hinfo=mysql_fetch_Array(mysql_query("SELECT * FROM proverka WHERE id=".$otkaz));
	if ($hinfo)
	{
		mysql_query("DELETE FROM proverka WHERE id=".$otkaz);
		$txt="Проверка у Представителей порядка не пройдена. Причина: ".$comment;
		mysql_query("INSERT INTO pochta(user,whom,text,subject) VALUES ('Проверка','".$hinfo['login']."','".$txt."','Проверка у Представителей порядка')");
		$msg = "Проверка не пройдена для персонаж <b>".$hinfo['login']."</b>.";
		history($hinfo['login'],"Отказ","Причина: ".$comment." (Модератор: ".$login.")",$hinfo["remote_ip"],"Дом Проверки");
		history($login,"Отказ","Причина: ".$comment." (Воин: ".$hinfo['login'].")",$db["remote_ip"],"Дом Проверки");

	}
}
// Причина рассмотрении
if ($_GET["prichina"] && ($moder==1 || $admin==1)) 
{
	$otkaz=(int)$_GET["prichina"];
	$comment=htmlspecialchars(addslashes($_POST['comment']));
	$comment=str_replace("\n","<br>",$comment);
	$hinfo=mysql_fetch_Array(mysql_query("SELECT * FROM proverka WHERE id=".$otkaz));
	if ($hinfo)
	{
		$txt="Дальнейшие операции. Причина: ".$comment;
		mysql_query("INSERT INTO pochta(user,whom,text,subject) VALUES ('Проверка','".$hinfo['login']."','".$txt."','Проверка у Представителей порядка')");
		mysql_query("UPDATE proverka SET zstatus=2, prichina='".$comment."',moder='".$login."' WHERE id=".$otkaz);
	}
}
// Действия
if ($_GET["deystv"] && ($moder==1 || $admin==1))
{
	$deystv=(int)$_GET["deystv"];
	$color=htmlspecialchars(addslashes(trim($_POST['color'])));
	$comment=htmlspecialchars(addslashes(trim($_POST['comment'])));
	echo $comment="<font color=".$color.">".$comment."</font>";
	$comment=str_replace("\n","<br>",$comment);
	$hinfo=mysql_fetch_Array(mysql_query("SELECT * FROM proverka WHERE id=".$deystv));
	if ($hinfo)
	{
		mysql_query("UPDATE proverka SET zstatus=3, prichina='".$comment."',moder='".$login."' WHERE id=".$deystv);
	}
}
//---------------------------
if ($_GET["podat"]) 
{
	//$msg="<h3>Закрыт на ремонт!</h3>";
	if (!$db["prision"])
	{	
		if ($db["money"]>=$z_money[$db["level"]])
		{
			if ($db["level"]>=8)
			{
				if ($db["metka"]+5*24*60*60<time())
				{
					$mes=mysql_fetch_array(mysql_query("SELECT * FROM proverka where login='".$login."'"));
					if (!$mes)
					{
						$c_pr=mysql_fetch_Array(mysql_Query("SELECT count(*) FROM proverka WHERE zstatus=1"));
						if ($c_pr[0]<30)
						{	
							mysql_query("UPDATE users SET money=money-".$z_money[$db["level"]]." WHERE login='".$login."'");
							mysql_query("INSERT INTO `proverka` (`login`,`zstatus`,`vaxt`) VALUES ('".$login."','1',".time().")");
							$db["money"]=$db["money"]-$z_money[$db["level"]];
							history($login,"Подал заявку на проверку",$z_money[$db["level"]]." Зл.",$ip,"Дом Проверки");
							$msg="Вы удачно подали заявку, ждите её рассмотрения!";
						} else  $msg="В проверке максимально 20 бойцов. Станьте в очередь...";
					} else  $msg="Вы уже подали заявку, ждите её рассмотрения!";
				} else $msg="Вы уже прошли проверку, ожидайте ее окончания!";
			} else $msg="У вас не тот уровень, рекомендованный уровень 12!";
		} else $msg="Для проверки необходимо ".$z_money[$db["level"]]." Зл., а у вас их нету!";
	} else $msg="Вы в Хаосе...";
} 
###//Конец Действия

$money = sprintf ("%01.2f", $db["money"]);
$platina = sprintf ("%01.2f", $db["platina"]);
?>
<script>
	var Hint3Name = '';
	// Заголовок, название скрипта, имя поля с логином
	function otkaz(title, script, name)
	{
		document.all("hint3").innerHTML = '<table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: hand" onclick="closehint3();"><BIG><B>x</td></tr><tr><td colspan=2>'+
		'<table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><form action="'+script+'" method=POST><INPUT TYPE=hidden name=sd4 value="<? echo $myinfo->id_person; ?>"><td colspan=2>'+
		'Укажите Причину</TD></TR><TR><TD width=50% align=right><textarea rows=5 cols=35 NAME="'+name+'"></textarea></TD><TD width=50%><INPUT type=image SRC="img/dmagic/gray_30.gif"></TD></TR>'+
		'<tr><td colspan=3>Цвет сообщений: <select name=color class="inup"><option style="COLOR: black" value="Black">Black</option>'+
		'<option style="COLOR: blue" value="Blue">Blue</option>'+
				'<option style="COLOR: green" value="Green">Green</option>'+
				'<option style="COLOR: maroon" value="Maroon">Maroon</option></select></FORM></TABLE></td></tr></table>';
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
<h3>Дом Проверки</h3>
<table width=100%>
<tr>
	<td width=100%>У вас в наличии: <B><?echo $money;?></b> Зл. <b><?echo $platina;?></b> Пл.</td>
	<td nowrap valign=top>
		<input type=button value='Вернуться' class=newbut onclick="document.location='main.php?act=go&level=remesl'">
		<input type=button value='Обновить'  class=newbut onClick="location.href='?act=none'">
	</td>
</tr>
</table>
<div id=hint3></div>
<?
echo"<center><font color=red><b>".$msg."</b></font></center><br>";

//Подача заявки
echo"
<table width='100%'>
	<tr><td align=center><b>Подача заявки на проверку</b></td></tr>";
	$me=mysql_fetch_array(mysql_query("SELECT * FROM proverka where login='".$login."'"));
	if ($db["metka"]+5*24*60*60>time()) echo"<td align=center><I>Вы уже прошли проверку на чистоту. Будет ещё длится: <b>".convert_time(($db["metka"]+5*24*60*60))."</I></td>";
	else if ($db["metka"]+20*24*60*60>time()) echo"<td align=center><I>До следующий проверки: <b>".convert_time(($db["metka"]+20*24*60*60))."</I></td>";
	else if ($me["zstatus"]==1 || $me["zstatus"]==3) echo"<td align=center><I>Ваша заявка находится на рассмотрении.</I></td>";
	else if ($me["zstatus"]==2) echo"<td align=center><font color=red><b>Состояния проверки:</b> ".$me["prichina"]."</font></td>";
	else echo"<td>Для подачи заявки вам нужно иметь:<br>
	- Иметь при себе <b>".$z_money[$db["level"]]."</b> Зл.<br>
	- Ваш уровень должен быть равен или более <b>8-го</b><br>
	<input type='button' value='Подать заявку на проверку' class=input onclick='document.location.href=\"?podat=1\"'></td>";
	echo"</tr>
</table>";

//----------------------------------------
echo"
	<TABLE width=100% cellspacing=1 cellpadding=5 class='l3' align=center>
	<TR style='font-weight:bold'>
		<TD width=10% align=center>№</TD><TD width=10% align=center>Действия</TD><TD align=center>Логин</TD><TD align=center>Состояние</TD><TD align=center>Время</TD><TD align=center>Модератор</TD>
	</TR>";
		$zay_ka=mysql_query("SELECT proverka.*,us.level,us.dealer,us.orden,us.admin_level,us.clan_short,us.clan, m.level as moder_level,m.dealer as moder_dealer,m.orden as moder_orden,m.admin_level as moder_admin_level,m.clan_short as moder_clan_short,m.clan as moder_clan FROM proverka LEFT JOIN users us on us.login=proverka.login LEFT JOIN users m on m.login=proverka.moder ORDER BY vaxt ASC");
		if (mysql_num_rows($zay_ka)) 
		{
			while ($zayavka=mysql_fetch_array($zay_ka))
			{
				$i++;
				$n=(!$n);
				switch ($zayavka['zstatus'])
				{
					case 1:$zstatus="На рассмотрении";break;
					case 2:$zstatus="Дальнейшие операции";break;
					case 3:$zstatus="<b>".$zayavka["prichina"]."</b>";break;
				}
				$zstatus=str_replace("&amp;","&",$zstatus);
				$zstatus=str_replace("&amp;","&",$zstatus);$zstatus=str_replace("&amp;","&",$zstatus);
				echo"<tr class='".($n?'l0':'l1')."'>
				<TD align='center' witdh=20>$i</td>
				<TD align='center' nowrap>";
				if ($admin)
				{	
					echo "<input type='button' value='Поставить метку' style='font-weight:bold;color:green;' onclick=\"document.location.href='?id=".$zayavka["id"]."'\">
					<br><input type='button' value='Отказ На чистоту ' onclick=\"JavaScript:otkaz('Отказ на проверку<br>персонажу ".$zayavka['login']."','?otkaz=".$zayavka["id"]."', 'comment')\">";
				}
				if ($moder)
				{	
					echo "<br><input type='button' value='Причина рассмотрении' onclick=\"JavaScript:otkaz('Причина рассмотрении<br>персонажу ".$zayavka['login']."','?prichina=".$zayavka["id"]."', 'comment')\">
					<br><input type='button' value='Действия' onclick=\"JavaScript:otkaz('Действия<br>персонажу ".$zayavka['login']."','?deystv=".$zayavka["id"]."', 'comment')\">";
				}
				echo "</TD>
				<TD align=center nowrap><script>drwfl('".$zayavka['login']."','".$zayavka['id']."','".$zayavka['level']."','".$zayavka['dealer']."','".$zayavka['orden']."','".$zayavka['admin_level']."','".$zayavka['clan_short']."','".$zayavka['clan']."');</script></TD>";
				echo "<TD align=center>".($db["orden"]==1?$zstatus:"<i style='color:grey'>Скрыта</i>")."</TD>";
				echo "<TD align=center nowrap>".date("d.m.Y H:i", $zayavka["vaxt"])."</TD>
				<TD align=center nowrap>".($zayavka["moder"]?"<script>drwfl('".$zayavka['moder']."','".$zayavka['moder_id']."','".$zayavka['moder_level']."','".$zayavka['moder_dealer']."','".$zayavka['moder_orden']."','".$zayavka['moder_admin_level']."','".$zayavka['moder_clan_short']."','".$zayavka['moder_clan']."');</script>":"")."</TD>
				</tr>";
			}
		} 
		else echo"<tr><td colspan=6><center>Новых Заявок Не Подано!</center></td></tr>";
echo"</table>";
?>