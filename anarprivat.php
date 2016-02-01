<?
	session_start();
	$login=$_SESSION['login'];
?>
<link REV="made" href="mailto:anarbsu@rambler.ru">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<meta http-equiv="Content-Language" content="ru">
<LINK REL=StyleSheet HREF='main.css' TYPE='text/css'>
<body bgcolor=#EEEEEE>
<INPUT TYPE=button onclick="document.location.href='anarprivat.php'" value="Обновить" style="cursor:hand">
<br><br>
<?
$logins=array("bor","OBITEL","Шеф","MEGA TRON","tobu");
if (in_array($login, $logins))
{	
	echo "<TABLE width=100% cellspacing=1 cellpadding=5 bgcolor=212120>";
	$text_f="chat/lovechat";
	$text_a=file($text_f);	
	$total_results=count($text_a);
	$massages="";
	for ($i=$total_results-1; $i>0; $i--)
	{
		list($t0,$t1,$t2,$t3,$t4,$t5,$t6) = explode("::", $text_a[$i]);
		$zaman = date("H:i",$t1);
		$name = $t2;
		$color = $t3;
		$body = $t4;
		//$body = str_replace("sys","",$body);
		//$body = str_replace("endSys","",$body);
		if(substr($body, 0, 3)!= "sys")
		echo "<tr bgcolor=#EEEEEE><td width=50 align=center><font class=date1>".$zaman."</font></td><td width=250><b>[".$t2."]</b> </td><td>".$body."</td></tr>";
	}
	echo "</table>";
}
?>
<br><br><br>