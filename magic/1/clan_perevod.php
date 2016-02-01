<?
echo "<form name='action' action='?spell=clan_perevod' method='post'>";
echo "<select name=clan class=new>"	;
$sql=mysql_query("SELECT name, name_short FROM clan");
while ($res=mysql_fetch_Array($sql))
{
	echo "<option value='".$res["name_short"]."' ".($res["name_short"]==$_POST["clan"]?" selected":"").">".$res["name"];
}
echo "</select>
<input type=submit value='Посмотрет Отчет' class=new>
</form>";
if ($_POST["clan"])
{
	$clan_s=htmlspecialchars(addslashes($_POST["clan"]));
	$lines = file("clan/operation/".$clan_s.".dis");
	foreach ($lines as $line_num => $line) 
	{
		$dis = explode("|",$line);
    	$txt.= $dis[2]."  ".$dis[0]."  [".$dis[1]."]\n";
	}
	echo "<textarea rows=30 cols=120>".str_replace("<b>","",str_replace("</b>","",$txt))."</textarea>";
}
?>