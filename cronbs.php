<?
include "conf.php";
include "functions.php";
$data = mysql_connect($base_name, $base_user, $base_pass);
mysql_select_db($db_name,$data);
$sql=mysql_query("SELECT t1.user,t2.room FROM bs t1 LEFT JOIN online t2 on t1.user=t2.login WHERE t2.room='smert_room'");
if (mysql_num_rows($sql))
{
	while ($res=mysql_fetch_array($sql))
	{
		$x=rand(-5,5);
		$y=rand(-5,5);
		mysql_query("UPDATE users SET bs=1, bs_x=$x, bs_y=$y WHERE login='".$res["user"]."'");
		$text="Турнир Начался...";
		$text = "sys<B style=color:#ff0000>$text</b></font>endSys";
		$chat_base = "/srv/www/meydan.az/public_html/chat/lovechat";
		$fopen_chat = fopen($chat_base,"a");
		fwrite ($fopen_chat,"::".time()."::$res[user]::#FF0000::$text::smert_room::mountown::\n");
		fclose ($fopen_chat);
	}
}
echo "Turnir Bawladi";
?>