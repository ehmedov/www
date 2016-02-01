<?
session_start();
$login=$_SESSION['login'];
$spell=$_GET['spell'];
switch ($mtype) 
{
	case "bron10": $add = 10;break;
	case "bron25": $add = 25;break;
	case "bron50": $add = 50;break;
	case "bron75": $add = 75;break;
	case "bron100": $add = 100;break;
}
$zaman=time()+6*60*60;
$my_id=$db["id"];
$type='bron';

mysql_query("DELETE FROM effects WHERE user_id=".$my_id." and type='".$type."'");
mysql_query("INSERT INTO effects (user_id,type,elik_id,add_bron,end_time) VALUES ('$my_id','$type','$elik_id','$add','$zaman')");
$_SESSION["message"]="Вы удачно прокастовали заклинание <b>&laquo;".$name."&raquo;</b>";
drop($spell,$DATA);
?>