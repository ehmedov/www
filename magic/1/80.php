<?
include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));

switch ($_POST['vip'])
{
	case 0:	$vip=0;						break;
	case 1:	$vip=time()+1*24*3600;	 	break;
	case 2:	$vip=time()+2*24*3600; 		break;
	case 7:	$vip=time()+7*24*3600; 		break;
	case 15:$vip=time()+15*24*3600; 	break;
	case 30:$vip=time()+30*24*3600; 	break;
}
	
if(!empty($target))
{
	$q=mysql_query("SELECT * FROM users WHERE login='".$target."' limit 1");
	$res=mysql_fetch_array($q);
	if(!$res)
	{
		echo "Персонаж <B>".$target."</B> не найден в базе данных.";
	}
	else 
	{
		mysql_query("UPDATE users SET vip='".$vip."' WHERE login='".$target."'");
		echo "Персонаж <b>".$target."</b> успешно обновлен.";
	}
}
?>