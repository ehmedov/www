<?
include ("key.php");
include ("conf.php");
include ("req.php");
include ("item_des.php");
array_walk($_REQUEST,"format_string");
array_walk($_POST,"format_string");
array_walk($_GET,"format_string"); 
$niks=array("OBITEL","bor","Test","Controller");
if (!in_array($_SESSION["login"],$niks))
{
	echo "��� ���� ������!";
	die();
}

$data = mysql_connect($base_name, $base_user, $base_pass) or die('�� ���������� ������������. ��������� ��� �������, ��� ������������ � ������!');
mysql_select_db($db_name) or die('������ ����� � ���� ������');

Header("Cache-Control: no-cache, must-revalidate"); // ������� �������� ���-�� �� �� ��������� ��� ��������
Header("Pragma: no-cache");
function c_items($db_items,$otdel)
{
	$res=mysql_fetch_array(mysql_query("SELECT count(id) FROM $db_items WHERE object='{$otdel}'"));
	return (int)$res[0];
}
########################################################
function DuplicateMySQLRecord ($table, $id_field, $id) 
{
    // load the original record into an array
    $result = mysql_query("SELECT * FROM {$table} WHERE {$id_field}={$id}");
    $original_record = mysql_fetch_assoc($result);
    
    // insert the new record and get the new auto_increment id
    mysql_query("INSERT INTO {$table} (`{$id_field}`) VALUES (NULL)");
    $newid = mysql_insert_id();
    
    // generate the query to update the new record with the previous values
    $query = "UPDATE {$table} SET ";
    foreach ($original_record as $key => $value) {
        if ($key != $id_field) {
            $query .= '`'.$key.'` = "'.str_replace('"','\"',$value).'", ';
        }
    }
    $query = substr($query,0,strlen($query)-2); # lop off the extra trailing comma
    $query .= " WHERE {$id_field}={$newid}";
    mysql_query($query);
    
    // return the new id
    return $newid;
}
?>
<html>
<HEAD>	
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<meta http-equiv="Content-Language" content="ru">
	<META Http-Equiv=Cache-Control Content="no-cache, max-age=0, must-revalidate, no-store">
	<meta http-equiv=PRAGMA content=NO-CACHE>
	<meta http-equiv=Expires content=0>	
	<LINK REL=StyleSheet HREF='main.css' TYPE='text/css'>
