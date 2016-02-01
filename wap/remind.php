<?
	header("Content-type: text/html; charset=windows-1251");
	header("Cache-Control: no-cache, must-revalidate"); // говорим браузеру что-бы он не кешировал эту страницу
	header("Pragma: no-cache");
	include ("conf.php");
	$data = mysql_connect($base_name, $base_user, $base_pass) or die('Не получается подключиться. Проверьте имя сервера, имя пользователя и пароль!');
	mysql_select_db($db_name) or die('Ошибка входа в базу данных');
	$ip=getenv('REMOTE_ADDR');
	echo '<?xml version="1.0" encoding="windows-1251"?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.2//EN" "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="en">';

?>
<html>
<head>
	<title>WAP.MEYDAN.AZ - [Восстановление забытого пароля]</title>
	<link rel="stylesheet" href="main.css" type="text/css"/>	
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
	<meta http-equiv="Content-Language" content="ru" />
	<meta name="Description" content="Отличная RPG онлайн игра посвященная боям и магии. Тысячи жизней, миллионы смертей, два бога, сотни битв между Светом и Тьмой." />
	<meta http-equiv="cache-control" content="no-cache" />
	<meta http-equiv="pragma" content="no-cache" />
	<meta http-equiv="expires" content="0" />
</head>
<?
	$login=htmlspecialchars(addslashes($_POST['login']));
	$mymail=htmlspecialchars(addslashes(strtolower(trim($_POST['mail']))));
	$birth=htmlspecialchars(addslashes($_POST['day'].".".$_POST['month'].".".$_POST['year']));
	if(!empty($login))
	{
	 	$db = mysql_fetch_array(mysql_query("SELECT * FROM users LEFT JOIN info on info.id_pers=users.id WHERE login='".$login."'"));
		if(!$db)
		{
     		$msg="Персонаж <u>".$login."</u> не найден в базе данных!";
    	}
    	else if($db["email"]!=$mymail)
    	{
    		$msg="Почтовый адрес указан неверно.";
    	}
    	else if($db["birth"]!=$birth)
    	{
    		$msg="День рождения указан неверно.";
    	}	
    	else 
    	{
    		$login_full=$db["login"];
			$pass = base64_decode($db["password"]);
			
			$subject="WAP.MEYDAN.AZ. Пароль для персонажа $login_full";
			
			$message = "<center><b style='color:#ff0000;font-size:15px'>WAP.MEYDAN.AZ - Отличная RPG онлайн игра посвященная боям и магии. Тысячи жизней, миллионы смертей, два бога, сотни битв между Светом и Тьмой.</b></center><br><br>";
			$message .= "<b>Здраствуйте!</b><br><br>";
			$message .= "Кто-то с ip-адреса <b>$ip</b> запросил пароль к персонажу <b style='color:green;font-size:12px'>$login_full</b> он-лайн игры <a href='http://wap.meydan.az'><b>WAP.MEYDAN.AZ</b></a>.<br>";
			$message .= "Так как в анкете персонажа <b style='color:green;font-size:12px'>$login_full</b> указан этот e-mail, система выслала пароль.<br><br>";
			$message .= "<b>Персонаж:</b>  $login_full<br>";
			$message .= "<b>Пароль:</b>    $pass<br><br>";
			$message .= "<i>(Это письмо сгенерировано автоматически, не надо на него отвечать!)</i><br><br>";
			$message .= "<div align=right style='color:green;font-weight:bold'>Администрация WAP.MEYDAN.AZ.</div></font>";
			
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=windows-1251' . "\r\n";
			$headers .= 'From: WAP.MEYDAN.AZ <admin@meydan.az>' . "\r\n";
			
			if (mail($db["email"], $subject, $message, $headers))
			{
				$msg="Внимание! Письмо с паролем будет отправлено на почту указанный в анкете в течении 5 минут.";
			} 
			else 
			{
				$msg="Внимание! Не удалось отправить пароль на e-mail, указанный в анкете!";
			}
		}
	}
	?>
<body>
<div id="cnt" class="content">
	<div class="aheader"><b style='color:#ff0000'><?=$msg?></b></div><br/>
	<div class="aheader">
		<b>Восстановление забытого пароля</b>
		<form action="remind.php" name="pass" method="post">
			<b>Логин:</b> <input type="text" class="inup" size="20" name="login"><br/>
			<b>Email:</b> <input type="text" class="inup" size="20" name="mail"><br/>
			
			<b>День:</b>
			<select name="day" class="inup">
				<option value="01">01</option>
				<option value="02">02</option>
				<option value="03">03</option>
				<option value="04">04</option>
				<option value="05">05</option>
				<option value="06">06</option>
				<option value="07">07</option>
				<option value="08">08</option>
				<option value="09">09</option>
				<option value="10">10</option>
				<option value="11">11</option>
				<option value="12">12</option>
				<option value="13">13</option>
				<option value="14">14</option>
				<option value="15">15</option>
				<option value="16">16</option>
				<option value="17">17</option>
				<option value="18">18</option>
				<option value="19">19</option>
				<option value="20">20</option>
				<option value="21">21</option>
				<option value="22">22</option>
				<option value="23">23</option>
				<option value="24">24</option>
				<option value="25">25</option>
				<option value="26">26</option>
				<option value="27">27</option>
				<option value="28">28</option>
				<option value="29">29</option>
				<option value="30">30</option>
				<option value="31">31</option>
			</select>
		<br/>
		<b>Месяц:</b>
			<select name="month" class="inup">
				<option value="01" selected="selected">Январь</option>
				<option value="02">Февраль</option>
				<option value="03">Март</option>
				<option value="04">Апрель</option>
				<option value="05">Май</option>
				<option value="06">Июнь</option>
				<option value="07">Июль</option>
				<option value="08">Август</option>
				<option value="09">Сентябрь</option>
				<option value="10">Октябрь</option>
				<option value="11">Ноябрь</option>
				<option value="12">Декабрь</option>
			</select>
		<br/>
		<b>Год:</b>
			<select name="year" class="inup">
			<?
				
				for ($i=2010; $i>=1920; $i--) 
				{
					$s.='<option value="'.$i.'">'.$i.'</option>';
				}
				echo $s;
			?>
			</select>
		<br/><br/>
		<input type="submit" style="cursor:hand" class="inup" value="Выслать пароль"><br/><br/>
	</form>
	</div>
	<?include("bottom_index.php");?>			
</div>
</html>