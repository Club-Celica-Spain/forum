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

function ShowDownloads()
{
	global $context, $smcFunc, $txt, $boardurl, $modSettings, $adkportal;
	
	//Load your language or English Language
	if(loadLanguage('Adk-Admin') == false)
		loadLanguage('Adk-Admin','english');
	
	if($adkportal['download_enable'] == 0 && !allowedTo('adk_downloads_manage'))
		fatal_lang_error('adk_this_module_doesnt_exist',false);
	
	isAllowedTo('adk_downloads_view');
	
	
	$subActions = array(
		'index' => 'ShowIndexCategories',
		'view' => 'AdkViewDownload',
		'search' => 'AdkSearchDownloads',
		'search2' => 'AdkSearchDownloads2',
		'downfile' => 'AdkDownloadFile',
		'addnewfile' => 'AddaNewDownload',
		'addnewfile2' => 'AddaNewDownload2',
		'deletedownload' => 'DeleteDownload',
		'editdownload' => 'EditDownload',
		'unapprovedownload' => 'UnApproveDownload',
		'approvedownload' => 'ApproveDownload',
		'saveeditdownload' => 'EditSaveDownload',
		'viewstats' => 'AdkViewStats',
		'myprofile' => 'AdkViewMyProfile',
		'down' => 'DownCat',
		'up' => 'UpCat',
	);
	
	$context['html_headers'] .= '<link rel="stylesheet" type="text/css" href="'.$boardurl.'/adkportal/css/download_system.css" />';
	
	//Load Template
	loadTemplate('Adk-Downloads');
	
	
	
	if (!empty($_GET['sa']) && !empty($subActions[$_GET['sa']]))
		$subActions[@$_GET['sa']]();
	elseif(!empty($_REQUEST['cat']) && is_numeric($_REQUEST['cat']))
		ShowCatDownload((int)$_REQUEST['cat']);
	else
		$subActions['index']();
}

function UpCat()
{
	global $smcFunc, $scripturl, $context;
	
	if(!empty($_REQUEST['id']))
		$id = (int)$_REQUEST['id'];
	else
		fatal_lang_error('adk_require_catid',false);
	
	$sql = $smcFunc['db_query']('','
		SELECT roworder, id_parent FROM {db_prefix}adk_down_cat
		WHERE id_cat = {int:cat}',
		array(
			'cat' => $id,
		)
	);
	
	$row = $smcFunc['db_fetch_assoc']($sql);
	
	if(empty($row))
		fatal_lang_error('adk_require_catid',false);
		
	$smcFunc['db_free_result']($sql);
	
	//If this category is in the first position? idiot -.-
	if($row['roworder'] == 1){
		if($row['id_parent'] == 0)
			redirectexit('action=downloads');
		else
			redirectexit('action=downloads;cat='.$row['id_parent']);
	}
	
	//UPDATE - 1
	$smcFunc['db_query']('','
		UPDATE {db_prefix}adk_down_cat
		SET roworder = roworder - 1
		WHERE id_cat = {int:cat}',
		array(
			'cat' => $id,
		)
	);
	
	//Rest update + 1
	$smcFunc['db_query']('','
		UPDATE {db_prefix}adk_down_cat
		SET roworder = roworder + 1
		WHERE roworder = {int:row} AND id_cat <> {int:cat} AND id_parent = {int:parent}',
		array(
			'row' => $row['roworder'] - 1,
			'cat' => $id,
			'parent' => $row['id_parent'],
		)
	);
	
	if($row['id_parent'] == 0)
		redirectexit('action=downloads');
	else
		redirectexit('action=downloads;cat='.$row['id_parent']);
	
}

function DownCat()
{
	global $smcFunc, $scripturl, $context;
	
	if(!empty($_REQUEST['id']))
		$id = (int)$_REQUEST['id'];
	else
		fatal_lang_error('adk_require_catid',false);
	
	$sql = $smcFunc['db_query']('','
		SELECT roworder, id_parent FROM {db_prefix}adk_down_cat
		WHERE id_cat = {int:cat}',
		array(
			'cat' => $id,
		)
	);
	
	$row = $smcFunc['db_fetch_assoc']($sql);
	
	if(empty($row))
		fatal_lang_error('adk_require_catid',false);
		
	$smcFunc['db_free_result']($sql);
	
	//If this category is in the last position? idiot -.-
	$d = $smcFunc['db_query']('','
		SELECT id_cat 
		FROM {db_prefix}adk_down_cat
		WHERE roworder > {int:order}',
		array(
			'order' => $row['roworder'],
		)
	);
	
	$r = $smcFunc['db_fetch_assoc']($d);
	
	if(empty($r)){
		if($row['id_parent'] == 0)
			redirectexit('action=downloads');
		else
			redirectexit('action=downloads;cat='.$row['id_parent']);
	}
	
	
	//UPDATE + 1
	$smcFunc['db_query']('','
		UPDATE {db_prefix}adk_down_cat
		SET roworder = roworder + 1
		WHERE id_cat = {int:cat}',
		array(
			'cat' => $id,
		)
	);
	
	//Rest update - 1
	$smcFunc['db_query']('','
		UPDATE {db_prefix}adk_down_cat
		SET roworder = roworder - 1
		WHERE roworder = {int:row} AND id_cat <> {int:cat} AND id_parent = {int:parent}',
		array(
			'row' => $row['roworder'] + 1,
			'cat' => $id,
			'parent' => $row['id_parent'],
		)
	);
	
	if($row['id_parent'] == 0)
		redirectexit('action=downloads');
	else
		redirectexit('action=downloads;cat='.$row['id_parent']);
	
}	

function AdkSearchDownloads()
{
	global $context, $txt, $scripturl;
	
	$context['sub_template'] = 'adk_search';
	$context['page_title'] = $txt['adk_buscar'];
	
	$context['linktree'][] = array(
		'url' => $scripturl . '?action=downloads',
		'name' => $txt['adk_descargas_title']
	);
	
	$context['linktree'][] = array(
		'url' => $scripturl . '?action=downloads;sa=search',
		'name' => $txt['adk_buscar']
	);
	
}

function AdkSearchDownloads2()
{
	global $smcFunc, $txt, $context, $scripturl;
	
	checkSession('post');
	
	$context['linktree'][] = array(
		'url' => $scripturl . '?action=downloads',
		'name' => $txt['adk_descargas_title']
	);
	
	$context['linktree'][] = array(
		'url' => $scripturl . '?action=downloads;sa=search',
		'name' => $txt['adk_buscar']
	);
	
	$body = CleanAdkStrings($_POST['search']);
	
	$sql = $smcFunc['db_query']('','
		SELECT 
			d.id_file, d.title, d.id_member, m.id_member, m.real_name
			FROM {db_prefix}adk_down_file AS d
			LEFT JOIN {db_prefix}members AS m ON (m.id_member = d.id_member)
			WHERE (d.title LIKE "%'.$body.'%" OR d.description LIKE "%'.$body.'%")'
	);
	
	$context['downloads'] = array();
	
	while($row = $smcFunc['db_fetch_assoc']($sql)){
		$context['downloads'][] = array(
			'id' => $row['id_file'],
			'title' => $row['title'],
			'id_member' => $row['id_member'],
			'name' => $row['real_name'],
		);
	}
	
	$smcFunc['db_free_result']($sql);
	
	if(count($context['downloads']) == 1){
		foreach($context['downloads'] AS $id2)
			$id = $id2['id'];
		
		//redirect to the only download avaiable
		redirectexit('action=downloads;sa=view;down='.$id);
	}
	elseif(count($context['downloads']) == 0){
		$context['sub_template'] = 'adk_search_not';
		$context['page_title'] = $txt['adk_buscar'];
	}
	else{
		$context['sub_template'] = 'adk_search_results';
		$context['page_title'] = $txt['adk_buscar'].': '.$body;
	}
	
	
}
		
	

function ShowIndexCategories()
{
	global $context, $txt, $smcFunc,$user_info, $boardurl, $scripturl, $modSettings;
	
	if($context['user']['is_guest'])
		$id_group = -1;
	else
		$id_group = $user_info['groups'][0];
	
	
	//Update Link Tree
	$context['linktree'][] = array(
		'url' => $scripturl . '?action=downloads',
		'name' => $txt['adk_descargas_title']
	);
	
	$sql = $smcFunc['db_query']('','SELECT
		c.id_cat, c.title, c.description, c.roworder, c.image, p.view, c.total, c.id_parent
		FROM {db_prefix}adk_down_cat AS c
		LEFT JOIN {db_prefix}adk_down_permissions AS p ON (p.id_group = {int:g} AND c.ID_CAT = p.ID_CAT)
		ORDER BY c.roworder ASC',
		array(
			'g' => $id_group,
		)
	);
	
	$context['all_cat'] = array();
	$context['all_parent'] = array();
	
	$width = 30;
	
	while($row = $smcFunc['db_fetch_assoc']($sql))
	{	
		if($row['id_parent'] == 0){
			$context['all_cat'][$row['id_cat']] = array(
				'post' => array(),
				'id_cat' => $row['id_cat'],
				'title' => $row['title'],
				'description' => parse_bbc($row['description']),
				'roworder' => $row['roworder'],
				'image' => $row['image'],
				'view' => $row['view'],
				'total' => $row['total'],
			);
			
			//Return The Last Download ;)
			$context['all_cat'][$row['id_cat']]['post'] = PleaseCheckMyLastDownload($row['id_cat']);
		
			//For RewriteUrls
			$context['rewrite_adk']['cat'][$row['id_cat']] = $row['title'];
			$context['rewrite_adk']['download'][$context['all_cat'][$row['id_cat']]['post']['id']] = $context['all_cat'][$row['id_cat']]['post']['download'];
		}
		else{
			$context['all_parent'][$row['id_parent']][] = 
				'<a href="'.$scripturl.'?action=downloads;cat='.$row['id_cat'].'">'.$row['title'].'</a>'
			;
			
			//For RewriteUrls
			$context['rewrite_adk']['cat'][$row['id_cat']] = $row['title'];
		}
	}
	
	$smcFunc['db_free_result']($sql);
			
	//Important
	$context['unApprove'] = CountUnapproveDownloads();
	$context['last_downloads'] = LastTenDownloads();
	$context['downloads_popular'] = PopularViewDownloads();
	//$context['total_downloads'] = RandomDownload();
	
	
	//Load main trader template.
	$context['sub_template']  = 'main';

	//Set the page title
	$context['page_title'] = $txt['adk_descargas_title'];


}

