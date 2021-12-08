<?php
/**********************************************************************************
* ModSettings.php                                                                 *
***********************************************************************************
* SMF: Simple Machines Forum                                                      *
* Open-Source Project Inspired by Zef Hemel (zef@zefhemel.com)                    *
* =============================================================================== *
* Software Version:           SMF 1.1                                             *
* Software by:                Simple Machines (http://www.simplemachines.org)     *
* Copyright 2006 by:          Simple Machines LLC (http://www.simplemachines.org) *
*           2001-2006 by:     Lewis Media (http://www.lewismedia.com)             *
* Support, News, Updates at:  http://www.simplemachines.org                       *
***********************************************************************************
* This program is free software; you may redistribute it and/or modify it under   *
* the terms of the provided license as published by Simple Machines LLC.          *
*                                                                                 *
* This program is distributed in the hope that it is and will be useful, but      *
* WITHOUT ANY WARRANTIES; without even any implied warranty of MERCHANTABILITY    *
* or FITNESS FOR A PARTICULAR PURPOSE.                                            *
*                                                                                 *
* See the "license.txt" file for details of the Simple Machines license.          *
* The latest version can always be found at http://www.simplemachines.org.        *
**********************************************************************************/
if (!defined('SMF'))
	die('Hacking attempt...');

/*	This file is here to make it easier for installed mods to have settings
	and options.  It uses the following functions:

	void ModifyFeatureSettings()
		// !!!

	void ModifyFeatureSettings2()
		// !!!

	void ModifyBasicSettings()
		// !!!

	void ModifyLayoutSettings()
		// !!!

	void ModifyKarmaSettings()
		// !!!

	Adding new settings to the $modSettings array:
	---------------------------------------------------------------------------
// !!!
*/

/*	Adding options to one of the setting screens isn't hard.  The basic format for a checkbox is:
		array('check', 'nameInModSettingsAndSQL'),

	   And for a text box:
		array('text', 'nameInModSettingsAndSQL')
	   (NOTE: You have to add an entry for this at the bottom!)

	   In these cases, it will look for $txt['nameInModSettingsAndSQL'] as the description,
	   and $helptxt['nameInModSettingsAndSQL'] as the help popup description.

	Here's a quick explanation of how to add a new item:

	 * A text input box.  For textual values.
	ie.	array('text', 'nameInModSettingsAndSQL', 'OptionalInputBoxWidth',
			&$txt['OptionalDescriptionOfTheOption'], 'OptionalReferenceToHelpAdmin'),

	 * A text input box.  For numerical values.
	ie.	array('int', 'nameInModSettingsAndSQL', 'OptionalInputBoxWidth',
			&$txt['OptionalDescriptionOfTheOption'], 'OptionalReferenceToHelpAdmin'),

	 * A text input box.  For floating point values.
	ie.	array('float', 'nameInModSettingsAndSQL', 'OptionalInputBoxWidth',
			&$txt['OptionalDescriptionOfTheOption'], 'OptionalReferenceToHelpAdmin'),
			
         * A large text input box. Used for textual values spanning multiple lines.
	ie.	array('large_text', 'nameInModSettingsAndSQL', 'OptionalNumberOfRows',
			&$txt['OptionalDescriptionOfTheOption'], 'OptionalReferenceToHelpAdmin'),

	 * A check box.  Either one or zero. (boolean)
	ie.	array('check', 'nameInModSettingsAndSQL', null, &$txt['descriptionOfTheOption'],
			'OptionalReferenceToHelpAdmin'),

	 * A selection box.  Used for the selection of something from a list.
	ie.	array('select', 'nameInModSettingsAndSQL', array('valueForSQL' => &$txt['displayedValue']),
			&$txt['descriptionOfTheOption'], 'OptionalReferenceToHelpAdmin'),
	Note that just saying array('first', 'second') will put 0 in the SQL for 'first'.

	 * A password input box. Used for passwords, no less!
	ie.	array('password', 'nameInModSettingsAndSQL', 'OptionalInputBoxWidth',
			&$txt['descriptionOfTheOption'], 'OptionalReferenceToHelpAdmin'),

	For each option:
		type (see above), variable name, size/possible values, description, helptext.
	OR	make type 'rule' for an empty string for a horizontal rule.
	OR	make type 'heading' with a string for a titled section. */

