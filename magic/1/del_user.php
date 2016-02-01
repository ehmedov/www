<?	
include "../conf.php";
$data = mysql_connect($base_name, $base_user, $base_pass);
mysql_select_db($db_name,$data);

$target=htmlspecialchars(addslashes($_POST['target']));
if(!empty($target))
{
	$q=mysql_query("SELECT id,login FROM users WHERE login='".$target."'");
	$res=mysql_fetch_array($q);
	if(!$res)
	{
		echo "Персонаж ".$target." не найден в базе данных.";
	}
	else
	{	
		$name=$res["login"];
		mysql_query("DELETE FROM info WHERE id_pers='".$res["id"]."'");
		mysql_query("DELETE FROM online WHERE login='".$name."'");
		mysql_query("DELETE FROM users WHERE login='".$name."'");
		mysql_query("DELETE FROM inv WHERE owner='".$name."'");
		mysql_query("DELETE FROM comok WHERE owner='".$name."'");
		mysql_query("DELETE FROM bank WHERE login='".$name."'");
		mysql_query("DELETE FROM thread WHERE creator='".$name."'");
		mysql_query("DELETE FROM topic WHERE creator='".$name."'");
		mysql_query("DELETE FROM perevod WHERE login='".$name."'");
		mysql_query("DELETE FROM complect WHERE owner='".$name."'");
		mysql_query("DELETE FROM friend WHERE login='".$name."'");
		mysql_query("UPDATE obraz SET owner='' WHERE owner='".$name."'");
		mysql_query("DELETE FROM friend WHERE friend='".$name."'");
		mysql_query("DELETE FROM bs_winner WHERE user='".$name."'");
		mysql_query("DELETE FROM house WHERE login='".$name."'");
		mysql_query("DELETE FROM report WHERE login='".$name."'");
		echo "Персонаж <b>$name</b> удален из базы...";
		history($login,"Персонаж <b>$name</b> удален из базы...","",$db["remote_ip"],$login);
	}
}
?>