<?
session_start();
$login=$_SESSION['login'];
if($db["travm"]!=0)
{
	$t_stat = $db["travm_stat"];
	$o_stat = $db["travm_old_stat"];
    mysql_query("UPDATE users SET $t_stat=$t_stat+$o_stat,travm='0', travm_stat='', travm_var=0, travm_old_stat=0 WHERE login='".$db["login"]."'");
	$_SESSION["message"]="�� ������ ������������ ���������� <b>&laquo;".$name."&raquo;</b>. ������ ��������.";
	drop($spell,$DATA);
}
else
{
	$_SESSION["message"]="�� �� ������������...";
}
?>