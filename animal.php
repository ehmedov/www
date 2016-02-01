<?
include("key.php");
include("time.php");
$login=$_SESSION["login"];
$ip=$db["remote_ip"];
#########################удаляем звера#########################
if($_GET["zver_del"]==1)
{
	$sql=mysql_query("SELECT * FROM zver WHERE owner=".$db["id"]." and sleep=0");
	if (mysql_num_rows($sql))
	{
		mysql_query("DELETE FROM zver WHERE owner=".$db["id"]." and sleep=0");
		$_SESSION["message"]="Зверь ушел от вас";
		history($login,'Выбросил звера',$_SESSION["message"],$ip,'Зверь');
		Header("Location: main.php?act=inv");
    	exit();
	}
}
#########################Вернуть в Магазин#########################
if($_GET["zver_sell"]==1)
{
	$sql=mysql_query("SELECT * FROM zver WHERE owner=".$db["id"]." and sleep=0");
	$res_zver=mysql_fetch_Array($sql);
	if ($res_zver["type"]=="dragon")
	{
		mysql_query("DELETE FROM zver WHERE owner=".$db["id"]." and sleep=0");
		mysql_query("UPDATE users SET platina=platina+1500 WHERE id=".$db["id"]);
		$_SESSION["message"]="Зверь вернулся в магазин и Вам перечислили 1500 Пл.";
		history($login,'Вернуль звера в Магазин',$_SESSION["message"],$ip,'Зверь');
		Header("Location: main.php?act=inv");
    	exit();
	}
}

####################################################################

