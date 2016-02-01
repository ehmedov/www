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
$rooms=array("room1","room2","room3","room4","room5","room6");
$ip=$db['remote_ip'];
$mine_id=$db["id"];
$act=$_GET['act'];
$in=$_GET['in'];
$team=$_GET['team'];
if(empty($act)){$act="";}
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
	echo "<b style='color:#ff0000'>Групповые бои только с 2-ого уровня</b>";
}
else if(!empty($db["travm"]))
{
 	echo"<b style='color:#ff0000'>Вы не можете драться, т.к. тяжело травмированы!<br>Вам необходим отдых!</b>";
}	
else
{
	//---------------------------Komandaya girmek---------------------
	if($act=="get" && !empty($in))
	{
		$in=intval($in);
		if ((int)$db[orden]==4) {$pr1="(2,5,6)";$pr2="(4)";}
		else if ((int)$db[orden]==2 ||(int)$db[orden]==5 ||(int)$db[orden]==6) {$pr1="(4)";$pr2="(2,5,6)";}
		else {$pr1="(9)";$pr2="(9)";}
		$mynewteam=(int)$_GET['team'];
		$teams=($mynewteam==2?1:2);
		$podal=($db['zayavka']==1?true:false);

		$Tema1_Count=mysql_fetch_array(mysql_query("SELECT count(*) FROM teams WHERE battle_id='".$in."' and team=1"));
		$Tema2_Count=mysql_fetch_array(mysql_query("SELECT count(*) FROM teams WHERE battle_id='".$in."' and team=2"));
		$IP_Count=mysql_fetch_array(mysql_query("SELECT count(*) FROM teams WHERE battle_id='".$in."' and team=$teams and ip='".$ip."'"));


		$x1=mysql_fetch_array(mysql_query("SELECT count(t.player) as coun FROM teams t LEFT JOIN users us on t.player=us.login WHERE t.battle_id='$in' and t.team=$mynewteam and us.orden IN $pr1"));
		$x2=mysql_fetch_array(mysql_query("SELECT count(t.player) as coun FROM teams t LEFT JOIN users us on t.player=us.login WHERE t.battle_id='$in' and t.team=$teams and us.orden IN $pr2"));
		if($podal)
		{
		    $msg="Вы не можете принять данную заявку. Сначала отзовите текущую!!!";
	    }
		else if($db["hp_all"]/3 > $db["hp"])
		{
			$msg="Вы слишком ослаблены для поединка! Восстановитесь!";
		}
		else if($IP_Count[0]>0)
		{
		 	$msg="Вы не можете выступать против персонажа с таким же IP как у вас!";
		}
		else if ($x1['coun']>0) 
		{
			$msg="Предупреждение! Вы не можете принять сторону врагов...";
		}
		else if ($x2['coun']>0) 
		{
			$msg="Предупреждение! Вы не можете идти на поединок против своих...";
		}
	    else
	    {
			$Q=mysql_query("SELECT zayavka.*,users.clan FROM zayavka LEFT JOIN users on users.id=$in WHERE zayavka.creator='".$in."' and zayavka.status!=3");
		    $D=mysql_fetch_array($Q);
		    if ($D)
		    {
		        $status  = $D["status"];
		        $type    = $D["type"];
		        $timeout = $D["timeout"];
		        $minlev1 = $D["minlev1"];
		        $minlev2 = $D["minlev2"];
		        $maxlev1 = $D["maxlev1"];
		        $maxlev2 = $D["maxlev2"];
		        $limit1  = $D["limit1"];
		        $limit2  = $D["limit2"];
		        $wait    = $D["wait"];
				$id=$D["id"];

	            if($_GET['team']==1)
	            {
	                if($Tema1_Count[0]>=$D["limit1"])
	                {
	                    $msg="Группа уже набрана";
	                }
	                else if ($type==11 && !$db["orden"] && !$db["dealer"])
	                {
	                	$msg="Эта заявка не может быть принята вами...Склонность не та..."; 
	                }	
	                else if($D["minlev1"]==99 && $db['clan']!=$D['clan'])
	                {
						$msg="Эта заявка не может быть принята вами."; 
	                }
	                else if(($db["level"]<$D["minlev1"] || $db["level"]>$D["maxlev1"]) && $D["minlev1"]!=99)
	                {
	                    $msg="Вы не подходите по уровню для этого поединка.";
	                }
	                else
	                {	
	            		mysql_query("INSERT INTO teams(player,team,ip,battle_id,over) VALUES('".$login."','1','".$ip."','".$in."','0')");
	            		mysql_query("UPDATE users SET zayavka=1 WHERE login='".$login."'");
	            		$db['zayavka']=1;
	            		$_SESSION["battle_ref"] = 0;
	            	}
	            }
	            else if($_GET['team']==2)
	            {
	                if($Tema2_Count[0]>=$D["limit2"])
	                {
	                    $msg="Группа уже набрана";
	                }
	                else if ($type==11 && !$db["orden"] && !$db["dealer"])
	                {
	                	$msg="Эта заявка не может быть принята вами...Склонность не та..."; 
	                }
	                else if($D["minlev2"]==99 && !$db['clan'])
	                {
						$msg="Эта заявка не может быть принята вами."; 
	                }
	                else if(($db["level"]<$D["minlev2"] || $db["level"]>$D["maxlev2"]) && $D["minlev2"]!=99)
	                {
	                    $msg="Вы не подходите по уровню для этого поединка.";
	                }
	                else
	                {
	                	mysql_query("INSERT INTO teams(player,team,ip,battle_id,hitted,over) VALUES('".$login."','2','".$ip."','".$in."','0','0')");
	                	mysql_query("UPDATE users SET zayavka=1 WHERE login='".$login."'");
	                	$db['zayavka']=1;
	                	$_SESSION["battle_ref"] = 0;
	                }
	            }
		    }
		}
	}
	/*===================Zayavka vermek==========================================*/
	if($_POST["open"])
	{
		$timeout=(int)$_POST['timeout'];
		$friend_count=(int)$_POST['friend_count'];
		$friend_level=(int)$_POST['friend_level'];
		$enemy_count=(int)$_POST['enemy_count'];
		$enemy_level=(int)$_POST['enemy_level'];
		$battle_type=(int)$_POST['battle_type'];
		$wait=(int)$_POST['wait'];
		$wait_to=$wait*60+time();
		$comment=htmlspecialchars(addslashes($_POST['comment']));

		$podal=($db['zayavka']==1?true:false);
		if($db["hp_all"]/3 > $db["hp"])
		{
			$msg="Вы слишком ослаблены для поединка! Восстановитесь!";
		}
		else if($db["level"]<$friend_minlevel)
		{
			$msg="Вы не можете подать заявку с минимальным уровнем, меньше вашего.";
		}
		else if(!$friend_count || !$enemy_count)
		{
			$msg="Неверные данные.";
		}
		else if($friend_count>30 || $enemy_count>30)
		{
			$msg="Максимальное колличество бойцов в группе - 30.";
		}
		else if(($friend_count==1 && $enemy_count<2) || ($friend_count<2 && $enemy_count==1))
		{
			$msg="Неверный ввод колличества бойцов. Минимальное количество противников - 2 человека.";
		}
		else if($friend_level==99 && !$db['clan'])
		{
			$msg="Вы не состоите в клане.";
		}
		else if($podal)
		{
		    $msg="Вы не можете подать новую заявку. Сначала отзовите текущую!";
	    }
		else
		{	
			//-------------------------------------------------------
			if($friend_level==0){$friend_minlevel=2; $friend_maxlevel=21;}
			if($friend_level==1){$friend_minlevel=2; $friend_maxlevel=$db["level"];}
			if($friend_level==2){$friend_minlevel=2; if ($db['level']==2)$friend_maxlevel=2;else $friend_maxlevel=$db['level']-1;}
			if($friend_level==3){$friend_minlevel=$db["level"]; $friend_maxlevel=$db["level"];}
			if($friend_level==4){$friend_minlevel=$db['level']; $friend_maxlevel=$db["level"]+1;}
			if($friend_level==5){if  ($db['level']==2)$friend_minlevel=2;	else $friend_minlevel=$db['level']-1;$friend_maxlevel=$db['level'];}
			if($friend_level==99){$friend_minlevel=99; $friend_maxlevel=99;}
			//-------------------------------------------------------
			if($enemy_level==0){$enemy_minlevel=2; $enemy_maxlevel=21;}
			if($enemy_level==1){$enemy_minlevel=2; $enemy_maxlevel=$db["level"];}
			if($enemy_level==2){$enemy_minlevel=2; if ($db['level']==2)$enemy_maxlevel=2;else $enemy_maxlevel=$db['level']-1;}
			if($enemy_level==3){$enemy_minlevel=$db["level"]; $enemy_maxlevel=$db["level"];}
			if($enemy_level==4){$enemy_minlevel=$db['level']; $enemy_maxlevel=$db["level"]+1;}
			if($enemy_level==5){if  ($db['level']==2)$enemy_minlevel=2;	else $enemy_minlevel=$db['level']-1;$enemy_maxlevel=$db['level'];}
			if($enemy_level==99){$enemy_minlevel=99; $enemy_maxlevel=99;}
			//---------------------------------------------------------------
			$SQL="INSERT INTO zayavka(status,type,timeout,creator,minlev1,maxlev1,minlev2,maxlev2,limit1,limit2,wait,comment,city,room)
					 VALUES('1','".$battle_type."','".$timeout."','".$mine_id."','".$friend_minlevel."','".$friend_maxlevel."','".$enemy_minlevel."','".$enemy_maxlevel."','".$friend_count."','".$enemy_count."','".$wait_to."','".$comment."','".$db["city_game"]."','".$db["room"]."')";
			mysql_query($SQL);
			mysql_query("INSERT INTO teams(player,team,ip,battle_id,hitted,over) VALUES('".$login."','1','".$ip."','".$mine_id."','0','0')");
			mysql_query("UPDATE users SET zayavka=1 WHERE login='".$login."'"); 
			$db['zayavka']=1;
			$_SESSION["battle_ref"] = 0;
			$msg="Заявка на бой подана";
		}
	}
	/*=============================================================*/
	$podal=($db['zayavka']==1?true:false);
	if ($podal)
	{
		echo '<meta http-equiv="refresh" content="15;url=group.php?tmp='.$random.'">';
	}	
	//-------------------zayavka vermek-------------------------
	if($act=="podat" && !$podal)
	{
		?>
		<div>
		<form action='group.php' method='post'>
		<b>Подать заявку на групповой бой</b><br/>[<a href='group.php'>Вернуться</a>]<br/><br/>
		Начало боя через:
		<select name='wait' class='inup'>
			<option value='3' selected>3 минут</option>
			<option value='5'>5 минут</option>
			<option value='10'>10 минут</option>
		</select><br/>
		Таймаут:
		<select name='timeout' class='inup'>
			<option value='1' selected>1 минут</option>
			<option value='2'>2 минут</option>
			<option value='3'>3 минут</option>
			<option value='4'>4 минут</option>
			<option value='5'>5 минут</option>
		</select><br/>
		Ваша команда: <input type='text' name='friend_count' size='3' class='inup' maxlength='2' /> бойцов<br/>
		Уровни союзников:
		<select name='friend_level' class='inup'>
			<option value='0'>любой уровень</option>
			<option value='1'>только моего и ниже</option>
			<option value='2'>только ниже моего уровня</option>
			<option value='3'>только моего уровня</option>
			<option value='4'>не старше меня более чем на уровень</option>
			<option value='5'>не младше меня более чем на уровень</option>
			<option value='99'>мой клан</option>
		</select><br/>
		Противники:	<input type='text' name='enemy_count' size='3' class='inup' maxlength='2' /> бойцов<br/>
		Уровни противников:
		<select name='enemy_level' class='inup'>
			<option value='0'>любой уровень</option>
			<option value='1'>только моего и ниже</option>
			<option value='2'>только ниже моего уровня</option>
			<option value='3'>только моего уровня</option>
			<option value='4'>не старше меня более чем на уровень</option>
			<option value='5'>не младше меня более чем на уровень</option>
			<option value='99'>только клан</option>
		</select><br/>
		Тип поединка:
		<select name='battle_type' class='inup'>
			<option value='4'>с оружием</option>
			<option value='101'>кровавый</option>
		</select><br/>
		Комментарий к бою: <input type='text' name='comment' class='inup' /><br/>
		<input name='open' type='submit' class='inup' value='Подать заявку' /><br/>
		</form>
		</div>
		<?
	}
	//----------------------komanda secmek----------------------
	else if ($_REQUEST['goconfirm'] && $_REQUEST['gocombat'] && !$podal) 
	{
		$gocombat=(int)$_REQUEST['gocombat'];
		$k=mysql_fetch_array(mysql_query("SELECT * FROM zayavka WHERE creator='".$gocombat."' and status!=3"));
		if ($k)
		{
			$p1="";$p2="";
			$q=mysql_query("SELECT users.login,users.level,users.id,users.orden,users.admin_level,users.clan,users.clan_short,users.dealer,teams.team FROM teams LEFT JOIN users on users.login=teams.player WHERE teams.battle_id='".$gocombat."'");
			while($dat=mysql_fetch_array($q))
			{
				if ($dat['team']==1)
			        $p1.=drwfl($dat["login"], $dat["id"], $dat["level"], $dat["dealer"], $dat["orden"], $dat["admin_level"], $dat["clan"], $dat["clan_short"], $dat["travm"])."<br/>";
				else 
			        $p2.=drwfl($dat["login"], $dat["id"], $dat["level"], $dat["dealer"], $dat["orden"], $dat["admin_level"], $dat["clan"], $dat["clan_short"], $dat["travm"])."<br/>";
			}
			$left_time=$k["wait"]-time();
			$left_min=floor($left_time/60);
			$left_sec=$left_time-$left_min*60;

			echo "
				<b>Бой начнется через ".$left_min." мин. ".$left_sec." сек.</b><br/>
				<b>На чьей стороне будете сражаться?</b><br/><br/>
				<b>Группа 1</b><br/>
				Максимальное кол-во: ".$k["limit1"]."<br/>
				Ограничения по уровню: ".$k["minlev1"]." - ".$k["maxlev1"]."<br/>".$p1."
				<a href='group.php?act=get&in=".$gocombat."&team=1'>Я за этих!</a><br/>
				
				<div class=\"sep1\"></div><div class=\"sep2\"></div>
				
				<b>Группа 2</b><br/>
				Максимальное кол-во: ".$k["limit2"]."<br/>
				Ограничения по уровню: ".$k["minlev2"]." - ".$k["maxlev2"]."<br/>".$p2."
				<a href='group.php?act=get&in=".$gocombat."&team=2'>Я за этих!</a><br/>
				<div class=\"sep1\"></div><div class=\"sep2\"></div>";
		}
		else
		{
			echo "<b style='color:#ff0000'>Бой не найден</a><br/><a href='group.php'>Вернуться</a><br/>";
		}	
		include("bottom.php");
		echo "</div>
		</html>";
		die();
	}
	else
	{
		echo "<center>[<a href='group.php'>Обновить</a>]</center>";
		if(!$podal)
		{	
			echo "<center>[<a href='group.php?act=podat'>Подать новую заявку</a>]</center>";
		}
	
		//---------------------------------------------------------------
		echo "<br/><font style='color:#ff0000'>".$msg."</font>";
		echo "<form action='group.php' method='post'>";
		if(!$podal)echo "<input type='submit' value='Принять участие' name='goconfirm' class='inup' /><br/>";
		$Q=mysql_query("SELECT * FROM zayavka WHERE type IN (3,4,101,11) and city='".$db["city_game"]."' ORDER BY date DESC");
		while($DATA=mysql_fetch_array($Q))
		{
			$comma1="";
			$comma2="";
			$mine_z=0;
			$creator=$DATA["creator"];
			$left_time=$DATA["wait"]-time();
			$left_min=floor($left_time/60);
			$left_sec=$left_time-$left_min*60;
			$MY_QUERY=mysql_fetch_array(mysql_query("SELECT count(*) FROM teams WHERE battle_id='".$creator."' and player='".$login."'"));
			if ($MY_QUERY[0]>0)
			{
				$mine_z = 1; // указывает, что н-ый массив относится к текущему перцу
			}
			
			if ($left_time>0 && $DATA["status"]!=3)
			{
				if($DATA['minlev1']==99) 
				{
					$range1 = "<i>клан</i>";
				}
				else 
				{
					$range1 = "{$DATA['minlev1']}-{$DATA['maxlev1']}";
				}
				if($DATA['minlev2']==99) 
				{
					$range2 = "<i>клан</i>";
				}
				else 
				{
					$range2 = "{$DATA['minlev2']}-{$DATA['maxlev2']}";
				}
				echo "<div style='padding: 2px;".($DATA["type"]==11?"background-color:#EEEEEE;":"")."'>";
				$team1_players="";
				$team2_players="";
				$team1_count=0;
				$team2_count=0;
				$QUERY=mysql_query("SELECT users.login,users.level,users.id,users.orden,users.admin_level,users.clan,users.clan_short,users.dealer,teams.team FROM teams LEFT JOIN users on users.login=teams.player WHERE teams.battle_id='".$creator."'");
				while($DAT=mysql_fetch_array($QUERY))
				{
					$player=drwfl($DAT["login"], $DAT["id"], $DAT["level"], $DAT["dealer"], $DAT["orden"], $DAT["admin_level"], $DAT["clan"], $DAT["clan_short"], $DAT["travm"]);
					if ($creator==$DAT["id"])$player="<u>".$player."</u>";
		        	if ($DAT["team"]==1)
		        	{
						$team1_count++;
			        	$team1_players.=$comma1.$player;
						$comma1=", ";
					}
					else if ($DAT["team"]==2)
					{
						$team2_count++;
						$team2_players.=$comma2.$player;
						$comma2=", ";
					}
				}
				if(!$podal)	echo "<input type='radio' name='gocombat' value='".$creator."' />";
				echo "<font class='date'>".substr($DATA["date"],10,9)."</font> <b>".$DATA["limit1"]." (</b>".$range1."<b>) на ".$DATA["limit2"]." (</b>".$range2."<b>)</b> ";
				echo ($team1_players?$team1_players:"(группа не набрана)")." <font color='#666666'><i>против</i></font> ".($team2_players?$team2_players:"(группа не набрана)").($DATA["comment"]?" (<i>Комментария: ".$DATA["comment"]."</i>)":"");
				echo " <img src='http://www.meydan.az/img/battletype/".($DATA["type"]==4 || $DATA["type"]==11?"1.gif' alt='Бой с оружием'":(($DATA["type"]==101)?"3.gif' alt='Кровавый бой'":"2.gif' alt='Кулачный бой'"))." border='0' />";
				echo "&nbsp;  (таймаут ".$DATA["timeout"]." мин.) ";
				echo "<i style='color:#666666;'>Бой начнется через ".$left_min." мин. ".$left_sec." сек. </i>";
				echo "</div>";
				if($team2_count==$DATA["limit2"] && $team1_count==$DATA["limit1"] && $mine_z == 1)
				{
					startBattle($creator);
				}
			}
			else
	    	{
	    		$Q_T2=mysql_query("SELECT * FROM teams WHERE battle_id='".$creator."' and team=2");
		        if(!mysql_num_rows($Q_T2))
				{
		            $Q_T1=mysql_query("SELECT * FROM teams WHERE battle_id='".$creator."' and team=1");
		            while($Q_T1DAT=mysql_fetch_array($Q_T1))
		            {
		                $cur_player=$Q_T1DAT["player"];
						mysql_query("UPDATE users SET zayavka=0 WHERE login='".$cur_player."'");
		                say($cur_player,"Ваш поединок не может состояться по причине: У вас отсутствуют противники.",$cur_player);
		            }
		            mysql_query("DELETE FROM zayavka WHERE creator=$creator");
		            mysql_query("DELETE FROM teams WHERE battle_id=$creator");
		        }
	        	else if($mine_z==1)
	        	{
					startBattle($creator);
	        	}
			}
		}
		echo "</form>";
	}
}
?>
<?include("bottom.php");?>
</div>
</html>