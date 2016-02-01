<?
include('key.php');
$login=$_SESSION["login"];
$clan_limit=50+$SITED['level']*5;
$SostCount = mysql_fetch_array(mysql_query("SELECT count(*) FROM users WHERE clan='".$clan_t."' and blok=0 ORDER BY glava DESC, clan_take DESC"));
//--------------------------
if ($_POST["target"])
{	
	$target=htmlspecialchars(addslashes($_POST["target"]));
	if($db["clan_take"]==1)
	{
		$q=mysql_query("SELECT * FROM users WHERE login='".$target."'");
		$res=mysql_fetch_array($q);
		if(!$res)
		{
			$msg= "Персонаж <B>".$target."</B> не найден в базе данных.";
		}
		else if($res["level"]<8)
		{
			$msg= "Минимальный уровень приёма в клан <b>8</b>";
		}
		else if($res["clan_short"]!="" || $res["orden"] || $res["dealer"])
		{
			$msg= "Персонаж <B>".$target."</B> уже состоит в клане";
		}
		else if(($res["metka"]+5*24*60*60)<time())
		{
			$msg= "Персонаж <B>".$target."</B> не прошел проверку <img src='img/orden/1/10.gif'><b>Стражи порядка</b>!";
		}
		else if($SostCount[0]>=$clan_limit)
		{
			$msg= "Максимум ".$clan_limit." чел.";
		}
		else if($db["money"]<100)
		{
			$msg= "У Вас недостаточно средств, для приема в клан нового члена!";
		}
		else
		{
			mysql_query("UPDATE users SET clan='".$clan_t."',clan_short='".$clan_s."',chin='НОВОБРАНЕЦ',orden='".$orden_t."' WHERE login='".$res['login']."'");
			mysql_query("UPDATE users SET money=money-100 WHERE login='".$login."'");
			talk($res['login'],"Персонаж <b>".$db['login']."</b> принял Вас в Ханство <b>".$clan_t."</b>...",$res);
			$msg= "Персонаж <b>".$res['login']."</b> принят в Ханства. С Вашего счета снято <b>100 Зл.</b>";
			history($res['login'],'Принят в Ханства.','Ханства '.$clan_t,$res['remote_ip'], "Глава: ".$login);
			history($login,'Принял в Ханства.','Персонаж '.$res['login'].' принят в Ханства '.$clan_t,$db['remote_ip'], "Глава: ".$login);
		}
	}
}
//--------------------------
echo "<font color=red>$msg</font>";
?>
<form name='slform' action='main.php?act=clan&do=3' method='POST'>
<table>
<tr valign=top>
	<td align=left>
		За прием в клан нового члена, Вы должны уплотить пошлину <b>100.00 Зл.</b><BR>
		Новый член клана должен пройти проверку у <img src='img/orden/1/10.gif'><b>Стражи порядка</b>.<BR>
		<br><b>Введите Ник:</b>	<input type=text name='target' class=new size=20>
		<input type=submit value="Принять" class=new><BR>
		<small>(У вас в составе: <?=$SostCount[0]?> чел. Максимум <?=$clan_limit?> чел.)</small>
		
	</td>
</tr>
</table>
</form>
<script>Hint3Name = 'target';</script>