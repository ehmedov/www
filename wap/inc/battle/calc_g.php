<?
effects($ATTACK_DATA["id"],$effect_attack);
effects($DEFEND_DATA["id"],$effect_defend);
/*===================определение характеристик атакующего===============*/
$attack_sila       	= $ATTACK_DATA["sila"]+$effect_attack["add_sila"];
$attack_lovkost    	= $ATTACK_DATA["lovkost"]+$effect_attack["add_lovkost"];
$attack_udacha     	= $ATTACK_DATA["udacha"]+$effect_attack["add_udacha"];

$parry=$ATTACK_DATA["parry"]+5;
$ms_uron=$ATTACK_DATA["ms_udar"]+$effect_attack["add_ms_boyech"];
$ms_krit=$ATTACK_DATA["ms_krit"];
$attack_counter=$ATTACK_DATA["counter"]+10;
############################################################
if ($ATTACK_DATA["zver_on"]==1)
{
	switch ($ATTACK_DATA["zver_type"])
	{
		 case "wolf":$attack_udacha=$attack_udacha+$ATTACK_DATA["zver_level"];break;
		 case "bear":$attack_sila=$attack_sila+$ATTACK_DATA["zver_level"];break;
	 	 case "cheetah":$attack_lovkost=$attack_lovkost+$ATTACK_DATA["zver_level"];break;
	}
}

$attack_krit       = $ATTACK_DATA["krit"]+5*$attack_udacha+$effect_attack["add_krit"];
$attack_antikrit   = $ATTACK_DATA["akrit"]+5*$attack_udacha+$effect_attack["add_akrit"];
$attack_uvorot     = $ATTACK_DATA["uvorot"]+5*$attack_lovkost+$effect_attack["add_uvorot"];
$attack_antiuvorot = $ATTACK_DATA["auvorot"]+5*$attack_lovkost+$effect_attack["add_auvorot"];


if($hand == 0)
{
	$attack_weapon = $ATTACK_DATA["hand_r"];
	$attack_weapon_type = $ATTACK_DATA["hand_r_type"];
	$attack_wp_min = $ATTACK_DATA["hand_r_hitmin"];
	$attack_wp_max = $ATTACK_DATA["hand_r_hitmax"];
}
else if($hand == 1)
{
	$attack_weapon = $ATTACK_DATA["hand_l"];
	$attack_weapon_type = $ATTACK_DATA["hand_l_type"];
	$attack_wp_min = $ATTACK_DATA["hand_l_hitmin"];
	$attack_wp_max = $ATTACK_DATA["hand_l_hitmax"];
}
##########################BONUS#############################
if ($attack_sila>=125) 		{$ms_uron=$ms_uron+25;$attack_wp_min=$attack_wp_min+10;$attack_wp_max=$attack_wp_max+10;}
else if ($attack_sila>=100)	{$ms_uron=$ms_uron+25;}
else if ($attack_sila>=75) 	{$ms_uron=$ms_uron+17;}
else if ($attack_sila>=50) 	{$ms_uron=$ms_uron+10;}
else if ($attack_sila>=25)	{$ms_uron=$ms_uron+5; }

if ($attack_lovkost>=125) 		{$attack_antikrit=$attack_antikrit+40;$parry=$parry+15;$attack_uvorot=$attack_uvorot+120;}
else if ($attack_lovkost>=100) 	{$attack_antikrit=$attack_antikrit+40;$parry=$parry+15;$attack_uvorot=$attack_uvorot+105;}
else if ($attack_lovkost>=75) 	{$attack_antikrit=$attack_antikrit+15;$parry=$parry+15;$attack_uvorot=$attack_uvorot+35;}
else if ($attack_lovkost>=50) 	{$attack_antikrit=$attack_antikrit+15;$parry=$parry+5;$attack_uvorot=$attack_uvorot+35;}
else if ($attack_lovkost>=25) 	{$parry=$parry+5;}

