<?php

/*
 +-----------------------------------------------------------------------+
 | rcube_shared.inc                                                      |
 |                                                                       |
 | This file is part of the RoundCube PHP suite                          |
 | Copyright (C) 2005-2007, RoundCube Dev. - Switzerland                 |
 | Licensed under the GNU GPL                                            |
 |                                                                       |
 | CONTENTS:                                                             |
 |   Shared functions and classes used in PHP projects                   |
 |                                                                       |
 +-----------------------------------------------------------------------+
 | Author: Thomas Bruederli <roundcube@gmail.com>                        |
 +-----------------------------------------------------------------------+

 $Id: rcube_shared.inc 3063 2009-10-27 09:43:39Z alec $

*/


/**
 * RoundCube shared functions
 * 
 * @package Core
 */


/**
 * Send HTTP headers to prevent caching this page
 */
function send_nocacheing_headers()
{
  if (headers_sent())
    return;

  header("Expires: ".gmdate("D, d M Y H:i:s")." GMT");
  header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
  header("Cache-Control: private, must-revalidate, post-check=0, pre-check=0");
  header("Pragma: no-cache");
  
  // We need to set the following headers to make downloads work using IE in HTTPS mode.
  if (rcube_https_check()) {
    header('Pragma: ');
    header('Cache-Control: ');
  }
}


/**
 * Send header with expire date 30 days in future
 *
 * @param int Expiration time in seconds
 */
function send_future_expire_header($offset=2600000)
{
  if (headers_sent())
    return;

  header("Expires: ".gmdate("D, d M Y H:i:s", mktime()+$offset)." GMT");
  header("Cache-Control: max-age=$offset");
  header("Pragma: ");
}


/**
 * Check request for If-Modified-Since and send an according response.
 * This will terminate the current script if headers match the given values
 *
 * @param int Modified date as unix timestamp
 * @param string Etag value for caching
 */
function send_modified_header($mdate, $etag=null, $skip_check=false)
{
  if (headers_sent())
    return;
    
  $iscached = false;
  $etag = $etag ? "\"$etag\"" : null;

  if (!$skip_check)
  {
    if ($_SERVER['HTTP_IF_MODIFIED_SINCE'] && strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) >= $mdate)
      $iscached = true;
  
    if ($etag)
      $iscached = ($_SERVER['HTTP_IF_NONE_MATCH'] == $etag);
  }
  
  if ($iscached)
    header("HTTP/1.x 304 Not Modified");
  else
    header("Last-Modified: ".gmdate("D, d M Y H:i:s", $mdate)." GMT");
  
  header("Cache-Control: max-age=0");
  header("Expires: ");
  header("Pragma: ");
  
  if ($etag)
    header("Etag: $etag");
  
  if ($iscached)
    {
    ob_end_clean();
    exit;
    }
}


/**
 * Returns whether an $str is a reserved word for any of the version of Javascript or ECMAScript
 * @param str String to check
 * @return boolean True if $str is a reserver word, False if not
 */
function is_js_reserved_word($str)
{
  return in_array($str, array(
    // ECMASript ver 4 reserved words
    'as','break','case','catch','class','const','continue',
    'default','delete','do','else','export','extends','false','finally','for','function',
    'if','import','in','instanceof','is','namespace','new','null','package','private',
    'public','return','super','switch','this','throw','true','try','typeof','use','var',
    'void','while','with',
    // ECMAScript ver 4 future reserved words
    'abstract','debugger','enum','goto','implements','interface','native','protected',
    'synchronized','throws','transient','volatile',
    // special meaning in some contexts
    'get','set',
    // were reserved in ECMAScript ver 3
    'boolean','byte','char','double','final','float','int','long','short','static'
  ));
}


/**
 * Convert a variable into a javascript object notation
 *
 * @param mixed Input value
 * @return string Serialized JSON string
 */
