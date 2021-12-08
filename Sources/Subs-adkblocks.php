<?php
/********************************************************
* Adk Portal                   
* Version: 2.0
* Official support: http://www.smfpersonal.net           
* Founder & Developer: Lucas-ruroken
* Project Manager: ^Heracles^ - Enik
* 2009-2011
* Smf Personal - Home of adkportal
/**********************************************************/

if (!defined('SMF'))
	die('Hacking attempt...');

function columnleft()
{
	global $boarddir, $adkportal, $user_info;

	echo
	'<div id="adkportal_left">';
	
	if($adkportal['title_in_blocks'] == 6 && !empty($adkportal['left']))
		echo'
	<span class="clear upperframe"><span></span></span>
		<div class="roundframe">';

	if(empty($akdportal['left']))
		foreach ($adkportal['left'] AS $poster)
			adk_create_block($poster);
		
	
	if($adkportal['title_in_blocks'] == 6 && !empty($adkportal['left']))
	echo'
		</div>
	<span class="lowerframe"><span></span></span>';
	
	echo'
	</div>';
}


function columncenter()
{
	global $boarddir, $adkportal, $user_info;
	
	echo
	'<div id="adkportal_center">';
	
	if($adkportal['title_in_blocks'] == 6 && !empty($adkportal['center']))
		echo'
	<span class="clear upperframe"><span></span></span>
		<div class="roundframe">';

	if(!empty($adkportal['center']))
		foreach ($adkportal['center'] AS $poster)
			adk_create_block($poster);
	
	if($adkportal['title_in_blocks'] == 6 && !empty($adkportal['center']))
	echo'
		</div>
	<span class="lowerframe"><span></span></span>';
	
	echo'
	</div>';
	
}


function columnright()
{
	global $boarddir, $adkportal, $user_info;
	
	echo
	'<div id="adkportal_right">';
	
	if($adkportal['title_in_blocks'] == 6 && !empty($adkportal['right']))
		echo'
	<span class="clear upperframe"><span></span></span>
		<div class="roundframe">';

	if(!empty($adkportal['right']))
		foreach ($adkportal['right'] AS $poster)
			adk_create_block($poster);
	
	if($adkportal['title_in_blocks'] == 6 && !empty($adkportal['right']))
	echo'
		</div>
	<span class="lowerframe"><span></span></span>';
	
	echo'
	</div>';

}

function columntop()
{
	global $boarddir, $adkportal, $user_info;
	
	echo
	'<div id="adkportal_top">';
	
	if($adkportal['title_in_blocks'] == 6 && !empty($adkportal['top']))
		echo'
	<span class="clear upperframe"><span></span></span>
		<div class="roundframe">';

	if(!empty($adkportal['top']))
		foreach ($adkportal['top'] AS $poster)
			adk_create_block($poster);
	
	if($adkportal['title_in_blocks'] == 6 && !empty($adkportal['top']))
	echo'
		</div>
	<span class="lowerframe"><span></span></span>';
	
	echo'
	</div>';
}
function columnbottom()
{
	global $boarddir, $adkportal, $user_info;
	
	echo
	'<div id="adkportal_bottom">';
	
	if($adkportal['title_in_blocks'] == 6 && !empty($adkportal['bottom']))
		echo'
	<span class="clear upperframe"><span></span></span>
		<div class="roundframe">';
	
	if(!empty($adkportal['bottom']))
		foreach ($adkportal['bottom'] AS $poster)
			adk_create_block($poster);
	
	if($adkportal['title_in_blocks'] == 6 && !empty($adkportal['bottom']))
	echo'
		</div>
	<span class="lowerframe"><span></span></span>';
	
	echo'
	</div>';
	
}



/* Desde aqui comienzan todos los bloques, pèro esta vez en funciones :D*/
/* bienvenidos.php*/
function adk_bienvenidos()
{
	global $context;
	
	echo '
	<div class="text_align_center">
		',$context['random_news_line'],'
	</div>'; 
}


/* estadisticas.php*/
function adk_estadisticas()
{
	global $txt, $scripturl, $adkportal, $smcFunc, $boardurl, $modSettings;

	$totals = array(
		'members' => $modSettings['totalMembers'],
		'posts' => $modSettings['totalMessages'],
		'topics' => $modSettings['totalTopics']
	);

	$result = $smcFunc['db_query']('', '
		SELECT COUNT(*)
		FROM {db_prefix}boards',
		array(
		)
	);
	list ($totals['boards']) = $smcFunc['db_fetch_row']($result);
	$smcFunc['db_free_result']($result);

	$result = $smcFunc['db_query']('', '
		SELECT COUNT(*)
		FROM {db_prefix}categories',
		array(
		)
	);
	list ($totals['categories']) = $smcFunc['db_fetch_row']($result);
	$smcFunc['db_free_result']($result);
	
	$stats = array(
		'members' => array(
			'img' => 'user_suit.png',
			'class' => 'windowbg',
			'content' => $txt['total_members']. ': <a href="'. $scripturl . '?action=mlist" style="font-weight: bold;">'. comma_format($totals['members']). '</a>',
		),
		'posts' => array(
			'img' => 'vcard.png',
			'class' => 'windowbg2',
			'content' => $txt['total_posts']. ': '. comma_format($totals['posts']),
		),
		'topics' => array(
			'img' => 'photo.png',
			'class' => 'windowbg',
			'content' => $txt['total_topics']. ': '. comma_format($totals['topics']),
		),
		'cats' => array(
			'img' => 'package.png',
			'class' => 'windowbg2',
			'content' => $txt['total_cats']. ': '. comma_format($totals['categories']),
		),
		'boards' => array(
			'img' => 'book_open.png',
			'class' => 'windowbg',
			'content' => $txt['total_boards']. ': '. comma_format($totals['boards']),
		),
	);
	
	foreach($stats AS $stat)
		echo'
		<div class="'.$stat['class'].'">
			<img class="adk_vertical" alt="" src="'.$boardurl.'/adkportal/images/'.$stat['img'].'" />
			'.$stat['content'].'
		</div>';
			

	
}

/* login_logout.php*/
function adk_login_logout()
{
	global $context, $scripturl;
	global $txt;		
	
	if ($context['user']['is_guest'])
		echo '
		<div class="text_align_center">
			'.ssi_login().'<br />
				<a href="'.$scripturl.'?action=login">
					'.$txt['login'].'
				</a> '.$txt['or'].' 
				<a href="'.$scripturl.'?action=register">
					'.$txt['register'].'
				</a>
		</div>';
	else
	{
		echo '<div class="text_align_center">'.ssi_welcome();
		echo '<br />';
		echo ssi_logout().'</div>';
	}
}

/*menuforo.php*/
function adk_menuforo()
{
/*Function removed*/
}

function adk_menupersonal()
{

	global $context, $settings, $scripturl, $smcFunc, $boardurl, $adkportal, $txt;

	if($context['user']['is_logged'])
	{
		echo'
			<div class="text_align_center">
				'.$txt['hi_all'].', '.$context['user']['name'].'
			</div>';	
		
		if (!empty($context['user']['avatar']['image']))
			echo'<div style="text-align: center;">',$context['user']['avatar']['image'],'</div>';
		else
			echo'
			<div class="text_align_center">
				<img src="', $boardurl, '/adkportal/images/noavatar.jpg" class="adk_no_avatar" alt="avatar" />
			</div>';
		echo'<br />';
	}
	else
	{
		echo'
			<div class="text_align_center">
				'.$txt['hi_all'].', '.$txt['adk_guest'].'
			</div>';	
		
		
		echo'
			<div class="text_align_center">
				<img src="', $boardurl, '/adkportal/images/noavatar.jpg" class="adk_no_avatar" alt="avatar" />
			</div>';
			
		echo'<br />';
	}
	
	
	parseAdk_buttons(load_menu_personal());
}

/*menuprincipal.php*/

function adk_menuprincipal()
{
	//Parse My Buttons
	parseAdk_buttons(load_menu_principal());
			
}

//Simple block!
function adk_Smf_news()
{
	global $context;
	
	//I don't wanna use SSI :(
	echo '<div class="text_align_center">',$context['random_news'],'</div>'; 
}

