<?include "conf.php";include "functions.php";$data = mysql_connect($base_name, $base_user, $base_pass);mysql_select_db($db_name,$data);//type=0 100 AZNlik//type=1  10 AZNlik####################################################################################$sql_give_1=mysql_fetch_array(mysql_query("SELECT user_id,login FROM bank_member LEFT JOIN users ON users.id=bank_member.user_id WHERE give=0 and type=0 GROUP BY user_id ORDER BY count(*) DESC"));if ($sql_give_1){	mysql_query("UPDATE bank_member SET give=1 WHERE user_id=".$sql_give_1["user_id"]);	mysql_Query("UPDATE users SET platina=platina+5000 WHERE id=".$sql_give_1["user_id"]);	$txt_give_login[1]=$sql_give_1["login"];	history($txt_give_login[1],"���������� ��������[100AZN]","5000 ��.","","���������� ��������[100AZN]");}	$sql_give_2=mysql_fetch_array(mysql_query("SELECT user_id,login FROM bank_member LEFT JOIN users ON users.id=bank_member.user_id WHERE give=0 and type=0 GROUP BY user_id ORDER BY count(*) DESC"));if ($sql_give_2){	mysql_query("UPDATE bank_member SET give=1 WHERE user_id=".$sql_give_2["user_id"]);	mysql_Query("UPDATE users SET platina=platina+3000 WHERE id=".$sql_give_2["user_id"]);	$txt_give_login[2]=$sql_give_2["login"];	history($txt_give_login[2],"���������� ��������[100AZN]","3000 ��.","","���������� ��������[100AZN]");}$sql_give_3=mysql_fetch_array(mysql_query("SELECT user_id,login FROM bank_member LEFT JOIN users ON users.id=bank_member.user_id WHERE give=0 and type=0 GROUP BY user_id ORDER BY count(*) DESC"));if ($sql_give_3){	mysql_query("UPDATE bank_member SET give=1 WHERE user_id=".$sql_give_3["user_id"]);	mysql_Query("UPDATE users SET platina=platina+2000 WHERE id=".$sql_give_3["user_id"]);	$txt_give_login[3]=$sql_give_3["login"];	history($txt_give_login[3],"���������� ��������[100AZN]","2000 ��.","","���������� ��������[100AZN]");}####################################################################################$sql_give_1=mysql_fetch_array(mysql_query("SELECT user_id,login FROM bank_member LEFT JOIN users ON users.id=bank_member.user_id WHERE give=0 and type=1 GROUP BY user_id ORDER BY count(*) DESC"));if ($sql_give_1){	mysql_query("UPDATE bank_member SET give=1 WHERE user_id=".$sql_give_1["user_id"]);	mysql_Query("UPDATE users SET platina=platina+1000 WHERE id=".$sql_give_1["user_id"]);	$txt_give_login[4]=$sql_give_1["login"];	history($txt_give_login[4],"���������� ��������[10AZN]","1000 ��.","","���������� ��������[10AZN]");}	$sql_give_2=mysql_fetch_array(mysql_query("SELECT user_id,login FROM bank_member LEFT JOIN users ON users.id=bank_member.user_id WHERE give=0 and type=1 GROUP BY user_id ORDER BY count(*) DESC"));if ($sql_give_2){	mysql_query("UPDATE bank_member SET give=1 WHERE user_id=".$sql_give_2["user_id"]);	mysql_Query("UPDATE users SET platina=platina+500 WHERE id=".$sql_give_2["user_id"]);	$txt_give_login[5]=$sql_give_2["login"];	history($txt_give_login[5],"���������� ��������[10AZN]","500 ��.","","���������� ��������[10AZN]");}$sql_give_3=mysql_fetch_array(mysql_query("SELECT user_id,login FROM bank_member LEFT JOIN users ON users.id=bank_member.user_id WHERE give=0 and type=1 GROUP BY user_id ORDER BY count(*) DESC"));if ($sql_give_3){	mysql_query("UPDATE bank_member SET give=1 WHERE user_id=".$sql_give_3["user_id"]);	mysql_Query("UPDATE users SET platina=platina+300 WHERE id=".$sql_give_3["user_id"]);	$txt_give_login[6]=$sql_give_3["login"];	history($txt_give_login[6],"���������� ��������[10AZN]","300 ��.","","���������� ��������[10AZN]");}####################################################################################$chat_base = "/srv/www/meydan.az/public_html/chat/lovechat";$text1 = "���������� �������� 100AZN ���� <b>".$txt_give_login[1]." - 5000 ��.</b>, <b>".$txt_give_login[2]." - 3000 ��.</b>, <b>".$txt_give_login[3]." - 2000 ��.</b>";$text1 = "sys<font style=color:#ff0000>".$text1."</font>endSys";$text2 = "���������� �������� 10AZN ���� <b>".$txt_give_login[4]." - 1000 ��.</b>, <b>".$txt_give_login[5]." - 500 ��.</b>, <b>".$txt_give_login[6]." - 300 ��.</b>";$text2 = "sys<font style=color:#ff0000>".$text2."</font>endSys";$fopen_chat = fopen($chat_base,"a");fwrite ($fopen_chat,"::".time()."::sys_news::#FF0000::".$text1."::room4::mountown::\n");fwrite ($fopen_chat,"::".time()."::sys_news::#FF0000::".$text2."::room4::mountown::\n");fclose ($fopen_chat);?>