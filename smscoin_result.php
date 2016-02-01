<?
include ("conf.php");
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
	
foreach($_REQUEST as $request_key => $request_value) 
{ 
	$_REQUEST[$request_key] = substr(strip_tags(trim($request_value)), 0, 250);
}
$secret_code = "meydan_secret";
$purse        = $_REQUEST["s_purse"];        // sms:bank id        идентификатор смс:банка
$order_id     = $_REQUEST["s_order_id"];     // operation id       идентификатор операции
$amount       = $_REQUEST["s_amount"];       // transaction sum    сумма транзакции
$clear_amount = $_REQUEST["s_clear_amount"]; // billing algorithm  алгоритм подсчета стоимости
$inv          = $_REQUEST["s_inv"];          // operation number   номер операции
$phone        = $_REQUEST["s_phone"];        // phone number       номер телефона
$sign         = $_REQUEST["s_sign_v2"];      // signature          подпись
	
$reference = ref_sign($secret_code, $purse, $order_id, $amount, $clear_amount, $inv, $phone);
$have_bank=mysql_fetch_Array(mysql_Query("SELECT users.id, users.login FROM bank LEFT JOIN users on users.login=bank.login WHERE number=".(int)$order_id));
if ($have_bank)
{
	if($sign == $reference) 
	{
		$add_platin=$amount*10*(1+$bonus/100);
		$txt="Удачно переведены <b>$add_platin Пл.</b>".($bonus?" (Бонус:".$bonus."%)":"")." на счет номер ".$order_id.". Удачной игры, мы работаем для Вас!";
		mysql_query("UPDATE bank SET emoney=emoney+$add_platin WHERE number=".$order_id);
		mysql_query("INSERT INTO smscoin(user_id, bank_id, platina, bonus, s_inv, s_phone, amount) VALUES ('".$have_bank["id"]."', '$order_id', '$add_platin', '$bonus', '$inv', '$phone','$amount')");
		mysql_query("INSERT INTO pochta(user, whom, text, subject) VALUES ('Путешественник','".$have_bank["login"]."','".$txt."','Покупка Платины')");
	}
	else 
	{
		mysql_query("INSERT INTO smscoin(user_id, bank_id, platina, bonus, s_inv, s_phone, amount) VALUES ('".$have_bank["id"]."', '$order_id', '0', '$bonus', '$inv', '$phone', '$amount')");
	}
}
mysql_close();
?>