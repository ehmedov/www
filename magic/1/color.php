<?
$target=htmlspecialchars(addslashes($_POST['target']));
if(!empty($target))
{
	$sql="update `users` set color='black' where login='".$target."'";
	$query=mysql_query($sql);
	if($query)
	{
		print "��� ��������� :)";
	}
	else
	{
		echo mysql_error();
	}
}
else
{
	?>
	<body onLoad='top.cf.action=1;' onUnload='top.cf.action=0;'>
	<div align=right>
	<table border=0 class=inv width=300 height=120>
	<tr><td align=left valign=top>
	<form name='action' action='main.php?act=inkviz&spell=color' method='post'>
	<table border=0 width=500>
	<tr>
	<td>
	�����:
	</td>
	<td>
	<input type=text name="target" class=new size=30> <br>
	<span> ������� ����� ���������,��� ���������� ���� </span>
	</td>
	</tr> <tr><td>
	<input type=submit value="���������" class=new>
	</td></tr>
	</table>
	</form>
	<?
}
?>
