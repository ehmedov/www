<?
$now=time();
$take=(int)$_GET["take"];
$login=$_SESSION['login'];
$ip=$db["remote_ip"];
##==============================================================================
$kvest_text=array();
$kvest_text[0]="Вам необходимо найти";
$kvest_text[1]="Тщеславия ради, Вам следует отыскать";
$kvest_text[2]="Неизвестно зачем, Вы должны хорошенько постараться, чтобы собрать";
$kvest_text[3]="Вам следует поднапрячься, и найти";
$kvest_text[4]="Вопреки всем усмешкам, Вы должны хорошенько постараться, чтобы найти";
$kvest_text[5]="Чтобы отстоять свою честь и достоинство, Вам следует поискать";
$kvest_text[6]="Чтобы что-то сделать, сначала нужно что-то найти..., Вам необходимо найти";
$kvest_text[7]="Для бесчеловечных экспериментов лекарей города, Вам следует набраться храбрости и доставить";
$kvest_text[8]="Мы уже видели вашу силу..вас ждет новая тяжка..борьба за лучшое место..не боясь Монстров одалея их силы от вас требуется  доставить";
$kvest_text[9]="Продолжается Борьба за ценные камни... от вас требуется храбрости сразиться с монстрами и добыть";

$items=array(118,119,120,121,122,123,124,125,126,127,128,129,120,131,132);
$items_count=array(10, 15, 20, 25, 30, 35, 40, 45, 50, 55, 60);
#$add_naqrada=array(100, 200, 300, 400, 500, 600, 700, 800, 900, 1000);
$add_naqrada[1]=array(100, 150, 200, 250, 300, 350);
$add_naqrada[2]=array(400, 450, 500, 550, 600, 650);
$add_naqrada[3]=array(700, 750, 800, 850, 900, 950);
##==============================================================================
if($_GET["action"]=="get_qwest")
{
	if ($db["kwest"]>=60)
	{	
		$have_qwest=mysql_fetch_Array(mysql_query("SELECT * FROM qwest WHERE owner='".$db["id"]."' and status=0"));
		if (!$have_qwest)
		{
			shuffle($items);
			$count_items=mt_Rand(1,3);
			for( $i=0; $i<$count_items; $i++ )
			{
				$r = mt_rand( 0, sizeof($items)-1 ); // generate random key
				if( isset($trio) )
				{
					if( in_array($items["$r"], $trio) )
					{
						--$i;
					}
					else
					{
						$trio[] = $items["$r"];
					}
				}
				else
				{
					$trio[] = $items["$r"];
				}
			}
			$item1=(int)$trio[0]; $col1=(int)$items_count[rand(0,count($items_count)-1)];
			$item2=(int)$trio[1]; $col2=(int)$items_count[rand(0,count($items_count)-1)];
			$item3=(int)$trio[2]; $col3=(int)$items_count[rand(0,count($items_count)-1)];
			$add_qwest_naqrada=(int)$add_naqrada[$count_items][rand(0,count($add_naqrada)-1)];
			$add_text=mt_rand(0,9);
			mysql_query("LOCK TABLES qwest WRITE");
			mysql_query("INSERT INTO qwest VALUES (null,".$db["id"].", $add_text, $add_qwest_naqrada, 0, $item1, $item2, $item3, $col1, $col2, $col3)");
			mysql_query("UNLOCK TABLES");
			$msg="Вы только что получили новое задание";
		}
	}
	else $msg="На данный момент вами не было заверщенно прохождение всех Квестов в <b>\"Проклятый Клад (Этаж 1)\"</b>.";
}
##==============================================================================
if($_GET["action"]=="get_bonus")
{
	$all_have=array();
	$all_count=0;
	$have_qwest=mysql_fetch_Array(mysql_query("SELECT * FROM qwest WHERE owner='".$db["id"]."' and status=0"));
	if ($have_qwest)
	{
		if($have_qwest["item1"])
		{
			$all_count++;
			$item1=mysql_fetch_array(mysql_query("SELECT name FROM wood WHERE id='".$have_qwest["item1"]."'"));
			$obj1 = mysql_fetch_array(mysql_query("SELECT count(*) FROM inv WHERE owner='".$login."' AND object_id=".$have_qwest["item1"]." and object_type='wood'"));
			if ($obj1[0]<$have_qwest["col1"])
			{
				$msg.="Не хватает: ".$item1["name"]." - ".(int)($have_qwest["col1"]-$obj1[0])." штук...<br>";
			}
			else $all_have[]=$have_qwest["item1"];
		}
		if($have_qwest["item2"])
		{
			$all_count++;
			$item2=mysql_fetch_array(mysql_query("SELECT name FROM wood WHERE id='".$have_qwest["item2"]."'"));
			$obj2 = mysql_fetch_array(mysql_query("SELECT count(*) FROM inv WHERE owner='".$login."' AND object_id=".$have_qwest["item2"]." and object_type='wood'"));
			if ($obj2[0]<$have_qwest["col2"])
			{
				$msg.="Не хватает: ".$item2["name"]." - ".(int)($have_qwest["col2"]-$obj2[0])." штук...<br>";
			}
			else $all_have[]=$have_qwest["item2"];
		}
		if($have_qwest["item3"])
		{
			$all_count++;
			$item3=mysql_fetch_array(mysql_query("SELECT name FROM wood WHERE id='".$have_qwest["item3"]."'"));
			$obj3 = mysql_fetch_array(mysql_query("SELECT count(*) FROM inv WHERE owner='".$login."' AND object_id=".$have_qwest["item3"]." and object_type='wood'"));
			if ($obj3[0]<$have_qwest["col3"])
			{
				$msg.="Не хватает: ".$item3["name"]." - ".(int)($have_qwest["col3"]-$obj3[0])." штук...<br>";
			}
			else $all_have[]=$have_qwest["item3"];
		}
		if ($all_count==count($all_have))
		{
			mysql_query("UPDATE users SET naqrada=naqrada+".$have_qwest["add_naqrada"]." WHERE login='$login'");
			mysql_query("UPDATE qwest SET status=1 WHERE id=".$have_qwest["id"]);
			mysql_Query("DELETE FROM inv WHERE owner='".$login."' AND object_id=".$have_qwest["item1"]." and object_type='wood'");
			if($have_qwest["item2"])mysql_Query("DELETE FROM inv WHERE owner='".$login."' AND object_id=".$have_qwest["item2"]." and object_type='wood'");
			if($have_qwest["item3"])mysql_Query("DELETE FROM inv WHERE owner='".$login."' AND object_id=".$have_qwest["item3"]." and object_type='wood'");
			$msg="Поздравляю вы выполнили <b>Квест</b>, в честь этого вы получили бонус <b>".$have_qwest["add_naqrada"]." Ед. награды</b>.";
		}
	}
}
##==============================================================================
?>
<h3>Задания[Этаж 2]</h3>
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
	<td width="100%"><font color="#ff0000"><?=$msg?></font></td>
	<td nowrap>
		<input type="button" value="Вернуться" onclick="document.location='main.php?act=go&level=crypt_go'">
		<input type="button" value="Обновить" onClick="document.location.href='?act=none'">
	</td>
