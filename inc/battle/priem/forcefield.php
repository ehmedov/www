<?
$login=$_SESSION["login"];
if($db["battle"] && $db["hp"] && $db["battle_opponent"]!="")
{
	switch ($is_pr["type"]) 
	{
		case "forcefield7": $hited=100;break;
		case "forcefield8": $hited=120;break;
		case "forcefield9": $hited=144;break;
	}

	$date = date("H:i");
	if($db["battle_team"]==1){$span = "p1";$span2 = "p2";}else{$span = "p2";$span2 = "p1";}
	$phrase="<span class=date>$date</span> <span class=$span>".$login."</span> понимая, что ситуация становится критической, применил прием <b>Силовое Поле</b><BR>";
	$bid=$db["battle"];
	battle_log($bid, $phrase);
	mysql_query("UPDATE person_on SET pr_active=2,pr_wait_for=".$is_pr["wait"].",hited=".$hited." WHERE id_person='".$db["id"]."' and pr_name='".$is_pr["type"]."' and battle_id='".$bid."'");
	mysql_query("UPDATE  battle_units SET hit=hit-".(int)$is_pr["hit"].",krit=krit-".(int)$is_pr["krit"].",uvarot=uvarot-".(int)$is_pr["uvarot"].",block=block-".(int)$is_pr["block"].",hp=hp-".(int)$is_pr["hp"].",counter=counter-".(int)$is_pr["all_hit"]." WHERE player='".$login."' and battle_id='".$bid."'");
}
?>