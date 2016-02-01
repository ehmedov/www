<?
$target=htmlspecialchars(addslashes($_REQUEST['target']));
$login=$_SESSION["login"];
$my_remote=$db["remote_ip"];
$date = date("H:i");
$rooms=array("mount","casino", "smert_room", "dungeon", "house", "hospital", "znaxar", "lesopilka", "bank", "sklad", "castle", "castle_hall", "pochta", "towerin",
 "proverka", "labirint_led", "crypt", "crypt_floor2", "magicstore", "artmag", "smith", "plshop", "artshop", "auction", "warcrypt", "war_labirint", "doblest_shop","mayak", "novruz", "novruz_go", "novruz_shop", "novruz_floor");

$Is_Naemnik=mysql_fetch_array(mysql_query("SELECT count(*) FROM person_proff WHERE proff=9 and person=".$db["id"]));

if ($_REQUEST['target'])
{
	if(!$db["battle"])
	{
		$q=mysql_query("SELECT users.*,(select count(*) from online where login='".$target."') as online FROM `users` WHERE login = '".$target."'");
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
			$_SESSION["message"]="Персонаж ".$res["login"]." сейчас офф-лайн.";
		}
		else if($db["clan"]!="" && $db["clan"]==$res["clan"])
        {
			$_SESSION["message"]="Вы не можете идти на поединок против своего клана...";
		}
		else if($db["hp"] < $db["hp_all"]*0.3)
        {
        	$_SESSION["message"]="Вы слишком ослаблены для боя!";
        }
		else if($res["oslab"]>time())
		{
			$_SESSION["message"]="Вы не можете нападать на персонажа ".$res["login"]." т.к. персонаж ослаблен из-за смерти в бою...";
		}
		else if($my_remote==$res['remote_ip'])
		{
			$_SESSION["message"]="Вы не можете нападать на персонажа с таким же IP как у вас!";
		}
		else if($res["room"]!=$db["room"])
        {
        	$_SESSION["message"]="Для нападния Вам необходимо находится в одной комнате!";
        }
        else if(in_Array($db["room"],$rooms))
        {
        	$_SESSION["message"]="В этом комнате нападать запрещен...";
        }
        else if($res["level"]<1)
        {
        	$_SESSION["message"]="Нулевым нападать запрещено!";
        }
		else if($res["hp"] < $res["hp_all"]*0.3)
        {
        	$_SESSION["message"]="Персонаж ".$target." слишком ослаблен!";
        }
        else if(!empty($db["travm"]))
		{
			$_SESSION["message"]="Вы не можете драться, т.к. тяжело травмированы!";
		}
		else if(!empty($res["travm"]))
		{
			$_SESSION["message"]="Противник не можете драться, т.к. тяжело травмирован!";
		}
        else if($db["zayavka"])
        {
        	$_SESSION["message"]="Сначала отзовите текущую заявку...";
        }
		else if ($db["level"]-$res['level']>=4)
		{
			$_SESSION["message"]="Ваш уровень слишком большой для этого боя!";
		}
		else if ($res['level']-$db["level"]>=4)
		{
			$_SESSION["message"]="Ваш уровень слишком низкий для этого боя!";
		}
		else if (!$res["battle"] && $res["zayavka"])
		{
			$_SESSION["message"]="Противник не можете драться, т.к. он в заявке!";
		}
		else
		{
			if (!$res["battle"])
			{
				if (($db["orden"]==2 && $res["orden"]==2) || ($db["orden"]==4 && $res["orden"]==4))
				{
					$_SESSION["message"]="Предупреждение! Вы не можете идти на поединок против своих...";
				}
				else
				{
					drop($spell,$DATA);
					$mine_id=$db["id"];
			        talk("toall","<b>&laquo;".$login."&raquo;</b> напал на <b>&laquo;".$res["login"]."&raquo;</b>!","");
			        talk($res["login"],"<b>&laquo;".$login."&raquo;</b> напал на вас!",$res);
			        mysql_query("INSERT INTO zayavka(status,type,timeout,creator) VALUES('3','44','3','".$mine_id."')");
			        mysql_query("INSERT INTO teams(player,team,ip,battle_id,hitted,over,leader) VALUES('".$login."','2','".$db["remote_ip"]."','".$mine_id."','0','0','1');");
			        mysql_query("INSERT INTO teams(player,team,ip,battle_id,hitted,over,leader) VALUES('".$res["login"]."','1','".$res["remote_ip"]."','".$mine_id."','0','0','1');");
			        if ($db["level"]<=$res["level"])mysql_query("UPDATE person_proff SET navika=navika+1 WHERE proff=9 and person=".$db["id"]);
			        goBattle($login);
			        goBattle($res["login"]);
		        }
			}
			else if ($res["battle"])
			{
				$t=array(5,102,1,100,11,23,77,7);
				if ($db["orden"]==4) {$pr1="(2)";$pr2="(4)";}
				else if ($db["orden"]==2) {$pr1="(4)";$pr2="(2,6)";}
				else {$pr1="(9)";$pr2="(9)";}

			
				$b_sql=mysql_query("SELECT zayavka.type,zayavka.maxlev1,zayavka.maxlev2,battles.win,battles.creator_id FROM battles LEFT JOIN zayavka on zayavka.creator=battles.creator_id WHERE battles.id=".$res["battle"]);
				$b_t=mysql_fetch_array($b_sql);
				if ($b_t["win"]==0)
				{	
					$battle_team=$res["battle_team"];
					switch ($battle_team)
					{
						case 1: $mynewteam=2; $max_level=$b_t["maxlev1"];break;
						case 2: $mynewteam=1; $max_level=$b_t["maxlev2"]; break;
					}
					
					$battle_id=$b_t["creator_id"];
					if(in_array($b_t["type"],$t))
					{
						$_SESSION["message"]="Запрещено вмешательство в бой!";
					}
					else if (($db["level"]-$max_level>=6) && $max_level>0)
					{
						$_SESSION["message"]="Ваш уровень слишком большой для этого боя!";
					}
					else if($db["battle_exit"]==$res["battle"])
					{
						$_SESSION["message"]="Кто тебя выкинул из боя.";
					}
					else 
					{	
						$sql1=mysql_query("SELECT count(t.player) as coun FROM teams t LEFT JOIN users us on t.player=us.login WHERE t.battle_id='".$battle_id."' and t.team=$mynewteam and us.orden IN $pr1");
						$sql2=mysql_query("SELECT count(t.player) as coun FROM teams t LEFT JOIN users us on t.player=us.login WHERE t.battle_id='".$battle_id."' and t.team=$battle_team and us.orden IN $pr2");

						$x1=mysql_fetch_array($sql1);
						$x2=mysql_fetch_array($sql2);
						if ($x1['coun']>0) 
						{
							$_SESSION["message"]="Предупреждение! Вы не можете принять сторону врагов...";
						}
						else if ($x2['coun']>0) 
						{
							$_SESSION["message"]="Предупреждение! Вы не можете идти на поединок против своих...";
						}
						else
						{	
							drop($spell,$DATA);
				        	mysql_query("INSERT INTO teams(player,team,ip,battle_id,hitted,over) VALUES('".$login."','".$mynewteam."','".$db["remote_ip"]."','".$battle_id."','0','0')");
							mysql_query("UPDATE person_proff SET navika=navika+1 WHERE proff=9 and person=".$db["id"]);
							talk("toall","<b>&laquo;".$login."&raquo;</b> вмешался в поединок против <b>&laquo;".$res["login"]."&raquo;</b>!","");
   							$att="<span class=sysdate>$date</span> <script>drwfl('".$db['login']."','".$db['id']."','".$db['level']."','".$db['dealer']."','".$db['orden']."','".$db['admin_level']."','".$db['clan_short']."','".$db['clan']."');</script> вмешался в поединок!<hr>";
							battle_log($res['battle'], $att);
					        goBattle($login);
				        }
				    }
				}
			}
		}
	}
}
echo "<script>location.href='main.php?act=inv&otdel=magic'</script>";
?>