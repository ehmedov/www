<?
session_start();
ob_start();
include_once ("browser.php");
include_once ("conf.php");
include_once ("req.php");
include_once ("functions.php");
$data = @mysql_connect($base_name, $base_user, $base_pass) or die('�� ���������� ������������. ��������� ��� �������, ��� ������������ � ������!');
mysql_select_db($db_name) or die('������ ����� � ���� ������');

$ip=getenv('REMOTE_ADDR');
?>
<HTML>
<HEAD>
	<TITLE>WWW.http://oldmeydan.pe.hu/ - ����� ������ ��������� ������ � �������� �������!</TITLE>
	<META http-equiv=Pragma content=no-cache>
	<META http-equiv=Cache-control content=private>
	<META http-equiv=Expires content=0>
	<LINK REL=StyleSheet HREF='smith.css' TYPE='text/css'>
	<style>
		#background_registration 
		{
		position:absolute;
		background:url(img/index/registration_background.jpg);
		width:100%;
		height:650px;
		z-index:0;
		}
	</style>
</HEAD>
<BODY bgcolor=#eaeaea leftMargin=0 topMargin=0 marginwidth=0 marginheight=0>
<div id="background_registration">
<script language="JavaScript" type="text/javascript" src="glow.js"></script>
<?
$vaxt=3600;
$regip = mysql_query("SELECT * FROM `report` WHERE type='0' and ip='".$ip."'");
$regblok = mysql_fetch_array($regip);
if ($ip!="88.151.196.234")
{	
	if ((time()-strtotime($regblok['time_stamp'])<$vaxt))
	{
		$tim=$vaxt-(time()-strtotime($regblok['time_stamp']));
		$h=floor($tim/3600);
		$m=floor(($tim-$h*3600)/60);
		$sec=$tim-$h*3600-$m*60;
		if ($m<10)$m="0".$m;
		if ($sec<10)$sec="0".$sec;
		echo "<h3>�� �����������: ".$m." ���. ".$sec." ���. (IP: $ip)</h3><br>";
		echo "<table><tr><td><img src='img/index/reg.png' border=0></td>";
		echo "<td valign=top>";
		echo '����������� ���� ������!
		� �������� �������. <br><br>

		��� �� ������ � ���� ���, ������  ���� ������� ����� ����� ����� � 
		���� ����� �����.<br>
		� �������� ���� ��� ��� �� ��� � �����  �� ����������.<br><br>

		����� �������� �����, ������� ����� � ������������ ��������������� 
		����� ��������� ���,  ������ ���������� �  ����� ������. <br>
		�� ������ ���� ���, �� ����� ����������� ������������ ������.<br><br>

		������ �����, ��� ���������� ���� �������� � ������� �����,
		���������� ��� - ������ ���. �� ������� ���, � �� ������ ���.
		�� ������ ��� �� ���� ���, ��� � ��� �������� �����. <br>
		����� ����� ���� ������ ���, �� �������� ������ � ������ ����������. <br><br>

		�� �� ������ ��������������, �������� � ����. � ��� ���� ������, 
		���� ������.��� ������: ���� ������ ���� ������, 
		��������� ���������, ����� ������ ���� ������� �����, 
		������������ ���� ���������� ����. ����� ������ �����, 
		�� �� ����� ������. � ����� �� � ���� ��� ��������� ����� ��������.<br><br>
		 
		����� � �������������� �� ����� ������.<br><br>

		- �� ������� ��������, ��� ������ �� �������� � ��������� �����. <br>
		���� ������ ������� ���� �� ����. ������ �� ���������, ���� �� �� ����,
		�� ������ ����� ������� �  �������� ��� ����� � ������.';
		echo "</td></tr><table>";
		die();
	}	
}
array_walk($_REQUEST,"format_string");
array_walk($_POST,"format_string");
array_walk($_GET,"format_string");
$ru = "��������ި�����������������������";
$en = "EYUIOAQWRTPSDFGHJKLZXCVBNM";
$splits="-_ ";

$oklogin=false;$okpsw=false;$okemail=false;$okname=false;$okall=false;

