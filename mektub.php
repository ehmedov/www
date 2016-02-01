<?
	include "conf.php";
	$data   = mysql_connect($base_name, $base_user, $base_pass)or 
	die ('Технический перерыв  . Приносим свои извинения. Администрация.');
	mysql_select_db($db_name,$data);
?>
<LINK REL=StyleSheet HREF='main.css' TYPE='text/css'>
<body bgcolor=#dddddd>	

<?
	echo "<table><tr bgcolor=#D5D5D5><td><b>FROM USER</td><td><b>TO USER</td><td><b>SUBJECT</td><td><b>MESSAGE</td></tr>";
	$baza=mysql_query("SELECT * FROM pochta");
	$i=0;
	while ($db=mysql_fetch_array($baza))
	{
		if ($i%2==0)$color="#D5D5D5";else $color="#C7C7C7";
		echo "<tr bgcolor=$color><td>".$db['user']."</td><td>".$db['whom']."</td><td>".$db['subject']."</td><td>".$db['text']."</td></tr>";
		$i++;
	}
	echo "</table>";

?>