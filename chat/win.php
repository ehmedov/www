<?
header('Content-Type: text/html; charset=windows-1251');
Header("Cache-Control: no-cache, must-revalidate"); // говорим браузеру что-бы он не кешировал эту страницу
Header("Pragma: no-cache");
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<meta http-equiv="Content-Language" content="ru">
	<META Http-Equiv=Cache-Control Content="no-cache, max-age=0, must-revalidate, no-store">
	<meta http-equiv=PRAGMA content=NO-CACHE>
	<meta http-equiv=Expires content=0>	
	<LINK rel="stylesheet" type="text/css" href="chatstyle.css">
</head>
<body style="margin-top: 0px; margin-right: 0px; margin-bottom: 0px; margin-left: 0px;" bgcolor="#faeede" oncontextmenu="top.OpenMenu(event);return false;" onload="top.start()" style="scrollbar-base-color: #eeeeee;scrollbar-face-color: #eeeeee;scrollbar-track-color: #eeeeee; scrollbar-arrow-color: Gray;scrollbar-darkshadow-color: Silver;scrollbar-highlight-color: Silver;scrollbar-shadow-color: Gray;scrollbar-3dlight-color: Gray; ">
<textarea id="holdtext" style="display:none;"></textarea>
<div id="oMenu" name="oMenu" class="menu" onmouseout="top.closeMenu();" style="position: absolute; z-index: 5; display:none;"></div>

<div id="mes" style="display:block;width:100%; height:0; z-index:2; position:absolute;" onclick="top.AddLogin(event)" ></div>
<div id="mes1" style="display:none; width:100%; height:0; z-index:1; position:absolute;" onclick="top.AddLogin(event)"></div>
</body>