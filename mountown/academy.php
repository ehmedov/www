<?
include_once('time.php');
$login=$_SESSION["login"];
#mysql_query("INSERT INTO `academy` VALUES (null, 'Торговеч', 24, 300);");

if ($db['k_time']!=0 && $db['k_time']<time())
{
	mysql_query("INSERT INTO `person_proff` (`person`, `proff`) VALUES ('".$db["id"]."', '".$db["proff"]."')");
	mysql_query("UPDATE users SET k_time=0, proff=0 WHERE login='".$login."'");
	$db["k_time"]=0;
	$db["proff"]=0;
	talk($login,"Обучениe оконченo...",$db);
}

if ($_GET["getproff"]!="") 
{
	$ch=mysql_fetch_array(mysql_query("SELECT * FROM academy WHERE id=".intval($_GET["getproff"]).""));
	if ($ch["id"]) 
	{ 
		if(!mysql_num_rows(mysql_query("SELECT * FROM person_proff WHERE person='".$db["id"]."' and proff='".$ch["id"]."'")))
		{
			if ($db["k_time"]<time())
			{
				if ($db["money"]>=$ch["price"])
				{ 
					if ($db["level"]>=8)
					{
						mysql_query("UPDATE users SET proff=".$ch["id"].", k_time=".(time()+($ch["srok"]*0)).", money=money-".$ch["price"]." WHERE login='".$login."'");
						$db["money"]=$db["money"]-$ch["price"];
						$db["k_time"]=(time()+($ch["srok"]*0));
						$db["proff"]=$ch["id"];
						$msg="Процесс обучения начат! По окончанию обучения Вы станете высококвалицицированным специалистом!";
					}
					else $msg="Вы не можете получить эту профессию, уровень маловат!";
				}
				else $msg="У Вас нет достаточной суммы!";
			}
			else $msg="Вы не можете заниматься сразу двумя делами!";
		}
		else $msg="У вас уже есть профессия: ".$ch["title"];
	}
	else $msg="Академия не предоставляет таких услуг!";
}
 
echo"<h3>Академия Профессии</h3>
<table width=100% cellspacing=0 cellpadding=5 border=0>
<tr>
<td width=100% valign=top nowrap>
	У вас в наличии: <B>".sprintf ("%01.2f", $db["money"])."</b> Зл. <b>".sprintf ("%01.2f", $db["platina"])."</b> Пл.
</td>
<td align=right valign=top nowrap>
	<input type=button value=Обновить onclick='window.location.href=\"main.php?act=none&tmp=\"+Math.random();\"\"'>
	<input type=button value=Вернуться onclick='window.location.href=\"main.php?act=go&level=okraina&tmp=\"+Math.random();\"\"'>
</td>
</tr>
</table>";


echo "<center><font color='#ff0000'><b>$msg</b></font></center><br>
<table width=100% cellspacing=0 cellpadding=3 border=0>
<tr>
<td align=right>
<table width=800 cellspacing=0 cellpadding=5 align=center>
<tr>
<td align=center>
	<TABLE width=100% cellspacing=1 cellpadding=5 class='l3' align=center>
	<TR class='l2' style='color:#ffffff'>
		<td><b>Наименование</b></td>
		<td width=150 align=center><b>Срок обучения</b></td>
		<td width=160 align=center><b>Стоимость обучения</b></td>
		<td align=center width=120><b>Роспись</b></td>
	</tr>";
	$ac=mysql_query("SELECT * FROM academy");
	while($acs=mysql_fetch_array($ac))
	{
		echo"
		<tr class='l0'>
		<td><b>$acs[title]</b></td>
		<td align=center>".($acs["srok"])." час</b></td>
		<td align=center>".$acs["price"].".00 Зл.</b></td>
		<td align=center>";
		$query=mysql_query("SELECT * FROM person_proff WHERE person='".$db["id"]."' and proff='".$acs["id"]."'");
		if (!mysql_num_rows($query))
		{	
			if ($db["proff"]==$acs["id"])
			{
				if ($db["k_time"]>time())echo "<small>Идёт обучение<br> Еще ".convert_time($db['k_time'])."</small>";
			}
			else
			{
				echo "<input type=button class=newbut value='Обучаться' onclick=\"if (confirm('Вы действительно хотите получить данную профессию?')) window.location='?getproff=".$acs["id"]."&'+Math.random();''\">"; 
			}
		}
		else echo "<font style='color:green'>Обучен!</font>";
		echo"</td></tr>";
	}
	echo"</table>";

echo"
</td>
</tr>
</table>";
// Конец получения спец.
echo"</td>
</tr>
</table>
</td>
</tr>
</table>";

?>