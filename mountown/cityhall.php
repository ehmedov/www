<?
$login=$_SESSION['login'];
$page=$_GET['page'];
$city=$db["city_game"];
echo "<h3>�������� �������</h3>";

$money = sprintf ("%01.2f", $db["money"]);
$platina = sprintf ("%01.2f", $db["platina"]);

//-------------------------Add Glava-------------------------------------------
if ($page =="addglava" && $db['adminsite']>=1)
{	
	$clan_names=htmlspecialchars(addslashes($_GET['clansname']));
	if ($_POST["add_glava"])
	{
		$glava=htmlspecialchars(addslashes($_POST['glava']));
		$resultat=mysql_fetch_array(mysql_Query("SELECT * FROM clan WHERE name_short='".$clan_names."'"));
		mysql_query("UPDATE users SET chin='',clan_take='',glava='' WHERE login='".$resultat['glava']."'");
		mysql_query("UPDATE clan SET glava='' WHERE glava='".$resultat['glava']."'");
		
		$select=mysql_fetch_array(mysql_query("SELECT login FROM users WHERE login='".$glava."'"));
		if ($select)
		{	
			mysql_query("UPDATE clan SET glava='".$select['login']."' WHERE name_short='".$clan_names."'");
			mysql_query("UPDATE users SET clan='".$resultat['name']."',clan_short='".$resultat['name_short']."', clan_take=1,orden='".$resultat['orden']."', glava=1, chin='���' WHERE login='".$select['login']."'");
		}
	}
	if ($_POST["add_creator"])
	{
		$creator=htmlspecialchars(addslashes($_POST['creator']));
		$select=mysql_fetch_array(mysql_query("SELECT id FROM users WHERE login='".$creator."'"));
		if ($select)
		{	
			mysql_query("UPDATE clan SET creator='".$select['id']."' WHERE name_short='".$clan_names."'");
		}
	}
	$page="archive";
}
//-------------------------Delete Clan-------------------------------------------
if ($page =="deleteclan" && $db['adminsite']>=5)
{	
	$clan_names=htmlspecialchars(addslashes($_GET['clansname']));
	$delete = mysql_query("DELETE FROM clan WHERE name_short='".$clan_names."'");
	$update=mysql_query("UPDATE users SET clan='',clan_short='',chin='',clan_take='',orden='',glava='' where clan_short='".$clan_names."'");
	$page="archive";
}
//-------------------Reg Clan--------------------------------------------
if($_POST['clan_name'])
{
	$clan_name=htmlspecialchars(addslashes($_POST['clan_name']));
	$clan_name_short=md5(time());
	$clan_site=htmlspecialchars(addslashes($_POST['clan_site']));
	$userfile=htmlspecialchars(addslashes($_POST['userfile']));
	$clan_history=htmlspecialchars(addslashes($_POST['clan_history']));
	$clan_history = str_replace("\n","<BR>",$clan_history);
	$glava_fio=htmlspecialchars(addslashes($_POST['glava_fio']));
	$orden=(int)$_POST['orden'];
	$road="img/clan/";
	$clan_price = 2000;
	if(($clan_name=="") || ($glava_fio=="")||($_POST['clan_site']=="") || (!is_uploaded_file($_FILES['userfile']['tmp_name'])) || ($_POST['clan_history']=="") )
	{
        $msg="�� ��� ���� ������ ���������!";
    }
	else if($db["platina"]<$clan_price)
	{
        $msg="����� (".$clan_price." ��.) �� ����� ����� ������������ ��� ����������� �������!";
    }
    else if($db["level"]<8)
    {
        $msg="������� ����� ������� ������ ������������(c 8 ������).";
    }
    else if($db["clan"]!="")
    {
        $msg="�� ��� �������� � �������. �� �� ������ ������ ������ �� �������� �������.";
    }
    else if($db["orden"]!="" && $db["orden"]!="0")
    {
        $msg="�� �� ������ ������ ������ �� �������� �������.";
    }
    else
    {		
        $SEEK_NAME = mysql_query("SELECT * FROM clan WHERE name='".$clan_name."'");
        $NAME_D = mysql_fetch_array($SEEK_NAME);
        if($NAME_D)
        {
            $msg="�������� ������� <B>".$clan_name."</B> ��� ������! �������� ������ ��������.";
        }
        else
        {
	        if(is_uploaded_file($_FILES['userfile']['tmp_name']))
	        {
	        	$ext = strrchr($_FILES['userfile']['name'], ".");  
	        	if ($ext=='.gif') 
	  			{
	  				$size_img = getimagesize($HTTP_POST_FILES['userfile']['tmp_name']);
	      			if ($size_img['0']<=25 && $size_img['1']<=25)
	      			{
						$image = $road.$clan_name_short.$ext;
						
						// ���������� ���� �� ��������� ���������� ������� � ����� �������
						if (copy($_FILES['userfile']['tmp_name'], $image))
	           			{
							// ���������� ���� �� ��������� ����������
							unlink($HTTP_POST_FILES['userfile']['tmp_name']);
						}
						$msg="<b>������ ������.</b> <br>� ��������� ����� ��� ����� ����������� ������� ����������� � �� � ����� ������� ������ ���������� �� �������� ����� �������. 
						<br>����� ����������� �������� � ������ ����� �������� <b>".$clan_price." ��.</b> � ������� ���������.
						<br> � ������� ����������� �������� �� ����� ����� ������ ���� <b>".$clan_price." ��.</b>, ����� ���� ������ ����� ���������.";
						
						$chas = date("H");
						$date=date("d.m.Y-H:i:s", mktime($chas-$GSM));
						mysql_query("INSERT INTO clan_zayavka(name,name_short,site,znak,history,glava,glava_fio,date,confirm,orden) VALUES('".$clan_name."','".$clan_name_short."','".$clan_site."','".$image."','".$clan_history."','".$login."','".$glava_fio."','".$date."','0','".$orden."')");
	        		} 
	        		else 
	        		{ 
	        			$msg="��������� �������� ��������� 25x25!";
	        		}
	    		} 
	    		else 
	    		{ 
	    			$msg="����������� ���� ���� �� ��������� GIF-��������!";
	    		}
			}
			else
			{
				$msg="�� �� ������ ��������� ��������...";
			}
		}
	}
	$page="reg_clan";
}

