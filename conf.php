<?
$base_name="localhost";
$base_user="root";
$base_pass="";
$db_name="u894880828_a";
$break = "0";
$give_all_gift=0;
$bonus=400; //100% gonderilen meblegden

$data = @mysql_connect($base_name, $base_user, $base_pass) or die('Не получается подключиться. Проверьте имя сервера, имя пользователя и пароль!');
mysql_select_db($db_name) or die('Ошибка входа в базу данных');
mysql_query ("SET NAMES 'latin1'"); 
mysql_query ("set character_set_client='latin1'"); 
mysql_query ("set character_set_results='latin1'"); 
mysql_query ("set collation_connection='latin1_swedish_ci'");
header("Content-Type: text/html; charset=windows-1251");

#if (getenv('REMOTE_ADDR')=="coolmeydan") $break = "0";else $break = "1"; 

$faiz=50;
$d=date("w");
$days=array(6,0);
#if (date("G")<9)$faiz=10.5;
if (in_array($d,$days))$faiz=30;
#if ($d==0)$faiz=3;
#if ((date(n)==12 && date(j)==31) || (date(n)==1 && date(j)==1))$faiz=4; //new year
#if (date(n)==2 && date(j)==3)$faiz=30;//2 fevral gencler gunu
#if (date(n)==2 && date(j)==14)$faiz=20;//14fevral
#if (date(n)==2 && date(j)==21)$faiz=30;//I cerwenbe
#if (date(n)==2 && date(j)==23)$faiz=20;//23 fevral
#if (date(n)==2 && date(j)==28)$faiz=20;//II cerwenbe
#if (date(n)==3 && date(j)==6)$faiz=20;//III cerwenbe
#if (date(n)==3 && date(j)==8)$faiz=30;//8mart
#if (date(n)==3 && date(j)==13)$faiz=30;//IV cerwenbe
#if (date(n)==3 && (date(j)==20 || date(j)==21)) $faiz=4; //NOVRUZ 
#if (date(n)==4 && date(j)==1)$faiz=20;//1 Aprel
if (date(n)==5 && date(j)==10)$faiz=30;//10 may gul bayrami
if (date(n)==5 && date(j)==28)$faiz=30;//28 may
if (date(n)==6 && date(j)==1)$faiz=30;//1iyun uwaqlar gunu
if (date(n)==6 && date(j)==15)$faiz=20;//15 iyun Milli Qrutuluw Gunu
if (date(n)==6 && date(j)==26)$faiz=20.5;//26 iyun Silahli Quvveler gunu
#if (date(n)==8 && (date(j)==4 || date(j)==5))$faiz=2.5; //birthday 06.08
#if (date(n)==8 && date(j)==6)$faiz=40; //birthday
#if (date(n)==8 && date(j)==31)$faiz=30; //31 avqust orucluq bayrami
#if (date(n)==10 && date(j)==18)$faiz=20; //Musteqillik Gunu
#if (date(n)==11 && date(j)==7)$faiz=30; //Qurbanliq Bayrami
#if (date(n)==11 && date(j)==8)$faiz=20; //Qurbanliq Bayrami
#if (date(n)==11 && date(j)==9)$faiz=30; //Bayraq Gunu
?>