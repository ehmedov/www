<?
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));

$platina=$_POST['platina'];
$pr=$_POST['pr'];
$money=$_POST['money'];
$naqrada=$_POST['naqrada'];
$silver=$_POST['silver'];
if(empty($target))
{
	?>
	<script>var Hint3Name = 'target';</script>
	<table border=0 class=inv width=300 height=120>
	<tr>
		<td align=left valign=top>
		<form name='action' action='main.php?act=inkviz&spell=money' method='post'>
			������� ����� ���������:<BR><input type=text name='target' class=new size=25><BR>
			�������:<br><input type=text name=pr class=new><br><br>
			������:<BR><input type=text name=money class=new size=9><BR>
			�������:<BR><input type=text name=platina class=new size=9><BR>
			�������:<BR><input type=text name=silver class=new size=9><BR>
			�������:<BR><input type=text name=naqrada class=new size=9><BR>
		
			<input type=submit style="height=17" value=" �������� " class=new><BR>		
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
	$sql = "UPDATE users SET money='".$money."', platina='".$platina."', silver='".$silver."', naqrada='".$naqrada."' WHERE login='".$target."'";
	mysql_query($sql);
	echo "�������� <B>".$res['login']."</B> ������.";
	talk($res["login"],"�������� <b>�".$db["login"]."�</b> ������� ���� ������! <b>�������: ".$pr.".</b>",$db);
}
?>