$step=$_POST['step'];
$login=$_POST['login'];
$psw=$_POST['psw']; 
$psw2=$_POST['psw2'];
$email=strtolower(trim($_POST['email']));
$name=$_POST['name'];
$icq=$_POST['icq'];
$city2=$_POST['city2'];
$about=$_POST['about'];
$chatcolor=$_POST['ChatColor'];
if (!$chatcolor) {$chatcolor="Black";}
$sex=$_POST['sex'];
$birthday=clean_var($_POST['0day']);
$law=$_POST['Law'];
$code=$_POST['code'];
################### REFERAL ###########################
if(!$_POST['ref']){$ref = (int)$_GET['ref'];}
else{$ref = (int)$_POST['ref'];}
if($ref)
{
	$s_ref = mysql_fetch_array(mysql_query("SELECT id FROM `users` WHERE `id`='".$ref."'"));
	if(!$s_ref){$ref=0;}
}
########################################################
if ($login)
{
	#------------------checklogin--------------------
	$oklogin=true;
	$sr='-���������������������������������';
	if (strlen($login)>20) {$message="����� ������ ��������� �� ����� 20 ��������";$oklogin=false;}
	if (strlen($login)<3) {$message="����� ������ ��������� �� ����� 3 ��������";$oklogin=false;}
	$is_rus=0;$is_eng=0;
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
		$message= "Login ����� �������� ������ �� ���� �������� �������� ��� ������ �� ���� ���������� ��������";$oklogin=false;
	}
	else
	{
		if ($is_eng) {$s=$en;$sogl=substr($en,6);} else {$s=$ru;$sogl=substr($ru,10);}
		$ps=-1;$p=0;#echo 'eng='.$is_eng.' rus='.$is_rus.' '.strtoupper($login);
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
					$message="��� �� ����� ��������� ��������� ����� ����� �������.";$oklogin=false;break;
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
			elseif(strpos($sr,$login[$i])) 
			{
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
					if ($rep>1) {$message="��� �� ������ ��������� ����� ���� ������������� ���� ������.";$oklogin=false;break;}
				} 
				else {$rep=0;}
				if (preg_match("![".$sogl."]{4,}!i",$login)) 
				{
					$message="��� �� ������ ��������� 4 � ����� ������ ������ ��������� ����.";$oklogin=false;break;
				}
				#if (strpos($sogl,strtoupper($login[$i-1]))>-1 && strpos($sogl,strtoupper($login[$i]))>-1) {$repsogl++;
				#if ($repsogl>2) {$message="��� �� ������ ��������� 4 � ����� ������ ������ ��������� ����.";$oklogin=false;break;}
				#} else {$repsogl=0;}
			}
		} 
		unset($blacklist,$p,$ps,$rep,$repsogl,$s,$sogl,$is_eng,$is_rus);
		$bwl=explode(",",strtoupper($blackwordlist));
		for ($i=0;$i<count($bwl);$i++) 
		{
			if (strpos(strtoupper($login),$bwl[$i])>-1) {$message="����� �������� ����������� �����.";$oklogin=false;break;}
		}
		if ($words>3) {$message="��� �� ������ ��������� ����� ���� ����.";$oklogin=false;}
		unset($blackwordslist,$bwl);
		for ($i=0;$i<10;$i++) 
		{
			if (strpos($login,"".($i))>-1) {$message="��� �� ������ ��������� ����.";$oklogin=false;break;}
		}
		$have_nik=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE login='".$login."'"));
		if ($have_nik) 
		{
			$message= "������������ ".$have_nik["login"]." ��� ���������������!";
			$oklogin=false;
		}
	}
	#------------------checkpassword--------------------
	if ($oklogin && $step>1) 
	{
    	$okpsw=true;
    	if ($psw!=$psw2) {$message="��������� ���� �� ���������.";$okpsw=false;}
    	elseif (strlen($psw)<6) {$message="������ �� ����� ���� ������ 6 ��������.";$okpsw=false;}
    	elseif (strlen($psw)>21) {$message="������ �� ����� ���� ������� 21 �������.";$okpsw=false;}
    	else 
    	{
    		#��������� ������ ���������� ������ ����� ����� ��������� � ������ ��������
        	$is_rus=0;$is_eng=0;
        	for($i=0; $i<strlen($ru); $i++) 
        	{
          		if(strpos(strtoupper($psw), $ru[$i]) > -1) {$is_rus++;break;}
        	}
        	for($i=0; $i<strlen($en); $i++) 
        	{
          		if(strpos(strtoupper($psw), $en[$i]) > -1) {$is_eng++;break;}
        	}
        	if(($is_rus > 0) && ($is_eng > 0)) {$raskl=1;} else {$raskl=0;}
    		$d=0; for ($i=0;$i<10;$i++) {if (strpos($psw,"".($i))>-1) {$d=1;break;}   }
    		if ((strtoupper($psw)==$psw OR strtolower($psw)==$psw) && !$d && !$raskl)
    		{
    			$message="��������� ������ ���������� ������ ����� ����� ��������� � ������ ��������.";$okpsw=false;
    		}
    		#��� ������� ������ ��������, ����� �� ������������ � ����� ������ �����
    		elseif ($d>0 && $is_rus==0 && $is_eng==0) #����� ���� �� ��� ����
    		{$message="��������� ������ ���������� ������ �����";$okpsw=false;}
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
      		if (($s>5)OR ($s>=strlen($login))) {$message="���������� ������� ������ ����� ������������ �� ������.";$okpsw=false;}
      		unset($s,$bwl,$deniedpsw);
   		}
		#------------------checkemail--------------------
		if ($okpsw && $step>2) 
		{
			if (strlen($email)>50) {$message="E-Mail �� ����� ���� ������� 50 ��������.";$okemail=false;}
			if (preg_match('#^[a-z0-9.!\#$%&\'*+-/=?^_`{|}~]+@([0-9.]+|([^\s]+\.+[a-z]{2,6}))$#si', $email))
			{
				$res=mysql_fetch_array(mysql_query("SELECT count(*) FROM info WHERE email='".$email."'"));
				if ($res[0]>0) {$message="������ E-Mail ��� ���������������.";$okemail=false;} else {$okemail=true;}
			} 
			else 
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
			#�������� �������
			#------------------checkuserdata--------------------
			if ($okemail && $step>3) 
			{
				$okname=true;
				$en=preg_match("/^(([a-zA-Z0-9 -])+)$/i", $name);
				$ru=preg_match("/^(([�-��-�0-9 -])+)$/i", $name);
				if ((($en && $ru) || (!$en && !$ru)) && ($name)){$message="�������� ���";$okname=false;}
				if (!$name) {$message="�� ������ ���";$okname=false;}
				
				$en=preg_match("/^(([a-zA-Z0-9 -])+)$/i", $city2);
				$ru=preg_match("/^(([�-��-�0-9 -])+)$/i", $city2);
				if ((($en && $ru) || (!$en && !$ru)) && ($city2)) {$message="�������� �������� ������";$okname=false;}
				if (!$city2) {$message="�� ������ �����";$okname=false;}
				$dt=explode(".",$birthday);
				#if (!checkdate($dt[1],$dt[0],$dt[2])) {$message="������������ ����";$okname=false;}
				if (!preg_match("/^(([0-9-])+)$/i", $icq) && $icq) {$message="�������� ���� ICQ";$okname=false;}
				if (!preg_match("/^(([0-9 ])+)$/i", $sex) || $sex<0 || $sex>2) {$message="�������� ���� ���";$okname=false;}
				if (!preg_match("/^(([a-zA-Z0-9#])+)$/i", $chatcolor)) {$message="�������� ���� ���� � ����";$okname=false;}
				#------------------checklastdata--------------------
				if ($okname && $step>4) 
				{
					$okall=true;
					if (!$law) {$message="���������� �������� � �������� ����.";$okall=false;}
					if ($code!=$_SESSION['sec_code_session']) {$message="������ ��� �������� ����!";$okall=false;}
				}  #----------/checklastdata

			}  #----------/checkuserdata

		}  #----------/checkemail

	}  #----------/checkpass

}  #----------/checklogin


