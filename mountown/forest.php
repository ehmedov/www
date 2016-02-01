<?
$login = $_SESSION['login'];
?>
<body style="background-image: url(img/index/forest.jpg);background-repeat:no-repeat;background-position:top right">
<h3>Тропинка в тёмный лес</h3>
<div align=right>
<input type="button" class="newbut" onclick="window.location='main.php?act=go&level=remesl'" value="Выход на площадь">
<input type="button" class="newbut" onclick="window.location='main.php?act=none'" value="Обновить">
</div>
<?
$max_level=11;	
if($_GET['action']=="nachat")
{
	if ($db["vaulttime"]<time())
	{
		if ($db['level']>=7 && $db['level']<=$max_level)
		{
			mysql_query("UPDATE users SET walktime='".(time()+3600)."' WHERE login='".$login."'");
			Header("Location: main.php?act=go&level=mount");
			die();
		}
		else echo "<b style='color:#ff0000'>Войти в ЛЕС Вы сможете только с 7 уровня до $max_level уровня</b>";
	}
}
?>
<table width=100%>
<tr>
<td valign='top'>
<?
if ($db['level']>=7 && $db['level']<=$max_level)
{	
	if (($db["vaulttime"]-time())>0)
	{
		$time=$db["vaulttime"]-time();
		$h=floor($time/3600);
		$m=floor(($time-$h*3600)/60);
		$sec=$time-$h*3600-$m*60;
		if($h<=0){$hour="";}else $hour="$h ч.";
		if($m<0){$minut="";}else $minut="$m мин.";
		if($sec<0){$sec=0;}
		$left="$hour $minut $sec сек.";
		echo "<b>Вы можете посетить лес через ".$left."</b>";
	}
	else
	{
		echo "<input type='button' class='btn' onclick=\"window.location='?action=nachat'\" value='Начать Поход'>";
	}
}
else
{
	echo "<b style='color:#ff0000'>Войти в ЛЕС Вы сможете только с 7 уровня до $max_level уровня</b>";
}
?>
</td>
</td>
</tr>
</table>