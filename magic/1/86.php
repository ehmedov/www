<?include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
$timer=htmlspecialchars(addslashes($_POST['timer']));

if(!empty($target))
{
	$q=mysql_query("select * from users where login='".$target."'");
	$res=mysql_fetch_array($q);
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
	if ($db["adminsite"]!=5)
	{	
		if($res['adminsite']>=5 ||$res["admin_level"]>=9)
		{
			echo "Персонаж <B>".$target."</B> не найден в базе данных.";
			die();
		}
	}
	$time2=time()+$timer*3600;
	mysql_query("UPDATE users SET obezlik='".$time2."' WHERE login='".$target."'");
	if($timer==24){$days_d="сутки";}
	if($timer==72){$days_d="3 дня";}
	if($timer==168){$days_d="неделю";}
	if($timer==360){$days_d="15 суток";}
	if($timer==744){$days_d="месяц";}
	if($timer==1440){$days_d="2 месяца";}
	if($timer==2160){$days_d="3 месяца";}
	if($timer==4320){$days_d="6 месяца";}
	if($timer==8640){$days_d="12 месяца";}
	
	$pref=$db["sex"];
	if($pref=="female")
	{
		$prefix="а";
	}
	else
	{
		$prefix="";
	}
    if($obezlik==""){$obezlik_cl=" Открыл$prefix инфу персонажа ";}
    else if($obezlik==1){$obezlik_cl=" Закрыл $prefix инфу персонажа ";}
    if($db["adminsite"])$logins="Высшая сила";	else $logins=$login;
	say("toall","Представитель порядка <b>&laquo;".$logins."&raquo;</b> Закрыл$prefix инфу персонажа <b>&laquo;".$target."&raquo</b> на ".$days_d."",$login);
	history($target,"Закрыли инфу ($days_d)",$reson,$res["remote_ip"],$logins);
	history($login,"Закрыл инфу ($days_d)",$reson,$db["remote_ip"],$target);
	echo "Персонаж <b>".$target."</b> успешно обновлен.";
}
?>