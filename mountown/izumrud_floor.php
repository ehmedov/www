<?
$login=$_SESSION["login"];	
$mine_id=$db["id"];
$move_time=0; // Время Перехода...
if ($db["adminsite"])$move_time=0; 
if ($db["adminsite"])$logins="Высшая сила";
else $logins=$login;
$db_bots=array();
$ip=$db["remote_ip"];
$etaj=1;
$db["room"]="izumrud_floor";
include("modules/izumrud_mod.php");
//----------------------------------------------
$sql_=mysql_fetch_array(mysql_query("SELECT * FROM izumrud_login WHERE player='".$login."'"));
$group_id=$sql_["group_id"];
$leader=$sql_["leader"];
if (!$group_id)
{
	Header("Location: main.php?act=go&level=izumrud&tmp=$now");
	die();
}	
//----------------------------------------------
$bot_d=mysql_query("SELECT cord FROM izumrud_setting WHERE group_id='".$group_id."' and type='bot' and etaj=$etaj");
while ($bot_db=mysql_fetch_array($bot_d))
{
	$db_bots[]=$bot_db["cord"];
}
mysql_free_result($bot_d);
foreach($db_bots as $value) 
{
	if(count($Bot_Array[$value])) 
	{
		unset($Bot_Array[$value]);
	}
}
//----------------------------------------------
if ($_GET["exit"])
{
	mysql_query("DELETE FROM izumrud_login WHERE player='".$login."'");
	mysql_query("DELETE FROM labirint WHERE user_id='".$login."'");
	mysql_query("UPDATE users SET zayava=0,izumrud_time='".time()."' WHERE login='".$login."'");
	$all_team=mysql_fetch_array(mysql_query("SELECT count(*) as co  FROM izumrud_login WHERE group_id=$group_id"));
	if (!$all_team["co"])
	{
		mysql_query("DELETE FROM izumrud_group WHERE id='".$group_id."'");
		mysql_query("DELETE FROM izumrud_setting WHERE group_id='".$group_id."'");
	}
	Header("Location: main.php?act=go&level=izumrud&tmp=$now");
	die();
}
//----------------------------Нападения--------------------------------------------------
if($_GET['action']=='attack' && count($Bot_Array[$_GET['id']]) && !$db["zayavka"] && $db["hp"]>0)
{
	$id=htmlspecialchars(addslashes($_GET['id']));

	$sel_battle_bot=mysql_query("SELECT * FROM bot_temp WHERE group_id=$group_id and cord='".$id."' and etaj=$etaj");
	if (mysql_num_rows($sel_battle_bot))
	{
		$sel_battle=mysql_fetch_assoc($sel_battle_bot);
		$battle_id=$sel_battle['battle_id'];
		$bat=mysql_fetch_Array(mysql_query("SELECT * FROM battles WHERE id='".$battle_id."'"));
		$creator=$bat['creator_id'];
		mysql_query("INSERT INTO teams(player,team,ip,battle_id,hitted,over) VALUES('".$login."','1','".$ip."','".$creator."','0','0')");
		$date = date("H:i");
		$att="<span class=date2>$date</span> <script>drwfl('".$db['login']."','".$db['id']."','".$db['level']."','".$db['dealer']."','".$db['orden']."','".$db['admin_level']."','".$db['clan_short']."','".$db['clan']."');</script> вмешался в поединок!<hr>";
		battle_log($battle_id, $att);
        goBattle($login);
	}
	else
	{
		$timeout = time()+180;
		mysql_query("UPDATE users SET fwd='".$id."' WHERE login='".$login."'");
	    mysql_query("INSERT INTO zayavka(status,type,timeout,creator) VALUES('3','88','3','".$mine_id."')");
	    mysql_query("INSERT INTO teams(player,team,ip,battle_id,hitted,over) VALUES('".$login."','1','".$ip."','".$mine_id."','0','0')");
		mysql_query("INSERT INTO battles(type, creator_id, lasthit) VALUES('88', '".$mine_id."', '".$timeout."')");
		$b_id=mysql_insert_id();
		foreach($Bot_Array[$id] as $value)
		{
			$i++;
			$attacked_bot=$Bot_Names[$value];
			$GBD = mysql_fetch_array( mysql_query("SELECT hp_all FROM users WHERE login='".$attacked_bot."'"));
			mysql_query("INSERT INTO bot_temp(bot_name,hp,hp_all,battle_id,prototype,team, two_hands,shield_hands,group_id,cord,etaj) VALUES('".$attacked_bot."(".$i.")','".$GBD["hp_all"]."','".$GBD["hp_all"]."','".$b_id."','".$attacked_bot."','2','1','".rand(0,1)."','".$group_id."','".$id."','$etaj')");
		}
		goBattle($login);
	}
	mysql_free_result($sel_battle_bot);
}
//------------выгнать персонажа-----------------------
if ($_POST["kill_member"] && $leader)
{
	$kill_member=htmlspecialchars(addslashes($_POST["kill_member"]));
	$sel_kill=mysql_fetch_array(mysql_query("SELECT * FROM izumrud_login WHERE player='".$kill_member."' and group_id=".$group_id));
	if ($sel_kill && $sel_kill["player"]!=$login)
	{
		mysql_query("DELETE FROM labirint WHERE user_id='".$kill_member."'");
		mysql_query("DELETE FROM izumrud_login WHERE player='".$kill_member."'");
		mysql_query("UPDATE users SET zayava=0,izumrud_time='".time()."' WHERE login='".$kill_member."'");
		say("toroom","Лидер группы <b>".$login."</b> выгнал персонажа <b>".$kill_member."</b> из группы",$login);
	}
}
//------------передать лидерство-----------------------
if ($_POST["change_leader"] && $leader)
{
	$change_leader=htmlspecialchars(addslashes($_POST["change_leader"]));
	$sel_kill=mysql_fetch_array(mysql_query("SELECT * FROM izumrud_login WHERE player='".$change_leader."' and group_id=".$group_id));
	if ($sel_kill && $sel_kill["player"]!=$login)
	{
		mysql_query("UPDATE  izumrud_login SET leader=1 WHERE player='".$change_leader."'");
		mysql_query("UPDATE  izumrud_login SET leader=0 WHERE player='".$login."'");
		say("toroom","Лидер группы <b>".$login."</b> передал лидерство персонажу <b>".$change_leader."</b>",$login);
	}
}
//----------------------------------------------
$ctime=time();
$r=mysql_fetch_array(mysql_query("SELECT * FROM labirint WHERE user_id='".$login."' and etaj=$etaj"));
if(!$r) 
{
	// начало лабиринта
	$my_cord="29x2";
	$my_vector=180;
	$Time=time();
	mysql_query("INSERT INTO labirint(user_id, location, vector, visit_time,etaj) VALUES('".$login."', '".$my_cord."', '".$my_vector."', '".$Time."',$etaj)");
}
else
{
	// определим видимую область
	$my_cord=$r['location'];
	$my_vector=$r['vector'];
	$Time=$r['visit_time'];
}
//----------------------------------------------
if ($r["lose"]>=10)
{
	say($login,"Вас убили...",$login);
	Header("Location: ?exit=1&".md5(time()));
	die();
}
//----------------------------------------------
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
		if($step1['fwd'] && (!in_array($step1["fwd"],$sunduk_Array)) && (!count($Bot_Array[$step1['fwd']])) && $step1['fwd']!="29x2" && $step1['fwd']!="27x1")
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

