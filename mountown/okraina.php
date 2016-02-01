<?
#####################################################

if ($_GET["getGift"]==1 && $db["id"] && $give_all_gift)
{
	$have_gift=mysql_fetch_array(mysql_query("SELECT * FROM hediyye WHERE owner='".$db["id"]."'"));
	if (!$have_gift)
	{
		$have_elik=mysql_fetch_Array(mysql_query("SELECT * FROM effects WHERE user_id=".$db["id"]." and type='jj'"));
		if ($have_elik)
		{
			mysql_query("UPDATE users SET hp_all=hp_all-".$have_elik["add_hp"]." WHERE login='".$db["login"]."'");
			mysql_query("DELETE FROM effects WHERE id=".$have_elik["id"]);
		}

		$hp_add=$db["power"]*30;
		$zaman=time()+3*24*3600;
		$type="jj";
		
		mysql_query("UPDATE users SET hp_all=hp_all+".$hp_add." WHERE login='".$db["login"]."'");
		mysql_query("INSERT INTO effects (user_id,type,elik_id,add_hp,end_time) VALUES ('".$db["id"]."','".$type."','249','".$hp_add."','".$zaman."')");
		
		mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author) VALUES ('".$login."','94','scroll','magic','20','1','Администрации WWW.MEYDAN.AZ')");#Восстановление энергии 1000HP 
		mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author) VALUES ('".$login."','176','scroll','magic','20','1','Администрации WWW.MEYDAN.AZ')");#Восстановление маны 1000MN 
		mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author) VALUES ('".$login."','61','scroll','magic','5','1','Администрации WWW.MEYDAN.AZ')");#Воскрешение 
		mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author) VALUES ('".$login."','116','scroll','magic','5','1','Администрации WWW.MEYDAN.AZ')");#Клонирование
		
		mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author) VALUES ('".$login."','52','scroll','magic','5','1','Администрации WWW.MEYDAN.AZ')");#Тактика Крови
		mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author) VALUES ('".$login."','53','scroll','magic','5','1','Администрации WWW.MEYDAN.AZ')");#Тактика Защиты
		mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author) VALUES ('".$login."','54','scroll','magic','5','1','Администрации WWW.MEYDAN.AZ')");#Тактика Ответа
		mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author) VALUES ('".$login."','55','scroll','magic','5','1','Администрации WWW.MEYDAN.AZ')");#Тактика Боя
		mysql_query("INSERT INTO inv(owner, object_id, object_type, object_razdel, iznos_max, gift, gift_author) VALUES ('".$login."','258','scroll','magic','5','1','Администрации WWW.MEYDAN.AZ')");#Тактика Парирования
		
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
		$msg="Вы получили подарки... Вам удачно прокастовали заклинание <b>&laquo;Жажда жизни + $hp_add HP&raquo;</b>.";
	}
	else $msg="Вы уже получили свой подарок...";
}
#####################################################
$getOwner = mysql_fetch_assoc(mysql_query("SELECT * FROM castle_config LEFT JOIN clan on clan.name_short=castle_config.owner"));
if ($getOwner['owner'] != '')
{
	$owner = 'Захвачен Ханством '.$getOwner['name'];
}
else 
{
	$owner = 'Замок свободен';
}
echo "<font color='#ff0000'>".$msg."</font>";
?>
<table width=100% border="0" cellpadding="0" cellspacing="0" align=center>
<tr>
	<td valign=top  align="center">
		<?include_once("player.php");?>
	</td>
	<td align="right" valign="top" width=100%>
		<div style="background-repeat:no-repeat; background:url(img/swf/frame.gif); width:558px; height:362px; position:relative;">
			<div style="position:relative; width:526px; height:340px; top:14;left:-16;">
				<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="526" height="340" id="municip" align="middle">
					<param name="allowScriptAccess" value="sameDomain" />
					<param name="allowFullScreen" value="false" />
					<param name="movie" value="img/swf/okraina.swf?castle=<?=$owner?>&55" />
					<param name="quality" value="high" />
					<embed src="img/swf/okraina.swf?castle=<?=$owner?>&55" quality="high" width="526" height="340" name="municip" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
				</object>
			</div>
		</div>
	</td>
</tr>
</table>
<br><br><?include_once("counter.php");?>
</body>
</html>
