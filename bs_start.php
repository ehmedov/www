<?
$check = mysql_query("SELECT users.login FROM online LEFT JOIN users on users.bs=1 WHERE online.login=users.login");
if (mysql_num_rows($check) <= 1) 
{
	$add = 0;
	$ch = mysql_fetch_array($check);
	$bs_sel = mysql_query("SELECT * FROM bs");
	while ($bs = mysql_fetch_array($bs_sel)) 
	{
		$add = $add + $bs["cash"];
		mysql_query("UPDATE users set bs_x=0, bs_y=0, bs=0 where login='".$bs["user"]."'");
	}
	if ($ch)
	{
		$add=floor($add*0.75);
		mysql_query("UPDATE users SET money=money+$add,naqrada=naqrada+50 where login='".$ch["login"]."'");
		mysql_query("INSERT INTO bs_winner(user,summa) VALUES('".$ch["login"]."','".$add."')");
		say($ch["login"],"<b>Поздравляем!</b> Вы победили в турнире, ваш приз состовляет: <b>$add Зл.</b>  (за исключением 25% комиссии) и <b>50 Ед.</b> награды...",$ch["login"]);
		say("toall","<b style='color:#ff0000;background-color:#FAE0E0;'>Поздравляем! Воин <font color=#000000>".$ch["login"]."</font> стал победителем турнира...</b>",$ch["login"]);
	}
	mysql_query("DELETE FROM bs");
	mysql_query("UPDATE bs_objects SET bs=0");
	Header("Location: ?tmp=$now");
	//mysql_query("DELETE FROM objects WHERE user='$ch[user]' AND bs = 1");
}
// --------------------------Нападение-----------------------------------
if ($_POST[Attack] && is_numeric($_POST['char_id']))
{
  	$char_id=(int)$_POST['char_id'];  
  	if($char_id==$db["id"])
	{
		$msg="Нападение на самого себя - это уже мазохизм...";
	}
	else if(!$db["battle"])
	{
		$q=mysql_query("SELECT * FROM `users` WHERE id = '".$char_id."'");
		$res=mysql_fetch_array($q);
		if(!$res)
		{
			$msg="Персонаж  не найден.";
		}
		else if (!$res['bs'])
		{
			$msg="Боец \"".$res["login"]."\" уже проиграл турнир!";
		}
		else if (!$db['bs'])
		{
			$msg="Вы уже проиграли турнир!";
		}	
		else if($res["room"]!=$db["room"])
        {
        	$msg="Для нападния Вам необходимо находится в одной комнате!";
        }
        else if($db["zayavka"]==1)
        {
        	$msg="Сначала отзовите текущую заявку...</b>";
        }
		else
		{
			if ($res["battle"]==0)
			{
		        $chas = date("H");
		        $date = date("H:i", mktime($chas));
				$mine_id=$db["id"];
		        say($res["login"],"<b>$login</b> напал на Вас!",$res["login"]);
		        mysql_query("INSERT INTO zayavka(status,type,timeout,creator) VALUES('3','99','3','".$mine_id."')");
		        mysql_query("INSERT INTO teams(player,team,ip,battle_id,hitted,over) VALUES('".$db["login"]."','2','".$db["last_ip"]."','".$mine_id."','0','0')");
		        mysql_query("INSERT INTO teams(player,team,ip,battle_id,hitted,over) VALUES('".$res["login"]."','1','".$res["last_ip"]."','".$mine_id."','0','0')");
				mysql_query("UPDATE users set zayavka=1, battle_opponent='".$db["login"]."' WHERE login='".$res["login"]."'");
		        goBattle($db["login"]);
		        goBattle($res["login"]);
			}
			else if ($res["battle"]!=0)
			{
				$Q_TEAM=mysql_query("SELECT * FROM teams WHERE player='".$res["login"]."'");
				$D=mysql_fetch_array($Q_TEAM);
				if ($D)
				{
					$battle_id=$D["battle_id"];
					$team=$D["team"];
					mysql_query("INSERT INTO teams(player,team,ip,battle_id,hitted,over) VALUES('".$_SESSION["login"]."','".($team==1?2:1)."','".$db["last_ip"]."','".$battle_id."','0','0')");
			        $chas = date("H");
    				$date = date("H:i", mktime($chas));
			        $log_file="logs/".$res['battle'].".dis";
					$f=fopen($log_file,"a");
					include ("align.php");
					$att="<span class=date2>$date</span> ".drwfl($db['login'],$db['id'],$db['level'],$db['dealer'],$db['orden'],$db['admin_level'],$db['clan_short'],$db['clan'])." вмешался в поединок!</b></b><hr>";
					fputs($f,$att);
					fclose($f);
			        goBattle($_SESSION["login"]);
				}
			}
		}
	}
	else
	{
 		$msg="Вы не можете кастовать это заклятие находясь в бою!";
 	}
}
// ----------------------------------------------------------------------
if ($_GET[go] == r)
{	
	if ($db[bs_x] >= -5 && ($db[bs_x]+1) <= 5) 
	{
		mysql_query("UPDATE users SET bs_x=bs_x+1 where id = $db[id]");
		$db[bs_x]=$db[bs_x]+1;
	}
}
if ($_GET[go] == l)
{  
	if (($db[bs_x]-1) >= -5 && $db[bs_x] <= 5)
	{
		mysql_query("UPDATE users SET bs_x=bs_x-1 where id = $db[id]");
		$db[bs_x]=$db[bs_x]-1;
	}
}
if ($_GET[go] == t)
{
	if ($db[bs_y] >= -5 && ($db[bs_y]+1) <= 5) 
	{
		mysql_query("UPDATE users SET bs_y=bs_y+1 where id = $db[id]");
		$db[bs_y]=$db[bs_y]+1;
	}
}
if ($_GET[go] == d)
{ 
	if (($db[bs_y]-1) >= -5 && $db[bs_y] <= 5) 
	{
		mysql_query("UPDATE users SET bs_y=bs_y-1 where id = $db[id]");
		$db[bs_y]=$db[bs_y]-1;
	}
}
// --------изнаем ид жертвы (рандомом)-----------------------------------
$all_people = array();
$all_users = array();
$result = mysql_query("SELECT * FROM `users` WHERE `bs_x` ='".$db['bs_x']."' AND `bs_y` ='".$db['bs_y']."' AND `bs` =1 AND `id` <> '".$db['id']."'");
$kol_idov = mysql_num_rows($result);
if ($kol_idov > 0) 
{
    while ($row = mysql_fetch_array($result)) 
    {
        $all_people[] = $row['id'];
        $all_users[]  = "<script>drwfl('$row[login]','$row[id]','$row[level]','$row[dealer]','$row[orden]','$row[admin_level]','$row[clan_short]','$row[clan]');</SCRIPT>";
    }
}
$count = count($all_people);
$lucky = $all_people[rand(1,$count) - 1];

