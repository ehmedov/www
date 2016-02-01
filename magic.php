<?
$login=$_SESSION['login'];
$type=htmlspecialchars(addslashes($_GET['type']));
$spell=(int)$_GET['spell'];

$DATA_S = mysql_query("SELECT * FROM inv LEFT JOIN scroll on scroll.id=inv.object_id WHERE inv.id='".$spell."' and inv.owner='".$login."' and object_type='".$type."'");
$DATA = mysql_fetch_array($DATA_S);
if ($DATA)
{
	$elik_id=$DATA["object_id"];
	$mtype=$DATA["mtype"];
	$min_i = $DATA["min_intellekt"];
	$min_v = $DATA["min_vospriyatie"];
	$min_l = $DATA["min_level"];
	$orden = $DATA["orden"];
	$name = $DATA["name"];
	$mana = $DATA["mana"];
	$file = $DATA["files"];
	if($DATA["orden"])
	{
		if($orden == $db["orden"]){$ordens = 1;	}
		else{$ordens = 0;}
	}
	else{$ordens = 1;}

	if($db["intellekt"]+$effect["add_intellekt"]>=$min_i && $db["vospriyatie"]>=$min_v && $db["level"]>=$min_l && $ordens && $db["mana"]>=$mana)
	{
		if (file_exists("magic/".$file))
		include "magic/".$file;
	}
	else
	{
		$_SESSION["message"]="У Вас недостаточно параметров для кастования этого заклятия!";
		echo "<script>location.href='main.php?act=inv&otdel=magic'</script>";
	}
}
else
{
	$_SESSION["message"]="Свиток не найден!";
	echo "<script>location.href='main.php?act=inv&otdel=magic'</script>";
}
?>