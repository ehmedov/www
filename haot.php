<?
include ("key.php");
ob_start("@ob_gzhandler");
include ("conf.php");
include ("functions.php");

$users_count=50;

header("Content-type: text/html; charset=windows-1251");
header("Cache-Control: no-cache, must-revalidate"); // ������� �������� ���-�� �� �� ��������� ��� ��������
header("Pragma: no-cache");

$login=$_SESSION['login'];
$act=$_GET['act'];
$rooms=array("room1","room2","room3","room4","room5","room6","room1_angels","room2_angels","room3_angels","room4_angels","room5_angels","room6_angels");

$data = mysql_connect($base_name, $base_user, $base_pass) or die('�� ���������� ������������. ��������� ��� �������, ��� ������������ � ������!');
mysql_select_db($db_name) or die('������ ����� � ���� ������');

$db = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE login='".$login."'"));
if($db["battle"]!=0){Header("Location: battle.php");die();}

$ip=$db["remote_ip"];
//----------------------------------------------
$cure_hp=$db["cure_hp"];
$time_to_cure=$cure_hp-time();
$hhh=$db["hp_all"];
if($db["battle"]==0)
{
	if($time_to_cure>0)
	{
		$cure_full = $db["cure_time"]-$db["cure"];
		$percent_hp=floor((100*$time_to_cure)/$cure_full);
		$percent=100-$percent_hp;
		$hp[0]=floor(($hhh*$percent)/100);
		mysql_query("UPDATE users SET hp='".$hp[0]."' WHERE login='".$login."'");
	}
	else
	{
		$hp[0]=$db["hp_all"];
		mysql_query("UPDATE users SET hp='".$hp[0]."',cure_hp='0' WHERE login='".$login."'");
	}
}
$hp[1]=$db["hp_all"];
//----------------------------------------------
?>
<HEAD>	
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<meta http-equiv="Content-Language" content="ru">
	<META Http-Equiv=Cache-Control Content="no-cache, max-age=0, must-revalidate, no-store">
	<meta http-equiv=PRAGMA content=NO-CACHE>
	<meta http-equiv=Expires content=0>	
	<LINK REL=StyleSheet HREF='main.css' TYPE='text/css'>
</HEAD>
<body bgcolor="#faeede">
<script language="JavaScript" type="text/javascript" src="commoninf.js"></script>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align=left valign=middle>
    	<?echo "<script>drwfl('".$db['login']."','".$db['id']."','".$db['level']."','".$db['dealer']."','".$db['orden']."','".$db['admin_level']."','".$db['clan_short']."','".$db['clan']."');</script>";?>
		<span id="HP" style="font-size:10px"></span>&nbsp;<img src="img/icon/grey.jpg" alt="������� �����" name="HP1" width="1" height="10" id="HP1"><img src="img/icon/grey.jpg" alt="������� �����" name="HP2" width="1" height="10" id="HP2"><span style="width:1px; height:10px"></span>
		<script>top.setHP(<?echo $hp[0].",".$hp[1].",100";?>);</script>	
	</td>
    <td  align=right valign=middle>
   	 	<INPUT TYPE=button value="��������" onclick="location.href='haot.php'">
		<INPUT TYPE=button class="podskazka" value="���������" onclick="window.open('help/zayavka.php','displayWindow','height=400,width=500,resizable=no,scrollbars=yes,menubar=no,status=no,toolbar=no,directories=no,location=no')"/>
		<INPUT TYPE=button value="���������" onclick="location.href='main.php?act=none';">
	</td>
  </tr>
</table>
<table align="center" width="100%" border="0">
  	<tr class=m>
		<td width="14%" class="m" align="center"><a href="#" onclick="document.location.href='zayavkatrain.php'" class="f">�������������</a></td>
		<td width="14%" class="m" align="center"><a href="#" onclick="document.location.href='zayavka.php'" class="f">���������</a></td>
		<td width="14%" class="m" align="center"><a href="#" onclick="document.location.href='group_zayavka.php'" class="f">���������</a></td>
		<td width="14%" class="s" align="center"><a href="#" onclick="document.location.href='haot.php'" class="f">�����������</a></td>
		<td width="14%" class="m" align="center"><a href="#" onclick="document.location.href='during.php'" class="f">�������</a></td>
		<td width="14%" class="m" align="center"><a href="#" onclick="document.location.href='archive.php'" class="f">��������</a></td>
	</tr>	