function ShowCatDownload($id_cat)
{
	global $context, $txt, $smcFunc,$user_info, $boardurl, $scripturl, $modSettings;
	
	verifyCatPermissions('view',$id_cat);
	
	if(empty($id_cat))
		fatal_lang_error('adk_require_catid',false);
	
	if($context['user']['is_guest'])
		$id_group = -1;
	else
		$id_group = $user_info['groups'][0];
	
	//The First Link Tree
	$context['linktree'][] = array(
		'url' => $scripturl . '?action=downloads',
		'name' => $txt['adk_descargas_title']
	);
	
	$sql = $smcFunc['db_query']('','
		SELECT id_cat, title, roworder, description, image, orderby, sortby, id_parent
		FROM {db_prefix}adk_down_cat
		WHERE id_cat = {int:cat}',
		array(
			'cat' => $id_cat,
		)
	);
	
	$row = $smcFunc['db_fetch_assoc']($sql);
	
	//Cat Info
	$context['adk_download_title'] = $row['title'];
	$context['adk_download_roworder'] = $row['roworder'];
	$context['adk_download_description'] = $row['description'];
	$context['adk_download_image'] = $row['image'];
	$context['adk_download_idparent'] = $row['id_parent'];
	$sortby = !empty($row['sortby']) ? $row['sortby'] : 'date';
	$orderby = !empty($row['orderby']) ? $row['orderby'] : 'ASC';
	$context['cat_id'] = $id_cat;
	//End Cat Info
	
	$smcFunc['db_free_result']($sql);
	
	//Link Tree if the cat is parent
	CheckCatParent($context['adk_download_idparent']);
	
	//The Final LinkTree
	$context['linktree'][] = array(
		'url' => $scripturl . '?action=downloads;cat=' . $id_cat ,
		'name' => $context['adk_download_title']
	);
	
	$sql = $smcFunc['db_query']('','
		SELECT total
		FROM {db_prefix}adk_down_cat
		WHERE id_cat = {int:cat}',
		array(
			'cat' => $id_cat,
		)
	);
	
	$row = $smcFunc['db_fetch_assoc']($sql);
	$smcFunc['db_free_result']($sql);
	
	$context['totalfiles'] = $row['total'];
	
	$context['start'] = (int) $_REQUEST['start'];
	
	
	//List Sub Categories
	$sql = $smcFunc['db_query']('','SELECT
		c.id_cat, c.title, c.description, c.roworder, c.image, p.view, c.total
		FROM {db_prefix}adk_down_cat AS c
		LEFT JOIN {db_prefix}adk_down_permissions AS p ON (p.id_group = {int:g} AND c.ID_CAT = p.ID_CAT)
		WHERE c.id_parent = {int:p} ORDER BY c.roworder ASC',
		array(
			'g' => $id_group,
			'p' => $id_cat,
		)
	);
	
	$context['all_cat'] = array();
	
	while($row = $smcFunc['db_fetch_assoc']($sql))
	{
		$context['all_cat'][$row['id_cat']] = array(
			'post' => array(),
			'id_cat' => $row['id_cat'],
			'title' => $row['title'],
			'description' => parse_bbc($row['description']),
			'roworder' => $row['roworder'],
			'image' => $row['image'],
			'view' => $row['view'],
			'total' => $row['total'],
		);
		
		//Last Download
		$context['all_cat'][$row['id_cat']]['post'] = PleaseCheckMyLastDownload($row['id_cat']);
		
		//For RewriteUrls
		$context['rewrite_adk']['cat'][$row['id_cat']] = $row['title'];
	}
	
	//if(empty($context['all_cat']))
		//fatal_lang_error('adk_require_catid',false);
	
	$smcFunc['db_free_result']($sql);
	//End List
	global $adkportal;
	
	//11/11/2010
	if($sortby == 'mostview')
		$sortby = 'views';
	elseif($sortby == 'mostdowns')
		$sortby = 'totaldownloads';
	
	$sortby = 'd.'.$sortby;
	
	$limit = $adkportal['download_set_files_per_page'];
	$start = $context['start'];
	
	//List all files ;)
	$sql = $smcFunc['db_query']('',"
		SELECT d.id_file, d.id_member, d.date, d.approved, d.title, d.description, d.views, d.totaldownloads, d.main_image,
		m.id_member, m.real_name
		FROM {db_prefix}adk_down_file AS d
		LEFT JOIN {db_prefix}members AS m ON (m.id_member = d.id_member)
		WHERE d.id_cat = {int:cat}
		ORDER BY $sortby $orderby
		LIMIT {int:start}, {int:limit}",
		array(
			'cat' => $id_cat,
			'start' => $start,
			'limit' => $limit,
		)
	);
	
	$context['listFiles'] = array();
	while($row = $smcFunc['db_fetch_assoc']($sql))
	{
		$context['listFiles'][] = array(
			'id_member' => $row['id_member'],
			'member' => '<a href="'.$scripturl.'?action=profile;u='.$row['id_member'].'">'.$row['real_name'].'</a>',
			'file' => '<a style="font-weight: bold;" href="'.$scripturl.'?action=downloads;sa=view;down='.$row['id_file'].'">'.$row['title'].'</a>',
			'id_file' => $row['id_file'],
			'date' => timeformat($row['date']),
			'description' => parse_bbc($row['description']),
			'views' => $row['views'],
			'total' => $row['totaldownloads'],
			'image' => $row['main_image'],
			'title' => $row['title'],
			'approved' => $row['approved'],
		);
	}
	
	$smcFunc['db_free_result']($sql);
	
	//Important
	$context['last_downloads'] = LastTenDownloads(4);
	$context['downloads_popular'] = PopularViewDownloads(4);
	
	$context['page_index'] = constructPageIndex($scripturl . '?action=downloads;cat=' . $id_cat, $context['start'], $context['totalfiles'], $limit);
	
	//Load main trader template.
	$context['sub_template']  = 'view_download_files';

	//Set the page title
	$context['page_title'] = $context['adk_download_title'].' - '.$txt['adk_descargas_title'];


}

function AdkViewMyProfile()
{
	global $context, $scripturl, $smcFunc, $txt, $user_info, $modSettings;
	
	if(!empty($_REQUEST['u']))
		$id = (int)$_REQUEST['u'];
	else
		$id = $user_info['id'];
	
	if(empty($id))
		fatal_lang_error('adk_empty_id_profile',false);
	

	//The First Link Tree
	$context['linktree'][] = array(
		'url' => $scripturl . '?action=downloads',
		'name' => $txt['adk_descargas_title']
	);
	
	$context['start'] = (int) $_REQUEST['start'];
	
	//List all files ;)
	$sql = $smcFunc['db_query']('',"
		SELECT d.id_file, d.id_member, d.date, d.approved, d.title, d.description, d.views, d.totaldownloads, d.main_image,
		m.id_member, m.real_name
		FROM {db_prefix}adk_down_file AS d
		LEFT JOIN {db_prefix}members AS m ON (m.id_member = d.id_member)
		WHERE	d.id_member = {int:m}
		ORDER BY d.id_file DESC
		",
		array(
			'm' => $id,
		)
	);
	
	$context['listFiles'] = array();
	while($row = $smcFunc['db_fetch_assoc']($sql))
	{
		$context['listFiles'][] = array(
			'id_member' => $row['id_member'],
			'member' => '<a href="'.$scripturl.'?action=profile;u='.$row['id_member'].'">'.$row['real_name'].'</a>',
			'file' => '<a href="'.$scripturl.'?action=downloads;sa=view;down='.$row['id_file'].'">'.$row['title'].'</a>',
			'id_file' => $row['id_file'],
			'date' => timeformat($row['date']),
			'description' => parse_bbc($row['description']),
			'views' => $row['views'],
			'total' => $row['totaldownloads'],
			'image' => $row['main_image'],
			'title' => $row['title'],
			'approved' => $row['approved'],
		);
		
		$context['the_real_name'] = $row['real_name'];
	}
	$smcFunc['db_free_result']($sql);
	
	if(empty($context['listFiles']))
		fatal_lang_error('adk_user_not_have_nadanose',false);
	
	$context['sub_template'] = 'download_my_profile';
	$context['page_title'] = $txt['adk_profile'].' '.$context['the_real_name'];
	
	//The First Link Tree
	$context['linktree'][] = array(
		'url' => $scripturl . '?action=downloads;sa=myprofile;u='.$id,
		'name' => $context['the_real_name']
	);
	
}

function AddaNewDownload()
{
	global $smcFunc, $context, $user_info, $txt, $modSettings, $sourcedir;
	
	isAllowedTo('adk_downloads_add');
	
	if(!empty($_REQUEST['category']) && is_numeric($_REQUEST['category']))
		$id_cat = (int)$_REQUEST['category'];
	else
		fatal_lang_error('adk_please_select_cat',false);
	
	$context['id_cat_'] = $id_cat;
	
	verifyCatPermissions('addfile',$id_cat);
	
	if($context['user']['is_guest'])
		falta_lang_error('adk_guest_not_add_',false);
	
	$sql = $smcFunc['db_query']('','
		SELECT title FROM {db_prefix}adk_down_cat
		WHERE id_cat = {int:cat}',
		array(
			'cat' => $id_cat,
		)
	);
	
	$row = $smcFunc['db_fetch_assoc']($sql);
	$context['cat_title'] = $row['title'];
	
	if(empty($context['cat_title']))
		fatal_lang_error('adk_this_category_not_exist',false);
	
	
	
	
	//$smcFunc['db_free_result']($sql);
	
	//Load Important Info
	$context['sub_template'] = 'add_a_new_download';
	$context['page_title'] = $txt['adk_add_newdownload'].' '.$context['cat_title'];
	//End
	
	// Needed for the WYSIWYG editor.
	require_once($sourcedir . '/Subs-Editor.php');

	// Now create the editor.
	$editorOptions = array(
		'id' => 'descript',
		'value' => '',
		'width' => '90%',
		'form' => 'picform',
		'labels' => array(
			'post_button' => '',
		),
	);
	create_control_richedit($editorOptions);
	$context['post_box_name'] = $editorOptions['id'];
}


function AddaNewDownload2()
{
	global $modSettings, $sourcedir, $smcFunc, $context, $user_info, $boarddir, $scripturl, $txt, $boardurl;
	
	//Security
	isAllowedTo('adk_downloads_add');
	checkSession('post');
	
	if($context['user']['is_guest'])
		falta_lang_error('adk_guest_not_add_',false);
	//End Security
	
	if (!empty($_REQUEST['descript_mode']) && isset($_REQUEST['descript']))
	{
		require_once($sourcedir . '/Subs-Editor.php');

		$_REQUEST['descript'] = html_to_bbc($_REQUEST['descript']);

		// We need to unhtml it now as it gets done shortly.
		$_REQUEST['descript'] = un_CleanAdkStrings($_REQUEST['descript']);

	}		
	
	
	$title = CleanAdkStrings($_POST['title']);
	$description = CleanAdkStrings($_REQUEST['descript']);
	$image = '';
	
	
	
	
	if (!empty($_FILES['screen']['name']) && $_FILES['screen']['name'] != '')
	{
		$sizes = @getimagesize($_FILES['screen']['tmp_name']);
		if ($sizes === false)
			fatal_lang_error('adk_invalid_picture',false);
			
		global $sourcedir;
		require_once($sourcedir . '/Subs-Graphics.php');
		
		$extensions = array(1 => 'gif',2 => 'jpeg',3 => 'png',5 => 'psd',6 => 'bmp',7 => 'tiff',8 => 'tiff',9 => 'jpeg',14 => 'iff',);
		$extension = isset($extensions[$sizes[2]]) ? $extensions[$sizes[2]] : '.bmp';
			
				
		$image2 = $boarddir.'/Adk-downloads/'.$_FILES['screen']['name'] . '.' . $extension;
		global $boardurl;
		$image = $boardurl.'/Adk-downloads/'.$_FILES['screen']['name'] . '.' . $extension;
		
		move_uploaded_file($_FILES['screen']['tmp_name'], $image2);
		
		//Thumb...make me
		if(check_if_gd())
			load_AvdImage('', $image2, $extension, 6, $image2);
	}
	
	//Continue ;)
	$time = time();
	$id_member = $user_info['id'];
	$id_cat = (int)$_POST['id_cat'];
	//$size = 0;
	verifyCatPermissions('addfile',$id_cat);
	
	$DownloadsDir = $boarddir.'/Adk-downloads';
	
	if(!is_writable($DownloadsDir))
		fatal_lang_error('adk_not_writable_dir',false);
	
	$approved = (allowedTo('adk_downloads_autoapprove') ? 1 : 0);
	
	if(empty($title))
		fatal_lang_error('adk_please_add_a_title',false);
	
	//Category Info
	$sql = $smcFunc['db_query']('','
		SELECT id_board, locktopic
		FROM {db_prefix}adk_down_cat
		WHERE id_cat = {int:cat}',
		array(
			'cat' => $id_cat,
		)
	);
	$row = $smcFunc['db_fetch_assoc']($sql);
	
	$id_board = $row['id_board'];
	$locktopic = $row['locktopic'];
	$smcFunc['db_free_result']($sql);
	//End Load Info
	global $adkportal;
	if(!empty($_FILES['download']) && $_FILES['download']['name'] != '')
	{	
		$l = 0;
		foreach ($_FILES['download']['tmp_name'] as $n => $dummy)
		{
			if($_FILES['download']['name'][$n] != '')
				$l++;
			
			$filesize = $_FILES['download']['size'][$n];
			
			if (!empty($adkportal['download_max_filesize']) && $filesize > $adkportal['download_max_filesize'])
			{
				@unlink($_FILES['download']['tmp_name'][$n]);
				fatal_lang_error('adk_tamano_archivo_grande',false);
			}
		}
		
		if(empty($l))
			fatal_lang_error('adk_empty_attach',false);
		
		$smcFunc['db_query']('',"
			INSERT INTO {db_prefix}adk_down_file
			(id_member,date,title,description,id_cat,main_image,approved)
			VALUES
			('$id_member','$time','$title','$description','$id_cat','$image','$approved')"
		);
		
		$last_id = 0;
		$last_id = $smcFunc['db_insert_id']("{db_prefix}adk_down_file");
		
		$i = 0;
		foreach ($_FILES['download']['tmp_name'] as $n => $dummy)
		{
			
			$filesize = $_FILES['download']['size'][$n];
			$original =  $_FILES['download']['name'][$n];
			
			
			//Nosotros usamos el Download System en Smf Personal, entonces... necesitamos el mismo nombre de archivo ;)
			$filename = $user_info['id'] . '_' . date('d_m_y_g_i_s').$i;
			$i++;
			
			move_uploaded_file($_FILES['download']['tmp_name'][$n], $DownloadsDir .'/'.  $filename);
			@chmod($DownloadsDir .  $filename, 0644);
			
			$smcFunc['db_query']('',"
				INSERT INTO {db_prefix}adk_down_attachs
				(id_file,filename,filesize,orginalfilename)
				VALUES
				('$last_id','$filename','$filesize','$original')"
			);
		}
		
		global $sourcedir;
		require_once($sourcedir . '/Subs-Post.php');
		if(!empty($id_board) && !empty($approved))
		{
			$link_to_download = '[img]'.$boardurl.'/adkportal/images/download_box.png[/img][url='.$scripturl.'?action=downloads;sa=view;down='.$last_id.'][b]'.$txt['adk_link_download'].'[/b][/url]';
			$msgOptions = array(
				'id' => 0,
				'subject' => $title,
				'body' => "$link_to_download\n\n\n" . $description,
				'icon' => 'xx',
				'smileys_enabled' => 1,
				'attachments' => array(),
			);
			$topicOptions = array(
				'id' => 0,
				'board' => $id_board,
				'poll' => null,
				'lock_mode' => $locktopic,
				'sticky_mode' => null,
				'mark_as_read' => true,
			);
			$posterOptions = array(
				'id' => $id_member,
				'update_post_count' => !$user_info['is_guest'] && !isset($_REQUEST['msg']),
			);
	
			preparsecode($msgOptions['body']);
			createPost($msgOptions, $topicOptions, $posterOptions);
	
			$id_topic = $topicOptions['id'];
			
			$smcFunc['db_query']('',"
				UPDATE {db_prefix}adk_down_file
				SET id_topic = {int:topic}
				WHERE id_file = {int:file}",
				array(
					'topic' => $id_topic,
					'file' => $last_id,
				)
			);
		}
				
		TotalCategoryUpdate($id_cat);

	}
	
	redirectexit('action=downloads;sa=myprofile;u='.$id_member);
}

