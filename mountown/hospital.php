<?include("key.php");
$login=$_SESSION['login'];
$text="";
$ip=$db["remote_ip"];
if($_GET['emeliyyat'] == "cure")
{
	if($db["travm"]!=0)
	{
		$t = $db["travm_var"];
		$trmoney = array();
		$trmoney[1]=5;
		$trmoney[2]=10;
		$trmoney[3]=15;
		$price=$trmoney[$t];
		if($db["orden"]==1){$price = 0;}
		if($db["money"] >= $price)
		{
			$t_stat = $db["travm_stat"];
			$o_stat = $db["travm_old_stat"];
			$travma = mysql_query("UPDATE users SET $t_stat=$t_stat+$o_stat,travm='0',money=money-$price, travm_stat='', travm_var='', travm_old_stat='' WHERE login='".$login."'");
			$msg="������� ������� ���� ������ �� $price ��.";
			$name2="$price ��.";
			$db["travm_var"]='';
			$db["travm"]=0;
			history($login,'��������� �� ������',$name2,$ip,'��������');
		}
		else
		{
			$msg="� ��� ������������ �����, ��� �� �������� ������ ��������.";
		}
	}
	else $msg="��������, �� � ��� ��� ������ ������, �� ��������� �������!";
}
?>
<script>

function cure()
{
	location.href='?emeliyyat=cure';
}
function talk(phrase)
{
var tab_b='<center><table border=0 width=95% cellpadding=1 cellspacing=1><tr><td>';
var tab_e='</td></tr></table><BR>';
if(phrase==1)
{
	bernard.innerHTML=tab_b+'<B>�������:</B><BR>- � ��� ������� �� ����, ������� �����������. � ��������� �������� �����, ������ ��������� ����������� ��������� � ��������. ���� ���������� �� ����� �������� ��������. ��, � ��������� ������ � ���� �������� ���� - ��� ��� �� ������� �� ���������� �� �������...<BR><BR><a href="javascript:dialog()" class=us2><B>- ����������...</B></a><BR><a href="javascript:talk(2)" class=us2><B>- �������� �� ������������...(��������� ��������)</B></a>'+tab_e;
}
if(phrase==2)
{
	document.location.href='?act=go&level=remesl';
}
if(phrase==3)
{
	<?
        if($db["orden"]==1)
        {
        	echo "bernard.innerHTML=tab_b+'<B>�������:</B><BR>- �������! � ������ ��� ���������!!!.<BR><BR><a href=\"javascript:cure()\" class=us2><B>- �������, �������� ����...</B></a><BR><a href=\"javascript:talk(2)\" class=us2><B>- �������, ����� ���� �������...(��������� ��������)</B></a>'+tab_e";
        }
        else
        {
        	if($db["travm_var"]==1)
        	{
        		echo "bernard.innerHTML=tab_b+'<B>�������:</B><BR>- �������!� ������ � ��� ��������� ����? ��� ����� ��������! � ������ ��� ��� ��� ����� �� <b>5 ��.</b><BR><BR><a href=\"javascript:cure()\" class=us2><B>- �������, �������� ����...</B></a><BR><a href=\"javascript:talk(2)\" class=us2><B>- �������, ����� ���� �������...(��������� ��������)</B></a>'+tab_e";
        	}
        	else if($db["travm_var"]==2)
        	{
        		echo "bernard.innerHTML=tab_b+'<B>�������:</B><BR>- ���!�� � ��� �������! ���� ������� �������������� ���������... � ������ ��� ����� �� <b>10 ��.</b><BR><BR><a href=\"javascript:cure()\" class=us2><B>- �������, �������� ����...</B></a><BR><a href=\"javascript:talk(2)\" class=us2><B>- �������, ����� ���� �������...(��������� ��������)</B></a>'+tab_e";
        	}
        	else if($db["travm_var"]==3)
        	{
        		echo "bernard.innerHTML=tab_b+'<B>�������:</B><BR>- �, �������! ��� ��� ��� ������� ���? � ��� ��������� ��������! ��� �� �������� ������� ����������.... � ����� ��� ����� ������ ��� <b>15 ��.</b><BR><BR><a href=\"javascript:cure()\" class=us2><B>- �������, �������� ����...</B></a><BR><a href=\"javascript:talk(2)\" class=us2><B>- �������, ����� ���� �������...(��������� ��������)</B></a>'+tab_e";
        	}
        	else if($db["travm_var"]==4)
        	{
        		echo "bernard.innerHTML=tab_b+'<B>�������:</B><BR>- �, �������! � ��� ������� �������... � �� ���� �������� ����� �������...<BR><BR><a href=\"javascript:dialog()\" class=us2><B>- ����������...</B></a><BR><a href=\"javascript:talk(2)\" class=us2><B>- �������, ����� ���� �������...(��������� ��������)</B></a>'+tab_e";
        	}
        }
	?>
}

}
function dialog()
{
	bernard.innerHTML='<center><table border=0  width=95% cellpadding=1 cellspacing=1><tr><td><B>�������:</B><BR>- ���� ������! � ����� ���������, �� ��� ������ ��� �� ��������...� ��������� ��� ��� �� ������� ��������� � �������...��� ������ �� ��������� �� �� ���� ����� �� �������! � ���� ��� � ���� ������ ��������� ���� ����.<BR><BR><a href="javascript:talk(1)" class=us2><B>- � �� ���?</B></a><?if($db["travm"]!=0){print "<BR><a href=\"javascript:talk(3)\" class=us2><B>- �� ������� �� ��������� ����?</B></a>";}?><BR><a href="javascript:talk(2)" class=us2><B>- �������� �� ������������... (��������� ��������)</B></a></td></tr></table><BR>';
}

</script>
<SCRIPT language="JavaScript" type="text/javascript" src="fight.js"></SCRIPT>
<h3>��������</h3>
<font color=red><?echo $msg?>&nbsp;</font>
<table width=100%>
<tr valign=top>
<td>
	<?
		showHPbattle($db);
		showPlayer($db);
	?>
</td>
<td>
	<div id='bernard'></div>
	<script>dialog();</script>
</td>
<td width=210>
	<?
	$result=mysql_query("SELECT * FROM users WHERE login='�������' limit 1");
	$bot=mysql_fetch_Array($result);
	mysql_free_result($result);
	showHPbattle($bot);
	showPlayer($bot);
	?>
</td>
</tr>
</table>