function json_serialize($var)
{
  if (is_object($var))
    $var = get_object_vars($var);

  if (is_array($var))
  {
    // empty array
    if (!sizeof($var))
      return '[]';
    else
    {
      $keys_arr = array_keys($var);
      $is_assoc = $have_numeric = 0;

      for ($i=0; $i<sizeof($keys_arr); ++$i)
      {
        if (is_numeric($keys_arr[$i]))
          $have_numeric = 1;
        if (!is_numeric($keys_arr[$i]) || $keys_arr[$i] != $i)
          $is_assoc = 1;
        if ($is_assoc && $have_numeric)
          break;
      }
      
      $brackets = $is_assoc ? '{}' : '[]';
      $pairs = array();

      foreach ($var as $key => $value)
      {
        // enclose key with quotes if it is not variable-name conform
        if (!preg_match('/^[_a-zA-Z]{1}[_a-zA-Z0-9]*$/', $key) || is_js_reserved_word($key))
          $key = "'$key'";

        $pairs[] = sprintf("%s%s", $is_assoc ? "$key:" : '', json_serialize($value));
      }

      return $brackets{0} . implode(',', $pairs) . $brackets{1};
    }
  }
  else if (!is_string($var) && strval(intval($var)) === strval($var))
    return $var;
  else if (is_bool($var))
    return $var ? '1' : '0';
  else
    return "'".JQ($var)."'";
}


/**
 * Function to convert an array to a javascript array
 * Actually an alias function for json_serialize()
 * @deprecated
 */
function array2js($arr, $type='')
{
  return json_serialize($arr);
}


/**
 * Similar function as in_array() but case-insensitive
 *
 * @param mixed Needle value
 * @param array Array to search in
 * @return boolean True if found, False if not
 */
function in_array_nocase($needle, $haystack)
{
  $needle = mb_strtolower($needle);
  foreach ($haystack as $value)
    if ($needle===mb_strtolower($value))
      return true;
  
  return false;
}


/**
 * Find out if the string content means TRUE or FALSE
 *
 * @param string Input value
 * @return boolean Imagine what!
 */
function get_boolean($str)
{
  $str = strtolower($str);
  if (in_array($str, array('false', '0', 'no', 'nein', ''), TRUE))
    return FALSE;
  else
    return TRUE;
}


/**
 * Parse a human readable string for a number of bytes
 *
 * @param string Input string
 * @return float Number of bytes
 */
function parse_bytes($str)
{
  if (is_numeric($str))
    return floatval($str);
    
  if (preg_match('/([0-9]+)([a-z])/i', $str, $regs))
  {
    $bytes = floatval($regs[1]);
    switch (strtolower($regs[2]))
    {
      case 'g':
        $bytes *= 1073741824;
        break;
      case 'm':
        $bytes *= 1048576;
        break;
      case 'k':
        $bytes *= 1024;
        break;
    }
  }

  return floatval($bytes);
}
    
/**
 * Create a human readable string for a number of bytes
 *
 * @param int Number of bytes
 * @return string Byte string
 */
function show_bytes($bytes)
{
  if ($bytes > 1073741824)
  {
    $gb = $bytes/1073741824;
    $str = sprintf($gb>=10 ? "%d " : "%.1f ", $gb) . rcube_label('GB');
  }
  else if ($bytes > 1048576)
  {
    $mb = $bytes/1048576;
    $str = sprintf($mb>=10 ? "%d " : "%.1f ", $mb) . rcube_label('MB');
  }
  else if ($bytes > 1024)
    $str = sprintf("%d ",  round($bytes/1024)) . rcube_label('KB');
  else
    $str = sprintf('%d ', $bytes) . rcube_label('B');

  return $str;
}


/**
 * Convert paths like ../xxx to an absolute path using a base url
 *
 * @param string Relative path
 * @param string Base URL
 * @return string Absolute URL
 */
