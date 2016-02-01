<?

@array_walk($_REQUEST,"format_string");
array_walk($_POST,"format_string");
array_walk($_GET,"format_string"); 

$login=$_SESSION["login"];
$random=md5(time());
$act=$_GET["act"];
$level=$_GET["level"];
$item=$_GET["item"];
$item_id=$_GET["item_id"];

$data = @mysql_connect($base_name, $base_user, $base_pass) or die('Не получается подключиться. Проверьте имя сервера, имя пользователя и пароль!');
mysql_select_db($db_name) or die('Ошибка входа в базу данных');
?>
<?
include("key.php");
$login=$_SESSION['login'];
$login_bot=htmlspecialchars(addslashes($_POST['login_bot']));
$room=htmlspecialchars(addslashes($_POST['room']));


if ($_POST["login_bot"])
{
$S="select * from users where login='".$login_bot."'";
	$q=mysql_query($S);
	$res=mysql_fetch_array($q);
	if(!$res)
	{
		print "<b><font color=red>Персонаж <B>\"".$login_bot."\"</B> не найден в базе данных.</font></b>";
		die();
	}
		mysql_query("UPDATE users,online SET users.room='".$room."', online.room='".$room."' WHERE online.login=users.login and online.login='".$login_bot."'");
		$_SESSION['my_room']=$room;
		$res['room']='$room';
		echo "<script>top.users.go_city();</script>";
}

?>
<form name="" action="main.php?act=inkviz&spell=teleport" method="post">
	<b>Login: <input name="login_bot" type="text" value=""><br>
	Room: <input name="room" type="text" value=""><br>
</select><center>
 <input type="submit" class=qirmizi name=go value="     Ok     "></center>