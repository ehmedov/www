<?
include_once("key.php");
include_once("conf.php");
include_once("functions.php");
include_once("item_des.php");
ob_start("ob_gzhandler");
Header("Cache-Control: no-cache, must-revalidate"); // говорим браузеру что-бы он не кешировал эту страницу
Header("Pragma: no-cache");
$login=$_SESSION['login'];
$data = mysql_connect($base_name, $base_user, $base_pass) or die('Не получается подключиться. Проверьте имя сервера, имя пользователя и пароль!');
mysql_select_db($db_name) or die('Ошибка входа в базу данных');

$result = mysql_query("SELECT users.*,zver.id as zver_count,zver.obraz as zver_obraz,zver.level as zver_level,zver.name as zver_name,zver.type as zver_type FROM `users` LEFT join zver on zver.owner=users.id  and zver.sleep=0 WHERE login='".$login."'");
$db = mysql_fetch_assoc($result);
?>
<html>
<HEAD>	
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<meta http-equiv="Content-Language" content="ru">
	<META Http-Equiv=Cache-Control Content="no-cache, max-age=0, must-revalidate, no-store">
	<meta http-equiv=PRAGMA content=NO-CACHE>
	<meta http-equiv=Expires content=0>	
	<LINK REL=StyleSheet HREF='main.css' TYPE='text/css'>
</HEAD>
<body bgcolor=#dddddd topMargin=0 leftMargin=0 rightMargin=0 bottomMargin=0 style="background-image: url(img/index/dungeon_bg.jpg);background-repeat:no-repeat;background-position:top right">
<DIV id="slot_info" style="VISIBILITY: hidden; POSITION: absolute;z-index: 1;"></DIV>
<script language="JavaScript" type="text/javascript" src="show_inf.js"></script>
<script language="JavaScript" type="text/javascript" src="commoninf.js"></script>
<script language="JavaScript" type="text/javascript" src="glow.js"></script>

