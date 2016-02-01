<?include("key.php");
$login=$_SESSION['login'];
$ip=$db["remote_ip"];
$news=htmlspecialchars(addslashes($_POST['news']));
$news = str_replace("&amp;","&",$news);
if ($news!="")
{	
	say("toall_news","<font color=\"#ff0000\">Объявления:</font> <font color=darkblue><b>$news</b></font>",$login);
	history($login,"Новость добавлена",$news,$ip,$login);
	echo "<b>Новость добавлена<b>";
}
?>