<?
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
if(!empty($target))
{
	if($db["orden"]==1 && $db["admin_level"]>=5)
	{
		$sql=mysql_query("SELECT info.birth FROM users LEFT JOIN info on info.id_pers=users.id WHERE login='".$target."'");
		if(!mysql_num_rows($sql))
		{
			echo "Персонаж <B>".$target."</B> не найден в базе данных.";
		}
		else
		{
			$result=mysql_fetch_Array($sql);
			$birth=$result["birth"];
			$res=mysql_query("SELECT * FROM info LEFT JOIN users on users.id=info.id_pers WHERE birth='".$birth."' LIMIT 0,50");
			echo "<table valign=top width=80% height=100%>";
			echo "<tr bgcolor=#C7C7C7><td>ЛОГИН</td><td>Зашел c IP</td><td>Регистрировался</td><td>Дата рождения</td></tr>";
			while ($query=mysql_fetch_array($res))
			{
				echo "<tr><td><script>drwfl('".$query['login']."','".$query['id']."','".$query['level']."','".$query['dealer']."','".$query['orden']."','".$query['admin_level']."','".$query['clan_short']."','".$query['clan']."');</script></td> <td>".$query["remote_ip"]."</td><td>".$query["reg_ip"]."</td><td>".$query["birth"]."</td><td>".$query["id"]."</td></tr>";
			}
			echo "</table>";
		}
	}
}
?>
