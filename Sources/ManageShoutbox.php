<?php
/**********************************************************************************
* ManageShoutbox.php                                                              *
***********************************************************************************
*                                                                                 *
* SMFPacks Shoutbox v1.0                                                          *
* Copyright (c) 2009-2010 by Makito and NIBOGO. All rights reserved.              *
* Powered by www.smfpacks.com                                                     *
* Created by Makito                                                               *
* Developed by NIBOGO for SMFPacks.com                                            *
*                                                                                 *
**********************************************************************************/

if (!defined('SMF'))
    die('Hacking attempt...');

function ManageShoutbox()
{
	global $txt, $context, $scripturl;

	isAllowedTo('admin_forum');
	adminIndex('shoutbox');

	if (loadLanguage('Shoutbox') == false)
		loadLanguage('Shoutbox', 'english');

	loadTemplate('ManageShoutbox');
	$context['page_title'] = $txt['sba_1'];

	$subActions = array(
		'settings' => 'ManageShoutbox_Settings',
		'settings2' => 'ManageShoutbox_Settings2',
	);

	$_REQUEST['sa'] = isset($_REQUEST['sa']) && isset($subActions[$_REQUEST['sa']]) ? $_REQUEST['sa'] : 'settings';

	$subActions[$_REQUEST['sa']]();
}

function ManageShoutbox_Settings()
{
	global $context, $db_prefix;

	// simple, load all settings
	$query = db_query("
				SELECT variable, value
				FROM {$db_prefix}shoutbox_settings", __FILE__, __LINE__);

	$context['shoutbox'] = array();
	while ($r = mysql_fetch_assoc($query))
		$context['shoutbox'][$r['variable']] = $r['value'];
	mysql_free_result($query);

	// ...
	$context['shoutbox_echo'] = array(
		'disable' => 'checkbox',
		'startHide' => 'checkbox',
		'',
		'backgroundColor' => 'text',
		'textColor' => 'text',
		'',
		'boxTitle' => 'text',
		'refreshShouts' => 'text',
		'startShouts' => 'text',
		'keepShouts' => 'text',
		'height' => 'text',
		'printClass' => 'text',
		'',
		'timeColor' => 'text',
		'timeFormat' => 'text',
		'',
		'maxMsgLenght' => 'text',
		'minMsgLenght' => 'text',
		'maxLinkLenght' => 'text',
		'fixLongWords' => 'text',
		'',
		'disableTags' => 'textarea',
		'faces' => 'textarea',
		'',
		'showActions' => 'textarea',
		'out_main' => 'textarea',
		'',
		'showform_down' => 'checkbox',
		'showmsg_down' => 'checkbox'	//start modified here, limit smileys for 1 shout	  $smileyLimit = $modSettings['smileyNumber']-2;	  $prev = substr_count($content, '[img') + substr_count($content, '[IMG');	  $tempmsg = doUBBC($content, true);		if (substr_count($tempmsg, '<img') > ($prev + $smileyLimit))			$content = 'No se admiten mas de 2 iconos  '.$smileyLimit;	   // end here
	);

	$context['sub_template'] = 'manageshoutbox_settings';
	$context['shoutbox_form'] = '?action=manageshoutbox;sa=settings2';
}

function ManageShoutbox_Settings2()
{
	global $func, $db_prefix;

	checkSession();

	$config = array(
		'disable' => 'checkbox',
		'startHide' => 'checkbox',

		'backgroundColor' => 'text',
		'textColor' => 'text',

		'boxTitle' => 'text',
		'refreshShouts' => 'text',
		'startShouts' => 'text',
		'keepShouts' => 'text',
		'height' => 'text',
		'printClass' => 'text',

		'timeColor' => 'text',
		'timeFormat' => 'text',

		'maxMsgLenght' => 'text',
		'minMsgLenght' => 'text',
		'maxLinkLenght' => 'text',
		'fixLongWords' => 'text',

		'disableTags' => 'textarea',
		'faces' => 'textarea',

		'showActions' => 'textarea',
		'out_main' => 'textarea',

		'showform_down' => 'checkbox',
		'showmsg_down' => 'checkbox'
	);

	foreach ($config as $s => $t)
	{
		if ($t == 'textarea' && isset($_POST[$s]))
			$_POST[$s] = str_replace("\n", ',', str_replace(array("\r", "\t", "<br />"), '', $_POST[$s]));

		if ($t == 'checkbox')
			$v = !isset($_POST[$s]) ? 0 : 1;
		else
			$v = !isset($_POST[$s]) ? 0 : addslashes($func['htmlspecialchars']($func['htmltrim'](stripslashes($_POST[$s])), ENT_QUOTES));

		if (!empty($v))
			// try to insert
			db_query("
				REPLACE INTO {$db_prefix}shoutbox_settings
				(variable, value) VALUES('$s', '$v')", __FILE__, __LINE__);
		else
			db_query("
				DELETE FROM {$db_prefix}shoutbox_settings
				WHERE variable = '$s' LIMIT 1", __FILE__, __LINE__);
	}

	redirectexit('action=manageshoutbox;sa=settings');
}

?>