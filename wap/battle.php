<?
ob_start();
include ("key.php");
include ("conf.php");
include ("functions.php");
include ("align.php");

header("Content-type: text/html; charset=windows-1251");
header("Cache-Control: no-cache, must-revalidate"); // говорим браузеру что-бы он не кешировал эту страницу
header("Pragma: no-cache");

echo '<?xml version="1.0" encoding="windows-1251"?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.2//EN" "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="en">';

$login=$_SESSION['login'];
$random=md5(time());
$date = date("H:i");
?>
<html>
<head>
	<title>WAP.MEYDAN.AZ</title>
	<link rel="stylesheet" href="main.css" type="text/css"/>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
	<meta http-equiv="Content-Language" content="ru" />
	<meta name="Description" content="Отличная RPG онлайн игра посвященная боям и магии. Тысячи жизней, миллионы смертей, два бога, сотни битв между Светом и Тьмой." />
	<meta http-equiv="cache-control" content="no-cache" />
	<meta http-equiv="pragma" content="no-cache" />
	<meta http-equiv="expires" content="0" />
	<?if ($_GET["act"]!="view_magic") echo '<meta http-equiv="refresh" content="15;url=battle.php?tmp='.$random.'">';?>
</head>
<body>
<div id="cnt" class="content">	
<?
##########################################################################################	
$data = mysql_connect($base_name, $base_user, $base_pass) or die('Не получается подключиться. Проверьте имя сервера, имя пользователя и пароль!');
mysql_select_db($db_name) or die('Ошибка входа в базу данных');

$db = mysql_fetch_array(mysql_query("SELECT users.*, zver.id as zver_count, zver.obraz as zver_obraz, zver.level as zver_level, zver.name as zver_name, zver.type as zver_type, (SELECT count(*) FROM inv WHERE inv.owner=users.login and inv.name='Кольцо Атаки' and wear=1)as item_name FROM users LEFT JOIN zver ON zver.owner=users.id and zver.sleep=0 WHERE users.login='".$login."'"));
if($db["battle"]==0){Header("Location: main.php?act=none&tmp=$random");	die();}

$creator = $db["battle_pos"];
$opponent = $db["battle_opponent"];
$bid = $db["battle"];
$team = $db["battle_team"];
include("inc/battle/battle_ajax.php");
$P_HDATA = mysql_fetch_array(mysql_query("SELECT hitted, op_ch, team, leader, zayavka.type, zayavka.timeout FROM teams LEFT JOIN zayavka on zayavka.creator=teams.battle_id WHERE battle_id='".$creator."' AND player='".$login."'"));
$battle_timeout=$P_HDATA["timeout"];
$to = $battle_timeout*60;
$_SESSION["my_battle"]=$db["battle"];
$_SESSION["my_creator"]=$db["battle_pos"];

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
		mysql_query("INSERT INTO `person_on` ( `id_person` , `battle_id` , `pr_name` , `pr_active`,`pr_wait_for`,`pr_cur_uses`) 
		VALUES( '".$db["id"]."','".$bid."', 'voskr',1,'0',1);");
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
		echo "<b style='color:#ff0000'>Персонаж не найден или он не вашем бою</b>";
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
			echo "<b style='color:#ff0000'>Персонаж не найден или он не вашем бою</b>";
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
		 echo "<b style='color:#ff0000'>Запрещено использовать зверя в турнире...</b>";
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
		else echo "<b style='color:#ff0000'>Ваш зверь голоден и его нужно покормить</b>";
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
		echo "<b style='color:#ff0000'>Персонаж ".$chg_login." не найден.</b>";
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
	$hell_str="<b style='color:#ff0000'>Волна №".$have_hell["volna"].($have_hell["unikal"]==5?"<br>Приближается нечто...":"")."</b><br/>";
}

##########################ЗАПРОС НА ИСПОЛЬЗОВАНИЕ ПРИЕМОВ##########################
if ($_GET['special'] && $b==1)
{
	include ("inc/battle/usepriems.php");
}
####################################################################################
if(($opponent == "" || $_GET["act"]=="change_opponent")&& $b == 1){$opponent=getNextEnemy($login,$enemy_team,$creator,$bid);$_GET['act']="";}
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

