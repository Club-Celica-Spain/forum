<?php
/*******************************************************************************
* Optimus Brave © 2010-2013, Bugo										       *
********************************************************************************
* Subs-Optimus.php															   *
********************************************************************************
* License http://creativecommons.org/licenses/by-nc-nd/3.0/deed.ru CC BY-NC-ND *
* Support and updates for this software can be found at	http://dragomano.ru    *
*******************************************************************************/

if (!defined('SMF'))
	die('Hacking attempt...');
	
define('OB', '1.8.6.2');

function optimus_home()
{
	global $modSettings, $context, $mbname, $txt;

	loadLanguage('Optimus');
	
	if (!isset($modSettings['optimus_portal_compat']))
		$modSettings['optimus_portal_compat'] = 0;

	if (!empty($modSettings['optimus_portal_compat']))
		if (empty($context['current_board']) && empty($context['current_topic']) && empty($_REQUEST['action']) && !empty($modSettings['optimus_portal_index']))
		{
			$context['forum_name'] = $mbname . ' ' . $modSettings['optimus_portal_index'];
			if ($modSettings['optimus_portal_compat'] == 2) {
				$context['forum_name'] = $mbname;
				$txt['home'] = $modSettings['optimus_portal_index'];
			}
		}

	// Forum
	$txt['forum_index'] = '%1$s';
	if (!empty($modSettings['optimus_forum_index']))
		$txt['forum_index'] = '%1$s - ' . $modSettings['optimus_forum_index'];
		
	$ignored_actions = !empty($modSettings['optimus_ignored_actions']) ? explode(",", $modSettings['optimus_ignored_actions']) : array();

	if (!in_array($context['current_action'], $ignored_actions))
	{
		// Invisible counters like Google
		if (!empty($modSettings['optimus_head_code']))
		{
			$head = explode("\n", trim($modSettings['optimus_head_code']));
			foreach ($head as $part) $context['html_headers'] .= "\n\t" . $part;
		}
		
		// Other invisible counters
		if (!empty($modSettings['optimus_stat_code']))
		{
			$stat = explode("\n", trim($modSettings['optimus_stat_code']));
			foreach ($stat as $part) $context['insert_after_template'] .= "\n\t" . $part;
		}

		// Styles for visible counters
		if (!empty($modSettings['optimus_count_code']))
			$context['html_headers'] .= "\n\t" . '<style type="text/css">.copyright a>img {opacity: 0.3} .copyright a:hover>img {opacity: 1.0} #footerarea ul li.copyright {line-height: normal; padding: 0}</style>';
	}
	
	// Special fix for PortaMx
	if ($modSettings['optimus_portal_compat'] == 4)
	{
		if (empty($_REQUEST['action']) && empty($_REQUEST['board']) && empty($_REQUEST['topic']))
		{
			if (!empty($modSettings['optimus_meta']) && empty($modSettings['pmx_frontmode']))
			{
				$meta = '';
				$test = @unserialize($modSettings['optimus_meta']);
				foreach ($test as $var)
					$meta .= "\n\t" . '<meta name="' . $var['name'] . '" content="' . $var['content'] . '" />';
				$context['html_headers'] .= $meta;
			}
		}
	}
}

