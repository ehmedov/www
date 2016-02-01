<?
session_start();
$login=$_SESSION['login'];
$spell=$_GET['spell'];
$zaman=time()+3*60*60;
$my_id=$db["id"];
$type='vampire';
mysql_query("DELETE FROM effects WHERE user_id=".$my_id." and type='".$type."'");
mysql_query("INSERT INTO effects (user_id,type,elik_id,end_time) VALUES ('$my_id','$type','$elik_id','$zaman')");
"Вы удачно прокастовали заклинание <b>&laquo;".$name."&raquo;</b>";
drop($spell,$DATA);
?>