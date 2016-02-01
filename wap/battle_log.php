<?
	$dis = explode("<hr>",$T_D["logs"]);
	$c = count($dis)-1;
	$goster=3;
	if($c>$goster){$b = $c; $e = $c-$goster; $l = 1;}
	else{$b = $c; $e = 0; $l = 0;}
	for($i = $b;$i >= $e;$i--)
	{
		echo "<div align=left>".$dis[$i]."</div><hr>";
	}
?>