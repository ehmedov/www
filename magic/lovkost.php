<?
session_start();
$login=$_SESSION['login'];
$spell=$_GET['spell'];
switch ($mtype) 
{
	case "lovkost10": $add = 10;	$type='stat';	$zaman=time()+6*60*60;	break;
	case "lovkost15": $add = 15;	$type='stat';	$zaman=time()+6*60*60;	break;
	case "lovkost22": $add = 22;$type='stat_mf';$zaman=time()+2*60*60;	break;
	case "lovkost100": $add = 100;	$type='stat';	$zaman=time()+6*60*60;	break;
}
$my_id=$db["id"];
if($db["battle"])
{
	say($login, "�� �� ������ ��������� ��� �������� �������� � ���!", $login);
}
else
{
	mysql_query("DELETE FROM effects WHERE user_id=".$my_id." and type='".$type."'");
	mysql_query("INSERT INTO effects (user_id,type,elik_id,add_lovkost,end_time) VALUES ('$my_id','$type','$elik_id','$add','$zaman')");
	$_SESSION["message"]="�� ������ ������������ ���������� <b>&laquo;".$name."&raquo;</b>";
	drop($spell,$DATA);
}
echo "<script>location.href='main.php?act=inv&otdel=magic'</script>";        
?>
