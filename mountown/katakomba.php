<?
$login=$_SESSION['login'];
$mine_id=$db["id"];
$now=md5(time());
$time=($db["last_request_time"]+7200)-time();
//------------------------------------------------------
#mysql_query("DELETE FROM labirint where user_id='".$login."'");
//--------------Go To Podzemka--------------------------
$sel_me=mysql_fetch_array(mysql_query("SELECT status FROM zayavka_teams LEFT JOIN zayavka_bot on zayavka_bot.id=zayavka_teams.battle_id WHERE player='".$login."'"));
if ($sel_me["status"]==2)
{
	Header("Location: main.php?act=go&level=dungeon&tmp=$now");
	die();
}
//-----------Delete Comments--------------------
if ($_GET["del_id"] && $db["orden"]==1)
{
	$del_id=(int)$_GET["del_id"];
	mysql_query("UPDATE zayavka_bot SET comment='<font color=#ff0000><i>Удалено Представителям порядка ".$login."</i></font>' WHERE id='".(int)$_GET["del_id"]."'");
}
//-----------Qrup Yaratmaq--------------------
if ($_POST["open"] && $time<0)
{
	if ($db["level"]<4 && !$db["adminsite"])$errmsg="Минимальный уровень 4";
	else if ($db["level"]>14 && !$db["adminsite"])$errmsg="Максимальный уровень 14";
	else 
	{	
		$sql=mysql_query("SELECT * FROM zayavka_teams WHERE player='".$login."'");
		$res=mysql_fetch_Array($sql);
		if (!$res)
		{
			$comment=htmlspecialchars(addslashes($_POST["comment"]));
			$pass=htmlspecialchars(addslashes($_POST["pass"]));
			mysql_query("INSERT INTO zayavka_bot (status,creator,comment,pass) VALUES (1,'".$mine_id."','".$comment."','".$pass."')");
			$b_id=mysql_insert_id();
			mysql_query("INSERT INTO zayavka_teams  VALUES ('$login','".$db["remote_ip"]."','".$b_id."',1)");
			mysql_query("UPDATE users SET zayava=1 WHERE login='".$login."'");
			$db['zayava']=1;
			$_SESSION["nachalo"]=1;
		}
		else $errmsg="Вы уже и так в группе";
	}
}
//-----------Qrupdan Cixmaq--------------------
else if ($_POST["leave"])
{
	$sel_me=mysql_fetch_array(mysql_query("SELECT * FROM zayavka_teams LEFT JOIN zayavka_bot on zayavka_bot.id=zayavka_teams.battle_id WHERE player='".$login."'"));
	if ($sel_me && $sel_me["status"]!=2)
	{
		if ($sel_me["creator"]==$mine_id)
		{
			$sql1=mysql_query("SELECT * FROM zayavka_teams WHERE battle_id=".$sel_me["id"]);
			while ($res=mysql_fetch_array($sql1))
			{
				mysql_query("UPDATE users SET zayava=0 WHERE login='".$res["player"]."'");
			}
			mysql_query("DELETE FROM zayavka_bot WHERE id='".$sel_me["id"]."'");
			mysql_query("DELETE FROM zayavka_teams WHERE battle_id='".$sel_me["id"]."'");
		}
		else 
		{
			mysql_query("DELETE FROM zayavka_teams WHERE player='".$login."'");
			mysql_query("UPDATE users SET zayava=0 WHERE login='".$login."'");
		}
		$db['zayava']=0;
		$errmsg="Вы покинули группу";
		$_SESSION["nachalo"]=0;
	}
}
//-----------Qrupa Qowulmaq--------------------
else if ($_REQUEST["goid"] && $time<0)
{
	$goid=(int)$_REQUEST["goid"];
	$pass=htmlspecialchars(addslashes($_REQUEST["pass"]));
	if (!$db['zayava'])
	{
		if ($db["level"]>7)$errmsg="Максимальный уровень 7";
		else
		{
			$me=mysql_fetch_array(mysql_query("SELECT * FROM zayavka_bot WHERE id=".$goid." and status=1"));
			if ($me)
			{
				if ($me["pass"]==$pass)
				{
					mysql_query("INSERT INTO zayavka_teams  VALUES ('$login','".$db["remote_ip"]."','".$me["id"]."',0)");				
					mysql_query("UPDATE users SET zayava=1 WHERE login='".$login."'");
					$db['zayava']=1;
					$_SESSION["nachalo"]=1;
				}
				else $errmsg="Не угадали пароль";
			}
			else
			{
				$errmsg="Нет такой группы $goid";
			}
		}
	}
	else $errmsg="Вы и так в группе";
}
//-----------START--------------------
else if ($_POST["start"])
{
	$if_me=mysql_fetch_array(mysql_query("SELECT * FROM zayavka_bot WHERE creator='".$mine_id."'"));
	if ($if_me)
	{
		$_SESSION["nachalo"]=0;
		mysql_query("UPDATE zayavka_bot SET status=2 WHERE creator='".$mine_id."'");			
		Header("Location: main.php?act=go&level=dungeon&tmp=$now");
		die();
	}
	//$errmsg="Ждем открытие ворот";
}
//-------------------------------------------------
$podal=($db['zayava']==1?true:false);
if ($podal)
{
	echo "<script>
			function refreshPeriodic()
			{
				location.href='main.php?act=none';
				timerID=setTimeout('refreshPeriodic()',20000);
			}
			timerID=setTimeout('refreshPeriodic()',20000);
		</script>";
}	
?>
<body style="background-image: url(img/index/kata.jpg);background-repeat:no-repeat;background-position:top right">
<SCRIPT src="dungeon.js"></SCRIPT>
<table width=100% border=0>
<tr>
	<td width=100%><h3>Спуск в Катакомбы</h3></td>
	<td nowrap valign=top>
		<input type=button class=newbut value='Вернуться' onclick="document.location='main.php?act=go&level=bazar'">
		<input type=button class=newbut value='Обновить' onClick="location.href='?act=none'">
	</td>
