<?
function boy_type($t)
{
	switch ($t)	
	{
		case 1:$txt="���������: � �������";	break;
		case 2:$txt="���������: ��������";	break;
		case 100:$txt="���������: ��������";break;
		case 3:$txt="���������: ��������";	break;
		case 4:$txt="���������: � �������";	break;
		case 101:$txt="���������: ��������";break;
		case 5:$txt="�����������: � �������";	break;
		case 6:$txt="�����������: ��������";	break;
		case 7:$txt="�����������: � �������";	break;
		case 102:$txt="�����������: ��������";break;
		case 18:$txt="������ ��������� �����";break;
		case 19:$txt="������������ ����";break;
		case 10:$txt="���������� ���������";break;
		case 15:$txt="���������";break;
		case 80:$txt="������� �� ���� �����";break;
		case 82:$txt="������� ������";break;
		case 88:$txt="���������� ������";break;
		case 89:$txt="������ �����������";break;
		case 44:$txt="���������";break;
		case 55:$txt="������ ���";break;
		case 99:$txt="������";break;
		case 66:$txt="����� � ������ ������";break;
		case 13:$txt="����� �� �����";break;
		case 33:$txt="����������� ����";break;
		case 11:$txt="���� vs. ����";break;
		case 23:$txt="��� � �������� �����";break;
		case 77:$txt="����� ������";break;
		case 29:$txt="���� vs. ����";break;
		default:$txt="�� ���������";break;
	}
	return $txt;
}
?>