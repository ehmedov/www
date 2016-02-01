<?
$bot=mysql_query("SELECT * FROM bot_temp WHERE battle_id='".$bid."' and hp>0");
while ($bots=mysql_fetch_array($bot))
{
	if ($bots["team"]==1)$enemy_teams=2; else if ($bots["team"]==2)$enemy_teams=1;
	
	$sql=mysql_query("SELECT player FROM teams LEFT JOIN users on users.login=teams.player WHERE teams.team=".$enemy_teams." and teams.battle_id=".$creator." and users.hp>0");
	while ($teams=mysql_fetch_array($sql))
	{
		$hits=mysql_fetch_array(mysql_query("SELECT count(*) FROM hit_temp WHERE attack='".$teams["player"]."' and defend='".$bots["bot_name"]."' and battle_id=".$bid));
		if (!$hits[0])
		{
			$block = rand(1,5);
			if($bots["bot_name"]=="Тень")$block = 0;
			$hit1  = rand(1,5);$hit2  = rand(1,5);
			hit($bots["bot_name"],$teams["player"],$hit1,$hit2,$hit3,$block,$bid,1);
		}
	}
	$sql_bot=mysql_query("SELECT bot_name FROM bot_temp WHERE team=".$enemy_teams." and battle_id=".$bid." and hp>0");
	while ($teams_bot=mysql_fetch_array($sql_bot))
	{
		$hits_bot=mysql_fetch_array(mysql_query("SELECT count(*) FROM hit_temp WHERE attack='".$teams_bot["bot_name"]."' and defend='".$bots["bot_name"]."' and battle_id=".$bid));
		if (!$hits_bot[0])
		{
			$hit1  = rand(1,5);$hit2  = rand(1,5);$block = rand(1,5);
			hit($bots["bot_name"],$teams_bot["bot_name"],$hit1,$hit2,$hit3,$block,$bid,1);
		}
	}
}
?>