function AdkViewDownload()
{
	global $sourcedir, $txt, $modSettings, $context, $user_info, $scripturl, $smcFunc, $boardurl;
	
	if(!empty($_REQUEST['down']) && is_numeric($_REQUEST['down']))
		$id_view = (int)$_REQUEST['down'];
	else
		fatal_lang_error('adk_require_id_file',false);
	
	$sql = $smcFunc['db_query']('','
		SELECT
		p.id_file, p.id_cat, 
	 	p.approved, p.views, p.title, p.id_member, m.real_name, p.date, p.description, p.main_image, p.id_topic,
	   	c.title AS CAT_TITLE, c.id_parent, p.totaldownloads,  p.lastdownload, m.avatar,
			IFNULL(a.id_attach, 0) AS id_attach, a.filename, a.attachment_type
		FROM ({db_prefix}adk_down_file as p,  {db_prefix}adk_down_cat AS c)
		LEFT JOIN {db_prefix}members AS m ON  (p.id_member = m.id_member)
		LEFT JOIN {db_prefix}attachments AS a ON (a.id_member = m.id_member)
		WHERE p.id_file = {int:id} AND p.id_cat = c.id_cat LIMIT 1',
		array(
			'id' => $id_view,
		)
	);
	
	//Load My Beauti JS.
	$context['html_headers'] .= '
	<script type="text/javascript" src="'.$boardurl.'/adkportal/js/download_system.js"></script>
	<script type="text/javascript" src="'.$boardurl.'/adkportal/js/jquery.js"></script>';
	
	
	if($smcFunc['db_affected_rows']()== 0)
		fatal_lang_error('adk_this_download_not_exist',false);
	
	$row = $smcFunc['db_fetch_assoc']($sql);
	$smcFunc['db_free_result']($sql);
	
	//Security
	verifyCatPermissions('view',$row['id_cat']);
	if($row['approved'] == 0 && $user_info['id'] != $row['id_member'] && !allowedTo('adk_downloads_manage'))
		fatal_lang_error('adk_this_download_not_approved',false);
	
	//$height and width
	$width = 75;
	$height = 75;
	
	
	$context['adkDownloadInformation'] = array(
		'id_file' => $row['id_file'],
		'id_cat' => $row['id_cat'],
		'views' => $row['views'],
		'file_title' => $row['title'],
		'id_member' => $row['id_member'],
		'member' => '<a href="'.$scripturl.'?action=profile;u='.$row['id_member'].'">'.$row['real_name'].'</a>',
		'date' => timeformat($row['date']),
		'description' => parse_bbc($row['description']),
		'cat' => '<a href="'.$scripturl.'?action=downloads;cat='.$row['id_cat'].'">'.$row['CAT_TITLE'].'</a>',
		'id_parent' => $row['id_parent'],
		'totaldownloads' => $row['totaldownloads'],
		'lastdownload' => timeformat($row['lastdownload']),
		'approved' => $row['approved'],
		'image' => $row['main_image'],
		'id_topic' => $row['id_topic'],
		'avatar' => $row['avatar'] == '' ? ($row['id_attach'] > 0 ? '<img title="'.$row['real_name'].'" style="vertical-align: middle;" width="'.$width.'" height="'.$height.'" src="' . (empty($row['attachment_type']) ? $scripturl . '?action=dlattach;attach=' . $row['id_attach'] . ';type=avatar' : $modSettings['custom_avatar_url'] . '/' . $row['filename']) . '" alt="" border="0" />' : '') : (stristr($row['avatar'], 'http://') ? '<img title="'.$row['real_name'].'" style="vertical-align: middle;" width="'.$width.'" height="'.$height.'"src="' . $row['avatar'] . '" alt="" border="0" />' : '<img title="'.$row['real_name'].'" style="vertical-align: middle;" width="'.$width.'" height="'.$height.'"src="' . $modSettings['avatar_url'] . '/' . $smcFunc['htmlspecialchars']($row['avatar']) . '" alt="" border="0" />'),
	);
	
	$context['linktree'][] = array(
		'url' => $scripturl . '?action=downloads',
		'name' => $txt['adk_total_descargas']
	);
	
	CheckCatParent($row['id_parent']);
	
	$context['linktree'][] = array(
		'url' => $scripturl . '?action=downloads;cat=' . $row['id_cat'],
		'name' => $row['CAT_TITLE']
	);
	
	$context['linktree'][] = array(
		'url' => $scripturl . '?action=downloads;sa=view;down=' . $row['id_file'],
		'name' => $row['title']
	);
	
	$context['sub_template']  = 'adk_view_file';
	$context['page_title'] = $row['title'];
	
	//Views + 1
	$smcFunc['db_query']('', "UPDATE {db_prefix}adk_down_file
		SET views = views + 1 WHERE id_file = {int:id} LIMIT 1",
		array(
			'id' => $id_view,
		)
	);
		
	
	//Load Attachments
	$a = $smcFunc['db_query']('','
		SELECT id_attach, filesize, orginalfilename
		FROM {db_prefix}adk_down_attachs
		WHERE id_file = {int:file}',
		array(
			'file' => $id_view,
		)
	);
	
	$context['load_attachments'] = array();
	while($row2 = $smcFunc['db_fetch_assoc']($a))
		$context['load_attachments'][] = '<img class="adk_vertical" src="'.$boardurl.'/adkportal/images/drive_add.png" alt="" />&nbsp;<a href="'.$scripturl.'?action=downloads;sa=downfile;id='.$row2['id_attach'].'">'.$row2['orginalfilename'].'</a> <span class="smalltext">('.format_size($row2['filesize']).')</span>';
	
	$smcFunc['db_free_result']($a);
	
	//Please, load all info member.
	loadMemberData($context['adkDownloadInformation']['id_member'], false, 'profile');
	loadMemberContext($context['adkDownloadInformation']['id_member']);
	
	global $memberContext;
	//Finaly, make my context string ;)
	$context['member'] = $memberContext[$context['adkDownloadInformation']['id_member']];
	
}