#if ($db["adminsite"])echo $my_cord."-".$my_vector."-".$step1['fwd']."-";
//------------------------------------------------------------------
if ($_GET["get"] && is_numeric($_GET["get"]))
{
	$get=(int)$_GET["get"];
	$sql=mysql_query("SELECT item_id,name FROM izumrud_setting LEFT JOIN wood on wood.id=izumrud_setting.item_id WHERE izumrud_setting.group_id='".$group_id."' and izumrud_setting.cord='".$my_cord."' and izumrud_setting.ids=$get and etaj=$etaj and type='items'");
	if (!mysql_num_rows($sql))
	{
		$msg="Кто-то быстрее...";
	}
	else 
	{
		$ww=mysql_fetch_assoc($sql);
		mysql_query("INSERT INTO `inv` (`owner`, `object_id`, `object_type`, `object_razdel` ,`iznos`,  `iznos_max`) VALUES 	('".$login."', '".$ww['item_id']."','wood','thing','0','1');");
		mysql_query("DELETE FROM izumrud_setting WHERE ids='$get'");
		$msg="Вы подняли '".$ww["name"]."'";
		say("toroom","<b>".$logins."</b> успешно подобрал предмет: <b>".$ww["name"]."</b>",$login);
	}
	mysql_free_result($sql);
}
//------------------------------------------------------------------
if ($_POST["id_sund"] && in_array($_POST["id_sund"],$sunduk_Array) && $step1['fwd']==$_POST["id_sund"])
{
	$id_sund=htmlspecialchars(addslashes($_POST["id_sund"]));
	$s_id=mysql_query("SELECT * FROM izumrud_setting WHERE group_id='".$group_id."' and type='sunduk' and etaj=$etaj and cord='$id_sund'");
	if (!mysql_fetch_array($s_id))
	{
		foreach ($eliks[$id_sund] as $table => $take_array) 
		{
			$take_id=$take_array[rand(0,count($take_array)-1)];
			$eliksir=mysql_fetch_array(mysql_query("SELECT * FROM $table WHERE id=".$take_id));
			if ($eliksir)
			{
				if ($table=="scroll")
				{
		 			$take_time=($eliksir["del_time"]>0?time()+$eliksir["del_time"]*24*3600:"");
					mysql_query("INSERT INTO inv(owner,object_id,object_type,object_razdel,wear,iznos,iznos_max,term) VALUES ('".$login."','".$eliksir["id"]."','scroll','magic','0','0','".$eliksir["iznos_max"]."','".$take_time."')");
		 		}
		 		else if ($table=="wood")
				{
					mysql_query("INSERT INTO `inv` (`owner`, `object_id`, `object_type`, `object_razdel` ,`iznos`,  `iznos_max`) VALUES 	('".$login."', '".$eliksir['id']."','wood','thing','0','1');");
				}
				mysql_query("INSERT INTO izumrud_setting VALUES (0,'".$id_sund."','".$login."','".$group_id."','$etaj','sunduk','')");
				say("toroom","<b>".$logins."</b> открыл <b>«Сундук»</b> и нашол в нем «<b>".$eliksir["name"]."</b>» 1шт.! Поздравляем!",$login);
				$msg= "Вы нашли «".$eliksir["name"]."» 1шт.! Поздравляем!";
			}
			else 
			{
				mysql_query("INSERT INTO led_setting VALUES (0,'".$id_sund."','".$login."','".$group_id."','$etaj','sunduk','')");
				$msg= "Волшебный сундук пуст!";
			}
		}
	}
	else $msg= "Волшебный сундук пуст!";
}	
//------------------------------------------------------------------
# Декорации
foreach($Items_Array as $item_info)
{
	if (in_array ($step2["left_cord"], $item_info))
	{
		$draw_item_left = $item_info["type"];
	}
	if (in_array ($step2["right_cord"], $item_info))
	{
		$draw_item_right = $item_info["type"];
	}
	if (in_array ($step1["fwd_cord"], $item_info))
	{
		$draw_item_fwd = $item_info["type"];
	}
	
	if (in_array ($step3["left_cord"], $item_info))
	{
		$draw_item_left1 = $item_info["type"];
	}
	if (in_array ($step3["right_cord"], $item_info))
	{
		$draw_item_right1 = $item_info["type"];
	}
	if (in_array ($step2["fwd_cord"], $item_info))
	{
		$draw_item_fwd1= $item_info["type"];
	}
}

