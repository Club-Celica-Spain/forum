<?php
/*******************************************************************************
* Optimus Brave © 2010-2013, Bugo										       *
********************************************************************************
* Admin-Optimus.php															   *
********************************************************************************
* License http://creativecommons.org/licenses/by-nc-nd/3.0/deed.ru CC BY-NC-ND *
* Support and updates for this software can be found at	http://dragomano.ru    *
*******************************************************************************/

if (!defined('SMF'))
	die('Hacking attempt...');
	
// Раздел настроек мода в админке
function optimus_admin_areas(&$admin_areas)
{
	global $txt;
	
	$counter = array_search('featuresettings', array_keys($admin_areas['config']['areas'])) + 1;

	$admin_areas['config']['areas'] = array_merge(
		array_slice($admin_areas['config']['areas'], 0, $counter, true),
		array(
			'optimus' => array(
				'label' => $txt['optimus_title'],
				'function' => create_function(null, 'optimus_area_settings();'),
				'icon' => 'maintain.gif',
				'subsections' => array(
					'common' => array($txt['optimus_common_title']),
					'verification' => array($txt['optimus_verification_title']),
					'counters' => array($txt['optimus_counters']),
					'robots' => array($txt['optimus_robots_title']),
					'terms' => array($txt['optimus_terms_title']),
				),
			),
		),
		array_slice($admin_areas['config']['areas'], $counter, count($admin_areas['config']['areas']), true)
	);
}

// Здесь подключаем все имеющиеся функции с настройками мода
function optimus_area_settings()
{
	global $sourcedir, $context, $txt;

	require_once($sourcedir . '/ManageSettings.php');
	
	$context['page_title'] = $txt['optimus_main'];

	$subActions = array(
		'common' => 'optimus_common_settings',
		'verification' => 'optimus_verification_settings',
		'counters' => 'optimus_counters_settings',
		'robots' => 'optimus_robots_settings',
		'terms' => 'optimus_terms_settings'
	);
	
	loadGeneralSettingParameters($subActions, 'common');

	// Load up all the tabs...
	$context[$context['admin_menu_name']]['tab_data'] = array(
		'title' => $txt['optimus_title'],
		'tabs' => array(
			'common' => array(
				'description' => $txt['optimus_common_desc'],
			),
			'verification' => array(
				'description' => $txt['optimus_verification_desc'],
			),
			'counters' => array(
				'description' => $txt['optimus_counters_desc'],
			),
			'robots' => array(
				'description' => $txt['optimus_robots_desc'],
			),
			'terms' => array(
				'description' => $txt['optimus_terms_desc'],
			),
		),
	);
	
	call_user_func($subActions[$_REQUEST['sa']]);
}

// Первая страница настроек
function optimus_common_settings()
{
	global $context, $txt, $scripturl;
	
	loadTemplate('Optimus', 'optimus');
	$context['sub_template'] = 'common';
	$context['page_title'] .= ' - ' . $txt['optimus_common_title'];
	$context['post_url'] = $scripturl . '?action=admin;area=optimus;sa=common;save';

	$config_vars = array(
		array('int', 'optimus_portal_compat'),
		array('text', 'optimus_portal_index'),
		array('text', 'optimus_forum_index'),
		array('text', 'optimus_description'),
		array('check', 'optimus_board_description'),
		array('check', 'optimus_topic_description'),
		array('check', 'optimus_404_status')
	);
	
	$templates = array();
	foreach ($txt['optimus_templates'] as $name => $template) {
		$templates[$name] = array(
			'name' => isset($_POST['' . $name . '_name']) ? $_POST['' . $name . '_name'] : '',
			'page' => isset($_POST['' . $name . '_page']) ? $_POST['' . $name . '_page'] : '',
			'site' => isset($_POST['' . $name . '_site']) ? $_POST['' . $name . '_site'] : '',
		);
	}
	
	// Saving?
	if (isset($_GET['save']))
	{
		checkSession();
		$save_vars = $config_vars;
		saveDBSettings($save_vars);
		updateSettings(array('optimus_templates' => serialize($templates)));
		redirectexit('action=admin;area=optimus;sa=common');
	}

	prepareDBSettingContext($config_vars);
}

