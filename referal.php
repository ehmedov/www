<?
include ('key.php');
include ("conf.php");
$login=$_SESSION["login"];
$data = mysql_connect($base_name, $base_user, $base_pass) or die('Не получается подключиться. Проверьте имя сервера, имя пользователя и пароль!');
mysql_select_db($db_name) or die('Ошибка входа в базу данных');
$db=mysql_fetch_Array(mysql_query("SELECT * FROM users WHERE login='".$login."'"));
?>
<html>
	<HEAD>	
		<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
		<meta http-equiv="Content-Language" content="ru">
		<META Http-Equiv=Cache-Control Content="no-cache, max-age=0, must-revalidate, no-store">
		<meta http-equiv=PRAGMA content=NO-CACHE>
		<meta http-equiv=Expires content=0>	
		<LINK REL=StyleSheet HREF='main.css' TYPE='text/css'>
	</HEAD>
<body bgcolor="#faeede">
<SCRIPT language="JavaScript" type="text/javascript" src="commoninf.js"></SCRIPT>
<div align=right>
	<input type=button value='Обновить'  class='newbut' style='cursor:hand' onClick="javascript:location.href='referal.php'">
	<input type=button value='Вернуться' class='newbut' style='cursor:hand' onClick="javascript:location.href='main.php?act=none'">
</div>
<h3>Ваши Реферальные ссылки:</h3>
<table width=100% cellspacing=1 cellpadding=3 class="l3">
<TR>
	<TD>
		<TABLE border=1 width=100% cellspacing="3" cellpadding="3" class="l1">
		<tr>
			<td colspan=2>
				<b>Реферальная система</b> - это возможность Вашего <b>дополнительного заработка</b> в игре. При регистрации в игре, Вы автоматически получаете личную <b>реферальную ссылку</b>, которую можете раздать своим друзьям и знакомым.<br><br>
				<b>Каждый персонаж</b>, зарегистрировавшийся в <b>WWW.MEYDAN.AZ</b> по Вашей реферальной ссылке, по достижению им <b>6го</b> уровня начнет приносить Вам <b>дополнительный заработок</b>.<br><br>

				При достижении Вашим рефералом:<br>
				<b>6го</b> уровня, Вам автоматически будет переведено <b>10 Пл</b>.<br>
				<b>7го</b> уровня - <b>20 Пл</b>.<br>
				<b>8го</b> уровня - <b>50 Пл</b>.<br>
				<b>9го</b> уровня - <b>100 Пл</b>.<br>
				<b>10го</b> уровня - <b>200 Пл</b>.<br>
				<b>11го</b> уровня - <b>300 Пл</b>.<br>
				<b>12го</b> уровня - <b>500 Пл</b>.<br><br>
			</td>
		</tr>
		<tr class="l3">
			<td>
				<b>Реферальная ссылка</b>
			</td>
			<td>
				<b>Ваши рефералы</b>
			</td>
		</tr>
		<tr>
			<td valign=top align=left nowrap>&nbsp;<a href='http://www.meydan.az/reg.php?ref=<?=$db["id"]?>' target='_blank'>http://www.meydan.az/reg.php?ref=<?=$db["id"]?></a>&nbsp;</td>
			<td width=300>
				<?
					$sql=mysql_query("SELECT * FROM users WHERE refer=".$db["id"]);
					if (mysql_num_rows($sql))
					{
						while($res=mysql_fetch_Array($sql))
						{
							echo "<script>drwfl('".$res['login']."','".$res['id']."','".$res['level']."','".$res['dealer']."','".$res['orden']."','".$res['admin_level']."','".$res['clan_short']."','".$res['clan']."');</script><br>";
						}
					}
					else echo "&nbsp;&nbsp;По этой ссылке еще не зарегистрировано ни одного персонажа.";
				?>
			</td>
		</tr>
		</TR>
		<TR>
			<TD colspan=2>
			<?
				if ($_GET["view"])
				{
					$refferal_id=(int)$_GET["view"];
					$users=mysql_fetch_Array(mysql_Query("SELECT * FROM users WHERE id='".$refferal_id."'"));
					if ($users)
					{
						$sql_ref=mysql_query("SELECT * FROM users WHERE refer=".$refferal_id." ORDER BY level DESC");
						if (mysql_num_rows($sql_ref))
						{
							echo "<center><b>Реферальная система персонажа</b> <script>drwfl('".$users['login']."','".$users['id']."','".$users['level']."','".$users['dealer']."','".$users['orden']."','".$users['admin_level']."','".$users['clan_short']."','".$users['clan']."');</script></center><br>"; 
							while ($res_ref=mysql_fetch_Array($sql_ref))
							{	
								$k++;
								echo "<b>$k.</b>&nbsp;&nbsp;<script>drwfl('".$res_ref['login']."','".$res_ref['id']."','".$res_ref['level']."','".$res_ref['dealer']."','".$res_ref['orden']."','".$res_ref['admin_level']."','".$res_ref['clan_short']."','".$res_ref['clan']."');</script><br>";
							}
						}
					}
				}
				else
				{	
					echo "<h3>Топ 10</h3>";
					$data = mysql_query("SELECT count(*) as ref_c, refer FROM `users` WHERE refer>0 GROUP BY refer ORDER BY count(*) DESC LIMIT 10");
					while($reffers=mysql_fetch_Array($data))
					{
						$i++;
						$users=mysql_fetch_Array(mysql_Query("SELECT * FROM users WHERE id='".$reffers["refer"]."'"));
						echo "<b>$i.</b>&nbsp;&nbsp;<script>drwfl('".$users['login']."','".$users['id']."','".$users['level']."','".$users['dealer']."','".$users['orden']."','".$users['admin_level']."','".$users['clan_short']."','".$users['clan']."');</script> - <a href='?view=".$reffers["refer"]."'>".(int)$reffers["ref_c"]." рефералов</a><br>";
					}
				}
			?>
		</TD>
	</TR>
</table>
		</TD>
	</TR>
</table>
<br/>
<?mysql_close();?>		
</BODY>
</HTML>	