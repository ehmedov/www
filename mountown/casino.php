<h3>Дом отдыха</h3>
<TABLE width=100% border=0>
<tr valign=top>
	<td align=right nowrap>
		<INPUT TYPE=button  class="podskazka" value="Подсказка" onclick="window.open('help/casino.php','displayWindow','height=400,width=500,resizable=no,scrollbars=yes,menubar=no,status=no,toolbar=no,directories=no,location=no')"/>
		<input type=button  class=newbut onclick="window.open('top.php?act=casino','displayWindow','')" value="Рейтинг">
		<input type=button  class=newbut onclick="location.href='main.php?act=go&level=remesl'" value="Вернуться">
		<input type=button  class=newbut onclick="location.href='main.php?act=none'" value="Обновить">
	</td>
</tr>
</table>
<SCRIPT src='roulette.js'></SCRIPT>	
<?
$roundtime=60;
$minbet=1;
$maxbet=100;
if ($db["adminsite"]==5)$maxbet=5000;
$login=$_SESSION["login"];
$Player_name = $login;
//-----------------------------------------------------------------------
/*if (!$db["adminsite"]) 
{
	die("<CENTER>Закрыто на реставрацию! Завозим новое оборудование.</CENTER><BR>");
}*/
if ($db["level"] < 7) 
{
	die("<CENTER>Увы, но рулетка доступна персонажам с 8-го уровня</CENTER><BR>");
}
if($db["prision"])
{
	die("<CENTER>Хаосникам Вход запрешен!!!</CENTER><BR>");
}
//-------------------------------------------
/*$win_number=array();
$win_number[0]=array(0);
$win_number[37]=array(1,4,7,10,13,16,19,22,25,28,31,34);
$win_number[38]=array(2,5,8,11,14,17,20,23,26,29,32,35);
$win_number[39]=array(3,6,9,12,15,18,21,24,27,30,33,36);
$win_number[40]=array(1,2,3,4,5,6,7,8,9,10,11,12);
$win_number[41]=array(13,14,15,16,17,18,19,20,21,22,23,24);
$win_number[42]=array(25,26,27,28,29,30,31,32,33,34,35,36);
$win_number[43]=array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18);
$win_number[44]=array(2,4,6,8,10,12,14,16,18,20,22,24,26,28,30,32,34,36);
$win_number[45]=array(1,3,5,7,9,12,14,16,18,19,21,23,25,27,30,32,34,36);
$win_number[46]=array(2,4,6,8,10,11,13,15,17,20,22,24,26,28,29,31,33,35);
$win_number[47]=array(1,3,5,7,9,11,13,15,17,19,21,23,25,27,29,31,33,35);
$win_number[48]=array(19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36);
*/
//-------------------------------------------
function winner_bet()
{
	$sum_=mysql_fetch_Array(mysql_query("SELECT SUM(bet) as sum_bet, betto FROM roul_bets WHERE betto<37 GROUP BY betto ORDER BY sum_bet ASC LIMIT 1"));
	if ($sum_["betto"]==0)$sum_["betto"]=rand(0,36);
	return (int)$sum_["betto"];
}

function sum_betto($num)
{
	$sum_s=mysql_fetch_Array(mysql_query("SELECT count(*) FROM roul_bets WHERE betto=$num"));
	return $sum_s[0];
}
//-------------------------------------------

$roul_names[0]="ZERO";
for ($i=0; $i<3; $i++)
{
	for ($j=0; $j<12; $j++)
    $roul_names[$j*3+$i+1]=($j*3+$i+1);
  	$roul_names[37+$i]=($i+1)." ряд";
  	$roul_names[40+$i]=($i+1)." дюжину";
}

$roul_names[43]="от 1 до 18";
$roul_names[44]="чет";
$roul_names[45]="красное";
$roul_names[46]="черное";
$roul_names[47]="нечет";
$roul_names[48]="от 19 до 36";

for ($j=0; $j<12; $j++)
{
	$roul_names[49+$j]=($j*3+1) . "-" . ($j*3+3);
	$roul_names[61+$j]=($j*3+2) . "," . ($j*3+3);
	$roul_names[73+$j]=($j*3+1) . "," . ($j*3+2);
}

