<?
include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));

$hpall=$_POST['hpall'];
$level=$_POST['level'];
$sila=$_POST['sila'];
$lovkost=$_POST['lovkost'];
$udacha=$_POST['udacha'];
$power=$_POST['power'];

$krit=$_POST['krit'];
$akrit=$_POST['akrit'];
$uvorot=$_POST['uvorot'];
$auvorot=$_POST['auvorot'];

$protect_udar=$_POST['protect_udar'];
$protect_mag=$_POST['protect_mag'];

$parry=$_POST['parry'];
$counter=$_POST['counter'];
$proboy=$_POST['proboy'];

$ms_udar=$_POST['ms_udar'];
$ms_krit=$_POST['ms_krit'];

$hand_r_hitmin=$_POST["hand_r_hitmin"];
$hand_l_hitmin=$_POST["hand_l_hitmin"];
$hand_r_hitmax=$_POST["hand_r_hitmax"];
$hand_l_hitmax=$_POST["hand_l_hitmax"];

$bron_head=$_POST["bron_head"];
$bron_corp=$_POST["bron_corp"];
$bron_poyas=$_POST["bron_poyas"];
$bron_legs=$_POST["bron_legs"];

if(empty($target))
{
	?>
	<div align=right>
	<table border=0 class=inv width=500 height=120>
	<tr><td align=left valign=top>
	<form name='action' action='main.php?act=inkviz&spell=bots' method='post'>
	Укажите логин Бота: <input type=text name='target' class=new size=25><BR>
	Уровен: <input type=text name=level class=new size=25><BR>
	<hr>
	Сила: <input type=text name=sila class=new size=25><BR>
	Ловкость: <input type=text name=lovkost class=new size=25><BR>
	Удача: <input type=text name=udacha class=new size=25><BR>
	Выносливость: <input type=text name=power class=new size=25><BR>
	<hr>
	Мф крита: <input type=text name=krit class=new size=25><BR>
	Мф антикрита: <input type=text name=akrit class=new size=25><BR>
	Мф уворота: <input type=text name=uvorot class=new size=25><BR>
	Мф антиуворота: <input type=text name=auvorot class=new size=25><BR>
	<hr>
	Защита от урона: <input type=text name=protect_udar class=new size=25><br>
	Защита от магии: <input type=text name=protect_mag class=new size=25><br>
	<hr>
	Мф. парирования: <input type=text name=parry class=new size=25><br>
	Мф. контрудара: <input type=text name=counter class=new size=25><br>
	Мф. пробоя брони: <input type=text name=proboy class=new size=25><br>
	<hr>
	Мф. мощности урона: <input type=text name=ms_udar class=new size=25><br>
	Мф. мощности критического удара: <input type=text name=ms_krit class=new size=25><br>
	<hr>	
	hand_r_hitmin: <input type=text name=hand_r_hitmin class=new size=30><BR>
	hand_l_hitmin: <input type=text name=hand_l_hitmin class=new size=30><BR>
	hand_r_hitmax: <input type=text name=hand_r_hitmax class=new size=30><BR>
	hand_l_hitmax: <input type=text name=hand_l_hitmax class=new size=30><BR>
	<hr>
	Броня Головы: <input type=text name=bron_head class=new size=30><BR>
	Броня Корпуса: <input type=text name=bron_corp class=new size=30><BR>
	Броня Пояса: <input type=text name=bron_poyas class=new size=30><BR>
	Броня Ноги: <input type=text name=bron_legs class=new size=30><BR>
	<input type=submit style="height=17" value=" Обновить статы " class=new><BR>
	</form>
	</td></tr>
	</table>
	<?
}
else 
{
	$q=mysql_query("SELECT * FROM users WHERE login='".$target."'");
	$res=mysql_fetch_array($q);
	if(!$res)
	{
		echo "Персонаж <B>".$target."</B> не найден в базе данных.";
	}
	else
	{	
		$sql = "UPDATE users SET hp_all='".($power*6)."',sila='$sila',lovkost='$lovkost',udacha='$udacha',power='$power',level='$level',
				krit='$krit',akrit='$akrit',uvorot='$uvorot',auvorot='$auvorot',
				hand_l_hitmin='$hand_l_hitmin',hand_l_hitmax='$hand_l_hitmax',hand_r_hitmin='$hand_r_hitmin',hand_r_hitmax='$hand_r_hitmax',
				bron_head='$bron_head',bron_corp='$bron_corp',bron_legs='$bron_legs',bron_poyas='$bron_poyas',
				protect_udar='$protect_udar',protect_mag='$protect_mag',
				parry='$parry',counter='$counter',proboy='$proboy',
				ms_udar='$ms_udar',ms_krit='$ms_krit'
		 		WHERE login='".$res["login"]."'";
		mysql_query($sql);
		echo "Бот <B>".$res["login"]."</B> обнулён.";
	}
}
?>
