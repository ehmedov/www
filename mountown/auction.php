<?include("time.php");?>
<SCRIPT LANGUAGE="JavaScript" SRC="scripts/magic-main.js"></SCRIPT>
<div id=hint4></div>	
<?
#################��������� ����#################
$query=mysql_Query("SELECT auction.*, login, remote_ip FROM auction LEFT JOIN users ON users.id=auction_owner WHERE `auction_time`<UNIX_TIMESTAMP()");
while ($have_sell=mysql_fetch_array($query))
{
	if (!$have_sell["lot_owner"])
	{
		mysql_Query("UPDATE inv SET owner='".$have_sell["login"]."' WHERE id=".$have_sell["auction_item"]);
		history($have_sell["login"],"������� �� ������","[INV ID: ".$have_sell["auction_item"]."]",$have_sell["remote_ip"],"�������");
		mysql_query("INSERT INTO pochta(user, whom, text, subject) VALUES ('��������������','".$have_sell["login"]."','���� ������� �� ������ � ��������� � ��������...','������� �� ������')");
		mysql_query("DELETE FROM auction WHERE auction_id=".$have_sell["auction_id"]);
	}
	else
	{
		$skupwik=mysql_fetch_array(mysql_Query("SELECT login, remote_ip FROM users WHERE id=".$have_sell["lot_owner"]));
		mysql_Query("UPDATE inv SET owner='".$skupwik["login"]."' WHERE id=".$have_sell["auction_item"]);
		mysql_query("UPDATE person_proff SET navika=navika+1 WHERE proff=10 and person=".$have_sell["auction_owner"]);
		mysql_query("UPDATE users SET money=money+".($have_sell["auction_price"]*0.9)." WHERE id=".$have_sell["auction_owner"]);
		history($have_sell["login"],"������� ������","[INV ID: ".$have_sell["auction_item"]."] �� ".($have_sell["auction_price"]*0.9)." ��. (�������: ".$skupwik["login"].")",$have_sell["remote_ip"],"�������");
		history($skupwik["login"],"������ �������","[INV ID: ".$have_sell["auction_item"]."] �� ".$have_sell["auction_price"]." ��. (��������: ".$have_sell["login"].")",$skupwik["remote_ip"],"�������");
		mysql_query("INSERT INTO pochta(user, whom, text, subject) VALUES ('��������������','".$have_sell["login"]."','���� ������� ��� ������ �� ".($have_sell["auction_price"]*0.9)."','������� ������')");
		mysql_query("INSERT INTO pochta(user, whom, text, subject) VALUES ('��������������','".$skupwik["login"]."','�� ������ ������ ������� �� ".($have_sell["auction_price"])."','������ �������')");
		mysql_query("DELETE FROM auction WHERE auction_id=".$have_sell["auction_id"]);
	}
}
#################������� ���####################
if ($_GET["get_lot"])
{
	$_GET['razdel']=2;
	$get_lot=(int)$_GET["get_lot"];
	$have_lot = mysql_fetch_Array(mysql_query("SELECT * FROM `auction` WHERE auction_id=$get_lot and `auction_owner`='".$db["id"]."'"));
	if ($have_lot)
	{
		if ($have_lot['lot_owner'])
		{
			$msg="�� ��� ��� ���� ������� ������, �� �� ������ ����������� ����� ���� � ��������.";
		}
		else
		{
			mysql_Query("UPDATE inv SET owner='".$login."' WHERE id=".$have_lot['auction_item']);
			mysql_query("DELETE FROM auction WHERE auction_id=$get_lot");
			$msg="�� ������ ������� ���";
		}
	}
}
#################������� ������#################
if (isset($_GET['cssale']) && $_GET['item']) 
{
	$kredit=(int)$_POST['lot_price'];
	$item_id=(int)$_GET['item'];
	if ($db["money"]>=$kredit)
	{	
		$dress = mysql_fetch_array(mysql_query("SELECT * FROM `auction` LEFT JOIN inv ON inv.id=auction.auction_item WHERE `auction_id` = '{$item_id}'"));
		if ($dress['auction_owner']==$db["id"]) {$msg="������ �������� �� ���� �������";} 
		else if ($dress['auction_time']<time()) {$msg="����� ����������... ���� ������ ����������...";} 
		else
		{
			if ($dress['lot_owner']==$db["id"])
			{
				mysql_query("UPDATE `auction` SET `auction_price`=`auction_price`+'".$kredit."' WHERE `auction_id`='".$dress["auction_id"]."'");
				mysql_query("UPDATE users SET money=money-$kredit WHERE login='".$login."'");
				$db["money"]=$db["money"]-$kredit;
				$msg="�� ������� ������";
			}
			else
			{
				if ($dress['auction_price']>=$kredit) {$msg="������� ������ ������";}
				else 
				{
					if ($dress['lot_owner'])
					{
						$lot_owner=mysql_fetch_Array(mysql_Query("SELECT login FROM users WHERE id=".$dress['lot_owner']));
						mysql_query("UPDATE users SET money=money+".$dress['auction_price']." WHERE id=".$dress['lot_owner']);
						$txt="���� ������ � ������� ".$dress['auction_price']." ��. �� ".$dress["name"]." ���� ��������. ������ ����������...";
						mysql_query("INSERT INTO pochta(user, whom, text, subject) VALUES ('��������������','".$lot_owner["login"]."','".$txt."','�������')");
					}
					mysql_query("UPDATE `auction` SET `auction_price`='".$kredit."', lot_owner=".$db["id"]." WHERE `auction_id`='".$dress["auction_id"]."'");
					mysql_query("UPDATE users SET money=money-$kredit WHERE login='".$login."'");
					$msg="�� ��������� ������ � ��������� {$kredit} ��.";
					$db["money"]=$db["money"]-$kredit;
				}
			}
		}
	}
	else $msg="� ��� ��� ����������� �����...$kredit ��.!";
}
#################���� �������#################
if ($_GET['sale'] && $_GET['item']) 
{
	$_GET['razdel']=3;
	$kredit=(int)$_POST['lot_price'];
	$item_name=htmlspecialchars(addslashes($_GET['sale']));
	$item_id=(int)$_GET['item'];
	if ($kredit>0) 
	{
		$Is_Torqovech=mysql_fetch_array(mysql_query("SELECT count(*) FROM person_proff WHERE proff=10 and person=".$db["id"]));
		if (!$Is_Torqovech[0])
		{
			$msg="����� ������� ����� ������ ��������.";
		}
		else
		{
			$dress = mysql_fetch_array(mysql_query("SELECT * FROM inv WHERE object_razdel in ('obj', 'runa') and owner='".$login."' and wear=0 and id=$item_id"));
			if($dress) 
			{
				if($dress['art']) $msg='�� �� ������ ����� �� ������� ���.';
				else if($dress['podzemka']) $msg='�� �� ������ ����� �� ������� ������� �� ����������.';
				else if($dress['gift']) $msg='������� ������� ���. �� �� ������ ����� �� �������.';
				else if($dress['is_modified']>5) $msg='�� �� ������ ����� �� ������� �������.';
				else
				{	
					if ($db["money"]>=10)
					{	
						$t_time=time()+24*3600;
						if ($dress["name"]=="")$dress["name"]=$item_name;
						mysql_query("UPDATE `inv` SET `owner` = '' WHERE `id` = ".$dress["id"]);
						mysql_query("UPDATE `users` SET money=money-10 WHERE `login` = '".$login."'");
						mysql_query("INSERT INTO `auction`(auction_item, auction_time, auction_price, auction_owner, stype) VALUES ('".$dress["id"]."','$t_time','$kredit','".$db["id"]."','".$dress["object_type"]."')");
						history($login,"���� �������",$dress["name"]." �� $kredit ��. [id: ".$dress["id"]."]",$db["remote_ip"],"�������");
						$msg="�� ����� �� ������� \"{$dress['name']}\" �� {$kredit} ��.";
						$db["money"]=$db["money"]-10;
					}
					else $msg="� ��� ��� ����������� �����...10.00 ��.!";
				}
			}
			else 
			{
				$msg="������� �� ������ � ����� �������!";
			}
		}
	}
}
##############################################
echo "<font color=red>$msg</font>";
?>
<TABLE border=0 width=100% cellspacing="0" cellpadding="0">
<tr>
	<td align=center width=100%><h3>�������</h3></td>
	<td align=right nowrap>
    	<input type="button" class="podskazka" value="���������" onclick="window.open('help/auction.php','displayWindow','height=400,width=500,resizable=no,scrollbars=yes,menubar=no,status=no,toolbar=no,directories=no,location=no')"/>
		<input type="button" onclick="location.href='main.php?act=none'" value="��������" class=new >
		<input type="button" onclick="location.href='main.php?act=go&level=remesl'" value="���������" class=new >
	</td>
