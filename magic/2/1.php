<?
include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
$rooms=array("casino","smert_room" ,"house","hospital","znaxar","lesopilka","bank","towerin");

if($db["orden"]==2)
{
	if ($db["battle"]=='0')
	{
		$res=mysql_fetch_array(mysql_query("SELECT users.*,effects.end_time FROM users LEFT JOIN effects on effects.user_id=users.id and effects.type='vampire' WHERE users.login='".$target."'"));
		if(!$res)
		{
			$err= "�������� <B>".$target."</B> �� ������ � ���� ������.";
		}
		else if($res["id"] == $db["id"])
		{
			$err= "���������� �� ������ ���� - ��� ��� ��������...";
		}
		else if(($res["orden"] == 2)||($res["orden"] == 1))
		{
			$err= "��� �������� �� ��������� �� ��������� <B>".$target."</B>";
		}
		else if(in_Array($res["room"],$rooms))
        {
        	$err="��� �������� �� ��������� � ���� �������";
        }
		else if($res["room"]!=$db["room"])
        {
        	$err= "��� ���������� ��� ���������� ��������� � ����� �������!";
        }
		else if($res["end_time"]>time())
		{
			$err= "�� �� ������ ������� ���� �� ��������� <B>".$target."</B>. �� ��������� ��� �������� �������� <i>&quot����� ������ ��������&quot</i>";
		}
		else if($res["battle"]!=0)
		{
			$err= "�������� <B>".$target."</B> ���������� � ���! ��� �������� �� ��������� �� ��������� !!!";
		}
		else if($res["hp"]<0.3*$res["hp_all"])
		{
			$err= "�������� <B>".$target."</B> ������� ��������, ����� ��������� � ���� ��� ����������.";		
		}
		else
		{
			$drink_hp = $res["hp"];
			if ($res["hp"]+$db["hp"]>=$db["hp_all"])$drink_hp=$db["hp_all"];
			
			setHP($login, $drink_hp, $db["hp_all"]);
			setHP($target, 1, $res["hp_all"]);

			if($db["sex"]=="female"){$pref = "�";}
			else{$pref = "";}
			$err= "�������� ������������ ������. �� ������ ������ ������� �� ��������� &quot$target&quot";
			say($target,"������ <b>&quot$login&quot</b> �����$pref ����� ����� �������!",$target);
		}
	}
	else
	{
		$err= "�� � ���!. �������� �� ���������";
	}	
}
if ($err!="") echo "<font style='color:#ff0000'>$err</font>";
?>