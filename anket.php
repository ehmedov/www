<?
include('key.php');
ob_start("@ob_gzhandler");
include ("conf.php");
include ("functions.php");

$data = mysql_connect($base_name, $base_user, $base_pass) or die('Не получается подключиться. Проверьте имя сервера, имя пользователя и пароль!');
mysql_select_db($db_name) or die('Ошибка входа в базу данных');

Header("Cache-Control: no-cache, must-revalidate"); // говорим браузеру что-бы он не кешировал эту страницу
Header("Pragma: no-cache");

$login=$_SESSION['login'];
$random=md5(time());
$result = mysql_query("SELECT * FROM users LEFT JOIN info on info.id_pers=users.id WHERE login='".$login."'");
$db = mysql_fetch_array($result);
mysql_free_result($result);
if($db["battle"]){Header("Location: battle.php?tmp=$random");	die();}
$action=$_GET["action"];
if ($action=="")$action="none";
$ip=$db["remote_ip"];
?>
<HTML>
<HEAD>	
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<meta http-equiv="Content-Language" content="ru">
	<META Http-Equiv=Cache-Control Content="no-cache, max-age=0, must-revalidate, no-store">
	<meta http-equiv=PRAGMA content=NO-CACHE>
	<meta http-equiv=Expires content=0>	
	<link rel=stylesheet type="text/css" href="main.css">
</HEAD>
<SCRIPT>
	function imover(im){im.filters.Alpha.Enabled=false;}
	function imout(im){im.filters.Alpha.Enabled=true;}
