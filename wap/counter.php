<div class="sep1"></div>
<div class="sep2"></div>
<div class="aheader">
	<?
		$indxFullURL1 = $_SERVER["SERVER_NAME"].$_SERVER["SCRIPT_NAME"];
		$pos31 = strpos($indxFullURL1, "/index.php");
		if ($pos31===false) 
		{
		 	echo '<a href="http://waplog.net/c.shtml?421307"><img src="http://c.waplog.net/421307.cnt" alt="waplog" title="waplog" border="0" /></a> ';
		 	echo '<a href="http://weplog.net/in/10083"><img src="http://weplog.net/10083/1.cnt" alt="wap сайты" title="wap сайты" border="0" /></a> ';
		}
		else 
		{
			echo '<a href="http://waplog.net/c.shtml?421306"><img src="http://c.waplog.net/421306.cnt" alt="waplog" title="waplog" border="0" /></a> ';
			echo '<a href="http://weplog.net/in/10083"><img src="http://weplog.net/10083/0.cnt" alt="wap сайты" title="wap сайты" border="0" /></a> ';
		}
	?>
</div>