?>
<div align=right>� ��� � �������: <B><?echo $money;?></b> ��. <b><?echo $platina;?></b> ��.</div>
<center>
	<input type=button class=button value="�������� �������" onClick="location.href='?page=reg_clan';">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type=button class=button value="������ ������ " onClick="location.href='?page=archive';">&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="button" class="btn" id="refresh" onclick="window.location='main.php?act=none'" value="��������">&nbsp;&nbsp;&nbsp;&nbsp;
	<input type=button class=button value=" ����� " onClick="location.href='main.php?act=go&level=remesl';">
</center>
<hr>
<?
echo "<font color=red>".$msg."&nbsp;</font>";
if(!$page)
{
	?>
	�� ������ ������� ���� ����������� �������� ���������������� � ���������� ���������������� ���. 
	��� �������� ��� � ����� �����������, ������ �������� ������� ���� ���������� ��� ������������ ������, ������������ ��� ����������� <i>������� </i>.
	����������� �������, �� ����� �������� ���� �����, � ���������� �� ������� �������� ������� ����, ������� ��� ����� �����. 
	��� ����������� ������� �� ������ ������������ ��� ���������: <br>
	     <ul>
			<br>
			<li>������ �������� <strong>20*20 </strong>
		    <li>�������� �������
		    <li>��������� ���� ���������� ������� 
		    <li>��� � ������� ����� �������
			<li>����� ������� ������ ���������� 4-�� ������ � ����.
	      	<br><br>
	    	<b>��������� ����������� �������!!!</b>
	        <br><img src="img/orden/2/0.gif"> ������� - 2000.00 ��.
			<br><img src="img/orden/3/0.gif"> ����� ���������� - 2000.00 ��.
			<br><img src="img/orden/4/0.gif"> ����� ����� - 2000.00 ��.
	    </ul>
	    <ul>
			<img src="img/orden/2/0.gif"> <b>�������</b> - 
			������ ����� ��������� ��������� �����, � ������� ��� ������� ���� ����. ������ ����� � ������� �����.<br>
			�������� ����� ���������� �������� ������������ � ����������. <br>
			��� �������� ���������,  ��������� ����� ��������� ������� ��������, ����������� �� ������ �������. <br>
			��������� ��������� � 21.00 �� 07.00 �� ���������� �������. <br>
			��������� � ������ �������� �����: <b>�������� �������</b> � <b>������</b>.<br>
			<img src="img/orden/3/0.gif"> <b>����� ����������</b> - 
			����� ���������� - ��������� ������� � ����������. <br>
			� ���� ���������� ���� ���������� ����������� � � ��� �������� ����������� �������� ������ �� ����� ��������.<br>
			<img src="img/orden/4/0.gif"> <b>����� �����</b> - 
			����� ���������� - ������ ����� � ������ ��������. <br>
			� ���� ���������� ���� ���������� ����������� � � ��� �������� ����������� �������� ������ �� ����� ��������.
		</ul>
	<?
}
//--------------------������� �������----------------------------------------------
if($page == "reg_clan")
{
	?>
	<form action='?page=reg_clan' name='reg_clan' method="POST" enctype="multipart/form-data" >				    
		<TABLE width="500" align="center" cellpadding="2" cellspacing="2">
		<tr><td colspan=2 align=center><h3>�������� �������</h3></td></tr>
		<TR>
			<TD width="50%">�������� �������<font color="red">*</font>:</TD>
			<TD width="50%"><INPUT size="30" class="input" name="clan_name"></TD>
		</TR>
						
		<TR>
			<TD width="50%">��� � �������<font color="red">*</font>:</TD>
			<TD width="50%"><INPUT size="30" class="input" name="glava_fio"></TD>
		</TR>	
			
		<TR>
			<TD>����� �����<font color="red">*</font>:</TD>
			<TD><INPUT size="30" class="input" name="clan_site"></TD>
		</TR>
			
		<TR>
			<TD width="50%">����������<font color="red">*</font>:</TD>
			<TD width="50%"><INPUT type="file" name="userfile" id="userfile" class="input"></TD>
		</TR>
		<TR>
			<TD width="50%">���������� �������<font color="red">*</font>:</TD>
			<TD width="50%">
				<select name="orden">
					<option value="2">������� - 2000 �������
					<option value="3">����� ���������� - 2000 �������
					<option value="4">����� ����� - 2000 �������
				</select>
			</TD>
		</TR>	
		<TR>
			<TD>������� �������<font color="red">*</font>:</TD>
			<TD><textarea rows="6" name="clan_history" cols="42" class="input"></textarea></TD>
		</TR>
		<TR>
		<TD align="center" colspan="2"><INPUT type="submit" class="input" value="������� �������"></TD>
		</TR>
		</TABLE>
	</FORM>
	<?
}
//---------------------------------------------------------------------------------------------------
else if($page == "archive")
{
	echo "<h3>����� ���������� � ��������������� ����� ������ WWW.Oldmeydan.Pe.Hu.</h3> ";
	$S = mysql_query("SELECT clan.*,users.login FROM clan LEFT JOIN users on users.id=clan.creator ORDER BY clan.orden DESC");
    while($DATA = mysql_fetch_array($S))
    {
        $name = $DATA["name"];
        $name_s = $DATA["name_short"];
        $glava = $DATA["glava"];
        $orden = $DATA["orden"];
        $creator = $DATA["login"];
        if(!$orden){$orden_i = "";}
        else if($orden == 2){$orden_i = "<img src='img/orden/2/0.gif'  alt='�������'>";}
        else if($orden == 3){$orden_i = "<img src='img/orden/3/0.gif'  alt='����� ����������'>";}
        else if($orden == 4){$orden_i = "<img src='img/orden/4/0.gif'  alt='����� �����'>";}

        $clan_i = "<img src='img/clan/$name_s.gif'  alt='".$name."' border=0>";
		echo "$orden_i $clan_i <B>$name</B> <a href='clan_inf.php?clan=$name_s' class=us2 target=$name_s><img src='img/h.gif' border=0></a> &nbsp; &nbsp; &nbsp;";
        if ($db['adminsite']>=1)
		{
			echo "<a href=?page=deleteclan&clansname=".$name_s."><img src='img/del.gif' border=0></a>
					<form action='?page=addglava&clansname=$name_s' method='post'>
						���: <input type=text name='glava' value='".$glava."' class=new size=30> <input type=submit value='OK' name='add_glava' class=new style='cursor:hand'>
						���������: <input type=text name='creator' value='".$creator."' class=new size=30> <input type=submit value='OK' name='add_creator' class=new style='cursor:hand'>
					</form>";
		}
		echo "<br>";
    }  
}
?>