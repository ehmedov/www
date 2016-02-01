<?
session_start();
ob_start();
if (!@session_is_registered('login'))
{
 	Header("Location: index.php");
 	die();
}

?>