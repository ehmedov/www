<?
echo $U=getenv("HTTP_USER_AGENT"); // получаем данные о софте, 
echo "<br>";
echo $H=getenv("HTTP_REFERER"); // получаем URL, с которого пришёл посетитель 
echo "<br>";
echo $R=getenv("REMOTE_ADDR"); // получаем IP посетителя 
echo "<br>";
echo $W=getenv("REQUEST_URI"); // получаем относительный адрес странички,
?>