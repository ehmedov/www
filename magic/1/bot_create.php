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
	if($res)
	{
		echo  "Логин <B>".$login_bot."</B> уже занят!.";
	}
	else
	{
		$sql = "INSERT INTO `users`(login, password, level, exp, next_up, sex, date, obraz, room, city_game, hp, hp_all, sila, lovkost, udacha, power, krit, akrit, uvorot, auvorot, hand_r_hitmin, hand_l_hitmin, hand_r_hitmax, hand_l_hitmax, bron_head, bron_corp, bron_poyas, bron_legs,
		parry, counter, proboy ,ms_udar, ms_krit, protect_rej, protect_drob, protect_kol, protect_rub, protect_udar, protect_mag, orden)
		VALUES('".$login_bot."', '".$password."', '".$level."','".$level_array[$level][0]."','".$level_array[$level][1]."', '".$sex."', '".date("d.m.Y H:i:s")."','".$obraz."','room1', 'mountown', '".(int)$_POST['hp_all']."','".(int)$_POST['hp_all']."', '".(int)$_POST['sila']."','".(int)$_POST['lovkost']."','".(int)$_POST['udacha']."','".(int)$_POST['power']."','".(int)$_POST['krit']."','".(int)$_POST['akrit']."','".(int)$_POST['uvorot']."','".(int)$_POST['auvorot']."', 
		'".(int)$_POST["hand_r_hitmin"]."','".(int)$_POST["hand_l_hitmin"]."','".(int)$_POST["hand_r_hitmax"]."','".(int)$_POST["hand_l_hitmax"]."', 
		'".(int)$_POST["bron_head"]."','".(int)$_POST["bron_corp"]."','".(int)$_POST["bron_poyas"]."','".(int)$_POST["bron_legs"]."', 
		'".(int)$_POST["parry"]."', '".(int)$_POST["counter"]."','".(int)$_POST["proboy"]."', '".(int)$_POST["ms_udar"]."','".(int)$_POST["ms_krit"]."',
		'".(int)$_POST["protect_rej"]."', '".(int)$_POST["protect_drob"]."','".(int)$_POST["protect_kol"]."', '".(int)$_POST["protect_rub"]."',
		'".(int)$_POST["protect_udar"]."', '".(int)$_POST["protect_mag"]."', '".(int)$_POST["orden"]."')";
		mysql_query($sql);
		$id_pers=mysql_insert_id();
		mysql_query("INSERT INTO info (id_pers, birth, born_city) VALUES(".$id_pers.", '".date("d.m.Y H:i:s")."', 'mountown');");
		echo "Персонаж <B>".$login_bot."</B> создан.";
	}
}
else
{
	?>
		<h3>Создание Ботов</h3>
		<form name="" action="main.php?act=inkviz&spell=bot_create" method="post">
			<table>
			<tr><td>Логин:</td><td><input name="login_bot" type="text" value=""></td></tr>
			<tr><td>Пароль:</td><td><input name="password" type="text" value=""></td></tr>
			<tr><td>Level:</td>
			<td>
				<select name="level">
				  	<option value="1">Level 1</option>
				  	<option value="2">Level 2</option>
					<option value="3">Level 3</option>
					<option value="4">Level 4</option>
					<option value="5">Level 5</option>
					<option value="6">Level 6</option>
					<option value="7">Level 7</option>
					<option value="8">Level 8</option>
					<option value="9">Level 9</option>
					<option value="10">Level 10</option>
					<option value="11">Level 11</option>
				</select>
			</td></tr>
			<tr><td>Ссылка на образ:</td><td><input name="obraz" type="text" value="hell/"></td></tr>
			
			<tr><td>Сила:</td><td><input name="sila" type="text" value="3"></td></tr>
			<tr><td>Ловкость:</td><td><input name="lovkost" type="text" value="3"></td></tr>
			<tr><td>Интуиция:</td><td><input name="udacha" type="text" value="3"></td></tr>
			<tr><td>Выносливость:</td><td><input name="power" type="text" value="3"></td></tr>
			<tr><td>HP:</td><td><input name="hp_all" type="text" value="30"></td></tr>
			<tr><td colspan="2" bgcolor="#000000"></td></td>
				
			<tr><td>Мф. Крит:</td><td><input name="krit" type="text" value=""></td></tr>
			<tr><td>Мф. Антикрит:</td><td><input name="akrit" type="text" value=""></td></tr>
			<tr><td>Мф. Уворот:</td><td><input name="uvorot" type="text" value=""></td></tr>
			<tr><td>Мф. Антиуворот:</td><td><input name="auvorot" type="text" value=""></td></tr>
			<tr><td>Мф. Парирования:</td><td><input name="parry" type="text" value=""></td></tr>
			<tr><td>Мф. Контрудара:</td><td><input name="counter" type="text" value=""></td></tr>
			<tr><td>Мф. Пробоя брони:</td><td><input name="proboy" type="text" value=""></td></tr>
			<tr><td colspan="2" bgcolor="#000000"></td></td>
				
			<tr><td>Мф. мощности урона:</td><td><input name="ms_udar" type="text" value=""></td></tr>
			<tr><td>Мф. мощности критического удара:</td><td><input name="ms_krit" type="text" value=""></td></tr>
			<tr><td colspan="2" bgcolor="#000000"></td></td>
				
			<tr><td>Броня головы:</td><td><input name="bron_head" type="text" value=""></td></tr>
			<tr><td>Броня корпуса:</td><td><input name="bron_corp" type="text" value=""></td></tr>
			<tr><td>Броня пояса:</td><td><input name="bron_poyas" type="text" value=""></td></tr>
			<tr><td>Броня ног:</td><td><input name="bron_legs" type="text" value=""></td></tr>
			<tr><td colspan="2" bgcolor="#000000"></td></td>
				
			<tr><td>Защита от режущего урона:</td><td><input name="protect_rej" type="text" value=""></td></tr>
			<tr><td>Защита от дробящего урона:</td><td><input name="protect_drob" type="text" value=""></td></tr>
			<tr><td>Защита от колющего урона:</td><td><input name="protect_kol" type="text" value=""></td></tr>
			<tr><td>Защита от рубящего урона:</td><td><input name="protect_rub" type="text" value=""></td></tr>	
			<tr><td colspan="2" bgcolor="#000000"></td></td>
				
			<tr><td>Защита от урона:</td><td><input name="protect_udar" type="text" value=""></td></tr>
			<tr><td>Защита от магии:</td><td><input name="protect_mag" type="text" value=""></td></tr>
			<tr><td colspan="2" bgcolor="#000000"></td></td>
				
			<tr><td>hand_r_hitmin:</td><td><input type="text" name="hand_r_hitmin"></td></tr>
			<tr><td>hand_l_hitmin:</td><td><input type="text" name="hand_l_hitmin"></td></tr>
			<tr><td>hand_r_hitmax:</td><td><input type="text" name="hand_r_hitmax"></td></tr>
			<tr><td>hand_l_hitmax:</td><td><input type="text" name="hand_l_hitmax"></td></tr>
			<tr><td colspan="2" bgcolor="#000000"></td></td>
			<tr><td>Склонность:</td><td>
				<select name="orden" class=new>
					<option value=0>нет
					<option value=1>Стражи порядка
					<option value=2>Вампиры
					<option value=3>Орден Равновесия
					<option value=4>Орден Света
					<option value=5>Тюремный заключеный
					<option value=6>Истинный Мрак
					<option value=100>Смертные
				</select>
			</td></tr>
			<tr><td>Sex:</td><td>
			<select size="1" name="sex">
		  		<option value="male">Мужчина</option>
		  		<option value="female">Женщина</option>
		  	</select>
		  	</td></tr>
		  	<tr><td colspan="2" bgcolor="#000000"></td></td>
			<tr><td colspan=2 align=center><input type="submit" name="create_bot" value="Создать Бота"></td></tr>
		</form>
	<?
}
?>