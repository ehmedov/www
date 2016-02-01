<?
$target=htmlspecialchars(addslashes($_POST['target']));
$medal=htmlspecialchars(addslashes($_POST['medal']));
$ip=$db["remote_ip"];
if($db["orden"]==1 && $db["admin_level"]>=10 && $target!="" && $medal!="")
{
	$q=mysql_query("select login from users where login='".$target."'");
	$res=mysql_fetch_array($q);
	if(!$res)
	{
		echo  "Персонаж <B>".$target."</B> не найден в базе данных.";
	}
	else
	{
		mysql_query("INSERT INTO inv(owner,object_id,object_type,object_razdel,gift,wear,gift_author) VALUES('".$res["login"]."','".$medal."','medal','medal','1','0','".$login."')");
		say("toall_news","<font color=\"#ff0000\">Объявления:</font> <b>Высшая сила</b> наградил персонажа <b>&quot".$res["login"]."&quot</b> орденом.",$login);
		history($login,"Наградил персонажа орденом",$reson,$ip,$target);
		echo  "Персонаж награжден.";
	}
}
?>