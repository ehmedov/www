<?include ("key.php");
$name=$_POST["name"];
$img=$_POST["img"];
$mass=$_POST["mass"];
$price=$_POST["price"];
$min_level=$_POST["min_level"];
$iznos_max=$_POST["iznos_max"];
$count_mag=$_POST["count_mag"];
$need_orden=$_POST["need_orden"];
$desc=$_POST["desc"];
$files=$_POST["files"];
$min_intellekt=$_POST["min_intellekt"];
$min_vospriyatie=$_POST["min_vospriyatie"];
$art=$_POST["art"];
$mana=$_POST["mana"];
$school=$_POST["school"];
$otdel=$_POST["otdel"];

if(!empty($name))
{
	$w0="INSERT INTO scroll(name,img,mass,price,min_level,type,iznos_max,mountown,orden,descs,files,min_intellekt,min_vospriyatie,to_book,art,mana,school,otdel) 
	VALUES ('$name','$img','$mass','$price','$min_level','scroll','$iznos_max','$count_mag','$need_orden','$desc','$files','$min_intellekt','$min_vospriyatie','1',$art,'$mana','$school','$otdel')";
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
<form name='action' action='main.php?act=inkviz&spell=add_svitok' method='post'>
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
<font color=RED><b>���� � �������: </b></font>
</td>
<td>
<input type=text name=img class=new size=30>
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
����������:
</td>
<td>
<select name=need_orden class=new>
<option value=0>���
<option value=1>�������� �������
<option value=2>�������
<option value=3>����� ����������
<option value=4>����� �����
<option value=5>�������� ����������
<option value=6>�������� ����
</select>
</td>
</tr>


<tr>
<td>
������ :
</td>
<td>
<select name=school class=new>
<option value="">���
<option value="air">������
<option value="water">����
<option value="fire">�����
<option value="earth">�����
</select>
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
