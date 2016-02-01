<?
#######################Fill HP and MN############################################
$cure_hp=$db["cure_hp"];
$cure_mn=$db["cure_mn"];

$time_to_cure=$cure_hp-time();
$time_to_cure_mn=$cure_mn-time();

$hhh=$db["hp_all"];
$mmm=$db["mana_all"];
if($db["battle"]==0)
{
	if($time_to_cure>0)
	{
		$cure_full = $db["cure_time"]-$db["cure"];
		$percent_hp=floor((100*$time_to_cure)/$cure_full);
		$percent=100-$percent_hp;
		$hp[0]=floor(($hhh*$percent)/100);
		mysql_query("UPDATE users SET hp='".$hp[0]."' WHERE login='".$db["login"]."'");
	}
	else
	{
		$hp[0]=$db["hp_all"];
		mysql_query("UPDATE users SET hp='".$hp[0]."',cure_hp='0' WHERE login='".$db["login"]."'");
	}
	if($time_to_cure_mn>0)
	{
		$percent_mn=floor((100*$time_to_cure_mn)/1200);
		$percentm=100-$percent_mn;
		$mana[0]=floor(($mmm*$percentm)/100);
		mysql_query("UPDATE users SET mana='".$mana[0]."' WHERE login='".$db["login"]."'");
	}
	else
	{
		$mana[0]=$db["mana_all"];
		mysql_query("UPDATE users SET mana='".$mana[0]."',cure_mn='0' WHERE login='".$db["login"]."'");
	}
}
#setHP($db["login"],0,$db["hp_all"]);
####################################################################################
?>