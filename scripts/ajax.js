function fields(fieldName) 
{
	return document.getElementById(fieldName);
}
function showProgressBar() 
{
	var obj = fields("content")
	obj.innerHTML='<center><span class=usuallyb align=center><b>Загрузка...</b></span></center>';
}

var xmlHttp
function loadPage(str)
{ 
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	showProgressBar();
	var url="reader.php";
	url=url+"?otdel="+str;
	url=url+"&sid="+Math.random();
	xmlHttp.onreadystatechange=stateChanged;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	return false;
}


function loadMagic(str)
{ 
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	showProgressBar();
	var url="readermagic.php";
	url=url+"?otdel="+str;
	url=url+"&sid="+Math.random();
	xmlHttp.onreadystatechange=stateChanged;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	return false;
}

function loadArt(str)
{ 
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	showProgressBar();
	var url="readerart.php";
	url=url+"?otdel="+str;
	url=url+"&sid="+Math.random();
	xmlHttp.onreadystatechange=stateChanged;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	return false;
}

function loadInv(str)
{ 
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	showProgressBar();
	var url="readerinventar.php?act=inv";
	url=url+"&otdel="+str;
	url=url+"&sid="+Math.random();
	xmlHttp.onreadystatechange=stateChanged;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	return false;
}

function loadDuring(str)
{ 
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	showProgressBar();
	var url="readerduring.php";
	url=url+"?otdel="+str;
	url=url+"&sid="+Math.random();
	xmlHttp.onreadystatechange=stateChanged;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	return false;
}

function loadFiziki(str)
{ 
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	showProgressBar();
	var url="readerfiziki.php";
	url=url+"?otdel="+str;
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