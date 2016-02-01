<?
include("key.php");
$login=$_SESSION['login'];
if($db["orden"]==1 && $db["admin_level"]>=10)
{
	$query=mysql_fetch_Array(mysql_query("SELECT count(*) FROM zayavka WHERE type=11"));
	if ($query[0])echo "Поединок идет...";
	else 
	{
		$wait_to=10*60+time();
		mysql_query("INSERT INTO zayavka(status,type,timeout,creator,minlev1,maxlev1,minlev2,maxlev2,limit1,limit2,wait,comment,city,room) VALUES('1','11','3','1','8','21','8','21','50','50','".$wait_to."','Свет vs. Тьма','".$db["city_game"]."','room4')");
		say("toall_news","<font color=\"#ff0000\">Объявления:</font> <font color=darkblue><b>Началась Битва между Светом и Тьмой</b></font>",$login);
		say("toall_news","<font color=\"#ff0000\">Объявления:</font> <font color=darkblue><b>Дети тьмы, я жду вас! </b></font>",$login);
		say("toall_news","<font color=\"#ff0000\">Объявления:</font> <font color=darkblue><b>Силы света, ваша помощь нужна, как никогда. Темные призвали своего бога!</b></font>",$login);
		echo "OK";
	}
}
?>
