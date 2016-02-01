<?
include ("time.php");
$login=$_SESSION['login'];
?>
<body style="background-image: url();background-repeat:no-repeat;background-position:top right">
<h3>Поздравляем для Сундук!</h3>
<TABLE width=100% border=0>
<tr valign=top>
	<td width=100%>
	</td>
	<td align=right nowrap>
		<input type=button onclick="location.href='main.php?act=go&level=okraina'" value="Вернуться" class="newbut" >
		<input type=button onclick="location.href='main.php?act=none'" value="Обновить" class="newbut" >
	</td>
</tr>
</TABLE>

<TABLE width=100% border=0>
<tr>
<td>
<?
	if ($_GET['action']=="del" && is_numeric($_GET['id']) && $db["admin_level"]>=1)
	{
		mysql_query("UPDATE novruz SET text='<font color=#ff0000><i>Удалено Стражом порядка ".$login."</i></font>' WHERE id='".(int)$_GET['id']."'");
	}
	############################################################################
	if ($_GET["action"]=="get_heart" && $db["id"])
	{
		//cerwenbelerde
		if (date(n)==1 && date(j)==01)
		{
			$have_gift=mysql_fetch_array(mysql_query("SELECT * FROM hediyye WHERE owner='".$db["id"]."'"));
			if (!$have_gift)
			{
				mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author) VALUES ('".$login."','94','scroll','magic','20','1','Администрации WWW.MEYDAN.AZ')");#Восстановление энергии 1000HP 
				mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author) VALUES ('".$login."','176','scroll','magic','20','1','Администрации WWW.MEYDAN.AZ')");#Восстановление маны 1000MN 
				mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author) VALUES ('".$login."','61','scroll','magic','5','1','Администрации WWW.MEYDAN.AZ')");#Воскрешение 
				mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author) VALUES ('".$login."','116','scroll','magic','5','1','Администрации WWW.MEYDAN.AZ')");#Клонирование
				
				mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author,term) VALUES ('".$login."','220','scroll','magic','50','1','Администрации WWW.MEYDAN.AZ','".(time()+30*24*3600)."')");#Большое Эликсир Жизни
					
				mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author,term) VALUES ('".$login."','239','scroll','magic','10','1','Администрации WWW.MEYDAN.AZ','".(time()+30*24*3600)."')");#Зелье Пронзающих Игл
				mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author,term) VALUES ('".$login."','240','scroll','magic','10','1','Администрации WWW.MEYDAN.AZ','".(time()+30*24*3600)."')");#Зелье Сверкающих Лезвий
				mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author,term) VALUES ('".$login."','241','scroll','magic','10','1','Администрации WWW.MEYDAN.AZ','".(time()+30*24*3600)."')");#Зелье Свистящих Секир
				mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author,term) VALUES ('".$login."','242','scroll','magic','10','1','Администрации WWW.MEYDAN.AZ','".(time()+30*24*3600)."')");#Зелье Тяжелых Молотов
					
				mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author,term) VALUES ('".$login."','235','scroll','magic','10','1','Администрации WWW.MEYDAN.AZ','".(time()+30*24*3600)."')");#Большое Эликсир Ветра
				mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author,term) VALUES ('".$login."','236','scroll','magic','10','1','Администрации WWW.MEYDAN.AZ','".(time()+30*24*3600)."')");#Большое Эликсир Морей
				mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author,term) VALUES ('".$login."','237','scroll','magic','10','1','Администрации WWW.MEYDAN.AZ','".(time()+30*24*3600)."')");#Большое Эликсир Песков
				mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author,term) VALUES ('".$login."','238','scroll','magic','10','1','Администрации WWW.MEYDAN.AZ','".(time()+30*24*3600)."')");#Большое Эликсир Пламени
				
				mysql_query("INSERT INTO hediyye(owner) VALUES('".$db["id"]."')");
				$msg="Вы получили подарки...</b>.";
			}
			else $msg="Вы уже получили свой подарок...";
		}
		else $msg="Еще не время - 01.01.2016!";
	}
	############################################################################
	if ($_GET['action']=="getpodarka")
	{
		if (date(n)==1 && (date(j)>=01 && date(j)<=31))
		{	
			$findpodarka = mysql_fetch_array(mysql_query("SELECT count(*) FROM novruzpodarka WHERE login='".$login."' and type=2"));
			if (!$findpodarka[0])
			{
				
				mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author,term) VALUES ('".$login."','224','scroll','magic','10','1','Администрации WWW.MEYDAN.AZ','".(time()+30*24*3600)."')");#Нектар Отрицания
				mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author,term) VALUES ('".$login."','111','scroll','magic','10','1','Администрации WWW.MEYDAN.AZ','".(time()+30*24*3600)."')");#Большое Зелье Неуязвимости
				mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author,term) VALUES ('".$login."','220','scroll','magic','50','1','Администрации WWW.MEYDAN.AZ','".(time()+30*24*3600)."')");#Большое Эликсир Жизни
				mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author) VALUES ('".$login."','94','scroll','magic','75','1','Администрации WWW.MEYDAN.AZ')");#Восстановление энергии 1000HP 
				mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author) VALUES ('".$login."','176','scroll','magic','50','1','Администрации WWW.MEYDAN.AZ')");#Восстановление маны 1000MN 

				mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author) VALUES ('".$login."','52','scroll','magic','10','1','Администрации WWW.MEYDAN.AZ')");#Тактика Крови
				mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author) VALUES ('".$login."','53','scroll','magic','10','1','Администрации WWW.MEYDAN.AZ')");#Тактика Защиты
				mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author) VALUES ('".$login."','54','scroll','magic','10','1','Администрации WWW.MEYDAN.AZ')");#Тактика Ответа
				mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author) VALUES ('".$login."','55','scroll','magic','10','1','Администрации WWW.MEYDAN.AZ')");#Тактика Боя
				mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author) VALUES ('".$login."','258','scroll','magic','10','1','Администрации WWW.MEYDAN.AZ')");#Тактика Парирования

				mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author) VALUES ('".$login."','61','scroll','magic','10','1','Администрации WWW.MEYDAN.AZ')");#Воскрешение
				mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author) VALUES ('".$login."','116','scroll','magic','10','1','Администрации WWW.MEYDAN.AZ')");#Клонирование
				mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author) VALUES ('".$login."','4','scroll','magic','10','1','Администрации WWW.MEYDAN.AZ')");#Нападение

				if ($_GET["type"]=="mag")
				{
					mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author,term) VALUES ('".$login."','225','scroll','magic','5','1','Администрации WWW.MEYDAN.AZ','".(time()+30*24*3600)."')");#Снадобье Забытых Магистров
					mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author,term) VALUES ('".$login."','228','scroll','magic','15','1','Администрации WWW.MEYDAN.AZ','".(time()+30*24*3600)."')");#Ледяной Интеллект
				}
				else
				{
					mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author,term) VALUES ('".$login."','226','scroll','magic','5','1','Администрации WWW.MEYDAN.AZ','".(time()+30*24*3600)."')");#Снадобье Забытых Мастеров 
					mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author,term) VALUES ('".$login."','227','scroll','magic','15','1','Администрации WWW.MEYDAN.AZ','".(time()+30*24*3600)."')");#Сила Великана
				} 
			if ($db["level"]>=1)
			{	
				if ($db["level"]>=1)$item_str="(1163, 1165, 1033, 1164, 1162, 1034, 1532, 1533)";
				else if ($db["level"]==9)$item_str="(1163, 1165, 1033, 1164, 1162, 1034, 1532, 1533)";
				else if ($db["level"]>=10)$item_str="(1163, 1165, 1033, 1164, 1162, 1034, 1532, 1533)";
				$buy_item_sql=mysql_query("SELECT * FROM paltar WHERE id in $item_str");
				while ($buy_item=@mysql_Fetch_array($buy_item_sql))
				{
					mysql_query("INSERT INTO `inv` (`id`, `owner`, `img`, `gift`, `gift_author` , `object_id`, `object_type`, `object_razdel`, `name`,  `mass`, `price`, `gos_price`, `min_sila`, `min_lovkost`, `min_udacha`, `min_power`, `min_intellekt`, `min_vospriyatie`, `min_level`, `min_sword_vl`, `min_staff_vl`, `min_axe_vl`, `min_fail_vl`, `min_knife_vl`, `min_spear_vl`,`min_fire`,`min_water`,`min_air`,`min_earth`,`min_svet`,`min_tma`,`min_gray`,`add_fire`, `add_water`, `add_air`, `add_earth`, `add_svet`, `add_tma`, `add_gray`, `add_sila`, `add_lovkost`, `add_udacha`, `add_intellekt`, `add_duxovnost`, `add_hp`, `add_mana`, `protect_head`, `protect_arm`, `protect_corp`, `protect_poyas`, `protect_legs`, `protect_rej`, `protect_drob`, `protect_kol`, `protect_rub`, `protect_fire`, `protect_water`, `protect_air`, `protect_earth`, `protect_svet`, `protect_tma`, `protect_gray`,`protect_mag`,`protect_udar`, `shieldblock`, `krit`, `akrit`, `uvorot`, `auvorot`, `parry`, `counter`, `add_rej`, `add_drob`, `add_kol`, `add_rub`, `ms_udar`, `ms_krit`, `ms_mag`, `ms_fire`, `ms_water`, `ms_air`, `ms_earth`, `ms_svet`, `ms_tma`, `ms_gray`, `ms_rej`, `ms_drob`, `ms_kol`, `ms_rub`, `iznos_max`, `min_attack`, `max_attack`, `proboy`, `add_oruj`, `add_sword_vl`, `add_staff_vl`, `add_axe_vl`, `add_fail_vl`, `add_knife_vl`, `add_spear_vl`, `need_orden`, `sex`, `art`, `podzemka`, `is_personal`, `personal_owner`, `noremont`, `two_hand`, `second_hand`,  `add_fire_att`, `add_air_att`, `add_watet_att`, `add_earth_att`, `edited`) 
					VALUES (NULL, '".$login."','".$buy_item["img"]."' ,'1','Администрации WWW.OlDmeydan.Pe.Hu' ,'".$buy_item["id"]."', '".$buy_item["object"]."', 'obj', '".$buy_item["name"]."', '".$buy_item["mass"]."', '".$buy_item["price"]."', '".$buy_item["price"]."', '".$buy_item["min_sila"]."', '".$buy_item["min_lovkost"]."', '".$buy_item["min_udacha"]."', '".$buy_item["min_power"]."', '".$buy_item["min_intellekt"]."', '".$buy_item["min_vospriyatie"]."', '".$buy_item["min_level"]."', '".$buy_item["min_sword_vl"]."', '".$buy_item["min_staff_vl"]."', '".$buy_item["min_axe_vl"]."', '".$buy_item["min_fail_vl"]."', '".$buy_item["min_knife_vl"]."', '".$buy_item["min_spear_vl"]."', '".$buy_item["min_fire"]."','".$buy_item["min_water"]."','".$buy_item["min_air"]."','".$buy_item["min_earth"]."','".$buy_item["min_svet"]."','".$buy_item["min_tma"]."','".$buy_item["min_gray"]."', '".$buy_item["add_fire"]."', '".$buy_item["add_water"]."', '".$buy_item["add_air"]."', '".$buy_item["add_earth"]."', '".$buy_item["add_svet"]."', '".$buy_item["add_tma"]."', '".$buy_item["add_gray"]."', '".$buy_item["add_sila"]."', '".$buy_item["add_lovkost"]."', '".$buy_item["add_udacha"]."', '".$buy_item["add_intellekt"]."', '".$buy_item["add_duxovnost"]."', '".$buy_item["add_hp"]."', '".$buy_item["add_mana"]."', '".$buy_item["protect_head"]."', '".$buy_item["protect_arm"]."', '".$buy_item["protect_corp"]."', '".$buy_item["protect_poyas"]."', '".$buy_item["protect_legs"]."', '".$buy_item["protect_rej"]."', '".$buy_item["protect_drob"]."', '".$buy_item["protect_kol"]."', '".$buy_item["protect_rub"]."', '".$buy_item["protect_fire"]."', '".$buy_item["protect_water"]."', '".$buy_item["protect_air"]."', '".$buy_item["protect_earth"]."', '".$buy_item["protect_svet"]."', '".$buy_item["protect_tma"]."', '".$buy_item["protect_gray"]."', '".$buy_item["protect_mag"]."', '".$buy_item["protect_udar"]."','".$buy_item["shieldblock"]."','".$buy_item["krit"]."', '".$buy_item["akrit"]."', '".$buy_item["uvorot"]."', '".$buy_item["auvorot"]."', '".$buy_item["parry"]."', '".$buy_item["counter"]."', '".$buy_item["add_rej"]."', '".$buy_item["add_drob"]."', '".$buy_item["add_kol"]."', '".$buy_item["add_rub"]."', '".$buy_item["ms_udar"]."', '".$buy_item["ms_krit"]."', '".$buy_item["ms_mag"]."', '".$buy_item["ms_fire"]."', '".$buy_item["ms_water"]."', '".$buy_item["ms_air"]."', '".$buy_item["ms_earth"]."', '".$buy_item["ms_svet"]."', '".$buy_item["ms_tma"]."', '".$buy_item["ms_gray"]."', '".$buy_item["ms_rej"]."', '".$buy_item["ms_drob"]."', '".$buy_item["ms_kol"]."', '".$buy_item["ms_rub"]."', '10', '".$buy_item["min_attack"]."', '".$buy_item["max_attack"]."', '".$buy_item["proboy"]."','".$buy_item["add_oruj"]."' ,'".$buy_item["add_sword_vl"]."', '".$buy_item["add_staff_vl"]."', '".$buy_item["add_axe_vl"]."', '".$buy_item["add_fail_vl"]."', '".$buy_item["add_knife_vl"]."', '".$buy_item["add_spear_vl"]."', '".$buy_item["need_orden"]."', '".$buy_item["sex"]."', '".$buy_item["art"]."', '1', '".$buy_item["is_personal"]."', '".$buy_item["personal_owner"]."', '1', '".$buy_item["two_hand"]."', '".$buy_item["second_hand"]."',  '".$buy_item["add_fire_att"]."', '".$buy_item["add_air_att"]."', '".$buy_item["add_watet_att"]."', '".$buy_item["add_earth_att"]."', '".$buy_item["edited"]."');");
				}
			}			
			{	

				mysql_query("UPDATE users SET platina=platina+20000 WHERE login='".$login."'");
				$db["platina"]=$db["platina"]+20000;
				echo ("<script>alert('Вы Получили 20 000 Пл. и Сундук !');</script>");
			} 
			
				mysql_query("INSERT INTO novruzpodarka (login,type) VALUES('$login','2')");
				$msg="Поздравляем для Сундук!";
			}
			else $msg="Вы уже получали Сундук!";
		}
		else $msg="Еще не время! (01.01.2016-31.12.2016)";
	}
	############################################################################
	if (isset($_POST['text']) && $_POST['text']!="")
	{
		$text=htmlspecialchars(addslashes($_POST['text']));
		$text = wordwrap(trim($text), 40, " ",1);
		$next_time=time()+24*3600;
		$now=time();
		$find = mysql_fetch_array(mysql_query("SELECT * FROM novruz WHERE login='".$login."' ORDER BY time DESC LIMIT 1"));
		$my_time=$find['time'];
		if ($my_time<=$now)
		{
			mysql_query("INSERT INTO novruz (text,login,time) VALUES ('".$text."','".$login."','".$next_time."')");
			$msg="Ваше сообщение добавлено.";
		}
		else
		{
			$msg="Ещё: ".convert_time($my_time);
		}
	}
	//type=1  Ad gunu
	//type=2  New Year
	
	echo "<font style='color:#ff0000'>".$msg."</font><br/>";
	//----------------------------------novruz-------------------------------------------------------------------
	echo "<center>";
	//echo "<img src='img/upakovka/11.gif' onmouseover=\"slot_view('<b>От всей души</b>');\" onmouseout=\"slot_hide();\" style='cursor:hand;' onclick=\"location.href='?action=get_heart'\"> ";
	echo "<img src='img/upakovka/warrior.gif' onmouseover=\"slot_view('<b>Подарок Для Воина!</b>');\" onmouseout=\"slot_hide();\" style='cursor:hand;' onclick=\"location.href='?action=getpodarka&type=warrior'\"> ";
	echo "<img src='img/upakovka/mag.gif' 	onmouseover=\"slot_view('<b>Подарок Для Мага!</b>');\" onmouseout=\"slot_hide();\" style='cursor:hand;' onclick=\"location.href='?action=getpodarka&type=mag'\">";
	echo "</center>";

	//----------------------------------novruz-------------------------------------------------------------------

	$page=(int)abs($_GET['page']);
	$table = mysql_query("SELECT * FROM novruz");
	$page_cnt=mysql_num_rows($table);
	$cnt=$page_cnt; // общее количество записей во всём выводе
	$rpp=15; // кол-во записей на страницу
	$rad=2; // сколько ссылок показывать рядом с номером текущей страницы (2 слева + 2 справа + активная страница = всего 5)

	$links=$rad*2+1;
	$pages=ceil($cnt/$rpp);
	if ($page>0) { echo "<a href=\"?page=0\">«««</a> | <a href=\"?page=".($page-1)."\">««</a> |"; }
	$start=$page-$rad;
	if ($start>$pages-$links) { $start=$pages-$links; }
	if ($start<0) { $start=0; }
	$end=$start+$links;
	if ($end>$pages) { $end=$pages; }
	for ($i=$start; $i<$end; $i++) 
	{
		if ($i==$page) 
		{
			echo "<b style='color:#ff0000'><u>";
		} 
		else 
		{
			echo "<a href=\"?page=$i\">";
		}
		echo $i;
		if ($i==$page) 
		{
			echo "</u></b>";
		} 
		else 
		{
			echo "</a>";
		}
		if ($i!=($end-1)) { echo " | "; }
	}
	if ($pages>$links && $page<($pages-$rad-1)) { echo " ... <a href=\"?page=".($pages-1)."\">".($pages-1)."</a>"; }
	if ($page<$pages-1) { echo " | <a href=\"?page=".($page+1)."\">»»</a> | <a href=\"?page=".($pages-1)."\">»»»</a>"; }

	$limit = $rpp;
	$eu = $page*$limit;
	echo "<br>";
	$SSS = mysql_query("SELECT novruz.id as ids, novruz.text, novruz.date, users.login, users.id, users.level, users.orden, users.admin_level, users.dealer, users.clan_short, users.clan FROM novruz LEFT JOIN users on users.login=novruz.login ORDER BY novruz.date DESC limit $eu, $limit");
	while($DATA = mysql_fetch_array($SSS))
	{
		$DATA['text']=str_replace("&amp;","&",$DATA['text']);
		$DATA['text']=str_replace("&amp;","&",$DATA['text']);
		$delid=$DATA['ids'];
		echo "<font class=date>".$DATA["date"]."</font> ";
		echo "<script>drwfl('".$DATA['login']."', '".$DATA['id']."', '".$DATA['level']."', '".$DATA['dealer']."', '".$DATA['orden']."', '".$DATA['admin_level']."', '".$DATA['clan_short']."', '".$DATA['clan']."');</script>";
		echo " - ".$DATA['text'];				
		echo (($db['orden']==1)?"&nbsp; <a href='?action=del&id=$delid'><img src='img/del.gif'></a>":"");
		echo "<br>";
	}
		echo '
		<form method="POST">
			Ваше пожелание:	<input type=text name="text" value="" maxlength="1024" size=50> <input type="submit" name="add" value=" Добавить ">
		</form>';

?>
</td>
</tr>
</table>