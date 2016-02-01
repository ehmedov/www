<?
$login=$_SESSION['login'];
$city=$db["city_game"];
$ip=$db["remote_ip"];

$buy=(int)($_GET['buy']);

if (isset($_GET['otdel']))
{	
	$otdel=(int)$_GET['otdel'];
	$_SESSION['otdel']=$otdel;
}
else 
{
	if (isset($_SESSION['otdel']))
	{
		$otdel=$_SESSION['otdel'];
	}
}
$item=(int)($_GET['item']);
$item_count=(int)($_POST['item_count']);
?>
<SCRIPT LANGUAGE="JavaScript" SRC="scripts/magic-main.js"></SCRIPT>
<script>
	function prodaja(id,name)
	{
		if(confirm('Вы уверены что хотите продать предмет '+name+' ?'))
		{
			location.href = '?otdel=12&sell_id='+id+'&name='+name;
		}
	}
</script>
	
<div id=hint4></div>
<?
if($_GET["sell_id"])
{
	$item_id=(int)$_GET['sell_id'];
	$item_sell=mysql_fetch_Array(mysql_query("SELECT scroll.price, scroll.name, scroll.art, inv.id, inv.iznos, inv.iznos_max, inv.gift, inv.gift_author,inv.podzemka FROM inv LEFT JOIN scroll on scroll.id=inv.object_id WHERE inv.owner='".$login."' and inv.id=$item_id and inv.wear=0"));
	if (!$item_sell)
	{
		$msg="Вещь не найдена";
	}
	else 
	{
		$pal_price=round(0.75*$item_sell["price"]);
		$m_type="money"; $money_type="Зл.";
		if ($item_sell["art"]){$m_type="platina"; $money_type="Пл.";}
		$price=($pal_price*($item_sell["iznos_max"]-$item_sell["iznos"]))/$item_sell["iznos_max"];
		$price=round($price,2);
		if ($price<0)$price=0;
		if ($item_sell["gift"])$price=0;
		if ($item_sell["podzemka"])$price=0;
		mysql_query("DELETE FROM inv WHERE id=$item_id");
        mysql_query("UPDATE users SET $m_type=$m_type+$price WHERE login='".$login."'");
        $db[$m_type]=$db[$m_type]+$price;
        $price = sprintf ("%01.2f", $price);
    	$msg="Вы удачно продали предмет &quot".$item_sell["name"]."&quot за ".$price." $money_type";
        history($login,"Продал",$item_sell["name"]." за $price $money_type",$db["remote_ip"],"Скупка Зелья");		
	}
}
if(isset($_GET['buy']))
{
	$q=mysql_query("SELECT * FROM scroll where id='".$item."' and $city>0 and art=0 limit 1");
	$r=mysql_fetch_array($q);
	if(!$r)
	{
		$msg="Вещь не найдена в магазине.";
	}
	else
	{
		$i_max=$r["iznos_max"];
		$artovka = $r["art"];
		$name=$r["name"];
		$del_time= time() + $r["del_time"]*24*3600;
		$price_gos = $r["price"];
		$price = sprintf ("%01.2f", $price_gos);
		$counts=1;
		if ($r["type"]=="scroll" || $r["type"]=="wolf" || $r["type"]=="cheetah" || $r["type"]=="bear" || $r["type"]=="dragon" || $r["type"]=="food" || $r["type"]=="snake")
		{	
			if (isset($item_count) && $item_count>0)
			{
				$price=$price*$item_count;
				$counts=$item_count;
			}
			if ($db["money"]<$price)
			{
				$msg="У вас нет такой суммы!";
			}
			else 
			{
				$object_razdel="magic";
				if($r["type"]=="food")$object_razdel="food";
				for ($i=0;$i<$counts;$i++) 
				{
					mysql_query("LOCK TABLES inv WRITE");
					mysql_query("INSERT INTO inv(owner,object_id,object_type,object_razdel,wear,iznos,iznos_max,term) VALUES ('".$login."','".$item."','scroll','".$object_razdel."','0','0','".$i_max."','".$del_time."')");
					mysql_query("UNLOCK TABLES");
				}
				mysql_query("UPDATE users, scroll SET users.money=users.money-$price, scroll.".$city."=scroll.".$city."-".$counts." WHERE users.login='".$login."' and scroll.id='".$item."'");
				$db["money"]=$db["money"]-$price;
				$msg="Вы удачно купили ".($item_count?$counts.' шт ':'')." <b>&laquo;".$name."&raquo;</b> за <b>".$price." Зл.</b>";
				history($login,'Купил '.($item_count?$counts.' шт ':''),$msg,$ip,'Магазин магии');
			}
		}
		else if ($r["type"]=="ability")
		{
			if ($db["clan"] && $db["glava"])
			{
				if ($db["money"]>$price_gos)
				{
					$have=mysql_num_rows(mysql_query("SELECT * FROM abils WHERE tribe='".$db["clan"]."' and item_id='".$item."'"));
					if (!$have)
					{	
						mysql_query("INSERT INTO abils (item_id,tribe, m_iznos) values ('".$r["id"]."','".$db["clan"]."','".$r["iznos_max"]."')");
						mysql_query("UPDATE users SET money=money-$price_gos WHERE login='".$login."'");
						mysql_query("UPDATE scroll SET $city=$city-1 WHERE id='".$item."'");
						$db["money"]=$db["money"]-$price_gos;
						$msg="Вы удачно купили <b>&laquo;$name&raquo;</b> за <b>".$price." Зл.</b>";
						history($login,"Купил ",$msg,$ip,'Магазин магии');
					}
					else $msg="Вы уже купили $name";
				}
				else $msg="У вас нет такой суммы!";
			}
			else $msg="Вы не состоите ни в каком клане!";
		}
		$otdel=$buy;
	}
}
?>	
<h3>Лавка мага</h3>
<table border=0 width=100%>
<tr>
	<td colspan=2>
	<table width=100%><tr>
		<td><font color=#ff0000><?=$msg?>&nbsp;</font></td>
		<td nowrap>	
			<?
				$money = sprintf ("%01.2f", $db["money"]);
				$platina = sprintf ("%01.2f", $db["platina"]);
			?>
			<div align=right>У вас в наличии: <B><?echo $money;?></b> Зл. <b><?echo $platina;?></b> Пл.</div>
		</td>
	</tr></table>
	</td>
