<?
if($db["battle"] && $db["hp"] && $db["battle_opponent"]!="")
{
	switch ($is_pr["type"]) 
	{
		case "watterhp5": $hp_min=75;$hp_max=79;break;
		case "watterhp6": $hp_min=90;$hp_max=95;break;
		case "watterhp7": $hp_min=110;$hp_max=115;break;
		case "watterhp8": $hp_min=135;$hp_max=138;break;
		case "watterhp9": $hp_min=165;$hp_max=166;break;
		case "watterhp10":$hp_min=200;$hp_max=205;break;
	}

	$date = date("H:i");
	$select_target=$login;
	$login=$_SESSION["login"];
	$creator = $db["battle_pos"];
	$b_id=$db["battle"];
	$my_team=$db["battle_team"];
	if($db["battle_team"]==1){$span = "p1";$span2 = "p2";}else{$span = "p2";$span2 = "p1";}
	
	$victims=array();
	$opponents = mysql_query("SELECT player,id,hp,hp_all FROM teams LEFT JOIN users on users.login=teams.player WHERE teams.battle_id = '".$creator."' and login='$select_target' and hp>0 and team=$my_team");
	$opponent=mysql_fetch_array($opponents);
	
	if ($opponent)	
    {	
		$ret['action']='';
		$hp_now=$opponent["hp"];
		$hp_all=$opponent["hp_all"];
		$hp_add=ceil(mt_rand($hp_min, $hp_max));

	 	if($hp_all - $hp_now<$hp_add)
		{
			$hp_add = $hp_all - $hp_now;
		}
		$hp_new = $hp_now + $hp_add;
		setHP($select_target,$hp_new,$hp_all);

		$ret['action'].="<span class=date>$date</span> <span class=$span>".$login."</span> понимая, что ситуация становится критической, применил прием <span class=magic>".$is_pr["name"]."</span> и восстановил здоровье <span class=$span>".$select_target."</span> на <span class=hitted>+$hp_add</span> [$hp_new/$hp_all]<BR>";
		mysql_query("UPDATE battle_units SET hit=hit-".(int)$is_pr["hit"].",krit=krit-".(int)$is_pr["krit"].",uvarot=uvarot-".(int)$is_pr["uvarot"].",block=block-".(int)$is_pr["block"].",hp=hp-".(int)$is_pr["hp"].",counter=counter-".(int)$is_pr["all_hit"]." WHERE player='".$login."' and battle_id='".$b_id."'");
		mysql_query("UPDATE person_on SET pr_active=1,pr_wait_for=".$is_pr["wait"]." WHERE id_person='".$db["id"]."' and pr_name='watterhp5' and battle_id='".$b_id."'");
		mysql_query("UPDATE person_on SET pr_active=1,pr_wait_for=".$is_pr["wait"]." WHERE id_person='".$db["id"]."' and pr_name='watterhp6' and battle_id='".$b_id."'");
		mysql_query("UPDATE person_on SET pr_active=1,pr_wait_for=".$is_pr["wait"]." WHERE id_person='".$db["id"]."' and pr_name='watterhp7' and battle_id='".$b_id."'");
		mysql_query("UPDATE person_on SET pr_active=1,pr_wait_for=".$is_pr["wait"]." WHERE id_person='".$db["id"]."' and pr_name='watterhp8' and battle_id='".$b_id."'");
		mysql_query("UPDATE person_on SET pr_active=1,pr_wait_for=".$is_pr["wait"]." WHERE id_person='".$db["id"]."' and pr_name='watterhp9' and battle_id='".$b_id."'");
		mysql_query("UPDATE person_on SET pr_active=1,pr_wait_for=".$is_pr["wait"]." WHERE id_person='".$db["id"]."' and pr_name='watterhp10' and battle_id='".$b_id."'");

		battle_log($b_id, $ret['action']);
	}
}
?>