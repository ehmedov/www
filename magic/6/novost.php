<?include("key.php");
$login=$_SESSION['login'];
$news=htmlspecialchars(addslashes($_POST['news']));
if ($news!="")
{	
	say("toall","<b><font color=#40404A>".$news."</font></b>",$login);
	echo "<b>Новость добавлена...<b>";
}
?>
