<table border="0" cellpadding="0" cellspacing="0" width=450>
	<tr>
		<td width=260 valign=top>
			<table cellspacing="0" cellpadding="0" width=100%>
		      	<tr>
		       		<td align=center>
						<?
							echo "<script>wks('".$db['login']."', '".$db['id']."', '".$db['level']."', '".$db['dealer']."', '".$db['orden']."', '".$db['admin_level']."', '".$db['clan_short']."', '".$db['clan']."','".$db['shut']."','".$db['travm']."','".time()."');</script>";
						?>
					</td>	
		      	</tr>      
				<tr>
					<td nowrap style="font-size:9px" style="position: relative;"><SPAN id="HP" style='position: absolute; left: 5; z-index: 1; font-weight: bold; color: #FFFFFF'></SPAN><img src="img/icon/grey.jpg" alt="������� �����" name="HP1" width="1" height="10" id="HP1"><img src="img/icon/grey.jpg" alt="������� �����" name="HP2" width="1" height="10" id="HP2"></td>
				</tr>
				<tr><td><span></span></td></tr>
				<?
				if($db['level']>0 && $db['mana_all']>0)
				{
				?>
				<tr>
					<td nowrap style="font-size:9px" style="position: relative;"><SPAN id="Mana" style='position: absolute; left: 5; z-index: 1; font-weight: bold; color: #FFFFFF'></SPAN><img src="img/icon/grey.jpg" alt="������� ����" name="Mana1" width="1" height="10" id="Mana1"><img src="img/icon/grey.jpg" alt="������� �����" name="Mana2" width="1" height="10" id="Mana2"></td>
				</tr>
				<tr><td><span></span></td></tr>	
				<?
				}
				?>
				</table>
				<script>top.setHP(<?echo $hp[0].",".$hp[1].",100";?>);</script>
	    		<script>top.setMana(<?echo $mana['0'].",".$mana['1'].",100";?>);</script>
				<?
					showPlayer($db);
					echo "<table cellspacing='3' border=0 cellpadding='0' width='220' align=left>";
					for ($j=0;$j<=1;$j++) 
					{
						echo "<tr>";
						for ($i=$j*6+100;$i<=$j*6+105;$i++) 
						{
						    echo "<td width=37>";showpic($db,$i,0);echo " </td>";
						}unset($i);
					  	echo "</tr>";
					}
					echo "</table>";
					unset($j);
				?>	
		</td>
		<td>&nbsp;</td>
		<td valign=top><br>
			<? 	
				echo "
					����: ".($db["sila"]+$effect["add_sila"])."<br>
					��������: ".($db["lovkost"]+$effect["add_lovkost"])."<br>
					�����: ".($db["udacha"]+$effect["add_udacha"])."<br>
					������������: ".$db["power"]."<br>";
					if ($db["level"])
					{
						echo "���������: ".($db["intellekt"]+$effect["add_intellekt"])."<br>";
						echo "����������: ".$db["vospriyatie"]."<br>";
					}
					if ($db["level"]>9 || $db["duxovnost"]>0)
					{
						echo "����������: ".$db["duxovnost"]."<br>";
					}	
					if($db["ups"])
					{
						echo "<a class=us2 href='?act=char'><small>��������� ���������� (".$db["ups"].")</small></A><br>";
				 	}
				 	if($db["umenie"])
					{
						echo "<a class=us2 href='?act=char&sl=L2'><small>��������� ������ (".$db["umenie"].")</small></A><br>";
				 	}	
				echo "<hr>
					����: <b>".number_format($db["exp"], 0, ',', ' ')."</b><br>
					���������: <a href='extable.php' target='_blank'>".number_format($db["next_up"], 0, ',', ' ')."</a><br><hr>
					�������: ".$db["level"]."<br>
					�����: <a href='top.php?act=pers' target='_blank'>".$db["win"]."</a><br>
					���������: ".$db["lose"]."<br>
					������: ".$db["nich"]."<br>
					����� ��� ���������: ".$db["monstr"]."<br>
					���������: ".$db["reputation"]."<br>
					��������: ".$db["doblest"]."<br>
					<hr>
					������: <b>".number_format($db["money"], 2, '.', ' ')."</b> ��.<br>
					�������: <b>".number_format($db["platina"], 2, '.', ' ')."</b> ��.<br>
					�������: <b>".number_format($db["naqrada"], 2, '.', ' ')."</b> ��.<br>
					�������: <b>".number_format($db["silver"], 2, '.', ' ')."</b> ��.<br>
					�������: ".(50-$db["peredacha"]);
			?></small>
		</td>
	</tr>
</table>