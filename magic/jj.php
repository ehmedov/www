<?
$login=$_SESSION['login'];
if($db["battle"])
{
	say($login, "�� �� ������ ��������� ��� �������� �������� � ���!", $login);
}
else
{	
	$target=htmlspecialchars(addslashes($_REQUEST['target']));
	$res=mysql_fetch_array(mysql_query("SELECT users.*, (SELECT count(*) FROM online WHERE login='".$target."') as online  FROM users WHERE login='".$target."'"));
	if(!$res)
	{
		$_SESSION["message"]="�������� ".$target." �� ������.";
	}
	else if(!$res["online"] || ($res["login"]=="bor" && !$db["adminsite"]))
	{
		$_SESSION["message"]="�������� ".$res["login"]." ������ ���-����.";
	}
	else if($res["room"]=="house")
	{
		$_SESSION["message"]="�������� ".$res["login"]." ������ � ���������.";
	}
	else if($res["zayavka"])
	{
		$_SESSION["message"]="�������� <B>".$target."</B> ���������� � ���! ��� �������� �� ��������� �� ��������� !!!";
	}
	else
	{
		switch ($mtype)
		{
			case "jj1": $hp_add = $res["power"]*2; 	break;
			case "jj2": $hp_add = $res["power"]*4; 	break;
			case "jj3": $hp_add = $res["power"]*6; 	break;
			case "jj4": $hp_add = $res["power"]*8; 	break;
			case "jj5": $hp_add = $res["power"]*10; break;
			case "jj6": $hp_add = $res["power"]*12; break;
		}
		$zaman=time()+2*3600;
		$type="jj";
		$have_elik=mysql_fetch_Array(mysql_query("SELECT * FROM effects WHERE user_id=".$res["id"]." and type='".$type."'"));
		if (!$have_elik)
		{
			mysql_query("UPDATE users SET hp_all=hp_all+".$hp_add." WHERE login='".$res["login"]."'");
			setMN($login,$db["mana"]-$mana,$db["mana_all"]);

			mysql_query("INSERT INTO effects (user_id,type,elik_id,add_hp,end_time) VALUES ('".$res["id"]."','$type','$elik_id','$hp_add','$zaman')");
			$_SESSION["message"]="�� ������ ������������ ���������� <b>&laquo;".$name."&raquo;</b> �� ��������� ".$res["login"].".";
			if($db["adminsite"])$logins="������ ����";
			else $logins=$db["login"];
			if($res["adminsite"])$res["login"]="������ ����";
			say("toall_news","���� <b>".$logins."</b> ������ ����������� ������ <b>&laquo;".$name."&raquo;</b> �� ��������� <b>".$res["login"]."</b>",$db["login"]);
			drop($spell,$DATA);
		}
		else
		{
			$_SESSION["message"]="�������� ��� ����������� ��� ��������...";
		}
	}
}
echo "<script>location.href='main.php?act=inv&otdel=magic'</script>";
?>