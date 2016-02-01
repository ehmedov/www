<?
include ("key.php");
include ("../conf.php");

$my_login = $_SESSION["login"];

$data=mysql_connect($base_name, $base_user, $base_pass) or die('Не получается подключиться. Проверьте имя сервера, имя пользователя и пароль!');
mysql_select_db($db_name) or die('Ошибка входа в базу данных');

Header("Cache-Control: no-cache, must-revalidate"); // говорим браузеру что-бы он не кешировал эту страницу
Header("Pragma: no-cache");
$attacker=array();
$defender=array();
$sql=mysql_query("SELECT defender FROM clan_battle WHERE attacker='".$_SESSION["clan_short"]."'");
while($have=mysql_fetch_array($sql))
{
	$attacker[]=$have["defender"];
}
$sql=mysql_query("SELECT attacker FROM clan_battle WHERE defender='".$_SESSION["clan_short"]."' and type=2");
while($have=mysql_fetch_array($sql))
{
	$defender[]=$have["attacker"];
}
//-------------------------------------------------------------------
$spath=session_save_path()."/";
$userler="";
$room=$_SESSION['my_room'];
$all_online=mysql_fetch_array(mysql_query("SELECT count(*) FROM online"));
$users= mysql_query("SELECT users.login, users.id, users.dealer, users.level, users.orden, users.admin_level, users.adminsite, users.clan_short, users.clan, users.shut, users.travm, online.uniqPCID FROM online LEFT JOIN users on users.login=online.login WHERE online.room='".$room."' ORDER BY users.admin_level DESC,users.dealer DESC,users.clan DESC");
$co=mysql_num_rows($users);
while ($onl= mysql_fetch_array($users))
{
	$war=0;
	if(in_Array($onl["clan_short"],$attacker))$war=1;
	if(in_Array($onl["clan_short"],$defender))$war=1;
	if (in_Array($room,array("arena","room4","room3")))$war=0;
	$shut=$onl['shut']-time();
	$shut=($shut>0)?1:0;
	$sfile="sess_".$onl["uniqPCID"];
	if((time()- @fileatime($spath.$sfile))> 900)
	{	
        mysql_query("DELETE FROM online WHERE login='".$onl["login"]."'");
        @unlink($spath.$sfile);
    }
   	if ($onl['adminsite']<2)
   	{
   		$userler.="usr('".$onl['login']."','".$onl['id']."','".$onl['level']."','".$onl['dealer']."','".$onl['orden']."','".$onl['admin_level']."','".$onl['clan_short']."','".$onl['clan']."','".$shut."','".$onl['travm']."','".$war."');\n";
	}
	else $co=$co-1;
}
mysql_free_result($users);
//-------------------------------------------------------------------
include_once('../otaqlar.php');
$how="<b>".$mesto." [".$co." из ".$all_online[0]."]</b>\n";
$users=$userler;
?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<meta http-equiv="Content-Language" content="ru">
	<META Http-Equiv=Cache-Control Content="no-cache, max-age=0, must-revalidate, no-store">
	<meta http-equiv=PRAGMA content=NO-CACHE>
	<meta http-equiv=Expires content=0>
	<meta http-equiv="Page-Enter" content="BlendTrans(Duration=0.1)">
