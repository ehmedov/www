<?
include("key.php");
$login=$_SESSION['login'];
$target=trim($_POST['target']);
if(isset($target))
{
	$q=mysql_query("SELECT * FROM users LEFT JOIN info on info.id_pers=users.id WHERE login='".$target."'");
	$res=mysql_fetch_array($q);
	if(!$res)
	{
		echo  "Персонаж <B>".$target."</B> не найден.";
	}
	else if($res["marry"]=="")
	{
		echo  "Персонаж <b>".$target."</b> не ".(($res["sex"]=='female')?'замужем':'женат').".";
	}
	else 
	{
		$info=mysql_fetch_array(mysql_query("SELECT users.id FROM users LEFT JOIN info on info.id_pers=users.id WHERE login='".$res['marry']."'"));
		$result1 = mysql_query("UPDATE info SET marry='' WHERE id_pers='".$info['id']."'");
		$result2 = mysql_query("UPDATE info SET marry='' WHERE id_pers='".$res['id']."'");
		if($db["adminsite"])$logins="Высшая сила";else $logins=$login;
		$text="Представитель порядка <b>&laquo;".$logins."&raquo;</b> разорвал".(($db['sex']=='female')?'а':'')." брачные узы <b>&laquo;".$res["login"]."&raquo</b> и <b>&laquo;".$res['marry']."&raquo.</b>";
		talk("toall",$text,"");
		echo  "Произведен развод <b>".$res["login"]."</b> и <b>".$res["marry"]."</b>.";
	}
}
?>