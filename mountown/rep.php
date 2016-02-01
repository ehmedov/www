<?
include("key.php");
$login=$_SESSION['login'];
$ip=$db["remote_ip"];
$room=(int)$_GET['room'];
//-------------------------------------------------------------
$price_edit[1]=500;
$price_edit[2]=1000;
$price_edit[3]=1500;
$price_edit[4]=1500;
$price_edit[5]=1500;
$price_edit[6]=10000000;
//---------------------Podqonka----------------------------------
/*
if ($_GET["podqonka1"])
{	
	switch ($_GET["type"])
	{
		case 1:$pay=100;$add_xp=1000;break;
		case 2:$pay=250;$add_xp=2000;break;
		default:$pay=100;$add_xp=1000;break;
	}
	$podqonka=(int)$_GET["podqonka"];
	$is_edited=mysql_fetch_array(mysql_query("SELECT inv.edited,paltar.name,inv.add_xp FROM inv LEFT JOIN paltar on paltar.id=inv.object_id WHERE owner='".$login."' AND wear='0' and inv.id=".$podqonka." and inv.object_type in ('armour','rubaxa','plash','boots','perchi','mask','poyas','helmet','naruchi','amulet','ring','pants')"));
	if (!$is_edited)
	{	
		$mess="У вас в рюкзаке нет брони!";
	}
	else if ($is_edited["add_xp"]>=$add_xp)
	{
		$mess="Броня уже Подогнан";
	}
	else
	{
		if ($db["platina"]<$pay)
		{
			$mess="У вас нет такой суммы!";
		}
		else
		{
			mysql_query("UPDATE inv SET add_xp=".$add_xp." WHERE id=".$podqonka);
			mysql_query("UPDATE users SET platina=platina-$pay WHERE login='".$login."'");
			$db["platina"]=$db["platina"]-$pay;
			$mess="Удачно Подогнан &quot".$is_edited["name"]."&quot на +".$add_xp." HP за ".$pay." Пл.!";
			history($login,'Подгонка брони',$mess,$ip,'Ремонтная мастерская');
		}
	}
}
*/
//---------------------UPGRATE ITEMS----------------------------------
if ($_GET["upgradeItem"])
{	
	$upgradeItem=(int)$_GET["upgradeItem"];
	
	$data=mysql_fetch_array(mysql_query("SELECT * FROM inv WHERE id=$upgradeItem and owner='".$login."' AND wear='0' and edited>0 and min_level<10"));
	if (!$data)
	{	
		$mess="У вас в рюкзаке нет Оружий, которые можно усилить!";
	}
	else 
	{
		$buy_item=mysql_fetch_array(mysql_query("SELECT * FROM paltar WHERE edited=".$data["edited"]." and min_level=".($data["min_level"]+1)));
		if ($buy_item)
		{	
			$is_modified=$data["is_modified"];
			$pay=$buy_item["price"]*0.1;
			if ($db["platina"]<$pay)
			{
				$mess="У вас нет такой суммы! [".$pay." Пл.]";
			}
			else
			{
				if ($data["runas"]!="")
				{
					$rname=explode("#",$data["runas"]);
					$is_runa=mysql_fetch_array(mysql_query("SELECT * FROM runa WHERE type='".$rname[0]."' and step=".$rname[1]));
					mysql_query("INSERT INTO `inv` (`owner`, `object_id`, `object_type`, `object_razdel`,  `iznos_max`) VALUES('".$login."', '".$is_runa["id"]."','runa','runa','1');");
				}

				mysql_query("LOCK TABLES inv WRITE");
				mysql_query("INSERT INTO `inv` (`id`, `owner`, `img`, `object_id`, `object_type`, `object_razdel`, `is_modified`, `name`,  `mass`, `price`, `gos_price`, `min_sila`, `min_lovkost`, `min_udacha`, `min_power`, `min_intellekt`, `min_vospriyatie`, `min_level`, `min_sword_vl`, `min_staff_vl`, `min_axe_vl`, `min_fail_vl`, `min_knife_vl`, `min_spear_vl`,`min_fire`,`min_water`,`min_air`,`min_earth`,`min_svet`,`min_tma`,`min_gray`,`add_fire`, `add_water`, `add_air`, `add_earth`, `add_svet`, `add_tma`, `add_gray`, `add_sila`, `add_lovkost`, `add_udacha`, `add_intellekt`, `add_duxovnost`, `add_hp`, `add_mana`, `protect_head`, `protect_arm`, `protect_corp`, `protect_poyas`, `protect_legs`, `protect_rej`, `protect_drob`, `protect_kol`, `protect_rub`, `protect_fire`, `protect_water`, `protect_air`, `protect_earth`, `protect_svet`, `protect_tma`, `protect_gray`,`protect_mag`,`protect_udar`, `shieldblock`, `krit`, `akrit`, `uvorot`, `auvorot`, `parry`, `counter`, `add_rej`, `add_drob`, `add_kol`, `add_rub`, `ms_udar`, `ms_krit`, `ms_mag`, `ms_fire`, `ms_water`, `ms_air`, `ms_earth`, `ms_svet`, `ms_tma`, `ms_gray`, `ms_rej`, `ms_drob`, `ms_kol`, `ms_rub`, `iznos_max`, `min_attack`, `max_attack`, `proboy`, `add_oruj`, `add_sword_vl`, `add_staff_vl`, `add_axe_vl`, `add_fail_vl`, `add_knife_vl`, `add_spear_vl`, `need_orden`, `sex`, `art`, `podzemka`, `is_personal`, `personal_owner`, `noremont`, `two_hand`, `second_hand`,  `add_fire_att`, `add_air_att`, `add_watet_att`, `add_earth_att`, `edited`) 
					VALUES (NULL, '".$login."','".$buy_item["img"]."' ,'".$buy_item["id"]."', '".$buy_item["object"]."', 'obj', '".$is_modified."', '".$buy_item["name"]."', '".$buy_item["mass"]."', '".($data["price"]+$pay)."', '".$buy_item["price"]."', '".$buy_item["min_sila"]."', '".$buy_item["min_lovkost"]."', '".$buy_item["min_udacha"]."', '".$buy_item["min_power"]."', '".$buy_item["min_intellekt"]."', '".$buy_item["min_vospriyatie"]."', '".$buy_item["min_level"]."', '".$buy_item["min_sword_vl"]."', '".$buy_item["min_staff_vl"]."', '".$buy_item["min_axe_vl"]."', '".$buy_item["min_fail_vl"]."', '".$buy_item["min_knife_vl"]."', '".$buy_item["min_spear_vl"]."', '".$buy_item["min_fire"]."','".$buy_item["min_water"]."','".$buy_item["min_air"]."','".$buy_item["min_earth"]."','".$buy_item["min_svet"]."','".$buy_item["min_tma"]."','".$buy_item["min_gray"]."', '".$buy_item["add_fire"]."', '".$buy_item["add_water"]."', '".$buy_item["add_air"]."', '".$buy_item["add_earth"]."', '".$buy_item["add_svet"]."', '".$buy_item["add_tma"]."', '".$buy_item["add_gray"]."', '".$buy_item["add_sila"]."', '".$buy_item["add_lovkost"]."', '".$buy_item["add_udacha"]."', '".$buy_item["add_intellekt"]."', '".$buy_item["add_duxovnost"]."', '".$buy_item["add_hp"]."', '".$buy_item["add_mana"]."', '".$buy_item["protect_head"]."', '".$buy_item["protect_arm"]."', '".$buy_item["protect_corp"]."', '".$buy_item["protect_poyas"]."', '".$buy_item["protect_legs"]."', '".$buy_item["protect_rej"]."', '".$buy_item["protect_drob"]."', '".$buy_item["protect_kol"]."', '".$buy_item["protect_rub"]."', '".$buy_item["protect_fire"]."', '".$buy_item["protect_water"]."', '".$buy_item["protect_air"]."', '".$buy_item["protect_earth"]."', '".$buy_item["protect_svet"]."', '".$buy_item["protect_tma"]."', '".$buy_item["protect_gray"]."', '".$buy_item["protect_mag"]."', '".$buy_item["protect_udar"]."','".$buy_item["shieldblock"]."','".$buy_item["krit"]."', '".$buy_item["akrit"]."', '".$buy_item["uvorot"]."', '".$buy_item["auvorot"]."', '".$buy_item["parry"]."', '".$buy_item["counter"]."', '".$buy_item["add_rej"]."', '".$buy_item["add_drob"]."', '".$buy_item["add_kol"]."', '".$buy_item["add_rub"]."', '".$buy_item["ms_udar"]."', '".$buy_item["ms_krit"]."', '".$buy_item["ms_mag"]."', '".$buy_item["ms_fire"]."', '".$buy_item["ms_water"]."', '".$buy_item["ms_air"]."', '".$buy_item["ms_earth"]."', '".$buy_item["ms_svet"]."', '".$buy_item["ms_tma"]."', '".$buy_item["ms_gray"]."', '".$buy_item["ms_rej"]."', '".$buy_item["ms_drob"]."', '".$buy_item["ms_kol"]."', '".$buy_item["ms_rub"]."', '".$buy_item["iznos_max"]."', '".$buy_item["min_attack"]."', '".$buy_item["max_attack"]."', '".$buy_item["proboy"]."','".$buy_item["add_oruj"]."' ,'".$buy_item["add_sword_vl"]."', '".$buy_item["add_staff_vl"]."', '".$buy_item["add_axe_vl"]."', '".$buy_item["add_fail_vl"]."', '".$buy_item["add_knife_vl"]."', '".$buy_item["add_spear_vl"]."', '".$buy_item["need_orden"]."', '".$buy_item["sex"]."', '".$buy_item["art"]."', '".$buy_item["podzemka"]."', '".$buy_item["is_personal"]."', '".$buy_item["personal_owner"]."', '".$buy_item["noremont"]."', '".$buy_item["two_hand"]."', '".$buy_item["second_hand"]."',  '".$buy_item["add_fire_att"]."', '".$buy_item["add_air_att"]."', '".$buy_item["add_watet_att"]."', '".$buy_item["add_earth_att"]."', '".$buy_item["edited"]."');");
				mysql_query("UNLOCK TABLES");
				mysql_query("DELETE FROM inv WHERE id=".$data["id"]);
				mysql_query("UPDATE users SET platina=platina-$pay WHERE login='".$login."'");
				$db["platina"]=$db["platina"]-$pay;
				$mess="Вы удачно усилили &quot".$data["name"]."&quot на &quot".$buy_item["name"]."&quot за ".$pay." Пл.!";
				history($login,'Усиление Именных Оружий',$mess,$ip,'Ремонтная мастерская');
			}
		}
		else 
		{
			$mess="Невозможно улучшить!";
		}
	}
}
//---------------------Runa----------------------------------
if ($_GET["runa"])
{	
	$runa_id=(int)$_GET["runa"];	
	$is_edited=mysql_fetch_array(mysql_query("SELECT runas FROM inv WHERE owner='".$login."' AND wear='0' and runas!='' and id=".$runa_id));
	if (!$is_edited)
	{	
		$mess="Это оружие не было найдено в вашем инвентаре!";
	}
	else
	{
		$rname=explode("#",$is_edited["runas"]);
		switch ($rname[1])
		{
			case 1:$runa_summa=30;break;
			case 2:$runa_summa=200;break;
			case 3:$runa_summa=500;break;
		}
		if ($db["platina"]<$runa_summa)
		{
			$mess="У вас нет такой суммы!";
		}
		else
		{
			$is_runa=mysql_fetch_array(mysql_query("SELECT * FROM runa WHERE type='".$rname[0]."' and step=".$rname[1]));
			mysql_query("UPDATE inv SET add_sila=add_sila-".$is_runa["add_sila"].", 
						add_lovkost=add_lovkost-".$is_runa["add_lovkost"].",
						add_udacha=add_udacha-".$is_runa["add_udacha"].",
						add_intellekt=add_intellekt-".$is_runa["add_intellekt"].",
						add_hp=add_hp-".$is_runa["add_hp"].", add_mana=add_mana-".$is_runa["add_mana"].",
						protect_mag=protect_mag-".$is_runa["protect_mag"].",protect_udar=protect_udar-".$is_runa["protect_udar"].",
						krit=krit-".$is_runa["add_krit"].", akrit=akrit-".$is_runa["add_akrit"].",uvorot=uvorot-".$is_runa["add_uvorot"].",auvorot=auvorot-".$is_runa["add_auvorot"].",						
						ms_udar=ms_udar-".$is_runa["ms_udar"].",ms_krit=ms_krit-".$is_runa["ms_krit"].",ms_mag=ms_mag-".$is_runa["ms_mag"].",						
						counter=counter-".$is_runa["counter"].", parry=parry-".$is_runa["parry"].",
						runas='' WHERE id=".$runa_id);
			
			mysql_query("INSERT INTO `inv` (`owner`, `object_id`, `object_type`, `object_razdel` ,`iznos`,  `iznos_max`) 
			VALUES('".$login."', '".$is_runa["id"]."','runa','runa','0','1');");

			mysql_query("UPDATE users SET platina=platina-$runa_summa WHERE login='".$login."'");
			$db["platina"]=$db["platina"]-$runa_summa;
			$mess="Вы удачно сняли руны {".$is_runa["name"]."} из оружия за ".$runa_summa." Пл.!";
			history($login,'Сняли Руны',$mess."[".$is_edited["runas"]."]",$ip,'Ремонтная мастерская');
		}
	}
}
//---------------------Repair----------------------------------
if($_GET['rep']=="repair")
{
	$t=$_GET['t'];
	$item_id=(int)$_GET['item_id'];
    $qq=mysql_query("SELECT * FROM inv WHERE id='".$item_id."' AND owner='".$login."' and inv.iznos>0");
	$result=mysql_fetch_array($qq);
	if ($result)
	{
		$iznos=$result["iznos"];
		$iznos_max=$result["iznos_max"];
		$noremont=$result["noremont"];	
		$name=$result["name"];	
		if($t == 1) $price1 = 0.1; else $price1=$iznos*0.1;
		$price = sprintf ("%01.2f", $price1);
		if ($noremont)
		{
			$mess="Предмет не подлежит ремонту";
		}
		else
		{
			if ($db["money"]>=$price1)
			{
				if ($iznos_max)
				{
					$rnd=($t?10:4);
					if ($iznos<$iznos_max && rand(1,$rnd)==1) { $s=", inv.iznos_max=inv.iznos_max-1"; $s1="<br>К сожалению, максимальная долговечность предмета из-за ремонта уменьшилась. ";}
					if($t == 0)
					{
						mysql_query("UPDATE users,inv SET inv.iznos='0',users.money=users.money-$price $s WHERE inv.id='".$item_id."' and users.login='".$login."'");
					}
					else if($t == 1)
					{
						mysql_query("UPDATE users,inv SET inv.iznos=inv.iznos-1,users.money=users.money-0.1 $s WHERE inv.id='".$item_id."' and users.login='".$login."'");
						$price = "0.1";
					}
					$mess="Вы удачно починили &quot".$name."&quot за ".$price." зл.! $s1";
					$db["money"]=$db["money"]-$price;
		        }
				else
				{
					$mess="Ошибка.";
				}
			}
			else
			{
				$mess="У вас нет такой суммы!";
			}
	    }
	}
	else $mess="Предмет не найден в рюкзаке...";
}
//-----------------------Grave----------------------------------------------------------------------
if($_GET['rep']=="grave")
{
	$grav_text=$_POST["grave_text"];
	$item_id=(int)$_GET['item_id'];
	if (!empty($grav_text) && is_numeric($item_id)) 
	{
		$object = mysql_fetch_array(mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND id='".$item_id."' and wear=0"));
		if ($object) 
		{
			if ($db["platina"]>=50)
			{
				if (eregi("^[a-zA-Zа-яА-Я0-9_\.\,\-\!\?\ ]+$",$grav_text)) 
				{
					if (strlen($grav_text) <= 50)
					{
						mysql_query("UPDATE inv SET gravirovka='".$grav_text."' WHERE id='".$item_id."'");
						mysql_query("UPDATE users SET platina = platina-50 WHERE login = '".$login."'");
						$db["platina"]=$db["platina"]-50;
						$mess = "Вы удачно выгравировали надпись <U>".$grav_text."</U> , заплатив при этом - 50 Пл.";
					}
					else $mess = "Текст гравировки не должен быть длинее 50 символов!";
				}
				else
				$mess = "В тексте гравировки можно указывать только русские или английские буквы!";
			}
			else
			{
				$mess="У вас нет такой суммы!";
			}
		}
		else $mess = "Предмет не найден в рюкзаке...";
	}
	else $mess = "Введите текст гравировки!";
	//$mess="Работаем над ошибками.";
}
//-----------------------Zatochka----------------------------------------------------------------------
if($_GET['zatochka'])
{
	$item_id=(int)abs($_GET['zatochka']);
	$object = mysql_fetch_array(mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND id='".$item_id."' and object_type in ('sword','axe','fail','spear','knife','staff') and wear=0"));
	if ($object) 
	{
		if ($object["is_modified"]>0)
		{
			if ($object["object_type"]=="fail")
			{
				switch ($object["is_modified"])
				{
					case 1: $magic_id=29; break;
					case 2: $magic_id=35; break;
					case 3: $magic_id=40; break;
					case 4: $magic_id=195; break;
					case 5: $magic_id=196; break;
					case 6: $magic_id=197; break;
					case 7: $magic_id=198; break;
					case 8: $magic_id=199; break;
					case 9: $magic_id=200; break;
					case 10: $magic_id=45; break;
					
				}
			}	
			else if ($object["object_type"]=="knife")
			{
				switch ($object["is_modified"])
				{
					case 1: $magic_id=28; break;
					case 2: $magic_id=36; break;
					case 3: $magic_id=41; break;
					case 4: $magic_id=207; break;
					case 5: $magic_id=208; break;
					case 6: $magic_id=209; break;
					case 7: $magic_id=210; break;
					case 8: $magic_id=211; break;
					case 9: $magic_id=212; break;
					case 10: $magic_id=46; break;
					
				}
			}
			else if ($object["object_type"]=="axe")
			{
				switch ($object["is_modified"])
				{
					case 1: $magic_id=27; break;
					case 2: $magic_id=38; break;
					case 3: $magic_id=43; break;
					case 4: $magic_id=201; break;
					case 5: $magic_id=202; break;
					case 6: $magic_id=203; break;
					case 7: $magic_id=204; break;
					case 8: $magic_id=205; break;
					case 9: $magic_id=206; break;
					case 10: $magic_id=48; break;
					
				}
			}
			else if ($object["object_type"]=="sword")
			{
				switch ($object["is_modified"])
				{
					case 1: $magic_id=26; break;
					case 2: $magic_id=37; break;
					case 3: $magic_id=42; break;
					case 4: $magic_id=189; break;
					case 5: $magic_id=190; break;
					case 6: $magic_id=191; break;
					case 7: $magic_id=192; break;
					case 8: $magic_id=193; break;
					case 9: $magic_id=206; break;
					case 10: $magic_id=47; break;
					
				}
			}
			else if ($object["object_type"]=="staff")
			{
				switch ($object["is_modified"])
				{
					case 1: $magic_id=130; break;
					case 2: $magic_id=131; break;
					case 3: $magic_id=133; break;
					case 4: $magic_id=213; break;
					case 5: $magic_id=214; break;
					case 6: $magic_id=215; break;
					case 7: $magic_id=216; break;
					case 8: $magic_id=217; break;
					case 9: $magic_id=218; break;
					case 10: $magic_id=132; break;
					
				}
			}
			if ($magic_id)
			{
				mysql_query("INSERT INTO inv(owner,object_id,object_type,object_razdel,wear,iznos,iznos_max) VALUES ('".$login."','".$magic_id."','scroll','magic','0','0','1')");
				mysql_query("UPDATE inv SET is_modified=0 WHERE id=$item_id");
				history($login,'Сняли Заточку',$object["object_type"]."-".$object["is_modified"]."[".$magic_id."]",$ip,'Ремонтная мастерская');
				$mess = "Удачно";
			}
		}
		else
		{
			$mess="Это оружие не было заточено!";
		}
	}
	else $mess = "Предмет не найден в рюкзаке...";
}

//----------------------------------------------------------------------------------------------
$platina = sprintf ("%01.2f", $db["platina"]);
$money = sprintf ("%01.2f", $db["money"]);
$naqrada = sprintf ("%01.2f", $db["naqrada"]);

?>
<SCRIPT LANGUAGE="JavaScript" SRC="scripts/magic-main.js"></SCRIPT>
<div id=hint4></div>
<table width=100% cellspacing=0 cellpadding=0>
<tr valign=top>
	<td width=100%><h3>Ремонтная мастерская</h3></td>
	<td nowrap>
		<input type=button onclick="location.href='main.php?act=go&level=municip'" value="Вернуться" class=new >
		<input type=button onclick="location.href='main.php?act=none'" value="Обновить" class=new >
	</td>
</tr>
</table>
<table width=100% cellspacing=0 cellpadding=0>
<tr valign=top>
	<td width=100%><B style=color:#ff0000><?echo $mess?>&nbsp;</B></td>
	<td nowrap>У вас в наличии: <B><?echo $money;?></B> Зл. <B><?echo $platina;?></B> Пл. <B><?echo $naqrada;?></B> Ед.</td>
</tr>
</table>
<table width=100% border=0>
<tr>
<td width=100% valign=top nowrap>
	<table width=100% border=0 cellspacing=0 cellpadding=0>
	<tr>
		<td valign=top> 
		<?
			echo "<TABLE width=100% cellspacing=0 cellpadding=2 bgcolor=#CEBBAA >
			<tr><td><B>&nbsp;&nbsp;Залы:&nbsp;</B></td>
			<td nowrap align=center ".($room<1?"class='fnew'":"class='fold'")." width=\"20%\"><a href=\"?room=0&".rand(0,1234123)."\" style=\"color: #ffffff\">Ремонт</a></td>
			<td nowrap align=center ".($room==1?"class='fnew'":"class='fold'")." width=\"20%\"><a href=\"?room=1&".rand(0,1234123)."\" style=\"color: #ffffff\">Гравировка</a></td>
			<td nowrap align=center ".($room==2?"class='fnew'":"class='fold'")." ><a href=\"?room=2&".rand(0,1234123)."\" style=\"color: #ffffff\">&nbsp;Усиление Оружий&nbsp;</a></td>
			<td nowrap align=center ".($room==3?"class='fnew'":"class='fold'")." ><a href=\"?room=3&".rand(0,1234123)."\" style=\"color: #ffffff\">&nbsp;Подгонка брони&nbsp;</a></td>
			<td nowrap align=center ".($room==4?"class='fnew'":"class='fold'")." ><a href=\"?room=4&".rand(0,1234123)."\" style=\"color: #ffffff\">&nbsp;Снять Руны&nbsp;</a></td>
			<td nowrap align=center ".($room==5?"class='fnew'":"class='fold'")." ><a href=\"?room=5&".rand(0,1234123)."\" style=\"color: #ffffff\">&nbsp;Снять Заточку&nbsp;</a></td>
			<td width=90%>&nbsp;</td></tr>
			</table>
			<TABLE  width=100% cellspacing=0 cellpadding=0 class='fnew' >
			<TR><TD align=center>";
			if ($room==0) { echo "Починка поврежденных предметов"; }
			else if ($room==1) { echo "Вы можете выгравировать надпись на одном из Ваших орудий..."; }
			else if ($room==2) {echo "Протирка и полировка Именных Оружий"; }
			else if ($room==3) {echo "Важно! Тут можно подгонять любой грудной вещь (броня, плащи, рубахи).!"; }
			else if ($room==4) {echo "Важно! Тут можно Снять Руны из любой вещи!"; }
			else if ($room==5) {echo "Важно! Тут можно Снять Заточку из Оружий!"; }
			echo "</TD></TR></table>";
		?>
		</td>
	</tr>
	<tr>
		<td valign=top nowrap>
			<TABLE width=100% cellspacing=0 cellpadding=0>
			<TR>
				<TD>
					<TABLE width=100% cellspacing=1 cellpadding=5 bgcolor=212120>
					<?
					if ($room<1)
					{
						$SQL=mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_razdel='obj' AND iznos>0 AND wear='0'");
						$at_all = mysql_num_rows($SQL);
						if($at_all==0)
						{
							echo "<tr class='l0'><td align=center><b style='color:#ff0000'>У вас в рюкзаке нет поврежденных предметов!</b></td></tr>";
						}
						else
						{
							while($data=mysql_fetch_array($SQL))
							{
								$n=(!$n);	
								echo "<tr class='".($n?'l0':'l1')."'><td valign=center width=200>";
								echo "<center><img src='img/items/".$data["img"]."' border=0><BR>";
									echo "<a href='?rep=repair&item_id=".$data["id"]."&t=1' class=us2><small>Ремонт 1 ед. за 0.1 Зл. </small></a><BR>";
									echo "<a href='?rep=repair&item_id=".$data["id"]."&t=0' class=us2><small>Полный ремонт за ".($data["iznos"]*0.1)." Зл.</small></a><BR>";
								echo "</td><td valign='top'>";
								show_item($db,$data);
								echo "</td></tr>";
							}
						}
					}
					//----------------------------------------------------------------------------------------------
					else if ($room==1)
					{
						$SQL=mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_type in ('sword','axe','fail','spear','knife','staff') AND wear='0'");
						$at_all = mysql_num_rows($SQL);
						if($at_all==0)
						{
							echo "<tr class='l0'><td align=center><b style='color:#ff0000'>У вас в рюкзаке нет оружия, на которое можно нанести гравировку!</b></td></tr>";
						}
						else
						{
							while($data=mysql_fetch_array($SQL))
							{
								$n=(!$n);
								echo "<tr class='".($n?'l0':'l1')."'><td valign=center width=200>";
								echo "<center><img src='img/items/".$data["img"]."' border=0><BR>";
								echo "<a href='javascript:;' onclick=\"form('Гравировка  за 50 Пл. :', '?rep=grave&room=1&item_id=".$data["id"]."', 'grave_text','', '5')\"><small>Гравировка  за 50 Пл.</small></a>";
								echo "</td><td valign='top'>";
								show_item($db,$data);
								echo "</td></tr>";
							}
						}
					}
					//----------------------------------------------------------------------------------------------
					else if ($room==2)
					{
						$SQL=mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND wear='0' and edited>0 and min_level<10");
						if (!mysql_num_rows($SQL))
						{	
							echo "<tr class='l0'><td align=center><b style='color:#ff0000'>У вас в рюкзаке нет Оружий, которые можно усилить!</b></td></tr>";
						}
						else
						{
							while($data=mysql_fetch_array($SQL))
							{
								$usilen=mysql_fetch_array(mysql_query("SELECT * FROM paltar WHERE edited=".$data["edited"]." and min_level=".($data["min_level"]+1)));
								$n=(!$n);
								echo "<tr class='".($n?'l0':'l1')."'>
								<td valign=center width=70><img src='img/items/".$data["img"]."' border=0></td>
								<td valign='top'>";show_item($db,$data);echo "</td>
								<TD valign=middle align=center width=12 class='l3'><img src='img/index/rep_arrow.gif'><br><img src='img/index/rep_arrow.gif'><br><img src='img/index/rep_arrow.gif'><br><img src='img/index/rep_arrow.gif'><br><img src='img/index/rep_arrow.gif'></td>
								<td valign=center width=70>".($usilen?"<img src='img/items/".$usilen["img"]."' border=0>":"")."</td>
								<td valign='top'>";($usilen?show_item($db,$usilen):"");echo "</td>
								</tr>
								<TR class='l3'>
								<TD colspan=5 valign=middle align=center>
									Усилить за <B>".sprintf ("%01.2f", $usilen["price"]*0.1)." Пл.</B>&nbsp;<INPUT type=button value='Усилить' onclick=\"document.location='?room=2&upgradeItem=".$data["id"]."'\" >
								</TD>
								</TR>";
							}
						}
					}
					//----------------------------------------------------------------------------------------------
					else if ($room==3)
					{
						$SQL=mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND wear='0' and object_type='armour'");
						if (!mysql_num_rows($SQL))
						{	
							echo "<tr class='l0'><td align=center><b style='color:#ff0000'>У вас в рюкзаке нет брони!</b></td></tr>";
						}
						else
						{
							while($data=mysql_fetch_array($SQL))
							{
								$n=(!$n);
								echo "<tr class='".($n?'l0':'l1')."'><td valign=center width=200>";
								echo "<center><img src='img/items/".$data["img"]."' border=0><BR>";
								//echo "<a href='?room=3&podqonka=$item_id&type=1'><small>+1000 HP за 100 Пл.</small></a><br>";
								echo "</td><td valign='top'>";
								show_item($db,$data);
								echo "</td></tr>";
							}
						}
					}
					//----------------------------------------------------------------------------------------------
					else if ($room==4)
					{
						$SQL=mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND  wear='0' and runas!=''");
						if (!mysql_num_rows($SQL))
						{	
							echo "<tr class='l0'><td align=center><b style='color:#ff0000'>У вас в рюкзаке нет брони!</b></td></tr>";
						}
						else
						{
							while($data=mysql_fetch_array($SQL))
							{
								$n=(!$n);
								$rname=explode("#",$data["runas"]);
								switch ($rname[1])
								{
									case 1:$runa_summa=30;break;
									case 2:$runa_summa=100;break;
									case 3:$runa_summa=200;break;
								}
								echo "<tr class='".($n?'l0':'l1')."'><td valign=center width=200>";
								echo "<center><img src='img/items/".$data["img"]."' border=0><BR>";
								echo "<a href='?room=4&runa=".$data["id"]."'><small>Снять Руны за ".$runa_summa." Пл.</small></a><br>";
								echo "</td><td valign='top'>";
								show_item($db,$data);
								echo "</td></tr>";
							}
						}
					}
					//----------------------------------------------------------------------------------------------
					else if ($room==5)
					{
						$SQL=mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_type in ('sword','axe','fail','spear','knife','staff') AND wear='0'");
						$at_all = mysql_num_rows($SQL);
						if($at_all==0)
						{
							echo "<tr class='l0'><td align=center><b style='color:#ff0000'>У вас в рюкзаке нет оружия!</b></td></tr>";
						}
						else
						{
							while($data=mysql_fetch_array($SQL))
							{
								$n=(!$n);
								echo "<tr class='".($n?'l0':'l1')."'><td valign=center width=200>";
								echo "<center><img src='img/items/".$data["img"]."' border=0><BR>";
								echo "<a href='?room=5&zatochka=".$data["id"]."'><small>Снять Заточку</small></a><br>";
								echo "</td><td valign='top'>";
								show_item($db,$data);
								echo "</td></tr>";
							}
						}
					}
					?>
					</td>
					</tr>
				</table>
			</td>
			</tr>
			</table>
	</td>	
	<td valign=top width=300 align=right>
		<img src='img/index/repair.gif' alt='Темный Воин'><br>
		<small>В мастерской вы можете отремонтировать вещи из оружейки.
		К сожалению, иногда в процессе ремонта вещь может потерять единицу долговечности,
		советуем учитывать это при ремонте вещей с малой долговечностью.	
	</td>	
</tr>
</table>