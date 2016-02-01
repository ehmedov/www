<?
include('key.php');
ob_start("@ob_gzhandler");
include ("conf.php");
include ("align.php");
include ("functions.php");
$login=$_SESSION['login'];
$random=md5(time());
$date = date("H:i");
header("Content-Type: text/html; charset=windows-1251");
Header("Cache-Control: no-cache, must-revalidate"); // говорим браузеру что-бы он не кешировал эту страницу
Header("Pragma: no-cache");
?>
<HTML>
<HEAD>	
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<meta http-equiv="Content-Language" content="ru">
	<META Http-Equiv=Cache-Control Content="no-cache, max-age=0, must-revalidate, no-store">
	<meta http-equiv=PRAGMA content=NO-CACHE>
	<meta http-equiv=Expires content=0>	
	<LINK REL=StyleSheet HREF='main.css' TYPE='text/css'>
</HEAD>
<body bgcolor="#faeede" style="margin-top: 0px; margin-right: 0px; margin-bottom: 0px; margin-left: 0px;" onkeyup="set_action();">	
<DIV id="slot_info" style="VISIBILITY: hidden; POSITION: absolute;z-index: 1;"></DIV>
<div id=hint4 name=hint4 style="z-index: 5;"></div>
<SCRIPT LANGUAGE="JavaScript" SRC="scripts/magic-main.js"></SCRIPT>
<SCRIPT language="JavaScript" type="text/javascript" src="show_inf.js"></SCRIPT>
<SCRIPT language="JavaScript" type="text/javascript" src="fight.js"></SCRIPT>
<SCRIPT language="JavaScript" type="text/javascript" src="commoninf.js"></SCRIPT>
<script>var my_login = '<?=$login; ?>';</script>
<div id="mmoves" style="background-color:#FFFFCC; visibility:hidden; z-index: 100; overflow:visible; position:absolute; border-color:#666666; border-style:solid; border-width: 1px; padding: 2px;"></div>
<?
##########################################################################################	
$data = mysql_connect($base_name, $base_user, $base_pass) or die('Не получается подключиться. Проверьте имя сервера, имя пользователя и пароль!');
mysql_select_db($db_name) or die('Ошибка входа в базу данных');

$result = mysql_query("SELECT users.*, zver.id as zver_count, zver.obraz as zver_obraz, zver.level as zver_level, zver.name as zver_name, zver.type as zver_type, (SELECT count(*) FROM inv WHERE inv.owner=users.login and inv.name='Кольцо Атаки' and wear=1)as item_name FROM users LEFT JOIN zver ON zver.owner=users.id and zver.sleep=0 WHERE users.login='".$login."'");
$db = mysql_fetch_array($result);
mysql_free_result($result);

if($db["battle"]==0){Header("Location: main.php?act=none&tmp=$random");	die();}

$creator = $db["battle_pos"];
$opponent = $db["battle_opponent"];
$bid = $db["battle"];
$team = $db["battle_team"];

$P_HDATA = mysql_fetch_array(mysql_query("SELECT hitted, op_ch, team, leader, zayavka.type, zayavka.timeout FROM teams LEFT JOIN zayavka on zayavka.creator=teams.battle_id WHERE battle_id='".$creator."' AND player='".$login."'"));
$battle_timeout=$P_HDATA["timeout"];
$to = $battle_timeout*60;
$_SESSION["my_battle"]=$db["battle"];
$_SESSION["my_creator"]=$db["battle_pos"];

#$B_DATA=mysql_fetch_array(mysql_query("SELECT * FROM battles WHERE id=$bid"));

$query_priem=mysql_fetch_Array(mysql_query("SELECT count(id_person) FROM person_on WHERE id_person=".$db["id"]." and battle_id=$bid"));
if ($query_priem[0]==0)
{
	$q_q=mysql_query("SELECT priem.type, priem.wait FROM slots_priem LEFT JOIN priem on priem.id=slots_priem.priem_id WHERE user_id=".$db["id"]." and priem_id!=0");
	while($qq=mysql_fetch_array($q_q))
	{
		mysql_query("INSERT INTO `person_on` ( `id_person` , `battle_id` , `pr_name` , `pr_active`,`pr_wait_for`,`pr_cur_uses`)VALUES( '".$db["id"]."','".$bid."', '".$qq["type"]."',1,'0',1);");
	}
	if($db["duxovnost"]>=50)
	{
		mysql_query("INSERT INTO `person_on` ( `id_person` , `battle_id` , `pr_name` , `pr_active`,`pr_wait_for`,`pr_cur_uses`) VALUES( '".$db["id"]."','".$bid."', 'voskr',1,'0',1);");
	}
}	

$b = 1;
$winer = 0;
$loser = 0;
//if (!$team)$team=$P_HDATA["team"];

switch ($team)
{
	case 1: $enemy_team=2; break;
	case 2: $enemy_team=1; break;
}

$weapons = array('axe','fail','knife','sword','spear','shot','staff','kostyl');
$shields=array('shield','spear');
$zones=1;
$blockzone=false;
if (in_array($db["hand_r_type"],$weapons) && in_array($db["hand_l_type"],$weapons)){$zones++;}
if ($db["item_name"]>0)$zones++;
if (in_array($db["hand_l_type"],$shields)){$blockzone = true;}
##############################################################################################
if ($_POST["change_leader"] && $P_HDATA["leader"] && $_POST["change_leader"]!=$login && $db["hp"]>0)
{
	$_POST["change_leader"]=htmlspecialchars(addslashes($_POST["change_leader"]));
	$query=mysql_fetch_Array(mysql_Query("SELECT count(*) FROM teams WHERE player='".$_POST["change_leader"]."' and battle_id=$creator and team=$team"));	
	if ($query[0])
	{
		if($team == 1){$span = "p1";}else{$span = "p2";}
		mysql_Query("UPDATE teams SET leader=0 WHERE player='".$login."'");
		mysql_Query("UPDATE teams SET leader=1 WHERE player='".$_POST["change_leader"]."'");
		$P_HDATA["leader"]=0;
		$phrase  = "<span class=sysdate>$date</span> Лидер Команды <span class=$span>".$login."</span> передал лидерство персонажу <span class=$span>".$_POST["change_leader"]."</span><hr>";
		battle_log($bid, $phrase);
	}
	else
	{
		echo "<b style='color:red'>Персонаж не найден или он не вашем бою</b>";
	}
}

