<?
include "req.php";
include "removexss.php";
array_walk($_REQUEST,"format_string");
array_walk($_POST,"format_string");
array_walk($_GET,"format_string"); 

array_walk($_REQUEST,"RemoveXSS");
array_walk($_POST,"RemoveXSS");
array_walk($_GET,"RemoveXSS"); 
?>