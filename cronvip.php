<?
include "conf.php";
$data = mysql_connect($base_name, $base_user, $base_pass);
mysql_select_db($db_name,$data);
$sql=mysql_query("SELECT login FROM person_proff LEFT JOIN users on users.id=person_proff.person WHERE person_proff.proff=9 and users.vip<".time()." ORDER BY person_proff.navika DESC LIMIT 0,5");
#$sql=mysql_query("SELECT login FROM users WHERE orden!=5 and blok!=1 AND vip<".time()." ORDER BY (win-lose) DESC LIMIT 0,5");
while ($groups=mysql_fetch_array($sql))
{
	$vip=time()+7*24*3600;
	$logins.=$comma."<b>".$groups["login"]."</b>";
	$comma=", ";
 	mysql_query("UPDATE users SET vip=".$vip." WHERE login='".$groups["login"]."'");
}
$text="¬оины ".$logins." попали в еженедельную п€терку лучших воинов и стали обладател€ми <b>VIP</b> на неделю";
mysql_query("INSERT INTO news (info,type) VALUES ('".$text."',2);");
$text = "sys<font style=color:#ff0000>$text</font>endSys";
$chat_base = "/srv/www/meydan.az/public_html/chat/lovechat";
#$chat_base="C:\\AppServ\www\ever\chat\lovechat";
$fopen_chat = fopen($chat_base,"a");
fwrite ($fopen_chat,"::".time()."::sys_news::#FF0000::$text::smert_room::mountown::\n");
fclose ($fopen_chat);

echo "BOYEVOY Reytinq: ".$logins;
?>