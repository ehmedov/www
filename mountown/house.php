<?
$login=$_SESSION["login"];
//--------------------------------ARENDA----------------------------------------------
if ($_GET["action"]=="arenda")
{
	$result=mysql_query("SELECT * FROM house WHERE login='".$login."'");
	if (!mysql_num_rows($result))
	{
		if ($_GET["type"]==1)
		{	
			if ($db["money"]>=30)
			{	
				$date=date("d.m.y H:i");
				$time=time()+7*24*3600;
				mysql_query("LOCK TABLES house WRITE");
				mysql_query("INSERT into house (login,time,date,type) values('".$login."', '".$time."','".$date."','1')");
				mysql_query("UNLOCK TABLES");
				mysql_query("UPDATE users SET money=money-30 WHERE login='".$login."'");
				$db["money"]=$db["money"]-30;
				$msg="Вы арендовали 'Койку в Гостинице' за 30.00 Зл.";
			}
			else $msg="Недостаточно денег.";
		}
		else if ($_GET["type"]==2)
		{
			if ($db["platina"]>=5)
			{	
				$date=date("d.m.y H:i");
				$time=time()+30*24*3600;
				mysql_query("LOCK TABLES house WRITE");
				mysql_query("INSERT into house (login,time,date,type) values('".$login."', '".$time."','".$date."','2')");
				mysql_query("UNLOCK TABLES");
				mysql_query("UPDATE users SET platina=platina-5 WHERE login='".$login."'");
				$db["platina"]=$db["platina"]-5;
				$msg="Вы арендовали 'Койку в Гостинице' за 5.00 Пл.";
			}
			else $msg="Недостаточно денег.";
		}
		else if ($_GET["type"]==3)
		{
			if ($db["platina"]>=20)
			{	
				$date=date("d.m.y H:i");
				$time=time()+30*24*3600;
				mysql_query("LOCK TABLES house WRITE");
				mysql_query("INSERT into house (login,time,date,type) values('".$login."', '".$time."','".$date."','3')");
				mysql_query("UNLOCK TABLES");
				mysql_query("UPDATE users SET platina=platina-20 WHERE login='".$login."'");
				$db["platina"]=$db["platina"]-20;
				$msg="Вы арендовали 'Койку в Гостинице' за 20.00 Пл.";
			}
			else $msg="Недостаточно денег.";
		}
	}
}
//--------------------------------Close Arenda----------------------------------------------
if ($_GET["closearenda"] && !$db["son"])
{
	$result=mysql_query("SELECT * FROM house WHERE login='".$login."' limit 1");
	if (mysql_num_rows($result))
	{
		mysql_query ("DELETE FROM house WHERE login='".$login."'");
	}
}
//---------------------SLEEP---------------------------------------------------------
if ($_GET["to_sleep"] && !$db["son"])
{
	$result=mysql_query("SELECT * FROM house WHERE login='".$login."' limit 1");
	if (mysql_num_rows($result))
	{
		$res=mysql_fetch_array($result);
		if ($res["time"]>time())
		{
			mysql_query("UPDATE users SET son=1 WHERE login='".$login."'");
			mysql_query("UPDATE effects SET add_time=end_time-".time()." WHERE user_id=".$db["id"]);
			$db["son"]=1;
			Header("Location: main.php?act=none");
			die();
		}
		else
		{
			$msg="Время просрочена...";
		}
	}
}
//--------------------------AWAKE----------------------------------------------------
if ($_GET["to_awake"] && $db["son"])
{
	$result=mysql_query("SELECT * FROM house WHERE login='".$login."' limit 1");
	if (mysql_num_rows($result))
	{
		$res=mysql_fetch_array($result);
	
		mysql_query("UPDATE users SET son=0 WHERE login='".$login."'");
		mysql_query("UPDATE effects SET end_time= add_time+".time().",add_time=0 WHERE user_id=".$db["id"]);
		$db["son"]=0;
		Header("Location: main.php?act=none");
		die();
	}
}
//--------------------------UP DATE----------------------------------------------------
if ($_GET["up_date"])
{
	$result=mysql_query("SELECT * FROM house WHERE login='".$login."' limit 1");
	if (mysql_num_rows($result))
	{
		$res=mysql_fetch_array($result);
		if ($res["time"]<time())
		{
			if ($res["type"]==1)
			{
				if ($db["money"]>=30)
				{
					$time=time()+7*24*3600;
					mysql_query("UPDATE users SET money=money-30 WHERE login='".$login."'");
					mysql_query("UPDATE house SET time='".$time."' WHERE login='".$login."'");
					$db["money"]=$db["money"]-30;
				}
				else $msg="Недостаточно денег.";
			}
			else if ($res["type"]==2)
			{
				if ($db["platina"]>=5)
				{
					$time=time()+30*24*3600;
					mysql_query("UPDATE users SET platina=platina-5 WHERE login='".$login."'");
					mysql_query("UPDATE house SET time='".$time."' WHERE login='".$login."'");
					$db["platina"]=$db["platina"]-5;
				}
			}
			else if ($res["type"]==3)
			{
				if ($db["platina"]>=20)
				{
					$time=time()+30*24*3600;
					mysql_query("UPDATE users SET platina=platina-20 WHERE login='".$login."'");
					mysql_query("UPDATE house SET time='".$time."' WHERE login='".$login."'");
					$db["platina"]=$db["platina"]-20;
				}
			}
		}
	}
}
//--------------------------Zapiska----------------------------------------------------
if ($_POST["savenotes"])
{
	$notes=$_POST["notes"];
	$result=mysql_query("SELECT * FROM house WHERE login='".$login."' limit 1");
	if (mysql_num_rows($result))
	{
		mysql_query("UPDATE house SET zapiska='".$notes."' WHERE login='".$login."'");
	}
}
//--------------------------Pet UnWear----------------------------------------------------
if ($_GET["pet_unwear"])
{
	$_GET["pet_unwear"]=(int)$_GET["pet_unwear"];
	$pet_unwear=mysql_fetch_array(mysql_query("SELECT * FROM house WHERE login='".$login."'"));
	if ($pet_unwear["type"]==3)
	{
		if (!$pet_unwear["zver"])
		{	
			$is_sleep=mysql_fetch_array(mysql_query("SELECT count(*) FROM zver WHERE id=".$_GET["pet_unwear"]." and owner=".$db["id"]." and sleep=0"));
			if ($is_sleep[0])
			{	
				mysql_query("UPDATE house SET zver='".$_GET["pet_unwear"]."' WHERE login='".$login."'");
				mysql_query("UPDATE zver SET sleep=1 WHERE id=".$_GET["pet_unwear"]);
			}
		}
		else
		{
			$msg="Нет мест...";
		}
	}
}
//--------------------------Pet Wear----------------------------------------------------
if ($_GET["pet_wear"])
{
	$pet_wear=mysql_fetch_array(mysql_query("SELECT * FROM house WHERE login='".$login."'"));
	if ($pet_wear["type"]==3)
	{
		if ($pet_wear["zver"])
		{	
			$is_sleep=mysql_fetch_array(mysql_query("SELECT * FROM zver WHERE owner=".$db["id"]." and sleep=0"));
			if (!$is_sleep)
			{	
				mysql_query("UPDATE house SET zver='' WHERE login='".$login."'");
				mysql_query("UPDATE zver SET sleep=0 WHERE id=".$pet_wear["zver"]);
			}
			else 
			{
				mysql_query("UPDATE house SET zver='".$is_sleep["id"]."' WHERE login='".$login."'");
				mysql_query("UPDATE zver SET sleep=1 WHERE id=".$is_sleep["id"]);
				mysql_query("UPDATE zver SET sleep=0 WHERE id=".$pet_wear["zver"]);
			}
		}
	}
}
//------------------------------------------------------------------------------
$platina = sprintf ("%01.2f", $db["platina"]);
$money = sprintf ("%01.2f", $db["money"]);
$naqrada = sprintf ("%01.2f", $db["naqrada"]);
?>
<h3>Гостиница</h3>
<table width=100% cellspacing=0 cellpadding=3>
<tr valign=top class="l3">
	<td>
		<?echo "<script>drwfl('".$db['login']."','".$db['id']."','".$db['level']."','".$db['dealer']."','".$db['orden']."','".$db['admin_level']."','".$db['clan_short']."','".$db['clan']."');</script>";?>
		[У вас в наличии: <B><?echo $money;?></B> Зл. <B><?echo $platina;?></B> Пл. <B><?echo $naqrada;?></B> Ед.]
	</td>
	<td align=right nowrap>
		<input type=button onclick="location.href='main.php?act=go&level=okraina'" value="Выйти на улицу" class=new >
		<input type=button onclick="location.href='main.php?act=none'" value="Обновить" class=new >
	</td>
