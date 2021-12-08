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


function template_main()
{
	global $adkportal, $user_info, $options;
	
	
	columntop();

	echo'
	<table border="0" width="100%">
		<tr>';

	if(!empty($adkportal['cleft']))
		echo'
			<td id="adk_left" valign="top" style="width:',$adkportal['wleft'],'; padding-right: 5px;'. (($user_info['is_guest'] ? !empty($_COOKIE['adk_left']) : !empty($options['adk_left'])) ? ' display: none;' : '') .'">
					',columnleft(),'
			</td>';
	
	echo'
			<td valign="top">
				
					',columncenter(),'
				
			</td>';

	if(!empty($adkportal['cright']))	
		echo'
			<td id="adk_right" valign="top" style="width:',$adkportal['wright'],'; padding-left: 5px;'. (($user_info['is_guest'] ? !empty($_COOKIE['adk_right']) : !empty($options['adk_right'])) ? ' display: none;' : '') .'">
				
				 ',columnright(),'
				
			</td>';
		
	echo'
		</tr>			
	</table>';
	
	columnbottom();
			

}
?>