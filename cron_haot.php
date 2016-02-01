<?
include "conf.php";
include "functions.php";
$data = mysql_connect($base_name, $base_user, $base_pass);
mysql_select_db($db_name,$data);


$have_zayavka_5=mysql_fetch_array(mysql_Query("SELECT count(*) FROM zayavka WHERE creator=2"));
if (!$have_zayavka_5[0])
{	
	$wait_to=3*60+time();
	mysql_query("INSERT INTO zayavka(status, type, timeout, creator, minlev1, maxlev1, wait, city, room, hidden) VALUES('1', '7', '3', '2', '5', '5', '".$wait_to."', 'mountown', 'room4', '1')");
	#echo "Level 5 - OK<br>";
}

$have_zayavka_6=mysql_fetch_array(mysql_Query("SELECT count(*) FROM zayavka WHERE creator=3"));
if (!$have_zayavka_6[0])
{	
	$wait_to=3*60+time();
	mysql_query("INSERT INTO zayavka(status, type, timeout, creator, minlev1, maxlev1, wait, city, room, hidden) VALUES('1', '7', '3', '3', '6', '6', '".$wait_to."', 'mountown', 'room4', '1')");
	#echo "Level 6 - OK<br>";
}

$have_zayavka_7=mysql_fetch_array(mysql_Query("SELECT count(*) FROM zayavka WHERE creator=8"));
if (!$have_zayavka_7[0])
{	
	$wait_to=4*60+time();
	mysql_query("INSERT INTO zayavka(status, type, timeout, creator, minlev1, maxlev1, wait, city, room, hidden) VALUES('1', '7', '3', '8', '7', '7', '".$wait_to."', 'mountown', 'room4', '1')");
	#echo "Level 7 - OK<br>";
}

$have_zayavka_8=mysql_fetch_array(mysql_Query("SELECT count(*) FROM zayavka WHERE creator=9"));
if (!$have_zayavka_8[0])
{	
	$wait_to=4*60+time();
	mysql_query("INSERT INTO zayavka(status, type, timeout, creator, minlev1, maxlev1, wait, city, room, hidden) VALUES('1', '7', '3', '9', '8', '8', '".$wait_to."', 'mountown', 'room4', '1')");
	#echo "Level 8 - OK<br>";
}

$have_zayavka_9=mysql_fetch_array(mysql_Query("SELECT count(*) FROM zayavka WHERE creator=10"));
if (!$have_zayavka_9[0])
{	
	$wait_to=5*60+time();
	mysql_query("INSERT INTO zayavka(status, type, timeout, creator, minlev1, maxlev1, wait, city, room, hidden) VALUES('1', '7', '3', '10', '9', '9', '".$wait_to."', 'mountown', 'room4', '1')");
	#echo "Level 9 - OK<br>";
}

$have_zayavka_10=mysql_fetch_array(mysql_Query("SELECT count(*) FROM zayavka WHERE creator=11"));
if (!$have_zayavka_10[0])
{	
	$wait_to=5*60+time();
	mysql_query("INSERT INTO zayavka(status, type, timeout, creator, minlev1, maxlev1, wait, city, room, hidden) VALUES('1', '7', '3', '11', '10', '10', '".$wait_to."', 'mountown', 'room4', '1')");
	#echo "Level 10 - OK<br>";
}
?>