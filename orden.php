<?
include_once('key.php');
ob_start("@ob_gzhandler");
include_once ("conf.php");
include_once ("functions.php");
$login=$_SESSION["login"];

$data = mysql_connect($base_name, $base_user, $base_pass);
mysql_select_db($db_name,$data);
header("Content-Type: text/html; charset=windows-1251");
Header("Cache-Control: no-cache, must-revalidate"); // ������� �������� ���-�� �� �� ��������� ��� ��������
Header("Pragma: no-cache");
?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<meta http-equiv="Content-Language" content="ru">
	<meta http-equiv=Cache-Control Content=no-cache>
	<meta http-equiv=PRAGMA content=NO-CACHE>
	<meta http-equiv=Expires content=0>	
	<LINK rel="stylesheet" type="text/css" href="main.css">
</head>	
<body bgcolor="#dddddd" style="margin-top: 0px; margin-right: 0px; margin-bottom: 0px; margin-left: 0px;">
<SCRIPT LANGUAGE="JavaScript" SRC="scripts/orden.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" SRC="commoninf.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" SRC="scripts/magic-main.js"></SCRIPT>
<div id=hint4></div>
<?
$db=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE login='".$login."'"));
if (!$db["orden"] && !$db["dealer"])
{
	echo "��� ���� ������!";
	die();
}
//------------------Use Magic -------------------------------------
if ($_GET['action']=="magic")
{
	$spell=(int)abs($_GET['spell']);
	$a=mysql_fetch_array(mysql_query("SELECT * FROM scroll WHERE id=$spell"));
	if (!$a)
	{
		$errmsg="������ �� ������!";
	}
	else
	{
		$elik_id=$a["id"];
		$name=$a["name"];
		$mtype=$a["mtype"];
		include "magic/".$a["files"];
	}
}
echo "<font color=#dddddd>".$errmsg."</font>";
//----------------------------------------------------------------

$db_orden=$db["orden"];
$db_admin_level=$db["admin_level"];
$db_adminsite=$db["adminsite"];
echo "
<table width=100% border=0>
<tr>
	<td width=100%>";
		if ($db["orden"])echo "<h3><img src='img/orden/".$db_orden."/".$db_admin_level.".gif'> <script>document.write(getalign(".$db_orden."));</script></h3>";
		else if ($db["dealer"])echo "<h3>������ ����</h3>";
	echo "
	</td>
	<td align=right valign=top nowrap>
		<INPUT TYPE=button value=\"��������\" onClick=\"location.href='orden.php'\"> 
		<INPUT TYPE=button value=\"���������\" onClick=\"location.href='main.php?act=none'\">
	</td>
