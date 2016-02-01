<?

	if ($db["admin_level"]>=10)
	{
		$page=(int)abs($_GET['page']);
		$table = mysql_query("SELECT count(*) FROM com_runa");
		$row=mysql_fetch_array($table);
		$page_cnt=$row[0];
		$cnt=$page_cnt; // общее количество записей во всём выводе
		$rpp=30; // кол-во записей на страницу
		$rad=2; // сколько ссылок показывать рядом с номером текущей страницы (2 слева + 2 справа + активная страница = всего 5)

		$links=$rad*2+1;
		$pages=ceil($cnt/$rpp);
		if ($page>0) { echo "<a href=\"admin.php?spell=com_runa&page=0\">«««</a> | <a href=\"admin.php?spell=com_runa&page=".($page-1)."\">««</a> |"; }
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
				echo "<a href=\"admin.php?spell=com_runa&page=$i\">";
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
		if ($pages>$links && $page<($pages-$rad-1)) { echo " ... <a href=\"admin.php?spell=com_runa&page=".($pages-1)."\">".($pages-1)."</a>"; }
		if ($page<$pages-1) { echo " | <a href=\"admin.php?spell=com_runa&page=".($page+1)."\">»»</a> | <a href=\"admin.php?spell=com_runa&page=".($pages-1)."\">»»»</a>"; }

		$limit = $rpp;
		$eu = $page*$limit;
		echo "<table border=0 class=new width=100% bgcolor=#dcdcdc cellspacing=1><TR bgcolor=#C7C7C7>
			<td><b>ЛОГИН</td><td><b>РУНА</td><td><b>IP-АДРЕСС</td><td><b>COUNT RUNA</td><td><b>PLATINA</td><td><b>ДАТА</td></tr>";

		$sql=mysql_query("SELECT * FROM com_runa ORDER BY date DESC LIMIT $eu, $limit");
		while ($res=mysql_fetch_array($sql))
		{
			echo "<tr><td nowrap><small>".$res["seller"]."</td><td><small>".$res["name"]."</td><td nowrap><small>".$res["ip"]."</td><td nowrap><small>".$res["count_runa"]."</td><td nowrap><small>".$res["platina"]."</td><td nowrap><small>".$res["date"]."</td></tr>";
		}
		mysql_free_result($sql);
		echo "</table>";
	}
	else
	{
		echo "Вам сюда нельзя!";
	}
?>
