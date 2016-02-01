<?
#die("<h3>Закрыт на ремонт</h3><input type=button onclick=\"location.href='main.php?act=go&level=bazar'\" value=\"Вернуться\" class=new >");
$login=$_SESSION["login"];
unwear_full($login);
mysql_query("DELETE FROM inv WHERE owner='".$login."' and wear=0 and bs=1");

if ($db['bs'] == 1) 
{ 
	header('Location: main.php?act=go&level=towerin'); 
	die(); 
}
$user=$db;
class predbannik_bs 
{
		var $mysql; // mysql
		var $userid = 0; // мой ижентификатор
		var $turnir_id = 0; // айти турнира
		var $turnir_info = 0;
			
		// создаем класс
		function predbannik_bs () 
		{
			global $mysql, $user;
			$this->mysql = $mysql;
			$this->userid = $user;
			$this->turnirstart = mysql_fetch_array(mysql_query("SELECT `value` FROM `variables` WHERE `var` = 'startbs' LIMIT 1;"));
			$this->turnirstart = $this->turnirstart[0];
		}

		// проверить идет ли турнир?
		function get_turnir () 
		{
			$dat = mysql_fetch_array(mysql_query("SELECT * FROM `deztow_turnir` WHERE `active` = 1"));
			$this->turnir_id = $dat[0];
			return $dat;
		}