// Вторая страница настроек
function optimus_verification_settings()
{
	global $context, $scripturl, $txt;

	loadTemplate('Optimus', 'optimus');
	$context['sub_template'] = 'verification';
	$context['page_title'] .= ' - ' . $txt['optimus_verification_title'];
	$context['post_url'] = $scripturl . '?action=admin;area=optimus;sa=verification;save';
	
	$config_vars = array();
	
	$meta = array();
	foreach ($txt['optimus_search_engines'] as $engine => $data) {
		if (!empty($_POST['' . $engine . '_content'])) {
			$meta[$engine] = array(
				'name' => isset($_POST['' . $engine . '_name']) ? $_POST['' . $engine . '_name'] : $data[0],
				'content' => $_POST['' . $engine . '_content']
			);
		}
	}
	
	// Saving?
	if (isset($_GET['save']))
	{
		checkSession();
		$save_vars = $config_vars;
		saveDBSettings($save_vars);
		updateSettings(array('optimus_meta' => serialize($meta)));
		redirectexit('action=admin;area=optimus;sa=verification');
	}

	prepareDBSettingContext($config_vars);
}

// Третья страница настроек
function optimus_counters_settings()
{
	global $context, $txt, $scripturl, $settings;
	
	loadTemplate('Optimus', array('codemirror', 'optimus'));
	$context['sub_template'] = 'counters';	
	$context['page_title'] .= ' - ' . $txt['optimus_counters'];
	$context['post_url'] = $scripturl . '?action=admin;area=optimus;sa=counters;save';
	
	$config_vars = array(
    	array('large_text', 'optimus_head_code'),
		array('large_text', 'optimus_stat_code'),
		array('large_text', 'optimus_count_code'),
		array('text', 'optimus_ignored_actions')
	);
	
	// Saving?
	if (isset($_GET['save']))
	{
		checkSession();
		$save_vars = $config_vars;
		saveDBSettings($save_vars);
		redirectexit('action=admin;area=optimus;sa=counters');
	}

	prepareDBSettingContext($config_vars);
}

// Четвертая страница настроек
function optimus_robots_settings()
{
	global $context, $txt, $scripturl, $robots_path;

	loadTemplate('Optimus', 'optimus');
	$context['sub_template'] = 'robots';
	$context['page_title'] .= ' - ' . $txt['optimus_robots_title'];
	$context['post_url'] = $scripturl . '?action=admin;area=optimus;sa=robots;save';
	
	$robots_path = $_SERVER['DOCUMENT_ROOT'] . "/robots.txt";
	$context['robots_content'] = file_exists($robots_path) ? @file_get_contents($robots_path) : '';
	
	optimus_robots_create();

	if (isset($_GET['save']))
	{
		checkSession();
		if (isset($_POST['robots']))
		{
			$robots = stripslashes($_POST['robots']);
			file_put_contents($robots_path, $robots);
		}
		redirectexit('action=admin;area=optimus;sa=robots');
	}
}

// Страница с перечнем поисковых запросов
function optimus_terms_settings()
{
	global $context, $txt, $scripturl, $modSettings, $smcFunc;

	loadTemplate('Optimus', 'optimus');
	$context['sub_template'] = 'terms';
	$context['page_title'] .= ' - ' . $txt['optimus_terms_title'];
	$context['post_url'] = $scripturl . '?action=admin;area=optimus;sa=terms;save';

	$config_vars = array(
		array('check', 'optimus_search_stats')
	);
	
	$context['search_terms'] = array();
	
	if (!empty($modSettings['optimus_search_stats']))
	{
		$request = $smcFunc['db_query']('', '
			SELECT text, hit
			FROM {db_prefix}search_terms
			ORDER BY hit DESC
			LIMIT 30',
			array()
		);
		
		$scale = 1;
		$context['stats_chart'] = false;
		
		while ($row = $smcFunc['db_fetch_assoc']($request))
		{
			if ($scale < $row['hit'])
				$scale = $row['hit'];
			
			$context['search_terms'][] = array(
				'text' => $row['text'],
				'scale' => round(($row['hit'] * 100) / $scale),
				'hit' => $row['hit']
			);
			
			if ($row['hit'] > 10) $context['stats_chart'] = true;
		}
		
		$smcFunc['db_free_result']($request);
	}
		
	// Saving?
	if (isset($_GET['save']))
	{
		checkSession();
		$save_vars = $config_vars;
		saveDBSettings($save_vars);
		redirectexit('action=admin;area=optimus;sa=terms');
	}

	prepareDBSettingContext($config_vars);
}

