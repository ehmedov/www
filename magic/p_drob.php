<?
session_start();
$login=$_SESSION['login'];
$spell=$_GET['spell'];
switch ($mtype) 
{
	case "drob10": $add = 10; break;
}
$zaman=time()+2*3600;
$type='p_drob';
$my_id=$db["id"];
if($db["battle"])
{
	say($login, "¬ы не можете кастовать это закл€тие наход€сь в бою!", $login);
}
else
{
	mysql_query("DELETE FROM effects WHERE user_id=".$my_id." and type='".$type."'");
	mysql_query("INSERT INTO effects (user_id,type,elik_id,p_drob,end_time) VALUES ('$my_id','$type','$elik_id','$add','$zaman')");
	$_SESSION["message"]="¬ы удачно прокастовали заклинание <b>&laquo;".$name."&raquo;</b>";
	drop($spell,$DATA);
}
echo "<script>location.href='main.php?act=inv&otdel=magic'</script>";        
?>
