<?php
/********************************************************
* Adk Portal                   
* Version: 2.1
* Official support: http://www.smfpersonal.net           
* Founder & Developer: Lucas-ruroken
* Project Manager: ^Heracles^ - Enik
* 2009-2011
* Smf Personal - Home of adkportal
/**********************************************************/


if (!defined('SMF'))
	die('Hacking attempt...');

function AdkModules()
{
	global $context, $txt, $settings, $boardurl;
	
	isAllowedTo('adk_portal');
	
	loadTemplate('Adk-Modules');
	
	if(loadLanguage('Adk-Admin') == false)
		loadLanguage('Adk-Admin','english');
		
	$subActions = array(
		'intro' => 'introAdk',
		'viewadminpages' => 'viewadminpages',
		'createpages' => 'createpages',
		'savecreatedpages' => 'savecreatedpages',
		'editpages' => 'editpages',
		'saveeditpages' => 'saveeditpages',
		'deletepages' => 'deletepages',
		'uploadanyimage' => 'UploadNewImage',
		'saveuploadimg' => 'SaveUploadNewImage',
		'manageimagesadk' => 'ManageImagesAdk',
		'deleteimagesadk' => 'DeleteImagesAdk',
		'savesettingsimagesadk' => 'SaveSettingsImagesAdk',
		'contact' => 'ContactAdmin',
		'save_contact' => 'SaveContactAdmin',
	);
	
	
	$context[$context['admin_menu_name']]['tab_data'] = array(
		'title' => $txt['adk_modules_settings'],
		'description' => $txt['adk_first_modules'],
		'tabs' => array(
			'intro' => array(
				'description' => $txt['adk_first_modules'],
				'label' => '<img style="vertical-align: middle;" alt="" src="'.$settings['default_theme_url'].'/images/admin/intro.png" />'.$txt['adk_modules_intro'],
			),
			'viewadminpages' => array(
				'description' => $txt['adk_second_modules'],
				'label' => '<img style="vertical-align: middle;" alt="" src="'.$settings['default_theme_url'].'/images/admin/pages.png" />'.$txt['adk_admin_pages'],
			),
			'contact' => array(
				'description' => $txt['adk_desc_contacto'],
				'label' => '<img style="vertical-align: middle;" alt="" src="'.$boardurl.'/adkportal/images/newmsg.png" />'.$txt['adk_contacto'],
			),
			'uploadanyimage' => array(
				'description' => $txt['adk_tirth_modules'],
				'label' => '<img style="vertical-align: middle;" alt="" src="'.$settings['default_theme_url'].'/images/admin/imagesadvanced.png" />'.$txt['advanced_block_images'],
			),
			'manageimagesadk' => array(
				'description' => $txt['adk_fourth_modules'],
				'label' => '<img style="vertical-align: middle;" alt="" src="'.$settings['default_theme_url'].'/images/admin/images.png" />'.$txt['adk_manage_images'],
			),			
		),
	);	
	
	// Follow the sa or just go to View function
	if (!empty($_GET['sa']) && !empty($subActions[$_GET['sa']]))
		$subActions[@$_GET['sa']]();
	else
		$subActions['intro']();
		
}

function introAdk()
{
	global $context, $txt;
	
	$context['sub_template']  = 'introAdk';
	$context['page_title'] = $txt['adk_modules_intro'];
	
	global $sourcedir;
	require_once($sourcedir .'/Subs-Package.php');
	
	$context['file'] = fetch_web_data('http://www.smfpersonal.net/news/read_modules.php');

}


