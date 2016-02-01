<?
$login=$_SESSION['login'];
$spell=$_GET['spell'];

switch ($mtype) 
{
	case "hp100": $hp_add = 100+ceil($db["cure"]);break;
	case "hp250": $hp_add = 250+ceil($db["cure"]);break;
	case "hp150": $hp_add = 150+ceil($db["cure"]);break;
	case "hp_full": $hp_add = 100000+ceil($db["cure"]);break;
}

if($db["battle"]!=0)
{
	say($login, "¬ы не можете кастовать это закл€тие наход€сь в бою!", $login);
}
else 
{
	$hp_now = $db["hp"];
	$hp_all = $db["hp_all"];

	if($hp_all - $hp_now==0)
	{
		$_SESSION["message"]="¬ы и так здоровы.";
	}
	else 
	{
		if($hp_all - $hp_now<$hp_add)
		{
			$hp_add = $hp_all - $hp_now;
		}
		$hp_new = $hp_now + $hp_add;
		setHP($login,$hp_new,$hp_all);
		$_SESSION["message"]="¬ы удачно прокастовали заклинание <b>&laquo;".$name."&raquo;</b> и восстановили свое здоровье на <b>$hp_add HP</b>!";
		drop($spell,$DATA);
	}
}
echo "<script>location.href='main.php?act=inv&otdel=magic'</script>";
?>
