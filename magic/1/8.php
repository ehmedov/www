<?
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
$reason=htmlspecialchars(addslashes($_POST['reason']));
$reason=$reason." [".date("d.m.Y-H:i:s")."]";
$reason=str_replace("\n","<br>",$reason);
$reason = str_replace("&amp;","&",$reason);
if(!empty($target))
{
	$res=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE login='".$target."'"));
	if(!$res)
	{
		echo "Персонаж <B>".$target."</B> не найден в базе данных.";
		die();
	}
	if ($db["adminsite"]!=5)
	{	
		if($res['adminsite']>=5 ||$res["admin_level"]>9)
		{
			echo "Редактирование богов запрещено высшей силой!";
			die();
		}
	}
	mysql_query("UPDATE users SET orden=0, admin_level=0, adminsite=0, otdel='' WHERE login='".$target."'");
	mysql_query("UPDATE info SET parent_temp='', orden_reason='$reason' WHERE id_pers=".$res["id"]);
	echo "Персонаж <B>".$target."</B> изгнан из ордена.";
}
?>
