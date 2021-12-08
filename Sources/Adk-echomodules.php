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

function load_pages_adkportal($request = '')
{
	global $context, $txt, $smcFunc, $sourcedir, $boardurl, $boarddir, $scripturl;
	
	//require_once($boarddir . '/SSI.php'); I don't know why I'm using SSI -.-
	require_once($sourcedir.'/Subs-adkblocks.php');
	
	loadTemplate('Adk-echomodules');
	
	$context['sub_template']  = 'load_pages_adkportal';
	
	
	if(empty($request) && empty($_REQUEST['page']))
		fatal_lang_error('error_adk_page_not_exist', false);
	elseif(empty($request) && !empty($_REQUEST['page']))
		$request = CleanAdkStrings(stripslashes($_REQUEST['page']));
	
	//Update views + 1
	$smcFunc['db_query']('', '
		UPDATE {db_prefix}adk_pages
		SET views = views + 1
		WHERE urltext = {text:page}',
		array(
			'page' => $request,
		)
	);
		
	//Load all
	$sql2 = $smcFunc['db_query']('','
		SELECT * FROM 
		{db_prefix}adk_pages 
		WHERE urltext = {text:page}',
		array(
			'page' => $request,
		)
	);
	
	
	$row = $smcFunc['db_fetch_assoc']($sql2);
		
	$context['page_view_content'] = array(
		'titlepage' => un_CleanAdkStrings($row['titlepage']),
		'body' => un_CleanAdkStrings($row['body']),
		'ctbg' => $row['cattitlebg'],
		'winbg' => $row['winbg'],
		'groups_allowed' => $row['grupos_permitidos'],
		'type' => $row['type'],
		'view' => $row['views'],
		'enableleft' => $row['enableleft'],
		'enableright' => $row['enableright'],
		'load_my_left' => !empty($row['enableleft']),
		'load_my_right' => !empty($row['enableright']),
	);
		
	if(empty($context['page_view_content']['titlepage']))
		fatal_lang_error('error_adk_page_not_exist', false);
		
	//Comprobamos si los visitantes pueden ver esta pagina
	permission_groups_other_pages($context['page_view_content']['groups_allowed']);
		
		
	$context['page_title'] = $context['page_view_content']['titlepage'];
		
		
	$smcFunc['db_free_result']($sql2);
	
	//Load Linktree
	$context['linktree'][] = array(
		'url' => $scripturl.'?page='.$request,
		'name' => $row['titlepage'],
	);
	
}

