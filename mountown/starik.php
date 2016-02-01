<?
include("key.php");
$login=$_SESSION['login'];
$ip=$db["remote_ip"];
if($_GET['action'] == "change")
{
	$S = mysql_query("SELECT wood.price, wood.name, count(*) as co FROM inv LEFT JOIN wood ON wood.id=inv.object_id WHERE inv.owner='".$login."' and inv.object_type='wood' and object_id in (142,143,144,145,146,147,148,149,150) GROUP BY object_id");
	if (!mysql_num_rows($S))$mess='<font color=red>ПУСТО</font><BR>';
	else
	{
		$price=0;
		$mess="<b style=color:red>Вы удачно сдали:</b><br>";
		while($DAT = mysql_fetch_assoc($S))
		{
			$price=$DAT["co"]*$DAT["price"];
			$mess.="<b>".$DAT["name"]."</b>-".$DAT["co"]." Шт. за $price Ср. ";
			$price_all+=$price;
		}
		$mess.="<br><br>";
		mysql_query("UPDATE users SET silver=silver+$price_all WHERE login='".$login."'");
		mysql_query("DELETE FROM inv WHERE owner='".$login."' and object_type='wood' and object_id in (142,143,144,145,146,147,148,149,150)");
		history($login,"Вы удачно сдали",$mess,$db["remote_ip"],"Старый Альтаир");
	}
}
?>
<script>
function talk(phrase)
{
	if(phrase==1)
	{
		bernard.innerHTML='<B>Старый Альтаир:</B><BR>'+
		'- Да вы надоели уже! Вопросы, у всех вопросы, и, что самое интересное - у всех одинаковые!<br/><br/><br/>'+
		'<a href="javascript:talk(6)" class=us2><B>- Какой-то вы недобрый. Нельзя таким быть!...</B></a><BR>'+	
		'<a href="javascript:dialog()" class=us2><B>- Продолжить...</B></a><BR>'+
		'<a href="javascript:talk(3)" class=us2><B>- В других местах намного интереснее. (завершить разговор)</B></a>';
	}
	if(phrase==2)
	{
		bernard.innerHTML='<B>Старый Альтаир:</B><BR>- Я смогу менять их на Серебро[Ср.]... Согласен?<BR><BR>'+
		'<a href="javascript:talk(4)" class=us2><B>- Согласен...</B></a><BR>'+	
		'<a href="javascript:dialog()" class=us2><B>- Конечно, все ясно! Теперь другой вопрос...</B></a><BR>'+
		'<a href="javascript:talk(3)" class=us2><B>- Извините за беспокойство...(завершить разговор)</B></a>';
	}
	if(phrase==3)
	{
		document.location.href='?act=go&level=izumrud_floor';
	}
	if(phrase==4)
	{
		document.location.href='?action=change';
	}
	if(phrase==5)
	{
		document.location.href='?act=none';
	}
	if(phrase==6)
	{
		bernard.innerHTML='<B>Старый Альтаир:</B><BR>'+
		'- Когда каждый пришедший задает одни и те же вопросы, это кого угодно может вывести из себя. К тому же я - один из лучших Алхимиков, поэтмоу могу повзолить себе некоторые вольности в общении с людьми, не опасаясь какого-либо наказания.<br/><br/>'+ 
		'Если уж дествительно задел вас своим неприветливым обращением - прошу извинить, но и вы меня поймите. Каждый раз, каждый раз одни и те же вопросы...<br/><br/><br/>'+
		'<a href="javascript:dialog()" class=us2><B>- Понимаю вас. Сменим тему....</B></a><BR>'+
		'<a href="javascript:talk(3)" class=us2><B>- Извините за беспокойство...(завершить разговор)</B></a>';
	}
}
function dialog()
{
	var changed='<?=$mess?>';
	if (changed=='')
	{
		bernard.innerHTML='<B>Старый Альтаир:</B><BR>'+
		'- Еще один посетитель! Да вы просто бесконечные!<BR><BR>'+
		'<a href="javascript:talk(1)" class=us2><B>- А вы Кто?</B></a><BR>';
	}
	else 
	{
		bernard.innerHTML=changed+
		'<a href="javascript:talk(5)" class=us2><B>- Продолжить...</B></a><BR>';
	}
	
	bernard.innerHTML+=
	'<a href="javascript:talk(2)" class=us2><B>- Я тут Драгоценные камни нашел, тебе они случайно не нужны?</B></a><BR>'+	
	'<a href="javascript:talk(3)" class=us2><B>- Не буду обременять вас своим присутствием. (завершить разговор)</B></a>';
}

</script>

<SCRIPT language="JavaScript" type="text/javascript" src="fight.js"></SCRIPT>
<h3>Диалог с "Старый Альтаир"</h3>
<table width=100% border=0>
<tr>
	<td width=210 valign=top>
		<?
			showHPbattle($db);
			showPlayer($db);
		?>
	</td>
	<td valign=top><br>
		<table border=0 width=500 cellpadding=1 cellspacing=1 align=left><tr><td>
			<div id='bernard'></div>
			<script>dialog();</script>
		</td></tr></table>
	</td>
	<td width=210 valign=top>
		<?
		$result=mysql_query("SELECT * FROM users WHERE login='Старый Альтаир' limit 1");
		$bot=mysql_fetch_Array($result);
		mysql_free_result($result);
		showHPbattle($bot);
		showPlayer($bot);
		?>
	</td>
</tr>
</table>