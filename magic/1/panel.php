<?
include('key.php');
echo "<a href='main.php?act=none' class=us2 title='Вернуться'><li>Вернуться</li></a><BR>";
if ($_SESSION["login"]=="DevelopeR")
{
	echo "

	<a href='?act=inkviz&spell=stats' class=us2 title='Статы'><li>Статы</li></a><br>
	<a href='?act=inkviz&spell=money' class=us2 title='Деньги'><li>Деньги</li></a><br>
	<a href='?act=inkviz&spell=add_own_item' class=us2 title='Статы'><li>Передать вещь</li></a><br>
	<a href='?act=inkviz&spell=bots' class=us2 title='Статы'><li>Статы Ботов</li></a><br>
	<a href='?act=inkviz&spell=level_up' class=us2 title='Поднят левел'><li>Поднят левел</li></a><br><br>
";
	echo "<DIV id='Layer1' style='Z-INDEX: 1; LEFT: 350px; POSITION: absolute; TOP: 10px; '>";
	$spell=htmlspecialchars(addslashes($_GET['spell']));
	if(!empty($spell))
	{
		switch ($spell)
		{
	
			case "stats":include "magic/1/stats.php";break;
			case "bots":include "magic/1/bots.php";break;
			case "money":include "magic/1/money.php";break;
			case "add_own_item":include "magic/1/add_own_item.php";break;

			case "level_up":include "magic/1/level_up.php";break;
		}
	}
	echo "</div>"; 
} else {
	echo "Вам сюда нельзя!";
}	 
?>