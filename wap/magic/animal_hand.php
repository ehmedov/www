<?
$login=$_SESSION['login'];
$spell=$_GET['spell'];

$add_time=time()+24*60*60;

$paltar=mysql_fetch_array(mysql_query("SELECT * FROM zver WHERE owner='".$db["id"]."' and sleep=0"));
if (!$paltar)
{
	$_SESSION["message"]="� ��� ���� �����...";
}
else
{
	mysql_query("UPDATE zver SET two_hands=$add_time WHERE owner=".$db['id']);
	$_SESSION["message"]="����� ���� ���������...";
	drop($spell,$DATA);
}
?>