<?include("time.php");?>
<SCRIPT LANGUAGE="JavaScript" SRC="scripts/magic-main.js"></SCRIPT>
<div id=hint4></div>	
<?
#################ПРОДАННЫЕ ЛОТЫ#################
$query=mysql_Query("SELECT auction.*, login, remote_ip FROM auction LEFT JOIN users ON users.id=auction_owner WHERE `auction_time`<UNIX_TIMESTAMP()");
while ($have_sell=mysql_fetch_array($query))
{
	if (!$have_sell["lot_owner"])
	{
		mysql_Query("UPDATE inv SET owner='".$have_sell["login"]."' WHERE id=".$have_sell["auction_item"]);
		history($have_sell["login"],"ПРЕДМЕТ НЕ ПРОДАН","[INV ID: ".$have_sell["auction_item"]."]",$have_sell["remote_ip"],"Аукцион");
		mysql_query("INSERT INTO pochta(user, whom, text, subject) VALUES ('Путешественник','".$have_sell["login"]."','Ваша предмет не продан и возвращен в инвентар...','ПРЕДМЕТ НЕ ПРОДАН')");
		mysql_query("DELETE FROM auction WHERE auction_id=".$have_sell["auction_id"]);
	}
	else
	{
		$skupwik=mysql_fetch_array(mysql_Query("SELECT login, remote_ip FROM users WHERE id=".$have_sell["lot_owner"]));
		mysql_Query("UPDATE inv SET owner='".$skupwik["login"]."' WHERE id=".$have_sell["auction_item"]);
		mysql_query("UPDATE person_proff SET navika=navika+1 WHERE proff=10 and person=".$have_sell["auction_owner"]);
		mysql_query("UPDATE users SET money=money+".($have_sell["auction_price"]*0.9)." WHERE id=".$have_sell["auction_owner"]);
		history($have_sell["login"],"ПРЕДМЕТ ПРОДАН","[INV ID: ".$have_sell["auction_item"]."] за ".($have_sell["auction_price"]*0.9)." Зл. (Скупшик: ".$skupwik["login"].")",$have_sell["remote_ip"],"Аукцион");
		history($skupwik["login"],"КУПИЛИ ПРЕДМЕТ","[INV ID: ".$have_sell["auction_item"]."] за ".$have_sell["auction_price"]." Зл. (Владелеч: ".$have_sell["login"].")",$skupwik["remote_ip"],"Аукцион");
		mysql_query("INSERT INTO pochta(user, whom, text, subject) VALUES ('Путешественник','".$have_sell["login"]."','Ваша предмет был продан за ".($have_sell["auction_price"]*0.9)."','ПРЕДМЕТ ПРОДАН')");
		mysql_query("INSERT INTO pochta(user, whom, text, subject) VALUES ('Путешественник','".$skupwik["login"]."','Вы удачно купили предмет за ".($have_sell["auction_price"])."','КУПИЛИ ПРЕДМЕТ')");
		mysql_query("DELETE FROM auction WHERE auction_id=".$have_sell["auction_id"]);
	}
}
#################ЗАБРАТЬ ЛОТ####################
if ($_GET["get_lot"])
{
	$_GET['razdel']=2;
	$get_lot=(int)$_GET["get_lot"];
	$have_lot = mysql_fetch_Array(mysql_query("SELECT * FROM `auction` WHERE auction_id=$get_lot and `auction_owner`='".$db["id"]."'"));
	if ($have_lot)
	{
		if ($have_lot['lot_owner'])
		{
			$msg="На ваш лот было сделано ставки, вы не имеете возможность снять вещь с аукциона.";
		}
		else
		{
			mysql_Query("UPDATE inv SET owner='".$login."' WHERE id=".$have_lot['auction_item']);
			mysql_query("DELETE FROM auction WHERE auction_id=$get_lot");
			$msg="Вы удачно забрали лот";
		}
	}
}
#################ПОДНЯТЬ СТАВКУ#################
if (isset($_GET['cssale']) && $_GET['item']) 
{
	$kredit=(int)$_POST['lot_price'];
	$item_id=(int)$_GET['item'];
	if ($db["money"]>=$kredit)
	{	
		$dress = mysql_fetch_array(mysql_query("SELECT * FROM `auction` LEFT JOIN inv ON inv.id=auction.auction_item WHERE `auction_id` = '{$item_id}'"));
		if ($dress['auction_owner']==$db["id"]) {$msg="Нельзя повишать за свой предмет";} 
		else if ($dress['auction_time']<time()) {$msg="Время просрочена... Ждем Работы Аукционера...";} 
		else
		{
			if ($dress['lot_owner']==$db["id"])
			{
				mysql_query("UPDATE `auction` SET `auction_price`=`auction_price`+'".$kredit."' WHERE `auction_id`='".$dress["auction_id"]."'");
				mysql_query("UPDATE users SET money=money-$kredit WHERE login='".$login."'");
				$db["money"]=$db["money"]-$kredit;
				$msg="Вы подняли ставку";
			}
			else
			{
				if ($dress['auction_price']>=$kredit) {$msg="Слишком низкая ставка";}
				else 
				{
					if ($dress['lot_owner'])
					{
						$lot_owner=mysql_fetch_Array(mysql_Query("SELECT login FROM users WHERE id=".$dress['lot_owner']));
						mysql_query("UPDATE users SET money=money+".$dress['auction_price']." WHERE id=".$dress['lot_owner']);
						$txt="Ваша ставка в размере ".$dress['auction_price']." Зл. на ".$dress["name"]." была перебита. Деньги возвращены...";
						mysql_query("INSERT INTO pochta(user, whom, text, subject) VALUES ('Путешественник','".$lot_owner["login"]."','".$txt."','Аукцион')");
					}
					mysql_query("UPDATE `auction` SET `auction_price`='".$kredit."', lot_owner=".$db["id"]." WHERE `auction_id`='".$dress["auction_id"]."'");
					mysql_query("UPDATE users SET money=money-$kredit WHERE login='".$login."'");
					$msg="Вы поставили ставку в количесве {$kredit} Зл.";
					$db["money"]=$db["money"]-$kredit;
				}
			}
		}
	}
	else $msg="У Вас нет достаточной суммы...$kredit Зл.!";
}
#################СДАЛ ПРЕДМЕТ#################
if ($_GET['sale'] && $_GET['item']) 
{
	$_GET['razdel']=3;
	$kredit=(int)$_POST['lot_price'];
	$item_name=htmlspecialchars(addslashes($_GET['sale']));
	$item_id=(int)$_GET['item'];
	if ($kredit>0) 
	{
		$Is_Torqovech=mysql_fetch_array(mysql_query("SELECT count(*) FROM person_proff WHERE proff=10 and person=".$db["id"]));
		if (!$Is_Torqovech[0])
		{
			$msg="Сдать предмет может только Торговеч.";
		}
		else
		{
			$dress = mysql_fetch_array(mysql_query("SELECT * FROM inv WHERE object_razdel in ('obj', 'runa') and owner='".$login."' and wear=0 and id=$item_id"));
			if($dress) 
			{
				if($dress['art']) $msg='Вы не можете сдать на аукцион АРТ.';
				else if($dress['podzemka']) $msg='Вы не можете сдать на аукцион Предмет из подземелья.';
				else if($dress['gift']) $msg='Предмет подарен вам. Вы не можете сдать на аукцион.';
				else if($dress['is_modified']>5) $msg='Вы не можете сдать на аукцион Предмет.';
				else
				{	
					if ($db["money"]>=10)
					{	
						$t_time=time()+24*3600;
						if ($dress["name"]=="")$dress["name"]=$item_name;
						mysql_query("UPDATE `inv` SET `owner` = '' WHERE `id` = ".$dress["id"]);
						mysql_query("UPDATE `users` SET money=money-10 WHERE `login` = '".$login."'");
						mysql_query("INSERT INTO `auction`(auction_item, auction_time, auction_price, auction_owner, stype) VALUES ('".$dress["id"]."','$t_time','$kredit','".$db["id"]."','".$dress["object_type"]."')");
						history($login,"СДАЛ ПРЕДМЕТ",$dress["name"]." за $kredit Зл. [id: ".$dress["id"]."]",$db["remote_ip"],"Аукцион");
						$msg="Вы сдали на аукцион \"{$dress['name']}\" за {$kredit} Зл.";
						$db["money"]=$db["money"]-10;
					}
					else $msg="У Вас нет достаточной суммы...10.00 Зл.!";
				}
			}
			else 
			{
				$msg="Предмет не найден в вашем рюкзаке!";
			}
		}
	}
}
##############################################
echo "<font color=red>$msg</font>";
?>
<TABLE border=0 width=100% cellspacing="0" cellpadding="0">
<tr>
	<td align=center width=100%><h3>Аукцион</h3></td>
	<td align=right nowrap>
    	<input type="button" class="podskazka" value="Подсказка" onclick="window.open('help/auction.php','displayWindow','height=400,width=500,resizable=no,scrollbars=yes,menubar=no,status=no,toolbar=no,directories=no,location=no')"/>
		<input type="button" onclick="location.href='main.php?act=none'" value="Обновить" class=new >
		<input type="button" onclick="location.href='main.php?act=go&level=remesl'" value="Вернуться" class=new >
	</td>
