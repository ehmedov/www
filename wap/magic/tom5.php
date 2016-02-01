<?
session_start();
$login=$_SESSION['login'];
$spell=$_GET['spell'];	
$have_tom_sl11=mysql_fetch_array(mysql_query("SELECT count(*) FROM slots_priem WHERE user_id=".$db["id"]." and sl_name='sl12'"));
if ($have_tom_sl11[0])
{
	$have_tom_sl12=mysql_fetch_array(mysql_query("SELECT count(*) FROM slots_priem WHERE user_id=".$db["id"]." and sl_name='sl13'"));
	if ($have_tom_sl12[0])
	{	
		$_SESSION["message"]="Вы уже изучили этот том!";
	}
	else
	{
		mysql_query("INSERT INTO slots_priem (user_id,sl_name) values (".$db["id"].",'sl13')");
		$_SESSION["message"]="Вы удачно прокастовали заклинание <b>&laquo;".$name."&raquo;</b>";
		drop($spell,$DATA);
	}
}
else
{
	$_SESSION["message"]="Изучите Том Слабости!";
}
?>