<?
$login=$_SESSION["login"];	
$now=time();
$action=$_GET[action];
$stavka=($db["orden"]==1?0:10);
$del_time=15;
?>
<script LANGUAGE="JavaScript">
function seleciona() 
{
	if (F1.master.checked==true)
	for (i=0; i<document.F1.elements.length;i++)
	{
		document.F1.elements[i].checked=true
	}
	if (F1.master.checked==false)
	for (i=0; i<document.F1.elements.length;i++)
	{
		document.F1.elements[i].checked=false
	}
}
</script>
<table width=100% cellspacing=0 cellpadding=0>
<tr valign=top>
	<td width=100%><h3>Почтовое отделение</h3><small></td>
	<td nowrap>
		<input type=button value='Вернуться' onClick="document.location='main.php?act=go&level=remesl'">
		<input type=button value='Обновить'  onClick="document.location='main.php?act=none'">
	</td>
</tr>	
</table>	
<?
echo"";
//-------------------------VIEW-----------------------------------------------------
if ($action=="let") 
{
	$id=(int)$_GET[id];
	$pochas = mysql_query("select  pochta.* , users.level, users.id AS ids, users.orden, users.admin_level, users.clan_short, users.clan, users.dealer, users.login FROM pochta  LEFT JOIN users on users.login=pochta.user WHERE pochta.id='".$id."' and pochta.whom='".$login."'");
	if(mysql_num_rows($pochas))
	{	
		$let = mysql_fetch_array($pochas);
		$text=$let["text"];
		$text=str_replace("\n","<br>",$text);
		$text=str_replace("&amp;","&",$text);
		$subj=$let["subject"];
		$subj=str_replace("&amp;","&",$subj);
		$user=$let["user"];
		$who=$let["whom"];
		$data_=$let["time"];
		$msg="<font color=#000000><b>Дата</b>: $data_
		<br><b>От</b>: <script>drwfl('".$let['login']."','".$let['ids']."','".$let['level']."','".$let['dealer']."','".$let['orden']."','".$let['admin_level']."','".$let['clan_short']."','".$let['clan']."');</script>
		<br><b>Тема</b>: $subj<br><b>Текст</b>:<br>$text</font>
		<br><br><input type=button value='Ответить' onClick=\"document.location='?action=new&log=".$user."'\">";
		mysql_query("UPDATE `pochta` SET `read` = '1' WHERE `id` = '".$id."' ");
	}
	else $msg="Телеграммы с запрошеным статусом не найдены...</font>";
}
//-------------------------VIEW-----------------------------------------------------
if ($action=="let_view") 
{
	$id=(int)$_GET[id];
	$pochas = mysql_query("select * from pochta where id='".$id."' and user='".$login."'");
	if(mysql_num_rows($pochas))
	{	
		$let = mysql_fetch_array($pochas);
		$text=$let["text"];
		$text=str_replace("\n","<br>",$text);
		$text=str_replace("&amp;","&",$text);
		$subj=$let["subject"];
		$subj=str_replace("&amp;","&",$subj);
		$user=$let["user"];
		$who=$let["whom"];
		$data_=$let["time"];
		$msg="<font color=#000000><b>Дата: </b>$data_<br><b>Кому:</b>$who<br><b>Тема:</b> $subj<br><b>Текст:</b><br>$text</font>";
	}
	else $msg="Телеграммы с запрошеным статусом не найдены...</font>";
}
//------------------------SEND------------------------------------------------------
if ($_POST["pochta"]) 
{
	$text = $_POST['letter'];
	$target = $_POST['target'];
	$subj = $_POST['subj'];
	$infs = mysql_fetch_array(mysql_query("SELECT login,adminsite FROM users WHERE login='".$target."'"));
	if (!$infs) $msg="Персонаж <b>«".$target."»</b> не существует, проверьте написание логина персонажа...";
	else if (!$db["adminsite"] && $infs["adminsite"]>=5) $msg="Персонаж <b>«".$target."»</b> не существует, проверьте написание логина персонажа...";
	else if (empty($text) || empty($subj)) $msg="В телеграмме должно присутствовать хотя бы одно слово...";
	else if ($db["money"]<$stavka){$msg="У вас нет такой суммы!";}
	else if (empty($text) || empty($subj)) $msg="В телеграмме должно присутствовать хотя бы одно слово...";
	else if (strlen($subj)>50) $msg="Максимально <b>50</b> символов...";
	else if (strlen($text)>1024) $msg="Максимально <b>1024</b> символов...";
	else if ($db["shut"]>time()) $msg="У Вас Молчанка!";
	else 
	{
		mysql_query("INSERT INTO pochta(user,whom,text,subject) VALUES ('".$login."','".$infs["login"]."','".$text."','".$subj."')");
		mysql_query("UPDATE users SET money=money-$stavka WHERE login = '".$login."'");
		$msg="Вы успешно отправили телеграмму персонажу <b>".$infs["login"]."</b> оплатив <b>".$stavka." Зл.</b>";
		$db["money"]=$db["money"]-$stavka;
	}
	$action="new";
}
//------------------------Удалить------------------------------------------------------
if ($_POST['tags'])
{	
	$checked=$_POST['tags'];
	for ($i=0;$i<count($checked);$i++)
	{
		$del_id=(int)$checked [$i];
		mysql_query("DELETE FROM pochta WHERE id='".$del_id."'");
	}
}
//----------------------------------------------------------------------------------
mysql_query("DELETE FROM pochta WHERE UNIX_TIMESTAMP(time) < ".(time() - $del_time*24*3600));
$unread = mysql_query("SELECT * FROM `pochta` WHERE `whom` LIKE '".$login."' AND `read` = 0 " );
$poch = mysql_query("select * from pochta where whom='".$login."' ORDER BY id DESC");
$send = mysql_query("select * from pochta where user='".$login."' ORDER BY id DESC");

