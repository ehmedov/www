<?include('key.php');
$login=$_SESSION["login"];
if($db["glava"]==1)
{
	if ($_POST['action'])
	{
		if ($db['platina']>=200)
		{	
			$or_d=(int)$_POST['orden'];
			mysql_query("UPDATE clan SET orden=$or_d WHERE name_short = '".$clan_s."'");
			mysql_query("UPDATE users SET orden=$or_d WHERE clan_short = '".$clan_s."'");
			mysql_query("UPDATE users SET platina=platina-200 WHERE login='".$login."'");
			history($login,'������� ���������',"200 ��.",$ip,'�������� �������');
			echo "�� ������ �������� ����������!";
		}
		else echo "� ��� ��� ����� ����� - 200 ��.";
	}
}
?>
<form name='sklonnost' action='main.php?act=clan&do=2&a=change_sclon' method='post'>
<table>
<TR>
	<TD>���������� �����:</TD>
	<TD>
		<select name="orden">
			<option value="2">������� - 200 �������
			<option value="3">����� ���������� - 200 �������
			<option value="4">����� ����� - 200 �������
		</select>
	</TD>
</TR>
<tr><td colspan=2><input type="submit" value="�������" name="action"></td></tr>
</table>
</form>