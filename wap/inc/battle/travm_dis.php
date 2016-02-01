<?
	//-----------------легкую повреждению-------------------------
	$ushib_d_h = array();
	$ushib_d_h[0] = "легкий ушиб уха";
	$ushib_d_h[1] = "ушиб носа";
	$ushib_d_h[2] = "рассеченая бровь";
	$ushib_d_h[3] = "разбитая губа";

	$ushib_d_c = array();
	$ushib_d_c[0] = "поцарапанная грудь";
	$ushib_d_c[1] = "вывих плеча";
	$ushib_d_c[2] = "вывих ключицы";
	$ushib_d_c[3] = "ушиб локтя";

	$ushib_d_p = array();
	$ushib_d_p[0] = "вывих бедра";
	$ushib_d_p[1] = "оцарапнный зад";
	$ushib_d_p[2] = "множественные царапины на ягодицах";
	$ushib_d_p[3] = "растяжение <ВЦ> ";

	$ushib_d_l = array();
	$ushib_d_l[0] = "растяжение сухожилий";
	$ushib_d_l[1] = "оцарапаная нога";
	$ushib_d_l[2] = "множественные царапины на пятке";
	$ushib_d_l[3] = "вывих голени";

	switch ($hit) 
	{
		 case 1:$ushib_d = $ushib_d_h[rand(0,count($ushib_d_h)-1)];break;
		 case 2:$ushib_d = $ushib_d_c[rand(0,count($ushib_d_c)-1)];break;
	 	 case 3:$ushib_d = $ushib_d_p[rand(0,count($ushib_d_p)-1)];break;
	 	 case 4:$ushib_d = $ushib_d_l[rand(0,count($ushib_d_l)-1)];break;
	 	 case 5:$ushib_d = $ushib_d_l[rand(0,count($ushib_d_l)-1)];break;
	}

	//-----------------повреждении средней тяжести-------------------------
	$perelom_d_h = array();
	$perelom_d_h[0] = "перелом носа";
	$perelom_d_h[1] = "разбитый нос";
	$perelom_d_h[2] = "рассеченая бровь";
	$perelom_d_h[3] = "выбитый зуб";

	$perelom_d_с = array();
	$perelom_d_с[0] = "перелом левой руки";
	$perelom_d_с[1] = "сломаное ребро";
	$perelom_d_с[2] = "отбитые почки";
	$perelom_d_с[3] = "перелом левой руки";
	$perelom_d_с[4] = "перелом ключицы";

	$perelom_d_p = array();
	$perelom_d_p[0] = "перелом половых органов";
	$perelom_d_p[1] = "треснутое бедро";
	$perelom_d_p[2] = "трещина в тазовом суставе";
	$perelom_d_p[3] = "сдвиг копчика";

	$perelom_d_l = array();
	$perelom_d_l[0] = "перелом правой ноги";
	$perelom_d_l[1] = "разрыв сухожилий";
	$perelom_d_l[2] = "трещина коленной чашечки";
	$perelom_d_l[3] = "перелом левой ноги";
	$perelom_d_l[4] = "перелом голени";

	switch ($hit) 
	{
		 case 1:$perelom_d = $perelom_d_h[rand(0,count($perelom_d_h)-1)];break;
		 case 2:$perelom_d = $perelom_d_с[rand(0,count($perelom_d_c)-1)];break;
	 	 case 3:$perelom_d = $perelom_d_p[rand(0,count($perelom_d_p)-1)];break;
	 	 case 4:$perelom_d = $perelom_d_l[rand(0,count($perelom_d_l)-1)];break;
	 	 case 5:$perelom_d = $perelom_d_l[rand(0,count($perelom_d_l)-1)];break;
	}
	//-----------------тяжелое повреждение-------------------------
	$heavy_d_h = array();
	$heavy_d_h[0] = "сотрясение мозга";		
	$heavy_d_h[1] = "раздробленный нос";
	$heavy_d_h[2] = "проломленный череп";
	$heavy_d_h[3] = "открытый перелом челюсти";
	$heavy_d_h[4] = "выбитый глаз";
	$heavy_d_h[5] = "внутренне кровотечение в мозг";
	$heavy_d_h[6] = "моральное унижение";

	$heavy_d_c = array();
	$heavy_d_c[0] = "перелом грудной клетки";
	$heavy_d_c[1] = "открытй перелом руки";
	$heavy_d_c[2] = "разрыв селезенки";
	$heavy_d_c[3] = "разрыв грудных мышц";
	$heavy_d_c[4] = "множественные переломы ребер";
	$heavy_d_c[5] = "моральное унижение";
	
	$heavy_d_p = array();
	$heavy_d_p[0] = "раздробленный тазовый сустав";
	$heavy_d_p[1] = "оторванные гениталии";
	$heavy_d_p[2] = "открытый перелом копчика";
	$heavy_d_p[3] = "раздробленный тазовый сустав";
	$heavy_d_p[4] = "моральное унижение";

	$heavy_d_l = array();
	$heavy_d_l[0] = "открытый перелом левой ноги";
	$heavy_d_l[1] = "множественные открытые переломы ноги";
	$heavy_d_l[2] = "трещена в берцовой кости";
	$heavy_d_l[3] = "открытый перелом стопы";
	$heavy_d_l[4] = "раздробленная коленная чашечка";
	$heavy_d_l[5] = "моральное унижение";

	switch ($hit) 
	{
		 case 1:$heavy_d = $heavy_d_h[rand(0,count($heavy_d_h)-1)];break;
		 case 2:$heavy_d = $heavy_d_c[rand(0,count($heavy_d_c)-1)];break;
	 	 case 3:$heavy_d = $heavy_d_p[rand(0,count($heavy_d_p)-1)];break;
	 	 case 4:$heavy_d = $heavy_d_l[rand(0,count($heavy_d_l)-1)];break;
	 	 case 5:$heavy_d = $heavy_d_l[rand(0,count($heavy_d_l)-1)];break;
	}
	switch ($travm) 
	{
		 case 1:$travm_text="легкое повреждение";break;
		 case 2:$travm_text="повреждении средней тяжести";break;
	 	 case 3:$travm_text="тяжелое повреждение";break;
	}

?>
