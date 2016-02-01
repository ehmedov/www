<?
$target=htmlspecialchars(addslashes($_REQUEST['target']));
$login=$_SESSION['login'];
$ip=$db['remote_ip'];
$date = date("H:i");
$rooms=array("mount","smert_room" ,"dungeon" ,"house", "hospital", "znaxar", "lesopilka", "bank", "sklad", "castle", "castle_hall", 
"pochta", "towerin", "proverka" ,"labirint_led", "crypt", "warcrypt", "war_labirint", "doblest_shop","mayak", "novruz", "novruz_go", "novruz_shop", "novruz_floor");

$Is_Naemnik=mysql_fetch_array(mysql_query("SELECT count(*) FROM person_proff WHERE proff=9 and person=".$db["id"]));

if ($_REQUEST['target'])
{
	if(!$db["battle"])
	{
		$q=mysql_query("SELECT users.*,(select count(*) from online where login='".$target."' limit 1) as online FROM `users` WHERE login = '".$target."' limit 1");
		$res=mysql_fetch_array($q);
		mysql_free_result($q);
		$online = $res['online'];
		if(!$res)
		{
			$_SESSION["message"]="Персонаж ".$target." не найден.";
		}
		else if (!$Is_Naemnik[0])
		{
			$_SESSION["message"]="Изучите профессию Наемник. \"Окраина -> Академия Профессии -> Наёмник\"";
		}
		else if($db["id"] == $res["id"])
        {
			$_SESSION["message"]="Нападение на самого себя - это уже мазохизм...";        
		}
		else if(!$online || $res["adminsite"])
		{
			$_SESSION["message"]="Персонаж ".$target." сейчас офф-лайн.";
		}
		else if($res["room"]!=$db["room"])
        {
        	$_SESSION["message"]="Для подмоги Вам необходимо находится в одной комнате!";
        }
		else if(in_Array($db["room"],$rooms))
        {
        	$_SESSION["message"]="В этом комнате подмога запрещена...";
        }
        else if($res["level"]<1)
        {
        	$_SESSION["message"]="Нулевым не нужна подмога!";
        }
        else if(!empty($db["travm"]))
		{
			$_SESSION["message"]="Вы не можете драться, т.к. тяжело травмированы!";
		}
        else if($db["zayavka"])
        {
        	$_SESSION["message"]="Сначала отзовите текущую заявку...";
        }
        else if($db["hp"] < $db["hp_all"]*0.3)
        {
        	$_SESSION["message"]="Вы слишком ослаблены для боя!";
        }
		else if ($res["battle"])
		{
			$t=array(5,102,1,100,11,77,7);
			if ($db["orden"]==4) {$pr1="(2)";$pr2="(4)";}
			else if ($db["orden"]==2 ||$db["orden"]==5) {$pr1="(4)";$pr2="(2,6)";}
			else {$pr1="(9)";$pr2="(9)";}
			$battle_team=$res["battle_team"];
			$mynewteam=($battle_team==1?2:1);
			$b_sql=mysql_query("SELECT zayavka.type,zayavka.maxlev1,zayavka.maxlev2,battles.win,battles.creator_id FROM battles LEFT JOIN zayavka on zayavka.creator=battles.creator_id WHERE battles.id=".$res["battle"]);
			$b_t=mysql_fetch_array($b_sql);
			if ($b_t["win"]==0)
			{
				$battle_id=$b_t["creator_id"];
				
				$battle_team=$res["battle_team"];
				switch ($battle_team)
				{
					case 1: $mynewteam=2;break;
					case 2: $mynewteam=1;break;
				}

				if(in_array($b_t["type"],$t))
				{
					$_SESSION["message"]="Запрещено вмешательство в бой!";
				}
				else if($db["battle_exit"]==$res["battle"])
				{
					$_SESSION["message"]="Кто тебя выкинул из боя.";
				}
				else
				{
					$sql1=mysql_query("SELECT count(t.player) as coun FROM teams t LEFT JOIN users us on t.player=us.login WHERE t.battle_id='".$battle_id."' and t.team=$battle_team and us.orden IN $pr1");
					$sql2=mysql_query("SELECT count(t.player) as coun FROM teams t LEFT JOIN users us on t.player=us.login WHERE t.battle_id='".$battle_id."' and t.team=$mynewteam and us.orden IN $pr2");

					$x1=mysql_fetch_array($sql1);
					$x2=mysql_fetch_array($sql2);
					if ($x1['coun']>0 && $b_t["type"]!=23) 
					{
						$_SESSION["message"]="Предупреждение! Вы не можете принять сторону врагов...";
					}
					else if ($x2['coun']>0 && $b_t["type"]!=23) 
					{
						$_SESSION["message"]="Предупреждение! Вы не можете идти на поединок против своих...";
					}
					else
					{
						drop($spell,$DATA);
			        	mysql_query("INSERT INTO teams(player,team,ip,battle_id,hitted,over) VALUES('".$login."','".$battle_team."','".$ip."','".$battle_id."','0','0')");
						$att="<span class=sysdate>$date</span> <script>drwfl('".$db['login']."','".$db['id']."','".$db['level']."','".$db['dealer']."','".$db['orden']."','".$db['admin_level']."','".$db['clan_short']."','".$db['clan']."');</script> вмешался в поединок!<hr>";
						battle_log($res['battle'], $att);
						goBattle($login);
					}
				}
			}
			else $_SESSION["message"]="Бой закончен...";
		}
		else $_SESSION["message"]="Персонаж ".$target." не в бою";
	}
	else
	{
		say($login, "Вы не можете кастовать это заклятие находясь в бою!", $login);
 	}
}
echo "<script>location.href='main.php?act=inv&otdel=magic'</script>";
?>