<?
if($db["battle"] && $db["hp"] && $db["battle_opponent"]!="")
{
	switch ($is_pr["type"]) 
	{
		case "airhp7": $hp_min=1;$hp_max=183;break;
		case "airhp8": $hp_min=1;$hp_max=219;break;
		case "airhp9": $hp_min=1;$hp_max=263;break;
		case "airhp10":$hp_min=1;$hp_max=316;break;
	}

	$date = date("H:i");
	$target=$db["battle_opponent"];
	$login=$_SESSION["login"];
	$creator = $db["battle_pos"];
	$b_id=$db["battle"];
	$my_team=$db["battle_team"];
	if($db["battle_team"]==1){$span = "p1";$span2 = "p2";}else{$span = "p2";$span2 = "p1";}
	
	$victims=array();
	$opponents = mysql_query("SELECT player,id,hp,hp_all FROM teams as tem  LEFT JOIN users us on us.login=tem.player WHERE battle_id = '".$creator."' and hp>0 and team=$my_team");
	if (mysql_num_rows($opponents))
	{
    	while ($opponent=mysql_fetch_array($opponents)) 
    	{
			$victims[] = array("opponent"=>$opponent["player"], "hp"=>$opponent["hp"], "hp_all"=>$opponent["hp_all"]);
    	}
	}
	
	$n=rand(1,3);//kolichestvo
	$n2=count($victims);
	if($n2<$n) $n=$n2;
	$i=0;
	$ret['action']='';

	shuffle($victims);
	for($i=0;$i<$n;$i++) 
	{
		$hp_now=$victims[$i]["hp"];
		$hp_all=$victims[$i]["hp_all"];
		$opponenti=$victims[$i]["opponent"];
		
		$hp_add=ceil(mt_rand($hp_min, $hp_max));
	 	
	 	if($hp_all - $hp_now<$hp_add)
		{
			$hp_add = $hp_all - $hp_now;
		}
		$hp_new = $hp_now + $hp_add;
		setHP($opponenti,$hp_new,$hp_all);

		$ret['action'].="<span class=date>$date</span> <span class=$span>".$login."</span> понимая, что ситуация становится критической, применил прием <span class=magic>".$is_pr["name"]."</span> и восстановил здоровье <span class=$span>".$opponenti."</span> на <span class=hitted>+$hp_add</span> [$hp_new/$hp_all]<BR>";
	}
	mysql_query("UPDATE battle_units SET hit=hit-".(int)$is_pr["hit"].",krit=krit-".(int)$is_pr["krit"].",uvarot=uvarot-".(int)$is_pr["uvarot"].",block=block-".(int)$is_pr["block"].",hp=hp-".(int)$is_pr["hp"].",counter=counter-".(int)$is_pr["all_hit"]." WHERE player='".$login."' and battle_id='".$b_id."'");
	mysql_query("UPDATE person_on SET pr_active=1,pr_wait_for=".$is_pr["wait"]." WHERE id_person='".$db["id"]."' and pr_name='airhp7' and battle_id='".$b_id."'");
	mysql_query("UPDATE person_on SET pr_active=1,pr_wait_for=".$is_pr["wait"]." WHERE id_person='".$db["id"]."' and pr_name='airhp8' and battle_id='".$b_id."'");
	mysql_query("UPDATE person_on SET pr_active=1,pr_wait_for=".$is_pr["wait"]." WHERE id_person='".$db["id"]."' and pr_name='airhp9' and battle_id='".$b_id."'");
	mysql_query("UPDATE person_on SET pr_active=1,pr_wait_for=".$is_pr["wait"]." WHERE id_person='".$db["id"]."' and pr_name='airhp10' and battle_id='".$b_id."'");

	battle_log($b_id, $ret['action']);
	hit($login,$target,0,0,0,0,$b_id,0);
}
?>