<?
$login=$_SESSION['login'];
include ("basehp.php");
?>
<body style="background-image: url(img/index/tavern.jpg);background-repeat:no-repeat;background-position:top right">
<TABLE width=100% border=0>
<tr valign=top>
	<td width=100%><h3>Таверна</h3></td>
	<td align=right nowrap>
		<input type='button' class='newbut' onclick="location.href='main.php?act=go&level=remesl'" value='Вернуться' />
		<input type='button' class='newbut' onclick="location.href='main.php?act=none'" value='Обновить' />
	</td>
</tr>
</table>

<?
$daily_kwest=array();
$daily_prize=array();

$daily_kwest[1]["name"]="Стремительный к знаниям";
$daily_kwest[1]["need"]=$max_exp[$db["level"]]*2;
$daily_kwest[1]["text"]="Надо набрать <b>".$daily_kwest[1]["need"]."</b> опыта";
$daily_prize[1]["money"]=$db["level"]*50;
$daily_prize[1]["exp"]=$max_exp[$db["level"]]*2;


$daily_kwest[2]["name"]="Дуэлянт";
$daily_kwest[2]["need"]=$db["level"];
$daily_kwest[2]["text"]="Надо выиграть <b>".$daily_kwest[2]["need"]."</b> одиночных боев.";
$daily_prize[2]["money"]=$db["level"]*50;
$daily_prize[2]["exp"]=$max_exp[$db["level"]]*2;

$daily_kwest[3]["name"]="Ненасытный";
$daily_kwest[3]["need"]=$db["level"];
$daily_kwest[3]["text"]="Надо выграть <b>".$daily_kwest[3]["need"]."</b> групповых боев";
$daily_prize[3]["money"]=$db["level"]*25;
$daily_prize[3]["exp"]=$max_exp[$db["level"]]*2;

$daily_kwest[4]["name"]="Воин хаоса";
$daily_kwest[4]["need"]=$db["level"]*3;
$daily_kwest[4]["text"]="Надо выграть <b>".$daily_kwest[4]["need"]."</b> хаотических боев";
$daily_prize[4]["money"]=$db["level"]*50;
$daily_prize[4]["exp"]=$max_exp[$db["level"]]*2;

$daily_kwest[5]["name"]="Дружелюбный";
$daily_kwest[5]["need"]=5;
$daily_kwest[5]["text"]="Надо подарить <b>".$daily_kwest[5]["need"]."</b> подарков из <b>Магазина подарков</b> друзьям";
$daily_prize[5]["money"]=$db["level"]*50;
$daily_prize[5]["exp"]=$max_exp[$db["level"]]*2;

$daily_kwest[6]["name"]="Лесоруб";
$daily_kwest[6]["need"]=$db["level"]*3;
$daily_kwest[6]["text"]="Вы должны рубит <b>".$daily_kwest[6]["need"]."</b> штук древесины";
$daily_prize[6]["money"]=$db["level"]*50;
$daily_prize[6]["exp"]=$max_exp[$db["level"]]*2;

$daily_kwest[7]["name"]="Рыболов";
$daily_kwest[7]["need"]=$db["level"]*3;
$daily_kwest[7]["text"]="Вы должны ловить <b>".$daily_kwest[7]["need"]."</b> штук рыбу";
$daily_prize[7]["money"]=$db["level"]*50;
$daily_prize[7]["exp"]=$max_exp[$db["level"]]*2;

$daily_kwest[8]["name"]="Клятва Гиппократа";
$daily_kwest[8]["need"]=5;
$daily_kwest[8]["text"]="Вылечите <b>".$daily_kwest[8]["need"]."</b> пациентов";
$daily_prize[8]["money"]=$db["level"]*25;
$daily_prize[8]["exp"]=$max_exp[$db["level"]]*2;

$kwest_count=count($daily_kwest);
#############################################################################
if($_GET["take"])
{
	$take=(int)abs($_GET["take"]);
	$have_kvest=mysql_fetch_array(mysql_query("SELECT * FROM daily_kwest WHERE user_id='".$db["id"]."' and kwest_id='".$take."'"));
	if(!$have_kvest)
	{
		mysql_query("INSERT INTO daily_kwest VALUES (null, '".$db["id"]."', '".$take."', '0', '".$daily_kwest[$take]["need"]."', '0', '".$daily_prize[$take]["money"]."', '".$daily_prize[$take]["exp"]."')");
	}
}

