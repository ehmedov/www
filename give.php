<?
include ('key.php');
ob_start("@ob_gzhandler");
include ("conf.php");
include ("functions.php");
include ("item_des.php");
$login=$_SESSION['login'];

Header("Cache-Control: no-cache, must-revalidate"); // ������� �������� ���-�� �� �� ��������� ��� ��������
Header("Pragma: no-cache");

$data = mysql_connect($base_name, $base_user, $base_pass) or die('�� ���������� ������������. ��������� ��� �������, ��� ������������ � ������!');
mysql_select_db($db_name) or die('������ ����� � ���� ������');

$db=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE login='".$login."'"));
$ip=$db["remote_ip"];
?>
<HTML>
<HEAD>
	<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
	<META Http-Equiv=Cache-Control Content=no-cache>
	<meta http-equiv=PRAGMA content=NO-CACHE>
	<META Http-Equiv=Expires Content=0>
	<link rel=stylesheet type="text/css" href="main.css">
</HEAD>
<body bgcolor="#faeede">
<SCRIPT LANGUAGE="JavaScript" type="text/javascript" SRC="scripts/magic-main.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" type="text/javascript" SRC="commoninf.js"></SCRIPT>
<? 
$step=1;
if ($step==1) $idkomu=0;

if (!$_REQUEST['setedit']) { $_REQUEST['setedit']=1; }
if ($_REQUEST['target']) 
{
	$target_q=mysql_query("SELECT * FROM users WHERE login='".addslashes(htmlspecialchars($_REQUEST['target']))."'");
	$res=mysql_fetch_array($target_q);
	$step=3;
}
else if ($_REQUEST['to_id']) 
{
	$target_q=mysql_query("SELECT * FROM users WHERE id='".(int)$_REQUEST['to_id']."'");
	$res=mysql_fetch_array($target_q);
	$step=3;
}
if ($step==3)
{
	$step=0;
	$id_person_x=$res['id'];
	if (!$id_person_x) $errmsg='�������� �� ������';
	else if ($res['adminsite'] && !$db['adminsite']) $errmsg='�������� �� ������';
	else if ($id_person_x==$db['id']) $errmsg='������� ���������� ������ ����';
	else if ($res['room']!=$db['room']) $errmsg='�� ������ ���������� � ����� ������� � ��� ���� ������ �������� ����';
	else if ($res['level']<8 || $db['level']<8) $errmsg='� ���������� �� 8-�� ������ �������� ��������� ���������';
	else if ($res['orden']==5) $errmsg='����� �������� ��������� ���������!';
	else if ($res['blok']) $errmsg='�������� ������������!';
	else if ($ip==$res['remote_ip']) $errmsg='�� �� ������ ���������� � ��������� � ����� �� IP ��� � ���!';
	else
	{
		$idkomu=$id_person_x;
		$komu=$res['login']; 	
		$step=3;
	}
}
else $errmsg='� ���������� �� 8-�� ������ �������� ��������� ���������';
if ($step==3 && $db['orden']!=5) 
{
	if ($_REQUEST['setkredit']>0 && is_numeric($_REQUEST['setkredit']) && $_REQUEST['to_id'] && $_REQUEST['sd4']==$db['id'] )
	{
		$_REQUEST['setkredit']=round($_REQUEST['setkredit'],2);
		$_REQUEST['comment']=htmlspecialchars(addslashes(trim($_REQUEST['comment'])));
		if ($db["peredacha"]>=50) $errmsg="��� ����� ������� ��������";
		else if ($db['money']<$_REQUEST['setkredit']) $errmsg="� ��� �� ����� ��� ����� �����!";
		else if ($_REQUEST['comment']=="") $errmsg="������� ����������� � ���������!";
		else 
		{
			mysql_query("UPDATE users SET money=money-".$_REQUEST['setkredit'].", peredacha=peredacha+1 WHERE id='".$db['id']."'");
	      	mysql_query("UPDATE users SET money=money+".$_REQUEST['setkredit']." WHERE id='".$idkomu."'");
			say($res['login'],"�������� <b>".$db['login']."</b> �������".(($db['sex']=='female')?'�':'')." ��� <b>".$_REQUEST['setkredit']." ��.</b>.",$res['login']);
			$errmsg='������ �������� '.$_REQUEST['setkredit'].' ��. � ��������� '.$komu;
			history($db['login'],'������� ��.',$_REQUEST['setkredit']." ��. (����������: ".$_REQUEST['comment'].")",$ip,$res['login']);
			history($res['login'],'������� ��.',$_REQUEST['setkredit']." ��. (����������: ".$_REQUEST['comment'].")",$res['remote_ip'],$db['login']);
			$db=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE login='".$login."'"));
		}
	}
	else if ($_REQUEST['action']=='gift' && $_REQUEST['to_id'] && is_numeric($_REQUEST['item_id']))
	{
		$res_item=mysql_fetch_array(mysql_query("SELECT * FROM inv WHERE owner='".$login."' and id='".$_REQUEST['item_id']."' and wear='0'"));
		if (!$res_item['id']) $errmsg="������� �� ������ � �������...";
		else 
		{
			if ($db["peredacha"]>=50) $errmsg="��� ����� ������� ��������";
			else if ($res_item['gift']) $errmsg='������� &quot'.$res_item['name'].'&quot ������� ���. �� �� ������ ���������� �������.';
			else if ($res_item['is_modified']) $errmsg='�� �� ������ �������� �������';
			else if ($res_item['art'] && !$db['adminsite']) $errmsg='�� �� ������ �������� ���.';
			else if ($res_item['podzemka'] && !$db['adminsite']) $errmsg='�� �� ������ �������� ������� �� ����������.';
			else
			{
				mysql_query("UPDATE users SET  peredacha=peredacha+1 WHERE id='".$db['id']."'");
				mysql_query("UPDATE inv SET owner='".$komu."', gift='1', gift_author='".$login."' WHERE id='".$_REQUEST['item_id']."'");
				$errmsg="�� ������ �������� ������� &quot".$res_item['name']."&quot ��������� ".$komu ;
				say($komu,"�������� <b>".$login."</b> ������� ��� ������� <b>&quot".$res_item['name']."&quot</b>.",$komu);
				history($login,'�������',$res_item['name']." (����: ".$res_item['price']." ��.)",$ip,$komu);
				history($komu,'������ � �������',$res_item['name']." (����: ".$res_item['price']." ��.)",$res['remote_ip'],$login);
			}
		}
	}
	else if ($_REQUEST['action']=='give' && $_REQUEST['to_id'] && is_numeric($_REQUEST['item_id']))
	{
		$res_item=mysql_fetch_array(mysql_query("SELECT * FROM inv WHERE owner='".$login."' and id='".$_REQUEST['item_id']."' and wear='0'"));
		if (!$res_item['id']) $errmsg="������� �� ������ � �������...";
		else 
		{
			if ($db["peredacha"]>=50) $errmsg="��� ����� ������� ��������";
			else if ($res_item['gift']) $errmsg='������� &quot'.$res_item['name'].'&quot ������� ���. �� �� ������ ���������� �������.';
			else if ($res_item['is_modified']) $errmsg='�� �� ������ �������� �������';
			else if ($res_item['art'] && !$db['adminsite']) $errmsg='�� �� ������ �������� ���.';
			else if ($res_item['podzemka'] && !$db['adminsite']) $errmsg='�� �� ������ �������� ������� �� ����������.';
			else
			{
				mysql_query("UPDATE users SET  peredacha=peredacha+1 WHERE id='".$db['id']."'");
				mysql_query("UPDATE inv SET owner='".$komu."' WHERE id='".$_REQUEST['item_id']."'");
				$errmsg="�� ������ �������� ������� &quot".$res_item['name']."&quot ��������� ".$komu ;
				say($komu,"�������� <b>".$login."</b> ������� ��� ������� <b>&quot".$res_item['name']."&quot</b>.",$komu);
				history($login,'�������',$res_item['name']." (����: ".$res_item['price']." ��.)",$ip,$komu);
				history($komu,'������',$res_item['name']." (����: ".$res_item['price']." ��.)",$res['remote_ip'],$login);
			}
		}
	}
}
?>
<H3>�������� ���������/�������� ������� ������</H3>
<div id=hint4></div>
<TABLE width=100% cellspacing=0 cellpadding=0>
<TR>
	<TD>
	<? 
	if ($step==3) 
	{ 
		echo "�������� <script>drwfl('".$res['login']."', '".$res['id']."', '".$res['level']."', '".$res['dealer']."', '".$res['orden']."', '".$res['admin_level']."', '".$res['clan_short']."', '".$res['clan']."');</script>
		<INPUT TYPE=button value=\"�������\" onClick=\"findlogin('�������� ���������','give.php','target','','4')\"><BR>";
	}
	else
	{
		echo "<SCRIPT>findlogin(\"�������� ���������\",\"give.php\",\"target\",\"\",\"4\");</SCRIPT>";
	}
	?>
	</td>
	<TD align=right>
		<INPUT TYPE=button value="���������" onClick="location.href='main.php?act=none';">
		<INPUT TYPE=button value="��������"  onClick="location.href='give.php';">
		<INPUT TYPE=button class="podskazka" value="���������" onclick="window.open('help/transfer.php','displayWindow','height=400,width=500,resizable=no,scrollbars=yes,menubar=no,status=no,toolbar=no,directories=no,location=no')"/>
	</TD>
