<?
include('key.php');
include('time.php');
$do=$_GET['do'];
$rnd=md5(time());
$statlar=addslashes($_GET['stat']);
if(empty($do)){$do = "";}
$login=$_SESSION['login'];
//-------------------------------------------------------------------------------------------------------------
$have_priem=mysql_fetch_Array(mysql_query("SELECT count(*) FROM slots_priem WHERE user_id =".$db["id"]));
if (!$have_priem[0])
{	
	for($i=1;$i<=8;$i++) mysql_query("INSERT INTO slots_priem (user_id,sl_name) values (".$db["id"].",'sl".$i."')");
}
//-------------------------------------------------------------------------------------------------------------
if (@$_GET['edit']) 
{
	$summ = floor($_GET['str']+$_GET['dex']+$_GET['inst']+$_GET['power']+$_GET['intel']+$_GET['wis']+$_GET['duxa']);
	if(!is_numeric($summ)){$summ=0;}

	if ($db["ups"] >0  && $summ<=$db["ups"] && $summ>0 && $_GET['str']>0)
	{	
		mysql_query("UPDATE `users` SET `sila` = `sila`+{$_GET['str']}, `ups`=`ups`-{$_GET['str']} WHERE `login` = '".$login."' LIMIT 1;");
        $msg.="<font color=red>���������� �����������<B> \"����\" </B>����������� ������</font><br>";
	}

	if ($db["ups"] >0  && $summ<=$db["ups"] && $summ>0 && $_GET['dex']>0)
	{	
		mysql_query("UPDATE `users` SET `lovkost` = `lovkost`+{$_GET['dex']}, `ups`=`ups`-{$_GET['dex']} WHERE `login` = '".$login."' LIMIT 1;");
        $msg.="<font color=red>���������� �����������<B> \"��������\" </B>����������� ������</font><br>";
	}

	if ($db["ups"] >0  && $summ<=$db["ups"] && $summ>0 && $_GET['inst']>0)
	{	
		mysql_query("UPDATE `users` SET `udacha` = `udacha`+{$_GET['inst']}, `ups`=`ups`-{$_GET['inst']} WHERE `login` = '".$login."' LIMIT 1;");
        $msg.="<font color=red>���������� �����������<B> \"�����\" </B>����������� ������</font><br>";
	}

	if ($db["ups"] >0  && $summ<=$db["ups"] && $summ>0 && $_GET['power']>0)
	{	
		mysql_query("UPDATE `users` SET `power` = `power`+{$_GET['power']}, `hp_all` = `hp_all`+".($_GET['power']*6).", `ups`=`ups`-{$_GET['power']} WHERE `login` = '".$login."' LIMIT 1;");
		$msg.="<font color=red>���������� �����������<B> \"������������\" </B>����������� ������</font><br>";
	}

    if (($db["ups"] >0 ) && ($db['level'] > 1) && $summ<=$db["ups"] && $summ>0 && $_GET['intel']>0)
    {	
    	mysql_query("UPDATE `users` SET `intellekt` = `intellekt`+{$_GET['intel']}, `ups`=`ups`-{$_GET['intel']} WHERE `login` = '".$login."' LIMIT 1;");
    	$msg.="<font color=red>���������� �����������<B> \"���������\" </B>����������� ������</font><br>";
    }

	if (($db["ups"] >0) && ($db['level'] > 1)  && $summ<=$db["ups"] && $summ>0 && $_GET['wis']>0)
	{	
		mysql_query("UPDATE `users` SET `vospriyatie` = `vospriyatie`+{$_GET['wis']}, `mana_all` = `mana_all`+".($_GET['wis']*10).", `ups`=`ups`-{$_GET['wis']} WHERE `login` = '".$login."' LIMIT 1;");
        $msg.="<font color=red>���������� �����������<B> \"����������\" </B>����������� ������</font><br>";
	}
	
	if (($db["ups"] >0 ) && ($db['level'] > 9) && $summ<=$db["ups"] && $summ>0 && $_GET['duxa']>0)
    {	
    	mysql_query("UPDATE `users` SET `duxovnost` = `duxovnost`+{$_GET['duxa']}, `ups`=`ups`-{$_GET['duxa']} WHERE `login` = '".$login."' LIMIT 1;");
    	$msg.="<font color=red>���������� �����������<B> \"����������\" </B>����������� ������</font><br>";
    }
	$db = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `login` = '".$login."' LIMIT 1;"));
}
//-------------------------------------------------------------------------------------------------------------
$umeniyalar=array("castet_vl","sword_vl","axe_vl","hummer_vl","copie_vl","shot_vl","staff_vl","cast","fire_magic","earth_magic","water_magic","air_magic","svet_magic","tma_magic","gray_magic");
if(($do == "umenie") && in_array($statlar,$umeniyalar) && $db["umenie"]>0)
{	
	switch ($statlar)
    {
        case phisic_vl: $st_title="����������� �����"; break;
		case sword_vl:  $st_title="������"; break;
        case castet_vl: $st_title="������, ���������"; break;
        case axe_vl:  $st_title="��������, ��������"; break;
        case hummer_vl:  $st_title="��������, ��������"; break;
		case copie_vl:  $st_title="���������� ��������"; break;
        case staff_vl:  $st_title="��������"; break;
       
        case fire_magic:  $st_title="������� ����"; break;
        case earth_magic:  $st_title="������� �����"; break;
        case water_magic:  $st_title="������� ����"; break;
        case air_magic:  $st_title="������� �������"; break;
        
        case svet_magic:  $st_title="������� �����"; break;
        case tma_magic:  $st_title="������� ����"; break;
        case gray_magic:  $st_title="����� �����"; break;
    }
	mysql_query("UPDATE users SET $statlar=$statlar+1,umenie=umenie-1 WHERE login='".$login."'");
	$msg="������ ��������� <b>���������� �������� $st_title</b>!<br>";
	$db = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `login` = '".$login."' LIMIT 1;"));
}
//-------------------------------------------------------------------------------------------------------------
?>
<style>
.tz			{ font-weight:bold; color: #514340; background-color: #fff8ea; cursor:pointer;}
.tzS		{ font-weight:bold; color: #514340; background-color: #504F4C; cursor:pointer;}
.tzOver		{ font-weight:bold; color: #514340; background-color: #C0C0C0; cursor:pointer;}
.tzSet		{ font-weight:bold; color: #514340; background-color: #CEBBAA; cursor:pointer;}
.dtz		{ display: none }


IMG.skill{width:9px;height:9px;cursor:pointer;}
TD.skill{font-weight:bold}
TD.skills{font-weight:bold;color:#600000}
TD.skillb{font-weight:bold;color:#006000}
</STYLE>

<SCRIPT>
var clevel='';

function dw(s) {document.write(s);}

function highl(nm, i)
{	if (clevel == nm) { document.all(nm).className = 'tzSet' }
	else {
		if (i==1) { document.all(nm).className = 'tzOver' }
		else { document.all(nm).className = 'tz' }
	}
}
function setlevel(nm)
{
	if (clevel != '') {
		document.all(clevel).className = 'tz';
		document.all('d'+clevel).style.display = 'none';
	}
	clevel = nm || 'L1';
	document.all(clevel).className = 'tzSet';
	document.all('d'+clevel).style.display = 'inline';
}

function show_priems_info(req, title, description)
{
    var t = ['hit', 'krit', 'block', 'uvarot', 'hp','all','parry'];
    var text = '';
    text += '<b>' + title;
    text += '</b><br />';
    for (i in req) 
    {
        if (!req[i]) 
        {
            continue;
        }
        text += '<img src="img/priem/' + t[i] + '.gif"  alt="" />';
        text += '&nbsp;' + req[i] + '&nbsp;&nbsp;';
    }
    text += '<br /><br />' + description;
    slot_view(text);
}
</SCRIPT>
<?

$bron_head=$db["bron_head"];
$bron_corp=$db["bron_corp"];
$bron_arm=$db["bron_arm"];
$bron_poyas=$db["bron_poyas"];
$bron_legs=$db["bron_legs"];

$mf_krit=$db["krit"];
$mf_uvorot=$db["uvorot"];
$mf_antikrit = $db["akrit"];
$mf_antiuvorot = $db["auvorot"];
$parry = $db["parry"];
$counter = $db["counter"];
$proboy = $db["proboy"];

$phisic_vl=$db["phisic_vl"];
$sword_vl=$db["sword_vl"];
$axe_vl=$db["axe_vl"];
$hummer_vl=$db["hummer_vl"];
$castet_vl=$db["castet_vl"];
$copie_vl=$db["copie_vl"];
$shot_vl=$db["shot_vl"];
$staff_vl=$db["staff_vl"];

$water_magic = $db["water_magic"];
$earth_magic = $db["earth_magic"];
$fire_magic = $db["fire_magic"];
$air_magic = $db["air_magic"];
$svet_magic = $db["svet_magic"];
$tma_magic = $db["tma_magic"];
$gray_magic = $db["gray_magic"];

$hand_r_hitmin=$db["hand_r_hitmin"];
$hand_l_hitmin=$db["hand_l_hitmin"];
$hand_r_hitmax=$db["hand_r_hitmax"];
$hand_l_hitmax=$db["hand_l_hitmax"];

$protect_rej=$db["protect_rej"];
$protect_drob=$db["protect_drob"];
$protect_kol=$db["protect_kol"];
$protect_rub=$db["protect_rub"];

$protect_fire=$db["protect_fire"];
$protect_water=$db["protect_water"];
$protect_air=$db["protect_air"];
$protect_earth=$db["protect_earth"];
$protect_svet=$db["protect_svet"];
$protect_tma=$db["protect_tma"];
$protect_gray=$db["protect_gray"];

$shieldblock=$db["protect_gray"];
 	 	 	
$mf_rub=$db["add_rub"];
$mf_kol=$db["add_kol"];
$mf_drob=$db["add_drob"];
$mf_rej=$db["add_rej"];

$ms_udar=$db["ms_udar"];
$ms_krit=$db["ms_krit"];

$ms_rub=$db["ms_rub"];
$ms_kol=$db["ms_kol"];
$ms_drob=$db["ms_drob"];
$ms_rej=$db["ms_rej"];

$ms_mag=$db["ms_mag"];					
$ms_fire=$db["ms_fire"];
$ms_water=$db["ms_water"];
$ms_air=$db["ms_air"];
$ms_earth=$db["ms_earth"];
$ms_svet=$db["ms_svet"];
$ms_tma=$db["ms_tma"];
$ms_gray=$db["ms_gray"];	

$k1=mysql_fetch_array(mysql_query("SELECT is_modified, add_rej, add_drob, add_kol, add_rub FROM `inv` WHERE id=".$db["hand_r"]));
$k2=mysql_fetch_array(mysql_query("SELECT is_modified, add_rej, add_drob, add_kol, add_rub FROM `inv` WHERE id=".$db["hand_l"]));

$mf_rub1= $k1["add_rub"];
$mf_kol1= $k1["add_kol"];
$mf_drob1=$k1["add_drob"];
$mf_rej1= $k1["add_rej"];

$mf_rub2= $k2["add_rub"];
$mf_kol2= $k2["add_kol"];
$mf_drob2=$k2["add_drob"];
$mf_rej2= $k2["add_rej"];

$is_modified1=$k1['is_modified1'];
$is_modified2=$k2['is_modified2'];

?>
<TABLE border=0 cellspacing=0 cellpadding=0 width=100% >
<tr>
	<td nowrap>
	<?
		echo "<font color=#ff0000>".$msg."</font>";
		echo "<script>drwfl('".$db['login']."','".$db['id']."','".$db['level']."','".$db['dealer']."','".$db['orden']."','".$db['admin_level']."','".$db['clan_short']."','".$db['clan']."');</script>";
	?>
	</td>
	<td align=right valign=top nowrap>
    	<INPUT TYPE=button class="newbut" value="��������" onClick="location.href='main.php?act=char&sl='+clevel">
		<INPUT TYPE=button class="newbut" value="���������" onClick="location.href='main.php?act=inv';">
	</td>
</tr>
</table>
<TABLE border=0 cellspacing=0 cellpadding=0 width=100% height=400>
<tr>
	<TD width=30% valign=top>
		<TABLE border=0 cellspacing=1 cellpadding=0 width=100%>
			<TR><TD class='tzSet' height=20>&nbsp;&nbsp;��������� ���������</TD></tr>
			<TR><TD style='padding-left: 5'>
			<TABLE cellSpacing=0>
				<TR id="str" onmousedown="ChangeSkill(event,this)" onmouseup="DropTimer()" onclick="OnClick(event,this);">
					<TD>� ����: </TD>
					<TD width=40 class="skill" align="right" wdth=30><?=($db['sila']+$effect["add_sila"])?><BR></small></TD>
					<TD width=60 noWrap></TD>
					<TD><IMG id="minus_str" SRC=img/minus.gif class="nonactive" ALT="���������">&nbsp;<IMG SRC=img/pluss.gif class=skill ALT="���������" id="plus_str"></TD>
				</TR>
				<TR id="dex" onmousedown="ChangeSkill( event, this )" onmouseup="DropTimer()"  onclick="OnClick(event,this);">
					<TD>� ��������: </TD>
					<TD width=40 class="skill" align="right" wdth=30><?=($db['lovkost']+$effect["add_lovkost"])?><BR></small></TD>
					<TD width=60 noWrap></TD>
					<TD><IMG id="minus_dex" SRC=img/minus.gif class="nonactive" ALT="���������">&nbsp;<IMG SRC=img/pluss.gif class=skill ALT="���������" id="plus_dex"></TD>
				</TR>
				<TR id="inst" onmousedown="ChangeSkill( event, this )" onmouseup="DropTimer()"  onclick="OnClick(event,this);">
					<TD>� �����: </TD>
					<TD width=40 class="skill" align="right" wdth=30><?=($db['udacha']+$effect["add_udacha"])?><BR></small></TD>
					<TD width=60 noWrap></TD>
					<TD><IMG id="minus_inst" SRC=img/minus.gif class="nonactive" ALT="���������">&nbsp;<IMG SRC=img/pluss.gif class=skill ALT="���������" id="plus_inst"></TD>
				</TR>
				<TR id="power" onmousedown="ChangeSkill( event, this )" onmouseup="DropTimer()"  onclick="OnClick(event,this);">
					<TD>� ������������: </TD>
					<TD width=40 class="skill" align="right" wdth=30><?=$db['power']?><BR></small></TD>
					<TD width=60 noWrap></TD>
					<TD><IMG id="minus_power" SRC=img/minus.gif class="nonactive" ALT="���������">&nbsp;<IMG SRC=img/pluss.gif class=skill ALT="���������"  id="plus_power"></TD>
				</TR>
				<?php
				if ($db['level'] > 1) 
				{
					?>
					<TR id="intel" onmousedown="ChangeSkill( event, this )" onmouseup="DropTimer()"  onclick="OnClick(event,this);">
						<TD>� ���������: </TD>
						<TD width=40 class="skill" align="right" wdth=30><?=($db['intellekt']+$effect["add_intellekt"])?></TD>
						<TD width=60 noWrap></TD>
						<TD><IMG id="minus_intel" SRC=img/minus.gif class="nonactive" ALT="���������">&nbsp;<IMG SRC=img/pluss.gif class=skill ALT="���������"  id="plus_intel"></TD>
					</TR>
					<TR id="wis" onmousedown="ChangeSkill( event, this )" onmouseup="DropTimer()"  onclick="OnClick(event,this);">
						<TD>� ����������: </TD>
						<TD width=40 class="skill" align="right" wdth=30><?=$db['vospriyatie']?></TD>
						<TD width=60 noWrap></TD>
						<TD><IMG id="minus_wis" SRC=img/minus.gif class="nonactive" ALT="���������">&nbsp;<IMG SRC=img/pluss.gif class=skill ALT="���������"  id="plus_wis"></TD>
					</TR>
					<?
				}
				if ($db['level'] > 9)
				{
					?>
					<TR id="duxa" onmousedown="ChangeSkill( event, this )" onmouseup="DropTimer()"  onclick="OnClick(event,this);">
						<TD>� ����������: </TD>
						<TD width=40 class="skill" align="right" wdth=30><?=$db['duxovnost']?></TD>
						<TD width=60 noWrap></TD>
						<TD><IMG id="minus_duxa" SRC=img/minus.gif class="nonactive" ALT="���������">&nbsp;<IMG SRC=img/pluss.gif class=skill ALT="���������"  id="plus_duxa"></TD>
					</TR>
					<?
				} 
				?>
				</td></tr>
			</table>
			<INPUT type="button" value="���������" disabled="disabled"  id="save_button0" onclick="SaveSkill();"> <INPUT type="checkbox" onClick="ChangeButtonState(0);">
			<?	
				if($db["ups"])
				{ 
					echo "<br><FONT COLOR=green>��������� ����������:  <b id=UP>".$db["ups"]."</b></FONT>";
				}
				if($db["umenie"])
				{
					echo "<br><FONT COLOR=green>��������� ������: <b>".$db["umenie"]."</b></FONT><br>";	
				}
			?>
			<SCRIPT> 
				var nUP = <?=$db['ups']?>;
				var oUP = document.getElementById( "UP" );
				var arrChange = { };
				var arrMin = {str: 5, dex: 5, inst: 5, power: 5};

				function SetAllSkills(isOn) 
				{
					var arrSkills = new Array("str", "dex", "inst", "power", "intel", "wis");
					for (var i in arrSkills) 
					{
						var clname = ( isOn ) ? "skill" : "nonactive";
						if( oNode = document.getElementById( "plus_" + arrSkills[i] ) ) oNode.className=clname;
					}
				}
				var t;
				function OnClick(eEvent, This) 
				{
					DropTimer();
					var oNode = eEvent.target || eEvent.srcElement;
					if( oNode.nodeName != "IMG" ) return;
					var nDelta = ( oNode.nextSibling ) ? -1 : 1;
					MakeSkillStep(nDelta, This, 0);
				}
				function DropTimer() 
				{
					if (t) 
					{
						clearTimeout(t);
						t = 0;
					}
				}
				function ChangeSkill( eEvent, This ) 
				{
					var oNode = eEvent.target || eEvent.srcElement;
					if( oNode.nodeName != "IMG" ) return;
					var nDelta = ( oNode.nextSibling ) ? -1 : 1;
					t=setTimeout(function() {MakeSkillStep(nDelta, This, 1)}, 500);
				}
				function MakeSkillStep(nDelta, This, IsRecurse) 
				{
					if ((nUP - nDelta ) < 0) return;
					var id = This.id;
					if (!arrChange[ id ]) arrChange[ id ] = 0;
					if ((arrChange[ id ] + nDelta) < 0 ) 
					{
						if (oNode = document.getElementById( "minus_" + id ))
						oNode.className = "nonactive";
						return;
					}
					SetAllSkills(( nUP - nDelta ));
					arrChange[ id ] += nDelta;
					This.cells[ 1 ].innerHTML = parseFloat( This.cells[ 1 ].innerHTML ) + nDelta;
					if( oNode = document.getElementById( id + "_inst" ) )
					oNode.innerHTML = parseFloat( oNode.innerHTML ) + nDelta;
					oUP.innerHTML = nUP -= nDelta;
					if ( !arrChange[ id ] ) 
					{
						if( oNode = document.getElementById( "minus_" + id ) ) oNode.className = "nonactive";
					} 
					else 
					{
						if( oNode = document.getElementById( "minus_" + id ) ) oNode.className = "skill";
					}
					if (IsRecurse) t = setTimeout(function(){MakeSkillStep(nDelta, This, 1)}, 50);
				}
				
				function SaveSkill( This ) 
				{
					var sHref = "main.php?act=char&edit=save";
					for( var i in arrChange )
					if( arrChange[ i ] > 0 )
					sHref += "&" + i + "=" + arrChange[ i ];
					document.location.href=sHref;
					return true;
				}
				function ChangeButtonState(bid) 
				{
					var button = document.getElementById( "save_button"+bid );
					if (button.disabled) 
					{
						button.disabled = 0;
					} 
					else 
					{
						button.disabled = 1;
					}
				}
			</SCRIPT>
			</td></tr>
		</TABLE>
	</td>
	<td width=1 bgcolor=#A0A0A0><span></span></td>
	<td valign=top>
		<TABLE border=0 cellspacing=1 cellpadding=0 width=100%>
		<TR>
			<TD align=center height=20 class=tz id=L1 onmouseover="highl('L1',1)"  onmouseout="highl('L1',0)"  onclick="setlevel('L1')">������ � ������������</TD>
			<TD align=center height=20 class=tz id=L2 onmouseover="highl('L2',1)"  onmouseout="highl('L2',0)"  onclick="setlevel('L2')">���������� ��������</TD>
			<TD align=center height=20 class=tz id=L4 onmouseover="highl('L4',1)"  onmouseout="highl('L4',0)"  onclick="setlevel('L4')">���������</TD>
			<TD align=center height=20 class=tz id=L5 onmouseover="highl('L5',1)"  onmouseout="highl('L5',0)"  onclick="setlevel('L5')">�����</TD>
			<TD align=center height=20 class=tz id=L6 onmouseover="highl('L6',1)"  onmouseout="highl('L6',0)"  onclick="setlevel('L6')">�������� ������</TD>
			<TD align=center height=20 class=tz id=L7 onmouseover="highl('L7',1)"  onmouseout="highl('L7',0)"  onclick="setlevel('L7')">���������</TD>
			<TD height=20 class=tz>&nbsp;</TD>
		</TR>
		</TABLE>
		<table border=0 cellpadding=0 cellspacing=6 width=100% height=300>
		<tr>
		<td  valign=top style='padding-left: 7'>
		<div class=dtz ID=dL1>
			<table cellspacing="0" cellpadding="0" border="0">
			<tr>
				<td valign=top align=left width=350 nowrap>
					<b>������</b><br>
					&nbsp;� ����� ������: <b>	<?=ceil($bron_head);?></b><br>
					&nbsp;� ����� �������: <b>	<?=ceil($bron_corp);?></b><br>
					&nbsp;� ����� �����: <b>	<?=ceil($bron_poyas);?></b><br>
					&nbsp;� ����� ���: <b>		<?=ceil($bron_legs);?></b><br><br>
					
					&nbsp;� ������ �� �������� �����: <b><?=ceil($protect_rej+$effect["p_rej"]);?></b><br>
					&nbsp;� ������ �� ��������� �����:<b><?=ceil($protect_drob+$effect["p_drob"]);?></b><br>
					&nbsp;� ������ �� �������� �����: <b><?=ceil($protect_kol+$effect["p_kol"]);?></b><br>
					&nbsp;� ������ �� �������� �����: <b><?=ceil($protect_rub+$effect["p_rub"]);?></b><br><br>
				
					&nbsp;� ������ �� �����: <b><?=ceil($db["protect_udar"]+$effect["add_bron"]+$db["power"]*1.5);?></b><br>
					&nbsp;� ������ �� �����: <b><?=ceil($db["protect_mag"]+$effect["add_mg_bron"]+$db["power"]*1.5);?></b><br><br>
					
					&nbsp;� ��������� ������ �� ����� ����: 	<b><?=ceil($protect_fire+$effect["protect_fire"]);?></b><br>
					&nbsp;� ��������� ������ �� ����� ����: 	<b><?=ceil($protect_water+$effect["protect_water"]);?></b><br>
					&nbsp;� ��������� ������ �� ����� �������: 	<b><?=ceil($protect_air+$effect["protect_air"]);?></b><br>
					&nbsp;� ��������� ������ �� ����� �����: 	<b><?=ceil($protect_earth+$effect["protect_earth"]);?></b><br>
					&nbsp;� ��������� ������ �� ����� �����: 	<b><?=ceil($protect_svet+$effect["protect_svet"]);?></b><br>
					&nbsp;� ��������� ������ �� ����� ����: 	<b><?=ceil($protect_tma+$effect["protect_tma"]);?></b><br>
					&nbsp;� ��������� ������ �� ����� �����: 	<b><?=ceil($protect_gray+$effect["protect_gray"]);?></b><br><br>
						
					&nbsp;� ��.����� �����: <b><?=ceil($shieldblock+$shieldblock*$effect["shieldblock"]/100);?></b><br><br>


				</td>
				<td  valign=top align=left>
					<? 
						$krit=$mf_krit+5*($db["udacha"]+$effect["add_udacha"])+$effect["add_krit"]; 
						$antikrit=$mf_antikrit+5*($db["udacha"]+$effect["add_udacha"])+$effect["add_akrit"]; 
						$uvorot=$mf_uvorot+5*($db["lovkost"]+$effect["add_lovkost"])+$effect["add_uvorot"];
						$antiuvorot=$mf_antiuvorot+5*($db["lovkost"]+$effect["add_lovkost"])+$effect["add_auvorot"];
						$db["sila"]=$db["sila"]+$effect["add_sila"];
						
						$udar_min1=$hand_r_hitmin+($db["sila"]+ceil($db["sila"]*0.4))+(int)(0+$is_modified1);
						$udar_max1=$hand_r_hitmax+($db["sila"]+ceil($db["sila"]*0.8))+(int)(0+$is_modified1);
						$udar_min2=$hand_l_hitmin+($db["sila"]+ceil($db["sila"]*0.4))+(int)(0+$is_modified2);
						$udar_max2=$hand_l_hitmax+($db["sila"]+ceil($db["sila"]*0.8))+(int)(0+$is_modified2); 
					?>
					<b>������������</b><br>
					&nbsp;� ����: <b><?echo "$udar_min1-$udar_max1".(($db["hand_l_type"]!="phisic" && $db["hand_l_type"]!="shield")?" / $udar_min2-$udar_max2":"");?></b><br>
					&nbsp;� ��. ����. �����: <b><?echo $krit;?></b><br>
					&nbsp;� ��. ������ ����. �����: <b><?echo $antikrit;?></b><br>
					&nbsp;� ��. �����������: <b><?echo $uvorot;?></b><br>
					&nbsp;� ��. ������ �����������: <b><?echo $antiuvorot;?></b><br>
					&nbsp;� ��. �����������: <b><?echo ($parry+5);?></b><br>
					&nbsp;� ��. ����������: <b><?echo ($counter+10) ;?></b><br>
					&nbsp;� ��. ������ �����: <b><?echo ($proboy+5) ;?></b><br><br>

					&nbsp;� ��. �������� �����: <b><?echo (int)$ms_udar;?></b><br>
					&nbsp;� ��. �������� ������������ �����: <b><?echo (int)$ms_krit;?></b><br><br>
							
					&nbsp;� ��. �������� ������� �����: <b><?echo (int)$ms_rub;?></b><br>
					&nbsp;� ��. �������� �������� �����: <b><?echo (int)$ms_kol;?></b><br>
					&nbsp;� ��. �������� ��������� �����: <b><?echo (int)$ms_drob;?></b><br>
					&nbsp;� ��. �������� �������� �����: <b><?echo (int)$ms_rej;?></b><br><br>
					
					&nbsp;� ��. ������� �����: <b><?echo (int)$mf_rub1;?></b>-<b><?echo (int)$mf_rub2;?></b><br>
					&nbsp;� ��. �������� �����: <b><?echo (int)$mf_kol1;?></b>-<b><?echo (int)$mf_kol2;?></b><br>
					&nbsp;� ��. ��������� �����: <b><?echo (int)$mf_drob1;?></b>-<b><?echo (int)$mf_drob2;?></b><br>
					&nbsp;� ��. �������� �����: <b><?echo (int)$mf_rej1;?></b>-<b><?echo (int)$mf_rej2;?></b><br><br>
					<?
						if (($db['intellekt']+$effect["add_intellekt"])>=125) 	    $add_ms_mag=25;
						else if (($db['intellekt']+$effect["add_intellekt"])>=100) 	$add_ms_mag=20;
						else if (($db['intellekt']+$effect["add_intellekt"])>=75) 	$add_ms_mag=15;
						else if (($db['intellekt']+$effect["add_intellekt"])>=50) 	$add_ms_mag=10;
						else if (($db['intellekt']+$effect["add_intellekt"])>=25)	$add_ms_mag=5;
						$add_ms_mag=$add_ms_mag+($db['intellekt']+$effect["add_intellekt"])*0.5
					?>
					&nbsp;� ��. �������� �����: <b><?echo (int)($ms_mag+$add_ms_mag);?></b><br>
					&nbsp;� ��. �������� ����� ����: <b><?echo (int)($ms_fire+$add_ms_mag);?></b><br>
					&nbsp;� ��. �������� ����� ����: <b><?echo (int)($ms_water+$add_ms_mag);?></b><br>
					&nbsp;� ��. �������� ����� �������: <b><?echo (int)($ms_air+$add_ms_mag);?></b><br>
					&nbsp;� ��. �������� ����� �����: <b><?echo (int)($ms_earth+$add_ms_mag);?></b><br>
					&nbsp;� ��. �������� ����� �����: <b><?echo (int)($ms_svet+$add_ms_mag);?></b><br>
					&nbsp;� ��. �������� ����� ����: <b><?echo (int)($ms_tma+$add_ms_mag);?></b><br>
					&nbsp;� ��. �������� ����� �����: <b><?echo (int)($ms_gray+$add_ms_mag);?></b><br><br>
	
					
			      </td>
			</tr>
			</table>
    	</div>
		
		<div class=dtz ID=dL2>
			<table cellspacing="0" cellpadding="0" border="0" width=100%>
			<tr>
				<td>
					<table>
						<tr><td colspan="3"><b>������:</b></td></tr>
						<tr><td>&nbsp;� ���������� �������� ������:</td><td>&nbsp;</td><td><b>				<?echo ($sword_vl+$effect["add_sword_vl"]+$db["add_oruj"]);		if($db["umenie"]){echo " <a href='?act=char&do=umenie&stat=sword_vl&sl=L2'><img src='img/icon/plus.gif' border=0 alt='���������'></a>";}?></font></b></td></tr>
						<tr><td>&nbsp;� ���������� �������� ������, ���������:</td><td>&nbsp;</td><td><b>	<?echo ($castet_vl+$effect["add_castet_vl"]+$db["add_oruj"]);	if($db["umenie"]){echo " <a href='?act=char&do=umenie&stat=castet_vl&sl=L2'><img src='img/icon/plus.gif' border=0 alt='���������'></a>";}?></font></b></td></tr>
						<tr><td>&nbsp;� ���������� �������� ��������, ��������:</td><td>&nbsp;</td><td><b>	<?echo ($axe_vl+$effect["add_axe_vl"]+$db["add_oruj"]);			if($db["umenie"]){echo " <a href='?act=char&do=umenie&stat=axe_vl&sl=L2'><img src='img/icon/plus.gif' border=0 alt='���������'></a>";}?></font></b></td></tr>
						<tr><td>&nbsp;� ���������� �������� ��������, ��������:</td><td>&nbsp;</td><td><b>	<?echo ($hummer_vl+$effect["add_hummer_vl"]+$db["add_oruj"]);	if($db["umenie"]){echo " <a href='?act=char&do=umenie&stat=hummer_vl&sl=L2'><img src='img/icon/plus.gif' border=0 alt='���������'></a>";}?></font></b></td></tr>
						<tr><td>&nbsp;� ���������� �������� ���������� ��������:</td><td>&nbsp;</td><td><b>	<?echo ($copie_vl+$effect["add_copie_vl"]+$db["add_oruj"]);		if($db["umenie"]){echo " <a href='?act=char&do=umenie&stat=copie_vl&sl=L2'><img src='img/icon/plus.gif' border=0 alt='���������'></a>";}?></font></b></td></tr>
						<tr><td>&nbsp;� ���������� �������� ��������:</td><td>&nbsp;</td><td><b>			<?echo ($staff_vl+$effect["add_staff_vl"]);		if($db["umenie"]){echo " <a href='?act=char&do=umenie&stat=staff_vl&sl=L2'><img src='img/icon/plus.gif' border=0 alt='���������'></a>";}?></font></b></td></tr>
						<tr><td colspan="3"><br><b>�����:</b></td></tr>
						<tr><td>&nbsp;� ���������� �������� ������� ����:</td><td>&nbsp;</td><td><b>		<?echo ($fire_magic+$effect["add_fire_magic"]);if($db["umenie"]){echo " <a href='?act=char&do=umenie&stat=fire_magic&sl=L2'><img src='img/icon/plus.gif' border=0 alt='���������'></a>";}?></font></b></td></tr>
						<tr><td>&nbsp;� ���������� �������� ������� �����:</td><td>&nbsp;</td><td><b>		<?echo ($earth_magic+$effect["add_earth_magic"]);if($db["umenie"]){echo " <a href='?act=char&do=umenie&stat=earth_magic&sl=L2'><img src='img/icon/plus.gif' border=0 alt='���������'></a>";}?></font></b></td></tr>
						<tr><td>&nbsp;� ���������� �������� ������� ����:</td><td>&nbsp;</td><td><b>		<?echo ($water_magic+$effect["add_water_magic"]);if($db["umenie"]){echo " <a href='?act=char&do=umenie&stat=water_magic&sl=L2'><img src='img/icon/plus.gif' border=0 alt='���������'></a>";}?></font></b></td></tr>
						<tr><td>&nbsp;� ���������� �������� ������� �������:</td><td>&nbsp;</td><td><b>		<?echo ($air_magic+$effect["add_air_magic"]);if($db["umenie"]){echo " <a href='?act=char&do=umenie&stat=air_magic&sl=L2'><img src='img/icon/plus.gif' border=0 alt='���������'></a>";}?></font></b></td></tr>
						<tr><td>&nbsp;� ���������� �������� ������� �����:</td><td>&nbsp;</td><td><b>		<?echo ($svet_magic+$effect["add_svet_magic"]);if($db["umenie"]){echo " <a href='?act=char&do=umenie&stat=svet_magic&sl=L2'><img src='img/icon/plus.gif' border=0 alt='���������'></a>";}?></font></b></td></tr>
						<tr><td>&nbsp;� ���������� �������� ������� ����:</td><td>&nbsp;</td><td><b>		<?echo ($tma_magic+$effect["add_tma_magic"]);if($db["umenie"]){echo " <a href='?act=char&do=umenie&stat=tma_magic&sl=L2'><img src='img/icon/plus.gif' border=0 alt='���������'></a>";}?></font></b></td></tr>
						<tr><td>&nbsp;� ���������� �������� ����� �����:</td><td>&nbsp;</td><td><b>		<?echo ($gray_magic+$effect["add_gray_magic"]);if($db["umenie"]){echo " <a href='?act=char&do=umenie&stat=gray_magic&sl=L2'><img src='img/icon/plus.gif' border=0 alt='���������'></a>";}?></font></b></td></tr>

					
					</table>	
				</td>
			</tr>
			</table>
		</div>
		<div class=dtz ID=dL6>
			<DIV style='padding-left: 10'>
			<?
					if ($db["sila"]+$effect["add_sila"]>=125) 	    echo "<B>���� �������</B><BR>� ������������ ��������� �����������: 10<br>� ����������� ��������� �����������: 10<br>� ��. �������� �����: 25<BR><BR>";
					else if ($db["sila"]+$effect["add_sila"]>=100) 	echo "<B>���� �������</B><BR>� ��. �������� �����: 25<BR><BR>";
					else if ($db["sila"]+$effect["add_sila"]>=75) 	echo "<B>���� �������</B><BR>� ��. �������� �����: 17<BR><BR>";
					else if ($db["sila"]+$effect["add_sila"]>=50) 	echo "<B>���� �������</B><BR>� ��. �������� �����: 10<BR><BR>";
					else if ($db["sila"]+$effect["add_sila"]>=25) 	echo "<B>���� �������</B><BR>� ��. �������� �����: 5<BR><BR>";
					
					if ($db["lovkost"]+$effect["add_lovkost"]>=125) 	    echo "<B>�������� �����</B><BR>� ��. ������ ������������ ����� (%): 40<br>� ��. ����������� (%): 15<br>� ��. ����������� (%): 120<BR><BR>";
					else if ($db["lovkost"]+$effect["add_lovkost"]>=100) 	echo "<B>�������� �����</B><BR>� ��. ������ ������������ ����� (%): 40<br>� ��. ����������� (%): 15<br>� ��. ����������� (%): 105<BR><BR>";
					else if ($db["lovkost"]+$effect["add_lovkost"]>=75) 	echo "<B>�������� �����</B><BR>� ��. ������ ������������ ����� (%): 15<br>� ��. ����������� (%): 15<br>� ��. ����������� (%): 35<BR><BR>";
					else if ($db["lovkost"]+$effect["add_lovkost"]>=50) 	echo "<B>�������� �����</B><BR>� ��. ������ ������������ ����� (%): 15<br>� ��. ����������� (%): 5<br>� ��. ����������� (%): 35<BR><BR>";
					else if ($db["lovkost"]+$effect["add_lovkost"]>=25) 	echo "<B>�������� �����</B><BR>� ��. ����������� (%): 5<BR><BR>";
					
					if($db["udacha"]+$effect["add_udacha"]>=125) 		echo "<B>���������� �������</B><BR>� ��. ������������ ����� (%): 120<br>� ��. �������� ����. ����� (%): 25<br>� ��. ������ ����������� (%): 45<BR><BR>";
					else if ($db["udacha"]+$effect["add_udacha"]>=100) 	echo "<B>���������� �������</B><BR>� ��. ������������ ����� (%): 105<br>� ��. �������� ����. ����� (%): 25<br>� ��. ������ ����������� (%): 45<BR><BR>";
					else if ($db["udacha"]+$effect["add_udacha"]>=75) 	echo "<B>���������� �������</B><BR>� ��. ������������ ����� (%): 35<br>� ��. �������� ����. ����� (%): 25<br>� ��. ������ ����������� (%): 15<BR><BR>";
					else if ($db["udacha"]+$effect["add_udacha"]>=50) 	echo "<B>���������� �������</B><BR>� ��. ������������ ����� (%): 35<br>� ��. �������� ����. ����� (%): 10<br>� ��. ������ ����������� (%): 15<BR><BR>";
					else if ($db["udacha"]+$effect["add_udacha"]>=25)	echo "<B>���������� �������</B><BR>� ��. �������� ����. ����� (%): 10<BR><BR>";
					
					if ($db["power"]>=125) 		echo "<B>������ ��������</B><BR>� 25% ������ �� �����<BR>� 25% ������ �� �����<BR><BR>";
					else if ($db["power"]>=100)	echo "<B>������ ��������</B><BR>� 20% ������ �� �����<BR>� 20% ������ �� �����<BR><BR>";
					else if ($db["power"]>=75)	echo "<B>������ ��������</B><BR>� 15% ������ �� �����<BR>� 15% ������ �� �����<BR><BR>";
					else if ($db["power"]>=50)	echo "<B>������ ��������</B><BR>� 10% ������ �� �����<BR>� 10% ������ �� �����<BR><BR>";
					else if ($db["power"]>=25)	echo "<B>������ ��������</B><BR>� 5% ������ �� ����� <BR>� 5% ������ �� �����<BR><BR>";
					
					if ($db["intellekt"]+$effect["add_intellekt"]>=125)			echo "<B>������� ������</B><BR>� �������� ����� ������ +25%<BR><BR>";
					else if ($db["intellekt"]+$effect["add_intellekt"]>=100)	echo "<B>������� ������</B><BR>� �������� ����� ������ +20%<BR><BR>";
					else if ($db["intellekt"]+$effect["add_intellekt"]>=75) 	echo "<B>������� ������</B><BR>� �������� ����� ������ +15%<BR><BR>";
					else if ($db["intellekt"]+$effect["add_intellekt"]>=50) 	echo "<B>������� ������</B><BR>� �������� ����� ������ +10%<BR><BR>";
					else if ($db["intellekt"]+$effect["add_intellekt"]>=25) 	echo "<B>������� ������</B><BR>� �������� ����� ������ +5%<BR><BR>";
			?>
			</div>
			<BR><BR><small><font color=red>��������!</font> ��������, � �������� ����� �� ������ ����� ������ 50, ������ �������� �� ���� �����. 
			������������ ����� ����� ������ �� ���������� ������. 
			������ �� ������ � ���� �� ����� �� �����������, � ���������� ����� ����������. 
			(������: ���� �� ������ 100 ���� �� � ��� ����� +10% � ���������� �����, � �� 10%+5%.)</small><br>
		</div>
		<div class=dtz ID=dL7>
			<?
				$pr_sql=mysql_query("SELECT title,navika FROM person_proff LEFT JOIN academy on academy.id=person_proff.proff WHERE person=".$db["id"]);
				if (mysql_num_rows($pr_sql))
				{	
					echo "<b>���������</b><br>";
					while($pr=mysql_fetch_array($pr_sql))
					{
						echo "&nbsp;� ".$pr["title"].": <b>".$pr["navika"]."</b><br>";
					}
				}
				else echo "��� ���������";
			?>
		</div>		
		<div class=dtz ID=dL4>
			<table cellspacing="0" cellpadding="0" border="0" width=100%>
			<tr>
				<td valign=top align=left>
					<?
						$s=mysql_query("SELECT * FROM effects LEFT JOIN scroll on scroll.id=effects.elik_id WHERE end_time>".time()." and effects.user_id=".$db["id"]);
						if (mysql_num_rows($s))
						{	
							while ($sc=mysql_fetch_array($s))
							{
								echo "<img src='img/".$sc["img"]."' border=0 title='".$sc["name"]."\n".$sc["descs"]."\n"."��� ".convert_time($sc['end_time'])."'>&nbsp;";
							}
							echo "<br><br>";
						}
						if (ceil($db['cure']))
						{						
							echo "�������������� HP (%) + ".ceil($db['cure'])." (�������� ����������� [".ceil($db['cure'])."])<BR><BR>";
						}
						if($db["vip"]>time())
						{
							echo "<img src='img/naqrada/vip.gif' border=0 alt='V.I.P ���� WWW.MEYDAN.AZ.'>V.I.P ���� WWW.MEYDAN.AZ - ���: ".convert_time($db["vip"])."<BR><BR>";
						}
						if($db["travm"]!=0)
						{
							$travm=$db["travm_var"];
							$kstat=$db["travm_stat"];
							$stats=$db["travm_old_stat"];
							if($travm==1){$travm="������ ������";}
							else if($travm==2){$travm="������� ������";}
							else if($travm==3){$travm="������� ������";}
							else if($travm==4){$travm="��������� ������";}
							if($kstat=="sila"){$kstat="����";}
							else if($kstat=="lovkost"){$kstat="��������";}
							else if($kstat=="udacha"){$kstat="��������";}
							else if($kstat=="intellekt"){$kstat="���������";}
							
							echo "<img src=img/index/travma.gif border=0> ";
							echo "� ��������� <B>$travm.</B> ";
							echo "���������� �������������� <B style='color:#ff0000'>$kstat-$stats</B> ";
							echo "(��� ".convert_time($db['travm']).")<BR><br>";
						}
						if($db["oslab"]>time())
					   	{
							echo "<img src=img/index/travma.gif border=0> ";
							echo "�������� �������� ��-�� ������ � ���, ��� ".convert_time($db['oslab'])."<BR><BR>"; 
						}
						if($db["shut"]>time())
					   	{							
							echo "<img src=img/index/molch.gif border=0> ";
							echo "������ ��� ".convert_time($db['shut'])."<BR><BR>"; 
						}
						if($db["travm_protect"]>time())
					   	{							
							echo "<img src='img/index/travm_protect.gif'>";
							echo "<b>���������� �����������:</b> ������ �� �����, ��� ".convert_time($db['travm_protect'])."<BR><BR>"; 
						}
					?>
				</td>
			</tr>
			</table>
		</div>
		<div class=dtz ID=dL5>
			<table cellspacing="0" cellpadding="0" border="0" width=400>
			<tr>
				<td valign=top align=left>
					<?
						if (($_GET["action"]=="onset_priem") && is_numeric($_GET["id"]))
						{
							$id=(int)$_GET["id"];
							$res=mysql_query("SELECT * FROM priem WHERE id=$id and view=0");
							if (mysql_num_rows($res))
							{
								$result=mysql_fetch_array($res);
								if ($db["level"] < $result["level"]) $msg="������� ������� ���!";
								else if ($db['intellekt']+$effect["add_intellekt"] < $result["intellekt"]) $msg="��������� ���. ��������� ".$result["intellekt"];
								else if ($db["vospriyatie"] < $result["vospriyatie"]) $msg="��������� ���. ���������� ".$result["vospriyatie"];								
								else if ($db["fire_magic"]+$effect["add_fire_magic"] < $result["fire_magic"]) $msg="��������� ���������� �������� ������� ���� ".$result["fire_magic"];
								else if ($db["earth_magic"]+$effect["add_earth_magic"] < $result["earth_magic"]) $msg="��������� ���������� �������� ������� ����� ".$result["earth_magic"];
								else if ($db["water_magic"]+$effect["add_water_magic"] < $result["water_magic"]) $msg="��������� ���������� �������� ������� ���� ".$result["water_magic"];
								else if ($db["air_magic"]+$effect["add_air_magic"] < $result["air_magic"]) $msg="��������� ���������� �������� ������� ������� ".$result["air_magic"];
								
								else if ($db["svet_magic"]+$effect["add_svet_magic"] < $result["svet_magic"]) $msg="���������� �������� ������� ����� ".$result["svet_magic"];
								else if ($db["tma_magic"]+$effect["add_tma_magic"] < $result["tma_magic"]) $msg="���������� �������� ������� ���� ".$result["tma_magic"];
								else if ($db["gray_magic"]+$effect["add_gray_magic"] < $result["gray_magic"]) $msg="���������� �������� ����� ����� ".$result["gray_magic"];
								else
								{
									$sl_inf=mysql_fetch_array(mysql_query("SELECT count(*) FROM slots_priem WHERE priem_id=".$id." and user_id =".$db["id"]));
									if ($sl_inf[0])
									{
										$msg="������������ ���� ������";
									}
								 	else
								 	{
								 		$slot_inf=mysql_fetch_array(mysql_query("SELECT * FROM slots_priem WHERE priem_id=0 and user_id =".$db["id"]." ORDER BY sl_name ASC"));
								 		if (!$slot_inf)$slot_name = "sl1";
								 		else $slot_name = $slot_inf["sl_name"];
										mysql_query("UPDATE slots_priem SET priem_id=".$id." WHERE sl_name='".$slot_name."' and user_id =".$db["id"]);
									}
								}
							}
						}
						if ($_GET["action"]=="unset_priem")
						{
							$sl_name=htmlspecialchars(addslashes($_GET["sl_name"]));
							mysql_query("UPDATE slots_priem SET priem_id=0 WHERE sl_name='$sl_name' and user_id = ".$db["id"]);
						}
						if ($_GET["clear_abil"]=="all")
						{
							mysql_query("UPDATE slots_priem SET priem_id=0 WHERE user_id = ".$db["id"]);
						}
						$used_priem=array();
						echo "<font color=red>".$msg."</font>";
						echo "<table width=100%>
						<tr>
							<td valign=top><b>��������� ������ ��� ���: </b>";
								echo"<table><tr>";
								$aktiv_p = mysql_query("SELECT * FROM slots_priem LEFT JOIN priem on priem.id=slots_priem.priem_id WHERE user_id=".$db["id"]." ORDER BY sl_name ASC");
								while($aktiv_priem=mysql_fetch_array($aktiv_p))
								{
									$used_priem[]=(int)$aktiv_priem["priem_id"];
									echo "<td>";
									if ($aktiv_priem["priem_id"]!=0)
									{
										if 	($db["level"] >= $aktiv_priem["level"] &&
											($db['intellekt']+$effect["add_intellekt"] >= $aktiv_priem["intellekt"])&& 
											($db["vospriyatie"] >= $aktiv_priem["vospriyatie"])&& 			
											($db["fire_magic"]+$effect["add_fire_magic"] >= $aktiv_priem["fire_magic"])&& 
											($db["earth_magic"]+$effect["add_earth_magic"] >= $aktiv_priem["earth_magic"])&& 
											($db["water_magic"]+$effect["add_water_magic"] >= $aktiv_priem["water_magic"])&& 
											($db["air_magic"]+$effect["add_air_magic"] >= $aktiv_priem["air_magic"])&& 
											($db["svet_magic"]+$effect["add_svet_magic"] >= $aktiv_priem["svet_magic"])&& 
											($db["tma_magic"]+$effect["add_tma_magic"] >= $aktiv_priem["tma_magic"])&& 
											($db["gray_magic"]+$effect["add_gray_magic"] >= $aktiv_priem["gray_magic"]))
											{
												echo "\n<img src='img/priem/misc/".$aktiv_priem["id"].".gif' style='cursor:pointer' onclick=\"document.location='?act=char&action=unset_priem&sl_name=".$aktiv_priem["sl_name"]."&sl=L5&tmp=".time()."'\" onmouseover=\"show_priems_info([".$aktiv_priem["hit"].",".$aktiv_priem["krit"].",".$aktiv_priem["block"].",".$aktiv_priem["uvarot"].",".$aktiv_priem["hp"].",".$aktiv_priem["all_hit"].",".$aktiv_priem["parry"]."], '".$aktiv_priem["name"].($aktiv_priem["wait"]?"<br></b>��������: ".$aktiv_priem["wait"]:"")."', '<b>��������� �����������:</b>".($aktiv_priem["level"]?"<br>� �������: ".$aktiv_priem["level"]:"").($aktiv_priem["intellekt"]?"<br>� ���������: ".$aktiv_priem["intellekt"]:"").($aktiv_priem["vospriyatie"]?"<br>� ����������: ".$aktiv_priem["vospriyatie"]:"").($aktiv_priem["mana"]?"<br>� ������ ����: ".$aktiv_priem["mana"]:"").($aktiv_priem["hod"]?"<br>� ����� ������ ���":"").($aktiv_priem["water_magic"]?"<br>� ���������� �������� ������� ����: ".$aktiv_priem["water_magic"]:"").($aktiv_priem["earth_magic"]?"<br>� ���������� �������� ������� �����: ".$aktiv_priem["earth_magic"]:"").($aktiv_priem["fire_magic"]?"<br>� ���������� �������� ������� ����: ".$aktiv_priem["fire_magic"]:"").($aktiv_priem["air_magic"]?"<br>� ���������� �������� ������� �������: ".$aktiv_priem["air_magic"]:"").($aktiv_priem["svet_magic"]?"<br>� ���������� �������� ������� �����: ".$aktiv_priem["svet_magic"]:"").($aktiv_priem["tma_magic"]?"<br>� ���������� �������� ������� ����: ".$aktiv_priem["tma_magic"]:"").($aktiv_priem["gray_magic"]?"<br>� ���������� �������� ����� �����: ".$aktiv_priem["gray_magic"]:"")."<br><br>".$aktiv_priem["about"]."');\" onmouseout=\"slot_hide();\">\n";
											}
											else
											{
												mysql_query("UPDATE slots_priem SET priem_id=0 WHERE sl_name='".$aktiv_priem["sl_name"]."' and user_id = ".$db["id"]);	
												echo"<img src='img/priem/misc/clear.gif' alt='������ ����'>";
											}
									}
									else echo"<img src='img/priem/misc/clear.gif' alt='������ ����'>";
									echo "</td>";
								}
								echo"</tr></table>";
								echo "<br><a href='main.php?act=char&clear_abil=all&&sl=L5'>��������</a>";
							echo "</td>
						</tr>
						<tr>
							<td valign=top><br><b>����� ��� ������:</b><br>";	
							$all_priem = mysql_query("SELECT * FROM priem WHERE view=0 ORDER BY mag ASC, level ASC, type ASC");
							echo"<table border=0><tr>";
							$i=0;
							while ($a_p = mysql_fetch_array($all_priem))
							{
								if(($i % 15) == 0) echo "</tr>";
								echo "<td>\n<img src='img/priem/misc/".$a_p["id"].".gif' ".((in_Array($a_p["id"],$used_priem)||$db["level"] < $a_p["level"])?"style='filter:gray();'":"onclick=\"document.location='?act=char&action=onset_priem&id=$a_p[id]&sl=L5&tmp=".time()."'\" style='cursor:pointer;'")."  onmouseover=\"show_priems_info([".$a_p["hit"].",".$a_p["krit"].",".$a_p["block"].",".$a_p["uvarot"].",".$a_p["hp"].",".$a_p["all_hit"].",".$a_p["parry"]."], '".$a_p["name"].($a_p["wait"]?"<br></b>��������: ".$a_p["wait"]:"")."', '<b>��������� �����������:</b>".($a_p["level"]?"<br>� �������: ".$a_p["level"]:"").($a_p["intellekt"]?"<br>� ���������: ".$a_p["intellekt"]:"").($a_p["vospriyatie"]?"<br>� ����������: ".$a_p["vospriyatie"]:"").($a_p["mana"]?"<br>� ������ ����: ".$a_p["mana"]:"").($a_p["hod"]?"<br>� ����� ������ ���":"").($a_p["water_magic"]?"<br>� ���������� �������� ������� ����: ".$a_p["water_magic"]:"").($a_p["earth_magic"]?"<br>� ���������� �������� ������� �����: ".$a_p["earth_magic"]:"").($a_p["fire_magic"]?"<br>� ���������� �������� ������� ����: ".$a_p["fire_magic"]:"").($a_p["air_magic"]?"<br>� ���������� �������� ������� �������: ".$a_p["air_magic"]:"").($a_p["svet_magic"]?"<br>� ���������� �������� ������� �����: ".$a_p["svet_magic"]:"").($a_p["tma_magic"]?"<br>� ���������� �������� ������� ����: ".$a_p["tma_magic"]:"").($a_p["gray_magic"]?"<br>� ���������� �������� ����� �����: ".$a_p["gray_magic"]:"")."<br><br>".$a_p["about"]."');\" onmouseout=\"slot_hide();\">\n</td>";
								$i++;
							}
							echo"</tr></table>";
							echo"</td>
						</tr></table>";
					?>
				</td>
			</tr>
			</table>
		</div>
	</td>
	</tr>
	</table>
</td>
</tr>
</table>
<SCRIPT>setlevel("<? echo addslashes($_GET['sl']);?>");</SCRIPT>