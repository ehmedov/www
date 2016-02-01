<?
include('key.php');
$login=$_SESSION["login"];
?>
<form name='slform' action='main.php?act=clan&do=2&a=give' method='post'>
<table border=0 class=inv >
<tr>
	<td align=left valign=top>
	<b>Укажите логин нового главы клана:</b><br><input type=text name='target' class=new size=30>
	<input type=submit style="height:17px" value=" OK " class=new><BR>
	</td>
</tr>
</table>
</form>
<script>Hint3Name = 'target';</script>
<?
if ($_POST["target"])
{	
	$target=htmlspecialchars(addslashes($_POST["target"]));
	if($db["glava"]==1)
	{
		$q=mysql_query("SELECT * FROM users WHERE login='".$target."'");
		$res=mysql_fetch_array($q);
		if(!$res)
		{
			echo "Персонаж <B>".$target."</B> не найден в базе данных.";
		}
		else if($res["clan_short"]!=$clan_s)
		{
			echo "Персонаж <B>".$target."</B> не состоит в Вашем Ханстве!";
		}
		else
		{
		    mysql_query("UPDATE users SET glava='0', clan_take='0', chin='ЭКС-ГЛАВА' WHERE login='".$login."'");
		    mysql_query("UPDATE users SET chin='ГЛАВА', glava=1, clan_take=1 WHERE login='".$target."'");
		    mysql_query("UPDATE clan SET glava='".$res['login']."' WHERE name_short='".$clan_s."'");
		    history($res['login'],'Стал главой','Ханства '.$clan_t,$res['remote_ip'], "ЭКС-ГЛАВА: ".$login);
			history($login,'Передал главенство','Новый глава Ханства: '.$clan_t.'-'.$res['login'],$db['remote_ip'], "Глава: ".$login);
			echo "Новый глава Ханства: <b>".$res['login']."</b>";
		}
	}
}
?>