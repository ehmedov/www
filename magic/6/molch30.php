<?include("key.php");
define("SILENT", 30);
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
$reason=htmlspecialchars(addslashes($_POST['reason']));
if(!empty($target))
{
	if($db["orden"]==6 && $db["admin_level"]>=2)
	{
		$result=mysql_query("select * from users where login='".$target."'");
		$res=mysql_fetch_array($result);
		mysql_free_result($result);
		if(!$res)
		{
			echo "Персонаж <B>".$target."</B> не найден в базе данных.";
			die();
		}
		if ($res['login']=="СОЗДАТЕЛЬ")
		{
			echo "Редактирование богов запрещено высшей силой!";
			die();
		}
		if ($res['shut']!=0)
		{
			echo "На персонажа <b>".$res["login"]."</b> уже заложена заклятие молчания!";
			die();
		}
		if ($db["adminsite"]!=5)
		{	
			if($res['adminsite']>=5 || $res["admin_level"]>=9 )
			{
				echo "Редактирование богов запрещено высшей силой!";
				die();
			}
		}	
		$d=date("H.i");
		$time2=time()+SILENT*60;
		mysql_query("UPDATE users SET shut='".$time2."',shut_reason='".$reason."' WHERE login='".$res['login']."'");

		$hours=floor(SILENT/60);
		$minutes=SILENT-$hours*60;

		if($hours>0)
		{
			if($hours==2 || $hours==24)
			{
				$hours_d="$hours часа";
			}
			else
			{
				$hours_d="$hours часов";
			}
			$minutes_d="";
		}
		else
		{
			$hours_d="";
			$minutes_d="$minutes минут";
		}
		$pref=$db["sex"];
		if($pref=="female")
		{
			$prefix="а";
		}
		else
		{
			$prefix="";
		}		
		if ($reason!="")
		{	
			$reason_text="<b>Причина:</b> <i>".$reason."</i>";
		}
		else $reason_text="";	 
		say("toall","<font color=#40404A>Смерть Души <b>&quot".$login."&quot</b> использовал$prefix заклятие молчания на персонажа <b>&quot".$res['login']."&quot</b> на $hours_d $minutes_d. $reason_text</font>",$login);
		history($target,"Молчанка на 30 мин.",$reason_text,$ip,$login);
		history($login,"Молчанка на 30 мин.",$reason_text,$ip,$target);		
		$time_d = $hours_d."  ".$minutes_d;
		echo "Кляп засунут в рот <b>".$target."</b>. Он будет молчать ".$time_d ;
	}
}
?>
