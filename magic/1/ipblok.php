<?
	mysql_query("DELETE FROM ip_block WHERE end_time<".time());
	if ($_GET["del_id"])
	{
		mysql_query("DELETE FROM ip_block WHERE id=".(int)$_GET["del_id"]);
	}
	echo "<b>Список заблокированых IP-адресов:</b>";
	echo "<table border=0 class=new width=100% bgcolor=#dcdcdc cellspacing=1><TR bgcolor=#C7C7C7 style='font-weight:bold'>
	<td></td><td>IP-адрес</td><td>Локальный</td><td>Заблокирован</td><td>До</td><td>Персонаж</td></tr>";
	$sql=mysql_query("SELECT ip_block.id,ip_block.date,end_time, ip_block.remote_ip, ip_block.last_ip, users.login FROM ip_block LEFT JOIN users on users.id=ip_block.user_id ORDER BY date DESC ");
	if (!mysql_num_rows($sql))echo"<tr><td colspan=6 align=center><i style=color:red>список пуст</i></td></tr>";
	else
	{
		while($row=mysql_fetch_Array($sql))
		{
			echo "<tr><td><a href='?act=inkviz&spell=ipblok&del_id=".(int)$row[0]."'><img src='img/icon/del.gif'></a></td><td>".$row[3]."</td><td>".$row[4]."</td><td>".$row[1]."</td><td>".date('d.m.Y H:i', $row[2])."</td><td>".$row[5]."</td><tr>\n";
		}
	}
	echo "</table>";
?>