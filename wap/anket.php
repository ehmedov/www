<?
include ("key.php");
include ("conf.php");
include ("align.php");
include ("functions.php");

header("Content-Type: text/html; charset=windows-1251");
header("Cache-Control: no-cache, must-revalidate"); // ������� �������� ���-�� �� �� ��������� ��� ��������
header("Pragma: no-cache");
echo '<?xml version="1.0" encoding="windows-1251"?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.2//EN" "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="en">';
$login=$_SESSION["login"];
$uin_id=$_SESSION["uin_id"];
$message="";
$data = mysql_connect($base_name, $base_user, $base_pass) or die('�� ���������� ������������. ��������� ��� �������, ��� ������������ � ������!');
mysql_select_db($db_name) or die('������ ����� � ���� ������');

$db = mysql_fetch_array(mysql_query("SELECT * FROM users LEFT JOIN info on info.id_pers=users.id WHERE login='".$login."'"));
TestBattle($db);
if($db["room"]=="house")
{
	$_SESSION["message"]="�� � ���������";
	Header("Location: main.php?tmp=".md5(time()));
	die();
}
?>
<html>
<head>
	<title>WAP.MEYDAN.AZ</title>
	<link rel="stylesheet" href="main.css" type="text/css"/>	
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
	<meta http-equiv="Content-Language" content="ru" />
	<meta name="Description" content="�������� RPG ������ ���� ����������� ���� � �����. ������ ������, �������� �������, ��� ����, ����� ���� ����� ������ � �����." />
	<meta http-equiv="cache-control" content="no-cache" />
	<meta http-equiv="pragma" content="no-cache" />
	<meta http-equiv="expires" content="0" />
</head>

<body>
<div id="cnt" class="content">
	<?
	$maxchars=2048;
	$name=($_POST['saveanketa']?$_POST['name']:$db["name"]);
	$icq=($_POST['saveanketa']?$_POST['icq']:$db["icq"]);
	$deviz=($_POST['saveanketa']?$_POST['deviz']:$db["deviz"]);
	$hobie=($_POST['saveanketa']?$_POST['hobie']:$db["hobie"]);
	$color=($_POST['saveanketa']?$_POST['color']:$db["color"]);
	$town=($_REQUEST['saveanketa']?$_POST['town']:$db["town"]);
	
	$name=HtmlSpecialChars($name);
	$icq=HtmlSpecialChars($icq);
	$deviz=HtmlSpecialChars($deviz);
	$hobie=HtmlSpecialChars($hobie);
	$color=HtmlSpecialChars($color);
	$town=HtmlSpecialChars($town);
	$hobie=str_replace("&amp;","&",$hobie);
	$hobie=str_replace("&amp;","&",$hobie);
	
	$deviz=str_replace("&amp;","&",$deviz);
	$deviz=str_replace("&amp;","&",$deviz);
	
	$hobie=str_replace("<br>","\n",$hobie);
	$hobie=str_replace("<br/>","\n",$hobie);

	if ($_POST['saveanketa']) 
	{
		$okname=true;
		$en=preg_match("/^(([a-zA-Z0-9 -])+)$/i", $name);
		$ru=preg_match("/^(([�-��-�0-9 -])+)$/i", $name);
		if ((($en && $ru) or (!$en && !$ru)) && ($name)){$message="�������� ���";$okname=false;}
		if (!$name) {$message="�� ������ ���";$okname=false;}
		
		$en=preg_match("/^(([a-zA-Z0-9 -])+)$/i", $town);
		$ru=preg_match("/^(([�-��-�0-9 -])+)$/i", $town);
		if ((($en && $ru) || (!$en && !$ru)) && ($town)) {$message="�������� �������� ������";$okname=false;}
		if (!$town) {$message="�� ������ �����";$okname=false;}
		
		if (!preg_match("/^(([0-9-])+)$/i", $icq) && $icq) {$message="�������� ���� ICQ";$okname=false;}
		if (!preg_match("/^(([a-zA-Z0-9#])+)$/i", $color)) {$message="�������� ���� ���� � ����";$okname=false;}
		if ($okname) 
		{
			mysql_query("UPDATE users SET color='".addslashes($color)."' WHERE login='".$login."'");
			mysql_query("UPDATE info SET name='".addslashes($name)."', town='".$town."', icq='".addslashes($icq)."', hobie='".addslashes(substr($hobie,0,$maxchars))."', deviz='".addslashes($deviz)."' WHERE id_pers='".$db["id"]."'");
			$message="��������� ��������� ������...";
		}
	}
	?>
		<div class="aheader">
			<b>�������������� ������</b><br/>
			<font color='#ff0000'><?=$message;?></font>
		</div>
		<form method="post">
			<div>
			<b>���� �������� ���:</b> <input name="name" value="<?=$name;?>" class="inup" size="20" maxlength="90" /><br/>
			<b>���� ��������:</b> <? echo $db['birth']; ?><br/>
			<b>�����:</b> <input name="town" value="<?=$town;?>" class="inup" size="20" maxlength="90" /><br/>
     		<b>ICQ:</b> <input value="<?=$icq;?>" name="icq" class="inup" size="20" maxlength="25" /><br/>
			<b>�����:</b> <input value="<?=$deviz;?>" name="deviz" class="inup" size="20" maxlength="160" /><br/><br/>
			<b>�������������� ����������</b> <small><? echo '(����������� '.$maxchars.' ��������)'; ?> </small><br/>
			<textarea name="hobie" class="inup" cols="40" rows="6"><?echo str_replace("<br>","\n",substr($hobie,0,$maxchars)); ?></textarea><br/>
			<b>���� ��������� � ����:</b><br/>
				<select name="color" class="inup" style="BACKGROUND: #f2f0f0;">
					<option style="color: black" <?echo ($color=="Black"?"selected":"");?> value="Black">Black</option>
					<option style="color: blue" <?echo ($color=="Blue"?"selected":"");?> value="Blue">Blue</option>
					<option style="color: fuchsia" <?echo ($color=="Fuchsia"?"selected":"");?> value="Fuchsia">Fuchsia</option>
					<option style="color: gray" <?echo ($color=="Gray"?"selected":"");?> value="Gray">Grey</option>
					<option style="color: green" <?echo ($color=="Green"?"selected":"");?> value="Green">Green</option>
					<option style="color: maroon" <?echo ($color=="Maroon"?"selected":"");?> value="Maroon">Maroon</option>
					<option style="color: navy" <?echo ($color=="Navy"?"selected":"");?> value="Navy">Navy</option>
					<option style="color: olive" <?echo ($color=="Olive"?"selected":"");?> value="Olive">Olive</option>
					<option style="color: purple" <?echo ($color=="Purple"?"selected":"");?> value="Purple">Purple</option>
					<option style="color: teal" <?echo ($color=="Teal"?"selected":"");?> value="Teal">Teal</option>
					<option style="color: chocolate" <?echo ($color=="Chocolate"?"selected":"");?> value="Chocolate">Chocolate</option>
		        </select>
		    </div>
		    <br/><br/>
			<div class="aheader"><input name="saveanketa" type="submit" class="inup" value="��������� ���������" /></div><br/>
	  </form>
		
		<?
			mysql_close();
		?>
	<?include("bottom.php");?>
</div>