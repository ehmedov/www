<?
$login=$_SESSION["login"];	
$mine_id=$db["id"];
$move_time=5; // Время Перехода...
if ($db["adminsite"])$move_time=0; 
$users=array();
$ip=$db["remote_ip"];
include("modules/warcrypt_mod.php");
$winner=0;
$now=md5(time());
$date = date("d.m.y H:i");
$battle_type=29;
##================================================================
$sql_=mysql_fetch_array(mysql_query("SELECT * FROM war_team WHERE player='".$login."'"));
$group_id=$sql_["group_id"];
$my_team=$sql_["team"];
if (!$group_id || !$db["zayava"] || $sql_["lose"])
{
	mysql_query("DELETE FROM labirint WHERE user_id='".$login."'");
	Header("Location: main.php?act=go&level=warcrypt&tmp=$now");
	die();
}
##================================================================
$team_count1=mysql_fetch_Array(mysql_query("SELECT count(*) FROM online LEFT JOIN war_team ON war_team.player=online.login WHERE war_team.team=1 and war_team.lose=0"));
$team_count2=mysql_fetch_Array(mysql_query("SELECT count(*) FROM online LEFT JOIN war_team ON war_team.player=online.login WHERE war_team.team=2 and war_team.lose=0"));
if($team_count1[0] && !$team_count2[0])
{
	$winner=1;
}
if(!$team_count1[0] && $team_count2[0])
{
	$winner=2;
}
if($winner)
{
	$sql_winners=mysql_query("SELECT * FROM war_team");
	while($res_Winners=mysql_fetch_Array($sql_winners))
	{
		mysql_query("UPDATE users SET zayava=0 ".($res_Winners["team"]==$winner?", shoptime=".(time()+12*3600).", doblest=doblest+5":"")." WHERE login='".$res_Winners["player"]."'");
	}
	mysql_query("DELETE FROM `labirint` WHERE user_id in (SELECT player FROM war_team)");
	mysql_query("TRUNCATE TABLE `war_group`");
	mysql_query("TRUNCATE TABLE `war_team`");
	say("toall_news","<font color=#ff0000>Бой <b>СВЕТ VS TЬМА</b> закончен. <b>Победил ".($winner==1?"Свет":"Тьма")."</b></font>","bor");
	Header("Location: main.php?act=go&level=warcrypt&tmp=$now");
	die();
}
#######################################################################
$ctime=time();
$r=mysql_fetch_Array(mysql_query("SELECT * FROM labirint WHERE user_id='".$login."'"));
if(!$r) 
{
	// начало лабиринта
	if ($my_team==1)$my_cord="32x5"; else $my_cord="2x24"; 
	$my_vector=180;
	$Time=time();
	mysql_query("INSERT INTO labirint(user_id, location, vector, visit_time) VALUES('".$login."', '".$my_cord."', '".$my_vector."', '".$Time."')");
}
else
{
	// определим видимую область
	$my_cord=$r['location'];
	$my_vector=$r['vector'];
	$Time=$r['visit_time'];
}
#######################################################################
$dtim=$ctime-$Time;
if($_GET['action'] && $dtim>=$move_time) 
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
	else if($_GET['action']=='forward')	
	{
		$step1=next_step($my_cord, $my_vector);
		if($step1['fwd'])
		{
			$my_cord=$step1['fwd'];
			$Time=$ctime;
		}
	}
	mysql_query('UPDATE labirint SET location="'.$my_cord.'", vector="'.$my_vector.'", visit_time="'.$Time.'" WHERE user_id="'.$login.'"');
}


$step1=next_step($my_cord, $my_vector);
if($step1['fwd']) $step2=next_step($step1['fwd'], $my_vector);
if($step2['fwd']) $step3=next_step($step2['fwd'], $my_vector);
if($step3['fwd']) $step4=next_step($step3['fwd'], $my_vector);
else $step4['fwd']=false;

