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
		if (confirm('�� �������, ��� ������ ����� �� ������ '+name+'?')) 
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
	<h3>������� <?=$clan_t;?></h3>
	<table border=0 width=100%>
	<tr valign=top>
		<td width=150>
		<?
			echo "<input type=button class=but value='���������' onclick=\"location.href='main.php?act=none'\" style=\"width:180px;\"><BR>";
			echo "<input type=button class=but value='������' onClick=\"location.href='main.php?act=clan&do=1'\" style=\"width:180px;\"><BR>";
			echo "<input type=button class=but value='�������� ���������' onClick=\"top.AddToClan('".$clan_t."')\" style=\"width:180px;\"><BR>";
			echo "<input type=button class=but value='����� �������' onClick=\"location.href='main.php?act=clan&do=4'\" style=\"width:180px;\"><BR>";
			echo "<input type=button class=but value='�������� � ������' onClick=\"location.href='main.php?act=clan&do=6'\" style=\"width:180px;\"><BR>";
			echo "<input type=button class=but value='������ ������' onClick=\"location.href='main.php?act=clan&do=5'\" style=\"width:180px;\"><BR>";
			echo "<input type=button class=but value='����� �� �������' onClick=\"conf('".$clan_t."');\" style=\"width:180px;\"><BR>";
			echo "<input type=button class=but value='��� ����' onClick=\"goSite()\" style=\"width:180px;\"><BR>";
			echo "<input type=button class=but value='������� ���� ����' onClick=\"location.href='main.php?act=clan&do=8'\" style=\"width:180px;\"><BR>";
			
			if($db["clan_take"]==1)
			{
				echo "<input type=button class=but value='������� � �������' onClick=\"location.href='main.php?act=clan&do=3'\" style=\"width:180px;font-weight:bold;\"><BR>";
	            echo "<input type=button class=but value='������� �����' onClick=\"location.href='main.php?act=clan&do=2&a=war'\" style=\"width:180px;font-weight:bold;\"><BR>";
			}
	        if($db["glava"]==1)
	        {
	            echo "<input type=button class=but value='������� ������' onClick=\"location.href='main.php?act=clan&do=2&a=chin'\" style=\"width:180px;\"><BR>";
	            echo "<input type=button class=but value='������� �� �������' onClick=\"location.href='main.php?act=clan&do=2&a=out'\" style=\"width:180px;\"><BR>";
	            echo "<input type=button class=but value='�������� ����������' onClick=\"location.href='main.php?act=clan&do=2&a=give'\" style=\"width:180px;font-weight:bold;\"><BR>";
	            echo "<input type=button class=but value='��������� �������' onClick=\"location.href='main.php?act=clan&do=2&a=zam'\" style=\"width:180px;\"><BR>";
	            echo "<input type=button class=but value='������ ������' onClick=\"location.href='main.php?act=clan&do=2&a=unzam'\" style=\"width:180px;\"><BR>";
	            echo "<input type=button class=but value='��������� �������' onClick=\"location.href='main.php?act=clan&do=2&a=opt'\" style=\"width:180px;\"><BR>";
	            echo "<input type=button class=but value='������� ����������' onClick=\"location.href='main.php?act=clan&do=2&a=change_sclon'\" style=\"width:180px;\"><BR>";
	            echo "<input type=button class=but value='������� ��������' onClick=\"location.href='main.php?act=clan&do=2&a=change_name'\" style=\"width:180px;\"><BR>";
	        }
		?>
		<center><img src='img/index/vip.gif'>
		</td>
		<td>	
			<?
				$kazna = sprintf ("%01.2f", $SITED['kazna']);
				$money = sprintf ("%01.2f", $db['money']);
				$platina = sprintf ("%01.2f", $db['platina']);
				echo "<div align=right>� ���: <B>".$money."</b> ��., <B>".$platina."</b> ��.<br>� ����� �����: <B>".$kazna."</b> ��.<img src='img/zlo.gif'>&nbsp;&nbsp;&nbsp; ������� �������: <b>".$SITED['ochki']."</b>&nbsp;&nbsp;&nbsp;������ �������: <b>".$SITED['wins']."</b></div><hr>";

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
