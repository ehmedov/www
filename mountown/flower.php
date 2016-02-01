<?
include_once("inc/shop/otdels_f.php");
$login=$_SESSION['login'];

$buy=(int)$_GET['buy'];
if (isset($_GET['otdel']))
{	
	$otdel=htmlspecialchars(addslashes($_GET['otdel']));
	$_SESSION['otdel']=$otdel;
}
else 
{
	if (isset($_SESSION['otdel']))
	{
		$otdel=$_SESSION['otdel'];
	}
}

$present_user=htmlspecialchars(addslashes(trim($_POST['target'])));
$present_text=htmlspecialchars(addslashes($_POST['present_text']));
$present_who=intval($_POST['present_who']);

$ip=$db["remote_ip"];
$city=$db["city_game"];

echo "
<DIV ID=form style='position:absolute; visibility:hidden'></DIV>
<SCRIPT LANGUAGE=\"JavaScript\">
<!--
function present (id, title,type) 
{
    var x, y, obj;
    obj = document.getElementById('f_'+id);
    for(i=obj, x=0, y=0; i; i = i.offsetParent)
    {
        x += i.offsetLeft;
        y += i.offsetTop;
    }
    form.style.left = x+115;
    form.style.top = y-100;
    document.all('form').style.visibility= 'visible';
    document.all('form').innerHTML= '<table cellspacing=0 cellpadding=0 bgcolor=ffffff align=center><tr><td><table width=100% cellspacing=1 cellpadding=3 class=\"podskazka\"><FORM action=\'?buy='+type+'&item='+id+'\' method=POST><tr><td colspan=2 align=center><b><span onClick=\'closeform();\' style=\'cursor:hand\'><img src=\'img/del.gif\'></span> Сделать подарок...</b></td></tr><tr><td style=\'BORDER-RIGHT: 0px; BORDER-BOTTOM: 0px; padding-left:7;\'>Подарить персонажу</td><td style=\'BORDER-LEFT: 0px; BORDER-BOTTOM: 0px; padding-right:7;\' align=right><input type=text class=input size=32 name=target></td></tr><tr><td style=\'BORDER-RIGHT: 0px; BORDER-BOTTOM: 0px; BORDER-TOP: 0px; padding-left:7;\'>с пожеланием</td><td style=\'BORDER-LEFT: 0px; BORDER-BOTTOM: 0px; BORDER-TOP: 0px; padding-right:7;\' align=right><input type=text class=input size=32 name=present_text></td></tr><tr><td colspan=2 style=\'BORDER-TOP: 0px; padding-left:7;\'><table width=100% cellspacing=0 cellpadding=0 border=0><TR><TD width=70>от имени:</TD><TD><INPUT TYPE=HIDDEN name=present_id value=\''+id+'\'><input type=radio checked name=present_who value=1> <b>".$db['login']."</b><BR>";
    if ($db['clan']) echo"<input type=radio name=present_who value=2> Клан <b><img src=\'img/clan/".$db['clan_short'].".gif\'>".$db['clan']."</b><BR>";
    echo"</TD></TR></TABLE></td></tr><tr><td colspan=2 align=center><input type=submit value=\'Подарить\' name=\'present_submit\' class=input style=\'WIDTH: 308px\'></td></tr></FORM></table></td></tr></table>';
}
function closeform()
{
	document.all('form').style.visibility='hidden'; 
}
//-->
</SCRIPT>";	
if(isset($buy) && is_numeric($_GET['item']))
{
	if($present_user==""){$present_user=$login;}
	$item=intval($_GET['item']);
	$pr_user=mysql_fetch_array(mysql_query("SELECT id, login FROM users WHERE login='".$present_user."'"));
	if ($pr_user)
	{	
		$DATA = mysql_fetch_array(mysql_query("SELECT * FROM `flower` WHERE id = '".addslashes($item)."' and type=".$buy." and mountown>0"));
		if (!$DATA)
		{
			$mess="Вещь не найдена в магазине.";
		}
		else
		{	
			$price_gos = $DATA["price"];
			$price     = sprintf ("%01.2f", $price_gos);
			$is_art = $DATA["art"];
			$term= time() + $DATA["term"]*86400;
			
			if ($is_art){$my_money=$db["platina"];$money_type="Пл.";}
			else {$my_money=$db["money"];$money_type="Зл.";}
			
			if($db["level"]<2)
			{
				$mess="К персонажам до 2-го уровня подарит подарки запрещены!";
			}
			else if($my_money<$price_gos)
			{
				$mess="У вас нет такой суммы!";
			}
			else
			{
				switch ($present_who) 
				{
	                case 1: $present_who = $login; break;
	                case 2: $present_who = "Клан ".$db["clan"]; break;
				}
				mysql_query("LOCK TABLES inv WRITE");
				mysql_query("INSERT INTO inv(owner,object_id,object_type,object_razdel,term,msg,gift,gift_author,wear) VALUES ('".$pr_user["login"]."','".$item."','flower','other','".$term."','".$present_text."','1','".$present_who."','0')");
				mysql_query("UNLOCK TABLES");
				mysql_Query("UPDATE flower SET mountown=mountown-1 WHERE id=".$item);
				if ($is_art)
				{
					mysql_query("UPDATE users SET  platina=platina-$price WHERE login='".$login."'");
					$db["platina"]=$db["platina"]-$price;
				}
				else
				{
					mysql_query("UPDATE users SET  money=money-$price WHERE login='".$login."'");
					$db["money"]=$db["money"]-$price;
				}
				if ($pr_user["id"]!=$db["id"])
				{
					mysql_query("UPDATE daily_kwest SET taked=taked+1 WHERE user_id='".$db['id']."' and kwest_id=5");//daily kwest
				}
				$name=$DATA["name"];
				$mess="Вы удачно купили &laquo;$name&raquo; за $price $money_type.";
				$name2="$name ($price $money_type), От имени: <b>$present_who</b>, С пожеланием: <b>$present_text</b>";
				$name3="$name ($price $money_type), От имени: <b>$login</b>, С пожеланием: <b>$present_text</b>";
				history($login,'Подарил персонажу '.$pr_user["login"],$name2,$ip,'Магазин подарков');
				history($pr_user["login"],'Подарили',$name3,$ip,'Магазин подарков');
				say($pr_user["login"],"<b>$present_who</b> подарил вам <b>&laquo;$name&raquo;</b> наверное это что-то значит...",$login);
				$otdel=$buy;
			}
		}
	}
	else $mess="Персонаж <B>".$present_user."</B> не найден в базе данных.";
}
if (!isset($otdels[$otdel])){$otdel=1;}
$money = sprintf ("%01.2f", $db["money"]);
$platina = sprintf ("%01.2f", $db["platina"]);
?>
<h3>Магазин подарков</h3>
<table border=0 width=100%>
<tr>
	<td colspan=2>
	<table width=100%><tr>
		<td><font color=#ff0000><?=$mess?>&nbsp;</font></td>
		<td nowrap align=right>
			У вас в наличии: <B><?echo $money;?></b> Зл. <b><?echo $platina;?></b> Пл.
		</td>
	</tr></table>			
	</td>
