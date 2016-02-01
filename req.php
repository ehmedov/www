<?
	function format_str(&$string)
   	{
   		return $string = htmlspecialchars(addslashes($string));
   	}
   	function format_arr(&$array)
   	{
   		foreach ($array as &$value) 
   		{
    		$value = htmlspecialchars(addslashes($value));
		}
   		return $array;
   	}
   	function format_string(&$string)
   	{
   		if (is_array($string))
   		return format_arr($string);
   		else format_str($string);
   	}
   	function clean_var($var) 
   	{ #в hidden или в input неважно (в люб html)
 		$var=str_replace('&', "&#38", $var);
 		$var=str_replace(array('"',"'","`","<",">",'\\'), array('&quot;',"&#x27;","&#x60;","&#60","&#62","&#92"), $var);
 		return $var;
	}
?>