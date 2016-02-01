<?
include "conf.php";
include "functions.php";
$data = mysql_connect($base_name, $base_user, $base_pass);
mysql_select_db($db_name,$data);
$chat_base="/srv/www/meydan.az/public_html/chat/lovechat";

#$chat_base="C:\\AppServ\www\ever\chat\lovechat";

$query=mysql_fetch_Array(mysql_query("SELECT * FROM war_group"));
if ($query)
{
	echo "Doyuw Gedir";
}
else 
{
	$wait_to=10*60+time();
	mysql_query("INSERT INTO war_group VALUES (null, unix_timestamp()+30*60,0);");
	$mess = "Начался приём заявок на Величайшую Битву между Светом и Тьмой на Пещере Воинов";
	$mess = "sys<b style=background-color:#CCD1FF>$mess</b>endSys";
	$fopen_chat = fopen($chat_base,"a");
	fwrite ($fopen_chat,"::".time()."::sys_news::#CCD1FF::$mess::room4::mountown::\n");
	fclose ($fopen_chat);
	//echo "OK";
}

?>
