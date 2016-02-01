<?
include("key.php");
$login=$_SESSION['login'];
$login_bot=htmlspecialchars(addslashes($_POST['login_bot']));
$password=$_POST['password'];
$password = base64_encode($password);
$level=(int)$_POST['level'];
$obraz=htmlspecialchars(addslashes($_POST['obraz']));
$sex=htmlspecialchars(addslashes($_POST['sex']));

$level_array[1]=array(165,410);
$level_array[2]=array(535,1300);
$level_array[3]=array(1455,2500);
$level_array[4]=array(2905,5000);
$level_array[5]=array(6005,12500);
$level_array[6]=array(14005,30000);
$level_array[7]=array(60005,300000);
$level_array[8]=array(400005,3000000);
$level_array[9]=array(6000005,10000000);
$level_array[10]=array(13000005,52000000);
$level_array[11]=array(55000005,120000000);


if ($_POST["login_bot"])
{
	$res=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE login='".$login_bot."'"));
	if(!$res)
	{
		echo  "Персонаж <B>$login_bot</B> не найден в базе данных.";
	}
	else
	{
		if ($_POST["edit_bot"])
		{
			mysql_query("UPDATE users SET sila='".$_POST["sila"]."', lovkost='".$_POST["lovkost"]."', udacha='".$_POST["udacha"]."', power='".$_POST["power"]."', hp='".$_POST["hp_all"]."', hp_all='".$_POST["hp_all"]."',
			krit='".$_POST["krit"]."', akrit='".$_POST["akrit"]."', uvorot='".$_POST["uvorot"]."', auvorot='".$_POST["auvorot"]."',
			parry='".$_POST["parry"]."', counter='".$_POST["counter"]."', proboy='".$_POST["proboy"]."', ms_udar='".$_POST["ms_udar"]."', ms_krit='".$_POST["ms_krit"]."',
			bron_head='".$_POST["bron_head"]."', bron_corp='".$_POST["bron_corp"]."', bron_poyas='".$_POST["bron_poyas"]."', bron_legs='".$_POST["bron_legs"]."',
			protect_rej='".$_POST["protect_rej"]."', protect_drob='".$_POST["protect_drob"]."', protect_kol='".$_POST["protect_kol"]."', protect_rub='".$_POST["protect_rub"]."',
			protect_udar='".$_POST["protect_udar"]."', protect_mag='".$_POST["protect_mag"]."',
			hand_r_hitmin='".$_POST["hand_r_hitmin"]."', hand_l_hitmin='".$_POST["hand_l_hitmin"]."', hand_r_hitmax='".$_POST["hand_r_hitmax"]."', hand_l_hitmax='".$_POST["hand_l_hitmax"]."'
			WHERE login='".$res['login']."'");
			echo "<b style='color:#ff0000'>Ok</font>";
			$res=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE login='".$res['login']."'"));
		}
		?>
		<h3>Создание Ботов</h3>
		<form name="" action="main.php?act=inkviz&spell=bot_edit" method="post">
			<table>
			<tr><td>Логин:</td><td><input name="login_bot" type="text" value="<?=$res['login'];?>"></td></tr>
			
			<tr><td>Сила:</td><td><input name="sila" type="text" value="<?=$res['sila'];?>"></td></tr>
			<tr><td>Ловкость:</td><td><input name="lovkost" type="text" value="<?=$res['lovkost'];?>"></td></tr>
			<tr><td>Интуиция:</td><td><input name="udacha" type="text" value="<?=$res['udacha'];?>"></td></tr>
			<tr><td>Выносливость:</td><td><input name="power" type="text" value="<?=$res['power'];?>"></td></tr>
			<tr><td>HP:</td><td><input name="hp_all" type="text" value="<?=$res['hp_all'];?>"></td></tr>
			<tr><td colspan="2" bgcolor="#000000"></td></td>
				
			<tr><td>Мф. Крит:</td><td><input name="krit" type="text" value="<?=$res['krit'];?>"></td></tr>
			<tr><td>Мф. Антикрит:</td><td><input name="akrit" type="text" value="<?=$res['akrit'];?>"></td></tr>
			<tr><td>Мф. Уворот:</td><td><input name="uvorot" type="text" value="<?=$res['uvorot'];?>"></td></tr>
			<tr><td>Мф. Антиуворот:</td><td><input name="auvorot" type="text" value="<?=$res['auvorot'];?>"></td></tr>
			<tr><td>Мф. Парирования:</td><td><input name="parry" type="text" value="<?=$res['parry'];?>"></td></tr>
			<tr><td>Мф. Контрудара:</td><td><input name="counter" type="text" value="<?=$res['counter'];?>"></td></tr>
			<tr><td>Мф. Пробоя брони:</td><td><input name="proboy" type="text" value="<?=$res['proboy'];?>"></td></tr>
			<tr><td colspan="2" bgcolor="#000000"></td></td>
				
			<tr><td>Мф. мощности урона:</td><td><input name="ms_udar" type="text" value="<?=$res['ms_udar'];?>"></td></tr>
			<tr><td>Мф. мощности критического удара:</td><td><input name="ms_krit" type="text" value="<?=$res['ms_krit'];?>"></td></tr>
			<tr><td colspan="2" bgcolor="#000000"></td></td>
				
			<tr><td>Броня головы:</td><td><input name="bron_head" type="text" value="<?=$res['bron_head'];?>"></td></tr>
			<tr><td>Броня корпуса:</td><td><input name="bron_corp" type="text" value="<?=$res['bron_corp'];?>"></td></tr>
			<tr><td>Броня пояса:</td><td><input name="bron_poyas" type="text" value="<?=$res['bron_poyas'];?>"></td></tr>
			<tr><td>Броня ног:</td><td><input name="bron_legs" type="text" value="<?=$res['bron_legs'];?>"></td></tr>
			<tr><td colspan="2" bgcolor="#000000"></td></td>
				
			<tr><td>Защита от режущего урона:</td><td><input name="protect_rej" type="text" value="<?=$res['protect_rej'];?>"></td></tr>
			<tr><td>Защита от дробящего урона:</td><td><input name="protect_drob" type="text" value="<?=$res['protect_drob'];?>"></td></tr>
			<tr><td>Защита от колющего урона:</td><td><input name="protect_kol" type="text" value="<?=$res['protect_kol'];?>"></td></tr>
			<tr><td>Защита от рубящего урона:</td><td><input name="protect_rub" type="text" value="<?=$res['protect_rub'];?>"></td></tr>	
			<tr><td colspan="2" bgcolor="#000000"></td></td>
				
			<tr><td>Защита от урона:</td><td><input name="protect_udar" type="text" value="<?=$res['protect_udar'];?>"></td></tr>
			<tr><td>Защита от магии:</td><td><input name="protect_mag" type="text" value="<?=$res['protect_mag'];?>"></td></tr>
			<tr><td colspan="2" bgcolor="#000000"></td></td>
				
			<tr><td>hand_r_hitmin:</td><td><input type="text" name="hand_r_hitmin" value="<?=$res['hand_r_hitmin'];?>"></td></tr>
			<tr><td>hand_l_hitmin:</td><td><input type="text" name="hand_l_hitmin" value="<?=$res['hand_l_hitmin'];?>"></td></tr>
			<tr><td>hand_r_hitmax:</td><td><input type="text" name="hand_r_hitmax" value="<?=$res['hand_r_hitmax'];?>"></td></tr>
			<tr><td>hand_l_hitmax:</td><td><input type="text" name="hand_l_hitmax" value="<?=$res['hand_l_hitmax'];?>"></td></tr>
		  	<tr><td colspan="2" bgcolor="#000000"></td></td>
			<tr><td colspan=2 align=center><input type="submit" name="edit_bot" value="Редактировать"></td></tr>
		</form>
		<?
	}
}
else
{
	?>
	<h3>Редактирование Ботов</h3>
		<form name="" action="main.php?act=inkviz&spell=bot_edit" method="post">
		<table>
			<tr><td>Логин:</td><td><input name="login_bot" type="text" value=""></td></tr>
			<tr><td colspan=2 align=center><input type="submit" value="Редактировать"></td></tr>
		</table>
		</form>
	<?
}
?>