function make_absolute_url($path, $base_url)
{
  $host_url = $base_url;
  $abs_path = $path;
  
  // check if path is an absolute URL
  if (preg_match('/^[fhtps]+:\/\//', $path))
    return $path;

  // cut base_url to the last directory
  if (strrpos($base_url, '/')>7)
  {
    $host_url = substr($base_url, 0, strpos($base_url, '/'));
    $base_url = substr($base_url, 0, strrpos($base_url, '/'));
  }

  // $path is absolute
  if ($path{0}=='/')
    $abs_path = $host_url.$path;
  else
  {
    // strip './' because its the same as ''
    $path = preg_replace('/^\.\//', '', $path);

    if (preg_match_all('/\.\.\//', $path, $matches, PREG_SET_ORDER))
      foreach ($matches as $a_match)
      {
        if (strrpos($base_url, '/'))
          $base_url = substr($base_url, 0, strrpos($base_url, '/'));
        
        $path = substr($path, 3);
      }

    $abs_path = $base_url.'/'.$path;
  }
    
  return $abs_path;
}

/**
 * Wrapper function for wordwrap
 */
function rc_wordwrap($string, $width=75, $break="\n", $cut=false)
{
  $para = explode($break, $string);
  $string = '';
  while (count($para)) {
    $list = explode(' ', array_shift($para));
    $len = 0;
    while (count($list)) {
      $line = array_shift($list);
      $l = mb_strlen($line);
      $newlen = $len + $l + ($len ? 1 : 0);

      if ($newlen <= $width) {
        $string .= ($len ? ' ' : '').$line;
        $len += (1 + $l);
      } else {
	if ($l > $width) {
	  if ($cut) {
	    $start = 0;
	    while ($l) {
	      $str = mb_substr($line, $start, $width);
	      $strlen = mb_strlen($str);
	      $string .= ($len ? $break : '').$str;
	      $start += $strlen;
	      $l -= $strlen;
	      $len = $strlen;
	    }
	  } else {
            $string .= ($len ? $break : '').$line;
	    if (count($list)) $string .= $break;
	    $len = 0;
	  }
	} else {
          $string .= $break.$line;
	  $len = $l;
        }
      }
    }
    if (count($para)) $string .= $break;
  }
  return $string;
}

/**
 * Read a specific HTTP request header
 *
 * @access static
 * @param  string $name Header name
 * @return mixed  Header value or null if not available
 */
function rc_request_header($name)
{
  if (function_exists('getallheaders'))
  {
    $hdrs = array_change_key_case(getallheaders(), CASE_UPPER);
    $key  = strtoupper($name);
  }
  else
  {
    $key  = 'HTTP_' . strtoupper(strtr($name, '-', '_'));
    $hdrs = array_change_key_case($_SERVER, CASE_UPPER);
  }

  return $hdrs[$key];
  }


/**
 * Make sure the string ends with a slash
 */
function slashify($str)
{
  return unslashify($str).'/';
}


/**
 * Remove slash at the end of the string
 */
function unslashify($str)
{
  return preg_replace('/\/$/', '', $str);
}
  

/**
 * Delete all files within a folder
 *
 * @param string Path to directory
 * @return boolean True on success, False if directory was not found
 */
function clear_directory($dir_path)
{
  $dir = @opendir($dir_path);
  if(!$dir) return FALSE;

  while ($file = readdir($dir))
    if (strlen($file)>2)
      unlink("$dir_path/$file");

  closedir($dir);
  return TRUE;
}


/**
 * Create a unix timestamp with a specified offset from now
 *
 * @param string String representation of the offset (e.g. 20min, 5h, 2days)
 * @param int Factor to multiply with the offset
 * @return int Unix timestamp
 */
