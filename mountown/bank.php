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
				$msgErr="������ �� ������.";
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
				$msgErr="���� ������� ������. �����: <b>".$numb."</b>.";
				history($login,'������ ����',$numb,$ip,'����');
   			}
   			else
   			{
    			$msgErr= "������ �� ���������!";
		   		$deist="new";
   			}
   		}
   		else
   		{
   			$msgErr= "� ��� ������������ �������!";
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
				$msgErr= "�������� ������ ��� ����� ".$_POST['bankid']."!";
			}
		}
		else
		{
			$msgErr= "���� ".$_POST['bankid']." �� ���������� ��� �� �� ������ �� ������������!";
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
			
			$subject="�� ����� ������� �������� ����� ����� � ������ � ��������� ".$login;
			$message=date("d.m.Y H:i")."<br>���-�� � IP: ".$db["remote_ip"]." �������� ������� ����� ����������� ����� � ������ � ��������� <b>$login</b>.<br>
			�.�. � ������ � ����� ��������� ������ email: <b>".$my_mail["email"]."</b>, �� �� � �������� ��� ������.<br>
			����� �����: ".$SEEK['number']." ������ (��� �������): \"".$new_pass."\"";
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=windows-1251' . "\r\n";
			$headers .= 'From: WWW.MEYDAN.AZ <root@meydan.az>' . "\r\n";
			if (mail($my_mail["email"], $subject, $message, $headers))
			{
				$msgErr="������ ����� ����� � ������ �� email, ��������� � ������!";
			} 
			else 
			{
				$msgErr="�� ������� ��������� ������ �� e-mail, ��������� � ������!";
			}
		}
		else
		{
			$msgErr= "���� ".$_POST['bankid']." �� ���������� ��� �� �� ������ �� ������������!";
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
						$msgErr="����������� ������� �����!";
					}
					else if ($db["money"]<$_POST['sum_1'])
					{
						$msgErr= "� ��� ��� ����� �����( ".$_POST['sum_1']." ��. )!";
					}
					else 
					{
						$bank_sum =$_POST['sum_1'];
						mysql_query("UPDATE `bank` SET money=money+$bank_sum WHERE number = '".$_SESSION["bankCheck"]."'");
						mysql_query("UPDATE `users` SET money=money-'$bank_sum' WHERE login = '".$_SESSION["login"]."'");
						$msgErr="�� �������� $bank_sum ��. �� ���� ".$_SESSION["bankCheck"];
						history($login,'�������� �� ���� '.$_SESSION["bankCheck"],$bank_sum." ��.",$ip,'����');
					}
				}
				//----------MONEY FROM BANK--------------------------------------------
				if($_POST['from_check'])
				{
					if (!is_numeric($_POST['sum2']) || ($_POST['sum2']<=0))
					{
						$msgErr="����������� ������� �����!";
					}
					else if($CHECK["money"]<$_POST['sum2'])
					{
               			$msgErr="�� ����� ��� ����� �����( ".$_POST['sum2']." ��. )!";
					}
					else 
					{
                		$bank_sum = $_POST['sum2'];
                		mysql_query("UPDATE `bank` SET money=money-$bank_sum WHERE number = '".$_SESSION["bankCheck"]."'");
                		mysql_query("UPDATE `users` SET money=money+$bank_sum WHERE login = '".$_SESSION["login"]."'");
                		$msgErr="�� ����� $bank_sum ��. �� ����� ".$_SESSION["bankCheck"];
						history($login,'���� ����� �� ����� '.$_SESSION["bankCheck"],$bank_sum." ��.",$ip,'����');
					}
				}
				//----------PLATINA TO BANK--------------------------------------------
				if($_POST['to_check_pl'])
				{
					if (!is_numeric($_POST['sum_2']) || ($_POST['sum_2']<=0))
					{
						$msgErr="����������� ������� �����!";
					}
					else if ($db["platina"]<$_POST['sum_2'])
					{
						$msgErr= "� ��� ��� ����� �����( ".$_POST['sum_2']." ��. )!";
					}
					else
					{
						$bank_sum = $_POST['sum_2'];
						$TO_CHECK = mysql_query("UPDATE `bank` SET emoney=emoney+$bank_sum WHERE number = '".$_SESSION["bankCheck"]."'");
						$FROM_USR = mysql_query("UPDATE `users` SET platina=platina-$bank_sum WHERE login = '".$_SESSION["login"]."'");
						$msgErr="�� �������� $bank_sum ��. �� ���� ".$_SESSION["bankCheck"];
						history($login,'�������� � ���� '.$_SESSION["bankCheck"],$_POST['sum_2']." ��.",$ip,'����');
					}
				}
				//----------PLATINA FROM BANK--------------------------------------------
				if($_POST['from_check_pl'])
				{
					if (!is_numeric($_POST['sum5']) || ($_POST['sum5']<=0))
					{
						$msgErr="����������� ������� �����!";
					}
					else if($CHECK["emoney"]<$_POST['sum5'])
					{
               			$msgErr="�� ����� ��� ����� �����( ".$_POST['sum5']." ��. )!";
					}
					else
					{
                		$bank_sum =$_POST['sum5'];
                		mysql_query("UPDATE `bank` SET emoney=emoney-$bank_sum WHERE number = '".$_SESSION["bankCheck"]."'");
                		mysql_query("UPDATE `users` SET platina=platina+$bank_sum WHERE login = '".$_SESSION["login"]."'");
						$msgErr="�� ����� $bank_sum ��. �� ����� ".$_SESSION["bankCheck"];
						history($login,'���� ����� �� ����� '.$_SESSION["bankCheck"],$bank_sum." ��.",$ip,'����');
                		
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
							$msgErr="����������� ������� �����!";
						}
						else if ($db["peredacha"]>=50) 
						{
							$msgErr="��� ����� ������� ��������";
						}
						else if($CHECK["money"]<$_POST['sum3'])
						{
		           			$msgErr="�� ����� ��� ����� �����( ".$_POST['sum3']." ��. )!";
						}
						else if ($db['orden']==5 || $res['orden']==5)
						{
		           			$msgErr="����� �������� ��������� ���������!";
						}
						else if ($db['level']<8 || $res['level']<8)
						{
		           			$msgErr="� ���������� �� 8-�� ������ �������� ��. ���������!";
						}
						else if ($comment=="")
						{
		           			$msgErr="������� ����������� � ���������!";
						}
						else
						{
                			$bank_sum = $_POST['sum3'];
                			mysql_query("UPDATE users SET  peredacha=peredacha+1 WHERE id='".$db['id']."'");
                			mysql_query("UPDATE `bank` SET money=money-".$_POST['sum3']." WHERE number = '".$_SESSION["bankCheck"]."'");
                			mysql_query("UPDATE `bank` SET money=money+".$_POST['sum3']." WHERE number = '".$_POST['to_check_id']."'");
							history($login,'������� ������',"�� ����� ".$_SESSION["bankCheck"]."(".$login.") �� ���� ".$_POST['to_check_id']."(".$toowner.")-".$_POST['sum3']." ��. (����������: $comment)",$ip,'����');
							history($toowner,'������� ������',"�� ����� ".$_SESSION["bankCheck"]."(".$login.") �� ���� ".$_POST['to_check_id']."(".$toowner.")-".$_POST['sum3']." ��. (����������: $comment)",$ip,'����');
                			$msgErr="�� �������� ".$_POST['sum3']." ��. � $toowner  �� ���� ".$_POST['to_check_id']." �� ����� ".$_SESSION["bankCheck"];
						}
					}
					else
					{
						$msgErr=  "���� ".$_POST['to_check_id']." �� ����������!";
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
								$msgErr="����������� ������� �����!";
							}
							else if($CHECK["emoney"]<$_POST['sum6'])
							{
			           			$msgErr="�� ����� ��� ����� �����( ".$_POST['sum6']." ��. )!";
							}
							else if ($db['orden']==5)
							{
			           			$msgErr="����� �������� ��������� ���������!";
							}
							else
							{
	                			$bank_sum = $_POST['sum6'];
	                			mysql_query("UPDATE `bank` SET emoney=emoney-$bank_sum WHERE number = '".$_SESSION["bankCheck"]."'");
	                			mysql_query("UPDATE `bank` SET emoney=emoney+$bank_sum WHERE number = '".$_POST['to_check_id_pl']."'");
								history($login,'������� �������',"�� ����� ".$_SESSION["bankCheck"]."(".$login.") �� ���� ".$_POST['to_check_id_pl']."(".$toowner.")-".$_POST['sum6']." ��.",$ip,'����');
								history($toowner,'������� �������',"�� ����� ".$_SESSION["bankCheck"]."(".$login.") �� ���� ".$_POST['to_check_id_pl']."(".$toowner.")-".$_POST['sum6']." ��.",$ip,'����');
								if ($bank_sum>=$bonus_limit)
	                			{	
	                				if ($res["dealer"] || $res["admin_level"]>=10)$bonus=0;
	                				if ($bonus>0)
	                				{
	                					//if ($_POST['sum6']>=2000)$bonus=100;
	                					//if ($_POST['sum6']>=5000)$bonus=150;
		                				$send_bonus=ceil(($bank_sum*$bonus)/100);
		                				mysql_query("UPDATE `bank` SET emoney=emoney+$send_bonus WHERE number = '".$_POST['to_check_id_pl']."'");	
										history($login,'������� �������������� �����',"�� ����� ".$_SESSION["bankCheck"]."(".$login.") �� ���� ".$_POST['to_check_id_pl']."(".$toowner.")-".$send_bonus." ��.",$ip,'����');
										history($toowner,'�������� �������������� �����',"�� ����� ".$_SESSION["bankCheck"]."(".$login.") �� ���� ".$_POST['to_check_id_pl']."(".$toowner.")-".$send_bonus." ��.",$ip,'����');
		                				$b_text="<br>�������������� �����: ".$send_bonus." ��. (".$bonus."%)";
	                				}
	                			}
	                			/*$bank_member=floor($_POST['sum6']/1000);
	                			if($bank_member>0)
	                			{
	                				$str_member="�� ��������� ���������� ����������� ��������. ������������ ������� 5000 ��.";
	                				for($i=1;$i<=$bank_member;$i++)
	                				{
										mysql_query("INSERT INTO inv (owner, object_id, object_type, object_razdel, msg, gift, gift_author, term) VALUES ('".$res['login']."', '419', 'flower', 'other', '�� ��������� ���������� ����������� ��������', 1, 'WWW.MEYDAN.AZ', '".(time()+3600*24*90)."')");
	                					mysql_Query("INSERT INTO bank_member (user_id) VALUES ('".$res["id"]."');");
	                				}
	                			}*/
	                			$msgErr="�� �������� $bank_sum ��. � $toowner  �� ���� ".$_POST['to_check_id_pl']." �� ����� ".$_SESSION["bankCheck"];
	                			$msgErr.=$b_text;
	                			say($res["login"],"$dates: ������ ���������� <b>".($bank_sum+$send_bonus)." ��.</b>".($bonus?" (�����:".$send_bonus." ��.)":"")." �� ���� ����� ".$_POST['to_check_id_pl']." � ��������� <b>".$res["login"]."</b>. ������� ����, �� �������� ��� ���! $str_member",$res["login"]);
	                			mysql_query("INSERT INTO compl(sender,receiver,sender_ip,receiver_ip,sender_number,receiver_number,platina,bonus) VALUES('".$login."','".$toowner."','".$ip."','".$res["remote_ip"]."','".$_SESSION["bankCheck"]."','".$_POST['to_check_id_pl']."','".$bank_sum."','".$send_bonus."')");
							}
						}
						else
						{
							$msgErr=  "���� ".$_POST['to_check_id']." �� ����������!";
						}
					}
				}
			}
			//----------------------EXCHANGE--------------------------------
			if($_POST['from_euro'])
			{
				if (!is_numeric($_POST['sum4']) || ($_POST['sum4']<=0))
				{
					$msgErr="����������� ������� �����!";
				}
				else if($CHECK["emoney"]<$_POST['sum4'])
				{
           			$msgErr="�� ����� VIP-����� ��� ����� �����( ".$_POST['sum4']." ��. )!";
				}
				else
				{
					$bank_sum   = $_POST['sum4']*100;
					$sum4     = $_POST['sum4'];
					mysql_query("UPDATE `bank` SET emoney=emoney-$sum4, money=money+$bank_sum WHERE number = '".$_SESSION["bankCheck"]."'");
					$msgErr="�� �������� $sum4 ��. �� ����� ".$_SESSION["bankCheck"].". ��� ���������� $bank_sum ��.";
					history($login,'����� ����� �� ����� '.$_SESSION["bankCheck"],$msgErr,$ip,'����');
				}
			}
			//----------------------Smenit Parol--------------------------------
			if($_POST['change_psw'])
			{
				$new_psw1=trim($_POST['new_psw1']);
				$new_psw2=trim($_POST['new_psw2']);
				if ($new_psw1=="")
				{
					$msgErr="�� �� ����� ����� ������";
				}
	    		else if($new_psw1 != $new_psw2)
	    		{
	    			$msgErr= "������ �� ���������!";
	   			}
	   			else
	   			{
	   				$newpass=md5($new_psw1);
	   				mysql_query("UPDATE `bank` SET password='".$newpass."' WHERE number = '".$_SESSION["bankCheck"]."'");
					history($login,"������ ������","����� ������ ��������.",$ip,'����');
					$msgErr="����� ������ ��������...";
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
			history($login,'������� ����',$_SESSION["bankCheck"]." (������ - ".sprintf ("%01.2f", $CHECK['money'])." ��., ������� - ".sprintf ("%01.2f", $CHECK['emoney'])." ��.)",$ip,'����');
			$_SESSION["bankLogin"]="";
			$_SESSION["bankCheck"]="";
		}
	}
}
//<BR>[��� ������� ���� 200AZN ����� �������� 100%, 500AZN ����� �������� 150% ]
?>
<h3>���� <br>(��������! �����! ��� ������� ������� - � ������� ������������� <?=$bonus?>% �� ����� �������!)</h3>
<TABLE border="0" cellpadding="0" cellspacing="0" width=100%>
<TR>
<TD width=100%><b style='color:#FF0000'><?=$msgErr?></b>&nbsp;</td>
<TD align=right nowrap valign=top>
	<input TYPE=button class="podskazka" value="���������" onclick="window.open('help/bank.php','displayWindow','height=400,width=500,resizable=no,scrollbars=yes,menubar=no,status=no,toolbar=no,directories=no,location=no')"/>
	<input type=button class="newbut" value="��������"	onClick="location.href='main.php?act=none'">
	<input type=button class="newbut" value="����� �� �����"	onclick="location.href='main.php?act=go&level=remesl'">
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
       			echo "&nbsp;&nbsp;������ ������� ����? ������ �������: <B>5.00 ��.</B><br>
       			<INPUT TYPE='button' class='newbut' VALUE='������� ����' onclick=\"location.href='?deist=new'\">
				<INPUT TYPE='button' class='newbut' VALUE='������ ������?' onclick=\"location.href='?deist=remind'\">";
				if ($deist=="new")
				{
					?>
					<table width=100%>
					<tr>
						<td>
							�� ������������� ��������� ������:
							<OL>
								<LI>�������� �����<LI>����������� ��������/����� ������/������� �� �����
								<LI>��������� ������/������� � ������ ����� �� ������
								<LI>�������� �����. ����� <b>��������</b> �� <b>������</b>
								<LI>�������� ���� ������ ��� � <b>5 ��.</b>
							</OL>
							<FORM ACTION='?do=create' NAME='newCheck' METHOD="POST">
								<table border=0 cellpadding=1 cellspacing=1 align=center>
									<tr><td> ������� ������: </td><td><INPUT TYPE='password' NAME='pass1' SIZE=20></td></tr>
									<tr><td> ������ ��������: </td><td><INPUT TYPE='password' NAME='pass2' SIZE=20></td></tr>
									<tr><td colspan=2 align=center><INPUT TYPE='submit' VALUE=' ������� ' CLASS='but' STYLE="height=18;font-size:11"></td></tr>
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
						<legend><b>���������� ������ �</b></legend>
						<table border=0 cellpadding=1 cellspacing=3 align=center>
						<tr>
							<td>����� �����: </td>
							<td>
								<select name='bankid' style='width:100'>";
								for ($i=0; $i<mysql_num_rows($nomer);$i++)
								{
									$num=mysql_fetch_array($nomer);
									echo "<option value=".$num['number'].">".$num['number'];
								}
								echo "</select>
							</td>
							<td><INPUT TYPE='submit' VALUE='�������� ������'></td>
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
						<legend><b>���������� ������ �</b></legend>
						<table border=0 cellpadding=0 cellspacing=3 align=center>
						<tr>
							<td align=right>����� �����: </td>
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
							<td align=right>������: </td>
							<td><INPUT TYPE='password' NAME='pass' SIZE=20 style='width:150'></td>
							<td><INPUT TYPE='submit' VALUE='�����'></td>
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
				echo "<fieldset><legend><b>���������� ������</b></legend>
				<b>���� �:</b> ".$_SESSION["bankCheck"]."<br>";
				#echo "&nbsp;&nbsp;<a href=\"?do=bankclose\" title=\"�������� ������ c ������� ������\">[x]</a>";
				echo "<INPUT TYPE='submit' VALUE='������� ����' NAME='logout' ></fieldset><br>
				<fieldset><legend><b>� ��� �� �����</b></legend>
				����� � ������� : <b>".$mymoney."</b> ��.<br>
		        ������� � ������� : <b>".$myplatina."</b> ��.<br><HR>
		        ����� �� ����� : <b>".$cash."</b> ��.<br>
		        ������� �� �����: <b>".$euro."</b> ��.</fieldset><br>
		        <fieldset><legend><b>������� ������</b></legend>
				<table>
					<tr><TD>����� ������</TD><TD><INPUT TYPE=password name=new_psw1></TD></tr>
					<tr><TD>������ ��������</TD><TD><INPUT TYPE=password name=new_psw2></TD></tr>
				</table>
				<INPUT TYPE=submit name=change_psw value=\"������� ������\">
				</FIELDSET><br>
		        <fieldset><LEGEND><B>���� �������</B> </LEGEND>
				������ �� ".date("d.m.Y")."<BR><BR>
				1 ��. = <b>0.1220</b> USD<BR>
				1 ��. = <b>0.0838</b> ����<BR>
				1 ��. = <b>0.1000</b> AZN<BR>
				1 ��. = <b>3.0959</b> ���������� ������
				</FIELDSET><br>
				<fieldset><LEGEND><B>Webmoney-��������</B> </LEGEND>
				<b>USD - <font color=red>Z111648627530</font></b>
				<br><small>� ���������� ������� ��� ��� � ����
				<br><font color=red>������� ��������� �� WMZ ����� ���������� � ������� �������</small></font>
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
						echo "<fieldset style='WIDTH: 350px'><legend><b>��������� ����</b></legend>
							����� <INPUT TYPE='text' NAME='sum_1' SIZE=4 maxlength=4 $m_dis>&nbsp;��. 
							<INPUT TYPE='submit' VALUE='�������� ��. �� ����' NAME='to_check' $m_dis>
							</fieldset><br>";
					?>
					</td>
					<td>
						<?
							print "<fieldset style='WIDTH: 350px'><legend><b>�������� ��. �� ����</b></legend>";
							print "����� <INPUT TYPE='text' NAME='sum_2' SIZE=4 maxlength=4 $p_dis>&nbsp;��. ";
							print "<INPUT TYPE='submit' VALUE='�������� ��. �� ����' NAME='to_check_pl' $p_dis>";
							print "</fieldset><br>";
						?>
					</td>
				</tr>
				<tr>
					<td colspan=2 align=center>
						<?
						echo "<fieldset style='WIDTH: 350px;'><legend><b>�������� �����</b></legend>
							�������� ������� �� ������.<BR>���� <B>1 ��.</B> = <B style='color:#ff0000'>100.00 ��.</b> <strike>30.00 ��.</strike><BR>
							����� <INPUT TYPE='text' NAME='sum4' SIZE=4 maxlength=4 $pb_dis>&nbsp;��. 
							<INPUT TYPE='submit' VALUE='��������' NAME='from_euro' $pb_dis onclick=\"if (isNaN(parseFloat(document.check.sum4.value))) {alert('������� ������������ �����'); return false;} else {return confirm('�� ������ �������� '+parseFloat(document.check.sum4.value)+' ��. �� ������?')}\">
							</fieldset><br>";
						?>
					</td>
				</tr>						
				<tr valign=top>
					<td>
					<?
						echo "<fieldset style='WIDTH: 350px'><legend><b>����� ��. �� �����</b></legend>
							����� <INPUT TYPE='text' NAME='sum2' SIZE=4 maxlength=4 $mb_dis>&nbsp;��. 
				        	<INPUT TYPE='submit' VALUE='����� ��. �� �����' NAME='from_check' $mb_dis>
				        	</fieldset><br>";
					?>
					</td>
					<td>
					<?
						echo "<fieldset style='WIDTH: 350px'><legend><b>����� ��. �� �����</b></legend>
							����� <INPUT TYPE='text' NAME='sum5' SIZE=4 maxlength=4 $pb_dis>&nbsp;��.
				        	<INPUT TYPE='submit' VALUE='����� ��. �� �����' NAME='from_check_pl' $pb_dis>
				        	</fieldset><br>";
					?>
					</td>
				</tr>
				<tr valign=top>
					<td>
					<?
						echo "<fieldset style='WIDTH: 350px'><legend><b>��������� ��. �� ������ ����</b></legend>
							����� <INPUT TYPE='text' NAME='sum3' SIZE=6 maxlength=".($db["adminsite"]?6:3)." $mb_dis> ��.<br>
							����� ����� <INPUT TYPE='text' NAME='to_check_id' SIZE=15 $mb_dis><br>
							���������� <input type='text' name='comment' size='20' $mb_dis>
							&nbsp;<INPUT TYPE='submit' VALUE='��������� ��. �� ������ ����' NAME='other_check' $mb_dis onclick=\"if (isNaN(parseFloat(document.check.sum3.value)) || isNaN(parseInt(document.check.to_check_id.value)) ) {alert('������� ����� � ����� �����'); return false;} else {return confirm('�� ������ ��������� �� ������ ����� '+parseFloat(document.check.sum3.value)+' ��. �� ���� ����� '+parseInt(document.check.to_check_id.value)+' ?')}\">
							</fieldset><br>";
					?>
					</td>
					<td><br>
					<?
						if ($db["admin_level"]>=10 || $db["dealer"])
						echo "<fieldset style='WIDTH: 350px'><legend><b>��������� ��. �� ������ ����</b></legend>
							����� <INPUT TYPE='text' NAME='sum6' SIZE=8 maxlength=5 $pb_dis> ��.<br>
							����� �����  <INPUT TYPE='text' NAME='to_check_id_pl' SIZE=15 $pb_dis>
							&nbsp;<INPUT TYPE='submit' VALUE='��������� ��. �� ������ ����' NAME='other_check_pl' $pb_dis onclick=\"if (isNaN(parseFloat(document.check.sum6.value)) || isNaN(parseInt(document.check.to_check_id_pl.value)) ) {alert('������� ����� � ����� �����'); return false;} else {return confirm('�� ������ ��������� �� ������ ����� '+parseFloat(document.check.sum6.value)+' ��. �� ���� ����� '+parseInt(document.check.to_check_id_pl.value)+' ?')}\">
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
