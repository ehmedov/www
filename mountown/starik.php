<?
include("key.php");
$login=$_SESSION['login'];
$ip=$db["remote_ip"];
if($_GET['action'] == "change")
{
	$S = mysql_query("SELECT wood.price, wood.name, count(*) as co FROM inv LEFT JOIN wood ON wood.id=inv.object_id WHERE inv.owner='".$login."' and inv.object_type='wood' and object_id in (142,143,144,145,146,147,148,149,150) GROUP BY object_id");
	if (!mysql_num_rows($S))$mess='<font color=red>�����</font><BR>';
	else
	{
		$price=0;
		$mess="<b style=color:red>�� ������ �����:</b><br>";
		while($DAT = mysql_fetch_assoc($S))
		{
			$price=$DAT["co"]*$DAT["price"];
			$mess.="<b>".$DAT["name"]."</b>-".$DAT["co"]." ��. �� $price ��. ";
			$price_all+=$price;
		}
		$mess.="<br><br>";
		mysql_query("UPDATE users SET silver=silver+$price_all WHERE login='".$login."'");
		mysql_query("DELETE FROM inv WHERE owner='".$login."' and object_type='wood' and object_id in (142,143,144,145,146,147,148,149,150)");
		history($login,"�� ������ �����",$mess,$db["remote_ip"],"������ �������");
	}
}
?>
<script>
function talk(phrase)
{
	if(phrase==1)
	{
		bernard.innerHTML='<B>������ �������:</B><BR>'+
		'- �� �� ������� ���! �������, � ���� �������, �, ��� ����� ���������� - � ���� ����������!<br/><br/><br/>'+
		'<a href="javascript:talk(6)" class=us2><B>- �����-�� �� ��������. ������ ����� ����!...</B></a><BR>'+	
		'<a href="javascript:dialog()" class=us2><B>- ����������...</B></a><BR>'+
		'<a href="javascript:talk(3)" class=us2><B>- � ������ ������ ������� ����������. (��������� ��������)</B></a>';
	}
	if(phrase==2)
	{
		bernard.innerHTML='<B>������ �������:</B><BR>- � ����� ������ �� �� �������[��.]... ��������?<BR><BR>'+
		'<a href="javascript:talk(4)" class=us2><B>- ��������...</B></a><BR>'+	
		'<a href="javascript:dialog()" class=us2><B>- �������, ��� ����! ������ ������ ������...</B></a><BR>'+
		'<a href="javascript:talk(3)" class=us2><B>- �������� �� ������������...(��������� ��������)</B></a>';
	}
	if(phrase==3)
	{
		document.location.href='?act=go&level=izumrud_floor';
	}
	if(phrase==4)
	{
		document.location.href='?action=change';
	}
	if(phrase==5)
	{
		document.location.href='?act=none';
	}
	if(phrase==6)
	{
		bernard.innerHTML='<B>������ �������:</B><BR>'+
		'- ����� ������ ��������� ������ ���� � �� �� �������, ��� ���� ������ ����� ������� �� ����. � ���� �� � - ���� �� ������ ���������, ������� ���� ��������� ���� ��������� ��������� � ������� � ������, �� �������� ������-���� ���������.<br/><br/>'+ 
		'���� �� ������������ ����� ��� ����� ������������� ���������� - ����� ��������, �� � �� ���� �������. ������ ���, ������ ��� ���� � �� �� �������...<br/><br/><br/>'+
		'<a href="javascript:dialog()" class=us2><B>- ������� ���. ������ ����....</B></a><BR>'+
		'<a href="javascript:talk(3)" class=us2><B>- �������� �� ������������...(��������� ��������)</B></a>';
	}
}
function dialog()
{
	var changed='<?=$mess?>';
	if (changed=='')
	{
		bernard.innerHTML='<B>������ �������:</B><BR>'+
		'- ��� ���� ����������! �� �� ������ �����������!<BR><BR>'+
		'<a href="javascript:talk(1)" class=us2><B>- � �� ���?</B></a><BR>';
	}
	else 
	{
		bernard.innerHTML=changed+
		'<a href="javascript:talk(5)" class=us2><B>- ����������...</B></a><BR>';
	}
	
	bernard.innerHTML+=
	'<a href="javascript:talk(2)" class=us2><B>- � ��� ����������� ����� �����, ���� ��� �������� �� �����?</B></a><BR>'+	
	'<a href="javascript:talk(3)" class=us2><B>- �� ���� ���������� ��� ����� ������������. (��������� ��������)</B></a>';
}

</script>

<SCRIPT language="JavaScript" type="text/javascript" src="fight.js"></SCRIPT>
<h3>������ � "������ �������"</h3>
<table width=100% border=0>
<tr>
	<td width=210 valign=top>
		<?
			showHPbattle($db);
			showPlayer($db);
		?>
	</td>
	<td valign=top><br>
		<table border=0 width=500 cellpadding=1 cellspacing=1 align=left><tr><td>
			<div id='bernard'></div>
			<script>dialog();</script>
		</td></tr></table>
	</td>
	<td width=210 valign=top>
		<?
		$result=mysql_query("SELECT * FROM users WHERE login='������ �������' limit 1");
		$bot=mysql_fetch_Array($result);
		mysql_free_result($result);
		showHPbattle($bot);
		showPlayer($bot);
		?>
	</td>
</tr>
</table>