function get_offset_time($offset_str, $factor=1)
  {
  if (preg_match('/^([0-9]+)\s*([smhdw])/i', $offset_str, $regs))
  {
    $amount = (int)$regs[1];
    $unit = strtolower($regs[2]);
  }
  else
  {
    $amount = (int)$offset_str;
    $unit = 's';
  }
    
  $ts = mktime();
  switch ($unit)
  {
    case 'w':
      $amount *= 7;
    case 'd':
      $amount *= 24;
    case 'h':
      $amount *= 60;
    case 'm':
      $amount *= 60;
    case 's':
      $ts += $amount * $factor;
  }

  return $ts;
}


/**
 * Replace the middle part of a string with ...
 * if it is longer than the allowed length
 *
 * @param string Input string
 * @param int    Max. length
 * @param string Replace removed chars with this
 * @return string Abbreviated string
 */
function abbreviate_string($str, $maxlength, $place_holder='...')
{
  $length = mb_strlen($str);
  $first_part_length = floor($maxlength/2) - mb_strlen($place_holder);
  
  if ($length > $maxlength)
  {
    $second_starting_location = $length - $maxlength + $first_part_length + 1;
    $str = mb_substr($str, 0, $first_part_length) . $place_holder . mb_substr($str, $second_starting_location, $length);
  }

  return $str;
}

/**
 * A method to guess the mime_type of an attachment.
 *
 * @param string $path     Path to the file.
 * @param string $name     File name (with suffix)
 * @param string $failover Mime type supplied for failover.
 *
 * @return string
 * @author Till Klampaeckel <till@php.net>
 * @see    http://de2.php.net/manual/en/ref.fileinfo.php
 * @see    http://de2.php.net/mime_content_type
 */
function rc_mime_content_type($path, $name, $failover = 'application/octet-stream')
{
    $mime_type = null;
    $mime_magic = rcmail::get_instance()->config->get('mime_magic');
    $mime_ext = @include(RCMAIL_CONFIG_DIR . '/mimetypes.php');
    $suffix = $name ? substr($name, strrpos($name, '.')+1) : '*';

    // use file name suffix with hard-coded mime-type map
    if (is_array($mime_ext)) {
        $mime_type = $mime_ext[$suffix];
    }
    // try fileinfo extension if available
    if (!$mime_type) {
        if (!extension_loaded('fileinfo')) {
            @dl('fileinfo.' . PHP_SHLIB_SUFFIX);
        }
        if (function_exists('finfo_open')) {
            if ($finfo = finfo_open(FILEINFO_MIME, $mime_magic)) {
                $mime_type = finfo_file($finfo, $path);
                finfo_close($finfo);
            }
        }
    }
    // try PHP's mime_content_type
    if (!$mime_type && function_exists('mime_content_type')) {
      $mime_type = mime_content_type($path); 
    }
    // fall back to user-submitted string
    if (!$mime_type) {
        $mime_type = $failover;
    }

    return $mime_type;
}

/**
 * A method to guess encoding of a string.
 *
 * @param string $string     	String.
 * @param string $failover 	Default result for failover.
 *
 * @return string
 */
function rc_detect_encoding($string, $failover='')
{
    if (!function_exists('mb_detect_encoding')) {
        return $failover;
    }

    // FIXME: the order is important, because sometimes 
    // iso string is detected as euc-jp and etc.
    $enc = array(
      'UTF-8', 'SJIS', 'BIG5', 'GB2312',
      'ISO-8859-1', 'ISO-8859-2', 'ISO-8859-3', 'ISO-8859-4',
      'ISO-8859-5', 'ISO-8859-6', 'ISO-8859-7', 'ISO-8859-8', 'ISO-8859-9',
      'ISO-8859-10', 'ISO-8859-13', 'ISO-8859-14', 'ISO-8859-15', 'ISO-8859-16',
      'WINDOWS-1252', 'WINDOWS-1251', 'EUC-JP', 'EUC-TW', 'KOI8-R', 
      'ISO-2022-KR', 'ISO-2022-JP'
    );

    $result = mb_detect_encoding($string, join(',', $enc));

    return $result ? $result : $failover;
}

