<?
	/* monitoring script by bllem*/
	$la = sys_getloadavg();
?>
<h4>������� �������� �������</h4>
<?
	echo "<B>�� 1 ������:</B> ".($la[0])."% ";
	if ($la[0] <= 30) 
	{
		echo "<font color=green>������</font>";
	} 
	else if ($la[0] < 75 && $la[0] > 30) 
	{
		echo "<font color=orange>�������</font>";
	} 
	else
	{
		echo "<font color=red>�������</font>";
	}
	
	echo "<BR><B>�� 5 �����:</B> ".($la[1])."% ";
	if ($la[1] < 30) 
	{
		echo "<font color=green>������</font>";
	} 
	else if ($la[1] < 75 && $la[1] > 30) 
	{
		echo "<font color=orange>�������</font>";
	} 
	else
	{
		echo "<font color=red>�������</font>";
	}
	
	echo "<BR><B>�� 15 �����:</B> ".($la[2])."% ";
	if ($la[2] < 30) 
	{
		echo "<font color=green>������</font>";
	} 
	else if ($la[2] < 75 && $la[2] > 30) 
	{
		echo "<font color=orange>�������</font>";
	} 
	else
	{
		echo "<font color=red>�������</font>";
	}
	$up=exec("uptime");
	echo "<br>".substr($up,0,strpos($up,','));
?>
</BODY>
</HTML>