<?
include('key.php');
ob_start("ob_gzhandler");
include ("conf.php");

Header("Cache-Control: no-cache, must-revalidate"); // говорим браузеру что-бы он не кешировал эту страницу
Header("Pragma: no-cache");
$login=$_SESSION['login'];
?>
<head>
	<title>WWW.MEYDAN.AZ - отчеты о переводах.</title>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<meta http-equiv="Content-Language" content="ru">
	<META Http-Equiv=Cache-Control Content="no-cache, max-age=0, must-revalidate, no-store">
	<meta http-equiv=PRAGMA content=NO-CACHE>
	<meta http-equiv=Expires content=0>
	<LINK REL=StyleSheet HREF='main.css' TYPE='text/css'>
</head>
<body bgcolor=#dddddd topMargin=0 leftMargin=0 rightMargin=0 bottomMargin=0 >
<?
$data = mysql_connect($base_name, $base_user, $base_pass) or die('Не получается подключиться. Проверьте имя сервера, имя пользователя и пароль!');
mysql_select_db($db_name) or die('Ошибка входа в базу данных');

$db=mysql_fetch_Array(mysql_query("SELECT admin_level,dealer,adminsite FROM users WHERE login='".$login."'"));
if($db["admin_level"]<4 && !$db["dealer"]){die ("<h3>Вам сюда нельзя!</h3>");}
//---------------------------------------------
$start = 0;
if(isset($_GET['start'])) 
{ 
	 $start = htmlspecialchars($_GET['start']); 
}
if ($start<0 || !is_numeric($start)) $start = 0;
//---------------------------------------------
$tar=htmlspecialchars(addslashes($_GET['tar']));

$q=mysql_query("SELECT * FROM users WHERE login='".$tar."'");
$res=mysql_fetch_array($q);
mysql_free_result($q);
if(!$res){die("Песонаж <B>".$tar."</B> не найден в БД!!!");}

if ($res['adminsite']>2 && $db["adminsite"]<2)
{
	die("Редактирование богов запрещено высшей силой!");
}

echo "<h3>Отчет Дом отдыха - ".$res["login"].".</h3>";
$all=mysql_fetch_array(mysql_query("SELECT * FROM casino WHERE Username='".$res["login"]."'"));
echo "Общий результат: ".(int)$all["Price"]." <b>".($all["Price"]<=0?"Проиграл":"Выиграл")."</b>";
$table = mysql_query("SELECT count(*) FROM roul_wins WHERE Username='".$res["login"]."'");
$row = mysql_fetch_array($table);
$nume=$row[0];
$eu = ($start - 0); 
$limit = 50; // No of records to be shown per page. 
$this1 = $eu + $limit; 
$back = $eu - $limit; 
$next = $eu + $limit;

echo "<table width='100%' border=0 cellspacing=1><tr>"; 
echo "<td align=right><b>Страницы:</b> "; 
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
$all=0;
$SSS = mysql_query("SELECT * FROM roul_wins WHERE Username='".$res["login"]."' ORDER BY wintime DESC limit $eu, $limit");
echo "<table border=0 class=new width=100% bgcolor=#dcdcdc cellspacing=1><TR bgcolor=#C7C7C7>
<td><b>ДАТА</td><td><b>ЛОГИН</td><td><b>Ставка</td><td><b>Выиграно</td></tr>";
while($DATA_USERS = mysql_fetch_array($SSS))
{
	if ($all%2==0)$color="#D5D5D5";else $color="#C7C7C7";
	echo "<tr bgcolor=$color height=23><Td nowrap><small>".date('d.m.y H:i', $DATA_USERS['wintime'])."</small></td><td>".$DATA_USERS["Username"]."</td><td>".$DATA_USERS["bet"]."</td><td>".$DATA_USERS["win"]."</td></tr>";
	$all++;
}
mysql_free_result($SSS);
echo "</table>";
	
if(!$row[0])
{
	echo "У персонажа <B>".$res["login"]."</B> небыло переводов.";
}
mysql_close();
?>
