<?
include("key.php");
$login=$_SESSION['login'];
$login_bot=htmlspecialchars(addslashes($_POST['login_bot']));
$level=(int)$_POST['level'];
$level_array=array();

$level_array[1]=165;
$level_array[2]=535;
$level_array[3]=1455;
$level_array[4]=2905;
$level_array[5]=6005;
$level_array[6]=14005;
$level_array[7]=60005;
$level_array[8]=400005;	
$level_array[9]=6000005;
$level_array[10]=13000005;
$level_array[11]=52000000;
$level_array[12]=120000000;
$level_array[13]=100000000000;
$level_array[14]=1000000000000;
$level_array[15]=6000000000000;
$level_array[16]=10000000000000;
if ($_POST["login_bot"])
{
		mysql_query("UPDATE users SET exp=".$level_array[$level]." WHERE login='$login_bot'");
		echo "OK";
}
?>
<form name="" action="main.php?act=inkviz&spell=level_up" method="post">
	Логин: <input name="login_bot" type="text" value=""><br>
	Левел: 
	<select name="level">
	  	<option value="1">Level 1</option>
	  	<option value="2">Level 2</option>
		<option value="3">Level 3</option>
		<option value="4">Level 4</option>
		<option value="5">Level 5</option>
		<option value="6">Level 6</option>
		<option value="7">Level 7</option>
		<option value="8">Level 8</option>
		<option value="9">Level 9</option>
		<option value="10">Level 10</option>
		<option value="11">Level 11</option>
		<option value="12">Level 12</option>
		<option value="13">Level 13</option>
		<option value="14">Level 14</option>
	</select> <input type="submit" name=go value=" Ok "></center>
</form>