<?include_once("key.php");
@ob_start("@ob_gzhandler");

Header('Content-Type: text/html; charset=windows-1251');
Header("Cache-Control: no-cache, must-revalidate"); // говорим браузеру что-бы он не кешировал эту страницу
Header("Pragma: no-cache");

include_once("conf.php");
include_once("functions.php");
include_once("req.php");
include_once("item_des.php");
array_walk($_REQUEST,"format_string");
array_walk($_POST,"format_string");
array_walk($_GET,"format_string"); 

$login=$_SESSION["login"];
$random=md5(time());
$act=$_GET["act"];
$level=$_GET["level"];
$item=$_GET["item"];
$item_id=$_GET["item_id"];

$data = mysql_connect($base_name, $base_user, $base_pass) or die('Не получается подключиться. Проверьте имя сервера, имя пользователя и пароль!');
mysql_select_db($db_name) or die('Ошибка входа в базу данных');
?><html>
<HEAD>	
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<meta http-equiv="Content-Language" content="ru">
	<META Http-Equiv="Cache-Control" Content="no-cache, max-age=0, must-revalidate, no-store">
	<meta http-equiv="PRAGMA" content="NO-CACHE">
	<meta http-equiv="Expires" content="0">	
	<LINK REL="StyleSheet" HREF="main.css" TYPE="text/css">
</HEAD>
<body bgcolor="#faeede">
<DIV id="slot_info" style="VISIBILITY: hidden; POSITION: absolute;z-index: 1;"></DIV>
<script language="JavaScript" type="text/javascript" src="show_inf.js"></script>
<script language="JavaScript" type="text/javascript" src="commoninf.js"></script>
<script language="JavaScript" type="text/javascript" src="glow.js"></script><?$result = mysql_query("SELECT users.*,zver.id as zver_count,zver.obraz as zver_obraz,zver.level as zver_level,zver.name as zver_name,zver.type as zver_type FROM `users` LEFT join zver on zver.owner=users.id  and zver.sleep=0 WHERE login='".$login."'");
$db = mysql_fetch_assoc($result);
mysql_free_result($result);

effects($db["id"],$effect);