echo "<table cellspacing=0 cellpadding=5 border=0 align=center>
<tr>
<td valign=top width=300 nowrap align=right>
	<a href=?action=new>Написать </a><br>
	<a href=?action=read>Входящие (";if (mysql_num_rows($unread)) echo "<b style=color:#ff0000>";else $_SESSION['mektub']="";echo mysql_num_rows($unread)."</b> / ".mysql_num_rows($poch)." )</a><br>
	<a href=?action=write>Исходящие (".mysql_num_rows($send).")</a><br>
</td>
<td width=600 valign=top align=left>";
	if ($action=="")
	{
		echo "<table width=100% cellspacing=0 cellpadding=0 border=0>
		<tr>
			<td align=center>
				<img src='img/city/post.jpg'><br>
				<small style=color:#FF0000>(Внимание! Письма, находящиеся в СЕРВЕРЕ более <b>$del_time Суток</b>, будут удалены автоматически.)</small>
			</td>
		</tr>
		<tr>
			<td><div  align=justify>Если вы спросите себя, что это за невысокое здание на Западной крыле, 
			в котором никогда не гаснет свет, то ответ не заставит себя ждать - это почта. 
			Круглосуточно тут трудятся сотни почтальонов. Под строгим руководством <b>Создателя</b> они посылают гонцов во все концы мира,
			дабы доставить адресату веселую весть, приглашение на свадьбу или поздравить с праздником.</div>
			</td>
		</tr>
		</table>";
	}	
	echo "<font color=#ff0000>".$msg."</font>&nbsp;";
	//----------------------------Входящие---------------------------------------------------------
	if ($action=="read") 
	{
		echo "<table width=100% cellspacing=0 cellpadding=5 class=l3>
		<FORM name='F1' method='POST' action=''>
		<tr><td width=30><b>№</b></td><td width=100><b>Отправитель</td><td width=100><b>Тема</td><td width=100><b>ДАТА</td><td><b><input type=\"checkbox\" name=\"master\" onClick=\"seleciona()\"></td></tr>";
			while ($pochta = mysql_fetch_array($poch) ) 
			{
				$n=(!$n);
				$i++;
				$user=$pochta["user"];
				$text=$pochta["subject"];
				$text=str_replace("&amp;","&",$text);
				$id=$pochta["id"];
				$data_=$pochta["time"];
				$readable="";
				if (!$pochta['read']) {$readable="<b>";}
				echo "<tr class='".($n?'l0':'l1')."' style='CURSOR: Hand'>
					<td>$readable $i</td>
					<td nowrap onclick='window.location.href=\"?action=let&id=$id\"'>$readable $user</td>
					<td>$readable ".$text."</td>
					<td>$readable $data_</td>
					<td><input type='checkbox' name='tags[]' value='".$id."'></td>
				</tr>";
			}
			if (!$i)echo "<tr><td colspan=5>Папка пуста</td></tr>";
		echo "<tr><td colspan=5 height=20 align=center><input name='delete' type='submit' value=' Удалить ' class=button style='cursor:hand'></td></tr>";
		echo "</FORM></table>";
	}
	//----------------------------Исходяшие---------------------------------------------------------
	if ($action=="write") 
	{
		echo "<table width=100% cellspacing=0 cellpadding=5 class=l3>
			<tr><td width=30><b>№</td><td width=100><b>Кому</td><td width=100><b>Тема</td><td width=100><b>ДАТА</td></tr>";
			while ($pochta = mysql_fetch_array($send) ) 
			{
				$n=(!$n);
				$i++;
				$user=$pochta["user"];
				$whom=$pochta["whom"];
				$text=$pochta["subject"];
				$text=str_replace("&amp;","&",$text);
				$id=$pochta["id"];
				$data_=$pochta["time"];
				$readable="";
				if (!$pochta['read']) {$readable="<b>";}
				echo "<tr class='".($n?'l0':'l1')."' style='CURSOR: Hand'>				
				<td>$readable $i</td>
				<td nowrap onclick='window.location.href=\"?action=let_view&id=$id\"'>$readable $whom</td>
				<td>$readable $text</td>
				<td>$readable $data_</td>
				</tr>";
			}
			if (!$i)echo "<tr><td colspan=5>Папка пуста</td></tr>";
			echo "<tr><td colspan=5 height=20 align=center></td></tr>";
			echo "</table>";
	}
	//----------------------------Написать---------------------------------------------------------
	if ($action=="new") 
	{
		if ($_GET["log"]!="")$login_send=HtmlSpecialChars(addslashes($_GET["log"]));
		?>
			<script>
			var symbols = 1024;
		   	function checkLeight()
		    {
		         var l = symbols - document.getElementById('letter').value.length;
		         if(l < 0)
		         {
		              alert('Извините, но масимальная длина сообщения - ' + symbols + '');
		              return false;
		         }
		         else
		         {
		              document.getElementById('co').innerHTML = l;
		              return true;
		         }
		    }
			</script>

			<table width=100% cellspacing=0 cellpadding=7><tr><td>
			<form name='F2' id='F2' action='' method="POST" onsubmit="return checkLeight();">
				<b>Кому:</b> <input type=text name="target" class=new size=30 value="<?=$login_send;?>"><br>
				<b>Тема:</b> <input type=text name="subj" class=new size=30><br>				
				<b>Текст письма</b><br>
				<textarea name="letter" rows=4 cols=70 onkeypress="checkLeight()"></textarea><BR>
				(осталось <SPAN id='co' name='co'>1024</SPAN> симв.)			
				<input name="pochta" type=submit value="Отправить" class=new>
			</form>
			</td></tr></table>
		<?
	}
	//---------------------------------------------------------------------------------------------
echo"</td>
</tr>
</table>";
?>