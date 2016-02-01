<?
include ("conf.php");
$data = mysql_connect($base_name, $base_user, $base_pass);
if(!mysql_select_db($db_name,$data)){echo mysql_error();die();}
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
?>
<LINK rel="stylesheet" type="text/css" href="../main.css">
<body bgcolor="#dddddd" topmargin="20" leftmargin="20">
<script language="JavaScript" type="text/javascript" src="commoninf.js"></script>

<?
$sql=mysql_query("SELECT * FROM users WHERE sex='female' and level>=10 and blok=0 and prision=0 ORDER BY level ASC");
while ($DAT=mysql_fetch_array($sql))
{
	echo "<script>drwfl('".$DAT['login']."', '".$DAT['id']."', '".$DAT['level']."', '".$DAT['dealer']."', '".$DAT['orden']."', '".$DAT['admin_level']."', '".$DAT['clan_short']."', '".$DAT['clan']."');</script><br>";
}
?>