// This function passes control through to the relevant tab.

function ModifyFeatureSettings()
{
	global $context, $txt, $scripturl, $modSettings, $sourcedir;

	// You need to be an admin to edit settings!
	isAllowedTo('admin_forum');

	// All the admin bar, to make it right.
	adminIndex('edit_mods_settings');
	loadLanguage('Help');
	loadLanguage('ModSettings');

	// Will need the utility functions from here.
	require_once($sourcedir . '/ManageServer.php');

	$context['page_title'] = $txt['modSettings_title'];
	$context['sub_template'] = 'show_settings';

	$subActions = array(

		'aeiou' => 'ModifyAeiouSettings',		'basic' => 'ModifyBasicSettings',
		'layout' => 'ModifyLayoutSettings',
		'karma' => 'ModifyKarmaSettings',
		'profile' => 'ModifyProfileSettings',
	);

	// By default do the basic settings.
	$_REQUEST['sa'] = isset($_REQUEST['sa']) && isset($subActions[$_REQUEST['sa']]) ? $_REQUEST['sa'] : 'basic';
	$context['sub_action'] = $_REQUEST['sa'];

	loadLanguage('CustomProfile');
	// Load up all the tabs...
	$context['admin_tabs'] = array(
		'title' => &$txt['modSettings_title'],
		'help' => 'modsettings',
		'description' => $txt['smf3'],
		'tabs' => array(
			'basic' => array(
				'title' => $txt['mods_cat_features'],
				'href' => $scripturl . '?action=featuresettings;sa=basic;sesc=' . $context['session_id'],
			),
			'layout' => array(
				'title' => $txt['mods_cat_layout'],
				'href' => $scripturl . '?action=featuresettings;sa=layout;sesc=' . $context['session_id'],
			),
			'profile' => array(
				'title' => $txt['cp_cpfields'],
				'href' => $scripturl . '?action=featuresettings;sa=profile;sesc=' . $context['session_id'],
			),
			'karma' => array(
				'title' => $txt['smf293'],
				'href' => $scripturl . '?action=featuresettings;sa=karma;sesc=' . $context['session_id'],
			),
			'aeiou' => array(
				'title' => $txt['aeiou'],
				'href' => $scripturl . '?action=featuresettings;sa=aeiou;sesc=' . $context['session_id'],
				'is_last' => true,
			),
		),
	);

	// Select the right tab based on the sub action.
	if (isset($context['admin_tabs']['tabs'][$context['sub_action']]))
		$context['admin_tabs']['tabs'][$context['sub_action']]['is_selected'] = true;

	// Call the right function for this sub-acton.
	$subActions[$_REQUEST['sa']]();
}

// This function basically just redirects to the right save function.
function ModifyFeatureSettings2()
{
	global $context, $txt, $scripturl, $modSettings, $sourcedir;

	isAllowedTo('admin_forum');
	loadLanguage('ModSettings');

	// Quick session check...
	checkSession();

	require_once($sourcedir . '/ManageServer.php');

	$subActions = array(

		'aeiou' => 'ModifyAeiouSettings',		'basic' => 'ModifyBasicSettings',
		'layout' => 'ModifyLayoutSettings',
		'karma' => 'ModifyKarmaSettings',
		'profile' => 'ModifyProfileSettings',
	);

	// Default to core (I assume)
	$_REQUEST['sa'] = isset($_REQUEST['sa']) && isset($subActions[$_REQUEST['sa']]) ? $_REQUEST['sa'] : 'basic';

	// Actually call the saving function.
	$subActions[$_REQUEST['sa']]();
}

