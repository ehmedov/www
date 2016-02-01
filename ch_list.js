document.onmousedown = t_nick;

function t_nick ()
{
  top.is_ctrl = window.event.ctrlKey;
  top.is_alt = window.event.altKey;
}

function ch_clear_ignor (nick)
{
  while (nick.indexOf ('=') >= 0) nick = nick.replace ('=', '%3D');
  while (nick.indexOf ('+') >= 0) nick = nick.replace ('+', '%2B');
  while (nick.indexOf ('#') >= 0) nick = nick.replace ('#', '%23');
  while (nick.indexOf (' ') >= 0) nick = nick.replace (' ', '%20');
  top.frames['ch_refr'].location='/ch.php?a=ign&s=0&u='+nick;
}
  
function reverse_alpha_sort (el1,el2)
{
  if (el1>el2) { return -1 }
  else if (el1<el2) { return 1 }
  else { return 0 }
}

function qsort_str(arr,first,last) {
 if (first<last) {
  point=arr[first].split(":")[0];
  i=first;
  j=last;
  while (i<j) {
   while ((arr[i].split(":")[0]<=point) && (i<last)) i++;
   while ((arr[j].split(":")[0]>=point) && (j>first)) j--;
   if (i<j) {
    temp=arr[i];
    arr[i]=arr[j];
    arr[j]=temp;
   }
  }
  temp=arr[first];
  arr[first]=arr[j];
  arr[j]=temp;
  qsort_str(arr,first,j-1);
  qsort_str(arr,j+1,last);
 }
}

function qsort_int(arr,first,last,h) {
 if (first<last) {
  point=parseInt(arr[first].split(":")[2]);
  i=first;
  j=last;
  while (i<j) {
   while ((h*parseInt(arr[i].split(":")[2])<=h*point) && (i<last)) i++;
   while ((h*parseInt(arr[j].split(":")[2])>=h*point) && (j>first)) j--;
   if (i<j) {
    temp=arr[i];
    arr[i]=arr[j];
    arr[j]=temp;
   }
  }
  temp=arr[first];
  arr[first]=arr[j];
  arr[j]=temp;
  qsort_int(arr,first,j-1,h);
  qsort_int(arr,j+1,last,h);
 }
}

function chatlist_build (sort_type)
{
  if (sort_type=='a_z') ChatListU.sort ();
  else if (sort_type=='z_a') ChatListU.sort (reverse_alpha_sort);
  else {

   if (sort_type=='0_33') {
    qsort_int(ChatListU,0,ChatListU.length-1,1);
   }
   else if (sort_type=='33_0') {
    qsort_int(ChatListU,0,ChatListU.length-1,-1);
   }

   f=0;
   fl=parseInt(ChatListU[f].split(":")[2]);
   for (i=1;i<ChatListU.length;i++) {
    n=i;
    nl=parseInt(ChatListU[i].split(":")[2]);
    if (fl!=nl) {
     qsort_str(ChatListU,f,n-1);
     f=n;
     fl=parseInt(ChatListU[f].split(":")[2]);
    }
    if (n==ChatListU.length-1) {
     qsort_str(ChatListU,f,n);
    }
   }
  }

  var ss;
  var sleeps;
  var nn_sec;
  var str_array;
  var sign_array;
  var altadd;

  for(var cou = 0; cou < ChatListU.length; cou++)
  {
    str_array = ChatListU[cou].split(":");

    var ss='';
    var sleeps='';
    var altadd='';
    var ign = '';
    var inj = '';
    var psg = '';
    var align = '';

    nn_sec = str_array[1];
    var login = str_array[1];
    while (nn_sec.indexOf('+')>=0) nn_sec = nn_sec.replace('+','%2B');
    if (login.indexOf ('<i>') > -1)
    {
      login = login.replace ('<i>', '');
      login = login.replace ('</i>', '');
      nn_sec = nn_sec.replace ('<i>', '');
      nn_sec = nn_sec.replace ('</i>', '');
    }

    if (str_array[3].length>1)
    {
      sign_array = str_array[3].split(";");
      if(sign_array[2].length>1)
        altadd=" ("+sign_array[2]+")";
      ss = "<img src=http://image.neverlands.ru/signs/"+sign_array[0]+" width=15 height=12 align=absmiddle alt=\""+sign_array[1]+altadd+"\">&nbsp;";
    }

    if(str_array[4].length>1)
      sleeps="<img src=http://image.neverlands.ru/signs/molch.gif width=15 height=12 border=0 alt=\""+str_array[4]+"\" align=absmiddle>";
    if (str_array[5] == '1')
      ign = "<a href=\"javascript:ch_clear_ignor('"+login+"');\"><img src=http://image.neverlands.ru/signs/ignor/3.gif width=15 height=12 border=0 alt=\"Снять игнорирование\"></a>";
    if (str_array[6] != '0')
      inj = "<img src=http://image.neverlands.ru/chat/tr4.gif width=15 height=12 border=0 alt=\""+str_array[6]+"\" align=absmiddle>";

     if (str_array[7] != '0')
     {
       var dilers = new Array ('', 'Дилер', '', '', '', '', '', '', '', '', '', 'Помощник дилера');
       psg = "<img src=http://image.neverlands.ru/signs/d_sm_"+str_array[7]+".gif width=15 height=12 align=absmiddle border=0 alt=\""+dilers[str_array[7]]+"\">&nbsp;";
     }
     if (str_array[8] != '0')
     {
       sign_array = str_array[8].split(";");
       align = "<img src=http://image.neverlands.ru/signs/"+sign_array[0]+" width=15 height=12 align=absmiddle border=0 alt=\""+sign_array[1]+"\">&nbsp";
     }
     else if (str_array[7] == '0')
       align = "<img src=http://image.neverlands.ru/1x1.gif width=15 height=12 align=absmiddle border=0 alt=\"\">&nbsp";
     
    document.write("<img src=http://image.neverlands.ru/1x1.gif width=5 height=0><a href=\"javascript:top.say_private('"+login+"')\"><img src=http://image.neverlands.ru/chat/private.gif width=11 height=12 border=0 align=absmiddle></a>&nbsp;"+psg+align+ss+"<a href=\"javascript:top.say_to('"+login+"')\"><font class=nickname><b>"+str_array[1]+"</b></a>["+str_array[2]+"]</font><a href=\"/pinfo.cgi?"+nn_sec+"\" target=_blank><img src=http://image.neverlands.ru/chat/info.gif width=11 height=12 border=0 align=absmiddle></a>"+sleeps+"&nbsp;"+ign+"&nbsp;"+inj+"<br>");
  }
}