$sql=mysql_query("SELECT * FROM zver WHERE owner=".$db["id"]." and sleep=0");
if (!mysql_num_rows($sql))
{
	echo "<h3>У вас нету зверя</h3>";
}
else 
{
	$zver=mysql_fetch_array($sql);

	#########################скармлеваем#########################
	if($_GET["action"]=='energy')
	{
		$item_id=(int)$_GET["item_id"];
		$items=mysql_fetch_array(mysql_query("SELECT * FROM inv WHERE id='".$item_id."' and object_razdel='food' and owner='".$login."'"));
		if($items)
		{
			$mag=mysql_fetch_Array(mysql_query("SELECT * FROM scroll WHERE id=".$items["object_id"]));
			if($zver["type"]==$mag["ztype"])
			{
				$add_energy=$mag["add_energy"];
				if($zver["max_energy"] - $zver["energy"]<$add_energy)
				{
					$add_energy = $zver["max_energy"] - $zver["energy"];
				}
				$new_sitost = $zver["energy"] + $add_energy;
				if ($add_energy>0)
				{	
					mysql_query("UPDATE zver SET energy='".$new_sitost."' WHERE owner='".$db["id"]."' and sleep=0");
					mysql_query("UPDATE `inv` SET iznos=iznos+1 WHERE id = '".$item_id."'");
					$INV_SQL = mysql_query("SELECT * FROM `inv` WHERE id = '".$item_id."'");
					$INV     = mysql_fetch_array($INV_SQL);
					if($INV["iznos"]==$INV["iznos_max"])
					{
						mysql_query("DELETE FROM `inv` WHERE id = '".$item_id."'");
						$_SESSION["message"].="<br>Свиток полностью использован.";
					}
					$zver["energy"]=$new_sitost;
					$_SESSION["message"]="Вы пополнили энергию зверя на ".$new_sitost;
				}
				else $_SESSION["message"]="Ваш зверь сыт";
			}
			else $_SESSION["message"]="Ваш Зверь не хочет есть <u>".$mag["name"]."</u>";
		}
	}
	#########################удаляем#########################
	//-------------------------------DELETE ITEMS------------------------------------------------------------------
	if ($_POST["tmpname423"])
	{	
		$name=htmlspecialchars(addslashes($_POST['drop']));
		$del_id=(int)$_POST['n'];
		
		$drop_item=mysql_fetch_array(mysql_query("select * from inv where id='".$del_id."' and owner='".$login."' and wear=0"));
		if (!$drop_item)
		{
			$_SESSION["message"]= "У вас нет такой вещь...";
		}
		else
		{
			if(isset($_POST["dropall"]))
			{
				mysql_query("DELETE FROM inv WHERE object_id='".$drop_item["object_id"]."' and object_type='".$drop_item["object_type"]."' and wear=0 and owner='".$login."'");
				history($login,'Выбросил Все',$name,$ip,'Свалка');
				$_SESSION["message"]= "Вы удачно удалили все предметы &quot".$name."&quot!";
			}	
			else if(isset($_POST["drop"]))
			{	
				mysql_query("DELETE FROM inv WHERE id='".$del_id."' and wear=0");
				history($login,'Выбросил',$name,$ip,'Свалка');
				$_SESSION["message"]= "Вы удачно удалили предмет &quot".$name."&quot!";
			}
		}

	}
	?>
	<SCRIPT LANGUAGE="JavaScript" SRC="scripts/magic-main.js"></SCRIPT>
	<div id="hint4" name="hint4" style="z-index: 5;"></div>

	<SCRIPT LANGUAGE="javascript">
	function conf(name)
	{	
		if (confirm('Вы уверены, что хотите навсегда прогнать '+name+'?')) 
		{
			location.href = 'main.php?act=animal&zver_del=1';
		}
	}
	function sell(name)
	{	
		if (confirm('Вы уверены, Вернуть в Магазин '+name+'?')) 
		{
			location.href = 'main.php?act=animal&zver_sell=1';
		}
	}
	var sd4 = Math.random();
	function drop(name, n, txt, image)
	{
		image = image || name;
		var table = 	'<TABLE width=100%><TD><IMG src="img/'+image+'"></TD><TD>Предмет <NOBR><B>\''+txt+'\'</B></NOBR> будет утерян, вы уверены ?</TABLE>'+
 		'<input type=checkbox name="dropall" value="'+txt+'"><SMALL> Все предметы этого вида</SMALL>'+
		'<INPUT type=hidden name=drop value="'+name+'"><INPUT type=hidden name=n value="'+n+'"><INPUT type=hidden name=sd4 value="' + sd4+'">';
		// window.clipboardData.setData('Text', table);
		dialogconfirm('Выбросить предмет?', 'main.php?act=animal',table,4);
	}
	</SCRIPT>

	<TABLE width=100% cellspacing=0 cellpadding=0>
	<TR>
	<TD valign=top>
		<table width="100%"  border="0" cellspacing="1" cellpadding="0">
		<tr valign="top">
			<td colspan=3 align="center" width=140><B><? echo $zver["name"]; ?></B> [<? echo $zver["level"]; ?>]</td>
		</tr>
		<tr valign="top">
			<td width=240>
				<IMG src="img/<? echo $zver['obraz']; ?>">
			</td>
			<td width=5 nowrap><span></span></td>
			<td width=100% align=left>
				<font title="Уровень жизни животного в бою">HP</font>: <? echo $zver["hp_all"]; ?><BR><BR>
				<font title="Сила определяет урон наносимый атаками животного в бою">Сила</font>: <? echo $zver["sila"];?><BR>
				<font title="Ловкость определяет уровень уворота и антиуворота животного в бою">Ловкость</font>: <? echo $zver["lovkost"];?><BR>
				<font title="Удача определяет шанс нанести критический удар или защитится от него">Удача</font>: <? echo $zver["udacha"];?><BR>
				<font title="От выносливости зависит уровень жизни животного и защита от урона">Выносливость</font>: <? echo $zver["power"];?><BR><BR>

				<font title="Уровень животного не может быть выше уровня хозяина">Уровень</font>: <? echo $zver["level"]; ?><BR>
				<font title="Животное получает опыт сражаясь за владельца">Опыт</font>: <? echo $zver["exp"]; ?>/<? echo $zver["next_up"]; ?><BR>
				<font title="Голодное животное не принимает участия в боях">Энергия</font>: <? echo $zver["energy"]."/".$zver["max_energy"]; ?><BR><BR>
				<?
					if ($zver["level"]>0)
					{
						switch ($zver["type"]) 
						{
							 case "wolf":	$txt = "• Удача + ".($zver["level"]);break;
							 case "bear":	$txt = "• Сила + ".($zver["level"]);break;
						 	 case "cheetah":$txt = "• Ловкость + ".($zver["level"]);break;
						 	 case "snake":	$txt = "• Интеллект + ".($zver["level"]);break;
						}

						echo "<b>Освоенные навыки</b>:<br>$txt";
					}
					if ($zver["two_hands"]>time())
					{
						echo "<br><br><b>Состояние</b>:<br> Двуручный Зверь: Еще".convert_time($zver['two_hands']);
					}
				?>	
			</td>
		</tr>
		</TABLE>
	</td>
	<td width=50% valign=top>
		<table border=0 cellpadding=0 cellspacing=0 width=100%>
		<tr>
			<td>
				<?echo "<b style='color:#ff0000'>".$_SESSION["message"]." &nbsp;</b>";$_SESSION["message"]="";?>
			</td>
		</tr>
		</TABLE>

		<TABLE width=100% cellspacing=0 cellpadding=0>
		<TR>	
		<TD>
			<INPUT TYPE=button class="newbut" style="cursor:hand" value="Выгнать" onClick="conf('<?=$zver[name]?>');">
		</TD>
		<TD valign=top align=right>
			<INPUT TYPE=button class="newbut" style="cursor:hand" value="Обновить" onClick="javascript:location.href='main.php?act=animal'">
			<INPUT TYPE=button class="newbut" style="cursor:hand" value="Вернуться" onClick="javascript:location.href='main.php?act=inv'">
		</TD>
		</TR>
		</TABLE>
		<table width='100%' cellspacing='1' cellpadding='2' bgcolor='#cebbaa'>
		<?
		$S = mysql_query("SELECT scroll.*,inv.id as ids,inv.iznos,inv.iznos_max,count(*) as co FROM inv LEFT JOIN scroll on scroll.id=inv.object_id WHERE inv.owner='".$login."' and inv.object_razdel='food' and inv.wear=0 GROUP BY object_id");
		while($DAT = mysql_fetch_array($S))
		{
			$n=(!$n);
			$spell_id=$DAT["id"];
			$item_id = $DAT["ids"];
	        $iznos = $DAT["iznos"];
			$iznos_all = $DAT["iznos_max"];
	        $name = $DAT["name"];
	        $img = $DAT["img"];
	        $min_i = $DAT["min_intellekt"];
	        $min_v = $DAT["min_vospriyatie"];
	        $min_level = $DAT["min_level"];
	        $desc = $DAT["desc"];
	        $type = $DAT["type"];
	        $mana = $DAT["mana"]; 
	        $school = $DAT["school"];
	        $artovka = $DAT["art"];
	        $co = $DAT["co"];
	        $price=$DAT["price"];
	        $price=sprintf ("%01.2f", $price);
			$eat_add_sitost = $DAT["add_energy"];
			$eat_dzver = $DAT["ztype"];
			echo "<tr class='".($n?'l0':'l1')."'>
			<td width=150 valign=center align=center>
			<span style=\"position:relative;  width:60px; height:60px;\"><img src='img/".$img."' alt='".$name."'><small style='background-color: #E0E0E0; position: absolute; right: 1; bottom: 3;'><B>x".$co."</B></small></span>
			<br>";
			echo "<a href='main.php?act=animal&action=energy&item_id=$item_id'>Скормить</a><br>";
			echo "<A HREF=\"javascript:drop('$name', '$item_id', '$name', '$img')\"><img src='img/icon/clear.gif' style='CURSOR: Hand' border=0></a>";
			echo "</td><td valign=top><b>$name</b> ".($artovka?"<img src='img/artefakt.gif' border=0 alt=\"АРТЕФАКТ\">":"")." (Масса: ".$DAT["mass"].")<br>";
			echo "<b>Цена: ".$price.($artovka?" Пл.":" Зл.")."</b><BR>";
	        echo "Долговечность: $iznos/$iznos_all<BR>";
	        echo "<b>Требования:</b><BR>";
			if($min_i)
			{
				echo "&bull; ".($min_i>$db["intellekt"]?"<font color=red>":"")."Интеллект: $min_i</font><BR>";
			}
			if($min_v)
			{
				echo "&bull; ".($min_v>$db["vospriyatie"]?"<font color=red>":"")."Воссприятие: $min_v</font><BR>";
			}
	        echo "&bull; ".($min_level>$db["level"]?"<font color=red>":"")."Уровень: $min_level</font><BR>";
	        if($mana)
			{
				echo "&bull; Исп. маны: ".$mana."<BR>";
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
			if ($eat_add_sitost)
			{
				echo "<B>Параметры:</B><BR>&bull; Сытость: +$eat_add_sitost<BR>";
			}	
	        if($DAT["descs"])
	        {
	        	echo "<div style=\"width:300;\">";
	        	echo "<small><b>Описание:</b> ".$DAT["descs"]."</small>";
	        	echo "</div>";
	        }
	        echo "</td></tr>";
		}
		if(!mysql_num_Rows($S))echo "<tr><td bgcolor=#D5D5D5 colspan=2><center>У вас нет подходящей еды в рюкзаке</td></tr>";
		echo "</TABLE>";
}
?>
