<?
$login=$_SESSION['login'];
$spell=(int)$_GET['spell'];
$zaman=time()+24*60*60;
$my_id=$db["id"];
$add=100;
$type='bron';
if($db["battle"]!=0)
{
	say($login, "В бою использовать реликты запрещено!", $login);
}
else
{
	$if_yes=mysql_fetch_Array(mysql_query("SELECT count(*) FROM effects WHERE user_id=".$my_id." and type='".$type."' and end_time>".time()));
	if (!$if_yes[0])
	{
		mysql_query("INSERT INTO effects (user_id,type,elik_id,add_bron,end_time) VALUES ('$my_id','$type','$spell','$add','$zaman')");
		mysql_query("UPDATE abils SET c_iznos=c_iznos+1 WHERE item_id = '".$spell."' and tribe='".$db["clan"]."'");
		$errmsg="Вы удачно прокастовали заклинание <b>&laquo;".$name."&raquo;</b>";
	}
	else $errmsg="Вы уже использовали это заклятие!!!";
}
?>
