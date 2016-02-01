<body style="background-image: url(img/index/lotto.jpg);background-repeat:no-repeat;background-position:top right">
<TABLE width=100% border=0>
<tr valign=top>
	<td width=100%><h3>Лотерея Хаоса (5 из 30)</h3></td>
	<td align=right nowrap>
		<input type=button onclick="location.href='main.php?act=go&level=remesl'" value="Вернуться" class=new >
		<input type=button onclick="location.href='main.php?act=none'" value="Обновить" class=new >
    	<INPUT TYPE=button class="podskazka" value="Подсказка" onclick="window.open('help/lotery.php','displayWindow','height=400,width=500,resizable=no,scrollbars=yes,menubar=no,status=no,toolbar=no,directories=no,location=no')"/>
	</td>
</tr>
</table>
<?
#if ($_SESSION["login"]!="bor")die("Закрыто!");
$money = sprintf ("%01.2f", $db["money"]);
$user=$db;
class Lottery
{
	function get_this_user_id()
	{
		// определеить id пользователя
		global $user;
		return $user['id'];
	}

	function buy($txt = '')
	{
		// списать сумму билета
		global $user;
		if ($user['money'] < 1) 		{			$this->mess = 'Не хватает денег<BR>';		} 		else 		{			$this->mess = $txt.'<BR>';			mysql_query("update users set money = money - 1 where id = ".$user['id'].";");
			mysql_query("INSERT INTO inv(owner,object_id,object_type,object_razdel,msg,term) VALUES ('".$user['login']."','193','flower','flud','".$txt."','".(time()+3600*24*7)."')");
		}
	}

	function pay_for_5($summ)
	{
		// оплата если 5 из 5 угадано
		global $user;
        mysql_query("update users set money = money + '".$summ."' where id = ".$user['id'].";");
        history($user['login'],'Билет выиграл (5 из 5 угадано)',$summ." Зл.",$user['remote_ip'],'Лотерея Хаоса');
	}

	function pay_for_4($summ)
	{
		// оплата если 4 из 5 угадано
		global $user;
        mysql_query("update users set money = money + '".$summ."' where id = ".$user['id'].";");
		history($user['login'],'Билет выиграл (4 из 5 угадано)',$summ." Зл.",$user['remote_ip'],'Лотерея Хаоса');
	}

	function pay_for_3($summ){
		// оплата если 3 из 5 угадано
		global $user;
		mysql_query("update users set money = money + '".$summ."' where id = ".$user['id'].";");
		history($user['login'],'Билет выиграл (3 из 5 угадано)',$summ." Зл.",$user['remote_ip'],'Лотерея Хаоса');
	}

	function buy_ticket($selected_str)
	{
		$selected_str = substr($selected_str,0,strlen($selected_str)-1);
		$selected_array = explode(',',$selected_str);
		sort($selected_array);

		$id_user = $this->get_this_user_id();

		if (sizeof($selected_array) ==5)
		{
		
			for($i=0;$i<5;$i++)
			{
				$values .= $selected_array[$i].',';
			}
	        $sql = "select id,date from lottery where end='0'";
			$res = mysql_query($sql);
			while($result_lottery = mysql_fetch_assoc($res))
			{
				$id_lottery = $result_lottery['id'];
				$id_date=$result_lottery['date'];
			}

			$this->buy("Тираж № ".$id_lottery." состоится $id_date. Выбраные номера: ".$values);
        	
        	$this->mess.= "<font color=red><B>Билет куплен. В ваш рюкзак добавлен лотерейный билет.<BR></font></b>";
			$date = date('Y-m-d H:i:s');
			$sql = "insert into lottery_log(`id_user`,`values`,`date`,`id_lottery`) values('".$id_user."','".$values."','".date('Y-m-d H:i:s')."','".$id_lottery."')";
			$res = mysql_query($sql);
			$jackpot = 0;
			$sql = "select * from `lottery` where end=0 limit 1";
			$res = mysql_query($sql);
			while($result = mysql_fetch_assoc($res))
			{
				$id = $result['id'];
				$jackpot = $result['jackpot'];
				$fond = $result['fond'];
			}
			$fond += 0.7;
			$sql = "update lottery set fond='".$fond."' where id='".$id."' ";
			mysql_query($sql);
			if($this->mess != null) 
        	{
        		return "<font color=red><B>".$this->mess."</font></b>";
        	}
		}
	}

	

