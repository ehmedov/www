<?
$login=$_SESSION['login'];
$spell=$_GET['spell'];

switch ($mtype) 
{
	case "mn100": $mana_add = 100;break;
	case "mn250": $mana_add = 250;break;
}
if($db["battle"]!=0)
{
	say($login, "�� �� ������ ��������� ��� �������� �������� � ���!", $login);
}
else 
{
	$mana_now = $db["mana"];
	$mana_all = $db["mana_all"];

	if($mana_all - $mana_now==0)
	{
		$_SESSION["message"]="�� � ��� �������.";
	}
	else 
	{
		if($mana_all - $mana_now<$mana_add)
		{
			$mana_add = $mana_all - $mana_now;
		}
		$mana_new = $mana_now + $mana_add;
		setMN($login,$mana_new,$mana_all);
		$_SESSION["message"]="�� ������ ������������ ���������� <b>&laquo;".$name."&raquo;</b> � ������������ ���� ���� �� <b>$mana_add MN</b>!";
		drop($spell,$DATA);
	}
}
echo "<script>location.href='main.php?act=inv&otdel=magic'</script>";
?>
