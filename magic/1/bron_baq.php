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
		$res=mysql_fetch_array(mysql_query("SELECT SUM(paltar.protect_head),SUM(paltar.protect_arm),SUM(paltar.protect_corp),SUM(paltar.protect_poyas),SUM(paltar.protect_legs) FROM paltar,(SELECT object_id FROM inv WHERE owner='".$data["login"]."' and wear=1 and object_razdel='obj') as inventar where paltar.id=inventar.object_id"));
		mysql_query("update users set bron_head=".(int)$res[0].",bron_arm=".(int)$res[1].",bron_corp=".(int)$res[2].",bron_poyas=".(int)$res[3].",bron_legs=".(int)$res[4]." where login='".$data["login"]."'");
		echo "BRONYA персонажа <b>".$data["login"]."</b> успешно восстановлены!";
	}
}
?>