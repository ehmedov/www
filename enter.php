<?
session_start();
@ob_start("ob_gzhandler");
include("conf.php");
include ("functions.php");
if (getenv('REMOTE_ADDR')!="85.132.96.76")include("browser.php");
$times=md5(time());
//-----------------------------------------
if($break == 1) {Header("Location: index.php?tmp=$times");   die();}
$ip=userip();
$my_remote=getenv('REMOTE_ADDR');

if (isset($_SESSION['logins']) && isset($_SESSION['psw']))
{
	$login_auth=$_SESSION['logins'];
	$password=$_SESSION['psw'];
	unset($_SESSION['logins']);
	unset($_SESSION['psw']);
}
else if (isset($_POST['logins']) && isset($_POST['psw']))
{
	$login_auth=$_POST['logins'];
	$password=$_POST['psw'];
}
$login_auth=htmlspecialchars(addslashes($login_auth));
$password=htmlspecialchars(addslashes($password));

$chas = date("H");
$server_date=date("d.m.Y", mktime($chas));
$server_time=date("H:i:s", mktime($chas));

$data = @mysql_connect($base_name, $base_user, $base_pass) or die('Не получается подключиться. Проверьте имя сервера, имя пользователя и пароль!');
mysql_select_db($db_name) or die('Ошибка входа в базу данных');

$is_ip=mysql_fetch_array(mysql_query("SELECT end_time, remote_ip FROM ip_block WHERE remote_ip='".$my_remote."' and end_time>".time()));

