<?
include('key.php');
//--------------------------------------------------

	$sql=mysql_query("SELECT clan_battle.*,c1.name as clan_name1, c2.name as clan_name2 FROM clan_battle LEFT JOIN clan c1 on c1.name_short=clan_battle.attacker LEFT JOIN clan c2 on c2.name_short=clan_battle.defender WHERE attacker='".$clan_s."'");
	while ($res=mysql_fetch_array($sql))
	{
		echo "<b>".$res["clan_name1"]." VS ".$res["clan_name2"]."</b>  Побед ".$res["win"]." Поражений ".$res["lose"]."<br>";
	}
	$sql=mysql_query("SELECT clan_battle.*,c1.name as clan_name1, c2.name as clan_name2 FROM clan_battle LEFT JOIN clan c1 on c1.name_short=clan_battle.attacker LEFT JOIN clan c2 on c2.name_short=clan_battle.defender WHERE defender='".$clan_s."'");
	if (mysql_num_rows($sql))echo "<br>";
	while ($res=mysql_fetch_array($sql))
	{
		echo "<b>".$res["clan_name1"]." VS ".$res["clan_name2"]."</b>  Побед ".$res["win"]." Поражений ".$res["lose"]."<br>";
	}

//--------------------------------------------------
if ($_GET["battle_id"])
{
	?>
	<TABLE style="border:1px solid #212120; background-color: #F0F0F0; width:100%;">
	<TR>
	<td valign=top>
	<?
		$battle_id=(int)$_GET["battle_id"];
		$result=mysql_fetch_Array(mysql_query("SELECT clan_history.*,c1.name as clan_name1, c2.name as clan_name2 FROM clan_history LEFT JOIN clan c1 on c1.name_short=clan_history.attacker LEFT JOIN clan c2 on c2.name_short=clan_history.defender WHERE clan_history.id=$battle_id"));
		echo $result["log"];
	?>
	</td>
	</tr>
	</table>
	<?
}
?>	
<TABLE>
<TR>
<td valign=top>
<?
	$sql=mysql_query("SELECT clan_history.*,c1.name as clan_name1, c2.name as clan_name2 FROM clan_history LEFT JOIN clan c1 on c1.name_short=clan_history.attacker LEFT JOIN clan c2 on c2.name_short=clan_history.defender WHERE attacker='".$clan_s."' ORDER BY start_time DESC, active DESC ".(!$_GET["all"]?"LIMIT 10":""));
	if (mysql_num_rows($sql))echo "<h3>Объявленные битвы<br/><small><A HREF='?act=clan&do=8&all=1'>посмотреть все</A></small></h3>";
	while ($res=mysql_fetch_array($sql))
	{
		echo "<b>[".date('d.m.y H:i:s', $res["start_time"])."]</b> ".($res["active"]?"Битва идет... ":"Битва завершен. Победила Ханства ".$res["winner"]." ")."<b>".$res["clan_name1"]." VS ".$res["clan_name2"]."</b> <A HREF='?act=clan&do=8&battle_id=".$res['id']."'>история битви »»</A><br>";
	}
	$sql=mysql_query("SELECT clan_history.*,c1.name as clan_name1, c2.name as clan_name2 FROM clan_history LEFT JOIN clan c1 on c1.name_short=clan_history.attacker LEFT JOIN clan c2 on c2.name_short=clan_history.defender WHERE defender='".$clan_s."' ORDER BY start_time DESC, active DESC ".(!$_GET["all"]?"LIMIT 10":""));
	if (mysql_num_rows($sql))echo "<h3>Ответные битвы</h3>";
	while ($res=mysql_fetch_array($sql))
	{
		echo "<b>[".date('d.m.y H:i:s', $res["start_time"])."]</b> ".($res["active"]?"Битва идет... ":"Битва завершен. Победила Ханства ".$res["winner"]." ")."<b>".$res["clan_name1"]." VS ".$res["clan_name2"]."</b> <A HREF='?act=clan&do=8&battle_id=".$res['id']."'>история битви »»</A><br>";
	}
?>
</td>
</tr>
</table>