function optimus_operations()
{
	global $context, $mbname, $boardurl, $modSettings, $smcFunc, $txt, $scripturl, $topicinfo, $board_info;
	
	if (empty($context['current_board']) && empty($context['current_topic']) && empty($_REQUEST['action'])) {
		$context['linktree'][0]['name'] = $mbname;
		$context['canonical_url'] = $boardurl . '/';
	}
	
	if (!empty($modSettings['optimus_portal_compat']) && in_array($context['current_action'], array('forum', 'community')))
		$context['canonical_url'] = $scripturl . '?action=' . $context['current_action'];

	// Description
	if (empty($context['current_action']))
		$context['optimus_description'] = !empty($modSettings['optimus_description']) ? $smcFunc['htmlspecialchars']($modSettings['optimus_description']) : '';

	// Обрабатываем шаблоны заголовков страниц
	if (!empty($modSettings['optimus_templates']) && strpos($modSettings['optimus_templates'], 'board') && strpos($modSettings['optimus_templates'], 'topic'))
	{
		$templates = @unserialize($modSettings['optimus_templates']);
		foreach ($templates as $name => $data)
		{
			if ($name == 'board') {
				$board_name_tpl = $data['name'];
				$board_page_tpl = $data['page'];
				$board_site_tpl = $data['site'];
			}
			if ($name == 'topic') {
				$topic_name_tpl = $data['name'];
				$topic_page_tpl = $data['page'];
				$topic_site_tpl = $data['site'];
			}
		}
	}
	else
	{
		foreach ($txt['optimus_templates'] as $name => $data)
		{
			if ($name == 'board') {
				$board_name_tpl = $data[0];
				$board_page_tpl = $data[1];
				$board_site_tpl = $data[2];
			}
			if ($name == 'topic') {
				$topic_name_tpl = $data[0];
				$topic_page_tpl = $data[1];
				$topic_site_tpl = $data[2];
			}
		}
	}

	// Номер текущей страницы в заголовке (при условии, что страниц несколько)
	$board_page_number = $topic_page_number = '';
	if ($context['current_action'] != 'wiki')
	{
		if (!empty($context['page_info']['current_page']) && $context['page_info']['num_pages'] != 1)
		{
			$trans = array("{#}" => $context['page_info']['current_page']);
			$board_page_number = strtr($board_page_tpl, $trans);
			$topic_page_number = strtr($topic_page_tpl, $trans);
		}
	}

	// Topics
	if (!empty($context['topic_first_message']))
	{
		$trans = array(
			"{topic_name}" => $topicinfo['subject'],
			"{board_name}" => strip_tags($board_info['name']),
			"{cat_name}" => $board_info['cat']['name'],
			"{forum_name}" => $context['forum_name']
		);
		$topic_page_number = !empty($topic_page_number) ? $topic_page_number : (!empty($topic_site_tpl) ? ' - ' : '');
		$context['page_title'] = strtr($topic_name_tpl . $topic_page_number . $topic_site_tpl, $trans);
		$context['optimus_description'] = !empty($modSettings['optimus_topic_description']) ? optimus_meta_teaser() : '';
	}

	// Boards
	if (!empty($board_info['total_topics']))
	{
		$trans = array(
			"{board_name}" => strip_tags($context['name']),
			"{cat_name}" => $board_info['cat']['name'],
			"{forum_name}" => $context['forum_name']
		);
		$board_page_number = !empty($board_page_number) ? $board_page_number : (!empty($board_site_tpl) ? ' - ' : '');
		$context['page_title'] = strtr($board_name_tpl . $board_page_number . $board_site_tpl, $trans);
		if (!empty($modSettings['optimus_board_description']))
			$context['optimus_description'] = optimus_meta_chars(!empty($context['description']) ? $context['description'] : $context['name']);
	}

	// Set canonical URLs and descriptions for AM pages
	if ($context['current_action'] == 'media' && !empty($_REQUEST['sa']) && !empty($_REQUEST['in']))
	{
		$item = (int) $_REQUEST['in'];
		
		if ($_REQUEST['sa'] == 'album')
			$context['canonical_url'] = $scripturl . '?action=media;sa=album;in=' . $item;
		if ($_REQUEST['sa'] == 'item')
			$context['canonical_url'] = $scripturl . '?action=media;sa=item;in=' . $item;
		
		$context['optimus_description'] = !empty($context['item_data']['description']) ? html_entity_decode($context['item_data']['description'], ENT_QUOTES, $context['character_set']) : '';
	}
	
	// Возвращаемые коды состояния, в зависимости от ситуации
	if (!empty($modSettings['optimus_404_status']))
	{
		if (!empty($board_info['error']))
		{
			if ($board_info['error'] == 'exist') // Страница не существует?
			{
				header('HTTP/1.1 404 Not Found');
				loadTemplate('Optimus');
				$context['sub_template'] = '404';
				$context['page_title'] = $txt['optimus_404_page_title'];
			}
			
			if ($board_info['error'] == 'access') // Нет доступа?
			{
				header('HTTP/1.1 403 Forbidden');
				loadTemplate('Optimus');
				$context['sub_template'] = '403';
				$context['page_title'] = $txt['optimus_403_page_title'];
			}
		}
	}
	if (empty($_REQUEST['action']) || !empty($_REQUEST['board']) || !empty($_REQUEST['topic']))

	if (!empty($modSettings['optimus_search_stats']))
		optimus_search_terms($txt['optimus_terms']);

	// Copyright Info
	if ($context['current_action'] == 'credits')
		$context['copyrights']['mods'][] = '<a href="http://dragomano.ru/page/optimus-brave" target="_blank" title="' . OB . '">Optimus Brave</a> &copy; 2010&ndash;2013, Bugo';
}

