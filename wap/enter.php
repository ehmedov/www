<?
session_start();
ob_start("ob_gzhandler");
include_once ("conf.php");
include_once ("functions.php");
$times=md5(time());
echo '<?xml version="1.0" encoding="windows-1251"?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.2//EN" "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="en">';

?>
<head>
	<title>WAP.MEYDAN.AZ- �������� RPG ������ ���� ����������� ���� � �����</title>
	<link rel="stylesheet" href="main.css" type="text/css"/>	
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
	<meta http-equiv="Content-Language" content="ru" />
	<meta name="Description" content="�������� RPG ������ ���� ����������� ���� � �����. ������ ������, �������� �������, ��� ����, ����� ���� ����� ������ � �����." />
	<meta http-equiv="cache-control" content="no-cache" />
	<meta http-equiv="pragma" content="no-cache" />
	<meta http-equiv="expires" content="0" />
</head>
<body>
<div id="cnt" class="content">
<?
//-----------------------------------------
if($break == 1) 
{
	Header("Location: index.php?tmp=$times");
    exit();
}
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

$server_date=date("d.m.Y");
$server_time=date("H:i:s");

$data = mysql_connect($base_name, $base_user, $base_pass) or die('�� ���������� ������������. ��������� ��� �������, ��� ������������ � ������!');
mysql_select_db($db_name) or die('������ ����� � ���� ������');

$is_ip=mysql_fetch_array(mysql_query("SELECT end_time,remote_ip FROM ip_block WHERE remote_ip='".$my_remote."' and end_time>".time()));

if ($is_ip)
{
	$error="������! ��� IP <b>".$is_ip[1]."</b> ������������ �� ".date('d.m.Y H:i', $is_ip[0])."<br/>";
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
				mysql_query("INSERT INTO `report`(date, login, action, type, ip) VALUES('$server_date-$server_time', '".$DATA["login"]."', '�������� ������', '2', '".$my_remote."')");
				$error="������! �������� ������ ��� \"$login_auth\".<br/>";
			}
			else
			{
				if($DATA["blok"])
			    {
			    	$error="�������� \"".$DATA["login"]."\" ������.<br/>������� �����: ".$DATA["blok_reason"].".<br/><br/>";
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
								mysql_query("INSERT INTO `report`(date,login,action,type,ip) VALUES('$server_date-$server_time','".$DATA["login"]."','�������� ������ ������� ������ ','5','".$my_remote."')");
			          			$mess='������! �������� ������...';
			          		}
			        	}
			        	else
			        	{  
			        		$ok=false; 
			        	}
	          			if (!$ok) 
	          			{
		          			echo "
		          				<div class=\"aheader\">
		          				<form action=\"enter.php\" method=\"post\">
			          				<b style='color:#ff0000'>$mess &nbsp;</b><br/>
			          				<b>������ ������� ������ � ���������.</b><br/>
			          				������: <input type=\"text\" class=\"inup\" size=\"20\" name=\"code\" /><br/><br/>
			          				<input type=\"submit\" style=\"cursor:hand\" class=\"inup\" value=\"�����\"><br/><br/>
			          			</form>
		          				</div>";
		          				include("bottom_index.php");
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
						$GET_ONLINE_DATA = mysql_fetch_array(mysql_query("SELECT * FROM `online` WHERE login='".$DATA["login"]."'"));
					    if(!$GET_ONLINE_DATA)
					    {
					    	mysql_query("INSERT INTO `online`(ip,remote_ip,login,uniqPCID,room,city,browser) VALUES('".$ip."','".$my_remote."','".$DATA["login"]."','".$sesid."','".$DATA["room"]."','".$DATA["city_game"]."','".getenv("HTTP_USER_AGENT")."')");
					    }
					    else
					    {
					    	mysql_query("UPDATE `online` SET ip='".$ip."',remote_ip='".$my_remote."',uniqPCID='".$sesid."',room='".$DATA["room"]."',city='".$DATA["city_game"]."' WHERE login='".$DATA["login"]."'");
					    }
						echo "<b>����������� ��������...</b>";
						$last_visit_ip=mysql_fetch_array(mysql_query("SELECT ip FROM report WHERE time_stamp=(SELECT MAX(time_stamp) FROM report WHERE login='".$DATA["login"]."' and type='1')"));
					 	$zayavka_c_m = 1;
						$zayavka_c_o = 1;
						$battle_ref  = 0;
						session_register('zayavka_c_m','zayavka_c_o','battle_ref');

						mysql_query("INSERT INTO `report`(date,login,action,type,ip) VALUES('$server_date-$server_time','".$DATA["login"]."','�������� ���������������','1','".$my_remote."')");
						mysql_query("UPDATE users SET last_ip='".$ip."',remote_ip='".$my_remote."' WHERE login='".$DATA["login"]."'");
						$_SESSION['my_room']=$DATA["room"];
						unset($_SESSION["lock"]);
						Header("Location: main.php?tmp=$times");die();
					}
			    }
			}
		}
		else
		{
			$error="������! ������ ���������  \"".$login_auth."\" �� ����������...<br/>";
		}
	}
	else $error="������! �� �� ����� ����� ���� ������!<br/>";
}
?>
<div class="aheader"><b style="color:#ff0000"><?=$error;?></b></div><br/>
<?include("bottom_index.php");?>			
</div>