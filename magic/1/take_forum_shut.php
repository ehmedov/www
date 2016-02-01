<?include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
if(!empty($target))
{	
	if($db["orden"]==1 && $db["admin_level"]>=3)
	{
		$q=mysql_query("select * from users where login='".$target."'");
		$res=mysql_fetch_array($q);
		if(!$res)
		{
			echo "ѕерсонаж <B>".$target."</B> не найден в базе данных.";
		}
		else 
		{	
			mysql_query("UPDATE users SET forum_shut='0' WHERE login='".$target."'");
			say("toall","ѕредставитель пор€дка <b>&laquo;".$login."&raquo;</b> сн€л форумную молчанку с персонажа <b>&laquo;".$target."&raquo;</b>.",$login);
			history($target,"сн€ли закл€тие молчани€",$reson,$ip,$login);
			history($login,"сн€л закл€тие молчани€",$reson,$ip,$target);
			echo "«акл€тие молчани€ сн€то.";
		}
	}
}
?>
