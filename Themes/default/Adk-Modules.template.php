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

function template_introAdk()
{
	global $scripturl, $context, $txt, $boardurl;
	
	echo'
		<div class="cat_bar"><h3 class="catbg">
			<img alt="" style="vertical-align: middle;" src="'.$boardurl.'/adkportal/images/link.png" /> '.$txt['adk_modules_settings'].'
		</h3></div>
		<div class="windowbg"><span class="topslice"><span></span></span>
			<div class="content">
				<strong class="aprovebg">'.$txt['adk_disponibles_modulos'].':</strong>
				<hr />
				<br />
				<div class="smalltext">'.$context['file'].'</div>
			</div>
		<span class="botslice"><span></span></span></div><br />';	

	ILoveAdkPortal();

}


function template_viewadminpages()
{
	global  $scripturl, $context, $txt, $adkportal, $boardurl;
	
	echo'	
		<div class="title_bar"><h3 class="titlebg">
			'.$txt['adk_admin_pages_new'].'
			<span style="float: right;">
				<img style="vertical-align: middle;" alt="" src="'.$boardurl.'/adkportal/images/newmsg.png" />
				<a href="'.$scripturl.'?action=admin;area=modules;sa=createpages;'.$context['session_var'].'='.$context['session_id'].'">
					<strong>'.$txt['adk_admin_pages_create'].'</strong>
				</a>
			</span>
		</h3></div>
		';
	
	echo'
	<table style="width: 100%;">
		<tr class="catbg">
			<td colspan="3">
				<img style="vertical-align: middle;" alt="" src="'.$boardurl.'/adkportal/images/book_open.png" />&nbsp;'.$txt['adk_admin_pages'].'
			</td>
		</tr>
	';
	
	$i = 0;
	foreach($context['total_admin_pages'] AS $pages)
	{
		if($i == 1) {
			$class = 'windowbg2';
			$i = 0;
		}
		else
			$class = 'windowbg';
			
		echo'
		<tr class="'.$class.'">
			<td style="width: 30%;">
				<strong><a href="'.$scripturl.'?page='.$pages['urltext'].'">'.$pages['titlepage'].'</a></strong>
			</td>
			<td width="55%" style="text-align: center;">
				<a href="'.$scripturl.'?action=admin;area=modules;sa=editpages;id='.$pages['id_page'].';'.$context['session_var'].'='.$context['session_id'].'" title="'.$txt['editar'].' '.$pages['titlepage'].'"><img alt="" src="'.$boardurl.'/adkportal/images/b_edit.png" /></a> - <a href="'.$scripturl.'?action=admin;area=modules;sa=deletepages;id='.$pages['id_page'].';'.$context['session_var'].'='.$context['session_id'].'" title="'.$txt['borrar'].' '.$pages['titlepage'].'"><img alt="" src="'.$boardurl.'/adkportal/images/cancel.png" /></a>
				
			</td>
			<td width="15%">
				<strong>'.$txt['page_view_adk'].'</strong> '.$pages['views'].'
			</td>
		</tr>';
		
		$i++;
	}
	
	echo'
	</table>
	<div align="right"><strong>'.$txt['adk_admin_pages'].':</strong> '.$context['page_index'].'</div>';
						
	
	
	ILoveAdkPortal();
			
}

