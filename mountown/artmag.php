<?
$login=$_SESSION['login'];
$city=$db["city_game"];
$ip=$db["remote_ip"];

$buy=(int)($_GET['buy']);

if (isset($_GET['otdel']))
{	
	$otdel=htmlspecialchars(addslashes($_GET['otdel']));
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
<div id=hint4></div>
<?
if(isset($_GET['buy']))
{
	$q=mysql_query("SELECT * FROM scroll where id='".$item."' and mountown>0 and art=1");
	$r=mysql_fetch_array($q);
	if(!$r)
	{
		$msg="���� �� ������� � ��������.";
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
		if ($r["type"]=="scroll" || $r["type"]=="dragon")
		{	
			if (isset($item_count) && $item_count>0)
			{
				$price=$price*$item_count;
				$counts=$item_count;
			}
			if ($db["platina"]<$price)
			{
				$msg="� ��� ��� ����� �����!";
			}
			else 
			{
				for ($i=0;$i<$counts;$i++) 
				{
					mysql_query("LOCK TABLES inv WRITE");
					mysql_query("INSERT INTO inv(owner,object_id,object_type,object_razdel,wear,iznos,iznos_max,term) VALUES ('".$login."','".$item."','scroll','magic','0','0','".$i_max."','".$del_time."')");
					mysql_query("UNLOCK TABLES");
				}
				mysql_query("UPDATE users, scroll SET users.platina=users.platina-$price, scroll.".$city."=scroll.".$city."-".$counts." WHERE users.login='".$login."' and scroll.id='".$item."'");
				$db["platina"]=$db["platina"]-$price;
				$msg="�� ������ ������ ".($item_count?$counts.' �� ':'')." <b>&laquo;".$name."&raquo;</b> �� <b>".$price." ��.</b>";
				history($login,'����� '.($item_count?$counts.' �� ':''),$msg,$ip,'������� �����');
			}
		}
		else if ($r["type"]=="ability")
		{
			if ($db["clan"] && $db["glava"])
			{
				if ($db["platina"]>=$price_gos)
				{
					$have=mysql_num_rows(mysql_query("SELECT * FROM abils WHERE tribe='".$db["clan"]."' and item_id='".$item."'"));
					if (!$have)
					{	
						mysql_query("INSERT INTO abils (item_id,tribe, m_iznos) values ('".$r["id"]."','".$db["clan"]."','".$r["iznos_max"]."')");
						mysql_query("UPDATE users SET platina=platina-$price_gos WHERE login='".$login."'");
						mysql_query("UPDATE scroll SET $city=$city-1 WHERE id='".$item."'");
						$db["platina"]=$db["platina"]-$price_gos;
						$msg="�� ������ ������ <b>&laquo;$name&raquo;</b> �� <b>".$price." ��.</b>";
						history($login,"����� ",$msg,$ip,'������� �����');
					}
					else $msg="�� ��� ������ $name";
				}
				else $msg="� ��� ��� ����� �����!";
			}
			else $msg="�� �� �������� �� � ����� �����!";
		}
		$otdel=$buy;
	}
}				
$money = sprintf ("%01.2f", $db["money"]);
$platina = sprintf ("%01.2f", $db["platina"]);
?>	
<h3>��������� �������</h3>
<table border=0 width=100%>
<tr>
	<td colspan=2>
	<table width=100%><tr>
		<td><font color=#ff0000><?=$msg?>&nbsp;</font></td>
		<td align=right nowrap>	
			� ��� � �������: <B><?echo $money;?></b> ��. <b><?echo $platina;?></b> ��.
		</td>
	</tr></table>
	</td>
</tr>
<tr>
<td width=180 valign=top>
	<table width=100% cellspacing=1 cellpadding=3 class="l3">
		<tr><td align="center"><b>���������� ������</b></td></tr>
	</table>
	<br>
	<table class="l3" width="180" cellspacing="1" cellpadding="3">
    <tr class="l0">
        <td>
			<INPUT type=button style="width:100%; cursor:hand" onclick="location.href='main.php?act=go&level=magicstore'" value="���������" class="newbut">	
        </td>
    </tr>
	</table>
	<br>	  	  
	<table class="l3" width="180" cellspacing="1" cellpadding="3">
    <tr class="l0">
        <td>
        		&nbsp;<a href='?otdel=0'>�����</a><br>
    			&nbsp;<a href='?otdel=8'>��������</a><br>
    			&nbsp;<a href='?otdel=9'>��������</a><br>
    			&nbsp;<a href='?otdel=10'>�������� ��������</a><br>
        		&nbsp;<a href='?otdel=1'>��������������</a><br>
        		&nbsp;<a href='?otdel=2'>����������</a><br>
        		&nbsp;<a href='?otdel=3'>�����������</a><br>
        		&nbsp;<a href='?otdel=4'>������</a><br>
        </td>
    </tr>
	</table>
	<br>	  	  
	<table class="l3" width="180" cellspacing="1" cellpadding="3">
    <tr class="l0">
        <td>
        		&nbsp;<a href='?otdel=6'>��������</a><br>
        		&nbsp;<a href='?otdel=7'>��� ��� ��������</a><br>
        </td>
    </tr>
	</table>
	<br>
	<table class="l3" width="180" cellspacing="1" cellpadding="3">
    <tr class="l0">
        <td>
				&nbsp;<a href='?otdel=5'>�������� �������</a><br>
				&nbsp;<a href='?otdel=11'>�������</a><br>
        </td>
    </tr>
	</table>
	<img src="img/index/magic.gif">	
</td>
<td valign=top width=100%>
	<TABLE width=100% cellspacing=1 cellpadding=5 class="l3">
	<tr>
		<td valign=center align=center colspan=2>
			<b>�����: "<?
			switch ($otdel)
			{
				case 0:echo "�����";break;
				case 1:echo "��������������";break;
				case 2:echo "����������";break;
				case 3:echo "�����������";break;
				case 4:echo "������";break;
				case 5:echo "�������� �������";break;
				case 6:echo "��������";break;
				case 7:echo "��� ��� ��������";break;
				case 8:echo "��������";break;
				case 9:echo "��������";break;
				case 10:echo "�������� ��������";break;
				case 11:echo "�������";break;
			}
			?>"
			</B>
		</td>
	</tr>
	<?
	$sql="SELECT * FROM scroll WHERE otdel='".$otdel."' and mountown>0 and art=1 ORDER BY min_level ASC, price ASC";
	$seek = mysql_query($sql);
	if (mysql_num_rows($seek))
	{
		while ($dat = mysql_fetch_array($seek))
		{
			$n=(!$n);
			$orden=$db["orden"];
			$id=$dat["id"];
			$name=$dat["name"];
			$img=$dat["img"];
			$type=$dat["type"];
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
			
			echo "<TR class='".($n?'l0':'l1')."'><TD valign=center align=center width=150>
			<img src='img/".$img."' alt='".$name."'><BR>
			<a href='?buy=".$otdel."&item=".$id."&rnd=".md5(rand())."' >������</a>&nbsp;
			<img src='img/index/count.gif' style='CURSOR: Hand' alt='������ ��������� ��.' onclick=\"countitems('������ ��������� ��. :', '?buy=$otdel&item=$id', '$name', '5')\"> ";
			if ($db['adminsite']>=1)
			{
				echo "<br><a href='editmagic.php?item=$id' target='_blank'>edit</a>";
			}
			echo "</td>
			<td valign=top><b>$name</b> ".($artovka?"<img src='img/icon/artefakt.gif' border=0 alt=\"��������\">":"");
			if($need_orden!=0)
			{
				switch ($need_orden) 
				{
					 case 1:$orden_dis = "������ �������";break;
					 case 2:$orden_dis = "�������";break;
				 	 case 3:$orden_dis = "����� ����������";break;
				 	 case 4:$orden_dis = "����� �����";break;
				 	 case 5:$orden_dis = "�������� ����������";break;
				 	 case 6:$orden_dis = "�������� ����";break;
				}
				echo "&nbsp; <img src='img/orden/".$need_orden."/0.gif' border=0 alt='��������� �����:\n".$orden_dis."'>";
			}
			echo "&nbsp;(�����: $mass)<br>";
			$my_money=($artovka?$db["platina"]:$db["money"]);
			echo "<b>����: ".($price>$my_money?"<font color=red>":"").$price_gos."</font>".($artovka?" ��.":" ��.")."</b> <small>(����������: $nums)</small><BR>
			�������������: 0/$iznos_max<br>";
			if($del_time)
			{
				echo "���� ��������: $del_time ��.<BR>";
			}
			echo "<table width=100%><tr><td valign=top><B>��������� �����������:</B><BR>";
			if($min_i)
			{
				echo "&bull; ".($min_i>$db["intellekt"]?"<font color=red>":"")."���������: $min_i</font><BR>";
			}
			if($min_v)
			{
				echo "&bull; ".($min_v>$db["vospriyatie"]?"<font color=red>":"")."�����������: $min_v</font><BR>";
			}
			echo "&bull; ".($min_level>$db["level"]?"<font color=red>":"")."�������: $min_level</font><BR>";
			if($need_mn)
			{
				echo "&bull; ���. ����: ".$need_mn."<BR>";
			}
			if($school)
			{
				switch ($school) 
				{
					 case "air":$school_d = "������";break;
					 case "water":$school_d = "����";break;
				 	 case "fire":$school_d = "�����";break;
				 	 case "earth":$school_d = "�����";break;
				}
				echo "&bull; ������: <b>".$school_d."</b><BR>";
			}
			if ($type=="animal")
			{
				echo "&bull; ��������� ���������: �� �������";
			}
			if(!empty($desc))
			{
				echo "<br><font color=brown>�������� ��������:</font> ".str_replace("\n","<br>",$desc)."<BR>";
			}
			if($to_book)echo "<small><font color=brown>������������ ����� ����� ������ � ���</font></small>";
			
			echo "</td></tr></table>";
		}
	}
	else echo "<tr class='l0' align=center><td><b>�������� �������� ������...</b></td></tr>";
	?>
</td>
</tr>
</table>

</td>
</tr>
<table>
<br><br><br><br>
<?include_once("counter.php");?>