<?
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));

$win=$_POST['win'];
$lose=$_POST['lose'];
$nich=$_POST['nich'];
$monstr=$_POST['monstr'];
$reputation=$_POST['reputation'];
$doblest=$_POST['doblest'];
if(empty($target))
{
	?>
	<script>var Hint3Name = 'target';</script>
	<table border=0 class=inv width=300 height=120>
	<tr>
		<td align=left valign=top>
		<form name='action' action='main.php?act=inkviz&spell=pabed' method='post'>
			������� ����� ���������:<BR><input type=text name='target' class=new size=25><BR>
			�����:<BR><input type=text name=win class=new size=25><BR>
			���������:<BR><input type=text name=lose class=new size=25><BR>
			������:<BR><input type=text name=nich class=new size=25><BR>
			����� ��� ��������:<BR><input type=text name=monstr class=new size=25><BR>
			���������:<BR><input type=text name=reputation class=new size=25><BR>
			��������:<BR>	<input type=text name=doblest class=new size=25><BR>
			<input type=submit style="height=17" value="�������� ����������" class=new><BR>		
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
	$sql = "UPDATE users SET win='".$win."',lose='".$lose."',nich='".$nich."',monstr='".$monstr."',reputation='".$reputation."',doblest='".$doblest."' WHERE login='".$target."'";
	mysql_query($sql);
	echo "�������� <B>".$res['login']."</B> ������.";
}
?>