function AdkDownloadFile()
{
	global $modSettings, $txt, $context, $smcFunc, $user_info, $boarddir;

	if(!empty($_REQUEST['id']))
		$id = (int)$_REQUEST['id'];
	else
		fatal_lang_error('adk_require_id_file',false);
	
	$sql = $smcFunc['db_query']('','
		SELECT a.id_file, a.id_attach, a.filename, a.orginalfilename, d.id_cat, d.id_file, d.id_member, d.approved
		FROM {db_prefix}adk_down_attachs AS a, {db_prefix}adk_down_file AS d
		INNER JOIN {db_prefix}members AS m ON (m.id_member = d.id_member)
		WHERE id_attach = {int:a} AND a.id_file = d.id_file',
		array(
			'a' => $id,
		)
	);
	
	$row = $smcFunc['db_fetch_assoc']($sql);
	$smcFunc['db_free_result']($sql);
	
	if($row['approved'] == 0 && $user_info['id'] != $row['id_member'] && !allowedTo('adk_downloads_manage'))
		fatal_lang_error('adk_this_download_not_approved',false);
	
	verifyCatPermissions('view',$row['id_cat']);
	
	$last = time();
	
	
	$smcFunc['db_query']('', "UPDATE {db_prefix}adk_down_file
		SET totaldownloads = totaldownloads + 1, lastdownload = {int:l} WHERE id_file = {int:id} LIMIT 1",
		array(
			'id' => $row['id_file'],
			'l' => $last,
		)
	);

		
	$real_filename = $row['orginalfilename'];
	$filename = $boarddir.'/Adk-downloads/'.$row['filename'];
	
	$ext = explode('.',$real_filename);
	$file_ext = $ext[count($ext) -1];
	
	// This is done to clear any output that was made before now. (would use ob_clean(), but that's PHP 4.2.0+...)
	ob_end_clean();
	if (!empty($modSettings['enableCompressedOutput']) && @version_compare(PHP_VERSION, '4.2.0') >= 0 && @filesize($filename) <= 4194304 && in_array($file_ext, array('txt', 'html', 'htm', 'js', 'doc', 'pdf', 'docx', 'rtf', 'css', 'php', 'log', 'xml', 'sql', 'c', 'java')))
		@ob_start('ob_gzhandler');
	else
	{
		ob_start();
		header('Content-Encoding: none');
	}

	// No point in a nicer message, because this is supposed to be an attachment anyway...
	if (!file_exists($filename))
	{
		loadLanguage('Errors');

		header('HTTP/1.0 404 ' . $txt['attachment_not_found']);
		header('Content-Type: text/plain; charset=' . (empty($context['character_set']) ? 'ISO-8859-1' : $context['character_set']));

		// We need to die like this *before* we send any anti-caching headers as below.
		die('404 - ' . $txt['attachment_not_found']);
	}

	// If it hasn't been modified since the last time this attachement was retrieved, there's no need to display it again.
	if (!empty($_SERVER['HTTP_IF_MODIFIED_SINCE']))
	{
		list($modified_since) = explode(';', $_SERVER['HTTP_IF_MODIFIED_SINCE']);
		if (strtotime($modified_since) >= filemtime($filename))
		{
			ob_end_clean();

			// Answer the question - no, it hasn't been modified ;).
			header('HTTP/1.1 304 Not Modified');
			exit;
		}
	}

	// Check whether the ETag was sent back, and cache based on that...
	$eTag = '"' . substr($_REQUEST['id'] . $real_filename . filemtime($filename), 0, 64) . '"';
	if (!empty($_SERVER['HTTP_IF_NONE_MATCH']) && strpos($_SERVER['HTTP_IF_NONE_MATCH'], $eTag) !== false)
	{
		ob_end_clean();

		header('HTTP/1.1 304 Not Modified');
		exit;
	}

	// Send the attachment headers.
	header('Pragma: ');
	if (!$context['browser']['is_gecko'])
		header('Content-Transfer-Encoding: binary');
	header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 525600 * 60) . ' GMT');
	header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($filename)) . ' GMT');
	header('Accept-Ranges: bytes');
	header('Connection: close');
	header('ETag: ' . $eTag);

	// IE 6 just doesn't play nice. As dirty as this seems, it works.
	if ($context['browser']['is_ie6'] && isset($_REQUEST['image']))
		unset($_REQUEST['image']);
		
	// Make sure the mime type warrants an inline display.
	elseif (isset($_REQUEST['image']) && !empty($mime_type) && strpos($mime_type, 'image/') !== 0)
		unset($_REQUEST['image']);
	
	// Does this have a mime type?
	elseif (!empty($mime_type) && (isset($_REQUEST['image']) || !in_array($file_ext, array('jpg', 'gif', 'jpeg', 'x-ms-bmp', 'png', 'psd', 'tiff', 'iff'))))
		header('Content-Type: ' . strtr($mime_type, array('image/bmp' => 'image/x-ms-bmp')));
		
	else
	{
		header('Content-Type: ' . ($context['browser']['is_ie'] || $context['browser']['is_opera'] ? 'application/octetstream' : 'application/octet-stream'));
		if (isset($_REQUEST['image']))
			unset($_REQUEST['image']);
	}

	// Convert the file to UTF-8, cuz most browsers dig that.
	$utf8name = !$context['utf8'] && function_exists('iconv') ? iconv($context['character_set'], 'UTF-8', $real_filename) : (!$context['utf8'] && function_exists('mb_convert_encoding') ? mb_convert_encoding($real_filename, 'UTF-8', $context['character_set']) : $real_filename);
	$fixchar = create_function('$n', '
		if ($n < 32)
			return \'\';
		elseif ($n < 128)
			return chr($n);
		elseif ($n < 2048)
			return chr(192 | $n >> 6) . chr(128 | $n & 63);
		elseif ($n < 65536)
			return chr(224 | $n >> 12) . chr(128 | $n >> 6 & 63) . chr(128 | $n & 63);
		else
			return chr(240 | $n >> 18) . chr(128 | $n >> 12 & 63) . chr(128 | $n >> 6 & 63) . chr(128 | $n & 63);');

	$disposition = !isset($_REQUEST['image']) ? 'attachment' : 'inline' ;

	// Different browsers like different standards...
	if ($context['browser']['is_firefox'])
		header('Content-Disposition: ' . $disposition . '; filename*="UTF-8\'\'' . preg_replace('~&#(\d{3,8});~e', '$fixchar(\'$1\')', $utf8name) . '"');

	elseif ($context['browser']['is_opera'])
		header('Content-Disposition: ' . $disposition . '; filename="' . preg_replace('~&#(\d{3,8});~e', '$fixchar(\'$1\')', $utf8name) . '"');

	elseif ($context['browser']['is_ie'])
		header('Content-Disposition: ' . $disposition . '; filename="' . urlencode(preg_replace('~&#(\d{3,8});~e', '$fixchar(\'$1\')', $utf8name)) . '"');

	else
		header('Content-Disposition: ' . $disposition . '; filename="' . $utf8name . '"');

	// If this has an "image extension" - but isn't actually an image - then ensure it isn't cached cause of silly IE.
	if (!isset($_REQUEST['image']) && in_array($file_ext, array('gif', 'jpg', 'bmp', 'png', 'jpeg', 'tiff')))
		header('Cache-Control: no-cache');
	else
		header('Cache-Control: max-age=' . (525600 * 60) . ', private');

	if (empty($modSettings['enableCompressedOutput']) || filesize($filename) > 4194304)
		header('Content-Length: ' . filesize($filename));

	// Try to buy some time...
	@set_time_limit(600);

	// Recode line endings for text files, if enabled.
	if (!empty($modSettings['attachmentRecodeLineEndings']) && !isset($_REQUEST['image']) && in_array($file_ext, array('txt', 'css', 'htm', 'html', 'php', 'xml')))
	{
		if (strpos($_SERVER['HTTP_USER_AGENT'], 'Windows') !== false)
			$callback = create_function('$buffer', 'return preg_replace(\'~[\r]?\n~\', "\r\n", $buffer);');
		elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Mac') !== false)
			$callback = create_function('$buffer', 'return preg_replace(\'~[\r]?\n~\', "\r", $buffer);');
		else
			$callback = create_function('$buffer', 'return preg_replace(\'~[\r]?\n~\', "\n", $buffer);');
	}

	// Since we don't do output compression for files this large...
	if (filesize($filename) > 4194304)
	{
		// Forcibly end any output buffering going on.
		if (function_exists('ob_get_level'))
		{
			while (@ob_get_level() > 0)
				@ob_end_clean();
		}
		else
		{
			@ob_end_clean();
			@ob_end_clean();
			@ob_end_clean();
		}

		$fp = fopen($filename, 'rb');
		while (!feof($fp))
		{
			if (isset($callback))
				echo $callback(fread($fp, 8192));
			else
				echo fread($fp, 8192);
			flush();
		}
		fclose($fp);
	}
	// On some of the less-bright hosts, readfile() is disabled.  It's just a faster, more byte safe, version of what's in the if.
	elseif (isset($callback) || @readfile($filename) == null)
		echo isset($callback) ? $callback(file_get_contents($filename)) : file_get_contents($filename);

	obExit(false);
}


function DeleteDownload()
{
	global $boarddir, $user_info;
	
	checkSession('get');
	
	if(!empty($_REQUEST['id']) && is_numeric($_REQUEST['id']))
		$id = (int)$_REQUEST['id'];
	else
		fatal_lang_error('adk_require_id_file',false);
	
	global $smcFunc;
	
	$sql = $smcFunc['db_query']('','
		SELECT id_cat, id_member
		FROM {db_prefix}adk_down_file
		WHERE id_file = {int:file}',
		array(
			'file' => $id,
		)
	);
	
	$row = $smcFunc['db_fetch_assoc']($sql);
	$id_cat = $row['id_cat'];
	$smcFunc['db_free_result']($sql);
	
	if($user_info['id'] != $row['id_member'] && !allowedTo('adk_downloads_manage'))
		fatal_lang_error('adk_not_permission',false);
	
	$smcFunc['db_query']('','
		DELETE FROM {db_prefix}adk_down_file
		WHERE id_file = {int:file}',
		array(
			'file' => $id,
		)
	);
	
	$sql = $smcFunc['db_query']('','
		SELECT filename FROM {db_prefix}adk_down_attachs
		WHERE id_file = {int:file}',
		array(
			'file' => $id,
		)
	);
	
	while($row = $smcFunc['db_fetch_assoc']($sql))
	{
		@unlink($boarddir.'/Adk-downloads/'.$row['filename']);
	}
	
	$smcFunc['db_query']('','
		DELETE FROM {db_prefix}adk_down_attachs
		WHERE id_file = {int:file}',
		array(
			'file' => $id,
		)
	);
	
	TotalCategoryUpdate($id_cat);
	
	redirectexit('action=downloads;cat='.$id_cat);
}

function UnApproveDownload()
{
	global $smcFunc;
	
	isAllowedTo('adk_downloads_manage');
	
	checkSession('get');
	
	if(!empty($_REQUEST['id']) && is_numeric($_REQUEST['id']))
		$id = (int)$_REQUEST['id'];
	else
		fatal_lang_error('adk_require_id_file',false);
	
	$smcFunc['db_query']('','
		UPDATE {db_prefix}adk_down_file
		SET approved = {int:a}
		WHERE id_file = {int:file}',
		array(
			'a' => 0,
			'file' => $id,
		)
	);
	
	redirectexit('action=downloads;sa=view;down='.$id);
}

function ApproveDownload()
{
	global $smcFunc, $modSettings, $sourcedir, $txt, $context, $boardurl;
	
	isAllowedTo('adk_downloads_manage');
	
	checkSession('get');
	
	if(!empty($_REQUEST['id']) && is_numeric($_REQUEST['id']))
		$id = (int)$_REQUEST['id'];
	else
		fatal_lang_error('adk_require_id_file',false);
	
	$smcFunc['db_query']('','
		UPDATE {db_prefix}adk_down_file
		SET approved = {int:a}
		WHERE id_file = {int:file}',
		array(
			'a' => 1,
			'file' => $id,
		)
	);
	
	$s = $smcFunc['db_query']('','
		SELECT a.id_topic, c.id_board, c.locktopic, a.title, a.description, a.id_member, a.id_cat, c.id_cat
		FROM {db_prefix}adk_down_file AS a, {db_prefix}adk_down_cat AS c
		WHERE a.id_file = {int:file} AND a.id_cat = c.id_cat',
		array(
			'a' => 1,
			'file' => $id,
		)
	);
	
	$row = $smcFunc['db_fetch_assoc']($s);
	$smcFunc['db_free_result']($s);
	$id_board = $row['id_board'];
	$id_topic = $row['id_topic'];
	$locktopic = $row['locktopic'];
	$title = $row['title'];
	$id_cat = $row['id_cat'];
	$description = $row['description'];
	$id_member = $row['id_member'];
	
	TotalCategoryUpdate($id_cat);
	require_once($sourcedir . '/Subs-Post.php');
	
	if(!empty($id_board) && empty($id_topic))
	{
		$link_to_download = '[img]'.$boardurl.'/adkportal/images/download_box.png[/img][url='.$scripturl.'?action=downloads;sa=view;down='.$id.'][b]'.$txt['adk_link_download'].'[/b][/url]';
		$msgOptions = array(
			'id' => 0,
			'subject' => $title,
			'body' => "$link_to_download\n\n\n" . $description,
			'icon' => 'xx',
			'smileys_enabled' => 1,
			'attachments' => array(),
		);
		$topicOptions = array(
			'id' => 0,
			'board' => $id_board,
			'poll' => null,
			'lock_mode' => $locktopic,
			'sticky_mode' => null,
			'mark_as_read' => true,
		);
		$posterOptions = array(
			'id' => $id_member,
			'update_post_count' => !$user_info['is_guest'] && !isset($_REQUEST['msg']),
		);
				
		preparsecode($msgOptions['body']);
		createPost($msgOptions, $topicOptions, $posterOptions);
		
		$id_topic = $topicOptions['id'];
		
		$smcFunc['db_query']('',"
			UPDATE {db_prefix}adk_down_file
			SET id_topic = {int:topic}
			WHERE id_file = {int:file}",
			array(
				'topic' => $id_topic,
				'file' => $id,
			)
		);
	}
	
	global $adkportal;
	if(!empty($adkportal['download_enable_sendpmApprove']) && !empty($adkportal['download_sendpm_body']) &&!empty($adkportal['download_sendpm_userId']))
	{
	
		
					
		$select = $smcFunc['db_query']('','
			SELECT member_name, real_name 
			FROM {db_prefix}members 
			WHERE id_member = {int:member}',
			array(
				'member' => $adkportal['download_sendpm_userId'],
			)
		);
		$member = $smcFunc['db_fetch_assoc']($select);
		$smcFunc['db_free_result']($select);
		
		$from = array(
		'id' => $adkportal['download_sendpm_userId'],
		'name' => $member['real_name'],
		'username' => $member['member_name']
		);
		
		$select = $smcFunc['db_query']('','
			SELECT a.id_member, a.title, m.id_member, m.real_name, m.member_name
			FROM {db_prefix}members AS m, {db_prefix}adk_down_file AS a
			WHERE a.id_member = m.id_member AND a.id_file = {int:file}',
			array(
				'file' => $id,
			)
		);
		
		$member2 = $smcFunc['db_fetch_assoc']($select);
		$smcFunc['db_free_result']($select);
		
		
						
		$recs = array(
			'to' => array($member2['id_member']),
			'bcc' => array()
		);
		
		$subject = $member2['title'].' '.$txt['adk_send_pm_has'];
		$message = $adkportal['download_sendpm_body'];
					
						
		sendpm($recs, $subject, $message, false, $from);
	}
	
	if(!empty($_REQUEST['return']) && $_REQUEST['return'] == 'admin')
		redirectexit('action=admin;area=adkdownloads;sa=approvedownloads;'.$context['session_var'].'='.$context['session_id']);
	else
		redirectexit('action=downloads;sa=view;down='.$id);


}


