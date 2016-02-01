<?
$login=$_SESSION["login"];
$now=time();
$frandtime=array(5,60,30,90,25,45,15,36,70,46,55,66,99,111,11,22,33,44);
$palt="Ржавая пила";
$my_prof=mysql_fetch_array(mysql_query("SELECT navika FROM person_proff WHERE person=".$db["id"]." and proff=5"));
$navika=(int)$my_prof["navika"];
//-----------Rabotayem----------------------------------
if ($_POST["mybut".$_SESSION["but_rand"]]) 
{
	if ($my_prof)
	{	
		$randtime_fish=$frandtime[rand(0,count($frandtime)-1)];
		$instrument=mysql_fetch_Array(mysql_query("SELECT * FROM inv WHERE name='".$palt."' and owner='".$login."' and wear=1"));
		if ($instrument)
		{
			if (!$db["r_action"]) 
			{
				if ($instrument["iznos"]< $instrument["iznos_max"] ) 
				{
					mysql_query("UPDATE inv SET iznos=iznos+1 WHERE id='".$instrument['id']."'");
				}
				else 
				{
					$damage=$instrument["id"];
					unWear($login,$damage);
	            	mysql_query("DELETE FROM inv WHERE id='".$damage."'");
	                history($login,"Пришел в негодность","Ржавая пила",$db["remote_ip"],"Центральная лесопилка");
	                talk($login,"<b>Ржавая пила</b> сломался...",$db);
				}
				mysql_query("UPDATE users SET for_time=$now+$randtime_fish, r_action=1 where login='".$login."'");
				$db["for_time"]=$now+$randtime_fish;
				$db["r_action"]=1;
			} else $msg = "Вы добываете древесину!";
		} else $msg="Вам необходима пила...";
	} else $msg="У вас нет профессии Лесоруба...";
 }
// ----------End-----------------------------
if ($db["r_action"]) 
{
	if ($db["for_time"]-2 < $now) 
	{
		$r=rand(1,2);
		if ($r == 1) 
		{
			$randomize=rand(1,10);
			$ww=mysql_fetch_array(mysql_query("SELECT id,name FROM wood WHERE id='".$randomize."' limit 1"));
			mysql_query("INSERT INTO `inv` (`owner`, `object_id`, `object_type`, `object_razdel` ,`iznos`,  `iznos_max`, `wear`) VALUES 	('".$login."', '".$ww["id"]."','wood','thing','0','1','0');");
			mysql_query("UPDATE `person_proff` SET navika=navika+1 WHERE person='".$db["id"]."' and proff=5");
			$db['for_time'] = 0;
			$db['r_action'] = 0;
			$navika =$navika+1;
			talk($login,"Поздравляем. Вы добыли <b>&laquo;".$ww["name"]."&raquo;</b> в кол-ве <b>1 ед.</b>",$db);
			mysql_query("UPDATE daily_kwest SET taked=taked+1 WHERE user_id='".$db['id']."' and kwest_id=6");//daily kwest
		}
		else 
		{
			$db['for_time'] = 0;
			$db['r_action'] = 0;
			talk($login,"Вам не очень повезло и вы ничего не добыли, попробуйте в другой раз!",$db);
		}
		mysql_query("UPDATE `users` SET for_time=0, r_action=0 WHERE login='".$login."'");
	}
}
$_SESSION["but_rand"]=time();
echo"
<script src='time.js'></script>
<h3>Центральная лесопилка</h3>
<table width=100% cellspacing=0 cellpadding=5 border=0>
<tr>
<td width=200>Навык Лесоруба: <b>".$navika."</b></td>
<td align=center><font color=red><b>".$msg."</b></font></td>	
<td width=200 align=right nowrap>
<input type=button onclick='document.location=\"main.php?act=go&level=nature\"' value='Вернуться' class=input>
<input type=button onClick=\"location.href='?tmp=$now'\" value='Обновить' class=inup >
</td>
</tr>
</table>

<form  method='POST' action='main.php'>
	<table width=100% cellspacing=0 cellpadding=3 border=0>
	<tr>
		<td align=center>
			<img src='img/city/sawmill.jpg'>
			<table cellspacing=0 cellpadding=5>
			<tr>
			<td align=center >
					<input type=submit class=newbut value='Рубка древесины' style='' name='mybut".$_SESSION["but_rand"]."'>
			</td></tr>
			</table>";
			if ($db["for_time"]>$now)
			{
				echo "<table cellspacing=0 cellpadding=3>
				<tr>
					<td>Оставшееся время работы: <b id=know></b></td>
				</tr>
				</table>
				<script>ShowTime('know',",($db['for_time']-$now),",1);</script>
				<META HTTP-EQUIV=\"Refresh\" CONTENT=\"".($db['for_time']-1-$now)."; URL=main.php\">";
			}
			echo"
		</td>
	</tr>
	</table>
</form>";
?>