<?include("key.php");
$login=$_SESSION['login'];
$target=$_POST['target'];
$platina=$_POST['platina'];
if(!empty($target)&& !empty($platina))
{
	$S="select * from users where login='".$target."'";
	$q=mysql_query($S);
	$res=mysql_fetch_array($q);
	if(!$res)
	{
		print "�������� <B>".$target."</B> �� ������ � ���� ������.";
		die();
	}
	if(!is_numeric($platina))
    {
    	print "����������� ������� �����!";
    	die();
    }
    if($platina<0)
    {
    	print "����������� ������� �����!";
    	die();
    }
	if($platina>$res['platina'])
    {
    	print "� ��������� <B>".$target."</B> ��� ����� �����.";
    	die();
    }
    $update=mysql_query("UPDATE users SET platina=platina-".$platina." WHERE login='".$target."'");
    print "� ��������� <b>".$res['login']."</b> ������� <b>".$platina."</b> ��.";
	history($_POST['target'],"������� ".$platina." ��.",$reson,$ip,$login);
	history($login,"������ ".$platina." ��.",$reson,$ip,$target);

}
?>
