<?
	$text="«лой ƒемон закрыл все вороты в подземелье...";
	$text = "sys<B style=color:#ff0000>$text</b></font>endSys";
	$chat_base = "/srv/www/meydan.az/public_html/chat/lovechat";
	$fopen_chat = fopen($chat_base,"a");
	fwrite ($fopen_chat,"::".time()."::sys_news::#FF0000::$text::arena::mountown::\n");
	fclose ($fopen_chat);
	
	
	
	$path = "/srv/www/meydan.az/public_html/bot.dat";
	$fh = fopen($path, 'w');
	fwrite($fh,"1");
	fclose($fh); 
	
	echo "ZLOY DEMON ZAKRIL VOROT";
?>