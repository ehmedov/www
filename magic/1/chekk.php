<? include("key.php");
$login=$_SESSION['login'];
$target=$_POST['target'];
$chek=$_POST['chek'];

if(empty($chek))
{
	?>
	<body>
	<div align=right>
	<table border=0 class=inv width=300 height=120>
	<tr><td align=left valign=top>
	<form name='action' action='main.php?act=inkviz&spell=chekk' method='post'>

	<select class=button name=chek>
	<option value=162>Чек на 1 час
	<option value=163>Чек на 3 час
	<option value=164>Чек на 6 час
	<option value=165>Чек на 12 час
	<option value=166>Чек на 24 час
	<option value=167>Чек на 7 дн
	<option value=168>Чек на 15 дн
	<option value=169>Чек на 30 дн

	</select>

	<input type=submit style="height=17" value=" OK " class=button><BR>
	<span class=small>Щелкните на логин в чате.</span>
	</form>
	</td></tr>
	</table>
	<?
}
else if($db["orden"]==1 && $db["adminsite"]>=5)
{
$S="select `login` from users";
	$q=@mysql_query($S);
	while($res=mysql_fetch_array($q)){
	$sql = "INSERT INTO inv (owner,object_type,object_id) VALUES ('".$res['login']."','wood','".$_POST["chek"]."');";
	$result = @mysql_query($sql);
}
	print "Персонажам дан чек.";

}
?>