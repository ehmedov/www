<?
	if ($db["admin_level"]>=10)
	{
		$page=(int)abs($_GET['page']);
		$table = mysql_query("SELECT count(*) FROM compl");
		$row=mysql_fetch_array($table);
		$page_cnt=$row[0];
		$cnt=$page_cnt; // общее количество записей во всём выводе
		$rpp=30; // кол-во записей на страницу
		$rad=2; // сколько ссылок показывать рядом с номером текущей страницы (2 слева + 2 справа + активная страница = всего 5)

		$links=$rad*2+1;
		$pages=ceil($cnt/$rpp);
		if ($page>0) { echo "<a href=\"admin.php?spell=compl&page=0\">«««</a> | <a href=\"admin.php?spell=compl&page=".($page-1)."\">««</a> |"; }
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
				echo "<a href=\"admin.php?spell=compl&page=$i\">";
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
		if ($pages>$links && $page<($pages-$rad-1)) { echo " ... <a href=\"admin.php?spell=compl&page=".($pages-1)."\">".($pages-1)."</a>"; }
		if ($page<$pages-1) { echo " | <a href=\"admin.php?spell=compl&page=".($page+1)."\">»»</a> | <a href=\"admin.php?spell=compl&page=".($pages-1)."\">»»»</a>"; }

		$limit = $rpp;
		$eu = $page*$limit;
		echo "<table width=100% cellspacing=1 cellpadding=3 class='l3'><TR bgcolor=><td><b>Sender</td><td><b>Receiver</td><td><b>Sender IP</td><td><b>Receiver IP</td><td><b>Sender Number</td><td><b>Receiver Number</td><td><b>Platina</td><td><b>Bonus</td><td><b>ДАТА</td></tr>";
		//sender,receiver,sender_ip,receiver_ip,sender_number,receiver_number,platina,bonus
		
		if(isset($_POST["find"]) && trim($_POST["search_text"])!="")
		{
			$sql=mysql_query("SELECT * FROM compl WHERE receiver='".$_POST["search_text"]."' ORDER BY date DESC");
			while ($res=mysql_fetch_array($sql))
			{
				$n=(!$n);
				echo "<tr class='".($n?'l0':'l1')."'><td nowrap><small>".$res["sender"]."</td><td><small>".$res["receiver"]."</td><td nowrap><small>".$res["sender_ip"]."</td><td nowrap><small>".$res["receiver_ip"]."</td><td nowrap><small>".$res["sender_number"]."</td><td nowrap><small>".$res["receiver_number"]."</td><td nowrap><small>".$res["platina"]."</td><td nowrap><small>".$res["bonus"]."</td><td nowrap><small>".$res["date"]."</td></tr>";
			}
		}
		else
		{		
			$sql=mysql_query("SELECT * FROM compl ORDER BY date DESC LIMIT $eu, $limit");
			while ($res=mysql_fetch_array($sql))
			{
				$n=(!$n);
				echo "<tr class='".($n?'l0':'l1')."'><td nowrap><small>".$res["sender"]."</td><td><small>".$res["receiver"]."</td><td nowrap><small>".$res["sender_ip"]."</td><td nowrap><small>".$res["receiver_ip"]."</td><td nowrap><small>".$res["sender_number"]."</td><td nowrap><small>".$res["receiver_number"]."</td><td nowrap><small>".$res["platina"]."</td><td nowrap><small>".$res["bonus"]."</td><td nowrap><small>".$res["date"]."</td></tr>";
			}
		}
		mysql_free_result($sql);
		echo "<tr class='l3'><td colspan=9><form action='admin.php?spell=compl' method='POST' style='margin: 0;'> 
			<input class='inup' type='text' name='search_text' value=''>
			<input class='btn' type='submit' name='find' value='Найти!'>
		</form></td></tr>";
		echo "</table>";
	}
	else
	{
		echo "Вам сюда нельзя!";
	}
?>
