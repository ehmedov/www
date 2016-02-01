<?
$city = $db["city_game"];
$room_list = Array();


$room_list["mountown"]["arena"] = "arena.php" ;
$room_list["mountown"]["room1"] = "room.php";
$room_list["mountown"]["room2"] = "room.php";
$room_list["mountown"]["room3"] = "room.php";
$room_list["mountown"]["room4"] = "room.php";
$room_list["mountown"]["room5"] = "room.php";
$room_list["mountown"]["room6"] = "room.php";


$room_list["mountown"]["municip"] = "municip.php";



$room_list["mountown"]["bazar"] = "bazar.php";



$room_list["mountown"]["remesl"] = "remesl.php";
$room_list["mountown"]["bank"] = "bank.php";


$room_list["mountown"]["okraina"] = "okraina.php";
$room_list["mountown"]["house"] = "house.php";


if($room_list[$city][$room])
{
	include_once ($city."/".$room_list[$city][$room]);
}
else echo "<b style='color:#ff0000'>Заходите в игру в Браузере</b>";
?>
