<?
$login=$_SESSION['login'];
$ip=$db["remote_ip"];
if($_POST['target'])
{
	$target=htmlspecialchars(addslashes(trim($_POST['target'])));
	$res=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE login='".$target."'"));
	if(!$res)
	{
		echo "Персонаж <B>".$target."</B> не найден в базе данных.";
	}
	else
	{
		mysql_query("DELETE FROM teams WHERE player='".$res["login"]."'");
		mysql_query("DELETE FROM battle_units WHERE player='".$res["login"]."'");
		mysql_query("DELETE FROM person_on WHERE id_person='".$res["id"]."'");
		mysql_query("UPDATE users SET zayavka='0', battle='0',battle_opponent='', battle_pos='', battle_team='',zver_on=0 WHERE login = '".$res["login"]."'");
		mysql_query("UPDATE users SET battle_opponent = ''  WHERE battle_opponent='".$res["login"]."'");
		mysql_query("DELETE FROM `hit_temp` WHERE attack='".$res["login"]."' OR defend='".$res["login"]."'");
		echo "OK";
		history($login,"Заявка удалена","",$ip,$login);
	}
}
?>
