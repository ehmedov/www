<h3>Турнирный зал</h3>
<script language="JavaScript" type="text/javascript" src="tower.js"></script>
<?php
include("modules/tower_mod.php");
$move_time=3; // Время Перехода...
$login=$_SESSION["login"];
//--------------------выиграл БС-------------------------------------------------------
$check = mysql_query("SELECT users.login,users.remote_ip FROM online LEFT JOIN users on users.bs=1 WHERE online.login=users.login");
if (mysql_num_rows($check) <= 1) 
{
	$add = 0;
	$ch = mysql_fetch_array($check);
	$bs_sel = mysql_query("SELECT * FROM deztow_stavka");
	while ($bs = mysql_fetch_array($bs_sel)) 
	{
		$add = $add + $bs["kredit"];
		mysql_Query("DELETE FROM labirint WHERE user_id='".$bs["owner"]."'");
	}
	if ($ch)
	{
		$add=floor($add*0.75);
		$winner=$ch["login"];
		mysql_query("UPDATE users SET money=money+$add,naqrada=naqrada+50,reputation=reputation+1 WHERE login='".$winner."'");
		mysql_query("INSERT INTO `inv` (`owner`, `object_id`, `object_type`, `object_razdel` ,`iznos`,  `iznos_max`) VALUES 	('".$winner."', '22','wood','thing','0','1');");
		history($winner,"Победил в турнире","Приз состовляет: <b>$add Зл.</b>  (за исключением 25% комиссии), Чек на 100Зл. и <b>50 Ед.</b> награды",$ch["remote_ip"],"Турнир");
		say($winner,"<b>Поздравляем!</b> Вы победили в турнире, ваш приз состовляет: <b>$add Зл.</b>  (за исключением 25% комиссии), Чек на 100Зл. и <b>50 Ед.</b> награды...",$winner);
		say("toall_news","<font color=red>В турнире победил <b>".$winner."</b>. Поздравляем!</font>",$winner);
	}
	mysql_query("UPDATE users SET location='', vector='', bs=0 WHERE bs=1");
	mysql_query('UPDATE `deztow_turnir` SET `winner` = \''.$winner.'\', `winnerlog`=\''.$winner.'\',`endtime` = \''.time().'\',`active` = FALSE, `log` = CONCAT(`log`,\''."<span class=date>".date("d.m.y H:i")."</span> Турнир завершен. Победитель: <b>".$winner."</>. Приз: <B>".$add."</B> Зл. <BR>".'\') WHERE `active` = TRUE LIMIT 1');
	mysql_query("DELETE FROM  deztow_turnir WHERE `active` = TRUE");
	mysql_query('UPDATE `variables` SET `value` = \''.(time()+20*60).'\' WHERE `var` = \'startbs\';');
	mysql_query("TRUNCATE TABLE `deztow_stavka`;");
	mysql_query("UPDATE bs_objects SET bs=0,owner=''");
	mysql_query("DELETE FROM bs_objects WHERE type!=1");
}
//-------------------------------------------------------------------------------------------
$db=mysql_fetch_array((mysql_query("SELECT * FROM users WHERE login='".$login."'")));
if ($db['bs'] != 1) { header('Location: main.php?act=go&level=smert_room'); die(); }
$mine_id=$db["id"];
$ip=$db["remote_ip"];
//-------------------------------------------------------------------------------------------
// поднял шмотку
if ($_GET['do'] == "get" && is_numeric($_GET[id])) 
{
	$id=(int)$_GET["id"];
	$b_s=mysql_fetch_Array(mysql_query("SELECT * FROM bs_objects WHERE id=$id and bs=0 and coord='".$db["location"]."'"));
	if ($b_s)
	{
		if($_SESSION['timei']<time()) 
		{
			$_SESSION['timei'] = time()+3;
			if ($b_s["type"]==1)
			{
				$buy_item = mysql_fetch_array(mysql_query("SELECT * FROM paltar WHERE id=".$b_s["bs_id"]));
				if ($buy_item)
				{	
					mysql_query("LOCK TABLES inv WRITE");
					mysql_query("INSERT INTO `inv` (`id`, `owner`, `img`, `bs`, `object_id`, `object_type`, `object_razdel`, `name`,  `mass`, `price`, `gos_price`, `min_sila`, `min_lovkost`, `min_udacha`, `min_power`, `min_intellekt`, `min_vospriyatie`, `min_level`, `min_sword_vl`, `min_staff_vl`, `min_axe_vl`, `min_fail_vl`, `min_knife_vl`, `min_spear_vl`,`min_fire`,`min_water`,`min_air`,`min_earth`,`min_svet`,`min_tma`,`min_gray`,`add_fire`, `add_water`, `add_air`, `add_earth`, `add_svet`, `add_tma`, `add_gray`, `add_sila`, `add_lovkost`, `add_udacha`, `add_intellekt`, `add_duxovnost`, `add_hp`, `add_mana`, `protect_head`, `protect_arm`, `protect_corp`, `protect_poyas`, `protect_legs`, `protect_rej`, `protect_drob`, `protect_kol`, `protect_rub`, `protect_fire`, `protect_water`, `protect_air`, `protect_earth`, `protect_svet`, `protect_tma`, `protect_gray`,`protect_mag`,`protect_udar`, `shieldblock`, `krit`, `akrit`, `uvorot`, `auvorot`, `parry`, `counter`, `add_rej`, `add_drob`, `add_kol`, `add_rub`, `ms_udar`, `ms_krit`, `ms_mag`, `ms_fire`, `ms_water`, `ms_air`, `ms_earth`, `ms_svet`, `ms_tma`, `ms_gray`, `ms_rej`, `ms_drob`, `ms_kol`, `ms_rub`, `iznos_max`, `min_attack`, `max_attack`, `proboy`, `add_oruj`, `add_sword_vl`, `add_staff_vl`, `add_axe_vl`, `add_fail_vl`, `add_knife_vl`, `add_spear_vl`, `need_orden`, `sex`, `art`, `podzemka`, `is_personal`, `personal_owner`, `noremont`, `two_hand`, `second_hand`,  `add_fire_att`, `add_air_att`, `add_watet_att`, `add_earth_att`, `edited`) 
						VALUES (NULL, '".$login."','".$buy_item["img"]."', 1 ,'".$buy_item["id"]."', '".$buy_item["object"]."', 'obj', '".$buy_item["name"]."', '".$buy_item["mass"]."', '".$buy_item["price"]."', '".$buy_item["price"]."', '".$buy_item["min_sila"]."', '".$buy_item["min_lovkost"]."', '".$buy_item["min_udacha"]."', '".$buy_item["min_power"]."', '".$buy_item["min_intellekt"]."', '".$buy_item["min_vospriyatie"]."', '".$buy_item["min_level"]."', '".$buy_item["min_sword_vl"]."', '".$buy_item["min_staff_vl"]."', '".$buy_item["min_axe_vl"]."', '".$buy_item["min_fail_vl"]."', '".$buy_item["min_knife_vl"]."', '".$buy_item["min_spear_vl"]."', '".$buy_item["min_fire"]."','".$buy_item["min_water"]."','".$buy_item["min_air"]."','".$buy_item["min_earth"]."','".$buy_item["min_svet"]."','".$buy_item["min_tma"]."','".$buy_item["min_gray"]."', '".$buy_item["add_fire"]."', '".$buy_item["add_water"]."', '".$buy_item["add_air"]."', '".$buy_item["add_earth"]."', '".$buy_item["add_svet"]."', '".$buy_item["add_tma"]."', '".$buy_item["add_gray"]."', '".$buy_item["add_sila"]."', '".$buy_item["add_lovkost"]."', '".$buy_item["add_udacha"]."', '".$buy_item["add_intellekt"]."', '".$buy_item["add_duxovnost"]."', '".$buy_item["add_hp"]."', '".$buy_item["add_mana"]."', '".$buy_item["protect_head"]."', '".$buy_item["protect_arm"]."', '".$buy_item["protect_corp"]."', '".$buy_item["protect_poyas"]."', '".$buy_item["protect_legs"]."', '".$buy_item["protect_rej"]."', '".$buy_item["protect_drob"]."', '".$buy_item["protect_kol"]."', '".$buy_item["protect_rub"]."', '".$buy_item["protect_fire"]."', '".$buy_item["protect_water"]."', '".$buy_item["protect_air"]."', '".$buy_item["protect_earth"]."', '".$buy_item["protect_svet"]."', '".$buy_item["protect_tma"]."', '".$buy_item["protect_gray"]."', '".$buy_item["protect_mag"]."', '".$buy_item["protect_udar"]."','".$buy_item["shieldblock"]."','".$buy_item["krit"]."', '".$buy_item["akrit"]."', '".$buy_item["uvorot"]."', '".$buy_item["auvorot"]."', '".$buy_item["parry"]."', '".$buy_item["counter"]."', '".$buy_item["add_rej"]."', '".$buy_item["add_drob"]."', '".$buy_item["add_kol"]."', '".$buy_item["add_rub"]."', '".$buy_item["ms_udar"]."', '".$buy_item["ms_krit"]."', '".$buy_item["ms_mag"]."', '".$buy_item["ms_fire"]."', '".$buy_item["ms_water"]."', '".$buy_item["ms_air"]."', '".$buy_item["ms_earth"]."', '".$buy_item["ms_svet"]."', '".$buy_item["ms_tma"]."', '".$buy_item["ms_gray"]."', '".$buy_item["ms_rej"]."', '".$buy_item["ms_drob"]."', '".$buy_item["ms_kol"]."', '".$buy_item["ms_rub"]."', '".$buy_item["iznos_max"]."', '".$buy_item["min_attack"]."', '".$buy_item["max_attack"]."', '".$buy_item["proboy"]."','".$buy_item["add_oruj"]."' ,'".$buy_item["add_sword_vl"]."', '".$buy_item["add_staff_vl"]."', '".$buy_item["add_axe_vl"]."', '".$buy_item["add_fail_vl"]."', '".$buy_item["add_knife_vl"]."', '".$buy_item["add_spear_vl"]."', '".$buy_item["need_orden"]."', '".$buy_item["sex"]."', '".$buy_item["art"]."', '".$buy_item["podzemka"]."', '".$buy_item["is_personal"]."', '".$buy_item["personal_owner"]."', 1, '".$buy_item["two_hand"]."', '".$buy_item["second_hand"]."',  '".$buy_item["add_fire_att"]."', '".$buy_item["add_air_att"]."', '".$buy_item["add_watet_att"]."', '".$buy_item["add_earth_att"]."', '".$buy_item["edited"]."');");
					mysql_query("UNLOCK TABLES");
					
					mysql_query("UPDATE bs_objects SET bs=1, owner='".$login."' WHERE id=$id");
					say("toroom","<b>".$login."</b> успешно подобрал предмет: <b>".$buy_item["name"]."</b>",$login);
					$str="<span class=date>".date("d.m.y H:i")."</span> <script>drwfl('".$db['login']."','".$db['id']."','".$db['level']."','".$db['dealer']."','".$db['orden']."','".$db['admin_level']."','".$db['clan_short']."','".$db['clan']."');</script> успешно подобрал предмет: <b>".$buy_item["name"]."</b><BR>";
					mysql_query('UPDATE `deztow_turnir` SET `log` = CONCAT(`log`,"'.$str.'") WHERE `active` = TRUE;');

				}
			}
			else if ($b_s["type"]==2)
			{
				$buy_item = mysql_fetch_array(mysql_query("SELECT * FROM scroll WHERE id=".$b_s["bs_id"]));
				if ($buy_item)
				{	
					if ($buy_item["del_time"])
					{
						$del_time= time() + $buy_item["del_time"]*24*3600;
					}
					mysql_query("LOCK TABLES inv WRITE");
					mysql_query("INSERT INTO inv(owner,object_id,object_type,object_razdel,wear,iznos,iznos_max,term, gift, gift_author) 
					VALUES ('".$login."','".$buy_item["id"]."','scroll','magic','0','0','".$buy_item["iznos_max"]."','".$del_time."',1,'Рыцарь Смерти')");
					mysql_query("UNLOCK TABLES");
					
					mysql_query("UPDATE bs_objects SET bs=1, owner='".$login."' WHERE id=$id");
					say("toroom","<b>".$login."</b> успешно подобрал предмет: <b>".$buy_item["name"]."</b>",$login);
					$str="<span class=date>".date("d.m.y H:i")."</span> <script>drwfl('".$db['login']."','".$db['id']."','".$db['level']."','".$db['dealer']."','".$db['orden']."','".$db['admin_level']."','".$db['clan_short']."','".$db['clan']."');</script> успешно подобрал предмет: <b>".$buy_item["name"]."</b><BR>";

					mysql_query('UPDATE `deztow_turnir` SET `log` = CONCAT(`log`,"'.$str.'") WHERE `active` = TRUE;');
				}
			}
			else if ($b_s["type"]==4)
			{
				$buy_item = mysql_fetch_array(mysql_query("SELECT * FROM wood WHERE id=".$b_s["bs_id"]));
				if ($buy_item)
				{
					mysql_query("LOCK TABLES inv WRITE");
					mysql_query("INSERT INTO inv (owner,object_type,object_id) VALUES ('".$login."','wood',24);");
					mysql_query("UNLOCK TABLES");
					
					mysql_query("UPDATE bs_objects SET bs=1, owner='".$login."' WHERE id=$id");
					say("toroom","<b>".$login."</b> успешно подобрал предмет: <b>".$buy_item["name"]."</b>",$login);
					$str="<span class=date>".date("d.m.y H:i")."</span> <script>drwfl('".$db['login']."','".$db['id']."','".$db['level']."','".$db['dealer']."','".$db['orden']."','".$db['admin_level']."','".$db['clan_short']."','".$db['clan']."');</script> успешно подобрал предмет: <b>".$buy_item["name"]."</b><BR>";

					mysql_query('UPDATE `deztow_turnir` SET `log` = CONCAT(`log`,"'.$str.'") WHERE `active` = TRUE;');
				}
			}
		}
		else 
		{
			echo "<font color=#ff0000>Вы сможте поднять вещь через ".($_SESSION['timei']-time())." секунд...</font>";
		}
	}
	else echo "<font color=#ff0000>Кто то оказался быстрее...</font>";
}
//----------------------------Нападения--------------------------------------------------
if($_GET['attack_bot']=="19x11" && !$db["zayavka"] && $db["hp"]>0)
{
	$is_smert=mysql_fetch_Array(mysql_query("SELECT count(*) FROM bs_objects WHERE type=3"));
	if (!$is_smert[0])
	{
		$sel_battle_bot=mysql_query("SELECT * FROM bot_temp WHERE prototype='Рыцарь Смерти'");
		if (mysql_num_rows($sel_battle_bot))
		{
			$sel_battle=mysql_fetch_assoc($sel_battle_bot);
			$battle_id=$sel_battle['battle_id'];
			$bat=mysql_fetch_Array(mysql_query("SELECT * FROM battles WHERE id='".$battle_id."'"));
			$creator=$bat['creator_id'];
			mysql_query("INSERT INTO teams(player,team,ip,battle_id,hitted,over) VALUES('".$login."','1','".$ip."','".$creator."','0','0')");
			$date = date("H:i");
			$att="<span class=date2>$date</span> <script>drwfl('".$db['login']."','".$db['id']."','".$db['level']."','".$db['dealer']."','".$db['orden']."','".$db['admin_level']."','".$db['clan_short']."','".$db['clan']."');</script> вмешался в поединок!<hr>";
			battle_log($battle_id, $att);
			$str="<span class=date>".date("d.m.y H:i")."</span> <script>drwfl('".$db['login']."','".$db['id']."','".$db['level']."','".$db['dealer']."','".$db['orden']."','".$db['admin_level']."','".$db['clan_short']."','".$db['clan']."');</script> вмешался в поединок против <b>Рыцарь Смерти</b> <a href=\"log.php?log=".$bat['id']."\" target=_blank>»»</a><BR>";
			mysql_query('UPDATE `deztow_turnir` SET `log` = CONCAT(`log`,"'.$str.'") WHERE `active` = TRUE;');
	        goBattle($login);
		}
		else
		{
			$timeout = time()+180;
		    mysql_query("INSERT INTO zayavka(status,type,timeout,creator) VALUES('3','66','3','".$mine_id."')");
		    mysql_query("INSERT INTO teams(player,team,ip,battle_id,hitted,over) VALUES('".$login."','1','".$ip."','".$mine_id."','0','0')");
			mysql_query("INSERT INTO battles(type, creator_id, lasthit) VALUES('66', '".$mine_id."', '".$timeout."')");
			$b_id=mysql_insert_id();
			mysql_query("INSERT INTO bot_temp(bot_name,hp,hp_all,battle_id,prototype,team, two_hands, shield_hands) VALUES('Рыцарь Смерти','300','300','".$b_id."','Рыцарь Смерти','2','1','0')");
			$str="<span class=date>".date("d.m.y H:i")."</span> <script>drwfl('".$db['login']."','".$db['id']."','".$db['level']."','".$db['dealer']."','".$db['orden']."','".$db['admin_level']."','".$db['clan_short']."','".$db['clan']."');</script> напал на <b>Рыцарь Смерти</b> завязался <a href=\"log.php?log=$b_id\" target=_blank>бой »»</a><BR>";
	        
			mysql_query('UPDATE `deztow_turnir` SET `log` = CONCAT(`log`,"'.$str.'") WHERE `active` = TRUE;');
			say("toroom","<b>".$login."</b> напал на <b>Рыцарь Смерти</b>",$login);
			goBattle($login);
		}
		mysql_free_result($sel_battle_bot);
	}
}
//-------------------нападение------------------------------------------------------------------------
if ($_POST[Attack] && is_numeric($_POST['char_id']))
{
  	$char_id=(int)$_POST['char_id'];  
  	if($char_id==$db["id"])
	{
		$msg="Нападение на самого себя - это уже мазохизм...";
	}
	else if(!$db["battle"])
	{
		$q=mysql_query("SELECT * FROM `users` WHERE id = '".$char_id."'");
		$res=mysql_fetch_array($q);
		if(!$res)
		{
			$msg="Персонаж не найден.";
		}
		else if (!$res['bs'])
		{
			$msg="Боец \"".$res["login"]."\" уже проиграл турнир!";
		}
		else if (!$db['bs'])
		{
			$msg="Вы уже проиграли турнир!";
		}	
		else if($res["room"]!=$db["room"])
        {
        	$msg="Для нападния Вам необходимо находится в одной комнате!";
        }
        else if($db["zayavka"]==1)
        {
        	$msg="Сначала отзовите текущую заявку...</b>";
        }
		else
		{
			if ($res["battle"]==0)
			{
				$timeout = time()+3*60;
		        $date = date("d.m.y H:i");
		        say("toroom","<b>".$login."</b> напал на <b>".$res["login"]."</b>",$login);
		        mysql_query("INSERT INTO zayavka(status,type,timeout,creator) VALUES('3','99','3','".$mine_id."')");
		        mysql_query("INSERT INTO teams(player,team,ip,battle_id,hitted,over) VALUES('".$db["login"]."','2','".$db["last_ip"]."','".$mine_id."','0','0')");
		        mysql_query("INSERT INTO teams(player,team,ip,battle_id,hitted,over) VALUES('".$res["login"]."','1','".$res["last_ip"]."','".$mine_id."','0','0')");
				$B_CREATE = mysql_query("INSERT INTO battles(type, creator_id, lasthit) VALUES('99', '".$mine_id."', '".$timeout."')");
				$b_id=mysql_insert_id();
				$str="<span class=date>".date("d.m.y H:i")."</span> <script>drwfl('".$db['login']."','".$db['id']."','".$db['level']."','".$db['dealer']."','".$db['orden']."','".$db['admin_level']."','".$db['clan_short']."','".$db['clan']."');</script> напал на <script>drwfl('".$res['login']."','".$res['id']."','".$res['level']."','".$res['dealer']."','".$res['orden']."','".$res['admin_level']."','".$res['clan_short']."','".$res['clan']."');</script> завязался <a href='log.php?log=".$b_id."' target=_blank>бой »»</a><BR>";
		        mysql_query('UPDATE `deztow_turnir` SET `log` = CONCAT(`log`,"'.$str.'") WHERE `active` = TRUE;');
		        goBattle($db["login"]);
		        goBattle($res["login"]);
			}
			else if ($res["battle"]!=0)
			{
				$Q_TEAM=mysql_query("SELECT * FROM teams WHERE player='".$res["login"]."'");
				$D=mysql_fetch_array($Q_TEAM);
				if ($D)
				{
					$battle_id=$D["battle_id"];
					$team=$D["team"];
					mysql_query("INSERT INTO teams(player,team,ip,battle_id,hitted,over) VALUES('".$login."','".($team==1?2:1)."','".$db["last_ip"]."','".$battle_id."','0','0')");
    				$date = date("d.m.y H:i");
					$att="<span class=date2>$date</span> <script>drwfl('".$db['login']."','".$db['id']."','".$db['level']."','".$db['dealer']."','".$db['orden']."','".$db['admin_level']."','".$db['clan_short']."','".$db['clan']."');</script> вмешался в поединок!<hr>";
					battle_log($battle_id, $att);
					$str="<span class=date>".date("d.m.y H:i")."</span> <script>drwfl('".$db['login']."','".$db['id']."','".$db['level']."','".$db['dealer']."','".$db['orden']."','".$db['admin_level']."','".$db['clan_short']."','".$db['clan']."');</script> вмешался в поединок против <script>drwfl('".$res['login']."','".$res['id']."','".$res['level']."','".$res['dealer']."','".$res['orden']."','".$res['admin_level']."','".$res['clan_short']."','".$res['clan']."');</script> <a href='log.php?log=".$res['battle']."}' target=_blank>»»</a><BR>";
		       		mysql_query('UPDATE `deztow_turnir` SET `log` = CONCAT(`log`,"'.$str.'") WHERE `active` = TRUE;');
			        goBattle($login);
				}
			}
		}
	}
	else
	{
 		$msg="Вы не можете кастовать это заклятие находясь в бою!";
 	}
}
//----------------------------------------------------------------------------------------
// переходы
$ctime=time();
$r=mysql_fetch_Array(mysql_query("SELECT * FROM labirint WHERE user_id='".$login."'"));
if(!$r) 
{ 
	// начало лабиринта
	$my_cord="0x0";	
	$my_vector=90;
	$Time=time();
	mysql_query('INSERT INTO labirint(user_id, location, vector, visit_time) VALUES("'.$login.'", "'.$my_cord.'", "'.$my_vector.'", "'.time().'")');
}
else 
{
	// определим видимую область
	$my_cord=$r['location'];
	$my_vector=$r['vector'];
	$Time=$r['visit_time'];
	$my_step=next_step($my_cord, $my_vector);
	if(in_array($_GET['action'], array('rotateleft','rotateright','forward_1','back'))) 
	{
		$dtim=$ctime-$Time;
		if($dtim>=$move_time) 
		{
			if($_GET['action']=='rotateleft') 
			{
				$my_vector-=90;
				if($my_vector<0) $my_vector=270;
			} 
			else if($_GET['action']=='rotateright') 
			{
				$my_vector+=90;
				if($my_vector>270) $my_vector=0;
			} 
			else if($_GET['action']=='forward_1')
			{
				$step1=next_step($my_cord, $my_vector);
				if($step1['fwd']) 
				{
					$my_cord=$step1['fwd'];
					$Time=$ctime;
				}
			}
			else if($_GET['action']=='back') 
			{
				$step1=next_step($my_cord, $my_vector);
				if($step1['back']) 
				{
					$my_cord=$step1['back'];
					$Time=$ctime;
				}
			}
			mysql_query('UPDATE labirint SET location="'.$my_cord.'", vector="'.$my_vector.'", visit_time="'.$Time.'" WHERE user_id="'.$login.'"');
			mysql_query('UPDATE users SET location="'.$my_cord.'", vector="'.$my_vector.'" WHERE login="'.$login.'"');
		}
	}	
}
$dtim=$ctime-$Time;
$my_c=explode ("x",$my_cord); 

$step1=next_step($my_cord, $my_vector);
if($step1['fwd']) $step2=next_step($step1['fwd'], $my_vector);
if($step2['fwd']) $step3=next_step($step2['fwd'], $my_vector);
if($step3['fwd']) $step4=next_step($step3['fwd'], $my_vector);
//echo $my_cord."-".$step1['fwd']."-".$step2['fwd'];

$is_smert=mysql_fetch_Array(mysql_query("SELECT count(*) FROM bs_objects WHERE type=3"));
if (!$is_smert[0])
{
	$smert_bot=true;
}
?>
<DIV ID=oMenu CLASS="menu"></DIV>
<script language="JavaScript">
	var stop_time=<?=$move_time-$dtim?>;
	function load_page() 
	{
		setTimeout('update_timeout()',1000);
	}
   	var max_stop_time = stop_time;
	function update_timeout() 
	{	
		stop_time--;
		if(stop_time>=0)
		{
			var o = document.getElementById("move");
			if(o)
			{
			    var width = ((max_stop_time-stop_time)/max_stop_time)*100;
			    if (width > 100)
			    {
			        width = 100
			    }
			    o.style.width = width+'px';
			}
		}	
		setTimeout('update_timeout()',1000);
	}
	function check_time() 
	{
		if(stop_time<1) return true;
		else 
		{
			document.getElementById("mess").innerHTML="Дождитесь...";//'Дождитесь завершения перемещения..';
			return false;
		} 
	}
</script>
<script>
	load_page();
	LoadImg();
</script>

<?
// --------изнаем ид жертвы (рандомом)-----------------------------------
$all_people = array();
$all_users = array();
$result = mysql_query("SELECT * FROM `users` WHERE `bs` =1 AND `id` <> '".$db['id']."'");
$kol_idov = mysql_num_rows($result);
if ($kol_idov > 0) 
{
    while ($row = mysql_fetch_array($result)) 
    {
    	if ($row['location'] ==$my_cord)
    	{	
        	$all_people[] = $row['id'];
        	$all_users[]  = "<script>drwfl('$row[login]','$row[id]','$row[level]','$row[dealer]','$row[orden]','$row[admin_level]','$row[clan_short]','$row[clan]');</SCRIPT>";
        }
        $users[]=array(login=>$row["login"],coord=>$row["location"]);
    }
}
$count = count($all_people);
$lucky = $all_people[rand(1,$count) - 1];

echo "<b style=color:#ff0000>$msg &nbsp;</b>";
echo "<TABLE WIDTH=100% CELLSPACING=0 CELLPADDING=0>
     <tr>
         <td width=100% nowrap valign=top>";
			$bs_obj_sel = mysql_query("SELECT id, bs_id, type FROM bs_objects WHERE bs=0 and coord='".$my_cord."'");
			if(mysql_num_rows($bs_obj_sel)>0) 
			{
			 	echo '<H4>В комнате разбросаны вещи:</H4>';
			 	while($it = mysql_fetch_array($bs_obj_sel)) 
			 	{
			 		$item=$it["bs_id"];
			 		if ($it["type"]==1)
			 		{	
						$bs_obj = mysql_fetch_array(mysql_query("SELECT id,name,img FROM paltar WHERE id=$item"));
						echo "<A style='cursor:hand' HREF='?do=get&id=$it[id]'><img src='img/items/$bs_obj[img]' alt='Подобрать предмет: \n$bs_obj[name]'></a> ";
					}
					else if ($it["type"]==2)
			 		{
						$bs_obj = mysql_fetch_array(mysql_query("SELECT id,name,img FROM scroll WHERE id=$item"));
						echo "<A style='cursor:hand' HREF='?do=get&id=$it[id]'><img src='img/$bs_obj[img]' alt='Подобрать предмет: \n$bs_obj[name]'></a> ";
					}
					else if ($it["type"]==4)
			 		{
						$bs_obj = mysql_fetch_array(mysql_query("SELECT * FROM wood WHERE id=$item"));
						echo "<A style='cursor:hand' HREF='?do=get&id=$it[id]'><img src='img/".$bs_obj["img"]."' alt='Подобрать предмет: \n".$bs_obj["name"]."'></a> ";
					}
			 	}
			}
			echo "<form action='' method=post>";
			if ($count>0) 
			{
				echo "<input type='hidden' name='char_id' value='".$lucky."'><input type='submit' name='Attack' class='input' value='Нападение'><br>
				<b>В этой локации находятся:</b><br>";
				for($i=0;$i<count($all_users);$i++) echo $all_users[$i]."<br>";
			}
			echo "</form>";
		echo "</td>";
		echo "<td width=503 align=center valign=top><div align=right><b>Ваши координаты в игре ($my_c[0],$my_c[1])</b></div>";
		?>
		
		<TABLE border="0" cellpadding="0" cellspacing="0" bgcolor="#000000">
		<TR>
			<TD width="373" height="260" nowrap>
			<div id="lok" style="OVERFLOW:hidden;WIDTH:372px; POSITION:relative; HEIGHT:260px"></div>
			<script>
				Print();
				PrintBot();
				<?=build_move_image($my_cord, $my_vector);?>
			</script>
			</TD>
			<TD width="130" align="center" vAlign="top" style="padding:4px" nowrap>
				<table cellspacing="0" cellpadding="0" width="100" border="0">
					<tr>
						<td width="100" background="img/tower/navigation/bg.gif" height="10"><img height="10" src="img/tower/navigation/move.gif" width="1" name="move" id="move" alt="" /></td>
					</tr>
					<tr>
						<td id=mess style="color:#ffffff">&nbsp;</td>
					</tr>
				</table>
				<table cellpadding="0" cellspacing="0" border=0>
					<tr>
						<td><img src="img/tower/navigation/inv.gif" width="30" height="30"></td>
						<td align="center" valign="bottom"><?if($step1['fwd']) {echo "<a href='?action=forward_1' onclick='return check_time()'><img src='img/tower/navigation/forward.gif' border='0' alt='Вперёд'></a>";}?></td>
						<td><img src="img/tower/navigation/inv.gif" width="30" height="30"></td>
					</tr>
					<tr>
						<td align="right" valign="center"><a href="?action=rotateleft" onclick="return check_time()"><img src="img/tower/navigation/left.gif" border="0" alt="Повернуться влево"></a></td>
						<td align="center"><img src="img/tower/navigation/center.gif" border="0"></td>
						<td align="left" valign="center"><a href="?action=rotateright" onclick="return check_time()"><img src="img/tower/navigation/right.gif" border="0" alt="Повернуться вправо"></a></td>
					</tr>

					<tr>
						<td><img src="img/tower/navigation/inv.gif" width="30" height="30"></td>
						<td align="center" valign="top"><?if($step1['back']) {echo "<a href='?action=back' onclick='return check_time()'><img src='img/tower/navigation/back.gif' border='0' alt='Назад'></a>";}?></td>
						<td><img src="img/tower/navigation/inv.gif" width="30" height="30"></td>
					</tr>
				</table>
				<?build_map($my_cord, $my_vector,$users);?>
			</TD>	
		</TR>
		</TABLE>
		<?if ($smert_bot==true)echo "<font color=red>Рыцарь Смерти Жив [19x11]</font>";?>
	</td>
</tr>
</table>
<br><br><br><br>
<?include_once("counter.php");?>