if ($is_ip)
{
	$error="Ошибка! Ваш IP <b>".$is_ip[1]."</b> заблокирован до ".date('d.m.Y H:i', $is_ip[0])."<br>";
}
else
{		
	if($login_auth!="" && $password!="")
	{
		$DATA  = mysql_fetch_array(mysql_query("SELECT * FROM `users` LEFT JOIN info on info.id_pers=users.id WHERE login='".$login_auth."'"));
		if ($DATA)
		{
			if($password != base64_decode($DATA["password"]))
			{
				mysql_query("INSERT INTO `report`(date,login,action,type,ip) VALUES('$server_date-$server_time','".$DATA["login"]."','Неверный пароль','2','".$my_remote."')");
				$error="Ошибка! Неверный пароль для \"$login_auth\".<br>";
			}
			else
			{
				if($DATA["blok"])
			    {
			    	$error="Персонаж \"".$DATA["login"]."\" казнен.<BR>Причина казни: ".$DATA["blok_reason"].".<br><br><img src='img/index/turma.jpg'><br>";
			    }
			    else 
			    {	
			    	if ($DATA["password1"]!="")
			    	{
						$_SESSION['logins']=$DATA["login"];
			    		$_SESSION['psw']=base64_decode($DATA["password"]);
			    		if ($_POST['code']) 
			        	{
			          		$ok=true;
			          		if ($_POST['code']!=$DATA['password1'])
			          		{
			          			$ok=false;
								mysql_query("INSERT INTO `report`(date,login,action,type,ip) VALUES('$server_date-$server_time','".$DATA["login"]."','Неверный Запрос второго пароля ','5','".$my_remote."')");
			          			$mess='Ошибка! Неверный пароль...';
			          		}
			        	}
			        	else
			        	{  
			        		$ok=false; 
			        	}
	          			if (!$ok) 
	          			{
		          			echo "<B style='color:#ffffff'>$mess &nbsp;</B>";
				      		echo '<TITLE>Второй пароль</TITLE>
				      			<LINK REL=StyleSheet HREF="main.css" TYPE="text/css">
								<BODY bgcolor="#666666">
								<div align="center"><b>Запрос второго пароля к персонажу.</b><br><br><br>
										<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" width="180" height="210" id="password" align="middle">
										<param name="allowScriptAccess" value="sameDomain" />
										<param name="allowFullScreen" value="false" />
										<param name="movie" value="password.swf?1" /><param name="quality" value="high" /><param name="bgcolor" value="#ffffff" />	<embed src="password.swf" quality="high" bgcolor="#ffffff" width="180" height="210" name="password" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
										</object>
								</div>';
					    	die();
				    	}
			    	}	
			    	else if ($DATA["password1"]=="") $ok=true;
					if ($ok==true)
					{
						$birth=explode(".",$DATA["birth"]);
						$zd=$birth[0];
						$zm=$birth[1];
						$_SESSION["login"]=$DATA["login"];
						$_SESSION["uin_id"]=$DATA["id"];
						$_SESSION["clan_short"]=$DATA["clan_short"];
						$sesid=session_id();
						$_SESSION["session_user_id"]=$sesid;
						$GET_ONLINE      = mysql_query("SELECT * FROM `online` WHERE login='".$DATA["login"]."'");
						$GET_ONLINE_DATA = mysql_fetch_array($GET_ONLINE);
						mysql_free_result($GET_ONLINE);
					    if(!$GET_ONLINE_DATA)
					    {
					    	mysql_query("INSERT INTO `online`(ip,remote_ip,login,uniqPCID,room,city,browser) VALUES('".$ip."','".$my_remote."','".$DATA["login"]."','".$sesid."','".$DATA["room"]."','".$DATA["city_game"]."','".getenv("HTTP_USER_AGENT")."')");
					    }
					    else
					    {
					    	mysql_query("UPDATE `online` SET ip='".$ip."',remote_ip='".$my_remote."',uniqPCID='".$sesid."',room='".$DATA["room"]."',city='".$DATA["city_game"]."' WHERE login='".$DATA["login"]."'");
					    }
						//SetCookie("user", $DATA["login"],time()+365*24*3600);
						//SetCookie("sessid", $sesid,time()+365*24*3600);
						echo "<b>Авторизация окончена...</b>";
						$last_visit_ip=mysql_fetch_array(mysql_query("SELECT ip FROM report WHERE time_stamp=(SELECT MAX(time_stamp) FROM report WHERE login='".$DATA["login"]."' and type='1')"));
					 	$zayavka_c_m = 1;
						$zayavka_c_o = 1;
						$battle_ref  = 0;
						@session_register('zayavka_c_m','zayavka_c_o','battle_ref');

						if($last_visit_ip["ip"]!=$ip)talk($DATA["login"],"В предыдущий раз этим персонажем заходили с другого компьютера!!!",$DATA);
						mysql_query("INSERT INTO `report`(date,login,action,type,ip) VALUES('$server_date-$server_time','".$DATA["login"]."','Персонаж авторизировался','1','".$my_remote."')");
						mysql_query("UPDATE users SET last_ip='".$ip."',remote_ip='".$my_remote."' WHERE login='".$DATA["login"]."'");
						if ($zd==date('d') && $zm==date('m')) $_SESSION["my_birth"]=1;
						//$_SESSION["user_data"]=$DATA;
						$_SESSION['my_room']=$DATA["room"];
						unset($_SESSION["lock"]);
						Header("Location: battles.php?tmp=$times");die();
						#else {Header("Location: http://".$DATA["city_game"].".OlDmeydan.Pe.Hu/battles.php?tmp=$times");die();}
					}
			    }
			}
		}
		else
		{
			$error="Ошибка! Такого персонажа  \"$login_auth\" не существует...<BR>";
		}
	}
	else $error="Ошибка! Вы не ввели логин либо пароль!<BR>";
}
echo "
<html>
<head>
	<title>WwW.OlDmeydan.Pe.Hu - [ Авторизация ]</title>
	<link rel=stylesheet href=\"main.css\" type=\"text/css\">
</head>
<body bgcolor=\"#faeede\">
<b style='color:#ff0000'>".$error."</b><br>
<hr>
<div align=right><a href='http://www.OlDmeydan.Pe.Hu'>© 2006-".date("Y")." WwW.OlDmeydan.Pe.Hu - Самый азартный проект в Азербайджане!</a></div>
</body>
</html>";
?>