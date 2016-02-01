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

		$sql_teams=mysql_fetch_Array(mysql_query("SELECT * FROM zayavka_teams WHERE player='".$res["login"]."'"));
		if($sql_teams)
		{
			$sql_teams_p=mysql_query("SELECT * FROM zayavka_teams WHERE battle_id=".$sql_teams["battle_id"]);
			while ($result=mysql_fetch_array($sql_teams_p))
			{	
				mysql_query("UPDATE users SET zayava=0 WHERE login='".$result["player"]."'");
			}
			mysql_query("DELETE FROM zayavka_teams WHERE battle_id=".$sql_teams["battle_id"]);
			mysql_query("DELETE FROM zayavka_bot WHERE id=".$sql_teams["battle_id"]);
			echo "OK-Спуск в Катакомбы";
		}
		else
		{
			$sql_teams=mysql_fetch_Array(mysql_query("SELECT * FROM z_login WHERE player='".$res["login"]."'"));
			if ($sql_teams)
			{
				$sql_teams_p=mysql_query("SELECT * FROM z_login WHERE group_id=".$sql_teams["group_id"]);
				while ($result=mysql_fetch_array($sql_teams_p))
				{	
					mysql_query("UPDATE users SET zayava=0 WHERE login='".$result["player"]."'");
				}
				mysql_query("DELETE FROM z_login WHERE group_id=".$sql_teams["group_id"]);
				mysql_query("DELETE FROM z_group WHERE id=".$sql_teams["group_id"]);
				echo "OK-Вход в Клад";
			}
			else
			{
				mysql_query("UPDATE users SET zayava=0 WHERE login='".$res["login"]."'");
				echo "OK";
			}
		}
	}
}
?>