// Вычисляем, по каким поисковым запросам пришел посетитель
function optimus_search_terms($engines)
{
	global $smcFunc;
	
	if (!is_array($engines) || empty($engines)) return;

	$refer = !empty($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : '';

	foreach ($engines as $name => $v)
	{
		if (strpos($refer, $name))
		{
			$refer_string = parse_url($refer, PHP_URL_QUERY);
			parse_str($refer_string, $vars);
			$search_terms = isset($vars[$v]) ? $vars[$v] : '';
		}
	
		if (!empty($search_terms))
		{
			$request = $smcFunc['db_query']('', "
				SELECT id
				FROM {db_prefix}search_terms
				WHERE text = {string:phrase}
				LIMIT 1",
				array(
					'phrase' => $search_terms
				)
			);
			
			list ($id) = $smcFunc['db_fetch_row']($request);
			
			if ($smcFunc['db_num_rows']($request) == 0)
			{
				$smcFunc['db_insert']('',
					'{db_prefix}search_terms',
					array('text' => 'string-100', 'hit' => 'int'),
					array($search_terms, 1),
					array('id')
				);
			}
			else
			{
				$smcFunc['db_query']('', '
					UPDATE {db_prefix}search_terms
					SET hit = hit + 1
					WHERE id = {int:id}',
					array(
						'id' => $id
					)
				);
			}
			
			$smcFunc['db_free_result']($request);
		}
	}
}

// Убираем двойные кавычки из описания, а также любые теги
function optimus_meta_chars($text)
{
	$result = $text;

	if (strpos($text, '"') !== false)
		$result = str_replace('"', '', strip_tags(un_htmlspecialchars($text)));

	return $result;
}

// Выборка фразы из первого сообщения каждой темы
function optimus_meta_teaser()
{
	global $smcFunc, $context;

	$request = $smcFunc['db_query']('', '
		SELECT SUBSTRING(body, 1, 200)
		FROM {db_prefix}messages
		WHERE id_msg = {int:id_msg}
		LIMIT 1',
		array(
			'id_msg' => $context['first_message']
		)
	);

	list ($teaser) = $smcFunc['db_fetch_row']($request);
	$smcFunc['db_free_result']($request);
	
	$teaser = optimus_meta_chars(str_replace('<br />', ' ', parse_bbc($teaser, false)));
	
	// Если длина первого сообщения меньше 150 символов, оно целиком попадает в description
	if ($smcFunc['strlen']($teaser) < 150) return strip_tags($teaser);

	// Иначе отсекаем первые 150 символов
	$teaser = $smcFunc['substr']($teaser, 0, 150);
	
	$teaser = str_replace("&nbsp;", "", $teaser);
	
	// Затем убираем всё до первого отступа
	$tmp1 = $smcFunc['substr']($teaser, 0, $smcFunc['strpos']($teaser, '  '));
	
	// Или до первой точки
	$tmp2 = $smcFunc['substr']($teaser, 0, $smcFunc['strpos']($teaser, '.'));
	
	// Или же до первого восклицательного знака
	$tmp3 = $smcFunc['substr']($teaser, 0, $smcFunc['strpos']($teaser, '!'));
	
	// Если ни одно из трёх условий выше не подходит, то просто выводим первые 150 символов, с удалением всех пробелов справа
	$result = !empty($tmp1) ? $tmp1 : (!empty($tmp2) ? $tmp2 : (!empty($tmp3) ? $tmp3 : rtrim($teaser)));

	return strip_tags($result);
}

// Здесь у нас различные замены в буфере
function optimus_buffer(&$buffer)
{
	global $modSettings, $context, $txt, $scripturl, $boardurl, $sourcedir, $forum_copyright, $boarddir;
	
	if (isset($_REQUEST['xml']) || $context['current_action'] == 'printpage') return $buffer;
	
	$replacements = array();

	if (empty($_REQUEST['action']) || !empty($_REQUEST['board']) || !empty($_REQUEST['topic']) || $context['current_action'] == 'media')
	{
		// Description
		if (!empty($context['optimus_description']))
		{
			$desc_old = '<meta name="description" content="' . $context['page_title_html_safe'] . '" />';
			$desc_new = '<meta name="description" content="' . $context['optimus_description'] . '" />';
			$replacements[$desc_old] = $desc_new;
		}
		
		// Verification tags
		if (!empty($modSettings['optimus_meta']) && $modSettings['optimus_portal_compat'] != 4)
		{
			$meta = '';
			$test = @unserialize($modSettings['optimus_meta']);
			foreach ($test as $var)
				$meta .= "\n\t" . '<meta name="' . $var['name'] . '" content="' . $var['content'] . '" />';
			$charset_meta = '<meta http-equiv="Content-Type" content="text/html; charset=' . $context['character_set'] . '" />';
			$check_meta = $charset_meta . $meta;
			$replacements[$charset_meta] = $check_meta;
		}
	}
	
	// Prev/next links ~ http://googlewebmastercentral.blogspot.com/2011/09/pagination-with-relnext-and-relprev.html
	if (!empty($_REQUEST['topic']) && isset($context['start']) && !empty($context['page_info']['num_pages']))
	{
		$prev = '<link rel="prev" href="' . $scripturl . '?topic=' . $context['current_topic'] . '.0;prev_next=prev" />' . "\n\t";
		$next = '<link rel="next" href="' . $scripturl . '?topic=' . $context['current_topic'] . '.0;prev_next=next" />' . "\n\t";
		$new_prev = '<link rel="prev" href="' . $scripturl . '?topic=' . $context['current_topic'] . '.' . ($context['start'] - $modSettings['defaultMaxMessages']) . '" />' . "\n\t";
		$new_next = '<link rel="next" href="' . $scripturl . '?topic=' . $context['current_topic'] . '.' . ($context['start'] + $modSettings['defaultMaxMessages']) . '" />' . "\n\t";
		
		if ($context['page_info']['num_pages'] > 1)
		{
			if ($context['page_info']['current_page'] == 1) {
				$replacements[$prev] = '';
				$replacements[$next] = $new_next;
			}
			if ($context['page_info']['current_page'] == $context['page_info']['num_pages']) {
				$replacements[$prev] = $new_prev;
				$replacements[$next] = '';
			}
			if ($context['page_info']['current_page'] < $context['page_info']['num_pages'] && $context['page_info']['current_page'] > 1) {
				$replacements[$prev] = $new_prev;
				$replacements[$next] = $new_next;
			}
		}
		else
			$replacements[$prev] = $replacements[$next] = '';
	}
	
	// The Open Graph Protocol for media pages
	if ($context['current_action'] == 'media' && !empty($_REQUEST['sa']) && !empty($_REQUEST['in']))
	{
		if ($_REQUEST['sa'] == 'item')
		{
			$item = (int) $_REQUEST['in'];
			
			if (function_exists('aeva_getItemData'))
			{
				$handler = new aeva_media_handler;
				$exif = @unserialize($context['item_data']['exif']);
				
				if ($context['item_data']['type'] == 'video')
				{
					$xmlns = 'html xmlns="http://www.w3.org/1999/xhtml"';
					$new_xmlns = $xmlns . ' xmlns:og="http://ogp.me/ns#"';
					$replacements[$xmlns] = $new_xmlns;
				
					$duration = $exif['duration'];
					
					$context['ogp_meta'] = '<meta property="og:title" content="' . $context['item_data']['title'] . '" />
	<meta property="og:url" content="' . $scripturl . '?action=media;sa=item;in=' . $item . '" />
	<meta property="og:image" content="' . $scripturl . '?action=media;sa=media;in=' . $item . ';thumb" />';
	
					if (!empty($context['item_data']['description']))
						$context['ogp_meta'] .= '
	<meta property="og:description" content="' . html_entity_decode($context['item_data']['description'], ENT_QUOTES, $context['character_set']) . '" />';
	
					$context['ogp_meta'] .= '
	<meta property="og:video" content="' . $boardurl . '/MGalleryItem.php?id=' . $item . '" />		
	<meta property="og:video:height" content="' . $context['item_data']['height'] . '" />
	<meta property="og:video:width" content="' . $context['item_data']['width'] . '" />
	<meta property="og:video:type" content="' . $handler->getMimeFromExt($context['item_data']['filename']) . '" />	
	<meta property="og:duration" content="' . $duration . '" />';
				}
			
				if (!empty($context['ogp_meta'])) {
					$head = '<title>' . $context['page_title_html_safe'] . '</title>';
					$new_head = $context['ogp_meta'] . "\n\t" . $head;
					$replacements[$head] = $new_head;
				}
			}
		}
	}
	
	// Counters
	$ignored_actions = !empty($modSettings['optimus_ignored_actions']) ? explode(",", $modSettings['optimus_ignored_actions']) : array();
	if (!in_array($context['current_action'], $ignored_actions))
		if (!empty($modSettings['optimus_count_code']))
			$replacements[$forum_copyright] = $modSettings['optimus_count_code'] . '<br />' . $forum_copyright;
		
	// XML sitemap link
	if (file_exists($boarddir . '/sitemap.xml'))
	{
		$text = '<li class="last"><a id="button_wap2"';
		$link = '<li><a href="' . $boardurl . '/sitemap.xml" target="_blank">' . $txt['optimus_sitemap_xml_link'] . '</a></li>';
		$replacements[$text] = $link . $text;
	}
	
	return str_replace(array_keys($replacements), array_values($replacements), $buffer);
}

?>