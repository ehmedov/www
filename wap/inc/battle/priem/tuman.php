<?
$login=$_SESSION["login"];
if($db["battle"] && $db["hp"] && $db["battle_opponent"]!="")
{
	$bid=$db["battle"];
	mysql_query("UPDATE person_on SET pr_active=2,pr_wait_for=".$is_pr["wait"]." WHERE id_person='".$db["id"]."' and pr_name='".$is_pr["type"]."' and battle_id='".$bid."'");
	mysql_query("UPDATE  battle_units SET hit=hit-".(int)$is_pr["hit"].",krit=krit-".(int)$is_pr["krit"].",uvarot=uvarot-".(int)$is_pr["uvarot"].",block=block-".(int)$is_pr["block"].",hp=hp-".(int)$is_pr["hp"].",counter=counter-".(int)$is_pr["all_hit"]." WHERE player='".$login."' and battle_id='".$bid."'");
}
?>