for ($j=0; $j<11; $j++)
{
	for ($i=0; $i<3; $i++)
	$roul_names[85+(2-$i)*11+$j]=($j*3-$i+3) . "," . ($j*3-$i+6);
	$roul_names[118+$j]=($j*3+1) . "-" . ($j*3+6);
	$roul_names[129+$j]=($j*3+1) . "," . ($j*3+2) . "," . ($j*3+4) . "," . ($j*3+5);
	$roul_names[140+$j]=($j*3+2) . "," . ($j*3+3) . "," . ($j*3+5) . "," . ($j*3+6);
}

// fill in roul_wins
$roul_wins[0][0]=36;
$red=array(1,3,5,7,9,12,14,16,18,19,21,23,25,27,30,32,34,36);
for ($i=1; $i<=36; $i++)
{
	$roul_wins[$i][$i]=36;
}
for ($i=0; $i<3; $i++)
{
	for ($j=0; $j<12; $j++)
	{
		$roul_wins[$i+1+$j*3][37+$i]=3;
		$roul_wins[$i+1+$j*3][40+floor(($i+$j*3)/12)]=3;
		$roul_wins[$i+1+$j*3][43+floor(($i+$j*3)/18)*5]=2;
		$roul_wins[$i+1+$j*3][47-(($i+$j*3)%2)*3]=2;
		$roul_wins[$i+1+$j*3][49+floor(($i+$j*3)/3)]=12;
		$roul_wins[$i+1+$j*3][45+(in_array($i+1+$j*3,$red)?0:1)]=2;
	}
}
for ($j=0; $j<12; $j++)
{
	$roul_wins[$j*3+2][61+$j]=18;
	$roul_wins[$j*3+3][61+$j]=18;
	$roul_wins[$j*3+1][73+$j]=18;
	$roul_wins[$j*3+2][73+$j]=18;
}
for ($j=0; $j<11; $j++)
{
	for ($i=0; $i<3; $i++)
	{
		$roul_wins[$j*3-$i+3][85+(2-$i)*11+$j]=18;
		$roul_wins[$j*3-$i+6][85+(2-$i)*11+$j]=18;
	}
	for ($i=1; $i<=6; $i++) $roul_wins[$j*3+$i][118+$j]=6;
	$roul_wins[$j*3+1][129+$j]=9;
	$roul_wins[$j*3+2][129+$j]=9;
	$roul_wins[$j*3+4][129+$j]=9;
	$roul_wins[$j*3+5][129+$j]=9;
	$roul_wins[$j*3+2][140+$j]=9;

	$roul_wins[$j*3+3][140+$j]=9;
	$roul_wins[$j*3+5][140+$j]=9;
	$roul_wins[$j*3+6][140+$j]=9;
}

$win_stone=array();
$win_stone[0]=array(1,3,5,7,9,12,14,16,18,19,21,23,25,27,30,32,34,36);
$win_stone[1]=array(0,2,4,6,8,10,11,13,15,17,20,22,24,26,28,29,31,33,35);

//-----------------------------------------------------------------
$timer_sql=mysql_fetch_array(mysql_query("SELECT * FROM roul_time"));
if($timer_sql[1]<=0)
{
	die("<CENTER><b>Увы, администрация казино отказывается Вас обслуживать. Казино Обанкротился :(</b></CENTER><BR>");
}

