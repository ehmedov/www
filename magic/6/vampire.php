<?include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
if($db["orden"]==6)
{
	if ($db["battle"]=='0')
	{	
		$q=mysql_query("select * from users where login='".$target."'");
		$res=mysql_fetch_array($q);
		if(!$res)
		{
			$err= "Персонаж <B>".$target."</B> не найден в базе данных.";
		}
		else if($res["login"] == $login)
		{
			$err= "Кастование на самого себя - это уже мазохизм...";
		}
		else if($res["orden"] == 1 || $res["orden"] == 6)
		{
			$err= "Это заклятие не действует на персонажа <B>".$target."</B>";
		}
		else if($res["vampiretime"]!=0)
		{
			$err= "Вы не можете нанести вред на персонажа <B>".$target."</B>. Он находится под дейсвием елексира <i>&quotМасло против вампиров&quot</i>";
		}
		else if($res["room"]!=$db["room"])
        {
        	$err= "Для кастования Вам необходимо находится в одной комнате!";
        }
		else if($res["battle"] !='0')
		{
			$err= "Персонаж <B>".$target."</B> находиться в бою! Это заклятие не действует на персонажа !!!";
		}
		else if($res["hp"]<($res["hp_all"]/100)*25)
		{
			$err= "Персонаж <B>".$target."</B> слишком ослаблен, чтобы применить к нему это заклинание.";		
		}
		else
		{
			$hp_t = $res["hp_all"];
			$min_dr_hp = floor($hp_t/100);
			$drink_hp = $res["hp"];			
			$tar_allhp = $res["hp_all"];		
			$tar_newhp = 1;
			if ($res["hp"]+$db["hp"]>$db["hp_all"])$drink_hp=$db["hp_all"];
			else 	$drink_hp=$res["hp"];
			
			setHP($login,$drink_hp,$db["hp_all"]);
			setHP($target,$tar_newhp,$tar_allhp);					

			if($db["sex"]=="female"){$pref = "а";}
			else{$pref = "";}
			$err= "Заклятие прокастовано удачно. Вы удачно выпили энергию из персонажа &quot$target&quot";
			say($target,"<font color=#40404A>Смерть Души <b>&quot$login&quot</b> выпил$pref часть вашей энергии!</font>",$target);
		}
	}
	else
	{
		$err= "Вы в бою!. Заклятие не действует";
	}	
}
if ($err!="") echo "<font style='color:#ff0000'>$err</font>";

?>
