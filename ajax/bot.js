var request;
var rezu="";
var ChatTimer;
var rez=0;

function createRequest() 
{
	try 
	{
		request = new XMLHttpRequest();
	} 
	catch (trymicrosoft) 
	{
		try 
		{
			request = new ActiveXObject("Msxml2.XMLHTTP");
		} 
		catch (othermicrosoft) 
		{
			try 
			{
				request = new ActiveXObject("Microsoft.XMLHTTP");
			} 
			catch (failed) 
			{
				request = false;
			}
		}
	}
	if (!request) alert("Ќе все игровые возможности доступны! ¬озможно вы используете браузер старой версии.");
}

function sendQuery(url) 
{
     createRequest();
     request.open("GET", url, true);
     request.onreadystatechange = Rezultat;
     request.send(null);
}

function Rezultat() 
{
	if (request.readyState == 4) 
	{
		if (request.status == 200) 
		{
			rezu = request.responseText;
		}
	}
}

function draw_text(bat) 
{	
	sendQuery("battext.php?bat="+bat);
}
function HitBot() 
{
  	sendQuery("bot_attack.php?bat_id="+bat+"&"+Math.random());
  	if (rezu=="battle1") 
  	{
		top.main.location.href="battle.php?tmp="+Math.random();
  	}
 	ChatTimer = setTimeout(HitBot, 5000);
}