if ($attack_udacha>=125) 	    {$attack_krit=$attack_krit+120;$ms_krit=$ms_krit+25;$attack_antiuvorot=$attack_antiuvorot+45;}
else if ($attack_udacha>=100) 	{$attack_krit=$attack_krit+105;$ms_krit=$ms_krit+25;$attack_antiuvorot=$attack_antiuvorot+45;}
else if ($attack_udacha>=75) 	{$attack_krit=$attack_krit+35;$ms_krit=$ms_krit+25;$attack_antiuvorot=$attack_antiuvorot+15;}
else if ($attack_udacha>=50) 	{$attack_krit=$attack_krit+35;$ms_krit=$ms_krit+10;$attack_antiuvorot=$attack_antiuvorot+15;}
else if ($attack_udacha>=25) 	{$ms_krit=$ms_krit+10;}
############################################################
switch ($attack_weapon_type)
{
	case "sword":$attack_vlad="sword_vl";	$add_vladeniya=(int)$effect_attack["add_sword_vl"]; 	break;
	case "axe":$attack_vlad="axe_vl";		$add_vladeniya=(int)$effect_attack["add_axe_vl"]; 	break;
	case "fail":$attack_vlad="hummer_vl";	$add_vladeniya=(int)$effect_attack["add_hummer_vl"]; break;
	case "knife":$attack_vlad="castet_vl";	$add_vladeniya=(int)$effect_attack["add_castet_vl"];	break;
	case "spear":$attack_vlad="copie_vl";	$add_vladeniya=(int)$effect_attack["add_copie_vl"]; 	break;
	case "staff":$attack_vlad="staff_vl";	$add_vladeniya=(int)$effect_attack["add_staff_vl"]; 	break;
}	

$attack_vladenie=$ATTACK_DATA[$attack_vlad]+$ATTACK_DATA["add_oruj"];
############################################################
if ($attack_weapon)$k=mysql_fetch_array(mysql_query("SELECT is_modified, add_rej, add_drob, add_kol, add_rub, art, proboy, two_hand FROM `inv` WHERE id=$attack_weapon"));
$is_modified=$k['is_modified'];
$is_art=$k['art'];
$proboy = $k["proboy"]+5;
$two_hand=$k['two_hand'];
############################################################
$kal=$k['add_kol']-($DEFEND_DATA["protect_kol"]+$effect_defend["p_kol"])*0-$effect_defend["p_kol"];
$rub=$k['add_rub']-($DEFEND_DATA["protect_rub"]+$effect_defend["p_rub"])*0-$effect_defend["p_rub"];
$drob=$k['add_drob']-($DEFEND_DATA["protect_drob"]+$effect_defend["p_drob"])*0-$effect_defend["p_drob"];
$rej=$k['add_rej']-($DEFEND_DATA["protect_rej"]+$effect_defend["p_rej"])*0-$effect_defend["p_rej"];
############################################################
if ($defent_priem_count["protkol"])$kal=$kal/2;
if ($defent_priem_count["protrub"])$rub=$rub/2;
if ($defent_priem_count["protdrob"])$drob=$drob/2;
if ($defent_priem_count["protrej"])$rej=$rej/2;
############################################################
$attack_minhit=($attack_wp_min+$is_modified+$effect_attack["min_udar"])*(1+0.07*$attack_vladenie);
$attack_maxhit=($attack_wp_max+$is_modified+$effect_attack["max_udar"])*(1+0.07*$attack_vladenie);

$hit_k=rand($attack_minhit,$attack_maxhit)+$ATTACK_DATA["level"]+$attack_sila;
if ($two_hand==1)$hit_k=$hit_k*1.1;
//-----------------------------------------------------------------------
if($kal>0 && !$have_hit_type)
{
	$ggg = rand(1,120);
	if($ggg<$kal)
	{
		$udar_kal=($attack_sila*0.2+$attack_lovkost*0.4)*(1+$ATTACK_DATA["ms_kol"]/100);
		$txt_hit_type.="[Колющий урон]";
		$have_hit_type=1;
	}
}
if($rub>0 && !$have_hit_type)
{
	$gggr = rand(1,100);
	if($gggr<$rub)
	{
		$udar_rub=($attack_sila*0.2+$attack_lovkost*0.2+$attack_udacha*0.3)*(1+$ATTACK_DATA["ms_rub"]/100);
		$txt_hit_type.="[Рубящий урон]";
		$have_hit_type=1;
	}
}
if($drob>0 && !$have_hit_type)
{
	$gggd = rand(1,100);
	if($gggd<$drob)
	{
		$udar_drob=($attack_sila*0.8)*(1+$ATTACK_DATA["ms_drob"]/100);
		$txt_hit_type.="[Дробящий урон]";
		$have_hit_type=1;
	}
}
if($rej>0 && !$have_hit_type)
{
	$gggj = rand(1,100);
	if($gggj<$rej)
	{
		$udar_rej=($attack_sila*0.2+$attack_udacha*0.4)*(1+$ATTACK_DATA["ms_rej"]/100);
		$txt_hit_type.="[Режущий урон]";
		$have_hit_type=1;
	}
}
$hit_k=$hit_k+$udar_kal+$udar_rub+$udar_drob+$udar_rej;
$hit_k=$hit_k*(1+$ms_uron/100);
if($is_art==1)$hit_k=$hit_k*1.2;