</tr>
</table>
<TABLE border=0 width=100% cellspacing="0" cellpadding="4">
<TR>
	<TD valign=top width=900 nowrap>
		<TABLE border=0 width=100% cellspacing="0" cellpadding="0">
		<TR>
			<TD>
			<TABLE border=0 width=100% cellspacing="0" cellpadding="1" class="l3">
			<TR>
				<td align=center><B>����:</B></TD>
				<TD align=center <?=($_GET['razdel']==0)?"class='fnew'":"class='fold'"?> nowrap><a href="?razdel=0" style="color: #ffffff">�����</a></TD>
				<TD align=center <?=($_GET['razdel']==1)?"class='fnew'":"class='fold'"?> nowrap><a href="?razdel=1" style="color: #ffffff">��� ������</a></TD>
				<TD align=center <?=($_GET['razdel']==2)?"class='fnew'":"class='fold'"?> nowrap><a href="?razdel=2" style="color: #ffffff">��� ����</a></TD>
				<TD align=center <?=($_GET['razdel']==3)?"class='fnew'":"class='fold'"?> nowrap><a href="?razdel=3" style="color: #ffffff">��������� �� �������</a></TD>
			</TR>
			<TR>
				<td colspan=5 height=30 class='fnew'>
					<CENTER>
					<?
					switch ($_GET['razdel']) 
					{
						case 0: echo "��� �� ������ ������� �� ������ ����� � ������ ����� ������, ������ ���� ���� ��� ����������.
						<b>��������!</b> � ������, ����� �� ������� ������ �� ��������, �� ������ ����������� ����������� ������ ��������.
		 				��� ����� ������ ���� � ���������, � ��, ��������, � �����. ��������� ����� �������� ��������� �� ������ �������� � ������������� �� ��������� ������.
		   				�� ��������� ������ ��� ��� ������������ �������, ���� ���� ������ ��������, ��� ��������� ������������� ����. "; break;
						case 1: echo "� ���� ������� �� ������ ������� �� ������ �������� �� ��������� ������� � ������� �������, ���� ���� ������ ��������. "; break;
						case 2: echo "�������� ������������ �����. � ���� ������� �� ������ ������� ���� ������������ ���� � ������� ��, �� ������� �� ���� ������ � ����� ������ �� ������� �����������."; break;
						case 3: echo "� ���� �������, ��������� ������ ����� � ������ ����� ������, �� ������ ������� ���� �� ������ ��������� ��� ����������� �� �������. ��������� �������� ����������� ���� �� ������� ����� <b>10.00 ��.</b> ���� ��� ��������, <b>10.00 ��.</b> ������������ ���, � � ������� ��������� �������� 10%. ���� ��� �� ������, <b>10.00 ��.</b> �� ������������."; break;
					}
					?>
					</CENTER>
				</td>
			</tr>
			</TABLE>
			</TD>
		</TR>
		</TABLE>
		<?
			#if (!$db["adminsite"])die("UNDER CONSTRUCTION");
			if ($_POST["apply"])
			{
				$_SESSION["iname"]=htmlspecialchars(addslashes($_POST["iname"]));
				$_SESSION["ilevellow"]=(int)$_POST["ilevellow"];
				$_SESSION["ilevelmax"]=(int)$_POST["ilevelmax"];
				$_SESSION["itype"]=htmlspecialchars(addslashes($_POST["itype"]));
			}
			if ($_POST["reset"])
			{
				$_SESSION["iname"]="";
				$_SESSION["ilevellow"]=0;
				$_SESSION["ilevelmax"]=0;
				$_SESSION["itype"]="";
			}
			if ($_GET['razdel']==0)
			{
				?>
				<form method="POST" action="main.php" style="margin:0px;">
				<table width=100% class="l2"><tr>
				<td>��������: <input type=text name="iname" value="<?=$_SESSION["iname"];?>"></td>
				<td>������� �� <input type=text size=2 name="ilevellow" value="<?=(int)$_SESSION["ilevellow"];?>"></td>
				<td> �� <input type=text size=2 name="ilevelmax" value="<?=(int)$_SESSION["ilevelmax"];?>"></td>
				<td>���: <select style="width:200px;" name="itype">
					<option <?=($_SESSION["itype"]==""?"selected":"");?> value="">��� �������</option>
					<option <?=($_SESSION["itype"]=="sword"?"selected":"");?> value="sword">����</option>
					<option <?=($_SESSION["itype"]=="axe"?"selected":"");?> value="axe">������ � ������</option>
					<option <?=($_SESSION["itype"]=="fail"?"selected":"");?> value="fail">������ � ������</option>
					<option <?=($_SESSION["itype"]=="spear"?"selected":"");?> value="spear">��������� ������</option>
					<option <?=($_SESSION["itype"]=="knife"?"selected":"");?> value="knife">������� � ����</option>
					<option <?=($_SESSION["itype"]=="staff"?"selected":"");?> value="staff">������</option>
					<option <?=($_SESSION["itype"]=="armour"?"selected":"");?> value="armour">������� �����</option>
					<option <?=($_SESSION["itype"]=="rubaxa"?"selected":"");?> value="rubaxa">������</option>
					<option <?=($_SESSION["itype"]=="plash"?"selected":"");?> value="plash">�����</option>
					<option <?=($_SESSION["itype"]=="helmet"?"selected":"");?> value="helmet">�����</option>
					<option <?=($_SESSION["itype"]=="mask"?"selected":"");?> value="mask">����� � ������</option>
					<option <?=($_SESSION["itype"]=="shield"?"selected":"");?> value="shield">����</option>
					<option <?=($_SESSION["itype"]=="pants"?"selected":"");?> value="pants">������</option>
					<option <?=($_SESSION["itype"]=="boots"?"selected":"");?> value="boots">������</option>
					<option <?=($_SESSION["itype"]=="perchi"?"selected":"");?> value="perchi">��������</option>
					<option <?=($_SESSION["itype"]=="poyas"?"selected":"");?> value="poyas">�����</option>
					<option <?=($_SESSION["itype"]=="amulet"?"selected":"");?> value="amulet">�������</option>
					<option <?=($_SESSION["itype"]=="naruchi"?"selected":"");?> value="naruchi">������</option>
					<option <?=($_SESSION["itype"]=="ring"?"selected":"");?> value="ring">������</option>
					<option <?=($_SESSION["itype"]=="amunition"?"selected":"");?> value="amunition">�����������</option>
					<option <?=($_SESSION["itype"]=="kostyl"?"selected":"");?> value="kostyl">��������</option>
					<option <?=($_SESSION["itype"]=="runa"?"selected":"");?> value="runa">����</option>
					<option <?=($_SESSION["itype"]=="wood"?"selected":"");?> value="wood">�������</option>
				</select></td>
				<td><input type="submit" name="apply" value="���������"></td>
				<td><input type="submit" name="reset" value="��������"></td>
				</tr>
				</table>
				<?
			}
		?>
		<table width=100% cellspacing=1 cellpadding=2  class="l3">
		<?
		if ($_GET['razdel']==0)
		{
			###########################################################################
			echo "<tr><td colspan=2 class='l1'>��������: ";
			$page=(int)abs($_GET['page']);
			$row=mysql_fetch_array(mysql_query("SELECT count(*) FROM `auction` ".($_SESSION["itype"]!=""?"WHERE stype='".$_SESSION["itype"]."'":"")." ORDER BY auction_time DESC"));
			$page_cnt=$row[0];
			$cnt=$page_cnt; // ����� ���������� ������� �� ��� ������
			$rpp=20; // ���-�� ������� �� ��������
			if ($_SESSION["iname"]!="" || $_SESSION["ilevellow"] || $_SESSION["ilevelmax"])$rpp=$page_cnt;
			$rad=2; // ������� ������ ���������� ����� � ������� ������� �������� (2 ����� + 2 ������ + �������� �������� = ����� 5)

			$links=$rad*2+1;
			$pages=ceil($cnt/$rpp);
			if ($page>0) { echo "<a href=\"?page=0\">���</a> | <a href=\"?page=".($page-1)."\">��</a> |"; }
			$start=$page-$rad;
			if ($start>$pages-$links) { $start=$pages-$links; }
			if ($start<0) { $start=0; }
			$end=$start+$links;
			if ($end>$pages) { $end=$pages; }
			for ($i=$start; $i<$end; $i++) 
			{
				if ($i==$page)
				{
					echo "<b style='color:#ff0000'><u>";
				} 
				else 
				{
					echo "<a href=\"?page=$i\">";
				}
				echo $i;
				if ($i==$page) 
				{
					echo "</u></b>";
				} 
				else 
				{
					echo "</a>";
				}
				if ($i!=($end-1)) { echo " | "; }
			}
			if ($pages>$links && $page<($pages-$rad-1)) { echo " ... <a href=\"?page=".($pages-1)."\">".($pages-1)."</a>"; }
			if ($page<$pages-1) { echo " | <a href=\"?page=".($page+1)."\">��</a> | <a href=\"?page=".($pages-1)."\">���</a>"; }

			$limit = $rpp;
			$eu = $page*$limit;
			echo "</td></tr>";
			###########################################################################
			$data = mysql_query("SELECT auction.*, users.login FROM `auction` LEFT JOIN users ON users.id=auction.auction_owner ".($_SESSION["itype"]!=""?"WHERE stype='".$_SESSION["itype"]."'":"")." ORDER BY auction_time DESC LIMIT $eu, $limit");
			while($row = mysql_fetch_array($data)) 
			{
				
				$n=(!$n);
				if ($row["stype"]=="runa")
				{
					$data_auction=mysql_fetch_Array(mysql_query("SELECT runa.*, inv.id as ids, inv.iznos, inv.iznos_max FROM inv LEFT JOIN runa ON runa.id=inv.object_id WHERE inv.id=".$row["auction_item"].($_SESSION["iname"]!=""?" and runa.name like '%".$_SESSION["iname"]."%'":"").($_SESSION["ilevellow"]?" and runa.min_level>=".$_SESSION["ilevellow"]."":"").($_SESSION["ilevelmax"]?" and runa.min_level<=".$_SESSION["ilevelmax"]."":"")));
					$data_img="img";
				}
				else if ($row["stype"]=="wood")
				{
					$data_auction=mysql_fetch_Array(mysql_query("SELECT wood.*, inv.id as ids, inv.iznos, inv.iznos_max FROM inv LEFT JOIN wood ON wood.id=inv.object_id WHERE inv.id=".$row["auction_item"].($_SESSION["iname"]!=""?" and wood.name like '%".$_SESSION["iname"]."%'":"").($_SESSION["ilevellow"]?" and min_level>=".$_SESSION["ilevellow"]."":"").($_SESSION["ilevelmax"]?" and min_level<=".$_SESSION["ilevelmax"]."":"")));
					$data_img="img";
				}
				else
				{
					$data_auction=mysql_fetch_Array(mysql_query("SELECT * FROM inv WHERE inv.id=".$row["auction_item"].($_SESSION["iname"]!=""?" and name like '%".$_SESSION["iname"]."%'":"").($_SESSION["ilevellow"]?" and min_level>=".$_SESSION["ilevellow"]."":"").($_SESSION["ilevelmax"]?" and min_level<=".$_SESSION["ilevelmax"]."":"")));
					$data_img="img/items";
				}
				if ($data_auction)
				{
					echo "<tr class='".($n?'l0':'l1')."'><TD align=center><IMG SRC=\"$data_img/{$data_auction['img']}\" BORDER=0><BR>
					<A onclick=\"lot('������� ������ :', '?cssale={$data_auction['name']}&item={$row['auction_id']}', '{$data_auction['name']}', '4')\" style='CURSOR: Hand'>������� ������</A><br>
					��������� ������: <br>".($row['auction_time']>time()?convert_time($row['auction_time']):"<font color=red>����� ����������... <br>���� ������ ����������...</font>");
					echo ($db["adminsite"]?"<br>��������: ".$row["login"]:"");
					echo "</TD>";
					echo "<TD valign=top>";
				 	$data_auction["price"]=$row["auction_price"];
				 	show_item($db,$data_auction); 
				 	echo "</TD>
				 	</tr>";	
			 	}
			}
		}
		##################��� ������####################
		if ($_GET['razdel']==1) 
		{
			$data = mysql_query("SELECT * FROM `auction` WHERE `lot_owner`='".$db["id"]."' ORDER BY auction_time DESC");
			while($row = mysql_fetch_array($data)) 
			{
				$n=(!$n);
				if ($row["stype"]=="runa")
				{
					$data_auction=mysql_fetch_Array(mysql_query("SELECT runa.*, inv.id as ids, inv.iznos, inv.iznos_max FROM inv LEFT JOIN runa ON runa.id=inv.object_id WHERE inv.id=".$row["auction_item"]));
					$data_img="img";
				}
				else if ($row["stype"]=="wood")
				{
					$data_auction=mysql_fetch_Array(mysql_query("SELECT wood.*, inv.id as ids, inv.iznos, inv.iznos_max FROM inv LEFT JOIN wood ON wood.id=inv.object_id WHERE inv.id=".$row["auction_item"]));
					$data_img="img";
				}
				else
				{
					$data_auction=mysql_fetch_Array(mysql_query("SELECT * FROM inv WHERE inv.id=".$row["auction_item"]));
					$data_img="img/items";
				}
				echo "<tr class='".($n?'l0':'l1')."'><TD align=center><IMG SRC=\"$data_img/{$data_auction['img']}\" BORDER=0><BR>
				<A onclick=\"lot('������� ������ :', '?cssale={$data_auction['name']}&item={$row['auction_id']}&razdel=1', '{$data_auction['name']}', '4')\" style='CURSOR: Hand'>������� ������</A><br>
				��������� ������: <br>".convert_time($row['auction_time'])."<br>
				��� ������: ".$row["auction_price"]." ��.</TD>
				<TD valign=top>";
		 		$data_auction["price"]=$row["auction_price"];
				show_item($db,$data_auction);
				echo"</TD>
				</TR>"; 
			}
		}
		##################��� ����####################
		if ($_GET['razdel']==2) 
		{
			$data = mysql_query("SELECT * FROM `auction` WHERE `auction_owner`='".$db["id"]."' ORDER BY auction_time DESC");
			while($row = mysql_fetch_array($data)) 
			{
				$n=(!$n);
				if ($row["stype"]=="runa")
				{
					$data_auction=mysql_fetch_Array(mysql_query("SELECT runa.*, inv.id as ids, inv.iznos, inv.iznos_max FROM inv LEFT JOIN runa ON runa.id=inv.object_id WHERE inv.id=".$row["auction_item"]));
					$data_img="img";
				}
				else if ($row["stype"]=="wood")
				{
					$data_auction=mysql_fetch_Array(mysql_query("SELECT wood.*, inv.id as ids, inv.iznos, inv.iznos_max FROM inv LEFT JOIN wood ON wood.id=inv.object_id WHERE inv.id=".$row["auction_item"]));
					$data_img="img";
				}
				else
				{
					$data_auction=mysql_fetch_Array(mysql_query("SELECT * FROM inv WHERE inv.id=".$row["auction_item"]));
					$data_img="img/items";
				}
				echo "<tr class='".($n?'l0':'l1')."'><TD align=center><IMG SRC=\"$data_img/{$data_auction['img']}\" BORDER=0><BR>";
				if (!$row['lot_owner'])echo "<A HREF=\"?get_lot={$row['auction_id']}\">������� ���</A><br>";
				echo "��������� ������: <br>".convert_time($row['auction_time'])."<br></TD>";
				echo "<TD valign=top>";
				$data_auction["price"]=$row["auction_price"];
				show_item($db,$data_auction);
				echo"</TD>
				</TR>"; 
			}
		}
		##################��������� �� �������####################
		if ($_GET['razdel']==3) 
		{
			$data = mysql_query("SELECT * FROM inv WHERE object_razdel='obj' and owner='".$login."' and wear=0");
			while($row = mysql_fetch_array($data)) 
			{
				$n=(!$n);
				echo "<tr class='".($n?'l0':'l1')."'><TD align=center><IMG SRC=\"img/items/{$row['img']}\" BORDER=0><BR>
				<A onclick=\"lot('��������� ��� :', '?sale={$row['name']}&item={$row['id']}', '{$row['name']}', '4')\" style='CURSOR: Hand'>��������� ���</A>
				</TD>
				<TD valign=top>";
				show_item($db,$row);
				echo "</TD></TR>";
			}
			$data = mysql_query("SELECT runa.*, inv.id as ids, inv.iznos, inv.iznos_max FROM inv LEFT JOIN runa ON runa.id=inv.object_id WHERE object_razdel='runa' and owner='".$login."' and wear=0");
			while($row = mysql_fetch_array($data)) 
			{
				$n=(!$n);
				echo "<tr class='".($n?'l0':'l1')."'><TD align=center><IMG SRC=\"img/{$row['img']}\" BORDER=0><BR>
				<A onclick=\"lot('��������� ��� :', '?sale={$row['name']}&item={$row['ids']}', '{$row['name']}', '4')\" style='CURSOR: Hand'>��������� ���</A>
				</TD>
				<TD valign=top>";
				show_item($db,$row);
				echo "</TD></TR>";
			}
		}
	?>
	</TABLE>
	</TD>
	<td valign=top>
		<?
			$money = sprintf ("%01.2f", $db["money"]);
			$platina = sprintf ("%01.2f", $db["platina"]);
		?>
		� ��� � �������: <B><?echo $money;?></b> ��. <b><?echo $platina;?></b> ��. 
	</td>
	</tr>	
	</TABLE>
