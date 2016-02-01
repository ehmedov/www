function postmess(str) {
	tmp = parent.talk.document.talker.phrase.value;
	parent.talk.document.talker.phrase.value = str + tmp;
	parent.talk.document.talker.phrase.focus();
}
function posttime(str) {
	parent.talk.document.talker.phrase.value += '(см. ' + str + ') ';
	parent.talk.document.talker.phrase.focus();
}
