<?
$login=$_SESSION["login"];
include ('time.php');
$ip=$db["remote_ip"];
if($db["admin_level"]>=10)$admin=1;
if($db["admin_level"]>=4)$moder=1;

$z_money=array();
$z_money[8]	=1000;
$z_money[9]	=1500;
$z_money[10]=2000;
$z_money[11]=3000;
$z_money[12]=5000;


###//��������
// ��������
if ($_GET["id"] && $admin==1) 
{
	$pr_id=(int)$_GET["id"];
	$hinfo=mysql_fetch_Array(mysql_query("SELECT proverka.*,users.metka,users.blok,users.prision,users.remote_ip FROM proverka LEFT JOIN users on users.login=proverka.login WHERE proverka.id=".$pr_id));
	if ($hinfo['blok'])	$msg = "�������� <b>".$hinfo['login']."</b> ������������!";
	else if ($hinfo['prision'])$msg = "�������� <b>".$hinfo['login']."</b> � �����!";
	else if ($hinfo["metka"]+5*24*60*60>time())$msg = "� ��������� <b>".$hinfo['login']."</b> ��� ������������� ���������� ��������!";
	else 
	{
		mysql_query("UPDATE users SET metka='".time()."'  WHERE login='".$hinfo['login']."'");
		mysql_query("LOCK TABLES proverka WRITE, perevod WRITE, perevod_arch WRITE");
		mysql_query("DELETE FROM proverka where id=".$pr_id);
		mysql_query("INSERT INTO perevod_arch(date,login,action,item,ip,login2) SELECT perevod.date,perevod.login,perevod.action,perevod.item,perevod.ip,perevod.login2 FROM perevod WHERE login='".$hinfo['login']."';");
		mysql_query("DELETE FROM perevod WHERE login='".$hinfo['login']."'");
		mysql_query("UNLOCK TABLES");
		$txt="�������� � �������������� ������� �������� ������. � ��� ���� 5 ����� ��� ���������� � �������.";
		mysql_query("INSERT INTO pochta(user,whom,text,subject) VALUES ('��������','".$hinfo['login']."','".$txt."','�������� � �������������� �������')");
		$msg = "�� ��������, ��� �������� <b>".$hinfo['login']."</b> ���� ����� �������.";
		history($hinfo['login'],"��������","�������� � �������������� ������� �������� ������. (���������: ".$login.")",$hinfo["remote_ip"],"��� ��������");
		history($login,"��������","�������� ����� ��������� ".$hinfo['login'],$db["remote_ip"],"��� ��������");
	}
}
// �����
if ($_GET["otkaz"] && $admin==1) 
{
	$otkaz=(int)$_GET["otkaz"];
	$comment=htmlspecialchars(addslashes($_POST['comment']));
	$comment=str_replace("\n","<br>",$comment);
	$hinfo=mysql_fetch_Array(mysql_query("SELECT * FROM proverka WHERE id=".$otkaz));
	if ($hinfo)
	{
		mysql_query("DELETE FROM proverka WHERE id=".$otkaz);
		$txt="�������� � �������������� ������� �� ��������. �������: ".$comment;
		mysql_query("INSERT INTO pochta(user,whom,text,subject) VALUES ('��������','".$hinfo['login']."','".$txt."','�������� � �������������� �������')");
		$msg = "�������� �� �������� ��� �������� <b>".$hinfo['login']."</b>.";
		history($hinfo['login'],"�����","�������: ".$comment." (���������: ".$login.")",$hinfo["remote_ip"],"��� ��������");
		history($login,"�����","�������: ".$comment." (����: ".$hinfo['login'].")",$db["remote_ip"],"��� ��������");

	}
}
// ������� ������������
if ($_GET["prichina"] && ($moder==1 || $admin==1)) 
{
	$otkaz=(int)$_GET["prichina"];
	$comment=htmlspecialchars(addslashes($_POST['comment']));
	$comment=str_replace("\n","<br>",$comment);
	$hinfo=mysql_fetch_Array(mysql_query("SELECT * FROM proverka WHERE id=".$otkaz));
	if ($hinfo)
	{
		$txt="���������� ��������. �������: ".$comment;
		mysql_query("INSERT INTO pochta(user,whom,text,subject) VALUES ('��������','".$hinfo['login']."','".$txt."','�������� � �������������� �������')");
		mysql_query("UPDATE proverka SET zstatus=2, prichina='".$comment."',moder='".$login."' WHERE id=".$otkaz);
	}
}
// ��������
if ($_GET["deystv"] && ($moder==1 || $admin==1))
{
	$deystv=(int)$_GET["deystv"];
	$color=htmlspecialchars(addslashes(trim($_POST['color'])));
	$comment=htmlspecialchars(addslashes(trim($_POST['comment'])));
	echo $comment="<font color=".$color.">".$comment."</font>";
	$comment=str_replace("\n","<br>",$comment);
	$hinfo=mysql_fetch_Array(mysql_query("SELECT * FROM proverka WHERE id=".$deystv));
	if ($hinfo)
	{
		mysql_query("UPDATE proverka SET zstatus=3, prichina='".$comment."',moder='".$login."' WHERE id=".$deystv);
	}
}
//---------------------------
if ($_GET["podat"]) 
{
	//$msg="<h3>������ �� ������!</h3>";
	if (!$db["prision"])
	{	
		if ($db["money"]>=$z_money[$db["level"]])
		{
			if ($db["level"]>=8)
			{
				if ($db["metka"]+5*24*60*60<time())
				{
					$mes=mysql_fetch_array(mysql_query("SELECT * FROM proverka where login='".$login."'"));
					if (!$mes)
					{
						$c_pr=mysql_fetch_Array(mysql_Query("SELECT count(*) FROM proverka WHERE zstatus=1"));
						if ($c_pr[0]<30)
						{	
							mysql_query("UPDATE users SET money=money-".$z_money[$db["level"]]." WHERE login='".$login."'");
							mysql_query("INSERT INTO `proverka` (`login`,`zstatus`,`vaxt`) VALUES ('".$login."','1',".time().")");
							$db["money"]=$db["money"]-$z_money[$db["level"]];
							history($login,"����� ������ �� ��������",$z_money[$db["level"]]." ��.",$ip,"��� ��������");
							$msg="�� ������ ������ ������, ����� � ������������!";
						} else  $msg="� �������� ����������� 20 ������. ������� � �������...";
					} else  $msg="�� ��� ������ ������, ����� � ������������!";
				} else $msg="�� ��� ������ ��������, �������� �� ���������!";
			} else $msg="� ��� �� ��� �������, ��������������� ������� 12!";
		} else $msg="��� �������� ���������� ".$z_money[$db["level"]]." ��., � � ��� �� ����!";
	} else $msg="�� � �����...";
} 
###//����� ��������

