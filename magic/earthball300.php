<?
$login=$_SESSION['login'];
$mesto=array();
$mesto[0]="������";
$mesto[1]="����";
$mesto[2]="������";
$mesto[3]="����";
$mesto[4]="����";
$mest_txt=$mesto[rand(0,count($mesto)-1)];
$date = date("H:i");

if($db["battle"] && $db["hp"] && $db["battle_opponent"]!="")
{
	$target=$db["battle_opponent"];
	$battle_id = $db["battle"];
	if($db["battle_team"]==1){$span = "p1";$span2 = "p2";}else{$span = "p2";$span2 = "p1";}
	$my_id=$db["id"];
	$phrase ="";
	$if_bot = mysql_fetch_Array(mysql_query("SELECT * FROM `bot_temp` WHERE battle_id='".$db["battle"]."' AND bot_name='".$target."'"));
	if($if_bot)
	{
		if ($if_bot["prototype"]=="������ �����")$lose_hp=3000;else $lose_hp=rand(5000,10000);
		$new_hp=$if_bot["hp"]-$lose_hp;
		if ($new_hp<=0){$new_hp=0;$death="<span class=date>$date</span> <b>".$target." �����</b><br>";}
		$phrase="<span class=date>$date</span> <span class=$span>$login</span> <B style='color:#ff0000'>&#1052;&#1077;&#1090;&#1077;&#1086;&#1088;&#1080;&#1090; <span class=$span2>".$target."</span>, ����� � $mest_txt <span class=krit>-$lose_hp</span>. [".$new_hp."/".$if_bot["hp_all"]."]<br>$death";
		mysql_Query("UPDATE `bot_temp` SET hp=$new_hp WHERE id='".$if_bot["id"]."'");
	}
	else
	{
		$res=mysql_fetch_array(mysql_Query("SELECT * FROM users WHERE login='".$target."'"));
		$lose_hp=rand(1,30);
		$new_hp=$res["hp"]-$lose_hp;
		if ($new_hp<=0){$new_hp=0;$death="<span class=date>$date</span> <b>".$target." �����</b><br>";}
		$phrase="<span class=date>$date</span> <span class=$span>$login</span> ����� ������� � <span class=$span2>".$target."</span>, ����� � $mest_txt <span class=krit>-$lose_hp</span>. [".$new_hp."/".$res["hp_all"]."]<br>$death";
		setHP($res["login"],$new_hp,$res["hp_all"]);
	}
	mysql_query("UPDATE teams SET hitted=hitted+$lose_hp WHERE player='".$login."'");
	mysql_query("UPDATE users SET battle_opponent='' WHERE login='".$login."'");
	battle_log($battle_id, $phrase);
	
	mysql_query("UPDATE inv SET iznos = iznos+1 WHERE id='".$id."'");
	$DAT = mysql_fetch_array(mysql_query("SELECT iznos,iznos_max FROM inv WHERE id = '".$id."'"));
	if($DAT["iznos"]==$DAT["iznos_max"])
	{
		mysql_query("UPDATE users SET slot".$slot."=0 WHERE login='".$login."'");
		mysql_query("DELETE FROM inv WHERE id = '".$id."'");
		say($login, "���������� <b>&laquo;".$name."&raquo;</b> ��������� �����������!", $login);
	}
}
?>