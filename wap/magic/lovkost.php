<?
session_start();
$login=$_SESSION['login'];
switch ($mtype) 
{
	case "lovkost10": $add = 10;break;
	case "lovkost15": $add = 15;break;
	case "lovkost22": $add = 22;break;
	case "lovkost100": $add = 100;break;
}
$zaman=time()+6*60*60;
$my_id=$db["id"];
$type='stat';
mysql_query("DELETE FROM effects WHERE user_id=".$my_id." and type='".$type."'");
mysql_query("INSERT INTO effects (user_id,type,elik_id,add_lovkost,end_time) VALUES ('$my_id','$type','$elik_id','$add','$zaman')");
$_SESSION["message"]="Вы удачно прокастовали заклинание <b>&laquo;".$name."&raquo;</b>";
drop($spell,$DATA);
?>