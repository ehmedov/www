<?
	$priem=htmlspecialchars(addslashes($_GET['special']));
	if($db["battle_team"] == 1){$span = "p1";}else{$span = "p2";}

	$priems=mysql_fetch_array(mysql_query("SELECT * FROM battle_units WHERE player='".$login."' and battle_id='".$bid."'"));
	$is_pr=mysql_fetch_Array(mysql_query("SELECT * FROM person_on LEFT JOIN priem ON priem.type=pr_name WHERE pr_name = '".$priem."' and id_person=".$db["id"]." and battle_id='".$bid."'"));
	if ($is_pr)
	{
		$enable=true;
		$can_use=checkbattlehars((int)$is_pr["hit"],(int)$is_pr["krit"],(int)$is_pr["block"],(int)$is_pr["uvarot"],(int)$is_pr["hp"],(int)$is_pr["all_hit"],(int)$is_pr["parry"],(int)$priems["hit"],(int)$priems["krit"],(int)$priems["block"],(int)$priems["uvarot"],(int)$priems["hp"],(int)$priems["counter"],(int)$priems["parry"]) ;
		if ($can_use)
		{	
			if ($is_pr["pr_cur_uses"]>0)
			{
				if ($is_pr["pr_wait_for"]) 
				{
					if ($is_pr['pr_wait_for']>0) 
					{
						$enable=false;echo "<b style='color:#ff0000'>Нельзя использовать: еще идет задержка </b>";
					}
					if ($is_pr['pr_active']!=1 && $is_pr["pr_cur_uses"]<=1) {$enable=false;echo "<b style='color:#ff0000'>Нельзя использовать: уже активен</b>";}
				}
				else
				{
					if ($is_pr['pr_active']!=1 && $is_pr["pr_cur_uses"]<=1) {$enable=false;echo "<b style='color:#ff0000'>Нельзя использовать: уже активен</b>";}
				}
			}
			else
			{
				$enable=false;echo "<b style='color:#ff0000'>Использовать прием можно 1 раз за бой.</b>";
			}
		}
		else 
		{
			$enable=false;
			echo "<b style='color:#ff0000'>Нельзя использовать: не хватает требований</b>";
		}
		
		if ($enable)
		{
			if ($is_pr["mag"]==1)
			{
				if ($db["bs"]==1)
				{
					 echo "<b style='color:#ff0000'>Запрещено использовать приемы мага в турнире</b>";
				}
				else
				{	
					if ($is_pr["mana"]<=$db["mana"])
					{
						if ($db['hp']>0)
						{	
							$mana_new = $db["mana"] - $is_pr["mana"];
							$mana_all = $db["mana_all"];
							setMN($login,$mana_new,$mana_all);
							include("inc/battle/calc_m.php");
							include("inc/battle/priem/".$is_pr["files"].".php");
							mysql_query("UPDATE users SET battle_opponent='' WHERE login='".$db["login"]."'");
							Header("Location: battle.php?tmp=$random");
						}
					}
					else echo "<b style='color:#ff0000'>У Вас недостаточно Маны [мин.".$is_pr["mana"]."MN]</b>";
				}
			}	
			else if ($priem=="heal" && $db['hp']>0)
			{
				if ($db['hp']>0)
				{
					$hp_add=$db["level"]*25;
					$new_hp=$db["hp"]+$hp_add;
					if ($new_hp>$db["hp_all"]) 
					{
						$new_hp=$db["hp_all"];
						$hp_add=$db["hp_all"]-$db["hp"];
					}	
					setHP($login,$new_hp,$db['hp_all']);
					$db["hp"]=$new_hp;
					$phrase_priem  = "<span class=date>$date</span> <span class=$span>$login</span> понял что его спасение это прием <b>Воля к победе. <font color=green>+$hp_add</font></b> [".$new_hp."/".$db['hp_all']."]<br> ";
					battle_log($bid, $phrase_priem);
					mysql_query("UPDATE  battle_units SET hit=hit-".(int)$is_pr["hit"].",krit=krit-".(int)$is_pr["krit"].",uvarot=uvarot-".(int)$is_pr["uvarot"].",block=block-".(int)$is_pr["block"].",hp=hp-".(int)$is_pr["hp"].",counter=counter-".(int)$is_pr["all_hit"]." WHERE player='".$login."' and battle_id='".$bid."'");
				}
			}
			else if ($priem=="voskr")
			{
				if($db['hp']<=0)
				{
					setHP($login,$db['hp_all'],$db['hp_all']);
					$db["hp"]=$db['hp_all'];
					$phrase_priem  = "<span class=date>$date</span> <span class=$span>$login</span> понял что его спасение это прием <b>Воскрешение.</b><br> ";
					battle_log($bid, $phrase_priem);
					mysql_query("UPDATE  battle_units SET hit=hit-".(int)$is_pr["hit"].",krit=krit-".(int)$is_pr["krit"].",uvarot=uvarot-".(int)$is_pr["uvarot"].",block=block-".(int)$is_pr["block"].",hp=hp-".(int)$is_pr["hp"].",counter=counter-".(int)$is_pr["all_hit"]." WHERE player='".$login."' and battle_id='".$bid."'");
				}
			}
			else if ($priem=="sobrat")
			{
				if ($db['hp']>0)
				{
					$hp_add=rand(10,20);
					$new_hp=$db["hp"]+$hp_add;
					if ($new_hp>$db["hp_all"]) 
					{
						$new_hp=$db["hp_all"];
						$hp_add=$db["hp_all"]-$db["hp"];
					}	
					setHP($login,$new_hp,$db['hp_all']);
					$db["hp"]=$new_hp;
					$phrase_priem  = "<span class=date>$date</span> <span class=$span>$login</span> понял что его спасение это прием <b>Собрать Зубы. <font color=green>+$hp_add</font></b> [".$new_hp."/".$db['hp_all']."]<br> ";
					battle_log($bid, $phrase_priem);
					mysql_query("UPDATE person_on SET pr_active=1,pr_wait_for=".(int)$is_pr["wait"]." WHERE id_person='".$db["id"]."' and pr_name='".$priem."' and battle_id='".$bid."'");
					mysql_query("UPDATE  battle_units SET hit=hit-".(int)$is_pr["hit"].",krit=krit-".(int)$is_pr["krit"].",uvarot=uvarot-".(int)$is_pr["uvarot"].",block=block-".(int)$is_pr["block"].",hp=hp-".(int)$is_pr["hp"].",counter=counter-".(int)$is_pr["all_hit"]." WHERE player='".$login."' and battle_id='".$bid."'");
				}
			}
			else if ($priem=="circleshield")
			{
				if ($db["hp"]>$db["hp_all"]*0.3 && $db['hp']>0)
				{
					$hp_remove=ceil($db["hp"]*0.1);
					$new_hp=$db["hp"]-$hp_remove;
					setHP($login,$new_hp,$db['hp_all']);
					$db["hp"]=$new_hp;
					$phrase_priem  = "<span class=date>$date</span> <span class=$span>$login</span> понял что его спасение это прием <b>Рывок</b>.<br> ";
					battle_log($bid, $phrase_priem);
					mysql_query("UPDATE person_on SET pr_active=1,pr_wait_for=".(int)$is_pr["wait"]." WHERE id_person='".$db["id"]."' and pr_name='".$priem."' and battle_id='".$bid."'");
					mysql_query("UPDATE battle_units SET hit=hit+3,block=block-".(int)$is_pr["block"]." WHERE player='".$login."' and battle_id='".$bid."'");
				}
			}
			else if ($priem=="heal_mn")
			{
				if ($db['hp']>0)
				{
					$mn_add=round($db["level"]*25);
					$new_mn=$db["mana"]+$mn_add;
					if ($new_mn>$db["mana_all"]) 
					{
						$new_mn=$db["mana_all"];
						$mn_add=$db["mana_all"]-$db["mana"];
					}	
					setMN($login,$new_mn,$db['mana_all']);
					$phrase_priem  = "<span class=date>$date</span> <span class=$span>$login</span> понял что его спасение это прием <b>Восстановление Маны. <font color=blue>+$mn_add</font></b> [".$new_mn."/".$db['mana_all']."]<br> ";
					battle_log($bid, $phrase_priem);
					mysql_query("UPDATE person_on SET pr_active=1,pr_wait_for=".(int)$is_pr["wait"]." WHERE id_person='".$db["id"]."' and pr_name='".$priem."' and battle_id='".$bid."'");
					mysql_query("UPDATE  battle_units SET hit=hit-".(int)$is_pr["hit"].",krit=krit-".(int)$is_pr["krit"].",uvarot=uvarot-".(int)$is_pr["uvarot"].",block=block-".(int)$is_pr["block"].",hp=hp-".(int)$is_pr["hp"].",counter=counter-".(int)$is_pr["all_hit"]." WHERE player='".$login."' and battle_id='".$bid."'");
				}
			}
			else if ($priem=="hp_regen")
			{
				if ($db['hp']>0)
				{
					$hp_add=$db["level"]*rand(2,5);
					$new_hp=$db["hp"]+$hp_add;
					if ($new_hp>$db["hp_all"]) 
					{
						$new_hp=$db["hp_all"];
						$hp_add=$db["hp_all"]-$db["hp"];
					}	
					setHP($login,$new_hp,$db['hp_all']);
					$db["hp"]=$new_hp;	
					$phrase_priem  = "<span class=date>$date</span> <span class=$span>$login</span> понял что его спасение это прием <b>Утереть пот. <font color=green>+$hp_add</font></b> [".$new_hp."/".$db['hp_all']."]<br> ";
					battle_log($bid, $phrase_priem);
					mysql_query("UPDATE person_on SET pr_active=1 WHERE id_person='".$db["id"]."' and pr_name='".$priem."' and battle_id='".$bid."'");
					mysql_query("UPDATE battle_units SET hit=hit-".(int)$is_pr["hit"].",krit=krit-".(int)$is_pr["krit"].",uvarot=uvarot-".(int)$is_pr["uvarot"].",block=block-".(int)$is_pr["block"].",hp=hp-".(int)$is_pr["hp"].",counter=counter-".(int)$is_pr["all_hit"]." WHERE player='".$login."' and battle_id='".$bid."'");
				}
			}
			else if ($priem=="restore")
			{
				if ($db['hp']>0)
				{
					if ($db["hand_l_type"]=="shield")
					{	
						$phrase_priem  = "<span class=date>$date</span> <span class=$span>$login</span> понял что его спасение это прием <b>Глухая Защита</b>.<br> ";
						battle_log($bid, $phrase_priem);
						mysql_query("UPDATE person_on SET pr_active=2,pr_wait_for=12,pr_cur_uses=6 WHERE id_person='".$db["id"]."' and pr_name='".$priem."' and battle_id='".$bid."'");
						mysql_query("UPDATE battle_units SET hit=hit-".(int)$is_pr["hit"].",krit=krit-".(int)$is_pr["krit"].",uvarot=uvarot-".(int)$is_pr["uvarot"].",block=block-".(int)$is_pr["block"].",hp=hp-".(int)$is_pr["hp"].",counter=counter-".(int)$is_pr["all_hit"]." WHERE player='".$login."' and battle_id='".$bid."'");
					}
					else echo "<b style='color:#ff0000'>Требует наличие щита</b>";
				}
			}
			else if ($priem=="protdrob")
			{
				if ($db['hp']>0)
				{
					$if_use=mysql_fetch_array(mysql_query("SELECT pr_active FROM person_on WHERE id_person='".$db["id"]."' and pr_name='".$priem."' and battle_id='".$bid."'"));
					if ($if_use['pr_active']==1)
					{
						$phrase_priem  = "<span class=date>$date</span> <span class=$span>$login</span> понял что его спасение это прием <b>Призрачный Молот</b>.<br> ";
						battle_log($bid, $phrase_priem);
						mysql_query("UPDATE person_on SET pr_active=2,pr_wait_for=5,pr_cur_uses=4 WHERE id_person='".$db["id"]."' and pr_name='".$priem."' and battle_id='".$bid."'");
						mysql_query("UPDATE battle_units SET hit=hit-".(int)$is_pr["hit"].",krit=krit-".(int)$is_pr["krit"].",uvarot=uvarot-".(int)$is_pr["uvarot"].",block=block-".(int)$is_pr["block"].",hp=hp-".(int)$is_pr["hp"].",counter=counter-".(int)$is_pr["all_hit"]." WHERE player='".$login."' and battle_id='".$bid."'");
					}
				}
			}
			else if ($priem=="protkol")
			{
				if ($db['hp']>0)
				{
					$if_use=mysql_fetch_array(mysql_query("SELECT pr_active FROM person_on WHERE id_person='".$db["id"]."' and pr_name='".$priem."' and battle_id='".$bid."'"));
					if ($if_use['pr_active']==1)
					{
						$phrase_priem  = "<span class=date>$date</span> <span class=$span>$login</span> понял что его спасение это прием <b>Призрачный Кинжал</b>.<br> ";
						battle_log($bid, $phrase_priem);
						mysql_query("UPDATE person_on SET pr_active=2,pr_wait_for=5,pr_cur_uses=4 WHERE id_person='".$db["id"]."' and pr_name='".$priem."' and battle_id='".$bid."'");
						mysql_query("UPDATE battle_units SET hit=hit-".(int)$is_pr["hit"].",krit=krit-".(int)$is_pr["krit"].",uvarot=uvarot-".(int)$is_pr["uvarot"].",block=block-".(int)$is_pr["block"].",hp=hp-".(int)$is_pr["hp"].",counter=counter-".(int)$is_pr["all_hit"]." WHERE player='".$login."' and battle_id='".$bid."'");
					}
				}
			}
			else if ($priem=="protrej")
			{
				if ($db['hp']>0)
				{
					$if_use=mysql_fetch_array(mysql_query("SELECT pr_active FROM person_on WHERE id_person='".$db["id"]."' and pr_name='".$priem."' and battle_id='".$bid."'"));
					if ($if_use['pr_active']==1)
					{
						$phrase_priem  = "<span class=date>$date</span> <span class=$span>$login</span> понял что его спасение это прием <b>Призрачный Меч</b>.<br> ";
						battle_log($bid, $phrase_priem);
						mysql_query("UPDATE person_on SET pr_active=2,pr_wait_for=5,pr_cur_uses=4 WHERE id_person='".$db["id"]."' and pr_name='".$priem."' and battle_id='".$bid."'");
						mysql_query("UPDATE battle_units SET hit=hit-".(int)$is_pr["hit"].",krit=krit-".(int)$is_pr["krit"].",uvarot=uvarot-".(int)$is_pr["uvarot"].",block=block-".(int)$is_pr["block"].",hp=hp-".(int)$is_pr["hp"].",counter=counter-".(int)$is_pr["all_hit"]." WHERE player='".$login."' and battle_id='".$bid."'");
					}
				}
			}
			else if ($priem=="protrub")
			{
				if ($db['hp']>0)
				{
					$if_use=mysql_fetch_array(mysql_query("SELECT pr_active FROM person_on WHERE id_person='".$db["id"]."' and pr_name='".$priem."' and battle_id='".$bid."'"));
					if ($if_use['pr_active']==1)
					{
						$phrase_priem  = "<span class=date>$date</span> <span class=$span>$login</span> понял что его спасение это прием <b>Призрачный Топор</b>.<br> ";
						battle_log($bid, $phrase_priem);
						mysql_query("UPDATE person_on SET pr_active=2,pr_wait_for=5,pr_cur_uses=4 WHERE id_person='".$db["id"]."' and pr_name='".$priem."' and battle_id='".$bid."'");
						mysql_query("UPDATE battle_units SET hit=hit-".(int)$is_pr["hit"].",krit=krit-".(int)$is_pr["krit"].",uvarot=uvarot-".(int)$is_pr["uvarot"].",block=block-".(int)$is_pr["block"].",hp=hp-".(int)$is_pr["hp"].",counter=counter-".(int)$is_pr["all_hit"]." WHERE player='".$login."' and battle_id='".$bid."'");
					}
				}
			}
			else if ($priem=="protair")
			{
				if ($db['hp']>0)
				{
					$if_use=mysql_fetch_array(mysql_query("SELECT pr_active FROM person_on WHERE id_person='".$db["id"]."' and pr_name='".$priem."' and battle_id='".$bid."'"));
					if ($if_use['pr_active']==1)
					{
						$phrase_priem  = "<span class=date>$date</span> <span class=$span>$login</span> понял что его спасение это прием <b>Призрачный Воздух</b>.<br> ";
						battle_log($bid, $phrase_priem);
						mysql_query("UPDATE person_on SET pr_active=2,pr_wait_for=5,pr_cur_uses=4 WHERE id_person='".$db["id"]."' and pr_name='".$priem."' and battle_id='".$bid."'");
						mysql_query("UPDATE battle_units SET hit=hit-".(int)$is_pr["hit"].",krit=krit-".(int)$is_pr["krit"].",uvarot=uvarot-".(int)$is_pr["uvarot"].",block=block-".(int)$is_pr["block"].",hp=hp-".(int)$is_pr["hp"].",counter=counter-".(int)$is_pr["all_hit"]." WHERE player='".$login."' and battle_id='".$bid."'");
					}
				}
			}
			else if ($priem=="protearth")
			{
				if ($db['hp']>0)
				{
					$if_use=mysql_fetch_array(mysql_query("SELECT pr_active FROM person_on WHERE id_person='".$db["id"]."' and pr_name='".$priem."' and battle_id='".$bid."'"));
					if ($if_use['pr_active']==1)
					{
						$phrase_priem  = "<span class=date>$date</span> <span class=$span>$login</span> понял что его спасение это прием <b>Призрачная Земля</b>.<br> ";
						battle_log($bid, $phrase_priem);
						mysql_query("UPDATE person_on SET pr_active=2,pr_wait_for=5,pr_cur_uses=4 WHERE id_person='".$db["id"]."' and pr_name='".$priem."' and battle_id='".$bid."'");
						mysql_query("UPDATE battle_units SET hit=hit-".(int)$is_pr["hit"].",krit=krit-".(int)$is_pr["krit"].",uvarot=uvarot-".(int)$is_pr["uvarot"].",block=block-".(int)$is_pr["block"].",hp=hp-".(int)$is_pr["hp"].",counter=counter-".(int)$is_pr["all_hit"]." WHERE player='".$login."' and battle_id='".$bid."'");
					}
				}
			}
			else if ($priem=="protfire")
			{
				if ($db['hp']>0)
				{
					$if_use=mysql_fetch_array(mysql_query("SELECT pr_active FROM person_on WHERE id_person='".$db["id"]."' and pr_name='".$priem."' and battle_id='".$bid."'"));
					if ($if_use['pr_active']==1)
					{
						$phrase_priem  = "<span class=date>$date</span> <span class=$span>$login</span> понял что его спасение это прием <b>Призрачный Огонь</b>.<br> ";
						battle_log($bid, $phrase_priem);
						mysql_query("UPDATE person_on SET pr_active=2,pr_wait_for=5,pr_cur_uses=4 WHERE id_person='".$db["id"]."' and pr_name='".$priem."' and battle_id='".$bid."'");
						mysql_query("UPDATE battle_units SET hit=hit-".(int)$is_pr["hit"].",krit=krit-".(int)$is_pr["krit"].",uvarot=uvarot-".(int)$is_pr["uvarot"].",block=block-".(int)$is_pr["block"].",hp=hp-".(int)$is_pr["hp"].",counter=counter-".(int)$is_pr["all_hit"]." WHERE player='".$login."' and battle_id='".$bid."'");
					}
				}
			}
			else if ($priem=="protwatter")
			{
				if ($db['hp']>0)
				{
					$if_use=mysql_fetch_array(mysql_query("SELECT pr_active FROM person_on WHERE id_person='".$db["id"]."' and pr_name='".$priem."' and battle_id='".$bid."'"));
					if ($if_use['pr_active']==1)
					{
						$phrase_priem  = "<span class=date>$date</span> <span class=$span>$login</span> понял что его спасение это прием <b>Призрачная Вода</b>.<br> ";
						battle_log($bid, $phrase_priem);
						mysql_query("UPDATE person_on SET pr_active=2,pr_wait_for=5,pr_cur_uses=4 WHERE id_person='".$db["id"]."' and pr_name='".$priem."' and battle_id='".$bid."'");
						mysql_query("UPDATE battle_units SET hit=hit-".(int)$is_pr["hit"].",krit=krit-".(int)$is_pr["krit"].",uvarot=uvarot-".(int)$is_pr["uvarot"].",block=block-".(int)$is_pr["block"].",hp=hp-".(int)$is_pr["hp"].",counter=counter-".(int)$is_pr["all_hit"]." WHERE player='".$login."' and battle_id='".$bid."'");
					}
				}
			}
			else if ($priem=="yarost")
			{
				if ($db['hp']>0)
				{
					$if_use=mysql_fetch_array(mysql_query("SELECT pr_cur_uses FROM person_on WHERE id_person='".$db["id"]."' and pr_name='".$priem."' and battle_id='".$bid."'"));
					if ($if_use[0]<4)
					{	
						$phrase_priem  = "<span class=date>$date</span> <span class=$span>$login</span> понял что его спасение это прием <b>Ярость[".($if_use[0])."]</b> (Мф. урон+".($if_use[0]*5)."%, Мф. магический урон+".($if_use[0]*5)."%).<br> ";
						battle_log($bid, $phrase_priem);
						mysql_query("UPDATE person_on SET pr_active=2,pr_cur_uses=pr_cur_uses+1 WHERE id_person='".$db["id"]."' and pr_name='".$priem."' and battle_id='".$bid."'");
						mysql_query("UPDATE battle_units SET hit=hit-".(int)$is_pr["hit"].",krit=krit-".(int)$is_pr["krit"].",uvarot=uvarot-".(int)$is_pr["uvarot"].",block=block-".(int)$is_pr["block"].",hp=hp-".(int)$is_pr["hp"].",counter=counter-".(int)$is_pr["all_hit"]." WHERE player='".$login."' and battle_id='".$bid."'");
					}
				}
			}
			else if ($priem=="stoykost")
			{
				if ($db['hp']>0)
				{
					$if_use=mysql_fetch_array(mysql_query("SELECT pr_cur_uses FROM person_on WHERE id_person='".$db["id"]."' and pr_name='".$priem."' and '".$bid."'"));
					if ($if_use[0]<4)
					{
						$phrase_priem  = "<span class=date>$date</span> <span class=$span>$login</span> понял что его спасение это прием <b>Стойкость[".($if_use[0])."]</b> (Мф. защита от урона+".($if_use[0]*5)."%).<br> ";
						battle_log($bid, $phrase_priem);
						mysql_query("UPDATE person_on SET pr_active=2,pr_cur_uses=pr_cur_uses+1 WHERE id_person='".$db["id"]."' and pr_name='".$priem."' and battle_id='".$bid."'");
						mysql_query("UPDATE battle_units SET hit=hit-".(int)$is_pr["hit"].",krit=krit-".(int)$is_pr["krit"].",uvarot=uvarot-".(int)$is_pr["uvarot"].",block=block-".(int)$is_pr["block"].",hp=hp-".(int)$is_pr["hp"].",counter=counter-".(int)$is_pr["all_hit"]." WHERE player='".$login."' and battle_id='".$bid."'");
					}
				}
			}
			else if ($priem=="supreme")
			{
				if ($db['hp']>0)
				{
					$if_use=mysql_fetch_array(mysql_query("SELECT pr_cur_uses FROM person_on WHERE id_person='".$db["id"]."' and pr_name='".$priem."' and '".$bid."'"));
					if ($if_use[0]<4)
					{
						$phrase_priem  = "<span class=date>$date</span> <span class=$span>$login</span> понял что его спасение это прием <b>Превосходство[".($if_use[0])."]</b> (Мф. антикрит+".($if_use[0]*5)."%, Мф. антиуворот+".($if_use[0]*5)."%).<br> ";
						battle_log($bid, $phrase_priem);
						mysql_query("UPDATE person_on SET pr_active=2,pr_cur_uses=pr_cur_uses+1 WHERE id_person='".$db["id"]."' and pr_name='".$priem."' and battle_id='".$bid."'");
						mysql_query("UPDATE battle_units SET hit=hit-".(int)$is_pr["hit"].",krit=krit-".(int)$is_pr["krit"].",uvarot=uvarot-".(int)$is_pr["uvarot"].",block=block-".(int)$is_pr["block"].",hp=hp-".(int)$is_pr["hp"].",counter=counter-".(int)$is_pr["all_hit"].",parry=parry-".(int)$is_pr["parry"]." WHERE player='".$login."' and battle_id='".$bid."'");
					}
				}
			}
			else if ($priem=="survive")
			{
				if ($db['hp']>0)
				{
					$faiz=$priems["counter"]*0.005+$priems["hit"]*0.01+$priems["krit"]*0.01+$priems["uvarot"]*0.01+$priems["block"]*0.01+$priems["parry"]*0.01;
					$hp_add=$db["hp_all"]*$faiz;
					if ($hp_add>$db["hp_all"]*0.25)	$hp_add=$db["hp_all"]*0.25;
					$hp_add=ceil($hp_add);
					$new_hp=$db["hp"]+$hp_add;
					if ($new_hp>$db["hp_all"]) 
					{
						$new_hp=$db["hp_all"];
						$hp_add=$db["hp_all"]-$db["hp"];
					}	
					setHP($login,$new_hp,$db['hp_all']);
					$db["hp"]=$new_hp;	
					$phrase_priem  = "<span class=date>$date</span> <span class=$span>$login</span> понял что его спасение это прием <b>Выжить.<font color=green>+$hp_add</font></b> [".$new_hp."/".$db['hp_all']."]<br> ";
					battle_log($bid, $phrase_priem);
					mysql_query("UPDATE person_on SET pr_active=1,pr_wait_for=".(int)$is_pr["wait"]." WHERE id_person='".$db["id"]."' and pr_name='".$priem."' and '".$bid."'");
					mysql_query("UPDATE battle_units SET hit=0,krit=0,uvarot=0,block=0,parry=0,hp=hp-".(int)$is_pr["hp"].",counter=counter-".(int)$is_pr["all_hit"]." WHERE player='".$login."' and battle_id='".$bid."'");
				}
			}
			else if ($priem=="auto_hit")
			{
				if ($db['hp']>0 && $opponent)
				{
					$is_bot=mysql_num_rows(mysql_query("SELECT * FROM bot_temp WHERE battle_id='".$bid."' and bot_name='".$opponent."' limit 1"));
					if ($is_bot>0)
					{
						hit_dis($login,$opponent,"01",0,rand(1,5),0,0,0,$bid);
					}	
					else
					{	
						hit_dis($login,$opponent,"00",0,rand(1,5),0,0,0,$bid);
					}
					$opponent=getNextEnemy($login,$enemy_team,$creator,$bid);
					$phrase_priem  = "<span class=date>$date</span> <span class=$span>$login</span> понял что его спасение это прием <b>Подлый удар</b>.<br> ";
					battle_log($bid, $phrase_priem);
					mysql_query("UPDATE person_on SET pr_active=1,pr_wait_for=".(int)$is_pr["wait"]." WHERE id_person='".$db["id"]."' and pr_name='".$priem."' and battle_id='".$bid."'");
					mysql_query("UPDATE  battle_units SET hit=hit-".(int)$is_pr["hit"].",krit=krit-".(int)$is_pr["krit"].",uvarot=uvarot-".(int)$is_pr["uvarot"].",block=block-".(int)$is_pr["block"].",hp=hp-".(int)$is_pr["hp"].",counter=counter-".(int)$is_pr["all_hit"]." WHERE player='".$login."' and battle_id='".$bid."'");
				}
			}
			else if ($priem=="hitshock")
			{
				if ($db['hp']>0)
				{
					$select_target=$opponent;
					$q=mysql_query("SELECT * FROM users WHERE login='".$select_target."' and battle=".$bid." and battle_team=".$enemy_team);
					$res=mysql_fetch_array($q);
					if ($res)
					{
						mysql_query("UPDATE person_on SET pr_wait_for=pr_wait_for+2 WHERE id_person='".$res["id"]."' and battle_id='".$bid."' and pr_active=1");
						$phrase_priem  = "<span class=date>$date</span> <span class=$span>$login</span> сам не поняв зачем, применил прием <b>".$is_pr["name"]."</b> на персонажа <b>".$res["login"]."</b>.<br> ";
						battle_log($bid, $phrase_priem);
						mysql_query("UPDATE person_on SET pr_active=1,pr_wait_for=".(int)$is_pr["wait"]." WHERE id_person='".$db["id"]."' and pr_name='".$priem."' and battle_id='".$bid."'");
						mysql_query("UPDATE  battle_units SET hit=hit-".(int)$is_pr["hit"].",krit=krit-".(int)$is_pr["krit"].",uvarot=uvarot-".(int)$is_pr["uvarot"].",block=block-".(int)$is_pr["block"].",hp=hp-".(int)$is_pr["hp"].",counter=counter-".(int)$is_pr["all_hit"]." WHERE player='".$login."' and battle_id='".$bid."'");
					}
				}
			}
			else
			{
				if ($db['hp']>0)
				{
					mysql_query("UPDATE person_on SET pr_active=2,pr_wait_for=".(int)$is_pr["wait"]." WHERE id_person='".$db["id"]."' and pr_name='".$priem."' and battle_id='".$bid."'");
					mysql_query("UPDATE  battle_units SET hit=hit-".(int)$is_pr["hit"].",krit=krit-".(int)$is_pr["krit"].",uvarot=uvarot-".(int)$is_pr["uvarot"].",block=block-".(int)$is_pr["block"].",hp=hp-".(int)$is_pr["hp"].",parry=parry-".(int)$is_pr["parry"].",counter=counter-".(int)$is_pr["all_hit"]." WHERE player='".$login."' and battle_id='".$bid."'");
				}
			}
		}
	}
	else
	{
		echo "<b style='color:#ff0000'>Нет такого приема на персонаже</b>";
	}
?>