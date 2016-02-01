<?include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
$noname=$_POST['noname'];
if(!empty($target))
{	
	$QUERY=mysql_query("SELECT * FROM users WHERE login='".$target."'");
	$data=mysql_fetch_array($QUERY);
	if(!$data)
    {
    	echo "Персонаж <B>".$target."</B> не найден в базе данных.";
    }
    else 
    {
		$res=mysql_fetch_array(mysql_query("SELECT SUM(paltar.knife_vl), SUM(paltar.sword_vl), SUM(paltar.axe_vl), SUM(paltar.fail_vl), SUM(paltar.spear_vl), SUM(paltar.staff_vl), SUM(paltar.add_fire),SUM(paltar.add_earth), SUM(paltar.add_water), SUM(paltar.add_air) FROM paltar,(SELECT object_id FROM inv WHERE owner='".$data["login"]."' and wear=1 and object_razdel='obj') as inventar where paltar.id=inventar.object_id"));
		mysql_query("UPDATE users SET umenie=level+1,phisic_vl=0,castet_vl=".(int)$res[0].",sword_vl=".(int)$res[1].",axe_vl=".(int)$res[2].",hummer_vl=".(int)$res[3].",copie_vl=".(int)$res[4].",staff_vl=".(int)$res[5].",fire_magic=".(int)$res[6].",earth_magic=".(int)$res[7].",water_magic=".(int)$res[8].",air_magic=".(int)$res[9]." where login='".$data["login"]."'");
		echo "Умения персонажа <b>".$data["login"]."</b> успешно восстановлены!";
	}
}
?>