<?
if($db["battle"] && $db["hp"] && $db["battle_opponent"]!="")
{
	switch ($is_pr["type"]) 
	{
		case "earthhp6": $hp_min=16;$hp_max=17;$hp_me=35;break;
		case "earthhp7": $hp_min=20;$hp_max=21;$hp_me=43;break;
		case "earthhp8": $hp_min=24;$hp_max=25;$hp_me=51;break;
		case "earthhp9": $hp_min=29;$hp_max=30;$hp_me=62;break;
		case "earthhp10":$hp_min=36;$hp_max=37;$hp_me=75;break;
	}

	$date = date("H:i");
	$login=$_SESSION["login"];
	$creator = $db["battle_pos"];
	$b_id=$db["battle"];
	$my_team=$db["battle_team"];
	if($db["battle_team"]==1){$span = "p1";$span2 = "p2";}else{$span = "p2";$span2 = "p1";}
	
	$victims=array();
	$opponents = mysql_query("SELECT player,id,hp,hp_all FROM teams as tem  LEFT JOIN users us on us.login=tem.player WHERE battle_id = '".$creator."' and hp>0 and team=$my_team and login!='".$login."'");
	if (mysql_num_rows($opponents))
	{
    	while ($opponent=mysql_fetch_array($opponents)) 
    	{
			$victims[] = array("opponent"=>$opponent["player"], "hp"=>$opponent["hp"], "hp_all"=>$opponent["hp_all"]);
    	}
	}
	
	$n=5;//kolichestvo
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

	if($db["hp"]<$db["hp_all"])
	{
		if($db["hp_all"] - $db["hp"]<$hp_me)
		{
			$hp_me = $db["hp_all"] - $db["hp"];
		}
		$hp_new_me = $db["hp"] + $hp_me;
		setHP($login,$hp_new_me,$db["hp_all"]);
		$ret['action'].="<span class=date>$date</span> <span class=$span>".$login."</span> понимая, что ситуация становится критической, применил прием <span class=magic>".$is_pr["name"]."</span> и восстановил свое здоровье <span class=hitted>+$hp_me</span> [$hp_new_me/".$db["hp_all"]."]<BR>";
		$yes_me=1;
	}
	if (count($victims)>0 || $yes_me==1)
	{	
		mysql_query("UPDATE battle_units SET hit=hit-".(int)$is_pr["hit"].",krit=krit-".(int)$is_pr["krit"].",uvarot=uvarot-".(int)$is_pr["uvarot"].",block=block-".(int)$is_pr["block"].",hp=hp-".(int)$is_pr["hp"].",counter=counter-".(int)$is_pr["all_hit"]." WHERE player='".$login."' and battle_id='".$b_id."'");
		mysql_query("UPDATE person_on SET pr_active=1,pr_wait_for=".$is_pr["wait"]." WHERE id_person='".$db["id"]."' and pr_name='earthhp6' and battle_id='".$b_id."'");
		mysql_query("UPDATE person_on SET pr_active=1,pr_wait_for=".$is_pr["wait"]." WHERE id_person='".$db["id"]."' and pr_name='earthhp7' and battle_id='".$b_id."'");
		mysql_query("UPDATE person_on SET pr_active=1,pr_wait_for=".$is_pr["wait"]." WHERE id_person='".$db["id"]."' and pr_name='earthhp8' and battle_id='".$b_id."'");
		mysql_query("UPDATE person_on SET pr_active=1,pr_wait_for=".$is_pr["wait"]." WHERE id_person='".$db["id"]."' and pr_name='earthhp9' and battle_id='".$b_id."'");
		mysql_query("UPDATE person_on SET pr_active=1,pr_wait_for=".$is_pr["wait"]." WHERE id_person='".$db["id"]."' and pr_name='earthhp10' and battle_id='".$b_id."'");
	
	}
	battle_log($b_id, $ret['action']);
	hit($login,$db["battle_opponent"],0,0,0,0,$b_id,0);

}
?>