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
			$msgErr="������ �� ������.";
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
			$msgErr="���� ������� ������. �����: <b>".$numb."</b>.";
			history($login,'������ ����',$numb,$ip,'����');
		}
		else
		{
			$msgErr= "������ �� ���������!";
	   		$_GET["deist"]="new";
		}
	}
	else
	{
		$msgErr= "� ��� ������������ �������!";
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
			$msgErr= "�������� ������ ��� ����� ".$_POST['bankid']."!";
		}
	}
	else
	{
		$msgErr= "���� ".$_POST['bankid']." �� ���������� ��� �� �� ������ �� ������������!";
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
                			mysql_query("INSERT INTO compl(sender,receiver,sender_ip,receiver_ip,sender_number,receiver_number,platina,bonus) VALUES('".$login."','".$toowner."','".$ip."','".$res["remote_ip"]."','".$_SESSION["bankCheck"]."','".$_POST['to_check_id_pl']."','".$bank_sum."','".$send_bonus."')");
						}
					}
					else
					{
						$msgErr=  "���� ".$_POST['to_check_id']." �� ����������!";
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
			$db=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE login='".$login."'"));
		}
	}
}
//------------------------------------------------------------------------------
echo "<font color=red>".$msgErr."</font>";
?>
<div id="cnt" class="content">
	<b>����</b> [<a href="main.php?act=go&level=remesl">����� �� �����</a>]<br/>
	<small>(��������! �����! ��� ������� ������� - � ������� ������������� <?=$bonus?>% �� ����� �������!)</small>
</div>	
<div class="sep1"></div>
<div class="sep2"></div>
	
