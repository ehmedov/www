<?
$login=$_SESSION['login'];
if($db["zayavka"])
{
	$_SESSION["message"]="Вы в заявке...";
}
else
{
	switch ($mtype)
	{
		case "jj1": $hp_add = $db["power"]*2; 	break;
		case "jj2": $hp_add = $db["power"]*4; 	break;
		case "jj3": $hp_add = $db["power"]*6; 	break;
		case "jj4": $hp_add = $db["power"]*8; 	break;
		case "jj5": $hp_add = $db["power"]*10; break;
		case "jj6": $hp_add = $db["power"]*12; break;
	}
	$zaman=time()+2*3600;
	$type="jj";
	$have_elik=mysql_fetch_Array(mysql_query("SELECT * FROM effects WHERE user_id=".$db["id"]." and type='".$type."'"));
	if (!$have_elik)
	{
		mysql_query("UPDATE users SET hp_all=hp_all+".$hp_add." WHERE login='".$db["login"]."'");
		setMN($login,$db["mana"]-$mana,$db["mana_all"]);

		mysql_query("INSERT INTO effects (user_id,type,elik_id,add_hp,end_time) VALUES ('".$db["id"]."','$type','$elik_id','$hp_add','$zaman')");
		$_SESSION["message"]="Вы удачно прокастовали заклинание <b>&laquo;".$name."&raquo;</b>.";
		drop($spell,$DATA);
	}
	else
	{
		$_SESSION["message"]="Вы уже использовали это заклятие...";
	}
}
?>