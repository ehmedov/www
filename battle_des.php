<?
	if($ATTACK_DATA["sex"]=="female"){
	$prefix="�";
	}
	else{
	$prefix="";
	}

	$head_dis=array();
	$head_dis[0]="������";
	$head_dis[1]="�������";
	$head_dis[2]="�������";
	$head_dis[3]="���";
	$head_dis[4]="����";
	$head_dis[5]="����";
	$head_dis[6]="���";

	$corp_dis=array();
	$corp_dis[0]="������";
	$corp_dis[1]="�����";
	$corp_dis[2]="�����";
	$corp_dis[3]="�������";
	$corp_dis[4]="��������� ���������";

	$poyas_dis=array();
	$poyas_dis[0]="����";
	$poyas_dis[1]="��������� ����";
	$poyas_dis[2]="�����";
	$poyas_dis[3]="�������� �����";
	$poyas_dis[4]="������� �������";
	$poyas_dis[5]="�� �����, � ������� ������ �� ����";

	$leg_dis=array();
	$leg_dis[0]="����";
	$leg_dis[1]="������";
	$leg_dis[2]="�����";
	$leg_dis[3]="���������";
	$leg_dis[4]="����� ����";

	$hit_dis=array();
	$hit_dis[1]=$head_dis[rand(0,6)];
	$hit_dis[2]=$corp_dis[rand(0,4)];
	$hit_dis[3]=$poyas_dis[rand(0,5)];
	$hit_dis[4]=$leg_dis[rand(0,4)];

	$hit_dis_phisic=array();
	$hit_dis_phisic[0]="������ ������� ������$prefix � ";
	$hit_dis_phisic[1]="� ������ ������$prefix � ";
	$hit_dis_phisic[2]="������� ����� ������$prefix � ";
	$hit_dis_phisic[3]="������� ������ � ���� ����� ������� ������$prefix �";
	$hit_dis_phisic[4]="����� ������� ������, ������$prefix ������� �";
	$hit_dis_phisic[5]="���������� �� ����� ����, ������$prefix ����� � ";
	$hit_dis_phisic[6]="������� ������ � ���� ������ �������, ������$prefix ������� �";

	$hit_dis_txt=$hit_dis_phisic[rand(0,6)];
?>