$dtim=$ctime-$Time;
?>
<SCRIPT src="izumrud.js"></SCRIPT>
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
<h3>Загадочная пещера (Этаж 1)</h3>
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
	echo "<table border=0 cellpadding=0 cellspacing=0>";
	echo "<b>Повержен:</b> ".$r['lose']."<br/>";
	$pl_sql=mysql_query("SELECT users.id,users.login,level,dealer,orden,admin_level,clan_short,clan,hp,hp_all,labirint.location,izumrud_login.leader FROM users LEFT JOIN izumrud_login on group_id='".$group_id."' LEFT JOIN izumrud_group on izumrud_group.id='".$group_id."' LEFT JOIN labirint on labirint.user_id=izumrud_login.player WHERE izumrud_login.player=users.login and labirint.etaj=1");
	WHILE ($players=mysql_fetch_Array($pl_sql))
	{
		echo "<tr height=10 nowrap><td><a href='javascript:top.AddToPrivate(\"".$players['login']."\")'><img border=0 src=img/arrow3.gif alt=\"Приватное сообщение\" ></a> 
		<script>drwfl('".$players['login']."','".$players['id']."','".$players['level']."','".$players['dealer']."','".$players['orden']."','".$players['admin_level']."','".$players['clan_short']."','".$players['clan']."');</script>&nbsp;</td>
		<td><script>show(".$players["hp"].",".$players["hp_all"].");</script></td><td>&nbsp;<small>[".$players['location']."]</small></td>
		<td>".($players["leader"]?"<img src='img/izumrud/misc/lid.gif' alt='Лидер группы'>":"").(($players["leader"] && $players["login"]==$login)?"&nbsp;<A href='#' onclick=\"findlogin( 'Выберите персонажа которого хотите выгнать','?act=none', 'kill_member' )\"><IMG alt='Выгнать' src='img/izumrud/misc/kill.gif'></A>&nbsp;<A href='#' onclick=\"findlogin( 'Выберите персонажа которому хотите передать лидерство','?act=none', 'change_leader')\"><IMG alt='Новый Лидер' src='img/izumrud/misc/c_lid.gif'></A>&nbsp;":"")."</td></tr>";
		if ($login!=$players["login"])$users[]=array(login=>$players["login"],coord=>$players["location"]);
	}
	mysql_free_result($pl_sql);
	echo "</table><br>";
	echo "<FONT COLOR=red>$msg</FONT>";
	$predmet=mysql_query("SELECT ids,name,img FROM izumrud_setting LEFT JOIN wood on wood.id=izumrud_setting.item_id WHERE izumrud_setting.group_id='".$group_id."' and izumrud_setting.cord='".$my_cord."' and izumrud_setting.etaj=1 and type='items'");
	if (mysql_num_rows($predmet))
	{	
		echo "<table border=0 cellpadding=0 cellspacing=0 width=100%><tr><td>
		<H3>В комнате разбросаны вещи:</H3>";
		while ($woods=mysql_fetch_assoc($predmet))
		{	
			echo "<img src=img/".$woods["img"]." style='cursor:hand' alt=\"Подобрать предмет '".$woods["name"]."'\" onclick=\"dungeon_obj('".$woods["ids"]."');\"> ";
		}
		echo "</td></tr></table>";
	}
	//DrawAll($my_cord,$my_vector);

