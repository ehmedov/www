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
    	echo "�������� <B>".$target."</B> ���������� � ���!";
    }
    else 
    {
	    setHP($data["login"],$data['hp_all'],$data['hp_all']);    
		echo "HP ��������� <b>".$data["login"]."</b> ������� �������������!";
	}
}
?>