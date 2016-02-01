<?
include('key.php');
$login=$_SESSION["login"];
$do=$_GET["do"];
$a=$_GET["a"];
if (!$do)$do=1;
$clan_t = $db["clan"];
$clan_s = $db["clan_short"];
$orden_t = $db["orden"];

$SITED = mysql_fetch_array(mysql_query("SELECT * FROM clan WHERE name_short='".$clan_s."'"));
$clan_site = $SITED["site"];
$history = $SITED["story"];
$clan_orden=$SITED["orden"];
$history = str_replace("<BR>","\n",$history);
$ip=getenv('REMOTE_ADDR');

function op($who,$operation,$cl)
{
	$dates=date("Y-m-d H:i:s");
	$txt=$who."|".$operation."|".$dates."|"."\n";
	$td = fopen("clan/operation/$cl.dis","a");
    fputs($td,$txt);
    fclose($td);
}
?>
<SCRIPT LANGUAGE="JavaScript" SRC="scripts/magic-main.js"></SCRIPT>
<script>
	function goSite()
	{
		window.open("<?echo $clan_site?>");
	}
	function clan(name)
	{
		top.talk.talker.phrase.focus();
		var s=top.talk.talker.phrase.value="clan ["+name+"] "+top.talk.talker.phrase.value;top.talk.talker.phrase.focus();
	}
	function conf(name)
	{	
		if (confirm('Вы уверены, что хотите Выйти из Хаства '+name+'?')) 
		{
			location.href = 'main.php?act=clan&do=7';
		}
	}
</script>
<div id=hint4></div>
<?
if($clan_t!="")
{
	?>
	<h3>Ханства <?=$clan_t;?></h3>
	<table border=0 width=100%>
	<tr valign=top>
		<td width=150>
		<?
			echo "<input type=button class=but value='Вернуться' onclick=\"location.href='main.php?act=none'\" style=\"width:180px;\"><BR>";
			echo "<input type=button class=but value='Состав' onClick=\"location.href='main.php?act=clan&do=1'\" style=\"width:180px;\"><BR>";
			echo "<input type=button class=but value='Клановое сообщение' onClick=\"top.AddToClan('".$clan_t."')\" style=\"width:180px;\"><BR>";
			echo "<input type=button class=but value='Казна Ханства' onClick=\"location.href='main.php?act=clan&do=4'\" style=\"width:180px;\"><BR>";
			echo "<input type=button class=but value='Операции с Казной' onClick=\"location.href='main.php?act=clan&do=6'\" style=\"width:180px;\"><BR>";
			echo "<input type=button class=but value='Список абилок' onClick=\"location.href='main.php?act=clan&do=5'\" style=\"width:180px;\"><BR>";
			echo "<input type=button class=but value='Выйти из Ханства' onClick=\"conf('".$clan_t."');\" style=\"width:180px;\"><BR>";
			echo "<input type=button class=but value='Наш сайт' onClick=\"goSite()\" style=\"width:180px;\"><BR>";
			echo "<input type=button class=but value='История всех войн' onClick=\"location.href='main.php?act=clan&do=8'\" style=\"width:180px;\"><BR>";
			
			if($db["clan_take"]==1)
			{
				echo "<input type=button class=but value='Принять в Ханство' onClick=\"location.href='main.php?act=clan&do=3'\" style=\"width:180px;font-weight:bold;\"><BR>";
	            echo "<input type=button class=but value='Объявит войну' onClick=\"location.href='main.php?act=clan&do=2&a=war'\" style=\"width:180px;font-weight:bold;\"><BR>";
			}
	        if($db["glava"]==1)
	        {
	            echo "<input type=button class=but value='Сменить статус' onClick=\"location.href='main.php?act=clan&do=2&a=chin'\" style=\"width:180px;\"><BR>";
	            echo "<input type=button class=but value='Выгнать из Ханства' onClick=\"location.href='main.php?act=clan&do=2&a=out'\" style=\"width:180px;\"><BR>";
	            echo "<input type=button class=but value='Передать главенство' onClick=\"location.href='main.php?act=clan&do=2&a=give'\" style=\"width:180px;font-weight:bold;\"><BR>";
	            echo "<input type=button class=but value='Назначить Визирем' onClick=\"location.href='main.php?act=clan&do=2&a=zam'\" style=\"width:180px;\"><BR>";
	            echo "<input type=button class=but value='Уволит Визиря' onClick=\"location.href='main.php?act=clan&do=2&a=unzam'\" style=\"width:180px;\"><BR>";
	            echo "<input type=button class=but value='Настройки Ханства' onClick=\"location.href='main.php?act=clan&do=2&a=opt'\" style=\"width:180px;\"><BR>";
	            echo "<input type=button class=but value='Сменить склонность' onClick=\"location.href='main.php?act=clan&do=2&a=change_sclon'\" style=\"width:180px;\"><BR>";
	            echo "<input type=button class=but value='Сменить названия' onClick=\"location.href='main.php?act=clan&do=2&a=change_name'\" style=\"width:180px;\"><BR>";
	        }
		?>
		<center><img src='img/index/vip.gif'>
		</td>
		<td>	
			<?
				$kazna = sprintf ("%01.2f", $SITED['kazna']);
				$money = sprintf ("%01.2f", $db['money']);
				$platina = sprintf ("%01.2f", $db['platina']);
				echo "<div align=right>У вас: <B>".$money."</b> Зл., <B>".$platina."</b> Пл.<br>В казне клана: <B>".$kazna."</b> Зл.<img src='img/zlo.gif'>&nbsp;&nbsp;&nbsp; Рейтинг Ханства: <b>".$SITED['ochki']."</b>&nbsp;&nbsp;&nbsp;Победа Ханства: <b>".$SITED['wins']."</b></div><hr>";

				if($do==1)
		        {
					include "clan/sostav.php";
		        }
				if($do == 2)
				{
	            	switch ($a) 
					{
						 case "chin":include "clan/chin.php";break;
						 case "out":include "clan/out.php";break;
						 case "give":include "clan/give.php";break;
						 case "war":include "clan/war.php";break;
						 case "zam":include "clan/zam.php";break;
						 case "unzam":include "clan/unzam.php";break;
						 case "opt":include "clan/opt.php";break;
						 case "change_sclon":include "clan/change_sclon.php";break;
						 case "change_name":include "clan/change_name.php";break;
					}
		        }
		        if($do == 3 && $db["clan_take"] == 1)
		        {
	                include "clan/take.php";
		        }
		        if($do == 4)
		        {
	                include "clan/kazna.php";
		        }
		        if($do == 5)
		        {
	                include "clan/abils.php";
		        }
		        if($do == 6)
		        {
	                include "clan/operation.php";
		        }
		        if($do == 7)
		        {
	                include "clan/exit.php";
		        }
		        if($do == 8)
		        {
	                include "clan/log.php";
		        }
			?>
		</td>
	</tr>
	</table>
	<?
}
?>
