<body style="background-image: url(img/index/lotto.jpg);background-repeat:no-repeat;background-position:top right">
<TABLE width=100% border=0>
<tr valign=top>
	<td width=100%><h3>������� ����� (5 �� 30)</h3></td>
	<td align=right nowrap>
		<input type=button onclick="location.href='main.php?act=go&level=remesl'" value="���������" class=new >
		<input type=button onclick="location.href='main.php?act=none'" value="��������" class=new >
    	<INPUT TYPE=button class="podskazka" value="���������" onclick="window.open('help/lotery.php','displayWindow','height=400,width=500,resizable=no,scrollbars=yes,menubar=no,status=no,toolbar=no,directories=no,location=no')"/>
	</td>
</tr>
</table>
<?
#if ($_SESSION["login"]!="bor")die("�������!");
$money = sprintf ("%01.2f", $db["money"]);
$user=$db;
class Lottery
{
	function get_this_user_id()
	{
		// ����������� id ������������
		global $user;
		return $user['id'];
	}

	function buy($txt = '')
	{
		// ������� ����� ������
		global $user;
		if ($user['money'] < 1) 		{			$this->mess = '�� ������� �����<BR>';		} 		else 		{			$this->mess = $txt.'<BR>';			mysql_query("update users set money = money - 1 where id = ".$user['id'].";");
			mysql_query("INSERT INTO inv(owner,object_id,object_type,object_razdel,msg,term) VALUES ('".$user['login']."','193','flower','flud','".$txt."','".(time()+3600*24*7)."')");
		}
	}

	function pay_for_5($summ)
	{
		// ������ ���� 5 �� 5 �������
		global $user;
        mysql_query("update users set money = money + '".$summ."' where id = ".$user['id'].";");
        history($user['login'],'����� ������� (5 �� 5 �������)',$summ." ��.",$user['remote_ip'],'������� �����');
	}

	function pay_for_4($summ)
	{
		// ������ ���� 4 �� 5 �������
		global $user;
        mysql_query("update users set money = money + '".$summ."' where id = ".$user['id'].";");
		history($user['login'],'����� ������� (4 �� 5 �������)',$summ." ��.",$user['remote_ip'],'������� �����');
	}

	function pay_for_3($summ){
		// ������ ���� 3 �� 5 �������
		global $user;
		mysql_query("update users set money = money + '".$summ."' where id = ".$user['id'].";");
		history($user['login'],'����� ������� (3 �� 5 �������)',$summ." ��.",$user['remote_ip'],'������� �����');
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

			$this->buy("����� � ".$id_lottery." ��������� $id_date. �������� ������: ".$values);
        	
        	$this->mess.= "<font color=red><B>����� ������. � ��� ������ �������� ���������� �����.<BR></font></b>";
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
				echo "����� <B>� ".$result['id']."</B> ������� <b>".$jackpot." ��.</b> �������� ������: ".$result['values']."<BR>";
				$zz = 1;
			}
			if ($count == 4)
			{
				$this->pay_for_4($summ_4);
				echo "����� <B>� ".$result['id']."</B> ������� <b>".$summ_4." ��.</b> �������� ������: ".$result['values']."<BR>";
				$zz = 1;
			}
			if ($count == 3)
			{
				$this->pay_for_3($summ_3);
				echo "����� <B>� ".$result['id']."</B> ������� <b>".$summ_3." ��.</b> �������� ������: ".$result['values']."<BR>";
				$zz = 1;
			}

			$sql_upd = "update lottery_log set send='1' where id='".$result['id']."'";
			mysql_query($sql_upd);
		}
		if (!$zz) 		{			echo "<font color=red><B>��� ���������� �������</b></font><BR>";		}
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

		$str .= '<form method="post" style="margin:0px;"  action="main.php?act=none"><h4>����� ������ ����� <input type="text" value="'.$id_lottery.'" size=4 name="tiraj"> <input type=submit value="����������"></h4></form>';
		if (!$date) 
		{
        	 return $str.'������� �� �����������.';
        }
		$str .= '
		<table width=100%>
			<tr>
				<td><b>����� �����:</b> '.$id_lottery.'</td><td><b>����:</b> '.$date.'</td>
			</tr>
			<tr>
				<td><b>�������� ����:</b> '.$fond.' ��.</td><td><b>�������:</b> '.$jackpot.' ��.</td>
			</tr>
			<tr>
				<td><b>������� �������:</b> '.$allbillets.'</td><td><b>������ ������:</b> '.substr($combination,0,strlen($combination)-1).'</td>
			</tr>
		</table>
		<hr>
		<table border=0 cellpadding=1 cellspacing=0>
			<tr>
				<TD align=center nowrap>&nbsp;<B>������� �</B>&nbsp;</TD>
				<TD align=center nowrap>&nbsp;<B>���������� �������</B>&nbsp;</TD>
				<TD align=center nowrap>&nbsp;<B>����� ��������</B>&nbsp;</TD>
			</tr>
			<tr>
				<td align=center>5</td>
				<td align=center>'.$count_5.'</td>
				<td align=center>';
				if ($count_5 == 0)
				{
					$str .= '����� �� �������. '.$summ_5.' ��. ���� � �������';
				}
				else
				{
					$str .= $summ_5.' ��.';
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
					$str .= '����� �� �������. '.$summ_4.' ��. ���� � �������';
				}
				else
				{
					$str .= $summ_4.' ��.';
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
					$str .= '����� �� �������. '.$summ_3.' ��. ���� � �������';
				}
				else{
					$str .= $summ_3.' ��.';
				}

				$str .= '
						</td>
					</tr>
					<tr><td colspan=3><hr></td></tr>
					<tr><td colspan=3><table width=100%><tr><td width=50% align=center>����� �����������: <b>'.$count.'</b> ���.</td><td align=center>����� ��������: <b>'.$summ.'</b> ��.</td></tr></table></td></tr>
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
		<TR><TD colspan=10 align=center bgcolor=d2d2d2><b>���������� 5 �����</b></TD></TR>
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
		�������� ���� ������ : <input style="border: 0px solid #000;color:green;font-weight: bold; background:transparent;" type="text" readonly="true" id="value" name="value" />';
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
		 	<td align="center">��������� ����� <B>� <?=$id_lottery?></B> ��������� <b><?=$date?></b></td>
		</tr> 

		<tr class="l0">
			<td id="main_content" align="bottom">
			<table width=100%>
			<tr>
				<td>��������� ����������� ������: <B>1.00 ��.</B></td><td>�������� ����: <b><?=$fond?> ��.</b></td>
			</tr>
			<tr>
				<td>� ��� � �������: <B><?=$money?> ��.</B></td><td>�������: <b><?=$jackpot?> ��.</b></td>
			</tr>	
			</table>
			<div id="adde">
			<form method='post' style="margin:0px;" action='main.php?act=none'>
			<? echo $Lottery->view_buy_ticket(); ?>
			<BR><input type=submit value='������ �����'>
			<input type="button" style='font-weight: bold;' value="��������� ���������� ������" onclick="location.href='?check=1';">
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