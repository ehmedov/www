<?
include ("key.php");
include ("conf.php");
include ("align.php");
include ("functions.php");

header("Content-Type: text/html; charset=windows-1251");
header("Cache-Control: no-cache, must-revalidate"); // ������� �������� ���-�� �� �� ��������� ��� ��������
header("Pragma: no-cache");
echo '<?xml version="1.0" encoding="windows-1251"?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.2//EN" "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="en">';
$login=$_SESSION["login"];
$uin_id=$_SESSION["uin_id"];
$message="";
$data = mysql_connect($base_name, $base_user, $base_pass) or die('�� ���������� ������������. ��������� ��� �������, ��� ������������ � ������!');
mysql_select_db($db_name) or die('������ ����� � ���� ������');

$db = mysql_fetch_array(mysql_query("SELECT * FROM users LEFT JOIN info on info.id_pers=users.id WHERE login='".$login."'"));
TestBattle($db);
if($db["room"]=="house")
{
	$_SESSION["message"]="�� � ���������";
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
	<meta name="Description" content="�������� RPG ������ ���� ����������� ���� � �����. ������ ������, �������� �������, ��� ����, ����� ���� ����� ������ � �����." />
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
		
		if (strlen($newpass)<6) {$ok=false;$mess='������. ������ �� ����� ���� ������ 6 ��������.';}
		if (strlen($newpass)>20) {$ok=false; $mess="������. ������ �� ����� ���� ������� 21 �������.";}
		if ($newpass!=$newpass2) {$ok=false;$mess='������. ������ �� ���������.';}
		if (trim($newpass)=='') {$ok=false;$mess='������. ����� ������ ������';}
		if ($oldpass!=base64_decode($db["password"])) {$ok=false;$mess="������. ������ ������ ������ �������.";}
		if ($ok) 
		{
			$date = date("d.m.Y H:i");
			mysql_query("UPDATE users SET password='".addslashes(base64_encode($newpass))."' WHERE login='".$login."'");
			history($login,"��� ������ ������",$date,$ip,"������");
            
			$subject  = "����� ������ � ��������� $login";

            $message  = "<b>�����������, $login!</b><br/><br/>";
            $message .= "���-�� � ip-������ <b>".$ip."</b> $date ��� ������ ������ � ��������� $login ��-���� ���� <b>WWW.MEYDAN.AZ</b>. <br/><br/>";
            $message .= "<b>����� ������</b>: $newpass<br/><br/><br/><br/>";
            $message .= "<b style='color:green'>� ���������. ������������� WWW.MEYDAN.AZ.</b>";
			
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=windows-1251' . "\r\n";
			$headers .= 'From: WWW.MEYDAN.AZ <admin@meydan.az>' . "\r\n";

			if (mail($db["email"], $subject, $message, $headers))
			{
				$mess.="<b style='color:#ff0000'>��������! ������ � ������� ����� ���������� �� ����� ��������� � ������ � ������� 5 �����.</b><br/>";
			} 
			else 
			{
				$mess.="<b style='color:#ff0000'>��������! �� ������� ��������� ������ �� e-mail, ��������� � ������!</b><br/>";
			}
			$mess.='����� ������ ��������.';
		}
	}
	if ($_POST['dochmail']) 
	{
		$old_mail=HtmlSpecialChars(addslashes(strtolower(trim($_POST['old_mail']))));
		$new_mail=HtmlSpecialChars(addslashes(strtolower(trim($_POST['new_mail']))));
		$ok=true;
		if (trim($new_mail)=='') {$ok=false;$mess='����� ������ �������� �����.';}
		if (!preg_match('#^[a-z0-9.!\#$%&\'*+-/=?^_`{|}~]+@([0-9.]+|([^\s]+\.+[a-z]{2,6}))$#si', $new_mail)){$ok=false;$mess="������. ������� ������ �������� �����.";}
		if ($old_mail!=$db["email"]) {$ok=false;$mess="������. ������ �������� ����� ������ �������.";}
		if ($ok) 
		{	
			$date = date("d.m.Y H:i");
			mysql_query("UPDATE info SET email='".$new_mail."' WHERE id_pers='".$db["id"]."'");
			history($login,"��� ������ E-mail",$date,$ip,"������");
			$mail = $db["email"];
            
			$subject  = "����� e-mail � ��������� $login";

            $message  = "<b>�����������, $login!</b><br/><br/>";
            $message .= "���-�� � ip-������ <b>$ip</b> $date ��� ������ e-mail, ��������� ��� ����������� ��������� <b>$login</b> ��-���� ���� <b>WWW.MEYDAN.AZ</b>.<br/>";
            $message .= "<br><b>����� e-mail</b>: $new_mail<br/><br/><br/><br/>";
            $message .= "<b style='color:green'>� ���������. ������������� WWW.MEYDAN.AZ.</b>";

			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=windows-1251' . "\r\n";
			$headers .= 'From: WWW.MEYDAN.AZ <admin@meydan.az>' . "\r\n";
			
			if (mail($db["email"], $subject, $message, $headers))
			{
				$mess.="<b style='color:#ff0000'>��������! ������ � ������� ����� ���������� �� ����� ��������� � ������ � ������� 5 �����.</b><br/>";
			} 
			else 
			{
				$mess.="<b style='color:#ff0000'>��������! �� ������� ��������� ������ �� e-mail, ��������� � ������!</b><br/>";
			}
			$mess.='�������� ����� ������� ������.';
		}
	}
	?>
	<div class="aheader">
		<b>������������</b><br/>
		<font color='#ff0000'><?=$mess;?></font>
	</div>
	<div>
		<form method="post">
		<b>������ ������:</b> 			<input name="oldpass" type="password" class="inup" size="20" maxlength="90" /><br/>
		<b>����� ������:</b> 			<input name="newpass" type="password" class="inup" size="20" maxlength="90" /><br/>
        <b>����� ������ (��� ���):</b> 	<input name="newpass2" type="password" class="inup" size="20" maxlength="90" /><br/>
		<br/><input name="dochpass" type="submit" class="inup" value="������� ������" /><br/><br/>

		<b>������ e-mail:</b> <input type="text" name="old_mail" class="inup" size="20" maxlength="90" /><br/>
		<b>����� e-mail:</b> <input type="text" name="new_mail" class="inup" size="20" maxlength="90" /><br/>
		<br/><input name="dochmail" type="submit" class="inup" value="������� email" /><br/><br/>
	</div>		
	<?mysql_close();?>
	<?include("bottom.php");?>
</div>