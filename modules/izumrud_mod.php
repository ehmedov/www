<?
if ($db["room"]=="izumrud_floor")
{	
	$labirint=array 
	(
		array(0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0),
		array(0 , 1 , 1 , 0 , 1 , 1 , 0 , 0 , 0 , 0 , 0 , 1 , 1 , 0 , 1 , 1 , 0 , 0 , 0 , 0 , 0 , 1 , 1 , 1 , 0 , 1 , 1 , 1 , 0 , 0),
		array(0 , 1 , 0 , 0 , 0 , 1 , 0 , 0 , 1 , 1 , 1 , 1 , 0 , 0 , 0 , 1 , 1 , 1 , 1 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 1 , 0 , 0 , 0),
		array(0 , 1 , 1 , 1 , 1 , 1 , 0 , 0 , 1 , 0 , 0 , 1 , 1 , 0 , 1 , 1 , 0 , 0 , 1 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 1 , 0 , 0 , 0),
		array(0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 1 , 0 , 0 , 0),
		array(0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 1 , 1 , 1 , 1 , 1 , 0 , 1 , 1 , 1 , 1 , 1 , 0 , 0 , 1 , 1 , 1 , 0 , 1 , 1 , 1 , 0 , 0),
		array(0 , 1 , 1 , 1 , 1 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 1 , 0 , 1 , 0 , 1 , 0 , 0),
		array(0 , 1 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 1 , 1 , 1 , 0 , 1 , 1 , 1 , 0 , 0 , 0 , 0 , 1 , 0 , 1 , 0 , 1 , 0 , 1 , 0 , 0),
		array(0 , 1 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 1 , 0 , 1 , 0 , 1 , 0 , 1 , 0 , 0),
		array(0 , 1 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 1 , 0 , 1 , 0 , 1 , 0 , 1 , 0 , 0),
		array(0 , 1 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 1 , 0 , 1 , 1 , 1 , 0 , 1 , 0 , 0),
		array(0 , 1 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0),
		array(0 , 1 , 1 , 1 , 1 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0),
		array(0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 0 , 0),
		array(0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0),
		array(0 , 1 , 1 , 1 , 0 , 0 , 0 , 0 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 0 , 0 , 0 , 0 , 1 , 1 , 1 , 0 , 0 , 0 , 0),
		array(0 , 1 , 0 , 1 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 1 , 0 , 0 , 0 , 1 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 1 , 0 , 1 , 0 , 0 , 0 , 0),
		array(0 , 1 , 0 , 1 , 1 , 1 , 1 , 1 , 1 , 0 , 0 , 1 , 0 , 0 , 0 , 1 , 0 , 0 , 1 , 1 , 1 , 1 , 1 , 1 , 0 , 1 , 0 , 0 , 0 , 0),
		array(0 , 1 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 1 , 1 , 0 , 1 , 1 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 1 , 0 , 0 , 0 , 0),
		array(0 , 1 , 1 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 1 , 1 , 0 , 0 , 0 , 0),
		array(0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 1 , 1 , 1 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0),
		array(0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0),
		array(0 , 0 , 1 , 0 , 0 , 0 , 0 , 1 , 1 , 1 , 1 , 0 , 0 , 0 , 0 , 1 , 1 , 1 , 1 , 0 , 0 , 0 , 1 , 1 , 1 , 1 , 1 , 0 , 0 , 0),
		array(0 , 0 , 1 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 1 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 1 , 0 , 0 , 0),
		array(0 , 0 , 1 , 1 , 0 , 1 , 0 , 1 , 0 , 0 , 1 , 1 , 1 , 1 , 1 , 1 , 0 , 0 , 1 , 0 , 1 , 0 , 1 , 0 , 0 , 0 , 1 , 0 , 1 , 0),
		array(0 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 1 , 1 , 1 , 1 , 0 , 0 , 0 , 1 , 1 , 1 , 0),
		array(0 , 0 , 1 , 1 , 0 , 1 , 0 , 1 , 0 , 0 , 1 , 1 , 1 , 1 , 1 , 1 , 0 , 0 , 1 , 0 , 1 , 0 , 1 , 0 , 0 , 0 , 1 , 0 , 1 , 0),
		array(0 , 1 , 1 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 1 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 1 , 0 , 0 , 0),
		array(0 , 0 , 1 , 0 , 0 , 0 , 0 , 1 , 1 , 1 , 1 , 0 , 0 , 0 , 0 , 1 , 1 , 1 , 1 , 0 , 0 , 0 , 1 , 1 , 1 , 1 , 1 , 0 , 0 , 0),
		array(0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0)
	);

	$sunduk_Array=array("1x23", "1x21", "18x10", "18x12", "18x14", "18x16", "24x28", "26x28", "26x20", "24x20", "26x5", "24x5", "1x2", "1x4",
	"1x25", "1x27", "3x14", "1x14", "3x12", "1x12");

	$eliks=array(
		"1x23"=>array("wood"=>array(148,149,150)), "1x21"=>array("wood"=>array(148,149,150)),	"18x10"=>array("wood"=>array(148,149,150)),
		"18x12"=>array("wood"=>array(148,149,150)),	"18x14"=>array("wood"=>array(148,149,150)),	"18x16"=>array("wood"=>array(148,149,150)),
		"24x28"=>array("wood"=>array(148,149,150)),	"26x28"=>array("wood"=>array(148,149,150)),	"26x20"=>array("wood"=>array(148,149,150)),
		"24x20"=>array("wood"=>array(148,149,150)),	"26x5"=>array("wood"=>array(148,149,150)),	"24x5"=>array("wood"=>array(148,149,150)),
		"1x2"=>array("wood"=>array(148,149,150)),	 "1x4"=>array("wood"=>array(148,149,150)),	"1x25"=>array("wood"=>array(148,149,150)),
		"1x27"=>array("wood"=>array(148,149,150)),	"3x14"=>array("wood"=>array(148,149,150)),	"1x14"=>array("wood"=>array(148,149,150)),
		"3x12"=>array("wood"=>array(148,149,150)),	"1x12"=>array("wood"=>array(148,149,150))
	);

	$Items_Array=array();
	$Bot_Names=array("palach"=>"Бездушный Палач", "lord"=>"Беспощадный Лорд", "ledi"=>"Леди Смерть", "gnom"=>"Скупой Гном", "stariy"=>"Жадный Торговец", "tupoy"=>"Тупой Торговец");

	$Bot_Array=array(
	"27x2"=>array("palach","stariy","lord","palach"), "25x2"=>array("ledi","gnom","tupoy","ledi"), "23x2"=>array("lord","stariy","stariy","lord"),
	"20x2"=>array("palach","palach","palach","palach"),"19x1"=>array("lord","lord","lord","lord"),"17x1"=>array("lord","stariy","palach"),
	"15x1"=>array("lord","lord","lord","lord"),"14x2"=>array("palach","stariy","lord","palach"),"12x1"=>array("palach","lord","lord","palach"),
	"9x1"=>array("palach","stariy","lord","palach"),"6x1"=>array("lord","lord","lord","lord"),"12x5"=>array("palach","lord","lord","palach"),
	"9x5"=>array("palach","stariy","lord","palach"),"6x5"=>array("lord","lord","lord","lord"),"5x3"=>array("palach","palach","palach","palach"),
	"3x1"=>array("palach","stariy","lord","palach"),"1x1"=>array("stariy","stariy","stariy","stariy"),"3x5"=>array("palach","stariy","lord","palach"),
	"1x5"=>array("stariy","stariy","stariy","stariy"),"17x4"=>array("ledi","gnom","gnom","ledi"),"17x6"=>array("gnom","tupoy","tupoy","gnom"),
	"17x8"=>array("gnom","tupoy","ledi","gnom"),"25x5"=>array("palach","tupoy","stariy","palach"),"25x7"=>array("lord","stariy","gnom","lord"),
	"28x7"=>array("lord","ledi","palach","lord"),"22x7"=>array("lord","ledi","palach","lord"),"22x10"=>array("palach","lord","lord","palach"),
	"28x10"=>array("lord","stariy","stariy","lord"),"25x10"=>array("lord","stariy","gnom","lord"),"24x11"=>array("palach","stariy","gnom","palach"),
	"24x13"=>array("lord","lord","lord","lord"),"24x15"=>array("stariy","stariy","stariy","stariy"),"22x15"=>array("lord","stariy","gnom","lord"),
	"22x18"=>array("palach","lord","ledi","palach"),"26x11"=>array("palach","stariy","gnom","palach"),"26x13"=>array("lord","lord","lord","lord"),
	"26x15"=>array("stariy","stariy","stariy","stariy"),"28x15"=>array("lord","stariy","gnom","lord"),"28x18"=>array("palach","lord","ledi","palach"),
	"22x7"=>array("lord","ledi","tupoy","lord"),"25x20"=>array("palach","gnom","gnom","palach"),"25x22"=>array("stariy","stariy","stariy","stariy"),
	"22x22"=>array("gnom","tupoy","tupoy","gnom"),"22x24"=>array("palach","gnom","ledi","palach"),"22x26"=>array("palach","stariy","gnom","palach"),
	"25x26"=>array("lord","lord","lord","lord"),"28x26"=>array("palach","stariy","lord","palach"),"28x24"=>array("stariy","stariy","stariy","stariy"),
	"28x22"=>array("palach","stariy","lord","palach"), "19x24"=>array("gnom","tupoy","tupoy","gnom"), "17x25"=>array("ledi","gnom","gnom","ledi"),
	"17x8"=>array("gnom","tupoy","ledi","gnom"), "15x24"=>array("tupoy","tupoy","tupoy","tupoy"), "13x24"=>array("ledi","ledi","ledi","ledi"),
	"13x27"=>array("gnom","tupoy","ledi","gnom"), "9x27"=>array("ledi","tupoy","tupoy","ledi"), "5x27"=>array("gnom","tupoy","tupoy","gnom"),
	"4x26"=>array("ledi","gnom","gnom","ledi"), "2x26"=>array("gnom","gnom","gnom","gnom"), "5x25"=>array("ledi","ledi","ledi","ledi"),
	"10x25"=>array("tupoy","tupoy","tupoy","tupoy"), "10x23"=>array("gnom","tupoy","ledi","gnom"), "5x23"=>array("ledi","ledi","ledi","ledi"),
	"4x22"=>array("ledi","gnom","gnom","ledi"), "2x22"=>array("gnom","gnom","gnom","gnom"), "13x21"=>array("gnom","tupoy","ledi","gnom"),
	"9x21"=>array("ledi","tupoy","tupoy","ledi"), "5x21"=>array("gnom","tupoy","tupoy","gnom"), "17x23"=>array("gnom","gnom","gnom","gnom"),
	"17x20"=>array("ledi","gnom","gnom","ledi"), "17x18"=>array("gnom","tupoy","ledi","gnom"), "15x18"=>array("tupoy","tupoy","tupoy","tupoy"),
	"15x15"=>array("ledi","ledi","ledi","ledi"), "18x15"=>array("gnom","gnom","gnom","gnom","gnom"), "20x15"=>array("gnom","tupoy","tupoy","gnom"),
	"20x13"=>array("ledi","gnom","gnom","ledi"), "15x8"=>array("tupoy","tupoy","tupoy","tupoy"), "15x11"=>array("ledi","ledi","ledi","ledi"),
	"18x11"=>array("gnom","gnom","gnom","gnom","gnom"), "20x11"=>array("gnom","tupoy","tupoy","gnom"), "15x13"=>array("tupoy","ledi","ledi","tupoy"),
	"13x13"=>array("gnom","tupoy","ledi","gnom"), "11x13"=>array("ledi","gnom","gnom","ledi"), "11x16"=>array("tupoy","tupoy","tupoy","tupoy"),
	"9x16"=>array("gnom","tupoy","tupoy","gnom"), "7x16"=>array("gnom","gnom","gnom","gnom"), "7x14"=>array("gnom","tupoy","ledi","gnom"),
	"5x14"=>array("gnom","tupoy","ledi","gnom"), "5x16"=>array("ledi","ledi","ledi","ledi"), "5x18"=>array("gnom","tupoy","tupoy","gnom"),
	"2x18"=>array("tupoy","tupoy","tupoy","tupoy"), "2x16"=>array("tupoy","tupoy","tupoy","tupoy"), "3x15"=>array("gnom","gnom","ledi","gnom","gnom"),
	"1x15"=>array("gnom","gnom","tupoy","gnom","gnom"), "11x10"=>array("tupoy","tupoy","tupoy","tupoy"), "9x10"=>array("gnom","tupoy","tupoy","gnom"),
	"7x10"=>array("gnom","gnom","gnom","gnom"), "7x12"=>array("gnom","tupoy","ledi","gnom"), "5x12"=>array("gnom","tupoy","ledi","gnom"),
	"5x10"=>array("ledi","ledi","ledi","ledi"), "5x8"=>array("gnom","tupoy","tupoy","gnom"), "2x8"=>array("tupoy","tupoy","tupoy","tupoy"),
	"2x10"=>array("tupoy","tupoy","tupoy","tupoy"), "3x11"=>array("gnom","gnom","ledi","gnom","gnom"), "1x11"=>array("gnom","gnom","tupoy","gnom","gnom")
	);

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
	$arrow="<img src='img/izumrud/move/".$ch[array_search($vec,$vt)]."' border=0 alt='Ваше местонахождени'>";
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
				if ($mxx==$x && $myy==$y)echo"<td width=17 height=17 align=center valign=center bgcolor='#c0c0c0' ".($itBeInThere?"background='img/izumrud/move/user.gif' title='".$who."'":"").($Bot_Array[$mxx."x".$myy]?"background='img/izumrud/misc/bot.gif'":"").">".$arrow."</td>";
				else if (in_array ($z, $sunduk_Array)) echo"<td width=17 height=17 align=center valign=center bgcolor='#c0c0c0' background='img/izumrud/misc/sunduk.gif' title='Сундук'></td>";
				else if ($itBeInThere)echo"<td width=17 height=17 align=center valign=center bgcolor=#c0c0c0 ".($Bot_Array[$mxx."x".$myy]?"background='img/izumrud/misc/bot.gif'":"")."><img src='img/izumrud/move/user.gif' border=0 alt='".$who."'></td>";
				else if ($Bot_Array[$mxx."x".$myy])echo"<td width=17 height=17 align=center valign=center bgcolor=#c0c0c0><img src='img/izumrud/misc/bot.gif'  alt='Подземные существа' border=0></td>";
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
	$arrow="<img src='img/izumrud/move/".$ch[array_search($vec,$vt)]."' border=0 alt='Ваше местонахождени'>";
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
				if ($mxx==$x && $myy==$y)echo"<td width=17 height=17 align=center valign=center bgcolor='#c0c0c0' ".($itBeInThere?"background='img/izumrud/move/user.gif' title='".$who."'":"").($Bot_Array[$mxx."x".$myy]?"background='img/izumrud/misc/bot.gif'":"").">".$arrow."</td>";
				else if (in_array ($z, $sunduk_Array)) echo"<td width=17 height=17 align=center valign=center bgcolor='#c0c0c0' background='img/izumrud/misc/sunduk.gif' title='Сундук'></td>";
				else if ($itBeInThere)echo"<td width=17 height=17 align=center valign=center bgcolor=#c0c0c0 ".($Bot_Array[$mxx."x".$myy]?"background='img/izumrud/misc/bot.gif'":"")."><img src='img/izumrud/move/user.gif' border=0 alt='".$who."'></td>";
				else if ($Bot_Array[$mxx."x".$myy])echo"<td width=17 height=17 align=center valign=center bgcolor=#c0c0c0><img src='img/izumrud/misc/bot.gif'  alt='Подземные существа' border=0></td>";
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