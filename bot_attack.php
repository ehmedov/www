<?
include('key.php');
include ("conf.php");
include ("functions.php");
$login=$_SESSION["login"];
$random=md5(time());
$data = mysql_connect($base_name, $base_user, $base_pass);
if(!mysql_select_db($db_name,$data)){echo mysql_error();die();}
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');

//------------------------------
if($_GET["bat_id"])
{
	$bat_id=(int)$_GET["bat_id"];
	$bat_sql=mysql_query("SELECT creator_id FROM battles WHERE id=".$bat_id);
	if(mysql_num_rows($bat_sql))
	{	
		$battle=mysql_fetch_Array($bat_sql);
		$bot=mysql_query("SELECT * FROM bot_temp WHERE battle_id='".$bat_id."' and hp>0");
		while ($bots=mysql_fetch_array($bot))
		{
			$enemy_teams=($bots["team"]==1?2:1);
			
			$sql=mysql_query("SELECT * FROM teams WHERE team=$enemy_teams and battle_id=".$battle["creator_id"]);
			while ($teams=mysql_fetch_array($sql))
			{
				$hits=mysql_query("SELECT * FROM hit_temp WHERE attack='".$teams["player"]."' and defend='".$bots["bot_name"]."' and battle_id=".$bat_id);
				if (!mysql_num_rows($hits))
				{
					$hit1  = rand(1,5);
	       			$hit2  = rand(1,5);
	       			$block = rand(1,5);
					hit($bots["bot_name"],$teams["player"],$hit1,$hit2,$hit3,$block,$bat_id,1);
				}
			}
			$sql_bot=mysql_query("SELECT * FROM bot_temp WHERE team=$enemy_teams and battle_id=".$bat_id." and hp>0");
			while ($teams_bot=mysql_fetch_array($sql_bot))
			{
				$hits_bot=mysql_query("SELECT * FROM hit_temp WHERE attack='".$teams_bot["bot_name"]."' and defend='".$bots["bot_name"]."' and battle_id=".$bat_id);
				if (!mysql_num_rows($hits_bot))
				{
					$hit1  = rand(1,5);
	       			$hit2  = rand(1,5);
	       			$block = rand(1,5);
					hit($bots["bot_name"],$teams_bot["bot_name"],$hit1,$hit2,$hit3,$block,$bat_id,1);
				}
			}
		}
	}
}

mysql_close($data);
?>