</tr>
<tr>
<td width=180 valign=top>
	<table width=100% cellspacing=1 cellpadding=3 class="l3">
		<tr><td align="center"><b>Магические товары</b></td></tr>
	</table>
	<br>
	<table class="l3" width="180" cellspacing="1" cellpadding="3">
    <tr class="l0">
        <td>
        	<INPUT type=button style="width:100%; cursor:hand" onclick="location.href='main.php?act=go&level=artmag'" value="Волшебный магазин" class="newbut">
        	<INPUT TYPE=button style="width:100%;" onclick="location.href='?otdel=12'" value="Скупка Зелья" class="newbut"> 	
			<INPUT type=button style="width:100%; cursor:hand" onclick="location.href='main.php?act=go&level=municip'" value="Выход" class="newbut">
			<INPUT TYPE=button style="width:100%;" class="podskazka" value="Подсказка" onclick="window.open('help/maq.php','displayWindow','height=400,width=500,resizable=no,scrollbars=yes,menubar=no,status=no,toolbar=no,directories=no,location=no')"/>
        </td>
    </tr>
	</table>
	<br>	  	  
	<table class="l3" width="180" cellspacing="1" cellpadding="3">
    <tr class="l0">
        <td>
        		&nbsp;<a href='?otdel=0'>Зелья</a><br>
        		&nbsp;<a href='?otdel=8'>Статовые</a><br>
        		&nbsp;<a href='?otdel=9'>Защитные</a><br>
        		&nbsp;<a href='?otdel=10'>Владения навыками</a><br>
        		&nbsp;<a href='?otdel=1'>Восстановление</a><br>
        		&nbsp;<a href='?otdel=2'>Разрушение</a><br>
        		&nbsp;<a href='?otdel=3'>Ремесленные</a><br>
        		&nbsp;<a href='?otdel=4'>Боевые</a><br>
        </td>
    </tr>
	</table>
	<br>	  	  
	<table class="l3" width="180" cellspacing="1" cellpadding="3">
    <tr class="l0">
        <td>
        		&nbsp;<a href='?otdel=6'>Животные</a><br>
        		&nbsp;<a href='?otdel=7'>Еда для Животных</a><br>
        </td>
    </tr>
	</table>
	<br>
	<table class="l3" width="180" cellspacing="1" cellpadding="3">
    <tr class="l0">
        <td>
				&nbsp;<a href='?otdel=5'>Клановые Абилити</a><br>
				&nbsp;<a href='?otdel=11'>Книжные</a><br>
        </td>
    </tr>
	</table>
	<img src="img/index/magic.gif">	
