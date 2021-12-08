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

function AdkAdmin()
{
	global $txt, $context, $sourcedir, $boardurl, $settings;
	
	isAllowedTo('adk_portal');
	
	loadTemplate('Adk-admin');
	
	if(loadLanguage('Adk-Admin') == false)
		loadLanguage('Adk-Admin','english');
			
	$subActions = array(
		'view' => 'view',
		'adksettings' => 'adksettings',
		'adksavesettings' => 'adksavesettings',
		'manageicons' => 'manageicons',
	);
	
	$context['html_headers'] = '<link rel="stylesheet" type="text/css" href="'.$boardurl.'/adkportal/css/admin_adkportal.css" />';
		
	$context[$context['admin_menu_name']]['tab_data'] = array(
		'title' => $txt['adk_title_admin_settings'],
		'description' => $txt['first_adk_descrip'],
		'tabs' => array(
			'view' => array(
				'description' => $txt['first_adk_descrip'],
				'label' => '<img style="vertical-align: middle;" alt="" src="'.$settings['default_theme_url'].'/images/admin/news.png" />&nbsp;'.$txt['adk_news_news'],
			),
			'adksettings' => array(
				'description' => $txt['second_adk_descript'],
				'label' => '<img style="vertical-align: middle;" alt="" src="'.$settings['default_theme_url'].'/images/admin/settings.png" />&nbsp;'.$txt['opcion_adk'],
			),
			'manageicons' => array(
				'description' => '',
				'label' => '<img style="vertical-align: middle;" alt="" src="'.$settings['default_theme_url'].'/images/admin/icons.png" />&nbsp;'.$txt['adk_manage_icons'],
			),	
		),
	);	
	
	
	// Follow the sa or just go to View function
	if (!empty($_GET['sa']) && !empty($subActions[$_GET['sa']]))
		$subActions[@$_GET['sa']]();
	else
		$subActions['view']();
}

function view()
{
	global $context, $txt;

	//Load main trader template.
	$context['sub_template']  = 'view';

	//Set the page title
	$context['page_title'] = $txt['adk_news_news'];
	
	$context['adkportal']['current_version'] = getCurrentversion();
	$context['adkportal']['your_version'] = getYourversion();
	
	if($context['adkportal']['your_version'] == $context['adkportal']['current_version'])
		$context['adkportal']['style_version'] = '<b style="color: green;">'.$context['adkportal']['your_version'].'</b>';
	else
		$context['adkportal']['style_version'] = '<b style="color: red;">'.$context['adkportal']['current_version'].'</b><br /><br /><div align="center"><a href="http://www.smfpersonal.net/downloads.html;cat=5" target="_blank"><strong>'.$txt['adk_download_now'].'</strong></a></div>';
}

function adksettings()
{

	global $context, $txt;
	checkSession('get');
	
	//Load main trader template.
	$context['sub_template']  = 'adksettings';

	//Set the page title
	$context['page_title'] = $txt['opcion_adk'];
	
}

function adksavesettings()
{
	global $context, $smcFunc;
	checkSession('post');
	
	$adk_enable = !empty($_POST['adk_enable']) ? (int)$_POST['adk_enable'] : 0;
	$cleft = !empty($_POST['cleft']) ? 1 : 0;
	$cright = !emptY($_POST['cright']) ? 1 : 0;
	$change_title = CleanAdkStrings($_POST['change_title']);
	$enable_right_forum = isset($_POST['enable_right_forum']) ? 1 : 0;
	$enable_left_forum = isset($_POST['enable_left_forum']) ? 1 : 0;
	$enable_bottom_forum = isset($_POST['enable_bottom_forum']) ? 1 : 0;
	$enable_top_forum = isset($_POST['enable_top_forum']) ? 1 : 0;
	$wleft = CleanAdkStrings($_POST['wleft']);
	//$wcenter = $smcFunc['CleanAdkStrings']($_POST['wcenter']);
	$wright = CleanAdkStrings($_POST['wright']);
	$enable_related_topics = !empty($_POST['enable_related_topics']) ? 1 : 0;
	$enable_watermark = !empty($_POST['enable_watermark']) ? 1 : 0;
	$title_in_blocks = (int)$_POST['title_in_blocks'];
	$enable_img_blocks = (int)$_POST['enable_img_blocks'];
	
	//Adk Stand Aloneeeeee!
	$adk_stand_alone_url = !empty($_POST['adk_stand_alone_url']) ? CleanAdkStrings($_POST['adk_stand_alone_url']) : '';
	
	//Hide version
	$adk_hide_version = !empty($_POST['adk_hide_version']) ? 1 : 0;
	
	//Are you using the block style from urls? -.-
	if(!empty($_SESSION['adk_style']))
		$_SESSION['adk_style'] = $title_in_blocks;
	
	updateSettingsAdkPortal(
		array(
			'adk_enable' => $adk_enable,
			'cleft' => $cleft,
			'cright' => $cright,
			'wleft' => $wleft,
			//'wcenter' => $wcenter,
			'wright' => $wright,
			'change_title' => $change_title,
			'enable_right_forum' => $enable_right_forum,
			'enable_left_forum' => $enable_left_forum,
			'enable_related_topics' => $enable_related_topics,
			'enable_watermark' => $enable_watermark,
			'enable_top_forum' => $enable_top_forum,
			'enable_bottom_forum' => $enable_bottom_forum,
			'title_in_blocks' => $title_in_blocks,
			'enable_img_blocks' => $enable_img_blocks,
			'adk_stand_alone_url' => $adk_stand_alone_url,
			'adk_hide_version' => $adk_hide_version,
		)
	);
	
	
	redirectexit('action=admin;area=adkadmin;sa=adksettings;'.$context['session_var'].'=' . $context['session_id']);
	
}

function manageicons()
{
	$set = array(
		'view_icons' => 'view_icons',
		'addicon' => 'addicon',
		'saveicon' => 'saveicon',
		'deleteicon' => 'deleteicon',
	);
	
	if (!empty($_GET['set']) && !empty($set[$_GET['set']]))
		$set[@$_GET['set']]();
	else
		$set['view_icons']();
}

function view_icons()
{
	global $context, $txt, $smcFunc;
	
	checkSession('get');
	
	$context['sub_template']  = 'view_icons';

	$context['page_title'] = $txt['adk_manage_icons_2'];
	
	$sql = $smcFunc['db_query']('','
		SELECT id_icon, icon 
		FROM {db_prefix}adk_icons 
		ORDER BY id_icon ASC'
	);
	
	$context['load_icons'] = array();
	
	while($row = $smcFunc['db_fetch_assoc']($sql))
	{
		$context['load_icons'][] = array(
			'id' => $row['id_icon'],
			'icon' => $row['icon']
		);
	}
	
	$smcFunc['db_free_result']($sql);
}

function deleteicon()
{
	global $smcFunc, $context, $boarddir;
	
	checkSession('get');
	
	if(!empty($_REQUEST['id']) && is_numeric($_REQUEST['id']))
		$id = (int)$_REQUEST['id'];
	else
		fatal_lang_error('adk_wrong_wrong_id',false);
	
	$sql = $smcFunc['db_query']('','
		SELECT icon 
		FROM {db_prefix}adk_icons
		WHERE id_icon = {int:icon}',
		array(
			'icon' => $id,
		)
	);
	
	$row = $smcFunc['db_fetch_assoc']($sql);
	$smcFunc['db_free_result']($sql);
	
	if(file_exists($boarddir.'/adkportal/images/blocks/'.$row['icon']))
		@unlink($boarddir.'/adkportal/images/blocks/'.$row['icon']);
	
	//Now DELETE DB
	$smcFunc['db_query']('','
		DELETE FROM {db_prefix}adk_icons
		WHERE id_icon = {int:icon}',
		array(
			'icon' => $id,
		)
	);
	
	redirectexit('action=admin;area=adkadmin;sa=manageicons;'.$context['session_var'].'='.$context['session_id']);
}

