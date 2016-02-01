<?include("key.php");
$login=$_SESSION['login'];
?>
<div align=right>
<form name='addnews' action='main.php?act=orden&ord=1&spell=addnews' method='post'>
<table border=0 class=inv width=500 height=120>
<tr>
	<td align=right valign=top>
		Заголовок:
	</td>
	<td>
		<input type=text name='news_title' class=new size=100>
	</td>
</tr>
<tr>
	<td align=right valign=top>		
		Текст: 
	</td>
	<td>
		<textarea rows="15" name="news_content" cols="100" class=new></textarea>		
	</td>
</tr>
<tr>
	<td align=center colspan=2>	
		<input type=submit value=" Применить " class=new>
	</td>
</tr>

</table>
</form>
<?
	$_POST["news_title"] = StripSlashes(trim($_POST["news_title"]));
	$_POST["news_content"] = str_replace("\n","<br>",StripSlashes(trim($_POST["news_content"])));
	if (!empty($_POST['news_title']) && !empty($_POST['news_content']) && ($db['orden']==1))
	{
		$fp = @fopen("data/news.dat","a+");
		@flock($fp,2);
		@fwrite($fp,Date("d-m-Y H:i")."|".$_POST["news_title"]."|".$_POST["news_content"]."|".$_SESSION["login"]."#".$db['level']."#".$db['orden']."#\n");
		@flock($fp,3);
		@fclose($fp);
	}
?>