function viewadminpages()
{
	global $context, $txt, $smcFunc, $scripturl;
	
	checkSession('get');
	
	//Load main trader template.
	$context['sub_template']  = 'viewadminpages';

	//Set the page title
	$context['page_title'] = $txt['adk_admin_pages'];
	
	$sql = $smcFunc['db_query']('','
		SELECT COUNT(*) AS total 
		FROM {db_prefix}adk_pages
	');
	
	$the_row = $smcFunc['db_fetch_assoc']($sql);
	$smcFunc['db_free_result']($sql);
	
	
		
	$total = $the_row['total'];
	$context['start'] = !empty($_REQUEST['start']) ? (int)$_REQUEST['start'] : 0;
	$limit = 10;
	
	$sql = $smcFunc['db_query']('','
		SELECT id_page, titlepage, urltext, views 
		FROM {db_prefix}adk_pages 
		ORDER BY titlepage ASC
		LIMIT {int:start},{int:end}',
		array(
			'start' => $context['start'],
			'end' => $limit,
		)
	);
	
	$context['total_admin_pages'] = array();
	
	while($row = $smcFunc['db_fetch_assoc']($sql))
	{
		$context['total_admin_pages'][] = array(
			'id_page' => $row['id_page'],
			'titlepage' => $row['titlepage'],
			'urltext' => $row['urltext'],
			'views' => $row['views'],
		);
	}
	
	$context['page_index'] = constructPageIndex($scripturl . '?action=admin;area=modules;sa=viewadminpages;'.$context['session_var'].'='.$context['session_id'], $context['start'], $total, $limit);
		
	$smcFunc['db_free_result']($sql);
}

function createpages()
{
	
	global $context, $txt, $smcFunc, $sourcedir, $adkportal;
	
	checkSession('get');

	//Load main trader template.
	$context['sub_template']  = 'createpages';

	//Set the page title
	$context['page_title'] = $txt['adk_admin_pages_create'];
	
	$sql = $smcFunc['db_query']('','
		SELECT id_group, group_name 
		FROM {db_prefix}membergroups  
		ORDER BY id_group DESC'
	); 
	
	$context['group_view_pages'] = array();
	
	while($row = $smcFunc['db_fetch_assoc']($sql))
	{
		$context['group_view_pages'][] = array(
			'id' => $row['id_group'],
			'name' => $row['group_name']
		);
	}
	
	$smcFunc['db_free_result']($sql);
	
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

function savecreatedpages()
{
	global $context, $txt, $smcFunc, $sourcedir;
	
	checkSession('post');
	
	$titlepage = CleanAdkStrings($_POST['titlepage']);
	$urltext = CleanAdkStrings($_POST['urltext']);
	
	if(!empty($_POST['groups_allowed']))
	{	
		$groups_allowed = array_keys($_POST['groups_allowed']);
		$groups_allowed = implode(',',$groups_allowed);
	}
	else
		$groups_allowed = '';
	
	if (!empty($_REQUEST['descript_mode']) && isset($_REQUEST['descript']))
	{
		require_once($sourcedir . '/Subs-Editor.php');

		$_REQUEST['descript'] = html_to_bbc($_REQUEST['descript']);

		// We need to unhtml it now as it gets done shortly.
		$_REQUEST['descript'] = un_CleanAdkStrings($_REQUEST['descript']);

	}
	
	$enableleft = (int)$_POST['enableleft'];
	$enableright = (int)$_POST['enableright'];
	$type = $_POST['type'];
	$body = CleanAdkStrings(stripslashes($_REQUEST['descript']));
	$cattitlebg = $_POST['cattitlebg'];
	$winbg = $_POST['winbg'];
	$views = 0;
	
	$sql = $smcFunc['db_query']('','
		SELECT urltext
		FROM {db_prefix}adk_pages'
	);
	
	WHILE($row = $smcFunc['db_fetch_assoc']($sql))
		$context['load_urltext'][] = $row['urltext'];
	
	if(!empty($context['load_urltext']) && in_array($urltext,$context['load_urltext']))
		fatal_lang_error('duplicate_adk_pages',FALSE);
	
	if(empty($titlepage))
		fatal_lang_error('adk_categorie_not_title',false);
	
	
	$smcFunc['db_query']('',"
		INSERT INTO {db_prefix}adk_pages (urltext,titlepage,body,views,grupos_permitidos, type,
		winbg, cattitlebg, enableleft, enableright)
		VALUES
		('$urltext','$titlepage','$body','$views','$groups_allowed','$type','$winbg','$cattitlebg',
		'$enableleft', '$enableright')
	");
	

	redirectexit('action=admin;area=modules;sa=viewadminpages;'.$context['session_var'].'=' . $context['session_id']);
	

}

function deletepages()
{
	global $smcFunc, $context;
	
	checkSession('get');
	
	if(!empty($_REQUEST['id']) && is_numeric($_REQUEST['id']))
		$id = (int) $_REQUEST['id'];
	else
		$id = 0;
	
	$smcFunc['db_query']('','DELETE FROM {db_prefix}adk_pages WHERE id_page = {int:page}',array('page' => $id,));
	
	redirectexit('action=admin;area=modules;sa=viewadminpages;'.$context['session_var'].'=' . $context['session_id']);


}

function editpages()
{

	global $context, $txt, $smcFunc, $sourcedir;
	checkSession('get');

	//Load main trader template.
	$context['sub_template']  = 'editpages';

	//Set the page title
	$context['page_title'] = $txt['adk_admin_pages_edit'];
	
	if(!empty($_REQUEST['id']))
		$id = (int) $_REQUEST['id'];
	else
		fatal_lang_error('error_adk_not_id',FALSE);
		
	$sql = $smcFunc['db_query']('','
		SELECT * 
		FROM {db_prefix}adk_pages 
		WHERE id_page = {int:page}',
		array(
			'page' => $id,
		)
	);
	
	$row = $smcFunc['db_fetch_assoc']($sql);
	
		$context['edit_admin_page'] = array(
			'id_page' => $row['id_page'],
			'body' => un_CleanAdkStrings($row['body']),
			'urltext' => un_CleanAdkStrings($row['urltext']),
			'titlepage' => un_CleanAdkStrings($row['titlepage']),
			'grupos_permitidos' => $row['grupos_permitidos'],
			'type' => $row['type'],
			'winbg' => $row['winbg'],
			'cattitlebg' => $row['cattitlebg'],
			'enableleft' => $row['enableleft'],
			'enableright' => $row['enableright']
		);
	

	if(empty($context['edit_admin_page']['titlepage']))
		fatal_lang_error('error_adk_not_id',FALSE);

	$smcFunc['db_free_result']($sql);
	
	
	// Needed for the WYSIWYG editor.
	require_once($sourcedir . '/Subs-Editor.php');

	// Now create the editor.
	$editorOptions = array(
		'id' => 'descript',
		'value' => $context['edit_admin_page']['body'],
		'width' => '97%',
		'form' => 'picform',
		'labels' => array(
			'post_button' => '',
		),
	);
	create_control_richedit($editorOptions);
	$context['post_box_name'] = $editorOptions['id'];


}

function saveeditpages()
{
	checkSession('post');
	
	global $context, $txt, $smcFunc, $sourcedir;
	
	$titlepage = CleanAdkStrings($_POST['titlepage']);
	$urltext = CleanAdkStrings($_POST['urltext']);
	
	if(!empty($_POST['groups_allowed']))
	{	
		$groups_allowed = array_keys($_POST['groups_allowed']);
		$groups_allowed = implode(',',$groups_allowed);
	}
	else
		$groups_allowed = '';
	
	if (!empty($_REQUEST['descript_mode']) && isset($_REQUEST['descript']))
	{
		require_once($sourcedir . '/Subs-Editor.php');

		$_REQUEST['descript'] = html_to_bbc($_REQUEST['descript']);

		// We need to unhtml it now as it gets done shortly.
		$_REQUEST['descript'] = un_CleanAdkStrings($_REQUEST['descript']);

	}
	
	$enableleft = (int)$_POST['enableleft'];
	$enableright = (int)$_POST['enableright'];
	$type = $_POST['type'];
	$body = CleanAdkStrings($_REQUEST['descript']);
	$cattitlebg = $_POST['cattitlebg'];
	$winbg = $_POST['winbg'];
	//$views = 0;
	
	$id_page = $_POST['id_page'];
	
	$sql = $smcFunc['db_query']('','
		SELECT urltext
		FROM {db_prefix}adk_pages'
	);
	
	WHILE($row = $smcFunc['db_fetch_assoc']($sql))
		$context['load_urltext'][] = $row['urltext'];
	
	$i = 0;
	
	foreach($context['load_urltext'] AS $newurl)
	{
		if($newurl == $urltext)
			$i++;
	}
	
	if($i > 1)
		fatal_lang_error('duplicate_adk_pages',FALSE);
	
	if(empty($titlepage))
		fatal_lang_error('adk_categorie_not_title',false);
	
	$smcFunc['db_query']('','UPDATE {db_prefix}adk_pages
		SET titlepage = {string:titlepage}, urltext = {string:urltext},
		grupos_permitidos = {string:grupos}, type = {string:type},
		body = {string:body}, winbg = {string:winbg}, cattitlebg = {string:cat},
		enableleft = {int:left}, enableright = {int:right}
		WHERE id_page = {int:page}',
		array(
			'titlepage' => $titlepage,
			'urltext' => $urltext,
			'grupos' => $groups_allowed,
			'type' => $type,
			'body' => $body,
			'winbg' => $winbg,
			'cat' => $cattitlebg,
			'left' => $enableleft,
			'right' => $enableright,
			'page' => $id_page,
		)
	);
		
	redirectexit('action=admin;area=modules;sa=viewadminpages;'.$context['session_var'].'=' . $context['session_id']);

}

function UploadNewImage()
{
	global $context, $txt;
	
	checkSession('get');
	
	$context['sub_template'] = 'adk_new_image';
	$context['page_title'] = $txt['advanced_block_images'];
	/*($_FILES["file"]["type"] == "image/jpeg")
	|| ($_FILES["file"]["type"] == "image/pjpeg"))
*/
}
	
	
function SaveUploadNewImage()
{
	global $context, $smcFunc, $txt, $boarddir, $boardurl;
	
	checkSession('post');
	
	if(empty($_POST['url']))
		fatal_lang_error('adk_require_url_p',false);
	
	if(empty($_FILES['image']['name']) && empty($_POST['image2']))
		fatal_lang_error('not_select_image_icon',false);
	
	$style = !empty($_POST['format']) ? (int)$_POST['format'] : 2;
	$url = CleanAdkStrings($_POST['url']);
	$filename = CleanAdkStrings($_POST['image2']);
	
	$explode = explode('.',$filename);
	$count = count($explode) - 1;
	$extension = $explode[$count];
	
	if(!empty($filename)){
		
		$is_image = checkIfValidExtension($extension);
		
		if(!$is_image)
			fatal_lang_error('not_select_image_icon',false);
	}
	
	if(!empty($_FILES['image']['name']))
	{
		if($_FILES['image']['type'] == "image/gif" 
			|| $_FILES['image']['type'] == "image/png" 
			|| $_FILES["image"]["type"] == "image/jpeg"
			|| $_FILES["image"]["type"] == "image/pjpeg")
		{
			$filename2 = $boarddir.'/adkportal/tmp/'.$_FILES['image']['name'];
			$filename = $boardurl.'/adkportal/tmp/'.$_FILES['image']['name'];
			$explode = explode('.',$_FILES['image']['name']);
			$count = count($explode) - 1;
			$extension = $explode[$count];
			
			
			@chmod($boardir.'/adkportal/tmp',777);
			move_uploaded_file($_FILES['image']['tmp_name'], $filename2);
			
			//@chmod($boardir.'/adkportal/tmp/'.$filename,644);
			//@chmod($boardir.'/adkportal/tmp',644);
			
		}
		else
		fatal_lang_error('not_select_image_icon',false);
	}
	
	
	$watermark = CleanAdkStrings($_POST['wm']);
	$imagen_name = $boarddir.'/adkportal/images/'.time().'.JPG';
	$imagen_name2 = $boardurl.'/adkportal/images/'.time().'.JPG';
	
	//Generate Image ;)
	load_AvdImage($watermark, $filename, $extension, $style, $imagen_name);
	
	$smcFunc['db_query']('',"
		INSERT INTO {db_prefix}adk_advanced_images
		VALUES
		(NULL,'$imagen_name2','$url')
	");
	
	if(!empty($_FILES['image']['name']))
	{
		if($_FILES['image']['type'] == "image/gif" 
			|| $_FILES['image']['type'] == "image/png" 
			|| $_FILES["image"]["type"] == "image/jpeg"
			|| $_FILES["image"]["type"] == "image/pjpeg")
		{
			unlink($filename2);
			@chmod($boardir.'/adkportal/tmp',644);
		}
	}
	
	redirectexit('action=admin;area=modules;sa=manageimagesadk;'.$context['session_var'].'='.$context['session_id']);


	
}	

function ManageImagesAdk()
{
	checkSession('get');
	
	global $context, $smcFunc, $txt, $scripturl;
	$context['sub_template'] = 'manages_images';
	$context['page_title'] = $txt['adk_opcion_yeahhhh'];
	
	//Load Images
	$context['start'] = !empty($_REQUEST['start']) ? (int)$_REQUEST['start'] : 0;
	$limit = 6;
	
	$load = $smcFunc['db_query']('','
		SELECT COUNT(*) AS total
		FROM {db_prefix}adk_advanced_images'
	);
	$row = $smcFunc['db_fetch_assoc']($load);
	$total = $row['total'];
	$smcFunc['db_free_result']($load);
	
	
	$sql = $smcFunc['db_query']('',"
		SELECT id,image,url
		FROM {db_prefix}adk_advanced_images
		ORDER BY id DESC
		LIMIT $context[start], $limit
	");
	$context['load_img'] = array();
	while($row = $smcFunc['db_fetch_assoc']($sql))
	{
		$context['load_img'][] = array(
			'id' => $row['id'],
			'url' => $row['url'],
			'image' => $row['image'],
		);
	}
	
	$smcFunc['db_free_result']($sql);
	
	$context['page_index'] = constructPageIndex($scripturl . '?action=admin;area=modules;sa=manageimagesadk;'.$context['session_var'].'='.$context['session_id'], $context['start'], $total, $limit);
}
		
	
function DeleteImagesAdk()
{
	checkSession('get');
	global $smcFunc, $context, $boarddir,$boardurl;
	
	$id = !empty($_REQUEST['id']) ? (int)$_REQUEST['id'] : 0;
	
	if(!empty($_REQUEST['url2']))
		$url = CleanAdkStrings($_REQUEST['url2']);
	else
		fatal_lang_error('adk_require_url',false);
	
	$url = str_replace($boardurl,$boarddir,$url);
	
	@chmod($url,777);
	@unlink($url);
	
	$smcFunc['db_query']('','
		DELETE FROM {db_prefix}adk_advanced_images
		WHERE id = {int:id}',
		array(
			'id' => $id,
		)
	);
	
	redirectexit('action=admin;area=modules;sa=manageimagesadk;'.$context['session_var'].'='.$context['session_id']);

}
	
function savesettingsimagesadk()
{
	checkSession('post');
	
	//$enable = isset($_POST['enable']) ? 1 : 0;
	//$body = isset($_POST['body']) ? 1 : 0;
	//$title = CleanAdkStrings(stripslashes($_POST['title']));
	$cantidad = (int)$_POST['cantidad'];
	
	updateSettingsAdkPortal(
		array(
			'adv_top_image_limit' => $cantidad,
		)
	);
			
			
	global $context;
	redirectexit('action=admin;area=modules;sa=manageimagesadk;'.$context['session_var'].'='.$context['session_id']);

}

function ContactAdmin()
{
	global $smcFunc, $context, $txt;
	
	//CheckSession
	checkSession('get');
	
	//Calling groups
	$sql = $smcFunc['db_query']('','
		SELECT id_group, group_name
		FROM {db_prefix}membergroups
		WHERE min_posts = {int:posts} AND id_group <> {int:admin} AND id_group <> {int:moderator}',
		array(
			'posts' => -1,
			'admin' => 1,
			'moderator' => 3,
		)
	);
	
	$context['groups'] = array();
	
	while($row = $smcFunc['db_fetch_assoc']($sql))
		$context['groups'][$row['id_group']] = $row['group_name'];
	
	$smcFunc['db_free_result']($sql);
	
	//Adding guests and regulars users
	$context['groups'] += array(
		-1 => $txt['adk_d_guests'],
		0 => $txt['adk_d_regulars_users']
	);
	
	//order array
	ksort($context['groups']);
	
	$context['sub_template'] = 'contact_admin';
	$context['page_title'] = $txt['adk_contacto'];
}

function SaveContactAdmin()
{
	global $context;
	
	checkSession('post');
	
	$adk_enable_contact = !empty($_POST['adk_enable_contact']) ? 1 : 0;
	/*toview*/
	if(isset($_POST['toview']))
	{	
		$toview = array_keys($_POST['toview']);
		$toview = implode(',',$toview);
	}
	else
		$toview = '';
	
	updateSettingsAdkPortal(
		array(
			'adk_enable_contact' => $adk_enable_contact,
			'adk_groups_contact' => $toview,
		)
	);
	
	redirectexit('action=admin;area=modules;sa=contact;'.$context['session_var'].'='.$context['session_id']);
}
?>