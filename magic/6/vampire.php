<?include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
if($db["orden"]==6)
{
	if ($db["battle"]=='0')
	{	
		$q=mysql_query("select * from users where login='".$target."'");
		$res=mysql_fetch_array($q);
		if(!$res)
		{
			$err= "�������� <B>".$target."</B> �� ������ � ���� ������.";
		}
		else if($res["login"] == $login)
		{
			$err= "���������� �� ������ ���� - ��� ��� ��������...";
		}
		else if($res["orden"] == 1 || $res["orden"] == 6)
		{
			$err= "��� �������� �� ��������� �� ��������� <B>".$target."</B>";
		}
		else if($res["vampiretime"]!=0)
		{
			$err= "�� �� ������ ������� ���� �� ��������� <B>".$target."</B>. �� ��������� ��� �������� �������� <i>&quot����� ������ ��������&quot</i>";
		}
		else if($res["room"]!=$db["room"])
        {
        	$err= "��� ���������� ��� ���������� ��������� � ����� �������!";
        }
		else if($res["battle"] !='0')
		{
			$err= "�������� <B>".$target."</B> ���������� � ���! ��� �������� �� ��������� �� ��������� !!!";
		}
		else if($res["hp"]<($res["hp_all"]/100)*25)
		{
			$err= "�������� <B>".$target."</B> ������� ��������, ����� ��������� � ���� ��� ����������.";		
		}
		else
		{
			$hp_t = $res["hp_all"];
			$min_dr_hp = floor($hp_t/100);
			$drink_hp = $res["hp"];			
			$tar_allhp = $res["hp_all"];		
			$tar_newhp = 1;
			if ($res["hp"]+$db["hp"]>$db["hp_all"])$drink_hp=$db["hp_all"];
			else 	$drink_hp=$res["hp"];
			
			setHP($login,$drink_hp,$db["hp_all"]);
			setHP($target,$tar_newhp,$tar_allhp);					

			if($db["sex"]=="female"){$pref = "�";}
			else{$pref = "";}
			$err= "�������� ������������ ������. �� ������ ������ ������� �� ��������� &quot$target&quot";
			say($target,"<font color=#40404A>������ ���� <b>&quot$login&quot</b> �����$pref ����� ����� �������!</font>",$target);
		}
	}
	else
	{
		$err= "�� � ���!. �������� �� ���������";
	}	
}
if ($err!="") echo "<font style='color:#ff0000'>$err</font>";

?>
