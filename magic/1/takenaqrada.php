<?include("key.php");
$login=$_SESSION['login'];
$target=$_POST['target'];
$zoloto=$_POST['zoloto'];
if(!empty($target)&& !empty($zoloto))
{
	$S="select * from users where login='".$target."'";
	$q=mysql_query($S);
	$res=mysql_fetch_array($q);
	if(!$res)
	{
		echo "�������� <B>".$target."</B> �� ������ � ���� ������.";
		die();
	}
	if(!is_numeric($zoloto))
    {
    	echo "����������� ������� �����!";
    	die();
    }
    if($zoloto<0)
    {
    	echo "����������� ������� �����!";
    	die();
    }
	if($zoloto>$res['naqrada'])
    {
    	echo "� ��������� <B>".$target."</B> ��� ����� �����.";
    	die();
    }
    $update=mysql_query("UPDATE users SET naqrada=naqrada-".$zoloto." WHERE login='".$target."'");
    echo "� ��������� <b>".$res['login']."</b> ������� <b>".$zoloto."</b> ��.";
	history($_POST['target'],"������� ".$zoloto." ��.",$reson,$ip,$login);
	history($login,"������ ".$zoloto." ��.",$reson,$ip,$target);
}
?>
