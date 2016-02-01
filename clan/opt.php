<?
$site_n=htmlspecialchars(addslashes($_POST['site_n']));
$history_n=htmlspecialchars(addslashes($_POST['history_n']));
if(empty($site_n))
{
	?>
	<table border=0 class=inv width=500 height=120>
	<tr valign=top><td align=left>
	<form name='chin' action='main.php?act=clan&do=2&a=opt' method='post'>
		<b>Сайт:</b> <input type=text name='site_n' value='<?echo $clan_site?>' class=new size=30><BR><BR>
		<b>Легенда клана:</b><BR>
		<textarea cols=80 rows=15 class=new name='history_n'><?echo $history;?></textarea><BR>
		<input type=submit value=" Сохранить " class=new>
	</form>
	</td></tr>
	</table>
	<?
}
else if($db["glava"]==1)
{
	$history = str_replace("\n","<BR>",$history_n);
	$result = mysql_query("UPDATE clan SET site='".$site_n."',story='".$history."' WHERE name_short='".$clan_s."'");
	history($login,'Настройки клана','Ханства '.$clan_t,$db['remote_ip'], "Глава: ".$login);
	echo "Настройки клана изменены удачно.";
}