if($_GET["get_naqrada"])
{
	$get_naqrada=(int)abs($_GET["get_naqrada"]);
	$have_kvest=mysql_fetch_array(mysql_query("SELECT * FROM daily_kwest WHERE user_id='".$db["id"]."' and kwest_id='".$get_naqrada."'"));
	if($have_kvest && !$have_kvest["ready"] && $have_kvest["taked"]>=$have_kvest["need"])
	{
		mysql_query("UPDATE daily_kwest SET ready=1 WHERE id='".$have_kvest["id"]."'");
		mysql_query("UPDATE users SET money=money+".$have_kvest["money"].", exp=exp+".$have_kvest["exp"]." WHERE login='".$db["login"]."'");
		$msg="Квест выполнен... Вы получили <b>".$have_kvest["money"]."</b> Зл. и <b>".$have_kvest["exp"]." Опыта</b>";
	}
	else if($have_kvest["ready"])$msg="Квест уже выполнен...";
	else $msg="Квест еще не выполнен...";
}
#############################################################################
if($_GET["take_all"])
{
	$ready_kwest=mysql_fetch_array(mysql_query("SELECT count(*) FROM daily_kwest WHERE user_id='".$db["id"]."' and ready=1 and kwest_id!=99"));
	if($kwest_count==$ready_kwest[0])
	{	
		$have_taked_vip=mysql_fetch_array(mysql_query("SELECT * FROM daily_kwest WHERE user_id='".$db["id"]."' and kwest_id=99"));
		if (!$have_taked_vip)
		{
			$vip_time=6*3600;
			if ($db["vip"]-time()>0)$add_vip_time=$db["vip"]+$vip_time;
			else $add_vip_time=time()+$vip_time;
			mysql_query("UPDATE users SET vip='".$add_vip_time."' WHERE login='".$login."'");
			$msg="Вы стали <b>V.I.P</b>-пользователем игры <b>WWW.MEYDAN.AZ</b> на <b>6 часов</b>";
			mysql_query("INSERT INTO daily_kwest VALUES (null, '".$db["id"]."', '99', '0', '0', '0', '0', '0')");
		}
		else $msg="Вы уже получили свой подарок...";
	}
	else $msg="Вы еще не выполнили все квесты";
}

echo "<input type='button' class='newbut' value='Я выполнил ВСЕ квесты - V.I.P на 6 часов' onclick='window.location.href=\"?take_all=1\"'><br/>";
#############################################################################
echo "<font color='#ff0000'>$msg</font><br/>";
for($i=1;$i<=$kwest_count;$i++)
{
	$have_kvest=mysql_fetch_array(mysql_query("SELECT * FROM daily_kwest WHERE user_id='".$db["id"]."' and kwest_id='".$i."'"));
	echo "<fieldset style='WIDTH: 600px; border:1px ridge;'>";
	echo "<legend><b>".$daily_kwest[$i]["name"]."</b> ".($have_kvest?"<font color='".($have_kvest["taked"]>=$have_kvest["need"]?"green":"#ff0000")."'>(".$have_kvest["taked"]."/".$have_kvest["need"].")</font>":"")."</legend>";
	echo $daily_kwest[$i]["text"]."<br/>";
	echo "Награда за квест: <b>".($have_kvest?$have_kvest["money"]:$daily_prize[$i]["money"])."</b> Зл. и <b>".($have_kvest?$have_kvest["exp"]:$daily_prize[$i]["exp"])."</b> Опыта<br/>";
	if (!$have_kvest)
	{
		echo "<input type='button' class='newbut' value='Взять Квест' onclick='window.location.href=\"?take=$i\"'>";
	}
	else if ($have_kvest["ready"])
	{
		echo "<font color='green'><i>Квест выполнен</i></font>";
	}
	else
	{
		echo "<input type='button' class='newbut' value='Получить награду за Квест' onclick='window.location.href=\"?get_naqrada=$i\"'>";
	}
	echo "</fieldset><br/><br/>	";
}
?>