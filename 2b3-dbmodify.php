<?php
// If SSI.php is in the same place as this file, and SMF isn't defined, this is being run standalone.
if (file_exists(dirname(__FILE__) . '/SSI.php') && !defined('SMF'))
        include_once(dirname(__FILE__) . '/SSI.php');
// Hmm... no SSI.php and no SMF?
elseif (!defined('SMF'))
        die('<b>Error:</b> Cannot install - please verify you put this in the same place as SMF\'s index.php.');

// Upgrade the database if necessary
db_extend('packages');

// Define each setting to be added
$newSetting['aeiou_initial_subject'] = '';	// To store a custom initial subject message for the email, if blank revert to use 
											// default txt string
$newSetting['aeiou_initial_message'] = '';	// To store a custom initial message, if blank revert to use default txt string
$newSetting['aeiou_final_subject'] = '';	// To store a custom final subject message for the email, if blank revert to use
											// default txt string
$newSetting['aeiou_final_message'] = '';	// To store a custom final message, if blank revert to use default txt string

// Cycle through array adding each new setting - if already exists, ignore
foreach ($newSetting as $key => $value)
	$smcFunc['db_insert']('ignore', '{db_prefix}settings', 
		array('variable' => 'string', 'value' => 'string'),
		array($key, $value),
		array('variable')
	);

// Add the scheduled task setting - if already exists, ignore
$smcFunc['db_insert']('ignore', '{db_prefix}scheduled_tasks',
	array('next_time' => 'int', 'time_offset' => 'int', 'time_regularity' => 'int', 
		'time_unit' => 'string', 'disabled' => 'int', 'task' => 'string'),
	array(0, 0, 1, 'd', 1, 'email_inactive'),
	array('id_task')
);

// Delete settings used by the SMF 1.1.x version
$delSetting[] = 'aeiou_enable';
$delSetting[] = 'aeiou_locktimestamp';
$delSetting[] = 'aeiou_hour_max';
$delSetting[] = 'aeiou_day_max';
$delSetting[] = 'aeiou_hour_sent';
$delSetting[] = 'aeiou_day_sent';
$delSetting[] = 'aeiou_chunksize';
$delSetting[] = 'aeiou_delete';
$delSetting[] = 'aeiou_underposts';
$delSetting[] = 'aeiou_stop';
$delSetting[] = 'aeiou_message';
$delSetting[] = 'aeiou_subject';
$delSetting[] = 'aeiou_lockkey';

// Cycle through array deleting each setting
$smcFunc['db_query']('', '
	DELETE FROM {db_prefix}settings
	WHERE variable IN ({array_string:variable})',
	array(
		'variable' => $delSetting
	)
);

// If we're using SSI, tell them we're done
if(SMF == 'SSI')
	echo 'Database changes for the AEIOU mod are complete!';

?>