function addicon()
{
	global $context, $txt;
	
	checkSession('get');
	
	$context['sub_template']  = 'addicon';

	$context['page_title'] = $txt['adk_add_icon'];
}

function saveicon()
{
	global $context, $boarddir, $txt, $smcFunc;
	
	checkSession('post');
	
	if(empty($_FILES['file']['name']))
		fatal_lang_error('not_select_image_icon',false);
	
	$maxfilesize = 1*1024*512;
	
	if($_FILES['file']['size'] > $maxfilesize)
		fatal_lang_error('not_select_image_icon',false);
	
	$filename = str_replace(' ','',$_FILES['file']['name']);
	
	$filename = time().$filename;
	
	if($_FILES['file']['type'] == "image/gif" || $_FILES['file']['type'] == "image/png")
	{
		@chmod($boardir.'/adkportal/images/blocks',777);
		move_uploaded_file($_FILES['file']['tmp_name'], $boarddir.'/adkportal/images/blocks/' .   $filename);
		
		@chmod($boardir.'/adkportal/images/blocks/'.$filename,644);
		@chmod($boardir.'/adkportal/images/blocks',644);
		
		$smcFunc['db_query']('',"INSERT INTO {db_prefix}adk_icons VALUES (NULL,'$filename')");
	}
	else
		fatal_lang_error('not_select_image_icon',false);
	
	redirectexit('action=admin;area=adkadmin;sa=manageicons;'.$context['session_var'].'='.$context['session_id']);
	
}

function AdkBlocksGeneral()
{
	global $txt, $context, $sourcedir, $boardurl, $settings;
	
	//Permisos
	isAllowedTo('adk_portal');
	
	loadTemplate('Adk-admin');
	
	if(loadLanguage('Adk-Admin') == false)
		loadLanguage('Adk-Admin','english');
		
	//Load main trader template.

	//Set the page title
	
	$subActions = array(
		'viewblocks' => 'viewblocks',
		'savesettingsblocks' => 'savesettingsblocks',
		'settingsblocks' => 'SettingsBlocks',
		'savesettingsblocks2' => 'SaveSettingsBlocks2',
		'deleteblocks' => 'deleteblocks',
		'editblocks' => 'editblocks',
		'saveeditblocks' => 'saveeditblocks',
		'newblocks' => 'LoadTheNewBlocksToCreate',
		'savenewblocks' => 'savenewblocks',
		'showeditnews' => 'showeditnews',
		'showdeletenews' => 'showdeletenews',
		'showsaveeditnews' => 'showsaveeditnews',
		'createnews' => 'createnews',
		'savecreatenews' => 'savecreatenews',
		'uploadblock' => 'uploadblock',
		'saveuploadblock' => 'saveuploadblock',
		'shoutbox' => 'ShoutBoxSettings',
		'shoutboxsave' => 'ShoutboxSave',
		'shoutboxdeleteall' => 'DeleteShoutboxMessages',
		'previewblock' => 'PreviewBlockAdKPortal',
		'permissions' => 'PermissionBlock',
		'savepermissions' => 'SavePermissionBlock',
	);
	
	//Load CSS
	$context['html_headers'] = '<link rel="stylesheet" type="text/css" href="'.$boardurl.'/adkportal/css/admin_adkportal.css" />';
		
	$context[$context['admin_menu_name']]['tab_data'] = array(
		'title' => $txt['adk_title_admin_settings'],
		'description' => $txt['first_adk_descrip'],
		'tabs' => array(
			'viewblocks' => array(
				'description' => $txt['first_adk_descrip_block'],					
				'label' => '<img style="vertical-align: middle;" alt="" src="'.$settings['default_theme_url'].'/images/admin/blocks.png" />&nbsp;'.$txt['bloques'],
			),
			'settingsblocks' => array(
				'description' => $txt['adk_another_description'],					
				'label' => '<img style="vertical-align: middle;" alt="" src="'.$boardurl.'/adkportal/images/admin.png" />&nbsp;'.$txt['adk_settings_blocks'],
			),
			'newblocks' => array(
				'description' => $txt['second_adk_descript_blocks'],
				'label' => '<img style="vertical-align: middle;" alt="" src="'.$settings['default_theme_url'].'/images/admin/createblock.png" />&nbsp;'.$txt['crear_block'],
			),
			'createnews' => array(
				'description' => $txt['second_adk_descript_news'],
				'label' => '<img style="vertical-align: middle;" alt="" src="'.$settings['default_theme_url'].'/images/admin/createnews.png" />&nbsp;'.$txt['nueva_noticia'],
			),
			'uploadblock' => array(
				'description' => '',
				'label' => '<img style="vertical-align: middle;" alt="" src="'.$settings['default_theme_url'].'/images/admin/upload.png" />&nbsp;'.$txt['adk_upload_yourBlock'],
			),
			'shoutbox' => array(
				'description' => '',
				'label' => '<img style="vertical-align: middle;" alt="" src="'.$settings['default_theme_url'].'/images/admin/shoutbox.png" />&nbsp;'.$txt['adk_shout'],
			),
				
		),
	);	
	
	
	// Follow the sa or just go to View function
	if (!empty($_GET['sa']) && !empty($subActions[$_GET['sa']]))
		$subActions[@$_GET['sa']]();
	else
		$subActions['viewblocks']();

}

function LoadTheNewBlocksToCreate()
{
	global $context, $txt;

	$context['add_custom_blocks'] = array(
		'bbc' => array(
			'title' => $txt['adk_bbc_select'].' / Html',
			'image' => 'page.png',
		),
		'php' => array(
			'title' => $txt['adk_php_select'],
			'image' => 'php.png',
		),
		'top_poster' => array(
			'title' => $txt['adk_top_poster_select'],
			'image' => 'users.png',
		),
		'auto_news' => array(
			'title' => $txt['adk_auto_news_select'],
			'image' => 'new.png',
		),
		'top_karma' => array(
			'title' => $txt['adk_top_karma_select'],
			'image' => 'group_add.png',
		),
		'staff' => array(
			'title' => $txt['adk_staff'],
			'image' => 'register.png',
		),
		'multi_block' => array(
			'title' => $txt['adk_multi_block'],
			'image' => 'brick_add.png',
		),
	);
	
	$set = array();
	
	foreach($context['add_custom_blocks'] AS $act => $button_finally)
	{
		//Action
		$set[$act] = 'AdkAddBlock_'.$act;
		//The Saves
		$set[$act.'_save'] = 'AdkAddBlock_'.$act.'_save';
	}
	
	
	
	if (!empty($_GET['set']) && !empty($set[$_GET['set']]))
		$set[@$_GET['set']]();
	else
	{
		checkSession('get');
		
		$context['sub_template'] = 'the_new_custom_blocks';
		$context['page_title'] = $txt['adk_create_custom_block'];
	}
		
	
}

function AdkAddBlock_multi_block()
{
	global $smcFunc, $context, $txt;
	
	$context['page_title'] = $txt['adk_multi_block'];
	$context['sub_template'] = 'multi_block';

	//Loading blocks
	$sql = $smcFunc['db_query']('','
		SELECT id, name
		FROM {db_prefix}adk_blocks
		WHERE type <> {string:type} AND id NOT IN ({array_int:not_id})
		ORDER by id ASC',
		array(
			'type' => 'multi_block',
			'not_id' => array(11,12),
		)
	);
	
	$blocks = array();
	
	while($row = $smcFunc['db_fetch_assoc']($sql))
		$blocks[$row['id']] = $row['name'];
	
	$smcFunc['db_free_result']($sql);
	
	$context['adk_blocks'] = $blocks;
	
}

