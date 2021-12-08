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


function AdkSeoMain()
{
	global $context, $txt, $scripturl, $settings;
	
	//Load Basic Info
	isAllowedTo('adk_portal');
	loadTemplate('Adk-Seo');
	
	if(loadLanguage('Adk-Admin') == false)
		loadLanguage('Adk-Admin','english');
		
		
	$subActions = array(
		'htaccess' => 'AdkCreateHtaccess',
		'savehtaccess' => 'AdkSaveHtaccess',
		'settings' => 'AdkSeoSettings',
		'savesettings' => 'AdkSaveSettings',
		'robotstxt' => 'AdkCreateRobotstxt',
		'saverobots' => 'AdkSaveRobotstxt',
		
	);	
		
		
	$context[$context['admin_menu_name']]['tab_data'] = array(
		'title' => $txt['seo_manage_title'],
		'description' => $txt['seo_manage_description'],
		'tabs' => array(
			'htaccess' => array(
				'description' => '',
				'label' => '<img style="vertical-align: middle;" alt="" src="'.$settings['default_theme_url'].'/images/admin/htaccess.png" />'.$txt['seo_create_htaccess'],
			),
			'settings' => array(
				'description' => '',
				'label' => '<img style="vertical-align: middle;" alt="" src="'.$settings['default_theme_url'].'/images/admin/settings.png" />'.$txt['adk_settings'],
			),
			'robotstxt' => array(
				'description' => '',					
				'label' => '<img style="vertical-align: middle;" alt="" src="'.$settings['default_theme_url'].'/images/admin/robot.png" />'.$txt['seo_create_robotstxt'],
			),
		),
	);	
	
	
	// Follow the sa or just go to View function
	if (!empty($_GET['sa']) && !empty($subActions[$_GET['sa']]))
		$subActions[@$_GET['sa']]();
	else
		$subActions['htaccess']();	
}
		
function AdkCreateHtaccess()
{
	global $context, $txt, $boarddir;
	
	checkSession('get');
	
	$context['sub_template'] = 'htaccess';
	$context['page_title'] = $txt['seo_create_htaccess'];
	
	
	if(file_exists($boarddir.'/.htaccess'))
		$context['htaccess_content'] = file_get_contents($boarddir."/.htaccess");
	else
		$context['htaccess_content'] = '';
}
		
function AdkSaveHtaccess()
{
	global $context, $adkportal, $boarddir;
	
	checkSession('post');
	
	$dir = $boarddir.'/.htaccess';
	
	if(!empty($_POST['path']))
	{
		$adkportal['path_seo'] = htmlspecialchars(stripslashes($_POST['path']),ENT_QUOTES);
		
		updateSettingsAdkPortal(
			array(
				'path_seo' => $adkportal['path_seo'],
			)
		);
	}
	
	if(!empty($_POST['htaccess']))
		$htaccess = stripslashes($_POST['htaccess']);
	else
		$htaccess = '
RewriteEngine on
RewriteBase /'.$adkportal['path_seo'].'
RewriteRule ^pages/(.*)\.html index.php?page=$1 [L]
RewriteRule ^cat/([0-9]*)-(.*)\.html$ index.php?action=downloads;cat=$1 [L]
RewriteRule ^down/([0-9]*)-(.*)\.html$ index.php?action=downloads;sa=view;down=$1 [L]';
		
	
	file_put_contents($dir,$htaccess);
	
	redirectexit('action=admin;area=adkseoadmin;sa=htaccess;'.$context['session_var'].'='.$context['session_id']);

}
function AdkSeoSettings()
{
	global $txt, $context, $boarddir;
	
	checkSession('get');
	
	if(!file_exists($boarddir.'/.htaccess'))
		redirectexit('action=admin;area=adkseoadmin;sa=htaccess;'.$context['session_var'].'='.$context['session_id']);
	
	$context['sub_template'] = 'settings_seo';
	$context['page_title'] = $txt['adk_settings'];
}

function AdkSaveSettings()
{
	global $context, $boarddir;
	
	checkSession('post');
	
	if(!file_exists($boarddir.'/.htaccess'))
		redirectexit('action=admin;area=adkseoadmin;sa=htaccess;'.$context['session_var'].'='.$context['session_id']);
	
	updateSettingsAdkPortal(
		array(
			'enable_pages_seo' => (int)$_POST['enable_pages_seo'],
			'enable_download_seo' => (int)$_POST['enable_download_seo'],
		)
	);
	
	redirectexit('action=admin;area=adkseoadmin;sa=settings;'.$context['session_var'].'='.$context['session_id']);
}

function AdkCreateRobotstxt()
{
	global $boarddir, $context, $txt, $adkportal;
	
	checkSession('get');
		
	$context['sub_template'] = 'robots_seo';
	$context['page_title'] = $txt['seo_create_robotstxt'];
	
	
	
	if(file_exists($boarddir.'/robots.txt'))
		$context['robots_dir'] = file_get_contents($boarddir.'/robots.txt');
	else
		$context['robots_dir'] = '';


}
		
		
function AdkSaveRobotstxt()
{
	global $boarddir, $context;
	
	checkSession('post');
	
	if(!empty($_POST['robots']))
	{	
		$dir = $boarddir.'/robots.txt';
		$r = stripslashes($_POST['robots']);
		
		file_put_contents($dir,$r);
	}
	
	
	redirectexit('action=admin;area=adkseoadmin;sa=robotstxt;'.$context['session_var'].'='.$context['session_id']);
}	
		
		
		
?>