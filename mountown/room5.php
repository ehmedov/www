<table width=100% border="0" cellpadding="0" cellspacing="0">
<tr>
	<td valign=top align=center nowrap>
		<?require_once("player.php");?>
	</td>
	<td align="right" valign="top" width=100% nowrap>
		<DIV style="position:relative; width:350px; height:288px;" >
			<img src="img/city/room.jpg" border="0">
		    <div style="position: absolute; left:230px;top:70px; 	z-index: 1;" ><img src="img/city/m.gif" border="0"/></div>
		    <div style="position: absolute; left:40px;top:225px; 	z-index: 1;" align=center class="nav" onclick="document.location.href='main.php?act=go&level=room1'" 	onmouseout="stopfilter(this)" onmouseover="startfilter(this)" title="Зал Рождения">Зал Рождения</div>
		    <div style="position: absolute; left:40px;top:50px; 	z-index: 1;" align=center class="nav" onclick="document.location.href='main.php?act=go&level=room4'" 	onmouseout="stopfilter(this)" onmouseover="startfilter(this)" title="Прошедшие подготовительные тренировки и испытания могут смело зайти в этот зал и чувствовать себя уверенно среди равных. (уровни 1 и выше)">Зал Воинов</div>
   		    <div style="position: absolute; left:32px;top:140px; 	z-index: 1;" align=center class="nav" onclick="document.location.href='main.php?act=go&level=room6'" 	onmouseout="stopfilter(this)" onmouseover="startfilter(this)" title="Будуар">Будуар</div>
		    <div style="position: absolute; left:223px;top:45px; 	z-index: 1;" align=center class="nav" onclick="document.location.href='main.php?act=go&level=room3'" 	onmouseout="stopfilter(this)" onmouseover="startfilter(this)" title="Опытные командиры и великолепные воины, покрытые шрамами тысяч сражений - им отведен отдельный Зал. (уровни 7 и выше)">Зал<br>Гладиаторов</div>
	    	<div style="position: absolute; left:215px;top:225px; 	z-index: 1;" align=center class="nav" onclick="document.location.href='main.php?act=go&level=room2'" 	onmouseout="stopfilter(this)" onmouseover="startfilter(this)" title="Зал Закона">Зал Закона</div>
			<div style="position: absolute; left:152px;top:35px; 	z-index: 1;" align=center class="nav" onclick="document.location.href='main.php?act=go&level=municip'" 	onmouseout="stopfilter(this)" onmouseover="startfilter(this)" title="Выход в ГОРОД">Выход</div>
			<div style="position: absolute; left:152px;top:135px; 	z-index: 1;" align=center class="nav" onclick="document.location.href='main.php?act=go&level=arena'" 	onmouseout="stopfilter(this)" onmouseover="startfilter(this)" title="Арена">Арена</div>
			<div style="position: absolute; left:267px;top:140px; 	z-index: 1;" align=center class="nav" onclick="document.location.href='main.php?act=go&level=room5'" 	onmouseout="stopfilter(this)" onmouseover="startfilter(this)" title="Те, кто повидал много кровавых сеч и сражений, могут уединиться от шумной толпы новичков и воинов. (уровни 9 и выше)">Зал<br>Славы</div>
		</div>
		<small>Те, кто повидал много кровавых сеч и сражений, <br>могут уединиться от шумной толпы новичков и воинов. <br>(уровни 20 и выше)</small>
		<hr>
		<input type="button" onclick="window.location='zayavka.php'" value="Поединки">
		<input type="button" onclick="window.open('top.php');" value="Рейтинг">
		<input type="button" onclick="window.open('extable.php');" value="Таблица опыта">
		<input type="button" onclick="window.open('rules.php');" value="Законы">
	</td>
</tr>
</table>
<br><br><?include_once("counter.php");?>