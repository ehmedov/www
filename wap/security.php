<?
include ("key.php");
include ("conf.php");
include ("align.php");
include ("functions.php");

header("Content-Type: text/html; charset=windows-1251");
header("Cache-Control: no-cache, must-revalidate"); // говорим браузеру что-бы он не кешировал эту страницу
header("Pragma: no-cache");
echo '<?xml version="1.0" encoding="windows-1251"?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.2//EN" "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="en">';
$login=$_SESSION["login"];
$uin_id=$_SESSION["uin_id"];
$message="";
$data = mysql_connect($base_name, $base_user, $base_pass) or die('Не получается подключиться. Проверьте имя сервера, имя пользователя и пароль!');
mysql_select_db($db_name) or die('Ошибка входа в базу данных');

$db = mysql_fetch_array(mysql_query("SELECT * FROM users LEFT JOIN info on info.id_pers=users.id WHERE login='".$login."'"));
TestBattle($db);
if($db["room"]=="house")
{
	$_SESSION["message"]="Вы в Гостинице";
	Header("Location: main.php?tmp=".md5(time()));
	die();
}
$ip=$db["remote_ip"];
?>
<html>
<head>
	<title>WAP.MEYDAN.AZ</title>
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

	<?
	if ($_POST['dochpass']) 
	{
		$ok=true;
		$newpass=HtmlSpecialChars($_POST['newpass']);
		$newpass2=HtmlSpecialChars($_POST['newpass2']);
		$oldpass=HtmlSpecialChars($_POST['oldpass']);
		
		if (strlen($newpass)<6) {$ok=false;$mess='Ошибка. Пароль не может быть короче 6 символов.';}
		if (strlen($newpass)>20) {$ok=false; $mess="Ошибка. Пароль не может быть длиннее 21 символа.";}
		if ($newpass!=$newpass2) {$ok=false;$mess='Ошибка. Пароли не совпадают.';}
		if (trim($newpass)=='') {$ok=false;$mess='Ошибка. Задан пустой пароль';}
		if ($oldpass!=base64_decode($db["password"])) {$ok=false;$mess="Ошибка. Старый пароль указан неверно.";}
		if ($ok) 
		{
			$date = date("d.m.Y H:i");
			mysql_query("UPDATE users SET password='".addslashes(base64_encode($newpass))."' WHERE login='".$login."'");
			history($login,"Был сменен пароль",$date,$ip,"Анкета");
            
			$subject  = "Смена пароля у персонажа $login";

            $message  = "<b>Здраствуйте, $login!</b><br/><br/>";
            $message .= "Кто-то с ip-адреса <b>".$ip."</b> $date был сменен пароль к персонажу $login он-лайн игры <b>WWW.MEYDAN.AZ</b>. <br/><br/>";
            $message .= "<b>Новый пароль</b>: $newpass<br/><br/><br/><br/>";
            $message .= "<b style='color:green'>С уважением. администрация WWW.MEYDAN.AZ.</b>";
			
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=windows-1251' . "\r\n";
			$headers .= 'From: WWW.MEYDAN.AZ <admin@meydan.az>' . "\r\n";

			if (mail($db["email"], $subject, $message, $headers))
			{
				$mess.="<b style='color:#ff0000'>Внимание! Письмо с паролем будет отправлено на почту указанный в анкете в течении 5 минут.</b><br/>";
			} 
			else 
			{
				$mess.="<b style='color:#ff0000'>Внимание! Не удалось отправить пароль на e-mail, указанный в анкете!</b><br/>";
			}
			$mess.='Новый пароль сохранен.';
		}
	}
	if ($_POST['dochmail']) 
	{
		$old_mail=HtmlSpecialChars(addslashes(strtolower(trim($_POST['old_mail']))));
		$new_mail=HtmlSpecialChars(addslashes(strtolower(trim($_POST['new_mail']))));
		$ok=true;
		if (trim($new_mail)=='') {$ok=false;$mess='Задан пустой почтовый адрес.';}
		if (!preg_match('#^[a-z0-9.!\#$%&\'*+-/=?^_`{|}~]+@([0-9.]+|([^\s]+\.+[a-z]{2,6}))$#si', $new_mail)){$ok=false;$mess="Ошибка. Неверно введен почтовый адрес.";}
		if ($old_mail!=$db["email"]) {$ok=false;$mess="Ошибка. Старый почтовый адрес указан неверно.";}
		if ($ok) 
		{	
			$date = date("d.m.Y H:i");
			mysql_query("UPDATE info SET email='".$new_mail."' WHERE id_pers='".$db["id"]."'");
			history($login,"Был сменен E-mail",$date,$ip,"Анкета");
			$mail = $db["email"];
            
			$subject  = "Смена e-mail у персонажа $login";

            $message  = "<b>Здраствуйте, $login!</b><br/><br/>";
            $message .= "Кто-то с ip-адреса <b>$ip</b> $date был сменен e-mail, указанный при регистрации персонажа <b>$login</b> он-лайн игры <b>WWW.MEYDAN.AZ</b>.<br/>";
            $message .= "<br><b>Новый e-mail</b>: $new_mail<br/><br/><br/><br/>";
            $message .= "<b style='color:green'>С уважением. администрация WWW.MEYDAN.AZ.</b>";

			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=windows-1251' . "\r\n";
			$headers .= 'From: WWW.MEYDAN.AZ <admin@meydan.az>' . "\r\n";
			
			if (mail($db["email"], $subject, $message, $headers))
			{
				$mess.="<b style='color:#ff0000'>Внимание! Письмо с паролем будет отправлено на почту указанный в анкете в течении 5 минут.</b><br/>";
			} 
			else 
			{
				$mess.="<b style='color:#ff0000'>Внимание! Не удалось отправить пароль на e-mail, указанный в анкете!</b><br/>";
			}
			$mess.='Почтовый адрес успешно сменен.';
		}
	}
	?>
	<div class="aheader">
		<b>Безопасность</b><br/>
		<font color='#ff0000'><?=$mess;?></font>
	</div>
	<div>
		<form method="post">
		<b>Старый пароль:</b> 			<input name="oldpass" type="password" class="inup" size="20" maxlength="90" /><br/>
		<b>Новый пароль:</b> 			<input name="newpass" type="password" class="inup" size="20" maxlength="90" /><br/>
        <b>Новый пароль (еще раз):</b> 	<input name="newpass2" type="password" class="inup" size="20" maxlength="90" /><br/>
		<br/><input name="dochpass" type="submit" class="inup" value="Сменить пароль" /><br/><br/>

		<b>Старый e-mail:</b> <input type="text" name="old_mail" class="inup" size="20" maxlength="90" /><br/>
		<b>Новый e-mail:</b> <input type="text" name="new_mail" class="inup" size="20" maxlength="90" /><br/>
		<br/><input name="dochmail" type="submit" class="inup" value="Сменить email" /><br/><br/>
	</div>		
	<?mysql_close();?>
	<?include("bottom.php");?>
</div>