<?
session_start();
$login=$_SESSION['login'];
$spell=$_GET['spell'];
switch ($mtype) 
{
	case "master":   $add_type="add_ms_boyech"; $add = 30; $add_min_udar=5; $add_max_udar=15;break;
	case "master1":  $add_type="add_ms_boyech"; $add = 17; $add_min_udar=2; $add_max_udar=7; break;

	case "magistr":  $add_type="add_ms_mag";    $add = 30; $add_min_udar=5; $add_max_udar=15;break;
	case "magistr1": $add_type="add_ms_mag";    $add = 17; $add_min_udar=2; $add_max_udar=7; break;
}
$zaman=time()+3*60*60;
$my_id=$db["id"];
$type='addms';

if($db["battle"])
{
	say($login, "¬ы не можете кастовать это закл€тие наход€сь в бою!", $login);
}
else
{
	mysql_query("DELETE FROM effects WHERE user_id=".$my_id." and type='".$type."'");
	mysql_query("INSERT INTO effects (user_id, type, elik_id, $add_type, min_udar, max_udar, end_time) VALUES ('$my_id', '$type', '$elik_id', '$add', '$add_min_udar', '$add_max_udar', '$zaman')");
	$_SESSION["message"]="¬ы удачно прокастовали заклинание <b>&laquo;".$name."&raquo;</b>";
	drop($spell,$DATA);
}
echo "<script>location.href='main.php?act=inv&otdel=magic'</script>";        
?>