</table>
��������� ��� - ������������� ����������, ��� ������ ����������� �������������. ��� �� ��������, ���� ��������� ������ 4-� �������.
<BR>
<?
if(!in_array($db["room"],$rooms))
{
	echo "<center><b style='color: #ff0000'>� ���� ������� ���������� �������� ������.</b></center>";
}
else if ($db["level"]<2)
{
	echo "<center><b style='color: #ff0000'>����������� ��� �������� � 2-��� ������</b></center>";
}
else if(!empty($db["travm"]))
{
	echo "<center><b style='color: #ff0000'>�� �� ������ �������, �.�. ������ ������������!<br>��� ��������� �����!</b></center>";
}
else
{
	//---------------------------Komandaya girmek---------------------
	if($_POST["gocombat"])
	{
		$in=(int)$_POST["gocombat"];
		$podal=($db['zayavka']==1?true:false);
		$have_art=mysql_fetch_Array(mysql_query("SELECT count(*) FROM inv WHERE `owner`='".$login."' and `object_razdel` = 'obj' and `wear`=1 and art=2"));
		if($podal)
		{	
		    $msg="�� �� ������ ������� ������ ������. ������� �������� �������...";
	    }
		else if($db["hp_all"]/3 > $db["hp"])
		{
			$msg="�� ������� ��������� ��� ��������! ��������������!";
		}
		else if(is_wear($login)<4 && $db["level"]>=8)
	    {
		    $msg="��� ������ � ��� ������ ���� ����� ������� 4 �����.";
	    }
	    else
	    {
		    $D=mysql_fetch_array(mysql_query("SELECT * FROM zayavka WHERE creator='".$in."' and status!=3"));
		    if ($D)
		    {
		    	if ($D["artoff"] && $have_art[0]>0)
		    	{
		    		$msg="���� ��� ��� ����������";
		    	}
		    	else
		    	{	
					$c_t=mysql_fetch_array(mysql_query("SELECT count(*) FROM teams WHERE battle_id=".$in));
					if ($c_t[0]>=$users_count){$msg="�������� $users_count ������...";}
					else
					{
			            if($db["level"]<$D["minlev1"] || $db["level"]>$D["maxlev1"])
			            {
			                $msg="�� �� ��������� �� ������ ��� ����� ��������.";
			            }
			            else
			            {	
			        		mysql_query("INSERT INTO teams(player,team,ip,battle_id) VALUES('".$login."','1','".$ip."','".$D["creator"]."')");
			        		mysql_query("UPDATE users SET zayavka=1 WHERE login='".$login."'");
							mysql_query("set @noc:=2;");
							mysql_query("UPDATE teams INNER JOIN (SELECT teams.player FROM teams LEFT JOIN users ON users.login = teams.player WHERE teams.battle_id = '".$D["creator"]."') as k on teams.player=k.player set team=CASE @noc WHEN 1 THEN @noc:=2 WHEN 2 THEN @noc:=1 END ;");
							#mysql_query("UPDATE teams INNER JOIN (SELECT teams.player FROM teams LEFT JOIN users ON users.login = teams.player WHERE teams.battle_id = '".$D["creator"]."' ORDER BY users.exp DESC) as k on teams.player=k.player set team=CASE @noc WHEN 1 THEN @noc:=2 WHEN 2 THEN @noc:=1 END ;");

			        		$db['zayavka']=1;
			        		$_SESSION["battle_ref"] = 0;
			        	}
					}
				}
        	}
		}
	}
	/*===================Zayavka vermek==========================================*/
	if($act=="submit")
	{
		$podal=($db['zayavka']==1?true:false);
		$have_art=mysql_fetch_Array(mysql_query("SELECT count(*) FROM inv WHERE `owner`='".$login."' and `object_razdel` = 'obj' and `wear`=1 and art=2"));

		if($db["hp_all"]/3 > $db["hp"])
		{
			$msg="�� ������� ��������� ��� ��������! ��������������!";
		}
		else if($podal)
		{
		    $msg="�� �� ������ ������ ����� ������. ������� �������� �������...";
	    }
	    else if(is_wear($login)<4 && $db["level"]>=8)
	    {
		    $msg="��� ������ � ��� ������ ���� ����� ������� 4 �����.";
	    }	
	    else if($_POST["artoff"] && $have_art[0]>0)
	    {
		    $msg="���� ��� ��� ����������";
	    }
		else
		{	
			$mine_id=$db["id"];
			$battle_type=(int)$_POST['hand'];
			$wait_to=$_POST['stime']*60+time();
			$battle_timeout=(int)$_POST['timeout'];
			$comment=htmlspecialchars(addslashes($_POST['fight_comment']));
			$teams_level=(int)$_POST["teams_level"];
			if($_POST["hidden"]){$hidden=1;$comment="";}
			if($_POST["artoff"]){$artoff=1;}
			
			if($teams_level==0){$friend_minlevel=2; $friend_maxlevel=35;}
			if($teams_level==1){$friend_minlevel=2; $friend_maxlevel=$db["level"];}
			if($teams_level==2){$friend_minlevel=2; if ($db['level']==2)$friend_maxlevel=2;else $friend_maxlevel=$db['level']-1;}
			if($teams_level==3){$friend_minlevel=$db["level"]; $friend_maxlevel=$db["level"];}
			if($teams_level==4){$friend_minlevel=$db['level']; $friend_maxlevel=$db["level"]+1;}
			if($teams_level==5){if  ($db['level']==2)$friend_minlevel=2;	else $friend_minlevel=$db['level']-1;$friend_maxlevel=$db['level'];}
			if($teams_level==6){$friend_minlevel=$db['level']; $friend_maxlevel=35;}
			if($teams_level==7){if  ($db['level']==2)$friend_minlevel=2;	else $friend_minlevel=$db['level']-1;$friend_maxlevel=$db['level']+1;}
			
			mysql_query("INSERT INTO zayavka(status,type,timeout,creator,minlev1,maxlev1,wait,comment,city,room,hidden,artoff) VALUES('1','".$battle_type."','".$battle_timeout."','".$mine_id."','".$friend_minlevel."','".$friend_maxlevel."','".$wait_to."','".$comment."','".$db["city_game"]."','".$db["room"]."','".$hidden."','".$artoff."')");
			mysql_query("INSERT INTO teams(player,team,ip,battle_id,hitted,over) VALUES('".$login."','1','".$ip."','".$mine_id."','0','0')");
			mysql_query("UPDATE users SET zayavka=1 WHERE login='".$login."'"); 
			$msg="������ �� ��� ������...";
			$db['zayavka']=1;
			$_SESSION["battle_ref"] = 0;
		}
	}
	/*=============================================================*/
	$podal=($db['zayavka']==1?true:false);
	if ($podal)
	{
		echo "<script>
				function refreshPeriodic()
				{
					location.href='haot.php';
					timerID=setTimeout('refreshPeriodic()',20000);
				}
				timerID=setTimeout('refreshPeriodic()',20000);
			</script>";
	}	
	if(!$podal)
	{
		echo "<input type=button value='������ ������ �� ��������� ���' class=new onClick=\"javascript:location.href='?act=podat'\">";
	}
	//-------------------zayavka vermek-------------------------
	if($act=="podat")
	{
		?>
		<form action='?act=submit' name='zayava' method='post'>
		<FIELDSET style="width:600px; border:1px outset;">
			<LEGEND><B>������ ������ �� ��������� ���</B></LEGEND>
    		<table cellspacing="5" cellpadding="0"><tr><td>
			������ ��� �����:
			<select name="stime">
				<?if($db['login']==NoPaLiT){echo"<option value=\"1\" selected>1 ���.";}?>
				<option value="3" selected>3 ���.
				<option value="5">5 ���.
				<option value="10">10 ���.
				<option value="15">15 ���.
				<option value="20">20 ���.
				<option value="25">25 ���.
				<option value="30">30 ���.
			</select>
			
			��� ���:
			<select name="hand">
				<option value=5 selected>� �������
				<option value=102>��������
			</select>
			
			����� �� ���:
			<select name="timeout">
				<option value="1" selected>1 ���.
				<option value="2">2 ���.
				<option value="3">3 ���.
				<option value="4">4 ���.
				<option value="5">5 ���.
				<option value="10">10 ���.
			</select>
				
			<br>������� ������:
			<SELECT NAME='teams_level'>
				<option value=0 selected>����� �������
				<option value=1>������ ����� � ����
				<option value=6>������ ����� � ����
				<option value=3>������ ����� ������
				<option value=4>�� ������ ���� ����� ��� �� �������
				<option value=5>�� ������ ���� ����� ��� �� �������
				<option value=7>��� ������� +1 � -1
			</SELECT>
			<BR>
			����������� � ���: <INPUT TYPE=text NAME=fight_comment maxlength=40 size=40><br>
			<INPUT TYPE='checkbox' NAME='hidden'> ��������� ��� (<font class=dsc>�� ����� ����������� � ������. +5% �����</font>)<BR>
			<INPUT TYPE='checkbox' NAME='artoff'> ��� ����������<BR>
			<INPUT TYPE=submit name=open value="������ ������">&nbsp;
			</td></tr></table>
		</FIELDSET>
		</form>	
		<?
	}
	//---------------------------------------------------------------
	echo "<br><font style='color:#ff0000'>".$msg."</font>";
	echo "<form method='post' action=''>";
	if(!$podal)echo "<INPUT TYPE=submit value='������� �������' NAME=confirm><BR>";
	$Q=mysql_query("SELECT * FROM zayavka WHERE type IN (5,6,7,102) and city='".$db["city_game"]."' ORDER BY date DESC");
	while($DATA=mysql_fetch_array($Q))
	{
		$mine_z=0;
		$creator=$DATA["creator"];
		$left_time=$DATA["wait"]-time();
		$left_min=floor($left_time/60);
		$left_sec=$left_time-$left_min*60;
		$begin_count=($DATA["type"]==7?1:4);
		$MY_QUERY=mysql_fetch_array(mysql_query("SELECT count(*) FROM teams WHERE battle_id='".$creator."' and player='".$login."'"));
		if ($MY_QUERY[0]>0)
		{
			$mine_z = 1; // ���������, ��� �-�� ������ ��������� � �������� �����
		}

		if ($left_time>0 && $DATA["status"]!=3)
		{
			echo "<div style='padding: 4px;'>";
			if(!$podal)
			{
				echo "<INPUT TYPE=radio NAME=gocombat value=$creator>";
			}
			echo "<font class='date'>".($mine_z?"<u>":"").substr($DATA["date"],10,9)."</u></font> ";
			$teams_players="";
			$QUERY=mysql_query("SELECT login,level,id,orden,admin_level,clan,clan_short,dealer FROM teams LEFT JOIN users on users.login=teams.player WHERE teams.battle_id='".$creator."'");
			while($DAT=mysql_fetch_array($QUERY))
			{
				$team_count++;
				$player="<script>drwfl('".$DAT['login']."','".$DAT['id']."','".$DAT['level']."','".$DAT['dealer']."','".$DAT['orden']."','".$DAT['admin_level']."','".$DAT['clan_short']."','".$DAT['clan']."');</script>";
				if ($creator==$DAT["id"])$player="<u>".$player."</u>";
	        	$teams_players.=$comma.$player;
				$comma=",&nbsp;&nbsp;";
			}
	        echo "(".($DATA["hidden"]?"<i>����������</i>":$teams_players).")";
			echo " �������: (".$DATA["minlev1"]."-".$DATA["maxlev1"].") ";
			echo "<img src='img/battletype/".($DATA["type"]==5 || $DATA["type"]==7?"1.gif' border=0 alt='��� � �������'":(($DATA["type"]==102)?"3.gif' border=0 alt='�������� ���'":"2.gif' border=0 alt='�������� ���'")).">";				
			echo "&nbsp;  (������� ".$DATA["timeout"]." ���.) ".($DATA["artoff"]?" [��� ��� ����������] ":"");
			echo "<i style='color:gray;'>��� �������� ����� ".$left_min." ���. ".$left_sec." ���. ".($DATA["comment"]?"(�����������: ".str_replace("&amp;","&",$DATA["comment"]).")":"")."</i>";
			echo "</div>";
			$comma="";
		}
		else
	    {
	    	$Q_T2=mysql_query("SELECT teams.player FROM teams LEFT JOIN users ON users.login = teams.player WHERE teams.battle_id = '".$creator."' ORDER BY users.hp_all DESC");
	        if(mysql_num_rows($Q_T2)<$begin_count)
	        {
	        	while($res_sql=mysql_fetch_Array($Q_T2))
	        	{
	        		mysql_query("UPDATE users SET zayavka=0 WHERE login='".$res_sql["player"]."'");
	        		say($res_sql['player'],"������ �� �������, ��� �������� �� �����... (��� �� ��������, ���� ��������� ������ 4-� �������.)",$res_sql['player']);
	        	}
				mysql_query("DELETE FROM zayavka WHERE creator=".$creator);
	            mysql_query("DELETE FROM teams WHERE battle_id=".$creator);
	        }
	        else if($mine_z==1)
	        {
	        	/*
	        	mysql_query("set @noc:=2;");
	        	mysql_query("UPDATE teams INNER JOIN (SELECT teams.player FROM teams LEFT JOIN users ON users.login = teams.player WHERE teams.battle_id = '".$creator."' ORDER BY users.hp_all DESC) as k on teams.player=k.player set team=CASE @noc WHEN 1 THEN @noc:=2 WHEN 2 THEN @noc:=1 END ;");
            	
            	$haos_team=1;
            	while ($participant=mysql_fetch_array($Q_T2)) 
                {
                	mysql_query("UPDATE teams SET team=".$haos_team." WHERE player='".$participant['player']."';");
					if($haos_team==1)$haos_team=2;
                	else if($haos_team==2)$haos_team=1;
                }*/
                startBattle($creator);
	        }
		}
	}
	echo "</form>";
}
mysql_close();
?>