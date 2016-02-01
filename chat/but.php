<?
Header('Content-Type: text/html; charset=windows-1251');
Header("Cache-Control: no-cache, must-revalidate"); // говорим браузеру что-бы он не кешировал эту страницу
Header("Pragma: no-cache");
?>
<HTML>
<HEAD>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<meta http-equiv="Content-Language" content="ru">
	<META Http-Equiv=Cache-Control Content="no-cache, max-age=0, must-revalidate, no-store">
	<meta http-equiv=PRAGMA content=NO-CACHE>
	<meta http-equiv=Expires content=0>	
</HEAD>

<style type="text/css">
	body { background:#faeede; font-size:9pt; font-weight:normal; font-family:Verdana; margin-top: 0px; margin-right: 0px; margin-bottom: 0px; margin-left: 0px;}
	dl.tabs { border-bottom:1px solid #aaa; margin:4px 0px 0px 0px; padding:0px 0px 0px 2px; }
	dl.tabs dt { border:1px solid #f0f0f0; color:#aaa; cursor:pointer; display:inline; margin:0px 0px 0px 3px; padding:0px 5px 0px 5px; }
	dl.tabs dt.active { border-top:2px solid #aaa; border-right:1px solid #aaa; border-bottom:1px solid #f0f0f0; border-left:1px solid #aaa; color:#000; }
	dl.tabs dt.inactive { border:1px solid #aaa; color:#aaa; }
	dl.tabs dt.light { border:1px solid #aaa; color:#ff0000;}
</style>
<script>
function change(type)
{
	if (type==1)
	{
		top.chat_turn=1;
		document.getElementById('all').className = 'active';
		document.getElementById('system').className = 'inactive';
		top.frames.ch.frames["chat"].document.all['mes'].style.display = 'block';
		top.frames.ch.frames["chat"].document.all['mes1'].style.display = 'none';		
	}
	else if (type==2)
	{
		top.chat_turn=2;
		document.getElementById('system').className = 'active';
		document.getElementById('all').className = 'inactive';
		top.frames.ch.frames["chat"].document.all['mes'].style.display = 'none';	
		top.frames.ch.frames["chat"].document.all['mes1'].style.display = 'block';
	}
	top.scrl(0);
	top.talk.F1.text.focus();

}
</script>
<body topmargin=0 marginheight=0 leftmargin=0 rightmargin=0>
<dl id="tabs" class="tabs">
	<dt class="active" onclick="change(1);" id = "all">Общий Чат</dt>
	<dt class="inactive" onclick="change(2);" id = "system">Системные сообщения</dt>
</dl>
</BODY>