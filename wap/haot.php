<?
ob_start();
include ("key.php");
include ("conf.php");
include ("functions.php");
include ("align.php");
$login=$_SESSION["login"];

header("Content-type: text/html; charset=windows-1251");
header("Cache-Control: no-cache, must-revalidate"); // говорим браузеру что-бы он не кешировал эту страницу
header("Pragma: no-cache");

echo '<?xml version="1.0" encoding="windows-1251"?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.2//EN" "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="en">';

$data = mysql_connect($base_name, $base_user, $base_pass) or die('Не получается подключиться. Проверьте имя сервера, имя пользователя и пароль!');
mysql_select_db($db_name) or die('Ошибка входа в базу данных');

$db = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE login='".$login."'"));
TestBattle($db);
include ("fill_hp.php");
$users_count=50;
$act=$_GET['act'];
$rooms=array("room1","room2","room3","room4","room5","room6");
$ip=$db["remote_ip"];
$random=md5(time());
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
</head>
<body>
<div id="cnt" class="content">
<?
include("header.php");

if(!in_array($db["room"],$rooms))
{
	echo "<b style='color:#ff0000'>В этой комнате невозможно подавать заявки.</b>";
}
else if ($db["level"]<2)
{
	echo "<b style='color:#ff0000'>Хаотические бои доступны с 2-ого уровня</b>";
}
else if(!empty($db["travm"]))
{
	echo "<b style='color:#ff0000'>Вы не можете драться, т.к. тяжело травмированы!<br>Вам необходим отдых!</b>";
}
else
{
	//---------------------------Komandaya girmek---------------------
	if($_POST["gocombat"])
	{
		$in=(int)$_POST["gocombat"];
		$podal=($db['zayavka']==1?true:false);
		$have_art=mysql_fetch_Array(mysql_query("SELECT count(*) FROM inv WHERE `owner`='".$login."' and `object_razdel` = 'obj' and `wear`=1 and art=2"));
		if($podal)
		{	
		    $msg="Вы не можете принять данную заявку. Сначала отзовите текущую...";
	    }
		else if($db["hp_all"]/3 > $db["hp"])
		{
			$msg="Вы слишком ослаблены для поединка! Восстановитесь!";
		}
		else if(is_wear($login)<8 && $db["level"]>=8)
	    {
		    $msg="Для Заявок у вас должно быть Одето минимум 8 вещей.";
	    }
	    else
	    {
		    $D=mysql_fetch_array(mysql_query("SELECT * FROM zayavka WHERE creator='".$in."' and status!=3"));
		    if ($D)	
		    {
		    	if ($D["artoff"] && $have_art[0]>0)
		    	{
		    		$msg="Этот бой Без Артефактов";
		    	}
		    	else
		    	{
					$c_t=mysql_fetch_array(mysql_query("SELECT count(*) FROM teams WHERE battle_id=".$in));
					if ($c_t[0]>=$users_count){$msg="Максимум $users_count бойцов...";}
					else
					{
			            if($db["level"]<$D["minlev1"] || $db["level"]>$D["maxlev1"])
			            {
			                $msg="Вы не подходите по уровню для этого поединка.";
			            }
			            else
			            {	
			        		mysql_query("INSERT INTO teams(player,team,ip,battle_id) VALUES('".$login."','1','".$ip."','".$D["creator"]."')");
			        		mysql_query("UPDATE users SET zayavka=1 WHERE login='".$login."'");
							mysql_query("set @noc:=2;");
							mysql_query("UPDATE teams INNER JOIN (SELECT teams.player FROM teams LEFT JOIN users ON users.login = teams.player WHERE teams.battle_id = '".$D["creator"]."') as k on teams.player=k.player set team=CASE @noc WHEN 1 THEN @noc:=2 WHEN 2 THEN @noc:=1 END ;");
							#mysql_query("UPDATE teams INNER JOIN (SELECT teams.player FROM teams LEFT JOIN users ON users.login = teams.player WHERE teams.battle_id = '".$D["creator"]."' ORDER BY users.exp DESC) as k on teams.player=k.player set team=CASE @noc WHEN 1 THEN @noc:=2 WHEN 2 THEN @noc:=1 END ;");

			        		$db['zayavka']=1;
			        		$_SESSION["battle_ref"] = 0;
			        	}
					}
				}
        	}
		}
	}
	/*===================Zayavka vermek==========================================*/
	if($act=="submit")
	{
		$podal=($db['zayavka']==1?true:false);
		$have_art=mysql_fetch_Array(mysql_query("SELECT count(*) FROM inv WHERE `owner`='".$login."' and `object_razdel` = 'obj' and `wear`=1 and art=2"));

		if($db["hp_all"]/3 > $db["hp"])
		{
			$msg="Вы слишком ослаблены для поединка! Восстановитесь!";
		}
		else if($podal)
		{
		    $msg="Вы не можете подать новую заявку. Сначала отзовите текущую...";
	    }
	    else if(is_wear($login)<8 && $db["level"]>=8)
	    {
		    $msg="Для Заявок у вас должно быть Одето минимум 8 вещей.";
	    }
	    else if($_POST["artoff"] && $have_art[0]>0)
	    {
		    $msg="Этот бой Без Артефактов";
	    }
		else
		{	
			$mine_id=$db["id"];
			$battle_type=(int)$_POST['hand'];
			$wait_to=$_POST['stime']*60+time();
			$battle_timeout=(int)$_POST['timeout'];
			$comment=htmlspecialchars(addslashes($_POST['fight_comment']));
			$teams_level=(int)$_POST["teams_level"];
			if($_POST["hidden"]){$hidden=1;$comment="";}
			if($_POST["artoff"]){$artoff=1;}
			
			if($teams_level==0){$friend_minlevel=2; $friend_maxlevel=21;}
			if($teams_level==1){$friend_minlevel=2; $friend_maxlevel=$db["level"];}
			if($teams_level==2){$friend_minlevel=2; if ($db['level']==2)$friend_maxlevel=2;else $friend_maxlevel=$db['level']-1;}
			if($teams_level==3){$friend_minlevel=$db["level"]; $friend_maxlevel=$db["level"];}
			if($teams_level==4){$friend_minlevel=$db['level']; $friend_maxlevel=$db["level"]+1;}
			if($teams_level==5){if  ($db['level']==2)$friend_minlevel=2;	else $friend_minlevel=$db['level']-1;$friend_maxlevel=$db['level'];}
			if($teams_level==6){$friend_minlevel=$db['level']; $friend_maxlevel=21;}
			if($teams_level==7){if  ($db['level']==2)$friend_minlevel=2;	else $friend_minlevel=$db['level']-1;$friend_maxlevel=$db['level']+1;}

			mysql_query("INSERT INTO zayavka(status,type,timeout,creator,minlev1,maxlev1,wait,comment,city,room,hidden,artoff) VALUES('1','".$battle_type."','".$battle_timeout."','".$mine_id."','".$friend_minlevel."','".$friend_maxlevel."','".$wait_to."','".$comment."','".$db["city_game"]."','".$db["room"]."','".$hidden."','".$artoff."')");
			mysql_query("INSERT INTO teams(player,team,ip,battle_id,hitted,over) VALUES('".$login."','1','".$ip."','".$mine_id."','0','0')");
			mysql_query("UPDATE users SET zayavka=1 WHERE login='".$login."'"); 
			$msg="Заявка на бой подана...";
			$db['zayavka']=1;
			$_SESSION["battle_ref"] = 0;
		}
	}
	/*=============================================================*/
	$podal=($db['zayavka']==1?true:false);
	if ($podal)
	{
		echo '<meta http-equiv="refresh" content="15;url=haot.php?tmp='.$random.'">';
	}
	echo "<center>[<a href='haot.php'>Обновить</a>]</center>";
	if(!$podal)
	{
		echo "<center>[<a href='haot.php?act=podat'>Подать новую заявку</a>]</center>";
	}
	//-------------------zayavka vermek-------------------------
	if($act=="podat")
	{
		?>
		<div>
		<form action='?act=submit' method='post'>
		<b>Подать заявку на хаотичный бой</b><br/>
		Начало боя через:
		<select name='stime' class='inup'>
			<option value="3" selected>3 мин.</option>
			<option value="5">5 мин.</option>
			<option value="10">10 мин.</option>
			<option value="15">15 мин.</option>
		</select><br/>
		Тип боя:
		<select name='hand' class='inup'>
			<option value='5' selected>с оружием</option>
			<option value='102'>кровавый</option>
		</select><br/>
		Время на ход:
		<select name='timeout' class='inup'>
			<option value="1" selected>1 мин.</option>
			<option value="2">2 мин.</option>
			<option value="3">3 мин.</option>
			<option value="4">4 мин.</option>
			<option value="5">5 мин.</option>
		</select><br/>
		Уровень бойцов:
		<select name='teams_level' class='inup'>
			<option value='0' selected>любой уровень</option>
			<option value='1'>только моего и ниже</option>
			<option value='6'>только моего и выше</option>
			<option value='3'>только моего уровня</option>
			<option value='4'>не старше меня более чем на уровень</option>
			<option value='5'>не младше меня более чем на уровень</option>
			<option value='7'>мой уровень +1 и -1</option>
		</select><br/>
		Комментарий к бою: <input type='text' name='fight_comment' class='inup' /><br/>
		<input type='checkbox' name='hidden' /> Невидимый Бой (не видно противников в заявке. +5% опыта)<br/>
		<input type='checkbox' name='artoff' /> Без Артефактов<br/>
		<input type='submit' name='open' value='подать заявку' class='inup' />
		</form>
		</div>
		<?
	}
	//---------------------------------------------------------------
	echo "<br/><font style='color:#ff0000'>".$msg."</font>";
	echo "<form method='post' action=''>";
	if(!$podal)echo "<input type='submit' value='Принять участие' name='confirm' class='inup' /><br/>";
	$Q=mysql_query("SELECT * FROM zayavka WHERE type IN (5,6,7,102) and city='".$db["city_game"]."' ORDER BY date DESC");
	while($DATA=mysql_fetch_array($Q))
	{
		$mine_z=0;
		$creator=$DATA["creator"];
		$left_time=$DATA["wait"]-time();
		$left_min=floor($left_time/60);
		$left_sec=$left_time-$left_min*60;
		$begin_count=($DATA["type"]==7?1:4);
		$MY_QUERY=mysql_fetch_array(mysql_query("SELECT count(*) FROM teams WHERE battle_id='".$creator."' and player='".$login."'"));
		if ($MY_QUERY[0]>0)
		{
			$mine_z = 1; // указывает, что н-ый массив относится к текущему перцу
		}

		if ($left_time>0 && $DATA["status"]!=3)
		{
			echo "<div style='padding: 4px;'>";
			if(!$podal)
			{
				echo "<input type='radio' name='gocombat' value='$creator' />";
			}
			echo "<font class='date'>".($mine_z?"<u>":"").substr($DATA["date"],10,9)."</u></font> ";
			$teams_players="";
			$QUERY=mysql_query("SELECT login,level,id,orden,admin_level,clan,clan_short,dealer FROM teams LEFT JOIN users on users.login=teams.player WHERE teams.battle_id='".$creator."'");
			while($DAT=mysql_fetch_array($QUERY))
			{
				$team_count++;
				$player=drwfl($DAT["login"], $DAT["id"], $DAT["level"], $DAT["dealer"], $DAT["orden"], $DAT["admin_level"], $DAT["clan"], $DAT["clan_short"], $DAT["travm"]);
				if ($creator==$DAT["id"])$player="<u>".$player."</u>";
	        	$teams_players.=$comma.$player;
				$comma=",&nbsp;&nbsp;";
			}
	        echo "(".($DATA["hidden"]?"<i>неизвестно</i>":$teams_players).")";
			echo " Уровень: (".$DATA["minlev1"]."-".$DATA["maxlev1"].") ";
			echo "<img src='http://www.meydan.az/img/battletype/".($DATA["type"]==5 || $DATA["type"]==7?"1.gif' alt='Бой с оружием'":(($DATA["type"]==102)?"3.gif' alt='Кровавый бой'":"2.gif' alt='Кулачный бой'"))."  border='0' />";
			echo "&nbsp;  (таймаут ".$DATA["timeout"]." мин.) ".($DATA["artoff"]?" [Бой Без Артефактов] ":"");
			echo "<i style='color:#666666;'>Бой начнется через ".$left_min." мин. ".$left_sec." сек. ".($DATA["comment"]?"(Комментария: ".str_replace("&amp;","&",$DATA["comment"]).")":"")."</i>";
			echo "</div>";
			$comma="";
		}
		else
	    {
	    	$Q_T2=mysql_query("SELECT teams.player FROM teams LEFT JOIN users ON users.login = teams.player WHERE teams.battle_id = '".$creator."' ORDER BY users.hp_all DESC");
	        if(mysql_num_rows($Q_T2)<$begin_count)
	        {
	        	while($res_sql=mysql_fetch_Array($Q_T2))
	        	{
	        		mysql_query("UPDATE users SET zayavka=0 WHERE login='".$res_sql["player"]."'");
	        		say($res_sql['player'],"Группа не набрана, бой начаться не может... (Бой не начнется, если собралось меньше 4-х человек.)",$res_sql['player']);
	        	}
				mysql_query("DELETE FROM zayavka WHERE creator=".$creator);
	            mysql_query("DELETE FROM teams WHERE battle_id=".$creator);
	        }
	        else if($mine_z==1)
	        {
	        	/*
	        	mysql_query("set @noc:=2;");
	        	mysql_query("UPDATE teams INNER JOIN (SELECT teams.player FROM teams LEFT JOIN users ON users.login = teams.player WHERE teams.battle_id = '".$creator."' ORDER BY users.hp_all DESC) as k on teams.player=k.player set team=CASE @noc WHEN 1 THEN @noc:=2 WHEN 2 THEN @noc:=1 END ;");
            	
            	$haos_team=1;
            	while ($participant=mysql_fetch_array($Q_T2)) 
                {
                	mysql_query("UPDATE teams SET team=".$haos_team." WHERE player='".$participant['player']."';");
					if($haos_team==1)$haos_team=2;
                	else if($haos_team==2)$haos_team=1;
                }*/
                startBattle($creator);
	        }
		}
	}
	echo "</form>";
}
?>
<?include("bottom.php");?>
</div>
</html>