function EditDownload()
{
	global $smcFunc, $context, $user_info, $txt, $modSettings, $sourcedir;
	
	checkSession('get');
	
	isAllowedTo('adk_downloads_add');
	
	if(!empty($_REQUEST['id']) && is_numeric($_REQUEST['id']))
		$id_file = (int)$_REQUEST['id'];
	else
		fatal_lang_error('adk_require_id_file',false);
	
	
	$sql = $smcFunc['db_query']('','
		SELECT a.title, a.description, a.id_cat, c.id_cat, c.title AS CAT_TITLE, a.main_image, a.id_member
		FROM {db_prefix}adk_down_file AS a, {db_prefix}adk_down_cat AS c
		WHERE c.id_cat = a.id_cat AND a.id_file = {int:file}',
		array(
			'file' => $id_file,
		)
	);
	
	if($smcFunc['db_affected_rows']()== 0)
		fatal_lang_error('adk_this_download_not_exist',false);
		
	$row = $smcFunc['db_fetch_assoc']($sql);
	$smcFunc['db_free_result']($sql);
	
	if($user_info['id'] != $row['id_member'] && !allowedTo('adk_downloads_manage'))
		fatal_lang_error('adk_not_permission',false);
	
	$sql2 = $smcFunc['db_query']('','
		SELECT id_attach, orginalfilename
		FROM {db_prefix}adk_down_attachs
		WHERE id_file = {int:file}',
		array(
			'file' => $id_file,
		)
	);
	
	$i = 0;
	while($row2 = $smcFunc['db_fetch_assoc']($sql2))
	{
		$context['load_attachs'][] = '<input type="checkbox" value="'.$row2['id_attach'].'" name="download2['.$row2['id_attach'].']" />&nbsp;'.$txt['adk_delete'].' - '.$row2['orginalfilename'];
		$i++;
	}
	$smcFunc['db_free_result']($sql2);
	
	//LoadAllCats
	if ($user_info['is_guest'])
		$id_group = -1;
	else
		$id_group =  $user_info['groups'][0];
	
	$sql3 = $smcFunc['db_query']('','
		SELECT c.id_cat, c.title, p.view, p.addfile
		FROM {db_prefix}adk_down_cat AS c
		LEFT JOIN {db_prefix}adk_down_permissions AS p ON (p.ID_GROUP = {int:group} AND c.id_cat = p.id_cat)',
		array(
			'group' => $id_group,
		)
	);
	
	$context['downloads_cat'] = array();
	while($row3 = $smcFunc['db_fetch_assoc']($sql3))
	{
		if ($row3['view'] == '0' || $row3['addfile'] == '0' )
			continue;
			
		$context['downloads_cat'][] = array(
			'id' => $row3['id_cat'],
			'title' => $row3['title'],
		);
	}
		
	$smcFunc['db_free_result']($sql3);
	
	$context['important_info'] = array(
		'id_cat' => $row['id_cat'],
		'description' => $row['description'],
		'title' => $row['title'],
		'image' => $row['main_image'],
		'id_file' => $id_file,
		'rest' => $i,
		'id_member' => $row['id_member'],
	);
	
	//Load Important Info
	$context['sub_template'] = 'edit_a_download';
	$context['page_title'] = $txt['adk_edit_general'].' '.$row['title'];
	//End
	
	// Needed for the WYSIWYG editor.
	require_once($sourcedir . '/Subs-Editor.php');

	// Now create the editor.
	$editorOptions = array(
		'id' => 'descript',
		'value' => $row['description'],
		'width' => '90%',
		'form' => 'picform',
		'labels' => array(
			'post_button' => '',
		),
	);
	create_control_richedit($editorOptions);
	$context['post_box_name'] = $editorOptions['id'];

}

function EditSaveDownload()
{
	global $modSettings, $sourcedir, $smcFunc, $context, $user_info, $boarddir, $scripturl, $txt;
	
	//Security
	isAllowedTo('adk_downloads_add');
	checkSession('post');
	
	if($context['user']['is_guest'])
		falta_lang_error('adk_guest_not_add_',false);
	//End Security
	
	if (!empty($_REQUEST['descript_mode']) && isset($_REQUEST['descript']))
	{
		require_once($sourcedir . '/Subs-Editor.php');

		$_REQUEST['descript'] = html_to_bbc($_REQUEST['descript']);

		// We need to unhtml it now as it gets done shortly.
		$_REQUEST['descript'] = un_CleanAdkStrings($_REQUEST['descript']);

	}
	
	if($user_info['id'] != (int)$_POST['id_member'] && !allowedTo('adk_downloads_manage'))
		fatal_lang_error('adk_not_permission',false);
	
	$title = CleanAdkStrings($_POST['title']);
	$description = CleanAdkStrings($_REQUEST['descript']);
	$image = !empty($_POST['screen2']) ? CleanAdkStrings($_POST['screen2']) : '';
	
	if (!empty($_FILES['screen']['name']) && $_FILES['screen']['name'] != '')
	{
		$sizes = @getimagesize($_FILES['screen']['tmp_name']);
		if ($sizes === false)
			fatal_lang_error('adk_invalid_picture',false);
			
		global $sourcedir;
		require_once($sourcedir . '/Subs-Graphics.php');
		
		$extensions = array(1 => 'gif',2 => 'jpeg',3 => 'png',5 => 'psd',6 => 'bmp',7 => 'tiff',8 => 'tiff',9 => 'jpeg',14 => 'iff',);
		$extension = isset($extensions[$sizes[2]]) ? $extensions[$sizes[2]] : '.bmp';
			
				
		$image2 = $boarddir.'/Adk-downloads/'.$_FILES['screen']['name'] . '.' . $extension;
		global $boardurl;
		$image = $boardurl.'/Adk-downloads/'.$_FILES['screen']['name'] . '.' . $extension;
		
		move_uploaded_file($_FILES['screen']['tmp_name'], $image2);
		
		//Thumb...make me
		if(check_if_gd())
			load_AvdImage('', $image2, $extension, 6, $image2);
	}
	
	$id_cat = (int)$_POST['cat'];	
	$ex_id_cat = (int)$_POST['ex_id_cat'];
	$id_file = (int)$_POST['id_file'];
	
	//verifyCatPermissions('addfile',$id_cat);
	
	$DownloadsDir = $boarddir.'/Adk-downloads';
	
	if(!is_writable($DownloadsDir))
		fatal_lang_error('adk_not_writable_dir',false);
		
	if(empty($title))
		fatal_lang_error('adk_please_add_a_title',false);
	
	$files = !empty($_POST['download2']) ? $_POST['download2'] : '';
	
	$files2 = !empty($_POST['download2']) ? 1 : 0;
	$download = !empty($_FILES['download']) ? 1 : 0;
	
	if(empty($download) && empty($files2))
		fatal_lang_error('adk_empty_attach',false);
	
	$smcFunc['db_query']('','
			UPDATE {db_prefix}adk_down_file
			SET title = {string:title}, description = {string:description},
			id_cat = {int:cat}, main_image = {string:image}
			WHERE id_file = {int:file}',
			array(
				'title' => $title,
				'description' => $description,
				'cat' => $id_cat,
				'image' => $image,
				'file' => $id_file,
			)
		);
	
	
	global $adkportal;
	if(!empty($_FILES['download']))
	{
		$i = 0;
		
		foreach ($_FILES['download']['tmp_name'] as $n => $dummy)
		{
			if($_FILES['download']['name'][$n] != '')
			{
			
				$filesize = $_FILES['download']['size'][$n];
				
				if (!empty($adkportal['download_max_filesize']) && $filesize > $adkportal['download_max_filesize'])
				{
					@unlink($_FILES['download']['tmp_name'][$n]);
					fatal_lang_error('adk_tamano_archivo_grande',false);
				}
			
				
				$filesize = $_FILES['download']['size'][$n];
				$original =  $_FILES['download']['name'][$n];
				
				
				//Nosotros usamos el Download System en Smf Personal, entonces... necesitamos el mismo nombre de archivo ;)
				
				$filename = $user_info['id'] . '_' . date('d_m_y_g_i_s').$i;
				$i++;
				
				move_uploaded_file($_FILES['download']['tmp_name'][$n], $DownloadsDir .'/'.  $filename);
				@chmod($DownloadsDir .  $filename, 0644);
				
				$smcFunc['db_query']('',"
					INSERT INTO {db_prefix}adk_down_attachs
					(id_file,filename,filesize,orginalfilename)
					VALUES
					('$id_file','$filename','$filesize','$original')"
				);
			}
		}
	}
	
	//DELETE files selected
	if(!empty($files))
	{
		$delete = $_POST['download2'];
		$t = 0;
		$count = count($delete); 
		
		foreach($delete AS $n => $dummy)
		{
			$id = $n;
			$sql = $smcFunc['db_query']('','
				SELECT filename FROM {db_prefix}adk_down_attachs
				WHERE id_attach = {int:attach} LIMIT 1',
				array(
					'attach' => $id,
				)
			);
			$row = $smcFunc['db_fetch_assoc']($sql);
			$smcFunc['db_free_result']($sql);
			@unlink($boarddir.'/Adk-downloads/'.$row['filename']);
			
			$smcFunc['db_query']('','
				DELETE FROM {db_prefix}adk_down_attachs
				WHERE id_attach = {int:attach} LIMIT 1',
				array(
					'attach' => $id,
				)
			);
			
			$t++;
		}
	}
	
	//Update Category
	if($id_cat !== $ex_id_cat) {
		TotalCategoryUpdate($id_cat);
		TotalCategoryUpdate($ex_id_cat);
	}
			
	redirectexit('action=downloads;sa=view;down='.$id_file);		
}

function AdkViewStats()
{
	global $smcFunc, $context, $txt, $scripturl;
	
	//Load Important Info
	$context['sub_template'] = 'view_stats';
	$context['page_title'] = $txt['adk_view_stats'];
	//End
	
	//Load Stats
	$context['last_downloads'] = LastTenDownloads();
	$context['most_downloads'] = MostDownloads();
	$context['uploaders'] = TopUploadersDownload();
	$context['most_viewed'] = MostViewed();
	
	//The First Link Tree
	$context['linktree'][] = array(
		'url' => $scripturl . '?action=downloads',
		'name' => $txt['adk_descargas_title']
	);
	
	//The First Link Tree
	$context['linktree'][] = array(
		'url' => $scripturl . '?action=downloads;sa=viewstats',
		'name' => $txt['adk_view_stats']
	);
	
}

function MostDownloads()
{
	global $smcFunc, $scripturl;
	
	$sql = $smcFunc['db_query']('','
		SELECT id_file, title, totaldownloads
		FROM {db_prefix}adk_down_file
		WHERE approved = {int:a}
		ORDER by totaldownloads DESC LIMIT 10',
		array(
			'a' => 1,
		)
	);
	
	$files = array();
	
	while($row = $smcFunc['db_fetch_assoc']($sql))
		$files[] = '<li><a href="'.$scripturl.'?action=downloads;sa=view;down='.$row['id_file'].'">'.$row['title'].'</a> ('.$row['totaldownloads'].')</li>';
	
	$smcFunc['db_free_result']($sql);
	
	return $files;

}

function MostViewed()
{
	global $smcFunc, $scripturl;
	
	$sql = $smcFunc['db_query']('','
		SELECT id_file, title, views
		FROM {db_prefix}adk_down_file
		WHERE approved = {int:a}
		ORDER by views DESC LIMIT 10',
		array(
			'a' => 1,
		)
	);
	
	$files = array();
	
	while($row = $smcFunc['db_fetch_assoc']($sql))
		$files[] = '<li><a href="'.$scripturl.'?action=downloads;sa=view;down='.$row['id_file'].'">'.$row['title'].'</a> ('.$row['views'].')</li>';
	
	$smcFunc['db_free_result']($sql);
	
	return $files;

}