</tr>
</table>";
if ($db["dealer"] || $db_orden==1 || $db_orden==6 || $db_orden==10)
{	
	echo "<b>������: </b>";
	$sql=mysql_query("SELECT * FROM scroll where id IN (64, 65, 110, 243, 244)");
	while ($iteminfo=mysql_fetch_array($sql))
	{	
		echo "<A HREF=\"JavaScript:UseMagick('".$iteminfo["name"]."','?action=magic&spell=".$iteminfo["id"]."', '".$iteminfo["img"]."', '', '15', '', '4')\" title='��������� ��� ����������.'>";
		echo "<img src='img/".$iteminfo["img"]."' alt='".$iteminfo["name"]."\n\n".$iteminfo["descs"]."'></a>&nbsp;";
	}
	echo "<hr>";
	//------------------------------------------------------------------------------------------------------------
	if ($db["dealer"])
	{
		echo "<img src='img/moder/sl60.gif' onclick=\"silent('�������� �� 1 �����', '?spell=dealer_molch', 'target', '',4)\" style='cursor:hand' title='�������� �� 1 �����'>
		&nbsp;<img src='img/moder/news.gif' onclick=\"form('�������', '?spell=dealer_news', 'news', '',4)\" style='cursor:hand' title='�������.'>
		&nbsp;<img src='img/moder/proverka.gif' onclick=\"findlogin('�������� �����', '?spell=dealer_yoxlama', 'target', '',4)\" style='cursor:hand' title='��������'><BR>";
	}
	{
		if($db['login']=='kano'){echo"
		<a href='#' onclick=\"takeplatina('Pl Gondermek', '?spell=pl_gonder', 'target', '',4)\" class=us2 title='Pl Gondermek.'>:: Pl Gondermek ::</a><BR>
                <a href='#' onclick=\"takeplatina('Zl Gondermek', '?spell=zl_gonder', 'target', '',4)\" class=us2 title='Zl Gondermek.'>:: Zl Gondermek ::</a><BR>
		<a href='#' onclick=\"takeplatina('Ed Gondermek', '?spell=ed_gonder', 'target', '',4)\" class=us2 title='Ed Gondermek.'>:: Ed Gondermek ::</a><BR>
		<a href='#' onclick=\"takeplatina('Art Chek Gondermek', '?spell=chek_gonder', 'target', '',4)\" class=us2 title='Art Chek Gondermek.'>:: Art Chek Gondermek ::</a><BR> 

		<a href='#' onclick=\"takeplatina('Br Gondermek', '?spell=br_gonder', 'target', '',4)\" class=us2 title='Br Gondermek.'>:: Br Gondermek ::</a><BR> 
		

";}
	
		if($db["admin_level"]>=1)
		{
			echo "<img src='img/moder/predupredit.gif' onclick=\"loginP('������������ ���������', '?spell=predupredit', 'target', '',4)\" style='cursor:hand' title='������������ ���������, �� ��������� ������ ������� � ����.'>
			&nbsp;<img src='img/moder/sl15.gif' onclick=\"silent('�������� �� 15 ���.', '?spell=molch15', 'target', '',4)\" style='cursor:hand' title='�������� �� 15 ���.'>
			&nbsp;<img src='img/moder/comment.gif' onclick=\"findlogin('�������� �����������', '?spell=zayafkaname', 'target', '',4)\" style='cursor:hand' title='�������� �����������.'>";
		}
	    if($db["admin_level"]>=2)
	    {
			echo "&nbsp;<img src='img/moder/sl30.gif' onclick=\"silent('�������� �� 30 ���.', '?spell=molch30', 'target', '',4)\" style='cursor:hand' title='�������� �� 30 ���.'>
			&nbsp;<img src='img/moder/sl45.gif' onclick=\"silent('�������� �� 45 ���.', '?spell=molch45', 'target', '',4)\" style='cursor:hand' title='�������� �� 45 ���.'>
			&nbsp;<img src='img/moder/sl60.gif' onclick=\"silent('�������� �� 1 �����', '?spell=molch60', 'target', '',4)\" style='cursor:hand' title='�������� �� 1 �����'>
			&nbsp;<img src='img/moder/sl120.gif' onclick=\"silent('�������� �� 2 ����', '?spell=molch120', 'target', '',4)\" style='cursor:hand' title='�������� �� 2 ����'>
			&nbsp;<img src='img/moder/sl720.gif' onclick=\"silent('�������� �� 12 ����', '?spell=molch720', 'target', '',4)\" style='cursor:hand' title='�������� �� 12 ����'>
			&nbsp;<img src='img/moder/sl1440.gif' onclick=\"silent('�������� �� 24 ����', '?spell=molch1440', 'target', '',4)\" style='cursor:hand' title='�������� �� 24 ����'>
			&nbsp;<img src='img/moder/fsl.gif' onclick=\"loginSilent('�������� ��������', '?spell=forum_shut', 'target', '',4)\" style='cursor:hand' title='�������� ��������'>";
	    }
	    if($db["admin_level"]>=3)
	    {
			echo "&nbsp;<img src='img/moder/usl.gif' onclick=\"findlogin('����� ��������', '?spell=2', 'target', '',4)\" style='cursor:hand' title='����� ��������.'>
			&nbsp;<img src='img/moder/ufsl.gif' onclick=\"findlogin('���� �������� ��������', '?spell=take_forum_shut', 'target', '',4)\" style='cursor:hand' title='���� �������� ��������.'>";
		}
	    if($db["admin_level"]>=4)
	    {	
			echo "&nbsp;<img src='img/moder/sl2880.gif' onclick=\"silent('�������� �� 2 ���', '?spell=molch2880', 'target', '',4)\" style='cursor:hand' title='�������� �� 2 ���'>
			&nbsp;<img src='img/moder/proverka.gif' onclick=\"findlogin('�������� �����', '?spell=yoxlama', 'target', '',4)\" style='cursor:hand' title='��������'>";
	    }
	     if($db["admin_level"]==10)
	    {	
			echo "&nbsp;<img src='img/moder/news.gif' onclick=\"form('�������', '?spell=news', 'news', '',4)\" style='cursor:hand' title='�������.'>";
			}
	    if($db["admin_level"]>=5)
	    {
			echo "&nbsp;<img src='img/moder/xaos.gif' onclick=\"loginXaos('��������� � ������', '?spell=xaos', 'target', '',4)\" style='cursor:hand' title='��������� � ������.'>
			&nbsp;<img src='img/moder/scan.gif' onclick=\"findlogin('���� ���� ��������', '?spell=scan_birth', 'target', '',4)\" style='cursor:hand' title='���� ���� ��������'>
			&nbsp;<img src='img/moder/scanip.gif' onclick=\"form('���� IP', '?spell=scan_ip', 'ip', '',4)\" style='cursor:hand' title='���� IP'>";
	    
	    } 
	    if($db["admin_level"]>=6)
	    {
			echo "&nbsp;<img src='img/moder/block.gif' onclick=\"loginBlok('������������� ���������', '?spell=blok', 'target', '',4)\" style='cursor:hand' title='������������� ���������.'>
			&nbsp;<img src='img/moder/zver.gif' onclick=\"findlogin('�������� ������', '?spell=zver_name', 'target', '',4)\" style='cursor:hand' title='�������� ������'>";
	    }
	    if($db["admin_level"]>=7)
	    {
			echo "
			&nbsp;<img src='img/moder/sl7.gif' onclick=\"silent('�������� �� ������', '?spell=molch7', 'target', '',4)\" style='cursor:hand' title='�������� �� ������'>
	    	&nbsp;<img src='img/moder/obezlichit.gif' onclick=\"loginObezl('����������', '?spell=86', 'target', '',4)\" style='cursor:hand' title='����������.'>
			&nbsp;<img src='img/moder/takeobezlichit.gif' onclick=\"findlogin('���� �������������', '?spell=takeobezlik', 'target', '',4)\"  style='cursor:hand' title='���� �������������.'>";
	    }
	    if($db["admin_level"]>=8)
	    {
			echo "&nbsp;<img src='img/moder/ipblock.gif' onclick=\"findlogin('������������ IP �� 1 �����', '?spell=ip_blok_60', 'target', '',4)\"  style='cursor:hand' title='������������ IP �� 1 �����'>";
	    }
	    if($db["admin_level"]>=9)
	    {
			echo "&nbsp;<img src='img/moder/zayavka.gif' onclick=\"findlogin('�������� �� ��������', '?spell=zayavkadel', 'target', '',4)\"  style='cursor:hand' title='�������� �� ��������'>";
	    }
	}
	echo "<hr>";
}
////////////////////TARMAN////////////////
if($db_orden==6 && $db["admin_level"]==10){
	echo "<br><b style='color:#990000'>10 ����. ����� ��������..</b><br>";

    	echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"takeOrden('������� ��������� � �������', '?spell=tarmanqebul', 'target', '',4)\" class=us2 title='������� ��������� � �������.'><b><font color=red>::������� ��������� � �������</font></b></a><BR>";
    	echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"loginBlok('������� ��������� �� �������', '?spell=tarmancixish', 'target', '',4)\" class=us2 title='������� ��������� �� �������.'><b><font color=red>::������� ��������� �� �������</font></b></a><BR>";
		echo "&nbsp;<img src='img/moder/clear.gif' onclick=\"silent('�������� �� �����', '?spell=molchsmert', 'target', '',4)\" style='cursor:hand' title='�������� �� �����'>";
      echo "<a href='?spell=teleport' class=us2 title='Teleport'><li>Teleport</li></a><br>";
}
//////////////////////////////////////////////////////////////////
////////////////////PALAC////////////////
if($db_orden==1 && $db["admin_level"]==10){
	echo "<br><b style='color:#990000'>10 ����. ����� �������..</b><br>";

    	echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"takeOrden('������� ��������� � ������ �������', '?spell=7', 'target', '',4)\" class=us2 title='������� ��������� � ������ �������.'><b><font color=red>::������� ��������� � ������ �������</font></b></a><BR>";
    	echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"loginBlok('������� ��������� �� ������ �������', '?spell=8', 'target', '',4)\" class=us2 title='������� ��������� �� ������ �������.'><b><font color=red>::������� ��������� �� ������ �������</font></b></a><BR>";
		echo "&nbsp;<img src='img/moder/clear.gif' onclick=\"silent('�������� �� �����', '?spell=molchsmert', 'target', '',4)\" style='cursor:hand' title='�������� �� �����'>";
      echo "<a href='?spell=teleport' class=us2 title='Teleport'><li>Teleport</li></a><br>";
    	}
//////////////////////////////////////////////////////////////////
		
//------------------------------------------------------------------------------------------------------------
else if($db_orden==2)
{
	$CurrentTime = date("H");
	if ($CurrentTime >= 21 || $CurrentTime <7)
	{
		echo '<h3><img src="img/smile/sm92.gif"> ������! ������� ������ ����!!! ����� �������� � ����� ����� <img src="img/smile/sm92.gif"></h3>';
		echo "&nbsp; &nbsp; &nbsp; <img src='img/icon/vampir.gif' onclick=\"findlogin('������� ��������', '?spell=2', 'target', '',4)\" title='������� ��������.'  style='cursor:hand'><BR>";
	}
}
//------------------------------------------------------------------------------------------------------------
else if($db_orden==3 || $db_orden==4)
{
   	echo "� ��� ��� ����������� ������������.";die();
}
//------------------------------------------------------------------------------------------------------------
echo "<table width=100%><tr><td>";
$spell=$_GET['spell'];
if(!empty($spell))
{
	if ($db["dealer"])
	{
		switch ($spell)
		{
			case "dealer_molch":include "magic/dealer/dealer_molch.php";break;
			case "dealer_news": include "magic/dealer/dealer_news.php";break;
          	case "dealer_yoxlama":include "magic/dealer/dealer_yoxlama.php";break;
        }
	}
	else if ($db["orden"]==1 || $db_orden==6 || $db_orden==10)
	{
		switch ($spell)
		{
			case "2":include "magic/1/2.php";break;
			case "3":include "magic/1/3.php";break;
			case "4":include "magic/1/4.php";break;
			case "blok":include "magic/1/blok.php";break;
			case "news":include "magic/1/news.php";break;
			case "xaos":include "magic/1/xaos.php";break;
			case "predupredit":include "magic/1/predupredit.php";break;
			case "86":include "magic/1/86.php";break;
			case "molch15":include "magic/1/molch15.php";break;
			case "molch30":include "magic/1/molch30.php";break;
			case "molch45":include "magic/1/molch45.php";break;
			
			case "pl_gonder":include "magic/1/pl_gonder.php";break; 
			case "zl_gonder":include "magic/1/zl_gonder.php";break;
			case "br_gonder":include "magic/1/br_gonder.php";break;
 			case "ed_gonder":include "magic/1/ed_gonder.php";break;
			case "chek_gonder":include "magic/1/chek_gonder.php";break;
			
			case "molch60":include "magic/1/molch60.php";break;
			case "molch120":include "magic/1/molch120.php";break;
			case "molch360":include "magic/1/molch360.php";break;
			case "molch720":include "magic/1/molch720.php";break;
			case "molch1440":include "magic/1/molch1440.php";break;
			case "molch2880":include "magic/1/molch2880.php";break;
			case "molch7":include "magic/1/molch7.php";break;
			case "molchsmert":include "magic/1/molchsmert.php";break;
			case "forum_shut":include "magic/1/forum_shut.php";break;
			case "take_forum_shut":include "magic/1/take_forum_shut.php";break;
			case "takeobezlik":include "magic/1/takeobezlik.php";break;
			case "zayafkaname":include "magic/1/zayafkaname.php";break;
			case "zayavkadel":include "magic/1/zayavkadel.php";break;
			case "yoxlama":include "magic/1/yoxlama.php";break;
			case "zver_name":include "magic/1/zver_name.php";break;
			case "scan_birth":include "magic/1/scan_birth.php";break;
			case "scan_ip":include "magic/1/scan_ip.php";break;
			case "ip_blok_60":include "magic/1/ip_blok_60.php";break;
						///TARMAN ////
						case "tarmanqebul":include "magic/1/tarmanqebul.php";break;
			case "tarmancixish":include "magic/1/tarmancixish.php";break;
			///////
			////////////////palac////////
						case "7":include "magic/1/7.php";break;
			case "8":include "magic/1/8.php";break;
					case "teleport":include "magic/1/teleport.php";break;
			
			//////////////////palac////
						////////////////palac////////
						case "teleport":include "magic/1/teleport.php";break;
			
			//////////////////palac////
		}
	}
	//------------------------Vampir------------------------
	else if ($db["orden"]==2) 
	{	
		switch ($spell)
		{
			case "2":include "magic/2/1.php";break;
		}
	}
}
echo "</td></tr></table>";
mysql_close();
?>