<script>
function talk(phrase)
{
	if(phrase==0)
	{
		document.location.href='main.php?act=none';
	}
	if(phrase==1)
	{
		bernard.innerHTML='<B>Хранитель Войны:</B><BR>- Хм... что же, давай приступим к твоему обучению, в этом мире не выжить без определенных навыком.<BR><BR>'+
		'<a href="javascript:talk(3)" class=us2><B>• Да, время не ждет, расскажи мне обо всем.</B></a><BR>'+
		'<a href="javascript:talk(0)" class=us2><B>• К сожалению мне пора идти. (Завершить диалог)</B></a>';
	}
	if(phrase==2)
	{
		bernard.innerHTML='<B>Хранитель Войны:</B><BR>- Ах, среди нас появился еще один умник. '+
		'Вы сияете ярче солнца, не так ли? Ну что же, если Вы считаете, что знаете все, позвольте проверить Ваши знания. '+
		'Вы должны провести поединок с ненастоящим противником. Он силен. Но вы знаете о силе все, не так ли? Вы готовы?<BR><BR>'+
		'<a href="javascript:talk(0)" class=us2><B>• Пожалуй, я пойду потренеруюсь еще. (Завершить диалог)</B></a>';
	}
	if(phrase==3)
	{
		bernard.innerHTML='<B>Хранитель Войны:</B><BR>- Хорошо, хорошо. Я только надеюсь, что Вы запомните что я Вам расскажу. '+
		'Начнем с основного. Пока Ваше здоровье полное - Вы живы. Ваше здоровье - HP, находится над Вашим образом. '+
		'Каждый удар противника по Вам отнимает некотрое количество Вашего здоровья, в конце концов здоровье упадет до нуля, и Вы умрете. '+
		'Конечно жаль, но Вы привыкните к этому. После окончания боя вы будете возращены к жизни. '+
		'Вы можете съесть что-нибудь или использовать магию, чтобы восстановление Вашего здоровья проходило быстрее. '+
		'Чем быстрее Вы будете восстанавливаться - тем быстрее Вы сможете принять участие в новом бою. Так что же, Вы все поняли о HP?<BR><BR>'+
		'Всего у тебя есть 4 характеристики – Сила, Ловкость, Удача и Выносливость. Они влияют на то, как ты будешь сражаться на просторах этого мира.<br>'+
		'<b>Сила</b> – очень важный параметр. Чем выше твоя сила, тем большее количество вещей ты сможешь носить в своем рюкзаке. Кроме того, от силы зависит наносимый тобой урон и уровень выносливости.<br>'+
		'<b>Ловкость</b> влияет на то, как легко ты сможешь уворачиваться от ударов противников, а также насколько часто ты будешь по ним попадать.<br>'+
		'<b>Удача</b> увеличивает шанс критического удара, наносящего вдвое больше урона, а также шанс избежать его со стороны противников.<br>'+
		'<b>Выносливость</b> не менее важна – чем выше жизнеспособность, тем выше у тебя Уровень жизни.<BR><BR>'+
		'<a href="javascript:talk(4)" class=us2><B>• Ясно как день. Что еще ты можешь мне рассказать?</B></a><BR>'+
		'<a href="javascript:talk(0)" class=us2><B>• Пожалуй, я пойду. (Завершить диалог)</B></a>';
	}
	if(phrase==4)
	{
		bernard.innerHTML='<B>Хранитель Войны:</B><BR>- О, да, чуть не забыл. '+
		'Этот мир населен удивительными существами и множеством персонажей которые рады вступить с Вами в диалог. '+
		'Эти персонажи могу рассказать Вам что-то очень важное или дать Вам задание. '+
		'Имена таких персонажей отмечено зеленым цветом в списке онлайн. Чтобы начать диалог с такими персонажами нужно, просто, нажать на их логин.<BR><BR>'+
		'<a href="javascript:talk(0)" class=us2><B>• Пожалуй, я пойду. (Завершить диалог)</B></a>';
	}
}
function dialog()
{
	bernard.innerHTML='<B>Хранитель Войны:</B><BR>'+
	'Хм... Еще один "избранный", что ли? Ну что же... я приветствую Вас... *читает с листа бумаги* Я рад приветствовать Вас в этом мире, Великий воин!'+
	' я ждал так долго, чтобы передать Вам древнее знание светлнт... свенл... ошибся... '+
	'Эх, проклятие, Вы даже не знаете скольких людей я встречаю каждый день... '+
	'И все же, все думают, "Я и есть этот избранный", рвутся спасать мир, даже не представляя кто они есть на самом деле...<br>'+
	'<BR><a href="javascript:talk(1)" class=us2><B>• Вы правы, я новичок в этом мире и ничего не знаю о себе.</B></a>'+
	'<BR><a href="javascript:talk(2)" class=us2><B>• Но я знаю достаточно о себе, а сплетни пропускаю мимо ушей.</B></a>'+
	'<BR><a href="javascript:talk(0)" class=us2><B>• Надеюсь, когда я вернусь, вы уже успокоитесь. (Завершить диалог)</B></a>';
}

</script>

<SCRIPT language="JavaScript" type="text/javascript" src="fight.js"></SCRIPT>
<h3>Диалог с "Хранитель Войны"</h3>
<table width=100% border=0>
<tr>
	<td width=210 valign=top>
		<?
			showHPbattle($db);
			showPlayer($db);
		?>
	</td>
	<td valign=top><br>
		<table border=0 width=100% cellpadding=1 cellspacing=1 align=left><tr><td>
			<div id='bernard'></div>
			<script>dialog();</script>
		</td></tr></table>
	</td>
	<td width=210 valign=top>
		<?
		$result=mysql_query("SELECT * FROM users WHERE login='Хранитель Войны' limit 1");
		$bot=mysql_fetch_Array($result);
		mysql_free_result($result);
		showHPbattle($bot);
		showPlayer($bot);
		?>
	</td>
</tr>
</table>