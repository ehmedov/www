<?
$city = $db["city_game"];
$room_list = Array();
$room_list["mountown"]["bazar"]= "bazar.php";
$room_list["mountown"]["municip"]= "municip.php";
$room_list["mountown"]["cityhall"]= "cityhall.php";
$room_list["mountown"]["okraina"]= "okraina.php";

$room_list["mountown"]["smith"] = "smith.php";
$room_list["mountown"]["hospital"]= "hospital.php";
$room_list["mountown"]["magicstore"]= "magicstore.php";
$room_list["mountown"]["test"]= "test.php";
$room_list["mountown"]["artmag"]= "artmag.php";
$room_list["mountown"]["remesl"]= "remesl.php";
$room_list["mountown"]["auction"]= "auction.php";
$room_list["mountown"]["apteka"]= "apteka.php";
$room_list["mountown"]["arena"]= "arena.php" ;
$room_list["mountown"]["flower"]= "flower.php"  ;
$room_list["mountown"]["plshop"]= "plshop.php";
$room_list["mountown"]["artshop"]= "artshop.php";
$room_list["mountown"]["bank"]= "bank.php";
$room_list["mountown"]['blackjeck']= "blackjeck.php";
$room_list["mountown"]['lotery']= "lotery.php";
$room_list["mountown"]['clanhol']= "clanhol.php";
$room_list["mountown"]['znaxar']= "znaxar.php";
$room_list["mountown"]['rep']= "rep.php";
$room_list["mountown"]['comok']= "comok.php";
$room_list["mountown"]["pochta"] = "pochta.php";
$room_list["mountown"]["casino"] = "casino.php";
$room_list["mountown"]["forest"] = "forest.php";
$room_list["mountown"]["mount"] = "mount.php";
$room_list["mountown"]["tavern"] = "tavern.php";

$room_list["mountown"]["crypt"] = "crypt.php";
$room_list["mountown"]["crypt_floor2"] = "crypt_floor2.php";
$room_list["mountown"]["cave_secret"] = "cave_secret.php";
$room_list["mountown"]["crypt_go"] = "crypt_go.php";
$room_list["mountown"]["cave_shop"] = "cave_shop.php";

$room_list["mountown"]['elka']= "elka.php";
$room_list["mountown"]['led']= "led.php";
$room_list["mountown"]['led_shop']= "led_shop.php";
$room_list["mountown"]['labirint_led']= "labirint_led.php";
$room_list["mountown"]['novruz']= "novruz.php";
$room_list["mountown"]['novruz_go']= "novruz_go.php";
$room_list["mountown"]['novruz_floor']= "novruz_floor.php";
$room_list["mountown"]['novruz_shop']= "novruz_shop.php";

$room_list["mountown"]["room1"] = "room1.php";
$room_list["mountown"]["room2"] = "room2.php";
$room_list["mountown"]["room3"] = "room3.php";
$room_list["mountown"]["room4"] = "room4.php";
$room_list["mountown"]["room5"] = "room5.php";
$room_list["mountown"]["room6"] = "room6.php";

$room_list["mountown"]["warcrypt"] = "warcrypt.php";
$room_list["mountown"]["war_labirint"] = "war_labirint.php";
$room_list["mountown"]["vault"] = "vault.php";
$room_list["mountown"]["doblest_shop"] = "doblest_shop.php";

$room_list["mountown"]["canalization"] = "canalization.php";
$room_list["mountown"]["portal"] = "portal.php";

$room_list["mountown"]["sklad"] = "sklad.php";

$room_list["mountown"]["katakomba"] = "katakomba.php";
$room_list["mountown"]["dungeon"] = "dungeon.php";
$room_list["mountown"]["merlin"] = "merlin.php";
$room_list["mountown"]["lavka"] = "lavka.php";
$room_list["mountown"]["kvest"] = "kvest.php";
$room_list["mountown"]["kvest1"] = "kvest1.php";
$room_list["mountown"]["artovka"] = "artovka.php";

$room_list["mountown"]["izumrud"] = "izumrud.php";
$room_list["mountown"]["izumrud_floor"] = "izumrud_floor.php";
$room_list["mountown"]["starik"] = "starik.php";
$room_list["mountown"]["izumrud_shop"] = "izumrud_shop.php";

$room_list["mountown"]["nature"] = "nature.php";
$room_list["mountown"]["lesopilka"] = "lesopilka.php";
$room_list["mountown"]["ozera"] = "ozera.php";
$room_list["mountown"]["priem"] = "priem.php";
$room_list["mountown"]["mayak"] = "mayak.php";
$room_list["mountown"]["hell_shop"] = "hell_shop.php";

$room_list["mountown"]['smert_room']= "smert_room.php";
$room_list["mountown"]['towerin']= "towerin.php";
$room_list["mountown"]['zadaniya']= "zadaniya.php";

$room_list["mountown"]['news']= "news.php";

$room_list["mountown"]["house"] = "house.php";
$room_list["mountown"]["obraz"] = "obraz.php";
$room_list["mountown"]["academy"] = "academy.php";
$room_list["mountown"]["castle"] = "castle.php";
$room_list["mountown"]["castle_hall"] = "castle_hall.php";
$room_list["mountown"]["proverka"] = "proverka.php";

if($room_list[$city][$room])
{
	include_once ($city."/".$room_list[$city][$room]);
	#GzDocOut();
}
?>
