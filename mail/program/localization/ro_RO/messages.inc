<?php

/*
+-----------------------------------------------------------------------+
| language/ro_RO/messages.inc                                           |
|                                                                       |
| Language file of the RoundCube Webmail client                         |
| Copyright (C) 2005-2009, RoundCube Dev. - Switzerland                 |
| Licensed under the GNU GPL                                            |
|                                                                       |
+-----------------------------------------------------------------------+
| Author: Daniel Anechitoaie - danieLs <daniels@safereaction.ro>        |
|         Zeno Popovici <zeno.popovici at ulbsibiu.ro>                  |
|		  Cristian Nastase <cristian.nastase@itcaffe.net>				|
+-----------------------------------------------------------------------+

@version $Id: messages.inc 2994 2009-09-27 14:16:33Z yllar $

*/

$messages = array();
$messages['loginfailed'] = 'Autentificare eşuată';
$messages['cookiesdisabled'] = 'Browserul dumneavoastră nu acceptă cookies';
$messages['sessionerror'] = 'Sesiunea dumneavoastră este invalidă sau a expirat';
$messages['imaperror'] = 'Conectarea la serverul IMAP a eşuat';
$messages['servererror'] = 'Eroare de server!';
$messages['invalidrequest'] = 'Solicitare invalidă! Datele nu au fost salvate.';
$messages['nomessagesfound'] = 'Nu a fost găsit nici un mesaj în această căsuţă poştală';
$messages['loggedout'] = 'Sesiune încheiată cu succes. La revedere!';
$messages['mailboxempty'] = 'Căsuţa poştală este goală';
$messages['loading'] = 'Se încarcă...';
$messages['loadingdata'] = 'Se încarcă informaţiile...';
$messages['checkingmail'] = 'Se caută mesaje noi...';
$messages['sendingmessage'] = 'Trimitere mesaj...';
$messages['messagesent'] = 'Mesajul a fost trimis cu succes!';
$messages['savingmessage'] = 'Salvare mesaj...';
$messages['messagesaved'] = 'Mesajul a fost salvat în Ciorne';
$messages['successfullysaved'] = 'Salvarea s-a efectuat cu succes';
$messages['addedsuccessfully'] = 'Contactul a fost adăugat cu succes în agendă';
$messages['contactexists'] = 'Mai există un contact cu această adresă de e-mail';
$messages['blockedimages'] = 'Pentru a vă proteja intimitatea, imaginile externe au fost blocate.';
$messages['encryptedmessage'] = 'Acesta este un mesaj criptat şi nu poate fi afişat. Ne pare rău.';
$messages['nocontactsfound'] = 'Nu s-a găsit nici un contact';
$messages['contactnotfound'] = 'Contactul solicitat nu a fost găsit.';
$messages['sendingfailed'] = 'Nu s-a reuşit trimiterea mesajului';
$messages['senttooquickly'] = 'Vă rugăm aşteptaţi $sec sec. înainte de a trimite acest mesaj';
$messages['errorsavingsent'] = 'A intervenit o eroare în timp ce se efectua salvarea mesajului trimis';
$messages['errorsaving'] = 'A intervenit o eroare în timp ce se efectua salvarea';
$messages['errormoving'] = 'Nu s-a putut muta mesajul';
$messages['errordeleting'] = 'Nu s-a putut şterge mesajul';
$messages['errormarking'] = 'Nu s-a putut marca mesajul';
$messages['deletecontactconfirm'] = 'Sunteţi sigur că doriţi să ştergeţi contactul(ele) selectate?';
$messages['deletemessagesconfirm'] = 'Chiar doriţi să ştergeţi mesajele selectate ?';
$messages['deletefolderconfirm'] = 'Sunteţi sigur că doriţi să ştergeţi acest dosar?';
$messages['purgefolderconfirm'] = 'Sunteţi sigur că doriţi să ştergeţi toate mesajele din acest dosar?';
$messages['foldercreating'] = 'Se creează dosarul...';
$messages['folderdeleting'] = 'Se şterge dosarul...';
$messages['folderrenaming'] = 'Se redenumeşte dosarul...';
$messages['foldermoving'] = 'Se mută dosarul...';
$messages['formincomplete'] = 'Formularul nu a fost completat corect';
$messages['noemailwarning'] = 'Vă rugăm să introduceţi o adresă de e-mail validă';
$messages['nonamewarning'] = 'Vă rugăm să introduceţi un nume';
$messages['nopagesizewarning'] = 'Vă rugăm să introduceţi mărimea paginii';
$messages['nosenderwarning'] = 'Vă rugăm să introduceţi adresa expeditorului';
$messages['norecipientwarning'] = 'Vă rugăm să introduceţi cel puţin un destinatar';
$messages['nosubjectwarning'] = 'Mesajul nu are subiect. Vreţi să introduceţi unul acum?';
$messages['nobodywarning'] = 'Trimiteţi acest mesaj fără text?';
$messages['notsentwarning'] = 'Mesajul nu a fost trimis. Vreţi să renunţaţi la el?';
$messages['noldapserver'] = 'Vă rugăm să alegeţi un server ldap pentru căutare';
$messages['nocontactsreturned'] = 'Nu s-a găsit nici un contact';
$messages['nosearchname'] = 'Vă rugăm să introduceţi un nume de contact sau adresă de e-mail';
$messages['searchsuccessful'] = '$nr mesaje găsite';
$messages['searchnomatch'] = 'Căutarea nu a returnat nici un rezultat';
$messages['searching'] = 'Se caută...';
$messages['checking'] = 'Se verifică...';
$messages['nospellerrors'] = 'Nu s-a găsit nici-o greşeală de ortografie';
$messages['folderdeleted'] = 'Dosarul a fost şters cu succes';
$messages['deletedsuccessfully'] = 'Mesaj şters cu succes !';
$messages['converting'] = 'Resetez mesajul la parametrii iniţiali...';
$messages['messageopenerror'] = 'Nu s-a putut încărca mesajul din server';
$messages['fileuploaderror'] = 'Încărcarea pe server a eşuat';
$messages['filesizeerror'] = 'Fişierul încărcat depăşeşte mărimea de $size';
$messages['copysuccess'] = '$nr adrese s-au copiat cu succes';
$messages['copyerror'] = 'Nu s-a putut copia nici-o adresă';
$messages['sourceisreadonly'] = 'Sursa acestei adrese este "read-only"(se poate doar citi)';
$messages['errorsavingcontact'] = 'Nu s-a putut salva adresa de contact';
$messages['movingmessage'] = 'Mutare mesaj....';
$messages['receiptsent'] = 'Confirmarea de citire a fost trimisă cu succes';
$messages['errorsendingreceipt'] = 'Confirmarea nu a putut fi trimisă';
$messages['nodeletelastidentity'] = 'Nu puteţi şterge această identitate, este ultima.';
$messages['addsubfolderhint'] = 'Acest dosar va fi creat ca subdosar al celui selectat.';
$messages['forbiddencharacter'] = 'Numele dosarului conţine un caracter nepermis.';
$messages['selectimportfile'] = 'Va rugăm să selectaţi fişierul pentru încărcare';
$messages['addresswriterror'] = 'Agenda selectată nu poate fi actualizată';
$messages['importwait'] = 'Datele sunt importate, vă rugăm să aşteptaţi...';
$messages['importerror'] = 'Importul a eşuat! Fişierul încărcat nu este un fişier vCard valid.';
$messages['importconfirm'] = 'Contactele $inserted au fost importate cu succes, $skipped intrări au fost ignorate deoarece ele există deja:$names';
$messages['opnotpermitted'] = 'Operaţia nu este permisă!';
$messages['nofromaddress'] = 'Nu există o adresă de e-mail în identitatea selectată';
$messages['editorwarning'] = 'Trecerea în mod text a editorului va cauza pierderea formatării textului. Doriţi să continuaţi?';
$messages['httpreceivedencrypterror'] = 'Vă rugăm să luaţi legătura cu administratorul serverului de mail, deoarece există o eroare în configuraţia acestuia. Mesajul d-voastră nu a fost trimis.';
$messages['smtpconnerror'] = 'Eroare SMTP  ($code): Conexiunea cu serverul a eşuat';
$messages['smtpautherror'] = 'Eroare SMTP  ($code): Autentificare eşuată';
$messages['smtpfromerror'] = 'Eroare SMTP  ($code): Nu s-a putut seta expeditorul "$from"';
$messages['smtptoerror'] = 'Eroare SMTP  ($code): Nu s-a putut adăuga destinatarul "$to"';
$messages['smtprecipientserror'] = 'Eroare SMTP: Nu s-a putut procesa lista cu destinatari';
$messages['smtperror'] = 'Eroare SMTP: $msg';
?>