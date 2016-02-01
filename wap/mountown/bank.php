<?
$login=$_SESSION["login"];
$ip=$db["remote_ip"];
$dates=date("Y-m-d H:i:s");
$bonus_limit=0; //500 Pl-dan yuxari kocurmelere aiddir...
//------------------------------------------------------------------------------
if($_GET['do'] == 'create')
{
	if($db["money"]>=5)
	{
		if ($_POST['pass1']=="" || $_POST['pass2']=="")
		{
			$msgErr="Пароль не введен.";
	   		$_GET["deist"]="new";
		}
		else if($_POST['pass1'] == $_POST['pass2'])
		{
			$numb = rand(1111,9999999999);

			$money = $db["money"];
			$nalog= 5;
			$newmoney = $money - $nalog;
			$query1 = mysql_query("SELECT * FROM bank WHERE number = '".$numb."'");
			$result1 = mysql_num_rows($query1);
			while ($result1!=0)
			{
				$numb = rand(1111,9999999999999);
				$query1 = mysql_query("SELECT * FROM bank WHERE number = '".$numb."'");
				$result1 = mysql_num_rows($query1);
			}	
			
        	mysql_query("UPDATE users SET money='".$newmoney."' WHERE login='".$login."'");
        	mysql_query("LOCK TABLES bank WRITE");
     		mysql_query("INSERT INTO bank(number,login,password) VALUES('".$numb."','".$login."','".md5($_POST['pass1'])."')");
     		mysql_query("UNLOCK TABLES");
			$msgErr="Счет успешно открыт. Номер: <b>".$numb."</b>.";
			history($login,'Открыт счет',$numb,$ip,'Банк');
		}
		else
		{
			$msgErr= "Пароли не совпадают!";
	   		$_GET["deist"]="new";
		}
	}
	else
	{
		$msgErr= "У вас недостаточно средств!";
		$_GET["deist"]="new";
	}
}
//------------------------------------------------------------------------------
if($_GET['do'] == 'Login' && is_numeric($_POST["bankid"]))
{
	$SEEK = mysql_fetch_array(mysql_query("SELECT * FROM `bank` WHERE number = '".$_POST["bankid"]."' and login='".$login."'"));
	if($SEEK)
	{
		if(md5($_POST['pass'])==$SEEK["password"])
		{
			$bankLogin = $_SESSION["login"];
			$bankCheck = $SEEK["number"];
			$_SESSION["bankLogin"]=$bankLogin;
			$_SESSION["bankCheck"]=$bankCheck;
		}
		else
		{
			$msgErr= "Неверный пароль для счета ".$_POST['bankid']."!";
		}
	}
	else
	{
		$msgErr= "Счет ".$_POST['bankid']." не существует или Вы не можете им пользоваться!";
	}
}
//------------------------------------------------------------------------------
if($_GET['do'] == 'Remind' && is_numeric($_POST["bankid"]))
{
	$SEEK = mysql_fetch_array(mysql_query("SELECT * FROM `bank` WHERE number = '".$_POST['bankid']."' and login='".$login."'"));
	if($SEEK)
	{
		$new_pass=time();
		$pass=md5($new_pass);
		$my_mail=mysql_fetch_array(mysql_query("SELECT email FROM info WHERE id_pers=".$db["id"]));
		mysql_query("UPDATE bank SET password='".$pass."' WHERE number = '".$_POST['bankid']."' and login='".$login."'");
		
		$subject="По вашей просьбе высылаем номер счета и пароль у персонажа ".$login;
		$message=date("d.m.Y H:i")."<br>Кто-то с IP: ".$db["remote_ip"]." попросил выслать номер банковского счета и пароль к персонажу <b>$login</b>.<br>
		Т.к. в анкете у этого персонажа указан email: <b>".$my_mail["email"]."</b>, то вы и получили это письмо.<br>
		Номер счета: ".$SEEK['number']." Пароль (без кавычек): \"".$new_pass."\"";
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=windows-1251' . "\r\n";
		$headers .= 'From: WWW.MEYDAN.AZ <root@meydan.az>' . "\r\n";
		if (mail($my_mail["email"], $subject, $message, $headers))
		{
			$msgErr="Выслан номер счета и пароль на email, указанный в анкете!";
		} 
		else 
		{
			$msgErr="Не удалось отправить пароль на e-mail, указанный в анкете!";
		}
	}
	else
	{
		$msgErr= "Счет ".$_POST['bankid']." не существует или Вы не можете им пользоваться!";
	}
}
//------------------------------------------------------------------------------
if($_GET['do'] == 'logout')
{
	$_SESSION["bankLogin"]="";
	$_SESSION["bankCheck"]="";
}
//------------------------------------------------------------------------------
if($_GET['do'] == 'check')
{
	if(!empty($_SESSION["bankLogin"]) && !empty($_SESSION["bankCheck"]))
	{
		$CHECK = mysql_fetch_array(mysql_query("SELECT * FROM `bank` WHERE number = '".$_SESSION["bankCheck"]."' and login='".$_SESSION["login"]."'"));
		if($CHECK)
		{
			//----------MONEY TO BANK--------------------------------------------
			if($_POST['to_check'])
			{
				if (!is_numeric($_POST['sum_1']) || ($_POST['sum_1']<=0))
				{
					$msgErr="Неправильно введена сумма!";
				}
				else if ($db["money"]<$_POST['sum_1'])
				{
					$msgErr= "У Вас нет такой суммы( ".$_POST['sum_1']." Зл. )!";
				}
				else 
				{
					$bank_sum =$_POST['sum_1'];
					mysql_query("UPDATE `bank` SET money=money+$bank_sum WHERE number = '".$_SESSION["bankCheck"]."'");
					mysql_query("UPDATE `users` SET money=money-'$bank_sum' WHERE login = '".$_SESSION["login"]."'");
					$msgErr="Вы положили $bank_sum Зл. на счет ".$_SESSION["bankCheck"];
					history($login,'Поставил на счет '.$_SESSION["bankCheck"],$bank_sum." Зл.",$ip,'Банк');
				}
			}
			//----------MONEY FROM BANK--------------------------------------------
			if($_POST['from_check'])
			{
				if (!is_numeric($_POST['sum2']) || ($_POST['sum2']<=0))
				{
					$msgErr="Неправильно введена сумма!";
				}
				else if($CHECK["money"]<$_POST['sum2'])
				{
           			$msgErr="На счету нет такой суммы( ".$_POST['sum2']." Зл. )!";
				}
				else 
				{
            		$bank_sum = $_POST['sum2'];
            		mysql_query("UPDATE `bank` SET money=money-$bank_sum WHERE number = '".$_SESSION["bankCheck"]."'");
            		mysql_query("UPDATE `users` SET money=money+$bank_sum WHERE login = '".$_SESSION["login"]."'");
            		$msgErr="Вы сняли $bank_sum Зл. со счета ".$_SESSION["bankCheck"];
					history($login,'Съем денег со счета '.$_SESSION["bankCheck"],$bank_sum." Зл.",$ip,'Банк');
				}
			}
			//----------PLATINA TO BANK--------------------------------------------
			if($_POST['to_check_pl'])
			{
				if (!is_numeric($_POST['sum_2']) || ($_POST['sum_2']<=0))
				{
					$msgErr="Неправильно введена сумма!";
				}
				else if ($db["platina"]<$_POST['sum_2'])
				{
					$msgErr= "У Вас нет такой суммы( ".$_POST['sum_2']." Пл. )!";
				}
				else
				{
					$bank_sum = $_POST['sum_2'];
					$TO_CHECK = mysql_query("UPDATE `bank` SET emoney=emoney+$bank_sum WHERE number = '".$_SESSION["bankCheck"]."'");
					$FROM_USR = mysql_query("UPDATE `users` SET platina=platina-$bank_sum WHERE login = '".$_SESSION["login"]."'");
					$msgErr="Вы положили $bank_sum Пл. на счет ".$_SESSION["bankCheck"];
					history($login,'Поставил в банк '.$_SESSION["bankCheck"],$_POST['sum_2']." Пл.",$ip,'Банк');
				}
			}
			//----------PLATINA FROM BANK--------------------------------------------
			if($_POST['from_check_pl'])
			{
				if (!is_numeric($_POST['sum5']) || ($_POST['sum5']<=0))
				{
					$msgErr="Неправильно введена сумма!";
				}
				else if($CHECK["emoney"]<$_POST['sum5'])
				{
           			$msgErr="На счету нет такой суммы( ".$_POST['sum5']." Пл. )!";
				}
				else
				{
            		$bank_sum =$_POST['sum5'];
            		mysql_query("UPDATE `bank` SET emoney=emoney-$bank_sum WHERE number = '".$_SESSION["bankCheck"]."'");
            		mysql_query("UPDATE `users` SET platina=platina+$bank_sum WHERE login = '".$_SESSION["login"]."'");
					$msgErr="Вы сняли $bank_sum Пл. со счета ".$_SESSION["bankCheck"];
					history($login,'Съем денег со счета '.$_SESSION["bankCheck"],$bank_sum." Пл.",$ip,'Банк');
            		
				}
			}
			//---------------------SEND MONEY--------------------------------
			if($_POST['other_check'] && isset($_POST['to_check_id']))
			{
          		$TO_CHECK = mysql_fetch_array(mysql_query("SELECT * FROM `bank` WHERE number = '".$_POST['to_check_id']."'"));
          		if($TO_CHECK)
          		{
         			$toowner= $TO_CHECK["login"];
         			$res=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE login='".$toowner."'"));
         			$_POST['sum3']=round($_POST['sum3'],2);
         			$comment=htmlspecialchars(addslashes(trim($_POST["comment"])));
					if (!is_numeric($_POST['sum3']) || ($_POST['sum3']<=0))
					{
						$msgErr="Неправильно введена сумма!";
					}
					else if ($db["peredacha"]>=50) 
					{
						$msgErr="Ваш лимит передач исчерпан";
					}
					else if($CHECK["money"]<$_POST['sum3'])
					{
	           			$msgErr="На счету нет такой суммы( ".$_POST['sum3']." Зл. )!";
					}
					else if ($db['orden']==5 || $res['orden']==5)
					{
	           			$msgErr="Любые передачи запрещены Хаосникам!";
					}
					else if ($db['level']<8 || $res['level']<8)
					{
	           			$msgErr="К персонажам до 8-го уровня передачи Зл. запрещены!";
					}
					else if ($comment=="")
					{
	           			$msgErr="Указать комментарий к переводам!";
					}
					else
					{
            			$bank_sum = $_POST['sum3'];
            			mysql_query("UPDATE users SET  peredacha=peredacha+1 WHERE id='".$db['id']."'");
            			mysql_query("UPDATE `bank` SET money=money-".$_POST['sum3']." WHERE number = '".$_SESSION["bankCheck"]."'");
            			mysql_query("UPDATE `bank` SET money=money+".$_POST['sum3']." WHERE number = '".$_POST['to_check_id']."'");
						history($login,'Передал золото',"со счета ".$_SESSION["bankCheck"]."(".$login.") на счет ".$_POST['to_check_id']."(".$toowner.")-".$_POST['sum3']." Зл. (коментария: $comment)",$ip,'Банк');
						history($toowner,'Получил золото',"со счета ".$_SESSION["bankCheck"]."(".$login.") на счет ".$_POST['to_check_id']."(".$toowner.")-".$_POST['sum3']." Зл. (коментария: $comment)",$ip,'Банк');
            			$msgErr="Вы перевели ".$_POST['sum3']." Зл. к $toowner  на счет ".$_POST['to_check_id']." со счета ".$_SESSION["bankCheck"];
					}
				}
				else
				{
					$msgErr=  "Счет ".$_POST['to_check_id']." не существует!";
				}
			}
			//---------------------SEND PLATINA--------------------------------
			if($_POST['other_check_pl'] && isset($_POST['to_check_id_pl']))
			{
				if ($db["admin_level"]>=10 || $db["dealer"])
				{	
              		$TO_C_SQL = mysql_query("SELECT * FROM `bank` WHERE number = '".$_POST['to_check_id_pl']."'");
              		$TO_CHECK = mysql_fetch_array($TO_C_SQL);
              		if($TO_CHECK)
              		{
             			$toowner= $TO_CHECK["login"];
						$sql=mysql_query("SELECT * FROM users WHERE login='".$toowner."'");
             			$res=mysql_fetch_array($sql);
             			mysql_free_result($sql);
						$_POST['sum6']=round($_POST['sum6'],2);
						if (!is_numeric($_POST['sum6']) || ($_POST['sum6']<=0))
						{
							$msgErr="Неправильно введена сумма!";
						}
						else if($CHECK["emoney"]<$_POST['sum6'])
						{
		           			$msgErr="На счету нет такой суммы( ".$_POST['sum6']." Пл. )!";
						}
						else if ($db['orden']==5)
						{
		           			$msgErr="Любые передачи запрещены Хаосникам!";
						}
						else
						{
                			$bank_sum = $_POST['sum6'];
                			mysql_query("UPDATE `bank` SET emoney=emoney-$bank_sum WHERE number = '".$_SESSION["bankCheck"]."'");
                			mysql_query("UPDATE `bank` SET emoney=emoney+$bank_sum WHERE number = '".$_POST['to_check_id_pl']."'");
							history($login,'Передал Платина',"со счета ".$_SESSION["bankCheck"]."(".$login.") на счет ".$_POST['to_check_id_pl']."(".$toowner.")-".$_POST['sum6']." Пл.",$ip,'Банк');
							history($toowner,'Получил Платина',"со счета ".$_SESSION["bankCheck"]."(".$login.") на счет ".$_POST['to_check_id_pl']."(".$toowner.")-".$_POST['sum6']." Пл.",$ip,'Банк');
							if ($bank_sum>=$bonus_limit)
                			{	
                				if ($res["dealer"] || $res["admin_level"]>=10)$bonus=0;
                				if ($bonus>0)
                				{
                					//if ($_POST['sum6']>=2000)$bonus=100;
                					//if ($_POST['sum6']>=5000)$bonus=150;
	                				$send_bonus=ceil(($bank_sum*$bonus)/100);
	                				mysql_query("UPDATE `bank` SET emoney=emoney+$send_bonus WHERE number = '".$_POST['to_check_id_pl']."'");	
									history($login,'Передан АВТОМАТИЧЕСКИЙ Бонус',"со счета ".$_SESSION["bankCheck"]."(".$login.") на счет ".$_POST['to_check_id_pl']."(".$toowner.")-".$send_bonus." Пл.",$ip,'Банк');
									history($toowner,'Получена АВТОМАТИЧЕСКИЙ Бонус',"со счета ".$_SESSION["bankCheck"]."(".$login.") на счет ".$_POST['to_check_id_pl']."(".$toowner.")-".$send_bonus." Пл.",$ip,'Банк');
	                				$b_text="<br>АВТОМАТИЧЕСКИЙ Бонус: ".$send_bonus." Пл. (".$bonus."%)";
                				}
                			}
                			/*$bank_member=floor($_POST['sum6']/1000);
                			if($bank_member>0)
                			{
                				$str_member="Вы являетесь Участником Новогоднего Джекпота. Максимальный Выигрыш 5000 Пл.";
                				for($i=1;$i<=$bank_member;$i++)
                				{
									mysql_query("INSERT INTO inv (owner, object_id, object_type, object_razdel, msg, gift, gift_author, term) VALUES ('".$res['login']."', '419', 'flower', 'other', 'Вы являетесь Участником Новогоднего Джекпота', 1, 'WWW.MEYDAN.AZ', '".(time()+3600*24*90)."')");
                					mysql_Query("INSERT INTO bank_member (user_id) VALUES ('".$res["id"]."');");
                				}
                			}*/
                			$msgErr="Вы перевели $bank_sum Пл. к $toowner  на счет ".$_POST['to_check_id_pl']." со счета ".$_SESSION["bankCheck"];
                			$msgErr.=$b_text;
                			mysql_query("INSERT INTO compl(sender,receiver,sender_ip,receiver_ip,sender_number,receiver_number,platina,bonus) VALUES('".$login."','".$toowner."','".$ip."','".$res["remote_ip"]."','".$_SESSION["bankCheck"]."','".$_POST['to_check_id_pl']."','".$bank_sum."','".$send_bonus."')");
						}
					}
					else
					{
						$msgErr=  "Счет ".$_POST['to_check_id']." не существует!";
					}
				}
			}
			//----------------------EXCHANGE--------------------------------
			if($_POST['from_euro'])
			{
				if (!is_numeric($_POST['sum4']) || ($_POST['sum4']<=0))
				{
					$msgErr="Неправильно введена сумма!";
				}
				else if($CHECK["emoney"]<$_POST['sum4'])
				{
	       			$msgErr="На Вашем VIP-счету нет такой суммы( ".$_POST['sum4']." Пл. )!";
				}
				else
				{
					$bank_sum   = $_POST['sum4']*100;
					$sum4     = $_POST['sum4'];
					mysql_query("UPDATE `bank` SET emoney=emoney-$sum4, money=money+$bank_sum WHERE number = '".$_SESSION["bankCheck"]."'");
					$msgErr="Вы обменяли $sum4 Пл. со счета ".$_SESSION["bankCheck"].". Вам зачисленно $bank_sum Зл.";
					history($login,'Обмен денег со счета '.$_SESSION["bankCheck"],$msgErr,$ip,'Банк');
				}
			}
			//----------------------Smenit Parol--------------------------------
			if($_POST['change_psw'])
			{
				$new_psw1=trim($_POST['new_psw1']);
				$new_psw2=trim($_POST['new_psw2']);
				if ($new_psw1=="")
				{
					$msgErr="Вы не ввели новый пароль";
				}
	    		else if($new_psw1 != $new_psw2)
	    		{
	    			$msgErr= "Пароли не совпадают!";
	   			}
	   			else
	   			{
	   				$newpass=md5($new_psw1);
	   				mysql_query("UPDATE `bank` SET password='".$newpass."' WHERE number = '".$_SESSION["bankCheck"]."'");
					history($login,"Сменил пароль","Новый пароль сохранен.",$ip,'Банк');
					$msgErr="Новый пароль сохранен...";
	   			}
			}
			$db=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE login='".$login."'"));
		}
	}
}
//------------------------------------------------------------------------------
echo "<font color=red>".$msgErr."</font>";
?>
<div id="cnt" class="content">
	<b>Банк</b> [<a href="main.php?act=go&level=remesl">Выйти на улицу</a>]<br/>
	<small>(Внимание! Акция! При покупке Платины - в подарок дополнительно <?=$bonus?>% от суммы покупки!)</small>
