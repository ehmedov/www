<?
	$maximum=(int)$_GET["maximum"];
	$now=(int)$_GET["now"];
	$health = ceil(100*$now/$maximum); 
	$img_height=14;
	$img_width=200;
	$img = imagecreatetruecolor($img_width, $img_height);
	imagecolorallocate($img, 0, 0, 0);
	
	if ($_GET["color"]==1)
	{	
		$red = imagecolorallocate($img, 	165,42,42);
		$white = imagecolorallocate($img, 255, 255, 255);
		$text="Exp";
	}
	else if ($_GET["color"]==2)
	{	
		if ($health<33)			$red = imagecolorallocate($img, 200, 0, 0);
		else if ($health<66)	$red = imagecolorallocate($img, 255, 215, 0);
		else					$red = imagecolorallocate($img, 0, 100, 0);
		$white = imagecolorallocate($img, 255, 255, 255);
		$text="HP";
	}
	else if ($_GET["color"]==3)
	{	
		$red = imagecolorallocate($img, 0, 0, 200);
		$white = imagecolorallocate($img, 255, 255, 255);
		$text="MANA";
	}
	imagefilledpolygon($img, array(0, 0, 0, $img_height, ceil($health*$img_width/100), $img_height, ceil($health*$img_width/100), 0), 4, $red);
	imagestring($img, 2, 10, 1, "$text: $now/$maximum ($health%)", $white);
	imagepolygon($img, array(0,0, 0,$img_height, $img_width-1,$img_height, $img_width-1,0), 4, $white);
	header('Content-Type: image/gif');
	imagegif($img);
	imagedestroy($img);

?>