function AdkAddBlock_multi_block_save()
{
	checkSession('post');
	
	global $context, $smcFunc, $txt;
	
	if(!empty($_POST['block']))
	{	
		$block = array_keys($_POST['block']);
		$block = implode(',',$block);
	}
	else
		$block = '';
	
	if(empty($block))
		fatal_lang_error('please_insert_multi_id',false);
	
	$name = CleanAdkStrings($_POST['name']);
	$activate = !empty($_POST['enable']) ? 1 : 0;
	$orden = (int)$_POST['orden'];
	$columna = (int)$_POST['columna'];
	$img = '';
	$type = 'multi_block';
	$empty_body = 0;
	$empty_title = 0;
	$empty_collapse = 0;
	
	$the_array_info = array(
		'name' => 'text',
		'echo' => 'text',
		'activate' => 'int',
		'columna' => 'int',
		'orden' => 'int',
		'img' => 'text',
		'type' => 'text',
		'empty_body' => 'int',
		'empty_title' => 'int',
		'empty_collapse' => 'int',
	);
	
	$the_array_insert = array(
		$name,
		$block,
		$activate,
		$columna,
		$orden,
		$img,
		$type,
		$empty_body,
		$empty_title,
		$empty_collapse,
	);
	
	$smcFunc['db_insert']('insert',
		'{db_prefix}adk_blocks',
		//Load The Array Info
		$the_array_info,
		//Insert Now;)
		$the_array_insert,
		array('id')
	);
	
	redirectexit('action=admin;area=blocks;sa=viewblocks;'.$context['session_var'].'='.$context['session_id']);
	
}

