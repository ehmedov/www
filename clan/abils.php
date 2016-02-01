<script>
	function up(id,price)
	{
		if(confirm('Увеличит количество использований на +5 за '+price+' рейтинг?'))
		{
			location.href = '?act=clan&do=5&action=up&spell='+id;
		}
	}
</script>
<?
if ($_GET['action']=="magic")
{
	$spell=(int)abs($_GET['spell']);
	$sql="SELECT abils.*, spell.files,spell.name FROM abils,(SELECT id,files,name FROM scroll WHERE id=$spell) as spell WHERE tribe='".$db["clan"]."' and abils.item_id=spell.id";
	$a=mysql_fetch_array(mysql_query($sql));
	if (!$a)
	{
		$errmsg="Свиток не найден!";
	}
	else
	{	
		$name=$a["name"];
		if ($a["c_iznos"]<$a["m_iznos"])include "magic/$a[files]";
		else $errmsg="Данный реликт на сегодня исчерпан!";
	}
	
}
else if ($_GET['action']=="up")
{
	if($db["glava"])
	{	
		$spell=(int)abs($_GET['spell']);
		$sql=mysql_query("SELECT * FROM abils WHERE tribe='".$db["clan"]."' and item_id='".$spell."'");
		$res=mysql_fetch_array($sql);
		if ($res)
		{
			if ($res["m_iznos"]>45)$price_oc=20000;
			else if ($res["m_iznos"]>40)$price_oc=10000;
			else if ($res["m_iznos"]>35)$price_oc=7000;
			else if ($res["m_iznos"]>30)$price_oc=5000;
			else if ($res["m_iznos"]>25)$price_oc=3000;
			else if ($res["m_iznos"]>20)$price_oc=2000;
			else $price_oc=1000;
			
			if(($SITED['ochki']-$price_oc)>0)
			{
				if ($res["m_iznos"]<50)
				{
					mysql_query("UPDATE abils SET m_iznos=m_iznos+5 WHERE tribe='".$db["clan"]."' and item_id='".$spell."'");
					mysql_query("UPDATE clan SET ochki=ochki-$price_oc WHERE name='".$db["clan"]."'");
					$SITED['ochki']=$SITED['ochki']-$price_oc;
					$errmsg="Увеличено количество использований на +5 за ".$price_oc." рейтинг.";
				}
				else $errmsg="У вас максимальный износ!";
			}
			else $errmsg="Рейтинга не хватает $price_oc!";
		}
		else $errmsg="Свиток не найден!";
	}
}
//--------------------------------------------------------------------
echo '
<b style="color:#ff0000">'.$errmsg.'</b><BR>
<FIELDSET style="width:600px; border:1px outset;">
<LEGEND><B>Список абилок</B> </LEGEND>';
	$_abil=mysql_query("SELECT * FROM abils where tribe='".$db["clan"]."'");
	for ($i=0; $i<mysql_num_rows($_abil); $i++) 
	{
		$abil=mysql_fetch_array($_abil);
		if ($abil["m_iznos"]>45)$price_oc=20000;
		else if ($abil["m_iznos"]>40)$price_oc=10000;
		else if ($abil["m_iznos"]>35)$price_oc=7000;
		else if ($abil["m_iznos"]>30)$price_oc=5000;
		else if ($abil["m_iznos"]>25)$price_oc=3000;
		else if ($abil["m_iznos"]>20)$price_oc=2000;
		else $price_oc=1000;
		$iteminfo=mysql_fetch_array(mysql_query("SELECT * FROM scroll where id='".$abil["item_id"]."'")); // Получаем инфу о предмете

		echo "<A HREF=\"JavaScript:UseMagick('".$iteminfo["name"]."','?act=clan&do=5&action=magic&spell=".$iteminfo["id"]."', '".$iteminfo["img"]."', '', '15', '', '5')\" title='Прочитать это заклинание.'>";
		echo "<img src='img/".$iteminfo["img"]."'></a> ".$iteminfo["name"]." [осталось на сегодня ".$abil["c_iznos"]." из ".$abil["m_iznos"]."] <img src='img/icon/plus.gif' style='cursor:hand' onclick=\"up('".$iteminfo["id"]."','".$price_oc."');\" alt='Увеличит количество использований на +5 за ".$price_oc." рейтинг'><br>";
	}
	if (!$i) echo  "У Вас нет не одной абилити!";
echo "</FIELDSET>";

?>