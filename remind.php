<?
	HEADER("Content-type: text/html; charset=windows-1251");
	Header("Cache-Control: no-cache, must-revalidate"); // ������� �������� ���-�� �� �� ��������� ��� ��������
	Header("Pragma: no-cache");
	include "conf.php";
	$data = @mysql_connect($base_name, $base_user, $base_pass) or die('�� ���������� ������������. ��������� ��� �������, ��� ������������ � ������!');
	mysql_select_db($db_name) or die('������ ����� � ���� ������');
	$ip=getenv('REMOTE_ADDR');
?>
<html>
<HEAD>	
	<title>WWW.Oldmeydan.pe.hu - [�������������� �������� ������]</title>
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
     		$msg="�������� <u>".$login."</u> �� ������ � ���� ������!";
    	}
    	else if($db["email"]!=$mymail)
    	{
    		$msg="�������� ����� ������ �������.";
    	}
    	else if($db["birth"]!=$birth)
    	{
    		$msg="���� �������� ������ �������.";
    	}	
    	else 
    	{
    		$login_full=$db["login"];
			$pass = base64_decode($db["password"]);
			
			$subject="WWW.Oldmeydan.pe.hu. ������ ��� ��������� $login_full";
			
			$message = "<center><b style='color:#ff0000;font-size:15px'>WWW.Oldmeydan.pe.hu - �������� RPG ������ ���� ����������� ���� � �����. ������ ������, �������� �������, ��� ����, ����� ���� ����� ������ � �����.</b></center><br><br>";
			$message .= "<b>�����������!</b><br><br>";
			$message .= "���-�� � ip-������ <b>$ip</b> �������� ������ � ��������� <b style='color:green;font-size:12px'>$login_full</b> ��-���� ���� <a href='http://www.Oldmeydan.pe.hu'><b>WWW.Oldmeydan.pe.hu</b></a>.<br>";
			$message .= "��� ��� � ������ ��������� <b style='color:green;font-size:12px'>$login_full</b> ������ ���� e-mail, ������� ������� ������.<br><br>";
			$message .= "<b>��������:</b>  $login_full<br>";
			$message .= "<b>������:</b>    $pass<br><br>";
			$message .= "<i>(��� ������ ������������� �������������, �� ���� �� ���� ��������!)</i><br><br>";
			$message .= "<div align=right style='color:green;font-weight:bold'>������������� WWW.Oldmeydan.pe.hu.</div></font>";
			
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=windows-1251' . "\r\n";
			$headers .= 'From: WWW.Oldmeydan.pe.hu <admin@Oldmeydan.pe.hu>' . "\r\n";
			
			if (mail($db["email"], $subject, $message, $headers))
			{
				$msg="��������! ������ � ������� ����� ���������� �� ����� ��������� � ������ � ������� 5 �����.";
			} 
			else 
			{
				$msg="��������! �� ������� ��������� ������ �� e-mail, ��������� � ������!";
			}
		}
	}
	?>
		<h3>�������������� �������� ������</h3>
		<form action="remind.php" name="pass" method="POST">
		<table align=center>
			<tr><td colspan=3><b style='color:red'><?=$msg?>&nbsp;</td></tr>
			<tr><td align=right><b>�����:</td><td colspan=2><input type=text size=25 name="login"></td></tr>
			<tr><td align=right><b>Email:</td><td colspan=2><input type=text size=25 name="mail"></td></tr>
			<tr><td align=right>
			<b>����:</b>
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
			<b>�����:</b>
			<select name="month" class="inup">
				<option value="01" selected="selected">������</option>
				<option value="02">�������</option>
				<option value="03">����</option>
				<option value="04">������</option>
				<option value="05">���</option>
				<option value="06">����</option>
				<option value="07">����</option>
				<option value="08">������</option>
				<option value="09">��������</option>
				<option value="10">�������</option>
				<option value="11">������</option>
				<option value="12">�������</option>
			</select>
			</td>
			<td>
			<b>���:</b>
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
			<tr><td colspan=3 align='center'><input type='submit' style='cursor:hand' value="������� ������"></td></tr>
		</table>
		</form>
		</html>