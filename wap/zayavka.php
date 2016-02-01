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
$mine_id=$db["id"];
$ip=$db["remote_ip"];
$random=md5(time());
$boy=$_GET['boy'];
$act=$_GET['act'];
$id=$_GET['id'];
$timeout=$_POST['timeout'];
$battle_type=$_POST['battle_type'];
if(!isset($zayavka_status))
{
	$zayavka_status="no";
}
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
	die("В этой комнате невозможно подавать заявки.");
}
/*======ZAYAVKA VERMEK====================================*/
if($_REQUEST['open'])
{
	$podal=($db['zayavka']==1?true:false);
	if($db["hp_all"]/3 > $db["hp"])
	{
		$msg="Вы слишком ослаблены для поединка! Восстановитесь!";
	}
	else if(!empty($db["travm"]))
	{
	 	$msg="Вы не можете драться, т.к. травмированы! Вам необходим отдых!";
	}
	else if($podal)
	{	
	    $msg="Вы не можете подать новую заявку. Сначала отзовите текущую.";
    }
    else
    {	
		$date=date("d.m.Y H:i");
		mysql_query("INSERT INTO zayavka(status,type,timeout,creator,comment,city,room,minlev1) VALUES('1','".$battle_type."','".$timeout."','".$mine_id."','','".$db["city_game"]."','".$db["room"]."','".$db["level"]."')");
		mysql_query("INSERT INTO teams(player,team,ip,battle_id,hitted,over) VALUES('".$login."','1','".$ip."','".$mine_id."','0','0')");
		mysql_query("UPDATE users SET zayavka='1' WHERE login='".$login."'");
		$_SESSION["zayavka_c_m"] = 0;
		$_SESSION["battle_ref"] = 0;
		$db['zayavka']=1;
	}
}
/*======KIMINSE ZAYAVKASINI QEBUL ETMEK====================================*/
if($_REQUEST['confirm2'])
{
	if (!$_REQUEST['gocombat'])
	{
		$msg="Вы не выбрали, чью именно заявку принимаете...";
	}
	else
	{
		$pr=(int)$_REQUEST['gocombat'];
		$podal=($db['zayavka']==1?true:false);
		$lev=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE id = $pr"));
		
		if($db["hp_all"]/3 > $db["hp"])
		{
			$msg="Вы слишком ослаблены для поединка. Восстановитесь.";
		}
		else if(!empty($db["travm"]))
		{
		 	$msg="Вы не можете драться, т.к. тяжело травмированы. Вам необходим отдых.";
		}
		else if($ip==$lev['remote_ip'])
		{
		 	$msg="Вы не можете выступать против персонажа с таким же IP как у вас!";
		}
		else if($db["clan_short"]==$lev['clan_short'] && $lev['clan_short']!="")
		{
		 	$msg="Предупреждение! Вы не можете идти на поединок против своих...";
		}
		/*else if ($db["level"]-$lev['level']>4)
		{
			$msg="Вы не можете принять этот вызов. Ваш уровень слишком большой для этого боя.";
		}
		else if ($lev['level']-$db["level"]>4)
		{
			$msg="Вы не можете принять этот вызов. Ваш уровень слишком низкий для этого боя.";
		}*/
		else if($podal)
		{	
		    $msg="Вы не можете принять этот вызов! Сначала отзовите текущую...";
	    }
	    else
	    {
			$data=mysql_num_rows(mysql_query("SELECT * FROM zayavka WHERE creator='".$pr."'"));
			if($data)
			{
				$_SESSION["zayavka_c_o"] = 0;
		        $D2 = mysql_fetch_array(mysql_query("SELECT * FROM teams WHERE battle_id = $pr and team=2"));
		        if(!$D2)
		        {
			        mysql_query("INSERT INTO teams(player, team, ip, battle_id) VALUES('".$login."','2','".$ip."','".$pr."')");
			        mysql_query("UPDATE zayavka SET status='2', minlev2='".$db['level']."' WHERE creator = $pr");
		            mysql_query("UPDATE users SET zayavka='1' WHERE login='".$login."'");
		            $db['zayavka']=1;
		            $_SESSION["battle_ref"] = 0;
		        }
		        else 
		        {
	       		    $msg="Кто-то оказался быстрее и перехватил заявку!!!";
		        }
			}
			else
			{
				$msg="Похоже противник отозвал свою заявку!";
			}
		}
	}
}
/*=====VERDIYIM ZAYAVKANI GERI GOTURMEK==================================*/
if($_REQUEST['recall'])
{
	$boy_type=array(1,2,100);
	$S=mysql_num_Rows(mysql_query("SELECT * FROM teams WHERE player='".$login."' and team=1"));
    if($S)
    {
        $DD = mysql_fetch_array(mysql_query("SELECT * FROM zayavka WHERE creator='".$db['id']."'"));
        if($DD["status"]==1 && in_array($DD["type"],$boy_type))
        {
        	mysql_query("DELETE FROM zayavka WHERE creator='".$db['id']."'");
        	mysql_query("DELETE FROM teams WHERE battle_id='".$db['id']."'");            
            mysql_query("UPDATE users SET zayavka='0' WHERE login='".$login."'");
            $db['zayavka']=0;
        }
    }
}
/*=========QEBUL ETDIYIM ZAYAVKANI GERI GOTURMEK========================*/
if($_REQUEST['recallBattle'])
{
	$boy_type=array(1,2,100);
    $DD = mysql_fetch_array(mysql_query("SELECT zayavka.status, zayavka.type, bat_id.battle_id FROM zayavka,(SELECT battle_id FROM teams WHERE player='".$login."' and team=2) as bat_id WHERE creator=bat_id.battle_id"));
    if($DD["status"]!=3 && in_array($DD["type"],$boy_type))
    {
    	$cr=$DD["battle_id"];
        mysql_query("UPDATE zayavka SET status='1', minlev2=0 WHERE creator='".$cr."'");
        mysql_query("DELETE FROM teams WHERE player='".$login."' and team=2");
        mysql_query("UPDATE users SET zayavka=0 WHERE login='".$login."'");
        $db['zayavka']=0;
        $DDD = mysql_fetch_array(mysql_query("SELECT * FROM teams WHERE battle_id='".$cr."' and team=1"));
        say($DDD["player"],"<b>".$login."</b> отозвал свой вызов.",$DDD["player"]);
    }
}
/*===============DOYUSHU QEBUL ETMEK VE YA ETMEMEMK===============================*/
if($act=="confirm")
{
	$denie=$_POST['denie'];
	$accept=$_POST['accept'];
    if($denie)
    {
        $DATA=mysql_fetch_array(mysql_query("SELECT * FROM teams WHERE player='".$login."' and team=1"));
        if($DATA)
        {
	        $cr = $DATA["battle_id"];
	        mysql_query("UPDATE zayavka SET status='1', minlev2=0 WHERE creator='".$cr."'");
	        $DDD = mysql_fetch_array(mysql_query("SELECT player FROM teams WHERE battle_id='".$cr."' and team=2"));
	        $op = $DDD["player"];
	        mysql_query("DELETE FROM teams WHERE battle_id='".$cr."' and team=2");
            mysql_query("UPDATE users SET zayavka='0' WHERE login='".$op."'");
            say($op,"<b>$login</b> отказал Вам в поединке.",$op);
            $_SESSION["zayavka_c_m"] = 0;
        }
    }
    if($accept)
    {
		$DATA = mysql_fetch_array(mysql_query("SELECT * FROM teams WHERE player='".$login."' and team=1"));
		if($DATA)
		{
            $tt = $DATA["type"];
            $cr = $DATA["battle_id"];
            $ZZ = mysql_fetch_array(mysql_query("SELECT * FROM teams WHERE battle_id=$cr and team=2"));
			if($ZZ)
			{
            	$bdate=date("d.m.y H:i",time());
				say($ZZ["player"],"Часы показывали <b>$bdate</b> когда бой начался!!!",$ZZ["player"]);
				startBattle($cr);
				Header("Location: battle.php?tmp=$random");
				die();
			}
			else
			{
				$msg="Противник отозвал свою заявку!";
			}
		}
	}
}
/*=====================================================*/
$m = 0;
$t = 0;
$MD = mysql_fetch_array(mysql_query("SELECT * FROM teams WHERE player='".$login."'"));
if ($MD)
{	
	$m = $MD["battle_id"];
	$t = $MD["team"];
	$protivnik=($t==1?"2":"1");
	$DD = mysql_fetch_array(mysql_query("SELECT * FROM teams WHERE battle_id=$m AND team=$protivnik"));
	$opponent = $DD["player"];
	$DAT=mysql_fetch_array(mysql_query("SELECT * FROM zayavka WHERE creator='$m'"));
	if ($DAT)
	{
	    if($DAT["status"]==1)				{$zayavka_status="awaiting";	}
	    if($DAT["status"]==2 && $t == 1)	{$zayavka_status="confirm_mine";}
	    if($DAT["status"]==2 && $t == 2)	{$zayavka_status="confirm_opp";	}
	    //if($DAT["status"]==3)				{goBattle($login);				}
	}
}
#################################################################################################
if ($db['zayavka']==1)
{
	echo '<meta http-equiv="refresh" content="15;url=zayavka.php?tmp='.$random.'">';
}	
#################################################################################################
echo "<div class='aheader'><br/>";
echo "<font color='#ff0000'>$msg</font>";
if($zayavka_status=="no")
{
	echo "
	<form action='' method='post'>
		<b>Подать заявку на бой</b><br/>
		Время на ход: 
	    <select name='timeout' class='inup'>
	        <option value='3' selected>3 мин.</option>
	        <option value='5'>5 мин.</option>
	        <option value='10'>10 мин.</option>
		</select><br/>
		Тип боя: 
		<select name='battle_type' class='inup'>
			<option value='1' selected>с оружием</option>
			<option value='100'>кровавый</option>
		</select>             
		<input type='submit' name='open' value='Подать заявку' class='inup' />
	</font><br/>";
	echo "<div class=\"sep1\"></div><div class=\"sep2\"></div>";

}
else if($zayavka_status=="awaiting")
{
	echo "
	<form action='' method='post'>
		<b>Ваша заявка ожидает подтверждения.</b> <input name='recall' type='submit' value='Отозвать заявку' class='inup' />
	</form>";
}
else if($zayavka_status=="confirm_mine")
{
	$OPP_DATA=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE login='".$opponent."'"));
	echo "
	<form action='?act=confirm' method='post'>
		<b>Желаете сразиться с </b>".drwfl($OPP_DATA["login"], $OPP_DATA["id"], $OPP_DATA["level"], $OPP_DATA["dealer"], $OPP_DATA["orden"], $OPP_DATA["admin_level"], $OPP_DATA["clan"], $OPP_DATA["clan_short"], $OPP_DATA["travm"])."<br/>
		<input type='submit' name='accept' value='Битва' class='inup' />&nbsp;
		<input type='submit' name='denie' value='Отказать' class='inup' />
	</form>";
}
else if($zayavka_status=="confirm_opp")
{
	echo "
	<form action='' method='post'>
		<b>Ожидаем подтверждения боя:</b> <input name='recallBattle' type='submit' value='Отозвать заявку' class='inup' />
	</form>";
}
echo "<br/></div>";
#################################################################################################
$QUERY=mysql_query("SELECT * FROM zayavka WHERE type IN (1,2,100) and status!='3' and city ='".$db["city_game"]."' ORDER BY date DESC");
if (mysql_num_rows($QUERY))
{	
	echo "
	<form method='post' action=''>
	<input type='submit' value='Принять вызов' name='confirm2' class='inup' /><br/>";
	while($data=mysql_fetch_array($QUERY)) 
	{
		$creator      	= $data["creator"];
		$date         	= $data["date"];
		$timeout      	= $data["timeout"];
		$battle_type  	= $data["type"];
		$battle_img="<img src='http://www.meydan.az/img/battletype/".($battle_type==1?"1.gif' border='0' alt='Бой с оружием'":(($battle_type==100)?"3.gif' border='0' alt='Кровавый бой'":"2.gif' border='0' alt='Кулачный бой'"))." />";
		$team1 = "";
		$team2 = "";

		$query_team=mysql_query("SELECT level, id, orden, admin_level, clan_short, clan, dealer, login, teams.team FROM teams LEFT JOIN users ON users.login=teams.player WHERE teams.battle_id='".$creator."'");
		while($DATS=mysql_fetch_array($query_team)) 
		{
			if ($DATS['team']==1) $team1=drwfl($DATS["login"], $DATS["id"], $DATS["level"], $DATS["dealer"], $DATS["orden"], $DATS["admin_level"], $DATS["clan"], $DATS["clan_short"], $DATS["travm"]);
			else $team2="<i style='color:#191970'>против</i> ".drwfl($DATS["login"], $DATS["id"], $DATS["level"], $DATS["dealer"], $DATS["orden"], $DATS["admin_level"], $DATS["clan"], $DATS["clan_short"], $DATS["travm"]);
		}
		echo "<input type='radio' ".((($creator==$db['id']) || ($data['status']==2))?'disabled':'')." name='gocombat' value='".$creator."' />".substr($date,10,9)." $team1 $team2 тип боя: $battle_img ";
		echo "(таймаут <b>$timeout</b> мин.)";
		echo "<br/>";
	}
	echo "<input type='submit' value='Принять вызов' name='confirm2' class='inup' /><br/>";
	echo "</form>";
}

?>
<?include("bottom.php");?>
</div>
</html>