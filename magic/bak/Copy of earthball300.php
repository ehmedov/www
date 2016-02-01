<?define("DAMAGE_MIN", 95);
define("DAMAGE_MAX", 145);
$login=$_SESSION["login"];
if($db["battle"] && $db["hp"] && $db["battle_opponent"]!="")
{
	$t = time();
	$date = date("H:i");
	$enemy_team=($db["battle_team"]==1?'2':'1');
	if($db["battle_team"]==1){$span = "p1";$span2 = "p2";}else{$span = "p2";$span2 = "p1";}
	$creator = $db["battle_pos"];
	$b_id=$db["battle"];
	$victims=array();
	$hited_targets=array();
	
	$opponents = mysql_query("SELECT player,hp,hp_all,add_magic,magic_time FROM teams as tem  LEFT JOIN users us on us.login=tem.player WHERE battle_id = '".$creator."' and hp>0 and team=$enemy_team");
	if (mysql_num_rows($opponents))
	{
    	while ($opponent=mysql_fetch_array($opponents)) 
    	{
      		$user_turn=mysql_fetch_array(mysql_query("select * from hit_temp WHERE attack='".$opponent["player"]."' AND defend='".$login."'"));
      		if (!$user_turn) 
      		{
      			$victims[] = array("opponent"=>$opponent["player"], "types"=>"human", "hp"=>$opponent["hp"], "hp_all"=>$opponent["hp_all"],"add_magic"=>$opponent["add_magic"],"magic_time"=>$opponent["magic_time"]);
      		}
    	}
	}
	$BLD_ = mysql_query("SELECT * FROM bot_temp WHERE battle_id='".$b_id."' and hp>0 and team=$enemy_team");
	if (mysql_num_rows($BLD_))
	{	
		while ($BLD=mysql_fetch_array($BLD_))
		{
			$victims[] = array("opponent"=>$BLD["bot_name"], "types"=>"bot", "hp"=>$BLD["hp"], "hp_all"=>$BLD["hp_all"],"add_magic"=>0,"magic_time"=>0);
		}
	}
	$n=5;//kolichestvo udarov
	$n2=count($victims);
	
	if($n2<$n) $n=$n2;
	$i=$ret['uron']=0;
	$ret['action']='';
	if ($db["hand_r_type"]=="staff")$k=rand($db["hand_r_hitmin"],$db["hand_r_hitmax"]);
	$sql=mysql_query("SELECT art,is_personal,inv.is_modified FROM paltar,(SELECT * FROM inv where id=".$db["hand_r"]." and owner='".$db["login"]."') as inv WHERE paltar.id=inv.object_id");
	$modif=mysql_fetch_array($sql);
	$is_modified=$modif['is_modified'];
	$is_art=$modif['art'];
	$is_personal=$modif['is_personal'];

	$f=ceil($db["intellekt"]+ 10*$db["earth_magic"] + DAMAGE_MIN + $k);
	$g=ceil($db["intellekt"]+ 10*$db["earth_magic"] + DAMAGE_MAX + $k);
	shuffle($victims);
	for($i=0;$i<$n;$i++) 
	{
		$uron=floor(mt_rand($f, $g));
		$uron=$uron+($is_modified?$is_modified*5:0)+($is_art?$uron*0.2:0)+($is_personal?$uron*0.7:0);
		$uron=ceil($uron);
		if ($victims[$i]["magic_time"]>time())$uron=$uron-ceil($uron*$victims[$i]["add_magic"]/100);
		$hp_new=$victims[$i]["hp"]-$uron;
		$hited_targets[]=$victims[$i]["opponent"];
	    if ($hp_new <= 0 )
	    {
	    	$hp_new=0;
	    	$ret['action'].= "<span class=date>$date</span> <B>".$victims[$i]["opponent"]." убит</B><BR>";
	    }		
		if ($victims[$i]["types"]=="human")
		{
			mysql_query("UPDATE users SET hp='".$hp_new."' WHERE login='".$victims[$i]["opponent"]."'");			
		}
		else if ($victims[$i]["types"]=="bot")
		{
			mysql_query("UPDATE bot_temp SET hp='".$hp_new."' WHERE battle_id='".$b_id."' AND bot_name='".$victims[$i]["opponent"]."'");
		}
		$ret['action'].="<span class=date>$date</span> <span class=$span>".$login."</span> обрушил <span class=magic>Каменный Дождь[6]</span> на <span class=$span2>".$victims[$i]["opponent"]."</span>, <span class=hitted>-$uron</span> [".$hp_new."/".$victims[$i]["hp_all"]."]<BR>";
		$ret['uron']+=$uron;	
	}
	mysql_query("UPDATE teams SET hitted=hitted+".$ret['uron']." WHERE player='".$login."'");
	mysql_query("UPDATE users SET battle_opponent='' WHERE login='".$login."'");
	mysql_query("UPDATE timeout SET lasthit='".$t."' WHERE battle_id='".$b_id."'");
	
	$td = fopen("logs/".$b_id.".dis","a");
	fputs($td,$ret['action']);
	fclose($td);
	
	mysql_query("UPDATE inv SET iznos = iznos+1 WHERE id='".$id."'");
	$S_INV = mysql_query("SELECT iznos,iznos_max FROM inv WHERE id = '".$id."' limit 1");
	$DAT = mysql_fetch_array($S_INV);
	if($DAT["iznos"]==$DAT["iznos_max"])
	{
		mysql_query("UPDATE users SET slot".$slot."=0 WHERE login='".$login."'");
		mysql_query("DELETE FROM inv WHERE id = '".$id."'");
		say($login, "Заклинание <b>&laquo;".$name."&raquo;</b> полностью использован!", $login);
	}
	$c=count($hited_targets);
	for($i=0;$i<$c;$i++) 
	{
		hit($login,$hited_targets[$i],0,0,0,$b_id);
	}
}
?>
