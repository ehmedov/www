<?session_start();
if ($_SESSION["login"]=="")
{	
 	echo "<script>top.location.href='index.php'</script>";
 	die();
}
?>