<?
$login=$_SESSION['login'];
$ip=$db["remote_ip"];
if($_POST['target'])
{
	$target=htmlspecialchars(addslashes(trim($_POST['target'])));
	$q=mysql_query("SELECT * FROM users WHERE login='".$target."'");
	$res=mysql_fetch_array($q);
	if(!$res)
	{
		echo "Персонаж <B>".$target."</B> не найден в базе данных.";
	}
	else
	{
		$query=mysql_query("SELECT * FROM battles WHERE creator_id=".$res["id"]);
		if (mysql_num_Rows($query)>0)
		{
			while ($result=mysql_fetch_Array($query))
			{
				$sql1=mysql_query("SELECT player FROM teams WHERE battle_id='".$result["creator_id"]."'");
				while($sql2=mysql_fetch_Array($sql1))
				{
					mysql_query("UPDATE users SET zayavka='0', battle='0',battle_opponent='', battle_pos='', battle_team='',zver_on=0 WHERE login = '".$sql2["player"]."'");
				}
				mysql_query("DELETE FROM teams WHERE battle_id='".$result["creator_id"]."'");
				mysql_query("DELETE FROM battles WHERE id='".$result["id"]."'");	
				mysql_query("DELETE FROM bot_temp WHERE battle_id='".$result["id"]."'");	
				mysql_query("DELETE FROM battle_units WHERE battle_id='".$result["id"]."'");	
				mysql_query("DELETE FROM `hit_temp` WHERE battle_id='".$result["id"]."'");
				mysql_query("DELETE FROM `zayavka` WHERE creator='".$result["creator_id"]."'");
			}
		}
		echo "OK";
		history($login,"Заявка удалена","",$ip,$login);
	}
}
?>