if($db["son"]==0)
{
	########################## Жажда жизни ############################################
	$have_elik=mysql_fetch_Array(mysql_query("SELECT * FROM effects WHERE user_id=".$db["id"]." and type='jj'"));
	if ($have_elik)
	{
		if ($have_elik["end_time"]<time())
		{
			mysql_query("UPDATE users SET hp_all=hp_all-".$have_elik["add_hp"]." WHERE login='".$db["login"]."'");
			mysql_query("DELETE FROM effects WHERE id=".$have_elik["id"]);
			talk($db["login"],"Действие Эликсира <b>«Жажда жизни+?»</b> закончилось!!!",$db);
		}
	}
	####################################################################################
	mysql_query("DELETE FROM effects WHERE user_id=".$db["id"]." and end_time<".time()." and type!='jj'");
	if(mysql_affected_rows()>0)talk($db["login"],"Действие Эликсира закончилось!!!",$db);
}
if ($db["zver_count"])
{
	$zver_db=mysql_fetch_assoc(mysql_query("SELECT * FROM zver WHERE id=".$db["zver_count"]));
	if ($zver_db["exp"]>=$zver_db["next_up"])
	{	
		testZverUp($zver_db,$db["login"]);
	}
}
if (!isset($_SESSION['my_room']))$_SESSION['my_room']=$db["room"];
if($db["battle"]!=0){Header("Location: battle.php?tmp=$random");die();}
$_SESSION["battle_ref"]=0;
//-------------------------------------------------------------
if ($_GET["post_attack"])
{
	$rooms=array(
	"plshop", "artshop", "smith", "magicstore", "casino", "test", "test2", "smert_room", "dungeon", "house", "hospital", "znaxar", "bank", "sklad",
	"castle", "castle_hall", "pochta", "towerin", "proverka", "labirint_led","izumrud_floor", "izumrud", "crypt", "crypt_floor2", "auction", "warcrypt",
	"war_labirint", "doblest_shop", "labirint_led", "novruz", "novruz_go", "novruz_shop", "novruz_floor","mount","ozera", "lesopilka"
	);

	$post_attack=(int)$_GET["post_attack"];
	$have_attack=0;
	$def=mysql_fetch_Array(mysql_query("SELECT users.*,(select count(*) from online where online.login=users.login) as online FROM users WHERE id=$post_attack"));
	if ($def)
	{
		$query=mysql_fetch_array(mysql_query("SELECT * FROM clan_battle WHERE defender='".$def["clan_short"]."' and attacker='".$db["clan_short"]."'"));
		if ($query)
		{
			$have_attack=1;
			$clan_id=$query["id"];
		}
		else
		{
			$query=mysql_fetch_array(mysql_query("SELECT * FROM clan_battle WHERE attacker='".$def["clan_short"]."' and defender='".$db["clan_short"]."' and type=2"));
			if ($query)
			{
				$have_attack=1;
				$clan_id=$query["id"];
			}
		}
		if($def["room"]!=$db["room"])
        {
        	$have_attack=0;
        	echo "<font color=red>Для нападния Вам необходимо находится в одной комнате!</font>";
        }
        if(in_Array($db["room"],$rooms))
        {
        	$have_attack=0;
        	echo "<font color=red>В этом комнате нападать запрещен...</font>";
        }
        if($def["oslab"]>time())
		{
			$have_attack=0;
			echo "<font color=red>Вы не можете нападать на персонажа ".$def["login"]." т.к. персонаж ослаблен из-за смерти в бою</font>";
		}
		if($db["oslab"]>time())
		{
			$have_attack=0;
			echo "<font color=red>Ты ослаблен из-за смерти в бою</font>";
		}
		if(!empty($db["travm"]))
		{
			$have_attack=0;
			echo "<font color=red>Вы не можете драться, т.к. тяжело травмированы!</font>";
		}
		if(!empty($def["travm"]))
		{
			$have_attack=0;
			echo "<font color=red>Противник не можете драться, т.к. тяжело травмирован!</font>";
		}
		if($db["zayavka"])
        {
        	$have_attack=0;
        	echo "<font color=red>Сначала отзовите текущую заявку...</font>";
        }
        if (!$def["battle"] && $def["zayavka"])
		{
			$have_attack=0;
			echo "<font color=red>Противник не можете драться, т.к. он в заявке!</font>";
		}
	}
	if ($have_attack && $def["online"])
	{
		$date_s=date("Y-m-d H:i:s");
		if (!$def["battle"])
		{
			$mine_id=$db["id"];
			$timeout = time()+180;
	        mysql_query("INSERT INTO zayavka(status,type,timeout,creator,clan_id) VALUES('3','77','3','".$mine_id."','".$clan_id."')");
	        mysql_query("INSERT INTO teams(player,team,ip,battle_id,hitted,over) VALUES('".$login."','2','".$db["remote_ip"]."','".$mine_id."','0','0');");
	        mysql_query("INSERT INTO teams(player,team,ip,battle_id,hitted,over) VALUES('".$def["login"]."','1','".$def["remote_ip"]."','".$mine_id."','0','0');");
			mysql_query("INSERT INTO battles(type, creator_id, lasthit) VALUES('77', '".$mine_id."', '".$timeout."')");
			$b_id=mysql_insert_id();
			mysql_query("INSERT INTO timeout(battle_id, lasthit) VALUES('".$b_id."', '".$timeout."')");
			$log = '<span class=date>'.date("d.m.y H:i").'</span> <b>'.$login.'</b> напал на <b>'.$def["login"].'</b> и завязался <a href="log.php?log='.$b_id.'" target=_blank>бой »»</a><BR>';
			mysql_query('UPDATE `clan_history` SET `log` = CONCAT(`log`,\''.$log.'\') WHERE  clan_id='.$clan_id);
			
			mysql_query("UPDATE users SET zayavka=1, battle='".$b_id."', battle_team='2',battle_pos='".$mine_id."' WHERE login='".$login."'");
			mysql_query("UPDATE users SET zayavka=1, battle='".$b_id."', battle_team='1',battle_pos='".$mine_id."' WHERE login='".$def["login"]."'");
			$add_dux_me=ceil($db["level"]/2+5)+$db["duxovnost"];
			$add_dux_def=ceil($def["level"]/2+5)+$def["duxovnost"];
			mysql_query("INSERT INTO battle_units(battle_id,player,hp) VALUES('".$b_id."','".$login."','".$add_dux_me."')");
			mysql_query("INSERT INTO battle_units(battle_id,player,hp) VALUES('".$b_id."','".$def["login"]."','".$add_dux_def."')");
			
			$diss="На часах было <span class=date>$date_s</span>, когда <b style='color:#000000'>".$login."</b> и <b style='color:#000000'>".$def["login"]."</b> завязали драку...<hr>";

			$log_file="logs/".$b_id.".dis";
			$t = file_exists($log_file);
			if(!$t)
			{
				$f=fopen($log_file,"w");
				fputs($f,$diss);
				fclose($f);
			}
			battle_log($b_id, $diss);
			talk("toall","<b>&laquo;".$login."&raquo;</b> напал на <b>&laquo;".$def["login"]."&raquo;</b>! [Битва Ханств]","");
		    Header("Location: battle.php");
		}
		else
		{
			$battle_team=$def["battle_team"];
			$battle_id=$def["battle_pos"];
			$zay=mysql_fetch_array(mysql_Query("SELECT * FROM zayavka WHERE creator=$battle_id"));
			if ($zay["type"]==77 && $zay["clan_id"]==$clan_id)
			{	
				switch ($battle_team)
				{
					case 1: $mynewteam=2; break;
					case 2: $mynewteam=1; break;
				}
		       	mysql_query("INSERT INTO teams(player,team,ip,battle_id,hitted,over) VALUES('".$login."','".$mynewteam."','".$db["remote_ip"]."','".$battle_id."','0','0')");
				talk("toall","<b>&laquo;".$login."&raquo;</b> вмешался в поединок против <b>&laquo;".$def["login"]."&raquo;</b>! [Битва Ханств]","");
   				$att="<span class=sysdate>$date_s</span> <script>drwfl('".$db['login']."','".$db['id']."','".$db['level']."','".$db['dealer']."','".$db['orden']."','".$db['admin_level']."','".$db['clan_short']."','".$db['clan']."');</script> вмешался в поединок!<hr>";
		        $log_file="logs/".$def['battle'].".dis";
				$f=fopen($log_file,"a");
				fputs($f,$att);
				fclose($f);
				battle_log($def['battle'], $att);
		        goBattle($login);
	        }
	        else echo "<font color=red>Другой тип боя</font>";
		}
	}
}	
//-------------------------------------------------------------
$_SESSION["my_battle"]=0;
$_SESSION["my_creator"]=0;
//----------------------------------------------------------------------------------
$poch=mysql_fetch_Array(mysql_query("SELECT count(*) FROM pochta WHERE whom='".$login."' and `read`=0"));
if ($poch[0]>0 && empty($_SESSION['mektub']))
{
	echo "<script>alert('Вам новое письмо! \"Арена\"->\"Центральная площадь\" ->\"Западное крыло\" -> \"Почт\" ');</script>";
	$_SESSION['mektub']="pochta";
}
if($_SESSION["my_birth"])
{
	talk($db["login"],"<font color=red>Внимание! <b>XAKUS</b> поздравляет вас с <b>Днем Рождения</b> в этом мире!</font>",$db);
	$_SESSION["my_birth"]=0;
}
if($_SESSION["registered"]==1)
{
	$info1="<font color=green>Мир <b>XAKUS<b> приветствует Вас <b>".$login."</b>! Я - СОЗДАТЕЛЬ  помогу тебе в твоих первых шагах в суровом мире. Наш город только начинает жить. Многие здания еще не достроены! Наш мир только начинает формироваться, бывают ошибки природы, сбои и скоро все будет работать как часы! Прежде всего вы должны распределить свободные параметры, такие как: сила, интуиция, ловкость и выносливость.</font>";
	$info2="<font color=green>Чтобы увеличить параметры надо нажать на <b>+Свободных увеличений</b>, и в появившемся окне, сделать выбор статов. Не спешите выбирать между маной и выносливостью, т.к. этот выбор определит вашу будущую раскачку под мага или воина соответственно. Выбор можно сделать в любой момент.</font>";
	$info3="<font color=green>Теперь мой юный воин перед первым боем тебе следует зайди в Инвентарь, чтобы посмотреть свой рюкзак вначале надо нажать кнопку <b>Инвентарь</b>,  расположенную в верхнем фрэйме кнопок навигации, там я для тебе приготовил <b>Легкий Нагрудник</b> которыю нужно на себя одеть. </font>";
	$info4="<font color=green>Далее нужно провести свой первый поединок, для этого есть кнопка <b>Начать поединок</b> и жди когда тебя примут в бой или выбери подходящего соперника из списка подавших ранее заявку на проведения боя.</font>";
	$info5="<font color=green>Удачи тебе, в этом не лёгком пути к славе и победам...</font>";
	
	talk($db["login"],$info1,$db);
	talk($db["login"],$info2,$db);
	talk($db["login"],$info3,$db);
	talk($db["login"],$info4,$db);
	talk($db["login"],$info5,$db);
	$_SESSION["registered"]=0;
}
//---------------------Fill HP and MN-----------------------------------------------
$cure_hp=$db["cure_hp"];
$cure_mn=$db["cure_mn"];