//-----------------
echo "</td>";

echo "<td valign=top align=right>
<A href='?exit=1' onclick='return confirm(\"Вы уверены, что хотите покинуть это место?\")'>Выйти</A>
	
	
<table bgcolor=#000000 width=100%><tr><td>";
echo "<div id=\"brodilka\" style=\"width:366px; height:260px; position:relative; background-color:#000000; z-index:0; overflow:hidden\" align=\"center\">
<!--menu-->
<div id=\"pmenu\" style=\"width:60px; height:20px; position:absolute; display:none; top:10px; left:10px; background-color:#CCCCCC; border-width:1px; border-color:#000000; border-style:solid; white-space:nowrap; padding:2px; z-index:8; text-align:right;\"></div>";
echo "\n\n <!--1 слой-->\n";
if(!$step1["left"])	{echo"<div style=\"position:absolute; top:10px; left:10px; z-index:7;\"><img src=\"img/izumrud/1_left_wall.gif\" /></div>";}
if(!$step1["fwd"])	{echo"<div style=\"position:absolute; top:10px; left:10px; z-index:7;\"><img src=\"img/izumrud/1_front_wall.gif\" /></div>";}
if(!$step1["right"]){echo"<div style=\"position:absolute; top:10px; right:0px; z-index:7;\"><img src=\"img/izumrud/1_right_wall.gif\" /></div>";}

