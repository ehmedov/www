<?
$base_name="mysql.hostinger.ru";
$base_user="u607637450_user";
$base_pass="12345abc";
$db_name="u607637450_db";

$break = 0;
#if (getenv('REMOTE_ADDR')=="85.132.96.85") $break = "0";else $break = "1";
$bonus=100; //50% gonderilen meblegden
$faiz=1;
$d=date("w");
$days=array(6,0);
if (in_array($d,$days))$faiz=3;
$img_folder="http://www.meydan.az/img/";

#if ($d==0)$faiz=3;
if ((date(n)==12 && date(j)==31) || (date(n)==1 && date(j)==1))$faiz=4; //new year
if (date(n)==2 && date(j)==3)$faiz=3;//2 fevral gencler gunu
if (date(n)==2 && date(j)==14)$faiz=2;//14fevral
if (date(n)==2 && date(j)==21)$faiz=3;//I cerwenbe
if (date(n)==2 && date(j)==23)$faiz=2;//23 fevral
if (date(n)==2 && date(j)==28)$faiz=2;//II cerwenbe
if (date(n)==3 && date(j)==6)$faiz=2;//III cerwenbe
if (date(n)==3 && date(j)==8)$faiz=3;//8mart
if (date(n)==3 && date(j)==13)$faiz=3;//IV cerwenbe
if (date(n)==3 && (date(j)==20 || date(j)==21)) $faiz=4; //NOVRUZ 
if (date(n)==4 && date(j)==1)$faiz=2;//1 Aprel
if (date(n)==5 && date(j)==10)$faiz=3;//10 may gul bayrami
if (date(n)==5 && date(j)==28)$faiz=3;//28 may
if (date(n)==6 && date(j)==1)$faiz=3;//1iyun uwaqlar gunu
if (date(n)==6 && date(j)==15)$faiz=2;//15 iyun Milli Qrutuluw Gunu
if (date(n)==6 && date(j)==26)$faiz=2.5;//26 iyun Silahli Quvveler gunu
if (date(n)==8 && (date(j)==4 || date(j)==5))$faiz=2.5; //birthday 06.08
if (date(n)==8 && date(j)==6)$faiz=4; //birthday
if (date(n)==8 && date(j)==31)$faiz=3; //31 avqust orucluq bayrami
if (date(n)==10 && date(j)==18)$faiz=2; //Musteqillik Gunu
if (date(n)==11 && date(j)==7)$faiz=3; //Qurbanliq Bayrami
if (date(n)==11 && date(j)==8)$faiz=2; //Qurbanliq Bayrami
if (date(n)==11 && date(j)==9)$faiz=3; //Bayraq Gunu

?>