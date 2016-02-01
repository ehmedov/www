<?
$login=$_SESSION['login'];
$ip=$db["remote_ip"];
$dates=date("Y-m-d H:i:s");

$bonus_limit=0; //500 Pl-dan yuxari kocurmelere aiddir...

if(empty($tar)){$tar="";}
$deist=$_GET['deist'];

if(empty($tar))
{
	if(empty($act)){$act = "";}
	if($_GET['do'] == 'create')
	{
		if($db["money"]>=5)
		{
			if ($_POST['pass1']=="" || $_POST['pass2']=="")
			{
				$msgErr="Пароль не введен.";
		   		$deist="new";
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
		   		$deist="new";
   			}
   		}
   		else
   		{
   			$msgErr= "У вас недостаточно средств!";
			$deist="new";
   		}
	}
	if($_GET['do'] == 'Login')
	{
		$SEEK_CHECK = mysql_query("SELECT * FROM `bank` WHERE number = '".$_POST["bankid"]."' and login='".$login."'");
		$SEEK = mysql_fetch_array($SEEK_CHECK);
		if($SEEK)
		{
			$svlad=$SEEK["login"];
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
	if($_GET['do'] == 'Remind')
	{
		$SEEK_CHECK = mysql_query("SELECT * FROM `bank` WHERE number = '".$_POST['bankid']."' and login='".$login."'");
		$SEEK = mysql_fetch_array($SEEK_CHECK);
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
	if($_GET['do'] == 'check')
	{
		if(!empty($_SESSION["bankLogin"]) && !empty($_SESSION["bankCheck"]))
		{
			$C_SQL = mysql_query("SELECT * FROM `bank` WHERE number = '".$_SESSION["bankCheck"]."' and login='".$_SESSION["login"]."'");
			$CHECK = mysql_fetch_array($C_SQL);
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
	                			say($res["login"],"$dates: Удачно переведены <b>".($bank_sum+$send_bonus)." Пл.</b>".($bonus?" (Бонус:".$send_bonus." Пл.)":"")." на счет номер ".$_POST['to_check_id_pl']." к персонажу <b>".$res["login"]."</b>. Удачной игры, мы работаем для Вас! $str_member",$res["login"]);
	                			mysql_query("INSERT INTO compl(sender,receiver,sender_ip,receiver_ip,sender_number,receiver_number,platina,bonus) VALUES('".$login."','".$toowner."','".$ip."','".$res["remote_ip"]."','".$_SESSION["bankCheck"]."','".$_POST['to_check_id_pl']."','".$bank_sum."','".$send_bonus."')");
							}
						}
						else
						{
							$msgErr=  "Счет ".$_POST['to_check_id']." не существует!";
						}
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
			//----------LOGOUT--------------------------------------------
			if($_POST['logout'])
			{
				$_SESSION["bankLogin"]="";
				$_SESSION["bankCheck"]="";
			}			
		}
	}
	//----------BANK CLOSE--------------------------------------------
	if($_GET['do'] == 'bankclose')
	{
		$C_SQL = mysql_query("SELECT * FROM `bank` WHERE number = '".$_SESSION["bankCheck"]."' and login='".$login."'");
		if(mysql_num_rows($C_SQL))
		{	
			$CHECK = mysql_fetch_array($C_SQL);
			mysql_free_result($C_SQL);
			mysql_query("DELETE FROM bank WHERE number='".$_SESSION["bankCheck"]."' and login='".$login."'");
			history($login,'Закрыль счет',$_SESSION["bankCheck"]." (Деньги - ".sprintf ("%01.2f", $CHECK['money'])." Зл., Платина - ".sprintf ("%01.2f", $CHECK['emoney'])." Пл.)",$ip,'Банк');
			$_SESSION["bankLogin"]="";
			$_SESSION["bankCheck"]="";
		}
	}
}
//<BR>[При покупке выше 200AZN Бонус составит 100%, 500AZN Бонус составит 150% ]
?>
<h3>Банк <br>(Внимание! Акция! При покупке Платины - в подарок дополнительно <?=$bonus?>% от суммы покупки!)</h3>
<TABLE border="0" cellpadding="0" cellspacing="0" width=100%>
<TR>
<TD width=100%><b style='color:#FF0000'><?=$msgErr?></b>&nbsp;</td>
<TD align=right nowrap valign=top>
	<input TYPE=button class="podskazka" value="Подсказка" onclick="window.open('help/bank.php','displayWindow','height=400,width=500,resizable=no,scrollbars=yes,menubar=no,status=no,toolbar=no,directories=no,location=no')"/>
	<input type=button class="newbut" value="Обновить"	onClick="location.href='main.php?act=none'">
	<input type=button class="newbut" value="Выйти из Банка"	onclick="location.href='main.php?act=go&level=remesl'">
</td>
</tr>
</table>
<table border=0 cellpadding="0" cellspacing="0" width=100% align=center valign=top>
<tr>
	<td valign="top" align=center>
		<?
       	if(empty($_SESSION["bankLogin"]) && empty($_SESSION["bankCheck"]))
       	{
       		echo "<table width=400 align=center border=0>
       		<tr>
       		<td valign=top align=center>";
       			echo "&nbsp;&nbsp;Хотите открыть счет? Услуга платная: <B>5.00 Зл.</B><br>
       			<INPUT TYPE='button' class='newbut' VALUE='Открыть счёт' onclick=\"location.href='?deist=new'\">
				<INPUT TYPE='button' class='newbut' VALUE='Забыли пароль?' onclick=\"location.href='?deist=remind'\">";
				if ($deist=="new")
				{
					?>
					<table width=100%>
					<tr>
						<td>
							Мы предоставляем следующие услуги:
							<OL>
								<LI>Открытие счета<LI>Возможность положить/снять Золото/Платина со счета
								<LI>Перевести Золото/Платина с одного счета на другой
								<LI>Обменный пункт. Обмен <b>Платинов</b> на <b>Золото</b>
								<LI>Открытие счёт обоётся вам в <b>5 Зл.</b>
							</OL>
							<FORM ACTION='?do=create' NAME='newCheck' METHOD="POST">
								<table border=0 cellpadding=1 cellspacing=1 align=center>
									<tr><td> Введите пароль: </td><td><INPUT TYPE='password' NAME='pass1' SIZE=20></td></tr>
									<tr><td> Пароль повторно: </td><td><INPUT TYPE='password' NAME='pass2' SIZE=20></td></tr>
									<tr><td colspan=2 align=center><INPUT TYPE='submit' VALUE=' СОЗДАТЬ ' CLASS='but' STYLE="height=18;font-size:11"></td></tr>
								</table>
							</FORM>
						</td>
					</tr>
					</table>
					<? 
				}
				else if ($deist=="remind")
				{
					$nomer = mysql_query("SELECT number FROM bank WHERE login='".$login."'");
					if (mysql_num_rows($nomer))
					{
						echo "<FORM ACTION='?do=Remind' NAME='Login' METHOD='POST'>
						<fieldset >
						<legend><b>Управление счетом №</b></legend>
						<table border=0 cellpadding=1 cellspacing=3 align=center>
						<tr>
							<td>Номер счета: </td>
							<td>
								<select name='bankid' style='width:100'>";
								for ($i=0; $i<mysql_num_rows($nomer);$i++)
								{
									$num=mysql_fetch_array($nomer);
									echo "<option value=".$num['number'].">".$num['number'];
								}
								echo "</select>
							</td>
							<td><INPUT TYPE='submit' VALUE='Получить Пароль'></td>
						</tr>
						</table>
						</FIELDSET></FORM>";
					}
				}
				else
				{
					$nomer = mysql_query("SELECT number FROM bank WHERE login='".$login."'");
					if (mysql_num_rows($nomer))
					{
						echo "<FORM ACTION='?do=Login' NAME='Login' METHOD='POST'>
						<fieldset >
						<legend><b>Управление счетом №</b></legend>
						<table border=0 cellpadding=0 cellspacing=3 align=center>
						<tr>
							<td align=right>Номер счета: </td>
							<td>
								<select name='bankid' style='width:150'>";
								for ($i=0; $i<mysql_num_rows($nomer);$i++)
								{
									$num=mysql_fetch_array($nomer);
									echo "<option value=".$num['number'].">".$num['number'];
								}
								echo "</select>
							</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td align=right>Пароль: </td>
							<td><INPUT TYPE='password' NAME='pass' SIZE=20 style='width:150'></td>
							<td><INPUT TYPE='submit' VALUE='Войти'></td>
						</tr>
						</table>
						</FIELDSET></FORM>";
					}
				}
			echo "</td>
			</tr>
			</table><br><br><br><br>";
       }
       else
       {
			$DATA  = mysql_fetch_array(mysql_query("SELECT * FROM `bank` WHERE number = '".$_SESSION["bankCheck"]."'"));
			$db=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE login='".$login."'"));

			if(!$db["money"])		{$m_dis = " DISABLED";}	else{$m_dis = "";}
			if(!$db["platina"]) 	{$p_dis = " DISABLED";}	else{$p_dis = "";}
			if(!$DATA["money"])		{$mb_dis = " DISABLED";}else{$mb_dis = "";}
			if(!$DATA["emoney"])	{$pb_dis = " DISABLED";}else{$pb_dis = "";}
			$mymoney=sprintf ("%01.2f", $db["money"]);
			$myplatina=sprintf("%01.2f", $db["platina"]);
			$cash =sprintf ("%01.2f", $DATA["money"]);
			$euro =sprintf ("%01.2f", $DATA["emoney"]);
        ?>
		<FORM ACTION='?do=check' NAME='check' METHOD="POST">
		<table width=100% border=0 cellspacing=0 cellpadding=0>
		<tr>
		<td valign=top width=300 nowrap>
			<TABLE border=0 cellspacing=5 cellpadding=0 width=100%><tr><td>
			<?
				echo "<fieldset><legend><b>Управление счетом</b></legend>
				<b>Счёт №:</b> ".$_SESSION["bankCheck"]."<br>";
				#echo "&nbsp;&nbsp;<a href=\"?do=bankclose\" title=\"Окончить работу c текущим счетом\">[x]</a>";
				echo "<INPUT TYPE='submit' VALUE='Сменить счёт' NAME='logout' ></fieldset><br>
				<fieldset><legend><b>У вас на счету</b></legend>
				Денег в кармане : <b>".$mymoney."</b> Зл.<br>
		        Платина в кармане : <b>".$myplatina."</b> Пл.<br><HR>
		        Денег на счету : <b>".$cash."</b> Зл.<br>
		        Платина на счету: <b>".$euro."</b> Пл.</fieldset><br>
		        <fieldset><legend><b>Сменить пароль</b></legend>
				<table>
					<tr><TD>Новый пароль</TD><TD><INPUT TYPE=password name=new_psw1></TD></tr>
					<tr><TD>Пароль повторно</TD><TD><INPUT TYPE=password name=new_psw2></TD></tr>
				</table>
				<INPUT TYPE=submit name=change_psw value=\"Сменить пароль\">
				</FIELDSET><br>
		        <fieldset><LEGEND><B>Курс Платины</B> </LEGEND>
				Данные на ".date("d.m.Y")."<BR><BR>
				1 Пл. = <b>0.1220</b> USD<BR>
				1 Пл. = <b>0.0838</b> ЕВРО<BR>
				1 Пл. = <b>0.1000</b> AZN<BR>
				1 Пл. = <b>3.0959</b> Российских Рублей
				</FIELDSET><br>
				<fieldset><LEGEND><B>Webmoney-кошельки</B> </LEGEND>
				<b>USD - <font color=red>Z111648627530</font></b>
				<br><small>В примечании укажите ваш ник и счет
				<br><font color=red>Платины купленные за WMZ будут выдаваться в двойном размере</small></font>
				</FIELDSET>";
	        ?>
	        </td></tr>
	        </table>
		</td>
		<td valign=top width=100%>
				<table border=0 cellspacing=5 cellpadding=0 width=100%>
				<tr valign=top>
					<td>
					<?
						echo "<fieldset style='WIDTH: 350px'><legend><b>Пополнить счет</b></legend>
							Сумма <INPUT TYPE='text' NAME='sum_1' SIZE=4 maxlength=4 $m_dis>&nbsp;Зл. 
							<INPUT TYPE='submit' VALUE='Положить Зл. на счёт' NAME='to_check' $m_dis>
							</fieldset><br>";
					?>
					</td>
					<td>
						<?
							print "<fieldset style='WIDTH: 350px'><legend><b>Положить Пл. на счёт</b></legend>";
							print "Сумма <INPUT TYPE='text' NAME='sum_2' SIZE=4 maxlength=4 $p_dis>&nbsp;Пл. ";
							print "<INPUT TYPE='submit' VALUE='Положить Пл. на счёт' NAME='to_check_pl' $p_dis>";
							print "</fieldset><br>";
						?>
					</td>
				</tr>
				<tr>
					<td colspan=2 align=center>
						<?
						echo "<fieldset style='WIDTH: 350px;'><legend><b>Обменный пункт</b></legend>
							Обменять Платины на Золото.<BR>Курс <B>1 Пл.</B> = <B style='color:#ff0000'>100.00 Зл.</b> <strike>30.00 Зл.</strike><BR>
							Сумма <INPUT TYPE='text' NAME='sum4' SIZE=4 maxlength=4 $pb_dis>&nbsp;Пл. 
							<INPUT TYPE='submit' VALUE='Обменять' NAME='from_euro' $pb_dis onclick=\"if (isNaN(parseFloat(document.check.sum4.value))) {alert('Укажите обмениваемую сумму'); return false;} else {return confirm('Вы хотите обменять '+parseFloat(document.check.sum4.value)+' Пл. на Золото?')}\">
							</fieldset><br>";
						?>
					</td>
				</tr>						
				<tr valign=top>
					<td>
					<?
						echo "<fieldset style='WIDTH: 350px'><legend><b>Снять Зл. со счёта</b></legend>
							Сумма <INPUT TYPE='text' NAME='sum2' SIZE=4 maxlength=4 $mb_dis>&nbsp;Зл. 
				        	<INPUT TYPE='submit' VALUE='Снять Зл. со счёта' NAME='from_check' $mb_dis>
				        	</fieldset><br>";
					?>
					</td>
					<td>
					<?
						echo "<fieldset style='WIDTH: 350px'><legend><b>Снять Пл. со счёта</b></legend>
							Сумма <INPUT TYPE='text' NAME='sum5' SIZE=4 maxlength=4 $pb_dis>&nbsp;Пл.
				        	<INPUT TYPE='submit' VALUE='Снять Пл. со счёта' NAME='from_check_pl' $pb_dis>
				        	</fieldset><br>";
					?>
					</td>
				</tr>
				<tr valign=top>
					<td>
					<?
						echo "<fieldset style='WIDTH: 350px'><legend><b>Перевести Зл. на другой счет</b></legend>
							Сумма <INPUT TYPE='text' NAME='sum3' SIZE=6 maxlength=".($db["adminsite"]?6:3)." $mb_dis> Зл.<br>
							Номер счета <INPUT TYPE='text' NAME='to_check_id' SIZE=15 $mb_dis><br>
							Коментарий <input type='text' name='comment' size='20' $mb_dis>
							&nbsp;<INPUT TYPE='submit' VALUE='Перевести Зл. на другой счет' NAME='other_check' $mb_dis onclick=\"if (isNaN(parseFloat(document.check.sum3.value)) || isNaN(parseInt(document.check.to_check_id.value)) ) {alert('Укажите сумму и номер счета'); return false;} else {return confirm('Вы хотите перевести со своего счета '+parseFloat(document.check.sum3.value)+' Зл. на счет номер '+parseInt(document.check.to_check_id.value)+' ?')}\">
							</fieldset><br>";
					?>
					</td>
					<td><br>
					<?
						if ($db["admin_level"]>=10 || $db["dealer"])
						echo "<fieldset style='WIDTH: 350px'><legend><b>Перевести Пл. на другой счет</b></legend>
							Сумма <INPUT TYPE='text' NAME='sum6' SIZE=8 maxlength=5 $pb_dis> Пл.<br>
							Номер счета  <INPUT TYPE='text' NAME='to_check_id_pl' SIZE=15 $pb_dis>
							&nbsp;<INPUT TYPE='submit' VALUE='Перевести Пл. на другой счет' NAME='other_check_pl' $pb_dis onclick=\"if (isNaN(parseFloat(document.check.sum6.value)) || isNaN(parseInt(document.check.to_check_id_pl.value)) ) {alert('Укажите сумму и номер счета'); return false;} else {return confirm('Вы хотите перевести со своего счета '+parseFloat(document.check.sum6.value)+' Пл. на счет номер '+parseInt(document.check.to_check_id_pl.value)+' ?')}\">
							</fieldset><br>";
					?>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		</table>
		</FORM>
		<?}?>
      </td>
  </tr>
</table>