echo "<b style=color:#ff0000>$msg &nbsp;</b>";
echo "<TABLE WIDTH=100% CELLSPACING=1 CELLPADDING=3 BGCOLOR=#212120>
	<tr bgcolor=#504F4C>
	<td align='center'><b style=color:#ffffff>В комнате разбросаны вещи</b></td>
	<td align='center'><b style=color:#ffffff>Ваши координаты в игре ($db[bs_x],$db[bs_y])</b></td>
	<td align='center'><b style=color:#ffffff>Нападенние и прочее</b></td>
	</tr>
     <tr bgcolor=#D5D5D5>
         <td width=300 nowrap valign=top align=center height=150>";
			$room = $db[room];
			if ($_GET['do'] == "get" && is_numeric($_GET[id])) 
			{
				$id=(int)$_GET[id];
				$b_s=mysql_num_rows(mysql_query("SELECT * FROM bs_objects WHERE bs_id=$id and bs=0"));
				if ($b_s)
				{	
					$bs_obj = mysql_fetch_array(mysql_query("SELECT id,object,name,iznos_max FROM paltar WHERE id=$id"));
					if ($bs_obj)
					{	
						mysql_query("INSERT INTO inv(owner,object_id,object_type,object_razdel,wear,iznos,iznos_max,noremont) VALUES ('$login','$bs_obj[id]','$bs_obj[object]','obj','0','0','$bs_obj[iznos_max]','1')");
						$itm_id=mysql_insert_id();
						mysql_query("UPDATE bs_objects SET bs=1 where bs_id=$id");
						say($login,"Вы успешно подобрали этот предмет <b>$bs_obj[name]</b>",$login);
						wear($who,$itm_id);
						Header("Location: ?tmp=$now");
					}
				}
				else 
				echo "<b style=color:#ff0000>Кто то оказался быстрее...</b>";
			}

			$rand = rand(0,10); #выбираеш диапазон рандома
			if ($_GET[go])
			{
				if ($rand == 5) 
				{
					$bs_obj_sel = mysql_query("SELECT bs_id FROM bs_objects where bs=0");
					while ($k=mysql_fetch_array($bs_obj_sel))
					{
						$arr[]=$k[bs_id];
					}
					$item=(int)$arr[rand(0,count($arr)-1)];
					$bs_obj_s = mysql_query("SELECT id,name,img FROM paltar WHERE id=$item");
					$bs_obj = mysql_fetch_array($bs_obj_s);
					if ($bs_obj) 
					{
				    	echo "<b>$bs_obj[name]</b><br><img src=img/$bs_obj[img]><br>
				    	<a href=?do=get&id=$bs_obj[id]>Забрать</a>";
					} 
					else 
					{
						echo "Вещей не найдено";
					}
				}
			}
		echo "</td>";
		echo "<td width=100% align=center valign=top>";
			echo "<table>";
				echo "<tr><td width=50></td><td width=50>";if ($db['bs_y'] == 5) {echo "верх"; } else {echo "<a href=?go=t>верх</a>"; } echo"</td><td width=50></td></tr>";
				echo "<tr><td width=50>";if ($db['bs_x'] == -5) {echo "лево"; } else {echo "<a href=?go=l>лево</a>"; }echo"</td><td width=50></td><td width=50>";if ($db['bs_x'] == 5) {echo "право"; } else {	echo "<a href=?go=r>право</a>"; }echo"</td></tr>";
				echo "<tr><td width=50></td><td width=50>";if ($db['bs_y'] == -5) {echo "вниз"; } else {echo "<a href=?go=d>вниз</a>"; }echo"</td><td width=50></td></tr>";
			echo "</table>";
		echo "</td>";
		echo "<td width=300 nowrap valign=top>";
		echo "<form action='' method=post>";
		if ($kol_idov > 0) 
		{
			echo "<input type='hidden' name='char_id' value='".$lucky."'><input type='submit' name='Attack' class='input' value='Нападение'>";
		} 
		else 
		{
			echo "В этой комнате нападать ненакого";
		}
		echo "<hr>В данный момент в этой локации находятся такие игроки:<br>";
		for($i=0;$i<count($all_users);$i++) echo $all_users[$i]."<br>";
		echo "</form></td>";
		echo "</tr></table>";
?>