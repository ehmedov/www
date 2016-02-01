<?
$login=$_SESSION['login'];
$my_sex=$db["sex"];
$id=intval($_GET["id"]);
$ip=$db["remote_ip"];

if ($_GET["action"]=="get_obraz" && $id>=0)
{
	$sql=mysql_query("SELECT * FROM obraz WHERE id=$id");
	$result=mysql_fetch_array($sql);
	if (!$result)
	{
		$msg="Образ не найден...";
	}
	else if ($result["sex"]!=$my_sex)
	{
		$msg="Не ваш пол...";
	}
	else if ($result["owner"]!="")
	{
		$msg="Образ не найден...";
	}
	else if ($result["price"]>$db["platina"])
	{
		$msg="Недостаточно денег.";
	}
	else
	{
		mysql_query("UPDATE users SET obraz='".$result["img"]."',platina=platina-".$result["price"]." WHERE login='".$login."'");
		mysql_query("UPDATE obraz SET owner='".$login."' WHERE id=$id");
		$db["platina"]=$db["platina"]-$result["price"];
		$msg="Образ сохранен...";
		history($login,'Купил Образ','Образ сохранен за '.sprintf ("%01.2f", $result["price"]).' Пл.',$ip,'Мастерская Образов');
	}
}
$platina = sprintf ("%01.2f", $db["platina"]);
$money = sprintf ("%01.2f", $db["money"]);
?>
<h3>Мастерская Образов<br><small>Образ может быть выбран из списка или предоставлен самим заказчиком.(курс может меняться)</small></h3>
<TABLE width=100% border=0 CELLSPACING=0 CELLPADDING=3 >
<tr valign=top bgcolor=#d2d2d2>
	<td width=100%>
		У вас в наличии: <B><?echo $money;?></B> Зл. <B><?echo $platina;?></B> Пл.
	</td>
	<td align=right nowrap>
		<input type=button onclick="location.href='main.php?act=go&level=remesl'" value="Вернуться" class=new >
		<input type=button onclick="location.href='?action=all';" value="Владельцы VIP образов" style="background-color:#AA0000; color: white;" >
		<input type=button onclick="location.href='main.php?act=none'" value="Обновить" class=new >
	</td>
</tr>
</table>
<font color=red><?=$msg?></font>
<?
//if (!$db["adminsite"])	die("remont");
if ($_GET["action"]=="all")
{	
	$sex="male";
	if ($_GET["sex"]=="female")$sex="female";
	$n=(!$n);
	$i=1;
	echo "<center><a href='?action=all&sex=male'>Мужские</a>&nbsp;&nbsp;&nbsp;<a href='?action=all&sex=female'>Женские</a></center>";
	echo "<table align=center><tr>";
	$sql=mysql_query("SELECT users.login, users.id, users.level, users.dealer, users.orden, users.admin_level, users.clan_short, users.clan, obraz.img, obraz.id as id_obraz, obraz.owner FROM obraz LEFT JOIN users on users.login=obraz.owner WHERE obraz.owner!='' and obraz.sex='".$sex."' ORDER BY obraz.owner ASC");
	while($res=mysql_fetch_array($sql))
	{	
		//if ($res['login']=="")mysql_Query("UPDATE obraz SET owner='', price=150 WHERE id=".$res["id_obraz"]);
		echo "<td nowrap align=center><script>drwfl('".$res['login']."','".$res['id']."','".$res['level']."','".$res['dealer']."','".$res['orden']."','".$res['admin_level']."','".$res['clan_short']."','".$res['clan']."');</script><br><img src='img/obraz/".$res["img"]."' title='".$res["id_obraz"]."-".$res["owner"]."' height=220 width=140></td>";
		if(($i % 5) == 0) echo "</tr><tr>";
		$i++;
	}
	echo "</tr></table>";
}
else
{	
	$i=1;
	echo "<table align=center><tr>";
		$sql=mysql_query("SELECT * FROM obraz WHERE owner='' ORDER BY sex DESC, price ASC, id ASC");
		while($res=mysql_fetch_array($sql))
		{	
			echo "<td width=145 nowrap align=center>Цена: <b>".($res["price"]>$db["platina"]?"<font color=red>":"").sprintf ("%01.2f", $res["price"])." Пл.</font></b><A href=\"?action=get_obraz&id=".$res["id"]."\" onclick=\"return confirm('Вы уверены, что хотите заплатить ".sprintf ("%01.2f", $res["price"])." Пл.?')\"><img src='img/obraz/".$res["img"]."'></a></td>";
			if(($i % 6) == 0) echo "</tr><tr>";
			$i++;
		}
	echo "</tr></table>";
}
?>