<?php
/**********************************************************************************
* Subs-Shoutbox.php                                                               *
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

function Shoutbox_Load($action = null)
{
	global $shoutbox, $context, $sourcedir;

	// die
	if (Shoutbox_Settings('disable') != '')
		return $action;

	if ($action !== null)
	{
		$show = Shoutbox_Settings('showActions');
		if (!in_array(strtolower($action), explode(',', $show)))
			return $action;
	}
	$context['shoutbox'] = array();
	$context['shoutbox']['can_moderate'] = !$context['user']['is_guest'] && allowedTo(array('shoutbox_edit', 'shoutbox_delete', 'shoutbox_prune', 'shoutbox_ban'));
	$context['shoutbox']['banned'] = Shoutbox_isBanned();
	$context['shoutbox']['can_view'] = !$context['shoutbox']['banned'] && allowedTo('shoutbox_view');

	if (!$context['shoutbox']['can_view'] && !$context['shoutbox']['banned'])
	{
		unset($context['shoutbox']);
		return $action;
	}
	$context['shoutbox']['can_post'] = !$context['user']['is_guest'] && $context['shoutbox']['can_view'] && allowedTo('shoutbox_post');

	// load config, template and language :P
	if (loadLanguage('Shoutbox') == false)
		loadLanguage('Shoutbox', 'english');

	loadTemplate('Shoutbox');
	Shoutbox_Settings();

	// print from main?
	if (isset($shoutbox['out_main']) && in_array(strtolower($action), explode(',', $shoutbox['out_main'])))
		$context['shoutbox']['out_main'] = 1;

	// post features... if can't post, scape
	if (!$context['shoutbox']['can_post'])
		return $action;

	$context['shoutbox']['disabled'] = array();
	if (isset($shoutbox['disableTags']))
		foreach (explode(',', $shoutbox['disableTags']) as $s)
			$context['shoutbox']['disabled'][$s] = 1;

	if (!isset($context['shoutbox']['disabled']['smileys']))
	{
		$context['shoutbox']['smileys'] = Shoutbox_LoadSmileys();

		// no smileys, disable it
		if (empty($context['shoutbox']['smileys']['postform']))
			$context['shoutbox']['disabled']['smileys'] = 1;
	}

	return $action;
}

// use allowedTo('shoutbox_view') or allowedTo('shoutbox_post') before
// $shoutbox must be defined
function Shoutbox_isBanned()
{
	global $ID_MEMBER, $context, $txt, $db_prefix, $shoutbox;

	// shoutbox doesn't ban guest
	if ($context['user']['is_guest'] || $context['user']['is_admin'])
		return false;

	// we need this be faster...
	if (!empty($_SESSION['shoutbox_lastget']) && $_SESSION['shoutbox_lastget'] > $shoutbox['banUpadte'])
		return false;

	// if can moderate, can't be banned...
	if (allowedTo(array('shoutbox_edit', 'shoutbox_delete', 'shoutbox_prune', 'shoutbox_ban')))
		return false;

	$query = db_query("
		SELECT reason, banEnd
		FROM {$db_prefix}shoutbox_ban
		WHERE ID_MEMBER = $ID_MEMBER
		LIMIT 1", __FILE__, __LINE__);
	$row = mysql_fetch_assoc($query);
	mysql_free_result($query);

	if (empty($row))
		return false;

	if ($row['banEnd'] < time() && $row['banEnd'] != 0)
	{
		db_query("
			DELETE FROM {$db_prefix}shoutbox_ban
			WHERE ID_MEMBER = $ID_MEMBER
			LIMIT 1", __FILE__, __LINE__);
		return false;
	}

	// ban :(
	$_SESSION['shoutbox_lastget'] = null;
	$_SESSION['shoutbox_lastid'] = null;

	return array(
		'reason' => $row['reason'],
		'end' => ($row['banEnd'] == 0 ? $txt['sb_8'] : ($row['banEnd'] > 0 ? timeformat($row['banEnd']) : $txt[470]))
	);	
}

function Shoutbox_Settings($setting = null)
{
	global $shoutbox, $db_prefix;

	if ($setting !== null)
	{
		$setting = (string) $setting;

		// if $setting is defined
		$result = db_query("
					SELECT value
					FROM {$db_prefix}shoutbox_settings
					WHERE variable = '$setting'
					LIMIT 1", __FILE__, __LINE__);
		$r = mysql_fetch_row($result);
		mysql_free_result($result);

		// return empty value if not found
		return !empty($r[0]) ? $r[0] : '';
	}

	// redefine if exists :|
	$shoutbox = array();

	$result = db_query("SELECT variable, value FROM {$db_prefix}shoutbox_settings", __FILE__, __LINE__);
	while ($r = mysql_fetch_assoc($result))
		$shoutbox[$r['variable']] = $r['value'];
	mysql_free_result($result);
}

function Shoutbox_LoadSmileys()
{
	global $txt, $modSettings, $db_prefix;
	global $context, $settings, $user_info;

	if (isset($settings['use_default_images']) && $settings['use_default_images'] == 'defaults' && isset($settings['default_template'])) {
		$temp1 = $settings['theme_url'];
		$settings['theme_url'] = $settings['default_theme_url'];
		$temp2 = $settings['images_url'];
		$settings['images_url'] = $settings['default_images_url'];
		$temp3 = $settings['theme_dir'];
		$settings['theme_dir'] = $settings['default_theme_dir'];
	}

	$smileys = array(
		'postform' => array(),
		'popup' => array(),
	);

	if (empty($modSettings['smiley_enable']) && $user_info['smiley_set'] != 'none')
		$smileys['postform'][] = array(
			'smileys' => array(
				array('code' => ':)', 'filename' => 'smiley.gif', 'description' => $txt[287]),
				array('code' => ';)', 'filename' => 'wink.gif', 'description' => $txt[292]),
				array('code' => ':D', 'filename' => 'cheesy.gif', 'description' => $txt[289]),
				array('code' => ';D', 'filename' => 'grin.gif', 'description' => $txt[293]),
				array('code' => '>:(', 'filename' => 'angry.gif', 'description' => $txt[288]),
				array('code' => ':(', 'filename' => 'sad.gif', 'description' => $txt[291]),
				array('code' => ':o', 'filename' => 'shocked.gif', 'description' => $txt[294]),
				array('code' => '8)', 'filename' => 'cool.gif', 'description' => $txt[295]),
				array('code' => '???', 'filename' => 'huh.gif', 'description' => $txt[296]),
				array('code' => '::)', 'filename' => 'rolleyes.gif', 'description' => $txt[450]),
				array('code' => ':P', 'filename' => 'tongue.gif', 'description' => $txt[451]),
				array('code' => ':-[', 'filename' => 'embarrassed.gif', 'description' => $txt[526]),
				array('code' => ':-X', 'filename' => 'lipsrsealed.gif', 'description' => $txt[527]),
				array('code' => ':-\\', 'filename' => 'undecided.gif', 'description' => $txt[528]),
				array('code' => ':-*', 'filename' => 'kiss.gif', 'description' => $txt[529]),
				array('code' => ':\'(', 'filename' => 'cry.gif', 'description' => $txt[530])
			),
			'last' => true,
		);
	elseif ($user_info['smiley_set'] != 'none')
	{
		if (($temp = cache_get_data('posting_smileys', 480)) == null)
		{
			$request = db_query("
				SELECT code, filename, description, smileyRow, hidden
				FROM {$db_prefix}smileys
				WHERE hidden IN (0, 2)
				ORDER BY smileyRow, smileyOrder", __FILE__, __LINE__);
			while ($row = mysql_fetch_assoc($request))
			{
				$row['code'] = htmlspecialchars($row['code']);
				$row['filename'] = htmlspecialchars($row['filename']);
				$row['description'] = htmlspecialchars($row['description']);

				$smileys[empty($row['hidden']) ? 'postform' : 'popup'][$row['smileyRow']]['smileys'][] = $row;
			}
			mysql_free_result($request);

			cache_put_data('posting_smileys', $smileys, 480);
		}
		else
			$smileys = $temp;
	}

	foreach (array_keys($smileys) as $location)
	{
		foreach ($smileys[$location] as $j => $row)
		{
			$n = count($smileys[$location][$j]['smileys']);
			for ($i = 0; $i < $n; $i++)
			{
				$smileys[$location][$j]['smileys'][$i]['code'] = addslashes($smileys[$location][$j]['smileys'][$i]['code']);
				$smileys[$location][$j]['smileys'][$i]['js_description'] = addslashes($smileys[$location][$j]['smileys'][$i]['description']);
			}

			$smileys[$location][$j]['smileys'][$n - 1]['last'] = true;
		}
		if (!empty($smileys[$location]))
			$smileys[$location][count($smileys[$location]) - 1]['last'] = true;
	}
	$settings['smileys_url'] = $modSettings['smileys_url'] . '/' . $user_info['smiley_set'];

	if (isset($settings['use_default_images']) && $settings['use_default_images'] == 'defaults' && isset($settings['default_template']))
	{
		$settings['theme_url'] = $temp1;
		$settings['images_url'] = $temp2;
		$settings['theme_dir'] = $temp3;
	}

	return $smileys;
}

// only parse smileys
function Shoutbox_ParseSmileys($message)
{
	parsesmileys($message);

	return $message;
}

?>