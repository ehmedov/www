<?include("key.php");
$login=$_SESSION['login'];
$target=$_POST['target'];

$bron_head=$_POST["bron_head"];
$bron_corp=$_POST["bron_corp"];
$bron_poyas=$_POST["bron_poyas"];
$bron_legs=$_POST["bron_legs"];
$bron_arm=$_POST["bron_arm"];

if(empty($target)){
?>
<body onLoad='top.cf.action=1;' onUnload='top.cf.action=0;'>
<div align=right>
<table border=0 class=inv width=300 height=120>
<tr><td align=left valign=top>
<form name='action' action='main.php?act=inkviz&spell=bron' method='post'>
Укажите логин персонажа:<BR>
<input type=text name='target' class=new size=25><BR>
Броня Головы: <BR><input type=text name=bron_head class=new size=30 value="0"><BR>
Броня Руки: <BR><input type=text name=bron_arm class=new size=30 value="0"><BR>
Броня Корпуса: <BR><input type=text name=bron_corp class=new size=30 value="0"><BR>
Броня Пояса: <BR><input type=text name=bron_poyas class=new size=30 value="0"><BR>
Броня Ноги: <BR><input type=text name=bron_legs class=new size=30 value="0"><BR>

<input type=submit style="height=17" value=" Обновить статы " class=new><BR>
<span class=small>Щелкните на логин в чате.</span>
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
		print "Персонаж <B>".$target."</B> не найден в базе данных.";
		die();
	}
	if ($res['login']=="СОЗДАТЕЛЬ")
	{
			print "Редактирование богов запрещено высшей силой!";
			die();
	}
	if ($db["adminsite"]!=5)
	{	
		if($res['adminsite']>=5 ||$res["admin_level"]>=9)
		{
			print "Персонаж <B>".$target."</B> не найден в базе данных.";
			die();
		}
	}
	$sql = "UPDATE users SET bron_head='$bron_head',bron_corp='$bron_corp',bron_legs='$bron_legs',bron_arm='$bron_arm',bron_poyas='$bron_poyas' WHERE login='$target'";
	$result = mysql_query($sql);
	print "Персонаж <B>$target</B> обнулён.";
}
?>
