<table width=100% border="0" cellpadding="0" cellspacing="0" align=center>
<tr><td>
<?include_once("player.php");?></td>
<td align="right">
<right><center><img src="newimages/test.png" height="250" width="500"><br><a href="?act=go&level=municip">Вход в Центральная площадь</a></center></td></tr></table>
<?
if ($db["level"]<8)
			{	
			mysql_query("UNLOCK TABLES");
				mysql_query("UPDATE users SET exp=exp+350000 WHERE login='".$login."'");
				$db["exp"]=$db["exp"]+350000;

				mysql_query("UPDATE users SET platina=platina+20000 WHERE login='".$login."'");
				$db["platina"]=$db["platina"]+20000;
				echo ("<script>alert('Вы Получили 20 000 Пл. и Достигли 8 Уровня !');</script>");
			} 
?>