$time_to_cure=$cure_hp-time();
$time_to_cure_mn=$cure_mn-time();

$hhh=$db["hp_all"];
$mmm=$db["mana_all"];
if($db["battle"]==0)
{
	if($time_to_cure>0)
	{
		$cure_full = $db["cure_time"]-$db["cure"];
		$percent_hp=floor((100*$time_to_cure)/$cure_full);
		$percent=100-$percent_hp;
		$hp[0]=floor(($hhh*$percent)/100);
		mysql_query("UPDATE users SET hp='".$hp[0]."' WHERE login='".$login."'");
	}
	else
	{
		$hp[0]=$db["hp_all"];
		mysql_query("UPDATE users SET hp='".$hp[0]."',cure_hp='0' WHERE login='".$login."'");
	}
	if($time_to_cure_mn>0)
	{
		$percent_mn=floor((100*$time_to_cure_mn)/1200);
		$percentm=100-$percent_mn;
		$mana[0]=floor(($mmm*$percentm)/100);
		mysql_query("UPDATE users SET mana='".$mana[0]."' WHERE login='".$login."'");
	}
	else
	{
		$mana[0]=$db["mana_all"];
		mysql_query("UPDATE users SET mana='".$mana[0]."',cure_mn='0' WHERE login='".$login."'");
	}
}
$hp[1]=$db["hp_all"];
$mana[1]=$db["mana_all"];
//--------------------------------------------------------------------
$room=$db["room"];
if($act=="go")
{
	$changeroom=false;
	if (in_array($level,array("room4","municip")) && $room=="arena") {$changeroom=true;} # arenadan otaqlara kecid
	if (in_array($level,array("room3")) && $room=="arena") 
	{
		if ($db["level"]>=7  ||$db["orden"]==1)$changeroom=true;
		else $mess="Ваш уровень не позволяет пройти в эту локацию (уровни 7 и выше).";
	}
	if (in_array($level,array("room5")) && $room=="arena") 
	{
		if ($db["level"]>=9  ||$db["orden"]==1)$changeroom=true;
		else $mess="Ваш уровень не позволяет пройти в эту локацию (уровни 9 и выше).";
	}
	else if (in_array($level,array("room2")) && $room=="arena") 
	{
		if ($db["orden"]==1)$changeroom=true;
		else $mess="Вы не можете войти в эту комнату, так как не являетесь модератором.";
	} # Palachlar ve Novichoklara kecid
	else if (in_array($level,array("room1")) && $room=="arena") 
	{
		if ($db["orden"]==1)$changeroom=true;
		else $mess="Ваш уровень не позволяет пройти в эту локацию.";
	} #
	else if (in_array($level,array("room2","room1")) && $room=="arena"  && $db["orden"]==1) {$changeroom=true;} # Palachlar ve Novichoklara kecid
	else if ($level=="room6" && $room=="arena")
	{
		if($db["sex"]=="female" ||$db["orden"]==1) {$changeroom=true;} # Buduara kechit
		else $mess="Вход разрешен только женщинам...";
	}
	else if ($room=="room1" && $level=="arena" && $db["level"]>0) {$changeroom=true;} # Novichoklar otaqdan cixir
	else if (in_array($room,array("room2","room3","room4","room5","municip","room6")) && $level=="arena") {$changeroom=true;} # Otaqlardan arenaya kecid
	else if ($room=="municip" && in_array($level,array("arena","smith","remesl","plshop","magicstore","test","test2","comok5","rep","flower","bazar"))) {$changeroom=true;}	
	else if ($level=="municip" && in_array($room,array("arena","smith","remesl","plshop","magicstore","test","test2","comok5","rep","flower","bazar"))) {$changeroom=true;}	
	else if ($room=="plshop" && $level=="artshop") {$changeroom=true;} 
	else if ($room=="artshop" && $level=="plshop") {$changeroom=true;}
	else if ($room=="magicstore" && $level=="artmag") {$changeroom=true;} 
	else if ($room=="artmag" && $level=="magicstore") {$changeroom=true;} 
	else if ($room=="test" && $level=="test2") {$changeroom=true;} 
	else if ($room=="test2" && $level=="test") {$changeroom=true;} 
	else if (in_array($room,array("vault","doblest_shop")) && $level=="warcrypt") {$changeroom=true;}
	else if ($level=="doblest_shop" && $room=="warcrypt")
	{
		if($db["shoptime"]>time() || $db["adminsite"]) {$changeroom=true;} 
		else $mess="Вы должны участвовать и победит в Пещера Воинов...";
	}
	else if ($room=="warcrypt" && $level=="vault") 
	{
		if ($db["zayava"]==1)
		{
			$mess="Вы участвуете в турнире...";
		}
		else $changeroom=true;
	}
	else if ($room=="warcrypt" && $level=="war_labirint") 
	{
		if ($db["zayava"]==1)
		{
			$changeroom=true;
		}
	}
	else if ($room=="war_labirint" && $level=="warcrypt") 
	{
		if ($db["zayava"]==0)
		{
			$changeroom=true;
		}
	}
	else if (in_array($room,array("towerin")) && $level=="smert_room") 
	{	# smertden bazara kecid
		if ($db["bs"]==1)
		{
			$mess="Вы участвуете в турнире...";
		}
		else $changeroom=true;
	}
	else if (in_array($room,array("smert_room")) && $level=="towerin") 
	{	# smertden bazara kecid
		if ($db["bs"]==1)
		{
			$changeroom=true;
		}
		else $mess="Вы не участвуете в турнире...";
	} 
	else if (in_array($room,array("smert_room")) && $level=="zadaniya") 
	{
		if ($db["bs"]==1)
		{
			$mess="Вы участвуете в турнире...";
		}
		else $changeroom=true;
	} 
	else if (in_array($room,array("lesopilka","ozera")) && $level=="nature") 
	{
		if ($db["for_time"])$mess="Вы работаете...";
		else $changeroom=true;
	}
	else if (in_array($room,array("priem","mayak")) && $level=="nature") 
	{
		$changeroom=true;
	}
	else if (in_array($room,array("nature")) && $level=="ozera" && $_SESSION["cord"]=="p_-11_-3_")
	{
		$changeroom=true;
	}
	else if (in_array($room,array("nature")) && $level=="mayak" && $_SESSION["cord"]=="p_-10_0_")
	{
		if ($db["level"]>=8)$changeroom=true;
		else $mess="Ваш уровень не позволяет пройти в эту локацию (уровни 8 и выше).";
	}
	else if (in_array($room,array("hell_shop")) && $level=="mayak")
	{
		$changeroom=true;
	}
	else if (in_array($room,array("mayak")) && $level=="hell_shop")
	{
		$changeroom=true;
	}
	else if (in_array($room,array("nature")) && $level=="lesopilka" && $_SESSION["cord"]=="p_3_4_")
	{
		$changeroom=true;
	}
	else if (in_array($room,array("nature")) && $level=="priem" && $_SESSION["cord"]=="p_6_-2_")
	{
		$changeroom=true;
	}
	else if (in_array($room,array("bazar","zadaniya")) && $level=="smert_room") 
	{
		#smerte kecid
		if ($db["level"]>=8)
		{
			if (!is_wear($login))	$changeroom=true;
			else $mess="Вход с оружием строго запрещен!!!";
		}
		else $mess="В Элитный Турнир допускаются воины с 8 уровня.";
	}
	else if (in_array($room,array("bazar")) && $level=="katakomba") 
	{
		#katakombaya kecid
		if ($db["level"]>=4 || $db["adminsite"])
		{
			$changeroom=true;
		}
		else $mess="Для входа на Катакомбы уровень Вашего персонажа должен быть выше 4-го";
	}
	else if (in_array($room,array("bazar","izumrud_shop")) && $level=="izumrud") 
	{
		#izumrudniya kecid
		if ($db["level"]>=8 || $db["adminsite"])
		{
			$changeroom=true;
		}
		else $mess="Для входа на Катакомбы уровень Вашего персонажа должен быть выше 8-го";
	}
	else if (in_array($room,array("dungeon")) && $level=="katakomba") 
	{
		if (!$db['zayava'])$changeroom=true;# podzemkadan cixish
	}
	else if (in_array($room,array("katakomba")) && $level=="dungeon") 
	{
		if ($db['zayava'])$changeroom=true;# podzemkaya giriw
	}
	else if (in_array($room,array("katakomba","izumrud")) && $level=="bazar") 
	{
		if (!$db['zayava'])$changeroom=true;# Centralkaya cixish
	}
	else if (in_array($room,array("izumrud")) && $level=="izumrud_floor") 
	{
		if ($db['zayava']){$db["room"]="izumrud_floor";$changeroom=true;}
	} 
	else if (in_array($room,array("izumrud_floor")) && $level=="izumrud") 
	{
		if (!$db['zayava'])$changeroom=true;
	}
	else if (in_array($room,array("izumrud")) && $level=="izumrud_shop") 
	{
		if (!$db['zayava'])$changeroom=true;
	}
	else if ($room=="izumrud_floor" && $level=="starik") {$changeroom=true;}
	else if ($room=="starik" && $level=="izumrud_floor") {$changeroom=true;}
	else if (in_array($room,array("crypt_go")) && $level=="crypt") 
	{
		if ($db['zayava']){$db["room"]="crypt";$changeroom=true;}
	} 	
	else if (in_array($room,array("crypt_go")) && in_array($level,array("remesl","cave_secret","kvest","kvest1"))) 
	{
		if (!$db['zayava']){$changeroom=true;}
	}
	else if (in_array($room,array("crypt","kvest","kvest1","crypt_floor2","crypt_floor3")) && $level=="crypt_go") 
	{
		if (!$db['zayava'])$changeroom=true;
	}
	else if (in_array($room,array("crypt")) && $level=="crypt_floor2") 
	{
		$my_pos=mysql_fetch_array(mysql_Query("SELECT * FROM labirint WHERE user_id='".$login."' and etaj=1"));
		if($my_pos["location"]=="1x28" && $my_pos["vector"]==0)
		{
			if ($db["kwest"]>=60)
			{	
				mysql_query("UPDATE labirint SET location='28x15', vector='180',etaj=2 WHERE user_id='".$login."'");
				$db["room"]="crypt_floor2";
				$changeroom=true;
			}
			else $mess="На данный момент вами не было заверщенно прохождение всех Квестов в <b>\"Проклятый Клад (Этаж 1)\"</b>.";
		}
	}
	else if (in_array($room,array("crypt_floor2")) && $level=="crypt") 
	{
		$my_pos=mysql_fetch_array(mysql_Query("SELECT * FROM labirint WHERE user_id='".$login."' and etaj=2"));
		if($my_pos["location"]=="28x15" && $my_pos["vector"]==0)
		{
			mysql_query("UPDATE labirint SET location='1x28', vector='0',etaj=1 WHERE user_id='".$login."'");
			$db["room"]="crypt";
			$changeroom=true;
		}
	}
	else if ($room=="dungeon" && $level=="merlin") {$changeroom=true;}
	else if ($room=="merlin" && $level=="dungeon") {$changeroom=true;}
	else if ($room=="merlin" && $level=="lavka") {$changeroom=true;}
	else if ($room=="lavka" && $level=="merlin") {$changeroom=true;}
	//else if ($room=="katakomba" && $level=="kvest") {$changeroom=true;} 
	//else if ($room=="kvest" && $level=="katakomba") {$changeroom=true;} 
	//else if ($room=="katakomba" && $level=="artovka") {$changeroom=true;} 
	//else if ($room=="artovka" && $level=="katakomba") {$changeroom=true;} 
	else if (in_array($room,array("sklad","smert_room","news")) && $level=="bazar") {$changeroom=true;} # bazara kecid
	else if (in_array($level,array("sklad","news")) && $room=="bazar") {$changeroom=true;}
	else if (in_array($room,array("casino","hospital","znaxar","municip","okraina","pochta","bank","cityhall","blackjeck","lotery","obraz","proverka","auction","vault","forest","tavern")) && $level=="remesl") {$changeroom=true;} # remesl kucesine kecid
	else if (in_array($level,array("casino","hospital","municip","okraina","pochta","bank","cityhall","lotery","obraz","auction","vault","tavern")) && $room=="remesl") {$changeroom=true;} # remesl kucesine kecid
	else if (in_array($room,array("remesl")) && $level=="proverka") 
	{
		if ($db["level"]>=8)
		{
			$changeroom=true;
		}
		else $mess="Для входа уровень Вашего персонажа должен быть выше 8-го...";
	}
	else if (in_array($room,array("remesl")) && $level=="forest") 
	{
		if ($db["level"]>=7)
		{
			$changeroom=true;
		}
		else $mess="Для входа уровень Вашего персонажа должен быть выше 7-го...";
	}
	else if ($room=="mount" && $level=="forest") {if ($_SESSION["vixod"]==1)$changeroom=true;} # mesheden cixiw
	else if ($level=="mount" && $room=="forest") {if (($db["vaulttime"]-time())<0)$changeroom=true;} # meweye giriw
	else if (in_array($room,array("remesl")) && $level=="znaxar") 
	{
		#znaxara kecid
		if (!is_wear($login))
		{
			if ($db["level"]>=4)$changeroom=true;
			else $mess="Для входа уровень Вашего персонажа должен быть выше 4-го...";
		}
		else $mess="Вход с оружием строго запрещен!!!";
	}
	else if (in_array($room,array("remesl","cave_secret")) && $level=="crypt_go") 
	{
		if ($db["level"]>=8 || $db["adminsite"])
		{
			$changeroom=true;
		}
		else $mess="Для входа уровень Вашего персонажа должен быть выше 8-го";
	}
	else if (in_array($room,array("okraina")) && in_array($level,array("house","academy"))) {$changeroom=true;} 
	else if (in_array($level,array("elka")) && in_array($room,array("okraina"))) 
	{
		if ($db["level"]>=4)
		{
			if (((date(n)==1 && date(j)>=16) || (date(n)==1 && date(j)<=5)) || ((date(n)==8 && date(j)<10) || (date(n)==7 && date(j)>=27)) || $db["adminsite"])$changeroom=true;
			else {$mess="Еще не время!";$changeroom=false;}
		}
		else $mess="Для входа уровень Вашего персонажа должен быть выше 4-го";
	}
	else if (in_array($level,array("novruz")) && in_array($room,array("okraina"))) 
	{
		if ((date(n)==1 && date(j)>=16) || (date(n)==1 && date(j)<=5))
		{	
			$changeroom=true;
		}
		else {$mess="Еще не время!";$changeroom=false;}
	}  
	else if (in_array($room,array("novruz", "novruz_shop")) && in_array($level,array("novruz_go"))) {$changeroom=true;} 
	else if (in_array($room,array("novruz_go")) && in_array($level,array("novruz", "novruz_shop"))) 
	{
		if (!$db['zayava'])$changeroom=true;
	} 
	else if (in_array($room,array("novruz_go")) && $level=="novruz_floor") 
	{
		if ($db['zayava']){$db["room"]="novruz_floor";$changeroom=true;}
	} 
	else if (in_array($room,array("novruz_floor")) && $level=="novruz_go") 
	{
		if (!$db['zayava'])$changeroom=true;
	}
	else if (in_array($room,array("okraina")) && in_array($level,array("nature"))) 
	{
		if ($db["level"]>=7)$changeroom=true;
		else 
		{
			$mess="Для входа на Остров Весеннего Листа Вашего персонажа должен быть выше 7-го";$changeroom=false;
		}
	} 
	else if (in_array($room,array("okraina","castle_hall")) && in_array($level,array("castle"))) 
	{
		if ($db["clan"]!="" || $db["adminsite"])
		{
			$_SESSION["castle"]=0;
			$changeroom=true;
		}
		else 
		{
			$mess="Вход разрешен только для клана";$changeroom=false;
		}
	} 
	else if (in_array($room,array("castle")) && in_array($level,array("castle_hall"))) 
	{
		if ($_SESSION["castle"]==1)$changeroom=true;
		else 
		{
			$mess="Вход разрешен только для клана";$changeroom=false;
		}
	} 
	else if (in_array($level,array("okraina")) && in_array($room,array("house"))) 
	{
		if ($db["son"]==0)$changeroom=true;
		else {$mess="Вы не можете перемещаться во времени сна!";$changeroom=false;}
	} 
	else if (in_array($level,array("okraina")) && in_array($room,array("nature","elka","novruz","castle","academy"))){$changeroom=true;}
	else if (in_array($level,array("led")) && in_array($room,array("elka"))) 
	{
		if ((date(n)==1 && date(j)>=16) || (date(n)==1 && date(j)<=5))
		{	
			$changeroom=true;
		}
		else {$mess="Еще не время!";$changeroom=false;}
	}  	
	else if (in_array($level,array("led")) && in_array($room,array("labirint_led","led_shop"))) {$changeroom=true;}  
	else if (in_array($level,array("elka")) && in_array($room,array("led"))) {$changeroom=true;}  
	else if (in_array($level,array("labirint_led","led_shop")) && in_array($room,array("led"))) 
	{
		if ((date(n)==1 && date(j)>=16) || (date(n)==1 && date(j)<=5) || $db["adminsite"])
		{	
			$changeroom=true;
		}
		else {$mess="Еще не время!";$changeroom=false;}
	}  

	if($db["zayavka"])
	{
		$mess="Вы подали заявку и не можете перемещаться! ";$changeroom=false;
	}
	if(!$db["movable"] && !in_array($db["room"],array("smert_room","towerin","crypt","dungeon","canalization","mount","crypt","crypt_floor2","labirint_led","war_labirint", "novruz", "novruz_go", "novruz_shop", "novruz_floor")))
	{
		$mess="Вы перегружены и не можете перемещаться! ";$changeroom=false;
	}
	if($db["travm_var"]>0 && ($db["hand_r_type"]!="kostyl" || $db["hand_l_type"]!="kostyl") && !in_array($db["room"],array("smert_room","towerin","crypt","dungeon","canalization","mount","crypt","crypt_floor2","labirint_led","war_labirint", "novruz", "novruz_go", "novruz_shop", "novruz_floor")))
	{
		$mess="У вас средняя или тяжелая травма. Вы не можете перемещаться! ";$changeroom=false;
	}
	if ($changeroom)
	{
		mysql_query("UPDATE users,online SET users.room='".$level."', online.room='".$level."' WHERE online.login=users.login and online.login='".$login."'");
		$_SESSION['my_room']=$level;
		$room=$level;
		echo "<script>top.users.go_city();</script>";
	}
	else 
	{	
		if (!$mess) echo "<b style='color:#ff0000'>Вы не можете так пройти.</b>";
		else 	echo "<b style='color:#ff0000'>$mess</b>";
	}
}
//-------------------------------------------------------------------------------------------------
if($act=="inkviz")
{
	include_once ("inkviz.php");
	die();
}
if($act=="otchet")
{
	include_once ("otchet.php");
}
if($act == "inv" && !$db["battle"] && $db["room"]!="house")
{
	include_once ("inv.php");
	die();
}
if($act=="addToSlot" && !$db["battle"] && is_numeric($_GET['id']) && $db["room"]!="house")
{
	set_svitok($db,$_GET['id']);
}
if($act=="setdown_svitok" && !$db["battle"] && is_numeric($_GET['id']) && is_numeric($_GET['slot']) && $db["room"]!="house")
{
	setdown_svitok($db,$_GET['slot'],$_GET['id']);
}
if($act=="wear" && !$db["battle"] && !$db["zayavka"] && is_numeric($_GET['item_id']))
{
	if ($db["room"]!="smert_room" && $db["room"]!="house" && $db["room"]!="zadaniya")
	{
		wear($_SESSION["login"],$_GET['item_id']);
	}
	else 
	{
		$_SESSION["message"]="В этой комнате невозможно одеватся";
		Header("Location: main.php?act=inv");
	}
}
if($act=="unwear" && !$db["battle"] && !$db["zayavka"] && is_numeric($_GET['item_id']))
{
	if ($db["room"]!="smert_room" && $db["room"]!="house" && $db["room"]!="zadaniya")
	{
		unWear($_SESSION["login"],$_GET['item_id']);
	}
	else 
	{
		Header("Location: main.php?act=inv");
	}
}
if($act=="unwear_full" && !$db["battle"] && $db["room"]!="house")
{
	unwear_full($_SESSION["login"]);
}
if($act=="clan" && !$db["battle"] && $db["room"]!="house")
{
	include_once ("clan.php");
	die();
}
if($act=="char" && !$db["battle"] && $db["room"]!="house")
{
	include_once ("char.php");
	die();
}
if($act=="animal" && !$db["battle"] && $db["room"]!="house")
{
	include_once ("animal.php");
	die();
}
if($act=="magic" && !$db["battle"] && $db["room"]!="house")
{
	include_once ("magic.php");
	die();
}
//----------------------------------
if ($db["exp"]>=$db["next_up"])
{	
	testUps($db);
}
//-----------TRAVMA------------------------------------------------------------------------
if($db["travm_stat"]!='')
{
    if($db["travm"]<time())
    {
    	$t_stat = $db["travm_stat"];
		$o_stat = $db["travm_old_stat"];
        mysql_query("UPDATE users SET $t_stat=$t_stat+$o_stat,travm='0', travm_stat='', travm_var='', travm_old_stat='' WHERE login='".$login."'");
        talk($login,"Травма вылечена",$db);
	}
}
//------------------------------------
testPrision($db);
include_once ("room_detect.php");
mysql_close();
?>
<br>