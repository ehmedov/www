<?include("key.php");
$login=$_SESSION['login'];
$target=htmlspecialchars(addslashes($_POST['target']));
$noname=$_POST['noname'];
if(!empty($target))
{	
	$QUERY=mysql_query("SELECT * FROM users WHERE login='".$target."'");
	$data=mysql_fetch_array($QUERY);
	if($data["battle"]!=0)
    {
    	print "Персонаж <B>".$target."</B> находиться в бою!";
    	die();
    }
    setMN($target,$data['mana_all'],$data['mana_all']);    
	$pref=$db["sex"];
	if($pref=="female")
	{
		$prefix="а";
	}
	else
	{
		$prefix="";
	}
    if($noname==""){$noname_cl="Палач <b>&laquo;$login&raquo;</b>";}
    else if($noname==1){$noname_cl="<i><b>&laquo;Неизвестный&raquo;</i></b>";}
	say("toall","$noname_cl восстановил$prefix MANA персонажу <b>&laquo;".$target."&raquo</b>",$login);
	print "MANA персонажа <b>".$target."</b> успешно восстановлены!";
}
?>