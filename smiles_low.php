<html>
<title>Смайлы</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<meta http-equiv="Content-Language" content="ru">
<LINK REL=StyleSheet HREF='style.css' TYPE='text/css'>
<body leftmargin="2" topmargin="2" marginheight="2" bgcolor="#faeede">
<center>
<script>
function S(name)
{
	top.talk.F1.text.focus();
	top.talk.F1.text.value = top.talk.F1.text.value + '*'+name+'* ';
}

var i=0;
while(i<128) 
{
	i++;
	document.write("<img src='img/smile/sm"+i+".gif' border='0' style='cursor:hand' onclick='S(\"sm"+i+"\");'> ");
}
</script>
</center>
</body>
</html>