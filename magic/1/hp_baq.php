<?include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
$noname=$_POST['noname'];
if(!empty($target))
{	
	$data=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE login='".$target."'"));
	if(!$data)
    {
    	echo "�������� <B>".$target."</B> �� ������ � ���� ������.";
    }
    else if($data["battle"] || $data["zayavka"])
    {
    	echo "�������� <B>".$target."</B> � ��� ��� � ������. �����...";
    }
    else 
    {
    	$have_jj=mysql_fetch_Array(mysql_query("SELECT add_hp FROM effects WHERE user_id=".$data["id"]." and type='jj'"));
		$res=mysql_fetch_array(mysql_query("SELECT SUM(add_hp) FROM inv WHERE owner='".$data["login"]."' and wear=1 and object_razdel='obj'"));
		mysql_query("UPDATE users SET hp_all=".(int)$res[0]."+power*6+".(int)$have_jj["add_hp"]." WHERE login='".$data["login"]."'");
		echo "HP ��������� <b>".$data["login"]."</b> ������� �������������!";
	}
}
?>