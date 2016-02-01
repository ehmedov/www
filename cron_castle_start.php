<?
	$text="До начала Битвы за Замок осталось 15 минут...  Всех приглашаем учавствовать на етом Битве... В бой попадают только те игроки кланов, которые находятся в Клановом Замке до начала штурма.";
	$text = "sys<B style=color:#ff0000>$text</b></font>endSys";
	$chat_base="/srv/www/meydan.az/public_html/chat/lovechat";
	$fopen_chat = fopen($chat_base,"a");
	fwrite ($fopen_chat,"::".time()."::sys_news::#FF0000::$text::smert_room::mountown::\n");
	fclose ($fopen_chat);
	
	echo "Bitva Za Zamokun bawlamasina 15 deqiqe qalib";
?>