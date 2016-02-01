<?
include("key.php");
$login=$_SESSION['login'];
if($db["orden"]==1 && $db["admin_level"]>=10)
{
	if ($_POST["startBattle"])
	{
		$query=mysql_fetch_Array(mysql_query("SELECT count(*) FROM zayavka WHERE type=23"));
		if ($query[0])echo "Поединок идет...";
		else 
		{
			$res=mysql_fetch_Array(mysql_query("SELECT users.login,id,level,users.remote_ip FROM online LEFT JOIN users on users.login=online.login WHERE users.battle=0 and zayavka=0 and online.room='room4' and level>=9 ORDER BY level DESC LIMIT 1"));
			if ($res)
			{
				$prototype="Исчадие Хаоса";
				mysql_query("INSERT INTO zayavka(status,type,timeout,creator) VALUES('3','23','3','".$res["id"]."')");
		        mysql_query("INSERT INTO teams(player,team,ip,battle_id,hitted,over,leader) VALUES('".$res["login"]."','1','".$res["remote_ip"]."','".$res["id"]."','0','0','1')");
				addBot($res["login"],$res["id"],$prototype,$prototype);
				goBattle($res["login"]);
				say("toall_news","<font color=\"#ff0000\">Объявления:</font> <font color=darkblue><b>Началась Битва между ".$res["login"]." и Исчадием Хаоса</b></font>",$res["login"]);
				echo "OK";
			}
			else echo "NO USERS";
		}
	}
	if ($_POST["heal"])
	{
		$query=mysql_fetch_Array(mysql_query("SELECT * FROM zayavka WHERE type=23"));
		if ($query)
		{
			$res=mysql_fetch_array(mysql_Query("SELECT * FROM battles WHERE creator_id=".$query["creator"]));
			$have_bot=mysql_fetch_array(mysql_Query("SELECT * FROM bot_temp WHERE battle_id=".$res["id"]." and team=2"));
			$hp_add=50000;
			$new_hp=$have_bot["hp"]+$hp_add;
			if ($new_hp>$have_bot["hp_all"]) 
			{
				$new_hp=$have_bot["hp_all"];
				$hp_add=$have_bot["hp_all"]-$have_bot["hp"];
			}	
			mysql_Query("UPDATE bot_temp SET hp=hp+$hp_add WHERE id=".$have_bot["id"]);
			$phrase_priem  = "<span class=date>".date("H:i")."</span> <b>Исчадие Хаоса</b> понял что его спасение это прием <b>Воля к победе. <font color=green>+$hp_add</font></b> [".$new_hp."/".$have_bot['hp_all']."]<br>";
			battle_log($res["id"], $phrase_priem);
		}
		else echo "You Should Start Battle";
	}
	?>
	<form method="POST" action="?spell=chaos_battle">
		Битва с Исчадием Хаоса <input type="submit" name="startBattle" value="Start Battle"><BR>
		Heal HP <input type="submit" name="heal" value="OK"><BR>
	</form>	
	<?
}
?>
