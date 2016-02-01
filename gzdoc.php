<?
/*
** Usage........:
**                 No space before the beginning of the first '<?' tag.
**                 ------------Start of file----------
**                 |<?
**                 | include('gzdoc.php'); 
**                 |?>
**                 |<HTML>
**                 |... the page ...
**                 |</HTML>
**                 |<?
**                 | gzdocout(); 
**                 |?>
**                 -------------End of file-----------
*/
ob_start(); 
ob_implicit_flush(0); 
function CheckCanGzip(){
    global $HTTP_ACCEPT_ENCODING; 
    if (headers_sent() || connection_aborted()){
        return 0; 
    }
    if (strpos($HTTP_ACCEPT_ENCODING,  'x-gzip') !== false) return "x-gzip"; 
    if (strpos($HTTP_ACCEPT_ENCODING, 'gzip') !== false) return "gzip"; 
    return 0; 
}
/* $level = compression level 0-9,  0=none,  9=max 
9-ый лвл нахуй не рекомендуется ставить ибо грузит сервер */

function GzDocOut($level=3, $debug=0)
{
    $ENCODING = CheckCanGzip(); 
    if ($ENCODING)
    {
        echo "\n<!-- Use compress $ENCODING -->\n"; 
        $Contents = ob_get_contents(); 
        ob_end_clean(); 
        if ($debug)
        {
            $s = "<center><font style='color:#C0C0C0;
                  font-size:9px; font-family:tahoma'>Not compress
                  length: ".strlen($Contents).";  "; 
            $s .= "Compressed length: ".
                   strlen(gzcompress($Contents, $level)).
                   "</font></center>"; 
            $Contents .= $s; 
        }
        header("Content-Encoding: $ENCODING"); 
        echo "\x1f\x8b\x08\x00\x00\x00\x00\x00"; 
        $Size = strlen($Contents); 
        $Crc = crc32($Contents); 
        $Contents = gzcompress($Contents, $level); 
        $Contents = substr($Contents,  0,  strlen($Contents) - 4); 
        echo $Contents; 
        echo pack('V', $Crc); 
        echo pack('V', $Size); 
        exit; 
    }
    else
    {
    	echo "\n<!-- not compressed -->\n"; 
        ob_end_flush(); 
        exit; 
    }
}
?>
