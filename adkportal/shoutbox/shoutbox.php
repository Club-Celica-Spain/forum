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

if(!empty($_REQUEST['action']))
{

	require_once("../../SSI.php");
		


	loadShoutboxwi();
}
else

	die('Hacking attempt...');


?>