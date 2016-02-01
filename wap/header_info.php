<?
	$have_online=mysql_fetch_array(mysql_query("SELECT count(*) FROM online WHERE login='".$db["login"]."'"));
?>
<div class="aheader">
<?=drwfl($db["login"], $db["id"], $db["level"], $db["dealer"], $db["orden"], $db["admin_level"], $db["clan"], $db["clan_short"], $db["travm"]);?><br/>
<?
	echo "<img src='draw.php?now=".$db["hp"]."&maximum=".$db["hp_all"]."&color=2&".md5(rand())."' border='0' /><br/>";
	if($db["mana_all"])echo "<img src='draw.php?now=".$db["mana"]."&maximum=".$db["mana_all"]."&color=3&".md5(rand())."' border='0' /><br/>";
	echo "<img src='http://www.meydan.az/img/obraz/".$db["obraz"]."' border='0' /><br/>";
	
	if (!$db["adminsite"])
	{	
		if($have_online[0])
		{
			echo "Персонаж сейчас находится <b style='color:#228b22'>OnLine.</b><br/>";
			$room=$db["room"];
			include('otaqlar.php');
			echo "Нахождение: <b>$mesto</b>";
			if ($db["bs"])echo "<br/>координаты [".$db["location"]."]";
		}
		else
		{
			$lastvisit=mysql_fetch_array(mysql_query("SELECT MAX(time_stamp) FROM report WHERE login='".$db["login"]."' and type='1'"));
			echo "Персонаж сейчас <b style='color:#666666'>Off-line</b><br/>";
			echo "Последний вход в игру:<br/>(".$lastvisit[0].")";
		}
	}
	else 
	{
		echo "Персонаж сейчас <b style='color:#666666'>Off-line</b><br/>";
		echo "Последний вход в игру:<br/>(2011-11-10 18:47:08)";
	}
	if($db["battle"])
	{
		echo "<br/>Персонаж в <a href='log.php?log=".$db["battle"]."'>поединке</a><br/>";
	}
?>
</div>
<div class="sep1"></div>
<div class="sep2"></div>
<?showPlayer($db);?>	
<div class="sep1"></div>
<div class="sep2"></div>
