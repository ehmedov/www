<?
if ($db["room"]=="crypt")
{	
	$labirint=array 
	(
		array(0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 0),
		array(1 , 1 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 1 , 1 , 1 , 1 , 1 , 0),
		array(0 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 1 , 1 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 1 , 0),
		array(0 , 1 , 0 , 0 , 0 , 0 , 0 , 1 , 1 , 1 , 1 , 1 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0),
		array(1 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 1 , 1 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 1 , 1 , 0 , 0 , 0),
		array(1 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 1 , 1 , 1 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0),
		array(1 , 0 , 0 , 1 , 0 , 0 , 0 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0),
		array(1 , 1 , 0 , 1 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 1 , 1 , 1 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 1 , 0 , 1 , 0),
		array(0 , 1 , 0 , 1 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 1 , 1 , 1 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 1 , 1 , 1 , 0),
		array(0 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 0),
		array(0 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 0),
		array(0 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 1 , 1 , 1 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 0),
		array(0 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 1 , 1 , 1 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 0),
		array(0 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 0),
		array(0 , 1 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 1 , 1 , 1 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 1 , 0 , 0 , 0 , 1 , 0),
		array(0 , 1 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 1 , 1 , 1 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 1 , 0 , 0 , 0 , 1 , 0),
		array(0 , 1 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0),
		array(0 , 1 , 0 , 1 , 1 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0),
		array(0 , 1 , 0 , 1 , 1 , 0 , 0 , 1 , 0 , 0 , 1 , 0 , 0 , 1 , 1 , 1 , 0 , 0 , 0 , 0 , 1 , 1 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0),
		array(0 , 1 , 1 , 1 , 1 , 0 , 0 , 1 , 1 , 1 , 1 , 1 , 0 , 1 , 1 , 1 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0),
		array(0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 0 , 0 , 1 , 0 , 0 , 0 , 1 , 0),
		array(0 , 0 , 0 , 0 , 1 , 1 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 1 , 1 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 1 , 1 , 1 , 1 , 1 , 0),
		array(0 , 0 , 0 , 0 , 0 , 0 , 1 , 1 , 1 , 1 , 0 , 0 , 0 , 1 , 1 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 1 , 0),
		array(0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0),
		array(0 , 1 , 1 , 1 , 1 , 1 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0),
		array(0 , 1 , 1 , 1 , 0 , 1 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0),
		array(0 , 1 , 1 , 1 , 0 , 1 , 1 , 1 , 1 , 1 , 1 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 1 , 0),
		array(0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 1 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 1 , 1 , 1 , 1 , 0),
		array(0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 0),
		array(0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 1 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0)
	);

	$sunduk_Array=array("26x10","18x10","21x18","18x20","5x9","10x20","5x3","1x0","1x2","4x11","3x7","5x18","20x28","22x28","26x28","28x28",
						"15x28","7x28","1x23","0x28","29x15","29x17");

	$eliks=array("26x10"=>2,"5x3"=>17,"1x2"=>51,"5x9"=>62,"4x11"=>2,"3x7"=>136,"5x18"=>2,"10x20"=>1,"18x20"=>4,"21x18"=>11,"18x10"=>17,
		"29x17"=>142,"29x15"=>138,"20x28"=>134,"22x28"=>2,"26x28"=>1,"28x28"=>137,"15x28"=>142,"1x0"=>2,"7x28"=>92,"1x23"=>137,"0x28"=>2);

	$Items_Array=array(array(type=>"skella",coord=>"25x7"),array(type=>"arc",coord=>"24x9"),array(type=>"tree",coord=>"16x1"),array(type=>"skella",coord=>"14x3"),array(type=>"skella",coord=>"12x3"),
	array(type=>"arc",coord=>"13x4"),array(type=>"tree",coord=>"16x7"),array(type=>"skella",coord=>"17x6"),array(type=>"fontan",coord=>"25x2"),array(type=>"tree",coord=>"25x14"),array(type=>"skella",coord=>"24x13"),
	array(type=>"skella",coord=>"19x19"),array(type=>"arc",coord=>"16x21"),array(type=>"arc",coord=>"16x24"),array(type=>"skella",coord=>"17x23"),array(type=>"skella",coord=>"18x25"),array(type=>"tree",coord=>"21x26"),
	array(type=>"skella",coord=>"23x25"),array(type=>"arc",coord=>"24x24"),array(type=>"skella",coord=>"25x23"),array(type=>"arc",coord=>"27x26"),array(type=>"arc",coord=>"13x26"),
	array(type=>"tree",coord=>"11x28"),array(type=>"skella",coord=>"10x29"),array(type=>"tree",coord=>"6x26"),array(type=>"tree",coord=>"1x26"),
	array(type=>"skella",coord=>"12x19"),array(type=>"tree",coord=>"13x18"),array(type=>"skella",coord=>"14x17"),array(type=>"fontan",coord=>"13x14"),
	array(type=>"skella",coord=>"12x11"),array(type=>"arc",coord=>"13x10"),array(type=>"skella",coord=>"14x9"),array(type=>"arc",coord=>"11x7"),array(type=>"arc",coord=>"9x5"),
	array(type=>"skella",coord=>"7x4"),array(type=>"skella",coord=>"3x2"),array(type=>"arc",coord=>"6x11"),array(type=>"fontan",coord=>"6x14"),array(type=>"arc",coord=>"3x9"),
	array(type=>"skella",coord=>"5x20"),array(type=>"tree",coord=>"8x21"),array(type=>"fontan",coord=>"20x14"),array(type=>"arc",coord=>"29x2"));

	$Bot_Names=array("barmaglot"=>"Бармаглот","povelitel"=>"Повелитель-Бармаглотов","dendroid"=>"Угрюмый-Дендроид","pangolin"=>"Пещерный-Ящер","qrifon"=>"Сумрачный-Грифон","feniks"=>"Мерцающий-феникс",);

	$Bot_Array=array("27x2"=>array("povelitel"),"26x3"=>array("dendroid","qrifon"),"24x2"=>array("feniks"),"25x1"=>array("pangolin","barmaglot","pangolin"),
	"26x1"=>array("pangolin","dendroid","pangolin"),"24x4"=>array("pangolin","qrifon","pangolin"),"25x5"=>array("pangolin","pangolin","pangolin"),"26x6"=>array("povelitel","dendroid","pangolin"),
	"26x8"=>array("pangolin","povelitel","pangolin"),"25x9"=>array("povelitel","pangolin","qrifon"),"23x9"=>array("pangolin","barmaglot","barmaglot","pangolin"),
	"22x8"=>array("barmaglot","povelitel","barmaglot"),"22x7"=>array("dendroid","pangolin","pangolin","dendroid"),"21x6"=>array("feniks"),
	"20x4"=>array("povelitel","pangolin","povelitel"),"18x4"=>array("pangolin","pangolin","pangolin","pangolin"),"17x4"=>array("qrifon"),"17x3"=>array("qrifon"),
	"19x2"=>array("dendroid"),"18x1"=>array("pangolin","barmaglot","pangolin"),"16x1"=>array("pangolin","dendroid","pangolin"),"14x1"=>array("pangolin","pangolin","qrifon","pangolin","pangolin"),
	"13x2"=>array("dendroid"),"13x4"=>array("povelitel","pangolin","povelitel"),"13x6"=>array("qrifon","qrifon","qrifon"),"13x8"=>array("povelitel"),
	"12x7"=>array("povelitel"),"14x7"=>array("povelitel"),"10x7"=>array("pangolin","povelitel","pangolin"),"9x6"=>array("dendroid","qrifon","dendroid"),
	"9x4"=>array("pangolin","povelitel","pangolin","pangolin"),"8x3"=>array("pangolin","pangolin","pangolin","pangolin"),"6x3"=>array("povelitel","povelitel","povelitel","povelitel"),
	"9x2"=>array("dendroid"),"8x1"=>array("feniks"),"6x0"=>array("qrifon"),"5x0"=>array("pangolin","qrifon","pangolin"),"3x1"=>array("barmaglot","qrifon","barmaglot"),
	"2x1"=>array("dendroid"),"8x7"=>array("dendroid"),"6x8"=>array("pangolin","dendroid","pangolin"),"6x10"=>array("dendroid","dendroid","dendroid"),
	"6x12"=>array("pangolin","feniks","pangolin"),"8x13"=>array("pangolin","pangolin"),"4x13"=>array("pangolin","pangolin"),"8x15"=>array("pangolin","pangolin","pangolin"),"4x15"=>array("pangolin","pangolin","pangolin"),
	"3x14"=>array("qrifon"),"2x13"=>array("barmaglot","qrifon","barmaglot"),"3x10"=>array("qrifon","qrifon","qrifon"),"3x8"=>array("dendroid","qrifon","dendroid"),
	"6x16"=>array("pangolin","povelitel","pangolin"),"6x17"=>array("povelitel"),"6x19"=>array("povelitel","povelitel"),"7x21"=>array("dendroid","dendroid"),
	"9x21"=>array("dendroid","pangolin","dendroid"),"11x21"=>array("dendroid","barmaglot","dendroid"),"13x20"=>array("barmaglot","dendroid","barmaglot"),
	"13x16"=>array("dendroid","feniks","dendroid"),"11x15"=>array("qrifon","dendroid"),"15x15"=>array("qrifon","dendroid"),"15x13"=>array("qrifon","dendroid"),"11x13"=>array("qrifon","dendroid"),
	"13x12"=>array("dendroid","povelitel","dendroid"),"13x10"=>array("dendroid"),"16x7"=>array("dendroid"),"18x7"=>array("qrifon"),"19x8"=>array("pangolin","barmaglot"),
	"19x11"=>array("pangolin","povelitel","pangolin","pangolin"),"20x12"=>array("pangolin","dendroid","pangolin"),"21x13"=>array("pangolin","qrifon","pangolin"),"19x13"=>array("pangolin","qrifon","pangolin"),
	"18x14"=>array("pangolin","povelitel","pangolin"),"19x15"=>array("pangolin","povelitel","pangolin"),"21x15"=>array("pangolin","povelitel","pangolin"),
	"23x14"=>array("pangolin","povelitel","pangolin"),"26x14"=>array("pangolin","povelitel","pangolin"),"27x15"=>array("pangolin","barmaglot","pangolin"),
	"28x16"=>array("dendroid","qrifon","feniks","qrifon","dendroid"),"20x17"=>array("dendroid","feniks","qrifon","dendroid"),"20x20"=>array("dendroid","feniks","dendroid"),"19x21"=>array("feniks","feniks","feniks"),
	"17x21"=>array("dendroid","feniks","dendroid"),"15x21"=>array("dendroid","feniks","dendroid"),"13x18"=>array("dendroid"),"13x22"=>array("qrifon"),"14x24"=>array("pangolin","pangolin","pangolin"),
	"17x24"=>array("povelitel"),"19x24"=>array("dendroid"),"21x26"=>array("barmaglot","povelitel","pangolin","povelitel","barmaglot"),"22x24"=>array("qrifon"),
	"26x24"=>array("dendroid","povelitel","dendroid"),"27x25"=>array("povelitel","povelitel","pangolin","povelitel"),"27x27"=>array("qrifon","qrifon","pangolin","qrifon"),"13x25"=>array("qrifon","qrifon","pangolin","qrifon"),
	"14x28"=>array("dendroid","povelitel","dendroid"),"12x28"=>array("pangolin","dendroid","pangolin"),"9x28"=>array("dendroid","feniks","dendroid"),
	"8x27"=>array("povelitel"),"6x26"=>array("povelitel","dendroid"),"4x25"=>array("pangolin","dendroid"),"2x24"=>array("barmaglot","povelitel","pangolin","povelitel","barmaglot"),
	"1x27"=>array("povelitel","dendroid","dendroid","povelitel"));
}
else if ($db["room"]=="crypt_floor2")
{
	$labirint=array 
	(
		array(0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0),
		array(0 , 1 , 1 , 0 , 1 , 1 , 0 , 1 , 1 , 0 , 1 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 1 , 0 , 1 , 1 , 0 , 1 , 1 , 0 , 1 , 1),
		array(0 , 1 , 0 , 0 , 0 , 1 , 0 , 1 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 1 , 0 , 1 , 0 , 0 , 0 , 1),
		array(0 , 1 , 0 , 0 , 0 , 1 , 0 , 1 , 0 , 0 , 0 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 0 , 0 , 0 , 1 , 0 , 1 , 0 , 1 , 0 , 1),
		array(0 , 1 , 0 , 0 , 0 , 1 , 0 , 1 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 1 , 0 , 1 , 0 , 1 , 0 , 1),
		array(0 , 1 , 0 , 0 , 0 , 1 , 0 , 1 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 1 , 0 , 1 , 0 , 1 , 0 , 1),
		array(0 , 1 , 1 , 1 , 1 , 1 , 0 , 1 , 1 , 1 , 1 , 1 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 1 , 1 , 1 , 1 , 1 , 0 , 1 , 1 , 1 , 1 , 1),
		array(0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0),
		array(0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0),
		array(0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0),
		array(0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 1 , 1 , 1 , 1 , 1 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0),
		array(0 , 0 , 0 , 1 , 1 , 1 , 0 , 1 , 1 , 1 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 1 , 1 , 1 , 0 , 1 , 1 , 1 , 0 , 0),
		array(0 , 0 , 0 , 0 , 0 , 1 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 1 , 0 , 0 , 0 , 0),
		array(0 , 0 , 0 , 0 , 0 , 1 , 0 , 1 , 0 , 0 , 0 , 1 , 1 , 1 , 0 , 0 , 0 , 1 , 1 , 1 , 0 , 0 , 0 , 1 , 0 , 1 , 0 , 0 , 0 , 0),
		array(0 , 0 , 0 , 1 , 1 , 1 , 0 , 1 , 1 , 1 , 0 , 1 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 1 , 0 , 1 , 1 , 1 , 0 , 1 , 1 , 1 , 0 , 0),
		array(0 , 0 , 0 , 1 , 0 , 1 , 0 , 1 , 0 , 1 , 0 , 1 , 0 , 0 , 1 , 1 , 1 , 0 , 0 , 1 , 0 , 1 , 0 , 1 , 0 , 1 , 0 , 1 , 0 , 0),
		array(0 , 0 , 0 , 1 , 0 , 1 , 0 , 1 , 0 , 1 , 0 , 1 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 1 , 0 , 1 , 0 , 1 , 0 , 1 , 0 , 1 , 0 , 0),
		array(0 , 0 , 0 , 1 , 0 , 1 , 1 , 1 , 0 , 1 , 0 , 1 , 1 , 1 , 0 , 1 , 0 , 1 , 1 , 1 , 0 , 1 , 0 , 1 , 1 , 1 , 0 , 1 , 0 , 0),
		array(0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 1 , 0 , 1 , 0 , 1 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0),
		array(0 , 0 , 0 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 0 , 0 , 0 , 1 , 1 , 1 , 1 , 1 , 0 , 0 , 0 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 0 , 0),
		array(0 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0),
		array(0 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0),
		array(0 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0),
		array(0 , 0 , 0 , 0 , 1 , 1 , 1 , 1 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 1 , 1 , 1 , 1 , 0 , 0 , 0),
		array(0 , 0 , 1 , 1 , 1 , 0 , 0 , 0 , 1 , 1 , 1 , 1 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 1 , 1 , 1 , 1 , 0 , 0 , 0 , 1 , 1 , 1 , 0),
		array(0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 1 , 1 , 1 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 0),
		array(0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 0),
		array(0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 1 , 1 , 1 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 0),
		array(0 , 0 , 1 , 1 , 1 , 0 , 0 , 0 , 1 , 1 , 1 , 1 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 1 , 1 , 1 , 1 , 0 , 0 , 0 , 1 , 1 , 1 , 0),
		array(0 , 0 , 0 , 0 , 1 , 1 , 1 , 1 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 0 , 0 , 0 , 0 , 0 , 0 , 1 , 1 , 1 , 1 , 1 , 0 , 0 , 0)
	);
	$sunduk_Array=array("15x16", "15x14", "24x15", "3x27", "1x2", "1x4", "1x8", "1x10", "1x20", "1x22", "1x26", "1x28");
	$eliks=array(
				"15x16"=>array("paltar"=>array(0,0,1088,1076,1097,1103,1110,1119,1126,629)),
				"15x14"=>array("paltar"=>array(0,0,1140,1112,1138,1121,1139,1075,1128,629)),
				"24x15"=>array("scroll"=>array(0,184,136,2,142,221,234)),
				"3x27"=>array("paltar"=>array(0,0,1094,1131,1086,1100,1106,1115,1136,1137,1135,350)),
				"1x2"=>array("paltar"=>array(0,0,1147,1146,1145,1148,1077,1149,350)),
				"1x4"=>array("paltar"=>array(0,0,1090,1085,1098,1104,1111,1120,1127,629)),
				"1x8"=>array("paltar"=>array(0,0,1133,1124,1117,1108,1102,1078,1141,1142,1039)),
				"1x10"=>array("paltar"=>array(0,0,1096,1134,1079,1109,1125,1118,1143,720)),
				"1x20"=>array("scroll"=>array(183,142,221,136,2,234)),
				"1x22"=>array("paltar"=>array(0,0,1116,1123,1107,1101,1095,1080,1132,350)),
				"1x26"=>array("paltar"=>array(0,0,1129,1122,1081,1113,1099,1105,1091,720)),
				"1x28"=>array("paltar"=>array(0,0,1144,1130,1114,1093,1092,1084,1136,1137,1135,1039))
				);

	
	$Items_Array=array(array(type=>"fontan",coord=>"26x15"),array(type=>"arc",coord=>"29x6"),array(type=>"skella",coord=>"26x1"),array(type=>"skella",coord=>"26x3"),
	array(type=>"arc",coord=>"21x6"),array(type=>"skella",coord=>"20x4"),array(type=>"tree",coord=>"17x3"),array(type=>"skella",coord=>"16x2"),
	array(type=>"tree",coord=>"15x3"),array(type=>"skella",coord=>"8x2"),array(type=>"skella",coord=>"8x4"),array(type=>"arc",coord=>"3x1"),
	array(type=>"tree",coord=>"3x5"),array(type=>"tree",coord=>"17x9"),array(type=>"tree",coord=>"8x9"),array(type=>"tree",coord=>"4x7"),
	array(type=>"skella",coord=>"2x13"),array(type=>"skella",coord=>"4x13"),array(type=>"tree",coord=>"3x17"),array(type=>"arc",coord=>"4x23"),
	array(type=>"arc",coord=>"9x21"),array(type=>"arc",coord=>"17x21"),array(type=>"tree",coord=>"16x27"),array(type=>"tree",coord=>"8x27"),
	array(type=>"arc",coord=>"4x25"),array(type=>"skella",coord=>"3x28"),array(type=>"skella",coord=>"4x30"),array(type=>"tree",coord=>"21x24"),
	array(type=>"arc",coord=>"26x28"),array(type=>"arc",coord=>"29x24"),array(type=>"arc",coord=>"7x15"),array(type=>"arc",coord=>"5x15"),
	array(type=>"arc",coord=>"15x19"),array(type=>"tree",coord=>"17x15"),array(type=>"tree",coord=>"15x11"),array(type=>"tree",coord=>"29x15"));
	
	$Bot_Names=array("yadernik"=>"Ядерник","radskorpion"=>"Радскорпион","nejit"=>"Нежить","kentavr"=>"Кентавр","qul"=>"Дикий гул","qarqulya"=>"Горгулья",
	"pauk"=>"Гигантский Паук");
	$Bot_Array=array("27x14"=>array("radskorpion","nejit","radskorpion"),"27x16"=>array("radskorpion","nejit","radskorpion"),
	"25x15"=>array("kentavr","radskorpion"),"26x13"=>array("yadernik","kentavr"),"27x11"=>array("radskorpion","radskorpion"),
	"25x11"=>array("pauk","pauk","pauk","pauk"),"26x17"=>array("pauk","pauk","pauk"),"28x8"=>array("pauk","nejit","pauk"),
	"29x7"=>array("nejit","radskorpion"),"29x5"=>array("nejit","radskorpion"),"28x4"=>array("pauk","nejit","radskorpion"),
	"25x2"=>array("pauk","pauk","pauk","pauk"),"27x2"=>array("pauk","pauk","pauk"),
	"24x4"=>array("pauk","nejit","nejit"),"24x8"=>array("pauk","nejit","radskorpion","nejit"),"22x6"=>array("radskorpion","pauk","radskorpion"),
	"20x6"=>array("pauk","nejit","nejit"),"19x3"=>array("pauk","pauk","pauk","pauk"),"14x3"=>array("radskorpion","nejit","radskorpion"),
	"17x5"=>array("radskorpion","radskorpion","radskorpion"),"14x5"=>array("pauk","nejit","radskorpion"),"11x5"=>array("pauk","pauk","pauk","pauk"),
	"11x3"=>array("radskorpion","radskorpion"),"6x3"=>array("nejit","radskorpion"),"6x3"=>array("pauk","nejit","radskorpion"),
	"6x1"=>array("pauk","nejit","nejit"),"3x1"=>array("radskorpion","radskorpion"),"1x1"=>array("kentavr","kentavr"),
	"6x5"=>array("pauk","pauk","pauk","pauk"),"3x5"=>array("radskorpion","radskorpion"),"1x5"=>array("kentavr","kentavr"),
	"14x9"=>array("kentavr","kentavr"),"19x9"=>array("yadernik","qul"),"17x7"=>array("yadernik","qul","yadernik"),
	"14x7"=>array("kentavr","qul"),"11x7"=>array("kentavr","qul","kentavr"),"11x9"=>array("kentavr","qul"),
	"9x9"=>array("yadernik","qul"),"6x9"=>array("yadernik","kentavr"),"6x7"=>array("yadernik","kentavr","pauk"),
	"3x7"=>array("qul","kentavr","pauk"),"1x7"=>array("qul","qul","yadernik"),"6x11"=>array("kentavr","kentavr"),
	"3x11"=>array("kentavr","nejit","radskorpion"),"1x11"=>array("yadernik","qul"),"27x19"=>array("radskorpion","radskorpion"),
	"25x19"=>array("pauk","pauk","pauk","pauk"),"28x22"=>array("pauk","nejit","pauk"),"29x24"=>array("nejit","radskorpion"),
	"28x26"=>array("pauk","nejit","radskorpion"),"26x28"=>array("pauk","pauk","pauk","pauk"),"24x26"=>array("pauk","nejit","nejit"),
	"23x24"=>array("pauk","nejit","radskorpion","nejit"),"24x22"=>array("radskorpion","pauk","radskorpion"),"21x24"=>array("pauk","nejit","nejit"),
	"19x24"=>array("radskorpion","nejit","radskorpion"),"19x21"=>array("radskorpion","radskorpion","radskorpion"),"19x27"=>array("pauk","nejit","radskorpion"),
	"17x27"=>array("pauk","pauk","pauk","pauk"),"14x27"=>array("nejit","radskorpion"),"14x25"=>array("pauk","nejit","radskorpion"),
	"17x25"=>array("pauk","nejit","nejit"),"17x23"=>array("radskorpion","radskorpion"),"14x23"=>array("kentavr","kentavr"),
	"14x21"=>array("pauk","pauk","pauk","pauk"),"17x21"=>array("radskorpion","radskorpion"),"11x23"=>array("kentavr","kentavr"),
	"11x21"=>array("yadernik","qul"),"9x21"=>array("yadernik","qul","yadernik"),"6x21"=>array("kentavr","qul"),
	"6x23"=>array("kentavr","qul","kentavr"),"3x23"=>array("kentavr","qul"),"1x23"=>array("yadernik","qul"),"6x19"=>array("yadernik","kentavr"),
	"3x19"=>array("yadernik","kentavr","pauk"),"1x19"=>array("qul","qul","yadernik"),"11x25"=>array("radskorpion","radskorpion"),
	"11x27"=>array("pauk","pauk","pauk","pauk"),"9x27"=>array("pauk","nejit","pauk"),"6x27"=>array("nejit","radskorpion"),
	"4x27"=>array("kentavr","qul","kentavr"),"6x29"=>array("pauk","nejit","radskorpion"),"4x29"=>array("pauk","pauk","pauk","pauk"),
	"1x29"=>array("pauk","nejit","nejit"),"6x25"=>array("pauk","nejit","radskorpion","nejit"),"4x25"=>array("radskorpion","pauk","radskorpion"),
	"1x25"=>array("radskorpion","nejit","radskorpion"),"3x14"=>array("radskorpion","qul","kentavr","pauk"),"3x16"=>array("qul","kentavr","pauk"),"5x15"=>array("kentavr","kentavr"),
	"7x15"=>array("yadernik","qul"),"10x15"=>array("yadernik","qul","yadernik"),"10x17"=>array("kentavr","qul"),
	"13x17"=>array("kentavr","qul","kentavr"),"13x19"=>array("kentavr","qul"),"15x19"=>array("qul"),"17x19"=>array("yadernik","qul"),
	"17x17"=>array("yadernik","kentavr"),"19x17"=>array("yadernik","kentavr","pauk"),"19x15"=>array("radskorpion","qul","kentavr","pauk"),
	"17x15"=>array("radskorpion","kentavr","pauk"),"15x15"=>array("radskorpion","qul","kentavr","pauk"),"10x13"=>array("kentavr","qul"),
	"13x13"=>array("kentavr","qul","kentavr"),"13x11"=>array("kentavr","qul"),"15x11"=>array("qul"),"17x11"=>array("yadernik","qul"),
	"17x13"=>array("yadernik","kentavr"),"19x13"=>array("yadernik","kentavr","pauk"),);
}	
//----------------------------------------------------------------
function DrawAllMap($loc,$vec)
{
	global $labirint;
	global $sunduk_Array;
	global $Bot_Array;
	global $users;
	$cord = explode("x",$loc);
	$x = $cord[0];
	$y = $cord[1];
	$vt=array(0,90,180,270);
	$ch=array("right.gif","back.gif","left.gif","top.gif");
	$arrow="<img src='img/podzemka/move/".$ch[array_search($vec,$vt)]."' border=0 alt='Ваше местонахождени'>";
	echo "<table border=0 cellpadding=0 cellspacing=0 bgcolor=#7e898b><tr><td>";
		echo "<table border=0 cellpadding=0 cellspacing=0 bgcolor=#000000 width=100% height=100%>";
		for ($my=-7;$my<8;$my++)
		{
			echo "<tr>";
			for ($mx=-4;$mx<5;$mx++)
			{
				$mxx=floor($x+$mx);
				$myy=floor($y+$my);
				$z=$mxx."x".$myy;
				$itBeInThere = 0;
				$who="";
				if ($users!="")
				foreach($users as $currentValue) 
				{
  					if (in_array ($z, $currentValue)) 
  					{
    					$itBeInThere = 1;
    					$who=$currentValue["login"];
    				}
  				} 
				if ($mxx==$x && $myy==$y)echo"<td width=17 height=17 align=center valign=center bgcolor='#c0c0c0' ".($itBeInThere?"background='img/podzemka/move/user.gif' title='".$who."'":"").($Bot_Array[$mxx."x".$myy]?"background='img/podzemka/misc/bot.gif'":"").">".$arrow."</td>";
				else if (in_array ($z, $sunduk_Array)) echo"<td width=17 height=17 align=center valign=center bgcolor='#c0c0c0' background='img/podzemka/misc/sunduk.gif' title='Сундук'></td>";
				else if ($itBeInThere)echo"<td width=17 height=17 align=center valign=center bgcolor=#c0c0c0 ".($Bot_Array[$mxx."x".$myy]?"background='img/podzemka/misc/bot.gif'":"")."><img src='img/podzemka/move/user.gif' border=0 alt='".$who."'></td>";
				else if ($Bot_Array[$mxx."x".$myy])echo"<td width=17 height=17 align=center valign=center bgcolor=#c0c0c0><img src='img/podzemka/misc/bot.gif'  alt='Подземные существа' border=0></td>";
				else if ($labirint[$mxx][$myy]==1)echo'<td width=17 height=17 align=center valign=center bgcolor=#c0c0c0></td>';
				else echo'<td width=17 height=17 align=center valign=center></td>';	
			}
			echo "</tr>";
		} 
		echo "</table>";
	echo "</td></tr></table>";

}
//----------------------------------------------------------------
function next_step($location,$vector)
{
	global $labirint;
	$cord = explode("x",$location);
	$row=$cord[0];
	$col=$cord[1];
	$cell=array();

	// fwd
	$c=$col;
	$r=$row;
	if($vector==90) $c=$col+1;
	else if($vector==180) $r=$row-1;
	else if($vector==270) $c=$col-1;
	else $r=$row+1;
	$cell['fwd']=$r."x".$c;
	$cell['fwd_cord']=$r."x".$c;
	if($labirint[$r][$c]==0) $cell['fwd']=false;
	
	// left
	$c=$col;
	$r=$row;
	if($vector==90) $r=$row+1;
	else if($vector==180) $c=$col+1;
	else if($vector==270) $r=$row-1;
	else $c=$col-1;
	$cell['left']=$r."x".$c;
	$cell['left_cord']=$r."x".$c;
	if($labirint[$r][$c]==0) $cell['left']=false;
	
	// right
	$c=$col;
	$r=$row;
	if($vector==90) $r=$row-1;
	else if($vector==180) $c=$col-1;
	else if($vector==270) $r=$row+1;
	else $c=$col+1;
	$cell['right']=$r."x".$c;
	$cell['right_cord']=$r."x".$c;
	if($labirint[$r][$c]==0) $cell['right']=false;
	
	return $cell;
}
?>