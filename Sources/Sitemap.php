<?php
/**********************************************************************************
* Version 1.2.2 Sitemap.php                                                       *
***********************************************************************************
* Modification by:                Matt Zuba (http://www.mattzuba.com)			  *
* Copyright 2007 by:          AirRideTalk.com (http://www.airidetalk.com)		  *
***********************************************************************************
* This program is distributed in the hope that it is and will be useful, but      *
* WITHOUT ANY WARRANTIES; without even any implied warranty of MERCHANTABILITY    *
* or FITNESS FOR A PARTICULAR PURPOSE.                                            *
**********************************************************************************/

// No Direct Access!
if (!defined('SMF'))
	die('Hacking attempt...');

// Main function that determines what we will view
function ShowSiteMap() {
	global $context, $scripturl, $settings, $txt, $user_info, $db_prefix, $modSettings;

	// Set the page title
	$context['page_title'] = $txt['sitemap'];

	// Load the proper template
	loadtemplate('Sitemap');

	$context['linktree'][] = array(
		'url' => $scripturl . '?action=sitemap',
		'name' => $txt['sitemap'],
		'extra_before' => $settings['linktree_inline'] ? $txt[118] . ': ' : ''
	);
	
	// Get the total topics ($modSettings['totalTopics'] isn't reliable) and create the page index
	$request = db_query("
		SELECT t.ID_TOPIC
		FROM {$db_prefix}messages as m, {$db_prefix}topics as t, {$db_prefix}boards as b
		WHERE m.ID_MSG = t.ID_LAST_MSG
		AND b.ID_BOARD = m.ID_BOARD
		AND $user_info[query_see_board]
		LIMIT $modSettings[sitemap_topic_count]", __FILE__, __LINE__);
		
	// Fix our start value.  If its higher than the max topic count, set it to the max topic count (it'll be fixed below to the proper number)
	$_REQUEST['start'] = ($_REQUEST['start'] > $modSettings['sitemap_topic_count']) ? $modSettings['sitemap_topic_count'] : $_REQUEST['start'];
	
	$context['page_index'] = constructPageIndex($scripturl . '?action=sitemap', $_REQUEST['start'], mysql_num_rows($request), 100);
	if (strpos($_SERVER['QUERY_STRING'], 'start') === false)
		$context['page_index'] = str_replace('[<b>1</b>]', '<a class="navPages" href="' . $scripturl . '?action=sitemap;start=0">1</a>', $context['page_index']);

	// Check to see if we're viewing topics or the boards or xml sitemap
	if (isset($_REQUEST['xml']))
		XMLDisplay();
	else if (strpos($_SERVER['QUERY_STRING'], 'start') !== false)
		TopicDisplay(($_REQUEST['start']));
	else
		BoardDisplay();

}

function BoardDisplay() {
	global $context, $db_prefix, $user_info;

	// Set the right sub template
	$context['sub_template'] = 'Boards';
	$context['sitemap']['collapsible'] = array();

	// Get our information from the database
	$request = db_query("
		SELECT b.ID_BOARD, b.ID_PARENT, b.childLevel, b.name, b.description, b.numTopics, b.numPosts
		FROM {$db_prefix}boards as b
		WHERE $user_info[query_see_board]
		ORDER BY b.boardOrder", __FILE__, __LINE__);

	// And assign it to an array
	while ($row = mysql_fetch_assoc($request))
	{
		$context['sitemap']['board'][$row['ID_BOARD']] = array(
			'id' => $row['ID_BOARD'],
			'level' => $row['childLevel'],
			'has_children' => false,
			'name' => $row['name'],
			'description' => $row['description'],
			'numt' => $row['numTopics'],
			'nump' => $row['numPosts'],
		);
		
		// If we are a child, and the first at that, let the parent know that at least one of us exists!
		if(!empty($row['childLevel']) && $row['childLevel'] == '1') {
			$context['sitemap']['board'][$row['ID_PARENT']]['has_children'] = true;
			$context['sitemap']['collapsible'] = $context['sitemap']['collapsible'] + array($row['ID_PARENT'] => $row['ID_PARENT']);
		}
	}
	
	$context['sitemap']['collapsible'] = '\'parent' . implode('\', \'parent', $context['sitemap']['collapsible']) . '\'';
	
	// Free the result.
	mysql_free_result($request);

}

function TopicDisplay($start) {
	global $context, $db_prefix, $user_info, $scripturl, $modSettings;

	// Set the proper sub template
	$context['sub_template'] = 'Topics';
	
	$end = $modSettings['sitemap_topic_count'] - $start < 100 ? $modSettings['sitemap_topic_count'] - $start : 100;
	
	// Get the right information
	$request = db_query("
		SELECT m.ID_MSG, m.ID_TOPIC, t.numReplies, t.numViews, m.ID_BOARD,
		m.subject, mem.realName, t.ID_FIRST_MSG, b.name, m.posterName
		FROM {$db_prefix}messages as m, {$db_prefix}topics as t, {$db_prefix}boards as b, {$db_prefix}members as mem
		WHERE m.ID_MSG=t.ID_FIRST_MSG
		AND mem.id_member = m.id_member
		AND b.ID_BOARD = m.ID_BOARD
		AND $user_info[query_see_board]
		ORDER BY m.ID_TOPIC DESC
		LIMIT $start,$end", __FILE__, __LINE__);

	// Assign it to the array
	while ($row = mysql_fetch_assoc($request))
	{
			$context['sitemap']['topic'][] = array(
			'subject' => $row['subject'],
			'poster' => empty($row['realName']) ? $row['posterName'] : $row['realName'],
			'views' => $row['numViews'],
			'replies' => $row['numReplies'],
			'href' => $scripturl . '?topic=' . $row['ID_TOPIC'] . '.0',
			'board_name' => $row['name'],
			'board_href' => $scripturl . '?board=' . $row['ID_BOARD'] . '.0',
		);
	}

	// Free the result
	mysql_free_result($request);
}

function XMLDisplay() {
	global $db_prefix, $context, $user_info, $modSettings;

	$context['sub_template'] = 'XMLDisplay';

	// Setup the main forum url...
	$context['sitemap']['main'] = array('time' => date_iso8601());

	// Get our information from the database
	$request = db_query("
		SELECT b.ID_BOARD, m.posterTime
		FROM {$db_prefix}boards as b, {$db_prefix}messages as m
		WHERE m.ID_MSG = b.ID_LAST_MSG
		AND $user_info[query_see_board]
		ORDER BY m.posterTime DESC", __FILE__, __LINE__);

	// And assign it to an array
	while ($row = mysql_fetch_assoc($request))
	{
			$context['sitemap']['board'][] = array(
			'id' => $row['ID_BOARD'] . '.0',
			'time' => date_iso8601($row['posterTime']),
		);
	}

	// Free the result.
	mysql_free_result($request);

	// Get the right information
	$request = db_query("
		SELECT t.ID_TOPIC, m.posterTime
		FROM {$db_prefix}messages as m, {$db_prefix}topics as t, {$db_prefix}boards as b
		WHERE m.ID_MSG = t.ID_LAST_MSG
		AND b.ID_BOARD = m.ID_BOARD
		AND $user_info[query_see_board]
		ORDER BY m.posterTime DESC
		LIMIT $modSettings[sitemap_topic_count]", __FILE__, __LINE__);

	// Assign it to the array
	while ($row = mysql_fetch_assoc($request))
	{
			$context['sitemap']['topic'][] = array(
			'id' => $row['ID_TOPIC'] . '.0',
			'time' => date_iso8601($row['posterTime']),
		);
	}

	// Free the result
	mysql_free_result($request);
	
	// Pretty URLs need to be rewritten
	if (!empty($modSettings['pretty_enable_filters']) && $modSettings['pretty_enable_filters'] == 'on') {
		ob_start('ob_sessrewrite');
		$context['pretty']['search_patterns'][] = '~(<loc>)([^#<]+)~';
		$context['pretty']['replace_patterns'][] = '~(<loc>)([^<]+)~';
	}
}

function date_iso8601($timestamp = '') {
	$timestamp = empty($timestamp) ? time() : $timestamp;
	$gmt =  substr(date("O", $timestamp), 0, 3).':00';
	return date('Y-m-d\TH:i:s',$timestamp).$gmt;
}?>