$timer=$timer_sql[0];
if ($timer<=time()) 
{
	$is_time=mysql_fetch_array(mysql_query("SELECT * FROM roul_time WHERE shouldstart<".time()));
	if ($is_time)
	{	
		mysql_query("UPDATE roul_time SET shouldstart=".(time()+$roundtime));
		$timer=time()+$roundtime;
		/*if(sum_betto(0)>0)
		{	
			$rand=mt_Rand(0,1);
			$winner=array();
			$winner = $win_stone[$rand];
			shuffle($winner);
			$num = $winner[0];
		}
		else $num=0;*/
		//$num=winner_bet();
		$num=mt_Rand(0,36);
		if (!$num) $strnum="Zero";
		else if (in_array($num, $red)) $strnum="$num, красное";
		else $strnum="$num, черное";
		$text="Ставки сделаны... Запускаем... Выпало <b>$strnum</b>. ";
		

		$bets=mysql_query("SELECT * FROM roul_bets");
		if (mysql_num_rows($bets)) // was bets
		{
			while ($cbet = mysql_fetch_array($bets))
			{
				$all_summer+=$cbet['bet'];
				if ($roul_wins[$num][$cbet['betto']])
				{
					$all_summer_wins+=$cbet['bet'];
					$wins[$cbet['Username']]+=$cbet['bet']*$roul_wins[$num][$cbet['betto']];
					$all_sum+=$cbet['bet']*$roul_wins[$num][$cbet['betto']];
					mysql_query("INSERT INTO roul_wins (Username, bet, betto, win, wintime,win_number) values ('". $cbet['Username'] . "', " . $cbet['bet']. ", " . $cbet['betto']. ", " . $cbet['bet']*$roul_wins[$num][$cbet['betto']]. ", ". time() .",$num)");   
				}
			}  	
			$winners='';
			if (isset($wins))
			{
				foreach ($wins as $user => $winmoney)
				{
					if ($winners) $winners.=', ';
					$winners.=$user;
					mysql_query("UPDATE users SET money=money+'".$winmoney."' WHERE login='".$user."'");   
					mysql_query("UPDATE casino SET Price=Price+'".$winmoney."' WHERE Username='".$user."'");   
				}
			}
		}
		if ($winners)
		{
			$text.="Удача улыбнулась <b>$winners</b>";
		} 
		else
		{
			$text.="Никто не выиграл";
		}

		talk("toroom",$text,$db);
		mysql_query("UPDATE roul_time SET cash=cash-".(int)$all_sum."+".(int)($all_summer-$all_summer_wins));
		mysql_query("INSERT INTO roul_num (num, win, lose, all_sum, wintime) values ('".$num."', '".(int)$all_sum."', '".(int)($all_summer-$all_summer_wins)."', '".$all_summer."' ,'".time()."')");
		mysql_query("TRUNCATE TABLE `roul_bets`;");
	}
}
//-----------------------------------------------------------------
$lefttime=$timer-time()+4;
// process user bet
$outstr='';
if ($_GET["bet"] && $roul_names[$_GET["betto"]]) 
{
  	if (is_numeric($_GET["bet"])) 
  	{
		$bet=(int)$_GET["bet"];
  		$betto=(int)$_GET["betto"];

  		$my_bet=mysql_fetch_array(mysql_query("SELECT SUM(bet) FROM roul_bets WHERE Username='".$login."'"));
    	if ($bet<$minbet) $outstr="Ставка слишком маленькая"; 
    	else if (($bet+$my_bet[0])>$maxbet) $outstr="Ставка слишком большая. Максимальная ставка $maxbet Зл."; 
    	else if ($bet>$db["money"]) $outstr="У вас стольки нет"; 
    	else 
    	{
      		mysql_query("UPDATE users SET money=money-'".$bet."' WHERE login='".$Player_name."'");   
      		$casinostat=mysql_fetch_array(mysql_query("SELECT count(*) FROM casino WHERE Username='".$Player_name."'"));
      		if (!$casinostat[0])
      		{
        		mysql_query("INSERT INTO casino (Username, Price) values ('$Player_name', '0')");   
      		}
      		mysql_query("UPDATE casino SET Price=Price-'".$bet."' WHERE Username='".$Player_name."'");   
      		mysql_query("INSERT INTO roul_bets (Username, bet, betto) values ('$Player_name', '$bet', '$betto')");
      		$outstr="Ставка принята";
      		$db["money"]-=$bet;
    	}
  	}
  	/*else 
  	{
	    $outstr='Попытка обмана игры занесена в логи, ждите наказания';
    	writestring("Игрок $Player_name пытается обмануть казино и скоро будет наказан");
  	}*/
}
?>

<script>lefttime=<?= $lefttime ?>;</script>
<body onload="firstload();">
<table align=center border=0>
<tr>
	<td colspan=3>
		<font color=red><?= $outstr;?></font><br>
		<center>
		У вас в наличии: <B><?= sprintf("%01.2f", $db["money"]) ?></b> Зл. <b style="color:brown">[Баланс Казино : <?=$timer_sql[1]?> Зл.]</b> <br>
		До запуска рулетки осталось <b id=timercl>0:00</b>
		</center>
	</td>
