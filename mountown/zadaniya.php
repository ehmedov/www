<?
	$login=$_SESSION["login"];
	$res=mysql_fetch_array(mysql_query("SELECT count(*) FROM `deztow_turnir` WHERE winner='".$login."'"));
	switch ($res[0])
	{
		case ($res[0]>=30 && $res[0]<50):$reputation="�������������";break;
		case ($res[0]>50 && $res[0]<100):$reputation="�����������";break;
		case ($res[0]>=100):$reputation="������";break;
		default:$reputation="��� ��������";break;
	}
	if ($_GET["zad"]==1)
	{
		if ($db["reputation"]>=5)
		{
			mysql_query("UPDATE users SET money=money+50,reputation=reputation-5 WHERE login='".$login."'");
			$msg="�� �������� 50.00 ��. �� 5 ���������";
			history($login,"�������",$msg,$db['remote_ip'],"������� � �����");
			$db["reputation"]=$db["reputation"]-5;
			$db["money"]=$db["money"]+50;
		}
		else $msg="� ��� ��� ����������� ���������!";
	}
	else if ($_GET["zad"]==2)
	{
		if ($db["reputation"]>=100)
		{
			mysql_query("UPDATE users SET naqrada=naqrada+1000, reputation=reputation-100 WHERE login='".$login."'");
			$query=mysql_fetch_array(mysql_query("SELECT count(*) FROM inv WHERE owner='".$login."' and object_razdel='medal' and object_id=31"));
			if ($query[0]==0)
			{
				mysql_query("INSERT INTO inv (owner,object_id,object_type,object_razdel,iznos_max) VALUES ('$login',31,'medal','medal',1);");
				$msg.="�� �������� ����� <b>������ ����� ������ [1]</b>. ";
			}
			else
			{
				$query=mysql_fetch_array(mysql_query("SELECT count(*) FROM inv WHERE owner='".$login."' and object_razdel='medal' and object_id=32"));
				if ($query[0]==0)
				{
					mysql_query("INSERT INTO inv (owner,object_id,object_type,object_razdel,iznos_max) VALUES ('$login',32,'medal','medal',1);");
					$msg.="�� �������� ����� <b>������ ����� ������ [2]</b>. ";
				}
				else 
				{
					$query=mysql_fetch_array(mysql_query("SELECT count(*) FROM inv WHERE owner='".$login."' and object_razdel='medal' and object_id=33"));
					if ($query[0]==0)
					{
						mysql_query("INSERT INTO inv (owner,object_id,object_type,object_razdel,iznos_max) VALUES ('$login',33,'medal','medal',1);");
						$msg.="�� �������� ����� <b>������ ����� ������ [3]</b>. ";
					}
				}
			}
			$msg.="�� �������� 1000.00 ��. �� 100 ���������";
			history($login,"�������",$msg,$db['remote_ip'],"������� � �����");
			$db["reputation"]=$db["reputation"]-100;
			$db["naqrada"]=$db["naqrada"]+1000;
		}
		else $msg="� ��� ��� ����������� ���������!";
	}
?>
<TABLE width=100% border=0>
<tr valign=top>
	<td align=right nowrap><INPUT TYPE="button" value="��������� �����" style="background-color:#AA0000; color: white;" onclick="location.href='?act=go&level=smert_room';"></td>
	<td width=100%><h3>������� � �����</h3></td>
	<td align=right nowrap>
		<input type=button  class=newbut onclick="location.href='main.php?act=none'" value="��������">
	</td>
</tr>
</table>
<font color=red><?=$msg;?></font>
<h4>����������</h4>
� ����� � ����� ������: <B><?=$res[0]?></B><BR>
� ������� � ����� ������: <B><?=$reputation?></B><BR>
� ��������� � ����� ������: <B><?=$db["reputation"]?></B><BR>
	
<h4>������� � �����</h4>
1. <a href="?zad=1">�������� �������� � ����� ������</a> <i>(5 ���������, 50.00 ��.)</i><BR>
2. <a href="?zad=2">�������� ����� ������</a> <i>(100 ���������, 1000.00 ��.)</i><BR>

<BR><BR>
<h4>��������� 10 ������� ����� ������</h4>		
<?
$sql=mysql_Query("SELECT users.login,users.level,users.id,users.orden,users.admin_level,users.clan,users.clan_short,users.dealer FROM `inv` LEFT JOIN users on users.login=inv.owner WHERE `object_id`=31 and `object_type`='medal' ORDER BY inv.date ASC");
while($dat=mysql_fetch_Array($sql))
{
	echo "<script>drwfl('".$dat['login']."','".$dat['id']."','".$dat['level']."','".$dat['dealer']."','".$dat['orden']."','".$dat['admin_level']."','".$dat['clan_short']."','".$dat['clan']."');</script><br>";
}
?>	
</BODY>
</HTML>