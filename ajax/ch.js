function fields(fieldName) 
{
	return document.getElementById(fieldName);
}
function showProgressBar() 
{
	var obj = fields("content")
	obj.innerHTML='<center><img src=ajax/loader.gif></center>';
}

var xmlHttp
function loadText(bat)
{ 
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	showProgressBar();
	var url="chat_archive.php";
	url=url+"?file_name="+bat;
	url=url+"&sid="+Math.random();
	xmlHttp.onreadystatechange=stateChanged;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	return false;
}

function stateChanged() 
{ 
	if (xmlHttp.readyState==4)
	{	
		document.getElementById("content").innerHTML=xmlHttp.responseText;
	}
}

function GetXmlHttpObject()
{
	var xmlHttp=null;
	try
	  {
		  // Firefox, Opera 8.0+, Safari
		  xmlHttp=new XMLHttpRequest();
	  }
	catch (e)
	  {
		  // Internet Explorer
		  try
		    {
		    xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		    }
		  catch (e)
		    {
		    xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
		    }
	  }
	return xmlHttp;
}