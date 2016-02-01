<?
session_start();
@ob_start("ob_gzhandler");
Header("Content-type: text/html; charset=windows-1251");
Header("Cache-Control: no-cache, must-revalidate"); // говорим браузеру что-бы он не кешировал эту страницу
Header("Pragma: no-cache");

$log_name = htmlspecialchars(addslashes(trim($_GET['log'])));
include_once ("conf.php");
include_once ("req.php");
include_once ("functions.php");
include_once ("time.php");

if($break == 1)
{
	echo '
	<center><br><br><br><br>
	<table border="0" cellpadding="0" cellspacing="0" width="400">
	  <tbody>
	  <tr>
	    <td><br><br><br>
	    <img src="img/const/cons.gif" align="right" border="0" height="43" width="52">
		<font face="ARIAL" size="-1">		
		<h3>WWW.OlDmeydan.Pe.Hu</h3>
	    <small>Отличная RPG онлайн игра посвященная боям и магии</small>
	    <br>
	 	<p align="center"><strong>  Извините сайт временно не работает.</strong></p>
		<br><br><img src="img/const/under.gif" border="0" height="13" width="442"> 
	<br>
    </font></td></tr></tbody></table>';
	die();
}
$data = @mysql_connect($base_name, $base_user, $base_pass) or die('Не получается подключиться. Проверьте имя сервера, имя пользователя и пароль!');
mysql_select_db($db_name) or die('Ошибка входа в базу данных');

$seek=mysql_query("SELECT users.*,info.*,zver.id as zver_count,zver.obraz as zver_obraz,zver.level as zver_level,zver.name as zver_name,zver.type as zver_type FROM `users` LEFT JOIN info on info.id_pers=users.id LEFT JOIN zver on zver.owner=users.id and zver.sleep=0 WHERE login='".$log_name."'");
$db = mysql_fetch_array($seek);
mysql_free_result($seek);

