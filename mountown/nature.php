<?
$login=$_SESSION['login'];
$go_time=2;
if($db["adminsite"])$go_time=0;
$map=array(
	"p_-10_-3_","p_-10_1_","p_-10_2_","p_-10_3_","p_-10_4_","p_-11_4_","p_-1_1_","p_-1_2_",
	"p_-1_3_","p_-1_4_","p_-2_2_","p_-2_3_","p_-2_4_","p_-3_2_","p_-3_3_","p_-3_4_","p_-4_1_",
	"p_-4_2_","p_-4_3_","p_-4_4_","p_-5_0_","p_-5_2_","p_-5_3_","p_-6_-1_","p_-6_2_","p_-6_3_",
	"p_-7_-1_","p_-7_-3_","p_-7_0_","p_-7_2_","p_-7_3_","p_-8_-1_","p_-8_-3_","p_-8_2_","p_-8_3_",
	"p_-8_4_","p_-9_-1_","p_-9_-2_","p_-9_-3_","p_-9_0_","p_-9_1_","p_-9_2_","p_-9_4_",
	"p_0_-3_","p_0_0_","p_0_1_","p_0_2_","p_0_3_","p_0_4_","p_1_-1_","p_1_-3_","p_1_0_",
	"p_1_1_","p_1_2_","p_1_3_","p_2_-1_","p_2_-2_","p_2_-3_","p_2_0_","p_2_1_","p_2_2_",
	"p_2_3_","p_2_4_","p_3_-1_","p_3_-2_","p_3_-3_","p_3_0_","p_3_1_","p_3_2_","p_3_3_",
	"p_3_4_","p_4_-1_","p_4_-3_","p_4_0_","p_4_1_","p_4_3_","p_4_4_","p_5_-1_","p_5_-2_",
	"p_5_0_","p_5_1_","p_5_3_","p_6_-1_","p_6_-2_","p_6_0_","p_6_1_","p_6_3_","p_7_-3_",
	"p_7_0_","p_7_1_","p_7_2_","p_7_3_","p_8_-3_","p_7_-2_","p_8_-2_","p_7_4_","p_1_4_",
	"p_-11_3_","p_-11_2_","p_-11_1_","p_-8_0_","p_-11_0_","p_-10_0_","p_-11_-1_","p_-10_-1_",
	"p_-11_-2_","p_-10_-2_","p_-11_-3_","p_5_4_","p_6_4_","p_6_2_","p_7_-1_","p_6_-3_","p_4_-2_","p_5_-3_",
	"p_5_2_","p_4_2_","p_1_-2_","p_-3_1_","p_-2_1_","p_-5_1_","p_-4_0_","p_-6_0_","p_-6_1_","p_-7_1_","p_-8_1_",
	"p_-1_0_","p_-5_4_","p_-6_4_","p_-7_4_","p_-9_3_","p_-12_4_","p_-12_3_","p_-12_2_","p_-8_-2_","p_-7_-2_","p_-6_-2_",
	"p_-6_-3_","p_-5_-3_","p_-5_-2_","p_-4_-3_","p_-4_-2_","p_-3_-3_","p_-3_-2_","p_-2_-3_","p_-2_-2_","p_-1_-3_","p_-1_-2_",
	"p_-3_-1_","p_-2_-1_","p_-1_-1_","p_-2_0_","p_-3_0_","p_-4_-1_","p_-5_-1_","p_0_-2_","p_0_-1_");

if ($_SESSION["cord"]=="")$_SESSION["cord"]="p_0_0_";

