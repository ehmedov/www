<?
session_start();
include ("conf.php");
header("Content-Type: text/html; charset=windows-1251");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

$data = mysql_connect($base_name, $base_user, $base_pass) or die('�� ���������� ������������. ��������� ��� �������, ��� ������������ � ������!');
mysql_select_db($db_name) or die('������ ����� � ���� ������');
$ip=getenv('REMOTE_ADDR');

echo '<?xml version="1.0" encoding="windows-1251"?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.2//EN" "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="en">';
?>
<head>
	<title>WAP.MEYDAN.AZ- ����� ������ ��������� ������ � �������� �������</title>
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
	<div class="sep2"></div><br/>
	<div>
	<?
	$vaxt=3600;
	$regblok = mysql_fetch_array(mysql_query("SELECT * FROM `report` WHERE type='0' and ip='".$ip."'"));
	if ((time()-strtotime($regblok['time_stamp'])<$vaxt))
	{
		$tim=$vaxt-(time()-strtotime($regblok['time_stamp']));
		$h=floor($tim/3600);
		$m=floor(($tim-$h*3600)/60);
		$sec=$tim-$h*3600-$m*60;
		if ($m<10)$m="0".$m;
		if ($sec<10)$sec="0".$sec;
		echo "<b>�� �����������: ".$m." ���. ".$sec." ���. (IP: $ip)</b><br/>";
		echo '����������� ���� ������!
		� �������� �������. <br/><br/>

		��� �� ������ � ���� ���, ������  ���� ������� ����� ����� ����� � 
		���� ����� �����.<br/>
		� �������� ���� ��� ��� �� ��� � �����  �� ����������.<br/><br/>

		����� �������� �����, ������� ����� � ������������ ��������������� 
		����� ��������� ���,  ������ ���������� �  ����� ������. <br/>
		�� ������ ���� ���, �� ����� ����������� ������������ ������.<br/><br/>

		������ �����, ��� ���������� ���� �������� � ������� �����,
		���������� ��� - ������ ���. �� ������� ���, � �� ������ ���.
		�� ������ ��� �� ���� ���, ��� � ��� �������� �����. <br/>
		����� ����� ���� ������ ���, �� �������� ������ � ������ ����������. <br/><br/>

		�� �� ������ ��������������, �������� � ����. � ��� ���� ������, 
		���� ������.��� ������: ���� ������ ���� ������, 
		��������� ���������, ����� ������ ���� ������� �����, 
		������������ ���� ���������� ����. ����� ������ �����, 
		�� �� ����� ������. � ����� �� � ���� ��� ��������� ����� ��������.<br/><br/>
		 
		����� � �������������� �� ����� ������.<br/><br/>

		- �� ������� ��������, ��� ������ �� �������� � ��������� �����. <br/>
		���� ������ ������� ���� �� ����. ������ �� ���������, ���� �� �� ����,
		�� ������ ����� ������� �  �������� ��� ����� � ������.';
	}
	else
	{	
		if(!$_POST['ref']){$ref = (int)$_GET['ref'];}
		else{$ref = (int)$_POST['ref'];}
		if($ref)
		{
			$s_ref = mysql_fetch_array(mysql_query("SELECT id FROM `users` WHERE `id`='".$ref."'"));
			if(!$s_ref){$ref=0;}
		}
		if ($_POST["login"])
		{
			$login=htmlspecialchars(addslashes($_POST["login"]));
			$psw=$_POST['psw']; 
			$psw2=$_POST['psw2'];
			$email=htmlspecialchars(addslashes(strtolower(trim($_POST['email']))));
			$name=htmlspecialchars(addslashes($_POST['name']));
			$icq=(int)abs($_POST['icq']);
			$city=htmlspecialchars(addslashes($_POST['city']));
			$deviz=htmlspecialchars(addslashes($_POST['deviz']));
			$chatcolor="Black";
			$sex=(int)abs($_POST['sex']);
			$birthday=$_POST['dd'].".".$_POST['mm'].".".$_POST['yy'];
			$law=$_POST['Law'];
			$code=$_POST['code'];
			####################################################################
			$is_rus=0;$is_eng=0;
			$ru = "��������ި�����������������������";
			$en = "EYUIOAQWRTPSDFGHJKLZXCVBNM";
			$splits="-_ ";
			$oklogin=true; $okpsw=true; $okemail=true; $okname=true; $okall=true;
			####################################################################
			if (strlen($login)>20) {$message="����� ������ ��������� �� ����� 20 ��������";$oklogin=false;}
			if (strlen($login)<3) {$message="����� ������ ��������� �� ����� 3 ��������";$oklogin=false;}
			for($i=0; $i<strlen($ru); $i++) 
			{
				if(strpos(strtoupper($login), $ru[$i]) > -1) {$is_rus++;}
			}
			for($i=0; $i<strlen($en); $i++) 
			{
				if(strpos(strtoupper($login), $en[$i]) > -1) {$is_eng++;}
			}
			if(($is_rus > 0) && ($is_eng > 0)) 
			{
				$message= "����� ����� �������� ������ �� ���� �������� �������� ��� ������ �� ���� ���������� ��������";$oklogin=false;
			}
			if ($is_eng) {$s=$en;$sogl=substr($en,6);} else {$s=$ru;$sogl=substr($ru,10);}
			$ps=-1;$p=0;
			$blacklist="��";$blackwordlist="���,����,sik,amciq,amcig,kurtlar,petux,qehbe,gehbe,kahbe,cirix,cindir,calan,got,qot,s i k,p e t u x,a m c i g, k u r t l a r";
			for($i=0; $i<strlen($login); $i++) 
			{
				if (strpos($s,$login[$i])>-1) 
				{ 
					#������� �����
					if (!$p && $i==$ps+1) 
					{
						$p=1;$words++; #�������� � ������� �����
						$lwords[$words].=$login[$i];
					}
					elseif ($p==2 && $i>$ps+1) 
					{
						$message="����� �� ����� ��������� ��������� ����� ����� �������.";$oklogin=false;break;
					}
					#���� ��������� ������ ������� ����� - ������=����� ��� ���� ������ ����� �����������
				}
				elseif (strpos(strtolower($s),$login[$i])>-1)
				{ 
					#��������� �����
					if (!$p && $i==$ps+1) {$words++;}
					$lwords[$words].=$login[$i];
					$p=2;
				} 
				elseif (strpos($splits,$login[$i])>-1) 
				{
					#������ �����������
					if ($ps==$i-1) {$message="�� ����� ���� ��� � ����� ����������� ������, ����� ��� �� ����� � ��� ����������.";$oklogin=false;break;}
					$ps=$i;$p=0;
					#�� ����� ���� ���� ������������ ������
					#�� ����� ���� ������������ � ������ � ����� ����� � ����� ��������� ���� � ������
				}
				else
				{
					$message=$login[$i]."����� �������� ����������� �������.";$oklogin=false;break;
				}
				if ($i>0) 
				{
					if ($login[$i-1]==$login[$i]) 
					{
						$rep++;
						if (preg_match("![".$blacklist."]{2,}!i",$login)) 
						{
							$message="����������� ���������� ������ ������ ��������.";$oklogin=false;break;
						}
						#if (strpos($blacklist,strtoupper($login[$i]))>-1) {$message="����������� ���������� ������ ������ ��������.";$oklogin=false;break;}
						if ($rep>1) {$message="����� �� ������ ��������� ����� ���� ������������� ���� ������.";$oklogin=false;break;}
					} 
					else {$rep=0;}
					if (preg_match("![".$sogl."]{4,}!i",$login)) 
					{
						$message="����� �� ������ ��������� 4 � ����� ������ ������ ��������� ����.";$oklogin=false;break;
					}
				}
			}
			for ($i=0;$i<10;$i++) 
			{
				if (strpos($login,"".($i))>-1) {$message="����� �� ������ ��������� ����.";$oklogin=false;break;}
			}
			$have_nik=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE login='".$login."'"));
			if ($have_nik){$message= "����� <b>".$have_nik["login"]."</b> ��� ���������������!";$oklogin=false;}
			unset($blacklist,$p,$ps,$rep,$repsogl,$s,$sogl,$is_eng,$is_rus);
			#########################################################
			if ($psw!=$psw2) {$message="��������� ���� ������ �� ���������.";$okpsw=false;}
	    	elseif (strlen($psw)<6) {$message="������ �� ����� ���� ������ 6 ��������.";$okpsw=false;}
	    	elseif (strlen($psw)>21) {$message="������ �� ����� ���� ������� 21 �������.";$okpsw=false;}
	    	else 
	    	{
	    		#��������� ������ ���������� ������ ����� ����� ��������� � ������ ��������
	        	$is_rus=0;$is_eng=0;
	        	for($i=0; $i<strlen($ru); $i++) 
	        	{
	          		if(strpos(strtoupper($psw), $ru[$i]) > -1) {$is_rus++;}
	        	}
	        	for($i=0; $i<strlen($en); $i++) 
	        	{
	          		if(strpos(strtoupper($psw), $en[$i]) > -1) {$is_eng++;}
	        	}
	        	if(($is_rus > 0) && ($is_eng > 0)) {$raskl=1;} else {$raskl=0;}
	    		$d=0; 
	    		for ($i=0;$i<10;$i++) 
	    		{
	    			if (strpos($psw,"".($i))>-1) {$d=1;}
	    		}
	    		if ((strtoupper($psw)==$psw || strtolower($psw)==$psw) && !$d && !$raskl)
	    		{
	    			$message="��������� ������ ���������� ������ ����� ����� ��������� � ������ ��������.";$okpsw=false;
	    		}
	    		else if ($d>0 && $is_rus==0 && $is_eng==0)
	    		{
	    			 #����� ���� �� ��� ����
	    			$message="��������� ������ ���������� ������ �����";$okpsw=false;
	    		}
	    		unset($is_rus,$is_eng);
	    		unset($d,$raskl);
	   			#��������� �������, ���������������� ������.
	        	$deniedpsw="qwer,qazws,zxcv,123,1234,12345,123456,����,�����,����";
	        	$bwl=explode(",",strtoupper($deniedpsw));
	        	for ($i=0;$i<count($bwl);$i++) 
	        	{
	           		if (strpos(strtoupper($psw),$bwl[$i])>-1) {$message="������ ������� �������.";$okpsw=false;break;}
	        	}
	        	$s=similar_text(strtoupper($login),strtoupper($psw));
	      		if (($s>5) || ($s>=strlen($login))) {$message="���������� ������� ������ ����� ������������ �� ������.";$okpsw=false;}
	      		unset($s,$bwl,$deniedpsw);
	   		}
	   		#########################################################
			if (strlen($email)>50) {$message="E-Mail �� ����� ���� ������� 50 ��������.";$okemail=false;}
			$res=mysql_fetch_array(mysql_query("SELECT count(*) FROM info WHERE email='".$email."'"));
			if ($res[0]>0) {$message="������ E-Mail ��� ���������������.";$okemail=false;}
			if (!preg_match('#^[a-z0-9.!\#$%&\'*+-/=?^_`{|}~]+@([0-9.]+|([^\s]+\.+[a-z]{2,6}))$#si', $email))
			{
				$message="������� ������ �������� �����.";$okemail=false;
			}
			$deniedmail="hotmail.com,bk.ru";
			$bwl=explode(",",strtoupper($deniedmail));
			for ($i=0;$i<count($bwl);$i++) 
			{
		    	if (strpos(strtoupper($email),$bwl[$i])>-1) {$message="�������� ������ ������� ������� ���������.";$okemail=false;break;}
			}
			unset($deniedmail,$bwl);
			#########################################################
			$en=preg_match("/^(([a-zA-Z ])+)$/i", $name);
			$ru=preg_match("/^(([�-��-� ])+)$/i", $name);
			if ((($en && $ru) || (!$en && !$ru)) && ($name)){$message="�������� ���";$okname=false;}
			if (!$name) {$message="�� ������ ���";$okname=false;}
			
			$en=preg_match("/^(([a-zA-Z ])+)$/i", $city);
			$ru=preg_match("/^(([�-��-� ])+)$/i", $city);
			if ((($en && $ru) || (!$en && !$ru)) && ($city)) {$message="�������� �������� ������";$okname=false;}
			if (!$city) {$message="�� ������ �����";$okname=false;}
			
			if (!preg_match("/^(([0-9-])+)$/i", $icq) && $icq) {$message="�������� ���� ICQ";$okname=false;}
			if (!preg_match("/^(([0-9 ])+)$/i", $sex) || $sex<0 || $sex>2) {$message="�������� ���� ���";$okname=false;}
			#########################################################
			if (!$law) {$message="���������� �������� � �������� ����.";$okall=false;}
			if ($code!=$_SESSION['sec_code_session']) {$message="������ ��� �������� ����!";$okall=false;}
			#########################################################
			if (!$oklogin || !$okpsw || !$okemail || !$okname || !$okall)
			{
				$message=$message;
			}
			else
			{ 
				$password = base64_encode($psw);
			   	$def_city = "mountown";
			    $def_city_game = "mountown";
			    $def_room = "room1";
				$server_date=date("d.m.Y");
				$server_time=date("H:i:s");
			    if($sex == 0)
			    {
					$sexy="male";
			       	$def_obraz = "m/1.gif";
			    }
			    else
			    {
			    	$sexy="female";
			       	$def_obraz = "f/1.gif";
			    }
			    
				$def_status = "�������";
				
				mysql_query("LOCK TABLES users WRITE, inv WRITE, report WRITE, info WRITE");
				mysql_query("INSERT INTO `users`(login,refer,password,level,sex, date, reg_ip, city_game,  obraz, status, room, color,money)  VALUES('".$login."','".$ref."','".$password."','0','".$sexy."','$server_date-$server_time','$ip','$def_city_game','$def_obraz','$def_status','$def_room','".$chatcolor."',100);");
				$id_pers=mysql_insert_id();
				mysql_query("INSERT INTO info (id_pers,icq, name, town, deviz,email,birth,born_city)  VALUES(".$id_pers.",'".$icq."','".$name."','".$city."','".$deviz."','".$email."','".$birthday."','".$def_city_game."');");
				mysql_query("INSERT INTO inv(owner,object_id,object_type,object_razdel,gift,wear,iznos,gift_author,iznos_max,name,img,price,mass,add_hp) 
				VALUES('".$login."','1','rubaxa','obj','1','0','0','WWW.MEYDAN.AZ','20','������� �������','rubaxa/1.gif',1,1,8);");
				mysql_query("DELETE FROM report WHERE ip='$ip' and type='0'");
				mysql_query("INSERT INTO `report`(date,login,action,type,ip) VALUES('$server_date-$server_time','".$login."','�������� ���������������','0','$ip');");
				mysql_query("UNLOCK TABLES");
				$_SESSION['logins']=$login;
				$_SESSION['psw']=$psw;
				header("Location: enter.php?tmp=".md5(time()));
				die();
			}
		}
		?>
		<center><b>�����������</b></center>
		<font color='#ff0000'><?=$message;?></font><br/>
			<form method="post" action="">
				<font color='#ff0000'>*</font> �����: <input name='login' value='<?=$login;?>' class='inup' size='20' maxlength='30' /><br/><br/>
				<font color='#ff0000'>*</font> ������: <input name='psw' type='password' value='' class='inup' size='20' maxlength='21' /><br/><br/>
				<font color='#ff0000'>*</font> ������ ��������: <input name='psw2' type='password' value='' class='inup' size='20' maxlength='21' /><br/><br/>
				<font color='#ff0000'>*</font> ��� e-mail:  <input name='email' class='inup' value='<?=$email;?>' size='20' maxlength='50' /><br/><br/>
				<font color='#ff0000'>*</font> ���� �������� ���: <input name='name' value='<?=$name;?>' class='inup' size='20' maxlength='90' /><br/><br/>
				<font color='#ff0000'>*</font> ���� ��������: 
												<?
												echo "<select name='dd' class='inup'>";
												for ($day=1;$day<=31;$day++){echo "<option value='$day'".($day==$_POST["dd"]?" selected":"").">$day</option>";}
												echo "</select> ";
												echo "<select name='mm' class='inup'>
												<option value='01'".($_POST["mm"]=='01'?" selected":"").">������</option>
												<option value='02'".($_POST["mm"]=='02'?" selected":"").">�������</option>
												<option value='03'".($_POST["mm"]=='03'?" selected":"").">����</option>
												<option value='04'".($_POST["mm"]=='04'?" selected":"").">������</option>
												<option value='05'".($_POST["mm"]=='05'?" selected":"").">���</option>
												<option value='06'".($_POST["mm"]=='06'?" selected":"").">����</option>
												<option value='07'".($_POST["mm"]=='07'?" selected":"").">����</option>
												<option value='08'".($_POST["mm"]=='08'?" selected":"").">������</option>
												<option value='09'".($_POST["mm"]=='09'?" selected":"").">��������</option>
												<option value='10'".($_POST["mm"]=='10'?" selected":"").">�������</option>
												<option value='11'".($_POST["mm"]=='11'?" selected":"").">������</option>
												<option value='12'".($_POST["mm"]=='12'?" selected":"").">�������</option>
												</select> ";
												echo "<select name='yy' class='inup'>";
												for ($year=1920;$year<=2012;$year++){echo "<option value='$year'".($year==$_POST["yy"]?" selected":"").">$year</option>";}
												echo "</select>";
												?><br/><br/>
				<font color='#ff0000'>*</font> ��� ���: 
											<select name='sex' class='inup'>
												<option value='0'>�������</option>
												<option value='1'>�������</option>
											</select><br/><br/>
				<font color='#ff0000'>*</font> �����: <input type='text' class='inup' name='city' value='<?=$city;?>' size='20' maxlength='40' /><br><br/>
				ICQ: <input name='icq' value='<?=$icq;?>' class='inup' size='20' maxlength='20' /><br/><br/>
				�����: <input name='deviz' value='<?$deviz;?>' class='inup'  size='20' maxlength='160' /><br/><br/>
				<input type='checkbox' name='Law' <?if($_POST["Law"]) echo "checked";?> /> <font color='#ff0000'>*</font> � �������� ��������� <a href='http://www.meydan.az/rules.php'>������ WWW.MEYDAN.AZ</a> � �������� �� ����� �������� <a href='http://www.meydan.az/soqlaweniya.php'>����������������� ����������</a><br/><br/>
				<font color='#ff0000'>*</font> ������� ���: <input type='text' name='code' class='inup' size='20' maxlength='12' /><br/>
				<img src='antibot.php?<?=session_id();?>' border='0'><br/><br/>
				<input class="inup" type="submit" value="OK" /><br/>
			</form>
		<?
	}
	?>
	</div>
	<?include("bottom_index.php");?>
</div>