var no = 20; // snow number
var speed = 15; // smaller number moves the snow faster
var sp_rel = 1.4; //speed relevation
var snowflake1 = "img/snow/snow1.gif";
var snowflake2 = "img/snow/snow2.gif";
 
var i, doc_width, doc_height;

dx = new Array();
xp = new Array();
yp = new Array();
am = new Array();
stx = new Array();
sty = new Array();



function SetVariable(c) 
{
	dx[c] = 0;                  // set coordinate variables
	am[c] = Math.random()*15;         // set amplitude variables
	xp[c] = Math.random()*(doc_width-35) + 0 + am[c];  // set position variables
	yp[c] = 0;
	stx[c] = 0.02 + Math.random()/10; // set step variables
	sty[c] = 0.7 + Math.random();     // set step variables
}

function DrawWeather() 
{
	doc_width = document.body.clientWidth;
    doc_height = document.body.clientHeight;
    
    
	var div = '';
	for (i = 0; i < no; ++ i) 
	{  
		SetVariable(i);
		div += "<div id=\"dot"+ i +"\" style=\"POSITION: absolute; Z-INDEX: 30" + i +"; VISIBILITY: visible; TOP: " +0 + "px; LEFT: " +0 + "px;\"><img id=\"im"+ i +"\" src=\"" + (sty[i]<sp_rel ? snowflake2 : snowflake1 ) + "\" border=\"0\" alt=\"\"></div>";
	}
	
	document.getElementById('snow').innerHTML = div;	
	return 1;
}



function WeatherBegin() 
{  // IE main animation function
	
	for (i = 0; i < no; ++ i)
	 {  // iterate for every dot
		yp[i] += sty[i] < sp_rel ? sty[i]/2 : sty[i];
		if (yp[i] > doc_height-40) 
		{
			SetVariable(i);
			var im = document.all['im'+i];
			im.src = (sty[i] < sp_rel) ? snowflake2 : snowflake1;
		}
		dx[i] += stx[i];
		document.all["dot"+i].style.pixelTop = yp[i];
		document.all["dot"+i].style.pixelLeft = xp[i] +  am[i]*Math.sin(dx[i]);
	}
	setTimeout("WeatherBegin()", speed);
}