	function get_count($win_combination,$user_combination)
	{
		$user_array = explode(',',$user_combination);

		$count = 0;

		for($i=0;$i<5;$i++){
			if (strpos(",".$win_combination,",".$user_array[$i].",") !== FALSE){
				$count ++; //echo substr($win_combination,$z,1)." ";
			}
		}

		return $count;
	}
	

	function check($id_lottery)
	{
		$id_user = $this->get_this_user_id();

		//$sql_comb = "select values from lottery_win_combination where id_lottery='".$id_lottery."'";

		if ($id_lottery < 1)  
		{
			$sql_comb = "select * from lottery where end=1 order by id DESC LIMIT 1;";
			$res_comb = mysql_fetch_array(mysql_query($sql_comb));
			$id_lottery = $res_comb['id'];
		}

        $sql_comb = "select * from lottery_win_combination where id_lottery='".$id_lottery."'";
		$res_comb = mysql_query($sql_comb);


		while($result_comb = mysql_fetch_assoc($res_comb))
		{
			$win_combination_str = $result_comb['values'];
		}

		$sql_summ = "select * from lottery where id='".$id_lottery."'";
		$res_summ = mysql_query($sql_summ);
		while($result_summ = mysql_fetch_assoc($res_summ))
		{
			$summ_5 = $result_summ['summ_5'];
			$summ_4 = $result_summ['summ_4'];
			$summ_3 = $result_summ['summ_3'];
			$jackpot = $result_summ['jackpot'];
		}

		$sql = "select * from lottery_log where id_lottery='".$id_lottery."' and id_user='".$id_user."' and send='0' ";
		$res = mysql_query($sql);
		while($result = mysql_fetch_assoc($res))
		{
			$count = $this->get_count($win_combination_str,$result['values']);

			if ($count == 5)
			{
				$this->pay_for_5($jackpot);
				echo "Билет <B>№ ".$result['id']."</B> выиграл <b>".$jackpot." Зл.</b> Выбраные номера: ".$result['values']."<BR>";
				$zz = 1;
			}
			if ($count == 4)
			{
				$this->pay_for_4($summ_4);
				echo "Билет <B>№ ".$result['id']."</B> выиграл <b>".$summ_4." Зл.</b> Выбраные номера: ".$result['values']."<BR>";
				$zz = 1;
			}
			if ($count == 3)
			{
				$this->pay_for_3($summ_3);
				echo "Билет <B>№ ".$result['id']."</B> выиграл <b>".$summ_3." Зл.</b> Выбраные номера: ".$result['values']."<BR>";
				$zz = 1;
			}

			$sql_upd = "update lottery_log set send='1' where id='".$result['id']."'";
			mysql_query($sql_upd);
		}
		if (!$zz) 		{			echo "<font color=red><B>Нет выигрышных билетов</b></font><BR>";		}
	}

