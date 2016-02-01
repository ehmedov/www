<?
$login = $_SESSION['login'];
$cem=2000;
//-------------------------------------------------------------------------------------------------------
if($_GET["from_box"]!="" && is_numeric($_GET["from_box"]))
{
	$from_box=(int)$_GET["from_box"];
	$sql=mysql_query("SELECT * FROM inv WHERE owner='".$login."' and object_type='wood' and id=$from_box");
	if(!mysql_num_rows($sql))
	{
		$msg="Предмет не найден в вашем рюкзаке!";
	}
	else
	{
		$c=mysql_query("SELECT count(*) FROM sklad WHERE owner='".$db["id"]."'");
		$all=mysql_fetch_array($c);
		if ($all[0]>=$cem)
		{
			$msg="В сундуке нет места...";
		}
		else
		{
			$res=mysql_fetch_array($sql);
			mysql_query("INSERT INTO sklad (owner,object_id,object_type,object_razdel,iznos,iznos_max) VALUES ('".$db["id"]."','".$res["object_id"]."','".$res["object_type"]."','".$res["object_razdel"]."','".$res["iznos"]."','".$res["iznos_max"]."')");
			mysql_query("DELETE FROM inv WHERE id=".$res['id']);
			$msg="Предмет перенесен из инвентаря";
		}
	}
}
//-------------------------------------------------------------------------------------------------------
if($_GET["from_box_all"]!="" && is_numeric($_GET["from_box_all"]))
{
	$from_box_all=(int)$_GET["from_box_all"];
	$sql=mysql_query("SELECT * FROM inv WHERE owner='".$login."' and object_type='wood' and id=$from_box_all");
	if(!mysql_num_rows($sql))
	{
		$msg="Предмет не найден в вашем рюкзаке!";
	}
	else
	{
		$res=mysql_fetch_array($sql);
		$query=mysql_query("SELECT * FROM inv WHERE owner='".$login."' and object_type='".$res['object_type']."' and object_id='".$res['object_id']."'");
		$count_all=mysql_num_rows($query);
		$c=mysql_query("SELECT count(*) FROM sklad WHERE owner='".$db["id"]."'");
		$all=mysql_fetch_array($c);
		if (($all[0]+$count_all)>=$cem)
		{
			$msg="В сундуке нет места...";
		}
		else
		{
			while($que=mysql_fetch_array($query))
			{	
				mysql_query("INSERT INTO sklad (owner,object_id,object_type,object_razdel,iznos,iznos_max) VALUES ('".$db["id"]."','".$que["object_id"]."','".$que["object_type"]."','".$que["object_razdel"]."','".$que["iznos"]."','".$que["iznos_max"]."')");
				mysql_query("DELETE FROM inv WHERE id=".$que['id']);
			}
			$msg="Предмет перенесен из инвентаря";
		}
	}
}
//-------------------------------------------------------------------------------------------------------
if($_GET["to_box"]!="" && is_numeric($_GET["to_box"]))
{
	$to_box=(int)$_GET["to_box"];
	$sql=mysql_query("SELECT * FROM sklad WHERE owner='".$db["id"]."' and object_type='wood' and id=$to_box");
	if(!mysql_num_rows($sql))
	{
		$msg="Предмет не найден в Складе!";
	}
	else
	{
		$res=mysql_fetch_array($sql);
		mysql_query("INSERT INTO inv (owner,object_id,object_type,object_razdel,iznos,iznos_max) VALUES ('".$login."','".$res["object_id"]."','".$res["object_type"]."','".$res["object_razdel"]."','".$res["iznos"]."','".$res["iznos_max"]."')");
		mysql_query("DELETE FROM sklad WHERE id=".$res['id']);
		$msg="Предмет перенесен в инвентарь";
	}
}
//-------------------------------------------------------------------------------------------------------
if($_GET["to_box_all"]!="" && is_numeric($_GET["to_box_all"]))
{
	$to_box_all=(int)$_GET["to_box_all"];
	$sql=mysql_query("SELECT * FROM sklad WHERE owner='".$db["id"]."' and object_type='wood' and id=$to_box_all");
	if(!mysql_num_rows($sql))
	{
		$msg="Предмет не найден в Складе!";
	}
	else
	{
		$res=mysql_fetch_array($sql);
		$query=mysql_query("SELECT * FROM sklad WHERE owner='".$db["id"]."' and object_type='".$res['object_type']."' and object_id='".$res['object_id']."'");
		while($que=mysql_fetch_array($query))
		{
			mysql_query("INSERT INTO inv (owner,object_id,object_type,object_razdel,iznos,iznos_max) VALUES ('".$login."','".$res["object_id"]."','".$res["object_type"]."','".$res["object_razdel"]."','".$res["iznos"]."','".$res["iznos_max"]."')");
			mysql_query("DELETE FROM sklad WHERE id=".$que['id']);
		}
		$msg="Предмет перенесен в инвентарь";
	}
}
//-------------------------------------------------------------------------------------------------------
$c=mysql_query("SELECT count(*) FROM sklad WHERE owner='".$db["id"]."'");
$all=mysql_fetch_array($c);
?>
<h3>Склад</h3>
<table width=100%>
<tr>
<td valign='top' width=100%><b style=color:#ff0000><?=$msg;?></b>&nbsp;</td>
<td valign='top' nowrap>
	<input type="button" class="btn" id="battle" onclick="window.location='main.php?act=go&level=bazar'" value="Вернуться">
	<input type="button" class="btn" id="refresh" onclick="window.location='main.php?act=none'" value="Обновить">
