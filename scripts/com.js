function draw_combat_info(legend, side){
  var s ='<img src="img/combats/1x1.gif" border=0 width="4" height=1>';
  if (!side) return;
  for (var i=1;i<=5;i++){
    s += '<img src="img/combats/'+((3+(side & 1))*10 + legend[i])+'.gif" alt="" width="10" height="12" border="0" align="bottom">';
  }
  return s;
}