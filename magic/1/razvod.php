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
		echo  "�������� <B>".$target."</B> �� ������.";
	}
	else if($res["marry"]=="")
	{
		echo  "�������� <b>".$target."</b> �� ".(($res["sex"]=='female')?'�������':'�����').".";
	}
	else 
	{
		$info=mysql_fetch_array(mysql_query("SELECT users.id FROM users LEFT JOIN info on info.id_pers=users.id WHERE login='".$res['marry']."'"));
		$result1 = mysql_query("UPDATE info SET marry='' WHERE id_pers='".$info['id']."'");
		$result2 = mysql_query("UPDATE info SET marry='' WHERE id_pers='".$res['id']."'");
		if($db["adminsite"])$logins="������ ����";else $logins=$login;
		$text="������������� ������� <b>&laquo;".$logins."&raquo;</b> ��������".(($db['sex']=='female')?'�':'')." ������� ��� <b>&laquo;".$res["login"]."&raquo</b> � <b>&laquo;".$res['marry']."&raquo.</b>";
		talk("toall",$text,"");
		echo  "���������� ������ <b>".$res["login"]."</b> � <b>".$res["marry"]."</b>.";
	}
}
?>