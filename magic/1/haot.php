<?
if ($_POST["level"])
{
	$_POST["level"]=(int)$_POST["level"];
	switch ($_POST["level"])
	{
		case 4:$creator=2;break;
		case 5:$creator=3;break;
		case 6:$creator=4;break;
		case 7:$creator=8;break;
		case 8:$creator=9;break;
		case 9:$creator=10;break;
		case 10:$creator=11;break;
		
	}	
	$have_zayavka=mysql_fetch_array(mysql_Query("SELECT count(*) FROM zayavka WHERE creator='$creator'"));
	if (!$have_zayavka[0])
	{	
		$wait_to=3*60+time();
		mysql_query("INSERT INTO zayavka(status, type, timeout, creator, minlev1, maxlev1, wait, city, room, hidden) 
		VALUES('1', '7', '3', '$creator', '".$_POST["level"]."', '".$_POST["level"]."', '".$wait_to."', 'mountown', 'room4', '1')");
		echo "Заявка на бой подана...";
	}
	else echo "Поединок идет...";
}

echo "<form name='action' action='?spell=haot' method='post'>
	<select name='level'>";
	for ($i=7;$i<11;$i++)
	{
		echo "<option value=\"$i\" ".($_POST["level"]==$i?"selected":"").">Level $i</option>";
	}	
	echo "</select>
	<input type=submit value='START' class=new>
</form>";

?>