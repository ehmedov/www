<?
include ('key.php');
ob_start("ob_gzhandler");
include ("conf.php");
$login=$_SESSION['login'];
header("Content-type: text/html; charset=windows-1251");
header("Cache-Control: no-cache, must-revalidate"); // ������� �������� ���-�� �� �� ��������� ��� ��������
header("Pragma: no-cache");
$data = mysql_connect($base_name, $base_user, $base_pass) or die('�� ���������� ������������. ��������� ��� �������, ��� ������������ � ������!');
mysql_select_db($db_name) or die('������ ����� � ���� ������');
echo '<?xml version="1.0" encoding="windows-1251"?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.2//EN" "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="en">';
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
##==========================================================================================
function ref_sign() 
{
	$params = func_get_args();
	$prehash = implode("::", $params);
	return md5($prehash);
}

// the function prints a request form
// ������� �������� ����� �������
function print_form($purse, $order_id, $amount, $clear_amount, $description, $secret_code, $submit) 
{
	// making signature
	// ������� �������
	$sign = ref_sign($purse, $order_id, $amount, $clear_amount, $description, $secret_code);
	
	echo '<form action="http://service.smscoin.com/bank/" method="post">
			<input name="s_purse" type="hidden" value="'.$purse.'" />
			<input name="s_order_id" type="hidden" value="'.$order_id.'" />
			<input name="s_amount" type="hidden" value="'.$amount.'" />
			<input name="s_clear_amount" type="hidden" value="'.$clear_amount.'" />
			<input name="s_description" type="hidden" value="'.$description.'" />
			<input name="s_sign" type="hidden" value="'.$sign.'" />
			<input type="submit" class="inup" value="'.$submit.'" />
		</form>';
}
##==========================================================================================

$db = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE login='".$login."'"));
if ($db)
{
	echo "<div class=\"aheader\">";
	echo "<b>������� ������� (��.) ������ �� ����� ���������� ��������.</b><br/>
	<div class=\"sep2\"></div>	
	������ �� ������� ����� ������� � ������� ����� ������ ���������� ��������.<br/>";
	if ($bonus)echo "<font color='#ff0000'>��������! �����! ��� ������� ������� - � ������� ������������� <b>".$bonus."%</b> �� ����� �������!</font><br/><br/>";
	echo "<br><br>";
	##===========================================================
	if (is_numeric($_POST["bankid"]))
	{
		$bank_id=$_POST["bankid"];
		$have_bank_id=mysql_fetch_Array(mysql_query("SELECT number FROM bank WHERE login='".$login."' and number=".$bank_id));
		if ($have_bank_id)
		{
			$_SESSION["bank_id"]=$bank_id;
			switch ($_POST["amount"])
			{
				case 1:$_SESSION["amount"]=0.1;break;
				case 2:$_SESSION["amount"]=2;break;
				case 5:$_SESSION["amount"]=5;break;
				default :$_SESSION["amount"]=2;break;
			}
		}
		else echo "<font color='#ff0000'>���� <b>".$bank_id."</b> �� ���������� ��� �� �� ������ �� ������������!</font>";
	}
	##===========================================================
	if ($_GET["destroy"])$_SESSION["bank_id"]="";
	##===========================================================
	if ($_SESSION["bank_id"])
	{
		echo "<b>���� �:</b> ".$_SESSION["bank_id"]." <a href='?destroy=1'>������� ����</a><br/>
		����� ����������: <b>".$_SESSION["amount"].".00AZN</b><br/>";
		echo "<b>�� ��������: ".$_SESSION["amount"].".00 AZN = ".($_SESSION["amount"]*10).".00��.".($bonus?" [ + ".($_SESSION["amount"]*10*$bonus/100).".00��. �����] =<font color='#ff0000'>".($_SESSION["amount"]*10*(1+$bonus/100)).".00��.</font>":"")."</b><br/>";
		##===========================================================
		// service secret code
		// ��������� ��� �������
		$secret_code = "meydan_secret";
		
		// initializing variables
		// �������������� ����������
		$purse        = 12946;              // sms:bank id        ������������� ���:�����
		$order_id     = $_SESSION["bank_id"];           // operation id       ������������� ��������
		$amount       = $_SESSION["amount"];            // transaction sum    ����� ����������
		$clear_amount = 0;              // billing algorithm  �������� �������� ���������
		$description  = "SMS PAYMENT SYSTEM"; // operation desc     �������� ��������
		$submit       = "������� �������";    // submit label       ������� �� ������ submit
		
		// printing the form
		// �������� �����
		print_form($purse, $order_id, $amount, $clear_amount, $description, $secret_code, $submit);
		##===========================================================
	}
	else
	{
		$nomer = mysql_query("SELECT number FROM bank WHERE login='".$login."'");
		if (mysql_num_rows($nomer))
		{
			echo "
			<form action='smscoin.php' method='post'>
				<b>���������� ������</b><br/>
				<b>����� �����:</b>
				<select name='bankid' style='width:100'>";
				for ($i=0; $i<mysql_num_rows($nomer);$i++)
				{
					$num=mysql_fetch_array($nomer);
					echo "<option value=".$num['number'].">".$num['number']."</option>";
				}
				echo "</select> 
				<select name='amount'>
					<option value='2'>2 AZN</option>
					<option value='5'>5 AZN</option>
				</select>
				<br/><input type='submit' class='inup' value='������� ����' />
			</form>";
		}
	}
	echo "</div><br/>";
}
mysql_close();
?>
<?include("bottom.php");?>
</div>
</html>