<?include('key.php');
$login=$_SESSION["login"];

$lines = file("clan/operation/".$clan_s.".dis");
foreach ($lines as $line_num => $line) 
{
	$dis = explode("|",$line);
    $txt.= $dis[2]."  ".$dis[0]."  [".$dis[1]."]\n";
}
echo "<textarea rows=30 cols=120>".str_replace("<b>","",str_replace("</b>","",$txt))."</textarea>";
?>