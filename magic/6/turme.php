<?include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
$reason=htmlspecialchars(addslashes($_POST['reason']));
$reason=str_replace("\n","<br>",$reason);
$timer=$_POST['timer'];
if(!empty($target))
{
	$q=mysql_query("select * from users where login='".$target."'");
	$res=mysql_fetch_array($q);
	if(!$res)
	{
		echo "ѕерсонаж <B>".$target."</B> не найден в базе данных.";
		die();
	}
	else if ($res['login']=="—ќ«ƒј“≈Ћ№")
	{
		echo "–едактирование богов запрещено высшей силой!";
		die();
	}
	else if ($db["adminsite"]!=5)
	{	
		if($res['adminsite']>=5 ||$res["admin_level"]>=9)
		{
			echo "ѕерсонаж <B>".$target."</B> не найден в базе данных.";
			die();
		}
	}
	$d=date("H.i");
	$chas = date("H");
	$vaxt=date("d.m.Y H:i:s", mktime($chas-$GSM));
	$time2=time()+$timer*3600;
	mysql_query("UPDATE users SET orden='5', otdel='', admin_level='',adminsite='',clan='',clan_short='',clan_take='',parent_temp='',prision='".$time2."',prision_reason='".$reason." (".$vaxt.", ".$login.")',metka='',parent_temp='' WHERE login='".$target."'");

	$pref=$db["sex"];
	if($pref=="female")
	{
		$prefix="а";
	}
	else
	{
		$prefix="";
	}
	if($timer==24){$days_d="сутки";}
	if($timer==72){$days_d="3 дн€";}
	if($timer==168){$days_d="неделю";}
	if($timer==360){$days_d="15 суток";}
	if($timer==744){$days_d="мес€ц";}
	if($timer==1440){$days_d="2 мес€ца";}
	if($timer==2160){$days_d="3 мес€ца";}
	if($timer==4320){$days_d="6 мес€ца";}
	if($timer==8640){$days_d="12 мес€ца";}

	say("toall","<font color=\"#40404A\">—мерть ƒуши <b>&laquo".$login."&raquo;</b> отправил".$prefix." в тюрьму персонажа <b>&laquo;".$target."&raquo;</b> на ".$days_d.".</font>",$login);
	echo "ѕерсонаж <b>".$target."</b> отправлен в тюрьму.";
	history($target,"ќтправлен в тюрьму ($days_d)",$reson,$ip,$login);
	history($login,"ќтправил в тюрьму ($days_d)",$reson,$ip,$target);
}
?>
