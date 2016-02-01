<?
$login=$_SESSION['login'];
if($db["battle"])
{
	say($login, "Вы не можете кастовать это заклятие находясь в бою!", $login);
}
else
{	
	$target=htmlspecialchars(addslashes($_REQUEST['target']));
	$res=mysql_fetch_array(mysql_query("SELECT users.*, (SELECT count(*) FROM online WHERE login='".$target."') as online  FROM users WHERE login='".$target."'"));
	if(!$res)
	{
		$_SESSION["message"]="Персонаж ".$target." не найден.";
	}
	else if(!$res["online"] || ($res["login"]=="bor" && !$db["adminsite"]))
	{
		$_SESSION["message"]="Персонаж ".$res["login"]." сейчас офф-лайн.";
	}
	else if($res["room"]=="house")
	{
		$_SESSION["message"]="Персонаж ".$res["login"]." сейчас в Гостинице.";
	}
	else if($res["zayavka"])
	{
		$_SESSION["message"]="Персонаж <B>".$target."</B> находиться в бою! Это заклятие не действует на персонажа !!!";
	}
	else
	{
		switch ($mtype)
		{
			case "jj1": $hp_add = $res["power"]*2; 	break;
			case "jj2": $hp_add = $res["power"]*4; 	break;
			case "jj3": $hp_add = $res["power"]*6; 	break;
			case "jj4": $hp_add = $res["power"]*8; 	break;
			case "jj5": $hp_add = $res["power"]*10; break;
			case "jj6": $hp_add = $res["power"]*12; break;
		}
		$zaman=time()+2*3600;
		$type="jj";
		$have_elik=mysql_fetch_Array(mysql_query("SELECT * FROM effects WHERE user_id=".$res["id"]." and type='".$type."'"));
		if (!$have_elik)
		{
			mysql_query("UPDATE users SET hp_all=hp_all+".$hp_add." WHERE login='".$res["login"]."'");
			setMN($login,$db["mana"]-$mana,$db["mana_all"]);

			mysql_query("INSERT INTO effects (user_id,type,elik_id,add_hp,end_time) VALUES ('".$res["id"]."','$type','$elik_id','$hp_add','$zaman')");
			$_SESSION["message"]="Вы удачно прокастовали заклинание <b>&laquo;".$name."&raquo;</b> на персонажа ".$res["login"].".";
			if($db["adminsite"])$logins="Высшая сила";
			else $logins=$db["login"];
			if($res["adminsite"])$res["login"]="Высшая сила";
			say("toall_news","Воин <b>".$logins."</b> удачно использован свиток <b>&laquo;".$name."&raquo;</b> на персонажа <b>".$res["login"]."</b>",$db["login"]);
			drop($spell,$DATA);
		}
		else
		{
			$_SESSION["message"]="Персонаж уже использовал это заклятие...";
		}
	}
}
echo "<script>location.href='main.php?act=inv&otdel=magic'</script>";
?>