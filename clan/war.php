<?
include('key.php');
$login=$_SESSION["login"];
//-----------------------------------
$all_sql=mysql_query("SELECT clan_battle.*, c1.name as c1_name, c2.name as c2_name FROM clan_battle LEFT JOIN clan c1 ON c1.name_short=clan_battle.defender LEFT JOIN clan c2 ON c2.name_short=clan_battle.attacker WHERE attacker='".$clan_s."' and time_end<".time());
if (mysql_num_rows($all_sql))
{	
	while($res=mysql_fetch_Array($all_sql))
	{
		if ($res["win"]>$res["lose"])
		{
			$winner=$res["c2_name"];
			$wins=$res["attacker"];
			$msg="Война окончена между Ханством <b>".$res["c2_name"]."</b> и <b>".$res["c1_name"]."</b>. Победила Ханства <b>".$winner."</b>";
		}
		else if ($res["win"]<$res["lose"])
		{
			$winner=$res["c1_name"];
			$wins=$res["defender"];
			$msg="Война окончена между Ханством <b>".$res["c2_name"]."</b> и <b>".$res["c1_name"]."</b>. Победила Ханства <b>".$winner."</b>";
		}
		else 
		{
			$winner="Ничья";
			$wins="Ничья";
			$msg="Война окончена между Ханством <b>".$res["c2_name"]."</b> и <b>".$res["c1_name"]."</b>. Ничья...";
		}
		say("toall_news",$msg,$login);
		mysql_query('UPDATE `clan_history` SET `winner` = \''.$winner.'\', `active` = 0, `log` = CONCAT(`log`,\''."<span class=date>".date("d.m.y H:i")."</span> Битва завершен. Победитель: <b>".$winner."</>.<BR>".'\') WHERE `active` = 1 and attacker="'.$res["attacker"].'" and clan_id="'.$res["id"].'"');
		mysql_query("DELETE FROM clan_battle WHERE id=".$res["id"]);
		mysql_query("UPDATE clan SET war_time='".(time()+7*24*3600)."' WHERE name_short='".$res["defender"]."'");
		mysql_query("UPDATE clan SET wins=wins+1 WHERE name_short='".$wins."'");
		mysql_query("INSERT INTO news (info) VALUES ('".$msg."');");
	}
}
//-------Объявлен врагом--------------------------
if($db["glava"]==1)
{
	if ($_POST['war'])
	{
		if ($db['money']>=1000)
		{	
			$_POST["clan_names"]=htmlspecialchars(addslashes($_POST["clan_names"]));
			if ($clan_s==$_POST["clan_names"])$msg="Нападение на самого себя - это уже мазохизм...";
			else
			{
				$hava_clan=mysql_fetch_Array(mysql_query("SELECT * FROM clan WHERE name_short='".$_POST["clan_names"]."'"));
				if ($hava_clan)
				{
					if ($hava_clan["war_time"]>time())
					{
						$msg="На Ханства ".$hava_clan["name"]." невозможно объявить войну до ".(date('d.m.y H:i:s', $hava_clan["war_time"]));
					}
					else
					{
						$count_battles=mysql_fetch_Array(mysql_query("SELECT count(*) FROM clan_battle WHERE attacker='".$clan_s."' and type=1"));
						if ($count_battles[0]<3)
						{
							$res=mysql_fetch_Array(mysql_query("SELECT * FROM clan_battle WHERE defender='".$clan_s."' and attacker='".$_POST["clan_names"]."'"));
							if ($res)
							{
								if ($res["type"]==1)
								{
									$msg="Вы должны Объявит ответную войну Ханству ".$hava_clan["name"];
								}
								else $msg="Битва уже объявлен";
							}
							else
							{
								$res=mysql_fetch_Array(mysql_query("SELECT * FROM clan_battle WHERE attacker='".$clan_s."' and defender='".$_POST["clan_names"]."'"));
								if (!$res)
								{	
									mysql_query("INSERT INTO clan_battle (attacker, defender, time_end, type) VALUES ('".$clan_s."','".$_POST["clan_names"]."','".(time()+3*24*3600)."','1')");
									$battle_id=mysql_insert_id();
									mysql_Query("UPDATE users SET money=money-1000 WHERE login='".$login."'");
									say("toall_news","<font color=#990000>Ханства <b>".$clan_t."</b> объявил кровавую войну Против Ханства <b>".$hava_clan["name"]."</b></font>",$login);
									$msg="Битва объявлена";
									$log = '<span class=date>'.date("d.m.y H:i").'</span> Битва объявлена Между Ханстваом '.$clan_t.' и '.$hava_clan["name"].'<BR>';
									mysql_query("INSERT `clan_history` (`start_time`,`attacker`,`defender`,`clan_id`,`log`,`active`) values ('".time()."','".$clan_s."','".$hava_clan["name_short"]."','".$battle_id."','".$log."','1');");
								}
								else $msg="Битва уже объявлен";
							}
						}
						else $msg="Ханства может объявить 3 войны";
					}
				}
			}
		}
		else $msg="У Вас нет такой суммы - 1000.00 Зл.";
	}
}
if($db["clan_take"]==1 || $db["glava"]==1)
{	
	if ($_POST['unwar'])
	{
		if ($db['money']>=1000)
		{	
			$_POST["clan_names"]=htmlspecialchars(addslashes($_POST["clan_names"]));
			if ($clan_s==$_POST["clan_names"])$msg="Нападение на самого себя - это уже мазохизм...";
			else
			{
				$hava_clan=mysql_fetch_Array(mysql_query("SELECT * FROM clan WHERE name_short='".$_POST["clan_names"]."'"));
				$res=mysql_fetch_Array(mysql_query("SELECT * FROM clan_battle WHERE defender='".$clan_s."' and attacker='".$_POST["clan_names"]."'"));
				if ($res)
				{
					if ($res["type"]==1)
					{
						$battle_id=$res["id"];
						mysql_query("UPDATE clan_battle SET type=2 WHERE defender='".$clan_s."' and attacker='".$_POST["clan_names"]."'");
						mysql_Query("UPDATE users SET money=money-1000 WHERE login='".$login."'");
						say("toall_news","<font color=#990000>Ханства <b>".$clan_t."</b> принял вызов Против Ханства <b>".$hava_clan["name"]."</b></font>",$login);
						$msg="Битва объявлена";
						$log = '<span class=date>'.date("d.m.y H:i").'</span> Ханства '.$clan_t.' принял вызов Против Ханства '.$hava_clan["name"].'<BR>';
						mysql_query('UPDATE `clan_history` SET `log` = CONCAT(`log`,\''.$log.'\') WHERE  clan_id="'.$battle_id.'"');
					}
					else $msg="Битва уже объявлен";
				}
				else $msg="Вы должны Объявит войну Ханству ".$hava_clan["name"];
			}

		}
		else $msg="У Вас нет такой суммы - 1000.00 Зл.";
	}
}
?>
<h3>Объявит войну</h3>
<font color=red><?=$msg?></font>
<form name='war' action='main.php?act=clan&do=2&a=war' method='post'>
<table>
<TR>
	<TD>Список Ханств:</TD>
	<TD>
		<select name="clan_names">
			<?
				$sql=mysql_query("SELECT * FROM clan WHERE name_short != '".$clan_s."'");
				WHILE ($res=mysql_fetch_Array($sql))
				{
					echo "<option value='".$res["name_short"]."'>".$res["name"];
				}
			?>
		</select>
		<input type="submit" value="Объявит войну" name="war">
		<input type="submit" value="Объявит ответную войну" name="unwar">
	</TD>
