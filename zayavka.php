<?
include ("key.php");
ob_start("@ob_gzhandler");
include ("align.php");
include	("prevent_attacks.php");
include ("conf.php");
include ("functions.php");

header("Content-type: text/html; charset=windows-1251");
header("Cache-Control: no-cache, must-revalidate"); // говорим браузеру что-бы он не кешировал эту страницу
header("Pragma: no-cache");

$login=$_SESSION['login'];
$random=md5(time());
$boy=$_GET['boy'];
$act=$_GET['act'];
$id=$_GET['id'];
$timeout=$_POST['timeout'];
$msg="";
//$zayavka_status=$_GET['zayavka_status'];
$battle_type=$_POST['battle_type'];
$rooms=array("room1","room2","room3","room4","room5","room6");
?>
<HEAD>	
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<meta http-equiv="Content-Language" content="ru">
	<META Http-Equiv=Cache-Control Content="no-cache, max-age=0, must-revalidate, no-store">
	<meta http-equiv=PRAGMA content=NO-CACHE>
	<meta http-equiv=Expires content=0>	
	<LINK REL=StyleSheet HREF='main.css' TYPE='text/css'>
</HEAD>
<body bgcolor="#faeede">
<script language="JavaScript" type="text/javascript" src="commoninf.js"></script>
<?
$data = mysql_connect($base_name, $base_user, $base_pass) or die('Не получается подключиться. Проверьте имя сервера, имя пользователя и пароль!');
mysql_select_db($db_name) or die('Ошибка входа в базу данных');

$db = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE login='".$login."'"));
if($db["battle"]!=0){Header("Location: battle.php");die();}
$ip=$db["remote_ip"];

$cure_hp=$db["cure_hp"];
$time_to_cure=$cure_hp-time();
$hhh=$db["hp_all"];
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
}
$hp[1]=$db["hp_all"];
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align=left valign=middle>
    	<?echo "<script>drwfl('".$db['login']."','".$db['id']."','".$db['level']."','".$db['dealer']."','".$db['orden']."','".$db['admin_level']."','".$db['clan_short']."','".$db['clan']."');</script>";?>
		<span id="HP" style="font-size:10px"></span>&nbsp;<img src="img/icon/grey.jpg" alt="Уровень жизни" name="HP1" width="1" height="10" id="HP1"><img src="img/icon/grey.jpg" alt="Уровень жизни" name="HP2" width="1" height="10" id="HP2"><span style="width:1px; height:10px"></span>
		<script>top.setHP(<?echo $hp[0].",".$hp[1].",100";?>);</script>	
	</td>
    <td  align=right valign=middle>
    	<INPUT TYPE=button value="Обновить" onClick="location.href='zayavka.php'">
    	<INPUT TYPE=button class="podskazka" value="Подсказка" onclick="window.open('help/zayavka.php','displayWindow','height=400,width=500,resizable=no,scrollbars=yes,menubar=no,status=no,toolbar=no,directories=no,location=no')"/>
		<INPUT TYPE=button value="Вернуться" onClick="location.href='main.php?act=none';">
	</td>
  </tr>
</table>
<?
//------------------------------------------------------------------------
if(!isset($zayavka_status))
{
	$zayavka_status="no";
}
if(empty($act)){$act="";} 
?>
<table align="center" width="100%" border="0">
  	<tr class="m">
		<td width="14%" class="m" align="center"><a href="#" onclick="document.location.href='zayavkatrain.php'" class="f">Тренировочные</a></td>
		<td width="14%" class="s" align="center"><a href="#" onclick="document.location.href='zayavka.php'" class="f">Одиночные</a></td>
		<td width="14%" class="m" align="center"><a href="#" onclick="document.location.href='group_zayavka.php'" class="f">Групповые</a></td>
		<td width="14%" class="m" align="center"><a href="#" onclick="document.location.href='haot.php'" class="f">Хаотические</a></td>
		<td width="14%" class="m" align="center"><a href="#" onclick="document.location.href='during.php'" class="f">Текущие</a></td>
		<td width="14%" class="m" align="center"><a href="#" onclick="document.location.href='archive.php'" class="f">Летописи</a></td>
	</tr>	
