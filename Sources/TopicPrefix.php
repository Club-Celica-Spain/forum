<?php
/**********************************************************************************
* TopicPrefix..php                                                                                                                                    *
***********************************************************************************
*                                                                                                                                                                  *
* SMF Topic Prefix Mod                                                                                                                          *
* Copyright (c) 2008-2009 by NIBOGO. All rights reserved.                                                                        *
* Powered by www.mundo-se.com                                                                                                             *
* Created by NIBOGO for Simplemachines.org                                                                                     *
*                                                                                                                                                                   *
**********************************************************************************/
function PrefixMain()
{
	global $sourcedir, $context, $txt, $boardurl, $boarddir, $scripturl, $smcFunc, $modSettings;	
 	
	// Load the prefix language
	if (loadLanguage('TopicPrefix') == false)
		loadLanguage('TopicPrefix','english');
		
	// Load the Prefix Template
	loadtemplate('TopicPrefix');

	// Load all the subactions for the YAGAM
	$subActions = array(		
		'add' => 'prefix_add',
		'addverify' => 'prefix_add_verify',
		'edit' => 'prefix_edit',
		'editverify' => 'prefix_edit_verify',
		'deleteverify' => 'prefix_delete_verify',		
        'admin' => 'prefix_admin', 
        'version' => 'prefix_version',                  
	);
	
	if (isset($_GET['sa']))
      $sa = $_GET['sa'];
		
	if (!empty($subActions[$sa]))
		$subActions[$sa]();		
}

function prefix_add()
{
	global $txt, $context, $smcFunc, $sourcedir, $board_info, $scripturl, $modSettings, $themedir, $sourcedir;	
	
	// Check Permission for Admin and Prefix Manager
	if (!allowedTo('prefix_manage'))
		fatal_lang_error('prefix_no_permission', false);	
		
	$context[$context['admin_menu_name']]['tab_data']['title'] = $txt['prefix_admin_title'];
	$context[$context['admin_menu_name']]['tab_data']['description'] = $txt['prefix_version_description'];
		
	// Load the sub-template
	$context['sub_template']  = 'prefix_add';
	$context['page_title'] = $txt['prefix_add'];
	
	// Load all the boards stuff
	prefix_boards();

	//Load the language
    loadLanguage('Admin');
	
	// We need the membergroups
	$dbresult = $smcFunc['db_query']('', '
    SELECT id_group, group_name
    FROM {db_prefix}membergroups
    WHERE min_posts = {int:primary_group}
      AND id_group <> {int:moderator}
      ORDER BY group_name',
      array(
         'primary_group' => -1,
         'moderator' => 3,
      )
    );
	$context['groups'] = array();
	while ($row = $smcFunc['db_fetch_assoc']($dbresult))
	{
		$context['groups'][$row['id_group']] = array(
			'id_group' => $row['id_group'],
			'group_name' => $row['group_name'],
			);
	}
	$smcFunc['db_free_result']($dbresult);
	
	//Add the Linktree
    $context['linktree'][] = array(		
		'name' => $txt['prefix_admin'],
		'url' => $scripturl.'?action=admin;area=prefix;sa=admin;'.$context['session_id'].'',
    );
	$context['linktree'][] = array(		
		'name' => $txt['prefix_add'],
		'url' => $scripturl.'?action=admin;area=prefix;sa=add;'.$context['session_id'].'',
    );
}

function prefix_add_verify()
{
	global $txt, $smcFunc, $user_info, $sourcedir, $context;
	
	// Check Permission for Admin and Prefix Manager
	if (!allowedTo('prefix_manage'))
		fatal_lang_error('prefix_no_permission', false);	
	
    //Please check the prefix title , content and status
	$prefix = htmlspecialchars($_REQUEST['prefix'], ENT_QUOTES);
	
	// Load all the boards stuff
	$boardsArray = array();	
	
	if (isset($_REQUEST['boards'])){
	foreach ($_REQUEST['boards'] as $i => $v)
         if (!is_numeric($_REQUEST['boards'][$i])) unset($_REQUEST['boards'][$i]);	
	$id_boards = implode(',', $_REQUEST['boards']);
	}	
	
	if ($_REQUEST['boards'] == '')
		fatal_lang_error('prefix_no_boards',false);
		
	// We need the prefix
	if (empty($prefix))
		fatal_lang_error('prefix_no_pre',false);	

	// So , Load the permission for the prefix
	$permissionsArray = array();
	
	if (isset($_REQUEST['groups']))
	{
		foreach ($_REQUEST['groups'] as $rgroup)
			$permissionsArray[] = (int) $rgroup;
	}
	
	$final_permissions = implode(",",$permissionsArray);
		
	$smcFunc['db_insert']('replace',
			'{db_prefix}prefix',
			array(
				'prefix' => 'text', 'permissions' => 'text', 'id_boards' => 'text',
			),
			array(
				$prefix, $final_permissions, $id_boards,
			),
			array('prefix', 'permissions', 'id_boards')
	);	
	
    // Please redirectme to the admin panel
	redirectexit('action=admin;area=prefix;sa=admin;sesc='.$context['session_id'].'');
}

