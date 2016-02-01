<?
session_start();
$login=$_SESSION['login'];
$spell=$_GET['spell'];	
$wearname=htmlspecialchars(addslashes(trim($_POST['wearname'])));


switch ($mtype) 
{
	case "fail1":  $zatochka = 1; $object_types='fail';break;
	case "fail2":  $zatochka = 2; $object_types='fail';break;
	case "fail3":  $zatochka = 3; $object_types='fail';break;
	case "fail4":  $zatochka = 4; $object_types='fail';break;
	case "fail5":  $zatochka = 5; $object_types='fail';break;
	case "fail6":  $zatochka = 6; $object_types='fail';break;
	case "fail7":  $zatochka = 7; $object_types='fail';break;
	case "fail8":  $zatochka = 8; $object_types='fail';break;
	case "fail9":  $zatochka = 9; $object_types='fail';break;
	case "fail10": $zatochka = 10;$object_types='fail';break;
	
	case "knife1":  $zatochka = 1; $object_types='knife';break;
	case "knife2":  $zatochka = 2; $object_types='knife';break;
	case "knife3":  $zatochka = 3; $object_types='knife';break;
	case "knife4":  $zatochka = 4; $object_types='knife';break;
	case "knife5":  $zatochka = 5; $object_types='knife';break;
	case "knife6":  $zatochka = 6; $object_types='knife';break;
	case "knife7":  $zatochka = 7; $object_types='knife';break;
	case "knife8":  $zatochka = 8; $object_types='knife';break;
	case "knife9":  $zatochka = 12; $object_types='knife';break;
	case "knife10": $zatochka = 10;$object_types='knife';break;
	
	case "axe1":  $zatochka = 1; $object_types='axe';break;
	case "axe2":  $zatochka = 2; $object_types='axe';break;
	case "axe3":  $zatochka = 3; $object_types='axe';break;
	case "axe4":  $zatochka = 4; $object_types='axe';break;
	case "axe5":  $zatochka = 5; $object_types='axe';break;
	case "axe6":  $zatochka = 6; $object_types='axe';break;
	case "axe7":  $zatochka = 7; $object_types='axe';break;
	case "axe8":  $zatochka = 8; $object_types='axe';break;
	case "axe9":  $zatochka = 12; $object_types='axe';break;
	case "axe10": $zatochka = 10;$object_types='axe';break;
	
	case "sword1":  $zatochka = 1; $object_types='sword';break;
	case "sword2":  $zatochka = 2; $object_types='sword';break;
	case "sword3":  $zatochka = 3; $object_types='sword';break;
	case "sword4":  $zatochka = 4; $object_types='sword';break;
	case "sword5":  $zatochka = 5; $object_types='sword';break;
	case "sword6":  $zatochka = 6; $object_types='sword';break;
	case "sword7":  $zatochka = 7; $object_types='sword';break;
	case "sword8":  $zatochka = 8; $object_types='sword';break;
	case "sword9":  $zatochka = 12; $object_types='sword';break;
	case "sword10": $zatochka = 10;$object_types='sword';break;
	
	case "staff1":  $zatochka = 1; $object_types='staff';break;
	case "staff2":  $zatochka = 2; $object_types='staff';break;
	case "staff3":  $zatochka = 3; $object_types='staff';break;
	case "staff4":  $zatochka = 4; $object_types='staff';break;
	case "staff5":  $zatochka = 5; $object_types='staff';break;
	case "staff6":  $zatochka = 6; $object_types='staff';break;
	case "staff7":  $zatochka = 7; $object_types='staff';break;
	case "staff8":  $zatochka = 8; $object_types='staff';break;
	case "staff9":  $zatochka = 12; $object_types='staff';break;
	case "staff10": $zatochka = 10;$object_types='staff';break;
}

$sql=mysql_query("SELECT * FROM inv WHERE name='".$wearname."' and object_type='".$object_types."' and owner='".$login."' and wear=0");
$inv=mysql_fetch_array($sql);
if (!$inv)
{
	$_SESSION["message"]="Ёто оружие не было найдено в вашем инвентаре!";
}
else
{
	if ($inv['is_modified']>=$zatochka)
	{
		$_SESSION["message"]="Ёто оружие было заточено ранее!";
	}
	else
	{
		mysql_query("UPDATE inv SET is_modified=$zatochka WHERE id=".$inv['id']);
		$_SESSION["message"]="¬ы удачно заточили оружие &quot".$inv['name']." +$zatochka&quot.";
		drop($spell,$DATA);
	}
}
echo "<script>location.href='main.php?act=inv&otdel=magic'</script>";
die();
?>