function template_createpages()
{


	global  $scripturl, $context, $txt, $adkportal, $boardurl;
	
	echo'
	<form method="post" action="'. $scripturl .'?action=admin;area=modules;sa=savecreatedpages">';
	
	echo'
		<div class="cat_bar"><h3 class="catbg">'.$txt['adk_admin_pages_new'].'</h3></div>
		<div class="windowbg2"><span class="topslice"><span></span></span>
		<table style="width:100%;">
			<tr>
				<td style="width: 30%;">
					<strong>'.$txt['titulo'].':</strong><br />
				</td>
				<td style="width: 70%;">
					<input type="text" value="" name="titlepage" size="30" /><br />
				</td>
			</tr>
			<tr>
				<td style="width: 30%;">
				<strong>'.$txt['adk_admin_pages_url'].':</strong><div class="smalltext">'.$txt['adk_admin_pages_minusculas'].'</div><br />
				</td>
				<td style="width: 70%;">
					<div class="smalltext">http://tuforo.com/index.php?page= <input type="text" value="" name="urltext" size="30" /></div><br />
				</td>
			</tr>
			<tr>
				<td style="width: 30%;">
				<strong>'.$txt['adk_pages_enable_left'].'</strong><br /><br />
				</td>
				<td style="width: 70%;">
					'.$txt['adk_pages_yes'].'<input type="radio" name="enableleft" value="1" /> '.$txt['adk_pages_no'].'<input type="radio" name="enableleft" value="0" checked="checked" /><br /><br />
				</td>
			</tr>
			<tr>
				<td style="width: 30%;">
				<strong>'.$txt['adk_pages_enable_right'].'</strong><br /><br />
				</td>
				<td style="width: 70%;">
					'.$txt['adk_pages_yes'].'<input type="radio" name="enableright" value="1" /> '.$txt['adk_pages_no'].'<input type="radio" name="enableright" value="0" checked="checked" /><br /><br />
				</td>
			</tr>
			<tr>
				<td style="width: 30%;" valign="top">
					<strong>'.$txt['adk_admin_pages_groups_allowed'].'</strong><br />
				</td>
				<td style="width: 70%;">';
				
					echo'<input type="checkbox" value="-1" name="groups_allowed[-1]" /> '.$txt['adk_admin_pages_guest'].'<br />';
				foreach($context['group_view_pages'] AS $poster)
				{
					echo'<input type="checkbox" value="'.$poster['id'].'" name="groups_allowed['.$poster['id'].']" /> '.$poster['name'].'<br />';
					
				}
	echo'		
				<i>'.$txt['check_all'].'</i> <input type="checkbox" onclick="invertAll(this, this.form, \'groups_allowed\');" /><br />
				<br />
				</td>
			</tr>
			<tr>
				<td style="width: 30%;">
					<strong>'.$txt['adk_admin_pages_type'].':</strong><br />
				</td>
				<td style="width: 70%;">
					PHP<input type="radio" name="type" value="php" /> Html<input type="radio" name="type" value="html" checked="checked" /> BBC<input type="radio" name="type" value="bbc" /><br />
				</td>
			</tr>
			<tr>
				<td style="width: 30%;">
					<strong>'.$txt['adk_admin_pages_body'].'</strong>
				</td>
				<td style="width: 70%;">';

	if (!function_exists('getLanguages'))
	{
		// Showing BBC?
		if ($context['show_bbc'])
			template_control_richedit($context['post_box_name'], 'bbc');
		
	
		// What about smileys?
		if (!empty($context['smileys']['postform']))
			template_control_richedit($context['post_box_name'], 'smileys');
	
		// Show BBC buttons, smileys and textbox.
		template_control_richedit($context['post_box_name'], 'message');
	}
	else 
	{
		
		if ($context['show_bbc'])
			echo '
					<div id="bbcBox_message"></div>';
		
	
		// What about smileys?
		if (!empty($context['smileys']['postform']) || !empty($context['smileys']['popup']))
			echo '
					<div id="smileyBox_message"></div>';
	
		
		echo '
					', template_control_richedit($context['post_box_name'], 'smileyBox_message', 'bbcBox_message');

	}		
	

	echo'
				</td>
			</tr>
			<tr>
				<td style="width: 30%;">
					<strong>'.$txt['titulo'].' '.$txt['adk_admin_pages_in'].':</strong>
				</td>
				<td style="width: 70%;">
					<select name="cattitlebg">
						<option value="catbg">Catbg</option>
						<option value="titlebg">Titlebg</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>
					<strong>'.$txt['adk_admin_pages_body'].' '.$txt['adk_admin_pages_in'].':</strong>
				</td>
				<td style="width: 70%;">
					<select name="winbg">
						<option value="windowbg">Windowbg</option>
						<option value="windowbg2">Windowbg2</option>
					</select>
				</td>
			</tr>
		</table>
		<table style="width:100%;">
			<tr>
				<td style="width:100%; text-align: center;">
				<br /><br />
				<input type="hidden" name="sc" value="', $context['session_id'], '" />
				<input type="submit" value="'.$txt['adk_admin_pages_save'].'" />
				</td>
			</tr>
		</table>
		<span class="botslice"><span></span></span></div>
	</form>
	';




	ILoveAdkPortal();


}

