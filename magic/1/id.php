<?$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
if(!empty($target))
{
	$q=mysql_query("SELECT * FROM users WHERE id='".$target."'");
	$res=mysql_fetch_array($q);
	if(!$res)
	{
		echo "�������� �� ������ � ���� ������.";
	}
	else
	{	
		echo $res["login"];
	}
}
?>