</td>
</tr>
</table>
<TABLE width=100% cellpadding=0 cellspacing=0><TR height=20>
<TD width=50% class='fnew'>В сундуке (Всего вещей: <?=$all[0]."/".$cem;?>)</TD><TD class='fnew'>В рюкзаке</TD>
<TR>
	<TD valign=top>
	<TABLE WIDTH=100% CELLSPACING=1 CELLPADDING=2  class='l3'>
	<?
		$sk = mysql_query("SELECT wood.*,sklad.id as ids,sklad.iznos,sklad.iznos_max, count(*) as co FROM sklad LEFT JOIN wood ON wood.id=sklad.object_id WHERE sklad.owner='".$db["id"]."' and sklad.object_type='wood' GROUP by object_id");
		while($sk_dat = mysql_fetch_assoc($sk))
		{
			$n=(!$n);
		    $name = $sk_dat["name"];
	    	$img = $sk_dat["img"];
	    	$item_id = $sk_dat["ids"];
	    	$co = $sk_dat["co"];
	    	$mass = $sk_dat["mass"];
	    	$price = $sk_dat["price"];
	    	$price=sprintf ("%01.2f", $price);
	    	$iznos = $sk_dat["iznos"];
			$iznos_all = $sk_dat["iznos_max"];
	    	echo"<tr class='".($n?'l0':'l1')."'>
	    		<td width=150 valign=center align=center>
	    		<span style=\"position:relative;  width:60px; height:60px;\"><img src='img/".$img."' alt='".$name."'><small style='background-color: #E0E0E0; position: absolute; right: 1; bottom: 3;'><B>x".$co."</B></small>
	    		</span>
	    		<br>
	    		<A href=\"?to_box=$item_id&tmp=".md5(time())."\">В инвентарь</A>
	    		<br>
	    		<A href=\"?to_box_all=$item_id&tmp=".md5(time())."\">Все</A>
	    		<br>
	    		</td><td valign=top>
	    		<b>".$name."</b> (Масса: ".$mass.")<BR>
	    		<b>Цена: ".$price." Зл.</b><BR>
	    		Долговечность:$iznos/$iznos_all
	    		</td></tr>";
		}
		if(!mysql_num_rows($sk))echo "<tr class='l0'><td colspan=2 align=center>ПУСТО</td></tr>";

		mysql_free_result($sk);
	?>
	</TABLE>
</TD>
<TD valign=top>
	<TABLE WIDTH=100% CELLSPACING=1 CELLPADDING=2  class='l3'>
	<?
		$S = mysql_query("SELECT wood.*,inv.id as ids,inv.iznos,inv.iznos_max, count(*) as co FROM inv LEFT JOIN wood ON wood.id=inv.object_id WHERE inv.owner='".$login."' and inv.object_type='wood'  GROUP by object_id");
		while($DAT = mysql_fetch_assoc($S))
		{
			$n=(!$n);
		    $name = $DAT["name"];
	    	$img = $DAT["img"];
	    	$item_id = $DAT["ids"];
	    	$co = $DAT["co"];
	    	$mass = $DAT["mass"];
	    	$price = $DAT["price"];
	    	$price=sprintf ("%01.2f", $price);
	    	$iznos = $DAT["iznos"];
			$iznos_all = $DAT["iznos_max"];
	    	echo "<tr class='".($n?'l0':'l1')."'>
	    		<td width=150 valign=center align=center>
				<span style=\"position:relative;  width:60px; height:60px;\"><img src='img/".$img."' alt='".$name."'><small style='background-color: #E0E0E0; position: absolute; right: 1; bottom: 3;'><B>x".$co."</B></small>
	    		</span>
	    		<br>
	    		<A href=\"?from_box=$item_id&tmp=".md5(time())."\">В сундук</A>
	    		<br>
	    		<A href=\"?from_box_all=$item_id&tmp=".md5(time())."\">Все</A>
	    		<br>
	    		</td><td valign=top>
	    		<b>".$name."</b> (Масса: ".$mass.")<BR>
	    		<b>Цена: ".$price." Зл.</b><BR>
	    		Долговечность:$iznos/$iznos_all
	    		</td></tr>";
		}
		if(!mysql_num_rows($S))echo "<tr class='l0'><td colspan=2 align=center>ПУСТО</td></tr>";
		mysql_free_result($S);
	?>
	</TABLE>
</TD>
</TR>		
</TABLE><br>