#echo $my_cord."-".$my_vector."-".$step1['fwd']."-";
#################################Нападение######################################
if ($_GET["attack"])
{
  	$char_id=(int)$_GET["attack"];  
  	if($char_id==$db["id"])
	{
		$msg="Нападение на самого себя - это уже мазохизм...";
	}
	else if(!$db["battle"])
	{
		$res=mysql_fetch_array(mysql_query("SELECT users.battle, users.last_ip, war_team.*, labirint.location FROM `users` LEFT JOIN war_team ON war_team.player=users.login LEFT JOIN labirint ON labirint.user_id=users.login WHERE id = '".$char_id."'"));
		if(!$res)
		{
			$msg="Персонаж не найден.";
		}
		else if ($res['lose'])
		{
			$msg="Боец \"".$res["player"]."\" уже проиграл!";
		}
        else if($db["zayavka"]==1)
        {
        	$msg="Сначала отзовите текущую заявку...</b>";
        }
		else if ($step1['fwd']==$res["location"])
		{
			if ($res["battle"]==0)
			{
				$timeout = time()+3*60;
		        say("toroom","<b>".$login."</b> напал на <b>".$res["player"]."</b>",$login);
		        mysql_query("INSERT INTO zayavka(status,type,timeout,creator) VALUES('3','".$battle_type."','3','".$mine_id."')");
		        mysql_query("INSERT INTO teams(player,team,ip,battle_id) VALUES('".$db["login"]."','2','".$db["last_ip"]."','".$mine_id."')");
		        mysql_query("INSERT INTO teams(player,team,ip,battle_id) VALUES('".$res["player"]."','1','".$res["last_ip"]."','".$mine_id."')");
				mysql_query("INSERT INTO battles(type, creator_id, lasthit) VALUES('".$battle_type."', '".$mine_id."', '".$timeout."')");
		        goBattle($db["login"]);
		        goBattle($res["player"]);
			}
			else if ($res["battle"]!=0)
			{
				$D=mysql_fetch_array(mysql_query("SELECT * FROM teams WHERE player='".$res["player"]."'"));
				if ($D)
				{
					mysql_query("INSERT INTO teams(player, team, ip, battle_id) VALUES('".$login."','".($D["team"]==1?2:1)."','".$db["last_ip"]."','".$D["battle_id"]."')");
					$att="<span class=date2>$date</span> <script>drwfl('".$db['login']."','".$db['id']."','".$db['level']."','".$db['dealer']."','".$db['orden']."','".$db['admin_level']."','".$db['clan_short']."','".$db['clan']."');</script> вмешался в поединок!</b><hr>";
					battle_log($res['battle'], $att);
			        goBattle($login);
				}
			}
		}
	}
}
##################Декорации#############################################333
foreach($Items_Array as $item_info)
{
	if (in_array ($step1["fwd_cord"], $item_info))
	{
		$draw_item_fwd = $item_info["type"];
	}
	if (in_array ($step2["fwd_cord"], $item_info))
	{
		$draw_item_fwd1= $item_info["type"];
	}
}

$dtim=$ctime-$Time;
?>
<SCRIPT src="dungeon.js"></SCRIPT>
<script>
	var Hint3Name = '';
	// Заголовок, название скрипта, имя поля с логином
	function findlogin(title, script, name)
	{
		document.all("hint3").innerHTML = '<table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: hand" onclick="closehint3();"><BIG><B>x</td></tr><tr><td colspan=2>'+
		'<table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><form action="'+script+'" method=POST><INPUT TYPE=hidden name=sd4 value="<? echo $myinfo->id_person; ?>"><td colspan=2>'+
		'Укажите логин персонажа:<small><BR>(можно щелкнуть по логину в чате)</TD></TR><TR><TD width=50% align=right><INPUT TYPE=text NAME="'+name+'"></TD><TD width=50%><INPUT type=image SRC="img/dmagic/gray_30.gif"></TD></TR></FORM></TABLE></td></tr></table>';
		document.all("hint3").style.visibility = "visible";
		document.all("hint3").style.left = 100;
		document.all("hint3").style.top = 100;
		document.all(name).focus();
		Hint3Name = name;
	}
	function closehint3()
	{
		document.all("hint3").style.visibility="hidden";
	    Hint3Name='';
	}
