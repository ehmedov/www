<?
$conf=$_GET['conf'];
$otkaz_msg=htmlspecialchars(addslashes($_POST['otkaz_msg']));
$glava=$_GET['glava'];
$clan_s=$_GET['clan_s'];
$pl=2000;

if($conf == ''){$conf="2";}

if($conf == 0)
{
    if($otkaz_msg=="")
    {
    	echo "�� �� ����� ������� ������!<BR>";
    }
    else
    {
    	$msg = "�����������, ��. $glava!<br>";
        $msg .= "����� ����������� ������ ���������� ���� ������ � ������� ��� �� �������:<br><br>";
        $msg .= "---------------------------------------<br>";
        $msg .= "$otkaz_msg<br>";
        $msg .= "---------------------------------------<br><br>";
        $msg .= "���� �� ���������� � �������� ������, ���������� �� ����� � ��������������� ������.<br>";
        $msg .= "� ��������� ����� ����������� ������.<br>";
        
    	mysql_query("INSERT INTO pochta(user,whom,text,subject) VALUES ('".$db["login"]."','".$glava."','".$msg."','����� ����������� ������(�����)')");
		mysql_query("DELETE FROM clan_zayavka WHERE name_short='".$clan_s."'");
        echo "������ �� �������� ����� $name ��������.";
	}
}
else if($conf == 1)
{
    $GL_DATA = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE login='".$glava."'"));
    $g_money = $GL_DATA["platina"];

	$S2 = mysql_query("SELECT * FROM clan_zayavka WHERE name_short='".$clan_s."'");
	$DATS = mysql_fetch_array($S2);
	$name = $DATS["name"];
	$name_short = $DATS["name_short"];
	$site = $DATS["site"];
	$history = $DATS["history"];
	$orden = $DATS["orden"];
	$sovet1 = $DATS["sovet1"];
	$sovet2 = $DATS["sovet2"];
	if ($g_money>=$pl)
	{	
		$msg = "�����������, ��. $glava!<br>";
		$msg .= "O���� ����������� ������ ���������� ���� ������ � ���������� ��. �� � ������ �������� � ���� ���������������. �������� ���������� � ����� ����� �� ������ � ������� \"����\" � ���������� \"����������\".����� �� ������ ���������/��������� �������, ��������� ��������.<br><br>";
		$msg .= "� ��������� O���� ����������� ������.<br>";
    	mysql_query("INSERT INTO pochta(user,whom,text,subject) VALUES ('".$db["login"]."','".$glava."','".$msg."','����� ����������� ������')");
		mysql_query("INSERT INTO clan(name,name_short,glava,site,story,orden,creator) VALUES('".$name."','".$name_short."','".$glava."','".$site."','".$history."','".$orden."','".$GL_DATA["id"]."')");
		mysql_query("UPDATE users SET clan='".$name."',clan_short='".$name_short."',orden='".$orden."',glava='1',clan_take='1',platina=platina-$pl,chin='����� �������' WHERE login='".$glava."'");
		mysql_query("DELETE FROM clan_zayavka WHERE name_short='$clan_s'");	
		echo "������ �� �������� ����� $name ������������.";
	}
	else
	{
		echo "<font color=red>����� �� ����� <B>".$glava."</B> ������������ ��� ����������� �����.</font>";
	}
}

$i = 0;
$S = mysql_query("SELECT * FROM clan_zayavka");
while($DATA = mysql_fetch_array($S))
{
	$name = $DATA["name"];
	$name_short = $DATA["name_short"];
	$site = $DATA["site"];
	$znak = $DATA["znak"];
	$history = $DATA["history"];
	$orden = $DATA["orden"];
	$glava = $DATA["glava"];
	$glava_fio = $DATA["glava_fio"];
	$sovet1 = $DATA["sovet1"];
	$sovet1_fio = $DATA["sovet1_fio"];
	$sovet2 = $DATA["sovet2"];
	$date = $DATA["date"];		


	echo "<table border=0 class=new width=700 bgcolor=#dcdcdc><TR bgcolor=#dcdcdc>";
	echo "<td bgcolor=#dcdcdc>$i. �������� ����a  <B>$name</B><BR>";
	echo "����: <a href='$site' class=us2>$site</a><BR>";
	echo "�����: <img src='img/orden/$orden/0.gif'><BR>";
	echo "������: <img src='$znak'><BR>";
	echo "�������:<BR>$history<BR>";
	echo "<B>����� �����:</B><BR>";
	echo "�����: <B>$glava</B> <a href='info.php?log=$glava' target=$glava><img src='img/h.gif' border=0></a> <I>[<B>$glava_fio</B>]</I><BR>";
	echo "���� ������ ������: $date<BR>";
	echo "<form action='main.php?act=inkviz&spell=10&conf=0&clan_s=$name_short&glava=$glava' name='otkaz' method=\"POST\">��������:<BR>";
	echo "<textarea class=new name='otkaz_msg' cols=40 rows=5></textarea><BR><input type=submit class=but value=\"��������\"></form>";
	echo "<input type=button class=but value=\"����������� ������\" onClick=\"javascript:location.href='main.php?act=inkviz&spell=10&conf=1&clan_s=$name_short&glava=$glava'\">";
	echo "</td>";
	echo "</tr></table><BR>";
	$i++;
}
if($i == 0)
{
	echo "<br>��� ������ �� ����������� �����.";
}
?>
