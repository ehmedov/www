<?
$login=$_SESSION['login'];
$ip=htmlspecialchars(addslashes($_POST['ip']));
if(!empty($ip))
{
	if($db["orden"]==1 && $db["admin_level"]>=5)
	{
		$res=mysql_query("SELECT report.time_stamp,report.action,report.ip,users.login, users.id, users.level, users.dealer , users.orden , users.admin_level , users.clan_short , users.clan  FROM report LEFT JOIN users on users.login=report.login WHERE ip='".$ip."' and type='1' ORDER BY time_stamp DESC");
		echo "<table valign=top width=80%>";
		echo "<tr bgcolor=#C7C7C7><td>ЛОГИН</td><td>Зашел c IP</td><td>Action</td><td>Дата</td></tr>";
		while ($query=mysql_fetch_array($res))
		{
			echo "<tr><td><script>drwfl('".$query['login']."','".$query['id']."','".$query['level']."','".$query['dealer']."','".$query['orden']."','".$query['admin_level']."','".$query['clan_short']."','".$query['clan']."');</script></td> <td>".$query["ip"]."</td><td>".$query["action"]."</td><td>".$query["time_stamp"]."</td></tr>";
		}
		echo "</table>";
	}
}
?>
