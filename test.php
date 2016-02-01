<?
include "conf.php";
$data = mysql_connect($base_name, $base_user, $base_pass);
mysql_select_db($db_name,$data);

$row=mysql_query("select inv.id from users left join inv on inv.owner=users.login where users.orden=1 and inv.object_type='scroll' and inv.object_id=60");
while($res=mysql_fetch_Array($row))
{
	mysql_query("UPDATE inv SET iznos_max=121 WHERE id=".$res[0]);
}	
?>