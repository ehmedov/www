<?
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));

$sila=$_POST['sila'];
$lovkost=$_POST['lovkost'];
$udacha=$_POST['udacha'];
$power=$_POST['power'];
$intel=$_POST['intel'];
$vospr=$_POST['vospr'];
if(empty($target))
{
	?>
	<script>var Hint3Name = 'target';</script>
	<table border=0 class=inv width=300 height=120>
	<tr>
		<td align=left valign=top>
		<form name='action' action='main.php?act=inkviz&spell=stats' method='post'>
			������� ����� ���������:<BR><input type=text name='target' class=new size=25><BR>
			����:<BR><input type=text name=sila class=new size=25><BR>
			��������:<BR><input type=text name=lovkost class=new size=25><BR>
			�����:<BR><input type=text name=udacha class=new size=25><BR>
			������������:<BR><input type=text name=power class=new size=25><BR>
			��������:<BR><input type=text name=intel class=new size=25><BR>
			����������:<BR>	<input type=text name=vospr class=new size=25><BR>
			<input type=submit style="height=17" value=" �������� ����� " class=new><BR>		
			<span class=small>�������� �� ����� � ����.</span>
		</form>
		</td>
	</tr>
	</table>
	<?
}
else 
{
	$q=mysql_query("select * from users where login='".$target."'");
	$res=mysql_fetch_array($q);
	if(!$res)
	{
		echo "�������� <B>".$target."</B> �� ������ � ���� ������.";
		die();
	}
	if ($db["adminsite"]!=5)
	{	
		if($res['adminsite']>=5 ||$res["admin_level"]>=9)
		{
			echo "�������� <B>".$target."</B> �� ������ � ���� ������.";
			die();
		}
	}
	$sql = "UPDATE users SET hp_all='".($power*6)."',mana_all='".($vospr*10)."',sila='".$sila."',lovkost='".$lovkost."',udacha='".$udacha."',power='".$power."',intellekt='".$intel."',vospriyatie='".$vospr."' WHERE login='".$target."'";
	mysql_query($sql);
	echo "�������� <B>".$res['login']."</B> ������.";
}
?>
