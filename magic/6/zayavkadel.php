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
	$boy=mysql_query("select * from teams where player='".$target."'");
	$result=mysql_fetch_array($boy);

	mysql_query("DELETE FROM teams WHERE battle_id='".$result['battle_id']."'");	
	mysql_query("DELETE FROM zayavka WHERE creator = '".$result['battle_id']."'");
	mysql_query("UPDATE users SET zayavka=0 WHERE login = '".$target."'");
	//mysql_query("UPDATE battles SET status='finished' WHERE creator_id='".$result['battle_id']."'");
	//$ClearZayavkaTime = mysql_query("DELETE FROM timeout WHERE battle_id = '".$res['battle']."'");
	//$ClearBattle = 		mysql_query("DELETE FROM battles WHERE creator_id = '".$result['battle_id']."'");
	//$Update= mysql_query("UPDATE users SET battle = '0', battle_pos = '', battle_team = '', battle_opponent = ''  WHERE battle='".$res['battle']."'");
	//$Update= mysql_query(" UPDATE users SET battle_opponent = ''  WHERE battle_opponent='".$target."'");
	//echo "UPDATE users SET battle = '0', battle_pos = '', battle_team = '', battle_opponent = ''  WHERE battle='".$res['battle']."'";
	history($login,"Zayafkani pozmaq","",$ip,$login);
	echo "OK";	 
}
?>
