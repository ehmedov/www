<table width=100% border="0" cellpadding="0" cellspacing="0">
<tr>
	<td valign=top align=center nowrap>
		<?require_once("player.php");?>
	</td>
	<td align="right" valign="top" width=100% nowrap>
		<DIV style="position:relative; width:350px; height:288px;" >
			<img src="img/city/room.jpg" border="0">
		    <div style="position: absolute; left:230px;top:70px; 	z-index: 1;" ><img src="img/city/m.gif" border="0"/></div>
		    <div style="position: absolute; left:40px;top:225px; 	z-index: 1;" align=center class="nav" onclick="document.location.href='main.php?act=go&level=room1'" 	onmouseout="stopfilter(this)" onmouseover="startfilter(this)" title="��� ��������">��� ��������</div>
		    <div style="position: absolute; left:40px;top:50px; 	z-index: 1;" align=center class="nav" onclick="document.location.href='main.php?act=go&level=room4'" 	onmouseout="stopfilter(this)" onmouseover="startfilter(this)" title="��������� ���������������� ���������� � ��������� ����� ����� ����� � ���� ��� � ����������� ���� �������� ����� ������. (������ 1 � ����)">��� ������</div>
   		    <div style="position: absolute; left:32px;top:140px; 	z-index: 1;" align=center class="nav" onclick="document.location.href='main.php?act=go&level=room6'" 	onmouseout="stopfilter(this)" onmouseover="startfilter(this)" title="������">������</div>
		    <div style="position: absolute; left:223px;top:45px; 	z-index: 1;" align=center class="nav" onclick="document.location.href='main.php?act=go&level=room3'" 	onmouseout="stopfilter(this)" onmouseover="startfilter(this)" title="������� ��������� � ������������ �����, �������� ������� ����� �������� - �� ������� ��������� ���. (������ 7 � ����)">���<br>�����������</div>
	    	<div style="position: absolute; left:215px;top:225px; 	z-index: 1;" align=center class="nav" onclick="document.location.href='main.php?act=go&level=room2'" 	onmouseout="stopfilter(this)" onmouseover="startfilter(this)" title="��� ������">��� ������</div>
			<div style="position: absolute; left:152px;top:35px; 	z-index: 1;" align=center class="nav" onclick="document.location.href='main.php?act=go&level=municip'" 	onmouseout="stopfilter(this)" onmouseover="startfilter(this)" title="����� � �����">�����</div>
			<div style="position: absolute; left:152px;top:135px; 	z-index: 1;" align=center class="nav" onclick="document.location.href='main.php?act=go&level=arena'" 	onmouseout="stopfilter(this)" onmouseover="startfilter(this)" title="�����">�����</div>
			<div style="position: absolute; left:267px;top:140px; 	z-index: 1;" align=center class="nav" onclick="document.location.href='main.php?act=go&level=room5'" 	onmouseout="stopfilter(this)" onmouseover="startfilter(this)" title="��, ��� ������� ����� �������� ��� � ��������, ����� ���������� �� ������ ����� �������� � ������. (������ 9 � ����)">���<br>�����</div>
		</div>
		<small>��, ��� ������� ����� �������� ��� � ��������, <br>����� ���������� �� ������ ����� �������� � ������. <br>(������ 20 � ����)</small>
		<hr>
		<input type="button" onclick="window.location='zayavka.php'" value="��������">
		<input type="button" onclick="window.open('top.php');" value="�������">
		<input type="button" onclick="window.open('extable.php');" value="������� �����">
		<input type="button" onclick="window.open('rules.php');" value="������">
	</td>
</tr>
</table>
<br><br><?include_once("counter.php");?>