<?

$login=$_SESSION['login'];
$otdel="obj";
if (isset($_GET['otdel']))
{	
	$otdel=htmlspecialchars(addslashes($_GET['otdel']));
	$_SESSION['sess_otdel']=$otdel;
}
else 
{
	if (isset($_SESSION['sess_otdel']))
	{
		$otdel=$_SESSION['sess_otdel'];
	}
}
if ($_POST["unlock"])
{
	$lock=mysql_fetch_Array(mysql_query("SELECT pass FROM effects WHERE user_id=".$db["id"]." and type='lock'"));
	if ($lock["pass"]!= $_POST["unlock_psw"])
	{	
		$_SESSION["message"]="�������� ������";
	}
	else $_SESSION["lock"]=true;
}
if (!$_SESSION["lock"])
{
	$lock=mysql_fetch_Array(mysql_query("SELECT pass FROM effects WHERE user_id=".$db["id"]." and type='lock' and end_time>".time()));
	if ($lock && $lock["pass"]!="")$inventar_locked=true;
}
$sexy=$db["sex"];
$ip=$db["remote_ip"];

$max_mass=$db["maxmass"];

$money  = number_format($db["money"], 2, '.', ' ');
$platina= number_format($db["platina"], 2, '.', ' ');
$bril= number_format($db["bril"], 2, '.', ' ');
$naqrada= number_format($db["naqrada"], 2, '.', ' ');

$level=$db["level"];
$expa=$db["exp"];
$next_up=$db["next_up"];

$clan_s  = $db["clan_short"];
$clan_f  = $db["clan"];
$chin=$db["chin"];

$status=$db["status"];
$my_orden=$db["orden"];
$admin_level=$db["admin_level"];
$otdels=$db["otdel"];

$stack=array(60,262);

