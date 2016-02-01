<?
$target=htmlspecialchars(addslashes($_POST['target']));
$medal=htmlspecialchars(addslashes($_POST['medal']));
$ip=$db["remote_ip"];
if($db["orden"]==1 && $db["admin_level"]>=10 && $target!="" && $medal!="")
{
	$q=mysql_query("select login from users where login='".$target."' limit 1");
	$res=mysql_fetch_array($q);
	if(!$res)
	{
		echo  "Персонаж <B>$target</B> не найден в базе данных.";
	}
	else
	{
		mysql_query("DELETE FROM inv WHERE owner='".$target."' and object_id='".$medal."' and object_type='medal'");
		echo "Забран орден у персонажа <b>".$target."</b>";
		history($login,"Забрал орден у персонажа",$reson,$ip,$target);
	}
}
?>