<?
//84,89	
$login=$_SESSION['login'];
$item_array=array();
##=========Runa Type 1==============================================
$item_array[1]=array(array("item"=>84,"count"=>5),array("item"=>89,"count"=>5),array("item"=>85,"count"=>5));
$item_array[2]=array(array("item"=>85,"count"=>5),array("item"=>88,"count"=>5),array("item"=>87,"count"=>5));
$item_array[3]=array(array("item"=>86,"count"=>5),array("item"=>87,"count"=>5),array("item"=>88,"count"=>5));
$item_array[4]=array(array("item"=>89,"count"=>5),array("item"=>85,"count"=>5),array("item"=>87,"count"=>5));

$item_array[5]=array(array("item"=>86,"count"=>5),array("item"=>89,"count"=>5),array("item"=>88,"count"=>5));
$item_array[6]=array(array("item"=>88,"count"=>5),array("item"=>87,"count"=>5),array("item"=>86,"count"=>5));
$item_array[7]=array(array("item"=>84,"count"=>5),array("item"=>85,"count"=>5),array("item"=>86,"count"=>5));
$item_array[8]=array(array("item"=>87,"count"=>5),array("item"=>88,"count"=>5),array("item"=>89,"count"=>5));

$item_array[9]=array(array("item"=>84,"count"=>5),array("item"=>85,"count"=>5),array("item"=>86,"count"=>5),array("item"=>87,"count"=>5));
$item_array[10]=array(array("item"=>86,"count"=>5),array("item"=>87,"count"=>5),array("item"=>88,"count"=>5),array("item"=>89,"count"=>5));

##=========Runa Type 2==============================================
$item_array[11]=array(array("item"=>133,"count"=>100),array("item"=>134,"count"=>200),array("item"=>135,"count"=>200));
$item_array[12]=array(array("item"=>134,"count"=>200),array("item"=>135,"count"=>100),array("item"=>136,"count"=>200));
$item_array[13]=array(array("item"=>133,"count"=>100),array("item"=>135,"count"=>200),array("item"=>137,"count"=>200));
$item_array[14]=array(array("item"=>135,"count"=>200),array("item"=>136,"count"=>100),array("item"=>138,"count"=>200));

$item_array[15]=array(array("item"=>133,"count"=>200),array("item"=>134,"count"=>200),array("item"=>135,"count"=>200));
$item_array[16]=array(array("item"=>134,"count"=>200),array("item"=>135,"count"=>200),array("item"=>136,"count"=>200));
$item_array[17]=array(array("item"=>135,"count"=>200),array("item"=>136,"count"=>200),array("item"=>137,"count"=>200));
$item_array[18]=array(array("item"=>136,"count"=>200),array("item"=>137,"count"=>200),array("item"=>138,"count"=>200));

$item_array[19]=array(array("item"=>137,"count"=>200),array("item"=>138,"count"=>200),array("item"=>134,"count"=>200),array("item"=>136,"count"=>200));
$item_array[20]=array(array("item"=>138,"count"=>200),array("item"=>133,"count"=>200),array("item"=>135,"count"=>200),array("item"=>137,"count"=>200));
##==================================================================

if ($_GET["take"])
{
	$take=(int)$_GET["take"];
	$runa=mysql_fetch_array(mysql_query("SELECT * FROM runa WHERE id=".$take));
	if($runa)
	{
		if (count($item_array[$take]))
		{
			$a=array();
			foreach ($item_array[$take] as $currentValue)
			{
				$sql_query="SELECT wood.name,(SELECT count(*) FROM inv WHERE inv.object_type='wood' and inv.owner='".$login."' and inv.object_id=wood.id) as counts FROM wood WHERE  wood.id=".$currentValue["item"];
				$query=mysql_fetch_Array(mysql_query($sql_query));
				if ($query["counts"]<$currentValue["count"]) 
				{
					$msg.="<font color=#ff0000>Ќе хватает: ".$query["name"]." - ".($currentValue["count"]-$query["counts"])." штук...</font><br>";
					$a[]=0;
				}
				else $a[]=1; 
			}
			if (!in_Array(0,$a))
			{
				foreach ($item_array[$take] as $currentValue)
				{
					mysql_query("DELETE FROM inv WHERE inv.object_type='wood' and inv.owner='".$login."' and inv.object_id=".$currentValue["item"]." LIMIT ".$currentValue["count"]);
				}
				mysql_query("INSERT INTO `inv` (`owner`, `object_id`, `object_type`, `object_razdel` ,`iznos`,  `iznos_max`) VALUES 	('".$login."', '".$take."','runa','runa','0','1');");
				$msg= "¬ы получили руну <b>".$runa['name']."</b>.";
			}
		}
	}
}
?>
<table width=100% border="0" cellpadding=0 cellspacing=0>
<tr>
	<td colspan=2><h3> ристальный зал</h3></td>