</div>	
<div class="sep1"></div>
<div class="sep2"></div>
	
<div>
	<?
   	if(empty($_SESSION["bankLogin"]) && empty($_SESSION["bankCheck"]))
   	{
		echo "<center>Хотите открыть счет? Услуга платная: <b>5.00 Зл.</b><br/>[<a href='?deist=new'>Открыть счёт</a>] [<a href='?deist=remind'>Забыли пароль?</a>]</center>";
		if ($_GET["deist"]=="new")
		{
			?>
			Мы предоставляем следующие услуги:<br/>
			- Открытие счета (Возможность положить/снять Золото/Платина со счета)<br/>
			- Перевести Золото/Платина с одного счета на другой<br/>
			- Обменный пункт. Обмен <b>Платинов</b> на <b>Золото</b><br/>
			- Открытие счёт обойдётся вам в <b>5.00 Зл.</b><br/><br/>
			<form action='?do=create' name='newcheck' method="post">
				Введите пароль: <input type='password' class='inup' name='pass1' size='20' /><br/>
				Пароль повторно: <INPUT TYPE='password' class='inup' name='pass2' size='20' /><br/>
				<input type='submit' value=' СОЗДАТЬ ' class='inup' /><br/>
			</form>
			<?
		}
		else if ($_GET["deist"]=="remind")
		{
			$nomer = mysql_query("SELECT number FROM bank WHERE login='".$login."'");
			if (mysql_num_rows($nomer))
			{
				echo "<form action='?do=Remind' name='Login' method='post'>
				<b>Управление счетом №</b><br/>
				Номер счета:<br/> 
				<select name='bankid' class='inup'>";
				while ($num=mysql_fetch_array($nomer))
				{
					echo "<option value='".$num['number']."'>".$num['number']."</option>";
				}
				echo "</select><br/>
				<input type='submit' class='inup' value='Получить Пароль' /><br/>
				</form>";
			}
		}
		else
		{
			$nomer = mysql_query("SELECT number FROM bank WHERE login='".$login."'");
			if (mysql_num_rows($nomer))
			{
				echo "<form action='?do=Login' name='Login' method='post'>
				<b>Управление счетом №</b><br/>
				Номер счета:<br/>
				<select name='bankid' class='inup'>";
				while ($num=mysql_fetch_array($nomer))
				{
					echo "<option value='".$num['number']."'>".$num['number']."</option>";
				}
				echo "</select><br/>
				Пароль: <input type='password' name='pass' size='10' /> <input type='submit' value='Войти' class='inup' />
				</form>";
			}
		}
	}
   	else
	{
		$DATA  = mysql_fetch_array(mysql_query("SELECT * FROM `bank` WHERE number = '".$_SESSION["bankCheck"]."'"));
		$mymoney=sprintf ("%01.2f", $db["money"]);
		$myplatina=sprintf("%01.2f", $db["platina"]);
		$cash =sprintf ("%01.2f", $DATA["money"]);
		$euro =sprintf ("%01.2f", $DATA["emoney"]);

		echo "
		<form action='?do=check' name='check' method='post'>
		<b>Управление счетом №: ".$_SESSION["bankCheck"]."</b> <a href='?do=logout'>Сменить</a><br/><br/>
		Денег в кармане : <b>".$mymoney."</b> Зл.<br/>
		Платина в кармане : <b>".$myplatina."</b> Пл.<br/>
		Денег на счету : <b>".$cash."</b> Зл.<br/>
		Платина на счету: <b>".$euro."</b> Пл.<br/><br/>
		<b>Сменить пароль</b><br/>
		Новый пароль: <input type='password' name='new_psw1' class='inup' /><br/>
		Пароль повторно: <input type='password' name='new_psw2' class='inup' /><br/>
		<input type='submit' name='change_psw' value='Сменить пароль' class='inup' /><br/>
		<b>Курс Платины</b><br/>
		Данные на ".date("d.m.Y")."<br/><br/>
		1 Пл. = <b>0.12</b> USD<br/>
		1 Пл. = <b>0.08</b> ЕВРО<br/>
		1 Пл. = <b>0.10</b> AZN<br/>
		1 Пл. = <b>3.00</b> Российских Рублей<br/>";

		echo "<div class=\"sep1\"></div><div class=\"sep2\"></div>";

		echo "<b>Webmoney-кошельки</b><br/>
		<b>USD - <font color='#ff0000'>Z111648627530</font></b><br/>
		<small>В примечании укажите ваш ник и счет<br/>
		<font color='#ff0000'>Платины купленные за WMZ будут выдаваться в двойном размере</small></font>";

		echo "<div class=\"sep1\"></div><div class=\"sep2\"></div>";
		
		echo "<b>Положить Зл. на счёт</b><br/>
		Сумма: <input type='text' name='sum_1' size='4' maxlength='4' class='inup' /> Зл. 
		<input type='submit' value='OK' name='to_check' class='inup' /><br/>";
		
		echo "<div class=\"sep1\"></div><div class=\"sep2\"></div>";
		
		echo "<b>Положить Пл. на счёт</b><br/>
		Сумма: <input type='text' name='sum_2' size='4' maxlength='4' class='inup' /> Пл. 
		<input type='submit' value='OK' name='to_check_pl' class='inup' /><br/>";

		echo "<div class=\"sep1\"></div><div class=\"sep2\"></div>";

		echo "<b>Обменный пункт</b><br/>
		Обменять Платины на Золото.<br/>Курс <b>1 Пл.</b> = <b style='color:#ff0000'>100.00 Зл.</b><br/>
		Сумма: <input type='text' name='sum4' size='4' maxlength='4' class='inup' /> Пл. 
		<input type='submit' value='OK' name='from_euro' class='inup' /><br/>";

		echo "<div class=\"sep1\"></div><div class=\"sep2\"></div>";

		echo "<b>Снять Зл. со счёта</b><br/>
		Сумма: <input type='text' name='sum2' size='4' maxlength='4' class='inup' /> Зл. 
		<input type='submit' value='OK' name='from_check' class='inup' /><br/>";

		echo "<div class=\"sep1\"></div><div class=\"sep2\"></div>";

		echo "<b>Снять Пл. со счёта</b><br/>
		Сумма: <input type='text' name='sum5' size='4' maxlength='4' class='inup' /> Пл. 
		<input type='submit' value='OK' name='from_check_pl' class='inup' /><br/>";

		echo "<div class=\"sep1\"></div><div class=\"sep2\"></div>";

		echo "<b>Перевести Зл. на другой счет</b><br/>
		Сумма: <input type='text' name='sum3' size='6' maxlength='".($db["adminsite"]?6:3)."' class='inup' /> Зл.<br/>
		Номер счета: <input type='text' name='to_check_id' size='10' class='inup' /><br/>
		Коментарий: <input type='text' name='comment' size='10' class='inup' /> 
		<input type='submit' value='OK' name='other_check' class='inup' /><br/>";

		if ($db["admin_level"]>=10 || $db["dealer"])
		{	
			echo "<div class=\"sep1\"></div><div class=\"sep2\"></div>";

			echo "<b>Перевести Пл. на другой счет</b><br/>
			Сумма: <input type='text' name='sum6' size='5' maxlength='5' class='inup' /> Пл.<br/>
			Номер счета:  <input type='text' name='to_check_id_pl' size='10' class='inup' /> 
			<input type='submit' value='OK' name='other_check_pl' class='inup' /><br/>";
		}
		echo "</form>";
	}
	?>
</div>