<?
	function calc_mag($pers,$magic_type)
	{
		effects($pers["id"],$effect);
		$pers["intellekt"]=$pers["intellekt"]+$effect["add_intellekt"];
		//----------------------ZVER BONUS------------------------------------------------
		if ($pers["zver_on"]==1 && $pers["zver_type"]=="snake")
		{
			if ($pers["zver_level"]<6)$add_ms_mag=$pers["zver_level"];
			else if ($pers["zver_level"]==6)$add_ms_mag=7;
			else if ($pers["zver_level"]==7)$add_ms_mag=9;
			else if ($pers["zver_level"]==8)$add_ms_mag=11;
			else if ($pers["zver_level"]==9)$add_ms_mag=13;
			else if ($pers["zver_level"]==10)$add_ms_mag=15;
			else if ($pers["zver_level"]==11)$add_ms_mag=17;
		}
		//--------------------------------------------------------------------------------
	
		$sql=mysql_query("SELECT is_modified, art, add_fire_att, add_air_att, add_watet_att, add_earth_att FROM `inv` WHERE id=".$pers["hand_r"]);
		$modif=mysql_fetch_array($sql);
		$is_modified=$modif['is_modified'];
		$is_art=$modif['art'];

		//----------------------PRIYOM ON------------------------------------------------
		$a_pr=mysql_query("SELECT pr_name FROM person_on WHERE id_person=".$pers["id"]." and battle_id=".$pers["battle"]." and pr_active=2 and pr_cur_uses>0");
		while($attack_priem=mysql_fetch_array($a_pr))
		{
			$at_priem[]=$attack_priem["pr_name"];
		}	
		$attack_priem_count=array_count_values($at_priem);

		//--------------------------------------------------------------------------------
		switch ($magic_type)
		{
			case "water_magic":$add_magic=(int)$effect["add_water_magic"];	$hit_type=$modif['add_watet_att']; 	$ms_mag_hit=$pers["ms_water"]; break;
			case "earth_magic":$add_magic=(int)$effect["add_earth_magic"];	$hit_type=$modif['add_earth_att'];	$ms_mag_hit=$pers["ms_earth"]; break;
			case "fire_magic": $add_magic=(int)$effect["add_fire_magic"];	$hit_type=$modif['add_fire_att'];	$ms_mag_hit=$pers["ms_fire"]; break;
			case "air_magic":  $add_magic=(int)$effect["add_air_magic"];	$hit_type=$modif['add_air_att'];	$ms_mag_hit=$pers["ms_air"]; break;
			case "tma_magic":  $add_magic=(int)$effect["add_tma_magic"];	$hit_type=$modif['add_tma_att'];	$ms_mag_hit=$pers["ms_tma"]; break;
		}
		if ($pers["hand_r_type"]=="staff" || $pers["hand_r_type"]=="spear")$k=rand($pers["hand_r_hitmin"]+$is_modified+$effect["min_udar"], $pers["hand_r_hitmax"]+$is_modified+$effect["max_udar"])*(1+0.07*($pers["staff_vl"]+$add_magic));

		//----------------------BONUS------------------------------------------------
		if ($pers["intellekt"]>=125) 	    $ms_mag_hit=$ms_mag_hit+25;
		else if ($pers["intellekt"]>=100) 	$ms_mag_hit=$ms_mag_hit+20;
		else if ($pers["intellekt"]>=75) 	$ms_mag_hit=$ms_mag_hit+15;
		else if ($pers["intellekt"]>=50) 	$ms_mag_hit=$ms_mag_hit+10;
		else if ($pers["intellekt"]>=25)	$ms_mag_hit=$ms_mag_hit+5;

		$ms_mag_hit=$ms_mag_hit+$add_ms_mag+$pers["intellekt"]/2+(int)$effect["add_ms_mag"];
		
		if ($attack_priem_count["yarost"]==1)$ms_mag_hit=$ms_mag_hit*1.05;
	    else if ($attack_priem_count["yarost"]==2)$ms_mag_hit=$ms_mag_hit*1.10;
	    else if ($attack_priem_count["yarost"]>=3)$ms_mag_hit=$ms_mag_hit*1.15;
	    
		$uron=$pers[$magic_type]+ $k;
		if($hit_type>0)
		{
			$ggg = rand(1,120);
			if($ggg<=$hit_type)
			{
				$uron = $uron+$uron*$hit_type/100;
			}
		}
		$uron=$uron+$uron*$ms_mag_hit/100;

		if($is_art==1)$uron=$uron*1.3;
		if($is_art==2)$uron=($uron+$pers["intellekt"])*1.2;
		//----------------------END URON------------------------------------------------
		return ceil($uron);
	}
?>