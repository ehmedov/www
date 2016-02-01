<script>
function prodaja(id,name,type)
{
	if(confirm('Вы уверены что хотите продать предмет \"'+name+'\" ?'))
	{
		location.href = '?action=sellconf&type='+type+'&item='+id+'&name='+name;
	}
}
function prodaja_all(id,name,type)
{
	if(confirm('Вы уверены что хотите продать все предметы \"'+name+'\" ?'))
	{
		location.href = '?action=sellconf_all&type='+type+'&item='+id+'&name='+name;
	}
}
</script>
<link rel=stylesheet type="text/css" href="smith.css">
<?
$login=$_SESSION['login'];
$ip=$db["remote_ip"];
//-------------------------------Продать------------------------------------------------------
if($_GET['action']=="sellconf" && is_numeric($_GET['item']))
{
	$item_id=(int)$_GET['item'];
	$type=$_GET["type"];
	$q=mysql_query("SELECT * FROM inv LEFT JOIN runa on runa.id=inv.object_id WHERE inv.owner='".$login."' AND inv.object_razdel='runa' and inv.id=".$item_id);
    $res=mysql_fetch_array($q);
    if ($res)
    {
        $name=$res["name"];
        $price=$res["price"];	
        $price1 = sprintf ("%01.2f", $price);
        mysql_query("DELETE FROM inv WHERE id=$item_id");
        mysql_query("UPDATE users SET platina=platina+$price WHERE login='".$login."'");
    	$msg="Вы удачно продали предмет &quot".$name."&quot за ".$price1." Пл.";
        history($login,'Продал',$msg,$ip,'Кристальный магазин');
        mysql_query("INSERT INTO com_runa (seller,ip,name,count_runa,platina) VALUES ('$login','$ip','$name',1,$price)");
        $db["platina"]=$db["platina"]+$price;
    }
	else
	{
		$msg="Предмет не найден в вашем рюкзаке!";
	}
}
//-------------------------------Продать Все------------------------------------------------------
if($_GET['action']=="sellconf_all" && is_numeric($_GET['item']))
{
	$item_id=(int)$_GET['item'];
	$type=$_GET["type"];
	$q=mysql_query("SELECT runa.*, count(*) as co FROM inv LEFT JOIN runa ON runa.id=inv.object_id WHERE inv.owner='".$login."' and inv.object_type='runa' and inv.object_id=$item_id GROUP by object_id");
    $res=mysql_fetch_array($q);
    if ($res)
    {
        $name=$res["name"];
        $price=$res["price"];
        $co=$res["co"];
        $price=$price*$co;
        $price1 = sprintf ("%01.2f", $price);
        mysql_query("DELETE FROM inv WHERE owner='".$login."' and object_type='runa' and inv.object_id=$item_id");
        mysql_query("UPDATE users SET platina=platina+$price WHERE login='".$login."'");
    	$msg="Вы удачно продали все предметы &quot".$name."&quot за ".$price1." Пл. ($co шт.)";
        history($login,'Продал Все',$msg,$ip,'Кристальный магазин');
		mysql_query("INSERT INTO com_runa (seller,ip,name,count_runa,platina) VALUES ('$login','$ip','$name',$co,$price)");
		$db["platina"]=$db["platina"]+$price;
    }
	else
	{
		$msg="Предмет не найден в вашем рюкзаке!";
	}
}

$money = sprintf ("%01.2f", $db["money"]);
$platina = sprintf ("%01.2f", $db["platina"]);
$naqrada = sprintf ("%01.2f", $db["naqrada"]);
//--------------------------------------------------------------------------------------------
echo "<h3>Кристальный магазин</h3>";
echo "<table width=100%>
	<tr>
	<td width=100%>
		У вас в наличии: <B>".$money."</b> Зл. <b>".$platina."</b> Пл. <b>".$naqrada."</b> Ед.
	</td>
	<td nowrap>
		<INPUT TYPE=button onclick=\"location.href='main.php?act=go&level=crypt_go'\" value=\"Вернуться\" >
		<INPUT TYPE=button onclick=\"location.href='?act=none'\" value=\"Обновить\">
	</td>
	</tr>
	</table>";
echo "<table align=center><tr><td align=center><img src='img/city/priem.jpg'><br>
<b style=color:#ff0000>$msg &nbsp;</b>";
echo "<TABLE WIDTH=100% CELLSPACING=1 CELLPADDING=2 BGCOLOR=#212120 align=center>";
$res = mysql_query("SELECT runa.*,inv.id as ids,inv.iznos,inv.iznos_max,inv.object_id, count(*) as co FROM inv LEFT JOIN runa ON runa.id=inv.object_id WHERE inv.owner='".$login."' and inv.object_type='runa' GROUP by object_id");
if(mysql_num_rows($res)>0)
{
	while ($_res=mysql_fetch_array($res))
	{	
		$name=$_res["name"];
		$co = $_res["co"];
        $img=$_res["img"];
		$iznos=$_res["iznos"];
        $iznos_max=$_res["iznos_max"];
		$price=$_res["price"];
		$price = sprintf ("%01.2f", $price);
		$all_price=sprintf ("%01.2f", $price*$co);
    	$iznos = $_res["iznos"];
		$iznos_all = $_res["iznos_max"];
		$object_id=$_res["object_id"];
		
		$mass=$_res["mass"];
		$n=(!$n);
		echo "<tr bgcolor=".($n?'#C7C7C7':'#D5D5D5').">
		<td valign=center align=center width=200>
		<span style=\"position:relative;  width:60px; height:60px;\">
		<img src='img/".$img."' alt='".$name."' border=0>
		<small style='background-color: #E0E0E0; position: absolute; right: 1; bottom: 3;'><B>x".$co."</B></small>
		</span>
		<br>
		<a href='#' onclick=\"prodaja('".$_res["ids"]."', '".$name."','zl');\">Продать за ".$price." Пл.</a><br>
		<a href='#' onclick=\"prodaja_all('".$object_id."', '".$name."','zl');\">Продать Все за ".$all_price." Пл.</a>	
		</td>
		<td valign=top>
			<b>$name</b> (Масса: $mass)<BR>
			<b>Цена: $price Пл.</b><BR>
			Долговечность:$iznos/$iznos_all
		</td>
		</tr>";
	}
}
else echo "<tr align=center bgcolor='#D5D5D5'><td><b>У Вас нет вещей, которые можно продать</b></td></tr>";
echo "</table>";
?>