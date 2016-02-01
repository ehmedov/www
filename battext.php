<?
	$filename = "logs/".$bid.".dis"; 
	$f=file($filename);
	$dis = explode("<hr>",$f[0]);
	$c = count($dis)-1;
	$goster=10;
	if($c>$goster){$b = $c; $e = $c-$goster; $l = 1;}
	else{$b = $c; $e = 0; $l = 0;}
	for($i = $b;$i >= $e;$i--)
	{
		echo "<div align=left>".$dis[$i]."</div><hr>";
	}
?>