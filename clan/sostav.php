<?
echo "<h3>Соклановцы</h3>";
echo "<table width=100%>";
$SostQuery = mysql_query("SELECT login, id, level, dealer, orden, admin_level, clan_short, clan, chin, glava, clan_take, (select count(*) FROM online where login=users.login) as online  FROM users WHERE clan='".$clan_t."' and blok=0 ORDER BY glava DESC, clan_take DESC, exp DESC");
while($DAT = mysql_fetch_array($SostQuery))
{
	if (!$DAT['online']) $online="<img src='img/index/offline.gif'>";else $online="<img src='img/index/online.gif'>";
	if ($DAT["glava"]) $gimg="<img src='img/index/glava.gif' alt='Хан'>"; 
	else if ($DAT['clan_take']) $gimg="<img src='img/index/zamglava.gif' alt='Визир'>"; 
	else $gimg="";
	echo "<tr><td nowrap>".$online."<a href='javascript:top.AddToPrivate(\"".$DAT['login']."\")'><img border=0 src=img/arrow3.gif alt=\"Приватное сообщение\" ></a> 
	<script>drwfl('".$DAT['login']."', '".$DAT['id']."', '".$DAT['level']."', '".$DAT['dealer']."', '".$DAT['orden']."', '".$DAT['admin_level']."', '".$DAT['clan_short']."', '".$DAT['clan']."');</script> $gimg</td><td width=100%>".$DAT['chin']."</td></tr>";
}
echo "</table>";
?>