// Функция создания файла robots.txt
function optimus_robots_create()
{
	global $boardurl, $smcFunc, $boarddir, $modSettings, $adkportal, $ultimateportalSettings, $ezpSettings, $context, $sourcedir, $txt, $scripturl;
	
	$url_path = @parse_url($boardurl, PHP_URL_PATH);
	
	// Запрашиваем все имеющиеся права доступа для гостей
	$yes = array();

	$request = $smcFunc['db_query']('', '
		SELECT ps.permission
		FROM {db_prefix}permissions AS ps
		WHERE ps.id_group = -1',
		array()
	);

	while ($row = $smcFunc['db_fetch_assoc']($request))
		$yes[$row['permission']] = true;

	$smcFunc['db_free_result']($request);
	
	// SimplePortal
	$sp = isset($modSettings['sp_portal_mode']) && $modSettings['sp_portal_mode'] == 1 && function_exists('sportal_init');
	// Файл, используемый SP при автономном режиме
	$autosp = !empty($modSettings['sp_standalone_url']) ? substr($modSettings['sp_standalone_url'], strlen($boardurl)) : '';
	// PortaMx
	$pm = !empty($modSettings['pmx_frontmode']) && function_exists('PortaMx');
	// Проверяем, не является ли экшен forum алиасом для community (в PortaMx)
	$alias = !empty($modSettings['pmxsef_aliasactions']) && strpos($modSettings['pmxsef_aliasactions'], 'forum');
	// Adk Portal
	$ap = !empty($adkportal['adk_enable']) && function_exists('adkportalSettings');
	// Файл, используемый AP при автономном режиме	
	$autoap = $ap && !empty($adkportal['adk_stand_alone_url']) && $adkportal['adk_enable'] == 2 ? substr($adkportal['adk_stand_alone_url'], strlen($boardurl)) : '';
	// Dream Portal
	$dp = function_exists('dp_main') && isset($yes['dream_portal_view']) ? in_array('dp', $context['admin_features']) : false;
	// TinyPortal
	$tp = function_exists('TPortal_init');
	// EzPortal
	$ez = !empty($ezpSettings['ezp_portal_enable']) && function_exists('EzPortalMain');
	// Aeva Media
	$aeva = file_exists($sourcedir . '/Aeva-Subs.php') && isset($yes['aeva_access']);
	// SMF Gallery
	$gal = file_exists($sourcedir . '/Gallery2.php') && isset($yes['smfgallery_view']);
	// SMF Arcade
	$arc = file_exists($sourcedir . '/Subs-Arcade.php') && isset($yes['arcade_view']);
	// FAQ mod
	$faq = file_exists($sourcedir . '/Subs-Faq.php') && isset($yes['faqperview']);
	// PMXBlog
	$blog = file_exists($sourcedir . '/PmxBlog.php') && !empty($modSettings['pmxblog_enabled']);
	// SMF Project Tools
	$pj = file_exists($sourcedir . '/Project.php') && in_array('pj', $context['admin_features']) && isset($yes['project_access']);
	// Simple Classifieds
	$sc = file_exists($sourcedir . '/Classifieds/Classifieds-Subs.php') && isset($yes['view_classifieds']);
	// SC Light
	$scl = file_exists($sourcedir . '/Subs-SCL.php') && !empty($modSettings['scl_mode']);
	// Topic Rating Bar
	$trb = file_exists($sourcedir . '/Subs-TopicRating.php');
	// Downloads System
	$ds = file_exists($sourcedir . '/Downloads2.php') && isset($yes['downloads_view']);
	// SMF Links
	$sl = isset($txt['smflinks_menu']) && isset($yes['view_smflinks']);
	
	// Проверяем существование файлов sitemap
	$map = 'sitemap.xml';
	$path_map = $boardurl . '/' . $map;
	$temp_map = file_exists($boarddir . '/' . $map);
	if (!$temp_map) $map = '';
	else $map = $path_map;

	// Заполняем основной массив
	$robots = array(
		"User-agent: Googlebot-Image",
		$aeva ? "Allow: " . $url_path . "/*media*item" : "",
		$aeva ? "Allow: " . $url_path . "/MGalleryItem.php" : "",
		$gal ? "Allow: " . $url_path . "/*gallery*view" : "",
		"Disallow: " . $url_path . "/",
		"|",
		"User-agent: YandexImages",
		$aeva ? "Allow: " . $url_path . "/*media*item" : "",
		$aeva ? "Allow: " . $url_path . "/MGalleryItem.php" : "",
		$gal ? "Allow: " . $url_path . "/*gallery*view" : "",
		"Disallow: " . $url_path . "/",
		"|",
		"User-agent: msnbot-MM",
		$aeva ? "Allow: " . $url_path . "/*media*item" : "",
		$aeva ? "Allow: " . $url_path . "/MGalleryItem.php" : "",
		$gal ? "Allow: " . $url_path . "/*gallery*view" : "",
		"Disallow: " . $url_path . "/",
		"|",
		"User-agent: Googlebot-Mobile",
		"Allow: " . $url_path . "/*wap",
		"Disallow: " . $url_path . "/",
		"|",
		"User-agent: YandexImageResizer",
		"Allow: " . $url_path . "/*wap",
		"Disallow: " . $url_path . "/",
		"|",
		"User-agent: MediaPartners-Google",
		"Allow: " . $url_path . "/",
		"|",
		substr($txt['lang_locale'], 0, 2) == 'ru' ? "User-agent: Baiduspider\nDisallow: " . $url_path . "/\n|" : "", // Зачем нам китайцы на форуме? :)
		// Правила для всех остальных пауков
		"User-agent: *",
		// Main
		"Allow: " . $url_path . "/$",
		// action=forum
		$sp || $tp || $ez ? "Allow: " . $url_path . "/*forum$" : "",
		// SimplePortal
		isset($modSettings['sp_portal_mode']) && $modSettings['sp_portal_mode'] == 3 && file_exists($boarddir . $autosp) ? "Allow: " . $url_path . $autosp : "",
		$sp ? "Allow: " . $url_path . "/*page*page" : "",
		// PortaMx
		$pm && $alias ? "Allow: " . $url_path . "/*forum$" : "",
		$pm && !$alias ? "Allow: " . $url_path . "/*community$" : "",
		// Adk Portal
		$ap && !$autoap ? "Allow: " . $url_path . "/*forum$" : "",
		isset($adkportal['adk_enable']) && $adkportal['adk_enable'] == 2 && file_exists($boarddir . $autoap) ? "Allow: " . $url_path . $autoap : "",
		$ap || $dp || $tp || $ez ? "Allow: " . $url_path . "/*page" : "",
		// Aeva Media
		$aeva ? "Allow: " . $url_path . "/*media$\nAllow: " . $url_path . "/*media*album\nAllow: " . $url_path . "/*media*item\nAllow: " . $url_path . "/MGalleryItem.php?id" : "",
		// SMF Gallery mod
		$gal ? "Allow: " . $url_path . "/*gallery$\nAllow: " . $url_path . "/*gallery*cat\nAllow: " . $url_path . "/*gallery*view" : "",
		// RSS
		!empty($modSettings['xmlnews_enable']) ? "Allow: " . $url_path . "/*action=.xml" : "",
		// Sitemap
		!empty($map) || file_exists($sourcedir . '/Sitemap.php') ? "Allow: " . $url_path . "/*sitemap" : "",
		// SMF Arcade
		$arc ? "Allow: " . $url_path . "/*arcade$\nAllow: " . $url_path . "/*arcade*game" : "",
		// FAQ
		$faq ? "Allow: " . $url_path . "/*faq" : "",
		// PMXBlog
		$blog ? "Allow: " . $url_path . "/*pmxblog" : "",
		// Project Tools
		$pj ? "Allow: " . $url_path . "/*project\nAllow: " . $url_path . "/*issue" : "",
		// SC Light
		$scl ? "Allow: " . $url_path . "/*scl" : "",
		// Simple Classifieds
		$sc ? "Allow: " . $url_path . "/*bbs" : "",
		$trb ? "Allow: " . $url_path . "/*rating" : "",
		// Downloads System
		$ds ? "Allow: " . $url_path . "/*downloads" : "",
		// SMF Links
		$sl ? "Allow: " . $url_path . "/*links" : "",
		// Remove *action, *wap, *.msg, *.new etc
		"Disallow: " . $url_path . "/*action",
		"Disallow: " . $url_path . "/*wap",
		"Disallow: " . $url_path . "/*board=*wap",
		"Disallow: " . $url_path . "/*topic=*wap",
		!empty($modSettings['queryless_urls']) ? "" : "Disallow: " . $url_path . "/*topic=*.msg\nDisallow: " . $url_path . "/*topic=*.new",
		"Disallow: " . $url_path . "/*;",
		"Disallow: " . $url_path . "/*PHPSESSID",
		// Content
		!empty($modSettings['queryless_urls'])
			? "Allow: " . $url_path . "/*board*.html$\nAllow: " . $url_path . "/*topic*.html$"
			: "Allow: " . $url_path . "/*board\nAllow: " . $url_path . "/*topic",
		// All
		"Disallow: " . $url_path . "/",
		// Sitemap XML
		!empty($map) ? "Sitemap: " . $map : "",
		file_exists($sourcedir . '/Sitemap.php') ? "Sitemap: " . $scripturl . "?action=sitemap;xml" : "",
		// Delay for spiders
		"Crawl-delay: 5",
		// for Yandex only
		"Clean-param: PHPSESSID " . $url_path . "/index.php",
		!empty($_SERVER['HTTP_HOST']) ? "Host: " . $_SERVER['HTTP_HOST'] : ""
	);

	$new_robots = array();
	foreach ($robots as $line)
		if (!empty($line)) $new_robots[] = $line;
	$new_robots = implode("<br />", str_replace("|", "", $new_robots));
	
	$context['new_robots_content'] = parse_bbc('[code]' . $new_robots . '[/code]');
}

