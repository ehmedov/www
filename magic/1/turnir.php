<?include("key.php");
$login=$_SESSION['login'];
if($db["orden"]==1 && $db["admin_level"]>=10)
{
	mysql_query('DELETE FROM `deztow_turnir` WHERE `active` = TRUE');
	mysql_query('UPDATE `variables` SET `value` = \''.(time()+10*60).'\' WHERE `var` = \'startbs\';');
	mysql_query("TRUNCATE TABLE `deztow_stavka`;");
	mysql_query("UPDATE bs_objects SET bs=0,owner=''");
	mysql_query("UPDATE users SET location='', vector='', bs=0 WHERE bs=1");
	echo "OK";
}
?>
