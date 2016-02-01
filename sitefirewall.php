<?
function isspamprogram($agent)
{
	$agentslist="CherryPicker,Crescent Internet ToolPak,ExtractorPro,EmailCollector,EmailSiphon,EmailWolf,Mozilla/2.0 (compatible; NEWT ActiveX; Win32)";
	$agentsarray=split(",", $agentslist);
	if($agent=="") return true;
	$isp=false;
	for($i=0;$i<count($agentsarray);$i++)
	{
		if(stristr($agent, $agentsarray[$i]))
		{
			$isp=true;
			last;
		}
 	}
	return $isp;
}

$browseragent=getenv("HTTP_USER_AGENT");
$userip=getenv("REMOTE_ADDR");
$thedate=date("l")." ".date("F")." ".date("j")." ".date("Y")." - ".date("g").":".date("i").":".date("s")." ".date("A");
$requestedpage=getenv("SCRIPT_NAME");
$requestedpage=substr($requestedpage, 1, strlen($requestedpage)-1);
$iparray3=explode(".", $userip);
$locksite=false;
if(isspamprogram($browseragent))
{
	$locksite=true;
	$thealert="Spam program blocked";
}
if(!$locksite)
{
	$iplist=fopen("blockedips.txt", "r");
	while(!feof($iplist))
	{
		$currip=fgetcsv($iplist, 1024, "-");
		if(trim($currip[0])!="")
		{
			if(count($currip)>1)
			{
				$iparray1=explode(".", trim($currip[0]));
				$iparray2=explode(".", trim($currip[1]));
				$cnt=0;
				for($i=0;$i<4;$i++)
				{
					if($iparray3[$i]<=$iparray2[$i] && $iparray3[$i]>=$iparray1[$i]) $cnt++;
				}
				if($iparray3[0]<$iparray2[0] && $iparray3[0]>=$iparray1[0]) $cnt=4;
				if($cnt==4)
				{
					$thealert="IP address blocked";
					$locksite=true;
					last;
				}
 			}
			else
			{
				if($currip[0]==$userip)
				{
					$thealert="IP address blocked";
					$locksite=true;
					last;
				}
 			}
  		}
   }
fclose($iplist);
}
if($locksite)
{
	$logfile=fopen("log.csv", "a");
	fputs($logfile,"$thealert,$thedate,$browseragent,$userip,$requestedpage\r\n");
	fclose($logfile);
	header("Location: blank.htm");
}
?>
<script language="JavaScript">
<!--
//Get browser name
var nav=navigator.appName;
//Determine whether browser is Internet Explorer or Netscape
var ie=(nav.indexOf("Microsoft")!=-1);
var ns=(nav.indexOf("Netscape")!=-1);

//Disables right click in IE
	function nrcIE()
	{
		return false;
	}
	
	//Disables right click in NS versions 4 and up
	function nrcNS(e)
	{
	//Check if mouse button pressed is the right one
		if(e.which==2 || e.which==3)
		{
			return false;
		}
 	}

	//If browser is IE, set the right click event to don't show the context menu when clicking
	if(ie)
	{
		document.oncontextmenu=nrcIE;
	}

//If browser is NS4, capture the right click event and set it to don't show the context menu when clicking
if(ns){
if(document.layers){
document.captureEvents(Event.MOUSEDOWN);
document.onmousedown=nrcNS;
}

//If browser is NS6 capture the right click event and set it to don't show the context menu when clicking
if(document.getElementById){
document.onmouseup=nrcNS;
}
 }

//Disable drag & drop
document.ondragstart=new Function("return false;");

//Disable text selecting and copy-paste functions
document.onselectstart=new Function("return false;");

//Disables showing URL of links in status bar, it works by showing a custom message in the statusbar when the mouse is moving, you can customize the message to your own
document.onmousemove=new Function("window.status='';");

//Disable offline use by detecting whether the URL of the webpage is not an HTTP protocol
if(window.self.location.href.indexOf("http://")==-1) window.location="";

//Disable printing of page
if(document.all) window.onbeforeprint=new Function("window.location='';");

//Keep page out of frames
if(top.location!=self.location) top.location=self.location;

//This function clears the clipboard data (text or pictures)
function ccb()
{
	if(clipboardData){clipboardData.clearData();}
}

//This code triggers the interval for deleting clipboard contents and also it will set to don't show error messages in case of bugs with browser, so the it don't shows any alert of error
window.onerror=new Function("return true;");
setInterval("ccb();", 1000);
//-->
</script>