</tr>
<tr valign=top class="l0">
	<td colspan=2><b>Правила:</b> Нет нападениям. Нет передаче предметов. Нет использованию магии и распитию эликсиров.</td>
</tr>
<tr class="l0">
	<td colspan=2><?echo "<font color=red>".$msg."</font>&nbsp;";?></td>
</tr>
<tr class="l0">
<td colspan=2>
<?
	$result=mysql_query("SELECT * FROM house WHERE login='".$login."' limit 1");
	if (!mysql_num_rows($result))
	{
		echo "Арендовать Койку в Гостинице<BR>
		Цена: <b>30.00 Зл.</b> в неделю<BR>
 		&bull; Койка<BR>
		<A href='?action=arenda&type=1' onclick=\"return confirm('Вы уверены, что хотите заплатить 30 Зл.?')\">Снять комнату</A><HR>";
		
		echo "Арендовать Койку в Гостинице<BR>
		Цена: <b>5.00 Пл.</b> в месяц<BR>
 		&bull; Койка<BR>
		<A href='?action=arenda&type=2' onclick=\"return confirm('Вы уверены, что хотите заплатить 5.00 Пл.?')\">Снять комнату</A><HR>";
		
		echo "Арендовать Койку в Гостинице<BR>
		Цена: <b>20.00 Пл.</b> в месяц<BR>
		&bull; Мест для животных: 1<br>
 		&bull; Койка<BR>
		<A href='?action=arenda&type=3' onclick=\"return confirm('Вы уверены, что хотите заплатить 20.00 Пл.?')\">Снять комнату</A><HR>";	
	}
	else
	{
		$res=mysql_fetch_Array($result);
		echo "<TABLE WIDTH=100% CELLSPACING=1 CELLPADDING=3 class='l3'><tr valign=top class='l0'><td nowrap width=300>";
		echo "Вы арендовали Койку в Гостинице<BR>
		Начало аренды: ".$res['date']."<BR>
		Оплачено до: ".date('d.m.y H:i', $res['time']);
		if($res["time"]<time()){echo "<br><font color=red>Время просрочена...</font> <a href='?up_date=1'><img src='img/icon/plus.gif' border=0 alt='увеличить'></a>";}
		if ($res["type"]==1)echo "<BR>Цена в неделю: <b>30.00 Зл.</b><BR>";
		else if ($res["type"]==2)echo "<BR>Цена в месяц: <b>5.00 Пл.</b><BR>";
		else if ($res["type"]==3)echo "<BR>Цена в месяц: <b>20.00 Пл.</b><BR>&nbsp&bull; Мест для животных: 1<BR>";
		echo "&nbsp&bull; Койка<BR><BR>";
		echo "<A href=\"?closearenda=1\" onclick=\"return confirm('Вы уверены, что хотите прекратить аренду?')\">Прекратить аренду</A><BR>
		<small>При отмене аренды, все вещи из сундука и <br>сувениры переносятся в ваш инвентарь.</small><BR>";
		if ($res["type"]==3)echo "<small><font color=red>Ваши животные выпускаются на волю.</font><small>";
		echo "</td><td width=100%>";
		echo "Вы можете заснуть, забыв о внешнем мире.<BR>
		Во время сна все временные эффекты на вас приостанавливаются. <BR>
		Это касается как, например, эликсиров.<BR>
		Сон не влияет на состояние предметов с ограниченным сроком существования<BR><BR>";
		if (!$db["son"])
		{	
			echo "Состояние: <B>Вы бодрствуете</B><BR>
			<A href=\"?to_sleep=1\" >Уснуть</A><BR>";
		}
		else
		{
			echo "<DIV  class='l3'>
			Состояние: <B>Вы спите</B><BR>
			<A href=\"?to_awake=1\" >Проснуться</A><BR></DIV>";
		}
		echo "</td></tr>";
		echo "</td></tr></table>";
		$res["zapiska"]=str_replace("&amp;","&",$res["zapiska"]);
		$res["zapiska"]=wordwrap($res["zapiska"], 100, " ",1);
		echo "<FORM METHOD=POST>
			Вы находитесь в своей комнате. Первое, что вы видите - записная книжка.<BR>
			Вы можете оставить нужные вам записи общим объемом не более 2048 символов.
			<TEXTAREA rows=10 style='width: 100%;' name='notes'>".$res["zapiska"]."</TEXTAREA><BR>
			<INPUT type='submit' name='savenotes' value='Сохранить текст'>
			</FORM>";
		
		if ($res["type"]==3)
		{
			echo "<TABLE cellpadding=0 cellspacing=0 width=100%>
			<TR>
			<TD align=center>";
				$zver_in=mysql_fetch_array(mysql_query("SELECT id,obraz,name,level FROM zver WHERE id=".$res["zver"]));
				if ($zver_in)
				{
					echo "<B>".$zver_in["name"]."</B> [".$zver_in["level"]."]<br>
					<A href='?pet_wear=1' alt='Забрать'><IMG src='img/".$zver_in["obraz"]."'></A>";
				}
				else 
				{
					echo "<B>свободно</B><br><IMG src='img/obraz/animal/null.gif'>";
				}

			echo "</td><TD align=center>";
				$zver_on=mysql_fetch_array(mysql_query("SELECT id,obraz,name,level FROM zver WHERE owner=".$db["id"]." and sleep=0"));
				if ($zver_on)
				{
					echo "<B>".$zver_on["name"]."</B> [".$zver_on["level"]."]<br>
					<A href='?pet_unwear=".$zver_on["id"]."' alt='Оставить'><IMG src='img/".$zver_on["obraz"]."'></A>";
				}
				else 
				{
					echo "<B>свободно</B><br>
					<IMG src='img/obraz/animal/null.gif'>";
				}
			echo "</TD>
			</TR>";	
			echo "</TABLE>";
		}	
	}
?>
</td>
</tr>
</table>