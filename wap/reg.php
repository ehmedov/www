<?
session_start();
include ("conf.php");
header("Content-Type: text/html; charset=windows-1251");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

$data = mysql_connect($base_name, $base_user, $base_pass) or die('Не получается подключиться. Проверьте имя сервера, имя пользователя и пароль!');
mysql_select_db($db_name) or die('Ошибка входа в базу данных');
$ip=getenv('REMOTE_ADDR');

echo '<?xml version="1.0" encoding="windows-1251"?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.2//EN" "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="en">';
?>
<head>
	<title>WAP.MEYDAN.AZ- Начни играть бесплатно онлайн в реальном времени</title>
	<link rel="stylesheet" href="main.css" type="text/css"/>	
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
	<meta http-equiv="Content-Language" content="ru" />
	<meta name="Description" content="Отличная RPG онлайн игра посвященная боям и магии. Тысячи жизней, миллионы смертей, два бога, сотни битв между Светом и Тьмой." />
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
		echo "<b>До регистрация: ".$m." мин. ".$sec." сек. (IP: $ip)</b><br/>";
		echo 'Приветствую тебя Путник!
		Я создание Древних. <br/><br/>

		Раз ты пришел в этот мир, значит  тебя привлек блеск нашей стали и 
		мощь нашей магии.<br/>
		Я расскажу тебе что это за Мир и зачем  он существует.<br/><br/>

		Много столетий назад, ужасная война с порождениями всепроникающего 
		Хаоса заставила нас,  ордена прибегнуть к  магии Судьбы. <br/>
		Мы спасли этот мир, но стали заложниками собственного выбора.<br/><br/>

		Отныне везде, где равновесие мира качнется в сторону Хаоса,
		появляется мир - Другой Мир. Мы выбрали его, и он принял нас.
		Но Другой мир не есть Зло, как и мир загранью этого. <br/>
		Очень часто люди творят зло, но выглядят Светом в глазах окружающих. <br/><br/>

		Мы же творим справедливость, пребывая в Тени. У нас своя мораль, 
		свои законы.Они просты: лжец должен быть изгнан, 
		предатель уничтожен, честь должна быть превыше всего, 
		благородство суть проявление силы. Могие думают иначе, 
		но мы знаем правду. И несем ее в этот мир используя любые средства.<br/><br/>
		 
		Честь и справедливость во благо истины.<br/><br/>

		- Не задавай вопросов, все ответы ты получишь в ближайшее время. <br/>
		Твоя судьба зависит лишь от тебя. Борись за выживание, ведь ты не один,
		ты можешь стать вожаком и  привести своё племя к победе.';
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
			$ru = "УЕЫАОЭЯИЮЁЙЦКНГШЩЗХЪФВПРЛДЖЧСМТЬБ";
			$en = "EYUIOAQWRTPSDFGHJKLZXCVBNM";
			$splits="-_ ";
			$oklogin=true; $okpsw=true; $okemail=true; $okname=true; $okall=true;
			####################################################################
			if (strlen($login)>20) {$message="Логин должен содержать не более 20 символов";$oklogin=false;}
			if (strlen($login)<3) {$message="Логин должен содержать не менее 3 символов";$oklogin=false;}
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
				$message= "Логин может состоять только из букв русского алфавита или только из букв англиского алфавита";$oklogin=false;
			}
			if ($is_eng) {$s=$en;$sogl=substr($en,6);} else {$s=$ru;$sogl=substr($ru,10);}
			$ps=-1;$p=0;
			$blacklist="ЬЪ";$blackwordlist="хуй,пизд,sik,amciq,amcig,kurtlar,petux,qehbe,gehbe,kahbe,cirix,cindir,calan,got,qot,s i k,p e t u x,a m c i g, k u r t l a r";
			for($i=0; $i<strlen($login); $i++) 
			{
				if (strpos($s,$login[$i])>-1) 
				{ 
					#большие буквы
					if (!$p && $i==$ps+1) 
					{
						$p=1;$words++; #началось с большой буквы
						$lwords[$words].=$login[$i];
					}
					elseif ($p==2 && $i>$ps+1) 
					{
						$message="Логин не может содержать заглавную букву после обычной.";$oklogin=false;break;
					}
					#были маленькие теперь большая буква - курсор=более чем след символ после разделителя
				}
				elseif (strpos(strtolower($s),$login[$i])>-1)
				{ 
					#маленькие буквы
					if (!$p && $i==$ps+1) {$words++;}
					$lwords[$words].=$login[$i];
					$p=2;
				} 
				elseif (strpos($splits,$login[$i])>-1) 
				{
					#найден разделитель
					if ($ps==$i-1) {$message="Не может быть два и более разделителя подряд, также имя не может с них начинаться.";$oklogin=false;break;}
					$ps=$i;$p=0;
					#не может быть двух разделителей подряд
					#не может быть разделителей в начале и конце имени в любом сочетании друг с другом
				}
				else
				{
					$message=$login[$i]."Логин содержит запрещенные символы.";$oklogin=false;break;
				}
				if ($i>0) 
				{
					if ($login[$i-1]==$login[$i]) 
					{
						$rep++;
						if (preg_match("![".$blacklist."]{2,}!i",$login)) 
						{
							$message="Запрещенная комбинация подряд идущих символов.";$oklogin=false;break;
						}
						#if (strpos($blacklist,strtoupper($login[$i]))>-1) {$message="Запрещенная комбинация подряд идущих символов.";$oklogin=false;break;}
						if ($rep>1) {$message="Логин не должно содержать более двух повторяющихся букв подряд.";$oklogin=false;break;}
					} 
					else {$rep=0;}
					if (preg_match("![".$sogl."]{4,}!i",$login)) 
					{
						$message="Логин не должно содержать 4 и более подряд идущих согласных букв.";$oklogin=false;break;
					}
				}
			}
			for ($i=0;$i<10;$i++) 
			{
				if (strpos($login,"".($i))>-1) {$message="Логин не должно содержать цифр.";$oklogin=false;break;}
			}
			$have_nik=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE login='".$login."'"));
			if ($have_nik){$message= "Логин <b>".$have_nik["login"]."</b> уже зарегистрирован!";$oklogin=false;}
			unset($blacklist,$p,$ps,$rep,$repsogl,$s,$sogl,$is_eng,$is_rus);
			#########################################################
			if ($psw!=$psw2) {$message="Введенные поля пароли не совпадают.";$okpsw=false;}
	    	elseif (strlen($psw)<6) {$message="Пароль не может быть короче 6 символов.";$okpsw=false;}
	    	elseif (strlen($psw)>21) {$message="Пароль не может быть длиннее 21 символа.";$okpsw=false;}
	    	else 
	    	{
	    		#Запрещены пароли содержащие только буквы одной раскладки и одного регистра
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
	    			$message="Запрещены пароли содержащие только буквы одной раскладки и одного регистра.";$okpsw=false;
	    		}
	    		else if ($d>0 && $is_rus==0 && $is_eng==0)
	    		{
	    			 #цифры есть но нет букв
	    			$message="Запрещены пароли содержащие только цифры";$okpsw=false;
	    		}
	    		unset($is_rus,$is_eng);
	    		unset($d,$raskl);
	   			#Запрещены простые, распространенные пароли.
	        	$deniedpsw="qwer,qazws,zxcv,123,1234,12345,123456,йцук,фывап,ячсм";
	        	$bwl=explode(",",strtoupper($deniedpsw));
	        	for ($i=0;$i<count($bwl);$i++) 
	        	{
	           		if (strpos(strtoupper($psw),$bwl[$i])>-1) {$message="Пароль слишком простой.";$okpsw=false;break;}
	        	}
	        	$s=similar_text(strtoupper($login),strtoupper($psw));
	      		if (($s>5) || ($s>=strlen($login))) {$message="Попробуйте выбрать пароль более отличающийся от логина.";$okpsw=false;}
	      		unset($s,$bwl,$deniedpsw);
	   		}
	   		#########################################################
			if (strlen($email)>50) {$message="E-Mail не может быть длиннее 50 символов.";$okemail=false;}
			$res=mysql_fetch_array(mysql_query("SELECT count(*) FROM info WHERE email='".$email."'"));
			if ($res[0]>0) {$message="Данный E-Mail уже зарегистрирован.";$okemail=false;}
			if (!preg_match('#^[a-z0-9.!\#$%&\'*+-/=?^_`{|}~]+@([0-9.]+|([^\s]+\.+[a-z]{2,6}))$#si', $email))
			{
				$message="Неверно введен почтовый адрес.";$okemail=false;
			}
			$deniedmail="hotmail.com,bk.ru";
			$bwl=explode(",",strtoupper($deniedmail));
			for ($i=0;$i<count($bwl);$i++) 
			{
		    	if (strpos(strtoupper($email),$bwl[$i])>-1) {$message="Почтовые адреса данного сервера запрещены.";$okemail=false;break;}
			}
			unset($deniedmail,$bwl);
			#########################################################
			$en=preg_match("/^(([a-zA-Z ])+)$/i", $name);
			$ru=preg_match("/^(([а-яА-Я ])+)$/i", $name);
			if ((($en && $ru) || (!$en && !$ru)) && ($name)){$message="Неверное имя";$okname=false;}
			if (!$name) {$message="Не указан имя";$okname=false;}
			
			$en=preg_match("/^(([a-zA-Z ])+)$/i", $city);
			$ru=preg_match("/^(([а-яА-Я ])+)$/i", $city);
			if ((($en && $ru) || (!$en && !$ru)) && ($city)) {$message="Неверное название города";$okname=false;}
			if (!$city) {$message="Не указан город";$okname=false;}
			
			if (!preg_match("/^(([0-9-])+)$/i", $icq) && $icq) {$message="Неверное поле ICQ";$okname=false;}
			if (!preg_match("/^(([0-9 ])+)$/i", $sex) || $sex<0 || $sex>2) {$message="Неверное поле пол";$okname=false;}
			#########################################################
			if (!$law) {$message="Необходимо согласие с законами игры.";$okall=false;}
			if ($code!=$_SESSION['sec_code_session']) {$message="Ошибка при введении кода!";$okall=false;}
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
			    
				$def_status = "Новичок";
				
				mysql_query("LOCK TABLES users WRITE, inv WRITE, report WRITE, info WRITE");
				mysql_query("INSERT INTO `users`(login,refer,password,level,sex, date, reg_ip, city_game,  obraz, status, room, color,money)  VALUES('".$login."','".$ref."','".$password."','0','".$sexy."','$server_date-$server_time','$ip','$def_city_game','$def_obraz','$def_status','$def_room','".$chatcolor."',100);");
				$id_pers=mysql_insert_id();
				mysql_query("INSERT INTO info (id_pers,icq, name, town, deviz,email,birth,born_city)  VALUES(".$id_pers.",'".$icq."','".$name."','".$city."','".$deviz."','".$email."','".$birthday."','".$def_city_game."');");
				mysql_query("INSERT INTO inv(owner,object_id,object_type,object_razdel,gift,wear,iznos,gift_author,iznos_max,name,img,price,mass,add_hp) 
				VALUES('".$login."','1','rubaxa','obj','1','0','0','WWW.MEYDAN.AZ','20','Накидка Новичка','rubaxa/1.gif',1,1,8);");
				mysql_query("DELETE FROM report WHERE ip='$ip' and type='0'");
				mysql_query("INSERT INTO `report`(date,login,action,type,ip) VALUES('$server_date-$server_time','".$login."','Персонаж зарегистрирован','0','$ip');");
				mysql_query("UNLOCK TABLES");
				$_SESSION['logins']=$login;
				$_SESSION['psw']=$psw;
				header("Location: enter.php?tmp=".md5(time()));
				die();
			}
		}
		?>
		<center><b>Регистрация</b></center>
		<font color='#ff0000'><?=$message;?></font><br/>
			<form method="post" action="">
				<font color='#ff0000'>*</font> Логин: <input name='login' value='<?=$login;?>' class='inup' size='20' maxlength='30' /><br/><br/>
				<font color='#ff0000'>*</font> Пароль: <input name='psw' type='password' value='' class='inup' size='20' maxlength='21' /><br/><br/>
				<font color='#ff0000'>*</font> Пароль повторно: <input name='psw2' type='password' value='' class='inup' size='20' maxlength='21' /><br/><br/>
				<font color='#ff0000'>*</font> Ваш e-mail:  <input name='email' class='inup' value='<?=$email;?>' size='20' maxlength='50' /><br/><br/>
				<font color='#ff0000'>*</font> Ваше реальное имя: <input name='name' value='<?=$name;?>' class='inup' size='20' maxlength='90' /><br/><br/>
				<font color='#ff0000'>*</font> День рождения: 
												<?
												echo "<select name='dd' class='inup'>";
												for ($day=1;$day<=31;$day++){echo "<option value='$day'".($day==$_POST["dd"]?" selected":"").">$day</option>";}
												echo "</select> ";
												echo "<select name='mm' class='inup'>
												<option value='01'".($_POST["mm"]=='01'?" selected":"").">Январь</option>
												<option value='02'".($_POST["mm"]=='02'?" selected":"").">Февраль</option>
												<option value='03'".($_POST["mm"]=='03'?" selected":"").">Март</option>
												<option value='04'".($_POST["mm"]=='04'?" selected":"").">Апрель</option>
												<option value='05'".($_POST["mm"]=='05'?" selected":"").">Май</option>
												<option value='06'".($_POST["mm"]=='06'?" selected":"").">Июнь</option>
												<option value='07'".($_POST["mm"]=='07'?" selected":"").">Июль</option>
												<option value='08'".($_POST["mm"]=='08'?" selected":"").">Август</option>
												<option value='09'".($_POST["mm"]=='09'?" selected":"").">Сентябрь</option>
												<option value='10'".($_POST["mm"]=='10'?" selected":"").">Октябрь</option>
												<option value='11'".($_POST["mm"]=='11'?" selected":"").">Ноябрь</option>
												<option value='12'".($_POST["mm"]=='12'?" selected":"").">Декабрь</option>
												</select> ";
												echo "<select name='yy' class='inup'>";
												for ($year=1920;$year<=2012;$year++){echo "<option value='$year'".($year==$_POST["yy"]?" selected":"").">$year</option>";}
												echo "</select>";
												?><br/><br/>
				<font color='#ff0000'>*</font> Ваш пол: 
											<select name='sex' class='inup'>
												<option value='0'>Мужской</option>
												<option value='1'>Женский</option>
											</select><br/><br/>
				<font color='#ff0000'>*</font> Город: <input type='text' class='inup' name='city' value='<?=$city;?>' size='20' maxlength='40' /><br><br/>
				ICQ: <input name='icq' value='<?=$icq;?>' class='inup' size='20' maxlength='20' /><br/><br/>
				Девиз: <input name='deviz' value='<?$deviz;?>' class='inup'  size='20' maxlength='160' /><br/><br/>
				<input type='checkbox' name='Law' <?if($_POST["Law"]) echo "checked";?> /> <font color='#ff0000'>*</font> Я обязуюсь соблюдать <a href='http://www.meydan.az/rules.php'>Законы WWW.MEYDAN.AZ</a> и согласен со всеми пунктами <a href='http://www.meydan.az/soqlaweniya.php'>Пользовательского соглашения</a><br/><br/>
				<font color='#ff0000'>*</font> Введите код: <input type='text' name='code' class='inup' size='20' maxlength='12' /><br/>
				<img src='antibot.php?<?=session_id();?>' border='0'><br/><br/>
				<input class="inup" type="submit" value="OK" /><br/>
			</form>
		<?
	}
	?>
	</div>
	<?include("bottom_index.php");?>
</div>