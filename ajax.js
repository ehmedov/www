var request;
var rezu="";
var ChatTimer;
var rez=0;

function createRequest() {
  try {
    request = new XMLHttpRequest();
  } catch (trymicrosoft) {
    try {
      request = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (othermicrosoft) {
      try {
        request = new ActiveXObject("Microsoft.XMLHTTP");
      } catch (failed) {
        request = false;
      }
    }
  }
  if (!request)
    alert("Error initializing XMLHttpRequest!");
}

function sendQuery(url) {
     createRequest();
     request.open("GET", url, true);
     request.onreadystatechange = Rezultat;
     request.send(null);
}

function Rezultat() {
     if (request.readyState == 4) {
       if (request.status == 200) {
         rezu = request.responseText;
       } else
         alert("status is "+request.status);
     }
}

function Attack() {
  sendQuery("bot_attack.php");
  //alert(rezu);
  if (rezu=="attack")
  	 window.location.reload();
     //top.frames['main'.id_person].location='battle.php';
  ChatTimer = setTimeout(Attack, 30000);
}