<?
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));	
$timer=(int)$_POST["timer"];
$end_time=time()+$timer*3600;
if($db["admin_level"]>=10)
{
	mysql_query("DELETE FROM ip_block WHERE end_time<".time());
	$q=mysql_query("SELECT * FROM users WHERE login='".$target."'");
	$res=mysql_fetch_array($q);
	if(!$res)
	{
		$msg="�������� <B>".$target."</B> �� ������ � ���� ������.";
	}
	else if ($res['adminsite']>=5)
	{
		$msg= "�������������� ����� ��������� ������ �����!";
	}
	else
	{
		$remote_ip=$res["remote_ip"];
		$last_ip=$res["last_ip"];
		$is_ip=mysql_fetch_array(mysql_query("SELECT count(*) FROM ip_block WHERE remote_ip='".$remote_ip."'"));
		if ($is_ip[0])$msg= "����� IP ��� ����������!";
		else
		{	
			mysql_Query("INSERT INTO ip_block (end_time,remote_ip,last_ip,user_id) VALUES ('".$end_time."','".$remote_ip."','".$last_ip."','".$res["id"]."')");
		    $msg= "IP-����� <b>\"".$remote_ip."\"</b> ������ ������������!";
			history($target,"������������ IP-�����","<b>\"".$ip_res."\"</b>",$ip,$login);
			history($login,"������������ IP-�����","<b>\"".$ip_res."\"</b>",$ip,$target);
		}
	}

	echo "<font color=red>".$msg."&nbsp;</font><br><br>";

	echo "<b>������ �������������� IP-�������:</b>";
	echo "<table border=0 class=new width=100% bgcolor=#dcdcdc cellspacing=1><TR bgcolor=#C7C7C7 style='font-weight:bold'>
	<td>IP-�����</td><td>���������</td><td>������������</td><td>��</td><td>��������</td></tr>";
	$sql=mysql_query("SELECT ip_block.id,ip_block.date,end_time, ip_block.remote_ip, ip_block.last_ip, users.login FROM ip_block LEFT JOIN users on users.id=ip_block.user_id ORDER BY date DESC ");
	if (!mysql_num_rows($sql))echo"<tr><td colspan=5 align=center><i style=color:red>������ ����</i></td></tr>";
	else
	{	
		while($row=mysql_fetch_Array($sql))
		{
			echo "<tr><td>".$row[3]."</td><td>".$row[4]."</td><td>".$row[1]."</td><td>".date('d.m.Y H:i', $row[2])."</td><td>".$row[5]."</td><tr>\n";
		}
	}
	echo "</table>";
}
?>