function adk_random_image()
{
	global $smcFunc, $context, $txt;
	
	$sql = $smcFunc['db_query']('','
		SELECT url, image FROM {db_prefix}adk_advanced_images
		ORDER BY RAND() LIMIT {int:limit}',
		array(
			'limit' => 1,
		)
	);
	$row = $smcFunc['db_fetch_assoc']($sql);
	$smcFunc['db_free_result']($sql);
	
	$context['img'] = array(
		'url' => $row['url'],
		'image' => $row['image'],
	);
	
	if(empty($row['image']))
		echo'<div class="text_align_center"><strong>'.$txt['adk_none_images'].'</strong></div>';
	else
		echo'
		<div class="text_align_center">
			<a href="'.$context['img']['url'].'">
				<img src="'.$context['img']['image'].'" alt="" class="adk_advanced_image" />
			</a>
		</div>';
	
}	


function adk_whois()
{
	global $user_info, $txt, $sourcedir, $settings, $modSettings, $boardurl;

	require_once($sourcedir . '/Subs-MembersOnline.php');
	$membersOnlineOptions = array(
		'show_hidden' => allowedTo('moderate_forum'),
		'sort' => 'log_time',
		'reverse_sort' => true,
		);
		
	global $smcFunc, $context, $scripturl, $user_info, $adkportal;

	// The list can be sorted in several ways.
	$allowed_sort_options = array(
		'log_time',
		'real_name',
		'show_online',
		'online_color',
		'group_name',
	);
	// Default the sorting method to 'most recent online members first'.
	if (!isset($membersOnlineOptions['sort']))
	{
		$membersOnlineOptions['sort'] = 'log_time';
		$membersOnlineOptions['reverse_sort'] = true;
	}

	// Not allowed sort method? Bang! Error!
	elseif (!in_array($membersOnlineOptions['sort'], $allowed_sort_options))
		trigger_error('Sort method for getMembersOnlineStats() function is not allowed', E_USER_NOTICE);

	// Initialize the array that'll be returned later on.
	$membersOnlineStats = array(
		'users_online' => array(),
		'list_users_online' => array(),
		'online_groups' => array(),
		'num_guests' => 0,
		'num_spiders' => 0,
		'num_buddies' => 0,
		'num_users_hidden' => 0,
		'num_users_online' => 0,
	);

	// Get any spiders if enabled.
	$spiders = array();
	$spider_finds = array();
	if (!empty($modSettings['show_spider_online']) && ($modSettings['show_spider_online'] < 3 || allowedTo('admin_forum')) && !empty($modSettings['spider_name_cache']))
		$spiders = unserialize($modSettings['spider_name_cache']);

	// Load the users online right now.
	$request = $smcFunc['db_query']('', '
		SELECT
			lo.id_member, lo.log_time, lo.id_spider, mem.real_name, mem.member_name, mem.show_online,
			mg.online_color, mg.id_group, mg.group_name
		FROM {db_prefix}log_online AS lo
			LEFT JOIN {db_prefix}members AS mem ON (mem.id_member = lo.id_member)
			LEFT JOIN {db_prefix}membergroups AS mg ON (mg.id_group = CASE WHEN mem.id_group = {int:reg_mem_group} THEN mem.id_post_group ELSE mem.id_group END)',
		array(
			'reg_mem_group' => 0,
		)
	);
	while ($row = $smcFunc['db_fetch_assoc']($request))
	{
		if (empty($row['real_name']))
		{
			// Do we think it's a spider?
			if ($row['id_spider'] && isset($spiders[$row['id_spider']]))
			{
				$spider_finds[$row['id_spider']] = isset($spider_finds[$row['id_spider']]) ? $spider_finds[$row['id_spider']] + 1 : 1;
				$membersOnlineStats['num_spiders']++;
			}
			// Guests are only nice for statistics.
			$membersOnlineStats['num_guests']++;

			continue;
		}

		elseif (empty($row['show_online']) && empty($membersOnlineOptions['show_hidden']))
		{
			// Just increase the stats and don't add this hidden user to any list.
			$membersOnlineStats['num_users_hidden']++;
			continue;
		}

		// Some basic color coding...
		if (!empty($row['online_color']))
			$link = '<a title="'.$row['group_name'].' - '.$row['real_name'].'" href="' . $scripturl . '?action=profile;u=' . $row['id_member'] . '" style="color: ' . $row['online_color'] . ';">' . $row['real_name'] . '</a>';
		else
			$link = '<a title="'.$row['group_name'].' - '.$row['real_name'].'" href="' . $scripturl . '?action=profile;u=' . $row['id_member'] . '">' . $row['real_name'] . '</a>';

		// Buddies get counted and highlighted.
		$is_buddy = in_array($row['id_member'], $user_info['buddies']);
		if ($is_buddy)
		{
			$membersOnlineStats['num_buddies']++;
			$link = '<strong>' . $link . '</strong>';
		}

		// A lot of useful information for each member.
		$membersOnlineStats['users_online'][$row[$membersOnlineOptions['sort']] . $row['member_name']] = array(
			'id' => $row['id_member'],
			'username' => $row['member_name'],
			'name' => $row['real_name'],
			'group' => $row['id_group'],
			'href' => $scripturl . '?action=profile;u=' . $row['id_member'],
			'link' => $link,
			'is_buddy' => $is_buddy,
			'hidden' => empty($row['show_online']),
			'is_last' => false,
		);

		// This is the compact version, simply implode it to show.
		$membersOnlineStats['list_users_online'][$row[$membersOnlineOptions['sort']] . $row['member_name']] = empty($row['show_online']) ? '<em>' . $link . '</em>' : $link;

		// Store all distinct (primary) membergroups that are shown.
		if (!isset($membersOnlineStats['online_groups'][$row['id_group']]))
			$membersOnlineStats['online_groups'][$row['id_group']] = array(
				'id' => $row['id_group'],
				'name' => $row['group_name'],
				'color' => $row['online_color']
			);
	}
	$smcFunc['db_free_result']($request);

	// If there are spiders only and we're showing the detail, add them to the online list - at the bottom.
	if (!empty($spider_finds) && $modSettings['show_spider_online'] > 1)
		foreach ($spider_finds as $id => $count)
		{
			$link = $spiders[$id] . ($count > 1 ? ' (' . $count . ')' : '');
			$sort = $membersOnlineOptions['sort'] = 'log_time' && $membersOnlineOptions['reverse_sort'] ? 0 : 'zzz_';
			$membersOnlineStats['users_online'][$sort . $spiders[$id]] = array(
				'id' => 0,
				'username' => $spiders[$id],
				'name' => $link,
				'group' => $txt['spiders'],
				'href' => '',
				'link' => $link,
				'is_buddy' => false,
				'hidden' => false,
				'is_last' => false,
			);
			$membersOnlineStats['list_users_online'][$sort . $spiders[$id]] = $link;
		}

	// Time to sort the list a bit.
	if (!empty($membersOnlineStats['users_online']))
	{
		// Determine the sort direction.
		$sortFunction = empty($membersOnlineOptions['reverse_sort']) ? 'ksort' : 'krsort';

		// Sort the two lists.
		$sortFunction($membersOnlineStats['users_online']);
		$sortFunction($membersOnlineStats['list_users_online']);

		// Mark the last list item as 'is_last'.
		$userKeys = array_keys($membersOnlineStats['users_online']);
		$membersOnlineStats['users_online'][end($userKeys)]['is_last'] = true;
	}

	// Also sort the membergroups.
	ksort($membersOnlineStats['online_groups']);

	// Hidden and non-hidden members make up all online members.
	$membersOnlineStats['num_users_online'] = count($membersOnlineStats['users_online']) + $membersOnlineStats['num_users_hidden'] - (isset($modSettings['show_spider_online']) && $modSettings['show_spider_online'] > 1 ? count($spider_finds) : 0);

	$return = $membersOnlineStats;
	
	echo '
	<div style="font-weight: bold;" class="windowbg">
		', comma_format($return['num_guests']), ' ', $return['num_guests'] == 1 ? $txt['guest'] : $txt['guests'], ', ', comma_format($return['num_users_online']), ' ', $return['num_users_online'] == 1 ? $txt['user'] : $txt['users'] ,'
	</div><br />';

	$bracketList = array();
	if (!empty($user_info['buddies']))
		$bracketList[] = comma_format($return['num_buddies']) . ' ' . ($return['num_buddies'] == 1 ? $txt['buddy'] : $txt['buddies']);
	if (!empty($return['num_spiders']))
		$bracketList[] = comma_format($return['num_spiders']) . ' ' . ($return['num_spiders'] == 1 ? $txt['spider'] : $txt['spiders']);
	if (!empty($return['num_users_hidden']))
		$bracketList[] = comma_format($return['num_users_hidden']) . ' ' . $txt['hidden'];

	$implode = ',';
	
	if (!empty($bracketList))
		echo ' (' . implode($implode, $bracketList) . ')';

	echo'
	<div style="max-height: 12em; overflow: auto;">';
	
	if(!empty($adkportal['no_avatar_who'])){
		echo'
		<img alt="" class="adk_vertical" src="'.$boardurl.'/adkportal/images/user_suit.png" />&nbsp;',implode('<br /><img alt="" class="adk_vertical" src="'.$boardurl.'/adkportal/images/user_suit.png" />&nbsp;', $return['list_users_online']),'
		';
	}
	else
		echo implode(', ', $return['list_users_online']);
		
	echo'
	</div>';
	
	//MemberGroups
	$the_implode = array();
	foreach($return['online_groups'] AS $group)
		$the_implode[$group['id']] = '<a href="'.$scripturl.'?action=groups;sa=members;group='.$group['id'].'" style="color: '.$group['color'].';">'.$group['name'].'</a>';
	
	if(!empty($the_implode))
		echo'<br />
		<div class="windowbg2 smalltext">
			[',implode('] [',$the_implode),']
		</div>';
	
	echo'
	<hr />
	<span class="smalltext">
		', $txt['most_online_today'], ': <strong>', comma_format($modSettings['mostOnlineToday']), '</strong>.<br />
		', $txt['most_online_ever'], ': ', comma_format($modSettings['mostOnline']), ' (', timeformat($modSettings['mostDate']), ')
	</span><hr />';
	
	if(allowedTo('who_view') && !empty($modSettings['who_enabled']))
	echo'
	<img alt="" src="'.$boardurl.'/adkportal/images/users.png" />&nbsp;<a href="'.$scripturl.'?action=who" class="smalltext">'.$txt['who_title'].'</a>';
		
	//I don't know :D :P
	echo'<div class="adk_height_1"></div>';
}