#########################Use Magic##############################################
if($_GET['act'] == "magic" && $b == 1)
{
	if ($db["bs"]==1)
	{
		 $msg="Запрещено использовать заклятия в турнире";
	}
	else
	{
		$slot=(int)$_GET['slot'];
		$id=(int)$_GET['id'];
		$SCROLL_DATA = mysql_fetch_array(mysql_query("SELECT scroll.name, scroll.mtype, scroll.min_vospriyatie, scroll.min_intellekt, scroll.min_level, scroll.orden, scroll.mana, scroll.school, scroll.files FROM inv LEFT JOIN scroll on scroll.id=inv.object_id WHERE inv.id='".$id."' and inv.owner='".$login."' and object_type='scroll'"));
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
	        	$opponent=getNextEnemy($login,$enemy_team,$creator,$bid);
	        	Header("Location: battle.php?tmp=$random");
			}
			else
		    {
			    $msg="У Вас недостаточно параметров для кастования этого заклятия!";
			    $_GET['act']="";
		    }
		}
	}
}
########################################################################################
echo "
<div class='aheader'>
<b style='color:#ff0000'>".$msg.$_SESSION["message"]."</b><br/>";
$_SESSION["message"]="";
if ($hell_str)echo "$hell_str<br/>";
echo "Нанесено урона: <b>".(int)$P_HDATA["hitted"]." HP.</b> [<a href='log.php?log=".$bid."'>лог боя »»</a>]<br/>(таймаут: ".$battle_timeout." мин.)<br/>";
echo "[<a href='battle.php?tmp=$random'>Обновить</a>]<br/><br/>";
//------------------------SHOW BATTLE USERS------------------------------------------  
if($b == 1)
{
	$fighters1="";	$fighters2="";
	$sql_fighters="(SELECT login, level, orden, admin_level, dealer, clan_short, clan, hp, hp_all, teams.team, teams.leader, (SELECT count(*) FROM hit_temp WHERE hit_temp.attack='".$login."' and hit_temp.defend=teams.player and hit_temp.battle_id=".$bid.") AS is_hit FROM teams LEFT JOIN users on users.login=teams.player WHERE users.hp>0 and teams.battle_id=".$creator.") 
					UNION 
					(SELECT bot_temp.bot_name, level, orden, admin_level, dealer, clan_short, clan, bot_temp.hp, bot_temp.hp_all, bot_temp.team,0, (SELECT count(*) FROM hit_temp WHERE hit_temp.attack = '".$login."' AND hit_temp.defend = bot_temp.bot_name AND hit_temp.battle_id=".$bid.") AS is_hit FROM bot_temp LEFT JOIN users on users.login=bot_temp.prototype WHERE bot_temp.battle_id=$bid and bot_temp.zver=0 and bot_temp.hp>0) 
					UNION 
					(SELECT bot_temp.bot_name, level, zver.orden, zver.admin_level, zver.dealer, zver.clan_short, zver.clan, bot_temp.hp, bot_temp.hp_all, bot_temp.team, 0, (SELECT count(*) FROM hit_temp WHERE hit_temp.attack = '".$login."' AND hit_temp.defend = bot_temp.bot_name AND hit_temp.battle_id=$bid) AS is_hit FROM bot_temp LEFT JOIN zver on zver.id=bot_temp.prototype WHERE bot_temp.battle_id=$bid and bot_temp.zver=1 and bot_temp.hp>0)";
	//if ($login=="tobu")echo $sql_fighters;
	$counts1=0;
	$counts1=0;
	$battle_units=mysql_query($sql_fighters);
	while ($ss=mysql_fetch_array($battle_units))
	{
		if ($ss['team']==1) 
		{
			$fighters1.=($counts1>0?", ":"").drbt($ss['login'], $ss['id'], $ss['level'], $ss['dealer'],  $ss['orden'], $ss['admin_level'], $ss['clan'], $ss['clan_short'], $ss['hp'], $ss['hp_all'], 'p1');
			$counts1++;
		}
		else 
		{
			$fighters2.=($counts2>0?", ":"").drbt($ss['login'], $ss['id'], $ss['level'], $ss['dealer'],  $ss['orden'], $ss['admin_level'], $ss['clan'], $ss['clan_short'], $ss['hp'], $ss['hp_all'], 'p2');
			$counts2++;
		}
	}
	mysql_free_result($battle_units);
	echo $fighters1." <b style='color:#ff0000'>против</b> ".$fighters2;
}
echo "<div class=\"sep1\"></div><div class=\"sep2\"></div>";
echo "<form action='battle.php?act=hit&<?=$random?>' method='post'>";
########################################################################################
$T_D = mysql_fetch_array(mysql_query("SELECT * FROM battles WHERE id='".$bid."'"));
$lasthit = $T_D["lasthit"];
########################################################################################
if ($b==1)
{
	if ($db["hp"]<=0)
	{
		if ($lasthit+$to+10*60 <time())	{Header("Location: battle.php?act=t_win&tmp=$random");die();}
		echo "<b style='color:#ff0000'>Для вас бой окончен. Ожидаем пока закончат и другие игроки....</b><br/>";
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
		###########################Use Magic######################################
		if($_GET['act']=="view_magic")
		{
			for ($i=100;$i<=111;$i++)
			{
			    showpic($db,$i,4);
			}
			unset($i);
		}
		###########################################################################
		if($opponent!="")
		{
			echo "<br/><b>Противник</b> - $opponent<br/>[<a href='?act=change_opponent'>Сменит противника</a>]<br/>";

			if(empty($_GET['act']) || $_GET['act'] == "hit")
		    {
		    	if (!$_SESSION["random_hit"])
		    	{
					echo '
						<b>Атака</b><br/>
						<select name="attack0" class="inup">
							<option value="1">Голова</option>
							<option value="2">Грудь</option>
							<option value="3">Живот</option>
							<option value="4">Пояс</option>
							<option value="5">Ноги</option>
						</select>
						<br/><br/>';
						if ($zones>1)
						echo '
						<select name="attack1" class="inup">
							<option value="1">Голова</option>
							<option value="2">Грудь</option>
							<option value="3">Живот</option>
							<option value="4">Пояс</option>
							<option value="5">Ноги</option>
						</select><br/><br/>';
						if ($zones>2)
						echo '
						<select name="attack2" class="inup">
							<option value="1">Голова</option>
							<option value="2">Грудь</option>
							<option value="3">Живот</option>
							<option value="4">Пояс</option>
							<option value="5">Ноги</option>
						</select><br/><br/>';
						
						echo '<b>Защита</b><br/>
						<select name="defend" class="inup">';
						if (!$blockzone)
						echo '
							<option value="1">Голова и Грудь</option>
							<option value="2">Грудь и Живот</option>
							<option value="3">Живот и Пояс</option>
							<option value="4">Пояс и Ноги</option>
							<option value="5">Ноги и Голова</option>';
						else 
						echo '
							<option value="1">Голова, Грудь и Живот</option>
							<option value="2">Грудь, Живот и Пояс</option>
							<option value="3">Живот, Пояс и Ноги</option>
							<option value="4">Пояс, Ноги и Голова</option>
							<option value="5">Ноги, Голова и Грудь</option>';
						echo '</select><br/>';
				}
				echo '<br/><input class="inup" type="submit" value=" Ударить " /><br/>';
			}
		}
		else
		{
			$timeout = $lasthit+$to - time();
			$minutes_l = floor($timeout/60);
			$seconds_l = $timeout - $minutes_l*60;
	        if($timeout>0)
	        {
	            echo "Ожидаем хода противника... <br/>До таймаута осталось <b>".$minutes_l." мин. ".$seconds_l." сек.</b><br/>";
	        }
	        else
	        {
				echo "
				Противник долго не делает свой ход, вы можете закончить бой победителем<br/>
				<a href='battle.php?act=t_win&tmp=$random'>Да, я победил!!!</a><br/>
				или признать ничью<br/>
				<a href='battle.php?act=t_draw&tmp=$random'>Считаем, что этого боя не было</a>";
	        }
		}
	}
	echo "<div class=\"sep1\"></div><div class=\"sep2\"></div>";
	###########################################################################
	echo '<a href="battle.php?act=random_hit&tmp='.$random.'">Случайный Удар</a>: '.($_SESSION["random_hit"]?'<b style="color:#008080">On</b>':'<b>Off</b>')."<br/>";
	echo "<a href='?act=view_magic'>Использование свитков</a><br/>";
	if ($db["zver_count"]){echo "<a href='?zver_on=1'>Выпусти своего зверя из клетки</a><br/>";}
	echo "<div class=\"sep1\"></div><div class=\"sep2\"></div><br/>";

	###########################################################################
	$aktiv_p = mysql_query("SELECT * FROM slots_priem LEFT JOIN priem on priem.id=slots_priem.priem_id WHERE user_id=".$db["id"]." ORDER BY sl_name ASC");
	if (mysql_num_rows($aktiv_p))
	{	
		$udarlar=mysql_fetch_array(mysql_query("SELECT * FROM battle_units WHERE player='".$login."' and battle_id='".$bid."'"));
		echo "
		<img width='15' title='Нанесенный удар' src='http://www.meydan.az/img/priem/hit.gif' border='0' />".(int)$udarlar['hit']."&nbsp;
		<img width='15' title='Критический удар' src='http://www.meydan.az/img/priem/krit.gif' border='0' />".(int)$udarlar['krit']."&nbsp;
		<img width='15' title='Парирования' src='http://www.meydan.az/img/priem/parry.gif' border='0' />".(int)$udarlar['parry']."&nbsp;
		<img width='15' title='Проведенный уворот' src='http://www.meydan.az/img/priem/uvarot.gif' border='0' />".(int)$udarlar['uvarot']."&nbsp;
		<img width='15' title='Успешный блок' src='http://www.meydan.az/img/priem/block.gif' border='0' />".(int)$udarlar['block']."&nbsp;
		<img width='15' title='Уровень духа' src='http://www.meydan.az/img/priem/hp.gif' border='0' />".(int)$udarlar['hp']."&nbsp;
		<img width='15' title='Нанесенный урон' src='http://www.meydan.az/img/priem/all.gif' border='0' />".(int)$udarlar['counter']."&nbsp;";
		echo "<br/>";
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
				echo ($enable?"<a href='battle.php?special=".$aktiv_priem["type"]."&tmp=".$random."'><img src='http://www.meydan.az/img/priem/misc/".$aktiv_priem["id"].".gif' border='0' style='cursor:pointer;' /></a> ":"<img src='http://www.meydan.az/img/priem/misc/".$aktiv_priem["id"].".gif' border='0' style='opacity:0.3; filter:alpha(opacity=30);' /> ");
			}
			else echo "<img src='http://www.meydan.az/img/priem/misc/clear.gif' border='0' /> ";
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
			echo ($enable?"<a href='battle.php?special=".$aktiv_priem["type"]."&tmp=".$random."'><img src='http://www.meydan.az/img/priem/misc/".$aktiv_priem["id"].".gif' border='0' /></a> ":"<img src='http://www.meydan.az/img/priem/misc/".$aktiv_priem["id"].".gif' border='0' style='opacity:0.6; filter:alpha(opacity=60);' /> ");
		}
	}
	########################
}
else
{
	#########################Win or Lose#############################################
	if($team == $winer)
	{
		echo "<img src='http://www.meydan.az/img/index/win.gif' border='0' /> <b style='color:#ff0000'>Бой окончен. Вы победили.</b><br/>";
	}
	else
	{
		echo "<img src='http://www.meydan.az/img/index/blose.gif' border='0' /> <b style='color:#ff0000'>Бой окончен. Вы проиграли.</b><br/>";
	}
	echo "<a href='battle.php?act=exit&tmp=$random'>Вернуться</a>";
}
echo "</form><br/>";
echo "</div>";
include_once('battle_log.php');
include("bottom.php");
mysql_close();
echo "</div></html>";