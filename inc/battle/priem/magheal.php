<?
$login=$_SESSION["login"];
if($db["battle"] && $db["hp"] && $db["battle_opponent"]!="")
{
	switch ($is_pr["type"]) 
	{
		case "magheal7": $hp_min=180;$hp_max=183;break;
		case "magheal8": $hp_min=207;$hp_max=210;break;
		case "magheal9": $hp_min=235;$hp_max=250;break;
		case "magheal10": $hp_min=260;$hp_max=280;break;
	}


	$date = date("H:i");
	$hp_add = rand($hp_min,$hp_max);
	
	$hp_now = $db["hp"];
	$hp_all = $db["hp_all"];

	if($hp_now<$hp_all)
	{
		if($hp_all - $hp_now<$hp_add)
		{
			$hp_add = $hp_all - $hp_now;
		}
		$hp_new = $hp_now + $hp_add;
		setHP($login,$hp_new,$hp_all);
		
		if($db["battle_team"]==1){$span = "p1";$span2 = "p2";}else{$span = "p2";$span2 = "p1";}
		$phrase="<span class=date>$date</span> <span class=$span>".$login."</span> понима€, что ситуаци€ становитс€ критической, применил прием <b>Ћечение</b> и восстановил свое здоровье <span class=hitted>+$hp_add</span> [$hp_new/$hp_all]<BR>";
		$bid=$db["battle"];
		battle_log($bid, $phrase);
		mysql_query("UPDATE person_on SET pr_active=1,pr_wait_for=".$is_pr["wait"]." WHERE id_person='".$db["id"]."' and pr_name='".$is_pr["type"]."' and battle_id='".$bid."'");
		mysql_query("UPDATE battle_units SET hit=hit-".(int)$is_pr["hit"].",krit=krit-".(int)$is_pr["krit"].",uvarot=uvarot-".(int)$is_pr["uvarot"].",block=block-".(int)$is_pr["block"].",hp=hp-".(int)$is_pr["hp"].",counter=counter-".(int)$is_pr["all_hit"]." WHERE player='".$login."' and battle_id='".$bid."'");
		hit($login,$db["battle_opponent"],0,0,0,0,$b_id,0);
	}
}
?>