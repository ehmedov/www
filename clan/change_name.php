<?include('key.php');
$login=$_SESSION["login"];
if($db["glava"]==1)
{
	if ($_POST['action'])
	{
		if ($db['platina']>=300)
		{	
			$name=htmlspecialchars(addslashes($_POST["name"]));
			
			$SEEK_NAME = mysql_query("SELECT * FROM clan WHERE name='$name'");
	        $NAME_D = mysql_fetch_array($SEEK_NAME);	        
	        if(!$NAME_D)
	        {				
				mysql_query("UPDATE clan SET name='$name' WHERE name_short = '".$clan_s."'");
				mysql_query("UPDATE users SET clan='$name' WHERE clan_short = '".$clan_s."'");
				mysql_query("UPDATE abils SET tribe='$name' WHERE tribe = '".$clan_t."'");
				mysql_query("UPDATE users SET platina=platina-300 WHERE login='".$login."'");
				history($login,'Изменил Названия Ханства',"300 Пл.",$ip,'Клановая комната');
				echo "Вы удачно изменили Названия!";
				$clan_t=$name;
			}
			else echo "Название Ханства <B>$name</B> уже занято! Выберите другое название.";
		}
		else echo "У Вас нет такой суммы - 300 Пл.";
	}
}
?>
<form name='name' action='main.php?act=clan&do=2&a=change_name' method='post'>
<table>
<TR>
	<TD>Названия Ханства:</TD>
	<TD>
		<input type=text name="name" value="<?=$clan_t?>" class=new size=30> за 300 Пл.
	</TD>
</TR>
<tr><td colspan=2><input type="submit" value="Сменить" name="action"></td></tr>
</table>
</form>