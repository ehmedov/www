<?
echo $U=getenv("HTTP_USER_AGENT"); // �������� ������ � �����, 
echo "<br>";
echo $H=getenv("HTTP_REFERER"); // �������� URL, � �������� ������ ���������� 
echo "<br>";
echo $R=getenv("REMOTE_ADDR"); // �������� IP ���������� 
echo "<br>";
echo $W=getenv("REQUEST_URI"); // �������� ������������� ����� ���������,
?>