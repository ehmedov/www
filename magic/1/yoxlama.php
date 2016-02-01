<?
include_once ('time.php');
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes(trim($_POST['target'])));
if(!empty($target))
{
	$q=mysql_query("SELECT * FROM users LEFT JOIN info on info.id_pers=users.id WHERE users.login='".$target."' limit 1");
	$res=mysql_fetch_array($q);
	mysql_free_result($q);
	if(!$res)
	{
		echo "Персонаж <B>".$target."</B> не найден в базе данных.";
	}
	else if ($res['adminsite']>2 && $db["adminsite"]<2)
	{
		echo "Редактирование богов запрещено высшей силой!";
	}
	else
	{
		$res_on = mysql_fetch_array(mysql_query("SELECT * FROM online WHERE login='".$target."' limit 1"));
		echo "<table width=100% cellpadding=0 cellspacing=0>";
		echo "<tr><td valign=top align=center colspan=3><h3>Досье персонажа ".$res["login"]."</h3></td></tr>";
		echo "<tr><td valign=top>";
		$reg_ip=$res['reg_ip'];
		$last_ip=$res['last_ip'];
		$remote_ip=$res['remote_ip'];
		
		$local_ip=$res_on['ip'];
		$global_ip=	$res_on['remote_ip'];
		
		if ($reg_ip=='')$reg_ip='none';
		if ($last_ip=='')$last_ip='none';
		if ($remote_ip=='')$remote_ip='none';
		
		if ($local_ip=='')$on_ip='Персонаж сейчас Off-line';
		if ($global_ip=='')$remote_online='Персонаж сейчас Off-line';
		echo "<table width=500 class='l3' cellpadding=5 cellspacing=1><tr class='l1'><td>";
		echo "Регистрировался: <b style='color:#FF0000'>".$reg_ip."</b> <a href='seekregip.php?ip=".base64_encode($reg_ip)."' class=us2 target='_blank'>Посмотреть</a><BR><BR>";
		echo "Последний раз зашел c Local IP: <b style='color:#007000'>".$last_ip."</b> <a href='seekregip.php?last_ip=".base64_encode($last_ip)."' class=us2 target='_blank'>Посмотреть</a><BR>";
		echo "Последний раз зашел c Global IP: <b style='color:#007000'>".$remote_ip."</b> <a href='seekregip.php?remote_ip=".base64_encode($remote_ip)."' class=us2 target='_blank'>Посмотреть</a><BR><BR>";
		
		echo "OnLine Local IP: <b style='color:#007000'>".$local_ip."</b> <a href='seekregip.php?onlineip=".base64_encode($local_ip)."' class=us2 target='_blank'>Посмотреть</a><br>";
		echo "OnLine Global IP: <b style='color:#007000'>".$global_ip."</b> <a href='seekregip.php?onlineremote=".base64_encode($global_ip)."' class=us2 target='_blank'>Посмотреть</a><br><br>";
		echo "<b>Browser</b>: ".$res_on["browser"];
		echo "</TD></TR></TABLE>";
		
		echo "<br><table width=500 class='l3' cellpadding=5 cellspacing=1><tr class='l1'><td>";
		echo "Переводы персонажа: <a href='perevod.php?tar=$target' class=us2 target='_blank'>Посмотреть</a><br>";
		echo "Бои персонажа: <a href='archive.php?tar=$target' class=us2 target='_blank'>Посмотреть</a><br>";
		echo "Дом отдыха: <a href='lottery_log.php?tar=$target' class=us2 target='_blank'>Посмотреть</a><br><br>";

		echo "Дата рождения: <b>".$res['birth']."</b><BR><BR>";
		echo "Деньги: <b>".sprintf ("%01.2f", $res['money'])."</b> Зл.<BR>";	
		echo "Платина: <b>".sprintf ("%01.2f", $res['platina'])."</b> Пл.<BR>";
		echo "Награда: <b>".sprintf ("%01.2f", $res['naqrada'])."</b> Ед.<BR>";
		echo "Серебро: <b>".sprintf ("%01.2f", $res['silver'])."</b> Ср.<BR>";
		echo "Передач: <b>".(50-$res["peredacha"])."</b>";
		echo "</TD></TR></TABLE>";
		
		echo "<br><table width=500 class='l3' cellpadding=5 cellspacing=1><tr class='l1'><td>";
		echo "<b style='color:brown'>Банковский Счёт:</b><br>";
		$nomer = mysql_query("SELECT * FROM bank WHERE login='".$target."'");
		while ($num = mysql_fetch_array($nomer))
		{
			echo "<b>".$num['number']." - (".sprintf ("%01.2f", $num['money'])." Зл. - ".sprintf ("%01.2f", $num['emoney'])." Пл.</b>)<br>";
		}
		echo "</TD></TR></TABLE>";
		
		echo "<br><table width=500 class='l3' cellpadding=5 cellspacing=1><tr class='l1'><td>";
		echo "<b style='color:brown'>Последния причина заключения: </b>".($res["prision_reason"]?$res["prision_reason"]:"<i style='color:grey'>нету</i>");
		echo "<br><br><b style='color:brown'>Последния причина блока: </b>".($res["blok_reason"]?$res["blok_reason"]:"<i style='color:grey'>нету</i>");
		echo "<br><br><b style='color:brown'>Последния причина изгнания из ордена: </b>".($res["orden_reason"]?$res["orden_reason"]:"<i style='color:grey'>нету</i>");
		
		echo "</TD></TR></TABLE>";
			
		echo "<br><table width=500 class='l3' cellpadding=5 cellspacing=1><tr class='l1'><td>";
		echo "<b style='color:brown'>Отчет системы безопасности:</b><br>";
		$lv=mysql_query("SELECT * FROM report WHERE login='".$res["login"]."' and type='1' ORDER BY time_stamp DESC LIMIT 5");
		while ($lastvisit=mysql_fetch_array($lv))
		{
			echo $lastvisit['time_stamp']." <b>".$lastvisit['action']."</b> ".$lastvisit['ip'].'<br>';
		}	
		echo "</TD></TR></TABLE>";
		echo "</td><td width=5 nowrap><span></span></td><td valign=top nowrap width=500>";
		if ($db['adminsite'])
		{
			effects($res["id"],$effect);
			echo "<table width=500 class='l3' cellpadding=5 cellspacing=1><tr class='l1'><td>";
			echo "Снаряжение: <a href='geyim.php?user=".$res['login']."' class=us2 target='_blank'>Посмотреть</a><br>";
			echo "E-mail: <b>".$res['email']."</b><BR>";
			echo "Admin level: <b style='color:red'>".$res['admin_level']."</b><br>";
			echo "Admin Site: <b style='color:red'>".$res['adminsite']."</b><br>";
			echo "ID: <b style='color:red'>".$res['id']."</b>";
			echo "</TD></TR></TABLE>";
			
			echo "<br><table width=500 class='l3' cellpadding=5 cellspacing=1><tr class='l1'><td>";
			echo "Опыт: <b>".$res['exp']."</b><BR>";
			echo "Повышение: <b>".$res['next_up']."</b><BR>";
			echo "<font color=green>Свободных увеличений: <b>".$res['ups']."</b> [".$res['add_ups']."]<BR>";
			echo "Свободные умения: <b>".$res['umenie']."</b> [".$res['add_umenie']."]</font>";
			echo "</TD></TR></TABLE>";
			
			echo "<br><table width=500 class='l3' cellpadding=5 cellspacing=1><tr class='l1'><td>";
			echo "<b style='color:brown'>Doyuw sisteminin Deyiwenleri:</b><BR>";
			echo "creator: <b>".$res['battle_pos']."</b><BR>";
			echo "bid: <b>".$res['battle']."</b><BR>";
			echo "zayavka: <b>".$res['zayavka']."</b><BR>";
			echo "team: <b>".$res['battle_team']."</b><hr>";
			$k=mysql_fetch_array(mysql_query("SELECT * FROM teams WHERE player='".$res['login']."'"));
			echo "team: <b>".(int)$k['team']."</b><BR>";
			echo "battle_id: <b>".(int)$k['battle_id']."</b><hr>";
			echo "Zayava: <b>".(int)$res['zayava']."</b><hr>";
			echo "</TD></TR></TABLE>";
			
			echo "<br><table width=500 class='l3' cellpadding=5 cellspacing=1><tr class='l1'><td>";
			echo "<b style='color:brown'>Состояние:</b><br>";
			$s=mysql_query("SELECT * FROM effects LEFT JOIN scroll on scroll.id=effects.elik_id WHERE  effects.user_id=".$res["id"]);
			while ($sc=mysql_fetch_array($s))
			{
				$kkk++;
				echo "<img src='img/".$sc["img"]."' border=0 alt='".$sc["name"]."\n".$sc["descs"]."\n"."Еще ".convert_time($sc['end_time'])."'>&nbsp;";
				if(($kkk % 6) == 0) echo "<br>";
			}
			echo "</TD></TR></TABLE>";
			
			echo "<br><table width=500 class='l3' cellpadding=5 cellspacing=1><tr class='l1'><td>";
			echo "<b style='color:brown'>Уровень брони:</b><br>";
			echo "&nbsp;• Броня головы: <b>".ceil($res["bron_head"])."</b><br>
			&nbsp;• Броня корпуса: <b>	".ceil($res["bron_corp"])."</b><br>
			&nbsp;• Броня пояса: <b>	".ceil($res["bron_poyas"])."</b><br>
			&nbsp;• Броня ног: <b>		".ceil($res["bron_legs"])."</b><br><br>
			
			&nbsp;• Защита от режущего урона: <b>".ceil($res["protect_rej"]+$effect["p_rej"])."</b><br>
			&nbsp;• Защита от дробящего урона:<b>".ceil($res["protect_drob"]+$effect["p_drob"])."</b><br>
			&nbsp;• Защита от колющего урона: <b>".ceil($res["protect_kol"]+$effect["p_kol"])."</b><br>
			&nbsp;• Защита от рубящего урона: <b>".ceil($res["protect_rub"]+$effect["p_rub"])."</b><br><br>
		
			&nbsp;• Защита от урона: <b>".ceil($res["protect_udar"]+$effect["add_bron"]+$res["power"]*1.5)."</b><br>
			&nbsp;• Защита от магии: <b>".ceil($res["protect_mag"]+$effect["add_mg_bron"]+$res["power"]*1.5)."</b><br><br>
			
			&nbsp;• Понижение защиты от магии Огня: 	<b>".ceil($res["protect_fire"]+$effect["protect_fire"])."</b><br>
			&nbsp;• Понижение защиты от магии Воды: 	<b>".ceil($res["protect_water"]+$effect["protect_water"])."</b><br>
			&nbsp;• Понижение защиты от магии Воздуха: 	<b>".ceil($res["protect_air"]+$effect["protect_air"])."</b><br>
			&nbsp;• Понижение защиты от магии Земли: 	<b>".ceil($res["protect_earth"]+$effect["protect_earth"])."</b><br>
			&nbsp;• Понижение защиты от магии Света: 	<b>".ceil($res["protect_svet"]+$effect["protect_svet"])."</b><br>
			&nbsp;• Понижение защиты от магии Тьмы: 	<b>".ceil($res["protect_tma"]+$effect["protect_tma"])."</b><br>
			&nbsp;• Понижение защиты от Серой магии: 	<b>".ceil($res["protect_gray"]+$effect["protect_gray"])."</b><br><br>
				
			&nbsp;• Мф.блока щитом: <b>".ceil($res["shieldblock"])."</b><br><br>
	
			</td></tr></table>";
			echo "<br><table width=500 class='l3' cellpadding=5 cellspacing=1><tr class='l1'>
			<td valign=top>";
			
			$k1=mysql_fetch_array(mysql_query("SELECT is_modified, add_rej, add_drob, add_kol, add_rub FROM `inv` WHERE id=".$res["hand_r"]));
			$k2=mysql_fetch_array(mysql_query("SELECT is_modified, add_rej, add_drob, add_kol, add_rub FROM `inv` WHERE id=".$res["hand_l"]));

			$mf_rub1= $k1["add_rub"];
			$mf_kol1= $k1["add_kol"];
			$mf_drob1=$k1["add_drob"];
			$mf_rej1= $k1["add_rej"];

			$mf_rub2= $k2["add_rub"];
			$mf_kol2= $k2["add_kol"];
			$mf_drob2=$k2["add_drob"];
			$mf_rej2= $k2["add_rej"];

			$is_modified1=$k1['is_modified1'];
			$is_modified2=$k2['is_modified2'];


			
			$krit=$res["krit"]+5*($res["udacha"]+$effect["add_udacha"])+$effect["add_krit"]; 
			$antikrit=$res["akrit"]+5*($res["udacha"]+$effect["add_udacha"])+$effect["add_akrit"]; 
			$uvorot=$res["uvorot"]+5*($res["lovkost"]+$effect["add_lovkost"])+$effect["add_uvorot"];
			$antiuvorot=$res["auvorot"]+5*($res["lovkost"]+$effect["add_lovkost"])+$effect["add_auvorot"];
			$res["sila"]=$res["sila"]+$effect["add_sila"];
			
			$udar_min1=$res["hand_r_hitmin"]+($res["sila"]+ceil($res["sila"]*0.4))+(int)(0+$is_modified1);
			$udar_max1=$res["hand_r_hitmax"]+($res["sila"]+ceil($res["sila"]*0.8))+(int)(0+$is_modified1);
			$udar_min2=$res["hand_l_hitmin"]+($res["sila"]+ceil($res["sila"]*0.4))+(int)(0+$is_modified2);
			$udar_max2=$res["hand_l_hitmax"]+($res["sila"]+ceil($res["sila"]*0.8))+(int)(0+$is_modified2); 			
					

			echo "<b style='color:brown'>Модификаторы</b><br>";?>
			&nbsp;• Урон: <b><?echo "$udar_min1-$udar_max1".(($res["hand_l_type"]!="phisic" && $res["hand_l_type"]!="shield")?" / $udar_min2-$udar_max2":"");?></b><br>
			&nbsp;• Мф. крит. удара: <b><?echo $krit;?></b><br>
			&nbsp;• Мф. против крит. удара: <b><?echo $antikrit;?></b><br>
			&nbsp;• Мф. увертывания: <b><?echo $uvorot;?></b><br>
			&nbsp;• Мф. против увертывания: <b><?echo $antiuvorot;?></b><br>
			&nbsp;• Мф. парирования: <b><?echo ($res["parry"]+5);?></b><br>
			&nbsp;• Мф. контрудара: <b><?echo ($res["counter"]+10) ;?></b><br>
			&nbsp;• Мф. пробоя брони: <b><?echo ($res["proboy"]+5) ;?></b><br><br>

			&nbsp;• Мф. мощности урона: <b><?echo (int)($res["ms_udar"]+$effect["add_ms_boyech"]);?></b><br>
			&nbsp;• Мф. мощности критического удара: <b><?echo (int)$res["ms_krit"];?></b><br><br>
					
			&nbsp;• Мф. мощности рубящго урона: <b><?echo (int)$res["ms_rub"];?></b><br>
			&nbsp;• Мф. мощности колющего урона: <b><?echo (int)$res["ms_kol"];?></b><br>
			&nbsp;• Мф. мощности дробящего урона: <b><?echo (int)$res["ms_drob"];?></b><br>
			&nbsp;• Мф. мощности режущего урона: <b><?echo (int)$res["ms_rej"];?></b><br><br>
			
			&nbsp;• Мф. рубящго урона: <b><?echo (int)$mf_rub1;?></b>-<b><?echo (int)$mf_rub2;?></b><br>
			&nbsp;• Мф. колющего урона: <b><?echo (int)$mf_kol1;?></b>-<b><?echo (int)$mf_kol2;?></b><br>
			&nbsp;• Мф. дробящего урона: <b><?echo (int)$mf_drob1;?></b>-<b><?echo (int)$mf_drob2;?></b><br>
			&nbsp;• Мф. режущего урона: <b><?echo (int)$mf_rej1;?></b>-<b><?echo (int)$mf_rej2;?></b><br><br>
			<?
				if (($res['intellekt']+$effect["add_intellekt"])>=125) 	    $add_ms_mag=25;
				else if (($res['intellekt']+$effect["add_intellekt"])>=100) 	$add_ms_mag=20;
				else if (($res['intellekt']+$effect["add_intellekt"])>=75) 	$add_ms_mag=15;
				else if (($res['intellekt']+$effect["add_intellekt"])>=50) 	$add_ms_mag=10;
				else if (($res['intellekt']+$effect["add_intellekt"])>=25)	$add_ms_mag=5;
				$add_ms_mag=$add_ms_mag+($res['intellekt']+$effect["add_intellekt"])*0.5
			?>
			&nbsp;• Мф. мощности магии: <b><?echo (int)($res["ms_mag"]+$add_ms_mag);?></b><br>
			&nbsp;• Мф. мощности магии Огня: <b><?echo (int)($res["ms_fire"]+$add_ms_mag);?></b><br>
			&nbsp;• Мф. мощности магии Воды: <b><?echo (int)($res["ms_water"]+$add_ms_mag);?></b><br>
			&nbsp;• Мф. мощности магии Воздуха: <b><?echo (int)($res["ms_air"]+$add_ms_mag);?></b><br>
			&nbsp;• Мф. мощности магии Земли: <b><?echo (int)($res["ms_earth"]+$add_ms_mag);?></b><br>
			&nbsp;• Мф. мощности магии Света: <b><?echo (int)($res["ms_svet"]+$add_ms_mag);?></b><br>
			&nbsp;• Мф. мощности магии Тьмы: <b><?echo (int)($res["ms_tma"]+$add_ms_mag);?></b><br>
			&nbsp;• Мф. мощности Серой магии: <b><?echo (int)($res["ms_gray"]+$add_ms_mag);?></b><br><br>
			<?
			echo "</td></tr></table>";
			echo "<br><table width=500 class='l3' cellpadding=5 cellspacing=1><tr class='l1'><td>";
			?>
			<b style='color:brown'>Оружие:</b><BR>
			&nbsp;• Мастерство владения мечами: <b>              	<?echo ($res["sword_vl"]+$effect["add_sword_vl"]+$res["add_oruj"]);?></b><br>
			&nbsp;• Мастерство владения ножами, кастетами: <b>	<?echo ($res["castet_vl"]+$effect["add_castet_vl"]+$res["add_oruj"]);?></b><br>
			&nbsp;• Мастерство владения топорами, секирами: <b>	<?echo ($res["axe_vl"]+$effect["add_axe_vl"]+$res["add_oruj"]);	?></b><br>
			&nbsp;• Мастерство владения дубинами, булавами: <b>	<?echo ($res["hummer_vl"]+$effect["add_hummer_vl"]+$res["add_oruj"]);?></b><br>
			&nbsp;• Мастерство владения древковоми оружиями: <b>	<?echo ($res["copie_vl"]+$effect["add_copie_vl"]+$res["add_oruj"]);?></b><br>
			&nbsp;• Мастерство владение посохами: <b>		<?echo ($res["staff_vl"]+$effect["add_staff_vl"]);?></b><br><br>
			<br><b style='color:brown'>Магия:</b><BR>
			&nbsp;• Мастерство владения стихией Огня: <b>		<?echo ($res["fire_magic"]+$effect["add_fire_magic"]);?></b><br>
			&nbsp;• Мастерство владения стихией Земли: <b>		<?echo ($res["earth_magic"]+$effect["add_earth_magic"]);?></b><br>
			&nbsp;• Мастерство владения стихией Воды: <b>		<?echo ($res["water_magic"]+$effect["add_water_magic"]);?></b><br>
			&nbsp;• Мастерство владения стихией Воздуха: <b>	<?echo ($res["air_magic"]+$effect["add_air_magic"]);?></b><br>
			&nbsp;• Мастерство владения стихией Света: <b>		<?echo ($res["svet_magic"]+$effect["add_svet_magic"]);?></b><br>
			&nbsp;• Мастерство владения стихией Тьмы: <b>		<?echo ($res["tma_magic"]+$effect["add_tma_magic"]);?></b><br>
			&nbsp;• Мастерство владения Серой магии: <b>		<?echo ($res["gray_magic"]+$effect["add_gray_magic"]);?></b><br>
			<?
			echo "</td></tr></table>";
		}
		echo "</td></tr></table>";
	}
}
?>
