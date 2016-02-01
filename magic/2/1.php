<?
include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
$rooms=array("casino","smert_room" ,"house","hospital","znaxar","lesopilka","bank","towerin");

if($db["orden"]==2)
{
	if ($db["battle"]=='0')
	{
		$res=mysql_fetch_array(mysql_query("SELECT users.*,effects.end_time FROM users LEFT JOIN effects on effects.user_id=users.id and effects.type='vampire' WHERE users.login='".$target."'"));
		if(!$res)
		{
			$err= "Персонаж <B>".$target."</B> не найден в базе данных.";
		}
		else if($res["id"] == $db["id"])
		{
			$err= "Кастование на самого себя - это уже мазохизм...";
		}
		else if(($res["orden"] == 2)||($res["orden"] == 1))
		{
			$err= "Это заклятие не действует на персонажа <B>".$target."</B>";
		}
		else if(in_Array($res["room"],$rooms))
        {
        	$err="Это заклятие не действует в этом комнате";
        }
		else if($res["room"]!=$db["room"])
        {
        	$err= "Для кастования Вам необходимо находится в одной комнате!";
        }
		else if($res["end_time"]>time())
		{
			$err= "Вы не можете нанести вред на персонажа <B>".$target."</B>. Он находится под дейсвием елексира <i>&quotМасло против вампиров&quot</i>";
		}
		else if($res["battle"]!=0)
		{
			$err= "Персонаж <B>".$target."</B> находиться в бою! Это заклятие не действует на персонажа !!!";
		}
		else if($res["hp"]<0.3*$res["hp_all"])
		{
			$err= "Персонаж <B>".$target."</B> слишком ослаблен, чтобы применить к нему это заклинание.";		
		}
		else
		{
			$drink_hp = $res["hp"];
			if ($res["hp"]+$db["hp"]>=$db["hp_all"])$drink_hp=$db["hp_all"];
			
			setHP($login, $drink_hp, $db["hp_all"]);
			setHP($target, 1, $res["hp_all"]);

			if($db["sex"]=="female"){$pref = "а";}
			else{$pref = "";}
			$err= "Заклятие прокастовано удачно. Вы удачно выпили энергию из персонажа &quot$target&quot";
			say($target,"Вампир <b>&quot$login&quot</b> выпил$pref часть вашей энергии!",$target);
		}
	}
	else
	{
		$err= "Вы в бою!. Заклятие не действует";
	}	
}
if ($err!="") echo "<font style='color:#ff0000'>$err</font>";
?>