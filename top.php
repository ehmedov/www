<?
include ("conf.php");
@ob_start("ob_gzhandler");
Header("Cache-Control: no-cache, must-revalidate"); // говорим браузеру что-бы он не кешировал эту страницу
Header("Pragma: no-cache");

$data = @mysql_connect($base_name, $base_user, $base_pass) or die('Не получается подключиться. Проверьте имя сервера, имя пользователя и пароль!');
mysql_select_db($db_name) or die('Ошибка входа в базу данных');


$reyting_array=array("pers","clan","lesorub","turnir","svet_tma","svet","tma","neytral","monstr","ribak","naemnik","casino","clan_win","auction");
$act=htmlspecialchars(addslashes($_GET[act]));
if (!in_array($act, $reyting_array))$act="svet_tma";
?>
<html>
<head>
	<title>WWW.Oldmeydan.Pe.Hu - Топ лучших игроков</title> 
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<meta http-equiv="Content-Language" content="ru">
	<LINK REL=StyleSheet HREF='main.css' TYPE='text/css'>
	<META Http-Equiv=Cache-Control Content=no-cache>
	<meta http-equiv=PRAGMA content=NO-CACHE>
	<META Http-Equiv=Expires Content=0>	
</head>
<script language="JavaScript" type="text/javascript" src="commoninf.js"></script>
<body leftmargin=0 topmargin=0 marginwidth=0 marginheight=0 bgcolor="#faeede">
<table align=center cellpadding=0 cellspacing=0>
<tr>
	<td>
		<img src='img/index/title_left.gif' width=42 height=33>
	</td>
	<td align=center valign=top>
		<table align=center cellpadding=0 cellspacing=0>
		<tr>
			<td width=100% height=20 background='img/index/title_center.gif' valign=top><B style='color:#F1BC00'>&nbsp; СИЛЬНЕЙШИЕ ГЕРОИ &nbsp;</B></td>
		</tr>
		</table>
	</td>
	<td>
		<img src='img/index/title_right.gif' width=42 height=33>
	</td>
</tr>
</table>
<TABLE CELLSPACING=0 CELLPADDING=0 align=center>
<tr><td align=center height=20><a href='?act=pers'>Боевой рейтинг</a> | <a href='?act=clan'>Рейтинг Ханств</a> | <a href='?act=clan_win'>Рейтинг Победа Ханств</a> | <a href='?act=turnir'>Турнирный рейтинг</a> | <a href='?act=monstr'>Побед над монстрами</a></td></tr>
<tr><td align=center height=20><a href='?act=svet_tma'>Общий рейтинг</a> | <a href='?act=svet'>Альянс Света</a> | <a href='?act=tma'>Альянс Тьмы</a> | <a href='?act=neytral'>Альянс Нейтралов</a></td></tr>
<tr><td align=center height=20><a href='?act=lesorub'>Рейтинг Лесорубов</a> | <a href='?act=ribak'>Рейтинг Рыбака</a> | <a href='?act=naemnik'>Рейтинг Наёмников</a> | <a href='?act=casino'>Рейтинг Дом отдыха</a> | <a href='?act=auction'>Рейтинг торговцев</a></td></tr>


