<?
session_start();
$login=$_SESSION['login'];
$spell=$_GET['spell'];
$zaman=time()+2*60*60;
$my_id=$db["id"];
$add=5;
$type='addms';
$add_type="add_ms_boyech";
if($db["battle"])
{
	say($login, "¬ы не можете кастовать это закл€тие наход€сь в бою!", $login);
}
else
{
	mysql_query("DELETE FROM effects WHERE user_id=".$my_id." and type='".$type."'");
	mysql_query("INSERT INTO effects (user_id,type,elik_id,$add_type,end_time) VALUES ('$my_id','$type','$elik_id','$add','$zaman')");
	$_SESSION["message"]="¬ы удачно прокастовали заклинание <b>&laquo;".$name."&raquo;</b>";
	drop($spell,$DATA);
}
echo "<script>location.href='main.php?act=inv&otdel=magic'</script>";
?>