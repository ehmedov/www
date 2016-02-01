<?include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));

if(!empty($target))
{
	$q=mysql_query("select * from users where login='".$target."' limit 1");
	$res=mysql_fetch_array($q);
	if(!$res)
	{
		echo "Персонаж <B>".$target."</B> не найден в базе данных.";
	}
	else if ($res['login']=="СОЗДАТЕЛЬ" || ($res['login']=="bor" && $login!="bor"))
	{
		echo "Редактирование богов запрещено высшей силой!";
	}
	else
	{
		$on_game = mysql_query("SELECT * FROM online WHERE login='".$target."' limit 1");
		$res_on = mysql_fetch_array($on_game);
		
		echo "<br><table style='border:1px solid #DB9F73' width=550 align=right cellpadding=5 cellspacing=0><tr><td valign=top>";
		echo "<center><b>Досье персонажа ".$res["login"]."</b></center><br>";
		echo "Admin level: <font color=red>".$res['admin_level']."</font><br>";
		echo "Admin Site: <font color=red>".$res['adminsite']."</font><br>";
		echo "ID: <font color=red>".$res['id']."</font><br><br>";
		
		$reg_ip=$res['reg_ip'];
		$last_ip=$res['last_ip'];
		$remote_ip=$res['remote_ip'];
		$on_ip=$res_on['ip'];
		$remote_online=	$res_on['remote_ip'];
		if ($reg_ip=='')$reg_ip='none';
		if ($last_ip=='')$last_ip='none';
		if ($remote_ip=='')$remote_ip='none';
		if ($on_ip=='')$on_ip='Персонаж сейчас Off-line';
		if ($remote_online=='')$remote_online='Персонаж сейчас Off-line';

		echo "Регистрировался: <b style='color:#FF0000'>".$reg_ip."</b> <a href='seekregip.php?ip=".base64_encode($reg_ip)."' class=us2 target='_blank'>Посмотреть</a><BR>";
		echo "Последний раз зашел c IP адреса: <b style='color:#007000'>".$last_ip."</b> <a href='seekregip.php?last_ip=".base64_encode($last_ip)."' class=us2 target='_blank'>Посмотреть</a><BR>";
		echo "Последний Обший IP: <b style='color:#007000'>".$remote_ip."</b> <a href='seekregip.php?remote_ip=".base64_encode($remote_ip)."' class=us2 target='_blank'>Посмотреть</a><BR>";
		echo "Текущий IP адрес: <b style='color:#007000'>".$on_ip."</b> <a href='seekregip.php?onlineip=".base64_encode($on_ip)."' class=us2 target='_blank'>Посмотреть</a><br>";
		echo "Текущий Обший IP: <b style='color:#007000'>".$remote_online."</b> <a href='seekregip.php?onlineremote=".base64_encode($remote_online)."' class=us2 target='_blank'>Посмотреть</a><br>";	
		
		echo "<br>Переводы персонажа: <a href='perevod.php?tar=$target' class=us2 target='_blank'>Посмотреть</a><br>";
		echo "Бои персонажа: <a href='archive.php?tar=$target' class=us2 target='_blank'>Посмотреть</a><br><br><br>";	
		echo "Дата рождения: <b>".$res['birthday']."</b><BR><BR>";
		echo "Деньги: <b style='color:green'>".$res['money']."</b> зл.<BR>";	
		echo "Платина: <b style='color:green'>".$res['platina']."</b> пл.<BR>";
		echo "Опыт: <b style='color:green'>".$res['exp']."</b><BR>";
		echo "Next_up: <b style='color:green'>".$res['next_up']."</b><BR>";
		echo "Свободных апов: <b style='color:green'>".$res['ups']."</b><BR>";
		$bron_head=$res["bron_head"];
		$bron_corp=$res["bron_corp"];
		$bron_poyas=$res["bron_poyas"];
		$bron_leg=$res["bron_legs"];
		$bron_arm=$res["bron_arm"];

		echo "<table width=100%><tr><td valign=top>";
		echo "Уровень брони:<br>";
		echo "&nbsp; &bull; Голова: ".$bron_head;
		echo "<br>&nbsp; &bull; Руки:".$bron_arm;
		echo "<br>&nbsp; &bull; Корпус: ".$bron_corp;
		echo "<br>&nbsp; &bull; Пояс: ".$bron_poyas;
		echo "<br>&nbsp; &bull; Ноги: ".$bron_leg;
		echo "</td><td valign=top>";

		$mf_krit=$res["krit"];
		$mf_uvorot=$res["uvorot"];
		$mf_antikrit = $res["akrit"];
		$mf_antiuvorot = $res["auvorot"];
		
		$lovkost=$res["lovkost"];
		$udacha=$res["udacha"];

		$mfkrit=$mf_krit+2*$udacha;
		$mfantikrit=$mf_antikrit+2*$udacha;
		$mfuvorot=$mf_uvorot+2*$lovkost;
		$mfantiuvorot=$mf_antiuvorot+2*$lovkost;

		echo "Боевые навыки:";	
		echo "<br>&nbsp; &bull; Мф крита: ".$mfkrit;
		echo "<br>&nbsp; &bull; Мф антикрита:".$mfantikrit;
		echo "<br>&nbsp; &bull; Мф уворота: ".$mfuvorot;
		echo "<br>&nbsp; &bull; Мф антиуворота: ".$mfantiuvorot;
		echo "</td></tr></table>";
		echo "<br><br>Магические навыки:";
		echo"<br>&nbsp;&bull; Мастерство владения стихией Огня: <b>".$res['fire_magic']."</b><br>
			&nbsp;&bull; Мастерство владения стихией Земли: <b>".$res['earth_magic']."</b><br>
			&nbsp;&bull; Мастерство владения стихией Воды: <b>".$res['water_magic']."</b><br>
			&nbsp;&bull; Мастерство владения стихией Воздуха: <b>".$res['air_magic']."</b><br>";

		echo "<br><br><font color=green>Банковский Счёт:</font><br>";
		$nomer = mysql_query("SELECT * FROM bank WHERE login='".$target."'");
		while ($num = mysql_fetch_array($nomer))
		{
			echo "<b>".$num['number']." - (".sprintf ("%01.2f", $num['money'])." зл. - ".sprintf ("%01.2f", $num['emoney'])." пл.</b>)<br>";
		}
		echo "<br>Последния причина заключения: <b>".$res["prision_reason"]."</b> <BR>";
		echo "<br></td></tr></table>";
	}
}
?>