function ModifyBasicSettings()
{
	global $txt, $scripturl, $context, $settings, $sc, $modSettings;

	$config_vars = array(
			// Big Options... polls, sticky, bbc....
			array('select', 'pollMode', array(&$txt['smf34'], &$txt['smf32'], &$txt['smf33'])),
		'',
			// Basic stuff, user languages, titles, flash, permissions...
			array('check', 'allow_guestAccess'),
			array('check', 'userLanguage'),
			array('check', 'allow_editDisplayName'),
			array('check', 'allow_hideOnline'),
			array('check', 'allow_hideEmail'),
			array('check', 'guest_hideContacts'),
			array('check', 'titlesEnable'),
			array('check', 'enable_buddylist'),
			array('text', 'default_personalText'),
			array('int', 'max_signatureLength'),
			array('check', 'display_facebook_like'),
			array('check', 'display_facebook_like_all'),
		'',
			// Stats, compression, cookies.... server type stuff.
			array('text', 'time_format'),
			array('select', 'number_format', array('1234.00' => '1234.00', '1,234.00' => '1,234.00', '1.234,00' => '1.234,00', '1 234,00' => '1 234,00', '1234,00' => '1234,00')),
			array('float', 'time_offset'),
			array('int', 'failed_login_threshold'),
			array('int', 'lastActive'),
			array('check', 'trackStats'),
			array('check', 'hitStats'),
			array('check', 'enableErrorLogging'),
			array('check', 'securityDisable'),
		'',
			// Reactive on email, and approve on delete
			array('check', 'send_validation_onChange'),
			array('check', 'approveAccountDeletion'),
		'',
			// Option-ish things... miscellaneous sorta.
			array('check', 'allow_disableAnnounce'),
			array('check', 'disallow_sendBody'),
			array('check', 'modlog_enabled'),
			array('check', 'queryless_urls'),
		'',
			array('check', 'sitemap_xml'),
			array('int', 'sitemap_topic_count'),
			array('check', 'sitemap_collapsible'),
		'',
			// Width/Height image reduction.
			array('int', 'max_image_width'),
			array('int', 'max_image_height'),
		'',
			// Reporting of personal messages?
			array('check', 'enableReportPM'),
	);

	// Saving?
	if (isset($_GET['save']))
	{
		// Fix PM settings.
		$_POST['pm_spam_settings'] = (int) $_POST['max_pm_recipients'] . ',' . (int) $_POST['pm_posts_verification'] . ',' . (int) $_POST['pm_posts_per_hour'];
		$save_vars = $config_vars;
		$save_vars[] = array('text', 'pm_spam_settings');

		saveDBSettings($save_vars);

		writeLog();
		redirectexit('action=featuresettings;sa=basic');
	}

	// Hack for PM spam settings.
	list ($modSettings['max_pm_recipients'], $modSettings['pm_posts_verification'], $modSettings['pm_posts_per_hour']) = explode(',', $modSettings['pm_spam_settings']);
	$config_vars[] = array('int', 'max_pm_recipients');
	$config_vars[] = array('int', 'pm_posts_verification');
	$config_vars[] = array('int', 'pm_posts_per_hour');

	$context['post_url'] = $scripturl . '?action=featuresettings2;save;sa=basic';
	$context['settings_title'] = $txt['mods_cat_features'];

	prepareDBSettingContext($config_vars);
}

function ModifyLayoutSettings()
{
	global $txt, $scripturl, $context, $settings, $sc;

	$config_vars = array(
			// Compact pages?
			array('check', 'compactTopicPagesEnable'),
			array('int', 'compactTopicPagesContiguous', null, $txt['smf235'] . '<div class="smalltext">' . str_replace(' ', '&nbsp;', '"3" ' . $txt['smf236'] . ': <b>1 ... 4 [5] 6 ... 9</b>') . '<br />' . str_replace(' ', '&nbsp;', '"5" ' . $txt['smf236'] . ': <b>1 ... 3 4 [5] 6 7 ... 9</b>') . '</div>'),
		'',
			// Stuff that just is everywhere - today, search, online, etc.
			array('select', 'todayMod', array(&$txt['smf290'], &$txt['smf291'], &$txt['smf292'])),
			array('check', 'topbottomEnable'),
			array('check', 'onlineEnable'),
			array('check', 'enableVBStyleLogin'),
		'',
			// Pagination stuff.
			array('int', 'defaultMaxMembers'),
		'',
			// This is like debugging sorta.
			array('check', 'timeLoadPageEnable'),
			array('check', 'disableHostnameLookup'),
		'',
			// Who's online.
			array('check', 'who_enabled'),
	);

	// Saving?
	if (isset($_GET['save']))
	{
		saveDBSettings($config_vars);
		redirectexit('action=featuresettings;sa=layout');

		loadUserSettings();
		writeLog();
	}

	$context['post_url'] = $scripturl . '?action=featuresettings2;save;sa=layout';
	$context['settings_title'] = $txt['mods_cat_layout'];

	prepareDBSettingContext($config_vars);
}

