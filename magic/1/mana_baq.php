<?include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
$noname=$_POST['noname'];
if(!empty($target))
{	
	$data=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE login='".$target."'"));
	if(!$data)
    {
    	echo "Персонаж <B>".$target."</B> не найден в базе данных.";
    }
    else 
    {
		$res=mysql_fetch_array(mysql_query("SELECT SUM(add_mana) FROM inv WHERE owner='".$data["login"]."' and wear=1 and object_razdel='obj'"));
		mysql_query("UPDATE users SET mana_all=".$res[0]."+vospriyatie*10 where login='".$data["login"]."'");
		echo "MANA персонажа <b>".$data["login"]."</b> успешно восстановлены!";
	}
}
?>