<?php
$chat_base = "lovechat"; // База зарегистрированных

function  replacequot ($textreplace)
{
	$textreplace = htmlspecialchars($textreplace);
 	$textreplace = str_replace ('\\&quot;', "&quot;", $textreplace);
 	$textreplace = str_replace ("\\'", "'", $textreplace);
 	$textreplace = str_replace ('\\\\', '\\', $textreplace);
 	return $textreplace;
}

//-------------------------------------------------------------------------------------------
function de($to,$text,$sender,$otaq,$city)
{
    $text = "sys".$text."endSys";
	$chat_base = "lovechat";
	if($to == "toall"){$to = "sys";}
	$fopen_chat = fopen($chat_base,"a");
	flock  ($fopen_chat,LOCK_EX); //БЛОКИРОВКА ФАЙЛА
	fwrite ($fopen_chat,"::".time()."::$to::#990000::$text::".$otaq."::".$city."::\n");
	fflush ($fopen_chat); //ОЧИЩЕНИЕ ФАЙЛОВОГО БУФЕРА И ЗАПИСЬ В ФАЙЛ
	flock  ($fopen_chat,LOCK_UN); //СНЯТИЕ БЛОКИРОВКИ
	fclose ($fopen_chat);
}
?>