//Well, load my shoutbox
function ShowShoutbox()
{
	global $txt, $adkportal, $context, $smcFunc, $scripturl, $user_info, $boardurl;
	
	//id_group?
	$id_group = $context['user']['is_logged'] ? $user_info['groups'][0] : -1;
	
	if($id_group == 1)
		$continue = true;
	elseif(in_array($id_group,explode(',',$adkportal['shout_allowed_groups_view'])))
		$continue = true;
	else
		$continue = false;
	
	//Are you allowed to view shoutbox?
	if(!$continue)
		fatal_lang_error('adk_shout_now_allowed', false);
	
	//Load Linktree
	$context['linktree'][] = array(
		'url' => $scripturl.'?action=adk_shoutbox',
		'name' => $txt['adk_shout'],
	);
	
	//Delete any?
	if(!empty($_REQUEST['del']) && $user_info['is_admin'])
	{
		$smcFunc['db_query']('','
			DELETE FROM {db_prefix}adk_shoutbox
			WHERE id = {int:id}',
			array(
				'id' => (int)$_REQUEST['del'],
			)
		);
	}
	
	//Load our Custom language
	if(loadLanguage('Adk-Admin') == false)
		loadLanguage('Adk-Admin','english');
	
	//Template
	loadTemplate('Adk-echomodules');
	
	//Load our css
	$context['html_headers'] = '
<link rel="stylesheet" type="text/css" href="'.$boardurl.'/adkportal/css/blocks.css" />';
	
	//Shouts limit
	$shout_limit = 20;
	
	//Start from?
	$context['start'] = !empty($_REQUEST['start']) ? (int)$_REQUEST['start'] : 0;
	
	//Load total shoutbox
	$data = $smcFunc['db_query']('','
		SELECT COUNT(*) AS total FROM {db_prefix}adk_shoutbox
	');
	
	if($smcFunc['db_num_rows']($data) == 0)
		fatal_lang_error('adk_shoutbox_empty',false);
	
	list($total) = $smcFunc['db_fetch_row']($data);
	
	$smcFunc['db_free_result']($data);
	
	//Well.... construct page index.
	$context['page_index'] = constructPageIndex($scripturl . '?action=adk_shoutbox', $context['start'], $total, $shout_limit);
	
	//Load shouts
	$sql = $smcFunc['db_query']('','
		SELECT id, date, user, message
		FROM {db_prefix}adk_shoutbox
		ORDER BY id DESC
		LIMIT {int:start},{int:end}',
		array(
			'start' => $context['start'],
			'end' => $shout_limit,
		)
	);
	
	$context['shouts'] = array();
	
	while($row = $smcFunc['db_fetch_assoc']($sql))
	{
		
		$context['shouts'][] = array(
			'id' => $row['id'],
			'date' => timeformat($row['date']),
			'user' => $row['user'],
			'message' => parse_shoutbox($row['message']),
			'alternate' => 'windowbg',
		);
		
	}
	
	$smcFunc['db_free_result']($sql);
	
	//Show the page_title
	$context['page_title'] = $txt['adk_shout'];
	
	//Sub_template
	$context['sub_template'] = 'load_shout';
	
}

function AddThisTopic()
{
	global $smcFunc, $adkportal, $user_info, $txt, $scripturl, $context;
	
	if(!empty($_REQUEST['add']))
	{	
		isAllowedTo('adk_portal');
		
		$id = (int)$_REQUEST['add'];
	
		$sql = $smcFunc['db_query']('','
			SELECT m.id_topic, m.subject, m.body, m.poster_name
			FROM {db_prefix}messages AS m
			INNER JOIN {db_prefix}topics AS t ON (t.id_first_msg = m.id_msg)
			WHERE t.id_topic = {int:topic}',
			array(
				'topic' => $id,
			)
		);
		$row = $smcFunc['db_fetch_assoc']($sql);
		$smcFunc['db_free_result']($sql);
		
		$body = un_CleanAdkStrings($smcFunc['htmlspecialchars']($row['body']));
		$title = $row['subject'];
		$name = $user_info['name'];
		$time = time();
		
		$Sql="INSERT INTO {db_prefix}adk_news 
		(titlepage,new,autor,time) values
		('$title','$body','$name','$time')";
		$smcFunc['db_query']('', $Sql);
		
		$id_new = 0;
		$id_new = $smcFunc['db_insert_id']('{db_prefix}adk_news');
		
		$smcFunc['db_query']('','
			UPDATE {db_prefix}topics
			SET id_new = {int:new}
			WHERE id_topic = {int:topic}',
			array(
				'new' => $id_new,
				'topic' => $id,
			)
		);
		
		redirectexit('topic='.$id.'.0');
	}
	elseif(!empty($_REQUEST['remove']))
	{
		$id = (int)$_REQUEST['remove'];
		isAllowedTo('adk_portal');
		$sql = $smcFunc['db_query']('','
			SELECT id_new
			FROM {db_prefix}topics
			WHERE id_topic = {int:topic}',
			array(
				'topic' => $id,
			)
		);
		
		list ($topic) = $smcFunc['db_fetch_row']($sql);
		$smcFunc['db_free_result']($sql);
		
		$smcFunc['db_query']('','
			UPDATE {db_prefix}topics
			SET id_new = {int:new}
			WHERE id_topic = {int:t}',
			array(
				'new' => 0,
				't' => $id,
			)
		);
		
		$smcFunc['db_query']('','
			DELETE FROM {db_prefix}adk_news
			WHERE id = {int:new}',
			array(
				'new' => $topic,
			)
		);
		
		redirectexit('topic='.$id.'.0');
	}
	elseif(!empty($_REQUEST['view']))
	{
		$id = (int)$_REQUEST['view'];
		
		if(empty($id))
			fatal_lang_error('news_adk_id_required',false);
		
		loadTemplate('Adk-echomodules');
		if(loadLanguage('Adk-Admin') == false)
			loadLanguage('Adk-Admin','english');
		
		$sql = $smcFunc['db_query']('','
			SELECT titlepage, new, autor, time
			FROM {db_prefix}adk_news
			WHERE id = {int:id_new}
			LIMIT 1',
			array(
				'id_new' => $id,
			)
		);
		
		$row = $smcFunc['db_fetch_assoc']($sql);
		$smcFunc['db_free_result']($sql);
		
		$context['adk_new'] = array(
			'id' => $id,
			'title' => $row['titlepage'],
			'body' => parse_bbc($row['new']),
			'autor' => $row['autor'],
			'time' => timeformat($row['time']),
		);
		
		$context['sub_template'] = 'view_new';
		$context['page_title'] = $row['titlepage'];
		
		//loadRandom5News();
		
		//Again :D
		if(empty($context['adk_new']['title']))
			fatal_lang_error('news_adk_id_required',false);
		
		//Show the linktree
		$context['linktree'][] = array(
			'url' => $scripturl.'?action=addthistopic;view='.$context['adk_new']['id'],
			'name' => $context['adk_new']['title'],
		);
	}
	else
		redirectexit();
}

function AdkCredits()
{
	global $txt, $context, $scripturl;
	
	//Load our Custom language
	if(loadLanguage('Adk-Admin') == false)
		loadLanguage('Adk-Admin','english');
	
	loadTemplate('Adk-echomodules');
	
	$context['sub_template'] = 'adk_credits';
	$context['page_title'] = $txt['adk_credits'];
	
	$context['linktree'][] = array(
		'name' => $txt['adk_credits'],
		'url' => $scripturl.'?action=adk_credits',
	);
}

function AdkContact()
{
	if(!empty($_REQUEST['sa']) && $_REQUEST['sa'] == 'send')
		$function = 'AdkContactSend';
	else
		$function = 'AdkContactWrite';
	
	//Load our Custom language
	if(loadLanguage('Adk-Admin') == false)
		loadLanguage('Adk-Admin','english');
	
	loadTemplate('Adk-echomodules');
	
	if(!allowedToViewContactPage())
		fatal_lang_error('adk_module_contact_disable',false);
	
	$function();
}

function AdkContactWrite()
{
	global $txt, $context, $scripturl, $adkportal, $sourcedir;
	
	$context['page_title'] = $txt['adk_contacto'].' - '.$context['forum_name'];
	$context['sub_template'] = 'adk_contact';
	
	$context['linktree'][] = array(
		'name' => $txt['adk_contacto'],
		'url' => $scripturl.'?action=contact',
	);

	if(empty($adkportal['adk_enable_contact']))
		fatal_lang_error('adk_module_contact_disable',false);
	
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
	
	//Select admin of the site
	global $smcFunc;
	
	$sql = $smcFunc['db_query']('','
		SELECT id_member, real_name
		FROM {db_prefix}members
		WHERE id_group = {int:admin}
		ORDER BY id_member ASC',
		array(
			'admin' => 1,
		)
	);
	
	$members = array();
	
	while($row = $smcFunc['db_fetch_assoc']($sql))
		$members[$row['id_member']] = $row['real_name'];
	
	$context['members_admin'] = $members;
	
	$smcFunc['db_free_result']($sql);
	
	//Visual Verification
	require_once($sourcedir . '/Subs-Editor.php');
	$verificationOptions = array(
		'id' => 'post',
	);
	$context['require_verification'] = create_control_verification($verificationOptions);
	$context['visual_verification_id'] = $verificationOptions['id'];
}

function AdkContactSend()
{
	global $smcFunc, $context, $sourcedir, $user_info, $txt;
	
	checkSession('post');
	
	//Wrong fields?
	if(empty($_POST['subject']) || empty($_POST['name']) || empty($_POST['email']) || empty($_POST['descript']))
		fatal_lang_error('adk_form_error',false);
	
	//Captcha error?
	require_once($sourcedir . '/Subs-Editor.php');
	$verificationOptions = array(
		'id' => 'post',
	);
	
	$context['require_verification'] = create_control_verification($verificationOptions, true);
	
	if (is_array($context['require_verification']))
		fatal_lang_error('adk_captcha_invalid',false);
	
	$admins = array();
	
	$id_admin = (int)$_POST['admin'];
	
	if(!empty($id_admin))
		$where = 'id_member = {int:member}';
	else
		$where = 'id_group = {int:admin}';
	
	$sql = $smcFunc['db_query']('','
		SELECT email_address
		FROM {db_prefix}members
		WHERE '.$where,
		array(
			'member' => (int)$_POST['admin'],
			'admin' => 1,
		)
	);
	
	while($row = $smcFunc['db_fetch_assoc']($sql))
		$admins[] = $row['email_address'];
	
	$smcFunc['db_free_result']($sql);
	
	if (!empty($_REQUEST['descript_mode']) && isset($_REQUEST['descript']))
	{
		require_once($sourcedir . '/Subs-Editor.php');

		$_REQUEST['descript'] = html_to_bbc($_REQUEST['descript']);

		// We need to unhtml it now as it gets done shortly.
		$_REQUEST['descript'] = un_CleanAdkStrings($_REQUEST['descript']);

	}
	
	$body = CleanAdkStrings($_REQUEST['descript']);
	$name = CleanAdkStrings($_POST['name']);
	$email = CleanAdkStrings($_POST['email']);
	$subject = CleanAdkStrings($_POST['subject']);
	
	//user logged and false name :)???
	if(!$context['user']['is_guest'])
		$name = $name.' ('.$user_info['name'].')';
	else
		$name = $name.' ('.$txt['guest'].')';
	
	//making new variables
	$from = $name.' - '.$email;
	$to = $admins;
	$message = parse_bbc($body);
	$message_id = null;
	$send_html = true;
	$priority = 3;
	$hotmail_fix = null;
	$is_private = false;
	
	$message .= '<br /><br /><hr />'.$txt['email'].': '.$email.'<br />'.$txt['name'].': '.$name;
	
	//Sending mail :)
	require_once($sourcedir . '/Subs-Post.php');
	sendmail($to, $subject, $message, $from, $message_id, $send_html, $priority, $hotmail_fix, $is_private);
	
	redirectexit('action=contact;sended');
	
}
?>