if($step1['fwd']=="29x2" && $my_vector==0){echo"<div style=\"position:absolute; top:0px; left:10px; z-index:100;\"><img src=\"img/izumrud/misc/les.gif\"></div>";}
if($step1['fwd']=="25x1" && $my_vector==270){echo"<div style=\"position:absolute; top:0px; left:10px; z-index:100;\"><img src=\"img/izumrud/misc/les.gif\" title='Этаж 2'></div>";}

if($step1['fwd']=="27x1" && $my_vector==270){echo"<div style=\"position:absolute; top:50px; left:140px; z-index:7;\" style='cursor:hand;' onClick=\"OpenMenuMerlin();\" onmouseout=\"closeMenu();\"><img src=\"img/izumrud/starik.gif\" title='Старый Альтаир'></div>";}

#бот!
echo "\n<div id='us' style='Z-INDEX:11; POSITION:absolute; LEFT:10px;TOP:60px;' onmouseout=\"closeMenu();\"></div>\n";

if(count($Bot_Array[$step1['fwd']]))
{
	echo"<script>
			var arr=new Array('".implode("','",$Bot_Array[$step1['fwd']])."');
			VesualBot(arr,'".$step1['fwd']."');
		</script>";
}
###
if ($users!="")
{
	foreach ($users as $currentValue) 
	{
		if (in_array ($step1['fwd'], $currentValue)) 
		{
			echo"<div style=\"Z-INDEX:12; LEFT:130px; POSITION:absolute; TOP:40px;\"><img src=\"img/izumrud/shadow.gif\" alt=\"".$currentValue["login"]."\" style=\"CURSOR:hand\"></div>";
		}
	}
}
if(in_array($step1["fwd"],$sunduk_Array))
{
	echo"\n<form name='myform' method=POST action='main.php?act=none'>
		<div id=\"m1_4\" style=\"Z-INDEX:10; LEFT:10px; POSITION:absolute; TOP:10px;\">
			<img src='img/izumrud/misc/sunduk1.gif' style='border:0; CURSOR:hand;' onclick=\"if (confirm('Открыть сундук?')) document.myform.submit(); else this.form.action=''; \">
			<input type=hidden name=id_sund value='".$step1["fwd"]."'>
		</div>
		</form>\n";
}
if($draw_item_left)
{
	echo"<div style=\"Z-INDEX:6; LEFT:10px; POSITION:absolute; TOP:10px; \"><img src='img/izumrud/misc/".$draw_item_left."_l1.gif' style='border:0; CURSOR:hand;'></div>";
}
if($draw_item_right)
{
	echo"<div style=\"Z-INDEX:10; LEFT:10px; POSITION:absolute; TOP:10px; \"><img src='img/izumrud/misc/".$draw_item_right."_r1.gif' style='border:0; CURSOR:hand;'></div>";
}
if($draw_item_fwd)
{
	echo"<div style=\"Z-INDEX:10; LEFT:10px; POSITION:absolute; TOP:10px; \"><img src='img/izumrud/misc/".$draw_item_fwd."_fwd1.gif' style='border:0; CURSOR:hand;'></div>";
}
echo"\n\n<!--2 слой-->\n";
if(!$step2["left"])	{echo "<div style=\"position:absolute; top:10px; left:10px; z-index:5;\"><img src=\"img/izumrud/2_left_wall.gif\" /></div>"; }
if(!$step2["fwd"])	{echo "<div style=\"position:absolute; top:10px; left:10px; z-index:5;\"><img src=\"img/izumrud/2_front_wall.gif\" /></div>";}
if(!$step2["right"]){echo "<div style=\"position:absolute; top:10px; right:0px; z-index:5;\"><img src=\"img/izumrud/2_right_wall.gif\" /></div>";}

echo "\n<div id='us2' style='Z-INDEX:5; POSITION:absolute; LEFT:10px;TOP:60px;' onmouseout=\"closeMenu();\"></div>\n";