function TopUploadersDownload()
{
	global $smcFunc, $scripturl;
	
	$sql = $smcFunc['db_query']('','
		SELECT a.id_file, a.title, a.id_member, m.id_member, m.real_name
		FROM {db_prefix}adk_down_file AS a, {db_prefix}members AS m
		WHERE approved = {int:a} AND m.id_member = a.id_member
		ORDER by COUNT(a.id_member) DESC LIMIT 10',
		array(
			'a' => 1,
		)
	);
	
	$files = array();
	
	while($row = $smcFunc['db_fetch_assoc']($sql))
		$files[] = '<li><a href="'.$scripturl.'?action=profile;u='.$row['id_member'].'">'.$row['real_name'].'</a></li>';
	
	$smcFunc['db_free_result']($sql);
	
	return $files;

}

function TotalCategoryUpdate($ID_CAT)
{
	global $smcFunc;
	
	$dbresult = $smcFunc['db_query']('','
		SELECT
		COUNT(*) AS total
		FROM {db_prefix}adk_down_file
		WHERE id_cat = {int:cat} AND approved = {int:a}',
		array(
			'cat' => $ID_CAT,
			'a' => 1,
		)
	);
	$row = $smcFunc['db_fetch_assoc']($dbresult);
	$total = $row['total'];
	$smcFunc['db_free_result']($dbresult);

	// Update the count
	$dbresult = $smcFunc['db_query']('','
		UPDATE {db_prefix}adk_down_cat 
		SET total = {int:t} WHERE id_cat = {int:cat} LIMIT 1',
		array(
			't' => $total,
			'cat' => $ID_CAT
		)
	);
}

function verifyCatPermissions($permission,$cat)
{
	global $user_info, $smcFunc;
	
	if(!$user_info['is_guest'])
		$sql = $smcFunc['db_query']('','
			SELECT
			m.id_member, c.view, c.addfile
			FROM {db_prefix}adk_down_permissions as c, {db_prefix}members as m
			WHERE m.id_member = {int:m} AND c.id_group = m.id_group AND c.ID_CAT = {int:cat} LIMIT 1',
			array(
				'm' => $user_info['id'],
				'cat' => $cat,
			)
		);
	else
		$sql = $smcFunc['db_query']('','
			SELECT
			c.view, c.addfile
			FROM {db_prefix}adk_down_permissions as c
			WHERE c.id_group = {int:m} AND c.ID_CAT = {int:cat} LIMIT 1',
			array(
				'm' => -1,
				'cat' => $cat,
			)
		);
	
	if($smcFunc['db_affected_rows']()== 0)
		$smcFunc['db_free_result']($sql);
	else
	{
		$row = $smcFunc['db_fetch_assoc']($sql);

		$smcFunc['db_free_result']($sql);
		
		if($permission == 'view' && $row['view'] == 0)
			fatal_lang_error('adk_cannot_view',false);
		if($permission == 'addfile' && $row['addfile'] == 0)
			fatal_lang_error('adk_cannot_addfile',false);
	}
}

function CheckCatParent($id_cat)
{
	global $smcFunc, $scripturl, $context;
	
	if($id_cat != 0)
	{
		$sql = $smcFunc['db_query']('','
			SELECT id_parent, title FROM {db_prefix}adk_down_cat
			WHERE id_cat = {int:cat}',
			array(
				'cat' => $id_cat,
			)
		);
		
		$row = $smcFunc['db_fetch_assoc']($sql);
		$smcFunc['db_free_result']($sql);
		
		
		CheckCatParent($row['id_parent']);
		
		$context['linktree'][] = array(
			'url' => $scripturl . '?action=downloads;cat=' . $id_cat ,
			'name' => $row['title']
		);
	}
}	
	
function LastTenDownloads($limit = 10)
{
	global $smcFunc, $scripturl;
	
	$sql = $smcFunc['db_query']('','
		SELECT id_file, title
		FROM {db_prefix}adk_down_file
		WHERE approved = {int:a}
		ORDER BY id_file DESC
		LIMIT '.$limit,
		array(
			'a' => 1
		)
	);
	
	$context['total_downloads'] = array();
	
	while($row = $smcFunc['db_fetch_assoc']($sql))
		$context['total_downloads'][] = '<li><a href="'.$scripturl.'?action=downloads;sa=view;down='.$row['id_file'].'">'.$row['title'].'</a></li>';
	
	$smcFunc['db_free_result']($sql);
	
	return $context['total_downloads'];

}

function RandomDownload()
{
	global $smcFunc, $scripturl;
	
	$sql = $smcFunc['db_query']('','
		SELECT d.id_file, d.title, d.description, d.id_member, m.id_member, m.real_name
		FROM {db_prefix}adk_down_file AS d, {db_prefix}members AS m
		WHERE approved = {int:a} AND d.id_member = m.id_member
		ORDER BY RAND()
		LIMIT 1',
		array(
			'a' => 1
		)
	);
	if ($smcFunc['db_affected_rows']() == 0)
		$context['total_downloads'] = '';
	else
	{
		$context['total_downloads'] = array();
		
		$row = $smcFunc['db_fetch_assoc']($sql);
		
		$context['total_downloads'][0] = '<a href="'.$scripturl.'?action=downloads;sa=view;down='.$row['id_file'].'">'.$row['title'].'</a>';
		$context['total_downloads'][1] = '<a href="'.$scripturl.'?action=profile;u='.$row['id_member'].'">'.$row['real_name'].'</a>';
		$context['total_downloads'][2] = parse_bbc($row['description']);
		
		$smcFunc['db_free_result']($sql);
	}
	
	return $context['total_downloads'];

}

function PopularViewDownloads($limit = 10)
{
	global $smcFunc, $scripturl;
	
	
	
	$sql = $smcFunc['db_query']('','
		SELECT a.id_file, a.title
		FROM {db_prefix}adk_down_file AS a
		WHERE approved = 1
		ORDER BY totaldownloads + views DESC
		limit '.$limit
	);
	
	$context['total_downloads'] = array();
	
	while($row = $smcFunc['db_fetch_assoc']($sql))
		$context['total_downloads'][] = '<li><a href="'.$scripturl.'?action=downloads;sa=view;down='.$row['id_file'].'">'.$row['title'].'</a></li>';
	
	$smcFunc['db_free_result']($sql);
	
	return $context['total_downloads'];
}
	
function CountUnapproveDownloads()
{
	global $smcFunc;
	
	$count = $smcFunc['db_query']('','
		SELECT
		COUNT(*) as totalfiles
		FROM {db_prefix}adk_down_file
		WHERE approved = {int:a}',
		array(
			'a' => 0,
		)
	);
	$row = $smcFunc['db_fetch_assoc']($count);
	
	$unApprove = $row['totalfiles'];
	
	$smcFunc['db_free_result']($count);
	
	return $unApprove;
}

/*----------------------------------------/*
Admin Secion
Start Here
Lucas-ruroken 2010-2011	
www.smfpersonal.net
/*-----------------------------------------*/
function ShowDownloadsMainAdmin()
{
	global $context, $txt, $smcFunc, $settings;
	
	$subActions = array(
		'settings' => 'AdkDownloadSettings',
		'savesettings' => 'AdkDownloadSaveSettings',
		'addcategory' => 'AdkDownloadAddCategory',
		'savecategory' => 'AdkDownloadSaveCategory',
		'allcategories' => 'AdkDownloadAllCategories',
		'editcategory' => 'AdkDownloadEditCategory',
		'saveeditcategory' => 'AdkDownloadSaveEditCategory',
		'deletecategory' => 'AdkDownloadDeleteCategory',
		'permisoscategory' => 'AdkDownloadPermisosCategory',
		'permisossavecategory' => 'AdkDownloadSavePermisosCategory',
		'permisosdeltecategory' => 'AdkDeletePermissions',
		'approvedownloads' => 'ApproveDownloadsAdmin',
	);
	
	
	$TotalUnApproved = CountUnapproveDownloads();
	//Load UnApprove Downloads End
	
	//Permisos
	isAllowedTo('adk_downloads_manage');
	loadTemplate('Adk-Downloads');
	
	if(loadLanguage('Adk-Admin') == false)
		loadLanguage('Adk-Admin','english');
	
	$context[$context['admin_menu_name']]['tab_data'] = array(
		'title' => $txt['adk_downloads_title'],
		'description' => $txt['adk_downloads_main_description'],
		'tabs' => array(
			'settings' => array(
				'description' => '',
				'label' => '<img style="vertical-align: middle;" alt="" src="'.$settings['default_theme_url'].'/images/admin/settings.png" />'.$txt['adk_settings'],
			),
			'addcategory' => array(
				'description' => '',
				'label' => '<img style="vertical-align: middle;" alt="" src="'.$settings['default_theme_url'].'/images/admin/addcategory.png" />'.$txt['add_category'],
			),
			'allcategories' => array(
				'description' => '',
				'label' => '<img style="vertical-align: middle;" alt="" src="'.$settings['default_theme_url'].'/images/admin/editcategory.png" />'.$txt['categories'],
			),
			'approvedownloads' => array(
				'description' => '',
				'label' => $txt['adk_approve'].' ('.$TotalUnApproved.')',
				'label' => '<img style="vertical-align: middle;" alt="" src="'.$settings['default_theme_url'].'/images/admin/approve.png" />'.$txt['adk_approve'].' ('.$TotalUnApproved.')',
			),
		),
	);	
	
	
	if (!empty($_GET['sa']) && !empty($subActions[$_GET['sa']]))
		$subActions[@$_GET['sa']]();
	else
		$subActions['settings']();

}

function AdkDownloadSettings()
{
	global $context, $txt;
	
	//Load main trader template.
	$context['sub_template']  = 'downloadssettings';

	//Set the page title
	$context['page_title'] = $txt['adk_downloads_settings'].' - Extreme Download System';


}	

function AdkDownloadSaveSettings()
{
	global $context;
	
	checkSession('post');
	
	$download_enable = (int)$_POST['download_enable'];
	$download_max_filesize = (int)$_POST['download_max_filesize'];
	$download_images_size = (int)$_POST['download_images_size'];
	$download_set_files_per_page = (int)$_POST['download_set_files_per_page'];
	$download_enable_sendpmApprove = (int)$_POST['download_enable_sendpmApprove'];
	$download_sendpm_body = CleanAdkStrings($_POST['download_sendpm_body']);
	$download_sendpm_userId = (int)$_POST['download_sendpm_userId'];
	$download_max_attach_download = (int)$_POST['download_max_attach_download'];
	
	updateSettingsAdkPortal(
		array(
			'download_enable' => $download_enable,
			'download_max_filesize' => $download_max_filesize,
			'download_images_size' => $download_images_size,
			'download_set_files_per_page' => $download_set_files_per_page,
			'download_enable_sendpmApprove' => $download_enable_sendpmApprove,
			'download_sendpm_body' => $download_sendpm_body,
			'download_sendpm_userId' => $download_sendpm_userId,
			'download_max_attach_download' => $download_max_attach_download,
		)
	);
	
	redirectexit('action=admin;area=adkdownloads');

}

