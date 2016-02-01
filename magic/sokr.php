<?
session_start();
$login=$_SESSION['login'];
$spell=$_GET['spell'];
switch ($mtype) 
{
	case "sokr1": $add = 45;break;
	case "sokr2": $add = 60;break;
	case "sokr3": $add = 100;break;
}

$zaman=time()+3*60*60;
$my_id=$db["id"];
$type='sokr';
if($db["battle"])
{
	say($login, "¬ы не можете кастовать это закл€тие наход€сь в бою!", $login);
}
else
{
	mysql_query("DELETE FROM effects WHERE user_id=".$my_id." and type='".$type."'");
	mysql_query("INSERT INTO effects (user_id,type,elik_id,add_krit,add_akrit,add_uvorot,add_auvorot,end_time) VALUES ('$my_id','$type','$elik_id','$add','$add','$add','$add','$zaman')");
	$_SESSION["message"]="¬ы удачно прокастовали заклинание <b>&laquo;".$name."&raquo;</b>";
	drop($spell,$DATA);
}
echo "<script>location.href='main.php?act=inv&otdel=magic'</script>";        
?>
