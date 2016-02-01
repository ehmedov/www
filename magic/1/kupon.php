<?include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
$kupon_count=(int)$_POST['kupon_count'];

if($_POST['target'] && $kupon_count>0)
{
	$res=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE login='".$target."'"));
	if ($res)
	{	
		switch ($_POST["kupon_type"])
		{
			case 0: $max_win=5000; $object_id=428; $kupon_type=0; $str_his="100AZN"; break;
			case 1: $max_win=1000; $object_id=427; $kupon_type=1; $str_his="10AZN"; break;
		}	
		$str="Выигрышный Купон: Вы являетесь Участником Новогоднего Джекпота. Максимальный Выигрыш ".$max_win." Пл. У Вас ".$kupon_count." купона...";
		for($i=1;$i<=$kupon_count;$i++)
		{
			mysql_query("INSERT INTO inv (owner, object_id, object_type, object_razdel, msg, gift, gift_author, term) VALUES ('".$res['login']."', '".$object_id."', 'flower', 'other', 'Вы являетесь Участником Джекпота', 1, 'WWW.Oldmeydan.Pe.Hu', '".(time()+3600*24*30)."')");
			mysql_Query("INSERT INTO bank_member (user_id, type) VALUES ('".$res["id"]."', '".$kupon_type."');");
		}
		history($res["login"],'Купон -$str_his',$str,$res["remote_ip"],'Купон-$str_his');
		mysql_query("INSERT INTO pochta(user, whom, text, subject) VALUES ('Путешественник','".$res["login"]."','".$str."','Выигрышный Купон')");
		say($res["login"], $str, $res["login"]);
		say("toall_news","Воин <b>".$res["login"]."</b> получил $kupon_count выигрышных купонов!",$res["login"]);
		echo "ok";
	}
	else echo "User Not Found";
}
else
{
	?>
	<br>
	<br>
	<form name='action' action='main.php?act=inkviz&spell=kupon' method='post'>
		<table border=0 width=500>
			<tr><td>Логин:</td><td><input type=text name="target" class=new size=30></td></tr>
			<tr><td>Количество купонов:</td><td><input type=text name="kupon_count" class=new size=30></td></tr>
			<tr><td>Тип лотереи:</td><td>
			<select name='kupon_type'>
				<option value="0">100AZN</option>
				<option value="1">10AZN</option>
			</select>
			</td></tr>
			<tr><td colspan=2><input type=submit value="Создать" class=new></td></tr>
		</table>
	</form>
	<?
}
?>