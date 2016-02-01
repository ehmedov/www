<?
$vector=0;
$labirint=array 
	(
		array(1 , 0 , 0 , 1 , 1 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0),
		array(1 , 0 , 0 , 1 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 1),
		array(1 , 0 , 0 , 1 , 0 , 1 , 1 , 1 , 1 , 1 , 0 , 0 , 1 , 0 , 1 , 0 , 0 , 1 , 0 , 0),
		array(1 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 1 , 0 , 1 , 0 , 0 , 1 , 0 , 0),
		array(1 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 1 , 0 , 1 , 0 , 0 , 1 , 1 , 0),
		array(1 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 1 , 0 , 1 , 0 , 0 , 0 , 1 , 0),
		array(1 , 1 , 1 , 1 , 0 , 0 , 0 , 0 , 0 , 1 , 1 , 1 , 1 , 0 , 1 , 0 , 0 , 0 , 1 , 1),
		array(0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 1),
		array(0 , 0 , 0 , 0 , 0 , 1 , 1 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 1),
		array(0 , 0 , 0 , 0 , 0 , 1 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 1 , 1 , 1 , 0 , 1),
		array(0 , 1 , 1 , 1 , 1 , 1 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 1),
		array(0 , 1 , 0 , 0 , 0 , 0 , 0 , 1 , 1 , 1 , 1 , 1 , 1 , 0 , 0 , 0 , 0 , 1 , 0 , 1),
		array(0 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 1 , 0 , 0),
		array(1 , 1 , 0 , 1 , 1 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 1 , 0 , 0),
		array(0 , 0 , 0 , 1 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 1 , 1 , 1),
		array(0 , 0 , 0 , 1 , 0 , 1 , 0 , 0 , 0 , 1 , 1 , 1 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 1),
		array(0 , 1 , 1 , 1 , 0 , 1 , 0 , 0 , 0 , 1 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 1),
		array(0 , 1 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 1 , 0 , 0 , 1 , 1 , 1 , 1 , 1 , 0 , 0 , 1),
		array(0 , 1 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 1 , 1 , 1),
		array(0 , 1 , 0 , 0 , 0 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0)
	);
//----------------------------------------------------------------
function build_move_image($location, $vector) 
{
	global $smert_bot;
	$step1=next_step($location, $vector);
	if($step1['fwd']) $step2=next_step($step1['fwd'], $vector);
	if($step2['fwd']) $step3=next_step($step2['fwd'], $vector);
	else $step3['fwd']=false;
	$s="";
	
	if($step1['left']) $s.="document.getElementById('l2l').style.display = 'block';";
	else $s.="document.getElementById('l1l').style.display = 'block';";
	
	if($step1['fwd']) 
	{
		if($step1['fwd']=="19x11" && $smert_bot) $s.="document.getElementById('bot_id').style.display = 'block';";

		if($step2['left']) 
		{
			$s.="document.getElementById('l3l').style.display = 'block';";
		}
		else $s.="document.getElementById('l2l').style.display = 'block';";
		
		if($step2['fwd']) 
		{
			if($step3['left']) 
			{
				$s.="document.getElementById('l4l').style.display = 'block';";
			}
			else $s.="document.getElementById('l3l').style.display = 'block';";
			
			if(!$step3['fwd']) $s.="document.getElementById('l3f').style.display = 'block';";
			
			if($step3['right']) 
			{
				$s.="document.getElementById('l4r').style.display = 'block';";
			}
			else $s.="document.getElementById('l3r').style.display = 'block';";
			if($step2['fwd']=="19x11" && $smert_bot) $s.="document.getElementById('bot_id_small').style.display = 'block';";
		} 
		else $s.="document.getElementById('l2f').style.display = 'block';";
		
		if($step2['right']) 
		{
			$s.="document.getElementById('l3r').style.display = 'block';";
		}
		else $s.="document.getElementById('l2r').style.display = 'block';";
	} 
	else $s.="document.getElementById('l1f').style.display = 'block';";
	
	if($step1['right']) $s.="document.getElementById('l2r').style.display = 'block';";
	else $s.="document.getElementById('l1r').style.display = 'block';";
	
	return $s;
}
//----------------------------------------------------------------
function next_step($location,$vector)
{
	global $labirint;
	$cord = explode("x",$location);
	$row=$cord[0];
	$col=$cord[1];
	$cell=array();

	// fwd
	$c=$col;
	$r=$row;
	if($vector==90) $c=$col+1;
	elseif($vector==180) $r=$row-1;
	elseif($vector==270) $c=$col-1;
	else $r=$row+1;
	$cell['fwd']=$r."x".$c;
	if($labirint[$r][$c]==0) $cell['fwd']=false;
	
	// left
	$c=$col;
	$r=$row;
	if($vector==90) $r=$row+1;
	elseif($vector==180) $c=$col+1;
	elseif($vector==270) $r=$row-1;
	else $c=$col-1;
	$cell['left']=$r."x".$c;
	if($labirint[$r][$c]==0) $cell['left']=false;
	
	// right
	$c=$col;
	$r=$row;
	if($vector==90) $r=$row-1;
	elseif($vector==180) $c=$col-1;
	elseif($vector==270) $r=$row+1;
	else $c=$col+1;
	$cell['right']=$r."x".$c;
	if($labirint[$r][$c]==0) $cell['right']=false;
	
	// back
	$c=$col;
	$r=$row;
	if($vector==90) $c=$col-1;
	elseif($vector==180) $r=$row+1;
	elseif($vector==270) $c=$col+1;
	else $r=$row-1;
	$cell['back']=$r."x".$c;
	if($labirint[$r][$c]==0) $cell['back']=false;
	return $cell;
}
//-----------------------------------------------------------------
function build_map($loc,$vec,$users)
{
	global $labirint;
	$cord = explode("x",$loc);
	$x = $cord[0];
	$y = $cord[1];
	$vt=array(0,90,180,270);
	$ch=array("right.gif","back.gif","left.gif","top.gif");
	$arrow="<img src='img/tower/move/".$ch[array_search($vec,$vt)]."' border=0 alt='Ваше местонахождени'>";
	echo "<table border=0 cellpadding=0 cellspacing=2 bgcolor=#7e898b width=98 height=98><tr><td>";
		echo "<table border=0 cellpadding=0 cellspacing=0 bgcolor=#000000 width=100% height=100%>";
		for ($my=-4;$my<5;$my++)
		{
			echo "<tr>";
			for ($mx=-4;$mx<5;$mx++)
			{
				$mxx=floor($x+$mx);
				$myy=floor($y+$my);
				$z=$mxx."x".$myy;
				$itBeInThere = 0;
				$who="";
				foreach ($users as $currentValue) 
				{
  					if (in_array ($z, $currentValue)) 
  					{
    					$itBeInThere = 1;
    					$who=$currentValue[login];
    				}
  				} 
				if ($mxx==$x && $myy==$y)echo"<td width=10 height=10 align=center valign=center bgcolor='#c0c0c0' ".($itBeInThere?"background='img/tower/move/0.gif' title='$who'":"''").">$arrow</td>";
				else if ($itBeInThere)echo"<td width=10 height=10 align=center valign=center bgcolor=#c0c0c0><img src='img/tower/move/0.gif' border=0 alt='$who'></td>";
				else if ($labirint[$mxx][$myy]==1)echo'<td width=10 height=10 align=center valign=center bgcolor=#c0c0c0></td>';
				else echo'<td width=10 height=10 align=center valign=center></td>';	
			}
			echo "</tr>";
		} 
		echo "</table>";
	echo "</td></tr></table>";

}
?>