#��� 0\1 ��� �������� ����� - �����1
#��� 2 ��� ������ ����� - �����2 ������

if (!$oklogin or $step<1) 
{
     $level=1;
}
elseif(!$okpsw or $step==1) 
{
     if (!$okpsw) {unset($psw,$psw2);}
     $level=2;
}
elseif(!$okemail or $step==2) 
{
     $level=3;
}
elseif(!$okname or $step==3) 
{
     $level=4;
}
elseif(!$okall or $step==4) 
{
	$level=5;
}
elseif($step==5) 
{
	$level=6;
	$birthday=$birthday[0].$birthday[1].".".$birthday[3].$birthday[4].".".$birthday[6].$birthday[7].$birthday[8].$birthday[9];
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
	mysql_query("INSERT INTO `users`(login,refer,password,level,sex, date, reg_ip, city_game,  obraz, status, room, color,money)  VALUES('".clean_var($login)."','".$ref."','".$password."','0','".$sexy."','$server_date-$server_time','$ip','$def_city_game','$def_obraz','$def_status','$def_room','".clean_var($chatcolor)."',100);");
	$id_pers=mysql_insert_id();
	mysql_query("INSERT INTO info (id_pers,icq, name, town, deviz,email,birth,born_city)  VALUES(".$id_pers.",'".clean_var($icq)."','".clean_var($name)."','".clean_var($city2)."','".clean_var($about)."','".clean_var($email)."','".$birthday."','".$def_city_game."');");
	mysql_query("INSERT INTO inv(owner,object_id,object_type,object_razdel,gift,wear,iznos,gift_author,iznos_max,name,img,price,mass,add_hp) 
	VALUES('".clean_var($login)."','1','rubaxa','obj','1','0','0','WWW.http://oldmeydan.pe.hu/','20','������� �������','rubaxa/1.gif',1,1,8);");
	mysql_query("DELETE FROM report WHERE ip='$ip' and type='0'");
	mysql_query("INSERT INTO `report`(date,login,action,type,ip) VALUES('$server_date-$server_time','".clean_var($login)."','�������� ���������������','0','$ip');");
	mysql_query("UNLOCK TABLES");
	$_SESSION["registered"]=1;
	$_SESSION['logins']=$login;
	$_SESSION['psw']=$psw;
	header("Location: enter.php?tmp=".md5(time()));
	die();
}

echo"
<table width=\"100%\" height=\"100%\"  border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
<tr>
	<td width=250 nowrap><img src='img/index/warrior1.png' border=0></td>
    <td align=\"center\" valign=\"center\" width=100%>
    	<table width=600>
    	<tr>
			<td>
				<h3>���������� ���� WWW.http://oldmeydan.pe.hu/!</h3>
				<b>� ������� ��� ����� ������ � ������������ ���!</b><br>
				����� ����, ��� ������ ������ ������� ���� ���, �� ������� ����������, 
				��������� ����������� ���� ��������� � ������ ����� � �����. 
				���, ��� ��� ������� � ����� ������, ������� � �������������� �����, � ������ �� ��� ����������� �� ����������. 
				������� ��������� ������, ������ ������������ ������ �������, � ����� �� ��� ����������� ����� ���� ����� � 
				� �� ������, ��� ����� ����� ������ ��� �������� ��������� �������, � ����� - ���������. � �� ���� ����� �����
			</td>
		</tr>
		</table>";
		switch ($level)
		{
				//--------------------------------------------------------------------------------------------------------
		        case 1:
		  			echo "
		  			<FORM action='reg.php' method='POST' name='FORM1'>
		  			<TABLE WIDTH=600 CELLSPACING=1 CELLPADDING=2 BGCOLOR=#212120 name=\"F1\">
					<INPUT type=hidden name=step value='1'>
		            <INPUT type=hidden name=add value='1'>
					<TR bgcolor=#D5D5D5>
						<TD >
		                	<B>��������!</B></span> ������ ���� �������� <U>������</U> ��� ��������� Internet Explorer!<BR><BR>
		                  	<FONT color=red>".clean_var($message)." &nbsp;</FONT><br><br>
							<b>������ ���� ���, ���� ����� �� ��������� ��� � ����� �������.</b><br>
		            		<font color=#FF0000>*</font> ��� ������ ���������: <input NAME=\"login\" value='".clean_var($login)."' class=\"inup\" size=30 maxlength=30>
		            		&nbsp;<INPUT name=add type=submit class=\"btn\" value=\"����������\">
		           			<br><br>
		           			<small><br><br><b>���������:</b> ������ ����� �� 3 �� 30 ��������. 
		           			����� ������������ ������ ������� ���� ���������� �����, ����� � ������.
		           		</TD>
					</TR>
				
					<input type='hidden' name='ref' value=\"".$ref."\">
					<input type='hidden' name='psw' value=\"".clean_var($psw)."\">
					<input type='hidden' name='psw2' value=\"".clean_var($psw)."\">
					<input type='hidden' name='email' value=\"".clean_var($email)."\">
					<input type='hidden' name='name' value=\"".clean_var($name)."\">
		            <input type='hidden' name='0day' value=\"".clean_var($birthday)."\">
		            <input type='hidden' name='sex' value=\"".clean_var($sex)."\">
		            <input type='hidden' name='city2' value=\"".clean_var($city2)."\">
		            <input type='hidden' name='icq' value=\"".clean_var($icq)."\">
		            <input type='hidden' name='about' value=\"".clean_var($about)."\">
		            <input type='hidden' name='ChatColor' value=\"".clean_var($chatcolor)."\">
					</table></FORM>";
				break;
				//--------------------------------------------------------------------------------------------------------
				case 2:
					echo "
					<FORM action='reg.php' method='POST' name='FORM1'>
					<TABLE WIDTH=600 CELLSPACING=1 CELLPADDING=2 BGCOLOR=#212120 name=\"F1\">
					<INPUT type=hidden name=step value='2'>
					<INPUT type=hidden name=add value='1'>
					<TR bgcolor=#D5D5D5>
						<TD>
							<B>��������!</B></span> ������ ���� �������� <U>������</U> ��� ��������� Internet Explorer!<BR><BR>
		                  	<FONT color=red>".clean_var($message)." &nbsp;</FONT><BR>
		            		��� ������ ���������: <input type='hidden' NAME=\"login\" value='".clean_var($login)."'><b>".clean_var($login)."</b>
		            		<BR><BR>
							<table width=100% border=0 CELLSPACING=0 CELLPADDING=0>
								<tr>
									<td><font color=#FF0000>*</font> ������:</td><td><input name=psw type=password value=\"".clean_var($psw)."\" class=\"inup\" size=15 maxlength=21></td>
								</tr>
								<tr>
									<td><font color=#FF0000>*</font> ������ ��������:</td><td><input name=psw2 type=password value=\"".clean_var($psw2)."\" class=\"inup\" size=15 maxlength=21></td>
								</tr>
								<tr><td colspan=2 height=20></td></tr>
								<tr>
									<td colspan=2><small>
					               		1. ������ �� ����� ���� ������ 6 ��������.<BR>
										�����������: <B>Aa123</B>, <B>tk3</B><BR>
										���������: <B>Turbo371</B><BR><BR>
										2. ��������� ������ ���������� ������ ����� ����� ��������� � ������ ��������.<BR>
										�����������: <B>azerbaycan</B>, <B>avtomobil</B><BR>
										���������: <B>azerbaycan38</B>, <B>avto_mobil</B><BR><BR>
										3. ��������� �������, ���������������� ������.<BR>
										�����������: <B>qwerty123456</B>, <B>qazwsx098</B><BR>
										���������: <B>akhtsel371</B>, <B>human-85y</b><BR><BR>
										4. ������ �� ������ ��������� ����� ������.
										�����������: <B>turbo2004</B> ��� ������ <B>Turbo</B><BR>
										���������: <B>latin9658</B>, <B>human-85y</b> ��� ������ <B>Turbo</B>.<BR><BR>
										5. ������������� �� ������������� �������� ������ ����������� � ������� �� email.<BR>
										</small>
									</td>
								</tr>
								<tr>
				                	<TD><INPUT onclick='FORM1.step.value=\"-1\"; FORM1.submit()' type=button class=\"btn\" value=\"���������\"></td>
				                    <TD align=right><INPUT type=submit class=\"btn\" value=\"����������\"></td>
								</tr>
							</TABLE>
		            	</TD>
		            </TR>
		            <input type='hidden' name='ref' value=\"".$ref."\">
					<input type='hidden' name='email' value=\"".clean_var($email)."\">
					<input type='hidden' name='name' value=\"".clean_var($name)."\">
					<input type='hidden' name='0day' value=\"".clean_var($birthday)."\">
					<input type='hidden' name='sex' value=\"".clean_var($sex)."\">
					<input type='hidden' name='city2' value=\"".clean_var($city2)."\">
					<input type='hidden' name='icq' value=\"".clean_var($icq)."\">
					<input type='hidden' name='about' value=\"".clean_var($about)."\">
					<input type='hidden' name='ChatColor' value=\"".clean_var($chatcolor)."\">
					</table></FORM>";
				break;
				//--------------------------------------------------------------------------------------------------------
		        case 3:
					echo "
					<FORM action='reg.php' method='POST' name='FORM1'>
					<TABLE WIDTH=600 CELLSPACING=1 CELLPADDING=2 BGCOLOR=#212120 name=\"F1\">			
		            <INPUT type=hidden name=step value='3'>
		            <INPUT type=hidden name=add value='1'>
					<TR bgcolor=#D5D5D5>
						<TD>				
							<table width=100% border=0 CELLSPACING=0 CELLPADDING=0>
							<tr>
								<td colspan=2>
									<B>��������!</B></span> ������ ���� �������� <U>������</U> ��� ��������� Internet Explorer!<BR><BR>
									<FONT color=red>".clean_var($message)." &nbsp;</FONT><BR>
					                ��� ������ ���������: <input type='hidden' NAME=\"login\" value='".clean_var($login)."'><b>".clean_var($login)."</b>
				    			</TD>
							</TR>
				            <TR>
				            	<INPUT type='hidden' name='psw' value=\"".clean_var($psw)."\">
								<INPUT type='hidden' name='psw2' value=\"".clean_var($psw)."\">
			            		<TD><font color=#FF0000>*</font> ��� e-mail: </TD>
			            		<TD><input name=email class=\"inup\" value=\"".clean_var($email)."\" maxlength=50></TD>
							</TR>
							<tr><td colspan=2 height=20></td></tr>
							<TR>
								<TD colspan=2><small>(������������ <U>������</U> ��� ����������� ������, ����� �� ������������ � �� ������������ ��� �������� \"�����������/����������/...\" � ������� �����.<BR>
									� ����� ������������ ��������� ����������� � @hotmail.com,@bk.ru)</small>
								</TD>
							</TR>
							<TR>
								<TD><INPUT onclick='FORM1.step.value=\"1\"; FORM1.submit()' type=button class=\"btn\" value=\"���������\"></td>
								<TD><INPUT type=submit class=\"btn\" value=\"����������\"></td.
							</TR>
							</table>
						<input type='hidden' name='ref' value=\"".$ref."\">
						<input type='hidden' name='name' value=\"".clean_var($name)."\">
						<input type='hidden' name='0day' value=\"".clean_var($birthday)."\">
						<input type='hidden' name='sex' value=\"".clean_var($sex)."\">
						<input type='hidden' name='city2' value=\"".clean_var($city2)."\">
						<input type='hidden' name='icq' value=\"".clean_var($icq)."\">
						<input type='hidden' name='about' value=\"".clean_var($about)."\">
						<input type='hidden' name='ChatColor' value=\"".clean_var($chatcolor)."\">
		  		</td></tr></table></FORM>";
		  		break;
				//--------------------------------------------------------------------------------------------------------
				case 4:
					echo "
					<FORM action='reg.php' method='POST' name='FORM1'>
					<TABLE WIDTH=600 CELLSPACING=1 CELLPADDING=2 BGCOLOR=#212120 name=\"F1\">
		            <INPUT type=hidden name=step value='4'>
		            <INPUT type=hidden name=add value='1'>
					<TR bgcolor=#D5D5D5>
						<TD>
							<table width=100% border=0 CELLSPACING=0 CELLPADDING=0>
							<tr>
								<td colspan=2>
									<span class=\"style5\"><B>��������!</B></span> ������ ���� �������� <U>������</U> ��� ��������� Internet Explorer!<BR><BR>
									<FONT color=red>".clean_var($message)."<B></b></FONT><BR>
									��� ������ ���������: <input type='hidden' NAME=\"login\" value='".clean_var($login)."'><b>".clean_var($login)."</b>
								<td>
							</TR>
							<TR>
								<input type='hidden' name='ref' value=\"".$ref."\">
								<input type='hidden' name='psw' value=\"".clean_var($psw)."\">
								<input type='hidden' name='psw2' value=\"".clean_var($psw)."\">
								<input type='hidden' name='email' value=\"".clean_var($email)."\">
								<TD><font color=#FF0000>*</font> ���� �������� ���: </TD>
								<TD><input name=\"name\" value='".clean_var($name)."' class=\"inup\" size=45 maxlength=90></TD>
							</TR>
						<TR>
							<TD><font color=#FF0000>*</font> ���� ��������:</TD>
							<TD>
								<script>
								function procdays (month) 
								{
									var selected = document.getElementById('dd').value;
									if (selected == \"\") selected=1;
									document.getElementById('dd').length = 0;
									var days = new Array(3,0,3,2,3,2,3,3,2,3,2,3);
									if (Math.round(document.getElementById('yyyy').value/4) == document.getElementById('yyyy').value/4) {days[1]=1;}
									var ind = parseFloat(month.value)-1;
									if (ind < 0) ind=0;
									var base = 29 + days[ind];
									if (selected>(base-1)) {selected=1;}
									for (var i=1; i<base; i++) {
									var myday = document.createElement(\"option\");
									myday.value = i;
									myday.text = i;
									document.getElementById('dd').add(myday);
									}
									document.getElementById('dd').value = selected;
									genZerodate();
									return true;
								}
								function genZerodate () 
								{
									var ss=document.getElementById('dd').value;
									if (ss.length < 2) ss='0'+ss;
									var str = ss+'.'+document.getElementById('mm').value+'.'+document.getElementById('yyyy').value;
									document.getElementById('nhya').value = str;
									return true;
								}
								</script>
								����:
								<select name=\"DD\" id=\"dd\" class=\"inup\" onchange=\"genZerodate();\">
									<script>
										var s=\"\";
										for (i=1; i<=31; i++) 
										{
										s+='<option value=\"'+i+'\">'+i+'</option>';
										}
										document.write(s);
									</script>
								</select>
								�����:
								<select name=\"MM\" onchange=\"procdays(this);\"  class=\"inup\" id=\"mm\">
									<option value=\"01\" selected=\"selected\">������</option>
									<option value=\"02\">�������</option>
									<option value=\"03\">����</option>
									<option value=\"04\">������</option>
									<option value=\"05\">���</option>
									<option value=\"06\">����</option>
									<option value=\"07\">����</option>
									<option value=\"08\">������</option>
									<option value=\"09\">��������</option>
									<option value=\"10\">�������</option>
									<option value=\"11\">������</option>
									<option value=\"12\">�������</option>
								</select>
								���:
								<select name=\"YYYY\" class=\"inup\" onchange=\"procdays(document.getElementById('mm'));\" id=\"yyyy\">
									<script>
										var s=\"\";
										for (i=2002; i>=1920; i--) 
										{
											s+='<option value=\"'+i+'\">'+i+'</option>';
										}
										document.write(s);
									</script>
								</select>
								<input type=\"text\" name=\"0day\" id=\"nhya\" value=\"".clean_var($birthday)."\" style=\"width:0px; height:0px; visibility:hidden\" />
								<script>
									var s=document.getElementById('nhya');
									s=s.value.split(\".\");
									if (s.length > 0) 
									{
										s[0]=parseFloat(s[0]);
										FORM1.DD.value=s[0];
									}
									if (s.length > 1) 
									{
										s[1]=parseFloat(s[1]);
										if (s[1] < 10 ) s[1]='0'+s[1];
										FORM1.MM.value=s[1];
									}
									if (s.length > 2) 
									{
										s[2]=parseFloat(s[2]);
										if (s[2] < 10 ) {s[2]='200'+s[2];} else 
										{
											if (s[2] < 100 ) s[2]='19'+s[2];
										}
										FORM1.YYYY.value=s[2];
									}
									procdays(document.getElementById('mm'));
								</script>
							</TD>
						</TR>
						<TR>
							<TD colspan=\"2\"><small><b>��������!</b> ���� �������� ������ ���� ����������, ��� ������������ � ������� ��������. ������ � ������������ ����� ����� ��������� ��� ��������������.</small></TD>
						</TR>
						<tr><td colspan=2 height=20></td></tr>
						<TR>
							<TD colspan=\"2\"><font color=#FF0000>*</font> ��� ���:<BR>
								<INPUT id=A1 style=\"CURSOR: hand\" type=radio value=\"0\" name=\"sex\"".($sex<1?" CHECKED":"").">
								<LABEL for=A1> �������</LABEL>
								<BR>
								<INPUT id=A2 style=\"CURSOR: hand\" type=radio value=\"1\" name=\"sex\"".($sex==1?" CHECKED":"").">
								<LABEL for=A2> �������</LABEL>
							</TD>
						</TR>
						<TR>
							<TD><font color=#FF0000>*</font> �����: </TD>
							<TD><INPUT TYPE=\"text\" value='".clean_var($city2)."' NAME=\"city2\" size=20 maxlength=40 class=\"inup\"></TD>
						</TR>
						<TR>
							<TD>ICQ:</TD>
							<TD><input value='".clean_var($icq)."' name=icq class=\"inup\" size=9 maxlength=20></TD>
						</TR>
						<TR>
							<TD>�����:</TD>
							<TD><input value='".clean_var($about)."' name=about class=\"inup\" size=60 maxlength=160></TD>
						</TR>
						<TR>
							<TD>���� ��������� � ����:</TD>
							<TD>
								<select name=ChatColor class=\"inup\">
									<option style=\"BACKGROUND: #f2f0f0; COLOR: black\" value=\"Black\" >Black</option>
									<option style=\"BACKGROUND: #f2f0f0; COLOR: blue\"	value=\"Blue\" >Blue</option>
									<option style=\"BACKGROUND: #f2f0f0; COLOR: fuchsia\" value=\"Fuchsia\" >Fuchsia</option>
									<option style=\"BACKGROUND: #f2f0f0; COLOR: gray\" value=\"Gray\" >Grey</option>
									<option style=\"BACKGROUND: #f2f0f0; COLOR: green\" value=\"Green\" >Green</option>
									<option style=\"BACKGROUND: #f2f0f0; COLOR: maroon\" value=\"Maroon\">Maroon</option>
									<option style=\"BACKGROUND: #f2f0f0; COLOR: navy\" value=\"Navy\" >Navy</option>
									<option style=\"BACKGROUND: #f2f0f0; COLOR: olive\" value=\"Olive\" >Olive</option>
									<option style=\"BACKGROUND: #f2f0f0; COLOR: purple\" value=\"Purple\" >Purple</option>
									<option style=\"BACKGROUND: #f2f0f0; COLOR: teal\" value=\"Teal\" >Teal</option>
									<option style=\"BACKGROUND: #f2f0f0; COLOR: orange\" value=\"Orange\" >Orange</option>
									<option style=\"BACKGROUND: #f2f0f0; COLOR: chocolate\" value=\"Chocolate\" >Chocolate</option>
									<option style=\"BACKGROUND: #f2f0f0; COLOR: darkkhaki\" value=\"DarkKhaki\" >DarkKhaki</option>
									<option style=\"BACKGROUND: #f2f0f0; COLOR: sandybrown\" value=\"SandyBrown\" >SandyBrown</option>
								</select>
								<SCRIPT>FORM1.ChatColor.value='".$chatcolor."'</SCRIPT>
							</TD>
						</TR>
						<TR>
							<TD><INPUT onclick='FORM1.step.value=\"2\"; FORM1.submit()' type=button class=\"btn\" value=\"���������\"></TD>
							<TD><INPUT type=submit class=\"btn\" value=\"����������\"></TD>
						</TR>
						</table>
				</td>
				</tr>
				</table></FORM>";
				break;
				//--------------------------------------------------------------------------------------------------------
				case 5:
					echo "<FORM action='reg.php' method='POST' name='FORM1'>
					<TABLE WIDTH=600 CELLSPACING=1 CELLPADDING=2 BGCOLOR=#212120 name=\"F1\">
		            <INPUT type=hidden name=step value='5'>
		            <INPUT type=hidden name=add value='1'>
					<TR bgcolor=#D5D5D5>
						<TD>
							<table width=100% border=0 CELLSPACING=0 CELLPADDING=0>
							<TR>
								<td colspan=2>
									<B>��������!</B></span> ������ ���� �������� <U>������</U> ��� ��������� Internet Explorer!<BR><BR>
									<FONT color=red>".clean_var($message)."</FONT><br>
									��� ������ ���������: <input type='hidden' NAME=\"login\" value='".clean_var($login)."'><b>".clean_var($login)."</b>
								</TD>
							</TR>
				            <TR>
				    			<input type='hidden' name='ref' value=\"".$ref."\">
								<input type='hidden' name='psw' value=\"".clean_var($psw)."\">
								<input type='hidden' name='psw2' value=\"".clean_var($psw)."\">
				                <input type='hidden' name='email' value=\"".clean_var($email)."\">
				                <input type='hidden' name='name' value=\"".clean_var($name)."\">
				                <input type='hidden' name='0day' value=\"".clean_var($birthday)."\">
				                <input type='hidden' name='sex' value=\"".clean_var($sex)."\">
				                <input type='hidden' name='city2' value=\"".clean_var($city2)."\">
				                <input type='hidden' name='icq' value=\"".clean_var($icq)."\">
				                <input type='hidden' name='about' value=\"".clean_var($about)."\">
				                <input type='hidden' name='ChatColor' value=\"".clean_var($chatcolor)."\">
				                <TD colspan=\"2\">
				            		<INPUT id=A3 style=\"CURSOR: hand\" type=checkbox name='Law'>
				                    <LABEL for=A3><font color=#FF0000>*</font> � �������� ���������</LABEL> <A TARGET=\"_blank\" HREF=\"rules.php\"><B>������ WWW.http://oldmeydan.pe.hu/</B></A> � �������� �� ����� �������� <A TARGET=\"_blank\" HREF=\"soqlaweniya.php\"><B>����������������� ����������</B></A>
				            	</TD>
							</TR>
							<TR>
				                <TD valign=top><font color=#FF0000>*</font> ������� ���: <INPUT type=text name='code' maxlength=12 size=30></TD>
				            	<TD><img src='antibot.php?".session_id()."' border=0></TD>
				            </TR>
							<TR>
		                        <TD><INPUT onclick='FORM1.step.value=\"3\"; FORM1.submit()' type=button class=\"btn\" value=\"���������\"></TD>
		                        <TD><INPUT type=submit class=\"btn\" value=\"����������������\"></TD>
				            </TR>
			        	</table>
		        	</TD>
		  		</TR>
				</TABLE></FORM>";
			}
			#=========================================================================================================
			echo "
			<table width=600 bgcolor=#B2B2B2><tr><td align=center>
			����� ����� ������ ��������� ���������. ��� ����� ���������� � �����������.<br>
			��� ����� � ������ �� ���������� <A TARGET=_blank HREF=\"rules.php\"><u>������ � ���������� WWW.http://oldmeydan.pe.hu/.</u></a>
			<br><br>&copy; Copyright 2006-".date("Y").", ��� ����� ��������. <a href='' class=us2>WWW.http://oldmeydan.pe.hu/</a>
			</td></tr></table>";
	echo "</td>
	<td width=250 nowrap><img src='img/index/warrior2.png' border=0></td>
	</tr>
</table>";
include_once("counter.php");
echo "</div></BODY>
</HTML>";
?>