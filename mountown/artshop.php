<?
include_once("inc/shop/otdels_b.php");
$login=$_SESSION['login'];
$city=$db["city_game"];

$buy=htmlspecialchars(addslashes($_GET['buy']));
$item=intval($_GET['item']);

if (isset($_GET['otdel']))
{	
	$otdel=htmlspecialchars(addslashes($_GET['otdel']));
	$_SESSION['otdel_pl']=$otdel;
}
else 
{
	if (isset($_SESSION['otdel_pl']))
	{
		$otdel=$_SESSION['otdel_pl'];
	}
}
//----------------------------------------------------------------------------------------
if($buy)
{
	$query=mysql_query("SELECT * FROM paltar WHERE id='".$item."' and mountown>0 and art=2");
	$buy_item=mysql_fetch_assoc($query);
	if(!$buy_item)
	{
		$msg="Вещь не найдена в магазине.";
	}
	else
	{
		$gos_price=$buy_item["price"];
		if ($db["vip"]>time())$buy_item["price"]=ceil($buy_item["price"]*0.75);
		if ($db["platina"]<$buy_item["price"])
		{
			$msg="У Вас нет достаточной суммы для покупки этой вещи!";
		}
		else if ($buy_item["orden"]!=0 && $buy_item["orden"]!=$db["orden"])
		{
			$msg="Ваша склонность не позволяет купить эту вещь";
		}
		else
		{
			mysql_query("LOCK TABLES inv WRITE");
			mysql_query("INSERT INTO `inv` (`id`, `owner`, `img`, `object_id`, `object_type`, `object_razdel`, `name`,  `mass`, `price`, `gos_price`, `min_sila`, `min_lovkost`, `min_udacha`, `min_power`, `min_intellekt`, `min_vospriyatie`, `min_level`, `min_sword_vl`, `min_staff_vl`, `min_axe_vl`, `min_fail_vl`, `min_knife_vl`, `min_spear_vl`,`min_fire`,`min_water`,`min_air`,`min_earth`,`min_svet`,`min_tma`,`min_gray`,`add_fire`, `add_water`, `add_air`, `add_earth`, `add_svet`, `add_tma`, `add_gray`, `add_sila`, `add_lovkost`, `add_udacha`, `add_intellekt`, `add_duxovnost`, `add_hp`, `add_mana`, `protect_head`, `protect_arm`, `protect_corp`, `protect_poyas`, `protect_legs`, `protect_rej`, `protect_drob`, `protect_kol`, `protect_rub`, `protect_fire`, `protect_water`, `protect_air`, `protect_earth`, `protect_svet`, `protect_tma`, `protect_gray`,`protect_mag`,`protect_udar`, `shieldblock`, `krit`, `akrit`, `uvorot`, `auvorot`, `parry`, `counter`, `add_rej`, `add_drob`, `add_kol`, `add_rub`, `ms_udar`, `ms_krit`, `ms_mag`, `ms_fire`, `ms_water`, `ms_air`, `ms_earth`, `ms_svet`, `ms_tma`, `ms_gray`, `ms_rej`, `ms_drob`, `ms_kol`, `ms_rub`, `iznos_max`, `min_attack`, `max_attack`, `proboy`, `add_oruj`, `add_sword_vl`, `add_staff_vl`, `add_axe_vl`, `add_fail_vl`, `add_knife_vl`, `add_spear_vl`, `need_orden`, `sex`, `art`, `podzemka`, `is_personal`, `personal_owner`, `noremont`, `two_hand`, `second_hand`,  `add_fire_att`, `add_air_att`, `add_watet_att`, `add_earth_att`, `edited`) 
				VALUES (NULL, '".$login."','".$buy_item["img"]."' ,'".$buy_item["id"]."', '".$buy_item["object"]."', 'obj', '".$buy_item["name"]."', '".$buy_item["mass"]."', '".$buy_item["price"]."', '".$gos_price."', '".$buy_item["min_sila"]."', '".$buy_item["min_lovkost"]."', '".$buy_item["min_udacha"]."', '".$buy_item["min_power"]."', '".$buy_item["min_intellekt"]."', '".$buy_item["min_vospriyatie"]."', '".$buy_item["min_level"]."', '".$buy_item["min_sword_vl"]."', '".$buy_item["min_staff_vl"]."', '".$buy_item["min_axe_vl"]."', '".$buy_item["min_fail_vl"]."', '".$buy_item["min_knife_vl"]."', '".$buy_item["min_spear_vl"]."', '".$buy_item["min_fire"]."','".$buy_item["min_water"]."','".$buy_item["min_air"]."','".$buy_item["min_earth"]."','".$buy_item["min_svet"]."','".$buy_item["min_tma"]."','".$buy_item["min_gray"]."', '".$buy_item["add_fire"]."', '".$buy_item["add_water"]."', '".$buy_item["add_air"]."', '".$buy_item["add_earth"]."', '".$buy_item["add_svet"]."', '".$buy_item["add_tma"]."', '".$buy_item["add_gray"]."', '".$buy_item["add_sila"]."', '".$buy_item["add_lovkost"]."', '".$buy_item["add_udacha"]."', '".$buy_item["add_intellekt"]."', '".$buy_item["add_duxovnost"]."', '".$buy_item["add_hp"]."', '".$buy_item["add_mana"]."', '".$buy_item["protect_head"]."', '".$buy_item["protect_arm"]."', '".$buy_item["protect_corp"]."', '".$buy_item["protect_poyas"]."', '".$buy_item["protect_legs"]."', '".$buy_item["protect_rej"]."', '".$buy_item["protect_drob"]."', '".$buy_item["protect_kol"]."', '".$buy_item["protect_rub"]."', '".$buy_item["protect_fire"]."', '".$buy_item["protect_water"]."', '".$buy_item["protect_air"]."', '".$buy_item["protect_earth"]."', '".$buy_item["protect_svet"]."', '".$buy_item["protect_tma"]."', '".$buy_item["protect_gray"]."', '".$buy_item["protect_mag"]."', '".$buy_item["protect_udar"]."','".$buy_item["shieldblock"]."','".$buy_item["krit"]."', '".$buy_item["akrit"]."', '".$buy_item["uvorot"]."', '".$buy_item["auvorot"]."', '".$buy_item["parry"]."', '".$buy_item["counter"]."', '".$buy_item["add_rej"]."', '".$buy_item["add_drob"]."', '".$buy_item["add_kol"]."', '".$buy_item["add_rub"]."', '".$buy_item["ms_udar"]."', '".$buy_item["ms_krit"]."', '".$buy_item["ms_mag"]."', '".$buy_item["ms_fire"]."', '".$buy_item["ms_water"]."', '".$buy_item["ms_air"]."', '".$buy_item["ms_earth"]."', '".$buy_item["ms_svet"]."', '".$buy_item["ms_tma"]."', '".$buy_item["ms_gray"]."', '".$buy_item["ms_rej"]."', '".$buy_item["ms_drob"]."', '".$buy_item["ms_kol"]."', '".$buy_item["ms_rub"]."', '".$buy_item["iznos_max"]."', '".$buy_item["min_attack"]."', '".$buy_item["max_attack"]."', '".$buy_item["proboy"]."','".$buy_item["add_oruj"]."' ,'".$buy_item["add_sword_vl"]."', '".$buy_item["add_staff_vl"]."', '".$buy_item["add_axe_vl"]."', '".$buy_item["add_fail_vl"]."', '".$buy_item["add_knife_vl"]."', '".$buy_item["add_spear_vl"]."', '".$buy_item["need_orden"]."', '".$buy_item["sex"]."', '".$buy_item["art"]."', '".$buy_item["podzemka"]."', '".$buy_item["is_personal"]."', '".$buy_item["personal_owner"]."', '".$buy_item["noremont"]."', '".$buy_item["two_hand"]."', '".$buy_item["second_hand"]."',  '".$buy_item["add_fire_att"]."', '".$buy_item["add_air_att"]."', '".$buy_item["add_watet_att"]."', '".$buy_item["add_earth_att"]."', '".$buy_item["edited"]."');");
			mysql_query("UNLOCK TABLES");
			mysql_query("UPDATE users,paltar SET users.platina=users.platina-".$buy_item["price"].", paltar.".$city."=paltar.".$city."-1 WHERE users.login='".$login."' and paltar.id='".$item."'");	
			$db["platina"]=$db["platina"]-$buy_item["price"];
			$msg="Вы удачно купили <b>&laquo;".$buy_item["name"]."&raquo;</b> за <b>".$buy_item["price"]." Пл.</b>";
			$name2=$buy_item["name"]." (".$buy_item["price"]." Пл.)";
			history($login,'Купил',$name2,$db["remote_ip"],'Магазин Артов');
		}
		$otdel=$buy;
	}
}
$money = sprintf ("%01.2f", $db["money"]);
$platina = sprintf ("%01.2f", $db["platina"]);
if (!isset($otdels[$otdel])){$otdel="sword";}
?>
<script>
	function blinkFont()
	{
	  document.getElementById("but").style.color="red";
	  setTimeout("setblinkFont()",1000);
	}

	function setblinkFont()
	{
	  document.getElementById("but").style.color="white";
	  setTimeout("blinkFont()",1000);
	}
</script>
<h3>Артефактный магазин</h3>
<body onload="blinkFont()">	
<TABLE width=100% cellspacing=0 cellpadding=0><tr><td><b style=color:#ff0000><?=$msg;?>&nbsp;</b></td><td align=right>У вас в наличии: <B><?echo $money;?></b> Зл. <b><?echo $platina;?></b> Пл.</td></tr></table>
<table border=0 width=100% cellpadding=3 cellspacing=0>
<tr>
<td width=180 valign=top>
	<table width="100%" cellspacing="1" cellpadding="3" class="l3"  height=20>
		<tr><td align="center"><b>Отделы магазина</b></td></tr>
	</table>
	<br>
	<table width="100%" cellspacing="1" cellpadding="3" class="l3">
        <tr class="l0">
            <td>
				<INPUT TYPE=button style="width:100%;" onclick="location.href='main.php?act=go&level=plshop'" value="Выход" class="newbut">
				<INPUT TYPE=button id="but" style="width:100%;color:red" onclick="window.open('thing.php')" value="Энциклопедия предметов" class="newbut"/>
            </td>
        </tr>
	</table>
	<br>
	<?include_once("inc/shop/otdels.php")?>
</td>
<td valign=top>
	<table width=100% cellspacing=1 cellpadding=3 class="l3">	
	<tr height=20><td valign=center align=center colspan=2><b>Ассортимент товаров отдела "<?=$otdels[$otdel];?>" </b></td></tr>
	<?
		//if (!$db["adminsite"])die("ЗАКРЫТ НА РЕМОНТ!!");
		$seek=mysql_query("SELECT * FROM paltar WHERE object='".$otdel."' and mountown>0 and art=2 ORDER BY min_level ASC,price ASC");
		while ($res=mysql_fetch_array($seek))
		{
			$n=(!$n);
			echo '<tr class="'.($n?'l0':'l1').'">
						<td valign=center align=center width=150 nowrap><img src="img/items/'.$res['img'].'"><br>';
						echo '<a href="?buy='.$otdel.'&item='.$res["id"].'">Купить</a><br>';
						if ($db['adminsite'])
						{
							echo '<hr width=75%><a href="add.php?type=edit&edit_id='.$res["id"].'" target="_blank">edit</a>';
						}
						echo '</td><td>';
						show_item($db,$res);
						echo '<br><small>Осталось: <b>'.$res["mountown"].'</b> шт.</small>';
						echo '</td>
				</tr>
			
			';
		}
		if (!mysql_num_rows($seek))echo "<tr bgcolor='#C7C7C7'><td valign=center align=center nowrap colspan=2><b>Прилавок магазина пустой...</b></td></tr>";
	?>
</td>
</tr>
<table>
<br><br><br><br>
<?include_once("counter.php");?>