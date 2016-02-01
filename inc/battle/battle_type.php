<?
function boy_type($t)
{
	switch ($t)	
	{
		case 1:$txt="Одиночные: с оружием";	break;
		case 2:$txt="Одиночные: кулачный";	break;
		case 100:$txt="Одиночные: кровавый";break;
		case 3:$txt="Групповые: кулачный";	break;
		case 4:$txt="Групповые: с оружием";	break;
		case 101:$txt="Групповые: кровавый";break;
		case 5:$txt="Хаотические: с оружием";	break;
		case 6:$txt="Хаотические: кулачный";	break;
		case 7:$txt="Хаотические: с оружием";	break;
		case 102:$txt="Хаотические: кровавый";break;
		case 18:$txt="Остров Весеннего Листа";break;
		case 19:$txt="Таинственный Маяк";break;
		case 10:$txt="Подземелья Призраков";break;
		case 15:$txt="Катакомбы";break;
		case 80:$txt="Напасть на Злой Демон";break;
		case 82:$txt="Ледяная пещера";break;
		case 88:$txt="Загадочная пещера";break;
		case 89:$txt="Пещера Праздничная";break;
		case 44:$txt="Нападение";break;
		case 55:$txt="Темный Лес";break;
		case 99:$txt="Турнир";break;
		case 66:$txt="Битва с Рыцарь Смерти";break;
		case 13:$txt="Битва за замок";break;
		case 33:$txt="Проклеенный Клад";break;
		case 11:$txt="Свет vs. Тьма";break;
		case 23:$txt="Бой с Исчадием Хаоса";break;
		case 77:$txt="Война Ханств";break;
		case 29:$txt="Свет vs. Тьма";break;
		default:$txt="Не определен";break;
	}
	return $txt;
}
?>