<?
include('key.php');
ob_start("ob_gzhandler");
include ("conf.php");
$login=$_SESSION['login'];

header("Content-Type: text/html; charset=windows-1251");
Header("Cache-Control: no-cache, must-revalidate"); // говорим браузеру что-бы он не кешировал эту страницу
Header("Pragma: no-cache");

$data = mysql_connect($base_name, $base_user, $base_pass) or die('Не получается подключиться. Проверьте имя сервера, имя пользователя и пароль!');
mysql_select_db($db_name) or die('Ошибка входа в базу данных');


##==========================================================================================
function ref_sign() 
{
	$params = func_get_args();
	$prehash = implode("::", $params);
	return md5($prehash);
}

// the function prints a request form
// функция печатает форму запроса
function print_form($purse, $order_id, $amount, $clear_amount, $description, $secret_code, $submit) 
{
	// making signature
	// создаем подпись
	$sign = ref_sign($purse, $order_id, $amount, $clear_amount, $description, $secret_code);
	
	echo '<form action="http://service.smscoin.com/bank/" method="post">
			<input name="s_purse" type="hidden" value="'.$purse.'" />
			<input name="s_order_id" type="hidden" value="'.$order_id.'" />
			<input name="s_amount" type="hidden" value="'.$amount.'" />
			<input name="s_clear_amount" type="hidden" value="'.$clear_amount.'" />
			<input name="s_description" type="hidden" value="'.$description.'" />
			<input name="s_sign" type="hidden" value="'.$sign.'" />
			<input type="submit" style="background-color:#AA0000; color: white;" value="'.$submit.'" />
		</form>';
}
##==========================================================================================

?>
<html>
<head>	
	<title>WWW.MEYDAN.AZ - Отличная RPG онлайн игра посвященная боям и магии</title>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<meta http-equiv="Content-Language" content="ru">
	<meta http-equiv="cache-control" Content="no-cache, max-age=0, must-revalidate, no-store">
	<meta http-equiv="pragma" content=no-cache>
	<meta http-equiv="expires" content=0>	
	<link rel=stylesheet href='main.css' type='text/css'>
	<style>
		.bgrright {background: url("img/design/brg-top-right-1-blank.gif") repeat-x top left}
		.bgrleft  {background: url("img/design/brg-top-left-1-blank.gif") repeat-x top right}
		.bgrdown  {background: url("img/design/down-bgr-blank.gif") repeat-x top right}
	</style>
</head>
<body bgcolor="#392F2D" background="img/design/bgr.gif" link="#FFD175" vlink="#FFD175" alink="white" leftmargin=0 topmargin=0 rightmargin=0 bottommargin=0 marginwidth=0 marginheight=0>
<table cellspacing=0 cellpadding=0 border=0 width=100% align=center>
<tr>
<td>
	<table cellspacing=0 cellpadding=0 border=0 width="100%">
	<tr valign=top>
		<td class="bgrleft" width=50%><img src="img/design/top-left-blank.gif" hspace=0 vspace=0 border=0></td>
		<td width=302><img src="img/design/top-balls_inf.gif" hspace=0 vspace=0 border=0></td>
		<td class="bgrright" width="100%" align="right"><img src="img/design/top-right-blank.gif" hspace=0 vspace=0 border=0></td>
	</tr>
	</table>
	<table cellspacing=0 cellpadding=0 border=0 width="100%">
	<tr>
		<td background="img/design/left-bgr-blank.gif"><img src="img/design/dot.gif" width=10 height=1 hspace=0 vspace=0 border=0></td>
		<td width=100% background="img/design/bgr.jpg">
			<?
				$db = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE login='".$login."'"));
				if ($db)
				{
					echo "
					<br/><br/><br/>
					<h3>Покупка Платины (Пл.) Оплата со счета мобильного телефона.</h3>
					<center>Оплата за покупку будет списана с баланса счета Вашего мобильного телефона.<br>";
					if ($bonus)echo "<font color=red>Внимание! Акция! При покупке Платины - в подарок дополнительно <b>".$bonus."%</b> от суммы покупки!</font><br><br>";
					echo "<br><br>";
					##===========================================================
					if ($_POST["bankid"])
					{
						$bank_id=(int)$_POST["bankid"];
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
						else echo "<font color=red>Счет <b>".$bank_id."</b> не существует или Вы не можете им пользоваться!</font>";
					}
					##===========================================================
					if ($_GET["destroy"])$_SESSION["bank_id"]="";
					##===========================================================
					if ($_SESSION["bank_id"])
					{
						echo "<b>Счёт №:</b> ".$_SESSION["bank_id"]." <a href='?destroy=1'>Сменить счёт</a><br>
						Сумма транзакции: <b>".$_SESSION["amount"].".00AZN</b><br>";
						echo "<b>Вы получите: ".$_SESSION["amount"].".00 AZN = ".($_SESSION["amount"]*10).".00Пл.".($bonus?" [ + ".($_SESSION["amount"]*10*$bonus/100).".00Пл. Бонус] =<font color=red>".($_SESSION["amount"]*10*(1+$bonus/100)).".00Пл.</font>":"")."</b><br>";
						##===========================================================
						// service secret code
						// секретный код сервиса
						$secret_code = "meydan_secret";
						
						// initializing variables
						// инициализируем переменные
						$purse        = 12946;              // sms:bank id        идентификатор смс:банка
						$order_id     = $_SESSION["bank_id"];           // operation id       идентификатор операции
						$amount       = $_SESSION["amount"];            // transaction sum    сумма транзакции
						$clear_amount = 0;              // billing algorithm  алгоритм подсчета стоимости
						$description  = "SMS PAYMENT SYSTEM"; // operation desc     описание операции
						$submit       = "Покупка Платины";    // submit label       надпись на кнопке submit
						
						// printing the form
						// печатаем форму
						print_form($purse, $order_id, $amount, $clear_amount, $description, $secret_code, $submit);
						##===========================================================
					}
					else
					{
						$nomer = mysql_query("SELECT number FROM bank WHERE login='".$login."'");
						if (mysql_num_rows($nomer))
						{
							echo "<FORM ACTION='smscoin.php' METHOD='POST'>
							<fieldset style='width:500px;'>
							<legend><b>Управление счетом №</b></legend>
							<table border=0 cellpadding=1 cellspacing=3 align=center>
							<tr>
								<td>Номер счета: </td>
								<td>
									<select name='bankid' style='width:100'>";
									for ($i=0; $i<mysql_num_rows($nomer);$i++)
									{
										$num=mysql_fetch_array($nomer);
										echo "<option value=".$num['number'].">".$num['number'];
									}
									echo "</select> 
									<select name='amount'>
										<option value=2>2 AZN</option>
										<option value=5>5 AZN</option>
									</select>
								</td>
								<td><INPUT TYPE='submit' VALUE='Выбрать Счет'></td>
							</tr>
							</table>
							</FIELDSET></FORM>";
						}
					}
				}
				mysql_close();
				?>
		</td>
		<td background="img/design/right-bgr-blank.gif"><img src="img/design/dot.gif" width=10 height=1 hspace=0 vspace=0 border=0></td>
	</tr>
</table>
<table cellspacing=0 cellpadding=0 border=0 width="100%" height=55 class="bgrdown">
	<tr valign=top>
		<td><img src="img/design/down-left-blank.gif" width=34 height=25 hspace=0 vspace=0 border=0></td>
		<td width=100%></td>
		<td><img src="img/design/down-right-blank.gif" width=34 height=25 hspace=0 vspace=0 border=0></td>
	</tr>
</table>
</body>
</HTML>