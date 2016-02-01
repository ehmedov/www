<?
$login=$_SESSION['login'];
$spell=$_GET['spell'];	
$animal_name=htmlspecialchars(addslashes(trim($_POST['wearname'])));
$animal_type=$DATA["type"];
if($db["battle"])
{
	say($login, "Вы не можете кастовать это заклятие находясь в бою!", $login);
}
else
{
	if ($animal_name!="")
	{
		$en=preg_match("/^(([a-zA-Z#])+)$/i", $animal_name);
		$ru=preg_match("/^(([а-яА-Я#])+)$/i", $animal_name);
		
		if (strlen($animal_name)>10)
		{
			$_SESSION["message"]="Кличка не подходит!!! (не может быть длиннее 10 символа)";
		}
		else if (strlen($animal_name)<3)
		{
			$_SESSION["message"]="Кличка не подходит!!! (не может быть короче 3 символов)";
		}
		else if (($en && $ru) or (!$en && !$ru))
		{
			$_SESSION["message"]="Кличка может состоять только из букв и только из одного слова...";
		}
		else
		{		
			$is_animal=mysql_fetch_Array(mysql_query("SELECT count(*) FROM zver WHERE owner=".$db["id"]." and sleep=0"));
			if ($is_animal[0]>0)
			{	
				$_SESSION["message"]="У вас уже есть зверь!!!";
			}
			else
			{
				include("bot_exp.php");

				switch ($animal_type) 
				{
					case "wolf": $obraz=array("1.gif","2.gif","3.gif");break;
					case "cheetah": $obraz=array("4.gif","5.gif","6.gif","7.gif");break;
					case "bear": $obraz=array("8.gif","9.gif","10.gif","11.gif");break;
					case "snake": $obraz=array("12.gif","13.gif","14.gif");break;
					case "dragon": $obraz=array("15.gif","16.gif","17.gif","18.gif","19.gif");break;
				}
				mysql_query("INSERT INTO `zver` ( `id` , `owner` , `type` , `name` , `obraz` ,  `energy` ,`hp_all` , `sila` , `lovkost` , `udacha` , `power` , `bron_head` , `bron_corp` , `bron_poyas` , `bron_legs`, `krit` , `akrit` , `uvorot` , `auvorot` , `hand_r_hitmin` , `hand_r_hitmax` , `hand_l_hitmin` , `hand_l_hitmax`)
				VALUES (NULL , '".$db["id"]."', '".$animal_type."', '".$animal_name."', 'obraz/animal/".$obraz[rand(0,count($obraz)-1)]."', '20', '".(int)($a[$animal_type][0]["power"]*6)."', '".($a[$animal_type][0]["sila"])."', '".($a[$animal_type][0]["lovkost"])."', '".($a[$animal_type][0]["udacha"])."', '".($a[$animal_type][0]["power"])."', '".($a[$animal_type][0]["bron_head"])."', '".($a[$animal_type][0]["bron_corp"])."', '".($a[$animal_type][0]["bron_poyas"])."', '".($a[$animal_type][0]["bron_legs"])."', '".($a[$animal_type][0]["krit"])."', '".($a[$animal_type][0]["akrit"])."', '".($a[$animal_type][0]["uvorot"])."', '".($a[$animal_type][0]["auvorot"])."', '".($a[$animal_type][0]["hand_r_hitmin"])."', '".($a[$animal_type][0]["hand_r_hitmax"])."', '".($a[$animal_type][0]["hand_l_hitmin"])."', '".($a[$animal_type][0]["hand_l_hitmax"])."');");
				$_SESSION["message"]="Вы удачно прокастовали заклинание!!!";
				mysql_query("DELETE FROM `inv` WHERE id = '".$spell."'");
				$_SESSION["message"].="<br>Свиток полностью использован.";
			}
		}
	}
}
echo "<script>location.href='main.php?act=inv&otdel=magic'</script>";
?>
