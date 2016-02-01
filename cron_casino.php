<?
include "conf.php";
$data = mysql_connect($base_name, $base_user, $base_pass);
mysql_select_db($db_name,$data);

function winner_bet()
{
	$sum_=mysql_fetch_Array(mysql_query("SELECT SUM(bet) as sum_bet, betto FROM roul_bets WHERE betto<37 GROUP BY betto ORDER BY sum_bet ASC LIMIT 1"));
	return (int)$sum_["betto"];
}
//--------------------------------------------------------------
$roundtime=60;
//--------------------------------------------------------------
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

//--------------------first we should perform all bets------------
$timer=mysql_fetch_array(mysql_query("SELECT * FROM roul_time"));
if ($timer[0]<=time()) // should roul
{
	/*$win_bet_number=win_bet();
	$arr=$win_number[$win_bet_number];
	$num=$arr[rand(0,count($arr)-1)];
	//if ($num==0)$num=mt_rand(0,36);*/
	$num=winner_bet();
	$bets=mysql_query("SELECT * FROM roul_bets");
	if (mysql_num_rows($bets)) // was bets
	{
		if (!$num) $strnum="Zero";
		else if (in_array($num, $red)) $strnum="$num, красное";
		else $strnum="$num, черное";
		$text="Ставки сделаны... Запускаем... Выпало <b>$strnum</b>. ";
	
		while ($cbet = mysql_fetch_array($bets))
		{
			if ($roul_wins[$num][$cbet['betto']])
			{
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
		if ($winners)
		{
			$text.="Удача улыбнулась <b>$winners</b>";
		} 
		else
		{
			$text.="Никто не выиграл";
		}

	}
	mysql_query("INSERT INTO roul_num (num, win, wintime) values ('".$num."', ".(int)$all_sum.", ".time().")");
	mysql_query("TRUNCATE TABLE `roul_bets`;");
	mysql_query("UPDATE roul_time SET shouldstart=".(time()+$roundtime));
}
//--------------------------------------------------------------
if ($text)
{
	$text = "sys<font color=black>$text</font>endSys";
	$chat_base = "/srv/www/meydan.az/public_html/chat/lovechat";
	$fopen_chat = fopen($chat_base,"a");
	fwrite ($fopen_chat,"::".time()."::toroom::#FF0000::$text::casino::mountown::\n");
	fclose ($fopen_chat);
}
//echo "ruletka";
?>