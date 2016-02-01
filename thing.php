<?
include_once("conf.php");
include_once("item_des.php");
$data = mysql_connect($base_name, $base_user, $base_pass) or die('Не получается подключиться. Проверьте имя сервера, имя пользователя и пароль!');
mysql_select_db($db_name) or die('Ошибка входа в базу данных');

Header("Cache-Control: no-cache, must-revalidate"); // говорим браузеру что-бы он не кешировал эту страницу
Header("Pragma: no-cache");
function c_items($db_items,$otdel)
{
	$res=mysql_fetch_array(mysql_query("SELECT count(id) FROM $db_items WHERE object='{$otdel}'"));
	return (int)$res[0];
}
?>
<html>
<HEAD>	
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<meta http-equiv="Content-Language" content="ru">
	<META Http-Equiv=Cache-Control Content="no-cache, max-age=0, must-revalidate, no-store">
	<meta http-equiv=PRAGMA content=NO-CACHE>
	<meta http-equiv=Expires content=0>	
	<LINK REL=StyleSheet HREF='main.css' TYPE='text/css'>
</HEAD>
<body bgcolor="#faeede">
<?
if ($_GET["item_id"])
{
	$item_id=(int)abs($_GET["item_id"]);
	$seek=mysql_query("SELECT * FROM paltar WHERE id=$item_id");
	if ($dat=mysql_fetch_array($seek))
	{	
		echo "<TABLE cellspacing=1 cellpadding=5 class='l3' align=center width=600>
		<tr  class='l0' >
			<td width=150 valign=center align=center><img src='img/items/".$dat["img"]."'></td>
			<td valign='top'>";show_item($db,$dat);echo "</td>
		</tr>";
	}
	else echo "Предмет не найден";
	echo "</table>";
	echo "</td></tr></table>";
}
else
{
	if (!$_GET["otdel"])$otdel="sword";
	else $otdel=htmlspecialchars(addslashes($_GET["otdel"]));
	
	if ($_GET["sort"]==1)$str=" and art=1 ";
	else if ($_GET["sort"]==2)$str=" and art=2 ";
	echo "Фильтр: <a href='?type=edit&otdel=$otdel'>Все</a> |  <img src='img/artefakt.gif'> <a href='?type=edit&otdel=$otdel&sort=1'>Магазин Артов</a> |  <img src='img/icon/artefakt.gif'> <a href='?type=edit&otdel=$otdel&sort=2'>Артефактный магазин</a>";

	echo '<table width=100%><tr><td nowrap width=100% valign=top>';
	echo '<TABLE width=100% cellspacing=1 cellpadding=3 class="l3" >';
	$query=mysql_query("SELECT * FROM paltar WHERE object='{$otdel}' and podzemka=0 $str ORDER BY min_level ASC, price ASC");
	while ($res=mysql_fetch_array($query))
	{
		$n=(!$n);
		echo '<tr class="'.($n?"l0":"l1").'"><td valign=center align=center width=150 nowrap><img src="img/items/'.$res['img'].'"></td><td>';
		show_item($db,$res);
		echo '</td>';
		echo '</tr>';
	}
	echo '</table>
	</td>
	<td nowrap valign=top>
	';
	include("inc/shop/otdels.php");
	echo '</td>';
	echo '</tr></table>';

}
?>