if ($_POST["kill_member"] && $P_HDATA["leader"] && $db["hp"]>0)
{
	$_POST["kill_member"]=htmlspecialchars(addslashes($_POST["kill_member"]));
	$kill_mem=mysql_fetch_Array(mysql_Query("SELECT users.id, users.hp, login ,zver.id as zver_count FROM users LEFT JOIN zver on zver.owner=users.id and zver.sleep=0  WHERE login='".$_POST["kill_member"]."'"));
	if ($kill_mem && $kill_mem["id"]!=$db["id"] && $kill_mem["hp"])
	{
		$query=mysql_fetch_Array(mysql_Query("SELECT count(*) FROM teams WHERE player='".$_POST["kill_member"]."' and battle_id=$creator and team=$team"));	
		if ($query[0])
		{
			if($team == 1){$span = "p1";}else{$span = "p2";}
			mysql_Query("UPDATE users SET  battle='0', battle_exit='$bid', zayavka=0, battle_opponent='', battle_pos=0, battle_team=0, fwd='', zver_on=0 WHERE login='".$_POST["kill_member"]."'");
			mysql_query("DELETE FROM teams WHERE player = '".$_POST["kill_member"]."'");
			mysql_query("DELETE FROM battle_units WHERE player = '".$_POST["kill_member"]."'");
			mysql_query("DELETE FROM bot_temp WHERE prototype='".$kill_mem["zver_count"]."'");
			mysql_query("DELETE FROM person_on WHERE id_person='".$kill_mem["id"]."'");
			mysql_query("UPDATE users SET battle_opponent='' WHERE battle_opponent='".$_POST["kill_member"]."'");

			$phrase  = "<span class=sysdate>$date</span> Лидер Команды <span class=$span>".$login."</span> выгнал персонажа <span class=$span>".$_POST["kill_member"]."</span> из боя<hr>";
			battle_log($bid, $phrase);
		}
		else
		{
			echo "<b style='color:red'>Персонаж не найден или он не вашем бою</b>";
		}
	}
	else
	{
		echo "<b style='color:red'>Персонаж не найден</b>";
	}
}
###########################ВЫПУСТИ СВОЕГО ЗВЕРЯ ИЗ КЛЕТКИ######################################
if ($_GET['zver_on']==1 && $db["zver_count"] && !$db["zver_on"] && $db["hp"]>0)
{
	if ($db["bs"]==1)
	{
		 echo "<b style='color:red'>Запрещено использовать зверя в турнире...</b>";
	}
	else
	{	
		if($db["battle_team"] == 1){$span = "p1";}else{$span = "p2";}
		$res=mysql_fetch_array(mysql_Query("SELECT * FROM zver WHERE owner=".$db["id"]." and sleep=0"));
		if ($res["energy"]>0)
		{	
				switch ($res["type"]) 
				{
					 case "wolf":$txt = "(Удача+".($res["level"]).")";break;
					 case "bear":$txt = "(Сила+".($res["level"]).")";break;
				 	 case "cheetah":$txt = "(Ловкость+".($res["level"]).")";break;
				 	 case "snake":$txt = "(Интеллект+".($res["level"]).")";break;
				}

			mysql_query("UPDATE users SET zver_on=1 WHERE login='".$login."'");
			mysql_query("INSERT INTO bot_temp(bot_name,hp,hp_all,battle_id,prototype,team,zver,two_hands) VALUES('".$res["name"]." (зверь ".$login.")','".$res["hp_all"]."','".$res["hp_all"]."','".$bid."','".$res["id"]."','".$db["battle_team"]."','1','".($res["two_hands"]>time()?1:0)."')");
			$db["zver_on"]=1;
			$phrase_zver  = "<span class=date>$date</span> <span class=$span>".$res["name"]." (зверь ".$login.")</span> вмешался в поединок!".($res["level"]>0?" $txt":"")."<hr> ";
			battle_log($bid, $phrase_zver);
		}
		else echo "<b style='color:red'>Ваш зверь голоден и его нужно покормить</b>";
	}
}
###########################Random Hit######################################
if($_GET['act']=="random_hit")
{
	if ($_SESSION["random_hit"])$_SESSION["random_hit"]=0;
	else $_SESSION["random_hit"]=1;
	$_GET['act']="";
}
###########################Считаем, что этого боя не было######################################
if($_GET['act']=="t_draw")
{
	$T_D = mysql_fetch_array(mysql_query("SELECT lasthit FROM battles WHERE id='".$bid."'"));
	$lasthit = $T_D["lasthit"];
	
	$timeout = $lasthit+$to - time();
	if($timeout<0 && $opponent == "")
	{
		lose(1,$bid,11);
		lose(2,$bid,11);
		clearZayavka($creator,$bid);
	}
	else
	{
		$_GET['act']="";
	}
}
###########################Я победил######################################
if($_GET['act']=="t_win")
{
	$T_D = mysql_fetch_array(mysql_query("SELECT lasthit FROM battles WHERE id='".$bid."'"));
	$lasthit = $T_D["lasthit"];
	
	$timeout = $lasthit+$to - time();
	if($timeout < 0 &&  (($db["hp"]>0 && $opponent == '') || $db["hp"]<=0))
	{
		$D = mysql_fetch_array(mysql_query("SELECT win FROM battles WHERE id=".$bid));
	    if ($D["win"]==0)
	    {
	    	mysql_query("UPDATE battles SET win='".$team."' WHERE id=".$bid);
	    	$winer=$team;
	    	$loser=($team==1?2:1);
		    win($winer,$bid);
		    lose($loser,$bid,0);
		    clearZayavka($creator,$bid);
			Header("Location: main.php?act=none&tmp=$random");
			die();
		}
	}
	else
	{
		$_GET['act']="";
	}
}
//-----------------------------exit----------------------------------------------------
if($_GET['act'] == "exit")
{
	$team1_c=0;$team2_c=0;
	$T = mysql_query("SELECT count(*) as c,team FROM teams LEFT JOIN users on users.login=teams.player WHERE teams.battle_id='".$creator."' and users.hp>0 GROUP BY team");
	while ($dat=mysql_fetch_array($T))
	{
		if ($dat['team']==1)$team1_c=$dat['c']; else if ($dat['team']==2)$team2_c=$dat['c'];
	}	
	$BOT = mysql_query("SELECT count(*) as c,team FROM bot_temp WHERE battle_id='".$bid."' and hp>0 group by team");
	while ($BOTD = mysql_fetch_array($BOT))
	{
		if($BOTD["team"]==1)$team1_c=$team1_c+$BOTD["c"]; else if($BOTD["team"]==2)$team2_c=$team2_c+$BOTD["c"];
	}
	//-----------------Winning Team---------------------------------------------
	if($team1_c==0 && $team2_c>0)
	{
		$winer=2;$loser=1;
	}
	if($team2_c==0 && $team1_c>0)
	{
		$winer=1;$loser=2;
	}
	if($winer && $loser)
	{	
		$D = mysql_fetch_array(mysql_query("SELECT win FROM battles WHERE id=".$bid));
	    if ($D["win"]==0)
	    {	
			mysql_query("UPDATE battles SET win=$winer WHERE id=".$bid);
		    win($winer,$bid);
		    lose($loser,$bid,0);
		    clearZayavka($creator,$bid);
			Header("Location: main.php?act=none&tmp=$random");
			die();
		}
	}
	else 
	{
		$_GET['act']="";
	}
}
//---------------------change opponent-----------------------------
if ($_POST["target"]!="" && !$_GET["special"] && $P_HDATA["op_ch"]>0)
{
	$chg_login=htmlspecialchars(addslashes($_POST["target"]));
	$opponents = mysql_query("SELECT player FROM teams as tem  LEFT JOIN users us on us.login=tem.player WHERE tem.battle_id = '".$creator."' and us.hp>0 and tem.player='".$chg_login."' and tem.team=".$enemy_team);
	if (mysql_num_rows($opponents))
	{
    	$opponent_=mysql_fetch_array($opponents);
   		$sl=mysql_query("SELECT * FROM hit_temp WHERE attack='".$opponent_["player"]."' AND defend='".$login."' and battle_id=$bid");
   		if (!mysql_num_rows($sl)) $changed_opp= $opponent_["player"];
	}
	else
	{
		$BLD_ = mysql_query("SELECT * FROM bot_temp WHERE battle_id='".$bid."' and hp>0 and team=$enemy_team and bot_name='".$chg_login."' limit 1");
		if (mysql_num_rows($BLD_))
		{	
			$BLD=mysql_fetch_array($BLD_);
			$sl=mysql_query("SELECT * FROM hit_temp WHERE attack='".$BLD["bot_name"]."' AND defend='".$login."' and battle_id=$bid");
			if (!mysql_num_rows($sl)) $changed_opp=$BLD["bot_name"];
		}
	}
	if ($changed_opp!="")
	{
		$opponent=$changed_opp;
		mysql_query("UPDATE users SET battle_opponent='".$opponent."' WHERE login='".$login."'");
		mysql_Query("UPDATE teams SET op_ch=op_ch-1 WHERE player='".$login."'");
		$P_HDATA["op_ch"]=$P_HDATA["op_ch"]-1;
	}
	else
	{
		echo "<b style='color:red'>Персонаж ".$chg_login." не найден.</b>";
	}
}
//---------------------Count Users and Winning Team------------------------------------------
$team1_c=0;$team2_c=0;
$T = mysql_query("SELECT count(*) as c,team FROM teams LEFT JOIN users on users.login=teams.player WHERE teams.battle_id='".$creator."' and users.hp>0 GROUP BY team");
while ($dat=mysql_fetch_array($T))
{
	if ($dat['team']==1)$team1_c=$dat['c']; else if ($dat['team']==2)$team2_c=$dat['c'];
}

