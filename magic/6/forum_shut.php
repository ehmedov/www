<?include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
if(!empty($target))
{
	if($db["orden"]==6 && $db["admin_level"]>=1)
	{
		$S="select * from users where login='".$target."'";
		$q=mysql_query($S);
		$res=mysql_fetch_array($q);
		if(!$res)
		{
			print "Персонаж <B>".$target."</B> не найден в базе данных.";
			die();
		}
		if ($res['login']=="СОЗДАТЕЛЬ")
		{
			print "Редактирование богов запрещено высшей силой!";
			die();
		}
		if ($db["adminsite"]!=5)
		{	
			if($res['adminsite']>=5 || $res["admin_level"]>=9 )
			{
				print "Редактирование богов запрещено высшей силой!";
				die();
			}
		}	
		$d=date("H.i");
		$time2=time()+$_POST['timer']*60;
		$sql = "UPDATE users SET forum_shut='".$time2."' WHERE login='".$target."'";
		$result = mysql_query($sql);

		$hours=floor($_POST['timer']/60);
		$minutes=$_POST['timer']-$hours*60;

		if($hours>0)
		{
			if($hours==2 or $hours==24)
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
		if ($_POST['reason']!="")
		{	
			$reson="Причина: ".htmlspecialchars(addslashes($_POST['reason']));
		}
		else $reson="";	 
		say("toall","<font color=#40404A>Смерть Души <b>&quot".$login."&quot</b> наложил$prefix заклятие форумного молчания на <b>&quot".$target."&quot</b>, сроком $hours_d $minutes_d. $reson</font>",$login);
		history($target,"Поставили форумного молчания",$reson,$ip,$login);
		history($login,"наложил$prefix заклятие форумного молчания",$reson,$ip,$target);
		print "Он будет молчать $hours_d $minutes_d";
	}
}
?>