</TR>
<TR>
	<TD colspan=2 align=right><b style='color:#ff0000'><?echo $errmsg."&nbsp;"; ?></B></td>
</TR>
</TABLE>
<FORM ACTION="give.php" METHOD=POST>
<TABLE width=100% cellspacing=0 cellpadding=0>
<TR>
	<TD valign=top align=left width=40%>
	<?
		if ($step==3) 
		{
			$money = sprintf ("%01.2f", $db["money"]);
			?>
			<INPUT TYPE=hidden name=to_id value="<? echo $idkomu; ?>">
			<INPUT TYPE=hidden name=sd4 value="<? echo $db['id']; ?>">
			� ��� � �������: <b style='COLOR:339900'><?echo $money;?> </b>��.
			<br>�������� �������, ���������� 0.01 ��.<BR>
			������� �����: <INPUT TYPE=text NAME=setkredit maxlength=3 size=10><br>
			����������: <input type='text' name='comment' size='20'> 
			<INPUT TYPE=submit VALUE="��������" style="cursor:hand">
			<?
		}
	?>	
	</TD>
	<TD>
		<table width=100% cellspacing=1 cellpadding=3 class="l3">
		<?
		if ($step==3) 
		{
			$result=mysql_query("SELECT * FROM inv WHERE owner='".$login."' and object_razdel='obj' and wear=0 ORDER BY UNIX_TIMESTAMP(date) DESC");
			while($dat = mysql_fetch_array($result))
			{
				$n=(!$n);
				echo "<tr class='".($n?'l0':'l1')."'>
				<td width=150 valign=center align=center>
				<img src='img/items/".$dat["img"]."' border=0><BR>
				<a href='give.php?action=gift&item_id=".$dat["id"]."&to_id=".$idkomu."' class=us2>��������</a><BR>
				<a href='give.php?action=give&item_id=".$dat["id"]."&to_id=".$idkomu."' class=us2>��������</a>
				</td><td valign=top>";
				show_item($db1,$dat);
				echo "</td></tr>";
			}
			if(!mysql_num_rows($result))
			{
				echo "<tr><td><b style='color:#ffffff'>� ��� ��� ����� � �������.</b></td></tr>";
			}
		}
		mysql_close($data);	
		?>	
		</TABLE><br>
	</TD>
</TR>
</TABLE>
</FORM>
</BODY>
</HTML>