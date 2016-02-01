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
			Укажите логин персонажа:<BR><input type=text name='target' class=new size=25><BR>
			Побед:<BR><input type=text name=win class=new size=25><BR>
			Поражений:<BR><input type=text name=lose class=new size=25><BR>
			Ничьих:<BR><input type=text name=nich class=new size=25><BR>
			Побед над монстрам:<BR><input type=text name=monstr class=new size=25><BR>
			Репутация:<BR><input type=text name=reputation class=new size=25><BR>
			Доблесть:<BR>	<input type=text name=doblest class=new size=25><BR>
			<input type=submit style="height=17" value="Обновить Статистика" class=new><BR>		
			<span class=small>Щелкните на логин в чате.</span>
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
		echo "Персонаж <B>".$target."</B> не найден в базе данных.";
		die();
	}
	if ($db["adminsite"]!=5)
	{	
		if($res['adminsite']>=5 ||$res["admin_level"]>=9)
		{
			echo "Персонаж <B>".$target."</B> не найден в базе данных.";
			die();
		}
	}
	$sql = "UPDATE users SET win='".$win."',lose='".$lose."',nich='".$nich."',monstr='".$monstr."',reputation='".$reputation."',doblest='".$doblest."' WHERE login='".$target."'";
	mysql_query($sql);
	echo "Персонаж <B>".$res['login']."</B> обнулён.";
}
?>