$money = sprintf ("%01.2f", $db["money"]);
$platina = sprintf ("%01.2f", $db["platina"]);
?>
<script>
	var Hint3Name = '';
	// ���������, �������� �������, ��� ���� � �������
	function otkaz(title, script, name)
	{
		document.all("hint3").innerHTML = '<table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: hand" onclick="closehint3();"><BIG><B>x</td></tr><tr><td colspan=2>'+
		'<table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><form action="'+script+'" method=POST><INPUT TYPE=hidden name=sd4 value="<? echo $myinfo->id_person; ?>"><td colspan=2>'+
		'������� �������</TD></TR><TR><TD width=50% align=right><textarea rows=5 cols=35 NAME="'+name+'"></textarea></TD><TD width=50%><INPUT type=image SRC="img/dmagic/gray_30.gif"></TD></TR>'+
		'<tr><td colspan=3>���� ���������: <select name=color class="inup"><option style="COLOR: black" value="Black">Black</option>'+
		'<option style="COLOR: blue" value="Blue">Blue</option>'+
				'<option style="COLOR: green" value="Green">Green</option>'+
				'<option style="COLOR: maroon" value="Maroon">Maroon</option></select></FORM></TABLE></td></tr></table>';
		document.all("hint3").style.visibility = "visible";
		document.all("hint3").style.left = 100;
		document.all("hint3").style.top = 100;
		document.all(name).focus();
		Hint3Name = name;
	}
	function closehint3()
	{
		document.all("hint3").style.visibility="hidden";
	    Hint3Name='';
	}
</script>
<h3>��� ��������</h3>
<table width=100%>
<tr>
	<td width=100%>� ��� � �������: <B><?echo $money;?></b> ��. <b><?echo $platina;?></b> ��.</td>
	<td nowrap valign=top>
		<input type=button value='���������' class=newbut onclick="document.location='main.php?act=go&level=remesl'">
		<input type=button value='��������'  class=newbut onClick="location.href='?act=none'">
	</td>
</tr>
</table>
<div id=hint3></div>
<?
echo"<center><font color=red><b>".$msg."</b></font></center><br>";

