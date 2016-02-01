<?
include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
$text=htmlspecialchars(addslashes($_POST['text']));
$text = str_replace("&amp;","&",$text);
if(!empty($target))
{
	$q=mysql_query("SELECT * FROM users WHERE login='".$target."'");
	$res=mysql_fetch_array($q);
	if(!$res)
	{
		echo "Персонаж <B>".$target."</B> не найден в базе данных.";
		die();
	}
	if ($db["adminsite"]!=5)
	{	
		if($res['adminsite']>=5 ||$res["admin_level"]>=9)
		{
			echo "Редактирование богов запрещено высшей силой!";
			die();
		}
	}
	$pref=$db["sex"];
	if($pref=="female")
	{
		$prefix="а";
	}
	else
	{
		$prefix="";
	}
	if (!empty($text)) $t="<b>Причина:</b> <i>".$text."!</i>";else $t="";
	if($db["adminsite"])$logins="Высшая сила";	else $logins=$login;
	talk("sys","Представитель порядка <b>&laquo;".$logins."&raquo;</b> предупредил$prefix персонажа <b>&laquo;".$res['login']."&raquo;</b>. $t","");
	talk($res['login'],"Представитель порядка <b>&laquo;".$logins."&raquo;</b> предупредил$prefix вас. $t",$res);
	echo "Персонаж <b>".$res['login']."</b> успешно предупрежден.";
}
?>