</tr>
</table>
<?
$res=mysql_fetch_Array(mysql_query("SELECT * FROM qwest WHERE owner='".$db["id"]."' and status=0"));
if (!$res)
{
	echo "<input type=\"button\" style=\"background-color:#AA0000; color: white;\" value=\"Взять Задания\" onclick=\"document.location.href='?action=get_qwest'\">";
}
else
{
	echo "<b>У Вас есть незавершенное задание:</b><br><br>";
	echo $kvest_text[$res["desc"]]."<br/>";
	if($res["item1"])
	{
		$item1=mysql_fetch_array(mysql_query("SELECT name FROM wood WHERE id='".$res["item1"]."'"));
		echo "&bull; <b>".$item1["name"]."</b> в количестве ".$res["col1"]." штук.<br/>";
	}
	if($res["item2"])
	{
		$item2=mysql_fetch_array(mysql_query("SELECT name FROM wood WHERE id='".$res["item2"]."'"));
		echo "&bull; <b>".$item2["name"]."</b> в количестве ".$res["col2"]." штук.<br/>";
	}
	if($res["item3"])
	{
		$item3=mysql_fetch_array(mysql_query("SELECT name FROM wood WHERE id='".$res["item3"]."'"));
		echo "&bull; <b>".$item3["name"]."</b> в количестве ".$res["col3"]." штук.<br/>";
	}
	echo "<br>Вы получите: <b>".$res["add_naqrada"]." Ед.</b> награды.";
	echo "<center><input class='newbut' type='button' value='Получить бонус за Задания' onclick='window.location.href=\"?action=get_bonus\"'></center>";
}
?>