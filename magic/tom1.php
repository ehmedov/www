<?
session_start();
$login=$_SESSION['login'];
$spell=$_GET['spell'];	
$have_tom=mysql_fetch_array(mysql_query("SELECT * FROM slots_priem WHERE user_id=".$db["id"]." and sl_name='sl9'"));
if ($have_tom)
{
	$_SESSION["message"]="�� ��� ������� ���� ���!";
}
else
{
	$proff=array();
	$sql=mysql_query("SELECT proff,title,navika FROM person_proff LEFT JOIN academy on academy.id=person_proff.proff WHERE person=".$db["id"]." and proff in (1,5)");
	while($res=mysql_fetch_array($sql))
	{
		$proff[$res["title"]]=$res["navika"];
	}	

	if ($proff["�������"]<0)$_SESSION["message"]="��������� ������� �������� 0. �� ������� ".(0-$proff["�������"])."!";
	else if ($proff["�����"]<0)$_SESSION["message"]="��������� ������� ������ 0. �� ������� ".(0-$proff["�����"])."!";
	else
	{
		mysql_query("INSERT INTO slots_priem (user_id,sl_name) values (".$db["id"].",'sl9')");
		$_SESSION["message"]="�� ������ ������������ ���������� <b>&laquo;".$name."&raquo;</b>";
		drop($spell,$DATA);
	}
}
echo "<script>location.href='main.php?act=inv&otdel=magic'</script>";
die();
?>