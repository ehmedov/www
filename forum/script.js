function ins_smile()
{
	var element=document.getElementById('cp');
	element.style.visibility='visible';
}
function clearForm()
{
	if(confirm("Вы уверены что хотите очистить форму?"))
	{
		document.Add.name.value="";
		document.Add.mail.value="";
		document.Add.header.value="";
		document.Add.msg.value="";
	}
}

function clearForm_comment()
{
	if(confirm("Вы уверены что хотите очистить форму?"))
	{
		document.add_top.msg.value="";
		document.add_top.header.value="";
	}
}


function submitForm()
{
	if(document.Add.name.value=="" && document.Add.anonim.checked!=true){alert('Вы не ввели ваш логин!!!');}
	else if(document.Add.header.value==""){alert('Вы не ввели заголовок новости!!!');}
	else if(document.Add.msg.value==""){alert('Вы не ввели текст сообщения!!!');}
	else
	{
		document.Add.submit();
	}
}

function submitForm_comment()
{
	if(document.add_top.msg.value==""){alert('Вы не ввели текст сообщения!');}
	else
	{
		document.add_top.submit();
	}
}


function smile(name){
document.Add.msg.value+=name;
}

function storeCaret(text) {
    if (text.createTextRange) { text.caretPos = document.selection.createRange().duplicate(); }
}
function paste(s1, s2)
{
   
 if (document.getSelection) { alert("Под NN не работает!"); }
   if (document.selection) 
   {
		var str = document.selection.createRange();
		var s = document.add_top.comments.value;
		if (s1 == '//') 
		{
			if ((str.text != "") && (s.indexOf(str.text)<0)) 
			{
				var str2 = '> ';
				var j = 0;
				for(var i=0; i<str.text.length; i++) 
				{
					str2 += str.text.charAt(i); j++;
					if (str.text.charAt(i) == "\n") { str2 += "> "; j=0; }
					if ((j>55)&&(str.text.charAt(i) == ' ')) { str2 += "\n> "; j=0; }
				}
				document.add_top.comments.value = s+"<I>\n"+str2+"\n</I>\n";
			} 
			else 
			{
				alert("Не выделен текст!\nДля вставки цитаты, сначала выделите на странице нужный текст, а затем нажмите эту кнопку.");
			}
		} 
		else 
		{
			if ((str.text != "") && (s.indexOf(str.text)>=0)) 
			{
				if (str.text.indexOf(s1) == 0) {return '';}
				str.text = s1+str.text+s2;
			} 
			else 
			{
	        	if (document.add_top.comments.createTextRange && document.add_top.comments.caretPos) 
	        	{
	            	var caretPos = document.add_top.comments.caretPos;
	            	caretPos.text = s1+s2;
	        	} 
	        	else 
	        	{
	                document.add_top.comments.value = s+s1+s2;
	            }
			}
		}
	}
	document.add_top.comments.focus();
	return false;
}

function help(what){
if(what=='comment'){
alert("Поставленый флажок дает возможность посетителям комментировать эту новость.");
}
else if(what=='anonim'){
alert("Посетители не будут видеть логин автора этого сообщения.\nПри выбранном флажке логин вводить не обязательно.");
}
else if(what=='mail'){
alert("Если вы хотите, чтобы посетители видели Ваш e-mail\nвпишите его в это поле, иначе оставте поле пустым.");
}
else if(what=='login'){
alert("Введите в это поле ваш логин.");
}
else if(what=='msg'){
alert("В это поле вводиться текст сообщения.Использование HTML-тегов запрещено.\nИспользуйте смайлы и кнопки стиля, которые находяться в правой колонке.\nЖ-жирный шрифт\nК-курсив\nП-подчеркнутый\nURL-ссылка URL\nIMG-рисунок\nДля использования стилей выделите участок текста в поле \"Текст сообщения\"\nи нажмите нужную вам кнопку стиля.");
}
else if(what=='private'){
alert("При выбранном флажке эта новость будет добавлена в новости группы,иначе - в общие новости.");
}
else if(what=='forward'){
alert("Отправлять оповещение на ваш e-mail адресс при добавлении комментария.\nE-mail поле должно быть заполненно.");
}
else if(what=='offtop'){
alert("Поставить это сообщение в оффтоп, т.е. всегда отображать его над остальными сообщениями.");
}
else if(what=='attach'){
alert("Вы можете также прикрепить файл к вашему сообщению.\nРазмер файла не должен превышать 2.00 Мб.");
}
}