</script>
<div id=hint3></div>
<h3>Пещера Воинов</h3>
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
</script>
<DIV ID=oMenu CLASS="menu"></DIV>
<?
echo "
<table width=100% border=0>
<tr>
<td width=100% valign=top>";
	$pl_sql=mysql_query("SELECT users.id, users.login, users.battle, level, dealer, orden, admin_level, clan_short, clan, hp, hp_all, labirint.location, war_team.team FROM war_team LEFT JOIN users ON users.login=war_team.player LEFT JOIN labirint on labirint.user_id=war_team.player WHERE group_id='".$group_id."' and war_team.lose=0");
	WHILE ($players=mysql_fetch_Array($pl_sql))
	{
		$team_str="
		<tr height=10 nowrap>
			<td>
				<a href='javascript:top.AddToPrivate(\"".$players['login']."\")'><img border=0 src=img/arrow3.gif alt=\"Приватное сообщение\" ></a> 
				<script>drwfl('".$players['login']."','".$players['id']."','".$players['level']."','".$players['dealer']."','".$players['orden']."','".$players['admin_level']."','".$players['clan_short']."','".$players['clan']."');</script>&nbsp;
			</td>
			<td>
				<script>show(".$players["hp"].",".$players["hp_all"].");</script>
			</td>
			<td>
				&nbsp;<small>[".$players['location']."]".($players['battle']?" <a href='log.php?log=".$players['battle']."' target='_blank'><img src='img/b.jpg'>":"")."</small>
			</td>
			<td width=20 nowrap>
				".($my_team!=$players["team"] && $step1['fwd']==$players['location']?"<a href='?attack=".$players['id']."'><img src='img/fight.gif' title='напаст'></a>":"")."
			</td>
		</tr>";
		if ($players["team"]==1)$team1_str.=$team_str;else $team2_str.=$team_str;
		if ($login!=$players["login"])$users[]=array(login=>$players["login"],coord=>$players["location"]);
	}
	echo "
	<table border=0 cellpadding=0 cellspacing=0>
		<tr><td colspan=4 class=newbut align=center><b>Свет</td></tr>
		$team1_str
		<tr><td colspan=4 height=30></td></tr>
		<tr><td colspan=4 class=newbut align=center><b>Тьма</td></tr>
		$team2_str	
	</table><br>";
	echo "<font color=#ff0000>$msg</font>";
//-----------------
echo "</td>";

echo "<td valign=top align=right>
<table bgcolor=#000000 width=100%><tr><td>";
echo "<div id=\"brodilka\" style=\"width:366px; height:260px; position:relative; background-color:#000000; z-index:0; overflow:hidden\" align=\"center\">
<!--menu-->
<div id=\"pmenu\" style=\"width:60px; height:20px; position:absolute; display:none; top:10px; left:10px; background-color:#CCCCCC; border-width:1px; border-color:#000000; border-style:solid; white-space:nowrap; padding:2px; z-index:8; text-align:right;\"></div>";
echo "\n\n <!--1 слой-->\n";
if(!$step1["left"])	{echo"<div style=\"position:absolute; top:10px; left:10px; z-index:7;\"><img src=\"img/warcrypt/1_left_wall.gif\" /></div>";}
if(!$step1["fwd"])	{echo"<div style=\"position:absolute; top:10px; left:10px; z-index:7;\"><img src=\"img/warcrypt/1_front_wall.gif\" /></div>";}
if(!$step1["right"]){echo"<div style=\"position:absolute; top:10px; right:0px; z-index:7;\"><img src=\"img/warcrypt/1_right_wall.gif\" /></div>";}

#бот!
echo "\n<div id='us' style='Z-INDEX:11; POSITION:absolute; LEFT:10px;TOP:60px;' onmouseout=\"closeMenu();\"></div>\n";
###
if ($users!="")
{
	foreach ($users as $currentValue) 
	{
		if (in_array ($step1['fwd'], $currentValue)) 
		{
			echo"<div style=\"Z-INDEX:12; LEFT:130px; POSITION:absolute; TOP:40px;\"><img src=\"img/warcrypt/shadow.gif\" alt=\"".$currentValue["login"]."\" style=\"CURSOR:hand\"></div>";
		}
	}
}
if($draw_item_fwd)
{
	echo"<div style=\"Z-INDEX:11; LEFT:10px; POSITION:absolute; TOP:10px; \"><img src='img/warcrypt/misc/".$draw_item_fwd."_fwd1.gif' style='border:0; CURSOR:hand;'></div>";
}	
echo"\n\n<!--2 слой-->\n";
if(!$step2["left"])	{echo "<div style=\"position:absolute; top:10px; left:10px; z-index:5;\"><img src=\"img/warcrypt/2_left_wall.gif\" /></div>"; }
if(!$step2["fwd"])	{echo "<div style=\"position:absolute; top:10px; left:10px; z-index:5;\"><img src=\"img/warcrypt/2_front_wall.gif\" /></div>";}
if(!$step2["right"]){echo "<div style=\"position:absolute; top:10px; right:0px; z-index:5;\"><img src=\"img/warcrypt/2_right_wall.gif\" /></div>";}

