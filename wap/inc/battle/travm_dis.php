<?
	//-----------------������ �����������-------------------------
	$ushib_d_h = array();
	$ushib_d_h[0] = "������ ���� ���";
	$ushib_d_h[1] = "���� ����";
	$ushib_d_h[2] = "���������� �����";
	$ushib_d_h[3] = "�������� ����";

	$ushib_d_c = array();
	$ushib_d_c[0] = "������������ �����";
	$ushib_d_c[1] = "����� �����";
	$ushib_d_c[2] = "����� �������";
	$ushib_d_c[3] = "���� �����";

	$ushib_d_p = array();
	$ushib_d_p[0] = "����� �����";
	$ushib_d_p[1] = "���������� ���";
	$ushib_d_p[2] = "������������� �������� �� ��������";
	$ushib_d_p[3] = "���������� <��> ";

	$ushib_d_l = array();
	$ushib_d_l[0] = "���������� ���������";
	$ushib_d_l[1] = "���������� ����";
	$ushib_d_l[2] = "������������� �������� �� �����";
	$ushib_d_l[3] = "����� ������";

	switch ($hit) 
	{
		 case 1:$ushib_d = $ushib_d_h[rand(0,count($ushib_d_h)-1)];break;
		 case 2:$ushib_d = $ushib_d_c[rand(0,count($ushib_d_c)-1)];break;
	 	 case 3:$ushib_d = $ushib_d_p[rand(0,count($ushib_d_p)-1)];break;
	 	 case 4:$ushib_d = $ushib_d_l[rand(0,count($ushib_d_l)-1)];break;
	 	 case 5:$ushib_d = $ushib_d_l[rand(0,count($ushib_d_l)-1)];break;
	}

	//-----------------����������� ������� �������-------------------------
	$perelom_d_h = array();
	$perelom_d_h[0] = "������� ����";
	$perelom_d_h[1] = "�������� ���";
	$perelom_d_h[2] = "���������� �����";
	$perelom_d_h[3] = "������� ���";

	$perelom_d_� = array();
	$perelom_d_�[0] = "������� ����� ����";
	$perelom_d_�[1] = "�������� �����";
	$perelom_d_�[2] = "������� �����";
	$perelom_d_�[3] = "������� ����� ����";
	$perelom_d_�[4] = "������� �������";

	$perelom_d_p = array();
	$perelom_d_p[0] = "������� ������� �������";
	$perelom_d_p[1] = "��������� �����";
	$perelom_d_p[2] = "������� � ������� �������";
	$perelom_d_p[3] = "����� �������";

	$perelom_d_l = array();
	$perelom_d_l[0] = "������� ������ ����";
	$perelom_d_l[1] = "������ ���������";
	$perelom_d_l[2] = "������� �������� �������";
	$perelom_d_l[3] = "������� ����� ����";
	$perelom_d_l[4] = "������� ������";

	switch ($hit) 
	{
		 case 1:$perelom_d = $perelom_d_h[rand(0,count($perelom_d_h)-1)];break;
		 case 2:$perelom_d = $perelom_d_�[rand(0,count($perelom_d_c)-1)];break;
	 	 case 3:$perelom_d = $perelom_d_p[rand(0,count($perelom_d_p)-1)];break;
	 	 case 4:$perelom_d = $perelom_d_l[rand(0,count($perelom_d_l)-1)];break;
	 	 case 5:$perelom_d = $perelom_d_l[rand(0,count($perelom_d_l)-1)];break;
	}
	//-----------------������� �����������-------------------------
	$heavy_d_h = array();
	$heavy_d_h[0] = "���������� �����";		
	$heavy_d_h[1] = "������������� ���";
	$heavy_d_h[2] = "������������ �����";
	$heavy_d_h[3] = "�������� ������� �������";
	$heavy_d_h[4] = "������� ����";
	$heavy_d_h[5] = "��������� ������������ � ����";
	$heavy_d_h[6] = "��������� ��������";

	$heavy_d_c = array();
	$heavy_d_c[0] = "������� ������� ������";
	$heavy_d_c[1] = "������� ������� ����";
	$heavy_d_c[2] = "������ ���������";
	$heavy_d_c[3] = "������ ������� ����";
	$heavy_d_c[4] = "������������� �������� �����";
	$heavy_d_c[5] = "��������� ��������";
	
	$heavy_d_p = array();
	$heavy_d_p[0] = "������������� ������� ������";
	$heavy_d_p[1] = "���������� ���������";
	$heavy_d_p[2] = "�������� ������� �������";
	$heavy_d_p[3] = "������������� ������� ������";
	$heavy_d_p[4] = "��������� ��������";

	$heavy_d_l = array();
	$heavy_d_l[0] = "�������� ������� ����� ����";
	$heavy_d_l[1] = "������������� �������� �������� ����";
	$heavy_d_l[2] = "������� � �������� �����";
	$heavy_d_l[3] = "�������� ������� �����";
	$heavy_d_l[4] = "������������� �������� �������";
	$heavy_d_l[5] = "��������� ��������";

	switch ($hit) 
	{
		 case 1:$heavy_d = $heavy_d_h[rand(0,count($heavy_d_h)-1)];break;
		 case 2:$heavy_d = $heavy_d_c[rand(0,count($heavy_d_c)-1)];break;
	 	 case 3:$heavy_d = $heavy_d_p[rand(0,count($heavy_d_p)-1)];break;
	 	 case 4:$heavy_d = $heavy_d_l[rand(0,count($heavy_d_l)-1)];break;
	 	 case 5:$heavy_d = $heavy_d_l[rand(0,count($heavy_d_l)-1)];break;
	}
	switch ($travm) 
	{
		 case 1:$travm_text="������ �����������";break;
		 case 2:$travm_text="����������� ������� �������";break;
	 	 case 3:$travm_text="������� �����������";break;
	}

?>