<div>
	<?
   	if(empty($_SESSION["bankLogin"]) && empty($_SESSION["bankCheck"]))
   	{
		echo "<center>������ ������� ����? ������ �������: <b>5.00 ��.</b><br/>[<a href='?deist=new'>������� ����</a>] [<a href='?deist=remind'>������ ������?</a>]</center>";
		if ($_GET["deist"]=="new")
		{
			?>
			�� ������������� ��������� ������:<br/>
			- �������� ����� (����������� ��������/����� ������/������� �� �����)<br/>
			- ��������� ������/������� � ������ ����� �� ������<br/>
			- �������� �����. ����� <b>��������</b> �� <b>������</b><br/>
			- �������� ���� �������� ��� � <b>5.00 ��.</b><br/><br/>
			<form action='?do=create' name='newcheck' method="post">
				������� ������: <input type='password' class='inup' name='pass1' size='20' /><br/>
				������ ��������: <INPUT TYPE='password' class='inup' name='pass2' size='20' /><br/>
				<input type='submit' value=' ������� ' class='inup' /><br/>
			</form>
			<?
		}
		else if ($_GET["deist"]=="remind")
		{
			$nomer = mysql_query("SELECT number FROM bank WHERE login='".$login."'");
			if (mysql_num_rows($nomer))
			{
				echo "<form action='?do=Remind' name='Login' method='post'>
				<b>���������� ������ �</b><br/>
				����� �����:<br/> 
				<select name='bankid' class='inup'>";
				while ($num=mysql_fetch_array($nomer))
				{
					echo "<option value='".$num['number']."'>".$num['number']."</option>";
				}
				echo "</select><br/>
				<input type='submit' class='inup' value='�������� ������' /><br/>
				</form>";
			}
		}
		else
		{
			$nomer = mysql_query("SELECT number FROM bank WHERE login='".$login."'");
			if (mysql_num_rows($nomer))
			{
				echo "<form action='?do=Login' name='Login' method='post'>
				<b>���������� ������ �</b><br/>
				����� �����:<br/>
				<select name='bankid' class='inup'>";
				while ($num=mysql_fetch_array($nomer))
				{
					echo "<option value='".$num['number']."'>".$num['number']."</option>";
				}
				echo "</select><br/>
				������: <input type='password' name='pass' size='10' /> <input type='submit' value='�����' class='inup' />
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
		<b>���������� ������ �: ".$_SESSION["bankCheck"]."</b> <a href='?do=logout'>�������</a><br/><br/>
		����� � ������� : <b>".$mymoney."</b> ��.<br/>
		������� � ������� : <b>".$myplatina."</b> ��.<br/>
		����� �� ����� : <b>".$cash."</b> ��.<br/>
		������� �� �����: <b>".$euro."</b> ��.<br/><br/>
		<b>������� ������</b><br/>
		����� ������: <input type='password' name='new_psw1' class='inup' /><br/>
		������ ��������: <input type='password' name='new_psw2' class='inup' /><br/>
		<input type='submit' name='change_psw' value='������� ������' class='inup' /><br/>
		<b>���� �������</b><br/>
		������ �� ".date("d.m.Y")."<br/><br/>
		1 ��. = <b>0.12</b> USD<br/>
		1 ��. = <b>0.08</b> ����<br/>
		1 ��. = <b>0.10</b> AZN<br/>
		1 ��. = <b>3.00</b> ���������� ������<br/>";

		echo "<div class=\"sep1\"></div><div class=\"sep2\"></div>";

		echo "<b>Webmoney-��������</b><br/>
		<b>USD - <font color='#ff0000'>Z111648627530</font></b><br/>
		<small>� ���������� ������� ��� ��� � ����<br/>
		<font color='#ff0000'>������� ��������� �� WMZ ����� ���������� � ������� �������</small></font>";

		echo "<div class=\"sep1\"></div><div class=\"sep2\"></div>";
		
		echo "<b>�������� ��. �� ����</b><br/>
		�����: <input type='text' name='sum_1' size='4' maxlength='4' class='inup' /> ��. 
		<input type='submit' value='OK' name='to_check' class='inup' /><br/>";
		
		echo "<div class=\"sep1\"></div><div class=\"sep2\"></div>";
		
		echo "<b>�������� ��. �� ����</b><br/>
		�����: <input type='text' name='sum_2' size='4' maxlength='4' class='inup' /> ��. 
		<input type='submit' value='OK' name='to_check_pl' class='inup' /><br/>";

		echo "<div class=\"sep1\"></div><div class=\"sep2\"></div>";

		echo "<b>�������� �����</b><br/>
		�������� ������� �� ������.<br/>���� <b>1 ��.</b> = <b style='color:#ff0000'>100.00 ��.</b><br/>
		�����: <input type='text' name='sum4' size='4' maxlength='4' class='inup' /> ��. 
		<input type='submit' value='OK' name='from_euro' class='inup' /><br/>";

		echo "<div class=\"sep1\"></div><div class=\"sep2\"></div>";

		echo "<b>����� ��. �� �����</b><br/>
		�����: <input type='text' name='sum2' size='4' maxlength='4' class='inup' /> ��. 
		<input type='submit' value='OK' name='from_check' class='inup' /><br/>";

		echo "<div class=\"sep1\"></div><div class=\"sep2\"></div>";

		echo "<b>����� ��. �� �����</b><br/>
		�����: <input type='text' name='sum5' size='4' maxlength='4' class='inup' /> ��. 
		<input type='submit' value='OK' name='from_check_pl' class='inup' /><br/>";

		echo "<div class=\"sep1\"></div><div class=\"sep2\"></div>";

		echo "<b>��������� ��. �� ������ ����</b><br/>
		�����: <input type='text' name='sum3' size='6' maxlength='".($db["adminsite"]?6:3)."' class='inup' /> ��.<br/>
		����� �����: <input type='text' name='to_check_id' size='10' class='inup' /><br/>
		����������: <input type='text' name='comment' size='10' class='inup' /> 
		<input type='submit' value='OK' name='other_check' class='inup' /><br/>";

		if ($db["admin_level"]>=10 || $db["dealer"])
		{	
			echo "<div class=\"sep1\"></div><div class=\"sep2\"></div>";

			echo "<b>��������� ��. �� ������ ����</b><br/>
			�����: <input type='text' name='sum6' size='5' maxlength='5' class='inup' /> ��.<br/>
			����� �����:  <input type='text' name='to_check_id_pl' size='10' class='inup' /> 
			<input type='submit' value='OK' name='other_check_pl' class='inup' /><br/>";
		}
		echo "</form>";
	}
	?>
</div>