<tr><td height=1 bgcolor=#CCCCCC></td></tr>
<tr>
	<td valign=top align=center><br>
	<TABLE WIDTH=500 CELLSPACING=1 CELLPADDING=2 class='l3'>
	<? 
	if ($act=='pers')
	{
		echo "<h3>Боевой рейтинг</h3>
			<tr class='l3' ><td align=right><b>№</b></td><td><b>Воин</b></td><td><b>рейтинг</b></td></tr>";
			$result = mysql_query("SELECT id, login, level, orden, admin_level, dealer, clan_short, clan, win-lose as reit FROM users WHERE orden!=5 and blok!=1 ORDER BY reit DESC LIMIT 0,50");
			while($row = mysql_fetch_array($result))
			{
				$n=(!$n);
				$j++;
				echo "<tr class='".($n?"l0":"l1")."'>";
				echo "<td width=30 align=right >".$j.".</td><td><script>drwfl('".$row["login"]."', '".$row["id"]."', '".$row["level"]."', '".$row["dealer"]."',  '".$row["orden"]."', '".$row["admin_level"]."', '".$row["clan_short"]."', '".$row["clan"]."');</script></td><td>".(int)$row["reit"]."</td>";	
				echo "</tr>";
			}
			unset($j);
	}
	else if ($act=='monstr')
	{
		echo "<h3>Побед над монстрами</h3>
		<tr class='l3' ><td align=right><b>№</b></td><td><b>Воин</b></td><td><b>рейтинг</b></td></tr>";
			$query = "SELECT id,login,level,orden,admin_level,dealer,clan_short,clan,monstr FROM users WHERE orden!=5 and blok!=1 ORDER BY monstr DESC LIMIT 0,50";
			$result = mysql_query($query);
			for ($j=0; $j<mysql_num_rows($result); $j++) 
			{
				$n=(!$n);
				$row = mysql_fetch_array($result);
				$orden = $row["orden"];
				$admin_level = $row["admin_level"];
				$dealer = $row["dealer"];
				$clan_s = $row["clan_short"];
				$clan_f = $row["clan"];
				$level=$row["level"];
				$id=$row["id"];
				$name=$row["login"];
				$monstr=$row["monstr"];
				echo "<tr class='".($n?"l0":"l1")."'>";
				echo "<td width=30 align=right >".($j+1).".</td><td><script>drwfl('$name', '$id', '$level', '$dealer',  '$orden', '$admin_level', '$clan_s', '$clan_f');</script></td><td>".(int)$monstr."</td>";	
				echo "</tr>";
			}
	}
	else if ($act=='clan')
	{
		echo "<h3>Рейтинг Ханств</h3>
		<tr class='l3' ><td align=right><b>№</b></td><td><b>Ханства</b></td><td><b>рейтинг</b></td></tr>";
			$query = "SELECT * FROM clan ORDER BY ochki DESC";
			$result = mysql_query($query);
			for ($j=0; $j<mysql_num_rows($result); $j++) 
			{
				$n=(!$n);
				$row = mysql_fetch_array($result);
				$name = $row["name"];
		        $name_s = $row["name_short"];
		        $orden = $row["orden"];
		        $ochki = $row["ochki"];
				if(!$orden){$orden_i = "";}
		        else if($orden == 2){$orden_i = "<img src='img/orden/2/0.gif'  alt='Вампиры.'>";}
		        else if($orden == 3){$orden_i = "<img src='img/orden/3/0.gif'  alt='Орден Равновесия.'>";}
		        else if($orden == 4){$orden_i = "<img src='img/orden/4/0.gif'  alt='Орден Света.'>";}
				$clan_i = "<img src='img/clan/$name_s.gif'  alt='$name' border=0>";
				echo "<tr class='".($_GET["clan_id"]==$name_s?"l2":($n?"l0":"l1"))."'>";
				echo "<td width=30 align=right >".($j+1).".</td><td>$orden_i $clan_i <B>$name</B> <a href='clan_inf.php?clan=$name_s' class=us2 target=$name_s><img src='img/h.gif' border=0></a></td><td>".(int)$ochki."</td>";	
				echo "</tr>";
			}
	}
	else if ($act=='clan_win')
	{
		echo "<h3>Рейтинг Победа Ханств</h3>
		<tr class='l3' ><td align=right><b>№</b></td><td><b>Ханства</b></td><td><b>рейтинг</b></td></tr>";
			$query = "SELECT * FROM clan ORDER BY wins DESC";
			$result = mysql_query($query);
			for ($j=0; $j<mysql_num_rows($result); $j++) 
			{
				$n=(!$n);
				$row = mysql_fetch_array($result);
				$name = $row["name"];
		        $name_s = $row["name_short"];
		        $orden = $row["orden"];
		        $wins = $row["wins"];
				if(!$orden){$orden_i = "";}
		        else if($orden == 2){$orden_i = "<img src='img/orden/2/0.gif'  alt='Вампиры.'>";}
		        else if($orden == 3){$orden_i = "<img src='img/orden/3/0.gif'  alt='Орден Равновесия.'>";}
		        else if($orden == 4){$orden_i = "<img src='img/orden/4/0.gif'  alt='Орден Света.'>";}
				$clan_i = "<img src='img/clan/$name_s.gif'  alt='$name' border=0>";
				echo "<tr class='".($_GET["clan_id"]==$name_s?"l2":($n?"l0":"l1"))."'>";
				echo "<td width=30 align=right >".($j+1).".</td><td>$orden_i $clan_i <B>$name</B> <a href='clan_inf.php?clan=$name_s' class=us2 target=$name_s><img src='img/h.gif' border=0></a></td><td>".(int)$wins."</td>";	
				echo "</tr>";
			}
	}
	else if ($act=='naemnik')
	{
		echo "<h3>Рейтинг Наёмников</h3>
		<tr class='l3' ><td align=right><b>№</b></td><td><b>Воин</b></td><td><b>рейтинг</b></td></tr>";
			$query = "SELECT users.id,login,level,orden,admin_level,dealer,clan_short,clan,navika FROM person_proff LEFT JOIN users on users.id=person_proff.person WHERE person_proff.proff=9 ORDER BY person_proff.navika DESC LIMIT 50";
			$result = mysql_query($query);
			for ($j=0; $j<mysql_num_rows($result); $j++) 
			{
				$n=(!$n);
				$row = mysql_fetch_array($result);
				$orden = $row["orden"];
				$admin_level = $row["admin_level"];
				$dealer = $row["dealer"];
				$clan_s = $row["clan_short"];
				$clan_f = $row["clan"];
				$level=$row["level"];
				$id=$row["id"];
				$name=$row["login"];
				$navik_wood=$row["navika"];
				echo "<tr class='".($n?"l0":"l1")."'>";
				echo "<td width=30 align=right >".($j+1).".</td><td><script>drwfl('$name', '$id', '$level', '$dealer',  '$orden', '$admin_level', '$clan_s', '$clan_f');</script></td><td>".(int)$navik_wood."</td>";	
				echo "</tr>";
			}
	}
	else if ($act=='lesorub')
	{
		echo "<h3>Рейтинг лесорубов</h3>
		<tr class='l3' ><td align=right><b>№</b></td><td><b>Воин</b></td><td><b>рейтинг</b></td></tr>";
			$query = "SELECT users.id,login,level,orden,admin_level,dealer,clan_short,clan,navika FROM person_proff LEFT JOIN users on users.id=person_proff.person WHERE person_proff.navika>0 and person_proff.proff=5 ORDER BY person_proff.navika DESC LIMIT 50";
			$result = mysql_query($query);
			for ($j=0; $j<mysql_num_rows($result); $j++) 
			{
				$n=(!$n);
				$row = mysql_fetch_array($result);
				$orden = $row["orden"];
				$admin_level = $row["admin_level"];
				$dealer = $row["dealer"];
				$clan_s = $row["clan_short"];
				$clan_f = $row["clan"];
				$level=$row["level"];
				$id=$row["id"];
				$name=$row["login"];
				$navik_wood=$row["navika"];
				echo "<tr class='".($n?"l0":"l1")."'>";
				echo "<td width=30 align=right >".($j+1).".</td><td><script>drwfl('$name', '$id', '$level', '$dealer',  '$orden', '$admin_level', '$clan_s', '$clan_f');</script></td><td>".(int)$navik_wood."</td>";	
				echo "</tr>";
			}
	}
	else if ($act=='auction')
	{
		echo "<h3>Рейтинг торговцев</h3>
		<tr class='l3' ><td align=right><b>№</b></td><td><b>Воин</b></td><td><b>рейтинг</b></td></tr>";
			$result = mysql_query("SELECT users.id, login, level, orden, admin_level, dealer, clan_short, clan, navika FROM person_proff LEFT JOIN users on users.id=person_proff.person WHERE person_proff.navika>0 and person_proff.proff=10 ORDER BY person_proff.navika DESC LIMIT 50");
			while($row = mysql_fetch_array($result))
			{
				$n=(!$n);
				$j++;
				echo "<tr class='".($n?"l0":"l1")."'>";
				echo "<td width=30 align=right >".$j.".</td><td><script>drwfl('".$row["login"]."', '".$row["id"]."', '".$row["level"]."', '".$row["dealer"]."',  '".$row["orden"]."', '".$row["admin_level"]."', '".$row["clan_short"]."', '".$row["clan"]."');</script></td><td>".(int)$row["navika"]."</td>";	
				echo "</tr>";
			}
			unset($j);
	}
	else if ($act=='ribak')
	{
		echo "<h3>Рейтинг Рыбака</h3>
		<tr class='l3' ><td align=right><b>№</b></td><td><b>Воин</b></td><td><b>рейтинг</b></td></tr>";
			$query = "SELECT users.id,login,level,orden,admin_level,dealer,clan_short,clan,navika FROM person_proff LEFT JOIN users on users.id=person_proff.person WHERE person_proff.navika>0 and person_proff.proff=1 ORDER BY person_proff.navika DESC LIMIT 50";
			$result = mysql_query($query);
			for ($j=0; $j<mysql_num_rows($result); $j++) 
			{
				$n=(!$n);
				$row = mysql_fetch_array($result);
				$orden = $row["orden"];
				$admin_level = $row["admin_level"];
				$dealer = $row["dealer"];
				$clan_s = $row["clan_short"];
				$clan_f = $row["clan"];
				$level=$row["level"];
				$id=$row["id"];
				$name=$row["login"];
				$navik_wood=$row["navika"];
				echo "<tr class='".($n?"l0":"l1")."'>";
				echo "<td width=30 align=right >".($j+1).".</td><td><script>drwfl('$name', '$id', '$level', '$dealer',  '$orden', '$admin_level', '$clan_s', '$clan_f');</script></td><td>".(int)$navik_wood."</td>";	
				echo "</tr>";
			}
	}
	else if ($act=='turnir')
	{
		echo "<h3>Турнирный рейтинг</h3>
		<tr class='l3' ><td align=right><b>№</b></td><td><b>Воин</b></td><td><b>рейтинг</b></td></tr>";
			$query = "SELECT us.login, us.id, us.level, us.orden, us.admin_level, us.dealer, us.clan_short, us.clan, deztow_turnir.winner, count(*) as t FROM `deztow_turnir` LEFT JOIN users us on us.login= deztow_turnir.winner WHERE deztow_turnir.winner!='' GROUP by winner ORDER BY  t DESC LIMIT 50";
			$result = mysql_query($query);
			for ($j=0; $j<mysql_num_rows($result); $j++) 
			{
				$n=(!$n);
				$row = mysql_fetch_array($result);
				$orden = $row["orden"];
				$admin_level = $row["admin_level"];
				$dealer = $row["dealer"];
				$clan_s = $row["clan_short"];
				$clan_f = $row["clan"];
				$level=$row["level"];
				$id=$row["id"];
				$name=$row["login"];
				$user=$row["user"];
				$turnir_count=$row["t"];
				echo "<tr class='".($n?"l0":"l1")."'>";
				echo "<td width=30 align=right >".($j+1).".</td><td><script>drwfl('$name', '$id', '$level', '$dealer',  '$orden', '$admin_level', '$clan_s', '$clan_f');</script></td><td>".(int)$turnir_count."</td>";	
				echo "</tr>";
			}
	}
	else if ($act=='svet_tma')
	{
		$align=mysql_fetch_assoc(mysql_query("SELECT * FROM align WHERE 1"));
		$sum=$align["svet"]+$align["tma"]+$align["neytral"];
		
		$svet_width=floor($align["svet"]*100/$sum);
		$tma_width=floor($align["tma"]*100/$sum);
		$neytral_width=100-$svet_width-$tma_width;
		?>
		<table>
		<tr>
		<td colspan='3'>
			<table class='shkala' width=100%>
			<tr>
				<td width='<?=$svet_width?>%' align='right' class='shkala_red' style="position: relative;font-size:10px;"><SPAN style='position: absolute; left: 5; top:5; z-index: 1; font-weight: bold; color: #FFFFFF'>Свет</SPAN><img src='img/index/align/middel.gif' style='position:relative; left:3px;'/></td>
				<td width='<?=$tma_width?>%' align='right' class='shkala_blue' style="position: relative;font-size:10px;"><SPAN style='position: absolute; left: 5; top:5; z-index: 1; font-weight: bold; color: #FFFFFF'>Тьма</SPAN><img src='img/index/align/middel.gif' style='position:relative; left:3px;'/></td>
				<td width='<?=$neytral_width?>%' style="position: relative;font-size:10px;"><SPAN style='position: absolute; left: 5; top:5; z-index: 1; font-weight: bold; color: #FFFFFF'>Нейтрал</SPAN></td>
			</tr>
			</table>
		</td>
		</tr>
		<tr>
		<td style='padding-left: 10px;'><?=$align[svet]?></td><td></td><td style='padding-left: 10px;'><?=$align[tma]?></td><td style='padding-left: 10px;'><?=$align[neytral]?></td>
		</tr>
		</table>
		<?
	}
	else if ($act=='svet')
	{
		echo "<h3>Альянс Света</h3>
		<tr class='l3' ><td align=right><b>№</b></td><td><b>Воин</b></td><td><b>рейтинг</b></td></tr>";
			$query = "SELECT id,login,level,orden,admin_level,dealer,clan_short,clan,win,lose FROM users WHERE orden=4 ORDER BY (win-lose) DESC LIMIT 0,50";
			$result = mysql_query($query);
			for ($j=0; $j<mysql_num_rows($result); $j++) 
			{
				$n=(!$n);
				$row = mysql_fetch_array($result);
				$orden = $row["orden"];
				$admin_level = $row["admin_level"];
				$dealer = $row["dealer"];
				$clan_s = $row["clan_short"];
				$clan_f = $row["clan"];
				$level=$row["level"];
				$id=$row["id"];
				$name=$row["login"];
				$win=$row["win"];
				$lose=$row["lose"];
				echo "<tr class='".($n?"l0":"l1")."'>";
				echo "<td width=30 align=right >".($j+1).".</td><td><script>drwfl('$name', '$id', '$level', '$dealer',  '$orden', '$admin_level', '$clan_s', '$clan_f');</script></td><td>".(int)($win-$lose)."</td>";	
				echo "</tr>";
			}
	}
	else if ($act=='tma')
	{
		echo "<h3>Альянс Тьмы</h3>
		<tr class='l3' ><td align=right><b>№</b></td><td><b>Воин</b></td><td><b>рейтинг</b></td></tr>";
			$query = "SELECT id,login,level,orden,admin_level,dealer,clan_short,clan,win,lose FROM users WHERE orden in (2,6) ORDER BY (win-lose) DESC LIMIT 0,50";
			$result = mysql_query($query);
			for ($j=0; $j<mysql_num_rows($result); $j++) 
			{
				$n=(!$n);
				$row = mysql_fetch_array($result);
				$orden = $row["orden"];
				$admin_level = $row["admin_level"];
				$dealer = $row["dealer"];
				$clan_s = $row["clan_short"];
				$clan_f = $row["clan"];
				$level=$row["level"];
				$id=$row["id"];
				$name=$row["login"];
				$win=$row["win"];
				$lose=$row["lose"];
				echo "<tr class='".($n?"l0":"l1")."'>";
				echo "<td width=30 align=right >".($j+1).".</td><td><script>drwfl('$name', '$id', '$level', '$dealer',  '$orden', '$admin_level', '$clan_s', '$clan_f');</script></td><td>".(int)($win-$lose)."</td>";	
				echo "</tr>";
			}
	}
	else if ($act=='neytral')
	{
		echo "<h3>Альянс Нейтралов</h3>
		<tr class='l3' ><td align=right><b>№</b></td><td><b>Воин</b></td><td><b>рейтинг</b></td></tr>";
			$query = "SELECT id,login,level,orden,admin_level,dealer,clan_short,clan,win,lose FROM users WHERE orden=3 ORDER BY (win-lose) DESC LIMIT 0,50";
			$result = mysql_query($query);
			for ($j=0; $j<mysql_num_rows($result); $j++) 
			{
				$n=(!$n);
				$row = mysql_fetch_array($result);
				$orden = $row["orden"];
				$admin_level = $row["admin_level"];
				$dealer = $row["dealer"];
				$clan_s = $row["clan_short"];
				$clan_f = $row["clan"];
				$level=$row["level"];
				$id=$row["id"];
				$name=$row["login"];
				$win=$row["win"];
				$lose=$row["lose"];
				echo "<tr class='".($n?"l0":"l1")."'>";
				echo "<td width=30 align=right >".($j+1).".</td><td><script>drwfl('$name', '$id', '$level', '$dealer',  '$orden', '$admin_level', '$clan_s', '$clan_f');</script></td><td>".(int)($win-$lose)."</td>";	
				echo "</tr>";
			}
	}
	else if ($act=='casino')
	{
		echo "<h3>Рейтинг Дом отдыха</h3>
		<tr class='l3' ><td align=right><b>№</b></td><td><b>Воин</b></td><td><b>рейтинг</b></td></tr>";
			$result = mysql_query("SELECT id,login,level,orden,admin_level,dealer,clan_short,clan ,Price FROM casino LEFT JOIN users on users.login=casino.Username WHERE Price>0 ORDER BY Price DESC LIMIT 0,50");
			while ($row = mysql_fetch_array($result)) 
			{
				$j++;
				$n=(!$n);
				$orden = $row["orden"];
				$admin_level = $row["admin_level"];
				$dealer = $row["dealer"];
				$clan_s = $row["clan_short"];
				$clan_f = $row["clan"];
				$level=$row["level"];
				$id=$row["id"];
				$name=$row["login"];
				$Price=$row["Price"];
				echo "<tr class='".($n?"l0":"l1")."'>";
				echo "<td width=30 align=right >".($j).".</td><td><script>drwfl('$name', '$id', '$level', '$dealer',  '$orden', '$admin_level', '$clan_s', '$clan_f');</script></td><td>".(int)($Price)."</td>";	
				echo "</tr>";
			}		
	}
	mysql_close();
	?>
	</td>
</tr>
</table>
</body>
</html>