function AdkDownloadAddCategory()
{
	global $context, $mbname, $txt, $modSettings, $smcFunc;

	
	checkSession('get');

	// Show the boards where the user can select to post in.
	$context['downloads_boards'] = array('');
	$request = $smcFunc['db_query']('', "
	SELECT 
		b.ID_BOARD, b.name AS bName, c.name AS cName 
	FROM {db_prefix}boards AS b, {db_prefix}categories AS c 
	WHERE b.ID_CAT = c.ID_CAT ORDER BY c.cat_order, b.board_order");
	while ($row = $smcFunc['db_fetch_assoc']($request))
		$context['downloads_boards'][$row['ID_BOARD']] = $row['cName'] . ' - ' . $row['bName'];
	$smcFunc['db_free_result']($request);

	 $dbresult = $smcFunc['db_query']('', "
	 SELECT
	 	c.ID_CAT, c.title,c.roworder
	 FROM {db_prefix}adk_down_cat AS c
	 ORDER BY c.roworder ASC");
	$context['downloads_cat'] = array();
	 while($row = $smcFunc['db_fetch_assoc']($dbresult))
	{
			$context['downloads_cat'][] = array(
			'ID_CAT' => $row['ID_CAT'],
			'title' => $row['title'],
			'roworder' => $row['roworder'],
			);
	}
	$smcFunc['db_free_result']($dbresult);

	if (isset($_REQUEST['cat']))
		$parent  = (int) $_REQUEST['cat'];
	else
		$parent = 0;

	$context['cat_parent'] = $parent;


	$context['page_title'] = $txt['adk_addcategory'].' - Extreme Download System';

	$context['sub_template']  = 'add_category';
	
}

function AdkDownloadSaveCategory()
{
	global $context, $modSettings, $sourcedir, $txt, $boarddir, $smcFunc;
	
	checkSession('post');
	
	$title = CleanAdkStrings($_POST['title']);
	$parent = (int)$_POST['parent'];
	$description = CleanAdkStrings($_POST['description']);
	$boardselect = (int)$_POST['boardselect'];
	$locktopic = (int)$_POST['locktopic'];
	
	if(empty($title))
		fatal_lang_error('adk_categorie_not_title',false);
	
	$sortby = '';
	$orderby = '';
	if(!empty($_POST['sortby']))
	{
		switch($_POST['sortby'])
		{
			case 'date':
				$sortby = 'id_file';
			break;
			case 'title':
				$sortby = 'title';
			break;
			case 'mostview':
				$sortby = 'views';
			break;
			case 'mostdowns':
				$sortby = 'totaldownloads';
			break;
		}
	}
	else
		$sortby = 'id_file';
	
	if(!empty($_POST['orderby']))
	{
		switch($_POST['orderby'])
		{
			case 'asc':
				$orderby = 'ASC';
			break;
			case 'desc':
				$orderby = 'DESC';
			break;
		}
	}
	else
		$orderby = 'DESC';
	
	$new = $smcFunc['db_query']('','
		SELECT MAX(roworder) as cat_order
		FROM {db_prefix}adk_down_cat
		WHERE ID_PARENT = {int:p}
		ORDER BY roworder DESC',
		array(
			'p' => $parent,
		)
	);
	
	$row = $smcFunc['db_fetch_assoc']($new);

	if ($smcFunc['db_affected_rows']() == 0)
		$order = 0;
	else
		$order = $row['cat_order'];
	
	$order++;
	
	$image = '';
	if (!empty($_FILES['picture']['name']) && $_FILES['picture']['name'] != '')
	{
		$sizes = @getimagesize($_FILES['picture']['tmp_name']);
		// if no size, invalid picture? :O
		if ($sizes === false)
			fatal_lang_error('adk_invalid_picture',false);
		$width_height = 128; //128 * 128 px max
	
		/*if ($sizes[0] > $width_height || $sizes[1] > $width_height)
		{
			// Delete the temp file
			@unlink($_FILES['picture']['tmp_name']);
			fatal_lang_error('adk_weight_height_false',false);
		}*/
	}
	
	$smcFunc['db_query']('',"INSERT INTO {db_prefix}adk_down_cat
		(title,description,roworder,image,id_board,id_parent,locktopic,sortby,orderby) VALUES
		('$title','$description','$order','$image','$boardselect','$parent','$locktopic','$sortby','$orderby')
	");
	
	$smcFunc['db_free_result']($new);
	
	//Category ID
	$cat_id = $smcFunc['db_insert_id']('{db_prefix}adk_down_cat', 'id_cat');
	
	if (!empty($_FILES['picture']['name']) && $_FILES['picture']['name'] != '')
	{
		
	
		// Move the file
		$extensions = array(
					1 => 'gif',
					2 => 'jpeg',
					3 => 'png',
					5 => 'psd',
					6 => 'bmp',
					7 => 'tiff',
					8 => 'tiff',
					9 => 'jpeg',
					14 => 'iff',
					);
		$extension = isset($extensions[$sizes[2]]) ? $extensions[$sizes[2]] : '.bmp';
			
				
		$filename = $boarddir.'/Adk-downloads/catimgs/'.$cat_id . '.JPEG';
		
		move_uploaded_file($_FILES['picture']['tmp_name'], $filename);
		//load_AvdImage('', $filename, $extension, 7, $filename);
		@chmod($filename, 0644);
		
		// Update the filename for the category
		$smcFunc['db_query']('', "
			UPDATE {db_prefix}adk_down_cat
			SET image = {string:image}
			WHERE ID_CAT = {int:cat} LIMIT 1",
			array(
				'image' => $filename,
				'cat' => $cat_id,
			)
		);
	}

		
	redirectexit('action=admin;area=adkdownloads;sa=allcategories;'.$context['session_var'].'='.$context['session_id']);
	
}

function AdkDownloadAllCategories()
{
	global $smcFunc, $context, $txt;
	
	checkSession('get');
	
	$sql = $smcFunc['db_query']('','
		SELECT c.id_cat, c.title,c.roworder, c.id_parent
		FROM {db_prefix}adk_down_cat AS c
		ORDER BY c.roworder ASC'
	);
	
	$context['all_categories'] = array();
	while($row = $smcFunc['db_fetch_assoc']($sql))
	{
		$context['all_categories'][] = array(
			'id_cat' => $row['id_cat'],
			'title' => $row['title'],
			'roworder' => $row['roworder'],
			'id_parent' => $row['id_parent'],
		);
	}
	
	$smcFunc['db_free_result']($sql);
	
	$context['page_title'] = $txt['adk_all_categories_title'].' - Extreme Download System';

	$context['sub_template']  = 'all_categories';

}

function AdkDownloadEditCategory()
{
	global $smcFunc, $txt, $context, $scripturl;
	
	checkSession('get');
	
	$context['page_title'] = $txt['adk_all_edit_categories_title'].' - Extreme Download System';

	$context['sub_template']  = 'edit_category';
	
	if(!empty($_REQUEST['id']) && is_numeric($_REQUEST['id']))
		$id_cat = (int)$_REQUEST['id'];
	else
		fatal_lang_error('adk_invalid_id_category',false);
	
	$context['downloads_boards'] = array('');
	$request = $smcFunc['db_query']('', "
	SELECT
		b.id_board, b.name AS bName, c.name AS cName
	FROM {db_prefix}boards AS b, {db_prefix}categories AS c
	WHERE b.id_cat = c.id_cat ORDER BY c.cat_order, b.board_order");
	while ($row = $smcFunc['db_fetch_assoc']($request))
		$context['downloads_boards'][$row['id_board']] = $row['cName'] . ' - ' . $row['bName'];
		
	$smcFunc['db_free_result']($request);

	 $dbresult = $smcFunc['db_query']('', "
	 SELECT
	 	c.ID_CAT, c.title,c.roworder
	 FROM {db_prefix}adk_down_cat AS c
	 WHERE ID_CAT <> '$id_cat'
	 ORDER BY c.roworder ASC");
	$context['downloads_cat'] = array();
	while($row = $smcFunc['db_fetch_assoc']($dbresult))
	{
			$context['downloads_cat'][] = array(
			'ID_CAT' => $row['ID_CAT'],
			'title' => $row['title'],
			'roworder' => $row['roworder'],
			);
	}
	$smcFunc['db_free_result']($dbresult);
	
	$context['adk_cat'] = array();
	$sql = $smcFunc['db_query']('','
		SELECT title,description,id_board,id_parent,locktopic,sortby,orderby,image
		FROM {db_prefix}adk_down_cat
		WHERE id_cat = {int:cat} LIMIT 1',
		array(
			'cat' => $id_cat,
		)
	);
	
	$new = $smcFunc['db_fetch_assoc']($sql);
	$context['adk_cat'] = array(
		'id_cat' => $id_cat,
		'id_board' => $new['id_board'],
		'title' => $new['title'],
		'description' => $new['description'],
		'id_parent' => $new['id_parent'],
		'locktopic' => $new['locktopic'],
		'sortby' => $new['sortby'],
		'orderby' => $new['orderby'],
		'image2' => $new['image'],
	);
	
	$smcFunc['db_free_result']($sql);

}

function AdkDownloadSaveEditCategory()
{
	global $context, $modSettings, $sourcedir, $txt, $boarddir, $smcFunc;
	
	checkSession('post');
	
	$title = CleanAdkStrings($_POST['title']);
	$parent = (int)$_POST['parent'];
	$description = CleanAdkStrings($_POST['description']);
	$boardselect = (int)$_POST['boardselect'];
	$locktopic = (int)$_POST['locktopic'];
	$id_cat = !empty($_POST['id_cat']) ? (int)$_POST['id_cat'] : 0;
	$filename = $_POST['picture2'];
	
	if(empty($title))
		fatal_lang_error('adk_categorie_not_title',false);
	
	$sortby = '';
	$orderby = '';
	if(!empty($_POST['sortby']))
	{
		switch($_POST['sortby'])
		{
			case 'date':
				$sortby = 'id_file';
			break;
			case 'title':
				$sortby = 'title';
			break;
			case 'mostview':
				$sortby = 'views';
			break;
			case 'mostdowns':
				$sortby = 'totaldownloads';
			break;
		}
	}
	else
		$sortby = 'id_file';
	
	if(!empty($_POST['orderby']))
	{
		switch($_POST['orderby'])
		{
			case 'asc':
				$orderby = 'ASC';
			break;
			case 'desc':
				$orderby = 'DESC';
			break;
		}
	}
	else
		$orderby = 'DESC';
	
	
	if (!empty($_FILES['picture']['name']) && $_FILES['picture']['name'] != '')
	{
		$sizes = @getimagesize($_FILES['picture']['tmp_name']);

		// if no size, invalid picture? :O
		if ($sizes === false)
			fatal_lang_error('adk_invalid_picture',false);
			
		global $sourcedir;
		require_once($sourcedir . '/Subs-Graphics.php');
			
		$width_height = 128; //128 * 128 px max
	
		/*if ($sizes[0] > $width_height || $sizes[1] > $width_height)
		{
			// Delete the temp file
			@unlink($_FILES['picture']['tmp_name']);
			fatal_lang_error('adk_weight_height_false',false);
		}*/
	
		// Move the file
		$extensions = array(
					1 => 'gif',
					2 => 'jpeg',
					3 => 'png',
					5 => 'psd',
					6 => 'bmp',
					7 => 'tiff',
					8 => 'tiff',
					9 => 'jpeg',
					14 => 'iff',
					);
		$extension = isset($extensions[$sizes[2]]) ? $extensions[$sizes[2]] : '.bmp';
			
				
		$filename = $boarddir.'/Adk-downloads/catimgs/'.$id_cat . '.' . $extension;
		
		move_uploaded_file($_FILES['picture']['tmp_name'], $filename);
		//load_AvdImage('', $filename, $extension, 7, $filename);
		@chmod($filename, 0644);
		
		
	}
	
	$smcFunc['db_query']('','
		UPDATE {db_prefix}adk_down_cat
		SET
		title = {string:title}, description = {string:description},
		image = {string:filename}, id_board = {int:idb},
		id_parent = {int:idp}, locktopic = {int:locktopic},
		sortby = {string:sortby}, orderby = {string:orderby}
		WHERE id_cat = {int:id_cat}',
		array(
			'title' => $title,
			'description' => $description,
			'filename' => $filename,
			'idb' => $boardselect,
			'idp' => $parent,
			'locktopic' => $locktopic,
			'sortby' => $sortby,
			'orderby' => $orderby,
			'id_cat' => $id_cat,
		)
	);
		
	
	redirectexit('action=admin;area=adkdownloads;sa=allcategories;'.$context['session_var'].'='.$context['session_id']);
	
}

function AdkDownloadDeleteCategory()
{
	global $context, $smcFunc;
	
	checkSession('get');
	
	if(!empty($_REQUEST['id']) && is_numeric($_REQUEST['id']))
		$id_cat = (int)$_REQUEST['id'];
	else
		fatal_lang_error('adk_invalid_id_category',false);
	
	$sql = $smcFunc['db_query']('','
		SELECT id_file FROM {db_prefix}adk_down_file
		WHERE id_cat = {int:cat}',
		array(
			'cat' => $id_cat,
		)
	);
	$context['info_cat'] = array();
	$context['load_filename'] = array();
	while($row = $smcFunc['db_fetch_assoc']($sql))
	{
		$context['info_cat'][] = $row['id_file'];
	}
	
	$smcFunc['db_free_result']($sql);
	
	if(!empty($context['info_cat'])){
		$id_files = implode(",",$context['info_cat']);
		
		$smcFunc['db_query']('','
			DELETE FROM {db_prefix}adk_down_attachs
			WHERE id_file IN ('.$id_files.')'
		);
	}
	
	$smcFunc['db_query']('','
		DELETE FROM {db_prefix}adk_down_file
		WHERE id_cat = {int:cat}',
		array(
			'cat' => $id_cat,
		)
	);
	
	//if
	
	$smcFunc['db_query']('','
		DELETE FROM {db_prefix}adk_down_cat
		WHERE id_cat = {int:cat}',
		array(
			'cat' => $id_cat,
		)
	);
	
	redirectexit('action=admin;area=adkdownloads;sa=allcategories;'.$context['session_var'].'='.$context['session_id']);

}

function AdkDownloadPermisosCategory()
{
	global $smcFunc, $context, $txt;
	
	checkSession('get');
	
	if(!empty($_REQUEST['id']) && is_numeric($_REQUEST['id']))
		$cat = (int)$_REQUEST['id'];
	else
		fatal_lang_error('adk_invalid_id_category',false);
	
	$dbresult1 = $smcFunc['db_query']('', "
		SELECT
		id_cat, title
		FROM {db_prefix}adk_down_cat
		WHERE id_cat = {int:cat} LIMIT 1",
		array(
			'cat' => $cat,
		)
	);
	$row1 = $smcFunc['db_fetch_assoc']($dbresult1);
	$context['downloads_cat_name'] = $row1['title'];
	$smcFunc['db_free_result']($dbresult1);

	loadLanguage('Admin');

	$context['downloads_cat'] = $cat;

	// Load the template
	$context['sub_template']  = 'permission_category';
	// Set the page title

	// Load the membergroups
	$dbresult = $smcFunc['db_query']('', "
		SELECT
		id_group, group_name
		FROM {db_prefix}membergroups
		WHERE min_posts = {string:min} ORDER BY group_name",
		array(
			'min' => -1
		)
	);
	while ($row = $smcFunc['db_fetch_assoc']($dbresult))
	{
		$context['groups'][$row['id_group']] = array(
			'ID_GROUP' => $row['id_group'],
			'group_name' => $row['group_name'],
			);
	}
	$smcFunc['db_free_result']($dbresult);


	// Membergroups
	$dbresult = $smcFunc['db_query']('', "
		SELECT
		c.id_cat, c.view, c.addfile,   c.id_group, m.group_name,a.title AS catname
		FROM ({db_prefix}adk_down_permissions as c, {db_prefix}membergroups AS m,{db_prefix}adk_down_cat as a)
		WHERE  c.ID_CAT = {int:cat} AND c.id_group = m.id_group AND a.id_cat = c.id_cat",
		array(
			'cat' => $context['downloads_cat'],
		)
	);
	
	$context['downloads_membergroups'] = array();
	while($row = $smcFunc['db_fetch_assoc']($dbresult))
		{
			$context['downloads_membergroups'][] = array(
			'ID_CAT' => $row['id_cat'],
			'view' => $row['view'],
			'addfile' => $row['addfile'],
			'ID_GROUP' => $row['id_group'],
			'group_name' => $row['group_name'],
			'catname' => $row['catname'],
			);

		}
	$smcFunc['db_free_result']($dbresult);


	$dbresult = $smcFunc['db_query']('', "
		SELECT
		c.id_cat,  c.view, c.addfile,  c.id_group,a.title AS catname
		FROM {db_prefix}adk_down_permissions as c,{db_prefix}adk_down_cat as a
		WHERE c.id_cat = {int:cat} AND c.id_group = {int:g} AND a.id_cat = c.id_cat LIMIT 1",
		array(
			'cat' => $context['downloads_cat'],
			'g' => 0,
		)
	);
	$context['downloads_reggroup'] = array();
	while($row = $smcFunc['db_fetch_assoc']($dbresult))
		{
			$context['downloads_reggroup'][] = array(
			'ID_CAT' => $row['id_cat'],
			'view' => $row['view'],
			'addfile' => $row['addfile'],
			'ID_GROUP' => $row['id_group'],
			'catname' => $row['catname'],
			);

		}
	$smcFunc['db_free_result']($dbresult);


	$dbresult = $smcFunc['db_query']('', "
		SELECT
		c.id_cat, c.view, c.addfile,  c.id_group,a.title AS catname
		FROM {db_prefix}adk_down_permissions as c,{db_prefix}adk_down_cat as a
		WHERE c.id_cat = {int:cat} AND c.id_group = {int:g} AND a.id_cat = c.id_cat LIMIT 1",
		array(
			'cat' => $context['downloads_cat'],
			'g' => -1,
		)
	);
	$context['downloads_guestgroup'] = array();
	while($row = $smcFunc['db_fetch_assoc']($dbresult))
		{
			$context['downloads_guestgroup'][] = array(
			'id_cat' => $row['id_cat'],
			'view' => $row['view'],
			'addfile' => $row['addfile'],
			'ID_GROUP' => $row['id_group'],
			'catname' => $row['catname'],
			);

	}
	$smcFunc['db_free_result']($dbresult);
	
	$context['page_title'] = $txt['adk_advanced_permission_cat'];

	$context['sub_template']  = 'permission_category';
	
}

function AdkDownloadSavePermisosCategory()
{
	global $txt, $smcFunc, $context;
	
	checkSession('post');
	
	$groupname = (int) $_POST['groupname'];
	$cat = (int) $_POST['cat'];
	
	
	//Delete previous permissions
	$smcFunc['db_query']('','
		DELETE FROM {db_prefix}adk_down_permissions
		WHERE id_cat = {int:cat} AND id_group = {string:g}',
		array(
			'cat' => $cat,
			'g' => $groupname,
		)
	);
	
	$view = isset($_REQUEST['view']) ? 1 : 0;
	$add = isset($_REQUEST['add']) ? 1 : 0;
	
	//Insert the new permissions
	$smcFunc['db_query']('',"
		INSERT INTO {db_prefix}adk_down_permissions
		(id_group,id_cat,view,addfile)
		VALUES
		('$groupname','$cat','$view','$add')
	");

	redirectexit('action=admin;area=adkdownloads;sa=permisoscategory;id='.$cat.';'.$context['session_var'].'='.$context['session_id']);

}

function AdkDeletePermissions($id_cat = false, $id_group = false)
{
	global $smcFunc, $context;
	
	checkSession('get');
	
	if(!empty($_REQUEST['id_cat']))
		$id_cat = (int)$_REQUEST['id_cat'];
	else
		fatal_lang_error('adk_require_catid',false);
	
	if(isset($_REQUEST['id_group']))
		$id_group = (int)$_REQUEST['id_group'];
	else
		fatal_lang_error('adk_require_idgroup',false);
	
	//Delete previous permissions
	$smcFunc['db_query']('','
		DELETE FROM {db_prefix}adk_down_permissions
		WHERE id_cat = {int:cat} AND id_group = {string:g}',
		array(
			'cat' => $id_cat,
			'g' => $id_group,
		)
	);
	
	
	redirectexit('action=admin;area=adkdownloads;sa=permisoscategory;id='.$id_cat.';'.$context['session_var'].'='.$context['session_id']);
	
}

function ApproveDownloadsAdmin()
{
	global $smcFunc, $txt, $context;
	
	checkSession('get');

	$context['page_title'] = $txt['adk_approve_admin'];

	$context['sub_template']  = 'approve_d';
	
	$sql = $smcFunc['db_query']('','
		SELECT id_file, title
		FROM {db_prefix}adk_down_file
		WHERE approved = {int:a}',
		array(
			'a' => 0,
		)
	);
	
	$context['unapproved'] = array();
	
	while($row = $smcFunc['db_fetch_assoc']($sql))
	{
		$context['unapproved'][] = array(
			'id' => $row['id_file'],
			'title' => $row['title'],
		);
	}
	
	$smcFunc['db_free_result']($sql);

}

function PleaseCheckMyLastDownload($id_cat)
{
	global $smcFunc, $context, $scripturl, $modSettings;
	
	$sql = $smcFunc['db_query']('','
		SELECT c.id_cat, f.id_cat,
		f.id_file, f.date, f.title, f.id_member, m.id_member, m.avatar, m.real_name,
			IFNULL(a.id_attach, 0) AS id_attach, a.filename, a.attachment_type
		FROM {db_prefix}adk_down_file AS f, {db_prefix}adk_down_cat AS c, {db_prefix}members AS m
		LEFT JOIN {db_prefix}attachments AS a ON (a.id_member = m.id_member)
		WHERE m.id_member = f.id_member AND c.id_cat = f.id_cat AND c.id_cat = {int:cat}
		ORDER BY f.id_file DESC LIMIT 1',
		array(
			'cat' => $id_cat,
		)
	);
	
	$row = $smcFunc['db_fetch_assoc']($sql);
	
	$smcFunc['db_free_result']($sql);
	
	$context['last_download'] = array();
	
	//$width and height
	$width = 50; $height = 50;
	
	$context['last_download'] = array(
		'id' => $row['id_file'],
		'member' => '<a href="'.$scripturl.'?action=profile;u='.$row['id_member'].'">'.$row['real_name'].'</a>',
		'avatar' => $row['avatar'] == '' ? ($row['id_attach'] > 0 ? '<img width="'.$width.'" height="'.$height.'" src="' . (empty($row['attachment_type']) ? $scripturl . '?action=dlattach;attach=' . $row['id_attach'] . ';type=avatar' : $modSettings['custom_avatar_url'] . '/' . $row['filename']) . '" alt="" border="0" />' : '') : (stristr($row['avatar'], 'http://') ? '<img width="'.$width.'" height="'.$height.'"src="' . $row['avatar'] . '" alt="" border="0" />' : '<img width="'.$width.'" height="'.$height.'"src="' . $modSettings['avatar_url'] . '/' . $smcFunc['htmlspecialchars']($row['avatar']) . '" alt="" border="0" />'),
		'file' => '<a href="'.$scripturl.'?action=downloads;sa=view;down='.$row['id_file'].'">'.$row['title'].'</a>',
		'date' => timeformat($row['date']),
		'download' => array(),
	);
	
	//For RewriteUrls
	$context['last_download']['download'] = $row['title'];
	
	return !empty($context['last_download']) ? $context['last_download'] : '';

}

function downloads_verify_checked($variable, $value)
{
	global $adkportal;
	
	if($adkportal[$variable] == $value)
		echo'checked="checked"';
}
function verfy_select_board($key,$board)
{
	if($board == $key)
		echo'selected="selected"';
}

function format_size($size, $round = 0) 
{
    //Size must be bytes!
    $sizes = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    for ($i=0; $size > 1024 && $i < count($sizes) - 1; $i++) $size /= 1024;
    return round($size,$round).$sizes[$i];
}

function download_bar_buttons($active = 'downloads')
{
	global $scripturl, $context, $user_info;
	
	//The Menu Buttons
	if(allowedTo('adk_downloads_add'))
		$context['adk_downloads_add'] = true;
	if($context['user']['is_logged'])
		$context['adk_user_is_logged'] = true;
	if(allowedTo('adk_downloads_manage') && !empty($context['unApprove']))
		$context['view_un'] = true;
	
	
	$menu_buttons = array(
		'downloads' => array(
			'text' => 'downloads',
			'image' => '',
			'lang' => true,
			'url' => $scripturl.'?action=downloads',
		),
		'viewstats' => array(
			'text' => 'adk_view_stats', 
			'image' => '', 
			'lang' => true, 
			'url' => $scripturl.'?action=downloads;sa=viewstats',
		),
		'myprofile' => array(
			'test' => 'adk_user_is_logged', 
			'text' => 'adk_myprofile', 
			'image' => '', 
			'lang' => true, 
			'url' => $scripturl.'?action=downloads;sa=myprofile;u='.$user_info['id'],
		)
	);
	
	$menu_buttons['search'] = array(
		'text' => 'adk_buscar', 
		'image' => '', 
		'lang' => true, 
		'url' => $scripturl.'?action=downloads;sa=search',
	);
	
	if(!empty($context['view_un'])){
		$menu_buttons[] = array(
			'test' => 'view_un',
			'text' => 'adk_approve_admin',
			'url' => $scripturl.'?action=admin;area=adkdownloads;sa=approvedownloads;'.$context['session_var'].'='.$context['session_id'],
			'active' => true,
		);
	}
	
	if(!empty($active))
		$menu_buttons[$active]['active'] = true;
	
	echo'
	<div class="pagesection">
		',template_button_strip($menu_buttons,'right'),'
	</div>
	<div class="height_2"></div>';
}
?>