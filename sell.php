<?
$login=$_SESSION['login'];
$city=$db["city_game"];
$ip=$db["remote_ip"];
echo '<table width=100% cellspacing=1 cellpadding=3 class="l3">';
$item_sell=mysql_query("SELECT * FROM inv WHERE owner='".$login."' AND object_razdel='obj' AND wear=0 ORDER BY date DESC");
if(mysql_num_rows($item_sell)==0)
{
	echo "<tr align=center class='l0'><td><b>У Вас нет вещей, которые можно продать</b></td></tr>";
}
else 
{
	while($query=mysql_fetch_array($item_sell))
	{
		$n=(!$n);
		$pal_price=$query["price"];
		
		$money_type="Зл.";
		if ($query["art"])$money_type="Пл.";
        if ($query["podzemka"])$money_type="Ед.";
        
        if (!$query["noremont"])
        {
        	if ($query["art"]) $price1=$pal_price*1.0-($query["iznos"]*0.1);
        	else $price1=$pal_price*0.75-($query["iznos"]*0.1);//$price1=$pal_price;
        }
        else $price1=1;
		if ($query["podzemka"])$price1=1;
		if ($price1<0)$price1=0;
		if ($query["term"]!="")$price1=0;
		$price = sprintf ("%01.2f", $price1);
		$db["vip"]=0;
		echo "<tr class='".($n?"l0":"l1")."'>
		<td width=180 valign=center align=center><img src='img/items/".$query["img"]."'><br>";
		echo "<a href='#' onclick=\"prodaja('".$query["id"]."', '".$query["name"].($query["is_modified"]?" +".$query["is_modified"]:"")."');\">Продать за $price $money_type</a>";
		echo "</td><td valign='top'>";
		show_item($db,$query);
		echo "</td></tr>";
	}
}
echo "</table>";
?>