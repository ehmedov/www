<?
include_once('key.php');

if ($db["adminsite"]<5)
{
	echo "Вам сюда нельзя!";
}	 
else
{
	echo "
	<a href='main.php' class=us2 title='Вернуться'><li>Вернуться</li></a><BR>
	<a href='?act=inkviz&spell=ipblok' class=us2 title='Блокирование ip адресов'><li>Блокирование ip</li></a><BR>
	<a href='?act=inkviz&spell=10' class=us2 title='Управление заявками на создание клана'><li>Управление заявками на создание клана</li></a><BR>
	<a href='?act=inkviz&spell=color' class=us2 title='Исправление бага'><li>Исправление бага чата</li></a><br><br>
		
	<a href='?act=inkviz&spell=add' class=us2 title='Добавление вещей в Магазин'><li>Добавление вещей в магазин</li></a><br>
	<a href='?act=inkviz&spell=add_elik' class=us2 title='Добавление Магические Свитки'><li>Добавление Магические Еликсири</li></a><br>
	<a href='?act=inkviz&spell=add_flowers' class=us2 title='Добавление Открытки'><li>Добавление Открытки</li></a><br>
	<a href='?act=inkviz&spell=add_gift' class=us2 title='Добавление Подарков'><li>Добавление Подарков</li></a><br>
	<a href='?act=inkviz&spell=add_medal' class=us2 title='Добавление Наград'><li>Добавление Наград</li></a><br>
	<a href='?act=inkviz&spell=add_obraz' class=us2 title='Добавление Образ'><li>Добавление Образ</li></a><br>
	<a href='?act=inkviz&spell=add_priem' class=us2 title='Добавление Приема'><li>Добавление Приема</li></a><br>
	<br>
	<a href='?act=inkviz&spell=chek' class=us2 title='Чек на Арт'><li>Чек на Арт</li></a><br>
	<a href='?act=inkviz&spell=chekk' class=us2 title='Чек на Арт всем'><li>Чек на Арт всем</li></a><br>
	<a href='?act=inkviz&spell=kupon' class=us2 title='Купон'><li>Купон</li></a><br>
        <a href='?act=inkviz&spell=pabed' class=us2 title='Pabed'><li>Qelebe/Meglubiyyet</li></a><br>
	<a href='?act=inkviz&spell=obraz' class=us2 title='Поставить образ'><li>Поставить образ</li></a><br>
	<a href='/main.php?act=inkviz&spell=admin' class=us2 title='ADMINSITE'><li>ADMINSITE</li></a><br>
	<a href='/main.php?act=inkviz&spell=sklon' class=us2 title='Склонности'><li>Склонности</li></a><br>
	<a href='?act=inkviz&spell=stats' class=us2 title='Статы'><li>Статы</li></a><br>
	<a href='?act=inkviz&spell=bots' class=us2 title='Статы'><li>Статы Ботов</li></a><br>
	<a href='?act=inkviz&spell=mf' class=us2 title='Статы.'><li>Боевые навыки</li></a><br>
	<a href='?act=inkviz&spell=bron' class=us2 title='Уровень брони.'><li>Уровень брони</li></a><br>
	<a href='?act=inkviz&spell=birth' class=us2 title='Дата рождения'><li>Дата рождения</li></a><br>
	<a href='?act=inkviz&spell=level_up' class=us2 title='Поднят левел'><li>Поднят левел</li></a><br><br>
	<a href='?act=inkviz&spell=bot_create' class=us2 title='Создание Ботов'><li>Создание Ботов</li></a><br>
		<a href='?act=inkviz&spell=teleport' class=us2 title='Change Room'><li>Телепорт Ник</li></a><br><br>
		<a href='?act=inkviz&spell=money' class=us2 title='Money'><li>Денги</li></a><br><br>
	<a href='?act=inkviz&spell=bot_edit' class=us2 title='Редактирование Ботов'><li>Редактирование Ботов</li></a><br>";
	
	echo "<DIV id='Layer1' style='Z-INDEX: 1; LEFT: 350px; POSITION: absolute; TOP: 10px; '>";
	$spell=htmlspecialchars(addslashes($_GET['spell']));
	if(!empty($spell))
	{
		switch ($spell)
		{
			case "10":include "magic/1/10.php";break;
			case "obraz":include "magic/1/obraz.php";break;
			case "ipblok":include "magic/1/ipblok.php";break;
			case "admin":include "magic/1/admin.php";break;
                        case "pabed":include "magic/1/pabed.php";break;
			case "sklon":include "magic/1/sklon.php";break;
			case "add":include "magic/1/add.php";break;
			case "add_obraz":include "magic/1/add_obraz.php";break;
			case "add_elik":include "magic/1/add_elik.php";break;
			case "add_flowers":include "magic/1/add_flowers.php";break;
			case "add_gift":include "magic/1/add_gift.php";break;
			case "stats":include "magic/1/stats.php";break;
			case "bots":include "magic/1/bots.php";break;
			case "color":include "magic/1/color.php";break;
			case "mf":include "magic/1/mf.php";break;
			case "bron":include "magic/1/bron.php";break;
			case "birth":include "magic/1/birth.php";break;
			case "add_medal":include "magic/1/add_medal.php";break;
			case "bot_create":include "magic/1/bot_create.php";break;
			case "bot_edit":include "magic/1/bot_edit.php";break;
			case "add_priem":include "magic/1/add_priem.php";break;
			case "level_up":include "magic/1/level_up.php";break;
			case "kupon":include "magic/1/kupon.php";break;
			case "chek":include "magic/1/chek.php";break;
			case "money":include "magic/1/money.php";break;
			case "teleport":include "magic/1/teleport.php";break;
			case "chekk":include "magic/1/chekk.php";break;
		}
	}
	echo "</div>"; 
}
?>