switch ($my_orden) 
{
	 case 1:$orden_dis="������ �������";break;
	 case 2:$orden_dis="�������";break;
 	 case 3:$orden_dis="����� ����������";break;
 	 case 4:$orden_dis="����� �����";break;
 	 case 5:$orden_dis="�������� ����������";break;
 	 case 6:$orden_dis="�������� ����";break;
 	 case 100:$orden_dis="��������";break;
}
if($my_orden)$orden="<img src='img/orden/".$my_orden."/".$admin_level.".gif' border=0 alt='".$orden_dis."'>";
//----------------------------------------------------------------------------
mysql_query("DELETE FROM `inv` WHERE owner='".$login."' and object_type='flower' and term<unix_timestamp();");
//-------------------------USE RUNA----------------------------------------------------
if ($_GET["runa_id"])
{
	$Is_Alchemist=mysql_fetch_array(mysql_query("SELECT count(*) FROM person_proff WHERE proff=8 and person=".$db["id"]));
	if (!$Is_Alchemist[0])
	{
		$_SESSION["message"]="�������� ���� � ������� ����� ������ �������.";
	}
	else 
	{
		$wearname=addslashes(htmlspecialchars(trim($_POST["wearname"])));
		$runa_id=(int)$_GET["runa_id"];
		$is_runa=mysql_fetch_array(mysql_query("SELECT runa.* FROM inv LEFT JOIN runa on runa.id=inv.object_id WHERE inv.id=$runa_id and inv.owner='".$login."' and inv.object_type='runa'"));
		if ($is_runa)
		{
			if ($is_runa["min_level"]<=$db["level"])
			{	
				$inv=mysql_fetch_Array(mysql_query("SELECT * FROM inv WHERE name='".$wearname."' and owner='".$login."' and wear=0 ORDER BY date DESC LIMIT 1"));
				if (!$inv)
				{
					$_SESSION["message"]="��� ������ �� ���� ������� � ����� ���������!";
				}
				else if (in_array($inv["object_type"],array('axe','fail','knife','sword','spear','shot','staff','kostyl','shield')))
				{
					$_SESSION["message"]="�� �������� �� �������...";
				}
				else
				{
					if ($inv["runas"]!="")
					{
						$rname=explode("#",$inv["runas"]);
						if ($rname[0]==$is_runa["type"] && $rname[1]<$is_runa["step"])
						{
							$is_runa_weared=mysql_fetch_array(mysql_query("SELECT * FROM runa WHERE type='".$rname[0]."' and step=".$rname[1]));
							##===Unwear Existing Runa
							mysql_query("UPDATE inv SET add_sila=add_sila-".$is_runa_weared["add_sila"].", 
							add_lovkost=add_lovkost-".$is_runa_weared["add_lovkost"].",
							add_udacha=add_udacha-".$is_runa_weared["add_udacha"].",
							add_intellekt=add_intellekt-".$is_runa_weared["add_intellekt"].",
							add_hp=add_hp-".$is_runa_weared["add_hp"].", add_mana=add_mana-".$is_runa_weared["add_mana"].",
							protect_mag=protect_mag-".$is_runa_weared["protect_mag"].",protect_udar=protect_udar-".$is_runa_weared["protect_udar"].",
							krit=krit-".$is_runa_weared["add_krit"].", akrit=akrit-".$is_runa_weared["add_akrit"].",uvorot=uvorot-".$is_runa_weared["add_uvorot"].",auvorot=auvorot-".$is_runa_weared["add_auvorot"].",						
							ms_udar=ms_udar-".$is_runa_weared["ms_udar"].",ms_krit=ms_krit-".$is_runa_weared["ms_krit"].",ms_mag=ms_mag-".$is_runa_weared["ms_mag"].",
							counter=counter-".$is_runa_weared["counter"].", parry=parry-".$is_runa_weared["parry"].",
							runas='' WHERE id=".$inv["id"]);
							##===Wear Runa
							mysql_query("UPDATE inv SET add_sila=add_sila+".$is_runa["add_sila"].", 
							add_lovkost=add_lovkost+".$is_runa["add_lovkost"].",
							add_udacha=add_udacha+".$is_runa["add_udacha"].",
							add_intellekt=add_intellekt+".$is_runa["add_intellekt"].",
							add_hp=add_hp+".$is_runa["add_hp"].", add_mana=add_mana+".$is_runa["add_mana"].",
							protect_mag=protect_mag+".$is_runa["protect_mag"].",protect_udar=protect_udar+".$is_runa["protect_udar"].",
							krit=krit+".$is_runa["add_krit"].", akrit=akrit+".$is_runa["add_akrit"].",uvorot=uvorot+".$is_runa["add_uvorot"].",auvorot=auvorot+".$is_runa["add_auvorot"].",						
							ms_udar=ms_udar+".$is_runa["ms_udar"].",ms_krit=ms_krit+".$is_runa["ms_krit"].",ms_mag=ms_mag+".$is_runa["ms_mag"].",						
							counter=counter+".$is_runa["counter"].", parry=parry+".$is_runa["parry"].",
							runas='".$is_runa["type"]."#".$is_runa["step"]."' WHERE id=".$inv["id"]);
							
							mysql_query("INSERT INTO `inv` (`owner`, `object_id`, `object_type`, `object_razdel`,  `iznos_max`) VALUES('".$login."', '".$is_runa_weared["id"]."','runa','runa','1');");
							mysql_query("DELETE FROM `inv` WHERE id = '".$runa_id."'");
							mysql_query("UPDATE person_proff SET navika=navika+1 WHERE proff=8 and person=".$db["id"]);
							$_SESSION["message"]="������ �������� ���� &quot".$is_runa['name']."&quot �� ������ &quot".$inv['name']."&quot";
						}
						else $_SESSION["message"]="���������� ������� ����";
					}
					else if ($inv["runas"]=="")
					{
						mysql_query("UPDATE inv SET add_sila=add_sila+".$is_runa["add_sila"].", 
						add_lovkost=add_lovkost+".$is_runa["add_lovkost"].",
						add_udacha=add_udacha+".$is_runa["add_udacha"].",
						add_intellekt=add_intellekt+".$is_runa["add_intellekt"].",
						add_hp=add_hp+".$is_runa["add_hp"].", add_mana=add_mana+".$is_runa["add_mana"].",
						protect_mag=protect_mag+".$is_runa["protect_mag"].",protect_udar=protect_udar+".$is_runa["protect_udar"].",
						krit=krit+".$is_runa["add_krit"].", akrit=akrit+".$is_runa["add_akrit"].",uvorot=uvorot+".$is_runa["add_uvorot"].",auvorot=auvorot+".$is_runa["add_auvorot"].",						
						ms_udar=ms_udar+".$is_runa["ms_udar"].",ms_krit=ms_krit+".$is_runa["ms_krit"].",ms_mag=ms_mag+".$is_runa["ms_mag"].",						
						counter=counter+".$is_runa["counter"].", parry=parry+".$is_runa["parry"].",
						runas='".$is_runa["type"]."#".$is_runa["step"]."' WHERE id=".$inv["id"]);
						mysql_query("DELETE FROM `inv` WHERE id = '".$runa_id."'");
						mysql_query("UPDATE person_proff SET navika=navika+1 WHERE proff=8 and person=".$db["id"]);
						$_SESSION["message"]="������ �������� ���� &quot".$is_runa['name']."&quot �� ������ &quot".$inv['name']."&quot";
					}
				}
			}
			else $_SESSION["message"]="����������� ������� -".$is_runa["min_level"];
		}
	}
}
//-------------------------getGift----------------------------------------------------
/*if ($_GET["action"]=="getGift")
{
	$id=$_GET['id'];
	if(is_numeric($id))
	{
		$INV_SQL = mysql_query("SELECT * FROM gift,(SELECT * FROM `inv` WHERE id='$id' and owner='$login') as hediyye WHERE gift.id=hediyye.object_id");
		$GIFT_DAT = mysql_fetch_array($INV_SQL);		
		if ($GIFT_DAT)
		{
			mysql_query("DELETE FROM `inv` WHERE id='$id'");
			$gifts=array(354,357,360,365,368,373,376,381,384,387,390,399,97,103,108,114,119,120,104,102,147,149,151,154,156,
			158,161,163,169,226,228,231,233,236,239,241,244,246,249,39,42,45,48,50,54,57,64,68,75,79,91,176,178,181,185,188,
			191,193,195,197,201,206,213,214,218,222,223,122,125,128,131,135,138,142,145,253,256,259,261,263,265,268,272,279,
			282,284,288,290,293,295,298,301,303,2,11,13,15,17,19,22,24,26,28,33,35,304,305,306,321,322,324,325,326,327,328,
			330,332,334,337,339,341,346,348,350,400,401);
			$gift_id=$gifts[rand(0,count($gifts)-1)];
	       	$GIFT_G_SQL = mysql_query("SELECT * FROM paltar WHERE id='".$gift_id."' limit 1");
	       	$GIFT_G_DAT = mysql_fetch_array($GIFT_G_SQL);
			mysql_query("INSERT INTO inv(owner,object_id,object_type,object_razdel,wear,iznos,iznos_max,gift,gift_author) VALUES ('$login','".$gift_id."','".$GIFT_G_DAT['object']."','obj','0','0','".$GIFT_G_DAT['iznos_max']."','1','���������')");
	       	//$GET_SQL_OTKRITKA    = mysql_query("INSERT INTO inv(owner,object_id,object_type,object_razdel,wear,iznos,iznos_max,gift,gift_author) VALUES ('".$_SESSION["login"]."','$gift_id','$gift_t','other','0','0','','1','������� �� ���������')");
	       	$_SESSION["message"]="� ������� �������� ������� &laquo;".$GIFT_G_DAT["name"]."&raquo;!";
	       	history($login,'�������',$GIFT_G_DAT["name"]."(".$GIFT_G_DAT["id"].")",$ip,'���������');
		}
		else
		{
			$_SESSION["message"]= "������� �� ������!";
		}
	}
}*/
//-------------------------------DELETE ITEMS------------------------------------------------------------------
if ($_POST["tmpname423"])
{	
	$name=htmlspecialchars(addslashes($_POST['drop']));
	$del_id=(int)$_POST['n'];
	
	$drop_item=mysql_fetch_array(mysql_query("SELECT * FROM inv WHERE id='".$del_id."' and owner='".$login."' and wear=0"));
	if (!$drop_item)
	{
		$_SESSION["message"]= "� ��� ��� ����� ����...";
	}
	else
	{
		if(isset($_POST["dropall"]))
		{
			mysql_query("DELETE FROM inv WHERE object_id='".$drop_item["object_id"]."' and object_type='".$drop_item["object_type"]."' and wear=0 and owner='".$login."'");
			history($login,'�������� ���',$name,$ip,'������');
			$_SESSION["message"]= "�� ������ ������� ��� �������� &quot".$name."&quot!";
		}	
		else if(isset($_POST["drop"]))
		{	
			mysql_query("DELETE FROM inv WHERE id='".$del_id."' and wear=0");
			history($login,'��������',$name,$ip,'������');
			$_SESSION["message"]= "�� ������ ������� ������� &quot".$name."&quot!";
		}
	}

}
//--------------------------- ������� --------------------------------------------------------------
if ($_GET["stack"] && in_array($_GET["stack"],$stack))
{

	$item_id=(int)$_GET["stack"];
	$sql=mysql_query("SELECT id FROM inv WHERE owner='".$login."' and object_type='scroll' and object_id='".$item_id."' and inv.iznos_max=1 and wear=0 LIMIT 20");
	$count_stack=mysql_num_rows($sql);
	if ($count_stack==20)
	{	
		while($res=mysql_fetch_Array($sql))
		{
			mysql_query("DELETE FROM inv WHERE id='".$res["id"]."'");
		}
		mysql_Query("INSERT INTO inv (owner, object_id, object_type, object_razdel, gift, gift_author, iznos, iznos_max, term) VALUES('".$login."', '".$item_id."', 'scroll', 'magic', '1', 'WWW.FOGGYTOWN.RU', '0', '$count_stack', '".(time()+30*24*3600)."');");
	}
	else $_SESSION["message"]="����� �������� ����� 20 ����. �� ������� ".(20-$count_stack)." ����.";
}
//--------------------------- ���������� ��������� --------------------------------------------------------------
if ($_GET['complect']=='save')
{
	$save_kmp=htmlspecialchars(addslashes($_POST['name']));
	$compl=mysql_query("SELECT * FROM complect WHERE complect_name='".$save_kmp."' and owner='".$login."'");
	$dat = mysql_fetch_array($compl);
	if (!$dat)
	{
		mysql_query("INSERT INTO complect(complect_name,owner,amulet,naruchi,hand_r,armour,rubaxa,plash,poyas,helmet,mask,hand_l,perchi,ring1,ring2,ring3,boots,pants)
		VALUES ('".$save_kmp."','".$login."','".$db['amulet']."','".$db['naruchi']."','".$db['hand_r']."','".$db['armour']."', '".$db['rubaxa']."', '".$db['plash']."', '".$db['poyas']."','".$db['helmet']."','".$db['mask']."','".$db['perchi']."','".$db['hand_l']."','".$db['ring1']."','".$db['ring2']."','".$db['ring3']."','".$db['boots']."','".$db['pants']."')");
		$_SESSION["message"]= "��������� �������� '".$save_kmp."'!";
	}
	else
	{
		mysql_query("UPDATE complect SET amulet='".$db['amulet']."',hand_r='".$db['hand_r']."',hand_l='".$db['hand_l']."',armour='".$db['armour']."', rubaxa='".$db['rubaxa']."', plash='".$db['plash']."', poyas='".$db['poyas']."',ring1='".$db['ring1']."',ring2='".$db['ring2']."',ring3='".$db['ring3']."',helmet='".$db['helmet']."',mask='".$db['mask']."',perchi='".$db['perchi']."',naruchi='".$db['naruchi']."',boots='".$db['boots']."',pants='".$db['pants']."'
		WHERE complect_name='".$save_kmp."' and owner='".$login."'");
		$_SESSION["message"]= "������������ �������� '".$save_kmp."'!";
	}	
}	
//-------------------------------- ����� �������� --------------------------------------------------------------
if ($_GET['odet']=='wearcomplect' && is_numeric($_GET['id']))
{
	if ($db["room"]!="smert_room" && $db["room"]!="towerin" && $db["room"]!="zadaniya")
	{	
		$com=mysql_query("SELECT * FROM complect WHERE id='".$_GET['id']."' and owner='".$login."'");		
		if (!mysql_num_rows($com))
		{
			$_SESSION["message"]= "�������� �� ������"; 
		}
		else
		{
			$kompl = mysql_fetch_array($com);
			//unwear_full($_SESSION["login"]);
			if($kompl['amulet']){wear($login,$kompl['amulet']);}
			if($kompl['hand_r']){wear($login,$kompl['hand_r']);}
			if($kompl['hand_l']){wear($login,$kompl['hand_l']);}
			if($kompl['armour']){wear($login,$kompl['armour']);}
			if($kompl['rubaxa']){wear($login,$kompl['rubaxa']);}
			if($kompl['plash']){wear($login,$kompl['plash']);}
			if($kompl['poyas']){wear($login,$kompl['poyas']);}
			if($kompl['ring1']){wear($login,$kompl['ring1']);}
			if($kompl['ring2']){wear($login,$kompl['ring2']);}
			if($kompl['ring3']){wear($login,$kompl['ring3']);}
			if($kompl['helmet']){wear($login,$kompl['helmet']);}
			if($kompl['mask']){wear($login,$kompl['mask']);}
			if($kompl['naruchi']){wear($login,$kompl['naruchi']);}
			if($kompl['perchi']){wear($login,$kompl['perchi']);}
			if($kompl['boots']){wear($login,$kompl['boots']);}
			if($kompl['pants']){wear($login,$kompl['pants']);}
		}
	}
	else $_SESSION["message"]= "� ���� ������� ���������� ��������..."; 
}	
//------------------------------ ������� �������� --------------------------------------------------------------
if ($_GET['delete']=='deletecomplect' && is_numeric($_GET['id']))
{
	$com=mysql_query("SELECT * FROM complect WHERE id='".$_GET['id']."' and owner='".$login."'");	
	if (!mysql_num_rows($com))
	{
		$_SESSION["message"]= "�������� �� ������!"; 
	}
	else
	{
		$comm = mysql_fetch_array($com);
		mysql_query("DELETE FROM complect WHERE id='".$_GET['id']."' and owner='".$login."'");
		$_SESSION["message"]= "�������� '".$comm['complect_name']."' ������!"; 
	}	
}	
//--------------------------------------------------------------------------------------------------------------	

$sql1=mysql_fetch_Array(mysql_query("SELECT sum(mass),count(*) FROM inv WHERE inv.owner='".$login."' and inv.object_razdel='obj'"));

$sql2=mysql_fetch_Array(mysql_query("SELECT sum(scroll.mass),count(*) FROM inv LEFT JOIN scroll on scroll.id=inv.object_id WHERE inv.owner='".$login."' and inv.object_razdel='magic'"));

$sql3=mysql_fetch_Array(mysql_query("SELECT sum(wood.mass),count(*) FROM inv LEFT JOIN wood on wood.id=inv.object_id WHERE inv.owner='".$login."' and inv.object_razdel='thing'"));

$sql4=mysql_fetch_Array(mysql_query("SELECT sum(flower.mass),count(*) FROM inv LEFT JOIN flower on flower.id=inv.object_id WHERE inv.owner='".$login."' and inv.object_razdel='other'"));

$sql5=mysql_fetch_Array(mysql_query("SELECT sum(inv.mass),count(*) FROM inv LEFT JOIN runa on runa.id=inv.object_id WHERE inv.owner='".$login."' and inv.object_razdel='runa'"));

$mass=$sql1[0]+$sql2[0]+$sql3[0]+$sql4[0]+$sql5[0];
$al=$sql1[1]+$sql2[1]+$sql3[1]+$sql4[1]+$sql5[1];


?>	
<SCRIPT LANGUAGE="JavaScript" SRC="scripts/magic-main.js"></SCRIPT>
<div id=hint4 name=hint4 style="z-index: 5;"></div>
<script>
	function delconf(id,name,otdel)
	{
		if(confirm('�� ������� ��� ������ ��������� ������� '+name+' ?'))
		{
			location.href = 'main.php?act=inv&action=del_item_conf&otdel='+otdel+'&item='+id+'&name='+name;
		}
	}
	var specialscript = '';
	var sd4 = Math.random();
	function drop(name, n, txt, image)
	{
		image = image || name;
		var table = 	'<TABLE width=100%><TD><IMG src="img/'+image+'"></TD><TD>������� <NOBR><B>\''+txt+'\'</B></NOBR> ����� ������, �� ������� ?</TABLE>'+
 		(!specialscript?'<input type=checkbox name="dropall" value="'+txt+'"><SMALL> ��� �������� ����� ����</SMALL>':'')+
		'<INPUT type=hidden name=drop value="'+name+'"><INPUT type=hidden name=n value="'+n+'"><INPUT type=hidden name=sd4 value="' + sd4+'">';
		// window.clipboardData.setData('Text', table);
		dialogconfirm('��������� �������?', (specialscript?specialscript:'main.php?act=inv'),table);
	}
	top.setHP(<?echo "$hp[0],$hp[1],100";?>); top.setMana(<?echo "$mana[0],$mana[1],100"?>)
</script>
<table border=0 cellpadding="0" cellspacing="0" width="100%" height="100%"  valign="top">
<tr>
	<td width=260 valign=top align=center nowrap>
		<table border="0" width="100%" cellpadding=0 cellspacing=0 >
			<tr >
			    <td width="100%" align=center nowrap>
					<?
						echo "<script>wks('".$db['login']."', '".$db['id']."', '".$db['level']."', '".$db['dealer']."', '".$db['orden']."', '".$db['admin_level']."', '".$db['clan_short']."', '".$db['clan']."','".$db['shut']."','".$db['travm']."','".time()."');</script>";
					?>
			   	</td>
			</tr>
			<tr>
				<td nowrap style="font-size:9px" style="position: relative;"><SPAN id="HP" style='position: absolute; left: 5; z-index: 1; font-weight: bold; color: #FFFFFF'></SPAN><img src="img/icon/grey.jpg" alt="������� �����" name="HP1" width="1" height="10" id="HP1"><img src="img/icon/grey.jpg" alt="������� �����" name="HP2" width="1" height="10" id="HP2"></td>
			</tr>
			<tr><td><span></span></td></tr>
			<?if($level >0 && $db['mana_all']>0){?>
				<tr>
					<td nowrap style="font-size:9px" style="position: relative;"><SPAN id="Mana" style='position: absolute; left: 5; z-index: 1; font-weight: bold; color: #FFFFFF'></SPAN><img src="img/icon/grey.jpg" alt="������� ����" name="Mana1" width="1" height="10" id="Mana1"><img src="img/icon/grey.jpg" alt="������� �����" name="Mana2" width="1" height="10" id="Mana2"></td>
				</tr>
			<?}?>
		</table>

		<?
		showPlayer_inv($db);
		echo "<table cellspacing='3' border=0 cellpadding='0' width='220'>";
		for ($j=0;$j<=1;$j++) 
		{
			echo "<tr>";
			for ($i=$j*6+100;$i<=$j*6+105;$i++) 
			{
			    echo "<td width=37>";showpic($db,$i,2);echo " </td>";
			}
			unset($i);
		  	echo "</tr>";
		}
		echo "</table>";
		unset($j);
		?>
		<a class=us2 href="main.php?act=unwear_full"  class=us2><small>����� ���</small></a><br>
		<a class=us2 href="#" onclick="form('��������� �������� :', '?act=inv&complect=save', 'name', '','5')" title='��������� ��������.' class=us2><small>��������� ��������</small></a><br /><br />
		<p style="MARGIN-LEFT: 10px;" align="left">
		<?
			$comp=mysql_query("SELECT id,complect_name FROM complect WHERE owner='".$login."'");
			while ($datt = mysql_fetch_array($comp))
			{
				echo "<a style='cursor:hand' href='?act=inv&delete=deletecomplect&id=".$datt['id']."'><img src='img/icon/del.gif'></a>&nbsp;
				<a class=us2 href='?act=inv&odet=wearcomplect&id=".$datt['id']."'><small>������ \"".$datt['complect_name']."\"</small></a><br />";
			}
			mysql_free_result($comp);
		?>
		</p>
	</td>
	<td width=2></td>
	<td valign="top" align=left nowrap width=210><br>
		<small>
		<?
		echo "����:  <b>".number_format($expa, 0, ',', ' ')."</b><br>
		���������:  [<a style=\"color: #252252\" title=\"������� �����\" href=\"extable.php\" target='_blank'>".number_format($next_up, 0, ',', ' ')."</a>]<br>
		�����: ".$db["win"]."<br>
		���������: ".$db["lose"]."<br>
		������: ".$db["nich"]."<br>
		����� ��� ���������: ".$db["monstr"]."<br>
		���������: ".$db["reputation"]."<br>
		��������: ".$db["doblest"]."<br>	
		<hr width=70%>
		������: <b>$money ��.</b><br>
                ���������: <b>$bril ��.</b><br>
		�������: <b>$platina ��.</b><br>
		�������: <b>$naqrada ��.</b><br>	
		<font color=green><b>��� ���:</font><font color=red> {$db['chek']}</font></b><br>	
		�������: ".(50-$db["peredacha"])."
		<hr width=70%>
		����: <b>".($db['sila']+$effect["add_sila"])."</b><br>
		��������: <b>".($db['lovkost']+$effect["add_lovkost"])."</b><br>
		�����: <b>".($db['udacha']+$effect["add_udacha"])."</b><br>
		������������: <b>".$db['power']."</b><br>";
		if($db["level"]>0)
		{
			echo "
			���������: <b>".($db['intellekt']+$effect["add_intellekt"])."</b><br>
			����������: <b>".$db['vospriyatie']."</b><br>";
		}
		if ($db["level"]>9 || $db["duxovnost"]>0)
		{
			echo "����������: <b>".$db["duxovnost"]."</b><br>";
		}
		if($db["ups"])
		{
			echo "<a class=us2 href='?act=char'><small>��������� ���������� (".$db["ups"].")</small></A><br>";
	 	}
	 	if($db["umenie"])
		{
			echo "<a class=us2 href='?act=char'><small>��������� ������ (".$db["umenie"].")</small></A><br>";
	 	}
		echo "
		<hr width=70%>
		������: <b>$status</b><br>";	
        if ($my_orden){echo "$orden <b>".$orden_dis."</b><br>".(($otdels!= "")?"���������: <b>".$otdels."</b>":"")."<BR>";}
        if($clan_f!='')
		{
			echo "�������: <a href='clan_inf.php?clan=".$clan_s."' class=us2 target=new><small>".$clan_f."</small></a><BR>";
			echo "���������: <b>".$chin."</b><BR>";
		}
		?>
	</td> 
	<td valign="top" nowrap>
	<table border=0 cellpadding=0 cellspacing=0 width=100%>
	<tr>
		<td>				
		<?echo "<b style='color:#ff0000'>".$_SESSION["message"]."</b>";	$_SESSION["message"]="";?>
		</td>	
	</tr>
	<tr>
		<td align=right>						
			<?if ($db["zver_count"]){?><input type=button value="�����" class="newbut" style="cursor:hand" onClick="javascript:location.href='main.php?act=animal'"><?}?>
			<input type=button value="���������" style="background-color:#AA0000; color: white; cursor:hand;" onClick="javascript:location.href='referal.php'">
			<input type=button value="������" class="newbut" style="cursor:hand" onClick="javascript:location.href='otchet.php'">
			<input type=button value="�������������" class="newbut" onClick="javascript:location.href='anket.php?action=secure'">
			<input type=button value="���������" class="newbut" style="cursor:hand" onClick="javascript:location.href='main.php?act=none'">
		</td>
	</tr>
	</table>
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td valign="top" align="center" >
		    <table border="0" cellspacing="0" cellpadding="5" width=100% bgcolor="#a5a5a5">
			<tr>
				<td nowrap <?echo ($otdel=="obj"?"bgcolor='504f4c'":"class='fold'");?> width="20%" valign="top" align="center" >
				<a class=us2 style="color: #ffffff" href='main.php?act=inv&otdel=obj&<?=time();?>'>����������</font></a>
				</td>
				<td nowrap <?echo ($otdel=="magic"?"bgcolor='504f4c'":"class='fold'");?> width="20%"  valign="top" align="center">
				<a class=us2 style="color: #ffffff" href='main.php?act=inv&otdel=magic&<?=time();?>'>�����</a>
				</td>
				<td nowrap <?echo ($otdel=="runa"?"bgcolor='504f4c'":"class='fold'");?> width="20%"  valign="top" align="center">
				<a class=us2 style="color: #ffffff" href='main.php?act=inv&otdel=runa&<?=time();?>'>����</a>
				</td>
				<td nowrap <?echo ($otdel=="other"?"bgcolor='504f4c'":"class='fold'");?> width="20%"  valign="top" align="center">
				<a class=us2 style="color: #ffffff" href='main.php?act=inv&otdel=other&<?=time();?>'>��������</a>
				</td>
				<td nowrap <?echo ($otdel=="thing"?"bgcolor='504f4c'":"class='fold'");?> width="20%"  valign="top" align="center">
				<a class=us2 style="color: #ffffff" href='main.php?act=inv&otdel=thing&<?=time();?>'>�������</a>
				</td>
				<td nowrap <?echo ($otdel=="flud"?"bgcolor='504f4c'":"class='fold'");?> width="20%"  valign="top" align="center">
				<a class=us2 style="color: #ffffff" href='main.php?act=inv&otdel=flud&<?=time();?>'>������</a>
				</td>
			</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="5" bgcolor='504f4c' align=center valign="center" height=20>
			<? echo "<b><font color=ffffff>������ (<font $mass_style>�����: ".round($mass,2)."</font>/".$max_mass.", ����� �����: $al)</font></b>";?>
		</td>
	</tr>
	<tr>
		<td  align=center>
		<TABLE WIDTH=100% CELLSPACING=1 CELLPADDING=2 BGCOLOR=#a5a5a5>
		<?
		if ($inventar_locked)
		{
			echo "<form method='post' action='main.php?act=inv'>
			<TR>
				<TD align=center>
				<B>������ ������.</B><BR><IMG SRC=img/elik/lock.gif><BR>
				������� ������ <INPUT TYPE=password NAME=unlock_psw>
				<INPUT TYPE=submit name=unlock value='�������'>
				</FORM>";
			die();
		}	
		//-----------------------------------------------obj----------------------------------------------------------------
		if($otdel=="obj")
		{
			$result=mysql_query("SELECT * FROM inv WHERE object_razdel='obj' and owner='".$login."' and wear=0 and ".($db["bs"]?"bs=1":"bs=0")." ORDER BY UNIX_TIMESTAMP(date) DESC");
			if (!mysql_num_rows($result))echo "<tr class='l0'><td height=30 align=center>�����</td></tr>";
			while($dat = mysql_fetch_assoc($result))
			{
				$wearable = 0;
			    if(	($db["sila"]+$effect["add_sila"])>=$dat["min_sila"] && 
			       	($db["lovkost"]+$effect["add_lovkost"])>=$dat["min_lovkost"] && 
			       	($db["udacha"]+$effect["add_udacha"])>=$dat["min_udacha"] && 
			    	($db["power"]>=$dat["min_power"]) &&
			    	($db["intellekt"]+$effect["add_intellekt"])>=$dat["min_intellekt"] && 
			    	($db["vospriyatie"]>=$dat["min_vospriyatie"]) && 
			    	($db["level"]>=$dat["min_level"]) &&
			    	($db["sword_vl"]+$effect["add_sword_vl"])>=$dat["min_sword_vl"] && 
			    	($db["staff_vl"]+$effect["add_staff_vl"])>=$dat["min_staff_vl"] &&
			    	($db["axe_vl"]+$effect["add_axe_vl"])>=$dat["min_axe_vl"] &&
			    	($db["hummer_vl"]+$effect["add_hummer_vl"])>=$dat["min_fail_vl"] &&
			    	($db["castet_vl"]+$effect["add_castet_vl"])>=$dat["min_knife_vl"] &&
			    	($db["copie_vl"]+$effect["add_copie_vl"])>=$dat["min_spear_vl"] &&
			    	($db["water_magic"]+$effect["add_water_magic"])>=$dat["min_water"] && 
			    	($db["earth_magic"]+$effect["add_earth_magic"])>=$dat["min_earth"] && 
			    	($db["fire_magic"]+$effect["add_fire_magic"])>=$dat["min_fire"] &&
			    	($db["air_magic"]+$effect["add_air_magic"])>=$dat["min_air"]
			    ){$wearable=1;}
				if ($dat["iznos"]>=$dat["iznos_max"])$wearable=0;
				if ($db['bs']==0 && $dat["bs"]==1)$wearable=0;
				if ($db['bs']==1 && $dat["bs"]==0)$wearable=0;
				if ($dat["object_type"]=='kostyl')$wearable=1;
				if ($dat["need_orden"]!=0 && $db["orden"]!=$dat["need_orden"])$wearable=0;
				$n=(!$n);
				if ($dat["term"]!="")
				{
					mysql_Query("DELETE FROM inv WHERE id=".$dat["id"]." and term<".time());
					if(mysql_affected_rows()>0)
					{
						talk($login,"���������� ���� ������ <b>".$dat["name"]."</b>",$db);
						history($login,"���������� ���� ������",$dat["name"],$db["remote_ip"],"���������");
					}
				}
				echo "<tr class='".($n?'l0':'l1')."'>
				<td width=150 valign=center align=center><img src='img/items/".$dat["img"]."'><br>".
				($wearable?"<a href='?act=wear&item_id=".$dat["id"]."' class=us2>������</a><br>":"<b>������ �����</b><br>");
				if(!$dat["is_personal"])echo "<A HREF=\"javascript:drop('".$dat["name"]."', '".$dat["id"]."', '".$dat["name"]."', 'items/".$dat["img"]."')\"><img src='img/icon/clear.gif' style='CURSOR: Hand' border=0></a>";
				echo "</td><td valign='top'>";
				$db["vip"]=0;
				show_item($db,$dat);
				echo "</td></tr>";
			}
			mysql_free_result($result);
		}
		//-------------------------------------------magic-------------------------------------------------------------------------
		else if($otdel=="magic")
		{
			$S = mysql_query("SELECT scroll.*, inv.id as ids, inv.iznos, inv.iznos_max, inv.term, inv.gift, inv.gift_author FROM inv LEFT JOIN scroll on scroll.id=inv.object_id WHERE inv.owner='".$login."' and inv.object_razdel='magic' and inv.wear=0 ORDER BY UNIX_TIMESTAMP(inv.date) DESC");
			if (!mysql_num_rows($S))echo "<tr class='l0'><td height=30 align=center>�����</td></tr>";
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
		        $br=$DAT['br'];
		        $gift= $DAT["gift"];
		        $gift_author= $DAT["gift_author"];
		        $term=$DAT["term"];
				$del_time=$DAT["del_time"];
		        $price=$DAT["price"];
		        $price=sprintf ("%01.2f", $price);
				$spells_attack=array("���������", "������", "�������", "������� �����", "����� �����+1", "����� �����+2", "����� �����+3", "����� �����+4", "����� �����+5", "����� �����+6", "����� �����+10");
				$animal_type=array("wolf","cheetah","bear","dragon","snake");
				$zatochka_name=array("������� ������ +3","������� ������ +20",
				"������� ������ � ������ +1","������� ������ � ������ +2","������� ������ � ������ +3","������� ������ � ������ +4","������� ������ � ������ +5",
				"������� ������ � ������ +6","������� ������ � ������ +7","������� ������ � ������ +8","������� ������ � ������ +9","������� ������ � ������ +10",

				"������� ���� +1","������� ���� +2","������� ���� +3","������� ���� +4","������� ���� +5",
				"������� ���� +6","������� ���� +7","������� ���� +8","������� ���� +9","������� ���� +10",
					
				"������� ���� +1","������� ���� +2","������� ���� +3","������� ���� +4","������� ���� +5",
				"������� ���� +6","������� ���� +7","������� ���� +8","������� ���� +9","������� ���� +10",
					
				"������� ������ +1","������� ������ +2","������� ������ +3","������� ������ +4","������� ������ +5",
				"������� ������ +6","������� ������ +7","������� ������ +8","������� ������ +9","������� ������ +10",
				
				"������� ������ +1","������� ������ +2","������� ������ +3","������� ������ +4","������� ������ +5",
				"������� ������ +6","������� ������ +7","������� ������ +8","������� ������ +9","������� ������ +10");
				echo "<tr class='".($n?'l0':'l1')."'>";
		        echo "<td width=150 valign=center align=center><img src='img/$img'>";
		        echo "<br>";
		        if($DAT["to_book"])
		        {
					echo "<a href='main.php?act=addToSlot&id=$item_id' class=us2>������</a><br>";
		        }
		    	else
		        {
					if (in_array($name,$spells_attack))
					{	
						echo "<A HREF=\"JavaScript:findlogin('��������� ��� ����������','main.php?act=magic&type=scroll&spell=$item_id', 'target', '', '5')\" title='��������� ��� ����������.'>���-��</A><BR>";
	    			}
	    			else if (in_array($type,$animal_type))
	    			{
	    				echo "<A HREF=\"JavaScript:findwear('$name','main.php?act=magic&type=scroll&spell=$item_id', 'wearname', '5')\" title='��������� ��� ����������.'>���-��</A><BR>";
	    			}
	    			else if(in_array($name,$zatochka_name))
	    			{
	    				echo "<A HREF=\"JavaScript:findwear('$name','main.php?act=magic&type=scroll&spell=$item_id', 'wearname', '5')\" title='��������� ��� ����������.'>���-��</A><BR>";
	    			}
	    			else if($name=="����� ��� �������")
	    			{
	    				echo "<A HREF=\"JavaScript:lock('$name','main.php?act=magic&type=scroll&spell=$item_id', '', '5')\" title='��������� ��� ����������.'>���-��</A><BR>";
	    			}
	    			else
	    			{	
	    				echo "<A HREF=\"JavaScript:UseMagick('$name','main.php?act=magic&type=scroll&spell=$item_id', '$img', '', '15', '', '5')\" title='��������� ��� ����������.'>���-��</A><BR>";
	        		}
				}
				if(in_array($spell_id,$stack))echo "<img src='img/icon/join.gif' ALT='�������' style='CURSOR: Hand' border=0 onclick=\"document.location.href='main.php?act=inv&stack=$spell_id'\"> ";
				echo "<A HREF=\"javascript:drop('$name', '$item_id', '$name', '$img')\"><img src='img/icon/clear.gif' style='CURSOR: Hand' border=0></a>";
		        echo "</td>";
		        echo "<td valign=top>
		        <b>".$name."</b> ".($artovka?"<img src='img/icon/artefakt.gif' border=0 alt=\"��������\">":"").($br?"<img src='img/icon/bril.gif' border=0 alt=\"��\">":"").($gift?"&nbsp;<img src='img/icon/gift.gif' border=0 alt=\"������� �� ".$gift_author."\">":"")." (�����: ".$DAT["mass"].")<br>";
				echo "<b>����: ".$price.($artovka?" ��.":"").($br?" ��.":"").(!$br && !$artovka?" ��.":"")."</b><BR>";
		        echo "�������������: $iznos/$iznos_all<BR>";
		        if ($del_time>0)
		        {
		        	echo "���� ��������: $del_time ��. (��  ".(date('d.m.y H:i:s', $term)).")<br>";
		        	if ($term<time())
		        	{
		        		mysql_query("DELETE FROM inv WHERE id=$item_id");
		        		history($login,"���������� ���� ��������",$name,$db["remote_ip"],"���������");
		        	}
		        }
		        if ($min_i>0 || $min_v>0 || $min_level>0)echo "<BR><b>����������:</b><BR>";
		        if($min_i)
				{
					echo "&bull; ".($min_i>$db["intellekt"]+$effect["add_intellekt"]?"<font color=red>":"")."���������: $min_i</font><BR>";
				}
				if($min_v)
				{
					echo "&bull; ".($min_v>$db["vospriyatie"]?"<font color=red>":"")."�����������: $min_v</font><BR>";
				}
				if ($min_level>0)
				{
		        	echo "&bull; ".($min_level>$db["level"]?"<font color=red>":"")."�������: $min_level</font><BR>";
		        }
		        if($mana)
				{
					echo "&bull; ���. ����: ".$mana."<BR>";
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
		        if($DAT["descs"])
		        {
		        	echo "<br>";
		        	echo "<div style=\"background-color: #FAF0E6\"><small><b>��������:</b> ".str_replace("\n","<br>",$DAT["descs"])."</small></div>";
		        }
		        echo "</td></tr>";
			}
			mysql_free_result($S);
		}
		//-------------------------------------------------other-------------------------------------------------------------------
		else if($otdel=="other")
		{
			//--------------------FLOWER-------------------------------------------
			$S = mysql_query("SELECT flower.*,inv.id as ids,inv.gift_author,inv.iznos,inv.iznos_max,inv.msg,inv.term as terms,inv.gift,inv.date FROM inv LEFT JOIN flower on flower.id=inv.object_id WHERE inv.owner='".$login."' and object_razdel='other' ORDER BY UNIX_TIMESTAMP(date) DESC");
			if (!mysql_num_rows($S))echo "<tr class='l0'><td height=30 align=center>�����</td></tr>";
			while($DAT = mysql_fetch_array($S))
			{
				$n=(!$n);
				$name = $DAT["name"];
				$img = $DAT["img"];
				$gift_author = $DAT["gift_author"];
				$wish = $DAT["msg"];
				$wish=str_replace("&amp;","&",$wish);
				$wish=str_replace("&amp;","&",$wish);
				$massa = round($DAT["mass"],2);
				$item_id = $DAT["ids"];
				$days = $DAT["term"];
				$date_send=$DAT["date"];
				$left = $DAT["terms"];
				$price=$DAT["price"];
				$price=sprintf ("%01.2f", $price);
				$left_time = $left - time();
				$d_left = floor($left_time/86400);
				echo "<tr class='".($n?'l0':'l1')."'>
				<td width=150 valign=center align=center>
				<img src='img/".$img."'><br>";
				echo "<A HREF=\"javascript:drop('$name', '$item_id', '$name', '$img')\"><img src='img/icon/clear.gif' style='CURSOR: Hand' border=0></a>
				</td><td valign=top><b>".$name."</b> (�����: ".$massa.")";
				if($DAT["gift"])
		       	{
		        	echo "&nbsp;<img src='img/icon/gift.gif' border=0 alt='������� �� ".$gift_author."'>";
		       	}
				echo "<br>";
				echo "<b>����: ".$price.($artovka?" ��.":" ��.")."</b><BR>";
				echo "�������: ".$date_send."<BR>";
				echo "���� �����: ".$days." ��. (�� ".(date('d.m.y H:i:s', $left)).")<BR><BR>";
		    	if($wish!="")
		       	{
		    		echo "�� ������ ������� �����:<BR>";
		    		echo "<div style=\"background-color: #FAF0E6\"><CODE>$wish";
		    		if($DAT["gift"])
			       	{
			        	echo "<br><br><p align=right>������� �� <b>".$gift_author."</b></p>";
			       	}
		    		echo "</CODE></div>";
		    	}
		    	echo "<small><font color=brown>������� �� �������� �������</font></small>";
		    	echo "<br></td></tr>";
			}
			mysql_free_result($S);
		}
		else if($otdel=="flud")
		{
			//--------------------FLOWER-------------------------------------------
			$S = mysql_query("SELECT flower.*,me.id as ids,me.gift_author,me.iznos,me.iznos_max,me.msg,me.term as terms,me.gift,me.date FROM flower,(SELECT * FROM inv WHERE owner='".$login."' and object_razdel='flud') as me WHERE flower.id=me.object_id ORDER BY UNIX_TIMESTAMP(date) DESC");
			if (!mysql_num_rows($S))echo "<tr class='l0'><td height=30 align=center>�����</td></tr>";
			while($DAT = mysql_fetch_array($S))
			{
				$n=(!$n);
				$name = $DAT["name"];
				$img = $DAT["img"];
				$gift_author = $DAT["gift_author"];
				$wish = $DAT["msg"];
				$massa = round($DAT["mass"],2);
				$item_id = $DAT["ids"];
				$days = $DAT["term"];
				$date_send=$DAT["date"];
				$left = $DAT["terms"];
				$price=$DAT["price"];
				$price=sprintf ("%01.2f", $price);
				$left_time = $left - time();
				$d_left = floor($left_time/86400);
				echo "<tr class='".($n?'l0':'l1')."'>
				<td width=150 valign=center align=center>
				<img src='img/".$img."'><br>";
				echo "<A HREF=\"javascript:drop('$name', '$item_id', '$name', '$img')\"><img src='img/icon/clear.gif' style='CURSOR: Hand' border=0></a>
				</td><td valign=top><b>".$name."</b> (�����: ".$massa.")";
				if($DAT["gift"])
		       	{
		        	echo "&nbsp;<img src='img/icon/gift.gif' border=0 alt='������� �� ".$gift_author."'>";
		       	}
				echo "<br>";
				echo "<b>����: ".$price.($artovka?" ��.":" ��.")."</b><BR>";
				echo "�������: ".$date_send."<BR>";
				echo "���� �����: ".$days." ��. (�� ".(date('d.m.y H:i:s', $left)).")<BR><BR>";
		    	if($wish!="")
		       	{
		    		echo "�� ������ ������� �����:<BR>";
		    		echo "<div style=\"background-color: #FAF0E6\"><CODE>$wish";
		    		if($DAT["gift"])
			       	{
			        	echo "<br><br><p align=right>������� �� <b>".$gift_author."</b></p>";
			       	}
		    		echo "</CODE></div>";
		    	}
		    	echo "<small><font color=brown>������� �� �������� �������</font></small>";
		    	echo "<br></td></tr>";
			}
			mysql_free_result($S);
		}
		//-------------------------------------------thing-------------------------------------------------------------------------
		else if($otdel=="thing")
		{
			$S = mysql_query("SELECT wood.*,inv.id as ids,inv.iznos,inv.iznos_max, count(*) as co FROM inv LEFT JOIN wood ON wood.id=inv.object_id WHERE inv.owner='".$login."' and inv.object_type='wood' GROUP by object_id");
			if (!mysql_num_rows($S))echo "<tr class='l0'><td height=30 align=center>�����</td></tr>";
			while($DAT = mysql_fetch_assoc($S))
			{
				$n=(!$n);
			    $name = $DAT["name"];
		    	$img = $DAT["img"];
		    	$item_id = $DAT["ids"];
		    	$co = $DAT["co"];
		    	$mass = round($DAT["mass"],2);
		    	$price = $DAT["price"];
		    	$price=sprintf ("%01.2f", $price);
		    	$iznos = $DAT["iznos"];
				$iznos_all = $DAT["iznos_max"];
		    	echo "<tr class='".($n?'l0':'l1')."'>
		    		<td width=150 valign=center align=center>
		    		<span style=\"position:relative;  width:60px; height:60px;\"><img src='img/".$img."' alt='".$name."'><small style='background-color: #E0E0E0; position: absolute; right: 1; bottom: 3;'><B>x".$co."</B></small>
		    		</span>
		    		<br><A HREF=\"javascript:drop('$name', '$item_id', '$name', '$img')\"><img src='img/icon/clear.gif' style='CURSOR: Hand' border=0></a>
		    		</td><td valign=top>
		    		<b>".$name."</b> (�����: ".$mass.")<BR>
		    		<b>����: ".$price." ��.</b><BR>
		    		�������������:$iznos/$iznos_all
		    		</td></tr>";
			}
			mysql_free_result($S);
		}
		else if($otdel=="runa")
		{
			$S = mysql_query("SELECT runa.*,inv.id as ids,inv.iznos,inv.iznos_max, count(*) as co FROM inv LEFT JOIN runa ON runa.id=inv.object_id WHERE inv.owner='".$login."' and inv.object_type='runa' GROUP by object_id");
			if (!mysql_num_rows($S))echo "<tr class='l0'><td height=30 align=center>�����</td></tr>";
			while($DAT = mysql_fetch_assoc($S))
			{
				$n=(!$n);		    	
		    	echo "<tr class='".($n?'l0':'l1')."'>
		    		<td width=150 valign=center align=center>
		    		<span style=\"position:relative;  width:60px; height:60px;\"><img src='img/".$DAT["img"]."' title='".$DAT["name"]."'><small style='background-color: #E0E0E0; position: absolute; right: 1; bottom: 3;'><B>x".$DAT["co"]."</B></small></span>
		    		<br><A HREF=\"JavaScript:findwear('".$DAT["name"]."','main.php?act=inv&runa_id=".$DAT["ids"]."', 'wearname', '5')\" title='��������� ��� ����������.'>���-��</A>
		    		<BR><A HREF=\"javascript:drop('".$DAT["name"]."', '".$DAT["ids"]."', '".$DAT["name"]."', '".$DAT["img"]."')\"><img src='img/icon/clear.gif' style='CURSOR: Hand' border=0></a>
		    		</td><td valign=top>";
		    		show_item($db,$DAT);
		    		echo "</td></tr>";
			}
			mysql_free_result($S);
		}

?>
	</table>
   </td>
  </tr>
</table>
  </td>
 </tr>
</table>
<br>