$BOT = mysql_query("SELECT count(*) as c,team FROM bot_temp WHERE battle_id='".$bid."' and hp>0 group by team");
while ($BOTD = mysql_fetch_array($BOT))
{
	if($BOTD["team"]==1)$team1_c=$team1_c+$BOTD["c"]; else if($BOTD["team"]==2)$team2_c=$team2_c+$BOTD["c"];
}
if($team1_c==0 && $team2_c>0)
{
	$winer=2;$loser=1;
}
if($team2_c==0 && $team1_c>0)
{
	$winer=1;$loser=2;
}
if($team1_c==0 && $team2_c==0)
{
	lose(1,$bid,1);
	lose(2,$bid,1);
	clearZayavka($creator,$bid);
}
if($winer && $loser)
{
	$b = 0;
}
########################## Волна ##########################
if ($P_HDATA["type"]==19)
{
	$have_hell=mysql_fetch_Array(mysql_query("SELECT * FROM `hellround_pohod` WHERE `end` = 0 and `owner`=".$db["id"].";"));
	if ($team2_c==0 && $team1_c>0)
	{
		##################################################
		$hp_add=round($db["hp_all"]*0.25);
		$mn_add=round($db["mana_all"]*0.25);
		$new_hp=$db["hp"]+$hp_add;
		if ($new_hp>$db["hp_all"])
		{
			$new_hp=$db["hp_all"];
			$hp_add=$db["hp_all"]-$db["hp"];
		}
		setHP($login,$new_hp,$db['hp_all']);
		if($mn_add>0)
		{
			$new_mn=$db["mana"]+$mn_add;
			if ($new_mn>$db["mana_all"])
			{
				$new_mn=$db["mana_all"];
				$mn_add=$db["mana_all"]-$db["mana"];
			}	
			setMN($login,$new_mn,$db['mana_all']);
		}
		##################################################
		if($db["battle_team"] == 1){$span = "p1";}else{$span = "p2";}
		$phrase_hell  = "<span class=date>".$date."</span> <span class=$span>".$login."</span>, нетрезво оценив положение, решил, что поможет ему только прием <b>Передышка</b> <font color=green><b>+$hp_add HP</b></font> [".$new_hp."/".$db['hp_all']."] ".($mn_add>0?"<font color=blue><b>+$mn_add MN</b></font> [".$new_mn."/".$db['mana_all']."]":"").".<br>";
		battle_log($bid, $phrase_hell);
		##################################################
		$names = array("Бармаглот","Пещерный-Ящер","Повелитель-Бармаглотов", "Угрюмый-Дендроид","Мерцающий-феникс","Сумрачный-Грифон", "Ядерник","Радскорпион","Дикий гул", "Леврета", "Линграонц", "Падший король");
		$names_unikal=array("Темный Линграонц", "Темный Леврета", "Лютый Линграонц", "Лютый Леврета", "Коварная Смотрительница", "Жадный Смотритель", "Осквернитель Хаоса");
		$bot_count=mysql_fetch_Array(mysql_Query("SELECT count(*) FROM `bot_temp` WHERE `battle_id`=$bid and team=2"));
		if ($have_hell["unikal"]==5)
		{
			$bot_u=array();
			if($db["level"]==8){$bot_u[0]=$names_unikal[0];$bot_u[1]=$names_unikal[1];}
			else if($db["level"]==9){$bot_u[0]=$names_unikal[2];$bot_u[1]=$names_unikal[3];}
			else if($db["level"]>=10){$bot_u[0]=$names_unikal[4];$bot_u[1]=$names_unikal[5];$bot_u[2]=$names_unikal[6];}
				
			for ($k=1; $k<=$have_hell["unikal_count"]; $k++)
			{
				$attacked_bot=$bot_u[rand(0,count($bot_u)-1)];
				$GBD = mysql_fetch_array(mysql_query("SELECT hp_all FROM users WHERE login='".$attacked_bot."'"));
				mysql_query("INSERT INTO bot_temp(bot_name, hp, hp_all, battle_id, prototype, team, two_hands, shield_hands) 
				VALUES('".$attacked_bot."(".($bot_count[0]+$k).")','".$GBD["hp_all"]."','".$GBD["hp_all"]."','".$bid."','".$attacked_bot."','2','1','".rand(0,1)."')");
			}
		}
		else
		{
			$bot_h=array();
			if($db["level"]==8){$bot_h[0]=$names[0];$bot_h[1]=$names[1];$bot_h[2]=$names[2];}
			else if($db["level"]==9){$bot_h[0]=$names[3];$bot_h[1]=$names[4];$bot_h[2]=$names[5];}
			else if($db["level"]==10){$bot_h[0]=$names[6];$bot_h[1]=$names[7];$bot_h[2]=$names[8];}
			else if($db["level"]>=11){$bot_h[0]=$names[9];$bot_h[1]=$names[10];$bot_h[2]=$names[11];}
			for ($i=1; $i<=3; $i++)
			{
				$attacked_bot=$bot_h[rand(0,count($bot_h)-1)];
				$GBD = mysql_fetch_array( mysql_query("SELECT hp_all FROM users WHERE login='".$attacked_bot."'"));
				mysql_query("INSERT INTO bot_temp(bot_name, hp, hp_all, battle_id, prototype, team, two_hands, shield_hands) 
				VALUES('".$attacked_bot."(".($i+$bot_count[0]).")','".$GBD["hp_all"]."','".$GBD["hp_all"]."','".$bid."','".$attacked_bot."','2','1','".rand(0,1)."')");
			}
		}
		if($have_hell["volna"]>=30) $have_unikal=5;
		else if($have_hell["volna"]>=25) $have_unikal=rand(4,5);
		else if($have_hell["volna"]>=20) $have_unikal=rand(3,5);
		else if($have_hell["volna"]>=10) $have_unikal=rand(2,5);
		else $have_unikal=rand(1,7);
		
		
		mysql_Query("UPDATE hellround_pohod SET volna=volna+1, unikal='".$have_unikal."' ".($have_unikal==5?",unikal_count=unikal_count+1":"")." WHERE id='".$have_hell["id"]."'");
		$have_hell["volna"]=$have_hell["volna"]+1;
		$have_hell["unikal"]==$have_unikal;
		$b=1;
	}
	$hell_str="<table width=100%><tr align=center><td><b style='color:#ff0000'>Волна №".$have_hell["volna"].($have_hell["unikal"]==5?"<br>Приближается нечто...":"")."</b></td></tr></table>";
}

##########################ЗАПРОС НА ИСПОЛЬЗОВАНИЕ ПРИЕМОВ##########################
if ($_GET['special'] && $b==1)
{
	include ("inc/battle/usepriems.php");
}
####################################################################################
if($opponent == "" && $b == 1){$opponent=getNextEnemy($login,$enemy_team,$creator,$bid);}
#######################Hit Personaj###################################################
if($_GET['act'] == "hit" && $db['hp']>0 && $b==1 && $opponent!="")
{	
	$hit1=0;
	$hit2=0;
	$hit3=0;
	$blok=0;
	if(!$_SESSION["random_hit"])
	{
		$hit1=(int)$_POST['attack0'];
		$hit2=(int)$_POST['attack1'];
		$hit3=(int)$_POST['attack2'];
		$blok=(int)$_POST['defend'];
	}
	else
	{
		$hit1=mt_rand(1,5);
		$hit2=mt_rand(1,5);
		$hit3=mt_rand(1,5);
		$blok=mt_rand(1,5);
	}
    if ($hit1 && (($zones==2 && $hit2) || ($zones==3 && $hit2 && $hit3) || ($zones==1)) && $blok)
    {
    	hit($login,$opponent,$hit1,$hit2,$hit3,$blok,$bid,0);
		Header("Location: battle.php?tmp=$random");
    	die();
    }
}
########################################################################################
?>
<TABLE border=0 width=100% cellpadding=0 cellspacing=0>
<TR>
<TD WIDTH=260 VALIGN=TOP ALIGN=LEFT nowrap>
	<?
		include_once("inc/battle/left.php");
	?>
</TD>
<TD width=100% valign=top align=center nowrap>
<FORM action="battle.php?act=hit&<?=$random?>" method="POST" name="f1" id="f1">
<b style='color:#ff0000' id='messid'></b>
<?
#########################Use Magic##############################################
if($_GET['act'] == "magic1" && $b == 1)
{
	if ($db["bs"]==1)
	{
		 echo "<script>errmess('Запрещено использовать заклятия в турнире');</script>";
	}
	else
	{
		$slot=(int)$_GET['slot'];
		$id=(int)$_GET['id'];
		$GET_DAT = mysql_query("SELECT scroll.name, scroll.mtype, scroll.min_vospriyatie, scroll.min_intellekt, scroll.min_level, scroll.orden, scroll.mana, scroll.school, scroll.files FROM inv LEFT JOIN scroll on scroll.id=inv.object_id WHERE inv.id='".$id."' and inv.owner='".$login."' and object_type='scroll'");
		$SCROLL_DATA = mysql_fetch_array($GET_DAT);
		if ($SCROLL_DATA)
		{
		    $name = $SCROLL_DATA["name"];
		    $mtype = $SCROLL_DATA["mtype"];
		    $min_v = $SCROLL_DATA["min_vospriyatie"];
		    $min_i = $SCROLL_DATA["min_intellekt"];
		    $min_l = $SCROLL_DATA["min_level"];
		    $orden = $SCROLL_DATA["orden"];
		    $mana = $SCROLL_DATA["mana"];
		    $school = $SCROLL_DATA["school"];
		    $files = $SCROLL_DATA["files"];
			if($orden)
		    {
	            if($orden == $db["orden"])
	            {
	            	$ordens = 1;
	            }
	            else
	            {
	            	$ordens = 0;
	            }
		    }
		    else
		    {
		    	$ordens = 1;
		    }
			if($db["intellekt"]>=$min_i && $db["vospriyatie"]>=$min_v && $db["level"]>=$min_l && $ordens == 1 && $db["mana"]>=$mana)
			{
	        	include ("magic/$files");
	        	//$opponent=getNextEnemy($login,$enemy_team,$creator,$bid);
	        	Header("Location: battle.php?tmp=$random");
			}
			else
		    {
			    echo "<script>errmess('У Вас недостаточно параметров для кастования этого заклятия!');</script>";
			    $_GET['act']="";
		    }
		}
	}
}
########################################################################################
echo "<table cellspacing='0' border=0 cellpadding='0' align=center>";
echo "<tr><td align=center>";
	for ($i=100;$i<=111;$i++)
	{
	    showpic($db,$i,4);
	}
	unset($i);
echo "</td></tr>";
echo "</table>";
$T_D = mysql_fetch_array(mysql_query("SELECT * FROM battles WHERE id='".$bid."'"));
$lasthit = $T_D["lasthit"];

########################################################################################
if ($b==1)
{
	if ($db["hp"]<=0)
	{
		if ($lasthit+$to+10*60 <time())	{Header("Location: battle.php?act=t_win&tmp=$random");die();}
		echo "<b style='color:#ff0000'>Для вас бой окончен. Ожидаем пока закончат и другие игроки....</b><BR>
		<input type=button value='Обновить' name='refresh' id='refresh' class='inup' onClick=\"location.href='battle.php'\">";
	}
	else
	{
		################################PROPUSTIT########################################
		$auto=mysql_query("SELECT hit_temp.*, (SELECT count(*) FROM online WHERE login=hit_temp.attack) as is_online FROM hit_temp LEFT JOIN users on users.login=hit_temp.attack WHERE hit_temp.defend='".$login."' and hit_temp.battle_id='".$bid."' and users.hp>0");
		while ($auto_hit=mysql_fetch_array($auto))
		{
			if ($auto_hit["is_online"])
			{	
				if (($auto_hit['time']+$to-5)<time())
				{
					if ($team==1)$span = "p2";else $span = "p1";
					if ($zones==1) 
					{
						hit_dis($login,$auto_hit['attack'],"00",0,$auto_hit['def_hit1'],0,0,$auto_hit['def_block1'],$bid);
					}
					else if ($zones==2)
					{
						hit_dis($login,$auto_hit['attack'],"00",0,$auto_hit['def_hit1'],0,0,$auto_hit['def_block1'],$bid);
						hit_dis($login,$auto_hit['attack'],"00",0,$auto_hit['def_hit2'],1,0,$auto_hit['def_block1'],$bid);
					}
					else if ($zones==3)
					{
						hit_dis($login,$auto_hit['attack'],"00",0,$auto_hit['def_hit1'],0,0,$auto_hit['def_block1'],$bid);
						hit_dis($login,$auto_hit['attack'],"00",0,$auto_hit['def_hit2'],1,0,$auto_hit['def_block1'],$bid);
						hit_dis($login,$auto_hit['attack'],"00",0,$auto_hit['def_hit3'],0,0,$auto_hit['def_block1'],$bid);
					}
					mysql_query("DELETE FROM hit_temp WHERE defend='".$login."' and attack='".$auto_hit['attack']."'");
					mysql_query("UPDATE battles SET lasthit='".time()."' WHERE id=$battle_id");
					$phrase="<span class=date >$date</span> <b class='$span'>".$auto_hit['attack']."</b> пропустил свой ход.<br><hr>";
					battle_log($bid, $phrase);
				}
			}
		}
		mysql_free_result($auto);
		###########################################################################
		if($opponent!="")
		{
			if(empty($_GET['act']) || $_GET['act'] == "hit")
		    {
		    	if (!$_SESSION["random_hit"])
		    	{
					echo "
					<TABLE cellspacing=0 style='border:1px solid;border-color:#CEBBAA' cellpadding=0 width=400 id=\"f1t\">
					<tr height=15>
						<td align='center' class='l2'>
							<B>Атака</B>
						</td>
						<td align='center' class='l2'>
							<B>Защита</B><BR>
						<td>
					</tr>

					<tr>
						<td>
							<SCRIPT>attacks=".$zones."; DrawDots(1);</SCRIPT>
						</td>
						<td>
							<SCRIPT>block_num=".($blockzone?'3':'2').";DrawDots(0);</SCRIPT>
						</td>
					</tr>
							
					<tr bgcolor='#CEBBAA'>
						<td colspan=2>
							<table width=100% cellspacing=0 cellpadding=0 border=0>
							<tr>
								<td width=100>&nbsp;</td>
								<td>
									<SCRIPT>DrawButtons();</SCRIPT>
								</td>
								<td width=100 align=right>
									<img src=\"img/icon/refresh.png\" onclick='window.location.href=\"battle.php?tmp=\"+Math.random();\"\"' style=\"cursor:hand\" alt=\"Обновить\" border=0>&nbsp;";
									if ($P_HDATA["op_ch"]>0)echo "<img src=\"img/icon/ok.png\" onclick=\"JavaScript:findlogin('Прочитать это заклинание','battle.php', 'target', '', '4')\" style=\"cursor:hand\" alt=\"Сменить  противника\"  border=0>";
								echo "</td>
							</tr>
							</table>
						</td>
					</tr>
					</TABLE>";
				}
				else
				{
					echo "<br>
						<TABLE cellspacing=0 style='border:1px solid;border-color:#CEBBAA' cellpadding=0 width=400 id=\"f1t\">
						<tr class='l2'>
						<td colspan=2>
							<table width=100% cellspacing=0 cellpadding=0 border=0>
							<tr>
								<td width=100>&nbsp;</td>
								<td align=center>
									<INPUT TYPE=submit name=\"let_attack\" id=\"let_attack\" style=\"border: #000000 1px solid;\" value=\"Случайный Удар\">
								</td>
								<td width=100 align=right>
									<img src=\"img/icon/refresh.png\" onclick='window.location.href=\"battle.php?tmp=\"+Math.random();\"\"' style=\"cursor:hand\" alt=\"Обновить\" border=0>&nbsp;";
									if ($P_HDATA["op_ch"]>0)echo "<img src=\"img/icon/ok.png\" onclick=\"JavaScript:findlogin('Прочитать это заклинание','battle.php', 'target', '', '4')\" style=\"cursor:hand\" alt=\"Сменить  противника\"  border=0>";
								echo "</td>
							</tr>
							</table>
						</td>
					</tr>
					</TABLE>";
					if ($_SESSION["random_hit"])echo "<script>document.getElementById(\"let_attack\").focus();</script>";
				}
			}
		}
		else
		{
			$timeout = $lasthit+$to - time();
			$minutes_l = floor($timeout/60);
			$seconds_l = $timeout - $minutes_l*60;
	        if($timeout>0)
	        {
	            echo "
	            Ожидаем хода противника... <br>До таймаута осталось <B style='color:#333399'>".$minutes_l." мин. ".$seconds_l." сек.</B><BR>
	            <input type='button' value='Обновить' name='refresh' id='refresh' class='inup' onClick=\"location.href='battle.php?tmp=$random'\">";
	            $_SESSION["battle_ref"] = 0;
	        }
	        else
	        {
				echo "
				<input type='button' value='Обновить' name='refresh' id='refresh' style='cursor:hand' onClick=\"location.href='battle.php?tmp=$random'\"><br>
				Противник долго не делает свой ход, вы можете закончить бой победителем<br>
				<input type=button value='Да, я победил!!!' style='cursor:hand' onClick=\"location.href='battle.php?act=t_win&tmp=$random'\"><br>
				или признать ничью<br>
				<input type=button value='Считаем, что этого боя не было' style='cursor:hand' onClick=\"location.href='battle.php?act=t_draw&tmp=$random'\">";
	        }
		}
	}
	###########################################################################
	echo '<br><a href="battle.php?act=random_hit&tmp='.$random.'">Случайный Удар</a>: '.($_SESSION["random_hit"]?'<b style="color:#008080">On</b>':'<b>Off</b>');

	###########################################################################
	$aktiv_p = mysql_query("SELECT * FROM slots_priem LEFT JOIN priem on priem.id=slots_priem.priem_id WHERE user_id=".$db["id"]." ORDER BY sl_name ASC");
	if (mysql_num_rows($aktiv_p))
	{	
		$udarlar=mysql_fetch_array(mysql_query("SELECT * FROM battle_units WHERE player='".$login."' and battle_id='".$bid."'"));
		echo "<br><script>DrawRes(".(0+$udarlar['hit']).", ".(0+$udarlar['krit']).", ".(0+$udarlar['uvarot']).", ".(0+$udarlar['block']).", ".(0+$udarlar['hp']).",".(0+$udarlar['counter']).",".(0+$udarlar['parry']).");</script>";

		WHILE($aktiv_priem = mysql_fetch_array($aktiv_p))
		{
			if ($aktiv_priem["priem_id"]!=0)
			{
				$enable=true;
				$per_on=mysql_fetch_array(mysql_query("SELECT pr_wait_for, pr_cur_uses,pr_active FROM person_on WHERE id_person='".$db["id"]."' and pr_name='".$aktiv_priem["type"]."' and battle_id='".$bid."'"));
				$can_use=checkbattlehars((int)$aktiv_priem["hit"],(int)$aktiv_priem["krit"],(int)$aktiv_priem["block"],(int)$aktiv_priem["uvarot"],(int)$aktiv_priem["hp"],(int)$aktiv_priem["all_hit"],(int)$aktiv_priem["parry"],(int)$udarlar["hit"],(int)$udarlar["krit"],(int)$udarlar["block"],(int)$udarlar["uvarot"],(int)$udarlar["hp"],(int)$udarlar["counter"],(int)$udarlar["parry"]) ;
				if ($can_use) 
				{
					if ($per_on["pr_wait_for"]) 
					{
						if ($per_on["pr_wait_for"]>0) 
						{
							$enable=false;
						}
	                    if ($per_on["pr_active"]!=1 && $per_on["pr_cur_uses"]<=1) {$enable=false;}
					}
					else
					{
						if ($per_on["pr_active"]!=1 && $per_on["pr_cur_uses"]<=1) {$enable=false;}
					}
				}
				else
				{
					$enable=false;
				}
				echo "\n<script>print_priems(".($enable?'1':'0').",'".$aktiv_priem["id"]."', '".$aktiv_priem["type"]."','".$aktiv_priem["target"]."', '[".$aktiv_priem["hit"].",".$aktiv_priem["krit"].",".$aktiv_priem["block"].",".$aktiv_priem["uvarot"].",".$aktiv_priem["hp"].",".$aktiv_priem["all_hit"].",".$aktiv_priem["parry"]."]', '".$aktiv_priem["name"]."', '".$aktiv_priem["about"].($per_on["pr_wait_for"]>0?"<br>Задержка: ".$per_on["pr_wait_for"]:"")."');</script>";
			}
			else echo "\n<img src='img/priem/misc/clear.gif'>";
		}
		########################
		$per_on=mysql_fetch_array(mysql_query("SELECT pr_wait_for, pr_cur_uses, pr_active, priem.* FROM person_on LEFT JOIN priem ON priem.type=person_on.pr_name WHERE id_person='".$db["id"]."' and pr_name='voskr' and battle_id='".$bid."'"));
		if ($per_on)
		{
			$enable=true;
			$can_use=checkbattlehars((int)$per_on["hit"],(int)$per_on["krit"],(int)$per_on["block"],(int)$per_on["uvarot"],(int)$per_on["hp"],(int)$per_on["all_hit"],(int)$per_on["parry"],(int)$udarlar["hit"],(int)$udarlar["krit"],(int)$udarlar["block"],(int)$udarlar["uvarot"],(int)$udarlar["hp"],(int)$udarlar["counter"],(int)$udarlar["parry"]) ;
			if ($can_use) 
			{
				if ($per_on["pr_wait_for"]) 
				{
					if ($per_on["pr_wait_for"]>0) 
					{
						$enable=false;
					}
	                if ($per_on["pr_active"]!=1 && $per_on["pr_cur_uses"]<=1) {$enable=false;}
				}
				else
				{
					if ($per_on["pr_active"]!=1 && $per_on["pr_cur_uses"]<=1) {$enable=false;}
				}
			}
			else
			{
				$enable=false;
			}
			echo "\n<script>print_priems(".($enable?'1':'0').",'".$per_on["id"]."', '".$per_on["type"]."','".$per_on["target"]."', '[".$per_on["hit"].",".$per_on["krit"].",".$per_on["block"].",".$per_on["uvarot"].",".$per_on["hp"].",".$per_on["all_hit"].",".$per_on["parry"]."]', '".$per_on["name"]."', '".$per_on["about"].($per_on["pr_wait_for"]>0?"<br>Задержка: ".$per_on["pr_wait_for"]:"")."');</script>";
		}
	}
	########################
	echo "<br>";
	if ($db["zver_count"])
	{
		echo (!$db["zver_on"]?"<a href='?zver_on=1'><img src='img/animal/animal.gif' alt='Выпусти своего зверя из клетки'></a>":"<img src='img/animal/animal.gif' style='filter:gray();' alt='Зверь выпущен'>");
	}
	if ($P_HDATA["leader"])
	{
		echo " <img src='img/battletype/leader.gif' title='Передать лидерство' onclick=\"findlogin( 'Передать лидерство','battle.php', 'change_leader','','4');\" style='cursor:hand;'> <img src='img/battletype/exit.gif' title='Выкинуть из боя' onclick=\"findlogin( 'Выкинуть из боя','battle.php', 'kill_member','','4');\" style='cursor:hand;'>";
	}	
}
else
{
	#########################Win or Lose#############################################
	if($team == $winer)
	{
		echo "<img src='img/index/win.gif'> <b style='color:#ff0000'>Бой окончен. Вы победили.</b><BR>";
	}
	else
	{
		echo "<img src='img/index/blose.gif'> <b style='color:#ff0000'>Бой окончен. Вы проиграли.</b><BR>";
	}
	echo "<input type=button value='Вернуться' class=inup onClick=\"location.href='battle.php?act=exit&tmp=$random'\">";
}
echo "</FORM>";
?>
</TD>
<TD VALIGN=TOP width=260 ALIGN=right nowrap>
	<?
		if($opponent && $db["hp"]>0)
		{
			include_once("inc/battle/right.php");
		}
		else if($winer!=0 && $loser!=0)
		{ 
	        if($team == $winer)
	        {
	            echo "<img src=img/battle/win.gif border=0>";
	        }
	        else
	        {
				echo "<img src=img/battle/lose.gif border=0>";
	        }
		}
		else echo "<img src=img/battle/".rand(1,109).".jpg border=0>";
	?>
</TD>
</TR>
</TABLE>
		
<table width=100% cellpadding=0 cellspacing=0 border=0>
<tr>
<td>
<?
	//------------------------SHOW BATTLE USERS------------------------------------------  
	if($b == 1)
	{
		$fighters1="";	$fighters2="";
		$sql_fighters="(SELECT login, orden, admin_level, dealer, clan_short, clan, hp, hp_all, teams.team, teams.leader, (SELECT count(*) FROM hit_temp WHERE hit_temp.attack='".$login."' and hit_temp.defend=teams.player and hit_temp.battle_id=".$bid.") AS is_hit FROM teams LEFT JOIN users on users.login=teams.player WHERE users.hp>0 and teams.battle_id=".$creator.") 
						UNION 
						(SELECT bot_temp.bot_name, orden, admin_level, dealer, clan_short, clan, bot_temp.hp, bot_temp.hp_all, bot_temp.team,0, (SELECT count(*) FROM hit_temp WHERE hit_temp.attack = '".$login."' AND hit_temp.defend = bot_temp.bot_name AND hit_temp.battle_id=".$bid.") AS is_hit FROM bot_temp LEFT JOIN users on users.login=bot_temp.prototype WHERE bot_temp.battle_id=$bid and bot_temp.zver=0 and bot_temp.hp>0) 
						UNION 
						(SELECT bot_temp.bot_name, zver.orden, zver.admin_level, zver.dealer, zver.clan_short, zver.clan, bot_temp.hp, bot_temp.hp_all, bot_temp.team, 0, (SELECT count(*) FROM hit_temp WHERE hit_temp.attack = '".$login."' AND hit_temp.defend = bot_temp.bot_name AND hit_temp.battle_id=$bid) AS is_hit FROM bot_temp LEFT JOIN zver on zver.id=bot_temp.prototype WHERE bot_temp.battle_id=$bid and bot_temp.zver=1 and bot_temp.hp>0)";
		//if ($login=="tobu")echo $sql_fighters;
		$counts1=0;
		$counts1=0;
		$battle_units=mysql_query($sql_fighters);
		while ($ss=mysql_fetch_array($battle_units))
		{
			if ($ss['team']==1) 
			{
				$fighters1.=($counts1>0?", ":"")."<script>drbt('".$ss['login']."','".$ss['dealer']."','".$ss['orden']."','".$ss['admin_level']."','".$ss['clan_short']."','".$ss['clan']."','".$ss['hp']."','".$ss['hp_all']."','p1','".$ss['is_hit']."');</script>".($ss['leader']?"<img src='img/leader/1.gif' title='Лидер Команды 1'>":"");
				$counts1++;
			}
			else 
			{
				$fighters2.=($counts2>0?", ":"")."<script>drbt('".$ss['login']."','".$ss['dealer']."','".$ss['orden']."','".$ss['admin_level']."','".$ss['clan_short']."','".$ss['clan']."','".$ss['hp']."','".$ss['hp_all']."','p2','".$ss['is_hit']."');</script>".($ss['leader']?"<img src='img/leader/2.gif' title='Лидер Команды 2'>":"");
				$counts2++;
			}
		}
		mysql_free_result($battle_units);
		echo "<table width=100%><tr align=center><td >".$fighters1." <B style=color:#ff0000>против</B> ".$fighters2."<hr></td></tr></table>";
	}
	//------------------------------------------------------------------ 
	echo "$hell_str<table width=100%><tr><td>На данный момент вами нанесено урона: <B>".(int)$P_HDATA["hitted"]." HP.</B></td><td align=right><a href='log.php?log=".$bid."' class=us2 target=_newlog>лог боя »»</a><br>(Бой идет с таймаутом ".$battle_timeout." мин.)</td></tr></table>";
	//------------------------------------------------------------------ 
	//include_once('battext.php');
	include_once('battle_log.php');
	mysql_close();
	?>
  </TD>
 </TR>
</TABLE>
<script>
		//if (document.getElementById("refresh"))document.getElementById("refresh").focus();
</script>
</HTML>