function template_editpages()
{


	global  $scripturl, $context, $txt, $adkportal, $boardurl;

	
	echo'
	<form method="post" action="'. $scripturl .'?action=admin;area=modules;sa=saveeditpages">';
	
	echo'
		<div class="cat_bar"><h3 class="catbg">'.$txt['adk_admin_pages_new'].'</h3></div>
		<div class="windowbg2"><span class="topslice"><span></span></span>
		<table style="width:100%;">
			<tr>
				<td style="width: 30%;">
					<strong>'.$txt['titulo'].':</strong><br />
				</td>
				<td style="width: 70%;">
					<input type="text" value="'.$context['edit_admin_page']['titlepage'].'" name="titlepage" size="30" /><br />
				</td>
			</tr>
			<tr>
				<td style="width: 30%;">
				<strong>'.$txt['adk_admin_pages_url'].':</strong><div class="smalltext">'.$txt['adk_admin_pages_minusculas'].'</div><br />
				</td>
				<td style="width: 70%;">
					<div class="smalltext">http://tuforo.com/index.php?page= <input type="text" value="'.$context['edit_admin_page']['urltext'].'" name="urltext" size="30" /></div><br />
				</td>
			</tr>
			<tr>
				<td style="width: 30%;">
				<strong>'.$txt['adk_pages_enable_left'].'</strong><br /><br />
				</td>
				<td style="width: 70%;">
					'.$txt['adk_pages_yes'].'<input type="radio" name="enableleft" value="1" ',$context['edit_admin_page']['enableleft'] == 1 ? 'checked="checked"' : '' ,' /> '.$txt['adk_pages_no'].'<input type="radio" name="enableleft" value="0" ',$context['edit_admin_page']['enableleft'] != 1 ? 'checked="checked"' : '' ,'  /><br /><br />
				</td>
			</tr>
			<tr>
				<td style="width: 30%;">
				<strong>'.$txt['adk_pages_enable_right'].'</strong><br /><br />
				</td>
				<td style="width: 70%;">
					'.$txt['adk_pages_yes'].'<input type="radio" name="enableright" value="1" ',$context['edit_admin_page']['enableright'] == 1 ? 'checked="checked"' : '' ,'  /> '.$txt['adk_pages_no'].'<input type="radio" name="enableright" value="0" ',$context['edit_admin_page']['enableright'] != 1 ? 'checked="checked"' : '' ,'  /><br /><br />
				</td>
			</tr>
			<tr>
				<td style="width: 30%;" valign="top">
					<strong>'.$txt['adk_admin_pages_groups_allowed'].'</strong><br />
				</td>
				<td style="width: 70%;">';
				
					load_membergroups_edit($context['edit_admin_page']['grupos_permitidos']);
	echo'		
				<i>'.$txt['check_all'].'</i> <input type="checkbox" onclick="invertAll(this, this.form, \'groups_allowed\');"',!empty($context['all_checked']) ? ' checked="checked"' : '' ,' /><br />
				<br /><br />
				</td>
			</tr>
			<tr>
				<td style="width: 30%;">
					<strong>'.$txt['adk_admin_pages_type'].':</strong><br />
				</td>
				<td style="width: 70%;">
					PHP<input type="radio" name="type" value="php" ',$context['edit_admin_page']['type'] == 'php' ? 'checked="checked"' : '' ,' /> Html<input type="radio" name="type" value="html" ',$context['edit_admin_page']['type'] == 'html' ? 'checked="checked"' : '' ,' /> BBC<input type="radio" name="type" value="bbc" ',$context['edit_admin_page']['type'] == 'bbc' ? 'checked="checked"' : '' ,' /><br />
				</td>
			</tr>
			<tr>
				<td style="width: 30%;">
					<strong>'.$txt['adk_admin_pages_body'].'</strong>
				</td>
				<td style="width: 70%;">';

	if (!function_exists('getLanguages'))
	{
		// Showing BBC?
		if ($context['show_bbc'])
			template_control_richedit($context['post_box_name'], 'bbc');
		
	
		// What about smileys?
		if (!empty($context['smileys']['postform']))
			template_control_richedit($context['post_box_name'], 'smileys');
	
		// Show BBC buttons, smileys and textbox.
		template_control_richedit($context['post_box_name'], 'message');
	}
	else 
	{
		
		if ($context['show_bbc'])
			echo '
					<div id="bbcBox_message"></div>';
		
	
		// What about smileys?
		if (!empty($context['smileys']['postform']) || !empty($context['smileys']['popup']))
			echo '
					<div id="smileyBox_message"></div>';
	
		
		echo '
					', template_control_richedit($context['post_box_name'], 'smileyBox_message', 'bbcBox_message');

	}		
	

	echo'
				</td>
			</tr>
			<tr>
				<td style="width: 30%;">
					<strong>'.$txt['titulo'].' '.$txt['adk_admin_pages_in'].':</strong>
				</td>
				<td style="width: 70%;">
					<select name="cattitlebg">
						<option value="catbg" ',$context['edit_admin_page']['cattitlebg'] == 'catbg' ? 'selected="selected"' : '' ,'>Catbg</option>
						<option value="titlebg" ',$context['edit_admin_page']['cattitlebg'] == 'titlebg' ? 'selected="selected"' : '' ,'>Titlebg</option>
					</select>
				</td>
			</tr>
			<tr>
				<td style="width: 30%;">
					<strong>'.$txt['adk_admin_pages_body'].' '.$txt['adk_admin_pages_in'].':</strong>
				</td>
				<td style="width: 70%;">
					<select name="winbg">
						<option value="windowbg" ',$context['edit_admin_page']['winbg'] == 'windowbg' ? 'selected="selected"' : '' ,'>Windowbg</option>
						<option value="windowbg2" ',$context['edit_admin_page']['winbg'] == 'windowbg2' ? 'selected="selected"' : '' ,'>Windowbg2</option>
					</select>
				</td>
			</tr>
		</table>
		<table style="width:100%;">
			<tr>
				<td style="width:100%; text-align: center;">
				<br /><br />
				<input type="hidden" name="sc" value="', $context['session_id'], '" />
				<input type="submit" value="'.$txt['adk_admin_pages_save'].'" />
				<input type="hidden" value="'.$context['edit_admin_page']['id_page'].'" name="id_page" />
				</td>
			</tr>
		</table>
		<span class="botslice"><span></span></span></div>
	</form>
	';
	
	ILoveAdkPortal();
}

