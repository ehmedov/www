<?
echo "<table width=100% cellspacing=1 cellpadding=2 class='l3'>";
$item_sell=mysql_query("SELECT scroll.*, inv.id as ids, inv.iznos, inv.iznos_max, inv.term, inv.gift, inv.gift_author,inv.podzemka FROM inv LEFT JOIN scroll on scroll.id=inv.object_id WHERE inv.owner='".$login."' and inv.object_razdel='magic' and inv.wear=0 ORDER BY UNIX_TIMESTAMP(inv.date) DESC");
if(mysql_num_rows($item_sell)==0)
{
	echo "<tr align='center' class='l0'><td><b>� ��� ��� �����, ������� ����� �������</b></td></tr>";
}
else 
{
	while($query=mysql_fetch_array($item_sell))
	{
		$n=(!$n);
		$pal_price=round(0.75*$query["price"]);
		
		$money_type="��.";
		if ($query["art"])$money_type="��.";
		$price=($pal_price*($query["iznos_max"]-$query["iznos"]))/$query["iznos_max"];
		$price=round($price,2);
		if ($price<0)$price=0;
		if ($query["gift"])$price=0;
		if ($query["podzemka"])$price=0;
		$price = sprintf ("%01.2f", $price);
		$db["vip"]=0;
		echo "<tr class='".($n?'l0':'l1')."'>
		<td width=180 valign=center align=center><img src='img/".$query["img"]."'><br>";
		echo "<a href='#' onclick=\"prodaja('".$query["ids"]."', '".$query["name"]."');\">������� �� $price $money_type</a>";
		echo "</td>
		<td valign=top><b>".$query["name"]."</b> ".($query["art"]?"<img src='img/icon/artefakt.gif' border=0 alt=\"��������\">":"").($query["gift"]?"&nbsp;<img src='img/icon/gift.gif' border=0 alt=\"������� �� ".$query["gift_author"]."\">":"");
		if($query["need_orden"]!=0)
		{
			switch ($query["need_orden"]) 
			{
				 case 1:$orden_dis = "������ �������";break;
				 case 2:$orden_dis = "�������";break;
			 	 case 3:$orden_dis = "����� ����������";break;
			 	 case 4:$orden_dis = "����� �����";break;
			 	 case 5:$orden_dis = "�������� ����������";break;
			 	 case 6:$orden_dis = "�������� ����";break;
			}
			echo "&nbsp; <img src='img/orden/".$query["need_orden"]."/0.gif' border=0 alt='��������� �����:\n".$orden_dis."'>";
		}
		echo "&nbsp;(�����: ".$query["mass"].")<br>";
		echo "<b>����: $price $money_type</b> (���. ����: ".sprintf ("%01.2f", $query["price"])." $money_type)<BR>
		�������������: ".$query["iznos"]."/".$query["iznos_max"]."<br>";
		if($query["del_time"])
		{
			echo "���� ��������: ".$query["del_time"]." ��. (�� ".(date('d.m.y H:i:s', $query["term"])).")<BR>";
		}
		echo "<table width=100%><tr><td valign=top>";
		if ($query["min_intellekt"] || $query["min_vospriyatie"] || $query["min_level"] || $query["mana"])echo "<B>��������� �����������:</B><BR>";
		if($query["min_intellekt"])
		{
			echo "&bull; ".($query["min_intellekt"]>$db["intellekt"]?"<font color=red>":"")."���������: ".$query["min_intellekt"]."</font><BR>";
		}
		if($query["min_vospriyatie"])
		{
			echo "&bull; ".($query["min_vospriyatie"]>$db["vospriyatie"]?"<font color=red>":"")."�����������: ".$query["min_vospriyatie"]."</font><BR>";
		}
		if ($query["min_level"]>0)
		{	
			echo "&bull; ".($query["min_level"]>$db["level"]?"<font color=red>":"")."�������: ".$query["min_level"]."</font><BR>";
		}
		if($query["mana"])
		{
			echo "&bull; ���. ����: ".$query["mana"]."<BR>";
		}
		if($query["school"])
		{
			switch ($query["school"]) 
			{
				 case "air":$school_d = "������";break;
				 case "water":$school_d = "����";break;
			 	 case "fire":$school_d = "�����";break;
			 	 case "earth":$school_d = "�����";break;
			}
			echo "&bull; ������: <b>".$school_d."</b><BR>";
		}
		if ($query["type"]=="animal")
		{
			echo "&bull; ��������� ���������: �� �������";
		}
		if(!empty($query["descs"]))
		{
			echo "<br><font color=brown>�������� ��������:</font> ".str_replace("\n","<br>",$query["descs"])."<BR>";
		}
		if($query["to_book"])echo "<small><font color=brown>������������ ����� ����� ������ � ���</font></small>";
		echo "</td></tr></table>";		
		
		echo "</td></tr>";
	}
}
echo "</table>";
?>