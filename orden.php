<?
include_once('key.php');
ob_start("@ob_gzhandler");
include_once ("conf.php");
include_once ("functions.php");
$login=$_SESSION["login"];

$data = mysql_connect($base_name, $base_user, $base_pass);
mysql_select_db($db_name,$data);
header("Content-Type: text/html; charset=windows-1251");
Header("Cache-Control: no-cache, must-revalidate"); // говорим браузеру что-бы он не кешировал эту страницу
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
	echo "Вам сюда нельзя!";
	die();
}
//------------------Use Magic -------------------------------------
if ($_GET['action']=="magic")
{
	$spell=(int)abs($_GET['spell']);
	$a=mysql_fetch_array(mysql_query("SELECT * FROM scroll WHERE id=$spell"));
	if (!$a)
	{
		$errmsg="Свиток не найден!";
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
		else if ($db["dealer"])echo "<h3>Диллер Игры</h3>";
	echo "
	</td>
	<td align=right valign=top nowrap>
		<INPUT TYPE=button value=\"Обновить\" onClick=\"location.href='orden.php'\"> 
		<INPUT TYPE=button value=\"Вернуться\" onClick=\"location.href='main.php?act=none'\">
	</td>
</tr>
</table>";
if ($db["dealer"] || $db_orden==1 || $db_orden==6 || $db_orden==10)
{	
	echo "<b>Свитки: </b>";
	$sql=mysql_query("SELECT * FROM scroll where id IN (64, 65, 110, 243, 244)");
	while ($iteminfo=mysql_fetch_array($sql))
	{	
		echo "<A HREF=\"JavaScript:UseMagick('".$iteminfo["name"]."','?action=magic&spell=".$iteminfo["id"]."', '".$iteminfo["img"]."', '', '15', '', '4')\" title='Прочитать это заклинание.'>";
		echo "<img src='img/".$iteminfo["img"]."' alt='".$iteminfo["name"]."\n\n".$iteminfo["descs"]."'></a>&nbsp;";
	}
	echo "<hr>";
	//------------------------------------------------------------------------------------------------------------
	if ($db["dealer"])
	{
		echo "<img src='img/moder/sl60.gif' onclick=\"silent('Молчанка на 1 часов', '?spell=dealer_molch', 'target', '',4)\" style='cursor:hand' title='Молчанка на 1 часов'>
		&nbsp;<img src='img/moder/news.gif' onclick=\"form('Новость', '?spell=dealer_news', 'news', '',4)\" style='cursor:hand' title='Новость.'>
		&nbsp;<img src='img/moder/proverka.gif' onclick=\"findlogin('Проверка БОЙЦА', '?spell=dealer_yoxlama', 'target', '',4)\" style='cursor:hand' title='Проверка'><BR>";
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
			echo "<img src='img/moder/predupredit.gif' onclick=\"loginP('Предупредить персонажа', '?spell=predupredit', 'target', '',4)\" style='cursor:hand' title='Предупредить персонажа, за нарушения правил общения в чате.'>
			&nbsp;<img src='img/moder/sl15.gif' onclick=\"silent('Молчанка на 15 мин.', '?spell=molch15', 'target', '',4)\" style='cursor:hand' title='Молчанка на 15 мин.'>
			&nbsp;<img src='img/moder/comment.gif' onclick=\"findlogin('Очистить комментарий', '?spell=zayafkaname', 'target', '',4)\" style='cursor:hand' title='Очистить комментарий.'>";
		}
	    if($db["admin_level"]>=2)
	    {
			echo "&nbsp;<img src='img/moder/sl30.gif' onclick=\"silent('Молчанка на 30 мин.', '?spell=molch30', 'target', '',4)\" style='cursor:hand' title='Молчанка на 30 мин.'>
			&nbsp;<img src='img/moder/sl45.gif' onclick=\"silent('Молчанка на 45 мин.', '?spell=molch45', 'target', '',4)\" style='cursor:hand' title='Молчанка на 45 мин.'>
			&nbsp;<img src='img/moder/sl60.gif' onclick=\"silent('Молчанка на 1 часов', '?spell=molch60', 'target', '',4)\" style='cursor:hand' title='Молчанка на 1 часов'>
			&nbsp;<img src='img/moder/sl120.gif' onclick=\"silent('Молчанка на 2 часа', '?spell=molch120', 'target', '',4)\" style='cursor:hand' title='Молчанка на 2 часа'>
			&nbsp;<img src='img/moder/sl720.gif' onclick=\"silent('Молчанка на 12 часа', '?spell=molch720', 'target', '',4)\" style='cursor:hand' title='Молчанка на 12 часа'>
			&nbsp;<img src='img/moder/sl1440.gif' onclick=\"silent('Молчанка на 24 часа', '?spell=molch1440', 'target', '',4)\" style='cursor:hand' title='Молчанка на 24 часа'>
			&nbsp;<img src='img/moder/fsl.gif' onclick=\"loginSilent('Форумная Молчанка', '?spell=forum_shut', 'target', '',4)\" style='cursor:hand' title='Форумная Молчанка'>";
	    }
	    if($db["admin_level"]>=3)
	    {
			echo "&nbsp;<img src='img/moder/usl.gif' onclick=\"findlogin('Снять молчанку', '?spell=2', 'target', '',4)\" style='cursor:hand' title='Снять молчанку.'>
			&nbsp;<img src='img/moder/ufsl.gif' onclick=\"findlogin('Снят Форумную молчанку', '?spell=take_forum_shut', 'target', '',4)\" style='cursor:hand' title='Снят Форумную молчанку.'>";
		}
	    if($db["admin_level"]>=4)
	    {	
			echo "&nbsp;<img src='img/moder/sl2880.gif' onclick=\"silent('Молчанка на 2 дня', '?spell=molch2880', 'target', '',4)\" style='cursor:hand' title='Молчанка на 2 дня'>
			&nbsp;<img src='img/moder/proverka.gif' onclick=\"findlogin('Проверка БОЙЦА', '?spell=yoxlama', 'target', '',4)\" style='cursor:hand' title='Проверка'>";
	    }
	     if($db["admin_level"]==10)
	    {	
			echo "&nbsp;<img src='img/moder/news.gif' onclick=\"form('Новость', '?spell=news', 'news', '',4)\" style='cursor:hand' title='Новость.'>";
			}
	    if($db["admin_level"]>=5)
	    {
			echo "&nbsp;<img src='img/moder/xaos.gif' onclick=\"loginXaos('Отправить в тюрьму', '?spell=xaos', 'target', '',4)\" style='cursor:hand' title='Отправить в тюрьму.'>
			&nbsp;<img src='img/moder/scan.gif' onclick=\"findlogin('Скан День рождения', '?spell=scan_birth', 'target', '',4)\" style='cursor:hand' title='Скан День рождения'>
			&nbsp;<img src='img/moder/scanip.gif' onclick=\"form('Скан IP', '?spell=scan_ip', 'ip', '',4)\" style='cursor:hand' title='Скан IP'>";
	    
	    } 
	    if($db["admin_level"]>=6)
	    {
			echo "&nbsp;<img src='img/moder/block.gif' onclick=\"loginBlok('Заблокировать персонажа', '?spell=blok', 'target', '',4)\" style='cursor:hand' title='Заблокировать персонажа.'>
			&nbsp;<img src='img/moder/zver.gif' onclick=\"findlogin('Изменить кличку', '?spell=zver_name', 'target', '',4)\" style='cursor:hand' title='Изменить кличку'>";
	    }
	    if($db["admin_level"]>=7)
	    {
			echo "
			&nbsp;<img src='img/moder/sl7.gif' onclick=\"silent('Молчанка на неделю', '?spell=molch7', 'target', '',4)\" style='cursor:hand' title='Молчанка на неделю'>
	    	&nbsp;<img src='img/moder/obezlichit.gif' onclick=\"loginObezl('Обезличить', '?spell=86', 'target', '',4)\" style='cursor:hand' title='Обезличить.'>
			&nbsp;<img src='img/moder/takeobezlichit.gif' onclick=\"findlogin('Снят Обезличивания', '?spell=takeobezlik', 'target', '',4)\"  style='cursor:hand' title='Снят Обезличивания.'>";
	    }
	    if($db["admin_level"]>=8)
	    {
			echo "&nbsp;<img src='img/moder/ipblock.gif' onclick=\"findlogin('Блокирование IP на 1 часов', '?spell=ip_blok_60', 'target', '',4)\"  style='cursor:hand' title='Блокирование IP на 1 часов'>";
	    }
	    if($db["admin_level"]>=9)
	    {
			echo "&nbsp;<img src='img/moder/zayavka.gif' onclick=\"findlogin('Выкинуть из поединка', '?spell=zayavkadel', 'target', '',4)\"  style='cursor:hand' title='Выкинуть из поединка'>";
	    }
	}
	echo "<hr>";
}
////////////////////TARMAN////////////////
if($db_orden==6 && $db["admin_level"]==10){
	echo "<br><b style='color:#990000'>10 ранг. Глава ТАРМАНОВ..</b><br>";

    	echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"takeOrden('Принять персонажа в ТАРМАНЫ', '?spell=tarmanqebul', 'target', '',4)\" class=us2 title='Принять персонажа в ТАРМАНЫ.'><b><font color=red>::Принять персонажа в ТАРМАНЫ</font></b></a><BR>";
    	echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"loginBlok('Изгнать персонажа из ТАРМАНЫ', '?spell=tarmancixish', 'target', '',4)\" class=us2 title='Изгнать персонажа из ТАРМАНЫ.'><b><font color=red>::Изгнать персонажа из ТАРМАНЫ</font></b></a><BR>";
		echo "&nbsp;<img src='img/moder/clear.gif' onclick=\"silent('Молчанка на Смерт', '?spell=molchsmert', 'target', '',4)\" style='cursor:hand' title='Молчанка на Смерт'>";
      echo "<a href='?spell=teleport' class=us2 title='Teleport'><li>Teleport</li></a><br>";
}
//////////////////////////////////////////////////////////////////
////////////////////PALAC////////////////
if($db_orden==1 && $db["admin_level"]==10){
	echo "<br><b style='color:#990000'>10 ранг. Глава Палачей..</b><br>";

    	echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"takeOrden('Принять персонажа в Стражи Порядка', '?spell=7', 'target', '',4)\" class=us2 title='Принять персонажа в Стражи Порядка.'><b><font color=red>::Принять персонажа в Стражи Порядка</font></b></a><BR>";
    	echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"loginBlok('Изгнать персонажа из Стражи Порядка', '?spell=8', 'target', '',4)\" class=us2 title='Изгнать персонажа из Стражи Порядка.'><b><font color=red>::Изгнать персонажа из Стражи Порядка</font></b></a><BR>";
		echo "&nbsp;<img src='img/moder/clear.gif' onclick=\"silent('Молчанка на Смерт', '?spell=molchsmert', 'target', '',4)\" style='cursor:hand' title='Молчанка на Смерт'>";
      echo "<a href='?spell=teleport' class=us2 title='Teleport'><li>Teleport</li></a><br>";
    	}
//////////////////////////////////////////////////////////////////
		
//------------------------------------------------------------------------------------------------------------
else if($db_orden==2)
{
	$CurrentTime = date("H");
	if ($CurrentTime >= 21 || $CurrentTime <7)
	{
		echo '<h3><img src="img/smile/sm92.gif"> ТЕМНЫЕ! СЕГОДНЯ ПОЛНАЯ ЛУНА!!! МОЖНО КУСАТЬСЯ В ЛЮБОЕ ВРЕМЯ <img src="img/smile/sm92.gif"></h3>';
		echo "&nbsp; &nbsp; &nbsp; <img src='img/icon/vampir.gif' onclick=\"findlogin('Напасть вампиром', '?spell=2', 'target', '',4)\" title='Напасть вампиром.'  style='cursor:hand'><BR>";
	}
}
//------------------------------------------------------------------------------------------------------------
else if($db_orden==3 || $db_orden==4)
{
   	echo "У Вас нет специальных возможностей.";die();
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