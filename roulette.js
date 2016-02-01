function ar(x1,y1,x2,y2,id,name)
{
  m=0.685;
  document.write("<AREA SHAPE=rect COORDS=\""+Math.round(x1*m)+","+Math.round(y1*m)+","+Math.round(x2*m)+","+Math.round(y2*m)+"\" HREF=\"javascript:bet("+id+",'"+name+"')\" alt=\""+name+"\">");
}
function xx(a,b) { return Math.floor(a+b*62.5); }
function yy(a,b) { return Math.floor(a+b*85); }
function buildtable()
{
ar(0,23,74,269,0,"ZERO");
for (i=0; i<3; i++)
{
  for (j=0; j<12; j++)
    ar(xx(86,j),yy(204,-i),xx(119,j),yy(256,-i),(j*3+i+1),(j*3+i+1));
  ar(836,yy(204,-i),869,yy(256,-i), 37+i, (i+1)+" ряд");
  ar(xx(86,i*4),280,xx(310,i*4),345, 40+i, (i+1)+" дюжина");
}
ar(86,370,182,430,43,"от 1 до 18");
ar(211,370,307,430,44,"чет");
ar(336,370,432,430,45,"красное");
ar(461,370,557,430,46,"черное");
ar(586,370,682,430,47,"нечет");
ar(711,370,807,430,48,"от 19 до 36");
for (j=0; j<12; j++)
{
  ar(xx(86,j),4,xx(119,j),34,49+j,(j*3+1)+"-"+(j*3+3));
  ar(xx(86,j),89,xx(119,j),119, 61+j, (j*3+2)+","+(j*3+3));
  ar(xx(86,j),174,xx(119,j),204,73+j,(j*3+1)+","+(j*3+2));
}
for (j=0; j<11; j++)
{
  for (i=0; i<3; i++)
    ar(xx(127,j),yy(43,i),xx(146,j),yy(84,i),85+(2-i)*11+j,(j*3-i+3)+","+(j*3-i+6));
  ar(xx(127,j),4,xx(146,j),34,118+j,(j*3+1)+"-"+(j*3+6));
  ar(xx(127,j),170,xx(146,j),205,129+j,(j*3+1)+","+(j*3+2)+","+(j*3+4)+","+(j*3+5));
  ar(xx(127,j),85,xx(146,j),120,140+j,(j*3+2)+","+(j*3+3)+","+(j*3+5)+","+(j*3+6));
}
}
currentbet=-1;
function bet(id, name)
{
  betto.style.display="block";
  betname.innerText=name;
  currentbet=id;
}
function timerfunc()
{
  lefttime--;
  if (lefttime<=0) window.location.href='?act=none&'+Math.random();
  leftsec=lefttime%60;
  leftmin=Math.floor(lefttime/60);
  if (leftsec<10) leftsec="0"+leftsec;
  timercl.innerText=leftmin+":"+leftsec;
  setTimeout("timerfunc()",1000);
}
function firstload()
{
  timerfunc();
}
function betclick()
{
  location.href='?bet='+betform.bet.value+'&betto='+currentbet+'&'+Math.random();
}
