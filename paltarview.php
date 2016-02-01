<?
include "conf.php";

$data = mysql_connect($base_name, $base_user, $base_pass);
if(!mysql_select_db($db_name,$data))
{
	echo mysql_error();
	die();
}
?>
<table border=1>
<?
$sql=mysql_query("select id,object,name,img from paltar");
while($k=mysql_fetch_array($sql))
{	
	echo "<tr><td>".$k['id']."</td><td>".$k['object']."</td><td>".$k['name']."</td><td><img src='img/".$k['img']."'></td></tr>";
}		
?>
</table>