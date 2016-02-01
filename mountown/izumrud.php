<?
$login=$_SESSION['login'];
$mine_id=$db["id"];
$now=md5(time());
$time=($db["izumrud_time"]+1*1800)-time();
##============================================================
#mysql_query("DELETE FROM labirint where user_id='".$login."'");
##==============Go To Podzemka================================
$sel_me=mysql_fetch_array(mysql_query("SELECT status FROM izumrud_group LEFT JOIN izumrud_login on izumrud_login.player='".$login."' WHERE izumrud_group.id=izumrud_login.group_id"));
if ($sel_me["status"]==2)
{
	Header("Location: main.php?act=go&level=izumrud_floor&tmp=$now");
	die();
}
##==============Delete Comments================================
if ($_GET["del_id"] && $db["orden"]==1)
{
	$del_id=(int)$_GET["del_id"];
	mysql_query("UPDATE izumrud_group SET comment='<font color=#ff0000><i>Удалено Представителям порядка ".$login."</i></font>' WHERE id='".(int)$_GET["del_id"]."'");
}	
##==============Qrup Yaratmaq================================
if ($_POST["open"] && $time<0)
{
	$have_chek=mysql_fetch_Array(mysql_query("SELECT count(*) FROM inv WHERE owner='".$login."' and object_type='wood' and object_id=21"));
	if ($have_chek[0] || $db["adminsite"] || $db["level"]>=8)
	{
		$res=mysql_fetch_Array(mysql_query("SELECT * FROM izumrud_login WHERE player='".$login."'"));
		if (!$res)
		{
			$comment=htmlspecialchars(addslashes($_POST["comment"]));
			$pass=htmlspecialchars(addslashes($_POST["pass"]));
			mysql_query("INSERT INTO izumrud_group (status,creator,comment,pass) VALUES ('1','".$mine_id."','".$comment."','".$pass."')");
			$group_id=mysql_insert_id();
			mysql_query("INSERT INTO izumrud_login  VALUES ('".$login."','".$group_id."','1')");
			mysql_query("UPDATE users SET zayava=1 WHERE login='".$login."'");
			$db['zayava']=1;
			$_SESSION["izumrud_start"]=1;
		}
		else $errmsg="Вы уже и так в группе";
	}
	else $errmsg="Без <b>Пропуска</b> не зайдешь!!!";
}
##==============Qrupdan Cixmaq================================
else if ($_POST["leave"])
{
	$sel_me=mysql_fetch_array(mysql_query("SELECT * FROM izumrud_group LEFT JOIN izumrud_login on izumrud_login.player='".$login."' WHERE izumrud_group.id=izumrud_login.group_id"));
	if ($sel_me && $sel_me["status"]!=2)
	{
		if ($sel_me["creator"]==$mine_id)
		{
			$sql1=mysql_query("SELECT * FROM izumrud_login WHERE group_id=".$sel_me["id"]);
			while ($res=mysql_fetch_array($sql1))
			{
				mysql_query("UPDATE users SET zayava=0 WHERE login='".$res["player"]."'");
			}
			mysql_query("DELETE FROM izumrud_group WHERE id='".$sel_me["id"]."'");
			mysql_query("DELETE FROM izumrud_login WHERE group_id='".$sel_me["id"]."'");
		}
		else 
		{
			mysql_query("DELETE FROM izumrud_login WHERE player='".$login."'");
			mysql_query("UPDATE users SET zayava=0 WHERE login='".$login."'");
		}
		$db['zayava']=0;
		$errmsg="Вы покинули группу";
		$_SESSION["izumrud_start"]=0;
	}
}
##==============Qrupa Qowulmaq================================
else if ($_REQUEST["goid"] && $time<0)
{
	$have_chek=mysql_fetch_Array(mysql_query("SELECT count(*) FROM inv WHERE owner='".$login."' and object_type='wood' and object_id=21"));
	if ($have_chek[0] || $db["adminsite"] || $db["level"]>=12)
	{
		$goid=(int)$_REQUEST["goid"];
		$pass=htmlspecialchars(addslashes($_REQUEST["pass"]));
		if (!$db['zayava'])
		{
			$me=mysql_fetch_array(mysql_query("SELECT * FROM izumrud_group WHERE id=".$goid." and status=1"));
			if ($me)
			{
				if ($me["pass"]==$pass)
				{
					mysql_query("INSERT INTO izumrud_login VALUES ('".$login."','".$me["id"]."','0')");
					mysql_query("UPDATE users SET zayava=1 WHERE login='".$login."'");
					$db['zayava']=1;
					$_SESSION["izumrud_start"]=1;
				}
				else $errmsg="Не угадали пароль";
			}
			else
			{
				$errmsg="Нет такой группы";
			}
		}
		else $errmsg="Вы и так в группе";
	}
	else $errmsg="Без <b>Пропуска</b> не зайдешь!!!";
}
##==============START LABIRINT================================
else if ($_POST["start"])
{
	$if_me=mysql_fetch_array(mysql_query("SELECT * FROM izumrud_group WHERE creator='".$mine_id."'"));
	if ($if_me)
	{
		$_SESSION["izumrud_start"]=0;
		mysql_query("UPDATE izumrud_group SET status=2 WHERE creator='".$mine_id."'");
		mysql_query("DELETE FROM inv WHERE id IN(SELECT NEWTABLENAME.id FROM (SELECT inv.id FROM `inv` WHERE owner in (SELECT player FROM izumrud_login) and object_type='wood' and object_id=21 GROUP BY owner) AS NEWTABLENAME )");
		Header("Location: main.php?act=go&level=izumrud_floor&tmp=$now");
		die();
	}
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
<body style="background-image: url(img/index/izumrud.jpg);background-repeat:no-repeat;background-position:top right">
<h3>Загадочная пещера(TestVer1.0)</h3>
<table width=100%>
<tr>
	<td>
		<input type=button value='Загадочный магазин' style="background-color:#AA0000; color: white;" onclick="document.location='main.php?act=go&level=izumrud_shop'">
	</td>
	<td align=right>
		<input type=button value='Вернуться' class=newbut onclick="document.location='main.php?act=go&level=bazar'">
		<input type=button value='Обновить'  class=newbut onClick="location.href='?act=none'">
	</td>
</tr>
<tr>
	<td colspan=2><font color=#ff0000><?=$errmsg?></font>&nbsp;</td>
</tr>
<tr>
	<td valign=top colspan=2>
		<?
			echo "<TABLE cellpadding=1 cellspacing=0>";
			$my=0;
			$sql_gr=mysql_query("SELECT * FROM izumrud_group WHERE status=1 ORDER BY date DESC");
			if (mysql_num_rows($sql_gr))
			{	
				echo "<b>Заявки:<b><br>";
				while ($groups=mysql_fetch_array($sql_gr))
				{
					$comment=$groups["comment"];
					$pass=$groups["pass"];
					$creator=$groups["creator"];
					$group_id=$groups["id"];
					$dates=$groups["date"];
					if ($creator==$db["id"])$my++;
					$teams = "";
					$t=mysql_query("SELECT users.level,users.id,users.orden,users.admin_level,users.clan_short,users.clan,users.dealer,users.login FROM izumrud_login z LEFT JOIN users on users.login=z.player WHERE z.group_id='".$group_id."'");
					while ($DATS=mysql_fetch_array($t))
					{
						$teams.="<script>drwfl('".$DATS['login']."','".$DATS['id']."','".$DATS['level']."','".$DATS['dealer']."','".$DATS['orden']."','".$DATS['admin_level']."','".$DATS['clan_short']."','".$DATS['clan']."');</script>&nbsp; ";
					}
					echo "<tr><td><FORM action='?act=none'>";
					echo "<INPUT TYPE=hidden NAME=goid value='".$group_id."'>";
					echo $dates."&nbsp;".$teams.($comment!=""?"<SMALL>| ".$comment."</SMALL> ":" ").(!$podal && $pass!=""?"<INPUT type='password' name='pass' size=5> ":" ").(!$podal?"<INPUT type='submit' value='Присоед.'>":"").($db['orden']==1?"&nbsp; <a href='?del_id=$group_id'><img src='img/icon/del.gif'></a>":"");
					echo "</FORM>";
					echo "</td></tr>";
				}
			}		
			echo "</table>";
			if ($time<0)
			{
				if (!$podal)
				{
					echo '<FORM id="REQUEST" method="POST" action="?act=none">
					<FIELDSET style=\'padding-left: 5; width=50%\'>
					<LEGEND><B> Группа </B> </LEGEND>
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
				$h=floor($time/3600);
				$m=floor(($time-$h*3600)/60);
				$sec=$time-$h*3600-$m*60;
				if($h<=0){$hour="";}else $hour="$h ч.";
				if($m<0){$minut="";}else $minut="$m мин.";
				if($sec<0){$sec=0;}
				$left="$hour $minut $sec сек.";
				echo "<b>Вы можете посетить Загадочная пещера через ".$left."</b>";
			}
		?>
	</td>
</tr>
</table>
<?
		$res=mysql_fetch_array(mysql_Query("SELECT count(*) FROM izumrud_login LEFT JOIN online on online.login=izumrud_login.player WHERE online.room in ('izumrud_floor')"));
		echo "(сейчас в лабиринте online: ".$res[0]." чел.)";
?>
<br><br><br><br>
<?include_once("counter.php");?>