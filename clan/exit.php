<?
if($db["glava"]!=1)
{
	mysql_query("UPDATE users SET clan='',clan_short='',chin='',orden='',clan_take='0',glava=0 WHERE login='".$login."'");
	history($login,'Покинул ханства',$clan_t,$db['remote_ip'],"Ханства");
	op($login,"Покинул ханства",$clan_s);
	Header("Location: main.php?act=none&tmp=$random");	
	die();
}
else echo "Вы не можете так покинут ханства...";
?>