<?
$login = $_SESSION['login'];
?>
<body style="background-image: url(img/index/forest.jpg);background-repeat:no-repeat;background-position:top right">
<h3>�������� � ����� ���</h3>
<div align=right>
<input type="button" class="newbut" onclick="window.location='main.php?act=go&level=remesl'" value="����� �� �������">
<input type="button" class="newbut" onclick="window.location='main.php?act=none'" value="��������">
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
		else echo "<b style='color:#ff0000'>����� � ��� �� ������� ������ � 7 ������ �� $max_level ������</b>";
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
		if($h<=0){$hour="";}else $hour="$h �.";
		if($m<0){$minut="";}else $minut="$m ���.";
		if($sec<0){$sec=0;}
		$left="$hour $minut $sec ���.";
		echo "<b>�� ������ �������� ��� ����� ".$left."</b>";
	}
	else
	{
		echo "<input type='button' class='btn' onclick=\"window.location='?action=nachat'\" value='������ �����'>";
	}
}
else
{
	echo "<b style='color:#ff0000'>����� � ��� �� ������� ������ � 7 ������ �� $max_level ������</b>";
}
?>
</td>
</td>
</tr>
</table>