		//==================================================================
		// начало турнира!!!!!!!
		function start_turnir () 
		{
			$loc=array('0x0','1x0','2x0','3x0','4x0','5x0','6x0','13x0','6x1','10x1','11x1','12x1',	'13x1','16x1','17x1','18x1','19x1','6x2','10x2','16x2','0x3','1x3','2x3','3x3','4x3','5x3','6x3','10x3','13x3','14x3','15x3','16x3','0x4','10x4','13x4','0x5','1x5','2x5','8x5','9x5','10x5','13x5','14x5','15x5','16x5','17x5','18x5','19x5','2x6','8x6','19x6','2x7','8x7','9x7','10x7','11x7','19x7','2x8','11x8','19x8','2x9','3x9','4x9','5x9','6x9','11x9','15x9','16x9','17x9','18x9','19x9','6x10','11x10','15x10','19x10','6x11','11x11','15x11','19x11','1x12','2x12','3x12','4x12','5x12','6x12','11x12','12x12','13x12','14x12','15x12','16x12','17x12','1x13','17x13','1x14','2x14','3x14','4x14','5x14','6x14','7x14','8x14','9x14','17x14','1x15','9x15','17x15','1x16','9x16','17x16','18x16','1x17','2x17','3x17','4x17','9x17','10x17','11x17','12x17','13x17','14x17','18x17','1x18','4x18','5x18','6x18','14x18','18x18','1x19','6x19','7x19','8x19','9x19','10x19','11x19','14x19','15x19','16x19','17x19','18x19');

			// вычисляем кто прошел в турнир
			$dat = mysql_query("SELECT dt.owner FROM `deztow_stavka` as dt, `online` as o WHERE o.login = dt.owner AND room = 'smert_room' ORDER by `kredit` DESC, dt.`time` ASC  LIMIT 20;");
			if(mysql_num_rows($dat))
			{
				$have_bs=mysql_fetch_array(mysql_query("SELECT * FROM `deztow_turnir` WHERE `active` = 1"));
				if (!$have_bs)
				{
					$stavka = mysql_fetch_array(mysql_query("SELECT SUM(`kredit`)*0.75 FROM `deztow_stavka`;"));
					while($row=mysql_fetch_array($dat)) 
					{	
						shuffle($loc);
						$coord=$loc[0];
						// пихаем учасников в БС
						mysql_query("UPDATE users SET bs=1, location='".$coord."',vector=0 WHERE login='".$row[0]."'");
						mysql_query("DELETE FROM labirint WHERE user_id='".$row[0]."'");
						mysql_query("INSERT INTO labirint(user_id, location, vector, visit_time) VALUES('".$row[0]."', '".$coord."', '0', '".time()."')");

						// список участников
						$lors.= $comma."<b>".$row[0]."</b>";
						$comma=", ";
					}
					say("toall_news","<font color=red>Турнир Начался...Участники: $lors</font>",$_SESSION["login"]);
					// формируем лог и создаем запись о турнире
					$log = '<span class=date>'.date("d.m.y H:i").'</span> Начало турнира. Участники: '.$lors.'<BR>';
					mysql_query("INSERT `deztow_turnir` (`type`,`winner`,`coin`,`start_time`,`log`,`endtime`,`active`) values ('".rand(1,7)."','','".$stavka[0]."','".time()."','".$log."','0','1');");

					shuffle($loc);
					$count_wmot=mysql_num_rows(mysql_query("SELECT id FROM bs_objects"));
					for($i=1;$i<=$count_wmot;$i++)
					{
						mysql_query("UPDATE bs_objects SET coord='".$loc[$i]."' WHERE id=$i");
					}
				}
			}
			else
			{
				mysql_query('DELETE FROM `deztow_turnir` WHERE `active` = TRUE');
				mysql_query('UPDATE `variables` SET `value` = \''.(time()+10*60).'\' WHERE `var` = \'startbs\';');
				mysql_query("TRUNCATE TABLE `deztow_stavka`;");
			}
		}
		//==================================================================
		// проверить ставку
		function get_stavka () 
		{
			$dat = mysql_fetch_array(mysql_query("SELECT `kredit` FROM `deztow_stavka` WHERE `owner` = '".$this->userid['login']."' LIMIT 1;"));
			return $dat[0];
		}
		// поставить
		function set_stavka ($kredit) 
		{
			if($kredit >= 10 && $this->userid['level'] >= 8 && $this->userid['money'] >= $kredit && is_numeric($kredit)) 
			{
				mysql_query("INSERT `deztow_stavka` (`owner`,`kredit`,`time`) values ('".$this->userid['login']."','".$kredit."','".time()."' ); ");
				mysql_query("UPDATE `users` set `money` = `money`- '".$kredit."' WHERE login = '".$this->userid['login']."'");
				// ON DUPLICATE KEY UPDATE `kredit` = '".$kredit."';");
				history($this->userid['login'],"Подал заявку на турнир","<b>".$kredit." Зл.</b>",$this->userid['remote_ip'],"Турнир");
				$_SESSION["battle_ref"] = 0;
				echo mysql_error();
			}
		}
		// поставить
		function up_stavka ($kredit) 
		{
			if($kredit >= 10 && $this->userid['level'] >= 8 && $this->userid['money'] >= $kredit && is_numeric($kredit)) 
			{
				mysql_query("UPDATE `deztow_stavka` SET `kredit` = `kredit`+'".$kredit."' WHERE `owner` = '".$this->userid['login']."';");
				mysql_query("UPDATE `users` set `money` = `money`- '".$kredit."' WHERE login = '".$this->userid['login']."'");
				history($this->userid['login'],"Увеличил ставку","<b>".$kredit." Зл.</b>",$this->userid['remote_ip'],"Турнир");
				echo mysql_error();
			}
		}
		function get_count () 
		{
			$dat = mysql_fetch_array(mysql_query("SELECT count(*) FROM `deztow_stavka` LEFT JOIN online on online.login=deztow_stavka.owner WHERE room='smert_room'"));
			return $dat[0];
		}
		// получить сумму ставок
		function get_fond () 
		{
			$dat = mysql_fetch_array(mysql_query("SELECT SUM(`kredit`)*0.75, count(`kredit`) FROM `deztow_stavka`;"));
			$this->turnir_info = array(round($dat[0],2),$dat[1]);
			return $this->turnir_info;
		}
		function get_users() 
		{
			$dat = mysql_query("SELECT us.login,us.id,us.level,us.dealer,us.orden,us.admin_level,us.clan_short,us.clan,us.bs FROM deztow_stavka LEFT JOIN users us on deztow_stavka.owner=us.login");
			while ($s_t = mysql_fetch_array($dat)) 
		  	{
		    	$k.=$comma."<script>drwfl('".$s_t['login']."','".$s_t['id']."','".$s_t['level']."','".$s_t['dealer']."','".$s_t['orden']."','".$s_t['admin_level']."','".$s_t['clan_short']."','".$s_t['clan']."');</script>";
		    	$comma=",&nbsp;";
		  	}
		  	$this->turnir_users=$k;
			return $this->turnir_users;
		}
	}
	
	$bania = new predbannik_bs;
	if($_POST['docoin']) 
	{
		if ($_POST['coin']<=200)
		{
			$bania->set_stavka ($_POST['coin']) ;
		}
		else $msg="Максимальная ставка 200.00 Зл.";
	}
	if($_POST['upcoin']) 
	{
		if (($_POST['coin']+$bania->get_stavka ())<=200)
		{
			$bania->up_stavka ($_POST['coin']);
		}
		else $msg="Максимальная ставка 200.00 Зл.";
	}
	$tr = $bania-> get_turnir();
	// старт турнира
	if($tr['id']==0 && $bania->turnirstart < time()) 
	{
		if ($bania->get_count()>=4)	
		{
			$bania->start_turnir ();
		}
		else 
		{
			$al=mysql_query("SELECT * FROM deztow_stavka");
			while ($rr=mysql_fetch_array($al))
			{
				mysql_query("UPDATE users SET money=money+".$rr["kredit"]." WHERE login='".$rr["owner"]."'");
				say($rr["owner"],"Турнир не может состояться по причине: участников меньше 4-х человек в комнате Турнирная арена",$rr["owner"]);
			}
			mysql_query("TRUNCATE TABLE `deztow_stavka`;");
			mysql_query('UPDATE `variables` SET `value` = \''.(time()+15*60).'\' WHERE `var` = \'startbs\';');
		}
	}
	$bania->get_fond();
