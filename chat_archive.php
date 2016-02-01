<?
session_start();
ob_start("@ob_gzhandler");
include ("conf.php");
include ("key.php");
$login=$_SESSION["login"];

header("Content-Type: text/html;charset=windows-1251");
Header("Cache-Control: no-cache, must-revalidate"); // говорим браузеру что-бы он не кешировал эту страницу
Header("Pragma: no-cache");

$data = mysql_connect($base_name, $base_user, $base_pass) or die('Не получается подключиться. Проверьте имя сервера, имя пользователя и пароль!');
mysql_select_db($db_name) or die('Ошибка входа в базу данных');

$db=mysql_fetch_array(mysql_query("SELECT adminsite FROM users WHERE login='".$login."'"));
if(!$db["adminsite"]){die ("Вам сюда нельзя!");}
?>
<HTML>
<head>
	<title>WWW.OlDmeydan.Pe.Hu - отчеты о переводах.</title>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<meta http-equiv="Content-Language" content="ru">
	<META Http-Equiv=Cache-Control Content="no-cache, max-age=0, must-revalidate, no-store">
	<meta http-equiv=PRAGMA content=NO-CACHE>
	<meta http-equiv=Expires content=0>
	<LINK REL=StyleSheet HREF='main.css' TYPE='text/css'>
	<script language="JavaScript" type="text/javascript" src="ajax/ch.js"></script>
</head>
<body bgcolor=#dddddd topMargin=5 leftMargin=0 rightMargin=0 bottomMargin=0 >
<?
//----------------------------------------------------
if ($_GET["file_name"]!="")
{
	if(!isset($_GET['page'])||$_GET['page']==0)
	{
		$page = 1;
	} 
	else 
	{ 
		$page = abs($_GET['page']);
	}
	
	$file_name=htmlspecialchars(addslashes($_GET["file_name"]));
	$filename="chat/data/$file_name";
	$text_a=file($filename);
	$total_results=count($text_a);
	
	$max_results = 500;
	$from = (($page * $max_results) - $max_results); 
	$to=$from+$max_results;
	if ($to>$total_results)$to=$total_results;
	
	$total_pages = ceil($total_results / $max_results); 
	
	echo "<div align=right>";
	for($i = 1; $i < $total_pages+1; $i++)
	{
		echo "<a onclick=\"loadText('".$file_name."&page=$i');\" style='cursor:hand'>";
	    if(($page) == $i){echo "<font color=red><b>$i</b></font>&nbsp;";} else {echo $i."&nbsp;";}
	    echo "</a>";
	}
	echo "</div><hr>";
	
	for ($i=$from;$i<$to;$i++)
	{
		list($t0,$t1,$t2,$t3,$t4,$t5,$t6) = explode("::", $text_a[$i]);
		$zaman = date("H:i:s",$t1);
		$name = $t2;
		$color = $t3;
		$body = $t4;
		if(substr($body, 0, 3)!= "sys")
		echo "<font class=date1>".$zaman."</font>&nbsp;&nbsp;<b>[".$name."]</b> ".$body."<br>";	
	}
	echo "<hr>";
	echo "<div align=right>";
	for($i = 1; $i < $total_pages+1; $i++)
	{
		echo "<a onclick=\"loadText('".$file_name."&page=$i');\" style='cursor:hand'>";
	    if(($page) == $i){echo "<font color=red><b>$i</b></font>&nbsp;";} else {echo $i."&nbsp;";}
	    echo "</a>";
	}
	echo "</div>";
}
else
{	
	//----------------------------------------------------
	$dir = realpath('chat/data');
	$images = scandir($dir);
	echo "<center>
	Дата: <select name=file_name onchange=\"loadText(this.value);\">";
	foreach ($images as $image) 
	{
		if (substr($image, 0, 1) != '.') 
		{
			echo "<option value='$image' ".($_POST["file_name"]==$image?"selected":"").">$image[0]$image[1].$image[2]$image[3].$image[4]$image[5]$image[6]$image[7]</option>";
		}
	}
	echo "</select>
	<hr></center>";
	echo "<div id=content></div>";
}
?>