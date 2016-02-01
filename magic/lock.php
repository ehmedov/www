<?
session_start();
$login=$_SESSION['login'];
$spell=$_GET['spell'];
$pass1=$_POST['pass1'];
$pass2=$_POST['pass2'];
$zaman=time()+14*24*60*60;
$my_id=$db["id"];
$type='lock';

$okpass=true;
if ($pass1!=$pass2) {$_SESSION["message"]="Введенные поля не совпадают.";$okpass=false;}
else if (strlen($pass1)>10) {$_SESSION["message"]="Парол должен содержать не более 10 символов";$okpass=false;}
else if (strlen($pass1)<3) {$_SESSION["message"]="Парол должен содержать не менее 3 символов";$okpass=false;}

if ($okpass)
{
	mysql_query("DELETE FROM effects WHERE user_id=".$my_id." and type='".$type."'");
	mysql_query("INSERT INTO effects (user_id,type,elik_id,pass,end_time) VALUES ('$my_id','$type','$elik_id','$pass1','$zaman')");
	$_SESSION["message"]="Вы удачно прокастовали заклинание <b>&laquo;".$name."&raquo;</b>";
	drop($spell,$DATA);
}

echo "<script>location.href='main.php?act=inv&otdel=magic'</script>";
?>