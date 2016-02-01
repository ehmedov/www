<?include("key.php");
$login=$_SESSION['login'];
$text="";
$ip=$db["remote_ip"];
if($_GET['emeliyyat'] == "cure")
{
	if($db["travm"]!=0)
	{
		$t = $db["travm_var"];
		$trmoney = array();
		$trmoney[1]=5;
		$trmoney[2]=10;
		$trmoney[3]=15;
		$price=$trmoney[$t];
		if($db["orden"]==1){$price = 0;}
		if($db["money"] >= $price)
		{
			$t_stat = $db["travm_stat"];
			$o_stat = $db["travm_old_stat"];
			$travma = mysql_query("UPDATE users SET $t_stat=$t_stat+$o_stat,travm='0',money=money-$price, travm_stat='', travm_var='', travm_old_stat='' WHERE login='".$login."'");
			$msg="Бернард вылечил Вашу травму за $price Зл.";
			$name2="$price Зл.";
			$db["travm_var"]='';
			$db["travm"]=0;
			history($login,'Излечился от травмы',$name2,$ip,'Больница');
		}
		else
		{
			$msg="У Вас недостаточно денег, что бы оплатить услуги Бернарда.";
		}
	}
	else $msg="Извините, но у нас Вам делать нечего, Вы абсолютно здоровы!";
}
?>
<script>

function cure()
{
	location.href='?emeliyyat=cure';
}
function talk(phrase)
{
var tab_b='<center><table border=0 width=95% cellpadding=1 cellspacing=1><tr><td>';
var tab_e='</td></tr></table><BR>';
if(phrase==1)
{
	bernard.innerHTML=tab_b+'<B>Бернард:</B><BR>- Я Сэр Бернард Де Фоль, местный врачеватель. Я занимаюсь лечением травм, продаю некоторые медецинские препараты и снадобья. Могу изготовить на заказ лечебное снадобье. Но, к сожалению сейчас у меня завязаны руки - мне еще не завезли ни припаратов ни приборы...<BR><BR><a href="javascript:dialog()" class=us2><B>- Продолжить...</B></a><BR><a href="javascript:talk(2)" class=us2><B>- Извините за беспокойство...(завершить разговор)</B></a>'+tab_e;
}
if(phrase==2)
{
	document.location.href='?act=go&level=remesl';
}
if(phrase==3)
{
	<?
        if($db["orden"]==1)
        {
        	echo "bernard.innerHTML=tab_b+'<B>Бернард:</B><BR>- Коллега! Я вылечу Вас бесплатно!!!.<BR><BR><a href=\"javascript:cure()\" class=us2><B>- Конечно, вылечите меня...</B></a><BR><a href=\"javascript:talk(2)\" class=us2><B>- Нестоит, думаю само заживет...(завершить разговор)</B></a>'+tab_e";
        }
        else
        {
        	if($db["travm_var"]==1)
        	{
        		echo "bernard.innerHTML=tab_b+'<B>Бернард:</B><BR>- Конечно!Я смотрю у вас небольшой ушиб? Это легко излечимо! Я сделаю это для Вас всего за <b>5 Зл.</b><BR><BR><a href=\"javascript:cure()\" class=us2><B>- Конечно, вылечите меня...</B></a><BR><a href=\"javascript:talk(2)\" class=us2><B>- Нестоит, думаю само заживет...(завершить разговор)</B></a>'+tab_e";
        	}
        	else if($db["travm_var"]==2)
        	{
        		echo "bernard.innerHTML=tab_b+'<B>Бернард:</B><BR>- Ого!Да у Вас перелом! Дело требует дополнительные перевязки... Я вылечу Вас всего за <b>10 Зл.</b><BR><BR><a href=\"javascript:cure()\" class=us2><B>- Конечно, вылечите меня...</B></a><BR><a href=\"javascript:talk(2)\" class=us2><B>- Нестоит, думаю само заживет...(завершить разговор)</B></a>'+tab_e";
        	}
        	else if($db["travm_var"]==3)
        	{
        		echo "bernard.innerHTML=tab_b+'<B>Бернард:</B><BR>- О, Господи! Кто это так отходил Вас? У Вас серьезные переломы! Тут не обойтись простой перевязкой.... Я думаю это будет стоить Вам <b>15 Зл.</b><BR><BR><a href=\"javascript:cure()\" class=us2><B>- Конечно, вылечите меня...</B></a><BR><a href=\"javascript:talk(2)\" class=us2><B>- Нестоит, думаю само заживет...(завершить разговор)</B></a>'+tab_e";
        	}
        	else if($db["travm_var"]==4)
        	{
        		echo "bernard.innerHTML=tab_b+'<B>Бернард:</B><BR>- О, Господи! У Вас сильный перелом... Я не могу излечить такой перелом...<BR><BR><a href=\"javascript:dialog()\" class=us2><B>- Продолжить...</B></a><BR><a href=\"javascript:talk(2)\" class=us2><B>- Нестоит, думаю само заживет...(завершить разговор)</B></a>'+tab_e";
        	}
        }
	?>
}

}
function dialog()
{
	bernard.innerHTML='<center><table border=0  width=95% cellpadding=1 cellspacing=1><tr><td><B>Бернард:</B><BR>- День добрый! Я очень извиняюсь, но моя аптека еще не работает...К сожалению нам еще не завезли препараты и приборы...Как только мы откроемся Вы об этом сразу же узнаете! А пока что я могу только подлечить Ваши раны.<BR><BR><a href="javascript:talk(1)" class=us2><B>- А вы Кто?</B></a><?if($db["travm"]!=0){print "<BR><a href=\"javascript:talk(3)\" class=us2><B>- Вы немогли бы подлечить меня?</B></a>";}?><BR><a href="javascript:talk(2)" class=us2><B>- Извините за беспокойство... (завершить разговор)</B></a></td></tr></table><BR>';
}

</script>
<SCRIPT language="JavaScript" type="text/javascript" src="fight.js"></SCRIPT>
<h3>Больница</h3>
<font color=red><?echo $msg?>&nbsp;</font>
<table width=100%>
<tr valign=top>
<td>
	<?
		showHPbattle($db);
		showPlayer($db);
	?>
</td>
<td>
	<div id='bernard'></div>
	<script>dialog();</script>
</td>
<td width=210>
	<?
	$result=mysql_query("SELECT * FROM users WHERE login='Бернард' limit 1");
	$bot=mysql_fetch_Array($result);
	mysql_free_result($result);
	showHPbattle($bot);
	showPlayer($bot);
	?>
</td>
</tr>
</table>