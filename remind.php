<?
	HEADER("Content-type: text/html; charset=windows-1251");
	Header("Cache-Control: no-cache, must-revalidate"); // говорим браузеру что-бы он не кешировал эту страницу
	Header("Pragma: no-cache");
	include "conf.php";
	$data = @mysql_connect($base_name, $base_user, $base_pass) or die('Не получается подключиться. Проверьте имя сервера, имя пользователя и пароль!');
	mysql_select_db($db_name) or die('Ошибка входа в базу данных');
	$ip=getenv('REMOTE_ADDR');
?>
<html>
<HEAD>	
	<title>WWW.Oldmeydan.pe.hu - [Восстановление забытого пароля]</title>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<meta http-equiv="Content-Language" content="ru">
	<META Http-Equiv=Cache-Control Content="no-cache, max-age=0, must-revalidate, no-store">
	<meta http-equiv=PRAGMA content=NO-CACHE>
	<meta http-equiv=Expires content=0>	
	<LINK REL=StyleSheet HREF='smith.css' TYPE='text/css'>
</HEAD>
<body bgcolor=#dddddd>
<?

	$login=htmlspecialchars(addslashes($_POST['login']));
	$mymail=htmlspecialchars(addslashes(strtolower(trim($_POST['mail']))));
	$birth=htmlspecialchars(addslashes($_POST['day'].".".$_POST['month'].".".$_POST['year']));
	if(!empty($login) && !empty($mymail))
	{
	 	$sql=mysql_query("SELECT * FROM users LEFT JOIN info on info.id_pers=users.id WHERE login='".$login."'");
	 	$db = mysql_fetch_array($sql);
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
			
			$subject="WWW.Oldmeydan.pe.hu. Пароль для персонажа $login_full";
			
			$message = "<center><b style='color:#ff0000;font-size:15px'>WWW.Oldmeydan.pe.hu - Отличная RPG онлайн игра посвященная боям и магии. Тысячи жизней, миллионы смертей, два бога, сотни битв между Светом и Тьмой.</b></center><br><br>";
			$message .= "<b>Здраствуйте!</b><br><br>";
			$message .= "Кто-то с ip-адреса <b>$ip</b> запросил пароль к персонажу <b style='color:green;font-size:12px'>$login_full</b> он-лайн игры <a href='http://www.Oldmeydan.pe.hu'><b>WWW.Oldmeydan.pe.hu</b></a>.<br>";
			$message .= "Так как в анкете персонажа <b style='color:green;font-size:12px'>$login_full</b> указан этот e-mail, система выслала пароль.<br><br>";
			$message .= "<b>Персонаж:</b>  $login_full<br>";
			$message .= "<b>Пароль:</b>    $pass<br><br>";
			$message .= "<i>(Это письмо сгенерировано автоматически, не надо на него отвечать!)</i><br><br>";
			$message .= "<div align=right style='color:green;font-weight:bold'>Администрация WWW.Oldmeydan.pe.hu.</div></font>";
			
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=windows-1251' . "\r\n";
			$headers .= 'From: WWW.Oldmeydan.pe.hu <admin@Oldmeydan.pe.hu>' . "\r\n";
			
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
		<h3>Восстановление забытого пароля</h3>
		<form action="remind.php" name="pass" method="POST">
		<table align=center>
			<tr><td colspan=3><b style='color:red'><?=$msg?>&nbsp;</td></tr>
			<tr><td align=right><b>Логин:</td><td colspan=2><input type=text size=25 name="login"></td></tr>
			<tr><td align=right><b>Email:</td><td colspan=2><input type=text size=25 name="mail"></td></tr>
			<tr><td align=right>
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
			</td>
			<td>
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
			</td>
			<td>
			<b>Год:</b>
			<select name="year" class="inup">
			<SCRIPT>
				var s="";
				for (i=2010; i>=1920; i--) 
				{
					s+='<option value="'+i+'">'+i+'</option>';
				}
				document.write(s);
			</SCRIPT>
			</td>
			</tr>
			<tr><td colspan=3 align='center'><input type='submit' style='cursor:hand' value="Выслать пароль"></td></tr>
		</table>
		</form>
		</html>