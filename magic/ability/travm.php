<?$login=$_SESSION['login'];
$spell=(int)$_GET['spell'];
if(!$db["battle"])
{
    if($db["travm"]!=0)
    {
    	$t_stat = $db["travm_stat"];
		$o_stat = $db["travm_old_stat"];
		mysql_query("UPDATE users SET $t_stat=$t_stat+$o_stat,travm='0', travm_stat='', travm_var='', travm_old_stat='' WHERE login='".$login."'");
		mysql_query("UPDATE abils SET c_iznos=c_iznos+1 WHERE item_id = '".$spell."' and tribe='".$db["clan"]."'");
    	$errmsg="Травма вылечена...";
	}
	else
	{
		$errmsg="Вы не травмированы...";
	}
}
else
{
	$errmsg="В бою использовать реликты запрещено...";
}
?>
