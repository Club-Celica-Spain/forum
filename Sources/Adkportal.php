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
	
function Adkportal()
{
	global $context, $txt, $adkportal;

	loadTemplate('Adkportal');
	
	//Load main trader template.
	$context['sub_template']  = 'main';

	//Set the page title
	$context['page_title'] = !empty($adkportal['change_title']) ? $adkportal['change_title'] : $context['forum_name'] . ' - '. $txt['portal'];
}

?>