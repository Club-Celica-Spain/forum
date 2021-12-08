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
	
function load_membergroups_edit($id_array)
{
	global $smcFunc, $context, $txt;
	
	$id_array2 = explode(",",$id_array);
	
	$sql = $smcFunc['db_query']('','
		SELECT id_group, group_name 
		FROM {db_prefix}membergroups 
		ORDER BY id_group DESC
	');
	
	$groups = array();
	
	while($row = $smcFunc['db_fetch_assoc']($sql))
		$groups[] = array(
			'id' => $row['id_group'],
			'name' => $row['group_name']
		);
	
	$context['all_checked'] = true;
	
	echo'<input type="checkbox" value="-1" name="groups_allowed[-1]" ',(in_array(-1,$id_array2) == 1) ? 'checked="checked"' : '' ,' /> '.$txt['adk_admin_pages_guest'].'<br />';
	
	//mmm
	if(!(in_array(-1,$id_array2) == 1))
		$context['all_checked'] = false;
	
	foreach($groups AS $g)
	{
		echo'<input type="checkbox" value="'.$g['id'].'" name="groups_allowed['.$g['id'].']" ',in_array($g['id'],$id_array2) ? 'checked="checked"' : '' ,' /> '.$g['name'].'<br />';
		
		if(!in_array($g['id'],$id_array2))
			$context['all_checked'] = false;
	}

	$smcFunc['db_free_result']($sql);
}

function analizar_type($type, $body)
{
	if ($type == 'bbc')
		echo parse_bbc($body);
	elseif ($type == 'html')
		echo un_htmlspecialchars($body);
	elseif ($type == 'php')
	{
		$body = trim($body);
		$body = trim($body, '<?php');
		$body = trim($body, '?>');
		eval($body);
	}
}


function permission_groups_other_pages($id_array)
{
	global $context, $user_info, $smcFunc;
	global $memberContext;
	
	//$visit = false;
	
	$id_array = explode(',',$id_array);
	$i = count($id_array);
	//$id_array[$i] = 1;
	
	$id_member = $user_info['id'];
	
	loadMemberData($id_member);
	loadMemberContext($id_member);

	$id_group_member = $memberContext[$id_member]['group_id'];
	
	if($id_group_member == 0)
	{
		$sql = $smcFunc['db_query']('','SELECT id_post_group FROM {db_prefix}members WHERE id_member = {int:member}',array('member' => $id_member,));
		$row = $smcFunc['db_fetch_assoc']($sql);
		$id_group_member = $row['id_post_group'];
		$smcFunc['db_free_result']($sql);
	}
	
	if(empty($id_group_member))
		$id_group_member = -1;
		
	if(!in_array($id_group_member, $id_array))
		fatal_lang_error('error_adk_not_allowed', false);
}

//Ultimas actualizaciones
function getAdkNews()
{
	global $sourcedir;
	
	//I need this file
	require_once($sourcedir.'/Subs-Package.php');
	
	//Load from our site
	$news = fetch_web_data("http://www.smfpersonal.net/news.txt");
	
	echo $news;
}

function getCurrentversion()
{
	global $sourcedir;
	
	//Load again -.-
	require_once($sourcedir.'/Subs-Package.php');
	$version = fetch_web_data("http://smfpersonal.net/news/adk-portal-version.txt");
	
	return $version;
}

function getYourversion()
{
	//Hey baby... What's our version?
	$version = '2.1.1';
	
	return $version;
}

function getCheckbox($variable)
{
	global $adkportal;
	
	if ($adkportal[$variable] == 1)
		echo 'checked="checked"';
	    
}

function changeAdkBuffer($buffer)
{
	global $adkportal, $forum_copyright, $context, $txt;
	
	$load = base64_decode($adkportal['variables_important']);
	
	if(empty($load))
	{
		$version = getYourversion();
		$load = $adkportal['copy'];
	}
	
	$buffer = str_replace($forum_copyright,$forum_copyright.$load,$buffer);
	
	$re_new = $load.$load;
	
	if(!empty($context['adk_stand_alone']))
		$buffer = str_replace($re_new,$load,$buffer);
	
	//Adk Portal Blocks admin
	if(!empty($_REQUEST['action']) && $_REQUEST['action'] == 'admin' && !empty($_REQUEST['area']) && $_REQUEST['area'] == 'blocks')
		$buffer = str_replace('<td class="windowbg adk_10" style="text-align: center;">(include)</td>','<td class="windowbg adk_10" style="text-align: center;">('.$txt['adk_block_include'].')</td>',$buffer);
	
	return $buffer;
}

function adk_admin_copyright()
{
//Function REMOVED	
}

function analizar_selected_adk($variable, $value)
{
	global $adkportal;
	
	if($adkportal[$variable] == $value)
		echo'selected="selected"';
}

function adkportalSettings($stand_alone_mode = false)
{
	global $smcFunc, $adkportal, $sourcedir, $boarddir, $context, $boardurl, $scripturl;
	
	$re_ = ' '.getYourversion();
	
	$version = empty($adkportal['adk_hide_version']) ? $re_ : '';
	//Load Info From Smf Personal
	$adkportal['load_Info_FromSmfPersonal'] = 'http://www.smfpersonal.net/news/adk_2.0rc5.txt';
	
	//The copyright
	$adkportal['copy'] = '<br /><a href="http://www.smfpersonal.net" target="_blank">Adk Portal'.$version.' &copy; 2009-2011</a>';
	
	//Load Table Settings... Oh my god, Not smf_settings ;) smf_adk_settings ^^
	$query = $smcFunc['db_query']('','
		SELECT variable, value
		FROM {db_prefix}adk_settings'
	);
	
	while($row = $smcFunc['db_fetch_assoc']($query))
		$adkportal[$row['variable']] = $row['value'];
	
	$smcFunc['db_free_result']($query);
	
	//Creating a simple variable
	$adkportal['variables_important'] = 'IHwgPGEgaHJlZj0ieyRzY3JpcHR1cmx9P2FjdGlvbj1hZGtfY3JlZGl0cyI+QWRrIFBvcnRhbCB7JHZlcnNpb259PC9hPiAmY29weTsgPGEgaHJlZj0iaHR0cDovL3d3dy5zbWZwZXJzb25hbC5uZXQiIHRhcmdldD0iX2JsYW5rIj5TTUYgcGVyc29uYWw8L2E+';
	
	//Replace
	$replace = array(
		'{$scripturl}' => $scripturl,
	);
	
	//Reeplace version?
	if(empty($adkportal['adk_hide_version']))
		$to_replace = $re_;
	else
		$to_replace = '';
		
	$replace += array(
		' {$version}' => $to_replace,
	);
	
	$adkportal['variables_important'] = base64_decode($adkportal['variables_important']);
	
	foreach($replace AS $i => $v)
		$adkportal['variables_important'] = str_replace($i,$v,$adkportal['variables_important']);
	
	//rewriting
	$adkportal['variables_important'] = base64_encode($adkportal['variables_important']);
	
	
	//Smileys path
	$adkportal['smileys_url'] = $boardurl.'/adkportal/smileys';
	
	$current = 'portal';
	
	if(!empty($_REQUEST['action']) && $_REQUEST['action'] != 'portal' && $_REQUEST['action'] != '' || !empty($_REQUEST['topic']) || !empty($_REQUEST['board']) || !empty($_REQUEST['blog']))
		$current = 'other';
	
	$current_action = '';
	if((!empty($_REQUEST['action'])) || !empty($_REQUEST['topic']) || !empty($_REQUEST['board']) || !empty($_REQUEST['blog']))
		$current_action = 'action';
	
	if(empty($adkportal['adk_enable']))
		$current_action = 'action';
		
	//Check if your use adk portal in this moment ;)!
	$adkportal['use_adkportal_now'] = false;
	
	if(($stand_alone_mode) || ($current == 'portal') || ((!empty($adkportal['enable_right_forum']) || !empty($adkportal['enable_left_forum']) || !empty($adkportal['enable_top_forum']) || !empty($adkportal['enable_bottom_forum'])) && !empty($current_action)))
	{
		require_once($sourcedir.'/Subs-adkblocks.php');
		require_once($boarddir.'/SSI.php');
		
		//Check if your use adk portal in this moment ;) NOW!
		$adkportal['use_adkportal_now'] = true;

		$sql = $smcFunc['db_query']('','
			SELECT id,echo, name AS title, img, type, columna, empty_body, empty_title, empty_collapse,permissions
			FROM {db_prefix}adk_blocks 
			WHERE activate = {int:activate}
			ORDER BY orden',
			array(
				'activate' => 1,
			)
		);
		
		//The Misterious array
		$adkportal['left'] = array();
		$adkportal['center'] = array();
		$adkportal['right'] = array();
		$adkportal['top'] = array();
		$adkportal['bottom'] = array();
		
		while($row = $smcFunc['db_fetch_assoc']($sql))
		{
			$row['title'] = parse_if_utf8($row['title']);
			
			if($row['columna'] == 1)
				$adkportal['left'][] = array(
					'id' => $row['id'],
					'echo' => un_htmlspecialchars($row['echo']),
					'title' => $row['title'],
					'img' => $row['img'],
					'type' => $row['type'],
					'b' => $row['empty_body'],
					't' => $row['empty_title'],
					'c' => $row['empty_collapse'],
					'p' => $row['permissions'],
				);
			elseif($row['columna'] == 2)
				$adkportal['center'][] = array(
					'id' => $row['id'],
					'echo' => un_htmlspecialchars($row['echo']),
					'title' => $row['title'],
					'img' => $row['img'],
					'type' => $row['type'],
					'b' => $row['empty_body'],
					't' => $row['empty_title'],
					'c' => $row['empty_collapse'],
					'p' => $row['permissions'],
				);
			elseif($row['columna'] == 3)
				$adkportal['right'][] = array(
					'id' => $row['id'],
					'echo' => un_htmlspecialchars($row['echo']),
					'title' => $row['title'],
					'img' => $row['img'],
					'type' => $row['type'],
					'b' => $row['empty_body'],
					't' => $row['empty_title'],
					'c' => $row['empty_collapse'],
					'p' => $row['permissions'],
				);
			elseif($row['columna'] == 4)
				$adkportal['top'][] = array(
					'id' => $row['id'],
					'echo' => un_htmlspecialchars($row['echo']),
					'title' => $row['title'],
					'img' => $row['img'],
					'type' => $row['type'],
					'b' => $row['empty_body'],
					't' => $row['empty_title'],
					'c' => $row['empty_collapse'],
					'p' => $row['permissions'],
				);
			elseif($row['columna'] == 5)
				$adkportal['bottom'][] = array(
					'id' => $row['id'],
					'echo' => un_htmlspecialchars($row['echo']),
					'title' => $row['title'],
					'img' => $row['img'],
					'type' => $row['type'],
					'b' => $row['empty_body'],
					't' => $row['empty_title'],
					'c' => $row['empty_collapse'],
					'p' => $row['permissions'],
				);
			
		}
		
		$smcFunc['db_free_result']($sql);
	}
	
}

function adk_standAloneMode($standalone = false)
{
	global $context, $adkportal, $txt, $scripturl;
	
	$context['adk_stand_alone'] = $standalone;
	
	//Esto no tiene nada que ver con el modo Stand Alone
	
	/*DELETE I DON'T NEED IT
	if(isset($_SESSION['adk_style']))
		$adkportal['title_in_blocks'] = $_SESSION['adk_style'];
	
	if(!empty($_REQUEST['adk_style'])){
		$adkportal['title_in_blocks'] = (int)$_REQUEST['adk_style'];
		
		if($adkportal['title_in_blocks'] > 6 || $adkportal['title_in_blocks'] < 1)
			$adkportal['title_in_blocks'] = 1;
		
		$_SESSION['adk_style'] = $adkportal['title_in_blocks'];
	}
	*/
}

function updateSettingsAdkPortal($arraySettings)
{
	global $smcFunc, $adkportal;
	
	foreach($arraySettings AS $variable => $value)
	{
		if(isset($adkportal[$variable]))
			$smcFunc['db_query']('','
				UPDATE {db_prefix}adk_settings
				SET value = {text:value}
				WHERE variable = {text:variable}',
				array(
					'value' => $value,
					'variable' => $variable,
				)
			);
		else
			$smcFunc['db_query']('','
				INSERT IGNORE INTO {db_prefix}adk_settings
				(variable,value) VALUES ({text:variable},{text:value})',
				array(
					'variable' => $variable,
					'value' => $value,
				)
			);
	}
}

/*******************************************
* Replace file_put_contents()
 Aidan Lister <aidan@php.net>
********************************************/
if(!function_exists('php_compat_file_put_contents')){
	function php_compat_file_put_contents($filename, $content, $flags = null, $resource_context = null)
	{
		$oldlevel = error_reporting(0);
		// If $content is an array, convert it to a string
		if (is_array($content))
		{
			$content = implode('', $content);
		}
		 
		// If we don't have a string, throw an error
		if (!is_scalar($content))
		{
			user_error('file_put_contents() The 2nd parameter should be either a string or an array',
				E_USER_WARNING);
			return false;
		}
		 
		// Get the length of data to write
		$length = strlen($content);
		 
		// Check what mode we are using
		$mode = ($flags & FILE_APPEND) ? 'a' :
		'wb';
		 
		// Check if we're using the include path
		$use_inc_path = ($flags & FILE_USE_INCLUDE_PATH) ? true :
		false;
		 
		// Open the file for writing
		if (($fh = @fopen($filename, $mode, $use_inc_path)) === false)
		{
			user_error('file_put_contents() failed to open stream: Permission denied',
				E_USER_WARNING);
			return false;
		}
		 
		// Attempt to get an exclusive lock
		$use_lock = ($flags & LOCK_EX) ? true :
		false ;
		if ($use_lock === true)
		{
			if (!flock($fh, LOCK_EX))
			{
				return false;
			}
		}
		 
		// Write to the file
		$bytes = 0;
		if (($bytes = @fwrite($fh, $content)) === false)
		{
			$errormsg = sprintf('file_put_contents() Failed to write %d bytes to %s',
				$length,
				$filename);
			user_error($errormsg, E_USER_WARNING);
			return false;
		}
			 
		// Close the handle
		@fclose($fh);
			 
		// Check all the data was written
		if ($bytes != $length)
		{
			$errormsg = sprintf('file_put_contents() Only %d of %d bytes written, possibly out of free disk space.',
				$bytes,
				$length);
			user_error($errormsg, E_USER_WARNING);
			return false;
		}
		 
			return $bytes;
	}
}

// Define - SD Seo uses this function
if(!function_exists('file_put_contents'))
{
    function file_put_contents($filename, $content, $flags = null, $resource_context = null)
    {
        return php_compat_file_put_contents($filename, $content, $flags, $resource_context);
	}
}

function changeurlpagesAdkportal($page)
{
	global $boardurl;
	
	//Rewrite System
	$path = 'pages/';
	
	//The perfect url
	$totalurl = $path.$page.'.html';
	
	//Return me
	return $totalurl;
}

function changeCatUrl($id)
{
	global $smcFunc, $context;
	
	if(isset($context['rewrite_adk']['cat'][$id]))
		$title = $context['rewrite_adk']['cat'][$id];
	else
	{
		$sql = $smcFunc['db_query']('','
			SELECT title
			FROM {db_prefix}adk_down_cat
			WHERE id_cat = {int:cat}',
			array(
				'cat' => $id,
			)
		);
		
		$row = $smcFunc['db_fetch_assoc']($sql);
		$smcFunc['db_free_result']($sql);
		
		$title = $row['title'];
	}
	
	if(empty($title))
		$title = 'empty';
	
	$title = strtolower(SimpleReplace($title));
	
	return 'cat/'.$id.'-'.$title.'.html';

}
		
function changeDownloadUrl($id)
{
	global $smcFunc, $smcFunc;
	
	if(isset($context['rewrite_adk']['download'][$id]))
		$title = $context['rewrite_adk']['download'][$id];
	else
	{
		$sql = $smcFunc['db_query']('','
			SELECT title
			FROM {db_prefix}adk_down_file
			WHERE id_file = {int:file}',
			array(
				'file' => $id,
			)
		);
		
		$row = $smcFunc['db_fetch_assoc']($sql);
		$smcFunc['db_free_result']($sql);
		
		$title = $row['title'];
	}
	
	if(empty($title))
		$title = 'empty';
	
	
	$title = strtolower(SimpleReplace($title));
	
	return 'down/'.$id.'-'.$title.'.html';

}

//Remove some signs....
function SimpleReplace($variable)
{
	$split = '-';

	$other = array('á','é','í','ó','ú','Á','É','Í','Ó','Ú','Ñ','ñ',);
	$other2 = array('a','e','i','o','u','A','E','I','O','U','N','n',);
	
	$var = str_replace($other,$other2,$variable);
	
	$again = array('"','!','ª','$','%','&','/','(',')','?','¿','Ç','-','.',';',',','´','+','`',"\\",'#',);
	$var = str_replace($again,"",$var);
	
	$o = array('   ','  ',);
	$var = str_replace($o,' ',$var);
	
	$var = str_replace(' ',$split,$var);
	
	return $var;
	
}
	
//This jump to is from SMF 1
function loadJumpTosmf1ByAlper()
{
	global $context, $user_info, $smcFunc;

	if (isset($context['jump_to']))
		return;

	// Find the boards/cateogories they can see.
	$request = $smcFunc['db_query']('','
		SELECT c.name AS catName, c.id_cat, b.id_board, b.name AS boardName, b.child_level
		FROM {db_prefix}boards AS b
		LEFT JOIN {db_prefix}categories AS c ON (c.id_cat = b.id_cat)
		WHERE '.$user_info['query_see_board']
	);
	
	$context['jump_to'] = array();
	$this_cat = array('id' => -1);
	
	//While....
	while ($row = $smcFunc['db_fetch_assoc']($request))
	{
		if ($this_cat['id'] != $row['id_cat'])
		{
			$this_cat = &$context['jump_to'][];
			$this_cat['id'] = $row['id_cat'];
			$this_cat['name'] = $row['catName'];
			$this_cat['boards'] = array();
		}

		$this_cat['boards'][] = array(
			'id' => $row['id_board'],
			'name' => $row['boardName'],
			'child_level' => $row['child_level'],
			'is_current' => isset($context['current_board']) && $row['id_board'] == $context['current_board']
		);
	}
	
	$smcFunc['db_free_result']($request);
}	
	
function loadCTop()
{	
	global $user_info, $options, $adkportal, $txt, $settings, $context;
	
	$current_action = '';
	if((!empty($_REQUEST['action'])) || !empty($_REQUEST['topic']) || !empty($_REQUEST['board']) || !empty($_REQUEST['blog']))
		$current_action = 'action';
	
	if(empty($adkportal['adk_enable']))
		$current_action = 'action';
	
	//the_change
	$left_image = (($user_info['is_guest'] ? !empty($_COOKIE['adk_left']) : !empty($options['adk_left'])) ? 'expand.gif' : 'collapse.gif');
	$right_image = (($user_info['is_guest'] ? !empty($_COOKIE['adk_right']) : !empty($options['adk_right'])) ? 'expand.gif' : 'collapse.gif');
	
	//fixing some errors
	$txt['colapse_left2'] = !empty($txt['colapse_left2']) ? $txt['colapse_left2'] : '';
	
	$colapse_left = '
		<span onclick="adkcollapse(1,\'adklcolapse\')" class="adk_pointer">
			<span id="adklcolapse">
				<img alt="'.$txt['colapse_left2'].'" title="'.$txt['colapse_left2'].'" src="'.$settings['images_url'].'/'.$left_image.'" />
			</span>
		</span>';
			
			
	$colapse_right = '
		<span onclick="adkcollapse(2,\'adkrcolapse\')" class="adk_pointer">
			<span id="adkrcolapse">	
				<img alt="'.$txt['colapse_left2'].'" title="'.$txt['colapse_left2'].'" src="'.$settings['images_url'].'/'.$right_image.'" />
			</span>		
		</span>	';
	
	
	echo'
		<div class="smalltext adk_pointer adk_float_r">';
	if(($adkportal['cleft'] == 1 && !empty($adkportal['adk_enable']) && empty($current_action)) || ($adkportal['cleft'] == 1 && !empty($adkportal['enable_left_forum']) && !empty($current_action)))
		echo !empty($_REQUEST['page']) ? '' : $colapse_left;

	if(($adkportal['cright'] == 1 && !empty($adkportal['adk_enable']) && empty($current_action)) || ($adkportal['cleft'] == 1 && !empty($adkportal['enable_right_forum']) && !empty($current_action)))
		echo !empty($_REQUEST['page']) ? '' : $colapse_right;
	
	if(!empty($_REQUEST['page']) && $context['page_view_content']['load_my_left'])
		echo $colapse_left;
	
	if(!empty($_REQUEST['page']) && $context['page_view_content']['load_my_right'])
		echo $colapse_right;
		
	echo'	
		</div><br />
		<div class="adk_height_1"></div>';
	
	
	$width_center = 100;
	
	if(!empty($adkportal['enable_left_forum']))
		$width_center = $width_center - $adkportal['wleft'];
	if(!empty($adkportal['enable_right_forum']))
		$width_center = $width_center - $adkportal['wright'];
	
	
	if(!empty($adkportal['enable_top_forum']) && !empty($current_action))
		columntop();
	
	if(((!empty($adkportal['enable_right_forum']) || !empty($adkportal['enable_left_forum'])) && !empty($current_action)) || ($adkportal['adk_enable'] == 2 && empty($context['adk_stand_alone'])))
	{
		echo'
		<table class="adk_100">
			<tr>';
			if(!empty($adkportal['enable_left_forum']))
			echo'
				<td id="adk_left" valign="top" style="width:',$adkportal['wleft'],';'. (($user_info['is_guest'] ? !empty($_COOKIE['adk_left']) : !empty($options['adk_left'])) ? ' display: none;' : '') .'" class="adk_padding_5_r">
					',columnleft(),'
				</td>';
			echo'
				<td valign="top">';
	}

	
}

function loadCBottom()
{
	global $adkportal, $smcFunc, $user_info, $options;	
	
	$current_action = '';
	
	if((!empty($_REQUEST['action'])) || !empty($_REQUEST['topic']) || !empty($_REQUEST['board']) || !empty($_REQUEST['blog']))
		$current_action = 'action';
	
	if(empty($adkportal['adk_enable']))
		$current_action = 'action';
	
	if(((!empty($adkportal['enable_right_forum']) || !empty($adkportal['enable_left_forum'])) && !empty($current_action)) || ($adkportal['adk_enable'] == 2 && empty($context['adk_stand_alone'])))
	{
		echo'</td>';
   
		if(!empty($adkportal['enable_right_forum']))
		echo'
			<td id="adk_right" valign="top" style="width:',$adkportal['wright'],';'. (($user_info['is_guest'] ? !empty($_COOKIE['adk_right']) : !empty($options['adk_right'])) ? ' display: none;' : '') .'" class="adk_padding_5_l">
				',columnright(),'
			</td>';
   
   
		echo'
		</tr></table>';
	}
	
	if(!empty($adkportal['enable_bottom_forum']) && !empty($current_action)){
		echo'<br />';
		columnbottom();
	}
	
}		
function load_AvdImage($watermark = '', $image, $extension, $style, $imagen_name)
{
	global $boarddir;
	
	$font = $boarddir.'/Themes/default/fonts/Forgottb.ttf';
	
	if($extension == 'jpg' || $extension == 'jpeg' || $extension == 'JPG' || $extension == 'JPEG')
		$extension = 'jpg';
	
	//$imagen_name = $boarddir.'/adkportal/images/'.time().'.JPG';
	
	$padding_left = 0;
	$padding_top = 0;
	
	//Makeme a new extension
	$size = getimagesize($image);

	switch ($size['mime']) {
		case "image/gif":
			$extension = 'gif';
			break;
		case "image/jpeg":
			$extension = 'jpg';
			break;
		case "image/png":
			$extension = 'png';
			break;
	}
	
	if($extension == 'gif')
		$create = imagecreatefromgif($image);
	if($extension == 'jpg')
		$create = imagecreatefromjpeg($image);
	if($extension == 'png')
		$create = imagecreatefrompng($image);
	
	if($style == 1)
	{
		$background = '';
		$width = imagesx($create);
		$height = imagesy($create);
		$width_image = $width;
		$height_image = $height;
		$letter = 13;
		$position_watermark = 0;
		$vertical = 200;
		$horizontal = 10;
	}
	elseif($style == 6)
	{
		$background = '';
		$width_image = imagesx($create);
		$height_image = imagesy($create);
		$width = 180;
		$height = 180 * $height_image / $width_image;
		$letter = 13;
		$position_watermark = 0;
		$vertical = 200;
		$horizontal = 10;
	}
	elseif($style == 7)
	{
		$background = '';
		$width_image = imagesx($create);
		$height_image = imagesy($create);
		$width = 50;
		$height = 50 * $height_image / $width_image;
		$letter = 13;
		$position_watermark = 0;
		$vertical = 200;
		$horizontal = 10;
	}
	elseif($style == 2)
	{
		$background = $boarddir.'/adkportal/images/portfolioBox.png';
		$width = 177;
		$height = 188;
		$width_image = imagesx($create);
		$height_image = imagesy($create);
		$padding_left = 17;
		$padding_top = 11;
		$letter = 13;
		$position_watermark = 0;
		$vertical = 200;
		$horizontal = 10;
	}
	elseif($style == 3)
	{
		$background = $boarddir.'/adkportal/images/caja.png';
		$width= 303; 
		$height = 426; 
		$width_image = imagesx($create);
		$height_image = imagesy($create);
		$padding_left = 60;
		$padding_top = 15;
		$letter = 16;
		$position_watermark = 90;
		$vertical = 150;
		$horizontal = 54;
	}
	elseif($style == 4)
	{
		$background = $boarddir.'/adkportal/images/caratulaps3.png';
		$width= 370; 
		$height = 461; 
		$width_image = imagesx($create);
		$height_image = imagesy($create);
		$padding_left = 30;
		$padding_top = 0;
		$letter = 16;
		$position_watermark = 0;
		$vertical = 20;
		$horizontal = 30;
	}
	elseif($style == 5)
	{
		$background = $boarddir.'/adkportal/images/caratulaxbox.png';
		$width= 400; 
		$height = 500; 
		$width_image = imagesx($create);
		$height_image = imagesy($create);
		$padding_left = 0;
		$padding_top = 64;
		$letter = 28;
		$position_watermark = 45;
		$vertical = 480;
		$horizontal = 240;
	}
	elseif($style == 8)
	{
		$background = $boarddir.'/adkportal/images/dvd8.png';
		$width = 335;
		$height = 496;
		$width_image = imagesx($create);
		$height_image = imagesy($create);
		$padding_left = 50;
		$padding_top = 13;
		$letter = 28;
		$position_watermark = 90;
		$vertical = 508;
		$horizontal = 45;
	}
	
	
	$final = imagecreatetruecolor($width, $height);
	imagecopyresampled($final, $create, 0, 0, 0, 0, $width, $height, $width_image, $height_image);
	
	if($style == 2 || $style == 3 || $style == 4 || $style == 5 || $style == 8)
	{
		$new = imagecreatefrompng($background);
		imagecopymerge($new, $final, $padding_left, $padding_top, 0, 0, $width, $height, 100);		
		
		if(!empty($watermark))
		{
			$return = imagecolorallocate($new, 0, 0, 0);
			imagettftext($new, $letter, $position_watermark, $horizontal , $vertical , $return, $font, $watermark);
		}
		imagealphablending($new, true);
		imagesavealpha($new, true);				
		imagepng($new,$imagen_name);
		//imagejpeg($new,$imagen_name);
		imagedestroy($create);
		imagedestroy($new);
	}
	elseif($style == 1 || $style == 6 || $style == 7)
	{	
		imagealphablending($final, true);
		imagesavealpha($final, true);			
		//imagepng($final);
		imagejpeg($final,$imagen_name);
		imagedestroy($create);
	}
}

function find_modSettings_style_top($title, $img = false, $id_block = false, $b = 0, $t = 0, $c = 0)
{
	global $adkportal, $boardurl, $user_info, $options, $settings;
	
	$load = !empty($img) && !empty($adkportal['enable_img_blocks']) ? '<img class="adk_vertical" src="'.$boardurl.'/adkportal/images/blocks/'.$img.'" alt="" />&nbsp;' : '';
	
	if($adkportal['title_in_blocks'] == 6)
	{
		if($t == 0)
		{
			echo'
			<div class="cat_bar"><h3 class="catbg">
				<span class="adk_font">
					'.$load.$title.'
				</span>';
		}
		
		if($c == 0)
		echo'
		<span onclick="adkBlock(\''. $id_block .'\',\'image_collapse_'. $id_block .'\')" class="adk_pointer">
			'.  (($user_info['is_guest'] ? !empty($_COOKIE['adk_block_'. $id_block]) : !empty($options['adk_block_'. $id_block])) ? '<img id="image_collapse_'. $id_block .'" src="'.$settings['images_url'].'/expand.gif" alt="+" border="0" class="collapse2" />' : '<img id="image_collapse_'. $id_block .'" src="'.$settings['images_url'].'/collapse.gif" alt="-" border="0" class="collapse2" />') .'
		</span>';
		
		if($t == 0)
		{
			echo'
			</h3></div>';
		}
		
		echo'
			<div class="adk_7"></div>
			<div class="my_blocks" id="adk_block_'. $id_block .'" '. (($user_info['is_guest'] ? !empty($_COOKIE['adk_block_'.$id_block]) : !empty($options['adk_block_'.$id_block])) ? ' style="display: none;"' : '') .'>';
	}
	
	if($adkportal['title_in_blocks'] == 1 || $adkportal['title_in_blocks'] == 7)
	{
		$define = $adkportal['title_in_blocks'] == 1 ? 'cat' : 'title';
		
		if($t == 0)
		{
			echo'
			<div class="'.$define.'_bar"><h3 class="'.$define.'bg">
				<span class="adk_font">
					'.$load.$title.'
				</span>';
		}
		
		if($c == 0)
		echo'
		<span onclick="adkBlock(\''. $id_block .'\',\'image_collapse_'. $id_block .'\')" class="adk_pointer">
			'.  (($user_info['is_guest'] ? !empty($_COOKIE['adk_block_'. $id_block]) : !empty($options['adk_block_'. $id_block])) ? '<img id="image_collapse_'. $id_block .'" src="'.$settings['images_url'].'/expand.gif" alt="+" border="0" class="collapse2" />' : '<img id="image_collapse_'. $id_block .'" src="'.$settings['images_url'].'/collapse.gif" alt="-" border="0" class="collapse2" />') .'
		</span>';
		
		if($t == 0)
		{
			echo'
			</h3></div>';
		}

		echo'
				<div class="my_blocks" id="adk_block_'. $id_block .'" '. (($user_info['is_guest'] ? !empty($_COOKIE['adk_block_'.$id_block]) : !empty($options['adk_block_'.$id_block])) ? ' style="display: none;"' : '') .'>
				',$b == 0 ? '<span class="clear upperframe"><span></span></span>
					<div class="roundframe">
						<div class="adk_min_height">' : '';
	}
	
	elseif($adkportal['title_in_blocks'] == 2 || $adkportal['title_in_blocks'] == 8)
	{
		$define = $adkportal['title_in_blocks'] == 2 ? 'cat' : 'title';
		
		echo'
		
				',$b == 0 ? '<span class="clear upperframe"><span></span></span>
					<div class="roundframe">
						<div class="adk_min_height">' : '';
		
		if($t == 0)
			echo'
			<div class="'.$define.'_bar"><h3 class="'.$define.'bg">
				<span class="adk_font">
					'.$load.$title.'
				</span>';
		
		
		if($c == 0)
			echo'
			<span onclick="adkBlock(\''. $id_block .'\',\'image_collapse_'. $id_block .'\')" class="adk_pointer">
				'.  (($user_info['is_guest'] ? !empty($_COOKIE['adk_block_'. $id_block]) : !empty($options['adk_block_'. $id_block])) ? '<img id="image_collapse_'. $id_block .'" src="'.$settings['images_url'].'/expand.gif" alt="+" border="0" class="collapse2" />' : '<img id="image_collapse_'. $id_block .'" src="'.$settings['images_url'].'/collapse.gif" alt="-" border="0" class="collapse2" />') .'
			</span>';
		
		if($t == 0)
			echo'
			</h3></div>
			<div class="adk_7"></div>';
		
		
		echo'
			<div class="my_blocks" id="adk_block_'. $id_block .'" '. (($user_info['is_guest'] ? !empty($_COOKIE['adk_block_'.$id_block]) : !empty($options['adk_block_'.$id_block])) ? ' style="display: none;"' : '') .'>
							';
	}
		
	elseif($adkportal['title_in_blocks'] == 3)
	{
		if($t == 0)
		{
			echo'
			<div class="cat_bar"><h3 class="catbg">
				<span class="adk_font">
					'.$load.$title.'
				</span>';
		}
		
		if($c == 0)
		echo'
		<span onclick="adkBlock(\''. $id_block .'\',\'image_collapse_'. $id_block .'\')" class="adk_pointer">
			'.  (($user_info['is_guest'] ? !empty($_COOKIE['adk_block_'. $id_block]) : !empty($options['adk_block_'. $id_block])) ? '<img id="image_collapse_'. $id_block .'" src="'.$settings['images_url'].'/expand.gif" alt="+" border="0" class="collapse2" />' : '<img id="image_collapse_'. $id_block .'" src="'.$settings['images_url'].'/collapse.gif" alt="-" border="0" class="collapse2" />') .'
		</span>';
		
		if($t == 0)
		{
			echo'
			</h3></div>';
		}
		
		echo'
				<div class="my_blocks" id="adk_block_'. $id_block .'" '. (($user_info['is_guest'] ? !empty($_COOKIE['adk_block_'.$id_block]) : !empty($options['adk_block_'.$id_block])) ? ' style="display: none;"' : '') .'>
				',$b == 0 ? '<div class="windowbg adk_min_height"><span class="topslice"><span></span></span>' : '' ,'
					<div class="allpadding_simple">';
	}
	elseif($adkportal['title_in_blocks'] == 4)
	{
		echo'
		
				',$b == 0 ? '<div class="windowbg"><span class="topslice"><span></span></span>' : '' ,'
					<div class="allpadding adk_min_height">';
		
		if($t == 0)
		{
			echo'
			<div class="cat_bar"><h3 class="catbg">
				<span class="adk_font">
					'.$load.$title.'
				</span>';
		}
		
		if($c == 0)
			echo'
			<span onclick="adkBlock(\''. $id_block .'\',\'image_collapse_'. $id_block .'\')" class="adk_pointer">
				'.  (($user_info['is_guest'] ? !empty($_COOKIE['adk_block_'. $id_block]) : !empty($options['adk_block_'. $id_block])) ? '<img id="image_collapse_'. $id_block .'" src="'.$settings['images_url'].'/expand.gif" alt="+" border="0" class="collapse2" />' : '<img id="image_collapse_'. $id_block .'" src="'.$settings['images_url'].'/collapse.gif" alt="-" border="0" class="collapse2" />') .'
			</span>';
		
		if($t == 0)
		{
			echo'
			</h3></div>';
		}
		
		echo'
			<div class="my_blocks" id="adk_block_'. $id_block .'" '. (($user_info['is_guest'] ? !empty($_COOKIE['adk_block_'.$id_block]) : !empty($options['adk_block_'.$id_block])) ? ' style="display: none;"' : '') .'>';
	}	
	elseif($adkportal['title_in_blocks'] == 5)
	{
		
		
		if($t == 0)
		{
			echo'
			<div class="cat_bar adk_little_round">
				<h3 class="catbg">
				<span class="adk_font">
						'.$load.$title.'
				</span>';
		}
		
		if($c == 0)
			echo'
			<span onclick="adkBlock(\''. $id_block .'\',\'image_collapse_'. $id_block .'\')" class="adk_pointer">
				'.  (($user_info['is_guest'] ? !empty($_COOKIE['adk_block_'. $id_block]) : !empty($options['adk_block_'. $id_block])) ? '<img id="image_collapse_'. $id_block .'" src="'.$settings['images_url'].'/expand.gif" alt="+" border="0" class="collapse2" />' : '<img id="image_collapse_'. $id_block .'" src="'.$settings['images_url'].'/collapse.gif" alt="-" border="0" class="collapse2" />') .'
			</span>';
		
		if($t == 0)
		{
			echo'
				</h3>
			</div>';
		}
		
		echo'
		',$b == 0 ? '
					<div class="roundframe adk_padding_7">
					<div class="adk_7"></div>
						' : '';
		
		echo'
			<div class="my_blocks" id="adk_block_'. $id_block .'" '. (($user_info['is_guest'] ? !empty($_COOKIE['adk_block_'.$id_block]) : !empty($options['adk_block_'.$id_block])) ? ' style="display: none;"' : '') .'>';
	}

}

function find_modSettings_style_bot($b = 0)
{
	global $adkportal;
	
	if($adkportal['title_in_blocks'] == 6)
		echo'
	</div>
	<div class="adk_7"></div>';
	if($adkportal['title_in_blocks'] == 1 || $adkportal['title_in_blocks'] == 7)
		echo'
		
				',$b == 0	? '	
						</div>
					</div>
				<span class="lowerframe"><span></span></span>' : '','
				</div>
				',$b == 0 ? '<br />' : '' ,'
				
		';
		
	elseif($adkportal['title_in_blocks'] == 2 || $adkportal['title_in_blocks'] == 8)
		echo'
				
							</div>
				',$b == 0	? '			</div>
					</div>
				<span class="lowerframe"><span></span></span>' : '' ,'
				',$b == 0 ? '<br />' : '' ,'
			';
		
	elseif($adkportal['title_in_blocks'] == 3)
		echo'	
		
					</div>
				',$b == 0	? '	<span class="botslice"><span></span></span></div>' : '' ,'
				</div>
				',$b == 0 ? '<br />' : '' ,'
			';
		
	elseif($adkportal['title_in_blocks'] == 4)
		echo'	
					</div>
					</div>
				',$b == 0	? '	
				<span class="botslice"><span></span></span></div>' : '' ,'
				<br />
			';	
	elseif($adkportal['title_in_blocks'] == 5)
		echo'
					</div>
					',$b == 0	? '	
					</div>
					<span class="lowerframe"><span></span></span>
					' : '' ,'
					<br />';
			

}

function ILoveAdkPortal()
{
	echo base64_decode('PGJyIC8+PGRpdiBhbGlnbj0iY2VudGVyIiBjbGFzcz0ic21hbGx0ZXh0Ij48YSBocmVmPSJodHRwOi8vd3d3LnNtZnBlcnNvbmFsLm5ldCIgdGFyZ2V0PSJfYmxhbmsiPkFkayBQb3J0YWwgYnkgU01GIFBlcnNvbmFsPC9hPjwvZGl2Pg==');
}

//Die function
function loadColpaseAdkportal(){}

function rewrite_context_html_headers()
{
	global $txt, $settings, $context, $user_info, $boardurl, $boarddir, $adkportal;
	
	if($adkportal['use_adkportal_now']){
		$html_header = '
		<link rel="stylesheet" type="text/css" href="'. $boardurl .'/adkportal/css/blocks.css" />
		<script type="text/javascript"><!-- // --><![CDATA[
			var smf_adk_url = "'.$boardurl.'/adkportal/";
			var smf_shoutbox_url = "'.$boardurl.'/adkportal/shoutbox/";
			var smf_shoutbox_text_sending = "'.$txt['adk_shoutbox_sending'].'";
			var smf_shoutbox_shout_it = "'.$txt['adk_shoutbox_shout_it'].'";
			var smf_shoutbox_fill = "'.$txt['adk_shoutbox_all_field'].'";
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
		
		return $html_header;
	}
}

function loadRandom5News()
{
	global $smcFunc, $context;
	
	//Load Random News
	$sql = $smcFunc['db_query']('','
		SELECT titlepage, new, autor, time, id
		FROM {db_prefix}adk_news
		ORDER BY RAND()
	');
	
	$context['adk_new']['random'] = array();
	
	while($row = $smcFunc['db_fetch_assoc']($sql)){
		$context['adk_new']['random'][] = array(
			'id' => $row['id'],
			'title' => $row['titlepage'],
			'body' => un_htmlspecialchars($row['new']),
			'time' => timeformat($row['time']),
			'autor' => $row['autor'],
		);
	}
	
	$smcFunc['db_free_result']($sql);
}

function adk_getContentShout($limit = 25)
{
	global $smcFunc, $context;
	
	$res = $smcFunc['db_query']('','
		SELECT date, user, message 
		FROM {db_prefix}adk_shoutbox 
		ORDER BY date DESC 
		LIMIT {int:limit}',
		array(
			'limit' => $limit,
		)
	);	
	
	$context['shoutboxload'] = array();
	$alternate = '';
	$i = 0;
	
	while($row = $smcFunc['db_fetch_assoc']($res))
	{
		if($i == 1)
		{
			$alternate = 'windowbg2';
			$i = 0;
		}
		else
		{
			$alternate = 'windowbg';
			$i++;
		}
			
		echo  '
			<div>
				<div style="font-weight: bold;">
					'.$row['user'].':
				</div>
				',parse_shoutbox($row['message']),'
				<br /><span class="date">
					'.timeformat($row['date']).'
				</span><hr />
			</div>';
	}
	
	$smcFunc['db_free_result']($res);

}
function adk_insertMessageShout($user, $message)
{
	global $smcFunc;
	
	$time = time();
	
	//I need this one
	$array_info = array(
		'date' => 'int',
		'user' => 'text',
		'message' => 'text',
	);
	
	
	//Make me happy :D
	$array_insert = array(
		$time,
		$user,
		$message,
	);
	
	$smcFunc['db_insert']('insert',
		'{db_prefix}adk_shoutbox',
		//Load The Array Info
		$array_info,
		//Insert Now;)
		$array_insert,
		array('id')
	);
	
}

function loadShoutboxwi()
{
	global $user_info, $scripturl;
	
	if(!empty($_REQUEST['action']) && $_REQUEST['action'] == 'update')
		adk_getContentShout();
	elseif(!empty($_REQUEST['action']) && $_REQUEST['action'] == 'insert')
	{
		$nick = CleanAdkStrings($_REQUEST['nick']);
		$message = CleanAdkStrings($_REQUEST['message']);
	
			
		
		$nick = CleanAdkStrings($_REQUEST['nick']);
		$message = CleanAdkStrings($_REQUEST['message']);
		
		if(!$user_info['is_guest']){
			
			if($user_info['name'] != $nick)
				die();
			
			$id_user = $user_info['id'];
			$nick = '<a href="'.$scripturl.'?action=profile;u='.$id_user.'">'.$nick.'</a>';
		}
				
		adk_insertMessageShout($nick, $message);
	}
}

//Function parse_buttons
function parseAdk_buttons($buttons)
{
	global $boardurl;
	
	if(!is_array($buttons) || empty($buttons))
		return;
	
	$return = array();
	
	foreach($buttons AS $button)
	{
		if($button['show'])
			$return[] = '
			<div class="adk_padding_5 '.$button['div'].'">
				<img style="'.$button['style'].'" alt="'.$button['title'].'" src="'.$boardurl.'/adkportal/images/'.$button['icon'].'" />&nbsp;
				<a href="'.$button['href'].'">
					'.$button['title'].'
				</a>
			</div>';
	}
	
	echo implode('',$return);
}


//Load Menus
function load_menu_principal()
{
	global $scripturl, $txt, $adkportal, $modSettings, $context;
	
	//Url's
	$adk_stand_alone_url = isset($adkportal['adk_stand_alone_url']) ? $adkportal['adk_stand_alone_url'] : $scripturl;
	$home_url = $adkportal['adk_enable'] == 2 ? $adk_stand_alone_url : $scripturl;
	
	$buttons = array();
	
	//Array
	$buttons = array(
		'home' => array(
			'title' => $txt['home'],
			'style' => 'vertical-align: middle;',
			'href' => $home_url,
			'show' => true,
			'icon' => 'gohome.png',
			'div' => 'windowbg',
		),
		'forum' => array(
			'title' => $txt['foro'],
			'style' => 'vertical-align: middle;',
			'href' => $adkportal['adk_enable'] == 2 ? $scripturl : $scripturl . '?action=forum',
			'show' => !empty($adkportal['adk_enable']),
			'icon' => 'agt.png',
			'div' => 'windowbg2',
		),
		'unread' => array(
			'title' => $txt['new_posts'],
			'style' => 'vertical-align: middle;',
			'href' => $scripturl.'?action=unread',
			'show' => true,
			'icon' => 'newmsg.png',
			'div' => 'windowbg',
		),
		'unreadreplies' => array(
			'title' => $txt['new_msg'],
			'style' => 'vertical-align: middle;',
			'href' => $scripturl.'?action=unreadreplies',
			'show' => true,
			'icon' => 'postscript.png',
			'div' => 'windowbg2',
		),
		'users' => array(
			'title' => $txt['users'],
			'style' => 'vertical-align: middle;',
			'href' => $scripturl.'?action=mlist',
			'show' => allowedTo('view_mlist'),
			'icon' => 'users.png',
			'div' => 'windowbg',
		),
		'search' => array(
			'title' => $txt['search'],
			'style' => 'vertical-align: middle;',
			'href' => $scripturl.'?action=search',
			'show' => allowedTo('search_posts'),
			'icon' => 'search.png',
			'div' => 'windowbg2',
		),
		'faq' => array(
			'title' => $txt['help'],
			'style' => 'vertical-align: middle;',
			'href' => $scripturl.'?action=help',
			'show' => true,
			'icon' => 'help.png',
			'div' => 'windowbg',
		),
	);
	
	if(!isset($txt['blog']))
		$txt['blog'] = 'Blog';
	
	if(!empty($modSettings['blog_enable']) && allowedTo_viewBlog())
		$buttons['blog'] = array(
			'title' => $txt['blog'],
			'style' => 'vertical-align: middle;',
			'href' => $scripturl.'?action=blogs',
			'show' => true,
			'icon' => 'AllPages.png',
			'div' => 'windowbg',
		);
	
	//Return buttons
	return $buttons;
}

function load_menu_personal()
{
	global $scripturl, $txt, $context, $modSettings, $user_info;
	
	$buttons = array();
	
	//Array
	$buttons = array(
		'profile' => array(
			'title' => $txt['profile'],
			'style' => 'vertical-align: middle;',
			'href' => $scripturl.'?action=profile',
			'show' => $context['user']['is_logged'],
			'icon' => 'link.png',
			'div' => 'windowbg',
		),
		'pm' => array(
			'title' => $txt['pm_short'],
			'style' => 'vertical-align: middle;',
			'href' => $scripturl.'?action=pm',
			'show' => $context['user']['is_logged'] && $context['allow_pm'],
			'icon' => 'messages.png',
			'div' => 'windowbg2',
		),
		'admin' => array(
			'title' => $txt['admin'],
			'style' => 'vertical-align: middle;',
			'href' => $scripturl.'?action=admin',
			'show' => $context['user']['is_logged'] && $context['allow_admin'],
			'icon' => 'admin.png',
			'div' => 'windowbg',
		),
		'logout' => array(
			'title' => $txt['logout'],
			'style' => 'vertical-align: middle;',
			'href' => $scripturl.'?action=logout;'.$context['session_var'].'='. $context['session_id'],
			'show' => $context['user']['is_logged'],
			'icon' => 'logout.png',
			'div' => 'windowbg2',
		),
		'register' => array(
			'title' => $txt['register'],
			'style' => 'vertical-align: middle;',
			'href' => $scripturl.'?action=register',
			'show' => !$context['user']['is_logged'],
			'icon' => 'register.png',
			'div' => 'windowbg',
		),
		'login' => array(
			'title' => $txt['login'],
			'style' => 'vertical-align: middle;',
			'href' => $scripturl.'?action=login',
			'show' => !$context['user']['is_logged'],
			'icon' => 'login.png',
			'div' => 'windowbg2',
		),
	);
	
	//Load Adk Blog
	if(!isset($txt['adk_another_string']))
		$txt['adk_another_string'] = 'My blog';
	
	if(!empty($modSettings['blog_enable']) && allowedTo_viewMyBlog()){
		array_unshift($buttons, array(
			'title' => $txt['adk_another_string'],
			'style' => 'vertical-align: middle;',
			'href' => $scripturl.'?blog='.$user_info['id'],
			'show' => true,
			'icon' => 'AllPages.png',
			'div' => 'windowbg2',
		));
	}
	
	//Unread Messages ;)
	$buttons['pm']['title'] .= ' ('.$user_info['unread_messages'].'/'.$user_info['messages'].')';
			
	
	return $buttons;
}

function downloads_button_strip($button_strip, $direction = 'right')
{
	global $settings, $context, $txt, $scripturl;

	// Create the buttons...
	$buttons = array();
	foreach ($button_strip as $key => $value)
	{
		$active = isset($value['active']) ? ' class="active"' : '';
		if (!isset($value['test']) || !empty($context[$value['test']]))
			$buttons[] = '
			<li id="'.$value['id'].'"><a'.$active.'><span>' . $value['text'] . '</span></a></li>';
	}

	// No buttons? No button strip either.
	if (empty($buttons))
		return;

	// Make the last one, as easy as possible.
	$buttons[count($buttons) - 1] = str_replace('<span>', '<span class="last">', $buttons[count($buttons) - 1]);

	echo '
		<div class="buttonlist', !empty($direction) ? ' align_' . $direction : '', '">
			<ul class="menu">',
				implode('', $buttons), '
			</ul>
		</div>';
}

function allowedTo_viewBlog()
{
	global $user_info, $modSettings, $context;
	
	if($context['user']['is_guest'] && in_array(-1,explode(',',$modSettings['blog_allowed_toview'])) && !empty($modSettings['blog_enable']))
		return true;
	elseif(!$user_info['is_guest'] && in_array($user_info['groups'][0],explode(',',$modSettings['blog_allowed_toview'])) && !empty($modSettings['blog_enable']))
		return true;
	else
		return false;
}

function allowedTo_viewMyBlog()
{
	global $user_info, $modSettings;
	
	if(in_array($user_info['groups'][0],explode(',',$modSettings['blog_allowed_your_blog'])))
		return true;
	else
		return false;
}

//Do you have GD library? :|
function check_if_gd()
{
	if(function_exists('imagecreate'))
		return true;
	else
		return false;
}

function loadDisplayNews()
{
	global $adkportal, $boardurl, $context, $txt, $scripturl;
	
	if(empty($context['adk_new']['random']))
		return;
	
	if($adkportal['enable_related_topics'] == 1)
	{
		echo'
		<br />
		<br />';
		
		echo'
		<div class="title_bar">
			<h3 class="titlebg">
				',$txt['adk_related_news'],'
			</h3>
		</div>
		<table class="table_grid" cellspacing="0" style="width: 100%;">
			<thead>
				<tr class="catbg">
					<th scope="col" class="smalltext first_th" width="8%">
					</th>
					<th scope="col" class="smalltext" width="48%">
						', $txt['subject'] ,'
					</th>
					<th scope="col" class="smalltext" width="22%">
						', $txt['started_by'] ,'
					</th>
					<th scope="col" class="smalltext last_th" width="22%">
						'.$txt['on'].'
					</th>
				</tr>
			</thead>
			<tbody>';
		foreach($context['adk_new']['random'] AS $t)
			echo'
				<tr class="windowbg2 whos_viewing">
					<td width="8%">
						<img alt="" src="',$boardurl,'/adkportal/images/page.png" />
					</td>
					<td>
						<a style="font-weight: bold;" href="'.$scripturl.'?action=addthistopic;view='.$t['id'].'">',$t['title'],'</a>
					</td>
					<td width="22%">
						<strong>',$t['autor'],'</strong>
					</td>
					<td width="22%">
						',$t['time'],'
					</td>
				</tr>';
		
		echo'
			</tbody>
		</table>
		<br />';
	
	}
}

function loadPagesAdkportal($page = '', $limit = 1, $order = '')
{
	global $smcFunc, $context, $user_info;
	
	if(empty($limit))
		return;
	
	$where = '';
	
	//an specific page?
	if(!empty($page))
		$where = 'WHERE urltext = {text:page}';
	
	//Load
	$sql = $smcFunc['db_query']('','SELECT
		id_page, urltext, titlepage, views, grupos_permitidos,
		type, winbg, cattitlebg, enableleft, enableright
		FROM {db_prefix}adk_pages
		'.$where.'
		'.$order.'
		LIMIT {int:limit}',
		array(
			'page' => $page,
			'limit' => $limit,
		)
	);
	
	$context['pages'] = array();
	
	while($row = $smcFunc['db_fetch_assoc']($sql))
	{
		$allowed = explode(',',$row['grupos_permitidos']);
		
		$id_group_member = $user_info['groups'][0];
		
		if($id_group_member == 0)
		{
			$sql = $smcFunc['db_query']('','SELECT id_post_group FROM {db_prefix}members WHERE id_member = {int:member}',array('member' => $id_member,));
			$row = $smcFunc['db_fetch_assoc']($sql);
			$id_group_member = $row['id_post_group'];
			$smcFunc['db_free_result']($sql);
		}
		
		if(empty($id_group_member))
			$id_group_member = -1;
			
		if(!in_array($id_group_member, $allowed))
			return;
		
		$context['pages'][$row['id_page']] = array(
			'id' => $row['id_page'],
			'urltext' => $row['urltext'],
			'titlepage' => $row['titlepage'],
			'views' => $row['views'],
			'type' => $row['type'],
			'winbg' => $row['winbg'],
			'cattitlebg' => $row['cattitlebg'],
			'enableleft' => $row['enableleft'],
			'enableright' => $row['enableright'],
		);
		
	}
	
	$smcFunc['db_free_result']($sql);
	
	return $context['pages'];
		
}

//Some errors with russian languages (for example)
function parse_if_utf8($title)
{
	//Heracles was here :P
	if(empty($title) || empty($context['character_set']))
		return empty($title) ? '' : $title;

	
	global $context;
	
	if($context['character_set'] == 'UTF-8')
		$title = htmlentities($title,ENT_QUOTES,'cp1251');
	
	return $title;	
}

//Shoutbox smileys
function parse_shoutbox($body)
{
	global $context, $boarddir, $adkportal;
	
	//Found dir
	$context['shout_dir'] = $boarddir.'/adkportal/smileys';
	$context['shout_dir_found'] = is_dir($context['shout_dir']);

		
	$context['filenames'] = array();
	//Load folder
	if ($context['shout_dir_found'])
	{
		if (!file_exists($context['shout_dir']))
			continue;

		$dir = dir($context['shout_dir']);
		while ($entry = $dir->read())
		{
			if (!in_array($entry, $context['filenames']) && in_array(strrchr($entry, '.'), array('.jpg', '.gif', '.jpeg', '.png')))
				$context['filenames'][strtolower($entry)] = array(
					'id' => CleanAdkStrings($entry),
			);
		}
		
		$dir->close();
		ksort($context['filenames']);
	}

	$context['filenames'] = array_values($context['filenames']);
	
	//Smiley name
	$smileys = array();
	//Image path
	$images = array();
	
	//Create str_replace
	foreach($context['filenames'] AS $smiley){
		$body = str_replace(':'.$smiley['id'].':','<img alt="" src="'.$adkportal['smileys_url'].'/'.$smiley['id'].'" />',$body);
	}

	
	//Now Parse BBCodes
	$bbcodes = array(
		'i' => array(
			'tag' => 'i',
			'before' => '<span class="font_italic">',
			'after' => '</span>',
		),
		'b' => array(
			'tag' => 'b',
			'before' => '<span class="font_bold">',
			'after' => '</span>',
		),
		'u' => array(
			'tag' => 'u',
			'before' => '<span class="font_under">',
			'after' => '</span>',
		),
		's' => array(
			'tag' => 's',
			'before' => '<span class="font_strike">',
			'after' => '</span>',
		),
		'left' => array(
			'tag' => 'left',
			'before' => '<div class="shout_left">',
			'after' => '</div>',
		),
		'center' => array(
			'tag' => 'center',
			'before' => '<div class="shout_center">',
			'after' => '</div>',
		),
		'right' => array(
			'tag' => 'right',
			'before' => '<div class="shout_right">',
			'after' => '</div>',
		),
	);
	
	foreach($bbcodes AS $bbc)
	{
		//Replace before
		$body = str_replace('['.$bbc['tag'].']',$bbc['before'],$body);
		
		//Replace after
		$body = str_replace('[/'.$bbc['tag'].']',$bbc['after'],$body);
		
	}
	
	
	//return
	return $body;
	
}

function adk_bookmarks($align = 'left', $block = 'auto_news', $id = 0)
{
	global $boardurl, $scripturl;
	
	//Not id? fuck!
	if(empty($id))
		return;
	
	//Url?
	$t = $scripturl.'?topic='.$id.'.0';
	$n = $scripturl.'?action=addthistopic;view='.$id;
	
	//final url
	$url = $block == 'auto_news' ? $t : $n;
	
	//Facebook share
	$share = array(
		'facebook' => array(
			'url' => 'http://www.facebook.com/sharer.php?u='.$url,
			'image' => 'facebook.png',
		),
		'twitter' => array(
			'url' => 'http://twitter.com/home?status='.$url,
			'image' => 'twitter.png',
		),
	);	
	
	echo'
	<div class="adk_align_'.$align.'">';
	
	foreach($share AS $b)
		echo'
		<a href="'.$b['url'].'"><img alt="" src="'.$boardurl.'/adkportal/images/'.$b['image'].'" /></a>';
	
	echo'
	</div>';
		
}

function checkIfValidExtension($extension){
	
	//non extension? return false :D
	if(empty($extension))
		return false;
	
	$extensions = array(
		'jpg','jpeg','png','gif','bmp',
	);
	
	$extension = strtolower($extension);
	
	if(in_array($extension,$extensions))
		return true;
	else
		return false;
}

//Hooks integration
function Adk_portal_add_index_actions(&$actionArray)
{
	//Load Adkportal actions
	$actionArray += array(
		'forum' => array('BoardIndex.php', 'BoardIndex'),
		'portal' => array('Adkportal.php', 'Adkportal'),
		'downloads' => array('Adk-Downloads.php','ShowDownloads'),
		'addthistopic' => array('Adk-echomodules.php','AddThisTopic'),
		'adk_shoutbox' => array('Adk-echomodules.php','ShowShoutbox'),
		'adk_credits' => array('Adk-echomodules.php','AdkCredits'),
		'contact' => array('Adk-echomodules.php','AdkContact'),
	);
}

function Adk_portal_add_admin_areas(&$adminAreas)
{
	global $txt;
	
	//Load Menu Admin
	$find_me = 0;
	reset($adminAreas);
	
	while((list($key, $val) = each($adminAreas)) && $key != 'layout')
		$find_me++;

	$adminAreas = array_merge(
		array_slice($adminAreas, 0, $find_me),
		array(
			'adk_portal' => array(
				'title' => $txt['adk_portal'],
				'permission' => array('adk_portal'),
				'areas' => array(
					'adkadmin' => array(
						'label' => $txt['adk_portal'],
						'file' => 'Adk-Admin.php',
						'function' => 'AdkAdmin',
						'icon' => 'label0.png',
						'permission' => array('adk_portal'),
						'subsections' => array(
							'view' => array($txt['adk_news_news']),
							'adksettings' => array($txt['opcion_adk']),
							'manageicons' => array($txt['adk_manage_icons']),
						),
					),
					'blocks' => array(
						'label' => $txt['blocks_settings_admin'],
						'file' => 'Adk-Admin.php',
						'function' => 'AdkBlocksGeneral',
						'icon' => 'posts.gif',
						'permission' => array('adk_portal'),
						'subsections' => array(
							'viewblocks' => array($txt['bloques']),
							'settingsblocks' => array($txt['adk_settings_blocks']),
							'newblocks' => array($txt['crear_block']),
							'uploadblock' => array($txt['adk_upload_yourBlock']),
							'createnews' => array($txt['nueva_noticia']),
							'shoutbox' => array($txt['adk_shout']), 
						),
					),
					'modules' => array(
						'label' => $txt['adk_modules_admin'],
						'file' => 'Adk-Modules.php',
						'function' => 'AdkModules',
						'icon' => 'label1.png',
						'permission' => array('adk_portal'),
						'subsections' => array(
							'intro' => array($txt['adk_modules_intro']),
							'viewadminpages' => array($txt['adk_admin_pages']),
							'contact' => array($txt['adk_contacto']),
							'uploadanyimage' => array($txt['advanced_block_images']),
							'manageimagesadk' => array($txt['adk_manage_images']),
						),
					),
					'adkdownloads' => array(
						'label' => $txt['downloads'],
						'file' => 'Adk-Downloads.php',
						'function' => 'ShowDownloadsMainAdmin',
						'icon' => 'label2.png',
						'subsections' => array(
							'settings' => array($txt['adk_settings']),
							'addcategory' => array($txt['add_category']),
							'allcategories' => array($txt['categories']),
							'approvedownloads' => array($txt['adk_approve']),
						),
					),
					'adkseoadmin' => array(
						'label' => $txt['seo_manage_title'],
						'file' => 'Adk-Seo.php',
						'function' => 'AdkSeoMain',
						'icon' => 'label3.png',
						'subsections' => array(
							'htaccess' => array($txt['seo_create_htaccess']),
							'settings' => array($txt['adk_settings']),
							'robotstxt' => array($txt['seo_create_robotstxt']),
						),
					),
				),
			),
		),
		array_slice($adminAreas, $find_me)
	);

}

function Adk_portal_add_menu_buttons(&$buttons)
{
	global $adkportal, $scripturl, $txt;
	
	//Load Menu buttons
	$adk_stand_alone_url = isset($adkportal['adk_stand_alone_url']) ? $adkportal['adk_stand_alone_url'] : $scripturl;
	$home_url = $adkportal['adk_enable'] == 2 ? $adk_stand_alone_url : $scripturl;
	
	$find_me = 0;
	reset($buttons);
	
	while((list($key, $val) = each($buttons)) && $key != 'help')
		$find_me++;

	$buttons = array_merge(
		array_slice($buttons, 0, $find_me),
		array(
			'forum' => array(
				'title' => !empty($txt['foro']) ? $txt['foro'] : 'Forum',
				'href' => $adkportal['adk_enable'] == 2 ? $scripturl : $scripturl . '?action=forum',
				'show' => !empty($adkportal['adk_enable']),
				'sub_buttons' => array(
				),
			),
			'downloads' => array(
				'title' => $txt['downloads'],
				'href' => $scripturl . '?action=downloads',
				'show' => $adkportal['download_enable'] && allowedTo('adk_downloads_view'),
				'sub_buttons' => array(
				),
			),
			'contact' => array(
				'title' => $txt['adk_contacto'],
				'href' => $scripturl.'?action=contact',
				'show' => !empty($adkportal['adk_enable_contact']) && allowedToViewContactPage(),
			),
		),
		array_slice($buttons, $find_me)
	);

	$buttons['admin']['sub_buttons'] += array(
		'adkportal' => array(
			'title' => !empty($txt['adk_portal']) ? $txt['adk_portal'] : 'Adk Portal',
			'href' => $scripturl . '?action=admin;area=adkadmin',
			'show' => allowedTo('adk_portal'),
			'is_last' => true,
		),
	);
	
	//rewrite main url
	$buttons['home']['href'] = $home_url;
	
	//rewrite is last...
	$button['admin']['sub_buttons']['permissions']['is_last'] = false;
}

function Adk_portal_display_buttons(&$display_buttons)
{
	global $context, $scripturl;
	
	if(allowedTo('adk_portal'))
		$context['adk_portal'] = true;
	$string = !empty($context['adk_id_new']) ? 'remove' : 'add';
	
	//Add Display Button
	$display_buttons += array(
		'addthistopic' => array('test' => 'adk_portal', 'text' => 'adk_'.$string.'_this_topic', 'image' => 'reply.gif', 'lang' => true, 'url' => $scripturl . '?action=addthistopic;'.$string.'=' . $context['current_topic']),
	);
}
	
function CleanAdkStrings($string)
{
	//This is for a compatibility check with Adk portal 2.1.... really, this is obsolet function on Adk 2.1.1+
	return htmlspecialchars($string,ENT_QUOTES);
}

function un_CleanAdkStrings($string)
{
	//This is for a compatibility check with Adk portal 2.1.... really, this is obsolet function on Adk 2.1.1+
	return un_htmlspecialchars($string);
}

function adk_create_block($parameters, $load_permissions = true)
{
	global $boarddir, $user_info;
	
	//Change variable name
	$poster = $parameters;
	
	//You can view that block (for the moment :P)
	$true = true;
	
	//Load permissions
	if($load_permissions){
		$explode = explode(',',$poster['p']);
		if($user_info['is_guest'] && in_array(-1,$explode))
			$true = false;
			
		if($user_info['groups'][0] == 0 && in_array(-2,$explode))
			$true = false;
			
		if(in_array($user_info['groups'][0],$explode) && $user_info['groups'][0] != 0)
			$true = false;
	}
	
	//Load block
	if($true){
		if($poster['type'] == 'multi_block')
		{
			$blocks = load_multi_blocks($poster['echo'], $poster['id']);
		}
		if($poster['type'] == 'include')
		{
			find_modSettings_style_top($poster['title'], $poster['img'],$poster['id'], $poster['b'],$poster['t'], $poster['c']);
			if(file_exists($boarddir.'/adkportal/blocks/'.$poster['echo']))
				require($boarddir.'/adkportal/blocks/'.$poster['echo']);
			find_modSettings_style_bot($poster['b']);
		}
		if($poster['type'] == 'php')
		{
			find_modSettings_style_top($poster['title'], $poster['img'],$poster['id'], $poster['b'],$poster['t'], $poster['c']);
			$body = $poster['echo'];
			$body = trim($body);
			$body = trim($body, '<?php');
			$body = trim($body, '?>');
			eval($body);
			find_modSettings_style_bot($poster['b']);
		}
		if($poster['type'] == 'html')
		{
			find_modSettings_style_top($poster['title'], $poster['img'],$poster['id'], $poster['b'],$poster['t'], $poster['c']);
			$body = $poster['echo'];
			echo $body;
			find_modSettings_style_bot($poster['b']);
		}
		if($poster['type'] == 'bbc')
		{
			find_modSettings_style_top($poster['title'], $poster['img'],$poster['id'], $poster['b'],$poster['t'], $poster['c']);
			$body = $poster['echo'];
			echo parse_bbc($body);
			find_modSettings_style_bot($poster['b']);
		}
	}
	
}
	
//The Array :?
function load_multi_blocks($id, $initial_id)
{
	global $smcFunc, $user_info;
	
	//wrongs id?
	if(empty($id))
		return;
		
	$multi_id = explode(',',$id);
	
	$sql = $smcFunc['db_query']('','
		SELECT id, echo, name, img, type, empty_body, empty_title, empty_collapse, permissions, other_style
		FROM {db_prefix}adk_blocks 
		WHERE id IN ({array_string:settings})',
		array(
			'settings' => $multi_id,
		)
	);
	
	$blocks = array();
	
	$to_count = count($multi_id);
	
	//Algunas variables
	$i = 0;
	$to_use = '';
	
	while($row = $smcFunc['db_fetch_assoc']($sql)){
		while($i < $to_count){
			if($row['id'] == $multi_id[$i])
				$to_use = $i;
			
			$i++;
		}
		
		$blocks[$to_use] = array(
			'id' => $row['id'],
			'echo' => un_htmlspecialchars($row['echo']),
			'title' => $row['name'],
			'img' => $row['img'],
			'type' => $row['type'],
			'b' => $row['empty_body'],
			't' => $row['empty_title'],
			'c' => $row['empty_collapse'],
			'p' => $row['permissions'],
			'other_style' => $row['other_style'],
		);
		
		$i = 0;
	}
	
	ksort($blocks);
	
	$smcFunc['db_free_result']($sql);
	
	$total_blocks = count($blocks);
	
	if(empty($blocks))
		return;
	
	//Count -1 if that user does not have permissions to see this block
	foreach($blocks AS $block){
		$true = true;
		$explode = explode(',',$block['p']);
		
		if($user_info['is_guest'] && in_array(-1,$explode))
		$true = false;
		
		if($user_info['groups'][0] == 0 && in_array(-2,$explode))
			$true = false;
			
		if(in_array($user_info['groups'][0],$explode) && $user_info['groups'][0] != 0)
			$true = false;
		
		if(!$true)
			$total_blocks--;
	}
	
	if(!empty($total_blocks)){
		
		//Widths :)
		$widths = 100 / $total_blocks;
		
		echo'
		<table style="width: 100%;" align="center">
			<tr>';
		
		foreach($blocks AS $block){
			
			$true = true;
			$explode = explode(',',$block['p']);
			
			if($user_info['is_guest'] && in_array(-1,$explode))
			$true = false;
			
			if($user_info['groups'][0] == 0 && in_array(-2,$explode))
				$true = false;
				
			if(in_array($user_info['groups'][0],$explode) && $user_info['groups'][0] != 0)
				$true = false;
			
			if($true){
				$block['id'] = $block['id'].'_prima_'.$initial_id;
				
				echo'
					<td valign="top" style="width: ',$widths,'%;">';
						adk_create_block($block);
				echo'
					</td>';
			}
		}
		
		echo'
			</tr>
		</table>';
	}
	
}

function allowedToViewContactPage()
{
	global $adkportal, $user_info;
	
	$to_view = false;
	$x = explode(',',$adkportal['adk_groups_contact']);
	
	//Groups
	foreach($x AS $i => $v){
		if(in_array($v,$user_info['groups']))
			$to_view = true;
	}
	
	//Guest
	if($user_info['is_guest'] && in_array(-1,$x))
		$to_view = true;
	
	//Regular users
	if($user_info['groups'][0] == 0 && in_array(0,$x))
		$to_view = true;
	
	if($user_info['is_admin'])
		$to_view = true;
	
	return $to_view;
}
	

?>