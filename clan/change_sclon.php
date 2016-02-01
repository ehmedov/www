<?include('key.php');
$login=$_SESSION["login"];
if($db["glava"]==1)
{
	if ($_POST['action'])
	{
		if ($db['platina']>=200)
		{	
			$or_d=(int)$_POST['orden'];
			mysql_query("UPDATE clan SET orden=$or_d WHERE name_short = '".$clan_s."'");
			mysql_query("UPDATE users SET orden=$or_d WHERE clan_short = '".$clan_s."'");
			mysql_query("UPDATE users SET platina=platina-200 WHERE login='".$login."'");
			history($login,'Изменил склонност',"200 Пл.",$ip,'Клановая комната');
			echo "Вы удачно изменили склонности!";
		}
		else echo "У Вас нет такой суммы - 200 Пл.";
	}
}
?>
<form name='sklonnost' action='main.php?act=clan&do=2&a=change_sclon' method='post'>
<table>
<TR>
	<TD>Склонность Клана:</TD>
	<TD>
		<select name="orden">
			<option value="2">Вампиры - 200 Платина
			<option value="3">Орден Равновесия - 200 Платина
			<option value="4">Орден Света - 200 Платина
		</select>
	</TD>
</TR>
<tr><td colspan=2><input type="submit" value="Сменить" name="action"></td></tr>
</table>
</form>