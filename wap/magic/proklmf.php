<?
$login=$_SESSION["login"];
if($db["battle"] && $db["hp"] && $db["battle_opponent"]!="")
{
	$target=$db["battle_opponent"];
	$battle_id = $db["battle"];
	if($db["battle_team"]==1){$span = "p1";$span2 = "p2";}else{$span = "p2";$span2 = "p1";}
	$date = date("H:i");
	$zaman=time()+2*3600;
	$my_id=$db["id"];
	$type='battlemf';
	$phrase ="";
	$if_bot = mysql_fetch_Array(mysql_query("SELECT count(*) FROM `bot_temp` WHERE battle_id='".$db["battle"]."' AND bot_name='".$target."'"));
	if(!$if_bot[0])
	{
		$res=mysql_fetch_array(mysql_query("SELECT id, login FROM users WHERE login='".$target."'"));
		if(!$res)
		{
			$_SESSION["message"]="Персонаж <B>".$target."</B> не найден в базе данных.";
		}
		else
		{
			mysql_query("UPDATE inv SET iznos = iznos+1 WHERE id='".$id."'");
			$DAT = mysql_fetch_array(mysql_query("SELECT iznos,iznos_max FROM inv WHERE id = '".$id."'"));
			if($DAT["iznos"]==$DAT["iznos_max"])
			{
				mysql_query("UPDATE users SET slot".$slot."=0 WHERE login='".$login."'");
				mysql_query("DELETE FROM inv WHERE id = '".$id."'");
				say($login, "Заклинание <b>&laquo;".$name."&raquo;</b> полностью использован!", $login);
			}
			switch ($mtype) 
			{
				case "mfkrit": 		$add = -250; $prokl="Мф крит";		$remove="add_krit";		break;
				case "mfuvorot": 	$add = -250; $prokl="Мф уворот";	$remove="add_uvorot";	break;
				case "mfakrit": 	$add = -250; $prokl="Мф антикрит";	$remove="add_akrit";	break;
				case "mfauvorot": 	$add = -250; $prokl="Мф антиуворот";$remove="add_auvorot";	break;
			}
			mysql_query("DELETE FROM effects WHERE user_id=".$res["id"]." and type='".$type."'");
			mysql_query("INSERT INTO effects (user_id,battle_id,type,elik_id,$remove,end_time) VALUES ('".$res["id"]."','".$battle_id."','".$type."','".$obj_id."','".$add."','".$zaman."')");			
			
		    $phrase = "<span class=date>$date</span> <span class=$span>".$login."</span> использовал свиток <b>&laquo;".$name."&raquo;</b> на <span class=$span2>".$res["login"]."</span>, <span class=hitted>$prokl $add</span><br>";
			battle_log($battle_id, $phrase);
		}
	}
}
?>
