<?include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
$noname=$_POST['noname'];
if(!empty($target))
{	
	$QUERY=mysql_query("SELECT * FROM users WHERE login='".$target."'");
	$data=mysql_fetch_array($QUERY);
	if($data["battle"]!=0)
    {
    	print "�������� <B>".$target."</B> ���������� � ���!";
    	die();
    }
    setMN($target,$data['mana_all'],$data['mana_all']);    
	$pref=$db["sex"];
	if($pref=="female")
	{
		$prefix="�";
	}
	else
	{
		$prefix="";
	}
    if($noname==""){$noname_cl="����� <b>&laquo;$login&raquo;</b>";}
    else if($noname==1){$noname_cl="<i><b>&laquo;�����������&raquo;</i></b>";}
	say("toall","$noname_cl �����������$prefix MANA ��������� <b>&laquo;".$target."&raquo</b>",$login);
	print "MANA ��������� <b>".$target."</b> ������� �������������!";
}
?>