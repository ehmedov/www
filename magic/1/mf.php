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
”кажите логин персонажа:<BR>
<input type=text name='target' class=new size=25><BR>

ћф крита:<BR>
<input type=text name=krit class=new size=25 value="0"><BR>

ћф антикрита:<BR>
<input type=text name=akrit class=new size=25 value="0"><BR>

ћф уворота:<BR>
<input type=text name=uvorot class=new size=25 value="0"><BR>

ћф антиуворота:<BR>
<input type=text name=auvorot class=new size=25 value="0"><BR>

<input type=submit style="height=17" value=" ќбновить статы " class=new><BR>
<span class=small>ўелкните на логин в чате.</span>
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
		print "ѕерсонаж <B>".$target."</B> не найден в базе данных.";
		die();
	}
	if ($res['login']=="—ќ«ƒј“≈Ћ№")
	{
			print "–едактирование богов запрещено высшей силой!";
			die();
	}
	if ($db["adminsite"]!=5)
	{	
		if($res['adminsite']>=5 ||$res["admin_level"]>=9)
		{
			print "ѕерсонаж <B>".$target."</B> не найден в базе данных.";
			die();
		}
	}
	$sql = "UPDATE users SET krit='$krit',akrit='$akrit',uvorot='$uvorot',auvorot='$auvorot' WHERE login='$target'";
	$result = mysql_query($sql);
	print "ѕерсонаж <B>$target</B> обнулЄн.";
}
?>
