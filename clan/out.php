<?include('key.php');
$login=$_SESSION["login"];
$target=htmlspecialchars(addslashes($_POST['target']));
if(empty($target))
{
	?>
		<body onLoad='top.cf.action=1;' onUnload='top.cf.action=0;'>
		<table border=0 class=inv width=500 height=120>
		<tr valign=top><td align=left>
		<form name='action' action='main.php?act=clan&do=2&a=out' method='post'>
			<b>������� ���:</b><BR>
			<input type=text name='target' class=new size=30>
			<input type=submit style="height=17" value=" OK " class=new><BR>
			<span class=small>�������� �� ����� � ����.</span>
		</form>
		</td></tr>
		</table>
	<?
}
else if($db["glava"]==1)
{
	$S="select * from users where login='".$target."' limit 1";
	$q=mysql_query($S);
	$res=mysql_fetch_array($q);
	if(!$res)
	{
		echo "�������� <B>$target</B> �� ������ � ���� ������.";
	}
	else if($res["clan_short"]!=$clan_s)
	{
		echo "�������� <B>$target</B> �� ������� � ����� �����";
	}
	else
	{
		mysql_query("UPDATE users SET clan='',clan_short='',chin='',orden='',clan_take='0',glava=0 WHERE login='".$res['login']."'");
		echo "�������� <B>".$res['login']."</B> ������ �� �������.";
		history($res['login'],'������ �� �������.',"������� ".$clan_t,$res['remote_ip'],"�����: ".$login);
		history($login,'������ �� �������','�������� '.$res['login'].' ������ �� ������� '.$clan_t,$db['remote_ip'], "�����: ".$login);
	}
}
?>