</tr>
<tr>
	<td width=100%><font color=#ff0000><?=$msg?></font></td>
	<td nowrap valign=top>
		<input type=button value='¬ернутьс€' class=newbut onclick="document.location='main.php?act=go&level=crypt_go'">
		<input type=button value='ќбновить'  class=newbut onClick="location.href='?act=none'">
	</td>
</tr>
</table>
<table border="0" cellpadding=0 cellspacing=0 width="600" align=center>
<tr>
	<td>
	<small>√овор€т, что эти руны - €зык богов, и только они могут создавать подобные камни, а воспроизводить начертание могут лишь единицы. 
	¬ыбить руну на предмете может каждый, но только алхимик - мастер своего дела сделает это с нужной каллиграфической точностью и передаст вещи магию руны. 
	ѕосле подобного процесса камень с руной разрушаетс€. 	</td>
</tr>	
</table>	
<table border="0" cellpadding=0 cellspacing=0 width="600" height="406" background="img/index/back.jpg" align=center>
<tr>
	<td align=center valign=top><br>
		<?
			$sql=mysql_query("SELECT * FROM `runa` WHERE id<11");
			while ($runas=mysql_fetch_array($sql))
			{
				$i++;
				$str="<a>".$runas["name"]."</a>";
				$str.="&nbsp;(ћасса: ".$runas["mass"].")<br>";
				$str.="<b>÷ена: ".$runas["price"]." «л.</b>";
				$str.="<BR>ƒолговечность: 0/1<BR>";
				$str.="<b>“ребуетс€ минимальное:</b><BR>";
				$str.="”ровень: ".$runas['min_level']."<BR><BR>";

				$str.="<b>ƒействует на:</b><BR>";
				$str.=(($runas['add_sila']>0)?"Х —ила: +{$runas['add_sila']}<BR>":"");
				$str.=(($runas['add_lovkost']>0)?"Х Ћовкость: +{$runas['add_lovkost']}<BR>":"");
				$str.=(($runas['add_udacha']>0)?"Х ”дача: +{$runas['add_udacha']}<BR>":"");
				$str.=(($runas['add_intellekt']>0)?"Х »нтеллект: +{$runas['add_intellekt']}<BR>":"");
				$str.=(($runas['add_hp'])?"Х ”ровень жизни: +{$runas['add_hp']}<BR>":"");
				$str.=(($runas['add_mana'])?"Х ”ровень маны: +{$runas['add_mana']}<BR>":"");
				
				$str.=(($runas['add_krit'])?"Х ћф. критических ударов: {$runas['add_krit']}%<BR>":"");
				$str.=(($runas['add_akrit'])?"Х ћф. против крит. ударов: {$runas['add_akrit']}%<BR>":"");
				$str.=(($runas['add_uvorot'])?"Х ћф. увертывани€: {$runas['add_uvorot']}%<BR>":"");
				$str.=(($runas['add_auvorot'])?"Х ћф. против увертывани€: {$runas['add_auvorot']}%<BR>":"");

				$str.=(($runas['ms_krit'])?"Х ћф. мощности крит. удара: {$runas['ms_krit']}%<BR>":"");
				$str.=(($runas['parry'])?"Х ћф. парировани€: {$runas['parry']}%<BR>":"");
				$str.=(($runas['counter'])?"Х ћф. контрудара: {$item_Array['counter']}%<BR>":"");
				
				$str.=(($runas['protect_udar'])?"Х «ащита от урона: +{$runas['protect_udar']}%<BR>":"");
				$str.=(($runas['protect_mag'])?"Х «ащита от магии: +{$runas['protect_mag']}%<BR>":"");
				$str.=(($runas['ms_udar'])?"Х ћф. мощности урона: +{$runas['ms_udar']}%<BR>":"");
				$str.=(($runas['ms_mag'])?"Х ћф. мощности магии стихий: +{$runas['ms_mag']}%<BR>":"");


				$str.="<hr>";
				if (count($item_array[$runas["id"]]))
				{	
					foreach ($item_array[$runas["id"]] as $currentValues)
					{
						$query=mysql_fetch_Array(mysql_query("SELECT img FROM wood WHERE id=".$currentValues["item"]));
						$str.="<img src=img/".$query["img"]."> - ".$currentValues["count"]." шт. ";
					}
				}
				if(($i % 7) == 0) echo "\n<br>\n";
				echo "\n<img src='img/".$runas["img"]."' onmouseover=\"slot_view('".$str."');\" onmouseout=\"slot_hide();\" style='cursor:hand;' onclick=\"document.location='?take=".$runas["id"]."'\"> ";
			}	
		?>
	</td>
</tr>
</table>