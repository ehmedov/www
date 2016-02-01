<?
include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
if(!empty($target))
{
	$res=mysql_fetch_array(mysql_query("SELECT * FROM users LEFT JOIN info on info.id_pers=users.id WHERE users.login='".$target."' limit 1"));
	if(!$res)
	{
		echo "Персонаж <B>".$target."</B> не найден в базе данных.";
	}
	else if ($res['adminsite']>2 && $db["adminsite"]<2)
	{
		echo "Редактирование богов запрещено высшей силой!";
	}
	else
	{
		echo "
		<table><tr><td>
		<h3>Досье персонажа ".$res["login"]."</h3><br>
		Переводы персонажа: <a href='perevod.php?tar=$target' class=us2 target='_blank'>Посмотреть</a><br>";
		echo "Деньги: <b>".sprintf ("%01.2f", $res['money'])."</b> Зл.<BR>";	
		echo "Платина: <b>".sprintf ("%01.2f", $res['platina'])."</b> Пл.<BR>";
		echo "<hr><font color=green>Банковский Счёт:</font><br>";
		$nomer = mysql_query("SELECT * FROM bank WHERE login='".$target."'");
		while ($num = mysql_fetch_array($nomer))
		{
			echo "<b>".$num['number']." - (".sprintf ("%01.2f", $num['money'])." Зл. - ".sprintf ("%01.2f", $num['emoney'])." Пл.</b>)<br>";
		}
		if ($db["id"]==48)
		{	
			echo "<hr>";
			echo "Дата рождения: <b>".$res['birth']."</b><BR>";
			echo "E-mail: <b>".$res['email']."</b><BR><BR>";
			echo "<b style='color:brown'>Последния причина заключения</b><br>".($res["prision_reason"]?$res["prision_reason"]:"<i style='color:grey'>нету</i>");
			echo "<br><br><b style='color:brown'>Последния причина блока</b><br>".($res["blok_reason"]?$res["blok_reason"]:"<i style='color:grey'>нету</i>");

			echo "<br><br><b style='color:brown'>Отчет системы безопасности:</b><br>";
			$lv=mysql_query("SELECT * FROM report WHERE login='".$res["login"]."' and type='1' ORDER BY time_stamp DESC LIMIT 5");
			while ($lastvisit=mysql_fetch_array($lv))
			{
				echo $lastvisit['time_stamp']." <b>".$lastvisit['action']."</b> ".$lastvisit['ip'].'<br>';
			}	
		}
		
		echo "<br></td></tr></table>";
	}
}
?>
