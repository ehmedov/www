<?
function convert_time($vaxt)
{
	$r=$vaxt-time();
	$days=(int)($r/(60*60*24));
	$hours=(int)(($r-$days*60*60*24)/(60*60));
	$mins=(int)(($r-$days*60*60*24-$hours*60*60)/(60));
	$secs=(int)($r-$days*60*60*24-$hours*60*60-$mins*60);
	
	if($days<=0){$day="";}else $day="$days ��.";
	if($hours<=0){$hour="";}else $hour="$hours �.";
	if($mins<=0){$minut="";}else $minut="$mins ���.";
	if($secs<=0){$secs=0;}
	$left="$day $hour $minut $secs ���.";
	return $left;
}
?>