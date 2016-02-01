<?list($msec,$sec)=explode(chr(32),microtime());$head=$sec+$msec;?>
<?include('conf.php');
$data = mysql_connect($base_name, $base_user, $base_pass);
if(!mysql_select_db($db_name,$data))
{
	echo mysql_error();
	die();
}
$sql=mysql_Query("SELECT * FROM users WHERE login='tobu'");
$db=mysql_fetch_Array($sql);
?>
<LINK REL=StyleSheet HREF='main.css' TYPE='text/css'>
<script>
function slot_view(text)
{
	var s;
	s='<table width=200 cellpadding=2 cellspacing=2 bgcolor="#E4F2DF" style="border: 1px solid #A0C3FC;opacity: 0.90;	filter: alpha(opacity:90);" >';
	s+='<tr><td align=center ><FONT STYLE="FONT-SIZE: 8pt;">'+text+'</FONT></td></tr>';
	s+='</table>';
	var element=document.getElementById('slot_info');
	element.innerHTML=s;
	
	x = event.clientX + document.body.scrollLeft- element.offsetWidth + 10;
	y = event.clientY + document.body.scrollTop + 10;
	if (x<0)x=event.clientX + document.body.scrollLeft+ 10;

    element.style.left = x + 'px';
    element.style.top = y + 'px';
    
	element.style.visibility='visible';
}

function slot_hide()
{ 
	var element=document.getElementById('slot_info');
	element.style.visibility='hidden'; 
}	

function view_item (img,hint) 
{
	document.write("<img src='img/"+img+"' border=0 onmouseover=\"slot_view('"+hint+"');\" onmouseout=\"slot_hide();\">");
}
</script>
<DIV id="slot_info" style="VISIBILITY: hidden; POSITION: absolute"></DIV>
<?
function showPlayer($myinfo)
{
	$inff="<b>»нформаци€ о ".$myinfo["login"]."</b><br>Х —ила: ".$myinfo["sila"]."<br>Х Ћовкость: ".$myinfo["lovkost"]."<br>Х ”дача: ".$myinfo["udacha"]."<br>Х ¬ыносливость: ".$myinfo["power"]."<br>";
	if($myinfo["level"]>0)
	{
		$inff.="Х »нтеллект: ".$myinfo["intellekt"]."<br>";
		$inff.="Х ¬оспри€тие: ".$myinfo["vospriyatie"]."<br>";
	}
	$query=mysql_query("SELECT paltar.*,inv.slot,inv.id as itm,inv.iznos ,inv.iznos_max,inv.noremont,inv.gravirovka,inv.is_modified FROM inv LEFT JOIN paltar on paltar.id=inv.object_id WHERE wear=1 and object_razdel='obj' and owner='".$myinfo["login"]."'");
	while($res=mysql_fetch_array($query))
	{
		$slot=$dat['slot'];
		$obj_id=$dat["id"];
		$iznos=$dat["iznos"];
		$iznos_all=$dat["iznos_max"];
		$gravirovka=$dat["gravirovka"];
		$is_modified=$dat["is_modified"];
		$is_personal=$dat['is_personal'];
		$personal_owner=$dat['personal_owner'];
		$wear_sex=$dat["sex"];
		$name=$dat["name"];
		$art=$dat["art"];
		$podzemka=$dat["podzemka"];
		$need_orden=$dat["orden"];
		$img=$dat["img"];
		$massa=$dat["mass"];
		$prise=$dat["price"];
		$min_sila=$dat["min_sila"];
		$min_lovkost=$dat["min_lovkost"];
		$min_udacha=$dat["min_udacha"];
		$min_vinoslivost=$dat["min_power"];
		$add_sila=$dat["add_sila"];
		$add_lovkost=$dat["add_lovkost"];
		$add_udacha=$dat["add_udacha"];
		$add_intellekt=$dat["add_intellekt"];
		$add_vinoslivost=$dat["add_hp"];
		$add_mana=$dat["add_mana"];
		$bron_head=$dat["protect_head"];
		$bron_arm=$dat["protect_arm"];
		$bron_corp=$dat["protect_corp"];
		$bron_leg=$dat["protect_legs"];
		$bron_poyas=$dat["protect_poyas"];
		$min_attack=$dat["min_attack"];
		$max_attack=$dat["max_attack"];
		$itm=$dat["itm"];
		if(($myinfo['sila']<$min_sila || $myinfo['lovkost']<$min_lovkost || $myinfo['udacha']<$min_udacha || $myinfo['power']<$min_vinoslivost ||($wear_sex!="" && $myinfo['sex']!=$wear_sex)||($need_orden!=0 && $myinfo['orden']!=$need_orden)) && $dat["object"]!="kostyl")
		{
			unWear($myinfo["login"],$itm);
		}
		else
		{
			$desc="";
			if($art){$desc.="<img src=img/icon/artefakt.gif border=0> ";}
			if($podzemka){$desc.="<img src=img/icon/podzemka.gif border=0> ";}
			if($need_orden){$desc.="<img src=img/orden/$need_orden/0.gif border=0> ";}
			$desc.="<b>$name ".($is_modified?" +$is_modified":"")." ($iznos/$iznos_all)</b>";
			if($gravirovka!=""){$desc.="<br>Х ¬ыгравирована надпись: ".$gravirovka."<br>";}
			if($add_vinoslivost){$desc.="<br>Х ”ровень ’ѕ: +$add_vinoslivost";}
			if($add_mana){$desc.="<br>Х ”ровень маны: +$add_mana";}
			
			if($bron_head){$desc.="<br>Х Ѕрон€ головы: +$bron_head";}
			if($bron_arm){$desc.="<br>Х Ѕрон€ рук: +$bron_arm";}
			if($bron_corp){$desc.="<br>Х Ѕрон€ корпуса: +$bron_corp";}
			if($bron_poyas){$desc.="<br>Х Ѕрон€ по€са: +$bron_poyas";}
			if($bron_leg){$desc.="<br>Х Ѕрон€ ног: +$bron_leg";}
			
			if($min_attack){$desc.="<br>Х ћин. урон: ".($min_attack+($is_modified?$is_modified*5:0));}
			if($max_attack){$desc.="<br>Х ћакс. урон: ".($max_attack+($is_modified?$is_modified*5:0));}
						
			if ($is_personal) $desc.="<br><font color=brown>Ћичное оружие персонажа <b>$personal_owner</b></font>";
		}
	}
}

showPlayer($db);
?>
<?list($msec,$sec)=explode(chr(32),microtime());echo round(($sec+$msec)-$head,4);?>