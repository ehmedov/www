<?include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
if(!empty($target))
{
	mysql_query("DELETE FROM inv WHERE gift_author='".$target."' and object_razdel='other'");
	echo "Подарки персонажа $target удалены...";
}
?>
