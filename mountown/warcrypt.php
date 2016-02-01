<?
$login=$_SESSION['login'];
$mine_id=$db["id"];
include("time.php");
##==============Go To Podzemka================================
$sel_me=mysql_fetch_array(mysql_query("SELECT started, lose FROM war_team LEFT JOIN war_group ON war_group.id=war_team.group_id WHERE player='".$login."'"));
if ($sel_me["started"]==1 && !$sel_me["lose"])
{
	Header("Location: main.php?act=go&level=war_labirint");
	die();
}
#insert into war_group values(null,unix_timestamp()+5,0)
?>
<body style="background-image: url(img/index/warcrypt.jpg);background-repeat:no-repeat;background-position:top right">
<SCRIPT src="dungeon.js"></SCRIPT>
<table width=100% border=0>
<tr>
	<td width=100%><h3>Пещера Воинов</h3></td>
	<td nowrap valign=top>
		<input type=button value='Магазин Доблести' style="background-color:#AA0000; color: white;" onclick="document.location='main.php?act=go&level=doblest_shop'">
		<input type=button class=newbut value='Вернуться' onclick="document.location='main.php?act=go&level=vault'">
		<input type=button class=newbut value='Обновить' onClick="location.href='?act=none'">
	</td>
</tr>
<tr>
	<td width=100% colspan=2><font color=#ff0000><?=$errmsg?></font>&nbsp;</td>