</tr>
<tr>
	<td width=200 nowrap valign=top>
	<?
	$cwins=mysql_query("SELECT * FROM roul_bets WHERE Username='".$login."'");
	if (mysql_num_rows($cwins)) 
	{
		?>
		<table WIDTH=100%>
			<tr><td colspan=3 ALIGN=CENTER><B>Ваши ставки</tr>
			<tr bgcolor=#cccccc><td>Номер</td><td>Сумма</td></tr>
			<?
			while ($cwin = mysql_fetch_array($cwins))
			{
				switch ($cwin['betto'])
				{	case 0:$betto_txt="ZERO";break;
					case $cwin['betto']<37:$betto_txt=$cwin['betto'];break;					
					case 37:$betto_txt="1 ряд";break;
					case 38:$betto_txt="2 ряд";break;
					case 39:$betto_txt="3 ряд";break;
					case 40:$betto_txt="1 дюжина";break;
					case 41:$betto_txt="2 дюжина";break;
					case 42:$betto_txt="3 дюжина";break;
					case 43:$betto_txt="от 1 до 18";break;
					case 44:$betto_txt="чет";break;
					case 45:$betto_txt="красное";break;
					case 46:$betto_txt="черное";break;
					case 47:$betto_txt="нечет";break;
					case 48:$betto_txt="от 19 до 36";break;
					
				}
		       	echo "<tr><td align=center>".$betto_txt."</td><td align=center>".$cwin['bet']."</td></tr>";
			}  
			?>
		</table>
	<?
	}
	?>
	</td>
	<td nowrap width=100% align=center valign=top> 
		<IMG SRC="img/index/roulette.gif" BORDER=0 USEMAP="#RouletteMap">
		<MAP NAME="RouletteMap"><script>buildtable();</script></MAP>
		<IMG SRC="img/index/roul.gif" BORDER=0>
	</td>
	<td width=200 nowrap valign=top>
	<?
  		$cwins=mysql_query("SELECT * FROM roul_num ORDER BY wintime DESC LIMIT 15");
  		if (mysql_num_rows($cwins)) 
  		{
			?>
			<table WIDTH=100%>
				<tr><td colspan=3 ALIGN=CENTER><B>Последние выигрыши</tr>
				<tr bgcolor=#cccccc><td>№</td><td>Сум.</td><td>Проиг.</td><td>Все</td></tr>
				<?
				while ($cwin = mysql_fetch_array($cwins))
				{
			       echo "<tr><td align=center>".$cwin['num']."</td><td align=center>".(int)$cwin['win']."</td><td align=center>".(int)$cwin['lose']."</td><td align=center>".(int)$cwin['all_sum']."</td></tr>";
				}  
				?>
			</table>
		<?
  		}
		?>
	</td>
</tr>
<tr>
	<td colspan=3>
	<center>
		<form method="GET" action="?act=none" id=betform >
		<div id=betto style="display: none">
			Вы ставите на <b id=betname></b>&nbsp;&nbsp;&nbsp;
			<input type=text name=bet id=bet value=1 size=10 /> Зл. 
			<INPUT TYPE=button value="Поставить" onclick="betclick();" />
			<br><small> Для того чтобы сделать ставку введите сумму ставки и нажмите кнопку "Поставить" </small>
		</div>
		</form>
		<?
  		$cwins=mysql_query("SELECT * FROM roul_wins WHERE Username='".$Player_name."' ORDER BY wintime DESC LIMIT 5");
  		if (mysql_num_rows($cwins)) 
  		{
		?>
		<table WIDTH=400>
			<tr><td colspan=3 ALIGN=CENTER><B>Последние ваши выигрыши</tr>
			<tr bgcolor=#cccccc><td>Ставка</td><td>Выиграно</td><td>Время</td></tr>
			<?
			while ($cwin = mysql_fetch_array($cwins))
			{
		       echo "<tr><td>".$cwin['bet']." Зл. на ". $roul_names[$cwin['betto']]."</td><td align=center>".$cwin['win']."</td><td>".date('d.m.y H:i', $cwin['wintime'])."</td></tr>";
			}  
			?>
		</table>
		<?
  		}
		?>
	</center>
	</td>
</tr>
</table>
</body>
</html>