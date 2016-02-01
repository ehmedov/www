<div><?=drwfl($db["login"], $db["id"], $db["level"], $db["dealer"], $db["orden"], $db["admin_level"], $db["clan"], $db["clan_short"], $db["travm"]);?>  [<?=date('Y-m-d H:i:s')?>]</div>
<?
	echo "<img src='draw.php?now=".$db["exp"]."&maximum=".$db["next_up"]."&color=1&".md5(rand())."' border='0' /><br/>";
	echo "<img src='draw.php?now=".$db["hp"]."&maximum=".$db["hp_all"]."&color=2&".md5(rand())."' border='0' /><br/>";
	if($db["mana_all"])echo "<img src='draw.php?now=".$db["mana"]."&maximum=".$db["mana_all"]."&color=3&".md5(rand())."' border='0' />";
	if($db["ups"]){echo "<br/><a href='char.php?view=1'><b style='color:#228b22'>Свободных увеличений: ".$db["ups"]."</b></a>";}
	if($db["umenie"]){echo "<br/><a href='char.php?view=1'><b style='color:#228b22'>Свободные умения: ".$db["umenie"]."</b></a>";}
?>
<div class="sep1"></div>
<div class="sep2"></div>