############################################################
$attack_krit=$attack_krit+(in_Array("jajda",$at_priem)?50:0);

if ($attack_priem_count["supreme"]==1){$attack_antikrit=$attack_antikrit+$attack_antikrit*0.05;$attack_antiuvorot=$attack_antiuvorot+$attack_antiuvorot*0.05;}
else if ($attack_priem_count["supreme"]==2){$attack_antikrit=$attack_antikrit+$attack_antikrit*0.10;$attack_antiuvorot=$attack_antiuvorot+$attack_antiuvorot*0.10;}
else if ($attack_priem_count["supreme"]>=3){$attack_antikrit=$attack_antikrit+$attack_antikrit*0.15;$attack_antiuvorot=$attack_antiuvorot+$attack_antiuvorot*0.15;}

/*===================определение характеристик защишаюшегося===============*/
$defend_sila       	= $DEFEND_DATA["sila"]+$effect_defend["add_sila"];
$defend_lovkost    	= $DEFEND_DATA["lovkost"]+$effect_defend["add_lovkost"];
$defend_udacha		= $DEFEND_DATA["udacha"]+$effect_defend["add_udacha"];

if ($DEFEND_DATA["zver_on"]==1)
{
	switch ($DEFEND_DATA["zver_type"]) 
	{
		 case "wolf":	$defend_udacha=$defend_udacha+$DEFEND_DATA["zver_level"];break;
		 case "bear":	$defend_sila=$defend_sila+$DEFEND_DATA["zver_level"];break;
	 	 case "cheetah":$defend_lovkost=$defend_lovkost+$DEFEND_DATA["zver_level"];break;
	}
}
$defend_krit       = $DEFEND_DATA["krit"]+5*$defend_udacha+$effect_defend["add_krit"];
$defend_antikrit   = $DEFEND_DATA["akrit"]+5*$defend_udacha+$effect_defend["add_akrit"];
$defend_uvorot     = $DEFEND_DATA["uvorot"]+5*$defend_lovkost+$effect_defend["add_uvorot"];
$defend_antiuvorot = $DEFEND_DATA["auvorot"]+5*$defend_lovkost+$effect_defend["add_auvorot"];
$def_parry         = $DEFEND_DATA["parry"]+5;
$def_counter	   = $DEFEND_DATA["counter"]+10;
$ms_def_krit       = $DEFEND_DATA["power"]*0.5;
$def_protect_udar  = $DEFEND_DATA["protect_udar"];

$defend_bron_h    = $DEFEND_DATA["bron_head"];
$defend_bron_c    = $DEFEND_DATA["bron_corp"];
$defend_bron_a    = ($DEFEND_DATA["bron_head"]+$DEFEND_DATA["bron_corp"])/2;
$defend_bron_p    = $DEFEND_DATA["bron_poyas"];
$defend_bron_l    = $DEFEND_DATA["bron_legs"];

//------Bonus-----------------------
if ($defend_lovkost>=125) 		{$defend_antikrit=$defend_antikrit+40;$def_parry=$def_parry+15;$defend_uvorot=$defend_uvorot+120;}
else if ($defend_lovkost>=100) 	{$defend_antikrit=$defend_antikrit+40;$def_parry=$def_parry+15;$defend_uvorot=$defend_uvorot+105;}
else if ($defend_lovkost>=75) 	{$defend_antikrit=$defend_antikrit+15;$def_parry=$def_parry+15;$defend_uvorot=$defend_uvorot+35;}
else if ($defend_lovkost>=50) 	{$defend_antikrit=$defend_antikrit+15;$def_parry=$def_parry+5; $defend_uvorot=$defend_uvorot+35;}
else if ($defend_lovkost>=25) 	{$def_parry=$def_parry+5;}

