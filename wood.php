<?
	session_start();
	$login=$_SESSION["login"];
	Header("Cache-Control: no-cache, must-revalidate"); // говорим браузеру что-бы он не кешировал эту страницу
	Header("Pragma: no-cache");
	include "conf.php";
	include "functions.php";
	
	$data = mysql_connect($base_name, $base_user, $base_pass) or die('Не получается подключиться. Проверьте имя сервера, имя пользователя и пароль!');
	mysql_select_db($db_name) or die('Ошибка входа в базу данных');
	if ($login!="bor")die("olmaz");
?>
<html>
<HEAD>	
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<meta http-equiv="Content-Language" content="ru">
	<META Http-Equiv=Cache-Control Content="no-cache, max-age=0, must-revalidate, no-store">
	<meta http-equiv=PRAGMA content=NO-CACHE>
	<meta http-equiv=Expires content=0>	
	<LINK REL=StyleSheet HREF='main.css' TYPE='text/css'>
</HEAD>
<body bgcolor=#dddddd topMargin=0 leftMargin=0 rightMargin=0 bottomMargin=0>
<?
	
	echo "<a href='?act=report'>REPORT</a> | <a href='?act=expired'>Delete Expired Scrolls</a> | <a href='?act=expired_flower'>Delete Expired FLOWERS</a> | <a href='?act=reports'>Delete OLd Repost</a>
	    | <a href='?act=del_bloked'>DELETE  BLOKED PERS INV</a> | <a href='?act=del_perevod'>DELETE PEREVOD</a><br>
	    <a href='?act=del_users'>DELETE BLOKED USERS</a>  | <a href='?act=del_runas'>Delete RUNAS</a> | <a href='?act=update_run'>UPDATE RUNAS</a> | <a href='?act=update_scrolls'>UPDATE SCROLLS</a>
	| <a href='?act=medal'>UPDATE MEDAL</a> | <a href='?act=usileniya'>IMENNOYLAR</a> | <a href='?act=give_pl'>ARTLARI SATIWI</a>  | <a href='?act=chg_img'>CHANGE IMG</a>  | <a href='?act=chg_paltar'>CHANGE PALTAR NAME</a><hr>
	<a href='?act=animal'>ANIMAL</a>";
	
	if ($_GET["act"]=="report") 
	{
		$date1=strtotime(date('d.m.Y'));
		$date2=$date1+24*60*60;
		$sql=mysql_query("SELECT * FROM report WHERE (UNIX_TIMESTAMP(time_stamp)>=$date1 and UNIX_TIMESTAMP(time_stamp)<$date2) and type=1 GROUP BY login ORDER BY time_stamp ASC ");
		while ($query=mysql_fetch_Array($sql))
		{
			echo $query["id"]." - ".$query["time_stamp"]." - ".$query["login"]." - ".$query["action"]." - ".$query["ip"]."<br>";
		}
	}
	else if ($_GET["act"]=="animal") 
	{
		#Zverlerle iwlemek
		include("bot_exp.php");
		$k=mysql_query("SELECT * FROM `zver` WHERE 1");
		while ($zver=mysql_fetch_Array($k))
		{
			mysql_query("UPDATE zver SET  hp_all=".($a[$zver["type"]][$zver["level"]]["power"]*6)." , 
			sila=".$a[$zver["type"]][$zver["level"]]["sila"]." , lovkost=".$a[$zver["type"]][$zver["level"]]["lovkost"]." , udacha=".$a[$zver["type"]][$zver["level"]]["udacha"]." , power=".$a[$zver["type"]][$zver["level"]]["power"]." , intellekt=".$a[$zver["type"]][$zver["level"]]["intellekt"]." , vospriyatie=".$a[$zver["type"]][$zver["level"]]["vospriyatie"]." , 
			krit=".$a[$zver["type"]][$zver["level"]]["krit"]." , akrit=".$a[$zver["type"]][$zver["level"]]["akrit"]." , uvorot=".$a[$zver["type"]][$zver["level"]]["uvorot"]." , auvorot=".$a[$zver["type"]][$zver["level"]]["auvorot"]." , 
			hand_r_hitmin=".$a[$zver["type"]][$zver["level"]]["hand_r_hitmin"]." , hand_r_hitmax=".$a[$zver["type"]][$zver["level"]]["hand_r_hitmax"]." , hand_l_hitmin=".$a[$zver["type"]][$zver["level"]]["hand_l_hitmin"]." , hand_l_hitmax=".$a[$zver["type"]][$zver["level"]]["hand_l_hitmax"].",
			bron_head=".$a[$zver["type"]][$zver["level"]]["bron_head"]." , bron_corp=".$a[$zver["type"]][$zver["level"]]["bron_corp"]." , bron_poyas=".$a[$zver["type"]][$zver["level"]]["bron_poyas"]." , bron_legs=".$a[$zver["type"]][$zver["level"]]["bron_legs"]." 
			WHERE id='".$zver["id"]."'");
		}
		echo "finiw";
	}
	else if ($_GET["act"]=="give_pl") 
	{
		/*$query=mysql_query("SELECT users.login, zver.* FROM `zver` LEFT JOIN users on users.id=zver.owner WHERE type='dragon' and zver.level<30");
		while($res=mysql_fetch_Array($query))
		{
			mysql_query("UPDATE users SET platina=platina+2500 WHERE login='".$res["login"]."'");
			history($res["login"],"Продан звер: ".$res["name"]."[".$res["level"]."]","2500 Пл.","","Инвентарь");
			mysql_query("DELETE FROM zver WHERE id=".$res["id"]);
			echo "UPDATE users SET platina=platina+2500 WHERE login='".$res["login"]."'<br>";
		}
		echo "finiw";*/
	}
	else if ($_GET["act"]=="chg_img") 
	{
		$query=mysql_query("SELECT id,img FROM paltar");
		while ($res=mysql_fetch_array($query))
		{
			mysql_query("UPDATE inv SET img='".$res["img"]."' WHERE object_razdel = 'obj' AND object_id =".$res["id"]);
		}
		echo "finiw";
	}
	else if ($_GET["act"]=="chg_paltar") 
	{
		$query=mysql_query("SELECT id,name FROM paltar");
		while ($res=mysql_fetch_array($query))
		{
			mysql_query("UPDATE inv SET name='".$res["name"]."' WHERE object_razdel = 'obj' AND object_id =".$res["id"]);
		}
		echo "finiw";
	}
	else if ($_GET["act"]=="usileniya") 
	{
		$query=mysql_query("SELECT * FROM paltar WHERE is_personal=1");
		while($res=mysql_fetch_Array($query))
		{
			echo $res["id"]."-".$res["object"]."-<b>".$res["personal_owner"]."</b>-".$res["price"]."<br>";
		}
		/*$query=mysql_query("SELECT inv.id,inv.owner,paltar.podzemka,paltar.price FROM inv LEFT JOIN paltar on paltar.id=inv.object_id WHERE paltar.podzemka=1 LIMIT 50000");
		while($res=mysql_fetch_Array($query))
		{
			mysql_query("UPDATE users SET naqrada=naqrada+".$res["price"]." WHERE login='".$res["owner"]."'");
			//history($res["owner"],"Гравировка за 50 Пл.","50 Пл.","","Инвентарь");
		    mysql_query("DELETE FROM inv WHERE id=".$res["id"]);
		    echo $res["owner"]."<br>";
		}
		echo "finiw";*/
	}
	else if ($_GET["act"]=="update_scrolls") 
	{
		$query=mysql_query("SELECT inv.owner,inv.id,scroll.price,scroll.art,scroll.name FROM inv LEFT JOIN scroll on scroll.id=inv.object_id WHERE inv.object_razdel='magic'");
		while($res=mysql_fetch_Array($query))
		{
			if ($res["art"]==1)
			{
				mysql_query("UPDATE users set platina=platina+".$res["price"]." WHERE login='".$res["owner"]."'");
				history($res["owner"],"AVTOMATIK SATILIB",$res["name"]."-".$res["price"]." Пл.","","Инвентарь");
			}
			else
			{
				mysql_query("UPDATE users set money=money+".$res["price"]." WHERE login='".$res["owner"]."'");
			}
	        mysql_query("DELETE FROM inv WHERE id=".$res["id"]);
		}
	}
	else if ($_GET["act"]=="expired") 
	{
		$query=mysql_query("SELECT scroll.del_time,scroll.name,inv.owner, inv.id as ids, inv.term FROM inv LEFT JOIN scroll on scroll.id=inv.object_id WHERE inv.object_razdel='magic' and inv.wear=0");
		while($res=mysql_fetch_Array($query))
		{
			if ($res["del_time"]>0)
	        {
	        	if ($res["term"]<time())
	        	{
	        		$total+=1;
	        		mysql_query("DELETE FROM inv WHERE id=".$res["ids"]);
	        		//history($login,"Закончился срок годности",$name,$db["remote_ip"],"Инвентарь");
	        	}
	        }
		}
		echo "TOTAL:".$total;
	} 
	else if ($_GET["act"]=="expired_flower" && $login=="bor") 
	{
		mysql_query("DELETE FROM `inv` WHERE object_type='flower' and term<".time());
		echo mysql_affected_rows();
	} 
	else if ($_GET["act"]=="reports" && $login=="bor") 
	{
		$all_u=mysql_query("SELECT login FROM users");
		while ($all_users=mysql_fetch_array($all_u))
		{
			$user_name=$all_users["login"];
			$time_out=mysql_fetch_Array(mysql_query("SELECT MAX(UNIX_TIMESTAMP(time_stamp)) as max FROM report WHERE login='".$user_name."' and type='1'"));
			mysql_query("DELETE FROM report WHERE login='".$user_name."' and UNIX_TIMESTAMP(time_stamp)<".($time_out["max"]-3*24*3600));
			echo $user_name."|".mysql_affected_rows()."<br>";
		}
	} 
	else if ($_GET["act"]=="del_perevod" && $login=="bor") 
	{
		$all_u=mysql_query("SELECT login FROM users WHERE 1");
		while ($all_users=mysql_fetch_array($all_u))
		{
			$user_name=$all_users["login"];
			$time_out=mysql_fetch_Array(mysql_query("SELECT MAX(UNIX_TIMESTAMP(date)) as max FROM perevod1 WHERE login='".$user_name."'"));
			mysql_query("DELETE FROM perevod1 WHERE login='".$user_name."' and UNIX_TIMESTAMP(date)<".($time_out["max"]-3*24*3600));
			echo $user_name."|".mysql_affected_rows()."<br>";
		}
	} 
	else if ($_GET["act"]=="del_bloked" && $login=="bor") 
	{
		//DELETE  BLOKED PERS INV
		$sql=mysql_query("SELECT login,id FROM users WHERE blok=1");
		while($blok=mysql_fetch_Array($sql))
		{
			mysql_query("DELETE FROM friend WHERE login='".$blok["login"]."'");
			echo "DELETE FROM friend WHERE login=".$blok["login"].": ".mysql_affected_rows()."<br>";
			
			mysql_query("DELETE FROM inv WHERE owner='".$blok["login"]."' and object_razdel in ('other','thing')");
			echo "Records deleted inv for owner=".$blok["login"].": ".mysql_affected_rows()."<br>";
			
			mysql_query("DELETE FROM sklad WHERE owner=".$blok["id"]);
			echo "Records deleted inv for owner=".$blok["login"].": ".mysql_affected_rows()."<br>";
			
			mysql_query("DELETE FROM complect WHERE owner=".$blok["login"]);
			echo "Records deleted complect for owner=".$blok["login"].": ".mysql_affected_rows()."<br>";
			echo "<hr>";
		}
	}
	else if ($_GET["act"]=="del_users" && $login=="bor") 
	{
		echo '<form action="?act=del_users" method=post>
			<select name="user_level">';
			for ($i=0;$i<=8;$i++)
			echo '<option value="'.$i.'">LEVEL '.$i.'</option>';
			echo '</select>
			<INPUT type=submit name="open" value="Подать заявку" class=new></form>';
			if ($_POST["open"])
			{
				$level=(int)$_POST["user_level"];
				$qu=mysql_query("SELECT id,login FROM users WHERE level=$level and blok=1");
				while($result=mysql_fetch_array($qu))
				{
					$name=$result["login"];
					$user_id=$result["id"];
					mysql_query("DELETE FROM info WHERE id_pers='".$user_id."'");
					mysql_query("DELETE FROM users WHERE login='".$name."'");
					mysql_query("DELETE FROM inv WHERE owner='".$name."'");
					mysql_query("DELETE FROM bank WHERE login='".$name."'");
					mysql_query("DELETE FROM thread WHERE creator='".$name."'");
					mysql_query("DELETE FROM topic WHERE creator='".$name."'");
					mysql_query("DELETE FROM perevod WHERE login='".$name."'");
					mysql_query("DELETE FROM friend WHERE login='".$name."'");
					mysql_query("DELETE FROM friend WHERE friend='".$name."'");
					mysql_query("DELETE FROM house WHERE login='".$name."'");
					mysql_query("DELETE FROM report WHERE login='".$name."'");
					mysql_query("DELETE FROM person_proff WHERE person='".$user_id."'");
					mysql_query("DELETE FROM slots_priem WHERE user_id='".$user_id."'");
					echo "Персонаж <b>$name</b> удален из базы...<br>";
				}
			}
	} 
	else if ($_GET["act"]=="del_runas") 
	{
		$sql=mysql_query("SELECT id,owner,runas FROM inv WHERE runas!=''");
		while($res=mysql_fetch_array($sql))
		{
				$rname=explode("#",$res[runas]);
				$runa=mysql_fetch_array(mysql_query("SELECT id,name FROM runa WHERE type='".$rname[0]."'"));
				mysql_query("INSERT INTO `inv1` (`owner`, `object_id`, `object_type`, `object_razdel` ,`iznos`,  `iznos_max`) 
				VALUES 	('".$res[owner]."', '".$runa[id]."','runa','runa','0','1');");
				mysql_query("UPDATE inv SET runas='' WHERE id=".$res[id]);
				

				echo $res[owner]."-".$res[runas]."-".$runa[id]."-".$runa[name]."<br>";
		}
	}
	else if ($_GET["act"]=="update_run") 
	{
		$sql=mysql_query("SELECT id,owner,object_id FROM inv WHERE `object_razdel` = 'runa'");
		while($res=mysql_fetch_array($sql))
		{
				mysql_query("INSERT INTO `inv1` (`owner`, `object_id`, `object_type`, `object_razdel` ,`iznos`,  `iznos_max`) 
				VALUES 	('".$res[owner]."', '".$res[object_id]."','runa','runa','0','1');");
				mysql_query("DELETE FROM inv WHERE id=".$res[id]);

				echo $res[owner]."-".$res[id]."-".$res[object_id]."-".$runa[name]."<br>";
		}
	}
	/*$zaman=time()+10*12*30*24*3600;
	mysql_query("INSERT INTO effects (user_id,type,elik_id,add_mg_bron,add_bron,end_time) VALUES ('66434','mgbron','','60','150','$zaman')");
	*/
	//mysql_query("UPDATE runa SET price=20");
	//mysql_query("INSERT INTO `inv` (`owner`, `object_id`, `object_type`, `object_razdel` ,`iznos`,  `iznos_max`) VALUES 	('OBITEL', '9','runa','runa','0','1');");

	/*
	$zaman=time()+10*12*30*24*3600;
	mysql_query("INSERT INTO effects (user_id,type,elik_id,add_mg_bron,add_bron,end_time) VALUES ('0','mgbron','','60','150','$zaman')");

	//----------------------------------------------------------------------------------
	
	*/
	
	/*
	
	
	//--Medallarin verilmesi
	$sql=mysql_query("SELECT login FROM `users` WHERE level>=15");
	while($users=mysql_fetch_Array($sql))
	{
		mysql_query("INSERT INTO inv(owner,object_id,object_type,object_razdel,gift,wear,gift_author) VALUES('".$users["login"]."','27','medal','medal','1','0','WWW.MEYDAN.AZ')");
	}

	$sql=mysql_query("SELECT owner FROM inv WHERE object_razdel='obj' and object_id=".(int)$_GET["item_id"]);
	while($inv=mysql_fetch_Array($sql))
	{
		echo $inv["owner"]."</br>";
	}

	
	//---------------------------------------------------------------------------------------------------
	//awake house
	$result=mysql_query("SELECT * FROM house WHERE 1");
	while($res=mysql_fetch_array($result))
	{	
		$login=$res["login"];
		$add_eliktim=($res["eliktime"]>0?(time()+$res["eliktime"]):0);
		$add_bron_time=($res["bron_time"]>0?(time()+$res["bron_time"]):0);
		$add_magic_time=($res["magic_time"]>0?(time()+$res["magic_time"]):0);
		
		mysql_query("UPDATE house SET eliktime=0,bron_time=0,magic_time=0 WHERE login='".$login."'");
		mysql_query("UPDATE users SET son=0,eliktime=$add_eliktim,bron_time=$add_bron_time,magic_time=$add_magic_time WHERE login='".$login."'");
		mysql_query("UPDATE effects SET end_time= add_time+".time().",add_time=0 WHERE user_id=(SELECT id FROM users WHERE login='".$login."')");
		echo $login."<br>";
	}

	//---------------------------------------------------------------------------------------------------
	//Bankda 0 lari silmek
	$k=mysql_query("SELECT * FROM bank WHERE money=0 and emoney=0");
	while ($res=mysql_fetch_Array($k))
	{
		$txt="Банковский шот ".$res["number"]." был закрыт. (Баланс: ".$res["money"]." Зл. ".$res["emoney"]." Пл.)";
		mysql_query("INSERT INTO pochta(user,whom,text,subject) VALUES ('bor','".$res['login']."','".$txt."','Администрация www.meydan.az')");
		mysql_query("DELETE FROM bank WHERE number=".$res["number"]);
		echo $txt."<br>";
	}*/
?>