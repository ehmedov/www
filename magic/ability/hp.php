<?$login=$_SESSION['login'];
$spell=(int)$_GET['spell'];
$hp_add = 10000;
$magic_name=$a["name"];
if($db["battle"]!=0)
{
	say($login, "� ��� ������������ ������� ���������!", $login);
}
else 
{
	$hp_now = $db["hp"];
	$hp_all = $db["hp_all"];

	if($hp_all - $hp_now==0)
	{
		$errmsg="�� � ��� �������...";
	}
	else 
	{
		if($hp_all - $hp_now<$hp_add)
		{
			$hp_add = $hp_all - $hp_now;
		}
		$hp_new = $hp_now + $hp_add;
		setHP($login,$hp_new,$hp_all);
		$errmsg="�� ������ ������������ ���������� <b>&laquo;$magic_name&raquo;</b> � ������������ ���� �������� �� <b>$hp_add HP</b>!";
		mysql_query("UPDATE abils SET c_iznos=c_iznos+1 WHERE item_id = '".$spell."' and tribe='".$db[clan]."'");
	}
}
?>