	function view_results($id_lottery = 0){
		$str = '';
        if ($id_lottery > 0) {
			$sql = "select * from lottery where id='".$id_lottery."' and end=1;";
		}
		else {			$sql = "select * from lottery where end=1 order by id DESC LIMIT 1;";
		}
        $res = mysql_query($sql);

		while ($result = mysql_fetch_assoc($res)){
			$id_lottery = $result['id'];
			$date = $result['date'];
			$jackpot = $result['jackpot'];
			$fond = $result['fond'];
			$summ_5 = $result['summ_5'];
			$summ_4 = $result['summ_4'];
			$summ_3 = $result['summ_3'];
			$count_5 = $result['count_5'];
			$count_4 = $result['count_4'];
			$count_3 = $result['count_3'];
		}

		$summ = $summ_5 + $summ_4 + $summ_3;
		$count = $count_5 + $count_4 + $count_3;

		$sql_combination = "select * from lottery_win_combination where id_lottery='".$id_lottery."'";
		$res_combination = mysql_query($sql_combination);
		while($result_combination = mysql_fetch_assoc($res_combination)){
			$combination = $result_combination['values'];
		}

		$sql = "select * from lottery_log where id_lottery='".$id_lottery."'";
		$res = mysql_query($sql);
        $allbillets = mysql_num_rows($res);

		$str .= '<form method="post" style="margin:0px;"  action="main.php?act=none"><h4>Итоги тиража номер <input type="text" value="'.$id_lottery.'" size=4 name="tiraj"> <input type=submit value="посмотреть"></h4></form>';
		if (!$date) 
		{
        	 return $str.'Лотерея не проводилась.';
        }
		$str .= '
		<table width=100%>
			<tr>
				<td><b>Тираж номер:</b> '.$id_lottery.'</td><td><b>Дата:</b> '.$date.'</td>
			</tr>
			<tr>
				<td><b>Призовой фонд:</b> '.$fond.' Зл.</td><td><b>Джекпот:</b> '.$jackpot.' Зл.</td>
			</tr>
			<tr>
				<td><b>Продано билетов:</b> '.$allbillets.'</td><td><b>Выпали номера:</b> '.substr($combination,0,strlen($combination)-1).'</td>
			</tr>
		</table>
		<hr>
		<table border=0 cellpadding=1 cellspacing=0>
			<tr>
				<TD align=center nowrap>&nbsp;<B>Угадано №</B>&nbsp;</TD>
				<TD align=center nowrap>&nbsp;<B>Выигрышных билетов</B>&nbsp;</TD>
				<TD align=center nowrap>&nbsp;<B>Сумма выигрыша</B>&nbsp;</TD>
			</tr>
			<tr>
				<td align=center>5</td>
				<td align=center>'.$count_5.'</td>
				<td align=center>';
				if ($count_5 == 0)
				{
					$str .= 'Никто не выиграл. '.$summ_5.' Зл. идут в джекпот';
				}
				else
				{
					$str .= $summ_5.' Зл.';
				}

				$str .= '
				</td>
			</tr>
			<tr>
				<td align=center>4</td>
				<td align=center>'.$count_4.'</td>
				<td align=center>';

				if ($count_4 == 0)
				{
					$str .= 'Никто не выиграл. '.$summ_4.' Зл. идут в джекпот';
				}
				else
				{
					$str .= $summ_4.' Зл.';
				}

				$str .= '
						</td>
					</tr>
					<tr>
						<td align=center>3</td>
						<td align=center>'.$count_3.'</td>
						<td align=center>';

				if ($count_3 == 0)
				{
					$str .= 'Никто не выиграл. '.$summ_3.' Зл. идут в джекпот';
				}
				else{
					$str .= $summ_3.' Зл.';
				}

				$str .= '
						</td>
					</tr>
					<tr><td colspan=3><hr></td></tr>
					<tr><td colspan=3><table width=100%><tr><td width=50% align=center>Всего победителей: <b>'.$count.'</b> чел.</td><td align=center>Всего выиграно: <b>'.$summ.'</b> Зл.</td></tr></table></td></tr>
				</table>';
		return $str;
	}