if(!$db || !$log_name)
{
	die('<TITLE>Произошла ошибка</TITLE><link rel=stylesheet type="text/css" href="main.css"><BODY bgcolor=#dddddd>
		<b style="color:#ff0000;">Произошла ошибка:</b> <br>Указанный персонаж не найден...
		<hr><div align=right>© Администрация <a href="" class=us2>OlDmeydan.Pe.Hu - Самый азартный проект в Азербайджане!</a></div>');
}
?>
<html>
<head>
<title>
	<?echo $db["login"];?> - Информация о персонаже</title>
	<meta http-equiv="content-type" content="text/html; charset=windows-1251">
	<meta http-equiv=cache-control content="no-cache, max-age=0, must-revalidate, no-store">
	<meta http-equiv=pragma content=no-cache>
	<meta http-equiv=expires content=0>
	<link rel=stylesheet type="text/css" href="main.css">
	<style>
		.bgrright {background: url("img/design/brg-top-right-1-blank.gif") repeat-x top left}
		.bgrleft  {background: url("img/design/brg-top-left-1-blank.gif") repeat-x top right}
		.bgrdown  {background: url("img/design/down-bgr-blank.gif") repeat-x top right}
	</style>
	<script type="text/javascript" language="JavaScript1.3" src='can.js'></script>	
	<script language="JavaScript" type="text/javascript" src="show_inf.js"></script>
	<script language="JavaScript" type="text/javascript" src="commoninf.js"></script>
</head>
<body bgcolor="#392F2D" background="img/design/bgr.gif" link="#FFD175" vlink="#FFD175" alink="white" leftmargin=0 topmargin=0 rightmargin=0 bottommargin=0 marginwidth=0 marginheight=0>
<div id="slot_info" style="visibility: hidden; position: absolute;z-index: 1;"></div>
<div id="mydiv" style="position:relative;height:100%; width:100%">
<table cellspacing=0 cellpadding=0 border=0 width=100% align=center>
<tr>
<td>
	<table cellspacing=0 cellpadding=0 border=0 width="100%">
	<tr valign=top>
		<td class="bgrleft" width=50%><img src="img/design/top-left-blank.gif" hspace=0 vspace=0 border=0></td>
		<td width=302><img src="img/design/top-balls_inf.gif" hspace=0 vspace=0 border=0></td>
		<td class="bgrright" width="100%" align="right"><img src="img/design/top-right-blank.gif" hspace=0 vspace=0 border=0></td>
	</tr>
	</table>
	<table cellspacing=0 cellpadding=0 border=0 width="100%">
	<tr>
		<td background="img/design/left-bgr-blank.gif"><img src="img/design/dot.gif" width=10 height=1 hspace=0 vspace=0 border=0></td>
		<td width=100% background="img/design/bgr.jpg">
			<?
			effects($db["id"],$effect);
			$sila=$db["sila"]+$effect["add_sila"];
			$lovkost=$db["lovkost"]+$effect["add_lovkost"];
			$udacha=$db["udacha"]+$effect["add_udacha"];
			$vinoslivost=$db["power"];
			$intellekt=$db["intellekt"]+$effect["add_intellekt"];
			$vospriyatie=$db["vospriyatie"];
			$duxovnost=$db["duxovnost"];

			$birthday = $db["birth"];
			$birth=explode(".",$birthday);
			$zd=$birth[0];
			$zm=$birth[1];

			switch (voin_type($db)) 
			{
				case "silach":$v_type = "Силач";break;
				case "krit":$v_type = "Критовик";break;
				case "uvarot":$v_type = "Уворотчик";break;
				case "mag":$v_type = "Маг";break;
				case "antikrit":$v_type = "Анти-Критовик";break;
			}
			###################################################
			$cure_hp=$db["cure_hp"];
			$cure_mn=$db["cure_mn"];
			$time_to_cure=$cure_hp-time();
			$time_to_cure_mn=$cure_mn-time();
			$hhh=$db["hp_all"];
			$mmm=$db["mana_all"];

			if($db["battle"]==0)
			{
				if($time_to_cure>0)
				{
					$cure_full = $db["cure_time"]-$db["cure"];
					$percent_hp=floor((100*$time_to_cure)/$cure_full);
					$percent=100-$percent_hp;
					$hp[0]=floor(($hhh*$percent)/100);
					mysql_query("UPDATE users SET hp='".$hp[0]."' WHERE login='".$db["login"]."'");
				}
				else
				{
					$hp[0]=$db["hp_all"];
					mysql_query("UPDATE users SET hp='".$hp[0]."',cure_hp='0' WHERE login='".$db["login"]."'");
				}
				if($time_to_cure_mn>0)
				{
					$percent_mn=floor((100*$time_to_cure_mn)/1200);
					$percentm=100-$percent_mn;
					$mana[0]=floor(($mmm*$percentm)/100);
					mysql_query("UPDATE users SET mana='".$mana[0]."' WHERE login='".$db["login"]."'");
				}
				else
				{
					$mana[0]=$db["mana_all"];
					mysql_query("UPDATE users SET mana='".$mana[0]."',cure_mn='0' WHERE login='".$db["login"]."'");
				}
			}
			else 
			{
				$hp[0]=$db["hp"];
				$mana[0]=$db["mana"];
			}
			$hp[1]=$db["hp_all"];
			$mana[1]=$db["mana_all"];
			###################################################
			$dd=mysql_query("SELECT SUM(add_sila) AS addsila, SUM(add_lovkost) AS addlovkost, SUM(add_udacha) AS addudacha, SUM(add_intellekt) AS addintellekt, SUM(add_duxovnost) AS addduxovnost FROM inv WHERE inv.owner='".$db["login"]."' and inv.wear='1' and inv.object_razdel='obj'");
			$ddd=mysql_fetch_array($dd);
			$silaadd=(int)$ddd['addsila'];
			$lovkostadd=(int)$ddd['addlovkost'];
			$udachaadd=(int)$ddd['addudacha'];
			$intelektadd=(int)$ddd['addintellekt'];
			$duxovnostadd=(int)$ddd['addduxovnost'];
			#####################TRAVMA########################
			if($db["travm"] && $db["travm"]<time())
			{
				$t_stat = $db["travm_stat"];
				$o_stat = $db["travm_old_stat"];
				mysql_query("UPDATE users SET $t_stat=$t_stat+$o_stat, travm='0', travm_stat='', travm_var='', travm_old_stat='' WHERE login='".$db["login"]."'");
			}
			###################################################
			testPrision($db);
			?>
			<table border="0" cellpadding="0" cellspacing="0" width=100%>
			<tr>
			<td width="260" valign=top nowrap>
				 <table align="center" border="0" cellpadding="0" cellspacing="0" >
			    	<tr>
			    		<td align=center>
			    			<?
							echo "<SCRIPT>
								errtrap('".$db['login']."'); 
								info('".$db['login']."', '".$db['id']."', '".$db['level']."', '".$db['dealer']."', '".$db['orden']."', '".$db['admin_level']."', '".$db['clan_short']."', '".$db['clan']."');
								setHP($hp[0],$hp[1],".($db['battle']==0?"100":"0"),");
					    		setMana($mana[0],$mana[1],".($db['battle']==0?"100":"0").");
					    		</script>";
					    	?>
			    			<table cellspacing="0" cellpadding="0">
							<tr>
								<td nowrap style="font-size:9px" style="position: relative;"><SPAN id="HP" style='position: absolute; left: 5; z-index: 1; font-weight: bold; color: #FFFFFF'></SPAN><img src="img/icon/grey.jpg" alt="Уровень жизни" name="HP1" width="1" height="10" id="HP1"><img src="img/icon/grey.jpg" alt="Уровень жизни" name="HP2" width="1" height="10" id="HP2"></td>
							</tr>
							<tr><td><span></span></td></tr>
							<?if($db["level"]>0 && $mana[1]>0){?>
							<tr>
								<td nowrap style="font-size:9px" style="position: relative;"><SPAN id="Mana" style='position: absolute; left: 5; z-index: 1; font-weight: bold; color: #FFFFFF'></SPAN><img src="img/icon/grey.jpg" alt="Уровень Маны" name="Mana1" width="1" height="10" id="Mana1"><img src="img/icon/grey.jpg" alt="Уровень жизни" name="Mana2" width="1" height="10" id="Mana2"></td>
							</tr>
							<?}?>
							</table>
							<?
								showPlayer_inf($db);
							?>
			    		</td>
			    	</tr>
			    </table>
			</td>
			<td width=3></td>
			<td valign="top" align=left width="300" nowrap>
		        <table border="0" width="100%" style="color:#333333" align=left>
				<tr>
					<td><br>
					Сила: <?echo "<b>".$sila."</b>"; if ($silaadd || $effect["add_sila"]) echo " (".($sila-$silaadd-$effect["add_sila"])."+<font color='darkgreen' title='Статы Вещей'>".$silaadd."</font>+<font color='blue' title='Статы Эликсиров'>".(int)$effect["add_sila"]."</font>)";?></b><br>
		        	Ловкость: <?echo "<b>".$lovkost."</b>"; if ($lovkostadd || $effect["add_lovkost"]) echo " (".($lovkost-$lovkostadd-$effect["add_lovkost"])."+<font color='darkgreen' title='Статы Вещей'>".$lovkostadd."</font>+<font color='blue' title='Статы Эликсиров'>".(int)$effect["add_lovkost"]."</font>)";?></b><br>
		        	Удача: <?echo "<b>".$udacha."</b>"; if ($udachaadd || $effect["add_udacha"]) echo " (".($udacha-$udachaadd-$effect["add_udacha"])."+<font color='darkgreen' title='Статы Вещей'>".$udachaadd."</font>+<font color='blue' title='Статы Эликсиров'>".(int)$effect["add_udacha"]."</font>)";?></b><br>
		        	Выносливость: <b><?echo $vinoslivost;?></b><br>
					<?
						if($db["level"])
						{
						?>
			        		Интеллект: <?echo "<b>".$intellekt."</b>"; if ($intelektadd || $effect["add_intellekt"]) echo " (".($intellekt-$intelektadd-$effect["add_intellekt"])."+<font color='darkgreen' title='Статы Вещей'>".$intelektadd."</font>+<font color='blue' title='Статы Эликсиров'>".(int)$effect["add_intellekt"]."</font>)";?></b><br>
			        		Восприятие: <b><?echo $vospriyatie;?></b><br>
						<?
						}
						if($db["level"]>9 || $duxovnost>0)echo "Духовность: <b>".$duxovnost."</b>"; if ($duxovnostadd) echo " (".($duxovnost-$duxovnostadd).($duxovnostadd>0?"+":"")."<font color=darkgreen>".$duxovnostadd."</font>)</b><br>";
					?>		
					<hr width=90% align=left>
					Побед: <?echo "<a href='top.php' target='_blank' class='us2'>".$db["win"]."</a>";?><br>
					Поражений: <?=$db["lose"];?><br>
					Ничьих: <?=$db["nich"];?><br>
					Побед над монстрами: <?=$db["monstr"];?><br>
					Репутация: <?=$db["reputation"];?><br>
					Доблесть: <?=$db["doblest"];?><br>
					<hr width=90% align=left>
					Тип Воина: <b><?echo $v_type;?></b><br>	
					Статус: <b><?echo $db["status"];?></b><br>
					Место рождения: <b><?echo strtoupper($db["born_city"]);?></b><br>	
					Родился: <?echo  $db["date"];?><br>
					<hr width=90% align=left>
					<?
					switch ($db["orden"]) 
					{
						 case 1:$orden_dis="Стражи порядка";break;
						 case 2:$orden_dis="Вампиры";break;
					 	 case 3:$orden_dis="Орден Равновесия";break;
					 	 case 4:$orden_dis="Орден Света";break;
					 	 case 5:$orden_dis="Тюремный заключеный";break;
					 	 case 6:$orden_dis="Истинный Мрак";break;
					 	 case 7:$orden_dis="Исчадие Хаоса";break;
					 	 case 100:$orden_dis="Смертные";break;
					}
		        
			        if ($db["orden"])
					{
						$db["otdel"]=str_replace("&amp;","&",$db["otdel"]);
						echo "<img src='img/orden/".$db["orden"]."/".$db["admin_level"].".gif' border='0' alt='".$orden_dis."'> <b>".$orden_dis."</b><br>";
						echo (($db["otdel"]!= "")?"<small>Должность: <b>".$db["otdel"]."</b></small><BR>":"");
					}
					if (!empty($db["parent_temp"]))
					{
						echo "<small>Назначил: <b>".$db["parent_temp"]."</small></B><BR>";
					}
					if($db["clan"])
					{
						echo "<b>Ханство: <a href='clan_inf.php?clan=".$db["clan_short"]."' class='us2' target='_blank'><small>".$db["clan"]."</small></a></b><BR>";
						echo "<b><small>Должность: ".$db["chin"]."</small></B><BR>";
					}
					?>
					</td>
				</tr>
		   		<tr>
					<td>
						<?
							if($db["travm"]!=0)
							{
								$travm=$db["travm_var"];
								$kstat=$db["travm_stat"];
								$stats=$db["travm_old_stat"];
								if($travm==1){$travm="легкая травма";}
								else if($travm==2){$travm="средняя травма";}
								else if($travm==3){$travm="тяжелая травма";}
								else if($travm==4){$travm="неизлечимая травма";}
								if($kstat=="sila"){$kstat="сила";}
								else if($kstat=="lovkost"){$kstat="ловкость";}
								else if($kstat=="udacha"){$kstat="интуиция";}
								else if($kstat=="intellekt"){$kstat="интеллект";}
								echo "<img src=img/index/travma.gif border=0> ";
								echo "<small>У персонажа <B>".$travm.".</B> ";
								echo "Ослабленна характеристика <B style='color:#ff0000'>$kstat-$stats</B> ";
								echo "(Еще ".convert_time($db['travm']).")</small><br>";
							}
							if($db["oslab"]>time())
						   	{
								echo "<img src=img/index/travma.gif border=0> ";
								echo "<small>Персонаж ослаблен из-за смерти в бою, еще ".convert_time($db['oslab'])."</small><BR>"; 
							}
						?>
					</td>
		        </tr>
		        <tr>
					<td>
						<?
							if($db["shut"]>time())
						   	{
								echo "<br><img src=img/index/molch.gif border=0>  <small>Молчит еще ".convert_time($db['shut'])." <BR>";
								echo "Причина: <i>".$db['shut_reason']."</i> </small><BR>";
							}
							if($db["forum_shut"]>time())
						   	{
								echo "<br><img src=img/index/molch.gif border=0> ";
								echo "<small>Персонаж будет молчать на форуме ещё ".convert_time($db['forum_shut'])." </small><BR>";
							}
							if($db["blok"])
							{
								echo "<table width=100%><tr><td valign=top>";
								echo "<center><b>Сообщение о блокировке:</b></center><span class='private'>".$db["blok_reason"]."</span>"; 
								echo "</td></tr></table>";
							}
							if($db["prision"])
							{
								echo "<table width=100%><tr><td valign=top>";
								echo "<center><b>Сообщение о изгнании:</b></center><span class='private'>".$db["prision_reason"]."</span><BR><i>Еще: ".convert_time($db['prision'])."</i></center>";
								echo "<br></td></tr></table>";
							}
						?>
					</td>
		        </tr>
		    </table>
		</td>
	<td valign="top" width=100%>
		<table cellspacing=0 cellpadding=0 border=0 width=600>
		<tr>
			<td align=right valign=bottom><img src="img/design/border-1x1.gif" width=10 height=10 border=0 hspace=0 vspace=0></td>
			<td style="background:url(img/design/border-h.gif) repeat-x bottom left"></td>
			<td align=left valign=bottom><img src="img/design/border-3x1.gif" width=10 height=10 border=0 hspace=0 vspace=0></td>
		</tr>
		<tr>
			<td style="background:url(img/design/border-v.gif) repeat-y top right"></td>
			<td style="padding: 3px;">
			<?
				echo "<img src=img/zodiac/".getSign($zd,$zm).">&nbsp;";
				if($db["marry"]!="")
				{
					if($db["sex"]=="male"){$pol="Женат на: ".$db["marry"]; }
					else if($db["sex"]=="female"){$pol="Замужем за: ".$db["marry"]; }
					echo "<a href='info.php?log=".str_replace(" ","%20",$db["marry"])."' target='_blank'><img src='img/index/married.gif' title='$pol' border=0></a>&nbsp;";
				}
				if($db["vip"]>time())
				{
					echo "<img src='img/naqrada/vip.gif' border=0 alt='V.I.P Клуб WWW.OlDmeydan.Pe.Hu. \nЕще: ".convert_time($db["vip"])."'>&nbsp;";
				}
				if($db["dealer"])
				{
					 echo "<img src='img/naqrada/dealer.gif' alt='Персонаж является ДИЛЛЕРОМ' border=0>&nbsp;";
				}
				$SS = mysql_query("SELECT medal.img,medal.name FROM inv LEFT JOIN medal on medal.id=inv.object_id WHERE inv.owner='".$db["login"]."' AND inv.object_razdel='medal'");
				if (mysql_num_rows($SS)>0)
				{
					while ($DAT_T = mysql_fetch_array($SS))
					{
				        $imgs = $DAT_T["img"];
				        $names = $DAT_T["name"];
				        echo "<img src='".$imgs."' onmouseover=\"slot_view('<b>".$names."</b>');\" onmouseout=\"slot_hide();\"> ";
					}
				}
			?>
			</td>
			<td style="background:url(img/design/border-v.gif) repeat-y top left"></td>
		</tr>
		<tr>
			<td align=right valign=top><img src="img/design/border-1x3.gif" width=10 height=10 border=0 hspace=0 vspace=0></td>
			<td style="background:url(img/design/border-h.gif) repeat-x top left"></td>
			<td align=left valign=top><img src="img/design/border-3x3.gif" width=10 height=10 border=0 hspace=0 vspace=0></td>
		</tr>
		</table>
		
		<?
			$all_gift=array();
			$all_gift_art=array();
			$SS = mysql_query("SELECT * FROM inv LEFT JOIN flower on flower.id=inv.object_id WHERE inv.owner='".$db["login"]."' AND inv.object_razdel='other' AND inv.object_id!=193 ORDER BY UNIX_TIMESTAMP(date) DESC");
			while ($DAT_T = mysql_fetch_array($SS))
			{
				if ($DAT_T["art"])
				$all_gift_art[]=array("gift_author"=>$DAT_T["gift_author"],"wish"=>$DAT_T["msg"],"name"=>$DAT_T["name"],"date"=>$DAT_T["date"],"img"=>$DAT_T["img"]);
				else
				$all_gift[]=array("gift_author"=>$DAT_T["gift_author"],"wish"=>$DAT_T["msg"],"name"=>$DAT_T["name"],"date"=>$DAT_T["date"],"img"=>$DAT_T["img"]);
			}
			if (count($all_gift_art) || count($all_gift))
			{
			?>
			<br/><br/>
			<table cellspacing=0 cellpadding=0 border=0 width=600>
			<tr>
				<td align=right valign=bottom><img src="img/design/border-1x1.gif" width=10 height=10 border=0 hspace=0 vspace=0></td>
				<td style="background:url(img/design/border-h.gif) repeat-x bottom left"></td>
				<td align=left valign=bottom><img src="img/design/border-3x1.gif" width=10 height=10 border=0 hspace=0 vspace=0></td>
			</tr>
			<tr>
				<td style="background:url(img/design/border-v.gif) repeat-y top right"></td>
				<td style="padding: 3px;" align="center">
				<?
						if (count($all_gift_art))
						{
							foreach ($all_gift_art as $currentValues)
							{
								$gift_author = $currentValues["gift_author"];
								$wish = $currentValues["wish"];
								$wish=str_replace("&amp;","&",$wish);
						        $name = $currentValues["name"];
						        $date_send=$currentValues["date"];
						        $img = $currentValues["img"];
						        $br=array("\n","\r");
						        echo "<script>DrawGift(\"$img\", \"$name\", \"<center><img src=img/$img boder=0></center>".str_replace($br,"<br>",$wish)."\", \"<b>от ".$gift_author."</b><br><small>Подарен: $date_send</small>\");</script>";
							}
							echo "<hr>";
						}
						if (count($all_gift))
						{
							$c_=count($all_gift);
							if (!$_GET["all"] && $c_>12)$c_=12;
							$all_gift=array_slice($all_gift, 0, $c_); 
							foreach ($all_gift as $currentValues)
							{					
								$gift_author = $currentValues["gift_author"];
						        $wish = $currentValues["wish"];
						        $wish=str_replace("&amp;","&",$wish);
						        $name = $currentValues["name"];
						        $date_send=$currentValues["date"];
						        $img = $currentValues["img"];
						        $br=array("\n","\r");
						        echo "<script>DrawGift(\"$img\", \"$name\", \"<center><img src=img/$img boder=0></center>".str_replace($br,"<br>",$wish)."\", \"<b>от ".$gift_author."</b><br><small>Подарен: $date_send</small>\");</script>";
							}
						}
						if (!$_GET["all"])echo "<center><small><A href=\"info.php?log=".$db["login"]."&all=1\">Нажмите сюда, чтобы увидеть все подарки...</A></small></center>";
				?>
				</td>
				<td style="background:url(img/design/border-v.gif) repeat-y top left"></td>
			</tr>
			<tr>
				<td align=right valign=top><img src="img/design/border-1x3.gif" width=10 height=10 border=0 hspace=0 vspace=0></td>
				<td style="background:url(img/design/border-h.gif) repeat-x top left"></td>
				<td align=left valign=top><img src="img/design/border-3x3.gif" width=10 height=10 border=0 hspace=0 vspace=0></td>
			</tr>
			</table>
		<?}?>
	</td>
</tr>
</table>
<table cellspacing=0 cellpadding=0 border=0 width=100%>
<tr>
	<td align=right valign=bottom><img src="img/design/border-1x1.gif" width=10 height=10 border=0 hspace=0 vspace=0></td>
	<td style="background:url(img/design/border-h.gif) repeat-x bottom left"></td>
	<td align=left valign=bottom><img src="img/design/border-3x1.gif" width=10 height=10 border=0 hspace=0 vspace=0></td>
</tr>
<tr>
	<td style="background:url(img/design/border-v.gif) repeat-y top right"></td>
	<td style="padding: 3px;" bgcolor=#FAF0E4>
	<?
		if($db["obezlik"]>time())
		{
			echo "<h3>Обезличен еще ".convert_time($db["obezlik"])."</h3>";
		}
		else
		{	
			echo "<h3>Анкетные даннные</h3>";
			echo "<b>Имя:</b> ".$db["name"]."<br>
	        <b>Пол:</b> ".(($db["sex"] == "male")?"Мужской":"Женский")."<br>
			<b>Город:</b> ".$db["town"]."<br>";
	        if ($db["deviz"]) echo "<b>Девиз: </b>".$db["deviz"]."<br>";
			if($db["icq"]) echo "<b>ICQ номер: </b>".$db["icq"]."<br>";
			if($db["hobie"])
			{
				$db["hobie"]=str_replace("&amp;","&",$db["hobie"]);
				$db["hobie"]=wordwrap($db["hobie"], 40, " ",1);
				$db["hobie"]=str_replace("\n","<br>",$db["hobie"]);
				echo "<br><b>Дополнительная информация:</b><br>".$db["hobie"];
			}
		}
	?>
	</td>
	<td style="background:url(img/design/border-v.gif) repeat-y top left"></td>
</tr>
<tr>
	<td align=right valign=top><img src="img/design/border-1x3.gif" width=10 height=10 border=0 hspace=0 vspace=0></td>
	<td style="background:url(img/design/border-h.gif) repeat-x top left"></td>
	<td align=left valign=top><img src="img/design/border-3x3.gif" width=10 height=10 border=0 hspace=0 vspace=0></td>
</tr>
</table>

<table border="0" cellpadding="0" cellspacing="0" width="100%" >
<tr>
	<td valign="top" align="center">
	<?
		if(($db["metka"]+5*24*60*60)>time())
		{
			$tim=$db["metka"]+5*24*60*60;
			echo "<a><B>Метка:</B> Удачно пройдена проверка, время прохождения: <b>".date("d.m.Y",$db["metka"])."</b> (Еще ".convert_time($tim).")</a>";
		}
	?>
</td>
</tr>
</table>
</td>
<td background="img/design/right-bgr-blank.gif"><img src="img/design/dot.gif" width=10 height=1 hspace=0 vspace=0 border=0></td>
</tr>
</table>
<table cellspacing=0 cellpadding=0 border=0 width="100%" height=55 class="bgrdown">
	<tr valign=top>
		<td><img src="img/design/down-left-blank.gif" width=34 height=25 hspace=0 vspace=0 border=0></td>
		<td width=100%></td>
		<td><img src="img/design/down-right-blank.gif" width=34 height=25 hspace=0 vspace=0 border=0></td>
	</tr>
</table>

<table border="0" cellpadding="5" cellspacing="2" width="100%">
	<tr>
		<td align="right" valign="bottom"><?include_once ('counter.php')?></td>
	</tr>
</table>
<?if ($db["id"]==82984)
{
	echo "<img src='img/index/traur.png' style=\"position:absolute; right:0px; top:0px\">";
}
?>	
</div>
<?mysql_close();?>	
</body>