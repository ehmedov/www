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
		$res=mysql_fetch_array(mysql_query("SELECT SUM(paltar.krit),SUM(paltar.akrit),SUM(paltar.uvorot),SUM(paltar.auvorot) FROM paltar,(SELECT object_id FROM inv WHERE owner='".$data["login"]."' and wear=1 and object_razdel='obj') as inventar where paltar.id=inventar.object_id"));
		mysql_query("update users set krit=".(int)$res[0].",akrit=".(int)$res[1].",uvorot=".(int)$res[2].",auvorot=".(int)$res[3]." where login='".$data["login"]."'");
		echo "MF персонажа <b>".$data["login"]."</b> успешно восстановлены!";
	}
}
?>