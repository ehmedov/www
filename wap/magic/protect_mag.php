<?
session_start();
$login=$_SESSION['login'];
$spell=$_GET['spell'];
switch ($mtype) 
{
	case "mgprotect25": $add = 25;break;
	case "mgprotect50": $add = 50;break;
	case "mgprotect100": $add = 100;break;
}
$zaman=time()+2*60*60;
$my_id=$db["id"];

$type='mgbron';

mysql_query("DELETE FROM effects WHERE user_id=".$my_id." and type='".$type."'");
mysql_query("INSERT INTO effects (user_id,type,elik_id,add_mg_bron,end_time) VALUES ('$my_id','$type','$elik_id','$add','$zaman')");
$_SESSION["message"]="Вы удачно прокастовали заклинание <b>&laquo;".$name."&raquo;</b>";
drop($spell,$DATA);
?>