?>
<body style="background-image: url('img/index/turnir.jpg');background-repeat:no-repeat;background-position:top right">
<TABLE width=100% border=0>
<tr valign=top>
	<td nowrap><INPUT TYPE="button" value="Задания в Башне" style="background-color:#AA0000; color: white;" onclick="location.href='?act=go&level=zadaniya';"></td>
	<td width=100%><h3>Турнирная арена</h3></td>
	<td align=right nowrap>
		<input type=button  class=newbut onclick="location.href='main.php?act=go&level=bazar'" value="Вернуться">
		<input type=button  class=newbut onclick="location.href='main.php?act=none'" value="Обновить">
    	<INPUT TYPE=button class="podskazka" value="Подсказка" onclick="window.open('help/tower.php','displayWindow','height=400,width=500,resizable=no,scrollbars=yes,menubar=no,status=no,toolbar=no,directories=no,location=no')"/>
	</td>
</tr>
</table>

<FORM method=POST action="main.php?act=none">
<?
if($tr['id'] == 0)
{ 
?>
	<h4>Прием заявок на следующий турнир.<small>(Турнир не начнется, если собралось меньше 4-х человек.)</small></h4><BR>
	Начало турнира: <span class=date><b><?=date("Y.m.d H:i:s",$bania->turnirstart)?></b></span><BR>
	Призовой фонд на текущий момент: <B><?=sprintf ("%01.2f", $bania->turnir_info[0]);?></B> Зл.<BR>
	Всего подано заявок: <B><?=$bania->turnir_info[1];?></B><BR>
	<?
		if($bania->get_users()!="")
		echo "В турнире принимают участие: <br>".$bania->get_users()."<br>";
	?>	
	<h4>Подать заявку</h4>
	<?
		if($bania->get_stavka ()) 
		{
			echo "Вы уже поставили <B><FONT COLOR=red>".$bania->get_stavka()." Зл.</B></FONT> хотите увеличить ставку? (минимальная ставка <b>10.00 Зл.</B>) У вас в наличии <b>".sprintf ("%01.2f", $user["money"])." Зл.</b><BR>";
			?>
			<script>
				function refreshPeriodic()
				{
					document.location.href='main.php?act=none';
					timerID=setTimeout("refreshPeriodic()",20000);
				}
				timerID=setTimeout("refreshPeriodic()",20000);
			</script>
			<input type="text" name="coin" value="10" size="4" maxlength=4> <input type="submit" value="Увеличить ставку" name="upcoin"><BR>
			<?
		}
		else
		{
			echo "Сколько ставите кредитов? (минимальная ставка <b>10.00 Зл.</B> у вас в наличии <b>".sprintf ("%01.2f", $user["money"])." Зл.</b>)<BR>";
			?><input type="text" name="coin" value="10" size="8" maxlength=4> <input type="submit" value="Подать заявку" name="docoin"><BR><?
		}
	?>
	Чем выше ваша ставка, тем больше шансов принять участие в турнире. Подробнее о башне смерти читайте в разделе "Подсказка".
	<?
	If($msg)echo "<br><font color=red>$msg</font>";
}
else 
{
	$lss = mysql_query("SELECT * FROM `users` WHERE `bs` = 1;");
	$i=0;
	while($in = mysql_fetch_array($lss)) 
	{
		$i++;
		if($i>1) { $lors .= ", "; }
		$lors .= "<script>drwfl('$in[login]','$in[id]','$in[level]','$in[dealer]','$in[orden]','$in[admin_level]','$in[clan_short]','$in[clan]');</SCRIPT>";
	}
	?>
	<H4>Турнир начался.</H4>
	Призовой фонд: <B><?=$tr['coin']?> Зл.</B><BR>
	<H4>Живых участников на данный момент:</H4><?=$lors?>
	<BR><BR><?=$tr['log']?>
	<?
}
//------------------------------------------
$row = mysql_query("SELECT * FROM `deztow_turnir` WHERE `active` = FALSE and winnerlog!='' ORDER by `id` DESC LIMIT 10;");
if (mysql_num_rows($row))
{
	echo "<P>&nbsp;<H4>Победители 10-ти предыдущих турниров</H4>
	<OL>";
	while($dat = mysql_fetch_array($row)) 
	{
		$p_users=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE login='".$dat['winnerlog']."'"));
		?>
		<LI>Победитель: <?="<script>drwfl('$p_users[login]','$p_users[id]','$p_users[level]','$p_users[dealer]','$p_users[orden]','$p_users[admin_level]','$p_users[clan_short]','$p_users[clan]');</SCRIPT>"?>. Начало турнира <FONT class=date><?=date("d.m.y H:i",$dat['start_time'])?></FONT> продолжительность <FONT class=date><?=floor(($dat['endtime']-$dat['start_time'])/60/60)?> ч. <?=floor(($dat['endtime']-$dat['start_time'])/60-floor(($dat['endtime']-$dat['start_time'])/60/60)*60)?> мин.</FONT> приз: <B><?=$dat['coin']?> Зл.</B> <A HREF="towerlog.php?id=<?=$dat['id']?>" target=_blank>история турнира »»</A></LI>
		<?
	}
	echo "</OL>";
}
//---------------------
$dat = mysql_fetch_array(mysql_query("SELECT * FROM `deztow_turnir` ORDER BY `coin` DESC LIMIT 1;"));
if ($dat)
{	
	$win_pers=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE login='".$dat['winnerlog']."'"));
	?>
	<H4>Максимальный выигрыш</H4>
	Победитель: <?echo "<script>drwfl('$win_pers[login]','$win_pers[id]','$win_pers[level]','$win_pers[dealer]','$win_pers[orden]','$win_pers[admin_level]','$win_pers[clan_short]','$win_pers[clan]');</SCRIPT>";?>. Начало турнира <FONT class=date><?=date("d.m.y H:i",$dat['start_time'])?></FONT>. Продолжительность <FONT class=date><?=floor(($dat['endtime']-$dat['start_time'])/60/60)?> ч. <?=floor(($dat['endtime']-$dat['start_time'])/60-floor(($dat['endtime']-$dat['start_time'])/60/60)*60)?> мин.</FONT>. Приз: <B><?=$dat['coin']?> Зл.</B> <A HREF="towerlog.php?id=<?=$dat['id']?>" target=_blank>история турнира »»</A><br>
	<?
}
$dat = mysql_fetch_array(mysql_query("SELECT * FROM `deztow_turnir` ORDER BY (`endtime`-`start_time`) DESC LIMIT 1;"));
if ($dat)
{
	$win_pers=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE login='".$dat['winnerlog']."'"));
	?>
	<H4>Самый продолжительный турнир</H4>
	Победитель: <?echo "<script>drwfl('$win_pers[login]','$win_pers[id]','$win_pers[level]','$win_pers[dealer]','$win_pers[orden]','$win_pers[admin_level]','$win_pers[clan_short]','$win_pers[clan]');</SCRIPT>";?>. Начало турнира <FONT class=date><?=date("d.m.y H:i",$dat['start_time'])?></FONT> продолжительность <FONT class=date><?=floor(($dat['endtime']-$dat['start_time'])/60/60)?> ч. <?=floor(($dat['endtime']-$dat['start_time'])/60-floor(($dat['endtime']-$dat['start_time'])/60/60)*60)?> мин.</FONT> приз: <B><?=$dat['coin']?> Зл.</B> <A HREF="towerlog.php?id=<?=$dat['id']?>" target=_blank>история турнира »»</A><br>
	<?
}
echo "<br><br><br><br>";
include_once("counter.php");
?>
</BODY>
</HTML>