function template_adk_new_image()
{
	global  $scripturl, $context, $txt, $adkportal, $boardurl;

	
	echo'
	<form method="post" enctype="multipart/form-data" action="'. $scripturl .'?action=admin;area=modules;sa=saveuploadimg">';
	
	echo'
	<div class="cat_bar"><h3 class="catbg">
		'.$txt['advanced_block_images'].'
	</h3></div>
		<table style="width: 100%;" cellspacing="0">
			<tr class="titlebg">
				<td colspan="4">
					'.$txt['adk_select_a_format'].'
				</td>
			</tr>
			<tr class="windowbg2">
				<td valign="top" style="width: 25%;" colspan="4">
					'.$txt['adk_nonone'].'<input type="radio" name="format" value="1" /><br />
				</td>
			</tr>
			<tr class="windowbg2">
				<td valign="top" style="width: 25%;">
					<input type="radio" name="format" value="2" checked="checked" /><br />
					<img src="http://www.smfpersonal.net/imagen-adkportal/demo1.jpg" alt="" style="width: 130px;" />
				</td>
				
				
				<td valign="top" style="width: 25%;">
					<input type="radio" name="format" value="4" /><br />
					<img src="http://www.smfpersonal.net/imagen-adkportal/demo3.png" alt="" style="width: 130px;" />
				</td>
				<td valign="top" style="width: 25%;">
					<input type="radio" name="format" value="5" /><br />
					<img src="http://www.smfpersonal.net/imagen-adkportal/demo4.png" alt="" style="width: 130px;" />
				</td>
				<td valign="top" style="width: 25%;">
					<input type="radio" name="format" value="8" /><br />
					<img src="http://www.smfpersonal.net/imagen-adkportal/view.php.png" alt="" style="width: 130px;" />
				</td>';
				
	echo'			
			</tr>
			<tr class="windowbg2">
				<td colspan="4">
				<br />
				</td>
			</tr>
		</table>
		<table style="width: 100%;" cellspacing="0">
			<tr class="titlebg">
				<td colspan="2">
					'.$txt['opcion_adk'].'
				</td>
			</tr>
			<tr class="windowbg2">
				<td>
					<strong>'.$txt['adk_any_url'].':</strong>
				</td>
				<td>
					<input type="text" name="url" value="http://" />
				</td>
			</tr>
			<tr class="windowbg2">
				<td>
					<strong>'.$txt['a_select_image'].'</strong>
				</td>
				<td>
					<input type="file" name="image" />
				</td>
			</tr>
			<tr class="windowbg2">
				<td>
					<strong>'.$txt['adk_select_maybe_image_url'].'</strong>
				</td>
				<td>
					<input type="text" name="image2" value="" />
				</td>
			</tr>
			<tr class="windowbg2">
				<td>
					<strong>'.$txt['adk_water_mark'].'</strong>
				</td>
				<td>
					<input type="text" name="wm" value="',$context['forum_name'],'" />
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<div class="information">
					<input type="submit" value="'.$txt['save'].'" />
					<input type="hidden" name="sc" value="'.$context['session_id'].'" />
					</div>
				</td>
			</tr>
			
		</table>
	</form>
		';
		
				
				
	ILoveAdkPortal();


}

