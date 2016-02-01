<?php

/*
 +-----------------------------------------------------------------------+
 | MarkAsJunk2 configuration file                                        |
 |                                                                       |
 | This file is part of the RoundCube Webmail client                     |
 | Copyright (C) 2005-2009, RoundCube Dev. - Switzerland                 |
 | Licensed under the GNU GPL                                            |
 |                                                                       |
 +-----------------------------------------------------------------------+

*/

// Learning driver
// Use an external process auch as salearn to learn from spam/ham messages. Default: null.
// Current possibilities: 'cmd_learn', 'dir_learn', 'email_learn'
$rcmail_config['markasjunk2_learning_driver'] = 'cmd_learn';

// Mark messages as read when reporting them as spam
$rcmail_config['markasjunk2_read_spam'] = true;

// Mark messages as unread when reporting them as ham
$rcmail_config['markasjunk2_unread_ham'] = false;

// When reporting a message as ham, if the orginial message is attached (like with SpamAssassin reports),
// detach the orginial message and move that to the INBOX, deleteing the spam report
$rcmail_config['markasjunk2_detach_ham'] = true;

// Add flag to messages marked as spam (flag will be removed when marking as ham)
// If you do not want to use message flags set this to null
$rcmail_config['markasjunk2_spam_flag'] = 'Junk';

// Add flag to messages marked as ham (flag will be removed when marking as spam)
// If you do not want to use message flags set this to null
$rcmail_config['markasjunk2_ham_flag'] = null;

// Write output from spam/ham commands to the log for debug
$rcmail_config['markasjunk2_debug'] = false;

// cmd_learn Driver options
// ------------------------
// The command used to learn that a message is spam
// The command can contain the following macros that will be expanded as follows:
//      %u is replaced with the username (from the session info)
//      %l is replaced with the local part (before the @) of the username (from the session info)
//      %d is replaced with the domain part (after the @) of the username (from the session info)
//      %f is replaced with the path to the message file (THIS SHOULD ALWAYS BE PRESENT)
// If you do not want run the command set this to null
$rcmail_config['markasjunk2_spam_cmd'] = 'sa-learn --spam --no-sync --username=%u %f';

// The command used to learn that a message is ham
// The command can contain the following macros that will be expanded as follows:
//      %u is replaced with the username (from the session info)
//      %l is replaced with the local part (before the @) of the username (from the session info)
//      %d is replaced with the domain part (after the @) of the username (from the session info)
//      %f is replaced with the path to the message file (THIS SHOULD ALWAYS BE PRESENT)
// If you do not want run the command set this to null
$rcmail_config['markasjunk2_ham_cmd'] = 'sa-learn --ham --no-sync --username=%u %f';

// dir_learn Driver options
// ------------------------
// The full path of the directory used to store spam (must be writable by webserver)
$rcmail_config['markasjunk2_spam_dir'] = null;

// The full path of the directory used to store ham (must be writable by webserver)
$rcmail_config['markasjunk2_ham_dir'] = null;

// The filename prefix
// The filename can contain the following macros that will be expanded as follows:
//      %u is replaced with the username (from the session info)
//      %l is replaced with the local part (before the @) of the username (from the session info)
//      %d is replaced with the domain part (after the @) of the username (from the session info)
//      %t is replaced with the type of message (spam/ham)
$rcmail_config['markasjunk2_filename'] = null;

// email_learn Driver options
// --------------------------
// The email address that spam messages will be sent to
// If you do not want run the command set this to null
$rcmail_config['markasjunk2_email_spam'] = null;

// The email address that ham messages will be sent to
// If you do not want run the command set this to null
$rcmail_config['markasjunk2_email_ham'] = null;

// Should the spam/ham message be sent as an attachment
$rcmail_config['markasjunk2_email_attach'] = true;

// The email subject
// The subject can contain the following macros that will be expanded as follows:
//      %u is replaced with the username (from the session info)
//      %l is replaced with the local part (before the @) of the username (from the session info)
//      %d is replaced with the domain part (after the @) of the username (from the session info)
//      %t is replaced with the type of message (spam/ham)
$rcmail_config['markasjunk2_email_subject'] = 'learn this message as %t';

?>