if ($defend_udacha>=125) 	    {$defend_krit=$defend_krit+120;$defend_antiuvorot=$defend_antiuvorot+45;}
else if ($defend_udacha>=100) 	{$defend_krit=$defend_krit+105;$defend_antiuvorot=$defend_antiuvorot+45;}
else if ($defend_udacha>=75) 	{$defend_krit=$defend_krit+35; $defend_antiuvorot=$defend_antiuvorot+15;}
else if ($defend_udacha>=50) 	{$defend_krit=$defend_krit+35; $defend_antiuvorot=$defend_antiuvorot+15;}

$def_protect_udar=$def_protect_udar+$DEFEND_DATA["power"]*1.5+$effect_defend["add_bron"];

if ($DEFEND_DATA["power"]>=125) {$def_protect_udar=$def_protect_udar+25;}
else if ($DEFEND_DATA["power"]>=100) {$def_protect_udar=$def_protect_udar+20;}
else if ($DEFEND_DATA["power"]>=75)  {$def_protect_udar=$def_protect_udar+15;}
else if ($DEFEND_DATA["power"]>=50)  {$def_protect_udar=$def_protect_udar+10;}
else if ($DEFEND_DATA["power"]>=25)  {$def_protect_udar=$def_protect_udar+5;}
############################################################
if ($attack_krit<1)$attack_krit=1;
if ($attack_antiuvorot<1)$attack_antiuvorot=1;
if ($defend_uvorot<1)$defend_uvorot=1;
if ($defend_antikrit<1)$defend_antikrit=1;
$def_counter=$def_counter-$attack_counter;
if ($def_counter<1)$def_counter=1;
if ($def_counter>80)$def_counter=80;
if ($ms_krit>160)$ms_krit=160;
$ms_krit=$ms_krit-$ms_krit*$ms_def_krit/100;
if ($ms_krit<1)$ms_krit=0;
$ver_ms_krit=$ms_krit/2;
####################расчет##################################
$uvarot_ferq=$defend_uvorot/$attack_antiuvorot;
$pruv2x=100/$uvarot_ferq; 
$veruv2=100-$pruv2x;  
if ($veruv2<=0)$veruv2=0;

$krit_ferq=$attack_krit/$defend_antikrit;
$prkr2x=100/$krit_ferq; 
$verkr2=100-$prkr2x;
if ($verkr2<=0)$verkr2=0;

$ver_parry=100-100/($def_parry/$parry); 
if ($ver_parry<=0)$ver_parry=0;
if ($ver_parry>50)$ver_parry=50;
//-----------------расчет уворота--------------------------
$uv=rand(1,90);
$is_uvorot=($uv<$veruv2?true:false);
//---------расчет критического удара-----------------------
$crit=rand(1,80);
$is_krit=($crit<$verkr2?true:false);
//---------расчет парирования------------------------------
$parry_rand=rand(1,200);
$is_parry=($parry_rand<$ver_parry?true:false);
//---------расчет пробоя ----------------------------------
$proboy_rand=rand(1,125);
$is_proboy=($proboy_rand<$proboy?true:false);
//---------расчет контрудара ----------------------------------
$counter_rand=rand(9,200);
$is_counter=($counter_rand<$def_counter?true:false);
//---------расчет пробить блок ----------------------------------
$krit_rand=rand(1,100);
$is_probit_blok=($krit_rand<$ver_ms_krit?true:false);
############################################################
$result_k=1;
$Subj_k=$attack_krit;
$Obj_k=$defend_antikrit;
if ($Subj_k>$Obj_k)
{
	$result_k=ceil($Subj_k-$Obj_k);
} 
if($result_k>100){$result_k=50;}
$is_travm="0";
$calc_travm=rand(1,300);
if($calc_travm<=$result_k){$is_travm="1";}
############################################################
?>