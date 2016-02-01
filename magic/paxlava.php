<?
session_start();
$login=$_SESSION['login'];
$spell=$_GET['spell'];
switch ($mtype) 
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
echo "<script>location.href='main.php?act=inv&otdel=magic'</script>";        
?>