</head>	
<SCRIPT LANGUAGE="JavaScript">
function getalign(align)
{
	var n=parseFloat(align);
	if (n == 1) return("Стражи порядка");
	if (n == 2) return("Вампиры");
	if (n == 3) return("Орден Равновесия");
	if (n == 4) return("Орден Света");
	if (n == 5) return("Тюремный заключеный");
	if (n == 6) return("Истинный Мрак");
	if (n == 7) return("Исчадие Хаоса");
	if (n == 100) return("Смертные");
	return("");
}
function usr(name, id, level, dealer, align, rang, klan, klanid, slp, trv,war)
{
	var s="";
	s+="<nobr><a href=\"javascript:top.AddToPrivate('"+name+"')\"><img border='0' src='../img/arrow3.gif' alt='Приватное сообщение' ></a> ";
	if (align>0) s+="<img src='../img/orden/"+align+"/"+rang+".gif'  alt=\""+getalign(align)+"\" border='0' /></a> ";
	if (dealer>0)s+="<img src='../img/orden/dealer.gif' border=0 alt=\"Диллер игры\">";

	if (klan) s+="<a href='../clan_inf.php?clan="+klan+"' target='_blank'><img src='../img/clan/"+klan+".gif'  alt='Ханство "+klanid+"' border='0' /></A>";
	if (name=='Хранитель Войны')s+=" <a onClick='top.frames.main.document.location=\"../help.php\"; return false;'><font color=#996600>"+name+"</font></a>["+level+"]";
	else if (name=='Торговец Вискаль')s+=" <a onClick='top.frames.main.document.location=\"../help_shop.php\"; return false;'><font color=#996600>"+name+"</font></a>["+level+"]";
	else if (name=='Ведунья')s+=" <a onClick='top.frames.main.document.location=\"../help_flower.php\"; return false;'><font color=#996600>"+name+"</font></a>["+level+"]";
	else if (name=='Механик Торвальдс')s+=" <a onClick='top.frames.main.document.location=\"../help_rep.php\"; return false;'><font color=#996600>"+name+"</font></a>["+level+"]";
	else if (name=='Защитник')s+=" <a onClick='top.frames.main.document.location=\"../help_municip.php\"; return false;'><font color=#996600>"+name+"</font></a>["+level+"]";
	else if (name=='Путешественник')s+=" <a onClick='top.frames.main.document.location=\"../help_pochta.php\"; return false;'><font color=#996600>"+name+"</font></a>["+level+"]";
	else if (name=='Банкир')s+=" <a onClick='top.frames.main.document.location=\"../help_banker.php\"; return false;'><font color=#996600>"+name+"</font></a>["+level+"]";
	else s+=" <a href='javascript:top.AddTo(\""+name+"\")'>"+name+"</a>["+level+"]";
	if (id!=-1) s+=" <a href='../info.php?log="+name+"' target=_blank><img src='../img/index/h.gif' alt='Инф. о "+name+"' border='0' /></a>";
	if (slp>0) { s+=' <img src=\"../img/index/molch.gif\" alt=\"Наложено заклятие молчания\">'; }
	if (trv>0) { s+=' <img src=\"../img/index/travma.gif\" alt=\"Персонаж травмирован\">'; }
	if (war==1){ s+=" <b><a href='#' onclick='top.frames.main.document.location=\"../main.php?post_attack="+id+"\";'><img src='../img/b.jpg' border=0></a></b>";}
	
	s+='</nobr><br>';

	document.write(s);
}
function go()
{
  	top.frames['users'].location='users.php?'+Math.random();
}
function go_city()
{
  	top.frames['users'].location='chat/users.php?'+Math.random();
}
</script>
<body style="margin-top: 0px; margin-right: 0px; margin-bottom: 0px; margin-left: 10px;" bgcolor="#faeede"  background='../img/design/who-bgr1.jpg' style="scrollbar-base-color:#E9E9E9;scrollbar-face-color:#E9E9E9;scrollbar-track-color: #E9E9E9;        scrollbar-arrow-color: Gray;scrollbar-darkshadow-color: Silver;scrollbar-highlight-color: Silver;scrollbar-shadow-color: Gray;scrollbar-3dlight-color: Gray; font-family: Verdana; font-size: 10pt; font-color:#000000;" >
<link rel='stylesheet' href='chatstyle.css' type='text/css'>
<table border='0' width='100%'>
<tr>
<td nowrap align='center'>
	<input type='button' onclick='go();' value='Обновить' style='cursor:hand' /><br/>
	<?echo $how?>
	<hr style="border: 0;height: 1px;color: #000000;background-color:#000000;" />
</td>
</tr>
<tr>
	<td style="white-space:nowrap">
		<?
			if ($room=="room1")echo "<script>usr('Хранитель Войны','1','10','0','0','0','','','0','0','0');</script>\n";
			if ($room=="smith")echo "<script>usr('Торговец Вискаль','1','11','0','0','0','','','0','0','0');</script>\n";
			if ($room=="flower")echo "<script>usr('Ведунья','1','10','0','0','0','','','0','0','0');</script>\n";
			if ($room=="rep")echo "<script>usr('Механик Торвальдс','1','10','0','0','0','','','0','0','0');</script>\n";
			if ($room=="municip")echo "<script>usr('Защитник','1','10','0','1','10','','','0','0','0');</script>\n";
			if ($room=="pochta")echo "<script>usr('Путешественник','1','10','0','0','0','','','0','0','0');</script>\n";
			if ($room=="bank")echo "<script>usr('Банкир','1','11','1','0','0','','','0','0','0');</script>\n";
			
		?>
		<script><?=$users;?></script>
	</td>
</tr>
</table>
</body>
</html>	