/**
 * Removes non-unicode characters from input
 *
 * @param mixed $input String or array.
 * @return string
 */
function rc_utf8_clean($input)
{
  // handle input of type array
  if (is_array($input)) {
    foreach ($input as $idx => $val)
      $input[$idx] = rc_utf8_clean($val);
    return $input;
  }
  
  if (!is_string($input) || $input == '')
    return $input;
  
  // iconv/mbstring are much faster (especially with long strings)
  if (function_exists('mb_convert_encoding') && ($res = mb_convert_encoding($input, 'UTF8', 'UTF8')))
    return $res;

  if (function_exists('iconv') && ($res = iconv('UTF8', 'UTF8//IGNORE', $input)))
    return $res;

  $regexp = '/^('.
//    '[\x00-\x7F]'.                                  // UTF8-1
    '|[\xC2-\xDF][\x80-\xBF]'.                      // UTF8-2
    '|\xE0[\xA0-\xBF][\x80-\xBF]'.                  // UTF8-3
    '|[\xE1-\xEC][\x80-\xBF][\x80-\xBF]'.           // UTF8-3
    '|\xED[\x80-\x9F][\x80-\xBF]'.                  // UTF8-3
    '|[\xEE-\xEF][\x80-\xBF][\x80-\xBF]'.           // UTF8-3
    '|\xF0[\x90-\xBF][\x80-\xBF][\x80-\xBF]'.       // UTF8-4
    '|[\xF1-\xF3][\x80-\xBF][\x80-\xBF][\x80-\xBF]'.// UTF8-4
    '|\xF4[\x80-\x8F][\x80-\xBF][\x80-\xBF]'.       // UTF8-4
    ')$/';
  
  $seq = '';
  $out = '';

  for ($i = 0, $len = strlen($input)-1; $i < $len; $i++) {
    $chr = $input[$i];
    $ord = ord($chr);
    // 1-byte character
    if ($ord <= 0x7F) {
      if ($seq)
        $out .= preg_match($regexp, $seq) ? $seq : '';
      $seq = '';
      $out .= $chr;
    // first (or second) byte of multibyte sequence
    } else if ($ord >= 0xC0) {
      if (strlen($seq)>1) {
	$out .= preg_match($regexp, $seq) ? $seq : '';
        $seq = '';
      } else if ($seq && ord($seq) < 0xC0) {
        $seq = '';
      }
      $seq .= $chr;
    // next byte of multibyte sequence
    } else if ($seq) {
      $seq .= $chr;
    }
  }

  if ($seq)
    $out .= preg_match($regexp, $seq) ? $seq : '';

  return $out;
}

/**
 * Explode quoted string
 * 
 * @param string Delimiter expression string for preg_match()
 * @param string Input string
 */
function rcube_explode_quoted_string($delimiter, $string)
{
  $result = array();
  $strlen = strlen($string);

  for ($q=$p=$i=0; $i < $strlen; $i++) {
    if ($string[$i] == "\"" && $string[$i-1] != "\\") {
      $q = $q ? false : true;
    } 
    else if (!$q && preg_match("/$delimiter/", $string[$i])) {
      $result[] = substr($string, $p, $i - $p);
      $p = $i + 1;
    }
  }
  
  $result[] = substr($string, $p);
  return $result;
}


/**
 * mbstring replacement functions
 */

if (!extension_loaded('mbstring'))
{
    function mb_strlen($str)
    {
	return strlen($str);
    }

    function mb_strtolower($str)
    {
        return strtolower($str);
    }

    function mb_strtoupper($str)
    {
        return strtoupper($str);
    }

    function mb_substr($str, $start, $len=null)
    {
        return substr($str, $start, $len);
    }

    function mb_strpos($haystack, $needle, $offset=0)
    {
        return strpos($haystack, $needle, $offset);
    }

    function mb_strrpos($haystack, $needle, $offset=0)
    {
        return strrpos($haystack, $needle, $offset);
    }
}

?>
