<?
session_start();
$login=$_SESSION['login'];
$spell=$_GET['spell'];
$target=htmlspecialchars(addslashes($_REQUEST['target']));

$res=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE login='".$target."'"));
if(!$res)
{
	$_SESSION["message"]="�������� ".$target." �� ������.";
}
else if($res["battle"])
{
	$_SESSION["message"]="�������� ".$target." � ���...";
}
else
{	
	if($res["travm"]!=0)
	{
		$t_stat = $res["travm_stat"];
		$o_stat = $res["travm_old_stat"];
	    mysql_query("UPDATE users SET $t_stat=$t_stat+$o_stat,travm='0', travm_stat='', travm_var=0, travm_old_stat=0 WHERE login='".$res["login"]."'");
		$_SESSION["message"]="�� ������ ������������ ���������� �� ��������� ".$res["login"].". ������ ��������.";
		say("toall_news","���� <b>".$db["login"]."</b> ������� ��������� <b>".$res["login"]."</b> <img src=../img/index/travma.gif>",$login);
		drop($spell,$DATA);
		if ($res["id"]!=$db["id"])mysql_query("UPDATE daily_kwest SET taked=taked+1 WHERE user_id='".$db['id']."' and kwest_id=8");//daily kwest
	}
	else
	{
		$_SESSION["message"]="�������� ".$res["login"]." �� �����������!!!";
	}
}
echo "<script>location.href='main.php?act=inv&otdel=magic'</script>";
?>
