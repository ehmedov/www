<?
	if($ATTACK_DATA["sex"]=="female"){
	$prefix="а";
	}
	else{
	$prefix="";
	}

	$head_dis=array();
	$head_dis[0]="голову";
	$head_dis[1]="темечко";
	$head_dis[2]="затылок";
	$head_dis[3]="ухо";
	$head_dis[4]="глаз";
	$head_dis[5]="зубы";
	$head_dis[6]="нос";

	$corp_dis=array();
	$corp_dis[0]="корпус";
	$corp_dis[1]="грудь";
	$corp_dis[2]="плечо";
	$corp_dis[3]="ключицу";
	$corp_dis[4]="солнечное сплетение";

	$poyas_dis=array();
	$poyas_dis[0]="пояс";
	$poyas_dis[1]="эрогенную зону";
	$poyas_dis[2]="пупок";
	$poyas_dis[3]="укромное место";
	$poyas_dis[4]="паховую область";
	$poyas_dis[5]="то место, в которое обычно не бьют";

	$leg_dis=array();
	$leg_dis[0]="ноги";
	$leg_dis[1]="колено";
	$leg_dis[2]="пятку";
	$leg_dis[3]="щиколотку";
	$leg_dis[4]="левую ногу";

	$hit_dis=array();
	$hit_dis[1]=$head_dis[rand(0,6)];
	$hit_dis[2]=$corp_dis[rand(0,4)];
	$hit_dis[3]=$poyas_dis[rand(0,5)];
	$hit_dis[4]=$leg_dis[rand(0,4)];

	$hit_dis_phisic=array();
	$hit_dis_phisic[0]="затаив дыхание ударил$prefix в ";
	$hit_dis_phisic[1]="в прыжке вмазал$prefix в ";
	$hit_dis_phisic[2]="недолго думая плюнул$prefix в ";
	$hit_dis_phisic[3]="засучив рукава и дико вертя глазами ударил$prefix в";
	$hit_dis_phisic[4]="хитро показав колено, ударил$prefix пальцем в";
	$hit_dis_phisic[5]="подпрыгнув на левой ноге, вмазал$prefix ногой в ";
	$hit_dis_phisic[6]="засучив рукава и дико вращая глазами, ударил$prefix кулаком в";

	$hit_dis_txt=$hit_dis_phisic[rand(0,6)];
?>