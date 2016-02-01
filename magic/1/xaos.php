<?
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
$reason=htmlspecialchars(addslashes($_POST['reason']));
$reason=str_replace("\n","<br>",$reason);
$reason = str_replace("&amp;","&",$reason);
$timer=htmlspecialchars(addslashes($_POST['timer']));
if(!empty($target))
{
	$q=mysql_query("SELECT * FROM users WHERE login='".$target."'");
	$res=mysql_fetch_array($q);
	if(!$res)
	{
		echo "ѕерсонаж <B>".$target."</B> не найден в базе данных.";
		die();
	}
	if ($db["adminsite"]!=5)
	{	
		if($res['adminsite']>=5 ||$res["admin_level"]>=9)
		{
			echo "–едактирование богов запрещено высшей силой!";
			die();
		}
	}
	$vaxt=date("d.m.Y H:i:s");
	$time2=time()+$timer*3600;
	if($db["adminsite"])$logins="¬ысша€ сила";
	else $logins=$login;
	mysql_query("UPDATE users SET orden='5',otdel='',admin_level='',adminsite='',clan='',clan_short='',clan_take='',prision='".$time2."',prision_reason='".$reason." (".$vaxt.", ".$logins.")', metka=0 WHERE login='".$target."'");
	mysql_query("UPDATE info SET parent_temp='' WHERE id_pers=".$res["id"]);
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
	if($timer==17280){$days_d="2 года";}
	
	talk("toall","ѕредставитель пор€дка <b>&laquo".$logins."&raquo;</b> отправил".$prefix." в тюрьму персонажа <b>&laquo;".$target."&raquo;</b> на ".$days_d.".","");
	echo "ѕерсонаж <b>".$target."</b> отправлен в тюрьму.";
	history($target,"ќтправлен в тюрьму (".$days_d.")",$reason,$res["remote_ip"],$logins);
	history($login,"ќтправил в тюрьму (".$days_d.")",$reason,$db["remote_ip"],$target);
}
?>
