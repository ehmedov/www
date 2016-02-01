<?
	if ($db["admin_level"]>=10)
	{
		$page=(int)abs($_GET['page']);
		$table = mysql_query("SELECT count(*) FROM smscoin");
		$row=mysql_fetch_array($table);
		$page_cnt=$row[0];
		$cnt=$page_cnt; // общее количество записей во всём выводе
		$rpp=30; // кол-во записей на страницу
		$rad=2; // сколько ссылок показывать рядом с номером текущей страницы (2 слева + 2 справа + активная страница = всего 5)

		$links=$rad*2+1;
		$pages=ceil($cnt/$rpp);
		if ($page>0) { echo "<a href=\"admin.php?spell=smscoin&page=0\">«««</a> | <a href=\"admin.php?spell=smscoin&page=".($page-1)."\">««</a> |"; }
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
				echo "<a href=\"admin.php?spell=smscoin&page=$i\">";
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
		if ($pages>$links && $page<($pages-$rad-1)) { echo " ... <a href=\"admin.php?spell=smscoin&page=".($pages-1)."\">".($pages-1)."</a>"; }
		if ($page<$pages-1) { echo " | <a href=\"admin.php?spell=smscoin&page=".($page+1)."\">»»</a> | <a href=\"admin.php?spell=smscoin&page=".($pages-1)."\">»»»</a>"; }

		$limit = $rpp;
		$eu = $page*$limit;
		echo "<table width=100% cellspacing=1 cellpadding=3 class='l3'><TR><td><b>Receiver</td><td><b>Bank Number</td><td><b>SUM</td><td><b>Platina</td><td><b>Bonus</td><td><b>Mobile Number</td><td><b>Transaction</td><td><b>Date</td></tr>";
		
		$sql=mysql_query("SELECT smscoin.*, users.login FROM smscoin LEFT JOIN users ON users.id=smscoin.user_id ORDER BY date DESC LIMIT $eu, $limit");
		while ($res=mysql_fetch_array($sql))
		{
			$n=(!$n);
			echo "<tr class='".($n?'l0':'l1')."'><td nowrap><small>".$res["login"]."</td><td nowrap><small>".$res["bank_id"]."</td><td nowrap><small>".$res["amount"]." AZN</td><td nowrap><small>".$res["platina"]."</td><td nowrap><small>".$res["bonus"]."</td><td nowrap><small>".$res["s_phone"]."</td><td nowrap><small>".$res["s_inv"]."</td><td nowrap><small>".$res["date"]."</td></tr>";
		}

		mysql_free_result($sql);
		echo "</table>";
	}
	else
	{
		echo "Вам сюда нельзя!";
	}
?>
