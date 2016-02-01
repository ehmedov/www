<html>
<title>Смайлы</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<meta http-equiv="Content-Language" content="ru">
<LINK REL=StyleSheet HREF='style.css' TYPE='text/css'>
<body leftmargin="2" topmargin="2" marginheight="2" bgcolor="#f2f0f0">
<center>
<script>
function S(name)
{
	var sData = dialogArguments;
	sData.F1.text.focus();
	sData.F1.text.value = sData.F1.text.value + '*'+name+'* ';
}

var i=0;
while(i<128) 
{
	i++;
	document.write("<IMG SRC='img/smile/sm"+i+".gif' BORDER=0 style='cursor:hand' onclick='S(\"sm"+i+"\")'> ");
}
</script>
<br /><input class=b type=button onClick="window.close()" value="Закрыть окно">
</center>
</body>
</html>