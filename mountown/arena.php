<table width=100% border="0" cellpadding="0" cellspacing="0">
<tr>
	<td valign=top align=center nowrap>
		<?require_once("player.php");?>
	</td>
	<td align="right" valign="top" width=100%>
		<DIV style="position:relative;width:350px;height:288px;" >
			<img src="img/city/room.jpg" border="0">
		    <div style="position: absolute; left:130px;top:50px; 	z-index: 1;" ><img src="img/city/m.gif" border="0"/></div>
		    <div style="position: absolute; left:40px;top:225px; 	z-index: 1;" align=center class="nav" onclick="document.location.href='main.php?act=go&level=room1'" 	onmouseout="stopfilter(this)" onmouseover="startfilter(this)" title="Зал Рождения">Зал Рождения<br><small>(<?=roomcount("room1");?> чел.)</small></div>
		    <div style="position: absolute; left:40px;top:50px; 	z-index: 1;" align=center class="nav" onclick="document.location.href='main.php?act=go&level=room4'" 	onmouseout="stopfilter(this)" onmouseover="startfilter(this)" title="Прошедшие подготовительные тренировки и испытания могут смело зайти в этот зал и чувствовать себя уверенно среди равных. (уровни 1 и выше)">Зал Воинов<br><small>(<?=roomcount("room4");?> чел.)</small></div>
   		    <div style="position: absolute; left:32px;top:140px; 	z-index: 1;" align=center class="nav" onclick="document.location.href='main.php?act=go&level=room6'" 	onmouseout="stopfilter(this)" onmouseover="startfilter(this)" title="Будуар">Будуар<br><small>(<?=roomcount("room6");?> чел.)</small></div>
		    <div style="position: absolute; left:223px;top:45px; 	z-index: 1;" align=center class="nav" onclick="document.location.href='main.php?act=go&level=room3'" 	onmouseout="stopfilter(this)" onmouseover="startfilter(this)" title="Опытные командиры и великолепные воины, покрытые шрамами тысяч сражений - им отведен отдельный Зал. (уровни 7 и выше)">Зал<br>Гладиаторов<br><small>(<?=roomcount("room3");?> чел.)</small></div>
	    	<div style="position: absolute; left:215px;top:225px; 	z-index: 1;" align=center class="nav" onclick="document.location.href='main.php?act=go&level=room2'" 	onmouseout="stopfilter(this)" onmouseover="startfilter(this)" title="Зал Закона">Зал Закона<br><small>(<?=roomcount("room2");?> чел.)</small></div>
			<div style="position: absolute; left:152px;top:35px; 	z-index: 1;" align=center class="nav" onclick="document.location.href='main.php?act=go&level=municip'" 	onmouseout="stopfilter(this)" onmouseover="startfilter(this)" title="Выход в ГОРОД">Выход</div>
			<div style="position: absolute; left:152px;top:135px; 	z-index: 1;" align=center class="nav" onclick="document.location.href='main.php?act=go&level=arena'" 	onmouseout="stopfilter(this)" onmouseover="startfilter(this)" title="Арена">Арена<br><small>(<?=roomcount("arena");?> чел.)</small></div>
			<div style="position: absolute; left:267px;top:140px; 	z-index: 1;" align=center class="nav" onclick="document.location.href='main.php?act=go&level=room5'" 	onmouseout="stopfilter(this)" onmouseover="startfilter(this)" title="Те, кто повидал много кровавых сеч и сражений, могут уединиться от шумной толпы новичков и воинов. (уровни 9 и выше)">Зал<br>Славы<br><small>(<?=roomcount("room5");?> чел.)</small></div>
		<small>В Арене Битв существуют разные локации для проведения боев по уровню персонажей.
		Более опытные бойцы старших уровней занимают другие комнаты. 
		В каждом комнате проводятся несколько видов боев на любой вкус. 
		Для того, что бы принят участие в состязаниях, выберете комнату Вашего уровня</small>
		<hr>
		<input type="button" onclick="window.open('top.php');" value="Рейтинг">
		<input type="button" onclick="window.open('extable.php');" value="Таблица опыта">
		<input type="button" onclick="window.open('rules.php');" value="Законы">
	</td>
</tr>
</table>
<br><br><?include_once("counter.php");?>