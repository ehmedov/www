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
    	echo "Вы не ввели причину отказа!<BR>";
    }
    else
    {
    	$msg = "Здраствуйте, ув. $glava!<br>";
        $msg .= "Отдел регистрации кланов рассмотрел Вашу заявку и отказал Вам по причине:<br><br>";
        $msg .= "---------------------------------------<br>";
        $msg .= "$otkaz_msg<br>";
        $msg .= "---------------------------------------<br><br>";
        $msg .= "Если Вы несогласны с решением отдела, обратитесь на форум в соответствующий раздел.<br>";
        $msg .= "С Уважением Отдел регистрации кланов.<br>";
        
    	mysql_query("INSERT INTO pochta(user,whom,text,subject) VALUES ('".$db["login"]."','".$glava."','".$msg."','Отдел регистрации кланов(Отказ)')");
		mysql_query("DELETE FROM clan_zayavka WHERE name_short='".$clan_s."'");
        echo "Заявка на создание клана $name отказана.";
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
		$msg = "Здраствуйте, ув. $glava!<br>";
		$msg .= "Oтдел регистрации кланов рассмотрел Вашу заявку и подтвердил ее. Вы и прошли проверку и клан зарегистрирован. Изменять информацию о Вашем клане Вы можете в разделе \"Клан\" в подразделе \"Главенство\".Также Вы можете принимать/исключать игроков, прошедших проверку.<br><br>";
		$msg .= "С Уважением Oтдел регистрации кланов.<br>";
    	mysql_query("INSERT INTO pochta(user,whom,text,subject) VALUES ('".$db["login"]."','".$glava."','".$msg."','Отдел регистрации кланов')");
		mysql_query("INSERT INTO clan(name,name_short,glava,site,story,orden,creator) VALUES('".$name."','".$name_short."','".$glava."','".$site."','".$history."','".$orden."','".$GL_DATA["id"]."')");
		mysql_query("UPDATE users SET clan='".$name."',clan_short='".$name_short."',orden='".$orden."',glava='1',clan_take='1',platina=platina-$pl,chin='ГЛАВА ХАНСТВА' WHERE login='".$glava."'");
		mysql_query("DELETE FROM clan_zayavka WHERE name_short='$clan_s'");	
		echo "Заявка на создание клана $name подтверждена.";
	}
	else
	{
		echo "<font color=red>Суммы на счету <B>".$glava."</B> недостаточно для регистрации клана.</font>";
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
	echo "<td bgcolor=#dcdcdc>$i. Название Кланa  <B>$name</B><BR>";
	echo "Сайт: <a href='$site' class=us2>$site</a><BR>";
	echo "Орден: <img src='img/orden/$orden/0.gif'><BR>";
	echo "Значек: <img src='$znak'><BR>";
	echo "История:<BR>$history<BR>";
	echo "<B>ГЛАВА КЛАНА:</B><BR>";
	echo "Глава: <B>$glava</B> <a href='info.php?log=$glava' target=$glava><img src='img/h.gif' border=0></a> <I>[<B>$glava_fio</B>]</I><BR>";
	echo "Дата подачи заявки: $date<BR>";
	echo "<form action='main.php?act=inkviz&spell=10&conf=0&clan_s=$name_short&glava=$glava' name='otkaz' method=\"POST\">Отказать:<BR>";
	echo "<textarea class=new name='otkaz_msg' cols=40 rows=5></textarea><BR><input type=submit class=but value=\"Отказать\"></form>";
	echo "<input type=button class=but value=\"Подтвердить заявку\" onClick=\"javascript:location.href='main.php?act=inkviz&spell=10&conf=1&clan_s=$name_short&glava=$glava'\">";
	echo "</td>";
	echo "</tr></table><BR>";
	$i++;
}
if($i == 0)
{
	echo "<br>Нет заявок на регистрацию клана.";
}
?>
