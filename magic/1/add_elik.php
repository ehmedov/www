<?
include ("key.php");

$name=$_POST["name"];
$img=$_POST["img"];
$mass=$_POST["mass"];
$price=$_POST["price"];
$min_level=$_POST["min_level"];
$type=$_POST["type"];
$count_mag=$_POST["count_mag"];
$need_orden=$_POST["need_orden"];
$desc=$_POST["desc"];
$files=$_POST["files"];
$min_intellekt=$_POST["min_intellekt"];
$min_vospriyatie=$_POST["min_vospriyatie"];
$art=$_POST["art"];
$otdel=$_POST["otdel"];
$iznos_max=$_POST["iznos_max"];
$ztype=$_POST["ztype"];
$add_energy=$_POST["add_energy"];
$to_book=$_POST["to_book"];
$mana=$_POST["mana"];
$del_time=$_POST["del_time"];
$mtype=$_POST["mtype"];


if(!empty($name))
{
	$w0="INSERT INTO scroll(name,img,mass,price,min_level,type,iznos_max,mountown,orden,descs,files,min_intellekt,min_vospriyatie,art,otdel,add_energy,ztype,to_book,mana,del_time,mtype) 
	VALUES ('$name','$img','$mass','$price','$min_level','$type','$iznos_max','$count_mag','$need_orden','$desc','$files','$min_intellekt','$min_vospriyatie',$art,'$otdel','$add_energy','$ztype','$to_book','$mana','$del_time','$mtype')";
	$res=mysql_query($w0);
	if($res)
	{
		echo "���� <font color=red><b>$name</font></b> ���-��� <b>$count_mag</b> �����������<br>";
	}
	else
	{
		echo "failed<br>";
		echo mysql_error();
	}
}
else
{
?>
<form name='action' action='main.php?act=inkviz&spell=add_elik' method='post'>
<table border=0 width=500>
<tr>
<td>
<font color=RED><b>��������: </b></font>
</td>
<td>
<input type=text name=name class=new size=30>
</td>
</tr>
<tr>
<td>
<font color=RED><b>���� � �������: </b></font
</td>
<td>
<input type=text name=img class=new size=30>
</td>
</tr>
<tr>
	<td>
	<font color=RED><b>Magic Type: </b></font
	</td>
	<td>
	<input type=text name=mtype class=new size=30>
	</td>
</tr>	
<tr>
<td>
<font color=RED><b>�����:</b><font>
</td>
<td>
<input type=text name=mass class=new size=30>
</td>
</tr>
<tr>
<td>
<font color=RED><b>�����: </b><font>
</td>
<td>
<input type=text name=iznos_max class=new size=30>
</td>
</tr>	
<tr>
<td>
<font color=RED><b>����: </b></font>
</td>
<td>
<input type=text name=price class=new size=30>
</td>
</tr>

<tr>
<td>
���. �������:
</td>
<td>
<input type=text name=min_level class=new size=30>
</td>
</tr>

<tr>
<td>
���. ���������:
</td>
<td>
<input type=text name=min_intellekt class=new size=30>
</td>
</tr>
	
<tr>
<td>
���. ����������:
</td>
<td>
<input type=text name=min_vospriyatie class=new size=30>
</td>
</tr>
	
<tr>
<td>
���. ����:
</td>
<td>
<input type=text name=mana class=new size=30>
</td>
</tr>

<tr>
<td>
<font color=RED><b>���-�� � ����:</b></font>
</td>
<td>
<input type=text name=count_mag class=new size=30>
</td>
</tr>
	
<tr>
<td>
<font color=GREEN><b>���� �������� (��.):</b></font>
</td>
<td>
<input type=text name=del_time class=new size=30>
</td>
</tr>
	
<tr>
<td>
<font color=RED><b>����:</b></font>
</td>
<td>
<input type=text name=files class=new size=30>
</td>
</tr>
<tr>
<td>
<font color=RED><b>DESC:</b></font>
</td>
<td>
<input type=text name=desc class=new size=30>
</td>
</tr>

<tr>
<td>
<font color=RED><b>TO BOOK:</b></font>
</td>
<td>
<select name=to_book class=new>
<option value=0>���
<option value=1>��
</td>
</tr>
		
<tr>
<td>
<font color=RED><b>�����:</b></font>
</td>
<td>
<select name=otdel class=new>
<option value=0>�����
<option value=1>��������������
<option value=2>����������
<option value=3>�����������
<option value=4>������
<option value=5>�������� �������
<option value=6>��������
<option value=7>��� ��� ��������
<option value=8>��������
<option value=9>��������
<option value=10>�������� ��������
</td>
</tr>

<tr>
<td>
<font color=RED><b>ART:</b></font>
</td>
<td>
<select name=art class=new>
<option value=0>���
<option value=1>��
</td>
</tr>

<tr>
<td>
<font color=RED><b>TYPE:</b></font>
</td>
<td>
<select name=type class=new>
<option value="scroll" selected>scroll
<option value="ability">ability
<option value="food">food
<option value="wolf">wolf
<option value="cheetah">cheetah
<option value="bear">bear
<option value="dragon">dragon
<option value="snake">snake
</td>
</tr>


<tr>
<td>
<font color=RED><b>��� ���:</b></font>
</td>
<td>
<select name=ztype class=new>
<option value="">
<option value="wolf">wolf
<option value="cheetah">cheetah
<option value="bear">bear
<option value="dragon">dragon
<option value="snake">snake
</td>
</tr>

<tr>
<td>
<font color=RED><b>�������:</b></font>
</td>
<td>
<select name=add_energy class=new>
<option value="">
<option value="5">5
<option value="10">10
<option value="15">15
<option value="20">20
</td>
</tr>


<tr>
<td>
����������:
</td>
<td>
<select name=need_orden class=new>
<option value=0>���
<option value=1>������ �������
<option value=2>�������
<option value=3>����� ����������
<option value=4>����� �����
<option value=5>�������� ����������
<option value=6>�������� ����
</select>
</td>
</tr>
<tr><td>
<input type=submit value="�������" class=new>
</td></tr>
</table>
</form>

<?
}
?>