function adk_newsadk()
{

	global $scripturl, $txt, $smcFunc, $adkportal, $boardurl, $context;
	$limit = $adkportal['adk_news'];
	$contador = 0;

	$listar = !empty($_REQUEST['pag']) ? $_REQUEST['pag'] < 1 ? 1 : (int)$_REQUEST['pag'] : 1;
	

	$resultado = $smcFunc['db_query']('','
		SELECT count(*) AS count 
		FROM {db_prefix}adk_news
	');
   
   $row = $smcFunc['db_fetch_assoc']($resultado);
   $contador = $row['count'];
   $smcFunc['db_free_result']($resultado);		
   
   
	$paginas = $contador;
	$por_pagina = $limit;
	$paginado = 0;
	while ($paginas >= $por_pagina):
		$paginas = $paginas - $por_pagina;
		$paginado++;
	endwhile;

	
	if ($paginas != 0)
		$paginado++;

	if ($contador >= $limit)
	{
		$enlace = '';
		for ($i = 1; $i <= $paginado; $i++)
		{
			if($i == $listar)
				$enlace .='[<strong>'.$i.'</strong>]&nbsp;';
			else 
				$enlace .='<a href="'.$scripturl.'?pag='.$i.'">'.$i.'</a>&nbsp;';
		}
	}
	else
		$enlace = '
			[<strong>1</strong>]';
  

	if($listar == 1) 
		$empezamos_por = 0;
	else 
		$empezamos_por = ($listar -1) * $limit;
   
	$quest = $smcFunc['db_query']('','
		SELECT n.id, n.new, n.autor, n.titlepage, n.time,
			IFNULL(t.id_new, 0) AS id_new, t.id_topic
		FROM {db_prefix}adk_news  AS n
		LEFT JOIN {db_prefix}topics AS t ON (t.id_new = n.id)
		ORDER BY id DESC LIMIT {int:start}, {int:limit}',
		array(
			'start' => $empezamos_por,
			'limit' => $limit,
		)
	);
	
	$adkportal['adknews'] = array();
	
	while ($fila = $smcFunc['db_fetch_assoc']($quest))
	{
		$adkportal['adknews'][] = 
			array (
				'id' => $fila['id'],
				'index' => parse_bbc($fila['new']),
				'member' => un_CleanAdkStrings($fila['autor']),
				'title' => un_CleanAdkStrings($fila['titlepage']),
				'time' => timeformat($fila['time']),
				'id_topic' => $fila['id_topic'],
		);
	}
	
	$u = 0;

	foreach ($adkportal['adknews'] as $poster)
	{
		if($u == 1)
		{
			$win = 'windowbg2';
			$cat = 'titlebg';
			$u = 0;
			$cat_ = 'title_bar';
		}
		else
		{
			$win = 'windowbg';
			$cat = 'catbg';
			$cat_ = 'cat_bar';
		}
		
		echo'
		<div class="'.$cat_.'">
			<h3 class="'.$cat.'">
				<a href="'.$scripturl.'?action=addthistopic;view='.$poster['id'].'">',$poster['title'],'</a>';
		
		echo'<span class="adk_float_r">	';
		if (allowedTo('adk_portal'))
			echo'
			
				<a href="'.$scripturl.'?action=admin;area=blocks;sa=showeditnews;id='.$poster['id'].';'.$context['session_var'].'='.$context['session_id'].'">
						<img src="', $boardurl, '/adkportal/images/edit.png" title="'.$txt['editar'].' '.$poster['title'].'" alt="'.$txt['editar'].' '.$poster['title'].'" />
				</a>
				<a onclick="return confirm(\'', $txt['remove_message'], '?\');" href="'.$scripturl.'?action=admin;area=blocks;sa=showdeletenews;del='.$poster['id'].';'.$context['session_var'].'='.$context['session_id'].'">
					<img src="', $boardurl, '/adkportal/images/delete.png" title="'.$txt['borrar'].' '.$poster['title'].'" alt="'.$txt['borrar'].' '.$poster['title'].'" />
				</a>';
		
		if(!empty($poster['id_topic']))
			echo'
				<a href="'.$scripturl.'?topic='.$poster['id_topic'].'.0">
						<img src="', $boardurl, '/adkportal/images/search.png" title="'.$txt['topic'].': '.$poster['title'].'" alt="'.$txt['topic'].' '.$poster['title'].'" />
				</a>';
		
		echo'
			</span>';
		
		echo'
			</h3>
		</div>';
			
		echo'	
		<div style="padding: 5px;">
			'.$poster['index'].'
			<br /><br /><br />';
			
			if(!empty($adkportal['adk_bookmarks_news']))
				adk_bookmarks('right','news',$poster['id']);
		
		echo'
			<div class="smalltext text_align_center windowbg adk_padding_5">
				'.$txt['added_portal'].' <b>'.$poster['member'].'</b> - '.$poster['time'].'
			</div>
		</div>';
		
		$u++;
	}
	
	echo'<br />';
	echo'<div class="smalltext adk_align_right">'.$txt['pages'].': '.$enlace.'</div>';
		
	$smcFunc['db_free_result']($quest);		

}

/*topposter10.php*/
function adk_topposter10($limit = '')
{
	global $context, $scripturl, $txt, $smcFunc, $boardurl, $adkportal, $modSettings;
	
	if(empty($limit))
		$limit = $adkportal['top_poster'];
		
	$sql = $smcFunc['db_query']('','
		SELECT mem.id_member, mem.real_name, mem.avatar, mem.posts,
		mg.online_color,
			IFNULL(a.id_attach, 0) AS id_attach, a.filename, a.attachment_type
		FROM {db_prefix}members AS mem
		LEFT JOIN {db_prefix}attachments AS a ON (a.id_member = mem.id_member)
		LEFT JOIN {db_prefix}membergroups AS mg ON (mg.id_group = IF(mem.id_group = 0, mem.id_post_group, mem.id_group))
		ORDER BY mem.posts DESC
		LIMIT {int:limit}',
		array(
			'limit' => $limit,
		)
	);
	
	echo'<table class="adk_100">';
	
	$context['the_array'] = array();
	
	//Height and width avatar
	$width = 50;
	$height = 50;
	
	while($row = $smcFunc['db_fetch_assoc']($sql))
		$context['the_array'][] = array(
			'id' => $row['id_member'],
			'name' => $row['real_name'],
			'avatar' => $row['avatar'] == '' ? ($row['id_attach'] > 0 ? '<img width="'.$width.'" height="'.$height.'" src="' . (empty($row['attachment_type']) ? $scripturl . '?action=dlattach;attach=' . $row['id_attach'] . ';type=avatar' : $modSettings['custom_avatar_url'] . '/' . $row['filename']) . '" alt="" border="0" />' : '') : (stristr($row['avatar'], 'http://') ? '<img width="'.$width.'" height="'.$height.'" src="' . $row['avatar'] . '" alt="" border="0" />' : '<img width="'.$width.'" height="'.$height.'" src="' . $modSettings['avatar_url'] . '/' . $smcFunc['htmlspecialchars']($row['avatar']) . '" alt="" border="0" />'),
			'color' => $row['online_color'],
			'posts' => $row['posts'],
		);
	
	
	foreach($context['the_array'] AS $adkTopPoster)
	{
		$id_member = $adkTopPoster['id'];
		
		if(empty($adkTopPoster['avatar']))
			$avatar = '<img src="'.$boardurl.'/adkportal/images/noavatar.jpg" alt="" class="adk_avatar" />';
		else
			$avatar = $adkTopPoster['avatar'];
			
		$color_online = $adkTopPoster['color'];
		
		echo'
			<tr>
				<td align="left" width="50">
					',$avatar,'
				</td>
				<td valign="middle" align="left">
					<a href="'.$scripturl.'?action=profile;u='.$id_member.'" title="'.$adkTopPoster['name'].'" style="color: '.$color_online.';" class="font_bold">
						'.$adkTopPoster['name'].'
					</a>
					<br />
					<span class="smalltext"><strong>'.$txt['adk_posts'].'</strong>: '.$adkTopPoster['posts'].'</span>
				</td>
			</tr>';
	}
		
	echo'</table>';	
	
	$smcFunc['db_free_result']($sql);
}

/*ultimosmensajes.php*/
function adk_ultimosmensajes()
{
	global $context, $settings, $scripturl, $txt, $db_prefix, $user_info;
	global $modSettings, $smcFunc, $adkportal, $boardurl;
	
	//SSI FUNCTION
	$exclude_boards = null; 
	$include_boards = null;
	$num_recent = $adkportal['ultimos_mensajes'];
	$output_method = 'array';

	if ($exclude_boards === null && !empty($modSettings['recycle_enable']) && $modSettings['recycle_board'] > 0)
		$exclude_boards = array($modSettings['recycle_board']);
	else
		$exclude_boards = empty($exclude_boards) ? array() : (is_array($exclude_boards) ? $exclude_boards : array($exclude_boards));

	// Only some boards?.
	if (is_array($include_boards) || (int) $include_boards === $include_boards)
	{
		$include_boards = is_array($include_boards) ? $include_boards : array($include_boards);
	}
	elseif ($include_boards != null)
	{
		$output_method = $include_boards;
		$include_boards = array();
	}

	$stable_icons = array('xx', 'thumbup', 'thumbdown', 'exclamation', 'question', 'lamp', 'smiley', 'angry', 'cheesy', 'grin', 'sad', 'wink', 'moved', 'recycled', 'wireless');
	$icon_sources = array();
	foreach ($stable_icons as $icon)
		$icon_sources[$icon] = 'images_url';

	// Find all the posts in distinct topics.  Newer ones will have higher IDs.
	$request = $smcFunc['db_query']('substring', '
		SELECT
			m.poster_time, ms.subject, m.id_topic, m.id_member, m.id_msg, b.id_board, b.name AS board_name, t.num_replies, t.num_views,
			mem.avatar,
			mg.online_color,
			IFNULL(a.id_attach, 0) AS id_attach, a.filename, a.attachment_type,
			IFNULL(mem.real_name, m.poster_name) AS poster_name, ' . ($user_info['is_guest'] ? '1 AS is_read, 0 AS new_from' : '
			IFNULL(lt.id_msg, IFNULL(lmr.id_msg, 0)) >= m.id_msg_modified AS is_read,
			IFNULL(lt.id_msg, IFNULL(lmr.id_msg, -1)) + 1 AS new_from') . ', SUBSTRING(m.body, 1, 384) AS body, m.smileys_enabled, m.icon
		FROM {db_prefix}topics AS t
			INNER JOIN {db_prefix}messages AS m ON (m.id_msg = t.id_last_msg)
			INNER JOIN {db_prefix}boards AS b ON (b.id_board = t.id_board)
			INNER JOIN {db_prefix}messages AS ms ON (ms.id_msg = t.id_first_msg)
			LEFT JOIN {db_prefix}members AS mem ON (mem.id_member = m.id_member)' . (!$user_info['is_guest'] ? '
			LEFT JOIN {db_prefix}log_topics AS lt ON (lt.id_topic = t.id_topic AND lt.id_member = {int:current_member})
			LEFT JOIN {db_prefix}log_mark_read AS lmr ON (lmr.id_board = b.id_board AND lmr.id_member = {int:current_member})' : '') . '
			LEFT JOIN {db_prefix}attachments AS a ON (a.id_member = mem.id_member)
			LEFT JOIN {db_prefix}membergroups AS mg ON (mg.id_group = IF(mem.id_group = 0, mem.id_post_group, mem.id_group))
		WHERE t.id_last_msg >= {int:min_message_id}
			' . (empty($exclude_boards) ? '' : '
			AND b.id_board NOT IN ({array_int:exclude_boards})') . '
			' . (empty($include_boards) ? '' : '
			AND b.id_board IN ({array_int:include_boards})') . '
			AND {query_wanna_see_board}' . ($modSettings['postmod_active'] ? '
			AND t.approved = {int:is_approved}
			AND m.approved = {int:is_approved}' : '') . '
		ORDER BY t.id_last_msg DESC
		LIMIT ' . $num_recent,
		array(
			'current_member' => $user_info['id'],
			'include_boards' => empty($include_boards) ? '' : $include_boards,
			'exclude_boards' => empty($exclude_boards) ? '' : $exclude_boards,
			'min_message_id' => $modSettings['maxMsgID'] - 35 * min($num_recent, 5),
			'is_approved' => 1,
		)
	);
	$posts = array();
	while ($row = $smcFunc['db_fetch_assoc']($request))
	{
		$row['body'] = strip_tags(strtr(parse_bbc($row['body'], $row['smileys_enabled'], $row['id_msg']), array('<br />' => '&#10;')));
		if ($smcFunc['strlen']($row['body']) > 128)
			$row['body'] = $smcFunc['substr']($row['body'], 0, 128) . '...';

		// Censor the subject.
		censorText($row['subject']);
		censorText($row['body']);

		if (empty($modSettings['messageIconChecks_disable']) && !isset($icon_sources[$row['icon']]))
			$icon_sources[$row['icon']] = file_exists($settings['theme_dir'] . '/images/post/' . $row['icon'] . '.gif') ? 'images_url' : 'default_images_url';

		// Build the array.
		$posts[] = array(
			'board' => array(
				'id' => $row['id_board'],
				'name' => $row['board_name'],
				'href' => $scripturl . '?board=' . $row['id_board'] . '.0',
				'link' => '<a href="' . $scripturl . '?board=' . $row['id_board'] . '.0">' . $row['board_name'] . '</a>'
			),
			'avatar' => $row['avatar'] == '' ? ($row['id_attach'] > 0 ? '<img width="50" height="50" src="' . (empty($row['attachment_type']) ? $scripturl . '?action=dlattach;attach=' . $row['id_attach'] . ';type=avatar' : $modSettings['custom_avatar_url'] . '/' . $row['filename']) . '" alt="" border="0" />' : '') : (stristr($row['avatar'], 'http://') ? '<img width="50" height="50" src="' . $row['avatar'] . '" alt="" border="0" />' : '<img width="50" height="50" src="' . $modSettings['avatar_url'] . '/' . $smcFunc['htmlspecialchars']($row['avatar']) . '" alt="" border="0" />'),
			'topic' => $row['id_topic'],
			'poster' => array(
				'id' => $row['id_member'],
				'name' => $row['poster_name'],
				'href' => empty($row['id_member']) ? '' : $scripturl . '?action=profile;u=' . $row['id_member'],
				'link' => empty($row['id_member']) ? ('<b>'.$row['poster_name'].'</b>') : '<a style="color: '.$row['online_color'].'; font-weight: bold;" href="' . $scripturl . '?action=profile;u=' . $row['id_member'] . '">' . $row['poster_name'] . '</a>'
			),
			'online_color' => $row['online_color'],
			'subject' => $row['subject'],
			'replies' => $row['num_replies'],
			'views' => $row['num_views'],
			'short_subject' => shorten_subject($row['subject'], 25),
			'preview' => $row['body'],
			'time' => timeformat($row['poster_time']),
			'timestamp' => forum_time(true, $row['poster_time']),
			'href' => $scripturl . '?topic=' . $row['id_topic'] . '.msg' . $row['id_msg'] . ';topicseen#new',
			'link' => '<a href="' . $scripturl . '?topic=' . $row['id_topic'] . '.msg' . $row['id_msg'] . '#new" rel="nofollow">' . $row['subject'] . '</a>',
			// Retained for compatibility - is technically incorrect!
			'new' => !empty($row['is_read']),
			'is_new' => empty($row['is_read']),
			'new_from' => $row['new_from'],
			'icon' => '<img src="' . $settings[$icon_sources[$row['icon']]] . '/post/' . $row['icon'] . '.gif" align="middle" alt="' . $row['icon'] . '" border="0" />',
		);
	}
	$smcFunc['db_free_result']($request);
	

		
	foreach($posts AS $Output)
	{
		$ID_TOPIC = $Output['topic'];
		$subject = $Output['subject'];
		$posterTime = $Output['time'];
		
		
		$id_member = $Output['poster']['id'];
		$href_last = $Output['href'];
		
		if($id_member == 0)
		{
			$MEMBER_STARTED = $Output['poster']['link'];
			$avatar = '<img src="'.$boardurl.'/adkportal/images/noavatar.jpg" class="adk_avatar" alt="" />';
		}
		else
		{	
			$MEMBER_STARTED = $Output['poster']['link'];
			if(!empty($Output['avatar']))
				$avatar = $Output['avatar'];
			else
				$avatar = '<img src="'.$boardurl.'/adkportal/images/noavatar.jpg" class="adk_avatar" alt="" />';
			
		}
		
		echo'
		<table style="width: 100%;">
			<tr>
				<td width="55">
					'.$avatar.'
				</td>
				<td>
					<a href="'.$scripturl.'?topic='.$ID_TOPIC.'.0" title="'.$subject.'"><b>'.$subject.'</b></a>&nbsp;
						', !$Output['is_new'] ? '' : '<a href="' . $scripturl . '?topic=' . $Output['topic'] . '.msg' . $Output['new_from'] . ';topicseen#new" rel="nofollow"><img src="' . $settings['lang_images_url'] . '/new.gif" alt="' . $txt['new'] . '" /></a>', '
							<div style="float: right;">
							<a href="'.$href_last.'">
								<img alt="" src="'.$settings['images_url'].'/icons/last_post.gif" />
							</a>
							</div>
					<br />
					<span class="smalltext">'.$txt['adk_last_updated'] .': '.$MEMBER_STARTED.'
					&nbsp;-&nbsp;'.$posterTime.'</span>
					
				</td>
			</tr>
		</table>';
		echo'
		<div class="adk_height_1"></div>';		
	}
}

function adk_aportes_automaticos($array = '', $limit_body = '', $limit_query = '')
{

	global $context, $scripturl, $txt, $settings, $smcFunc, $boardurl, $adkportal;
	global $modSettings;
	
	if(empty($array))
		$array = explode(',',$adkportal['auto_news_id_boards']);
	else
		$array = explode(',',$array);
	
	if(empty($limit_body))
		$limit_body = $adkportal['auto_news_limit_body'];
	
	if(empty($limit_query))
		$limit_query = $adkportal['auto_news_limit_topics'];
	
	$context['start'] = isset($_REQUEST['adk']) ? !empty($_REQUEST['start']) ? (int)$_REQUEST['start'] : 0 : 0;
   
	$sql = $smcFunc['db_query']('','
		SELECT COUNT(*) AS total 
		FROM {db_prefix}topics AS t
		INNER JOIN {db_prefix}boards AS b ON (b.id_board = t.id_board)
		WHERE b.id_board IN ('.implode(',',$array).') AND {query_wanna_see_board}
	');
   
	$row = $smcFunc['db_fetch_assoc']($sql);
	$smcFunc['db_free_result']($sql);
   
	$total = $row['total'];
	$context['page_index'] = constructPageIndex($scripturl . '?adk', $context['start'], $total, $limit_query);
	
	$sql = $smcFunc['db_query']('','
		SELECT m.id_topic, m.poster_time, m.id_member, m.poster_name,
		m.subject, m.body, m.icon, mg.online_color, t.num_replies, t.num_views, mem.real_name, mem.avatar,
		IFNULL(a.id_attach, 0) AS id_attach, a.filename, a.attachment_type
		FROM {db_prefix}messages AS m
		LEFT JOIN {db_prefix}members AS mem ON (mem.id_member = m.id_member)
		LEFT JOIN {db_prefix}attachments AS a ON (a.id_member = mem.id_member)
		LEFT JOIN {db_prefix}membergroups AS mg ON (mg.id_group = IF(mem.id_group = 0, mem.id_post_group, mem.id_group))
		INNER JOIN {db_prefix}topics AS t ON (t.id_first_msg = m.id_msg)
		INNER JOIN {db_prefix}boards AS b ON (b.id_board = m.id_board)
		WHERE m.id_board IN ('.implode(',',$array).') AND {query_wanna_see_board}
		ORDER BY m.id_topic DESC LIMIT {int:uno}, {int:limit} ',
		array(
			'limit' => $limit_query,
			'uno' => $context['start'],
		)
	);
									
	
	$img = 'plugin.png';
	
	$topics = array();
	
	while($row = $smcFunc['db_fetch_assoc']($sql))
	{
		if(!empty($row['id_member']))
			$member = '<a href="'.$scripturl.'?action=profile;u='.$row['id_member'].'" style="color: '.$row['online_color'].';">'.$row['real_name'].'</a>';
		else
			$member = $row['poster_name'];
			
		
		$topics[] = array(
			'v' => $row['num_views'],
			'r' => $row['num_replies'],
			'avatar' => $row['avatar'] == '' ? ($row['id_attach'] > 0 ? '<img width="30" height="30" src="' . (empty($row['attachment_type']) ? $scripturl . '?action=dlattach;attach=' . $row['id_attach'] . ';type=avatar' : $modSettings['custom_avatar_url'] . '/' . $row['filename']) . '" alt="" border="0" />' : '') : (stristr($row['avatar'], 'http://') ? '<img width="30" height="30" src="' . $row['avatar'] . '" alt="" border="0" />' : '<img width="30" height="30" src="' . $modSettings['avatar_url'] . '/' . $smcFunc['htmlspecialchars']($row['avatar']) . '" alt="" border="0" />'),
			'id_topic' => $row['id_topic'],
			'img' => '<img style="vertical-align: middle;" src="'.$settings['images_url'].'/post/'.$row['icon'].'.gif" alt="" />',
			'href' => $row['subject'],
			'time' => timeformat($row['poster_time']),
			'member' => $member,
			'body' => str_replace('<img ','<img style="max-width: 350px;" ',parse_bbc(substr($row['body'],0,$limit_body)))
		);
	}
	//$averiguar = $avatar2,1,4);
	$smcFunc['db_free_result']($sql);
	
	
	foreach($topics AS $topic)
	{
		$title = '<a href="'.$scripturl.'?topic='.$topic['id_topic'].'.0"><b>'.$topic['href'].'</b></a>';
		
		echo'
		<div class="title_bar">
			<h3 class="titlebg">
				'.$topic['img'].$title.' 
			</h3>
		</div>';
							
		echo'
		<div style="height: 40px;">
		
		<div class="smalltext adk_float_r">'.$txt['by'].' '.$topic['member'].' - '.$topic['time'].'</div>';
		
		if(!emptY($topic['avatar']))
		echo'
		<div class="adk_float_l">',$topic['avatar'],'</div>';
		
		echo'
		</div>
		
		<div class="adk_padding_8">
			'.$topic['body'].'
		</div>
		
		<br />';
		
		if(!empty($adkportal['adk_bookmarks_autonews']))
			adk_bookmarks('right','auto_news',$topic['id_topic']);
		
		echo'
		<div class="windowbg2 smalltext adk_padding_5">
			<a href="'.$scripturl.'?topic='.$topic['id_topic'].'.0"><strong>'.$txt['learn_more'].'...</strong></a>
			<div class="adk_float_r">
				'.$txt['views'].': '.$topic['v'].'  '.$txt['replies'].': '.$topic['r'].'
			</div>
		</div>
		<div class="adk_height_3"></div>';

	}
	
	echo'<div class="adk_align_right">'.$txt['adk_admin_pages'].': '.   $context['page_index'].'</div>';
	echo'<div class="adk_height_1"></div>';			

}

function adk_carrousel()
{
	global $settings, $scripturl, $context, $adkportal, $boardurl, $txt, $smcFunc;
	
	$t = $smcFunc['db_query']('','
		SELECT image, url
		FROM {db_prefix}adk_advanced_images
		ORDER BY id DESC
		LIMIT {int:limit}',
		array(
			'limit' => $adkportal['adv_top_image_limit'],
		)
	);
	
	$adkportal['load_images_'] = array();
	
	while($row = $smcFunc['db_fetch_assoc']($t)){
		$adkportal['load_images_'][] = array(
			'url' => '<a href="'.$row['url'].'"><img src="'.$row['image'].'" alt="" /></a>&nbsp;',
		);
	}
	
	$smcFunc['db_free_result']($t);
	
	if(empty($adkportal['jquery_loaded']))
	echo'
	<script type="text/javascript" src="'.$boardurl.'/adkportal/js/jquery.js"></script>';
		
	$adkportal['jquery_loaded'] = true;
	
	echo'
		<script src="'.$boardurl.'/adkportal/js/carousel.js" type="text/javascript"></script>
		<script type="text/javascript">

		// Credits: Robert Penners easing equations (http://www.robertpenner.com/easing/).
		jQuery.easing[\'BounceEaseOut\'] = function(p, t, b, c, d) {
			if ((t/=d) < (1/2.75)) {
				return c*(7.5625*t*t) + b;
			} else if (t < (2/2.75)) {
				return c*(7.5625*(t-=(1.5/2.75))*t + .75) + b;
			} else if (t < (2.5/2.75)) {
				return c*(7.5625*(t-=(2.25/2.75))*t + .9375) + b;
			} else {
				return c*(7.5625*(t-=(2.625/2.75))*t + .984375) + b;
			}
		};

		jQuery(document).ready(function() {
			jQuery(\'#mycarousel\').jcarousel({
				easing: \'BounceEaseOut\',
				animation: 1000
			});
		});
		
		</script>';
	

		
		echo'
	<div class="adk_height_1"></div>
	<div id="wrap">
		<ul id="mycarousel" class="jcarousel-skin-tango">
			';
		
		foreach($adkportal['load_images_'] AS $t)
			echo '
			<li>'.$t['url'].'</li>';
			
		
		echo'
		</ul>
	</div>
	<div class="adk_height_1"></div>';

}
function adk_shoutbox()
{
	global $boardurl, $txt, $adkportal, $context, $user_info, $boarddir, $boardurl, $scripturl;
	
	//Post action? not show this block... for security reasons
	if(!empty($context['post_box_name']))
		echo $txt['shoutbox_disabled'];
	else{
	
		$id_group = $context['user']['is_logged'] ? $user_info['groups'][0] : -1;
		
		$true1 = false;
		$true2 = false;
		
		if($id_group == 1)
		{
			$true1 = true;
			$true2 = true;
		}
		
		if(in_array($id_group,explode(',',$adkportal['shout_allowed_groups_view'])))
			$true1 = true;
		
		if(in_array($id_group,explode(',',$adkportal['shout_allowed_groups'])))
			$true2 = true;
		
		if($true1 && empty($adkportal['jquery_loaded'])){
			echo'
			<script type="text/javascript" src="'.$boardurl.'/adkportal/js/jquery.js"></script>';
		}
		
		//Yeah! Jquery loaded
		$adkportal['jquery_loaded'] = true;
		
		//Load Smileys.
		if($true2){
			
			$context['shout_dir'] = $boarddir.'/adkportal/smileys';
			$context['shout_dir_found'] = is_dir($context['shout_dir']);
			
			$context['filenames'] = array();
			if ($context['shout_dir_found'])
			{
				if (!file_exists($context['shout_dir']))
					continue;

				$dir = dir($context['shout_dir']);
				while ($entry = $dir->read())
				{
					if (!in_array($entry, $context['filenames']) && in_array(strrchr($entry, '.'), array('.jpg', '.gif', '.jpeg', '.png')))
						$context['filenames'][strtolower($entry)] = array(
							'id' => htmlspecialchars($entry),
							'selected' => false,
						);
				}
				$dir->close();
			ksort($context['filenames']);
			}

			$context['filenames'] = array_values($context['filenames']);
		}
		
		if($true1){
			echo'
			<div id="container3">
				',!empty($adkportal['shout_title']) ? '<div class="approvebg adk_padding_5">'.$adkportal['shout_title'].'</div>' : '' ,'
				<div class="contente windowbg">
					
					<div id="loading">'.$txt['ajax_in_progress'].'</div>
					
				</div>
			</div>
			<script type="text/javascript" src="'.$boardurl.'/adkportal/shoutbox/shoutbox.js"></script><br />';
			
			
		}
		else
			echo '<div class="smalltetext">'.$txt['adk_shout_now_allowed'].'</div>';
		
		//The action post y for security reasons
		if($true2){
		echo'
		<form method="post" id="form" action="">
			<table>
				',!$context['user']['is_logged'] ? '
				<tr>
					<td><label>'.$txt['user'].'</label></td></tr><tr>
					<td><input class="text user" id="nick" type="text" size="10" /></td>
				</tr>' : '
				<tr>
					<td><input type="hidden" id="nick" value="'.$user_info['name'].'" /></td>
				</tr>' ,'
				
				<tr>
					<td><label>'.$txt['adk_message_shoutbox'].'</label></td>
				</tr>
				<tr>
					<td><input class="text" id="message_shoutbox" type="text" /></td>
				</tr>
				<tr>
					<td colspan="2" align="left">
						<input id="send" type="submit" value="'.$txt['adk_shoutbox_shout_it'].'" />
					</td>
				</tr>
			</table>
		</form>';
		
		echo'
		<br />
		<a href="javascript:OpenShoutbox(\'shoutbox_smiley\')" title="',$txt['adk_open_smileys'],'">
			<img alt="" src="'.$boardurl.'/adkportal/images/shout_open.png" class="carousel_buttons" />
		</a>
		<a href="javascript:OpenShoutbox(\'shout_fonts\')">
			<img alt="" src="'.$boardurl.'/adkportal/images/shout_a.png" class="carousel_buttons" />
		</a>
		<a href="javascript:finalUpdate()">
			<img alt="" src="'.$boardurl.'/adkportal/images/shout_update.png" class="carousel_buttons" />
		</a>
		<a href="'.$scripturl.'?action=adk_shoutbox">
			<img alt="" src="'.$boardurl.'/adkportal/images/icon_shoutbox.png" class="carousel_buttons" />
		</a>
		
		<br />';
		
			echo'
			<div id="shoutbox_smiley" style="display: none;">
			<br />';
			
			foreach($context['filenames'] AS $smiley)
				echo'<img alt="" src="'.$boardurl.'/adkportal/smileys/'.$smiley['id'].'" class="adk_pointer" onclick="addSmiley(\':'.$smiley['id'].':\')" />';
		
			echo'
			</div>';
			
			//Load Fonts, etc
			$things = array('i','b','u','s','left','right','center');
			
			echo'
			<div id="shout_fonts" style="display: none;">';
			
			foreach($things AS $i)
				echo'<img alt="" src="'.$boardurl.'/adkportal/bbcodes/'.$i.'.gif" class="adk_pointer" onclick="addBBCode(\''.$i.'\')" />';
			
			echo'
			</div>';
		
		}
	}

}

function adk_topkarma10($limit)
{
	global $context, $scripturl, $txt, $smcFunc, $boardurl, $adkportal, $modSettings;
   
	if(empty($limit))
		$limit = $adkportal['top_poster'];
	
	$where = 'mem.karma_good';
      
	$sql = $smcFunc['db_query']('','
		SELECT mem.id_member, mem.real_name, mem.avatar, mem.karma_good, mem.karma_bad,
		mg.online_color,
			IFNULL(a.id_attach, 0) AS id_attach, a.filename, a.attachment_type
		FROM {db_prefix}members AS mem
		LEFT JOIN {db_prefix}attachments AS a ON (a.id_member = mem.id_member)
		LEFT JOIN {db_prefix}membergroups AS mg ON (mg.id_group = IF(mem.id_group = 0, mem.id_post_group, mem.id_group))
		ORDER BY '.$where.' DESC
		LIMIT {int:limit}',
		array(
			'limit' => $limit,
		)
	);
   
	echo'<table style="width: 100%;">';
   
	$context['the_array'] = array();
   
	//Height and width avatar
	$width = 50;
	$height = 50;
   
	while($row = $smcFunc['db_fetch_assoc']($sql))
	$context['the_array'][] = array(
		'id' => $row['id_member'],
		'name' => $row['real_name'],
		'avatar' => $row['avatar'] == '' ? ($row['id_attach'] > 0 ? '<img width="'.$width.'" height="'.$height.'" src="' . (empty($row['attachment_type']) ? $scripturl . '?action=dlattach;attach=' . $row['id_attach'] . ';type=avatar' : $modSettings['custom_avatar_url'] . '/' . $row['filename']) . '" alt="" border="0" />' : '') : (stristr($row['avatar'], 'http://') ? '<img width="'.$width.'" height="'.$height.'" src="' . $row['avatar'] . '" alt="" border="0" />' : '<img width="'.$width.'" height="'.$height.'" src="' . $modSettings['avatar_url'] . '/' . $smcFunc['htmlspecialchars']($row['avatar']) . '" alt="" border="0" />'),
		'color' => $row['online_color'],
		'posts' => $modSettings['karmaMode'] == '1' ? $row['karma_good'] : $row['karma_good'] - $row['karma_bad'],
	);
   
   
	foreach($context['the_array'] AS $adkTopPoster)
	{
		$id_member = $adkTopPoster['id'];
      
		if(empty($adkTopPoster['avatar']))
			$avatar = '<img src="'.$boardurl.'/adkportal/images/noavatar.jpg" alt="" class="adk_avatar" />';
		else
			$avatar = $adkTopPoster['avatar'];
         
		$color_online = $adkTopPoster['color'];
      
		echo'
		<tr>
			<td align="left" width="50">
				',$avatar,'
			</td>
			<td valign="middle" align="left">
				<a href="'.$scripturl.'?action=profile;u='.$id_member.'" title="'.$adkTopPoster['name'].'" style="color: '.$color_online.'; font-weight: bold;">
					'.substr($adkTopPoster['name'],0,13).'
				</a>
				<br />
				<span class="smalltext"><strong>'.$txt['adk_karma'].'</strong>: '.$adkTopPoster['posts'].'</span>
			</td>
		</tr>';
	}
      
	echo'</table>';   
	
	$smcFunc['db_free_result']($sql);
 
}

function notasparacambiar()
{
	global $user_info, $smcFunc, $txt, $boardurl;
	
	$notes = '';
	
	if(isset($_POST['notes_save']) && !empty($_POST['notes_txt']))
	{
		$notes = CleanAdkStrings($_POST['notes_txt']);
		
		if($user_info['is_guest'])
			$_SESSION['adk_notes'] = $notes;
		else
			updateMemberData($user_info['id'],array('adk_notes' => $notes));
	}
	else
	{
		$notes = $user_info['adk_notes'];
	
		//If this user is guest, He can add notes too ;)
		if(isset($_SESSION['adk_notes']) && $user_info['is_guest'])
			$notes = $_SESSION['adk_notes'];
	}
	
	echo'
	<script type="text/javascript">
		function ChangeContent(id, id2) {
		if(document.getElementById(id).style.display == "none"){
			document.getElementById(id).style.display = "block";
		}
		else{
			document.getElementById(id).style.display = "none";
		}
		
		if(document.getElementById(id2).style.display == "none"){
			document.getElementById(id2).style.display = "block";
		}
		else{
			document.getElementById(id2).style.display = "none";
		}
	}
	</script>';
	
	echo'
	<div class="windowbg2 smalltext" align="center" id="note" style="display: none;">
		<form action="" method="post">
			<textarea rows="3" cols="15" name="notes_txt">',$notes,'</textarea>
			<br />
			<br /><input class="button_submit" type="submit" name="notes_save" value="'.$txt['save'].'" />
		</form>
	</div>';
	
	echo'
	<div id="note2" align="center" class="windowbg2 smalltext" style="display: block;">
		',empty($notes) ? $txt['adk_add_a_reminder'] : parse_bbc($notes) ,'
	</div>
	<div align="right">
		<a href="javascript:ChangeContent(\'note\',\'note2\')" title="'.$txt['editar'].'">
			<img alt="" src="'.$boardurl.'/adkportal/images/email_edit.png" />
		</a>
	</div>
	';
	/* rows="10" cols="10" onkeyup="if(this.value.length > 140){this.value=this.value.substring(0,140);alert(\'no puede poner más de 140 caracteres\')}"*/

}

Function ShowMyCalendar()
{
	global $sourcedir, $options, $modSettings, $scripturl, $txt, $context, $settings, $boardurl, $smcFunc;
	
	//My Own Require
	require_once($sourcedir . '/Subs-Calendar.php');
	$today = getTodayInfo();
	
	$curPage = array(
		'day' => $today['day'],
		'month' => $today['month'],
		'year' => $today['year']
	);

	$calendarOptions = array(
		'start_day' => !empty($options['calendar_start_day']) ? $options['calendar_start_day'] : 0,
		'show_birthdays' => in_array($modSettings['cal_showbdays'], array(1, 2)),
		'show_events' => true,
		'show_holidays' => true,
		'show_week_num' => true,
		'short_day_titles' => true,
		'show_next_prev' => false,
		'show_week_links' => false,
		'size' => 'small',
	);
	
	$my_array = array();

	$context['calendar_grid_main'] = getCalendarGrid($curPage['month'], $curPage['year'], $calendarOptions);

	$calendar_data = &$context['calendar_grid_main'];
	$colspan = !empty($calendar_data['show_week_links']) ? 8 : 7;

	if (empty($calendar_data['disable_title']))
	{
		echo '
				<div class="titlebg adk_padding_5">';

		if (empty($calendar_data['previous_calendar']['disabled']) && $calendar_data['show_next_prev'])
			echo'
					<span class="floatleft"><a href="'. $calendar_data['previous_calendar']['href'] .'">&#171;</a></span>';

		if (empty($calendar_data['next_calendar']['disabled']) && $calendar_data['show_next_prev'])
			echo'
					<span class="floatright"><a href="'. $calendar_data['next_calendar']['href'] .'">&#187;</a></span>';

		if ($calendar_data['show_next_prev'])
			echo'
					'. $txt['months_titles'][$calendar_data['current_month']] .' '. $calendar_data['current_year'];
		else
			echo'
					'. $txt['months_titles'][$calendar_data['current_month']] .' '. $calendar_data['current_year'] .'';

		echo'
				</div>';
	}

	echo'
				<table align="center" class="calendar_table" style="border-spacing:5px;table-layout:fixed;width:100%;">';

	// Show each day of the week.
	if (empty($calendar_data['disable_day_titles']))
	{
		echo'
					<tr>';

		if (!empty($calendar_data['show_week_links']))
			echo'
						<td class="windowbg3">&nbsp;</td>';

		foreach ($calendar_data['week_days'] as $day)
			echo'
						<th class="windowbg3 days" scope="col" '. ($calendar_data['size'] == 'small' ? 'style="font-size: x-small;"' : '') .'>'. (!empty($calendar_data['short_day_titles']) ? $smcFunc['substr']($txt['days_short'][$day], 0, 1) : $txt['days'][$day] ) .'</th>';

		echo'
					</tr>';
	}

	foreach ($calendar_data['weeks'] as $week)
	{
		echo'
					<tr>';

		if (!empty($calendar_data['show_week_links']))
			echo'
						<td align="center" class="windowbg2">
							<a href="'. $scripturl .'?action=calendar;viewweek;year='. $calendar_data['current_year'] .';month='. $calendar_data['current_month'] .';day='. $week['days'][0]['day'] .'">&#187;</a>
						</td>';


		foreach ($week['days'] as $day)
		{
			echo'
						<td align="center" style="height: '. ($calendar_data['size'] == 'small' ? '20' : '100') . 'px; padding: 2px;'. ($calendar_data['size'] == 'small' ? 'font-size: x-small;' : '') .'" class="'. ($day['is_today'] ? 'calendar_today' : 'windowbg') .' days">';

			if (!empty($day['day']))
			{
				if(!empty($day['holidays']) || !empty($day['birthdays']) || !empty($day['events']))
				{
					$my_array[$day['day']]['day'] = $day['day'];
					echo '
					<a href="javascript:ShowAdkCalendar(\'day_'.$day['day'].'\')" class="birthday" style="color: #920ac4; font-weight: bold;">';
				}
				
				echo
				$day['day'];
				
				if(!empty($day['holidays']) || !empty($day['birthdays']) || !empty($day['events']))
				echo'
				</a>';

				
				if (!empty($day['holidays']))
					$my_array[$day['day']]['event'][] = '<img style="vertical-align: middle;" src="'.$boardurl.'/adkportal/images/calendar.png" alt="" />&nbsp;<span class="holiday smalltext">'. $txt['calendar_prompt']. ' '. implode(', ', $day['holidays']). '</span>';

				if (!empty($day['birthdays']))
				{
					foreach ($day['birthdays'] as $member)
						$my_array[$day['day']]['event'][] = '
					<img style="vertical-align: middle;" src="'.$boardurl.'/adkportal/images/cake.png" alt="" />&nbsp;
					<a class="smalltext" href="'. $scripturl .'?action=profile;u='. $member['id']. '">'. $member['name']. (isset($member['age']) ? ' (' . $member['age'] . ')' : ''). '</a>';
				}

				if (!empty($day['events']))
				{
					foreach ($day['events'] as $event){
						$my_array[$day['day']]['event'][] = '<img style="vertical-align: middle;" src="'.$boardurl.'/adkportal/images/calendar.png" alt="" />&nbsp;
						'. $event['link'];
					}
				}
			}

			echo'
						</td>';
		}

		echo'
					</tr>';
	}

	echo'
				</table><div></div>';
				
	if(!empty($my_array)){
		echo'
		<script type="text/javascript">
			function ShowAdkCalendar(id) {
			if(document.getElementById(id).style.display == "none"){
				document.getElementById(id).style.display = "block";
			}
			else{
				document.getElementById(id).style.display = "none";
			}
		}
		</script>';
		
		$true_days = array();
		
		
		foreach($my_array AS $event){
			echo'
			
			<div id="day_'.$event['day'].'" style="display: none;">
			<strong class="smalltext">'.$txt['calendar_day'].' '.$event['day'].'</strong>';
			
			foreach($event['event'] AS $num => $e)
				echo '<br />'.$e;
			
			echo'
			</div>';
			
		}
		
	}
}

function adkportal_staff($groups = '1,2', $show_avatar = 1)
{
	global $smcFunc, $txt, $context, $boardurl, $scripturl, $adkportal, $sourcedir, $modSettings;

	//require_once($sourcedir . '/Subs-Members.php');
	
	//bored :|
	$a = false;
	
	if(!empty($show_avatar))
		$a = true;
	
	$mods = array();
	
	if(in_array(3,explode(',',$groups))){
		//Show Moderators?
		$md = $smcFunc['db_query']('','
			SELECT id_member
			FROM {db_prefix}moderators
		');
		
		
		
		while($row = $smcFunc['db_fetch_assoc']($md))
			$mods[$row['id_member']] = $row['id_member'];
		
		$smcFunc['db_free_result']($md);
	}
	
	$m = $smcFunc['db_query']('','
		SELECT id_member FROM 
		{db_prefix}members 
		WHERE id_group IN ({array_int:staff})',
		array(
			'staff' => explode(',',$groups),
		)
	);
	
	while($row = $smcFunc['db_fetch_assoc']($m))
		$mods[$row['id_member']] = $row['id_member'];
	
	$smcFunc['db_free_result']($m);
	
	
	//$my_staff = array_merge($mods, $g_mod, $ad);
	$my_staff = array_unique($mods);
	
	
	$sql = $smcFunc['db_query']('','
		SELECT mem.id_member, mem.real_name, mem.avatar, mem.karma_good, mem.karma_bad,
		mg.online_color, mg.group_name, mg.id_group,
			IFNULL(a.id_attach, 0) AS id_attach, a.filename, a.attachment_type
		FROM {db_prefix}members AS mem
		LEFT JOIN {db_prefix}attachments AS a ON (a.id_member = mem.id_member)
		LEFT JOIN {db_prefix}membergroups AS mg ON (mg.id_group = IF(mem.id_group = 0, mem.id_post_group, mem.id_group))
		WHERE mem.id_member IN ({array_int:staff})
		ORDER BY mem.id_member ASC',
		array(
			'staff' => $my_staff,
		)
	);
	
	$context['the_array'] = array();
	
	//height and width
	$height = 50; $width = 50;
	
	while($row = $smcFunc['db_fetch_assoc']($sql)){
		$context['the_array'][$row['id_group']] = array(
			'id_group' => $row['id_group'],
			'name' => '<strong style="color: '.$row['online_color'].'; font-family: comic sans;" class="smalltext">'.$row['group_name'].'</strong>',
			'members' => array(),
		);
		
		//Load members
		$members[$row['id_member']] = array(
			'id_group' => $row['id_group'],
			'id' => $row['id_member'],
			'name' => $row['real_name'],
			'avatar' => $row['avatar'] == '' ? ($row['id_attach'] > 0 ? '<img width="'.$width.'" height="'.$height.'" src="' . (empty($row['attachment_type']) ? $scripturl . '?action=dlattach;attach=' . $row['id_attach'] . ';type=avatar' : $modSettings['custom_avatar_url'] . '/' . $row['filename']) . '" alt="" border="0" />' : '') : (stristr($row['avatar'], 'http://') ? '<img width="'.$width.'" height="'.$height.'" src="' . $row['avatar'] . '" alt="" border="0" />' : '<img width="'.$width.'" height="'.$height.'" src="' . $modSettings['avatar_url'] . '/' . $smcFunc['htmlspecialchars']($row['avatar']) . '" alt="" border="0" />'),
			'color' => $row['online_color'],
			//'posts' => $modSettings['karmaMode'] == '1' ? $row['karma_good'] : $row['karma_good'] - $row['karma_bad'],
		);
		
		if(!in_array($row['id_group'],explode(',',$groups)))
			$context['the_array'][$row['id_group']]['name'] = '<strong class="smalltext" style="font-family: comic sans;">'.$txt['moderators'].'</strong>';
   }
   
   
   //Doesn't work in the other way :|
   foreach($members AS $id_group => $v)
	{
		$context['the_array'][$v['id_group']]['members'][] = array(
			'id' => $v['id'],
			'name' => $v['name'],
			'avatar' => $v['avatar'],
			'color' => $v['color'],
		);
	}
	
	$i = 0;
	foreach($context['the_array'] AS $g)
	{
		if($i != 0)
			echo'<br />';
		
		$i++;
		
		echo'
		'.$g['name'].'<hr />';
		
		
		echo'
		<table class="adk_100">';
		foreach($g['members'] AS $m)
		{
			if(empty($m['avatar']))
				$avatar = '<img src="'.$boardurl.'/adkportal/images/noavatar.jpg" alt="" class="adk_avatar" />';
			else
				$avatar = $m['avatar'];
		
			echo'
			<tr>
				<td align="left"',$a ? ' width="50"' : ' width="16"' ,'>
					',$a ? $avatar : '<img alt="" style="vertical-align: middle;" src="'.$boardurl.'/adkportal/images/user_suit.png" />' ,'
				</td>
				<td valign="middle" align="left">
					<a href="'.$scripturl.'?action=profile;u='.$m['id'].'" title="'.$m['name'].'" style="color: '.$m['color'].'; font-weight: bold;">
						'.substr($m['name'],0,13).'
					</a>
				</td>
			</tr>';
		}
		
		echo'</table>';
	}
	
	echo'<div class="adk_height_1"></div>';
      
	$smcFunc['db_free_result']($sql);


}


?>