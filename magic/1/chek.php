<? include("key.php");
$login=$_SESSION['login'];
$target=$_POST['target'];
$sklon=$_POST['sklon'];

if(empty($target))
{
	?>
	<body>
	<div align=right>
	<table border=0 class=inv width=300 height=120>
	<tr><td align=left valign=top>
	<form name='action' action='main.php?act=inkviz&spell=chek' method='post'>
	������� ����� ��������� � ����������:<BR>
	<input type=text name='target' class=button size=15>

	<select class=button name=chek>
	<option value=162>��� �� 1 ���
	<option value=163>��� �� 3 ���
	<option value=164>��� �� 6 ���
	<option value=165>��� �� 12 ���
	<option value=166>��� �� 24 ���
	<option value=167>��� �� 7 ��
	<option value=168>��� �� 15 ��
	<option value=169>��� �� 30 ��

	</select>

	<input type=submit style="height=17" value=" OK " class=button><BR>
	<span class=small>�������� �� ����� � ����.</span>
	</form>
	</td></tr>
	</table>
	<?
}
else if($db["orden"]==1 && $db["adminsite"]>=5)
{
	$S="select * from users where login='".$target."'";
	$q=mysql_query($S);
	$res=@mysql_fetch_array($q);
	if(!$res)
	{
		print "�������� <B>".$target."</B> �� ������ � ���� ������.";
		die();
	}
	if ($db["adminsite"]!=5)
	{	
		if($res['adminsite']>=5)
		{
			print "�������� <B>".$target."</B> �� ������ � ���� ������.";
			die();
		}
	}
	$sql = "INSERT INTO inv (owner,object_type,object_id) VALUES ('".$target."','wood','".$_POST["chek"]."');";
	$result = mysql_query($sql);
	print "��������� <B>".$target."</B> ��� ���.";

}
?>