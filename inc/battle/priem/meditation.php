<?
$login=$_SESSION["login"];
if($db["battle"] && $db["hp"] && $db["battle_opponent"]!="")
{
	switch ($is_pr["type"]) 
	{
		case "meditation7": $mana_add=10;break;
	}


	$date = date("H:i");
	$mana = $db["mana"];
	$mana_all = $db["mana_all"];
	$mana_add=ceil($mana_all*$mana_add/100);
	if($mana<$mana_all)
	{
		if($mana_all - $mana<$mana_add)
		{
			$mana_add = $mana_all - $mana;
		}
		$mana_new = $mana + $mana_add;
		setMN($login,$mana_new,$mana_all);
		
		if($db["battle_team"]==1){$span = "p1";$span2 = "p2";}else{$span = "p2";$span2 = "p1";}
		$phrase="<span class=date>$date</span> <span class=$span>".$login."</span> понимая, что ситуация становится критической, применил прием <b style='color:#A00000'>".$is_pr["name"]."</b> <b style='color:#006699'>+".$mana_add."</b> [$mana_new/$mana_all]<BR>";
		$bid=$db["battle"];
		battle_log($bid, $phrase);
		mysql_query("UPDATE person_on SET pr_active=1,pr_wait_for=".$is_pr["wait"]." WHERE id_person='".$db["id"]."' and pr_name='".$is_pr["type"]."' and battle_id='".$bid."'");
		mysql_query("UPDATE battle_units SET hit=hit-".(int)$is_pr["hit"].",krit=krit-".(int)$is_pr["krit"].",uvarot=uvarot-".(int)$is_pr["uvarot"].",block=block-".(int)$is_pr["block"].",hp=hp-".(int)$is_pr["hp"].",counter=counter-".(int)$is_pr["all_hit"]." WHERE player='".$login."' and battle_id='".$bid."'");
		hit($login,$db["battle_opponent"],0,0,0,0,$b_id,0);
	}
}
?>