</tr>
<tr>
<td width=180 valign=top>
	<table width="100%" cellspacing="1" cellpadding="3" class="l3"  height=20>
		<tr><td align="center"><b>Отделы магазина</b></td></tr>
	</table>
	<br>
	<table class="l3" width="180" cellspacing="1" cellpadding="3">
    <tr class="l0">
        <td>
			<INPUT type=button style="width:100%; cursor:hand" onclick="location.href='main.php?act=go&level=municip'" value="Выход" class="newbut">	
        </td>
    </tr>
	</table>
	<br>	  	  
	<table class="l3" width="180" cellspacing="1" cellpadding="3">
    <tr class="l0">
        <td>
				&nbsp;<a href='?otdel=1'>Цветы</a><br>
				&nbsp;<a href='?otdel=2'>Открытки</a><br>
				&nbsp;<a href='?otdel=3'>Аксессуары</a><br>
				&nbsp;<a href='?otdel=4'>Подарки</a><br>
				&nbsp;<a href='?otdel=5'>Национальные</a><br>
				&nbsp;<a href='?otdel=6'>Новогодние</a><br>
				&nbsp;<a href='?otdel=7'>Валентинки</a><br>
				&nbsp;<a href='?otdel=9'>Летние подарки</a><br>
        </td>
    </tr>
	</table>
	<br>
	<table class="l3" width="180" cellspacing="1" cellpadding="3">
    <tr class="l0">
        <td>
				&nbsp;<a href='?otdel=8'>Уникальные подарки</a><br>
        </td>
    </tr>
	</table>
</td>
<td valign=top width=100%>	
	<table border=1  width=700  cellpadding=5 cellspacing=0 align=center>
	<TABLE width=100% cellspacing=1 cellpadding=5 class="l3">
	<tr>
		<td valign=center align=center colspan=2>
			<b>Отдел: "<?=$otdels[$otdel]?>"</B>
		</td>
	</tr>
	<?
	$seek=mysql_query("SELECT * FROM flower WHERE mountown>0  and type=$otdel ORDER BY price ASC");
	if (mysql_num_rows($seek))
	{
		while($DATA = mysql_fetch_array($seek))
		{	
			$id         = $DATA["id"];
			$img        = $DATA["img"];
			$name       = $DATA["name"];
			$price = $DATA["price"];
			$price_gos  = sprintf ("%01.2f", $price);
			$mass       = $DATA["mass"];
			$term       = $DATA["term"];
			$nums       = $DATA["mountown"];
			$is_art       = $DATA["art"];

			$n=(!$n);
			echo "<tr class='".($n?'l0':'l1')."'><td align=center valign=center width=150 nowrap>";
			echo "<img src='img/$img' alt='$name'><BR>";
			echo "<a onclick=\"present(".$id.",'".$name."','".$otdel."');\" style='CURSOR: Hand' id='f_".$id."'>Подарить</a>";
			echo "</td>";
			echo "<td valign=top nowrap>";
			echo "<a style='color: #252525'>".$name."</a> (Масса: ".$mass.")<BR>";
			if ($is_art){$my_money=$db["platina"];$money_type="Пл.";}
			else {$my_money=$db["money"];$money_type="Зл.";}
			if($price<=$my_money)
			{
				echo "<b>Цена: ".$price_gos." ".$money_type."</b>";
			}
			else
			{
				echo "<b style='color:#ff0000'>Цена: ".$price_gos." ".$money_type."</b>";
			}
			echo " (Осталось: ".$nums." шт.)";
			echo "<br>Срок жизни: $term дн.<BR><BR>";
			echo "<small><font color=brown>Предмет не подлежит ремонту</font></small>";
			echo "</td></tr>";	
		}
	}
	else echo "<TR><TD class='l0' align=center><b>Прилавок магазина пустой</b></td></tr>";
	mysql_free_result($seek);
	echo "</table>";
	echo "<br>";
?>
</td>
</tr>
</table>
<br><br><br><br>
<?include_once("counter.php");?>