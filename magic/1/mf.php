<?include("key.php");
$login=$_SESSION['login'];
$target=$_POST['target'];
$krit=$_POST['krit'];
$akrit=$_POST['akrit'];
$uvorot=$_POST['uvorot'];
$auvorot=$_POST['auvorot'];

if(empty($target)){
?>
<body onLoad='top.cf.action=1;' onUnload='top.cf.action=0;'>
<div align=right>
<table border=0 class=inv width=300 height=120>
<tr><td align=left valign=top>
<form name='action' action='main.php?act=inkviz&spell=mf' method='post'>
������� ����� ���������:<BR>
<input type=text name='target' class=new size=25><BR>

�� �����:<BR>
<input type=text name=krit class=new size=25 value="0"><BR>

�� ���������:<BR>
<input type=text name=akrit class=new size=25 value="0"><BR>

�� �������:<BR>
<input type=text name=uvorot class=new size=25 value="0"><BR>

�� �����������:<BR>
<input type=text name=auvorot class=new size=25 value="0"><BR>

<input type=submit style="height=17" value=" �������� ����� " class=new><BR>
<span class=small>�������� �� ����� � ����.</span>
</form>
</td></tr>
</table>
<?
}
else 
{
	$S="select * from users where login='".$target."'";
	$q=mysql_query($S);
	$res=mysql_fetch_array($q);
	if(!$res)
	{
		print "�������� <B>".$target."</B> �� ������ � ���� ������.";
		die();
	}
	if ($res['login']=="���������")
	{
			print "�������������� ����� ��������� ������ �����!";
			die();
	}
	if ($db["adminsite"]!=5)
	{	
		if($res['adminsite']>=5 ||$res["admin_level"]>=9)
		{
			print "�������� <B>".$target."</B> �� ������ � ���� ������.";
			die();
		}
	}
	$sql = "UPDATE users SET krit='$krit',akrit='$akrit',uvorot='$uvorot',auvorot='$auvorot' WHERE login='$target'";
	$result = mysql_query($sql);
	print "�������� <B>$target</B> ������.";
}
?>