</table>
<?	
if(!in_array($db["room"],$rooms))
{
	echo "<center><b style='color:#ff0000'>В этой комнате невозможно подавать заявки.</b></center>";die();
}
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td valign=top>
<?
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
		$mine_id=$db["id"];
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
		$level = mysql_query("SELECT * FROM users WHERE id = $pr");
		$lev=mysql_fetch_array($level);
		
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
			        mysql_query("INSERT INTO teams(player,team,ip,battle_id,hitted,over) VALUES('".$login."','2','".$ip."','".$pr."','0','0')");
			        mysql_query("UPDATE zayavka SET status='2',minlev2='".$db['level']."' WHERE creator = $pr");
		            mysql_query("UPDATE users SET zayavka='1' WHERE login='".$login."'");
		            $db['zayavka']=1;
		            $_SESSION["battle_ref"] = 0;
					talk($lev["login"],"<b>".$login."</b> не страшится сильного противника и предлагает Вам померяться силами!",$lev);
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
        mysql_query("UPDATE zayavka SET status='1',minlev2=0 WHERE creator='".$cr."'");
        mysql_query("DELETE FROM teams WHERE player='".$login."' and team=2");
        mysql_query("UPDATE users SET zayavka=0 WHERE login='".$login."'");
        $db['zayavka']=0;
        $DDD = mysql_fetch_array(mysql_query("SELECT player FROM teams WHERE battle_id='".$cr."' and team=1"));
        say($DDD["player"],"<b>".$login."</b> отозвал свой вызов.",$DDD["player"]);
    }
}
/*===============DOYUSHU QEBUL ETMEK VE YA ETMEMEMK===============================*/
if($act=="confirm")
{
    if($_POST['denie'])
    {
        $DATA=mysql_fetch_array(mysql_query("SELECT * FROM teams WHERE player='".$login."' and team=1"));
        if($DATA)
        {
	        $cr = $DATA["battle_id"];
	        mysql_query("UPDATE zayavka SET status='1',minlev2=0 WHERE creator='".$cr."'");
	        $DDD = mysql_fetch_array(mysql_query("SELECT player FROM teams WHERE battle_id='".$cr."' and team=2"));
	        $op = $DDD["player"];
	        mysql_query("DELETE FROM teams WHERE battle_id='".$cr."' and team=2");
            mysql_query("UPDATE users SET zayavka='0' WHERE login='".$op."'");
            say($op,"<b>$login</b> отказал Вам в поединке.",$op);
            $_SESSION["zayavka_c_m"] = 0;
        }
    }
    if($_POST['accept'])
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
$m = 0;$t = 0;
$MD = mysql_fetch_array(mysql_query("SELECT * FROM teams WHERE player='".$login."'"));
if ($MD)
{	
	$m = $MD["battle_id"];
	$t = $MD["team"];
	$protivnik=($t==1?"2":"1");
	$DD = mysql_fetch_array(mysql_query("SELECT * FROM teams WHERE battle_id=$m AND team=$protivnik"));
	$opponent = $DD["player"];
	$DAT=mysql_fetch_array(mysql_query("SELECT * FROM zayavka WHERE creator='".$m."'"));
	if ($DAT)
	{
	    if($DAT["status"]==1)				{$zayavka_status="awaiting";	}
	    if($DAT["status"]==2 && $t == 1)	{$zayavka_status="confirm_mine";}
	    if($DAT["status"]==2 && $t == 2)	{$zayavka_status="confirm_opp";	}
	    //if($DAT["status"]==3)				{goBattle($login);				}
	}
}
/*=====================================================*/
if ($db['zayavka']==1)
{
	echo "<script>
			function refreshPeriodic()
			{
				location.href='zayavka.php';
				timerID=setTimeout('refreshPeriodic()',20000);
			}
			timerID=setTimeout('refreshPeriodic()',20000);
		</script>";
}	
/*=====================================================*/
echo "<b style='color:#ff0000'>".$msg."</b>";
/*=====================================================*/
if($zayavka_status=="no")
{
	?>
	<table cellspacing="0" cellpadding="0"><tr><td>
		<form name="boy" action="zayavka.php" method="POST">
        <FIELDSET style="width:600px; border:1px outset;">
    		<LEGEND><B>Подать заявку на бой</B> </LEGEND>
        		Время на ход:
	            <SELECT name=timeout class=new>
		            <OPTION value=3 selected>3 мин.
		            <OPTION value=5>5 мин.
		            <OPTION value=10>10 мин.
	    		</SELECT>
	    		Тип боя 
	    		<SELECT name=battle_type class=new>
		    		<OPTION value=1 selected>с оружием
					<OPTION value=100>кровавый
				</SELECT>             
				<INPUT type=submit name=open value="Подать заявку" class=new>
        </FIELDSET>
		</form>
	</td></tr></table>
	<?
}
/*=========================awaiting============================*/
else if($zayavka_status=="awaiting")
{
	?>
	<form action="zayavka.php" method="POST">
		<B>Ваша заявка ожидает подтверждения.</B> <input name='recall' type='submit' value='Отозвать заявку' class='new'>
	</form>
	<?
}
/*=========================confirm_mine============================*/
else if($zayavka_status=="confirm_mine")
{
	$OPP_DATA=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE login='".$opponent."'"));
	?>
	<form name="accept" action="zayavka.php?boy=phisic&act=confirm" method="POST">
		<B>Желаете сразиться с</B> 
		<?echo "<script>drwfl('".$OPP_DATA['login']."','".$OPP_DATA['id']."','".$OPP_DATA['level']."','".$OPP_DATA['dealer']."','".$OPP_DATA['orden']."','".$OPP_DATA['admin_level']."','".$OPP_DATA['clan_short']."','".$OPP_DATA['clan']."');</script>";?>
		<input type='submit' name='accept' value='Битва' class='new'> <input type='submit' name='denie' value='Отказать' class='new'>
	</form>
	<?
}
/*=========================confirm_opp============================*/
else if($zayavka_status=="confirm_opp")
{
	?>
	<form action="zayavka.php" method="POST">
		<B>Ожидаем подтверждения боя</B> <input name='recallBattle' type='submit' value='Отозвать заявку' class='new'>
	</form>
	<?
}
/*=================================================================================================================*/
$QUERY=mysql_query("SELECT * FROM zayavka WHERE type IN (1,2,100) and status!='3' ".($_REQUEST['all']>0?'':"and (minlev1='".$db["level"]."' or minlev2='".$db["level"]."')")." and city ='".$db["city_game"]."' ORDER BY date DESC");
if (mysql_num_rows($QUERY))
{	
	echo "<FORM METHOD=POST ACTION=zayavka.php>";
	echo "<INPUT TYPE=submit value=\"Принять вызов\" NAME=confirm2><BR>";
	while($data=mysql_fetch_array($QUERY))
	{
		$creator      	= $data["creator"];
		$date         	= $data["date"];
		$timeout      	= $data["timeout"];
		$battle_type  	= $data["type"];
		$battle_img="<img src='img/battletype/".($battle_type==1?"1.gif' alt='Бой с оружием'":(($battle_type==100)?"3.gif' alt='Кровавый бой'":"2.gif' alt='Кулачный бой'"))."  border='0' >";
		$team1 = "";
		$team2 = "";

		$query_team=mysql_query("SELECT level, id, orden, admin_level, clan_short, clan, dealer, login, teams.team FROM teams LEFT JOIN users ON users.login=teams.player WHERE teams.battle_id='".$creator."'");
		while ($DATS=mysql_fetch_array($query_team)) 
		{
			if ($DATS['team']==1) $team1="<script>drwfl('".$DATS['login']."','".$DATS['id']."','".$DATS['level']."','".$DATS['dealer']."','".$DATS['orden']."','".$DATS['admin_level']."','".$DATS['clan_short']."','".$DATS['clan']."');</script>&nbsp;";
			else $team2="<i style='color:#191970'>против</i> <script>drwfl('".$DATS['login']."','".$DATS['id']."','".$DATS['level']."','".$DATS['dealer']."','".$DATS['orden']."','".$DATS['admin_level']."','".$DATS['clan_short']."','".$DATS['clan']."');</script>&nbsp;\n";
		}
		echo "<div style='padding: 1px;'>";
		echo "<input type=radio ".((($creator==$db['id']) || ($data['status']==2))?'disabled':'')." NAME=gocombat value='$creator' >".substr($date,10,9)." $team1 $team2 тип боя: $battle_img ";
		echo "(таймаут <b>$timeout</b> мин.)";
		echo "</div>";
	}
	echo "<INPUT TYPE=submit value=\"Принять вызов\" NAME=confirm2><BR>";
	echo "</form>";
}
mysql_free_result($QUERY);

?>
</td>
<td width=200 valign=top>
	<form name="lev" action="zayavka.php" method="POST">
		<FIELDSET style="width:200px; border:1px outset;"><LEGEND>Показывать заявки</LEGEND>
		<?echo	"&nbsp;<INPUT TYPE=radio ID=A1 NAME=all value=0".($_REQUEST['all']>0?'':' checked')."> <LABEL FOR=A1>моего уровня</LABEL><BR>
			&nbsp;<INPUT TYPE=radio ID=A2 NAME=all value=1".($_REQUEST['all']>0?' checked':'')."> <LABEL FOR=A2>все</LABEL>";
		?>	
		<br>&nbsp;<input type=submit value=" OK " class=new >
		</FIELDSET>	
	</form>
</td>
</tr>
</table>
</body>
</html>	
<?mysql_close();?>