function prefix_edit()
{
	global $txt, $context, $smcFunc, $sourcedir, $board_info, $selected_boards, $scripturl, $sourcedir;
	
	// Check Permission for Admin and Prefix Manager
	if (!allowedTo('prefix_manage'))
		fatal_lang_error('prefix_no_permission', false);	
		
	// We need an ID!!	
	if (empty($_REQUEST['pid']))
		fatal_lang_error('prefix_no_selected', false);	
	
	// Get the ID, Sub-Template, Page Title and Language
	$prefixID = (int) $_REQUEST['pid'];		
	$context['sub_template']  = 'prefix_edit';
	$context['page_title'] = $txt['prefix_edit'];
	loadLanguage('Admin');	

	// Load the membergroups
	$dbresult = $smcFunc['db_query']('', '
    SELECT id_group, group_name
    FROM {db_prefix}membergroups
    WHERE min_posts = {int:primary_group}
      AND id_group <> {int:moderator}
      ORDER BY group_name',
      array(
         'primary_group' => -1,
         'moderator' => 3,
      )
    );
   
	$context['groups'] = array();
	while ($row = $smcFunc['db_fetch_assoc']($dbresult))
	{
		$context['groups'][$row['id_group']] = array(
			'id_group' => $row['id_group'],
			'group_name' => $row['group_name'],
			);
	}
	$smcFunc['db_free_result']($dbresult);	
	
	// Load the prefix info 
	$dbresult = $smcFunc['db_query']('', '
	SELECT 
		id_prefix, prefix, permissions, id_boards
	FROM {db_prefix}prefix
	WHERE id_prefix = {int:prefix_id}      
      LIMIT 1',
      array(
         'prefix_id' => $prefixID,        
      )
    );	
	$row = $smcFunc['db_fetch_assoc']($dbresult);
	$context['prefix_edit_info'] = $row;
	
	$smcFunc['db_free_result']($dbresult);
	
	// Load all the boards stuff	
	prefix_boards();	
	
	$boards_id = $context['prefix_edit_info']['id_boards'];

	if (isset($context['prefix_edit_info']['id_boards'])){ 
	foreach (explode(',', $context['prefix_edit_info']['id_boards']) as $i => $v)
     $selected_boards[$v] = $v;
	}	

    //Add the Linktree  
     $context['linktree'][] = array(		
		'name' => $txt['prefix_admin'],
		'url' => $scripturl.'?action=admin;area=prefix;sa=admin;'.$context['session_id'].'',
    );
	$context['linktree'][] = array(		
		    'name' => $row['prefix'],
	);		  		
    $context['linktree'][] = array(		   
		    'name' => $txt['prefix_edit3'],
	);		
}

function prefix_edit_verify()
{
	global $txt, $smcFunc, $sourcedir, $board_info, $board, $selected_boards;
	
	// Check Permission for Admin and Prefix Manager
	if (!allowedTo('prefix_manage'))
		fatal_lang_error('prefix_no_permission', false);	

	// We need an ID!!	  
	if (empty($_REQUEST['pid']))
		fatal_lang_error('prefix_no_selected', false);	
		
	// Get the prefix id , title , content , status and comments
	$prefixID = (int) $_REQUEST['pid'];
	$prefix = htmlspecialchars($_REQUEST['prefix'], ENT_QUOTES);
		
	// We are in troubles we need a title or content
    if (empty($prefix))
		fatal_lang_error('prefix_no_pre',false);
			
	// Load all the boards stuff
	$boardsArray = array();	
	
	if (isset($_REQUEST['boards'])){
	foreach ($_REQUEST['boards'] as $i => $v)
         if (!is_numeric($_REQUEST['boards'][$i])) unset($_REQUEST['boards'][$i]);	
	$id_boards = implode(',', $_REQUEST['boards']);
	}	
	
	if ($_REQUEST['boards'] == '')
		fatal_lang_error('prefix_no_boards',false);
		
	// Load Permissions
	$permissionsArray = array();
	
	if (isset($_REQUEST['groups']))
	{
		foreach ($_REQUEST['groups'] as $rgroup)
			$permissionsArray[] = (int) $rgroup;
	}
	
	$finalPermissions = implode(",",$permissionsArray);
	
	// Define all - Boards are numeric!
	$smcFunc['db_query']('', "
	UPDATE {db_prefix}prefix
	SET prefix = '$prefix', permissions = '$finalPermissions', id_boards = '$id_boards' 
	WHERE id_prefix = {int:prefix_id}
	LIMIT 1",
	array(
         'prefix_id' => $prefixID,        
      )
    );
				
	// Please redirectme to the new prefix
	redirectexit('action=admin;area=prefix;sa=admin');
}

