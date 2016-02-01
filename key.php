<?session_start();

if (!@session_is_registered('login'))
{
 	echo "<script>top.location.href='index.php'</script>";
 	die();
}

?>