// Обработка дат
function optimus_sitemap_date($timestamp = '')
{
	$timestamp = empty($timestamp) ? time() : $timestamp;
	$gmt = substr(date("O", $timestamp), 0, 3) . ':00';
	$result = date('Y-m-d\TH:i:s', $timestamp) . $gmt;
	
	return $result;
}

// Создаем файл карты
function optimus_file_create($path, $data)
{
	if (!$fp = @fopen($path, 'w')) return false;

	flock($fp, LOCK_EX);
	fwrite($fp, $data);
	flock($fp, LOCK_UN);
	fclose($fp);
	
	return true;
}

// Если количество урлов больше 50000, заканчиваем сказку
function check_count_urls($array)
{
	global $txt;
	
	if (count($array) > 50000)
		log_error($txt['optimus_sitemap_url_limit'] . $txt['optimus_sitemap_rec'], 'general');
	
	return;
}

// Если размер файла превышает 10 МБ, отправляем запись в Журнал ошибок
function check_filesize($file)
{
	global $txt;
	
	clearstatcache();

	if (filesize($file) > 10485760)
		log_error(sprintf($txt['optimus_sitemap_size_limit'], @pathinfo($file, PATHINFO_BASENAME)) . $txt['optimus_sitemap_rec'], 'general');
	
	return;
}