function template_manages_images()
{
	global  $scripturl, $context, $txt, $adkportal, $boardurl;

	
	echo'
	<form method="post" action="'. $scripturl .'?action=admin;area=modules;sa=savesettingsimagesadk">';
	
	echo'
	<table style="width: 100%;" cellspacing="1">
		<tr>
			<td colspan="2">
				<div class="cat_bar"><h3 class="catbg">'.$txt['adk_opcion_yeahhhh'].'</h3></div>
			</td>
		</tr>
		<tr class="windowbg">
			<td>
				<strong>'.$txt['adk_cantidad_images'].'</strong>
			</td>
			<td>
				<input type="text" size="2" value="'.$adkportal['adv_top_image_limit'].'" name="cantidad" />
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<div class="information">
					<input type="submit" value="'.$txt['save'].'" />
					<input type="hidden" name="sc" value="'.$context['session_id'].'" />
				</div>
			</td>
		</tr>
	</table>
	</form><br />';
		
		
	
	$i = 0;
	echo'
	<div class="windowbg">
		<table align="center" style="width: 100%;" cellspacing="0">
			<tr>';
	
	foreach($context['load_img'] AS $img)
	{
		if($i == 3)
		{
			echo'</tr><tr><td colspan="3"><br /></td></tr><tr>';
			$i = 0;
		}
			
			echo'
			<td style="width: 33%;" align="center">
				<a href="'.$img['url'].'">
					<img src="'.$img['image'].'" alt="" style="width: 177px;" />
				</a><br />
				<a  onclick="return confirm(\''.$txt['adk_delete'].'?\');" href="'.$scripturl.'?action=admin;area=modules;sa=deleteimagesadk;id='.$img['id'].';url2='.$img['image'].';'.$context['session_var'].'='.$context['session_id'].'" title="'.$txt['adk_delete'].'">
					<img src="'.$boardurl.'/adkportal/images/cancel.png" alt="'.$txt['adk_delete'].'" title="'.$txt['adk_delete'].'" />
				</a>
			</td>';
		
		$i++;
		
	}
	
	echo'<td colspan="3"></td>
			</tr>
		</table>
	</div>
	<br />
	<div class="smalltext" align="right">
		'.$txt['adk_admin_pages'].': '.$context['page_index'].'
	</div>
	';
	ILoveAdkPortal();			
}		
	
function template_contact_admin()
{
	global  $scripturl, $context, $txt, $adkportal, $boardurl;
	
	$toview = array();
	
	if(!empty($adkportal['adk_groups_contact']))
		$toview = explode(',',$adkportal['adk_groups_contact']);
	
	echo'
	<form method="post" action="'. $scripturl .'?action=admin;area=modules;sa=save_contact">';
	
	echo'
	<div class="cat_bar">
		<h3 class="catbg">
			<img alt="" src="'.$boardurl.'/adkportal/images/newmsg.png" style="vertical-align: middle;" />&nbsp;',$txt['adk_settings'],'
		</h3>
	</div>
	<div class="windowbg"><span class="topslice"><span></span></span>
		<div class="content">
			<table style="width: 100%;">
				<tr>
					<td style="width: 50%; text-align: right; font-weight:bold;">
						',$txt['adk_enable_contact'],'
					</td>
					<td style="width: 50%; text-align: left;">
						<input type="checkbox" name="adk_enable_contact"',!empty($adkportal['adk_enable_contact']) ? ' checked="checked"' : '' ,' />
					</td>
				</tr>
				<tr>
					<td style="width: 50%; text-align: right; font-weight:bold;">
						',$txt['adk_mail_contact'],'
					</td>
					<td style="width: 50%; text-align: left;">';
			
			foreach($context['groups'] AS $i => $v)
						echo'
						<input type="checkbox" name="toview['.$i.']"',isset($toview) && in_array($i,$toview) ? ' checked="checked"' : '' ,' />'.$v.'<br />';
	
	echo'
					</td>
				</tr>
			</table><br />
			<div align="center">
				<input type="submit" value="',$txt['save'],'" class="button_submit" />
				<input type="hidden" name="sc" value="',$context['session_id'],'" />
			</div>
		</div>
	<span class="botslice"><span></span></span></div>
	</form>';
	
	ILoveAdkPortal();	

}
	


?>