if(count($Bot_Array[$step2['fwd']]))
{
	echo"<script>
			var arr=new Array('".implode("','",$Bot_Array[$step2['fwd']])."');
			VesualBot2(arr,'".$step2['fwd']."');
		</script>";
}
if ($users!="")
{
	foreach ($users as $currentValue) 
	{
		if (in_array ($step2['fwd'], $currentValue)) 
		{
			echo"<div style=\"Z-INDEX:11; LEFT:150px; POSITION:absolute; TOP:60px;\"><img src=\"img/izumrud/shadow.gif\" width=\"70\" alt=\"".$currentValue["login"]."\" style=\"CURSOR:hand\"></div>";
		}
	}
}
if(in_array($step2["fwd"],$sunduk_Array))
{
	echo "\n<div style=\"Z-INDEX:6; LEFT:10px; POSITION:absolute; TOP:10px;\"><img src='img/izumrud/misc/sunduk2.gif'></div>";
}

if($draw_item_left1)
{
	echo"<div style=\"Z-INDEX:6; LEFT:10px; POSITION:absolute; TOP:10px; \"><img src='img/izumrud/misc/".$draw_item_left1."_l2.gif' style='border:0; CURSOR:hand;'></div>";
}
if($draw_item_right1)
{
	echo"<div style=\"Z-INDEX:10; LEFT:10px; POSITION:absolute; TOP:10px; \"><img src='img/izumrud/misc/".$draw_item_right1."_r2.gif' style='border:0; CURSOR:hand;'></div>";
}
if($draw_item_fwd1)
{
	echo"<div style=\"Z-INDEX:10; LEFT:10px; POSITION:absolute; TOP:10px; \"><img src='img/izumrud/misc/".$draw_item_fwd1."_fwd2.gif' style='border:0; CURSOR:hand;'></div>";
}

echo"\n\n<!--3 слой-->\n";
if(!$step3["left"]) {echo"<div style=\"position:absolute; top:10px; left:10px; z-index:3;\"><img src=\"img/izumrud/3_left_wall.gif\" /></div>";}
if(!$step3["fwd"])	{echo"<div style=\"position:absolute; top:10px; left:10px; z-index:3;\"><img src=\"img/izumrud/3_front_wall.gif\" /></div>";}
if(!$step3["right"]){echo"<div style=\"position:absolute; top:10px; right:0px; z-index:3;\"><img src=\"img/izumrud/3_right_wall.gif\" /></div>";}

echo"\n\n<!--пол и потолок-->";
echo "<div id=\"l1ce\" style=\"position:absolute; top:10px; left:10px; z-index:0;\"><img src=\"img/izumrud/bg.gif\"/></div>";

echo"\n\n<!--4 слой-->";
if(!$step4["left"])	{echo"<div id=\"l4l\" style=\"position:absolute; top:10px; left:10px; z-index:1;\"><img src=\"img/izumrud/4_left_wall.gif\" id=\"lv4l\" /></div>";}
if(!$step4["right"]){echo"<div id=\"l4r\" style=\"position:absolute; top:10px; right:0px; z-index:1;\"><img src=\"img/izumrud/4_right_wall.gif\" id=\"lv4r\" /></div>";}

echo"<div style=\"position:absolute; bottom:10px; left:120px; z-index:100;\">
<div><img src=\"img/izumrud/navigation.gif\"/></div>
<div>";
if($step1['fwd']) 
{
	echo "<a href='?action=forward' onclick='return check_time();'><img src='img/izumrud/up.gif' style=\"position:absolute; top:12px; left:48px; z-index:0;\" border='0' alt='Вперёд'></a>";
}
else echo "<img src='img/izumrud/noway.gif' style=\"position:absolute; top:14px; left:46px; z-index:0;\" border='0' alt='Нельзя'>";
echo "<a href='?action=rotateleft' onclick='return check_time();'><img src='img/izumrud/left.gif' style=\"position:absolute; top:40px; left:12px; z-index:0;\" border='0' alt='Повернуться влево'></a>";
echo "<a href='?action=rotateright' onclick='return check_time();'><img src='img/izumrud/right.gif' style=\"position:absolute; top:40px; left:88px; z-index:0;\" border='0' alt='Повернуться вправо'></a>";

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