if($draw_item_fwd1)
{
	echo"<div style=\"Z-INDEX:9; LEFT:10px; POSITION:absolute; TOP:10px; \"><img src='img/warcrypt/misc/".$draw_item_fwd1."_fwd2.gif' style='border:0;'></div>";
}

if ($users!="")
{
	foreach ($users as $currentValue) 
	{
		if (in_array ($step2['fwd'], $currentValue)) 
		{
			echo"<div style=\"Z-INDEX:8; LEFT:150px; POSITION:absolute; TOP:55px;\"><img src=\"img/warcrypt/shadow.gif\" width=\"70\" alt=\"".$currentValue["login"]."\" style=\"CURSOR:hand\"></div>";
		}
	}
}
echo"\n\n<!--3 слой-->\n";
if(!$step3["left"]) {echo"<div style=\"position:absolute; top:10px; left:10px; z-index:3;\"><img src=\"img/warcrypt/3_left_wall.gif\" /></div>";}
if(!$step3["fwd"])	{echo"<div style=\"position:absolute; top:10px; left:10px; z-index:3;\"><img src=\"img/warcrypt/3_front_wall.gif\" /></div>";}
if(!$step3["right"]){echo"<div style=\"position:absolute; top:10px; right:0px; z-index:3;\"><img src=\"img/warcrypt/3_right_wall.gif\" /></div>";}

echo"\n\n<!--пол и потолок-->";
echo "<div id=\"l1ce\" style=\"position:absolute; top:10px; left:10px; z-index:0;\"><img src=\"img/warcrypt/bg.gif\"/></div>";

echo"\n\n<!--4 слой-->";
if(!$step4["left"])	{echo"<div id=\"l4l\" style=\"position:absolute; top:10px; left:10px; z-index:1;\"><img src=\"img/warcrypt/4_left_wall.gif\" id=\"lv4l\" /></div>";}
if(!$step4["right"]){echo"<div id=\"l4r\" style=\"position:absolute; top:10px; right:0px; z-index:1;\"><img src=\"img/warcrypt/4_right_wall.gif\" id=\"lv4r\" /></div>";}

echo"<div style=\"position:absolute; bottom:10px; left:130px; z-index:100;\">
<div><img src=\"img/warcrypt/navigation.gif\"/></div>
<div>";
if($step1['fwd']) 
{
	echo "<a href='?action=forward' onclick='return check_time();'><img src='img/warcrypt/up.gif' style=\"position:absolute; top:12px; left:48px; z-index:0;\" border='0' alt='Вперёд'></a>";
}
else echo "<img src='img/warcrypt/noway.gif' style=\"position:absolute; top:14px; left:46px; z-index:0;\" border='0' alt='Нельзя'>";
echo "<a href='?action=rotateleft' onclick='return check_time();'><img src='img/warcrypt/left.gif' style=\"position:absolute; top:40px; left:12px; z-index:0;\" border='0' alt='Повернуться влево'></a>";
echo "<a href='?action=rotateright' onclick='return check_time();'><img src='img/warcrypt/right.gif' style=\"position:absolute; top:40px; left:88px; z-index:0;\" border='0' alt='Повернуться вправо'></a>";

echo "</div>";

echo "</div>";

echo"</div></td>
<TD width=160 align=center valign=top style='padding:4px' nowrap>";
?>
	<table cellspacing="0" cellpadding="0" width="100" border="0">
	<tr>
		<td width="100" background="img/ug/navigation/bg.gif" height="10"><img height="10" src="img/ug/navigation/move.gif" width="1" name="move" id="move" alt="" /></td>
	</tr>
	<tr>
		<td id=mess style="color:#ffffff">&nbsp;</td>
	</tr>
	</table>
	<?DrawAllMap($my_cord,$my_vector);?>
</td>	
</tr>
</table>
</td>
</tr>
</table>
<br><br><br><br>
<?include_once("counter.php");?>