<?
include("key.php");
$login=$_SESSION['login'];
$ip=$db["remote_ip"];
if($_GET['action'] == "change")
{
	$S = mysql_query("SELECT wood.price, wood.name, count(*) as co FROM inv LEFT JOIN wood ON wood.id=inv.object_id WHERE inv.owner='".$login."' and inv.object_type='wood' and object_id in (52,53,54,55,56,57,58,59,60,61,62,63) GROUP BY object_id");
	if (!mysql_num_rows($S))$mess='<font color=red>ПУСТО</font><BR>';
	else if ($db["naqrada"]>=20000)$mess='<font color=red>У вас больше 20000 Ед. Зачем вам столько наград? :)</font><BR>';
	else
	{
		$price=0;
		$mess="<b style=color:red>Вы удачно сдали:</b><br>";
		while($DAT = mysql_fetch_assoc($S))
		{
			$price=$DAT["co"]*$DAT["price"];
			$mess.=$DAT["name"]."-".$DAT["co"]." Шт. за $price Ед. <br>";
			$price_all+=$price;
		}
		$mess.="<br>";
		mysql_query("UPDATE users SET naqrada=naqrada+$price_all WHERE login='".$login."'");
		mysql_query("DELETE FROM inv WHERE owner='".$login."' and object_type='wood' and object_id in (52,53,54,55,56,57,58,59,60,61,62,63)");
		history($login,"Вы удачно сдали",$mess,$db["remote_ip"],"Тень Мерлина");
	}	
}
?>
<script>
function talk(phrase)
{
	if(phrase==1)
	{
		bernard.innerHTML='<B>Тень Мерлина:</B><BR>- <BR><BR>'+
		'<a href="javascript:dialog()" class=us2><B>- Продолжить...</B></a><BR>'+
		'<a href="javascript:talk(3)" class=us2><B>- Извините за беспокойство...(завершить разговор)</B></a>';
	}
	if(phrase==2)
	{
		bernard.innerHTML='<B>Тень Мерлина:</B><BR>- Я смогу менять их на награду[Ед.]... Согласен?<BR><BR>'+
		'<a href="javascript:dialog()" class=us2><B>- Продолжить...</B></a><BR>'+
		'<a href="javascript:talk(4)" class=us2><B>- Согласен...</B></a><BR>'+	
		'<a href="javascript:talk(3)" class=us2><B>- Извините за беспокойство...(завершить разговор)</B></a>';
	}
	if(phrase==3)
	{
		document.location.href='?act=go&level=dungeon';
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
		document.location.href='?act=go&level=lavka';
	}

}
function dialog()
{
	var changed='<?=$mess?>';
	if (changed=='')
	{
		bernard.innerHTML='<B>Тень Мерлина:</B><BR>'+
		'- Дорого тебе времени, путик! <br>Как здорово, что ты согласился развлечь старого человека теплой дружеской беседой...<br>'+
		'Давно ко мне не заходила ни единая душа, да и те странствующие путники не удостоили меня ни единым словом.'+
		'<br>Я буду рад побеседовать с тобой <BR>'+
		'<BR><a href="javascript:talk(1)" class=us2><B>- А вы Кто?</B></a><BR>';
	}
	else 
	{
		bernard.innerHTML=changed+
		'<a href="javascript:talk(5)" class=us2><B>- Продолжить...</B></a><BR>';
	}
	
	bernard.innerHTML+=
	'<a href="javascript:talk(2)" class=us2><B>- Я тут Ресурсы нашел, тебе они случайно не нужны?</B></a><BR>'+	
	'<a href="javascript:talk(6)" class=us2><B>- Лавка Мерлина</B></a><BR>'+	
	'<a href="javascript:talk(3)" class=us2><B>- Извините за беспокойство... (завершить разговор)</B></a>';
}

</script>

<SCRIPT language="JavaScript" type="text/javascript" src="fight.js"></SCRIPT>
<h3>Диалог с "Тень Мерлина"</h3>
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
		$result=mysql_query("SELECT * FROM users WHERE login='Тень Мерлина' limit 1");
		$bot=mysql_fetch_Array($result);
		mysql_free_result($result);
		showHPbattle($bot);
		showPlayer($bot);
		?>
	</td>
</tr>
</table>