</tr>
<tr>
	<td width=100% colspan=2><font color=#ff0000><?=$errmsg?></font>&nbsp;</td>
</tr>
<tr>
	<td valign=top colspan=2>
		<?
			echo "<TABLE cellpadding=0 cellspacing=0>";
			$my=0;
			$sql_gr=mysql_query("SELECT * FROM zayavka_bot WHERE status=1");
			if (mysql_num_rows($sql_gr))
			{	
				echo "<b>Заявки:<b><br>";
				while ($groups=mysql_fetch_array($sql_gr))
				{
					$comment=$groups["comment"];
					$pass=$groups["pass"];
					$creator=$groups["creator"];
					$creator_id=$groups["id"];
					$dates=$groups["date"];
					if ($creator==$mine_id)$my=1;
					$teams = "";
					$t=mysql_query("SELECT zayavka_teams.*,level,id,orden,admin_level,clan_short,clan,dealer,login FROM zayavka_teams LEFT JOIN users on users.login=zayavka_teams.player WHERE battle_id='".$groups["id"]."'");
					while ($DATS=mysql_fetch_array($t))
					{
						$teams.="<script>drwfl('".$DATS['login']."','".$DATS['id']."','".$DATS['level']."','".$DATS['dealer']."','".$DATS['orden']."','".$DATS['admin_level']."','".$DATS['clan_short']."','".$DATS['clan']."');</script>&nbsp; ";
					}
					echo "<tr><td><FORM action='?act=none'>";
					echo "<INPUT TYPE=hidden NAME=goid value=$creator_id>";
					echo $dates."&nbsp;".$teams.($comment!=""?"<SMALL>| $comment</SMALL> ":" ").(!$podal && $pass!=""?"<INPUT type='password' name='pass' size=5> ":" ").(!$podal?"<INPUT type='submit' value='Войти в группу.'>":"").($db['orden']==1?"&nbsp; <a href='?del_id=$creator_id'><img src='img/icon/del.gif'></a>":"");
					echo "</FORM>";
					echo "</td></tr>";
				}
				echo "<TR><TD colspan=2 align=left><hr style='width:500px'></TD></TR>";
			}		
			echo "</table>";
			if ($time<0)
			{
				if (!$podal)
				{
					echo '<FORM id="REQUEST" method="POST" action="?act=none">
					<FIELDSET style=\'padding-left: 5; width=50%\'>
					<LEGEND><B> Создать группу </B> </LEGEND>
					Комментарий: <INPUT TYPE=text NAME="comment" maxlength=40 size=40><BR>
					Пароль: <INPUT TYPE=password NAME="pass" maxlength=25 size=25><BR>
					<INPUT TYPE=submit name="open" value="Создать группу">
					</FIELDSET>
					</FORM>';
				}
				else
				{
					echo '<FORM id="REQUEST" method="POST" action="?act=none">
					<FIELDSET style=\'padding-left: 5; width=50%\'>
					<LEGEND><B> Группа </B> </LEGEND>'.
					($my?'<INPUT type=\'submit\' name=\'start\' value=\'Вход в пещеру\'> &nbsp;':'')
					.'<INPUT type=\'submit\' name=\'leave\' value=\'Покинуть группу\'>
					</FIELDSET>
					</FORM>';
				}
			}
			else
			{
				//$time=$db["last_request_time"]-time();
				$h=floor($time/3600);
				$m=floor(($time-$h*3600)/60);
				$sec=$time-$h*3600-$m*60;
				if($h<=0){$hour="";}else $hour="$h ч.";
				if($m<0){$minut="";}else $minut="$m мин.";
				if($sec<0){$sec=0;}
				$left="$hour $minut $sec сек.";
				echo "<b>Вы можете посетить Подземелья Призраков через ".$left."</b>";
			}
		?>
	</td>
</tr>
</table>
<?
		$res=mysql_fetch_array(mysql_Query("SELECT count(*) FROM zayavka_teams LEFT JOIN online on online.login=zayavka_teams.player WHERE online.room='dungeon'"));
		echo "(сейчас в лабиринте online: ".$res[0]." чел.)";
?>
<br><br><br><br>
<?include_once("counter.php");?>