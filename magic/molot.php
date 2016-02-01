<?
session_start();
$login=$_SESSION['login'];
$spell=$_GET['spell'];
switch ($mtype) 
{
	case "type1": $add_krit = 50; 	$add_ms_boyech=10; 	$protect_fire=50; 	$add_sila=8;		break;
	case "type2": $add_uvorot = 50; $add_ms_boyech=10; 	$protect_earth=50; 	$add_lovkost=8;		break;
	case "type3": $add_bron = 50; 	$add_ms_mag=10; 	$add_akrit=50; 		$add_intellekt=8;	break;
}
$zaman=time()+3*60*60;
$my_id=$db["id"];
$type='molot';

if($db["battle"])
{
	say($login, "¬ы не можете кастовать это закл€тие наход€сь в бою!", $login);
}
else
{
	mysql_query("DELETE FROM effects WHERE user_id=".$my_id." and type='".$type."'");
	mysql_query("INSERT INTO effects (user_id, type, elik_id, add_krit, add_uvorot, add_bron, add_ms_boyech, add_ms_mag, protect_fire, protect_earth, add_akrit, add_sila, add_lovkost, add_intellekt, end_time) 
							VALUES ('$my_id', '$type', '$elik_id', '$add_krit', '$add_uvorot', '$add_bron', '$add_ms_boyech', '$add_ms_mag', '$protect_fire', '$protect_earth', '$add_akrit', '$add_sila', '$add_lovkost', '$add_intellekt', '$zaman')");
	$_SESSION["message"]="¬ы удачно прокастовали заклинание <b>&laquo;".$name."&raquo;</b>";
	drop($spell,$DATA);
}
echo "<script>location.href='main.php?act=inv&otdel=magic'</script>";
?>
