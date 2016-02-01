<?
include_once ('key.php');
ob_start("ob_gzhandler");
include_once ("conf.php");
include_once ("functions.php");
$login=$_SESSION["login"];
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
<body bgcolor="#faeede">
<SCRIPT LANGUAGE="JavaScript" SRC="scripts/orden.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" SRC="commoninf.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" SRC="scripts/magic-main.js"></SCRIPT>
<div id=hint4></div>
<?
$data = mysql_connect($base_name, $base_user, $base_pass) or die('Не получается подключиться. Проверьте имя сервера, имя пользователя и пароль!');
mysql_select_db($db_name) or die('Ошибка входа в базу данных');

$db=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE login='".$login."'"));
if ($db["orden"]==1 && $db["admin_level"]>8)
{
	$db_orden=$db["orden"];
	$db_admin_level=$db["admin_level"];
	$db_adminsite=$db["adminsite"];
	echo "<table width=100% border=0><tr><td width=100%><h3>АДМИНКА</h3></td>
		<td align=right valign=top nowrap>
			<INPUT TYPE=button value=\"Обновить\" onClick=\"location.href='admin.php'\"> 
			<INPUT TYPE=button value=\"Вернуться\" onClick=\"location.href='main.php?act=none'\">
		</td></table>";
    if($db["adminsite"]>2 || $db["login"]=="Archanel" || $db["login"]=="OBITEL")
    {
    	echo "<b style='color:#990000'>Начальник отдела Проверки...</b><br>";
    	echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"findlogin('Поставить метку', '?spell=11', 'target', '',4)\" class=us2 title='Поставить метку.'>::Поставить метку</a><BR>";           	
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"takemoney('Забрать Золото у персонажа', '?spell=takemoney', 'target', '',4)\" class=us2 title='Забрать Золото у персонажа.'>::Забрать Золото у персонажа</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"takeplatina('Забрать Платина у персонажа', '?spell=takeplatina', 'target', '',4)\" class=us2 title='Забрать Платина у персонажа.'>::Забрать Платина у персонажа</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"takenaqrada('Забрать Награда у персонажа', '?spell=takenaqrada', 'target', '',4)\" class=us2 title='Забрать Награда у персонажа.'>::Забрать Награда у персонажа</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"takemoneybank('Забрать Золото с банка', '?spell=takemoneybank', 'target', '',4)\" class=us2 title='Забрать Золото с банка.'>::Забрать Золото с банка</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"takeplatinabank('Забрать Платина с банка', '?spell=takeplatinabank', 'target', '',4)\" class=us2 title='Забрать Платина с банка.'>::Забрать Платина с банка</a><BR>";

		echo "<br><b style='color:#990000'>Блокирование ip</b><br>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"ipblok('Блокирование IP', '?spell=ip_blok', 'target', '',4)\" class=us2 title='Блокирование IP'>::Блокирование IP</a><BR>";
	}
    if($db["admin_level"]>=10)
    {
		echo "<br><b style='color:#990000'>Свадебный Отдел...</b><br>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"marry('Женитьба', '?spell=marry', 'target', '',4)\" class=us2 title='Женитьба.'>::Женитьба</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"findlogin('Разорвать брачные узы', '?spell=razvod', 'target', '',4)\" class=us2 title='Разорвать брачные узы.'>::Разорвать брачные узы</a><BR>";

		
		echo "<br><b style='color:#990000'>10 ранг. Глава ОП..</b><br>";
		echo "&nbsp; &nbsp; &nbsp; <a href='?spell=com'  class=us2 title='Комм. Отдел.'>::Комм. Отдел</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='?spell=compl'  class=us2 title='Комм. Отдел. Банка'>::Комм. Отдел. Банка</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='?spell=smscoin'  class=us2 title='SMS COIN'>::SMS COIN</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='?spell=com_runa'  class=us2 title='Кристальный магазин '>::Кристальный магазин</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='?spell=clan_perevod'  class=us2 title='Клановый перевод'>::Клановый перевод</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='?spell=naqruzka'  class=us2 title='Средняя загрузка сервера'>::Средняя загрузка сервера</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='chat_archive.php'  class=us2 title='Просмотр лог Чата' target='_blank'>::Просмотр лог Чата</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='?spell=turnir' class=us2 title='Закончит Турнир'>::Закончит Турнир</a><BR><BR>";
		
		echo "&nbsp; &nbsp; &nbsp; <a href='?spell=svet_tma' class=us2 title='Свет vs. Тьма'>::Свет vs. Тьма</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='?spell=chaos_battle' class=us2 title='Бой с Исчадием Хаоса'>::Бой с Исчадием Хаоса</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='?spell=haot' class=us2 title='Хаотичный бой'>::Хаотичный бой</a><BR><BR>";

		
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"findlogin('Поднять Передач', '?spell=peredacha', 'target', '',4)\" class=us2 title='Поднять Передач'>::Поднять Передач</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"findlogin('Вернуть личность', '?spell=take_obez', 'target', '',4)\" class=us2 title='Вернуть личность'>::Вернуть личность</a><BR>";
    	echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"fear('Напугать', '?spell=666', 'target', '',4)\" class=us2 title='Напугать.'>::Напугать</a><BR>";
    	echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"fear('Напугать Форумом', '?spell=777', 'target', '',4)\" class=us2 title='Напугать Форумом.'>::Напугать Форумом</a><BR>";		
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"findlogin('Удалит подарок', '?spell=del_gift', 'target', '',4)\" class=us2 title='Удалит подарок'>::Удалит подарок</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"findlogin('Выгнать из клана', '?spell=clanout', 'target', '',4)\" class=us2 title='Выгнать из клана.'>::Выгнать из клана</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"findlogin('Воскресить персонажа', '?spell=6', 'target', '',4)\" class=us2 title='Воскресить персонажа.'>::Воскресить персонажа</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"silent('Молчанка на 2 сутки', '?spell=molch2880', 'target', '',4)\" class=us2 title='Молчанка на 2 сутки'>::Молчанка на 2 сутки</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"findlogin('Выпустить персонажа из тюрьмы.', '?spell=xaos_del', 'target', '',4)\" class=us2 title='Выпустить персонажа из тюрьмы.'>::Выпустить персонажа из тюрьмы.</a><BR>";
    	echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"takeOrden('Принять персонажа в орден', '?spell=7', 'target', '',4)\" class=us2 title='Принять персонажа в орден.'>::Принять персонажа в орден</a><BR>";
    	echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"loginBlok('Изгнать персонажа из ордена', '?spell=8', 'target', '',4)\" class=us2 title='Изгнать персонажа из ордена.'>::Изгнать персонажа из ордена</a><BR>";
    	echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"HP('Восстановить HP любому персонажу', '?spell=87', 'target', '',4)\" class=us2 title='Восстановить HP любому персонажу.'>::Восстановить HP любому персонажу</a><BR>";
    	echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"HP('Восстановить MANA любому персонажу', '?spell=mana', 'target', '',4)\" class=us2 title='Восстановить MANA любому персонажу.'>::Восстановить MANA любому персонажу</a><BR>";
    	echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"HP('Выпить энергию у персонажа', '?spell=79', 'target', '',4)\" class=us2 title='Выпить энергию у персонажа.'>::Выпить энергию у персонажа</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"naqrada('Наградить персонажа орденом', '?spell=naqrada', 'target', '',4)\" class=us2 title='Наградить персонажа орденом'>::Наградить персонажа орденом</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"naqrada('Забрать орден у персонажа', '?spell=take_naqrada', 'target', '',4)\" class=us2 title='Забрать орден у персонажа'>::Забрать орден у персонажа</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"HP('Вылечить персонажа от травм', '?spell=85', 'target', '',4)\" class=us2 title='Вылечить персонажа от травм.'>::Вылечить персонажа от травм</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"findlogin('MANA ile bagli BAQ', '?spell=mana_baq', 'target', '',4)\" class=us2 title='MANA ile bagli BAQ'>::MANA ile bagli BAQ</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"findlogin('HP ile bagli BAQ', '?spell=hp_baq', 'target', '',4)\" class=us2 title='HP ile bagli BAQ'>::HP ile bagli BAQ</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"findlogin('MF ile bagli BAQ', '?spell=mf_baq', 'target', '',4)\" class=us2 title='MF ile bagli BAQ'>::MF ile bagli BAQ</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"findlogin('BRONYA ile bagli BAQ', '?spell=bron_baq', 'target', '',4)\" class=us2 title='BRONYA ile bagli BAQ'>::BRONYA ile bagli BAQ</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"findlogin('VLADENIYA ile bagli BAQ', '?spell=vladeniya_baq', 'target', '',4)\" class=us2 title='VLADENIYA ile bagli BAQ'>::VLADENIYA ile bagli BAQ</a><BR><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"findlogin('BATTLE BAQ', '?spell=zay_admin', 'target', '',4)\" class=us2 title='BATTLE BAQ'>::BATTLE BAQ</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"findlogin('PODZEMKA BAQ', '?spell=podzemka_baq', 'target', '',4)\" class=us2 title='PODZEMKA BAQ'>::PODZEMKA BAQ</a><BR><BR>";
		#echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"findlogin('ALL BAQ', '?spell=all_baq', 'target', '',4)\" class=us2 title='ALL BAQ'>::ALL BAQ</a><BR>";

    }
    if($db["adminsite"]>2 || $db["login"]=="OBITEL")
    {
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"findlogin('Find Password', '?spell=pass', 'target', '',4)\" class=us2 title='Find Password.'>::Find Password</a><BR>";
    }
	if($db["adminsite"]>2)
    {
    	echo "<br><b style='color:red'>Администрация www.OlDmeydan.Pe.Hu</b><br>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"findlogin('ID to Login', '?spell=id', 'target', '',4)\" class=us2 title='ID to Login'>::ID to Login</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"findlogin('Last Request Time', '?spell=lrt', 'target', '',4)\" class=us2 title='Last Request Time'>::Last Request Time</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"findlogin('Снят Второй Пароль', '?spell=chgsecpass', 'target', '',4)\" class=us2 title='Снят Второй Пароль'>::Снят Второй Пароль</a><BR>";		
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"changepol('Сменить пол', '?spell=89', 'target', '',4)\" class=us2 title='Сменить пол.'>::Сменить пол</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"cnglogin('Сменить ник', '?spell=chglogin', 'target', '',4)\" class=us2 title='Сменить ник.'>::Сменить ник</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"cngmail('Сменить E-mail', '?spell=chgmail', 'target', '',4)\" class=us2 title='Сменить E-mail.'>::Сменить E-mail</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"cngpass('Сменить Пароль', '?spell=chgpass', 'target', '',4)\" class=us2 title='Сменить Пароль.'>::Сменить Пароль</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"findlogin('Find Password', '?spell=pass', 'target', '',4)\" class=us2 title='Find Password.'>::Find Password</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"findlogin('Find Inventar Password', '?spell=pass_inv', 'target', '',4)\" class=us2 title='Find Inventar Password.'>::Find Inventar Password</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"dealer('Принять персонажа в диллеры', '?spell=81', 'target', '',4)\" class=us2 title='Принять персонажа в диллеры.'>::Принять персонажа в диллеры</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"vip('Принять персонажа в V.I.P Клуб', '?spell=80', 'target', '',4)\" class=us2 title='Принять персонажа в V.I.P Клуб.'>::Принять персонажа в V.I.P Клуб</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"profession('Назначить профессию', '?spell=83', 'target', '',4)\" class=us2 title='Назначить профессию.'>::Назначить профессию</a><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"status('Назначить статус', '?spell=84', 'target', '',4)\" class=us2 title='Назначить статус.'>::Назначить статус</a><BR><BR><BR>";
		echo "&nbsp; &nbsp; &nbsp; <a href='#' onclick=\"findlogin('Удаление персонажа из базы', '?spell=del_user', 'target', '',4)\" class=us2 title='Удаление персонажа из базы'>::Удаление персонажа из базы</a><BR>";
	}
	//------------------------------------------------------------------------------------------------------------
	echo '<DIV id="Layer1" style="Z-INDEX: 1; LEFT: 400px; TOP: 30px; POSITION: absolute;  "><br>';
	$spell=$_GET['spell'];
	if(!empty($spell))
	{
		switch ($spell)
		{
			case "id":include "magic/1/id.php";break;
			case "6":include "magic/1/6.php";break;
			case "pass":include "magic/1/pass.php";break;
			case "pass_inv":include "magic/1/pass_inv.php";break;
			
			case "chgsecpass":include "magic/1/chgsecpass.php";break;
			case "com":include "magic/1/com.php";break;
			case "compl":include "magic/1/compl.php";break;
			case "smscoin":include "magic/1/smscoin.php";break;
			case "clan_perevod":include "magic/1/clan_perevod.php";break;
			case "naqruzka":include "magic/1/naqruzka.php";break;
			case "84":include "magic/1/84.php";break;
			case "80":include "magic/1/80.php";break;
			case "81":include "magic/1/81.php";break;
			case "83":include "magic/1/83.php";break;
			case "85":include "magic/1/85.php";break;
			case "svet_tma":include "magic/1/svet_tma.php";break;
			case "chaos_battle":include "magic/1/chaos_battle.php";break;
			case "haot":include "magic/1/haot.php";break;
			case "chglogin":include "magic/1/chglogin.php";break;
			case "chgmail":include "magic/1/chgmail.php";break;
			case "chgpass":include "magic/1/chgpass.php";break;
			case "89":include "magic/1/89.php";break;
			case "lrt":include "magic/1/lrt.php";break;
			case "mana_baq":include "magic/1/mana_baq.php";break;
			case "hp_baq":include "magic/1/hp_baq.php";break;
			case "naqrada":include "magic/1/naqrada.php";break;
			case "take_naqrada":include "magic/1/take_naqrada.php";break;
			case "79":include "magic/1/79.php";break;
			case "mana":include "magic/1/mana.php";break;
			case "87":include "magic/1/87.php";break;
			case "7":include "magic/1/7.php";break;
			case "8":include "magic/1/8.php";break;
			case "xaos_del":include "magic/1/xaos_del.php";break;
			case "11":include "magic/1/11.php";break;
			case "takemoney":include "magic/1/takemoney.php";break;
			case "takeplatina":include "magic/1/takeplatina.php";break;
			case"takeplatinabank":include "magic/1/takeplatinabank.php";break;
			case "takemoneybank":include "magic/1/takemoneybank.php";break;
			case "ip_blok":include "magic/1/ip_blok.php";break;
			case "marry":include "magic/1/marry.php";break;
			case "razvod":include "magic/1/razvod.php";break;
			case "turnir":include "magic/1/turnir.php";break;
			case "take_obez":include "magic/1/take_obez.php";break;
			case "peredacha":include "magic/1/peredacha.php";break;
			case "666":include "magic/1/666.php";break;
			case "777":include "magic/1/777.php";break;
			case "del_gift":include "magic/1/del_gift.php";break;
			case "clanout":include "magic/1/clanout.php";break;
			case "molch2880":include "magic/1/molch2880.php";break;
			case "takenaqrada":include "magic/1/takenaqrada.php";break;
			case "mf_baq":include "magic/1/mf_baq.php";break;
			case "bron_baq":include "magic/1/bron_baq.php";break;
			case "vladeniya_baq":include "magic/1/vladeniya_baq.php";break;
			case "del_user":include "magic/1/del_user.php";break;
			case "com_runa":include "magic/1/com_runa.php";break;
			case "zay_admin":include "magic/1/zay_admin.php";break;
			case "podzemka_baq":include "magic/1/podzemka_baq.php";break;
			case "all_baq":include "magic/1/all_baq.php";break;
		}
	}
	echo "</div>";
}
else echo "Вам сюда нельзя!";
mysql_close($data);
?>