if($_GET['goloc']!="" && in_array($_GET['goloc'],$map))
{
	$dtim=time()-$_SESSION["nature_time"];
	if($dtim>0) 
	{
		$_SESSION["cord"]=htmlspecialchars(addslashes($_GET['goloc']));
		$_SESSION["nature_time"]=time()+$go_time;
	}
}
$dtim=time()-$_SESSION["nature_time"];
if($dtim>0) $enable_movie=true;else $enable_movie=false;
?>
<script language="JavaScript">
var stop_time=<?=($go_time-$dtim)?>;
function load_page() 
{
	setTimeout("update_timeout()",1000);
}
var max_stop_time = stop_time;
function update_timeout() 
{	
	stop_time--;
	var o = document.getElementById("move");
	if(stop_time>=0)
	{
	    o.innerHTML = "Перемещаемся... Еще <b>"+stop_time+"</b> сек.";
	}
	else 
	{
		o.innerHTML = '';
	}
	setTimeout("update_timeout()",1000);
}
function move(id)
{ 
	if(stop_time<1){window.location="?goloc="+id+"&r="+ Math.random();} 
	return false; 
}
load_page();
</script>
<SCRIPT LANGUAGE="JavaScript" SRC="scripts/magic-main.js"></SCRIPT>
<div id=hint4></div>
<h3>Остров Весеннего Листа</h3>
<?
$x = explode("_",$_SESSION["cord"]);
$y = $x[2];
$x = $x[1];
for ($my_go=-1;$my_go<2;$my_go++)
{
	for ($mx_go=-1;$mx_go<2;$mx_go++)
	{
		$mxx_go=floor($x+$mx_go);
		$myy_go=floor($y+$my_go);
		$gup='p_'.$x.'_'.($y-1).'_';
		$gdown='p_'.$x.'_'.($y+1).'_';
		$gleft='p_'.($x-1).'_'.$y.'_';
		$gright='p_'.($x+1).'_'.$y.'_';
		$glup='p_'.($x-1).'_'.($y-1).'_';
		$grdown='p_'.($x+1).'_'.($y+1).'_';
		$grup='p_'.($x+1).'_'.($y-1).'_';
		$gldown='p_'.($x-1).'_'.($y+1).'_';
		
		if(in_array($gleft,$map))	{$left='1';$lefta_s='<a title="Запад" style="cursor:hand" onclick="return move(\''.$gleft.'\');">';$lefta='</a>';}else $left=0;
		if(in_array($gright,$map))	{$right='1';$righta_s='<a title="Восток" style="cursor:hand" onclick="return move(\''.$gright.'\');">';$righta='</a>';}else{$right=0;}
		if(in_array($gup,$map))		{$up='1';$upa_s='<a title="Север" style="cursor:hand" onclick="return move(\''.$gup.'\');">';$upa='</a>';}else{$up=0;}
		if(in_array($gdown,$map))	{$down='1';$downa_s='<a title="Юг" style="cursor:hand" onclick="return move(\''.$gdown.'\');">';$downa='</a>';}else{$down=0;}
		if(in_array($glup,$map))	{$lup='1';$lupa_s='<a title="Северо-Запад" style="cursor:hand" onclick="return move(\''.$glup.'\');">';$lupa='</a>';}else{$lup=0;}
		if(in_array($grup,$map))	{$rup='1';$rupa_s='<a title="Северо-Восток" style="cursor:hand" onclick="return move(\''.$grup.'\');">';$rupa='</a>';}else{$rup=0;}
		if(in_array($grdown,$map))	{$rdown='1';$rdowna_s='<a title="Юго-Восток" style="cursor:hand" onclick="return move(\''.$grdown.'\');">';$rdowna='</a>';}else{$rdown=0;}
		if(in_array($gldown,$map))	{$ldown='1';$ldowna_s='<a title="Юго-Запад" style="cursor:hand" onclick="return move(\''.$gldown.'\');">';$ldowna='</a>';}else{$ldown=0;}
	}
}
echo "<font color=#ff0000>".$msg."</font>
<table width=100% cellpadding=0 cellspacing=0 border=0>
<tr>
	<td width=100% valign=top>";
	if($_SESSION["cord"]=='p_3_4_')
	{	
		echo "<input type=button onclick='document.location=\"main.php?act=go&level=lesopilka\"' value='Центральная лесопилка' class=newbut><br>";
	}
	if($_SESSION["cord"]=='p_0_0_')
	{	
		echo "<input type=button onclick='document.location=\"main.php?act=go&level=okraina\"' value='Войти в город' class=newbut><br>";
	}
	if($_SESSION["cord"]=='p_6_-2_')
	{	
		echo "<input type=button onclick='document.location=\"main.php?act=go&level=priem\"' value='Приём ресурсов' class=newbut><br>";
	}
	if($_SESSION["cord"]=='p_-10_0_')
	{	
		echo "<input type=button onclick='document.location=\"main.php?act=go&level=mayak\"' value='Таинственный Маяк' class=newbut><br>";
	}
	if($_SESSION["cord"]=='p_-11_-3_')
	{	
		echo "<input type=button onclick='document.location=\"main.php?act=go&level=ozera\"' value='Озеро' class=newbut><br>";
	}
	echo "</td>";
	echo "<td width=450 valign=top>";
	echo"<table cellpadding=0 cellspacing=2 border=0 algin=center BGCOLOR=#212120><tr bgcolor=#dddddd><td>";
	echo"<table cellpadding=0 cellspacing=0 border=0 algin=center>";
	for ($my=-2;$my<3;$my++)
	{
		echo "<tr>";
		for ($mx=-3;$mx<4;$mx++)
		{
			$mxx=floor($x+$mx);
			$myy=floor($y+$my);
			if ($mxx==$x && $myy==$y)echo'<td width=60 height=60 background="img/map/'.$mxx.'_'.$myy.'.jpg" align=center valign=center><img src="img/city/forest.gif" border=0 alt="Ваше местонахождени"></td>';
			else if ($mxx==$x-1 && $myy==$y && $lefta_s<>'')echo'<td width=60 height=60 title="Перемещение" style="filter: alpha (opacity=70); opacity: 0.7; -khtml-opacity: 0.7; -moz-opacity: 0.7">'.$lefta_s.'<img src=img/map/'.$mxx.'_'.$myy.'.jpg width=60 height=60 border=0>'.$lefta.'</td>';
			else if ($mxx==$x+1 && $myy==$y && $righta_s<>'')echo'<td width=60 height=60 title="Перемещение" style="filter: alpha (opacity=70); opacity: 0.7; -khtml-opacity: 0.7; -moz-opacity: 0.7">'.$righta_s.'<img src=img/map/'.$mxx.'_'.$myy.'.jpg width=60 height=60 border=0>'.$righta.'</td>';
			else if ($mxx==$x && $myy==$y-1 && $upa_s<>'')echo'<td width=60 height=60 title="Перемещение" style="filter: alpha (opacity=70); opacity: 0.7; -khtml-opacity: 0.7; -moz-opacity: 0.7">'.$upa_s.'<img src=img/map/'.$mxx.'_'.$myy.'.jpg width=60 height=60 border=0>'.$upa.'</td>';
			else if ($mxx==$x && $myy==$y+1 && $downa_s<>'')echo'<td width=60 height=60 title="Перемещение" style="filter: alpha (opacity=70); opacity: 0.7; -khtml-opacity: 0.7; -moz-opacity: 0.7">'.$downa_s.'<img src=img/map/'.$mxx.'_'.$myy.'.jpg width=60 height=60 border=0>'.$downa.'</td>';
			else if ($mxx==$x-1 && $myy==$y-1 && $lupa_s<>'')echo'<td width=60 height=60 title="Перемещение" style="filter: alpha (opacity=70); opacity: 0.7; -khtml-opacity: 0.7; -moz-opacity: 0.7">'.$lupa_s.'<img src=img/map/'.$mxx.'_'.$myy.'.jpg width=60 height=60 border=0>'.$lupa_.'</td>';
			else if ($mxx==$x+1 && $myy==$y+1 && $rdowna_s<>'')echo'<td width=60 height=60 title="Перемещение" style="filter: alpha (opacity=70); opacity: 0.7; -khtml-opacity: 0.7; -moz-opacity: 0.7">'.$rdowna_s.'<img src=img/map/'.$mxx.'_'.$myy.'.jpg width=60 height=60 border=0>'.$rdowna.'</td>';
			else if ($mxx==$x+1 && $myy==$y-1 && $rupa_s<>'')echo'<td width=60 height=60 title="Перемещение" style="filter: alpha (opacity=70); opacity: 0.7; -khtml-opacity: 0.7; -moz-opacity: 0.7">'.$rupa_s.'<img src=img/map/'.$mxx.'_'.$myy.'.jpg width=60 height=60 border=0>'.$rupa.'</td>';
			else if ($mxx==$x-1 && $myy==$y+1 && $ldowna_s<>'')echo'<td width=60 height=60 title="Перемещение" style="filter: alpha (opacity=70); opacity: 0.7; -khtml-opacity: 0.7; -moz-opacity: 0.7">'.$ldowna_s.'<img src=img/map/'.$mxx.'_'.$myy.'.jpg width=60 height=60 border=0>'.$ldowna.'</td>';
			else echo'<td><img src=img/map/'.$mxx.'_'.$myy.'.jpg width=60 height=60 border=0></td>';
		}
		echo"</tr>";
	}
	echo"</table>";
	echo"</td></tr></table>";
	echo "<table width=100%><tr><td align=center><b>Сектор ($x,$y)</b><br><small id='move'></small>&nbsp;</td></tr>
	<tr><td align=right><small>
		Войти в город - Сектор (0,0)<br>
		Центральная лесопилка - Сектор (3,4)<br>
		Приём ресурсов - Сектор (6,-2)<br>
		Озеро - Сектор (-11,-3)<br>
		Таинственный Маяк - Сектор (-10,0)<hr>
	</td></tr>
	</table>";

echo "</td>";
echo"</table>";
?>
</center>
</body>