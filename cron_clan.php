<?
include "conf.php";
$data = mysql_connect($base_name, $base_user, $base_pass);
mysql_select_db($db_name,$data);


$all_sql=mysql_query("SELECT clan_battle.*, c1.name as c1_name, c2.name as c2_name FROM clan_battle LEFT JOIN clan c1 ON c1.name_short=clan_battle.defender LEFT JOIN clan c2 ON c2.name_short=clan_battle.attacker WHERE time_end<".time());
if (mysql_num_rows($all_sql))
{	
	while($res=mysql_fetch_Array($all_sql))
	{
		if ($res["win"]>$res["lose"])
		{
			$winner=$res["c2_name"];
			$wins=$res["attacker"];
			$txt="Война окончена между Ханством <b>".$res["c2_name"]."</b> и <b>".$res["c1_name"]."</b>. Победила Ханства <b>".$winner."</b>";
		}
		else if ($res["win"]<$res["lose"])
		{
			$winner=$res["c1_name"];
			$wins=$res["defender"];
			$txt="Война окончена между Ханством <b>".$res["c2_name"]."</b> и <b>".$res["c1_name"]."</b>. Победила Ханства <b>".$winner."</b>";
		}
		else 
		{
			$winner="Ничья";
			$wins="Ничья";
			$txt="Война окончена между Ханством <b>".$res["c2_name"]."</b> и <b>".$res["c1_name"]."</b>. Ничья...";
		}
		$text.=$txt."<br>";
		mysql_query('UPDATE `clan_history` SET `winner` = \''.$winner.'\', `active` = 0, `log` = CONCAT(`log`,\''."<span class=date>".date("d.m.y H:i")."</span> Битва завершен. Победитель: <b>".$winner."</>.<BR>".'\') WHERE `active` = 1 and attacker="'.$res["attacker"].'" and clan_id="'.$res["id"].'"');
		mysql_query("DELETE FROM clan_battle WHERE id=".$res["id"]);
		mysql_query("UPDATE clan SET war_time='".(time()+7*24*3600)."' WHERE name_short='".$res["defender"]."'");
		mysql_query("UPDATE clan SET wins=wins+1 WHERE name_short='".$wins."'");
		mysql_query("INSERT INTO news (info) VALUES ('".$txt."');");
	}
	$text = "sys<font style=color:#990000>$text</font>endSys";
	$chat_base = "/srv/www/meydan.az/public_html/chat/lovechat";
	$fopen_chat = fopen($chat_base,"a");
	fwrite ($fopen_chat,"::".time()."::sys_news::#FF0000::$text::room4::mountown::\n");
	fclose ($fopen_chat);
	
	//echo "Clan Wars";
}
?>