<?include("key.php");
$target=htmlspecialchars(addslashes($_POST['target']));
$login=$_SESSION['login'];
$noname=$_POST['noname'];
if(!empty($target))
{
	$QUERY=mysql_query("SELECT * FROM users WHERE login='".$target."'");
	$data=mysql_fetch_array($QUERY);
	if ($data["travm"]!='0')
	{	
		$t_stat = $data["travm_stat"];
		$o_stat = $data["travm_old_stat"];	
	    $SQ = mysql_query("UPDATE users SET $t_stat=$t_stat+$o_stat,travm='0', travm_stat='', travm_var='', travm_old_stat='' WHERE login='".$target."'");
	    
		$pref=$db["sex"];
		if($pref=="female")
		{
			$prefix="�";
		}
		else
		{
			$prefix="";
		}
	    if($noname==""){$noname_cl=$login;}
	    else if($noname==1){$noname_cl="������ ����";}

		say("toall","������������� ������� <b>&laquo;".$noname_cl."&raquo;</b> �������$prefix ��������� <b>&laquo;".$target."&raquo;</b>",$login);
		echo "�������� <b>".$target."</b> ������ ������.";
		history($target,"��������",$reson,$data["remote_ip"],$noname_cl);
		history($login,"�������",$reson,$db["remote_ip"],$target);

	}
	else
	{
		echo "�������� <b>".$target."</b> �� �����������.";
	}
}
?>