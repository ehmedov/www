<?
	include "conf.php";
	include "functions.php";
	$data   = mysql_connect($base_name, $base_user, $base_pass)or 
	die ('Технический перерыв  . Приносим свои извинения. Администрация.');
	mysql_select_db($db_name,$data);

	function unpaltar($who,$itm)
	{
		$sql_user=mysql_query("SELECT * FROM `users` WHERE login='".$who."'");
		$sql_print=mysql_query("SELECT paltar.*,inv.id as id_inv FROM inv LEFT JOIN paltar on inv.object_id=paltar.id WHERE inv.owner='".$who."' and inv.id='".$itm."' and inv.wear=1");
		$db=mysql_fetch_array($sql_user);	
		$item_data=mysql_fetch_array($sql_print);
		if ($item_data)
		{
			$i_type=$item_data["object"];
			$id_inv=$item_data["id_inv"];
			if($i_type=="sword" || $i_type=="axe" || $i_type=="fail" || $i_type=="knife" || $i_type=="spear" || $i_type=="shield" || $i_type=="amunition" || $i_type=="staff" || $i_type=="kostyl")
			{
				if($db["hand_r"] == $itm){$slot = "hand_r";}
		        if($db["hand_l"] == $itm){$slot = "hand_l";}
		    }
			else if($i_type=="ring")
			{
				if($db["ring1"]==$itm)
				{
					$slot="ring1";
				}
				else if($db["ring2"]==$itm)
				{
					$slot="ring2";
				}
				else if($db["ring3"]==$itm)
				{
					$slot="ring3";
				}
			}
			else
			{
		        $slot=$i_type;
			}	
			$slot_v=$db[$slot];	

			$new_sila=$db["sila"]-$item_data["add_sila"];
			$new_lovkost=$db["lovkost"]-$item_data["add_lovkost"];
			$new_udacha=$db["udacha"]-$item_data["add_udacha"];
			$new_intellekt=$db["intellekt"]-$item_data["add_intellekt"];
			
			$new_phead=$db["bron_head"]-$item_data["protect_head"];
			$new_parm=$db["bron_arm"]-$item_data["protect_arm"];
			$new_pcorp=$db["bron_corp"]-$item_data["protect_corp"];
			$new_ppoyas=$db["bron_poyas"]-$item_data["protect_poyas"];
			$new_plegs=$db["bron_legs"]-$item_data["protect_legs"];
			
			$new_mfkrit=$db["krit"]-$item_data["krit"];
			$new_mfantikrit=$db["akrit"]-$item_data["akrit"];
			$new_mfuvorot=$db["uvorot"]-$item_data["uvorot"];
			$new_mfantiuvorot=$db["auvorot"]-$item_data["auvorot"];

			$new_wpmin_h=$item_data["min_attack"];
			$new_wpmax_h=$item_data["max_attack"];
			
			if($slot=="hand_l")
			{
				$new_wpmin=$db["hand_l_hitmin"]-$item_data["min_attack"];
				$new_wpmax=$db["hand_l_hitmax"]-$item_data["max_attack"];
			}
			else if($slot=="hand_r")
			{
				$new_wpmin=$db["hand_r_hitmin"]-$item_data["min_attack"];
				$new_wpmax=$db["hand_r_hitmax"]-$item_data["max_attack"];
			}
			
			$new_swordvl=$db["sword_vl"]-$item_data["sword_vl"];
			$new_axevl=$db["axe_vl"]-$item_data["axe_vl"];
			$new_failvl=$db["hummer_vl"]-$item_data["fail_vl"];
			$new_knifevl=$db["castet_vl"]-$item_data["knife_vl"];
			$new_spearvl=$db["copie_vl"]-$item_data["spear_vl"];
			$new_staffvl=$db["staff_vl"]-$item_data["staff_vl"];
			
			$new_mass=$db["mass"]-$item_data["mass"];
			
			$new_fire=$db["fire_magic"]-$item_data["add_fire"];
			$new_water=$db["water_magic"]-$item_data["add_water"];
			$new_air=$db["air_magic"]-$item_data["add_air"];
			$new_earth=$db["earth_magic"]-$item_data["add_earth"];
			
			$new_cast=$db["cast"]-$item_data["add_cast"];
			$new_trade=$db["trade"]-$item_data["add_trade"];
			$new_cure=$db["cure"]-$item_data["add_cure"];
			
			$new_hp=$db["hp_all"]-$item_data["add_hp"];
			$new_mana=$db["mana_all"]-$item_data["add_mana"];
			
			$hp=$db["hp"];
			$mn=$db["mana"];
			if($new_hp>$hp){$hp2=$hp;}else{$r=$hp-$new_hp; $hp2=$hp-$r;}
			if($new_mana>$mn){$mn2=$mn;}else{$k=$mn-$new_mana; $mn2=$mn-$k;}
			setHP($who,$hp2,$new_hp);
			setMN($who,$mn2,$new_mana);
			
			$new_sql ="UPDATE `users` SET sila='".$new_sila."',lovkost='".$new_lovkost."',udacha='".$new_udacha."',hp_all='".$new_hp."',";
			$new_sql.="intellekt='".$new_intellekt."', mana_all='".$new_mana."',bron_head='".$new_phead."',bron_corp='".$new_pcorp."',";
			$new_sql.="bron_legs='".$new_plegs."', bron_arm='".$new_parm."',bron_poyas='".$new_ppoyas."',";
			$new_sql.="$slot='0',sword_vl='".$new_swordvl."',axe_vl='".$new_axevl."',hummer_vl='".$new_failvl."',";
			$new_sql.="castet_vl='".$new_knifevl."',copie_vl='".$new_spearvl."',staff_vl='".$new_staffvl."',mass='".$new_mass."',";

			if($slot == "hand_r")
			{
				$new_sql.="hand_r_type='phisic',hand_r_free='1',hand_r_hitmin='0',hand_r_hitmax='0',";
			}
			else if($slot == "hand_l")
			{
				$new_sql.="hand_l_type='phisic',hand_l_free='1',hand_l_hitmin='0',hand_l_hitmax='0',";
			}
			$new_sql.="krit='$new_mfkrit',akrit='$new_mfantikrit',uvorot='$new_mfuvorot',auvorot='$new_mfantiuvorot',";
			$new_sql.="fire_magic='$new_fire',water_magic='$new_water',";
			$new_sql.="air_magic='$new_air',earth_magic='$new_earth',cast='$new_cast',trade='$new_trade',cure='$new_cure'";
			$new_sql.=" WHERE login='".$who."'";
			mysql_query($new_sql);	
			mysql_query("UPDATE inv SET wear='0',slot='' WHERE id='".$id_inv."'");
		}
	}
	//unpaltar("MUXAX","4674241");

$t = microtime(true);

$f1 = 200;
$f2 = 200;
$f3 = 200;
$s = 0;

for ( $z=0; $z<=$f1; $z++ )
{
    $s++;
    for ( $x=0; $x<=$f2; $x++ )
    {
        $s++;
        for ( $c=0; $c<=$f3; $c++ )
        {
            $s++;
            echo $s;
        }
    }
}
echo '<br /><br /><br />';
printf('Время выполнения %f сек.', microtime(true)-$t);

?>