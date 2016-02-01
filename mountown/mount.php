<?
include_once ('time.php');
$login = $_SESSION['login'];
$ip=$db["remote_ip"];
if($db["battle"]!=0){Header("Location: battle.php?tmp=$random");die();}
function attack($who)
{
	$weapons = array('axe','fail','knife','sword','spear','shot','staff','kostyl');
	$shields=array('shield','spear');
	$str="";
    $bot_name = array();
    $bot_name[0] = "Гигантская крыса";
    $bot_name[1] = "Дикий Циклоп";
    $bot_name[2] = "Гигантский Червь";
	$bot_name[3] = "Дерево убийца";
    $bot_name[4] = "Трол";
    $bot_name[5] = "Лев";
    $bot_name[6] = "Разбойник";

	$prototype =$who["login"];
		
	if (in_array($who["hand_r_type"],$weapons) && in_array($who["hand_l_type"],$weapons)){$two_hands=1;}
	if (voin_type($who)=="mag"){$two_hands=1;}
	if (in_array($who["hand_l_type"],$shields)){$shield_hands = 1;}

	if (!$who["zayavka"] && $who["hp"]>0)
	{
		$bot_count=rand(1,3);
		$timeout = time()+180;
		$add_hp=ceil($who["hp_all"]*1.12);

	    mysql_query("INSERT INTO zayavka(status,type,timeout,creator) VALUES('3','55','3','".$who["id"]."')");
	    mysql_query("INSERT INTO teams(player,team,ip,battle_id) VALUES('".$who["login"]."','1','".$ip."','".$who["id"]."')");
		mysql_query("INSERT INTO battles(type, creator_id, lasthit) VALUES('55', '".$who["id"]."', '".$timeout."')");
		$b_id=mysql_insert_id();

		for ($i=1;$i<=$bot_count;$i++)
		{
			$name = $bot_name[rand(0,count($bot_name)-1)];
			$name = $name."(".$i.")";
			$str.= "<b>".$name."</b> ";
			mysql_query("INSERT INTO bot_temp(bot_name, hp, hp_all, battle_id, prototype, team, two_hands, shield_hands) 
			VALUES('".$name."','".$add_hp."','".$add_hp."','".$b_id."','".$prototype."','2','$two_hands','$shield_hands')");
		}
		talk($who["login"], "На вас напал ".$str ,$who);
		goBattle($who["login"]);
	}
}
//-------------------------------------------------------------------
function box($xoll)
{
    if($xoll =="9x8" ){?>  
    <div style="position: absolute; left:125px;top:190px; z-index: 1;">
    	<form action='main.php' name="img_but1" method=post>
    		<input type="hidden" name="baks" value="1">
    		<input type="hidden" name="takemoney" value="1">
    		<img src="img/mount/dol.gif" height="80" style="cursor:hand;" onclick="document.img_but1.submit();return false;">
    	</form>
    </div> 
    <?}
    else if ($xoll =="0x8" ){?>  
    <div style="position: absolute; left:125px;top:190px; z-index: 1;">
    	<form action='main.php' name="img_but2" method=post>
    		<input type="hidden" name="baks" value="1">
    		<input type="hidden" name="takemoney" value="2">
    		<img src="img/mount/dol.gif" height="80" style="cursor:hand;" onclick="document.img_but2.submit();return false;">
    	</form>
    </div> 
    <?}
    else if ($xoll =="1x0" ){?>  
    <div style="position: absolute; left:125px;top:190px; z-index: 1;">
    	<form action='main.php' name="img_but3" method=post>
    		<input type="hidden" name="baks" value="1">
    		<input type="hidden" name="takemoney" value="3">
    		<img src="img/mount/dol.gif" height="80" style="cursor:hand;" onclick="document.img_but3.submit();return false;">
    	</form>
    </div> 
    <?}
}
//-------------------------------------------------------------------
$x=$_GET['x'];
$y=$_GET['y'];
if (is_numeric($x) && is_numeric($y))
{
	$_SESSION["xy"]=$x."x".$y;
}

if ($_GET['action']=="vixod")
{
	$vt=time()+2*60*60;
	mysql_query("UPDATE `users` SET vaulttime='".(time()+2*3600)."' WHERE login='".$login."'");
	mysql_query("DELETE FROM `les` WHERE user_id='".$db["id"]."'");
	$_SESSION["vixod"]=1;
	Header("Location: main.php?act=go&level=forest");
  	die();
}
if ($db['walktime']<time()){echo "<script>document.location.href='?action=vixod';</script>";die();}

//------------------------------------
$matrix=array(
			array(2,0,0,0,0,0,0,0,1,2),
			array(1,0,0,0,0,0,0,1,1,0),
			array(1,0,0,0,0,0,0,1,0,0),
			array(1,0,0,0,1,1,1,1,0,0),
			array(1,0,0,0,1,0,0,0,0,0),
			array(1,1,0,0,1,0,0,0,0,0),
			array(0,1,0,0,1,0,0,0,0,0),
			array(0,1,0,0,1,0,0,0,0,0),
			array(0,1,1,1,1,1,1,0,0,0),
			array(0,0,0,0,1,0,1,1,1,2)
		);


//---------------get money-------------------------------------
if($_POST["take_money"])
{
	if(isset($_SESSION['captcha_keystring']) && $_SESSION['captcha_keystring'] ==  $_POST['keystring'])
   	{
   		$sel=mysql_fetch_array(mysql_query("SELECT * FROM les WHERE user_id='".$db["id"]."' and take='".$_POST['takemoney']."'"));
   		if (!$sel)
   		{
            $money=rand($db["level"]*10,$db["level"]*15);
            mysql_query("UPDATE users SET money=money+".$money." WHERE login='".$login."'");
            mysql_query("INSERT INTO les (user_id, take) VALUES('".$db["id"]."','".$_POST['takemoney']."')");
            $money=$money." Зл.";
			history($login,'Нашел ',$money,$ip,'Темный Лес');
            echo "<b style='color:green'>Вы нашли ".$money." !!!</b>";
		}
		else
		{
			echo "<b style='color:#ff0000'>Ничего не произошло!!!</b>";
		}	 
	}
	else if($_SESSION['captcha_keystring'] !=  $_POST['keystring']) 
	{
		echo "<b style='color:#ff0000'>Ошибка при введении кода!!!</b>";
	}	
}
unset($_SESSION['captcha_keystring']);
echo "<div align=right><b style='color:#ff0000'>Ещё: ".convert_time($db['walktime'])."</b>";
echo "&nbsp; &nbsp; &nbsp;<input type='button' class='btn' onclick=\"window.location='?action=vixod'\" value='Выход'></div>";
//----------------------------------------------------

if (!isset($_SESSION["xy"]))
{
	$_SESSION["xy"]="9x4";
	$xx=9;
	$yy=4;
}
else
{
	$cor=explode("x",$_SESSION["xy"]);
	$xx=$cor[0];
	$yy=$cor[1];
}

//------------BATLLE WHEN WALK--------------------------------------
if ($_GET["action"]=='walk')
{	
	$at=rand(0,100);
	if ($at>75)
	{
		attack($db);
	}
}
//------------TAKE MONEY--------------------------------------
echo "<table cellspacing=0 cellpadding=0 width=100% border=0>
<tr>
<td width=100%>";
	if($_POST['baks'] == 1)
	{	
		?>
		<form action="main.php" method="post">
	    	<p>	<img src="pic.php?<? echo session_name()?>=<? echo session_id()?>">
	    		<br>Введите текст:<input type="text" name="keystring">
				<input type="hidden" name="takemoney" value="<?=$_POST['takemoney'];?>">
	    		<input type="submit" class="button" name="take_money" value="Получить">
	    	</p>
	    </form>
	    <?
	}
echo "
</td>
	<td class='l3' nowrap>
		<table class='l2' cellspacing=0 cellpadding=1 width=547 align=right>
		<tr>
			<td align=center valign=top width=150>
			<b style='color:#990000'>Навигация</b><br/>
				<table cellspacing=0 cellpadding=0 border=0>
				<tr height=58>
					<td width=58>&nbsp;</td>";
					echo "<td width=58 valign=bottom align=center>";
					if (($matrix[$xx-1][$yy])==1){echo "<IMG SRC='img/mount/navigation/top.gif' onclick=\"javascript:location.href='?action=walk&x=".($xx-1)."&y=".$yy."'\" alt='Идти прямо' style='CURSOR: Hand'>";}else {echo "&nbsp;";}
					echo "</td><td width=58>&nbsp;</td>
				</tr>";
				echo "
				<tr height=58>
					<td width=58 align=right valign=center>";
					if (($matrix[$xx][$yy-1])==1){echo "<IMG SRC='img/mount/navigation/left.gif' onclick=\"javascript:location.href='?action=walk&x=".$xx."&y=".($yy-1)."'\" alt='Идти влево' style='CURSOR: Hand'>";}else {echo "&nbsp;";}
					echo "</td>";
					echo "<td width=58 align=center valign=center><IMG SRC='img/mount/navigation/center.gif' onclick=\"javascript:location.href='?act=none';\" style='CURSOR: Hand'></td>";
					echo "<td width=58 align=left valign=center>";
					if (($matrix[$xx][$yy+1])==1){echo "<IMG SRC='img/mount/navigation/right.gif' onclick=\"javascript:location.href='?action=walk&x=".$xx."&y=".($yy+1)."'\" alt='Идти направо' style='CURSOR: Hand'>";}else {echo "&nbsp;";}
					echo"</td>
				</tr>";
				echo "
				<tr height=58>
					<td width=58>&nbsp;</td>";
					echo "<td width=58 align=center valign=top>";
					if (($matrix[$xx+1][$yy])==1){echo "<IMG SRC='img/mount/navigation/bottom.gif' onclick=\"javascript:location.href='?action=walk&x=".($xx+1)."&y=".$yy."'\" alt='Идти назад' style='CURSOR: Hand'>";}else {echo "&nbsp;";}
					echo "</td>";
					echo"<td width=58>&nbsp;</td>
				</tr>
				</table>";
			echo '
			</td>
			<td align=center>
				<table cellspacing=0 cellpadding=0 border=0>
				<tr>
					<td align=right valign=bottom><img src="img/design/border-1x1.gif" width=10 height=10 border=0 hspace=0 vspace=0></td>
					<td style="background:url(img/design/border-h.gif) repeat-x bottom left"></td>
					<td align=left valign=bottom><img src="img/design/border-3x1.gif" width=10 height=10 border=0 hspace=0 vspace=0></td>
				</tr>
				<tr>
					<td style="background:url(img/design/border-v.gif) repeat-y top right"></td>
					<td style="padding: 0px;">
						<DIV  align="left" style="position:relative;" >';
			 				box($xx."x".$yy);
						echo '
						<img src="img/mount/loc/'.$xx.$yy.'.jpg" border="0">
						</div>
					</td>
					<td style="background:url(img/design/border-v.gif) repeat-y top left"></td>
				</tr>
				<tr>
					<td align=right valign=top><img src="img/design/border-1x3.gif" width=10 height=10 border=0 hspace=0 vspace=0></td>
					<td style="background:url(img/design/border-h.gif) repeat-x top left"></td>
					<td align=left valign=top><img src="img/design/border-3x3.gif" width=10 height=10 border=0 hspace=0 vspace=0></td>
				</tr>
				</table>
			</td>
		</tr>
		</table>
	</td>
</tr>
</table>';
?>