	function view_buy_ticket()
	{
		$str = '';

		$str .= '
		<style>
		td.unselect{background-color: none; cursor: pointer; }
		td.select  {background-color:#111111; color:white;cursor: pointer;}
		</style>
		<script>
		function add(name)
		{
			var array = new Array();
			var test = document.getElementById(\'value\').value;

			if (test.indexOf(",") > 0)
			{
				array = test.split(",");

				//alert(array.lenght);

				if (array[5] != \'\')
				{
					document.getElementById(name).className=\'select\';
					document.getElementById(name).onclick = function() { del(name) };
					test = test + name + ",";
					document.getElementById(\'value\').value = test;
				}
			}
			else{
				document.getElementById(name).className=\'select\';
				document.getElementById(name).onclick = function() { del(name) };
				test = test + name + ",";
				document.getElementById(\'value\').value = test;
			}
		}
		function del(name)
		{
			var array = new Array();
			var test = document.getElementById(\'value\').value;

			document.getElementById(name).className=\'unselect\';
			document.getElementById(name).onclick = function() { add(name) };
			test = test.replace(name+",","");
			document.getElementById(\'value\').value = test;
		}
		</script>
			
		<table border=1 cellpadding=0 cellspacing=0 style="BORDER-COLLAPSE: collapse;cursor: hand" bordercolor=111111>
		<TR><TD colspan=10 align=center bgcolor=d2d2d2><b>Зачеркните 5 чисел</b></TD></TR>
		<TR>
		<SCRIPT>
		for (i=1;i<=30;i++) 
		{
			document.write("<TD width=20 align=center class=\"unselect\" id="+i+" onclick=\"add("+i+")\">&nbsp;"+i+"&nbsp;</TD>");
			if (i % 10 == 0) document.write("</TR><TR>")
		}
		</SCRIPT>
		</TR>
		</TABLE><BR>
		Выбраные Вами номера : <input style="border: 0px solid #000;color:green;font-weight: bold; background:transparent;" type="text" readonly="true" id="value" name="value" />';
		return $str;
	}
}

$Lottery = new Lottery();

if ($_POST['value']) {	echo $Lottery->buy_ticket($_POST['value']);}


$sql = "select * from lottery where end=0 order by id DESC LIMIT 1;";
$res = mysql_query($sql);
while ($result = mysql_fetch_assoc($res))
{
	$id_lottery = $result['id'];
	$date = $result['date'];
	$jackpot = $result['jackpot'];
	$fond = $result['fond'];
	$summ_5 = $result['summ_5'];
	$summ_4 = $result['summ_4'];
	$summ_3 = $result['summ_3'];
	$count_5 = $result['count_5'];
	$count_4 = $result['count_4'];
	$count_3 = $result['count_3'];
}
?>
<table width=700 cellspacing=0 cellpadding=0>
<tr>
<td>
	<table width="100%" class="l3">
		<tr class="l0">
		 	<td align="center">Следующий тираж <B>№ <?=$id_lottery?></B> состоится <b><?=$date?></b></td>
		</tr> 

		<tr class="l0">
			<td id="main_content" align="bottom">
			<table width=100%>
			<tr>
				<td>Стоимость лотерейного билета: <B>1.00 Зл.</B></td><td>Призовой фонд: <b><?=$fond?> Зл.</b></td>
			</tr>
			<tr>
				<td>У вас в наличии: <B><?=$money?> Зл.</B></td><td>Джекпот: <b><?=$jackpot?> Зл.</b></td>
			</tr>	
			</table>
			<div id="adde">
			<form method='post' style="margin:0px;" action='main.php?act=none'>
			<? echo $Lottery->view_buy_ticket(); ?>
			<BR><input type=submit value='Купить билет'>
			<input type="button" style='font-weight: bold;' value="Проверить лотерейные билеты" onclick="location.href='?check=1';">
			</form>
			</div>
			<hr>
			<?
			if($_GET['check']) {$Lottery->check($_POST['tiraj']);}
			echo $Lottery->view_results($_POST['tiraj']);
			?>
			</td>
		</tr>
	</table>
</td>
</tr>
</table>