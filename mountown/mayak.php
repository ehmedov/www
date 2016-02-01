<?
$login=$_SESSION['login'];
$mine_id=$db["id"];
$now=md5(time());
$ip=$db["remote_ip"];
$time=($db["hell_time"]+6*3600)-time();
##============================================================
if($_REQUEST["go"] && $_REQUEST["level"] && $time<0)
{
	$have_hell=mysql_fetch_Array(mysql_query("SELECT * FROM `hellround_pohod` WHERE `end` = 0 and `owner`=".$mine_id.";"));
	if(!$have_hell)
	{
		$timeout = time()+60;
		$names = array("Бармаглот","Пещерный-Ящер","Повелитель-Бармаглотов", "Угрюмый-Дендроид","Мерцающий-феникс","Сумрачный-Грифон", "Ядерник","Радскорпион","Дикий гул", "Леврета", "Линграонц", "Падший король");
		mysql_query("UPDATE users SET hell_time=".time()." WHERE login='".$login."'");
		mysql_query("INSERT INTO zayavka(status, type, timeout, creator) VALUES('3','19','1','".$mine_id."')");
	    mysql_query("INSERT INTO teams(player, team, ip, battle_id) VALUES('".$login."','1','".$ip."','".$mine_id."')");
		mysql_query("INSERT INTO battles(type, creator_id, lasthit) VALUES('19', '".$mine_id."', '".$timeout."')");
		$b_id=mysql_insert_id();
		mysql_query("INSERT INTO hellround_pohod(date_in, volna, owner,level, unikal_count, bat_id) VALUES('".time()."', '1', '".$mine_id."', '".(int)$_REQUEST["level"]."', 1, ".$b_id.")");

		if($db["level"]==8){$from=0;$ends=2;}
		else if($db["level"]==9){$from=3;$ends=5;}
		else if($db["level"]==10){$from=6;$ends=8;}
		else if($db["level"]>=11){$from=9;$ends=11;}
		for ($i=$from; $i<=$ends; $i++)
		{
			$k++;
			$attacked_bot=$names[$i];
			$GBD = mysql_fetch_array( mysql_query("SELECT hp_all FROM users WHERE login='".$attacked_bot."'"));
			mysql_query("INSERT INTO bot_temp(bot_name, hp, hp_all, battle_id, prototype, team, two_hands, shield_hands) 
			VALUES('".$attacked_bot."(".$k.")','".$GBD["hp_all"]."','".$GBD["hp_all"]."','".$b_id."','".$attacked_bot."','2','1','".rand(0,1)."')");
		}
		goBattle($login);
	}
}
##============================================================
?>
<body style="background-image: url(img/index/mayak.jpg);background-repeat:no-repeat;background-position:top right">
<h3>Таинственный Маяк<br><small>(Тестовые версии)</small></h3>
<table width=100%>
<tr>
	<td width=50%>
		<input type="button" style="background-color:#AA0000; color: white;" onclick="window.location='main.php?act=go&level=hell_shop'" value="Оружейная Комната">
		<input type="button" style="background-color:#AA0000; color: white;" onclick="window.location='?action=change'" value="Обменные пункты">
	</td>
	<td align=right>
		<input type="button" class="newbut" onclick="window.location='main.php?act=go&level=nature'" value="Вернуться">
		<input type="button" class="newbut" onclick="window.location='main.php?act=none'" value="Обновить">
	</td>
</tr>
</table>
<?
	#if(!$db["adminsite"]) die("UNDER CONSTRUCTION");
?>
<br>
<table width=100%>
<tr>
<td width=100% valign=top>	
<?
######################################################################################	
if ($time<0)
{
	?>
		<FORM>
			<input type="radio" name="level" value="8">Проход для любителей<br/>
			<INPUT type="hidden" name="go" value="1">
			<INPUT type="submit" value="Начать поход">
		</FORM>
	<?
}
else
{
	$h=floor($time/3600);
	$m=floor(($time-$h*3600)/60);
	$sec=$time-$h*3600-$m*60;
	if($h<=0){$hour="";}else $hour="$h ч.";
	if($m<0){$minut="";}else $minut="$m мин.";
	if($sec<0){$sec=0;}
	$left="$hour $minut $sec сек.";
	echo "<b>Вы можете посетить Таинственный Маяк через ".$left."</b>";
}
######################################################################################
?>
<?
if ($_GET["action"]=="change")
{
	$change_count=100;
	echo "<br><br>";
	if ($_GET["buy"]=="unikal")
	{
		$have_obrazec=mysql_fetch_array(mysql_query("SELECT count(*) FROM inv WHERE owner='$login' and object_id=139 and object_type='wood'"));
		if($have_obrazec[0]>=$change_count)
		{
			mysql_query("INSERT INTO `inv` (`owner`, `object_id`, `object_type`, `object_razdel` ,`iznos`, `iznos_max`) VALUES ('$login', '141','wood','thing','0','1');");
			mysql_query("DELETE FROM inv WHERE inv.object_type='wood' and inv.owner='".$login."' and inv.object_id=139 LIMIT $change_count");
			$msg="Вы удачно обменяли <b style='color:red'>[Образец]x$change_count</b> на <b>Идеальные Образцы</b>";
		}
		else
		{
			$msg="Не хватает: <b style='color:red'>Образец x".($change_count-$have_obrazec[0])."</b>";
		}
	}
	$obrazec=mysql_fetch_Array(mysql_Query("SELECT * FROM wood WHERE id=141"));
	echo "
	<center>$msg</center>
	<TABLE WIDTH=500 CELLSPACING=1 CELLPADDING=2 BGCOLOR=#A5A5A5>
	<tr bgcolor='#D5D5D5'>
		<td valign=center align=center width=100>
			<img src='img/".$obrazec["img"]."'><br>
			<A HREF=\"?action=change&buy=unikal\">купить</A>
		</td>
		<td valign='top'>
			<b>".$obrazec["name"]."</b> (Масса: ".$obrazec["mass"].")<BR>
			<b>Цена: ".sprintf ("%01.2f", $obrazec["price"])." Зл.</b><BR>
			Требуется предмет: <b style='color:red'>[Образец]x$change_count</b><br>
			Долговечность: 0/1<BR><BR>
			<small><font color=brown>Предмет не подлежит ремонту</font></small><BR>
		</td>
	</TR>
	</table>";
}
?>

</td>
<td valign=top width=600 nowrap>
	<?
		$_GET["top"]="mayak1";
		switch($_GET["top"])
		{
			case "mayak1":$top_level=8;$desc="Проход для любителей"; 	break;
			case "mayak2":$top_level=9;$desc="Проход для бывалых";	break;
			case "mayak3":$top_level=10;$desc="Проход для профессионалов"; 	break;
			case "mayak4":$top_level=11;$desc="Проход для жителей"; 	break;
			case "mayak5":$top_level=12;$desc="Проход для ветеранов"; 	break;
		}
		echo "
		<table width=100%>
		<tr><td colspan=4 align=center>$desc</td></tr>
		<tr class='newbut'><td>Боец</td><td>Максимальная волна</td><td>Рейтинг</td><td>Лог боя</td></tr>";
		$sql_top=mysql_query("SELECT MAX(volna)as max_volna, SUM(volna)as sum_volna, bat_id, users.id, users.login, users.level, users.orden, users.admin_level, users.dealer, users.clan_short, users.clan FROM hellround_pohod LEFT JOIN users ON users.id=owner WHERE hellround_pohod.level=$top_level GROUP BY owner ORDER BY sum_volna DESC LIMIT 50");
		while($row=mysql_fetch_array($sql_top))
		{
			echo "<tr><td><script>drwfl('".$row["login"]."', '".$row["id"]."', '".$row["level"]."', '".$row["dealer"]."',  '".$row["orden"]."', '".$row["admin_level"]."', '".$row["clan_short"]."', '".$row["clan"]."');</script></td><td align=center>".$row["max_volna"]."</td><td align=center>".$row["sum_volna"]."</td><td><a href='log.php?log=".(int)$row["bat_id"]."' target='_blank'>»»</a></td></tr>";
		}
		echo "</tr></table>";
		
	?>
</td>
</tr>
</table>
<br><br><br><br>
<?include_once("counter.php");?>