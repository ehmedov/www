<?
include('key.php');
$login=$_SESSION["login"];
?>
<h3>��������� �������</h3>
<form name='slform' action='main.php?act=clan&do=2&a=zam' method='POST'>
<table border=0>
<tr valign=top>
	<td>
		<b>������� ���:</b>	<input type=text name="target" class=new size=30>
		<input type=submit value="���������">
	</td>
</tr>
</table>
</form>
<script>Hint3Name = 'target';</script>
<?
if($_POST["target"])
{	
	$target=htmlspecialchars(addslashes($_POST['target']));
	if($db["glava"]==1)
	{
		$q=mysql_query("SELECT * FROM users WHERE login='".$target."'");
		$res=mysql_fetch_array($q);
		if(!$res)
		{
			echo "�������� <B>".$target."</B> �� ������ � ���� ������.";
		}
		else if($res["id"]==$db["id"])
		{
			echo "����� �� ����� �������� ���� �������...";
		}	
		else if($res["clan_short"]!=$clan_s)
		{
			echo "�������� <B>".$target."</B> �� ������� � ����� �����";
		}
		else
		{
			$counts=mysql_fetch_array(mysql_query("SELECT count(*) FROM users WHERE clan_short='".$clan_s."' and clan_take=1 and glava=0"));
			if ($counts[0]>3)
			{
				echo " �������� 3 ������";
			}	
			else
			{
				mysql_query("UPDATE users SET clan_take=1, chin='������', glava=0 WHERE login='".$res["login"]."'");
				echo "�������� <b>".$res["login"]."</b> �������� �������.";
			}
		}
	}
}
?>