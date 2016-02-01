<?include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
if(!empty($target))
{
	if($db["orden"]==1 && $db["admin_level"]>=1)
	{
		$q=mysql_query("SELECT * FROM users WHERE login='".$target."'");
		$res=mysql_fetch_array($q);
		if(!$res)
		{
			echo "Персонаж <B>".$target."</B> не найден в базе данных.";
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
		$time2=time()+$_POST['timer']*60;
		mysql_query("UPDATE users SET forum_shut='".$time2."' WHERE login='".$target."'");

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
			$reson="<b>Причина:</b> <i>".htmlspecialchars(addslashes($_POST['reason']))."</i>";
			$reson = str_replace("&amp;","&",$reson);
		}
		else $reson="";
		if($db["adminsite"])$logins="Высшая сила";
		else $logins=$login;
		talk("toall","Представитель порядка <b>&quot".$logins."&quot</b> наложил$prefix заклятие форумного молчания на <b>&quot".$res['login']."&quot</b> на $hours_d $minutes_d. $reson","");
		history($target,"Поставили форумного молчания",$reson,$ip,$logins);
		history($login,"наложил$prefix заклятие форумного молчания",$reson,$ip,$target);
		echo "Он будет молчать $hours_d $minutes_d";
	}
}
?>