function ModifyProfileSettings()
{
	global $sourcedir;
	require_once($sourcedir . '/CustomProfile.php');
	CustomFieldSettings();
}

function ModifyKarmaSettings()
{
	global $txt, $scripturl, $context, $settings, $sc;

	$config_vars = array(
			// Karma - On or off?
			array('select', 'karmaMode', explode('|', $txt['smf64'])),
		'',
			// Who can do it.... and who is restricted by time limits?
			array('int', 'karmaMinPosts'),
			array('float', 'karmaWaitTime'),
			array('check', 'karmaTimeRestrictAdmins'),
		'',
			// What does it look like?  [smite]?
			array('text', 'karmaLabel'),
			array('text', 'karmaApplaudLabel'),
			array('text', 'karmaSmiteLabel'),
	);

	// Saving?
	if (isset($_GET['save']))
	{
		saveDBSettings($config_vars);
		redirectexit('action=featuresettings;sa=karma');
	}

	$context['post_url'] = $scripturl . '?action=featuresettings2;save;sa=karma';
	$context['settings_title'] = $txt['smf293'];

	prepareDBSettingContext($config_vars);
}

function ModifyAeiouSettings()
{
	global $txt, $scripturl, $context, $settings, $sc, $db_prefix, $modSettings;

	// If the mod is enabled and we're not saving, query for mod status information
	if (!isset($_GET['save']) && $modSettings['aeiou_enable'])
	{
		// Current time
		$time = time();
		
		// Get the delete band
		$request = db_query("
			SELECT count(*)
			FROM {$db_prefix}members
			WHERE lastLogin < ". ($time - 1814400) ."
				AND aeiou_email < ". ($time - 1814400) ."
				AND aeiou_count > 1
				AND posts <= ". (int) $modSettings['aeiou_underposts']. "
		", __FILE__, __LINE__);
		list($deletion) = mysql_fetch_row($request);
		
		// Create an array for the bands, with default values of 0
		$temp = array(0 => 0, 1 => 0, 2 => (int) $deletion);
		
		// Tidy up
		unset($deletion);
		mysql_free_result($request);
		
		// Get the email bands
		$request = db_query("
			SELECT count(*) as no, aeiou_count
			FROM {$db_prefix}members
			WHERE dateRegistered < ". ($time - 1814400) ."
				AND lastLogin < ". ($time - 1814400) ."
				AND aeiou_email < ". ($time - 1814400) ."
				AND ID_GROUP != 1
				AND NOT FIND_IN_SET(1, additionalGroups)
				AND aeiou_count < 2
				AND is_activated < 10
				AND is_activated != 0
				AND is_activated != 4
			GROUP BY aeiou_count
			ORDER BY aeiou_count ASC
			", __FILE__, __LINE__);
		
		// No further emails, if not set already, stop the mod until tomorrow
		if(mysql_num_rows($request) == 0)
		{
			// If not already, tell the mod to stop
			if(!empty($modSettings['aeiou_stop']))
				aeiou_update(array('stop' => 1));
			// Change the variable for the remainder of this page
			$modSettings['aeiou_stop'] = 1;
		}
		else
		{
			// Store the bands in the array created earlier
			while($row = mysql_fetch_assoc($request))
				$temp[$row['aeiou_count']] = $row['no'];
			// Tidy up
			unset($row);
		
			// The mod is set as stopped, but we discovered some emails, so re-activate us
			if(!empty($modSettings['aeiou_stop']))
			{
				aeiou_update(array('stop' => 0));
				// Change the variable for the remainder of this page
				$modSettings['aeiou_stop'] = 0;
				$reactivated = 1;
			}
		}
		
		// Prepare rows for the stats table
		$items = array();
		
		// Last ran
		$items['aeiou_last_ran'] = ($modSettings['aeiou_locktimestamp'] == 0) ? $txt['aeiou_never'] : timeformat($modSettings['aeiou_locktimestamp'], true) ;

		$again = ($modSettings['aeiou_locktimestamp'] == 0) ? $time : $modSettings['aeiou_locktimestamp'];
		// But if reached daily limit or is stopped we will start/check again tomorrow
		if($modSettings['aeiou_day_max'] <= $modSettings['aeiou_day_sent'] || !empty($modSettings['aeiou_stop']))
		{
			$date = explode('-', date('Y-m-d', $again));
			$tomorrow = mktime(0, 0, 0, $date[1], $date[2], $date[0]) + (60*60*24);
			$items['aeiou_starts_again'] = timeformat($tomorrow, true);
			unset($date, $tomorrow);
		}
		elseif($modSettings['aeiou_hour_max'] <= $modSettings['aeiou_hour_sent'])
		{
			// Or reached hourly limit we will start/check again next hour
			$date = explode('-', date('Y-m-d-h', $again));
			$nexthour = mktime($date[3], 0, 0, $date[1], $date[2], $date[0]) + (60*60);
			$items['aeiou_starts_again'] = timeformat($nexthour, true);
			unset($date, $nexthour);
		}
		else
		// Else Can start again from previous + 5mins
			$items['aeiou_starts_again'] = timeformat($again + 300, true) ;

		// Emailed today with max in parenthesis
		$items['aeiou_sent_day'] = $modSettings['aeiou_day_sent']
			.' <span style="font-weight:normal;font-style:italic">('.$txt['aeiou_max'].': '.$modSettings['aeiou_day_max'].')</span>';
		// Emailed this hour with max in parenthesis
		$items['aeiou_sent_hour'] = $modSettings['aeiou_hour_sent']
			.' <span style="font-weight:normal;font-style:italic">('.$txt['aeiou_max'].': '.$modSettings['aeiou_hour_max'].')</span>';

		// Now setup the stats about no.s of email etc
		$items['aeiou_awaiting_total'] = $temp[0] + $temp[1];
		$items['aeiou_awaiting_initial_email'] = $temp[0];
		$items['aeiou_awaiting_final_email'] = $temp[1];
		$items['aeiou_awaiting_deletion'] = $temp[2] . (empty($modSettings['aeiou_delete']) ? ' <span style="color:red">'.$txt['aeiou_disabled'].'</span>' : '' ) ; 

		// Reasons for inactive			
		if(!empty($modSettings['aeiou_stop']))
			$status = $txt['aeiou_nofurtheremails'];
		elseif($modSettings['aeiou_day_max'] <= $modSettings['aeiou_day_sent'])
			$status = $txt['aeiou_reacheddailylimit'];
		elseif($modSettings['aeiou_hour_max'] <= $modSettings['aeiou_hour_sent'])
			$status = $txt['aeiou_reachedhourlylimit'];

		// Is the mod Active? (even if enabled, it might not be active)
		// If the mod was stopped, but on loading this page, we discovered more emails, show as re-activated
		if(!empty($reactivated))
			$status = '<span style="color:darkgreen">'.$txt['aeiou_reactivated'].'</span>';
		elseif(empty($status))
			$status = '<span style="color:darkgreen">'.$txt['aeiou_active'].'</span>';
		else
		// Inactive 
			$status = '<span style="color:maroon">'.$txt['aeiou_stopped'].'</span> - '. $status;
		
		// Header of the stats chunk and status
		$chunk = '<table cellpadding="1" cellspacing="0" border="0" width="100%" class="tborder">
		<tr class="titlebg"><td colspan="2">'.$txt['aeiou_status'].': '.$status.'</td></tr>';
		
		// Now build the chunk of html of our stats
		foreach($items as $string => $value)
		{
			// Less emphasis on the sub-totals
			$italic = ($string == 'aeiou_awaiting_initial_email' || $string == 'aeiou_awaiting_final_email') ? 1 : 0 ;
			// Add more rows to the existing chunk
			$chunk .= '<tr class="windowbg"><td'.($italic ? ' style="font-weight:normal;font-style:italic"' : '').' >'.$txt[$string].':</td><td'.($italic ? ' style="font-weight:normal;font-style:italic"' : '').'>'.$value.'</td></tr>';
		}	
		$chunk .= '</table><br />';
			
		// Now for the last 10 people emailed
		$request = db_query("
			SELECT ID_MEMBER, memberName, aeiou_email, aeiou_count
			FROM {$db_prefix}members
			WHERE aeiou_email != 0
			ORDER BY aeiou_email DESC
			LIMIT 10
			", __FILE__, __LINE__);
		
		$chunk2 = '<table cellpadding="1" cellspacing="0" border="0" width="100%" class="tborder">
		<tr class="titlebg"><td colspan="3">'.$txt['aeiou_last10emailed'].'</td></tr>';
		if(mysql_num_rows($request) == 0)
			$chunk2 .= '<tr class="windowbg"><td colspan="3">'.$txt['aeiou_never'].'</td></tr>';
		else
		{
			// Add each user as a row in the table
			while($row = mysql_fetch_assoc($request))
				$chunk2 .= '<tr class="windowbg"><td><a href="'.$scripturl.'?action=profile;u='.$row['ID_MEMBER'].'">'.$row['memberName'].'</a></td><td style="font-weight:normal;">'.timeformat($row['aeiou_email'], true).'</td><td style="font-weight:normal;">'. $txt['aeiou_'.( ($row['aeiou_count'] == 1) ? 'initial' : 'final' )].'</td></tr>';
		}
		$chunk2 .= '</table><br />';

	}
	else
		// If the mod is not enabled, don't show either as chunks.  use a space to prevent it being shown as a delimiter
		$chunk = $chunk2 = ' ';
	
	// Compile/Build some language strings/add to
	// Avoids using html in the language files
	$temp = array('initial_subject' => 'subject', 'initial_message' => 'message', 'final_subject' => 'subject', 'final_message' => 'message');
	$add = '<div class="smalltext">'.$txt['aeiou_email_desc1'].'<br />'.$txt['aeiou_email_desc2'].'<br />'.$txt['aeiou_email_desc3'].'</div>';
	foreach($temp as $a => $b)
	{
		// Add the descriptions to the txt string
		$txt['aeiou_'.$a] .= $add;
		// Use the default message if we don't have a custom one saved
		if(empty($modSettings['aeiou_'.$a]))
			$modSettings['aeiou_'.$a] = !empty($txt['aeiou_default_'.$b]) ? $txt['aeiou_default_'.$b] : '' ;
	}
	// Tidy up
	unset($temp, $add, $a);
	
	// More descriptions to add with html
	$temp = array('delete', 'underposts', 'hour_max', 'day_max', 'chunksize');
	foreach($temp as $a)
		$txt['aeiou_'.$a] .= '<div class="smalltext">'.$txt['aeiou_'.$a.'_desc'] .'</div>';
	
	// Now the warning chunk.  Comprises of 4 parts.
	$txt['aeiou_warning'] .= '<div class="smalltext">'. $txt['aeiou_warning2'] .'<br />'.$txt['aeiou_warning3'].'<br />'.$txt['aeiou_warning4'].'</div>';
	
	// The important array
	$config_vars = array(
		$chunk,
			array('check', 'aeiou_enable'),
			array('text', 'aeiou_initial_subject', '30" style="width:95%'),
			array('large_text', 'aeiou_initial_message', '5" style="width:95%'),
			array('text', 'aeiou_final_subject', '30" style="width:95%'),
			array('large_text', 'aeiou_final_message', '5" style="width:95%'),
		'',
			array('check', 'aeiou_delete'),
			array('int', 'aeiou_underposts'),
		'',
		$txt['aeiou_warning'],
			array('int', 'aeiou_hour_max'),
			array('int', 'aeiou_day_max'),
			array('int', 'aeiou_chunksize'),
		$chunk2,
	);
		
	// Saving?
	if (isset($_GET['save']))
	{
		saveDBSettings($config_vars);
		redirectexit('action=featuresettings;sa=aeiou');
	}

	$context['post_url'] = $scripturl . '?action=featuresettings2;save;sa=aeiou';
	$context['settings_title'] = $txt['aeiou_title'];

	prepareDBSettingContext($config_vars);
}
?>