<?
$login=$_SESSION["login"];
$_SESSION["castle"]=0;
$getOwner = mysql_fetch_assoc(mysql_query("SELECT * FROM castle_config LEFT JOIN clan on clan.name_short=castle_config.owner"));
if ($getOwner['owner'] != '')
{
	$owner = '����� ����������� �����: '.($getOwner['orden']?'<img src="img/orden/'.$getOwner['orden'].'/0.gif"> ':'').'<a href="clan_inf.php?clan='.$getOwner['name_short'].'" target=_blank><img src=img/clan/'.$getOwner['name_short'].'.gif align=midle></a> '.$getOwner['name'].'';
}
else 
{
	$owner = '� ������ ������ ����� ����� �� ������������.';
}
//***************************************************************************
if ($db['clan_short']!= $getOwner['owner'] && !$db["adminsite"])
{
	Header("Location: main.php?act=go&level=castle");
	die();
}
//***************************************************************************
$item_Array_str="(1064,1065,1066)";
$magic_Array_str="(229,230,231,232,233)";

$item_Array=array(1064,1065,1066);
$magic_Array=array(229,230,231,232,233);
$del_time=time()+7*24*60*60;
//***************************************************************************
if ($_GET["buy_magic"])
{
	$_POST['shop']=true;
	$_GET['otdel']="magic";
	$item_id=(int)$_GET["buy_magic"];
	$r=mysql_fetch_array(mysql_query("SELECT * FROM scroll where id='".$item_id."'"));
	if(!$r)
	{
		$msg="���� �� ������� � ��������.";
	}
	else
	{
		if ($_GET["type"]=="ed")
		{
			$my_money=$db["naqrada"];$m_type='naqrada';$m_txt="��.";
			$r["price"]=$r["price"]*10;
			$podzemka=1;
		}	
		else
		{
			if ($r["art"]){$my_money=$db["platina"];$m_type='platina';$m_txt="��.";}
			else {$my_money=$db["money"];$m_type='money';$m_txt="��.";}
		}
		$del_time= time() + $r["del_time"]*24*3600;
		$price_gos = $r["price"];
		$price = sprintf ("%01.2f", $price_gos);

		if ($my_money<$price)
		{
			$msg="� ��� ��� ����� �����!";
		}
		else 
		{
			mysql_query("LOCK TABLES inv WRITE");
			mysql_query("INSERT INTO inv(owner,object_id,object_type,object_razdel,iznos_max,term,podzemka) VALUES ('".$login."','".$item_id."','scroll','magic','".$r["iznos_max"]."','".$del_time."','".$podzemka."')");
			mysql_query("UNLOCK TABLES");
			mysql_query("UPDATE users SET $m_type=$m_type-$price WHERE login='".$login."'");
			if ($_GET["type"]=="ed")$db["naqrada"]=$db["naqrada"]-$price;
			else if ($r["art"])$db["platina"]=$db["platina"]-$price; else $db["money"]=$db["money"]-$price;
			$msg="�� ������ ������  <b>&laquo;".$r["name"]."&raquo;</b> �� <b>".$price." $m_txt</b>";
			history($login,'�����',$msg, $db["remote_ip"],'������� �����');
		}
	}
}
//***************************************************************************
if ($_GET["buy"])
{	
	$_POST['shop']=true;
	$item_id=(int)$_GET["buy"];
	if (!in_Array($item_id,$item_Array))
	{
		$msg="���� �� ������� � ��������.";
	}
	else
	{
		$buy_item=mysql_fetch_array(mysql_query("SELECT * FROM paltar WHERE id='".$item_id."'"));
		if ($_GET["type"]=="art"){$my_money=$db["platina"];$money_type='��.';}
		else {$my_money=$db["naqrada"];$buy_item["price"]=$buy_item["price"]*100;$money_type='��.';$buy_item["podzemka"]=1;}

		if(!$buy_item)
		{
			$msg="���� �� ������� � ��������.";
		}
		else if ($my_money<$buy_item["price"])
		{
			$msg="� ��� ��� ����������� ����� ��� ������� ���� ����!";
		}
		else
		{
			mysql_query("LOCK TABLES inv WRITE");
			mysql_query("INSERT INTO `inv` (`id`, `owner`, `img`, `object_id`, `object_type`, `object_razdel`, `name`, `term`,  `mass`, `price`, `gos_price`, `min_sila`, `min_lovkost`, `min_udacha`, `min_power`, `min_intellekt`, `min_vospriyatie`, `min_level`, `min_sword_vl`, `min_staff_vl`, `min_axe_vl`, `min_fail_vl`, `min_knife_vl`, `min_spear_vl`,`min_fire`,`min_water`,`min_air`,`min_earth`,`min_svet`,`min_tma`,`min_gray`,`add_fire`, `add_water`, `add_air`, `add_earth`, `add_svet`, `add_tma`, `add_gray`, `add_sila`, `add_lovkost`, `add_udacha`, `add_intellekt`, `add_duxovnost`, `add_hp`, `add_mana`, `protect_head`, `protect_arm`, `protect_corp`, `protect_poyas`, `protect_legs`, `protect_rej`, `protect_drob`, `protect_kol`, `protect_rub`, `protect_fire`, `protect_water`, `protect_air`, `protect_earth`, `protect_svet`, `protect_tma`, `protect_gray`,`protect_mag`,`protect_udar`, `shieldblock`, `krit`, `akrit`, `uvorot`, `auvorot`, `parry`, `counter`, `add_rej`, `add_drob`, `add_kol`, `add_rub`, `ms_udar`, `ms_krit`, `ms_mag`, `ms_fire`, `ms_water`, `ms_air`, `ms_earth`, `ms_svet`, `ms_tma`, `ms_gray`, `ms_rej`, `ms_drob`, `ms_kol`, `ms_rub`, `iznos_max`, `min_attack`, `max_attack`, `proboy`, `add_oruj`, `add_sword_vl`, `add_staff_vl`, `add_axe_vl`, `add_fail_vl`, `add_knife_vl`, `add_spear_vl`, `need_orden`, `sex`, `art`, `podzemka`, `is_personal`, `personal_owner`, `noremont`, `two_hand`, `second_hand`,  `add_fire_att`, `add_air_att`, `add_watet_att`, `add_earth_att`, `edited`) 
				VALUES (NULL, '".$login."','".$buy_item["img"]."' ,'".$buy_item["id"]."', '".$buy_item["object"]."', 'obj', '".$buy_item["name"]."','".$del_time."', '".$buy_item["mass"]."', '".$buy_item["price"]."', '".$buy_item["price"]."', '".$buy_item["min_sila"]."', '".$buy_item["min_lovkost"]."', '".$buy_item["min_udacha"]."', '".$buy_item["min_power"]."', '".$buy_item["min_intellekt"]."', '".$buy_item["min_vospriyatie"]."', '".$buy_item["min_level"]."', '".$buy_item["min_sword_vl"]."', '".$buy_item["min_staff_vl"]."', '".$buy_item["min_axe_vl"]."', '".$buy_item["min_fail_vl"]."', '".$buy_item["min_knife_vl"]."', '".$buy_item["min_spear_vl"]."', '".$buy_item["min_fire"]."','".$buy_item["min_water"]."','".$buy_item["min_air"]."','".$buy_item["min_earth"]."','".$buy_item["min_svet"]."','".$buy_item["min_tma"]."','".$buy_item["min_gray"]."', '".$buy_item["add_fire"]."', '".$buy_item["add_water"]."', '".$buy_item["add_air"]."', '".$buy_item["add_earth"]."', '".$buy_item["add_svet"]."', '".$buy_item["add_tma"]."', '".$buy_item["add_gray"]."', '".$buy_item["add_sila"]."', '".$buy_item["add_lovkost"]."', '".$buy_item["add_udacha"]."', '".$buy_item["add_intellekt"]."', '".$buy_item["add_duxovnost"]."', '".$buy_item["add_hp"]."', '".$buy_item["add_mana"]."', '".$buy_item["protect_head"]."', '".$buy_item["protect_arm"]."', '".$buy_item["protect_corp"]."', '".$buy_item["protect_poyas"]."', '".$buy_item["protect_legs"]."', '".$buy_item["protect_rej"]."', '".$buy_item["protect_drob"]."', '".$buy_item["protect_kol"]."', '".$buy_item["protect_rub"]."', '".$buy_item["protect_fire"]."', '".$buy_item["protect_water"]."', '".$buy_item["protect_air"]."', '".$buy_item["protect_earth"]."', '".$buy_item["protect_svet"]."', '".$buy_item["protect_tma"]."', '".$buy_item["protect_gray"]."', '".$buy_item["protect_mag"]."', '".$buy_item["protect_udar"]."','".$buy_item["shieldblock"]."','".$buy_item["krit"]."', '".$buy_item["akrit"]."', '".$buy_item["uvorot"]."', '".$buy_item["auvorot"]."', '".$buy_item["parry"]."', '".$buy_item["counter"]."', '".$buy_item["add_rej"]."', '".$buy_item["add_drob"]."', '".$buy_item["add_kol"]."', '".$buy_item["add_rub"]."', '".$buy_item["ms_udar"]."', '".$buy_item["ms_krit"]."', '".$buy_item["ms_mag"]."', '".$buy_item["ms_fire"]."', '".$buy_item["ms_water"]."', '".$buy_item["ms_air"]."', '".$buy_item["ms_earth"]."', '".$buy_item["ms_svet"]."', '".$buy_item["ms_tma"]."', '".$buy_item["ms_gray"]."', '".$buy_item["ms_rej"]."', '".$buy_item["ms_drob"]."', '".$buy_item["ms_kol"]."', '".$buy_item["ms_rub"]."', '".$buy_item["iznos_max"]."', '".$buy_item["min_attack"]."', '".$buy_item["max_attack"]."', '".$buy_item["proboy"]."','".$buy_item["add_oruj"]."' ,'".$buy_item["add_sword_vl"]."', '".$buy_item["add_staff_vl"]."', '".$buy_item["add_axe_vl"]."', '".$buy_item["add_fail_vl"]."', '".$buy_item["add_knife_vl"]."', '".$buy_item["add_spear_vl"]."', '".$buy_item["need_orden"]."', '".$buy_item["sex"]."', '".$buy_item["art"]."', '".$buy_item["podzemka"]."', '".$buy_item["is_personal"]."', '".$buy_item["personal_owner"]."', '".$buy_item["noremont"]."', '".$buy_item["two_hand"]."', '".$buy_item["second_hand"]."',  '".$buy_item["add_fire_att"]."', '".$buy_item["add_air_att"]."', '".$buy_item["add_watet_att"]."', '".$buy_item["add_earth_att"]."', '".$buy_item["edited"]."');");
			mysql_query("UNLOCK TABLES");
			if ($_GET["type"]=="art")
			{
				mysql_query("UPDATE users SET platina=platina-".$buy_item["price"]." WHERE login='".$login."'");
				$db["platina"]=$db["platina"]-$buy_item["price"];
			}
			else
			{
				mysql_query("UPDATE users SET naqrada=naqrada-".$buy_item["price"]." WHERE login='".$login."'");
				$db["naqrada"]=$db["naqrada"]-$buy_item["price"];
			}
			$msg="�� ������ ������ <b>&laquo;".$buy_item["name"]."&raquo;</b> �� <b>".$buy_item["price"]." $money_type</b> �� ������";
			history($login,'�����',$buy_item["name"]." �� ".$buy_item["price"]." $money_type",$db["remote_ip"],'������� �����');
		}
	}
}
//************************************************************
if (!$_GET['otdel'] && $_POST['shop'])$_GET['otdel']='obj';
if ($_GET['otdel'])$_POST['shop']=true;
//************************************************************
if  (isset($_POST['add_msg']) && isset($_POST['text']))
{	
	$_POST['castle_board']=true;
	$_POST['text'] = htmlspecialchars(addslashes(trim($_POST['text'])));
	if (strlen($_POST['text']) < 3)
	{
		$msg = '��������� �� ����� ���� ������ 3 ��������';
	}
	elseif ($db['glava'] != 1)
	{
		$msg = '� ��� ��� �� ��� ����!';
	}
	else 
	{
		mysql_query("INSERT INTO castle_board SET tribe = '".$db['clan_short']."', user_id = ".$db['id'].", msg = '".$_POST['text']."', time = ".time()."");
		$msg="��������� ���������!";
	}
}
//************************************************************
if ($_POST["hp_restore"])
{
	if($db["hp_all"] - $db["hp"]==0)
	{
		$msg="�� � ��� �������.";
	}
	else 
	{
		setHP($login,$db["hp_all"],$db["hp_all"]);
		$msg="�� ������ ������������ ���� ��������!";
	}
}
//*********************************************************
if ($_POST["mn_restore"])
{
	if($db["mana_all"] - $db["mana"]==0)
	{
		$msg="�� � ��� �������.";
	}
	else 
	{
		setMN($login,$db["mana_all"],$db["mana_all"]);
		$msg="�� ������ ������������ ���� ����!";
	}
}	
//*********************************************************
if ($_POST["lechit"])
{
	if($db["travm"]!=0)
    {
    	$t_stat = $db["travm_stat"];
		$o_stat = $db["travm_old_stat"];
		mysql_query("UPDATE users SET $t_stat=$t_stat+$o_stat,travm='0', travm_stat='', travm_var='', travm_old_stat='' WHERE login='".$login."'");
    	$msg="������ ��������...";
	}
	else
	{
		$msg="�� �� ������������!!!";
	}
}
//*********************************************************
echo "<h3>��� �����<br><small>(".$owner.")</small></h3>";

$money = sprintf ("%01.2f", $db["money"]);
$platina = sprintf ("%01.2f", $db["platina"]);
$naqrada = sprintf ("%01.2f", $db["naqrada"]);

echo"
<table width=100% cellspacing=0 cellpadding=0 border=0>
<tr>
<td align=left>� ��� � �������: <b>".$money."</b> ��. <b>".$platina."</b> ��. <b>".$naqrada."</b> ��.</td>
<td align=center nowrap><font color=red>".$msg."</font></td>
<td align=right nowrap>
	<INPUT TYPE=button value=\"��������\" onClick=\"location.href='main.php?act=none'\">
 	<INPUT TYPE=button value=\"���������\" onClick=\"location.href='main.php?act=go&level=castle';\">
</td>
</tr>
</table><hr>

<table border=0 width=100%>
  <tr>
    <td valign=top align=center width=300 nowrap>
		<form action='main.php?act=none' method=post>
	    	<input type=submit class=newbut value='����������' name='castle_board' style='width: 170px;'><br>
			<input type=submit class=newbut value='������� �����' name='shop' style='width: 170px;'><br>
			<input type=submit class=newbut value='������� ��� �����' name='clan_shop' style='width: 170px;'><br>
			<input type=button value='������������ ������' style='background-color:#AA0000; color: white;width: 170px;' onclick=\"document.location='main.php?act=go&level=taynik'\"><br>
			<input type=submit class=newbut value='�����' name=enter_castle2 style='width: 170px;'><br>
			<input type=submit class=newbut value='������������ HP' name='hp_restore' style='width: 170px;'><br>
			<input type=submit class=newbut value='������������ MN' name='mn_restore' style='width: 170px;'><br>
			<input type=submit class=newbut value='������� �����' name='lechit' style='width: 170px;'><br>
		</form>
	   	<b>������ �� ����� �����:</b><br>";
		$getTribes = mysql_query("SELECT * FROM castle_tournament LEFT JOIN clan on clan.name_short=castle_tournament.tribe ORDER BY stavka DESC");
		if (mysql_num_rows($getTribes) == 0)
		{
			echo "����� �� ����� ������ �� ����� �����.";
		}
		else 
		{
			while ($tribes = mysql_fetch_assoc($getTribes))
			{
				echo '<img src="img/orden/'.$tribes['orden'].'/0.gif"> <img src=img/clan/'.$tribes['name_short'].'.gif align=midle> <b>'.$tribes['name'].'</b> [������: '.sprintf ("%01.2f", $tribes['stavka']).' ��.]<br>';
			}
		}
    echo "</td>
    <td valign=top>";
		if (isset($_POST['castle_board']) || !count($_POST))
		{
			echo "
			<form action='' method=post>
				<TABLE width=100% cellspacing=1 cellpadding=5 bgcolor=A5A5A5 align=center>
				<TR bgcolor=212120 style='color:#ffffff'>
					<td width=100%><b>C��������</b></td>
					<td width=200 nowrap align=center><b>�������</b></td>
					<td width=100 nowrap align=center><b>����</b></td>
				</tr>";
				if ($db['glava'] == 1 || $db['adminsite'])
				{
					echo "
					<tr bgcolor=#C7C7C7>
						<td colspan=4><input type=text maxlength=100 size=50 name=text> <input type=submit style='width: 75px;' value='��������' class=input name='add_msg'></td>						
					</tr>";
				}
				$getMSG = mysql_query("SELECT castle_board.msg, castle_board.time, 
				users.id,  users.login, users.level,  users.dealer, users.orden, users.admin_level, users.clan_short,  users.clan 
				FROM  castle_board LEFT JOIN users on users.id=castle_board.user_id ".(!$db['adminsite']?"WHERE castle_board.tribe = '".$db['clan_short']."'":"")." ORDER BY castle_board.time DESC");
				$i = 0;
				while ($mess = mysql_fetch_assoc($getMSG))
				{
					
					$n=(!$n);
					echo "<tr bgcolor=".($n?'#D5D5D5':'#C7C7C7').">
					<td>".$mess['msg']."</td>
					<td align=center><script>drwfl('".$mess['login']."','".$mess['id']."','".$mess['level']."','".$mess['dealer']."','".$mess['orden']."','".$mess['admin_level']."','".$mess['clan_short']."','".$mess['clan']."');</script></td>
					<td align=center nowrap>".date("d.m.Y H:i:s", $mess['time'])."</td>
					</tr>";
				}
				echo "</table>
			</form>";
		}
		else if (isset($_POST['enter_castle2']))
		{
			echo "<h3>���� ���� � �������:</h3>";
		}
		else if (isset($_POST['shop']))
		{
			$db["vip"]=0;
			echo '<table border=0 cellpadding=0 bgcolor=#A5A5A5 cellspacing=0 width=100%>';
			echo '<tr>
					<td valign="top" align="center" >
		    			<table border="0" cellspacing="0" cellpadding="5" width=100% bgcolor="#A5A5A5">
						<tr>
							<td nowrap '.($_GET['otdel']=="obj"?"class='fnew'":"class='fold'").' width="20%" valign="top" align="center" >
								<a class=us2 style="color: #ffffff" href="?otdel=obj">����������</font></a>
							</td>
							<td nowrap '.($_GET['otdel']=="magic"?"class='fnew'":"class='fold'").' width="20%"  valign="top" align="center">
								<a class=us2 style="color: #ffffff" href="?otdel=magic">�����</a>
							</td>
						</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td  align=center>
						<TABLE WIDTH=100% CELLSPACING=1 CELLPADDING=2 BGCOLOR=#A5A5A5>';
							if ($_GET['otdel']=="obj")
							{
								$seek=mysql_query("SELECT * FROM paltar WHERE id in $item_Array_str ORDER BY min_level ASC,price ASC");
								while ($res=mysql_fetch_array($seek))
								{
									$n=(!$n);
									echo '<tr bgcolor='.($n?'#C7C7C7':'#D5D5D5').'>
												<td valign=center align=center width=300 nowrap><img src="img/items/'.$res['img'].'"><br>';
												echo '<a href="?buy='.$res["id"].'&type=art">������ �� ������ �� '.sprintf ("%01.2f", $res["price"]).' ��.</a><br>';
												echo '<a href="?buy='.$res["id"].'&type=ed">������ �� ������ �� '.sprintf ("%01.2f", $res["price"]*100).' ��.</a><br>';
												echo '</td><td width=100%>';
												show_item($db,$res);
												echo '</td>
										</tr>
									';
								}
								if (!mysql_num_rows($seek))echo "<tr bgcolor='#C7C7C7'><td valign=center align=center nowrap colspan=2><b>�������� �������� ������...</b></td></tr>";
							}
							else if ($_GET['otdel']=="magic")
							{
								$seek = mysql_query("SELECT * FROM scroll WHERE id in $magic_Array_str ORDER BY min_level ASC, price ASC");
								while ($dat = mysql_fetch_array($seek))
								{
									$n=(!$n);
									echo "<TR  bgcolor=".($n?'#D5D5D5':'#C7C7C7').">
									<TD valign=center align=center width=250>
										<img src='img/".$dat["img"]."'><br>
										<a href='?buy_magic=".$dat["id"]."&type=art'>������ �� ".sprintf ("%01.2f", $dat["price"])." ��.</a><br>
										<a href='?buy_magic=".$dat["id"]."&type=ed'>������ �� ".sprintf ("%01.2f", $dat["price"]*10)." ��.</a><br>

									</td>
									<td valign=top><b>".$dat["name"]."</b> ".($dat["art"]?"<img src='img/icon/artefakt.gif' border=0 alt=\"��������\">":"");
									if($dat["need_orden"]!=0)
									{
										switch ($dat["need_orden"]) 
										{
											 case 1:$orden_dis = "������ �������";break;
											 case 2:$orden_dis = "�������";break;
										 	 case 3:$orden_dis = "����� ����������";break;
										 	 case 4:$orden_dis = "����� �����";break;
										 	 case 5:$orden_dis = "�������� ����������";break;
										 	 case 6:$orden_dis = "�������� ����";break;
										}
										echo "&nbsp; <img src='img/orden/".$dat["need_orden"]."/0.gif' border=0 alt='��������� �����:\n".$orden_dis."'>";
									}
									echo "&nbsp;(�����: ".$dat["mass"].")<br>";
									echo "<b>����: ".$dat["price"]."</font>".($dat["art"]?" ��.":" ��.")."</b> <small>(����������: ".$dat["mountown"].")</small><BR>
									�������������: 0/".$dat["iznos_max"]."<br>";
									if($dat["del_time"])
									{
										echo "���� ��������: ".$dat["del_time"]." ��.<BR>";
									}
									echo "<table width=100%><tr><td valign=top>";
									if ($dat["min_intellekt"] || $dat["min_vospriyatie"] || $dat["min_level"] || $dat["mana"] || $dat["school"])echo "<B>��������� �����������:</B><BR>";
									if($dat["min_intellekt"])
									{
										echo "&bull; ���������: ".$dat["min_intellekt"]."<BR>";
									}
									if($dat["min_vospriyatie"])
									{
										echo "&bull; �����������: ".$dat["min_vospriyatie"]."<BR>";
									}
									if ($dat["min_level"]>0)
									{	
										echo "&bull; �������: ".$dat["min_level"]."<BR>";
									}
									if($dat["mana"])
									{
										echo "&bull; ���. ����: ".$dat["mana"]."<BR>";
									}
									if($dat["school"])
									{
										switch ($dat["school"]) 
										{
											 case "air":$school_d = "������";break;
											 case "water":$school_d = "����";break;
										 	 case "fire":$school_d = "�����";break;
										 	 case "earth":$school_d = "�����";break;
										}
										echo "&bull; ������: <b>".$school_d."</b><BR>";
									}
									if ($dat["type"]=="animal")
									{
										echo "&bull; ��������� ���������: �� �������";
									}
									if(!empty($dat["descs"]))
									{
										echo "<br><font color=brown>�������� ��������:</font> ".str_replace("\n","<br>",$dat["descs"])."<BR>";
									}
									if($dat["to_book"])echo "<small><font color=brown>������������ ����� ����� ������ � ���</font></small>";
									echo "</td></tr></table>";
								}
								if (!mysql_num_rows($seek))echo "<tr bgcolor='#C7C7C7'><td valign=center align=center nowrap colspan=2><b>�������� �������� ������...</b></td></tr>";
							}
						echo '</TABLE>';
				echo '</td>
			  	</tr>
				</TABLE>';
			echo '</TABLE>';
		}
		echo "</td>
  		</tr>
		</table>";
?>
<br><br><br><br>
<?include_once("counter.php");?>