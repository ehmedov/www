<script src='script.js'></script>
<form method="POST" name='add_top' action='?action=add&fid=<?=$fid;?>'>	
<table width="500" style="width:460px; height:25px; border:1px solid #BBB;" cellpadding="0" cellspacing="5" align="center">
<tr align="left" valign="top">
<td colspan=2 style="background-image:url('design/bg.gif')">
	<img title="Полужирный" style="cursor:hand" src="design/b.gif" width="23" height="25" border="0" onclick="paste(' [B]',' [/B]');">
	<img title="Наклонный текст" style="cursor:hand" src="design/i.gif" width="23" height="25" border="0" onclick="paste(' [I]',' [/I]');">
	<img title="Подчеркнутый текст" style="cursor:hand" src="design/u.gif" width="23" height="25" border="0" onclick="paste(' [U]',' [/U]');">
	<img src="design/brkspace.gif" width="5" height="25" border="0">
	<img title="Выравнивание по левому краю" style="cursor:hand" src="design/left.gif" width="23" height="25" border="0" onclick="paste(' [left]',' [/left]');">
	<img title="По центру" style="cursor:hand" src="design/center.gif" width="23" height="25" border="0" onclick="paste(' [center]',' [/center]');">
	<img title="Выравнивание по правому краю" style="cursor:hand" src="design/right.gif" width="23" height="25" border="0" onclick="paste(' [right]',' [/right]');">
	<img src="design/brkspace.gif" width="5" height="25" border="0">
	<img title="Вставка смайликов" style="cursor:hand" src="design/emo.gif" width="23" height="25" border="0" onclick="ins_smile();">
	<img src="design/brkspace.gif" width="5" height="25" border="0">
	<iframe width="250" height="200" id="cp" src="color.html" frameborder="0" vspace="0" hspace="0" marginwidth="0" marginheight="0" scrolling="no" style="visibility:hidden; position: absolute;"></iframe>
</td>
</tr>
<tr>
	<td>
		Название темы: <input type="text" size="40" maxlength="150" name="title" value="" tabindex="1" style="font-family:verdana; font-size:11px; border:1px solid #E0E0E0;" />
		<textarea name="comments" id="comments" tabindex="2" style="width:450px; height:160px; font-family:verdana; font-size:11px; border:1px solid #E0E0E0;"></textarea>
	</td>
</tr>
<tr>
	<td align=center>
        <input name="save" type="image" tabindex="3" src="design/send.png">
	</td>
</tr>
</table>
</form>