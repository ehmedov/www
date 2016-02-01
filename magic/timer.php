<?
$login=$_SESSION['login'];
$spell=$_GET['spell'];

if($db["battle"]!=0)
{
	say($login, "¬ы не можете кастовать это закл€тие наход€сь в бою!", $login);
}
else 
{
	if ($mtype=="timer30")
	{	
		mysql_query("UPDATE users SET last_request_time=last_request_time-1800 WHERE login='".$login."'");
	}
	else if ($mtype=="timer_all")
	{	
		mysql_query("UPDATE users SET last_request_time=0 WHERE login='".$login."'");
	}
	$_SESSION["message"]="¬ы удачно прокастовали заклинание <b>&laquo;".$name."&raquo;</b>!";
	drop($spell,$DATA);
}
echo "<script>location.href='main.php?act=inv&otdel=magic'</script>";
?>