</td>
<td valign=top width=100%>
	<TABLE width=100% cellspacing=1 cellpadding=5 class="l3">
	<tr>
		<td valign=center align=center colspan=2>
			<B>Отдел: "<?
			switch ($otdel)
			{
				case 0:echo "Зелья";break;
				case 1:echo "Восстановление";break;
				case 2:echo "Разрушение";break;
				case 3:echo "Ремесленные";break;
				case 4:echo "Боевые";break;
				case 5:echo "Клановые Абилити";break;
				case 6:echo "Животные";break;
				case 7:echo "Еда для Животных";break;
				case 8:echo "Статовые";break;
				case 9:echo "Защитные";break;
				case 10:echo "Владения навыками";break;
				case 11:echo "Книжные";break;
				case 12:echo "Скупка Зелья";break;
			}
			?>"
			</B>
		</td>
	</tr>
	<?
	if ($otdel!=12)
	{

		$sql="SELECT * FROM scroll WHERE otdel='".$otdel."' and mountown>0 and art=0 ORDER BY min_level ASC, price ASC";
		$seek = mysql_query($sql);
		if (mysql_num_rows($seek))
		{
			while ($dat = mysql_fetch_array($seek))
			{
				$n=(!$n);
				$orden=$db["orden"];
				$id=$dat["id"];
				$name=$dat["name"];
				$type=$dat["type"];
				$img=$dat["img"];
				$mass=$dat["mass"];
				$price=$dat["price"];
				$price_gos = sprintf ("%01.2f", $price);
				$artovka = $dat["art"];
				$min_i=$dat["min_intellekt"];
				$min_v=$dat["min_vospriyatie"];
				$min_level=$dat["min_level"];
				$del_time=$dat["del_time"];

				$iznos_max=$dat["iznos_max"];
				$nums=$dat["mountown"];
				$need_orden=$dat["orden"];
				$desc=$dat["descs"];
				$to_book = $dat["to_book"];
				$need_mn = $dat["mana"];
				$school = $dat["school"];
				$eat_add_sitost = $dat["add_energy"];
				$eat_dzver = $dat["ztype"];
				
				echo "<TR class='".($n?'l0':'l1')."'><TD valign=center align=center width=150>
				<img src='img/".$img."' alt='".$name."'><BR>
				<a href='?buy=".$otdel."&item=".$id."&rnd=".md5(rand())."' >Купить</a>&nbsp;
				<img src='img/index/count.gif' style='CURSOR: Hand' alt='Купить несколько шт.' onclick=\"countitems('Купить несколько шт. :', '?buy=$otdel&item=$id', '$name', '5')\">";
				if ($db['adminsite']>=1)
				{
					echo "<br><a href='editmagic.php?item=$id' target='_blank'>edit</a>";
				}
				echo "</td>
				<td valign=top><b>$name</b> ".($artovka?"<img src='img/icon/artefakt.gif' border=0 alt=\"АРТЕФАКТ\">":"");
				if($need_orden!=0)
				{
					switch ($need_orden) 
					{
						 case 1:$orden_dis = "Стражи порядка";break;
						 case 2:$orden_dis = "Вампиры";break;
					 	 case 3:$orden_dis = "Орден Равновесия";break;
					 	 case 4:$orden_dis = "Орден Света";break;
					 	 case 5:$orden_dis = "Тюремный заключеный";break;
					 	 case 6:$orden_dis = "Истинный Мрак";break;
					}
					echo "&nbsp; <img src='img/orden/".$need_orden."/0.gif' border=0 alt='Требуемый орден:\n".$orden_dis."'>";
				}
				echo "&nbsp;(Масса: $mass)<br>";
				$my_money=($artovka?$db["platina"]:$db["money"]);
				echo "<b>Цена: ".($price>$my_money?"<font color=red>":"").$price_gos."</font>".($artovka?" Пл.":" Зл.")."</b> <small>(количество: $nums)</small><BR>
				Долговечность: 0/$iznos_max<br>";
				if($del_time)
				{
					echo "Срок годности: $del_time дн.<BR>";
				}
				echo "<table width=100%><tr><td valign=top>";
				if ($min_i || $min_v || $min_level || $need_mn || $school)echo "<B>Требуется минимальное:</B><BR>";
				if($min_i)
				{
					echo "&bull; ".($min_i>$db["intellekt"]?"<font color=red>":"")."Интеллект: $min_i</font><BR>";
				}
				if($min_v)
				{
					echo "&bull; ".($min_v>$db["vospriyatie"]?"<font color=red>":"")."Воссприятие: $min_v</font><BR>";
				}
				if ($min_level>0)
				{	
					echo "&bull; ".($min_level>$db["level"]?"<font color=red>":"")."Уровень: $min_level</font><BR>";
				}
				if($need_mn)
				{
					echo "&bull; Исп. маны: ".$need_mn."<BR>";
				}
				if($school)
				{
					switch ($school) 
					{
						 case "air":$school_d = "Воздух";break;
						 case "water":$school_d = "Вода";break;
					 	 case "fire":$school_d = "Огонь";break;
					 	 case "earth":$school_d = "Земля";break;
					}
					echo "&bull; Стихия: <b>".$school_d."</b><BR>";
				}
				if ($type=="animal")
				{
					echo "&bull; Состояние животного: не голодно";
				}
				if(!empty($desc))
				{
					echo "<br><font color=brown>Наложены заклятия:</font> ".str_replace("\n","<br>",$desc)."<BR>";
				}
				if($to_book)echo "<small><font color=brown>Использовать магию можно только в бою</font></small>";
				echo "</td></tr></table>";
			}
		}
		else echo "<tr class='l0' align=center><td><b>Прилавок магазина пустой...</b></td></tr>";
	}
	else
	{
		include("sell_mag.php");
	}
	?>
</td>
</tr>
</table>

</td>
</tr>
<table>
<br><br><br><br>
<?include_once("counter.php");?>