// Определяем периодичность обновлений
function optimus_sitemap_frequency($time)
{
	$frequency = time() - $time;
	
	if ($frequency < (24*60*60))
		return 'hourly';
	elseif ($frequency < (24*60*60*7))
		return 'daily';
	elseif ($frequency < (24*60*60*7*(52/12)))
		return 'weekly';
	elseif ($frequency < (24*60*60*365))
		return 'monthly';

	return 'yearly';
}

// Функция генерации карты форума (активируется в Диспетчере задач)
function scheduled_optimus_sitemap()
{
	global $modSettings, $sourcedir, $boardurl, $smcFunc, $scripturl, $context, $boarddir;
	
	$t = "\t";
	$n = "\n";
	$sef = false;
	$mobile_type = 'wap2'; // wap, wap2, imode
	$xmlns = 'xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"';
	$tab = $xmlns . $n . $t . $t;
	$xmlns_mobile = $tab . 'xmlns:mobile="http://www.google.com/schemas/sitemap-mobile/1.0"';
	$xmlns_image = $tab . 'xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"';
	$xmlns_video = $tab . 'xmlns:video="http://www.google.com/schemas/sitemap-video/1.1"';
	
	// SimpleSEF enabled?
	$sef = !empty($modSettings['simplesef_enable']) && file_exists($sourcedir . '/SimpleSEF.php');
	if ($sef)
	{
		function create_sefurl($url)
		{
			global $sourcedir;
			
			require_once($sourcedir . '/SimpleSEF.php');
			$simple = new SimpleSEF;
			
			return $simple->create_sef_url($url);
		}
	}
	
	// PortaMx SEF enabled?
	if (file_exists($sourcedir . '/PortaMx/PortaMxSEF.php') && function_exists('create_sefurl')) $sef = true;
	
	// Объявляем массивы, с которыми будем работать
	$fm = $media = $boards = $topics = array();
	
	// Boards
	$request = $smcFunc['db_query']('', '
		SELECT b.id_board, m.poster_time, m.modified_time
		FROM {db_prefix}boards AS b
			LEFT JOIN {db_prefix}messages AS m ON (m.id_msg = b.id_last_msg)
		WHERE FIND_IN_SET(-1, b.member_groups) != 0' . (!empty($modSettings['recycle_board']) ? ' AND b.id_board <> ' . (int) $modSettings['recycle_board'] : '') . '
		ORDER BY b.id_board',
		array()
	);
	
	while ($row = $smcFunc['db_fetch_assoc']($request))
		$boards[] = $row;
	
	$smcFunc['db_free_result']($request);
	
	$last = array(0);
	foreach ($boards as $entry)	$last[] = empty($entry['modified_time']) ? (empty($entry['poster_time']) ? '' : $entry['poster_time']) : $entry['modified_time'];
	$last_edit = max($last);
	
	// Здесь быстренько заполняем информацию о главной странице
	$fm[] = array(
		'loc' => $boardurl . '/',
		'wap' => $scripturl . '/?' . $mobile_type,
		'lastmod' => optimus_sitemap_date($last_edit),
		'changefreq' => optimus_sitemap_frequency($last_edit),
		'priority' => 1
	);
	
	// А здесь — для разделов
	foreach ($boards as $entry)
	{
		$last_edit = empty($entry['modified_time']) ? $entry['poster_time'] : $entry['modified_time'];
		
		// Поддержка мода BoardNoIndex
		if (!empty($modSettings['BoardNoIndex_enabled']))
		{
			if (!in_array($entry['id_board'], @unserialize($modSettings['BoardNoIndex_select_boards'])))
				$fm[] = array(
					'loc' => $scripturl . '?board=' . $entry['id_board'] . '.0',
					'wap' => $scripturl . '?board=' . $entry['id_board'] . '.0;' . $mobile_type,
					'lastmod' => optimus_sitemap_date($last_edit),
					'changefreq' => optimus_sitemap_frequency($last_edit),
					'priority' => 0.8
				);
		}
		else
		{
			$fm[] = array(
				'loc' => $scripturl . '?board=' . $entry['id_board'] . '.0',
				'wap' => $scripturl . '?board=' . $entry['id_board'] . '.0;' . $mobile_type,
				'lastmod' => optimus_sitemap_date($last_edit),
				'changefreq' => optimus_sitemap_frequency($last_edit),
				'priority' => 0.8
			);
		}
	}

	// Topics
	$request = $smcFunc['db_query']('', '
		SELECT t.id_topic, t.id_board, t.id_last_msg, m.poster_time, m.modified_time
		FROM {db_prefix}topics AS t
			INNER JOIN {db_prefix}messages AS m ON (m.id_msg = t.id_last_msg)
			INNER JOIN {db_prefix}boards AS b ON (b.id_board = t.id_board)
		WHERE FIND_IN_SET(-1, b.member_groups) != 0' . (!empty($modSettings['recycle_board']) ? ' AND b.id_board <> ' . (int) $modSettings['recycle_board'] : '') . '
		ORDER BY t.id_topic',
		array()
	);
	
	while ($row = $smcFunc['db_fetch_assoc']($request))
		$topics[] = $row;
	
	$smcFunc['db_free_result']($request);
	
	foreach ($topics as $entry)
	{
		$last_edit = empty($entry['modified_time']) ? $entry['poster_time'] : $entry['modified_time'];
		
		// Поддержка мода BoardNoIndex
		if (!empty($modSettings['BoardNoIndex_enabled']))
		{
			if (!in_array($entry['id_board'], @unserialize($modSettings['BoardNoIndex_select_boards'])))
				$fm[] = array(
					'loc' => $scripturl . '?topic=' . $entry['id_topic'] . '.0',
					'wap' => $scripturl . '?topic=' . $entry['id_topic'] . '.0;' . $mobile_type,
					'lastmod' => optimus_sitemap_date($last_edit),
					'changefreq' => optimus_sitemap_frequency($last_edit),
					'priority' => 0.6
				);
		}
		else
		{
			$fm[] = array(
				'loc' => $scripturl . '?topic=' . $entry['id_topic'] . '.0',
				'wap' => $scripturl . '?topic=' . $entry['id_topic'] . '.0;' . $mobile_type,
				'lastmod' => optimus_sitemap_date($last_edit),
				'changefreq' => optimus_sitemap_frequency($last_edit),
				'priority' => 0.6
			);
		}
	}
	
	// Aeva Media
	if (file_exists($sourcedir . '/Aeva-Subs.php'))
	{
		$query_one = $smcFunc['db_query']('', "SHOW TABLES LIKE '{db_prefix}aeva_media'", array());
		$query_two = $smcFunc['db_query']('', "SHOW TABLES LIKE '{db_prefix}aeva_albums'", array());
		$result = $smcFunc['db_num_rows']($query_one) != 0 && $smcFunc['db_num_rows']($query_two) != 0;

		if ($result)
		{
			$items = array();
		
			$request = $smcFunc['db_query']('', '
				SELECT am.id_media, am.title, am.description, am.type, am.album_id, am.rating, am.views, aa.name
				FROM {db_prefix}aeva_media AS am
					INNER JOIN {db_prefix}aeva_albums AS aa ON (aa.id_album = am.album_id)
					INNER JOIN {db_prefix}permissions AS ps ON (ps.id_group = -1)
				WHERE FIND_IN_SET(-1, aa.access) != 0
					AND ps.permission LIKE "aeva_access"
				ORDER BY am.id_media',
				array()
			);
		
			while ($row = $smcFunc['db_fetch_assoc']($request))
				$items[] = $row;
		
			$smcFunc['db_free_result']($request);
			
			// AM Items
			foreach ($items as $entry)
			{
				$media[] = array(
					'loc' => $scripturl . '?action=media;sa=item;in=' . $entry['id_media'],
					'album' => $scripturl . '?action=media;sa=album;in=' . $entry['album_id'],
					'image' => $entry['type'] == 'image' ? $boardurl . '/MGalleryItem.php?id=' . $entry['id_media'] : '',
					'video' => $entry['type'] == 'video' ? $boardurl . '/MGalleryItem.php?id=' . $entry['id_media'] : '',
					'caption' => $entry['title'],
					'thumb' => $scripturl . '?action=media;sa=media;in=' . $entry['id_media'] . ';thumb',
					'desc' => !empty($entry['description']) ? $entry['description'] : '',
					'rating' => !empty($entry['rating']) ? $entry['rating'] : 0,
					'count' => !empty($entry['views']) ? $entry['views'] : 0,
					'name' => $entry['name']
				);
			}
		}
	}
	
	// SMF Gallery mod
	if (file_exists($sourcedir . '/Gallery2.php'))
	{
		$query_one = $smcFunc['db_query']('', "SHOW TABLES LIKE '{db_prefix}gallery_cat'", array());
		$query_two = $smcFunc['db_query']('', "SHOW TABLES LIKE '{db_prefix}gallery_pic'", array());
		$result = $smcFunc['db_num_rows']($query_one) != 0 && $smcFunc['db_num_rows']($query_two) != 0;

		if ($result)
		{
			$items = array();
		
			$request = $smcFunc['db_query']('', '
				SELECT gp.id_picture, gp.title, gp.filename
				FROM {db_prefix}gallery_pic AS gp
					INNER JOIN {db_prefix}permissions AS ps ON (ps.id_group = -1)
				WHERE ps.permission LIKE "smfgallery_view"
				ORDER BY gp.id_picture',
				array()
			);
		
			while ($row = $smcFunc['db_fetch_assoc']($request))
				$items[] = $row;
		
			$smcFunc['db_free_result']($request);
			
			// Gallery Items
			foreach ($items as $entry)
			{
				$media[] = array(
					'loc' => $scripturl . '?action=gallery;sa=view;pic=' . $entry['id_picture'],
					'image' => $boardurl . '/gallery/' . $entry['filename'],
					'caption' => $entry['title']
				);
			}
		}
	}
	
	$header = '<' . '?xml version="1.0" encoding="UTF-8"?>' . $n . '<?xml-stylesheet type="text/xsl" href="' . $boardurl . '/Themes/default/css/sitemap.xsl"?>' . $n . '<urlset ' . $xmlns . '>' . $n;
	$footer = '</urlset>';
	$out = '';
	
	check_count_urls($fm);
	
	foreach ($fm as $entry)
	{
		$out .= $t . '<url>' . $n;
		$out .= $t . $t . '<loc>' . ($sef ? create_sefurl($entry['loc']) : $entry['loc']) . '</loc>' . $n;
		$out .= $t . $t . '<lastmod>' . $entry['lastmod'] . '</lastmod>' . $n;
		$out .= $t . $t . '<changefreq>' . $entry['changefreq'] . '</changefreq>' . $n;
		$out .= $t . $t . '<priority>' . $entry['priority'] . '</priority>' . $n;
		$out .= $t . '</url>' . $n;
	}
 
	// Это для мобилок, задел на будущее
	if (!empty($mobile_type))
	{
		$mobile = '';
		foreach ($fm as $entry)
		{
			if (!empty($entry['wap']))
			{
				$mobile .= $t . '<url>' . $n;
				$mobile .= $t . $t . '<loc>' . ($sef ? create_sefurl($entry['wap']) : $entry['wap']) . '</loc>' . $n;
				$mobile .= $t . $t . '<lastmod>' . $entry['lastmod'] . '</lastmod>' . $n;
				$mobile .= $t . $t . '<mobile:mobile/>' . $n;
				$mobile .= $t . '</url>' . $n;
			}
		}
	}
	
	// Карта изображений в Галерее
	$images = '';
	foreach ($media as $entry)
	{
		if (!empty($entry['image']))
		{
			$images .= $t . '<url>' . $n;
			$images .= $t . $t . '<loc>' . ($sef ? create_sefurl($entry['loc']) : $entry['loc']) . '</loc>' . $n;
			$images .= $t . $t . '<image:image>' . $n;
			$images .= $t . $t . $t . '<image:loc>' . $entry['image'] . '</image:loc>' . $n;
			$images .= $t . $t . $t . '<image:caption>' . $entry['caption'] . '</image:caption>' . $n;
			$images .= $t . $t . '</image:image>' . $n;
			$images .= $t . '</url>' . $n;
		}
	}

	// Карта видеороликов в Галерее
	$videos = '';
	foreach ($media as $entry)
	{
		if (!empty($entry['video']))
		{
			$videos .= $t . '<url>' . $n;
			$videos .= $t . $t . '<loc>' . ($sef ? create_sefurl($entry['loc']) : $entry['loc']) . '</loc>' . $n;
			$videos .= $t . $t . '<video:video>' . $n;
			$videos .= $t . $t . $t . '<video:thumbnail_loc>' . ($sef ? create_sefurl($entry['thumb']) : $entry['thumb']) . '</video:thumbnail_loc>' . $n;
			$videos .= $t . $t . $t . '<video:title>' . $entry['caption'] . '</video:title>' . $n;
			$videos .= $t . $t . $t . '<video:description>' . $entry['desc'] . '</video:description>' . $n;
			$videos .= $t . $t . $t . '<video:content_loc>' . $entry['video'] . '</video:content_loc>' . $n;
			$videos .= $t . $t . $t . '<video:rating>' . $entry['rating'] . '</video:rating>' . $n;
			$videos .= $t . $t . $t . '<video:view_count>' . $entry['count'] . '</video:view_count>' . $n;
			$videos .= $t . $t . $t . '<video:gallery_loc title="' . $entry['name'] . '">' . ($sef ? create_sefurl($entry['album']) : $entry['album']) . '</video:gallery_loc>' . $n;
			$videos .= $t . $t . '</video:video>' . $n;
			$videos .= $t . '</url>' . $n;
		}
	}
	
	// Pretty URLs installed?
	$pretty = $sourcedir . '/PrettyUrls-Filters.php';
	if (file_exists($pretty) && !empty($modSettings['pretty_enable_filters']))
	{
		require_once($pretty);
		$context['pretty']['search_patterns'][] = '~(<loc>)([^#<]+)~';
		$context['pretty']['replace_patterns'][] = '~(<loc>)([^<]+)~';
		$context['pretty']['search_patterns'][] = '~(<video:thumbnail_loc>)([^#<]+)~';
		$context['pretty']['replace_patterns'][] = '~(<video:thumbnail_loc>)([^<]+)~';
		$context['pretty']['search_patterns'][] = '~(">)([^#<]+)~';
		$context['pretty']['replace_patterns'][] = '~(">)([^<]+)~';
		$out = pretty_rewrite_buffer($out);
		if (!empty($mobile)) $mobile = pretty_rewrite_buffer($mobile);
		if (!empty($images)) $images = pretty_rewrite_buffer($images);
		if (!empty($videos)) $videos = pretty_rewrite_buffer($videos);
	}
	
	$out = $header . $out . $footer;

	// Создаем обычную карту сайта
	$sitemap = $boarddir . '/sitemap.xml';
	optimus_file_create($sitemap, $out);
	check_filesize($sitemap);
	
	if (!empty($mobile) || !empty($images) || !empty($videos))
	{
		// Карта для мобилок
		if (!empty($mobile_type))
		{
			$header = '<' . '?xml version="1.0" encoding="UTF-8"?>' . $n . '<?xml-stylesheet type="text/xsl" href="' . $boardurl . '/Themes/default/css/sitemap.xsl"?>' . $n . '<urlset ' . $xmlns_mobile . '>' . $n;
			$mobile = $header . $mobile . $footer;
			$sitemap = $boarddir . '/sitemap_mobile.xml';
			optimus_file_create($sitemap, $mobile);
			check_filesize($sitemap);
		}
		
		// Карта ссылок на изображения в Галерее
		if (!empty($images))
		{
			$header = '<' . '?xml version="1.0" encoding="UTF-8"?>' . $n . '<?xml-stylesheet type="text/xsl" href="' . $boardurl . '/Themes/default/css/sitemap.xsl"?>' . $n . '<urlset ' . $xmlns_image . '>' . $n;
			$images = $header . $images . $footer;
			$sitemap = $boarddir . '/sitemap_images.xml';
			optimus_file_create($sitemap, $images);
			check_filesize($sitemap);
		}
		
		// Карта ссылок на видеоролики в Галерее
		if (!empty($videos))
		{
			$header = '<' . '?xml version="1.0" encoding="UTF-8"?>' . $n . '<?xml-stylesheet type="text/xsl" href="' . $boardurl . '/Themes/default/css/sitemap.xsl"?>' . $n . '<urlset ' . $xmlns_video . '>' . $n;
			$videos = $header . $videos . $footer;
			$sitemap = $boarddir . '/sitemap_videos.xml';
			optimus_file_create($sitemap, $videos);
			check_filesize($sitemap);
		}
	}
	
	// Return for the log...
	return true;
}

?>