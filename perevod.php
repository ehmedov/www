<?
include('key.php');
ob_start("ob_gzhandler");
include ("conf.php");

Header("Cache-Control: no-cache, must-revalidate"); // ������� �������� ���-�� �� �� ��������� ��� ��������
Header("Pragma: no-cache");
$login=$_SESSION['login'];
?>
<head>
	<title>WWW.MEYDAN.AZ - ������ � ���������.</title>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<meta http-equiv="Content-Language" content="ru">
	<META Http-Equiv=Cache-Control Content="no-cache, max-age=0, must-revalidate, no-store">
	<meta http-equiv=PRAGMA content=NO-CACHE>
	<meta http-equiv=Expires content=0>
	<LINK REL=StyleSheet HREF='main.css' TYPE='text/css'>
</head>
<body bgcolor=#dddddd topMargin=0 leftMargin=0 rightMargin=0 bottomMargin=0 >
<?
$data = mysql_connect($base_name, $base_user, $base_pass) or die('�� ���������� ������������. ��������� ��� �������, ��� ������������ � ������!');
mysql_select_db($db_name) or die('������ ����� � ���� ������');

$db=mysql_fetch_Array(mysql_query("SELECT admin_level,dealer,adminsite FROM users WHERE login='".$login."'"));
if($db["admin_level"]<4 && !$db["dealer"]){die ("<h3>��� ���� ������!</h3>");}
//---------------------------------------------
$start = 0;
if(isset($_GET['start'])) 
{ 
	 $start = htmlspecialchars($_GET['start']); 
}
if ($start<0 || !is_numeric($start)) $start = 0;
//---------------------------------------------
$but=$_POST['but'];
$tar=htmlspecialchars(addslashes($_GET['tar']));
$n_date=htmlspecialchars(addslashes($_POST['n_date']));
if(empty($tar)){$tar="";}
if(empty($tar) && $_GET["act"]!="old" && $_GET["act"]!="archive")
{
	$d=date("Y-m-d");
	?>
	<form name='per' action='perevod.php' method='post'>
	������� ����� ��������� � ����(����.��.��):<BR>
	<small>�������� ���� ���� ������, ����� ����������� ��� �������� ���������</small><BR>
	<input type="text" class="new" name="tar" value="<?if (isset($but))echo htmlspecialchars(addslashes($_POST['tar']));?>">
	<input type="text" class="new" name="n_date" value=<?if (isset($but))echo $_POST["n_date"]; else echo $d;?>>
	<input type="submit" name="but" value="  OK  " class=new>
	</form>
	<?
}
else if ($_GET["act"]=="old" && $db["adminsite"])
{
	$login_f=htmlspecialchars(addslashes($_GET['login']));

	$res=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE login='".$login_f."'"));
	if(!$res)
	{
		die("������� <B>".$login_f."</B> �� ������ � ��!!!");
	}
	echo "<input type='submit' class='new' value='NEW' onclick=\"document.location.href='perevod.php?tar=".$res["login"]."'\">";

	$SSS = mysql_query("SELECT * FROM perevod1 WHERE login='".$res["login"]."' ORDER BY date DESC");
	echo "<table border=0 class=new width=100% bgcolor=#dcdcdc cellspacing=1><TR bgcolor=#C7C7C7>
		<td><b>����</td><td><b>�����</td><td><b>��������</td><td><b>�������</td><td><b>IP-������</td><td><b>�����������</td></tr>";
	while($DATA_USERS = mysql_fetch_array($SSS))
	{
		$log = $DATA_USERS["login"];
		$login2 = $DATA_USERS["login2"];
		$action = $DATA_USERS["action"];
		$item = $DATA_USERS["item"];
		$ip = $DATA_USERS["ip"];
		$time = $DATA_USERS["time"];
		$date = $DATA_USERS["date"];
		if ($all%2==0)$color="#D5D5D5";else $color="#C7C7C7";

		$log = "<font color=green>".$log."</font>";
		echo "<tr bgcolor=$color height=23><Td nowrap><small>$date</small></td><td>$log</td><td>$action</td><td>$item</td><td>$ip</td><td>$login2</td></tr>";
		$all++;
	}
}
//----------------------------------------------------------
else if ($_GET["act"]=="archive")
{
	$login_f=htmlspecialchars(addslashes($_GET['login']));
	$q=mysql_query("SELECT * FROM users WHERE login='".$login_f."'");
	$res=mysql_fetch_array($q);
	mysql_free_result($q);
	if(!$res){die("������� <B>".$login_f."</B> �� ������ � ��!!!");}
	
	if ($res['adminsite']>2 && $db["adminsite"]<2)
	{
		die("�������������� ����� ��������� ������ �����!");
	}

	if(empty($n_date))
	{
		echo "<h3>����� � ��������� ��������� ".$res["login"].".</h3>";
		$all=0;
		$table = mysql_query("SELECT count(*) FROM perevod_arch WHERE login='".$res["login"]."'");
		$row = mysql_fetch_array($table);
		$nume=$row[0];
		$eu = ($start - 0); 
		$limit = 50; // No of records to be shown per page. 
		$this1 = $eu + $limit; 
		$back = $eu - $limit; 
		$next = $eu + $limit;
		echo "<input type='submit' class='newbut' value='BACK' onclick=\"document.location.href='perevod.php?tar=".$res["login"]."'\">";		
		echo "<table width='100%' border=0 cellspacing=1><tr>"; 
		echo "<td align=right><b>��������:</b> "; 
		$i=0; 
		$l=1; 
		for($i=0;$i < $nume;$i=$i+$limit)
		{ 
			if($i <> $eu)
			{ 
				echo " <a href='?act=archive&login=".$res["login"]."&start=$i'><b>$l</b></a> "; 
			} 
			else { echo "<b style=color:#ff0000><u>$l</u></b>";} /// Current page is not displayed as link and given font color red 
			$l=$l+1; 
		} 
		echo "&nbsp;</td></tr></table>";
		
		$SSS = mysql_query("SELECT * FROM perevod_arch WHERE login='".$res["login"]."' ORDER BY date DESC limit $eu, $limit");
		echo "<table border=0 class=new width=100% bgcolor=#dcdcdc cellspacing=1><TR bgcolor=#C7C7C7>
			<td><b>����</td><td><b>�����</td><td><b>��������</td><td><b>�������</td><td><b>IP-������</td><td><b>�����������</td></tr>";
		while($DATA_USERS = mysql_fetch_array($SSS))
		{
			$log = $DATA_USERS["login"];
			$login2 = $DATA_USERS["login2"];
			$action = $DATA_USERS["action"];
			$item = $DATA_USERS["item"];
			$ip = $DATA_USERS["ip"];
			$time = $DATA_USERS["time"];
			$date = $DATA_USERS["date"];
			if ($all%2==0)$color="#D5D5D5";else $color="#C7C7C7";

			$log = "<font color=green>".$log."</font>";
			echo "<tr bgcolor=$color height=23><Td nowrap><small>$date</small></td><td>$log</td><td>$action</td><td>$item</td><td>$ip</td><td>$login2</td></tr>";
			$all++;
		}
		mysql_free_result($SSS);
		echo "</table>";
			
		if($all==0)
		{
			echo "� ��������� <B>".$res["login"]."</B> ������ ���������.";
		}
	}
}
else if ($_GET["act"]!="old" && $_GET["act"]!="archive")
{
	$res=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE login='".$tar."'"));	
	if(!$res){die("������� <B>".$tar."</B> �� ������ � ��!!!");}
	
	if ($res['adminsite']>2 && $db["adminsite"]<2)
	{
		die("�������������� ����� ��������� ������ �����!");
	}

	if(empty($n_date))
	{
		echo "<h3>����� � ��������� ��������� ".$res["login"].".</h3>";
		$all=0;
		$table = mysql_query("SELECT count(*) FROM perevod WHERE login='".$res["login"]."'");
		$row = mysql_fetch_array($table);
		$nume=$row[0];
		$eu = ($start - 0); 
		$limit = 50; // No of records to be shown per page. 
		$this1 = $eu + $limit; 
		$back = $eu - $limit; 
		$next = $eu + $limit;
		if ($db["adminsite"])echo "<input type='submit' class='new' value='OLD' onclick=\"document.location.href='perevod.php?act=old&login=".$res["login"]."'\">&nbsp;&nbsp;";
		echo "<input type='submit' class='newbut' value='ARCHIVE' onclick=\"document.location.href='perevod.php?act=archive&login=".$res["login"]."'\">";
		echo "<table width='100%' border=0 cellspacing=1><tr>"; 
		echo "<td align=right><b>��������:</b> "; 
		$i=0; 
		$l=1; 
		for($i=0;$i < $nume;$i=$i+$limit)
		{ 
			if($i <> $eu)
			{ 
				echo " <a href='$page_name?tar=".$tar."&start=$i'><b>$l</b></a> "; 
			} 
			else { echo "<b style=color:#ff0000><u>$l</u></b>";} /// Current page is not displayed as link and given font color red 
			$l=$l+1; 
		} 
		echo "&nbsp;</td></tr></table>";
		
		$SSS = mysql_query("SELECT * FROM perevod WHERE login='".$res["login"]."' ORDER BY date DESC limit $eu, $limit");
		echo "<table border=0 class=new width=100% bgcolor=#dcdcdc cellspacing=1><TR bgcolor=#C7C7C7>
			<td><b>����</td><td><b>�����</td><td><b>��������</td><td><b>�������</td><td><b>IP-������</td><td><b>�����������</td></tr>";
		while($DATA_USERS = mysql_fetch_array($SSS))
		{
			$log = $DATA_USERS["login"];
			$login2 = $DATA_USERS["login2"];
			$action = $DATA_USERS["action"];
			$item = $DATA_USERS["item"];
			$ip = $DATA_USERS["ip"];
			$time = $DATA_USERS["time"];
			$date = $DATA_USERS["date"];
			if ($all%2==0)$color="#D5D5D5";else $color="#C7C7C7";
			if ($login2=="����. �����"){$color_font="style='color:#FF0000'";$color="#fae0e0";}else$color_font="";
			echo "<tr bgcolor='$color' $color_font><Td nowrap><small>$date</small></td><td><font color=green>$log</font></td><td>$action</td><td>$item</td><td>$ip</td><td>$login2</td></tr>";
			$all++;
		}
		mysql_free_result($SSS);
		echo "</table>";
			
		if($all==0)
		{
			echo "� ��������� <B>".$res["login"]."</B> ������ ���������.";
		}
	}
}
//----------------------------------------------------------
if(isset($but))
{
	$tar=trim(htmlspecialchars(addslashes($_POST['tar'])));
	if ($tar!="")
	{
		$q=mysql_query("SELECT * FROM users WHERE login='".$tar."'");
		$res=mysql_fetch_array($q);
		mysql_free_result($q);
		if(!$res){die("������� <B>".$tar."</B> �� ������ � ��!!!");}
		if ($res['adminsite']>2 && $db["adminsite"]<2)
		{
			die("�������������� ����� ��������� ������ �����!");
		}

		$n_date=date("Y-m-d",strtotime($n_date));
		echo "<h3>����� � ��������� ��������� ".$res["login"]." �� $n_date.</h3>";
		$all=0;
		echo "<table border=0 class=new width=100% bgcolor=#dcdcdc cellspacing=1><TR bgcolor=#C7C7C7>
			<td><b>�����</td><td><b>�����</td><td><b>��������</td><td><b>�������</td><td><b>IP-������</td><td><b>�����������</td></tr>";
		$SSS = mysql_query("SELECT * FROM perevod WHERE DATEDIFF(date,'$n_date')=0 and login='".$tar."' ORDER BY date DESC");
		while($DATA_USERS = mysql_fetch_array($SSS))
		{
			$log = $DATA_USERS["login"];
			$login2 = $DATA_USERS["login2"];
			$action = $DATA_USERS["action"];
			$item = $DATA_USERS["item"];
			$ip = $DATA_USERS["ip"];
			$date = $DATA_USERS["date"];
			if ($all%2==0)$color="#D5D5D5";else $color="#C7C7C7";
			$log = "<font color=green>$log</font>";
			echo "<tr bgcolor=$color><Td>$date</td><td>$log</td><td>$action</td><td>$item</td><td>$ip</td><td>$login2</td></tr>";
			$all++;
		}
		mysql_free_result($SSS);
		echo "</table>";
		if($all==0)
		{
			echo "�� ����� <b>".$n_date."</b> � ��������� <B>".$tar."</B> ������ ���������.";
		}
	}
}
mysql_close($data);
?>