</tr>
<tr>
	<td valign=top colspan=2>
		<?
			#if (!$db["adminsite"])die();
			$have_Zayavka=mysql_fetch_Array(mysql_Query("SELECT * FROM war_group"));
			if (!$have_Zayavka)
			{
				echo "<b style='color:#ff0000'>На данный момент нет заявок... Время проведения Битвы: Каждый день в 21:00</b>";
			}
			else
			{
				if ($have_Zayavka["start_time"]<time())
				{
					if ($have_Zayavka["started"])
					{
						echo "
							<table cellspacing=1 cellpadding=3 align=center width=600>
							<tr>
								<td colspan=2 align=center><b style='color:#ff0000'>Война идёт... Живых участников на данный момент</b></td>
							</tr>
							<tr class='newbut' align=center>
								<td width=50%><b>Свет</td><td><b>Тьма</td>
							</tr>
							<tr>
								<td valign=top>";
								$sql_team1=mysql_query("SELECT users.login, users.level, users.id, users.orden, users.admin_level, users.clan, users.clan_short, users.dealer, users.battle FROM war_team LEFT JOIN users ON users.login=war_team.player WHERE group_id=".$have_Zayavka['id']." and war_team.team=1 and war_team.lose=0");
								while ($team1=mysql_fetch_Array($sql_team1))
								{
									echo "<script>drwfl('".$team1['login']."','".$team1['id']."','".$team1['level']."','".$team1['dealer']."','".$team1['orden']."','".$team1['admin_level']."','".$team1['clan_short']."','".$team1['clan']."');</script>".($team1['battle']?" <a href='log.php?log=".$team1['battle']."' target='_blank'><img src='img/b.jpg'>":"")."<br>";
								}
								echo "</td>
								<td valign=top>";
								$sql_team2=mysql_query("SELECT users.login, users.level, users.id, users.orden, users.admin_level, users.clan, users.clan_short, users.dealer, users.battle FROM war_team LEFT JOIN users ON users.login=war_team.player WHERE group_id=".$have_Zayavka['id']." and war_team.team=2 and war_team.lose=0");
								while ($team2=mysql_fetch_Array($sql_team2))
								{
									echo "<script>drwfl('".$team2['login']."','".$team2['id']."','".$team2['level']."','".$team2['dealer']."','".$team2['orden']."','".$team2['admin_level']."','".$team2['clan_short']."','".$team2['clan']."');</script>".($team2['battle']?" <a href='log.php?log=".$team2['battle']."' target='_blank'><img src='img/b.jpg'>":"")."<br>";
								}
								echo "</td>
							</tr>
							</table>";
					}
					else
					{
						$count_team1=mysql_fetch_Array(mysql_Query("SELECT count(*) FROM war_team WHERE team=1"));
						$count_team2=mysql_fetch_Array(mysql_Query("SELECT count(*) FROM war_team WHERE team=2"));
						if ($count_team1[0] && $count_team2[0])
						{
							mysql_query("UPDATE war_group SET started=1");
						}
						else 
						{
							/*$sql=mysql_Query("SELECT player FROM war_team");
							while($res=mysql_Fetch_array($sql))
							{
								mysql_query("UPDATE users SET zayava=0 WHERE login='".$res["player"]."'");
							}*/
							mysql_query("UPDATE users SET zayava=0 WHERE login in (SELECT player FROM war_team)");
							mysql_query("DELETE FROM `labirint` WHERE user_id in (SELECT player FROM war_team)");
							mysql_query("TRUNCATE TABLE `war_group`");
							mysql_query("TRUNCATE TABLE `war_team`");
						}
					}
				}
				else
				{
					#######################################################
					if ($_GET["team"])
					{
						$svet_Array=array(1,4,3);
						$tma_Array=array(2,3);
						$join_team=(int)$_GET["team"];
						$have_i=mysql_fetch_Array(mysql_Query("SELECT * FROM war_team WHERE player='".$login."'"));
						if (!$have_i)
						{	
							$count_Teams=mysql_fetch_Array(mysql_query("SELECT count(*) FROM war_team WHERE team=$join_team"));
							if ($count_Teams[0]<20)
							{
								if (($join_team==1 && in_Array($db["orden"],$svet_Array))||($join_team==2 && in_Array($db["orden"],$tma_Array)))
								{
									mysql_query("INSERT INTO war_team VALUES('".$login."','".$have_Zayavka['id']."','".$join_team."','0')");
									mysql_query("UPDATE users SET zayava=1 WHERE login='".$login."'");
									if ($join_team==1)$loc="32x5"; else $loc="2x24"; 
									mysql_Query("DELETE FROM labirint WHERE user_id='".$login."'");
									mysql_query("INSERT INTO labirint(user_id, location, vector, visit_time) VALUES('".$login."', '".$loc."', '0', '".time()."')");
									$msg="Заявка на бой подана";
								}
								else $msg="Вы не можете идти на поединок против своих...";
							}
							else $msg="Максимальное колличество бойцов в группе - 20 чел.";
						}
						else $msg="Вы уже и так в группе";
					}
					#######################################################
					echo "
					<font color='#ff0000'>$msg</font><br>
					<table cellspacing=1 cellpadding=3 align=center  width=600>
						<tr>
							<td colspan=2 align=center><b>До войны еще: ".convert_time($have_Zayavka['start_time'])."</td>
						</tr>
						<tr class='newbut' align=center>
							<td width=50%><b>Свет</td><td><b>Тьма</td>
						</tr>
						<tr>
							<td valign=top>";
							$sql_team1=mysql_query("SELECT users.login, users.level, users.id, users.orden, users.admin_level, users.clan, users.clan_short, users.dealer FROM war_team LEFT JOIN users ON users.login=war_team.player WHERE group_id=".$have_Zayavka['id']." and war_team.team=1");
							while ($team1=mysql_fetch_Array($sql_team1))
							{
								echo "<script>drwfl('".$team1['login']."','".$team1['id']."','".$team1['level']."','".$team1['dealer']."','".$team1['orden']."','".$team1['admin_level']."','".$team1['clan_short']."','".$team1['clan']."');</script><br>";
							}
							echo "</td>
							<td valign=top>";
							$sql_team2=mysql_query("SELECT users.login, users.level, users.id, users.orden, users.admin_level, users.clan, users.clan_short, users.dealer FROM war_team LEFT JOIN users ON users.login=war_team.player WHERE group_id=".$have_Zayavka['id']." and war_team.team=2");
							while ($team2=mysql_fetch_Array($sql_team2))
							{
								echo "<script>drwfl('".$team2['login']."','".$team2['id']."','".$team2['level']."','".$team2['dealer']."','".$team2['orden']."','".$team2['admin_level']."','".$team2['clan_short']."','".$team2['clan']."');</script><br>";
							}
							echo "</td>
						</tr>
						<tr align=center>
							<td>
								<input class='newbut' type='button' onclick=\"document.location.href='?team=1'\" value=\"Я за Свет!\">
							</td>
							<td>
								<input class='newbut' type='button' onclick=\"document.location.href='?team=2'\" value=\"Я за Тьма!\">
							</td>
						</tr>
					</table>";
					
				}
			}
		?>
	</td>
</tr>
</table>
<br><br><br><br><br><br><br><br>
<?include_once("counter.php");?>