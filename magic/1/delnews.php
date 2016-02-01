<?include("key.php");
$login=$_SESSION['login'];
echo"<b>Список новостей:</b><br><table border=0 width=500>";
	$file_news = file("data/news.dat");
	for($i=0;$i<count($file_news);$i++) 
	{
		$row_news = explode("|",$file_news[$i]);
		echo "<tr><td><span id=news_date>$i. [".$row_news[0]."] </span> <span id=news_title>".$row_news[1]."</span> <a href=main.php?act=inkviz&spell=delnews&do=delete&pos=".($i+1)." onclick='return confirm(\"Вы действительно хотите удалить эту новость?\");'><small style='color:darkred'><b>[delete]</b></small></a></td></tr>\n";
	}
echo"</table>";
if ($_GET['do']=='delete')
{
	$file = @file("data/news.dat");
	unset($file[$_GET["pos"]-1]);

	$fp = @fopen("data/news.dat","w");
	@flock($fp,2);
	@fwrite($fp,implode("",$file));
	@flock($fp,3);
	@fclose($fp);
	echo "<script>document.location.href='main.php?act=inkviz&spell=delnews';</script>";
}	
?>