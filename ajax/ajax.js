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
function RefreshBattle() 
{	
  	sendQuery("battle_ajax.php?"+Math.random());
  	if (rezu=="battle") 
  	{
  		try 
		{
			top.main.location.href="battle.php?tmp="+Math.random();
		}
		catch(err) { }
  	}
  	else if (rezu=="katakomba") 
  	{
  		try 
		{
			top.main.location.href="main.php?act=none&tmp="+Math.random();
		}
		catch(err) { }
  	}
  	else if(rezu=="confirm_mine")
  	{	
  		try 
		{
  			top.main.location.href='zayavka.php?boy=phisic&tmp='+Math.random();
  		}
		catch(err) { }
  	}
  	else if(rezu=="confirm_opp")
  	{
  		try 
		{
  			top.main.location.href='zayavka.php?boy=phisic&tmp='+Math.random();
  		}
		catch(err) { }
  	}
  	else if(rezu=="battle_begin")
  	{
  		try 
		{
  			top.main.location.href='zayavka.php?boy=phisic&tmp='+Math.random();
  		}
		catch(err) { }
  	}
	else if(rezu=="group")
  	{
  		try 
		{
  			top.main.location.href='group_zayavka.php?tmp='+Math.random();
  		}
		catch(err) { }
  	}
  	else if(rezu=="haot")
  	{
  		try 
		{
  			top.main.location.href='haot.php?tmp='+Math.random();
  		}
		catch(err) { }
  	}
 	ChatTimer = setTimeout(RefreshBattle, 5000);
}