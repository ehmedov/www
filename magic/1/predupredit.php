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
		echo "�������� <B>".$target."</B> �� ������ � ���� ������.";
		die();
	}
	if ($db["adminsite"]!=5)
	{	
		if($res['adminsite']>=5 ||$res["admin_level"]>=9)
		{
			echo "�������������� ����� ��������� ������ �����!";
			die();
		}
	}
	$pref=$db["sex"];
	if($pref=="female")
	{
		$prefix="�";
	}
	else
	{
		$prefix="";
	}
	if (!empty($text)) $t="<b>�������:</b> <i>".$text."!</i>";else $t="";
	if($db["adminsite"])$logins="������ ����";	else $logins=$login;
	talk("sys","������������� ������� <b>&laquo;".$logins."&raquo;</b> �����������$prefix ��������� <b>&laquo;".$res['login']."&raquo;</b>. $t","");
	talk($res['login'],"������������� ������� <b>&laquo;".$logins."&raquo;</b> �����������$prefix ���. $t",$res);
	echo "�������� <b>".$res['login']."</b> ������� ������������.";
}
?>