</SCRIPT>
<body bgcolor="#faeede">
<h3>Редактирование анкеты персонажа "<? echo $login; ?>"</h3>
<center>
<input type=button onclick="location.href='?action=none'" value="Настройки" class=btn>
<input type=button onclick="location.href='?action=secure'" value="Безопастность" class=btn>
<input type=button onclick="location.href='?action=obraz'" value="Образ" class=btn>
<input type=button onclick="location.href='?action=vip'" value="Мастерская образов" class=btn>	
<input type=button onclick="location.href='main.php?act=none'" value="Вернуться" class=btn>
</center>
<?
if ($action=="none")
{
	$maxchars=2048;
	$name=($_POST['saveanketa']?$_POST['name']:$db["name"]);
	$icq=($_POST['saveanketa']?$_POST['icq']:$db["icq"]);
	$deviz=($_POST['saveanketa']?$_POST['deviz']:$db["deviz"]);
	$hobie=($_POST['saveanketa']?$_POST['hobie']:$db["hobie"]);
	$color=($_POST['saveanketa']?$_POST['color']:$db["color"]);
	$town=($_REQUEST['saveanketa']?$_POST['town']:$db["town"]);
	
	$name=HtmlSpecialChars($name);
	$icq=HtmlSpecialChars($icq);
	$deviz=HtmlSpecialChars($deviz);
	$hobie=HtmlSpecialChars($hobie);
	$color=HtmlSpecialChars($color);
	$town=HtmlSpecialChars($town);
	$hobie=str_replace("&amp;","&",$hobie);
	$hobie=str_replace("&amp;","&",$hobie);
	
	$deviz=str_replace("&amp;","&",$deviz);
	$deviz=str_replace("&amp;","&",$deviz);
	
	str_replace("<br>","\n",$hobie);

	$message="&nbsp;";

	$showform=1;
	if ($_POST['saveanketa']) 
	{
		$okname=true;
		$en=preg_match("/^(([a-zA-Z0-9 -])+)$/i", $name);
		$ru=preg_match("/^(([а-яА-Я0-9 -])+)$/i", $name);
		if ((($en && $ru) or (!$en && !$ru)) && ($name)){$message="Неверное имя";$okname=false;}
		if (!$name) {$message="Не указан имя";$okname=false;}
		
		$en=preg_match("/^(([a-zA-Z0-9 -])+)$/i", $town);
		$ru=preg_match("/^(([а-яА-Я0-9 -])+)$/i", $town);
		if ((($en && $ru) || (!$en && !$ru)) && ($town)) {$message="Неверное название города";$okname=false;}
		if (!$town) {$message="Не указан город";$okname=false;}
		
		if (!preg_match("/^(([0-9-])+)$/i", $icq) && $icq) {$message="Неверное поле ICQ";$okname=false;}
		if (!preg_match("/^(([a-zA-Z0-9#])+)$/i", $color)) {$message="Неверное поле цвет в чате";$okname=false;}
		if ($okname) 
		{
			mysql_query("UPDATE users SET color='".addslashes($color)."' WHERE login='".$login."'");
			mysql_query("UPDATE info SET name='".addslashes($name)."',town='".$town."',icq='".addslashes($icq)."' , hobie='".addslashes(substr($hobie,0,$maxchars))."',deviz='".addslashes($deviz)."' WHERE id_pers='".$db["id"]."'");
			$message="Настройки сохранено удачно...";
			$showform=1;
		}
	}
	if ($showform) 
	{
		?>
		<B style="color:#ff0000"><center><? echo $message; ?></center></B>	
		<table width="95%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#CEBBAA" name="F1">
		<FORM METHOD=POST ACTION="anket.php" name='FORM1' id="FORM1">
			<tr class='l1'>
				<td><b>Ваше реальное имя: </td>
				<td><input name="name" value="<? echo $name; ?>" class="inup" size="45" maxlength="90" /></td>
			</tr>
			<tr class='l1'>
				<td><b>Дата рождения: </td>
				<td><? echo $db['birth']; ?></td>
			</tr>
			<tr class='l1'>
				<td><b>Город: </td>
				<td><input name="town" value="<? echo $town; ?>" class="inup" size="45" maxlength="90" /></td>
		    </tr>
		    <tr class='l1'>
				<td><b>ICQ:</td>
				<td><input value="<? echo $icq;?>" name="icq" class="inup" size="25" maxlength="25" /> 
			</tr>
		    <tr class='l1'>
				<td><b>Девиз:</td>
				<td><input value="<? echo $deviz; ?>" name="deviz" class="inup" size="60" maxlength="160" /></td>
			</tr>
		    <tr class='l1'>
				<td colspan="2" align="left"><b>Дополнительная информация</b> <small><? echo '(Максимально '.$maxchars.' символов)'; ?> </small><BR>
					<textarea name="hobie" class="inup" cols="60" rows="10"  style='width:95%'><? echo str_replace("<br>","\n",substr($hobie,0,$maxchars)); ?></textarea>
				</td>
			</tr>
		    <tr class='l1'>
				<td><b>Цвет сообщений в чате:</td>
				<td>
				<select name="color" class="inup" style="BACKGROUND: #f2f0f0;">
					<option style="COLOR: black" value="Black">Black</option>
					<option style="COLOR: blue" value="Blue">Blue</option>
					<option style="COLOR: fuchsia" value="Fuchsia">Fuchsia</option>
					<option style="COLOR: gray" value="Gray">Grey</option>
					<option style="COLOR: darkgreen" value="darkgreen">DarkGreen</option>
					<option style="COLOR: maroon" value="Maroon">Maroon</option>
					<option style="COLOR: navy" value="Navy">Navy</option>
					<option style="COLOR: olive" value="Olive">Olive</option>
					<option style="COLOR: purple" value="Purple">Purple</option>
					<option style="COLOR: teal" value="Teal">Teal</option>
					<option style="COLOR: chocolate" value="Chocolate">Chocolate</option>
					<option style="COLOR: deeppink" value="DeepPink">DeepPink</option>
		        </select>
				<script language="javascript" type="text/javascript">document.FORM1.color.value="<? echo $color; ?>";</script></td>
		    </tr>
		    <tr>
				<td colspan="2" align="center">
					<input name="saveanketa" type="submit" class="btn" value="Сохранить изменения" />
				</td>
		    </tr>
		  </form>
		</table>
		<?
	}
}
if ($action=="secure")
{
	$mess="&nbsp;";
	$showform=true;
	if ($_POST['dochpass']) 
	{
		$ok=true;
		$newpass=HtmlSpecialChars($_POST['newpass']);
		$newpass2=HtmlSpecialChars($_POST['newpass2']);
		$oldpass=HtmlSpecialChars($_POST['oldpass']);
		
		if (strlen($newpass)<6) {$ok=false;$mess='Ошибка. Пароль не может быть короче 6 символов.';}
		if (strlen($newpass)>20) {$ok=false; $mess="Ошибка. Пароль не может быть длиннее 21 символа.";}
		if ($newpass!=$newpass2) {$ok=false;$mess='Ошибка. Пароли не совпадают.';}
		if (trim($newpass)=='') {$ok=false;$mess='Ошибка. Задан пустой пароль';}
		if ($oldpass!=base64_decode($db["password"])) {$ok=false;$mess="Ошибка. Старый пароль указан неверно.";}
		if ($ok) 
		{
			$date = date("d.m.Y H:i");
			mysql_query("UPDATE users SET password='".addslashes(base64_encode($newpass))."' WHERE login='".$login."'");
			history($login,"Был сменен пароль",$date,$ip,"Анкета");
            
			$subject="Смена пароля у персонажа $login";

            $message = "<b>Здраствуйте, $login!</b><br><br>";
            $message .= "Кто-то с ip-адреса <b>$ip</b> $date был сменен пароль к персонажу $login он-лайн игры <b>WWW.MEYDAN.AZ</b>. <br><br>";
            $message .= "<b>Новый пароль</b>: $newpass<br><br><br><br>";
            $message .= "<b style='color:green'>С уважением. администрация WWW.MEYDAN.AZ.</b>";
			
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=windows-1251' . "\r\n";
			$headers .= 'From: WWW.MEYDAN.AZ <admin@meydan.az>' . "\r\n";

			if (mail($db["email"], $subject, $message, $headers))
			{
				echo "<center><font color=green><b>Внимание! Письмо с паролем будет отправлено на почту указанный в анкете в течении 5 минут.</b></font></center>";
			} 
			else 
			{
				echo "<center><font color=red><b>Внимание! Не удалось отправить пароль на e-mail, указанный в анкете!</b></font></center>";
			}
			$mess='Новый пароль сохранен.';
		}
	}
	if ($_POST['dochmail']) 
	{
		$old_mail=HtmlSpecialChars(addslashes(strtolower(trim($_POST['old_mail']))));
		$new_mail=HtmlSpecialChars(addslashes(strtolower(trim($_POST['new_mail']))));
		$ok=true;
		if (trim($new_mail)=='') {$ok=false;$mess='Задан пустой почтовый адрес.';}
		if (!preg_match('#^[a-z0-9.!\#$%&\'*+-/=?^_`{|}~]+@([0-9.]+|([^\s]+\.+[a-z]{2,6}))$#si', $new_mail)){$ok=false;$mess="Ошибка. Неверно введен почтовый адрес.";}
		if ($old_mail!=$db["email"]) {$ok=false;$mess="Ошибка. Старый почтовый адрес указан неверно.";}
		if ($ok) 
		{	
			$date = date("d.m.Y H:i");
			mysql_query("UPDATE info SET email='".$new_mail."' WHERE id_pers='".$db["id"]."'");
			history($login,"Был сменен E-mail",$date,$ip,"Анкета");
			$mail = $db["email"];
            
			$subject="Смена e-mail у персонажа $login";

            $message = "<b>Здраствуйте, $login!</b><br><br>";
            $message .= "Кто-то с ip-адреса <b>$ip</b> $date был сменен e-mail, указанный при регистрации персонажа <b>$login</b> он-лайн игры <b>WWW.MEYDAN.AZ</b>.<br>";
            $message .= "<br><b>Новый e-mail</b>: $new_mail<br><br><br><br>";
            $message .= "<b style='color:green'>С уважением. администрация WWW.MEYDAN.AZ.</b>";

			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=windows-1251' . "\r\n";
			$headers .= 'From: WWW.MEYDAN.AZ <admin@meydan.az>' . "\r\n";
			
			if (mail($db["email"], $subject, $message, $headers))
			{
				echo "<center><font color=green><b>Внимание! Письмо с паролем будет отправлено на почту указанный в анкете в течении 5 минут.</b></font></center>";
			} 
			else 
			{
				echo "<center><font color=red><b>Внимание! Не удалось отправить пароль на e-mail, указанный в анкете!</b></font></center>";
			}
			$mess='Почтовый адрес успешно сменен.';
		}
	}
	if ($_POST['set_on_psw2']) 
	{
		$numbers=array(4,6,8);
		$min_=array();
		$max_=array();
		$min_[4]=1000;
		$max_[4]=9999;

		$min_[6]=100000;
		$max_[6]=999999;

		$min_[8]=10000000;
		$max_[8]=99999999;
		$num_count=(int)$_POST['count'];
		if (in_array($num_count,$numbers))
		{	
			$password1=mt_rand($min_[$num_count],$max_[$num_count]);
			$my_pass=mysql_fetch_array(mysql_query("SELECT password1 FROM users WHERE login='".$login."'"));
			if (empty($my_pass['password1']))
			{	
				$date = date("d.m.Y H:i");
				mysql_query("UPDATE users SET password1='".$password1."' WHERE login='".$login."'");
				history($login,"Был сменен Второй пароль",$date,$ip,"Анкета");
				$mess="ВНИМАНИЕ! Ваш второй пароль: $password1";
				$db['password1']=$password1;
			}
			else $mess="Второй пароль уже установлен..."; 
		}
	}
	if ($_POST['set_off_psw2']) 
	{
		$oldpass=(int)$_POST['oldpsw2'];
		$my_pass=mysql_fetch_array(mysql_query("SELECT password1 FROM users WHERE login='$login' limit 1"));
		if ($my_pass['password1']==$oldpass)
		{	
			$date = date("d.m.Y H:i");
			mysql_query("UPDATE users SET password1='' WHERE login='".$login."'");
			history($login,"Второй пароль отключен",$date,$ip,"Анкета");
			$mess="Второй пароль отключен...";
			$db['password1']="";
		}
		else $mess="Ошибка. Старый пароль указан неверно.";
	}
	if ($showform) 
	{
	?>
	<B style="color:#ff0000"><center><? echo $mess; ?></center></B>
		<table width="95%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#CEBBAA" name="F1">
			<FORM METHOD=POST ACTION="?action=secure" name='FORM1' id="FORM1">
			<tr class='l1'>
				<td width=300>Старый пароль: </td>
				<td><input name="oldpass" type=password value="<? echo $name; ?>" class="inup" size="45" maxlength="90" /></td>
			</tr>
			<tr class='l1'>
				<td>Новый пароль: </td>
				<td><input name="newpass" type=password class="inup" size="45" maxlength="90" /></td>
			</tr>
			<tr class='l1'>
				<td>Новый пароль (еще раз): </td>
				<td><input name="newpass2" type=password class="inup" size="45" maxlength="90" /></td>
		    </tr>
		    <tr>
				<td colspan="2" align="center">
		          <input name="dochpass" type="submit" class="btn" value="Сменить пароль" />
		   		</td>
		    </tr>
		</table>
		<br>
		<br>
		<table width="95%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#CEBBAA" name="F1">
			<tr class='l1'>
				<td width=300>Старый e-mail: </td>
				<td><input type=text name=old_mail class=inup size="45" maxlength="90"></td>
			</tr>
			<tr class='l1'>
				<td>Новый e-mail: </td>
				<td><input type=text name=new_mail class=inup size="45" maxlength="90"></td>
			</tr>
		    <tr>
				<td colspan="2" align="center">
					<input name="dochmail" type="submit" class="btn" value="Сменить email" />
		   		</td>
		    </tr>
		</table>
		
		<br>
		<br>
		<table width="95%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#CEBBAA" name="F1">
			<tr class='l1'>
				<td colspan=2 align=center><B>Второй уровень защиты</B></td>
			</tr>
			<tr class='l1'>
				<td colspan=2>
					<small>Рекомендуем его использовать, если вы играете из интернет кафе или компьютерного клуба.<BR>
					На компьютере может быть установлен клавиатурный шпион, который записывает все нажатия клавиш, таким образом, могут узнать ваш пароль.<BR>
					Возможно, в сети компьютеров установлен "сетевой снифер", перехватывающий все интернет пакеты, который легко покажет все пароли. Чтобы обезопасить себя, вы можете установить своему персонажу второй пароль, который можно вводить при помощи мышки (клавиатурным шпионом не перехватить) и который передается на игровой сервер в зашифрованном виде, не поддающимся расшифровке ("сетевой снифер" не сможет перехватить его).<BR>
					Ваш браузер должен нормально отображать Flash 6! (<I>если наши часики в нижней строке нормально тикают, значит у вас все в порядке :</I>)<BR>
					</small><br><U>Будьте внимательны!</U> Второй пароль нельзя получить на email или узнать как-либо еще. Если вы его забудете/потеряете, вы не сможете войти в <b>WwW.MeYdAn.Az</b> своим персонажем!<BR>
				</td>
			</tr>
			<tr class='l1'>
				<td>
					<?
					if (empty($db['password1']))
					{
						echo "<b>ПРИ УСТАНОВКЕ ОБЯЗАТЕЛЬНО ЗАПИШИТЕ ПАРОЛЬ, КОТОРЫЙ ПОЯВИТСЯ НА ЭКРАНЕ.</b><br><BR>";
						echo "
						<INPUT TYPE=radio NAME='count' value=4> <b>простой уровень</b> (4 цифр)<BR>
						<INPUT TYPE=radio NAME='count' checked value=6> <b>средний уровень</b> (6 цифр)<BR>
						<INPUT TYPE=radio NAME='count' value=8> <b>сложный уровень</b> (8 цифр)<BR>";
						?>
							<input name="set_on_psw2" type="submit" class="btn" value="Установить второй пароль" onclick="return confirm('Система сама придумает вам второй пароль, он будет показан на этой странице. Будьте внимательны.\nУстановить второй пароль?')"/>
						<?
					}
					else
					{
						echo "<BR><B>Второй пароль установлен.</B><BR><BR>";
						?>
						Введите второй пароль <INPUT TYPE=password NAME=oldpsw2 size=10 maxlength=8> <INPUT TYPE=submit name=set_off_psw2 value="Выключить второй пароль" onclick="return confirm('Выключить запрос второго пароля при входе...?')">
						<?
					}
					?>
				</td>
			</tr>
		</table>
	</FORM>
	<b>ПРЕДУПРЕЖДЕНИЕ!!!</b><br>
		Уважаемые игроки! При смене своего пароля старайтесь ставить новый, пользуясь следующими правилами::<br>
		&bull; Не ставить пароль, состоящий только из одних цифр или одних букв. Оптимальный вариант - сочетание.<br>
		&bull; По возможности составлять пароль с использованием различных регистров (большие и маленькие буквы вперемешку).<br>
		&bull; Не использовать в пароле известные вещи, например номер вашего телефона или своё имя.<br>
		&bull; Пароль должен быть очень трудным для угадывания, но в то же время хорошо запоминающимся вам.<br>
		&bull; Никогда, ни под каким предлогом, никому не говорите свой пароль. Администрации не нужно знать ваш пароль.<br>
		&bull; Вводите логин и пароль только на титульной странице <A HREF="http://www.meydan.az" target=_blank>www.meydan.az</A> Ни на каких других сайтах, которые будут как две капли похожие на наш, и куда вас зазывают обещая на халяву предметы и кредиты, не вводите свой пароль! Иначе вы рискуете потерять своего персонажа.<br>
	<br><br>
	<? 
	}
}
if ($action=="obraz")
{
	if ($db["sex"]=="male") 
	{
		$ob="1.gif,2.gif,3.gif,4.gif,5.gif,6.gif,7.gif,8.gif,9.gif,10.gif,11.gif,12.gif,13.gif,14.gif,15.gif,16.gif,17.gif,18.gif,19.gif,20.gif,21.gif,22.gif,23.gif,24.gif,25.gif,26.gif,27.gif,28.gif";
		$ob=explode(',',$ob);
		$my_sex="m";
	}
	else
	{
		$ob="1.gif,2.gif,3.gif,4.gif,5.gif,6.gif,7.gif,8.gif,9.gif,10.gif,11.gif,12.gif,13.gif,14.gif,15.gif,16.gif";
		$ob=explode(',',$ob);
		$my_sex="f";
	}

	$messs="&nbsp;";
	if (in_array($_GET['setimage'],$ob))
	{
		mysql_query("update users set obraz='".htmlspecialchars(addslashes($my_sex."/".$_GET['setimage']))."' where login='".$login."'");
		$messs='Образ сохранен.';
		$db['obraz'] = htmlspecialchars(addslashes($my_sex."/".$_GET['setimage']));
	}	
	echo "<B style='color:#ff0000'><center>$messs</center></B>";
	echo "<center>";
	$i=0;
	foreach ($ob as $key=>$value) 
	{
		$i++;
		echo "<SPAN style='background-Color: #000000'><a href=\"?action=obraz&setimage=$value\"><IMG SRC=\"img/obraz/$my_sex/$value\"  border=0 ALT='Выбрать этот образ' onMouseOver=\"imover(this)\" onMouseOut=\"imout(this)\" style=\"".($db['obraz']==$my_sex.'/'.$value?'':'filter:Alpha(Opacity=80,FinishOpacity=60,Style=2)')."\"></a></SPAN>&nbsp;";
		if(($i % 5) == 0) echo "<br>";	
	}
	echo "</center><br><br>";
}
//---------------------------------------------------------------------------
if ($action=="vip")
{
	if ($_GET["id"])
	{
		$obraz_id=(int)$_GET["id"];
		$sql_=mysql_query("SELECT * FROM obraz WHERE owner='".$login."' and id=".$obraz_id);
		$res_=mysql_fetch_array($sql_);
		if (!$res_)
		{
			echo "<b style='color:red'>Образ не найден...</b>";
		}
		else
		{
			mysql_query("UPDATE users SET obraz='".$res_["img"]."' WHERE login='".$login."'");
			echo "<b style='color:red'>Образ сохранен!</b>";
		}		
	}	
	$i=1;
	echo "<table align=center><tr>";
	$sql=mysql_query("SELECT * FROM obraz WHERE owner='".$login."'");
	while($res=mysql_fetch_array($sql))
	{	
		echo "<td width=145 nowrap align=center><A href=\"?action=vip&id=".$res["id"]."\"><img src='img/obraz/".$res["img"]."' border=0></a></td>";
		if(($i % 6) == 0) echo "</tr><tr>";
		$i++;
	}
	if (!mysql_num_Rows($sql))echo "<td><b style='color:red'>У вас нету персональных образов!</b></td>";
	echo "</tr></table>";
}
?>
</body>
</html>