function AdkAddBlock_staff()
{
	global $context, $txt, $smcFunc;
	
	$context['page_title'] = $txt['adk_staff'];
	$context['sub_template'] = 'newblocks_staff';
	
	$sql = $smcFunc['db_query']('','
		SELECT group_name, id_group
		FROM {db_prefix}membergroups
		WHERE min_posts = -1
	');
	
	$context['g'] = array();
	
	while($row = $smcFunc['db_fetch_assoc']($sql))
		$context['g'][$row['id_group']] = $row['group_name'];
	
	$smcFunc['db_free_result']($sql);
	
}

function AdkAddBlock_staff_save()
{
	global $context, $sourcedir, $txt, $smcFunc;
	
	checkSession('post');
	
	$type = 'php';
	$name = CleanAdkStrings($_POST['titulo']);
	$activate = !empty($_POST['enable']) ? 1 : 0;
	$orden = (int)$_POST['orden'];
	$columna = (int)$_POST['columna'];
	$empty_body = !empty($_POST['empty_body']) ? 1 : 0;
	$empty_title = !empty($_POST['empty_title']) ? 1 : 0;
	$empty_collapse = !empty($_POST['empty_collapse']) ? 1 : 0;
	$img = !empty($_POST['img']) ? CleanAdkStrings($_POST['img']) : '';
	
	if(!empty($_POST['groups_allowed']))
	{	
		$groups_allowed = array_keys($_POST['groups_allowed']);
		$groups_allowed = implode(',',$groups_allowed);
	}
	else
		$groups_allowed = '';
		
	
	$show_avatar = !empty($_POST['avatar']) ? 1 : 0;
	
	if(empty($name))
		fatal_lang_error('adk_categorie_not_title',false);
	
	
	$echo = "<?php adkportal_staff('$groups_allowed',$show_avatar); ?>";
	
	$the_array_info = array(
		'name' => 'text',
		'echo' => 'text',
		'activate' => 'int',
		'columna' => 'int',
		'orden' => 'int',
		'img' => 'text',
		'type' => 'text',
		'empty_body' => 'int',
		'empty_title' => 'int',
		'empty_collapse' => 'int',
	);
	
	$the_array_insert = array(
		$name,
		$echo,
		$activate,
		$columna,
		$orden,
		$img,
		$type,
		$empty_body,
		$empty_title,
		$empty_collapse,
	);
	
	$smcFunc['db_insert']('insert',
		'{db_prefix}adk_blocks',
		//Load The Array Info
		$the_array_info,
		//Insert Now;)
		$the_array_insert,
		array('id')
	);
	
	redirectexit('action=admin;area=blocks;sa=viewblocks;'.$context['session_var'].'='.$context['session_id']);
	
}

function AdkAddBlock_top_karma()
{
	global $context, $txt;
	
	$context['page_title'] = $txt['adk_creating_top_karma_block'];
	$context['sub_template'] = 'newblocks_top_karma';
	
}

function AdkAddBlock_top_karma_save()
{
	global $context, $sourcedir, $txt, $smcFunc;
	
	checkSession('post');
	
	$echo = (int)$_POST['descript'];
	$type = 'php';
	$name = CleanAdkStrings($_POST['titulo']);
	$activate = !empty($_POST['enable']) ? 1 : 0;
	$orden = (int)$_POST['orden'];
	$columna = (int)$_POST['columna'];
	$empty_body = !empty($_POST['empty_body']) ? 1 : 0;
	$empty_title = !empty($_POST['empty_title']) ? 1 : 0;
	$empty_collapse = !empty($_POST['empty_collapse']) ? 1 : 0;
	$img = !empty($_POST['img']) ? CleanAdkStrings($_POST['img']) : '';
	
	if(empty($name))
		fatal_lang_error('adk_categorie_not_title',false);
	
	if(empty($echo))
		fatal_lang_error('adk_please_add_a_body',false);
	
	$echo = "<?php adk_topkarma10('$echo'); ?>";
	
	$the_array_info = array(
		'name' => 'text',
		'echo' => 'text',
		'activate' => 'int',
		'columna' => 'int',
		'orden' => 'int',
		'img' => 'text',
		'type' => 'text',
		'empty_body' => 'int',
		'empty_title' => 'int',
		'empty_collapse' => 'int',
	);
	
	$the_array_insert = array(
		$name,
		$echo,
		$activate,
		$columna,
		$orden,
		$img,
		$type,
		$empty_body,
		$empty_title,
		$empty_collapse,
	);
	
	$smcFunc['db_insert']('insert',
		'{db_prefix}adk_blocks',
		//Load The Array Info
		$the_array_info,
		//Insert Now;)
		$the_array_insert,
		array('id')
	);
	
	redirectexit('action=admin;area=blocks;sa=viewblocks;'.$context['session_var'].'='.$context['session_id']);
	
}

function AdkAddBlock_auto_news()
{
	global $context, $txt;

	$context['page_title'] = $txt['adk_creating_auto_news_block'];
	$context['sub_template'] = 'newblocks_auto_news';
	
	//Load Boards
	loadJumpTosmf1ByAlper();
	
}
function AdkAddBlock_auto_news_save()
{
	global $context, $sourcedir, $txt, $smcFunc;
	
	checkSession('post');
	
	if (isset($_POST['auto_news_id_boards'])){
		foreach ($_POST['auto_news_id_boards'] as $i => $v)
		{
			 if (!is_numeric($_POST['auto_news_id_boards'][$i])) 
				unset($_POST['auto_news_id_boards'][$i]);
			else
				$_POST['auto_news_id_boards'][$i] = (int)$_POST['auto_news_id_boards'][$i];
		}
	$echo = implode(',', $_POST['auto_news_id_boards']);
	}
	else
		$echo = 0;
	
	$int = (int)$_POST['int'];
		
	$type = 'php';
	$name = CleanAdkStrings($_POST['titulo']);
	$activate = !empty($_POST['enable']) ? 1 : 0;
	$orden = (int)$_POST['orden'];
	$columna = (int)$_POST['columna'];
	$empty_body = !empty($_POST['empty_body']) ? 1 : 0;
	$empty_title = !empty($_POST['empty_title']) ? 1 : 0;
	$empty_collapse = !empty($_POST['empty_collapse']) ? 1 : 0;
	$img = !empty($_POST['img']) ? CleanAdkStrings($_POST['img']) : '';
	
	if(empty($name))
		fatal_lang_error('adk_categorie_not_title',false);
	
	if(empty($echo))
		fatal_lang_error('adk_please_add_a_body',false);
	
	$echo = "<?php adk_aportes_automaticos('$echo', '', $int); ?>";
	
	$the_array_info = array(
		'name' => 'text',
		'echo' => 'text',
		'activate' => 'int',
		'columna' => 'int',
		'orden' => 'int',
		'img' => 'text',
		'type' => 'text',
		'empty_body' => 'int',
		'empty_title' => 'int',
		'empty_collapse' => 'int',
	);
	
	$the_array_insert = array(
		$name,
		$echo,
		$activate,
		$columna,
		$orden,
		$img,
		$type,
		$empty_body,
		$empty_title,
		$empty_collapse,
	);
	
	$smcFunc['db_insert']('insert',
		'{db_prefix}adk_blocks',
		//Load The Array Info
		$the_array_info,
		//Insert Now;)
		$the_array_insert,
		array('id')
	);
	
	redirectexit('action=admin;area=blocks;sa=viewblocks;'.$context['session_var'].'='.$context['session_id']);
	
}

function AdkAddBlock_top_poster()
{
	global $context, $txt;

	$context['page_title'] = $txt['adk_creating_top_poster_block'];
	$context['sub_template'] = 'newblocks_top_poster';
	
}

function AdkAddBlock_top_poster_save()
{
	global $context, $sourcedir, $txt, $smcFunc;
	
	checkSession('post');
	
	$echo = (int)$_POST['descript'];
	$type = 'php';
	$name = CleanAdkStrings($_POST['titulo']);
	$activate = !empty($_POST['enable']) ? 1 : 0;
	$orden = (int)$_POST['orden'];
	$columna = (int)$_POST['columna'];
	$empty_body = !empty($_POST['empty_body']) ? 1 : 0;
	$empty_title = !empty($_POST['empty_title']) ? 1 : 0;
	$empty_collapse = !empty($_POST['empty_collapse']) ? 1 : 0;
	$img = !empty($_POST['img']) ? CleanAdkStrings($_POST['img']) : '';
	
	if(empty($name))
		fatal_lang_error('adk_categorie_not_title',false);
	
	if(empty($echo))
		fatal_lang_error('adk_please_add_a_body',false);
	
	$echo = "<?php adk_topposter10('$echo'); ?>";
	
	$the_array_info = array(
		'name' => 'text',
		'echo' => 'text',
		'activate' => 'int',
		'columna' => 'int',
		'orden' => 'int',
		'img' => 'text',
		'type' => 'text',
		'empty_body' => 'int',
		'empty_title' => 'int',
		'empty_collapse' => 'int',
	);
	
	$the_array_insert = array(
		$name,
		$echo,
		$activate,
		$columna,
		$orden,
		$img,
		$type,
		$empty_body,
		$empty_title,
		$empty_collapse,
	);
	
	$smcFunc['db_insert']('insert',
		'{db_prefix}adk_blocks',
		//Load The Array Info
		$the_array_info,
		//Insert Now;)
		$the_array_insert,
		array('id')
	);
	
	redirectexit('action=admin;area=blocks;sa=viewblocks;'.$context['session_var'].'='.$context['session_id']);
	
}

function AdkAddBlock_php()
{
	global $context, $txt;

	$context['page_title'] = $txt['adk_creating_php_block'];
	$context['sub_template'] = 'newblocks_php';
}

function AdkAddBlock_php_save()
{
	global $context, $sourcedir, $txt, $smcFunc;
	
	checkSession('post');
	
	$echo = CleanAdkStrings($_POST['descript']);
	$type = 'php';
	$name = CleanAdkStrings($_POST['titulo']);
	$activate = !empty($_POST['enable']) ? 1 : 0;
	$orden = (int)$_POST['orden'];
	$columna = (int)$_POST['columna'];
	$empty_body = !empty($_POST['empty_body']) ? 1 : 0;
	$empty_title = !empty($_POST['empty_title']) ? 1 : 0;
	$empty_collapse = !empty($_POST['empty_collapse']) ? 1 : 0;
	$img = !empty($_POST['img']) ? CleanAdkStrings($_POST['img']) : '';
	
	if(empty($name))
		fatal_lang_error('adk_categorie_not_title',false);
	
	if(empty($echo))
		fatal_lang_error('adk_please_add_a_body',false);
	
	
	$the_array_info = array(
		'name' => 'text',
		'echo' => 'text',
		'activate' => 'int',
		'columna' => 'int',
		'orden' => 'int',
		'img' => 'text',
		'type' => 'text',
		'empty_body' => 'int',
		'empty_title' => 'int',
		'empty_collapse' => 'int',
	);
	
	$the_array_insert = array(
		$name,
		$echo,
		$activate,
		$columna,
		$orden,
		$img,
		$type,
		$empty_body,
		$empty_title,
		$empty_collapse,
	);
	
	$smcFunc['db_insert']('insert',
		'{db_prefix}adk_blocks',
		//Load The Array Info
		$the_array_info,
		//Insert Now;)
		$the_array_insert,
		array('id')
	);
	
	redirectexit('action=admin;area=blocks;sa=viewblocks;'.$context['session_var'].'='.$context['session_id']);
	
}

function AdkAddBlock_bbc()
{
	global $context, $sourcedir, $txt;

	$context['page_title'] = $txt['adk_creating_bbc_block'];
	$context['sub_template'] = 'newblocks';
	
	// Needed for the WYSIWYG editor.
	require_once($sourcedir . '/Subs-Editor.php');

	// Now create the editor.
	$editorOptions = array(
		'id' => 'descript',
		'value' => '',
		'width' => '97%',
		'form' => 'picform',
		'labels' => array(
			'post_button' => '',
		),
	);
	create_control_richedit($editorOptions);
	$context['post_box_name'] = $editorOptions['id'];
}

function AdkAddBlock_bbc_save()
{
	global $context, $sourcedir, $txt, $smcFunc;
	
	checkSession('post');
	
	if (!empty($_REQUEST['descript_mode']) && isset($_REQUEST['descript']))
	{
		require_once($sourcedir . '/Subs-Editor.php');

		$_REQUEST['descript'] = html_to_bbc($_REQUEST['descript']);

		// We need to unhtml it now as it gets done shortly.
		$_REQUEST['descript'] = un_CleanAdkStrings($_REQUEST['descript']);

	}
	
	$echo = CleanAdkStrings($_REQUEST['descript']);
	$type = !empty($_POST['html']) ? 'html' : 'bbc';
	$name = CleanAdkStrings($_POST['titulo']);
	$activate = !empty($_POST['enable']) ? 1 : 0;
	$orden = (int)$_POST['orden'];
	$columna = (int)$_POST['columna'];
	$empty_body = !empty($_POST['empty_body']) ? 1 : 0;
	$empty_title = !empty($_POST['empty_title']) ? 1 : 0;
	$empty_collapse = !empty($_POST['empty_collapse']) ? 1 : 0;
	$img = !empty($_POST['img']) ? CleanAdkStrings($_POST['img']) : '';
	
	if(empty($name))
		fatal_lang_error('adk_categorie_not_title',false);
	
	if(empty($echo))
		fatal_lang_error('adk_please_add_a_body',false);
	
	
	$the_array_info = array(
		'name' => 'text',
		'echo' => 'text',
		'activate' => 'int',
		'columna' => 'int',
		'orden' => 'int',
		'img' => 'text',
		'type' => 'text',
		'empty_body' => 'int',
		'empty_title' => 'int',
		'empty_collapse' => 'int',
	);
	
	$the_array_insert = array(
		$name,
		$echo,
		$activate,
		$columna,
		$orden,
		$img,
		$type,
		$empty_body,
		$empty_title,
		$empty_collapse,
	);
	
	$smcFunc['db_insert']('insert',
		'{db_prefix}adk_blocks',
		//Load The Array Info
		$the_array_info,
		//Insert Now;)
		$the_array_insert,
		array('id')
	);
	
	redirectexit('action=admin;area=blocks;sa=viewblocks;'.$context['session_var'].'='.$context['session_id']);
		
	
}
	

function viewblocks()
{
	global $context, $db_prefix, $txt, $smcFunc;

	checkSession('get');
	$context['sub_template']  = 'viewblocks';

	//Set the page title
	$context['page_title'] = $txt['bloques'];
	
	//traemos left column
	$left = $smcFunc['db_query']('', "SELECT * FROM {db_prefix}adk_blocks ORDER BY orden ASC");
	$context['left'] = array();
	$context['center'] = array();
	$context['right'] = array();
	while ($fila = $smcFunc['db_fetch_assoc']($left))
	{
		if($fila['columna'] == 1)
		{
			$context['left'][] = array (
				'name' => $fila['name'],
				'echo' => $fila['echo'],
				'activate' => $fila['activate'],
				'orden' => $fila['orden'],
				'id' => $fila['id'],
				'columna' => $fila['columna'],
				'img' => $fila['img'],
				'type' => $fila['type']
			);
		}
		elseif($fila['columna'] == 2)
		{
			$context['center'][] = array (
				'name' => $fila['name'],
				'activate' => $fila['activate'],
				'echo' => $fila['echo'],
				'orden' => $fila['orden'],
				'id' => $fila['id'],
				'columna' => $fila['columna'],
				'img' => $fila['img'],
				'type' => $fila['type']
			);
		}
		elseif($fila['columna'] == 3)
		{
			$context['right'][] = array(
				'name' => $fila['name'],
				'activate' => $fila['activate'],
				'echo' => $fila['echo'],
				'orden' => $fila['orden'],
				'id' => $fila['id'],
				'columna' => $fila['columna'],
				'img' => $fila['img'],
				'type' => $fila['type']  
			);
		}
		elseif($fila['columna'] == 4)
		{
			$context['top'][] = array(
				'name' => $fila['name'],
				'activate' => $fila['activate'],
				'echo' => $fila['echo'],
				'orden' => $fila['orden'],
				'id' => $fila['id'],
				'columna' => $fila['columna'],
				'img' => $fila['img'],
				'type' => $fila['type']  
			);
		}
		elseif($fila['columna'] == 5)
		{
			$context['bottom'][] = array(
				'name' => $fila['name'],
				'activate' => $fila['activate'],
				'echo' => $fila['echo'],
				'orden' => $fila['orden'],
				'id' => $fila['id'],
				'columna' => $fila['columna'],
				'img' => $fila['img'],
				'type' => $fila['type']  
			);
		}
	}

	$smcFunc['db_free_result']($left);
	
}

function SettingsBlocks()
{
	global $context, $txt;
	
	checkSession('get');
	
	$context['sub_template'] = 'settings_blocks';
	$context['page_title'] = $txt['adk_settings_blocks'];
	
	//Load Jump To
	loadJumpTosmf1ByAlper();
}

function SaveSettingsBlocks2()
{
	checkSession('post');
	
	if (isset($_POST['auto_news_id_boards'])){
		foreach ($_POST['auto_news_id_boards'] as $i => $v)
		{
			 if (!is_numeric($_POST['auto_news_id_boards'][$i])) 
				unset($_POST['auto_news_id_boards'][$i]);
			else
				$_POST['auto_news_id_boards'][$i] = (int)$_POST['auto_news_id_boards'][$i];
		}
	$auto_news_id_boards = implode(',', $_POST['auto_news_id_boards']);
	}
	else
		$auto_news_id_boards = 0;
	
	$adk_news = (int)$_POST['adk_news'];
	$auto_news_limit_body = (int)$_POST['auto_news_limit_body'];
	$auto_news_limit_topics = (int)$_POST['auto_news_limit_topics'];
	$top_poster = (int)$_POST['top_poster'];
	$ultimos_mensajes = (int)$_POST['ultimos_mensajes'];
	$no_avatar_who = !empty($_POST['no_avatar_who']) ? 1 : 0;
	$adk_bookmarks_autonews = !empty($_POST['adk_bookmarks_autonews']) ? 1 : 0;
	$adk_bookmarks_news = !empty($_POST['adk_bookmarks_news']) ? 1 : 0;
	
	updateSettingsAdkPortal( 
		array(
			'adk_news' => $adk_news,
			'auto_news_limit_body' => $auto_news_limit_body,
			'auto_news_limit_topics' => $auto_news_limit_topics,
			'top_poster' => $top_poster,
			'ultimos_mensajes' => $ultimos_mensajes,
			'no_avatar_who' => $no_avatar_who,
			'auto_news_id_boards' => $auto_news_id_boards,
			'adk_bookmarks_news' => $adk_bookmarks_news,
			'adk_bookmarks_autonews' => $adk_bookmarks_autonews,
		)
	);
	
	
	global $context;
	
	redirectexit('action=admin;area=blocks;sa=settingsblocks;'.$context['session_var'].'='.$context['session_id']);
			
}
	
	

function PreviewBlockAdKPortal()
{
	global $smcFunc, $context, $settings, $sourcedir, $boarddir, $boardurl, $user_info, $txt;
	
	checkSession('get');
	
	if(!empty($_REQUEST['id']))
		$id = (int)$_REQUEST['id'];
	else
		fatal_lang_error('error_adk_not_id',false);
	
	$context['html_headers'] .= '
	<link rel="stylesheet" type="text/css" href="'. $boardurl .'/adkportal/css/blocks.css" />
	<script type="text/javascript"><!-- // --><![CDATA[
		var smf_adk_url = "'.$boardurl.'/adkportal/";
		var smf_shoutbox_url = "'.$boardurl.'/adkportal/shoutbox/";
	// ]]></script>
	<script language="JavaScript" type="text/javascript"><!-- // --><![CDATA[
		function adkcollapse(id,span)
		{
			var hide = new Array();
			hide[1] = "adk_left";
			hide[2] = "adk_right";
			mode = document.getElementById(hide[id]).style.display == "" ? 0 : 1;' . ($user_info['is_guest'] ? '
			document.cookie = hide[id] + "=" + (mode ? 0 : 1);' : '
			smf_setThemeOption(hide[id], mode ? 0 : 1, null, "' . $context['session_id'] . '");') . '
			document.getElementById(span).innerHTML = (mode ? "<img alt=\"'.$txt['colapse_left2'].'\" title=\"'.$txt['colapse_left2'].'\" src=\"'.$settings['images_url'].'/collapse.gif\" />" : "<img alt=\"'.$txt['colapse_left1'].'\" title=\"'.$txt['colapse_left1'].'\" src=\"'.$settings['images_url'].'/expand.gif\" />"); 						
			document.getElementById(hide[id]).style.display = mode ? "" : "none";
		}
		function adkBlock(id,img_id)
		{
			var hide = new Array();
			hide[id] = "adk_block_"+ id;
			mode = document.getElementById(hide[id]).style.display == "" ? 0 : 1;' . ($user_info['is_guest'] ? '
			document.cookie = hide[id] + "=" + (mode ? 0 : 1);' : '
			smf_setThemeOption(hide[id], mode ? 0 : 1, null, "' . $context['session_id'] . '");') . '
			document.getElementById(img_id).src = (mode ? "'.$settings['images_url'].'/collapse.gif" : "'.$settings['images_url'].'/expand.gif");
			document.getElementById(hide[id]).style.display = mode ? "" : "none";
		}		
	// ]]></script>';
	
	$sql = $smcFunc['db_query']('','
		SELECT id,echo, name AS title, img, type, columna, empty_body, empty_title, empty_collapse
		FROM {db_prefix}adk_blocks
		WHERE id = {int:id}',
		array(
			'id' => $id,
		)
	);
	
	$row = $smcFunc['db_fetch_assoc']($sql);
	
	if(empty($row['id']))
		fatal_lang_error('error_adk_not_id',false);
	
	$smcFunc['db_free_result']($sql);
	
	//Load Important Files
	require_once($boarddir.'/SSI.php');
	require_once($sourcedir.'/Subs-adkblocks.php');
	
	$context['adkportal']['blocks'] = array(
		'id' => $row['id'],
		'columna' => $row['columna'],
		'echo' => un_CleanAdkStrings($row['echo']),
		'title' => $row['title'],
		'img' => $row['img'],
		'type' => $row['type'],
		'b' => $row['empty_body'],
		't' => $row['empty_title'],
		'c' => $row['empty_collapse']
	);
	
	$context['page_title'] = $row['title'];
	$context['sub_template'] = 'preview_adkblock';
	
	
}


function savesettingsblocks()
{
	global $db_prefix,  $context, $smcFunc;

	checkSession('post');
	if(!empty($_POST['idleft']))
	{
		$activateleft =  $_POST['activateleft'];  
		$ordenleft =  $_POST['ordenleft'];  
		$idleft =  $_POST['idleft'];  
		$columnaleft =  $_POST['columnaleft'];	
			

		$i = 0;
		$n = count($idleft);

		while ($i < $n)
		{
			$activateleft[$i] = (int)$activateleft[$i];
			$ordenleft[$i] = (int)$ordenleft[$i];
			$columnaleft[$i] = (int)$columnaleft[$i];
			$idleft[$i] = (int)$idleft[$i];
			
			$smcFunc['db_query']('','
				UPDATE {db_prefix}adk_blocks
				SET activate = {int:activate},
				orden = {int:orden},
				columna = {int:columna}
				WHERE id = {int:idb}',
				array(
					'activate' => $activateleft[$i],
					'orden' => $ordenleft[$i],
					'columna' => $columnaleft[$i],
					'idb' => $idleft[$i],
				)
			);
			
			$i++;
		}
	}


	if(!empty($_POST['idcenter']))	   
	{
	
		$activatecenter =  $_POST['activatecenter'];  
		$ordencenter =  $_POST['ordencenter'];  
		$idcenter =  $_POST['idcenter'];  
		$columnacenter =  $_POST['columnacenter'];	
			

		$i = 0;
		$n = count($idcenter);

		while ($i < $n)
		{
			$activatecenter[$i] = (int)$activatecenter[$i];
			$ordencenter[$i] = (int)$ordencenter[$i];
			$columnacenter[$i] = (int)$columnacenter[$i];
			$idcenter[$i] = (int)$idcenter[$i];
			
			$smcFunc['db_query']('','
				UPDATE {db_prefix}adk_blocks
				SET activate = {int:activate},
				orden = {int:orden},
				columna = {int:columna}
				WHERE id = {int:id}',
				array(
					'activate' => $activatecenter[$i],
					'orden' => $ordencenter[$i],
					'columna' => $columnacenter[$i],
					'id' => $idcenter[$i],
				)
			);
			$i++;
		}
	}

		   
	if(!empty($_POST['idright']))
	{
		$activateright =  $_POST['activateright'];  
		$ordenright =  $_POST['ordenright'];  
		$idright =  $_POST['idright'];  
		$columnaright =  $_POST['columnaright'];	
			

		$i = 0;
		$n = count($idright);

		while ($i < $n)
		{
			$activateright[$i] = (int)$activateright[$i];
			$ordenright[$i] = (int)$ordenright[$i];
			$columnaright[$i] = (int)$columnaright[$i];
			$idright[$i] = (int)$idright[$i];
			

			$smcFunc['db_query']('','
				UPDATE {db_prefix}adk_blocks
				SET activate = {int:activate},
				orden = {int:orden},
				columna = {int:columna}
				WHERE id = {int:id}',
				array(
					'activate' => $activateright[$i],
					'orden' => $ordenright[$i],
					'columna' => $columnaright[$i],
					'id' => $idright[$i],
				)
			);
			$i++;
		}
	}
	
	if(!empty($_POST['idtop']))
	{
		$activatetop =  $_POST['activatetop'];  
		$ordentop =  $_POST['ordentop'];  
		$idtop =  $_POST['idtop'];  
		$columnatop =  $_POST['columnatop'];	
			

		$i = 0;
		$n = count($idtop);

		while ($i < $n)
		{
			$activatetop[$i] = (int)$activatetop[$i];
			$ordentop[$i] = (int)$ordentop[$i];
			$columnatop[$i] = (int)$columnatop[$i];
			$idtop[$i] = (int)$idtop[$i];
			

			$smcFunc['db_query']('','
				UPDATE {db_prefix}adk_blocks
				SET activate = {int:activate},
				orden = {int:orden},
				columna = {int:columna}
				WHERE id = {int:id}',
				array(
					'activate' => $activatetop[$i],
					'orden' => $ordentop[$i],
					'columna' => $columnatop[$i],
					'id' => $idtop[$i],
				)
			);
			$i++;
		}
	}
	
	if(!empty($_POST['idbottom']))
	{
		$activatebottom =  $_POST['activatebottom'];  
		$ordenbottom =  $_POST['ordenbottom'];  
		$idbottom =  $_POST['idbottom'];  
		$columnabottom =  $_POST['columnabottom'];	
			

		$i = 0;
		$n = count($idbottom);

		while ($i < $n)
		{
			$activatebottom[$i] = (int)$activatebottom[$i];
			$ordenbottom[$i] = (int)$ordenbottom[$i];
			$columnabottom[$i] = (int)$columnabottom[$i];
			$idbottom[$i] = (int)$idbottom[$i];
			

			$smcFunc['db_query']('','
				UPDATE {db_prefix}adk_blocks
				SET activate = {int:activate},
				orden = {int:orden},
				columna = {int:columna}
				WHERE id = {int:id}',
				array(
					'activate' => $activatebottom[$i],
					'orden' => $ordenbottom[$i],
					'columna' => $columnabottom[$i],
					'id' => $idbottom[$i],
				)
			);
			$i++;
		}
	}
		
	redirectexit('action=admin;area=blocks;sa=viewblocks;'.$context['session_var'].'=' . $context['session_id']);


}

function deleteblocks()
{

	global $scripturl,$smcFunc, $context, $boarddir;
	
	checkSession('get');
	
	if(!empty($_REQUEST['delete']) && is_numeric($_REQUEST['delete']))
		$id_delete = (int) $_REQUEST['delete'];
	else
		fatal_lang_error('error_adk_not_id',false);
   
	$sql = $smcFunc['db_query']('','
		SELECT echo,type FROM {db_prefix}adk_blocks
		WHERE id = {int:id}',
		array(
			'id' => $id_delete,
		)
	);
	$row = $smcFunc['db_fetch_assoc']($sql);
	
	if(empty($row['echo']))
		fatal_lang_error('error_adk_not_id',false);
	
	$smcFunc['db_free_result']($sql);
	
	//DELETE FILE
	if($row['type'] == 'include')
	{
		$echo = $boarddir.'/adkportal/blocks/'.$row['echo'];
		@unlink($echo);
	}
	
	$smcFunc['db_query']('','
		DELETE FROM {db_prefix}adk_blocks 
		WHERE id = {int:id}',
		array(
			'id' => $id_delete,
		)
	);
			

	redirectexit('action=admin;area=blocks;sa=viewblocks;'.$context['session_var'].'=' . $context['session_id']);
}

function editblocks()
{
	global $context, $txt, $smcFunc, $boardurl, $sourcedir;
	
	checkSession('get');

	if(!empty($_REQUEST['edit']) && is_numeric($_REQUEST['edit']))
		$id_block = (int)$_REQUEST['edit'];
	else
		fatal_lang_error('error_adk_not_id',false);
	
	$context['sub_template'] = 'editblocks';	
	
	$edit = $smcFunc['db_query']('','
		SELECT * FROM {db_prefix}adk_blocks 
		WHERE id = {int:id}',
		array(
			'id' => $id_block,
		)
	);
	
	$fila = $smcFunc['db_fetch_assoc']($edit);
	
	$context['edit'] = array (
		'title' => $fila['name'],
		'new' => un_CleanAdkStrings($fila['echo']),
		'id' => $fila['id'],
		'img' => $fila['img'],
		'type' => $fila['type'],
		'empty_body' => $fila['empty_body'],
		'empty_title' => $fila['empty_title'],
		'empty_collapse' => $fila['empty_collapse'],
	);
	
	// Needed for the WYSIWYG editor.
	require_once($sourcedir . '/Subs-Editor.php');
	
	if($context['edit']['type'] == 'html')
		$context['edit']['new'] = $context['edit']['new'];

	// Now create the editor.
	$editorOptions = array(
		'id' => 'descript',
		'value' => $context['edit']['new'],
		'width' => '97%',
		'form' => 'picform',
		'labels' => array(
			'post_button' => '',
		),
	);
	create_control_richedit($editorOptions);
	$context['post_box_name'] = $editorOptions['id'];
	
	$resto = substr ($context['edit']['new'], -4);    // devuelve .php
	
	/*if(empty($context['edit']['title']))
		fatal_lang_error('error_adk_not_id',FALSE);*/
	
	$context['page_title'] = $context['edit']['title'];
	
	
	$smcFunc['db_free_result']($edit);
}

function saveeditblocks()
{
	global $sourcedir ,$smcFunc, $context;

	checkSession('post');
	
	if (!empty($_REQUEST['descript_mode']) && isset($_POST['descript']))
	{
		require_once($sourcedir . '/Subs-Editor.php');

		$_POST['descript'] = html_to_bbc($_POST['descript']);

		// We need to unhtml it now as it gets done shortly.
		$_POST['descript'] = un_CleanAdkStrings($_POST['descript']);

	}
	
	$type = CleanAdkStrings($_POST['type_']);
	$echo = CleanAdkStrings($_POST['descript']);
	
	$title = CleanAdkStrings($_POST['titulo']);
	$id = (int)$_POST['id'];
	$img = CleanAdkStrings($_POST['img']);
	
	$empty_body = !empty($_POST['empty_body']) ? 1 : 0;
	$empty_title = !empty($_POST['empty_title']) ? 1 : 0;
	$empty_collapse = !empty($_POST['empty_collapse']) ? 1 : 0;

	$smcFunc['db_query']('','
		UPDATE {db_prefix}adk_blocks 
		SET name = {string:title},
		echo = {string:echo},
		img = {string:img},
		empty_body = {int:b},
		empty_collapse = {int:c},
		empty_title = {int:t}
		WHERE id = {int:id}',
		array(
			'title' => $title,
			'echo' => $echo,
			'img' => $img,
			'id' => $id,
			'b' => $empty_body,
			't' => $empty_title,
			'c' => $empty_collapse,
		)
	);



	redirectexit('action=admin;area=blocks;sa=viewblocks;'.$context['session_var'].'=' . $context['session_id']);

}


function openDirImages($image = false)
{
	global $boardir, $adkportal, $txt, $smcFunc, $boardurl;
	
	echo'
	<table style="text-align: center;">';
	
	echo'
		<tr>
			<td colspan="5">
			'.$txt['adk_imagen_ninguna'].'<input type="radio" name="img" value=""',empty($image) ? ' checked="checked"' : '',' />&nbsp;&nbsp;&nbsp;&nbsp;
			</td>
		</tr>
		<tr>';
	
	$icons = $smcFunc['db_query']('','SELECT icon FROM {db_prefix}adk_icons');
	$adkportal['icons'] = array();
	
	while($row = $smcFunc['db_fetch_assoc']($icons))
	{
		$adkportal['icons'][] = array(
			'icon' => $row['icon']
		);
	}
	
	$smcFunc['db_free_result']($icons);
	$i = 1;
	foreach($adkportal['icons'] AS $icon)
	{	
		if($i == 15)
		{
			echo'</tr><tr>';
			$i = 1;
		}
		
		echo'
			<td>
				<img src="'.$boardurl.'/adkportal/images/blocks/'.$icon['icon'].'" alt="" /><input type="radio" name="img" value="'.$icon['icon'].'" ',!empty($image) && $image == $icon['icon'] ? ' checked="checked"' : '' ,' />&nbsp;&nbsp;&nbsp;&nbsp;
			</td>';
		
		$i++;
	
	}
	echo'
		</tr></table>';

}


function createnews()
{
	global $context, $txt, $boardurl, $sourcedir;
	
	checkSession('get');

	//Load main trader template.
	$context['sub_template']  = 'createnews';
	$context['page_title'] = $txt['nueva_noticia'];
	
	// Needed for the WYSIWYG editor.
	require_once($sourcedir . '/Subs-Editor.php');

	// Now create the editor.
	$editorOptions = array(
		'id' => 'descript',
		'value' => '',
		'width' => '97%',
		'form' => 'picform',
		'labels' => array(
			'post_button' => '',
		),
	);
	create_control_richedit($editorOptions);
	$context['post_box_name'] = $editorOptions['id'];
	
}

function savecreatenews()
{
	global $context, $scripturl, $smcFunc, $sourcedir;

	checkSession('post');
	
	if (!empty($_REQUEST['descript_mode']) && isset($_REQUEST['descript']))
	{
		require_once($sourcedir . '/Subs-Editor.php');

		$_REQUEST['descript'] = html_to_bbc($_REQUEST['descript']);

		// We need to unhtml it now as it gets done shortly.
		$_REQUEST['descript'] = un_CleanAdkStrings($_REQUEST['descript']);

	}
	
	$autore = CleanAdkStrings($_POST['autore']);
	$titlepage = CleanAdkStrings($_POST['titlepage']);	
	$quest = CleanAdkStrings($_REQUEST['descript']);
	$time = time();
	
	$quest = $quest;
	
	$the_array_info = array(
		'titlepage' => 'text',
		'new' => 'text',
		'autor' => 'text',
		'time' => 'int',
	);
	
	$the_array_insert = array(
		$titlepage,$quest,$autore,$time
	);

	$smcFunc['db_insert']('insert',
		'{db_prefix}adk_news',
		$the_array_info,
		$the_array_insert,
		array('id_new')
	);
	
	redirectexit('action=admin;area=blocks;'.$context['session_var'].'='.$context['session_id']);


}

function showeditnews()
{
	global $context, $sourcedir, $txt, $smcFunc, $boardurl, $options;
	
	checkSession('get');
	
	if(!empty($_REQUEST['id']) && is_numeric($_REQUEST['id']))
		$id_new = (int)$_REQUEST['id'];
	else
		fatal_lang_error('error_adk_not_id',FALSE);

	$context['sub_template'] = 'showeditnews';	
	
	$edit = $smcFunc['db_query']('','
		SELECT titlepage, new, autor, id 
		FROM {db_prefix}adk_news 
		WHERE id = {int:id}',
		array(
			'id' => $id_new,
		)
	);
	
	$fila = $smcFunc['db_fetch_assoc']($edit);
	
	$context['edit'] = array (
		'title' => un_CleanAdkStrings($fila['titlepage']),
		'new' => un_CleanAdkStrings($fila['new']),
		'autor' => un_CleanAdkStrings($fila['autor']),
		'id' => $fila['id']
	);
		

	if(empty($context['edit']['title']))
		fatal_lang_error('error_adk_not_id',FALSE);
	
	$context['page_title'] = $context['edit']['title'];
	
	$smcFunc['db_free_result']($edit);
	
	// Needed for the WYSIWYG editor.
	require_once($sourcedir . '/Subs-Editor.php');

	// Now create the editor.
	$editorOptions = array(
		'id' => 'descript',
		'value' => $context['edit']['new'],
		'width' => '97%',
		'preview_type' => 0,
	);
	
	create_control_richedit($editorOptions);
	$context['post_box_name'] = $editorOptions['id'];
	
	$options['wysiwyg_default'] = true;
	
	
}

function showsaveeditnews()
{
	global $smcFunc, $context, $sourcedir;
	
	checkSession('post');
	
	if (!empty($_REQUEST['descript_mode']) && isset($_REQUEST['descript']))
	{
		require_once($sourcedir . '/Subs-Editor.php');

		$_REQUEST['descript'] = html_to_bbc($_REQUEST['descript']);

		// We need to unhtml it now as it gets done shortly.
		$_REQUEST['descript'] = un_CleanAdkStrings($_REQUEST['descript']);

	}
	
	$id_new = (int)$_POST['id'];
	$autor = CleanAdkStrings($_POST['autore']);
	$title = CleanAdkStrings($_POST['titlepage']);
	$insert = CleanAdkStrings($_REQUEST['descript']);
	
	$insert = $insert;

	$smcFunc['db_query']('','
		UPDATE {db_prefix}adk_news
		SET autor = {string:autor},
		titlepage = {string:title},
		new = {string:insert}
		WHERE id = {int:id}',
		array(
			'autor' => $autor,
			'title' => $title,
			'insert' => $insert,
			'id' => $id_new,
		)
	);
	

	redirectexit();
}

function showdeletenews()
{
	global $db_prefix,$scripturl, $smcFunc;
	
	checkSession('get');
	
	if(!empty($_REQUEST['del']) && is_numeric($_REQUEST['del']))
		$id_new = (int)$_REQUEST['del'];
	else
		$id_new = 0;
   
	$smcFunc['db_query']('','
		DELETE FROM {db_prefix}adk_news 
		WHERE id = {int:id}',
		array(
			'id' =>$id_new,
		)
	);

	redirectexit();
}	

function uploadblock()
{
	global $context, $txt;
	
	checkSession('get');
	
	$context['sub_template']  = 'uploadblock';

	$context['page_title'] = $txt['adk_upload_yourBlock'];


}

function saveuploadblock()
{
	global $context, $boarddir, $txt, $smcFunc;
	
	checkSession('post');
	
	if(empty($_FILES['file']['name']))
		fatal_lang_error('fatal_lang_error_not_block',false);
	
	$explode = explode('.',$_FILES['file']['name']);
	$count = count($explode) - 1;
	$extension = $explode[$count];
	
	if($extension != 'php')
		fatal_lang_error('fatal_lang_error_not_block',false);
	else
	{
		$name = $_FILES['file']['name'];
		$name2 = str_replace('.php','',$_FILES['file']['name']);
		
		@chmod($boardir.'/adkportal/blocks',777);
		move_uploaded_file($_FILES['file']['tmp_name'], $boarddir.'/adkportal/blocks/' .   $_FILES['file']['name']);
		@chmod($boardir.'/adkportal/blocks',644);
		@chmod($boardir.'/adkportal/blocks/'.$_FILES['file']['name'],644);
		
		$smcFunc['db_query']('',"
			INSERT INTO {db_prefix}adk_blocks 
			(id,name,echo,activate,columna,orden,img,type)
			VALUES
			(NULL,'$name2','$name',0,2,1,'','include')"
		);
	}
	
	redirectexit('action=admin;area=blocks;sa=viewblocks;'.$context['session_var'].'=' . $context['session_id']);

}

function PermissionBlock()
{
	global $smcFunc, $context, $txt;
	
	checkSession('get');
	
	if(!empty($_REQUEST['id']) && is_numeric($_REQUEST['id']))
		$id = (int)$_REQUEST['id'];
	else
		fatal_lang_error('error_adk_not_id',FALSE);
		
	//LoadMemberGroups
	$sql = $smcFunc['db_query']('','
		SELECT id_group, group_name
		FROM {db_prefix}membergroups
		WHERE min_posts = {int:p}',
		array(
			'p' => -1,
		)
	);
	
	$context['adk_groups'] = array();
	
	while($row = $smcFunc['db_fetch_assoc']($sql))
		$context['adk_groups'][$row['id_group']] = $row['group_name'];
	
	$smcFunc['db_free_result']($sql);
	
	$sql = $smcFunc['db_query']('','
		SELECT id, name, permissions FROM {db_prefix}adk_blocks
		WHERE id = {int:id}',
		array(
			'id' => $id,
		)
	);
	
	$row = $smcFunc['db_fetch_assoc']($sql);
	
	$context['block'] = array(
		'id' => $row['id'],
		'name' => $row['name'],
		'permissions' => $row['permissions'],
	);
	
	$smcFunc['db_free_result']($sql);
	
	if(empty($context['block']))
		fatal_lang_error('error_adk_not_id',FALSE);
	
	$context['sub_template'] = 'permissions';
	$context['page_title'] = $row['name'].' - '.$txt['adk_permissions_block'];
	
}

function SavePermissionBlock()
{
	global $smcFunc, $context, $txt;
	
	checkSession('post');
	
	if(!empty($_POST['adk']))
	{	
		$adk = array_keys($_POST['adk']);
		$adk = implode(',',$adk);
	}
	else
		$adk = '';
		
	$id = (int)$_POST['id'];
	
	$smcFunc['db_query']('','
		UPDATE {db_prefix}adk_blocks
		SET permissions = {text:adk}
		WHERE id = {int:id}',
		array(
			'adk' => $adk,
			'id' => $id,
		)
	);
	
	redirectexit('action=admin;area=blocks;sa=viewblocks;'.$context['session_var'].'=' . $context['session_id']);
	
}

function ShoutBoxSettings()
{
	global $smcFunc, $context, $txt;
	
	checkSession('get');
	
	$context['sub_template'] = 'shoutbox';
	$context['page_title'] = $txt['adk_shout'];
	
	$sql = $smcFunc['db_query']('',"
		SELECT id_group, group_name
		FROM {db_prefix}membergroups
		WHERE min_posts = '-1' AND id_group <> '1'
	");
	
	$context['memberadk'] = array();
	
	while($row = $smcFunc['db_fetch_assoc']($sql))
		$context['memberadk'][$row['id_group']] = $row['group_name'];
	
	$smcFunc['db_free_result']($sql);
	
	
}

function ShoutboxSave()
{
	global $context, $smcFunc;
	
	checkSession('post');
	
	$shout_title = CleanAdkStrings($_POST['shout_title']);
	
	if (isset($_POST['shout_allowed_groups_view'])){
		foreach ($_POST['shout_allowed_groups_view'] as $i => $v)
		{
			 if (!is_numeric($_POST['shout_allowed_groups_view'][$i])) 
				unset($_POST['shout_allowed_groups_view'][$i]);
			else
				$_POST['shout_allowed_groups_view'][$i] = (int)$_POST['shout_allowed_groups_view'][$i];
		}
	$shout_allowed_groups_view = implode(',', $_POST['shout_allowed_groups_view']);
	}
	else
		$shout_allowed_groups_view = 1;
	
	if (isset($_POST['shout_allowed_groups'])){
		foreach ($_POST['shout_allowed_groups'] as $i => $v)
		{
			 if (!is_numeric($_POST['shout_allowed_groups'][$i])) 
				unset($_POST['shout_allowed_groups'][$i]);
			else
				$_POST['shout_allowed_groups'][$i] = (int)$_POST['shout_allowed_groups'][$i];
		}
	$shout_allowed_groups = implode(',', $_POST['shout_allowed_groups']);
	}
	else
		$shout_allowed_groups = 1;
	
	updateSettingsAdkPortal( 
		array(
			'shout_title' => $shout_title,
			'shout_allowed_groups' => $shout_allowed_groups,
			'shout_allowed_groups_view' => $shout_allowed_groups_view,
		)
	);
	
	//Permissions, For some errors ;)
	global $boarddir;
	@chmod($boarddir.'/adkportal/shoutbox', 0755);
	@chmod($boarddir.'/adkportal/shoutbox/shoutbox.php', 0644);
	@chmod($boarddir.'/adkportal/shoutbox/shoutbox.js', 0644);
	
	
	redirectexit('action=admin;area=blocks;sa=shoutbox;'.$context['session_var'].'='.$context['session_id'].';done');
	
}

function DeleteShoutboxMessages()
{
	checkSession('get');
	
	global $smcFunc, $context;
	
	$smcFunc['db_query']('','DELETE FROM {db_prefix}adk_shoutbox');
	
	redirectexit('action=admin;area=blocks;sa=shoutbox;'.$context['session_var'].'='.$context['session_id'].';done');
}

?>