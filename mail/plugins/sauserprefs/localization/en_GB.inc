<?php
/* Author: Philip Weir */

$labels = array();
$labels['sauserprefs']  = 'Spam';
$labels['sauserprefssettings']  = 'Spam settings';
$labels['spamgeneralsettings']  = 'General Settings';
$labels['spamthres']  = 'Score threshold';
$labels['spamsubject']  = 'Subject tag';
$labels['spamsubjectblank']  = '(leave blank for none)';
$labels['spamlang']  = 'Message languages';
$labels['enabled']  = 'Enabled';
$labels['disabled']  = 'Disabled';
$labels['headers'] = 'Message Headers';
$labels['foldheaders'] = 'Allow multiple lines in headers';
$labels['spamlevelstars'] = 'Use \'Spam Level\' header';
$labels['spamlevelchar'] = 'Spam level character';
$labels['spamtests'] = 'Internet Based Spam Tests';
$labels['userazor1'] = 'Use Razor v1';
$labels['userazor2'] = 'Use Razor v2';
$labels['usepyzor'] = 'Use Pyzor';
$labels['usebayes'] = 'Use Bayesian style classifier';
$labels['usedcc'] = 'Use DCC';
$labels['skiprblchecks'] = 'Use Realtime Blackhole List';
$labels['spamreportsettings']  = 'Report Settings';
$labels['spamreport0']  = 'Include report in headers of original message';
$labels['spamreport1']  = 'Include original as MIME attachment to report';
$labels['spamreport2']  = 'Include original as text-only attachment to report';
$labels['spamaddressrules']  = 'Address Rules';
$labels['whitelist_from']  = 'Accept Mail From';
$labels['blacklist_from']  = 'Reject Mail From';
$labels['whitelist_to']  = 'Accept Mail Sent To';
$labels['addrule']  = 'Add Rule';
$labels['rule']  = 'Rule';
$labels['importfromaddressbook'] = 'Import addresses from Address Book';
$labels['deleteall'] = 'Delete All';
$labels['autoscore'] = 'Auto';
$labels['defaultscore'] = 'Default Score';
$labels['otherscore'] = 'Other (%s)';
$labels['usedefault'] = 'Restore Default Settings';
$labels['langoptions'] = 'Language Options';
$labels['bayes'] = 'Bayes Settings';
$labels['purgingbayes'] = 'Deleting Bayesian data...';
$labels['purgebayes'] = 'Delete personal Bayesian data';
$labels['bayesautolearn'] = 'Use Bayes auto learn';
$labels['bayesautooptions'] = 'Auto learn options';
$labels['bayesnonspam'] = 'Non spam threshold';
$labels['bayesspam'] = 'Spam threshold';
$labels['bayesrules'] = 'Use Baysian rules';
$labels['help']  = 'Help';

$messages = array();
$messages['sauserprefchanged'] = 'Successfully changed spam settings';
$messages['sauserpreffailed'] = 'Error: Cannot change spam settings';
$messages['spamthresexp'] = 'Anything above the threshold is marked as spam. Increasing this threshold will increase the amount of spam missed, but will reduce the risk of false positives.';
$messages['spamlangexp'] = 'Select all the languages you expect to receive e-mail in. Any messages received that are written in non selected languages will be treated as possible spam.';
$messages['headersexp'] = 'SpamAssassin adds headers to processed messages providing information about the results. Use the options below to configure these headers.';
$messages['spamtestssexp'] = 'Some checks use internet based services to help identify spam. Select the ones you wish to use:';
$messages['spamreport']  = 'When a message is identified as spam a report of all tests and scores assigned is created...';
$messages['autowhitelist'] = 'Email addresses in your Address Book are automatically added to the \'Accept Mail From\' list.';
$messages['whitelistexp'] = 'An asterisk (*) can be used as a wild card for greater flexibility. For example: *@example.com or *@*.example.com.';
$messages['spamaddressexists'] = 'A rule already exists for this address';
$messages['spamenteraddress'] = 'Please enter an address to add';
$messages['spamaddresserror'] = 'Error: Address appears invalid';
$messages['spamaddressdelete'] = 'Are you sure you want to delete this rule?';
$messages['spamaddressdeleteall'] = 'Are you sure you want to delete all address rules?';
$messages['noaddressrules'] = 'No address rules found.';
$messages['importingaddresses'] = 'Importing addresses...';
$messages['usedefaultconfirm'] = 'Are you sure you want to restore the default settings? This will delete all your settings, including your address rules.';
$messages['purgebayesexp'] = 'Delete personal Bayesian data collected from your email';
$messages['bayesnonspamexp'] = 'Messages which score below this threshold will be use to improve the systems detection of non spam messages.';
$messages['bayesspamexp'] = 'Messages which score above this threshold will be use to improve the systems detection of spam messages.';
$messages['bayesautohelp'] = 'When Bayes auto learn is enabled the system will automatically process messages which are very likely to be spam/non spam and use the information from those to improve the detection filters.';
$messages['bayeshelp'] = 'The Bayesian classifier tries to identify spam by looking at words or short character sequences that are commonly found in spam or non spam messages.';
$messages['rblhelp'] = 'Server addresses found in hypertext links in a message will be checked against several \'blacklists\' or lists of known spam sources.';
$messages['dcchelp'] = 'The DCC or Distributed Checksum Clearinghouse is a system of servers collecting and counting checksums (or signatures) of millions of mail messages every day. The greater the similarity the checksum of an incoming message has to the list the more likely it is to be spam.';
$messages['pyzhelp'] = 'Pyzor is a collaborative, networked system to detect and block spam using identifying digests of messages. The digests are generated in a number of different ways to allow for small differences in the content of the message.';
$messages['raz2help'] = 'Vipul\'s Razor is a distributed, collaborative, spam detection and filtering network based on user submissions of spam. Detection is done with signatures that efficiently spot mutating spam content. The spam reports are validated through reputation assignments given to each reporter.';
$messages['raz1help'] = 'Vipul\'s Razor is a distributed, collaborative, spam detection and filtering network based on user submissions of spam. Detection is done with signatures that efficiently spot mutating spam content. The spam reports are validated through reputation assignments given to each reporter. Version 1 has now been replaced by version 2 and is no longer supported.';
$messages['levelhelp'] = 'The \'Spam Level\' header can be added to a message to indicate the score given to a message by repeating the character specified that many times. This may be useful for further processing of the message.';
$messages['foldhelp'] = 'Should headers added by SpamAssassin will be wrapped? In other words, should they be broken up into multiple lines instead of one very long one. When a line is broken it will be indented to mark it as a continuation of the preceding one.';
$messages['bayesruleshlp'] = 'Before the Bayesian-style classifier can be used effectively it must be "trained" to properly detect spam/non spam messages. Disabling the Bayesian rules allows the system to continue to learn both automatically and manually from incoming mail but it will not be used to detect spam.';
$messages['purgebayesconfirm'] = 'Are you sure delete all your Bayesian data?';

?>