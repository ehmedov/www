<?
include('key.php');
$login=$_SESSION["login"];
$target=htmlspecialchars(addslashes($_POST['target']));
if ($_POST['summa_n'])
{
	if (!is_numeric($_POST['summa_n']) || ($_POST['summa_n']<=0))
	{
		$msgErr="����������� ������� �����!";
	}
	if ($db["peredacha"]>=50) 
	{
		$msgErr="��� ����� ������� ��������";
	}
	else if ($db["money"]<$_POST['summa_n'])
	{
		$msgErr= "� ��� ��� ����� �����... (".$_POST['summa_n']." ��.)";
	}
	else 
	{
		$bank_sum =$_POST['summa_n'];
		mysql_query("UPDATE `clan` SET kazna=kazna+$bank_sum WHERE name_short = '".$clan_s."'");
		mysql_query("UPDATE `users` SET money=money-$bank_sum, peredacha=peredacha+1 WHERE login = '".$login."'");
		$msgErr="�� ������ �������� <b>$bank_sum ��.</b> � ����� �����";
		history($login,'�������� � � �����',$_POST['summa_n']." ��.",$ip,'����� �����');
		op($login,$msgErr,$clan_s);
	}
}
else if ($_POST['summa_a'])
{
	if (!is_numeric($_POST['summa_a']) || ($_POST['summa_a']<=0))
	{
		$msgErr="����������� ������� �����!";
	}
	else if ($SITED["kazna"]<$_POST['summa_a'])
	{
		$msgErr= "� ����� ��� ����� �����... (".$_POST['summa_a']." ��.)";
	}
	else if(!$db["glava"])
	{
		$msgErr= "������ <b>����� �����</b> ����� ����� ������ � ��������� �����...";
	}
	else 
	{
		$bank_sum = $_POST['summa_a'];
		mysql_query("UPDATE `clan` SET kazna=kazna-$bank_sum WHERE name_short = '".$clan_s."'");
		mysql_query("UPDATE `users` SET money=money+$bank_sum WHERE login = '".$login."'");
		$msgErr="�� ������ ����� <b>$bank_sum ��.</b> �� ����� �����";
		history($login,'���� �� �����',$bank_sum." ��.",$ip,'����� �����');
		op($login,$msgErr,$clan_s);
	}
}
else if ($_POST['bank_id'] && $_POST['deneg_n'] && $_POST['comment'])
{
	if (!is_numeric($_POST['deneg_n']) || ($_POST['deneg_n']<=0))
	{
		$msgErr="����������� ������� �����!";
	}
	else if ($SITED["kazna"]<$_POST['deneg_n'])
	{
		$msgErr= "� ����� ��� ����� �����... (".$_POST['deneg_n']." ��.)";
	}
	else if(!$db["glava"])
	{
		$msgErr= "������ <b>����� �����</b> ������ ���������� ������ � ��������� �����...";
	}
	else 
	{
		$number=(int)$_POST['bank_id'];
		$bank=mysql_fetch_array(mysql_query("SELECT * FROM users,(SELECT number,login FROM bank WHERE number=$number LIMIT 1) as b WHERE users.login=b.login and users.clan_short='$clan_s' LIMIT 1"));
		if ($bank)
		{
			$bank_sum = $_POST['deneg_n'];
			$comment=htmlspecialchars(addslashes($_POST['comment']));
			mysql_query("UPDATE `clan` SET kazna=kazna-$bank_sum WHERE name_short = '".$clan_s."'");
			mysql_query("UPDATE `bank` SET money=money+$bank_sum WHERE number = $number");
			$msgErr="�� ������ �������� <b>$bank_sum ��.</b> �� ����� ����� �� ���� <b>$number</b> � <b>$bank[login]</b>...";
			history($login,'������� �� �����',$msgErr."- ����������-$comment",$ip,'����� �����');
			op($login,$msgErr,$clan_s);
		}
		else $msgErr= "�������� ������...";
	}
}

echo "<font color=#ff0000>".$msgErr."</font>&nbsp;";
?>
<body onLoad='top.cf.action=1;' onUnload='top.cf.action=0;'>
<form name='action' method="POST" action="main.php?act=clan&do=4">
	<b>������� ����� ������� ������ �������� � �����.</b><br>
	�����: <input type="text" name="summa_n" size="20" value="0" maxlength=3> <input type="submit" value=">>" name="action">
</form>
<form name='action' method="POST" action="main.php?act=clan&do=4">
	<b>������� ����� ������� ������ ����� � �����.</b><br>
	�����: <input type="text" name="summa_a" size="20" value="0" maxlength=3> <input type="submit" value=">>" name="action">
</form>
<form name='action' method="POST" action="main.php?act=clan&do=4">
	<b>��������� �� ������ ����...</b><br>
    <table>
    <tr>
    	<td>����� �����: </td><td><input type="text" name="bank_id" size="20"></td>
   	</tr>
	<tr>
		<td>�����: </td><td><input type="text" name="deneg_n" size="20" value="0" maxlength=3></td>
	</tr>
	<tr>
		<td>����������: </td><td><input type="text" name="comment" size="20"> <input type="submit" value=">>" name="action"></td>
	</tr>
	</table>
</form>