</HEAD>
<body bgcolor=#e2e0e0 topMargin=0 leftMargin=0 rightMargin=0 bottomMargin=0>
<a href="?type=add">���������� ����� � �������</a> | <a href="?type=edit&otdel=sword">�������������� �����</a> | <a href="?type=old">OLD THINGS</a> | <a href="?type=all_things">�Ѩ</a>  | <a href="?type=priem">�����</a> | <a href="?type=runa">����������� ���</a> | <a href="?type=resurs">�������</a> | <a href="?type=eliks">�����</a> | <a href="?type=medal">MEDAL</a> | <a href="?type=flower">������� ��������</a><hr>
<?
if (isset($_POST["name"]))
{
	$road="img/items/";
	if(is_uploaded_file($_FILES['img']['tmp_name']))
	{
		$ext = strrchr($_FILES['img']['name'], ".");  
		if ($ext=='.gif' || $ext=='.png') 
		{
			$size_img = getimagesize($HTTP_POST_FILES['img']['tmp_name']);
			if ($size_img['0']<=100 && $size_img['1']<=100)
			{
				if ($_POST['two_hand']>0)$_POST['second_hand']=0;
				mysql_query("INSERT INTO `paltar` (`id`, `object`, `name`,  `mass`, `price`, `min_sila`, `min_lovkost`, `min_udacha`, `min_power`, `min_intellekt`, `min_vospriyatie`, `min_level`, `min_sword_vl`, `min_staff_vl`, `min_axe_vl`, `min_fail_vl`, `min_knife_vl`, `min_spear_vl`,`min_fire`,`min_water`,`min_air`,`min_earth`,`min_svet`,`min_tma`,`min_gray`,`add_fire`, `add_water`, `add_air`, `add_earth`, `add_svet`, `add_tma`, `add_gray`, `add_sila`, `add_lovkost`, `add_udacha`, `add_intellekt`, `add_duxovnost`, `add_hp`, `add_mana`, `protect_head`, `protect_arm`, `protect_corp`, `protect_poyas`, `protect_legs`, `protect_rej`, `protect_drob`, `protect_kol`, `protect_rub`, `protect_fire`, `protect_water`, `protect_air`, `protect_earth`, `protect_svet`, `protect_tma`, `protect_gray`,`protect_mag`,`protect_udar`, `shieldblock`, `krit`, `akrit`, `uvorot`, `auvorot`, `parry`, `counter`, `add_rej`, `add_drob`, `add_kol`, `add_rub`, `ms_udar`, `ms_krit`, `ms_mag`, `ms_fire`, `ms_water`, `ms_air`, `ms_earth`, `ms_svet`, `ms_tma`, `ms_gray`, `ms_rej`, `ms_drob`, `ms_kol`, `ms_rub`, `iznos_max`, `min_attack`, `max_attack`, `proboy`, `add_oruj`, `add_sword_vl`, `add_staff_vl`, `add_axe_vl`, `add_fail_vl`, `add_knife_vl`, `add_spear_vl`, `mountown`, `need_orden`, `sex`, `art`, `podzemka`, `is_personal`, `personal_owner`, `noremont`, `two_hand`, `second_hand`,  `add_fire_att`, `add_air_att`, `add_watet_att`, `add_earth_att`, `edited`) 
				VALUES (NULL, '".$_POST["object_type"]."', '".$_POST["name"]."', '".$_POST["mass"]."', '".$_POST["price"]."', '".$_POST["min_sila"]."', '".$_POST["min_lovkost"]."', '".$_POST["min_udacha"]."', '".$_POST["min_power"]."', '".$_POST["min_intellekt"]."', '".$_POST["min_vospriyatie"]."', '".$_POST["min_level"]."', '".$_POST["min_sword_vl"]."', '".$_POST["min_staff_vl"]."', '".$_POST["min_axe_vl"]."', '".$_POST["min_fail_vl"]."', '".$_POST["min_knife_vl"]."', '".$_POST["min_spear_vl"]."', '".$_POST["min_fire"]."','".$_POST["min_water"]."','".$_POST["min_air"]."','".$_POST["min_earth"]."','".$_POST["min_svet"]."','".$_POST["min_tma"]."','".$_POST["min_gray"]."', '".$_POST["add_fire"]."', '".$_POST["add_water"]."', '".$_POST["add_air"]."', '".$_POST["add_earth"]."', '".$_POST["add_svet"]."', '".$_POST["add_tma"]."', '".$_POST["add_gray"]."', '".$_POST["add_sila"]."', '".$_POST["add_lovkost"]."', '".$_POST["add_udacha"]."', '".$_POST["add_intellekt"]."', '".$_POST["add_duxovnost"]."', '".$_POST["add_hp"]."', '".$_POST["add_mana"]."', '".$_POST["protect_head"]."', '".$_POST["protect_arm"]."', '".$_POST["protect_corp"]."', '".$_POST["protect_poyas"]."', '".$_POST["protect_legs"]."', '".$_POST["protect_rej"]."', '".$_POST["protect_drob"]."', '".$_POST["protect_kol"]."', '".$_POST["protect_rub"]."', '".$_POST["protect_fire"]."', '".$_POST["protect_water"]."', '".$_POST["protect_air"]."', '".$_POST["protect_earth"]."', '".$_POST["protect_svet"]."', '".$_POST["protect_tma"]."', '".$_POST["protect_gray"]."', '".$_POST["protect_mag"]."', '".$_POST["protect_udar"]."','".$_POST["shieldblock"]."','".$_POST["krit"]."', '".$_POST["akrit"]."', '".$_POST["uvorot"]."', '".$_POST["auvorot"]."', '".$_POST["parry"]."', '".$_POST["counter"]."', '".$_POST["add_rej"]."', '".$_POST["add_drob"]."', '".$_POST["add_kol"]."', '".$_POST["add_rub"]."', '".$_POST["ms_udar"]."', '".$_POST["ms_krit"]."', '".$_POST["ms_mag"]."', '".$_POST["ms_fire"]."', '".$_POST["ms_water"]."', '".$_POST["ms_air"]."', '".$_POST["ms_earth"]."', '".$_POST["ms_svet"]."', '".$_POST["ms_tma"]."', '".$_POST["ms_gray"]."', '".$_POST["ms_rej"]."', '".$_POST["ms_drob"]."', '".$_POST["ms_kol"]."', '".$_POST["ms_rub"]."', '".$_POST["iznos_max"]."', '".$_POST["min_attack"]."', '".$_POST["max_attack"]."', '".$_POST["proboy"]."','".$_POST["add_oruj"]."' ,'".$_POST["add_sword_vl"]."', '".$_POST["add_staff_vl"]."', '".$_POST["add_axe_vl"]."', '".$_POST["add_fail_vl"]."', '".$_POST["add_knife_vl"]."', '".$_POST["add_spear_vl"]."', '".$_POST["count_mag"]."', '".$_POST["need_orden"]."', '".$_POST["sex"]."', '".$_POST["art"]."', '".$_POST["podzemka"]."', '".$_POST["is_personal"]."', '".$_POST["personal_owner"]."', '".$_POST["noremont"]."', '".$_POST["two_hand"]."', '".$_POST["second_hand"]."',  '".$_POST["add_fire_att"]."', '".$_POST["add_air_att"]."', '".$_POST["add_watet_att"]."', '".$_POST["add_earth_att"]."', '".$_POST["edited"]."');");
				$insert_id=mysql_insert_id();
				$img_name=$_POST["object_type"]."/".$insert_id.$ext;
				$image = $road.$img_name;
				
				// ���������� ���� �� ��������� ���������� ������� � ����� �������
				if (copy($_FILES['img']['tmp_name'], $image))
	   			{
					// ���������� ���� �� ��������� ����������
					unlink($HTTP_POST_FILES['img']['tmp_name']);
				}
				mysql_query("UPDATE paltar SET img='".$img_name."' WHERE id=".$insert_id);
				echo "���� <font color=red><b>".$_POST["name"]."</font></b> ���-��� <b>".$_POST["count_mag"]."</b> �����������. [ID=".$insert_id."]";
			} 
			else 
			{ 
				$msg="��������� �������� ��������� 100x100!";
			}
		} 
		else 
		{ 
			$msg="����������� ���� ���� �� ��������� GIF ��� PNG ��������!";
		}
	}
	else
	{
		$msg="�� �� ������ ��������� ��������...";
	}	
}
//--------------------------------------------------------------------
if ($_GET["type"]=="priem")
{	
	echo"<table border=0><tr>";
	$all_priem = mysql_query("SELECT * FROM priem ORDER BY mag ASC, level ASC, type ASC");
	$i=0;
	while ($a_p = mysql_fetch_array($all_priem))
	{
		if(($i % 15) == 0) echo "</tr>";
		echo "<td>\n<img src='img/priem/misc/".$a_p["id"].".gif' title='".$a_p["name"]."' onclick=\"document.location='?type=priem&edit=$a_p[id]'\" style='cursor:hand;'>\n</td>";
		$i++;
	}
	echo"</tr></table>";
	if ($_GET["edit"])
	{
		if ($_POST["priem_id"] && $_SESSION["login"]=="bor")
		{
			mysql_query("UPDATE priem SET 
			name='".$_POST["priem_name"]."',  about='".$_POST["about"]."',  level='".$_POST["level"]."',
			intellekt='".$_POST["intellekt"]."',  vospriyatie='".$_POST["vospriyatie"]."',  mana='".$_POST["mana"]."',
			water_magic='".$_POST["water_magic"]."', earth_magic='".$_POST["earth_magic"]."', fire_magic='".$_POST["fire_magic"]."', air_magic='".$_POST["air_magic"]."',
			krit='".$_POST["krit"]."', uvarot='".$_POST["uvarot"]."', hit='".$_POST["hit"]."', block='".$_POST["block"]."', hp='".$_POST["hp"]."', all_hit='".$_POST["all_hit"]."',
			hod='".$_POST["hod"]."',  wait='".$_POST["wait"]."',  parry='".$_POST["parry"]."',target='".$_POST["target"]."',type='".$_POST["type"]."',
			svet_magic='".$_POST["svet_magic"]."',  tma_magic='".$_POST["tma_magic"]."',  gray_magic='".$_POST["gray_magic"]."'
			WHERE id=".(int)$_POST["priem_id"]);
			
		}
		$priem_id=$_GET["edit"];
		$priem_id=mysql_fetch_array(mysql_query("SELECT * FROM priem WHERE id=$priem_id"));
		?>
		<table border=0>
		<tr>
			<td align=left valign=top>
			<form action='' method='post'>
					<INPUT TYPE=hidden name=priem_id value="<?=$priem_id['id']?>">
					�������� ������: <input type=text name='priem_name' value="<?=$priem_id['name']?>" class=new size=50><br>
					����������: <input type=text name='about' value="<?=$priem_id['about']?>" class=new size=100><br>
					���: <input type=text name='type' value="<?=$priem_id['type']?>" class=new size=30><br>
					����: <input type=text name='files' value="<?=$priem_id['files']?>.php" class=new size=30><br><br>
					
					���. �������: <input type=text name='level' value="<?=$priem_id['level']?>" class=new size=27><br>
					���. ���������: <input type=text name='intellekt' value="<?=$priem_id['intellekt']?>" class=new size=27><br>
					���. ����������: <input type=text name='vospriyatie' value="<?=$priem_id['vospriyatie']?>" class=new size=27><br>
					������ ����: <input type=text name='mana' value="<?=$priem_id['mana']?>" class=new size=27><br><br>

					���������� �������� ������� ����: <input type=text value="<?=$priem_id['water_magic']?>" name='water_magic' class=new size=27><br>
					���������� �������� ������� �����: <input type=text value="<?=$priem_id['earth_magic']?>" name='earth_magic' class=new size=27><br>
					���������� �������� ������� ����: <input type=text value="<?=$priem_id['fire_magic']?>" name='fire_magic' class=new size=27><br>
					���������� �������� ������� �������: <input type=text value="<?=$priem_id['air_magic']?>" name='air_magic' class=new size=27><br><br>
					
					���������� �������� ������� �����: <input type=text value="<?=$priem_id['svet_magic']?>" name='svet_magic' class=new size=27><br>
					���������� �������� ������� ����: <input type=text value="<?=$priem_id['tma_magic']?>" name='tma_magic' class=new size=27><br>
					���������� �������� ����� �����: <input type=text value="<?=$priem_id['gray_magic']?>" name='gray_magic' class=new size=27><br><br>
					
					����������� ����: <input type=text name='krit' value="<?=$priem_id['krit']?>" class=new size=27><br>
					����������� ������: <input type=text name='uvarot' value="<?=$priem_id['uvarot']?>" class=new size=27><br>
					���������� ����: <input type=text name='hit' value="<?=$priem_id['hit']?>" class=new size=27><br>
					�������� ����: <input type=text name='block' value="<?=$priem_id['block']?>" class=new size=27><br>
					������� ����: <input type=text name='hp' value="<?=$priem_id['hp']?>" class=new size=27><br>
					���������� ����: <input type=text name='all_hit' value="<?=$priem_id['all_hit']?>" class=new size=27><br>
					�����������: <input type=text name='parry' value="<?=$priem_id['parry']?>" class=new size=27><br><br>
					
					����� ������ ���: <input type=text name='hod' value="<?=$priem_id['hod']?>" class=new size=27><br>
					��������: <input type=text name='wait' value="<?=$priem_id['wait']?>" class=new size=27><br>
					Target: <input type=text name='target' value="<?=$priem_id['target']?>" class=new size=27><br>
					<br>	
						
				<input type=submit value=" ������� " class=new>
			</form>
			</td>
		</tr>
		</table>
		<?
	}
}
//--------------------------------------------------------------------
if ($_GET["type"]=="runa")
{	
	echo"<table border=0><tr>";
	$all_runa = mysql_query("SELECT * FROM `runa`");
	$i=0;
	while ($a_p = mysql_fetch_array($all_runa))
	{
		if(($i % 10) == 0) echo "</tr>";
		echo "<td>\n<img src='img/runa/".$a_p["id"].".gif' onclick=\"document.location='?type=runa&edit=$a_p[id]'\" style='cursor:hand;' title='$a_p[name]'>\n</td>";
		$i++;
	}
	echo"</tr></table>";
	if ($_GET["edit"])
	{
		if ($_POST["runa_id"] && $_SESSION["login"]=="bor")
		{
			mysql_query("UPDATE runa SET 
			name='".$_POST["name"]."',  type='".$_POST["type"]."',
			min_level='".$_POST["min_level"]."',img='".$_POST["img"]."',
			step='".$_POST["step"]."',price='".$_POST["price"]."',mass='".$_POST["mass"]."',
			counter='".$_POST["counter"]."',parry='".$_POST["parry"]."',
			add_sila='".$_POST["add_sila"]."', add_lovkost='".$_POST["add_lovkost"]."', add_udacha='".$_POST["add_udacha"]."', add_intellekt='".$_POST["add_intellekt"]."',	
			add_hp='".$_POST["add_hp"]."', add_mana='".$_POST["add_mana"]."', 
			protect_mag='".$_POST["protect_mag"]."', protect_udar='".$_POST["protect_udar"]."',
			add_krit='".$_POST["add_krit"]."', add_akrit='".$_POST["add_akrit"]."', add_uvorot='".$_POST["add_uvorot"]."', add_auvorot='".$_POST["add_auvorot"]."',	
			ms_krit='".$_POST["ms_krit"]."', ms_udar='".$_POST["ms_udar"]."', ms_mag='".$_POST["ms_mag"]."'
			WHERE id=".(int)$_POST["runa_id"]);
		}
		$runa_id=$_GET["edit"];
		$runa=mysql_fetch_array(mysql_query("SELECT * FROM `runa` WHERE id=$runa_id"));
		?>
		<table border=0>
		<tr>
			<td align=left valign=top>
			<form action='' method='post'>
					<INPUT TYPE=hidden name="runa_id" value="<?=$runa['id']?>">
					��������: <input type=text name='name' value="<?=$runa['name']?>" class=new size=50><br>
					���: <input type=text name='type' value="<?=$runa['type']?>" class=new size=30><br>
					IMG: <input type=text name='img' value="<?=$runa['img']?>" class=new size=30><br>
					STEP: <input type=text name='step' value="<?=$runa['step']?>" class=new size=30><br>
					�������: <input type=text name='min_level' value="<?=$runa['min_level']?>" class=new size=30><br>
					����: <input type=text name='price' value="<?=$runa['price']?>" class=new size=30><br>
					�����: <input type=text name='mass' value="<?=$runa['mass']?>" class=new size=30><br><br>
			
					����: + <input type=text name='add_sila' value="<?=$runa['add_sila']?>" class=new size=30><br>
					��������: + <input type=text name='add_lovkost' value="<?=$runa['add_lovkost']?>" class=new size=30><br>	
					�����: + <input type=text name='add_udacha' value="<?=$runa['add_udacha']?>" class=new size=30><br>	
					���������: + <input type=text name='add_intellekt' value="<?=$runa['add_intellekt']?>" class=new size=30><br><br>
					
					������� �����: + <input type=text name='add_hp' value="<?=$runa['add_hp']?>" class=new size=30><br>
					������� ����: + <input type=text name='add_mana' value="<?=$runa['add_mana']?>" class=new size=30><br><br>	
						
					������ �� �����: + <input type=text name='protect_mag' value="<?=$runa['protect_mag']?>" class=new size=30><br>
					������ �� �����: + <input type=text name='protect_udar' value="<?=$runa['protect_udar']?>" class=new size=30><br><br>
						
					��. �����������: + <input type=text name='add_krit' value="<?=$runa['add_krit']?>" class=new size=30><br>
					��. ������ ����: + <input type=text name='add_akrit' value="<?=$runa['add_akrit']?>" class=new size=30><br>
					��. �����������: + <input type=text name='add_uvorot' value="<?=$runa['add_uvorot']?>" class=new size=30><br>
					��. ������ �����������: + <input type=text name='add_auvorot' value="<?=$runa['add_auvorot']?>" class=new size=30><br><br>
						
					��. �������� ����: + <input type=text name='ms_krit' value="<?=$runa['ms_krit']?>" class=new size=30><br>
					��. �������� �����: + <input type=text name='ms_udar' value="<?=$runa['ms_udar']?>" class=new size=30><br>
					��. �������� �����: + <input type=text name='ms_mag' value="<?=$runa['ms_mag']?>" class=new size=30><br><br>
						
					��. ����������: + <input type=text name='counter' value="<?=$runa['counter']?>" class=new size=30><br>
					��. �����������: + <input type=text name='parry' value="<?=$runa['parry']?>" class=new size=30><br><br>	
					<br>
					<input type=submit value=" ������� " class=new>
			</form>
			</td>
		</tr>
		</table>
		<?
	}
}
//--------------------------------------------------------------------
if ($_GET["type"]=="old")
{
	$db_items="paltar1";
	if (!$_GET["otdel"])$otdel="sword";
	else $otdel=$_GET["otdel"];
	echo '<table width=100%><tr><td nowrap width=100% valign=top>';
	echo '<TABLE width=100% cellspacing=1 cellpadding=3 bgcolor=A5A5A5>';
	$query=mysql_query("SELECT * FROM paltar_old WHERE object='{$otdel}' ORDER BY min_level ASC, price ASC");
	while ($res=mysql_fetch_array($query))
	{
		$n=(!$n);
		echo '<tr bgcolor='.($n?'#C7C7C7':'#D5D5D5').'>
					<td valign=center align=center width=150 nowrap><img src="img/'.$res['img'].'?'.md5(time()).'"></td>
					<td>';
					show_item($db,$res);
					echo '</td>
			</tr>
		
		';
	}
	echo '</table>';
	echo '</td>';
	echo '<td nowrap valign=top>';
	include("inc/shop/otdel_edit.php");
	echo '</td>';
	echo '</tr></table>
	
	';
}
//--------------------------------------------------------------------
if ($_GET["type"]=="resurs")
{
	echo '<TABLE width=100% cellspacing=1>';
    echo"<tr>";
	$query=mysql_query("SELECT * FROM wood WHERE 1 ORDER BY id ASC");
	while($DAT = mysql_fetch_assoc($query))
	{
		if(($i % 15) == 0) echo "</tr>";
		echo "<td><img src='img/".$DAT["img"]."' title='".$DAT["name"]."' onclick=\"document.location='?type=resurs&edit=$DAT[id]'\" style='cursor:hand;'></td>";
		$i++;
	}
	echo '</tr></table>';
	if ($_GET["edit"])
	{
		if ($_POST["resurs_id"] && $_SESSION["login"]=="bor")
		{
			mysql_query("UPDATE wood SET name='".$_POST["name"]."', img='".$_POST["img"]."', price='".$_POST["price"]."',mass='".$_POST["mass"]."' WHERE id=".(int)$_POST["resurs_id"]);
		}
		$resurs_id=$_GET["edit"];
		$resurs=mysql_fetch_array(mysql_query("SELECT * FROM `wood` WHERE id=$resurs_id"));
		?>
		<table border=0>
		<tr>
			<td align=left valign=top>
			<form action='' method='post'>
					<INPUT TYPE=hidden name="resurs_id" value="<?=$resurs['id']?>">
					��������: <input type=text name='name' value="<?=$resurs['name']?>" class=new size=50><br>
					IMG: <input type=text name='img' value="<?=$resurs['img']?>" class=new size=30><br>
					����: <input type=text name='price' value="<?=$resurs['price']?>" class=new size=30><br>
					�����: <input type=text name='mass' value="<?=$resurs['mass']?>" class=new size=30><br><br>
					<input type=submit value=" ������� " class=new>
			</form>
			</td>
		</tr>
		</table>
		<?
	}
}
//--------------------------------------------------------------------
if ($_GET["type"]=="all_things")
{
	$query=mysql_query("SELECT * FROM paltar ORDER BY object ASC,min_level ASC, price ASC");
	while ($res=mysql_fetch_array($query))
	{
		$object_old=$res['object'];
		if ($object_old!=$object_new){$object_old=$res['object'];$object_new=$res['object'];echo "<hr><br>";}
		echo "<img src='img/items/".$res['img']."' title='".$res['name']." \n Item Id: ".$res['id']."'> ";
	}
}
//--------------------------------------------------------------------
if ($_GET["type"]=="flower")
{
	$query=mysql_query("SELECT * FROM flower WHERE 1 ORDER BY price ASC");
	while ($res=mysql_fetch_array($query))
	{
		echo "<img src='img/".$res["img"]."' title='".$res["name"]."\nID:".$res['id']."'>&nbsp;";
	}
}
//--------------------------------------------------------------------
if ($_GET["type"]=="medal")
{
	echo "	<TABLE width=100% cellspacing=1 cellpadding=5 bgcolor=A5A5A5>";
	$seek = mysql_query("SELECT * FROM medal WHERE 1 ORDER BY id ASC");
	while ($dat = mysql_fetch_array($seek))
	{
		$n=(!$n);
		echo "<TR  bgcolor=".($n?'#D5D5D5':'#C7C7C7').">
		<TD valign=center align=center width=150>
			<img src='".$dat["img"]."'><br>[ID:".$dat["id"]."]
		</td>
		<td valign=top><b>".$dat["name"]."</b></td></tr>";
	}
	echo "</table>";
}
//--------------------------------------------------------------------

if ($_GET["type"]=="eliks")
{
	echo "	<TABLE width=100% cellspacing=1 cellpadding=5 bgcolor=A5A5A5>";
	$seek = mysql_query("SELECT * FROM scroll WHERE 1 ORDER BY min_level ASC, price ASC");
	while ($dat = mysql_fetch_array($seek))
	{
		$n=(!$n);
		echo "<TR  bgcolor=".($n?'#D5D5D5':'#C7C7C7').">
		<TD valign=center align=center width=150>
			<img src='img/".$dat["img"]."'><br>[ID:".$dat["id"]."]
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
			echo "&nbsp; <img src='img/orden/".$dat["need_orden"]."/10.gif' border=0 alt='��������� �����:\n".$orden_dis."'>";
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
}
//--------------------------------------------------------------------
if ($_GET["type"]=="edit")
{
	if ($_GET["dubl_id"])
	{
		DuplicateMySQLRecord ("paltar", "id", $_GET["dubl_id"]);
	}	
	if (!$_GET["item_id"] && !$_GET["edit_id"])
	{
		$db_items="paltar";
		if (!$_GET["otdel"])$otdel="sword";
		else $otdel=$_GET["otdel"];
		if ($_GET["sort"]==1)$str=" and art=1 ";
		else if ($_GET["sort"]==2)$str=" and art=2 ";
		else if ($_GET["sort"]==3)$str=" and podzemka=1 ";
		echo "������: <a href='?type=edit&otdel=$otdel'>���</a> |  <a href='?type=edit&otdel=$otdel&sort=1'>ART1</a> |  <a href='?type=edit&otdel=$otdel&sort=2'>ART2</a> |  <a href='?type=edit&otdel=$otdel&sort=3'>���������</a>";
		echo '<table width=100%><tr><td nowrap width=100% valign=top>';
		echo '<TABLE width=100% cellspacing=1 cellpadding=3 bgcolor=A5A5A5>';
		$query=mysql_query("SELECT * FROM paltar WHERE object='{$otdel}' $str ORDER BY min_level ASC, price ASC");
		while ($res=mysql_fetch_array($query))
		{
			$n=(!$n);
			echo '<tr bgcolor='.($n?'#C7C7C7':'#D5D5D5').'><td valign=center align=center width=150 nowrap><img src="img/items/'.$res['img'].'?'.md5(time()).'">
			<br><a href="?type=edit&item_id='.$res['id'].'&'.md5(time()).'">������� �������</a>
			<br><a href="?type=edit&edit_id='.$res['id'].'&'.md5(time()).'">������� �����e</a>
			<br><br><br><a href="?type=edit&dubl_id='.$res['id'].'&'.md5(time()).'">��������</a>
			<br>ID=['.$res['id'].']
			</td>
			<td>';
			show_item($db,$res);
			echo '
			<br>(����������: '.$res["mountown"].')</td>';
			echo '</tr>';
		}
		echo '</table>
		</td>
		<td nowrap valign=top>
		';
		include("inc/shop/otdel_edit.php");
		echo '</td>';
		echo '</tr></table>';
	}
	else if ($_GET["item_id"])
	{
		$query=mysql_query("SELECT * FROM paltar WHERE id=".$_GET["item_id"]);
		$res=mysql_fetch_array($query);
		if ($_POST["change_img"])
		{
			$road="img/items/";
			if(is_uploaded_file($_FILES['img']['tmp_name']))
			{
				$ext = strrchr($_FILES['img']['name'], ".");  
				if ($ext=='.gif' || $ext=='.png') 
				{
					$size_img = getimagesize($HTTP_POST_FILES['img']['tmp_name']);
					if ($size_img['0']<=100 && $size_img['1']<=100)
					{
						$img_name=$res["object"]."/".$res["id"].$ext;
						$image = $road.$img_name;
						
						// ���������� ���� �� ��������� ���������� ������� � ����� �������
						if (copy($_FILES['img']['tmp_name'], $image))
			   			{
							// ���������� ���� �� ��������� ����������
							unlink($HTTP_POST_FILES['img']['tmp_name']);
						}
						mysql_query("UPDATE paltar SET img='".$img_name."' WHERE id=".$res["id"]);
						$msg= "Image Changed";
					} 
					else 
					{ 
						$msg="��������� �������� ��������� 100x100!";
					}
				} 
				else 
				{ 
					$msg="����������� ���� ���� �� ��������� GIF ��� PNG ��������!";
				}
			}
			else
			{
				$msg="�� �� ������ ��������� ��������...";
			}	
		}
		echo "<form name='action' action='' method='POST' enctype='multipart/form-data'>";
		echo "<TABLE width=300 cellspacing=1 cellpadding=3 bgcolor=A5A5A5>";
		echo "<tr bgcolor=".($n?'#C7C7C7':'#D5D5D5')."><td valign=center align=center width=150 nowrap><img src='img/items/".$res['img']."?".md5(time())."'></td>";
		echo "<td><font color=RED><b>���� � �������: </b></font><INPUT type='file' name='img' id='img' class='new'></td>";
		echo "</tr>";
		echo "<tr><td colspan=2 align=center><input type=submit name='change_img' value='�������' class='newbut'></td></tr>";
		echo "</table>";
	}
	else if ($_GET["edit_id"])
	{
		if ($_POST["edit"])
		{
			if ($_POST['two_hand']>0)$_POST['second_hand']=0;
			mysql_query("UPDATE paltar SET object='".$_POST['object_type']."', name='".$_POST['name']."', mass='".$_POST['mass']."', price='".$_POST['price']."', 
			min_sila='".$_POST['min_sila']."', min_lovkost ='".$_POST['min_lovkost']."', min_udacha='".$_POST['min_udacha']."', 
			min_power='".$_POST['min_power']."', min_intellekt='".$_POST['min_intellekt']."', min_vospriyatie='".$_POST['min_vospriyatie']."', 
			min_level='".$_POST['min_level']."', min_sword_vl='".$_POST['min_sword_vl']."', min_staff_vl='".$_POST['min_staff_vl']."', 
			min_axe_vl='".$_POST['min_axe_vl']."', min_fail_vl='".$_POST['min_fail_vl']."', min_knife_vl='".$_POST['min_knife_vl']."', 	
			min_spear_vl='".$_POST['min_spear_vl']."', add_fire='".$_POST['add_fire']."', add_water='".$_POST['add_water']."', 
			add_air='".$_POST['add_air']."', add_earth='".$_POST['add_earth']."', add_svet='".$_POST['add_svet']."', add_tma='".$_POST['add_tma']."', 
			add_gray='".$_POST['add_gray']."', add_sila='".$_POST['add_sila']."', add_lovkost='".$_POST['add_lovkost']."', 
			add_udacha='".$_POST['add_udacha']."', add_intellekt='".$_POST['add_intellekt']."', add_duxovnost='".$_POST['add_duxovnost']."', 
			add_hp='".$_POST['add_hp']."', add_mana='".$_POST['add_mana']."', protect_head='".$_POST['protect_head']."', 
			protect_arm='".$_POST['protect_arm']."', protect_corp='".$_POST['protect_corp']."', protect_poyas='".$_POST['protect_poyas']."', 
			protect_legs='".$_POST['protect_legs']."', protect_rej='".$_POST['protect_rej']."', protect_drob='".$_POST['protect_drob']."', 
			protect_kol='".$_POST['protect_kol']."', protect_rub='".$_POST['protect_rub']."', protect_fire='".$_POST['protect_fire']."', 
			protect_water='".$_POST['protect_water']."', protect_air='".$_POST['protect_air']."', protect_earth='".$_POST['protect_earth']."', 
			protect_svet='".$_POST['protect_svet']."', protect_tma='".$_POST['protect_tma']."', protect_gray='".$_POST['protect_gray']."', 
			protect_mag='".$_POST['protect_mag']."', protect_udar='".$_POST['protect_udar']."',shieldblock='".$_POST['shieldblock']."', krit='".$_POST['krit']."', akrit='".$_POST['akrit']."', 
			uvorot='".$_POST['uvorot']."', auvorot='".$_POST['auvorot']."', parry='".$_POST['parry']."', counter='".$_POST['counter']."', 
			add_rej='".$_POST['add_rej']."', add_drob='".$_POST['add_drob']."', add_kol='".$_POST['add_kol']."', add_rub='".$_POST['add_rub']."', 
			ms_udar='".$_POST['ms_udar']."', ms_krit='".$_POST['ms_krit']."', ms_mag='".$_POST['ms_mag']."', ms_fire='".$_POST['ms_fire']."', 
			ms_water='".$_POST['ms_water']."', ms_air='".$_POST['ms_air']."', ms_earth='".$_POST['ms_earth']."', ms_svet='".$_POST['ms_svet']."', 
			ms_tma='".$_POST['ms_tma']."', ms_gray='".$_POST['ms_gray']."', ms_rej='".$_POST['ms_rej']."', ms_drob='".$_POST['ms_drob']."', 
			ms_kol='".$_POST['ms_kol']."', ms_rub='".$_POST['ms_rub']."', iznos_max='".$_POST['iznos_max']."', min_attack='".$_POST['min_attack']."', 
			max_attack='".$_POST['max_attack']."', proboy='".$_POST['proboy']."',add_oruj='".$_POST['add_oruj']."' ,add_sword_vl='".$_POST['add_sword_vl']."', 
			add_staff_vl='".$_POST['add_staff_vl']."', add_axe_vl='".$_POST['add_axe_vl']."', add_fail_vl='".$_POST['add_fail_vl']."', 
			add_knife_vl='".$_POST['add_knife_vl']."', add_spear_vl='".$_POST['add_spear_vl']."', mountown='".$_POST['mountown']."', 
			need_orden='".$_POST['need_orden']."', sex='".$_POST['sex']."', art='".$_POST['art']."', podzemka='".$_POST['podzemka']."', 
			is_personal='".$_POST['is_personal']."', personal_owner='".$_POST['personal_owner']."', noremont='".$_POST['noremont']."',
			two_hand='".$_POST['two_hand']."', second_hand='".$_POST['second_hand']."',
			min_fire='".$_POST['min_fire']."', min_water='".$_POST['min_water']."', min_air='".$_POST['min_air']."', min_earth='".$_POST['min_earth']."', 
			min_svet='".$_POST['min_svet']."', min_tma='".$_POST['min_tma']."', min_gray='".$_POST['min_gray']."',
			add_fire_att='".$_POST['add_fire_att']."', add_air_att='".$_POST['add_air_att']."', add_watet_att='".$_POST['add_watet_att']."', add_earth_att='".$_POST['add_earth_att']."', edited='".$_POST['edited']."' WHERE id=".$_POST['id']);
			echo "ITEM EDITED!!!<br>";
		}
		$query=mysql_query("SELECT * FROM paltar WHERE id=".$_GET["edit_id"]);
		$res=mysql_fetch_array($query);
		?>
		<form name="action" action="" method="POST" enctype="multipart/form-data">
		<table border=0 width=600>
		<tr><td><font color=RED><b>ID: </b></font></td><td><input type=text name="id" value="<?=$res['id'];?>" class=new size=30></td></tr>	
		<tr><td><font color=RED><b>��������: </b></font></td><td><input type=text name="name" value="<?=$res['name'];?>" class=new size=30></td></tr>
		<tr><td><font color=RED><b>�����:</b><font></td><td><input type=text name="mass" value="<?=$res['mass'];?>" class=new size=30></td></tr>
		<tr><td><font color=RED><b>����: </b></font></td><td><input type=text name="price" value="<?=$res['price'];?>" class=new size=30></td></tr>
		<tr><td><font color=RED><b>�����: </b></font></td><td><input type=text name="iznos_max" value="<?=$res['iznos_max'];?>" class=new size=30></td></tr>
		<tr><td><font color=RED><b>���-�� � ����:</b></font></td><td><input type=text name="mountown" value="<?=$res['mountown'];?>" class=new size=30 value=10000></td></tr>
		<tr>
			<td>����� ��������:</td>
			<td>
				<select name="object_type" class=new>
					<option value="pants" <?=($res['object']=="pants"?"selected":"")?>>������
					<option value="kostyl" <?=($res['object']=="kostyl"?"selected":"")?>>��������
					<option value="amunition" <?=($res['object']=="amunition"?"selected":"")?>>�����������
					<option value="amulet" <?=($res['object']=="amulet"?"selected":"")?>>������
					<option value="naruchi" <?=($res['object']=="naruchi"?"selected":"")?>>������
					<option value="sword" <?=($res['object']=="sword"?"selected":"")?>>���
					<option value="axe" <?=($res['object']=="axe"?"selected":"")?>>�����
					<option value="fail" <?=($res['object']=="fail"?"selected":"")?>>�����/������
					<option value="knife" <?=($res['object']=="knife"?"selected":"")?>>���/������
					<option value="spear" <?=($res['object']=="spear"?"selected":"")?>>��������� ������
					<option value="staff" <?=($res['object']=="staff"?"selected":"")?>>������
					<option value="armour" <?=($res['object']=="armour"?"selected":"")?>>�����
					<option value="rubaxa" <?=($res['object']=="rubaxa"?"selected":"")?>>������
					<option value="plash" <?=($res['object']=="plash"?"selected":"")?>>�����
					<option value="poyas" <?=($res['object']=="poyas"?"selected":"")?>>����
					<option value="helmet" <?=($res['object']=="helmet"?"selected":"")?>>����
					<option value="mask" <?=($res['object']=="mask"?"selected":"")?>>�����
					<option value="masdrikon" <?=($res['object']=="masdrikon"?"selected":"")?>>����� � ����
					<option value="perchi" <?=($res['object']=="perchi"?"selected":"")?>>��������
					<option value="rukavic" <?=($res['object']=="rukavic"?"selected":"")?>>��������
					<option value="shield" <?=($res['object']=="shield"?"selected":"")?>>���
					<option value="boots" <?=($res['object']=="boots"?"selected":"")?>>������
					<option value="ring" <?=($res['object']=="ring"?"selected":"")?>>������
				</select>
			</td>
		</tr>
		<tr>
			<td>������ ������:</td>
			<td>
				<select name="second_hand" class=new>
					<option value='0'>NO
					<option value='1' <?echo ($res['second_hand']?"selected":"")?>>YES
				</select>
			</td>
		</tr>
		<tr>
			<td>��������� ������:</td>
			<td>
				<select name="two_hand" class=new>
					<option value='0'>No
					<option value="1" <?echo ($res['two_hand']?"selected":"")?>>YES
				</select>
			</td>
		</tr>	
		<tr><td colspan=2><br><b>��������� �����������:</td></tr>

		<tr><td>���. �������:</b></td><td><input type=text name="min_level" value="<?=$res['min_level'];?>" class=new size=30></td></tr>
		<tr><td>���. ����:</td><td><input type=text name="min_sila" value="<?=$res['min_sila'];?>" class=new size=30></td></tr>
		<tr><td>���. ��������:</td><td><input type=text name="min_lovkost" value="<?=$res['min_lovkost'];?>" class=new size=30></td></tr>
		<tr><td>���. �����:</td><td><input type=text name="min_udacha" value="<?=$res['min_udacha'];?>" class=new size=30></td></tr>
		<tr><td>���. ������������:</td><td><input type=text name="min_power" value="<?=$res['min_power'];?>" class=new size=30></td></tr>
		<tr><td>���. ���������:</td><td><input type=text name="min_intellekt" value="<?=$res['min_intellekt'];?>" class=new size=30></td></tr>
		<tr><td>���. ����������:</td><td><input type=text name="min_vospriyatie" value="<?=$res['min_vospriyatie'];?>" class=new size=30></td></tr>

		<tr><td colspan=2><br></td></tr>
		
		<tr><td>���. ������ ����:</td><td><input type=text name="min_fire" value="<?=$res['min_fire'];?>" class=new size=30></td></tr>
		<tr><td>���. ������ ����:</td><td><input type=text name="min_water" value="<?=$res['min_water'];?>" class=new size=30></td></tr>
		<tr><td>���. ������ �������:</td><td><input type=text name="min_air" value="<?=$res['min_air'];?>" class=new size=30></td></tr>
		<tr><td>���. ������ �����:</td><td><input type=text name="min_earth" value="<?=$res['min_earth'];?>" class=new size=30></td></tr>
		<tr><td>���. ������ �����:</td><td><input type=text name="min_svet" value="<?=$res['min_svet'];?>" class=new size=30></td></tr>
		<tr><td>���. ������ ����:</td><td><input type=text name="min_tma" value="<?=$res['min_tma'];?>" class=new size=30></td></tr>
		<tr><td>���. ����� ������:</td><td><input type=text name="min_gray" value="<?=$res['min_gray'];?>" class=new size=30></td></tr>
		
		<tr><td colspan=2><br></td></tr>
		
		<tr><td>���. �������� ������:</td><td><input type=text name="min_sword_vl" value="<?=$res['min_sword_vl'];?>" class=new size=30></td></tr>
		<tr><td>���. �������� ��������:</td><td><input type=text name="min_axe_vl" value="<?=$res['min_axe_vl'];?>" class=new size=30></td></tr>
		<tr><td>���. �������� ��������:</td><td><input type=text name="min_fail_vl" value="<?=$res['min_fail_vl'];?>" class=new size=30></td></tr>
		<tr><td>���. �������� ������:</td><td><input type=text name="min_knife_vl" value="<?=$res['min_knife_vl'];?>" class=new size=30></td></tr>
		<tr><td>���. �������� �������:</td><td><input type=text name="min_spear_vl" value="<?=$res['min_spear_vl'];?>" class=new size=30></td></tr>
		<tr><td>���. �������� ��������:</td><td><input type=text name="min_staff_vl" value="<?=$res['min_staff_vl'];?>" class=new size=30></td></tr>
				
		<tr><td colspan=2><br><b>��������� ��</td></tr>

		<tr><td>+ ����:</td><td><input type=text name="add_sila" value="<?=$res['add_sila'];?>" class=new size=30></td></tr>
		<tr><td>+ ��������:</td><td><input type=text name="add_lovkost" value="<?=$res['add_lovkost'];?>" class=new size=30></td></tr>
		<tr><td>+ �����:</td><td><input type=text name="add_udacha" value="<?=$res['add_udacha'];?>" class=new size=30></td></tr>
		<tr><td>+ ���������:</td><td><input type=text name="add_intellekt" value="<?=$res['add_intellekt'];?>" class=new size=30></td></tr>
		<tr><td>+ ����������:</td><td><input type=text name="add_duxovnost" value="<?=$res['add_duxovnost'];?>" class=new size=30></td></tr>
		<tr><td>+ HP:</td><td><input type=text name="add_hp" value="<?=$res['add_hp'];?>" class=new size=30></td></tr>
		<tr><td>+ MN:</td><td><input type=text name="add_mana" value="<?=$res['add_mana'];?>" class=new size=30></td></tr>

		<tr><td colspan=2><br><b>��������</td></tr>
			
		<tr><td>+ �������� ������� :</td><td><input type=text name="add_oruj" value="<?=$res['add_oruj'];?>" class=new size=30></td></tr>			
		<tr><td>+ �������� ������:</td><td><input type=text name="add_sword_vl" value="<?=$res['add_sword_vl'];?>" class=new size=30></td></tr>
		<tr><td>+ �������� ��������:</td><td><input type=text name="add_axe_vl" value="<?=$res['add_axe_vl'];?>" class=new size=30></td></tr>
		<tr><td>+ �������� ��������:</td><td><input type=text name="add_fail_vl" value="<?=$res['add_fail_vl'];?>" class=new size=30></td></tr>
		<tr><td>+ �������� ������:</td><td><input type=text name="add_knife_vl" value="<?=$res['add_knife_vl'];?>" class=new size=30></td></tr>
		<tr><td>+ �������� �������:</td><td><input type=text name="add_spear_vl" value="<?=$res['add_spear_vl'];?>" class=new size=30></td></tr>
		<tr><td>+ �������� ��������:</td><td><input type=text name="add_staff_vl" value="<?=$res['add_staff_vl'];?>" class=new size=30></td></tr>

		<tr><td colspan=2><br></td></tr>

		<tr><td>+ �������� ������ ����:</td><td><input type=text name="add_fire" value="<?=$res['add_fire'];?>" class=new size=30></td></tr>
		<tr><td>+ �������� ������ ����:</td><td><input type=text name="add_water" value="<?=$res['add_water'];?>" class=new size=30></td></tr>
		<tr><td>+ �������� ������ �������:</td><td><input type=text name="add_air" value="<?=$res['add_air'];?>" class=new size=30></td></tr>
		<tr><td>+ �������� ������ �����:</td><td><input type=text name="add_earth" value="<?=$res['add_earth'];?>" class=new size=30></td></tr>
		<tr><td>+ �������� ������ �����:</td><td><input type=text name="add_svet" value="<?=$res['add_svet'];?>" class=new size=30></td></tr>
		<tr><td>+ �������� ������ ����:</td><td><input type=text name="add_tma" value="<?=$res['add_tma'];?>" class=new size=30></td></tr>	
		<tr><td>+ �������� ����� ������:</td><td><input type=text name="add_gray" value="<?=$res['add_gray'];?>" class=new size=30></td></tr>
			
		<tr><td colspan=2><br><b>������</td></tr>

		<tr><td>+ ����� ������:</td><td><input type=text name="protect_head" value="<?=$res['protect_head'];?>" class=new size=30></td></tr>
		<tr><td>+ ����� ���:</td><td><input type=text name="protect_arm" value="<?=$res['protect_arm'];?>" class=new size=30></td></tr>
		<tr><td>+ ����� �������:</td><td><input type=text name="protect_corp" value="<?=$res['protect_corp'];?>" class=new size=30></td></tr>
		<tr><td>+ ����� �����:</td><td><input type=text name="protect_poyas" value="<?=$res['protect_poyas'];?>" class=new size=30></td></tr>
		<tr><td>+ ����� ���:</td><td><input type=text name="protect_legs" value="<?=$res['protect_legs'];?>" class=new size=30></td></tr>

		<tr><td colspan=2><br></td></tr>

		<tr><td>+ ������ �� �����:</td><td><input type=text name="protect_mag" value="<?=$res['protect_mag'];?>" class=new size=30></td></tr>
		<tr><td>+ ������ �� �����:</td><td><input type=text name="protect_udar" value="<?=$res['protect_udar'];?>" class=new size=30></td></tr>
		
		<tr><td colspan=2><br></td></tr>	
		
		<tr><td>+ ��.����� �����:</td><td><input type=text name="shieldblock" value="<?=$res['shieldblock'];?>" class=new size=30></td></tr>

		<tr><td colspan=2><br></td></tr>

		<tr><td>+ ������ �� �������� �����:</td><td><input type=text name="protect_rej" value="<?=$res['protect_rej'];?>" class=new size=30></td></tr>
		<tr><td>+ ������ �� ��������� �����:</td><td><input type=text name="protect_drob" value="<?=$res['protect_drob'];?>" class=new size=30></td></tr>
		<tr><td>+ ������ �� �������� �����:</td><td><input type=text name="protect_kol" value="<?=$res['protect_kol'];?>" class=new size=30></td></tr>
		<tr><td>+ ������ �� �������� �����:</td><td><input type=text name="protect_rub" value="<?=$res['protect_rub'];?>" class=new size=30></td></tr>

		<tr><td colspan=2><br></td></tr>

		<tr><td>+ ��������� ������ �� ����� ����:</td><td><input type=text name="protect_fire" value="<?=$res['protect_fire'];?>" class=new size=30></td></tr>
		<tr><td>+ ��������� ������ �� ����� ����:</td><td><input type=text name="protect_water" value="<?=$res['protect_water'];?>" class=new size=30></td></tr>
		<tr><td>+ ��������� ������ �� ����� �������:</td><td><input type=text name="protect_air" value="<?=$res['protect_air'];?>" class=new size=30></td></tr>
		<tr><td>+ ��������� ������ �� ����� �����:</td><td><input type=text name="protect_earth" value="<?=$res['protect_earth'];?>" class=new size=30></td></tr>
		<tr><td>+ ��������� ������ �� ����� �����:</td><td><input type=text name="protect_svet" value="<?=$res['protect_svet'];?>" class=new size=30></td></tr>
		<tr><td>+ ��������� ������ �� ����� ����:</td><td><input type=text name="protect_tma" value="<?=$res['protect_tma'];?>" class=new size=30></td></tr>
		<tr><td>+ ��������� ������ �� ����� �����:</td><td><input type=text name="protect_gray" value="<?=$res['protect_gray'];?>" class=new size=30></td></tr>


		<tr><td colspan=2><br><b>��.</td></tr>

		<tr><td>+ ��. ����:</td><td><input type=text name="krit" value="<?=$res['krit'];?>" class=new size=30></td></tr>
		<tr><td>+ ��. ��������:</td><td><input type=text name="akrit" value="<?=$res['akrit'];?>" class=new size=30></td></tr>
		<tr><td>+ ��. ������:</td><td><input type=text name="uvorot" value="<?=$res['uvorot'];?>" class=new size=30></td></tr>
		<tr><td>+ ��. ����������:</td><td><input type=text name="auvorot" value="<?=$res['auvorot'];?>" class=new size=30></td></tr>
		<tr><td>+ ��. �����������:</td><td><input type=text name="parry" value="<?=$res['parry'];?>" class=new size=30></td></tr>
		<tr><td>+ ��. ����������:</td><td><input type=text name="counter" value="<?=$res['counter'];?>" class=new size=30></td></tr>

		<tr><td colspan=2><br></td></tr>

		<tr><td>+ ��. �������� �����:</td><td><input type=text name="add_rej" value="<?=$res['add_rej'];?>" class=new size=30></td></tr>
		<tr><td>+ ��. ��������� �����:</td><td><input type=text name="add_drob" value="<?=$res['add_drob'];?>" class=new size=30></td></tr>
		<tr><td>+ ��. �������� �����:</td><td><input type=text name="add_kol" value="<?=$res['add_kol'];?>" class=new size=30></td></tr>
		<tr><td>+ ��. �������� �����:</td><td><input type=text name="add_rub" value="<?=$res['add_rub'];?>" class=new size=30></td></tr>

		<tr><td>+ ��. �������� �����:</td><td><input type=text name="add_fire_att" value="<?=$res['add_fire_att'];?> "class=new size=30></td></tr>
		<tr><td>+ ��. ������������� �����:</td><td><input type=text name="add_air_att" value="<?=$res['add_air_att'];?>" class=new size=30></td></tr>
		<tr><td>+ ��. ������� �����:</td><td><input type=text name="add_watet_att" value="<?=$res['add_watet_att'];?>" class=new size=30></td></tr>
		<tr><td>+ ��. �������� �����:</td><td><input type=text name="add_earth_att" value="<?=$res['add_earth_att'];?>" class=new size=30></td></tr>

		<tr><td colspan=2><br><b>��. ��������</td></tr>

		<tr><td>+ ��. �������� �����:</td><td><input type=text name="ms_udar" value="<?=$res['ms_udar'];?>" class=new size=30></td></tr>
		<tr><td>+ ��. �������� ������������ �����:</td><td><input type=text name="ms_krit" value="<?=$res['ms_krit'];?>" class=new size=30></td></tr>

		<tr><td colspan=2><br></td></tr>

		<tr><td>+ ��. �������� �������� �����:</td><td><input type=text name="ms_rej" value="<?=$res['ms_rej'];?>" class=new size=30></td></tr>
		<tr><td>+ ��. �������� ��������� �����:</td><td><input type=text name="ms_drob" value="<?=$res['ms_drob'];?>" class=new size=30></td></tr>
		<tr><td>+ ��. �������� �������� �����:</td><td><input type=text name="ms_kol" value="<?=$res['ms_kol'];?>" class=new size=30></td></tr>
		<tr><td>+ ��. �������� �������� �����:</td><td><input type=text name="ms_rub" value="<?=$res['ms_rub'];?>" class=new size=30></td></tr>

		<tr><td colspan=2><br></td></tr>

		<tr><td>+ ��. �������� �����:</td><td><input type=text name="ms_mag" value="<?=$res['ms_mag'];?>" class=new size=30></td></tr>
		<tr><td>+ ��. �������� ����� ����:</td><td><input type=text name="ms_fire" value="<?=$res['ms_fire'];?>" class=new size=30></td></tr>
		<tr><td>+ ��. �������� ����� ����:</td><td><input type=text name="ms_water" value="<?=$res['ms_water'];?>" class=new size=30></td></tr>
		<tr><td>+ ��. �������� ����� �������:</td><td><input type=text name="ms_air" value="<?=$res['ms_air'];?>" class=new size=30></td></tr>
		<tr><td>+ ��. �������� ����� �����:</td><td><input type=text name="ms_earth" value="<?=$res['ms_earth'];?>" class=new size=30></td></tr>
		<tr><td>+ ��. �������� ����� �����:</td><td><input type=text name="ms_svet" value="<?=$res['ms_svet'];?>" class=new size=30></td></tr>
		<tr><td>+ ��. �������� ����� ����:</td><td><input type=text name="ms_tma" value="<?=$res['ms_tma'];?>" class=new size=30></td></tr>
		<tr><td>+ ��. �������� ����� �����:</td><td><input type=text name="ms_gray" value="<?=$res['ms_gray'];?>" class=new size=30></td></tr>

		<tr><td colspan=2><br></td></tr>

		<tr><td>���. ������:</td><td><input type=text name="min_attack" value="<?=$res['min_attack'];?>" class=new size=30></td></tr>
		<tr><td>����. ������:</td><td><input type=text name="max_attack" value="<?=$res['max_attack'];?>" class=new size=30></td></tr>
		<tr><td>��. ������ �����:</td><td><input type=text name="proboy" value="<?=$res['proboy'];?>" class=new size=30></td></tr>

		<tr><td colspan=2><br></td></tr>

		<tr>
			<td>����������� ����:</td>
			<td>
				<select name="art" class=new>
					<option value='0'>NO
					<option value="1" <?echo ($res['art']==1?"selected":"")?>>YES
					<option value="2" <?echo ($res['art']==2?"selected":"")?>>ART 2
				</select>
			</td>
		</tr>

		<tr>	
			<td>���������:</td>
			<td>
				<select name=podzemka  class=new>
					<option value="0">NO
					<option value="1" <?echo ($res['podzemka']?"selected":"")?>>YES
				</select>
			</td>
		</tr>
			
		<tr>
			<td>�������:</td>
			<td>
				<select name=is_personal  class=new>
					<option value="0">NO
					<option value="1"<?echo ($res['is_personal']?"selected":"")?>>YES
				</select>
			</td>
		</tr>

		<tr><td>��������:</td><td><input type=text name=personal_owner value="<?=$res['personal_owner'];?>" class=new size=30></td></tr>

		<tr>
			<td>��� ��������:</td>
			<td>
				<select name="sex" class=new>
					<option value=''>-----
					<option value='male' <?echo ($res['sex']=="male"?"selected":"")?>>�������
					<option value='female' <?echo ($res['sex']=="female"?"selected":"")?>>�������
				</select>
			</td>
		</tr>
			
		<tr>
			<td>������ ��������:</td>
			<td>
				<select name="noremont" class=new>
					<option value='0' <?echo (!$res['noremont']?"selected":"")?>>�������������
					<option value='1' <?echo ($res['noremont']?"selected":"")?>>�� �������� �������
				</select>
			</td>
		</tr>

		<tr>
			<td>����������:</td>
			<td>
				<select name="need_orden" class=new>
					<option value=0 <?echo ($res['need_orden']==0?"selected":"")?>>���
					<option value=1 <?echo ($res['need_orden']==1?"selected":"")?>>�������� �������
					<option value=2 <?echo ($res['need_orden']==2?"selected":"")?>>�������
					<option value=3 <?echo ($res['need_orden']==3?"selected":"")?>>����� ����������
					<option value=4 <?echo ($res['need_orden']==4?"selected":"")?>>����� �����
					<option value=5 <?echo ($res['need_orden']==5?"selected":"")?>>�������� ����������
					<option value=6 <?echo ($res['need_orden']==6?"selected":"")?>>�������� ����
				</select>
			</td>
		</tr>
			
		<tr>
			<td>�������� ��������:</td>
			<td>
				<select name="edited" class=new>
					<option value='0' <?echo (!$res['edited']?"selected":"")?>>���
					<option value='1' <?echo ($res['edited']==1?"selected":"")?>>������ ����������
					<option value='2' <?echo ($res['edited']==2?"selected":"")?>>��� ����������
					<option value='3' <?echo ($res['edited']==3?"selected":"")?>>��� ������
					<option value='4' <?echo ($res['edited']==4?"selected":"")?>>��� �����
					<option value='5' <?echo ($res['edited']==5?"selected":"")?>>����� ����
					<option value='6' <?echo ($res['edited']==6?"selected":"")?>>������ ����������
					<option value='7' <?echo ($res['edited']==7?"selected":"")?>>������� ������ �����
					<option value='8' <?echo ($res['edited']==8?"selected":"")?>>������ ����������
					<option value='9' <?echo ($res['edited']==9?"selected":"")?>>������ ����������
					<option value='10' <?echo ($res['edited']==10?"selected":"")?>>������ ����������������
					<option value='11' <?echo ($res['edited']==11?"selected":"")?>>����� �����
					<option value='12' <?echo ($res['edited']==12?"selected":"")?>>����� ����
					<option value='13' <?echo ($res['edited']==13?"selected":"")?>>����� �����
					<option value='14' <?echo ($res['edited']==14?"selected":"")?>>������ �������
					<option value='15' <?echo ($res['edited']==15?"selected":"")?>>����� ���������
					<option value='16' <?echo ($res['edited']==16?"selected":"")?>>������� ������
					<option value='17' <?echo ($res['edited']==17?"selected":"")?>>����� �����
					<option value='18' <?echo ($res['edited']==18?"selected":"")?>>������ �����
					<option value='19' <?echo ($res['edited']==19?"selected":"")?>>������ �������
					<option value='20' <?echo ($res['edited']==20?"selected":"")?>>������ �����
					<option value='21' <?echo ($res['edited']==21?"selected":"")?>>������ �����
					<option value='22' <?echo ($res['edited']==22?"selected":"")?>>���� �����
					<option value='23' <?echo ($res['edited']==23?"selected":"")?>>��� ��������
					<option value='24' <?echo ($res['edited']==24?"selected":"")?>>��� �����������
					<option value='25' <?echo ($res['edited']==25?"selected":"")?>>������� ��������
					<option value='26' <?echo ($res['edited']==26?"selected":"")?>>������� �����
					<option value='27' <?echo ($res['edited']==27?"selected":"")?>>������� "������"
					<option value='28' <?echo ($res['edited']==28?"selected":"")?>>���� ���������
					<option value='29' <?echo ($res['edited']==29?"selected":"")?>>���� ����������� ���
					<option value='30' <?echo ($res['edited']==30?"selected":"")?>>����� �����
				</select>
			</td>
		</tr>

		<tr><td colspan=2 align=center><br><input type=submit name="edit" value="�������" class="newbut"></td></tr>
		</table>
		</form>
		<?
	}	
}	
//--------------------------------------------------------------------
echo $msg;
//--------------------------------------------------------------------

if ($_GET["type"]=="add")
{	
?>	
<form name="action" action="" method="POST" enctype="multipart/form-data">
<table border=0 width=600>
<tr><td><font color=RED><b>��������: </b></font></td><td><input type=text name="name" class=new size=30></td></tr>
<tr><td><font color=RED><b>���� � �������: </b></font></td><td><INPUT type="file" name="img" id="img" class="new"></td></tr>
<tr><td><font color=RED><b>�����:</b><font></td><td><input type=text name="mass" class=new size=30></td></tr>
<tr><td><font color=RED><b>����: </b></font></td><td><input type=text name="price" class=new size=30></td></tr>
<tr><td><font color=RED><b>�����: </b></font></td><td><input type=text name="iznos_max" class=new size=30></td></tr>
<tr><td><font color=RED><b>���-�� � ����:</b></font></td><td><input type=text name="count_mag" class=new size=30 value=10000></td></tr>
<tr>
	<td>����� ��������:</td>
	<td>
		<select name="object_type" class=new>
			<option value="pants" selected>������
			<option value="kostyl">��������
			<option value="amunition">�����������
			<option value="amulet">������
			<option value="naruchi">������
			<option value="sword">���
			<option value="axe">�����
			<option value="fail">�����/������
			<option value="knife">���/������
			<option value="spear">��������� ������
			<option value="staff">������
			<option value="armour">�����
			<option value="rubaxa">������
			<option value="plash">�����
			<option value="poyas">����
			<option value="helmet">����
			<option value="mask">�����
			<option value="masdrikon">����� � ����
			<option value="perchi">��������
			<option value="rukavic">��������
			<option value="shield">���
			<option value="boots">������
			<option value="ring">������
		</select>
	</td>
</tr>
<tr>
	<td>������ ������:</td>
	<td>
		<select name="second_hand" class=new>
			<option value='0'>NO
			<option value='1'>YES
		</select>
	</td>
</tr>
<tr>
	<td>��������� ������:</td>
	<td>
		<select name="two_hand" class=new>
			<option value='0'>No
			<option value='1'>YES
		</select>
	</td>
</tr>
	
<tr><td colspan=2><br><b>��������� �����������:</td></tr>

<tr><td>���. �������:</b></td><td><input type=text name="min_level" class=new size=30></td></tr>
<tr><td>���. ����:</td><td><input type=text name="min_sila" class=new size=30></td></tr>
<tr><td>���. ��������:</td><td><input type=text name="min_lovkost" class=new size=30></td></tr>
<tr><td>���. �����:</td><td><input type=text name="min_udacha" class=new size=30></td></tr>
<tr><td>���. ������������:</td><td><input type=text name="min_power" class=new size=30></td></tr>
<tr><td>���. ���������:</td><td><input type=text name="min_intellekt" class=new size=30></td></tr>
<tr><td>���. ����������:</td><td><input type=text name="min_vospriyatie" class=new size=30></td></tr>

<tr><td colspan=2><br></td></tr>

<tr><td>���. �������� ������:</td><td><input type=text name="min_sword_vl" class=new size=30></td></tr>
<tr><td>���. �������� ��������:</td><td><input type=text name="min_axe_vl" class=new size=30></td></tr>
<tr><td>���. �������� ��������:</td><td><input type=text name="min_fail_vl" class=new size=30></td></tr>
<tr><td>���. �������� ������:</td><td><input type=text name="min_knife_vl" class=new size=30></td></tr>
<tr><td>���. �������� �������:</td><td><input type=text name="min_spear_vl" class=new size=30></td></tr>
<tr><td>���. �������� ��������:</td><td><input type=text name="min_staff_vl" class=new size=30></td></tr>

<tr><td colspan=2><br></td></tr>

<tr><td>���. ������ ����:</td><td><input type=text name="min_fire" class=new size=30></td></tr>
<tr><td>���. ������ ����:</td><td><input type=text name="min_water" class=new size=30></td></tr>
<tr><td>���. ������ �������:</td><td><input type=text name="min_air" class=new size=30></td></tr>
<tr><td>���. ������ �����:</td><td><input type=text name="min_earth" class=new size=30></td></tr>
<tr><td>���. ������ �����:</td><td><input type=text name="min_svet" class=new size=30></td></tr>
<tr><td>���. ������ ����:</td><td><input type=text name="min_tma" class=new size=30></td></tr>
<tr><td>���. ����� ������:</td><td><input type=text name="min_gray" class=new size=30></td></tr>
	
<tr><td colspan=2><br><b>��������� ��</td></tr>

<tr><td>+ ����:</td><td><input type=text name="add_sila" class=new size=30></td></tr>
<tr><td>+ ��������:</td><td><input type=text name="add_lovkost" class=new size=30></td></tr>
<tr><td>+ �����:</td><td><input type=text name="add_udacha" class=new size=30></td></tr>
<tr><td>+ ���������:</td><td><input type=text name="add_intellekt" class=new size=30></td></tr>
<tr><td>+ ����������:</td><td><input type=text name="add_duxovnost" class=new size=30></td></tr>
<tr><td>+ HP:</td><td><input type=text name="add_hp" class=new size=30></td></tr>
<tr><td>+ MN:</td><td><input type=text name="add_mana" class=new size=30></td></tr>

<tr><td colspan=2><br><b>��������</td></tr>

<tr><td>+ �������� ������� :</td><td><input type=text name="add_oruj" class=new size=30></td></tr>
<tr><td>+ �������� ������:</td><td><input type=text name="add_sword_vl" class=new size=30></td></tr>
<tr><td>+ �������� ��������:</td><td><input type=text name="add_axe_vl" class=new size=30></td></tr>
<tr><td>+ �������� ��������:</td><td><input type=text name="add_fail_vl" class=new size=30></td></tr>
<tr><td>+ �������� ������:</td><td><input type=text name="add_knife_vl" class=new size=30></td></tr>
<tr><td>+ �������� �������:</td><td><input type=text name="add_spear_vl" class=new size=30></td></tr>
<tr><td>+ �������� ��������:</td><td><input type=text name="add_staff_vl" class=new size=30></td></tr>

<tr><td colspan=2><br></td></tr>

<tr><td>+ �������� ������ ����:</td><td><input type=text name="add_fire" class=new size=30></td></tr>
<tr><td>+ �������� ������ ����:</td><td><input type=text name="add_water" class=new size=30></td></tr>
<tr><td>+ �������� ������ �������:</td><td><input type=text name="add_air" class=new size=30></td></tr>
<tr><td>+ �������� ������ �����:</td><td><input type=text name="add_earth" class=new size=30></td></tr>
<tr><td>+ �������� ������ �����:</td><td><input type=text name="add_svet" class=new size=30></td></tr>
<tr><td>+ �������� ������ ����:</td><td><input type=text name="add_tma" class=new size=30></td></tr>	
<tr><td>+ �������� ����� ������:</td><td><input type=text name="add_gray" class=new size=30></td></tr>
	
<tr><td colspan=2><br><b>������</td></tr>

<tr><td>+ ����� ������:</td><td><input type=text name="protect_head" class=new size=30></td></tr>
<tr><td>+ ����� ���:</td><td><input type=text name="protect_arm" class=new size=30></td></tr>
<tr><td>+ ����� �������:</td><td><input type=text name="protect_corp" class=new size=30></td></tr>
<tr><td>+ ����� �����:</td><td><input type=text name="protect_poyas" class=new size=30></td></tr>
<tr><td>+ ����� ���:</td><td><input type=text name="protect_legs" class=new size=30></td></tr>

<tr><td colspan=2><br></td></tr>

<tr><td>+ ������ �� �����:</td><td><input type=text name="protect_mag" class=new size=30></td></tr>
<tr><td>+ ������ �� �����:</td><td><input type=text name="protect_udar" class=new size=30></td></tr>

<tr><td colspan=2><br></td></tr>

<tr><td>+ ������ �� �������� �����:</td><td><input type=text name="protect_rej" class=new size=30></td></tr>
<tr><td>+ ������ �� ��������� �����:</td><td><input type=text name="protect_drob" class=new size=30></td></tr>
<tr><td>+ ������ �� �������� �����:</td><td><input type=text name="protect_kol" class=new size=30></td></tr>
<tr><td>+ ������ �� �������� �����:</td><td><input type=text name="protect_rub" class=new size=30></td></tr>

<tr><td colspan=2><br></td></tr>

<tr><td>+ ������ �� ����� ����:</td><td><input type=text name="protect_fire" class=new size=30></td></tr>
<tr><td>+ ������ �� ����� ����:</td><td><input type=text name="protect_water" class=new size=30></td></tr>
<tr><td>+ ������ �� ����� �������:</td><td><input type=text name="protect_air" class=new size=30></td></tr>
<tr><td>+ ������ �� ����� �����:</td><td><input type=text name="protect_earth" class=new size=30></td></tr>
<tr><td>+ ������ �� ����� �����:</td><td><input type=text name="protect_svet" class=new size=30></td></tr>
<tr><td>+ ������ �� ����� ����:</td><td><input type=text name="protect_tma" class=new size=30></td></tr>
<tr><td>+ ������ �� ����� �����:</td><td><input type=text name="protect_gray" class=new size=30></td></tr>


<tr><td colspan=2><br><b>��.</td></tr>

<tr><td>+ ��. ����:</td><td><input type=text name="krit" class=new size=30></td></tr>
<tr><td>+ ��. ��������:</td><td><input type=text name="akrit" class=new size=30></td></tr>
<tr><td>+ ��. ������:</td><td><input type=text name="uvorot" class=new size=30></td></tr>
<tr><td>+ ��. ����������:</td><td><input type=text name="auvorot" class=new size=30></td></tr>
<tr><td>+ ��. �����������:</td><td><input type=text name="parry" class=new size=30></td></tr>
<tr><td>+ ��. ����������:</td><td><input type=text name="counter" class=new size=30></td></tr>

<tr><td colspan=2><br></td></tr>

<tr><td>+ ��. �������� �����:</td><td><input type=text name="add_rej" class=new size=30></td></tr>
<tr><td>+ ��. ��������� �����:</td><td><input type=text name="add_drob" class=new size=30></td></tr>
<tr><td>+ ��. �������� �����:</td><td><input type=text name="add_kol" class=new size=30></td></tr>
<tr><td>+ ��. �������� �����:</td><td><input type=text name="add_rub" class=new size=30></td></tr>

<tr><td>+ ��. �������� �����:</td><td><input type=text name="add_fire_att" class=new size=30></td></tr>
<tr><td>+ ��. ������������� �����:</td><td><input type=text name="add_air_att" class=new size=30></td></tr>
<tr><td>+ ��. ������� �����:</td><td><input type=text name="add_watet_att" class=new size=30></td></tr>
<tr><td>+ ��. �������� �����:</td><td><input type=text name="add_earth_att" class=new size=30></td></tr>	
<tr><td colspan=2><br></td></tr>	
	
<tr><td>+ ��.����� �����:</td><td><input type=text name="shieldblock" class=new size=30></td></tr>	

<tr><td colspan=2><br><b>��. ��������</td></tr>

<tr><td>+ ��. �������� �����:</td><td><input type=text name="ms_udar" class=new size=30></td></tr>
<tr><td>+ ��. �������� ������������ �����:</td><td><input type=text name="ms_krit" class=new size=30></td></tr>

<tr><td colspan=2><br></td></tr>

<tr><td>+ ��. �������� �������� �����:</td><td><input type=text name="ms_rej" class=new size=30></td></tr>
<tr><td>+ ��. �������� ��������� �����:</td><td><input type=text name="ms_drob" class=new size=30></td></tr>
<tr><td>+ ��. �������� �������� �����:</td><td><input type=text name="ms_kol" class=new size=30></td></tr>
<tr><td>+ ��. �������� �������� �����:</td><td><input type=text name="ms_rub" class=new size=30></td></tr>

<tr><td colspan=2><br></td></tr>

<tr><td>+ ��. �������� �����:</td><td><input type=text name="ms_mag" class=new size=30></td></tr>
<tr><td>+ ��. �������� ����� ����:</td><td><input type=text name="ms_fire" class=new size=30></td></tr>
<tr><td>+ ��. �������� ����� ����:</td><td><input type=text name="ms_water" class=new size=30></td></tr>
<tr><td>+ ��. �������� ����� �������:</td><td><input type=text name="ms_air" class=new size=30></td></tr>
<tr><td>+ ��. �������� ����� �����:</td><td><input type=text name="ms_earth" class=new size=30></td></tr>
<tr><td>+ ��. �������� ����� �����:</td><td><input type=text name="ms_svet" class=new size=30></td></tr>
<tr><td>+ ��. �������� ����� ����:</td><td><input type=text name="ms_tma" class=new size=30></td></tr>
<tr><td>+ ��. �������� ����� �����:</td><td><input type=text name="ms_gray" class=new size=30></td></tr>

<tr><td colspan=2><br></td></tr>

<tr><td>���. ������:</td><td><input type=text name="min_attack" class=new size=30></td></tr>
<tr><td>����. ������:</td><td><input type=text name="max_attack" class=new size=30></td></tr>
<tr><td>��. ������ �����:</td><td><input type=text name="proboy" class=new size=30></td></tr>

<tr><td colspan=2><br></td></tr>

<tr>
	<td>����������� ����:</td>
	<td>
		<select name="art" class=new>
			<option value='0' selected>NO
			<option value='1'>YES
			<option value='2'>ART 2
		</select>
	</td>
</tr>

<tr>	
	<td>���������:</td>
	<td>
		<select name=podzemka  class=new>
			<option value="0">NO
			<option value="1">YES
		</select>
	</td>
</tr>
	
<tr>
	<td>�������:</td>
	<td>
		<select name=is_personal  class=new>
			<option value="0">NO
			<option value="1">YES
		</select>
	</td>
</tr>

<tr><td>��������:</td><td><input type=text name=personal_owner class=new size=30></td></tr>

<tr>
	<td>��� ��������:</td>
	<td>
		<select name="sex" class=new>
			<option value='' selected>-----
			<option value='male'>male
			<option value='female'>female
		</select>
	</td>
</tr>
	
<tr>
	<td>������ ��������:</td>
	<td>
		<select name="noremont" class=new>
			<option value='0' selected>�������������
			<option value='1'>�� �������� �������
		</select>
	</td>
</tr>

<tr>
	<td>����������:</td>
	<td>
		<select name="need_orden" class=new>
			<option value=0>���
			<option value=1>�������� �������
			<option value=2>�������
			<option value=3>����� ����������
			<option value=4>����� �����
			<option value=5>�������� ����������
			<option value=6>�������� ����
		</select>
	</td>
</tr>
<tr>
	<td>�������� ��������:</td>
	<td>
		<select name="edited" class=new>
			<option value='0'>���
			<option value='1'>������ ����������
			<option value='2'>��� ����������
			<option value='3'>��� ������
			<option value='4'>��� �����
			<option value='5'>����� ����
			<option value='6'>������ ����������
			<option value='7'>������� ������ �����
			<option value='8'>������ ����������
			<option value='9'>������ ����������
			<option value='10'>������ ����������������
			<option value='11'>����� �����
			<option value='12'>����� ����
			<option value='13'>����� �����
			<option value='14'>������ �������
			<option value='15'>����� ���������
			<option value='16'>������� ������
			<option value='17'>����� �����
			<option value='18'>������ �����
			<option value='19'>������ �������
			<option value='20'>������ �����
			<option value='21'>������ �����
			<option value='22'>���� �����
			<option value='23'>��� ��������
			<option value='24'>��� �����������
			<option value='25'>������� ��������
			<option value='26'>������� �����
			<option value='27'>������� "������"
			<option value='28'>���� ���������
			<option value='29'>���� ����������� ���
			<option value='30'>����� �����
		</select>
	</td>
</tr>
	
<tr><td colspan=2 align=center><br><input type=submit name="create" value="�������" class="newbut"></td></tr>
</table>
</form>
<?
}
?>