</TR>
</table>
</form>
<TABLE style="border:1px solid #212120;z-index:900;background-color: #F0F0F0;"><TR><td valign=top><small>
Войны обявляются и развиваются по следующим правилам:<br>

- Любой Ханства может объявить войну другому клану. Объявление войны стоит 1000.00 Зл. Война объявляется на 3 суток.<br><br>

- С момента объявления войны в списке чата около ников враждующего Ханства появляется крестик, нажав на который производится нападение на этого персонажа.<br><br>

- Все Ханственные битвы кровавые. Проигравшая сторона получает тяжелую травму от 12 до 24 часов.<br><br>

- В бой могут вмешаться только члены данных враждующих кланов и никто более. Вмешаться в бой можно через нападение в списке чата. Никакие другие свитки нападения не действуют на битвы.<br><br>

- Ханства, которому объявили войну может объявить ответную войну. Стоимость ответной войны - 1000.00 Зл. Ханства, не ответивший на войну не сможет вмешиваться в битвы и будет подвергаться безответным кровавым нападениям от Ханства-агрессора до тех пор, пока не объявит ответную войну.<br><br>

- Ханства может объявить 3 войны и ответить на 3 войны одновременно. После окончания войны, следующая война с тем же Ханством возможна через 7 дней.<br><br>

- Если Ханству объявили войну несколько Ханствов одновременно (но не более 3х), то игроки этих Ханствов не смогут вмешиваться в клановые битвы друг друга. Каждый дерется в своем бою.<br><br>

- Объявленные и отвеченные войны и время их окончания можно увидеть в панели.<br><br>

При обнаружении багов в войнах просьба обращаться к Администраторам. 
</td></tr></table>