<?
	$login=$_SESSION["login"];
	$res=mysql_fetch_array(mysql_query("SELECT count(*) FROM `deztow_turnir` WHERE winner='".$login."'"));
	switch ($res[0])
	{
		case ($res[0]>=30 && $res[0]<50):$reputation="Исследователь";break;
		case ($res[0]>50 && $res[0]<100):$reputation="Посвященный";break;
		case ($res[0]>=100):$reputation="Знаток";break;
		default:$reputation="Без рейтинга";break;
	}
	if ($_GET["zad"]==1)
	{
		if ($db["reputation"]>=5)
		{
			mysql_query("UPDATE users SET money=money+50,reputation=reputation-5 WHERE login='".$login."'");
			$msg="Вы получили 50.00 Зл. за 5 репутации";
			history($login,"Задания",$msg,$db['remote_ip'],"Задания в Башне");
			$db["reputation"]=$db["reputation"]-5;
			$db["money"]=$db["money"]+50;
		}
		else $msg="У Вас нет достаточной репутации!";
	}
	else if ($_GET["zad"]==2)
	{
		if ($db["reputation"]>=100)
		{
			mysql_query("UPDATE users SET naqrada=naqrada+1000, reputation=reputation-100 WHERE login='".$login."'");
			$query=mysql_fetch_array(mysql_query("SELECT count(*) FROM inv WHERE owner='".$login."' and object_razdel='medal' and object_id=31"));
			if ($query[0]==0)
			{
				mysql_query("INSERT INTO inv (owner,object_id,object_type,object_razdel,iznos_max) VALUES ('$login',31,'medal','medal',1);");
				$msg.="Вы получили Медал <b>Рыцарь Башни Смерти [1]</b>. ";
			}
			else
			{
				$query=mysql_fetch_array(mysql_query("SELECT count(*) FROM inv WHERE owner='".$login."' and object_razdel='medal' and object_id=32"));
				if ($query[0]==0)
				{
					mysql_query("INSERT INTO inv (owner,object_id,object_type,object_razdel,iznos_max) VALUES ('$login',32,'medal','medal',1);");
					$msg.="Вы получили Медал <b>Рыцарь Башни Смерти [2]</b>. ";
				}
				else 
				{
					$query=mysql_fetch_array(mysql_query("SELECT count(*) FROM inv WHERE owner='".$login."' and object_razdel='medal' and object_id=33"));
					if ($query[0]==0)
					{
						mysql_query("INSERT INTO inv (owner,object_id,object_type,object_razdel,iznos_max) VALUES ('$login',33,'medal','medal',1);");
						$msg.="Вы получили Медал <b>Рыцарь Башни Смерти [3]</b>. ";
					}
				}
			}
			$msg.="Вы получили 1000.00 Ед. за 100 репутации";
			history($login,"Задания",$msg,$db['remote_ip'],"Задания в Башне");
			$db["reputation"]=$db["reputation"]-100;
			$db["naqrada"]=$db["naqrada"]+1000;
		}
		else $msg="У Вас нет достаточной репутации!";
	}
?>
<TABLE width=100% border=0>
<tr valign=top>
	<td align=right nowrap><INPUT TYPE="button" value="Турнирная арена" style="background-color:#AA0000; color: white;" onclick="location.href='?act=go&level=smert_room';"></td>
	<td width=100%><h3>Задания в Башне</h3></td>
	<td align=right nowrap>
		<input type=button  class=newbut onclick="location.href='main.php?act=none'" value="Обновить">
	</td>
</tr>
</table>
<font color=red><?=$msg;?></font>
<h4>Статистика</h4>
• Побед в Башне Смерти: <B><?=$res[0]?></B><BR>
• Рейтинг в Башне Смерти: <B><?=$reputation?></B><BR>
• Репутация в Башне Смерти: <B><?=$db["reputation"]?></B><BR>
	
<h4>Задания в Башне</h4>
1. <a href="?zad=1">Выиграть поединок в Башне Смерти</a> <i>(5 репутации, 50.00 Зл.)</i><BR>
2. <a href="?zad=2">Выиграть Башню Смерти</a> <i>(100 репутации, 1000.00 Ед.)</i><BR>

<BR><BR>
<h4>Последний 10 Рыцарей Башни Смерти</h4>		
<?
$sql=mysql_Query("SELECT users.login,users.level,users.id,users.orden,users.admin_level,users.clan,users.clan_short,users.dealer FROM `inv` LEFT JOIN users on users.login=inv.owner WHERE `object_id`=31 and `object_type`='medal' ORDER BY inv.date ASC");
while($dat=mysql_fetch_Array($sql))
{
	echo "<script>drwfl('".$dat['login']."','".$dat['id']."','".$dat['level']."','".$dat['dealer']."','".$dat['orden']."','".$dat['admin_level']."','".$dat['clan_short']."','".$dat['clan']."');</script><br>";
}
?>	
</BODY>
</HTML>