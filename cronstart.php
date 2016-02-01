<?
	$text="ƒо начала турнира осталось 15 минут...  ¬сех приглашаем учавствовать на етом турнире...";
	$text = "sys<B style=color:#ff0000>$text</b></font>endSys";
	$chat_base = "/srv/www/meydan.az/public_html/chat/lovechat";
	$fopen_chat = fopen($chat_base,"a");
	fwrite ($fopen_chat,"::".time()."::sys_news::#FF0000::$text::smert_room::mountown::\n");
	fclose ($fopen_chat);
	
	echo "turnirin bawlamasina 15 deqiqe qalib";
?>