//������ ������
echo"
<table width='100%'>
	<tr><td align=center><b>������ ������ �� ��������</b></td></tr>";
	$me=mysql_fetch_array(mysql_query("SELECT * FROM proverka where login='".$login."'"));
	if ($db["metka"]+5*24*60*60>time()) echo"<td align=center><I>�� ��� ������ �������� �� �������. ����� ��� ������: <b>".convert_time(($db["metka"]+5*24*60*60))."</I></td>";
	else if ($db["metka"]+20*24*60*60>time()) echo"<td align=center><I>�� ��������� ��������: <b>".convert_time(($db["metka"]+20*24*60*60))."</I></td>";
	else if ($me["zstatus"]==1 || $me["zstatus"]==3) echo"<td align=center><I>���� ������ ��������� �� ������������.</I></td>";
	else if ($me["zstatus"]==2) echo"<td align=center><font color=red><b>��������� ��������:</b> ".$me["prichina"]."</font></td>";
	else echo"<td>��� ������ ������ ��� ����� �����:<br>
	- ����� ��� ���� <b>".$z_money[$db["level"]]."</b> ��.<br>
	- ��� ������� ������ ���� ����� ��� ����� <b>8-��</b><br>
	<input type='button' value='������ ������ �� ��������' class=input onclick='document.location.href=\"?podat=1\"'></td>";
	echo"</tr>
</table>";

//----------------------------------------
echo"
	<TABLE width=100% cellspacing=1 cellpadding=5 class='l3' align=center>
	<TR style='font-weight:bold'>
		<TD width=10% align=center>�</TD><TD width=10% align=center>��������</TD><TD align=center>�����</TD><TD align=center>���������</TD><TD align=center>�����</TD><TD align=center>���������</TD>
	</TR>";
		$zay_ka=mysql_query("SELECT proverka.*,us.level,us.dealer,us.orden,us.admin_level,us.clan_short,us.clan, m.level as moder_level,m.dealer as moder_dealer,m.orden as moder_orden,m.admin_level as moder_admin_level,m.clan_short as moder_clan_short,m.clan as moder_clan FROM proverka LEFT JOIN users us on us.login=proverka.login LEFT JOIN users m on m.login=proverka.moder ORDER BY vaxt ASC");
		if (mysql_num_rows($zay_ka)) 
		{
			while ($zayavka=mysql_fetch_array($zay_ka))
			{
				$i++;
				$n=(!$n);
				switch ($zayavka['zstatus'])
				{
					case 1:$zstatus="�� ������������";break;
					case 2:$zstatus="���������� ��������";break;
					case 3:$zstatus="<b>".$zayavka["prichina"]."</b>";break;
				}
				$zstatus=str_replace("&amp;","&",$zstatus);
				$zstatus=str_replace("&amp;","&",$zstatus);$zstatus=str_replace("&amp;","&",$zstatus);
				echo"<tr class='".($n?'l0':'l1')."'>
				<TD align='center' witdh=20>$i</td>
				<TD align='center' nowrap>";
				if ($admin)
				{	
					echo "<input type='button' value='��������� �����' style='font-weight:bold;color:green;' onclick=\"document.location.href='?id=".$zayavka["id"]."'\">
					<br><input type='button' value='����� �� ������� ' onclick=\"JavaScript:otkaz('����� �� ��������<br>��������� ".$zayavka['login']."','?otkaz=".$zayavka["id"]."', 'comment')\">";
				}
				if ($moder)
				{	
					echo "<br><input type='button' value='������� ������������' onclick=\"JavaScript:otkaz('������� ������������<br>��������� ".$zayavka['login']."','?prichina=".$zayavka["id"]."', 'comment')\">
					<br><input type='button' value='��������' onclick=\"JavaScript:otkaz('��������<br>��������� ".$zayavka['login']."','?deystv=".$zayavka["id"]."', 'comment')\">";
				}
				echo "</TD>
				<TD align=center nowrap><script>drwfl('".$zayavka['login']."','".$zayavka['id']."','".$zayavka['level']."','".$zayavka['dealer']."','".$zayavka['orden']."','".$zayavka['admin_level']."','".$zayavka['clan_short']."','".$zayavka['clan']."');</script></TD>";
				echo "<TD align=center>".($db["orden"]==1?$zstatus:"<i style='color:grey'>������</i>")."</TD>";
				echo "<TD align=center nowrap>".date("d.m.Y H:i", $zayavka["vaxt"])."</TD>
				<TD align=center nowrap>".($zayavka["moder"]?"<script>drwfl('".$zayavka['moder']."','".$zayavka['moder_id']."','".$zayavka['moder_level']."','".$zayavka['moder_dealer']."','".$zayavka['moder_orden']."','".$zayavka['moder_admin_level']."','".$zayavka['moder_clan_short']."','".$zayavka['moder_clan']."');</script>":"")."</TD>
				</tr>";
			}
		} 
		else echo"<tr><td colspan=6><center>����� ������ �� ������!</center></td></tr>";
echo"</table>";
?>