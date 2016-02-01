<?
if ($db["room"]=="novruz_floor")
{	
	$labirint=array 
	(
		array(0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 ),
		array(0 , 0 , 1 , 1 , 1 , 1 , 0 , 0 , 0 , 0 ),
		array(0 , 0 , 1 , 1 , 1 , 0 , 0 , 0 , 0 , 0 ),
		array(0 , 0 , 1 , 1 , 1 , 0 , 0 , 0 , 0 , 0 ),
		array(0 , 0 , 0 , 1 , 0 , 0 , 1 , 1 , 0 , 0 ),
		array(0 , 0 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 0 ),
		array(0 , 0 , 0 , 1 , 1 , 0 , 1 , 1 , 0 , 0 ),
		array(0 , 0 , 0 , 1 , 0 , 0 , 0 , 1 , 0 , 0 ),
		array(0 , 0 , 0 , 1 , 0 , 0 , 0 , 1 , 0 , 0 ),
		array(0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 )
	);

	$sunduk_Array=array("5x2","5x8","1x5","8x7");
	$eliks=array("5x2"=>array("wood"=>array(157)),"5x8"=>array("wood"=>array(158)),"1x5"=>array("wood"=>array(157,158)),"8x7"=>array("wood"=>array(25)));

	$Items_Array=array();
	$Bot_Names=array("santa"=>"Див");

	$Bot_Array=array("7x3"=>array("santa"),"6x3"=>array("santa","santa","santa"),"6x4"=>array("santa","santa"),"3x3"=>array("santa","santa","santa"),
	"5x5"=>array("santa","santa","santa"),"5x7"=>array("santa","santa","santa"),"3x2"=>array("santa","santa","santa"),
	"3x4"=>array("santa","santa","santa"),"1x2"=>array("santa","santa","santa"),"1x4"=>array("santa","santa","santa"),"7x7"=>array("santa","santa","santa","santa","santa"),);

}
//----------------------------------------------------------------
function DrawAllMap($loc,$vec)
{
	global $labirint;
	global $sunduk_Array;
	global $Bot_Array;
	global $users;
	$cord = explode("x",$loc);
	$x = $cord[0];
	$y = $cord[1];
	$vt=array(0,90,180,270);
	$ch=array("right.gif","back.gif","left.gif","top.gif");
	$arrow="<img src='img/novruz/move/".$ch[array_search($vec,$vt)]."' border=0 alt='Ваше местонахождени'>";
	echo "<table border=0 cellpadding=0 cellspacing=0 bgcolor=#7e898b><tr><td>";
		echo "<table border=0 cellpadding=0 cellspacing=0 bgcolor=#000000 width=100% height=100%>";
		for ($my=-5;$my<7;$my++)
		{
			echo "<tr>";
			for ($mx=-4;$mx<4;$mx++)
			{
				$mxx=floor($x+$mx);
				$myy=floor($y+$my);
				$z=$mxx."x".$myy;
				$itBeInThere = 0;
				$who="";
				if ($users!="")
				foreach($users as $currentValue) 
				{
  					if (in_array ($z, $currentValue)) 
  					{
    					$itBeInThere = 1;
    					$who=$currentValue["login"];
    				}
  				} 
				if ($mxx==$x && $myy==$y)echo"<td width=17 height=17 align=center valign=center bgcolor='#c0c0c0' ".($itBeInThere?"background='img/novruz/move/user.gif' title='".$who."'":"").($Bot_Array[$mxx."x".$myy]?"background='img/novruz/misc/bot.gif'":"").">".$arrow."</td>";
				else if (in_array ($z, $sunduk_Array)) echo"<td width=17 height=17 align=center valign=center bgcolor='#c0c0c0' background='img/novruz/misc/sunduk.gif' title='Сундук'></td>";
				else if ($itBeInThere)echo"<td width=17 height=17 align=center valign=center bgcolor=#c0c0c0 ".($Bot_Array[$mxx."x".$myy]?"background='img/novruz/misc/bot.gif'":"")."><img src='img/novruz/move/user.gif' border=0 alt='".$who."'></td>";
				else if ($Bot_Array[$mxx."x".$myy])echo"<td width=17 height=17 align=center valign=center bgcolor=#c0c0c0><img src='img/novruz/misc/bot.gif'  alt='Подземные существа' border=0></td>";
				else if ($labirint[$mxx][$myy]==1)echo'<td width=17 height=17 align=center valign=center bgcolor=#c0c0c0></td>';
				else echo'<td width=17 height=17 align=center valign=center></td>';	
			}
			echo "</tr>";
		} 
		echo "</table>";
	echo "</td></tr></table>";

}
//----------------------------------------------------------------
function DrawAll($loc,$vec)
{
	global $labirint;
	global $sunduk_Array;
	global $Bot_Array;
	global $users;
	$cord = explode("x",$loc);
	$x = $cord[0];
	$y = $cord[1];
	$vt=array(0,90,180,270);
	$ch=array("right.gif","back.gif","left.gif","top.gif");
	$arrow="<img src='img/novruz/move/".$ch[array_search($vec,$vt)]."' border=0 alt='Ваше местонахождени'>";
	echo "<table border=0 cellpadding=0 cellspacing=0 bgcolor=#7e898b><tr><td>";
		echo "<table border=0 cellpadding=0 cellspacing=0 bgcolor=#000000 width=100% height=100%>";
		for ($my=0;$my<30;$my++)
		{
			echo "<tr>";
			for ($mx=0;$mx<30;$mx++)
			{
				$mxx=$mx;
				$myy=$my;
				$z=$mxx."x".$myy;
				$itBeInThere = 0;
				$who="";
				if ($users!="")
				foreach($users as $currentValue) 
				{
  					if (in_array ($z, $currentValue)) 
  					{
    					$itBeInThere = 1;
    					$who=$currentValue["login"];
    				}
  				} 
				if ($mxx==$x && $myy==$y)echo"<td width=17 height=17 align=center valign=center bgcolor='#c0c0c0' ".($itBeInThere?"background='img/novruz/move/user.gif' title='".$who."'":"").($Bot_Array[$mxx."x".$myy]?"background='img/novruz/misc/bot.gif'":"").">".$arrow."</td>";
				else if (in_array ($z, $sunduk_Array)) echo"<td width=17 height=17 align=center valign=center bgcolor='#c0c0c0' background='img/novruz/misc/sunduk.gif' title='Сундук'></td>";
				else if ($itBeInThere)echo"<td width=17 height=17 align=center valign=center bgcolor=#c0c0c0 ".($Bot_Array[$mxx."x".$myy]?"background='img/novruz/misc/bot.gif'":"")."><img src='img/novruz/move/user.gif' border=0 alt='".$who."'></td>";
				else if ($Bot_Array[$mxx."x".$myy])echo"<td width=17 height=17 align=center valign=center bgcolor=#c0c0c0><img src='img/novruz/misc/bot.gif'  alt='Подземные существа' border=0></td>";
				else if ($labirint[$mxx][$myy]==1)echo'<td width=17 height=17 align=center valign=center bgcolor=#c0c0c0></td>';
				else echo'<td width=17 height=17 align=center valign=center></td>';	
			}
			echo "</tr>";
		} 
		echo "</table>";
	echo "</td></tr></table>";

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
	else if($vector==180) $r=$row-1;
	else if($vector==270) $c=$col-1;
	else $r=$row+1;
	$cell['fwd']=$r."x".$c;
	$cell['fwd_cord']=$r."x".$c;
	if($labirint[$r][$c]==0) $cell['fwd']=false;
	
	// left
	$c=$col;
	$r=$row;
	if($vector==90) $r=$row+1;
	else if($vector==180) $c=$col+1;
	else if($vector==270) $r=$row-1;
	else $c=$col-1;
	$cell['left']=$r."x".$c;
	$cell['left_cord']=$r."x".$c;
	if($labirint[$r][$c]==0) $cell['left']=false;
	
	// right
	$c=$col;
	$r=$row;
	if($vector==90) $r=$row-1;
	else if($vector==180) $c=$col-1;
	else if($vector==270) $r=$row+1;
	else $c=$col+1;
	$cell['right']=$r."x".$c;
	$cell['right_cord']=$r."x".$c;
	if($labirint[$r][$c]==0) $cell['right']=false;
	
	return $cell;
}
?>