<?
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));	
$timer=(int)$_POST["timer"];
$end_time=time()+$timer*3600;
if($db["admin_level"]>=10)
{
	mysql_query("DELETE FROM ip_block WHERE end_time<".time());
	$q=mysql_query("SELECT * FROM users WHERE login='".$target."'");
	$res=mysql_fetch_array($q);
	if(!$res)
	{
		$msg="Персонаж <B>".$target."</B> не найден в базе данных.";
	}
	else if ($res['adminsite']>=5)
	{
		$msg= "Редактирование богов запрещено высшей силой!";
	}
	else
	{
		$remote_ip=$res["remote_ip"];
		$last_ip=$res["last_ip"];
		$is_ip=mysql_fetch_array(mysql_query("SELECT count(*) FROM ip_block WHERE remote_ip='".$remote_ip."'"));
		if ($is_ip[0])$msg= "Такой IP уже существует!";
		else
		{	
			mysql_Query("INSERT INTO ip_block (end_time,remote_ip,last_ip,user_id) VALUES ('".$end_time."','".$remote_ip."','".$last_ip."','".$res["id"]."')");
		    $msg= "IP-адрес <b>\"".$remote_ip."\"</b> удачно заблокирован!";
			history($target,"Заблокирован IP-адрес","<b>\"".$ip_res."\"</b>",$ip,$login);
			history($login,"Заблокировал IP-адрес","<b>\"".$ip_res."\"</b>",$ip,$target);
		}
	}

	echo "<font color=red>".$msg."&nbsp;</font><br><br>";

	echo "<b>Список заблокированых IP-адресов:</b>";
	echo "<table border=0 class=new width=100% bgcolor=#dcdcdc cellspacing=1><TR bgcolor=#C7C7C7 style='font-weight:bold'>
	<td>IP-адрес</td><td>Локальный</td><td>Заблокирован</td><td>До</td><td>Персонаж</td></tr>";
	$sql=mysql_query("SELECT ip_block.id,ip_block.date,end_time, ip_block.remote_ip, ip_block.last_ip, users.login FROM ip_block LEFT JOIN users on users.id=ip_block.user_id ORDER BY date DESC ");
	if (!mysql_num_rows($sql))echo"<tr><td colspan=5 align=center><i style=color:red>список пуст</i></td></tr>";
	else
	{	
		while($row=mysql_fetch_Array($sql))
		{
			echo "<tr><td>".$row[3]."</td><td>".$row[4]."</td><td>".$row[1]."</td><td>".date('d.m.Y H:i', $row[2])."</td><td>".$row[5]."</td><tr>\n";
		}
	}
	echo "</table>";
}
?>