</tr>
</table>
<TABLE border=0 width=100% cellspacing="0" cellpadding="4">
<TR>
	<TD valign=top width=900 nowrap>
		<TABLE border=0 width=100% cellspacing="0" cellpadding="0">
		<TR>
			<TD>
			<TABLE border=0 width=100% cellspacing="0" cellpadding="1" class="l3">
			<TR>
				<td align=center><B>Залы:</B></TD>
				<TD align=center <?=($_GET['razdel']==0)?"class='fnew'":"class='fold'"?> nowrap><a href="?razdel=0" style="color: #ffffff">Торги</a></TD>
				<TD align=center <?=($_GET['razdel']==1)?"class='fnew'":"class='fold'"?> nowrap><a href="?razdel=1" style="color: #ffffff">Мои ставки</a></TD>
				<TD align=center <?=($_GET['razdel']==2)?"class='fnew'":"class='fold'"?> nowrap><a href="?razdel=2" style="color: #ffffff">Мои лоты</a></TD>
				<TD align=center <?=($_GET['razdel']==3)?"class='fnew'":"class='fold'"?> nowrap><a href="?razdel=3" style="color: #ffffff">Выставить на аукцион</a></TD>
			</TR>
			<TR>
				<td colspan=5 height=30 class='fnew'>
					<CENTER>
					<?
					switch ($_GET['razdel']) 
					{
						case 0: echo "Тут Вы можете выбрать из списка вещей в правой части экрана, какого рода вещи Вас интересуют.
						<b>Внимание!</b> В момент, когда Вы делаете ставку на аукционе, Вы должны располагать необходимой суммой кредитов.
		 				Эта сумма должна быть у персонажа, а не, например, в банке. Указанная сумма кредитов изымается из Вашего кошелька и резервируется до окончания торгов.
		   				По окончании торгов Вам или возвращаются кредиты, если Вашу ставку перебили, или достается приобретенная вещь. "; break;
						case 1: echo "В этом разделе Вы можете следить за своими ставками на выбранный предмет и забрать предмет, если Ваша ставка выиграет. "; break;
						case 2: echo "Просмотр выставленных лотов. В этом разделе Вы можете увидеть Ваши выставленные лоты и забрать те, на которые не было ставок и время торгов по которым закончилось."; break;
						case 3: echo "В этом разделе, используя фильтр вещей в правой части экрана, Вы можете выбрать вещь из своего инвентаря для выставления на аукцион. Стоимость комиссии выставления лота на аукцион равна <b>10.00 Зл.</b> Если лот покупают, <b>10.00 Зл.</b> возвращается Вам, а с продажи взимается комиссия 10%. Если лот не продан, <b>10.00 Зл.</b> не возвращается."; break;
					}
					?>
					</CENTER>
				</td>
			</tr>
			</TABLE>
			</TD>
		</TR>
		</TABLE>
		<?
			#if (!$db["adminsite"])die("UNDER CONSTRUCTION");
			if ($_POST["apply"])
			{
				$_SESSION["iname"]=htmlspecialchars(addslashes($_POST["iname"]));
				$_SESSION["ilevellow"]=(int)$_POST["ilevellow"];
				$_SESSION["ilevelmax"]=(int)$_POST["ilevelmax"];
				$_SESSION["itype"]=htmlspecialchars(addslashes($_POST["itype"]));
			}
			if ($_POST["reset"])
			{
				$_SESSION["iname"]="";
				$_SESSION["ilevellow"]=0;
				$_SESSION["ilevelmax"]=0;
				$_SESSION["itype"]="";
			}
			if ($_GET['razdel']==0)
			{
				?>
				<form method="POST" action="main.php" style="margin:0px;">
				<table width=100% class="l2"><tr>
				<td>Название: <input type=text name="iname" value="<?=$_SESSION["iname"];?>"></td>
				<td>Уровень от <input type=text size=2 name="ilevellow" value="<?=(int)$_SESSION["ilevellow"];?>"></td>
				<td> до <input type=text size=2 name="ilevelmax" value="<?=(int)$_SESSION["ilevelmax"];?>"></td>
				<td>Вид: <select style="width:200px;" name="itype">
					<option <?=($_SESSION["itype"]==""?"selected":"");?> value="">Без фильтра</option>
					<option <?=($_SESSION["itype"]=="sword"?"selected":"");?> value="sword">Мечи</option>
					<option <?=($_SESSION["itype"]=="axe"?"selected":"");?> value="axe">Топоры и Секиры</option>
					<option <?=($_SESSION["itype"]=="fail"?"selected":"");?> value="fail">Дубины и Булавы</option>
					<option <?=($_SESSION["itype"]=="spear"?"selected":"");?> value="spear">Древковое оружие</option>
					<option <?=($_SESSION["itype"]=="knife"?"selected":"");?> value="knife">Кастеты и ножи</option>
					<option <?=($_SESSION["itype"]=="staff"?"selected":"");?> value="staff">Посохи</option>
					<option <?=($_SESSION["itype"]=="armour"?"selected":"");?> value="armour">Тяжелая броня</option>
					<option <?=($_SESSION["itype"]=="rubaxa"?"selected":"");?> value="rubaxa">Рубахи</option>
					<option <?=($_SESSION["itype"]=="plash"?"selected":"");?> value="plash">Плащи</option>
					<option <?=($_SESSION["itype"]=="helmet"?"selected":"");?> value="helmet">Шлемы</option>
					<option <?=($_SESSION["itype"]=="mask"?"selected":"");?> value="mask">Маски и Короны</option>
					<option <?=($_SESSION["itype"]=="shield"?"selected":"");?> value="shield">Щиты</option>
					<option <?=($_SESSION["itype"]=="pants"?"selected":"");?> value="pants">Поножи</option>
					<option <?=($_SESSION["itype"]=="boots"?"selected":"");?> value="boots">Сапоги</option>
					<option <?=($_SESSION["itype"]=="perchi"?"selected":"");?> value="perchi">Перчатки</option>
					<option <?=($_SESSION["itype"]=="poyas"?"selected":"");?> value="poyas">Пояса</option>
					<option <?=($_SESSION["itype"]=="amulet"?"selected":"");?> value="amulet">Амулеты</option>
					<option <?=($_SESSION["itype"]=="naruchi"?"selected":"");?> value="naruchi">Наручи</option>
					<option <?=($_SESSION["itype"]=="ring"?"selected":"");?> value="ring">Кольца</option>
					<option <?=($_SESSION["itype"]=="amunition"?"selected":"");?> value="amunition">Инструменты</option>
					<option <?=($_SESSION["itype"]=="kostyl"?"selected":"");?> value="kostyl">Амуниция</option>
					<option <?=($_SESSION["itype"]=="runa"?"selected":"");?> value="runa">Руны</option>
					<option <?=($_SESSION["itype"]=="wood"?"selected":"");?> value="wood">Ресурсы</option>
				</select></td>
				<td><input type="submit" name="apply" value="Применить"></td>
				<td><input type="submit" name="reset" value="Сбросить"></td>
				</tr>
				</table>
				<?
			}
		?>
		<table width=100% cellspacing=1 cellpadding=2  class="l3">
		<?
		if ($_GET['razdel']==0)
		{
			###########################################################################
			echo "<tr><td colspan=2 class='l1'>Страницы: ";
			$page=(int)abs($_GET['page']);
			$row=mysql_fetch_array(mysql_query("SELECT count(*) FROM `auction` ".($_SESSION["itype"]!=""?"WHERE stype='".$_SESSION["itype"]."'":"")." ORDER BY auction_time DESC"));
			$page_cnt=$row[0];
			$cnt=$page_cnt; // общее количество записей во всём выводе
			$rpp=20; // кол-во записей на страницу
			if ($_SESSION["iname"]!="" || $_SESSION["ilevellow"] || $_SESSION["ilevelmax"])$rpp=$page_cnt;
			$rad=2; // сколько ссылок показывать рядом с номером текущей страницы (2 слева + 2 справа + активная страница = всего 5)

			$links=$rad*2+1;
			$pages=ceil($cnt/$rpp);
			if ($page>0) { echo "<a href=\"?page=0\">«««</a> | <a href=\"?page=".($page-1)."\">««</a> |"; }
			$start=$page-$rad;
			if ($start>$pages-$links) { $start=$pages-$links; }
			if ($start<0) { $start=0; }
			$end=$start+$links;
			if ($end>$pages) { $end=$pages; }
			for ($i=$start; $i<$end; $i++) 
			{
				if ($i==$page)
				{
					echo "<b style='color:#ff0000'><u>";
				} 
				else 
				{
					echo "<a href=\"?page=$i\">";
				}
				echo $i;
				if ($i==$page) 
				{
					echo "</u></b>";
				} 
				else 
				{
					echo "</a>";
				}
				if ($i!=($end-1)) { echo " | "; }
			}
			if ($pages>$links && $page<($pages-$rad-1)) { echo " ... <a href=\"?page=".($pages-1)."\">".($pages-1)."</a>"; }
			if ($page<$pages-1) { echo " | <a href=\"?page=".($page+1)."\">»»</a> | <a href=\"?page=".($pages-1)."\">»»»</a>"; }

			$limit = $rpp;
			$eu = $page*$limit;
			echo "</td></tr>";
			###########################################################################
			$data = mysql_query("SELECT auction.*, users.login FROM `auction` LEFT JOIN users ON users.id=auction.auction_owner ".($_SESSION["itype"]!=""?"WHERE stype='".$_SESSION["itype"]."'":"")." ORDER BY auction_time DESC LIMIT $eu, $limit");
			while($row = mysql_fetch_array($data)) 
			{
				
				$n=(!$n);
				if ($row["stype"]=="runa")
				{
					$data_auction=mysql_fetch_Array(mysql_query("SELECT runa.*, inv.id as ids, inv.iznos, inv.iznos_max FROM inv LEFT JOIN runa ON runa.id=inv.object_id WHERE inv.id=".$row["auction_item"].($_SESSION["iname"]!=""?" and runa.name like '%".$_SESSION["iname"]."%'":"").($_SESSION["ilevellow"]?" and runa.min_level>=".$_SESSION["ilevellow"]."":"").($_SESSION["ilevelmax"]?" and runa.min_level<=".$_SESSION["ilevelmax"]."":"")));
					$data_img="img";
				}
				else if ($row["stype"]=="wood")
				{
					$data_auction=mysql_fetch_Array(mysql_query("SELECT wood.*, inv.id as ids, inv.iznos, inv.iznos_max FROM inv LEFT JOIN wood ON wood.id=inv.object_id WHERE inv.id=".$row["auction_item"].($_SESSION["iname"]!=""?" and wood.name like '%".$_SESSION["iname"]."%'":"").($_SESSION["ilevellow"]?" and min_level>=".$_SESSION["ilevellow"]."":"").($_SESSION["ilevelmax"]?" and min_level<=".$_SESSION["ilevelmax"]."":"")));
					$data_img="img";
				}
				else
				{
					$data_auction=mysql_fetch_Array(mysql_query("SELECT * FROM inv WHERE inv.id=".$row["auction_item"].($_SESSION["iname"]!=""?" and name like '%".$_SESSION["iname"]."%'":"").($_SESSION["ilevellow"]?" and min_level>=".$_SESSION["ilevellow"]."":"").($_SESSION["ilevelmax"]?" and min_level<=".$_SESSION["ilevelmax"]."":"")));
					$data_img="img/items";
				}
				if ($data_auction)
				{
					echo "<tr class='".($n?'l0':'l1')."'><TD align=center><IMG SRC=\"$data_img/{$data_auction['img']}\" BORDER=0><BR>
					<A onclick=\"lot('Сделать ставку :', '?cssale={$data_auction['name']}&item={$row['auction_id']}', '{$data_auction['name']}', '4')\" style='CURSOR: Hand'>Сделать ставку</A><br>
					Окончание торгов: <br>".($row['auction_time']>time()?convert_time($row['auction_time']):"<font color=red>Время просрочена... <br>Ждем Работы Аукционера...</font>");
					echo ($db["adminsite"]?"<br>Владелеч: ".$row["login"]:"");
					echo "</TD>";
					echo "<TD valign=top>";
				 	$data_auction["price"]=$row["auction_price"];
				 	show_item($db,$data_auction); 
				 	echo "</TD>
				 	</tr>";	
			 	}
			}
		}
		##################МОИ СТАВКИ####################
		if ($_GET['razdel']==1) 
		{
			$data = mysql_query("SELECT * FROM `auction` WHERE `lot_owner`='".$db["id"]."' ORDER BY auction_time DESC");
			while($row = mysql_fetch_array($data)) 
			{
				$n=(!$n);
				if ($row["stype"]=="runa")
				{
					$data_auction=mysql_fetch_Array(mysql_query("SELECT runa.*, inv.id as ids, inv.iznos, inv.iznos_max FROM inv LEFT JOIN runa ON runa.id=inv.object_id WHERE inv.id=".$row["auction_item"]));
					$data_img="img";
				}
				else if ($row["stype"]=="wood")
				{
					$data_auction=mysql_fetch_Array(mysql_query("SELECT wood.*, inv.id as ids, inv.iznos, inv.iznos_max FROM inv LEFT JOIN wood ON wood.id=inv.object_id WHERE inv.id=".$row["auction_item"]));
					$data_img="img";
				}
				else
				{
					$data_auction=mysql_fetch_Array(mysql_query("SELECT * FROM inv WHERE inv.id=".$row["auction_item"]));
					$data_img="img/items";
				}
				echo "<tr class='".($n?'l0':'l1')."'><TD align=center><IMG SRC=\"$data_img/{$data_auction['img']}\" BORDER=0><BR>
				<A onclick=\"lot('Поднять ставку :', '?cssale={$data_auction['name']}&item={$row['auction_id']}&razdel=1', '{$data_auction['name']}', '4')\" style='CURSOR: Hand'>Поднять ставку</A><br>
				Окончание торгов: <br>".convert_time($row['auction_time'])."<br>
				Мои ставки: ".$row["auction_price"]." Зл.</TD>
				<TD valign=top>";
		 		$data_auction["price"]=$row["auction_price"];
				show_item($db,$data_auction);
				echo"</TD>
				</TR>"; 
			}
		}
		##################МОИ ЛОТЫ####################
		if ($_GET['razdel']==2) 
		{
			$data = mysql_query("SELECT * FROM `auction` WHERE `auction_owner`='".$db["id"]."' ORDER BY auction_time DESC");
			while($row = mysql_fetch_array($data)) 
			{
				$n=(!$n);
				if ($row["stype"]=="runa")
				{
					$data_auction=mysql_fetch_Array(mysql_query("SELECT runa.*, inv.id as ids, inv.iznos, inv.iznos_max FROM inv LEFT JOIN runa ON runa.id=inv.object_id WHERE inv.id=".$row["auction_item"]));
					$data_img="img";
				}
				else if ($row["stype"]=="wood")
				{
					$data_auction=mysql_fetch_Array(mysql_query("SELECT wood.*, inv.id as ids, inv.iznos, inv.iznos_max FROM inv LEFT JOIN wood ON wood.id=inv.object_id WHERE inv.id=".$row["auction_item"]));
					$data_img="img";
				}
				else
				{
					$data_auction=mysql_fetch_Array(mysql_query("SELECT * FROM inv WHERE inv.id=".$row["auction_item"]));
					$data_img="img/items";
				}
				echo "<tr class='".($n?'l0':'l1')."'><TD align=center><IMG SRC=\"$data_img/{$data_auction['img']}\" BORDER=0><BR>";
				if (!$row['lot_owner'])echo "<A HREF=\"?get_lot={$row['auction_id']}\">Забрать лот</A><br>";
				echo "Окончание торгов: <br>".convert_time($row['auction_time'])."<br></TD>";
				echo "<TD valign=top>";
				$data_auction["price"]=$row["auction_price"];
				show_item($db,$data_auction);
				echo"</TD>
				</TR>"; 
			}
		}
		##################ВЫСТАВИТЬ НА АУКЦИОН####################
		if ($_GET['razdel']==3) 
		{
			$data = mysql_query("SELECT * FROM inv WHERE object_razdel='obj' and owner='".$login."' and wear=0");
			while($row = mysql_fetch_array($data)) 
			{
				$n=(!$n);
				echo "<tr class='".($n?'l0':'l1')."'><TD align=center><IMG SRC=\"img/items/{$row['img']}\" BORDER=0><BR>
				<A onclick=\"lot('Выставить лот :', '?sale={$row['name']}&item={$row['id']}', '{$row['name']}', '4')\" style='CURSOR: Hand'>Выставить лот</A>
				</TD>
				<TD valign=top>";
				show_item($db,$row);
				echo "</TD></TR>";
			}
			$data = mysql_query("SELECT runa.*, inv.id as ids, inv.iznos, inv.iznos_max FROM inv LEFT JOIN runa ON runa.id=inv.object_id WHERE object_razdel='runa' and owner='".$login."' and wear=0");
			while($row = mysql_fetch_array($data)) 
			{
				$n=(!$n);
				echo "<tr class='".($n?'l0':'l1')."'><TD align=center><IMG SRC=\"img/{$row['img']}\" BORDER=0><BR>
				<A onclick=\"lot('Выставить лот :', '?sale={$row['name']}&item={$row['ids']}', '{$row['name']}', '4')\" style='CURSOR: Hand'>Выставить лот</A>
				</TD>
				<TD valign=top>";
				show_item($db,$row);
				echo "</TD></TR>";
			}
		}
	?>
	</TABLE>
	</TD>
	<td valign=top>
		<?
			$money = sprintf ("%01.2f", $db["money"]);
			$platina = sprintf ("%01.2f", $db["platina"]);
		?>
		У вас в наличии: <B><?echo $money;?></b> Зл. <b><?echo $platina;?></b> Пл. 
	</td>
	</tr>	
	</TABLE>
