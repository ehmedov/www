<?include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
if(!empty($target))
{
	$S="select * from users where login='".$target."'";
	$q=mysql_query($S);
	$res=mysql_fetch_array($q);
	if(!$res)
	{
		print "Персонаж <B>".$target."</B> не найден в базе данных.";
		die();
	}
	if ($res['battle']!=0)
	{
		$boy=mysql_query("select * from team1 where player='".$target."'");
		$result=mysql_fetch_array($boy);
		$ClearTeam1=		mysql_query("DELETE FROM team1 WHERE battle_id='".$result['battle_id']."'");
		$ClearTeam2=		mysql_query("DELETE FROM team2 WHERE battle_id='".$result['battle_id']."'");
		$ClearZayavka = 	mysql_query("DELETE FROM zayavka WHERE creator = '".$result['battle_id']."'");
		$ClearZayavkaTime = mysql_query("DELETE FROM timeout WHERE battle_id = '".$res['battle']."'");
		$ClearBattle = 		mysql_query("DELETE FROM battles WHERE creator_id = '".$result['battle_id']."'");
		$Update= mysql_query("UPDATE users SET battle = '0', battle_pos = '', battle_team = '', battle_opponent = ''  WHERE battle='".$res['battle']."'");
		//$Update= mysql_query(" UPDATE users SET battle_opponent = ''  WHERE battle_opponent='".$target."'");
		//echo "UPDATE users SET battle = '0', battle_pos = '', battle_team = '', battle_opponent = ''  WHERE battle='".$res['battle']."'";
		echo "OK";
	}
	else
	{
		print "Персонаж <B>".$target."</B> не в бою.";
		die();
	}	 
}
?>
