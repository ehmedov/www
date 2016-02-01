<?
include "conf.php";
$data = mysql_connect($base_name, $base_user, $base_pass);
mysql_select_db($db_name,$data);


function get_result()
{
	$array = range(1,30);
	shuffle($array);

	for($i=0;$i<5;$i++){
		$result[] = $array[$i];
	}

	return $result;
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

function get_win_combination()
{
	$chat_base="/srv/www/meydan.az/public_html/chat/lovechat";
	#$chat_base="C:\\AppServ\www\ever\chat\lovechat";
	
	$win_combination = get_result();

	for($i=0;$i<5;$i++)
	{
		$win_combination_str .= $win_combination[$i].',';
	}


	$sql = "select id,jackpot,fond from lottery where end='0'";
	$res = mysql_query($sql);
	while($result = mysql_fetch_assoc($res))
	{
		$id_lottery = $result['id'];
		$jackpot = $result['jackpot'];
		$fond = $result['fond'];
	}

	$sql = "insert into lottery_win_combination(`values`,`date`,`id_lottery`) values('".$win_combination_str."','".date('Y-m-d H:i:s')."','".$id_lottery."') ";
	mysql_query($sql);

	$people_5 = 0;
	$people_4 = 0;
	$people_3 = 0;

	$sql = "select * from lottery_log where id_lottery='".$id_lottery."' ";
	$res = mysql_query($sql);
	while($result = mysql_fetch_assoc($res))
	{
		$count = get_count($win_combination_str,$result['values']);

		if ($count == 5)
		{
			$people_5 ++;
		}
		if ($count == 4)
		{
			$people_4 ++;
		}
		if ($count == 3)
		{
			$people_3 ++;
		}
	}

	if ($people_5 > 0 )
	{
		$summ_5 = ($jackpot+($fond*0.3))/$people_5;
		$jackpot = 0;
	}
	else
	{
		$summ_5 = ($fond*0.3);
		$jackpot += $fond*0.3;
	}
	if ($people_4 > 0)
	{
		$summ_4 = ($fond*0.3)/$people_4;
	}
	else
	{
		$summ_4 = ($fond*0.3);
		$jackpot += $fond*0.3;
	}
	if ($people_3 > 0)
	{
		$summ_3 = ($fond*0.4)/$people_3;
	} 
	else
	{
		$summ_3 = $fond*0.4;
		$jackpot += $fond*0.4;
	}

	$fond=round($fond, 2);
	$summ_5=round($summ_5, 2);
	$summ_4=round($summ_4, 2);
	$summ_3=round($summ_3, 2);
	$jackpot=round($jackpot, 2);
	
	
	$sql_upd = "update lottery set end='1' , fond='".$fond."' , summ_5='".$summ_5."' , summ_4='".$summ_4."' , summ_3='".$summ_3."' , count_5='".$people_5."' , count_4='".$people_4."' , count_3='".$people_3."' where id='".$id_lottery."'";
	mysql_query($sql_upd);

	$sql_ins = "insert into lottery(`date`,`jackpot`,`fond`,`end`,`summ_5`,`summ_4`,`summ_3`,`count_5`,`count_4`,`count_3`) values('".date('Y-m-d H:i:s',strtotime("+1 week"))."','".$jackpot."','0','0','0','0','0','0','0','0')";
	mysql_query($sql_ins);

	$mess = "Лотерея Хаоса началась! Проверьте ваши лотореи. Выпали номера: ".$win_combination_str;
	$mess = "sys<b style=background-color:#CCD1FF>$mess</b>endSys";
	$fopen_chat = fopen($chat_base,"a");
	fwrite ($fopen_chat,"::".time()."::sys_news::#FF0000::$mess::room4::mountown::\n");
	fclose ($fopen_chat);
}

get_win_combination();
echo "Lotto iwledi...";

?>