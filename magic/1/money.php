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
			Укажите логин персонажа:<BR><input type=text name='target' class=new size=25><BR>
			Причина:<br><input type=text name=pr class=new><br><br>
			Золото:<BR><input type=text name=money class=new size=9><BR>
			Платина:<BR><input type=text name=platina class=new size=9><BR>
			Серебро:<BR><input type=text name=silver class=new size=9><BR>
			Награда:<BR><input type=text name=naqrada class=new size=9><BR>
		
			<input type=submit style="height=17" value=" Обнулить " class=new><BR>		
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
	$sql = "UPDATE users SET money='".$money."', platina='".$platina."', silver='".$silver."', naqrada='".$naqrada."' WHERE login='".$target."'";
	mysql_query($sql);
	echo "Персонаж <B>".$res['login']."</B> обнулён.";
	talk($res["login"],"Персонаж <b>«".$db["login"]."»</b> Обнулил ваши деньги! <b>Причина: ".$pr.".</b>",$db);
}
?>
