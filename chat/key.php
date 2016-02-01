<?session_start();ob_start("@ob_gzhandler");
if ($_SESSION["login"]=="")
{	
 	echo "<script>top.location.href='../index.php'</script>";
 	die();
}
header("Content-Type: text/html;charset=windows-1251");

?>