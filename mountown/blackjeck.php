<?
$login=$_SESSION["login"];	
if ($db['orden']=="5")
{
	echo "<h3>Вам сюда нельзя!</h3>";
	?>
		<input type=button class=button value=" Выйти " style="height=18;font-size:11 px" onclick="location.href='main.php?act=go&level=remesl'">
	<?
	die();
}	
//настройки для ставок
$pr_1=2;
$pr_2=3;
$pr_3=4;
?>
<h3>Дом отдыха</h3>
<table align=center>
<tr>
  <td>
<form name="game"  action='?act=none' method="POST">
<table border='0' height=281 bgcolor='#eeeeee' cellspacing='1' cellpadding='3'>

<tr>
  <td bgcolor='#ffffff'><b>Совпадение</b></td>
  <td bgcolor='#ffffff'><b>Выигрыш монет</b></td>
</tr>
<tr>
  <td bgcolor='#ffffff'>XXY, YXX</td>
  <td bgcolor='#ffffff'>*2</td>
</tr>
<tr>
  <td bgcolor='#ffffff'>XYX</td>
  <td bgcolor='#ffffff'>*3</td>
</tr>
<tr>
  <td bgcolor='#ffffff'>XXX</td>
  <td bgcolor='#ffffff'>*4</td>
</tr>
<tr>
  <td bgcolor='#ffffff' colspan='2' align="center">
  <?
	$gr_1=rand(0,9);
	$gr_2=rand(0,9);
	$gr_3=rand(0,9);
	echo "<table width=100 border=0>
	<tr>	
	<td align=\"center\" nowrap><img src='img/casino/bar".$gr_1.".gif'></td>
	<td align=\"center\" nowrap><img src='img/casino/bar".$gr_2.".gif'></td>
	<td align=\"center\" nowrap><img src='img/casino/bar".$gr_3.".gif'></td>
	</tr>
	</table>";
	

if($_POST['game']=="1" && $_SESSION["sc"]==$_POST['ses'] && $_POST['gm']>=1 && is_numeric($_POST['gm']) && $_POST['gm']<=$db["money"])
{
	if ($gr_1==$gr_2 && $gr_2==$gr_3)
	{
		$prize=$_POST['gm']*$pr_3;
		$prize=$prize-$_POST['gm'];
		mysql_query("UPDATE users SET money=money+'$prize' WHERE login='".$login."'");
		$db["money"]=$db["money"]+$prize;
		echo "<b style='color:green'>Вы выиграли $prize зл.</b>";
		history($login,"ВЫИГРАЛ",$prize,$ip,"Дом отдыха");
	}
	elseif ($gr_1==$gr_3)
	{
		$prize=$_POST['gm']*$pr_2;
		$prize=$prize-$_POST['gm'];
		mysql_query("UPDATE users SET money=money+'$prize' WHERE login='".$login."'");
		$db["money"]=$db["money"]+$prize;		
		echo "<b style='color:green'>Вы выиграли $prize зл.</b>";
		history($login,'ВЫИГРАЛ',$prize,$ip,"Дом отдыха");
	}
	elseif ($gr_1==$gr_2 || $gr_2==$gr_3) 
	{
		$prize=$_POST['gm']*$pr_1;
		$prize=$prize-$_POST['gm'];
		mysql_query("UPDATE users SET money=money+'$prize' WHERE login='".$login."'");
		$db["money"]=$db["money"]+$prize;
		echo "<b style='color:green'>Вы выиграли $prize зл.</b>";
		history($login,'ВЫИГРАЛ',$prize,$ip,"Дом отдыха");
		
	}
	else
	{
		$win=0;
		mysql_query("UPDATE users SET money=money-".$_POST['gm']." WHERE login='".$login."'");
		$db["money"]=$db["money"]-$_POST['gm'];
		echo "<b style='color:red'>Вы проиграли ".$_POST['gm']." зл.</b>";
		history($login,'ПРОИГРАЛ',$_POST['gm'],$ip,"Дом отдыха");		
	}
}
elseif(isset($_POST['gm']) && !is_numeric($_POST['gm'])){echo "<b style='color:red'>Неправильно введена ставка!!!</b>";}
elseif($_POST['gm']<1 && $_POST['game']=="1" && $_SESSION["sc"]==$_POST['ses']){echo "<b style='color:red'>Минимальная ставка 1 зл.</b>";}
elseif($_POST['gm']>$db["money"] && $_SESSION["sc"]==$_POST['ses']){echo "<b style='color:red'>У вас нет столько золота</b>";}
else{?>&nbsp;<?}
$b = rand(0,9);
$c = rand(0,9);
$d = rand(0,9);
$e = rand(0,9);
$f = rand(0,9);
$g = rand(0,9);
$sescode="$b$c$d$e$f$g";
$_SESSION["sc"]=$sescode;
  ?>
  </td>
</tr>

<tr>
  <td bgcolor='#ffffff'>Ваши деньги</td>
  <td bgcolor='#ffffff'> <?=sprintf ("%01.2f", $db["money"]);?> Зл.</td>
</tr>
<tr>
  <td bgcolor='#ffffff'>Ставка</td>
  <td bgcolor='#ffffff'>
    <select name="gm" class="inup" style="width=150;">
        <option value=0>0 зл.
        <option value=1>1 зл.
        <option value=3>3 зл.
        <option value=5>5 зл.
		<option value=10>10 зл.
	</select></td>
</tr>
<tr>
<td colspan="2" align="center">
<input type=button class=button value=" Выйти " style="height=18;font-size:11 px" onclick="location.href='main.php?act=go&level=remesl'">
<input type="hidden" name="game" value="1">
<input type="hidden" name="ses" value="<?echo $sescode;?>">
<input type="submit" class=button name="" value="Сыграть" style="height=18;font-size:11 px"/>
</td></tr></table></form>


</td></tr></table>