function prefix_delete_verify()
{
	global $txt, $smcFunc, $context;
	
	// You can`t be here
	if (allowedTo('prefix') == false)
		fatal_lang_error('prefix_no_delete', false);
		
	// We need an ID!!	
	if (empty($_REQUEST['pid']))
		fatal_lang_error('prefix_no_selected', false);	
	
	// Get the id
	$prefixID = (int) $_REQUEST['pid'];
	
	// Delete the prefix info of the DB
	$smcFunc['db_query']('', '
	DELETE FROM {db_prefix}prefix  
	WHERE id_prefix = {int:prefix_id}
	LIMIT 1',
	array(
         'prefix_id' => $prefixID,        
      )
    );	
		
	// Please redirectme to the admin panel
	redirectexit('action=admin;area=prefix;sa=admin;sesc='.$context['session_id'].'');
}

function prefix_admin()
{
	global $sourcedir, $context, $txt, $boardurl, $boarddir, $scripturl, $smcFunc;	
	
	$context[$context['admin_menu_name']]['tab_data']['title'] = $txt['prefix_admin_title'];
	$context[$context['admin_menu_name']]['tab_data']['description'] = $txt['prefix_admin_description'];
 	
	// Load the Language
	if (loadLanguage('TopicPrefix') == false)
		loadLanguage('TopicPrefix','english');
		
    // Load a title
    $context['page_title'] = $txt['prefix_admin'];	

    // Load a subtemplate
	$context['sub_template']  = 'admin_prefix';	
	
	// You aren't admin?? Please you can`t be here
	if (!allowedTo('prefix_manage'))
	redirectexit();	
	
	// Load the Prefix
    $dbresult = $smcFunc['db_query']('', '
	SELECT 
		id_prefix, prefix, permissions, id_boards
	FROM {db_prefix}prefix
	ORDER BY id_prefix DESC'); 	
    
	$context['prefix'] = array();
	while ($row = $smcFunc['db_fetch_assoc']($dbresult))
	$context['prefix'][] = $row;
	$smcFunc['db_free_result']($dbresult);

    // Load the membergroups
	$dbresult = $smcFunc['db_query']('', '
    SELECT id_group, group_name
    FROM {db_prefix}membergroups
    WHERE min_posts = {int:primary_group}
      AND id_group <> {int:moderator}
      ORDER BY group_name',
      array(
         'primary_group' => -1,
         'moderator' => 3,
      )
    );
   
	$context['groups'] = array();
	while ($row = $smcFunc['db_fetch_assoc']($dbresult))
	{
		$context['groups'][$row['id_group']] = array(
			'id_group' => $row['id_group'],
			'group_name' => $row['group_name'],
			);
	}
	$smcFunc['db_free_result']($dbresult);
	
   //Add the Linktree
   $context['linktree'][] = array(		
		'name' => $txt['prefix_admin'],
		'url' => $scripturl.'?action=admin;area=prefix;sa=admin;'.$context['session_id'].'',
    );
}

function prefix_boards()
{
	global $smcFunc, $context, $user_info;
	
	// Based on the loadJumpTo() from SMF 1.1.X
	if (isset($context['jump_to']))
		return;

	// Find the boards/cateogories they can see.
	$request = $smcFunc['db_query']('', "
		SELECT c.name AS cat_name, c.id_cat, b.id_board, b.name AS board_name, b.child_level
		FROM {db_prefix}boards AS b
			LEFT JOIN {db_prefix}categories AS c ON (c.id_cat = b.id_cat)
		WHERE $user_info[query_see_board]"
		);
		
	$context['jump_to'] = array();
	$this_cat = array('id' => -1);
	while ($row = $smcFunc['db_fetch_assoc']($request))
	{
		if ($this_cat['id'] != $row['id_cat'])
		{
			$this_cat = &$context['jump_to'][];
			$this_cat['id'] = $row['id_cat'];
			$this_cat['name'] = $row['cat_name'];
			$this_cat['boards'] = array();
		}

		$this_cat['boards'][] = array(
			'id' => $row['id_board'],
			'name' => $row['board_name'],
			'child_level' => $row['child_level'],
			'is_current' => isset($context['current_board']) && $row['id_board'] == $context['current_board']
		);
	}
	$smcFunc['db_free_result']($request);
}

function prefix_version()
{
	global $context, $txt, $scripturl;

	$context[$context['admin_menu_name']]['tab_data']['title'] = $txt['prefix_version'];
	$context[$context['admin_menu_name']]['tab_data']['description'] = $txt['prefix_version_description'];
	
	$context['page_title'] = $txt['prefix_version'];
	$context['sub_template'] = 'prefix_version';	
	
	 //Add the Linktree
   $context['linktree'][] = array(		
		'name' => $txt['prefix_admin'],
		'url' => $scripturl.'?action=admin;area=prefix;sa=admin;'.$context['session_id'].'',
    );
	$context['linktree'][] = array(		
		'name' => $txt['prefix_version'],
		'url' => $scripturl.'?action=admin;area=prefix;sa=version',
    );
}	
?>